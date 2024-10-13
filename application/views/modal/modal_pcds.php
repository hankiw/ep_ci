<div id="modal-PCDS" class="modal">
	<div class="modal-background"></div>
	<div class="modal-card">
		<header class="modal-card-head">
			<p class="modal-card-title">입금구분 코드 도움</p>
			<button class="delete" aria-label="close" onclick="closeModal('modal-PCDS');"></button>
		</header>
		<section class="modal-card-body">
			<div id="pcds_grid" class="mb-1" style="width:100%;height:300px;"></div>
		</section>
		<section class="modal-card-body">
			<div class="field is-grouped">
				<div class="control">
					<input class="input is-small" type="text" placeholder="거래처명" id="pcds_search">
				</div>
				<div class="control">
					<a class="button is-info is-small" onclick="pcdsSearch(document.getElementById('pcds_search').value);">검색</a>
				</div>
				<div class="control buttons are-small">
					<button class="button is-success" onclick="pcdsReg();">신규등록</button>
					<button class="button is-warning" onclick="pcdsModi();">수정</button>
				</div>
			</div>
		</section>
		<footer class="modal-card-foot">
			<div class="buttons are-small is-centered">
				<button class="button is-success" id="cmpy_select_btn" onclick="pcdsSelect();">선택</button>
				<button class="button" onclick="closeModal('modal-PCDS');">취소</button>
			</div>
		</footer>
	</div>
</div>
<div id="modal-PCDS-reg" class="modal">
	<div class="modal-background"></div>
	<div class="modal-card">
		<header class="modal-card-head">
			<p class="modal-card-title">입금구분 등록</p>
			<button class="delete" aria-label="close" onclick="closeModal('modal-PCDS-reg');"></button>
		</header>
		<section class="modal-card-body">
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">코드</label>
				</div>
				<div class="field-body">
					<div class="field has-addons">
						<p class="control is-expanded">
							<input class="input is-small" type="text" placeholder="CODE" name="n_cds_2" id="n_cds_2" readonly>
						</p>
						<p class="control">
							<a class="button is-small is-info" id="pcds_btn" onclick="getNextPcdsCds();">부여</a>
						</p>
					</div>
				</div>
				<div class="field-label is-small">
					<div class="field">
						<p class="control"></p>
					</div>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control"></p>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">사업자번호</label>
				</div>
				<div class="field-body">
					<div class="field has-addons">
						<p class="control is-expanded">
							<input class="input is-small" type="text" name="n_sno_2" id="n_sno_2" onchange="inputFormat(this, 'sno');" placeholder="사업자번호">
						</p>
						<p class="control">
							<a class="button is-small is-success" onclick="alert('준비중입니다.');">검증</a>
						</p>
					</div>
				</div>
				<div class="field-label is-small">
					<label class="label"></label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control"></p>
					</div>
				</div>
			</div>
			<!--
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">주민등록번호</label>
				</div>
				<div class="field-body">
					<div class="field has-addons">
						<p class="control is-expanded">
							<input class="input is-small" type="text" name="n_jno" id="n_jno" onchange="inputFormat(this, 'jno');" placeholder="주민등록번호">
						</p>
						<p class="control">
							<a class="button is-small is-success" onclick="alert('준비중입니다.');">검증</a>
						</p>
					</div>
				</div>
				<div class="field-label is-small">
					<label class="label"></label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control"></p>
					</div>
				</div>
			</div>
			-->
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">명칭</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control">
							<input class="input is-small" type="text" name="n_nam_2" id="n_nam_2" placeholder="상호">
						</p>
					</div>
				</div>
				<div class="field-label is-small">
					<label class="label"></label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control"></p>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">대표자</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control">
							<input class="input is-small" type="text" name="n_own_2" id="n_own_2" placeholder="대표자">
						</p>
					</div>
				</div>
				<div class="field-label is-small">
					<label class="label"></label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control"></p>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">사업장주소</label>
				</div>
				<div class="field-body">
					<div class="field has-addons">
						<p class="control">
							<input class="input is-small" type="text" name="n_zip_2" id="n_zip_2" readonly placeholder="사업장주소">
						</p>
						<p class="control">
							<a class="button is-small is-success" onclick="searchZip2();">찾기</a>
						</p>
					</div>
				</div>
				<div class="field-label is-small">
					<label class="label"></label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control"></p>
					</div>
				</div>
			</div>
			<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
			<script>
				function searchZip2() {
					new daum.Postcode({
						oncomplete: function(data) {
							// console.log(data);
							let addr;
							if (data.userSelectedType === 'R') addr = data.roadAddress;
							else addr = data.jibunAddress;

							document.getElementById('n_zip_2').value = data.zonecode;
							document.getElementById('n_adr1_2').value = addr;
						}
					}).open();
				}
			</script>
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">주소</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control">
							<input class="input is-small" type="text" name="n_adr1_2" id="n_adr1_2" readonly placeholder="주소">
						</p>
					</div>
				</div>
				<div class="field-label is-small">
					<label class="label"></label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control"></p>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">상세주소</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control">
							<input class="input is-small" type="text" name="n_adr2_2" id="n_adr2_2" placeholder="상세주소">
						</p>
					</div>
				</div>
				<div class="field-label is-small">
					<label class="label"></label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control"></p>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">업태</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control">
							<input class="input is-small" type="text" name="n_typ_2" id="n_typ_2" placeholder="업태">
						</p>
					</div>
				</div>
				<div class="field-label is-small">
					<label class="label"></label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control"></p>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">종목</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control">
							<input class="input is-small" type="text" name="n_knd_2" id="n_knd_2" placeholder="종목">
						</p>
					</div>
				</div>
				<div class="field-label is-small">
					<label class="label"></label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control"></p>
					</div>
				</div>
			</div>

			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">이메일 1</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control">
							<input class="input is-small" type="text" name="n_eml1_2" id="n_eml1_2" placeholder="이메일 1">
						</p>
					</div>
				</div>
				<div class="field-label is-small">
					<label class="label">이메일 2</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control">
							<input class="input is-small" type="text" name="n_eml2_2" id="n_eml2_2" placeholder="이메일 2">
						</p>
					</div>
				</div>
			</div>
		</section>
		<footer class="modal-card-foot">
			<div class="buttons are-small is-centered">
				<button class="button is-success" onclick="return saveCmpyCds2();">저장</button>
				<!-- <button class="button is-danger" onclick="">삭제</button> -->
				<button class="button" onclick="closeModal('modal-PCDS-reg');">취소</button>
			</div>
		</footer>
	</div>
