<?php
// custom core
require_once APPPATH.'core/Controller_custom.php';
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends Controller {
	function __construct() {
		parent::__construct();

		defined('INC_JS_URL') OR define('INC_JS_URL', '/include/js/');
		$this->load->model('Member_model');
	}


	public function gridUserData()
	{
		$COD = $this->session->userdata('UCOD');
		$SCH = $this->input->post('SCH');


		$data = $this->Member_model->getUserData($COD, $SCH);

		echo json_encode($data);
	}


	// 사용자관리 data insert/update/delete
	public function updateUserData()
	{

		$CRUD = $this->input->post('CRUD');

		$COD = $this->session->userdata('UCOD');

		$SEQ = $this->input->post('SEQ');
		$UID = $this->input->post('UID');
		$UPW = $this->input->post('UPW');
		$UNM = $this->input->post('UNM');
		$STDT = $this->input->post('STDT');
		$EDDT = $this->input->post('EDDT');
		
		$result = $this->Member_model->updateUserData($CRUD, $COD, $SEQ, $UID, $UPW, $UNM, $STDT, $EDDT);

		echo json_encode($result[0]);
	}



	public function index()
	{
		
		// 품목군 선택, 등록 modal
		$this->load->view('modal/modal_pg', $data);

	}


	public function gridCodsData()
	{
		$COD = $this->session->userdata('UCOD');
		$SCH = $this->input->post('SCH');

		
		$data = $this->Member_model->getCodsData($COD, $SCH);
		echo json_encode($data);
	}


	// 거래처관리 data insert/update/delete
	public function updateCodsData()
	{

		$CRUD = $this->input->post('CRUD');

		$COD = $this->session->userdata('UCOD');

		$CDS  = $this->input->post('CDS');
		$NAM  = $this->input->post('NAM');
		$SNO  = $this->input->post('SNO');
		$JNO  = $this->input->post('JNO');
		$OWN  = $this->input->post('OWN');
		$ZIP  = $this->input->post('ZIP');
		$ADR1 = $this->input->post('ADR1');
		$ADR2 = $this->input->post('ADR2');
		$TYP  = $this->input->post('TYP');
		$KND  = $this->input->post('KND');
		$MGR1 = $this->input->post('MGR1');
		$EML1 = $this->input->post('EML1');
		$MGR2 = $this->input->post('MGR2');
		$EML2 = $this->input->post('EML2');
		$SDT  = $this->input->post('SDT');
		$EDT  = $this->input->post('EDT');

		$result = $this->Member_model->updateCodsData($CRUD, $COD, $CDS , $NAM , $SNO , $JNO , $OWN , $ZIP , $ADR1, $ADR2, $TYP , $KND , $MGR1, $EML1, $MGR2, $EML2, $SDT , $EDT );
		// echo json_encode($result->result_id);
		echo json_encode($result[0]);
	}

	public function gridProdData()
	{
		$COD = $this->session->userdata('UCOD');
		$SCH = $this->input->post('SCH');

		$data = $this->Member_model->getProdData($COD, $SCH);
		echo json_encode($data);
	}


	// 품목관리 data insert/update/delete
	public function updateProdData()
	{

		$CRUD = $this->input->post('CRUD');

		$COD = $this->session->userdata('UCOD');

		$PCOD_SAVED = $this->input->post('PCOD_SAVED');
		$PCOD    	= $this->input->post('PCOD');
		$DVS     	= $this->input->post('DVS');
		$PGCD     	= $this->input->post('PGCD');
		$NAM     	= $this->input->post('NAM');
		$STD     	= $this->input->post('STD');
		$UNT	 	= $this->input->post('UNT'); 
		$TAXCD   	= $this->input->post('TAXCD');
		$STDCOST 	= $this->input->post('STDCOST');
		$STDSALE 	= $this->input->post('STDSALE');
		$RMK	 	= $this->input->post('RMK'); 

		$result = $this->Member_model->updateProdData($CRUD, $COD, $PCOD_SAVED, $PCOD, $DVS, $PGCD, $NAM, $STD, $UNT, $TAXCD, $STDCOST, $STDSALE, $RMK );
		//echo json_encode($result->result_id);
		echo json_encode($result[0]);

		
	}


	public function gridPgData()
	{
		$COD = $this->session->userdata('UCOD');
		$SCH = $this->input->post('SCH');

		$data = $this->Member_model->getPgData($COD, $SCH);
		echo json_encode($data);
	}


	public function gridSvcrqstData()
	{
		$SCH = $this->input->post('SCH');
		$RQST_STAT = $this->input->post('RQST_STAT');

		$data = $this->Member_model->getSvcrqstData($SCH, $RQST_STAT);
		echo json_encode($data);
	}


	public function gridStockData()
	{
		$COD = $this->session->userdata('UCOD');
		$SCH = $this->input->post('SCH');

		$data = $this->Member_model->getStockData($COD, $SCH);
		echo json_encode($data);
	}


	// 품목관리 data insert/update/delete
	public function updatePgData()
	{

		$CRUD = $this->input->post('CRUD');

		$COD = $this->session->userdata('UCOD');

		$PGCD_SAVED = $this->input->post('PGCD_SAVED');

		$PGCD     	= $this->input->post('PGCD');
		$PGNM     	= $this->input->post('PGNM');
		$SDT     	= $this->input->post('SDT');
		$EDT	 	= $this->input->post('EDT'); 

		$result = $this->Member_model->updatePgData($CRUD, $COD, $PGCD_SAVED, $PGCD, $PGNM, $SDT, $EDT );
		
		echo json_encode($result[0]);
	}


	// 서비스신청 data insert/update/delete
	public function updateSvcrqstData()
	{

		$SEQ 		= $this->input->post('SEQ');

		$RQST_STAT  = $this->input->post('RQST_STAT');
		$RQST_REMK  = $this->input->post('RQST_REMK');

		$result = $this->Member_model->updateSvcrqstData($SEQ, $RQST_STAT, $RQST_REMK);
		echo json_encode($result->result_id);
	}


	// 사용자관리
	public function userlist()
	{
		if (!file_exists(APPPATH.'views/member/userlist.php')) {
			show_404();
		}

		// $this->load->view('welcome_message');
		$data['page_title'] = '사용자관리';

		$this->load->view('templates/header', $data);
		$this->load->view('member/userlist', $data);
		$this->load->view('templates/footer', $data);
	}

	// 거래처관리
	public function codslist()
	{
		if (!file_exists(APPPATH.'views/member/codslist.php')) {
			show_404();
		}

		// $this->load->view('welcome_message');
		$data['page_title'] = '거래처관리';

		$this->load->view('templates/header', $data);
		$this->load->view('member/codslist', $data);
		$this->load->view('templates/footer', $data);
	}


	// 품목관리
	public function prodlist()
	{
		if (!file_exists(APPPATH.'views/member/prodlist.php')) {
			show_404();
		}

		$data['page_title'] = '품목관리';

		// 이 아래 부분이 gasan.gcda.co.kr/member/prodlist 주소 에서 불러오는 view 파일들

		$this->load->view('templates/header', $data);
		$this->load->view('member/prodlist', $data);
		$this->load->view('modal/modal_pg', $data);


		// 아래처럼 필요한 modal 의 view 파일 을 추가해서 , js 소스에서 openModal('모달dom 아이디') 로 열 수 있다.
		// $this->load->view('modal/modal_pg', $data);

		$this->load->view('templates/footer', $data);
	}

	// 품목군관리
	public function pglist()
	{
		if (!file_exists(APPPATH.'views/member/pglist.php')) {
			show_404();
		}

		$data['page_title'] = '품목군관리';

		// 이 아래 부분이 gasan.gcda.co.kr/member/prodlist 주소 에서 불러오는 view 파일들

		$this->load->view('templates/header', $data);
		$this->load->view('member/pglist', $data);


		// 아래처럼 필요한 modal 의 view 파일 을 추가해서 , js 소스에서 openModal('모달dom 아이디') 로 열 수 있다.
		// $this->load->view('modal/modal_pg', $data);

		$this->load->view('templates/footer', $data);
	}

	// 재고현황
	public function stocklist()
	{
		if (!file_exists(APPPATH.'views/member/stocklist.php')) {
			show_404();
		}

		$data['page_title'] = '현재고 조회';

		// 이 아래 부분이 gasan.gcda.co.kr/member/prodlist 주소 에서 불러오는 view 파일들

		$this->load->view('templates/header', $data);
		$this->load->view('member/stocklist', $data);


		// 아래처럼 필요한 modal 의 view 파일 을 추가해서 , js 소스에서 openModal('모달dom 아이디') 로 열 수 있다.
		// $this->load->view('modal/modal_pg', $data);

		$this->load->view('templates/footer', $data);
	}

	// 서비스신청 리스트
	public function svcrqstlist()
	{
		if (!file_exists(APPPATH.'views/member/svcrqstlist.php')) {
			show_404();
		}

		$data['page_title'] = '서비스신청관리';

		// 이 아래 부분이 gasan.gcda.co.kr/member/prodlist 주소 에서 불러오는 view 파일들

		$this->load->view('templates/header', $data);
		$this->load->view('member/svcrqstlist', $data);


		// 아래처럼 필요한 modal 의 view 파일 을 추가해서 , js 소스에서 openModal('모달dom 아이디') 로 열 수 있다.
		// $this->load->view('modal/modal_pg', $data);

		$this->load->view('templates/footer', $data);
	}

}

