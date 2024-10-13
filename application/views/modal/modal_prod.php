<div id="modal-PROD" class="modal">
	<div class="modal-background"></div>
	<div class="modal-card">
		<header class="modal-card-head">
			<p class="modal-card-title">품목 코드 도움</p>
			<button class="delete" aria-label="close" onclick="closeModal('modal-PROD');"></button>
		</header>
		<section class="modal-card-body">
			<div id="prod_grid" class="mb-1" style="width:100%;height:300px;"></div>
		</section>
		<section class="modal-card-body">
			<div class="field is-grouped">
				<div class="control">
					<input class="input is-small" type="text" placeholder="품목명" id="cndsearch_prod" onKeyPress="if( event.keyCode==13 ){prodSearch();}">
				</div>
				<div class="control">
					<a class="button is-info is-small" onclick="prodSearch();">검색</a>
				</div>
				<div class="control buttons are-small">
					<button class="button is-success" onclick="prodReg();">신규등록</button>
					<button class="button is-warning" onclick="prodModi();">수정</button>
				</div>
			</div>
		</section>
		<footer class="modal-card-foot">
			<div class="buttons are-small is-centered">
				<button class="button is-success" id="prod_select_btn" onclick="prodSelect();">선택</button>
				<button class="button" onclick="closeModal('modal-PROD');">취소</button>
			</div>
		</footer>
	</div>
