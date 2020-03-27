<?php
/*
Author: Pradeep T.
Date: 27/03/2020
Version: 1.0
*/
class Users extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('form_validation');
    }
	public function index(){	    	
		$data ['title'] = 'Test';		
		$data['main_content'] = 'users/welcome_message';
    	$this->load->view('page2', $data);
    	return;
	}
}
