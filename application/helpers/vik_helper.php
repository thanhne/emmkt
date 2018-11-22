<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$CI = get_instance();

if ( !function_exists( 'dd' ) ) {
	/**
	 * [dd print_r or var_dump with style ]
	 * @author VIK thanhne.com
	 * @param  [type] $inputs [description]
	 * @return [type]         [description]
	 */
	function dd($inputs){
		echo '<pre style="background: #000; color: #fff; border: 3px solid red; border-radius: 3px; margin: 20px; padding: 5px;">';
		if (is_array($inputs)) {
			print_r($inputs);
		}else {
			var_dump($inputs);
		}
		echo '</pre>';
		die();
	}
}

if ( !function_exists( 'vik_format_input_parameter' ) ) {
	function vik_format_input_parameter($inputs = []) {
		$urls = [];
		if (is_array($inputs)) {
			if (!empty($inputs['by_id']) && is_numeric($inputs['by_id'])) {
				$urls['by_id'] = $inputs['by_id'];
			}

			if (!empty($inputs['limit']) && is_numeric($inputs['limit'])) {
				$urls['limit'] = $inputs['limit'];
			}

			return $urls;
		}
		return false;
	}
}

if ( !function_exists( 'vik_pagination_config' ) ) {
	/**
	 * [vik_pagination_config description]
	 * @param  array  $inputs [please see default array below]
	 * @return [type]         [array]
	 */
	function vik_pagination_config($inputs = []) {
		$default = [
			'base_url'             => 	'http://thanhne.com/vik-cms/',
			'total_rows'           => 	'',
			'per_page'             => 	50,
			'use_page_numbers'     => 	TRUE,
			'page_query_string'    => 	TRUE,
			'query_string_segment' =>	'page',
			'num_tag_open'         =>	'<li class="paginate_button ">',
			'num_tag_close'        =>	'</li>',
			'full_tag_open'        => 	'<ul class="pagination">',
			'full_tag_close'       =>	'</ul>',
			'first_link'           =>	'First',
			'first_tag_open'       =>	'<li class="paginate_button first">',
			'first_tag_close'      =>	'</li>',
			'first_url'            =>	'',
			'last_link'            =>	'Last',
			'last_tag_open'        =>	'<li class="paginate_button last">',
			'last_tag_close'       =>	'</li>',
			'last_url'             =>	'',
			'next_link'            =>	'Next',
			'next_tag_open'        =>	'<li class="paginate_button next">',
			'next_tag_close'       =>	'</li>',
			'prev_link'            =>	'Previous',
			'prev_tag_open'        =>	'<li class="paginate_button previous">',
			'prev_tag_close'       =>	'</li>',
			'cur_tag_open'         =>	'<li class="paginate_button active"><a href="#">',
			'cur_tag_close'        =>	'</a></li>',
		];

		return array_merge($default,$inputs);
	}
}

if ( !function_exists( 'is_selected' ) ) {
	function is_selected($value) {
		$allowed = [10,25,50,100];
		echo '<label>
            Show <select name="dataTables-limit" class="form-control input-sm">';
            foreach ($allowed as $item) {
            	if ($item == $value) {
            		echo '<option value="'.$item.'" selected>'.$item.'</option>';
            	}else {
            		echo '<option value="'.$item.'">'.$item.'</option>';
            	}
            }
        echo '</select> entries
        </label>';
	}
}

if ( !function_exists( 'checkbox_contact_groups' ) ) {
	function checkbox_contact_groups($data = [],$checked = [], $type = 'div') {
		$html = '';
		$is_checked = '';
		if ($data) {
			foreach ($data as $key => $item) {
				if (in_array($item['id'], $checked)) {
					$is_checked = ' checked';
				}else {
					$is_checked = set_checkbox('txtGroups[]',$item['id']);
				}
				if ($type == 'div') {
					$html .= '<div class="checkbox">
		                     <label>
		                         <input type="checkbox" name="txtGroups[]" value="'.$item['id'].'"'.$is_checked.'>'.$item['name'].'
		                     </label>
		                 </div>';
				}else {
					$html .= '<tr>
                                <td><input type="checkbox" name="group_ids[]" value="'.$item['id'].'" '.$is_checked.' /></td>
                                <td><strong>#'.$item['id'].'</strong></td>
                                <td><strong>'.$item['name'].'</strong></td>
                                <td>'.total_contacts_by_group_id($item['id']).'</td>
                        	</tr>';
				}
			}
			return $html;
		}
	}
}

if ( !function_exists( 'selected_value' ) ) {
	function selected_value($data = [], $id = '') {
		$html = $is_selected = '';
		if ($data) {
			foreach ($data as $item) {
				if ($id == $item['id']) {
					$is_selected = 'selected';
				}else {
					$is_selected = '';
				}
				$html .= '<option value="'.$item['id'].'" '.$is_selected.'>'.$item['name'].'</option>';
			}
			return $html;
		}
	}
}

