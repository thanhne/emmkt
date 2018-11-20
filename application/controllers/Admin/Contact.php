<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Contact extends CI_Controller {
	private $__table       = 'contacts'; //this is table on database not include prefix
	private $__default_url = '/admin/contact/list/';
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
	 * @return [type] [description]
	 */
	public function list() {
		log_message('error','abc');
		//die();
		$this->load->library('pagination');
		#View configuration#
		$data = [
			'meta'       => [ 
				'title' 	 => 'Contacts' 
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
		$by_id = isset($url_queries['by_id']) ? $url_queries['by_id'] : false;
		$limit = isset($url_queries['limit']) ? $url_queries['limit'] : VIK_PER_PAGE;
		$page  = !empty($this->input->get('page')) ? $this->input->get('page') : 1;
		$total_records = $this->admin_model->get_total_records($this->__table,'group_id',$by_id);
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
			$data['records'] = $this->admin_model->get_current_page_records($this->__table,$limit,$start_page,'group_id',$by_id);
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
				'title' => 'Add a contact',
			],
			'subview' 	=> AD_THEME.'/contacts/add',
		];

		$data['groups'] = checkbox_contact_groups($this->admin_model->group_getAll());
		if ($this->input->post()) {
			$this->form_validation->set_rules([
				[ 
					'field'  => 'txtEmail',
					'rules'  => 'trim|required|valid_email|is_unique[contacts.email]',
					'errors' => [
						'required'    => 'Please enter email',
						'valid_email' => 'Please enter a valid email. (example@domain.com)',
						'is_unique'   => 'Email already exists in the system'
					],
				],
				[
					'field'	=> 'txtGroups[]',
					'rules' => 'required',
					'errors' => [
						'required' => 'Please check at least once Group'
					]
				]
			]);
		  	if ($this->form_validation->run() == true){
		  		#INSERT RECORDS TO DATABASE
		  		$inputs = [
						'first_name'       => $this->input->post('txtFname'),
						'last_name'        => $this->input->post('txtLname'),
						'email'            => $this->input->post('txtEmail'),
						'phone'            => $this->input->post('txtPhone')
		  		];
		  		$groups = $this->input->post('txtGroups');
		  		$inserted_id = $this->admin_model->contact_insert($inputs);
		  		if (isset($inserted_id) && is_numeric($inserted_id)) {
		  			if ($this->admin_model->relationships_insert_array($inserted_id,$groups,'contact')) {
		  				$this->session->set_flashdata('_status', 1);
		  				$this->session->set_flashdata('flash_msg', 'The contact has been submitted successfully.'); #add is success
		  				$this->home();
		  			}else { 
		  				//if the system can not insert groups! It will remove contact have inserted before
		  				$this->admin_model->contact_delete($inserted_id);
		  				$this->session->set_flashdata('_status', 0);
		  			}
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
	 * @param  boolean $id [description]
	 * @return [type]      [description]
	 */
	public function edit($id = '') {
		$data = [
			'meta'		=> [ //Meta title, descripton...
				'title' => 'Edit contact',
			],
			'subview' 	=> AD_THEME.'/contacts/edit',
		];
		if (!is_numeric($id)) {
			$this->home();
		}
		$item = $this->admin_model->contact_find($id);
		$relationship = $this->admin_model->relationships_find_group_bycontact($id);
		$data['groups'] = checkbox_contact_groups($this->admin_model->group_getAll(),$relationship);
		if ($item) {
			if ($this->input->post()) {
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
						'field'	=> 'txtGroups[]',
						'rules' => 'required',
						'errors' => [
							'required' => 'Please check at least once Group'
						]
					]
				];
				if ($item['email'] != $this->input->post('txtEmail')) { //validate duplicate name
					$valid_data[0]['rules']               .= '|is_unique[contacts.email]';
					$valid_data[0]['errors']['is_unique'] = 'Email already exists in the system';
				}
				$this->form_validation->set_rules($valid_data);
				if ($this->form_validation->run() == TRUE) {
					$inputs = [
						'first_name'       => $this->input->post('txtFname'),
						'last_name'        => $this->input->post('txtLname'),
						'email'            => $this->input->post('txtEmail'),
						'phone'            => $this->input->post('txtPhone')
		  			];
		  			$groups = $this->input->post('txtGroups');
		  			$update_group = $this->admin_model->relationships_update_array($id,$groups);
					if ($this->admin_model->contact_update($id,$inputs) || $update_group) {
						$this->session->set_flashdata('_status', 1);
		  				$this->session->set_flashdata('flash_msg', 'The contact has been edited successfully.'); #add is success
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
	public function import() {
		//echo hash('tiger192,3', 'bestprice123');
		$data = [
			'meta'		=> [ //Meta title, descripton...
				'title' => 'Import contact from file',
			],
			'subview' 	=> AD_THEME.'/contacts/import',
		];
		if ($this->input->post('submit') == 'ok') {
			$config['upload_path']   = './uploads/api_files/';
			$config['allowed_types'] = 'txt|text|csv';
			$this->load->library('upload');
	        $this->upload->initialize($config);

	       if ( ! $this->upload->do_upload('transfer_file')) {
	            $this->session->set_flashdata('flash_msg', $this->upload->display_errors());
	            $this->session->set_flashdata('_status', 0);
	           	redirect($_SERVER['REQUEST_URI']); 
	        }else{
	        	if ($result = $this->upload->data('full_path')) {
	        		
	        	}
	        }
		}
		$this->load->view( AD_THEME.'/master_layout',$data);
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
		if ($this->admin_model->contact_find($id)) {
			if ($this->admin_model->contact_delete($id)) {
				$this->admin_model->relationships_delete('',$id);
				$this->session->set_flashdata('flash_msg', 'The contact has been deleted successfully.');
				$this->home();
			}
		}else {
			$this->home();
		}
	}

	/*public function export() {

	}*/

}
?>