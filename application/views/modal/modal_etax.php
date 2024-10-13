<div id="modal-ETAX" class="modal">
	<div class="modal-background"></div>
	<div class="modal-card" style="min-width:70%;">
		<header class="modal-card-head">
			<p class="modal-card-title">세금계산서 발행</p>
			<button class="delete" aria-label="close" onclick="closeModal('modal-ETAX');"></button>
		</header>
		<section class="modal-card-body">
			<div id="etax_grid" class="mb-4" style="width:100%;height:300px;"></div>
			<script>
				var providerEtax, gridViewEtax;
				var COD = '<?=$COD?>';
				var YM = '<?=$YM?>';
				var DD = '<?=$DD?>';

				document.addEventListener('DOMContentLoaded', function() {
					providerEtax = new RealGrid.LocalDataProvider();
					gridViewEtax = new RealGrid.GridView('etax_grid');
					gridViewEtax.setDataSource(providerEtax);
					gridViewEtax.displayOptions.rowHeight = 30;
					gridViewEtax.header.height = 36;
					gridViewEtax.footer.height = 30;

					gridViewEtax.checkBar.useImages = true;
					
					gridViewEtax.setStateBar({
						visible: true,
						width:20,
					});


					gridViewEtax.setCheckBar({
						visible: true,
						showAll: true,
						width: 40,
					});

					providerEtax.setFields([
						{fieldName: 'COD'}
						, {fieldName: 'DVS'}
						, {fieldName: 'DTS'}
						, {fieldName: 'DTS_YY'}
						, {fieldName: 'DTS_MM'}
						, {fieldName: 'DTS_DD'}
						, {fieldName: 'TNO'}
						, {fieldName: 'TYP'}
						, {fieldName: 'GBN'}
						, {fieldName: 'CDS'}
						, {fieldName: 'NAM'}
						, {fieldName: 'EITM'}
						, {fieldName: 'QTY'}
						, {fieldName: 'PRC'}
						, {fieldName: 'RMK'}
						, {fieldName: 'NET', dataType: 'number'}
						, {fieldName: 'VAT', dataType: 'number'}
						, {fieldName: 'MDFYCD'}
						, {fieldName: 'EDIV'}
						, {fieldName: 'GRS'}
						, {fieldName: 'SRC'}
						, {fieldName: 'EBL'}
						, {fieldName: 'ENO'}
						, {fieldName: 'EDTS'}
						, {fieldName: 'EEML'}
						, {fieldName: 'ATNO'}
					]);

					// 필수값 DVS && DTSDD && TYP && GBN && CDS && NET && VAT

					let etaxColumns = [
						{name: 'TNO', fieldName: 'TNO', editable: false, width: 100, header: {text: 'TNO'}}
						, {name: 'DTS_YY', fieldName: 'DTS_YY', editable: false, width: 60, header: {text: '년'}}
						, {name: 'DTS_MM', fieldName: 'DTS_MM', editable: false, width: 30, header: {text: '월'}}
						, {name: 'DTS_DD', fieldName: 'DTS_DD', editable: false, width: 30, header: {text: '일'}}
						, {
							name: 'TYP'
							, fieldName: 'TYP'
							, editable: false
							, width: 50
							, header: {text: '유형'}
							, values: ['1']
							, labels: ['과세']
						}
						, {name: 'COD', fieldName: 'COD', editable: false, width: 50, header: {text: '코드'}}
						, {name: 'NAM', fieldName: 'NAM', editable: false, width: 100, header: {text: '거래처'}}
						// , {name: 'NET', fieldName: 'NET', editable: false, width: 90, header: {text: '공급가액'}}
						// , {name: 'VAT', fieldName: 'VAT', editable: false, width: 70, header: {text: '세액'}}
						, {
							name: 'NET'
							, fieldName: 'NET'
							, editable: false
							, width: 90
							, header: {text: '공급가액'}
							, styleName: 'align-right'
							, numberFormat: '#,##0'
							,  editor: {
								type: "number",
								textAlignment: "far",
								editFormat: "#,##0",
								multipleChar: "+",
							}
						}
						, {
							name: 'VAT'
							, fieldName: 'VAT'
							, editable: false
							, width: 70
							, header: {text: '세액'}
							, styleName: 'align-right'
							, numberFormat: '#,##0'
							,  editor: {
								type: "number",
								textAlignment: "far",
								editFormat: "#,##0",
								multipleChar: "+",
							}
						}
						, {
							name: 'MDFYCD'
							, fieldName: 'MDFYCD'
							, editable: false
							, width: 50
							, header: {text: '수정'}
							, values: ['', '1']
							, labels: ['', '수정']
						}
						, {
							name: 'EDIV'
							, fieldName: 'EDIV'
							, editable: false
							, width: 50
							, header: {text: '구분'}
							, values: ['1', '2']
							, labels: ['청구', '영수']
						}
						, {name: 'EEML', fieldName: 'EEML', editable: false, width: 100, header: {text: '이메일'}}
						, {name: 'EDTS', fieldName: 'EDTS', editable: false, width: 80, header: {text: '발행(취소)일자'}}
						, {name: 'ATNO', fieldName: 'ATNO', editable: false, width: 100, header: {text: '첨부파일'}}
					];

					
					gridViewEtax.setColumns(etaxColumns);
				});

			</script>

			<div class="notification is-info">
				<div class="level">
					<div class="level-left">
						<span class="tag is-primary is-medium"><?=$this->login->CNAM?></span>&nbsp;님의 잔여포인트는&nbsp;<span id="u_balpnt"><?=number_format($this->login->BALPNT)?></span>&nbsp;Point 입니다.
					</div>
					<div class="level-right">
						<button type="button" class="button is-warning is-small" onclick="openPointModal();">내 포인트 관리</button>
					</div>
				</div>
			</div>
			
		</section>
		<footer class="modal-card-foot">
			<div class="buttons are-small is-centered">
				<button class="button is-success" onclick="return makeEtax();">발행</button>
				<!-- <button class="button is-danger" onclick="">삭제</button> -->
				<button class="button" onclick="closeModal('modal-ETAX');">취소</button>
			</div>
		</footer>
	</div>
