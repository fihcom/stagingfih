<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Authentication extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        
        // Load the user model
        $this->load->model('front_model');
    }
    
    public function login_post() {
        // Get the post data
        $data = $this->input->post();
        
        $config = [
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter your email address.',
                ],
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter your valid password.',
                ],
            ],

        ];
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules($config);
        if($this->form_validation->run()==FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
                'data'=>$data
            ], REST_Controller::HTTP_OK);
        }
        $email = $this->security->xss_clean(trim($data['email']));
        $result = $this->front_model->userLogin($email, $data['password']);
        
        if($result && $result->userId >0)
		{
            if($data['listingid'] !='')
            {
                $listingId = $data['listingid'];
                $this->db->set('userId', $result->userId);
                $this->db->where('listing_id', $listingId);
                $this->db->where('userId', 0);
                $this->db->where('type', 'VALUATION');
                $this->db->where('Status', 1);
                $this->db->update(TABLE_PREFIX.'sell_business_temp');
            }
            $this->response([
                'status' => TRUE,
                'message' => 'User login successful.',
                'data' => $result
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => array('Login unsuccessful - username and/or password are incorrect.'),
                'data'=>$data
            ], REST_Controller::HTTP_OK);
        }
    }
    
    public function registration_post() 
    {
        $data = $this->input->post();
        $register_type = $data['register_type'];
        
        if($register_type == 'SOCIALMEDIA')
        {
            $config = [
                [
                    'field' => 'fname',
                    'label' => 'Name',
                    'rules' => 'trim|required',
                    'errors' => [
                            'required' => 'Please enter your name.',
                    ],
                ],
                [
                    'field' => 'mail',
                    'label' => 'Email',
                    'rules' => 'trim|required|valid_email|callback_user_exists',
                    'errors' => [
                            'required' => 'Please enter your valid email address.',
                            'valid_email' => 'Please enter your valid email address.'
                    ],
                ],

            ];
        }else{
            $config = [
                [
                    'field' => 'fname',
                    'label' => 'Name',
                    'rules' => 'trim|required',
                    'errors' => [
                            'required' => 'Please enter your name.',
                    ],
                ],
                [
                    'field' => 'mail',
                    'label' => 'Email',
                    'rules' => 'trim|required|valid_email|callback_user_exists',
                    'errors' => [
                            'required' => 'Please enter your valid email address.',
                            'valid_email' => 'Please enter your valid email address.'
                    ],
                ],
                [
                    'field' => 'phone',
                    'label' => 'Phone',
                    'rules' => 'trim|required',
                    'errors' => [
                            'required' => 'Please enter your phone number.'
                    ],
                ],
                [
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'trim|required|callback_chk_password_expression',
                    'errors' => [
                            'required' => 'Please enter your password.'
                    ],
                ],
                [
                    'field' => 'conpassword',
                    'label' => 'Confirm Password',
                    'rules' => 'trim|required|matches[password]',
                    'errors' => [
                            'required' => 'Please enter your confirm password.'
                    ],
                ],
                [
                    'field' => 'terms',
                    'label' => 'Terms and Conditions',
                    'rules' => 'trim|required',
                    'errors' => [
                            'required' => 'Please accept Terms and conditions.'
                    ],
                ],

            ];
        }
        
        
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules($config);

        if($this->form_validation->run()==FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
                'data'=>$data
            ], REST_Controller::HTTP_OK);
        }
        
        $randomstring = substr(str_shuffle(RANDOM_CHAR), 0, 10);
        $Adddata['fname'] = $this->security->xss_clean(trim($data['fname']));
        $Adddata['lname'] = $this->security->xss_clean(trim($data['lname']));
        $Adddata['mail'] = $this->security->xss_clean(trim($data['mail']));
        $Adddata['phone'] = $this->security->xss_clean(trim($data['phone']));
        $Adddata['profile_type'] = $this->security->xss_clean(trim($data['userProfile']));
        if($register_type == 'SOCIALMEDIA')
        {
            $Adddata['password'] = '';
            $Adddata['activation_str'] = '';
        }else{
            $Adddata['password'] = getHashedPassword($data['password']);
            $Adddata['activation_str'] = $randomstring;
        }
        $Adddata['oauth_uid'] = $this->security->xss_clean(trim($data['oauth_uid']));
        $Adddata['oauth_provider'] = $this->security->xss_clean(trim($data['oauth_provider']));
        $Adddata['user_profile_pic'] = $this->security->xss_clean(trim($data['user_profile_pic']));
        $Adddata['Status'] = ($data['Status']) ? $data['Status'] : 0;
        
        
        $userTableId = $this->front_model->add_user($Adddata);
        if($data['listingid'] !='')
        {
            $listingId = $data['listingid'];
            $this->db->set('userId', $userTableId);
            $this->db->where('listing_id', $listingId);
            $this->db->where('userId', 0);
            $this->db->where('type', 'VALUATION');
            $this->db->where('Status', 1);
            $this->db->update(TABLE_PREFIX.'sell_business_temp');
        }
        $user_to =$Adddata['mail'] ;

        //$user_subject = 'Welcome to Flat Iron Holdings - FIH.com';
        $user_subject = 'Welcome to FIH.com';
        if($register_type == 'SOCIALMEDIA')
        {
            $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$data['fname'].'</strong>,</h6>
            <br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Thank you for registering at FFIH.com - the curated business marketplace.</p>
        <br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
        }else{
            $user_subject = 'FIH.com Account Activation.';
            $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$data['fname'].'</strong>,</h6>
            <br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Thank you for registering at FIH.com - the curated business marketplace.</p>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Please <a href="'.base_url().'emailconfirm?email='.$Adddata['mail'].'&r='.$randomstring.'">Click here</a> to activate your account.</p>
        <br>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
        }
		
		$sendEmail = sendEmail($user_to, $user_subject, $user_message);
        
        $this->response([
            'status' => TRUE,
            'message' => 'The user has been added successfully.',
            'data' => [$userTableId,$user_to]
        ], REST_Controller::HTTP_OK);
        
    }

    public function checksocialuserexists_post(){
        $data = $this->input->post();
        $result = $this->front_model->checkOAuthProvider($data['oauth_provider'],$data['oauth_uid']);
        $this->response([
            'status' => TRUE,
            'message' => '',
            'data' => $result,
            'postdata'=>$data
        ], REST_Controller::HTTP_OK);
    }

    public function confirmemail_post(){
        $value = $this->input->post();
        $email = $this->security->xss_clean(trim($value['email']));
		$random = $this->security->xss_clean(trim($value['r']));
        $result = $this->front_model->emailconfirm($email,$random);
        $this->response([
            'status' => TRUE,
            'message' => 'The user has been added successfully.',
            'data' => [
                $value
                    ]
        ], REST_Controller::HTTP_OK);
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
	public function user_exists($str)
	{
		$user = $this->front_model->checkExistingUser($str);
		if ($user)
		{
            if($user->Status == 0)
            {
                $this->form_validation->set_message('user_exists', 'Your account is not activated yet. Please activate your account from the acitvation link sent at your email address.');
            }else{
                $this->form_validation->set_message('user_exists', 'Email address exists. Please select different email address.');
            }
			
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
    
    public function user_get($id = 0) {
        // Returns all the users data if the id not specified,
        // Otherwise, a single user will be returned.
        $con = $id?array('id' => $id):'';
        $users = $this->user->getRows($con);
        
        // Check if the user data exists
        if(!empty($users)){
            // Set the response and exit
            //OK (200) being the HTTP response code
            $this->response($users, REST_Controller::HTTP_OK);
        }else{
            // Set the response and exit
            //NOT_FOUND (404) being the HTTP response code
            $this->response([
                'status' => FALSE,
                'message' => 'No user was found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    
    public function user_put() {
        $id = $this->put('id');
        
        // Get the post data
        $first_name = strip_tags($this->put('first_name'));
        $last_name = strip_tags($this->put('last_name'));
        $email = strip_tags($this->put('email'));
        $password = $this->put('password');
        $phone = strip_tags($this->put('phone'));
        
        // Validate the post data
        if(!empty($id) && (!empty($first_name) || !empty($last_name) || !empty($email) || !empty($password) || !empty($phone))){
            // Update user's account data
            $userData = array();
            if(!empty($first_name)){
                $userData['first_name'] = $first_name;
            }
            if(!empty($last_name)){
                $userData['last_name'] = $last_name;
            }
            if(!empty($email)){
                $userData['email'] = $email;
            }
            if(!empty($password)){
                $userData['password'] = md5($password);
            }
            if(!empty($phone)){
                $userData['phone'] = $phone;
            }
            $update = $this->user->update($userData, $id);
            
            // Check if the user data is updated
            if($update){
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'The user info has been updated successfully.'
                ], REST_Controller::HTTP_OK);
            }else{
                // Set the response and exit
                $this->response("Some problems occurred, please try again.", REST_Controller::HTTP_OK);
            }
        }else{
            // Set the response and exit
            $this->response("Provide at least one user info to update.", REST_Controller::HTTP_OK);
        }
    }

    public function saveprofilephoto_post(){
        $data = $this->input->post();
        $link  = $data['link'];
        if ($link) {
			$fileName = date('y-m-d-H-i-s') . '.jpg';
			$ch = curl_init();
			$savePath = "uploads/profile_pictures/". $fileName;
			$fp = fopen($savePath, 'wb');
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_URL, $link);
			curl_setopt($ch, CURLOPT_REFERER, $link);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

			curl_setopt($ch, CURLOPT_FILE, $fp);
			$img = curl_exec($ch);
			fclose($fp);
			curl_close($ch);
            //return $fileName;
            $this->response([
                'status' => TRUE,
                'message' => '',
                'data' => $fileName
            ], REST_Controller::HTTP_OK);
			
			
        }
    }

    public function forgetPassword_post(){
        $data = $this->input->post();
        $config = [
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email',
                'errors' => [
                        'required' => 'Please enter your valid email address.',
                        'valid_email' => 'Please enter your valid email address.'
                ],
            ],

        ];
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules($config);

        if($this->form_validation->run()==FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
                'data'=>$data
            ], REST_Controller::HTTP_OK);
        }
        $mail = $data['email'];

        $email = $this->security->xss_clean(trim($mail));
        $result = $this->front_model->userForgetPass($email);
        if($result->userId>0)
		{
			
			$user_to = $result->mail;
			$user_subject = 'Password Reset - FIH.com';
			$user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$result->name.'</strong>,</h6>
            <br>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Someone recently requested that your password be reset. If this is a mistake just ignore this email - your password will not be changed. Otherwise, Please <a href="'.base_url().'/resetpassword?email='.$email.'&r='.$result->passwordResetCode.'">click here</a> to confirm and reset your password.</p>
            <br>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,<br>
            The Fih.com Team</p>';
			$sendEmail = sendEmail($user_to, $user_subject, $user_message);
            $this->response([
                'status' => TRUE,
                'message' => 'An email with reset password link has been sent to your registered email ['.$result->mail.'].',
                'data' => $result
            ], REST_Controller::HTTP_OK);
		}else{
            $this->response([
                'status' => FALSE,
                'message' => array('No user found with this email address.'),
                'data' => $data
            ], REST_Controller::HTTP_OK);
		}
        

    }

    public function resetPassword_post(){
        $data = $this->input->post();
        $config = [
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email',
                'errors' => [
                        'required' => 'Please enter your valid email address.',
                        'valid_email' => 'Please enter your valid email address.'
                ],
            ],
            [
                'field' => 'random',
                'label' => 'Random',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Random Number is missing.'
                ],
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required|callback_chk_password_expression',
                'errors' => [
                        'required' => 'Please enter your password.'
                ],
            ],
            [
                'field' => 'conpassword',
                'label' => 'Confirm Password',
                'rules' => 'trim|required|matches[password]',
                'errors' => [
                        'required' => 'Please enter your confirm password.'
                ],
            ]

        ];
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules($config);

        if($this->form_validation->run()==FALSE){
            $this->response([
                'status' => FALSE,
                'message' => $this->form_validation->error_array(),
                'data'=>$data
            ], REST_Controller::HTTP_OK);
        }

        $mail = $data['email'];
        $random = $data['random'];
        $senddata['password'] = getHashedPassword($data['password']);
        $conpassword = $data['conpassword'];
        $senddata['email'] = $this->security->xss_clean(trim($mail));
        $senddata['random'] = $this->security->xss_clean(trim($random));

        $result = $this->front_model->updateuserpassword($senddata);
        if($result->userId >0)
        {
            $this->response([
            'status' => true,
            'message' => 'Password reset successfully.',
            'data' => $result
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
            'status' => false,
            'message' => array('No user found with this email address.'),
            'data' => $result
            ], REST_Controller::HTTP_OK);
        }
        
    }

}

