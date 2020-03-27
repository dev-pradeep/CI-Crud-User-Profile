<?php
/*
	Author: Pradeep T.
	Date: 27/03/2020
	Version: 1.0
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Admins extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->helper('hotel');
        $this->load->library('admin_vts_auth');		
        $this->load->library('form_validation');
        $this->load->library('session');        
    }
    public function index() { //Main Page (Dashboard Page) redirect        
		$this->admin_vts_auth->_member_signin_redirect();			
		$data['title']        = 'Signin';
		$data['main_content'] = 'login/signin';
		$this->load->view('no_manu_footer', $data);
		return;
    }
    public function dashboard() {        
		$this->admin_vts_auth->_member_area_redirect();
		$data['Get_all_users'] = $this->admin_model->Get_all_users();
		$data['title'] = 'Dashboard';
		$data['main_content'] = 'admins/dashboard.php';
		$this->load->view('page', $data);
		return;      
    }
	function setting() { //profile page load view
        $this->admin_vts_auth->_member_area_redirect();
        $email = $this->session->userdata('login_email');
        $adminId = $this->session->userdata('login_Id');
        $data['title'] = 'Setting';        
        $data['usersdata'] = $this->admin_model->get_userdetailsbyEmail($email); 
		$data['main_content'] = 'admins/setting';
        $this->load->view('page', $data);
        return;
    }
    public function users() { //Users Management        
		$this->admin_vts_auth->_member_area_redirect();
		$data['Get_all_users'] = $this->admin_model->Get_all_users();
		$data['title'] = 'Consultants';
		$data['main_content'] = 'admins/user';
		$this->load->view('page', $data);
		return;
    }    
	function changePassword() { // change password page ajax call
        if ($this->admin_vts_auth->validateTokenCode() != true) {
            return;
        }
        $config = array(
					array(
					'field' => 'newPassword', 
					'label' => 'New Password',
					'rules' => 'trim|required|alpha_dash'
					),
					array(
					'field' => 'confirmPassword', 
					'label' => 'Confirm Password',
					'rules' => 'trim|required|alpha_dash|matches[newPassword]'
					)
		);
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === false) {
            $this->form_validation->set_error_delimiters('<br />', '');
            $arrV[] = validation_errors();
            $data['json'] = json_encode(array("status" => "error", "message" => $arrV));
            $this->load->view('json_view', $data);
        } else {
            $userdatas = new stdClass();
            $cPass = $this->input->post('confirmPassword');
            $useruid = $this->input->post('users_id');
            $rand_salt = $this->admin_vts_auth->genRndDgt();
            $encrypt_pass = $this->admin_vts_auth->encryptUserPwd($cPass, $rand_salt);
            $pass_len = strlen($cPass);
            $userdatas->password = $encrypt_pass;
            $userdatas->salt = $rand_salt;
            $updatePass = $this->admin_model->updateusers_changepassword($useruid, $userdatas);
            if ($updatePass) {
                $data['json'] = json_encode(array("status" => "success", "message" => "Password changed successfully.", "data" => $userdatas));
                $this->load->view('json_view', $data);
                return;
            } else {
                $data['json'] = json_encode(array("status" => "error", "message" => "Unable to Change Your Password"));
                $this->load->view('json_view', $data);
                return;
            }
        }
    }
    public function update_user_profile() {
        // uplaod photo (avatar img)  ajax call
        if ($this->admin_vts_auth->validateTokenCode() != true) {
            return;
        }
        if ($_POST) {
            $imgData = $this->input->post('imagebase64', true);
            $base64img = substr($imgData, 9);
            if (isset($base64img) && $base64img) {
                $base64img = str_replace('data:image/png;base64,', '', $base64img);
                $base64img = str_replace(' ', '+', $base64img);
                //$base64img = preg_replace('#^data:image/[^;]+;base64,#', '', $base64img);
                $base64img = base64_decode($base64img);
                $fName = uniqid() . '.png';
                $file = $this->config->item('admin_upload_dir') . "adminLogo/" . $fName;
                $img = file_put_contents($file, $base64img);
                if ($img) {
                    $useruid = $this->input->post('users_id');
                    $cdata['profile_pic'] = $fName;
                    $updateprofile = $this->admin_model->updateusers_changepassword($useruid, $cdata);
                    if ($updateprofile) {
                        $data['json'] = json_encode(array("status" => "success", "message" => "Profile picture updated.", "data" => $cdata));
                        $this->load->view('json_view', $data);
                        return;
                    } else {
                        $data['json'] = json_encode(array("status" => "error", "message" => "Unable to Update Profile picture", "data" => ''));
                        $this->load->view('json_view', $data);
                        return;
                    }
                } else {
                    $data['json'] = json_encode(array("status" => "error", "message" => "Unable to upload image."));
                    $this->load->view('json_view', $data);
                    return;
                }
            } else {
                $data['json'] = json_encode(array("status" => "error", "message" => "Unable to upload image."));
                $this->load->view('json_view', $data);
                return;
            }
            return;
        } else {
            $data['json'] = json_encode(array("status" => "error", "message" => "Unable to upload image."));
            $this->load->view('json_view', $data);
            return;
        }
    }
    function change_profile_data() {
        if ($this->admin_vts_auth->validateTokenCode() != true) {
            return;
        }
        $config = array(
					array(
					'field' => 'name', 
					'label' => 'Name', 
					'rules' => 'trim|required'
					),
					array(
					'field' => 'address', 
					'label' => 'Address', 
					'rules' => 'trim|required'
					),
					array(
					'field' => 'mobile_no', 
					'label' => 'Mobile No', 
					'rules' => 'trim|required'
					)
		);
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() === false) {
            $this->form_validation->set_error_delimiters('<br />', '');
            $arrV[] = validation_errors();
            $data['json'] = json_encode(array("status" => "error", "message" => $arrV));
            $this->load->view('json_view', $data);
        } else {
            // update users profile  ajax call
            $users_id = $this->input->post('users_id');
            $name = $this->input->post('name');
            $address = $this->input->post('address');
            $mobile_no = $this->input->post('mobile_no');            
            //$newemail = $this->input->post('email');
           // $cdata['email'] = $newemail;
            $cdata = array(
					'name' => $name, 
					'address' => $address,					
					'mobile_no' => $mobile_no
			);
            $updatePass = $this->admin_model->updateusers_changepassword($users_id, $cdata);
            if ($updatePass) {
                $data['json'] = json_encode(array("status" => "success", "message" => "Your profile updated successfully", "data" => $cdata));
                $this->load->view('json_view', $data);
                return;
            } else {
                $data['json'] = json_encode(array("status" => "error", "message" => "Unable to Change Your Name and E-mail"));
                $this->load->view('json_view', $data);
                return;
            }
        }
    }
    function sentemail() {
        $username = $this->session->userdata('send_username');
        $useremail = $this->session->userdata('send_email');        
        $send_url = $this->session->userdata('send_url');        
        if ($username && $useremail) {            
            $dt['logo'] = $this->config->item('email_logo');
            $dt['user_email'] = $useremail;
            $dt['usersname'] = $username;            
            $dt['SetPasswordUrl'] = base_url() ."login/setPasswordUrl/".base64_encode($useremail);            
            $dt['appname'] = $this->config->item('applicationName');
			
			$this->load->library ( 'email', $this->config->item ( 'email_config' ) );
			$this->email->from ( $this->config->item('email_from'), $this->config->item ('applicationName'));
			$this->email->to ( $useremail );
			$this->email->subject ('You have been registered at '. $this->config->item('applicationName'));
			$msg = $this->load->view ( 'email/set_password_link', $dt, TRUE );
			$this->email->message ( $msg );
			$this->email->send();			
			$this->session->unset_userdata('send_username');
            $this->session->unset_userdata('send_email');
            $this->session->unset_userdata('send_cPass');
        } else {
            echo "blank";
            return;
        }
    }
	function Adduser() { // update Site ajax call
        if ($this->admin_vts_auth->validateTokenCode() != true) {
            return;
        }
        if ($_POST) {
            $config = array(
				array(
					'field' => 'name',
					'label' => 'Consultants Name', 
					'rules' => 'trim|required'
				),
				array(
					'field' => 'email',
					'label' => 'Email ID', 
					'rules' => 'trim|required|valid_email'
				),
				array(
					'field' => 'mobile_no',
					'label' => 'Mobile No',
					'rules' => 'trim|required'
				)
			);
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() === false) {
                $this->form_validation->set_error_delimiters('<br />', '');
                $arrV[] = validation_errors();
                $data['json'] = json_encode(array("status" => "error", "message" => $arrV));
                $this->load->view('json_view', $data);
            } else {
                $name = $this->input->post('name');
                $email = $this->input->post('email');
                $address = $this->input->post('address');                
                $verified = $this->input->post('verified');                
                $mobile_no = $this->input->post('mobile_no');                
				$usercode = strtoupper(md5('EVENT' . rand(0, 1000) . 'QO'));
				$activationCode = md5(rand(0, 1000) . 'amosMS');
				if ($verified=='on') {
                    $status = 1;
                } else {
                    $status = 0;
                }				
				$veryfiyemail = emailvarify($email);
				if($veryfiyemail){
						$data ['json'] = json_encode(array("status" => "error","message"=>'email address already in use.!'));
						$this->load->view ( 'json_view', $data );
						return;
				}
                $udata = array(
							'name' => $name, 
							'email' => $email, 
							'address' => $address,
							'mobile_no' => $mobile_no,
							'status	' => $status,
							'users_code	' => $usercode,
							'activationCode	' => '',
							'users_type' => 2,
							'isVerified' => 1,
							'createdOn' => date('Y-m-d H:i:s')
						);
                $SlId = $this->admin_model->insert_users($udata);				
				$this->session->set_userdata('send_username',$name);
				$this->session->set_userdata('send_email',$email);								
                if ($SlId) {
                    $data['json'] = json_encode(array("status" => "success", "message" => "User create successfully", "data" => $SlId));
                    $this->load->view('json_view', $data);
                    return;
                } else {
                    $data['json'] = json_encode(array("status" => "error", "message" => "Unable to create User"));
                    $this->load->view('json_view', $data);
                    return;
                }
            }
        } else {
            $data['json'] = json_encode(array("status" => "error", "message" => "Please enter valid details"));
            $this->load->view('json_view', $data);
            return;
        }
    }
    function updateuser() { // update Site ajax call
        if ($this->admin_vts_auth->validateTokenCode() != true) {
          return;
        }	
        if ($_POST) {
           $config = array(
				array(
					'field' => 'name',
					'label' => 'Consultants Name', 
					'rules' => 'trim|required'
				),
				array(
					'field' => 'email',
					'label' => 'Email ID', 
					'rules' => 'trim|required|valid_email'
				),
				array(
					'field' => 'mobile_no',
					'label' => 'Mobile No',
					'rules' => 'trim|required'
				)
			);
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() === false) {
                $this->form_validation->set_error_delimiters('<br />', '');
                $arrV[] = validation_errors();
                $data['json'] = json_encode(array("status" => "error", "message" => $arrV));
                $this->load->view('json_view', $data);
            } else {
                $name = $this->input->post('name');
                //$email = $this->input->post('email');
                $address = $this->input->post('address');
                $userid = $this->input->post('admin_id');                
                $active = $this->input->post('verified');				
                $mobile_no = $this->input->post('mobile_no');                
                if ($active=='on') {
                    $status = 1;
                }else {
                    $status = 0;
                }
                $udata = array(
							'name' => $name, 
							//'email' => $email, 
							'address' => $address,
							'mobile_no' => $mobile_no,							
							'status' => $status,
							'users_type' => 2,
							'isVerified' => 1,
							'createdOn' => date('Y-m-d H:i:s')
						);
                $SlId = $this->admin_model->updateusers($userid, $udata);
                if ($SlId) {
                    $data['json'] = json_encode(array("status" => "success", "message" => "User updated successfully", "data" => $SlId));
                    $this->load->view('json_view', $data);
                    return;
                } else {
                    $data['json'] = json_encode(array("status" => "error", "message" => "Unable to update User"));
                    $this->load->view('json_view', $data);
                    return;
                }
            }
        } else {
            $data['json'] = json_encode(array("status" => "error", "message" => "Please enter valid details"));
            $this->load->view('json_view', $data);
            return;
        }
    }
    function loaduser() { // load user ajax call
        if ($this->admin_vts_auth->validateTokenCode() != true) {
            return;
        }
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            $status=$this->input->post('userStatus');
			if($status==1){
				$data['Get_all_users'] = $this->admin_model->active_users();
				$data['main_content'] = 'viewuser';
				$d = $this->load->view('outputPage', $data, true);
				$this->output->set_output($d);
				return;
			}else{
				$data['Get_all_users'] = $this->admin_model->inactive_users();
				$data['main_content'] = 'inactive_user_view';
				$d = $this->load->view('outputPage', $data, true);
				$this->output->set_output($d);
				return;
			}
        }
    }
    function deleteuser() { // deleted user ajax call
        if ($this->admin_vts_auth->validateTokenCode() != true) {
            return;
        }
        $did = $this->input->post('user_id');
        $udata = array('isDeleted' => 1);
        $SlId = $this->admin_model->updateusers($did, $udata);
        if ($SlId) {
            $data['json'] = json_encode(array("status" => "success", "message" => "user deleted successfully", "data" => $SlId));
            $this->load->view('json_view', $data);
            return;
        } else {
            $data['json'] = json_encode(array("status" => "error", "message" => "Unable to remove user"));
            $this->load->view('json_view', $data);
            return;
        }
    }
	function activeStatus() { // deleted user ajax call
        if ($this->admin_vts_auth->validateTokenCode() != true) {
            return;
        }
        $did = $this->input->post('user_id');
        $udata = array('status' => 1);
        $SlId = $this->admin_model->updateusers($did, $udata);
        if ($SlId) {
            $data['json'] = json_encode(array("status" => "success", "message" => "Active Consultants successfully", "data" => $SlId));
            $this->load->view('json_view', $data);
            return;
        } else {
            $data['json'] = json_encode(array("status" => "error", "message" => "Unable to Active Consultants"));
            $this->load->view('json_view', $data);
            return;
        }
    } 
	function inactiveStatus() { // deleted user ajax call
        if ($this->admin_vts_auth->validateTokenCode() != true) {
            return;
        }
        $did = $this->input->post('user_id');
        $udata = array(
					'status' => 0,
					'inactive_date' => date('Y-m-d H:i:s')
				);
        $SlId = $this->admin_model->updateusers($did, $udata);
        if ($SlId) {
            $data['json'] = json_encode(array("status" => "success", "message" => "Inactive Consultants successfully", "data" => $SlId));
            $this->load->view('json_view', $data);
            return;
        } else {
            $data['json'] = json_encode(array("status" => "error", "message" => "Unable to Inactive Consultants"));
            $this->load->view('json_view', $data);
            return;
        }
    }
}
