<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuration extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('auth_model');
		$this->auth_model->is_login();
		$this->load->helper('url');
		$this->load->helper('vik_helper');
		$this->load->library('form_validation');
		$this->load->model('admin_model');
		$this->load->library('session');

	}

	public function home() {
		redirect('/admin/dashboard/');
	}

	public function index() {
		$data = [
			'meta'		=> [
				'title' => 'Setting Your System',
			],
			'subview' 	=> AD_THEME.'/configuration/config_view',
		];
		if ($item = $this->admin_model->configuration_find(1)) {
			if ($this->input->post()) {
				if ($this->input->post('txtProtocol') || $this->input->post('txtEmailHost') ||
					$this->input->post('txtEmailUsername')) {
					$valid_data = [
						[
							'field'  => 'txtSendFrom',
							'rules'  => 'required|valid_email',
							'errors' => [
								'required'    => 'Please enter the root email',
								'valid_email' => 'Please enter a valid email. (example@domain.com)',
							]
						],
						[
							'field'  => 'txtEmailPort',
							'rules'  => 'numeric',
							'errors' => [
								'required' => 'Please enter a valid number',
							]
						],
						[
							'field'  => 'txtEmailUsername',
							'rules'  => 'valid_email',
							'errors' => [
								'valid_email' => 'Please enter a valid email. (example@domain.com)',
							]
						],
					];
					$this->form_validation->set_rules($valid_data);
				}

				
				if ($this->form_validation->run() == TRUE) {
					$inputs = [
						'api_domains'   => $this->input->post('txtRequestDomain'),
						'mail_from'		=> $this->input->post('txtSendFrom'),
						'mail_protocol' => $this->input->post('txtProtocol'),
						'mail_host'     => $this->input->post('txtEmailHost'),  
						'mail_port'     => $this->input->post('txtEmailPort'),  
						'mail_user'     => $this->input->post('txtEmailUsername')
			  		];

			  		$pass = $this->input->post('txtEmailPassword');
			  		if ($pass && !empty($pass)) {
			  			$inputs['mail_password'] = $this->input->post('txtEmailPassword');
			  		}

			  		//$api_secret = $this->input->post('txtSecretKey');

					if ($this->admin_model->configuration_update(1,$inputs)) {
						$this->session->set_flashdata('_status', 1);
		  				$this->session->set_flashdata('flash_msg', 'The Setting has been updated successfully.'); #add is success
		  				//$this->home();
					}
				}else {
					$this->session->set_flashdata('_status', 0); #add is fail
				}
			}
			$data['item'] = $item;
			$this->load->view( AD_THEME.'/master_layout',$data);
		}else {
			//insert default
		}
	}

	public function generating_secret_key() {
		$this->load->library('encryption');
		$this->encryption->initialize(array('driver' => 'openssl'));
		if ($this->input->post('get_secret_key')) {
			$key = 'VIK-CMS'.rand(1, 1000000);
			$secret_key = hash('tiger192,3', $key);
			if ($secret_key) {
				$this->admin_model->configuration_update(1,[ 'api_secret' => $secret_key ]);
				echo $secret_key;
			}
		}
	}
}
