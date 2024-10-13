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
									<input class="input is-small p-1" id="SCH" type="text" name="SCH" placeholder="" size="5" maxlength="20" onKeyPress="if( event.keyCode==13 ){setUserData();}">
								</p>
							</div>
						</div>
					</div>
				</form>
			</div>


			<div class="level-right">
				<div class="buttons are-small">
					<a class="button">도움</a>
					<a class="button" onclick="setUserData();">검색</a>
					<a class="button" onclick="delUserData();">삭제</a>
				</div>
			</div>
		</div>
		

		<div>
			<div id="user_grid" class="mb-4" style="width:100%;height:700px;"></div>
			
			<script>
				var providerUser, gridViewUser;


				// modal 에서 값 입력 후 그리드 접근 위해
				var modalTargetGrid;
				var modalTargetIndex;
				var modalTargetProvider;

				// alert("1122");

				document.addEventListener('DOMContentLoaded', function() {
					providerUser = new RealGrid.LocalDataProvider();
					gridViewUser = new RealGrid.GridView('user_grid');
					gridViewUser.setDataSource(providerUser);
					gridViewUser.displayOptions.rowHeight = 30;
					gridViewUser.header.height = 36;
					gridViewUser.footer.height = 30;


					//selectionStyle의 속성중 style을 block로 지정하면 선택 영역을 여러 블럭으로 지정할 수 있습니다.
					gridViewUser.displayOptions.selectionMode = "extended";
					gridViewUser.displayOptions.selectionStyle = "block";
					gridViewUser.setCopyOptions({
						singleMode: false,
						enabled: true
					});

					gridViewUser.setEditOptions({
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

					gridViewUser.setPasteOptions({
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

					gridViewUser.rowIndicator.footText = "";
					

					gridViewUser.checkBar.useImages = true;

					gridViewUser.setCheckBar({
						visible: true,
						showAll: true,
	
						width: 40,
					});
					
					gridViewUser.setStateBar({
						visible: true,
						width:20,
					});





					// 단순조회물, 풋터는 표시하지 않는다.
					gridViewUser.setFooters({
					  	visible: false
					});

					
					providerUser.setFields([
						{fieldName: 'COD'}
						, {fieldName: 'SEQ'}
						, {fieldName: 'UID'}
						, {fieldName: 'UPW'}
						, {fieldName: 'UNM'}
						, {fieldName: 'STDT', dataType: 'text'}
						, {fieldName: 'EDDT', dataType: 'text'}
						// , {fieldName: 'NET', dataType: 'number'}
					]);

					let UserColumns = [
						{name: 'SEQ', fieldName: 'SEQ', visible: false, editable: false, width: 0, header: {text: '순번'}}
						, {name: 'UID', fieldName: 'UID', editable: true, styleName: 'editable-true', width: 150, header: {text: 'ID *'}}
						, {name: 'UPW', fieldName: 'UPW', editable: true, styleName: 'editable-true', width: 150, header: {text: 'PASSWORD *'}}
						, {
							name: 'UNM'
							, fieldName: 'UNM'
							, editable: true
							, styleName: 'editable-true'
							, width: 150
							, header: {text: '이름 *'}
						}
						, {
							name: 'STDT'
							, fieldName: 'STDT'
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
							, header: {text: '시작일'}

							}
						, {
							name: 'EDDT'
							, fieldName: 'EDDT'
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
							, header: {text: '종료일'}
						}
					];


					
					gridViewUser.setColumns(UserColumns);

					// 최초 Tran 그리드 set
					setUserData();

					// gridViewUser.showLoading();

					// Tran 그리드 행 선택
					gridViewUser.onCurrentRowChanged = function(grid, oldRow, newRow) {
						// console.log('check', oldRow, newRow);
						// console.log(grid);


						let SEQ = providerUser.getValue(newRow, 'SEQ');
						let UID = providerUser.getValue(newRow, 'UID');
						let UPW = providerUser.getValue(newRow, 'UPW');
						let UNM = providerUser.getValue(newRow, 'UNM');
						let STDT = providerUser.getValue(newRow, 'STDT');
						let EDDT = providerUser.getValue(newRow, 'EDDT');

						// SEQ, UID, UPW, UNM
						// console.log('row changed');
						// console.log(SEQ, UID, UPW, UNM);
						
						if (newRow < 0 || !SEQ) return;
					}


					gridViewUser.onKeyDown = function (grid, event) {
					    
					    // 엔터키, 마지막필드이고 다음행이 존재하면 이동하게 처리함
					    if (event.keyCode == 13) {

					    	/*
					    	var nowR = gridViewUser.getCurrent().itemIndex;
					    	var maxR = providerUser.getRowCount() - 1;
					    	var maxCN = providerUser.getFieldName(providerUser.getFieldIndex("EDDT"));
					    	var nowCN = gridViewUser.getCurrent().fieldName;

					    	if (nowR < maxR && maxCN == nowCN)
					    	{
					    		gridViewUser.setCurrent({ itemIndex: nowR+1, column: 'UID' });
					    	} 
					    	*/

					    	////alert("onKeyDown:13");

					    // f2키, 특정필드의 경우 editor 를 true 로 오픈합니다.
					    } else if (event.keyCode == 113) {

					    	// 구분필드에서 f2 를 눌렀으면
					    	if (gridViewUser.getCurrent().fieldName == "STDT" || gridViewUser.getCurrent().fieldName == "EDDT"){
					    		gridViewUser.showEditor(true);
					    	}
					    }

					    return true;		    		

					};	

					gridViewUser.onEditRowChanged = function (grid, itemIndex, dataRow, field, oldValue, newValue) {
						
						//alert("onEditRowChanged");

						// edit 상태라 커밋하고 저장처리합ㄴ다.
						//gridViewUser.commit(true);

						saveData(itemIndex);

						//gridViewUser.commit(true);
						//providerUser.commit(true);
					};

					
					gridViewUser.onRowsPasted =  function (grid, items) {
    					
    					//alert("붙여넣기된 행들 : " + items.length);

						// 변경된 행의 카운트 확인
						var ucount = providerUser.getRowStateCount('updated');
						var ccount = providerUser.getRowStateCount('created');

						if (ucount < 1 && ccount <1)
						{
							//alert("returned")
							return;
						}

						gridViewUser.commit(true);

					    var i = 0;

					    while (i<items.length){

							saveData(items[i]);

					      	i++;

					    }

						gridViewUser.commit(true);

						// RowState 삭제
						providerUser.clearRowStates(true, true);

					};

					gridViewUser.onPasted = function (grid){
						
					    //alert("onPasted");
						
						// 변경된 행의 카운트 확인
						gridViewUser.commit(true);


						var ucount = providerUser.getRowStateCount('updated');
						var ccount = providerUser.getRowStateCount('created');
					    
					    //alert(ucount);
					    //alert(ccount);



						if (ucount < 1 && ccount <1)
						{
							//alert("returned")
							return;
						}

						saveData(gridViewUser.getCurrent().itemIndex);

						gridViewUser.commit(true);
						
					};


					function saveData(findex){


						gridViewUser.commit(true);

						//alert(findex);

						let SEQ = providerUser.getValue(findex, 'SEQ');

						let UID = providerUser.getValue(findex, 'UID');
						let UPW = providerUser.getValue(findex, 'UPW');
						let UNM = providerUser.getValue(findex, 'UNM');
						let STDT = providerUser.getValue(findex, 'STDT');
						let EDDT = providerUser.getValue(findex, 'EDDT');
						
						if (!SEQ && (UID && UPW && UNM)) {
							console.log('insert tran row : ' + findex);
						 	let ret = saveUserData(SEQ, UID, UPW, UNM, STDT, EDDT);
						} else if (SEQ) {
						 	console.log('update tran row : ' + findex);
						 	providerUser.setRowState(findex, 'none', true);
						 	let ret = updateUserData(SEQ, UID, UPW, UNM, STDT, EDDT);
						}
					}

					gridViewUser.onCellButtonClicked = function(grid, column) {
						// console.log(grid, column);
						// if (column.column == 'CDS') {
						// 	modalTargetGrid = grid;
						// 	modalTargetIndex = column.itemIndex;
						// 	modalTargetProvider = providerUser;
						// 	// openModal('modal-CMPYCDS');
						// 	// setCmpyData(COD, '');
						// }
					};

					providerUser.onRowCountChanged = function(provider, count) {
						// 스크롤 최하단으로 설정, 그냥하면 setTopItem 이 안먹혀서 setTimeout 넣음
						setTimeout(function() {
						 	gridViewUser.setTopItem(count);
						}, 10);
					};
				});

				// data json 가져오기
				function setUserData() {

					gridViewUser.showLoading();

					let SCH = document.getElementById('SCH').value;

					$.ajax({
						url: '/member/gridUserData/',
						type: 'post',
						dataType: 'json',
						data: {SCH: SCH},
					})
					.done(function(jsonData) {
						console.log(jsonData);
						providerUser.fillJsonData(jsonData, {fillMode : 'set'});
						providerUser.addRow({});
						gridViewUser.commit(true);

						gridViewUser.setCurrent({itemIndex: providerUser.getRowCount(), column: 'UID'});
						gridViewUser.setFocus();

					})
					.always(function() {
						console.log('gridUserData complete');
						gridViewUser.closeLoading();
						//let rcnt = providerUser.getRowCount()-1;
						//gridViewUser.setCurrent({itemIndex:rcnt});
						//gridViewUser.setFocus();
					});
				}

				// Tran row 데이터 저장하기
				function saveUserData(SEQ, UID, UPW, UNM, STDT, EDDT) {
					gridViewUser.showLoading();
					console.log('in saveUserData ajax', SEQ, UID, UPW, UNM, STDT, EDDT);

					$.ajax({
						url: '/member/updateUserData',
						type: 'post',
						dataType: 'json',
						data: {
							CRUD: 'C'
							, SEQ: SEQ
							, UID: UID
							, UPW: UPW
							, UNM: UNM
							, STDT: STDT
							, EDDT: EDDT
						},
					})
					.done(function(res) {
						// console.log(res);
						console.log("success saveUserData");
						if (res.CNT > 0) {
							let insertRowIdx = providerUser.getRowCount() - 1;
							providerUser.setValue(insertRowIdx, 'SEQ', res.SEQ);
							providerUser.setRowState(insertRowIdx, 'none', true);

							providerUser.addRow({});
						 	gridViewUser.commit(true);
							//gridViewUser.setCurrent({itemIndex: providerUser.getRowCount(), column: 'UID'});
						} else {
							alert('오류가 발생했습니다.');
						}
						//setUserData();
					})
					.fail(function(res) {
						let errorText = sqlErrorMsg(res.responseText);
						alert(errorText);
					})
					.always(function(res) {
						// console.log(res);
						// need check 20231001
						gridViewUser.closeLoading();
					});
				}

				function updateUserData(SEQ, UID, UPW, UNM, STDT, EDDT) {
					gridViewUser.showLoading();
					// console.log('in updateUserData ajax', SEQ, UID, UPW, UNM, STDT, EDDT);

					$.ajax({
						url: '/member/updateUserData',
						type: 'post',
						dataType: 'json',
						data: {
							CRUD: 'U'
							, SEQ: SEQ
							, UID: UID
							, UPW: UPW
							, UNM: UNM
							, STDT: STDT
							, EDDT: EDDT
						},
					})
					.done(function(res) {
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
						// need check 20231001
						gridViewUser.closeLoading();
					});
				}

				function delUserData() {
					let provider = providerUser;
					let gridView = gridViewUser;
					let checked = gridView.getCheckedRows();
					let checkCnt = checked.length;
					let checkedCOD;
					let checkedTNO;

					if (checked.length < 1 ) {
						alert('1개 이상의 항목을 선택해주세요.');
						return false;
					}


					if (confirm('자료를 삭제합니다.')) {

						let checkedSEQ = '';

						if (checked.length >= 1) {
							checked.forEach(function(row, idx) {
								checkedSEQ += ',' + provider.getValue(row, 'SEQ');
							})
						};

						gridView.showLoading();
						$.ajax({
							url: '/member/updateUserData',
							type: 'post',
							dataType: 'json',
							data: {
								CRUD: 'D'
								, SEQ: checkedSEQ
							},
						})
						.done(function(res) {
							// console.log("success");
							// let YM = DTS.substring(0, 4);

							if (res.CNT > 0) {
								setUserData();
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