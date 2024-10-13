<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function index()
	{
		if (!file_exists(APPPATH.'views/dashboard/index.php')) {
			show_404();
		}

		// $this->load->view('welcome_message');
		$data['page_title'] = 'epunch';
		$this->load->view('templates/header', $data);
		$this->load->view('dashboard/index.php', $data);
		$this->load->view('templates/footer', $data);
	}
}
