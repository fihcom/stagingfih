<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

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
		$this->load->library(array('form_validation', "upload", "M_pdf")); // , "Excel_export"
		if($this->session->userdata('roleText') != 'admin'){
            redirect(base_url().'administrator/login');
            exit();
        }
        if($this->session->userdata('isLoggedIn') != TRUE){
            redirect(base_url().'administrator/login');
            exit();
        }

	}

	

	public function dashboard()
	{
		//$getResult = $this->front_model->getMarketplaceListing($editArray);
		//print '<pre>';
		//print_r($this->session->userdata('authorize'));
		//die;
		//echo $this->session->userdata('authorize');
		
		$arr['userId'] = 1;
		$arr['page'] = 0;
		$arr['limit'] = 20;
		$notificationDetails = $this->notificationdetails($arr);
		
		$notificationDetails['notificationlimit'] = $arr['limit'];
		$notificationDetails['notificationstart'] = $arr['page'];

		$this->load->view('backend/includes/header');
		$this->load->view('backend/dashboard',$notificationDetails);
		$this->load->view('backend/includes/footer');
	}
	function notificationdetails($arr){
		$notificationDetails = $this->front_model->usernotifications($arr);
		if(is_array($notificationDetails['notification']) && count($notificationDetails['notification'])>0)
		{
			foreach($notificationDetails['notification'] as $k=>$v)
			{
				$notificationType = $v['notification_type'];
				if($notificationType == 'WALLET')
				{
					$adminLink = 'administrator/wallet-addmoney-request/'.$v['notification_type_id'];
				}elseif($notificationType == 'WALLETWITHDRAW')
				{
					$adminLink = 'administrator/wallet-addmoney-request/'.$v['notification_type_id'];
				}elseif($notificationType == 'SUPPORTTICKET')
				{
					$this->db->select('h.*', FALSE);
                    $this->db->from(TABLE_PREFIX.'ticketing as h', FALSE);
                    $this->db->where('h.id', $v['notification_type_id']);
                    $this->db->limit(1);
                    $query = $this->db->get();        
                    $uncovered = $query->row();
					$adminLink = 'administrator/ticket/details/'.$uncovered->ticket_no;
				}elseif($notificationType == 'FAQREPLY')
				{
					$adminLink = 'administrator/faq/edit/'.$v['notification_type_id'];
				}elseif($notificationType == 'BUYNOWREQ')
				{
					$adminLink = 'administrator/listing-buy-request/'.$v['notification_type_id'];
				}elseif($notificationType == 'OFFER')
				{
					$adminLink = 'administrator/listing-offers/'.$v['notification_type_id'];
					
				}elseif($notificationType == 'MANUALFUNDAPPROVAL')
				{
					$adminLink = 'administrator/verifications/verify-fund-proof/'.$v['notification_type_id'];
				}elseif($notificationType == 'MANUALIDAPPROVAL')
				{
					$adminLink = 'administrator/verifications/verify-identity-proof/'.$v['notification_type_id'];
				}elseif($notificationType == 'CONTACTUS')
				{
					$adminLink = 'administrator/contactus/details/'.$v['notification_type_id'];
				}elseif($notificationType == 'LISTINGREQ')
				{
					$adminLink = 'administrator/sell-request/sell-details/'.$v['notification_type_id'];
				}
				$notificationDetails['notification'][$k]['admin_link'] = $adminLink;
			}
		}
		return $notificationDetails;
	}
	public function edit_profile(){
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'site-settings';
		$header['userData'] = $getUserData;
		$data['admin_details'] = $getUserData;
        $this->load->view('backend/includes/header', $baseInfo);
        $this->load->view('backend/admin-edit-user-profile', $data);
        $this->load->view('backend/includes/footer');
	}

	public function submitUserPic()
    {
        $sess_data = array();
        if(!empty($_FILES['file']['name'])){
            
            $adminID = $this->session->userdata('user_id');
            
            $uploadPath = "./uploads/profile_pictures/";
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
				$getResult = $this->front_model->updateAdminDetails($editArray, $adminID);
			}
            /*if($this->upload->do_upload('file')){
              // Get data about the file
                
                
                $editArray['user_profile_pic'] = ($this->upload->do_upload('file')) ? $fileData['file_name'] : '';
                $getResult = $this->front_model->updateAdminDetails($editArray, $adminID);
                $sessionArray['profile_picture'] = getUserProfilePicThumbUrl($editArray['user_profile_pic']);
                $this->session->set_userdata($sessionArray);
            }*/
        }
	}

	public function sellRequest(){
		$permission = checkAuthorization('BUSINESSAPPLICATION','LIST');

		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'sellrequest';
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/sell-request');
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}
	public function getSellRequest(){
		//$sellRequests = $this->admin_model->getsellrequest();
		//if()
		$editpermission = checkAuthorization('BUSINESSAPPLICATION','APPROVE');
		$deletepermission = checkAuthorization('BUSINESSAPPLICATION','DELETE');

		$draw = $_POST['draw'];
        $data['start'] = $_POST['start'];
		$data['limit'] = $_POST['length'];
        $data['searchValue'] = $_POST['searchName'];
		$data['searchStatus'] = $_POST['searchByStatus'];
		$sort = $_POST['order'][0];
        $sellRequests = $this->admin_model->getsellrequest($data,$sort);
		$dataArr = [];
        if(is_array($sellRequests['sellrequests']) && count($sellRequests['sellrequests'])>0)
        {
            
            $i = $data['start']+1;
            foreach($sellRequests['sellrequests'] as $v)
            {
				$datares['sl_no'] = $i;
				$json_text = $v['data_json'];
				$jsonArr = json_decode($json_text,true);
				
                $i++;
				$datares['fname'] = $v['clientName'];
				$datares['mail'] = '<a target="_blank" href="'.base_url().'administrator/users/edit/'.$v['userId'].'">'.$v['mail'].'</a>';
				$datares['listing'] = '<a href="'.base_url().'administrator/sell-request/sell-request-process/'.$v['id'].'">'.$v['listing_id'].'</a>';
				$datares['website'] = $jsonArr['website'][0];
				$promotype = $jsonArr['promo_details']['promotype'];
				if($jsonArr['promo_details']['promocode'] !='')
				{
					if($promotype == 'ADMIN')
					{
						$typegenerator  = $jsonArr['promo_details']['promocode'].'(A)';
					}elseif($promotype == 'USER')
					{
						$promorefererId = $jsonArr['promo_details']['id'];
						$typegenerator = '<a href="'.base_url().'administrator/users/edit/'.$promorefererId.'">'.$jsonArr['promo_details']['promocode'].'(U)</a>';

					}else{
						$typegenerator = $jsonArr['promo_details']['promocode'].'(A)';

					}
					$datares['coupon'] = $typegenerator;
				}else{
					$datares['coupon'] = '33';
				}
				
				
				$datares['amount'] = $sellRequests['currency'][0]['symbol'].$v['paid_amount'];
				if($v['Status'] == 1)
				{
					$datares['status'] = 'Pending';
				}elseif($v['Status'] == 2)
				{
					$datares['status'] = 'Rejected';
				}elseif($v['Status'] == 3)
				{
					$datares['status'] = 'Approved';
				}
                //$datares['status'] = $v['Status'];
				$datares['date'] = date('jS M Y',strtotime($v['last_updated']));
				//$datares['action'] = '';
				if($editpermission)
				{
					$approve = '<a href="'.base_url().'administrator/sell-request/sell-request-process/'.$v['id'].'" class="btn-sm btn-primary editrec"><i class="fa fa-plus" aria-hidden="true"></i></a>';
				}
				if($deletepermission)
				{
					$delete = '&nbsp;<a href="javascript: void(0)" onclick="deleterecord(this)" datadeletehref="'.base_url().'administrator/sell-request/reject/'.$v['id'].'/'.$v['userId'].'" class="btn-sm btn-danger deleterec"><i class="fa fa-trash" aria-hidden="true"></i></a>';
				}
				if($v['Status'] == 2)
				{
					$datares['action'] = '<a href="'.base_url().'administrator/sell-request/sell-details/'.$v['id'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
				}else{
					$datares['action'] = $approve.'&nbsp;<a href="'.base_url().'administrator/sell-request/sell-details/'.$v['id'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>'.$delete;
				}
				
                $dataArr[] = $datares;
            }
        }
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $sellRequests['totalrecord']->totalrecord,
            "recordsFiltered" => $sellRequests['totalrecord']->totalrecord,
			"data" => $dataArr,
			"token" => $this->security->get_csrf_hash()
			
        );
        echo json_encode($response);
	}
	public function valuationRequest(){
		$permission = checkAuthorization('VALUATIONAPPLICATION','LIST');

		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'sellrequest';
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/valuation-request');
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}
	public function getValuationRequest(){
		//$sellRequests = $this->admin_model->getsellrequest();
		//if()
		$editpermission = checkAuthorization('BUSINESSAPPLICATION','APPROVE');
		$deletepermission = checkAuthorization('BUSINESSAPPLICATION','DELETE');

		$draw = $_POST['draw'];
        $data['start'] = $_POST['start'];
		$data['limit'] = $_POST['length'];
        $data['searchValue'] = $_POST['searchName'];
		$data['searchStatus'] = $_POST['searchByStatus'];
		$sort = $_POST['order'][0];
        $sellRequests = $this->admin_model->getvaluationrequest($data,$sort);
		$dataArr = [];
        if(is_array($sellRequests['sellrequests']) && count($sellRequests['sellrequests'])>0)
        {
            
            $i = $data['start']+1;
            foreach($sellRequests['sellrequests'] as $v)
            {
				$datares['sl_no'] = $i;
				$json_text = $v['data_json'];
				$jsonArr = json_decode($json_text,true);
				
                $i++;
				$datares['fname'] = $v['clientName'];
				$datares['mail'] = '<a target="_blank" href="'.base_url().'administrator/users/edit/'.$v['userId'].'">'.$v['mail'].'</a>';
				$datares['phone'] = $v['phone'];
				$datares['website'] = $jsonArr['website'][0];
				$datares['monetization'] = $v['monetizationRec'];
				//$promotype = $jsonArr['promo_details']['promotype'];
				// if($jsonArr['promo_details']['promocode'] !='')
				// {
				// 	if($promotype == 'ADMIN')
				// 	{
				// 		$codeShow  = $jsonArr['promo_details']['promocode'].'(A)';
				// 	}elseif($promotype == 'USER')
				// 	{
				// 		$promorefererId = $jsonArr['promo_details']['id'];
				// 		$typegenerator = '<a href="'.base_url().'administrator/users/edit/'.$promorefererId.'">'.$jsonArr['promo_details']['promocode'].'(U)</a>';

				// 	}else{
				// 		$typegenerator = $jsonArr['promo_details']['promocode'].'(A)';

				// 	}
				// 	$datares['coupon'] = $typegenerator;
				// }else{
				// 	$datares['coupon'] = '';
				// }
				$datares['valuationdate'] = date('jS M @ g:i a',strtotime($v['last_updated']));
				
				
				$datares['amount'] = $sellRequests['currency'][0]['symbol'].number_format(($v['valuationArr']['profit']*$v['valuationArr']['multiple']),2);
				//$datares['amount'] = $v['valuation_json'];
				// if($v['Status'] == 1)
				// {
				// 	$datares['status'] = 'Pending';
				// }elseif($v['Status'] == 2)
				// {
				// 	$datares['status'] = 'Rejected';
				// }elseif($v['Status'] == 3)
				// {
				// 	$datares['status'] = 'Approved';
				// }
                // //$datares['status'] = $v['Status'];
				// $datares['date'] = date('jS M Y',strtotime($v['last_updated']));
				//$datares['action'] = '';
				$datares['multiple'] = number_format($v['valuationArr']['multiple'],2).'x';
				// if($editpermission)
				// {
				// 	$approve = '<a href="'.base_url().'administrator/sell-request/sell-request-process/'.$v['id'].'" class="btn-sm btn-primary editrec"><i class="fa fa-plus" aria-hidden="true"></i></a>';
				// }
				// if($deletepermission)
				// {
				// 	$delete = '&nbsp;<a href="javascript: void(0)" onclick="deleterecord(this)" datadeletehref="'.base_url().'administrator/sell-request/reject/'.$v['id'].'/'.$v['userId'].'" class="btn-sm btn-danger deleterec"><i class="fa fa-trash" aria-hidden="true"></i></a>';
				// }
				if($v['Status'] == 2)
				{
					$datares['action'] = '<a target="blank" href="'.base_url().'user/valuation//'.$v['listing_id'].'?id='.$v['userId'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
				}else{
					$datares['action'] = '<a target="blank" href="'.base_url().'user/valuation//'.$v['listing_id'].'?id='.$v['userId'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
				}
				
                $dataArr[] = $datares;
            }
        }
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $sellRequests['totalrecord']->totalrecord,
            "recordsFiltered" => $sellRequests['totalrecord']->totalrecord,
			"data" => $dataArr,
			"token" => $this->security->get_csrf_hash()
			
        );
        echo json_encode($response);
	}


	public function approvedSell(){
		$permission = checkAuthorization('LISTING','LIST');
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'sellrequest';
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/approved-sell');
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}
	public function getApprovedSell(){
		//$sellRequests = $this->admin_model->getsellrequest();
		//if()
		$editpermission = checkAuthorization('LISTING','EDIT');
		$deletepermission = checkAuthorization('LISTING','DELETE');
		$draw = $_POST['draw'];
        $data['start'] = $_POST['start'];
		$data['limit'] = $_POST['length'];
        $data['searchValue'] = $_POST['searchName'];
		$data['searchStatus'] = $_POST['searchByStatus'];
		$sort = $_POST['order'][0];
        $sellRequests = $this->admin_model->getapprovedsell($data,$sort);
		$dataArr = [];
        if(is_array($sellRequests['sellrequests']) && count($sellRequests['sellrequests'])>0)
        {
            
            $i = $data['start']+1;
            foreach($sellRequests['sellrequests'] as $v)
            {
				//$datares['sl_no'] = $i;
				$json_text = $v['data_json'];
				$jsonArr = json_decode($json_text,true);
				
                $i++;
				$datares['fname'] = $v['clientName'];
				$datares['email'] = '<a target="_blank" href="'.base_url().'administrator/users/edit/'.$v['userId'].'">'.$v['mail'].'</a>';
				$datares['phone'] = $v['phone'];
				$datares['listing'] = '<a target="_blank" href="'.base_url().'administrator/sell-request/sell-request-process/'.$v['id'].'">'.$v['listing_id'].'</a>';
				$datares['website'] = $jsonArr['website'][0];
				if($v['show_home'] == 'Y')
				{
					$checked = ' checked="checked"';
					$showInfo = 'Yes';
				}else{
					$checked = '';
					$showInfo = 'No';
				}
				if($editpermission && ($v['Status'] == 1 || $v['Status'] == 4 || $v['Status'] == 3))
				{
				$datares['showhome'] = '<label class="switch"><input id="showhome'.$v['approvedid'].'" type="checkbox" name="changehome" '.$checked.' onclick="toggleHome('.$v['approvedid'].')"><span class="slider round"></span></label>';
				}else{

					$datares['showhome'] = $showInfo;
				}
				if($v['Status'] == 1)
				{
					$datares['status'] = 'Published';
				}elseif($v['Status'] == 0)
				{
					$datares['status'] = 'Inactive';
				}elseif($v['Status'] == 2)
				{
					$datares['status'] = 'Pending Publish';
				}elseif($v['Status'] == 3)
				{
					$datares['status'] = 'Pending Sell';
				}elseif($v['Status'] == 4)
				{
					$datares['status'] = 'Sold';
				}
                //$datares['status'] = $v['Status'];
				$datares['date'] = date('jS M Y',strtotime($v['last_updated']));
				//$datares['action'] = '';
				if($editpermission)
				{
					$edit = '&nbsp;<a href="'.base_url().'administrator/sell-request/sell-request-process/'.$v['id'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
				}
				if($deletepermission)
				{
					$delete = '&nbsp;<a href="javascript: void(0)" onclick="deleterecord(this)" datadeletehref="'.base_url().'administrator/sell-request/deleteapproved/'.$v['id'].'/'.$v['userId'].'" class="btn-sm btn-danger deleterec"><i class="fa fa-trash" aria-hidden="true"></i></a>';
				}
				if($v['Status'] == 1)
				{
					$datares['action'] = '<a target="_blank" href="'.base_url().'listing/'.$v['listing_id'].'" class="btn-sm btn-primary editrec"><i class="fa fa fa-eye" aria-hidden="true"></i></a>'.$edit.$delete;
					if($v['sell_answers_status'] == 1 && $edit)
					{
						$datares['action'] .= '&nbsp;<a target="_blank" href="'.base_url().'administrator/approved-sell/question-answer/'.$v['listing_id'].'" class="btn-sm btn-primary"><i class="fa fa fa-info" aria-hidden="true"></i></a>';
					}
				}else{
					//$datares['action'] = '<a href="'.base_url().'administrator/sell-request/sell-request-process/'.$v['id'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;<a href="javascript: void(0)" onclick="deleterecord(this)" datadeletehref="'.base_url().'administrator/sell-request/deleteapproved/'.$v['id'].'/'.$v['userId'].'" class="btn-sm btn-danger deleterec"><i class="fa fa-trash" aria-hidden="true"></i></a>';
					$datares['action'] = $edit.$delete;
					if($v['sell_answers_status'] == 1 && $edit)
					{
						$datares['action'] .= '&nbsp;<a href="'.base_url().'administrator/approved-sell/question-answer/'.$v['listing_id'].'" class="btn-sm btn-primary"><i class="fa fa fa-info" aria-hidden="true"></i></a>';
					}
				}
				
                $dataArr[] = $datares;
            }
        }
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $sellRequests['totalrecord']->totalrecord,
            "recordsFiltered" => $sellRequests['totalrecord']->totalrecord,
			"data" => $dataArr,
			"token" => $this->security->get_csrf_hash()
			
        );
        echo json_encode($response);
	}

	public function listingshowhome(){
		$permission = checkAuthorization('LISTING','EDIT');
		if($permission)
		{
			$listing_id = $this->input->post('listing_id');
			$showhome = $this->input->post('showhome');
			$editarr['show_home'] = $showhome;
			//$this->db->where('listing_temp_id', $listing_id);
            //unset($Arr['id']);
            //$this->db->update(TABLE_PREFIX.'sell_record', $editarr);
			$this->admin_model->updateApprovedSell($editarr,$listing_id);
		}
		$token = $this->security->get_csrf_hash();
		echo json_encode(['token'=>$token,'arr'=>$editarr,'lid'=>$listing_id]);
	}

	public function processSellRequest($id){

		$permission = checkAuthorization('LISTING','EDIT');
		if(!$permission)
		{
			$permission = checkAuthorization('BUSINESSAPPLICATION','EDIT');
		}
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'sellrequest';
		$data['monetization'] = $this->user_model->getmonetization();
		$data['req_id'] = $id;
		$getData = $this->admin_model->gettempselldata($id);
		
		$data['tempdata'] = json_decode($getData->data_json,true);
		
		$data['assets'] = $this->admin_model->listassets('active');

		$getApproveddata = $this->admin_model->getapprovedselldata($id);

		// print_r($getApproveddata);
		
		if($getApproveddata->id >0)
		{
			$data['tempdata']['monetization'] = json_decode($getApproveddata->monetization,true);
			$data['tempdata']['website'] = json_decode($getApproveddata->website,true);
			$data['tempdata']['businessstartdate'] = $getApproveddata->business_create_date;
			$data['tempdata']['workinghour'] = $getApproveddata->working_hour;
			$assetlist = json_decode($getApproveddata->asset_list,true);
			if(is_array($assetlist) && count($assetlist)>0)
			{
				$extraassetstr = '';
				foreach($assetlist as $v){
					if($v['id'] == 'extra' && $v['value']!='')
					{
						$extraassetstr .= $v['value'].'|';
					}elseif($v['id']>0 && $v['value']!='')
					{
						//echo 'k';
						$assetsval[$v['id']] = $v['value'];
					}
				}
				$data['extraassets'] = rtrim($extraassetstr,'|');
				$data['addedassets'] = $assetsval;
			}
		}else{
			$getApproveddata->listing_id = $getData->listing_id;
		}
		//print '<pre>';
		//print_r($data['addedassets']);
		//die;

		// Sourav Das Code - 20082024
		$getUncoverData = $this->admin_model->getPassHistoryByListing($getApproveddata->listing_id);

		
		
		$data['industries'] = $this->admin_model->listindustry('active');
		$data['countries'] = $this->admin_model->listcountry();
		$data['storedData'] = $getApproveddata;
		$data['uncoverData'] = $getUncoverData;

		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/process-sell-request',$data);
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}

	public function downloadNDA($userId, $listingID){
		/*echo $userId;
		echo '<br/>';
		echo $listingID;*/

		$getUserData = $this->admin_model->getUserDetails($userId);
		$getUncoveredListDetails = $this->admin_model->getUncoveredListByID($listingID);
		$getDigiSign = $this->admin_model->getUserDigiSign($userId);
		$decryptJson = json_decode($getUncoveredListDetails['dJson'], true);

		/*pre($getDigiSign);
		exit();

		echo base_url().'/uploads/user_digital_signature/'.$getDigiSign->documents;
		exit();*/

		/*echo '<pre>';
		print_r($decryptJson['website']);
		echo '</pre>';
		exit();*/
		

		$genHTML = '<table style="border-collapse: collapse;">
						<tr>
							<td style="padding:0 0 26px 0; font-size:20px;line-height:26px;">
								<strong>FIH.com NON-DISCLOSURE AGREEMENT</strong>
							</td>
						</tr>
						<tr>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">
								Please read the following Non-Disclosure Agreement ("Agreement") carefully. By signing
								this agreement (or clicking on the "I accept" button you are indicating your acceptance
								of this Non-Disclosure Agreement and agree to be legally bound by it.
							</td>
						</tr>
						<tr>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">
								For the purposes of this Agreement, <strong>"Business"</strong> means any business currently
								advertised and offered for sale by FIH.com (which a Buyer wants to view confidential
								information for in connection with a possible transaction).
							</td>
						</tr>
						<tr>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">
								<strong>"Seller"</strong> means the owner or representative of a given Business a buyer views
								confidential information about.
							</td>
						</tr>
						<tr>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">
								<strong>“FIH” “FIH.com”</strong> or <strong>“FIH LLC”</strong> means the people from FIH.com who act as
								representatives/contact-points/brokers for the Business.
							</td>
						</tr>
						<tr>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">
								<strong>"You"</strong> or <strong>"Your"</strong> or <strong>"Buyer"</strong> means the person or company who is interested in acquiring
								the Business.
							</td>
						</tr>
						<tr>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">
								For the purpose of this Agreement, You and the Seller and FIH.com are each a "Party" and collectively "The Parties."
							</td>
						</tr>
					</table>
					<table style="overflow: wrap;page-break-after: always;">
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">1.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">This Agreement is effective as of the date of Your acceptance of this Agreement.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">2.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">You wish to evaluate the Business and engage in discussions with the Seller in connection with Your possible acquisition of the Business ("Purpose").</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">3.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">The Seller wishes to disclose certain Confidential Information to You relating tothe Purpose. You enter into this Agreement to protect the confidentiality of the Confidential Information, on the terms set out below.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">4.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">You acknowledge and agree that terms of this Agreement are binding upon You and enforceable by the Seller.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">5.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">"Confidential Information" means any information provided by the Seller or any of its Personnel to You or any of your Personnel for or in connection with the Purpose, including: (a) information designated as confidential by the Seller; (b) information imparted in circumstances of confidence; or (c) information that You know, or ought to know, is confidential, but excluding information which is already known by You at the time it is disclosed, or which is or becomes public knowledge other than by a breach of this Agreement.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">6.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">"Personnel" means any employee, officer, agent, contractor, subcontractor, student or volunteer of a Party, and any employee, officer, agent, contractor, subcontractor, student or volunteer of a contractor or subcontractor, but excludes the other Party and its Personnel.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">7.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">You acknowledge and agree that the Confidential Information is valuable.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">8.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">In consideration for the Seller providing the Confidential Information to You, You accept and agree to keep the Confidential Information confidential in accordance terms of this Agreement.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">9.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">Subject to clause 10, You must (a) keep the Confidential Information confidential and preserve its confidential nature; and (b) not use or disclose or permit the use or disclosure of Confidential Information for any purpose other than the Purpose.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">10.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">This Agreement does not prohibit the use or disclosure of Confidential Information (a) required to be disclosed by You by law or pursuant to the rules of any securities exchange; (b) by You to your legal or other advisers, subject to the relevant adviser being subject to confidentiality obligations or a confidentiality undertaking in a form reasonably satisfactory to the Seller; (c) which is necessary for the Purpose, but only to the extent necessary for the Purpose; (d) to an auditor solely for the purposes of an audit; or (e) which the Seller has agreed in writing may be used or disclosed by You, provided such use or disclosure is in accordance with the terms of that agreement.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">11.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">You must ensure (a) your Personnel are made aware of the confidential nature of the Confidential Information and the terms of this Agreement before being provided with or having access to Confidential Information; and (b) your Personnel do not do or fail to do anything that, if done or not done, would amount to a breach of your obligations under this Agreement.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">12.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">If You become aware that You have or may breach this Agreement, You must immediately notify the Seller and take all reasonable steps required to stop the breach.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">13.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">Unless agreed otherwise in writing, this Agreement and the obligations under this Agreement continue in full force and effect for three (3) years from the Commencement Date.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">14.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">You acknowledge that the Confidential Information remains the property of the Seller at all times and that this Agreement does not convey to You or any of your Personnel any proprietary or other interest in the Confidential Information.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">15.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">You must, promptly upon request by the Seller, return or destroy all material containing Confidential Information in your possession, power or control, which was either received from the Seller or which You have generated.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">16.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">You acknowledge that disclosure of any Confidential Information in breach of this Agreement would cause irreparable harm to the Seller for which damages may not be an adequate remedy.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">17.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">You consent to the grant of injunctive relief to restrain any breach of this Agreement, or specific performance to compel You to perform your obligations under this Agreement, as a remedy for any breach or threatened breach of this Agreement and in addition to any other remedies available to the Seller.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">18.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">You indemnify the Seller and FIH.com against any claims, loss, damages, costs and expenses (including legal costs on a solicitor and own client basis) that the Seller or FIH.com incurs or suffers directly or indirectly as a result of a breach of this Agreement by You, or any unauthorized use or disclosure of the Confidential Information by You or your Personnel or a person who received Confidential Information from any of them.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">19.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">This Agreement is governed by the laws of New York and You agree to submit to the non-exclusive jurisdiction of its courts.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">20.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">This Agreement shall be binding upon and for the benefit of the Parties, their successors and assigns.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">21.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">This Agreement constitutes Your entire understanding in relation to its subject matter and supersedes all prior written or oral agreements or undertakings regarding that subject matter</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">22.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">You may not assign this Agreement (or any right under it) to another person without the prior, written consent of the Seller.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">23.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">The termination or expiry of this Agreement for any reason will not extinguish Your obligations, which, either expressly or by their nature, are intended to survive termination or expiry, including clause 9.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">24.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">Without authorization from FIH.com, the buyer (and their associates) are not allowed to contact or arrange M&A-related transactions directly with the owners of a given business that FIH.com ( the broker) advertises or formally or informally represents.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">25.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">By signing this NDA, the party listed below will ensure that FIH.com will get their standard M&A fee (tiered between 2-9% net of the total deal size, including cash at closing, payments, and equity) if any business sale transactions result from their sharing of private business offering materials after this NDA is signed. All additional platform-based fees (such as those originating from a buyer choosing to view a given listing on Acquire.com, Flippa.com, etc) will be treated as buy-side fees that will be added to the cost of the transaction for the buyer. You agree that FIH nor the seller are liable for any such fees.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">26.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">You agree FIH.com is not liable for the misuse of confidential information, shared to you by them, and that any liability resulting from it, or damages demanded from the seller, will be assigned to you and not FIH.com.</td>
						</tr>
						<tr>
							<td valign="top" style="padding:0 0 22px 0;font-size:16px;line-height:22px; width:30px;"><p style="display:flex;">27.</p></td>
							<td style="padding:0 0 22px 0;font-size:16px;line-height:22px;">You agree that FIH.com does its best to verify confidential information to be accurate but FIH.com doesn’t make any guarantees to the accuracy of its information and will not be held liable for any damages resulting from its sharing of inaccurate information. The buyer will do their own independent due diligence to verify any claims made by the Seller or FIH.com.</td>
						</tr>
					</table>
					<table style="overflow: wrap;border-collapse: separate;max-width:600px; border-spacing: 20px;">
						<tr>
							<td colspan="2" style="padding:0 0 26px 0; font-size:20px;line-height:24px;"><strong>FIH/Seller Representative</strong></td>
							<td style="padding:0 0 26px 0; font-size:20px;line-height:24px; text-align:left;"><strong>Buyer</strong></td>
							<td></td>

						</tr>
						<tr>
							<td style="padding:0 0 22px 0; font-size:18px;line-height:24px;">By:</td>
							<td><span style="border-bottom:2px solid #000; padding:0 0 0 10px;"><img src="'.base_url().'/assets/backend/img/nda_pdf_imgs/signature.png" style="height:40px; object-fit: contain;" /></span></td>
							
							<td style="padding:0 0 22px 0; font-size:18px;line-height:24px;">By:</td>
							<td><strong style="font-size:18px;line-height:24px; text-transform: uppercase;">'.(!empty($getDigiSign) && $getDigiSign->documents != '' ? '<img src="'.base_url().'/uploads/user_digital_signature/'.$getDigiSign->documents.'" style="height:40px; object-fit: contain;" />' : '____________________').'</strong></td>
							
						</tr>
						<tr>
							<td style="padding:0 0 22px 0; display:flex; font-size:18px;line-height:24px;">Printed Name:</td>
							<td><span style="border-bottom:2px solid #000;"><img src="'.base_url().'/assets/backend/img/nda_pdf_imgs/neil_image.png" style="height:20px; object-fit: contain;"></span></td>
							<td style="padding:0 0 22px 0; font-size:18px;line-height:24px;">Printed Name:</td>
							<td><strong style="font-size:12px;line-height:24px; text-transform: uppercase; border-bottom:2px solid #000;">'.$getUserData->fname.' '.$getUserData->lname.'</strong></td>
						</tr>
						<tr>
							<td style="padding:0 0 22px 0;font-size:18px;line-height:24px;">Title:</td>
							<td><span style="border-bottom:2px solid #000;"><img src="'.base_url().'/assets/backend/img/nda_pdf_imgs/ceo.png" style="height:20px; object-fit: contain;"></span></td>
							
							<td style="padding:0 0 22px 0; font-size:18px;line-height:24px;">Title:</td>
							<td><strong style="font-size:12px;line-height:24px; text-transform: uppercase; border-bottom:2px solid #000;">Potential Buyer For '.$decryptJson['website'][0].'</strong></td>
							
						</tr>
						<tr>
							<td style="padding:0 0 22px 0; font-size:18px;line-height:24px;">Address:</td>
							<td><span style="border-bottom:2px solid #000;"><img src="'.base_url().'/assets/backend/img/nda_pdf_imgs/address.png" style="height:20px; object-fit: contain;"></span></td>
							
							<td style="padding:0 0 22px 0; font-size:18px;line-height:24px;">Address:</td>
							<td><strong style="font-size:12px;line-height:24px; text-transform: uppercase; border-bottom:2px solid #000;">'.$getUserData->mail.'</strong></td>
							
						</tr>
						<tr>
							<td style="padding:0 0 22px 0; font-size:18px;line-height:24px;">Dated:</td>
							<td><strong style="font-size:12px;line-height:24px; text-transform: uppercase; border-bottom:2px solid #000;">'.date('d/m/Y', strtotime($getUncoveredListDetails['date_unlocked'])).'</strong></td>
							
							<td style="padding:0 0 22px 0; font-size:18px;line-height:24px;">Dated:</td>
							<td><strong style="font-size:12px;line-height:24px; text-transform: uppercase; border-bottom:2px solid #000;">'.date('d/m/Y', strtotime($getUncoveredListDetails['date_unlocked'])).'</strong></td>
						</tr>
					</table>'; // ____________________ '.(!empty($getDigiSign) && $getDigiSign->document != '' ? '<img src="'.base_url().'/uploads/user_digital_signature/'.$getDigiSign->document.'" />' : '____________________').'
		
		// $this->m_pdf->pdf->setAutoTopMargin = 'stretch';
		/*$this->m_pdf->pdf->SetHTMLHeader('<table style="max-width:600px;">
		<tr>
			<td>
				<table style="border-collapse: collapse;max-width:600px;">
					<tr>
						<td style="padding:0 0 50px 0; font-size:80px;line-height:100px;">
							<strong>FIH.com NON-DISCLOSURE AGREEMENT</strong>
						</td>
					</tr>
					<tr>
						<td style="padding:0 0 25px 0;font-size:52px;line-height:70px;">
							Please read the following Non-Disclosure Agreement ("Agreement") carefully. By signing
							this agreement (or clicking on the "I accept" button you are indicating your acceptance
							of this Non-Disclosure Agreement and agree to be legally bound by it.
						</td>
					</tr>
					<tr>
						<td style="padding:0 0 25px 0;font-size:52px;line-height:70px;">
							For the purposes of this Agreement, <strong>"Business"</strong> means any business currently
							advertised and offered for sale by FIH.com (which a Buyer wants to view confidential
							information for in connection with a possible transaction).
						</td>
					</tr>
					<tr>
						<td style="padding:0 0 25px 0;font-size:52px;line-height:70px;">
							<strong>"Seller"</strong> means the owner or representative of a given Business a buyer views
							confidential information about.
						</td>
					</tr>
					<tr>
						<td style="padding:0 0 25px 0;font-size:52px;line-height:70px;">
							<strong>“FIH” “FIH.com”</strong> or <strong>“FIH LLC”</strong> means the people from FIH.com who act as
							representatives/contact-points/brokers for the Business.
						</td>
					</tr>
					<tr>
						<td style="padding:0 0 25px 0;font-size:52px;line-height:70px;">
							<strong>"You"</strong> or <strong>"Your"</strong> or <strong>"Buyer"</strong> means the person or company who is interested in acquiring
							the Business.
						</td>
					</tr>
					<tr>
						<td style="padding:0 0 25px 0;font-size:52px;line-height:70px;">
							For the purpose of this Agreement, You and the Seller and FIH.com are each a "Party"
							and collectively "The Parties."
						</td>
						
					</tr>
				</table>');*/
		$this->m_pdf->pdf->shrink_tables_to_fit = 1;
		// $samplePDF->defaultfooterline = 0;
		
		// $this->m_pdf->pdf->SetFooter('');
		// $this->m_pdf->pdf->autoPageBreak = true;
		$this->m_pdf->pdf->WriteHTML($genHTML);
		$this->m_pdf->pdf->Output('nda_'.$userId.'_'.$listingID.'.pdf', 'I');

	}

	public function rejectSell($id,$clientid)
	{
		$permission = checkAuthorization('LISTING','DELETE');
		if(!$permission)
		{
			$permission = checkAuthorization('BUSINESSAPPLICATION','DELETE');
		}
		if($permission)
		{
			$data['start'] = 0;
			$data['limit'] = 1;
			$data['requestId'] = $id;
			$sellRequests = $this->admin_model->getsellrequest($data,[]);
			$selldata = $sellRequests['sellrequests'][0];
			$editArray['Status'] = 2;
			$this->admin_model->updateSellRequest($editArray,$id);
			$user_to = $selldata['mail'];
			$user_subject = 'Your business listing application has been rejected - FIH.com';
			$user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$selldata['clientName'].'</strong>,</h6>
			<br>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Unfortunately, your request to sell your business with FIH.com has been rejected. Any application fees will be refunded shortly. Feel free
			to follow up with us if you have any questions.</p>
			<br>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
			$sendEmail = sendEmail($user_to, $user_subject, $user_message);

			$notificationarr['sender'] = 1;
			$notificationarr['receiver'] = $selldata['userId'];
			$notificationarr['notification_text'] = 'Your business listing application has been rejected.';
			$notificationarr['notification_type'] = 'SELLREJECT';
			$notificationarr['notification_type_id'] = $id;
			$this->front_model->insertnotification($notificationarr);

			redirect(base_url().'administrator/sell-request');
		}else{
			$header['sitetitle'] = 'ADMIN - FIH.com';
			$header['class'] = 'sellrequest';
			$header['userData'] = $getUserData;
			$this->load->view('backend/includes/header',$header);
			$this->load->view('backend/unauthorized');
			$this->load->view('backend/includes/footer');
		}
	}
	public function deleteapprovedSell($id,$clientid)
	{
		$data['start'] = 0;
		$data['limit'] = 1;
		$data['requestId'] = $id;
		$sellRequests = $this->admin_model->getapprovedsell($data);
		$selldata = $sellRequests['sellrequests'][0];
		$id = $selldata['approvedid'];
		$editArray['Status'] = 2;
		$this->admin_model->updateApprovedSell($editArray,$id);
		$user_to = $selldata['mail'];
		$user_subject = 'Your business listing has been removed - FIH.com';
		$user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$selldata['clientName'].'</strong>,</h6>
		<br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Your business has been removed - please login to your account to learn more. If you think this is a mistake, please reach out to us.</p>
		<br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);

		$notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $selldata['userId'];
        $notificationarr['notification_text'] = 'Your business listing has been removed.';
        $notificationarr['notification_type'] = 'SELLREMOVED';
        $notificationarr['notification_type_id'] = $id;
        $this->front_model->insertnotification($notificationarr);

		redirect(base_url().'administrator/approved-sell');
	}

	public function getSellDetails($id){
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'sellrequest';
		$this->load->view('backend/includes/header',$header);
		$data['monetization'] = $this->user_model->getmonetization();
		$getData = $this->admin_model->gettempselldata($id);
		
		//$data['monetization'] = $getData['monetization'];
		$data['tempdata'] = json_decode($getData->data_json,true);

		$this->load->view('backend/sell-details',$data);
		$this->load->view('backend/includes/footer');
	}

	public function updateuserdetails(){
        if ($this->session->userdata('isLoggedIn') == TRUE){
        if($this->input->post('submit') != ''){
            
            $fname = $this->input->post('fname');
			$lname = $this->input->post('lname');
            $email = $this->input->post('hidden_email_id');
            $mobile = $this->input->post('mobile');

            $this->form_validation->set_rules('hidden_email_id', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('fname', 'Name', 'trim|required');
            $this->form_validation->set_rules('mobile', 'Telephone', 'trim|required');
            if($this->form_validation->run() == FALSE)
            {
                $data = array(
                'error' => validation_errors(),
                );
                $this->session->set_flashdata($data);
                redirect(base_url().'administrator/edit-profile');
            }
            $fname = $this->security->xss_clean(trim($fname));
            //$bio = $this->security->xss_clean(trim($bio));

            //$hobbies = $this->input->post('hobbies');
            //$occupation = $this->input->post('hobbies');
            $editArray['fname'] = $fname;
			$editArray['lname'] = $lname;
            $editArray['mail'] = $email;
            $editArray['phone'] = $mobile;
			
            $adminID = $this->session->userdata('user_id');
            
            $getResult = $this->front_model->updateAdminDetails($editArray, $adminID,$editdetailsArray);
            //print_r($this->db->last_query());exit;

                $this->session->set_flashdata('success', 'Profile Has Been Updated!!!!');
                /* ====== Save to session ====== */
                $name = $fname;
                $sessionArray = array(
                    'name'       => $name,
                    'userDisplayNickname' => $editArray['user_firstname']
                );
                $this->session->set_userdata($sessionArray);
                redirect('administrator/edit-profile');
            
        }}
	}
	public function update_admin_password()
    {
        $old_pass=$this->input->post('old_pass');
        $new_pass=$this->input->post('new_pass');
        $confirm_pass=$this->input->post('confirm_pass');
        $session_id=$this->session->userdata('user_id');
		$que=$this->front_model->getAdminDetails($session_id);
		
        if(password_verify($old_pass,$que['password']) && $new_pass==$confirm_pass)
        {
            $this->admin_model->change_pass($session_id,$new_pass);
            $this->session->set_flashdata('change_password_success', 'Password Changed Successfully!!');
        }
        else if(!password_verify($old_pass,$que['Password']))
        {
            $this->session->set_flashdata('change_password_error', 'Old Password And Provided Password Does Not Match!!');
        }
        else if($new_pass!=$confirm_pass)
        {
            $this->session->set_flashdata('change_password_error', 'New Password And Confirm Password Does Not Match!!');
        }
        redirect('administrator/edit-profile');      

	}
	function formatArray($arr)
	{
		if(is_array($arr) && count($arr)>0)
		{
			foreach($arr as $v)
			{
				$value = $this->security->xss_clean(trim($v));
				if($value !='')
				{
					$formatArr[] = $value;
				}
				
			}
		}
		return $formatArr;
	}
	public function addSale(){
		
		$monetization = $this->input->post('monetization');
		$industry = $this->input->post('industry');
		$website = $this->input->post('website_url');
		$workinghour = $this->input->post('workinghour');
		$requestId = $this->input->post('requestId');
		$pricing_period = $this->input->post('pricingperiod');
		$price = $this->input->post('price');
		$monthly_revenue = $this->input->post('monthly_revenue');
		$monthly_profit = $this->input->post('monthly_profit');
		$multiple = $this->input->post('multiple');
		$listingSummery = $this->input->post('listingSummery');
		$asset_description = $this->input->post('asset_description');
		$AssetDescriptiontxt = $this->input->post('AssetDescriptiontxt');
		$otherAssets = explode('|',$this->security->xss_clean(trim($this->input->post('otherAssets'))));
		$brand_reputation = $this->input->post('brand_reputation');
		$risk_profile = $this->input->post('risk_profile');
		$asset_value = $this->input->post('asset_value');
		$growth_potential = $this->input->post('growth_potential');
		$reason_for_sale = $this->input->post('reason_for_sale');
		$support_seller_included = $this->input->post('support_seller_included');
		$fb_link = $this->input->post('fb_link');
		$twitter_link = $this->input->post('twitter_link');
		$insta_link = $this->input->post('insta_link');
		$youtube_link = $this->input->post('youtube_link');
		$pinterest_link = $this->input->post('pinterest_link');
		$linkedin_link = $this->input->post('linkedin_link');
		$extrasocialmedia = $this->input->post('extrasocialmedia');
		$Title = $this->input->post('Title');
		
		$value = $this->input->post('value');
		$buyerTitle = $this->input->post('buyerTitle');
		$buyervalue = $this->input->post('buyervalue');
		$youtube_url = $this->input->post('youtube_url');
		
		$startdate = $this->input->post('startdate');
		$Strength = $this->input->post('strength');
		$Opertunities = $this->input->post('Opertunities');
		$Weakness = $this->input->post('Weakness');
		$Threats = $this->input->post('Threats');
		$skill = $this->input->post('skill');
		$skill_description = $this->input->post('skill_description');
		$buyer_profile_description = $this->input->post('buyer_profile_description');
		$other_info_description = $this->input->post('other_info_description');
		$googleDrive = $this->input->post('googleDrive');
		$pl_link = $this->input->post('pl_link');
		$businessLocation = $this->input->post('businessLocation');
		$country = $this->input->post('country');
		$seoTitle = $this->input->post('seoTitle');
		$seoValue = $this->input->post('seoValue');

		$calendarYear = $this->input->post('calendarYear');
		$trafficStatus = $this->input->post('trafficStatus');
		$totalPageView = $this->input->post('totalPageView');
		$totalVisitor = $this->input->post('totalVisitor');

		$earningcalendarYear = $this->input->post('earningcalendarYear');
		$earningStatus = $this->input->post('earningStatus');
		$avgRevenue = $this->input->post('avgRevenue');
		$avgProfit = $this->input->post('avgProfit');
		
		$action = $this->input->post('action');
		$approveId = $this->input->post('approveId');

		
		$fileName = $_FILES["uploadcsv"]["tmp_name"];
		$yeararray = [];
		if ($_FILES["uploadcsv"]["size"] > 0) {
			$file = fopen($fileName, "r");
			$year = 0;
			while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
				
				if($column[0] != 'Month')
				{
					if($year != $column[1])
					{
						$year = $column[1];
						if(!in_array($year,$yeararray))
						{
							$yeararray[] = $year;
						}
					}
					$revenueArr[$year][] = $column[2];
					$profitArr[$year][] = $column[3];
					$totalvisitorArr[$year][] = $column[4];
					$pageviewArr[$year][] = $column[5];
				}

			}
		}
		
		$AssetArr = [];
		if(is_array($asset_description) && count($asset_description)>0)
		{
			foreach($asset_description as $v)
			{
				$AssetArr[] = array('id'=>$v,'value'=>$this->security->xss_clean(trim($AssetDescriptiontxt[$v])));
			}
		}
		if(is_array($otherAssets) && count($otherAssets)>0)
		{
			foreach($otherAssets as $vo)
			{
				if($this->security->xss_clean(trim($vo)) !='')
				{
					$AssetArr[] = array('id'=>'extra','value'=>$this->security->xss_clean(trim($vo)));
				}
				
			}
		}
		$OtherInfoArr = [];
		if(is_array($Title) && count($Title)>0)
		{
			foreach($Title as $kk=>$vv)
			{
				if($this->security->xss_clean(trim($vv)) !='' && $this->security->xss_clean(trim($value[$kk])) != '')
				{
					$OtherInfoArr[] = array( 'title'=> $this->security->xss_clean(trim($vv)), 'value'=> $this->security->xss_clean(trim($value[$kk])));
				}
			}
		}
		$buyerProfileArr = [];
		if(is_array($buyerTitle) && count($buyerTitle)>0)
		{
			foreach($buyerTitle as $kk=>$vv)
			{
				if($this->security->xss_clean(trim($vv)) !='' && $this->security->xss_clean(trim($buyervalue[$kk])) != '')
				{
					$buyerProfileArr[] = array( 'title'=> $this->security->xss_clean(trim($vv)), 'value'=> $this->security->xss_clean(trim($buyervalue[$kk])));
				}
				
			}
		}
		$seodataArr = [];
		if(is_array($seoTitle) && count($seoTitle)>0)
		{
			foreach($seoTitle as $kk=>$vv)
			{
				if($this->security->xss_clean(trim($vv)) !='' && $this->security->xss_clean(trim($seoValue[$kk])) != '')
				{
					$seodataArr[] = array( 'title'=> $this->security->xss_clean(trim($vv)), 'value'=> $this->security->xss_clean(trim($seoValue[$kk])));
				}
				
			}
		}
		$trafficmodulearr = [];
		$earningmodulearr = [];
		/*if(is_array($earningcalendarYear) && count($earningcalendarYear)>0)
		{
			foreach($earningcalendarYear as $k=>$v)
			{
				if($v>100)
				{
					$earningmodulearr[] = [
						'year'=>$v,
						'status'=>$earningStatus[$k],
						'avgProfit'=> $avgProfit[$k],
						'avgRevenue'=> $avgRevenue[$k]
					];
				}
				
			}
		}*/

		if(is_array($yeararray) && count($yeararray)>0){
			$updategraph = 'Y';
			$AlltotalVisitor = 0;
			$totalTrafficRecord = 0;
			foreach($yeararray as $y)
			{
				if(count($revenueArr[$y])>0 || count($profitArr)>0)
				{
					$earningmodulearr[] = [
						'year'=>$y,
						'status'=>1,
						'avgProfit'=> $profitArr[$y],
						'avgRevenue'=> $revenueArr[$y],
						'yearly-total-avg-profit'=>$profitTotal[$y],
						'yearly-total-avg-revenue'=>$revenueTotal[$y],
					];
				}

				if(count($pageviewArr[$y])>0 || count($totalvisitorArr)>0)
				{
					$trafficmodulearr[] = [
						'year'=>$y,
						'status'=>1,
						'avgPageview'=> $pageviewArr[$y],
						'avgVisitor'=> $totalvisitorArr[$y],
						'yearly-total-avg-pageview'=>$pageviewTotal[$y],
						'yearly-total-avg-visitor'=>$visitorTotal[$y],
					];
					if(is_array($totalvisitorArr[$y]) && count($totalvisitorArr[$y])>0)
					{
						foreach($totalvisitorArr[$y] as $valindi)
						{
							if($valindi!='')
							{
								$AlltotalVisitor = $AlltotalVisitor + $valindi;
								$totalTrafficRecord = $totalTrafficRecord+1;
							}
						}
					}
				}
				
			}
			if($totalTrafficRecord>0){
				$trafficPerMonth = ceil($AlltotalVisitor/$totalTrafficRecord);
				//$trafficPerMonth = $AlltotalVisitor;
			}
		}else{
			$updategraph = 'N';
		}


		/*$trafficPerMonth = 0;
		
		if(is_array($calendarYear) && count($calendarYear)>0)
		{
			$AlltotalVisitor = 0;
			$totalTrafficRecord = 0;
			foreach($calendarYear as $k=>$v)
			{
				if($v>100)
				{
					$trafficmodulearr[] = [
						'year'=>$v,
						'status'=>$trafficStatus[$k],
						'avgPageview'=> $totalPageView[$k],
						'avgVisitor'=> $totalVisitor[$k]
					];
					if(is_array($totalVisitor[$k]) && count($totalVisitor[$k])>0)
					{
						foreach($totalVisitor[$k] as $valindi)
						{
							if($valindi>0)
							{
								$AlltotalVisitor = $AlltotalVisitor + $valindi;
								$totalTrafficRecord = $totalTrafficRecord+1;
							}
						}
					}
					
					
				}
				
			}
			//print '<pre>';
			//echo '------------';
			//print_r($totalTrafficRecord);
			
			if($totalTrafficRecord>0){
				$trafficPerMonth = ceil($AlltotalVisitor/$totalTrafficRecord);
				//$trafficPerMonth = $AlltotalVisitor;
			}

		}*/
		
		
		$getData = $this->admin_model->gettempselldata($requestId);
		$tempdata = json_decode($getData->data_json,true);
		$userId = $getData->userId;

		$tempId = $this->input->post('monetization');
		$Arr['monetization'] = json_encode($monetization);
		$Arr['listing_temp_id'] = $requestId; //---
		if($action == 'edit')
		{
			$Arr['id'] = $approveId; //---
		}
		if(isset($_FILES['businessImage'])){
			if ($_FILES['businessImage']['name'] && substr($_FILES['businessImage']['type'], 0, 5) == 'image') {
				$uploadPath = "uploads/business_image/";
				$config['upload_path'] = $uploadPath;
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['encrypt_name'] = TRUE;

				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if ($this->upload->do_upload('businessImage')) {
					$fileData = $this->upload->data();
					/* ====== Image Resizing to profile view box ====== */
					$image_info = getimagesize($uploadPath . $fileData['file_name']); 
					if($image_info[0] >= $image_info[1]) // 
					{
						if($image_info[0] <= 300)
						{
							$newwidth = $image_info[0];
							$newheight = $image_info[1];
						}else
						{
							$newwidth = 300;
							$ratiopercent = (300/$image_info[0])*100;
							$newheight = ($image_info[1]*$ratiopercent)/100;

						}
					}elseif($image_info[0] < $image_info[1])
					{
						if($image_info[1] <= 200)
						{
							$newwidth = $image_info[0];
							$newheight = $image_info[1];
						}else
						{
							$newheight = 200;
							$ratiopercent = (200/$image_info[1])*100;
							$newwidth = ($image_info[0]*$ratiopercent)/100;

						}
					}
					$config = array();
					$config['image_library']  = 'gd2';
					$config['source_image']   = $uploadPath . $fileData['file_name'];
					$config['create_thumb']   = TRUE;
					$config['maintain_ratio'] = FALSE;
					$config['width']          = ceil($newwidth);
					$config['height']         = ceil($newheight);
					$config['thumb_marker']   = '_resized';
					$this->load->library('image_lib');
					$this->image_lib->initialize($config);
					$this->image_lib->resize();
					$this->image_lib->clear();

					$Arr['business_image'] = $fileData['file_name'];
				}
			}
		}
		
		$Arr['listing_id'] = $getData->listing_id;
		$Arr['userId'] = $getData->userId;
		$Arr['website'] = json_encode($this->formatArray($website));
		$Arr['industry'] = $this->security->xss_clean(trim($industry));
		$Arr['pricing_period'] = $this->security->xss_clean(trim($pricing_period));
		$Arr['price'] = $this->security->xss_clean(trim($price));
		$Arr['monthly_revenue'] = $this->security->xss_clean(trim($monthly_revenue));
		$Arr['monthly_profit'] = $this->security->xss_clean(trim($monthly_profit));
		$Arr['multiple'] = $this->security->xss_clean(trim($multiple));
		$Arr['summery'] = $listingSummery;
		$Arr['business_create_date'] = $this->security->xss_clean(trim($startdate));
		$Arr['working_hour'] = $this->security->xss_clean(trim($workinghour));
		$Arr['asset_list'] = json_encode($AssetArr);
		$Arr['brand_reputation'] = $this->security->xss_clean(trim($brand_reputation));
		$Arr['risk_profile'] = $this->security->xss_clean(trim($risk_profile));
		$Arr['asset_value'] = $this->security->xss_clean(trim($asset_value));
		$Arr['growth_potential'] = $this->security->xss_clean(trim($growth_potential));
		$Arr['reason_for_sale'] = $this->security->xss_clean(trim($reason_for_sale));
		$Arr['support_seller_included'] = $this->security->xss_clean(trim($support_seller_included));
		$Arr['other_info'] = json_encode($OtherInfoArr);
		$Arr['buyer_profile'] = json_encode($buyerProfileArr);
		$Arr['youtube_url'] = json_encode($this->formatArray($youtube_url));
		$Arr['fb_link'] = $this->security->xss_clean(trim($fb_link));
		$Arr['twitter_link'] = $this->security->xss_clean(trim($twitter_link));
		$Arr['insta_link'] = $this->security->xss_clean(trim($insta_link));
		$Arr['youtube_link'] = $this->security->xss_clean(trim($youtube_link));
		$Arr['pinterest_link'] = $this->security->xss_clean(trim($pinterest_link));
		$Arr['linkedin_link'] = $this->security->xss_clean(trim($linkedin_link));
		$Arr['extrasocialmedia'] = json_encode($this->formatArray($extrasocialmedia));
		$Arr['google_drive_link'] = $this->security->xss_clean(trim($googleDrive));
		$Arr['pl_link'] = $this->security->xss_clean(trim($pl_link));
		$Arr['businesslocation'] = $this->security->xss_clean(trim($businessLocation));
		$Arr['country'] = $this->security->xss_clean(trim($country));
		$Arr['skill_description'] = $this->security->xss_clean(trim($skill_description));
		$Arr['buyer_profile_description'] = $this->security->xss_clean(trim($buyer_profile_description));
		$Arr['other_info_description'] = $this->security->xss_clean(trim($other_info_description));
		$Arr['Strength'] = json_encode($this->formatArray($Strength));
		$Arr['Opertunities'] = json_encode($this->formatArray($Opertunities));
		$Arr['Weakness'] = json_encode($this->formatArray($Weakness));
		$Arr['Threats'] = json_encode($this->formatArray($Threats));
		$Arr['skills'] = json_encode($this->formatArray($skill));
		$Arr['seo_data'] = json_encode($seodataArr);
		if($updategraph == 'Y')
		{
			$Arr['traffic'] = json_encode($trafficmodulearr);
			$Arr['traffic_per_month'] = $trafficPerMonth;
			$Arr['earnings'] = json_encode($earningmodulearr);
		}
		
		
		$que=$this->admin_model->addaltersale($Arr,$action);

		$this->db->where('id', $requestId);
		$arrtemp['Status'] = 3;
		$this->db->set('Status',3);
		$this->db->update(TABLE_PREFIX.'sell_business_temp');
		if($action == 'add')
		{
			$getUserData = $this->admin_model->getUserDetails($userId);
			$user_to = $getUserData->mail;
			$user_subject = 'Business listing application #'.$getData->listing_id.' has been approved - FIH.com';
			$user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$getUserData->fname.'</strong>,</h6>
			<br>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Good news! Your application to have FIH.com sell your business has been approved. Be on the lookout for next steps in your FIH.com
			seller dashboard.</p>
			<br>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
			$sendEmail = sendEmail($user_to, $user_subject, $user_message);

			$notificationarr['sender'] = 1;
			$notificationarr['receiver'] = $getUserData->userId;
			$notificationarr['notification_text'] = 'Your business listing application #'.$getData->listing_id.' has been accepted. 
			Your request to SELL business listing #'.$getData->listing_id.' is accepted by admin';
			$notificationarr['notification_type'] = 'SELLACCEPTED';
			$notificationarr['notification_type_id'] = $que;
			$this->front_model->insertnotification($notificationarr);
		}
		

		
		$this->session->set_flashdata('success', 'Business for sale added successfully.');
		redirect('administrator/approved-sell');      

	}

	public function publishSale(){
		$requestId = $this->input->post('requestId');
		$approveId = $this->input->post('approveId');
		$userId = $this->input->post('userId');
		$action = $this->input->post('action');
		if($action == 'publish')
		{
			$Arr['id'] = $approveId;
			$Arr['Status'] = 1; //---
			$Arr['date_added'] = date('Y-m-d H:i:s');

			$getUserData = $this->admin_model->getUserDetails($userId);
			$getData = $this->admin_model->gettempselldata($requestId);
			// echo "<pre>"; print_r($getUserData) ;die;
			$user_to = $getUserData->mail;
			$user_subject = 'Your business listing #'.$getData->listing_id.' has been published - FIH.com';
			$user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$getUserData->fname.'</strong>,</h6>
			<br>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Good news! Your business listing #'.$getData->listing_id.' has been published and is open for viewing in our marketplace.</p>
			<br>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
			$sendEmail = sendEmail($user_to, $user_subject, $user_message);

			$notificationarr['sender'] = 1;
			$notificationarr['receiver'] = $getUserData->userId;
			$notificationarr['notification_text'] = 'Your business listing #'.$getData->listing_id.' has been published.';
			$notificationarr['notification_type'] = 'SELLPUBLISHED';
			$notificationarr['notification_type_id'] = $approveId;
			$this->front_model->insertnotification($notificationarr);

			$this->session->set_flashdata('success', 'Business for sale succesfully published.');

		}elseif($action == 'unpublish')
		{
			$Arr['id'] = $approveId;
			$Arr['Status'] = 2; //---

			$getUserData = $this->admin_model->getUserDetails($userId);
			$getData = $this->admin_model->gettempselldata($requestId);
			// echo "<pre>";print_r($getData);die;
			$user_to = $getUserData->mail;
			$user_subject = 'Your business listing #'.$getData->listing_id.' has been unpublished - FIH.com';
			$user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$getUserData->fname.'</strong>,</h6>
			<br>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Your business listing #'.$getData->listing_id.' has been and it is not being offered for sale. Feel free to follow up with us to learn why.</p>
			<br>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
			$sendEmail = sendEmail($user_to, $user_subject, $user_message);

			$notificationarr['sender'] = 1;
			$notificationarr['receiver'] = $getUserData->userId;
			$notificationarr['notification_text'] = 'Your business listing #'.$getData->listing_id.' has been unpublished and is no longer for sale.';
			$notificationarr['notification_type'] = 'SELLPUBLISHED';
			$notificationarr['notification_type_id'] = $approveId;
			$this->front_model->insertnotification($notificationarr);

			$this->session->set_flashdata('success', 'Business for sale succesfully unpublished.');
		}
		$que=$this->admin_model->addaltersale($Arr,'edit');
		
		redirect('administrator/approved-sell');  
	}

	public function displayQuestions($listingId){
		$permission = checkAuthorization('LISTING','EDIT');

		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'sellrequest';
		$Questioncat = $this->admin_model->getquestioncategories();
		$getqadata = $this->admin_model->getquestionanswers($listingId);
		$sell_answers = $getqadata->sell_answers;
		$sellQArtr = json_decode($sell_answers,true);
		$data['listingId'] = $listingId;
		if(is_array($Questioncat) && count($Questioncat)>0 && is_array($sellQArtr) && count($sellQArtr)>0) 
		{
			foreach($Questioncat as $val)
			{
				$i=0;
				$id = $val['id'];
				$newQArray[$id] = ['cat_name'=>$val['category_name']];
				//$newQArray[$id]['addedquestions'] = 'kkkk';
				while($sellQArtr[$i])
				{
					if($sellQArtr[$i]['Category'] == $val['id'])
					{
						$newQArray[$id]['addedquestions'][] = $sellQArtr[$i];
					}
					$i++;
				}
			}
		}
		$data['sellQArtr'] = $newQArray;
		//print '<pre>';
		//print_r($newQArray);
		//print_r($data['sellQArtr']);
		//die;
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/display-question-answers',$data);
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}

	public function manageEarnings($id){
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'approvedsell';
		//$data['monetization'] = $this->user_model->getmonetization();
		$data['req_id'] = $id;
		//$getData = $this->admin_model->gettempselldata($id);
		
		//$data['tempdata'] = json_decode($getData->data_json,true);
		//$data['assets'] = $this->admin_model->listassets('active');

		
		
		
		//$data['industries'] = $this->admin_model->listindustry('active');
		
		//$data['storedData'] = $getApproveddata;
		$fields = 'id,earnings';
		$getApproveddata = $this->admin_model->getapprovedselldata($id,$fields);
		$data['earnings'] = json_decode($getApproveddata->earnings,true);
		
		$this->load->view('backend/includes/header',$header);
		$this->load->view('backend/manage-earning',$data);
		$this->load->view('backend/includes/footer');
	}

	public function earningAdd(){
		$calendarYear = $this->input->post('calendarYear');
		$earningStatus = $this->input->post('earningStatus');
		$avgRevenue = $this->input->post('avgRevenue');
		$avgProfit = $this->input->post('avgProfit');
		$recordId = $this->input->post('recordId');
		$earningmodulearr[] = [
			'year'=>$calendarYear,
			'status'=>$earningStatus,
			'avgProfit'=> $avgProfit,
			'avgRevenue'=> $avgRevenue
		];
		
		$fields = 'id,earnings';
		$getApproveddata = $this->admin_model->getapprovedselldata($recordId,$fields);
		if($getApproveddata->earnings != '')
		{
			$earningdata = json_decode($getApproveddata->earnings,true);
			array_push($earningdata,$earningmodulearr[0]);
			$jsonstr = json_encode($earningdata);
			$arr['id'] = $getApproveddata->id;
			$arr['earnings'] = $jsonstr;
			$this->admin_model->addaltersale($arr,'edit');
		}else{
			$jsonstr = json_encode($earningmodulearr);
			$arr['id'] = $getApproveddata->id;
			$arr['earnings'] = $jsonstr;
			$this->admin_model->addaltersale($arr,'edit');
		}
		redirect(base_url().'administrator/approved-sell/manage-earnings/'.$recordId);
	}

	

	public function users(){

		$permission = checkAuthorization('USER','LIST');
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'proof-verification';
		$this->load->view('backend/includes/header',$header);

		if($permission)
		$this->load->view('backend/users');
		else	
		$this->load->view('backend/unauthorized');

		$this->load->view('backend/includes/footer');
	}

	public function usersData(){
		$editpermission = checkAuthorization('USER','EDIT');
		$deletepermission = checkAuthorization('USER','DELETE');
		$draw = $_POST['draw'];
        $data['start'] = $_POST['start'];
		$data['limit'] = $_POST['length'];
        $data['searchValue'] = $_POST['searchName'];
		$data['searchUsertype'] = $_POST['searchUsertype'];
		$sort = $_POST['order'][0];
		$users = $this->admin_model->getusers($data,$sort);
		
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
				if($editpermission){
					$editbtn = '<a href="'.base_url().'administrator/users/edit/'.$v['userId'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
				}
				if($deletepermission){
					$deletebtn = '<a href="javascript: void(0)" onclick="deleterecord(this)" datadeletehref="'.base_url().'administrator/users/delete/'.$v['userId'].'" class="btn-sm btn-danger deleterec"><i class="fa fa-trash" aria-hidden="true"></i></a>';
				}
				if($v['Status'] == 1)
				{
					//$datares['action'] = '<a href="'.base_url().'administrator/users/edit/'.$v['userId'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;<a href="javascript: void(0)" onclick="deleterecord(this)" datadeletehref="'.base_url().'administrator/users/delete/'.$v['userId'].'" class="btn-sm btn-danger deleterec"><i class="fa fa-trash" aria-hidden="true"></i></a>';
					$datares['action'] = $editbtn.'&nbsp;'.$deletebtn;
				}elseif($v['Status'] == 0)
				{
					//$datares['action'] = '<a href="'.base_url().'administrator/users/edit/'.$v['userId'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;<a href="javascript: void(0)" onclick="deleterecord(this)" datadeletehref="'.base_url().'administrator/users/delete/'.$v['userId'].'" class="btn-sm btn-danger deleterec"><i class="fa fa-trash" aria-hidden="true"></i></a>';
					$datares['action'] = $editbtn.'&nbsp;'.$deletebtn;
				}else{
					//$datares['action'] = '<a href="'.base_url().'administrator/users/edit/'.$v['userId'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;<a href="javascript: void(0)" onclick="deleterecord(this)" datadeletehref="'.base_url().'administrator/users/delete/'.$v['userId'].'" class="btn-sm btn-danger deleterec"><i class="fa fa-trash" aria-hidden="true"></i></a>';
					$datares['action'] = $editbtn.'&nbsp;'.$deletebtn;
				}
				
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

	public function usersDelete($userId){
		$permission = checkAuthorization('USER','DELETE');
		if($permission)
		{
			$arr['clientId'] = $userId;
			$arr['Status'] = 3;
			$this->user_model->updateuserprofile($arr);
			redirect('administrator/users');  
		}else{
			$getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
			$header['sitetitle'] = 'ADMIN - FIH.com';
			$header['class'] = 'proof-verification';
			$header['userData'] = $getUserData;
			$data['result'] = $this->admin_model->getuserprofile($userId);
			
			$this->load->view('backend/includes/header',$header);
			$this->load->view('backend/unauthorized');
		
			$this->load->view('backend/includes/footer');
		}
		  
	}

	public function usersEdit($userId){
		$permission = checkAuthorization('USER','EDIT');
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'proof-verification';
		$header['userData'] = $getUserData;
		$data['result'] = $this->admin_model->getuserprofile($userId);

		// Get User Uncovered Count
		$getUncoverCount = $this->admin_model->countUncoveredListingsByUser($userId);
		$data['getUncoverCount'] = $getUncoverCount;
		
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/edit-users',$data);
		else	
		$this->load->view('backend/unauthorized');
		
		$this->load->view('backend/includes/footer');
	}

	public function uncoveredListingsByUser($userId){
		$permission = checkAuthorization('LISTING','LIST');
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'proof-verification';
		$header['userData'] = $getUserData;
		$data['getSelectedUserDetails'] = $this->admin_model->getUserDetails($userId);
		$data['result'] = $this->admin_model->getUncoveredListingsByUser($userId);
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/uncovered-listings-by-user', $data);
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}

	public function usersUpdate(){
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		$arr['fname']=$this->input->post('fname');
		$arr['lname']=$this->input->post('lname');
		$arr['phone']=$this->input->post('phone');
		$arr['google_analitics_email']=$this->input->post('google_analitics_email');
		$arr['secondary_phone']=$this->input->post('secondary_phone');
		$arr['Status']=$this->input->post('Status');
		$userPassword=$this->input->post('userPassword');
		$userPasswordconfirm=$this->input->post('userPasswordconfirm');
		if($userPassword !='' && $userPasswordconfirm == $userPassword)
		{
			$arr['password']=getHashedPassword($userPassword);
		}elseif($userPassword !='' && $userPasswordconfirm != $userPassword)
		{
			$this->session->set_flashdata('error', 'Password and Confirm password are not same!');
			redirect('administrator/users/edit/'.$this->input->post('requestId')); 
		}
		$arr['clientId']=$this->input->post('requestId');
		
		$this->user_model->updateuserprofile($arr);
		$this->session->set_flashdata('success', 'User successfully updated!');
		redirect('administrator/users');  
	}

	public function pendingFaqs(){
		$permission = checkAuthorization('FAQ','LIST');
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'sellrequest';
		$header['userData'] = $getUserData;
		$data['result'] = $this->admin_model->getuserprofile($userId);
		//  $data['users'] = $this->admin_model->getpendingfaq();
		//   echo "<pre>";print_r($data['users']);die;

		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/pending-faqs',$data);
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}

	public function pendingFaqsData(){
		$draw = $_POST['draw'];
        $data['start'] = $_POST['start'];
		$data['limit'] = $_POST['length'];
		$data['searchName'] = $_POST['search']['value'];
		$sort = $_POST['order'][0];
		$users = $this->admin_model->getpendingfaq($data,$sort);
		$dataArr = [];
        if(is_array($users['record']) && count($users['record'])>0)
        {
            
            $i = $data['start']+1;
            foreach($users['record'] as $v)
            {
				$datares['listing_id'] = '<a target="_blank" href="'.base_url().'administrator/sell-request/sell-request-process/'.$v['tempid'].'">#'.$v['listing_id'].'</a>';
                $i++;
				$datares['buyername'] = $v['buyername'];
				$datares['buyeremail'] = '<a target="_blank" href="'.base_url().'administrator/users/edit/'.$v['buyeruserId'].'">'.$v['buyeremail'].'</a>';
				$datares['question'] = substr($v['question'],0,20);
				$datares['sellername'] = $v['sellername'];
				$datares['selleremail'] = '<a target="_blank" href="'.base_url().'administrator/users/edit/'.$v['selleruserId'].'">'.$v['selleremail'].'</a>';
				$datares['faqDate'] = $v['faqDate'];
				$datares['seller_reply'] = substr($v['seller_reply'],0,20);
				if($v['Status'] == 2)
				{ $status = '<span style="color:green">Approved</span>'; } else if($v['Status'] == 3) { $status = '<span style="color:red">Rejected</span>';} else{ $status = '<span style="color:#d4bc28">Pending </span>' ;
				}
				$datares['admin_status'] = $status;
				$datares['action'] = '<a href="'.base_url().'administrator/faq/edit/'.$v['id'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                $dataArr[] = $datares;
            }
		}
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $users['totalrecord']->totalrecord,
            "recordsFiltered" => $users['totalrecord']->totalrecord,
			"data" => $dataArr,
			//"qrt"=>$users['query'],
			//"ppost"=>$_POST['search']['value'],
			"token" => $this->security->get_csrf_hash()
			
        );
        echo json_encode($response);
	}
	
	public function listingOffers(){
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'sellrequest';
		$header['userData'] = $getUserData;
		//$data['result'] = $this->admin_model->getuserprofile($userId);
		
		$this->load->view('backend/includes/header',$header);
		$this->load->view('backend/listing-offers',$data);
		$this->load->view('backend/includes/footer');
	}
	
	public function listingOffersData(){
		$draw = $_POST['draw'];
        $data['start'] = $_POST['start'];
		$data['limit'] = $_POST['length'];
		$data['searchName'] = $_POST['searchName'];
		$data['searchByStatus'] = $_POST['searchByStatus'];
		$sort = $_POST['order'][0];
		$users = $this->admin_model->getlistingoffers($data,$sort);
		
		$dataArr = [];
        if(is_array($users['record']) && count($users['record'])>0)
        {
            
            $i = $data['start']+1;
            foreach($users['record'] as $v)
            {
				$datares['sl_no'] = $i;
                $i++;
				$datares['buyername'] = $v['buyername'];
				$datares['buyeremail'] = '<a target="_blank" href="'.base_url().'administrator/users/edit/'.$v['userId'].'">'.$v['buyeremail'].'</a>';
				$datares['offer_price'] = substr($v['offer_price'],0,20);
				$datares['sellername'] = $v['sellername'];
				$datares['selleremail'] = '<a target="_blank" href="'.base_url().'administrator/users/edit/'.$v['sellerId'].'">'.$v['selleremail'].'</a>';
				$datares['offerDate'] = $v['offerDate'];
				$datares['listing_id'] = '<a target="_blank" href="'.base_url().'administrator/sell-request/sell-request-process/'.$v['tempid'].'">#'.$v['listing_id'].'</a>';
				if($v['status'] == 1)
				$datares['offerStatus'] = 'Pending';
				elseif($v['status'] == 2)
				$datares['offerStatus'] = 'Approved';
				$datares['description'] = substr($v['offer_description'],0,20).'...';

				$datares['action'] = '<a href="'.base_url().'administrator/listing-offers/'.$v['id'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                $dataArr[] = $datares;
            }
		}
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $users['totalrecord']->totalrecord,
            "recordsFiltered" => $users['totalrecord']->totalrecord,
			"data" => $dataArr,
			"datasending" =>$data,
			"token" => $this->security->get_csrf_hash()
			
        );
        echo json_encode($response);
	}


	public function walletAddmoney(){
		$permission = checkAuthorization('WALLET','LIST');
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'buyreq';
		$header['userData'] = $getUserData;
		//$data['result'] = $this->admin_model->getuserprofile($userId);
		
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/wallet-addmoney-requests',$data);
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}

	public function walletAddmoneyData(){
		$draw = $_POST['draw'];
        $data['start'] = $_POST['start'];
		$data['limit'] = $_POST['length'];
		$data['searchName'] = $_POST['searchName'];
		$data['searchByStatus'] = $_POST['searchByStatus'];
		$data['section'] = 'WALLET';
		$sort = $_POST['order'][0];
		$users = $this->admin_model->getwalletbuyreqadmin($data,$sort);
		
		$dataArr = [];
        if(is_array($users['record']) && count($users['record'])>0)
        {
            
            $i = $data['start']+1;
            foreach($users['record'] as $v)
            {
				$datares['buyername'] = $v['buyername'];
				$datares['buyeremail'] = '<a target="_blank" href="'.base_url().'administrator/users/edit/'.$v['userId'].'">'.$v['buyermail'].'</a>';
				$datares['buyerphone'] = $v['buyerphone'];
				$datares['transaction_ref'] = $v['transaction_ref'];
				$datares['buyDate'] = date('jS M Y',strtotime($v['date_added']));
				$datares['amount'] = $users['currency'][0]['symbol'].$v['wallet_amount'];
				$datares['type'] = '';
				if($v['section'] == 'WALLET')
				{
					$datares['type'] = 'Deposit';
				}elseif($v['section'] == 'WALLETWITHDRAW')
				{
					$datares['type'] = 'Withdrawal';
				}

				if($v['status'] == 1)
				$datares['amount'] .= '<span style="color:red; float:right">Pending</span>';
				elseif($v['status'] == 2)
				$datares['amount'] .= '<span style="color:green; float:right">Approved</span>';
				elseif($v['status'] == 3)
				$datares['amount'] .= '<span style="color:grey; float:right">Rejected</span>';
				
				$datares['action'] = '<a href="'.base_url().'administrator/wallet-addmoney-request/'.$v['id'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                $dataArr[] = $datares;
            }
		}
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $users['totalrecord']->totalrecord,
            "recordsFiltered" => $users['totalrecord']->totalrecord,
			"data" => $dataArr,
			"datasending" =>$data,
			"token" => $this->security->get_csrf_hash()
			
        );
        echo json_encode($response);
	}

	public function listingCommission(){
		$draw = $_POST;
		$permission = checkAuthorization('REPORT','LIST');
		$data['editpermission'] = checkAuthorization('REPORT','EDIT');
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'buyreq';
		$header['userData'] = $getUserData;
		$data['section'] = 'LISTING';
		$data['searchName'] = $_POST['searchName'];
		$data['dateFrom'] = $_POST['dateFrom'];
		$data['dateTo'] = $_POST['dateTo'];
		$data['buyStatus'] = $_POST['buyStatus'];
		$data['start'] = 0;
		$data['limit'] = 10;
		$users = $this->admin_model->getlistingbuycommission($data);

		if($_POST['dateFrom']!='')
        {
            $partSql .= " and S.last_updated>='".$_POST['dateFrom']."'";
        }else{
            $currentMonthFrom = date('Y-m').'-01';

            $partSql .= " and S.last_updated>=DATE_SUB( NOW() , INTERVAL 6 MONTH )";
        }
        if($_POST['dateTo']!='')
        {
            $partSql .= " and S.last_updated<='".$_POST['dateTo']." 23:59:59'";
        }else{
            $currentMonthFrom = date('Y-m-d').' 23:59:59';
            $partSql .= " and S.last_updated<='".$currentMonthFrom."'";
        }
		$q = "select sum(S.paid_amount) as totalCollection  from 
        ".TABLE_PREFIX."sell_business_temp as S 
        where (S.Status=1 or S.Status=3) ".$partSql;

        $query = $this->db->query($q);    
        $totalcollectionapplication = $query->row();  
		$data['totalcollectionapplication'] = $totalcollectionapplication->totalCollection; 


		$sitesettings = $this->admin_model->getSiteSettings();
        $currency = $this->admin_model->getCurrencies($sitesettings['currency']);
		///print '';
		$dataArr = [];
        if(is_array($users['record']) && count($users['record'])>0)
        {
            
			$i = $data['start']+1;
			$totalSale = 0;
			$totalCommission = 0;
			$totalAmounttoTransfer = 0;
            foreach($users['record'] as $v)
            {
				$datares['sl_no'] = $i;
                $i++;
				//$datares['buyername'] = $v['buyername'];
				$datares['transaction_ref'] = $v['transaction_ref'];
				$datares['selleremail'] = $v['selleremail'];

				$datares['buyDate'] = date('jS M Y',strtotime($v['date_added']));
				//https://www.fih.com/administrator/sell-request/sell-request-process/124
				$datares['listing_id'] = '<a target="_blank" href="'.base_url().'administrator/sell-request/sell-request-process/'.$v['listingref'].'">#'.$v['listing_id'].'</a>';
				$datares['price'] = $v['price'];
				//$datares['description'] = substr($v['description'],0,20).'...';
				$this->db->select("*");
				$this->db->from(TABLE_PREFIX.'listing_offers');
				$this->db->where('listing_id', $v['listing_id']); 
				$this->db->where('sellerId', $v['selleruserId']); 
				$this->db->where('userId', $v['buyeruserId']); 
				$this->db->where('status', 2);   
				$Query = $this->db->get();
				$offers = $Query->row();

				/*$this->db->select("*");
				$this->db->from(TABLE_PREFIX.'commission_history');
				$this->db->where('change_date <=', $v['sold_date']);   
				$this->db->order_by('change_date', 'desc'); 
				$Query = $this->db->get();
				$commission = $Query->row();
				$commissionPercentage = $commission->percentage;
				*/
				
				if($offers->id>0)
				{
					$datares['offersell'] = 'Y';
					$datares['price'] = $offers->offer_price;
				}
				$sellPrice = $datares['price'];
				$where = "((price_from<='$sellPrice' and price_to >='$sellPrice') OR (price_from='0.00' and price_to >='$sellPrice') OR (price_from<='$sellPrice' and price_to ='0.00')) and status=1";
				$this->db->select("*");
				$this->db->from(TABLE_PREFIX.'commission_history');
				$this->db->where($where);   
				$Query = $this->db->get();
				$commission = $Query->row();
				$commissionPercentage = $commission->percentage;

				$totalSale = $totalSale+$datares['price'];
				$totalCommission = $totalCommission+($datares['price']/100)*$commissionPercentage;
				if($v['buy_amt_stranfer_status'] == 0)
				{
					$totalAmounttoTransfer = $totalAmounttoTransfer+($datares['price']-($datares['price']/100)*$commissionPercentage);
				}
				$datares['commissionAmount'] = number_format(($datares['price']/100)*$commissionPercentage,2).' ('.$commissionPercentage.'%)';
				$datares['transferAmount'] = number_format($datares['price']-($datares['price']/100)*$commissionPercentage,2);
				$datares['amtTransferststus'] = ($v['buy_amt_stranfer_status'] == 1)?'Paid': 'Unpaid';
				$datares['buy_amt_stranfer_status'] = $v['buy_amt_stranfer_status'];
				$datares['id'] = $v['id'];
                $dataArr[] = $datares;
            }
		}
		$data['result'] = $dataArr;
		$data['currency'] = $currency[0]['symbol'];

		$data['totalSale'] = number_format($totalSale,2);
		$data['totalCommission'] = number_format($totalCommission,2);
		$data['totalAmounttoTransfer'] = number_format($totalAmounttoTransfer,2);

		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/listing-buy-commission',$data);
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}
	public function approvelistingCommission($id){
		//echo $id;
		$this->db->where('id', $id);
		$updatesell['buy_amt_stranfer_status'] = 1;
		$this->db->update(TABLE_PREFIX.'buy_request', $updatesell);
		redirect('administrator/listing-commissions');  
	}
	
	public function listingBuy(){
		$permission = checkAuthorization('BUYREQUEST','LIST');
		$data['editpermission'] = checkAuthorization('BUYREQUEST','DELETE');
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'buyreq';
		$header['userData'] = $getUserData;
		//$data['result'] = $this->admin_model->getuserprofile($userId);
		
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/listing-buy-requests',$data);
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}
	
	public function listingBuyData(){
		$draw = $_POST['draw'];
		//$data['start'] = $_POST['start'];
		$data['start'] = 0;
		//$data['limit'] = $_POST['length'];
		$data['limit'] = 10;

		$data['searchName'] = $_POST['searchName'];
		$data['searchByStatus'] = $_POST['searchByStatus'];
		$data['searchBySellType'] = $_POST['searchBySellType'];
		$data['section'] = 'LISTING';
		$sort = $_POST['order'][0];
		$users = $this->admin_model->getlistingbuyreq($data,$sort);
		$sitesettings = $this->admin_model->getSiteSettings();
        $currency = $this->admin_model->getCurrencies($sitesettings['currency']);
		$dataArr = [];
        if(is_array($users['record']) && count($users['record'])>0)
        {
            
            $i = $data['start']+1;
            foreach($users['record'] as $v)
            {
				
				//$datares['sl_no'] = $i;
                $i++;
				//$datares['buyername'] = $v['buyername'];
				$datares['transaction_ref'] = $v['transaction_ref'];
				$datares['sellername'] = '<a href="'.base_url().'administrator/users/edit/'.$v['selleruserId'].'">'.$v['selleremail'].'</a>';
				$datares['buyDate'] = $v['buyDate'];
				//$datares['listing_id'] = '<a target="_blank" href="'.base_url().'listing/'.$v['listing_id'].'">#'.$v['listing_id'].'</a>';
				if($v['status'] == 1)
				$datares['buyStatus'] = 'Pending [<a href="'.base_url().'administrator/sell-request/sell-request-process/'.$v['businessdfetailsid'].'">#'.$v['listing_id'].'</a>]';
				elseif($v['status'] == 2)
				$datares['buyStatus'] = 'Sold [<a href="'.base_url().'administrator/sell-request/sell-request-process/'.$v['businessdfetailsid'].'">#'.$v['listing_id'].'</a>]';
				elseif($v['status'] == 3)
				$datares['buyStatus'] = 'Rejected [<a href="'.base_url().'administrator/sell-request/sell-request-process/'.$v['businessdfetailsid'].'">#'.$v['listing_id'].'</a>]';
				
				
				//$datares['description'] = substr($v['description'],0,20).'...';

				$this->db->select("*");
				$this->db->from(TABLE_PREFIX.'listing_offers');
				$this->db->where('listing_id', $v['listing_id']); 
				$this->db->where('sellerId', $v['selleruserId']); 
				$this->db->where('userId', $v['buyeruserId']); 
				$this->db->where('status', 2);   
				$Query = $this->db->get();
				$offers = $Query->row();
				if($v['sold_date'])
				{
					$solddate = $v['sold_date'];
				}else{
					$solddate = date('Y-m-d');
				}
				

				if($offers->id>0)
				{
					$datares['offersell'] = 'Offer';
					$datares['price'] = $currency[0]['symbol'].$offers->offer_price;
					$sellPrice = $offers->offer_price;
				}else{
					$datares['offersell'] = 'Normal';
					$datares['price'] = $currency[0]['symbol'].$v['price'];
					$sellPrice = $v['price'];
				}
				//$where = '(price_from>='.$sellPrice.' and price_to <='.$sellPrice.') OR (price_from=0.00 and price_to <='.$sellPrice.') OR (price_from>='.$sellPrice.' and price_to =0.00) and ststus=1';
				$where = "((price_from<='$sellPrice' and price_to >='$sellPrice') OR (price_from='0.00' and price_to >='$sellPrice') OR (price_from<='$sellPrice' and price_to ='0.00')) and status=1";
				$this->db->select("*");
				$this->db->from(TABLE_PREFIX.'commission_history');
				$this->db->where($where);   
				$Query = $this->db->get();
				$commission = $Query->row();
				$commissionPercentage = $commission->percentage;
				
				//$totalSale = $totalSale+$datares['price'];
				//$totalCommission = $totalCommission+($datares['price']/100)*$commissionPercentage;
				/*if($v['buy_amt_stranfer_status'] == 0)
				{
					$totalAmounttoTransfer = $totalAmounttoTransfer+($datares['price']-($datares['price']/100)*$commissionPercentage);
				}*/
				$amtTransferststus = ($v['buy_amt_stranfer_status'] == 1)?' <span style="color:green; float:right">Paid</span>': ' <span style="color:red; float:right">Unpaid</span>';
				$datares['commissionAmount'] = $currency[0]['symbol'].number_format(($sellPrice/100)*$commissionPercentage,2).' ('.$commissionPercentage.'%)';
				$datares['transferAmount'] = $currency[0]['symbol'].number_format($sellPrice-($sellPrice/100)*$commissionPercentage,2).$amtTransferststus;
				
				//$datares['buyStatus'] = $datares['buyStatus'].$amtTransferststus;
				//$datares['buy_amt_stranfer_status'] = $v['buy_amt_stranfer_status'];


				$datares['action'] = '<a href="'.base_url().'administrator/listing-buy-request/'.$v['id'].'" class="btn-sm btn-primary editrec" title="View Details"><i class="fa fa-search" aria-hidden="true"></i></a>';
                $dataArr[] = $datares;
            }
		}
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $users['totalrecord']->totalrecord,
            "recordsFiltered" => $users['totalrecord']->totalrecord,
			"data" => $dataArr,
			"datasending" =>$data,
			"token" => $this->security->get_csrf_hash(),
			"sort"=>$sort
			
        );
        echo json_encode($response);
	}
	public function listingOffersDetails($id){
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'sellrequest';
		$header['userData'] = $getUserData;
		$arr['start'] = 0;
		$arr['limit'] = 1;
		$arr['id'] = $id;
		$result = $this->admin_model->getlistingoffers($arr,[]);
		//print '<pre>';
		//print_r($result);
		//die;
		$data['result'] = $result['record'][0];
		$this->load->view('backend/includes/header',$header);
		$this->load->view('backend/listing-offer-details',$data);
		$this->load->view('backend/includes/footer');
	}
	
	public function listingBuyDetails($id){
		$permission = checkAuthorization('BUYREQUEST','LIST');
		$data['editpermission'] = checkAuthorization('BUYREQUEST','DELETE');
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'buyreq';
		$header['userData'] = $getUserData;
		$arr['start'] = 0;
		$arr['limit'] = 1;
		$arr['id'] = $id;
		$arr['section'] = 'LISTING';
		$result = $this->admin_model->getlistingbuyreq($arr);
		
		$data['result'] = $result['record'][0];
		
		$sitesettings = $this->admin_model->getSiteSettings();
		$data['currency'] = $this->admin_model->getCurrencies($sitesettings['currency']);
		
		//Listing offers
		$this->db->select("*");
        $this->db->from(TABLE_PREFIX.'listing_offers');
		$this->db->where('listing_id', $data['result']['listing_id']); 
		$this->db->where('sellerId', $data['result']['sellerId']); 
		$this->db->where('userId', $data['result']['userId']); 
        $this->db->where('status', 2);   
		$Query = $this->db->get();
		$offers = $Query->row();
		$data['offers'] = $offers;
		
		// listing details
		$this->db->select("price");
        $this->db->from(TABLE_PREFIX.'sell_record');
		$this->db->where('listing_id', $data['result']['listing_id']); 
        $Query = $this->db->get();
		$data['listing'] = $Query->row();

		if($data['result']['sold_date'])
		{
			$solddate = $data['result']['sold_date'];
		}else{
			$solddate = date('Y-m-d');
		}
		
		

		if($offers->id>0)
		{
			$datares['offersell'] = 'Offer';
			$sellPrice = $offers->offer_price;
		}else{
			$datares['offersell'] = 'Normal';
			$sellPrice = $data['result']['price'];
		}

		$where = "((price_from<='$sellPrice' and price_to >='$sellPrice') OR (price_from='0.00' and price_to >='$sellPrice') OR (price_from<='$sellPrice' and price_to ='0.00')) and status=1";
		$this->db->select("*");
		$this->db->from(TABLE_PREFIX.'commission_history');
		$this->db->where($where);   
		$Query = $this->db->get();
		$commission = $Query->row();
		$commissionPercentage = $commission->percentage;
		
		$data['amtTransferststus'] = ($data['result']['buy_amt_stranfer_status'] == 1)?' <span style="color:green;">Paid</span>': ' <span style="color:red;">Unpaid</span>';
		$data['commissionAmount'] = number_format(($sellPrice/100)*$commissionPercentage,2).' ('.$commissionPercentage.'%)';
		$data['transferAmount'] = number_format($sellPrice-($sellPrice/100)*$commissionPercentage,2);
		
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/listing-buy-details',$data);
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}

	/*public function contactUs()
	{
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'supportticket';
		$header['userData'] = $getUserData;
		//$data['result'] = $this->admin_model->getuserprofile($userId);
		
		$this->load->view('backend/includes/header',$header);
		$this->load->view('backend/contact-us',$data);
		$this->load->view('backend/includes/footer');
	}

	public function contactUsAction(){
		$draw = $_POST['draw'];
        $data['start'] = $_POST['start'];
		$data['limit'] = $_POST['length'];
		$data['searchName'] = $_POST['search']['value'];
        
        
		$sellRequests = $this->admin_model->getcontactus($data);
		if(is_array($sellRequests['record']) && count($sellRequests['record'])>0)
		{
			$i = 0;
			foreach($sellRequests['record'] as $val){

				$contactus[$i]['name'] = $val['name'];
				$contactus[$i]['email'] = $val['email'];
				$contactus[$i]['phone'] = $val['phone'];
				$contactus[$i]['message'] = mb_strimwidth($val['message'], 0, 70, '...');
				$contactus[$i]['contactDate'] = date('jS M Y',strtotime($val['date_added']));
				$contactus[$i]['action'] = '<a href="'.base_url().'administrator/contactus/details/'.$val['id'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
				$i++;

			}
		}else{
			$contactus = [];
		}
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $sellRequests['totalrecord']->totalrecord,
            "recordsFiltered" => $sellRequests['totalrecord']->totalrecord,
			"data" => $contactus,
			'postdata'=>$search,
			"token" => $this->security->get_csrf_hash()
			
        );
        echo json_encode($response);
	}*/

	public function emailnotificationmanagement(){
		$Notification['userregistration']['keywords'] = ['USERNAME'=>'User Name','USEREMAIL'=>'User Email','USERNAME'=>'User Name','USEREMAIL'=>'User Email'];
		$Notification['userregistration']['notification'] = 'No';
		$dataRec['notification'] = $Notification;
		$this->load->view('backend/includes/header',$header);
		$this->load->view('backend/email-notification',$dataRec);
		$this->load->view('backend/includes/footer');
	}

	public function clearanalytics(){
		$action = 'edit';
		$approveId = $this->input->post('approveId');
		$Arr['traffic'] = '';
		$Arr['earnings'] = '';
		$Arr['id'] = $approveId;
		$que=$this->admin_model->addaltersale($Arr,$action);
		$this->session->set_flashdata('success', 'Business analytics data removed successfully.');
		redirect(base_url().'administrator/sell-request/sell-request-process/'.$this->input->post('requestId'));
	}

	public function contactUsdetails($id)
	{
		//echo $id;
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'supportticket';
		$header['userData'] = $getUserData;
		//$data['result'] = $this->admin_model->getuserprofile($userId);
		$data['start'] = 0;
		$data['limit'] = 1;
		$data['id'] = $id;
		$sellRequests = $this->admin_model->getcontactus($data);
		//print '<pre>';
		//print_r($sellRequests);
		//die;
		$dataRec = $sellRequests['record'][0];
		$this->load->view('backend/includes/header',$header);
		$this->load->view('backend/contact-us-details',$dataRec);
		$this->load->view('backend/includes/footer');
	}


	public function walletAddmoneyDetails($id){
		$permission = checkAuthorization('WALLET','LIST');
		$data['editpermission'] = checkAuthorization('WALLET','DELETE');
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'buyreq';
		$header['userData'] = $getUserData;
		$arr['start'] = 0;
		$arr['limit'] = 1;
		$arr['id'] = $id;
		$arr['section'] = 'WALLET';
		$result = $this->admin_model->getwalletbuyreqadmin($arr);
		
		$data['result'] = $result['record'][0];
		
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/wallet-addmoney-details',$data);
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}

	public function listingBuyReject($id){
		$result = $this->admin_model->updatebuydetails($id,'reject');

		$WalletBalance = $this->front_model->getwalletBalance($result->buyeruserId);
		$this->db->select("*");
		$this->db->from(TABLE_PREFIX.'fund_history');
		$this->db->where('userId', $result->buyeruserId); 
		$this->db->order_by('date_approved', 'desc');   
		$Query = $this->db->get();
		$Array = $Query->row();
		$approvedFund = $Array->approved_fund;

		$curDate = date('Y-m-d H:i:s');
		$arr['userId'] = $result->buyeruserId;
		$arr['fund_proof_approve_date'] = $curDate;
		$arr['proof_fund_status'] = 1;
		$arr['fund_approved_amount'] = $WalletBalance+$approvedFund;
		//$randomstring = strtoupper(substr(str_shuffle(RANDOM_CHAR), 0, 10));
		$randomstring = $this->front_model->setinvestorpassref();
		$arr['Investor_pass'] = $randomstring;
		$result111 = $this->user_model->updateuserdetails($arr);

		$arrHistory['userId'] =$result->buyeruserId;
		$arrHistory['investor_pass'] = $randomstring;
		$arrHistory['activity'] = 'CREATEPASS';
		$arrHistory['unlocked_business'] = 0;
		$this->admin_model->investor_pass_history($arrHistory);



		$user_to = $result->buyeremail;
		$user_subject = 'Your request to buy business listing #'.$result->listing_id.' has been rejected - FIH.com';
		$user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$result->buyername.'</strong>,</h6>
		<br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Unfortunately, your request to buy business has been rejected. Feel free to follow up with us to learn why.</p>
		<br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);
		
		$user_to = $result->selleremail;
		$user_subject = 'Your business listing #'.$result->listing_id.' buy request rejected';
		$user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$result->sellername.'</strong>,</h6>
		<br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Your business listing #'.$result->listing_id.' buy request rejected.</p>
		<br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">FIH.com.</p>';
		//$sendEmail = sendEmail($user_to, $user_subject, $user_message);

		$notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $result->buyeruserId;
        $notificationarr['notification_text'] = 'Your request to buy business listing #'.$result->listing_id.' has been rejected.';
        $notificationarr['notification_type'] = 'BUYNOWREJECT';
        $notificationarr['notification_type_id'] = $id;
		$this->front_model->insertnotification($notificationarr);


		$notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $result->selleruserId;
        $notificationarr['notification_text'] = 'Your business listing #'.$result->listing_id.' buy request rejected.';
        $notificationarr['notification_type'] = 'BUYNOWREJECT';
        $notificationarr['notification_type_id'] = $id;
		//$this->front_model->insertnotification($notificationarr);

		
		$this->session->set_flashdata('success', 'Buy request rejected successfully!');
		redirect('administrator/listing-buy-request');  
	}
	
	public function listingBuyApprove($id){
		//echo $id;
		$result = $this->admin_model->updatebuydetails($id,'approve');
		
		$user_to = $result->buyeremail;
		$user_subject = 'Your request to buy business listing #'.$result->listing_id.' has been approved - FIH.com';
		$user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$result->buyername.'</strong>,</h6>
		<br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Congrats! Your request to buy a business has been approved. Be on the lookout for next steps (regarding) from our team. Please let us
		know if you have any questions in the meantime.</p>
		<br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);
		
		$user_to = $result->selleremail;
		$user_subject = 'Your business listing #'.$result->listing_id.' has sold - FIH.com';
		$user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$result->sellername.'</strong>,</h6>
		<br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Congrats! Your business listing #'.$result->listing_id.' has been sold. Be on the lookout for next steps (regarding transfer) from our team. Please let
		us know if you have any questions in the meantime.</p>
		<br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);

		$notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $result->buyeruserId;
        $notificationarr['notification_text'] = 'Good news! Your request to buy business listing #'.$result->listing_id.' has been approved.';
        $notificationarr['notification_type'] = 'BUYNOWAPPROVE';
        $notificationarr['notification_type_id'] = $id;
		$this->front_model->insertnotification($notificationarr);


		$notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $result->selleruserId;
        $notificationarr['notification_text'] = 'Good news! Your business listing #'.$result->listing_id.' has sold.';
        $notificationarr['notification_type'] = 'BUYNOWAPPROVE';
        $notificationarr['notification_type_id'] = $id;
		$this->front_model->insertnotification($notificationarr);
		
		$this->session->set_flashdata('success', 'Buy request approved successfully!');
		redirect('administrator/listing-buy-request');  
	}
	
	public function walletAddmoneyReject($id){
		$result = $this->admin_model->updatewalletbuydetails($id,'reject');
		//print '<pre>';
		//print_r($result);
		
		$user_to = $result->buyeremail;
		$user_subject = 'Your request to add money to your wallet has been rejected - FIH.com';
		$user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$result->buyername.'</strong>,</h6>
		<br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Unfortunately, your request to add money to your wallet has been rejected. Feel free to follow up with us to learn why.</p>
		<br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);
		
		$notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $result->buyeruserId;
        $notificationarr['notification_text'] = 'Your request to add wallet money has been rejected.';
        $notificationarr['notification_type'] = 'WALLETADDMONEYREJECT';
        $notificationarr['notification_type_id'] = $id;
		$this->front_model->insertnotification($notificationarr);

		$this->session->set_flashdata('success', 'Wallet money request rejected successfully!');
		redirect('administrator/wallet-addmoney-request');  
	}

	public function walletAddmoneyApprove($id){
		//echo $id;
		$result = $this->admin_model->updatewalletbuydetails($id,'approve');
		/*print '<pre>';
		print_r($result);
		die;*/
		$WalletBalance = $this->front_model->getwalletBalance($result->userId);
		////
		$this->db->select("*");
        $this->db->from(TABLE_PREFIX.'fund_history');
        $this->db->where('userId', $result->userId); 
        $this->db->order_by('date_approved', 'desc');   
        $Query = $this->db->get();
        $Array = $Query->row();
		$approvedFund = $Array->approved_fund;
		
		$curDate = date('Y-m-d H:i:s');
		$arr['userId'] = $result->userId;
		$arr['fund_proof_approve_date'] = $curDate;
		$arr['proof_fund_status'] = 1;
		$arr['fund_approved_amount'] = $WalletBalance+$approvedFund;
		$arr['fund_source'] = 'WALLET';
		//$randomstring = strtoupper(substr(str_shuffle(RANDOM_CHAR), 0, 10));
		$randomstring = $this->front_model->setinvestorpassref();
		$arr['Investor_pass'] = $randomstring;
		$result11 = $this->user_model->updateuserdetails($arr);

		$arrHistory['userId'] = $result->userId;
		$arrHistory['investor_pass'] = $randomstring;
		$arrHistory['activity'] = 'CREATEPASS';
		$arrHistory['unlocked_business'] = 0;
		$this->admin_model->investor_pass_history($arrHistory);
		////
		// print '<pre>';
		// print_r($result);
		// die;
		$user_to = $result->buyeremail;
		$user_subject = 'Your request to add wallet to your money has been approved - FIH.com';
		$user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$result->buyername.'</strong>,</h6>
		<br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Success! Your request to add money to your wallet has been approved.</p>
		<br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);
		

		$notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $result->buyeruserId;
        $notificationarr['notification_text'] = 'Your request to add wallet to your money has been approved - FIH.com';
        $notificationarr['notification_type'] = 'WALLETADDMONEYAPPROVE';
        $notificationarr['notification_type_id'] = $id;
		$this->front_model->insertnotification($notificationarr);

		$this->session->set_flashdata('success', 'Wallet money approved successfully!');
		redirect('administrator/wallet-addmoney-request');  
	}

	public function walletWithdrawmoneyReject($id){
		$result = $this->admin_model->updatewalletbuydetails($id,'reject');
		$WalletBalance = $this->front_model->getwalletBalance($result->userId);
		$this->db->select("*");
		$this->db->from(TABLE_PREFIX.'fund_history');
		$this->db->where('userId', $result->userId); 
		$this->db->order_by('date_approved', 'desc');   
		$Query = $this->db->get();
		$Array = $Query->row();
		$approvedFund = $Array->approved_fund;

		$curDate = date('Y-m-d H:i:s');
		$arr['userId'] = $result->userId;
		$arr['fund_proof_approve_date'] = $curDate;
		$arr['proof_fund_status'] = 1;
		$arr['fund_approved_amount'] = $WalletBalance+$approvedFund;
		//$randomstring = strtoupper(substr(str_shuffle(RANDOM_CHAR), 0, 10));
		$randomstring = $this->front_model->setinvestorpassref();
		$arr['Investor_pass'] = $randomstring;
		$result111 = $this->user_model->updateuserdetails($arr);

		$arrHistory['userId'] =$result->userId;
		$arrHistory['investor_pass'] = $randomstring;
		$arrHistory['activity'] = 'CREATEPASS';
		$arrHistory['unlocked_business'] = 0;
		$this->admin_model->investor_pass_history($arrHistory);

		
		$user_to = $result->buyeremail;
		$user_subject = 'Your request to withdraw money from wallet has been rejected - FIH.com';
		$user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$result->buyername.'</strong>,</h6>
		<br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Unfortunately, your request to withdraw money from your wallet has been rejected. Feel free to follow up with us to learn why.</p>
		<br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);
		
		$notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $result->buyeruserId;
        $notificationarr['notification_text'] = 'Your request to withdraw money from your wallet has been rejected.';
        $notificationarr['notification_type'] = 'WALLETWITHDRAWMONEYREJECT';
        $notificationarr['notification_type_id'] = $id;
		$this->front_model->insertnotification($notificationarr);

		$this->session->set_flashdata('success', 'Wallet withdraw money request rejected successfully!');
		redirect('administrator/wallet-addmoney-request');  
	}

	public function walletWithdrawmoneyApprove($id){
		$result = $this->admin_model->updatewalletbuydetails($id,'approve');
		
		$WalletBalance = $this->front_model->getwalletBalance($result->userId);
		////
		$curDate = date('Y-m-d H:i:s');
		$arr['userId'] = $result->userId;
		$arr['fund_proof_approve_date'] = $curDate;
		$arr['proof_fund_status'] = 1;
		$arr['fund_approved_amount'] = $WalletBalance;
		$arr['fund_source'] = 'WALLET';
		$randomstring = $this->front_model->setinvestorpassref();
		$arr['Investor_pass'] = $randomstring;
		$result11 = $this->user_model->updateuserdetails($arr);

		$arrHistory['userId'] = $result->userId;
		$arrHistory['investor_pass'] = $randomstring;
		$arrHistory['activity'] = 'CREATEPASS';
		$arrHistory['unlocked_business'] = 0;
		$this->admin_model->investor_pass_history($arrHistory);
		
		$user_to = $result->buyeremail;
		$user_subject = 'Your request to withdraw funds from your wallet has been approved - FIH.com';
		$user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$result->buyername.'</strong>,</h6>
		<br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Success! Your request to withdraw funds from your wallet has been approved.</p>
		<br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);
		

		$notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $result->buyeruserId;
        $notificationarr['notification_text'] = 'Your request to withdraw money from your wallet has been approved.';
        $notificationarr['notification_type'] = 'WALLETWITHDRAWMONEYAPPROVE';
        $notificationarr['notification_type_id'] = $id;
		$this->front_model->insertnotification($notificationarr);

		$this->session->set_flashdata('success', 'Wallet money approved successfully!');
		redirect('administrator/wallet-addmoney-request');  
	}

	public function listingBuytransferStatus($id)
	{
		$arr['id'] = $id;
		$arr['transfer_status'] = $this->input->post('transferStatus');
		$arr['status'] = 2;
		$result = $this->admin_model->updatebuytransferdetails($arr);

		//print '<pre>';
		//print_r($result);
		$user_to = $result->buyeremail;
        $user_subject = 'Your Won business listing #'.$result->listing_id.' status has been updated - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$result->buyername.'</strong>,</h6>
		<br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Your won business listing #'.$result->listing_id.' status has been updated. Please check the status by going to your FIH.com dashboard.</p>
		<br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);

		$user_to = $result->selleremail;
        $user_subject = 'Your sold business listing #'.$result->listing_id.' had its status updated - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$result->sellername.'</strong>,</h6>
		<br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Your sold business listing #[LISTINGID] status has been updated by the Admin. Please check the status by going to your FIH.com
		dashboard.</p>
		<br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);

		$notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $result->userId;
        $notificationarr['notification_text'] = 'Your won business listing #'.$result->listing_id.' status has been updated.';
        $notificationarr['notification_type'] = 'SOLDBUSINESSSTATUSB';
        $notificationarr['notification_type_id'] = $id;
		$this->front_model->insertnotification($notificationarr);

		$notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $result->sellerId;
        $notificationarr['notification_text'] = 'Your sold business listing #'.$result->listing_id.' status has been updated.';
        $notificationarr['notification_type'] = 'SOLDBUSINESSSTATUS';
        $notificationarr['notification_type_id'] = $id;
		$this->front_model->insertnotification($notificationarr);

		$this->session->set_flashdata('success', 'Business transfer status updated successfully!');
		redirect('administrator/listing-buy-request/'.$id);  

	}

	public function faqEdit($faqId){
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'sellrequest';
		$header['userData'] = $getUserData;
		$data['result'] = $this->admin_model->getfaqdetails($faqId);
		$data['deletepermission'] = checkAuthorization('FAQ','DELETE');
		//print '<pre>';
		//print_r($data['result']);
		//die;
		$this->load->view('backend/includes/header',$header);
		$this->load->view('backend/pending-faqs-details',$data);
		$this->load->view('backend/includes/footer');
	}

	public function faqApprove($faqId){
		$permission = checkAuthorization('FAQ','DELETE');
		if($permission)
		{
		$result_get = $this->admin_model->getfaqdetails($faqId);
		
		$arr['id'] = $faqId;
        $arr['Status'] = 2;
		$arr['approve_date'] = date('Y-m-d H:i:s');
		$arr['seller_reply']=$this->input->post('reply');
		$arr['question']=$this->input->post('question');
		$result = $this->front_model->insertfaq($arr,'edit');
		
        $user_to = $result_get->buyeremail;
        $user_subject = 'Your FAQ has been replied to on listing #'.$result_get->listing_id.' - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$result_get->buyername.'</strong>,</h6>
		<br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Your FAQ has been replied to on listing #'.$result_get->listing_id.'. Please check the reply by logging into FIH.com.</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);

		//$user_to = $result_get->selleremail;
        //$user_subject = 'Your FAQ Reply on listing #'.$result_get->listing_id.' is approved - FIH.com';
        //$user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$result_get->sellername.'</strong>,</h6>
        //<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Your FAQ Reply on listing #'.$result_get->listing_id.' is approved. Please check the reply by login to your QEIP cPanel.</p>
        //<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Best regards.</p>
        //<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">FIH.com Team.</p>';
		//$sendEmail = sendEmail($user_to, $user_subject, $user_message);
		$this->session->set_flashdata('success', 'FAQ approved successfully!');

        //$userDetails = $this->front_model->userDetailswrtlistingno($arr['listing_id']);
        $notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $result_get->buyeruserID;
        $notificationarr['notification_text'] = 'You have received a FAQ Reply from the seller.';
        $notificationarr['notification_type'] = 'FAQREPLYADMIN';
        $notificationarr['notification_type_id'] = $faqId;
		$this->front_model->insertnotification($notificationarr);

		/*$notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $result_get->selleruserID;
        $notificationarr['notification_text'] = 'YOUR FAQ Reply is approved by QEIP Admin.';
        $notificationarr['notification_type'] = 'FAQREPLYADMIN';
        $notificationarr['notification_type_id'] = $faqId;
		$result = $this->front_model->insertnotification($notificationarr);*/
		
		redirect('administrator/faqs');  
		}else{
			$header['sitetitle'] = 'ADMIN - FIH.com';
			$header['class'] = 'sellrequest';
			$header['userData'] = $getUserData;
			$this->load->view('backend/includes/header',$header);
			$this->load->view('backend/unauthorized');
			$this->load->view('backend/includes/footer');
		}

	}
	public function faqReject($faqId){
		$permission = checkAuthorization('FAQ','DELETE');
		if($permission)
		{
		$result_get = $this->admin_model->getfaqdetails($faqId);

		$arr['id'] = $faqId;
        $arr['Status'] = 3;
		//$arr['approve_date'] = date('Y-m-d H:i:s');
		//$arr['seller_reply']=$this->input->post('reply');
		//$arr['question']=$this->input->post('question');
		$result = $this->front_model->insertfaq($arr,'edit');
		
        $user_to = $result_get->buyeremail;
        $user_subject = 'Your FAQ has been removed on listing #'.$result_get->listing_id.' - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$result_get->buyername.'</strong>,</h6>
		<br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Your FAQ has been removed on listing #'.$result_get->listing_id.'. Feel free to follow up with our team to learn why.</p>
		<br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);
		$notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $result_get->buyeruserID;
        $notificationarr['notification_text'] = 'Your FAQ is rejected on listing #'.$result_get->listing_id;
        $notificationarr['notification_type'] = 'FAQREPLYADMIN';
        $notificationarr['notification_type_id'] = $faqId;
		$this->front_model->insertnotification($notificationarr);

		$user_to = $result_get->selleremail;
        $user_subject = 'Your FAQ reply on listing #'.$result_get->listing_id.' has been removed - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$result_get->sellername.'</strong>,</h6>
		<br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Your FAQ Reply on listing #'.$result_get->listing_id.' has been removed. Feel free to follow up with our team to learn why.</p>
		<br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);

		$notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $result_get->selleruserID;
        $notificationarr['notification_text'] = 'Your FAQ Reply on listing #'.$result_get->listing_id.' has been removed.';
        $notificationarr['notification_type'] = 'FAQREPLYADMIN';
        $notificationarr['notification_type_id'] = $faqId;
		$this->front_model->insertnotification($notificationarr);
		$this->session->set_flashdata('success', 'FAQ rejected successfully!');
		redirect('administrator/faqs'); 
		}else{
			$header['sitetitle'] = 'ADMIN - FIH.com';
			$header['class'] = 'sellrequest';
			$header['userData'] = $getUserData;
			$this->load->view('backend/includes/header',$header);
			$this->load->view('backend/unauthorized');
			$this->load->view('backend/includes/footer');
		} 

	}

	public function callschedules(){
		$permission = checkAuthorization('CALLSCHEDULE','LIST');
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'supportticket';
		$header['userData'] = $getUserData;
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/scheduledcalls',$data);
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}

	public function callschedulesaction(){
		$draw = $_POST['draw'];
        $data['start'] = $_POST['start'] = 0;
		$data['limit'] = $_POST['length'] = 10;
		$data['start'] = 0;
		$data['limit'] = 10;
        $data['searchValue'] = $_POST['searchName'];
		$data['searchTimeSchedulecall'] = $_POST['searchTimeSchedulecall'];
		$data['searchStatus'] = $_POST['searchByStatus'];
		$sort = $_POST['order'][0];
        $callrequests = $this->admin_model->getcalllog($data,$sort);
		$dataArr = [];
        if(is_array($callrequests['callrequests']) && count($callrequests['callrequests'])>0)
        {
            
            $i = $data['start']+1;
            foreach($callrequests['callrequests'] as $v)
            {
				$datares['sl_no'] = $i;
				$json_text = $v['data_json'];
				$jsonArr = json_decode($json_text,true);
				
                $i++;
				$datares['name'] = $v['user_name'];
				$datares['email'] = '<a target="_blank" href="'.base_url().'administrator/users/edit/'.$v['user_id'].'">'.$v['email'].'</a>';
				$datares['phone'] = $v['user_phone'];
				$datares['scheduledtime'] = date('jS M Y @ h:i a',strtotime($v['call_time']));
				
				$datares['enqiry_type'] = $v['enqiry_type'];
				$datares['note'] = mb_strimwidth($v['note'], 0, 70, '...');
				if($v['status'] == 1)
				{
					$datares['status'] = 'Pending';
				}elseif($v['Status'] == 2)
				{
					$datares['status'] = 'Rejected';
				}elseif($v['status'] == 3)
				{
					$datares['status'] = 'Approved';
				}elseif($v['status'] == 4)
				{
					$datares['status'] = 'Completed';
				}
				
					$datares['action'] = '<a href="'.base_url().'administrator/callschedule/view/'.$v['id'].'" class="btn-sm btn-primary editrec"><i class="fa fa-eye" aria-hidden="true"></i></a>';
				
				
                $dataArr[] = $datares;
            }
        }
		$response = array(
            "draw" => intval($draw),
            "recordsTotal" => $callrequests['totalrecord']->totalrecord,
            "recordsFiltered" => $callrequests['totalrecord']->totalrecord,
			"data" => $dataArr,
			"post" =>$_POST,
			"token" => $this->security->get_csrf_hash()
			
        );
        echo json_encode($response);
	}

	public function editCall($id){
		$permission = checkAuthorization('CALLSCHEDULE','LIST');
		$data['id'] = $id;
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'supportticket';
		$header['userData'] = $getUserData;
		$data['result'] = $this->admin_model->getcalllog($data);
		$data['editpermission'] = checkAuthorization('CALLSCHEDULE','EDIT');
		// print '<pre>';
		// print_r($data['result']);
		// die;
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/pending-call-details',$data);
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}

	public function editCallAction(){
		
		if(checkAuthorization('CALLSCHEDULE','EDIT'))
		{
		$data['user_name'] = $this->input->post('user_name');
		$data['user_phone'] = $this->input->post('user_phone');
		$data['call_time'] = $this->input->post('call_time');
		$data['note'] = $this->input->post('note');
		$data['status'] = $this->input->post('Status');
		$data['id'] = $this->input->post('CallId');
		$result = $this->admin_model->updatecalllog($data);
		$datafetch['id'] = $data['id'];
		$datafetch['start'] = 0;
		$datafetch['limit'] = 1;
		$result = $this->admin_model->getcalllog($datafetch);

		$user_to = $result['callrequests'][0]['email'];
		if($data['status'] == 3)
		{
			$user_subject = 'Your call schedule request has been approved - FIH.com';
			$user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$result['callrequests'][0]['user_name'].'</strong>,</h6>
			<br>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Success! Your call schedule request has been approved. You can expect a call from our team on '.date('jS M Y @ h:i a',strtotime($result['callrequests'][0]['call_time'])).'. We look forward to
			speaking with you.</p>
			<br>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
			$sendEmail = sendEmail($user_to, $user_subject, $user_message);
			$notificationarr['sender'] = 1;
			$notificationarr['receiver'] = $result['callrequests'][0]['user_id'];
			$notificationarr['notification_text'] = 'Your call schedule request has been accepted. You will receive a call on '.date('jS M Y @ h:i a',strtotime($result['callrequests'][0]['call_time'])).'.';
			$notificationarr['notification_type'] = 'CALLSHDULE';
			$notificationarr['notification_type_id'] = $this->input->post('CallId');
			$this->front_model->insertnotification($notificationarr);
		}elseif($data['status'] == 2)
		{
			$user_subject = 'Your call schedule request has been denied - FIH.com';
			$user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$result['callrequests'][0]['user_name'].'</strong>,</h6>
			<br>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Unfortunately, your call schedule request has been denied. Please try to reschedule your call for another date and time in the future. We
			look forward to speaking with you in the future.</p>
			<br>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
			$sendEmail = sendEmail($user_to, $user_subject, $user_message);
			$notificationarr['sender'] = 1;
			$notificationarr['receiver'] = $result['callrequests'][0]['user_id'];
			$notificationarr['notification_text'] = 'Your call schedule request has been denied. Please reschedule your call for another date and time.';
			$notificationarr['notification_type'] = 'CALLSHDULE';
			$notificationarr['notification_type_id'] = $this->input->post('CallId');
			$this->front_model->insertnotification($notificationarr);
		}elseif($data['status'] == 4)
		{
			$notificationarr['sender'] = 1;
			$notificationarr['receiver'] = $result['callrequests'][0]['user_id'];
			$notificationarr['notification_text'] = 'Your Call request is completed. If all your queries is not sorted, Please raise a support for more details.';
			$notificationarr['notification_type'] = 'CALLSHDULE';
			$notificationarr['notification_type_id'] = $this->input->post('CallId');
			$this->front_model->insertnotification($notificationarr);
		}
        
		
		$this->session->set_flashdata('success', 'Call Details Has Been Updated!!!!');
		}
		redirect(base_url().'administrator/callschedule/view/'.$data['id']);
	}

	public function loadmoreUserNotification(){
		// get notifications
		$postData = $this->input->post();
		//$url = 'api/user/getnotifications';
        $userDataOffer['page'] = $postData['page'];
        $userDataOffer['limit'] = $postData['limit'];
        $userDataOffer['userId'] = 1;
		$notifications = $this->notificationdetails($userDataOffer);
		//$notifications = sendRestRequest($url, $userDataOffer);
		$notifications['token'] = $this->security->get_csrf_hash();
		header('Content-Type: application/json');
    	echo json_encode($notifications);
	}
	public function removeUserNotification($id){
		//$url = 'api/user/delnotifications';
        $userDataOffer['id'] = $id;
        $userDataOffer['userId'] = 1;
		$this->front_model->deleteusernotifications($userDataOffer);
		//$notifications = sendRestRequest($url, $userDataOffer);
		$notifications['token'] = $this->security->get_csrf_hash();
		$notifications['status'] = true;
		$notifications['id'] = $id;
		header('Content-Type: application/json');
    	echo json_encode($notifications);
	}

	public function exportanalyticsdata($id){
		$getApproveddata = $this->admin_model->getapprovedselldata($id);
		$list = array (
			array("Month", "Year" ,"Revenue", "Profit", "Visitors", "Pageviews"),
		);
		$monthArr = ['January','February','March','April','May','June','July','August','September','October','November','December'];
		$earning = json_decode($getApproveddata->earnings,true);
		$traffic = json_decode($getApproveddata->traffic,true);
		//$datalist = $earning;  
		if(is_array($earning) && count($earning)>0)
		{
			foreach($earning as $k=>$v)
			{
				$year = $v['year'];
				$revenueData = $v['avgRevenue'];
				$profitData = $v['avgProfit'];
				$newDataArr[$year][] = ['revenue'=>$revenueData,'profit'=>$profitData];
				/*for($i=0; $i<12; $i++)
				{
					$list[] = [$monthArr[$i],$v['year'],$revenueData[$i],$profitData[$i]];
				}*/
			}
		}
		if(is_array($traffic) && count($traffic)>0)
		{
			foreach($traffic as $k=>$v)
			{
				$year = $v['year'];
				$pageviewData = $v['avgPageview'];
				$visitorData = $v['avgVisitor'];
				$newDataArr[$year][] = ['pageview'=>$pageviewData,'visitor'=>$visitorData];
				
			}
		}
		if(is_array($newDataArr) && count($newDataArr)>0)
		{
			foreach($newDataArr as $key=>$val)
			{
				for($i=0; $i<12; $i++)
				{
					$list[] = [$monthArr[$i],$key,$val[0]['revenue'][$i],$val[0]['profit'][$i],$val[1]['visitor'][$i],$val[1]['pageview'][$i]];
				}
			}
		}
		$file = fopen( 'php://output', 'w' );
		  
		foreach ($list as $line) {
			fputcsv($file, $line);
		}
		  
		fclose($file);
	}

	// Export Users Via Method - Sourav Das - 05092024
	public function export_users(){
		/*$libSpreadsheet = $this->excel_export->spreadsheet;
		$activeWorksheet = $libSpreadsheet->getActiveSheet();
		$activeWorksheet->setCellValue('A1', 'Hello World !');

		$xlsSheet = $this->excel_export->createdXlsx($libSpreadsheet);
		$writer->save('./uploads/exported_excels/users/hello_world.xlsx');*/

		$file_name = 'fih_users_on_'.date('YmdHis').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$file_name"); 
		header("Content-Type: application/csv;");
   
		// get data 
		$userData = $this->admin_model->getExportedUserData();

		// file creation 
		$file = fopen('php://output', 'w');

		$header = array(
					"Name",
					"Email",
					"Phone",
					"Date Of Birth",
					"Fund Status",
					"Fund Approved Date",
					"Identity Status",
					"Identity Approved Date",
					"Status",
					"Added On"
				);
		fputcsv($file, $header);
		foreach ($userData as $key => $value) { 
			fputcsv($file, $value); 
		}
		fclose($file); 
		exit;
	}

	

	
}