<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminlogin extends CI_Controller {

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
		$this->load->library(array('form_validation', "upload"));
		$this->load->model('front_model');
		$this->load->model('admin_model');
	}
	
	public function login(){
		$this->load->view('backend/admin_login');
	}
	
    public function logout(){
        $user_data = $this->session->all_userdata();
            foreach ($user_data as $key => $value) {

                /*if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity' && $key != 'addtocart') {
                    $this->session->unset_userdata($key);
				}*/
				$this->session->unset_userdata($key);
            }
        redirect(base_url().'administrator/login');
    }
}