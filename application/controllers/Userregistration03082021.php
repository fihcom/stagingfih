<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userregistration extends CI_Controller {
    public function __construct() 
	{
		parent::__construct();
        $this->load->library(array('form_validation', "upload"));
        $this->load->library('facebook');
        $this->load->model('front_model');
        $this->load->helper(array('cookie', 'url')); 
	}
    
    public function login(){
        if($this->session->userdata('isLoggedIn'))
		{
            redirect(base_url());
            exit();
        }
        $header = $this->front_model->header();
        $header['site_settings']->site_title = 'Login - '.$header['site_settings']->site_title;
        $footer = $this->front_model->footer();
        include_once APPPATH.'libraries/vendor/autoload.php';
        //echo gloginredirecturl;
		$Google_client = new Google_Client();
		$Google_client->setClientId(gloginclientId);
		$Google_client->setClientSecret(gloginclientSecret);
		$Google_client->setRedirectUri(gloginredirecturl);
		$Google_client->addScope('email');
        $Google_client->addScope('profile');

        $data['google_login_url']= $Google_client->createAuthUrl();
        $data['facebook_login_url'] =  $this->facebook->login_url();
        $data['redirectto'] =  $_GET['redirect_to'];
        $this->load->view('frontend/includes/inside-header',$header);
        $this->load->view('frontend/login',$data);
        $this->load->view('frontend/includes/footer',$footer);
    }

    public function loginUser(){
        if($this->session->userdata('isLoggedIn'))
		{
            redirect(base_url());
            exit();
        }

        $listingid = $this->session->session_id;
        $url = 'api/authentication/login';
        $userDataPost = $this->input->post();
        
        $userDataPost['listingid'] = $listingid;
        $redirectto = $userDataPost['redirect'];
        $res = sendRestRequest($url, $userDataPost);
        
        if($res['status'] === true){
            $userDetails = $res['data'];
            
            $rememberme = $this->input->post('rememberme');
            if($rememberme == 1)
			{
				$randomstring = substr(str_shuffle(RANDOM_CHAR), 0, 10);
				delete_cookie('remember_me_npb'); 
				$cookie = array(
					'name'   => 'remember_me_npb',
					'value'  => $randomstring,
					'expire' => '1209600',  // Two weeks
				);
				set_cookie($cookie);
				$this->db->set('remember_me', $randomstring);
				$this->db->where('userId', $userDetails['userId']);
				$this->db->update(TABLE_PREFIX.'users');
            }
            //print '<pre>';
                //print_r($sessionArray);
                //print_r($userDetails);
                //die;
            if($userDetails['role'] == 'admin'){
                $sessionArray = array('userId'=>$userDetails['userId'],     
							'name'=>$userDetails['fname'],
                            'lastLogin'=> '',
                            'roleText'=>'admin',
                            'authorize' =>$userDetails['authorize'],  
							'isLoggedIn' => TRUE
                );
                
                $this->session->set_userdata('login_as_user','login_as_admin');
                $this->session->set_userdata('user_id',$userDetails['userId']);
                $this->session->set_userdata($sessionArray);/**/
                if($redirectto !='')
                {
                    redirect(base_url().$redirectto);
                    die;
                }
                redirect(base_url().'administrator');
            }elseif($userDetails['role'] == 'subadmin'){
                $permissions = $userDetails['authorize'];
                if($permissions == 'ALL') 
                {
                    $newAuthArr = 'ALL';
                }else{
        
                    $authArr = explode('|',$userDetails['authorize']);
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
                $sessionArray = array('userId'=>$userDetails['userId'],     
							'name'=>$userDetails['fname'],
                            'lastLogin'=> '',
                            'roleText'=>'admin',
                            'authorize' =>$newAuthArr,  
							'isLoggedIn' => TRUE
                );
                $this->session->set_userdata('login_as_user','login_as_admin');
                $this->session->set_userdata('user_id',$userDetails['userId']);
                $this->session->set_userdata($sessionArray);/**/
                if($redirectto !='')
                {
                    redirect(base_url().$redirectto);
                    die;
                }
                redirect(base_url().'administrator');
            }else{
                
                $sessionArray = array('userId'=>$userDetails['userId'],     
							'name'=>$userDetails['name'],
                            'lastLogin'=> '',
                            'roleText'=>'user',
							'isLoggedIn' => TRUE
                );
                $this->session->set_userdata('login_as_user','login_as_user');
                $this->session->set_userdata('user_id',$userDetails['userId']);
                $this->session->set_userdata($sessionArray);/**/
                if($redirectto !='')
                {
                    redirect(base_url().$redirectto);
                    die;
                }

                redirect(base_url().'user/buyer');
            }
        }else{
            $data = array(
                'error' => $res['message'],
                'errorCode'=>1,
                'dataval' => $res['data']
            );
            $this->session->set_flashdata($data);
			redirect(base_url().'login');
        }
    }

    public function newsletter(){
        /*$url = 'api/user/registernewsletter';
        $userData = $this->input->post();
        $res = sendRestRequest($url, $userData);
        if($res['status'] === true){
            
        }else{
            $data = array(
                'error' => $res['message'],
                'errorCode'=>1,
                'dataval' => $res['data']
            );
        }*/
        $data = array(
                'error' => 'Email successfully subscribed.',
                'errorCode'=>0,
                'dataval' => $res['data']
        );

        //print '<pre>';
        //print_r($data);
        //die;

        
        $header = $this->front_model->header();
        $footer = $this->front_model->footer();
        $this->load->view('frontend/includes/inside-header',$header);
        $this->load->view('frontend/registernewsletter',$data);
        $this->load->view('frontend/includes/footer',$footer);
    }

    public function register(){
        if($this->session->userdata('isLoggedIn'))
		{
            redirect(base_url());
            exit();
        }
        include_once APPPATH.'libraries/vendor/autoload.php';
        //echo gloginredirecturl;
		$Google_client = new Google_Client();
		$Google_client->setClientId(gloginclientId);
		$Google_client->setClientSecret(gloginclientSecret);
		$Google_client->setRedirectUri(gloginredirecturl);
		$Google_client->addScope('email');
        $Google_client->addScope('profile');
        $data['google_login_url']=$Google_client->createAuthUrl();
        $data['facebook_login_url'] =  $this->facebook->login_url();
        $header = $this->front_model->header();
        $header['site_settings']->site_title = 'Create your account - '.$header['site_settings']->site_title;
        $footer = $this->front_model->footer();
        $this->load->view('frontend/includes/inside-header',$header);
        $this->load->view('frontend/register',$data);
        $this->load->view('frontend/includes/footer',$footer);
    }

    public function forgetpassword(){
        $header = $this->front_model->header();
        $header['site_settings']->site_title = 'Reset your password - '.$header['site_settings']->site_title;
        $footer = $this->front_model->footer();
        
        $this->load->view('frontend/includes/inside-header',$header);
        $this->load->view('frontend/forget-password');
        $this->load->view('frontend/includes/footer',$footer);
    }

    public function forgetpasswordaction(){
        if($this->session->userdata('isLoggedIn'))
		{
            redirect(base_url());
            exit();
        }
        $url = 'api/authentication/forgetpassword';
        $userData = $this->input->post();
        
        $res = sendRestRequest($url, $userData);
        if($res['status'] === true)
        {
            $data = array(
                'success' => $res['message'],
                'errorCode'=>1,
                'dataval' => ''
            );
            $this->session->set_flashdata($data);
			redirect(base_url().'forgetpassword');
        }else{
            $data = array(
                'error' => $res['message'],
                'errorCode'=>1,
                'dataval' => $res['data']
            );
            $this->session->set_flashdata($data);
			redirect(base_url().'forgetpassword');
        }
    }
    
    public function registerUser(){
        if($this->session->userdata('isLoggedIn'))
		{
            redirect(base_url());
            exit();
        }
        $url = 'api/authentication/registration';
        $userData = $this->input->post();
        $listingid = $this->session->session_id;
        $userData['listingid'] = $listingid;
        $res = sendRestRequest($url, $userData);
        
        if($res['status'] === false)
        {
            $data = array(
                'error' => $res['message'],
                'errorCode'=>1,
                'dataval' => $res['data']
            );
            $this->session->set_flashdata($data);
			redirect(base_url().'register');
        }else{
            $emailUser = $res['data'][1];
            $data = array(
                'error' => $res['message'],
                'errorCode'=>0,
                'dataval' => $res['data'],
                'email' =>$emailUser
            );
            $this->session->set_flashdata($data);
            redirect(base_url().'register/success');
        }
    }

    public function emailconfirm(){
        if($this->session->userdata('isLoggedIn'))
		{
            redirect(base_url());
            exit();
        }
        $url = 'api/authentication/confirmemail';
        $userData['email'] = $this->input->get('email');
        $userData['r'] = $this->input->get('r');
        $res = sendRestRequest($url, $userData);
        $data = array(
            'success' => 'You have successfully confirmed your email address. ',
            'errorCode'=>1,
            'dataval' => ''
        );
        $this->session->set_flashdata($data);
        redirect(base_url().'login');
    
    }

    public function registerSuccess()
    {
        if($this->session->userdata('isLoggedIn'))
		{
            redirect(base_url());
            exit();
        }
        $header = $this->front_model->header();
        $header['site_settings']->site_title = 'Welcome - '.$header['site_settings']->site_title;
        $footer = $this->front_model->footer();
        $this->load->view('frontend/includes/inside-header',$header);
        $this->load->view('frontend/register-success');
        $this->load->view('frontend/includes/footer',$footer);
    }

    public function userauthgoogle()
    {
       
        if($this->session->userdata('isLoggedIn'))
		{
            redirect(base_url());
            exit();
        } 
        
        include_once APPPATH.'libraries/vendor/autoload.php';
		$Google_client = new Google_Client();
		$Google_client->setClientId(gloginclientId);
		$Google_client->setClientSecret(gloginclientSecret);
		$Google_client->setRedirectUri(gloginredirecturl);
		$Google_client->addScope('email');
        $Google_client->addScope('profile');
        if(isset($_GET["code"])){
            
            $token = $Google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
            
            if(!isset($token["error"])){
                $Google_client->setAccessToken($token["access_token"]);
				$this->session->userdata('access_token',$token["access_token"]);
				$google_service = new Google_Service_Oauth2($Google_client);
                $userProfile = $google_service->userinfo->get();
                $url = 'api/authentication/checksocialuserexists';
                $checkArray['oauth_provider'] = 'google';
                $checkArray['oauth_uid'] = $userProfile['id'];
                $checkUserExist = sendRestRequest($url, $checkArray);
                
                if(count($checkUserExist['data'])>0)
                {
                    $userData = $checkUserExist['data'][0];
                    $sessionArray = array('userId'=>$userData['userId'],     
                                'name'=>$userData['fname'],
                                'lastLogin'=> '',
                                'isLoggedIn' => TRUE
                    );
                    
                    $this->session->set_userdata('login_as_user','login_as_user');
                    $this->session->set_userdata('user_id',$userData['userId']);
                    $this->session->set_userdata($sessionArray);/**/
                    redirect(base_url().'user');
                }else{
                    $getResult = $this->front_model->checkExistingUser($userProfile['email']);
                    if($getResult->userId > 0)
                    {
                        $data = array(
                            'error' => ['Email already exist. You can access your account or change your password by clicking on Login button.'],
                            'mail'=>$userProfile['email']
                            );
                            $this->session->set_flashdata($data);
                            redirect(base_url().'login');
                    }
                    $profileid = $userProfile['id'];
                    
					$picturedetails = $userProfile['picture'];
                    //$profilepic = $this->save_profile_photo($picturedetails);
                    $url = 'api/authentication/saveprofilephoto';
                    $profilepicArray['link'] = $picturedetails;
                    $profilepicData = sendRestRequest($url, $profilepicArray);
                    $profilepic = $profilepicData['data'];

					$editArray['oauth_provider'] = 'google'; 
					$editArray['oauth_uid']    = !empty($userProfile['id'])?$userProfile['id']:'';
					$editArray['Status']   = 1; 
					$editArray['user_profile_pic'] = $profilepic;
					$name = $this->security->xss_clean(trim($userProfile['givenName']));
                    $lname = $this->security->xss_clean(trim($userProfile['familyName']));
					$email = $this->security->xss_clean(trim($userProfile['email']));
					$editArray['fname'] = $name;
                    $editArray['lname'] = $lname;
					$editArray['mail'] = $email;
                    $editArray['register_type'] = 'SOCIALMEDIA';
                    $url = 'api/authentication/registration';
                    $res = sendRestRequest($url, $editArray);
                    if($res['status'])
                    {
                        $url = 'api/authentication/checksocialuserexists';
                        $loginArray['oauth_provider'] = 'google';
                        $loginArray['oauth_uid'] = $profileid;
                        $checkUserExist = sendRestRequest($url, $loginArray);
                        $userData = $checkUserExist['data'][0];
                        $sessionArray = array('userId'=>$userData['userId'],     
                                    'name'=>$userData['fname'],
                                    'lastLogin'=> '',
                                    'isLoggedIn' => TRUE
                        );
                        
                        $this->session->set_userdata('login_as_user','login_as_user');
                        $this->session->set_userdata('user_id',$userData['userId']);
                        $this->session->set_userdata($sessionArray);/**/
                        redirect(base_url().'user');
                    }else{
                        $data = array(
                            'error' => $res['message'],
                            'errorCode'=>1,
                            'dataval' => $res['data']
                        );
                        $this->session->set_flashdata($data);
                        redirect(base_url().'login');
                    }
                    
                }
            }
        }
        die;
    }

    public function userauthfb()
    {
		if($this->session->userdata('isLoggedIn'))
		{
            redirect(base_url());
            exit();
        }
		$userData = array();
		if($this->facebook->is_authenticated()){
            $userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
			$user_email = $userProfile['email'];
			$checkUserExist = $this->front_model->checkOAuthProvider('facebook',$userProfile['id']);
            $url = 'api/authentication/checksocialuserexists';
            $editArray['oauth_provider'] = 'facebook';
            $editArray['oauth_uid'] = $userProfile['id'];
            $checkUserExist = sendRestRequest($url, $editArray);
            
			if(count($checkUserExist['data'])>0)
			{
                $userData = $checkUserExist['data'][0];
                if($userData['Status'] == 1)
                {
                    $sessionArray = array('userId'=>$userData['userId'],     
							'name'=>$userData['fname'],
							'lastLogin'=> '',
							'isLoggedIn' => TRUE
                    );
                    
                    $this->session->set_userdata('login_as_user','login_as_user');
                    $this->session->set_userdata('user_id',$userData['userId']);
                    $this->session->set_userdata($sessionArray);/**/
                    redirect(base_url().'user');
                }else{
                    $data = array(
						'error' => array('Login Unsuccesful. No active user found.')
					);
					$this->session->set_flashdata($data);
					redirect(base_url().'login');
                }
			}else{
                $getResult = $this->front_model->checkExistingUser($user_email);
                if($getResult->userId > 0)
                {
                    $data = array(
                        'error' => ['Email already exist. You can access your account or change your password by clicking on Login button.'],
                        'mail'=>$userProfile['email']
                        );
                        $this->session->set_flashdata($data);
                        redirect(base_url().'login');
                }
				$profileid = $userProfile['id'];
                $picturedetails = $this->facebook->request('get', '/me/picture?redirect=0&height=200&width=200&type=normal');
                
                $url = 'api/authentication/saveprofilephoto';
                $profilepicArray['link'] = $picturedetails['data']['url'];
                $profilepicData = sendRestRequest($url, $profilepicArray);
                $profilepic = $profilepicData['data'];
				$editArray['oauth_provider'] = 'facebook'; 
                $editArray['oauth_uid']    = !empty($userProfile['id'])?$userProfile['id']:'';
				$editArray['Status']   = 1;

				$name = $this->security->xss_clean(trim($userProfile['first_name']));
                $lname = $this->security->xss_clean(trim($userProfile['last_name']));
				$email = $this->security->xss_clean(trim($userProfile['email']));
				$editArray['fname'] = $name;
                $editArray['lname'] = $lname;
                $editArray['mail'] = $email;
                $editArray['register_type'] = 'SOCIALMEDIA';
                $editArray['user_profile_pic'] = $profilepic;
                $url = 'api/authentication/registration';
                $res = sendRestRequest($url, $editArray);

                $url = 'api/authentication/checksocialuserexists';
                $loginArray['oauth_provider'] = 'facebook';
                $loginArray['oauth_uid'] = $profileid;
                $checkUserExist = sendRestRequest($url, $editArray);
                $userData = $checkUserExist['data'][0];
                $sessionArray = array('userId'=>$userData['userId'],     
							'name'=>$userData['fname'],
							'lastLogin'=> '',
							'isLoggedIn' => TRUE
                );
                
                $this->session->set_userdata('login_as_user','login_as_user');
                $this->session->set_userdata('user_id',$userData['userId']);
                $this->session->set_userdata($sessionArray);/**/
                redirect(base_url().'user');
                
			}

		}
		else
		{
            $data['authUrl'] =  $this->facebook->login_url();
        }
    }

    public function resetpassword()
    {
        $header = $this->front_model->header();
        $header['site_settings']->site_title = 'Reset your password - '.$header['site_settings']->site_title;
        $footer = $this->front_model->footer();
        $userData = $this->input->get();
        $data['email'] = $userData['email'];
        $data['random'] = $userData['r'];
        $this->load->view('frontend/includes/inside-header',$header);
        $this->load->view('frontend/reset-password',$data);
        $this->load->view('frontend/includes/footer',$footer);
    }

    public function resetpasswordaction()
    {
        $url = 'api/authentication/resetpassword';
        $userData = $this->input->post();
        
        $res = sendRestRequest($url, $userData);
        
        if($res['status'] == true)
        {
            $data = array(
                'success' => $res['message'],
                'errorCode'=>1,
                'dataval' => '',
                'submitbuy' =>true,
            );
            $this->session->set_flashdata($data);
            redirect(base_url().'login');
        }else{
            $data = array(
                'error' => $res['message'],
                'errorCode'=>1,
                'dataval' => $res['data'],
                'submitbuy' =>true,
            );
            $this->session->set_flashdata($data);

            redirect(base_url().'resetpassword?email='.$userData['email'].'&r='.$userData['random']);
        }
        
    }
    

    
}