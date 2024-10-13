<?php
// custom core
require_once APPPATH.'core/Controller_custom.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class Point extends Controller {
	function __construct() {
		parent::__construct();

		$this->db = $this->load->database('default', true);
		$this->load->model('Point_model');
	}

	public function index()
	{
		//
	}

	public function payRequest()
	{

		// // epunch nicepay 
		// $merchantKey = 'CvUHl3UUVEKDlyvD2NaZfO56hD+3XH99wjPcZfq3G6OGVSajO+JejFqfjvPC6edsX+eHf2Zh4qhMjpVlkQ7ZgA==';
		// $MID = 'kiconsultm';
		// $goodsName   = "ePunch 포인트충전"; // 결제상품명
		// $price       = "100"; // 결제상품금액
		// $buyerName = $this->login->UNM;
		// $returnURL = '';
		// $buyerTel	 = "01000000000"; // 구매자연락처
		// $buyerEmail  = "happy@day.co.kr"; // 구매자메일주소        
		// $moid        = "mnoid1234567890"; // 상품주문번호
		// $returnURL	 = "http://localhost:8080/payResult.php"; // 결과페이지(절대경로) - 모바일 결제창 전용

		// /*
		// *******************************************************
		// * <해쉬암호화> (수정하지 마세요)
		// * SHA-256 해쉬암호화는 거래 위변조를 막기위한 방법입니다. 
		// *******************************************************
		// */ 
		// $ediDate = date("YmdHis");
		// $hashString = bin2hex(hash('sha256', $ediDate.$MID.$price.$merchantKey, true));

		// test
		$data['merchantKey'] = "EYzu8jGGMfqaDEp76gSckuvnaHHu+bC4opsSN6lHv3b2lurNYkVXrZ7Z1AoqQnXI3eLuaUFyoRNC6FkrzVjceg=="; // 상점키
		$data['MID']         = "nicepay00m"; // 상점아이디
		$data['goodsName']   = "ePunch 포인트충전"; // 결제상품명
		$data['price']       = (int) $this->input->post('amt'); // 결제상품금액
		$data['buyerName']   = $this->login->UNM; // 구매자명 
		$data['buyerTel']	 = $this->login->UTEL; // 구매자연락처
		$data['buyerEmail']  = $this->login->EML; // 구매자메일주소        
		$data['moid']        = "11111"; // 상품주문번호                     
		$data['returnURL']	 = "http://localhost:8080/payResult.php"; // 결과페이지(절대경로) - 모바일 결제창 전용

		/*
		*******************************************************
		* <해쉬암호화> (수정하지 마세요)
		* SHA-256 해쉬암호화는 거래 위변조를 막기위한 방법입니다. 
		*******************************************************
		*/ 
		$data['ediDate'] 	= date("YmdHis");
		$data['hashString'] = bin2hex(hash('sha256', $data['ediDate'].$data['MID'].$data['price'].$data['merchantKey'], true));

		$this->load->view('point/payrequest', $data);
	}

	public function payResult()
	{
		/*
		****************************************************************************************
		* <인증 결과 파라미터>
		****************************************************************************************
		*/
		$authResultCode = $_POST['AuthResultCode'];		// 인증결과 : 0000(성공)
		$authResultMsg = $_POST['AuthResultMsg'];		// 인증결과 메시지
		$nextAppURL = $_POST['NextAppURL'];				// 승인 요청 URL
		$txTid = $_POST['TxTid'];						// 거래 ID
		$authToken = $_POST['AuthToken'];				// 인증 TOKEN
		$payMethod = $_POST['PayMethod'];				// 결제수단
		$mid = $_POST['MID'];							// 상점 아이디
		$moid = $_POST['Moid'];							// 상점 주문번호
		$amt = $_POST['Amt'];							// 결제 금액
		$reqReserved = $_POST['ReqReserved'];			// 상점 예약필드
		$netCancelURL = $_POST['NetCancelURL'];			// 망취소 요청 URL
		//$authSignature = $_POST['Signature'];			// Nicepay에서 내려준 응답값의 무결성 검증 Data

		/*  
		****************************************************************************************
		* Signature : 요청 데이터에 대한 무결성 검증을 위해 전달하는 파라미터로 허위 결제 요청 등 결제 및 보안 관련 이슈가 발생할 만한 요소를 방지하기 위해 연동 시 사용하시기 바라며 
		* 위변조 검증 미사용으로 인해 발생하는 이슈는 당사의 책임이 없음 참고하시기 바랍니다.
		****************************************************************************************
		 */
		$merchantKey = 'EYzu8jGGMfqaDEp76gSckuvnaHHu+bC4opsSN6lHv3b2lurNYkVXrZ7Z1AoqQnXI3eLuaUFyoRNC6FkrzVjceg=='; // 상점키

		// 인증 응답 Signature = hex(sha256(AuthToken + MID + Amt + MerchantKey)
		$authComparisonSignature = bin2hex(hash('sha256', $authToken. $mid. $amt. $merchantKey, true)); 

		/*
		****************************************************************************************
		* <승인 결과 파라미터 정의>
		* 샘플페이지에서는 승인 결과 파라미터 중 일부만 예시되어 있으며, 
		* 추가적으로 사용하실 파라미터는 연동메뉴얼을 참고하세요.
		****************************************************************************************
		*/

		$response = "";

		// 인증 응답으로 받은 Signature 검증을 통해 무결성 검증을 진행하여야 합니다.
		if($authResultCode === "0000" /* && $authSignature == $authComparisonSignature*/){
			/*
			****************************************************************************************
			* <해쉬암호화> (수정하지 마세요)
			* SHA-256 해쉬암호화는 거래 위변조를 막기위한 방법입니다. 
			****************************************************************************************
			*/	
			$ediDate = date("YmdHis");
			$signData = bin2hex(hash('sha256', $authToken . $mid . $amt . $ediDate . $merchantKey, true));

			try{
				$data = Array(
					'TID' => $txTid,
					'AuthToken' => $authToken,
					'MID' => $mid,
					'Amt' => $amt,
					'EdiDate' => $ediDate,
					'SignData' => $signData,
					'CharSet' => 'utf-8'
				);		
				$response = $this->reqPost($data, $nextAppURL); //승인 호출
				// $this->jsonRespDump($response); //response json dump example

				// 결제 성공 후 포인트 적립 처리하기
				$response_json = json_decode($response);
				$pay_result_code = $response_json->ResultCode;
				$pay_point = (int) $response_json->Amt;
				$pp_result = $this->setPayPoint($pay_result_code, $pay_point);
				echo "결제 요청을 처리중입니다.
				<script>
					opener.parent.niceResult('{$pay_point}', '{$pp_result->BALPNT}');
					self.close();
				</script>";

			}catch(Exception $e){
				$e->getMessage();
				$data = Array(
					'TID' => $txTid,
					'AuthToken' => $authToken,
					'MID' => $mid,
					'Amt' => $amt,
					'EdiDate' => $ediDate,
					'SignData' => $signData,
					'NetCancel' => '1',
					'CharSet' => 'utf-8'
				);
				$response = $this->reqPost($data, $netCancelURL); //예외 발생시 망취소 진행
				
				$this->jsonRespDump($response); //response json dump example
			}


			//  test 결과 예시
			// ResultCode=3001
			// ResultMsg=카드 결제 성공
			// MsgSource=PG
			// Amt=000000000300
			// MID=nicepay00m
			// Moid=11111
			// BuyerEmail=hwang0619@naver.com
			// BuyerTel=
			// BuyerName=이민정
			// GoodsName=ePunch 포인트충전
			// TID=nicepay00m01012404211150513090
			// AuthCode=29823847
			// AuthDate=240421115052
			// PayMethod=CARD
			// CartData=
			// Signature=4cf660cfacff80a56d9716cca32feb15a939341a1943e5797ce2161e8f5b4c39
			// MallReserved=
			// CardCode=06
			// CardName=신한
			// CardNo=94106186****3120
			// CardQuota=00
			// CardInterest=0
			// AcquCardCode=06
			// AcquCardName=신한
			// CardCl=0
			// CcPartCl=1
			// CouponAmt=000000000000
			// CouponMinAmt=000000000000
			// PointAppAmt=000000000000
			// ClickpayCl=
			// MultiCl=
			// MultiCardAcquAmt=
			// MultiPointAmt=
			// MultiCouponAmt=
			// MultiDiscountAmt=
			// RcptType=
			// RcptTID=
			// RcptAuthCode=
			// CardType=01
			// ApproveCardQuota=00
			// PointCl=0
			
		}else /*if($authComparisonSignature == $authSignature)*/{
			//인증 실패 하는 경우 결과코드, 메시지
			$ResultCode = $authResultCode; 	
			$ResultMsg = $authResultMsg;
		}/*else{
			echo('인증 응답 Signature : '. $authSignature.'</br');
			echo('인증 생성 Signature : '. $authComparisonSignature);
		}*/
	}

	public function getPayData()
	{
		if (!$pay_amount = $this->input->post('pay_amount')) die('parameter error');
		// test 하기위해 금액 1/100
		$pay_amount = (int) $pay_amount / 100;

		$merchantKey = "EYzu8jGGMfqaDEp76gSckuvnaHHu+bC4opsSN6lHv3b2lurNYkVXrZ7Z1AoqQnXI3eLuaUFyoRNC6FkrzVjceg=="; // 상점키
		$MID         = "nicepay00m"; // 상점아이디
		$goodsName   = "ePunch 포인트충전"; // 결제상품명
		$price       = $pay_amount; // 결제상품금액
		$buyerName   = $this->login->UNM; // 구매자명 
		$buyerTel	 = $this->login->UTEL; // 구매자연락처
		$buyerEmail  = $this->login->EML; // 구매자메일주소        
		$moid        = time(); // 상품주문번호                     
		$returnURL	 = "http://localhost:8080/payResult.php"; // 결과페이지(절대경로) - 모바일 결제창 전용

		/*
		*******************************************************
		* <해쉬암호화> (수정하지 마세요)
		* SHA-256 해쉬암호화는 거래 위변조를 막기위한 방법입니다. 
		*******************************************************
		*/ 
		$ediDate 	= date("YmdHis");
		$hashString = bin2hex(hash('sha256', $ediDate.$MID.$price.$merchantKey, true));

		$return = array();
		$return['price'] = $price;
		$return['hashString'] = $hashString;
		$return['ediData'] = $ediDate;

		echo json_encode($return);
	}

	//Post api call
	private function reqPost(Array $data, $url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);					//connection timeout 15 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));	//POST data
		curl_setopt($ch, CURLOPT_POST, true);
		$response = curl_exec($ch);
		curl_close($ch);	 
		return $response;
	}

	// API CALL foreach 예시
	private function jsonRespDump($resp){
		//global $mid, $merchantKey;
		$respArr = json_decode($resp);
		foreach ( $respArr as $key => $value ){
			/*if($key == "Amt" || $key == "CancelAmt"){
				$payAmt = $value;
			}
			*if($key == "TID"){
				$tid = $value;
			}
			// 승인 응답으로 받은 Signature 검증을 통해 무결성 검증을 진행하여야 합니다.
			if($key == "Signature"){
				$paySignature = bin2hex(hash('sha256', $tid. $mid. $payAmt. $merchantKey, true));
				if($value != $paySignature){
					echo '비정상 거래! 취소 요청이 필요합니다.</br>';
					echo '승인 응답 Signature : '. $value. '</br>';
					echo '승인 생성 Signature : '. $paySignature. '</br>';
				}
			}*/
			echo "$key=". $value."<br />";
		}
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
	}

	public function gridPointGetData()
	{
		$SDTS = $this->input->post('sdts');
		$EDTS = $this->input->post('edts');
		$COD = $this->login->COD;

		$result = $this->Point_model->getPointGetData($COD, $SDTS, $EDTS);
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}

	public function gridPointUseData()
	{
		$SDTS = $this->input->post('sdts');
		$EDTS = $this->input->post('edts');
		$COD = $this->login->COD;

		$result = $this->Point_model->getPointUseData($COD, $SDTS, $EDTS);
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
	}

}
