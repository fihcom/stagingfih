<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitesettings extends CI_Controller {
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

    public function siteSettingsDisplay(){
		$permission = checkAuthorization('BASICSETTINGS','LIST');
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'site-settings';
		$header['userData'] = $getUserData;

		$getSiteDetails['siteSettings'] = $this->admin_model->getSiteSettings(1);
		$getSiteDetails['getCurrency'] = $this->admin_model->getCurrencies();
		$getSiteDetails['editpermission'] = checkAuthorization('BASICSETTINGS','EDIT');
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/admin-site-settings',$getSiteDetails);
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}

	public function siteSettingsAction(){
		$searchArr['site_title'] = $this->security->xss_clean($this->input->post('site_title'));
		$searchArr['currency'] = $this->security->xss_clean($this->input->post('currency'));
		$searchArr['paypal_email'] = $this->security->xss_clean($this->input->post('paypalemail'));
		$searchArr['wire_transfer_details'] = $this->security->xss_clean($this->input->post('wire_transfer_details'));

		$searchArr['wire_bank_name'] = $this->security->xss_clean($this->input->post('wire_bank_name'));
		$searchArr['wire_bank_address'] = $this->security->xss_clean($this->input->post('wire_bank_address'));
		$searchArr['wire_swift_code'] = $this->security->xss_clean($this->input->post('wire_swift_code'));
		$searchArr['wire_credit_account_name'] = $this->security->xss_clean($this->input->post('wire_credit_account_name'));
		$searchArr['wire_aba_routing'] = $this->security->xss_clean($this->input->post('wire_aba_routing'));

		$searchArr['wire_credit_account_no'] = $this->security->xss_clean($this->input->post('wire_credit_account_no'));
		$searchArr['wire_beneficiary_address'] = $this->security->xss_clean($this->input->post('wire_beneficiary_address'));
		$searchArr['wire_additional_info'] = $this->security->xss_clean($this->input->post('wire_additional_info'));



		$searchArr['helpline_no'] = $this->security->xss_clean($this->input->post('helpline_no'));
		$searchArr['helpline_email_address'] = $this->security->xss_clean($this->input->post('helpline_email_address'));
		$searchArr['support_email_address'] = $this->security->xss_clean($this->input->post('support_email_address'));
		$searchArr['address'] = $this->security->xss_clean($this->input->post('address'));
		$searchArr['facebook_link'] = $this->security->xss_clean($this->input->post('facebook_link'));
		$searchArr['twitter_link'] = $this->security->xss_clean($this->input->post('twitter_link'));
		$searchArr['instagram_link'] = $this->security->xss_clean($this->input->post('instagram_link'));
		$searchArr['youtube_link'] = $this->security->xss_clean($this->input->post('youtube_link'));
		$searchArr['description'] = $this->security->xss_clean($this->input->post('description'));
		$searchArr['sell_business_amount'] = $this->security->xss_clean($this->input->post('sell_business_amount'));
		$searchArr['buy_business_commission'] = $this->security->xss_clean($this->input->post('buy_business_commission'));
		if($this->security->xss_clean($this->input->post('homelogoimagefile')) !='')
		{
			$searchArr['home_logo'] = $this->security->xss_clean($this->input->post('homelogoimagefile'));
		}
		if($this->security->xss_clean($this->input->post('insidelogoimagefile')) !='')
		{
			$searchArr['inside_logo'] = $this->security->xss_clean($this->input->post('insidelogoimagefile'));
		}
		
		$this->db->update(TABLE_PREFIX.'site_settings', $searchArr);

		$this->db->select("*");
		$this->db->from(TABLE_PREFIX.'commission_history');
		$this->db->order_by('change_date','desc');
        $Query = $this->db->get();
		$commission = $Query->row(); 
		if($commission->percentage!=$this->security->xss_clean($this->input->post('buy_business_commission')))
		{
			$comarr['percentage'] = $this->security->xss_clean($this->input->post('buy_business_commission'));
			$this->db->insert(TABLE_PREFIX.'commission_history', $comarr);
		}
        $successMessage = 'Site Settings Info has been updated!';
        $this->session->set_flashdata('success', $successMessage);
        redirect(base_url().'administrator/site-settings');
    }

	public function addhomePageLogo(){
		$sess_data = array();
        if(!empty($_FILES['file']['name'])){
            
            $adminID = $this->session->userdata('user_id');
            
            $uploadPath = "./uploads/logo_image/";
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
	public function addinsidePageLogo(){
		$sess_data = array();
        if(!empty($_FILES['file']['name'])){
            
            $adminID = $this->session->userdata('user_id');
            
            $uploadPath = "./uploads/logo_image/";
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
    
    public function commonListAssets(){
		$permission = checkAuthorization('COMMONASSETS','LIST');
        $getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'site-settings';
		$header['userData'] = $getUserData;

		//$getSiteDetails['siteSettings'] = $this->admin_model->getSiteSettings(1);
		//$getSiteDetails['getCurrency'] = $this->admin_model->getCurrencies();
        $data['assets'] = $this->admin_model->listassets('all');
        $data['editpermission'] = checkAuthorization('COMMONASSETS','EDIT');
		$data['deletepermission'] = checkAuthorization('COMMONASSETS','DELETE');
		$data['addpermission'] = checkAuthorization('COMMONASSETS','ADD');
		

		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/common-assets',$data);
		else
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
    }

    public function addCommonAssets(){
        $AssetDescription = $this->input->post('AssetDescription');
		$this->form_validation->set_rules('AssetDescription', 'Asset description is required', 'trim|required');
		if($this->form_validation->run() == FALSE)
        {
            $data = array(
			  'error' => validation_errors(),
			  'errorCode'=>1
			);
			$this->session->set_flashdata($data);
			redirect(base_url().'administrator/site-settings/common-list-assets');
		}
		
		$searchArr['asset_description'] = $this->security->xss_clean($this->input->post('AssetDescription'));
		$searchArr['status'] = $this->security->xss_clean($this->input->post('assetStatus'));
		$action = $this->security->xss_clean($this->input->post('action'));
		if($action == 'edit')
		{
			$searchArr['id'] = $this->security->xss_clean($this->input->post('id'));
		}
		$this->admin_model->addasset($searchArr,$action);
		if($action == 'add')
		{
			$this->session->set_flashdata('success', 'Assets successfully added.');
		}elseif($action == 'edit')
		{
			$this->session->set_flashdata('success', 'Assets successfully edited.');
		}
		
		redirect(base_url().'administrator/site-settings/common-list-assets');
    }
    public function deleteCommonAssets($id){
		if(checkAuthorization('COMMONASSETS','DELETE'))
		{
        $this->session->set_flashdata('success', 'Asset successfully removed.');
        $this->admin_model->deleteasset($id);
		}
		redirect(base_url().'administrator/site-settings/common-list-assets');
	}

	public function monetization(){
		$permission = checkAuthorization('MONETIZATION','LIST');
        $getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'site-settings';
		$header['userData'] = $getUserData;

		//$getSiteDetails['siteSettings'] = $this->admin_model->getSiteSettings(1);
		//$getSiteDetails['getCurrency'] = $this->admin_model->getCurrencies();
        $data['assets'] = $this->admin_model->listmonetization('all');
        $data['editpermission'] = checkAuthorization('MONETIZATION','EDIT');
		$data['deletepermission'] = checkAuthorization('MONETIZATION','DELETE');
		$data['addpermission'] = checkAuthorization('MONETIZATION','ADD');

		$this->load->view('backend/includes/header',$header);
		$this->load->view('backend/monetization',$data);
		$this->load->view('backend/includes/footer');
    }

    public function addmonetization(){
		if(checkAuthorization('MONETIZATION','ADD'))
		{
        $monetizationName = $this->input->post('monetizationName');
		$this->form_validation->set_rules('monetizationName', 'Monetization Name is required', 'trim|required');
		//$this->form_validation->set_rules('lowmultiple', 'Low multiple is required', 'trim|required|numeric');
		//$this->form_validation->set_rules('heighMuiltiple', 'High multiple is required', 'trim|required|numeric');
		if($this->form_validation->run() == FALSE)
        {
            $data = array(
			  'error' => validation_errors(),
			  'errorCode'=>1
			);
			$this->session->set_flashdata($data);
			redirect(base_url().'administrator/site-settings/monetization');
		}
		
		$searchArr['name'] = $this->security->xss_clean($this->input->post('monetizationName'));
		$searchArr['slug'] = setMonetizationSlug(create_url_slug(trim($searchArr['name'])));
		//$searchArr['low_multiple'] = $this->security->xss_clean($this->input->post('lowmultiple'));
		//$searchArr['high_multiple'] = $this->security->xss_clean($this->input->post('heighMuiltiple'));
		$searchArr['Status'] = $this->security->xss_clean($this->input->post('assetStatus'));
		$action = $this->security->xss_clean($this->input->post('action'));
		if($action == 'edit')
		{
			$searchArr['id'] = $this->security->xss_clean($this->input->post('id'));
		}
		$this->admin_model->addmonetization($searchArr,$action);
		if($action == 'add')
		{
			$this->session->set_flashdata('success', 'Monetization successfully added.');
		}elseif($action == 'edit')
		{
			$this->session->set_flashdata('success', 'Monetization successfully edited.');
		}
		}
		redirect(base_url().'administrator/site-settings/monetization');
    }
    public function deletemonetization($id){
		if(checkAuthorization('MONETIZATION','DELETE'))
		{
        	$this->session->set_flashdata('success', 'Monetization successfully removed.');
        	$this->admin_model->deletemonetization($id);
		}
		redirect(base_url().'administrator/site-settings/monetization');
	}
	//
	public function commonListIndustries(){
		$permission = checkAuthorization('INDUSTRIES','LIST');
        $getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'site-settings';
		$header['userData'] = $getUserData;

		//$getSiteDetails['siteSettings'] = $this->admin_model->getSiteSettings(1);
		//$getSiteDetails['getCurrency'] = $this->admin_model->getCurrencies();
        $data['assets'] = $this->admin_model->listindustry('all');
        $data['editpermission'] = checkAuthorization('INDUSTRIES','EDIT');
		$data['deletepermission'] = checkAuthorization('INDUSTRIES','DELETE');
		$data['addpermission'] = checkAuthorization('INDUSTRIES','ADD');

		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/inductry-list',$data);
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
    }

    public function addIndustries(){
        $Industry = $this->input->post('Industry');
		$this->form_validation->set_rules('Industry', 'Industry', 'trim|required');
		if($this->form_validation->run() == FALSE)
        {
            $data = array(
			  'error' => validation_errors(),
			  'errorCode'=>1
			);
			$this->session->set_flashdata($data);
			redirect(base_url().'administrator/site-settings/industries');
		}
		
		$searchArr['industry'] = $this->security->xss_clean($this->input->post('Industry'));
		$searchArr['status'] = $this->security->xss_clean($this->input->post('industryStatus'));
		$action = $this->security->xss_clean($this->input->post('action'));
		if($action == 'edit')
		{
			$searchArr['id'] = $this->security->xss_clean($this->input->post('id'));
		}
		$this->admin_model->addindustry($searchArr,$action);
		if($action == 'add')
		{
			$this->session->set_flashdata('success', 'Industry successfully added.');
		}elseif($action == 'edit')
		{
			$this->session->set_flashdata('success', 'Industry successfully edited.');
		}
		
		redirect(base_url().'administrator/site-settings/industries');
    }
    public function deleteIndustries($id){
        $this->session->set_flashdata('success', 'Industry successfully removed.');
        $this->admin_model->deleteindustry($id);
		redirect(base_url().'administrator/site-settings/industries');
		//echo 'here';
	}
	
	public function commissionSettings(){
		$permission = checkAuthorization('COMMSETTINGS','LIST');
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'site-settings';
		$header['userData'] = $getUserData;

		//$getSiteDetails['siteSettings'] = $this->admin_model->getSiteSettings(1);
		//$getSiteDetails['getCurrency'] = $this->admin_model->getCurrencies();
        $data['commissions'] = $this->admin_model->listcommission('all');
		$data['editpermission'] = checkAuthorization('COMMSETTINGS','EDIT');
		$data['deletepermission'] = checkAuthorization('COMMSETTINGS','DELETE');
		$data['addpermission'] = checkAuthorization('COMMSETTINGS','ADD');
		//print '<pre>';
		//print_r($data['assets']);
		//die;
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/commission-settings',$data);
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}

	public function addcommissionSettings(){
		
		$priceFrom = $this->input->post('priceFrom');
		$priceTo = $this->input->post('priceTo');
		$percentage = $this->input->post('percentage');

		//$this->form_validation->set_rules('priceFrom', 'Price from is required', 'trim|required');
		//$this->form_validation->set_rules('priceTo', 'Price to is required', 'trim|required');
		$this->form_validation->set_rules('percentage', 'Percentage is required', 'trim|required');
		if($this->form_validation->run() == FALSE)
        {
            $data = array(
			  'error' => validation_errors(),
			  'errorCode'=>1
			);
			$this->session->set_flashdata($data);
			redirect(base_url().'administrator/site-settings/commission-settings');
		}
		
		$searchArr['price_from'] = $this->security->xss_clean($this->input->post('priceFrom'));
		$searchArr['price_to'] = $this->security->xss_clean($this->input->post('priceTo'));
		$searchArr['percentage'] = $this->security->xss_clean($this->input->post('percentage'));
		$action = $this->security->xss_clean($this->input->post('action'));

		if($action == 'edit')
		{
			$searchArr['id'] = $this->security->xss_clean($this->input->post('id'));
		}
		$this->admin_model->addcommission($searchArr,$action);
		if($action == 'add')
		{
			$this->session->set_flashdata('success', 'Commission successfully added.');
		}elseif($action == 'edit')
		{
			$this->session->set_flashdata('success', 'Commission successfully edited.');
		}
		
		redirect(base_url().'administrator/site-settings/commission-settings');
	}
	
	public function deletecommissionSettings($id){
		if(checkAuthorization('COMMSETTINGS','DELETE'))
		{
        $this->session->set_flashdata('success', 'Commission successfully removed.');
        $this->admin_model->deletecommission($id);
		}
		redirect(base_url().'administrator/site-settings/commission-settings');
		//echo $id;
	}
}