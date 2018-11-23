<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Campaign extends CI_Controller {
	private $__table       = 'campaigns'; //this is table on database not include prefix
	private $__default_url = '/admin/campaign/email/list/';

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

	public function tracker($tracker) {
		if($tracker) {
			$output = decode_email($tracker);
			if ($output) {
				parse_str($output);
				if ($tracker_type == 'opener') {
					if ($email) {
						$this->opener($email,$campaign_id,$contact_id);
					}
				}else if($tracker_type == 'clicker') {

				}else {

				}
			}
		
			
			/*echo $tracker_type;
			echo '<Br />';
			echo $email;
			echo '<Br />';
			echo $campaign_id;
			echo '<br />';
			echo $contact_id;*/
		}else {

		}

		// /echo $tracker;
		/*$input = 'tracker_type=opener&email=nbthanh93@gmail.com&campaign_id=1&contact_id=1';

		$code = encode_email($input);

		echo $code;*/

		/*if ($tracker == 'op') {
			$this->opener();
		}else if($tracker == 'cli') {

		}else {
			redirect('404');
		}*/
	}

	public function opener($email = '', $campaign_id = '', $contact_id = '') {
		if ($email) {

			//$this->admin_model->

			$graphic_http = $this->config->item('base_url').'/vik/public/admin/assets/dist/blank.gif';

			$filesize = filesize('blank.gif');

			//Now actually output the image requested, while disregarding if the database was affected
			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Cache-Control: private', false);
			header('Content-Disposition: attachment; filename="blank.gif"');
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: ' . $filesize);
			readfile($graphic_http);
			exit;
		}else {
			redirect('404');
		}
	}

	public function clicker() {

	}

	public function unsubscribe() {
		$data = [
			'meta'		=> [ //Meta title, descripton...
				'title' => 'Hủy đăng ký khỏi các danh sách BestPrice',
			],
		];

		if (!$email = $this->input->get('email')) {
			redirect('404');
		}

		$data['unsub_url'] = '/unsubscribe/?status=true&email='.$email;

		$data['skip'] = 'https://www.google.com.vn';

		$status = $this->input->get('status');
		$email = decode_email($email);
		if ($status == 'true') {
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				if ($item = $this->admin_model->contact_find_byEmail($email)) {
					$this->admin_model->contact_delete($item[0]['id']);
					$this->load->view( AD_THEME.'/tracker/unsubscribe_success', $data);
				}else {
					$this->load->view( AD_THEME.'/tracker/unsubscribe_success', $data);
				}
			}
		}else {
			if (!$this->admin_model->contact_find_byEmail($email)) {
				redirect('404');
			}
			$data['email'] = $email;
			$this->load->view( AD_THEME.'/tracker/unsubscribe', $data);
		}
	}

	public function email_ajax() {
		if ($this->input->post('run_campaign')) {
			$id    	= $this->input->post('campaign_id');
			$status = $this->input->post('status');
			if (is_numeric($id)) {
				$status = $this->input->post('status');
				if ($this->admin_model->campaign_update_status($id,$status)) {
					echo 'updated';
				}
			}
		}
	}

	/**
	 * [email_home description]
	 * @author VIK thanhne.com
	 * @return [type] [description]
	 */
	public function email_home() {
		redirect($this->__default_url); //redirect to route..
	}
	/**
	 * [email_list description]
	 * @author VIK thanhne.com
	 */
	public function email_list(){
		$this->load->library('pagination');
		$data = [
			'meta'		=> [ //Meta title, descripton...
				'title' => 'Email campaigns',
			],
			'subview'	=> AD_THEME.'/campaigns/email/list',
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
	 * [email_add description]
	 * @author VIK thanhne.com
	 */
	public function email_add($step = ''){
		if (empty($step)) {
			$this->email_home();
		}

		$data = [
			'meta'		=> [ //Meta title, descripton...
				'title' => 'Campaign builder',
			],
		];

		if ($this->session->has_userdata('_setup')) {
			$data['_setup'] = isset($_SESSION['_setup']) ? $_SESSION['_setup'] : '';
		}
		if ($this->session->has_userdata('_design')) {
			$data['_design'] = isset($_SESSION['_design']) ? $_SESSION['_design'] : '';
		}
		if ($this->session->has_userdata('_recipients')) {
			$data['_recipients'] = isset($_SESSION['_recipients']) ? $_SESSION['_recipients'] : '';
		}

		if ($step == 'setup') {
			$data['subview'] = AD_THEME.'/campaigns/email/add/setup';
			$data['from_mail'] = from_mail_option($this->admin_model->configuration_find(1));
			$this->email_add_setup();
		}else if($step == 'message-design') {
			$data['subview'] = AD_THEME.'/campaigns/email/add/design';

			$txtTemplate = isset($data['_design']['txtTemplate']) ? $data['_design']['txtTemplate'] : '';

			$data['option'] = selected_value($this->admin_model->template_getAll(), $txtTemplate);
			$this->email_add_design();
		}else if($step == 'recipients') {
			$data['subview'] = AD_THEME.'/campaigns/email/add/recipients';

			$recipients = isset($data['_recipients']['group_ids']) ? $data['_recipients']['group_ids'] : array();

			$data['checkbox'] = checkbox_contact_groups($this->admin_model->group_getAll(),$recipients,'table');

			$this->email_add_recipients();
		}else if($step == 'confirmation') {
			$data['subview'] = AD_THEME.'/campaigns/email/add/confirmation';
			$recipients = isset($data['_recipients']['group_ids']) ? $data['_recipients']['group_ids'] : '';
			$data['recipients_selected'] = $this->admin_model->group_find_byids($recipients);
			$this->email_add_confirmation();
		}else if($step == 'schedule'){
			$data['subview'] = AD_THEME.'/campaigns/email/add/schedule';
			$this->email_add_schedule();
		}else {
			$this->email_home();
		}
		$this->load->view( AD_THEME.'/master_layout',$data);
	}
	/**
	 * [email_add_setup description]
	 * @author VIK thanhne.com
	 * @param  string $id [description]
	 * @return [type]     [description]
	 */
	public function email_add_setup($id = '') {
		if ($this->input->post()) {
			$valid_data = [
				[ 
					'field'  => 'txtCampName',
					'rules'  => 'trim|required|is_unique[campaigns.name]',
					'errors' => [
						'required'    => 'Please enter the name of campaign',
						'is_unique'	  => 'The campaign name already exists in the system'
					],
				],
				[
					'field'  => 'txtSubject',
					'rules'  => 'trim|required|min_length[5]',
					'errors' => [
						'required'    => 'Please enter the subject of campaign',
						'min_length'  => 'The Subject must be minimum 5 characters required'
					],
				],
				[
					'field'  => 'txtFromEmail',
					'rules'  => 'trim|required|valid_email',
					'errors' => [
						'required'  => 'Please choose From email. Are you hacker ?',
						'valid_email'  => 'Please enter a valid email. (example@domain.com)'
					],
				],
				[
					'field'  => 'txtFromName',
					'rules'  => 'required',
					'errors' => [
						'required'  => 'Please enter the From Name.',
					],
				],
				[
					'field'  => 'txtReplyEmail',
					'rules'  => 'trim|valid_email',
					'errors' => [
						'valid_email'  => 'Please enter a valid email. (example@domain.com)',
					],
				]
			];
			$this->form_validation->set_rules($valid_data);
			if ($this->form_validation->run() == true) {
				$setup = $this->input->post(['txtCampName','txtSubject','txtFromEmail','txtFromName','txtReplyEmail']);
				if (count($setup) == 5) {
					$this->session->set_userdata('_setup',$setup);
					redirect('/admin/campaign/email/add/message-design/');
				}
			}else {
				$this->session->set_flashdata('_status', 0);
			}
		}
	}
	/**
	 * [email_add_design description]
	 * @author VIK thanhne.com
	 * @param  string $id [description]
	 * @return [type]     [description]
	 */
	public function email_add_design($id = '') {
		if (!$this->session->has_userdata('_setup')) {
			$this->session->set_flashdata('error_msg', 'Ops! please enter Setup\'s step once again');
			redirect('/admin/campaign/email/add/setup/');
		}
		if ($this->input->post()) {
			$valid_data = [
				[ 
					'field'  => 'txtTemplate',
					'rules'  => 'trim|required|numeric',
					'errors' => [
						'required'    => 'Please choose a template',
						'numeric'  	=> 'Are you hacker ??'
					],
				],
			];
			$this->form_validation->set_rules($valid_data);
			if ($this->form_validation->run() == TRUE) {
				$design = $this->input->post(['txtTemplate']);
				if (count($design) == 1) {
					$this->session->set_userdata('_design',$design);
					redirect('/admin/campaign/email/add/recipients/');
				}else {

				}
			}else {
				$this->session->set_flashdata('_status', 0);
			}
		}
	}
	/**
	 * [email_add_recipients description]
	 * @author VIK thanhne.com
	 * @param  string $id [description]
	 * @return [type]     [description]
	 */
	public function email_add_recipients($id = '') {
		if (!$this->session->has_userdata('_design')) {
			$this->session->set_flashdata('error_msg', 'Ops! please choose message design once again');
			redirect('/admin/campaign/email/add/message-design/');
		}
		
		if ($this->input->post()) {
			$valid_data = $valid_data = [
				[ 
					'field'  => 'group_ids[]',
					'rules'  => 'required', //in_list[1,2,3,4,5,6]
					'errors' => [
						'required'    => 'Please check at least one item of recipients group to run'
					],
				],
			];
			$this->form_validation->set_rules($valid_data);
			if ($this->form_validation->run() == TRUE) {
				$recipients = $this->input->post(['group_ids']);
				if (count($recipients) == 1) {
					$this->session->set_userdata('_recipients',$recipients);
					redirect('/admin/campaign/email/add/confirmation/');
				}else {
					
				}
			}else {
				$this->session->set_flashdata('_status', 0);
			}
		}
	}
	/**
	 * [email_add_confirmation description]
	 * @author VIK thanhne.com
	 * @param  string $id [description]
	 * @return [type]     [description]
	 */
	public function email_add_confirmation($id = '') {
		if (!$this->session->has_userdata('_recipients')) {
			$this->session->set_flashdata('error_msg', 'Ops! Please check at least one item of recipients group again');
			redirect('/admin/campaign/email/add/recipients/');
		}
		$setup = isset($_SESSION['_setup']) ? $_SESSION['_setup'] : 0;
		$design = isset($_SESSION['_design']) ? $_SESSION['_design'] : 0;
		$recipients = isset($_SESSION['_recipients']) ? $_SESSION['_recipients'] : 0;


		
		if ($this->input->post('save_quit')) {
			$save_data = [
				'name'          => $setup['txtCampName'],
				'subject'       => $setup['txtSubject'],
				'from_mail'      => $setup['txtFromEmail'],
				'from_name'     => $setup['txtFromName'],
				'custom_reply'  => $setup['txtReplyEmail'],
				'template_id'   => $design['txtTemplate'],
				//'recipient_ids' => $recipients['group_ids'],
			];
			if ($inserted_id = $this->admin_model->campaign_insert($save_data)) {
				if ($this->admin_model->relationships_insert_array($inserted_id,$recipients['group_ids'],'campaign')) {
					$this->session->set_flashdata('_status', 1);
	  				$this->session->set_flashdata('flash_msg', 'The Campaign has been submitted successfully.'); #add is success
	  				#unset session data
	  				$this->session->unset_userdata('_setup');
	  				$this->session->unset_userdata('_design');
	  				$this->session->unset_userdata('_recipients');
	  				#insert success redirect to home
	  				$this->email_home();
				}else {
					//if the system can not insert groups! It will remove contact have inserted before
	  				$this->admin_model->campaign_delete($inserted_id);
	  				$this->session->set_flashdata('_status', 0);
				}
			}else {
				$this->session->set_flashdata('_status', 0);
			}
		}else if($this->input->post('save_send')) {
			$save_data = [
				'name'          => $setup['txtCampName'],
				'subject'       => $setup['txtSubject'],
				'from_mail'      => $setup['txtFromEmail'],
				'from_name'     => $setup['txtFromName'],
				'custom_reply'  => $setup['txtReplyEmail'],
				'template_id'   => $design['txtTemplate'],
				'status'   		=> 1,
				//'recipient_ids' => $recipients['group_ids'],
			];
			if ($inserted_id = $this->admin_model->campaign_insert($save_data)) {
				if ($this->admin_model->relationships_insert_array($inserted_id,$recipients['group_ids'],'campaign')) {
					$this->session->set_flashdata('_status', 1);
	  				$this->session->set_flashdata('flash_msg', 'The Campaign has been submitted successfully.'); #add is success
	  				#unset session data
	  				$this->session->unset_userdata('_setup');
	  				$this->session->unset_userdata('_design');
	  				$this->session->unset_userdata('_recipients');
	  				#insert success redirect to home
	  				$this->email_home();
				}else {
					//if the system can not insert groups! It will remove contact have inserted before
	  				$this->admin_model->campaign_delete($inserted_id);
	  				$this->session->set_flashdata('_status', 0);
				}
			}else {
				$this->session->set_flashdata('_status', 0);
			}
		}
	}
	/*//optimize two method email_add_schedule + email_add_confirmation
	private $_mailFrom, $_mailName, $_mailSubject, $_mailContent, $_mailReply, $_email_list;
	public function email_add_schedule() {

		$setup      = isset($_SESSION['_setup']) ? $_SESSION['_setup'] : 0;
		$design     = isset($_SESSION['_design']) ? $_SESSION['_design'] : 0;
		$recipients = isset($_SESSION['_recipients']) ? $_SESSION['_recipients'] : 0;

		if (!$setup) {
			redirect('/admin/campaign/email/add/setup/');
		}

		if (!$design) {
			redirect('/admin/campaign/email/add/message-design/');
		}

		if (!$recipients) {
			redirect('/admin/campaign/email/add/recipients/');
		}

		$templateid = isset($design['txtTemplate']) ? $design['txtTemplate'] : '';
		if(is_numeric($templateid)){
			$this->_mailContent = $this->admin_model->template_find($templateid)['content'];
		}

		$this->_mailSubject = isset($setup['txtSubject']) ? $setup['txtSubject'] : '';
		$this->_mailName    = isset($setup['txtFromName']) ? $setup['txtFromName'] : '';
		$this->_mailReply   = isset($setup['txtReplyEmail']) ? $setup['txtReplyEmail'] : '';

		$group_ids = isset($recipients['group_ids']) ? $recipients['group_ids'] : '';
		if (!empty($group_ids)) {
			$contact_ids = $this->admin_model->Find_contactID_by_groupID($group_ids);
			foreach ($contact_ids as $c_ids) {
				if ($c_ids['contact_id']) {
					$this->_email_list[] = $this->admin_model->contact_get_mail($c_ids['contact_id']);
				}
			}
		}
		if ($this->input->post('schedule')) {
			$save_data = [
				'name'          => $setup['txtCampName'],
				'subject'       => $setup['txtSubject'],
				'from_mail'      => $setup['txtFromEmail'],
				'from_name'     => $setup['txtFromName'],
				'custom_reply'  => $setup['txtReplyEmail'],
				'template_id'   => $design['txtTemplate'],
				//'recipient_ids' => $recipients['group_ids'],
			];
			if ($inserted_id = $this->admin_model->campaign_insert($save_data)) {
				if ($this->admin_model->relationships_insert_array($inserted_id,$recipients['group_ids'],'campaign')) {
					$this->session->set_flashdata('_status', 1);
	  				$this->session->set_flashdata('flash_msg', 'The Campaign has been submitted successfully.'); #add is success
	  				#unset session data
	  				$this->session->unset_userdata('_setup');
	  				$this->session->unset_userdata('_design');
	  				$this->session->unset_userdata('_recipients');
	  				#insert success redirect to home
	  				$this->email_home();
				}else {
					//if the system can not insert groups! It will remove contact have inserted before
	  				$this->admin_model->campaign_delete($inserted_id);
	  				$this->session->set_flashdata('_status', 0);
				}
			}else {
				$this->session->set_flashdata('_status', 0);
			}
		}
	}

	public function schedule() {
		$this->load->library('send_mail');
	}*/

	public function email_edit(){
		//$this->load->view('VIK-CMS/admin/campaigns/email/edit');
	}

	/*public function email_delete(){
		//$this->load->view('VIK-CMS/admin/campaigns/email/delete');
	}*/
}
