<?php 	
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth_model extends CI_Model{
	public function __construct() {
    	$this->load->database();
    	$this->load->library('session');
	}

	public function auth_email_pass($email,$pass){
		$this->db->from('users');
		$this->db->where('email',$email);
		$this->db->where('password',$pass);
		if ($this->db->count_all_results() > 0) {
			return true;
		}
		return false;
	}

	public function is_login() {
		if (!$this->session->userdata('is_login_email')) {
			redirect('/admin/login/');
		}
	}
}