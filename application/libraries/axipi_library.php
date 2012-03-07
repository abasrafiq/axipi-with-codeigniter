<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class axipi_library {
	public function __construct($params = array()) {
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set('Etc/UCT');
		}
		set_error_handler(array($this, 'error_handler'));
		$this->CI =& get_instance();
		$this->CI->err = array();
		$this->CI->hlp = array();
		$this->CI->msg = array();
		$this->CI->head = array();
		$this->CI->foot = array();
		$this->debug = array();
		$this->jquery = array();
		$this->base_url = base_url();
	}
	function error_handler($e_type, $e_message, $e_file, $e_line) {
		$e_type_values = array(1=>'E_ERROR', 2=>'E_WARNING', 4=>'E_PARSE', 8=>'E_NOTICE', 16=>'E_CORE_ERROR', 32=>'E_CORE_WARNING', 64=>'E_COMPILE_ERROR', 128=>'E_COMPILE_WARNING', 256=>'E_USER_ERROR', 512=>'E_USER_WARNING', 1024=>'E_USER_NOTICE', 2048=>'E_STRICT', 4096=>'E_RECOVERABLE_ERROR', 8192=>'E_DEPRECATED', 16384=>'E_USER_DEPRECATED', 30719=>'E_ALL');
		if(isset($e_type_values[$e_type]) == 1) {
			$e_type = $e_type_values[$e_type];
		}
		$key = md5($e_type.' | '.$e_message.' | '.$e_file.' | '.$e_line);
		$this->debug[$key] = $e_type.' | '.$e_message.' | '.$e_file.' | '.$e_line;
		$this->watchdog(array('e_type'=>$e_type, 'e_message'=>$e_message, 'e_file'=>$e_file, 'e_line'=>$e_line));
	}
	function watchdog($data) {
		$wtd_content = '';
		foreach($data as $k => $v) {
			$wtd_content .= $k.':'."\r\n";
			$wtd_content .= $v."\r\n";
		}
		$wtd_key = md5($wtd_content);
        $query = $this->CI->db->query('SELECT wtd_id FROM '.$this->CI->db->dbprefix('wtd').' AS wtd WHERE wtd.wtd_key = ? GROUP BY wtd.wtd_id', array($wtd_key));
		if($query->num_rows() > 0) {
			$this->CI->db->set('wtd_datemodified', date('Y-m-d H:i:s'));
			$this->CI->db->where('wtd_key', $wtd_key);
			$this->CI->db->update('wtd');
		} else {
			$this->CI->db->set('wtd_key', $wtd_key);
			$this->CI->db->set('wtd_content', $wtd_content);
			$this->CI->db->set('wtd_datecreated', date('Y-m-d H:i:s'));
			$this->CI->db->insert('wtd');
		}
	}
	function debug($data) {
		$this->debug[] = '<p><textarea>'.print_r($data, 1).'</textarea></p>';
	}
	function widget($itm_code) {
		$query = $this->CI->db->query('SELECT itm_link AS link, cmp_code, itm.itm_id AS id, itm_content AS content, itm_code AS code, itm_virtualcode AS virtualcode, itm_parent AS parent, itm_title AS title FROM '.$this->CI->db->dbprefix('itm').' AS itm LEFT JOIN '.$this->CI->db->dbprefix('cmp').' AS cmp ON cmp.cmp_id = itm.cmp_id WHERE itm.itm_code = ? GROUP BY itm.itm_id', array($itm_code));
		if($query->num_rows() > 0) {
			$itm = $query->row();
			list($directory, $class) = explode('/', $itm->cmp_code);
			if(file_exists(APPPATH.'widgets/'.$itm->cmp_code.EXT)) {
				require_once APPPATH.'widgets/'.$itm->cmp_code.EXT;
				$widget = new $class();
				$widget->data = $itm;
				foreach(get_object_vars($this->CI) as $key => $object) {
					$widget->$key =& $this->CI->$key;
				}
				echo $widget->index();
			}
		} 
	}
	function build_pagination($total, $per_page) {
		$this->CI->load->library('pagination');

		$config = array();
		$config['base_url'] = '?';
		$config['num_links'] = 5;
		$config['total_rows'] = $total;
		$config['per_page'] = $per_page;
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['first_url'] = '?page=1';
		$config['query_string_segment'] = 'page';

		$pages = ceil($total/$config['per_page']);

		$key = 'per_page_'.$this->CI->uri->uri_string();
		if($this->CI->input->get('page') && is_numeric($this->CI->input->get('page'))) {
			$page = $this->CI->input->get('page');
			$this->CI->session->set_userdata($key, $page);
		} elseif($this->CI->session->userdata($key) && is_numeric($this->CI->session->userdata($key))) {
			$_GET['page'] = $this->CI->session->userdata($key);
		} else {
			$_GET['page'] = 0;
		}
		$start = ($this->CI->input->get('page') * $config['per_page']) - $config['per_page'];
		if($start < 0 || $this->CI->input->get('page') > $pages) {
			$start = 0;
			$_GET['page'] = 1;
		}

		if($pages == 1) {
			$position = $total;
		} elseif($_GET['page'] == $pages && $pages != 0) {
			$position = ($start+1).'-'.$total.'/'.$total;
		} elseif($pages != 0) {
			$position = ($start+1).'-'.($start+$config['per_page']).'/'.$total;
		} else {
			$position = $total;
		}

		$this->CI->pagination->initialize($config);
		return array('output'=>$this->CI->pagination->create_links(), 'start'=>$start, 'limit'=>$config['per_page'], 'position'=>$position);
	}
	function get_head() {
		$head = array();
		if($this->CI->lay->lay_type == 'text/html') {
			$titles = array();
			/*$titles[] = $this->CI->sct->sct_title;
			foreach($this->CI->itm->itm_tree as $value) {
				$titles[] = $value['title'];
			}
			if($this->CI->itm->itm_titlehead != '' && $this->CI->itm->itm_titleheadfull == 1) {
				$titles = array();
				$titles[] = $this->CI->itm->itm_titlehead;
			} else {
				$titles = array_reverse($titles);
				if($this->CI->itm->itm_titlehead != '' && $this->CI->itm->itm_titleheadfull == 0) {
					$titles[0] = $this->CI->itm->itm_titlehead;
				}
			}*/
			$titles[] = $this->CI->itm->itm_title;
			$titles[] = $this->CI->sct->sct_trl_title; 
			$head[] = '<title>'.implode(' | ', $titles).'</title>';

			$head[] = '<meta charset="UTF-8">';
			/*if($this->CI->itm->itm_description != '') {
				$head[] = '<meta content="'.$this->CI->data->display_in_field($this->CI->itm->itm_description).'" name="description">';
			} elseif($this->CI->sct->sct_description != '') {
				$head[] = '<meta content="'.$this->CI->data->display_in_field($this->CI->sct->sct_description).'" name="description">';
			}
			if($this->CI->itm->itm_keywords != '') {
				$head[] = '<meta content="'.$this->CI->data->display_in_field($this->CI->itm->itm_keywords).'" name="keywords">';
			} elseif($this->CI->sct->sct_keywords != '') {
				$head[] = '<meta content="'.$this->CI->data->display_in_field($this->CI->sct->sct_keywords).'" name="keywords">';
			}*/
			/*if(isset($this->CI->itm->itm_stg']['meta-robots']) == 1 && $this->CI->itm->itm_stg']['meta-robots'] != '') {
				$head[] = '<meta content="'.$this->CI->itm->itm_stg']['meta-robots'].'" name="robots">';
			} else {
				$robots = '<meta content="index,follow" name="robots">';
			}*/

			/*if($this->CI->stg->cdn-url'] != '') {
				$this->base_url = $this->CI->stg->cdn-url'].'/';
			} else {
				$this->base_url = '';
			}*/
			if(file_exists('styles/sct_code/'.$this->CI->sct->sct_code.'.css')) {
				$head[] = '<link href="'.$this->base_url.'styles/sct_code/'.$this->CI->sct->sct_code.'.css" rel="stylesheet" type="text/css">';
			} elseif(file_exists('styles/sct_code/'.$this->CI->sct->sct_code.'.dist.css')) {
				$head[] = '<link href="'.$this->base_url.'styles/sct_code/'.$this->CI->sct->sct_code.'.dist.css" rel="stylesheet" type="text/css">';
			}
			if(file_exists('styles/sct_virtualcode/'.$this->CI->sct->sct_virtualcode.'.css')) {
				$head[] = '<link href="'.$this->base_url.'styles/sct_virtualcode/'.$this->CI->sct->sct_virtualcode.'.css" rel="stylesheet" type="text/css">';
			}
			if(file_exists('styles/lay_code/'.$this->CI->lay->lay_code.'.css')) {
				$head[] = '<link href="'.$this->base_url.'styles/lay_code/'.$this->CI->lay->lay_code.'.css" rel="stylesheet" type="text/css">';
			}
			/*if(file_exists('styles/hst_environment/'.$this->CI->hst->hst_environment.'.css')) {
				$head[] = '<link href="'.$this->base_url.'styles/hst_environment/'.$this->CI->hst->hst_environment.'.css" rel="stylesheet" type="text/css">';
			}
			if(file_exists('styles/hst_code/'.$_SERVER['HTTP_HOST'].'.css')) {
				$head[] = '<link href="'.$this->base_url.'styles/hst_code/'.$_SERVER['HTTP_HOST'].'.css" rel="stylesheet" type="text/css">';
			}*/
			if(file_exists('styles/cmp_code/'.$this->CI->cmp->cmp_code.'.css')) {
				$head[] = '<link href="'.$this->base_url.'styles/cmp_code/'.$this->CI->cmp->cmp_code.'.css" rel="stylesheet" type="text/css">';
			}
			if(file_exists('styles/itm_virtualcode/'.$this->CI->itm->itm_virtualcode.'.css')) {
				$head[] = '<link href="'.$this->base_url.'styles/itm_virtualcode/'.$this->CI->itm->itm_virtualcode.'.css" rel="stylesheet" type="text/css">';
			}
			if(file_exists('styles/itm_code/'.$this->CI->itm->itm_code.'.css')) {
				$head[] = '<link href="'.$this->base_url.'styles/itm_code/'.$this->CI->itm->itm_code.'.css" rel="stylesheet" type="text/css">';
			}
			/*if(file_exists('styles/lng_code/'.$this->CI->lng->lng_code.'.css')) {
				$head[] = '<link href="'.$this->base_url.'styles/lng_code/'.$this->CI->lng->lng_code.'.css" rel="stylesheet" type="text/css">';
			}*/
		}
		$head = array_merge($head, $this->CI->head);
		return implode("\r\n", $head)."\r\n";
	}
	function get_foot() {
		$foot = array();
		if($this->CI->lay->lay_type == 'text/html') {
			$this->jquery = array_unique($this->jquery);
			if(count($this->jquery) != 0) {
				foreach($this->jquery as $v) {
					if(file_exists('thirdparty/jquery/scripts/'.$v.'.min.js')) {
						$foot[] = '<script type="text/javascript" src="'.$this->base_url.'thirdparty/jquery/scripts/'.$v.'.min.js" charset="UTF-8"></script>';
					} elseif(file_exists('thirdparty/jquery/scripts/'.$v.'.js')) {
						$foot[] = '<script type="text/javascript" src="'.$this->base_url.'thirdparty/jquery/scripts/'.$v.'.js" charset="UTF-8"></script>';
					}
				}
				if(file_exists('scripts/sct_code/'.$this->CI->sct->sct_code.'.js')) {
					$foot[] = '<script src="'.$this->base_url.'scripts/sct_code/'.$this->CI->sct->sct_code.'.js" type="text/javascript"></script>';
				} elseif(file_exists('scripts/sct_code/'.$this->CI->sct->sct_code.'.dist.js')) {
					$foot[] = '<script src="'.$this->base_url.'scripts/sct_code/'.$this->CI->sct->sct_code.'.dist.js" type="text/javascript"></script>';
				}
				if(file_exists('scripts/sct_virtualcode/'.$this->CI->sct->sct_virtualcode.'.js')) {
					$foot[] = '<script src="'.$this->base_url.'scripts/sct_virtualcode/'.$this->CI->sct->sct_virtualcode.'.js" type="text/javascript"></script>';
				} elseif(isset($this->CI->sct->sct_virtualcode) == 1 && file_exists('scripts/sct_virtualcode/'.$this->CI->sct->sct_virtualcode.'.dist.js')) {
					$foot[] = '<script src="'.$this->base_url.'scripts/sct_virtualcode/'.$this->CI->sct->sct_virtualcode.'.dist.js" type="text/javascript"></script>';
				}
				if(file_exists('scripts/cmp_code/'.$this->CI->cmp->cmp_code.'.js')) {
					$foot[] = '<script src="'.$this->base_url.'scripts/cmp_code/'.$this->CI->cmp->cmp_code.'.js" type="text/javascript"></script>';
				} elseif(file_exists('scripts/cmp_code/'.$this->CI->cmp->cmp_code.'.dist.js')) {
					$foot[] = '<script src="'.$this->base_url.'scripts/cmp_code/'.$this->CI->cmp->cmp_code.'.dist.js" type="text/javascript"></script>';
				}
				if(file_exists('scripts/itm_virtualcode/'.$this->CI->itm->itm_virtualcode.'.js')) {
					$foot[] = '<script src="'.$this->base_url.'scripts/itm_virtualcode/'.$this->CI->itm->itm_virtualcode.'.js" type="text/javascript"></script>';
				}
				if(file_exists('scripts/itm_code/'.$this->CI->itm->itm_code.'.js')) {
					$foot[] = '<script src="'.$this->base_url.'scripts/itm_code/'.$this->CI->itm->itm_code.'.js" type="text/javascript"></script>';
				}
			}
		}
		$foot = array_merge($foot, $this->CI->foot);
		return implode("\r\n", $foot)."\r\n";
	}
	function jquery_load($k) {
		$this->jquery[] = $k;
	}
	function get_debug() {
		$debug = '';
		if($this->CI->lay->lay_type == 'text/html') {
			function loop_v($data) {
				if(is_array($data)) {
				} else {
					$data = get_object_vars($data);
				}
				ksort($data);
				$output = '<ul>';
				foreach($data as $k => $v) {
					if(is_array($v)) {
						if(count($v) != 0) {
							$output .= '<li>'.$k.':';
							$output .= loop_v($v);
							$output .= '</li>';
						}
					} elseif(strval($v) != '') {
						$output .= '<li>'.$k.':';
						$output .= ' '.$v;
						$output .= '</li>';
					}
				}
				$output .= '</ul>';
				return $output;
			}

			if($this->CI->hst->hst_debug == 1) {
				$debug = '<div id="box-debug">';
				$debug .= '<h1>Debug</h1>';
				$debug .= '<div class="display">';
			
				$debug .= '<p>elapsed time: '.$this->CI->benchmark->elapsed_time().'</p>';
				if(function_exists('memory_get_peak_usage')) {
					$debug .= '<p>memory peak usage: '.number_format(memory_get_peak_usage(), 0, '.', ' ').'</p>';
				}
				if(function_exists('memory_get_usage')) {
					$debug .= '<p>memory usage: '.number_format(memory_get_usage(), 0, '.', ' ').'</p>';
				}
	
				if(count($this->debug) != 0) {
					$debug .= '<ul>';
					foreach($this->debug as $item) {
						$debug .= '<li>'.$item.'</li>';
					}
					$debug .= '</ul>';
				}

				$debug .= '<h2>queries ('.count($this->CI->db->queries).')</h2>';
				$debug .= '<ul>';
				foreach($this->CI->db->queries as $query) {
					$debug .= '<li>'.$query.'</li>';
				}
				$debug .= '</ul>';

				$debug .= '<div class="column1">';
			
				$debug .= '<h2>itm</h2>';
				$debug .= loop_v($this->CI->itm);
			
				$debug .= '</div>';
			
				$debug .= '<div class="column1">';
			
				$debug .= '<h2>sct</h2>';
				$debug .= loop_v($this->CI->sct);
			
				$debug .= '<h2>hst</h2>';
				$debug .= loop_v($this->CI->hst);
			
				$debug .= '<h2>cmp</h2>';
				$debug .= loop_v($this->CI->cmp);
			
				$debug .= '</div>';
			
				$debug .= '<div class="column1">';
			
				$debug .= '<h2>usr</h2>';
				$debug .= loop_v($this->CI->usr);
			
				$debug .= '</div>';
			
				$debug .= '<div class="column1 columnlast">';
			
				$debug .= '<h2>lng</h2>';
				$debug .= loop_v($this->CI->lng);
			
				$debug .= '<h2>lay</h2>';
				$debug .= loop_v($this->CI->lay);
			
				$debug .= '<h2>stg</h2>';
				//$debug .= loop_v($this->CI->stg);
			
				$debug .= '</div>';
			
				$debug .= '</div>';
				$debug .= '</div>';
			}
		}
		return $debug."\r\n";
	}
}
