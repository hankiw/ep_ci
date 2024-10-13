<div id="modal-CMPYCDS" class="modal">
	<div class="modal-background"></div>
	<div class="modal-card">
		<header class="modal-card-head">
			<p class="modal-card-title">거래처 코드 도움</p>
			<button class="delete" aria-label="close" onclick="closeModal('modal-CMPYCDS');"></button>
		</header>
		<section class="modal-card-body">
			<div id="cmpy_grid" class="mb-1" style="width:100%;height:300px;"></div>
		</section>
		<section class="modal-card-body">
			<div class="field is-grouped">
				<div class="control">
					<input class="input is-small" type="text" placeholder="거래처명" id="cndsearch" onKeyPress="if( event.keyCode==13 ){cmpySearch();}">
				</div>
				<div class="control">
					<a class="button is-info is-small" onclick="cmpySearch();">검색</a>
				</div>
				<div class="control buttons are-small">
					<button class="button is-success" onclick="cmpyReg();">신규등록</button>
					<button class="button is-warning" onclick="cmpyModi();">수정</button>
				</div>
			</div>
		</section>
		<footer class="modal-card-foot">
			<div class="buttons are-small is-centered">
				<button class="button is-success" id="cmpy_select_btn" onclick="cmpySelect();">선택</button>
				<button class="button" onclick="closeModal('modal-CMPYCDS');">취소</button>
			</div>
		</footer>
	</div>
