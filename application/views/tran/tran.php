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
									<input type="text" class="input is-small p-1 datepicker monthpicker" name="YM" id="YM" size="5" value="<?=$YMF?>" readonly onchange="selectYM();">
								</p>
							</div>
							</script>
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
					<a class="button" onclick="openMakeEtaxTran();">전자발행</a>
					<a class="button mr-5">발행취소</a>
					<a class="button">도움</a>
					<a class="button" href="">검색</a>
					<a class="button" onclick="delTranData();">삭제</a>
					<a class="button">인쇄</a>
					<a class="button">복사이동</a>

					<a class="button" onclick="focusOut();">focus out</a>
				</div>
			</div>
		</div>
		<div>
			<div id="tran_grid" class="mb-4" style="width:100%;height:500px;"></div>
			
			<script>
				var providerTran, gridViewTran;
				var COD = '<?=$COD?>';
				var YM = '<?=$YM?>';
				var DD = '<?=$DD?>';
				var DVS = '';

				// modal 에서 값 입력 후 그리드 접근 위해
				var modalTargetGrid;
				var modalTargetIndex;
				var modalTargetProvider;

				var isInitData = false;

				document.addEventListener('DOMContentLoaded', function() {
					providerTran = new RealGrid.LocalDataProvider();
					gridViewTran = new RealGrid.GridView('tran_grid');
					gridViewTran.setDataSource(providerTran);
					gridViewTran.displayOptions.rowHeight = 30;
					gridViewTran.header.height = 36;
					gridViewTran.footer.height = 30;

					gridViewTran.checkBar.useImages = true;
					
					gridViewTran.setStateBar({
						visible: true,
						width:20,
					});


					gridViewTran.setCheckBar({
						visible: true,
						showAll: true,
						width: 40,
					});

					providerTran.setFields([
						{fieldName: 'COD'}
						, {fieldName: 'DVS'}
						, {fieldName: 'DTS'}
						, {fieldName: 'DTS_DD'}
						, {fieldName: 'TNO'}
						, {fieldName: 'TYP'}
						, {fieldName: 'GBN'}
						, {fieldName: 'CDS'}
						, {fieldName: 'NAM'}
						, {fieldName: 'NET', dataType: 'number'}
						, {fieldName: 'VAT', dataType: 'number'}
						, {fieldName: 'GRS', dataType: 'number'}
						, {fieldName: 'SRC'}
						, {fieldName: 'EBL'}
						, {fieldName: 'ENO'}
						// , {fieldName: 'NET', dataType: 'number'}
					]);

					// 필수값 DVS && DTSDD && TYP && GBN && CDS && NET && VAT

					let TranColumns = [
						{
							name: 'DVS'
							, fieldName: 'DVS'
							, width: 80
							, header: {text: '구분 *'}
							, editor: {type: 'dropdown', domainOnly: true, textReadOnly: false, partialMatch: true}
							, values: ['3', '4']
							, labels: ['3.매출', '4.매입']
							, lookupDisplay: true
						}
						, {name: 'DTS_DD', fieldName: 'DTS_DD', width: 50, styleName: 'align-center', header: {text: '일'}}
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
							, editable: true
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
						, {name: 'NAM', fieldName: 'NAM', editable: false, styleName: 'editable-false', width: 150, header: {text: '거래처명'}}
						, {name: 'TNO', fieldName: 'TNO', editable: false
							, styleName: 'editable-false align-center', width: 120
							, header: {text: '매입매출번호'}
							}
						, {
							name: 'NET'
							, fieldName: 'NET'
							, header: {text: '공급가액 *'}
							, styleName: 'align-right'
							, numberFormat: '#,##0'
						    ,  editor: {
							    type: "number",
							    textAlignment: "far",
							    //입력시 적용되는 포맷(소수점 최대 3자리까지만 입력 가능)
							    editFormat: "#,##0",
							    multipleChar: "+",
							 }
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
							, header: {text: '부가세액 *'}
							, styleName: 'align-right'
						    ,  editor: {
							    type: "number",
							    textAlignment: "far",
							    //입력시 적용되는 포맷(소수점 최대 3자리까지만 입력 가능)
							    editFormat: "#,##0",
							    multipleChar: "+",
							 }
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
						, {name: 'SRC', fieldName: 'SRC', editable: false
								, styleName: 'editable-false align-center'
								, visible: false
								, width: 0, header: {text: '입력'}}
						, {name: 'EBL', fieldName: 'EBL', editable: false
								, styleName: 'editable-false align-center'
								, width: 100, header: {text: '전자발행'}}
						, {name: 'ENO', fieldName: 'ENO', editable: false
								, styleName: 'editable-false align-center'
								, width: 100, header: {text: '발행번호'}}
					];

					
					gridViewTran.setColumns(TranColumns);

					// 최초 Tran 그리드 set
					setTranData(COD, YM, DD);

					// gridViewTran.showLoading();

					// Tran 그리드 행 선택
					gridViewTran.onCurrentRowChanged = function(grid, oldRow, newRow) {
						// console.log('check', oldRow, newRow);
						// console.log(grid);
						let COD = providerTran.getValue(newRow, 'COD');
						let DVS = providerTran.getValue(newRow, 'DVS');
						let DTS = providerTran.getValue(newRow, 'DTS');
						let TNO = providerTran.getValue(newRow, 'TNO');
						if (newRow < 0 || !TNO) return;
					}

					gridViewTran.onCellEdited = function(grid, itemIndex, row, field) {
						gridViewTran.commit(true);



						let current = gridViewTran.getCurrent();
						let thisValue = providerTran.getValue(current.dataRow, current.fieldName);

						let fld = current.fieldName;

						//유형
						let sTYP = providerTran.getValue(current.dataRow, "TYP");

						if (fld	== "NET")
						{
							let dNET = thisValue;
							let dVAT = 0;

							if (thisValue == "" || sTYP == "2"){
								dVAT = 0;
							}
							else {
								dVAT = thisValue * 0.1;
							};

							let dGRS = dNET + dVAT;

							gridViewTran.setValue(current.dataRow, 'VAT', dVAT);
							gridViewTran.setValue(current.dataRow, 'GRS', dGRS);

						};

						if (fld	== "VAT")
						{
							let dNET2 = providerTran.getValue(current.dataRow, 'NET');
							let dVAT2 = thisValue;

							if (dNET2 == ""){
								dVAT2 = 0;
							};
							
							let dGRS2 = dNET2 + dVAT2;

							gridViewTran.setValue(current.dataRow, 'GRS', dGRS2);
						};


						// let COD = providerTran.getValue(current.dataRow, 'COD');
						let DVS = providerTran.getValue(current.dataRow, 'DVS');
						let DTS = providerTran.getValue(current.dataRow, 'DTS');
						let DTSDD = providerTran.getValue(current.dataRow, 'DTS_DD');
						let TNO = providerTran.getValue(current.dataRow, 'TNO');
						let TYP = providerTran.getValue(current.dataRow, 'TYP');
						let GBN = providerTran.getValue(current.dataRow, 'GBN');
						let CDS = providerTran.getValue(current.dataRow, 'CDS');
						let NAM = providerTran.getValue(current.dataRow, 'NAM');
						let NET = providerTran.getValue(current.dataRow, 'NET');
						let VAT = providerTran.getValue(current.dataRow, 'VAT');
						let GRS = providerTran.getValue(current.dataRow, 'GRS');
						let SRC = providerTran.getValue(current.dataRow, 'SRC');
						let EBL = providerTran.getValue(current.dataRow, 'EBL');
						let ENO = providerTran.getValue(current.dataRow, 'ENO');

						NET = (NET == '') ? '0' : NET;
						VAT = (VAT == '') ? '0' : VAT;
						GRS = (GRS == '') ? '0' : GRS;

						// 발행구분 자동선택 
						if (TYP) {
							if (TYP == '1' || TYP == '2' || TYP == '7') GBN = '1';
							else GBN = '3';

							providerTran.setValue(current.dataRow, 'GBN', GBN);
						}


						if (Number(DTSDD) < 10) DTSDD = '0' + Number(DTSDD);

						if (!TNO && (DVS && DTSDD && TYP && GBN && CDS && NET && VAT)) {
							console.log('insert tran row');
							let ret = saveTranData(COD, DVS, (YM + DTSDD), TNO, TYP, GBN, CDS, NET, VAT);
							gridViewTran.commit(true);
						} else if (TNO && (DVS && DTSDD && TYP && GBN && CDS && NET && VAT)) {
							console.log('update tran row');
							let ret = updateTranData(COD, DVS, (YM + DTSDD), TNO, TYP, GBN, CDS, NET, VAT);
							gridViewTran.commit(true);
						}
					}

					gridViewTran.onCellButtonClicked = function(grid, column) {
						// console.log(grid, column);
						if (column.column == 'CDS') {
							OpenModalS(column.column);
						}
					};

					providerTran.onRowCountChanged = function(provider, count) {
						// 스크롤 최하단으로 설정, 그냥하면 setTopItem 이 안먹혀서 setTimeout 넣음
						setTimeout(function() {
							gridViewTran.setTopItem(count);
							if (!isInitData) {
								gridViewTran.setCurrent({itemIndex: count});
								gridViewTran.setFocus();
								isInitData = true;
							}
						}, 10);
					};



					//function key, enter key event
					gridViewTran.setEditOptions({
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


					//function key, enter key event
					gridViewTran.onKeyDown = function (grid, event) {
					    
						if (event.keyCode == 113) {

					    	// 구분필드에서 f2 를 눌렀으면
					    	if (gridViewTran.getCurrent().fieldName == "DVS" 
					    		|| gridViewTran.getCurrent().fieldName == "GBN"
					    		|| gridViewTran.getCurrent().fieldName == "TYP"){
					    		gridViewTran.showEditor(true);
					    		return true;		    		
					    	}
					    	else if (gridViewTran.getCurrent().fieldName == "CDS"){
					    		OpenModalS(gridViewTran.getCurrent().fieldName);
					    		return false;
					    	}
					    }

					    //유형

					};

				});
				
				function focusOut() {
					// gridViewTran.setCurrent({itemIndex: 0});
					gridViewTran.resetCurrent();
				}

				function OpenModalS(DIV){
				
					if (DIV == "CDS"){

						modalTargetGrid = gridViewTran;
						modalTargetIndex = gridViewTran.getCurrent().itemIndex;
						modalTargetProvider = providerTran;


						openModal('modal-CMPYCDS');
						setCmpyData(COD, '');

						document.getElementById('cndsearch').value = "";
						document.getElementById('cndsearch').focus();

					};

				}
				
				// data json 가져오기
				function setTranData(COD, YM, D) {
					gridViewTran.showLoading();
					$.ajax({
						url: '/tran/gridTranData/',
						type: 'post',
						dataType: 'json',
						data: {COD: COD, YM: YM, D: D},
					})
					.done(function(jsonData) {
						// console.log(jsonData);
						providerTran.fillJsonData(jsonData, {fillMode : 'set'});
						providerTran.addRow({});
						gridViewTran.commit(true);
						gridViewTran.closeLoading();
					})
					.always(function() {
						console.log('gridTranData complete');
					});
				}

				// Tran row 데이터 저장하기
				function saveTranData(COD, DVS, DTS, TNO, TYP, GBN, CDS, NET, VAT) {
					gridViewTran.showLoading();
					console.log('in saveTranData ajax', COD, DVS, DTS, TNO, TYP, GBN, CDS, NET, VAT);

					$.ajax({
						url: '/tran/updateTranData',
						type: 'post',
						dataType: 'json',
						data: {
							CRUD: 'C'
							, COD: COD
							, DVS: DVS
							, DTS: DTS
							, TNO: TNO
							, TYP: TYP
							, GBN: GBN
							, CDS: CDS
							, NET: NET
							, VAT: VAT
						},
					})
					.done(function(res) {
						// console.log(res);
						console.log("success saveTranData");
						if (res.CNT > 0) {
							let insertRowIdx = providerTran.getRowCount() - 1;
							// 프로시저에서 TNO 받아서 set 해줘야함
							providerTran.setValue(insertRowIdx, 'TNO', res.TNO);
							providerTran.setRowState(insertRowIdx, 'none', true);

							providerTran.addRow({});
						 	gridViewTran.commit(true);
							gridViewTran.setCurrent({itemIndex: providerTran.getRowCount(), column: 'DVS'});
						} else {
							alert('오류가 발생했습니다.');
						}
						// setTranData(COD, YM, DD);
					})
					.always(function(res) {
						gridViewTran.closeLoading();
					});
				}

				function updateTranData(COD, DVS, DTS, TNO, TYP, GBN, CDS, NET, VAT) {
					gridViewTran.showLoading();
					console.log('in updateTranData ajax', COD, DVS, DTS, TNO, TYP, GBN, CDS, NET, VAT);

					$.ajax({
						url: '/tran/updateTranData',
						type: 'post',
						dataType: 'json',
						data: {
							CRUD: 'U'
							, COD: COD
							, DVS: DVS
							, DTS: DTS
							, TNO: TNO
							, TYP: TYP
							, GBN: GBN
							, CDS: CDS
							, NET: NET
							, VAT: VAT
						},
					})
					.done(function(res) {
						// console.log(res);
						console.log("success updateTranData");
						if (res.CNT > 0) {
							// 정상처리됨.
							let update = gridViewTran.getCurrent();
							providerTran.setRowState(update.itemIndex, 'none', true);
						} else {
							alert('오류가 발생했습니다.');
						}
						// setTranData(COD, YM, DD);
					})
					.always(function(res) {
						gridViewTran.closeLoading();
					});
				}

				function delTranData() {
					let provider = providerTran;
					let gridView = gridViewTran;
					let checked = gridView.getCheckedRows();
					let checkCnt = checked.length;
					let checkedCOD;
					let checkedTNO;

					if (checked.length < 1 || checked.length > 1) {
						alert('1개 항목을 선택해주세요.');
						return false;
					}

					checked.forEach(function(row, idx) {
						checkedCOD = provider.getValue(row, 'COD');
						checkedTNO = provider.getValue(row, 'TNO');
					});



					if (confirm('자료를 삭제합니다.')) {
						gridView.showLoading();
						$.ajax({
							url: '/tran/updateTranData',
							type: 'post',
							dataType: 'json',
							data: {
								CRUD: 'D'
								, COD: checkedCOD
								, TNO: checkedTNO
							},
						})
						.done(function(res) {
							// console.log("success");
							// let YM = DTS.substring(0, 4);
							setTranData(COD, YM, DD);
						})
						.always(function(res) {
							gridView.closeLoading();
						});
					}
				}

				function openMakeEtaxTran() {
					let checked = gridViewTran.getCheckedRows();
					let checkCnt = checked.length;
					let checkedTNO;
					let checkedCDS;
					let checkedNET;
					let checkedVAT;
					let checkedGRS;
					let checkedDTS;
					let checkedENO;

					if (checked.length < 1) {
						alert('항목을 한개 이상 선택해주세요.');
						return false;
					}

					checkedTNO = '';
					checked.forEach(function(row, idx) {
						checkedTNO += (checkedTNO == '') ? providerTran.getValue(row, 'TNO') : ',' + providerTran.getValue(row, 'TNO');
					});

					if (checkedENO) {
						alert('이미 발행된 건입니다.');
						return false;
					}

					openModal('modal-ETAX');
					setEtaxData(COD, checkedTNO);
				}

				// etax modal 데이터 가져오기
				// data json 가져오기
				function setEtaxData(COD, TNO) {
					gridViewEtax.showLoading();
					$.ajax({
						url: '/tran/gridEtaxData/',
						type: 'post',
						dataType: 'json',
						data: {COD: COD, TNO: TNO},
					})
					.done(function(jsonData) {
						// console.log(jsonData);
						providerEtax.fillJsonData(jsonData, {fillMode : 'set'});
						gridViewEtax.commit(true);
						gridViewEtax.closeLoading();
					})
					.always(function() {
						console.log('gridTranData complete');
					});
				}
				
			</script>
		</div>
	</div>
</section>