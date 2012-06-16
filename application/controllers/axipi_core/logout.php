<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class logout extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function index() {
		$this->auth->logout();
		if($this->config->item('hst_rewrite')) {
			redirect('axipi');
		} else {
			redirect('?ci=axipi');
		}
	}
}
