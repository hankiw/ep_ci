<?php
// custom core
require_once APPPATH.'core/Controller_custom.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends Controller {
	function __construct() {
		parent::__construct();

		defined('INC_JS_URL') OR define('INC_JS_URL', '/include/js/');
		
		$this->db = $this->load->database('default', true);
		$this->load->model('Manage_model');
	}

	public function index()
	{
		if (!file_exists(APPPATH.'views/main/index.php')) {
			show_404();
		}

		// $this->load->view('welcome_message');
		$data['title'] = 'ci test main';
		$this->load->view('templates/header', $data);
		$this->load->view('main/index', $data);
		$this->load->view('templates/footer', $data);


	}

	public function storeout()
	{
		if (!file_exists(APPPATH.'views/manage/storemanage.php')) {
			show_404();
		}
		
		date_default_timezone_set("Asia/Seoul");

		if (isset($_GET['YM'])) {
			$YM = str_replace('-', '', $this->input->get('YM'));
			$data['Y'] = substr($YM, 0, 4);
			$data['M'] = substr($YM, 4, 2);
		} else {
			$data['Y'] = date('Y');
			$data['M'] = date('m');
		}

		if (isset($_GET['DD']) && $_GET['DD'] != '') $data['DD'] = sprintf('%02d', (int) $_GET['DD']);
		else $data['DD'] = '';

		$COD = $this->login->COD;
		$DVS = '1';

		$data['page_title'] = '판매입력';
		$data['COD'] = $COD;
		$data['YM'] = $data['Y'].$data['M'];
		$data['YMF'] = $data['Y'].'-'.$data['M'];
		$data['DVS'] = $DVS;

		$this->load->view('templates/header', $data);

		// view 파일 storemanage 공통사용에서 따로 분리
		// $this->load->view('manage/storemanage', $data);
		$this->load->view('manage/storeout', $data);

		// 거래처 선택, 등록 modal
		$this->load->view('modal/modal_cmpy', $data);
		// 품목 선택, 등록 modal
		$this->load->view('modal/modal_prod', $data);
		// 세금계산서 건별발행
		$this->load->view('modal/modal_etax', $data);
		// 포인트 관리
		$this->load->view('modal/modal_point', $data);

		
		$this->load->view('templates/footer', $data);
	}

	public function storein()
	{
		if (!file_exists(APPPATH.'views/manage/storemanage.php')) {
			show_404();
		}

		date_default_timezone_set("Asia/Seoul");
		
		if (isset($_GET['YM'])) {
			$YM = str_replace('-', '', $this->input->get('YM'));
			$data['Y'] = substr($YM, 0, 4);
			$data['M'] = substr($YM, 4, 2);
		} else {
			$data['Y'] = date('Y');
			$data['M'] = date('m');
		}

		if (isset($_GET['DD']) && $_GET['DD'] != '') $data['DD'] = sprintf('%02d', (int) $_GET['DD']);
		else $data['DD'] = '';

		$COD = $this->login->COD;
		$DVS = '2';

		$data['page_title'] = '구매입력';
		$data['COD'] = $COD;
		$data['YM'] = $data['Y'].$data['M'];
		$data['YMF'] = $data['Y'].'-'.$data['M'];
		$data['DVS'] = $DVS;

		$this->load->view('templates/header', $data);

		// view 파일 storemanage 공통사용에서 따로 분리
		// $this->load->view('manage/storemanage', $data);
		$this->load->view('manage/storein', $data);

		// 거래처 선택, 등록 modal
		$this->load->view('modal/modal_cmpy', $data);
		// 품목 선택, 등록 modal
		$this->load->view('modal/modal_prod', $data);
		// 세금계산서 건별발행
		$this->load->view('modal/modal_etax', $data);
		// 포인트 관리
		$this->load->view('modal/modal_point', $data);
		
		$this->load->view('templates/footer', $data);
	}

	public function quotation()
	{
		if (!file_exists(APPPATH.'views/manage/storemanage.php')) {
			show_404();
		}

		date_default_timezone_set("Asia/Seoul");
		
		if (isset($_GET['YM'])) {
			$YM = str_replace('-', '', $this->input->get('YM'));
			$data['Y'] = substr($YM, 0, 4);
			$data['M'] = substr($YM, 4, 2);
		} else {
			$data['Y'] = date('Y');
			$data['M'] = date('m');
		}

		if (isset($_GET['DD']) && $_GET['DD'] != '') $data['DD'] = sprintf('%02d', (int) $_GET['DD']);
		else $data['DD'] = '';

		$COD = $this->login->COD;
		$DVS = '6';

		$data['page_title'] = '견적서입력';
		$data['COD'] = $COD;
		$data['YM'] = $data['Y'].$data['M'];
		$data['YMF'] = $data['Y'].'-'.$data['M'];
		$data['DVS'] = $DVS;

		$this->load->view('templates/header', $data);
		// view 파일 storemanage 공통사용에서 따로 분리
		// $this->load->view('manage/storemanage', $data);
		$this->load->view('manage/quotation', $data);

		// 거래처 선택, 등록 modal
		$this->load->view('modal/modal_cmpy', $data);
		// 품목 선택, 등록 modal
		$this->load->view('modal/modal_prod', $data);
		$this->load->view('templates/footer', $data);
	}

	public function request()
	{
		if (!file_exists(APPPATH.'views/manage/storemanage.php')) {
			show_404();
		}

		date_default_timezone_set("Asia/Seoul");
		
		if (isset($_GET['YM'])) {
			$YM = str_replace('-', '', $this->input->get('YM'));
			$data['Y'] = substr($YM, 0, 4);
			$data['M'] = substr($YM, 4, 2);
		} else {
			$data['Y'] = date('Y');
			$data['M'] = date('m');
		}

		if (isset($_GET['DD']) && $_GET['DD'] != '') $data['DD'] = sprintf('%02d', (int) $_GET['DD']);
		else $data['DD'] = '';

		$COD = $this->login->COD;
		$DVS = '7';

		$data['page_title'] = '발주서입력';
		$data['COD'] = $COD;
		$data['YM'] = $data['Y'].$data['M'];
		$data['YMF'] = $data['Y'].'-'.$data['M'];
		$data['DVS'] = $DVS;

		$this->load->view('templates/header', $data);
		// view 파일 storemanage 공통사용에서 따로 분리
		// $this->load->view('manage/storemanage', $data);
		$this->load->view('manage/request', $data);
		
		// 거래처 선택, 등록 modal
		$this->load->view('modal/modal_cmpy', $data);
		// 품목 선택, 등록 modal
		$this->load->view('modal/modal_prod', $data);
		$this->load->view('templates/footer', $data);
	}

	public function gridMasterData()
	{
		$DVS = $_POST['DVS'];
		$COD = $_POST['COD'];
		$YM = $_POST['YM'];
		$D = $_POST['D'];
		$data = $this->Manage_model->getMasterData($DVS, $COD, $YM, $D);
		echo json_encode($data);
	}

	public function gridDetailData()
	{
		$COD = $_POST['COD'];
		$DVS = $_POST['DVS'];
		$NOS = $_POST['NOS'];
		$data = $this->Manage_model->getDetailData($COD, $DVS, $NOS);
		echo json_encode($data);
	}

	// 미사용함
	public function saveRowData()
	{
		// print_r($_POST);
		$CRUD = $_POST['CRUD'];
		$DTS = $_POST['DTS'];
		$TYP = $_POST['TYP'];
		$GBN = $_POST['GBN'];
		$CDS = $_POST['CDS'];
		$DVS = $_POST['DVS'];
		$COD = $_POST['COD'];
		$YM = $_POST['YM'];

		// if ($DVS === '1') {
		// 	$tmpNOS = 'S'.substr($DTS, 2);
		// } else if ($DVS === '2') {
		// 	$tmpNOS = 'P'.substr($DTS, 2);
		// }
		// $NOS_no = $this->Manage_model->getNewNOS($COD, $DVS, $DTS);
		// $newNOS = $tmpNOS.'-'.sprintf('%05d', $NOS_no);

		// $newNOS = $this->Manage_model->getNewNOS($COD, $DVS, $DTS);
		$newNOS = '';

		$result = $this->Manage_model->updateRowData($CRUD, $COD, $DVS, $DTS, $NOS, $TYP, $GBN, $CDS, $NET, $VAT);
		echo json_encode($result->result_id);
	}

	public function updateRowData()
	{
		$CRUD = $this->input->post('CRUD');
		$COD = $this->input->post('COD');
		$DVS = $this->input->post('DVS');
		$DTS = $this->input->post('DTS');
		$NOS = $this->input->post('NOS');
		$TYP = $this->input->post('TYP');
		$GBN = $this->input->post('GBN');
		$CDS = $this->input->post('CDS');
		$NET = $this->input->post('NET') ? $this->input->post('NET') : '0';
		$VAT = $this->input->post('VAT') ? $this->input->post('VAT') : '0';

		// $no_dts = $this->Manage_model->getNoDTS($COD, $DVS, $NOS);
		$result = $this->Manage_model->updateRowData($CRUD, $COD, $DVS, $DTS, $NOS, $TYP, $GBN, $CDS, $NET, $VAT);
		// echo json_encode($result->result_id);
		echo json_encode($result[0]);
	}

	public function deleteRowData()
	{
		$COD = $_POST['COD'];
		$DVS = $_POST['DVS'];
		$NOS = $_POST['NOS'];
		$NOS = join($NOS, ',');

		$result = $this->Manage_model->deleteRowData($COD, $DVS, $NOS);
		echo json_encode($result->result_id);
	}

	public function transfer_tran_RowData()
	{
		$COD = $_POST['COD'];
		$NOS = $_POST['NOS'];
		$NOS = join($NOS, ',');

		$result = $this->Manage_model->transfer_tran_RowData($COD, $NOS);
		if ($result->result_id) {
			echo json_encode($result->result_id);
		} else {
			echo $result;
		}
	}

	public function transfer_cancel_RowData()
	{
		$COD = $_POST['COD'];
		$TNO = $_POST['TNO'];
		$TNO = join($TNO, ',');

		$result = $this->Manage_model->transfer_cancel_RowData($COD, $TNO);
		echo json_encode($result->result_id);
	}


	// 미사용함
	public function saveRowDataDetail()
	{
		// print_r($_POST);
		$COD = $_POST['COD'];
		$DVS = $_POST['DVS'];
		$PCOD = $_POST['PCOD'];
		$QTYS = $_POST['QTYS'];
		$NOS = $_POST['NOS'];

		// $NSEQS = $this->Manage_model->getDetailSeq($COD, $DVS, $NOS);

		$result = $this->Manage_model->saveRowDataDetail($COD, $DVS, $NOS, $PCOD, $QTYS);
		// echo json_encode($result->result_id);
		echo json_encode($result[0]);
	}

	public function updateRowDataDetail()
	{
		$CRUD = $this->input->post('CRUD');
		$COD = $this->input->post('COD');
		$DVS = $this->input->post('DVS');
		$NOS = $this->input->post('NOS');
		$SEQS = $this->input->post('SEQS');
		$DSEQ = $this->input->post('DSEQ');
		$PCOD = $this->input->post('PCOD');
		$QTYS = $this->input->post('QTYS') ? $this->input->post('QTYS') : '0';
		$PRIC = $this->input->post('PRIC') ? $this->input->post('PRIC') : '0';
		$REMK = $this->input->post('REMK');

		$result = $this->Manage_model->updateRowDataDetail($CRUD, $COD, $DVS, $NOS, $SEQS, $DSEQ, $PCOD, $QTYS, $PRIC, $REMK);
		// echo json_encode($result->result_id);
		echo json_encode($result[0]);
	}

	// 거래처 코드 가져오기
	public function getCmpyCods()
	{
		$COD = $_POST['COD'];
		$SCH = isset($_POST['SCH']) ? $_POST['SCH'] : '';
		$CDS = isset($_POST['CDS']) ? $_POST['CDS'] : '';
		$cmpy_cods = $this->Manage_model->getCmpyCods($COD, $SCH, $CDS);
		echo json_encode($cmpy_cods);
	}

	// 거래처 등록 시 거래처 코드 가져오기
	public function getNextCmpyCds()
	{
		$COD = $_POST['COD'];
		$CDS = $this->Manage_model->getNextCmpyCds($COD);
		echo $CDS;
	}

	// 거래처 등록
	public function saveCmpyCds()
	{
		$COD = $_POST['COD'];
		$CDS = $_POST['CDS'];
		$NAM = $_POST['NAM'];
		$SNO = $_POST['SNO'];
		$JNO = $_POST['JNO'];
		$OWN = $_POST['OWN'];
		$ZIP = $_POST['ZIP'];
		$ADR1 = $_POST['ADR1'];
		$ADR2 = $_POST['ADR2'];
		$TYP = $_POST['TYP'];
		$KND = $_POST['KND'];
		$MGR1 = $_POST['MGR1'];
		$EML1 = $_POST['EML1'];
		$MGR2 = $_POST['MGR2'];
		$EML2 = $_POST['EML2'];

		$tmp = $this->Manage_model->isCmpyCods($COD, $CDS);
		if ($tmp) $CRUD = 'U';
		else $CRUD = 'C';

		$result = $this->Manage_model->saveCmpyCds($CRUD, $COD, $CDS, $NAM, $SNO, $JNO, $OWN, $ZIP, $ADR1, $ADR2, $TYP, $KND, $MGR1, $EML1, $MGR2, $EML2);
		echo json_encode($result->result_id);
	}

	// 품목군 가져오기
	public function getPg()
	{
		$COD = $_POST['COD'];
		$SCH = isset($_POST['SCH']) ? $_POST['SCH'] : '';
		$pg = $this->Manage_model->getPg($COD, $SCH);
		echo json_encode($pg);
	}

	// 품목 가져오기
	public function getProd()
	{
		$COD = $_POST['COD'];
		$SCH = isset($_POST['SCH']) ? $_POST['SCH'] : '';
		$CDS = isset($_POST['CDS']) ? $_POST['CDS'] : '';
		$prod = $this->Manage_model->getProd($COD, $SCH, $CDS);
		echo json_encode($prod);
	}

	// 품목 등록 시 품목 코드 가져오기
	public function getNextPcod()
	{
		$COD = $_POST['COD'];
		$PCOD = $this->Manage_model->getNextPcod($COD);
		echo $PCOD;
	}

	// 품목 등록
	public function saveProd()
	{
		$COD = $_POST['COD'];
		$PCOD = $_POST['PCOD'];
		$DVS = $_POST['DVS'];
		$NAM = $_POST['NAM'];
		$STD = $_POST['STD'];
		$UNT = $_POST['UNT'];
		$TAXCD = $_POST['TAXCD'];
		$STDCOST = $_POST['STDCOST'];
		$STDSALE =  $_POST['STDSALE'];
		$RMK = $_POST['RMK'];


		$tmp = $this->Manage_model->isPcod($COD, $PCOD);
		if ($tmp) $CRUD = 'U';
		else $CRUD = 'C';


		// echo $CRUD.'|'.$COD.'|'.$PCOD.'|'.$DVS.'|'.$NAM.'|'.$STD.'|'.$UNT.'|'.$TAXCD.'|'.$STDCOST.'|'.$STDSALE.'|'.$RMK;

		$result = $this->Manage_model->saveProd($CRUD, $COD, $PCOD, $DVS, $NAM, $STD, $UNT, $TAXCD, $STDCOST, $STDSALE, $RMK);

		echo json_encode($result->result_id);

	}
	
	public function gridtest()
	{
		$this->load->view('manage/gridtest2', array());
	}
}
