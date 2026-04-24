<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verifications extends CI_Controller {

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
	public function listIdentityProof()
	{
		$permission = checkAuthorization('IDENTITYPROOF','LIST');
        $getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'proof-verification';
		$header['userData'] = $getUserData;
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/identity-proofs');
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
    }
    public function listIdentityProofData(){
        $draw = $_POST['draw'];
        $data['start'] = $_POST['start'];
        $data['limit'] = $_POST['length'];
        
        $data['searchValue'] = $_POST['search']['value'];
		$sort = $_POST['order'][0];
        $pendingidentity = $this->admin_model->getpenndingidentity($data,$sort);
		$dataArr = [];
        if(is_array($pendingidentity['pendingidentity']) && count($pendingidentity['pendingidentity'])>0)
        {
            $i = $data['start']+1;
            foreach($pendingidentity['pendingidentity'] as $v)
            {
				$datares['sl_no'] = $i;
                $i++;
				$datares['fname'] = $v['fname'].' '.$v['fname'];
				$datares['phone'] = $v['phone'];
				$datares['mail'] = '<a target="_blank" href="'.base_url().'administrator/users/edit/'.$v['userId'].'">'.$v['mail'].'</a>';
				if($v['identity_proof_status'] == 2)
				{
					$datares['identity_status'] = 'Pending Approval';
				}elseif($v['identity_proof_status'] == 1)
				{
					$datares['identity_status'] = 'Approved';
                }
                if($v['Status'] == 1)
				{
					$datares['status'] = 'Active';
				}elseif($v['Status'] == 1)
				{
					$datares['status'] = 'Inactive';
                }
                //$datares['status'] = $v['Status'];
				$datares['submission_date'] = date('jS M Y',strtotime($v['identity_proof_submit_date']));
				//$datares['action'] = '';
				//if($editpermission) 
				$datares['action'] = '<a href="'.base_url().'administrator/verifications/verify-identity-proof/'.$v['userId'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
				
				
				
                $dataArr[] = $datares;
            }
        }
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $pendingidentity['totalrecord']->totalrecord,
            "recordsFiltered" => $pendingidentity['totalrecord']->totalrecord,
			"data" => $dataArr,
			"token" => $this->security->get_csrf_hash()
			
        );
        echo json_encode($response);
    }

    public function verifyIdentityProof($userId){
		$permission = checkAuthorization('IDENTITYPROOF','LIST');
        $data['userId'] = $userId;
		$data['result'] = $this->user_model->getuserprofile($data);
		$data['area'] = $_GET['area'];
		$data['editpermission'] = checkAuthorization('IDENTITYPROOF','EDIT');
        
        $getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'proof-verification';
		$header['userData'] = $getUserData;

		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/verify-identity-proofs',$data);
		else
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}

	public function saveapproveIdentity($userId)
	{
		//echo 'here';
		$data = $this->input->post();
		//print '<pre>';
		//print_r($data);
        $dataUpdate['clientId'] = $userId;
        //$dataUpdate['fname'] = $this->security->xss_clean(trim($data['username']));
        $dataUpdate['dob'] = $this->security->xss_clean(trim($data['dob']));
		$dataUpdateDetails['persona_verification_id'] = $this->security->xss_clean(trim($data['personainquiryId']));
        $dataUpdateDetails['IdentrityProof'] = $this->security->xss_clean(trim($data['identrity_proof']));
        $dataUpdateDetails['IdentrityProofNumber'] = $this->security->xss_clean(trim($data['identrity_proof_number']));
        $dataUpdateDetails['IdentrityProofexpdate'] = $this->security->xss_clean(trim($data['identrity_proof_exp_date']));
        $dataUpdateDetails['verificationType'] = 'offline';
		
		$documentsDetails = $this->user_model->getUserDocuments($userId,'indentity');
		if(is_array($documentsDetails) && count($documentsDetails)>0)
		{
			foreach($documentsDetails as $val)
			{
				$proofDocuments[] = $val['documents'];
			}
			$verificationData = [
				'type'=>$dataUpdateDetails['verificationType'],
				'identrity_proof' => $dataUpdateDetails['IdentrityProof'],
				'identrity_proof_number' => $dataUpdateDetails['IdentrityProofNumber'],
				'identrity_proof_exp_date' => $dataUpdateDetails['IdentrityProofexpdate'],
				'documents' => $proofDocuments
			];
			$identityProofStatus = 2;
			//$message = 'You are successfully uploaded identity documents.';
		}
		$result = $this->user_model->updateuserprofile($dataUpdate);
        $arr['userId'] = $userId;
        $arr['identity_proof_doc'] = json_encode($verificationData);
        $arr['identity_proof_status'] = $identityProofStatus;
        $arr['identity_proof_submit_date'] = date('Y-m-d H:i:s');
        if($dataUpdateDetails['verificationType'] == 'online')
        {
            $arr['identity_proof_approve_date'] = date('Y-m-d H:i:s');
        }
        $result = $this->user_model->updateuserdetails($arr);
        $this->db->delete(TABLE_PREFIX.'proof_of_funds', array('userId' => $data['user_id'], 'doc_type'=>'indentity'));
		$this->approveIdentity($userId);
	}
	
	public function approveIdentity($userId){
		$arr['userId'] = $userId;
		$arr['identity_proof_approve_date'] = date('Y-m-d H:i:s');
		$arr['identity_proof_status'] = 1;
		$result = $this->user_model->updateuserdetails($arr);
		$userDetails = $this->front_model->getAdminDetails($userId);
        $user_to = $userDetails['mail'];
        $user_subject = 'Your identity proof request has been approved - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$userDetails['fname'].'</strong>,</h6>
		<br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Good News! Your identity proof has been reviewed & approved.</p>
		<br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);

		$notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $userId;
        $notificationarr['notification_text'] = 'Your identity proof request has been approved.';
        $notificationarr['notification_type'] = 'IDENTITYAPPROVED';
        $notificationarr['notification_type_id'] = $userId;
        $result = $this->front_model->insertnotification($notificationarr);

		$this->session->set_flashdata('success', 'Identity proof approved successfully.');
		$data = $this->input->post();
		if($data['area'] == 'user')
		{
			redirect('administrator/users/edit/'.$userId);
		}
		redirect('administrator/verifications/identity-proof');  
	}
	public function rejectIdentity($userId){
		$arr['userId'] = $userId;
		$arr['identity_proof_approve_date'] = date('Y-m-d H:i:s');
		$arr['identity_proof_status'] = 0;
		$result = $this->user_model->updateuserdetails($arr);

		$userDetails = $this->front_model->getAdminDetails($userId);
        $user_to = $userDetails['mail'];
        $user_subject = 'Your identity proof request has been rejected - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$userDetails['fname'].'</strong>,</h6>
		<br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Your identity proof request has been rejected</p>
		<br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);

		$notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $userId;
        $notificationarr['notification_text'] = 'Your identity proof request is denied.';
        $notificationarr['notification_type'] = 'IDENTITYAPPROVED';
        $notificationarr['notification_type_id'] = $userId;
        $result = $this->front_model->insertnotification($notificationarr);

		$this->session->set_flashdata('success', 'Identity proof rejected successfully.');
		$data = $this->input->post();
		if($data['area'] == 'user')
		{
			redirect('administrator/users/edit/'.$userId);
		}
		redirect('administrator/verifications/identity-proof');  
	}
	public function rejectFund($userId){
		$arr['userId'] = $userId;
		$area= $this->input->post('area');
		$arr['fund_proof_approve_date'] = date('Y-m-d H:i:s');
		$arr['proof_fund_status'] = 0;
		$result = $this->user_model->updateuserdetails($arr);

		$userDetails = $this->front_model->getAdminDetails($userId);
        $user_to = $userDetails['mail'];
        $user_subject = 'Your fund proof request has been rejected - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$userDetails['fname'].'</strong>,</h6>
		<br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Your fund proof request has been rejected</p>
		<br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);

		$notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $userId;
        $notificationarr['notification_text'] = 'Your fund proof request is denied.';
        $notificationarr['notification_type'] = 'FUNDAPPROVED';
        $notificationarr['notification_type_id'] = $userId;
        $result = $this->front_model->insertnotification($notificationarr);
		$this->session->set_flashdata('success', 'Fund proof rejected successfully.');
		if($area == 'user')
		{
			redirect('administrator/users/edit/'.$userId); 
		}
		redirect('administrator/verifications/fund-proof');  
	}


	public function listFundProof()
	{
		$permission = checkAuthorization('FUNDPROOF','LIST');
        $getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'proof-verification';
		$header['userData'] = $getUserData;
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/fund-proofs');
		else
		$this->load->view('backend/unauthorized');

		$this->load->view('backend/includes/footer');
    }
    public function listFundProofData(){
        $draw = $_POST['draw'];
        $data['start'] = $_POST['start'];
		$data['limit'] = $_POST['length'];
		$data['searchValue'] = $_POST['search']['value'];
		//$data['searchUsertype'] = $_POST['searchUsertype'];
		$sort = $_POST['order'][0];
        $pendingfund = $this->admin_model->getpenndingfundproof($data,$sort);
		$dataArr = [];
        if(is_array($pendingfund['pendingfund']) && count($pendingfund['pendingfund'])>0)
        {
            
            $i = $data['start']+1;
            foreach($pendingfund['pendingfund'] as $v)
            {
				$datares['sl_no'] = $i;
                $i++;
				$datares['fname'] = $v['fname'].' '.$v['lname'];
				$datares['email'] = '<a href="'.base_url().'administrator/users/edit/'.$v['userId'].'">'.$v['mail'].'</a>';
				$datares['phone'] = $v['phone'];
				if($v['proof_fund_status'] == 2)
				{
					$datares['identity_status'] = 'Pending Approval';
				}elseif($v['proof_fund_status'] == 1)
				{
					$datares['identity_status'] = 'Approved';
                }
                if($v['Status'] == 1)
				{
					$datares['status'] = 'Active';
				}elseif($v['Status'] == 1)
				{
					$datares['status'] = 'Inactive';
                }
                //$datares['status'] = $v['Status'];
				$datares['submission_date'] = date('jS M Y',strtotime($v['fund_proof_submit_date']));
				//$datares['action'] = '';
				
					$datares['action'] = '<a href="'.base_url().'administrator/verifications/verify-fund-proof/'.$v['userId'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
				
				
                $dataArr[] = $datares;
            }
        }
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $pendingfund['totalrecord']->totalrecord,
            "recordsFiltered" => $pendingfund['totalrecord']->totalrecord,
			"data" => $dataArr,
			"reqdata"=>$_POST['search']['value'],
			"token" => $this->security->get_csrf_hash()
			
        );
        echo json_encode($response);
    }

    public function verifyFundProof($userId){
		$permission = checkAuthorization('FUNDPROOF','LIST');
        $data['userId'] = $userId;
		$data['result'] = $this->user_model->getuserprofile($data);
		$data['area'] = $_GET['area'];
		$data['editpermission'] = checkAuthorization('FUNDPROOF','EDIT');
		
		$FundJsonstr =  $data['result']->proof_funds;
		$fundProofArr = json_decode($FundJsonstr,true);
		// print '<pre>';
		// print_r($fundProofArr);
		// die;
		if($permission)
		{
		if($fundProofArr['mode'] == 'online')
		{
			$acesstokensArr = $fundProofArr['accesstokens'];
			if(is_array($acesstokensArr) && count($acesstokensArr)>0)
			{
				foreach($acesstokensArr as $v)
				{
					//echo $v;
					$fundHistory = $this->admin_model->getfundhistory($userId,$v);
					
					if($fundHistory->id >0)
					{
						$arr = json_decode($fundHistory->fund_details,true);
					}else{
						$url = PLAID_URL.'/accounts/balance/get';
						// User account info
						//$userData = $this->input->post();
						$userData = [
							"client_id"=>PLAID_CLIENT_ID,
							"secret"=>PLAID_CLIENT_SECRET,
							'access_token'=>$v
						];
						// Create a new cURL resource
						$ch = curl_init($url);
						curl_setopt($ch, CURLOPT_TIMEOUT, 30);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
						curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
						curl_setopt($ch, CURLOPT_HTTPHEADER, array(
							'Content-Type: application/json'
							));
						curl_setopt($ch, CURLOPT_POST, 1);
						curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($userData));
						$result = curl_exec($ch);
						curl_close($ch);
						$arr = json_decode($result,true);
						//sendEmail('surajit@eclick.co.in', 'test eclick', $result);

						$arrData['userId'] = $userId;
						$arrData['asset_token'] = $v;
						$arrData['fund_details'] = $result;
						$arrData['date_added'] = date('Y-m-d H:i:s');
						$this->admin_model->setfundhistory($arrData);
					}
					
                    $resultArr[] = $arr;
				}
			}
			
			if(is_array($resultArr) && count($resultArr)>0)
			{
				foreach($resultArr as $k=>$vBank)
				{
					$bankItems = $vBank['accounts'];
					if(is_array($bankItems) && count($bankItems)>0)
					{
						$totalFortheBank = 0;
						foreach($bankItems as $k=>$v)
						{
							if($v['type'] == 'depository')
							{
								$totalFortheBank = $totalFortheBank+$v['balances']['available'];

							}
						}
						$totalAsset = $totalAsset+$totalFortheBank;
					}
				}
			}
			
			foreach($acesstokensArr as $v)
			{
				$arrHistory1['date_approved'] = $curDate;
				$arrHistory1['userId'] = $userId;
				$arrHistory1['asset_token'] = $v;
				$arrHistory1['approved_fund'] = $this->security->xss_clean($totalAsset);
				$result = $this->admin_model->updatefundapprovehistory($arrHistory1);
			}
			//die;
			// $asset_report_tokens = $fundProofArr['asset_report_tokens'];
			
			// if(is_array($asset_report_tokens) && count($asset_report_tokens)>0)
			// {
			// 	foreach($asset_report_tokens as $v)
			// 	{
			// 		$fundHistory = $this->admin_model->getfundhistory($userId,$v);
					
			// 		if($fundHistory->id >0)
			// 		{
			// 			$arr = json_decode($fundHistory->fund_details,true);
			// 		}else{
			// 			$url = PLAID_URL.'/asset_report/get';
			// 			// User account info
			// 			//$userData = $this->input->post();
			// 			$userData = [
			// 				"client_id"=>PLAID_CLIENT_ID,
			// 				"secret"=>PLAID_CLIENT_SECRET,
			// 				'asset_report_token'=>$v,
			// 				"include_insights"=> false,
							
			// 			];
			// 			// Create a new cURL resource
			// 			$ch = curl_init($url);
			// 			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			// 			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			// 			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			// 			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			// 				'Content-Type: application/json'
			// 				));
			// 			//curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . $apiKey));
			// 			//curl_setopt($ch, CURLOPT_USERPWD, "$apiUser:$apiPass");
			// 			curl_setopt($ch, CURLOPT_POST, 1);
			// 			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($userData));
			// 			$result = curl_exec($ch);
			// 			curl_close($ch);
			// 			$arr = json_decode($result,true);

			// 			$arrData['userId'] = $userId;
			// 			$arrData['asset_token'] = $v;
			// 			$arrData['fund_details'] = $result;
			// 			$arrData['date_added'] = date('Y-m-d H:i:s');
			// 			$this->db->insert(TABLE_PREFIX.'fund_history', $arrData);
			// 		}
					
			// 		$resultArr[] = $arr;
			// 	}
			// }

			
			$data['bankBal'] = $resultArr;

		}elseif($fundProofArr['mode'] == 'offline')
		{
			$data['offlinefundsummery'] = $this->admin_model->getofflinefundhistory($userId,$data['result']->fund_proof_approve_date);
			//print '<pre>';
			//echo $data['result']->fund_proof_approve_date;
			//print_r($data['offlinefundsummery']);
			//die;
		}
		}
        $getUserData = $this->admin_model->getUserDetails($this->session->userdata('administrator_owner_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'proof-verification';
		$header['userData'] = $getUserData;
		
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/verify-fund-proofs',$data);
		else
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}
	
	public function approveFund($userId){
		$userWalletBalance = $this->front_model->getwalletBalance($userId);
		$totalAsset = $this->input->post('totalAsset');
		$area= $this->input->post('area');
		$curDate = date('Y-m-d H:i:s');
		$arr['userId'] = $userId;
		$arr['fund_proof_approve_date'] = $curDate;
		$arr['proof_fund_status'] = 1;
		$arr['fund_approved_amount'] = $this->security->xss_clean($totalAsset)+$userWalletBalance;
		//$randomstring = strtoupper(substr(str_shuffle(RANDOM_CHAR), 0, 10));
		$randomstring = $this->front_model->setinvestorpassref();
		$arr['Investor_pass'] = $randomstring;
		$result = $this->user_model->updateuserdetails($arr);
		
		$arrHistory['userId'] = $userId;
		$arrHistory['investor_pass'] = $randomstring;
		$arrHistory['activity'] = 'CREATEPASS';
		$arrHistory['unlocked_business'] = 0;
		$this->admin_model->investor_pass_history($arrHistory);

		$data['userId'] = $userId;
        $data['result'] = $this->user_model->getuserprofile($data);
		$FundJsonstr =  $data['result']->proof_funds;
		$fundProofArr = json_decode($FundJsonstr,true);
		if($fundProofArr['mode'] == 'online')
		{
			$asset_report_tokens = $fundProofArr['asset_report_tokens'];
			
			if(is_array($asset_report_tokens) && count($asset_report_tokens)>0)
			{
				foreach($asset_report_tokens as $v)
				{
					$arrHistory1['date_approved'] = $curDate;
					$arrHistory1['userId'] = $userId;
					$arrHistory1['asset_token'] = $v;
					$arrHistory1['approved_fund'] = $this->security->xss_clean($totalAsset);
					//$result = $this->admin_model->updatefundapprovehistory($arrHistory1);
				}
			}
		}else{
			$banks = $this->input->post('banks');
			$availableBal = $this->input->post('availableBal');
			if(is_array($banks) && count($banks)>0)
			{
				foreach($banks as $k=>$v)
				{
					$amount =  trim($this->security->xss_clean($availableBal[$k]));
					$bankName =  trim($this->security->xss_clean($v));
					if($amount>0 && $bankName !='')
					{
						$fundHistory[] = ['bank'=>$bankName, 'balance'=>$amount];
					}

					$arrData['userId'] = $userId;
					$arrData['asset_token'] = '';
					$arrData['fund_details'] = json_encode($fundHistory);
					$arrData['date_added'] = $curDate;
					$arrData['date_approved'] = $curDate;
					$arrData['approved_fund'] = $this->security->xss_clean($totalAsset);
					$this->db->insert(TABLE_PREFIX.'fund_history', $arrData);

				}
			}
		}
		$userDetails = $this->front_model->getAdminDetails($userId);
        $user_to = $userDetails['mail'];
        $user_subject = 'Your proof of funds request has been approved - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$userDetails['fname'].'</strong>,</h6>
		<br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Good news! Your proof of funds has been reviewed &amp; approved. You can now view businesses up to &amp; slightly above the total amount of
		assets verified.</p>
		<br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);

		$notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $userId;
        $notificationarr['notification_text'] = 'Your proof of funds request has been approved.';
        $notificationarr['notification_type'] = 'FUNDAPPROVED';
        $notificationarr['notification_type_id'] = $userId;
        $result = $this->front_model->insertnotification($notificationarr);

		$this->session->set_flashdata('success', 'Fund proof approved successfully.');
		if($area == 'user')
		{
			redirect('administrator/users/edit/'.$userId); 
		}
		redirect('administrator/verifications/fund-proof');  
	}

	public function submitUserIdentityProof(){
		if(!empty($_FILES['file']['name'])){
			$filecontent = file_get_contents($_FILES['file']['tmp_name']); 
		}
		$filename = $_FILES['file']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		
		//-----
		$data = $this->input->post();
        $filename = $data['user_id'].'_'.time().'.'.$ext;
        $uploadPath = "./uploads/proof_documents/".$filename;
        file_put_contents($uploadPath,base64_decode($data['imageContent']));
        
        $documents = $filename;
        $action = 'add';
        $dataUpdate['userId'] = $data['user_id'];
        $dataUpdate['documents'] = $documents;
        $dataUpdate['doc_type'] = 'indentity';
        $result = $this->user_model->userdocumentproof($dataUpdate,$action);
	}
	public function submitUserFundProof(){
		if(!empty($_FILES['file']['name'])){
			$filecontent = file_get_contents($_FILES['file']['tmp_name']); 
		}
		$filename = $_FILES['file']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		
		$data = $this->input->post();
        $filename = $data['user_id'].'_'.time().'.'.$ext;
        $uploadPath = "./uploads/proof_documents/".$filename;
        file_put_contents($uploadPath,base64_decode($data['imageContent']));
        $documents = $filename;
        $action = 'add';
        $dataUpdate['userId'] = $data['user_id'];
        $dataUpdate['documents'] = $documents;
        $dataUpdate['doc_type'] = 'fund';
        $result = $this->user_model->userdocumentproof($dataUpdate,$action);
        
	}
	public function proofoffundaction(){
		if(checkAuthorization('FUNDPROOF','EDIT'))
		{
		$data = $this->input->post();
		//print '<pre>';
		//print_r($data);
		//die;
		$area= $this->input->post('area');
		$documentsDetails = $this->user_model->getUserDocuments($data['user_id'],'fund');
        $documenttypes = json_decode($data['proof'],true);
		
		foreach($documentsDetails as $val)
		{
			$proofDocuments[] = $val['documents'];
		}

		$proofFinalArray = ['documents'=>$proofDocuments,'documentproof'=>$data['proof'],'mode'=>'offline'];
		$arr['userId'] = $data['user_id'];
		$arr['proof_funds'] = json_encode($proofFinalArray);
		$arr['proof_fund_status'] = 2;
		$arr['fund_proof_submit_date'] = date('Y-m-d H:i:s');
		$result = $this->user_model->updateuserdetails($arr);
		//$this->user_model->removedocdata($arr);
		$this->db->delete(TABLE_PREFIX.'proof_of_funds', array('userId' => $data['user_id'], 'doc_type'=>'fund'));
		

		//--------------
		$userId = $data['user_id'];
		$userWalletBalance = $this->front_model->getwalletBalance($userId);
		$totalAsset = $data['totalAsset'];
		$curDate = date('Y-m-d H:i:s');
		$arr['userId'] = $userId;
		$arr['fund_proof_approve_date'] = $curDate;
		$arr['proof_fund_status'] = 1;
		$arr['fund_approved_amount'] = $this->security->xss_clean($totalAsset)+$userWalletBalance;
		//$randomstring = strtoupper(substr(str_shuffle(RANDOM_CHAR), 0, 10));
		$randomstring = $this->front_model->setinvestorpassref();
		$arr['Investor_pass'] = $randomstring;
		$result = $this->user_model->updateuserdetails($arr);

		$arrHistory['userId'] = $userId;
		$arrHistory['investor_pass'] = $randomstring;
		$arrHistory['activity'] = 'CREATEPASS';
		$arrHistory['unlocked_business'] = 0;
		$this->admin_model->investor_pass_history($arrHistory);

		$data1['userId'] = $userId;
        $data1['result'] = $this->user_model->getuserprofile($data1);
		$FundJsonstr =  $data1['result']->proof_funds;
		$fundProofArr = json_decode($FundJsonstr,true);
		$banks = $data['banks'];
		$availableBal = $data['availableBal'];
		
		if(is_array($banks) && count($banks)>0)
		{
			foreach($banks as $k=>$v)
			{
				$amount =  trim($this->security->xss_clean($availableBal[$k]));
				$bankName =  trim($this->security->xss_clean($v));
				if($amount>0 && $bankName !='')
				{
					$fundHistory[] = ['bank'=>$bankName, 'balance'=>$amount];
				}

				$arrData['userId'] = $userId;
				$arrData['asset_token'] = '';
				$arrData['fund_details'] = json_encode($fundHistory);
				$arrData['date_added'] = $curDate;
				$arrData['date_approved'] = $curDate;
				$arrData['approved_fund'] = $this->security->xss_clean($totalAsset);
				$this->db->insert(TABLE_PREFIX.'fund_history', $arrData);

			}
		}else{
			$arrData['userId'] = $userId;
			$arrData['asset_token'] = '';
			$arrData['fund_details'] = '';
			$arrData['date_added'] = $curDate;
			$arrData['date_approved'] = $curDate;
			$arrData['approved_fund'] = $this->security->xss_clean($totalAsset);
			$this->db->insert(TABLE_PREFIX.'fund_history', $arrData);
		}

		$userDetails = $this->front_model->getAdminDetails($userId);
        $user_to = $userDetails['mail'];
        $user_subject = 'Your proof of funds request has been approved - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$userDetails['fname'].'</strong>,</h6>
		<br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Good news! Your proof of funds has been reviewed &amp; approved. You can now view businesses up to &amp; slightly above the total amount of
		assets verified.</p>
		<br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);

		$notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $userId;
        $notificationarr['notification_text'] = 'Your proof of funds request has been approved.';
        $notificationarr['notification_type'] = 'FUNDAPPROVED';
        $notificationarr['notification_type_id'] = $userId;
        $result = $this->front_model->insertnotification($notificationarr);
		$this->session->set_flashdata('success', 'Fund proof approved successfully.');
		}
		if($area == 'user')
		{
			redirect('administrator/users/edit/'.$userId); 
		}
		redirect('administrator/verifications/fund-proof');


	}


}