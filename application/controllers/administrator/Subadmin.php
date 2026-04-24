<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subadmin extends CI_Controller {
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

    public function addsubadmin($id=0){

        $getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'site-settings';
		
		$header['userData'] = $getUserData;
		$this->load->view('backend/includes/header',$header);
		$this->load->view('backend/sub-admin-add');
		$this->load->view('backend/includes/footer');
    }
	public function editsubadmin($id=0){

        $getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		if($id>0)
		{
			$getSubadminDetails = $this->admin_model->getUserDetails($id);
			if($getSubadminDetails->authorize !='')
			{

			$authArr = explode('|',$dataval['authorize']);
			if(is_array($authArr) && count($authArr)>0)
			{
				foreach($authArr as $k=>$v)
				{
				//USER:EDIT,DELETE
				$authIndiArr = explode(':',$v);
				$authIndiValArr = explode(',',$authIndiArr[1]);
				$newAuthArr[$authIndiArr[0]] = $authIndiValArr;
				}
			}
			
			}
			$data['dataval'] = [
				'fname'=> $getSubadminDetails->fname,
				'lname'=> $getSubadminDetails->lname,
				'email'=> $getSubadminDetails->mail,
				'authorize' =>$getSubadminDetails->authorize,
				'userId' => $getSubadminDetails->userId,
			];

		}
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'site-settings';
		$header['userData'] = $getUserData;
		$this->load->view('backend/includes/header',$header);
		$this->load->view('backend/sub-admin-edit',$data);
		$this->load->view('backend/includes/footer');
    }

	public function altersubadmin(){
		$data = $this->input->post();
		$subadminId = $data['userId'];
		
		$config = [
			[
				'field' => 'fname',
				'label' => 'Name',
				'rules' => 'trim|required',
				'errors' => [
						'required' => 'Please enter your name.',
				],
			],
			
			

		];
		if($subadminId>0 && ($data['password']!='' || $data['conpassword']!=''))
		{
			$config[]  = [
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'trim|required|callback_chk_password_expression',
				'errors' => [
						'required' => 'Please enter your password.'
				],
			];
			$config[]  = [
				'field' => 'conpassword',
				'label' => 'Confirm Password',
				'rules' => 'trim|required|matches[password]',
				'errors' => [
						'required' => 'Please enter your confirm password.'
				],
			];
			$config[]  = [
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'trim|required|valid_email',
				'errors' => [
						'required' => 'Please enter your valid email address.',
						'valid_email' => 'Please enter your valid email address.'
				],
			];
		}elseif($subadminId == '')
		{
			$config[]  = [
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'trim|required|callback_chk_password_expression',
				'errors' => [
						'required' => 'Please enter your password.'
				],
			];
			$config[]  = [
				'field' => 'conpassword',
				'label' => 'Confirm Password',
				'rules' => 'trim|required|matches[password]',
				'errors' => [
						'required' => 'Please enter your confirm password.'
				],
			];
			$config[]  = [
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'trim|required|valid_email|callback_user_exists',
				'errors' => [
						'required' => 'Please enter your valid email address.',
						'valid_email' => 'Please enter your valid email address.'
				],
			];
		}
		$authorize = $data['authorize'];
		$subauthorize = $data['subauthorize'];
		$AuthStr = '';
		if(is_array($authorize) && count($authorize)>0)
		{
			foreach($authorize as $authval)
			{
				if($AuthStr !='')
				$AuthStr .='|';
				
				$AuthStr .= $authval.':';
				//echo $authval;
				//print '<pre>';
				//print_r($data['subauthorize'][strtolower($authval)]);
				//echo '<br>---<br>';
				//echo strtolower($authval).'<br>';
				$subauth = implode(',',$data['subauthorize'][strtolower($authval)]);
				//print_r($data['subauthorize'][strtolower($authval)]);
				//echo '<br>';
				$AuthStr .= $subauth;
			}
		};
		//die;
		$data['authorize'] = $AuthStr;
		$this->form_validation->set_data($data);
        $this->form_validation->set_rules($config);

        if($this->form_validation->run()==FALSE){
            
			$data1 = array(
				'error' => $this->form_validation->error_array(),
				'errorCode'=>1,
				'dataval' => $data
			);
			$this->session->set_flashdata($data1);
			if($subadminId>0)
			{
				redirect(base_url().'administrator/sub-admin/edit/'.$subadminId);
			}else{
				redirect(base_url().'administrator/sub-admin/add');
			}
        }
		
		if($subadminId>0)
		{
			$Adddata['lname'] = $this->security->xss_clean(trim($data['lname']));
			$Adddata['mail'] = $this->security->xss_clean(trim($data['email']));
			$Adddata['profile_type'] = '';
			$Adddata['Status'] = 1;
			if($data['password'] !='')
			{
				$Adddata['password'] = getHashedPassword($data['password']);
			}
			
			$Adddata['authorize'] = $AuthStr;
			
			$userTableId = $this->front_model->updateAdminDetails($Adddata,$subadminId);
			$data1 = array(
				'success' => 'Sub admin updated successfully.',
				'errorCode'=>0
			);

		}else{
			$Adddata['fname'] = $this->security->xss_clean(trim($data['fname']));
			$Adddata['lname'] = $this->security->xss_clean(trim($data['lname']));
			$Adddata['mail'] = $this->security->xss_clean(trim($data['email']));
			$Adddata['profile_type'] = '';
			$Adddata['Status'] = 1;
			$Adddata['password'] = getHashedPassword($data['password']);
			$Adddata['authorize'] = $AuthStr;
			$Adddata['role'] = 'subadmin';
			$userTableId = $this->front_model->add_user($Adddata);
			$user_to =$data['email'] ;
			//$user_subject = 'Welcome to Flat Iron Holdings - FIH.com';
			$user_subject = 'Welcome to FIH.com';
			$user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$data['fname'].'</strong>,</h6>
			<br>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Thank you for registering as sub admin at FIH.com - the curated business marketplace.</p>
			<br>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
			$sendEmail = sendEmail($user_to, $user_subject, $user_message);
			$data1 = array(
				'success' => 'Sub admin added successfully.',
				'errorCode'=>0
			);
		}
		
		if($subadminId>0)
		{
			$this->session->set_flashdata($data1);
			redirect(base_url().'administrator/sub-admin');
		}else{
			$this->session->set_flashdata($data1);
			redirect(base_url().'administrator/sub-admin/add');
		}
		

	}
	public function user_exists($str)
	{
		if ($this->front_model->checkExistingUser($str))
		{
			$this->form_validation->set_message('user_exists', 'Email address exists. Please select different email address.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	public function chk_password_expression($str)
	{
		if (1 !== preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $str))
		{
			$this->form_validation->set_message('chk_password_expression', '%s must be at least 8 characters and must contain at least one lower case letter, one upper case letter, one digit and one special character');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function subadminlist(){
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'site-settings';
		$header['userData'] = $getUserData;
		$this->load->view('backend/includes/header',$header);
		$this->load->view('backend/sub-admin');
		$this->load->view('backend/includes/footer');
	}

	public function subadmindata(){
		$draw = $_POST['draw'];
        $data['start'] = $_POST['start'];
		$data['limit'] = $_POST['length'];
        $data['searchValue'] = $_POST['searchName'];
		$data['searchUsertype'] = $_POST['searchUsertype'];
		
		$user_sort = $_POST['order'][0];
		$users = $this->admin_model->getsubadmin($data,$user_sort);
		
		$dataArr = [];
        if(is_array($users['users']) && count($users['users'])>0)
        {
            
            $i = $data['start']+1;
            foreach($users['users'] as $v)
            {
				$datares['sl_no'] = $i;
                $i++;
				$datares['fname'] = $v['fname'].' '.$v['lname'];;
				$datares['phone'] = $v['phone'];
				$datares['email'] = '<a href="'.base_url().'administrator/users/edit/'.$v['userId'].'">'.$v['mail'].'</a>';
				if($v['Status'] == 1)
				{
					$datares['status'] = 'Active';
				}elseif($v['Status'] == 0)
				{
					$datares['status'] = 'Pending Activation';
				}elseif($v['Status'] == 2)
				{
					$datares['status'] = 'Inactive';
				}elseif($v['Status'] == 3)
				{
					$datares['status'] = 'Deleted';
				}


				if($v['identity_proof_status'] == 1)
				{
					$datares['identity'] = 'Verified';
				}
				elseif($v['identity_proof_status'] == 0)
				{
					$datares['identity'] = 'Not verified';
				}
				elseif($v['identity_proof_status'] == 2)
				{
					$datares['identity'] = 'Pending';	
				}


				if($v['proof_fund_status'] == 1)
				{
					$datares['fund'] = 'Verified';
				}
				elseif($v['proof_fund_status'] == 0)
				{
					$datares['fund'] = 'Not verified';
				}
				elseif($v['proof_fund_status'] == 2)
				{
					$datares['fund'] = 'Pending';	
				}
					
                //$datares['status'] = $v['Status'];
				$datares['reg_date'] = date('jS M Y',strtotime($v['added_on']));
				
				if($v['Status'] == 1)
				{
					$datares['action'] = '<a href="'.base_url().'administrator/sub-admin/edit/'.$v['userId'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;<a href="javascript: void(0)" onclick="deleterecord(this)" datadeletehref="'.base_url().'administrator/sub-admin/delete/'.$v['userId'].'" class="btn-sm btn-danger deleterec"><i class="fa fa-trash" aria-hidden="true"></i></a>';
				}elseif($v['Status'] == 0)
				{
					$datares['action'] = '<a href="'.base_url().'administrator/sub-admin/edit/'.$v['userId'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;<a href="javascript: void(0)" onclick="deleterecord(this)" datadeletehref="'.base_url().'administrator/sub-admin/delete/'.$v['userId'].'" class="btn-sm btn-danger deleterec"><i class="fa fa-trash" aria-hidden="true"></i></a>';
				}else{
					$datares['action'] = '<a href="'.base_url().'administrator/sub-admin/edit/'.$v['userId'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;<a href="javascript: void(0)" onclick="deleterecord(this)" datadeletehref="'.base_url().'administrator/sub-admin/delete/'.$v['userId'].'" class="btn-sm btn-danger deleterec"><i class="fa fa-trash" aria-hidden="true"></i></a>';
				}
				
                $dataArr[] = $datares;
            }
		}
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $users['totalrecord']->totalrecord,
            "recordsFiltered" => $users['totalrecord']->totalrecord,
			"data" => $dataArr,
			"post" => $user_sort,
			"token" => $this->security->get_csrf_hash()
			
        );
        echo json_encode($response);
	}

	public function deletesubadmin($id){
		//echo $id;
		$Adddata['Status'] = 2;
		$userTableId = $this->front_model->updateAdminDetails($Adddata,$id);
		$data1 = array(
			'success' => 'Sub admin updated successfully.',
			'errorCode'=>0
		);
		$this->session->set_flashdata($data1);
		redirect(base_url().'administrator/sub-admin');
	}
}