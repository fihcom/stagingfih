<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paypal extends CI_Controller{
    
     function  __construct(){
        parent::__construct();
        
        // Load paypal library & product model
        $this->load->library('paypal_lib');
        $this->load->model('front_model');
        $this->load->model('admin_model');
        //$this->load->model('product');
     }
     function pay(){
        $returnURL = base_url().'paypal/success';
        $cancelURL = base_url().'paypal/cancel';
        $notifyURL = base_url().'paypal/ipn';
        
        $siteSetting = $this->admin_model->getSiteSettings();
        $currencyDetails = $this->front_model->getSelectedCurreny($siteSetting['currency']);
        $packageId = $this->input->post('packageId');
        $packageName = $this->input->post('packageName');
        $area = $this->input->post('area');
        $tempuser = $this->input->post('tempuser');

        $paypalemail = $siteSetting['paypal_email'];

        $data['userId'] = $this->session->userdata('userId');
        $section = '';
        if($tempuser>0)
        {
            $data['userId'] = $tempuser;
            $section = 'REGISTRATION';
        }elseif(!$data['userId'] >0)
		{
			redirect(base_url());
        }
        $packageInfo = $this->subscription_model->listmembership($packageId);
        //$packageInfo = $this->athlete_model->packageDetailsbyid($packageId);
         // Add fields to paypal form
        $this->paypal_lib->add_field('return', $returnURL);
        $this->paypal_lib->add_field('cancel_return', $cancelURL);
        $this->paypal_lib->add_field('notify_url', $notifyURL);
        $this->paypal_lib->add_field('item_name', $area.' :'.$packageName);
        $this->paypal_lib->add_field('custom', $area.':'.$data['userId'].':'.$packageId.':'.$section);
        $this->paypal_lib->add_field('business', $paypalemail);
        $this->paypal_lib->add_field('no_shipping', "1");
        $this->paypal_lib->add_field('amount',  $packageInfo->price);

        $this->paypal_lib->add_field('currency_code',  $currencyDetails->code);
        $this->paypal_lib->add_field('quantity',  "1");
        // Render paypal form
        $this->paypal_lib->paypal_auto_form();
     }
     
    function success(){
        
        $custom = $_REQUEST['custom'];
        $customarr = explode(':',$custom);
        if($customarr[3] == 'REGISTRATION')
        {
            $user = $this->front_model->find_temp_user($customarr[1]);
            
            
        }
		/*$header['sitetitle'] = 'Payment Success - Fih.com';
		$header['isloggedin'] = $this->session->userdata('isLoggedIn');
		$header['role'] = $this->session->userdata('roleText');
		$header['name'] = $this->session->userdata('name');*/
        $header = $this->front_model->header();
        $footer = $this->front_model->footer();
		$data[] = '';
		$this->load->view('user/includes/header',$header);
		$this->load->view('user/success-sell-business',$data);
		$this->load->view('user/includes/footer',$footer);
    }
     
     function cancel(){
        
		/*$header['sitetitle'] = 'Payment Cancel - Fih.com';
		$header['isloggedin'] = $this->session->userdata('isLoggedIn');
		$header['role'] = $this->session->userdata('roleText');
		$header['name'] = $this->session->userdata('name');*/
        $header = $this->front_model->header();
        $header['site_settings']->site_title = 'Payment Failed - '.$header['site_settings']->site_title;
        $footer = $this->front_model->footer();
        //$header['sitetitle'] = 'Payment Failed - Fih.com';
		$header['isloggedin'] = $this->session->userdata('isLoggedIn');
		$header['role'] = $this->session->userdata('roleText');
		$header['name'] = $this->session->userdata('name');
        //$header = $this->front_model->header();
        //$footer = $this->front_model->footer();
		$data[] = '';
		$this->load->view('frontend/includes/inside-header',$header);
        $this->load->view('frontend/paypalcancel');
        $this->load->view('frontend/includes/footer');
     }
     
     function ipn(){
        
        //////////////////////////////////////////////
        // Paypal posts the transaction data
        $paypalInfo = $this->input->post();
        
        if(!empty($paypalInfo)){
            $ipnCheck = $this->paypal_lib->validate_ipn($paypalInfo);

            //log_message('info', $paypalInfo);
            //mail('chansuro@gmail.com','test email 123',$paypalInfo["payment_status"]);
            if($ipnCheck){
                if(($paypalInfo["payment_status"] == 'Completed' || $paypalInfo["payment_status"] == 'Pending') && $paypalInfo["payer_status"] == 'verified')
                {
                    $custom = explode(':',$paypalInfo["custom"]);

                    $url = 'api/data/sellrequestfinal';
                    $userDataPost = $paypalInfo;
                    $userDataPost['clientId'] = $custom[1];
                    $userDataPost['paymentAmount'] = $paypalInfo["mc_gross"];
                    //print_r($userDataPost);
                    //$g1 = ob_get_contents();
                    //mail('chansuro@gmail.com','qeip.com registration 33',$g1);
                    $res = sendRestRequest($url, $userDataPost);
                    if($res['status'] === false)
                    {
                        redirect(base_url().'user/sell-your-business');
                    }
                }
            }
        }
        
        /*print_r($paypalInfo);
        $g = ob_get_contents();
        ob_end_flush();
        
        mail('chansuro@gmail.com','qeip.com registration',$g);*/
        /*$paypalInfo = array(
            'mc_gross' => '22.44',
            'protection_eligibility' => 'Eligible',
            'payer_id' => 'SK3SHBG4Z7DD6',
            'payment_date' => '23:16:44 Sep 17, 2020 PDT',
            'payment_status' => 'Pending',
            'charset' => 'windows-1252',
            'first_name' => 'Surajit',
            'notify_version' => '3.9',
            'custom' => 'POLITICIAN:5:2:REGISTRATION',
            'payer_status' => 'verified',
            'business' => 'chansuro@gmail.com',
            'quantity' => '1',
            'verify_sign' => 'A0IP1QjfpfCzqjN2DcUeVky9w6hGASmLRevC-IA-WVbIM0rism9vt3qa',
            'payer_email' => 'chansuropersonal@tom.com',
            'txn_id' => '96T914233Y135150G',
            'payment_type' => 'instant',
            'last_name' => 'Koley',
            'receiver_email' => 'chansuro@gmail.com',
            'shipping_discount' => '0.00',
            'receiver_id' => 'PWH4U7ZUT3ANY',
            'pending_reason' => 'multi_currency',
            'insurance_amount' => '0.00',
            'txn_type' => 'web_accept',
            'item_name' => 'POLITICIAN :Bronze package 11',
            'discount' => '0.00',
            'mc_currency' => 'USD',
            'item_number' =>'',
            'residence_country' => 'US',
            'test_ipn' => '1',
            'shipping_method' => 'Default',
            'transaction_subject' =>'',
            'payment_gross' => '22.44',
            'ipn_track_id' => '62de602b01127'
         );*/
        //mail('chansuro@gmail.com','NPB registration 1',$g);
        
        
        

    }
}