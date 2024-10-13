<?php
// custom core
require_once APPPATH.'core/Controller_custom.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends Controller {
	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', true);
		$this->load->model('Main_model');
	}

	public function index()
	{
		if (!file_exists(APPPATH.'views/main/dashboard.php')) {
			show_404();
		}

		$data['page_title'] = 'epunch';
		$data['page_name'] = 'dashboard';
		
		$this->load->view('templates/header', $data);
		$this->load->view('main/dashboard.php', $data);
		$this->load->view('templates/footer', $data);
	}

	public function summaryMain()
	{
		$COD = $this->session->userdata('UCOD');

		$data = $this->Main_model->getSummaryMain($COD);
		echo json_encode($data);
	}

	public function drawChart()
	{

		$COD = $this->session->userdata('UCOD');
		
		$chart = $this->input->post('chart');
		if ($chart == 'chart1') $data = $this->Main_model->getChartData($COD, 'A', 'M');
		else if ($chart == 'chart2') $data = $this->Main_model->getChartData($COD, 'B', 'M');
		else if ($chart == 'chart3') $data = $this->Main_model->getChartData($COD, 'C', 'M');
		else if ($chart == 'chart4') $data = $this->Main_model->getChartData($COD, 'D', 'M');

		echo json_encode($data);
	}
}