</div>
<div id="modal-PROD-reg" class="modal">
	<div class="modal-background"></div>
	<div class="modal-card">
		<header class="modal-card-head">
			<p class="modal-card-title">품목 등록</p>
			<button class="delete" aria-label="close" onclick="closeModal('modal-PROD-reg');"></button>
		</header>
		<section class="modal-card-body">
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">구분*</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control select is-small">
							<select name="n_pdvs" id="n_pdvs">
								<option value="1">상품</option>
								<option value="2">제품</option>
								<option value="3">비용</option>
								<option value="4">기타</option>
							</select>
						</p>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">품번*</label>
				</div>
				<div class="field-body">
					<div class="field has-addons">
						<p class="control">
							<input class="input is-small" type="text" name="n_pcod" id="n_pcod" placeholder="품번">
						</p>
						<p class="control">
							<a class="button is-small is-info" id="pcod_btn" onclick="getNextPcod();">부여</a>
						</p>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">품명*</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control">
							<input class="input is-small" type="text" id="n_pnam" name="n_pnam" placeholder="품명">
						</p>
					</div>
					<div class="field">
						<p class="control"></p>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">과세/면세*</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control select is-small">
							<select name="n_taxcd" id="n_taxcd">
								<option value="1">과세</option>
								<option value="0">면세</option>
							</select>
						</p>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">규격</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control">
							<input class="input is-small" type="text" id="n_std" name="n_std" placeholder="규격">
						</p>
					</div>
					<div class="field">
						<p class="control"></p>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">단위</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control">
							<input class="input is-small" type="text" id="n_unt" name="n_unt" placeholder="단위">
						</p>
					</div>
					<div class="field">
						<p class="control"></p>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">매입단가</label>
				</div>
				<div class="field-body">
					<div class="field has-addons">
						<p class="control">
							<input class="input is-small" type="text" id="n_stdcost" name="n_stdcost" placeholder="매입단가" oninput="formatNumberInpu(this);">

						</p>
						<p class="control">
							<a class="button is-small is-static">원</a>
						</p>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">판매단가</label>
				</div>
				<div class="field-body">
					<div class="field has-addons">
						<p class="control">
							<input class="input is-small" type="text" id="n_stdsale" name="n_stdsale" placeholder="판매단가" oninput="formatNumberInpu(this);">
						</p>

						<p class="control">
							<a class="button is-small is-static">원</a>
						</p>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">비고</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control">
							<input class="input is-small" type="text" id="n_rmk" name="n_rmk" placeholder="비고">
						</p>
					</div>
				</div>
			</div>
		</section>
		<footer class="modal-card-foot">
			<div class="buttons are-small is-centered">
				<button class="button is-success" onclick="return saveProd();">저장</button>
				<!-- <button class="button is-danger" onclick="">삭제</button> -->
				<button class="button" onclick="closeModal('modal-PROD-reg');">취소</button>
			</div>
		</footer>
		<script>



			function saveProd() {
				// 필수입력
				let PDVS = document.getElementById('n_pdvs').value;
				let PCOD = document.getElementById('n_pcod').value;
				let PNAM = document.getElementById('n_pnam').value;
				let TAXCD = document.getElementById('n_taxcd').value;
				// 선택입력
				let STD = document.getElementById('n_std').value;
				let UNT = document.getElementById('n_unt').value;
				let STDCOST = document.getElementById('n_stdcost').value;
				let STDSALE = document.getElementById('n_stdsale').value;
				let RMK = document.getElementById('n_rmk').value;

				STDCOST = STDCOST.replace(/,/g, '');
				STDSALE = STDSALE.replace(/,/g, '');

				console.log('STDCOST:' + STDCOST);
				console.log('STDSALE:' + STDSALE);


				if (!PDVS || !PCOD || !PNAM || !TAXCD) {
					alert('필수 입력값을 입력해 주세요.');
					return false;
				}


				$.ajax({
					url: '/manage/saveProd/',
					type: 'post',
					dataType: 'json',
					data: {
						PCOD: PCOD
						, DVS: PDVS
						, NAM: PNAM
						, STD: STD
						, UNT: UNT
						, TAXCD: TAXCD
						, STDCOST: STDCOST
						, STDSALE: STDSALE
						, RMK: RMK

						// 공통 사용 변수
						, COD: COD
					},
				})
				.done(function(res) {
					console.log('save prod:' + res);
					if (res) {
						alert('저장되었습니다.');
						setProdData(COD, '');
						closeModal('modal-PROD-reg');
					}
				})
				.always(function(res) {
					// console.log("complete");
					// console.log(res);
				});
			}

			function getNextPcod() {
				$.ajax({
					url: '/manage/getNextPcod/',
					type: 'post',
					//dataType: 'json',
					data: {
						// 공통사용변수
						COD: COD
					},
				})
				.done(function(res) {
					console.log(112233);
					console.log(res);
					if (res) {
						document.getElementById('n_pcod').value = res;
					} else {
						alert('오류가 발생했습니다.');
					}
				})
				.always(function(res) {
					console.log(res);
					console.log("complete");
				});
			}
		</script>
	</div>
