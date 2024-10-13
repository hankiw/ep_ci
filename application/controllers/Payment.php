<?php
// custom core
require_once APPPATH.'core/Controller_custom.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends Controller {
	function __construct() {
		parent::__construct();

		defined('INC_JS_URL') OR define('INC_JS_URL', '/include/js/');
		
		$this->db = $this->load->database('default', true);
		$this->load->model('Payment_model');
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

	public function payin()
	{
		
		if (!file_exists(APPPATH.'views/payment/payment.php')) {
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

		$data['page_title'] = '수금입력';
		$data['COD'] = $COD;
		$data['YM'] = $data['Y'].$data['M'];
		$data['YMF'] = $data['Y'].'-'.$data['M'];
		$data['DVS'] = $DVS;

		$this->load->view('templates/header', $data);
		$this->load->view('payment/payment', $data);

		// 거래처 선택, 등록 modal
		$this->load->view('modal/modal_cmpy', $data);
		// 입금구분 선택, 등록 modal
		$this->load->view('modal/modal_pcds', $data);

		$this->load->view('templates/footer', $data);
	}

	public function payout()
	{
		if (!file_exists(APPPATH.'views/payment/payment.php')) {
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

		$data['page_title'] = '지급입력';
		$data['COD'] = $COD;
		$data['YM'] = $data['Y'].$data['M'];
		$data['YMF'] = $data['Y'].'-'.$data['M'];
		$data['DVS'] = $DVS;

		$this->load->view('templates/header', $data);
		$this->load->view('payment/payment', $data);

		// 거래처 선택, 등록 modal
		$this->load->view('modal/modal_cmpy', $data);
		// 입금구분 선택, 등록 modal
		$this->load->view('modal/modal_pcds', $data);

		$this->load->view('templates/footer', $data);
	}


	public function gridPaymentData()
	{
		$DVS = $this->input->post('DVS');
		$COD = $this->input->post('COD');
		$YM = $this->input->post('YM');
		$D = $this->input->post('D');
		$PDT = $YM.$D;
		$data = $this->Payment_model->getPaymentData($COD, $DVS, $PDT);
		echo json_encode($data);
	}

	function updatePaymentData()
	{
		$CRUD = $this->input->post('CRUD');
		$COD = $this->input->post('COD');
		$CDS = $this->input->post('CDS');
		$PDT = $this->input->post('PDT');
		$DVS = $this->input->post('DVS');
		$PNO = $this->input->post('PNO');
		$PAMT = $this->input->post('PAMT');
		$PCDS = $this->input->post('PCDS');
		$PRMK = $this->input->post('PRMK');

		// $no_dts = $this->Manage_model->getNoDTS($COD, $DVS, $NOS);
		$result = $this->Payment_model->updatePaymentData($CRUD, $COD, $CDS, $PDT, $DVS, $PNO, $PAMT, $PCDS, $PRMK);
		echo json_encode($result->result_id);
	}

	public function gridAccountData()
	{
		$COD = $this->input->post('COD');
		$CDS = $this->input->post('CDS');
		$PNO = $this->input->post('PNO');
		$data = $this->Payment_model->getAccountData($COD, $CDS, $PNO);
		echo json_encode($data);
	}

	public function updateAccountData()
	{
		$COD = $this->input->post('COD');
		$CDS = $this->input->post('CDS');
		$PNO = $this->input->post('PNO');
		$DVS = $this->input->post('DVS');
		$ENO = $this->input->post('ENO');
		$PAMT = $this->input->post('PAMT');
		$OAMT = $this->input->post('OAMT');
		$PRMK = $this->input->post('PRMK');

		$result = $this->Payment_model->updateAccountData($COD, $CDS, $PNO, $DVS, $ENO, $PAMT, $OAMT, $PRMK);
		echo json_encode($result->result_id);
	}

	// 입금구분 데이터 가져오기
	public function getPcds()
	{
		$COD = $this->input->post('COD');
		$SCH = isset($_POST['SCH']) ? $this->input->post('SCH') : '';
		$CDS = isset($_POST['CDS']) ? $this->input->post('CDS') : '';

		$pcds_cods = $this->Payment_model->getPcds($COD, $SCH, $CDS);
		echo json_encode($pcds_cods);
	}

	// 입금구분 코드 부여
	public function getNextPcdsCds()
	{
		$COD = $this->input->post('COD');
		$CDS = $this->Payment_model->getNextPcdsCds($COD);
		echo $CDS;
	}

	// 입금구분 insert
	public function saveCmpyCds2()
	{
		$COD = $this->input->post('COD');
		$CDS = $this->input->post('CDS');
		$NAM = $this->input->post('NAM');
		$SNO = $this->input->post('SNO');
		$JNO = $this->input->post('JNO');
		$OWN = $this->input->post('OWN');
		$ZIP = $this->input->post('ZIP');
		$ADR1 = $this->input->post('ADR1');
		$ADR2 = $this->input->post('ADR2');
		$TYP = $this->input->post('TYP');
		$KND = $this->input->post('KND');
		$MGR1 = $this->input->post('MGR1');
		$EML1 = $this->input->post('EML1');
		$MGR2 = $this->input->post('MGR2');
		$EML2 = $this->input->post('EML2');

		$tmp = $this->Payment_model->isCmpyCods2($COD, $CDS);
		if ($tmp) $CRUD = 'U';
		else $CRUD = 'C';

		$result = $this->Payment_model->saveCmpyCds2($CRUD, $COD, $CDS, $NAM, $SNO, $JNO, $OWN, $ZIP, $ADR1, $ADR2, $TYP, $KND, $MGR1, $EML1, $MGR2, $EML2);
		echo json_encode($result->result_id);
	}

}
