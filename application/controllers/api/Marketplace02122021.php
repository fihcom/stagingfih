<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Marketplace extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        
        // Load the user model
        $this->load->model('front_model');
        $this->load->model('admin_model');
        $this->load->model('user_model');
    }

    public function listing_post(){
        $data = $this->input->post();
        $listingId = $data['listingId'];
        
        $recomendedBusinessLoad = $data['recomendedBusinessLoad'];
        $listdata = $this->front_model->getBusinessListing($listingId);
        $industry = $listdata->industry;
        if($recomendedBusinessLoad)
        {
            $arr['start'] = 0;
            $arr['limit'] = 12;
            $arr['listingId'] = $listingId;
            $arr['industry'] = $industry;
            $arr['userId'] = $data['userId'];
            $listdata->recomendedBusiness = $this->front_model->getRecomendedListing($arr);
        }
        $this->response([
            'status' => TRUE,
            'message' => '',
            'data' => $listdata
        ], REST_Controller::HTTP_OK);
    }

    public function selectmaxminrange_post(){
        $data = $this->input->post();
        $minmaxDetails = $this->front_model->getMinMaxDetails();
        $this->response([
            'status' => TRUE,
            'message' => '',
            'data' => $minmaxDetails
        ], REST_Controller::HTTP_OK);
    }

    public function mpBuyerUnlockedListing_post(){
        $data = $this->input->post();
        $arr['start'] = $data['page'];
        $arr['limit'] = $data['limit'];
        $arr['userId'] = $data['userId'];
        //$arr['searchText'] = $this->security->xss_clean(trim($data['searchText']));
        //$arr['Monitization'] = $this->security->xss_clean(trim($data['Monitization']));
        //$arr['min'] = $this->security->xss_clean(trim($data['min']));
        //$arr['max'] = $this->security->xss_clean(trim($data['max']));
        /*if($data['Monitization'] !='')
        $arr['Monitization'] = $data['Monitization'];
        if($data['priceRange'] !='')
        $arr['priceRange'] = $data['priceRange'];*/
        
        $listdata = $this->front_model->getUserUnlockedListing($arr);

        
        $this->response([
            'status' => TRUE,
            'message' => '',
            'data' => $listdata
        ], REST_Controller::HTTP_OK);
    }

    public function mpListing_post(){
        $data = $this->input->post();
        $arr['start'] = $data['page'];
        $arr['limit'] = $data['limit'];
        $arr['userId'] = $data['userId'];
        $arr['searchText'] = $this->security->xss_clean(trim($data['searchText']));
        $arr['Monitization'] = $this->security->xss_clean(trim($data['Monitization']));
        $arr['businessAge'] = $this->security->xss_clean(trim($data['businessAge']));
        
        

        $arr['ProfitFrom'] = $this->security->xss_clean(trim($data['ProfitFrom']));
        $arr['ProfitTo'] = $this->security->xss_clean(trim($data['ProfitTo']));
        
        $arr['RevenueFrom'] = $this->security->xss_clean(trim($data['RevenueFrom']));
        $arr['RevenueTo'] = $this->security->xss_clean(trim($data['RevenueTo']));
        
        $arr['MultipleFrom'] = $this->security->xss_clean(trim($data['MultipleFrom']));
        $arr['MultipleTo'] = $this->security->xss_clean(trim($data['MultipleTo']));



        $arr['min'] = $this->security->xss_clean(trim($data['min']));
        $arr['max'] = $this->security->xss_clean(trim($data['max']));
        
        $listdata = $this->front_model->getMarketplaceListing($arr);
        
        $this->response([
            'status' => TRUE,
            'message' => '',
            'data' => $listdata
        ], REST_Controller::HTTP_OK);
    }
    public function mpRecentListing_post(){
        $data = $this->input->post();
        $arr['start'] = $data['page'];
        $arr['limit'] = $data['limit'];
        $arr['userId'] = $data['userId'];

        if($data['Monitization'] !='')
        $arr['Monitization'] = $data['Monitization'];
        if($data['priceRange'] !='')
        $arr['priceRange'] = $data['priceRange'];
        if($data['show_home'])
        {
            $arr['show_home'] = $this->security->xss_clean(trim($data['show_home']));
        }
        $listdata = $this->front_model->getRecentListing($arr);
        $this->response([
            'status' => TRUE,
            'message' => '',
            'data' => $listdata
        ], REST_Controller::HTTP_OK);
    }
    public function mpSellerListing_post(){
        $data = $this->input->post();
        $arr['start'] = $data['page'];
        $arr['limit'] = $data['limit'];
        $arr['userId'] = $data['userId'];

        if($data['Monitization'] !='')
        $arr['Monitization'] = $data['Monitization'];
        if($data['priceRange'] !='')
        $arr['priceRange'] = $data['priceRange'];
        
        $listdata = $this->front_model->getSellerListing($arr);
        
        $this->response([
            'status' => TRUE,
            'message' => '',
            'data' => $listdata
        ], REST_Controller::HTTP_OK);
    }

    public function listingUserPermission_post(){
        $data = $this->input->post();
        $permission = $this->front_model->getMarketplaceListingpermission($data);
        $this->response([
            'status' => TRUE,
            'message' => '',
            'data' => $permission
        ], REST_Controller::HTTP_OK);
    }

    public function uncoverListing_post(){
        $data = $this->input->post();
        $permission = $this->front_model->uncoverlisting($data);
        $userDetails = $this->front_model->getAdminDetails($data['userId']);
        $user_to = $userDetails['mail'];
        $user_subject = 'You successfully uncovered listing #'.$data['unlocked_business'].' - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$userDetails['fname'].'</strong>,</h6>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Congrats! You have successfully uncovered listing #'.$data['unlocked_business'].'and can view it’s full details.</p>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
        $sendEmail = sendEmail($user_to, $user_subject, $user_message);
        $this->response([
            'status' => TRUE,
            'message' => 'You have successfully uncovered this listing',
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function listingaskquestion_post(){
        $data = $this->input->post();
        $config = [
            [
                'field' => 'question',
                'label' => 'Question',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Please enter your question.',
                ],
            ],
            [
                'field' => 'listingNo',
                'label' => 'Listing No',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Listing No is required.',
                ],
            ],[
                'field' => 'user',
                'label' => 'User',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'You must login.',
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
        $arr['question'] = $this->security->xss_clean(trim($data['question']));
        $arr['listing_id'] = $this->security->xss_clean(trim($data['listingNo']));
        $arr['userId'] = $this->security->xss_clean(trim($data['user']));
        $result = $this->front_model->insertfaq($arr);
        $userDetails = $this->front_model->userDetailswrtlistingno($arr['listing_id']);

        $notificationarr['sender'] = $this->security->xss_clean(trim($data['user']));
        $notificationarr['receiver'] = $userDetails->userId;
        $notificationarr['notification_text'] = 'You have received FAQ.';
        $notificationarr['notification_type'] = 'FAQ';
        $notificationarr['notification_type_id'] = $result;
        $result = $this->front_model->insertnotification($notificationarr);
        
        $user_to = $userDetails->mail;
        $user_subject = 'You received a question for listing #'.$arr['listingId'].' - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$userDetails->fname.'</strong>,</h6>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">You received a question for listing #'.$arr['listingId'].'. Please reply to it in the FAQ section of your seller dashboard.</p>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
        $sendEmail = sendEmail($user_to, $user_subject, $user_message);

        $this->response([
            'status' => TRUE,
            'message' => 'We have received your question. We will get back to you soon.',
            'data' => $userDetails
        ], REST_Controller::HTTP_OK);
    }

    public function sellerfaq_post(){
        $data = $this->input->post();
        $datapost['page'] = $data['page'];
        $datapost['limit'] = $data['limit'];
        $datapost['listing_id'] = $data['listing_id'];
        $datapost['Status'] = $data['Status'];
        $result = $this->front_model->get_faq_seller($datapost);
        
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $result,
        ], REST_Controller::HTTP_OK);
    }

    public function submitoffers_post(){
        $data = $this->input->post();
        $config = [
            [
                'field' => 'offerPrice',
                'label' => 'offer Price',
                'rules' => 'trim|required|numeric',
                'errors' => [
                        'required' => 'Please enter your offer Price.',
                        'numeric' => 'Please enter numeric offer Price.',
                ],
            ],
            [
                'field' => 'listingNo',
                'label' => 'Listing No',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Listing No is required.',
                ],
            ],[
                'field' => 'user',
                'label' => 'User',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'You must login.',
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

        $this->db->select('BaseTbl.userId, U.fname, U.mail', FALSE);
        $this->db->from(TABLE_PREFIX.'sell_record as BaseTbl', FALSE);
        $this->db->join(TABLE_PREFIX.'users as U','U.userId=BaseTbl.userId');
        $this->db->where('BaseTbl.listing_id', $data['listingNo']);
        $query = $this->db->get();        
        $sellerDetails = $query->row();



        $dataInsrt['listing_id'] = $this->security->xss_clean(trim($data['listingNo']));
        $dataInsrt['sellerId'] = $sellerDetails->userId;
        $dataInsrt['userId'] = $this->security->xss_clean(trim($data['user']));
        $dataInsrt['offer_price'] = $this->security->xss_clean(trim($data['offerPrice']));
        $dataInsrt['offer_description'] = $this->security->xss_clean(trim($data['offerDescription']));
        $result_offer = $this->front_model->setlistingoffer($dataInsrt);

        $notificationarr['sender'] = $this->security->xss_clean(trim($data['user']));
        $notificationarr['receiver'] = $sellerDetails->userId;
        $notificationarr['notification_text'] = 'You have received an offer for listing #'.$this->security->xss_clean(trim($data['listingNo'])).'.';
        $notificationarr['notification_type'] = 'OFFER';
        $notificationarr['notification_type_id'] = $result_offer;
        $result = $this->front_model->insertnotification($notificationarr);
        
        $notificationarr['sender'] = $this->security->xss_clean(trim($data['user']));
        $notificationarr['receiver'] = 1;
        $notificationarr['notification_text'] = 'A new offer for listing #'.$this->security->xss_clean(trim($data['listingNo'])).' is submitted.';
        $notificationarr['notification_type'] = 'OFFER';
        $notificationarr['notification_type_id'] = $result_offer;
        $result = $this->front_model->insertnotification($notificationarr);

        
        $user_to = $sellerDetails->mail;
        $user_subject = 'You received a offer for listing #'.$arr['listingNo'].' - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$sellerDetails->fname.'</strong>,</h6>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Good news! You received a offer for listing #'.$data['listingNo'].'. You may accept or reject this offer in your seller dashboard.</p>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers, </p>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
        $sendEmail = sendEmail($user_to, $user_subject, $user_message);

        $this->db->select('U.fname, U.mail', FALSE);
        $this->db->from(TABLE_PREFIX.'users as U',FALSE);
        $this->db->where('U.userId', $data['user']);
        $query = $this->db->get();        
        $buyerDetails = $query->row();

        $user_to = $buyerDetails->mail;
        $user_subject = 'You have successfully submitted an offer for listing #'.$arr['listingNo'].' - FIH.com';
        $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$buyerDetails->fname.'</strong>,</h6>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Success! You have successfully submitted your offer for listing #'.$data['listingNo'].'. Be on the lookout for a response from the seller.</p>
        <br>
        <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
		<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
        $sendEmail = sendEmail($user_to, $user_subject, $user_message);


        $this->response([
            'status' => true,
            'message' => 'Offer successfully submitted.',
            'data' => $dataInsrt,
        ], REST_Controller::HTTP_OK);
    }

    public function userOffers_post(){
        $data = $this->input->post();

        $result = $this->front_model->get_user_offer($data);
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $result,
        ], REST_Controller::HTTP_OK);
    }

    public function uploadBuyDoc_post(){
        $data = $this->input->post();
        $filename = $data['user_id'].'_buydoc_'.time().'.'.$data['fileextention'];
        $uploadPath = "./uploads/buy_documents/".$filename;
        //$im = imagecreatefromstring($data['imageContent']);
        
        //imagejpeg($im,$uploadPath,100);
        file_put_contents($uploadPath,base64_decode($data['fileContent']));
        $this->response([
            'status' => true,
            'message' => '',
            'data' => $filename,
        ], REST_Controller::HTTP_OK);
    }
    function generaterefnumber(){
        $randomstring = substr(str_shuffle(RANDOM_CHAR), 0, 15);

        $this->db->select('BaseTbl.id', FALSE);
        $this->db->from(TABLE_PREFIX.'buy_request as BaseTbl', FALSE);
        $this->db->where('BaseTbl.transaction_ref', $randomstring);
        $query = $this->db->get();        
        $randomstringDetails = $query->row();
        if($randomstringDetails->id>0)
        {
            $this->generaterefnumber();
        }else{
            return $randomstring;
        }
    }
    public function submitbuy_post(){
        $data = $this->input->post();
        
        $this->db->select('BaseTbl.userId, U.fname, U.mail,BaseTbl.price', FALSE);
        $this->db->from(TABLE_PREFIX.'sell_record as BaseTbl', FALSE);
        $this->db->join(TABLE_PREFIX.'users as U','U.userId=BaseTbl.userId');
        $this->db->where('BaseTbl.listing_id', $data['listingNo']);
        $query = $this->db->get();        
        $sellerDetails = $query->row();

        /*
        $this->db->select('U.*', FALSE);
        $this->db->from(TABLE_PREFIX.'users as U', FALSE);
        $this->db->where('U.userId', $data['user_id']);
        $query = $this->db->get();        
        $BuyerDetails = $query->row();
        */
        $walletTransferAmount = 0;
        $wireTransferAmt = 0;
        $paymentMode = 'WIRETRANSFER';
        $buyStatus = 1; 

        $offerdata['user'] = $this->security->xss_clean(trim($data['user_id'])); 
        $offerdata['listingId'] = $this->security->xss_clean(trim($data['listingNo']));
        $offers = $this->front_model->get_user_offer($offerdata);
        $offer_price = $offers->offer_price;
        
        if($offer_price > 0)
        {
            //$dataInsrt['wallet_amount'] = $offer_price;
            $listingPrice = $offer_price;
        }else{
            //$dataInsrt['wallet_amount'] = $sellerDetails->price;
            $listingPrice = $sellerDetails->price;
        }
        $successMsg = 'Your buy request successfully submitted and pending for admin approval. You will be notified once your buy request is approved.';
        $transferStatus = 1;
        if($data['useWallet'] == 'Y')
        {
            $WalletBalance = $this->front_model->getwalletBalance($data['user_id']);
            //$offers = $res['data'];
            if($listingPrice > $WalletBalance)
            {
                $wireTransferAmt = $listingPrice - $WalletBalance;
                $walletTransferAmount = $WalletBalance;
                $paymentMode = 'BOTH';
            }else{
                $wireTransferAmt = 0;
                $walletTransferAmount = $listingPrice;
                $paymentMode = 'WALLET';
                $buyStatus = 2;
                $instantTransfer = 'YES';
                $transferStatus = 2;
                $successMsg = 'Your buy request successfully submitted and approved. Thank you for buying the business. You will be notified for the further proceedings of business transfer.';
            }
            $paymentDetails = '{"wallet": '.$walletTransferAmount.', "wiretransfer": '.$wireTransferAmt.'}';
        }
        
        /*if($data['imageContents'] !='')
        {
            $imagesArr = explode(',',$this->security->xss_clean(trim($data['imageContents'])));
        }*/
        $this->db->select('BaseTbl.id,BaseTbl.transaction_ref', FALSE);
        $this->db->from(TABLE_PREFIX.'buy_request as BaseTbl', FALSE);
        $this->db->where('BaseTbl.listing_id', $data['listingNo']);
        $this->db->where('BaseTbl.sellerId', $sellerDetails->userId);
        $this->db->where('BaseTbl.userId', $data['user_id']);
        $query = $this->db->get();        
        $userBuyDetails = $query->row();
        if($userBuyDetails->id >0)
        {
            $this->response([
                'status' => false,
                'message' => 'You have already sent purchase request for this listing.',
                'data' => $dataInsrt,
            ], REST_Controller::HTTP_OK);
        }else{
            /*if($userBuyDetails->id>0)
            {
                $refNumber = $userBuyDetails->transaction_ref;
            }else{
                $refNumber = $this->generaterefnumber();
            }*/
            //$sellerDetails = $this->userDetailswrtlistingno($listingNo);
            //$sellerId = $sellerDetails->userId;
            $this->db->select('BaseTbl.id,BaseTbl.transaction_ref', FALSE);
            $this->db->from(TABLE_PREFIX.'user_buy_ref as BaseTbl', FALSE);
            $this->db->where('BaseTbl.listing_id', $data['listingNo']);
            $this->db->where('BaseTbl.sellerId', $sellerDetails->userId);
            $this->db->where('BaseTbl.userId', $data['user_id']);
            $query = $this->db->get();        
            $userRefDetails = $query->row();
            $refNumber = $userRefDetails->transaction_ref;


            $dataInsrt['listing_id'] = $this->security->xss_clean(trim($data['listingNo']));
            $dataInsrt['sellerId'] = $sellerDetails->userId;
            $dataInsrt['userId'] = $this->security->xss_clean(trim($data['user_id']));
            $dataInsrt['transaction_ref'] = $refNumber;
            $dataInsrt['description'] = $this->security->xss_clean(trim($data['buyDescription']));
            $dataInsrt['images'] = json_encode($imagesArr);
            $dataInsrt['payment_mode'] = $paymentMode;
            $dataInsrt['wallet_amount'] = $walletTransferAmount;
            $dataInsrt['payment_details'] = $paymentDetails;
            $dataInsrt['transfer_status'] = $transferStatus;
            if($transferStatus == 2)
            {
                $dataInsrt['sold_date'] = date('Y-m-d H:i:s');
            }
            $dataInsrt['status'] = $buyStatus;
            /*if($this->security->xss_clean(trim($data['payThrough'])) == 'WALLET')
            {
                //////////// offers associated
                $offerdata['user'] = $this->security->xss_clean(trim($data['user_id'])); 
                $offerdata['listingId'] = $this->security->xss_clean(trim($data['listingNo']));
                $offers = $this->front_model->get_user_offer($offerdata);
                //$offers = $res['data'];
                $offer_price = $offers->offer_price;
                if($offer_price > 0)
                {
                    $dataInsrt['wallet_amount'] = $offer_price;
                }else{
                    $dataInsrt['wallet_amount'] = $sellerDetails->price;
                }
            }*/
            

            $result = $this->front_model->setlistingbuyoffer($dataInsrt);
            if($instantTransfer == 'YES')
            {
                $listingId = $dataInsrt['listing_id'];
                $updatesell['Status'] = 4;
                $this->db->where('listing_id', $listingId);
                $this->db->update(TABLE_PREFIX.'sell_record', $updatesell);
            }
            //$site_settings = $this->admin_model->getSiteSettings();
            //$user_to = $site_settings['helpline_email_address'];
            $user_subject = $BuyerDetails->fname.' raised a buy request on listing #'.$arr['listingNo'].' - FIH.com';
            $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">Admin</strong>,</h6>
            <br>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">'.$BuyerDetails->fname.' raised a buy request on listing #'.$data['listingNo'].'. Please check the Reference number <strong>'.$refNumber.'</strong> with your
            bank and approve.</p>
            <br>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
            //$sendEmail = sendEmail($user_to, $user_subject, $user_message);

            $notificationarr['sender'] = $this->security->xss_clean(trim($data['user_id']));;
            $notificationarr['receiver'] = 1;
            $notificationarr['notification_text'] = 'You received a listing buy request for listing #'.$data['listingNo'].'.';
            $notificationarr['notification_type'] = 'BUYNOWREQ';
            $notificationarr['notification_type_id'] = $result;
            $result = $this->front_model->insertnotification($notificationarr);

            $notificationarr['sender'] = $this->security->xss_clean(trim($data['user_id']));;
            $notificationarr['receiver'] = $sellerDetails->userId;
            $notificationarr['notification_text'] = 'You received a listing buy request for listing #'.$data['listingNo'].'.';
            $notificationarr['notification_type'] = 'BUYNOWREQ';
            $notificationarr['notification_type_id'] = $result;
            //$result = $this->front_model->insertnotification($notificationarr);

            $this->db->select('U.fname, U.mail', FALSE);
            $this->db->from(TABLE_PREFIX.'users as U',FALSE);
            $this->db->where('U.userId', $data['user_id']);
            $query = $this->db->get();        
            $buyerDetails = $query->row();

            $user_to = $buyerDetails->mail;
            $user_subject = 'You have successfully submitted a buy request for listing #'.$arr['listingNo'].' - FIH.com';
            $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$buyerDetails->fname.'</strong>,</h6>
            <br>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">Success! You have successfully submitted your buy request for listing #'.$data['listingNo'].'.When your full payment is registered, we will be able to
            approve your request. Your payment reference number is <strong>'.$refNumber.'</strong>.</p>
            <br>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
            $sendEmail = sendEmail($user_to, $user_subject, $user_message);

            $site_settings = $this->admin_model->getSiteSettings();
            $user_to = $site_settings['support_email_address'];
            $user_subject = $buyerDetails->fname.' raised a buy request on listing #'.$arr['listingNo'].' - FIH.com';
            $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">Admin</strong>,</h6>
            <br>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">'.$buyerDetails->fname.' raised a buy request on listing #'.$arr['listingNo'].'. Please check the Reference number <strong>'.$refNumber.'</strong> with your bank and approve.</p>
            <br>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
            $sendEmail = sendEmail($user_to, $user_subject, $user_message);


            $this->response([
                'status' => true,
                'message' => 'Your buy request successfully submitted and pending for admin approval. You will be notified once your buy request is approved.',
                'data' => $dataInsrt,
            ], REST_Controller::HTTP_OK);
        }
    }
    public function submitbuywallet_post(){
        $data = $this->input->post();
        $config = [
            [
                'field' => 'wire_transfer_ref',
                'label' => 'offer Price',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Wire Transfer Reference number is required.'
                ],
            ],
            [
                'field' => 'walletMoney',
                'label' => 'Wallet money',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Wallet money is required.'
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

        $this->db->select('BaseTbl.id,BaseTbl.transaction_ref', FALSE);
        $this->db->from(TABLE_PREFIX.'buy_request as BaseTbl', FALSE);
        //$this->db->where('BaseTbl.listing_id', $data['listingNo']);
       // $this->db->where('BaseTbl.sellerId', $sellerDetails->userId);
        $this->db->where('BaseTbl.userId', $data['user_id']);
        $this->db->where('BaseTbl.transaction_ref', $data['wire_transfer_ref']);
        $query = $this->db->get();        
        $userBuyDetails = $query->row();
        
        if($userBuyDetails->id >0)
        {
            $this->response([
                'status' => false,
                'message' => 'You have already sent purchase request for this transacrion Ref.',
                'data' => $dataInsrt,
            ], REST_Controller::HTTP_OK);
        }else{
            
            $refNumber = $data['wire_transfer_ref'];
            $walletMoney = $data['walletMoney'];
            $dataInsrt['listing_id'] = 0;
            $dataInsrt['sellerId'] = 0;
            $dataInsrt['userId'] = $this->security->xss_clean(trim($data['user_id']));
            $dataInsrt['transaction_ref'] = $refNumber;
            $dataInsrt['description'] = '';
            $dataInsrt['section'] = 'WALLET';
            $dataInsrt['images'] = '';
            $dataInsrt['wallet_amount'] = $walletMoney;
            $dataInsrt['payment_mode'] = $this->security->xss_clean(trim($data['payThrough']));

            $result123 = $this->front_model->setlistingbuyoffer($dataInsrt);
            
            $buyrref['userId'] = $this->security->xss_clean(trim($data['user_id']));
            $buyrref['sellerId'] = 0;
            $buyrref['listing_id'] = 0;
            $buyrref['transaction_ref'] = $refNumber;
            $buyrref['area'] = 'WALLET';
            $buyrref['redeemed'] = 'Y';
            $result = $this->front_model->setuserbuyref($buyrref);
            
            $this->db->select('U.fname, U.mail', FALSE);
            $this->db->from(TABLE_PREFIX.'users as U',FALSE);
            $this->db->where('U.userId', $data['user_id']);
            $query = $this->db->get();        
            $buyerDetails = $query->row();

            $user_to = $buyerDetails->mail;
            $user_subject = 'You have successfully requested to add money to your wallet  - FIH.com';
            $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$buyerDetails->fname.'</strong>,</h6>
            <br>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">You have successfully requested to add money to wallet. When we register the funds (with the correct reference number attached, we will
            approve your request). Your reference number is <strong>'.$refNumber.'</strong>.</p>
            <br>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
            $sendEmail = sendEmail($user_to, $user_subject, $user_message);

            $site_settings = $this->admin_model->getSiteSettings();
            $user_to = $site_settings['support_email_address'];
            $user_subject = $buyerDetails->fname.' raised a add money to wallet request - FIH.com';

            $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">Admin</strong>,</h6>
            <br>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">'.$buyerDetails->fname.' raised a add money to request. Please check the Reference number <strong>'.$refNumber.'</strong> with your bank and approve.</p>
            <br>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
            $sendEmail = sendEmail($user_to, $user_subject, $user_message);

            $notificationarr['sender'] = $this->security->xss_clean(trim($data['user_id']));
            $notificationarr['receiver'] = 1;
            $notificationarr['notification_text'] = $buyerDetails->fname.' raised a add money to wallet request for transaction Ref <strong>'.$refNumber.'</strong>';
            $notificationarr['notification_type'] = 'WALLET';
            $notificationarr['notification_type_id'] = $result123;
            $result = $this->front_model->insertnotification($notificationarr);


            $this->response([
                'status' => true,
                'message' => 'Your buy request successfully submitted and pending for admin approval. You will be notified once your buy request is approved.',
                'data' => $dataInsrt,
            ], REST_Controller::HTTP_OK);
        }
    }
    
    public function submitwithdrawwallet_post(){
        $data = $this->input->post();
        $config = [
            [
                'field' => 'walletMoney',
                'label' => 'Wallet money',
                'rules' => 'trim|required|numeric',
                'errors' => [
                        'required' => 'Wallet money is required.',
                        'numeric' => 'Wallet money is should be numeric.',
                ],
            ],[
                'field' => 'witeTransferInstruction',
                'label' => 'Wire transfer instructions',
                'rules' => 'trim|required',
                'errors' => [
                        'required' => 'Wire transfer instructions is required.'
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
         
        $walletData['userId'] = $data['user_id'];
        $walletdetails = $this->front_model->getwalletdetails($walletData);
        
        $availableBalance = $walletdetails['walletamt'];

        //$getpendingwithdrawal = $this->front_model->getpendingwithdrawal($walletData);
        $this->db->select('BaseTbl.id,BaseTbl.transaction_ref', FALSE);
        $this->db->from(TABLE_PREFIX.'buy_request as BaseTbl', FALSE);
        $this->db->where('BaseTbl.userId', $data['user_id']);
        $this->db->where('BaseTbl.transaction_ref', $data['wire_transfer_ref']);
        $query = $this->db->get();        
        $userBuyDetails = $query->row();


        if($userBuyDetails->id >0)
        {
            /*$this->response([
                'status' => false,
                'message' => 'You have already sent purchase request for this transacrion Ref.',
                'data' => $dataInsrt,
            ], REST_Controller::HTTP_OK);*/
        }

        
        if($data['walletMoney'] >$availableBalance)
        {
            $this->response([
                'status' => false,
                'message' => 'Your withdrawal request amount is greater than your available balancae.',
                'data' => $dataInsrt,
            ], REST_Controller::HTTP_OK);
        }elseif($data['walletMoney'] < 1000)
        {
            $this->response([
                'status' => false,
                'message' => 'Your withdrawal request amount must be greater than $1000.',
                'data' => $dataInsrt,
            ], REST_Controller::HTTP_OK);
        }else{
            $this->db->select('U.fname, U.mail', FALSE);
            $this->db->from(TABLE_PREFIX.'users as U',FALSE);
            $this->db->where('U.userId', $data['user_id']);
            $query = $this->db->get();        
            $sellerDetails = $query->row();

            $refNumber = $data['wire_transfer_ref'];
            $walletMoney = $data['walletMoney'];
            $Description = $data['witeTransferInstruction'];
            $dataInsrt['listing_id'] = 0;
            $dataInsrt['sellerId'] = 0;
            $dataInsrt['userId'] = $this->security->xss_clean(trim($data['user_id']));
            $dataInsrt['transaction_ref'] = $refNumber;
            $dataInsrt['description'] = $this->security->xss_clean(trim($Description));
            $dataInsrt['section'] = 'WALLETWITHDRAW';
            $dataInsrt['images'] = '';
            $dataInsrt['wallet_amount'] = $this->security->xss_clean(trim($walletMoney));
            $dataInsrt['payment_mode'] = $this->security->xss_clean(trim($data['payThrough']));

            $result = $this->front_model->setlistingbuyoffer($dataInsrt);

            $buyrref['userId'] = $this->security->xss_clean(trim($data['user_id']));
            $buyrref['sellerId'] = 0;
            $buyrref['listing_id'] = 0;
            $buyrref['transaction_ref'] = $refNumber;
            $buyrref['area'] = 'WALLET';
            $buyrref['redeemed'] = 'Y';
            $this->front_model->setuserwithdrawref($buyrref);
            $userId = $this->security->xss_clean(trim($data['user_id']));
            $WalletBalance = $this->front_model->getwalletBalance($userId);

            $this->db->select("*");
            $this->db->from(TABLE_PREFIX.'fund_history');
            $this->db->where('userId', $userId); 
            $this->db->order_by('date_approved', 'desc');   
            $Query = $this->db->get();
            $Array = $Query->row();
            $approvedFund = $Array->approved_fund;

            ////
            $curDate = date('Y-m-d H:i:s');
            $arr['userId'] = $userId;
            $arr['fund_proof_approve_date'] = $curDate;
            $arr['proof_fund_status'] = 1;
            $arr['fund_approved_amount'] = $WalletBalance+$approvedFund;
            //$randomstring = strtoupper(substr(str_shuffle(RANDOM_CHAR), 0, 10));
            $randomstring = $this->front_model->setinvestorpassref();
            $arr['Investor_pass'] = $randomstring;
            $arr['fund_source'] = 'WALLET';
            $result11 = $this->user_model->updateuserdetails($arr);

            $arrHistory['userId'] = $userId;
            $arrHistory['investor_pass'] = $randomstring;
            $arrHistory['activity'] = 'CREATEPASS';
            $arrHistory['unlocked_business'] = 0;
            $this->admin_model->investor_pass_history($arrHistory);
            
            
            $user_to = $sellerDetails->mail;
            $user_subject = 'You raised a wallet withdrawal request - FIH.com';
            $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">'.$sellerDetails->fname.'</strong>,</h6>
            <br>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">You have requested money be withdrawn from your wallet - if approved, we will release your funds shortly.</p>
            <br>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
            $sendEmail = sendEmail($user_to, $user_subject, $user_message);

            $site_settings = $this->admin_model->getSiteSettings();
            $user_to = $site_settings['support_email_address'];
            $user_subject = $sellerDetails->fname.' raised a wallet withdrawal request - FIH.com';

            $user_message = '<h6 style="padding: 5px 0; margin: 0 0 0 0; font: normal 17px arial">Dear <strong style="padding: 0 0 0 0; margin: 0 0 0 0;  font: bold 16px arial;">Admin</strong>,</h6>
            <br>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial">'.$sellerDetails->fname.' requests money be withdrawn from his account. If accepted, you will need to send them funds.</p>
            <br>
            <p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">Cheers,</p>
			<p style="padding: 8px 0; margin: 0 0 0 0; font: normal 16px arial;">The Fih.com Team.</p>';
            $sendEmail = sendEmail($user_to, $user_subject, $user_message);

            $notificationarr['sender'] = $this->security->xss_clean(trim($data['user_id']));
            $notificationarr['receiver'] = 1;
            $notificationarr['notification_text'] = 'You received a wallet withdrawal request from '.$sellerDetails->fname;
            $notificationarr['notification_type'] = 'WALLETWITHDRAW';
            $notificationarr['notification_type_id'] = $result;
            $result = $this->front_model->insertnotification($notificationarr);/**/


            $this->response([
                'status' => true,
                'message' => 'Your withdrawal request successfully submitted and pending for admin approval. You will be notified once your withdrawal request is approved.',
                'data' => $dataInsrt,
            ], REST_Controller::HTTP_OK);
        }
    }


    public function buyerWonListing_post(){
        $data = $this->input->post();
        $arr['userId'] = $data['userId'];
        $listdata = $this->front_model->getUserWonListing($arr);
        
        $this->response([
            'status' => TRUE,
            'message' => '',
            'data' => $listdata
        ], REST_Controller::HTTP_OK);
    }
    
    public function sellerSoldListing_post(){
        $data = $this->input->post();
        $arr['userId'] = $data['userId'];
        $listdata = $this->front_model->getSellerSoldListing($arr);
        
        $this->response([
            'status' => TRUE,
            'message' => '',
            'data' => $listdata
        ], REST_Controller::HTTP_OK);
    }

}
