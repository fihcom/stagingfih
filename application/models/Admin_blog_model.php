<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_blog_model extends CI_Model {
    
    /* ==================================== Methods for Blog Management ====================================== */

    function getBlogCatLists(){
        $this->db->select('B.*', false);
        $this->db->from(TABLE_PREFIX.'blog_categories B', false);
        $this->db->where('B.isDeleted', '0');
        $Query = $this->db->get();
        
        $Array = $Query->result_array();
        return $Array;
    }

    function getBlogParentCategories($blogCatID = ''){
       $this->db->select('blogCatID, blogCatName', false);
        $this->db->from(TABLE_PREFIX.'blog_categories', false);
        $this->db->where('blogCatParent', '0');
        if($blogCatID != ''){
            $this->db->where('blogCatID <>', $blogCatID);
        }
        $this->db->where('isDeleted', '0'); 
        $Query = $this->db->get();

        // echo $this->db->last_query();
        $Array = $Query->result_array();
        return $Array;
    }


    function getBlogCatSingle($ID){
        $this->db->select('*');
        $this->db->from(TABLE_PREFIX.'blog_categories');
        $this->db->where('blogCatID', $ID);
        $this->db->where('isDeleted', '0');

        $Query = $this->db->get();
        //echo $this->db->last_query();
        $Array = $Query->row_array();
        return $Array;
    }

    function actionBlogCatDetails($param, $action){
        switch($action){
            case 'add':
                $this->db->insert(TABLE_PREFIX.'blog_categories', $param);
                return $this->db->insert_id();
            break;

            case 'edit':
            case 'delete':
                $this->db->where('blogCatID', $param['blogCatID']);
                $this->db->update(TABLE_PREFIX.'blog_categories', $param);
                // echo $this->db->last_query();
                return $this->db->affected_rows();
            break;
        }
    }

    function updateBlogCategoryField($param, $catID){
        $this->db->where('blogCategory', $catID);
        $this->db->update(TABLE_PREFIX.'blogs', $param);
        return $this->db->affected_rows();
    }


    /* ====== Blog Methods ====== */
    function getBlogLists(){
        $this->db->select('BLG.*, COUNT(CMNT.id) AS blogTotalComments');
        $this->db->from(TABLE_PREFIX.'blogs AS BLG');
        $this->db->join(TABLE_PREFIX.'blog_comments AS CMNT','BLG.blogID = CMNT.blogID', 'left');
        $this->db->where('BLG.isDeleted', '0');
        $this->db->group_by('BLG.blogID');
        $Query = $this->db->get();

        // echo $this->db->last_query();
        $Array = $Query->result_array();
        return $Array;
    }

    function getBlogSingle($blogID){
        $this->db->select('*');
        $this->db->from(TABLE_PREFIX.'blogs');
        $this->db->where('blogID', $blogID);
        $this->db->where('isDeleted', '0');
        $Query = $this->db->get();

        //echo $this->db->last_query();
        $Array = $Query->row_array();
        return $Array;
    }

    function alterBlogDetails($param, $action){
        switch($action){
            case 'add':
                $this->db->insert(TABLE_PREFIX.'blogs', $param);
                /* echo $this->db->last_query();
                exit(); */
                return $this->db->insert_id();
            break;

            case 'edit':
            case 'delete':
                $this->db->where('blogID', $param['blogID']);
                $this->db->update(TABLE_PREFIX.'blogs', $param);
                // echo $this->db->last_query();
                return $this->db->affected_rows();
            break;
        }
    }


    /*function getCommentLists(){
        $this->db->select('CMNT.*, CONCAT_WS(" ", UBD.user_firstname, UBD.user_middlename, UBD.user_lastname) AS user_fullname, UBD.user_profile_pic, BLG.blogName');
        $this->db->from(TABLE_PREFIX.'blog_comments AS CMNT');
        $this->db->join(TABLE_PREFIX.'users_basic_details AS UBD', 'CMNT.userID = UBD.user_login_id', 'left');
        $this->db->join(TABLE_PREFIX.'blogs AS BLG', 'BLG.blogID = CMNT.blogID', 'left');
        $this->db->where('CMNT.blogID', $blogID);
        $this->db->where('CMNT.isDeleted', '0');
        $this->db->order_by('CMNT.addedOn', 'DESC');
        $Query = $this->db->get();

        //echo $this->db->last_query();
        $Array = $Query->result_array();
        return $Array;
    }*/

    function getBlogComments($blogID){
        $this->db->select('CMNT.*, CONCAT_WS(" ", UBD.user_firstname, UBD.user_middlename, UBD.user_lastname) AS user_fullname, UBD.user_profile_pic, BLG.blogName');
        $this->db->from(TABLE_PREFIX.'blog_comments AS CMNT');
        $this->db->join(TABLE_PREFIX.'users_basic_details AS UBD', 'CMNT.userID = UBD.user_login_id', 'left');
        $this->db->join(TABLE_PREFIX.'blogs AS BLG', 'BLG.blogID = CMNT.blogID', 'left');
        $this->db->where('CMNT.blogID', $blogID);
        $this->db->where('CMNT.isDeleted', '0');
        $this->db->order_by('CMNT.addedOn', 'DESC');
        $Query = $this->db->get();

        //echo $this->db->last_query();
        $Array = $Query->result_array();
        return $Array;
    }

    function getCommentLists($blogID){
        $this->db->select('CMNT.id, CMNT.comments, CMNT.addedOn, CMNT.isApproved, CONCAT_WS(" ", UBD.user_firstname, UBD.user_middlename, UBD.user_lastname) AS user_fullname, BLG.blogName, BLG.blogID');
        $this->db->from(TABLE_PREFIX.'blog_comments AS CMNT');
        $this->db->join(TABLE_PREFIX.'users_basic_details AS UBD', 'CMNT.userID = UBD.user_login_id', 'left');
        $this->db->join(TABLE_PREFIX.'blogs AS BLG', 'CMNT.blogID = BLG.blogID', 'left');
        $this->db->where('BLG.blogID', $blogID);
        $this->db->order_by('CMNT.addedOn', 'DESC');
        $Query = $this->db->get();

        // echo $this->db->last_query();
        $Array = $Query->result_array();
        return $Array;
    }

    function getCommentDetails($commentID){
        $this->db->select('CMNT.id, CMNT.comments, CMNT.addedOn, CMNT.isApproved, CONCAT_WS(" ", UBD.user_firstname, UBD.user_middlename, UBD.user_lastname) AS user_fullname, BLG.blogName, BLG.blogID');
        $this->db->from(TABLE_PREFIX.'blog_comments AS CMNT');
        $this->db->join(TABLE_PREFIX.'users_basic_details AS UBD', 'CMNT.userID = UBD.user_login_id', 'left');
        $this->db->join(TABLE_PREFIX.'blogs AS BLG', 'CMNT.blogID = BLG.blogID', 'left');
        $this->db->where('CMNT.id', $commentID);
        $this->db->order_by('CMNT.addedOn', 'DESC');
        $Query = $this->db->get();

        // echo $this->db->last_query();
        $Array = $Query->row_array();
        return $Array;
    }


    function updateCommentDetails($param, $blogID, $commentID){
        $this->db->where('id', $commentID);
        $this->db->where('blogID', $blogID);
        $this->db->update(TABLE_PREFIX.'blog_comments', $param);
        // echo $this->db->last_query();
        return $this->db->affected_rows();
    }

    function deleteCommentDetails($blogID, $commentID) {
        $this->db->where('id', $commentID);
        $this->db->where('blogID', $blogID);
        $this->db->delete(TABLE_PREFIX.'blog_comments');
        return $this->db->affected_rows();
    }

}

?>