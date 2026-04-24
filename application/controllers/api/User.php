<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class User extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        
        // Load the user model
        $this->load->model('user_model');
        $this->load->model('admin_model');
        $this->load->model('front_model');
        $this->load->library('session');
    }

    public function monetization_post(){
        $result = $this->user_model->getmonetization();
        $this->response([
            'status' => TRUE,
            'message' => '',
            'data' => $result
        ], REST_Controller::HTTP_OK);
    }

    public function selltemprecord_post(){
        $data = $this->input->post();
        $monetization = $this->user_model->getmonetization('SELL');
        $tempdata = $this->user_model->gettempselldata($data['clientId'],'SELL');
        
        $this->response([
            'status' => TRUE,
            'message' => '',
            'data' => [
                'monetization' => $monetization,
                'tempdata' => $tempdata
            ]
        ], REST_Controller::HTTP_OK);
    }

    public function valuationtemprecord_post(){
        $data = $this->input->post();
        $monetization = $this->user_model->getmonetization('VALUATION');
        $tempdata = $this->user_model->gettempvaluationdata($data['clientId'],$data['listingId']);
        
        $this->response([
            'status' => TRUE,
            'message' => '',
            'data' => [
                'monetization' => $monetization,
                'tempdata' => $tempdata
            ]
        ], REST_Controller::HTTP_OK);
    }

    public function updatesellyourbusiness_post(){
        $data = $this->input->post();
        /*if($sellbusinessdata!='')
        {
            $sellbusinessdata = json_decode($sellbusinessdata,true);
        }*/
        $tempdata = $this->user_model->gettempselldata($data['clientId'],'SELL');
        if($tempdata->id>0){
            $jsonText = $tempdata->data_json;
            if($jsonText!='')
            {
                $jsonTextArr = json_decode($jsonText,true);
            }else{
                $jsonTextArr = [];
            }
            
        }else{
            $jsonTextArr = [];
        }

        if($data['step'] == 1){
            $jsonTextArr['monetization'] = explode(',',$this->security->xss_clean(trim($data['monetization'])));
        }elseif($data['step'] == 2){
            $websitestr = $data['website'];
            $websitestrArr = explode(',',$websitestr);
            $jsonTextArr['website'] = $websitestrArr;
            $businessstartdate = $this->security->xss_clean(trim($data['businessstartdate']));
            $businessstartdateArr = explode('/',$businessstartdate);
            $jsonTextArr['businessstartdate'] = $businessstartdateArr[2].'-'.$businessstartdateArr[0].'-'.$businessstartdateArr[1];
            $jsonTextArr['workinghour'] = $this->security->xss_clean(trim($data['workinghour']));
        }elseif($data['step'] == 3){
            $jsonTextArr['month3avgrevenue'] = $this->security->xss_clean(trim($data['month3avgrevenue']));
            $jsonTextArr['month3avgprofit'] = $this->security->xss_clean(trim($data['month3avgprofit']));
            $jsonTextArr['month6avgrevenue'] = $this->security->xss_clean(trim($data['month6avgrevenue']));
            $jsonTextArr['month6avgprofit'] = $this->security->xss_clean(trim($data['month6avgprofit']));
            $jsonTextArr['month12avgrevenue'] = $this->security->xss_clean(trim($data['month12avgrevenue']));
            $jsonTextArr['month12avgprofit'] = $this->security->xss_clean(trim($data['month12avgprofit']));
        }elseif($data['step'] == 4){
            $jsonTextArr['trackingInfo'] = $this->security->xss_clean(trim($data['trackingInfo']));
            $jsonTextArr['trackingtool'] = $this->security->xss_clean(trim($data['trackingtool']));
            $jsonTextArr['monthlyvisitor'] = $this->security->xss_clean(trim($data['monthlyvisitor']));
            $jsonTextArr['trackingaddeddate'] = $this->security->xss_clean(trim($data['trackingaddeddate']));
        }elseif($data['step'] == 5){
            $jsonTextArr['extraInfo'] = $this->security->xss_clean(trim($data['extraInfo']));
        }
        $User = $data['clientId'];
        $this->user_model->sellbusinesstemp(json_encode($jsonTextArr),$User);
        $this->response([
            'status' => TRUE,
            'message' => '',
            'data' => $data
        ], REST_Controller::HTTP_OK);

    }
    
    public function updatevalueyourbusiness_post(){
        $data = $this->input->post();
        $listingid = $data['listing_id'];
        $tempdata = $this->user_model->gettempvaluationdata($data['clientId'],$listingid);
        if($tempdata->id>0){
            $jsonText = $tempdata->data_json;
            if($jsonText!='')
            {
                $jsonTextArr = json_decode($jsonText,true);
            }else{
                $jsonTextArr = [];
            }
            
        }else{
            $jsonTextArr = [];
        }

        if($data['step'] == 1){
            $jsonTextArr['monetization'] = explode(',',$this->security->xss_clean(trim($data['monetization'])));
        }elseif($data['step'] == 2){
            $businessstartdate = $this->security->xss_clean(trim($data['businessstartdate']));
            $businessstartdateArr = explode('/',$businessstartdate);
            $websitestr = $data['website'];
            $websitestrArr = explode(',',$websitestr);
            $jsonTextArr['website'] = $websitestrArr;
            $jsonTextArr['businessstartdate'] = $businessstartdateArr[2].'-'.$businessstartdateArr[0].'-'.$businessstartdateArr[1];
            $jsonTextArr['workinghour'] = $this->security->xss_clean(trim($data['workinghour']));
        }elseif($data['step'] == 3){
            //$jsonTextArr['avgrevenue'] = $this->security->xss_clean(trim($data['avgrevenue']));
            //$jsonTextArr['avgprofit'] = $this->security->xss_clean(trim($data['avgprofit']));
            $jsonTextArr['monetization'] = $this->security->xss_clean(trim($data['monetization']));
            //$jsonTextArr['recurringrevenue'] = $this->security->xss_clean(trim($data['recurringrevenue']));
        }elseif($data['step'] == 4){
            $jsonTextArr['uniquevisiors'] = $this->security->xss_clean(trim($data['uniquevisiors']));
            $jsonTextArr['onlinefollowers'] = $this->security->xss_clean(trim($data['onlinefollowers']));
            $jsonTextArr['revenuechannels'] = $this->security->xss_clean(trim($data['revenuechannels']));
            //$jsonTextArr['trackingaddeddate'] = $this->security->xss_clean(trim($data['trackingaddeddate']));
        }elseif($data['step'] == 5){
            $jsonTextArr['avgrevenue'] = $this->security->xss_clean(trim($data['avgrevenue']));
            $jsonTextArr['avgprofit'] = $this->security->xss_clean(trim($data['avgprofit']));
            $jsonTextArr['recurringrevenue'] = $this->security->xss_clean(trim($data['recurringrevenue']));
        }
        $User = $data['clientId'];
        
        

        $this->user_model->valuebusinesstemp(json_encode($jsonTextArr),$User,$listingid);
        $this->response([
            'status' => TRUE,
            'message' => '',
            'data' => $jsonTextArr
        ], REST_Controller::HTTP_OK);

    }


    function generatelistingId(){
        $listingId = substr(str_shuffle(RANDOM_CHAR_NUM), 0, 7);

        $this->db->select('id', FALSE);
        $this->db->from(TABLE_PREFIX.'sell_business_temp', FALSE);
        $this->db->where('listing_id', $listingId);      
        $this->db->limit(1);      
        $Query = $this->db->get();
        $sellrec = $Query->row();
        if($sellrec->id>0)
        {
            return $this->generatelistingId();
        }
        return $listingId;
    }
    public function sellrequestfinal_post(){
       
        $data = $this->input->post();
        $User = $data['clientId'];
        $paymentAmount = $data['paymentAmount'];
        
        $this->db->select('id', FALSE);
        $this->db->from(TABLE_PREFIX.'sell_business_temp', FALSE);
        $this->db->where('userId', $User); 
        $this->db->where('Status', 0);    
        $this->db->where('type', 'SELL'); 
        $this->db->limit(1);      
        $Query = $this->db->get();
        $sellrec = $Query->row();

        

        if($sellrec->id>0)
        {
            $data1['listing_id'] = $this->generatelistingId();
            $data1['Status'] = 1;
            $data1['last_updated'] = date('Y-m-d H:i:s');
            if($paymentAmount>0)
            {
                $data1['paid_amount'] = $paymentAmount;
            }
            
            $this->admin_model->updateSellRequest($data1,$sellrec->id);
            
            

            $data['start'] = 0;
            $data['limit'] = 1;
            $data['requestId'] = $sellrec->id;

            //$arraysort = array();
            $sellRequests = $this->admin_model->getsellrequest($data,[]);
            
           
            $selldata = $sellRequests['sellrequests'][0];
            $user_to = $selldata['mail'];
            $user_subject = 'Your business listing application has been received - FIH.com';
            $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$selldata['fname'].'</strong>,</h6>
            <br>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Your application to sell your business with us has been received and has been submitted for processing. Once our team members review
            your request, they will provide you a decision promptly. If you need to add additional details in the mean time, your listing ID (to mention)
            is #'.$data1['listing_id'].'.</p>
            <br>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
            $sendEmail = sendEmail($user_to, $user_subject, $user_message);
            
            $site_settings = $this->admin_model->getSiteSettings();
            $user_to = $site_settings['support_email_address'];
            $user_subject = 'A business listing application has been received - FIH.com';
            $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">Admin</strong>,</h6>
            <br>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">An application to sell business has been received and has been submitted for processing.  listing ID is #'.$data1['listing_id'].'.</p>
            <br>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team</p>';
            $sendEmail = sendEmail($user_to, $user_subject, $user_message);
           
            $notificationarr['sender'] = $User;
            $notificationarr['receiver'] = 1;
            $notificationarr['notification_text'] = 'You have received a business listing request for listing #'.$data1['listing_id'].'. Please check the listing request details.';
            $notificationarr['notification_type'] = 'LISTINGREQ';
            $notificationarr['notification_type_id'] = $sellrec->id;
            $result = $this->front_model->insertnotification($notificationarr);
            
            $notificationarr['sender'] = 1;
            $notificationarr['receiver'] = $User;
            $notificationarr['notification_text'] = 'Your business listing application has been received for listing #'.$data1['listing_id'].'.';
            $notificationarr['notification_type'] = 'LISTINGREQ';
            $notificationarr['notification_type_id'] = $sellrec->id;
            $result = $this->front_model->insertnotification($notificationarr);
            
            $this->response([
                'status' => TRUE,
                'message' => '',
                'data' => $data1
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => '',
                'data' => array('No sell request found.')
            ], REST_Controller::HTTP_OK);
        }


    }

    public function registernewsletter_post(){
        $data = $this->input->post();
        $config = [
            [
                'field' => 'newsletteremail',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email',
                'errors' => [
                        'required' => 'Please enter your valid email address.',
                        'valid_email' => 'Please enter your valid email address.'
                ],
            ]

        ];
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules($config);
        if($this->form_validation->run()==FALSE){
            $errorInfo = $this->form_validation->error_array();
            $this->response([
                'status' => FALSE,
                'message' => $errorInfo['newsletteremail'],
                'data'=>$data
            ], REST_Controller::HTTP_OK);
        }
        $result = $this->front_model->insertnewsletter($data);
        if($result){
             $this->response([
            'status' => TRUE,
            'message' => 'Email successfully subscribed.',
            'data' => $data
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
            'status' => false,
            'message' => 'Email already subscribed with us. Please select another email address.',
            'data' => $data
            ], REST_Controller::HTTP_OK);
        }
        
    }

    public function updateProfile_post(){
        
        $data = $this->input->post();
        $config = [
            [
                'field' => 'fname',
                'label' => 'Name',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter your Name.',
                ],
            ], [
                'field' => 'phone',
                'label' => 'phone',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter your phone number.',
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

        $result = $this->user_model->updateuserprofile($data);
        $this->response([
                'status' => TRUE,
                'message' => '',
                'data' => 'Profile Successfully updated.'
            ], REST_Controller::HTTP_OK);
    }
    public function getProfile_post(){
        
        $data = $this->input->post();
        $result = $this->user_model->getuserprofile($data);
        $getDigiSign = $this->user_model->getUserDigiSign($data['userId']);
        $this->response([
                'status' => TRUE,
                'message' => '',
                'data' => $result,
                'digiSign' => $getDigiSign,
            ], REST_Controller::HTTP_OK);
    }

    public function updateuserpasswprd_post(){
        $data = $this->input->post();
        $old_pass = $data['old_pass'];
        $new_pass = $data['new_pass'];
        $confirm_pass = $data['confirm_pass'];
        $session_id = $data['user_id'];

        $que=$this->front_model->getAdminDetails($session_id);
        if(password_verify($old_pass,$que['password']) && $new_pass==$confirm_pass)
        {
            $this->admin_model->change_pass($session_id,$new_pass);
            //$this->session->set_flashdata('change_password_success', 'Password Changed Successfully!!');
            $this->response([
                'status' => true,
                'message' => 'Password Changed Successfully!!',
                'data' => $data
            ], REST_Controller::HTTP_OK);
        }
        else if(!password_verify($old_pass,$que['password']))
        {
            $this->response([
                'status' => false,
                'message' => 'Old Password And Provided Password Does Not Match!!',
                'data' => $data
            ], REST_Controller::HTTP_OK);
            //$this->session->set_flashdata('change_password_error', 'Old Password And Provided Password Does Not Match!!');
        }
        else if($new_pass!=$confirm_pass)
        {
            //$this->session->set_flashdata('change_password_error', 'New Password And Confirm Password Does Not Match!!');
            $this->response([
                'status' => false,
                'message' => 'New Password And Confirm Password Does Not Match!!',
                'data' => $data
            ], REST_Controller::HTTP_OK);
        }

        
    }

    public function updateprofilepicture_post(){
        $data = $this->input->post();
        $filename = $data['user_id'].'_profileimage.jpg';
        $uploadPath = "./uploads/profile_pictures/".$filename;
        //$im = imagecreatefromstring($data['imageContent']);
        
        //imagejpeg($im,$uploadPath,100);
        file_put_contents($uploadPath,base64_decode($data['imageContent']));
        $dataUpdate['clientId'] = $data['user_id'];
        $dataUpdate['user_profile_pic'] = $filename;
        $result = $this->user_model->updateuserprofile($dataUpdate);
        $this->response([
            'status' => false,
            'message' => 'Profile picture updated successfully.',
            'data' => '',
        ], REST_Controller::HTTP_OK);
		
    }

    public function userVerification_post(){
        $data = $this->input->post();
        $dataUpdate['clientId'] = $data['user_id'];
        
        //$dataUpdate['fname'] = $this->security->xss_clean(trim($data['username']));
        //$dataUpdate['dob'] = $this->security->xss_clean(trim($data['dob']));
        
        $dataUpdateDetails['persona_verification_id'] = $this->security->xss_clean(trim($data['personainquiryId']));
        $dataUpdateDetails['IdentrityProof'] = $this->security->xss_clean(trim($data['IdentrityProof']));
        $dataUpdateDetails['IdentrityProofNumber'] = $this->security->xss_clean(trim($data['IdentrityProofNumber']));
        $dataUpdateDetails['IdentrityProofexpdate'] = $this->security->xss_clean(trim($data['IdentrityProofexpdate']));
        $dataUpdateDetails['verificationType'] = $this->security->xss_clean(trim($data['verificationType']));

        if($dataUpdateDetails['verificationType'] == 'online')
        {
            $verificationData = [
                'type'=>$dataUpdateDetails['verificationType'],
                'persona_verification_id' => $dataUpdateDetails['persona_verification_id']
            ];
            $identityProofStatus = 1;
            $message = 'You are successfully verified.';
        }elseif($dataUpdateDetails['verificationType'] == 'offline')
        {
            $dataUpdate['fname'] = $this->security->xss_clean(trim($data['usernameoffline']));
            $dobofflineArr = explode('/',$this->security->xss_clean(trim($data['doboffline'])));
            //$jsonTextArr['businessstartdate'] = $dobofflineArr[2].'-'.$dobofflineArr[0].'-'.$dobofflineArr[1];
            
            $dataUpdate['dob'] = $dobofflineArr[2].'-'.$dobofflineArr[0].'-'.$dobofflineArr[1];
            $config = [
                [
                    'field' => 'usernameoffline',
                    'label' => 'Name',
                    'rules' => 'trim|required',
                    'errors' => [
                            'required' => 'Please enter your Name.',
                    ],
                ],
                [
                    'field' => 'doboffline',
                    'label' => 'Date of Birth',
                    'rules' => 'trim|required',
                    'errors' => [
                            'required' => 'Please enter your date of birth.',
                    ],
                ],
                [
                    'field' => 'IdentrityProof',
                    'label' => 'Identity Proof',
                    'rules' => 'trim|required',
                    'errors' => [
                            'required' => 'Please enter your identity proof.',
                    ],
                ],
                [
                    'field' => 'IdentrityProofNumber',
                    'label' => 'Identity Proof Number',
                    'rules' => 'trim|required',
                    'errors' => [
                            'required' => 'Please enter your identity proof number.',
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
            $documentsDetails = $this->user_model->getUserDocuments($data['user_id'],'indentity');
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
                $result = $this->user_model->updateuserprofile($dataUpdate);

                //////////////////////////////////////////////
                $notificationarr['sender'] = $data['user_id'];
                $notificationarr['receiver'] = 1;
                $notificationarr['notification_text'] = $dataUpdate['fname'].' raised a manual identity approval request.';
                $notificationarr['notification_type'] = 'MANUALIDAPPROVAL';
                $notificationarr['notification_type_id'] = $data['user_id'];
                $result = $this->front_model->insertnotification($notificationarr);

                //$userInput1['userId'] = 1;
                //$getUser = $this->user_model->getuserprofile($userInput1);
                //$user_to = $getUser->mail;
                $site_settings = $this->admin_model->getSiteSettings();
                $user_to = $site_settings['support_email_address'];
                $user_subject = $dataUpdate['fname'].' raised a manual identity approval request. - FIH.com';
                $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">Admin</strong>,</h6>
                <br>
                <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">'.$dataUpdate['fname'].' raised a manual identity approval request. Please login to your super admin panel to review the details.</p>
                <br>
                <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
                <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
                $sendEmail = sendEmail($user_to, $user_subject, $user_message);

                

                /////////////////////////////////////////////

                $message = 'You are successfully uploaded identity documents.';
            }else{
                $this->response([
                    'status' => false,
                    'message' => ['Please upload Proof of identity documents.'],
                    'data' => $data
                ], REST_Controller::HTTP_OK);
            }
        }
        
        
        
        $arr['userId'] = $data['user_id'];
        $arr['identity_proof_doc'] = json_encode($verificationData);
        $arr['identity_proof_status'] = $identityProofStatus;
        $arr['identity_proof_submit_date'] = date('Y-m-d H:i:s');
        if($dataUpdateDetails['verificationType'] == 'online')
        {
            $arr['identity_proof_approve_date'] = date('Y-m-d H:i:s');
        }
        $result = $this->user_model->updateuserdetails($arr);
        $this->db->delete(TABLE_PREFIX.'proof_of_funds', array('userId' => $data['user_id'], 'doc_type'=>'indentity'));
        $this->response([
            'status' => true,
            'message' => $message,
            'data' => '',
        ], REST_Controller::HTTP_OK);
    }

    public function updateFundProof_post(){
        //ob_start();
        $data = $this->input->post();
        $filename = $data['user_id'].'_'.time().'.'.$data['fileExtention'];
        $uploadPath = "./uploads/proof_documents/".$filename;
        file_put_contents($uploadPath,base64_decode($data['imageContent']));
        //$documentsDetails = $this->user_model->getUserDocuments($data['user_id']);
        
        
        $documents = $filename;
        $action = 'add';
        $dataUpdate['userId'] = $data['user_id'];
        $dataUpdate['documents'] = $documents;
        $dataUpdate['doc_type'] = 'fund';
        $result = $this->user_model->userdocumentproof($dataUpdate,$action);
        $this->response([
            'status' => true,
            'message' => 'Files uploaded successful.',
            'data' => '',
        ], REST_Controller::HTTP_OK);
        
    }
    
    public function updateIndentityProof_post(){
        //ob_start();
        $data = $this->input->post();
        $filename = $data['user_id'].'_'.time().'.'.$data['fileExtention'];
        $uploadPath = "./uploads/proof_documents/".$filename;
        file_put_contents($uploadPath,base64_decode($data['imageContent']));
        
        $documents = $filename;
        $action = 'add';
        $dataUpdate['userId'] = $data['user_id'];
        $dataUpdate['documents'] = $documents;
        $dataUpdate['doc_type'] = 'indentity';
        $result = $this->user_model->userdocumentproof($dataUpdate,$action);
        $this->response([
            'status' => true,
            'message' => 'Files uploaded successful.',
            'data' => '',
        ], REST_Controller::HTTP_OK);
        
    }

    public function updateUserDigitalSignature_post(){
        //ob_start();
        $data = $this->input->post();
        $filename = $data['user_id'].'_digisign_'.time().'.'.$data['fileExtention'];
        $uploadPath = "./uploads/user_digital_signature/".$filename;
        file_put_contents($uploadPath,base64_decode($data['imageContent']));
        
        $documents = $filename;
        $action = 'add';
        $dataUpdate['userId'] = $data['user_id'];
        $dataUpdate['documents'] = $documents;
        $dataUpdate['doc_type'] = 'digisign';
        $result = $this->user_model->userdocumentproof($dataUpdate,$action);
        $this->response([
            'status' => true,
            'message' => 'Files uploaded successful.',
            'data' => '',
        ], REST_Controller::HTTP_OK);
        
    }

    public function updateFundProofFinal_post(){
        $data = $this->input->post();
        $documentsDetails = $this->user_model->getUserDocuments($data['user_id'],'fund');
        $documenttypes = json_decode($data['proof'],true);
        if(is_array($documenttypes) && count($documenttypes)>0 && $data['verificationTypeFund'] == 'offline')
        {
        }elseif($data['verificationTypeFund'] == 'online'){
        }else{
            $this->response([
                'status' => false,
                'message' => 'Please select type of documents.',
                'data' => $data,
            ], REST_Controller::HTTP_OK);
        }
        if(is_array($documentsDetails) && count($documentsDetails)>0 && $data['verificationTypeFund'] == 'offline')
        {
            foreach($documentsDetails as $val)
            {
                $proofDocuments[] = $val['documents'];
            }
            
            $proofFinalArray = ['documents'=>$proofDocuments,'documentproof'=>json_decode($data['proof'],true),'mode'=>'offline'];
            $arr['userId'] = $data['user_id'];
            $arr['proof_funds'] = json_encode($proofFinalArray);
            $arr['proof_fund_status'] = 2;
            $arr['fund_proof_submit_date'] = date('Y-m-d H:i:s');
            $result = $this->user_model->updateuserdetails($arr);
            //$this->user_model->removedocdata($arr);
            $this->db->delete(TABLE_PREFIX.'proof_of_funds', array('userId' => $data['user_id'], 'doc_type'=>'fund'));
            $userInput['userId'] = $data['user_id'];
            $getUser = $this->user_model->getuserprofile($userInput);

            $notificationarr['sender'] = $data['user_id'];
            $notificationarr['receiver'] = 1;
            $notificationarr['notification_text'] = $getUser->fname.' raised a manual fund approval request.';
            $notificationarr['notification_type'] = 'MANUALFUNDAPPROVAL';
            $notificationarr['notification_type_id'] = $data['user_id'];
            $result = $this->front_model->insertnotification($notificationarr);
            //$userInput1['userId'] = 1;
            //$getUser = $this->user_model->getuserprofile($userInput1);
            $site_settings = $this->admin_model->getSiteSettings();
            $user_to = $site_settings['support_email_address'];
            ///$user_to = $getUser->mail;
            $user_subject = $getUser->fname.' raised a manual fund approval request. - FIH.com';
            $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">Admin</strong>,</h6>
            <br>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">'.$getUser->fname.' raised a manual fund approval request. Please login to your super admin panel to review the details.</p>
            <br>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
                <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
            $sendEmail = sendEmail($user_to, $user_subject, $user_message);

            $this->response([
                'status' => true,
                'message' => 'Document proof uploaded successfully.',
                'data' => '',
            ], REST_Controller::HTTP_OK);

        }elseif($data['verificationTypeFund'] == 'online'){
            $curDate = date('Y-m-d H:i:s');
            $userId = $data['user_id'];
            $acesstokensArr = explode(',',$data['accesstokens']);
            if(is_array($acesstokensArr) && count($acesstokensArr)>0)
            {
                foreach($acesstokensArr as $accesstoken)
                {
                    $url = PLAID_URL.'/accounts/balance/get';
                    // User account info
                    //$userData = $this->input->post();
                    $userData = [
                        "client_id"=>PLAID_CLIENT_ID,
                        "secret"=>PLAID_CLIENT_SECRET,
                        'access_token'=>$accesstoken
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
                    $arrData['asset_token'] = $accesstoken;
                    $arrData['fund_details'] = $result;
                    $arrData['date_added'] = date('Y-m-d H:i:s');
                    $this->admin_model->setfundhistory($arrData);
                    $resultArr[] = $arr;

                    /*$url = PLAID_URL.'/asset_report/create';
                    // User account info
                    //$userData = $this->input->post();
                    $userData = [
                        "client_id"=>PLAID_CLIENT_ID,
                        "secret"=>PLAID_CLIENT_SECRET,
                        'access_tokens'=>[$accesstoken],
                        "days_requested"=> 20,
                        'options'=>[
                            'client_report_id'=> '123'.rand(),
                            'webhook'=>PLAID_WEBHOOK,
                            'user'=>[
                                'client_user_id'=>'22',
                                'first_name'=>'Surajit',
                                'middle_name'=>'',
                                'last_name'=>'Koly',
                                'email'=>'chansuro@gmail.com'
                            ]
                        ]
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
                    $assetsDetails = json_decode($result,true);
                    $asset_report_token[] = $assetsDetails['asset_report_token'];
                    $asset_report_id[] = $assetsDetails['asset_report_id'];*/
                    //$dd[] = $assetsDetails;

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
                
                
            }
            
            $userWalletBalance = $this->front_model->getwalletBalance($userId);
            //$totalAsset = $this->input->post('totalAsset');
            $proofFinalArray = ['documents'=>'','asset_report_tokens'=>$asset_report_token,'accesstokens'=>$acesstokensArr,'mode'=>'online'];
            $arruser['userId'] = $userId;
            $arruser['proof_funds'] = json_encode($proofFinalArray);
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
            $notificationarr['notification_text'] = 'Your fund proof request has been approved.';
            $notificationarr['notification_type'] = 'FUNDAPPROVE';
            $notificationarr['notification_type_id'] = $userId;
            $this->front_model->insertnotification($notificationarr);

            /*$proofFinalArray = ['documents'=>'','asset_report_tokens'=>$asset_report_token,'accesstokens'=>$acesstokensArr,'mode'=>'online'];
            $arr['userId'] = $data['user_id'];
            $arr['proof_funds'] = json_encode($proofFinalArray);
            $arr['fund_request_id'] = join(',',$asset_report_id);
            $arr['proof_fund_status'] = 2;
            $arr['fund_proof_submit_date'] = date('Y-m-d H:i:s');
            $result = $this->user_model->updateuserdetails($arr);*/
            $this->response([
                'status' => true,
                'message' => 'Document proof uploaded successfully.',
                'data' => $arr,
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Please upload Proof of fund documents.',
                'data' => $documentsDetails,
            ], REST_Controller::HTTP_OK);
        }
       
    }

    public function reverifyproofoffund_post(){
        $data = $this->input->post();
        $arr['userId'] = $data['user_id'];
        $arr['proof_funds'] = '';
        $arr['proof_fund_status'] = 0;
        $arr['fund_proof_submit_date'] = null;
        $result = $this->user_model->updateuserdetails($arr);
        $this->response([
            'status' => true,
            'message' => '',
            'data' => '',
        ], REST_Controller::HTTP_OK);
    }

    public function buyerfaq_post(){
        $data = $this->input->post();
        $result = $this->front_model->get_faq_buyer($data);
        $this->response([
            'status' => true,
            'message' => '',
            'post' => $data,
            'data' => $result,
        ], REST_Controller::HTTP_OK);
    }

    public function sellerfaq_post(){
        $data = $this->input->post();
        $result = $this->front_model->get_faq_seller($data);
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $result,
        ], REST_Controller::HTTP_OK);
    }

    public function sellerfaqReply_post(){
        $data = $this->input->post();
        $arr['id'] = $data['qId'];
        $arr['seller_reply'] = $data['sellerReply'];
        $arr['Status'] = 2;
        $arr['reply_date'] = date('Y-m-d H:i:s');
        $result = $this->front_model->insertfaq($arr,'edit');
        
        $data['page'] = 0;
        $data['limit'] = 1;
        $data['id'] = $data['qId'];
        $data['userId'] = $data['userId'];
        $result_get = $this->front_model->get_faq_seller($data);
        $site_settings = $this->admin_model->getSiteSettings();
        $user_to = $site_settings['support_email_address'];

        $this->db->select('U.fname,U.mail,U.userId', FALSE);
        $this->db->from(TABLE_PREFIX.'faq as faq', FALSE);
        $this->db->join(TABLE_PREFIX.'sell_record as BaseTbl', 'faq.listing_id=BaseTbl.listing_id');
        $this->db->join(TABLE_PREFIX.'users as U','U.userId=BaseTbl.userId');
        $this->db->where('faq.id', $data['qId']);
        $this->db->limit(1);
        $query = $this->db->get();        
        $userDetails = $query->row();

        //$userDetails = $this->front_model->userDetailswrtlistingno($arr['listing_id']);
        $notificationarr['sender'] = $userDetails->userId;
        $notificationarr['receiver'] = 1;
        $notificationarr['notification_text'] = 'You have received FAQ Reply from seller.';
        $notificationarr['notification_type'] = 'FAQREPLY';
        $notificationarr['notification_type_id'] = $data['qId'];
        $result = $this->front_model->insertnotification($notificationarr);
        
        $user_subject = $result_get[0]['fname'].' Replied on listing #'.$result_get[0]['listing_id'].' - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">Admin</strong>,</h6>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">'.$result_get[0]['fname'].' Replied on listing #'.$result_get[0]['listing_id'].'. Please check the reply and approve it to display at listing details page.</p>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
        $sendEmail = sendEmail($user_to, $user_subject, $user_message);
        $this->response([
            'status' => true,
            'message' => 'Seller replied successfully.',
            'data' => $result_get,
        ], REST_Controller::HTTP_OK);
    }

    public function sellercuratedcontents_post(){
        $data = $this->input->post();
        $result_get = $this->front_model->get_curated_contents_seller($data);
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $result_get,
        ], REST_Controller::HTTP_OK);
    }
    public function sellergetoffers_post(){
        $data = $this->input->post();
        $offerDetails = $this->front_model->getOfferDetails($data);
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $offerDetails,
        ], REST_Controller::HTTP_OK);
    }

    public function buyergetoffers_post(){
        $data = $this->input->post();
        $offerDetails = $this->front_model->getbuyerOfferDetails($data);
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $offerDetails,
        ], REST_Controller::HTTP_OK);
    }

    public function approveOffer_post(){
        $data = $this->input->post();
        $offerDetails = $this->front_model->approveoffedr($data);
        $dataoffer['page'] = 0;
        $dataoffer['limit'] = 1;
        $dataoffer['id'] = $data['offerId'];
        $dataoffer['userId'] = $data['clientId'];
        $offerDetails = $this->front_model->getOfferDetails($dataoffer);

        $notificationarr['sender'] = $data['clientId'];
        $notificationarr['receiver'] = $offerDetails['record'][0]['buyeruserId'];
        $notificationarr['notification_text'] = 'Your offer for listing #'.$offerDetails['record'][0]['listing_id'].' has been approved but payment is needed.';
        $notificationarr['notification_type'] = 'OFFERAPPROVE';
        $notificationarr['notification_type_id'] = $data['offerId'];
        $result = $this->front_model->insertnotification($notificationarr);
        
        /*$notificationarr['sender'] = $data['clientId'];
        $notificationarr['receiver'] = 1;
        $notificationarr['notification_text'] = 'Offer for listing #'.$offerDetails['record'][0]['listing_id'].' is approved.';
        $notificationarr['notification_type'] = 'OFFERAPPROVE';
        $notificationarr['notification_type_id'] = $data['offerId'];
        $result = $this->front_model->insertnotification($notificationarr);
        */
        $record = $offerDetails['record'];
        $user_to = $offerDetails['record'][0]['mail'];
        $user_subject = 'Your offer for listing #'.$offerDetails[0]['listing_id'].' has been approved by seller - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$offerDetails['record'][0]['fmane'].'</strong>,</h6>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Congrats! Your offer for listing #'.$offerDetails['record'][0]['listing_id'].' has been accepted by seller. Please make a wire transfer payment within 72 hours to
        finalize your purchase.</p>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
        $sendEmail = sendEmail($user_to, $user_subject, $user_message);

        $this->response([
            'status' => true,
            'message' => 'Offer successfully Approved.',
            'data' => $record,
        ], REST_Controller::HTTP_OK);
    }
    public function rejectOffer_post(){
        $data = $this->input->post();
        $offerDetails = $this->front_model->rejectoffedr($data);
        $dataoffer['page'] = 0;
        $dataoffer['limit'] = 1;
        $dataoffer['id'] = $data['offerId'];
        $dataoffer['userId'] = $data['clientId'];
        $offerDetails = $this->front_model->getOfferDetails($dataoffer);

        $notificationarr['sender'] = $data['clientId'];
        $notificationarr['receiver'] = $offerDetails['record'][0]['buyeruserId'];
        $notificationarr['notification_text'] = 'Your offer for listing #'.$offerDetails['record'][0]['listing_id'].' has been rejected but payment is needed.';
        $notificationarr['notification_type'] = 'OFFERAPPROVE';
        $notificationarr['notification_type_id'] = $data['offerId'];
        $result = $this->front_model->insertnotification($notificationarr);
        
        /*$notificationarr['sender'] = $data['clientId'];
        $notificationarr['receiver'] = 1;
        $notificationarr['notification_text'] = 'Offer for listing #'.$offerDetails['record'][0]['listing_id'].' is approved.';
        $notificationarr['notification_type'] = 'OFFERAPPROVE';
        $notificationarr['notification_type_id'] = $data['offerId'];
        $result = $this->front_model->insertnotification($notificationarr);
        */
        $record = $offerDetails['record'];
        $user_to = $offerDetails['record'][0]['mail'];
        $user_subject = 'Your offer for listing #'.$offerDetails[0]['listing_id'].' has been rejected by seller - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$offerDetails['record'][0]['fmane'].'</strong>,</h6>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Your offer for listing #'.$offerDetails['record'][0]['listing_id'].' has been rejected by seller.</p>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
        $sendEmail = sendEmail($user_to, $user_subject, $user_message);

        $this->response([
            'status' => true,
            'message' => 'Offer successfully Rejected.',
            'data' => $record,
        ], REST_Controller::HTTP_OK);
    }

    public function getnotifications_post(){
        $data = $this->input->post();
        $notificationDetails = $this->front_model->usernotifications($data);

        $this->response([
            'status' => true,
            'message' => '',
            'data' => $notificationDetails,
        ], REST_Controller::HTTP_OK);
    }

    public function deletenotifications_post(){
        $data = $this->input->post();
        $this->front_model->deleteusernotifications($data);

        $this->response([
            'status' => true,
            'message' => 'Notification deleted successfully.',
            'data' => $data,
        ], REST_Controller::HTTP_OK);
    }

    public function individual_curated_content_post(){
        $data = $this->input->post();
        $contents = $this->front_model->getcuratedcontents($data);

        $this->response([
            'status' => true,
            'message' => '',
            'data' => $contents,
        ], REST_Controller::HTTP_OK);
    }

    public function curated_contents_post(){
        $data = $this->input->post();
        //$contents = $this->front_model->getallcuratedcontents($data);

        $this->response([
            'status' => true,
            'message' => '',
            'data' => $contents,
        ], REST_Controller::HTTP_OK);
    }

    public function sellerfreecontents_post(){
        $data = $this->input->post();
        $data['area'] = 'SELLER';
        $contents = $this->front_model->sellerfreecontents($data);

        $this->response([
            'status' => true,
            'message' => '',
            'data' => $contents,
        ], REST_Controller::HTTP_OK);
    }
    public function buyerfreecontents_post(){
        $data = $this->input->post();
        $data['area'] = 'BUYER';
        $contents = $this->front_model->sellerfreecontents($data);

        $this->response([
            'status' => true,
            'message' => '',
            'data' => $contents,
        ], REST_Controller::HTTP_OK);
    }
    public function blogCategories_post(){
        $data = $this->input->post();
        $blogcategories = $this->front_model->getblogcategories($data);

        $this->response([
            'status' => true,
            'message' => '',
            'data' => $blogcategories,
        ], REST_Controller::HTTP_OK);
    }

    public function blogs_post(){
        $data = $this->input->post();
        $blogs = $this->front_model->getblogs($data);

        $this->response([
            'status' => true,
            'message' => '',
            'data' => $blogs,
        ], REST_Controller::HTTP_OK);
    }
    public function blogcatpost_post(){
        $data = $this->input->post();
        $blogs = $this->front_model->getcatblogs($data);

        $this->response([
            'status' => true,
            'message' => '',
            'data' => $blogs,
        ], REST_Controller::HTTP_OK);
    }


    public function blogsDetails_post(){
        $data = $this->input->post();
        $blogsDetails = $this->front_model->getblogsdetails($data);

        $this->response([
            'status' => true,
            'message' => '',
            'data' => $blogsDetails,
        ], REST_Controller::HTTP_OK);
    }
    public function blogcuratedDetails_post(){
        $data = $this->input->post();
        $blogsDetails = $this->front_model->getblogcurateddetails($data);

        $this->response([
            'status' => true,
            'message' => '',
            'data' => $blogsDetails,
        ], REST_Controller::HTTP_OK);
    }

    public function valuationInputs_post(){
        $data = $this->input->post();
        $valuationInputDetails = $this->front_model->getvaluationinputs($data);
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $valuationInputDetails,
        ], REST_Controller::HTTP_OK);
    }

    public function valuationBusiness_post(){
        $data = $this->input->post();
        /*$this->response([
            'status' => true,
            'message' => '',
            'data' => [$data],
        ], REST_Controller::HTTP_OK);*/

        $profit = ($data['avgprofit']*12);
        $revenueEntered = $data['avgrevenue'];
        $monetization = $data['monetization'];
        $listingid = $data['listingid'];
        $clientId = $data['clientId'];
        $getmonitizationRange = $this->front_model->getmonitizationRange($monetization);
        $questions = json_decode($data['questions'],true);
        $netPercentage = 0;

        //
        $businessstartdate = $data['businessstartdate'];
        $curDate = date('Y-m-d');
        $q = "SELECT TIMESTAMPDIFF(MONTH, '$businessstartdate', '$curDate') as monthCount";
        $query = $this->db->query($q);    
        $Array = $query->result_array();
        $questions[2] = $Array[0]['monthCount'];
        $questions[3] = $data['workinghour'];
        $questions[1] = $data['uniquevisiors'];
        $questions[4] = $data['revenuechannels'];
        $questions[6] = $data['onlinefollowers'];
        $questions[7] = $data['recurringrevenue'];
        $questions[5] = ($data['avgprofit']/$data['avgrevenue'])*100;
        
        if(is_array($questions) && count($questions)>0)
        {
            foreach($questions as $k=>$v)
            {
                $questionDetails = $this->front_model->getValuationQuestions($k);
                $QData = $questionDetails[0];
                if($v>=$QData['high_range'])
                {
                    $grossPercentage = 100;
                }elseif($v<=$QData['low_range'])
                {
                    $grossPercentage = 0;
                }else{
                    //$grossPercentage = ($v/$QData['high_range'])*100;
                    $grossPercentage = (100/$QData['high_range']) * $v;
                }
                
                if($QData['value_type'] == 'higher' && $QData['range_type'] == 'higher')
                {
                    //$netPercentage = $netPercentage+$grossPercentage;
                }elseif($QData['value_type'] == 'higher' && $QData['range_type'] == 'lower')
                {
                    $grossPercentage = 100-$grossPercentage;
                }elseif($QData['value_type'] == 'lower' && $QData['range_type'] == 'higher')
                {
                    $grossPercentage = 100-$grossPercentage;
                }
                $indiQuesPercentage = ($grossPercentage/100)*$QData['worth'];

                $netPercentage = $netPercentage+$indiQuesPercentage;
                $QData['gross'] = $grossPercentage;
                $QData['net'] = $netPercentage;
                $QData['answergiven'] = $v;
                $questionArr[] = $QData;
                if($QData['factor'] == 'AGE')
                {
                    $businessage = $v;
                }elseif($QData['factor'] == 'TIME')
                {
                    $hourworked = $v;
                }elseif($QData['factor'] == 'TRAFFIC')
                {
                    $visitor = $v;
                }elseif($QData['factor'] == 'REVENUE')
                {
                    $revenue = $v;
                }elseif($QData['factor'] == 'PROFITRATIO')
                {
                    $profitratio = $v;

                }elseif($QData['factor'] == 'FOLLOWERS')
                {
                    $follower = $v;
                }elseif($QData['factor'] == 'REPEATCUST')
                {
                    $returningCustomer = $v;
                }

            }

            if($netPercentage <= 0)
            {
                $multiple = $getmonitizationRange->low_multiple;
            }elseif($netPercentage >= 100)
            {
                $multiple = $getmonitizationRange->high_multiple;
            }else
            {
                $range = $getmonitizationRange->high_multiple-$getmonitizationRange->low_multiple;
                $rangeevaluation = ($range/100)*$netPercentage;

                $multiple = $getmonitizationRange->low_multiple+$rangeevaluation;




                $getmonitizationRange->range = $range;
                $getmonitizationRange->rangeevaluation = $rangeevaluation;
                $getmonitizationRange->netPercentage = $netPercentage;
                $getmonitizationRange->businessmultiple = $multiple;
                $highermultiple = $multiple+0.75;
                $lowermultiple = $multiple-0.75;
                $getmonitizationRange->businessmultiplehigher = $highermultiple;
                $getmonitizationRange->businessmultiplelower = $lowermultiple;
                if($data['avgprofit'] < 0)
                {
                    $getmonitizationRange->businessValue = $revenueEntered*$multiple;
                    $getmonitizationRange->businessValuehigher = $revenueEntered*$highermultiple;
                    $getmonitizationRange->businessValuelower = $revenueEntered*$lowermultiple;
                }else{
                    $getmonitizationRange->businessValue = $profit*$multiple;
                    $getmonitizationRange->businessValuehigher = $profit*$highermultiple;
                    $getmonitizationRange->businessValuelower = $profit*$lowermultiple;
                }
                
                $getmonitizationRange->businessage = $businessage;
                $getmonitizationRange->hourworked = $hourworked;
                $getmonitizationRange->visitor = $visitor;
                $getmonitizationRange->revenue = $revenue;
                $getmonitizationRange->profitratio = number_format($profitratio,2);
                //$getmonitizationRange->profitpercentage = ($data['avgrevenue']/$data['avgprofit']);
                $getmonitizationRange->follower = $follower;
                $getmonitizationRange->returningCustomer = $returningCustomer;
                $getmonitizationRange->avgrevenue = $data['avgrevenue'];
                $getmonitizationRange->avgprofit = $data['avgprofit'];

            }
        }
        if($clientId>0)
        {
        }else{
            $clientId = 0;
        }
            $arr['multiple'] = $multiple;
            $arr['highermultiple'] = $highermultiple;
            $arr['lowermultiple'] = $lowermultiple;
            $arr['profit'] = $profit;
            $arr['range'] = $range;
            $arr['rangeevaluation'] = $rangeevaluation;

            $valuationDetails = $this->front_model->updatevaluationlisting($listingid,$clientId,$arr);
            
        //}
        
        $this->response([
            'status' => true,
            'message' => '',
            'data' => [$questionArr,$getmonitizationRange,$questions,$data,$valuationDetails],
        ], REST_Controller::HTTP_OK);
    }

    public function valuationList_post(){
        $data = $this->input->post();
        $userId = $data['userId'];
        $valuationListing = $this->user_model->getvaluationlisting($userId);
        
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $valuationListing,
        ], REST_Controller::HTTP_OK);
    }

    public function previouslysoldbusiness_post(){
        $data = $this->input->post();
        $monetization1 = $data['monetization'];

        $getsoldRecord = $this->front_model->getsoldrecord($monetization);
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $getsoldRecord,
        ], REST_Controller::HTTP_OK);
    }

    public function partners_post(){
        $data = $this->user_model->getpartnerts();
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $data,
        ], REST_Controller::HTTP_OK);
    }

    public function contactUs_post(){
        $data = $this->input->post();
        $config = [
            [
                'field' => 'fname',
                'label' => 'fname',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter your name.',
                ],
            ],
            [
                'field' => 'mail',
                'label' => 'mail',
                'rules' => 'trim|required|valid_email',
                'errors' => [
                        'required' => 'Please enter your valid email address.',
                ],
            ],
            [
                'field' => 'phone',
                'label' => 'phone',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter your valid phone No.',
                ],
            ],
            [
                'field' => 'message',
                'label' => 'message',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter your message.',
                ],
            ],

        ];
        $captcha = $this->input->post('g-recaptcha-response');
        $secret_key = RECAPTCHA_SECRET_KEY;
		$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode(RECAPTCHA_SECRET_KEY) .  '&response=' . urlencode($captcha);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_REFERER, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($ch);
		curl_close($ch);
		$response_data = json_decode($response,true);
		

        $this->form_validation->set_data($data);
        $this->form_validation->set_rules($config);
        $messageArr = $this->form_validation->error_array();
		
        if($this->form_validation->run()==FALSE){
            $msgArr = $this->form_validation->error_array();
            if(!$response_data['success'])
            {
                $msgArr['captcha'] = 'Captcha validation failed.';
            }
            $this->response([
                'status' => FALSE,
                'message' => $msgArr,
                'data'=>$data
            ], REST_Controller::HTTP_OK);
        }elseif(!$response_data['success'])
        {
            $msgArr['captcha'] = 'Captcha validation failed.';
            $this->response([
                'status' => FALSE,
                'message' => $msgArr,
                'data'=>$data
            ], REST_Controller::HTTP_OK);
        }

        $Adddata['name'] = $this->security->xss_clean(trim($data['fname']));
        $Adddata['email'] = $this->security->xss_clean(trim($data['mail']));
        $Adddata['phone'] = $this->security->xss_clean(trim($data['phone']));
        $Adddata['message'] = $this->security->xss_clean(trim($data['message']));

        $contactus = $this->user_model->insertcontactus($Adddata);
        $site_settings = $this->admin_model->getSiteSettings();

        $user_to = $site_settings['support_email_address'];
        $user_subject = 'Contact us - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">Admin</strong></h6>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Someone want to contact you. Below is the description added<br>
        Name:  '.$Adddata['name'].'<br>
        Email: '. $Adddata['email'].'<br>
        Phone: '.$Adddata['phone'].'<br>
        Message: '.$Adddata['message'].'<br></p>

        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Best regards.</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
        $sendEmail = sendEmail($user_to, $user_subject, $user_message);

        $notificationarr['sender'] = 0;
        $notificationarr['receiver'] = 1;
        $notificationarr['notification_text'] = 'Contact us request received. .';
        $notificationarr['notification_type'] = 'CONTACTUS';
        $notificationarr['notification_type_id'] = $contactus;
        $result = $this->front_model->insertnotification($notificationarr);

        $this->response([
            'status' => true,
            'message' => '',
            'data'=>$data
        ], REST_Controller::HTTP_OK);
    }

    public function createTicketAction_post(){
        //$data = $this->user_model->getvaluationlisting($userId);
        $data = $this->input->post();
        $config = [
            [
                'field' => 'subject',
                'label' => 'Subject',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter Ticket Subject.',
                ],
            ],
            [
                'field' => 'message',
                'label' => 'Password',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter your Ticket Details.',
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
        $subject = $this->security->xss_clean(trim($data['subject']));
        $message = $this->security->xss_clean(trim($data['message']));
        $generalSettings = $this->admin_model->getSiteSettings();
        $SuppoerTicketNo = $generalSettings['support_ticket_no'];
        $formatedSupportNo = 'FIH-'.date('dmY').'-'.str_pad($SuppoerTicketNo, 5, '0', STR_PAD_LEFT);
        $dataInsert['userId'] = $data['clientId'];
        $dataInsert['userid_to'] = 1;
        $dataInsert['subject'] = $subject;
        $dataInsert['message'] = $message;
        $dataInsert['ticket_no'] = $formatedSupportNo;
        $dataInsert['type'] = 'NEW';
        $dataInsert['user_read'] = 'Y';
        $dataInsert['admin_read'] = 'N';

        $ticketId = $this->user_model->insertticket($dataInsert);

        $this->db->set('reply_ticket_id', $ticketId);
        $this->db->where('id', $ticketId);
        $this->db->update(TABLE_PREFIX.'ticketing');

        $this->db->set('support_ticket_no', $SuppoerTicketNo+1);
        $this->db->where('id', '1');
        $this->db->update(TABLE_PREFIX.'site_settings');

        $userInput['userId'] = $data['clientId'];
        $getUser = $this->user_model->getuserprofile($userInput);

        $user_to = $getUser->mail;
        $user_subject = 'You have successfully raised a support ticket - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$getUser->fname.'</strong>,</h6>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Your support ticket has been raised successfully. Your support ticket is <strong>#'.$formatedSupportNo.'</strong> </p>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
        $sendEmail = sendEmail($user_to, $user_subject, $user_message);

        $notificationarr['sender'] = $data['clientId'];
        $notificationarr['receiver'] = 1;
        $notificationarr['notification_text'] = 'You have received a support ticket <strong>#'.$formatedSupportNo.'</strong>.';
        $notificationarr['notification_type'] = 'SUPPORTTICKET';
        $notificationarr['notification_type_id'] = $ticketId;
        $result111 = $this->front_model->insertnotification($notificationarr);

        //$userInput1['userId'] = 1;
        //$getUser = $this->user_model->getuserprofile($userInput1);
        $site_settings = $this->admin_model->getSiteSettings();
        $user_to = $site_settings['support_email_address'];
        $user_subject = 'You have received a support ticket -  FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">Admin</strong>,</h6>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">You have received a support ticket <strong>#'.$formatedSupportNo.'</strong>. </p>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
        $sendEmail = sendEmail($user_to, $user_subject, $user_message);

        
        
        $this->response([
            'status' => true,
            'message' => 'Ticket successfully created.',
            'data' => $dataInsert,
        ], REST_Controller::HTTP_OK);
    }

    public function supportTicketAction_post()
    {
        $data = $this->input->post();


        $sellRequests = $this->user_model->getusertickets($data);
        $this->response([
            'status' => true,
            'message' => 'Ticket successfully created.',
            'data' => $sellRequests,
        ], REST_Controller::HTTP_OK);
    }
    
    public function supportTicketDetails_post()
    {
        $data = $this->input->post();
        $ticketid = $data['ticket'];
        $user = $data['userId'];
        $ticketDetails = $this->user_model->getTicketDetails($ticketid,$user);
        //$sellRequests = $this->user_model->getusertickets($data);
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $ticketDetails,
        ], REST_Controller::HTTP_OK);
    }

    public function supportTicketReply_post(){
        $data = $this->input->post();
        $config = [
            [
                'field' => 'userreply',
                'label' => 'Reply',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Ticket Reply is required.',
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
        $userreply = $this->security->xss_clean(trim($data['userreply']));
        $ticketId = $this->security->xss_clean(trim($data['ticketId']));
        $userId = $this->security->xss_clean(trim($data['userId']));

        $ticketDetails = $this->admin_model->getTicketDetails($ticketId);
        
        $dataInsert['userId'] = $userId;
		$dataInsert['userid_to'] = 1;
		$dataInsert['subject'] = $ticketDetails[0]['subject'];
		$dataInsert['message'] = $userreply;
		$dataInsert['type'] = 'REPLY';
		$dataInsert['reply_ticket_id'] = $ticketDetails[0]['id'];
		$dataInsert['user_read'] = 'Y';
		$dataInsert['admin_read'] = 'N';
        $dataInsert['ticket_no'] = $ticketDetails[0]['ticket_no'];
        $valuationListing = $this->user_model->insertticket($dataInsert);
        
        $userInput['userId'] = $userId;
        $getUser = $this->user_model->getuserprofile($userInput);

        $user_to = $getUser->mail;
        $user_subject = 'You have successfully replied to support ticket #'.$ticketDetails[0]['ticket_no'].' - FIH.com';

        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$getUser->fname.'</strong></h6>
        <br><br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">You successfully replied on support ticket #'.$ticketDetails[0]['ticket_no'].'. We will get back to you shortly. </p>
        <br><br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
        $sendEmail = sendEmail($user_to, $user_subject, $user_message);
        
        //$userInput1['userId'] = 1;
        //$getUser = $this->user_model->getuserprofile($userInput1);

        //$user_to = $getUser->mail;
        $site_settings = $this->admin_model->getSiteSettings();
        $user_to = $site_settings['support_email_address'];
        $user_subject = 'You have received a reply on  support ticket #'.$ticketDetails[0]['ticket_no'].' - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$getUser->fname.'</strong>,</h6>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">You have received a reply on support ticket <strong>#'.$ticketDetails[0]['ticket_no'].'. We will get back to you shortly.</strong>. </p>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
        $sendEmail = sendEmail($user_to, $user_subject, $user_message);
        
        $notificationarr['sender'] = $data['userId'];
        $notificationarr['receiver'] = 1;
        $notificationarr['notification_text'] = 'You have received reply for support ticket no <strong>#'.$ticketDetails[0]['ticket_no'].'</strong> by '.$getUser->fname.'. ';
        $notificationarr['notification_type'] = 'SUPPORTTICKET';
        $notificationarr['notification_type_id'] = $ticketDetails[0]['id'];
        $result111 = $this->front_model->insertnotification($notificationarr);
        
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $data,
        ], REST_Controller::HTTP_OK);
    }

    public function supportTicketClose_post(){
        $data = $this->input->post();
        $ticketId = $data['ticket'];
        $closeTicket = $this->user_model->closeticket($ticketId);
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $data,
        ], REST_Controller::HTTP_OK);
    }

    public function testimonials_post(){
        $data = $this->input->post();
        //$ticketId = $data['ticket'];
        $testimonials = $this->admin_model->gettestimonialcontent($data);
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $testimonials,
        ], REST_Controller::HTTP_OK);
    }
    public function homecontents_post(){
        $data = $this->input->post();
        //$ticketId = $data['ticket'];
        $homecontents = $this->admin_model->gethomecontent();
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $homecontents,
        ], REST_Controller::HTTP_OK);
    }
    public function bannercontents_post(){
        $data = $this->input->post();
        //$ticketId = $data['ticket'];
        $homecontents = $this->admin_model->getbanners();
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $homecontents,
        ], REST_Controller::HTTP_OK);
    }

    public function buyerswalletdetails_post(){
        $data = $this->input->post();
        $walletdetails = $this->front_model->getwalletdetails($data);
        
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $walletdetails,
        ], REST_Controller::HTTP_OK);
    }
    
    public function walletTransactionList_post(){
        $data = $this->input->post();

        //$walletdetails = $this->front_model->getwalletdetails($data);
        $data['start'] = $_POST['start'];
		$data['limit'] = $_POST['length'];
		$data['searchName'] = $_POST['searchName'];
		$data['searchByStatus'] = $_POST['searchByStatus'];
		//$data['section'] = 'WALLET';
        $data['userId'] = $data['user_id'];
		$users = $this->admin_model->getwalletbuyreq($data);
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $users,
        ], REST_Controller::HTTP_OK);
    }
    
    public function applyPromo_post(){
        $data = $this->input->post();
        
        $promocode = $this->security->xss_clean(trim($data['redeemCode']));
        $clientId = $this->security->xss_clean(trim($data['clientId']));
        $codeDetails = $this->user_model->getpromocodedetails($promocode,$clientId);
        if($codeDetails->id > 0 && $codeDetails->promotype == 'ADMIN')
        {
            $site_settings = $this->admin_model->getSiteSettings();
            $sell_business_amount = $site_settings['sell_business_amount'];

            $discount_type = $codeDetails->discount_type;
            if($discount_type == 'Percentage')
            {
                $diccountAmt = $sell_business_amount*($codeDetails->discount/100);
            }elseif($discount_type == 'Amount')
            {
                $diccountAmt = $codeDetails->discount;
            }
            $sell_business_amount_discounted = $sell_business_amount-$diccountAmt;
            $codeDetails->Sell_amount = $sell_business_amount;
            $codeDetails->discount_amount = $diccountAmt;
            $codeDetails->Sell_amount_discounted = $sell_business_amount_discounted;
            
        }elseif($codeDetails->id > 0 && $codeDetails->promotype == 'USER')
        {
            $site_settings = $this->admin_model->getSiteSettings();
            $sell_business_amount = $site_settings['sell_business_amount'];
            //$codeDetails->discount_type = 'Amount';
            $codeDetails->discount = $sell_business_amount;
            $discount_type = $codeDetails->discount_type;
            if($discount_type == 'Amount')
            {
                $diccountAmt = $codeDetails->discount;
            }
            $sell_business_amount_discounted = $sell_business_amount-$diccountAmt;
            $codeDetails->Sell_amount = $sell_business_amount;
            $codeDetails->discount_amount = $diccountAmt;
            $codeDetails->Sell_amount_discounted = $sell_business_amount_discounted;
        }
        $tempdata = $this->user_model->gettempselldata($data['clientId']);
        if($tempdata->id>0){
            $jsonText = $tempdata->data_json;
            if($jsonText!='')
            {
                $jsonTextArr = json_decode($jsonText,true);
            }else{
                $jsonTextArr = [];
            }
            
        }else{
            $jsonTextArr = [];
        }
        $jsonTextArr['promo_details'] = $codeDetails;
        $User = $data['clientId'];
        $this->user_model->sellbusinesstemp(json_encode($jsonTextArr),$User);
        //$tempdata = $this->user_model->gettempselldata($data['clientId']);
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $codeDetails,
        ], REST_Controller::HTTP_OK);
    }

    public function sellPendingApplications_post(){
        $data = $this->input->post();
        $applications = $this->user_model->getpendingapplications($data['userId'],'SELL');
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $applications,
        ], REST_Controller::HTTP_OK);
    }

    public function callschedule_post(){
        $data = $this->input->post();
        $config = [
            [
                'field' => 'callScheduleName',
                'label' => 'Name',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter your name.',
                ],
            ],
            [
                'field' => 'callSchedulePhone',
                'label' => 'Email',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter your phone No.',
                ],
            ],
            [
                'field' => 'callScheduleTime',
                'label' => 'Email',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter call schedule time.',
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
        $Adddata['user_id'] = $this->security->xss_clean(trim($data['userId']));
        $Adddata['user_name'] = $this->security->xss_clean(trim($data['callScheduleName']));
        $Adddata['user_phone'] = $this->security->xss_clean(trim($data['callSchedulePhone']));
        $Adddata['call_time'] = $this->security->xss_clean(trim($data['callScheduleTime']));
        $Adddata['note'] = $this->security->xss_clean(trim($data['callScheduleNote']));
        $applications = $this->user_model->updatecallschedule($Adddata,'add');
        $site_settings = $this->admin_model->getSiteSettings();
        $user_to = $site_settings['support_email_address'];
        $result_get = $this->user_model->getuserprofile($Adddata['user_id']);
        $user_subject = 'Call schedule request - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">Admin</strong>,</h6>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">'.$result_get->fname.' scheduled a call. Please check and approve it from the admin panel.</p>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
        $sendEmail = sendEmail($user_to, $user_subject, $user_message);

        $notificationarr['sender'] = $this->security->xss_clean(trim($data['userId']));;
        $notificationarr['receiver'] = 1;
        $notificationarr['notification_text'] = 'Call schedule request raised by '.$this->security->xss_clean(trim($data['callScheduleName'])).'.';
        $notificationarr['notification_type'] = 'CALLSHDULE';
        $notificationarr['notification_type_id'] = $applications;
        $result111 = $this->front_model->insertnotification($notificationarr);

        $this->response([
            'status' => true,
            'message' => 'Call scheduled successfully and its pending for approval.',
            'data' => $data,
        ], REST_Controller::HTTP_OK);
    }

    public function callLogHistory_post(){
        $data = $this->input->post();
        $log = $this->user_model->getcalllog($data);
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $log,
        ], REST_Controller::HTTP_OK);
    }

    public function getlendinglist_post(){
        $lendinglist = $this->front_model->getlendinglist($data);
        $lendingcontent = $this->front_model->getlendingcontent();
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $lendinglist,
            'content' => $lendingcontent,
        ], REST_Controller::HTTP_OK);
    }

    public function financingrequestaccess_post(){
        $data = $this->input->post();
        $config = [
            [
                'field' => 'available_money',
                'label' => 'available_money',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter how much money do you have available to invest in this fund.',
                ],
            ],
            [
                'field' => 'hold_period',
                'label' => 'hold_period',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter how long of a hold period are you comfortable with.',
                ],
            ],
            [
                'field' => 'name',
                'label' => 'name',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter your name.',
                ],
            ],
            [
                'field' => 'email',
                'label' => 'email',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter your valid email.',
                        'email' => 'Please enter your valid email.',
                ],
            ],
            [
                'field' => 'phone',
                'label' => 'phone',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter your valid phone number.',
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

        $site_settings = $this->admin_model->getSiteSettings();
        $user_to = $site_settings['support_email_address'];
        //$user_to = 'surajit@eclick.co.in';
        $user_subject = 'A site user raised a Fund Application - FIH.com';
        $investor = ($data['investor'] == 'Y')?'Yes':'No';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">Admin</strong>,</h6>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">A site user raised a raised a Fund Application. The information is given below.<br> 
        <strong>Are you an accredited investor?</strong> <br>'.$investor.'<br> 
        <strong>How much money do you have available to invest in this fund?</strong> <br>'.$data['available_money'].'<br>
        <strong>How long of a hold period are you comfortable with?</strong> <br>'.$data['hold_period'].'<br>
        <strong>Name:</strong> <br>'.$data['name'].'<br>
        <strong>Email:</strong> <br>'.$data['email'].'<br>
        <strong>Phone:</strong> <br>'.$data['phone'].'<br>

        <br>
        Please login to your admin panel and check the details.
        </p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
        $sendEmail = sendEmail($user_to, $user_subject, $user_message);

        $Adddata['investor'] = $data['investor'];
        $Adddata['available_money'] = $data['available_money'];
        $Adddata['hold_period'] = $data['hold_period'];
        $Adddata['name'] = $data['name'];
        $Adddata['email'] = $data['email'];
        $Adddata['phone'] = $data['phone'];

        $applications = $this->user_model->AddRequestAccess($Adddata,'add');

        $this->response([
            'status' => true,
            'message' => '',
            'data' => $data,
        ], REST_Controller::HTTP_OK);
    }

    //top form
    public function financinggetfund_post(){
        $data = $this->input->post();
        $config = [
            [
                'field' => 'funding_amount',
                'label' => 'funding_amount',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter how much funding are you looking for.',
                ],
            ],
            [
                'field' => 'BusinessUrl',
                'label' => 'BusinessUrl',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter URL of the business.',
                ],
            ],
            [
                'field' => 'phone',
                'label' => 'phone',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter your phone.',
                ],
            ],
            [
                'field' => 'email',
                'label' => 'email',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter your email.',
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

        $site_settings = $this->admin_model->getSiteSettings();
        $user_to = $site_settings['support_email_address'];
        //$user_to = 'surajit@eclick.co.in';
        $user_subject = 'A site user raised a Fund Options - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">Admin</strong>,</h6>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">A site user raised a raised a Fund Options. The information is given below.<br> 
        <strong>Are you a buyer, seller, or broker?</strong> <br>'.$data['business_owner'].'<br> 
        <strong>How much funding are you looking for?</strong> <br>'.$data['funding_amount'].'<br>
        <strong>How quickly do you need funding?</strong> <br>'.$data['timing'].'<br>
        <strong>What is the URL of the business in question?</strong> <br>'.$data['BusinessUrl'].'<br>
        <strong>Phone</strong> <br>'.$data['phone'].'<br>
        <strong>Email</strong> <br>'.$data['email'].'<br>
        <br>
        Please login to your admin panel and check the details.
        </p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
        $sendEmail = sendEmail($user_to, $user_subject, $user_message);
        $Adddata['fund_seeker'] = $data['business_owner'];
        $Adddata['amount'] = $data['funding_amount'];
        $Adddata['funding_timing'] = $data['timing'];
        $Adddata['website'] = $data['BusinessUrl'];
        $Adddata['phone'] = $data['phone'];
        $Adddata['email'] = $data['email'];

        $applications = $this->user_model->Addgetfunded($Adddata,'add');

        $this->response([
            'status' => true,
            'message' => '',
            'data' => $Adddata,
        ], REST_Controller::HTTP_OK);
    }
    public function financingfundacquisition_post(){
        $data = $this->input->post();
        $config = [
            [
                'field' => 'name',
                'label' => 'name',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter your name.',
                ],
            ],
            [
                'field' => 'phone',
                'label' => 'phone',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter your phone.',
                ],
            ],
            [
                'field' => 'email',
                'label' => 'email',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter your email.',
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

        $site_settings = $this->admin_model->getSiteSettings();
        $user_to = $site_settings['support_email_address'];
        //$user_to = 'surajit@eclick.co.in';
        $user_subject = 'A site user raised a Business acquisition - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">Admin</strong>,</h6>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">A site user raised a raised a Business acquisition. The information is given below.<br> 
        <strong>Are you an accredited investor?</strong> <br>'.$data['investory'].'<br> 
        <strong>Full Name</strong> <br>'.$data['name'].'<br>
        <strong>Street Address</strong> <br>'.$data['street'].'<br>
        <strong>Phone Number</strong> <br>'.$data['phone'].'<br>
        <strong>Email</strong> <br>'.$data['email'].'<br>
        
        <br>
        Please login to your admin panel and check the details.
        </p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
        $sendEmail = sendEmail($user_to, $user_subject, $user_message);

        $Adddata['investor'] = $data['investor'];
        $Adddata['name'] = $data['name'];
        $Adddata['street'] = $data['street'];
        $Adddata['phone'] = $data['phone'];
        $Adddata['email'] = $data['email'];
        $applications = $this->user_model->Addfundacquisition($Adddata,'add');

        $this->response([
            'status' => true,
            'message' => '',
            'data' => $data,
        ], REST_Controller::HTTP_OK);
    }
}