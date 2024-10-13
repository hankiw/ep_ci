

<section class="section">
	<div class="container">
		<h1 class="title">서비스 신청</h1>
		<h2 class="subtitle">
			서비스 신청 페이지 subtext
		</h2>
		<div class="box">
			<form name="signup-frm" id="signup-frm">
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">회사명(상호)</label>
					</div>
					<div class="field-body">
						<div class="field">
							<p class="control is-expanded has-icons-left">
								<input class="input" type="text" placeholder="회사명" name="NAM" value="">
								<span class="icon is-small is-left">
									<i class="fas fa-building"></i>
								</span>
							</p>
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">사업자등록번호</label>
					</div>
					<div class="field-body">
						<div class="field">
							<p class="control is-expanded has-icons-left">
								<input class="input" type="text" placeholder="사업자등록번호" name="SNO" value="">
								<span class="icon is-small is-left">
									<i class="fas fa-file"></i>
								</span>
							</p>
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">이메일</label>
					</div>
					<div class="field-body">
						<div class="field">
							<p class="control is-expanded has-icons-left">
								<input class="input" type="text" placeholder="이메일" name="EML" value="">
								<span class="icon is-small is-left">
									<i class="fas fa-at"></i>
								</span>
							</p>
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">담당자</label>
					</div>
					<div class="field-body">
						<div class="field">
							<p class="control is-expanded has-icons-left">
								<input class="input" type="text" placeholder="담당자" name="UNM" value="">
								<span class="icon is-small is-left">
									<i class="fas fa-user"></i>
								</span>
							</p>
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">담당자 연락처</label>
					</div>
					<div class="field-body">
						<div class="field">
							<p class="control is-expanded has-icons-left">
								<input class="input" type="text" placeholder="담당자 연락처" name="UTEL" value="">
								<span class="icon is-small is-left">
									<i class="fas fa-user"></i>
								</span>
							</p>
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">아이디</label>
					</div>
					<div class="field-body">
						<div class="field">
							<p class="control is-expanded has-icons-left">
								<input class="input" type="text" placeholder="아이디" name="UID" value="">
								<span class="icon is-small is-left">
									<i class="fas fa-user"></i>
								</span>
							</p>
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">비밀번호</label>
					</div>
					<div class="field-body">
						<div class="field">
							<p class="control is-expanded has-icons-left">
								<input class="input" type="password" placeholder="비밀번호" name="UPW" value="">
								<span class="icon is-small is-left">
									<i class="fas fa-lock"></i>
								</span>
							</p>
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">비밀번호(확인)</label>
					</div>
					<div class="field-body">
						<div class="field">
							<p class="control is-expanded has-icons-left">
								<input class="input" type="password" placeholder="비밀번호 확인" name="UPW_CONF" value="">
								<span class="icon is-small is-left">
									<i class="fas fa-lock"></i>
								</span>
							</p>
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label"></label>
					</div>
					<div class="field-body">
						<div class="field">
							<p class="control is-expanded has-icons-left">
								<label class="checkbox">
									<input type="checkbox" name="AGREE" value="Y">
									<a href="#">서비스 이용약관</a>과 <a href="#">개인정보 수집 이용 보관</a>에 동의합니다.
								</label>
							</p>
						</div>
					</div>
				</div>
			</form>
			<div class="field is-horizontal">
				<div class="field-label">
					<!-- Left empty for spacing -->
				</div>
				<div class="field-body">
					<div class="field">
						<div class="control">
							<button class="button is-primary" onclick="singup();">신청하기</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	function singup() {
		let formData = new FormData(document.getElementById('signup-frm'));

		if (!formData.get('AGREE')) {
			alert('약관에 동의해 주세요.');
			return false;
		}

		for (let input of formData.entries()) {
			if (!input[1]) {
				alert('모든 항목을 입력해주세요.');
				return false;
			}
		}

		$.ajax({
			url: '/home/registCmpy',
			type: 'post',
			processData: false,
			contentType: false,
			dataType: 'json',
			data: formData,
		})
		.done(function(res) {
			alert(res.msg);
			if (res.result) {
				location.href = '/';
			}
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		

	}
</script>