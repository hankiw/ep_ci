
<div id="modal-POINT" class="modal">
	<div class="modal-background"></div>
	<div class="modal-card" style="width:67%;min-width:640px;">
		<header class="modal-card-head">
			<p class="modal-card-title">내 포인트 관리</p>
			<button class="delete" aria-label="close" onclick="closeModal('modal-POINT');"></button>
		</header>
		<section class="modal-card-body">
			<div class="tabs is-toggle is-small">
				<ul id="modal-POINT-tab">
					<li data-mode="charge" class="is-active"><a>포인트 충전</a></li>
					<li data-mode="list_charge"><a>충전내역 조회</a></li>
					<li data-mode="list_use"><a>사용내역 조회</a></li>
				</ul>
			</div>
			<div id="modal-POINT-cont">
				<div style="height:630px;">
					<div class="notification">
						포인트 충전 후 세금계산서 발행 서비스 이용이 가능합니다.<br/>
						포인트 충전 시 환산금액은 1 원 = 1 Point 입니다.<br/><br/>
						충전시 오류관리<br/>
						<ul>
							<li>신용카드(해외카드 제외) : 1688-7001</li>
							<li>무통장입금(가상계좌) : 1544-8660 KCP</li>
							<li>휴대폰결제 : 1566-3555(다날)</li>
						</ul>
					</div>
					<div class="notification is-info">
						<span class="tag is-primary is-medium"><?=$this->login->CNAM?></span>&nbsp;님의 잔여포인트는 <span id="c_balpnt"><?=number_format($this->login->BALPNT)?></span> Point 입니다.
					</div>
					<div class="box">
						<div class="columns">
							<div class="column is-one-quarter">
								<label class="radio"><input type="radio" name="point" value="10000" onclick="setPayValue(this);" checked>&nbsp;10,000원</label>
							</div>
							<div class="column is-one-quarter">
								<label class="radio"><input type="radio" name="point" value="20000" onclick="setPayValue(this);">&nbsp;20,000원</label>
							</div>
							<div class="column is-one-quarter">
								<label class="radio"><input type="radio" name="point" value="30000" onclick="setPayValue(this);">&nbsp;30,000원</label>
							</div>
							<div class="column is-one-quarter">
								<label class="radio"><input type="radio" name="point" value="50000" onclick="setPayValue(this);">&nbsp;50,000원</label>
							</div>
						</div>
						<div class="columns">
							<div class="column is-one-quarter">
								<label class="radio"><input type="radio" name="point" value="100000" onclick="setPayValue(this);">&nbsp;100,000원</label>
							</div>
							<div class="column is-one-quarter">
								<label class="radio"><input type="radio" name="point" value="200000" onclick="setPayValue(this);">&nbsp;200,000원</label>
							</div>
							<div class="column is-one-quarter">
								<label class="radio"><input type="radio" name="point" value="300000" onclick="setPayValue(this);">&nbsp;300,000원</label>
							</div>
							<div class="column is-one-quarter">
								<label class="radio"><input type="radio" name="point" value="500000" onclick="setPayValue(this);">&nbsp;500,000원</label>
							</div>
						</div>
						<div class="notification">
							<div class="field is-horizontal">
								총 구입가격&nbsp;&nbsp;
								<div class="control">
									<input type="hidden" id="p_pay_amount" value="10000">
									<input type="text" class="input is-small has-text-right" value="10,000" id="set_pay_amount" readonly>
								</div>
								&nbsp;&nbsp;원 (VAT별도)
							</div>
							<div class="field is-horizontal">
								적립 포인트&nbsp;&nbsp;
								<div class="control"><input type="text" class="input is-small has-text-right" value="10,000" id="set_point_amount" readonly></div>
								&nbsp;&nbsp;POINT
							</div>
						</div>
						<div class="buttons are-small is-centered">
							<button class="button is-success" onclick="payPoint();">결제하기</button>
							<button class="button" onclick="closeModal('modal-POINT');">취소</button>
						</div>
					</div>
				</div>
				<div style="height:630px;display:none;">
					<div class="level-right pb-2">
						<div class="field is-horizontal">
							<div class="field-label is-small">
								<label class="label">검색기간</label>
							</div>
							<div class="field-body">
								<div class="field">
									<p class="control has-icons-left">
										<input class="input is-small" size="6" type="month" onchange="getPointGetData();" id="get_YM_start">
									</p>
								</div>
								<div class="field">
									<p class="control has-icons-left">
										<input class="input is-small" size="6" type="month" onchange="getPointGetData();" id="get_YM_end">
									</p>
								</div>
							</div>
						</div>
					</div>
					<div id="pointget_grid" class="mb-1" style="width:100%;height:578px;"></div>
				</div>
				<div style="height:630px;display:none;">
					<div class="level-right pb-2">
						<div class="field is-horizontal">
							<div class="field-label is-small">
								<label class="label">검색기간</label>
							</div>
							<div class="field-body">
								<div class="field">
									<p class="control has-icons-left">
										<input class="input is-small" size="6" type="month" onchange="getPointUseData();" id="use_YM_start">
									</p>
								</div>
								<div class="field">
									<p class="control has-icons-left">
										<input class="input is-small" size="6" type="month" onchange="getPointUseData();" id="use_YM_end">
									</p>
								</div>
							</div>
						</div>
					</div>
					<div id="pointuse_grid" class="mb-1" style="width:100%;height:578px;"></div>
				</div>
			</div>
		</section>
	</div>