</div>
<script>
	// openModal('modal-PROD-reg');
	
	var selectedPCOD;
	var selectedPNAM;
	var selectedSTDCOST;
	var selectedSTDSALE;
	var selectedTAXCD;

	var dataProd;
	document.addEventListener('DOMContentLoaded', function() {
		providerProd = new RealGrid.LocalDataProvider();
		gridViewProd = new RealGrid.GridView('prod_grid');
		gridViewProd.setDataSource(providerProd);

		gridViewProd.displayOptions.rowHeight = 30;
		gridViewProd.displayOptions.selectionMode = "none";
		gridViewProd.displayOptions.selectionStyle = "singleRow";


		// 단순조회물, 풋터는 표시하지 않는다.
		gridViewProd.setFooters({
		  	visible: false
		});

		gridViewProd.header.height = 36;
		
		gridViewProd.onKeyDown = function (grid, event) {
		    
		    if (event.keyCode == 13) {
		    	prodSelect();
		    	return false;
		    }

		};

		providerProd.setFields([
			{fieldName: 'COD'}
			, {fieldName: 'PCOD'}
			, {fieldName: 'DVS'}
			, {fieldName: 'NAM'}
			, {fieldName: 'STD'}
			, {fieldName: 'UNT'}
			, {fieldName: 'TAXCD'}
			, {fieldName: 'STDCOST', dataType: 'number'}
			, {fieldName: 'STDSALE', dataType: 'number'}
			, {fieldName: 'RMK'}
		]);

		gridViewProd.setColumns([
			{
				name: 'PCOD'
				, fieldName: 'PCOD'
				, width: 100
				, editable: false
			  ,  styleName: 'align-center'
				, header: {text: '품번'}
			}
			, {
				name: 'NAM'
				, fieldName: 'NAM'
				, width: 150
				, editable: false
			  ,  styleName: 'align-left'
				, header: {text: '품명'}
			}
			, {
				name: 'STDCOST'
				, fieldName: 'STDCOST'
				, width: 90
				, editable: false
						  ,  styleName: 'align-right'
						  ,  type: 'number'
						  ,  numberFormat: '#,##0'
				, header: {text: '기준매입가'}

			}
			, {
				name: 'STDSALE'
				, fieldName: 'STDSALE'
				, width: 90
				, editable: false
						  ,  styleName: 'align-right'
						  ,  type: 'number'
						  ,  numberFormat: '#,##0'
				, header: {text: '기준판매가'}

			}		
			, {
				name: 'STD'
				, fieldName: 'STD'
				, width: 100
				, editable: false
			  ,  styleName: 'align-left'
				, header: {text: '규격'}
			}
			, {
				name: 'UNT'
				, fieldName: 'UNT'
				, width: 100
				, editable: false
			  ,  styleName: 'align-left'
				, header: {text: '단위'}
			}
			,{name: 'DVS'       
			  ,  fieldName: 'DVS'		  
			  ,  editable: false
			  ,  styleName: 'align-center'
			  ,  width: 60
			  ,  header: {text: '구분'}
			  ,  editor: {type: 'dropdown', domainOnly: true, textReadOnly: false, partialMatch: true}
			  , values: ['1', '2', '3', '4']
		 	  , labels: ['1.제품', '2.상품', '3.비용', '4.기타']
			  , lookupDisplay: true
			}			
			, {name: 'TAXCD'     
			  ,  fieldName: 'TAXCD'	  
			  ,  editable: false
			  ,  width: 60
			  ,  header: {text: '과세'}
			  ,  styleName: 'align-center'
			  , values: ['1', '0']
		 	  , labels: ['1.과세', '0.면세']
			  , lookupDisplay: true
			}
		]);

		gridViewProd.onCurrentRowChanged = function(grid, oldRow, newRow) {
			console.log('check', oldRow, newRow);
			console.log(grid);
			
			// 품목 선택 정보
			selectedPCOD = providerProd.getValue(newRow, 'PCOD');
			selectedPNAM = providerProd.getValue(newRow, 'NAM');
			selectedSTDCOST = providerProd.getValue(newRow, 'STDCOST');
			selectedSTDSALE = providerProd.getValue(newRow, 'STDSALE');
			selectedTAXCD = providerProd.getValue(newRow, 'TAXCD');
		}
	});

	// 입력폼 reset
	function resetFormPROD(obj) {
		document.getElementById('pcod_btn').disabled = false;
		let inputObj = document.getElementById(obj).querySelectorAll('input');
		inputObj.forEach(function(obj, idx) {
			obj.value = '';
		});
	}

	// 품목 신규 등록
	function prodReg() {
		resetFormPROD('modal-PROD-reg');
		openModal('modal-PROD-reg');
	}

	// 품목 수정
	function prodModi() {
		if (!selectedPCOD) {
			alert('품목을 선택해주세요.');
			return false;
		}
		gridViewProd.showLoading();
		resetFormPROD('modal-PROD-reg');
		setProdModiData(COD, selectedPCOD);
		openModal('modal-PROD-reg');
		gridViewProd.closeLoading();
	}

	// 품목 데이터 가져오기
	function setProdData(COD, SCH) {
		gridViewProd.showLoading();
		$.ajax({
			url: '/manage/getProd/',
			type: 'post',
			dataType: 'json',
			data: {
				COD: COD
				, SCH: SCH
			},
		})
		.done(function(jsonData) {
			providerProd.fillJsonData(jsonData, {fillMode : 'set'});
			dataProd = jsonData;
			gridViewProd.commit(true);
			gridViewProd.closeLoading();


			if (document.getElementById('cndsearch_prod').value == '' || providerProd.getRowCount() == 0) {
				document.getElementById('cndsearch_prod').select();
				document.getElementById('cndsearch_prod').focus();
			} else {
				gridViewProd.setFocus();
			}

		})
		.always(function() {
			console.log('gridProdData complete');
		});

		// 검색 입력 reset
		//document.getElementById('cndsearch_prod').value = '';
	}

	// 수정할 품목 데이터 가져오기
	function setProdModiData(COD, CDS) {
		$.ajax({
			url: '/manage/getProd/',
			type: 'post',
			dataType: 'json',
			data: {
				COD: COD
				, CDS: CDS
			},
		})
		.done(function(res) {
			// providerCmpy.clearRows();
			console.log(res[0]);
			let prodData = res[0];
			document.getElementById('pcod_btn').disabled = true;
			document.getElementById('n_pdvs').value = prodData.DVS;
			document.getElementById('n_pcod').value = prodData.PCOD;
			document.getElementById('n_pnam').value = prodData.NAM;
			document.getElementById('n_taxcd').value = prodData.TAXCD;
			document.getElementById('n_std').value = prodData.STD;
			document.getElementById('n_unt').value = prodData.UNT;

			
			document.getElementById('n_stdcost').value = formatNumberDisp(prodData.STDCOST);
			document.getElementById('n_stdsale').value = formatNumberDisp(prodData.STDSALE);
			document.getElementById('n_rmk').value = prodData.RMK;

			openModal('modal-PROD-reg');
		})
		.always(function() {
			console.log('gridCmpyModiData complete');
		});
	}


