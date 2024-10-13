<?php
// custom core
require_once APPPATH.'core/Controller_custom.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class Tran extends Controller {
	function __construct() {
		parent::__construct();

		defined('INC_JS_URL') OR define('INC_JS_URL', '/include/js/');
		
		$this->db = $this->load->database('default', true);
		$this->load->model('Tran_model');
		$this->load->model('Point_model');
	}

	public function index()
	{
		if (!file_exists(APPPATH.'views/tran/tran.php')) {
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
		$DVS = '';

		$data['page_title'] = '전자세금계산서 입력';
		$data['COD'] = $COD;
		$data['YM'] = $data['Y'].$data['M'];
		$data['YMF'] = $data['Y'].'-'.$data['M'];
		$data['DVS'] = $DVS;

		$this->load->view('templates/header', $data);
		$this->load->view('tran/tran', $data);

		// 거래처 선택, 등록 modal
		$this->load->view('modal/modal_cmpy', $data);
		// 세금계산서 건별발행
		$this->load->view('modal/modal_etax', $data);
		// 포인트 관리
		$this->load->view('modal/modal_point', $data);

		
		$this->load->view('templates/footer', $data);
	}

	public function gridTranData()
	{
		$COD = $this->input->post('COD');
		$YM = $this->input->post('YM');
		$D = $this->input->post('D');
		$DTS = $YM.$D;
		$data = $this->Tran_model->getTranData($COD, $DTS);
		echo json_encode($data);
	}

	// 매입매출 data insert/update
	public function updateTranData()
	{

		$CRUD = $this->input->post('CRUD');
		$COD = $this->input->post('COD');
		$DVS = $this->input->post('DVS');
		$DTS = $this->input->post('DTS');
		$TNO = $this->input->post('TNO');
		$TYP = $this->input->post('TYP');
		$GBN = $this->input->post('GBN');
		$CDS = $this->input->post('CDS');
		$NET = $this->input->post('NET') ? $this->input->post('NET') : '0';
		$VAT = $this->input->post('VAT') ? $this->input->post('VAT') : '0';


		$result = $this->Tran_model->updateTranData($CRUD, $COD, $DVS, $DTS, $TNO, $TYP, $GBN, $CDS, $NET, $VAT);
		// echo json_encode($result->result_id);
		echo json_encode($result[0]);
	}

	public function gridEtaxData()
	{
		$COD = $this->input->post('COD');
		$TNO = $this->input->post('TNO');
		$data = $this->Tran_model->getEtaxData($COD, $TNO);
		echo json_encode($data);
	}

	public function testresut()
	{
		$Amt = 100;
		$pp_result = $this->setPayPoint('T0001', $Amt);
		echo "
		결제 요청을 처리중입니다.
		<script>
			opener.parent.testResult('{$Amt}', '{$pp_result->BALPNT}');
			self.close();
		</script>
		";
	}
	
	// 결제 후 포인트 세팅
	private function setPayPoint($pay_result_code, $pay_amount)
	{
		// $pay_amount = $this->input->post('pay_amount');
		// $point_amount = $this->input->post('point_amount');

		$PAYAMT = $pay_amount;
		
		$COD = $this->login->COD;
		$UID = $this->login->UID;
		$BALPNT = $this->login->BALPNT;
		$PAYAMT = str_replace(',', '', $pay_amount);

		$result = $this->Point_model->setPayPoint($COD, $UID, $PAYAMT);
		if ($result->result_id) {
			$response = new StdClass();
			$response->result = true;
			$response->BALPNT = (int) $BALPNT + (int) $PAYAMT;
		}

		return $response;
		// echo json_encode($response);
	}
}