</div>

<?php
// test
$merchantKey = "EYzu8jGGMfqaDEp76gSckuvnaHHu+bC4opsSN6lHv3b2lurNYkVXrZ7Z1AoqQnXI3eLuaUFyoRNC6FkrzVjceg=="; // 상점키
$MID         = "nicepay00m"; // 상점아이디
$goodsName   = "ePunch 포인트충전"; // 결제상품명
$price       = "100"; // 결제상품금액
$buyerName   = $this->login->UNM; // 구매자명 
$buyerTel	 = $this->login->UTEL; // 구매자연락처
$buyerEmail  = $this->login->EML; // 구매자메일주소        
$moid        = "11111"; // 상품주문번호                     
$returnURL	 = "http://localhost:8080/payResult.php"; // 결과페이지(절대경로) - 모바일 결제창 전용

// /*
// *******************************************************
// * <해쉬암호화> (수정하지 마세요)
// * SHA-256 해쉬암호화는 거래 위변조를 막기위한 방법입니다. 
// *******************************************************
// */ 
// $ediDate 	= date("YmdHis");
// $hashString = bin2hex(hash('sha256', $ediDate.$MID.$price.$merchantKey, true));

?>

<form name="payForm" method="post" action="/point/payResult" target="result_popup">
	<input type="hidden" name="Amt" value="<?=$price?>">
	<input type="hidden" name="PayMethod" value="">
	<input type="hidden" name="GoodsName" value="<?php echo($goodsName)?>">
	<input type="hidden" name="MID" value="<?php echo($MID)?>">
	<input type="hidden" name="Moid" value="<?php echo($moid)?>">
	<input type="hidden" name="BuyerName" value="<?php echo($buyerName)?>">
	<input type="hidden" name="BuyerEmail" value="<?php echo($buyerEmail)?>">
	<input type="hidden" name="BuyerTel" value="<?php echo($buyerTel)?>">
	<input type="hidden" name="ReturnURL" value="<?php echo($returnURL)?>">
	<input type="hidden" name="VbankExpDate" value="">
	<!-- 옵션 -->	 
	<input type="hidden" name="GoodsCl" value="0"/>						<!-- 상품구분(실물(1),컨텐츠(0)) -->
	<input type="hidden" name="TransType" value="0"/>					<!-- 일반(0)/에스크로(1) --> 
	<input type="hidden" name="CharSet" value="utf-8"/>				<!-- 응답 파라미터 인코딩 방식 -->
	<input type="hidden" name="ReqReserved" value=""/>					<!-- 상점 예약필드 -->

	<!-- 금액 변경 시 변경위해 결제요청시 ajax로 값 받아와서 세팅됨 -->
	<input type="hidden" name="EdiDate" value=""/>
	<input type="hidden" name="SignData" value=""/>

	<!-- 변경 불가능 -->
	<!-- 전문 생성일시 -->
	<!-- <input type="hidden" name="EdiDate" value="<?php echo($ediDate)?>"/> -->
	<!-- 해쉬값 -->
	<!-- <input type="hidden" name="SignData" value="<?php echo($hashString)?>"/> -->
	<!-- <a href="#" class="btn_blue" onClick="nicepayStart();">요 청</a> -->
</form>