</div>
<script>
	// 세금계산서발행
	function makeEtax() {
		// 필수입력
		var checkedRows = gridViewEtax.getCheckedRows();
		var checkedData = [];

		for(var i = 0; i < checkedRows.length; i++){
		    checkedData.push(providerEtax.getJsonRow(checkedRows[i]));
		}

		if (checkedData.length < 1) {
			alert('발행 대상을 선택해 주세요.');
			return false;
		}

		$.ajax({
			url: '/etax/makeEtaxCheck',
			type: 'post',
			dataType: 'json',
			data: {
				request: checkedData
				// 공통 사용 변수
				, COD: COD
				, DVS: DVS
			},
		})
		.done(function(res) {
			if (res.result) {
				makeEtaxRun(checkedData);
			} else {
				alert(res.msg);
			}
		})
		.always(function() {
			console.log("complete");
		});
		

		
		// $.ajax({
		// 	url: '/etax/makeEtaxRun/',
		// 	type: 'post',
		// 	// dataType: 'json',
		// 	data: {
		// 		request: checkedData

		// 		// 공통 사용 변수
		// 		, COD: COD
		// 		, DVS: DVS
		// 	},
		// })
		// .done(function(res) {
		// 	console.log(res);

		// 	// if (!res.result) {
		// 	// 	alert(res.msg);
		// 	// }

		// 	// if (res) {
		// 	// 	alert('저장되었습니다.');
		// 	// 	closeModal('modal-ETAX');
		// 	// 	setTranData(COD, YM, DD);
		// 	// }
		// })
		// .always(function(res) {
		// 	// console.log("complete");
		// 	// console.log(res);
		// 	toggleLoader(false);
		// });
	}

	function makeEtaxRun(checkedData) {
		console.log(checkedData);
	}

	// 아래 함수들 는 모달 오픈 페이지에서 별도로 정의
	function makeEtaxRun_NOUSE() {}

	function openMakeEtaxSingle_NOUSE() {}

	function openPointModal() {
		// closeModal('modal-ETAX');
		openModal('modal-POINT');
		initPointModal();
	}

	// 입력폼 reset
	function resetFormETAX(obj) {
		let inputObj = document.getElementById(obj).querySelectorAll('input');
		inputObj.forEach(function(obj, idx) {
			obj.value = '';
		});
	}
</script>