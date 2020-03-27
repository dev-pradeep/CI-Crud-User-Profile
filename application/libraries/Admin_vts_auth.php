<?php
/*
	Author: Pradeep T.
	Date: 27/03/2020
	Version: 1.0
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin_vts_auth {
	function __construct() {
		$this->ci = & get_instance();
		$this->ci->load->model('admins/admin_model');
		$this->ci->load->helper('hotel');
	}
	function process_login($login_array_input = NULL) {
		if (!isset($login_array_input) OR count($login_array_input) != 2) return false;
		//set its variable
		$username = $login_array_input[0];
		$password = $login_array_input[1];
		// select data from database to check user exist or not?
		$query = $this->ci->db->query("SELECT * FROM `admin` WHERE `email`= '" . $username . "' and isDeleted=0 LIMIT 1");
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$user_pass = $row->password;
			$adminID = $row->users_code;
			$user_email = $row->email;
			$admin_salt = $row->salt;
			$isVerified = $row->isVerified;
			$status = $row->status;
			$activationCode = $row->activationCode;			
			if ($this->encryptUserPwd($password, $admin_salt) === $user_pass) {				
				if ($isVerified != 1) {
					$data['json'] = json_encode(array("status" => "error", "message" => "Sorry ! Your account is not verified."));
					return $data;
				}
				if ($status == 0) {
					$data['json'] = json_encode(array("status" => "error", "message" => "Sorry ! Your account is not active."));
					return $data;
				}
				if (!empty($activationCode)) {
					$data['json'] = json_encode(array("status" => "error", "message" => "Please verify your email first."));
					return $data;
				}
				$tokenCode = $this->_generate_access_token($adminID);
				$fullName = $row->name;
				$data['is_LoggedIn'] = true;
				$data['login_email'] = $username;
				$data['login_Id'] = $adminID;
				$data['accessToken'] = $tokenCode;
				$data['name'] = (isset($fullName) && $fullName && trim($fullName) == true) ? $fullName : $username;				
				$this->ci->session->set_userdata($data);				
				if ($this->_member_signin_redirect_returnPage()) {
					$rUrl = $this->_member_signin_redirect_returnPage();
				} else {
					$rUrl = base_url() . 'admins/dashboard';
				}
				$data['json'] = json_encode(array("status" => "success", "message" => "Login Success", "redirect_url" => $rUrl));
				return $data;
			} else {
				$data['json'] = json_encode(array("status" => "error", "message" => "<p>Invalid Email or Password.</p>",));
				return $data;
			}
		} else {			
			$data['json'] = json_encode(array("status" => "error", "message" => "<p>Unable to find your account.</p>",));
			return $data;			
		}
	}	
	function check_logged() {
		return ($this->ci->session->userdata('is_LoggedIn')) ? TRUE : FALSE;
	}
	function logged_id() {
		return ($this->ci->check_logged()) ? $this->ci->session->userdata('is_LoggedIn') : '';
	}
	function _member_signin_redirect() {				
		if ($this->_is_logged_in()) {		
			$rUrl = base_url() . 'admins/dashboard';
			redirect($rUrl);
		}
	}	
	function _member_signin_redirect_returnPage() {
		$rPage = $this->ci->session->userdata('last_page');
		$last = $this->ci->uri->total_segments();
		$record_num = $this->ci->uri->segment($last);
		if (isset($rPage) && $rPage != NULL && $rPage != "") {
			$contents = explode('/', $rPage);
			$str = end($contents);
			if (strpos($str, '.js') || strpos($str, '.css') || strpos($str, '.map') === true) {
				$rPage = base_url() . "admins/dashboard";
			}
			return $rPage;
			} else {
			$loggedUserId = $this->ci->session->userdata('userId');
			$rPage = base_url() . "admins/dashboard";
			return $rPage;
		}
	}	
	function _member_area_redirect() {				
		$tokenCode = $this->ci->session->userdata('accessToken');
		$query = $this->ci->db->query("SELECT * FROM `access_token` WHERE `tokenCode`= '" . $tokenCode . "' LIMIT 1");
		if (empty($query->result())) {
			$this->ci->session->set_userdata('tokensms', 'Your session is expired. Please login again');
			$this->ci->session->unset_userdata("accessToken");
			$this->ci->session->unset_userdata("accesstable");
			$this->ci->session->unset_userdata("is_LoggedIn");
			$this->ci->session->unset_userdata("login_email");
			$this->ci->session->unset_userdata("adminId");
			$this->ci->session->unset_userdata("name");
			redirect('login', 'refresh');
			return;
		}
		if (!$this->_is_logged_in() && $this->validateTokenCode($tokenCode)) {
			$this->ci->load->helper('url');
			$this->ci->session->set_userdata('last_page', current_url());
			redirect('login', 'refresh');
			return;
		}
	}
	function check_email() {
		$query = $this->ci->db->query("SELECT * FROM `admins` WHERE `email`= '" . $user_email . "' LIMIT 1");
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$email = $row->email;
			if ($email) {
				return true;
			}
			return false;
		}
	}
	function _member_area() {
		if (!$this->_is_logged_in()) {
			redirect('');
		}
	}
	function _is_logged_in() {
		if (null !== $this->ci->session->userdata('is_LoggedIn') && $this->ci->session->userdata('is_LoggedIn')) {
			return true;
			} else {
			return false;
		}
	}
	function encryptUserPwd($pwd, $salt) {
		return sha1(md5($pwd) . $salt);
	}
	// Generate Random Salt for Password encryption
	function genRndSalt() {
		return $this->genRndDgt(8, true);
	}
	// Generate Random Digit
	function genRndDgt($length = 8, $specialCharacters = true) {
		$digits = '';
		$chars = "abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789";
		if ($specialCharacters === true) $chars.= "!?=/&+,.";
		for ($i = 0;$i < $length;$i++) {
			$x = mt_rand(0, strlen($chars) - 1);
			$digits.= $chars{$x};
		}
		return $digits;
	}
	function _generate_access_token($uID) {
		$access_token = md5(sha1($uID) . "MS" . rand(0, 1000) . time() . 'access_token');
		$storeToken = $this->ci->admin_model->storeToken($uID, $access_token);
		if ($storeToken) {
			return $access_token;
		}
		return $access_token;
	}
	function _removeAccessToken($tokenCode) {
		$removeToken = $this->ci->admin_model->removeToken($tokenCode);
		if ($removeToken) {
			return true;
		}
		return false;
	}
	function validateTokenCode() {
		$token = $this->ci->input->post("accessToken", true);
		/* $tokenCode = $this->ci->session->userdata('accessToken');
			if (!$tokenCode) {
			$data['json'] = json_encode(array("status" => "error", "message" => "Your session is expired. Please login again."));
			$this->ci->load->view('json_view', $data);
			return;
		} */
		if (isset($token) && $token) {
			$query = $this->ci->db->query("SELECT * FROM `access_token` WHERE `tokenCode`= '" . $token . "' LIMIT 1");
			if ($query->num_rows() > 0) {
				return true;
				//return $query->result();
				
				} else {
				$data['json'] = json_encode(array("status" => "error", "message" => "Provide valid access token."));
				$this->ci->load->view('json_view', $data);
				return;
			}
			} else {
			$data['json'] = json_encode(array("status" => "error", "message" => "Provide access token."));
			$this->ci->load->view('json_view', $data);
			return;
		}
	}	
}
