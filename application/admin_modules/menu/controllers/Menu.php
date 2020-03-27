<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	class Menu extends MY_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('admin_model');		
			// $this->load->helper('admin_pos');
		}
		
		function index(){			
			$email = $this->session->userdata('login_email');
			$admin_data = $this->admin_model->get_userdetailsbyEmail($email);			
			$data['profilepic']=($admin_data ? $admin_data[0]->profile_pic : 'defaultUser.png');
			$data['name']=($admin_data ? $admin_data[0]->name : 'Users');
			$this->load->view("menu",$data);			
			return;
		}
		function _is_200($url)
		{
			$options['http'] = array(
			'method' => "HEAD",
			'ignore_errors' => 1,
			'max_redirects' => 0
			);
			$body = file_get_contents($url, NULL, stream_context_create($options));
			sscanf($http_response_header[0], 'HTTP/%*d.%*d %d', $code);
			return $code === 200;
		}
		
		//Limit access
		function _remap(){
			show_404();
		}
		
	}
	
?>		