<script src="https://pg-web.nicepay.co.kr/v3/common/js/nicepay-pgweb.js" type="text/javascript"></script>
<script type="text/javascript">
	
	//결제창 최초 요청시 실행됩니다.
	function nicepayStart(){
		goPay(document.payForm);
	}

	//[PC 결제창 전용]결제 최종 요청시 실행됩니다. <<'nicepaySubmit()' 이름 수정 불가능>>
	function nicepaySubmit(){
		window.open('about:blank', 'result_popup', 'width=100,height=100');
		document.payForm.submit();
	}

	//[PC 결제창 전용]결제창 종료 함수 <<'nicepayClose()' 이름 수정 불가능>>
	function nicepayClose(){
		alert("결제가 취소 되었습니다");
	}

	// 결제완료, 포인트 충전 완료 후 처리부
	function niceResult(amt, BALPNT) {
		// set_pay_amount
		console.log(amt, BALPNT);
		document.getElementById('nice_layer').remove();
		document.getElementById('bg_layer').remove();

		alert(amt + ' 포인트를 충전했습니다.');
		document.getElementById('u_balpnt').innerHTML = numberFormat(BALPNT);
		document.getElementById('c_balpnt').innerHTML = numberFormat(BALPNT);
		closeModal('modal-POINT');
		// nicepayClose();
	}
