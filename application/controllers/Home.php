<?php
// custom core
require_once APPPATH.'core/Controller_custom.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Controller {
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url', 'cookie'));
		$this->load->library('form_validation');

		$this->form_validation->set_rules('COD', '회사코드', 'trim|requried');
		$this->form_validation->set_rules('MID', '아이디', 'trim|requried');
		$this->form_validation->set_rules('MPW', '비밀번호', 'trim|requried');

		$this->ckSAVE = get_cookie('ckSAVE');
		$this->ckCOD = get_cookie('ckCOD');
		$this->ckUID = get_cookie('ckUID');
	}
	public function index()
	{
		if (!file_exists(APPPATH.'views/home/index.php')) {
			show_404();
		}

		$data['notice'] = $this->boardLatest('notice', 3);

		$data['page_title'] = 'ePunch';
		$this->load->view('templates/header', $data);

		$this->load->view('home/index.php', $data);

		// login form
		$this->load->view('modal/modal_login', $data);
		
		$this->load->view('templates/footer', $data);
	}

	public function introduce()
	{
		if (!file_exists(APPPATH.'views/home/introduce.php')) {
			show_404();
		}
		
		$data['page_title'] = 'ePunch 소개';
		$this->load->view('templates/header', $data);
		$this->load->view('home/introduce.php', $data);

		// login form
		$this->load->view('modal/modal_login', $data);

		$this->load->view('templates/footer', $data);
	}

	// 회원가입 폼 페이지
	public function signup()
	{
		if (!file_exists(APPPATH.'views/home/signup.php')) {
			show_404();
		}
		
		$data['page_title'] = 'ePunch 서비스신청';
		$this->load->view('templates/header', $data);
		$this->load->view('home/signup.php', $data);

		// login form
		$this->load->view('modal/modal_login', $data);

		$this->load->view('templates/footer', $data);
	}

	// 회원가입처리
	public function registCmpy()
	{
		$this->load->model('Main_model');

		$response = new StdClass();
		if (!$NAM = $this->input->post('NAM')) die('parameter error NAM');
		if (!$SNO = $this->input->post('SNO')) die('parameter error SNO');
		if (!$EML = $this->input->post('EML')) die('parameter error EML');
		if (!$UNM = $this->input->post('UNM')) die('parameter error UNM');
		if (!$UTEL = $this->input->post('UTEL')) die('parameter error UTEL');
		if (!$UID = $this->input->post('UID')) die('parameter error UID');
		if (!$UPW = $this->input->post('UPW')) die('parameter error UPW');
		if (!$UPW_CONF = $this->input->post('UPW_CONF')) die('parameter error UPW_CONF');

		if ($UPW != $UPW_CONF) {
			$response->result = false;
			$response->msg = '비밀번호를 확인해주세요.';
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			exit;
		}

		$response->result = $this->Main_model->registCmpy($NAM, $SNO, $EML, $UNM, $UTEL, $UID, $UPW, $UPW_CONF);
		
		if ($response->result) {
			$response->msg = '가입신청이 완료되었습니다.';
		} else {
			$response->msg = '오류가 발생했습니다.';
		}

		echo json_encode($response, JSON_UNESCAPED_UNICODE);
		exit;
	}

	// 체험하기
	public function demo()
	{
		$this->load->model('Auth_model');
		$check = $this->Auth_model->checkLogin('DEMO', 'demo', 'demo');
		if ($check) {
			$this->setLoginSession($check[0]['COD'], $check[0]['UID'], $check[0]['CDIV']);
		}

		header('Location:/');
	}

	private function boardLatest($bo, $limit)
	{
		$this->load->model('Board_model');
		$latest = $this->Board_model->getLatest('notice', $limit);
		$list = array();
		foreach ($latest as $idx => $row) {
			$row['href'] = '/board/view?BNM='.$bo.'&BSEQ='.$row['BSEQ'];
			$row['no'] = $limit - $idx;
			$list[$idx] = $row;
		}
		return $list;
	}

	// demo 로그인 처리 
	private function setLoginSession($COD, $UID, $CDIV)
	{
		$tmp = array('UCOD' => $COD, 'UID' => $UID, 'CDIV' => $CDIV);
		$this->session->set_userdata($tmp);
		if ($this->session->userdata['UID'] && $this->session->userdata['UCOD']) return true;
		else return true;
	}

	// test
	public function test()
	{
		$this->load->view('templates/test');
	}
}
