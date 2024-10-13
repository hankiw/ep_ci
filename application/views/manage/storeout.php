<!-- 리얼그리드 테마 css -->
<link href="<?=INC_JS_URL?>realgrid.2.6.2/realgrid-sky-blue.css" rel="stylesheet" />
<!-- 리얼그리드 커스컴 수정사항 css -->
<link href="<?=INC_JS_URL?>realgrid.2.6.2/realgrid-custom.css" rel="stylesheet" />
<script src="<?=INC_JS_URL?>realgrid.2.6.2/realgrid-lic.js"></script>
<script src="<?=INC_JS_URL?>realgrid.2.6.2/realgrid.2.6.2.min.js"></script>

<section class="section p-4">
	<div class="container pt-5">
		<h1 class="title mb-4 is-size-5-desktop is-size-6-tablet is-size-6-mobile"><?=$page_title?></h1>
		<!-- <h2 class="subtitle">입고 품목 관리</h2> -->
		
		<div class="level mb-4">
			<div class="level-left">
				<form id="select_ym" name="select_ym">
					<div class="field is-horizontal">
						<div class="field-label is-small mr-2" style="width:120px;">
							<label class="label">년월-일</label>
						</div>
						<div class="field-body">
							<div class="field">
								<p class="control is-expanded has-icons-left">
									<input class="input is-small p-1 datepicker monthpicker" type="text" name="YM" placeholder="" value="<?=$YMF?>" size="5" reaonly onchange="selectYM();">


								</p>
							</div>
							<div class="field">
								<p class="control" style="width:50px;">
									<input class="input is-small p-1" type="text" name="DD" placeholder="" value="<?=$DD?>" size="3" maxlength="2" onchange="selectYM();">
								</p>
							</div>
						</div>
					</div>
				</form>
			</div>
			<script>
				function selectYM() {
					document.select_ym.submit();
				}
			</script>
			<div class="level-right">
				<div class="buttons are-small">
					<a class="button" onclick="transfer_tran();">건별전송</a>
					<a class="button mr-5" onclick="transfer_cancel();">전송취소</a>
					<a href="" class="button">도움</a>
					<a href="" class="button">검색</a>
					<a class="button" onclick="delRowData();">삭제</a>
					<a href="" class="button">인쇄</a>
					<a href="" class="button">복사이동</a>
				</div>
			</div>
		</div>
		

		<div>
			<div id="master_grid" class="mb-4" style="width:100%;height:300px;"></div>
			<div class="level mb-4">
				<div class="level-left">
					<div class="field is-horizontal">
						<div class="field-label is-small mr-2" style="width:120px;">
							<label class="label">명세서</label>
						</div>
						<div class="field-body">
							<div class="field">
								<p class="control is-expanded has-icons-left">
									<input class="input is-small p-1" type="text" id="selected_cds" value="" size="10" readonly>
								</p>
							</div>
							<div class="field">
								<p class="control is-expanded has-icons-left has-icons-right">
									<input class="input is-small p-1" type="text" id="selected_nos" value="" size="10" readonly>
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="level-right">
					<div class="buttons are-small">
						<a class="button" onclick="delRowDataDetail();">삭제</a>
					</div>
				</div>
			</div>
			<div id="detail_grid" style="width:100%;height:300px;"></div>
			<script>
				var providerMaster, gridViewMaster, providerDetail, gridViewDetail;
				var COD = '<?=$COD?>';
				var YM = '<?=$YM?>';
				var DD = '<?=$DD?>';
				var DVS = '<?=$DVS?>';

				// modal 에서 값 입력 후 그리드 접근 위해
				var modalTargetGrid;
				var modalTargetIndex;
				var modalTargetProvider;

				var isInitData = false;

				document.addEventListener('DOMContentLoaded', function() {
					providerMaster = new RealGrid.LocalDataProvider();
					gridViewMaster = new RealGrid.GridView('master_grid');
					gridViewMaster.setDataSource(providerMaster);
					gridViewMaster.displayOptions.rowHeight = 30;
					gridViewMaster.header.height = 36;
					gridViewMaster.footer.height = 30;
					gridViewMaster.checkBar.useImages = true;
					
					gridViewMaster.setStateBar({
						visible: true,
						width:20,
					});

					gridViewMaster.setCheckBar({
						visible: true,
						showAll: true,
	
						width: 40,
					});

					//function key, enter key event
					gridViewMaster.setEditOptions({
						insertable :true,
						appendable :true,
						commitByCell: true,
						// commitWhenExitLast: true,
						// enterToNextRow: true,
						enterToTab: true,
						skipReadOnly: true,
						// skipReadOnlyCell: true,
						crossWhenExitLast:true,
					});

					providerDetail = new RealGrid.LocalDataProvider();
					gridViewDetail = new RealGrid.GridView('detail_grid');
					gridViewDetail.setDataSource(providerDetail);
					gridViewDetail.displayOptions.rowHeight = 30;
					gridViewDetail.header.height = 36;
					gridViewDetail.footer.height = 30;
					gridViewDetail.checkBar.useImages = true;

					gridViewDetail.setStateBar({
						visible: true,
						width:20,
					});

					gridViewDetail.setCheckBar({
						visible: true,
						showAll: true,
						width: 40,
					});

					//function key, enter key event
					gridViewDetail.setEditOptions({
						insertable :true,
						appendable :true,
						commitByCell: true,
						//commitWhenExitLast: true,
						//enterToNextRow: true,
						enterToTab: true,
						skipReadOnly: true,
						//skipReadOnlyCell: true,
						crossWhenExitLast:true,
					});

					providerMaster.setFields([
						{fieldName: 'COD'}
						, {fieldName: 'DVS'}
						, {fieldName: 'DTS'}
						, {fieldName: 'DTS_DD'}
						, {fieldName: 'NOS'}
						, {fieldName: 'TYP'}
						, {fieldName: 'GBN'}
						, {fieldName: 'CDS'}
						, {fieldName: 'NAM'}
						, {fieldName: 'NET', dataType: 'number'}
						, {fieldName: 'VAT', dataType: 'number'}
						, {fieldName: 'GRS', dataType: 'number'}
						, {fieldName: 'TRS'}
						, {fieldName: 'TNO'}
						, {fieldName: 'ENO'}
					]);

					let masterColumns = [
						{
							name: 'DTS_DD'
							, fieldName: 'DTS_DD'
							, width: 50
							, styleName: 'align-center'
							, header: {text: '일 *'}
						}
						, {
							name: 'TYP'
							, fieldName: 'TYP'
							, width: 120
							, header: {text: '유형 *'}
							, editor: {type: 'dropdown', domainOnly: true, textReadOnly: false, partialMatch: true}
							, values: ['1', '2', '6', '7', '8']
							, labels: ['1.세금계산서', '2.계산서', '6.신용카드', '7.현금영수증', '8.기타']
							, lookupDisplay: true
						}
						, {
							name: 'GBN'
							, fieldName: 'GBN'
							, width: 80
							, header: {text: '발행구분 *'}
							, editor: {type: 'dropdown', domainOnly: true, textReadOnly: false, partialMatch: true}
							, values: ['1', '2', '3']
							, labels: ['1.건별', '2.합산', '3.기타']
							, lookupDisplay: true
						}
						, {
							name: 'CDS'
							, fieldName: 'CDS'
							, width: 100
							, header: {text: '거래처코드 *'}
							, editable: true
							, button: 'action'
							, buttonVisibility: 'default'
							
						}
						, {name: 'NAM', fieldName: 'NAM', editable: false
							, styleName: 'editable-false', width: 150, header: {text: '거래처명'}}
						, {name: 'NOS', fieldName: 'NOS', editable: false
							, styleName: 'editable-false align-center', width: 120
							, header: {text: '명세서번호'}}
						, {
							name: 'NET'
							, fieldName: 'NET'
							, editable: false
							, styleName: 'editable-false align-right'
							, header: {text: '공급가액'}
							, type: 'number'
							, numberFormat: '#,##0'
							, footer: {
								expression: 'sum'
								, numberFormat: '#,##0'
								, text: '합계'
								, styleName: 'align-right'
							}
						}
						, {
							name: 'VAT'
							, fieldName: 'VAT'
							, editable: false
							, styleName: 'editable-false align-right'
							, header: {text: '부가세액'}
							, type: 'number'
							, numberFormat: '#,##0'
							, footer: {
								expression: 'sum'
								, numberFormat: '#,##0'
								, text: '합계'
								, styleName: 'align-right'
							}
						}
						, {
							name: 'GRS'
							, fieldName: 'GRS'
							, editable: false
							, styleName: 'editable-false align-right'
							, header: {text: '합계금액'}
							, type: 'number'
							, numberFormat: '#,##0'
							, footer: {
								expression: 'sum'
								, numberFormat: '#,##0'
								, text: '합계'
								, styleName: 'align-right'
							}
						}
						, {
							name: 'TRS'
							, fieldName: 'TRS'
							, editable: false
							, styleName: 'editable-false align-center'
							, width: 60
							, header: {text: '전송'}
						}
						, {
							name: 'TNO'
							, fieldName: 'TNO'
							, editable: false
							, styleName: 'editable-false align-center'
							, width: 100
							, header: {text: '전송번호'}
						}
						, {
							name: 'ENO'
							, fieldName: 'ENO'
							, editable: false
							, styleName: 'editable-false align-center'
							, width: 100
							, header: {text: '발행번호'}
						}
					];

					
					gridViewMaster.setColumns(masterColumns);

					providerDetail.setFields([
						{fieldName: 'COD'}
						, {fieldName: 'DVS'}
						, {fieldName: 'DTS'}
						, {fieldName: 'NOS'}
						, {fieldName: 'SEQS'}
						, {fieldName: 'DSEQ'}
						, {fieldName: 'PCOD'}
						, {fieldName: 'NAM'}
						, {fieldName: 'STD'}
						, {fieldName: 'UNT'}
						, {fieldName: 'QTYS', dataType: 'number'}
						, {fieldName: 'PRIC', dataType: 'number'}
						, {fieldName: 'TAXCD'}
						, {fieldName: 'NETS', dataType: 'number'}
						, {fieldName: 'VATS', dataType: 'number'}
						, {fieldName: 'GRSS', dataType: 'number'}
						, {fieldName: 'REMK'}
						, {fieldName: 'RETN'}
						, {fieldName: 'PAMT', dataType: 'number'}
						, {fieldName: 'BNFT', dataType: 'number'}
						, {fieldName: 'BNFT_DESC'}
					]);


					let detailColumns = [
						{
							name: 'PCOD'
							, fieldName: 'PCOD'
							, width: 120
							, editable: true
							, header: {text: '품번 *'}
							, button: 'action'
							, buttonVisibility: 'default'
							// , editor: {type: 'dropdown', domainOnly: true, textReadOnly: true}
							// , values: prodValues
							// , labels: prodValues
							// , lookupDisplay: true
						}
						, {name: 'NAM', fieldName: 'NAM'
							, width: 150
							, editable: false
							, styleName: 'editable-false'
							, header: {text:'품명'} }
						, {
							name: 'QTYS'
							, fieldName: 'QTYS'
							, width: 80
							, styleName: 'align-right'
							, header: {text:'수량 *'}
							, type: 'number'
							, numberFormat: '#,##0'
							, editor: {type: 'number', numberFormat: '#,##0'}
						}
						, {name: 'SEQS', fieldName: 'SEQS'
							, width: 40
							, styleName: 'editable-false align-center'
							, editable: false
							, visible: false
							, header: {text:'순번'} }
						, {name: 'DSEQ', fieldName: 'DSEQ'
							, width: 60
							, styleName: 'align-center'
							, editable: false
							, visible: false
							, header: {text:'표시순번'} }
						, {
							name: 'PRIC'
							, fieldName: 'PRIC'
							, styleName: 'align-right'
							, header: {text:'단가 *'}
							, width: 90
							, numberFormat: '#,##0'
						    ,  editor: {
							    type: "number",
							    textAlignment: "far",
							    //입력시 적용되는 포맷(소수점 최대 3자리까지만 입력 가능)
							    editFormat: "#,##0",
							    multipleChar: "+",
							 }
						}
						,{name: 'TAXCD'     
							,  fieldName: 'TAXCD'	  
							, styleName: 'align-center'
						  	,  editable: false
						  	,  width: 60
						  	,  header: {text: '과세'}
						  	, values: ['1', '0']
					 	  	, labels: ['1.과세', '0.면세']
						  	, lookupDisplay: true
						}		
						, {
							name: 'NETS'
							, fieldName: 'NETS'
							, styleName: 'align-right'
							, header: {text:'공급가액'}
							, type: 'number'
							, width: 90
							, numberFormat: '#,##0'
							, editor: {type: 'number', numberFormat: '#,##0'}
							, footer: {
								expression: 'sum'
								, numberFormat: '#,##0'
								, text: '합계'
								, styleName: 'align-right'
							}
						}
						, {
							name: 'VATS'
							, fieldName: 'VATS'
							, styleName: 'align-right'
							, header: {text:'부가세액'}
							, type: 'number'
							, width: 90
							, numberFormat: '#,##0'
							, editor: {type: 'number', numberFormat: '#,##0'}
							, footer: {
								expression: 'sum'
								, numberFormat: '#,##0'
								, text: '합계'
								, styleName: 'align-right'
							}
						}
						, {
							name: 'GRSS'
							, fieldName: 'GRSS'
							, styleName: 'editable-false align-right'
							, header: {text:'합계금액'}
							, editable: false
							, type: 'number'
							, width: 90
							, numberFormat: '#,##0'
							, editor: {type: 'number', numberFormat: '#,##0'}
							, footer: {
								expression: 'sum'
								, numberFormat: '#,##0'
								, text: '합계'
								, styleName: 'align-right'
							}
						}
						, {
							name: 'REMK'
							, fieldName: 'REMK'
							, width: 100
							, header: {text:'적요'}
						}
						, {
							name: 'RETN'
							, fieldName: 'RETN'
							, header: {text:'반품'}
							, width: 50
							, editable: false
							, styleName: 'editable-false'
						}
						, {
							name: 'PAMT'
							, fieldName: 'PAMT'
							, numberFormat: '#,##0'
							, header: {text:'매입금액'}
						    , width: 80
							, editable: false
							, styleName: 'editable-false align-right'
						}
						, {
							name: 'BNFT'
							, fieldName: 'BNFT'
							, numberFormat: '#,##0'
							, header: {text:'판매이익'}
						    , width: 80
							, editable: false
							, styleName: 'editable-false align-right'
						}
						, {
							name: 'BNFT_DESC'
							, fieldName: 'BNFT_DESC'
							, header: {text:'비고'}
							, width: 120
							, editable: false
							, styleName: 'editable-false'
						}
					];
					gridViewDetail.setColumns(detailColumns);
					gridViewDetail.columnByName("PAMT").header.text = "매입금액";

					// 최초 master 그리드 set
					setMasterData(DVS, COD, YM, DD);

					// gridViewMaster.showLoading();

					// master 그리드 행 선택
					gridViewMaster.onCurrentRowChanged = function(grid, oldRow, newRow) {
						// console.log('check', oldRow, newRow);
						// console.log(grid);
						providerDetail.clearRows();
						let COD = providerMaster.getValue(newRow, 'COD');
						let DVS = providerMaster.getValue(newRow, 'DVS');
						let DTS = providerMaster.getValue(newRow, 'DTS');
						let NOS = providerMaster.getValue(newRow, 'NOS');
						if (newRow < 0 || !NOS) return;

						console.log('check1111');
						console.log(COD, DVS, DTS, NOS);
						
						// 거래처 정보
						let CDS = providerMaster.getValue(newRow, 'CDS');
						let NAM = providerMaster.getValue(newRow, 'NAM');
						document.getElementById('selected_cds').value = NAM;
						document.getElementById('selected_nos').value = NOS;
						
						setDetailData(COD, DVS, NOS);
					}

					gridViewMaster.onCellEdited = function(grid, itemIndex, row, field) {
						gridViewMaster.commit(true);
						let current = gridViewMaster.getCurrent();
						let thisValue = providerMaster.getValue(current.dataRow, current.fieldName);
						let NOS = providerMaster.getValue(current.dataRow, 'NOS');
						let DTSDD = providerMaster.getValue(current.dataRow, 'DTS_DD');
						let TYP = providerMaster.getValue(current.dataRow, 'TYP');
						let GBN = providerMaster.getValue(current.dataRow, 'GBN');
						let CDS = providerMaster.getValue(current.dataRow, 'CDS');
						let NET = providerMaster.getValue(current.dataRow, 'NET');
						let VAT = providerMaster.getValue(current.dataRow, 'VAT');
						// let GRS = providerMaster.getValue(current.dataRow, 'GRS');
						// let TRS = providerMaster.getValue(current.dataRow, 'TRS');
						// let EBL = providerMaster.getValue(current.dataRow, 'EBL');
						// let ENO = providerMaster.getValue(current.dataRow, 'ENO');

						NET = (!NET) ? '0' : NET;
						VAT = (!VAT) ? '0' : VAT;

						if (Number(DTSDD) < 10) DTSDD = '0' + Number(DTSDD);

						// 유형 선택 시 발행구분 값만 자동으로
						if (current.fieldName == 'TYP' && !NOS) {
							if (thisValue == '1' || thisValue == '2') {
								// 세금계산서, 계산서 선택 시 GBN(발행구분) 값이 합산 으로 선택되있으면 변경 X
								if (GBN != '2') providerMaster.setValue(current.dataRow, 'GBN', '1');
							} else {
								providerMaster.setValue(current.dataRow, 'GBN', '3');
							}
						}

						if (!NOS && (DTSDD && TYP && GBN && CDS)) {
							console.log('insert master row');
							let ret = saveRowData((YM + DTSDD), TYP, GBN, CDS);
							gridViewMaster.commit(true);
						} else if (NOS) {
							console.log('update master row');
							let ret = updateRowData(COD, DVS, (YM + DTSDD), NOS, TYP, GBN, CDS, NET, VAT);
							gridViewMaster.commit(true);
						}
					}

					gridViewDetail.onCellEdited = function(grid, itemIndex, row, field) {
						gridViewDetail.commit(true);
						let current = gridViewDetail.getCurrent();
						let thisValue = providerDetail.getValue(current.dataRow, current.fieldName);
						let rowData = [];
						let PCOD = providerDetail.getValue(current.dataRow, 'PCOD');
						let NAM = providerDetail.getValue(current.dataRow, 'NAM');
						let QTYS = providerDetail.getValue(current.dataRow, 'QTYS');
						let NOS = providerDetail.getValue(current.dataRow, 'NOS');
						let SEQS = providerDetail.getValue(current.dataRow, 'SEQS');
						let DSEQ = providerDetail.getValue(current.dataRow, 'DSEQ');
						let PRIC = providerDetail.getValue(current.dataRow, 'PRIC');
						let REMK = providerDetail.getValue(current.dataRow, 'REMK');

						PRIC = (!PRIC) ? '0' : PRIC;
						//REMK = (!REMK) ? '' : REMK;

						if (!SEQS && (PCOD && QTYS && PRIC)) {
							console.log('insert detail row');
							console.log(PCOD, QTYS, NOS, PRIC, REMK);
							let result = saveRowDataDetail(PCOD, QTYS, NOS, PRIC, REMK);
							gridViewDetail.commit(true);
						} else if (SEQS && (NAM && PCOD && QTYS && PRIC)) {
							console.log('update detail row');
							console.log(PCOD, QTYS, NOS, SEQS, DSEQ, PRIC, REMK);
							let result = updateRowDataDetail(PCOD, QTYS, NOS, SEQS, DSEQ, PRIC, REMK);
							gridViewDetail.commit(true);
						}
					}

					gridViewMaster.onCellButtonClicked = function(grid, column) {
						// console.log(grid, column);
						if (column.column == 'CDS') {
							OpenModalS(column.column);
						}
					};

					gridViewDetail.onCellButtonClicked = function(grid, column) {
						// console.log(grid, column);
						if (column.column == 'PCOD') {
							OpenModalS(column.column);
						}
					};

					providerMaster.onRowCountChanged = function(provider, count) {
						// 스크롤 최하단으로 설정, 그냥하면 setTopItem 이 안먹혀서 setTimeout 넣음
						setTimeout(function() {
							gridViewMaster.setTopItem(count);
							if (!isInitData) {
								gridViewMaster.setCurrent({itemIndex: count});
								gridViewMaster.setFocus();
								isInitData = true;
							}
						}, 10);
					};

					//function key, enter key event
					gridViewMaster.onKeyDown = function (grid, event) {
						if (event.keyCode == 113) {
					    	// 구분필드에서 f2 를 눌렀으면
					    	if (gridViewMaster.getCurrent().fieldName == "DVS" 
					    		|| gridViewMaster.getCurrent().fieldName == "GBN"
					    		|| gridViewMaster.getCurrent().fieldName == "TYP"){
					    		gridViewMaster.showEditor(true);
					    		return true;		    		
					    	}
					    	else if (gridViewMaster.getCurrent().fieldName == "CDS"){
								OpenModalS(gridViewMaster.getCurrent().fieldName);
							 	return false;
					    	}
					    }
					};


					//function key, enter key event
					gridViewDetail.onKeyDown = function (grid, event) {
						if (event.keyCode == 113) {
					    	if (gridViewDetail.getCurrent().fieldName == "PCOD"){
								OpenModalS(gridViewDetail.getCurrent().fieldName);
							 	return false;
					    	}
					    }
					};

					providerDetail.onRowCountChanged = function(provider, count) {
						// 스크롤 최하단으로 설정, 그냥하면 setTopItem 이 안먹혀서 setTimeout 넣음
						setTimeout(function() {
							gridViewDetail.setTopItem(count);
						}, 10);
					};

				});

				function OpenModalS(DIV){
				
					//modalOpenCDS
					//modalOpenPCOD

					if (DIV == "CDS"){

						modalTargetGrid = gridViewMaster;
						modalTargetIndex = gridViewMaster.getCurrent().itemIndex;
						modalTargetProvider = providerMaster;


						openModal('modal-CMPYCDS');
						setCmpyData(COD, '');

						document.getElementById('cndsearch').value = "";
						document.getElementById('cndsearch').focus();

					}
					else if (DIV == "PCOD"){

						modalTargetGrid = gridViewDetail;
					 	modalTargetIndex = gridViewDetail.getCurrent().itemIndex;
					 	modalTargetProvider = providerDetail;

					 	openModal('modal-PROD');
						setProdData(COD, '');

						document.getElementById('cndsearch_prod').value = "";
						document.getElementById('cndsearch_prod').focus();

					};

				}
				

				// data json 가져오기
				function setMasterData(DVS, COD, YM, D) {
					
					gridViewMaster.showLoading();
					$.ajax({
						url: '/manage/gridMasterData/',
						type: 'post',
						dataType: 'json',
						data: {DVS: DVS, COD: COD, YM: YM, D: D},
					})
					.done(function(jsonData) {
						// console.log(jsonData);
						providerMaster.fillJsonData(jsonData, {fillMode : 'set'});
						providerMaster.addRow({});
						gridViewMaster.commit(true);
						gridViewMaster.closeLoading();
					})
					.always(function() {
						console.log('gridMasterData complete');
					});
				}

				function setDetailData(COD, DVS, NOS) {
					let thisNOS = NOS;
					let thisDVS = DVS;
					gridViewDetail.showLoading();
					$.ajax({
						url: '/manage/gridDetailData/',
						type: 'post',
						dataType: 'json',
						data: {
							COD: COD
							, DVS: DVS
							, NOS: NOS
						},
					})
					.done(function(jsonData) {
						providerDetail.fillJsonData(jsonData, {fillMode : 'set'});
						let detailNewRow = providerDetail.addRow({});
						providerDetail.setValue(detailNewRow, 'NOS', thisNOS);
						providerDetail.setValue(detailNewRow, 'DVS', thisDVS);
						gridViewDetail.closeLoading();
						gridViewDetail.commit(true);

						console.log('after update detail row');
						let masterCurrent = gridViewMaster.getCurrent();
						let sumNETS = gridViewDetail.getSummary('NETS','sum');
						let sumVATS = gridViewDetail.getSummary('VATS','sum');
						let sumGRSS = gridViewDetail.getSummary('GRSS','sum');
						if (sumNETS && sumVATS && sumGRSS) {
							providerMaster.setValue(masterCurrent.dataRow, 'NET', sumNETS);
							providerMaster.setValue(masterCurrent.dataRow, 'VAT', sumVATS);
							providerMaster.setValue(masterCurrent.dataRow, 'GRS', sumGRSS);
							providerMaster.setRowState(masterCurrent.itemIndex, 'none', true);
							gridViewMaster.commit(true);
						}
					})
					.always(function() {
						console.log('gridDetailData complete');
					});
				}

				// master row 데이터 저장하기
				function saveRowData(DTS, TYP, GBN, CDS) {
					gridViewMaster.showLoading();
					// console.log('in saveRowData ajax', DTS, TYP, GBN, CDS, DVS, COD, YM);
					$.ajax({
						url: '/manage/updateRowData',
						type: 'post',
						dataType: 'json',
						data: {
							CRUD: 'C'
							, COD: COD
							, DVS: DVS
							, DTS: DTS
							, TYP: TYP
							, GBN: GBN
							, CDS: CDS
							, NET: '0'
							, VAT: '0'
							// 공통변수
							, YM: YM
						},
					})
					.done(function(res) {
						// console.log(res);
						console.log("success saveRowData");
						if (res.CNT > 0) {
							let insertRowIdx = providerMaster.getRowCount() - 1;
							// 프로시저에서 NOS 받아서 set 해줘야함
							providerMaster.setValue(insertRowIdx, 'NOS', res.NOS);
							// 새로 추가한 row 의 다른 정보는 기존 변수 활용
							providerMaster.setValue(insertRowIdx, 'COD', COD);
							providerMaster.setValue(insertRowIdx, 'DVS', DVS);
							providerMaster.setValue(insertRowIdx, 'DTS', DTS);
							providerMaster.setValue(insertRowIdx, 'NET', 0);
							providerMaster.setValue(insertRowIdx, 'VAT', 0);
							providerMaster.setValue(insertRowIdx, 'GRS', 0);

							providerMaster.setRowState(insertRowIdx, 'none', true);

							providerMaster.addRow({});
						 	gridViewMaster.commit(true);
							//gridViewMaster.setCurrent({itemIndex: providerMaster.getRowCount(), column: 'DTS_DD'});

							let detailNewRow = providerDetail.addRow({});
							providerDetail.setValue(detailNewRow, 'NOS', res.NOS);
							providerDetail.setValue(detailNewRow, 'DVS', DVS);
							gridViewDetail.commit(true);
							gridViewDetail.setCurrent({itemIndex: providerDetail.getRowCount(), column: 'PCOD'});
							gridViewDetail.setFocus();
						} else {
							alert('오류가 발생했습니다.');
						}

						// if (res) setMasterData(DVS, COD, YM, DD);
					})
					.fail(function(res) {
						console.log(res);
						alert('오류가 발생했습니다.');
						// location.reload();
					})
					.always(function(res) {
						console.log(res);
						gridViewMaster.closeLoading();
					});
				}

				function updateRowData(COD, DVS, DTS, NOS, TYP, GBN, CDS, NET, VAT) {
					gridViewMaster.showLoading();
					console.log(COD, DVS, DTS, NOS, TYP, GBN, CDS, NET, VAT);
					console.log('in updateRowData JS');
					$.ajax({
						url: '/manage/updateRowData',
						type: 'post',
						dataType: 'json',
						data: {
							CRUD: 'U'
							, COD: COD
							, DVS: DVS
							, DTS: DTS
							, NOS: NOS
							, TYP: TYP
							, GBN: GBN
							, CDS: CDS
							, NET: NET
							, VAT: VAT
						},
					})
					.done(function(res) {
						console.log("success updateRowData");
						if (res.CNT > 0) {
							// 정상 처리됨
							let update = gridViewMaster.getCurrent();
							providerMaster.setRowState(update.itemIndex, 'none', true);
						} else {
							alert('오류가 발생했습니다.');
						}
						// setMasterData(DVS, COD, YM, DD);
					})
					.always(function(res) {
						console.log("complete");
						console.log(res);
						gridViewMaster.closeLoading();
					});
					
				}


				function transfer_tran() {
					let provider = providerMaster;
					let gridView = gridViewMaster;
					let checked = gridView.getCheckedRows();
					let checkCnt = 0;
					let checkedCOD;
					let checkedNOS = [];

					checked.forEach(function(row, idx) {
						if (provider.getValue(row, 'NOS')) {
							checkedCOD = provider.getValue(row, 'COD');
							checkedNOS.push(provider.getValue(row, 'NOS'));
							checkCnt++;
						}
					});


					console.log(checkedNOS);

					if (confirm(checkCnt + '건의 판매건을 세금계산서로 전송합니다 : 발행구분이 [1.건별]이 아닌것은 전송되지 않습니다.')) {
						gridView.showLoading();
						$.ajax({
							url: '/manage/transfer_tran_RowData',
							type: 'post',
							dataType: 'json',
							data: {
								COD: checkedCOD
								, NOS: checkedNOS
							},
						})
						.done(function(res) {
							console.log("success");
							console.log(res);
							setMasterData(DVS, COD, YM, DD);
						})
						.fail(function(res) {
							let errorText = sqlErrorMsg(res.responseText);
							alert(errorText);
						})
						.always(function(res) {
							console.log("complete");
							gridView.closeLoading();
						});
					}
				}

				function transfer_cancel() {
					let provider = providerMaster;
					let gridView = gridViewMaster;
					let checked = gridView.getCheckedRows();
					let checkCnt = 0;
					let checkedCOD;
					let checkedTNO = [];

					checked.forEach(function(row, idx) {
						if (provider.getValue(row, 'TNO')) {
							checkedCOD = provider.getValue(row, 'COD');
							checkedTNO.push(provider.getValue(row, 'TNO'));
							checkCnt++;
						}
					});

					if (confirm(checkCnt + '건의 세금계산서 전송건을 취소합니다.')) {
						gridView.showLoading();
						$.ajax({
							url: '/manage/transfer_cancel_RowData',
							type: 'post',
							dataType: 'json',
							data: {
								COD: checkedCOD
								, TNO: checkedTNO
							},
						})
						.done(function(res) {
							console.log("success");
							console.log(res);
							setMasterData(DVS, COD, YM, DD);
						})
						.fail(function(res) {
							let errorText = sqlErrorMsg(res.responseText);
							alert(errorText);
						})
						.always(function(res) {
							console.log("complete");
							console.log(complete);
							gridView.closeLoading();
						});
					}
				}

				function delRowData() {
					let provider = providerMaster;
					let gridView = gridViewMaster;
					let checked = gridView.getCheckedRows();
					let checkCnt = 0;
					let checkedCOD;
					let checkedDVS;
					let checkedNOS = [];

					checked.forEach(function(row, idx) {
						if (provider.getValue(row, 'NOS')) {
							checkedCOD = provider.getValue(row, 'COD');
							checkedDVS = provider.getValue(row, 'DVS');
							checkedNOS.push(provider.getValue(row, 'NOS'));
							checkCnt++;
						}
					});

					if (confirm(checkCnt + '건의 자료를 삭제합니다.')) {
						gridView.showLoading();
						$.ajax({
							url: '/manage/deleteRowData',
							type: 'post',
							dataType: 'json',
							data: {
								COD: checkedCOD
								, DVS: checkedDVS
								, NOS: checkedNOS
							},
						})
						.done(function(res) {
							console.log("success");
							console.log(res);
							setMasterData(DVS, COD, YM, DD);
							gridView.closeLoading();
						})
						.fail(function(res) {
							let errorText = sqlErrorMsg(res.responseText);
							alert(errorText);
						})
						.always(function(res) {
							console.log("complete");
							console.log(complete);
						});
					}
				}

				function saveRowDataDetail(PCOD, QTYS, NOS, PRIC, REMK) {
					gridViewDetail.showLoading();
					$.ajax({
						url: '/manage/updateRowDataDetail',
						type: 'post',
						dataType: 'json',
						data: {
							CRUD: 'C'
							, PCOD: PCOD
							, QTYS: QTYS
							, NOS: NOS
							, SEQS : ''
							, DSEQ : ''
							, PRIC : PRIC
							, REMK : REMK

							// 공통변수
							, DVS: DVS
							, COD: COD
						},
					})
					.done(function(res) {
						console.log("save row data detail.");
						if (res.CNT > 0) {
							let insertRowIdx = providerDetail.getRowCount() - 1;
							// 프로시저에서 값 받아서 set 해줘야함
							providerDetail.setValue(insertRowIdx, 'NOS', res.NOS);
							providerDetail.setValue(insertRowIdx, 'SEQS', res.SEQS);
							providerDetail.setValue(insertRowIdx, 'NETS', res.NETS);
							providerDetail.setValue(insertRowIdx, 'VATS', res.VATS);
							providerDetail.setValue(insertRowIdx, 'GRSS', res.GRSS);
							// 새로 추가한 row 의 다른 정보는 기존 변수 활용
							providerDetail.setValue(insertRowIdx, 'DVS', DVS);

							providerDetail.setRowState(insertRowIdx, 'none', true);

							let detailNewRow = providerDetail.addRow({});
							providerDetail.setValue(detailNewRow, 'NOS', res.NOS);
							providerDetail.setValue(detailNewRow, 'DVS', DVS);
							gridViewDetail.commit(true);
							gridViewDetail.setCurrent({itemIndex: providerDetail.getRowCount(), column: 'PCOD'});
							gridViewDetail.setFocus();

							console.log('after save detail row');
							let masterCurrent = gridViewMaster.getCurrent();
							let sumNETS = gridViewDetail.getSummary('NETS','sum');
							let sumVATS = gridViewDetail.getSummary('VATS','sum');
							let sumGRSS = gridViewDetail.getSummary('GRSS','sum');
							if (sumNETS && sumVATS && sumGRSS) {
								providerMaster.setValue(masterCurrent.dataRow, 'NET', sumNETS);
								providerMaster.setValue(masterCurrent.dataRow, 'VAT', sumVATS);
								providerMaster.setValue(masterCurrent.dataRow, 'GRS', sumGRSS);
								providerMaster.setRowState(masterCurrent.itemIndex, 'none', true);
								gridViewMaster.commit(true);
							}
						} else {
							alert('오류가 발생했습니다.');
						}

						// setDetailData(COD, DVS, NOS);
					})
					.always(function() {
						// console.log("complete");
						gridViewDetail.closeLoading();
						gridViewDetail.setCurrent();
					});
				}

				function updateRowDataDetail(PCOD, QTYS, NOS, SEQS, DSEQ, PRIC, REMK) {
					gridViewDetail.showLoading();
					$.ajax({
						url: '/manage/updateRowDataDetail',
						type: 'post',
						dataType: 'json',
						data: {
							CRUD: 'U'
							, PCOD: PCOD
							, QTYS: QTYS
							, NOS: NOS
							, SEQS: SEQS
							, DSEQ: DSEQ
							, PRIC: PRIC
							, REMK: REMK
							
							// 공통변수
							, DVS: DVS
							, COD: COD
						},
					})
					.done(function(res) {
						console.log("update row data detail.");
						if (res.CNT > 0) {
							// 정상처리됨
							let update = gridViewDetail.getCurrent();
							providerDetail.setValue(update.itemIndex, 'NETS', res.NETS);
							providerDetail.setValue(update.itemIndex, 'VATS', res.VATS);
							providerDetail.setValue(update.itemIndex, 'GRSS', res.GRSS);
							providerDetail.setRowState(update.itemIndex, 'none', true);

							console.log('after update detail row');
							let masterCurrent = gridViewMaster.getCurrent();
							let sumNETS = gridViewDetail.getSummary('NETS','sum');
							let sumVATS = gridViewDetail.getSummary('VATS','sum');
							let sumGRSS = gridViewDetail.getSummary('GRSS','sum');
							if (sumNETS && sumVATS && sumGRSS) {
								providerMaster.setValue(masterCurrent.dataRow, 'NET', sumNETS);
								providerMaster.setValue(masterCurrent.dataRow, 'VAT', sumVATS);
								providerMaster.setValue(masterCurrent.dataRow, 'GRS', sumGRSS);
								providerMaster.setRowState(masterCurrent.itemIndex, 'none', true);
								gridViewMaster.commit(true);
							}
						} else {
							alert('오류가 발생했습니다.');
						}
						// setDetailData(COD, DVS, NOS);
					})
					.always(function() {
						// console.log("complete");
						//gridViewDetail.setCurrent();
						gridViewDetail.closeLoading();
					});
					
				}

				function delRowDataDetail() {
					let provider = providerDetail;
					let gridView = gridViewDetail;
					let checked = gridView.getCheckedRows();
					let checkCnt = checked.length;
					let checkedCOD;
					let checkedDVS;
					let checkedNOS;
		            let checkedSEQS;

					if (checked.length < 1 || checked.length > 1) {
						alert('1개 항목을 선택해주세요.');
						return false;
					}

					checked.forEach(function(row, idx) {
						checkedCOD = provider.getValue(row, 'COD');
						checkedDVS = provider.getValue(row, 'DVS');
						checkedNOS = provider.getValue(row, 'NOS');
						checkedSEQS = provider.getValue(row, 'SEQS');
					});

					if (confirm('자료를 삭제합니다.')) {
						gridView.showLoading();
						$.ajax({
							url: '/manage/updateRowDataDetail',
							type: 'post',
							dataType: 'json',
							data: {
								CRUD: 'D'
								, COD: checkedCOD
								, DVS: checkedDVS
								, NOS: checkedNOS
								, SEQS: checkedSEQS
							},
						})
						.done(function(res) {
							// console.log("success");
							// let YM = DTS.substring(0, 4);
							setDetailData(COD, DVS, checkedNOS);
							setMasterData(DVS, COD, YM, DD);
							gridView.closeLoading();
						})
						.always(function(complete) {
							console.log("complete");
							console.log(complete);
							//gridViewDetail.setCurrent();
						});
					}
				}
			</script>
			<script src="/include/js/manage.js"></script>
		</div>
	</div>
</section>