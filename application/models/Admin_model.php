<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Model for Contact it mean email list
 */
class Admin_model extends CI_Model{
	public function __construct() {
    	$this->load->database();
	}
	
	/**
	 * [get_current_page_records description]
	 * @author VIK - thanhne.com
	 * @param  [string] $table  [description]
	 * @param  [number] $limit  [description]
	 * @param  [number] $offset [description]
	 * @param  [string] $key  	[column name]
	 * @param  [any]  	$by_id  [description]
	 * @return [type]         	[description]
	 */
	public function get_current_page_records($table,$limit,$offset,$key = '',$by_id = '') {
		$this->db->from($table);
		if (!empty($key) && !empty($by_id)) {
			$this->db->join('relationships', 'contacts.id = relationships.contact_id');
			$this->db->where($key,$by_id);
			$this->db->order_by("contacts.id", "desc");
		}else {
			$this->db->order_by("id", "desc");
		}
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	/**
	 * [get_total_records description]
	 * @author VIK - thanhne.com
	 * @param  [type] $table [custom table]
	 * @param  [string] $key [description]
	 * @param  [number] $by_id [description]
	 * @return [type] [description]
	 */
	public function get_total_records($table,$key = '',$by_id = '') {
		$this->db->from($table);
		if (!empty($key) && !empty($by_id)) {
			//SELECT * FROM `vik_contacts` C, vik_relationships R WHERE C.id = R.contact_id AND R.group_id = 5
			$this->db->join('relationships', 'contacts.id = relationships.contact_id');
			$this->db->where($key,$by_id);
			return $this->db->count_all_results();
		}else {
			return $this->db->count_all($table);
		}
	}

	public function Find_contactID_by_groupID($group_ids = []){
		//$this->db->select('contact_id');
		$this->db->from('relationships');
		if (count($group_ids) > 1) {
			$this->db->where_in('group_id', $group_ids);
		}else {
			$this->db->where('group_id',$group_ids[0]);
		}
		$this->db->group_by('contact_id');
		if($ids = $this->db->get()->result_array()){
			return $ids;
		}
		return false;
	}
	/**
	 * ###################CAMPAIGN MODEL###################
	 */
	public function campaign_find($camp_id = '') {
		if (!empty($camp_id) && is_numeric($camp_id)) {
			$this->db->from('campaigns');
			$this->db->where('id',$camp_id);
			if ($items = $this->db->get()->result_array()) {
				return $items[0];
			}
		}
		return false;
	}
	/**
	 * [campaign_find_bystatus description]
	 * @param  string $status [description]
	 * @return [type]         [description]
	 */
	public function campaign_find_bystatus($status = '') {
		if (!empty($status) && is_numeric($status)) {
			$this->db->from('campaigns');
			$this->db->where('status',$status);
			if ($items = $this->db->get()->result_array()) {
				return $items;
			}
			return false;
		}
		return false;
	}

	/**
	 * [campaign_getAll description]
	 * @author VIK thanhne.com
	 * @return [type] [description]
	 */
	public function campaign_getAll(){
		$this->db->from('campaigns');
		$this->db->order_by("id", "desc");
		if ($items = $this->db->get()->result_array()) {
			return $items;
		}
		return false;
	}
	/**
	 * [campaign_insert description]
	 * @author VIK thanhne.com
	 * @param  array  $inputs [description]
	 * @return [type]         [description]
	 */
	public function campaign_insert($inputs = []) {
		$default = [
			'name'          => '',
			'subject'       => '',
			'email_id'      => '',
			'from_mail'     => '',
			'from_name'     => '',
			'custom_reply'  => '',
			'template_id'   => '',
			'status'   		=> '',
		];
		$data = array_merge($default,$inputs);
		if (count($data) == 8) {
			$this->db->insert('campaigns', $data);
			return $this->db->insert_id();
		}
	}
	/**
	 * [campaign_update description]
	 * @param  [type] $id     [description]
	 * @param  array  $inputs [description]
	 * @return [type]         [description]
	 */
	public function campaign_update($id,$inputs = []) {
		$default = [
			'name'          => '',
			'subject'       => '',
			'email_id'      => '',
			'from_mail'     => '',
			'from_name'     => '',
			'custom_reply'  => '',
			'template_id'   => '',
			'status'   		=> '',
		];
		$outputs = array_merge($default,$inputs);

		if (count($outputs) == 8 && $id && is_numeric($id)) {
			$this->db->where('id', $id);
			return $this->db->update('campaigns', $outputs);
		}
		return false;
	}

	public function campaign_update_status($id,$status) {
		$status = isset($status) ? $status : 1;
		$outputs = [
			'status'   		=> $status,
		];
		//$outputs = array_merge($default,$inputs);

		if (count($outputs) == 1 && is_numeric($id)) {
			$this->db->where('id', $id);
			return $this->db->update('campaigns', $outputs);
		}
		return false;
	}
	/**
	 * [campaign_delete description]
	 * @author VIK thanhne.com
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function campaign_delete($id) {
		if ($id && is_numeric($id)) {
			return $this->db->delete('campaigns', [ 'id' => $id ]); 
		}
		return false;
	}

	/**
	 * ###################TEMPLATES MODEL###################
	 */
	/**
	 * [template_getAll description]
	 * @author VIK thanhne.com
	 * @return [type] [description]
	 */
	public function template_getAll(){
		$this->db->from('templates');
		$this->db->order_by("id", "desc");
		$this->db->where('status',1);
		if ($query = $this->db->get()->result_array()) {
			return $query;
		}
		return false;
	}
	/**
	 * [template_find description]
	 * @param  [type] $id [id of templates]
	 * @return [type]     [description]
	 */
	public function template_find($id) {
		if ($id && is_numeric($id)) {
			$this->db->from('templates');
			$this->db->where('id',$id);
			if ($item =  $this->db->get()->result_array()) {
				return $item[0];
			}
		}
		return false;
	}
	/**
	 * [template_insert description]
	 * @param  array  $inputs [description]
	 * @return [type]         [description]
	 */
	public function template_insert($inputs = []) {
		$default = [
			'name'    => '',
			'content' => '',
			'status' => '',
		];
		$data = array_merge($default,$inputs);
		if (count($data) == 3) {
			$this->db->insert('templates', $data);
			return $this->db->insert_id();
		}
	}
	/**
	 * [template_update description]
	 * @param  [type] $id     [id of templates]
	 * @param  array  $inputs [description]
	 * @return [type]         [description]
	 */
	public function template_update($id,$inputs = []) {
		$default = [
			'name'    => '',
			'content' => '',
			'status'  => ''
		];
		$outputs = array_merge($default,$inputs);

		if (count($outputs) == 3 && $id && is_numeric($id)) {
			$this->db->where('id', $id);
			return $this->db->update('templates', $outputs);
		}
		return false;
	}
	/**
	 * [template_delete description]
	 * @param  [type] $id [id of templates]
	 * @return [type]     [description]
	 */
	public function template_delete($id) {
		if ($id && is_numeric($id)) {
			return $this->db->delete('templates', [ 'id' => $id ]); 
		}
		return false;
	}
	/**
	 * ###################CONTACTS MODEL###################
	 */
	public function contact_get_mail($id = ''){
		if (!empty($id)) {
			$result = [];
			if ($item = $this->contact_find($id)) {
				return [
					'first_name' => $item['first_name'],
					'email' => $item['email']
				];
			}
			return false;
		}
	}
	/**
	 * [contact_find description]
	 * @author VIK thanhne.com
	 * @param  [type] $id [id of contact]
	 * @return [type]     [description]
	 */
	public function contact_find($id) {
		if ($id && is_numeric($id)) {
			$this->db->from('contacts');
			$this->db->where('id',$id);
			return $this->db->get()->result_array()[0];
		}
		return false;
	}
	public function contact_find_byEmail($email = "") {
		if (!empty($email)) {
			$this->db->from('contacts');
			$this->db->where('email',$email);
			if ($item = $this->db->get()) {
				return $item->result_array();
			}
			return false;
		}
		return false;
	}
	/**
	 * [contact_find_email description]
	 * @author VIK thanhne.com
	 * @param  string $email [description]
	 * @return [type]        [description]
	 */
	public function contact_find_email($email = "") {
		if (!empty($email)) {
			$this->db->from('contacts');
			$this->db->where('email',$email);
			if ($this->db->count_all_results() > 0) {
				return true;
			}
			return false;
		}
		return false;
	}
	/**
	 * [contact_get_group_id description]
	 * @author VIK thanhne.com
	 * @param  string $id [group_id from relationships table]
	 * @return [type]     [description]
	 */
	public function contact_get_group_id($id = '') {
		if (!empty($id) && is_numeric($id)) {
			$this->db->from('relationships');
			$this->db->where('group_id',$id);
			return $this->db->count_all_results();
		}
		return false;
	}
	/**
	 * [contact_insert description]
	 * @author VIK thanhne.com
	 * @param  array  $inputs [please look default array below]
	 * @return [numeric]      [return the inserted id]
	 */
	public function contact_insert($inputs = []) {
		$default = array(
			'first_name'       => '',
			'last_name'        => '',
			'email'            => '',
			'phone'            => '',
		);

		$data = array_merge($default,$inputs);

		if (count($data) == 4) {
			$this->db->insert('contacts', $data);
			return $this->db->insert_id();
		}
	}
	/**
	 * [contact_update description]
	 * @author VIK thanhne.com
	 * @param  [type] $id     [id of contact]
	 * @param  array  $inputs [please see default array in the below method]
	 * @return [type]         [description]
	 */
	public function contact_update($id,$inputs = []) {
		$default = [
			'first_name' => '',
			'last_name'  => '',
			'email'      => '',
			'phone'      => ''
		];
		$outputs = array_merge($default,$inputs);

		if (count($outputs) == 4 && $id && is_numeric($id)) {
			$this->db->where('id', $id);
			return $this->db->update('contacts', $outputs);
		}
		return false;
	}
	/**
	 * [contact_delete description]
	 * @author VIK thanhne.com
	 * @param  [type] $id [id of contact]
	 * @return [type]     [description]
	 */
	public function contact_delete($id) {
		if ($id && is_numeric($id)) {
			return $this->db->delete('contacts', [ 'id' => $id ]); 
		}
		return false;
	}

	/**
	 * ###################GROUPS MODEL###################
	 */
	/**
	 * [group_getAll description]
	 * @author VIK Thanhne.com
	 * @return [type] [description]
	 */
	public function group_getAll(){
		$this->db->from('groups');
		$this->db->order_by("id", "desc");
		if ($items = $this->db->get()->result_array()) {
			return $items;
		}
		return false;
	}
	/**
	 * [group_find description]
	 * @author VIK Thanhne.com
	 * @param  string $id [id of groups]
	 * @return [type]     [description]
	 */
	public function group_find($id) {
		if ($id && is_numeric($id)) {
			$this->db->select('name');
			$this->db->from('groups');
			$this->db->where('id',$id);
			return $this->db->get()->result_array()[0];
		}
		return false;
	}
	/**
	 * [contact_group_insert description]
	 * @author VIK thanhne.com
	 * @param  [type] $name [name of group]
	 * @return [type]       [description]
	 */
	public function group_insert($name = '') {
		if (!empty($name)) {
			$this->db->insert('groups', [
				'name'  => $name
			]);
			return $this->db->insert_id();
		}
		return false;
	}
	/**
	 * [contact_group_update description]
	 * @author VIK thanhne.com
	 * @param  string $id   [id of groups]
	 * @param  string $name [description]
	 * @return [type]       [description]
	 */
	public function group_update($id = '',$name = '') {
		if (!empty($id) && is_numeric($id) && !empty($name)) {
			$this->db->where('id', $id);
			return $this->db->update('groups',  [
				'name' => $name
			]); 
		}
		return false;
	}
	/**
	 * [contact_group_delete description]
	 * @author VIK thanhne.com
	 * @param  string $id [id of groups]
	 * @return [type]     [description]
	 */
	public function group_delete($id) {
		if ($id && is_numeric($id)) {
			return $this->db->delete('groups', [ 'id' => $id ]); 
		}
		return false;
	}

	public function group_find_byids($ids = []) {
		if (!is_array($ids)) {
			return false;
		}
		$this->db->from('groups');
		$this->db->where_in('id', $ids);
		$this->db->order_by("id", "desc");
		if ($items = $this->db->get()->result_array()) {
			return $items;
		}
		return false;
	}

	/**
	 * ###################RELATIONSHIPS MODEL###################
	 */

	/**
	 * [relationships_findID This function just use in class]
	 * @author VIK thanhne.com
 	 * @param  [type] $group_id   [group_id]
	 * @param  [type] $contact_id [contact_id]
	 * @return [type]             [description]
	 */
	protected function relationships_findID($group_id,$contact_id) {
		$this->db->select('id');
		$this->db->from('relationships');
		$this->db->where('contact_id',$contact_id);
		$this->db->where('group_id',$group_id);
		if($ids = $this->db->get()->result_array()){
			return $ids;
		}
		return false;
	}
	/**
	 * [relationships_insert description]
	 * @author VIK thanhne.com
	 * @param  string $c_id [contact_id or campaign_id]
	 * @param  string $g_id [group_id]
	 * @return [type]       [description]
	 */
	public function relationships_insert( $g_id,$c_id, $type = 'contact'){
		if (!is_numeric($g_id) || !is_numeric($c_id)) {
			return false;
		}
		if ($c_id && $g_id) {
			if ($type == 'contact') {
				$this->db->insert('relationships', [
					'group_id' 	  => $g_id,  
					'contact_id'  => $c_id,
				]);
			}else {
				$this->db->insert('relationships', [
					'group_id'    => $g_id,  
					'campaign_id' => $c_id,
				]);
			}
			return $this->db->insert_id();
		}
		return false;
	}
	/**
	 * [relationships_insert_array description]
	 * @author VIK thanhne.com
	 * @param  string $id     [inserted_id from contacts table]
	 * @param  array  $inputs [input from $this->input->post('txtGroups')]
	 * @param  string $type   [contact or campaign]
	 * @return [type]         [description]
	 */
	public function relationships_insert_array($id, $inputs = [],$type = 'contact') {
		if ($id && is_numeric($id)) {
			if (count($inputs) > 1) {
				$ids = [];
				foreach ($inputs as $i) {
					$ids[] = $this->relationships_insert($i,$id,$type);
				}
			}else {
				$ids[] = $this->relationships_insert($inputs[0],$id,$type);
			}
			return $ids;
		}
		return false;
	}
	/**
	 * [relationships_InsertOrUpdate description]
	 * @author VIK thanhne.com
	 * @param  [type] $g_id [group_id]
	 * @param  [type] $c_id [contact_id]
	 * @return [type]       [description]
	 */
	public function relationships_InsertOrUpdate($g_id,$c_id){
		if (!is_numeric($g_id) || !is_numeric($c_id)) {
			return false;
		}
		if ($c_id && $g_id) {
			if ($ids = $this->relationships_findID($g_id,$c_id)) {
				$id = trim($ids[0]['id']);
				return $this->db->update('relationships',[ 
						'group_id' 	  => $g_id
					],
					[
						'id' 	=> (int)$id
					]
				);
			}else {
				$this->db->insert('relationships', [
					'contact_id'  => $c_id,  
					'group_id' 	  => $g_id
				]);
				return $this->db->insert_id();
			}
		}
		return false;
	}
	/**
	 * [relationships_update_array description]
	 * @author VIK thanhne.com
	 * @param  [type] $id     [contact_id]
	 * @param  array  $inputs [input from $this->input->post('txtGroups')]
	 * @return [type]         [description]
	 */
	public function relationships_update_array($id, $inputs = []) {
		if ($id && is_numeric($id)) {
			$this->db->where_not_in('group_id', $inputs);
			$this->db->delete('relationships'); 
			if (count($inputs) >1) {
				$ids = [];
				foreach ($inputs as $i) {
					$ids[] = $this->relationships_InsertOrUpdate($i,$id);
				}
			}else {
				$ids[] = $this->relationships_InsertOrUpdate($inputs[0],$id);
			}
			return $ids;
		}
		return false;
	}
	/**
	 * [relationships_find_byid find group by contact id]
	 * @author VIK Thanhne.com
	 * @param  [type] $c_id [contact_id]
	 * @return [type]       [description]
	 */
	public function relationships_find_group_bycontact($c_id) {
		if ($c_id && is_numeric($c_id)) {
			$this->db->from('relationships');
			$this->db->where('contact_id',$c_id); //$this->db->where_in('username', $names);
			$outputs = [];
			foreach ($this->db->get()->result_array() as $item) {
				$outputs[] = $item['group_id'];
			}
			return $outputs;
		}
		return false;
	}
	/**
	 * [relationships_find_contact_bygroup get all contact have group_id in array]
	 * @param  array  $group_ids [id1,id2,id3]
	 * @return [type]            [description]
	 */
	public function relationships_find_contact_bygroup($group_ids = [],$limit = '') {
		if (is_array($group_ids)) {
			$this->db->from('relationships');

			if (!empty($limit) && is_numeric($limit)) {
				$this->db->limit($limit);
			}

			$this->db->join('contacts', 'contacts.id = relationships.contact_id');
			$this->db->where('contacts.status',1);
			$this->db->where_in('relationships.group_id', $group_ids);

			$outputs = [];
			foreach ($this->db->get()->result_array() as $item) {
				if ($item['contact_id']) {
					$outputs[] = $item['contact_id'];
				}
			}
			return $outputs;
		}
		return false;
	}
	/**
	 * [relationships_find_group_bycamp get all group have camp_id = '']
	 * @param  string $camp_id [numeric]
	 * @return [type]          [description]
	 */
	public function relationships_find_group_bycamp($camp_id = '') {
		if ($camp_id && is_numeric($camp_id)) {
			$this->db->from('relationships');
			$this->db->where('campaign_id',$camp_id);
			$outputs = [];
			foreach ($this->db->get()->result_array() as $item) {
				$outputs[] = $item['group_id'];
			}
			return $outputs;
		}
		return false;
	}

	/**
	 * [relationships_delete description]
	 * @author VIK thanhne.com
	 * @param  string $g_id [group_id]
	 * @param  string $c_id [contact_id]
	 * @return [type]       [description]
	 */
	public function relationships_delete($g_id = '', $c_id = '') {
		if ($g_id && is_numeric($g_id)) {
			return $this->db->delete('relationships', [ 'group_id' => $g_id ]); 
		}
		if ($c_id && is_numeric($c_id)) {
			return $this->db->delete('relationships', [ 'contact_id' => $c_id ]); 
		}
		return false;
	}

	public function configuration_find($id = 1) {
		$this->db->from('configuration');
		$this->db->where('id',$id);
		if($result = $this->db->get()->result_array()[0]){
			return $result;
		}
		return false;
	}

	public function configuration_update($id = '',$inputs = []) {
		if (!empty($id) && is_numeric($id)) {
			$data = [ 
				'mail_protocol' => '',
				'mail_host'     => '',
				'mail_port'     => '',
				'mail_user'     => '',
			];

			$outputs = array_merge($data,$inputs);

			return $this->db->update('configuration',$outputs,[ 'id' => $id ]);
		}
		return false;
	}

	public function find_trans_by_campid($camp_id) {
		$this->db->from('transactions');
		$this->db->where('camp_id',$camp_id);
		if($result = $this->db->get()->result_array()){
			return $result;
		}
		return false;
	}

	public function is_received($camp_id,$contact_id) {
		if (!$camp_id && !$contact_id) {
			return false;
		}

		$this->db->from('transactions');
		$this->db->where('camp_id',$camp_id);
		$this->db->where('contact_id',$contact_id);
		$this->db->where_in('st_received',[1,2]);
		if($result = $this->db->get()->result_array()){
			return $result;
		}
		return false;
	}

	public function transactions_insert($camp_id,$contact_id,$st_received = 1){
		if (!$camp_id && !$contact_id) {
			return false;
		}

		$data = array(
		   'camp_id' => $camp_id,
		   'contact_id' => $contact_id,
		   'st_received' => $st_received
		);

		$this->db->insert('transactions', $data); 
	}
}
?>