<!-- 리얼그리드 테마 css -->
<link href="<?=INC_JS_URL?>realgrid.2.6.2/realgrid-sky-blue.css" rel="stylesheet" />
<!-- 리얼그리드 커스컴 수정사항 css -->
<link href="<?=INC_JS_URL?>realgrid.2.6.2/realgrid-custom.css" rel="stylesheet" />
<script src="<?=INC_JS_URL?>realgrid.2.6.2/realgrid-lic.js"></script>
<script src="<?=INC_JS_URL?>realgrid.2.6.2/realgrid.2.6.2.min.js"></script>

<section class="section p-4">
	<div class="container">
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
									<input class="input is-small p-1 datepicker monthpicker" type="text" name="YM" placeholder="" value="<?=$YM?>" size="5" readonly onchange="selectYM();">
								</p>
							</div>
							<div class="field">
								<p class="control is-expanded has-icons-left has-icons-right">
									<input class="input is-small p-1" type="text" name="DD" placeholder="" value="<?=$DD?>" size="3" maxlength="2" onchange="selectYM();">
								</p>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="level-right">
				<div class="buttons are-small">
					<a href="" class="button">건별발행</a>
					<a href="" class="button mr-5">발행취소</a>
					<a href="" class="button">도움</a>
					<a href="" class="button">검색</a>
					<a href="" class="button">삭제</a>
					<a href="" class="button">인쇄</a>
					<a href="" class="button">복사이동</a>
				</div>
			</div>
		</div>
		<script>
			function selectYM() {
				document.select_ym.submit();
			}
		</script>

		<div class="level mb-2">
			<div class="level-left" style="width:55%;">
				<div id="payment_grid" style="width:100%;height:600px;"></div>
			</div>
			<script>
				var COD = '<?=$COD?>';
				var YM = '<?=$YM?>';
				var DD = '<?=$DD?>';
				var DVS = '<?=$DVS?>';

				var providerPayment, gridViewPayment;

				// modal 에서 값 입력 후 그리드 접근 위해
				var modalTargetGrid;
				var modalTargetIndex;

				document.addEventListener('DOMContentLoaded', function() {
					providerPayment = new RealGrid.LocalDataProvider();
					gridViewPayment = new RealGrid.GridView('payment_grid');
					gridViewPayment.setDataSource(providerPayment);
					gridViewPayment.displayOptions.rowHeight = 30;
					gridViewPayment.header.height = 30;
					gridViewPayment.footer.height = 30;

					providerPayment.setFields([
						
					]);

					let paymentColumns = [
						{name: 'DTS_DD', fieldName: 'DTS_DD', width: 30, styleName: 'align-center', header: {text: '일'}}
						, {
							name: 'CDS'
							, fieldName: 'CDS'
							, width: 80
							, header: {text: '거래처코드'}
							, editable: false
							, button: 'action'
							, buttonVisibility: 'default'
							
						}
						, {name: 'NAM', fieldName: 'NAM', editable: false, styleName: 'editable-false', width: 100, header: {text: '거래처명'}}
						, {name: 'NOS', fieldName: 'NOS', editable: false, styleName: 'editable-false', width: 110, header: {text: '명세서번호'}}
						, {
							name: ''
							, fieldName: ''
							, editable: false
							, styleName: 'editable-false align-right'
							, header: {text: '입금금액'}
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
							name: ''
							, fieldName: ''
							, width: 100
							, header: {text: '입금구분코드'}
							, editable: false
							, button: 'action'
							, buttonVisibility: 'default'
							
						}
						, {name: '', fieldName: '', editable: false, styleName: 'editable-false', width: 100, header: {text: '입금구분'}}
						, {
							name: ''
							, fieldName: ''
							, header: {text:'적요'}
						}
						, {
							name: ''
							, fieldName: ''
							, header: {text:'일치'}
						}
					];
					
					gridViewPayment.setColumns(paymentColumns);

					// 최초 master 그리드 set
					setMasterData(DVS, COD, YM, DD);

					// gridViewMaster.showLoading();

					// master 그리드 행 선택
					gridViewPayment.onCurrentRowChanged = function(grid, oldRow, newRow) {
						// console.log('check', oldRow, newRow);
						// console.log(grid);
						// providerDetail.clearRows();
						// let COD = providerMaster.getValue(newRow, 'COD');
						// let DVS = providerMaster.getValue(newRow, 'DVS');
						// let DTS = providerMaster.getValue(newRow, 'DTS');
						// let NOS = providerMaster.getValue(newRow, 'NOS');
						// if (newRow < 0 || !NOS) return;
						
						// // 거래처 정보
						// let CDS = providerMaster.getValue(newRow, 'CDS');
						// let NAM = providerMaster.getValue(newRow, 'NAM');
						// document.getElementById('selected_cds').value = NAM;
						// document.getElementById('selected_nos').value = NOS;
						
						// setDetailData(COD, DVS, NOS);
					}

					gridViewPayment.onCellEdited = function(grid, itemIndex, row, field) {
						gridViewPayment.commit(true);
						// let current = gridViewPayment.getCurrent();
						// let thisValue = providerPayment.getValue(current.dataRow, current.fieldName);
						// let NOS = providerPayment.getValue(current.dataRow, 'NOS');
						// let DTSDD = providerPayment.getValue(current.dataRow, 'DTS_DD');
						// let TYP = providerPayment.getValue(current.dataRow, 'TYP');
						// let GBN = providerPayment.getValue(current.dataRow, 'GBN');
						// let CDS = providerPayment.getValue(current.dataRow, 'CDS');
						// let NET = providerPayment.getValue(current.dataRow, 'NET');
						// let VAT = providerPayment.getValue(current.dataRow, 'VAT');

					}

					
				});
				
				// data json 가져오기
				function setMasterData(DVS, COD, YM, D) {
					// gridViewMaster.showLoading();
					// $.ajax({
					// 	url: '/manage/gridMasterData/',
					// 	type: 'post',
					// 	dataType: 'json',
					// 	data: {DVS: DVS, COD: COD, YM: YM, D: D},
					// })
					// .done(function(jsonData) {
					// 	// console.log(jsonData);
					// 	providerMaster.fillJsonData(jsonData, {fillMode : 'set'});
					// 	providerMaster.addRow({});
					// 	gridViewMaster.commit(true);
					// 	gridViewMaster.closeLoading();
					// })
					// .always(function() {
					// 	console.log('gridMasterData complete');
					// });
				}
			</script>
			<div class="level-right" style="width:44%;">
				<div id="account_grid" style="width:100%;height:600px;"></div>
			</div>
			<script>
				var providerAccount, gridViewAccount;

				// modal 에서 값 입력 후 그리드 접근 위해
				var modalTargetGrid;
				var modalTargetIndex;

				document.addEventListener('DOMContentLoaded', function() {
					providerAccount = new RealGrid.LocalDataProvider();
					gridViewAccount = new RealGrid.GridView('account_grid');
					gridViewAccount.setDataSource(providerAccount);
					gridViewAccount.displayOptions.rowHeight = 30;
					gridViewAccount.header.height = 30;
					gridViewAccount.footer.height = 30;

					providerAccount.setFields([
						
					]);

					let accountColumns = [
						{name: '', fieldName: '', width: 60, styleName: 'align-center', header: {text: '매출일자'}}
						, {name: '', fieldName: '', editable: false, styleName: 'editable-false', width: 30, header: {text: '-'}}
						, {
							name: ''
							, fieldName: ''
							, editable: false
							, styleName: 'editable-false align-right'
							, header: {text: '매출금액'}
							, type: 'number'
							, numberFormat: '#,##0'
							, footer: {
								expression: 'sum'
								, numberFormat: '#,##0'
								, text: '매출금액'
								, styleName: 'align-right'
							}
						}
						, {name: '', fieldName: '', editable: false, styleName: 'editable-false', width: 30, header: {text: '-'}}
						, {
							name: ''
							, fieldName: ''
							, editable: false
							, styleName: 'editable-false align-right'
							, header: {text: '전일회수'}
							, type: 'number'
							, numberFormat: '#,##0'
							, footer: {
								expression: 'sum'
								, numberFormat: '#,##0'
								, text: '전일회수'
								, styleName: 'align-right'
							}
						}
						, {name: '', fieldName: '', editable: false, styleName: 'editable-false', width: 30, header: {text: '-'}}
						, {
							name: ''
							, fieldName: ''
							, editable: false
							, styleName: 'editable-false align-right'
							, header: {text: '전일미수'}
							, type: 'number'
							, numberFormat: '#,##0'
							, footer: {
								expression: 'sum'
								, numberFormat: '#,##0'
								, text: '전일미수'
								, styleName: 'align-right'
							}
						}
						, {name: '', fieldName: '', editable: false, styleName: 'editable-false', width: 30, header: {text: '-'}}
						, {
							name: ''
							, fieldName: ''
							, editable: false
							, styleName: 'editable-false align-right'
							, header: {text: '당일회수'}
							, type: 'number'
							, numberFormat: '#,##0'
							, footer: {
								expression: 'sum'
								, numberFormat: '#,##0'
								, text: '당일회수'
								, styleName: 'align-right'
							}
						}
						
					];
					
					gridViewAccount.setColumns(accountColumns);
				});

			</script>
		</div>
		<div>
			<div class="field is-horizontal">
				<div class="field-label is-small mr-2" style="width:120px;">
					<label class="label">매출채권 회수합계</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control is-expanded has-icons-left">
							<input class="input is-small p-1" type="text" id="" value="" size="10" readonly>
						</p>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-small mr-2" style="width:120px;">
					<label class="label">기타입금처리</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control is-expanded has-icons-left">
							<input class="input is-small p-1" type="text" id="" value="" size="10" readonly>
						</p>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-small mr-2" style="width:120px;">
					<label class="label">일지여부</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control is-expanded has-icons-left">
							<input class="input is-small p-1" type="text" id="" value="" size="10" readonly>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>