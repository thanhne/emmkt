<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('auth_model');
		$this->auth_model->is_login();
	}

	public function home() {
		redirect('/admin/dashboard/');
	}

	public function index() {
		$data = [
			/**
			 * Meta title, descripton...
			 */
			'meta'		=> [
				'title' => 'Dashboard',
			],
			'subview' 	=> AD_THEME.'/dashboard',
		];
		$this->load->view(AD_THEME.'/master_layout',$data);
	}
}