if ( !function_exists( 'show_status_process' ) ) {
	function show_status_process($status = '',$name,$msg) { 
		$html = $status_class = $show_msg = '';
		if($status === 0 && empty($msg)) {
			$status_class = 'danger';
			$msg = 'OOPS, something has gone wrong, please try again';
		}else if ($status === 0) {
			$status_class = 'danger';
		}else if($status === 1) {
			$status_class = 'success';
			$show_msg = 'show_msg';
			$msg = 'The '.$name.' has been submitted successfully.';
		}

		if (!empty($msg)) {
			$html .= '<div class="alert alert-'.$status_class.' ' .$show_msg.' alert-dismissable">';
			$html .= '<button type="button" class="close">×</button>';
			$html .= $msg;
			$html .= '</div>';
			return $html;
		}
	}
}

if( !function_exists( 'is_start' ) ) {
	function is_start($status) {
		if ($status == 3) {
			echo '<button class="btn btn-warning btn-xs">Done</button>';
		}else {
			if ($status == 2) {
				echo '<button class="btn btn-danger stop">Stop</button>';
			}else {
				echo '<button class="btn btn-success start">Start</button>';
			}
		}
	}
}

if ( !function_exists( 'total_contacts_by_groups' ) ) {
	function total_contacts_by_group_id($group_id) {
		global $CI;
		if ($group_id) {
			$CI->load->model('admin_model');
			$total = $CI->admin_model->contact_get_group_id($group_id);
			$rs = '<a href="/admin/contact/list/?by_id='.$group_id.'">'.$total.' contacts</a>';
			return $rs;
		}
	}
}

if ( !function_exists( 'test_send_mail' ) ) {
	function test_send_mail($mails = [], $name, $subject,$message) {
		global $CI;
		$CI->load->library('../controllers/Send_mail');
		foreach ($mails as $mail) {
			$CI->Send_mail->mail_sender('nbthanh93@gmail.com', $name, $mail, $subject, $message);
		}
	}
}

if ( ! function_exists('is_error')) {
    function is_error($valid_error) {
       return empty($valid_error) ? '' : ' has-error';
    }
}

if ( ! function_exists( 'show_flashdata' ) ) {
	function show_flashdata($value = '') {
		if (!empty($value)) {
			$html = '<div class="alert alert-success alert-dismissable show_msg">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
	        $html .= $value;
	        $html .= '</div>';
			return $html;
		}
	}
}

if ( !function_exists( 'is_status' ) ) {
	function is_status($value = 1) {
		if (!empty($value)) {
			if ($value == 1) {
				return '<span class="btn btn-success btn-xs">Active</span>';
			}else {
				return '<span class="btn btn-danger btn-xs">Disable</span>';
			}
		}
		return '<span class="btn btn-danger btn-xs">Disable</span>';
	}
}

if ( !function_exists( 'check_value_form' ) ) {
	function check_value_form($value1 = '', $value2 = '', $value3 = '') {
		if (!empty($value1)) {
			return $value1;
		}else {
			if (!empty($value2)) {
				return $value2;
			}else {
				if (!empty($value3)) {
					return $value3;
				}else {
					return false;
				}
			}
		}
	}
}

if ( !function_exists( 'mail_validate' ) ) {
	function mail_provider_validate($email) {
		$result = $email;
		$gmail_regex = '/(.*?)@(gmail.con|gamil.com|gmial.com|gmail.vn|gmail.com.vn|gmial.com|gmel.com|gmal.com|gmail.com.nv)/';
		if (preg_match($gmail_regex,$email,$matches)) {
			$result = isset($matches[2]) ?  str_replace($matches[2], 'gmail.com', $email ) : '';
		}else if(preg_match('/(.*?)@yahoo.(con)/',$email,$matches)) {
			$result = isset($matches[2]) ?  str_replace($matches[2], 'com', $email ) : '';
		}else if(preg_match('/(.*?)@yahoo.(vn|com.nv)/',$email,$matches)) {
			$result = isset($matches[2]) ?  str_replace($matches[2], 'com.vn', $email ) : '';
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  	return false; 
		}
		return trim($result);
	}
}

if ( !function_exists( 'from_mail_option' ) ) {
	function from_mail_option($inputs) {
		if (is_array($inputs)) {
			$html = '';
			$html .= '<option value="'.$inputs['mail_from'].'">{'.$inputs['mail_from'].'}</option>';
		}else {
			$html = '<option value="'.$inputs.'">{'.$inputs.'}</option>';
		}
		return $html;
	}
}