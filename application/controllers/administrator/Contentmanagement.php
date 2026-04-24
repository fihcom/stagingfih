<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contentmanagement extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() 
	{
		parent::__construct();
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

    public function curatedContent(){
		$permission = checkAuthorization('CURETEDCONTENTS','LIST');
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'cms-management';
		$header['userData'] = $getUserData;
		$data['result'] = $this->admin_model->getcuratedcontent($arr);
		$data['editpermission'] = checkAuthorization('CURETEDCONTENTS','EDIT');
		$data['deletepermission'] = checkAuthorization('CURETEDCONTENTS','DELETE');
		$data['addpermission'] = checkAuthorization('CURETEDCONTENTS','ADD');
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/curated-content',$data);
		else
		$this->load->view('backend/unauthorized',$data);
		$this->load->view('backend/includes/footer');
	}
	public function addcuratedContent(){
		$permission = checkAuthorization('CURETEDCONTENTS','ADD');
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'cms-management';
		$header['userData'] = $getUserData;
		if($permission)
		$this->load->view('backend/includes/header',$header);
		else
		$this->load->view('backend/unauthorized',$data);
		if($permission)
		$this->load->view('backend/add-curated-content',$data);
		else
		$this->load->view('backend/unauthorized',$data);
		$this->load->view('backend/includes/footer');
	}

	public function addcuratedImage(){
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
	public function altercuratedContent()
	{
		$title=$this->input->post('title');
		$title_slug = setCuratedSlug(create_url_slug(trim($this->input->post('title'))));
		$description=$this->input->post('description');
		$author=$this->input->post('author');
		$image=$this->input->post('imageContents');

		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('imageContents', 'Image', 'trim|required');
		$this->form_validation->set_rules('author', 'Author', 'trim|required');

		if($this->form_validation->run() == FALSE)
        {
            $data = array(
			  'error' => validation_errors(),
			  'errorCode'=>1
			);
			
			$this->session->set_flashdata($data);
			redirect(base_url().'administrator/curated-content/add');
		}
		if($this->input->post('contentId') > 0)
		{
			$arr['id']=$this->input->post('contentId');
			$action = 'edit';
			$arr['id'] = $arr['id'];
			$result = $this->admin_model->getcuratedcontent($arr);
			$previoustitle = $result[0]['title'];
		}else{
			$action = 'add';
		}
		$arr['title']=$this->input->post('title');
		if($arr['title'] != $previoustitle)
		{
			$arr['title_slug'] = setCuratedSlug(create_url_slug(trim($this->input->post('title'))));
		}
		$arr['description']=$this->input->post('description');
		$arr['author']=$this->input->post('author');
		$imagesArr = explode(',',$image);

		$arr['image']=json_encode($imagesArr);
		$arr['relay_to']=$this->input->post('relayType');
		$this->admin_model->altercuratedContent($arr,$action);
		if($action == 'add')
		{
			$this->session->set_flashdata('success', 'Curated Content added successfully!');
		}elseif($action == 'edit')
		{
			$this->session->set_flashdata('success', 'Curated Content edited successfully!');
		}
		redirect('administrator/curated-content'); 
	}

	public function swapcuratedContent(){
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
                        $getPageUpdate = $this->admin_model->altercuratedContent($param,'edit');
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

	public function deletecuratedContent($id){
		$permission = checkAuthorization('CURETEDCONTENTS','DELETE');
		if($permission)
		{
			$param['status'] = 2;
			$param['id'] = $id;
			$getPageUpdate = $this->admin_model->altercuratedContent($param,'edit');
			$this->session->set_flashdata('success', 'Curated Content deleted successfully!');
			redirect('administrator/curated-content'); 
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
	public function editcuratedContent($id){
		$permission = checkAuthorization('CURETEDCONTENTS','EDIT');
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'cms-management';
		$header['userData'] = $getUserData;
		$arr['id'] = $id;
		$data['result'] = $this->admin_model->getcuratedcontent($arr);
		$data['contentId'] = $id;
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/add-curated-content',$data);
		else
		$this->load->view('backend/unauthorized',$data);
		$this->load->view('backend/includes/footer');
	}

    public function downloadedContents(){
		$permission = checkAuthorization('DOWNLOADEDCONTENTS','LIST');

        $getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'cms-management';
		$header['userData'] = $getUserData;
		$data['result'] = $this->admin_model->getfreedownloadcontent($arr);
		$data['editpermission'] = checkAuthorization('DOWNLOADEDCONTENTS','EDIT');
		$data['deletepermission'] = checkAuthorization('DOWNLOADEDCONTENTS','DELETE');
		$data['addpermission'] = checkAuthorization('DOWNLOADEDCONTENTS','ADD');
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/downloaded-content',$data);
		else
		$this->load->view('backend/unauthorized');

		$this->load->view('backend/includes/footer');
    }
    
    public function adddownloadedContents(){
		$permission = checkAuthorization('DOWNLOADEDCONTENTS','ADD');
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'cms-management';
		$header['userData'] = $getUserData;
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/add-downloaded-content',$data);
		else
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
    }
    
    public function alterdownloadedContents()
	{
		$title=$this->input->post('title');
		//$title_slug = setCuratedSlug(create_url_slug(trim($this->input->post('title'))));
		$description=$this->input->post('description');
		$downloadLink=$this->input->post('downloadLink');
        $image=$this->input->post('imageContents');
        $relayType=$this->input->post('relayType');

		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('imageContents', 'Image', 'trim|required');
		$this->form_validation->set_rules('downloadLink', 'Download Link', 'trim|required');

		if($this->form_validation->run() == FALSE)
        {
            $data = array(
			  'error' => validation_errors(),
			  'errorCode'=>1
			);
			
            $this->session->set_flashdata($data);
            if($this->input->post('contentId') > 0)
            {
                redirect(base_url().'administrator/free-downloaded-contents/edit/'.$this->input->post('contentId'));
            }
			redirect(base_url().'administrator/free-downloaded-contents/add');
		}
		if($this->input->post('contentId') > 0)
		{
			$arr['id']=$this->input->post('contentId');
			$action = 'edit';
			$arr['id'] = $arr['id'];
			$result = $this->admin_model->getcuratedcontent($arr);
			$previoustitle = $result[0]['title'];
		}else{
			$action = 'add';
		}
		$arr['title']=$this->input->post('title');
		$arr['description']=$this->input->post('description');
		$arr['download_link']=$this->input->post('downloadLink');
		$imagesArr = explode(',',$image);
        $arr['image']=json_encode($imagesArr);
        $arr['reply_to']=$this->input->post('relayType');

		$this->admin_model->alterfreedownloadContent($arr,$action);
		if($action == 'add')
		{
			$this->session->set_flashdata('success', 'Free Downloaded Content added successfully!');
		}elseif($action == 'edit')
		{
			$this->session->set_flashdata('success', 'Free Downloaded Content edited successfully!');
		}
		redirect('administrator/free-downloaded-contents'); 
    }
    public function editdownloadedContents($id){
		$permission = checkAuthorization('DOWNLOADEDCONTENTS','EDIT');
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'cms-management';
		$header['userData'] = $getUserData;
		$arr['id'] = $id;
		$data['result'] = $this->admin_model->getfreedownloadcontent($arr);
		$data['contentId'] = $id;
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/add-downloaded-content',$data);
		else
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
    }
    
    public function deletedownloadedContents($id){
		$permission = checkAuthorization('DOWNLOADEDCONTENTS','DELETE');
		if($permission)
		{
			$param['status'] = 2;
			$param['id'] = $id;
			$getPageUpdate = $this->admin_model->alterfreedownloadContent($param,'edit');
			$this->session->set_flashdata('success', 'Free Downloaded Content deleted successfully!');
		}
		redirect('administrator/free-downloaded-contents'); 
	}


	//------------
	public $valuationFactors = ['AGE'=>'Age','TIME'=>'Time Commitment','TRAFFIC'=>'Traffic','REVENUE'=>'Revenue Channels','PROFITRATIO'=>'Ratio of Revenue to Profit','FOLLOWERS'=>'Online followers','REPEATCUST'=>'Repeat customers'];
	public function valuationQuestions(){
        $getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'valuationquestion';
		$header['userData'] = $getUserData;
		$data['result'] = $this->admin_model->getvaluationquestions($arr);
		$data['valuationFactors'] = $this->valuationFactors;
		$this->load->view('backend/includes/header',$header);
		$this->load->view('backend/valuation-questions',$data);
		$this->load->view('backend/includes/footer');
    }
    
    public function addvaluationQuestions(){
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'valuationquestion';
		$header['userData'] = $getUserData;
		$data['valuationFactors'] = $this->valuationFactors;
		$this->load->view('backend/includes/header',$header);
		$this->load->view('backend/add-valuation-questions',$data);
		$this->load->view('backend/includes/footer');
    }
    
    public function altervaluationQuestions()
	{
		$value_type=$this->input->post('value_type');
		$range_type=$this->input->post('range_type');
		$question=$this->input->post('question');
        $low_range=$this->input->post('low_range');
		$high_range=$this->input->post('high_range');
		$worth=$this->input->post('worth');

		$this->form_validation->set_rules('value_type', 'Value', 'trim|required');
		$this->form_validation->set_rules('range_type', 'Range', 'trim|required');
		$this->form_validation->set_rules('question', 'Question', 'trim|required');
		$this->form_validation->set_rules('low_range', 'Range From', 'trim|required');
		$this->form_validation->set_rules('high_range', 'Range To', 'trim|required');
		$this->form_validation->set_rules('worth', 'Worth', 'trim|required');

		if($this->form_validation->run() == FALSE)
        {
            $data = array(
			  'error' => validation_errors(),
			  'errorCode'=>1
			);
			
            $this->session->set_flashdata($data);
            if($this->input->post('contentId') > 0)
            {
                redirect(base_url().'administrator/valuation_questions/edit/'.$this->input->post('contentId'));
            }
			redirect(base_url().'administrator/valuation_questions/add');
		}
		if($this->input->post('contentId') > 0)
		{
			$arr['id']=$this->input->post('contentId');
			$action = 'edit';
			$arr['id'] = $arr['id'];
			$result = $this->admin_model->getcuratedcontent($arr);
			$previoustitle = $result[0]['title'];
		}else{
			$action = 'add';
		}
		$arr['value_type']=$this->input->post('value_type');
		$arr['range_type']=$this->input->post('range_type');
		$arr['question']=$this->input->post('question');
		$arr['low_range']=$this->input->post('low_range');
		$arr['high_range']=$this->input->post('high_range');
        $arr['worth']=$this->input->post('worth');
		$arr['factor']=$this->input->post('factor');
		$this->admin_model->altervaluationQuestions($arr,$action);
		if($action == 'add')
		{
			$this->session->set_flashdata('success', 'Valuation Questions added successfully!');
		}elseif($action == 'edit')
		{
			$this->session->set_flashdata('success', 'Valuation Questions edited successfully!');
		}
		redirect('administrator/valuation_questions'); 
    }
	public function editvaluationQuestions($id)
	{
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'valuationquestion';
		$header['userData'] = $getUserData;
		$arr['id'] = $id;
		$data['result'] = $this->admin_model->getvaluationquestions($arr);
		$data['contentId'] = $id;
		$data['valuationFactors'] = $this->valuationFactors;
		$this->load->view('backend/includes/header',$header);
		$this->load->view('backend/add-valuation-questions',$data);
		$this->load->view('backend/includes/footer');
    }
    
    public function deletevaluationQuestions($id){
		$param['status'] = 2;
		$param['id'] = $id;

		$getPageUpdate = $this->admin_model->altervaluationQuestions($param,'edit');
		$this->session->set_flashdata('success', 'Valuation Questions deleted successfully!');
		redirect('administrator/valuation_questions'); 
	}
	public function swapvaluationQuestions(){
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
                        $getPageUpdate = $this->admin_model->altervaluationQuestions($param,'edit');
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

	public function getSupportticket(){
		
	}


}