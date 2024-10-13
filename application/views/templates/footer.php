		<footer class="footer p-5">
			<div class="container">
				<div class="content has-text-left">
					<strong>위드그린컨설팅</strong>
					&nbsp;&nbsp;withgreen@naver.com
					&nbsp;&nbsp;사업자번호 123-45-12345
				</div>
			</div>
		</footer>
		<style>
			#ajax_loader {}
			.modal_layer {display:none;}
			.modal_layer.on {
				display:flex;
				align-items:center;
				justify-content:center;
				width:100%;
				height:100%;
				position:fixed;
				top:0;
				left:0;
				z-index:2000;
				background-color:rgba(0, 0, 0, 0.6);
			}
			.modal_layer .lds-dual-ring {
				display: inline-block;
				width: 120px;
				height: 120px;
			}
			.modal_layer .lds-dual-ring:after {
				content: '';
				display: block;
				width: 64px;
				height: 64px;
				margin: 8px;
				border-radius: 50%;
				border: 10px solid #fff;
				border-color: #fff transparent #fff transparent;
				animation: lds-dual-ring 1.5s linear infinite;
			}
			@keyframes lds-dual-ring {
				0% { transform: rotate(0deg); }
				100% { transform: rotate(360deg); }
			}
		</style>
		<div id="ajax_loader" class="modal_layer">
			<div class="lds-dual-ring"></div>
		</div>
		<script>
			function toggleLoader(bOn) {
				if (bOn) document.getElementById('ajax_loader').classList.add('on');
				else document.getElementById('ajax_loader').classList.remove('on');
			}

			// modal on/off
			function openModal(id) {
				let modal = document.getElementById(id);
				modal.classList.add('is-active');
			}

			function closeModal(id) {
				let modal = document.getElementById(id);
				modal.classList.remove('is-active');

				if (typeof modalTargetGrid !== 'undefined' && modalTargetGrid) modalTargetGrid.setFocus();
			}

			function numberFormat(num) {
				return new Intl.NumberFormat("en-US", {style: 'decimal',}).format(num);
			}

			function sqlErrorMsg(text) {
				if (text.indexOf('<p>Message:  mssql_query(): message:') < 0) {
					return '500 ERROR';
				}
				let errorTmp = text.split('<p>Message:  mssql_query(): message:')[1];
				let errorText = errorTmp.substring(0, errorTmp.indexOf('</p>'));
				return errorText;
			}
		</script>
		<script>
			if ($('.monthpicker').length > 0) {
				$('.monthpicker').datepicker({
					format: "yyyy-mm",
					viewMode: "month", 
					minViewMode: 1,
					language: "ko",
					autoclose: true
				});
			}
		</script>
	</body>
</html>