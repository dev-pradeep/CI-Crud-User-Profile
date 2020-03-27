<?php
	defined('BASEPATH') OR exit('No direct script access allowed');	 
	class Login extends MY_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('admins/admin_model');
			$this->load->model('Login_model');
			$this->load->helper('hotel');
			$this->load->library('admin_vts_auth');			
			$this->load->library('form_validation');
			$this->load->library('session');
			}				
		public function index(){ //Main Page (Dashboard Page) redirect			
			$this->admin_vts_auth->_member_signin_redirect();			
			$data['title']        = 'Signin';
			$data['main_content'] = 'login/signin';
			$this->load->view('no_manu_footer', $data);
			return;
		}		
		public function forgotpassword(){ //Main Page (Dashboard Page) redirect			
			$this->admin_vts_auth->_member_signin_redirect();			
			$data['title']        = 'Forgot Password';
			$data['main_content'] = 'login/forgotpassword';
			$this->load->view('no_manu_footer', $data);
			return;
		}
		function signin(){ // signin in page ajax call						
			if ($_POST) {
				$config = array(
                array(
				'field' => 'email',
				'label' => 'E-mail',
				'rules' => 'trim|required|valid_email'
                ),
                array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'trim|required'
                )
				);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() === false) {
					$arrV[] = validation_errors();
					$this->form_validation->set_error_delimiters(' ', ' ');
					$data['json'] = json_encode(array(
                    "status" => "error",
                    "message" => $arrV
					));
					$this->load->view('json_view', $data);
					return;
					} else {
					// Data
					$admin_email = $this->input->post('email', true);
					$password    = $this->input->post('password', true);
					$res         = $this->admin_vts_auth->process_login(array($admin_email,$password));
					$this->load->view('json_view', $res);
				}
				return;
			}
			else{
				$data ['json'] = json_encode (array("status" => "error","message" => "provide some valid details.","data" => ""));
				$this->load->view ( 'json_view', $data );
				return;
			}
		}		
		function activate($email="",$key=""){
			$email=$this->uri->segment(3);
			$key=$this->uri->segment(4);
			$password = $this->session->userdata('adminpassword'); // session store data
			if(isset($email) && $email !=NULL && $email !=""){
				//$chk=$this->admin_model->check_email($email);
				$chk=getuserDetails($email);				
				if(!$chk){
					$data['error']="Invalid Email. Please Check Your Email.";
					$this->load->view('login/displayMessagePage', $data);
					return;
				}
				$tablename=$chk[0];
				$usercode=$chk[1];
				$dbKey=$this->admin_model->getActKey($tablename,$email);
				if(isset($dbKey) && $dbKey !=NULL && $dbKey !="" && isset($key) && $key !=NULL && $key !="" && $dbKey==$key){
					$d=array("isVerified"=>1,"activationCode"=>'',"status"=>1);
					$rm=$this->admin_model->updateKey($tablename,$email,$d);
					if($rm){
						try{						
							$users=$this->admin_model->get_admin_data($email);						
							$dt ['logo'] = $this->config->item('email_logo');
							$dt ['user_email'] = $email;
							$dt ['name'] = ($users ? $users[0]->name : $email);
							$dt ['userspass'] = $password;
							$dt ['appname'] = $this->config->item('applicationName');	
							$dt ['LoginUrl']	= base_url()."login";							
							$body = $this->load->view ( 'email/usr_welcome_page', $dt, TRUE );
							$subject=strtolower($this->config->item('applicationName')).": Account Confirmation";
							$sendTo=$email;
							$this->phpmail->SendPhpmail($sendTo,$body,$subject);							
							$this->session->unset_userdata('adminpassword');
						}catch(Exception $e){
							$data ['json'] = json_encode(array("status"=>"error","message"=>"Message Not Sent."));
							$this->load->view('json_view',$data);
							return;
						}
						$data['success']="Great! Your account is confirmed You will be automatically redirected to login page";
						$this->load->view('login/displayMessagePage', $data);
						return;
					}
					}else{
					$data['error']="Please provide valid activation key.";
					$this->load->view('login/displayMessagePage', $data);
					return;
				}
				}else{
				$data['error']="Invalid Email.";
				$this->load->view('login/displayMessagePage', $data);
				return;
			}
		}
		function forgotpasswords() {
			if ($_POST) {
				$config = array (
				array (
				'field' => 'recoverEmail',
				'label' => 'Recovery Email',
				'rules' => 'trim|required|valid_email'
				)
				);
				$this->form_validation->set_rules ( $config );
				if ($this->form_validation->run () === false) {
					$arrV [] = validation_errors ();
					$this->form_validation->set_error_delimiters ( ' ', ' ' );
					$data ['json'] = json_encode ( array (
					"status" => "error",
					"message" => $arrV 
					) );
					$this->load->view ( 'json_view', $data );
					return;	
					} else {
					$userdata = new stdClass ();
					$recoverEmail = $this->input->post('recoverEmail');								
					$chk=getuserDetails($recoverEmail);					
					if (empty($chk)){
						$data ['json'] = json_encode(array("status" => "error","message" => "<p>Email you entered is not registered with us</p>","data"=>""));
						$this->load->view ( 'json_view', $data );
						return;
					}
					$rCode=$this->admin_vts_auth->genRndDgt(10,false);
					$recoverLink=base_url()."login/resetpassword/".$recoverEmail."/".$rCode;
					$validateresetEmail=$this->admin_model->validateresetEmail($recoverEmail);					
					if($validateresetEmail){
						$rData['resetcode']=$rCode;
						$linkSuccess=$this->admin_model->updateResetPasswordLink($recoverEmail,$rData);
						}else{
						$rData['email']=$recoverEmail;
						$rData['resetcode']=$rCode;
						$linkSuccess=$this->admin_model->saveResetPasswordLink($rData);
					}
					if($linkSuccess){											
						$admindata=$this->admin_model->Emailbyadmindata($recoverEmail)[0];
						$username=$admindata->name;
						
						$dt ['logo'] = $this->config->item('email_logo');
						$dt ['user_email'] = $username;
						$dt ['recovery_key']=$recoverLink;
						$dt ['appname']=$this->config->item ('applicationName');
						$this->load->library ( 'email', $this->config->item ( 'email_config' ) );
						$this->email->from ( $this->config->item('email_from'), strtolower($this->config->item ('applicationName')));
						$this->email->to ( $recoverEmail );
						$this->email->subject ( 'Password Reset Link' );
						$msg = $this->load->view ( 'email/forgotpassword_link', $dt, TRUE );
						$this->email->message ( $msg );
						if($this->email->send()){
							$data ['json'] = json_encode(array("status" => "success","message" => "<p>Password recovery link sent successfully to your email address.</p>","data"=>""));
							$this->load->view ( 'json_view', $data );
							return;
							}else{
							$data ['json'] = json_encode(array("status" => "error","message" => "<p>Unable to send recovery email to your account.</p>","data"=>""));
							$this->load->view ( 'json_view', $data );
							return;
						}
						}else{
						$data ['json'] = json_encode(array("status" => "error","message" => "<p>Unable to send recovery email to your account.</p>","data"=>""));
						$this->load->view ( 'json_view', $data );
						return;
					}
				}
				return;
			}
			else{
				$data ['json'] = json_encode (array("status" => "error","message" => "provide some valid details.","data" => ""));
				$this->load->view ( 'json_view', $data );
				return;
			}
		}
		function resetpassword($email="",$rCode=""){
			if(isset($email) && $email && isset($rCode) && $rCode){
				$validateresetEmail=$this->admin_model->validateresetEmail($email);
				if(!$validateresetEmail){
					$data['title'] = 'SetPassword';
					$data ['error'] = "<br>Sorry! This resetpassword link is no longer available or invalid input.";
					$data ['main_content'] = 'login/resetPassword';
					$this->load->view ( 'no_manu_footer', $data );
					return;
				}
				$validateresetCode=$this->admin_model->validateresetCode($email,$rCode);
				if(!$validateresetCode){
					$data['title'] = 'SetPassword';
					$data ['error'] = "<br>Sorry! This resetpassword link is no longer available or invalid input.";
					$data ['main_content'] = 'login/resetPassword';
					$this->load->view ( 'no_manu_footer', $data );
					return;
				}
				if ($_POST) {
					$config = array (
					array (
					'field' => 'npassword',
					'label' => 'New Password',
					'rules' => 'trim|required|min_length[4]|alpha_dash'
					),
					array (
					'field' => 'cpassword',
					'label' => 'Confirm Password',
					'rules' => 'trim|required|min_length[4]|alpha_dash|matches[npassword]'
					)
					);
					$this->form_validation->set_rules ( $config );
					if ($this->form_validation->run () === false) {
						$this->form_validation->set_error_delimiters('<br />', '');
						$data['title'] = 'SetPassword';
						$data ['error'] = validation_errors ();
						$data ['main_content'] = 'login/resetPassword';
						$this->load->view ( 'no_manu_footer', $data );
						return;
					} else {
						$userdata = new stdClass ();
						$cPass = $this->input->post ( 'cpassword' );
						$rand_salt = $this->admin_vts_auth->genRndSalt();
						$encrypt_pass = $this->admin_vts_auth->encryptUserPwd ( $cPass, $rand_salt );				
						$userdata->password = $encrypt_pass;
						$userdata->salt = $rand_salt;
						//
						$chk=getuserDetails($email);
						$tablename=$chk[0];
						$usercode=$chk[1];
						//
						$updatePass = $this->admin_model->updateUserByEmailRest($tablename,$email, $userdata );
						if ($updatePass) {
							$this->admin_model->removeResetEntry($email, $rCode );
							$data['title'] = 'SetPassword';
							$data ['message'] = "Your Password Reset succesfully.";
							$data ['main_content'] = 'login/resetPassword';
							$this->load->view ( 'no_manu_footer', $data );
						}else{
							$data['title'] = 'SetPassword';	
							$data ['error'] = "Unable to reset your password.";
							$data ['main_content'] = 'login/resetPassword';
							$this->load->view ( 'no_manu_footer', $data );
						}
					}
					return;
				}
				$data ['main_content'] = 'login/resetPassword';
				$this->load->view ( 'no_manu_footer', $data );
				return;
				}else{
				redirect("login","refresh");
			}
		}
		function setPasswordUrl($email=""){			
			if(isset($email) && $email){				
				$email = base64_decode($email);
				$validateresetEmail=$this->admin_model->check_email($email);
				if(!$validateresetEmail){
					$data['title'] = 'SetPassword';
					$data ['error'] = "<br>Sorry! This resetpassword link is no longer available or invalid input.";
					$data ['main_content'] = 'login/setPassword';
					$this->load->view ( 'no_manu_footer', $data );
					return;
				}
				$validateresetCode=$this->admin_model->Set_resetpassword($email);
				if(!$validateresetCode){
					$data['title'] = 'SetPassword';
					$data ['error'] = "<br>Sorry! This resetpassword link is no longer available or invalid input.";
					$data ['main_content'] = 'login/setPassword';
					$this->load->view ( 'no_manu_footer', $data );
					return;
				}
				if ($_POST) {
					$config = array (
					array (
					'field' => 'npassword',
					'label' => 'New Password',
					'rules' => 'trim|required|min_length[4]|alpha_dash'
					),
					array (
					'field' => 'cpassword',
					'label' => 'Confirm Password',
					'rules' => 'trim|required|min_length[4]|alpha_dash|matches[npassword]'
					)
					);
					$this->form_validation->set_rules ( $config );
					if ($this->form_validation->run () === false) {
						$this->form_validation->set_error_delimiters('<br />', '');
						$data ['error'] = validation_errors ();
						$data ['main_content'] = 'login/setPassword';
						$this->load->view ( 'no_manu_footer', $data );
						return;
					} else {
						$userdata = new stdClass ();
						$cPass = $this->input->post ( 'cpassword' );
						$rand_salt = $this->admin_vts_auth->genRndSalt();
						$encrypt_pass = $this->admin_vts_auth->encryptUserPwd ( $cPass, $rand_salt );				
						$userdata->password = $encrypt_pass;
						$userdata->salt = $rand_salt;
						$userdata->salt = $rand_salt;
						$updatePass = $this->admin_model->updateUserByEmail_setPassword($email,$userdata );
						
						$res  = $this->admin_vts_auth->process_login(array($email,$cPass));
						
						if ($updatePass) {
							$data['title'] = 'SetPassword';
							$data ['message'] = "Your password has been set successfully !! You will now be redirected to the application.";							
							$data ['main_content'] = 'login/setPassword';
							$this->load->view ( 'no_manu_footer', $data );
						}else{
							$data['title'] = 'SetPassword';
							$data ['error'] = "Unable to reset your password.";
							$data ['main_content'] = 'login/setPassword';
							$this->load->view ( 'no_manu_footer', $data );
						}
					}
					return;
				}
				$data['title'] = 'SetPassword';
				$data ['main_content'] = 'login/setPassword';
				$this->load->view ( 'no_manu_footer', $data );
				return;
			}else{
				redirect("login","refresh");
			}
		}
		function page_not_found(){
			$data['title']        = 'Pagenot Found';
			$data['main_content'] = 'login/error-404';
			$this->load->view('outputPage', $data);
			return;
		}		
		function logout(){ 			
			$tokenCode=$this->session->userdata("accessToken");
			$this->admin_vts_auth->_removeAccessToken($tokenCode);			
			$this->session->unset_userdata("accessToken");
			$this->session->unset_userdata("accesstable");
			$this->session->unset_userdata("is_LoggedIn");
			$this->session->unset_userdata("login_email");
			$this->session->unset_userdata("adminId");
			$this->session->unset_userdata("name");			
			redirect("login","refresh");
		}
	}					