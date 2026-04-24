<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function __construct() 
	{
		parent::__construct();
		$this->load->library(array('form_validation', "upload"));
		//$this->load->library('facebook');
        $this->load->model('front_model');
        $this->load->model('admin_model');
        $this->load->model('user_model');
        $this->load->model('admin_cms_model');
        $this->load->helper(array('cookie', 'url')); 
        // Load Pagination library
        $this->load->library('pagination');

        $logincookie = get_cookie('remember_me_npb');
		
		if($logincookie!='' && !$this->session->userdata('isLoggedIn'))
		{
			$this->loginrememberme();
		}
    }

    public function loginrememberme(){
		$result = $this->front_model->userLoginoncookie(get_cookie('remember_me_npb'));
		
		if($result && $result->userId >0)
		{
			$sessionArray = array('userId'=>$result->userId,     
									'name'=>$result->name,
									'lastLogin'=> '',
									'isLoggedIn' => TRUE
            );
            $this->session->set_userdata('login_as_user','login_as_user');
			$this->session->set_userdata('user_id',$result->userId);
			$this->session->set_userdata($sessionArray);
		}
    }
    
    public function index($curPage=0)
	{
        
        //phpinfo();
        $header = $this->front_model->header();
        
        $footer = $this->front_model->footer();
        //print '<pre>';
        //print_r($footer);
        //die;
        $page = ($curPage>0) ? ($curPage - 1) : 0;
        $url = 'api/marketplace/mprecentlisting';
        $userData['page'] = $page;
        $userData['limit'] = 20;
        $userData['userId'] = $this->session->userdata('user_id');
        $res = sendRestRequest($url, $userData);
        $datarecent= $res['data'];
        
        $page = ($curPage>0) ? ($curPage - 1) : 0;
        $url = 'api/marketplace/mplisting';
        $userData['page'] = $page;
        $userData['limit'] = 20;
        $userData['detaillisting'] = false;
        //$userData['show_home'] = 'Y';
        $userData['userId'] = $this->session->userdata('user_id');
        $res = sendRestRequest($url, $userData);
        //$data= $res['data'];
        /*print '<pre>';
        print_r($res);
        die;
        */
        $datatotallisting = $res['data'];
        $dataPost['totalnumberoflisting'] = $datatotallisting['totalrecord']['totalrecord'];
        $dataPost['totalnumberofnewlisting'] = $datarecent['totalrecord']['totalrecord'];
        $config['base_url'] = base_url();
        $config['total_rows'] = $datarecent['totalrecord']['totalrecord'];
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
        $getListingDetails = $datarecent['listing'];
        $dataPost['recentBusiness'] = $getListingDetails;

        $url = 'api/data/monetization';
        //$userData['page'] = $page;
        //$userData['limit'] = 20;
        $resMonetization = sendRestRequest($url, $userData);
        $header['monetization'] = $resMonetization['data'];

        $url = 'api/data/partners';
        $partners = sendRestRequest($url, $userData);
        
        $dataPost['partners'] = $partners['data'];

        //blogs
		$url = 'api/data/blogs';
		$userDataPost = $this->input->post();
        $userDataPost['clientId'] = $this->session->userdata('user_id');
        $userDataPost['limit'] = 3;
        $userDataPost['start'] = 0;
        $resBlogs = sendRestRequest($url, $userDataPost);
        $dataPost['blogs'] = $resBlogs['data']['blog'];

        //testimonials
		$url = 'api/data/testimonials';
		$userDataPost = $this->input->post();
        $userDataPost['page'] = 0;
        $userDataPost['limit'] = 20;
        $restestimonials = sendRestRequest($url, $userDataPost);
        
        $dataPost['testimonial'] = $restestimonials['data'][0];

        //home contents
		$url = 'api/data/homecontents';
		$userDataPost = $this->input->post();
        $reshomecontents = sendRestRequest($url, $userDataPost);
        $dataPost['homecontents'] = $reshomecontents['data'];
        $dataPost['loggedIn'] = $this->session->userdata('user_id');
        $url = 'api/marketplace/selectmaxminrange';
        $resmaxmin = sendRestRequest($url, []);
        $header['maxmin'] = $resmaxmin['data'];
        $header['site_settings']->site_title = $header['site_settings']->site_title;
        $this->load->view('frontend/includes/header',$header);
        $this->load->view('frontend/home',$dataPost);
        $this->load->view('frontend/includes/footer',$footer);
    }
    public function opensrs(){
        // Note: Requires cURL library
        $TEST_MODE = true;

        $connection_options = [
            'live' => [
                'api_host_port' => 'https://rr-n1-tor.opensrs.net:55443',
                'api_key' => 'c6698f30b7f33a3aad733cf10fe6a5f5bbc7d13053b3fea5da73ae198bfaf7bc6dcaa87f5ebac8e01191768b1603ccf06cab9cab9c571c5d',
                'reseller_username' => 'fihcom'
            ],
            'test' => [
                'api_host_port' => 'https://horizon.opensrs.net:55443',
                'api_key' => 'c6698f30b7f33a3aad733cf10fe6a5f5bbc7d13053b3fea5da73ae198bfaf7bc6dcaa87f5ebac8e01191768b1603ccf06cab9cab9c571c5d',
                'reseller_username' => 'fihcom'
            ]
        ];

        if ($TEST_MODE) {
            $connection_details = $connection_options['test'];
        } else {
            $connection_details = $connection_options['live'];
        }

        $xml = "<<<EOD
        <?xml version='1.0' encoding='UTF-8' standalone='no' ?>
        <!DOCTYPE OPS_envelope SYSTEM 'ops.dtd'>
        <OPS_envelope>
        <header>
            <version>0.9</version>
        </header>
        <body>
        <data_block>
            <dt_assoc>
                <item key=\"protocol\">XCP</item>
                <item key=\"action\">LOOKUP</item>
                <item key=\"object\">DOMAIN</item>
                <item key=\"attributes\">
                <dt_assoc>
                        <item key=\"domain\">myfirstopensrsapitest.com</item>
                </dt_assoc>
                </item>
            </dt_assoc>
        </data_block>
        </body>
        </OPS_envelope> 
        EOD";

        $data = [
            'Content-Type:text/xml',
            'X-Username:' . $connection_details['reseller_username'],
            'X-Signature:' . md5(md5($xml . $connection_details['api_key']) .  $connection_details['api_key']),
        ];

        $ch = curl_init($connection_details['api_host_port']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $data);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

        //$response = curl_exec($ch);
        if( $response = curl_exec($ch) === false)
        {
            echo 'Curl error: ' . curl_error($ch);
        }
        else
        {
            echo 'Request as reseller: ' . $connection_details['reseller_username'] . "\n" .  $xml . "\n";

            echo "Response\n";
            echo $response . "\n";
        }

        
    }
    
    public function login(){
        $header = $this->front_model->header();
        $footer = $this->front_model->footer();
        $this->load->view('frontend/includes/inside-header',$header);
        $this->load->view('frontend/login');
        $this->load->view('frontend/includes/footer',$footer);
    }

    public function logout(){
        $user_data = $this->session->all_userdata();
		delete_cookie('remember_me_npb'); 
            foreach ($user_data as $key => $value) {
				$this->session->unset_userdata($key);
            }
        redirect(base_url());
    }

    public function listingDetails($listingNo)
    {
        $url = 'api/marketplace/listing';
        $userData['listingId'] = $listingNo;
        $userData['recomendedBusinessLoad'] = true;
        $userData['userId'] = $this->session->userdata('user_id');
        $res = sendRestRequest($url, $userData);
        
        $data= $res['data'];
       
        if($this->session->userdata('isLoggedIn'))
		{
            if($data['userId'] == $this->session->userdata('user_id'))
            {
                $respermission['data']['isunlocked'] = true;
                $respermission['data']['isidentityproofed'] = true;
                $respermission['data']['isfundproofed'] = true;
                $respermission['data']['isavailablefund'] = true;
                $respermission['data']['maxlistingprice'] = $data['price'];
            }else{
                $url = 'api/marketplace/listinguserpermission';
                $userDatalistingpermission['listingId'] = $listingNo;
                $userDatalistingpermission['user'] = $this->session->userdata('user_id');
                $userDatalistingpermission['buy_ref'] = 'Y';
                $respermission = sendRestRequest($url, $userDatalistingpermission);

                // wallet details
                $url = 'api/user/buyerswalletdetails';
                $userDataOffer['page'] = 0;
                $userDataOffer['limit'] = 10;
                $userDataOffer['userId'] = $this->session->userdata('user_id');
                $walletdetails = sendRestRequest($url, $userDataOffer);
                $data['wallet'] = $walletdetails['data'];
            }

            $data['permission']= $respermission['data'];
            /*print '<pre>';
            print_r($data['wallet']);
            die;*/
            /*$url = 'api/marketplace/listinguseroffers';
            $useroffer['listingId'] = $listingNo;
            $useroffer['user'] = $this->session->userdata('user_id');*/

            //$res = sendRestRequest($url, $userDatalistingpermission);
            $offers = $respermission['data']['offerdetails'];
            $offer_price = $offers['offer_price'];
            if($offer_price > 0)
            {
                $data['listing_price'] = $data['price'];
                $data['price'] = $offer_price;
                $data['offer_accepted'] = 'YES';

            }
            //$data['permission']= $res['data'];
            
        }
        
        $header = $this->front_model->header();
        $header['site_settings']->site_title = 'Listing #'.$listingNo.' - '.$header['site_settings']->site_title;
        $footer = $this->front_model->footer();
        $data['listingNo'] = $listingNo;
        $url = 'api/data/partners';
        $partners = sendRestRequest($url, $userData);
        
        $header['nocaption'] = true;
        $dataPost['partners'] = $partners['data'];
        
        $this->load->view('frontend/includes/mp-header',$header);
        $this->load->view('frontend/mp-sale-details',$data);
        $this->load->view('frontend/includes/footer',$footer);
    }

    public function listingUncover(){
        if($this->session->userdata('isLoggedIn'))
		{
            $userDataPost = $this->input->post();
            $url = 'api/marketplace/listinguserpermission';

            $userDatalistingpermission['listingId'] = $userDataPost['listingNo'];
            $userDatalistingpermission['user'] = $this->session->userdata('user_id');
            $res = sendRestRequest($url, $userDatalistingpermission);
            
            if($res['data']['isunlocked'] == false && $res['data']['isidentityproofed'] == true && $res['data']['isfundproofed'] == true && $res['data']['isavailablefund'] == true)
            {
                $url = 'api/marketplace/uncoverlisting';
                $uncover['unlocked_business'] = $userDataPost['listingNo'];
                $uncover['investor_pass'] = $res['data']['listing']['Investor_pass'];
                $uncover['userId'] = $this->session->userdata('user_id');
                $uncover['activity'] = 'UNCOVER';
                $uncoverres = sendRestRequest($url, $uncover);
            }
            //$data['permission']= $res['data'];
            
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function listingUncoverProcess($listingId){
        $data['listingid']=$listingId;
        $url = 'api/data/getprofile';
		//$userDataPost = $this->input->post();
		$userDataPost['userId'] = $this->session->userdata('user_id');
        $res = sendRestRequest($url, $userDataPost);
        
        $identity_proof_doc = json_decode($res['data']['identity_proof_doc'],true);
        
		$url = 'api/marketplace/listing';
        $userData['listingId'] = $listingId;
        $userData['recomendedBusinessLoad'] = false;
        $resListing = sendRestRequest($url, $userData);
        
        $data['listingDetails'] = $resListing['data'];
		$data['fieldData']= $res['data'];
		$data['fieldData']['usernameoffline']= $res['data']['fname'];
		$data['fieldData']['doboffline']= $res['data']['dob'];
		$data['fieldData']['verificationType']= $identity_proof_doc['type'];
		$data['fieldData']['IdentrityProof']= $identity_proof_doc['identrity_proof'];
		$data['fieldData']['IdentrityProofNumber']= $identity_proof_doc['identrity_proof_number'];
		$data['fieldData']['IdentrityProofexpdate']= $identity_proof_doc['identrity_proof_exp_date'];
		$data['userDetails'] = $res['data'];
		$data['listing_id'] = $res['data']['listing_id'];
		if($this->session->userdata('isLoggedIn'))
		{
            $url = 'api/marketplace/listinguserpermission';
            $userDatalistingpermission['listingId'] = $listingId;
            $userDatalistingpermission['user'] = $this->session->userdata('user_id');
            $userDatalistingpermission['section'] = 'unlock';
            $res = sendRestRequest($url, $userDatalistingpermission);
            $data['permission']= $res['data'];
            
            if($res['data']['isunlocked'] == true && $res['data']['isidentityproofed'] == true && $res['data']['isfundproofed'] == true && $res['data']['isavailablefund'] == true)
            {
                redirect(base_url().'listing/'.$listingId);
            }
            
        }

        $header = $this->front_model->header();
        $footer = $this->front_model->footer();

        $this->load->view('frontend/includes/inside-header',$header);
        $this->load->view('frontend/listing-uncover-process',$data);
        $this->load->view('frontend/includes/footer',$footer);
    }
    public function marketPlace($curPage=0)
    {
        $userData = $this->input->post();
        
        $page = ($curPage>0) ? ($curPage - 1) : 0;
        $limit = 20;
        $url = 'api/marketplace/mplisting';
        $userData['page'] = $page;
        $userData['limit'] = $limit;
        $userData['userId'] = $this->session->userdata('user_id');
        $userData['searchText'] = $this->input->get('searchText');
        $userData['Monitization'] = $this->input->get('Monitization');
        $userData['min'] = $this->input->get('min');
        $userData['max'] = $this->input->get('max');
        $res = sendRestRequest($url, $userData);
        

        $data= $res['data'];
        $config['base_url'] = base_url().'marketplace';
        $config['total_rows'] = $data['totalrecord']['totalrecord'];
        $config['per_page'] = $userData['limit'];
        $config['uri_segment'] = 2;
        $config['full_tag_open'] = '<div class="pagination_fg">';
        $config['full_tag_close'] = '</div>';
        $config['next_link'] = '&raquo;';
        $config['prev_link'] = '&laquo;';
        $config['cur_tag_open'] = '<a class="active">';
        $config['cur_tag_close'] = '</a>';
        $config['attributes'] = array('class' => 'pager');
        $config['use_page_numbers'] = TRUE;
        $config['last_link'] = FALSE;
        $config['reuse_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $getListingDetails = $data['listing'];
        /*print '<pre>';
        print_r($getListingDetails);
        die;*/

        $url = 'api/marketplace/selectmaxminrange';
        $resmaxmin = sendRestRequest($url, []);
        $dataPost['maxmin'] = $resmaxmin['data'];
        
        
        $dataPost['maxmin']['minPrice'] = ($dataPost['maxmin']['minPrice']>0)?floor($dataPost['maxmin']['minPrice']):0;
        $dataPost['maxmin']['maxPrice'] = ($dataPost['maxmin']['maxPrice']>0)?ceil($dataPost['maxmin']['maxPrice']):10000000;

        $dataPost['maxmin']['minProfit'] = ($dataPost['maxmin']['minProfit']>0)?floor($dataPost['maxmin']['minProfit']):0;
        $dataPost['maxmin']['maxProfit'] = ($dataPost['maxmin']['maxProfit']>0)?ceil($dataPost['maxmin']['maxProfit']):10000000;

        $dataPost['maxmin']['minRevenue'] = ($dataPost['maxmin']['minRevenue']>0)?floor($dataPost['maxmin']['minRevenue']):0;
        $dataPost['maxmin']['maxRevenue'] = ($dataPost['maxmin']['maxRevenue']>0)?ceil($dataPost['maxmin']['maxRevenue']):10000000;

        $dataPost['maxmin']['minMultiple'] = ($dataPost['maxmin']['minMultiple']>0)?floor($dataPost['maxmin']['minMultiple']):0;
        $dataPost['maxmin']['maxMultiple'] = ($dataPost['maxmin']['maxMultiple']>0)?ceil($dataPost['maxmin']['maxMultiple']):100;

        $dataPost['maxmin']['minTraffic'] = ($dataPost['maxmin']['minTraffic']>0)?floor($dataPost['maxmin']['minTraffic']):0;
        $dataPost['maxmin']['maxTraffic'] = ($dataPost['maxmin']['maxTraffic']>0)?ceil($dataPost['maxmin']['maxTraffic']):10000000;
        

        $dataPost['allMarketPaceDetails'] = $getListingDetails;
        $dataPost['allMarketPaceDetailsPagePosition'] = [$userData['page'],$userData['limit'],$data['totalrecord']['totalrecord']];
        $dataPost['links'] = $this->pagination->create_links();

        $url = 'api/data/monetization';
        $userData['page'] = $page;
        $userData['limit'] = $limit;
        $resMonetization = sendRestRequest($url, $userData);
        $dataPost['monetization'] = $resMonetization['data'];
        $dataPost['searchRec'] = $userData;
        
        $header = $this->front_model->header();
        $header['site_settings']->site_title = 'Online Business Marketplace - '.$header['site_settings']->site_title;
        $footer = $this->front_model->footer();
        $url = 'api/data/partners';
        $partners = sendRestRequest($url, $userData);
        $dataPost['partners'] = $partners['data'];
        $dataPost['loggedUser'] = $this->session->userdata('user_id');
        $dataPost['listingPage'] = $page;
        $dataPost['listingLimit'] = $userData['limit'];

        $url = 'api/data/testimonials';
		$userDataPost = $this->input->post();
        $userDataPost['page'] = 0;
        $userDataPost['limit'] = 20;
        $restestimonials = sendRestRequest($url, $userDataPost);
        
        $dataPost['testimonial'] = $restestimonials['data'][0];

        //home contents
		$url = 'api/data/homecontents';
		$userDataPost = $this->input->post();
        $reshomecontents = sendRestRequest($url, $userDataPost);
        $dataPost['homecontents'] = $reshomecontents['data'];

        /*print '<pre>';
        print_r($dataPost);
        die;*/

        $this->load->view('frontend/includes/mp-header',$header);
        $this->load->view('frontend/marketplace-details',$dataPost);
        $this->load->view('frontend/includes/footer',$footer);
    }
    public function load_more_faq(){
        if($this->session->userdata('user_id') > 0)
        {
            $userDataPost = $this->input->post();
            $url = 'api/marketplace/sellerfaq';
            $userData['page'] = $userDataPost['start'];
            $userData['limit'] = $userDataPost['limit'];
            $userData['listing_id'] = $userDataPost['listing_id'];
            $userData['Status'] = 2;
            $resFAQ = sendRestRequest($url, $userData);
            $resFAQ['token'] = $this->security->get_csrf_hash();
        }
		
		header('Content-Type: application/json');
    	echo json_encode($resFAQ);
    }
    
    public function listingAskQuestion(){
        if($this->session->userdata('isLoggedIn'))
		{
            $url = 'api/marketplace/listinguseraskaquestion';
            $userData = $this->input->post();
            $userData['user'] = $this->session->userdata('user_id');
            $res = sendRestRequest($url, $userData);
            
            //$data['permission']= $res['data'];
           
            if($res['status'] == true)
            {
                $data = array(
                    'successfaq' => $res['message'],
                    'errorCode'=>1,
                    'dataval' => '',
                    'faq' =>true,
                );
                $this->session->set_flashdata($data);
                redirect(base_url().'listing/'.$userData['listingNo']);
            }else{
                $data = array(
                    'errorfaq' => $res['message'],
                    'errorCode'=>1,
                    'dataval' => $res['data'],
                    'faq' =>true,
                );
                $this->session->set_flashdata($data);

                redirect(base_url().'listing/'.$userData['listingNo']);
            }
        }else{
            redirect(base_url().'login');
        }
    }

    public function submitoffers(){
        if($this->session->userdata('isLoggedIn'))
		{
            $url = 'api/marketplace/submitoffers';
            $userData = $this->input->post();
            $userData['user'] = $this->session->userdata('user_id');
            $res = sendRestRequest($url, $userData);
            
            //$data['permission']= $res['data'];
            
            if($res['status'] == true)
            {
                $data = array(
                    'successsubmitoffer' => $res['message'],
                    'errorCode'=>1,
                    'dataval' => '',
                    'submitoffer' =>true,
                );
                $this->session->set_flashdata($data);
                redirect(base_url().'listing/'.$userData['listingNo']);
            }else{
                $data = array(
                    'errorsubmitoffer' => $res['message'],
                    'errorCode'=>1,
                    'dataval' => $res['data'],
                    'submitoffer' =>true,
                );
                $this->session->set_flashdata($data);

                redirect(base_url().'listing/'.$userData['listingNo']);
            }
        }else{
            redirect(base_url().'login');
        }
    }

    public function buyRefImage(){
        if(!empty($_FILES['file']['name'])){
			$filecontent = file_get_contents($_FILES['file']['tmp_name']); 
		}
		$filename = $_FILES['file']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        
		$url = 'api/data/uploadbuyrefpicture';
		$userDataPost = $this->input->post();
        $userDataPost['user_id'] = $this->session->userdata('user_id');
        $userDataPost['fileextention'] = $ext;
		$userDataPost['fileContent'] = base64_encode($filecontent);
        $res = sendRestRequest($url, $userDataPost);
        header('Content-Type: application/json');
    	echo json_encode($res);
    }

    public function submitbuyrequest(){
        $userData = $this->input->post();
       
        $url = 'api/marketplace/submitbuy';
		$userDataPost = $this->input->post();
        $userDataPost['user_id'] = $this->session->userdata('user_id');
        $res = sendRestRequest($url, $userDataPost);
        //print '<pre>';
        //print_r($res);
        //die;
        if($res['status'] == true)
        {
            $data = array(
                'successbuyoffer' => $res['message'],
                'errorCode'=>1,
                'dataval' => '',
                'submitbuy' =>true,
            );
            $this->session->set_flashdata($data);
            redirect(base_url().'listing/'.$userData['listingNo']);
        }else{
            $data = array(
                'errorbuyoffer' => $res['message'],
                'errorCode'=>1,
                'dataval' => $res['data'],
                'submitbuy' =>true,
            );
            $this->session->set_flashdata($data);

            redirect(base_url().'listing/'.$userData['listingNo']);
        }
    }

    public function getfreevaluation(){
        if(!isset($_SESSION['listingId']))
        {
            $listingid = $this->session->session_id;
            $_SESSION['listingId'] = $listingid;
        }else{
            $listingid = $_SESSION['listingId'];
        }
        if($this->session->userdata('user_id') > 0)
        {
            $clientId = $this->session->userdata('user_id');
        }else
        {
            $clientId = 0;
        }
        $header = $this->front_model->header();
        $footer = $this->front_model->footer();
        
        $url = 'api/data/valuationtemprecord';
        $userDataPost = $this->input->post();
        
        $userDataPost['clientId'] = $clientId;
        $userDataPost['listingId'] = $listingid;
		$res = sendRestRequest($url, $userDataPost);
		
		$data['monetization'] = $res['data']['monetization'];
		
		$data['tempdata'] = json_decode($res['data']['tempdata']['data_json'],true);
        $data['sitesettings'] = $this->admin_model->getSiteSettings();
        
		$currencyID = $data['sitesettings']['currency'];
        $data['currency'] = $this->front_model->getSelectedCurreny($currencyID);
        $data['questions'] =$this->front_model->getValuationQuestions();
        $header['site_settings']->site_title = 'Get Appraised - '.$header['site_settings']->site_title;
        //print '<pre>';
        //print_r($data['tempdata']);
        //die;
        $this->load->view('frontend/includes/inside-header',$header);
        //$this->load->view('user/includes/header',$header);
		$this->load->view('frontend/get-free-valuation',$data);
		$this->load->view('user/includes/footer',$footer);
    }

    /*public function businessvaluationAction(){
        $header = $this->front_model->header();
        $footer = $this->front_model->footer();
        $this->load->view('user/includes/header',$header);
		$this->load->view('frontend/get-free-valuation-result',$data);
		$this->load->view('user/includes/footer',$footer);
    }*/

    public function valuationAction($listingid=''){
        //$userDataPost = $this->input->post();
        //$selectedMonitization = $userDataPost['monitizationValue'];
        if($listingid !='')
        {
            $status = 1;
        }else{
            $status = 0;
            if(!isset($_SESSION['listingId']))
            {
                $listingid = $this->session->session_id;
                $_SESSION['listingId'] = $listingid;
            }else{
                $listingid = $_SESSION['listingId'];
            }
        }
        
        //$listingid = 1620619241;
        //$status = 1;
        $url = 'api/data/valuationinputs';
        $userDataPost = $this->input->post();
        
        $userDataPost['listing_id'] = $listingid;
        $userDataPost['status'] = $status;
        if($this->session->userdata('user_id') >0)
        $clientId = $this->session->userdata('user_id');
        else
        $clientId = 0;
        //$clientId = 24;
        $userDataPost['clientId'] = $clientId;
        $data['clientId'] = $clientId;
        
        $resInput = sendRestRequest($url, $userDataPost);
        
        
        $data['inputDetails'] = $resInput['data'];
        //$businessstartdate = $resInput['data']['businessstartdate'];
        //$businessstartdateArr = explode('/',$businessstartdate);
        //$resInput['data']['businessstartdate'] = $businessstartdateArr[2].'-'.$businessstartdateArr[0].'-'.$businessstartdateArr[1];
       
        $header = $this->front_model->header();
        $footer = $this->front_model->footer();
        
        $url = 'api/data/valuationbusinesscalculation';
        $userDataPost = $resInput['data'];
        $userDataPost['clientId'] = $clientId;
        $userDataPost['listingid'] = $listingid;
        $userDataPost['questions'] = json_encode($userDataPost['q']);
         
        $res = sendRestRequest($url, $userDataPost);

        $url = 'api/data/getpreviouslusold';
        $soldDataPost = $this->input->post();
        $soldDataPost['monetization'] = $res['data'][3]['monetization'];
        $ressold = sendRestRequest($url, $soldDataPost);
        $data['soldlisting'] = $ressold['data'];

        $data['valuationdetails'] = $res['data'];
        
        $data['datainput'] = $userDataPost;     
        
        $this->load->view('frontend/includes/inside-header',$header);
		$this->load->view('frontend/get-free-valuation-result',$data);
		$this->load->view('user/includes/footer',$footer);
    }
    

    public function value_your_business_action(){
        if(!isset($_SESSION['listingId']))
        {
            $listingid = $this->session->session_id;
            $_SESSION['listingId'] = $listingid;
        }else{
            $listingid = $_SESSION['listingId'];
        }
        
		$url = 'api/data/update-value-your-business';
        $userDataPost = $this->input->post();
        if($this->session->userdata('user_id')>0)
        {
            $userId = $this->session->userdata('user_id');
        }else{
            $userId = 0;
        }

        $userDataPost['clientId'] = $userId;
        $userDataPost['listing_id'] = $listingid;
		$res = sendRestRequest($url, $userDataPost);
		
		$data['jsonsellbusiness'] = $res['data'];
		$arr = array('sellbusiness'=>$res['data'],'token'=>$this->security->get_csrf_hash());
		//$arr = array('sellbusiness'=>$userDataPost,'token'=>$this->security->get_csrf_hash());
		header('Content-Type: application/json');
		echo json_encode($arr);
	}

    public function blog(){
        $header = $this->front_model->header();
        $footer = $this->front_model->footer();
        
        $url = 'api/data/blogcategories';
		$userDataPost = $this->input->post();
		$userDataPost['clientId'] = $this->session->userdata('user_id');
        $res = sendRestRequest($url, $userDataPost);
        $data['blogcat'] = $res['data'];
        
        $url = 'api/data/blogs';
		$userDataPost = $this->input->post();
        $userDataPost['clientId'] = $this->session->userdata('user_id');
        $userDataPost['limit'] = 10;
        $userDataPost['start'] = 0;
        $res = sendRestRequest($url, $userDataPost);
        
        $data['blogs'] = $res['data'];
        $data['blogLimit'] = $userDataPost['limit'];
        $data['blogStart'] = $userDataPost['start'];
		$this->load->view('user/includes/header',$header);
		$this->load->view('frontend/blog',$data);
		$this->load->view('user/includes/footer',$footer);
    }
    
    public function blogCategory($slug){
        $header = $this->front_model->header();
        $footer = $this->front_model->footer();
        
        /*$url = 'api/data/blogcategories';
		$userDataPost = $this->input->post();
		$userDataPost['clientId'] = $this->session->userdata('user_id');
        $res = sendRestRequest($url, $userDataPost);
        $data['blogcat'] = $res['data'];
        */
        $url = 'api/data/blogcatpost';
		$userDataPost = $this->input->post();
        $userDataPost['clientId'] = $this->session->userdata('user_id');
        $userDataPost['limit'] = 10;
        $userDataPost['start'] = 0;
        $userDataPost['slug'] = $slug;
        $res = sendRestRequest($url, $userDataPost);
        
        $data['blogs'] = $res['data'];
        $data['slug'] = $slug;
        $data['blogLimit'] = $userDataPost['limit'];
        $data['blogStart'] = $userDataPost['start'];
		$this->load->view('user/includes/header',$header);
		$this->load->view('frontend/blog-category',$data);
		$this->load->view('user/includes/footer',$footer);
    }
    public function getblogCategory(){
        $url = 'api/data/blogcatpost';
		$userDataPost = $this->input->post();
        $userDataPost['clientId'] = $this->session->userdata('user_id');
        $res = sendRestRequest($url, $userDataPost);
        $res['token'] = $this->security->get_csrf_hash();
        header('Content-Type: application/json');
    	echo json_encode($res);
    }

    public function getblog(){
        $url = 'api/data/blogs';
		$userDataPost = $this->input->post();
        $userDataPost['clientId'] = $this->session->userdata('user_id');
        $res = sendRestRequest($url, $userDataPost);
        $res['token'] = $this->security->get_csrf_hash();
        header('Content-Type: application/json');
    	echo json_encode($res);
		
    }

    public function blogDetails($slug){
        $header = $this->front_model->header();
        $footer = $this->front_model->footer();
        //echo $slug;
        $url = 'api/data/blogdetails';
		$userDataPost = $this->input->post();
        $userDataPost['clientId'] = $this->session->userdata('user_id');
        $userDataPost['slug'] = $slug;
        $res = sendRestRequest($url, $userDataPost);
        
        $data['blogdescription'] = $res['data'];
        $this->load->view('user/includes/header',$header);
		$this->load->view('frontend/blog-details',$data);
		$this->load->view('user/includes/footer',$footer);
    }
    public function curatedDetails($slug){
        $header = $this->front_model->header();
        $footer = $this->front_model->footer();
        //echo $slug;
        $url = 'api/data/blogcurateddetails';
		$userDataPost = $this->input->post();
        $userDataPost['clientId'] = $this->session->userdata('user_id');
        $userDataPost['slug'] = $slug;
        $res = sendRestRequest($url, $userDataPost);
       
        $data['blogdescription'] = $res['data'];
        $this->load->view('user/includes/header',$header);
		$this->load->view('frontend/blog-curated-details',$data);
		$this->load->view('user/includes/footer',$footer);
    }

    public function curatedContentSeller(){
        $header = $this->front_model->header();
        $footer = $this->front_model->footer();
        $url = 'api/user/sellercuratedcontents';
		$userDataPost = $this->input->post();
        $userDataPost['clientId'] = $this->session->userdata('user_id');
        $userDataPost['page'] = 0;
        $userDataPost['limit'] = 10;
        $userDataPost['area'] = 'SELLER';
        $res = sendRestRequest($url, $userDataPost);
        //print '<pre>';
        //print_r($res);
        //die;
        $data['area'] = 'SELLER';
        $data['blogs'] = $res['data'];
        $data['blogLimit'] = $userDataPost['limit'];
        $data['blogStart'] = $userDataPost['start'];
        $this->load->view('user/includes/header',$header);
		$this->load->view('frontend/blog-curated-contents',$data);
		$this->load->view('user/includes/footer',$footer);
    }

    public function getcuratedContentSeller(){
        $url = 'api/user/sellercuratedcontents';
		$userDataPost = $this->input->post();
        $userDataPost['clientId'] = $this->session->userdata('user_id');
        $res = sendRestRequest($url, $userDataPost);
        $res['token'] = $this->security->get_csrf_hash();
        header('Content-Type: application/json');
    	echo json_encode($res);
		
    }
    
    public function curatedContentBuyer(){
        $header = $this->front_model->header();
        $footer = $this->front_model->footer();
        $url = 'api/user/sellercuratedcontents';
		$userDataPost = $this->input->post();
        $userDataPost['clientId'] = $this->session->userdata('user_id');
        $userDataPost['page'] = 0;
        $userDataPost['limit'] = 10;
        $userDataPost['area'] = 'BUYER';
        $res = sendRestRequest($url, $userDataPost);
        //print '<pre>';
        //print_r($res);
        //die;
        $data['area'] = 'BUYER';
        $data['blogs'] = $res['data'];
        $data['blogLimit'] = $userDataPost['limit'];
        $data['blogStart'] = $userDataPost['start'];
        $this->load->view('user/includes/header',$header);
		$this->load->view('frontend/blog-curated-contents',$data);
		$this->load->view('user/includes/footer',$footer);
    }

    public function getcuratedContentBuyer(){
        $url = 'api/user/sellercuratedcontents';
		$userDataPost = $this->input->post();
        $userDataPost['clientId'] = $this->session->userdata('user_id');
        $res = sendRestRequest($url, $userDataPost);
        $res['token'] = $this->security->get_csrf_hash();
        header('Content-Type: application/json');
    	echo json_encode($res);
		
    }

    public function howItWorks($section){
        $header = $this->front_model->header();
        $footer = $this->front_model->footer();

        $url = 'api/data/homecontents';
		$userDataPost = $this->input->post();
        $reshomecontents = sendRestRequest($url, $userDataPost);
        $data['homecontents'] = $reshomecontents['data'];
        // print '<pre>';
        // print_r($data['homecontents']);
        // die;
        $this->load->view('user/includes/header',$header);
		$this->load->view('frontend/how-it-works',$data);
		$this->load->view('user/includes/footer',$footer);
    }

    public function testimonials(){
        $header = $this->front_model->header();
        $header['site_settings']->site_title = 'Testimonials - '.$header['site_settings']->site_title;
        $footer = $this->front_model->footer();

        $url = 'api/data/testimonials';
		$userDataPost = $this->input->post();
        $userDataPost['page'] = 0;
        $userDataPost['limit'] = 20;
        $restestimonials = sendRestRequest($url, $userDataPost);
        $data['testimonial'] = $restestimonials['data'][0];
        $data['totalrecord'] = $restestimonials['data'][1];
        $data['page'] = $userDataPost['page'];
        $data['limit'] = $userDataPost['limit'];
        // print '<pre>';
        // print_r($data['testimonial']);
        // die;
        //$this->load->view('user/includes/header',$header);
        $this->load->view('frontend/includes/inside-header',$header);
		$this->load->view('frontend/testimonials',$data);
		$this->load->view('user/includes/footer',$footer);
    }
    public function testimonialsData(){
        
        $url = 'api/data/testimonials';
		$userDataPost = $this->input->post();
        $restestimonials = sendRestRequest($url, $userDataPost);
        $data['testimonial'] = $restestimonials['data'][0];
        $data['totalrecord'] = $restestimonials['data'][1];
        $data['page'] = $userDataPost['page'];
        $data['limit'] = $userDataPost['limit'];
        $data['token'] = $this->security->get_csrf_hash();
        header('Content-Type: application/json');
    	echo json_encode($data);
    }
    
    //plaid-----------------------------------------------------------------------------------------
    
    public function plaidgetassetrequest(){
        $url = 'https://sandbox.plaid.com/asset_report/get';
        // User account info
        //$userData = $this->input->post();
        $userData = [
            "client_id"=>"5fac02f2ff7ece00122ba94b",
            "secret"=>"494a6512ba52fb478f3a153274f906",
            'asset_report_token'=>'assets-sandbox-e47d702b-3395-4da6-91f9-d9ecc6b442cd',
            "include_insights"=> false,
            
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

    /*public function plaidwebhook(){
        $data = file_get_contents("php://input");
        
        $jsonData=json_decode($data,true);
        $reqId = $jsonData['asset_report_id'];
        $this->db->select('h.*', FALSE);
        $this->db->from(TABLE_PREFIX.'user_details as h', FALSE);
        $this->db->like('h.fund_request_id', $reqId,'both');
        $this->db->limit(1);
        $query = $this->db->get();        
        $userDetails = $query->row();
        $FundJsonstr =  $userDetails->proof_funds;
        $fundProofArr = json_decode($FundJsonstr,true);
        $sendEmail = sendEmail('surajit@eclick.co.in', 'webhook url', 'This is test');
        print '<pre>';
        print_r($fundProofArr);
        die;
        if($fundProofArr['mode'] == 'online')
		{
			$asset_report_tokens = $fundProofArr['asset_report_tokens'];
			
			if(is_array($asset_report_tokens) && count($asset_report_tokens)>0)
			{
				foreach($asset_report_tokens as $v)
				{
					$fundHistory = $this->admin_model->getfundhistory($userDetails->userId,$v);
					
					if($fundHistory->id >0)
					{
						$arr = json_decode($fundHistory->fund_details,true);
					}else{
						$url = PLAID_URL.'/asset_report/get';
						// User account info
						//$userData = $this->input->post();
						$userData = [
							"client_id"=>PLAID_CLIENT_ID,
							"secret"=>PLAID_CLIENT_SECRET,
							'asset_report_token'=>$v,
							"include_insights"=> false,
							
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
						$arr = json_decode($result,true);

						$arrData['userId'] = $userDetails->userId;
						$arrData['asset_token'] = $v;
						$arrData['fund_details'] = $result;
                        $arrData['date_added'] = date('Y-m-d H:i:s');
                        $this->admin_model->setfundhistory($arrData);
						//$this->db->insert(TABLE_PREFIX.'fund_history', $arrData);
                    }
                    
					
					$resultArr[] = $arr;
                }
                
                if(is_array($resultArr) && count($resultArr)>0)
                {
                    foreach($resultArr as $k=>$vBank)
                    {
                        $bankItems = $vBank['report']['items'];
                        if(is_array($bankItems) && count($bankItems)>0)
                        {
                            foreach($bankItems as $k=>$v)
                            {
                                $totalFortheBank = 0;
                                if(is_array($v['accounts']) && count($v['accounts'])>0)
                                {
                                    foreach($v['accounts'] as $bankAcct)
                                    {
                                        $AvailableBal = $bankAcct['balances']['available'];
                                        if($bankAcct['balances']['available'])
                                        {
                                            $totalFortheBank = $totalFortheBank+$bankAcct['balances']['available'];
                                        }
                                    }
                                    $totalAsset = $totalAsset+$totalFortheBank;
                                }
                            }
                        }
                    }
                }

			}
        }
        
        $userId = $userDetails->userId;
        $userWalletBalance = $this->front_model->getwalletBalance($userId);
		//$totalAsset = $this->input->post('totalAsset');
		$curDate = date('Y-m-d H:i:s');
		$arruser['userId'] = $userId;
		$arruser['fund_proof_approve_date'] = $curDate;
		$arruser['proof_fund_status'] = 1;
		$arruser['fund_approved_amount'] = $totalAsset+$userWalletBalance;
		//$randomstring = strtoupper(substr(str_shuffle(RANDOM_CHAR), 0, 10));
		$randomstring = $this->front_model->setinvestorpassref();
		$arruser['Investor_pass'] = $randomstring;
		$result = $this->user_model->updateuserdetails($arruser);

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
					$result = $this->admin_model->updatefundapprovehistory($arrHistory1);
				}
			}
        }
        $userDetails = $this->front_model->getAdminDetails($userId);
        $user_to = $userDetails['mail'];
        $user_subject = 'Your proof of funds request has been approved - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$userDetails['fname'].'</strong></h6>
        <br><br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Good news! Your proof of funds has been reviewed &amp; approved. You can now view businesses up to &amp; slightly above the total amount of
        assets verified.</p>
        <br>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);

        $notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $userId;
        $notificationarr['notification_text'] = 'Your fund proof request is approved.';
        $notificationarr['notification_type'] = 'FUNDAPPROVE';
        $notificationarr['notification_type_id'] = $this->input->post('CallId');
        $this->front_model->insertnotification($notificationarr);
    }*/
    public function plaidwebhook(){
        /*$data = file_get_contents("php://input");
        ob_start();
        print '<pre>';
        print_r($data);
        echo 'Client ID#'.$clientId = $this->session->userdata('user_id');
        $g = ob_get_contents();
        ob_clean();
        sendEmail('surajit@eclick.co.in', 'test', $g);
        
        $jsonData=json_decode($data,true);
        $reqId = $jsonData['asset_report_id'];
        $this->db->select('h.*', FALSE);
        $this->db->from(TABLE_PREFIX.'user_details as h', FALSE);
        $this->db->like('h.fund_request_id', $reqId,'both');
        $this->db->limit(1);
        $query = $this->db->get();        
        $userDetails = $query->row();
        $FundJsonstr =  $userDetails->proof_funds;
        $fundProofArr = json_decode($FundJsonstr,true);
        
        if($fundProofArr['mode'] == 'online')
		{
            $accesstokens = $fundProofArr['accesstokens'];
            if(is_array($accesstokens) && count($accesstokens)>0)
            {
                foreach($accesstokens as $k=>$v)
                {
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

                    $arrData['userId'] = $userDetails->userId;
                    $arrData['asset_token'] = $v;
                    $arrData['fund_details'] = $result;
                    $arrData['date_added'] = date('Y-m-d H:i:s');
                    $this->admin_model->setfundhistory($arrData);

                    
                    $resultArr[] = $arr;
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
            }
            
			/*$asset_report_tokens = $fundProofArr['asset_report_tokens'];
			
			if(is_array($asset_report_tokens) && count($asset_report_tokens)>0)
			{
				foreach($asset_report_tokens as $v)
				{
					$fundHistory = $this->admin_model->getfundhistory($userDetails->userId,$v);
					
					if($fundHistory->id >0)
					{
						$arr = json_decode($fundHistory->fund_details,true);
					}else{
						$url = PLAID_URL.'/asset_report/get';
						// User account info
						//$userData = $this->input->post();
						$userData = [
							"client_id"=>PLAID_CLIENT_ID,
							"secret"=>PLAID_CLIENT_SECRET,
							'asset_report_token'=>$v,
							"include_insights"=> false,
							
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
						$arr = json_decode($result,true);

						$arrData['userId'] = $userDetails->userId;
						$arrData['asset_token'] = $v;
						$arrData['fund_details'] = $result;
                        $arrData['date_added'] = date('Y-m-d H:i:s');
                        $this->admin_model->setfundhistory($arrData);
						//$this->db->insert(TABLE_PREFIX.'fund_history', $arrData);
                    }
                    
					
					$resultArr[] = $arr;
                }
                
                if(is_array($resultArr) && count($resultArr)>0)
                {
                    foreach($resultArr as $k=>$vBank)
                    {
                        $bankItems = $vBank['report']['items'];
                        if(is_array($bankItems) && count($bankItems)>0)
                        {
                            foreach($bankItems as $k=>$v)
                            {
                                $totalFortheBank = 0;
                                if(is_array($v['accounts']) && count($v['accounts'])>0)
                                {
                                    foreach($v['accounts'] as $bankAcct)
                                    {
                                        $AvailableBal = $bankAcct['balances']['available'];
                                        if($bankAcct['balances']['available'])
                                        {
                                            $totalFortheBank = $totalFortheBank+$bankAcct['balances']['available'];
                                        }
                                    }
                                    $totalAsset = $totalAsset+$totalFortheBank;
                                }
                            }
                        }
                    }
                }

			}
        }
        //$sendEmail = sendEmail('surajit@eclick.co.in', 'eclick subject previous', $totalAsset);
        
        
        $userId = $userDetails->userId;
        $userWalletBalance = $this->front_model->getwalletBalance($userId);
		//$totalAsset = $this->input->post('totalAsset');
		$curDate = date('Y-m-d H:i:s');
		$arruser['userId'] = $userId;
		$arruser['fund_proof_approve_date'] = $curDate;
		$arruser['proof_fund_status'] = 1;
		$arruser['fund_approved_amount'] = $totalAsset+$userWalletBalance;
		//$randomstring = strtoupper(substr(str_shuffle(RANDOM_CHAR), 0, 10));
		$randomstring = $this->front_model->setinvestorpassref();
		$arruser['Investor_pass'] = $randomstring;
		$result = $this->user_model->updateuserdetails($arruser);
        
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
			$asset_report_tokens = $fundProofArr['accesstokens'];
			
			if(is_array($asset_report_tokens) && count($asset_report_tokens)>0)
			{
				foreach($asset_report_tokens as $v)
				{
					$arrHistory1['date_approved'] = $curDate;
					$arrHistory1['userId'] = $userId;
					$arrHistory1['asset_token'] = $v;
					$arrHistory1['approved_fund'] = $this->security->xss_clean($totalAsset);
					$result = $this->admin_model->updatefundapprovehistory($arrHistory1);
				}
			}
        }
        $userDetails = $this->front_model->getAdminDetails($userId);
        $user_to = $userDetails['mail'];
        $user_subject = 'Your proof of funds request has been approved - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$userDetails['fname'].'</strong></h6>
        <br><br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Good news! Your proof of funds has been reviewed &amp; approved. You can now view businesses up to &amp; slightly above the total amount of
        assets verified.</p>
        <br>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);

        $notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $userId;
        $notificationarr['notification_text'] = 'Your fund proof request has been approved.';
        $notificationarr['notification_type'] = 'FUNDAPPROVE';
        $notificationarr['notification_type_id'] = $userId;
        $this->front_model->insertnotification($notificationarr);*/
    }

    public function plaidwebhookfire(){
        ///sandbox/item/fire_webhook
    }
    public function chkfundapprove(){
        ///sandbox/item/fire_webhook
        $DataPost = $this->input->post();
        $userDataPost = $this->session->userdata('user_id');
        $getfundapprovestatus = $this->admin_model->getuserprofile($userDataPost);
        if($getfundapprovestatus->proof_fund_status == 1)
        {
            $url = 'api/marketplace/listinguserpermission';
            $userDatalistingpermission['listingId'] = $DataPost['listingNo'];
            $userDatalistingpermission['user'] = $this->session->userdata('user_id');
            $res = sendRestRequest($url, $userDatalistingpermission);

            $permission = $res['data'];
            if($permission['isavailablefund'] == true && $permission['isidentityproofed'] == true && $permission['isfundproofed'] == true && $permission['totalunloadremaining']>0){
                $getfundapprovestatus->unlockpermission = true;
                
            }else{
                $getfundapprovestatus->unlockpermission = false;
            }
        }
        $getfundapprovestatus->token = $this->security->get_csrf_hash();
        
        header('Content-Type: application/json');
        //echo json_encode($getfundapprovestatus);
        echo json_encode($getfundapprovestatus);
    }

    public function contactus(){
        $header = $this->front_model->header();
        $footer = $this->front_model->footer();
        $this->load->view('frontend/includes/inside-header',$header);
        $this->load->view('frontend/contactus',$data);
        $this->load->view('frontend/includes/footer',$footer);
    }

    public function contactusfrmAction(){
        $url = 'api/data/contactus';
        $userDataPost = $this->input->post();
        $resInput = sendRestRequest($url, $userDataPost);
        
        if($resInput['status'])
        {
            $dataMsg = array(
                'success' => 'We have received your message. Our support member will contact you soon. ',
                'errorCode'=>0,
                'dataval' => ''
            );
            $this->session->set_flashdata($dataMsg);
			redirect(base_url().'contactus');
        }else{
            $dataMsg = array(
                'error' => $resInput['message'],
                'errorCode'=>1,
                'dataval' => $resInput['data']
            );
            $this->session->set_flashdata($dataMsg);
			redirect(base_url().'contactus');
        }

    }
    

    public function cmsLinks($linkslug){
        $header = $this->front_model->header();
        $footer = $this->front_model->footer();
        
		$data['page_details'] = $this->admin_cms_model->getCMSPageDetailsbyslug($this->security->xss_clean($linkslug));
        //print_r($data['page_details']);
        $header['site_settings']->site_title = $data['page_details']['metaTitle'];
        $header['site_settings']->metaKeyword = $data['page_details']['metaKeyword'];
        $header['site_settings']->metaDescription = $data['page_details']['metaDescription'];

        
        
		$url = 'api/data/partners';
        $partners = sendRestRequest($url, $userData);
        $data['partners'] = $partners['data'];
        
		$this->load->view('frontend/includes/inside-header',$header);
        if($linkslug == 'aboutus')
        {
            $this->load->view('frontend/cms_links_aboutus',$data);
        }else{
            $this->load->view('frontend/cms_links',$data);
        }
		
		$this->load->view('frontend/includes/footer',$footer);

	}

    public function fbdatadelete (){
        log_message('info', 'USER_INFO this is test');
        $signed_request = $_POST['signed_request'];
        log_message('info', 'Signed->'.$signed_request);
        /*$data = $this->parse_signed_request($signed_request);
        $user_id = $data['user_id'];

        // Start data deletion

        $status_url = 'https://www.fih.com.com/deletion?id=abc123'; // URL to track the deletion
        $confirmation_code = 'abc123'; // unique code for the deletion request

        $data = array(
        'url' => $status_url,
        'confirmation_code' => $confirmation_code,
        'user_id'=>$user_id
        );*/
        //sendEmail('surajit@eclick.co.in', 'FB delete data', json_encode($signed_request));
        //echo json_encode($data);
    }
    function parse_signed_request($signed_request) {
        list($encoded_sig, $payload) = explode('.', $signed_request, 2);
    
        $secret = "56c97b1fe3c40824ff34fc728e8cbb40"; // Use your app secret here
    
        // decode the data
        $sig = $this->base64_url_decode($encoded_sig);
        $data = json_decode($this->base64_url_decode($payload), true);
    
        // confirm the signature
        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        if ($sig !== $expected_sig) {
        //error_log('Bad Signed JSON signature!');
        sendEmail('surajit@eclick.co.in', 'FB delete data', 'Bad Signed JSON signature!');
        return null;
        }
    
        return $data;
    }
    function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    public function page_missing()
    {
        $header = $this->front_model->header();
        $footer = $this->front_model->footer();
        $this->load->view('frontend/includes/inside-header',$header);
        $this->load->view('frontend/page-not-found',$data);
        $this->load->view('frontend/includes/footer',$footer);
    }

    //https://developers.google.com/analytics/devguides/reporting/core/v4/quickstart/service-php
    // public function analytics(){
    //     $analytics = $this->initializeAnalytics();
    //     $response = $this->getReport($analytics);
    //     $this->printResults($response);
    // }
    // /**
    //  * Initializes an Analytics Reporting API V4 service object.
    //  *
    //  * @return An authorized Analytics Reporting API V4 service object.
    //  */
    // function initializeAnalytics()
    // {

    //     // Use the developers console and download your service account
    //     // credentials in JSON format. Place them in this directory or
    //     // change the key file location if necessary.
    //     $KEY_FILE_LOCATION = __DIR__ . '/product-analytics-data-5b40f6f703ec.json';
        
    //     // Create and configure a new client object.
    //     $client = new Google_Client();
    //     $client->setApplicationName("Hello Analytics Reporting");
    //     $client->setAuthConfig($KEY_FILE_LOCATION);
    //     $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
    //     $analytics = new Google_Service_AnalyticsReporting($client);

    //     return $analytics;
    // }


    // /**
    //  * Queries the Analytics Reporting API V4.
    //  *
    //  * @param service An authorized Analytics Reporting API V4 service object.
    //  * @return The Analytics Reporting API V4 response.
    //  */
    // function getReport($analytics) {

    //     // Replace with your view ID, for example XXXX.
    //     $VIEW_ID = "<REPLACE_WITH_VIEW_ID>";
    //     $VIEW_ID = "123".rand();
    //     // Create the DateRange object.
    //     $dateRange = new Google_Service_AnalyticsReporting_DateRange();
    //     $dateRange->setStartDate("7daysAgo");
    //     $dateRange->setEndDate("today");

    //     // Create the Metrics object.
    //     $sessions = new Google_Service_AnalyticsReporting_Metric();
    //     $sessions->setExpression("ga:sessions");
    //     $sessions->setAlias("sessions");

    //     // Create the ReportRequest object.
    //     $request = new Google_Service_AnalyticsReporting_ReportRequest();
    //     $request->setViewId($VIEW_ID);
    //     $request->setDateRanges($dateRange);
    //     $request->setMetrics(array($sessions));

    //     $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
    //     $body->setReportRequests( array( $request) );
    //     return $analytics->reports->batchGet( $body );
    // }


    // /**
    //  * Parses and prints the Analytics Reporting API V4 response.
    //  *
    //  * @param An Analytics Reporting API V4 response.
    //  */
    // function printResults($reports) {
    //     for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
    //         $report = $reports[ $reportIndex ];
    //         $header = $report->getColumnHeader();
    //         $dimensionHeaders = $header->getDimensions();
    //         $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
    //         $rows = $report->getData()->getRows();

    //         for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
    //         $row = $rows[ $rowIndex ];
    //         $dimensions = $row->getDimensions();
    //         $metrics = $row->getMetrics();
    //         for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
    //             print($dimensionHeaders[$i] . ": " . $dimensions[$i] . "\n");
    //         }

    //         for ($j = 0; $j < count($metrics); $j++) {
    //             $values = $metrics[$j]->getValues();
    //             for ($k = 0; $k < count($values); $k++) {
    //             $entry = $metricHeaders[$k];
    //             print($entry->getName() . ": " . $values[$k] . "\n");
    //             }
    //         }
    //         }
    //     }
    // }
}
    

    