</div>
<script>
	// cmpyReg();
	// openModal('modal-CMPYCDS-reg');
	var selectedCDS;
	var selectedCNAM;
	var dataPcds;
	document.addEventListener('DOMContentLoaded', function() {
		providerPcds = new RealGrid.LocalDataProvider();
		gridViewPcds = new RealGrid.GridView('pcds_grid');
		gridViewPcds.setDataSource(providerPcds);

		gridViewPcds.displayOptions.rowHeight = 30;
		gridViewPcds.displayOptions.selectionMode = "none";
		gridViewPcds.displayOptions.selectionStyle = "singleRow";


		// 단순조회물, 풋터는 표시하지 않는다.
		gridViewPcds.setFooters({
		  	visible: false
		});

		gridViewPcds.header.height = 36;

		gridViewPcds.onKeyDown = function (grid, event) {
		    
		    if (event.keyCode == 13) {
		    	pcdsSelect();
		    	return false;
		    }

		};

		providerPcds.setFields([
			{fieldName: 'COD'}
			, {fieldName: 'CDS'}
			, {fieldName: 'NAM'}
			, {fieldName: 'SNO'}
			, {fieldName: 'OWN'}
			, {fieldName: 'ZIP'}
			, {fieldName: 'ADR1'}
			, {fieldName: 'ADR2'}
			, {fieldName: 'TYP'}
			, {fieldName: 'KND'}
			, {fieldName: 'EML1'}
			, {fieldName: 'EML2'}
			, {fieldName: 'SDT'}
			, {fieldName: 'EDT'}
		]);

		gridViewPcds.setColumns([
			{
				name: 'CDS'
				, fieldName: 'CDS'
				, width: 80
				, header: {text: '코드'}
				, editable: false
			}
			, {
				name: 'NAM'
				, fieldName: 'NAM'
				, width: 80
				, header: {text: '명청'}
				, editable: false
			}
			, {
				name: 'SNO'
				, fieldName: 'SNO'
				, width: 100
				, header: {text: '사업자등록번호'}
				, editable: false
			}
			, {
				name: 'OWN'
				, fieldName: 'OWN'
				, width: 80
				, header: {text: '대표자'}
				, editable: false
			}
		]);

		gridViewPcds.onCurrentRowChanged = function(grid, oldRow, newRow) {
			console.log('check', oldRow, newRow);
			console.log(grid);
			
			// 거래처 선택 정보
			selectedCDS = providerPcds.getValue(newRow, 'CDS');
			selectedCNAM = providerPcds.getValue(newRow, 'NAM');
		}
	});


	// 사업, 주민 번호 숫자만 , format
	function inputFormat(obj, type) {
		obj.value = obj.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
		if (type == 'jno') {
			obj.value = obj.value.substring(0, 6) + '-' + obj.value.substring(6);
		} else if (type == 'sno') {
			obj.value = obj.value.substring(0, 3) + '-' + obj.value.substring(3, 5) + '-' + obj.value.substring(5);
		}
	}

	// 입력폼 reset
	function resetFormPCDS(obj) {
		document.getElementById('pcds_btn').disabled = false;
		let inputObj = document.getElementById(obj).querySelectorAll('input');
		inputObj.forEach(function(obj, idx) {
			obj.value = '';
		});
	}

	// 거래처 신규 등록
	function pcdsReg() {
		resetFormPCDS('modal-PCDS-reg');
		openModal('modal-PCDS-reg');
	}

	// 거래처 수정
	function pcdsModi() {
		if (!selectedCDS) {
			alert('입금구분을 선택해주세요.');
			return false;
		}
		gridViewPcds.showLoading();
		resetFormPCDS('modal-PCDS-reg');
		setPcdsModiData(COD, selectedCDS);
		gridViewPcds.closeLoading();
	}

	// 거래처 정보 저장
	function saveCmpyCds2() {
		// 필수입력
		let CDS = document.getElementById('n_cds_2').value;
		let SNO = document.getElementById('n_sno_2').value;
		let NAM = document.getElementById('n_nam_2').value;
		let OWN = document.getElementById('n_own_2').value;
		let EML1 = document.getElementById('n_eml1_2').value;
		// 선택입력
		let ZIP = document.getElementById('n_zip_2').value;
		let ADR1 = document.getElementById('n_adr1_2').value;
		let ADR2 = document.getElementById('n_adr2_2').value;
		let TYP = document.getElementById('n_typ_2').value;
		let KND = document.getElementById('n_knd_2').value;
		let EML2 = document.getElementById('n_eml2_2').value;

		// 미사용
		let JNO = '';
		let MGR1 = '';
		let MGR2 = '';

		if (!CDS || !SNO || !NAM || !OWN || !EML1) {
			alert('필수 입력값을 입력해 주세요.');
			return false;
		}

		$.ajax({
			url: '/payment/saveCmpyCds2/',
			type: 'post',
			dataType: 'json',
			data: {
				CDS: CDS
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

				// 공통 사용 변수
				, COD: COD
			},
		})
		.done(function(res) {
			console.log('save cmpy2:' + res);
			if (res) {
				alert('저장되었습니다.');
				setPcdsData(COD, '');
				closeModal('modal-PCDS-reg');
			}
		})
		.always(function(res) {
			// console.log("complete");
			// console.log(res);
		});
		
	}

	// 거래처코드 부여
	function getNextPcdsCds() {
		if (document.getElementById('n_cds_2').value) {
			alert('이미 코드를 부여했습니다.');
			return false;
		}
		
		$.ajax({
			url: '/payment/getNextPcdsCds/',
			type: 'post',
			data: {
				// 공통사용변수
				COD: COD
			},
		})
		.done(function(res) {
			console.log(res);
			if (res) {
				document.getElementById('n_cds_2').value = res;
			} else {
				alert('오류가 발생했습니다.');
			}
		})
		.always(function(res) {
			console.log(res);
			console.log("complete");
		});
	}

	// 입금구분 데이터 가져오기
	function setPcdsData(COD, SCH) {
		gridViewCmpy.showLoading();
		$.ajax({
			url: '/payment/getPcds/',
			type: 'post',
			dataType: 'json',
			data: {
				COD: COD
				, SCH: SCH
			},
		})
		.done(function(jsonData) {
			// providerPcds.clearRows();
			providerPcds.fillJsonData(jsonData, {fillMode : 'set'});
			dataPcds = jsonData;
			gridViewPcds.commit(true);
			gridViewPcds.closeLoading();
			gridViewPcds.setFocus();
		})
		.always(function() {
			console.log('gridCmpyData complete');
		});

		// 검색 입력 reset
		document.getElementById('cmpycds_search').value = '';
	}

	// 수정할 거래처 데이터 가져오기
	function setPcdsModiData(COD, CDS) {
		$.ajax({
			url: '/payment/getPcds/',
			type: 'post',
			dataType: 'json',
			data: {
				COD: COD
				, CDS: CDS
			},
		})
		.done(function(res) {
			// providerCmpy.clearRows();
			console.log(res[0]);
			let cmpyData = res[0];
			document.getElementById('pcds_btn').disabled = true;
			document.getElementById('n_cds_2').value = cmpyData.CDS
			document.getElementById('n_sno_2').value = cmpyData.SNO
			document.getElementById('n_nam_2').value = cmpyData.NAM
			document.getElementById('n_own_2').value = cmpyData.OWN
			document.getElementById('n_zip_2').value = cmpyData.ZIP
			document.getElementById('n_adr1_2').value = cmpyData.ADR1
			document.getElementById('n_adr2_2').value = cmpyData.ADR2
			document.getElementById('n_typ_2').value = cmpyData.TYP
			document.getElementById('n_knd_2').value = cmpyData.KND
			document.getElementById('n_eml1_2').value = cmpyData.EML1
			document.getElementById('n_eml2_2').value = cmpyData.EML2
			openModal('modal-PCDS-reg');
		})
		.always(function() {
			console.log('gridPcdsModiData complete');
		});
	}

	function pcdsSelect() {
		console.log(modalTargetIndex, modalTargetGrid);
		console.log('check2');
		modalTargetProvider.setValue(modalTargetIndex, 'PCDS', selectedCDS);
		modalTargetProvider.setValue(modalTargetIndex, 'PNAM', selectedCNAM);
		modalTargetGrid.onCellEdited(modalTargetGrid, modalTargetIndex, 0, 0);

		closeModal('modal-PCDS');
		modalTargetGrid.setFocus();
	}

	function pcdsSearch(val) {
		setPcdsData(COD, val);
	}
</script>