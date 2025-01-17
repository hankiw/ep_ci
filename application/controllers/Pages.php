<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {
	public function view($page = 'home')
	{
		if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
			show_404();
		}

		// $this->load->view('welcome_message');
		$data['title'] = ucfirst($page);
		$this->load->view('templates/header', $data);
		$this->load->view('templates/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}
}
