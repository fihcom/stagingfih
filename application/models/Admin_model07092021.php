<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    function getSiteSettings(){
        $this->db->select("*");
        $this->db->from(TABLE_PREFIX.'site_settings');
        //$this->db->where('site_id', $siteID);
        $Query = $this->db->get();
        $Array = $Query->row_array();
        return $Array;
    }

    function getCurrencies($currencyId = 0){
        $this->db->select("id, country, currency, code, symbol", FALSE);
        $this->db->from(TABLE_PREFIX.'currencies');
        if($currencyId>0)
        {
            $this->db->where('id', $currencyId);
        }
        $Query = $this->db->get();
        $Array = $Query->result_array();
        return $Array;
    }

    function getsellrequest($searchArr,$sort){
        $partSql = "";
        if($searchArr['requestId']>0)
        {
            $id = $searchArr['requestId'];
            $partSql .= " and S.id=$id";
        }
        if($searchArr['searchValue'] !='')
        {
            $partSql .= " and (U.fname LIKE '%".$searchArr['searchValue']."%' || U.lname LIKE '%".$searchArr['searchValue']."%' || U.mail LIKE '%".$searchArr['searchValue']."%' || U.phone LIKE '%".$searchArr['searchValue']."%' || S.listing_id LIKE '%".$searchArr['searchValue']."%' || S.data_json LIKE '%".$searchArr['searchValue']."%') ";
        }
        if($searchArr['searchStatus'] !='')
        {
            $partSql .= " and S.Status='".$searchArr['searchStatus']."'";
        }

        $sortarr = ['1'=>'U.fname','2'=>'U.mail','3'=>'S.listing_id','6'=>'S.paid_amount','7'=>'S.last_updated'];
        
        if(count($sort)>0)
        {
            $sortsql = 'order by '. $sortarr[$sort['column']].' '.$sort['dir'];
        }else{
            $sortsql = 'order by S.last_updated desc';
        }

        $q = "select SQL_CALC_FOUND_ROWS S.id,S.userId,S.data_json,S.paid_amount,S.listing_id,CONCAT(U.fname,' ',U.lname) as clientName,U.fname,U.mail,U.phone,S.last_updated,S.Status  from 
        ".TABLE_PREFIX."sell_business_temp as S 
        join ".TABLE_PREFIX."users as U on U.userId=S.userId
        where S.Status>0 and S.type='SELL' and U.Status=1 $partSql ".$sortsql." limit ".$searchArr['start'].",".$searchArr['limit']."";

        $query = $this->db->query($q);    
        $sellrequests = $query->result_array();  
        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
        $sitesettings = $this->getSiteSettings();
        $currency = $this->getCurrencies($sitesettings['currency']);
        return array("totalrecord"=>$totalrecord,"sellrequests"=>$sellrequests,'currency'=>$currency);
    }

    function getvaluationrequest($searchArr,$sort){
        $partSql = "";
        if($searchArr['requestId']>0)
        {
            $id = $searchArr['requestId'];
            $partSql .= " and S.id=$id";
        }
        if($searchArr['searchValue'] !='')
        {
            $partSql .= " and (U.fname LIKE '%".$searchArr['searchValue']."%' || U.lname LIKE '%".$searchArr['searchValue']."%' || U.mail LIKE '%".$searchArr['searchValue']."%' || U.phone LIKE '%".$searchArr['searchValue']."%' || S.listing_id LIKE '%".$searchArr['searchValue']."%' || S.data_json LIKE '%".$searchArr['searchValue']."%') ";
        }
        if($searchArr['searchStatus'] !='')
        {
            $partSql .= " and S.Status='".$searchArr['searchStatus']."'";
        }

        $sortarr = ['1'=>'U.fname','2'=>'U.mail','3'=>'U.phone','6'=>'S.last_updated'];
        
        if(count($sort)>0)
        {
            $sortsql = 'order by '. $sortarr[$sort['column']].' '.$sort['dir'];
        }else{
            $sortsql = 'order by S.last_updated desc';
        }

        $q = "select SQL_CALC_FOUND_ROWS S.id,S.userId,S.valuation_json,S.data_json,S.paid_amount,S.listing_id,CONCAT(U.fname,' ',U.lname) as clientName,U.fname,U.mail,U.phone,S.last_updated,S.Status  from 
        ".TABLE_PREFIX."sell_business_temp as S 
        join ".TABLE_PREFIX."users as U on U.userId=S.userId
        where S.Status>0 and S.type='VALUATION' and U.Status=1 $partSql ".$sortsql." limit ".$searchArr['start'].",".$searchArr['limit']."";

        $query = $this->db->query($q);    
        $valuationListing = $query->result_array(); 
        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
        if(is_array($valuationListing) && count($valuationListing)>0)
        {
            $i = 0;
            foreach($valuationListing as $val)
            {
                $valuationListing[$i]['dataArr'] = json_decode($val['data_json'],true);
                $valuationListing[$i]['valuationArr'] = json_decode($val['valuation_json'],true);
                $monetization = $valuationListing[$i]['dataArr']['monetization'];

                $this->db->select('name', FALSE);
                $this->db->from(TABLE_PREFIX.'monetization', FALSE);
                $this->db->where('slug', $monetization);  
                $this->db->where('area', 'VALUATION');     
                $this->db->where('Status', '1');   
                $Query = $this->db->get();
                $monetizationRec = $Query->row();
                $valuationListing[$i]['monetizationRec'] = $monetizationRec->name;
                $i++;
            }
        }
        $sitesettings = $this->getSiteSettings();
        $currency = $this->getCurrencies($sitesettings['currency']);
        return array("totalrecord"=>$totalrecord,"sellrequests"=>$valuationListing,'currency'=>$currency);
    }

    function updateSellRequest($editArray,$id)
    {
        $this->db->where('id', $id);
        $this->db->update(TABLE_PREFIX.'sell_business_temp', $editArray);
    }
    function updateApprovedSell($editArray,$id)
    {
        $this->db->where('id', $id);
        $this->db->update(TABLE_PREFIX.'sell_record', $editArray);
    }
    function getapprovedsell($searchArr,$sort=[]){
        $partSql = "";
        if($searchArr['requestId']>0)
        {
            $id = $searchArr['requestId'];
            $partSql = " and S.id=$id";
        }
        if($searchArr['searchValue'] !='')
        {
            $partSql .= " and (U.fname LIKE '%".$searchArr['searchValue']."%' || U.lname LIKE '%".$searchArr['searchValue']."%' || U.mail LIKE '%".$searchArr['searchValue']."%' || U.phone LIKE '%".$searchArr['searchValue']."%' || S.listing_id LIKE '%".$searchArr['searchValue']."%' || S.data_json LIKE '%".$searchArr['searchValue']."%') ";
        }
        if($searchArr['searchStatus'] !='')
        {
            $partSql .= " and SR.Status='".$searchArr['searchStatus']."'";
        }
        $sortarr = ['0'=>'U.fname','1'=>'U.mail','2'=>'U.phone','3'=>'S.listing_id','6'=>'S.last_updated'];
        
        if(count($sort)>0)
        {
            $sortsql = 'order by '. $sortarr[$sort['column']].' '.$sort['dir'];
        }else{
            $sortsql = 'order by S.last_updated desc';
        }
        $q = "select SQL_CALC_FOUND_ROWS S.id,S.sell_answers_status,S.userId,S.data_json,S.listing_id,CONCAT(U.fname,' ',U.lname) as clientName,U.mail,U.phone,SR.date_added as last_updated,SR.Status,SR.id as approvedid,SR.show_home from 
        ".TABLE_PREFIX."sell_business_temp as S 
        join ".TABLE_PREFIX."sell_record as SR on SR.userId=S.userId and SR.listing_temp_id=S.id and SR.listing_id=S.listing_id
        join ".TABLE_PREFIX."users as U on U.userId=S.userId
        where U.Status<>2 $partSql ".$sortsql." limit ".$searchArr['start'].",".$searchArr['limit']."";
        $query = $this->db->query($q);    
        $sellrequests = $query->result_array();  
        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
 
        return array("totalrecord"=>$totalrecord,"sellrequests"=>$sellrequests);
    }

    function getquestionanswers($listingId)
    {
        $q = "select S.id,S.sell_answers_status,S.sell_answers from 
        ".TABLE_PREFIX."sell_business_temp as S 
        where S.Status<>0 and S.sell_answers_status=1 and S.listing_id=$listingId";
        $query = $this->db->query($q);    
        $qa = $query->row();
        return $qa;

    }
    function gettempselldata($id){
        $this->db->select('*', FALSE);
        $this->db->from(TABLE_PREFIX.'sell_business_temp', FALSE);
        $this->db->where('id', $id);    
        $this->db->where('Status <>', 0);  
        $this->db->limit(1);      
        $Query = $this->db->get();
        $sellrec = $Query->row();
        return $sellrec;
    }
    function getapprovedselldata($id,$fields=''){
        if(count($fields)>0)
        {
            $this->db->select($fields, FALSE);
        }else{
            $this->db->select('*', FALSE);
        }
        
        $this->db->from(TABLE_PREFIX.'sell_record', FALSE);
        $this->db->where('listing_temp_id', $id);    
        $this->db->where('Status <>', 0);  
        $this->db->limit(1);      
        $Query = $this->db->get();
        $sellrec = $Query->row();
        return $sellrec;
    }
    function getUserDetails($userId)
    {
        $this->db->select('BaseTbl.*', FALSE);
        $this->db->from(TABLE_PREFIX.'users as BaseTbl', FALSE);
        $this->db->where('BaseTbl.Status !=', 0);
        $this->db->where('BaseTbl.userId', $userId);
        $query = $this->db->get();        
        $user = $query->row();
        if(!empty($user)){
            return $user;
        } else {
            return null;
        }
    }
    function addcommission($arr,$action){
        if($action == 'add')
        {
            $this->db->insert(TABLE_PREFIX.'commission_history', $arr);
            return $this->db->insert_id();
        }elseif($action == 'edit')
        {
            $this->db->where('id', $arr['id']);
            unset($arr['id']);
            $this->db->update(TABLE_PREFIX.'commission_history', $arr);
        }
        
    }

    function addasset($arr,$action){
        if($action == 'add')
        {
            $this->db->insert(TABLE_PREFIX.'common_list_assets', $arr);
            return $this->db->insert_id();
        }elseif($action == 'edit')
        {
            $this->db->where('id', $arr['id']);
            unset($arr['id']);
            $this->db->update(TABLE_PREFIX.'common_list_assets', $arr);
        }
        
    }
    function listassets($spec){
        
        $this->db->select("*");
        $this->db->from(TABLE_PREFIX.'common_list_assets');
        if($spec == 'active')
        {
            $this->db->where('Status', 1);
        }else{
            $this->db->where('Status <>', 2);
        }
        
        $Query = $this->db->get();
        $Array = $Query->result_array();  
        return $Array;
    }

    function deleteasset($galId){
        $this->db->where('id', $galId);
        $arr['Status'] = 2;
        $this->db->update(TABLE_PREFIX.'common_list_assets', $arr);
    }
     function addindustry($arr,$action){
        if($action == 'add')
        {
            $this->db->insert(TABLE_PREFIX.'industries', $arr);
            return $this->db->insert_id();
        }elseif($action == 'edit')
        {
            $this->db->where('id', $arr['id']);
            unset($arr['id']);
            $this->db->update(TABLE_PREFIX.'industries', $arr);
        }
        
    }
    function listindustry($spec){
        
        $this->db->select("*");
        $this->db->from(TABLE_PREFIX.'industries');
        if($spec == 'active')
        {
            $this->db->where('status', 1);
        }else{
            $this->db->where('status <>', 2);
        }
        
        $Query = $this->db->get();
        $Array = $Query->result_array();  
        return $Array;
    }

    function deleteindustry($galId){
        $this->db->where('id', $galId);
        $arr['Status'] = 2;
        $this->db->update(TABLE_PREFIX.'industries', $arr);
    }

    function addaltersale($Arr,$action)
    {
        if($action == 'add')
        {
            $this->db->insert(TABLE_PREFIX.'sell_record', $Arr);
            return $this->db->insert_id();
        }elseif($action == 'edit')
        {
            $this->db->where('id', $Arr['id']);
            unset($Arr['id']);
            $this->db->update(TABLE_PREFIX.'sell_record', $Arr);
        }
    }

    function listcommission($spec){
        
        $this->db->select("*");
        $this->db->from(TABLE_PREFIX.'commission_history');
        $this->db->where('status', 1);
        $Query = $this->db->get();
        $Array = $Query->result_array();  
        return $Array;
    }
    function deletecommission($Id){
        $this->db->where('id', $Id);
        $arr['Status'] = 2;
        $this->db->update(TABLE_PREFIX.'commission_history', $arr);
    }

    function addmonetization($arr,$action){
        if($action == 'add')
        {
            $this->db->insert(TABLE_PREFIX.'monetization', $arr);
            return $this->db->insert_id();
        }elseif($action == 'edit')
        {
            $this->db->where('id', $arr['id']);
            unset($arr['id']);
            $this->db->update(TABLE_PREFIX.'monetization', $arr);
        }
        
    }
    function listmonetization($spec){
        
        $this->db->select("*");
        $this->db->from(TABLE_PREFIX.'monetization');
        $this->db->where('area', 'SELL');
        if($spec == 'active')
        {
            $this->db->where('Status', 1);
        }else{
            $this->db->where('Status <>', 2);
        }
        
        $Query = $this->db->get();
        $Array = $Query->result_array();  
        return $Array;
    }

    function deletemonetization($galId){
        $this->db->where('id', $galId);
        $arr['Status'] = 2;
        $this->db->update(TABLE_PREFIX.'monetization', $arr);
    }

    function listcountry($id=0){
        $this->db->select("*");
        $this->db->from(TABLE_PREFIX.'countries');
        if($id >0)
        {
            $this->db->where('id', $id);
        }
        $Query = $this->db->get();
        $Array = $Query->result_array();  
        return $Array;
    }
    function change_pass($session_id,$new_pass)
    {
        $this->db->where('userId', $session_id);
        $editArray=array('password'=>password_hash($new_pass, PASSWORD_DEFAULT));
        $this->db->update(TABLE_PREFIX.'users', $editArray);
    }

    function getpenndingidentity($searchArr,$sort){
        $partSql = "";
        if($searchArr['searchValue']!='')
        {
            $searchval = $searchArr['searchValue'];
            $partSql = " and (U.fname like '%$searchval%' || U.lname like '%$searchval%' || U.phone like '%$searchval%' )";
        }
        $sortarr = ['1'=>'U.fname','3'=>'U.mail','2'=>'U.phone','4'=>'S.identity_proof_submit_date'];
        
        if(count($sort)>0)
        {
            $sortsql = 'order by '. $sortarr[$sort['column']].' '.$sort['dir'];
        }else{
            $sortsql = 'order by S.identity_proof_submit_date desc';
        }

        $q = "select SQL_CALC_FOUND_ROWS U.fname, U.lname,U.mail,U.phone,U.Status,S.identity_proof_submit_date,S.identity_proof_status,U.userId from 
        ".TABLE_PREFIX."user_details as S 
        join ".TABLE_PREFIX."users as U on U.userId=S.userId
        where U.Status=1 and S.identity_proof_status=2 $partSql ".$sortsql." limit ".$searchArr['start'].",".$searchArr['limit']."";
        $query = $this->db->query($q);    
        $pendingidentity = $query->result_array();  
        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
 
        return array("totalrecord"=>$totalrecord,"pendingidentity"=>$pendingidentity);
    }

    function getpenndingfundproof($searchArr,$sort){
        $partSql = "";
        if($searchArr['searchValue']!='')
        {
            $searchval = $searchArr['searchValue'];
            $partSql = " and (U.fname like '%$searchval%' || U.phone like '%$searchval%' )";
        }
        $sortarr = ['1'=>'U.fname','3'=>'U.mail','2'=>'U.phone','4'=>'S.fund_proof_submit_date'];
        
        if(count($sort)>0)
        {
            $sortsql = 'order by '. $sortarr[$sort['column']].' '.$sort['dir'];
        }else{
            $sortsql = 'order by S.fund_proof_submit_date desc';
        }
        $q = "select SQL_CALC_FOUND_ROWS U.fname,U.lname,U.phone,U.mail,U.Status,S.fund_proof_submit_date,S.proof_fund_status,U.userId from 
        ".TABLE_PREFIX."user_details as S 
        join ".TABLE_PREFIX."users as U on U.userId=S.userId
        where U.Status=1 and S.proof_fund_status=2 $partSql ".$sortsql." limit ".$searchArr['start'].",".$searchArr['limit']."";
        $query = $this->db->query($q);    
        $pendingfund = $query->result_array();  
        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
 
        return array("totalrecord"=>$totalrecord,"pendingfund"=>$pendingfund);
    }

    function getusers($searchArr,$sort){
        $partSql = "";
        //$searchArr['start'] = 0;
        //$searchArr['limit'] = 10;
        if($searchArr['searchValue']!='')
        {
            $searchval = $searchArr['searchValue'];
            $partSql = " and (U.fname like '%$searchval%' || U.lname like '%$searchval%' || U.phone like '%$searchval%' || U.mail like '%$searchval%' )";
        }
        $sortarr = ['1'=>'U.fname','3'=>'U.mail','2'=>'U.phone','4'=>'U.added_on'];
        
        if(count($sort)>0)
        {
            $sortsql = 'order by '. $sortarr[$sort['column']].' '.$sort['dir'];
        }else{
            $sortsql = 'order by U.Added_on desc';
        }

        $q = "select SQL_CALC_FOUND_ROWS U.*,UD.proof_fund_status,UD.identity_proof_status from 
        ".TABLE_PREFIX."users as U
        left join ".TABLE_PREFIX."user_details as UD ON UD.userId=U.userId
        where U.role='user' $partSql ".$sortsql." limit ".$searchArr['start'].",".$searchArr['limit']."";
        $query = $this->db->query($q);    
        $pendingfund = $query->result_array();  
        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
 
        return array("totalrecord"=>$totalrecord,"users"=>$pendingfund);
    
    }
    function getsubadmin($searchArr,$sort=[]){
        $partSql = "";
        //$searchArr['start'] = 0;
        //$searchArr['limit'] = 10;
        $sortarr = ['1'=>'fname','2'=>'mail','3'=>'added_on'];
        if($searchArr['searchValue']!='')
        {
            $searchval = $searchArr['searchValue'];
            $partSql = " and (U.fname like '%$searchval%' || U.lname like '%$searchval%' || U.phone like '%$searchval%' || U.mail like '%$searchval%' )";
        }
        if(count($sort)>0)
        {
            $sortsql = 'order by U.'. $sortarr[$sort['column']].' '.$sort['dir'];
        }else{
            $sortsql = 'order by U.Added_on desc';
        }
        $q = "select SQL_CALC_FOUND_ROWS U.* from 
        ".TABLE_PREFIX."users as U
        where U.role='subadmin' and U.Status=1 $partSql $sortsql  limit ".$searchArr['start'].",".$searchArr['limit']."";
        $query = $this->db->query($q);    
        $pendingfund = $query->result_array();  
        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
 
        return array("totalrecord"=>$totalrecord,"users"=>$pendingfund);
    
    }

    function getuserprofile($user)
    {
        $this->db->select('U.userId as user_id,U.fname,U.lname,U.mail,U.google_analitics_email,U.secondary_phone,U.phone,U.dob,U.Status,UD.*', FALSE);
        $this->db->from(TABLE_PREFIX.'users U', FALSE);
        $this->db->join(TABLE_PREFIX.'user_details UD', 'U.userId = UD.userId','left');
        $this->db->where('U.userId', $user);   
        $Query = $this->db->get();
        $sellrec = $Query->row();
        return $sellrec;
    }
    function getfundhistory($userId,$assetToken){
        $this->db->select("*");
        $this->db->from(TABLE_PREFIX.'fund_history');
        $this->db->where('userId', $userId); 
        $this->db->where('asset_token', $assetToken);   
        $Query = $this->db->get();
        $Array = $Query->row();
        return $Array;
    }
    function setfundhistory($arrData){
		$this->db->insert(TABLE_PREFIX.'fund_history', $arrData);
    }
    function getofflinefundhistory($userId,$approvedate){
        $this->db->select("*");
        $this->db->from(TABLE_PREFIX.'fund_history');
        $this->db->where('userId', $userId); 
        $this->db->where('date_approved', $approvedate);   
        $this->db->order_by('id', 'desc');  
        $Query = $this->db->get();
        $Array = $Query->row();
        return $Array;
    }
    function updatefundapprovehistory($arr){
        $this->db->where('userId', $arr['userId']);
        $this->db->where('asset_token', $arr['asset_token']);
        unset($arr['userId']);
        unset($arr['asset_token']);
        
        $this->db->update(TABLE_PREFIX.'fund_history', $arr);
    }

    function investor_pass_history($arr){
        $this->db->insert(TABLE_PREFIX.'investor_pass_history', $arr);
        return $this->db->insert_id();
    }

    

    function getpendingfaq($arr,$sort)
    {
        if($arr['searchName']!='')
        {
            $partSql .= " and (u.fname like '%".$arr['searchName']."%' || u1.fname like '%".$arr['searchName']."%' || (u.lname like '%".$arr['searchName']."%' || u1.lname like '%".$arr['searchName']."%' || u.mail like '%".$arr['searchName']."%' || u1.mail like '%".$arr['searchName']."%' || f.listing_id like '%".$arr['searchName']."%' || f.question like '%".$arr['searchName']."%' || f.seller_reply like '%".$arr['searchName']."%')";
        }
        $sortarr = ['0'=>'f.listing_id','1'=>'u.fname','2'=>'u.mail','3'=>'f.question','4'=>'u1.fname','5'=>'u1.mail','6'=>'f.reply_date','7'=>'f.seller_reply'];
        
        if(count($sort)>0)
        {
            $sortsql = 'order by '. $sortarr[$sort['column']].' '.$sort['dir'];
        }else{
            $sortsql = 'order by S.last_updated desc';
        }
        $q = "select SQL_CALC_FOUND_ROWS f.*,sbt.id as tempid,CONCAT(u.fname,' ',u.lname) as buyername,u.userId as buyeruserId,u.mail as buyeremail,date_format(f.reply_date,'%D %b, %Y') as faqDate,CONCAT(u1.fname,' ',u1.lname) as sellername,u1.mail as selleremail,u1.userId as selleruserId from 
        ".TABLE_PREFIX."faq as f
        join ".TABLE_PREFIX."users as u on u.userId=f.userId
        join ".TABLE_PREFIX."sell_record as sr on sr.listing_id=f.listing_id
        left join ".TABLE_PREFIX."sell_business_temp as sbt on sbt.listing_id=f.listing_id
        join ".TABLE_PREFIX."users as u1 on u1.userId=sr.userId
        where (f.Status=2||f.Status=3)".$partSql." ".$sortsql." limit ".$arr['start'].",".$arr['limit']."";
        $query = $this->db->query($q);    
        $userDetails = $query->result_array();

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
        return array('record'=>$userDetails,'totalrecord'=>$totalrecord, 'query'=>$q);
    }

    function getfaqdetails($faqid){
        $q = "select f.*,u.userId as buyeruserID,CONCAT(u.fname,' ',u.lname) as buyername,u.mail as buyeremail,date_format(f.reply_date,'%D %b, %Y') as faqDate,u1.userId as selleruserID,CONCAT(u1.fname,' ',u1.lname) as sellername,u1.mail as selleremail from 
        ".TABLE_PREFIX."faq as f
        join ".TABLE_PREFIX."users as u on u.userId=f.userId
        join ".TABLE_PREFIX."sell_record as sr on sr.listing_id=f.listing_id
        join ".TABLE_PREFIX."users as u1 on u1.userId=sr.userId
        where (f.Status=2||f.Status=3) and f.id=$faqid";
        $query = $this->db->query($q);    
        $faqDetails = $query->row();
        return $faqDetails;
    }
    function getlistingoffers($arr,$sort)
    {
        $partSql = '';
        if($arr['searchByStatus']>0)
        {
            $partSql .= " and f.status=".$arr['searchByStatus'];
        }
        if($arr['searchName']!='')
        {
            $partSql .= " and (u.fname like '%".$arr['searchName']."%' || u.lname like '%".$arr['searchName']."%' || u.mail like '%".$arr['searchName']."%' || u1.fname like '%".$arr['searchName']."%' || u1.lname like '%".$arr['searchName']."%' || u1.mail like '%".$arr['searchName']."%' || f.offer_price like '%".$arr['searchName']."%' || f.offer_description like '%".$arr['searchName']."%' || f.listing_id like '%".$arr['searchName']."%')";
        }
        if($arr['id']>0)
        {
            $partSql .= " and f.id=".$arr['id'];
        }
        $sortarr = ['1'=>'u.fname','2'=>'u.mail','3'=>'f.offer_price','4'=>'u1.fname','5'=>'u1.mail','6'=>'f.listing_id','7'=>'f.offer_date'];
        
        if(count($sort)>0)
        {
            $sortsql = 'order by '. $sortarr[$sort['column']].' '.$sort['dir'];
        }else{
            $sortsql = 'order by f.offer_date desc';
        }
        $q = "select SQL_CALC_FOUND_ROWS f.*,sbt.id as tempid,CONCAT(u.fname,' ',u.lname) as buyername,u.mail as buyeremail,date_format(f.offer_date,'%D %b, %Y') as offerDate,CONCAT(u1.fname,' ',u1.lname) as sellername,u1.mail as selleremail from 
        ".TABLE_PREFIX."listing_offers as f
        join ".TABLE_PREFIX."users as u on u.userId=f.userId
        join ".TABLE_PREFIX."users as u1 on u1.userId=f.sellerId
        left join ".TABLE_PREFIX."sell_business_temp as sbt on sbt.userId=f.sellerId
        where f.id>0 ".$partSql." ".$sortsql." limit ".$arr['start'].",".$arr['limit']."";
        $query = $this->db->query($q);    
        $userDetails = $query->result_array();

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
        return array('record'=>$userDetails,'totalrecord'=>$totalrecord); 
    }

    function getlistingbuycommission($arr)
    {
        $partSql = '';
        if($arr['searchByStatus']>0)
        {
            $partSql .= " and f.status=".$arr['searchByStatus'];
        }
        if($arr['searchName']!='')
        {
            $partSql .= " and (u1.fname like '%".$arr['searchName']."%' || f.transaction_ref like '%".$arr['searchName']."%' || f.description like '%".$arr['searchName']."%' || f.listing_id like '%".$arr['searchName']."%')";
        }
        if($arr['dateFrom']!='')
        {
            $partSql .= " and f.sold_date>='".$arr['dateFrom']."'";
        }else{
            $currentMonthFrom = date('Y-m').'-01';

            $partSql .= " and f.sold_date>=DATE_SUB( NOW() , INTERVAL 6 MONTH )";
        }
        if($arr['dateTo']!='')
        {
            $partSql .= " and f.sold_date<='".$arr['dateTo']." 23:59:59'";
        }else{
            $currentMonthFrom = date('Y-m-d').' 23:59:59';
            $partSql .= " and f.sold_date<='".$currentMonthFrom."'";
        }

        if($arr['id']>0)
        {
            $partSql .= " and f.id=".$arr['id'];
        }

        if($arr['buyStatus'] != '')
        {
            $partSql .= " and f.buy_amt_stranfer_status=".$arr['buyStatus'];
        }
        $section = $arr['section'];
        $q = "select SQL_CALC_FOUND_ROWS f.*,date_format(f.date_added,'%D %b, %Y') as buyDate,f.sold_date,u1.fname as sellername,u1.mail as selleremail,u1.userId as selleruserId,sr.price,S.id as listingref from 
        ".TABLE_PREFIX."buy_request as f
        join ".TABLE_PREFIX."sell_business_temp as S ON S.listing_id= f.listing_id
        join ".TABLE_PREFIX."sell_record as sr on sr.listing_id=f.listing_id
        join ".TABLE_PREFIX."users as u1 on u1.userId=f.sellerId
        ".$joinSql."
        where f.id>0 and f.status=2 and f.transfer_status=4 and f.section='".$section."' ".$partSql." order by f.date_added desc limit ".$arr['start'].",".$arr['limit']."";
        $query = $this->db->query($q);    
        $userDetails = $query->result_array();

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
        
        return array('record'=>$userDetails,'totalrecord'=>$totalrecord);
    }

    function getlistingbuyreq($arr,$sort=[])
    {
        $partSql = '';
        if($arr['searchByStatus']>0)
        {
            $partSql .= " and f.status=".$arr['searchByStatus'];
        }
        if($arr['searchName']!='')
        {
            $partSql .= " and (u.fname like '%".$arr['searchName']."%' || u1.fname like '%".$arr['searchName']."%' || (u.lname like '%".$arr['searchName']."%' || u1.lname like '%".$arr['searchName']."%' || f.transaction_ref like '%".$arr['searchName']."%' || f.description like '%".$arr['searchName']."%' || f.listing_id like '%".$arr['searchName']."%')";
        }
        if($arr['id']>0)
        {
            $partSql .= " and f.id=".$arr['id'];
        }
        if($arr['searchBySellType'] == 1)
        {
            $joinSql = " join ".TABLE_PREFIX."listing_offers as lo on f.sellerId=lo.sellerId and f.userId=lo.userId and f.listing_id=lo.listing_id";
            $partSql .= " and lo.status=2";
        }if($arr['searchBySellType'] == 2)
        {
            $joinSql = " left join ".TABLE_PREFIX."listing_offers as lo on f.sellerId=lo.sellerId and f.userId=lo.userId and f.listing_id=lo.listing_id and lo.status=2";
            $partSql .= " and lo.id IS NULL";
        }
        $section = $arr['section'];
        $sortarr = ['0'=>'f.transaction_ref','1'=>'u1.mail','2'=>'f.date_added','5'=>'sr.price'];
        
        if(count($sort)>0)
        {
            $sortsql = 'order by '. $sortarr[$sort['column']].' '.$sort['dir'];
        }else{
            $sortsql = 'order by f.date_added desc';
        }

        $q = "select SQL_CALC_FOUND_ROWS f.*,CONCAT(u.fname,' ',u.lname) as buyername,u.userId as buyeruserId,date_format(f.date_added,'%D %b, %Y') as buyDate,f.sold_date,CONCAT(u1.fname,' ',u1.lname) as sellername,u1.mail as selleremail,u1.userId as selleruserId,sr.price,st.id as businessdfetailsid from 
        ".TABLE_PREFIX."buy_request as f
        join ".TABLE_PREFIX."sell_record as sr on sr.listing_id=f.listing_id
        join ".TABLE_PREFIX."sell_business_temp as st on st.listing_id=f.listing_id
        join ".TABLE_PREFIX."users as u on u.userId=f.userId
        join ".TABLE_PREFIX."users as u1 on u1.userId=f.sellerId
        ".$joinSql."
        where f.id>0 and f.transfer_status<>4 and f.section='".$section."' ".$partSql." ".$sortsql." limit ".$arr['start'].",".$arr['limit']."";
        $query = $this->db->query($q);    
        $userDetails = $query->result_array();

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
        
        return array('record'=>$userDetails,'totalrecord'=>$totalrecord);
    }

    function getwalletbuyreq($arr)
    {
        $partSql = '';
        if($arr['searchByStatus']>0)
        {
            $partSql .= " and f.status=".$arr['searchByStatus'];
        }
        if($arr['searchName']!='')
        {
            $partSql .= " and (u.fname like '%".$arr['searchName']."%' || u1.fname like '%".$arr['searchName']."%' || f.transaction_ref like '%".$arr['searchName']."%' || f.description like '%".$arr['searchName']."%' || f.listing_id like '%".$arr['searchName']."%')";
        }
        if($arr['id']>0)
        {
            $partSql .= " and f.id=".$arr['id'];
        }
        
            $partSql .= " and f.userId=".$arr['userId'];
        
        if($arr['searchBySellType'] == 1)
        {
            $joinSql = " join ".TABLE_PREFIX."listing_offers as lo on f.sellerId=lo.sellerId and f.userId=lo.userId and f.listing_id=lo.listing_id";
            $partSql .= " and lo.status=2";
        }
        if($arr['searchBySellType'] == 2)
        {
            $joinSql = " left join ".TABLE_PREFIX."listing_offers as lo on f.sellerId=lo.sellerId and f.userId=lo.userId and f.listing_id=lo.listing_id and lo.status=2";
            $partSql .= " and lo.id IS NULL";
        }
        $section = $arr['section'];
        $q = "select SQL_CALC_FOUND_ROWS f.*,u.fname as buyername,u.userId as buyeruserId,date_format(f.date_added,'%D %b, %Y') as buyDate from 
        ".TABLE_PREFIX."buy_request as f
        join ".TABLE_PREFIX."users as u on u.userId=f.userId
        ".$joinSql."
        where f.id>0 and (f.section='WALLET' || f.section='WALLETWITHDRAW' || (f.section='LISTING' and (f.payment_mode='WALLET' OR f.payment_mode='BOTH'))) ".$partSql." order by f.date_added desc limit ".$arr['start'].",".$arr['limit']."";
        $query = $this->db->query($q);    
        $userDetails = $query->result_array();
        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
        $sitesettings = $this->getSiteSettings();
        $currency = $this->getCurrencies($sitesettings['currency']);
        return array('record'=>$userDetails,'totalrecord'=>$totalrecord, 'currency'=>$currency);
    }
    function getwalletbuyreqadmin($arr,$sort=[])
    {
        $partSql = '';
        if($arr['searchByStatus']>0)
        {
            $partSql .= " and f.status=".$arr['searchByStatus'];
        }
        if($arr['searchName']!='')
        {
            $partSql .= " and (u.fname like '%".$arr['searchName']."%' || u1.fname like '%".$arr['searchName']."%' || u.lname like '%".$arr['searchName']."%' || u1.lname like '%".$arr['searchName']."%' || f.transaction_ref like '%".$arr['searchName']."%' || f.description like '%".$arr['searchName']."%' || f.listing_id like '%".$arr['searchName']."%')";
        }
        if($arr['id']>0)
        {
            $partSql .= " and f.id=".$arr['id'];
        }
        
        if($arr['searchBySellType'] == 1)
        {
            $joinSql = " join ".TABLE_PREFIX."listing_offers as lo on f.sellerId=lo.sellerId and f.userId=lo.userId and f.listing_id=lo.listing_id";
            $partSql .= " and lo.status=2";
        }
        if($arr['searchBySellType'] == 2)
        {
            $joinSql = " left join ".TABLE_PREFIX."listing_offers as lo on f.sellerId=lo.sellerId and f.userId=lo.userId and f.listing_id=lo.listing_id and lo.status=2";
            $partSql .= " and lo.id IS NULL";
        }
        $section = $arr['section'];
        $sortarr = ['0'=>'u.fname','1'=>'u.mail','2'=>'u.phone','3'=>'f.transaction_ref','4'=>'f.wallet_amount','6'=>'f.date_added'];
        
        if(count($sort)>0)
        {
            $sortsql = 'order by '. $sortarr[$sort['column']].' '.$sort['dir'];
        }else{
            $sortsql = 'order by f.date_added desc';
        }
        $q = "select SQL_CALC_FOUND_ROWS f.*,CONCAT(u.fname,' ',u.lname) as buyername,u.mail as buyermail,u.phone as buyerphone,u.userId as buyeruserId,date_format(f.date_added,'%D %b, %Y') as buyDate from 
        ".TABLE_PREFIX."buy_request as f
        join ".TABLE_PREFIX."users as u on u.userId=f.userId
        ".$joinSql."
        where f.id>0 and (f.section='WALLET' || f.section='WALLETWITHDRAW') ".$partSql." ".$sortsql." limit ".$arr['start'].",".$arr['limit']."";
        $query = $this->db->query($q);    
        $userDetails = $query->result_array();
        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
        $sitesettings = $this->getSiteSettings();
        $currency = $this->getCurrencies($sitesettings['currency']);
        return array('record'=>$userDetails,'totalrecord'=>$totalrecord, 'currency'=>$currency);
    }

    function updatebuydetails($id,$action){
        $this->db->select("br.*,ub.fname as buyername,ub.userId as buyeruserId,ub.mail as buyeremail,us.fname as sellername,us.userId as selleruserId,us.mail as selleremail");
        $this->db->from(TABLE_PREFIX.'buy_request br');
        $this->db->join(TABLE_PREFIX.'users ub','ub.userId=br.userId');
        $this->db->join(TABLE_PREFIX.'users us','us.userId=br.sellerId');
        $this->db->where('br.id', $id); 
        $Query = $this->db->get();
        $Array = $Query->row();
        if($action == 'reject')
        {
            $arr['status'] = 3;
            $listingId = $Array->listing_id;
            $updatesell['Status'] = 1;
            $this->db->where('listing_id', $listingId);
            $this->db->update(TABLE_PREFIX.'sell_record', $updatesell);

            
        }elseif($action == 'approve')
        {
            $arr['status'] = 2;
            $arr['sold_date'] = date('Y-m-d H:i:s');
            $listingId = $Array->listing_id;
            $updatesell['Status'] = 4;
            $this->db->where('listing_id', $listingId);
            $this->db->update(TABLE_PREFIX.'sell_record', $updatesell);

        }
        
        $this->db->where('id', $id);
        $this->db->update(TABLE_PREFIX.'buy_request', $arr);
        return $Array;
    }

    function updatewalletbuydetails($id,$action){
        $this->db->select("br.*,ub.fname as buyername,ub.userId as buyeruserId,ub.mail as buyeremail");
        $this->db->from(TABLE_PREFIX.'buy_request br');
        $this->db->join(TABLE_PREFIX.'users ub','ub.userId=br.userId');
        $this->db->where('br.id', $id); 
        $Query = $this->db->get();
        $Array = $Query->row();
        if($action == 'reject')
        {
            $arr['status'] = 3;
            $listingId = $Array->listing_id;
            //$updatesell['Status'] = 1;
            //$this->db->where('listing_id', $listingId);
            //$this->db->update(TABLE_PREFIX.'sell_record', $updatesell);
        }elseif($action == 'approve')
        {
            $arr['status'] = 2;
            $arr['sold_date'] = date('Y-m-d H:i:s');
            $listingId = $Array->listing_id;
            //$updatesell['Status'] = 4;
            //$this->db->where('listing_id', $listingId);
            //$this->db->update(TABLE_PREFIX.'sell_record', $updatesell);

        }
        
        $this->db->where('id', $id);
        $this->db->update(TABLE_PREFIX.'buy_request', $arr);
        return $Array;
    }

    function alterPromoCode($arr,$action){
        if($action == 'add')
        {
            $this->db->insert(TABLE_PREFIX.'promo_code', $arr);
            return $this->db->insert_id();
        }elseif($action == 'edit'){
            $this->db->where('id', $arr['id']);
            unset($arr['id']);
            $this->db->update(TABLE_PREFIX.'promo_code', $arr);
        }
    }

    function getpromocode($arr){
        
        $this->db->select("*");
        $this->db->from(TABLE_PREFIX.'promo_code');
        if($arr['id']>0)
        {
            $this->db->where('id', $arr['id']); 
        }
        $this->db->where('status', 1);   
        if($arr['limit']>0) 
        {
            $this->db->limit($arr['limit'],$arr['page']);  
        }
        $Query = $this->db->get();
        $Array = $Query->result_array();
        return $Array;
    }

    function altercuratedContent($arr,$action){
        if($action == 'add')
        {
            $q = "select max(U.sort) as maxsort from ".TABLE_PREFIX."cutared_contents as U where U.id>0";
            $query = $this->db->query($q);    
            $partner = $query->row();
            $arr['sort'] = $partner->maxsort+1;

            $this->db->insert(TABLE_PREFIX.'cutared_contents', $arr);
            return $this->db->insert_id();
        }elseif($action == 'edit'){
            $this->db->where('id', $arr['id']);
            unset($arr['id']);
            $this->db->update(TABLE_PREFIX.'cutared_contents', $arr);
        }
    }

    function getcuratedcontent($arr){
        
        $this->db->select("*");
        $this->db->from(TABLE_PREFIX.'cutared_contents');
        if($arr['id']>0)
        {
            $this->db->where('id', $arr['id']); 
        }
        $this->db->where('status', 1); 
        $this->db->order_by('sort');  
        if($arr['limit']>0) 
        {
            $this->db->limit($arr['limit'],$arr['page']);  
        }
        $Query = $this->db->get();
        $Array = $Query->result_array();
        return $Array;
    }
    function getvaluationquestions(){
        $this->db->select("*");
        $this->db->from(TABLE_PREFIX.'valuation_questions');
        if($arr['id']>0)
        {
            $this->db->where('id', $arr['id']); 
        }
        $this->db->where('status', 1); 
        $this->db->order_by('sort');  
        if($arr['limit']>0) 
        {
            $this->db->limit($arr['limit'],$arr['page']);  
        }
        $Query = $this->db->get();
        $Array = $Query->result_array();
        return $Array;
    }

    function altervaluationQuestions($arr,$action){
        if($action == 'add')
        {
            $q = "select max(U.sort) as maxsort from ".TABLE_PREFIX."valuation_questions as U where U.id>0";
            $query = $this->db->query($q);    
            $partner = $query->row();
            $arr['sort'] = $partner->maxsort+1;

            $this->db->insert(TABLE_PREFIX.'valuation_questions', $arr);
            return $this->db->insert_id();
        }elseif($action == 'edit'){
            $this->db->where('id', $arr['id']);
            unset($arr['id']);
            $this->db->update(TABLE_PREFIX.'valuation_questions', $arr);
        }
    }
    function alterfreedownloadContent($arr,$action){
        if($action == 'add')
        {
            $q = "select max(U.sort) as maxsort from ".TABLE_PREFIX."free_content_download as U where U.id>0";
            $query = $this->db->query($q);    
            $partner = $query->row();
            $arr['sort'] = $partner->maxsort+1;

            $this->db->insert(TABLE_PREFIX.'free_content_download', $arr);
            return $this->db->insert_id();
        }elseif($action == 'edit'){
            $this->db->where('id', $arr['id']);
            unset($arr['id']);
            $this->db->update(TABLE_PREFIX.'free_content_download', $arr);
        }
    }
    
    function getfreedownloadcontent($arr){
        
        $this->db->select("*");
        $this->db->from(TABLE_PREFIX.'free_content_download');
        if($arr['id']>0)
        {
            $this->db->where('id', $arr['id']); 
        }
        $this->db->where('status', 1); 
        $this->db->order_by('sort');  
        if($arr['limit']>0) 
        {
            $this->db->limit($arr['limit'],$arr['page']);  
        }
        $Query = $this->db->get();
        $Array = $Query->result_array();
        return $Array;
    }

    function gettickets($arr,$sort=[]){
        $start = $arr['start'];
        $limit = $arr['limit'];
        $partSql = '';
        $sortarr = ['0'=>'f.ticket_no','1'=>'u.fname,u.lname,u1.fname,u1.lname','2'=>'u.mail,u1.mail','3'=>'u.phone,u1.phone','4'=>'f.subject','5'=>'f.date_added'];
        
        if(count($sort)>0)
        {
            $sortsql = 'order by '. $sortarr[$sort['column']].' '.$sort['dir'];
        }else{
            $sortsql = 'order by f.date_added desc';
        }

        if($arr['searchByStatus']>0)
        {
            $partSql .= " and f.status=".$arr['searchByStatus']."";
        }
        if($arr['searchName']!='')
        {
            $partSql .= " and (f.subject LIKE '%".$arr['searchName']."%' || f.message LIKE '%".$arr['searchName']."%' || u.fname LIKE '%".$arr['searchName']."%' || u.lname LIKE '%".$arr['searchName']."%' || f.ticket_no LIKE '%".$arr['searchName']."%')";
        }
        $q = "select SQL_CALC_FOUND_ROWS f.*,u.userId as uid,CONCAT(u.fname,' ',u.lname) as fname,u.mail,u.phone,CONCAT(u1.fname,' ',u1.lname) as fname1,u1.userId as uid1,u1.mail as mail1,u1.phone as phone1 from 
        ".TABLE_PREFIX."ticketing as f
        join ".TABLE_PREFIX."users as u on u.userId=f.userId
        join ".TABLE_PREFIX."users as u1 on u1.userId=f.userid_to
        where f.id>0 and f.id in (SELECT max(id) FROM ".TABLE_PREFIX."ticketing  GROUP by reply_ticket_id) $partSql $sortsql limit $start,$limit";
        $query = $this->db->query($q);    
        $userDetails = $query->result_array();

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();

        return array('record'=>$userDetails,'totalrecord'=>$totalrecord); 
    }
    function listpartners($page,$limit)
    {
        $q = "select SQL_CALC_FOUND_ROWS U.* from ".TABLE_PREFIX."partners as U
        where U.id>0 order by U.sort limit ".$page.",".$limit."";
        $query = $this->db->query($q);    
        $Array = $query->result_array();

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();

        return array('p'=>$Array,'totalrecord'=>$totalrecord);
    }
    function alterPartner($param){
        $this->db->where('id', $param['id']);
        unset($param['id']);
        $this->db->update(TABLE_PREFIX.'partners', $param);
    }

    public function getTicketDetails($id){
        $q = "select SQL_CALC_FOUND_ROWS f.*,CONCAT(u.fname,' ',u.lname) as fname from 
        ".TABLE_PREFIX."ticketing as f
        join ".TABLE_PREFIX."users as u on u.userId=f.userId
        where f.id>0 and f.ticket_no='$id' order by f.date_added asc";
        $query = $this->db->query($q);    
        $userDetails = $query->result_array();
        $param['admin_read'] = 'Y';
        $this->db->where('ticket_no', $id);
        $this->db->update(TABLE_PREFIX.'ticketing', $param);

        return $userDetails;
    }

    function altertestimonialContent($arr,$action){
        if($action == 'add')
        {
            $q = "select max(U.sort) as maxsort from ".TABLE_PREFIX."testimonials as U where U.id>0";
            $query = $this->db->query($q);    
            $partner = $query->row();
            $arr['sort'] = $partner->maxsort+1;

            $this->db->insert(TABLE_PREFIX.'testimonials', $arr);
            return $this->db->insert_id();
        }elseif($action == 'edit'){
            $this->db->where('id', $arr['id']);
            unset($arr['id']);
            $this->db->update(TABLE_PREFIX.'testimonials', $arr);
        }
    }

    function gettestimonialcontent($arr){
        if($arr['id']>0)
        {
            //$this->db->where('id', $arr['id']); 
            $partSql = " and id=".$arr['id'];
        }
        if($arr['limit']>0) 
        {
            //$this->db->limit($arr['limit'],$arr['page']);  
            $limitSql = "limit ".$arr['page'].",".$arr['limit'];
        }

        $q = "select SQL_CALC_FOUND_ROWS t.*,DATE_FORMAT(t.date_added, '%D %M %Y') as dateformated from 
        ".TABLE_PREFIX."testimonials t
        where status=1 $partSql order by sort $limitSql";
        $query = $this->db->query($q);    
        $Array = $query->result_array();
        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();

        /*$this->db->select("*");
        $this->db->from(TABLE_PREFIX.'testimonials');
        if($arr['id']>0)
        {
            $this->db->where('id', $arr['id']); 
        }
        $this->db->where('status', 1); 
        $this->db->order_by('sort');  
        
        $Query = $this->db->get();
        $Array = $Query->result_array();
        */

        return [$Array,$totalrecord];
    }

    function sethomecontents($arr,$action)
    {
        if($action == 'edit')
        {
            $this->db->where('id', $arr['id']);
            unset($arr['id']);
            $this->db->update(TABLE_PREFIX.'home_contents', $arr);
        }else{
            $this->db->insert(TABLE_PREFIX.'home_contents', $arr);
        }
    }
    function gethomecontent()
    {
        $this->db->select("*");
        $this->db->from(TABLE_PREFIX.'home_contents');
        $Query = $this->db->get();
        $Array = $Query->row();

        $this->db->select("*");
        $this->db->from(TABLE_PREFIX.'how_it_works');
        $Query = $this->db->get();
        $ArrayHowItWorks = $Query->result_array();
        if(is_array($ArrayHowItWorks) && count($ArrayHowItWorks)>0)
        {
            foreach($ArrayHowItWorks as $k=>$v)
            {
                $parentId = $v['id'];
                $this->db->select("*");
                $this->db->from(TABLE_PREFIX.'how_it_works_steps');
                $this->db->where('parentId',$parentId);
                $Query = $this->db->get();
                $ArraySub = $Query->result_array();

                if($v['section'] == 'BUYER')
                {
                    $buyerArray = ['content'=>$v,'steps'=>$ArraySub];
                }elseif($v['section'] == 'SELLER')
                {
                    $sellerArray = ['content'=>$v,'steps'=>$ArraySub];
                }elseif($v['section'] == 'GENERAL')
                {
                    $generalArray = ['content'=>$v,'steps'=>$ArraySub];
                }
            }
        }
        return [$Array,$buyerArray,$sellerArray,$generalArray];
    }

    function getsubhomecontentDetails()
    {
        $this->db->select("*", FALSE);
        $this->db->from(TABLE_PREFIX.'how_it_works');
        $Query = $this->db->get();
        $Array = $Query->result_array();
        
        if(is_array($Array) && count($Array)>0)
        {
            foreach($Array as $k=>$v)
            {
                $id = $v['id'];
                $this->db->select("*");
                $this->db->where('parentId', $id);
                $this->db->from(TABLE_PREFIX.'how_it_works_steps');
                $Query = $this->db->get();
                $ArraySub = $Query->result_array();
                $Array[$k]['steps'] = $ArraySub;
            }
        }
        return $Array;
    }

    function setsubhomecontent($arr,$subarr,$section){
        $this->db->select("*");
        $this->db->from(TABLE_PREFIX.'how_it_works');
        $this->db->where('section', $section);
        $Query = $this->db->get();
        $Array = $Query->row();
        $sectionId = $Array->id;

        $this->db->where('id', $sectionId);
        $this->db->where('section', $section);
        $this->db->update(TABLE_PREFIX.'how_it_works', $arr);
    
        $this->db->where('parentId', $sectionId);
        $this->db->delete(TABLE_PREFIX.'how_it_works_steps');
        
        if(is_array($subarr) && count($subarr)>0)
        {
            $k = 1;
            foreach($subarr as $val)
            {
                $subarr1['parentId'] = $sectionId;
                $subarr1['title'] = $val[0];
                $subarr1['description'] = $val[1];
                $subarr1['sort'] = $k;
                //print_r($subarr);
                $this->db->insert(TABLE_PREFIX.'how_it_works_steps', $subarr1);
                $k++;
            }
        }

        return $Array;
    }

    function getsubhomecontent(){
        $this->db->select("*");
        $this->db->from(TABLE_PREFIX.'how_it_works');
        $Query = $this->db->get();
        $Array = $Query->row();
        $sectionId = $Array->id;
    }

    function updatebuytransferdetails($arr){
        $id = $arr['id'];
        $this->db->where('id', $arr['id']);
        $this->db->where('status', $arr['status']);
        unset($arr['id']);
        unset($arr['status']);
        $this->db->update(TABLE_PREFIX.'buy_request', $arr);

        $this->db->select("br.*,ub.fname as buyername,ub.userId as buyeruserId,ub.mail as buyeremail,us.fname as sellername,us.userId as selleruserId,us.mail as selleremail");
        $this->db->from(TABLE_PREFIX.'buy_request br');
        $this->db->join(TABLE_PREFIX.'users ub','ub.userId=br.userId');
        $this->db->join(TABLE_PREFIX.'users us','us.userId=br.sellerId');
        $this->db->where('br.id', $id); 
        $Query = $this->db->get();
        $Array = $Query->row();
        return $Array;
    }

    function getquestioncategories(){
        $this->db->select("*");
        $this->db->where('status', 1);
        $this->db->from(TABLE_PREFIX.'question_category');
        $this->db->order_by('sort','asc');
        $Query = $this->db->get();
        $ArraySub = $Query->result_array();
        return $ArraySub;
    }

    function getcalllog($arr){
        /*$this->db->select('*', FALSE);
        $this->db->from(TABLE_PREFIX.'callschedules', FALSE);
        $this->db->order_by('call_time', 'desc');   
        $Query = $this->db->get();
        $sellrec = $Query->result_array();
        return $sellrec;*/
        //$arr['page'] = 0;
        //$arr['limit'] = 10;

        if($arr['id']>0)
        {
            //$this->db->where('id', $arr['id']); 
            $partSql = " and t.id=".$arr['id'];
        }
        if($arr['limit']>0) 
        {
            //$this->db->limit($arr['limit'],$arr['page']);  
            $limitSql = "limit ".$arr['start'].",".$arr['limit'];
        }
        if($arr['searchValue']!='') 
        {
            //$this->db->limit($arr['limit'],$arr['page']);  
            $partSql .= " and (t.user_name like '%".$arr[searchValue]."%' || t.user_phone like '%".$arr[searchValue]."%' || t.note like '%".$arr[searchValue]."%' || u.mail like '%".$arr[searchValue]."%' || t.enqiry_type like '%".$arr[searchValue]."%')";
        }
        if($arr['searchStatus']!='') 
        {
            //$this->db->limit($arr['limit'],$arr['page']);  
            $partSql .= " and t.status='".$arr['searchStatus']."'";
            if($arr['searchStatus'] == 4)
            {
                
            }else{
                $partSql .= " and t.call_time> DATE_SUB(NOW(), INTERVAL 2 HOUR)";
            }
        }else{
            $partSql .= " and t.call_time> DATE_SUB(NOW(), INTERVAL 2 HOUR)";
        }
        if($arr['searchTimeSchedulecall']!='') 
        {
            //$this->db->limit($arr['limit'],$arr['page']);  
            $partSql .= " and t.call_time >='".$arr['searchTimeSchedulecall']."'";
        }

        $sortarr = ['0'=>'u.fname,u.lname','1'=>'u.mail','2'=>'u.phone','3'=>'t.call_time'];
        
        if(count($sort)>0)
        {
            $sortsql = 'order by '. $sortarr[$sort['column']].' '.$sort['dir'];
        }else{
            $sortsql = 'order by t.call_time asc';
        }

        $q = "select SQL_CALC_FOUND_ROWS t.*,u.mail as email from 
        ".TABLE_PREFIX."callschedules t
        join ".TABLE_PREFIX."users u on t.user_id = u.userId
        where t.status>0 $partSql $sortsql $limitSql";
        $query = $this->db->query($q);    
        $Array = $query->result_array();
        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
        return ['callrequests'=>$Array, 'totalrecord'=>$totalrecord];
    }

    function updatecalllog($data)
    {
        $this->db->where('id', $data['id']);
        unset($data['id']);
        $this->db->update(TABLE_PREFIX.'callschedules', $data);
    }

    function getcontactus($arr){
        $start = $arr['start'];
        $limit = $arr['limit'];
        
        $partSql = '';
        
        if($arr['searchName']!='')
        {
            $partSql .= " and (f.name LIKE '%".$arr['searchName']."%' || f.phone LIKE '%".$arr['searchName']."%' || f.email LIKE '%".$arr['searchName']."%' || f.message LIKE '%".$arr['searchName']."%')";
        }
         if($arr['id']>0)
        {
            $partSql .= " and f.id = '".$arr['id']."'";
        }
        $q = "select SQL_CALC_FOUND_ROWS f.* from 
        ".TABLE_PREFIX."contactus as f
        where f.id>0 $partSql order by f.date_added desc limit $start,$limit";
        $query = $this->db->query($q);    
        $userDetails = $query->result_array();

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();

        return array('record'=>$userDetails,'totalrecord'=>$totalrecord); 
    }

    

    

    
}