<!-- 리얼그리드 테마 css -->
<link href="<?=INC_JS_URL?>realgrid.2.6.2/realgrid-sky-blue.css" rel="stylesheet" />
<!-- 리얼그리드 커스컴 수정사항 css -->
<link href="<?=INC_JS_URL?>realgrid.2.6.2/realgrid-custom.css" rel="stylesheet" />
<script src="<?=INC_JS_URL?>realgrid.2.6.2/realgrid-lic.js"></script>
<script src="<?=INC_JS_URL?>realgrid.2.6.2/realgrid.2.6.2.min.js"></script>
<script src="<?=INC_JS_URL?>realgrid.2.6.2/libs/jszip.min.js"></script>


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
									<input class="input is-small p-1" id="SCH" type="text" name="SCH" placeholder="" size="5" maxlength="20" onKeyPress="if( event.keyCode==13 ){setStockData();}">
								</p>
							</div>
						</div>
					</div>
				</form>
			</div>


			<div class="level-right">
				<div class="buttons are-small">
					<a class="button">도움</a>
					<a class="button" onclick="setStockData();">검색</a>
					<a class="button" onclick="expExcelData();">액셀</a>
				</div>
			</div>
		</div>
		
		

		<div>
			<div id="prod_grid" class="mb-4" style="width:100%;height:700px;"></div>
			
			<script>
				var providerStock, gridViewStock;

				// modal 에서 값 입력 후 그리드 접근 위해
				var modalTargetGrid;
				var modalTargetIndex;
				var modalTargetProvider;

				// alert("1122");

				document.addEventListener('DOMContentLoaded', function() {
					providerStock = new RealGrid.LocalDataProvider();
					gridViewStock = new RealGrid.GridView('prod_grid');
					gridViewStock.setDataSource(providerStock);
					gridViewStock.displayOptions.rowHeight = 30;
					gridViewStock.header.height = 36;
					gridViewStock.footer.height = 30;

					//selectionStyle의 속성중 style을 block로 지정하면 선택 영역을 여러 블럭으로 지정할 수 있습니다.
					gridViewStock.displayOptions.selectionMode = "extended";
					gridViewStock.displayOptions.selectionStyle = "block";
					gridViewStock.setCopyOptions({
					  singleMode: false,
					  enabled: true
					});

					gridViewStock.setEditOptions({
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
					
					gridViewStock.setPasteOptions({
					    singleMode: false,
					    enabled: false, // 단순조회 메뉴여서 true -> false 로 변경함
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

					gridViewStock.rowIndicator.footText = "";

					// 단순조회물, 상태바는 표시하지 않는다.
					gridViewStock.setStateBar({
  						visible: false
					});

					// 단순조회물, 체크바는 표시하지 않는다.
					gridViewStock.setCheckBar({
					  	visible: false
					});

					providerStock.setFields([
						  {fieldName: 'PGCD', dataType: 'text'}
						, {fieldName: 'PGNM', dataType: 'text'}
						, {fieldName: 'PCOD', dataType: 'text'}
						, {fieldName: 'PNAM', dataType: 'text'}
						, {fieldName: 'STD', dataType: 'text'}
						, {fieldName: 'UNT', dataType: 'text'}
						, {fieldName: 'STCK_QTY', dataType: 'number'}

						// , {fieldName: 'NET', dataType: 'number'}
					]);

					//구분 1:제품 2:상품 3:비용 4:기타
					//partialMatch : 부분 문자열만 일치하더라도 검색하여 선택할 수 있습니다
					let stockColumns = [
						 {name: 'PGCD'      ,  fieldName: 'PGCD'      ,  editable: false,  width: 100, header: {text: '품목군코드'}}
						,{name: 'PGNM'      ,  fieldName: 'PGNM'      ,  editable: false,  width: 150, header: {text: '품목군'}}
						,{name: 'PCOD'      ,  fieldName: 'PCOD'      ,  editable: false,  width: 100, header: {text: '품번'}}
						,{name: 'PNAM'      ,  fieldName: 'PNAM'      ,  editable: false,  width: 150, header: {text: '품명'}}
						,{name: 'STD'       ,  fieldName: 'STD'		  ,  editable: false,  width: 120, header: {text: '규격'}}
						,{name: 'UNT'       ,  fieldName: 'UNT' 	  ,  editable: false,  width: 120, header: {text: '단위'}}

						,{name: 'STCK_QTY'   
						  ,  fieldName: 'STCK_QTY'	  
						  ,  editable: false
						  ,  styleName: 'editable-true align-right'
						  ,  width: 150
						  ,  header: {text: '현재고 수량'}
						  ,  footer: {text: '합계'
						  		, numberFormat: "#,##0"
						  		, expression: "sum"
						  		, styleName: "align-right"}
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
					];

					
					gridViewStock.setColumns(stockColumns);

					// 최초 Stock 그리드 set
					setStockData();

					// gridViewStock.showLoading();


				});
				
				// data json 가져오기
				function setStockData() {


					gridViewStock.showLoading();

					let SCH = document.getElementById('SCH').value;

					$.ajax({
						url: '/member/gridStockData/',
						type: 'post',
						dataType: 'json',
						data: {SCH: SCH},
					})
					.done(function(jsonData) {
						console.log(jsonData);
						providerStock.fillJsonData(jsonData, {fillMode : 'set'});
						//providerStock.addRow({});
						//gridViewStock.commit(true);
					})
					.always(function() {
						console.log('gridStockData complete');
						gridViewStock.commit(true);
						gridViewStock.closeLoading();
					});
				}

				// excel data 내보내기
				function expExcelData() {

					gridViewStock.exportGrid({
					    type: "excel",
					    target: "local",
					    fileName: "현재고조회.xlsx", 
					  
					});
				}





				
			</script>
		</div>
	</div>
</section>