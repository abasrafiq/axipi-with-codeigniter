<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class layouts extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/layouts_model', '', true);
	}
	public function index() {
		$this->load->helper(array('form'));

		$filters = array();
		$filters['layouts_lay_code'] = array('lay.lay_code', 'like');
		$flt = build_filters($filters);

		$columns = array();
		$columns[] = 'lay.lay_id';
		$columns[] = 'lay.lay_code';
		$columns[] = 'lay.lay_type';
		$columns[] = 'count_sections';
		$col = build_columns('layouts', $columns, 'lay.lay_id', 'DESC');

		$results = $this->layouts_model->get_all_layouts($flt);
		$build_pagination = $this->axipi_library->build_pagination(ci_url().$this->itm->itm_code, 'layouts', $results->count, 30);

		$data = array();
		$data['columns'] = $col;
		$data['pagination'] = $build_pagination['output'];
		$data['position'] = $build_pagination['position'];
		$data['results'] = $this->layouts_model->get_pagination_layouts($flt, $build_pagination['limit'], $build_pagination['start'], 'layouts');
		$this->zones['content'] = $this->load->view('axipi_dynamic/layouts/layouts_index', $data, true);
	}
	public function rule_lay_code($lay_code, $current = '') {
		if($current != '') {
			$query = $this->db->query('SELECT lay.lay_code FROM '.$this->db->dbprefix('lay').' AS lay WHERE lay.lay_code = ? AND lay.lay_code != ? GROUP BY lay.lay_id', array($lay_code, $current));
		} else {
			$query = $this->db->query('SELECT lay.lay_code FROM '.$this->db->dbprefix('lay').' AS lay WHERE lay.lay_code = ? GROUP BY lay.lay_id', array($lay_code));
		}
		if($query->num_rows() > 0) {
			$this->form_validation->set_message('rule_lay_code', $this->lang->line('value_already_used'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function create() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();

		$this->form_validation->set_rules('lay_code', 'lang:lay_code', 'required|max_length[100]|callback_rule_lay_code');
		$this->form_validation->set_rules('lay_type', 'lang:lay_type', 'required|max_length[100]');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/layouts/layouts_create', $data, true);
		} else {
			$this->db->set('lay_code', $this->input->post('lay_code'));
			$this->db->set('lay_type', $this->input->post('lay_type'));
			$this->db->set('lay_createdby', $this->usr->usr_id);
			$this->db->set('lay_datecreated', date('Y-m-d H:i:s'));
			$this->db->set('lay_ispublished', 1);
			$this->db->insert('lay');
			$this->msg[] = $this->lang->line('created');
			$this->index();
		}
	}
	public function read($lay_id) {
		$data = array();
		$data['lay'] = $this->layouts_model->get_layout($lay_id);
		if($data['lay']) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/layouts/layouts_read', $data, true);
		} else {
			$this->index();
		}
	}
	public function update($lay_id) {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['lay'] = $this->layouts_model->get_layout($lay_id);
		if($data['lay']) {
			$this->form_validation->set_rules('lay_code', 'lang:lay_code', 'required|max_length[100]|callback_rule_lay_code['.$data['lay']->lay_code.']');
			$this->form_validation->set_rules('lay_type', 'lang:lay_type', 'required|max_length[100]');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/layouts/layouts_update', $data, true);
			} else {
				$this->db->set('lay_code', $this->input->post('lay_code'));
				$this->db->set('lay_type', $this->input->post('lay_type'));
				$this->db->set('lay_modifiedby', $this->usr->usr_id);
				$this->db->set('lay_datemodified', date('Y-m-d H:i:s'));
				$this->db->where('lay_id', $lay_id);
				$this->db->update('lay');
				$this->msg[] = $this->lang->line('updated');
				$this->index();
			}
		} else {
			$this->index();
		}
	}
	public function delete($lay_id) {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['lay'] = $this->layouts_model->get_layout($lay_id);
		if($data['lay']) {
			if($data['lay']->lay_islocked == 0) {
				$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');

				if($this->form_validation->run() == FALSE) {
					$this->zones['content'] = $this->load->view('axipi_dynamic/layouts/layouts_delete', $data, true);
				} else {
					$this->db->where('lay_id', $lay_id);
					$this->db->delete('zon');

					$this->db->where('lay_id', $lay_id);
					$this->db->where('lay_islocked', 0);
					$this->db->delete('lay');
					$this->msg[] = $this->lang->line('deleted');
					$this->index();
				}
			} else {
				$this->index();
			}
		}
	}
}
