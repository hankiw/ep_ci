<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<link href="<?=JS_URL?>realgrid.2.6.2/realgrid-style.css" rel="stylesheet" />
<script src="<?=JS_URL?>realgrid.2.6.2/realgrid-lic.js"></script>
<script src="<?=JS_URL?>realgrid.2.6.2/realgrid.2.6.2.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<section class="section p-4">
	<div class="container">
		

		<div>
			<div id="master_grid" class="mb-2" style="width:100%;height:300px;"></div>
			<div class="level mb-2">
				<div class="level-left">
					<div class="field is-horizontal">
						<div class="field-label is-small mr-2" style="width:120px;">
							<label class="label">명세서</label>
						</div>
						<div class="field-body">
							<div class="field">
								<p class="control is-expanded has-icons-left">
									<input class="input is-small p-1" type="text" id="selected_cds" value="" size="10" readonly>
								</p>
							</div>
							<div class="field">
								<p class="control is-expanded has-icons-left has-icons-right">
									<input class="input is-small p-1" type="text" id="selected_nos" value="" size="10" readonly>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="detail_grid" style="width:100%;height:300px;"></div>
			<script>
				var providerMaster, gridViewMaster, providerDetail, gridViewDetail;
				var COD = '<?=$COD?>';
				var DVS = '<?=$DVS?>';
				var YM = '<?=$YM?>';
				var DD = '<?=$DD?>';

				// modal 에서 값 입력 후 그리드 접근 위해
				var modalTargetGrid;
				var modalTargetIndex;

				document.addEventListener('DOMContentLoaded', function() {
					providerMaster = new RealGrid.LocalDataProvider();
					gridViewMaster = new RealGrid.GridView('master_grid');
					gridViewMaster.setDataSource(providerMaster);

					providerDetail = new RealGrid.LocalDataProvider();
					gridViewDetail = new RealGrid.GridView('detail_grid');
					gridViewDetail.setDataSource(providerDetail);

					providerMaster.setFields([
						{fieldName: 'COD'}
						, {fieldName: 'DVS'}
						, {fieldName: 'DTS'}
						, {fieldName: 'DTS_DD'}
						, {fieldName: 'NOS'}
						, {fieldName: 'TYP'}
						, {fieldName: 'GBN'}
						, {fieldName: 'CDS'}
						, {fieldName: 'NAM'}
						, {fieldName: 'NET'}
						, {fieldName: 'VAT'}
						, {fieldName: 'GRS'}
						, {fieldName: 'TRS'}
						, {fieldName: 'EBL'}
						, {fieldName: 'ENO'}
					]);

					gridViewMaster.setColumns([
						{name: 'DTS_DD', fieldName: 'DTS_DD', width: 30, header: {text: '일'}}
						, {
							name: 'TYP'
							, fieldName: 'TYP'
							, width: 100
							, header: {text: '유형'}
							, editor: {type: 'dropdown', domainOnly: true, textReadOnly: true}
							, values: ['1', '2', '6', '7', '8']
							, labels: ['1.세금계산서', '2.계산서', '6.신용카드', '7.현금영수증', '8.기타']
							, lookupDisplay: true
						}
						, {name: 'GBN', fieldName: 'GBN', width: 60, header: {text: '발행구분'}}
						, {
							name: 'CDS'
							, fieldName: 'CDS'
							, width: 80
							, header: {text: '거래처코드'}
							, button: 'action'
							, buttonVisibility: 'default'
							// , editor: {type: 'dropdown', domainOnly: true, textReadOnly: true}
							// , values: codsValues
							// , labels: codsValues
							// , lookupDisplay: true
						}
						, {name: 'NAM', fieldName: 'NAM', editable: false, width: 100, header: {text: '거래처명'}}
						, {name: 'NOS', fieldName: 'NOS', editable: false, width: 110, header: {text: '명세서번호'}}
						, {name: 'NET', fieldName: 'NET', header: {text: '공급가액'}}
						, {name: 'VAT', fieldName: 'VAT', header: {text: '부가세액'}}
						, {name: 'GRS', fieldName: 'GRS', header: {text: '합계금액'}}
						, {name: 'TRS', fieldName: 'TRS', header: {text: '전송'}}
						, {name: 'EBL', fieldName: 'EBL', width: 60, header: {text: '전자발행'}}
						, {name: 'ENO', fieldName: 'ENO', width: 60, header: {text: '발행번호'}}
					]);

					providerDetail.setFields([
						{fieldName: 'COD'}
						, {fieldName: 'DVS'}
						, {fieldName: 'DTS'}
						, {fieldName: 'NOS'}
						, {fieldName: 'SEQS'}
						, {fieldName: 'DSEQ'}
						, {fieldName: 'PCOD'}
						, {fieldName: 'NAM'}
						, {fieldName: 'STD'}
						, {fieldName: 'UNT'}
						, {fieldName: 'QTYS'}
						, {fieldName: 'PRIC'}
						, {fieldName: 'NETS'}
						, {fieldName: 'VATS'}
						, {fieldName: 'GRSS'}
						, {fieldName: 'REMK'}
						, {fieldName: 'RETN'}
						, {fieldName: 'PAMT'}
						, {fieldName: 'BNFT'}
					]);

					gridViewDetail.setColumns([
						{
							name: 'PCOD'
							, fieldName: 'PCOD'
							, width: 80
							, header: {text: '품번'}
							, button: 'action'
							, buttonVisibility: 'default'
							// , editor: {type: 'dropdown', domainOnly: true, textReadOnly: true}
							// , values: prodValues
							// , labels: prodValues
							// , lookupDisplay: true
						}
						, {name: 'NAM', fieldName: 'NAM', width: 100, editable: false, header: {text:'품명'} }
						, {name: 'QTYS', fieldName: 'QTYS', width: 80, header: {text:'수량'} }
						, {name: 'SEQS', fieldName: 'SEQS', width: 40, editable: false, header: {text:'순번'} }
						, {name: 'DSEQ', fieldName: 'DSEQ', width: 40, header: {text:'표시순번'} }
						, {name: 'PRIC', fieldName: 'PRIC', header: {text:'단가'} }
						, {name: 'NETS', fieldName: 'NETS', header: {text:'공급가액'} }
						, {name: 'VATS', fieldName: 'VATS', header: {text:'부가세액'} }
						, {name: 'GRSS', fieldName: 'GRSS', header: {text:'합계금액'} }
						, {name: 'REMK', fieldName: 'REMK', header: {text:'적요'} }
						, {name: 'RETN', fieldName: 'RETN', header: {text:'반품구분'} }
						, {name: 'PAMT', fieldName: 'PAMT', header: {text:'매입금액'} }
						, {name: 'BNFT', fieldName: 'BNFT', header: {text:'판매이익'} }
					]);

					// 최초 master 그리드 set
					setMasterData(DVS, COD, YM, DD);

					// master 그리드 행 선택
					gridViewMaster.onCurrentRowChanged = function(grid, oldRow, newRow) {
						// console.log('check', oldRow, newRow);
						// console.log(grid);
						providerDetail.clearRows();
						let COD = providerMaster.getValue(newRow, 'COD');
						let DVS = providerMaster.getValue(newRow, 'DVS');
						let DTS = providerMaster.getValue(newRow, 'DTS');
						let NOS = providerMaster.getValue(newRow, 'NOS');
						if (newRow < 0 || !NOS) return;
						
						// 거래처 정보
						let CDS = providerMaster.getValue(newRow, 'CDS');
						let NAM = providerMaster.getValue(newRow, 'NAM');
						document.getElementById('selected_cds').value = NAM;
						document.getElementById('selected_nos').value = NOS;
						
						setDetailData(COD, DVS, DTS, NOS);
					}

					gridViewMaster.onCellEdited = function(grid, itemIndex, row, field) {
						gridViewMaster.commit(true);
						let current = gridViewMaster.getCurrent();
						let thisValue = providerMaster.getValue(current.dataRow, current.fieldName);
						let NOS = providerMaster.getValue(current.dataRow, 'NOS');
						let DTSDD = providerMaster.getValue(current.dataRow, 'DTS_DD');
						let TYP = providerMaster.getValue(current.dataRow, 'TYP');
						let GBN = providerMaster.getValue(current.dataRow, 'GBN');
						let CDS = providerMaster.getValue(current.dataRow, 'CDS');
						let NET = providerMaster.getValue(current.dataRow, 'NET');
						let VAT = providerMaster.getValue(current.dataRow, 'VAT');
						let GRS = providerMaster.getValue(current.dataRow, 'GRS');
						let TRS = providerMaster.getValue(current.dataRow, 'TRS');
						let EBL = providerMaster.getValue(current.dataRow, 'EBL');
						let ENO = providerMaster.getValue(current.dataRow, 'ENO');

						if (Number(DTSDD) < 10) DTSDD = '0' + Number(DTSDD);

						if (!NOS && (DTSDD && TYP && GBN && CDS)) {
							console.log('check1', (YM + DTSDD), TYP, GBN, CDS);
							let ret = saveRowData((YM + DTSDD), TYP, GBN, CDS);
							gridViewMaster.commit(true);
						} else if (NOS) {
							console.log('master row update');
							let ret = updateRowData(COD, DVS, NOS, (YM + DD), TYP, GBN, CDS, NET, VAT, GRS, TRS, EBL, ENO);
							gridViewMaster.commit(true);
						}
					}

					gridViewDetail.onCellEdited = function(grid, itemIndex, row, field) {
						gridViewDetail.commit(true);
						let current = gridViewDetail.getCurrent();
						let thisValue = providerDetail.getValue(current.dataRow, current.fieldName);
						let rowData = [];
						let PCOD = providerDetail.getValue(current.dataRow, 'PCOD');
						let NAM = providerDetail.getValue(current.dataRow, 'NAM');
						let QTYS = providerDetail.getValue(current.dataRow, 'QTYS');
						let SEQS = providerDetail.getValue(current.dataRow, 'SEQS');
						let DSEQ = providerDetail.getValue(current.dataRow, 'DSEQ');
						let PRIC = providerDetail.getValue(current.dataRow, 'PRIC');
						let NETS = providerDetail.getValue(current.dataRow, 'NETS');
						let VATS = providerDetail.getValue(current.dataRow, 'VATS');
						let GRSS = providerDetail.getValue(current.dataRow, 'GRSS');
						let REMK = providerDetail.getValue(current.dataRow, 'REMK');
						let RETN = providerDetail.getValue(current.dataRow, 'RETN');
						let PAMT = providerDetail.getValue(current.dataRow, 'PAMT');
						let BNFT = providerDetail.getValue(current.dataRow, 'BNFT');

						console.log(NAM, PCOD, QTYS);

						if (!NAM && (PCOD && QTYS)) {
							let result = saveRowDataDetail(current.dataRow, PCOD, QTYS, NOS);
							gridViewDetail.commit(true);
						} else if (NAM && PCOD && QTYS){
							console.log(PCOD, QTYS, NOS, SEQS, DSEQ, PRIC, NETS, VATS, GRSS, REMK, RETN, PAMT, BNFT);
							let result = updateRowDataDetail(PCOD, QTYS, NOS, SEQS, DSEQ, PRIC, NETS, VATS, GRSS, REMK, RETN, PAMT, BNFT);
							gridViewDetail.commit(true);
						}
					}

					gridViewMaster.onCellButtonClicked = function(grid, column) {
						console.log(grid, column);
						if (column.column == 'CDS') {
							modalTargetGrid = grid;
							modalTargetIndex = column.itemIndex;
							openModal('modal-CMPY');
							setCmpyData(COD);
						}
						// alert(
						//	 "CellButton Clicked: itemIndex=" +
						//	 index.itemIndex +
						//	 ", fieldName=" +
						//	 column.fieldName
						// );
					};

					gridViewDetail.onCellButtonClicked = function(grid, column) {
						console.log(grid, column);
						if (column.column == 'PCOD') {
							modalTargetGrid = grid;
							modalTargetIndex = column.itemIndex;
							openModal('modal-PROD');
							setProdData(COD, DVS);
						}
						// alert(
						//	 "CellButton Clicked: itemIndex=" +
						//	 index.itemIndex +
						//	 ", fieldName=" +
						//	 column.fieldName
						// );
					};
				});
				
				// data json 가져오기
				function setMasterData(DVS, COD, YM, D) {
					toggleLoader(true);
					$.ajax({
						url: '/manage/gridMasterData/',
						type: 'post',
						dataType: 'json',
						data: {DVS: DVS, COD: COD, YM: YM, D: D},
					})
					.done(function(jsonData) {
						providerMaster.fillJsonData(jsonData, {fillMode : 'set'});
						providerMaster.addRow({});
						gridViewMaster.commit(true);
						toggleLoader(false);
					})
					.always(function() {
						console.log('gridMasterData complete');
					});
				}

				function setDetailData(COD, DVS, DTS, NOS) {
					let thisNOS = NOS;
					toggleLoader(true);
					$.ajax({
						url: '/manage/gridDetailData/',
						type: 'post',
						dataType: 'json',
						data: {
							COD: COD
							, DVS: DVS
							, DTS: DTS
							, NOS: NOS
						},
					})
					.done(function(jsonData) {
						console.log(jsonData);
						providerDetail.fillJsonData(jsonData, {fillMode : 'set'});
						let detailNewRow = providerDetail.addRow({});
						providerDetail.setValue(detailNewRow, 'NOS', thisNOS);
						// providerDetail.addRow({});
						// gridViewDetail.commit(true);
						toggleLoader(false);
					})
					.always(function() {
						console.log('gridDetailData complete');
					});
				}

				// row 데이터 저장하기
				function saveRowData(DTS, TYP, GBN, CDS) {
					toggleLoader(true);
					// console.log('in saveRowData ajax', DTS, TYP, GBN, CDS, DVS, COD, YM);
					$.ajax({
						url: '/manage/saveRowData',
						type: 'post',
						// dataType: 'json',
						data: {
							DTS: DTS
							, TYP: TYP
							, GBN: GBN
							, CDS: CDS
							// 공통변수
							, DVS: DVS
							, COD: COD
							, YM: YM
						},
					})
					.done(function(res) {
						console.log(res);
						console.log("success saveRowData");
						if (res) setMasterData(DVS, COD, YM, DD);
						toggleLoader(false);
					})
					.always(function(res) {
						console.log(res);
					});
				}

				function updateRowData(COD, DVS, NOS, DTS, TYP, GBN, CDS, NET, VAT, GRS, TRS, EBL, ENO) {
					toggleLoader(true);
					$.ajax({
						url: '/manage/updateRowData',
						type: 'post',
						dataType: 'json',
						data: {
							COD: COD
							, DVS: DVS
							, NOS: NOS
							, DTS: DTS
							, TYP: TYP
							, GBN: GBN
							, CDS: CDS
							, NET: NET
							, VAT: VAT
							, GRS: GRS
							, TRS: TRS
							, EBL: EBL
							, ENO: ENO
						},
					})
					.done(function(res) {
						// console.log("success");
						// let YM = DTS.substring(0, 4);
						setMasterData(DVS, COD, YM, DD);
						toggleLoader(false);
					})
					.always(function(complete) {
						console.log("complete");
						console.log(complete);
					});
				}

				function saveRowDataDetail(itemIndex, PCOD, QTYS, NOS) {
					toggleLoader(true);
					$.ajax({
						url: '/manage/saveRowDataDetail',
						type: 'post',
						dataType: 'json',
						data: {
							PCOD: PCOD
							, QTYS: QTYS
							, NOS: NOS
							// 공통변수
							, DVS: DVS
							, COD: COD
						},
					})
					.done(function(res) {
						console.log("success");
						console.log(res);
						let rowNOS = providerDetail.getValue(itemIndex, 'NOS');
						setDetailData(COD, DVS, rowNOS);
						toggleLoader(false);
					})
					.always(function() {
						console.log("complete");
					});
				}

				function updateRowDataDetail(PCOD, QTYS, NOS, SEQS, DSEQ, PRIC, NETS, VATS, GRSS, REMK, RETN, PAMT, BNFT) {
					toggleLoader(true);
					$.ajax({
						url: '/manage/updateRowDataDetail',
						type: 'post',
						dataType: 'json',
						data: {
							PCOD : PCOD
							, QTYS : QTYS
							, NOS : NOS
							, SEQS : SEQS
							, DSEQ : DSEQ
							, PRIC : PRIC
							, NETS : NETS
							, VATS : VATS
							, GRSS : GRSS
							, REMK : REMK
							, RETN : RETN
							, PAMT : PAMT
							, BNFT : BNFT
							// 공통변수
							, DVS: DVS
							, COD: COD
						},
					})
					.done(function(res) {
						console.log("success");
						console.log(res);
						let rowNOS = NOS;
						setDetailData(COD, DVS, rowNOS);
						toggleLoader(false);
					})
					.always(function() {
						console.log(33);
						console.log("complete");
					});
					
				}

				// modal on/off
				function openModal(id) {
					let modal = document.getElementById(id);
					modal.classList.add('is-active');
				}

				function closeModal(id) {
					let modal = document.getElementById(id);
					modal.classList.remove('is-active');
				}
			</script>
		</div>
	</div>
</section>
<style>
	#ajax_loader {}
	.modal_layer {display:none;}
	.modal_layer.on {
		display:flex;
		align-items:center;
		justify-content:center;
		width:100%;
		height:100%;
		position:fixed;
		top:0;
		left:0;
		z-index:2000;
		background-color:rgba(0, 0, 0, 0.6);
	}
	.modal_layer .lds-dual-ring {
		display: inline-block;
		width: 120px;
		height: 120px;
	}
	.modal_layer .lds-dual-ring:after {
		content: '';
		display: block;
		width: 64px;
		height: 64px;
		margin: 8px;
		border-radius: 50%;
		border: 10px solid #fff;
		border-color: #fff transparent #fff transparent;
		animation: lds-dual-ring 1.5s linear infinite;
	}
	@keyframes lds-dual-ring {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}
</style>
<div id="ajax_loader" class="modal_layer">
	<div class="lds-dual-ring"></div>
</div>
<script>
	function toggleLoader(bOn) {
		if (bOn) document.getElementById('ajax_loader').classList.add('on');
		else document.getElementById('ajax_loader').classList.remove('on');
	}
</script>