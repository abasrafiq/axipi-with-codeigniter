<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class error404 extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function index() {
		$this->output->set_status_header(404);
		$this->zones['content'] = '<p>404</p>';
	}
}
