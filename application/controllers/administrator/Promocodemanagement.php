<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promocodemanagement extends CI_Controller {

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


    public function getpromoCode(){
		$permission = checkAuthorization('PROMOCODE','LIST');
		
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'sellrequest';
		$header['userData'] = $getUserData;

		$data['result'] = $this->admin_model->getPromoCode([]);
		$sitesettings = $this->admin_model->getSiteSettings();
		$currencyDetails = $this->admin_model->getCurrencies($sitesettings['currency']);
		$data['currency'] = $currencyDetails[0]['symbol'];
		$data['editpermission'] = checkAuthorization('PROMOCODE','EDIT');
		$data['deletepermission'] = checkAuthorization('PROMOCODE','DELETE');
		$data['addpermission'] = checkAuthorization('PROMOCODE','ADD');
        $this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/promo-code',$data);
		else	
		$this->load->view('backend/unauthorized');
		
		$this->load->view('backend/includes/footer');
	}
	
	public function addpromoCode(){
		$permission = checkAuthorization('PROMOCODE','ADD');
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'sellrequest';
		$header['userData'] = $getUserData;
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/promo-code-add');
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}
	public function editpromoCode($id){
		$permission = checkAuthorization('PROMOCODE','EDIT');
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'sellrequest';
		$header['userData'] = $getUserData;
		$arr['id'] = $id;
		$data['result'] = $this->admin_model->getPromoCode($arr);
		
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/promo-code-add',$data);
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}
	public function alterpromoCode(){
		$codeTitle=$this->input->post('codeTitle');
		//$title_slug = setCuratedSlug(create_url_slug(trim($this->input->post('title'))));
		$discountType=$this->input->post('discountType');
		$amount=$this->input->post('amount');

		$this->form_validation->set_rules('codeTitle', 'Code Title', 'trim|required');
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric');
		$this->form_validation->set_rules('discountType', 'discountType', 'trim|required');

		if($this->form_validation->run() == FALSE)
        {
            $data = array(
			  'error' => validation_errors(),
			  'errorCode'=>1
			);
			
			$this->session->set_flashdata($data);
			redirect(base_url().'administrator/promo-code/add');
		}
		if($this->input->post('promocodeId') > 0)
		{
			$arr['id']=$this->input->post('promocodeId');
			$action = 'edit';
		}else{
			$action = 'add';
		}
		$amount = $this->input->post('amount');
		if($this->input->post('discountType') == 'Percentage' && $amount>100)
		{
			$amount = 100;
		}
		$arr['promocode']=$this->input->post('codeTitle');
		$arr['discount_type']=$this->input->post('discountType');
		$arr['discount']=$this->input->post('amount');
		$arr['section']='SELL';
		$arr['validity']=$this->input->post('Validity');
		$arr['date_from']=$this->input->post('dateFrom');
		$arr['date_to']=$this->input->post('dateTo');
		$this->admin_model->alterPromoCode($arr,$action);

		if($action == 'add')
		{
			$this->session->set_flashdata('success', 'Promo code added successfully!');
		}elseif($action == 'edit')
		{
			$this->session->set_flashdata('success', 'Promo code edited successfully!');
		}
		redirect('administrator/promo-code'); 
	}

	public function deletepromoCode($id){
		$permission = checkAuthorization('PROMOCODE','DELETE');
		$arr['status']=2;
		$arr['id']=$id;
		$action = 'edit';
		if($permission)
		{
			$this->admin_model->alterPromoCode($arr,$action);
			$this->session->set_flashdata('success', 'Promo code deleted successfully!');
			redirect('administrator/promo-code'); 
		}else{
			$header['sitetitle'] = 'ADMIN - FIH.com';
			$header['class'] = 'sellrequest';
			$header['userData'] = $getUserData;
			$this->load->view('backend/includes/header',$header);
			$this->load->view('backend/unauthorized');
			$this->load->view('backend/includes/footer');
		}
		
	}
}