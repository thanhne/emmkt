<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('vik_helper');
		$this->load->library('form_validation');
		$this->load->model('auth_model');
		$this->load->library('session');
	}

	public function home() {

	}

	public function logout() {
		if ($this->session->has_userdata('is_login_email')) {
			unset($_SESSION['is_login_email']);
			redirect('/admin/login/');
		}
	}

	public function login() {
		if ($this->session->userdata('is_login_email')) {
			redirect('/admin/dashboard/');
		}
		$data = [
			'meta'		=> [ //Meta title, descripton...
				'title' => 'Administrator Login',
			]
		];

		if ($this->input->post('login') == 'true') {
			$valid_data = [
				[ 
					'field'  => 'txtEmail',
					'rules'  => 'trim|required|valid_email',
					'errors' => [
						'required'    => 'Please enter the email',
						'valid_email' => 'Please enter a valid email. (example@domain.com)'
					],
				],
				[
					'field'	=> 'txtPass',
					'rules' => 'required|min_length[8]',
					'errors' => [
						'required' => 'Please enter the password',
						'min_length' => 'Passwords must be at least 8 characters in length',
					]
				]
			];
			$this->form_validation->set_rules($valid_data);
			if ($this->form_validation->run() == TRUE) {
				$email = $this->input->post('txtEmail');
				$pass = hash('tiger192,3', $this->input->post('txtPass'));
				if ($this->auth_model->auth_email_pass($email,$pass)) {
					$this->session->set_userdata(['is_login_email'  => $email]);
					redirect('/admin/dashboard/');
				}else {
					$this->session->set_flashdata('_status', 3);
				}
			}else {
				$this->session->set_flashdata('_status', 0); #add is fail
			}
		}

		$this->load->view( AD_THEME.'/auth/login',$data);
	}
}