function formatNumberDisp(number) {
    // 콤마 제거
    let value = number.replace(/,/g, '');

    // 숫자만 남기고 모든 문자 제거
    value = value.replace(/[^\d]/g, '');

    // 천단위 콤마 추가
    value = Number(value).toLocaleString('en-US');

    return value;
}

function formatNumberInpu(input) {
	// 현재 입력값에서 콤마 제거
	let value = input.value.replace(/,/g, '');

	// 숫자만 남기고 모든 문자 제거
	value = value.replace(/[^\d]/g, '');

	// 천단위 콤마 추가
	value = Number(value).toLocaleString('en-US');

	// 입력 필드에 적용
	input.value = value;
}



	function prodSelect() {
		providerDetail.setValue(modalTargetIndex, 'PCOD', selectedPCOD);
		providerDetail.setValue(modalTargetIndex, 'NAM', selectedPNAM);

		let chkDVS = providerDetail.getValue(modalTargetIndex, 'DVS');

		console.log('chkDVS', chkDVS);
		if (chkDVS == '1' || chkDVS == '3' || chkDVS == '6'){
			providerDetail.setValue(modalTargetIndex, 'PRIC', selectedSTDSALE);			
		} else if (chkDVS == '2' || chkDVS == '4' || chkDVS == '7'){
			providerDetail.setValue(modalTargetIndex, 'PRIC', selectedSTDCOST);			
		}

		providerDetail.setValue(modalTargetIndex, 'TAXCD', selectedTAXCD);

		console.log(modalTargetIndex, modalTargetGrid);
		gridViewDetail.onCellEdited(modalTargetGrid, modalTargetIndex, 0, 0);

		closeModal('modal-PROD');
		modalTargetGrid.setFocus();
	}

	function prodSearch(val) {
		let SCH = document.getElementById('cndsearch_prod').value;
		setProdData(COD, SCH);
	}
</script>