<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sendmail{
	protected $CI;
	protected $From,$Name,$mailTo,$Subject,$Content,$replyTo;
	public $send_status;

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->library('email');
		$this->CI->load->library('encrypt');
	}

	public function mailConfig($ptcol,$host,$port,$user,$pass,$timeout = 30) {
		$config = [
		 	'protocol'  => isset($ptcol) ? $ptcol : 'smtp',
		    'smtp_host' => isset($host) ? $host : 'ssl://smtp.gmail.com',
		    'smtp_port' => isset($port) ? $port : 465,
		    'smtp_user' => isset($user) ? $user : '',
		    'smtp_pass' => isset($pass) ? $pass : '',
		    'mailtype'  => 'html',
		    'charset'   => 'utf-8',
		    'smtp_timeout'	=> $timeout
		];

		$this->CI->email->initialize($config);
		$this->CI->email->set_mailtype("html");
		$this->CI->email->set_newline("\r\n");
	}

	public function setMail($From,$Name,$To,$Subject,$Content,$Reply = '') {
		$this->mailFrom    = $From;
		$this->mailName    = $Name;
		$this->mailTo      = $To;
		$this->mailSubject = $Subject;
		$this->mailContent = $Content;
		$this->mailreplyTo = $Reply;
		if ($this->mailFrom && $this->mailName && $this->mailTo && $this->mailSubject && $this->mailContent) {
			return true;
		}
		return false;
	}

	public function setStatus() {
		if ($this->Sender()) {
			return true;
		}
		return false;
	}

	public function Sender () {
		$config = [
		 	'protocol'  => 'smtp',
		    'smtp_host' => 'ssl://smtp.gmail.com',
		    'smtp_port' => 465,
		    'smtp_user' => 'thanhnb@bestprice.vn',
		    'smtp_pass' => 'Congty123!@#',
		    'mailtype'  => 'html',
		    'charset'   => 'utf-8',
		    'smtp_timeout'	=> 30
		];

		$this->CI->email->initialize($config);
		$this->CI->email->set_mailtype("html");
		$this->CI->email->set_newline("\r\n");

		$this->CI->email->from($this->mailFrom,$this->mailName);
		$this->CI->email->to($this->mailTo);
		$this->CI->email->subject($this->mailSubject);
		$this->CI->email->message($this->mailContent);
		if (!empty($this->mailreplyTo)) {
			$this->CI->email->reply_to($this->mailreplyTo, $this->mailName);
		}
		return $this->CI->email->send();
	}
}