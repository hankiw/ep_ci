<script type="text/javascript" src="<?=INC_JS_URL?>/smarteditor2-2.9.2/dist/js/service/HuskyEZCreator.js" charset="utf-8"></script>
<section class="section">
	<div class="container">
		<h1 class="title">자료실</h1>
		<h2 class="subtitle">자료실 글 등록하기</h2>
		<form id="write-frm">
			<input type="hidden" name="BNM" value="<?=$this->BNM?>">
			<input type="hidden" name="UID" value="<?=$this->login->UID?>">
			<div class="field">
				<label class="label">구분</label>
				<div class="control">
					<select class="select" name="BVAR1" id="BVAR1">
						<option value="분류1">분류1</option>
						<option value="분류2">분류2</option>
						<option value="분류3">분류3</option>
					</select>
				</div>
			</div>
			<div class="field">
				<label class="label">제목</label>
				<div class="control">
					<input class="input" type="text" name="TITLE" placeholder="제목을 입력하세요.">
				</div>
			</div>
			<div class="field">
				<label class="label">내용</label>
				<div class="control">
					<textarea class="textarea" name="CONT" id="CONT" placeholder="내용을 입력하세요."></textarea>
				</div>
			</div>
			<div class="field">
				<label class="label">첨부파일</label>
				<div class="control">
					<input class="input" type="file" name="BFILE[]" placeholder="제목을 입력하세요.">
					<input class="input" type="file" name="BFILE[]" placeholder="제목을 입력하세요.">
					<input class="input" type="file" name="BFILE[]" placeholder="제목을 입력하세요.">
				</div>
			</div>
			<div class="field is-grouped is-grouped-right">
				<div class="control">
					<button class="button is-link" type="button" onclick="submitWrite();">등록</button>
				</div>
				<div class="control">
					<a href="<?=$list_href?>"><button type="button" class="button is-link is-light">취소</button></a>
				</div>
			</div>
		</form>
	</div>
</section>
<script>
	var oEditors = [];
	nhn.husky.EZCreator.createInIFrame({
		oAppRef: oEditors,
		elPlaceHolder: 'CONT',
		sSkinURI: '<?=INC_JS_URL?>/smarteditor2-2.9.2/dist/SmartEditor2Skin.html',
		fCreator: 'createSEditor2'
	});

	function submitWrite() {
		oEditors.getById['CONT'].exec('UPDATE_CONTENTS_FIELD', []);

		let listHref = '<?=$list_href?>';
		let formData = new FormData(document.getElementById('write-frm'));

		$.ajax({
			url: '/board/writeProc',
			type: 'post',
			processData: false,
			contentType: false,
			dataType: 'json',
			data: formData,
		})
		.done(function(res) {
			console.log(res);
			console.log("success");
			if (res.result) {
				alert('등록되었습니다');
				location.href = listHref;
			} else {
				alert(res.msg);
			}
			// if (res.result) {
			// 	location.reload();
			// } else {
			// 	alert(res.msg);
			// }
		})
		.fail(function(res) {
			alert(res.msg);
			console.log(res);
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	}
</script>