</script>
<script>

	function initPointModal() {
		$('#modal-POINT-tab li').eq(0).addClass('is-active').siblings('li').removeClass('is-active');
		$('#modal-POINT-cont').children('div').hide().eq(0).show();
		$('input[name=point]').each(function() {
			if ($(this).val() == '10000') $(this).prop('checked', true);
			else $(this).prop('checked', false);
		});
		document.getElementById('set_pay_amount').value = '10,000';
		document.getElementById('set_point_amount').value = '10,000';
	}

	$('#modal-POINT-tab li').click(function() {
		$(this).addClass('is-active').siblings('li').removeClass('is-active');
		$('#modal-POINT-cont').children('div').hide().eq($(this).index()).show();
		// setPointTab($(this).data('mode'));
	});

	function setPayValue(obj) {
		document.getElementById('p_pay_amount').value = obj.value;
		document.getElementById('set_pay_amount').value = numberFormat(obj.value);
		document.getElementById('set_point_amount').value = numberFormat(obj.value);
		// document.payForm.amt.value = Number(obj.value) / 100;
	}

	function payPoint() {
		let payAmount = document.getElementById('p_pay_amount').value;

		$.ajax({
			url: '/point/getPayData',
			type: 'post',
			dataType: 'json',
			data: {
				pay_amount: payAmount
			},
		})
		.done(function(res) {
			console.log(res);
			document.payForm.Amt.value = res.price;
			document.payForm.SignData.value = res.hashString;
			document.payForm.EdiDate.value = res.ediData;
			nicepayStart();
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	}

	document.addEventListener('DOMContentLoaded', function() {
		let datetime = new Date();
		let schEnd = datetime.getFullYear() + '-' + (datetime.getMonth() + 1);
		datetime.setYear(Number(datetime.getFullYear()) - 1);
		let schStart = datetime.getFullYear() + '-' + (datetime.getMonth() + 1);

		document.getElementById('get_YM_start').value = schStart;
		document.getElementById('use_YM_start').value = schStart;
		document.getElementById('get_YM_end').value = schEnd;
		document.getElementById('use_YM_end').value = schEnd;

		providerPOINTGET = new RealGrid.LocalDataProvider();
		gridViewPOINTGET = new RealGrid.GridView('pointget_grid');
		gridViewPOINTGET.setDataSource(providerPOINTGET);

		gridViewPOINTGET.displayOptions.rowHeight = 30;
		gridViewPOINTGET.displayOptions.selectionMode = "none";
		gridViewPOINTGET.displayOptions.selectionStyle = "singleRow";
		gridViewPOINTGET.header.height = 36;
		// 단순조회물, 풋터는 표시하지 않는다.
		gridViewPOINTGET.setFooters({visible: false});
		gridViewPOINTGET.setCheckBar({
			visible: false
		});

		providerPOINTGET.setFields([
			{fieldName: 'SEQ'}
			, {fieldName: 'DTS'}
			, {fieldName: 'PAYMTD'}
			, {fieldName: 'PAYAMT', dataType: 'number'}
			, {fieldName: 'GETPNT', dataType: 'number'}
			, {fieldName: 'PAYSTAT'}
			, {fieldName: 'BNO'}
			, {fieldName: 'BILLS'}
		]);

		gridViewPOINTGET.setColumns([
			{
				name: 'DTS'
				, fieldName: 'DTS'
				, width: 75
				, editable: false
				, header: {text: '승인일자'}
			}
			, {
				name: 'PAYMTD'
				, fieldName: 'PAYMTD'
				, width: 60
				, editable: false
				, header: {text: '결제방법'}
			}
			, {
				name: 'PAYAMT'
				, fieldName: 'PAYAMT'
				, width: 80
				, editable: false
				, styleName: 'align-right'
				, type: 'number'
				, numberFormat: '#,##0'
				, header: {text: '결제금액'}
			}
			, {
				name: 'GETPNT'
				, fieldName: 'GETPNT'
				, width: 80
				, editable: false
				, styleName: 'align-right'
				, type: 'number'
				, numberFormat: '#,##0'
				, header: {text: '충전포인트'}
			}
			, {
				name: 'PAYSTAT'
				, fieldName: 'PAYSTAT'
				, width: 60
				, editable: false
				, header: {text: '결제상태'}
			}
			, {
				name: 'BNO'
				, fieldName: 'BNO'
				, width: 70
				, editable: false
				, header: {text: '세금계산서'}
			}
			, {
				name: 'BILLS'
				, fieldName: 'BILLS'
				, width: 70
				, editable: false
				, header: {text: '영수증'}
			}
		]);

		providerPOINTUSE = new RealGrid.LocalDataProvider();
		gridViewPOINTUSE = new RealGrid.GridView('pointuse_grid');
		gridViewPOINTUSE.setDataSource(providerPOINTUSE);

		gridViewPOINTUSE.displayOptions.rowHeight = 30;
		gridViewPOINTUSE.displayOptions.selectionMode = "none";
		gridViewPOINTUSE.displayOptions.selectionStyle = "singleRow";
		gridViewPOINTUSE.header.height = 36;
		// 단순조회물, 풋터는 표시하지 않는다.
		gridViewPOINTUSE.setFooters({visible: false});
		gridViewPOINTUSE.setCheckBar({
			visible: false
		});

		providerPOINTUSE.setFields([
			{fieldName: 'DTS'}
			, {fieldName: 'DSCR'}
			, {fieldName: 'USEPNT', dataType: 'number'}
			, {fieldName: 'BALPNT', dataType: 'number'}
			, {fieldName: 'REFNO'}
		]);

		gridViewPOINTUSE.setColumns([
			{
				name: 'DTS'
				, fieldName: 'DTS'
				, width: 75
				, editable: false
				, header: {text: '사용일자'}
			}
			, {
				name: 'DSCR'
				, fieldName: 'DSCR'
				, width: 160
				, editable: false
				, header: {text: '사용내역'}
			}
			, {
				name: 'USEPNT'
				, fieldName: 'USEPNT'
				, width: 80
				, editable: false
				, styleName: 'align-right'
				, type: 'number'
				, numberFormat: '#,##0'
				, header: {text: '사용포인트'}
			}
			, {
				name: 'BALPNT'
				, fieldName: 'BALPNT'
				, width: 80
				, editable: false
				, styleName: 'align-right'
				, type: 'number'
				, numberFormat: '#,##0'
				, header: {text: '가용포인트'}
			}
			, {
				name: 'REFNO'
				, fieldName: 'REFNO'
				, width: 80
				, editable: false
				, header: {text: '발행번호'}
			}
		]);


		getPointGetData();
		getPointUseData();
	});

	function getPointGetData() {
		let schStart = document.getElementById('get_YM_start').value.replaceAll('-', '');
		let schEnd = document.getElementById('get_YM_end').value.replaceAll('-', '');
		$.ajax({
			url: '/point/gridPointGetData',
			type: 'post',
			dataType: 'json',
			data: {sdts: schStart, edts: schEnd},
		})
		.done(function(jsonData) {
			providerPOINTGET.fillJsonData(jsonData, {fillMode : 'set'});
			providerPOINTGET.addRow({});
			gridViewPOINTGET.commit(true);
			gridViewPOINTGET.closeLoading();
		})
		.always(function() {
			console.log('getPointGetData complete');
		});
	};

	function getPointUseData() {
		let schStart = document.getElementById('use_YM_start').value.replaceAll('-', '');
		let schEnd = document.getElementById('use_YM_end').value.replaceAll('-', '');
		$.ajax({
			url: '/point/gridPointUseData',
			type: 'post',
			dataType: 'json',
			data: {sdts: schStart, edts: schEnd},
		})
		.done(function(jsonData) {
			providerPOINTUSE.fillJsonData(jsonData, {fillMode : 'set'});
			providerPOINTUSE.addRow({});
			gridViewPOINTUSE.commit(true);
			gridViewPOINTUSE.closeLoading();
		})
		.always(function() {
			console.log('getPointUseData complete');
		});
	};

</script>