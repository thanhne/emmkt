<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjob extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('vik_helper');
		$this->load->model('admin_model');
		$this->load->library('Sendmail');
	}

	public function getAllJobs() {
		if ($items = $this->admin_model->campaign_find_bystatus(1)) {
			$ids = [];
			foreach ($items as $item) {
				$this->doAjob($item['id']);
			}
		}
	}

	public function doAjob($camp_id) {
		//$camp_id = 3;
		$errors = [];
		$campaign = $this->admin_model->campaign_find($camp_id);
		$this->sendmail->mailConfig($this->config->item('email_service'));
		if (!$campaign) {
			$errors[] = 'campaign';
		}

		$status = isset($campaign['status']) ? $campaign['status'] : 1;
		if ($status != 1) { // = 1; //disable |  = 2; //active |  = 3; //done
			return;
		}
		//1. Subject
		if (isset($campaign['subject']) && !empty($campaign['subject'])) {
			$subject = $campaign['subject'];
		}else {
			$errors[] = 'subject';
		}
		//2. From
		if (isset($campaign['from_mail']) && !empty($campaign['from_mail'])) {
			$from_mail = $campaign['from_mail'];
		}else {
			$errors[] = 'from_mail';
		}
		//3. from name
		if (isset($campaign['from_name']) && !empty($campaign['from_name'])) {
			$from_name = $campaign['from_name'];
		}else {
			$errors[] = 'from_name';
		}
		//4. Content
		if (isset($campaign['template_id']) && !empty($campaign['template_id'])) {
			$template_id = $campaign['template_id'];
			$message = $this->admin_model->template_find($template_id)['content'];
			if (empty($message)) {
				$errors[] = 'message';
			}
		}else {
			$errors[] = 'template_id';
		}
		//5. Reply
		$Reply = isset($campaign['custom_reply']) ? $campaign['custom_reply'] : '';

		if (count($errors) > 0) {
			return;
		}

		$group_ids = $this->admin_model->relationships_find_group_bycamp($camp_id);
		$contact_ids = $this->admin_model->relationships_find_contact_bygroup($group_ids);

		if (count($contact_ids) > 50) {
			$contact_ids = $this->admin_model->relationships_find_contact_bygroup($group_ids,50);
		}

		print_r($contact_ids);

		/*for ($i=0; $i < ; $i++) { 
			# code...
		}

		foreach ($contact_ids as $c_id) {
			if (!$this->admin_model->is_received($camp_id,$c_id)) {
				$tomail = trim($this->admin_model->contact_get_mail($c_id));
				if(!$tomail){
					continue;
				}

				$this->sendmail->setMail($from_mail,$from_name,$tomail,$subject,$message,$Reply);
				if ($this->sendmail->Sender()) {
					$this->admin_model->transactions_insert($camp_id,$c_id,1);
				}/*else {
					$this->admin_model->transactions_insert($camp_id,$c_id,2); //2 == fail
				}
			}
		}*/
	}

	public function doJobs() {
		$this->getAllJobs();
	}
}