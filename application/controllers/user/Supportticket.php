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
		if($logincookie!='' && !$this->session->userdata('isLoggedIn'))
		{
			$this->loginrememberme();
		}elseif(!$this->session->userdata('isLoggedIn') && !$this->session->userdata('user_id'))
		{
			redirect(base_url().'login');
		}
		if($this->session->userdata('roleText') =='admin')
		{
			redirect(base_url().'administrator');
		}
    }

	public function supportTicketDetails($ticketid)
	{
		$header = $this->front_model->header();
		$header['site_settings']->site_title = 'Email Support - '.$header['site_settings']->site_title;
		$footer = $this->front_model->footer();
		$url = 'api/user/supportticketdetails';
        $userDataOffer['ticket'] = $ticketid;
        $userDataOffer['userId'] = $this->session->userdata('user_id');
		$ticketDetails = sendRestRequest($url, $userDataOffer);
		
		//$ticketDetails = $this->admin_model->getTicketDetails($ticketid);
		$data['ticket'] = $ticketDetails['data'];
		
		$this->load->view('user/includes/header',$header);
		$this->load->view('user/user-support-ticket-details',$data);
		$this->load->view('user/includes/footer');
	}

	public function supportReply(){
		$data = $this->input->post();
		$url = 'api/user/supportticketreply';
        $data['userId'] = $this->session->userdata('user_id');
		$ticketDetails = sendRestRequest($url, $data);
		if($ticketDetails['status'])
		{
			$this->session->set_flashdata('success', 'Ticket replied successfully!');
		}else{
			$this->session->set_flashdata('error', $ticketDetails['message']);
		}
		
		redirect('user/ticket/details/'.$data['ticketId']);

	}

	public function supportTicketClose($id){
		$ticketId = $id;

		$url = 'api/user/supportticketclose';
		$data['ticket'] = $ticketId;
        $data['userId'] = $this->session->userdata('user_id');
		$ticketDetails = sendRestRequest($url, $data);

		//$closeTicket = $this->user_model->closeticket($ticketId);
		$this->session->set_flashdata('closesuccess', 'Ticket closed successfully!');
		redirect('user/ticket/details/'.$id);
	}


}
?>