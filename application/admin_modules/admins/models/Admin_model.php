<?php
	class Admin_model extends CI_Model{
		var $tbladmin='admin';		
		var	$tblResetPassword='resetpassword';			
		var	$tableAccessToken='access_token';		
		function __construct(){
			parent::__construct();						
		}
		function admin_signup($data){ // insert recored in users table
			$this->db->trans_start();
			$query=$this->db->insert($this->tbladmin,$data);
			$insert_id = $this->db->insert_id();
			$this->db->trans_complete();
			return $insert_id;
		}
		function insert_users($data){ // insert recored in users table
			$this->db->trans_start();
			$query=$this->db->insert($this->tbladmin,$data);
			$insert_id = $this->db->insert_id();
			$this->db->trans_complete();
			return $insert_id;
		}		
		function Get_all_users(){	// get all recored in users table			
			$this->db->select('*');						
			$this->db->where('isDeleted',0);
			$this->db->where('users_type',2);
			$this->db->from("$this->tbladmin");			
			$q = $this->db->get();			
			return $q->result();
		}
		function active_users(){	// get all recored in users table			
			$this->db->select('*');						
			$this->db->where('isDeleted',0);
			$this->db->where('status',1);
			$this->db->where('users_type',2);
			$this->db->from("$this->tbladmin");			
			$q = $this->db->get();			
			return $q->result();
		}
		
		function inactive_users(){	// get all recored in users table			
			$this->db->select('*');						
			$this->db->where('isDeleted',0);
			$this->db->where('status',0);
			$this->db->where('users_type',2);
			$this->db->from("$this->tbladmin");			
			$q = $this->db->get();			
			return $q->result();
		}
		function updateusers($vid,$data){ // update recored in users table
			$where = "admin_id = '$vid'";
			$str = $this->db->update_string($this->tbladmin, $data, $where);
			$query = $this->db->query($str);
			return $query;
		}
		
		function updateusers_changepassword($vid,$data){ // update recored in users table
			$where = "users_code = '$vid'";
			$str = $this->db->update_string($this->tbladmin, $data, $where);
			$query = $this->db->query($str);
			return $query;
		}
		function get_veryfyemail($email){ // get recored by email_id in users table
			$this->db->where('email',$email);
			$this->db->where('isDeleted',0);
			$query = $this->db->get($this->tbladmin);
			if ( $query->num_rows() > 0 ){
				return true;
				}else{
				return false;
			}
		}
		function validateEmail($email){
			$query = $this->db->query("SELECT * FROM $this->tbladmin where email=? and isDeleted=0",$email);
			if($query->num_rows()>0){
				return $query->row()->admin_id;
				}else{
				return false;
			}
		}
		function Emailbyadmindata($email){			
			$query = $this->db->query("SELECT * FROM $this->tbladmin where email=?",$email);			
			if($query->num_rows() > 0){
				return $query->result();
				}else{
				return false;
			}
		}
		function check_email($email){
			$query = $this->db->query("SELECT * FROM $this->tbladmin where email=?",$email);
			if($query->num_rows() > 0){
				return true;
				}else{
				return false;
			}
		} 
		function getActKey($tablename,$email){
			$k="";
			$query = $this->db->query("SELECT activationCode FROM $tablename where email=? and isDeleted=0",$email);
			if($query->num_rows() > 0){
				$k=$query->row()->activationCode;
				}else{
				$k="";
			}
			return $k;
		}
		function updateKey($tablename,$email, $cData){
			$data = (array)$cData;
			$where = "email = '$email'";
			$str = $this->db->update_string($tablename, $data, $where);
			$query = $this->db->query($str);
			return $query;
		}
		function get_userdetailsbyid($uid){ // get recored by email_id in users table
			$this->db->where('user_id',$uid);
			$this->db->where('isDeleted',0);
			$query = $this->db->get($this->tbladmin);
			if ( $query->num_rows() > 0 ){
				return $query->result();
			}else{
				return false;
			}
		}
		function get_userdetailsbyEmail($email){ // get recored by email_id in users table
			$this->db->where('email',$email);
			$this->db->where('isDeleted',0);
			$query = $this->db->get($this->tbladmin);
			if ( $query->num_rows() > 0 ){
				return $query->result();
			}else{
				return false;
			}
		}
		function updateUserByEmail($userid,$udata){ // update recored by email_id in users table
			$data = (array)$udata;
			$where = "users_code = '$userid'";
			$str = $this->db->update_string($this->tbladmin, $data, $where);
			$query = $this->db->query($str);
			return $query;
		}
		function updateUserByEmailRest($tablename,$email,$udata){ // update recored by email_id in users table
			$data = (array)$udata;
			$where = "email = '$email'";
			$str = $this->db->update_string($tablename, $data, $where);
			$query = $this->db->query($str);
			return $query;
		}
		function updateUserByEmail_setPassword($email,$udata){ // update recored by email_id in users table
			$data = (array)$udata;
			$where = "email = '$email'";
			$str = $this->db->update_string($this->tbladmin, $data, $where);
			$query = $this->db->query($str);
			return $query;
		}
		function ForgotvalidateEmail($tablename,$email){
			$query = $this->db->query("SELECT * FROM $tablename where email=? and isDeleted=0",$email);
			if($query->num_rows()>0){			
				return $query->row()->users_code;
				}else{
				return false;
			}
		}
		function updateResetPasswordLink($email, $userdata){
			$data = (array)$userdata;
			$where = "email = '$email'";
			$str = $this->db->update_string($this->tblResetPassword, $data, $where);
			$query = $this->db->query($str);
			return $query;
		}
		function validateresetEmail($email){
			$query = $this->db->query("SELECT email FROM $this->tblResetPassword where email=?",$email);
			if($query->num_rows() > 0){
				return true;
				}else{
				return false;
			}
		}
		function saveResetPasswordLink($data){
			$this->db->trans_start();
			$this->db->insert($this->tblResetPassword,$data);
			$insert_id = $this->db->insert_id();
			$this->db->trans_complete();
			return  $insert_id;
		}
		function validateresetCode($email,$rCode){
			$query = $this->db->query("SELECT email FROM $this->tblResetPassword where email=? and resetcode='$rCode'",$email);
			if($query->num_rows() > 0){
				return true;
				}else{
				return false;
			}
		}		
		function removeResetEntry($email,$code){
			$query = $this->db->query("delete from $this->tblResetPassword where email=? and resetcode='$code'",$email);
			return $query;
		}
		function storeToken($id,$tokenCode){		
			$query = $this->db->query("SELECT * FROM `access_token` WHERE users_code='$id' LIMIT 1");
			if ($query->num_rows() === 1){
				$query=$this->db->query("Update $this->tableAccessToken set tokenCode=? where users_code=?",array($tokenCode,$id));
				return $query;
			}else{
				$this->db->trans_start();
				$this->db->insert($this->tableAccessToken,array("users_code"=>"$id","tokenCode"=>$tokenCode));
				$insert_id = $this->db->insert_id();
				try{
					$this->db->query("delete from $this->tableAccessToken where users_code='$id' and createdOn < DATE_SUB(NOW() , INTERVAL 1 DAY)");
				}catch(Exception $e){}
				$this->db->trans_complete();
				return  $insert_id;
			}
		}
		function removeToken($tokenCode){		
			$query = $this->db->query("delete FROM $this->tableAccessToken where tokenCode=?",$tokenCode);
			if($query){
				return true;
				}else{
				return false;
			}
		}
		function Set_resetpassword($email){
			$query = $this->db->query("SELECT email FROM $this->tbladmin where email=? and password='' and salt='' ",$email);
			if($query->num_rows() > 0){
				return true;
				}else{
				return false;
			}
		}
	}
?>																																										