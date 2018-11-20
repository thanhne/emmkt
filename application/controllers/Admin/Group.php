<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Contact groups Controller it mean contact list group
 */
class Group extends CI_Controller {
	private $__table 	= 'groups'; //this is table on database not include prefix
	private $__default_url = '/admin/contact/group/list/';

	public function __construct() {
		parent::__construct();
		$this->load->model('auth_model');
		$this->auth_model->is_login();
		$this->load->helper('url');
		$this->load->helper('vik_helper');
		$this->load->model('admin_model');
		$this->load->library('session');
	}
	/**
	 * [home redirect directory default route]
	 * @author VIK thanhne.com
	 * @return [type] [description]
	 */
	public function home() {
		redirect($this->__default_url); 
	}
	/**
	 * [list description]
	 * @author VIK thanhne.com
	 * @return [type] [description]
	 */
	public function list() {
		$this->load->library('pagination');
		#Default configuration#
		$data = [
			'meta'       => [ 
				'title' 	 => 'Contact Groups' 
			],
			'subview'    => AD_THEME.'/'.$this->__table.'/list',
			'records'    => '',
			'pagination' => [
				'results'    =>	'',
				'total_rows' => '',
				'limit'		 => '',
				'start'      => '',
				'end'        => '',
			]
		];
		#format query url#
		if ($url_queries = vik_format_input_parameter($this->input->get(['by_id','limit'],TRUE))) {
			$this->__default_url .= '?'.http_build_query($url_queries);
		}
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
				'end'        => $end_page,
			];
		}
		$this->load->view( AD_THEME.'/master_layout', $data);
	}
	/**
	 * [add description]
	 * @author VIK thanhne.com
	 */
	public function add() {
		$this->load->library('form_validation');
		$data = [
			'meta'		=> [ //Meta title, descripton...
				'title' => 'Add a contact groups',
			],
			'subview' 	=> AD_THEME.'/'.$this->__table.'/add',
		];
		if ($this->input->post()) {
			$valid_data = [
				[
					'field'  => 'txtName', 
					'rules'  => 'trim|required|is_unique[groups.name]',
					'errors' => [
						'required' 	=> 'Please inter contact group name',
						'is_unique' => 'Name already exists in the system'
					],
				],
			];
			$this->form_validation->set_rules($valid_data);
			if ($this->form_validation->run() == TRUE) {
				$inserted_id = $this->admin_model->group_insert($this->input->post('txtName'));
				if (isset($inserted_id) && is_numeric($inserted_id)) {
					$this->session->set_flashdata('_status', 1); #add is success
					$this->session->set_flashdata('flash_msg', 'The group has been submitted successfully.'); #add is success
					$this->home();
				}
			}else {
				$this->session->set_flashdata('_status', 0); #add is fail
			}
		}
		$this->load->view( AD_THEME.'/master_layout',$data);
	}
	/**
	 * [edit description]
	 * @author VIK thanhne.com
	 * @param  string $id [description]
	 * @return [type]     [description]
	 */
	public function edit($id = '') {
		$this->load->library('form_validation');
		$data = [
			'meta'		=> [ //Meta title, descripton...
				'title' => 'Edit a contact groups',
			],
			'subview' 	=> AD_THEME.'/'.$this->__table.'/edit',
		];
		if (!is_numeric($id)) {
			$this->home();
		}
		if ($item = $this->admin_model->group_find($id)) {
			if ($this->input->post()) {
				$valid_data = [
					[
						'field'  => 'txtName', 
						'rules'  => 'trim|required',
						'errors' => [
							'required' 	=> 'Please inter contact group name',
						],
					],
				];
				if ($item['name'] != $this->input->post('txtName')) { //validate duplicate name
					$valid_data[0]['rules'] .= '|is_unique[groups.name]';
					$valid_data[0]['errors']['is_unique'] = 'Name already exists in the system';
				}
				$this->form_validation->set_rules($valid_data);
				if ($this->form_validation->run() == TRUE) {
					if ($item['name'] == $this->input->post('txtName')) {
						$this->session->set_flashdata('_status', -1); #add is success
					}else {
						if($this->admin_model->group_update($id,$this->input->post('txtName'))){
							$this->session->set_flashdata('_status', 1); #add is success
							$this->session->set_flashdata('flash_msg', 'The group has been edited successfully.'); #add is success
							$this->home();
						}
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
	 * @author VIK thanhne.com
	 * @param  string $id [description]
	 * @return [type]     [description]
	 */
	public function delete($id = '') {
		if (!is_numeric($id)) {
			$this->home();
		}
		if ($this->admin_model->group_find($id)) {
			if ($this->admin_model->group_delete($id)) {
				$this->admin_model->relationships_delete($id);
				$this->session->set_flashdata('flash_msg', 'The group has been deleted successfully.');
				$this->home();
			}
		}else {
			$this->home();
		}
	}
}
?>