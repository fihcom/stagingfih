<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admincms extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('admin_cms_model');
        $this->load->model('admin_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', "upload"));
        $this->load->library('email');
        $config['protocol']     = PROTOCOL;
        $config['smtp_host']    = SMTP_HOST;
        $config['smtp_port']    = SMTP_PORT;
        $config['smtp_user']    = SMTP_USER;
        $config['smtp_pass']    = SMTP_PASS;
        $config['mailpath']     = MAIL_PATH;
        $config['smtp_timeout'] = SMTP_TIMEOUT;
        $config['charset']      = 'iso-8859-1';
        $config['mailtype']     = 'html'; 
        $config['wordwrap']     = 'TRUE';            
        $config['validation']   = TRUE;

        if($this->session->userdata('role') == 3){
            redirect(base_url());
            exit();
        }

        if($this->session->userdata('isLoggedIn') != TRUE){
            redirect('administrator');
        }
    }




    /* ====================================== Blog Categories management=================*/

    public function listCMSPages(){
        $permission = checkAuthorization('SITECONTENT','LIST');

        //$baseInfo['pageTitle'] = 'CMS Pages - Safsap Food ADMIN';
        $baseInfo['last_login'] = $this->session->userdata('lastLogin');
        $baseInfo['name'] = $this->session->userdata('name');
        $baseInfo['role_text'] = $this->session->userdata('role_text');
        $baseInfo['class'] = 'cms-management';
        $cmsList['cmsList'] = $this->admin_cms_model->getCMSPageLists();     
        $cmsList['editpermission'] = checkAuthorization('SITECONTENT','EDIT');
		$cmsList['deletepermission'] = checkAuthorization('SITECONTENT','DELETE');
		$cmsList['addpermission'] = checkAuthorization('SITECONTENT','ADD');

        $this->load->view('backend/includes/header', $baseInfo);
        if($permission)
        $this->load->view('backend/admin-list-cms-pages', $cmsList);
        else	
		$this->load->view('backend/unauthorized');
        $this->load->view('backend/includes/footer');
     
    }

    public function addEditCMSPages($pageID = '') {
        if($pageID == '')
        $permission = checkAuthorization('SITECONTENT','ADD');
        else
        $permission = checkAuthorization('SITECONTENT','EDIT');

        $getCMSDetails = [];
        //$baseInfo['pageTitle'] = 'Add CMS Pages - Safsap Food ADMIN';

        if($pageID != ''){
            $getCMSDetails = $this->admin_cms_model->getCMSPageDetails($pageID);
        }



        $pageSlug    = $getCMSDetails['pageSlug'];
        if($pageSlug=='add-restaurant-owner')
        {
            $get_restaurant_owner_content_details = $this->admin_cms_model->getOwnerContentDetails();
        }

        $baseInfo['last_login'] = $this->session->userdata('lastLogin');
        $baseInfo['name'] = $this->session->userdata('name');
        $baseInfo['role_text'] = $this->session->userdata('role_text');
        $baseInfo['class'] = 'cms-management';
        $cmsDetails['getPageDetails'] = $getCMSDetails;     
        $cmsDetails['get_restaurant_owner_content_details'] = $get_restaurant_owner_content_details;

        $this->load->view('backend/includes/header', $baseInfo);
        if($permission)
        $this->load->view('backend/admin-add-edit-cms-pages', $cmsDetails);
        else	
		$this->load->view('backend/unauthorized');
        $this->load->view('backend/includes/footer');
    }

    public function alterCMSPages(){

        $pageName = $this->input->post('pageName');
        $pageTitle = $this->input->post('pageTitle');
        $pageContent = addslashes($this->input->post('pageContent'));
        $pageStatus = $this->input->post('pageStatus');
        $showInMenu = $this->input->post('showInMenu');

        $sponsored_title = $this->input->post('sponsored_title');
        $sponsored_subtitle = $this->input->post('sponsored_subtitle');
        $most_viewed_title = $this->input->post('most_viewed_title');
        $most_viewed_subtitle = $this->input->post('most_viewed_subtitle');
        
        $first_content_title = $this->input->post('first_content_title');
        $first_content_description = $this->input->post('first_content_description');
        $second_content_title = $this->input->post('second_content_title');
        $second_content_description = $this->input->post('second_content_description');




        $metaTitle = $this->input->post('metaTitle');
        $metaKeyword = $this->input->post('metaKeyword');
        $metaDescription = $this->input->post('metaDescription');

        $action = $this->input->post('action');


        $param = [];

        $param['pageName'] = $pageName;
        $param['pageTitle'] = $pageTitle;
        $param['pageContent'] = $pageContent;
        $param['pageStatus'] = $pageStatus;
        $param['showInMenu'] = $showInMenu;

        $param['sponsored_title'] = $sponsored_title;
        $param['sponsored_subtitle'] = $sponsored_subtitle;
        $param['most_viewed_title'] = $most_viewed_title;
        $param['most_viewed_subtitle'] = $most_viewed_subtitle;

        $param['first_content_title'] = $first_content_title;
        $param['first_content_description'] = $first_content_description;
        $param['second_content_title'] = $second_content_title;
        $param['second_content_description'] = $second_content_description;



        $param['metaTitle'] = $metaTitle;
        $param['metaKeyword'] = $metaKeyword;
        $param['metaDescription'] = $metaDescription;
        $uploadPath = "./uploads/cms_page_images/";   
        if(is_dir($uploadPath)) {
          } else {
            mkdir($uploadPath);
          }
        if(isset($_FILES['pageImage'])){
             
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['encrypt_name'] = TRUE;

            // Load and initialize upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if($this->upload->do_upload('pageImage')){
                // Uploaded file data
                $fileData = $this->upload->data();
                // $editProfile['user_profile_pic'] = $fileData['file_name'];

                /* ====== Image Resizing to profile view box ====== */
                /*$config['image_library']  = 'gd2';
                $config['source_image']   = $uploadPath.'/'.$fileData['file_name'];
                $config['create_thumb']   = TRUE;
                $config['maintain_ratio'] = FALSE;
                $config['width']          = 564;
                $config['height']         = 408;
                $config['thumb_marker']   = '_resized';
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $this->image_lib->clear();
                */
                //$thumbfileName = str_ireplace('.', '_resized.', $fileData['file_name']);
                $featured_pic  = $fileData['file_name'];
                $param['pageFeatureImage'] = $featured_pic;
            }
        }



        if(isset($_FILES["banner_image"]["name"]) && $_FILES["banner_image"]["name"]!='') 
        {
            $file_name=$_FILES["banner_image"]["name"];
            $file_tmp=$_FILES["banner_image"]["tmp_name"];
            $ext=pathinfo($file_name,PATHINFO_EXTENSION);
            $newFileName=$this->getRandomString(10).time().".".$ext;
            move_uploaded_file($file_tmp=$_FILES["banner_image"]["tmp_name"],"./uploads/cms_page_images/banner_images/".$newFileName);
            $param['banner_image'] = $newFileName;
        }

        $param['banner_title'] = $this->input->post('banner_title');
        $param['banner_sub_title'] = $this->input->post('banner_sub_title');



        if(isset($_FILES["first_content_image"]["name"]) && $_FILES["first_content_image"]["name"]!='') 
        {
            $file_name=$_FILES["first_content_image"]["name"];
            $file_tmp=$_FILES["first_content_image"]["tmp_name"];
            $ext=pathinfo($file_name,PATHINFO_EXTENSION);
            $newFileName=$this->getRandomString(10).time().".".$ext;
            move_uploaded_file($file_tmp=$_FILES["first_content_image"]["tmp_name"],"./uploads/home_page/".$newFileName);
            $param['first_content_image'] = $newFileName;
        }


        if(isset($_FILES["second_content_image"]["name"]) && $_FILES["second_content_image"]["name"]!='') 
        {
            $file_name=$_FILES["second_content_image"]["name"];
            $file_tmp=$_FILES["second_content_image"]["tmp_name"];
            $ext=pathinfo($file_name,PATHINFO_EXTENSION);
            $newFileName=$this->getRandomString(10).time().".".$ext;
            move_uploaded_file($file_tmp=$_FILES["second_content_image"]["tmp_name"],"./uploads/home_page/".$newFileName);
            $param['second_content_image'] = $newFileName;
        }



        $content_id = $this->input->post('content_id');
        $owner_title = $this->input->post('owner_title');
        $owner_sub_title = $this->input->post('owner_sub_title');
        $owner_description = $this->input->post('owner_description');
        $owner_image = $this->input->post('owner_image');



        $add_restaurant_owner = array();
        
        switch ($action) {
            case 'add':
                # code...
                $pageSlug = setPageSlug(create_url_slug(trim($param['pageName'])));
                $add_restaurant_owner['cms_slug']=$pageSlug;
                $param['pageSlug'] = $pageSlug;
                $getPageUpdate = $this->admin_cms_model->alterCMSPages($param, 'add');
                $add_restaurant_owner['cms_id']=$getPageUpdate;
                $successMessage = 'Page has been created.';
                $errorMessage = 'Page can not be created.';

            break;

            case 'edit':
                # code...
                $add_restaurant_owner['cms_id']=$this->input->post('pageID');
                $pageSlug = setPageSlug(create_url_slug(trim($param['pageName'])));
                $add_restaurant_owner['cms_slug']=$pageSlug;
                $param['pageID'] = $this->input->post('pageID');
                $getPageUpdate = $this->admin_cms_model->alterCMSPages($param, 'edit');
                $successMessage = 'Page has been updated.';
                $errorMessage = 'Page can not be updated.';
            break;
            
            default:
                # code...
            break;
        }

        

        $id_array = $this->input->post('content_id_array');
        /*
        for($i=0;$i<count($owner_title);$i++)
        {
            if($owner_title[$i]!='')
            {
                $add_restaurant_owner['owner_title']=$owner_title[$i];
                $add_restaurant_owner['owner_sub_title']=$owner_sub_title[$i];
                $add_restaurant_owner['owner_title']=$owner_title[$i];
                $add_restaurant_owner['owner_sub_title']=$owner_sub_title[$i];
                $add_restaurant_owner['owner_description']=$owner_description[$i];
               
                if(isset($_FILES["owner_image"]["name"][$i]) && $_FILES["owner_image"]["name"][$i]!='') 
                {
                    $file_name=$_FILES["owner_image"]["name"][$i];
                    $file_tmp=$_FILES["owner_image"]["tmp_name"][$i];
                    $ext=pathinfo($file_name,PATHINFO_EXTENSION);
                    $newFileName=$this->getRandomString(10).time().".".$ext;
                    move_uploaded_file($file_tmp=$_FILES["owner_image"]["tmp_name"][$i],"./uploads/restaurant_owner/".$newFileName);
                    $add_restaurant_owner['owner_image'] = $newFileName;
                }
                if(isset($content_id[$i]) && $content_id[$i]!='')
                {
                    $this->db->where('id',$content_id[$i]);
                    $this->db->update('llctbl_owner_content',$add_restaurant_owner);
                }
                else
                {
                    $this->db->insert('llctbl_owner_content',$add_restaurant_owner);
                }
                
            }
        }
        */



        if($getPageUpdate != 0){ 
            $this->session->set_flashdata('success', $successMessage);
        } else {
            $this->session->set_flashdata('error', $errorMessage);
        }

        redirect(base_url().'administrator/cms-pages');
    }


    public function deleteCMSPages($pageID){
        $permission = checkAuthorization('SITECONTENT','DELETE');
        if($permission)
        {
            $successMessage = 'Page has been deleted.';
            $errorMessage = 'Page can not be deleted.';
            if($pageID != '') {
                $param['isDeleted'] = '1';
                $param['pageID'] = $pageID;
                $getPageUpdate = $this->admin_cms_model->alterCMSPages($param, 'delete');

                $successMessage = 'Page has been deleted.';
                $errorMessage = 'Page can not be deleted.';

                if($getPageUpdate != 0){ 
                    $this->session->set_flashdata('success', $successMessage);
                } else {
                    $this->session->set_flashdata('error', $errorMessage);
                }
            } else {
            $this->session->set_flashdata('error', $errorMessage); 
            }

            redirect(base_url().'administrator/cms-pages');
        }else{
            $baseInfo['last_login'] = $this->session->userdata('lastLogin');
            $baseInfo['name'] = $this->session->userdata('name');
            $baseInfo['role_text'] = $this->session->userdata('role_text');
            $baseInfo['class'] = 'cms-management';
            $this->load->view('backend/includes/header', $baseInfo);
            $this->load->view('backend/unauthorized');
            $this->load->view('backend/includes/footer');
        }
    }

    private function getRandomString($n) { 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
        return $randomString; 
    }


    public function deleteOwnerContent()
    {
        $content_id = $this->input->post('id');
        $this->db->where('id',$content_id);
        $this->db->delete('llctbl_owner_content');
        echo json_encode(array('message'=>'Owner Content Deleted Successsfully.'));
    }

    public function partners(){
        $permission = checkAuthorization('PARTNERS','LIST');

        $getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'cms-management';
		$header['userData'] = $getUserData;
        $data['admin_details'] = $getUserData;
        
        $data['partners'] = $this->admin_model->listpartners(0,500);
		$data['deletepermission'] = checkAuthorization('PARTNERS','DELETE');
		$data['addpermission'] = checkAuthorization('PARTNERS','ADD');
		$this->load->view('backend/includes/header',$header);
        if($permission)
		$this->load->view('backend/partners',$data);
        else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
    }

    public function partnersadd(){
        if(isset($_FILES["featured_image"]["name"]) && $_FILES["featured_image"]["name"]!='')
        {
            $file_name=$_FILES["featured_image"]["name"];
            $file_tmp=$_FILES["featured_image"]["tmp_name"];
            $ext=pathinfo($file_name,PATHINFO_EXTENSION);
            $newFileName=$this->getRandomString(10).time().".".$ext;
            move_uploaded_file($file_tmp=$_FILES["featured_image"]["tmp_name"],"./uploads/partner-image/".$newFileName);
            $editArray['partner_image'] = $newFileName;
            $editArray['partner_url'] = $this->input->post('partner_url');
            $q = "select max(U.sort) as maxsort from ".TABLE_PREFIX."partners as U where U.id>0";
            $query = $this->db->query($q);    
            $partner = $query->row();
            $editArray['sort'] = $partner->maxsort+1;
            $this->db->insert(TABLE_PREFIX.'partners', $editArray);
            $insert_id = $this->db->insert_id();
            $successMessage = 'Partners added successfully!';
            $this->session->set_flashdata('success', $successMessage);
        }
        redirect(base_url().'administrator/partners');
        exit();
    }
    public function partnerslist(){
        $draw = $_POST['draw'];
        $data['start'] = $_POST['start'];
        $data['limit'] = $_POST['length'];
        $baseInfo = $this->admin_model->listpartners($data['start'],$data['limit']);
        if(is_array($baseInfo['p']) && count($baseInfo['p'])>0)
        {
            $i = $data['start']+1;
            foreach($baseInfo['p'] as $k=>$v){
                $datares['sl_no'] = $i;
                $i++;
                $datares['image'] = '<img src="'.base_url().'uploads/partner-image/'.$v['partner_image'].'" width="100">';
                $datares['action'] = '<a class="btn btn-sm btn-danger deleteRow deleteCMS" href="javascript:void(0);" onclick=delpartner(this) datadeletehref="'.base_url().'administrator/partners/delete/'.$v['id'].'" data-type="cms" title="Delete"><i class="fa fa-trash"></i></a>';
                $datadisplay[] =  $datares;
            }
        }
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $baseInfo['totalrecord']->totalrecord,
            "recordsFiltered" => $baseInfo['totalrecord']->totalrecord,
            "token" => $this->security->get_csrf_hash(),
            "data" => $datadisplay
        );
        echo json_encode($response);
    }

    public function partnersdelete($id){
        $permission = checkAuthorization('PARTNERS','DELETE');
        if($permission)
        {
        $this->db->where('id', $id);
        $this->db->delete(TABLE_PREFIX.'partners');
        redirect(base_url().'administrator/partners');
        exit();
        }else{
            $baseInfo['last_login'] = $this->session->userdata('lastLogin');
            $baseInfo['name'] = $this->session->userdata('name');
            $baseInfo['role_text'] = $this->session->userdata('role_text');
            $baseInfo['class'] = 'cms-management';
            $this->load->view('backend/includes/header', $baseInfo);
            $this->load->view('backend/unauthorized');
            $this->load->view('backend/includes/footer');
        }

    }
    public function swappartnerPages(){
        $pageID = $this->input->get('pageId');

        if($pageID != '') {
            $pageIdArr = explode(',',$pageID);
            if(is_array($pageIdArr) && count($pageIdArr)>0)
            {
                foreach($pageIdArr as $k=>$v)
                {
                    $param = array();
                    if($v>0)
                    {
                        $param['sort'] = $k+1;
                        $param['id'] = $v;
                        $getPageUpdate = $this->admin_model->alterPartner($param);
                    }
                    
                    //
                }
            }
            
        } 
        header('Content-Type: application/json');
		echo json_encode($param);
		die;
        //redirect('administrator/cms-pages');
    }

    public function testimonials(){
        $permission = checkAuthorization('TESTIMONIALS','LIST');
        $getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'cms-management';
		$header['userData'] = $getUserData;
        $data['admin_details'] = $getUserData;
        $testimonials = $this->admin_model->gettestimonialcontent([]);
        $data['result'] = $testimonials[0];
        $data['editpermission'] = checkAuthorization('TESTIMONIALS','EDIT');
		$data['deletepermission'] = checkAuthorization('TESTIMONIALS','DELETE');
		$data['addpermission'] = checkAuthorization('TESTIMONIALS','ADD');

		$this->load->view('backend/includes/header',$header);
        if($permission)
		$this->load->view('backend/testimonials',$data);
        else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
    }
    public function addtestimonialContent(){
        $permission = checkAuthorization('TESTIMONIALS','ADD');
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'cms-management';
		$header['userData'] = $getUserData;
		$this->load->view('backend/includes/header',$header);
        if($permission)
		$this->load->view('backend/add-testimonial',$data);
        else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
    }
    public function altertestimonialContent()
	{
		$desingation=$this->input->post('desingation');
		$description=$this->input->post('description');
		$author=$this->input->post('author');

		$this->form_validation->set_rules('desingation', 'Designation', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('author', 'Author', 'trim|required');

		if($this->form_validation->run() == FALSE)
        {
            $data = array(
			  'error' => validation_errors(),
			  'errorCode'=>1
			);
			
			$this->session->set_flashdata($data);
			redirect(base_url().'administrator/testimonial/add');
		}
		if($this->input->post('testimonialId') > 0)
		{
			$arr['id']=$this->input->post('testimonialId');
			$action = 'edit';
			$arr['id'] = $arr['id'];
			$result = $this->admin_model->gettestimonialcontent($arr);
			$previoustitle = $result[0]['title'];
		}else{
			$action = 'add';
		}
		$arr['description']=$this->input->post('description');
        $arr['author']=$this->input->post('author');
        $arr['designation']=$this->input->post('desingation');
		$this->admin_model->altertestimonialContent($arr,$action);
		if($action == 'add')
		{
			$this->session->set_flashdata('success', 'Testimonial added successfully!');
		}elseif($action == 'edit')
		{
			$this->session->set_flashdata('success', 'Testimonial edited successfully!');
		}
		redirect('administrator/testimonials'); 
    }
    
    public function swaptestimonialContent(){
        $pageID = $this->input->get('pageId');

        if($pageID != '') {
            $pageIdArr = explode(',',$pageID);
            if(is_array($pageIdArr) && count($pageIdArr)>0)
            {
                foreach($pageIdArr as $k=>$v)
                {
                    $param = array();
                    if($v>0)
                    {
                        $param['sort'] = $k+1;
                        $param['id'] = $v;
                        $getPageUpdate = $this->admin_model->altertestimonialContent($param,'edit');
                    }
                    
                    //
                }
            }
            
        } 
        header('Content-Type: application/json');
		echo json_encode($pageID);
		die;
        //redirect('administrator/cms-pages');
    }

    public function edittestimonialContent($id){
        $permission = checkAuthorization('TESTIMONIALS','EDIT');
        $getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'testimonials';
		$header['userData'] = $getUserData;
        $arr['id'] = $id;
        //$arr['id'] = $arr['id'];
		$data['result'] = $this->admin_model->gettestimonialcontent($arr);
		$data['contentId'] = $id;
		$this->load->view('backend/includes/header',$header);
        if($permission)
		$this->load->view('backend/add-testimonial',$data);
        else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
    }

    public function deletetestimonialContent($id){
        $permission = checkAuthorization('TESTIMONIALS','DELETE');
        if($permission)
        {
            $param['status'] = 2;
            $param['id'] = $id;
            $getPageUpdate = $this->admin_model->altertestimonialContent($param,'edit');
            $this->session->set_flashdata('success', 'Testimonial deleted successfully!');
            redirect('administrator/testimonials'); 
        }else{
            $baseInfo['last_login'] = $this->session->userdata('lastLogin');
            $baseInfo['name'] = $this->session->userdata('name');
            $baseInfo['role_text'] = $this->session->userdata('role_text');
            $baseInfo['class'] = 'cms-management';
            $this->load->view('backend/includes/header', $baseInfo);
            $this->load->view('backend/unauthorized');
            $this->load->view('backend/includes/footer');
        }
    }

    public function homecomponents(){
        $permission = checkAuthorization('HOMECONTENTS','LIST');
        $getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'cms-management';
		$header['userData'] = $getUserData;
        $arr['id'] = $id;
        //$arr['id'] = $arr['id'];
        $data['result'] = $this->admin_model->gethomecontent();
        $data['editpermission'] = checkAuthorization('HOMECONTENTS','EDIT');
        $resultsub = $this->admin_model->getsubhomecontentDetails();
        // print '<pre>';
        // print_r($data['result']);
        // die;
        if(is_array($resultsub) && count($resultsub)>0)
        {
            foreach($resultsub as $val)
            {
                if($val['section'] == 'BUYER')
                {
                    $data['buyerData'] = $val;
                }elseif($val['section'] == 'SELLER')
                {
                    $data['sellerData'] = $val;
                }elseif($val['section'] == 'GENERAL')
                {
                    $data['generalData'] = $val;
                }

            }
        }
        
        //$home = ["data"=>'test',"tags"=>[["data1"=>"test1"]]];
        //echo json_encode($home);
        //die;
		$data['contentId'] = $id;
		$this->load->view('backend/includes/header',$header);
        if($permission)
		$this->load->view('backend/add-home-contents',$data);
        else
        $this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
    }

    public function alterhomecomponents(){
        /*print '<pre>';
        print_r($_POST);
        die;*/
        $arr['id'] = $this->input->post('homecontentid');
        $section = $this->input->post('section');
        
        if($arr['id'] > 0)
        {
            $action = 'edit';
        }else{
            $action = 'add';
        }
        if($section == 'seller')
        {
            $arrb['image'] = $this->input->post('imageContentsSeller');
            $arrb['title'] = $this->input->post('seller_title');
            $arrb['short_description'] = $this->input->post('seller_short_description');
            $arrb['long_description'] = $this->input->post('seller_long_description');

            
            $titlestepbuyer = $this->input->post('titlestepseller[]');
            $descriptstepseller = $this->input->post('descriptionstepseller[]');
            
            $i = 0;
            while($titlestepbuyer[$i])
            {
                if($titlestepbuyer[$i]!='')
                {
                    $subcontentarr[$i] = [$titlestepbuyer[$i],$descriptstepseller[$i]];
                }
                $i++;
            }
            $seller = $this->admin_model->setsubhomecontent($arrb,$subcontentarr,'SELLER');
        }elseif($section == 'buyer')
        {   
            $arrb['image'] = $this->input->post('imageContentsBuyer');
            $arrb['title'] = $this->input->post('howitworks_title_buyer');
            $arrb['short_description'] = $this->input->post('howitworks_description_short_buyer');
            $arrb['long_description'] = $this->input->post('howitworks_description_long_buyer');

            
            $titlestepbuyer = $this->input->post('titlestepbuyer[]');
            $descriptstepbuyer = $this->input->post('descriptstepbuyer[]');
            
            $i = 0;
            while($titlestepbuyer[$i])
            {
                if($titlestepbuyer[$i]!='')
                {
                    $subcontentarr[$i] = [$titlestepbuyer[$i],$descriptstepbuyer[$i]];
                }
                $i++;
            }
            $buyer = $this->admin_model->setsubhomecontent($arrb,$subcontentarr,'BUYER');
        }elseif($section == 'general')
        {
            //$arr['general_title'] = $this->input->post('general_title');
            //$arr['general_description'] = $this->input->post('general_description');
            $arrb['image'] = $this->input->post('imageContentsGeneral');
            $arrb['title'] = $this->input->post('general_title');
            $arrb['short_description'] = $this->input->post('general_description');
            //$arrb['long_description'] = $this->input->post('seller_long_description');

            
            $titlestepbuyer = $this->input->post('titlestepgeneral[]');
            $descriptstepseller = $this->input->post('descriptionstepgeneral[]');
            
            $i = 0;
            while($titlestepbuyer[$i])
            {
                if($titlestepbuyer[$i]!='')
                {
                    $subcontentarr[$i] = [$titlestepbuyer[$i],$descriptstepseller[$i]];
                }
                $i++;
            }
            $seller = $this->admin_model->setsubhomecontent($arrb,$subcontentarr,'GENERAL');
        }else{
            $arr['content'] = $this->input->post('content');
            $arr['npb_title1'] = $this->input->post('site_title1');
            $arr['npb_description1'] = $this->input->post('description1');

            $arr['npb_title2'] = $this->input->post('site_title2');
            $arr['npb_description2'] = $this->input->post('description2');

            $arr['npb_title3'] = $this->input->post('site_title3');
            $arr['npb_description3'] = $this->input->post('description3');
            $this->admin_model->sethomecontents($arr,$action);
        }
        
        $this->session->set_flashdata('success', 'Content updated successfully!');
		redirect('administrator/homecontents'); 

    }

    public function alterbannercomponents(){
        $section = $this->input->post('action');
        $arr = $this->input->post();
        $this->admin_model->alertbanner($arr,$section);
        $this->session->set_flashdata('success', 'Content updated successfully!');
		redirect('administrator/banners'); 

    }

    public function addhomeImage(){
		$sess_data = array();
        if(!empty($_FILES['file']['name'])){
            
            $adminID = $this->session->userdata('user_id');
            
            $uploadPath = "./uploads/images_extra/";
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            //Load upload library
            $this->load->library('upload',$config); 
			// File upload
			if($this->upload->do_upload('file')){
				$fileData = $this->upload->data();
				//$editArray['user_profile_pic'] = ($fileData) ? $fileData['file_name'] : '';
				//$getResult = $this->front_model->updateAdminDetails($editArray, $adminID);
			}
            
		}
		echo $fileData['file_name'];
	}

    public function addbannerImage(){
		$sess_data = array();
        if(!empty($_FILES['file']['name'])){
            
            $adminID = $this->session->userdata('user_id');
            
            $uploadPath = "./uploads/banner_images/";
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            //Load upload library
            $this->load->library('upload',$config); 
			// File upload
			if($this->upload->do_upload('file')){
				$fileData = $this->upload->data();
				//$editArray['user_profile_pic'] = ($fileData) ? $fileData['file_name'] : '';
				//$getResult = $this->front_model->updateAdminDetails($editArray, $adminID);

                $configresize['image_library'] = 'gd2';
                $configresize['source_image'] = './uploads/banner_images/'.$fileData['file_name'];
                $configresize['new_image'] = './uploads/banner_images/resized/'.$fileData['file_name'];
                $configresize['create_thumb'] = false;
                $configresize['maintain_ratio'] = TRUE;
                $configresize['width'] = 1600;
                $configresize['height'] = 654;
                $this->load->library('image_lib', $configresize);
                $this->image_lib->resize();
                // handle if there is any problem
                if ( ! $this->image_lib->resize()){
                    //echo $this->image_lib->display_errors();
                    
                }else{
                    echo $fileData['file_name'];
                }
			}
            
		}
		
	}
    public function addbannerImageInner(){
		$sess_data = array();
        if(!empty($_FILES['file']['name'])){
            
            $adminID = $this->session->userdata('user_id');
            
            $uploadPath = "./uploads/banner_images/";
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            //Load upload library
            $this->load->library('upload',$config); 
			// File upload
			if($this->upload->do_upload('file')){
				$fileData = $this->upload->data();
				//$editArray['user_profile_pic'] = ($fileData) ? $fileData['file_name'] : '';
				//$getResult = $this->front_model->updateAdminDetails($editArray, $adminID);

                $configresize['image_library'] = 'gd2';
                $configresize['source_image'] = './uploads/banner_images/'.$fileData['file_name'];
                $configresize['new_image'] = './uploads/banner_images/resized/'.$fileData['file_name'];
                $configresize['create_thumb'] = false;
                $configresize['maintain_ratio'] = TRUE;
                $configresize['width'] = 1600;
                $configresize['height'] = 312;
                $this->load->library('image_lib', $configresize);
                $this->image_lib->resize();
                // handle if there is any problem
                if ( ! $this->image_lib->resize()){
                    //echo $this->image_lib->display_errors();
                    
                }else{
                    echo $fileData['file_name'];
                }
			}
            
		}
		
	}

    public function bannerscomponents()
    {
        $permission = checkAuthorization('HOMECONTENTS','LIST');
        $getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'cms-management';
		$header['userData'] = $getUserData;
        $arr['id'] = $id;
        //$arr['id'] = $arr['id'];
        $data['result'] = $this->admin_model->getbanners();
        
        $data['editpermission'] = checkAuthorization('HOMECONTENTS','EDIT');
        //$resultsub = $this->admin_model->getsubhomecontentDetails();
        
        
        //$home = ["data"=>'test',"tags"=>[["data1"=>"test1"]]];
        //echo json_encode($home);
        //die;
		$data['contentId'] = $id;
		$this->load->view('backend/includes/header',$header);
        if($permission)
		$this->load->view('backend/add-banner-contents',$data);
        else
        $this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
    }

    

}
?>