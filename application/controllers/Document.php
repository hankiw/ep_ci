<?php
// custom core
require_once APPPATH.'core/Controller_custom.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends Controller {
	function __construct() {
		parent::__construct();

		defined('INC_JS_URL') OR define('INC_JS_URL', '/include/js/');
		
		$this->db = $this->load->database('default', true);
		$this->load->model('Tran_model');

		$this->current_page = $this->uri->rsegments[2];
	}

	public function index()
	{
		if (!file_exists(APPPATH.'views/document/index.php')) {
			show_404();
		}

		$pg = $this->input->get('pg') ? $this->input->get('pg') : 'index';

		$data['page_title'] = '사용메뉴얼';
		$data['pg'] = $pg;

		$this->load->view('templates/header', $data);
		$this->load->view('document/'.$pg, $data);
		$this->load->view('templates/footer', $data);
	}
}
