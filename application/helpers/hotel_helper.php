<?php 
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if ( ! function_exists('test_method')){
		function test_method($var = '')
		{
			return $var;
		}   
	}
	if ( ! function_exists('base_url'))
	{
		function base_url($uri = '')
		{
			/* $u=get_instance()->config->base_url();
				$res=substr($u, 0, -6);
			return $res.$uri; */
			return BASE_URL .'/';
		}
	}
	if (!function_exists('isSuperAdmin'))
	{
		function isSuperAdmin()
		{
			$ci=& get_instance();		
			$uId=$ci->session->userdata('login_Id');	
			$query = $ci->db->query("SELECT * FROM `admin` WHERE users_code=? and isDeleted=0 and isDeleted=0",array($uId));		
			if($query->num_rows()>0 && isset($query->row()->users_type)){
				return $query->row()->users_type;
				}else{
				return false;
			}
		}
	}
	if (!function_exists('getuserDetails'))
	{
		function getuserDetails($email){
			$ci=& get_instance();				
			$query = $ci->db->query("SELECT * FROM `admin` WHERE email=? and isDeleted=0 and isDeleted=0",array($email));		
			if($query->num_rows()>0 && isset($query->row()->users_type)){
				$array=array('admin',$query->row()->users_code);
				return $array;
			}else{				
				return false;
			}
			return false;
		}
	}
	if (!function_exists('emailvarify'))
	{
		function emailvarify($email)
		{
			$ci=& get_instance();
			$uId=$ci->session->userdata('login_Id');		
			$query = $ci->db->query("SELECT email FROM `admin` WHERE email='$email' and isDeleted=0");			
			if($query->num_rows()>0){
				return true;
			}else{
				return false;
			}
			return false;
		}
	}	
	if (!function_exists('getAutoincrimentId'))
	{
		function getAutoincrimentId(){
			$ci=& get_instance();			
			$query = $ci->db->query("SELECT * FROM `admin` WHERE isDeleted=0 ORDER BY admin_id DESC");
			if($query->num_rows()>0){
				$consultantsId=$query->row()->admin_id;				
				return ($consultantsId+1);
			}else{
				return 1;
			}
		}
	}