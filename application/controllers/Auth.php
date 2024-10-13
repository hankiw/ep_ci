<?php
// custom core
require_once APPPATH.'core/Controller_custom.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->db = $this->load->database('default', true);
		$this->load->model('Auth_model');
		$this->load->helper('form');
		$this->load->helper('cookie');
		$this->load->library('form_validation');
	}

	public function checkLogin()
	{
		$response = new StdClass();
		$this->form_validation->set_rules('COD', '회사코드', 'required');
		$this->form_validation->set_rules('UID', '아이디', 'required');
		$this->form_validation->set_rules('UPW', '비밀번호', 'required');
		
		if (!$this->form_validation->run()) {
			$response->result = false;
			$response->msg = validation_errors();
		} else {
			$COD = $this->input->post('COD');
			$UID = $this->input->post('UID');
			$UPW = $this->input->post('UPW');
			$SAVE = $this->input->post('SAVE');

			if ($SAVE == 'Y') {
				if (!$ckSAVE = get_cookie('ckSAVE')) set_cookie('ckSAVE', $SAVE, (86400 * 30));
				if (!$ckCOD = get_cookie('ckCOD')) set_cookie('ckCOD', $COD, (86400 * 30));
				if (!$ckUID = get_cookie('ckUID')) set_cookie('ckUID', $UID, (86400 * 30));
			} else {
				delete_cookie('ckSAVE');
				delete_cookie('ckCOD');
				delete_cookie('ckUID');
			}

			$check = $this->Auth_model->checkLogin($COD, $UID, $UPW);
			if (!$check) {
				$response->result = false;
				$response->msg = '아이디/패스워드 를 확인하세요.';
			} else {
				// $tmp = array('COD' => $COD, 'UID' => $UID);
				// $this->session->set_userdata($tmp);
				// $response->result = true;

				if ($this->setLoginSession($check[0]['COD'], $check[0]['UID'], $check[0]['CDIV'])) {
					$response->result = true;
				} else {
					$response->result = false;
					$response->msg = 'session error';
				}
			}
		}
		
		echo json_encode($response);
		exit;
	}

	public function logout()
	{
		$this->session->unset_userdata('UID');
		$this->session->unset_userdata('UCOD');
		header('Location:/');
	}

	private function setLoginSession($COD, $UID, $CDIV)
	{
		$tmp = array('UCOD' => $COD, 'UID' => $UID, 'CDIV' => $CDIV);
		$this->session->set_userdata($tmp);
		if ($this->session->userdata['UID'] && $this->session->userdata['UCOD']) return true;
		else return true;
	}


}
