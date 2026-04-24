<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supportticket extends CI_Controller {
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

    public function getSupportticket(){
		$permission = checkAuthorization('SUPPORTTICKET','LIST');
        $getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		$header['sitetitle'] = 'ADMIN - FIH.com';
		$header['class'] = 'supportticket';
		$header['userData'] = $getUserData;

		//$getSiteDetails['siteSettings'] = $this->admin_model->getSiteSettings(1);
		//$getSiteDetails['getCurrency'] = $this->admin_model->getCurrencies();
		
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/admin-support-ticket',$getSiteDetails);
		else
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
    }

    public function getSupportticketData(){
        $draw = $_POST['draw'];
        $data['start'] = $_POST['start'];
		$data['limit'] = $_POST['length'];
        $data['searchName'] = $_POST['searchName'];
        $data['searchByStatus'] = $_POST['searchByStatus'];
        $sort = $_POST['order'][0];
		$sellRequests = $this->admin_model->gettickets($data,$sort);
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
					$email = '<a target="_blank" href="'.base_url().'administrator/users/edit/'.$val['uid'].'">'.$val['mail'].'</a>';
					$phone = $val['phone'];
				}else{
					$firstName = $val['fname1'];
					$email = '<a target="_blank" href="'.base_url().'administrator/users/edit/'.$val['uid1'].'">'.$val['mail1'].'</a>';
					$phone = $val['phone1'];
				}
				
				if($val['admin_read'] == 'N')
				{
					$ticket[$i]['ticket_id'] = '<strong>'.$val['ticket_no'].'</strong>';
					$ticket[$i]['user'] = '<strong>'.$firstName.'</strong>';
					$ticket[$i]['email'] = '<strong>'.$email.'</strong>';
					$ticket[$i]['phone'] = '<strong>'.$phone.'</strong>';
					$ticket[$i]['subject'] = '<strong>'.$val['subject'].'</strong>';
					//$ticket[$i]['message'] = substr($val['message'],0,50).'...';
					$ticket[$i]['admin_read'] = $val['admin_read'];
					$ticket[$i]['ticketDate'] = '<strong>'.date('jS M Y',strtotime($val['date_added'])).'</strong>';
					$ticket[$i]['ticketStatus'] = '<strong>'.$ticketStatus.'</strong>';
				}else{
					$ticket[$i]['ticket_id'] = $val['ticket_no'];
					$ticket[$i]['user'] = $firstName;
					$ticket[$i]['email'] = $email;
					$ticket[$i]['phone'] = $phone;
					$ticket[$i]['subject'] = $val['subject'];
					$ticket[$i]['admin_read'] = $val['admin_read'];
					$ticket[$i]['ticketDate'] = date('jS M Y',strtotime($val['date_added']));
					$ticket[$i]['ticketStatus'] = $ticketStatus;
				}
				
				$ticket[$i]['action'] = '<a href="'.base_url().'administrator/ticket/details/'.$val['ticket_no'].'" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
				$i++;
			}
		}else{
			$ticket = [];
		}
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $sellRequests['totalrecord']->totalrecord,
            "recordsFiltered" => $sellRequests['totalrecord']->totalrecord,
			"data" => $ticket,
			'postdata'=>$data,
			"token" => $this->security->get_csrf_hash()
			
        );
        echo json_encode($response);
	}
	
	public function supportTicketDetails($ticketid)
	{
		$permission = checkAuthorization('SUPPORTTICKET','LIST');
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		//$header['sitetitle'] = 'ADMIN - FIH.com';
		
		$header['class'] = 'supportticket';
		$header['userData'] = $getUserData;

		//echo $ticketid;
		
		$ticketDetails = $this->admin_model->getTicketDetails($ticketid);
		$data['ticket'] = $ticketDetails;
		$data['editpermission'] = checkAuthorization('SUPPORTTICKET','EDIT');
		$this->load->view('backend/includes/header',$header);
		if($permission)
		$this->load->view('backend/admin-support-ticket-details',$data);
		else	
		$this->load->view('backend/unauthorized');
		$this->load->view('backend/includes/footer');
	}

	public function supportReply(){
		//echo  'Support reply';
		$getUserData = $this->admin_model->getUserDetails($this->session->userdata('user_id'));
		
		$adminreply = $this->input->post('adminreply');
		$ticketId = $this->input->post('ticketId');
		$ticketDetails = $this->admin_model->getTicketDetails($ticketId);
		
		$adminreply = $this->security->xss_clean($adminreply);

		$dataInsert['userId'] = $this->session->userdata('user_id');
		$dataInsert['userid_to'] = $ticketDetails[0]['userId'];
		$dataInsert['subject'] = $ticketDetails[0]['subject'];
		$dataInsert['message'] = $adminreply;
		$dataInsert['type'] = 'REPLY';
		$dataInsert['reply_ticket_id'] = $ticketDetails[0]['id'];
		$dataInsert['user_read'] = 'N';
		$dataInsert['admin_read'] = 'Y';
		$dataInsert['ticket_no'] = $ticketDetails[0]['ticket_no'];
		//print '<pre>';
		//print_r($dataInsert);
		//die;
		$valuationListing = $this->user_model->insertticket($dataInsert);


		$notificationarr['sender'] = 1;
        $notificationarr['receiver'] = $ticketDetails[0]['userId'];
        $notificationarr['notification_text'] = 'You have received reply for support ticket no <strong>#'.$ticketDetails[0]['ticket_no'].'</strong> by admin. ';
        $notificationarr['notification_type'] = 'SUPPORTTICKET';
        $notificationarr['notification_type_id'] = $valuationListing;
        $result111 = $this->front_model->insertnotification($notificationarr);

		$this->session->set_flashdata('success', 'Ticket replied successfully!');
		redirect('administrator/ticket/details/'.$ticketDetails[0]['ticket_no']);

	}

	public function supportTicketClose($id){
		$ticketId = $id;
		$closeTicket = $this->user_model->closeticket($ticketId);
		$this->session->set_flashdata('success', 'Ticket closed successfully!');
		redirect('administrator/ticket/details/'.$id);
	}


}
?>