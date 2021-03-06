<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class permissions extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/permissions_model', '', true);
	}
	public function index() {
		$this->load->helper(array('form'));

		$filters = array();
		$filters['permissions_per_code'] = array('per.per_code', 'like');
		$flt = build_filters($filters);

		$columns = array();
		$columns[] = 'per.per_id';
		$columns[] = 'per.per_code';
		$columns[] = 'count_groups';
		$col = build_columns('permissions', $columns, 'per.per_id', 'DESC');

		$results = $this->permissions_model->get_all_permissions($flt);
		$build_pagination = $this->axipi_library->build_pagination(ci_url().$this->itm->itm_code, 'permissions', $results->count, 30);

		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->permissions_model->get_pagination_permissions($flt, $build_pagination['limit'], $build_pagination['start'], 'permissions');
		$this->zones['content'] = $this->load->view('axipi_dynamic/permissions/permissions_index', $data, true);
	}
	public function rule_per_code($per_code, $current = '') {
		if($current != '') {
			$query = $this->db->query('SELECT per.per_code FROM '.$this->db->dbprefix('per').' AS per WHERE per.per_code = ? AND per.per_code != ? GROUP BY per.per_id', array($per_code, $current));
		} else {
			$query = $this->db->query('SELECT per.per_code FROM '.$this->db->dbprefix('per').' AS per WHERE per.per_code = ? GROUP BY per.per_id', array($per_code));
		}
		if($query->num_rows() > 0) {
			$this->form_validation->set_message('rule_per_code', $this->lang->line('value_already_used'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function create() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['translations'] = $this->permissions_model->get_translations(0);

		$this->form_validation->set_rules('per_code', 'lang:per_code', 'required|max_length[100]|callback_rule_per_code');
		foreach($data['translations'] as $trl) {
			$this->form_validation->set_rules('title'.$trl->lng_id, $this->lang->line('per_trl_title').' ('.$trl->lng_code.')', 'required');
		}

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/permissions/permissions_create', $data, true);
		} else {
			$this->db->set('per_code', $this->input->post('per_code'));
			$this->db->set('per_createdby', $this->usr->usr_id);
			$this->db->set('per_datecreated', date('Y-m-d H:i:s'));
			$this->db->set('per_ispublished', 1);
			$this->db->insert('per');
			$per_id = $this->db->insert_id();

			foreach($data['translations'] as $trl) {
				$this->db->set('per_trl_title', $this->input->post('title'.$trl->lng_id));
				$this->db->set('per_id', $per_id);
				$this->db->set('lng_id', $trl->lng_id);
				$this->db->insert('per_trl');
			}

			$this->msg[] = $this->lang->line('created');
			$this->index();
		}
	}
	public function read($per_id) {
		$data = array();
		$data['per'] = $this->permissions_model->get_permission($per_id);
		if($data['per']) {
			$data['translations'] = $this->permissions_model->get_translations($per_id);
			$this->zones['content'] = $this->load->view('axipi_dynamic/permissions/permissions_read', $data, true);
		} else {
			$this->index();
		}
	}
	public function update($per_id) {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['per'] = $this->permissions_model->get_permission($per_id);
		if($data['per']) {
			$data['translations'] = $this->permissions_model->get_translations($per_id);

			$this->form_validation->set_rules('per_code', 'lang:per_code', 'required|max_length[100]|callback_rule_per_code['.$data['per']->per_code.']');
			foreach($data['translations'] as $trl) {
				$this->form_validation->set_rules('title'.$trl->lng_id, $this->lang->line('per_trl_title').' ('.$trl->lng_code.')', 'required');
			}

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/permissions/permissions_update', $data, true);
			} else {
				$this->db->set('per_code', $this->input->post('per_code'));
				$this->db->set('per_modifiedby', $this->usr->usr_id);
				$this->db->set('per_datemodified', date('Y-m-d H:i:s'));
				$this->db->where('per_id', $per_id);
				$this->db->update('per');

				foreach($data['translations'] as $trl) {
					$this->db->set('per_trl_title', $this->input->post('title'.$trl->lng_id));
					if($trl->per_id) {
						$this->db->where('per_id', $per_id);
						$this->db->where('lng_id', $trl->lng_id);
						$this->db->update('per_trl');
					} else {
						$this->db->set('per_id', $per_id);
						$this->db->set('lng_id', $trl->lng_id);
						$this->db->insert('per_trl');
					}
				}

				$this->msg[] = $this->lang->line('updated');
				$this->index();
			}
		} else {
			$this->index();
		}
	}
	public function delete($per_id) {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['per'] = $this->permissions_model->get_permission($per_id);
		if($data['per']) {
			if($data['per']->per_islocked == 0) {
				$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');
		
				if($this->form_validation->run() == FALSE) {
					$this->zones['content'] = $this->load->view('axipi_dynamic/permissions/permissions_delete', $data, true);
				} else {
					$this->db->where('per_id', $per_id);
					$this->db->delete('per_trl');
		
					$this->db->where('per_id', $per_id);
					$this->db->where('grp_per_islocked', 0);
					$this->db->delete('grp_per');
		
					$this->db->where('per_id', $per_id);
					$this->db->where('per_islocked', 0);
					$this->db->delete('per');
					$this->msg[] = $this->lang->line('deleted');
					$this->index();
				}
			} else {
				$this->index();
			}
		}
	}
}
