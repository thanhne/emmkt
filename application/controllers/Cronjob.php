<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cronjob extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper('vik_helper');
		$this->load->model('admin_model');
		$this->load->library('Sendmail');

		$this->load->driver('cache', [
				'adapter' => 'apc',
				'backup' => 'file',
				'key_prefix' => 'campaigns_'
			]
		);
	}

	public function getAllJobs() {
		set_time_limit(0);
		//$time_start = microtime(true);

		if ($items = $this->admin_model->campaign_find_bystatus(2)) { //status == 2 campaign will be send
			$ids = [];
			foreach ($items as $item) {
				$this->doAjob($item['id']);
			}
		}
		// SCRIPT CODE
 
		/*//Create a variable for end time
		$time_end = microtime(true);
		 
		//Subtract the two times to get seconds
		 
		$time = $time_end - $time_start;
		 
		 echo 'Execution time : '.$time.' seconds';
		/*$queries = $this->db->queries;

		foreach ($queries as $query)
		{
		    echo $query.'<br />';
		}*/
	}

	public function doAjob($camp_id) {
		$errors = $camp_cache_result = [];
		$cache_time = 100;

		$this->sendmail->mailConfig($this->config->item('email_service'));
		if ( !$camp_cache_result = $this->cache->get($camp_id) ){
			$camp_cache_result['campaign']    = $this->admin_model->campaign_find($camp_id);
			$camp_cache_result['group_ids']   = $this->admin_model->relationships_find_group_bycamp($camp_id);
			$camp_cache_result['contact_ids'] = $this->admin_model->relationships_find_contact_bygroup($camp_cache_result['group_ids']);
	       	$this->cache->save($camp_id, $camp_cache_result, $cache_time);
		}

		$group_ids   = $camp_cache_result['group_ids'];
		$contact_ids = $camp_cache_result['contact_ids'];

		if (isset($camp_cache_result['campaign']) && count($camp_cache_result['campaign']) > 1) {
			$campaign = $camp_cache_result['campaign'];
		}else {
			return;
		}

		$status = isset($campaign['status']) ? $campaign['status'] : 1;
		if ($status != 2) { // = 1; //disable |  = 2; //active |  = 3; //done
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

			if (!$message = $this->cache->get($camp_id.'.temaplate') ) {
				$message = $this->admin_model->template_find($template_id)['content'];
				$this->cache->save($camp_id.'.temaplate', $message, $cache_time);
			}

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

		if (count($contact_ids) > 50) {
			$contact_ids = $this->admin_model->relationships_find_contact_bygroup($group_ids,50);
		}

		if ($this->input->get('test') == 'ok') {
			echo 'test<br />';
			$total = !empty($this->input->get('total')) ? $this->input->get('total') : 1;
			$customer_email = 'thanhnb@bestprice.vn';
			$message = str_replace('{NAME}', '<strong>Bá Thành</strong>', $message);
			$message .= $this->add_unsub_link($customer_email);
			$this->sendmail->setMail($from_mail,$from_name,$customer_email,$subject,$message,$Reply);
			if ($total > 1) {
				for ($i=1; $i < $total; $i++) {
					$this->sendmail->Sender();
				}
			}else {
				$this->sendmail->Sender();
			}
			$this->sendmail->is_errors();
		}else {
			for ($i=0; $i < count($contact_ids); $i++) { 
				$contact_id = $contact_ids[$i];
				if ($this->admin_model->is_received($camp_id,$contact_id)) {
					continue;
				}

				if(!$info = $this->admin_model->contact_get_mail($contact_id)){
					continue;
				}else {
					$customer_email = $info['email'];
					$customer_name  = $info['first_name'];
				}

				$call_name = $this->call_name($customer_email,$customer_name);

				$message = str_replace('{NAME}', $call_name, $message);
				$message .= $this->add_unsub_link($customer_email);
				$this->sendmail->setMail($from_mail,$from_name,$customer_email,$subject,$message,$Reply);
				if ($this->sendmail->Sender()) {
					$this->admin_model->transactions_insert($camp_id,$contact_id,2);
				}else {
					$this->admin_model->transactions_insert($camp_id,$contact_id,1);
				}
			}
		}
	}

	public function add_unsub_link($email) {
		$code = base64UrlEncode($email);
		$link = $this->config->item('base_url').'/unsubscribe/?email='.$code;
		$html = '<div align="center" style="color:#727272;font-size:10px;clear: both;margin-top:20px">If you wish to unsubscribe from our newsletter, click <a style="color:#01a4c6" href="'.$link.'" target="_blank" data-saferedirecturl="https://www.google.com/url?q='.$link.'">here</a></div>';
		return $html;
	}

	public function call_name($email, $name = '') {
		if (!empty($name)) {
			$call_name = '<strong>'.$name.'</strong>';
		}else {
			$call_name = '<strong>'.$email.'</strong>';
		}
		return $call_name;
	}

	public function doJobs() {
		$this->getAllJobs();
	}
}