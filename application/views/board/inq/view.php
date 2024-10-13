<section class="section">
	<div class="container">
		<h1 class="title">1:1문의</h1>
		<!-- <h2 class="subtitle">공지사항 글 등록하기</h2> -->
		<div class="content">
			<table class="table is-narrow">
				<colgroup>
					<col width="12%">
					<col width="*">
				</colgroup>
				<thead>
					<tr>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tr>
					<th>회사명</th>
					<td><?=$view['BVAR2']?></td>
				</tr>
				<tr>
					<th>분류</th>
					<td><?=$view['BVAR1']?></td>
				</tr>
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
					<th>문의내용</th>
					<td>
						<div style="min-height:200px;"><?=$view['CONT']?></div>
					</td>
				</tr>
				<tr>
					<th>답변</th>
					<td>
						<div style="min-height:200px;">
						<?php if ($this->login->CDIV == 'M'): ?>
							<form id="reply-frm">
								<input type="hidden" name="BSEQ" value="<?=$view['BSEQ']?>">
								<input type="hidden" name="UID" value="<?=$this->login->UID?>">
								<textarea class="textarea" name="RECONT" id="RECONT" placeholder="내용을 입력하세요."><?php echo (isset($view['RECONT'])) ? $view['RECONT'] : ''; ?></textarea>
								<div class="field is-grouped is-grouped-right">
									<?php if (isset($view['RECONT'])): ?>
										<div class="control">
											<span class="tag is-light">답변일 <?=$view['UDTF']?></span>
										</div>
									<?php endif ?>
									<div class="control">
										<button class="button is-link is-small" type="button" onclick="replyWrite();">답변등록</button>
									</div>
								</div>
							</form>
						<?php else: ?>
							<?php echo (isset($view['RECONT'])) ? $view['RECONT'] : ''; ?>
						<?php endif ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<div class="field is-grouped is-grouped-right">
			<div class="control">
				<a href="<?=$list_href?>"><button type="button" class="button is-link is-light">목록</button></a>
			</div>
		</div>
	</div>
</section>
<script>
	function replyWrite() {
		let formData = new FormData(document.getElementById('reply-frm'));

		$.ajax({
			url: '/board/replyProc',
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