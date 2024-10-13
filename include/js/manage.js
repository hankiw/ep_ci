// 건별발행 master
function openMakeEtaxSingle() {
	let checked = gridViewMaster.getCheckedRows();
	let checkCnt = checked.length;
	let checkedNOS;
	let checkedCDS;
	let checkedGBN;
	let checkedNET;
	let checkedVAT;
	let checkedGRS;
	let checkedDNAM;

	if (checked.length < 1 || checked.length > 1) {
		alert('1개 항목을 선택해주세요.');
		return false;
	}

	for (let row of checked) {
		checkedNOS = providerMaster.getValue(row, 'NOS');
		checkedENO = providerMaster.getValue(row, 'ENO');
		checkedGBN = providerMaster.getValue(row, 'GBN');
		console.log(checkedGBN);
		if (checkedENO) {
			alert('이미 발행된 건이 포함되었습니다.');
			return false;
		} else if (checkedGBN != '1') {
			alert('합산 구분 건이 포함되었습니다.');
			return false;
		}
	}

	checked.forEach(function(row, idx) {
		checkedNOS = providerMaster.getValue(row, 'NOS');
		checkedENO = providerMaster.getValue(row, 'ENO');
	});

	if (checkedENO) {
		alert('이미 발행된 건입니다.');
		return false;
	}

	$.ajax({
		url: '/etax/getEtaxBef',
		type: 'post',
		dataType: 'json',
		data: {
			COD: COD
			, DVS: DVS
			, NOS: checkedNOS
		},
	})
	.done(function(jsonData) {
		console.log(jsonData);
		resetFormETAX('modal-ETAX');
		document.getElementById('e_cds').value = jsonData.CDS;
		document.getElementById('e_nam').value = jsonData.NAM;
		document.getElementById('e_sno').value = jsonData.SNO;
		document.getElementById('e_jno').value = jsonData.JNO;
		document.getElementById('e_mgr1').value = jsonData.MGR1;
		document.getElementById('e_eml1').value = jsonData.EML1;
		document.getElementById('e_cnt').value = numberFormat(jsonData.GUN);
		document.getElementById('e_net').value = numberFormat(jsonData.NET);
		document.getElementById('e_vat').value = numberFormat(jsonData.VAT);
		document.getElementById('e_grs').value = numberFormat(jsonData.GRS);
		document.getElementById('e_dts').value = jsonData.MAKEDT.substring(0, 4) + '-' + jsonData.MAKEDT.substring(4, 6) + '-' + jsonData.MAKEDT.substring(6, 8);
		document.getElementById('e_nos').value = checkedNOS;
		document.getElementById('e_itm').value = jsonData.ITM;
		
		openModal('modal-ETAX');
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});

	
}

// 세금계산서발행
function makeEtaxRun() {
	// 필수입력
	let ENO = '';
	let CDS = document.getElementById('e_cds').value;
	let NOS = document.getElementById('e_nos').value;
	let EDTS = document.getElementById('e_dts').value.replaceAll('-', '');
	let EITM = document.getElementById('e_itm').value;
	let ERMK = document.getElementById('e_rmk').value;
	let EMGR = document.getElementById('e_mgr1').value;
	let EEML = document.getElementById('e_eml1').value;

	if (!CDS || !NOS || !EDTS || !EITM || !EMGR || !EEML) {
		alert('필수 입력값을 입력해 주세요.');
		return false;
	}

	toggleLoader(true);
	$.ajax({
		url: '/etax/makeEtaxSingle/',
		type: 'post',
		dataType: 'json',
		data: {
			ENO: ENO
			, CDS: CDS
			, NOS: NOS
			, EDTS: EDTS
			, EITM: EITM
			, ERMK: ERMK
			, EMGR: EMGR
			, EEML: EEML

			// 공통 사용 변수
			, COD: COD
			, DVS: DVS
		},
	})
	.done(function(res) {
		console.log('make etax:' + res);
		if (res) {
			alert('저장되었습니다.');
			closeModal('modal-ETAX');
			setMasterData(DVS, COD, YM, DD);
		}
	})
	.always(function(res) {
		// console.log("complete");
		// console.log(res);
		toggleLoader(false);
	});
}