<!-- 리얼그리드 테마 css -->
<link href="<?=INC_JS_URL?>realgrid.2.6.2/realgrid-sky-blue.css" rel="stylesheet" />
<!-- 리얼그리드 커스컴 수정사항 css -->
<link href="<?=INC_JS_URL?>realgrid.2.6.2/realgrid-custom.css" rel="stylesheet" />
<script src="<?=INC_JS_URL?>realgrid.2.6.2/realgrid-lic.js"></script>
<script src="<?=INC_JS_URL?>realgrid.2.6.2/realgrid.2.6.2.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<section class="section p-4">
	<div class="container pt-5">
		<h1 class="title mb-4 is-size-5-desktop is-size-6-tablet is-size-6-mobile"><?=$page_title?></h1>
		<!-- <h2 class="subtitle">입고 품목 관리</h2> -->
		
		<div class="level mb-4">
			<div class="level-left">
				<form id="select_condition" name="select_condition" onSubmit="return false">
					<div class="field is-horizontal">
						<div class="field-label is-small mr-2" style="width:120px;">
							<label class="label">검색</label>
						</div>
						<div class="field-body">
							<div class="field">
								<p class="control is-expanded has-icons-left">
									<input class="input is-small p-1" id="SCH" type="text" name="SCH" placeholder="" size="5" maxlength="20" onKeyPress="if( event.keyCode==13 ){setCodsData();}">
								</p>
							</div>
						</div>
					</div>
				</form>
			</div>


			<div class="level-right">
				<div class="buttons are-small">
					<a class="button">도움</a>
					<a class="button" onclick="setCodsData();">검색</a>
					<a class="button" onclick="delCodsData();">삭제</a>
				</div>
			</div>
		</div>
		
		

		<div>
			<div id="cods_grid" class="mb-4" style="width:100%;height:700px;"></div>
			
			<script>
				var providerCods, gridViewCods;


				// modal 에서 값 입력 후 그리드 접근 위해
				var modalTargetGrid;
				var modalTargetIndex;
				var modalTargetProvider;

				var isInitData = false;
				
				// alert("1122");

				document.addEventListener('DOMContentLoaded', function() {
					providerCods = new RealGrid.LocalDataProvider();
					gridViewCods = new RealGrid.GridView('cods_grid');
					gridViewCods.setDataSource(providerCods);
					gridViewCods.displayOptions.rowHeight = 30;
					gridViewCods.header.height = 36;
					gridViewCods.footer.height = 30;

					//selectionStyle의 속성중 style을 block로 지정하면 선택 영역을 여러 블럭으로 지정할 수 있습니다.
					gridViewCods.displayOptions.selectionMode = "extended";
					gridViewCods.displayOptions.selectionStyle = "block";
					gridViewCods.setCopyOptions({
					  singleMode: false,
					  enabled: true
					});

					gridViewCods.setEditOptions({
					insertable :true,
					appendable :true,
					commitByCell: false,
					//commitWhenExitLast: true,
					//enterToNextRow: true,
					enterToTab: true,
					skipReadOnly: true,
					//skipReadOnlyCell: true,
					crossWhenExitLast:true,
					commitWhenLeave:true,
					});
					
					gridViewCods.setPasteOptions({
					    singleMode: false,
					    enabled: true,
					    startEdit: false,
					    commitEdit: false,
					    enableAppend: false,
					    fillFieldDefaults: false,
					    fillColumnDefaults: false,
					    forceRowValidation: false,
					    forceColumnValidation: false,
					    selectionBase: false,
					    stopOnError: false,
					    noEditEvent: false,
					    eventEachRow: false,
					    checkReadOnly: false,
					    checkDomainOnly: false,
					    convertLookupLabel: false,
					  });
					
					gridViewCods.rowIndicator.footText = "";

					
					gridViewCods.checkBar.useImages = true;

					gridViewCods.setCheckBar({
						visible: true,
						showAll: true,
	
						width: 40,
					});
					
					gridViewCods.setStateBar({
						visible: false,
						width:20,
					});



					// 단순조회물, 풋터는 표시하지 않는다.
					gridViewCods.setFooters({
					  	visible: false
					});



					providerCods.setFields([
						  {fieldName: 'COD'}
						, {fieldName: 'CDS'}
						, {fieldName: 'NAM'}
						, {fieldName: 'SNO'}
						, {fieldName: 'JNO'}
						, {fieldName: 'OWN'}
						, {fieldName: 'ZIP'}
						, {fieldName: 'ADR1'}
						, {fieldName: 'ADR2'}
						, {fieldName: 'TYP'}
						, {fieldName: 'KND'}
						, {fieldName: 'MGR1'}
						, {fieldName: 'MGR2'}
						, {fieldName: 'EML1'}
						, {fieldName: 'EML2'}
						, {fieldName: 'SDT', dataType: 'text'}
						, {fieldName: 'EDT', dataType: 'text'}
						// , {fieldName: 'NET', dataType: 'number'}
					]);

					let CodsColumns = [
						  {name: 'CDS',  fieldName: 'CDS',  editable: false, width: 50, header: {text: '코드'}}
						, {name: 'NAM',  fieldName: 'NAM',  editable: true, styleName: 'editable-true', width: 150, header: {text: '상호 *'}}
						, {name: 'SNO',  fieldName: 'SNO',  editable: true, styleName: 'editable-true'
						   , editor: { mask: { editMask: '000-00-00000', allowEmpty: true } }
						   , textFormat: '([0-9]{3})([0-9]{2})([0-9]{5});$1-$2-$3'
						   , width: 100, header: {text: '사업자번호'}}
						, {name: 'JNO',  fieldName: 'JNO',  editable: true, styleName: 'editable-true'
						   , editor: { mask: { editMask: '000000-0000000', allowEmpty: true} }
						   , textFormat: '([0-9]{6})([0-9]{7});$1-$2'
						   , width: 120, header: {text: '주민번호'}

						  }

						, {name: 'OWN',  fieldName: 'OWN',  editable: true, styleName: 'editable-true', width: 60, header: {text: '대표자'}}
						, {name: 'ZIP',  fieldName: 'ZIP',  editable: true, styleName: 'editable-true', width: 70, header: {text: '우편번호'}}
						, {name: 'ADR1', fieldName: 'ADR1', editable: true, styleName: 'editable-true', width: 150, header: {text: '주소'}}
						, {name: 'ADR2', fieldName: 'ADR2', editable: true, styleName: 'editable-true', width: 100, header: {text: '상세주소'}}
						, {name: 'TYP',  fieldName: 'TYP',  editable: true, styleName: 'editable-true', width: 80, header: {text: '업태'}}
						, {name: 'KND',  fieldName: 'KND',  editable: true, styleName: 'editable-true', width: 80, header: {text: '종목'}}
						, {name: 'MGR1', fieldName: 'MGR1', editable: true, styleName: 'editable-true', width: 60, header: {text: '담당자'}}
						, {name: 'EML1', fieldName: 'EML1', editable: true, styleName: 'editable-true', width: 150, header: {text: '이메일'}}
						, {name: 'MGR2', fieldName: 'MGR2', editable: true, styleName: 'editable-true', width: 60, header: {text: '담당자2'}}
						, {name: 'EML2', fieldName: 'EML2', editable: true, styleName: 'editable-true', width: 150, header: {text: '이메일2'}}
						, {
							name: 'SDT'
							, fieldName: 'SDT'
							, editor: {
								type: 'date'
								, datetimeFormat: 'yyyy-MM-dd'
								, mask: {
									editMask: '9999-99-99'
									,placeHolder: 'yyyy-MM-dd'
									,includedFormat: true
								}
							}
							, textFormat: '([0-9]{4})([0-9]{2})([0-9]{2})$;$1-$2-$3'
							, width: 150
							, header: {text: '거래시작일'}

							}
						, {
							name: 'EDT'
							, fieldName: 'EDT'
							, editor: {
								type: 'date'
								, datetimeFormat: 'yyyy-MM-dd'
								, mask: {
									editMask: '9999-99-99'
									,placeHolder: 'yyyy-MM-dd'
									,includedFormat: true
								}
							}
							, textFormat: '([0-9]{4})([0-9]{2})([0-9]{2})$;$1-$2-$3'
							, width: 150
							, header: {text: '거래종료일'}
							}
					];

					gridViewCods.setColumns(CodsColumns);



					// 최초 Cods 그리드 set
					setCodsData();

					// gridViewCods.showLoading();

					// Cods 그리드 행 선택
					gridViewCods.onCurrentRowChanged = function(grid, oldRow, newRow) {
						// console.log('check', oldRow, newRow);
						// console.log(grid);

						let CDS = providerCods.getValue(newRow, 'CDS');

						if (newRow < 0 || !CDS) return;
					}



					gridViewCods.onKeyDown = function (grid, event) {
					    
					    // 엔터키, 마지막필드이고 다음행이 존재하면 이동하게 처리함
					    if (event.keyCode == 13) {

					    	/*
					    	var nowR = gridViewCods.getCurrent().itemIndex;
					    	var maxR = providerCods.getRowCount() - 1;
					    	var maxCN = providerCods.getFieldName(providerCods.getFieldIndex("EDT"));
					    	var nowCN = gridViewCods.getCurrent().fieldName;

					    	if (nowR < maxR && maxCN == nowCN)
					    	{
					    		gridViewCods.setCurrent({ itemIndex: nowR+1, column: 'NAM' });
					    	} 
					    	*/

					    // f2키, 특정필드의 경우 editor 를 true 로 오픈합니다.
					    } else if (event.keyCode == 113) {

					    	// 구분필드에서 f2 를 눌렀으면
					    	if (gridViewCods.getCurrent().fieldName == "SDT" || gridViewCods.getCurrent().fieldName == "EDT"){
					    		gridViewCods.showEditor(true);
					    	}
					    }


					    return true;		    		

					};	

					gridViewCods.onEditRowChanged = function (grid, itemIndex, dataRow, field, oldValue, newValue) {
					    						// edit 상태라 커밋하고 저장처리합ㄴ다.
						//gridViewCods.commit(true);

						saveData(itemIndex);

						//gridViewCods.commit(true);
						//providerCods.commit(true);


					};
					
					gridViewCods.onRowsPasted =  function (grid, items) {

					    //alert("붙여넣기된 행들 : " + items.length);

						// 변경된 행의 카운트 확인
						var ucount = providerCods.getRowStateCount('updated');
						var ccount = providerCods.getRowStateCount('created');

						if (ucount < 1 && ccount <1)
						{
							//alert("returned")
							return;
						}
						
						gridViewCods.commit(true);

						var i = 0;

					    while (i<items.length){

							saveData(items[i]);

					      	i++;

						}

						gridViewCods.commit(true);
						// RowState 삭제
						gridViewCods.clearRowStates(true, true);

					};
					
					gridViewCods.onPasted = function (grid){


					    //alert("onPasted");
						gridViewCods.commit(true);
						
						// 변경된 행의 카운트 확인
						var ucount = providerCods.getRowStateCount('updated');
						var ccount = providerCods.getRowStateCount('created');

						if (ucount < 1 && ccount <1)
						{
							//alert("returned")
							return;
						}


						saveData(gridViewCods.getCurrent().itemIndex);

						gridViewCods.commit(true);


					};
					

					function saveData(findex){

						//alert(findex);
						gridViewCods.commit(true);
						

						let CDS  = providerCods.getValue(findex,'CDS');
						let NAM  = providerCods.getValue(findex,'NAM');
						let SNO	 = providerCods.getValue(findex,'SNO');
						let JNO	 = providerCods.getValue(findex,'JNO');
						let OWN	 = providerCods.getValue(findex,'OWN');
						let ZIP	 = providerCods.getValue(findex,'ZIP');
						let ADR1 = providerCods.getValue(findex,'ADR1');
						let ADR2 = providerCods.getValue(findex,'ADR2');
						let TYP	 = providerCods.getValue(findex,'TYP');
						let KND	 = providerCods.getValue(findex,'KND');
						let MGR1 = providerCods.getValue(findex,'MGR1');
						let EML1 = providerCods.getValue(findex,'EML1');
						let MGR2 = providerCods.getValue(findex,'MGR2');
						let EML2 = providerCods.getValue(findex,'EML2');
						let SDT	 = providerCods.getValue(findex,'SDT');
						let EDT	 = providerCods.getValue(findex,'EDT');


						//alert(NAM);

						if (!CDS && (NAM)) {
							//console.log('insert cods row');

							//alert("saveCodsData");

						 	let ret = saveCodsData(CDS, NAM, SNO, JNO, OWN, ZIP, ADR1, ADR2, TYP, KND, MGR1, EML1, MGR2, EML2, SDT, EDT);
						} else if (CDS && (NAM)) {
						 	//console.log('update cods row');

							//alert("updateCodsData");
							providerCods.setRowState(findex, 'none', true);
						 	let ret = updateCodsData(CDS, NAM, SNO, JNO, OWN, ZIP, ADR1, ADR2, TYP, KND, MGR1, EML1, MGR2, EML2, SDT, EDT);
						}

					}

					gridViewCods.onCellButtonClicked = function(grid, column) {
						// console.log(grid, column);
						// if (column.column == 'CDS') {
						// 	modalTargetGrid = grid;
						// 	modalTargetIndex = column.itemIndex;
						// 	modalTargetProvider = providerCods;
						// 	// openModal('modal-CMPYCDS');
						// 	// setCmpyData(COD, '');
						// }
					};

					providerCods.onRowCountChanged = function(provider, count) {
						// 스크롤 최하단으로 설정, 그냥하면 setTopItem 이 안먹혀서 setTimeout 넣음
						//setTimeout(function() {
						// 	if (!isInitData) {
						// 		gridViewCods.setTopItem(count);
						// 		gridViewCods.setCurrent({itemIndex: count});
						// 		gridViewCods.setFocus();
						// 		isInitData = true;
						// 	}
						//}, 10);

						setTimeout(function() {
						 		gridViewCods.setTopItem(count);
						}, 10);

					};
				});
				
				// data json 가져오기
				function setCodsData() {

					//alert("setData");


					gridViewCods.showLoading();

					let SCH = document.getElementById('SCH').value;

					// 2행까지 고정처리
					gridViewCods.setFixedOptions({
  						colCount: 2
					});

					//alert(gridViewCods.getStyles("checkBar").checkImageUrl);
					//console.log(gridViewCods.getStyles("checkBar").checkImageUrl);

					$.ajax({
						url: '/member/gridCodsData/',
						type: 'post',
						dataType: 'json',
						data: {SCH: SCH},
					})
					.done(function(jsonData) {
						console.log(jsonData);
						providerCods.fillJsonData(jsonData, {fillMode : 'set'});
						providerCods.addRow({});
						gridViewCods.commit(true);
						
						gridViewCods.setCurrent({itemIndex: providerCods.getRowCount(), column: 'CDS'});
						gridViewCods.setFocus();
					})
					.always(function() {
						console.log('complete gridCodsData');
						//gridViewCods.commit(true);
						gridViewCods.closeLoading();
						//let rcnt = providerCods.getRowCount()-1;
						//gridViewCods.setCurrent({itemIndex:rcnt});
						//gridViewCods.setFocus();
					});
				}

				// Cods row 데이터 저장하기
				function saveCodsData(CDS, NAM, SNO, JNO, OWN, ZIP, ADR1, ADR2, TYP, KND, MGR1, EML1, MGR2, EML2, SDT, EDT) {
					gridViewCods.showLoading();
					console.log('in saveCodsData ajax', CDS, NAM, SNO, JNO, OWN, ZIP, ADR1, ADR2, TYP, KND, MGR1, EML1, MGR2, EML2, SDT, EDT);

					$.ajax({
						url: '/member/updateCodsData',
						type: 'post',
						//dataType: 'json',
						data: {
							CRUD: 'C'
							, CDS: ''
							, NAM: NAM
							, SNO: SNO
							, JNO: JNO
							, OWN: OWN
							, ZIP: ZIP
							, ADR1: ADR1
							, ADR2: ADR2
							, TYP: TYP
							, KND: KND
							, MGR1: MGR1
							, EML1: EML1
							, MGR2: MGR2
							, EML2: EML2
							, SDT: SDT
							, EDT: EDT
						},
					})
					.done(function(res) {
						// console.log(res);
						console.log("success saveCodsData");
						//setCodsData();

						if (res.CNT > 0) {
							let insertRowIdx = providerCods.getRowCount() - 1;
							providerCods.setValue(insertRowIdx, 'CDS', res.CDS);
							providerCods.setRowState(insertRowIdx, 'none', true);

							providerCods.addRow({});
						 	gridViewCods.commit(true);
							//gridViewUser.setCurrent({itemIndex: providerUser.getRowCount(), column: 'UID'});
						} else {
							alert('오류가 발생했습니다.');
						}
					})
					.fail(function(res) {
						let errorText = sqlErrorMsg(res.responseText);
						alert(errorText);
					})
					.always(function(complete) {
						// console.log(res);
						gridViewCods.closeLoading();
					});
				}

				function updateCodsData(CDS, NAM, SNO, JNO, OWN, ZIP, ADR1, ADR2, TYP, KND, MGR1, EML1, MGR2, EML2, SDT, EDT) {
					gridViewCods.showLoading();
					console.log('in updateCodsData ajax', CDS, NAM, SNO, JNO, OWN, ZIP, ADR1, ADR2, TYP, KND, MGR1, EML1, MGR2, EML2, SDT, EDT);

					$.ajax({
						url: '/member/updateCodsData',
						type: 'post',
						dataType: 'json',
						data: {
							CRUD: 'U'
							, CDS: CDS
							, NAM: NAM
							, SNO: SNO
							, JNO: JNO
							, OWN: OWN
							, ZIP: ZIP
							, ADR1: ADR1
							, ADR2: ADR2
							, TYP: TYP
							, KND: KND
							, MGR1: MGR1
							, EML1: EML1
							, MGR2: MGR2
							, EML2: EML2
							, SDT: SDT
							, EDT: EDT
						},
					})
					.done(function(res) {
						
						console.log(res.CNT);
						console.log("success updateCodsData");

						if (res.CNT > 0) {
							// 정상
						} else {
							// 오류
							alert('오류가 발생했습니다.');
						}
					})
					.fail(function(res) {
						let errorText = sqlErrorMsg(res.responseText);
						alert(errorText);
					})
					.always(function(complete) {
						console.log("complete updateCodsData");
						gridViewCods.closeLoading();
					});
				}

				function delCodsData() {
					let provider = providerCods;
					let gridView = gridViewCods;
					let checked = gridView.getCheckedRows();
					let checkCnt = checked.length;
					let checkedCDS;

					if (checked.length < 1 ) {
						alert('1개 이상의 항목을 선택해주세요.');
						return false;
					}

					if (confirm('자료를 삭제합니다.')) {

						checked.forEach(function(row, idx) {
							checkedCDS += ',' + provider.getValue(row, 'CDS');
						});

						gridView.showLoading();
						$.ajax({
							url: '/member/updateCodsData',
							type: 'post',
							dataType: 'json',
							data: {
								CRUD: 'D'
								, CDS: checkedCDS
							},
						})
						.done(function(res) {
							// console.log("success");
							// let YM = DTS.substring(0, 4);
							
							if (res.CNT > 0) {
								setCodsData();
							} else {
								alert('오류가 발생했습니다1.');
							}
						})
						.fail(function(res) {
							let errorText = sqlErrorMsg(res.responseText);
							alert(errorText);
						})
						.always(function(complete) {
							console.log("complete");
							gridView.closeLoading();
						});
					}
				}

				
			</script>
		</div>
	</div>
</section>