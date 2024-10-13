<div id="modal-LOGIN" class="modal">
	<div class="modal-background"></div>
	<div class="modal-card">
		<header class="modal-card-head has-background-link-dark">
			<p class="modal-card-title has-text-white-bis"></p>
			<button class="delete" aria-label="close" onclick="closeModal('modal-LOGIN');"></button>
		</header>
		<section class="modal-card-body">
			<form name="login-frm" id="login-frm">
				<div class="columns p-3">
					<div class="column is-6">
						<div class="field is-horizontal">
							<div class="field-label is-normal">
								<label class="label">회사코드</label>
							</div>
							<div class="field-body">
								<div class="field">
									<p class="control has-icons-left has-icons-right">
										<input class="input is-success" type="text" placeholder="CODE" name="COD" value="<?=($this->ckCOD) ? $this->ckCOD : ''?>">
										<span class="icon is-small is-left">
											<i class="fas fa-house"></i>
										</span>
										<span class="icon is-small is-right">
											<i class="fas fa-check"></i>
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
									<p class="control has-icons-left has-icons-right">
										<input class="input is-success" type="text" placeholder="ID" name="UID" value="<?=($this->ckUID) ? $this->ckUID : ''?>">
										<span class="icon is-small is-left">
											<i class="fas fa-user"></i>
										</span>
										<span class="icon is-small is-right">
											<i class="fas fa-check"></i>
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
									<p class="control has-icons-left has-icons-right">
										<input class="input is-success" type="password" placeholder="PASSWORD" name="UPW">
										<span class="icon is-small is-left">
											<i class="fas fa-lock"></i>
										</span>
										<span class="icon is-small is-right">
											<i class="fas fa-check"></i>
										</span>
									</p>
								</div>
							</div>
						</div>
						<div class="field">
							<div class="control">
								<label class="checkbox">
									<input type="checkbox" name="SAVE" value="Y" <?=($this->ckSAVE == 'Y') ? 'checked' : ''?> >회사코드 및 아이디 저장
								</label>
							</div>
						</div>
					</div>
					<div class="column is-6">
						<div class="field is-horizontal">
							<div class="field-body">
								<div class="field">
									<p class="control">
										<button class="button is-large is-fullwidth has-background-link-dark has-text-white-bis" type="button" onclick="submitLogin();">로그인</button>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</section>
		<footer class="modal-card-foot">
			<div class="buttons are-small is-centered">
			</div>
		</footer>
	</div>
</div>
<script>
	function submitLogin() {

		let formData = new FormData(document.getElementById('login-frm'));
		$.ajax({
			url: '/auth/checkLogin',
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
				location.reload();
			} else {
				alert(res.msg);
			}
		})
		.fail(function(res) {
			console.log(res);
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	}
</script>