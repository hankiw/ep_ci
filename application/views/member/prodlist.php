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
									<input class="input is-small p-1" id="SCH" type="text" name="SCH" placeholder="" size="5" maxlength="20" onKeyPress="if( event.keyCode==13 ){setProdData();}">
								</p>
							</div>
						</div>
					</div>
				</form>
			</div>


			<div class="level-right">
				<div class="buttons are-small">
					<a class="button">도움</a>
					<a class="button" onclick="setProdData();">검색</a>
					<a class="button" onclick="delProdData();">삭제</a>
				</div>
			</div>
		</div>
		
		

		<div>
			<div id="prod_grid" class="mb-4" style="width:100%;height:700px;"></div>
			
			<script>
				var providerProd, gridViewProd;

				// modal 에서 값 입력 후 그리드 접근 위해
				var modalTargetGrid;
				var modalTargetIndex;
				var modalTargetProvider;

				// 첫 set data 구분
				var isInitData = false;

				// alert("1122");

				document.addEventListener('DOMContentLoaded', function() {
					providerProd = new RealGrid.LocalDataProvider();
					gridViewProd = new RealGrid.GridView('prod_grid');
					gridViewProd.setDataSource(providerProd);
					gridViewProd.displayOptions.rowHeight = 30;
					gridViewProd.header.height = 36;
					gridViewProd.footer.height = 30;

					//selectionStyle의 속성중 style을 block로 지정하면 선택 영역을 여러 블럭으로 지정할 수 있습니다.
					gridViewProd.displayOptions.selectionMode = "extended";
					gridViewProd.displayOptions.selectionStyle = "block";
					gridViewProd.setCopyOptions({
					  singleMode: false,
					  enabled: true
					});

					gridViewProd.setEditOptions({
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
					
					gridViewProd.setPasteOptions({
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

					gridViewProd.rowIndicator.footText = "";

					// 단순조회물, 상태바는 표시하지 않는다.


					gridViewProd.checkBar.useImages = true;

					gridViewProd.setCheckBar({
						visible: true,
						showAll: true,
						width: 40,
					});
					
					gridViewProd.setStateBar({
						visible: false,
						width:20,
					});



					// 단순조회물, 풋터는 표시하지 않는다.
					gridViewProd.setFooters({
					  	visible: false
					});

					
					
					providerProd.setFields([
						  {fieldName: 'COD', dataType: 'text'}
						, {fieldName: 'PCOD_SAVED', dataType: 'text'}
						, {fieldName: 'PCOD', dataType: 'text'}
						, {fieldName: 'DVS', dataType: 'text'}
						, {fieldName: 'PGCD', dataType: 'text'}
						, {fieldName: 'PGNM', dataType: 'text'}
						, {fieldName: 'NAM', dataType: 'text'}
						, {fieldName: 'STD', dataType: 'text'}
						, {fieldName: 'UNT', dataType: 'text'}
						, {fieldName: 'TAXCD', dataType: 'text'}
						, {fieldName: 'STDCOST', dataType: 'number'}
						, {fieldName: 'STDSALE', dataType: 'number'}
						, {fieldName: 'RMK', dataType: 'text'}

						// , {fieldName: 'NET', dataType: 'number'}
					]);

					//구분 1:제품 2:상품 3:비용 4:기타
					//partialMatch : 부분 문자열만 일치하더라도 검색하여 선택할 수 있습니다
					let prodColumns = [
						 {name: 'PCOD_SAVED',  fieldName: 'PCOD_SAVED',  visible: false, editable: false, width: 0, header: {text: ''}} 
						,{name: 'PCOD'      ,  fieldName: 'PCOD'      ,  editable: true,  width: 100, header: {text: '품번 *'}}
						,{name: 'DVS'       
						  ,  fieldName: 'DVS'		  
						  ,  editable: true
						  ,  styleName: 'editable-true'
						  ,  width: 80
						  ,  header: {text: '구분 *'}
						  ,  editor: {type: 'dropdown', domainOnly: true, textReadOnly: false, partialMatch: true}
						  , values: ['1', '2', '3', '4']
					 	  , labels: ['1.제품', '2.상품', '3.비용', '4.기타']
						  , lookupDisplay: true
						}
						//,{name: 'DVSNAM'    ,  fieldName: 'DVSNAM'    ,  editable: true,  styleName: 'editable-true',  width: 100, header: {text: '구분'}}
						,{name: 'NAM'       ,  fieldName: 'NAM'		  ,  editable: true,  width: 150, header: {text: '품명 *'}}
						,{name: 'TAXCD'     
						  ,  fieldName: 'TAXCD'	  
						  ,  editable: true
						  ,  styleName: 'editable-true'
						  ,  width: 80
						  ,  header: {text: '과세 *'}
						  ,  editor: {type: 'dropdown', domainOnly: true, textReadOnly: false, partialMatch: true}
						  , values: ['1', '0']
					 	  , labels: ['1.과세', '0.면세']
						  , lookupDisplay: true
						}						
						,{name: 'PGCD'      
						  , fieldName: 'PGCD'	  		
						  , width: 100
						  , header: {text: '품목군코드'}
						  , editable: true
 						  , button: 'action'
						  , buttonVisibility: 'default'	
						}
						,{name: 'PGNM'      ,  fieldName: 'PGNM'	  
						  , editable: false
						  , width: 120, header: {text: '품목군'}}
						,{name: 'STD'       ,  fieldName: 'STD'		  ,  editable: true,  width: 120, header: {text: '규격'}}
						,{name: 'UNT'       ,  fieldName: 'UNT' 	  ,  editable: true,  width: 120, header: {text: '단위'}}

						,{name: 'STDCOST'   
						  ,  fieldName: 'STDCOST'	  
						  ,  editable: true
						  ,  styleName: 'editable-true align-right'
						  ,  width: 100
						  ,  header: {text: '기준매입가'}
						  ,  type: 'number'
						  ,  numberFormat: '#,##0'
						  ,  editor: {
							    type: "number",
							    textAlignment: "far",
							    //입력시 적용되는 포맷(소수점 최대 3자리까지만 입력 가능)
							    editFormat: "#,##0",
							    multipleChar: "+",
							 }
						}
						,{name: 'STDSALE'   
						  ,  fieldName: 'STDSALE'	  
						  ,  editable: true
						  ,  styleName: 'editable-true align-right'
						  ,  width: 100
						  ,  header: {text: '기준판매가'}
						  ,  type: 'number'
						  ,  numberFormat: '#,##0'
						  ,  editor: {
							    type: "number",
							    textAlignment: "far",
							    //입력시 적용되는 포맷(소수점 최대 3자리까지만 입력 가능)
							    editFormat: "#,##0",
							    multipleChar: "+",
							 }
						}
						,{name: 'RMK'       ,  fieldName: 'RMK'		  ,  editable: true,  width: 150, header: {text: '비고'}}
					];

					
					gridViewProd.setColumns(prodColumns);

					
					setProdData();



					gridViewProd.onKeyDown = function (grid, event) {
					    
					    // 엔터키, 마지막필드이고 다음행이 존재하면 이동하게 처리함
					    if (event.keyCode == 13) {

					    	/*
					    	var nowR = gridViewProd.getCurrent().itemIndex;
					    	var maxR = providerProd.getRowCount() - 1;
					    	var maxCN = providerProd.getFieldName(providerProd.getFieldIndex("RMK"));
					    	var nowCN = gridViewProd.getCurrent().fieldName;

					    	if (nowR < maxR && maxCN == nowCN)
					    	{
					    		gridViewProd.setCurrent({ itemIndex: nowR+1, column: 'PCOD' });
					    	} 
					    	*/

					    // f2키, 특정필드의 경우 editor 를 true 로 오픈합니다.
					    } else if (event.keyCode == 113) {

					    	// 구분필드에서 f2 를 눌렀으면
					    	if (gridViewProd.getCurrent().fieldName == "DVS" 
					    		|| gridViewProd.getCurrent().fieldName == "TAXCD"){
					    		gridViewProd.showEditor(true);
					    		return true;		    		
					    	}
					    	else if (gridViewProd.getCurrent().fieldName == "PGCD"){

								modalTargetGrid = grid;
							 	modalTargetIndex = gridViewProd.getCurrent().itemIndex;
							 	modalTargetProvider = providerProd;

							 	//alert("PGCD Button Clicked");
							 	
							 	openModal('modal-PG');

							 	// modal 을 오픈한 후에 모달의 select 를 수행한다.
							 	setPgData();

								//document.getElementById("pg_grid").focus();

							 	// return false 로 안하면 잔상이 남네.
							 	return false;

					    	}
					    }


					};	



					gridViewProd.onEditRowChanged = function (grid, itemIndex, dataRow, field, oldValue, newValue) {

						// edit 상태라 커밋하고 저장처리합ㄴ다.
						//gridViewProd.commit(true);
						//console.log('onEditRowChanged');
						saveData(itemIndex);

						//gridViewProd.commit(true);
						//providerProd.commit(true);

					};

					gridViewProd.onRowsPasted =  function (grid, items) {
    					
    					//alert("붙여넣기된 행들 : " + items.length);

						// 변경된 행의 카운트 확인

						var ucount = providerProd.getRowStateCount('updated');
						var ccount = providerProd.getRowStateCount('created');

						if (ucount < 1 && ccount <1)
						{
							//alert("returned")
							return;
						}

					    var i = 0;

					    while (i<items.length){

							saveData(items[i]);

					      	i++;

					    }

						gridViewProd.commit(true);

						// RowState 삭제
						providerProd.clearRowStates(true, true);

					};
					


					
					gridViewProd.onPasted = function (grid){
						// 변경된 행의 카운트 확인


						gridViewProd.commit(true);

						var ucount = providerProd.getRowStateCount('updated');
						var ccount = providerProd.getRowStateCount('created');

						if (ucount < 1 && ccount <1)
						{
							//alert("returned")
							return;
						}

						saveData(gridViewProd.getCurrent().itemIndex);

						gridViewProd.commit(true);

					}
					


					function saveData(findex){


						gridViewProd.commit(true);

						//alert(findex);

						let PCOD_SAVED = providerProd.getValue(findex,'PCOD_SAVED');
							
						let PCOD       = providerProd.getValue(findex,'PCOD'      );
						let DVS        = providerProd.getValue(findex,'DVS'       );
						let PGCD       = providerProd.getValue(findex,'PGCD'      );
						let NAM        = providerProd.getValue(findex,'NAM'       );
						let STD        = providerProd.getValue(findex,'STD'       );
						let UNT        = providerProd.getValue(findex,'UNT'       );
						let TAXCD      = providerProd.getValue(findex,'TAXCD'     );
						let STDCOST    = providerProd.getValue(findex,'STDCOST'   );
						let STDSALE    = providerProd.getValue(findex,'STDSALE'   );
						let RMK        = providerProd.getValue(findex,'RMK'       );
						
						//alert(PCOD);
						//alert(PGCD);
						//alert(NAM);

						if (!PCOD_SAVED && (DVS && NAM && TAXCD)) {
						 	let ret = saveProdData(PCOD_SAVED, PCOD, DVS, PGCD, NAM, STD, UNT, TAXCD, STDCOST, STDSALE, RMK);
						} else if (PCOD_SAVED && (DVS && NAM && TAXCD)) {
						 	providerProd.setRowState(findex, 'none', true);
						 	let ret = updateProdData(PCOD_SAVED, PCOD, DVS, PGCD, NAM, STD, UNT, TAXCD, STDCOST, STDSALE, RMK);
						}

					}

					gridViewProd.onCellButtonClicked = function(grid, column) {
						// console.log(grid, column);
						
						if (column.column == 'PGCD') {
						 	modalTargetGrid = grid;
						 	modalTargetIndex = column.itemIndex;
						 	modalTargetProvider = providerProd;

						 	//alert("PGCD Button Clicked");
						 	
						 	openModal('modal-PG');

						 	// modal 을 오픈한 후에 모달의 select 를 수행한다.
						 	setPgData();

						}
						
					};

					providerProd.onRowCountChanged = function(provider, count) {
						// 스크롤 최하단으로 설정, 그냥하면 setTopItem 이 안먹혀서 setTimeout 넣음
						//setTimeout(function() {
						// 	gridViewProd.setTopItem(count);
						// 	if (!isInitData) {
						// 		gridViewProd.setCurrent({itemIndex: count - 1});
						// 		gridViewProd.setFocus();
						// 		isInitData = true;
						// 	}
						//}, 10);

						setTimeout(function() {
						 	gridViewProd.setTopItem(count);
						}, 10);

					};

				});
				
				// data json 가져오기
				function setProdData() {


					gridViewProd.showLoading();

					let SCH = document.getElementById('SCH').value;

					$.ajax({
						url: '/member/gridProdData/',
						type: 'post',
						dataType: 'json',
						data: {SCH: SCH},
					})
					.done(function(jsonData) {
						console.log(jsonData);
						providerProd.fillJsonData(jsonData, {fillMode : 'set'});
						providerProd.addRow({});
						gridViewProd.commit(true);


						gridViewProd.setCurrent({itemIndex: providerProd.getRowCount(), column: 'PCOD'});
						gridViewProd.setFocus();

					})
					.always(function() {
						console.log('gridProdData complete');
						/////////////////gridViewProd.commit(true);
						gridViewProd.closeLoading();


					});
				}

				// Prod row 데이터 저장하기
				//                    PCOD_SAVED, PCOD, DVS, PGCD, NAM, STD, UNT, TAXCD, STDCOST, STDSALE, RMK
				function saveProdData(PCOD_SAVED, PCOD, DVS, PGCD, NAM, STD, UNT, TAXCD, STDCOST, STDSALE, RMK) {
					gridViewProd.showLoading();
					console.log('in saveProdData ajax', PCOD_SAVED, PCOD, DVS, PGCD, NAM, STD, UNT, TAXCD, STDCOST, STDSALE, RMK);

					$.ajax({
						url: '/member/updateProdData',
						type: 'post',
						dataType: 'json',
						data: {
							CRUD: 'C'
							, PCOD_SAVED: PCOD_SAVED
							, PCOD		: PCOD
							, DVS		: DVS
							, PGCD      : PGCD 
							, NAM		: NAM
							, STD		: STD
							, UNT		: UNT
							, TAXCD		: TAXCD
							, STDCOST	: STDCOST
							, STDSALE	: STDSALE
							, RMK       : RMK 
						},
					})
					.done(function(res) {
						//console.log(res);
						console.log("success saveProdData");

						if (res.CNT > 0) {
							let insertRowIdx = providerProd.getRowCount() - 1;
							providerProd.setValue(insertRowIdx, 'PCOD_SAVED', res.PCOD_SAVED);
							providerProd.setRowState(insertRowIdx, 'none', true);
							
							providerProd.addRow({});
						 	gridViewProd.commit(true);
							//gridViewPg.setCurrent({itemIndex: providerPg.getRowCount(), column: 'PGCD'});
						} else {
							alert('오류가 발생했습니다1.');
						}

					})
					.fail(function(res){
						let errorText = sqlErrorMsg(res.responseText);
						alert(errorText);
					})
					.always(function(complete) {
						//console.log(res);
						gridViewProd.closeLoading();
					});
				}

				function updateProdData(PCOD_SAVED, PCOD, DVS, PGCD, NAM, STD, UNT, TAXCD, STDCOST, STDSALE, RMK) {
					gridViewProd.showLoading();
					console.log('in updateProdData ajax', PCOD_SAVED, PCOD, DVS, PGCD, NAM, STD, UNT, TAXCD, STDCOST, STDSALE, RMK);

					//alert(NAM);

					$.ajax({
						url: '/member/updateProdData',
						type: 'post',
						dataType: 'json',
						data: {
							CRUD: 'U'
							, PCOD_SAVED: PCOD_SAVED
							, PCOD		: PCOD
							, DVS		: DVS
							, PGCD      : PGCD
							, NAM		: NAM
							, STD		: STD
							, UNT		: UNT
							, TAXCD		: TAXCD
							, STDCOST	: STDCOST
							, STDSALE	: STDSALE
							, RMK       : RMK 
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
					.fail(function(res){
						let errorText = sqlErrorMsg(res.responseText);
						alert(errorText);

					})
					.always(function(complete) {
						console.log("complete");
						gridViewProd.closeLoading();
					});
				}

				function delProdData() {
					let provider = providerProd;
					let gridView = gridViewProd;
					let checked = gridView.getCheckedRows();
					let checkCnt = checked.length;
					let checkedPCOD_SAVED;

					if (checked.length < 1) {
						alert('1개 항목을 선택해주세요.');
						return false;
					}

					//alert(checkedPCOD_SAVED);


					if (confirm('자료를 삭제합니다.')) {

						checked.forEach(function(row, idx) {
							checkedPCOD_SAVED += ',' + provider.getValue(row, 'PCOD_SAVED');
						});


						gridView.showLoading();
						$.ajax({
							url: '/member/updateProdData',
							type: 'post',
							dataType: 'json',
							data: {
								CRUD: 'D'
								, PCOD_SAVED: checkedPCOD_SAVED
							},
						})
						.done(function(res) {
							// console.log("success");
							// let YM = DTS.substring(0, 4);


							if (res.CNT > 0) {
								setProdData();
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