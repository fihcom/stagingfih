<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sellquestions extends CI_Controller {
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

    public function listSurveyForms(){
        $getUserData = $this->admin_model->getUserDetails($this->session->userdata('politician_owner_id'));
		$header['sitetitle'] = 'ADMIN - Poliscore';
		$header['userData'] = $getUserData;
		$header['class'] = 'surveymanagement';
        $this->load->view('backend/includes/header',$header);
		$this->load->view('backend/survey-form-list',$data);
		$this->load->view('backend/includes/footer');
    }

    /*public function addSurveyForms(){
        //$getUserData = $this->admin_model->getUserDetails($this->session->userdata('politician_owner_id'));
		$header['sitetitle'] = 'ADMIN - Poliscore';
		$header['userData'] = $getUserData;
        $header['class'] = 'surveymanagement';
        $settings = $this->admin_model->getSiteSettings();
        //$unpublishedsurvey = $this->admin_model->getunpublishedsurveyform($this->session->userdata('politician_owner_id'));
        //$data['surveyFormdata'] = $unpublishedsurvey;
        $data['settings'] = $settings;
        $data['currency'] = $this->admin_model->getCurrencies($settings['currency']);
        
		$this->load->view('backend/includes/header',$header);
		$this->load->view('backend/add-survey-form-description',$data);
		$this->load->view('backend/includes/footer');
    }*/
    public function addQuestionFields(){
        $permission = checkAuthorization('SELLQUESTION','LIST');
        $getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'site-settings';
		$header['userData'] = $getUserData;
		$data['admin_details'] = $getUserData;
        $sitesettings = $this->admin_model->getSiteSettings();
        $data['questionArr'] = json_decode($sitesettings['sell_questions'],true);
        $data['questionCat'] = $this->admin_model->getquestioncategories();
        $data['editpermission'] = checkAuthorization('SELLQUESTION','EDIT');
        $this->load->view('backend/includes/header', $header);
        if($permission)
		$this->load->view('backend/add-question-form',$data);
        else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
    }
    public function addQuestionFormsAction(){
        $getUserData = $this->admin_model->getUserDetails($this->session->userdata('politician_owner_id'));
        $header['sitetitle'] = 'ADMIN - FIH.com';
        for($i=1; $i<=100;$i++)
        {
            $Question = $this->security->xss_clean($this->input->post('Question'.$i));
            $Category = $this->security->xss_clean($this->input->post('Category'.$i));
            $Answer = $this->security->xss_clean($this->input->post('Answer'.$i));
            $surveyTitle = $this->security->xss_clean($this->input->post('surveyTitle'));
            $AnswerOptions = $this->security->xss_clean($this->input->post('Answer'.$i.'Options'));
            if($Question != '')
            {
                $SurveyArr[] = [
                    'Question'=>$Question,
                    'Category'=>$Category,
                    'Answer'=>$Answer,
                    'AnswerOptions' => $AnswerOptions
                ];
            }
            
        }
        
        $arr['sell_questions'] = json_encode($SurveyArr);
        $this->db->where('id', 1);
        $this->db->update(TABLE_PREFIX.'site_settings', $arr);
        $this->session->set_flashdata('success', 'Question successfully Updated!!!!');
        redirect(base_url().'administrator/site-settings/questionadd');
    }


    public function listSurveyData(){
        $userId = $this->session->userdata('politician_owner_id');
		$draw = $_POST['draw'];
        $page = $_POST['start'];
		$limit = $_POST['length'];
		//$page = 0;
		//$limit = 10;
		$searchValue['search'] = $_POST['search']; 
		$searchValue['status'] = $_POST['status']; 
		//$searchValue = 'sfdgdfg';
		$users = $this->admin_model->getSurvey($userId,$page,$limit,$searchValue);

		
		if(is_array($users['data']) && count($users['data'])>0)
		{
			$i=1;
			foreach($users['data'] as $kk=>$vv)
			{
                $action = '';
                $expiryDate = '';
                if($vv['status'] == '0')
                {
                    $action = '<a href="'.base_url().'politician/surveyforms/addfields" title="Reply Review" class="btn btn-sm btn-success deleteathlete"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
                    $status = 'Unpublished';
                    $submissionDate = '';
                    $expiryDate = '';
                    $billingAmt = '';
                }elseif($vv['status'] == '1')
                {
                    $status = 'Pending Approval';
                    $submissionDate = date("F j, Y, g:i a",strtotime($vv['submit_date']));
                    $billingAmt = $vv['symbol'].$vv['payment_gross'];
                }elseif($vv['status'] == '2')
                {
                    $status = 'Published';
                    $submissionDate = date("F j, Y, g:i a",strtotime($vv['submit_date']));
                    $expiryDate = date("F j, Y, g:i a",strtotime($vv['expDate']));
                    $billingAmt = $vv['symbol'].$vv['payment_gross'];
                }elseif($vv['status'] == '3')
                {
                    $status = 'Rejected';
                    $submissionDate = date("F j, Y, g:i a",strtotime($vv['submit_date']));
                    $billingAmt = $vv['symbol'].$vv['payment_gross'];
                }
                if($vv['status'] == '2' && time()>strtotime($vv['expDate']))
                {
                    $status = 'Expired';
                    $submissionDate = date("F j, Y, g:i a",strtotime($vv['submit_date']));
                    $expiryDate = date("F j, Y, g:i a",strtotime($vv['expDate']));
                    $billingAmt = $vv['symbol'].$vv['payment_gross'];
                }
				$allUser[] = array('sl_no'=>$i,'name'=>$vv['title'],'survey_date'=>$submissionDate,'expiry_date'=>$expiryDate,'billing_code'=>$vv['subscription_code'],'billing_amt'=>$billingAmt,'status'=>$status,'action'=>$action);
				$i++;
			}
		}else{
			$allUser = [];
		}
		
		
		  
		$response = array(
            "draw" => intval($draw),
            "recordsTotal" => $users['totalrecord']->totalrecord,
            "recordsFiltered" => $users['totalrecord']->totalrecord,
			"data" => $allUser,
			"ss"=>$_POST,
			"token"=> $this->security->get_csrf_hash()
        );
        echo json_encode($response);
    }

    

}