<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function index() {
		$this->load->helper(array('form'));
		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'lang:email', 'required|valid_email|callback_rule_login');
		$this->form_validation->set_rules('password', 'lang:password', 'required');
		$this->form_validation->set_rules('remember_checkbox', 'lang:remember_checkbox');

		if($this->form_validation->run() == FALSE) {
			$this->zones['content'] = $this->load->view('axipi_core/login_index', null, true);
		} else {
			if($this->input->post('remember_checkbox')) {
				//$this->input->set_cookie(array('name'=>'axipi-remember', 'value'=>1, 'expire'=>3600*24*30, 'path'=>'/', 'secure'=>TRUE));
			}
			if($this->config->item('hst_rewrite')) {
				redirect('axipi');
			} else {
				redirect('?ci=axipi');
			}
		}
	}
	public function rule_login() {
		if($this->auth->login($this->input->post('email'), $this->input->post('password'))) {
			return TRUE;
		} else {
			$this->form_validation->set_message('rule_login', $this->lang->line('login_error'));
			return FALSE;
		}
	}
}
