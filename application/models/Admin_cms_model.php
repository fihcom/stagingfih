<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_cms_model extends CI_Model {
    
    /* ==================================== Methods for Blog Management ====================================== */

    function getCMSPageLists(){
        $this->db->select('C.*');
        $this->db->from(TABLE_PREFIX.'cms_pages C');
        $this->db->where('isDeleted', '0');
        $Query = $this->db->get();
        $result = $Query->result_array();
        return $result;
    }

    function getCMSPageDetails($pageID){
        $this->db->select('*');
        $this->db->from(TABLE_PREFIX.'cms_pages');
        $this->db->where('pageID', $pageID);
        $this->db->where('isDeleted', '0');
        $Query = $this->db->get();
        $result = $Query->row_array();
        return $result;
    }
    function getCMSPageDetailsbyslug($pageSlug){
        $this->db->select('*');
        $this->db->from(TABLE_PREFIX.'cms_pages');
        $this->db->where('pageSlug', $pageSlug);
        $this->db->where('isDeleted', '0');
        $Query = $this->db->get();
        $result = $Query->row_array();
        return $result;
    }

    function alterCMSPages($param, $action){
        switch ($action) {
            case 'add':
                # code...
                $this->db->insert(TABLE_PREFIX.'cms_pages', $param);
                return $this->db->insert_id();
            break;

            case 'edit':
            case 'delete':
                # code...
                $this->db->where('pageID', $param['pageID']);
                unset($param['pageID']);
                $this->db->update(TABLE_PREFIX.'cms_pages', $param);
                return $this->db->affected_rows();
            break;
            
            default:
                # code...
                break;
        }
    } 

    function get_page_cms($pageID){
        $this->db->select('*');
        $this->db->from(TABLE_PREFIX.'cms_pages');
        $this->db->where('pages_id', $pageID);
        $this->db->where('isDeleted', '0');
        $Query = $this->db->get();
        $result = $Query->row_array();
        return $result;
    }

    function get_page_cms_extra_fields($pageID){
        $this->db->select('CMS.pages_id, CMSMT.extra_field_title, CMSMT.extra_field_name, CMSMT.display_type, CMSMV.meta_id,  CMSMV.meta_value');
        $this->db->from(TABLE_PREFIX.'cms_pages AS CMS');
        $this->db->join(TABLE_PREFIX.'cms_page_meta_types AS CMSMT', 'CMS.pages_id = CMSMT.page_id', 'left');
        $this->db->join(TABLE_PREFIX.'cms_page_meta_values AS CMSMV', 'CMSMT.id = CMSMV.meta_id', 'left');
        $this->db->where('CMS.pages_id', $pageID);
        $this->db->where('CMS.isDeleted', '0');
        $Query = $this->db->get();
        // echo $this->db->last_query();
        $result = $Query->result_array();
        return $result;
    }

    function save_page_cms($postData){
        if($postData['pages_id'] != ''){
            // edit the page details
            $pageID = $postData['pages_id'];
            $postData['page_updated'] = date('Y-m-d H:i:s');
            $this->db->where('pages_id',$pageID);
            $this->db->update(TABLE_PREFIX.'cms_pages', $postData);
            $resultData = $this->db->affected_rows();
            //echo "<pre>"; print_r($this->db->affected_rows());die;
            $msg = "Page has been updated successfully!";
        } else {
            $postData['page_created'] = date('Y-m-d H:i:s');
            $this->db->insert(TABLE_PREFIX.'cms_pages', $postData);
            $resultData = $this->db->affected_rows();
            //echo "<pre>"; print_r($this->db->affected_rows());die;
            $msg = "Page has been inserted successfully!";
        }

        $returnData = ($resultData > 0) ? '<span class="success">'.$msg.'</span>' : '<span class="error">Some Error Occurred!</span>';
        return $returnData;
    }

    function delete_cms_page($pageID){
        if($pageID != ''){
            $data['isDeleted'] = '1';
            $this->db->where('pages_id', $pageID);
            $this->db->update(TABLE_PREFIX.'cms_pages', $data);
            $resultData = $this->db->affected_rows();
        }
    }


    function getOwnerContentDetails()
    {
        $this->db->select('*');
        $this->db->from('llctbl_owner_content');
        $Query = $this->db->get();
        $result = $Query->result_array();
        return $result;
    }

}

?>