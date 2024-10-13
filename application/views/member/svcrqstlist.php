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
									<input class="input is-small p-1" id="SCH" type="text" name="SCH" placeholder="" size="5" maxlength="20" onKeyPress="if( event.keyCode==13 ){setSvcrqstData();}">
								</p>
							</div>
						</div>
						<div class="field-label is-small mr-2" style="width:120px;">
							<label class="label">상태</label>
						</div>
						<div class="field-body">
							<div class="field">
								<p class="select is-small">
									<select name="optRQST_STAT" id="optRQST_STAT" onchange="setSvcrqstData();">
										<option value="">전체</option>
										<option value="0">0.신청</option>
										<option value="1">1.승인</option>
										<option value="2">2.반려</option>
										<option value="3">3.기타</option>
									</select>
								</p>
							</div>
						</div>
					</div>
				</form>
			</div>


			<div class="level-right">
				<div class="buttons are-small">
					<a class="button">도움</a>
					<a class="button" onclick="setSvcrqstData();">검색</a>

				</div>
			</div>
		</div>
		
		

		<div>
			<div id="svcrqst_grid" class="mb-4" style="width:100%;height:700px;"></div>
			
			<script>
				var providerSvcrqst, gridViewSvcrqst;

				// modal 에서 값 입력 후 그리드 접근 위해
				var modalTargetGrid;
				var modalTargetIndex;
				var modalTargetProvider;

				// alert("1122");

				document.addEventListener('DOMContentLoaded', function() {
					providerSvcrqst = new RealGrid.LocalDataProvider();
					gridViewSvcrqst = new RealGrid.GridView('svcrqst_grid');
					gridViewSvcrqst.setDataSource(providerSvcrqst);
					gridViewSvcrqst.displayOptions.rowHeight = 30;
					gridViewSvcrqst.header.height = 36;
					gridViewSvcrqst.footer.height = 30;

					//selectionStyle의 속성중 style을 block로 지정하면 선택 영역을 여러 블럭으로 지정할 수 있습니다.
					gridViewSvcrqst.displayOptions.selectionMode = "extended";
					gridViewSvcrqst.displayOptions.selectionStyle = "block";
					gridViewSvcrqst.setCopyOptions({
					  singleMode: false,
					  enabled: true
					});

					gridViewSvcrqst.setEditOptions({
					insertable :true,
					appendable :true,
					commitByCell: true,
					//commitWhenExitLast: true,
					//enterToNextRow: true,
					enterToTab: true,
					skipReadOnly: true,
					//skipReadOnlyCell: true,
					crossWhenExitLast:true,
					commitWhenLeave:true,
					});
					
					gridViewSvcrqst.setPasteOptions({
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

					gridViewSvcrqst.rowIndicator.footText = "";

				

					gridViewSvcrqst.checkBar.useImages = true;
					
					gridViewSvcrqst.setStateBar({
						visible: false,
						width:20,
					});


					gridViewSvcrqst.setCheckBar({
						visible: true,
						showAll: true,
	
						width: 40,
					});


					

					// 단순조회물, 풋터는 표시하지 않는다.
					gridViewSvcrqst.setFooters({
					  	visible: false
					});

					
					providerSvcrqst.setFields([
						  {fieldName: 'SEQ', dataType: 'text'}
						, {fieldName: 'NAM', dataType: 'text'}
						, {fieldName: 'SNO', dataType: 'text'}
						, {fieldName: 'EML', dataType: 'text'}
						, {fieldName: 'UNM', dataType: 'text'}
						, {fieldName: 'UTEL', dataType: 'text'}
						, {fieldName: 'UID', dataType: 'text'}
						, {fieldName: 'UPW', dataType: 'text'}
						, {fieldName: 'COD', dataType: 'text'}
						, {fieldName: 'RQST_STAT', dataType: 'text'}
						, {fieldName: 'USECD', dataType: 'text'}
						, {fieldName: 'RQST_REMK', dataType: 'text'}
						, {fieldName: 'SDT', dataType: 'text'}

						// , {fieldName: 'NET', dataType: 'number'}
					]);

					//구분 1:제품 2:상품 3:비용 4:기타
					//partialMatch : 부분 문자열만 일치하더라도 검색하여 선택할 수 있습니다
					let svcrqstColumns = [
						 {name: 'SEQ',  fieldName: 'SEQ',  editable: false,  width: 50, styleName: 'align-center', header: {text: '순번'}}
						,{name: 'NAM',  fieldName: 'NAM',  editable: false,  width: 100, header: {text: '회사명'}}
						,{name: 'SNO',  fieldName: 'SNO',  editable: false,  width: 100, styleName: 'align-center', header: {text: '사업자번호'}}
						,{name: 'EML',  fieldName: 'EML',  editable: false,  width: 160, header: {text: '이메일'}}
						,{name: 'UNM',  fieldName: 'UNM',  editable: false,  width: 80, styleName: 'align-center', header: {text: '담당자'}}
						,{name: 'UTEL', fieldName: 'UTEL', editable: false,  width: 100, styleName: 'align-center', header: {text: '담당자연락처'}}
						,{name: 'UID',  fieldName: 'UID',  editable: false,  width: 100, styleName: 'align-center', header: {text: '아이디'}}
						,{name: 'UPW',  fieldName: 'UPW',  editable: false,  width: 100, styleName: 'align-center', header: {text: '비밀번호'}}

						,{name: 'COD',  fieldName: 'COD',  editable: false,  width: 80, styleName: 'align-center', header: {text: '회사코드'}}

						,{name: 'RQST_STAT'       
						  ,  fieldName: 'RQST_STAT'		  
						  ,  editable: true
						  ,  styleName: 'editable-true align-center'
						  ,  width: 80
						  ,  header: {text: '상태 *'}
						  ,  editor: {type: 'dropdown', domainOnly: true, textReadOnly: false, partialMatch: true}
						  , values: ['0', '1', '2', '3']
					 	  , labels: ['0.신청', '1.승인', '2.반려', '3.기타']
						  , lookupDisplay: true
						}

						,{name: 'USECD'       
						  ,  fieldName: 'USECD'		  
						  ,  editable: false
						  ,  styleName: 'align-center'
						  ,  width: 70
						  ,  header: {text: '사용'}
						  ,  editor: {type: 'dropdown', domainOnly: true, textReadOnly: false, partialMatch: true}
						  , values: ['0', '1']
					 	  , labels: ['0.중지', '1.사용']
						  , lookupDisplay: true
						}

						,{name: 'RQST_REMK', fieldName: 'RQST_REMK',  editable: true,   width: 130, header: {text: '처리내용 *'}}
						,{name: 'SDT',       fieldName: 'SDT',        editable: false,  width: 100, header: {text: '처리일시'}}

					
						
					];

					
					gridViewSvcrqst.setColumns(svcrqstColumns);

					// 최초 Pg 그리드 set
					setSvcrqstData();

					// gridViewSvcrqst.showLoading();

					// Pg 그리드 행 선택
					gridViewSvcrqst.onCurrentRowChanged = function(grid, oldRow, newRow) {
						// console.log('check', oldRow, newRow);
						// console.log(grid);
						let SEQ = providerSvcrqst.getValue(newRow, 'SEQ');
						if (newRow < 0 || !SEQ) return;
					};

/*
					gridViewSvcrqst.onCellEdited = function(grid, itemIndex, row, field) {
						
						////////////gridViewSvcrqst.commit(true);

						//alert("onCellEdited");

						let current = gridViewSvcrqst.getCurrent();
						let thisValue = providerSvcrqst.getValue(current.dataRow, current.fieldName);
						
						let PGCD_SAVED = providerSvcrqst.getValue(current.dataRow,'PGCD_SAVED');
						
						let PGCD       = providerSvcrqst.getValue(current.dataRow,'PGCD'      );
						let DVS        = providerSvcrqst.getValue(current.dataRow,'DVS'       );
						let PGNM        = providerSvcrqst.getValue(current.dataRow,'PGNM'       );
						let SDT        = providerSvcrqst.getValue(current.dataRow,'SDT'       );
						let UNT        = providerSvcrqst.getValue(current.dataRow,'UNT'       );
						let TAXCD      = providerSvcrqst.getValue(current.dataRow,'TAXCD'     );
						let SDTCOST    = providerSvcrqst.getValue(current.dataRow,'SDTCOST'   );
						let SDTSALE    = providerSvcrqst.getValue(current.dataRow,'SDTSALE'   );
						let RMK        = providerSvcrqst.getValue(current.dataRow,'RMK'       );
						

						if (!PGCD_SAVED && (PGNM)) {
							//console.log('insert pg row');

							//alert("saveSvCrqstData");

						 	let ret = saveSvCrqstData(PGCD_SAVED, PGCD, DVS, PGNM, SDT, UNT, TAXCD, SDTCOST, SDTSALE, RMK);
						 	gridViewSvcrqst.commit(true);
						} else if (PGCD_SAVED && (PGNM)) {
						 	//console.log('update pg row');

							//alert("updateSvcrqstData");

						 	let ret = updateSvcrqstData(PGCD_SAVED, PGCD, DVS, PGNM, SDT, UNT, TAXCD, SDTCOST, SDTSALE, RMK);
						 	gridViewSvcrqst.commit(true);
						}

					};

*/

					gridViewSvcrqst.onKeyDown = function (grid, event) {
					    
					    // 엔터키, 마지막필드이고 다음행이 존재하면 이동하게 처리함
					    if (event.keyCode == 13) {

					    	/*
					    	var nowR = gridViewSvcrqst.getCurrent().itemIndex;
					    	var maxR = providerSvcrqst.getRowCount() - 1;
					    	var maxCN = providerSvcrqst.getFieldName(providerSvcrqst.getFieldIndex("RMK"));
					    	var nowCN = gridViewSvcrqst.getCurrent().fieldName;

					    	if (nowR < maxR && maxCN == nowCN)
					    	{
					    		gridViewSvcrqst.setCurrent({ itemIndex: nowR+1, column: 'PGCD' });
					    	} 
					    	*/

					    // f2키, 특정필드의 경우 editor 를 true 로 오픈합니다.
					    } else if (event.keyCode == 113) {

					    						    	// 구분필드에서 f2 를 눌렀으면
					    	if (gridViewSvcrqst.getCurrent().fieldName == "RQST_STAT"){
					    		gridViewSvcrqst.showEditor(true);
					    	}
					    }


					};	

/*
					gridViewSvcrqst.onShowEditor = function (grid, index, props, attrs) {
					    
					    // 엔터키, 마지막필드이고 다음행이 존재하면 이동하게 처리함
					    if (index.fieldName == "PGCD") {
							
							

					    }

					    //return true;		    		

					};	
*/

					gridViewSvcrqst.onEditRowChanged = function (grid, itemIndex, dataRow, field, oldValue, newValue) {

						// edit 상태라 커밋하고 저장처리합ㄴ다.
						gridViewSvcrqst.commit(true);

						saveData(itemIndex);

						//gridViewSvcrqst.commit(true);
						providerSvcrqst.commit(true);

					};

					gridViewSvcrqst.onRowsPasted =  function (grid, items) {
    					
    					//alert("붙여넣기된 행들 : " + items.length);

						// 변경된 행의 카운트 확인
						var ucount = providerSvcrqst.getRowStateCount('updated');
						var ccount = providerSvcrqst.getRowStateCount('created');

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

						gridViewSvcrqst.commit(true);

						// RowState 삭제
						providerSvcrqst.clearRowStates(true, true);

					};
					


					
					gridViewSvcrqst.onPasted = function (grid){

					    //alert("onPasted");
						
						// 변경된 행의 카운트 확인
						var ucount = providerSvcrqst.getRowStateCount('updated');
						var ccount = providerSvcrqst.getRowStateCount('created');

						if (ucount < 1 && ccount <1)
						{
							//alert("returned")
							return;
						}

						saveData(gridViewSvcrqst.getCurrent().itemIndex);

						gridViewSvcrqst.commit(true);

					}
					


					function saveData(findex){

						//alert(findex);
						let SEQ       = providerSvcrqst.getValue(findex,'SEQ'      );
						let RQST_STAT = providerSvcrqst.getValue(findex,'RQST_STAT'      );
						let RQST_REMK = providerSvcrqst.getValue(findex,'RQST_REMK'       );
						
						//alert(PGCD);
						//alert(PGCD);
						//alert(PGNM);

						if (!SEQ && (RQST_STAT && RQST_REMK)) {
						 	let ret = saveSvCrqstData(SEQ, RQST_STAT, RQST_REMK);
						} else if (SEQ && (RQST_STAT && RQST_REMK)) {
						 	let ret = updateSvcrqstData(SEQ, RQST_STAT, RQST_REMK);
						}

					}


					providerSvcrqst.onRowCountChanged = function(provider, count) {
						// 스크롤 최하단으로 설정, 그냥하면 setTopItem 이 안먹혀서 setTimeout 넣음
						setTimeout(function() {
						 	gridViewSvcrqst.setTopItem(count);
						}, 10);
					};

				});
				
				// data json 가져오기
				function setSvcrqstData() {


					gridViewSvcrqst.showLoading();

					let SCH = document.getElementById('SCH').value;
					let RQST_STAT = document.getElementById('optRQST_STAT').value;

					$.ajax({
						url: '/member/gridSvcrqstData/',
						type: 'post',
						dataType: 'json',
						data: {SCH: SCH, RQST_STAT: RQST_STAT},
					})
					.done(function(jsonData) {
						console.log(jsonData);
						providerSvcrqst.fillJsonData(jsonData, {fillMode : 'set'});
						//providerSvcrqst.addRow({});
						//gridViewSvcrqst.commit(true);
					})
					.always(function() {
						console.log('gridSvCrqstData complete');
						gridViewSvcrqst.commit(true);
						gridViewSvcrqst.closeLoading();
						//let rcnt = providerSvcrqst.getRowCount()-1;
						//gridViewSvcrqst.setCurrent({itemIndex:rcnt});
						//gridViewSvcrqst.setFocus();
					});
				}

				// Pg row 데이터 저장하기
				function saveSvCrqstData(SEQ, RQST_STAT, RQST_REMK) {
					gridViewSvcrqst.showLoading();
					console.log('in saveSvCrqstData ajax', SEQ, RQST_STAT, RQST_REMK);

					$.ajax({
						url: '/member/updateSvcrqstData',
						type: 'post',
						// dataType: 'json',
						data: {
							SEQ: SEQ
							, RQST_STAT		: RQST_STAT
							, RQST_REMK		: RQST_REMK

						},
					})
					.done(function(res) {
						console.log(res);
						console.log("success saveSvCrqstData");
						setSvcrqstData();
					})
					.always(function(res) {
						console.log(res);
						gridViewSvcrqst.closeLoading();
					});
				}

				function updateSvcrqstData(SEQ, RQST_STAT, RQST_REMK) {
					gridViewSvcrqst.showLoading();
					console.log('in updateSvcrqstData ajax', SEQ, RQST_STAT, RQST_REMK);

					//alert(PGNM);

					$.ajax({
						url: '/member/updateSvcrqstData',
						type: 'post',
						dataType: 'json',
						data: {
							SEQ: SEQ
							, RQST_STAT: RQST_STAT
							, RQST_REMK: RQST_REMK

						},
					})
					.done(function(res) {
						// console.log("success");
						// let YM = DTS.substring(0, 4);
						setSvcrqstData();
					})
					.always(function(complete) {
						console.log("complete");
						gridViewSvcrqst.closeLoading();
					});
				}


				
			</script>
		</div>
	</div>
</section>