</div>
<div id="modal-CMPYCDS-reg" class="modal">
	<div class="modal-background"></div>
	<div class="modal-card">
		<header class="modal-card-head">
			<p class="modal-card-title">거래처 등록</p>
			<button class="delete" aria-label="close" onclick="closeModal('modal-CMPYCDS-reg');"></button>
		</header>
		<section class="modal-card-body">
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">코드</label>
				</div>
				<div class="field-body">
					<div class="field has-addons">
						<p class="control is-expanded">
							<input class="input is-small" type="text" placeholder="CODE" name="n_cds" id="n_cds" readonly>
						</p>
						<p class="control">
							<a class="button is-small is-info" id="cod_btn" onclick="getNextCmpyCds();">부여</a>
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
							<input class="input is-small" type="text" name="n_sno" id="n_sno" onchange="inputFormat(this, 'sno');" placeholder="사업자번호">
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
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">상호</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control">
							<input class="input is-small" type="text" name="n_nam" id="n_nam" placeholder="상호">
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
							<input class="input is-small" type="text" name="n_own" id="n_own" placeholder="대표자">
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
							<input class="input is-small" type="text" name="n_zip" id="n_zip" readonly placeholder="사업장주소">
						</p>
						<p class="control">
							<a class="button is-small is-success" onclick="searchZip();">찾기</a>
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
				function searchZip() {
					new daum.Postcode({
						oncomplete: function(data) {
							// console.log(data);
							let addr;
							if (data.userSelectedType === 'R') addr = data.roadAddress;
							else addr = data.jibunAddress;

							document.getElementById('n_zip').value = data.zonecode;
							document.getElementById('n_adr1').value = addr;
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
							<input class="input is-small" type="text" name="n_adr1" id="n_adr1" readonly placeholder="주소">
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
							<input class="input is-small" type="text" name="n_adr2" id="n_adr2" placeholder="상세주소">
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
							<input class="input is-small" type="text" name="n_typ" id="n_typ" placeholder="업태">
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
							<input class="input is-small" type="text" name="n_knd" id="n_knd" placeholder="종목">
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
					<label class="label">담당자 1</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control">
							<input class="input is-small" type="text" name="n_mgr1" id="n_mgr1" placeholder="담당자 1">
						</p>
					</div>
				</div>
				<div class="field-label is-small">
					<label class="label">이메일 1</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control">
							<input class="input is-small" type="text" name="n_eml1" id="n_eml1" placeholder="이메일 1">
						</p>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label is-small">
					<label class="label">담당자 2</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control">
							<input class="input is-small" type="text" name="n_mgr2" id="n_mgr2" placeholder="담당자 2">
						</p>
					</div>
				</div>
				<div class="field-label is-small">
					<label class="label">이메일 2</label>
				</div>
				<div class="field-body">
					<div class="field">
						<p class="control">
							<input class="input is-small" type="text" name="n_eml2" id="n_eml2" placeholder="이메일 2">
						</p>
					</div>
				</div>
			</div>
		</section>
		<footer class="modal-card-foot">
			<div class="buttons are-small is-centered">
				<button class="button is-success" onclick="return saveCmpyCds();">저장</button>
				<!-- <button class="button is-danger" onclick="">삭제</button> -->
				<button class="button" onclick="closeModal('modal-CMPYCDS-reg');">취소</button>
			</div>
		</footer>
	</div>
</div>
<script>
	// cmpyReg();
	// openModal('modal-CMPYCDS-reg');
	var selectedCDS;
	var selectedCNAM;
	var dataCmpy;
	document.addEventListener('DOMContentLoaded', function() {
		providerCmpy = new RealGrid.LocalDataProvider();
		gridViewCmpy = new RealGrid.GridView('cmpy_grid');
		gridViewCmpy.setDataSource(providerCmpy);

		gridViewCmpy.displayOptions.rowHeight = 30;
		gridViewCmpy.displayOptions.selectionMode = "none";
		gridViewCmpy.displayOptions.selectionStyle = "singleRow";

		// 단순조회물, 풋터는 표시하지 않는다.
		gridViewCmpy.setFooters({
		  	visible: false
		});

		gridViewCmpy.header.height = 36;
		//gridViewPg.footer.height = 30;

		gridViewCmpy.onKeyDown = function (grid, event) {
		    
		    if (event.keyCode == 13) {
		    	cmpySelect();
		    	return false;
		    }

		};


		providerCmpy.setFields([
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

		gridViewCmpy.setColumns([
			{
				name: 'NAM'
				, fieldName: 'NAM'
				, width: 200
				, header: {text: '거래처명'}
				, editable: false
			}
			, {
				name: 'SNO'
				, fieldName: 'SNO'
				, width: 120
				, header: {text: '사업자등록번호'}
				, editable: false
			}
			, {
				name: 'OWN'
				, fieldName: 'OWN'
				, width: 120
				, header: {text: '대표자'}
				, editable: false
			}
		]);

		gridViewCmpy.onCurrentRowChanged = function(grid, oldRow, newRow) {
			console.log('check', oldRow, newRow);
			console.log(grid);
			
			// 거래처 선택 정보
			selectedCDS = providerCmpy.getValue(newRow, 'CDS');
			selectedCNAM = providerCmpy.getValue(newRow, 'NAM');
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
	function resetFormCMPY(obj) {
		document.getElementById('cod_btn').disabled = false;
		let inputObj = document.getElementById(obj).querySelectorAll('input');
		inputObj.forEach(function(obj, idx) {
			obj.value = '';
		});
	}

	// 거래처 신규 등록
	function cmpyReg() {
		resetFormCMPY('modal-CMPYCDS-reg');
		openModal('modal-CMPYCDS-reg');
	}

	// 거래처 수정
	function cmpyModi() {
		if (!selectedCDS) {
			alert('거래처를 선택해주세요.');
			return false;
		}
		gridViewCmpy.showLoading();
		resetFormCMPY('modal-CMPYCDS-reg');
		setCmpyModiData(COD, selectedCDS);
		gridViewCmpy.closeLoading();
	}

	// 거래처 정보 저장
	function saveCmpyCds() {
		// 필수입력
		let CDS = document.getElementById('n_cds').value;
		let SNO = document.getElementById('n_sno').value;
		let JNO = document.getElementById('n_jno').value;
		let NAM = document.getElementById('n_nam').value;
		let OWN = document.getElementById('n_own').value;
		let MGR1 = document.getElementById('n_mgr1').value;
		let EML1 = document.getElementById('n_eml1').value;
		// 선택입력
		let ZIP = document.getElementById('n_zip').value;
		let ADR1 = document.getElementById('n_adr1').value;
		let ADR2 = document.getElementById('n_adr2').value;
		let TYP = document.getElementById('n_typ').value;
		let KND = document.getElementById('n_knd').value;
		let MGR2 = document.getElementById('n_mgr2').value;
		let EML2 = document.getElementById('n_eml2').value;

		if (!CDS || !SNO || !NAM || !OWN || !EML1) {
			alert('필수 입력값을 입력해 주세요.');
			return false;
		}

		$.ajax({
			url: '/manage/saveCmpyCds/',
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
			console.log('save cmpy:' + res);
			if (res) {
				alert('저장되었습니다.');
				setCmpyData(COD, '');
				closeModal('modal-CMPYCDS-reg');
			}
		})
		.always(function(res) {
			// console.log("complete");
			// console.log(res);
		});
		
	}

	// 거래처코드 부여
	function getNextCmpyCds() {
		if (document.getElementById('n_cds').value) {
			alert('이미 코드를 부여했습니다.');
			return false;
		}
		
		$.ajax({
			url: '/manage/getNextCmpyCds/',
			type: 'post',
			data: {
				// 공통사용변수
				COD: COD
			},
		})
		.done(function(res) {
			console.log(res);
			if (res) {
				document.getElementById('n_cds').value = res;
			} else {
				alert('오류가 발생했습니다.');
			}
		})
		.always(function(res) {
			console.log(res);
			console.log("complete");
		});
	}

	// 거래처 데이터 가져오기
	function setCmpyData(COD, SCH) {
		gridViewCmpy.showLoading();
		$.ajax({
			url: '/manage/getCmpyCods/',
			type: 'post',
			dataType: 'json',
			data: {
				COD: COD
				, SCH: SCH
			},
		})
		.done(function(jsonData) {
			// providerCmpy.clearRows();
			providerCmpy.fillJsonData(jsonData, {fillMode : 'set'});
			dataCmpy = jsonData;
			gridViewCmpy.commit(true);
			gridViewCmpy.closeLoading();
			
			if (document.getElementById('cndsearch').value == '' || providerCmpy.getRowCount() == 0) {
				document.getElementById('cndsearch').select();
				document.getElementById('cndsearch').focus();
			} else {
				gridViewCmpy.setFocus();
			}
		})
		.always(function() {
			console.log('gridCmpyData complete');
		});

		// 검색 입력 reset
		// document.getElementById('cndsearch').value = '';
	}

	// 수정할 거래처 데이터 가져오기
	function setCmpyModiData(COD, CDS) {
		$.ajax({
			url: '/manage/getCmpyCods/',
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
			document.getElementById('cod_btn').disabled = true;
			document.getElementById('n_cds').value = cmpyData.CDS
			document.getElementById('n_sno').value = cmpyData.SNO
			document.getElementById('n_jno').value = cmpyData.JNO
			document.getElementById('n_nam').value = cmpyData.NAM
			document.getElementById('n_own').value = cmpyData.OWN
			document.getElementById('n_zip').value = cmpyData.ZIP
			document.getElementById('n_adr1').value = cmpyData.ADR1
			document.getElementById('n_adr2').value = cmpyData.ADR2
			document.getElementById('n_typ').value = cmpyData.TYP
			document.getElementById('n_knd').value = cmpyData.KND
			document.getElementById('n_eml1').value = cmpyData.EML1
			document.getElementById('n_mgr1').value = cmpyData.MGR1
			document.getElementById('n_eml2').value = cmpyData.EML2
			document.getElementById('n_mgr2').value = cmpyData.MGR2
			openModal('modal-CMPYCDS-reg');
		})
		.always(function() {
			console.log('gridCmpyModiData complete');
		});
	}

	function cmpySelect() {
		console.log(modalTargetIndex, modalTargetGrid);
		console.log('check');
		modalTargetProvider.setValue(modalTargetIndex, 'CDS', selectedCDS);
		modalTargetProvider.setValue(modalTargetIndex, 'NAM', selectedCNAM);
		modalTargetGrid.onCellEdited(modalTargetGrid, modalTargetIndex, 0, 0);

		closeModal('modal-CMPYCDS');
		modalTargetGrid.setFocus();
	}

	function cmpySearch() {
		let SCH = document.getElementById('cndsearch').value;
		setCmpyData(COD, SCH);
	}
</script>