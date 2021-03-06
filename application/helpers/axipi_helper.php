<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('ci_url')) {
	function ci_url() {
		$CI =& get_instance();
		if($CI->config->item('hst_rewrite')) {
			$url = $CI->base_url;
		} else {
			$url = $CI->base_url.'?ci=';
		}
		return $url;
	}
}

if( ! function_exists('build_filters')) {
	function build_filters($filters) {
		$CI =& get_instance();
		$flt = array();
		$flt[] = '1';
		foreach($filters as $k =>$v) {
			if(isset($_SESSION[$k]) == 0) {
				$_SESSION[$k] = '';
			}
			$value = '';
			if($CI->input->post($k) || isset($_POST[$k]) == 1) {
				$value = strval($CI->input->post($k));
				$CI->session->set_userdata($k, strval($CI->input->post($k)));
			} elseif($CI->session->userdata($k) != '') {
				$value = $CI->session->userdata($k);
			}
			if($value != '') {
				if($v[1] == 'notnull' && $value == 1) {
					$flt[] = $v[0].' IS NOT NULL';
				}
				if($v[1] == 'notnull' && $value == 0) {
					$flt[] = $v[0].' IS NULL';
				}
				if($v[1] == 'equal') {
					$flt[] = $v[0].' = '.$CI->db->escape($value);
				}
				if($v[1] == 'like') {
					$flt[] = $v[0].' LIKE '.$CI->db->escape('%'.$value.'%');
				}
			}
		}
		return $flt;
	}
}

if( ! function_exists('checkbox2database')) {
	function checkbox2database($value) {
		if($value == 1) {
			return '1';
		} else {
			return '0';
		}
	}
}

if( ! function_exists('tinyint2boolean')) {
	function tinyint2boolean($value) {
		if($value == 1) {
			return true;
		} else {
			return false;
		}
	}
}

if( ! function_exists('build_columns')) {
	function build_columns($reference, $columns, $default_order, $default_direction) {
		$CI =& get_instance();
		$defined_order = '';
		$defined_direction = '';
		if($CI->input->get($reference.'_col') && preg_match('/^[a-zA-Z0-9._]{1,}[ ](ASC|DESC)$/', $CI->input->get($reference.'_col'))) {
			list($defined_order, $defined_direction) = explode(' ', $CI->input->get($reference.'_col'));
			$CI->session->set_userdata($reference.'_col', $CI->input->get($reference.'_col'));
		} elseif($CI->session->userdata($reference.'_col') && preg_match('/^[a-zA-Z0-9._]{1,}[ ](ASC|DESC)$/', $CI->session->userdata($reference.'_col'))) {
			list($defined_order, $defined_direction) = explode(' ', $CI->session->userdata($reference.'_col'));
		}
		if(!in_array($defined_order, $columns) || !in_array($defined_direction, array('ASC', 'DESC'))) {
			$defined_order = $default_order;
			$defined_direction = $default_direction;
			$CI->session->set_userdata($reference.'_col', $default_order.' '.$default_direction);
		}
		$col = array();
		foreach($columns as $v) {
			if($v == $defined_order) {
				if($defined_direction == 'ASC') {
					$col[] = $defined_order.' DESC';
				}
				if($defined_direction == 'DESC') {
					$col[] = $defined_order.' ASC';
				}
			} else {
				$col[] = $v.' ASC';
			}
		}
		return $col;
	}
}

if( ! function_exists('display_column')) {
	function display_column($url, $reference, $column, $lang) {
		$CI =& get_instance();
		$class = '';
		list($display_order, $display_direction) = explode(' ', $column);
		if($CI->session->userdata($reference.'_col') && preg_match('/^[a-zA-Z0-9._]{1,}[ ](ASC|DESC)$/', $CI->session->userdata($reference.'_col'))) {
			list($defined_order, $defined_direction) = explode(' ', $CI->session->userdata($reference.'_col'));
			if($display_order == $defined_order) {
				if($display_direction == 'ASC') {
					$class = ' class="sort_desc"';
				}
				if($display_direction == 'DESC') {
					$class = ' class="sort_asc"';
				}
			}
		}
		if($CI->config->item('hst_rewrite')) {
			$url = $url.'?';
		} else {
			$url = $url.'&';
		}
		$link = '<th'.$class.'><a href="'.$url.$reference.'_col='.urlencode($column).'">'.$lang.'</a></th>';
		echo $link;
	}
}
