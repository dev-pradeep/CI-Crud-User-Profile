<?php
/*
	Author: Pradeep T.
	Date: 27/03/2020
	Version: 1.0
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('admins/admin_model');
        $this->load->helper('hotel');
        $this->load->library('admin_vts_auth');		
        $this->load->library('form_validation');
        $this->load->library('session');        
    }
    public function index() { //Main Page (Dashboard Page) redirect
		$this->admin_vts_auth->_member_area_redirect();
        $email = $this->session->userdata('login_email');
        $adminId = $this->session->userdata('login_Id');
        $data['title'] = 'Setting';        
        $data['usersdata'] = $this->admin_model->get_userdetailsbyEmail($email); 
		$data['main_content'] = 'admins/setting';
        $this->load->view('page', $data);
        return;
    }    
}
