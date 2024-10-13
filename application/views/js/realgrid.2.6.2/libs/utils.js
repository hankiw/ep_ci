
function formatNumberDisp(number) {
    // 콤마 제거
    let value = number.replace(/,/g, '');

    // 숫자만 남기고 모든 문자 제거
    value = value.replace(/[^\d]/g, '');

    // 천단위 콤마 추가
    value = Number(value).toLocaleString('en-US');

    return value;
}

function formatNumberInpu(input) {
	// 현재 입력값에서 콤마 제거
	let value = input.value.replace(/,/g, '');

	// 숫자만 남기고 모든 문자 제거
	value = value.replace(/[^\d]/g, '');

	// 천단위 콤마 추가
	value = Number(value).toLocaleString('en-US');

	// 입력 필드에 적용
	input.value = value;
}