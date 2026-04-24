<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Acquisitionlending extends CI_Controller {
    public function __construct(){
        parent::__construct();
        //$this->load->model('admin_blog_model');
        $this->load->model('admin_model');
		$this->load->model('user_model');
		$this->load->model('front_model');
        $this->load->model('Admin_lending_model');
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
    public function list()
    {
        $permission = checkAuthorization('ACQUISITIONLENDING','LIST');
        $baseInfo['pageTitle'] = 'Blog Categories - FIH.com';
        $baseInfo['last_login'] = $this->session->userdata('lastLogin');
        $baseInfo['name'] = $this->session->userdata('name');
        $baseInfo['role_text'] = $this->session->userdata('role_text');
        $baseInfo['class'] = 'acquisitionlending';
        //$getBlogCatLists['blog_cat_lists'] = $this->admin_blog_model->getBlogCatLists();
        //$baseInfo['cat_count'] = count($getCatLists['cat_lists']);
        $getBlogCatLists['addpermission'] = checkAuthorization('ACQUISITIONLENDING','ADD');
        $getBlogCatLists['editpermission'] = checkAuthorization('ACQUISITIONLENDING','EDIT');
		$getBlogCatLists['deletepermission'] = checkAuthorization('ACQUISITIONLENDING','DELETE');
		//$getBlogCatLists['addpermission'] = checkAuthorization('BLOGCAT','ADD');

        $this->load->view('backend/includes/header', $baseInfo);
        if($permission)
        $this->load->view('backend/admin-acquisition-lending', $getBlogCatLists);
        else	
		$this->load->view('backend/unauthorized');
        $this->load->view('backend/includes/footer');
    }

    public function listgetfunded()
    {
        $permission = checkAuthorization('GETFUNDLIST','LIST');
        $baseInfo['pageTitle'] = 'Blog Categories - FIH.com';
        $baseInfo['last_login'] = $this->session->userdata('lastLogin');
        $baseInfo['name'] = $this->session->userdata('name');
        $baseInfo['role_text'] = $this->session->userdata('role_text');
        $baseInfo['class'] = 'acquisitionlending';
        //$getBlogCatLists['blog_cat_lists'] = $this->admin_blog_model->getBlogCatLists();
        //$baseInfo['cat_count'] = count($getCatLists['cat_lists']);
        //$getBlogCatLists['editpermission'] = checkAuthorization('BLOGCAT','EDIT');
		$getBlogCatLists['deletepermission'] = checkAuthorization('GETFUNDLIST','DELETE');
		//$getBlogCatLists['addpermission'] = checkAuthorization('BLOGCAT','ADD');

        $this->load->view('backend/includes/header', $baseInfo);
        if($permission)
        $this->load->view('backend/admin-acquisition-getfunded', $getBlogCatLists);
        else	
		$this->load->view('backend/unauthorized');
        $this->load->view('backend/includes/footer');
    }

    public function listfundacquisition()
    {
        $permission = checkAuthorization('FUNDACQUISITIONLIST','LIST');
        $baseInfo['pageTitle'] = 'Blog Categories - FIH.com';
        $baseInfo['last_login'] = $this->session->userdata('lastLogin');
        $baseInfo['name'] = $this->session->userdata('name');
        $baseInfo['role_text'] = $this->session->userdata('role_text');
        $baseInfo['class'] = 'acquisitionlending';
        //$getBlogCatLists['blog_cat_lists'] = $this->admin_blog_model->getBlogCatLists();
        //$baseInfo['cat_count'] = count($getCatLists['cat_lists']);
        //$getBlogCatLists['editpermission'] = checkAuthorization('BLOGCAT','EDIT');
		$getBlogCatLists['deletepermission'] = checkAuthorization('FUNDACQUISITIONLIST','DELETE');
		//$getBlogCatLists['addpermission'] = checkAuthorization('BLOGCAT','ADD');

        $this->load->view('backend/includes/header', $baseInfo);
        if($permission)
        $this->load->view('backend/admin-acquisition-fundacquisition', $getBlogCatLists);
        else	
		$this->load->view('backend/unauthorized');
        $this->load->view('backend/includes/footer');
    }

    public function listrequestaccess()
    {
        $permission = checkAuthorization('REQUESTACCESSLIST','LIST');
        $baseInfo['pageTitle'] = 'Blog Categories - FIH.com';
        $baseInfo['last_login'] = $this->session->userdata('lastLogin');
        $baseInfo['name'] = $this->session->userdata('name');
        $baseInfo['role_text'] = $this->session->userdata('role_text');
        $baseInfo['class'] = 'acquisitionlending';
        //$getBlogCatLists['blog_cat_lists'] = $this->admin_blog_model->getBlogCatLists();
        //$baseInfo['cat_count'] = count($getCatLists['cat_lists']);
        //$getBlogCatLists['editpermission'] = checkAuthorization('BLOGCAT','EDIT');
		$getBlogCatLists['deletepermission'] = checkAuthorization('REQUESTACCESSLIST','DELETE');
		//$getBlogCatLists['addpermission'] = checkAuthorization('BLOGCAT','ADD');

        $this->load->view('backend/includes/header', $baseInfo);
        if($permission)
        $this->load->view('backend/admin-acquisition-requestaccess', $getBlogCatLists);
        else	
		$this->load->view('backend/unauthorized');
        $this->load->view('backend/includes/footer');
    }

    public function lendingData(){
        $editpermission = checkAuthorization('ACQUISITIONLENDING','EDIT');
		$deletepermission = checkAuthorization('ACQUISITIONLENDING','DELETE');
		$draw = $_POST['draw'];
        $data['start'] = $_POST['start'];
		$data['limit'] = $_POST['length'];
        $data['searchValue'] = $_POST['searchName'];
		$data['searchUsertype'] = $_POST['searchUsertype'];
		$sort = $_POST['order'][0];
		$users = $this->Admin_lending_model->getlending($data,$sort);
		
		$dataArr = [];
        if(is_array($users['lending']) && count($users['lending'])>0)
        {
            
            $i = $data['start']+1;
            foreach($users['lending'] as $v)
            {
				$datares['sl_no'] = $i;
                $i++;
				$datares['industry'] = $v['industryname'];
				$datares['loantype'] = $v['loan_type'];
                $datares['loan_term'] = $v['loan_term'];
                $datares['acquirer_contribution'] = $v['acquirer_contribution'];
                $datares['status'] = ($v['status'] == 1)?'Active': 'Inactive';
                $datares['dateadded'] = date('dS M Y',strtotime($v['Added_on']));
                
				$datares['action'] = '<a href="'.base_url().'administrator/edit-acquisition/'.$v['id'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a> <a class="btn-sm btn-danger deleteRow deleteCMS" href="javascript:void(0);" onclick=delpartner(this) datadeletehref="'.base_url().'administrator/delete-acquisition/'.$v['id'].'" data-type="cms" title="Delete"><i class="fa fa-trash"></i></a>';
				
                $dataArr[] = $datares;
            }
		}
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $users['totalrecord']->totalrecord,
            "recordsFiltered" => $users['totalrecord']->totalrecord,
			"data" => $dataArr,
			"token" => $this->security->get_csrf_hash()
			
        );
        echo json_encode($response);
    }
    
    public function requestaccessData(){
        //$editpermission = checkAuthorization('USER','EDIT');
		$deletepermission = checkAuthorization('REQUESTACCESSLIST','DELETE');
		$draw = $_POST['draw'];
        $data['start'] = $_POST['start'];
		$data['limit'] = $_POST['length'];
        $data['searchValue'] = $_POST['searchName'];
		$data['searchUsertype'] = $_POST['searchUsertype'];
		$sort = $_POST['order'][0];
		$users = $this->Admin_lending_model->fundrequestaccess($data,$sort);
		
		$dataArr = [];
        if(is_array($users['lending']) && count($users['lending'])>0)
        {
            
            $i = $data['start']+1;
            foreach($users['lending'] as $v)
            {
				$datares['sl_no'] = $i;
                $i++;
				$datares['investor'] = $v['investor'];
				$datares['available_money'] = $v['available_money'];
                $datares['hold_period'] = $v['hold_period'];
                $datares['name'] = $v['name'];
                $datares['email'] = $v['email'];
                $datares['phone'] = $v['phone'];

                //$datares['status'] = ($v['status'] == 1)?'Active': 'Inactive';
                $datares['dateadded'] = date('dS M Y',strtotime($v['date_added']));
                
				$datares['action'] = '<a class="btn-sm btn-danger deleteRow deleteCMS" href="javascript:void(0);" onclick=delpartner(this) datadeletehref="'.base_url().'administrator/delete-requestaccess/'.$v['id'].'" data-type="cms" title="Delete"><i class="fa fa-trash"></i></a>';
				
                $dataArr[] = $datares;
            }
		}
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $users['totalrecord']->totalrecord,
            "recordsFiltered" => $users['totalrecord']->totalrecord,
			"data" => $dataArr,
			"token" => $this->security->get_csrf_hash()
			
        );
        echo json_encode($response);
    }
    public function fundacquisitionData(){
        //$editpermission = checkAuthorization('USER','EDIT');
		$deletepermission = checkAuthorization('FUNDACQUISITIONLIST','DELETE');
		$draw = $_POST['draw'];
        $data['start'] = $_POST['start'];
		$data['limit'] = $_POST['length'];
        $data['searchValue'] = $_POST['searchName'];
		$data['searchUsertype'] = $_POST['searchUsertype'];
		$sort = $_POST['order'][0];
		$users = $this->Admin_lending_model->fundacquisition($data,$sort);
		
		$dataArr = [];
        if(is_array($users['lending']) && count($users['lending'])>0)
        {
            
            $i = $data['start']+1;
            foreach($users['lending'] as $v)
            {
				$datares['sl_no'] = $i;
                $i++;
				$datares['investor'] = $v['investor'];
				$datares['name'] = $v['name'];
                $datares['street'] = $v['street'];
                $datares['phone'] = $v['phone'];
                $datares['email'] = $v['email'];
                //$datares['status'] = ($v['status'] == 1)?'Active': 'Inactive';
                $datares['dateadded'] = date('dS M Y',strtotime($v['date_added']));
                
				$datares['action'] = '<a class="btn-sm btn-danger deleteRow deleteCMS" href="javascript:void(0);" onclick=delpartner(this) datadeletehref="'.base_url().'administrator/delete-fundacquisition/'.$v['id'].'" data-type="cms" title="Delete"><i class="fa fa-trash"></i></a>';
				
                $dataArr[] = $datares;
            }
		}
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $users['totalrecord']->totalrecord,
            "recordsFiltered" => $users['totalrecord']->totalrecord,
			"data" => $dataArr,
			"token" => $this->security->get_csrf_hash()
			
        );
        echo json_encode($response);
    }
    public function getfundedData(){
        //$editpermission = checkAuthorization('USER','EDIT');
		$deletepermission = checkAuthorization('GETFUNDLIST','DELETE');
		$draw = $_POST['draw'];
        $data['start'] = $_POST['start'];
		$data['limit'] = $_POST['length'];
        $data['searchValue'] = $_POST['searchName'];
		$data['searchUsertype'] = $_POST['searchUsertype'];
		$sort = $_POST['order'][0];
		$users = $this->Admin_lending_model->getfunded($data,$sort);
		
		$dataArr = [];
        if(is_array($users['lending']) && count($users['lending'])>0)
        {
            
            $i = $data['start']+1;
            foreach($users['lending'] as $v)
            {
				$datares['sl_no'] = $i;
                $i++;
				$datares['fund_seeker'] = $v['fund_seeker'];
				$datares['amount'] = $v['amount'];
                $datares['funding_timing'] = $v['funding_timing'];
                $datares['website'] = $v['website'];
                $datares['phone'] = $v['phone'];
                $datares['email'] = $v['email'];
                //$datares['status'] = ($v['status'] == 1)?'Active': 'Inactive';
                $datares['dateadded'] = date('dS M Y',strtotime($v['date_added']));
                
				$datares['action'] = '<a class="btn-sm btn-danger deleteRow deleteCMS" href="javascript:void(0);" onclick=delpartner(this) datadeletehref="'.base_url().'administrator/delete-getfundlist/'.$v['id'].'" data-type="cms" title="Delete"><i class="fa fa-trash"></i></a>';
				
                $dataArr[] = $datares;
            }
		}
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $users['totalrecord']->totalrecord,
            "recordsFiltered" => $users['totalrecord']->totalrecord,
			"data" => $dataArr,
			"token" => $this->security->get_csrf_hash(),
            'sort' => $sort
			
        );
        echo json_encode($response);
    }

    public function add($id=0)
    {
        $baseInfo['pageTitle'] = 'Add Blog Categories - FIH.com';
        $baseInfo['last_login'] = $this->session->userdata('lastLogin');
        $baseInfo['name'] = $this->session->userdata('name');
        $baseInfo['role_text'] = $this->session->userdata('role_text');
        $baseInfo['class'] = 'acquisitionlending';
        $baseInfo['sub_class'] = 'blog-category-list';

        //$data['industries'] = $this->admin_model->listindustry('active');
        if($id>0)
        {
            $permission = checkAuthorization('ACQUISITIONLENDING','EDIT');
            $data['action'] = 'edit';
            $data['lendingdata'] = $this->Admin_lending_model->getLendingDetails($id);
        }else{
            $permission = checkAuthorization('ACQUISITIONLENDING','ADD');
            $data['action'] = 'add';
        }
        $this->load->view('backend/includes/header', $baseInfo);
        if($permission)
        $this->load->view('backend/admin-alter-acquision-lending', $data);
        else	
		$this->load->view('backend/unauthorized');

        $this->load->view('backend/includes/footer');
    }

    public function alter(){
        $Industry = trim(strip_tags($this->input->post('Industry')));
    	$BusinessAge = trim(strip_tags($this->input->post('BusinessAge')));
        $Revenue = trim(strip_tags($this->input->post('Revenue')));
        $NetProfit = trim(strip_tags($this->input->post('NetProfit')));
        $FundingAmount = trim(strip_tags($this->input->post('FundingAmount')));

        $EBITDA = trim(strip_tags($this->input->post('EBITDA')));
        $LoanType = trim(strip_tags($this->input->post('LoanType')));
        $LoanTerm = trim(strip_tags($this->input->post('LoanTerm')));
        $InterestYield = trim(strip_tags($this->input->post('InterestYield')));
        $AcquirerContribution = trim(strip_tags($this->input->post('AcquirerContribution')));
        $FundingOpportunity = trim(strip_tags($this->input->post('FundingOpportunity')));
        $BusinessListingURL = trim(strip_tags($this->input->post('BusinessListingURL')));
        $LendingId = trim(strip_tags($this->input->post('LendingId')));
        $action = trim(strip_tags($this->input->post('action')));
    	$addedBy = $this->session->userdata('userId');
    	$this->form_validation->set_rules('Industry', 'Industry', 'required', 'Industry is required');
        $this->form_validation->set_rules('BusinessAge', 'BusinessAge', 'required', 'Business Age is required');
    	$this->form_validation->set_rules('Revenue', 'Revenue', 'required', 'Revenue is required');
        $this->form_validation->set_rules('NetProfit', 'NetProfit', 'required', 'Net Profit is required');
        $this->form_validation->set_rules('FundingAmount', 'FundingAmount', 'required', 'Funding Amount is required');
        $this->form_validation->set_rules('EBITDA', 'EBITDA', 'required', 'EBITDA is required');

    	$this->form_validation->set_rules('LoanType', 'LoanType', 'required', 'Loan Type is required');
        $this->form_validation->set_rules('LoanTerm', 'LoanTerm', 'required', 'Loan Term is required');
    	$this->form_validation->set_rules('InterestYield', 'InterestYield', 'required', 'Interest Yield is required');
        $this->form_validation->set_rules('AcquirerContribution', 'AcquirerContribution', 'required', 'Acquirer Contribution is required');

    	//$this->form_validation->set_rules('FundingOpportunity', 'FundingOpportunity', 'required', 'Funding Opportunity is required');
        $this->form_validation->set_rules('BusinessListingURL', 'BusinessListingURL', 'required', 'Business Listing URL is required');



        if ($this->form_validation->run() == FALSE) {
        	$data = array(
              'error' => validation_errors()
            );

            $this->session->set_flashdata($data);
            redirect('administrator/add-acquisition');
        }
        $param['industry'] = $Industry;
        $param['business_age'] = $BusinessAge;
        $param['revenue'] = $Revenue;
        $param['net_profit'] = $NetProfit;
        $param['funding_amount'] = $FundingAmount;
        $param['ebitda'] = $EBITDA;
        $param['loan_type'] = $LoanType;
        $param['loan_term'] = $LoanTerm;
        $param['interest_yield'] = $InterestYield;
        $param['acquirer_contribution'] = $AcquirerContribution;
        $param['funding_opportunity'] = $FundingOpportunity;
        $param['business_listing_url'] = $BusinessListingURL;
        $param['status'] = trim(strip_tags($this->input->post('status')));
        if($LendingId>0)
        {
            $param['LendingId'] = $LendingId;
        }
        


        $getActionDetails = $this->Admin_lending_model->actionLendingDetails($param, $action);
	    switch($action){
            case 'add':
                # code...
                $successMessage = 'Acquisition Lending has been added!!!!';
                $errorMessage = "Acquisition Lending hasn't been added!!!!";
            break;

            case 'edit':
                # code...

                $successMessage = 'Acquisition Lending has been updated!!!!';
                $errorMessage = "Acquisition Lending hasn't been updated!!!!";
            break;
        }    

        if($getActionDetails != 0){ 
            $this->session->set_flashdata('success', $successMessage);
        } else {
            $this->session->set_flashdata('error', $errorMessage);
        }
        redirect('administrator/acquisition-lending-list');
    }
    public function delete($id){
        $this->db->delete(TABLE_PREFIX.'acquisition_lending', array('id' => $id));
        $successMessage = 'Data Deleted successfully!!';
        $this->session->set_flashdata('success', $successMessage);
        redirect('administrator/acquisition-lending-list');
    }

    public function deleterequestaccess($id){
        $this->db->delete(TABLE_PREFIX.'request_access_list', array('id' => $id));
        $successMessage = 'Data Deleted successfully!!';
        $this->session->set_flashdata('success', $successMessage);
        redirect('administrator/acquisition-requestaccess-list');
    }

    public function deletegetfundlist($id){
        $this->db->delete(TABLE_PREFIX.'get_fund_list', array('id' => $id));
        $successMessage = 'Data Deleted successfully!!';
        $this->session->set_flashdata('success', $successMessage);
        redirect('administrator/acquisition-getfund-list');
    }
    
    public function deletefundacquisition($id){
        $this->db->delete(TABLE_PREFIX.'fund_acquisition', array('id' => $id));
        $successMessage = 'Data Deleted successfully!!';
        $this->session->set_flashdata('success', $successMessage);
        redirect('administrator/acquisition-businessacquisition-list');
    }
    public function contents()
    {
        $permission = checkAuthorization('ACQUISITIONLENDINGCONTENT','EDIT');
        $baseInfo['pageTitle'] = 'Add Blog Categories - FIH.com';
        $baseInfo['last_login'] = $this->session->userdata('lastLogin');
        $baseInfo['name'] = $this->session->userdata('name');
        $baseInfo['role_text'] = $this->session->userdata('role_text');
        $baseInfo['class'] = 'acquisitionlending';
        $data['contents'] = $this->admin_model->getLendingContentDetails(1);
        
        $this->load->view('backend/includes/header', $baseInfo);
        if($permission)
        $this->load->view('backend/lending-contents', $data);
        else	
		$this->load->view('backend/unauthorized');

        $this->load->view('backend/includes/footer');
    }

    public function pageImage()
    {
        $sess_data = array();
        if(!empty($_FILES['file']['name'])){
            
            $adminID = $this->session->userdata('user_id');
            $uploadPath = "./uploads/otherimages/";
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            //Load upload library
            $this->load->library('upload',$config); 
			// File upload
			if($this->upload->do_upload('file')){
				$fileData = $this->upload->data();
				$editArray['image'] = ($fileData) ? $fileData['file_name'] : '';
				$getResult = $this->admin_model->updateLendingContentDetails($editArray, 1);
			}
        }
	}

    public function updatecontent(){
        $editArray['content_one'] = $this->input->post('pageContent_block_one',false);
        $editArray['content_two'] = $this->input->post('pageContent_block_two',false);
        $editArray['content_three'] = $this->input->post('pageContent_block_three',false);
        $getResult = $this->admin_model->updateLendingContentDetails($editArray, 1);
        $successMessage = 'Page contents successfully updated!!';
        $this->session->set_flashdata('success', $successMessage);
        redirect('administrator/acquisition-lending/contents');
    }

}