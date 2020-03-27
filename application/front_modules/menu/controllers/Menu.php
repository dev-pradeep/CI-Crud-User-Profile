<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		
	}
	
	function index(){
		
		$this->load->view("menu");
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