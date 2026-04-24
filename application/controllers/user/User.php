<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
	
	public function __construct() {
		parent::__construct();
		$this->load->library(array('form_validation', "upload"));
		$this->load->model('front_model');
		$this->load->model('admin_model');
		$this->load->model('user_model');
		$this->load->library('paypal_lib');
		$this->load->library('pagination');
		if($logincookie!='' && !$this->session->userdata('isLoggedIn')) {
			$this->loginrememberme();
		} elseif(!$this->session->userdata('isLoggedIn') && !$this->session->userdata('user_id')) {
			redirect(base_url().'login');
		}
		if($this->session->userdata('roleText') =='admin' || $this->session->userdata('roleText') =='subadmin') {
			redirect(base_url().'administrator');
		}

	}
	public function dashboard() {
		redirect(base_url().'user/buyer');
		$header = $this->front_model->header();
		$header['site_settings']->site_title = 'Seller Dashboard - '.$header['site_settings']->site_title;
        $footer = $this->front_model->footer();
		$url = 'api/data/getprofile';
		
		//$userDataPost = $this->input->post();
		$userDataPost['userId'] = $this->session->userdata('user_id');
		$res = sendRestRequest($url, $userDataPost);
		$data['profiledata'] = $res['data'];

		// get notifications
		/*$url = 'api/user/getnotifications';
        $userDataOffer['page'] = 0;
        $userDataOffer['limit'] = 15;
        $userDataOffer['userId'] = $this->session->userdata('user_id');
		$data['notifications'] = sendRestRequest($url, $userDataOffer);*/
		
		$data['sellerOffers'] = $sellerOffers['data'];
		$data['sellerOffersStart'] = $userDataOffer['page'];
		$data['sellerOffersLimit'] = $userDataOffer['limit'];
		$this->load->view('user/includes/header',$header);
		$this->load->view('user/buyer-dashboard',$data);
		$this->load->view('user/includes/footer',$footer);
	}
	
	public function selldashboard() {
		$page = ($curPage>0) ? ($curPage - 1) : 0;
        $url = 'api/marketplace/sellerlisting';
        $userData['page'] = $page;
        $userData['limit'] = 10;
        $userData['detaillisting'] = false;
        $userData['userId'] = $this->session->userdata('user_id');
		$res = sendRestRequest($url, $userData);

		/*$userData['start'] = $page;
		print_r($userData);
		$listdata = $this->front_model->getSellerListing($userData);*/
		
		$data= $res['data'];
		$datatotallisting = $res['data'];
        $dataPost['totalnumberoflisting'] = $datatotallisting['totalrecord']['totalrecord'];
        $dataPost['totalnumberofnewlisting'] = $data['totalrecord']['totalrecord'];
        $config['base_url'] = base_url();
        $config['total_rows'] = $data['totalrecord']['totalrecord'];
        $config['per_page'] = $userData['limit'];
        $config['uri_segment'] = 2;
        $config['full_tag_open'] = '<div class="pagination_fg">';
        $config['full_tag_close'] = '</div>';
        $config['next_link'] = '&raquo;';
        $config['prev_link'] = '&laquo;';
        $config['cur_tag_open'] = '<a class="active">';
        $config['cur_tag_close'] = '</a>';
        /* $config['num_tag_open'] = '<p>';
        $config['num_tag_close'] = '</p>';*/
        $config['attributes'] = array('class' => 'pager');
        $config['use_page_numbers'] = TRUE;
        $config['last_link'] = FALSE;
        
        $this->pagination->initialize($config);
        $getListingDetails = $data['listing'];
		$data['sellerListing'] = $getListingDetails;
		
		$url = 'api/user/sellerfaq';
        $userData['page'] = $page;
        $userData['limit'] = 15;
        $userData['userId'] = $this->session->userdata('user_id');
		$resFAQ = sendRestRequest($url, $userData);


		$data['sellerFAQ'] = $resFAQ['data'];
		$data['sellerFAQlimit'] = $userData['limit'];
		$data['sellerFAQstart'] = $userData['page'];

		$url = 'api/user/valuationlist';
		$userData['userId'] = $this->session->userdata('user_id');
		
		$resVAluationList = sendRestRequest($url, $userData);
		$data['valuationListData'] = $resVAluationList['data'];
		

		//print '<pre>';
        //print_r($resVAluationList);
        //die;
		// get Curated Content For Sellers
		$url = 'api/user/sellercuratedcontents';
        $userData['page'] = 0;
        $userData['limit'] = 300;
        $userData['userId'] = $this->session->userdata('user_id');
		$resCuratedContents = sendRestRequest($url, $userData);
		$data['CuratedContents'] = $resCuratedContents['data'];

		// get Curated Content For Sellers
		$url = 'api/user/sellerfreecontents';
		$resCuratedContents = sendRestRequest($url, $userData);
		$data['freecontents'] = $resCuratedContents['data'];
		
		// get offers
		$url = 'api/user/sellergetoffers';
        $userDataOffer['page'] = 0;
        $userDataOffer['limit'] = 10;
        $userDataOffer['userId'] = $this->session->userdata('user_id');
		$sellerOffers = sendRestRequest($url, $userDataOffer);
		$data['sellerOffers'] = $sellerOffers['data'];
		$data['sellerOffersStart'] = $userDataOffer['page'];
		$data['sellerOffersLimit'] = $userDataOffer['limit'];
		// get pending sell applications
		$url = 'api/user/sellpendingapplications';
        $userDataPending['userId'] = $this->session->userdata('user_id');
		$sellerPendingApplications = sendRestRequest($url, $userDataPending);
		
		$data['applications'] = $sellerPendingApplications['data'];
		
		$slidetab = $this->session->flashdata('slidetab');

		$url = 'api/marketplace/soldlisting';
		$userData['userId'] = $this->session->userdata('user_id');
		$buyerWonList = sendRestRequest($url, $userData);

		$data['SoldList'] = $buyerWonList['data']['listing'];
		
		$data['LogginUser'] = $this->session->userdata('user_id');

		
		
		if($slidetab>0)
		{
			$data['firstslide'] = 'N';
		}else{
			$data['firstslide'] = 'Y';
		}
		

		$header = $this->front_model->header();
		$header['site_settings']->site_title = 'Seller Dashboard - '.$header['site_settings']->site_title;
        $footer = $this->front_model->footer();
		$this->load->view('user/includes/header',$header);
		$this->load->view('user/dashboard',$data);
		$this->load->view('user/includes/footer',$footer);
	}

	public function sellmoreinfo($listingId){
		$header = $this->front_model->header();
        $footer = $this->front_model->footer();
		
		$data['listingId'] = $listingId;
		$loginUser = $this->session->userdata('user_id');

		$this->db->select('*', FALSE);
        $this->db->from(TABLE_PREFIX.'sell_business_temp', FALSE);
        $this->db->where('userId', $loginUser);    
        $this->db->where('Status<>', 0);
        $this->db->where('type', 'SELL');  
		$this->db->where('listing_id', $listingId);  
        $this->db->limit(1);      
        $Query = $this->db->get();
        $sellrec = $Query->row();
		if($sellrec->id >0)
		{
			if($sellrec->sell_answers != '')
			{
				//$data['sellQArtr'] = json_decode($sellrec->sell_answers,true);
				$sellQArtr = json_decode($sellrec->sell_answers,true);
				$data['sellQStatus'] = $sellrec->sell_answers_status;
			}else{
				$sellQ = $header['site_settings']->sell_questions;
				//$data['sellQArtr'] = json_decode($sellQ,true);
				$sellQArtr = json_decode($sellQ,true);
			}
			$Questioncat = $this->admin_model->getquestioncategories();

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
				$data['sellQArtr'] = $newQArray;

				//print '<pre>';
				//print_r($data['sellQStatus']);
				//die;
			}
		}else{
			redirect(base_url().'user/sell');
		}
		
		
		$this->load->view('user/includes/header',$header);
		$this->load->view('user/moreinfoselldata',$data);
		$this->load->view('user/includes/footer',$footer);
	}

	public function sellmoreinfoAction(){
		$userDataPost = $this->input->post();
		
		$loginUser = $this->session->userdata('user_id');
		$listingId = $userDataPost['listingId'];

		$this->db->select('*', FALSE);
        $this->db->from(TABLE_PREFIX.'sell_business_temp', FALSE);
        $this->db->where('userId', $loginUser);    
        $this->db->where('Status<>', 0);
        $this->db->where('type', 'SELL');  
		$this->db->where('listing_id', $listingId);  
        $this->db->limit(1);      
        $Query = $this->db->get();
        $sellrec = $Query->row();
		$site_settings = $this->admin_model->getSiteSettings();
		if($sellrec->id >0)
		{
			if($sellrec->sell_answers != '')
			{
				$sellQArtr = json_decode($sellrec->sell_answers,true);
			}else{
				$sellQArtr = json_decode($site_settings['sell_questions'],true);
			}

			$Questioncat = $this->admin_model->getquestioncategories();

			if(is_array($Questioncat) && count($Questioncat)>0 && is_array($sellQArtr) && count($sellQArtr)>0) 
			{
				$k=0;
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
							$answerGiven = $userDataPost['Answer'.$k];
							$sellQArtr[$i]['AnswerGiven'] = $answerGiven;
							$newQArray[$id]['addedquestions'][] = $sellQArtr[$i];
							$k++;
							$sell_questions[] =$sellQArtr[$i]; 
						}
						$i++;
						
					}
				}
				//$sell_questions = $newQArray;
			}

			/*
			$i=0;
			while($sell_questions[$i])
			{
				$answerGiven = $userDataPost['Answer'.$i];
				$sell_questions[$i]['AnswerGiven'] = $answerGiven;
				$i++;
			}*/
			//print '<pre>';
			//print_r($sell_questions);
			//die;
			$sell_answers = json_encode($sell_questions);
			$this->db->set('sell_answers', $sell_answers);
			$this->db->set('sell_answers_status', $userDataPost['answerStatus']);
            $this->db->where('userId', $loginUser);
            $this->db->where('id', $sellrec->id);
            $this->db->where('listing_id', $listingId);
            $this->db->update(TABLE_PREFIX.'sell_business_temp');
			if($userDataPost['answerStatus'] == 0)
			{
				$this->session->set_flashdata('success', 'Data successfully saved as draft.');
				redirect(base_url().'user/sell/moreinfo/'.$listingId);
			}elseif($userDataPost['answerStatus'] == 1)
			{
				$user_to = $site_settings['support_email_address'];
				$this->session->set_flashdata('success', 'Data successfully Published. Your answer is under review and we will get back to you soon.');
				$user_subject = 'Answers on listing #'.$listingId.' is Published - FIH.com';
				$user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">Admin</strong></h6>
				<br><br>
				<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial"> Answers on listing #'.$listingId.' is published for your review. Please check the answers and approve it to display at listing details page.</p>
				<br><br>
				<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers.</p>
				<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
				//$sendEmail = sendEmail($user_to, $user_subject, $user_message);
				redirect(base_url().'user/sell/moreinfo/'.$listingId);
			}else{
				redirect(base_url().'user/sell/moreinfo/'.$listingId);
			}
		}else{
			redirect(base_url().'user/sell');
		}
	}

	public function scheduleCall(){
		//echo 'i am shreejat koley';
		$userData = $this->input->post();
		$url = 'api/user/callschedule';
        $userData['userId'] = $this->session->userdata('user_id');
		$resSchedule = sendRestRequest($url, $userData);
		/*print '<pre>';
		print_r($resSchedule);
		die;*/
		if($resSchedule['status'])
		{
			$data = array(
				'message' => $resSchedule['message'],
				'errorCode'=>0,
				'dataval' => [],
				'faqseller' =>true,
			);
			$this->session->set_flashdata('successCall', $data);
			//$this->session->set_flashdata('slidetab', 3);
		}else{
			$data = array(
				'errorcall' => $resSchedule['message'],
				'errorCode'=>1,
				'dataval' => ['token'=>$this->security->get_csrf_hash(),'ret'=>$resSchedule['data']],
				'faqseller' =>true,
			);
			$this->session->set_flashdata('errorCall', $data);
			//$this->session->set_flashdata('slidetab', 3);
		}
		redirect(base_url().'scheduledcalls');    
	}

	public function buyerdashboard()
	{
		
		$page = ($curPage>0) ? ($curPage - 1) : 0;
        $url = 'api/marketplace/buyerunlockedlisting';
        $userData['page'] = $page;
        $userData['limit'] = 10;
        $userData['detaillisting'] = false;
        $userData['userId'] = $this->session->userdata('user_id');
		$res = sendRestRequest($url, $userData);
		/*echo '<pre>';
		print_r($listdata);
		echo '</pre>';*/
		$data= $res['data'];
		/*echo '<pre>';
		print_r($data);
		echo '</pre>';*/
		$datatotallisting = $res['data'];
        $dataPost['totalnumberoflisting'] = $datatotallisting['totalrecord']['totalrecord'];
        $dataPost['totalnumberofnewlisting'] = $data['totalrecord']['totalrecord'];
        $config['base_url'] = base_url();
        $config['total_rows'] = $data['totalrecord']['totalrecord'];
        $config['per_page'] = $userData['limit'];
        $config['uri_segment'] = 2;
        $config['full_tag_open'] = '<div class="pagination_fg">';
        $config['full_tag_close'] = '</div>';
        $config['next_link'] = '&raquo;';
        $config['prev_link'] = '&laquo;';
        $config['cur_tag_open'] = '<a class="active">';
        $config['cur_tag_close'] = '</a>';
        /* $config['num_tag_open'] = '<p>';
        $config['num_tag_close'] = '</p>';*/
        $config['attributes'] = array('class' => 'pager');
        $config['use_page_numbers'] = TRUE;
        $config['last_link'] = FALSE;
        
        $this->pagination->initialize($config);
		$getListingDetails = $data['listing'];
		//print '<pre>';
		//print_r($getListingDetails);
		//die;
		$data['sellerListing'] = $getListingDetails;

		$url = 'api/marketplace/buyerwonlisting';
		$userData['userId'] = $this->session->userdata('user_id');
		$buyerWonList = sendRestRequest($url, $userData);
		$data['buyerWonList'] = $buyerWonList['data']['listing'];
		//print '<pre>';
		//print_r($data['buyerWonList']);
		//die;
		
		$url = 'api/user/buyerfaq';
        $userData['page'] = $page;
        $userData['limit'] = 15;
        $userData['userId'] = $this->session->userdata('user_id');
		$resFAQ = sendRestRequest($url, $userData);
		
		$data['sellerFAQ'] = $resFAQ['data'];
		$data['sellerFAQlimit'] = $userData['limit'];
		$data['sellerFAQstart'] = $userData['page'];

		// get Curated Content For Sellers
		$url = 'api/user/sellercuratedcontents';
        $userData['page'] = 0;
		$userData['limit'] = 300;
		$userData['area'] = 'BUYER';
        $userData['userId'] = $this->session->userdata('user_id');
		$resCuratedContents = sendRestRequest($url, $userData);
		$data['CuratedContents'] = $resCuratedContents['data'];

		// get Curated Content For Buyer
		$url = 'api/user/buyerfreecontents';
		$resCuratedContents = sendRestRequest($url, $userData);
		$data['freecontents'] = $resCuratedContents['data'];


		
		// get offers
		$url = 'api/user/buyersofferrequested';
        $userDataOffer['page'] = 0;
        $userDataOffer['limit'] = 10;
        $userDataOffer['userId'] = $this->session->userdata('user_id');
		$sellerOffers = sendRestRequest($url, $userDataOffer);

		// wallet details
		$url = 'api/user/buyerswalletdetails';
        $userDataOffer['page'] = 0;
        $userDataOffer['limit'] = 10;
        $userDataOffer['userId'] = $this->session->userdata('user_id');
		$walletdetails = sendRestRequest($url, $userDataOffer);
		
		
		$data['walletdetails'] = $walletdetails['data'];

		$data['sellerOffers'] = $sellerOffers['data'];
		$data['sellerOffersStart'] = $userDataOffer['page'];
		$data['sellerOffersLimit'] = $userDataOffer['limit'];
		$slidetab = $this->session->flashdata('slidetab');
		$data['LogginUser'] = $this->session->userdata('user_id');
		


		if($slidetab>0)
		{
			$data['firstslide'] = 'N';
		}else{
			$data['firstslide'] = 'Y';
		}
		
		
		$header = $this->front_model->header();
		$header['site_settings']->site_title = 'Buyer Dashboard - '.$header['site_settings']->site_title;
        $footer = $this->front_model->footer();
		$this->load->view('user/includes/header',$header);
		$this->load->view('user/buyer-main-dashboard',$data);
		$this->load->view('user/includes/footer',$footer);
	}

	public function buyernotification(){
		$this->session->set_flashdata('slidetab', 8);
		redirect(base_url().'user/profile');  
	}



	public function load_more_seller_reply(){
		$userDataPost = $this->input->post();
		$url = 'api/user/sellerfaq';
        $userData['page'] = $userDataPost['start'];
        $userData['limit'] = $userDataPost['limit'];
        $userData['userId'] = $this->session->userdata('user_id');
		$resFAQ = sendRestRequest($url, $userData);
		$resFAQ['token'] = $this->security->get_csrf_hash();
		header('Content-Type: application/json');
    	echo json_encode($resFAQ);
	}

	public function load_more_seller_offer()
	{
		$userDataPost = $this->input->post();
		$url = 'api/user/sellergetoffers';
        $userData['page'] = $userDataPost['start'];
        $userData['limit'] = $userDataPost['limit'];
        $userData['userId'] = $this->session->userdata('user_id');
		$resFAQ = sendRestRequest($url, $userData);
		$resFAQ['token'] = $this->security->get_csrf_hash();
		header('Content-Type: application/json');
    	echo json_encode($resFAQ);
	}

	public function load_more_buyer_offer()
	{
		$userDataPost = $this->input->post();
		$url = 'api/user/buyersofferrequested';
        $userData['page'] = $userDataPost['start'];
        $userData['limit'] = $userDataPost['limit'];
        $userData['userId'] = $this->session->userdata('user_id');
		$resFAQ = sendRestRequest($url, $userData);
		$resFAQ['token'] = $this->security->get_csrf_hash();
		header('Content-Type: application/json');
    	echo json_encode($resFAQ);
	}

	public function approveOffer($id)
	{
		$url = 'api/user/approveoffer';
		$userDataPost = $this->input->post();
		$userDataPost['clientId'] = $this->session->userdata('user_id');
		$userDataPost['offerId'] = $id;
		$res = sendRestRequest($url, $userDataPost);
		
		if($res['status'] == true)
		{
			$this->session->set_flashdata('successoffer', $res['message']);
			$this->session->set_flashdata('slidetab', 2);
		}else{
			$this->session->set_flashdata('failedoffer', $res['message']);
			$this->session->set_flashdata('slidetab', 2);
		}
		redirect(base_url().'user/sell');    
	}
	public function rejectOffer($id)
	{
		$url = 'api/user/rejectoffer';
		$userDataPost = $this->input->post();
		$userDataPost['clientId'] = $this->session->userdata('user_id');
		$userDataPost['offerId'] = $id;
		$res = sendRestRequest($url, $userDataPost);
		
		if($res['status'] == true)
		{
			$this->session->set_flashdata('successoffer', $res['message']);
			$this->session->set_flashdata('slidetab', 2);
		}else{
			$this->session->set_flashdata('failedoffer', $res['message']);
			$this->session->set_flashdata('slidetab', 2);
		}
		redirect(base_url().'user/sell');    
	}


	public function seller_faq_reply(){
			
		$url = 'api/user/sellerfaqreply';
		$userDataPost = $this->input->post();
		$userDataPost['userId'] = $this->session->userdata('user_id');
		$res = sendRestRequest($url, $userDataPost);

		if($res['status'] == true)
		{
			$data = array(
				'successfaq' => $res['message'],
				'errorCode'=>0,
				'dataval' => ['token'=>$this->security->get_csrf_hash(),'ret'=>$res['data']],
				'faqseller' =>true,
			);
		}else{
			$data = array(
				'errorfaq' => $res['message'],
				'errorCode'=>1,
				'dataval' => ['token'=>$this->security->get_csrf_hash(),'ret'=>$res['data']],
				'faqseller' =>true,
			);
			//$this->session->set_flashdata($data);
			//redirect(base_url().'user');
		}
		
		header('Content-Type: application/json');
    	echo json_encode($data);
	}

	public function buyer_faq(){
			
		$url = 'api/user/buyerfaq';
		$userDataPost = $this->input->post();
		//$userDataPost1['page']=$userDataPost['start'];
		//$userDataPost1['limit']=$userDataPost['limit'];
		$userDataPost['userId'] = $this->session->userdata('user_id');
		$res = sendRestRequest($url, $userDataPost);
		if($res['status'] == true)
		{
			$data = array(
				'successfaq' => $res['message'],
				'errorCode'=>0,
				'dataval' => ['token'=>$this->security->get_csrf_hash(),'ret'=>$res['data']],
				'faqseller' =>true,
			);
		}else{
			$data = array(
				'errorfaq' => $res['message'],
				'errorCode'=>1,
				'dataval' => ['token'=>$this->security->get_csrf_hash(),'ret'=>$res['data']],
				'faqseller' =>true,
			);
			//$this->session->set_flashdata($data);
			//redirect(base_url().'user');
		}
		
		header('Content-Type: application/json');
    	echo json_encode($data);
	}




	
	public function businesssuccesspayment(){
		
		/*
		$url = 'api/data/sellrequestfinal';
		$userDataPost = $this->input->post();
		$userDataPost['clientId'] = $this->session->userdata('user_id');
		$res = sendRestRequest($url, $userDataPost);
		if($res['status'] === false)
		{
			redirect(base_url().'user/sell-your-business');
		}
		*/

		$header = $this->front_model->header();
        $footer = $this->front_model->footer();
		$data['listing_id'] = $res['data']['listing_id'];
		$this->load->view('user/includes/header',$header);
		$this->load->view('user/success-sell-business',$data);
		$this->load->view('user/includes/footer',$footer);
	}

	public function userProfile(){
		$url = 'api/data/getprofile';
		//$userDataPost = $this->input->post();
		$userDataPost['userId'] = $this->session->userdata('user_id');
		$res = sendRestRequest($url, $userDataPost);
		/*pre($res);
		exit();*/
		
		$identity_proof_doc = json_decode($res['data']['identity_proof_doc'],true);
		
		
		$data['fieldData']= $res['data'];
		$data['fieldData']['usernameoffline']= $res['data']['fname'];
		$data['fieldData']['doboffline']= $res['data']['dob'];
		$data['fieldData']['verificationType']= $identity_proof_doc['type'];
		$data['fieldData']['IdentrityProof']= $identity_proof_doc['identrity_proof'];
		$data['fieldData']['IdentrityProofNumber']= $identity_proof_doc['identrity_proof_number'];
		$data['fieldData']['IdentrityProofexpdate']= $identity_proof_doc['identrity_proof_exp_date'];
		$data['userDetails'] = $res['data'];
		$data['listing_id'] = $res['data']['listing_id'];

		$data['digiSign'] = $res['digiSign'];
		
		$url = 'api/marketplace/listinguserpermission';
        $userDatalistingpermission['listingId'] = 'Profileshow';
        $userDatalistingpermission['user'] = $this->session->userdata('user_id');

        $res = sendRestRequest($url, $userDatalistingpermission);
		$data['permission']= $res['data'];
		
		$slidetab = $this->session->flashdata('slidetab');
		if($slidetab>0)
		{
			$data['firstslide'] = 'N';
		}else{
			$data['firstslide'] = 'Y';
		}
		// get notifications
		$url = 'api/user/getnotifications';
        $userDataOffer['page'] = 0;
        $userDataOffer['limit'] = 15;
        $userDataOffer['userId'] = $this->session->userdata('user_id');
		$data['notifications'] = sendRestRequest($url, $userDataOffer);
		//print '<pre>';
		//print_r($data);
		$data['sellerOffersStart'] = $userDataOffer['page'];
		$data['sellerOffersLimit'] = $userDataOffer['limit'];

		/*pre($data);
		exit();*/

		$header = $this->front_model->header();
        $footer = $this->front_model->footer();
		$this->load->view('user/includes/header',$header);
		$this->load->view('user/user-profile',$data);
		$this->load->view('user/includes/footer',$footer);
	}

	public function userProfileUpdate(){

		$url = 'api/data/updateprofile';
		$userDataPost = $this->input->post();
		
		$userDataPost['clientId'] = $this->session->userdata('user_id');
		$res = sendRestRequest($url, $userDataPost);

		if($res['status'])
		{
			$this->session->set_flashdata('successprofileupdate', $res['data']);
		}else{
			$this->session->set_flashdata('failedprofileupdate', $res['message']);
			$this->session->set_flashdata('dataval', $res['data']);
		}
		redirect(base_url().'user/profile');  
	}
	public function update_user_password()
    {
		$url = 'api/data/updatepassword';
		$userDataPost = $this->input->post();
		$userDataPost['user_id'] = $this->session->userdata('user_id');
		
		$res = sendRestRequest($url, $userDataPost);

		
		if($res['status'] == true)
		{
			$this->session->set_flashdata('successchangepassword', $res['message']);
			$this->session->set_flashdata('slidetab', 3);
		}else{
			$this->session->set_flashdata('failedchangepassword', $res['message']);
			$this->session->set_flashdata('slidetab', 3);
		}
		redirect(base_url().'user/profile');    

	}

	public function update_user_photo(){
		if(!empty($_FILES['profilePic']['name'])){
			$filecontent = file_get_contents($_FILES['profilePic']['tmp_name']); 
		}
		$filename = $_FILES['profilePic']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$extentionarr = ['gif','png','jpg','jpeg'];
		if (!in_array($ext,$extentionarr)) {
			$this->session->set_flashdata('errorprofilepicture', 'Please select an image to update profile picture.');
			redirect(base_url().'user/profile'); 
			die; 
		}
		$url = 'api/data/updateuserpicture';
		$userDataPost = $this->input->post();
		$userDataPost['user_id'] = $this->session->userdata('user_id');
		$userDataPost['imageContent'] = base64_encode($filecontent);
		$res = sendRestRequest($url, $userDataPost);
		
		$this->session->set_flashdata('successprofilepicture', $res['message']);
		redirect(base_url().'user/profile'); 
	}

	public function verifyIdentityaction(){
		
		$url = 'api/data/userverification';
		$userDataPost = $this->input->post();
		$userDataPost['user_id'] = $this->session->userdata('user_id');
		$res = sendRestRequest($url, $userDataPost);
		
		$redirectto = $this->input->get('redirect_to');
		
		if($res['status'] == true)
		{
			if($redirectto == 'user/buyer')
			{
				$this->session->set_flashdata('successwithdraw', $res['message']);
				$this->session->set_flashdata('slidetab', 7);
			}else{
				$this->session->set_flashdata('successuserverify', $res['message']);
				$this->session->set_flashdata('slidetab', 2);
			}
			
		}else{
			if($redirectto == 'user/buyer')
			{
				$this->session->set_flashdata('failedwithdraw', $res['message']);
				$this->session->set_flashdata('slidetab', 7);
			}else{
				$this->session->set_flashdata('faileduserverify', $res['message']);
				$this->session->set_flashdata('slidetab', 2);
				$this->session->set_flashdata('dataval', $res['data']);
			}
			
		}
		
		if($redirectto!='')
		{
			redirect(base_url().$redirectto);
		}else{
			redirect(base_url().'user/profile');
		}
		
	}

	public function createlinktoken(){

        $url = PLAID_URL.'/link/token/create';
        /*$userData = [
            "client_id"=>PLAID_CLIENT_ID,
            "secret"=>PLAID_CLIENT_SECRET,
            'client_name'=>PLAID_CLIENT_NAME,
            "user"=> [
                "client_user_id"=>$this->session->userdata('user_id')
            ],
            "products"=>["assets"],
            "country_codes"=>["US"],
            "language"=>"en",
            "webhook"=>PLAID_WEBHOOK
        ];*/
		$userData = [
            "client_id"=>PLAID_CLIENT_ID,
            "secret"=>PLAID_CLIENT_SECRET,
            'client_name'=>PLAID_CLIENT_NAME,
            "user"=> [
                "client_user_id"=>$this->session->userdata('user_id')
            ],
            "products"=>['auth', 'transactions'],
            "country_codes"=>["US"],
            "language"=>"en"
        ];

		
        // Create a new cURL resource
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
            ));
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . $apiKey));
        //curl_setopt($ch, CURLOPT_USERPWD, "$apiUser:$apiPass");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($userData));
        $result = curl_exec($ch);
        curl_close($ch);
		
        header('Content-Type: application/json');
    	echo $result;
	}
	
	public function plaidgetaccesstoken(){
        $userData = $this->input->post();
        $public_token = $userData['public_token'];
        $url = PLAID_URL.'/item/public_token/exchange';
        // User account info
        //$userData = $this->input->post();
        $userData = [
            "client_id"=>PLAID_CLIENT_ID,
            "secret"=>PLAID_CLIENT_SECRET,
            "public_token"=>$public_token
        ];
        // Create a new cURL resource
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
            ));
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . $apiKey));
        //curl_setopt($ch, CURLOPT_USERPWD, "$apiUser:$apiPass");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($userData));
        $result = curl_exec($ch);
        curl_close($ch);
        header('Content-Type: application/json');
    	echo $result;
	}
	
	public function submitUserFundProof(){
		if(!empty($_FILES['file']['name'])){
			$filecontent = file_get_contents($_FILES['file']['tmp_name']); 
		}
		$filename = $_FILES['file']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		
		$url = 'api/data/updateuserfundproof';
		$userDataPost = $this->input->post();
		$userDataPost['user_id'] = $this->session->userdata('user_id');
		$userDataPost['imageContent'] = base64_encode($filecontent);
		$userDataPost['fileExtention'] = $ext;
		$res = sendRestRequest($url, $userDataPost);
	}
	public function submitUserIdentityProof(){
		if(!empty($_FILES['file']['name'])){
			$filecontent = file_get_contents($_FILES['file']['tmp_name']); 
		}
		$filename = $_FILES['file']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		
		$url = 'api/data/updateuserindefyproof';
		$userDataPost = $this->input->post();
		$userDataPost['user_id'] = $this->session->userdata('user_id');
		$userDataPost['imageContent'] = base64_encode($filecontent);
		$userDataPost['fileExtention'] = $ext;
		$res = sendRestRequest($url, $userDataPost);

	}

	public function uploadDigitalSignature(){
		if(!empty($_FILES['upload_digital_signature']['name'])){
			$filecontent = file_get_contents($_FILES['upload_digital_signature']['tmp_name']); 
		}
		$filename = $_FILES['upload_digital_signature']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		
		$url = 'api/data/updateuserdigitalsignature';
		$userDataPost = $this->input->post();
		$userDataPost['user_id'] = $this->session->userdata('user_id');
		$userDataPost['imageContent'] = base64_encode($filecontent);
		$userDataPost['fileExtention'] = $ext;
		$res = sendRestRequest($url, $userDataPost);

		header('Content-Type: application/json');
    	echo json_encode($res);
	}
	

	public function proofoffundaction(){

		$url = 'api/data/proofoffund';
		$userData = $this->input->post();
		$userDataPost['user_id'] = $this->session->userdata('user_id');
		$userDataPost['proof'] = json_encode($userData['proof']);
		$userDataPost['verificationTypeFund'] = $userData['verificationTypeFund'];
		$userDataPost['accesstokens'] = $userData['accesstokens'];
		$res = sendRestRequest($url, $userDataPost);
		
		if($res['status'] == true)
		{
			$this->session->set_flashdata('successproofupload', $res['message']);
			$this->session->set_flashdata('slidetab', 2);
		}else{
			$this->session->set_flashdata('failedproofupload', $res['message']);
			$this->session->set_flashdata('slidetab', 2);
			$this->session->set_flashdata('dataval', $userData);
		}
		$redirectto = $this->input->get('redirect_to');
		if($redirectto!='')
		{
			redirect(base_url().$redirectto);
		}else{
			redirect(base_url().'user/profile');
		}

	}
	public function proofoffundactiononline(){

		$url = 'api/data/proofoffund';
		$userData = $this->input->post();
		$userDataPost['user_id'] = $this->session->userdata('user_id');
		$userDataPost['proof'] = json_encode($userData['proof']);
		$userDataPost['verificationTypeFund'] = $userData['verificationTypeFund'];
		$userDataPost['accesstokens'] = $userData['accesstokens'];
		$res = sendRestRequest($url, $userDataPost);
		
		header('Content-Type: application/json');
    	echo json_encode($res);

	}

	public function verificationtab(){
		$this->session->set_flashdata('slidetab', 2);
		redirect(base_url().'user/profile');
	}
	public function reverifyfund(){

		$url = 'api/data/reverifyproofoffund';
		$userData = $this->input->post();
		
		$userDataPost['user_id'] = $this->session->userdata('user_id');
		$res = sendRestRequest($url, $userDataPost);
		
		if($res['status'] == true)
		{
			//$this->session->set_flashdata('successproofupload', $res['message']);
			$this->session->set_flashdata('slidetab', 2);
		}else{
			$this->session->set_flashdata('failedproofupload', $res['message']);
			$this->session->set_flashdata('slidetab', 2);
			$this->session->set_flashdata('dataval', $userData);
		}
		$redirectto = $this->input->get('redirect_to');
		if($redirectto!='')
		{
			redirect(base_url().$redirectto);
		}else{
			redirect(base_url().'user/profile');
		}
	}
	public function verifyfundprofile(){

		$this->session->set_flashdata('slidetab', 2);
		redirect(base_url().'user/profile');
		
	}
	
	public function seller_cureted_content(){
		$header = $this->front_model->header();
		$footer = $this->front_model->footer();
		$url = 'api/data/get_curated_contents';
		$userData = $this->input->post();
		$userDataPost['start'] = 0;
		$userDataPost['limit'] = 2;
		$res = sendRestRequest($url, $userDataPost);
		
		$data['contentdetails'] = $res['data'];

		$this->load->view('user/includes/header',$header);
		$this->load->view('user/seller-cureted-content',$data);
		$this->load->view('user/includes/footer',$footer);
	}
	
	public function individual_seller_cureted_content($slug){
		$header = $this->front_model->header();
		$footer = $this->front_model->footer();
		//$curatedcontents = 
		$url = 'api/data/individual_curated_content';
		$userData = $this->input->post();
		
		$userDataPost['content_slug'] = $slug;
		$res = sendRestRequest($url, $userDataPost);
			
		$data['contentdetails'] = $res['data'];
		$this->load->view('user/includes/header',$header);
		$this->load->view('user/individual-seller-cureted-content',$data);
		$this->load->view('user/includes/footer',$footer);
	}

	
	public function loadmoreUserNotification(){
		// get notifications
		$postData = $this->input->post();
		$url = 'api/user/getnotifications';
        $userDataOffer['page'] = $postData['page'];
        $userDataOffer['limit'] = $postData['limit'];
        $userDataOffer['userId'] = $this->session->userdata('user_id');
		$notifications = sendRestRequest($url, $userDataOffer);
		$notifications['token'] = $this->security->get_csrf_hash();
		header('Content-Type: application/json');
    	echo json_encode($notifications);
	}
	public function removeUserNotification($id){
		$url = 'api/user/delnotifications';
        $userDataOffer['id'] = $id;
        $userDataOffer['userId'] = $this->session->userdata('user_id');
		$notifications = sendRestRequest($url, $userDataOffer);
		$notifications['token'] = $this->security->get_csrf_hash();
		header('Content-Type: application/json');
    	echo json_encode($notifications);
	}

	public function countUserNotification(){
		$countnotification = $this->front_model->countnotification();
		header('Content-Type: application/json');
    	echo json_encode($countnotification);
	}

	public function getfreevaluation(){
		$header = $this->front_model->header();
		$footer = $this->front_model->footer();
		
		$this->load->view('user/includes/header',$header);
		$this->load->view('user/individual-seller-cureted-content',$data);
		$this->load->view('user/includes/footer',$footer);
	}
	public function scheduledcalls(){
		$header = $this->front_model->header();
		$header['site_settings']->site_title = 'Schedule Call - '.$header['site_settings']->site_title;
        $footer = $this->front_model->footer();
		/*$res = sendRestRequest($url, $userDatalistingpermission);
		$proof= $res['data'];
		if(!$proof['isidentityproofed'])
		{
			$this->session->set_flashdata('slidetab', 2);
			redirect(base_url().'user/profile');  
		}*/

		$url = 'api/data/getprofile';
		$userDataPost['userId'] = $this->session->userdata('user_id');
		$resProfile = sendRestRequest($url, $userDataPost);
		$data['userProfileData'] = $resProfile['data'];
		
		/*$url = 'api/data/getcallloghistory';
		$userDataPost['userId'] = $this->session->userdata('user_id');
		$resLogHistory = sendRestRequest($url, $userDataPost);
		$data['userCallLog'] = $resLogHistory['data'];*/

        
        $this->load->view('user/includes/header',$header);
		$this->load->view('frontend/call-list',$data);
		$this->load->view('user/includes/footer',$footer);
	}

	public function scheduledcallsAction(){

		$draw = $_POST['draw'];
        $data['start'] = $_POST['start'] = 0;
		$data['limit'] = $_POST['length'] = 10;
        $data['searchValue'] = $_POST['searchName'];
		$data['searchTimeSchedulecall'] = $_POST['searchTimeSchedulecall'];
		$data['searchStatus'] = $_POST['searchByStatus'];
		$data['user'] = $this->session->userdata('user_id');
		
        $callrequests = $this->admin_model->getcalllog($data);
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
				$datares['phone'] = $v['user_phone'];
				$datares['scheduledtime'] = date('jS M Y @ h:i a',strtotime($v['call_time']));
				$datares['note'] = mb_strimwidth($v['note'], 0, 70, '...');
				$datares['enqiry_type'] = $v['enqiry_type'];
				
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

	public function createTicket()
    {
        $header = $this->front_model->header();
        $footer = $this->front_model->footer();
		$url = 'api/marketplace/listinguserpermission';
        $userDatalistingpermission['listingId'] = 'Profileshow';
        $userDatalistingpermission['user'] = $this->session->userdata('user_id');

        $res = sendRestRequest($url, $userDatalistingpermission);
		$proof= $res['data'];
		if(!$proof['isidentityproofed'])
		{
			$this->session->set_flashdata('slidetab', 2);
			redirect(base_url().'user/profile');  
		}
        /*$url = 'api/user/sellercuratedcontents';
		$userDataPost = $this->input->post();
        $userDataPost['clientId'] = $this->session->userdata('user_id');
        $userDataPost['page'] = 0;
        $userDataPost['limit'] = 10;
        $userDataPost['area'] = 'BUYER';
        $res = sendRestRequest($url, $userDataPost);*/
        //print '<pre>';
        //print_r($res);
        //die;
        $data['area'] = 'BUYER';
        $data['blogs'] = $res['data'];
        $data['blogLimit'] = $userDataPost['limit'];
        $data['blogStart'] = $userDataPost['start'];
		$header['site_settings']->site_title = 'Email Support - '.$header['site_settings']->site_title;
        $this->load->view('user/includes/header',$header);
		$this->load->view('frontend/ticket-create',$data);
		$this->load->view('frontend/includes/footer',$footer);
    }

    public function createTicketAction(){
        $url = 'api/user/createticketaction';
		$userDataPost = $this->input->post();
        $userDataPost['clientId'] = $this->session->userdata('user_id');
        $res = sendRestRequest($url, $userDataPost);
        
        if($res['status'])
        {
            $data = array(
                'success' => $res['message'],
                'errorCode'=>0,
                'dataval' => ''
            );
            $this->session->set_flashdata($data);
			//redirect(base_url().'ticket/create');
        }else{
            $data = array(
                'error' => $res['message'],
                'errorCode'=>1,
                'dataval' => $res['data']
            );
            $this->session->set_flashdata($data);
			
        }
        redirect(base_url().'ticket/create');
        //$res['token'] = $this->security->get_csrf_hash();
	}
	
	public function getSupportticketData(){
        $draw = $_POST['draw'];
        $data['start'] = $_POST['start'];
		$data['limit'] = $_POST['length'];
        $data['searchName'] = $_POST['searchName'];
		$data['searchByStatus'] = $_POST['searchByStatus'];
		
		$url = 'api/user/getsupportticketaction';
		$userDataPost = $this->input->post();
		$userDataPost['clientId'] = $this->session->userdata('user_id');
		
		$res = sendRestRequest($url, $userDataPost);
		$sellRequests = $res['data'];
		
		//print '<pre>';
		//print_r($sellRequests['record']);
		/*$sellRequests = $this->admin_model->gettickets($data);*/
		if(is_array($sellRequests['record']) && count($sellRequests['record'])>0)
		{
			$i = 0;
			foreach($sellRequests['record'] as $val){
				$status = $val['status'];
				if($status == 1)
				{
					$ticketStatus = 'Open';
				}elseif($status == 2)
				{
					$ticketStatus = 'Closed';
				}
				if($val['userId']>1)
				{
					$firstName = $val['fname'];
				}else{
					$firstName = $val['fname1'];
				}
				if($val['user_read'] == 'N')
				{
					$ticket[$i]['ticket_id'] = '<strong>'.$val['ticket_no'].'</strong>';
					$ticket[$i]['user'] = '<strong>'.$firstName.'</strong>';
					$ticket[$i]['subject'] = '<strong>'.$val['subject'].'</strong>';
					//$ticket[$i]['message'] = substr($val['message'],0,50).'...';
					$ticket[$i]['user_read'] = $val['user_read'];
					$ticket[$i]['ticketDate'] = '<strong>'.date('jS M Y',strtotime($val['date_added'])).'</strong>';
					$ticket[$i]['ticketStatus'] = '<strong>'.$ticketStatus.'</strong>';
				}else{
					$ticket[$i]['ticket_id'] = $val['ticket_no'];
					$ticket[$i]['user'] = $firstName;
					$ticket[$i]['subject'] = $val['subject'];
					$ticket[$i]['user_read'] = $val['user_read'];
					$ticket[$i]['ticketDate'] = date('jS M Y',strtotime($val['date_added']));
					$ticket[$i]['ticketStatus'] = $ticketStatus;
				}
				
				$ticket[$i]['action'] = '<a href="'.base_url().'user/ticket/details/'.$val['ticket_no'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
				$i++;
			}
		}else{
			$ticket = [];
		}
		
		//print_r($ticket);
		//die;
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $sellRequests['totalrecord']['totalrecord'],
            "recordsFiltered" => $sellRequests['totalrecord']['totalrecord'],
			"data" => $ticket,
			'postdata'=>$_POST,
			'res'=>$res,
			"token" => $this->security->get_csrf_hash()
			
        );
        echo json_encode($response);
	}

	public function submitbuywalletamountrequest(){
		
		$userData = $this->input->post();
        $url = 'api/marketplace/submitbuywallet';
		$userDataPost = $this->input->post();
        $userDataPost['user_id'] = $this->session->userdata('user_id');
		$res = sendRestRequest($url, $userDataPost);
		
        if($res['status'] == true)
        {
            /*$data = array(
                'successwalletamount' => ['Wallet Add money requested successfully. The amount is pendin for approval.'],
                'errorCode'=>1,
                'dataval' => '',
                'submitbuy' =>true,
				'slidetab' => 7
            );
            $this->session->set_flashdata($data);*/
			
			$this->session->set_flashdata('successwithdraw', 'Wallet Add money requested successfully. The amount is pending for approval.');
			$this->session->set_flashdata('slidetab', 7);
            //redirect(base_url().'listing/'.$userData['listingNo']);
        }else{
            /*$data = array(
                'errorwalletamount' => 'Some problem occured. Please try again.',
                'errorCode'=>1,
                'dataval' => $res['data'],
                'submitbuy' =>true,
				'slidetab' => 7
            );
            $this->session->set_flashdata($data);*/
			$this->session->set_flashdata('failedwithdraw', 'Some problem occured. Please try again.');
			$this->session->set_flashdata('slidetab', 7);
            
        }
		redirect(base_url().'user/buyer');
	}
	public function submitwalletwithdrawrequest(){
		$userData = $this->input->post();
		
        $url = 'api/marketplace/submitwithdrawwallet';
		$userDataPost = $this->input->post();
        $userDataPost['user_id'] = $this->session->userdata('user_id');
		$res = sendRestRequest($url, $userDataPost);
		
        if($res['status'] == true)
        {
			$this->session->set_flashdata('successwithdraw', $res['message']);
			$this->session->set_flashdata('slidetab', 7);
        }else{
			$this->session->set_flashdata('failedwithdraw', $res['message']);
			$this->session->set_flashdata('slidetab', 7);
            
        }
		redirect(base_url().'user/buyer');
	}

	public function getWalletData(){
		$userData = $this->input->post();
        $url = 'api/user/walletTransactionList';
		$userDataPost = $this->input->post();
        $userDataPost['user_id'] = $this->session->userdata('user_id');
		$res = sendRestRequest($url, $userDataPost);
		$dataArr = [];
        if(is_array($res['data']['record']) && count($res['data']['record'])>0)
        {
            
            $i = $data['start']+1;
            foreach($res['data']['record'] as $v)
            {
				$datares['sl_no'] = $i;
                $i++;
				$datares['transaction_ref'] = $v['transaction_ref'];
				$datares['date_added'] = date('jS F Y',strtotime($v['date_added']));
				$datares['wallet_amount'] = $res['data']['currency'][0]['symbol'].$v['wallet_amount'];
				if($v['section'] == 'WALLET')
				{
					$datares['type'] = 'Deposit (Cr.)';
				}elseif($v['section'] == 'WALLETWITHDRAW')
				{
					$datares['type'] = 'Withdrawal (Dr.)';
				}elseif($v['section'] == 'LISTING' && $v['payment_mode'] == 'WALLET')
				{
					$datares['type'] = 'Purchase (Dr.)';
				}elseif($v['section'] == 'LISTING' && $v['payment_mode'] == 'BOTH')
				{
					$datares['type'] = 'Purchase (Dr.)';
				}
				if($v['status'] == 1)
				$datares['buyStatus'] = 'Pending';
				elseif($v['status'] == 2)
				$datares['buyStatus'] = 'Approved';
				elseif($v['status'] == 3)
				$datares['buyStatus'] = 'Rejected';
				
				//$datares['action'] = '<a href="'.base_url().'administrator/wallet-addmoney-request/'.$v['id'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                $dataArr[] = $datares;
            }
		}
		$response = array(
            "draw" => intval($draw),
            "recordsTotal" => $res['data']['totalrecord']['totalrecord'],
            "recordsFiltered" => $res['data']['totalrecord']['totalrecord'],
			"data" => $dataArr,
			'postdata'=>$userDataPost,
			'res'=>$res,
			"token" => $this->security->get_csrf_hash()
			
        );
        echo json_encode($response);
	}
	
	public function checkSignatureUploaded(){
		$retData = [];
		$retData['csrfName'] = $this->security->get_csrf_token_name();
		$retData['csrfVal'] = $this->security->get_csrf_hash();
		$retData['ret'] = 0;
		$getDigiSign = $this->admin_model->getUserDigiSign($this->session->userdata('user_id'));
		if(count($getDigiSign) > 0){
			$retData['ret'] = 1;
		}
		echo json_encode($retData);
		exit();
	}
}