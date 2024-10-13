<div class="navbar-menu" id="navbar">
	<div class="navbar-start">
		<div class="navbar-item has-dropdown is-hoverable mx-2">
			<a class="navbar-link is-arrowless" href="/main">대시보드</a>
		</div>

		<div class="navbar-item has-dropdown is-hoverable mx-2">
			<a class="navbar-link">판매관리</a>
			<div class="navbar-dropdown">
				<a class="navbar-item" href="/manage/storeout">판매 입력</a>
				<a class="navbar-item" href="/etax/invoice">세금계산서 합산발행</a>
				<a class="navbar-item" href="/manage/quotation">견적서 입력</a>
				<a class="navbar-item" href="/payment/payin">수금 입력</a>
			</div>
		</div>
		<div class="navbar-item has-dropdown is-hoverable mx-2">
			<a class="navbar-link">구매관리</a>
			<div class="navbar-dropdown">
				<a class="navbar-item" href="/manage/storein">구매 입력</a>
				<a class="navbar-item">구매 세금계산서 처리</a>
				<a class="navbar-item" href="/manage/request">발주서 입력</a>
				<a class="navbar-item" href="/payment/payout">지급 입력</a>
			</div>
		</div>
		<div class="navbar-item has-dropdown is-hoverable mx-2">
			<a class="navbar-link">전자세금계산서 관리</a>
			<div class="navbar-dropdown">
				<a class="navbar-item" href="/tran">전자세금계산서 입력</a>
			</div>
		</div>
		<div class="navbar-item has-dropdown is-hoverable mx-2">
			<a class="navbar-link">재고관리</a>
			<div class="navbar-dropdown">
				<a class="navbar-item" href="/member/stocklist">현재고 조회</a>
			</div>
		</div>
		<div class="navbar-item has-dropdown is-hoverable mx-2">
			<a class="navbar-link">환경설정</a>
			<div class="navbar-dropdown">
				<a class="navbar-item" href="/member/userlist">사용자관리</a>
				<a class="navbar-item" href="/member/codslist">거래처관리</a>
				<a class="navbar-item" href="/member/pglist">품목군관리</a>
				<a class="navbar-item" href="/member/prodlist">품목관리</a>
			</div>
		</div>
		<?php if ($this->login->CDIV == 'M'): ?>
			<div class="navbar-item has-dropdown is-hoverable mx-2">
				<a class="navbar-link">관리자</a>
				<div class="navbar-dropdown">
					<a class="navbar-item" href="/board/lists?BNM=notice">공지사항</a>
					<a class="navbar-item" href="/board/lists?BNM=inq">1:1문의</a>
					<a class="navbar-item" href="/board/lists?BNM=ref">자료실</a>
					<a class="navbar-item" href="/member/svcrqstlist">서비스신청관리</a>
					<a class="navbar-item" href="/document/index">메뉴얼문서(test)</a>
				</div>
			</div>
		<?php else: ?>
			<div class="navbar-item has-dropdown is-hoverable mx-2">
				<a class="navbar-link">게시판</a>
				<div class="navbar-dropdown">
					<a class="navbar-item" href="/board/lists?BNM=notice">공지사항</a>
					<a class="navbar-item" href="/board/lists?BNM=inq">1:1문의</a>
					<a class="navbar-item" href="/board/lists?BNM=ref">자료실</a>
				</div>
			</div>
		<?php endif ?>
	</div>
</div>