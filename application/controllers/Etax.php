<?php
// custom core
require_once APPPATH.'core/Controller_custom.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class Etax extends Controller {
	function __construct() {
		parent::__construct();

		defined('INC_JS_URL') OR define('INC_JS_URL', '/include/js/');

		$this->db = $this->load->database('default', true);
		$this->load->model('Etax_model');
	}

	public function getCmpyInfo()
	{
		$COD = $this->input->post('COD');
		$CDS = $this->input->post('CDS');
		$cmpy_info = $this->Etax_model->getCmpyInfo($COD, $CDS);
		echo json_encode($cmpy_info, JSON_UNESCAPED_UNICODE);
	}

	public function makeEtaxCheck()
	{
		$COD = $this->input->post('COD');
		$CDS = $this->input->post('CDS');
		$request = $this->input->post('request');
		$return = array();

		// 잔여 포인트 확인
		$pnt = (int) $this->login->BALPNT;
		// $pnt = 100;
		$use_pnt = count($request) * 100;
		if ($pnt < $use_pnt) {
			$return['result'] = false;
			$return['msg'] = '보유 포인트가 부족합니다.';
		} else {
			$return['result'] = true;
		}

		echo json_encode($return, JSON_UNESCAPED_UNICODE);
	}

	public function makeEtaxRun()
	{
		$COD = $this->input->post('COD');
		$CDS = $this->input->post('CDS');
		$request = $this->input->post('request');
		$return = array();

		// 잔여 포인트 확인
		$pnt = (int) $this->login->BALPNT;
		$use_pnt = count($request) * 100;
		if ($pnt < $use_pnt) {
			$return['result'] = false;
			$return['msg'] = '보유 포인트가 부족합니다.';
			echo json_encode($return, JSON_UNESCAPED_UNICODE);
			exit;
		}

		// 실제 발행 후 sp 처리 하는지? 먼저 sp 처리 하고 실발행 하는지?
		$submit = array();
		foreach ($request as $row) {
			// 발행sp
			$rs = $this->Etax_model->makeEtaxSingle($COD, $row['TNO'], $row['DTS_YY'], $row['DTS_MM'], $row['DTS_DD'], $row['TYP'], $row['CDS'], $row['NET'], $row['VAT'], $row['MDFYCD'], $row['EDIV'], $row['EEML'], $row['EDTS'], $row['ATNO']);
			if ($rs) {
				$submit[] = $row['TNO'];
				// 정상발행 후처리 (포인트 차감 등) 여기서 해야하는지?
				// 아니면 실발행 이우에 하는지?
			}
		}

		$return['result'] = true;
		$return['msg'] = '세금계산서가 발행되었습니다.';
		$return['submit'] = $submit;
		echo json_encode($return, JSON_UNESCAPED_UNICODE);
	}

	public function makeEtaxMulti()
	{

		$COD = $this->input->post('COD');
		$NOS = $this->input->post('checkedNOS');
		$result = $this->Etax_model->makeEtaxMulti($COD, $NOS);
		
		// $this->load->model('Point_model');
		// if ($result->result_id) {
		// 	$result = $this->Point_model->usePoint($COD, '건별발행', '100', '');
		// }

		echo json_encode($result->result_id);
	}

	public function cancelEtaxMulti()
	{

		$COD = $this->input->post('COD');
		$TNO = $this->input->post('checkedTNO');
		$TNO = implode(',', $TNO);
		$result = $this->Etax_model->cancelEtaxMulti($COD, $TNO);

		// $this->load->model('Point_model');
		// if ($result->result_id) {
		// 	$result = $this->Point_model->usePoint($COD, '건별발행', '100', '');
		// }

		echo json_encode($result->result_id);
	}

	// 합산계산서발행 페이지
	public function invoice()
	{
		if (!file_exists(APPPATH.'views/etax/invoice.php')) {
			show_404();
		}

		date_default_timezone_set("Asia/Seoul");
		
		if (isset($_GET['YM'])) {
			$data['Y'] = substr($_GET['YM'], 0, 4);
			$data['M'] = substr($_GET['YM'], 4, 2);
		} else {
			$data['Y'] = date('Y');
			$data['M'] = date('m');
		}

		$SDT = $this->input->get('SDT');
		$EDT = $this->input->get('SDT');
		// 기간 사용 X, 월단위로 검색하기로 수정
		// $EDT = $this->input->get('EDT');
		
		if (!$SDT || !$EDT) {
			$data['sdt'] = $data['Y'].'-'.$data['M'];
			$data['edt'] = $data['Y'].'-'.$data['M'];
		} else {
			$data['sdt'] = $SDT;
			$data['edt'] = $EDT;
		}

		// 오늘
		$TDT = date('Ymd');
		$data['tdt'] = $TDT;

		$COD = $this->login->COD;
		$DVS = '1';

		$data['page_title'] = '세금계산서 합산발행';
		$data['COD'] = $COD;
		$data['YM'] = $data['Y'].$data['M'];
		$data['DVS'] = $DVS;

		$this->load->view('templates/header', $data);
		$this->load->view('etax/invoice', $data);
		
		// 
		// // 세금계산서 합상발행
		// $this->load->view('modal/modal_etax', $data);
		// // 세금계산서 합산발행 grid
		// $this->load->view('modal/modal_etax_grid', $data);
		// 포인트 관리
		$this->load->view('modal/modal_point', $data);

		$this->load->view('templates/footer', $data);
	}

	public function gridCompanyData()
	{
		$COD = $this->input->post('COD');
		$DVS = $this->input->post('DVS');
		$SDT = $this->input->post('SDT');
		$EDT = $this->input->post('EDT');

		$data = $this->Etax_model->getCompanyData($COD, $DVS, $SDT, $EDT);
		echo json_encode($data);
	}

	public function gridSalesData()
	{
		$COD = $this->input->post('COD');
		$DVS = $this->input->post('DVS');
		$SDT = $this->input->post('SDT');
		$EDT = $this->input->post('EDT');
		$CDS = $this->input->post('CDS');

		$data = $this->Etax_model->getSalesData($COD, $DVS, $SDT, $EDT, $CDS);
		echo json_encode($data);
	}

	public function gridInvoiveData()
	{
		$COD = $this->input->post('COD');
		$DVS = $this->input->post('DVS');
		$SDT = $this->input->post('SDT');
		$EDT = $this->input->post('EDT');
		$CDS = $this->input->post('CDS');

		$data = $this->Etax_model->getInvoiveData($COD, $DVS, $SDT, $EDT, $CDS);
		echo json_encode($data);
	}


	// 미사용
	// public function getEtaxBef()
	// {
	// 	$COD = $this->input->post('COD');
	// 	$DVS = $this->input->post('DVS');
	// 	$NOS = $this->input->post('NOS');

	// 	if ($COD != $this->login->COD) {
	// 		die('error');
	// 	}

	// 	$etax_bef = $this->Etax_model->getEtaxBef($COD, $DVS, $NOS);
	// 	echo json_encode($etax_bef, JSON_UNESCAPED_UNICODE);
	// }

	// public function makeEtaxSingle()
	// {
	// 	$this->load->model('Point_model');

	// 	$COD = $this->input->post('COD');
	// 	$DVS = $this->input->post('DVS');
	// 	$ENO = $this->input->post('ENO');
	// 	$CDS = $this->input->post('CDS');
	// 	$NOS = $this->input->post('NOS');
	// 	$EDTS = $this->input->post('EDTS');
	// 	$EITM = $this->input->post('EITM');
	// 	$ERMK = $this->input->post('ERMK');
	// 	$EMGR = $this->input->post('EMGR');
	// 	$EEML = $this->input->post('EEML');
		
	// 	$result = $this->Etax_model->makeEtaxSingle($COD, $DVS, $ENO, $CDS, $NOS, $EDTS, $EITM, $ERMK, $EMGR, $EEML);
	// 	if ($result->result_id) {
	// 		$result = $this->Point_model->usePoint($COD, '건별발행', '100', '');
	// 	}

	// 	echo json_encode($result->result_id);
	// }
}
