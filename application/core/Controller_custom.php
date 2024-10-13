<?php
class Controller extends CI_Controller {
	function __construct() {
		parent::__construct();
		date_default_timezone_set('Asia/Seoul');

		$this->_controller = $this->uri->rsegment(1);
		
		$this->load->model('Auth_model');
		$UCOD = $this->session->userdata('UCOD');
		$UID = $this->session->userdata('UID');
		$this->login = $this->Auth_model->getLoginInfo($UCOD, $UID);
		// if ($this->session->userdata('CDIV')) $this->login->CDIV = $this->session->userdata('CDIV');

		if ($this->login === false && $this->_controller != 'home') {
			Header('Location:/');
		}
	}
}
