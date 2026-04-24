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

        if($data['step'] == 1){
            $jsonTextArr['monetization'] = explode(',',$this->security->xss_clean(trim($data['monetization'])));
        }elseif($data['step'] == 2){
            $websitestr = $data['website'];
            $websitestrArr = explode(',',$websitestr);
            $jsonTextArr['website'] = $websitestrArr;
            $jsonTextArr['businessstartdate'] = $this->security->xss_clean(trim($data['businessstartdate']));
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
            $websitestr = $data['website'];
            $websitestrArr = explode(',',$websitestr);
            $jsonTextArr['website'] = $websitestrArr;
            $jsonTextArr['businessstartdate'] = $this->security->xss_clean(trim($data['businessstartdate']));
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



    public function sellrequestfinal_post(){
        $data = $this->input->post();
        $User = $data['clientId'];
        

        $this->db->select('id', FALSE);
        $this->db->from(TABLE_PREFIX.'sell_business_temp', FALSE);
        $this->db->where('userId', $User); 
        $this->db->where('Status', 0);       
        $this->db->limit(1);      
        $Query = $this->db->get();
        $sellrec = $Query->row();
        if($sellrec->id>0)
        {
            $data1['listing_id'] = substr(str_shuffle(RANDOM_CHAR_NUM), 0, 7);
            $data1['Status'] = 1;
            $this->admin_model->updateSellRequest($data1,$sellrec->id);
            
            $data['start'] = 0;
            $data['limit'] = 1;
            $data['requestId'] = $sellrec->id;
            $sellRequests = $this->admin_model->getsellrequest($data);
            $selldata = $sellRequests['sellrequests'][0];
            $user_to = $selldata['mail'];
            $user_subject = 'Your request to sell business is successfully registered';
            $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$selldata['clientName'].'</strong></h6>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Your request to sell business is successfully registered with us. Your listing id is '.$data['listing_id'].'. One of our team member will contact you soon for further process. Please mention this listing Id while processing your sell request.</p>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Regards.</p>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">QEIP LLC.</p>';
            $sendEmail = sendEmail($user_to, $user_subject, $user_message);

            $notificationarr['sender'] = $User;
            $notificationarr['receiver'] = 1;
            $notificationarr['notification_text'] = 'You have received a business listing request for listing #'.$data1['listing_id'].'. Please check the listing request details.';
            $notificationarr['notification_type'] = 'LISTINGREQ';
            $notificationarr['notification_type_id'] = $result;
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
            ],
            [
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
            ], REST_Controller::HTTP_BAD_REQUEST);
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
        $this->response([
                'status' => TRUE,
                'message' => '',
                'data' => $result
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
		die;
		die;
    }

    public function userVerification_post(){
        $data = $this->input->post();
        $dataUpdate['clientId'] = $data['user_id'];
        
        $dataUpdate['fname'] = $this->security->xss_clean(trim($data['username']));
        $dataUpdate['dob'] = $this->security->xss_clean(trim($data['dob']));
        
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
            $dataUpdate['dob'] = $this->security->xss_clean(trim($data['doboffline']));
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
                ], REST_Controller::HTTP_BAD_REQUEST);
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
                $message = 'You are successfully uploaded identity documents.';
            }else{
                $this->response([
                    'status' => false,
                    'message' => ['Please upload Proof of identity documents.'],
                    'data' => $data
                ], REST_Controller::HTTP_OK);
            }
        }

        $result = $this->user_model->updateuserprofile($dataUpdate);
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
        
        //print '<pre>';
        //print_r($documentsDetails);
        //$g = ob_get_contents();
        //ob_end_flush();
        //mail('chansuro@gmail.com','QEIP LLC',$g);
        //$documents = json_decode($documentsDetails->documents,true);
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
            $this->response([
                'status' => true,
                'message' => 'Document proof uploaded successfully.',
                'data' => '',
            ], REST_Controller::HTTP_OK);

        }elseif($data['verificationTypeFund'] == 'online'){
            $acesstokensArr = explode(',',$data['accesstokens']);
            if(is_array($acesstokensArr) && count($acesstokensArr)>0)
            {
                foreach($acesstokensArr as $accesstoken)
                {
                    $url = PLAID_URL.'/asset_report/create';
                    // User account info
                    //$userData = $this->input->post();
                    $userData = [
                        "client_id"=>PLAID_CLIENT_ID,
                        "secret"=>PLAID_CLIENT_SECRET,
                        'access_tokens'=>[$accesstoken],
                        "days_requested"=> 20,
                        
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
                }
            }
            $proofFinalArray = ['documents'=>'','asset_report_tokens'=>$asset_report_token,'accesstokens'=>$acesstokensArr,'mode'=>'online'];
            $arr['userId'] = $data['user_id'];
            $arr['proof_funds'] = json_encode($proofFinalArray);
            $arr['proof_fund_status'] = 2;
            $arr['fund_proof_submit_date'] = date('Y-m-d H:i:s');
            $result = $this->user_model->updateuserdetails($arr);
            $this->response([
                'status' => true,
                'message' => 'Document proof uploaded successfully.',
                'data' => '',
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
        $arr['Status'] = 1;
        $arr['reply_date'] = date('Y-m-d H:i:s');
        $result = $this->front_model->insertfaq($arr,'edit');
        
        $data['page'] = 0;
        $data['limit'] = 1;
        $data['id'] = $data['qId'];
        $data['userId'] = $data['userId'];
        $result_get = $this->front_model->get_faq_seller($data);
        $site_settings = $this->admin_model->getSiteSettings();
        $user_to = $site_settings['helpline_email_address'];

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

        $user_subject = $result_get[0]['fname'].' Replied on listing #'.$result_get[0]['listing_id'].' - QEIP LLC';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">Admin</strong></h6>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">'.$result_get[0]['fname'].' Replied on listing #'.$result_get[0]['listing_id'].'. Please check the reply and approve it to display at listing details page.</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Best regards.</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">QEIP LLC Team.</p>';
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
        $notificationarr['notification_text'] = 'Your offer for listing #'.$offerDetails['record'][0]['listing_id'].' is approved. Please make a wire transfer payment within 72 hours to avail this offer price.';
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
        $user_subject = 'Your offer for listing #'.$offerDetails[0]['listing_id'].' is approved by seller - QEIP LLC';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$offerDetails['record'][0]['fmane'].'</strong></h6>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Your offer for listing #'.$offerDetails['record'][0]['listing_id'].' is approved by seller. Please buy now the listing.</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Best regards.</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">QEIP LLC Team.</p>';
        $sendEmail = sendEmail($user_to, $user_subject, $user_message);

        $this->response([
            'status' => true,
            'message' => 'Offer successfully Approved.',
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
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        $subject = $this->security->xss_clean(trim($data['subject']));
        $message = $this->security->xss_clean(trim($data['message']));
        $generalSettings = $this->admin_model->getSiteSettings();
        $SuppoerTicketNo = $generalSettings['support_ticket_no'];
        $formatedSupportNo = 'QEIP-'.date('dmY').'-'.str_pad($SuppoerTicketNo, 5, '0', STR_PAD_LEFT);
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
        $user_subject = 'You have successfully raised a support ticket - QEIP LLC';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$getUser->fname.'</strong></h6>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Your ticket raised successfully. Your support ticket No is <strong>#'.$formatedSupportNo.'</strong> </p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Best regards.</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">QEIP LLC Team.</p>';
        $sendEmail = sendEmail($user_to, $user_subject, $user_message);

        $userInput1['userId'] = 1;
        $getUser = $this->user_model->getuserprofile($userInput1);

        $user_to = $getUser->mail;
        $user_subject = 'You have received a support ticket - QEIP LLC';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$getUser->fname.'</strong></h6>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">You have received s support ticket no <strong>#'.$formatedSupportNo.'</strong>. </p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Best regards.</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">QEIP LLC Team.</p>';
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
            ], REST_Controller::HTTP_BAD_REQUEST);
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
        $user_subject = 'You have successfully replied a support ticket #'.$ticketDetails[0]['ticket_no'].' - QEIP LLC';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$getUser->fname.'</strong></h6>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">You successfully replied on support ticket #'.$ticketDetails[0]['ticket_no'].'. </p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Best regards.</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">QEIP LLC Team.</p>';
        $sendEmail = sendEmail($user_to, $user_subject, $user_message);

        $userInput1['userId'] = 1;
        $getUser = $this->user_model->getuserprofile($userInput1);

        $user_to = $getUser->mail;
        $user_subject = 'You have received a reply on  support ticket #'.$ticketDetails[0]['ticket_no'].' - QEIP LLC';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$getUser->fname.'</strong></h6>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">You have received a reply on support ticket <strong>#'.$ticketDetails[0]['ticket_no'].'</strong>. </p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Best regards.</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">QEIP LLC Team.</p>';
        $sendEmail = sendEmail($user_to, $user_subject, $user_message);
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
        $testimonials = $this->admin_model->gettestimonialcontent([]);
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
		$data['section'] = 'WALLET';
        $data['userId'] = $data['user_id'];
		$users = $this->admin_model->getwalletbuyreq($data);
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $users,
        ], REST_Controller::HTTP_OK);
    }

    
}