<script type="text/javascript" src="<?=INC_JS_URL?>/smarteditor2-2.9.2/dist/js/service/HuskyEZCreator.js" charset="utf-8"></script>
<section class="section">
	<div class="container">
		<h1 class="title">공지사항</h1>
		<!-- <h2 class="subtitle">공지사항 글 등록하기</h2> -->
		<div class="content">
			<table class="table is-narrow">
				<colgroup>
					<col width="15%">
					<col width="*">
				</colgroup>
				<thead>
					<tr>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tr>
					<th>제목</th>
					<td><?=$view['TITLE']?></td>
				</tr>
				<tr>
					<th>작성자</th>
					<td>
						<div class="level">
							<div class="level-left"><?=$view['UID']?></div>
							<div class="level-left"><?=$view['RDTF']?></div>
						</div>
					</td>
				</tr>
				<tr>
					<th>내용</th>
					<td>
						<?php if ($this->login->CDIV == 'M'): ?>
							<form id="modify-frm">
								<input type="hidden" name="BSEQ" value="<?=$view['BSEQ']?>">
								<input type="hidden" name="UID" value="<?=$this->login->UID?>">
								<textarea class="textarea" name="CONT" id="CONT"><?=$view['CONT']?></textarea>
							</form>
						<?php else: ?>
							<div style="min-height:200px;"><?=$view['CONT']?></div>
						<?php endif ?>
					</td>
				</tr>
				<tr>
					<th>첨부파일</th>
					<td>
						<?php foreach ($bfile as $bf): ?>
							<div>
								<a target="_BLANK" href="<?=$bf['href']?>"><?=$bf['filename']?></a>
							</div>
						<?php endforeach ?>
					</td>
				</tr>
			</table>
		</div>
		<div class="field is-grouped is-grouped-right">
			<?php if ($this->login->CDIV == 'M'): ?>
				<div class="control">
					<span class="tag is-light">수정일 <?=$view['UDTF']?></span>
				</div>
				<div class="control">
					<button type="button" class="button is-primary is-light" onclick="modifyNotice();">수정</button>
				</div>
			<?php endif ?>
			<div class="control">
				<a href="<?=$list_href?>"><button type="button" class="button is-link is-light">목록</button></a>
			</div>
		</div>
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

	function modifyNotice() {
		oEditors.getById['CONT'].exec('UPDATE_CONTENTS_FIELD', []);
		
		let formData = new FormData(document.getElementById('modify-frm'));

		if (!confirm('게시글을 수정합니다.')) {
			return false;
		}

		$.ajax({
			url: '/board/modifyNoticeProc',
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
				alert('수정되었습니다');
				location.reload();
			} else {
				alert(res.msg);
			}
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