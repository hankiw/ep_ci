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
			<div class="column is-4">
				<form id="search_invoice" name="search_invoice">
					<div class="level-left">
						<div class="field-label is-small">
							<label class="label">거래년월</label>
						</div>
						<div class="field-body">
							<div class="field">
								<p class="control">
									<input type="text" class="input is-small p-1 datepicker monthpicker" name="SDT" id="SDT" value="<?=$sdt?>" readonly onchange="searchInvoice();">
								</p>
							</div>
						</div>
					</div>
				</form>
				<script>
					function searchInvoice() {
						document.search_invoice.submit();
					}
				</script>
			</div>
			<div class="column is-8">
				<div class="level-right">
					<div class="buttons are-small">
						<a class="button" onclick="btnEtaxMulti();">합산발행</a>
						<a class="button mr-5" onclick="btnEtaxMultiCancel();">발행취소</a>
						<a href="" class="button">도움</a>
						<a href="" class="button">검색</a>
						<a class="button" onclick="alert('준비중');">삭제</a>
						<a href="" class="button">인쇄</a>
						<a href="" class="button">복사이동</a>
					</div>
				</div>
			</div>
		</div>
		<script>
			// 합산발행 전송 버튼
			function btnEtaxMulti() {
				let checked = gridViewSales.getCheckedRows();
				let checkCnt = checked.length;
				let checkedNOS = '';
				let selected = gridViewCompany.getCurrent();
				let selectedCDS = (selected.itemIndex > 0) ? providerCompany.getValue(selected.dataRow, 'CDS') : '';

				for (let row of checked) {
					checkedNOS += (checkedNOS == '') ? providerSales.getValue(row, 'NOS') : (',' + providerSales.getValue(row, 'NOS'));
				}

				if (checked.length < 1) {
					alert('1개 이상의 항목을 선택해주세요.');
					return false;
				}

				if (!confirm(checked.length + '건의 합산 세금계산서를 발행합니다.')) {
					return false;
				}

				makeEtaxMultiRun(COD, checkedNOS, selectedCDS);
			}

			// 세금계산서 합산 전송
			function makeEtaxMultiRun(COD, checkedNOS, selectedCDS) {
				if (!checkedNOS) {
					alert('필수 입력값을 입력해 주세요.');
					return false;
				}
				gridViewSales.showLoading();
				gridViewInvoice.showLoading();
				$.ajax({
					url: '/etax/makeEtaxMulti/',
					type: 'post',
					dataType: 'json',
					data: {
						checkedNOS: checkedNOS
						, COD: COD
					},
				})
				.done(function(res) {
					console.log('make etax:' + res);
					if (res) {
						alert('전송되었습니다.');
						setCompanyData(COD, DVS, document.getElementById('SDT').value.replaceAll('-', ''), document.getElementById('SDT').value.replaceAll('-', ''));
						setSalesData(COD, DVS, document.getElementById('SDT').value.replaceAll('-', ''), document.getElementById('SDT').value.replaceAll('-', ''), selectedCDS);
						setInvoiveData(COD, DVS, document.getElementById('SDT').value.replaceAll('-', ''), document.getElementById('SDT').value.replaceAll('-', ''), selectedCDS);
					}
				})
				.always(function(res) {
					console.log(res);
					gridViewSales.closeLoading();
					gridViewInvoice.closeLoading();
				});
			}

			// 합상발행 전송 취소 버튼
			function btnEtaxMultiCancel() {
				let checked = gridViewInvoice.getCheckedRows();
				let checkCnt = checked.length;
				let checkedTNO = [];
				let rowTNO = '';
				let selected = gridViewCompany.getCurrent();
				let selectedCDS = (selected.itemIndex > 0) ? providerCompany.getValue(selected.dataRow, 'CDS') : '';

				for (let row of checked) {
					rowTNO = providerInvoice.getValue(row, 'TNO');
					if (checkedTNO.indexOf(rowTNO) < 0) {
						checkedTNO.push(rowTNO);
					}
				}

				if (checkedTNO.length < 1) {
					alert('1개 이상의 항목을 선택해주세요.');
					return false;
				}

				if (!confirm(checked.length + '건의 합산 세금계산서를 취소합니다.')) {
					return false;
				}

				cancelEtaxMultiRun(COD, checkedTNO, selectedCDS);
			}

			// 세금계산서 합산 전송최소
			function cancelEtaxMultiRun(COD, checkedTNO, selectedCDS) {
				if (!checkedTNO || checkedTNO.length < 1) {
					alert('필수 입력값을 입력해 주세요.');
					return false;
				}
				gridViewSales.showLoading();
				gridViewInvoice.showLoading();
				$.ajax({
					url: '/etax/cancelEtaxMulti/',
					type: 'post',
					dataType: 'json',
					data: {
						checkedTNO: checkedTNO
						, COD: COD
					},
				})
				.done(function(res) {
					console.log('cancel etax:' + res);
					if (res) {
						alert('전송이 취소되었습니다.');
						setCompanyData(COD, DVS, document.getElementById('SDT').value.replaceAll('-', ''), document.getElementById('SDT').value.replaceAll('-', ''));
						setSalesData(COD, DVS, document.getElementById('SDT').value.replaceAll('-', ''), document.getElementById('SDT').value.replaceAll('-', ''), selectedCDS);
						setInvoiveData(COD, DVS, document.getElementById('SDT').value.replaceAll('-', ''), document.getElementById('SDT').value.replaceAll('-', ''), selectedCDS);
					}
				})
				.always(function(res) {
					console.log(res);
					gridViewSales.closeLoading();
					gridViewInvoice.closeLoading();
				});
			}
		</script>
		<div class="columns">
			<div class="column is-5">
				<div id="company_grid" style="width:100%;height:600px;"></div>
			</div>

			<div class="column is-7">
				<div id="sales_grid" class="mb-4" style="width:100%;height:292px;"></div>
				<div id="invoice_grid" style="width:100%;height:292px;"></div>
			</div>
		</div>
		<script>
			var COD = '<?=$COD?>';
			var YM = '<?=$YM?>';
			var DVS = '<?=$DVS?>';

			var providerCompany, gridViewCompany;
			var providerInvoice, gridViewInvoice;
			var providerSales, gridViewSales;

			// modal 에서 값 입력 후 그리드 접근 위해
			var modalTargetGrid;
			var modalTargetIndex;
			var modalTargetProvider;

			// 선택중인 Company grid 의 cds 값
			var selectedCDS;

			document.addEventListener('DOMContentLoaded', function() {

				// grid payment
				providerCompany = new RealGrid.LocalDataProvider();
				gridViewCompany = new RealGrid.GridView('company_grid');
				gridViewCompany.setDataSource(providerCompany);
				gridViewCompany.displayOptions.rowHeight = 30;
				gridViewCompany.header.height = 36;
				gridViewCompany.footer.height = 30;



				gridViewCompany.checkBar.useImages = true;
				
				gridViewCompany.setStateBar({
					visible: true,
					width:20,
				});


				gridViewCompany.setCheckBar({
					visible: false,
					showAll: true,

					width: 40,
				});




				providerCompany.setFields([
					{fieldName: 'COD'}
					, {fieldName: 'CDS'}
					, {fieldName: 'NAM'}
					, {fieldName: 'CNT_TRS'}
					, {fieldName: 'CNT_NOT'}
				]);

				let companyColumns = [
					{
						name: 'CDS'
						, fieldName: 'CDS'
						, width: 80
						, header: {text: '거래처코드'}
						, editable: false
						, button: 'action'
						, buttonVisibility: 'default'
					}
					, {
						name: 'NAM'
						, fieldName: 'NAM'
						, width: 150
						, editable: false
						, styleName: 'editable-false'
						, header: {text: '거래처명'}
					}
					, {
						name: 'CNT_TRS'
						, fieldName: 'CNT_TRS'
						, width: 50
						, editable: false
						, styleName: 'editable-false'
						, header: {text: '전송'}
					}
					, {
						name: 'CNT_NOT'
						, fieldName: 'CNT_NOT'
						, width: 50
						, editable: false
						, styleName: 'editable-false'
						, header: {text: '미전송'}
					}
				];
				
				gridViewCompany.setColumns(companyColumns);

				// 최초 payment 그리드 set
				setCompanyData(COD, DVS, document.getElementById('SDT').value.replaceAll('-', ''), document.getElementById('SDT').value.replaceAll('-', ''));

				// payment 그리드 행 선택
				gridViewCompany.onCurrentRowChanged = function(grid, oldRow, newRow) {
					// console.log('check', oldRow, newRow);
					// console.log(grid);

					providerInvoice.clearRows();
					let COD = providerCompany.getValue(newRow, 'COD');
					let CDS = providerCompany.getValue(newRow, 'CDS');
					if (newRow < 0 || !CDS) return;

					selectedCDS = CDS;

					console.log('company gird row changed:' + CDS);

					setSalesData(COD, DVS, document.getElementById('SDT').value.replaceAll('-', ''), document.getElementById('SDT').value.replaceAll('-', ''), CDS);
					setInvoiveData(COD, DVS, document.getElementById('SDT').value.replaceAll('-', ''), document.getElementById('SDT').value.replaceAll('-', ''), CDS);
				}


				// grid invoice
				providerSales = new RealGrid.LocalDataProvider();
				gridViewSales = new RealGrid.GridView('sales_grid');
				gridViewSales.setDataSource(providerSales);
				gridViewSales.displayOptions.rowHeight = 30;
				gridViewSales.header.height = 36;
				gridViewSales.footer.height = 30;

				gridViewSales.checkBar.useImages = true;
				
				gridViewSales.setStateBar({
					visible: true,
					width:20,
				});

				gridViewSales.setCheckBar({
					visible: true,
					showAll: true,
					width: 40,
				});

				providerSales.setFields([
					{fieldName: 'COD'}
					, {fieldName: 'DVS'}
					, {fieldName: 'DTS'}
					, {fieldName: 'NOS'}
					, {fieldName: 'TYP'}
					, {fieldName: 'GBN'}
					, {fieldName: 'CDS'}
					, {fieldName: 'NAM'}
					, {fieldName: 'NET', dataType: 'number'}
					, {fieldName: 'VAT', dataType: 'number'}
					, {fieldName: 'GRS', dataType: 'number'}
					, {fieldName: 'TRS'}
					, {fieldName: 'EBL'}
					, {fieldName: 'ENO'}
					, {fieldName: 'PNAM'}
					, {fieldName: 'CNTS', dataType: 'number'}
				]);

				let SalesColumns = [
					{
						name: 'DTS'
						, fieldName: 'DTS'
						, width: 70
						, editable: false
						, styleName: 'editable-false align-right'
						, header: {text: '거래일자'}
					}
					, {
						name: 'NOS'
						, fieldName: 'NOS'
						, width: 120
						, editable: false
						, styleName: 'editable-false align-right'
						, header: {text: '명세서번호'}
					}
					, {
						name: 'NET'
						, fieldName: 'NET'
						, width: 80
						, editable: false
						, styleName: 'editable-false align-right'
						, header: {text: '공급가액'}
						, type: 'number'
						, numberFormat: '#,##0'
						, footer: {
							expression: 'sum'
							, numberFormat: '#,##0'
							, text: '공급가액'
							, styleName: 'align-right'
						}
					}
					, {
						name: 'VAT'
						, fieldName: 'VAT'
						, width: 80
						, editable: false
						, styleName: 'editable-false align-right'
						, header: {text: '부가세액'}
						, type: 'number'
						, numberFormat: '#,##0'
						, footer: {
							expression: 'sum'
							, numberFormat: '#,##0'
							, text: '부가세액'
							, styleName: 'align-right'
						}
					}
					, {
						name: 'GRS'
						, fieldName: 'GRS'
						, editable: false
						, width: 80
						, styleName: 'editable-false align-right'
						, header: {text: '합계금액'}
						, type: 'number'
						, numberFormat: '#,##0'
						, footer: {
							expression: 'sum'
							, numberFormat: '#,##0'
							, text: '합계금액'
							, styleName: 'align-right'
						}
					}
					, {name: 'PNAM', fieldName: 'PNAM', editable: false, styleName: 'editable-false', width: 60, header: {text: '대표품목'}}
					, {
						name: 'CNTS'
						, fieldName: 'CNTS'
						, editable: false
						, width: 60
						, styleName: 'editable-false align-right'
						, header: {text: '품목수'}
						, type: 'number'
						, numberFormat: '#,##0'
						, footer: {
							expression: 'sum'
							, numberFormat: '#,##0'
							, text: '품목수'
							, styleName: 'align-right'
						}
					}
					, {name: 'TRS', fieldName: 'TRS', editable: false, styleName: 'editable-false', width: 60, header: {text: '전송'}}
					, {name: 'EBL', fieldName: 'EBL', editable: false, styleName: 'editable-false', width: 60, header: {text: '전자발행'}}
					, {name: 'ENO', fieldName: 'ENO', editable: false, styleName: 'editable-false', width: 60, header: {text: '발행번호'}}
				];

				gridViewSales.setColumns(SalesColumns);

				// grid invoice
				providerInvoice = new RealGrid.LocalDataProvider();
				gridViewInvoice = new RealGrid.GridView('invoice_grid');
				gridViewInvoice.setDataSource(providerInvoice);
				gridViewInvoice.displayOptions.rowHeight = 30;
				gridViewInvoice.header.height = 36;
				gridViewInvoice.footer.height = 30;

				gridViewInvoice.checkBar.useImages = true;
				
				gridViewInvoice.setStateBar({
					visible: true,
					width:20,
				});

				gridViewInvoice.setCheckBar({
					visible: true,
					showAll: true,
					width: 40,
				});

				providerInvoice.setFields([
					{fieldName: 'COD'}
					, {fieldName: 'DTS'}
					, {fieldName: 'TNO'}
					, {fieldName: 'NOS'}
					, {fieldName: 'TYP'}
					, {fieldName: 'GBN'}
					, {fieldName: 'CDS'}
					, {fieldName: 'NAM'}
					, {fieldName: 'NET', dataType: 'number'}
					, {fieldName: 'VAT', dataType: 'number'}
					, {fieldName: 'GRS', dataType: 'number'}
					, {fieldName: 'TRS'}
					, {fieldName: 'EBL'}
					, {fieldName: 'ENO'}
					, {fieldName: 'PNAM'}
					, {fieldName: 'CNTS', dataType: 'number'}
				]);

				let invoiceColumns = [
					{
						name: 'TNO'
						, fieldName: 'TNO'
						, width: 100
						, editable: false
						, styleName: 'editable-false align-right'
						, header: {text: '전송번호'}
						, mergeRule:{criteria: "value"}
					}
					, {
						name: 'DTS'
						, fieldName: 'DTS'
						, width: 80
						, editable: false
						, styleName: 'editable-false align-right'
						, header: {text: '전송일자'}
					}
					, {
						name: 'NOS'
						, fieldName: 'NOS'
						, width: 100
						, editable: false
						, styleName: 'editable-false align-right'
						, header: {text: '명세서번호'}
					}
					, {
						name: 'NET'
						, fieldName: 'NET'
						, width: 70
						, editable: false
						, styleName: 'editable-false align-right'
						, header: {text: '공급가액'}
						, type: 'number'
						, numberFormat: '#,##0'
						, footer: {
							expression: 'sum'
							, numberFormat: '#,##0'
							, text: '공급가액'
							, styleName: 'align-right'
						}
					}
					, {
						name: 'VAT'
						, fieldName: 'VAT'
						, width: 70
						, editable: false
						, styleName: 'editable-false align-right'
						, header: {text: '부가세액'}
						, type: 'number'
						, numberFormat: '#,##0'
						, footer: {
							expression: 'sum'
							, numberFormat: '#,##0'
							, text: '부가세액'
							, styleName: 'align-right'
						}
					}
					, {
						name: 'GRS'
						, fieldName: 'GRS'
						, editable: false
						, width: 70
						, styleName: 'editable-false align-right'
						, header: {text: '합계금액'}
						, type: 'number'
						, numberFormat: '#,##0'
						, footer: {
							expression: 'sum'
							, numberFormat: '#,##0'
							, text: '합계금액'
							, styleName: 'align-right'
						}
					}
					, {
						name: 'PNAM'
						, fieldName: 'PNAM'
						, editable: false
						, styleName: 'editable-false'
						, width: 80
						, header: {text: '대표품목'}
					}
					, {
						name: 'CNTS'
						, fieldName: 'CNTS'
						, editable: false
						, width: 60
						, styleName: 'editable-false align-right'
						, header: {text: '품목수'}
						, type: 'number'
						, numberFormat: '#,##0'
						, footer: {
							expression: 'sum'
							, numberFormat: '#,##0'
							, text: '품목수'
							, styleName: 'align-right'
						}
					}
				];

				gridViewInvoice.setColumns(invoiceColumns);
				gridViewInvoice.groupBy(['TNO', 'DTS']);
				gridViewInvoice.setRowGroup({
				    mergeMode: false
				    , expandedAdornments: false
				    , collapsedAdornments: false
				    , indentVisible: false
				});
				gridViewInvoice.checkBar.mergeRule = 'value["TNO"]';
			});
			
			// data json 가져오기 payment grid
			function setCompanyData(COD, DVS, SDT, EDT) {
				console.log(COD, DVS, SDT, EDT);
				gridViewCompany.showLoading();
				$.ajax({
					url: '/etax/gridCompanyData/',
					type: 'post',
					dataType: 'json',
					data: {COD: COD, DVS: DVS, SDT: SDT, EDT: EDT},
				})
				.done(function(jsonData) {
					console.log(jsonData);
					providerCompany.fillJsonData(jsonData, {fillMode : 'set'});
					gridViewCompany.commit(true);
					gridViewCompany.closeLoading();
				})
				.always(function() {
					console.log('gridCompanyData complete');
				});
			}


			// data json 가져오기 invoice grid
			function setSalesData(COD, DVS, SDT, EDT, CDS) {
				gridViewSales.showLoading();
				$.ajax({
					url: '/etax/gridSalesData/',
					type: 'post',
					dataType: 'json',
					data: {COD: COD, DVS: DVS, SDT: SDT, EDT: EDT, CDS: CDS},
				})
				.done(function(jsonData) {
					// console.log(jsonData);
					providerSales.fillJsonData(jsonData, {fillMode : 'set'});
					gridViewSales.commit(true);
					gridViewSales.closeLoading();
				})
				.always(function() {
					console.log('gridSalesData complete');
				});
			}

			function setInvoiveData(COD, DVS, SDT, EDT, CDS) {
				gridViewInvoice.showLoading();
				$.ajax({
					url: '/etax/gridInvoiveData/',
					type: 'post',
					dataType: 'json',
					data: {COD: COD, DVS: DVS, SDT: SDT, EDT: EDT, CDS: CDS},
				})
				.done(function(jsonData) {
					// console.log(jsonData);
					providerInvoice.fillJsonData(jsonData, {fillMode : 'set'});
					gridViewInvoice.commit(true);
					gridViewInvoice.closeLoading();
				})
				.always(function() {
					console.log('gridPaymentData complete');
				});
			}

		</script>
</section>