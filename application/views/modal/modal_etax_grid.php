<div id="modal-ETAX-GRID" class="modal">
	<div class="modal-background"></div>
	<div class="modal-card">
		<header class="modal-card-head">
			<p class="modal-card-title">세금계산서 발행</p>
			<button class="delete" aria-label="close" onclick="closeModal('modal-ETAX-GRID');"></button>
		</header>
		<section class="modal-card-body">
			<input type="hidden" id="e_nos" name="e_nos">
			<div>
				Lorem ipsum dolor, sit amet consectetur adipisicing elit. Facilis, quaerat pariatur vel laborum sit voluptas rerum iure molestias, quod unde error natus saepe nemo, minima maxime excepturi, voluptatem quibusdam veniam?
			</div>
			<div class="notification is-info">
				<div class="level">
					<div class="level-left">
						<span class="tag is-primary is-medium"><?=$this->login->CNAM?></span>&nbsp;님의 잔여포인트는&nbsp;<span id="u_balpnt"><?=number_format($this->login->BALPNT)?></span>&nbsp;Point 입니다.
					</div>
					<div class="level-right">
						<button type="button" class="button is-warning is-small" onclick="openPointModal();">내 포인트 관리</button>
					</div>
				</div>
			</div>
		</section>
		<footer class="modal-card-foot">
			<div class="buttons are-small is-centered">
				<button class="button is-success" onclick="return makeEtaxRun();">발행</button>
				<!-- <button class="button is-danger" onclick="">삭제</button> -->
				<button class="button" onclick="closeModal('modal-ETAX-GRID');">취소</button>
			</div>
		</footer>
	</div>
</div>
<script>
	// 아래 함수들 는 모달 오픈 페이지에서 별도로 정의
	function makeEtaxRun_NOUSE() {}

	function openMakeEtaxSingle_NOUSE() {}

	function openPointModal() {
		// closeModal('modal-ETAX');
		openModal('modal-POINT');
		initPointModal();
	}

	// 입력폼 reset
	function resetFormETAX(obj) {
		let inputObj = document.getElementById(obj).querySelectorAll('input');
		inputObj.forEach(function(obj, idx) {
			obj.value = '';
		});
	}
</script>