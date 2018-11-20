<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Template extends CI_Controller {
	private $__table       = 'templates'; //this is table on database not include prefix
	private $__default_url = '/admin/campaign/template/list/';
	public function __construct() {
		parent::__construct();
		$this->load->model('auth_model');
		$this->auth_model->is_login();
		$this->load->helper('url');
		$this->load->helper('vik_helper');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('admin_model');
	}
	/**
	 * [home description]
	 * @author VIK thanhne.com
	 * @return [type] [description]
	 */
	public function home() {
		redirect($this->__default_url); //redirect to route..
	}
	/**
	 * [list description]
	 * @author VIK thanhne.com
	 */
	public function list() {
		$this->load->library('pagination');
		#View configuration#
		$data = [
			'meta'       => [ 
				'title' 	 => 'List templates' 
			],
			'subview'    => AD_THEME.'/campaigns/template/list',
			'results'    => '',
			'pagination' => [
				'results'    =>	'',
				'total_rows' => '',
				'limit'		 => '',
				'start'      => '',
				'end'        => '',
			]
		];
		#format query url#
		if ($url_queries = vik_format_input_parameter($this->input->get(['limit'],TRUE))) {
			$this->__default_url .= '?'.http_build_query($url_queries);
		}
		//$by_id = isset($url_queries['by_id']) ? $url_queries['by_id'] : false;
		$limit = isset($url_queries['limit']) ? $url_queries['limit'] : VIK_PER_PAGE;
		$page  = !empty($this->input->get('page')) ? $this->input->get('page') : 1;
		$total_records = $this->admin_model->get_total_records($this->__table);
		if ($total_records > 0) {
			if ($total_records <= $limit) {
				$limit = VIK_PER_PAGE;
			}
			#Page cofiguration#
			$this->pagination->initialize(
				vik_pagination_config([
					'base_url'		=> $this->__default_url,
					'total_rows'    => $total_records,
					'per_page'      => $limit,
				])
			);
			$start_page = ($page - 1) * $limit;
			$end_page 	= $start_page + $limit;
			#get results for view#
			$data['records'] = $this->admin_model->get_current_page_records($this->__table,$limit,$start_page);
			$data['pagination'] = [
				'results'    =>	$this->pagination->create_links(),
				'total_rows' => $total_records,
				'limit'		 => $limit,
				'start'      => ($start_page != 0) ? $start_page : 1,
				'end'        => $end_page
			];
		}
		$this->load->view( AD_THEME.'/master_layout', $data);
	}
	/**
	 * [add description]
	 * @author VIK thanhne.com
	 */
	public function add() {
		$data = [
			'meta'		=> [ //Meta title, descripton...
				'title' => 'Add a template',
			],
			'subview' 	=> AD_THEME.'/campaigns/template/add',
		];
		if ($this->input->post()) {
			$this->form_validation->set_rules([
				[ 
					'field'  => 'txtName',
					'rules'  => 'trim|required|is_unique[templates.name]',
					'errors' => [
						'required'    => 'Please enter the name',
						'is_unique'   => 'The name of template already exists in the system'
					],
				],
				[
					'field'  => 'txtContent',
					'rules'  => 'required',
					'errors' => [
						'required' => 'Please enter the content',
					]
				],
				[
					'field'	=> 'txtStatus',
					'rules' => 'required|numeric|max_length[1]',
					'errors' => [
						'required' => 'Are you hacker ???'
					]
				]
			]);
		  	if ($this->form_validation->run() == true){
		  		#INSERT RECORDS TO DATABASE
		  		$inputs = [
					'name'    => $this->input->post('txtName'),
					'content' => $this->input->post('txtContent'),  
					'status'  => $this->input->post('txtStatus')
		  		];

		  		if ($this->admin_model->template_insert($inputs)) {
		  			$this->session->set_flashdata('_status', 1);
	  				$this->session->set_flashdata('flash_msg', 'The template has been submitted successfully.'); #add is success
	  				$this->home();
				}
            }else {
            	$this->session->set_flashdata('_status', 0);
            }
		}
		$this->load->view( AD_THEME.'/master_layout',$data);
	}
	/**
	 * [edit description]
	 * @author VIK thanhne.com
	 */
	public function edit($id = '') {
		$data = [
			'meta'		=> [ //Meta title, descripton...
				'title' => 'Edit template',
			],
			'subview' 	=> AD_THEME.'/campaigns/template/edit',
		];
		if (!is_numeric($id)) {
			$this->home();
		}
		if ($item = $this->admin_model->template_find($id)) {
			if ($this->input->post()) {
				$valid_data = [
					[ 
						'field'  => 'txtName',
						'rules'  => 'trim|required',
						'errors' => [
							'required'    => 'Please enter the name',
						],
					],
					[
						'field'  => 'txtContent',
						'rules'  => 'required',
						'errors' => [
							'required' => 'Please enter the content',
						]
					],
					[
						'field'	=> 'txtStatus',
						'rules' => 'required|numeric|max_length[1]',
						'errors' => [
							'required' => 'Are you hacker ???'
						]
					]
				];
				if ($item['name'] != $this->input->post('txtName')) { //validate duplicate name
					$valid_data[0]['rules']               .= '|is_unique[templates.name]';
					$valid_data[0]['errors']['is_unique'] = 'The name of template already exists in the system';
				}
				$this->form_validation->set_rules($valid_data);
				if ($this->form_validation->run() == TRUE) {
					$inputs = [
						'name'    => $this->input->post('txtName'),
						'content' => $this->input->post('txtContent'),  
						'status'  => $this->input->post('txtStatus')
			  		];
					if ($this->admin_model->template_update($id,$inputs)) {
						$this->session->set_flashdata('_status', 1);
		  				$this->session->set_flashdata('flash_msg', 'The template has been edited successfully.'); #add is success
		  				$this->home();
					}
				}else {
					$this->session->set_flashdata('_status', 0); #add is fail
				}
			}
			$data['item'] = $item;
			$this->load->view( AD_THEME.'/master_layout',$data);
		}else {
			$this->home();
		}
	}
	/**
	 * [delete description]
	 * @param  string $id [id of template]
	 * @return [type]     [description]
	 */
	public function delete($id = '') {
		if (!is_numeric($id)) {
			$this->home();
		}
		if ($this->admin_model->template_find($id)) {
			if ($this->admin_model->template_delete($id)) {
				$this->session->set_flashdata('flash_msg', 'The template has been deleted successfully.');
				$this->home();
			}
		}else {
			$this->home();
		}
	}
}