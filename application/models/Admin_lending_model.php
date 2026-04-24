<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_lending_model extends CI_Model {
    
    function actionLendingDetails($param, $action){
        switch($action){
            case 'add':
                $this->db->insert(TABLE_PREFIX.'acquisition_lending', $param);
                return $this->db->insert_id();
            break;

            case 'edit':
            case 'delete':
                $this->db->where('id', $param['LendingId']);
                unset($param['LendingId']);
                $this->db->update(TABLE_PREFIX.'acquisition_lending', $param);
                return $this->db->affected_rows();
            break;
        }
    }

    function getlending($searchArr,$sort){
        $partSql = "";
        $searchArr['start'] = 0;
        $searchArr['limit'] = 10;
        if($searchArr['searchValue']!='')
        {
            $searchval = $searchArr['searchValue'];
            $partSql = " and (U.fname like '%$searchval%' || U.lname like '%$searchval%' || U.phone like '%$searchval%' || U.mail like '%$searchval%' )";
        }
        $sortarr = ['0'=>'U.id','1'=>'U.industry','2'=>'U.loan_type','3'=>'U.loan_term','6'=>'U.status','4'=>'U.acquirer_contribution','5'=>'U.added_on'];
        
        if(count($sort)>0)
        {
            $sortsql = 'order by '. $sortarr[$sort['column']].' '.$sort['dir'];
        }else{
            $sortsql = 'order by U.Added_on desc';
        }

        $q = "select SQL_CALC_FOUND_ROWS U.*,U.industry as industryname from 
        ".TABLE_PREFIX."acquisition_lending as U
        where 1 $partSql ".$sortsql." limit ".$searchArr['start'].",".$searchArr['limit']."";
        $query = $this->db->query($q);    
        $pendingfund = $query->result_array();  
        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
 
        return array("totalrecord"=>$totalrecord,"lending"=>$pendingfund);
    
    }

    function getfunded($searchArr,$sort){
        $partSql = "";
        $searchArr['start'] = 0;
        $searchArr['limit'] = 10;
        if($searchArr['searchValue']!='')
        {
            $searchval = $searchArr['searchValue'];
            $partSql = " and (U.fund_seeker like '%$searchval%' || U.amount like '%$searchval%' || U.funding_timing like '%$searchval%' || U.website like '%$searchval%' )";
        }
        $sortarr = ['0'=>'U.id','1'=>'U.fund_seeker','2'=>'U.amount','3'=>'U.funding_timing','4'=>'U.website','5'=>'U.phone','6'=>'U.email','7'=>'U.date_added'];
        
        if(count($sort)>0)
        {
            $sortsql = 'order by '. $sortarr[$sort['column']].' '.$sort['dir'];
        }else{
            $sortsql = 'order by U.date_added desc';
        }

        $q = "select SQL_CALC_FOUND_ROWS U.* from 
        ".TABLE_PREFIX."get_fund_list as U
        where 1 $partSql ".$sortsql." limit ".$searchArr['start'].",".$searchArr['limit']."";
        $query = $this->db->query($q);    
        $pendingfund = $query->result_array();  
        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
 
        return array("totalrecord"=>$totalrecord,"lending"=>$pendingfund);
    
    }

    function fundacquisition($searchArr,$sort){
        $partSql = "";
        $searchArr['start'] = 0;
        $searchArr['limit'] = 10;
        if($searchArr['searchValue']!='')
        {
            $searchval = $searchArr['searchValue'];
            $partSql = " and (U.investor like '%$searchval%' || U.name like '%$searchval%' || U.street like '%$searchval%' || U.phone like '%$searchval%' || U.email like '%$searchval%' )";
        }
        $sortarr = ['0'=>'U.id','1'=>'U.investor','2'=>'U.name','3'=>'U.street','4'=>'U.phone','5'=>'U.email','6'=>'U.date_added'];
        
        if(count($sort)>0)
        {
            $sortsql = 'order by '. $sortarr[$sort['column']].' '.$sort['dir'];
        }else{
            $sortsql = 'order by U.date_added desc';
        }

        $q = "select SQL_CALC_FOUND_ROWS U.* from 
        ".TABLE_PREFIX."fund_acquisition as U
        where 1 $partSql ".$sortsql." limit ".$searchArr['start'].",".$searchArr['limit']."";
        $query = $this->db->query($q);    
        $pendingfund = $query->result_array();  
        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
 
        return array("totalrecord"=>$totalrecord,"lending"=>$pendingfund);
    
    }

    function fundrequestaccess($searchArr,$sort){
        $partSql = "";
        $searchArr['start'] = 0;
        $searchArr['limit'] = 10;
        if($searchArr['searchValue']!='')
        {
            $searchval = $searchArr['searchValue'];
            $partSql = " and (U.investor like '%$searchval%' || U.available_money like '%$searchval%' || U.hold_period like '%$searchval%' || U.name like '%$searchval%' || U.phone like '%$searchval%' || U.email like '%$searchval%' )";
        }
        $sortarr = ['0'=>'U.id','1'=>'U.investor','2'=>'U.available_money','3'=>'U.hold_period','4'=>'U.name','5'=>'U.email','6'=>'U.phone','7'=>'U.date_added'];
        
        if(count($sort)>0)
        {
            $sortsql = 'order by '. $sortarr[$sort['column']].' '.$sort['dir'];
        }else{
            $sortsql = 'order by U.date_added desc';
        }

        $q = "select SQL_CALC_FOUND_ROWS U.* from 
        ".TABLE_PREFIX."request_access_list as U
        where 1 $partSql ".$sortsql." limit ".$searchArr['start'].",".$searchArr['limit']."";
        $query = $this->db->query($q);    
        $pendingfund = $query->result_array();  
        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
 
        return array("totalrecord"=>$totalrecord,"lending"=>$pendingfund);
    
    }

    function getLendingDetails($id)
    {
        $q = "select U.*,I.industry as industryname from 
        ".TABLE_PREFIX."acquisition_lending as U
        LEFT JOIN ".TABLE_PREFIX."industries as I ON I.id=U.industry
        where U.id=".$id;
        $query = $this->db->query($q);    
        $pendingfund = $query->result_array();  
        return $pendingfund[0];
    }


}

?>