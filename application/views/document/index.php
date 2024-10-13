<section class="p-4">
	<div class="container">
		<div class="columns">
			<div class="column is-one-fifth-desktop">
				<?php $this->load->view('document/doc_nav.php'); ?>
			</div>
			<div class="column">
				<div class="box">
					<div class="p-4 mb-6">
						<p class="title p-1">사용방법 안내</p>
						<p class="subtitle p-1">쉽고 편리한 금전출납부 형식의 회계시스템 <strong>조합Click</strong> 사용방법입니다.</p>
					</div>
					<div class="columns is-flex is-flex-wrap-wrap is-flex-direction-row">
						<div class="column is-half-desktop docs-item" onclick="location.href='index?pg=doc01';">
							<article class="media is-clickable p-3">
								<figure class="media-left has-text-primary is-size-4">
									<i class="fas fa-eye"></i>
								</figure>
								<div class="media-content">
									<p>
										<strong class="is-size-4">접속하기</strong>
										<br>
										조합Click 은 언제 어디서나 <strong>웹을 통하여 쉽게 접속</strong> 할 수 있습니다.
									</p>
								</div>
							</article>
						</div>
						<div class="column is-half-desktop docs-item" onclick="location.href='index?pg=doc02';">
							<article class="media is-clickable p-3">
								<figure class="media-left has-text-primary is-size-4">
									<i class="fas fa-tools"></i>
								</figure>
								<div class="media-content">
									<p>
										<strong class="is-size-4">기준관리</strong>
										<br>
										통장계좌, 체크카드, 거래처, 계정과목, 예산과목, 결재라인 등을 관리하는 방법입니다.
									</p>
								</div>
							</article>
						</div>
						<div class="column is-half-desktop docs-item" onclick="location.href='index?pg=doc03';">
							<article class="media is-clickable p-3">
								<figure class="media-left has-text-primary is-size-4">
									<i class="fas fa-paint-brush"></i>
								</figure>
								<div class="media-content">
									<p>
										<strong class="is-size-4">예산등록</strong>
										<br>
										예산을 등록하는 방법입니다. (전년도예산복사 기능)
									</p>
								</div>
							</article>
						</div>
						<div class="column is-half-desktop docs-item" onclick="location.href='index?pg=doc04';">
							<article class="media is-clickable p-3">
								<figure class="media-left has-text-primary is-size-4">
									<i class="fas fa-medkit"></i>
								</figure>
								<div class="media-content">
									<p>
										<strong class="is-size-4">지출결의서와 수입결의서</strong>
										<br>
										결의서 입력방법, 증빙첨부하기, 예산잔액확인하기, 결의서 출력 방법안내입니다.
									</p>
								</div>
							</article>
						</div>
						<div class="column is-half-desktop docs-item" onclick="location.href='index?pg=doc05';">
							<article class="media is-clickable p-3">
								<figure class="media-left has-text-primary is-size-4">
									<i class="fas fa-columns"></i>
								</figure>
								<div class="media-content">
									<p>
										<strong class="is-size-4">마감</strong>
										<br>
										세무법인 담당자는 결의서 등을 검토한 후에 <strong>월별로 마감</strong> 을 하게 되며, 마감 이후에는 결의서를 수정할 수 없습니다.
									</p>
								</div>
							</article>
						</div>
						<div class="column is-half-desktop docs-item" onclick="location.href='index?pg=doc06';">
							<article class="media is-clickable p-3">
								<figure class="media-left has-text-primary is-size-4">
									<i class="fas fa-warehouse"></i>
								</figure>
								<div class="media-content">
									<p>
										<strong class="is-size-4">현황</strong>
										<br>
										금전출납부, 업무추진비 집행내역, 예산결산대비표는 <strong>세무법인 마감 전에도</strong> 조회하고 출력할 수 있습니다.
									</p>
								</div>
							</article>
						</div>
						<div class="column is-half-desktop docs-item" onclick="location.href='index?pg=doc07';">
							<article class="media is-clickable p-3">
								<figure class="media-left has-text-primary is-size-4">
									<i class="fab fa-wpforms"></i>
								</figure>
								<div class="media-content">
									<p>
										<strong class="is-size-4">자금수지계산서</strong>
										<br>
										세무법인 담당자가 <strong>검토한 후 마감을 하면</strong> 자금수지계산서를 조회 및 출력할 수 있습니다.
									</p>
								</div>
							</article>
						</div>
						<div class="column is-half-desktop docs-item" onclick="location.href='index?pg=doc08';">
							<article class="media is-clickable p-3">
								<figure class="media-left has-text-primary is-size-4">
									<i class="fas fa-cube"></i>
								</figure>
								<div class="media-content">
									<p>
										<strong class="is-size-4">자금수지보고서</strong>
										<br>
										세무법인 담당자가 <strong>검토한 후 마감을 하면</strong> 자금수지보고서를 조회 및 출력할 수 있습니다.
									</p>
								</div>
							</article>
						</div>
						<div class="column is-half-desktop docs-item" onclick="location.href='index?pg=doc09';">
							<article class="media is-clickable p-3">
								<figure class="media-left has-text-primary is-size-4">
									<i class="fas fa-cubes"></i>
								</figure>
								<div class="media-content">
									<p>
										<strong class="is-size-4">게시판</strong>
										<br>
										공지사항, 1:1문의, 자료실, 자주묻는질문에 대한 사용방법입니다.
									</p>
								</div>
							</article>
						</div>
					</div>
				</div>
				<script>
					$('.docs-item').hover(function() {
						$(this).addClass('has-background-primary-light');
					}, function() {
						$(this).removeClass('has-background-primary-light');
					});
				</script>
			</div>
		</div>
	</div>
</section>