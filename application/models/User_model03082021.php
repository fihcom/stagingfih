<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    function getmonetization($area='SELL'){
        $this->db->select('*', FALSE);
        $this->db->from(TABLE_PREFIX.'monetization', FALSE);
        $this->db->where('Status', 1);
        $this->db->where('area', $area);       
        $Query = $this->db->get();
        $Array = $Query->result_array();
        return $Array;
    }

    function sellbusinesstemp($json_text,$user){
        $this->db->select('id', FALSE);
        $this->db->from(TABLE_PREFIX.'sell_business_temp', FALSE);
        $this->db->where('userId', $user); 
        $this->db->where('Status', 0);  
        $this->db->where('type', 'SELL');      
        $this->db->limit(1);      
        $Query = $this->db->get();
        $sellrec = $Query->row();
        if($sellrec->id >0)
        {
            $this->db->set('data_json', $json_text);
            $this->db->where('userId', $user);
            $this->db->where('id', $sellrec->id);
            $this->db->update(TABLE_PREFIX.'sell_business_temp');
        }else{
            $editArray['userId'] = $user;
            $editArray['data_json'] = $json_text;
            $this->db->insert(TABLE_PREFIX.'sell_business_temp', $editArray);
        }

    }

    function valuebusinesstemp($json_text,$user,$listingId){
        $this->db->select('id', FALSE);
        $this->db->from(TABLE_PREFIX.'sell_business_temp', FALSE);
        $this->db->where('userId', $user); 
        $this->db->where('Status', 0); 
        $this->db->where('type', 'VALUATION'); 
        $this->db->where('listing_id',$listingId); 
        $this->db->limit(1);      
        $Query = $this->db->get();
        $sellrec = $Query->row();
        if($sellrec->id >0)
        {
            $this->db->set('data_json', $json_text);
            $this->db->where('userId', $user);
            $this->db->where('id', $sellrec->id);
            $this->db->where('listing_id', $listingId);
            $this->db->update(TABLE_PREFIX.'sell_business_temp');
        }else{
            $editArray['userId'] = $user;
            $editArray['data_json'] = $json_text;
            $editArray['type'] = 'VALUATION';
            $editArray['listing_id'] = $listingId;
            $this->db->insert(TABLE_PREFIX.'sell_business_temp', $editArray);
        }

    }

    function gettempselldata($user,$area='SELL'){
        $this->db->select('*', FALSE);
        $this->db->from(TABLE_PREFIX.'sell_business_temp', FALSE);
        $this->db->where('userId', $user);    
        $this->db->where('Status', 0);
        $this->db->where('type', $area);  
        $this->db->limit(1);      
        $Query = $this->db->get();
        $sellrec = $Query->row();
        return $sellrec;
    }
    
    function getpendingapplications($user,$area='SELL'){
        $this->db->select('*', FALSE);
        $this->db->from(TABLE_PREFIX.'sell_business_temp', FALSE);
        $this->db->where('userId', $user);    
        $this->db->where('Status<>', 0);
        $this->db->where('type', 'SELL');   
        $this->db->order_by('last_updated', 'desc');   
        $Query = $this->db->get();
        $sellrec = $Query->result_array();
        return $sellrec;
    }

    function updatecallschedule($arr,$action = 'add')
    {
        if($action == 'add')
        {
            $this->db->insert(TABLE_PREFIX.'callschedules', $arr);
            return $this->db->insert_id();
        }
    }


    function getcalllog($arr){
        $userId = $arr['userId'];
        $this->db->select('*', FALSE);
        $this->db->from(TABLE_PREFIX.'callschedules', FALSE);
        $this->db->where('user_id', $userId); 
        $this->db->order_by('call_time', 'desc');   
        $Query = $this->db->get();
        $sellrec = $Query->result_array();
        return $sellrec;
    }
    
    function gettempvaluationdata($user,$listingId){
        $this->db->select('*', FALSE);
        $this->db->from(TABLE_PREFIX.'sell_business_temp', FALSE);
        $this->db->where('userId', $user);    
        $this->db->where('Status', 0); 
        $this->db->where('type','VALUATION'); 
        $this->db->where('listing_id', $listingId); 
        $this->db->limit(1);      
        $Query = $this->db->get();
        $sellrec = $Query->row();
        return $sellrec;
    }

    function updateuserprofile($user)
    {
        $this->db->where('userId', $user['clientId']);
        unset($user['clientId']);
        $this->db->update(TABLE_PREFIX.'users',$user);
    }
    function getuserprofile($user)
    {
        //$user['userId'];
        $this->db->select('U.*,UD.*', FALSE);
        $this->db->from(TABLE_PREFIX.'users U', FALSE);
        $this->db->join(TABLE_PREFIX.'user_details UD', 'U.userId = UD.userId','left');
        $this->db->where('U.userId', $user['userId']);    
        $this->db->where('U.Status', 1);  
        $this->db->limit(1);      
        $Query = $this->db->get();
        $sellrec = $Query->row();
        return $sellrec;
    }
    function getUserDocuments($userId,$type){
        $this->db->select('BaseTbl.*', FALSE);
        $this->db->from(TABLE_PREFIX.'proof_of_funds as BaseTbl', FALSE);
        $this->db->where('BaseTbl.userId', $userId);
        $this->db->where('BaseTbl.doc_type', $type);
        $this->db->where('BaseTbl.status',1);
        $query = $this->db->get();        
        $listing = $query->result_array();
        return $listing;
    }

    function userdocumentproof($Arr,$action){
        if($action == 'add')
        {
            $this->db->insert(TABLE_PREFIX.'proof_of_funds', $Arr);
        }elseif($action == 'edit')
        {
            $this->db->where('userId', $Arr['userId']);
            unset($Arr['userId']);
            $this->db->update(TABLE_PREFIX.'proof_of_funds', $Arr);
        }
    }

    function updateuserdetails($arr)
    {
        $this->db->select('*', FALSE);
        $this->db->from(TABLE_PREFIX.'user_details', FALSE);
        $this->db->where('userId', $arr['userId']);     
        $Query = $this->db->get();
        $sellrec = $Query->row();

        if($sellrec->id>0)
        {
            $this->db->where('userId', $arr['userId']);
            unset($Arr['userId']);
            $this->db->update(TABLE_PREFIX.'user_details', $arr);
        }else{
            $this->db->insert(TABLE_PREFIX.'user_details', $arr);
        }
    }

    function getvaluationlisting($clientId){
        $this->db->select('*', FALSE);
        $this->db->from(TABLE_PREFIX.'sell_business_temp', FALSE);
        $this->db->where('userId', $clientId);  
        $this->db->where('type', 'VALUATION');     
        $this->db->where('Status', '1');   
        $this->db->order_by('last_updated', 'desc');   
        $Query = $this->db->get();
        $valuationListing = $Query->result_array();
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
        return $valuationListing;

    }

    function insertticket($arr){
        $insertId = $this->db->insert(TABLE_PREFIX.'ticketing', $arr);
        return $this->db->insert_id();
    }
    function closeticket($ticketId){
        $where = "ticket_no='$ticketId'";
        $this->db->set('status', 2);
        //$this->db->where('type', 'NEW');
        $this->db->where($where);
        $this->db->update(TABLE_PREFIX.'ticketing');
        return $ticketId;
    }

    function getpartnerts(){
        $this->db->select('*', FALSE);
        $this->db->from(TABLE_PREFIX.'partners', FALSE);
        $this->db->order_by('sort');  
        $Query = $this->db->get();
        $valuationListing = $Query->result_array();
        return $valuationListing;
    }

    function getusertickets($arr){
        $start = $arr['start'] = 0;
        $limit = $arr['limit'] = 10;
        $clientId = $arr['clientId'];
        
        $partSql = '';
        if($arr['searchByStatus']>0)
        {
            $partSql .= " and f.status=".$arr['searchByStatus']."";
        }
        if($arr['searchName']!='')
        {
            $partSql .= " and (f.subject LIKE '%".$arr['searchName']."%' || f.message LIKE '%".$arr['searchName']."%' || u.fname LIKE '%".$arr['searchName']."%' || f.ticket_no LIKE '%".$arr['searchName']."%')";
        }
        $q = "select SQL_CALC_FOUND_ROWS f.*,u.fname,u1.fname as fname1 from 
        ".TABLE_PREFIX."ticketing as f
        join ".TABLE_PREFIX."users as u on u.userId=f.userId
        join ".TABLE_PREFIX."users as u1 on u1.userId=f.userid_to
        where f.id>0 and (f.userId=$clientId OR f.userid_to=$clientId) and f.id in (SELECT max(id) FROM ".TABLE_PREFIX."ticketing where userId=$clientId OR userid_to=$clientId  GROUP by reply_ticket_id) $partSql order by f.date_added desc limit $start,$limit";
        $query = $this->db->query($q);    
        $userDetails = $query->result_array();

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
        
        return array('record'=>$userDetails,'totalrecord'=>$totalrecord); 
    }

    public function getTicketDetails($id,$user){
        $q = "select SQL_CALC_FOUND_ROWS f.*,u.fname from 
        ".TABLE_PREFIX."ticketing as f
        join ".TABLE_PREFIX."users as u on u.userId=f.userId
        where f.id>0 and f.ticket_no='$id' and (f.userId=$user OR f.userid_to=$user) order by f.date_added asc";
        $query = $this->db->query($q);    
        $userDetails = $query->result_array();
        $param['user_read'] = 'Y';
        $this->db->where('ticket_no', $id);
        $this->db->update(TABLE_PREFIX.'ticketing', $param);

        return $userDetails;
    }

    public function getpromocodedetails($promocode){
        //$promocode = $arr['redeemCode'];
        $q = "select * from ".TABLE_PREFIX."promo_code where promocode='$promocode' AND (validity='LifeTime' || (validity='DateRange' AND date_from<NOW() AND date_to>NOW()))";
        $query = $this->db->query($q);    
        $promoDetails = $query->row();
        return $promoDetails;
    }

    public function insertcontactus($arr){
        $this->db->insert(TABLE_PREFIX.'contactus', $arr);
        return $this->db->insert_id();
    }

    
} 