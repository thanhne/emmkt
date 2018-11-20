<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class VIK_Api extends CI_Controller {
	protected $allowlist, $secret_key;
	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('vik_helper');
		$this->load->library('form_validation');
		$this->load->model('admin_model');
		$this->load->library('session');
	}
	/**
	 * [_home description]
	 * @return [type] [description]
	 */
	protected function _home() {
		if (!$this->input->post()) {
			redirect('/');
			exit();
		}
	}
	/**
	 * [_getAllowDomain allow domain list]
	 * @param  [type] $allow [description]
	 * @return [type]        [description]
	 */
	protected function _getAllowDomain($allow) {
		$allows = '';
		$allows .=  'http://'.str_replace(',',',https://',$allow).',';
		$allows .=  'https://'.str_replace(',',',http://',$allow);
		return $allows;
	}

	protected function getStatusCodeMsg($status){
		$codes = [
			100 => 'Continue',
			101 => 'Switching Protocols',

			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',

			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			306 => '(Unused)',
			307 => 'Temporary Redirect',

			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',

			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported'
		];
		return (isset($codes[$status])) ? $codes[$status] :'';
	}
	/**
	 * [Authenticate authentication API]
	 * @param [type] $getSecretkey [description]
	 */
	protected function Authenticate($getSecretkey) {
		if ($this->secret_key != $getSecretkey) {
			$this->sendResponse(401,'Authentication Failed. Your secret key is not correct');
			exit();
		}
	}
	/**
	 * [_header description]
	 * @return [type] [description]
	 */
	protected function _header() {
		header("Access-Control-Allow-Origin: ".$this->allowlist);
		header("Access-Control-Allow-Methods: POST");
		header("Access-Control-Max-Age: 3600");
	}
	/**
	 * [index description]
	 * @param  string $method [description]
	 * @return [type]         [description]
	 */
	public function index($method = '') {
		//$this->_home();
		if ($item = $this->admin_model->configuration_find(1)) {
			$this->allowlist = $this->_getAllowDomain($item['api_domains']);
			$this->secret_key = $item['api_secret'];
		}
		if (empty($method)) {
			return false;
		}

		$this->_header();
		if ($method == 'transfer') {
			$this->transfer();
		}else if($method == 'transfer_from_file') {
			$this->transfer_from_file();
		}else if($method == 'test') {
			$this->test();
		}
	}

/*	public function transfer_from_file() {
		$this->load->view('upload_form', array('error' => ' ' ));
		if ($this->input->post('submit') == 'ok') {
			$config['upload_path']   = './uploads/api_files/';
			$config['allowed_types'] = 'txt|text|csv';
			//$this->load->library('upload');
	       // $rs = $this->upload->initialize($config);
	       // print_r($rs);
	        //var_dump($this->upload->data());
	        /*if ( ! $this->upload->do_upload('transfer_file')) {
	            return $this->upload->display_errors();
	        }else{
	           	return $this->upload->data();
	        }*/
		}
	}*/
	/**
	 * [transfer transfer email to marketing system]
	 * $data_input = 	'[
	 * 						"email=&firstname=&lastname=&phone=",
	 * 						"email=&firstname=&lastname=&phone="
	 * 					]';
	 * @return [type] [description]
	 */
	public function transfer() {
		$this->Authenticate($this->input->post('secret_key'));
		$data = json_decode($this->input->post('data'));
		if (is_array($data)) {
			$ids = [];
			if (count($data) > 1) {
				foreach ($data as $value) {
					parse_str($value);
					$email = mail_provider_validate(isset($email) ? trim($email) : '');
					if (!$email || empty($email)) {
						continue;
					}
					if ($this->admin_model->contact_find_email($email) === true) {
						continue;
					}
					$inputs = [
						'email'      => $email,
						'first_name' => isset($fname) ? trim($fname) : '',
						'last_name'  => isset($lname) ? trim($lname) : '',
						'phone'      => isset($phone) ? trim($phone) : ''
					];
					$ids[] = $this->admin_model->contact_insert($inputs);
				}
				if (count($ids) > 0) {
					$this->sendResponse(200,json_encode($ids));
				}else {
					$this->sendResponse(200, 'Operation successfully done but No emails added to the system');
				}
			}else {
				parse_str($data[0]);
				$email = mail_provider_validate(isset($email) ? trim($email) : '');
				if (!$email || empty($email)) {
					$this->sendResponse(403,'403 Invalid data input');
					return;
				}
				if ($this->admin_model->contact_find_email($email) === true) {
					$this->sendResponse(409,'409 This email already exists in system');
					return;
				}
				$inputs = [
						'email'      => $email,
						'first_name' => isset($fname) ? trim($fname) : '',
						'last_name'  => isset($lname) ? trim($lname) : '',
						'phone'      => isset($phone) ? trim($phone) : ''
					];
				$ids[] = $this->admin_model->contact_insert($inputs);
				$this->sendResponse(200,json_encode($ids));
			}
		}else {
			$this->sendResponse(403,'403 Invalid data input');
		}
	}
	/**
	 * [sendResponse description]
	 * @param  integer $status       [description]
	 * @param  string  $msg          [description]
	 * @param  string  $content_type [description]
	 * @return [type]                [description]
	 */
	protected function sendResponse($status = 200, $msg = '', $content_type = 'text/html'){
		$success = ($status == 200) ? 'true' : 'false';
		$msg = isset($msg) ? $msg : '';
		$status_header = 'HTTP/1.1 ' . $status . ' ' . $msg; //$this->getStatusCodeMsg($status)
		header($status_header);
		header('Content-type: ' . $content_type);

		echo '{
			"success": '.$success.',
			"status": '.$status.',
			"message": "'.$msg.'"
		}';
	}
}