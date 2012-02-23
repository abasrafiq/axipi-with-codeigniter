<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class items extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->language('axipi_dynamic');
		$this->load->model('axipi_dynamic/items_model', '', true);

		if($this->input->get('itm_id')) {
			$this->itm_id = $this->input->get('itm_id');
		} else {
			$this->itm_id = 0;
		}
	}
	public function index() {
		$this->load->helper(array('axipi', 'form'));

		$filters = array();
		$filters['items_itm_code'] = array('itm.itm_code', 'like');
		$filters['items_itm_title'] = array('itm.itm_title', 'like');
		$filters['items_sct_id'] = array('itm.sct_id', 'equal');
		$filters['items_cmp_code'] = array('cmp.cmp_code', 'like');
		$filters['items_lng_id'] = array('itm.lng_id', 'equal');
		$flt = build_filters($filters);

		$results_count = $this->items_model->get_all_items($flt);
		$build_pagination = $this->axipi_library->build_pagination($results_count[0]->count, 30);

		$data = array();
		$data['pagination'] = $build_pagination['output'];
		$data['results'] = $this->items_model->get_pagination_items($flt, $build_pagination['limit'], $build_pagination['start']);
		$data['select_section'] = $this->items_model->select_section();
		$data['select_language'] = $this->items_model->select_language();
		$this->zones['content'] = $this->load->view('axipi_dynamic/items/items_index', $data, true);
	}
	public function rule_itm_code($itm_code) {
		$query = $this->db->query('SELECT itm.itm_code FROM '.$this->db->dbprefix('itm').' AS itm WHERE itm.itm_code = ? GROUP BY itm.itm_id', array($itm_code));
		if($query->num_rows() > 0) {
			$this->form_validation->set_message('rule_itm_code', $this->lang->line('value_already_used'));
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function create() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$data = array();
		$data['select_component'] = $this->items_model->select_component();
		$data['select_section'] = $this->items_model->select_section();
		$data['select_language'] = $this->items_model->select_language();

		$this->form_validation->set_rules('sct_id', 'lang:sct_code', 'required');
		$this->form_validation->set_rules('itm_code', 'lang:itm_code', 'required|max_length[100]|callback_rule_itm_code');
		$this->form_validation->set_rules('itm_virtualcode', 'lang:itm_virtualcode', 'max_length[100]');
		$this->form_validation->set_rules('itm_title', 'lang:itm_title', 'required|max_length[255]');
		$this->form_validation->set_rules('cmp_id', 'lang:cmp_code', 'required');
		$this->form_validation->set_rules('itm_link', 'lang:itm_link', 'max_length[255]');
		$this->form_validation->set_rules('itm_ordering', 'lang:itm_ordering', 'required|numeric');
		$this->form_validation->set_rules('lng_id', 'lang:lng_code', 'required');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_dynamic/items/items_create', $data, true);
		} else {
			$this->db->set('sct_id', $this->input->post('sct_id'));
			$this->db->set('itm_code', $this->input->post('itm_code'));
			$this->db->set('itm_virtualcode', $this->input->post('itm_virtualcode'));
			$this->db->set('itm_title', $this->input->post('itm_title'));
			$this->db->set('cmp_id', $this->input->post('cmp_id'));
			$this->db->set('itm_content', $this->input->post('itm_content'));
			$this->db->set('itm_summary', $this->input->post('itm_summary'));
			$this->db->set('itm_link', $this->input->post('itm_link'));
			$this->db->set('lng_id', $this->input->post('lng_id'));
			$this->db->set('itm_ispublished', 1);
			$this->db->insert('itm'); 
			$this->index();
		}
	}
	public function read() {
		if($this->itm_id != 0) {
			$data = array();
			$data['itm'] = $this->items_model->get_item($this->itm_id);
			$this->zones['content'] = $this->load->view('axipi_dynamic/items/items_read', $data, true);
		}
	}
	public function update() {
		if($this->itm_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['itm'] = $this->items_model->get_item($this->itm_id);
			$data['select_component'] = $this->items_model->select_component();
			$data['select_section'] = $this->items_model->select_section();
			$data['select_language'] = $this->items_model->select_language();

			$this->form_validation->set_rules('sct_id', 'lang:sct_code', 'required');
			$this->form_validation->set_rules('itm_code', 'lang:itm_code', 'required|max_length[100]');
			$this->form_validation->set_rules('itm_virtualcode', 'lang:itm_virtualcode', 'max_length[100]');
			$this->form_validation->set_rules('itm_title', 'lang:itm_title', 'required|max_length[255]');
			$this->form_validation->set_rules('cmp_id', 'lang:cmp_code', 'required');
			$this->form_validation->set_rules('itm_link', 'lang:itm_link', 'max_length[255]');
			$this->form_validation->set_rules('itm_ordering', 'lang:itm_ordering', 'required|numeric');
			$this->form_validation->set_rules('lng_id', 'lang:lng_code', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/items/items_update', $data, true);
			} else {
				$this->db->set('sct_id', $this->input->post('sct_id'));
				$this->db->set('itm_code', $this->input->post('itm_code'));
				$this->db->set('itm_virtualcode', $this->input->post('itm_virtualcode'));
				$this->db->set('itm_title', $this->input->post('itm_title'));
				$this->db->set('cmp_id', $this->input->post('cmp_id'));
				$this->db->set('itm_content', $this->input->post('itm_content'));
				$this->db->set('itm_summary', $this->input->post('itm_summary'));
				$this->db->set('itm_link', $this->input->post('itm_link'));
				$this->db->set('lng_id', $this->input->post('lng_id'));
				$this->db->where('itm_id', $this->itm_id);
				$this->db->update('itm'); 
				$this->index();
			}
		}
	}
	public function delete() {
		if($this->itm_id != 0) {
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$data = array();
			$data['itm'] = $this->items_model->get_item($this->itm_id);

			$this->form_validation->set_rules('confirm', 'lang:confirm', 'required');

			if($this->form_validation->run() == FALSE) {
				$this->zones['content'] = $this->load->view('axipi_dynamic/items/items_delete', $data, true);
			} else {
				$this->db->where('itm_id', $this->itm_id);
				$this->db->where('itm_islocked', 0);
				$this->db->delete('itm'); 
				$this->index();
			}
		}
	}
}
