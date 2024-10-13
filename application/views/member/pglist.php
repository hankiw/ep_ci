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
									<input class="input is-small p-1" id="SCH" type="text" name="SCH" placeholder="" size="5" maxlength="20" onKeyPress="if( event.keyCode==13 ){setPgData();}">
								</p>
							</div>
						</div>
					</div>
				</form>
			</div>


			<div class="level-right">
				<div class="buttons are-small">
					<a class="button">도움</a>
					<a class="button" onclick="setPgData();">검색</a>
					<a class="button" onclick="delPgData();">삭제</a>
				</div>
			</div>
		</div>
		
		

		<div>
			<div id="pg_grid" class="mb-4" style="width:100%;height:700px;"></div>
			
			<script>
				var providerPg, gridViewPg;

				// modal 에서 값 입력 후 그리드 접근 위해
				var modalTargetGrid;
				var modalTargetIndex;
				var modalTargetProvider;

				// alert("1122");

				document.addEventListener('DOMContentLoaded', function() {
					providerPg = new RealGrid.LocalDataProvider();
					gridViewPg = new RealGrid.GridView('pg_grid');
					gridViewPg.setDataSource(providerPg);
					gridViewPg.displayOptions.rowHeight = 30;
					gridViewPg.header.height = 36;
					gridViewPg.footer.height = 30;

					//selectionStyle의 속성중 style을 block로 지정하면 선택 영역을 여러 블럭으로 지정할 수 있습니다.
					gridViewPg.displayOptions.selectionMode = "extended";
					gridViewPg.displayOptions.selectionStyle = "block";

					gridViewPg.setCopyOptions({
						singleMode: false,
						enabled: true
					});

					gridViewPg.setEditOptions({
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
					
					gridViewPg.setPasteOptions({
					    singleMode: false,
					    enabled: true,
					    startEdit: false,
					    commitEdit: false,  //false 일 경우 provider.onRowUpdated 가 줄바뀜 되었을 경우 발생한다.
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

					gridViewPg.rowIndicator.footText = "";
					gridViewPg.checkBar.useImages = true;

					gridViewPg.setCheckBar({
						visible: true,
						showAll: true,
						width: 40,
					});
					
					gridViewPg.setStateBar({
						visible: true,
						width:20,
					});

					// 단순조회물, 풋터는 표시하지 않는다.
					gridViewPg.setFooters({
					  	visible: false
					});
					
					providerPg.setFields([
						  {fieldName: 'COD', dataType: 'text'}
						, {fieldName: 'PGCD_SAVED', dataType: 'text'}
						, {fieldName: 'PGCD', dataType: 'text'}
						, {fieldName: 'PGNM', dataType: 'text'}
						, {fieldName: 'SDT', dataType: 'text'}
						, {fieldName: 'EDT', dataType: 'text'}

						// , {fieldName: 'NET', dataType: 'number'}
					]);

					//구분 1:제품 2:상품 3:비용 4:기타
					//partialMatch : 부분 문자열만 일치하더라도 검색하여 선택할 수 있습니다
					let pgcoLumns = [
						 {name: 'PGCD_SAVED',  fieldName: 'PGCD_SAVED',  visible: false, editable: false, width: 0, header: {text: ''}} 
						,{name: 'PGCD'      ,  fieldName: 'PGCD'      ,  editable: true,  width: 150, header: {text: '품목군코드 *'}}
						,{name: 'PGNM'       ,  fieldName: 'PGNM'		  ,  editable: true,  width: 150, header: {text: '품목군 *'}}
						,{
							name: 'SDT'
							, fieldName: 'SDT'
							, editor: {
								type: 'date'
								, datetimeFormat: 'yyyy-MM-dd'
								, mask: {
									editMask: '9999-99-99'
									, placeHolder: 'yyyy-MM-dd'
									, includedFormat: true
								}
							}
							, textFormat: '([0-9]{4})([0-9]{2})([0-9]{2})$;$1-$2-$3'
							, width: 150
							, header: {text: '조회시작일'}

							}
						, {
							name: 'EDT'
							, fieldName: 'EDT'
							, editor: {
								type: 'date'
								, datetimeFormat: 'yyyy-MM-dd'
								, mask: {
									editMask: '9999-99-99'
									, placeHolder: 'yyyy-MM-dd'
									, includedFormat: true
								}
							}
							, textFormat: '([0-9]{4})([0-9]{2})([0-9]{2})$;$1-$2-$3'
							, width: 150
							, header: {text: '조회종료일'}
						}
					];

					
					gridViewPg.setColumns(pgcoLumns);

					// 최초 Pg 그리드 set
					setPgData();

					// gridViewPg.showLoading();

					// Pg 그리드 행 선택
					gridViewPg.onKeyDown = function (grid, event) {
					    if (event.keyCode == 113) {
							// 구분필드에서 f2 를 눌렀으면
					    	if (gridViewPg.getCurrent().fieldName == "SDT" || gridViewPg.getCurrent().fieldName == "EDT"){
					    		gridViewPg.showEditor(true);
					    	}
					    }
					};	

/*
					gridViewPg.onShowEditor = function (grid, index, props, attrs) {
					    
					    // 엔터키, 마지막필드이고 다음행이 존재하면 이동하게 처리함
					    if (index.fieldName == "PGCD") {
							
							

					    }

					    //return true;		    		

					};	
*/				

					gridViewPg.onEditRowChanged = function (grid, itemIndex, dataRow, field, oldValue, newValue) {
						//// edit 상태라 커밋하고 저장처리합ㄴ다.
						//gridViewPg.commit(true);
						saveData(itemIndex);
						//providerPg.commit(true);
					};

					gridViewPg.onRowsPasted =  function (grid, items) {
    					
    					//alert("붙여넣기된 행들 : " + items.length);

						// 변경된 행의 카운트 확인
						var ucount = providerPg.getRowStateCount('updated');
						var ccount = providerPg.getRowStateCount('created');

						if (ucount < 1 && ccount < 1) {
							//alert("returned")
							return;
						}

						gridViewPg.commit(true);

					    var i = 0;

					    while (i<items.length) {
							saveData(items[i]);
					      	i++;
					    }

						gridViewPg.commit(true);

						// RowState 삭제
						providerPg.clearRowStates(true, true);
					};
					


					
					gridViewPg.onPasted = function (grid){

					    //alert("onPasted");
						
						// 변경된 행의 카운트 확인
						gridViewPg.commit(true);

						var ucount = providerPg.getRowStateCount('updated');
						var ccount = providerPg.getRowStateCount('created');

						if (ucount < 1 && ccount < 1) {
							//alert("returned")
							return;
						}

						saveData(gridViewPg.getCurrent().itemIndex);

						gridViewPg.commit(true);

					}
					

					function saveData(findex){

						gridViewPg.commit(true);

						let PGCD_SAVED = providerPg.getValue(findex,'PGCD_SAVED');
							
						let PGCD       = providerPg.getValue(findex,'PGCD'      );
						let PGNM       = providerPg.getValue(findex,'PGNM'      );
						let SDT        = providerPg.getValue(findex,'SDT'       );
						let EDT        = providerPg.getValue(findex,'EDT'       );
						
						//alert(PGCD);
						//alert(PGCD);
						//alert(PGNM);

						if (!PGCD_SAVED && (PGNM)) {
							console.log('111:' + PGCD_SAVED);
						 	let ret = savePgData(PGCD_SAVED, PGCD, PGNM, SDT, EDT);

						} else if (PGCD_SAVED && (PGNM)) {
							console.log('2222:' + PGCD_SAVED);
						 	providerPg.setRowState(findex, 'none', true);
						 	let ret = updatePgData(PGCD_SAVED, PGCD, PGNM, SDT, EDT);
						}

					}

					providerPg.onRowCountChanged = function(provider, count) {
						// 스크롤 최하단으로 설정, 그냥하면 setTopItem 이 안먹혀서 setTimeout 넣음
						
						setTimeout(function() {
						 	gridViewPg.setTopItem(count);
						}, 10);
					};
				});
				
				// data json 가져오기
				function setPgData() {

					gridViewPg.showLoading();

					let SCH = document.getElementById('SCH').value;

					$.ajax({
						url: '/member/gridPgData/',
						type: 'post',
						dataType: 'json',
						data: {SCH: SCH},
					})
					.done(function(jsonData) {
						console.log(jsonData);
						providerPg.fillJsonData(jsonData, {fillMode : 'set'});
						//////////////////////////providerPg.addRow({});
						////////////////gridViewPg.commit(true);
						providerPg.addRow({});
						gridViewPg.commit(true);

						gridViewPg.setCurrent({itemIndex: providerPg.getRowCount(), column: 'PGCD'});
						gridViewPg.setFocus();

					})
					.always(function() {
						console.log('gridPgData complete');
						////////////////gridViewPg.commit(true);
						gridViewPg.closeLoading();


					});
				}

				// Pg row 데이터 저장하기
				function savePgData(PGCD_SAVED, PGCD, PGNM, SDT, EDT) {
					gridViewPg.showLoading();
					// console.log('in savePgData ajax', PGCD_SAVED, PGCD, PGNM, SDT, EDT);

					$.ajax({
						url: '/member/updatePgData',
						type: 'post',
						dataType: 'json',
						data: {
							CRUD: 'C'
							, PGCD_SAVED: PGCD_SAVED
							, PGCD		: PGCD
							, PGNM		: PGNM
							, SDT		: SDT
							, EDT		: EDT
						},
					})
					.done(function(res) {
						// console.log(res);
						// console.log("success savePgData");
						if (res.CNT > 0) {
							let insertRowIdx = providerPg.getRowCount() - 1;
							providerPg.setValue(insertRowIdx, 'PGCD_SAVED', res.PGCD_SAVED);
							providerPg.setRowState(insertRowIdx, 'none', true);
							
							providerPg.addRow({});
						 	gridViewPg.commit(true);
							//gridViewPg.setCurrent({itemIndex: providerPg.getRowCount(), column: 'PGCD'});
						} else {
							alert('오류가 발생했습니다1.');
						}

					})
					.fail(function(res) {
						let errorText = sqlErrorMsg(res.responseText);
						alert(errorText);
					})
					.always(function(res) {
						console.log(res);
						gridViewPg.closeLoading();
					});
				}

				function updatePgData(PGCD_SAVED, PGCD, PGNM, SDT, EDT) {
					gridViewPg.showLoading();
					// console.log('in updatePgData ajax', PGCD_SAVED, PGCD, PGNM, SDT, EDT);
					//alert(PGNM);

					$.ajax({
						url: '/member/updatePgData',
						type: 'post',
						dataType: 'json',
						data: {
							CRUD: 'U'
							, PGCD_SAVED: PGCD_SAVED
							, PGCD		: PGCD
							, PGNM		: PGNM
							, SDT		: SDT
							, EDT		: EDT
						},
					})
					.done(function(res) {
						// console.log("success");
						// let YM = DTS.substring(0, 4);
						
						if (res.CNT > 0) {
							// 정상
						} else {
							// 오류
							alert('오류가 발생했습니다2.');
						}
					})
					.fail(function(res) {
						let errorText = sqlErrorMsg(res.responseText);
						alert(errorText);
					})
					.always(function(complete) {
						console.log("complete");
						gridViewPg.closeLoading();
					});
				}

				function delPgData() {
					let provider = providerPg;
					let gridView = gridViewPg;
					let checked = gridView.getCheckedRows();
					let checkCnt = checked.length;
					let checkedPGCD_SAVED;

					if (checked.length < 1 ) {
						alert('1개 이상의 항목을 선택해주세요.');
						return false;
					}

					
					//alert(checkedPGCD_SAVED);

					if (confirm('자료를 삭제합니다.')) {


						if (checked.length >= 1) {
							checked.forEach(function(row, idx) {
								checkedPGCD_SAVED += ',' + provider.getValue(row, 'PGCD_SAVED');
							})
						};

						//alert(checkedSEQ);

						gridView.showLoading();
						$.ajax({
							url: '/member/updatePgData',
							type: 'post',
							dataType: 'json',
							data: {
								CRUD: 'D'
								, PGCD_SAVED: checkedPGCD_SAVED
							},
						})
						.done(function(res) {
							// console.log("success");
							// let YM = DTS.substring(0, 4);
							// setPgData();

							if (res.CNT > 0) {
								setPgData();
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
	
					
					};


				}

				
			</script>
		</div>
	</div>
</section>