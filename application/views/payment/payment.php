<!-- 리얼그리드 테마 css -->
<link href="<?=INC_JS_URL?>realgrid.2.6.2/realgrid-sky-blue.css" rel="stylesheet" />
<!-- 리얼그리드 커스컴 수정사항 css -->
<link href="<?=INC_JS_URL?>realgrid.2.6.2/realgrid-custom.css" rel="stylesheet" />
<script src="<?=INC_JS_URL?>realgrid.2.6.2/realgrid-lic.js"></script>
<script src="<?=INC_JS_URL?>realgrid.2.6.2/realgrid.2.6.2.min.js"></script>

<section class="section p-4">
	<div class="container pt-5">
		<h1 class="title mb-4 is-size-5-desktop is-size-6-tablet is-size-6-mobile"><?=$page_title?></h1>
		<div class="columns">
			<div class="column is-7">
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
											<input class="input is-small p-1 datepicker monthpicker" type="text" name="YM" placeholder="" value="<?=$YMF?>" size="4"  readonly onchange="selectYM();">
										</p>
									</div>
									<div class="field">
										<p class="control" style="width:50px;">
											<input class="input is-small p-1" type="text" name="DD" placeholder="" value="<?=$DD?>" size="2" maxlength="2" onchange="selectYM();">
										</p>
									</div>
								</div>
							</div>
						</form>
						<script>
							function selectYM() {
								document.select_ym.submit();
							}
						</script>
					</div>
					<div class="level-right">
						<div class="buttons are-small">
							<!-- <a class="button">도움</a> -->
							<!-- <a class="button">검색</a> -->
							<a class="button" onclick="delPaymentData();">삭제</a>
							<a class="button">인쇄</a>
							<a class="button">복사이동</a>
						</div>
					</div>
				</div>
				<div id="payment_grid" style="width:100%;height:723px;"></div>
			</div>
			<div class="column is-5">
				<div class="mb-4">
					<div class="level-left mb-1">
						<div class="field-label is-small mr-2">
							<label class="label">거래처</label>
						</div>
						<div class="field-body">
							<div class="field">
								<p class="control">
									<input class="input is-small p-1 readonly" type="text" placeholder="거래처코드" id="display_pcds" size="2" readonly>
								</p>
							</div>
							<div class="field">
								<p class="control">
									<input class="input is-small p-1 readonly" type="text" placeholder="거래처명" id="display_pnam" readonly>
								</p>
							</div>
							<div class="field"></div>
							<div class="field"></div>
						</div>
					</div>
					<div class="level-left mb-1">
						<div class="field-label is-small mr-2">
							<label class="label">조회구분</label>
						</div>
						<div class="field-body">
							<div class="field">
								<p class="select is-small">
									<select name="" id="">
										<option value="">조회구분</option>
									</select>
								</p>
							</div>
							<div class="field">
								<p class="control"></p>
							</div>
						</div>
					</div>
					<div class="level-left">
						<div class="field-label is-small mr-2">
							<label class="label">조회기간</label>
						</div>
						<div class="field-body">
							<div class="field">
								<p class="control">
									<input type="date" class="input is-small p-1">
								</p>
							</div>
							<div class="field">
								<p class="control">
									<input type="date" class="input is-small p-1">
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="mb-1" id="account_grid" style="width:100%;height:600px;"></div>
				<div class="columns">
					<div class="column is-4">
						<div class="field-label is-small mr-2">
							<label class="label">입금액</label>
						</div>
						<div class="field-body">
							<div class="field">
								<p class="control">
									<input type="text" class="input is-small p-1" id="row_pamt" reaonly>
								</p>
							</div>
						</div>
					</div>
					<div class="column is-4">
						<div class="field-label is-small mr-2">
							<label class="label">당일회수(기타)</label>
						</div>
						<div class="field-body">
							<div class="field">
								<p class="control">
									<input type="text" class="input is-small p-1" id="row_damt" reaonly>
								</p>
							</div>
						</div>
					</div>
					<div class="column is-4">
						<div class="field-label is-small mr-2">
							<label class="label">차이</label>
						</div>
						<div class="field-body">
							<div class="field">
								<p class="control">
									<input type="text" class="input is-small p-1" id="row_camt" reaonly>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			var COD = '<?=$COD?>';
			var YM = '<?=$YM?>';
			var DD = '<?=$DD?>';
			var DVS = '<?=$DVS?>';

			var providerPayment, gridViewPayment;
			var providerAccount, gridViewAccount;

			// modal 에서 값 입력 후 그리드 접근 위해
			var modalTargetGrid;
			var modalTargetIndex;
			var modalTargetProvider;

			// 선택중인 payment grid 의 pno 값
			var selectedPNO;

			document.addEventListener('DOMContentLoaded', function() {

				// grid payment
				providerPayment = new RealGrid.LocalDataProvider();
				gridViewPayment = new RealGrid.GridView('payment_grid');
				gridViewPayment.setDataSource(providerPayment);
				gridViewPayment.displayOptions.rowHeight = 30;
				gridViewPayment.header.height = 36;
				gridViewPayment.footer.height = 30;



				gridViewPayment.checkBar.useImages = true;
				
				gridViewPayment.setStateBar({
					visible: true,
					width:20,
				});


				gridViewPayment.setCheckBar({
					visible: true,
					showAll: true,

					width: 40,
				});



				providerPayment.setFields([
					{fieldName: 'COD'}
					, {fieldName: 'CDS'}
					, {fieldName: 'NAM'}
					, {fieldName: 'PDT'}
					, {fieldName: 'PDT_DD'}
					, {fieldName: 'PNO'}
					, {fieldName: 'PAMT', dataType: 'number'}
					, {fieldName: 'DAMT', dataType: 'number'}
					, {fieldName: 'CAMT', dataType: 'number'}
					, {fieldName: 'CHKS'}
					, {fieldName: 'PCDS'}
					, {fieldName: 'PNAM'}
					, {fieldName: 'PRMK'}
				]);

				let paymentColumns = [
					{name: 'PDT_DD', fieldName: 'PDT_DD', width: 30, styleName: 'align-center', header: {text: '일'}}
					, {
						name: 'CDS'
						, fieldName: 'CDS'
						, width: 70
						, header: {text: '거래처코드'}
						, editable: false
						, button: 'action'
						, buttonVisibility: 'default'
					}
					, {name: 'NAM', fieldName: 'NAM', editable: false, styleName: 'editable-false', width: 120, header: {text: '거래처명'}}
					, {
						name: 'PAMT'
						, fieldName: 'PAMT'
						, width: 100
						, header: {text: '입금액'}
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
						name: 'PNAM'
						, fieldName: 'PNAM'
						, width: 100
						, header: {text: '입금구분'}
						, editable: false
						, button: 'action'
						, buttonVisibility: 'default'
					}
					, {
						name: 'PRMK'
						, fieldName: 'PRMK'
						, header: {text:'적요'}
					}
					, {
						name: ''
						, fieldName: ''
						, width: 40
						, header: {text:'일치'}
					}
				];
				
				gridViewPayment.setColumns(paymentColumns);

				// 최초 payment 그리드 set
				setPaymentData(DVS, COD, YM, DD);

				// payment 그리드 행 선택
				gridViewPayment.onCurrentRowChanged = function(grid, oldRow, newRow) {
					// console.log('check', oldRow, newRow);
					// console.log(grid);
					providerAccount.clearRows();
					let COD = providerPayment.getValue(newRow, 'COD');
					let CDS = providerPayment.getValue(newRow, 'CDS');
					let PNO = providerPayment.getValue(newRow, 'PNO');
					let PAMT = providerPayment.getValue(newRow, 'PAMT');
					let DAMT = providerPayment.getValue(newRow, 'DAMT');
					let CAMT = providerPayment.getValue(newRow, 'CAMT');
					if (newRow < 0 || !PNO) return;

					console.log('payment gird row changed:' + PNO);

					selectedPNO = PNO;
					setAccountData(COD, CDS, PNO);
					setAccountSummary(PAMT, DAMT, CAMT);

					let PCDS = providerPayment.getValue(newRow, 'PCDS');
					let NAM = providerPayment.getValue(newRow, 'NAM');
					document.getElementById('display_pcds').value = PCDS;
					document.getElementById('display_pnam').value = NAM;
				}

				gridViewPayment.onCellEdited = function(grid, itemIndex, row, field) {
					gridViewPayment.commit(true);
					let current = gridViewPayment.getCurrent();
					let thisValue = providerPayment.getValue(current.dataRow, current.fieldName);

					// pCRUD pCOD  pCDS  pPDT  pDVS  pPNO  pPAMT  pPCDS  pPRMK

					let CDS = providerPayment.getValue(current.dataRow, 'CDS');
					let PDT_DD = providerPayment.getValue(current.dataRow, 'PDT_DD');
					let PNO = providerPayment.getValue(current.dataRow, 'PNO');
					let PAMT = providerPayment.getValue(current.dataRow, 'PAMT');
					let PCDS = providerPayment.getValue(current.dataRow, 'PCDS');
					let PRMK = providerPayment.getValue(current.dataRow, 'PRMK');
					if (Number(PDT_DD) < 10) PDT_DD = '0' + Number(PDT_DD);

					if (!PNO && (PDT_DD && PAMT && CDS && PCDS)) {
						console.log('insert payment row');
						console.log(CDS, (YM + PDT_DD), PNO, PAMT, PCDS, PRMK);
						let ret = savePaymentData(COD, CDS, (YM + PDT_DD), DVS, PAMT, PCDS, PRMK);
						gridViewPayment.commit(true);
					} else if (PNO) {
						console.log('update payment row');
						let ret = updatePaymentData(COD, CDS, (YM + PDT_DD), DVS, PNO, PAMT, PCDS, PRMK);
						gridViewPayment.commit(true);
					}
				}

				gridViewPayment.onCellButtonClicked = function(grid, column) {
					// console.log(grid, column);
					if (column.column == 'CDS') {
						modalTargetGrid = grid;
						modalTargetIndex = column.itemIndex;
						modalTargetProvider = providerPayment;
						openModal('modal-CMPYCDS');
						setCmpyData(COD, '');
					} else if (column.column == 'PNAM') {
						modalTargetGrid = grid;
						modalTargetIndex = column.itemIndex;
						modalTargetProvider = providerPayment;
						openModal('modal-PCDS');
						setPcdsData(COD, '');
					}
				};



				// grid account
				providerAccount = new RealGrid.LocalDataProvider();
				gridViewAccount = new RealGrid.GridView('account_grid');
				gridViewAccount.setDataSource(providerAccount);
				gridViewAccount.displayOptions.rowHeight = 30;
				gridViewAccount.header.height = 36;
				gridViewAccount.footer.height = 30;

				gridViewAccount.checkBar.useImages = true;
				
				gridViewAccount.setStateBar({
					visible: true,
					width:20,
				});


				gridViewAccount.setCheckBar({
					visible: true,
					showAll: true,

					width: 40,
				});

				providerAccount.setFields([
					{fieldName: 'COD'}
					, {fieldName: 'DVS'}
					, {fieldName: 'ENO'}
					, {fieldName: 'CDS'}
					, {fieldName: 'EDTS'}
					, {fieldName: 'GRSS', dataType: 'number'}
					, {fieldName: 'PAYS', dataType: 'number'}
					, {fieldName: 'BLNC', dataType: 'number'}
					, {fieldName: 'PAMT', dataType: 'number'}
					, {fieldName: 'OAMT', dataType: 'number'}
					, {fieldName: 'PRMK'}
				]);

				let accountColumns = [
					{
						name: 'EDTS'
						, fieldName: 'EDTS'
						, width: 70
						, editable: false
						, styleName: 'editable-false align-right'
						, header: {text: '매출일자'}}
					, {
						name: 'GRSS'
						, fieldName: 'GRSS'
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
					, {
						name: 'PAYS'
						, fieldName: 'PAYS'
						, width: 70
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
					, {
						name: 'BLNC'
						, fieldName: 'BLNC'
						, editable: false
						, width: 70
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
					, {
						name: 'PAMT'
						, fieldName: 'PAMT'
						, width: 70
						, styleName: 'align-right'
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
					, {
						name: 'OAMT'
						, fieldName: 'OAMT'
						, width: 70
						, styleName: 'align-right'
						, header: {text: '기타'}
						, type: 'number'
						, numberFormat: '#,##0'
						, footer: {
							expression: 'sum'
							, numberFormat: '#,##0'
							, text: '기타'
							, styleName: 'align-right'
						}
					}
				];

				gridViewAccount.setColumns(accountColumns);

				gridViewAccount.onCellEdited = function(grid, itemIndex, row, field) {
					gridViewAccount.commit(true);
					let current = gridViewAccount.getCurrent();
					let thisValue = providerAccount.getValue(current.dataRow, current.fieldName);

					let COD = providerAccount.getValue(current.dataRow, 'COD');
					let DVS = providerAccount.getValue(current.dataRow, 'DVS');
					let ENO = providerAccount.getValue(current.dataRow, 'ENO');
					let CDS = providerAccount.getValue(current.dataRow, 'CDS');
					let EDTS = providerAccount.getValue(current.dataRow, 'EDTS');
					let GRSS = providerAccount.getValue(current.dataRow, 'GRSS');
					let PAYS = providerAccount.getValue(current.dataRow, 'PAYS');
					let BLNC = providerAccount.getValue(current.dataRow, 'BLNC');
					let PAMT = providerAccount.getValue(current.dataRow, 'PAMT');
					let OAMT = providerAccount.getValue(current.dataRow, 'OAMT');
					let PRMK = providerAccount.getValue(current.dataRow, 'PRMK');
					gridViewAccount.commit(true);


					console.log('update account row');
					let ret = updateAccountData(COD, CDS, selectedPNO, DVS, ENO, PAMT, OAMT, PRMK);
				}
				
			});
			
			// data json 가져오기 payment grid
			function setPaymentData(DVS, COD, YM, D) {
				console.log(DVS, COD, YM, D);
				gridViewPayment.showLoading();
				$.ajax({
					url: '/payment/gridPaymentData/',
					type: 'post',
					dataType: 'json',
					data: {DVS: DVS, COD: COD, YM: YM, D: D},
				})
				.done(function(jsonData) {
					// console.log(jsonData);
					providerPayment.fillJsonData(jsonData, {fillMode : 'set'});
					providerPayment.addRow({});
					gridViewPayment.commit(true);
					gridViewPayment.closeLoading();
				})
				.always(function() {
					console.log('gridPaymentData complete');
				});
			}

			// payment data insert
			function savePaymentData(COD, CDS, PDT, DVS, PAMT, PCDS, PRMK) {
				gridViewPayment.showLoading();
				$.ajax({
					url: '/payment/updatePaymentData',
					type: 'post',
					dataType: 'json',
					data: {
						CRUD: 'C'
						, COD: COD
						, CDS: CDS
						, PDT: PDT
						, DVS: DVS
						, PAMT: PAMT
						, PCDS: PCDS
						, PRMK: PRMK
					},
				})
				.done(function(res) {
					console.log('save payment data success');
					setPaymentData(DVS, COD, YM, DD);
					gridViewPayment.closeLoading();
				})
				.always(function(complete) {
					console.log("complete");
					// console.log(complete);
				});
			}

			function updatePaymentData(COD, CDS, PDT, DVS, PNO, PAMT, PCDS, PRMK) {
				gridViewPayment.showLoading();
				$.ajax({
					url: '/payment/updatePaymentData',
					type: 'post',
					dataType: 'json',
					data: {
						CRUD: 'U'
						, COD: COD
						, CDS: CDS
						, PDT: PDT
						, DVS: DVS
						, PNO: PNO
						, PAMT: PAMT
						, PCDS: PCDS
						, PRMK: PRMK
					},
				})
				.done(function(res) {
					// console.log("success");
					// let YM = DTS.substring(0, 4);
					setPaymentData(DVS, COD, YM, DD);
					gridViewPayment.closeLoading();
				})
				.always(function(complete) {
					console.log("complete");
					// console.log(complete);
				});
			}

			function delPaymentData() {
				let provider = providerPayment;
				let gridView = gridViewPayment;
				let checked = gridView.getCheckedRows();
				let checkCnt = checked.length;
				let checkedCOD;
				let checkedCDS;
				let checkedPNO;

				if (checked.length < 1 || checked.length > 1) {
					alert('1개 항목을 선택해주세요.');
					return false;
				}

				checked.forEach(function(row, idx) {
					checkedCOD = provider.getValue(row, 'COD');
					checkedCDS = provider.getValue(row, 'CDS');
					checkedPNO = provider.getValue(row, 'PNO');
				});

				if (confirm('자료를 삭제합니다.')) {
					gridView.showLoading();
					$.ajax({
						url: '/payment/updatePaymentData',
						type: 'post',
						dataType: 'json',
						data: {
							CRUD: 'D'
							, COD: checkedCOD
							, CDS: checkedCDS
							, PNO: checkedPNO
						},
					})
					.done(function(res) {
						// console.log("success");
						// let YM = DTS.substring(0, 4);
						setPaymentData(DVS, COD, YM, DD);
						gridView.closeLoading();
					})
					.always(function(complete) {
						console.log("complete");
						console.log(complete);
					});
				}
			}

			// data json 가져오기 account grid
			function setAccountData(COD, CDS, PNO) {
				gridViewAccount.showLoading();
				$.ajax({
					url: '/payment/gridAccountData/',
					type: 'post',
					dataType: 'json',
					data: {COD: COD, CDS: CDS, PNO: PNO},
				})
				.done(function(jsonData) {
					// console.log(jsonData);
					providerAccount.fillJsonData(jsonData, {fillMode : 'set'});
					gridViewAccount.commit(true);
					gridViewAccount.closeLoading();
				})
				.always(function() {
					console.log('gridPaymentData complete');
				});
			}

			// account grid 하단 정보
			function setAccountSummary(PAMT, DAMT, CAMT) {
				document.getElementById('row_pamt').value = PAMT ? PAMT : '';
				document.getElementById('row_damt').value = DAMT ? DAMT : '';
				document.getElementById('row_camt').value = CAMT ? CAMT : '';
			}

			function updateAccountData(COD, CDS, PNO, DVS, ENO, PAMT, OAMT, PRMK) {
				gridViewAccount.showLoading();
				$.ajax({
					url: '/payment/updateAccountData',
					type: 'post',
					dataType: 'json',
					data: {
						COD: COD
						, CDS: CDS
						, PNO: PNO
						, DVS: DVS
						, ENO: ENO
						, PAMT: PAMT
						, OAMT: OAMT
						, PRMK: PRMK
					},
				})
				.done(function(res) {
					console.log("update account data success");
					setAccountData(COD, CDS, PNO);
					setPaymentData(DVS, COD, YM, DD);
					gridViewAccount.closeLoading();
				})
				.always(function(complete) {
					console.log("complete");
					// console.log(complete);
				});
			}
		</script>
</section>