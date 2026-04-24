<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Adminbloginfo extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('admin_blog_model');
        $this->load->model('admin_model');
		$this->load->model('user_model');
		$this->load->model('front_model');
		$this->load->library(array('form_validation', "upload"));
		if($this->session->userdata('roleText') != 'admin'){
            redirect(base_url().'administrator/login');
            exit();
        }
        if($this->session->userdata('isLoggedIn') != TRUE){
            redirect(base_url().'administrator/login');
            exit();
        }
    }




    /* ====================================== Blog Categories management=================*/

    public function Blogcategories(){
        $permission = checkAuthorization('BLOGCAT','LIST');
        $baseInfo['pageTitle'] = 'Blog Categories - FIH.com';
        $baseInfo['last_login'] = $this->session->userdata('lastLogin');
        $baseInfo['name'] = $this->session->userdata('name');
        $baseInfo['role_text'] = $this->session->userdata('role_text');
        $baseInfo['class'] = 'cms-management';
        $getBlogCatLists['blog_cat_lists'] = $this->admin_blog_model->getBlogCatLists();
        $baseInfo['cat_count'] = count($getCatLists['cat_lists']);
        $getBlogCatLists['editpermission'] = checkAuthorization('BLOGCAT','EDIT');
		$getBlogCatLists['deletepermission'] = checkAuthorization('BLOGCAT','DELETE');
		$getBlogCatLists['addpermission'] = checkAuthorization('BLOGCAT','ADD');

        $this->load->view('backend/includes/header', $baseInfo);
        if($permission)
        $this->load->view('backend/admin-blog-categories', $getBlogCatLists);
        else	
		$this->load->view('backend/unauthorized');
        $this->load->view('backend/includes/footer');
     
    }


    public function addBlogCategory(){
        $permission = checkAuthorization('BLOGCAT','ADD');
        $baseInfo['pageTitle'] = 'Add Blog Categories - FIH.com';
        $baseInfo['last_login'] = $this->session->userdata('lastLogin');
        $baseInfo['name'] = $this->session->userdata('name');
        $baseInfo['role_text'] = $this->session->userdata('role_text');
        $baseInfo['class'] = 'cms-management';
        $baseInfo['sub_class'] = 'blog-category-list';

        // Add blog parent category
        $getParentCats['parent_cats'] = $this->admin_blog_model->getBlogParentCategories();

        $this->load->view('backend/includes/header', $baseInfo);
        if($permission)
        $this->load->view('backend/admin-alter-blog-categories', $getParentCats);
        else	
		$this->load->view('backend/unauthorized');

        $this->load->view('backend/includes/footer');
    }


    public function editBlogCategory($ID){
        if($ID != ""){
            $permission = checkAuthorization('BLOGCAT','EDIT');
            $baseInfo['pageTitle'] = 'Edit Blog Categories - FIH.com';
            $baseInfo['last_login'] = $this->session->userdata('lastLogin');
            $baseInfo['name'] = $this->session->userdata('name');
            $baseInfo['role_text'] = $this->session->userdata('role_text');
            $baseInfo['class'] = 'cms-management';
            $baseInfo['sub_class'] = 'blog-category-list';
            $adminID = $this->session->userdata('userId');
            $getBlogCatDetails['parent_cats'] = $this->admin_blog_model->getBlogParentCategories($ID);
            $getBlogCatDetails['blogCatDetails'] = $this->admin_blog_model->getBlogCatSingle($ID);
           
            $this->load->view('backend/includes/header', $baseInfo);
            if($permission)
            $this->load->view('backend/admin-alter-blog-categories', $getBlogCatDetails);
            else	
		    $this->load->view('backend/unauthorized');
            $this->load->view('backend/includes/footer');
        } else {
            redirect('administrator/listcategories');
        }
    }

    public function alterBlogCatDetails(){
        
    	$blogCatName = trim(strip_tags($this->input->post('blogCatName')));
    	$blogCatStatus = trim(strip_tags($this->input->post('blogCatStatus')));
    	$addedBy = $this->session->userdata('userId');

    	$this->form_validation->set_rules('blogCatName', 'Category Title', 'required', 'Title is required');
        $this->form_validation->set_rules('blogCatStatus', 'Category Status', 'required', 'Status is required');

        if ($this->form_validation->run() == FALSE) {
        	$data = array(
              'error' => validation_errors()
            );
            $this->session->set_flashdata($data);
            redirect('administrator/blog-categories');
        } else {
        	$param = [];

	        $param['blogCatName'] = $this->input->post('blogCatName');
	        $param['blogCatStatus'] = $this->input->post('blogCatStatus');
	        $param['addedBy'] = $this->session->userdata('userId');

	        $action = $this->input->post('action');

	        switch($action){
	            case 'add':
	                # code...
	                $param['blogCatSlug'] = setBlogCatSlug(create_url_slug($param['blogCatName']));
	                $successMessage = 'Category has been added!!!!';
	                $errorMessage = "Category hasn't been added!!!!";
	            break;

	            case 'edit':
	                # code...
	                $param['modifiedOn'] = date('Y-m-d H:i:s');
	                $param['blogCatID'] = trim(strip_tags($this->input->post('blogCatID')));

	                $successMessage = 'Category has been updated!!!!';
	                $errorMessage = "Category hasn't been updated!!!!";
	            break;
	        }

	        $getActionDetails = $this->admin_blog_model->actionBlogCatDetails($param, $action);
	        
	        if($getActionDetails != 0){ 
	            $this->session->set_flashdata('success', $successMessage);
	        } else {
	            $this->session->set_flashdata('error', $errorMessage);
	        }

	        redirect('administrator/blog-categories');
	    }
    }

    public function deleteCategory($catID){
        $permission = checkAuthorization('BLOGCAT','DELETE');
        if($permission)
        {
            $param['blogCatID'] = $catID;
            $param['isDeleted'] = '1';
            $getActionDetails = $this->admin_blog_model->actionBlogCatDetails($param, 'edit');


            $successMessage = 'Category has been deleted.';
            $errorMessage = "Category hasn't been deleted.";

            if($getActionDetails != 0){ 
                $param1['blogCategory'] = '0';

                $this->admin_blog_model->updateBlogCategoryField($param1, $catID);
                $this->session->set_flashdata('success', $successMessage);
            } else {
                $this->session->set_flashdata('error', $errorMessage);
            }
        }
        redirect('administrator/blog-categories');
    }
    /* ======================================= Category Management ends ================================================ */

    /* ====== Blog Management Starts ====== */
    public function listblogs(){
        $permission = checkAuthorization('BLOG','LIST');
        $baseInfo['pageTitle'] = 'Blogs - FIH.com';
        $baseInfo['class'] = 'cms-management';
        $baseInfo['last_login'] = $this->session->userdata('lastLogin');
        $baseInfo['name'] = $this->session->userdata('name');
        $baseInfo['role_text'] = $this->session->userdata('role_text');
        $getBlogLists['blogLists'] = $this->admin_blog_model->getBlogLists();
        $getBlogLists['editpermission'] = checkAuthorization('BLOG','EDIT');
		$getBlogLists['deletepermission'] = checkAuthorization('BLOG','DELETE');
		$getBlogLists['addpermission'] = checkAuthorization('BLOG','ADD');
        
        $this->load->view('backend/includes/header', $baseInfo);
        if($permission)
        $this->load->view('backend/admin-list-blogs', $getBlogLists);
        else	
		$this->load->view('backend/unauthorized');
        
        $this->load->view('backend/includes/footer');
    }

    public function addBlog(){
        $permission = checkAuthorization('BLOG','ADD');
        $baseInfo['pageTitle'] = 'Add Blog - FIH.com';
        $baseInfo['class'] = 'cms-management';
        $baseInfo['last_login'] = $this->session->userdata('lastLogin');
        $baseInfo['name'] = $this->session->userdata('name');
        $baseInfo['role_text'] = $this->session->userdata('role_text');
        
        $getBlogDetails['blogCatDetails'] = $this->admin_blog_model->getBlogCatLists();
        
        $this->load->view('backend/includes/header', $baseInfo);
        if($permission)
        $this->load->view('backend/admin-alter-blog', $getBlogDetails);
        else	
		$this->load->view('backend/unauthorized');
        $this->load->view('backend/includes/footer');
    }

    public function editBlog($blogID){
        if($blogID != ""){
            $permission = checkAuthorization('BLOG','EDIT');
            $baseInfo['pageTitle'] = 'Edit Blog - Lux Life Cars ADMIN';
            $baseInfo['class'] = 'cms-management';
            $baseInfo['last_login'] = $this->session->userdata('lastLogin');
            $baseInfo['name'] = $this->session->userdata('name');
            $baseInfo['role_text'] = $this->session->userdata('role_text');
            $adminID = $this->session->userdata('userId');
            $getBlogDetails['blogCatDetails'] = $this->admin_blog_model->getBlogCatLists();
            $getBlogDetails['blog_details'] = $this->admin_blog_model->getBlogSingle($blogID);

            $this->load->view('backend/includes/header', $baseInfo);
            if($permission)
            $this->load->view('backend/admin-alter-blog', $getBlogDetails);
            else	
		    $this->load->view('backend/unauthorized');
            $this->load->view('backend/includes/footer');
        } else {
            redirect('administrator/listblogs');
        }
    }

    public function deleteBlog($blogID){
        $permission = checkAuthorization('BLOG','DELETE');
        if($permission)
        {

        
        $param['isDeleted'] = '1';
        $param['blogID'] = $blogID;

        $successMessage = '<p class="success-msg">Blog has been deleted!!!</p>';
        $errorMessage = '<p class="error-msg">Blog has not been deleted!!!</p>';

        $getResult = $this->admin_blog_model->alterBlogDetails($param, 'delete');

        if($getResult != 0){
            $this->session->set_flashdata('success', $successMessage);
        } else {
            $this->session->set_flashdata('error', $errorMessage);
        }
    }
        redirect('administrator/blogs');

    }

    public function alterBlogDetails(){

        $param['blogName'] = trim(strip_tags($this->input->post('blogName')));
        $param['blogCategory'] = trim(strip_tags($this->input->post('blogCategory')));
        $param['blogDescription'] = trim($this->input->post('blogDescription'));
        $param['blog_author'] = trim($this->input->post('blog_author'));
        $param['blogStatus'] = trim(strip_tags($this->input->post('blogStatus')));
        $param['blogImage'] = trim(strip_tags($this->input->post('imageContents')));
        
        $this->form_validation->set_rules('blogName', 'Blog Title', 'required', 'Title is required');
        $this->form_validation->set_rules('blogCategory', 'Blog Category', 'required', 'Category is required');
        $this->form_validation->set_rules('blogDescription', 'Blog Description', 'required', 'Description is required');
        $this->form_validation->set_rules('blogStatus', 'Blog Status', 'required', 'Status is required');

        if ($this->form_validation->run() == FALSE) {
        	$data = array(
              'error' => validation_errors()
            );
            $this->session->set_flashdata($data);
        } else {
        	
	        $action = $this->input->post('action');
	        switch($action){
	            case 'add':
	                $param['blogSlug'] = setBlogSlug(create_url_slug($this->input->post('blogName')));
	                $successMessage = '<p class="success-msg">Blog has been added!!!</p>';
	                $errorMessage = '<p class="error-msg">Blog has not been added!!!</p>';
	            break;

	            case 'edit':
	                $param['blogID'] = $this->input->post('blogID');
	                $param['modifiedOn'] = date('Y-m-d H:i:s');
	                $successMessage = '<p class="success-msg">Blog has been updated!!!</p>';
	                $errorMessage = '<p class="error-msg">Blog has not been updated!!!</p>';
	            break;
	        }
	        $getResult = $this->admin_blog_model->alterBlogDetails($param, $action);

	        if($getResult != 0){
	            $this->session->set_flashdata('success', $successMessage);
	        } else {
	            $this->session->set_flashdata('error', $errorMessage);
	        }

	        redirect('administrator/blogs');
	    }
    }

    public function addblogImage(){
		$sess_data = array();
        if(!empty($_FILES['file']['name'])){
            
            $adminID = $this->session->userdata('user_id');
            
            $uploadPath = "./uploads/images_blog/";
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            //Load upload library
            $this->load->library('upload',$config); 
			// File upload
			if($this->upload->do_upload('file')){
				$fileData = $this->upload->data();
				$editArray['user_profile_pic'] = ($fileData) ? $fileData['file_name'] : '';
				//$getResult = $this->front_model->updateAdminDetails($editArray, $adminID);
			}
            
		}
		echo $fileData['file_name'];
	}


    /* ====== Comments Section ====== */

    public function listComments($blogID){
        $blogDetails = $this->admin_blog_model->getBlogSingle($blogID);
        $baseInfo['class'] = 'cms-management';
        $baseInfo['pageTitle'] = 'Comments on '.$blogDetails['blogName'].' - FIH.com';
        $baseInfo['last_login'] = $this->session->userdata('lastLogin');
        $baseInfo['name'] = $this->session->userdata('name');
        $baseInfo['role_text'] = $this->session->userdata('role_text');
        $getCommentLists['commentLists'] = $this->admin_blog_model->getCommentLists($blogID);
        $this->load->view('backend/includes/header', $baseInfo);
        $this->load->view('backend/admin-list-comments', $getCommentLists);
        $this->load->view('backend/includes/footer');
    }

    public function viewComment($commentID){
        $commentDetails['commentDetails'] = $this->admin_blog_model->getCommentDetails($commentID);
        $baseInfo['class'] = 'cms-management';
        $baseInfo['pageTitle'] = 'View Comment - FIH.com';
        $baseInfo['last_login'] = $this->session->userdata('lastLogin');
        $baseInfo['name'] = $this->session->userdata('name');
        $baseInfo['role_text'] = $this->session->userdata('role_text');
        $this->load->view('backend/includes/header', $baseInfo);
        $this->load->view('backend/admin-view-comment', $commentDetails);
        $this->load->view('backend/includes/footer');
    }
    
    public function alterComment(){
        
        $param['isApproved'] = $this->input->post('isApproved');
        $blogID = $this->input->post('blogID');
        $commentID = $this->input->post('commentID');

        $updateComment = $this->admin_blog_model->updateCommentDetails($param, $blogID, $commentID);

        $successMessage = '<p class="success-msg">Comment has been updated!!!</p>';
        $errorMessage = '<p class="error-msg">Comment has not been updated!!!</p>';

        if($updateComment != 0){
            $this->session->set_flashdata('success', $successMessage);
        } else {
            $this->session->set_flashdata('error', $errorMessage);
        }

        redirect('administrator/blog/comments/'.$blogID);
    }

    public function deleteComment($commentID, $blogID){

        $successMessage = '<p class="success-msg">Comment has been deleted!!!</p>';
        $errorMessage = '<p class="error-msg">Comment has not been deleted!!!</p>';

        $getResult = $this->admin_blog_model->deleteCommentDetails($blogID, $commentID);

        if($getResult != 0){
            $this->session->set_flashdata('success', $successMessage);
        } else {
            $this->session->set_flashdata('error', $errorMessage);
        }

        redirect('administrator/blog/comments/'.$blogID);

    }
}

?>