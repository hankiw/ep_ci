
<style>
	#doc_nav a {text-decoration:none;cursor:pointer;}
	#doc_nav ul {list-style:none;padding:0;margin:0;}
	#doc_nav.box {
		display:block;
		padding:1.25rem;
		border-radius:6px;
		box-shadow:0 0.5em 1em -0.125em rgba(10,10,10,.1), 0 0 0 1px rgba(10,10,10,.02);
	}

	#doc_nav.box input {
		-webkit-appearance:none;
		align-items:center;
		border:1px solid #485fc7;
		border-radius:4px;
		box-shadow:inset 0 0.0625em 0.125em rgba(10,10,10,.05);
		display:inline-flex;
		font-size:1rem;
		width:100%;
		height:2.5em;
		justify-content:flex-start;
		line-height:1.5;
		padding-bottom:calc(0.5em - 1px);
		padding-left:calc(0.75em - 1px);
		padding-right:calc(0.75em - 1px);
		padding-top:calc(0.5em - 1px);
		position:relative;
		vertical-align:top;
	}
	#doc_nav.box .menu {
		margin-top:.75rem;
		font-size:1rem;
	}
	#doc_nav.box .menu_list {
		line-height:1.25;
	}

	#doc_nav .menu-list a {
		border-radius:2px;
	    color:#4a4a4a;
	    display:block;
	    padding:0.5em 0.75em;
	}

	#doc_nav .menu-list a:hover {
	    background-color:#f5f5f5;
	    color:#363636;
	}

	#doc_nav .menu-list a.is-active {
		border-radius:2px;
	    color:#fff;
	    background-color:#485fc7;
	    display:block;
	    padding:0.5em 0.75em;
	}

	#doc_nav .menu-list li ul {
		border-left:1px solid #dbdbdb;
		margin:0.75em;
		padding-left:0.75em;
	}

	#doc_page.box {
		display:block;
		padding:1.25rem;
		border-radius:6px;
		box-shadow:0 0.5em 1em -0.125em rgba(10,10,10,.1), 0 0 0 1px rgba(10,10,10,.02);
	}

	#doc_page .doc_page_top {
		padding:1rem;
		margin-bottom:3rem;
	}

	#doc_page .title {
		color:#363636;
		font-size:2rem;
		font-weight:600;
		line-height:1.125;
	}

	#doc_page .title:not(.is-spaced)+.subtitle {
	    margin-top:-1.25rem;
	}

	#doc_page .page_item {
		display:flex;
		flex-flow:row wrap;
	}
	#doc_page .page_item .media {
		box-sizing:border-box;
		width:50%;
		padding:0.75rem;
		display:flex;
	}

	#doc_page .page_item .media strong {
	    color:#363636;
	    font-weight:700;
	}
	#doc_page .page_item .media strong:first-child {
		font-size:1.5rem;
	}
</style>

<div style="display:flex;justify-content:space-between;">
	<div style="width:20%;">
		<div class="box" id="doc_nav">
			<input class="input is-link" type="text" placeholder="Search" onkeyup="setDocNav(this.value);">
			<aside class="menu">
				<ul class="menu-list depth1 ">
					<li>
						<a class="is-active" href="/document/index">사용방법 안내</a>
						<ul class="depth2">
							<li><a class="" href="/document/index?pg=doc01" data-key="접속하기">접속하기</a></li>
							<li><a class="" href="/document/index?pg=doc02" data-key="기준관리">기준관리</a></li>
							<li><a class="" href="/document/index?pg=doc03" data-key="예산등록">예산등록</a></li>
							<li><a class="" href="/document/index?pg=doc04" data-key="결의서">결의서</a></li>
							<li><a class="" href="/document/index?pg=doc05" data-key="마감">마감</a></li>
							<li><a class="" href="/document/index?pg=doc06" data-key="현황">현황</a></li>
							<li><a class="" href="/document/index?pg=doc07" data-key="자금수지계산서">자금수지계산서</a></li>
							<li><a class="" href="/document/index?pg=doc08" data-key="자금수지보고서">자금수지보고서</a></li>
							<li><a class="" href="/document/index?pg=doc09" data-key="게시판">게시판</a></li>
						</ul>
					</li>
				</ul>
			</aside>
		</div>
	</div>
	<div style="width:75%;">
		<div class="box" id="doc_page">
			<div class="doc_page_top">
				<p class="title p-1">사용방법 안내</p>
				<p class="subtitle p-1">쉽고 편리한 금전출납부 형식의 회계시스템 <strong>조합Click</strong> 사용방법입니다.</p>
			</div>
			<div class="page_item">
				<article class="media">
					<figure class="media-left">
						<i class="fas fa-cube"></i>icon
					</figure>
					<div class="media-content">
						<p>
							<strong>자금수지보고서</strong>
							<br>
							세무법인 담당자가 <strong>검토한 후 마감을 하면</strong> 자금수지보고서를 조회 및 출력할 수 있습니다.
						</p>
					</div>
				</article>
				<article class="media">
					<figure class="media-left">
						<i class="fas fa-columns"></i>icon
					</figure>
					<div class="media-content">
						<p>
							<strong class="is-size-4">마감</strong>
							<br>
							세무법인 담당자는 결의서 등을 검토한 후에 <strong>월별로 마감</strong> 을 하게 되며, 마감 이후에는 결의서를 수정할 수 없습니다.
						</p>
					</div>
				</article>
				<article class="media">
					<figure class="media-left">
						<i class="fas fa-cube"></i>icon
					</figure>
					<div class="media-content">
						<p>
							<strong>자금수지보고서</strong>
							<br>
							세무법인 담당자가 <strong>검토한 후 마감을 하면</strong> 자금수지보고서를 조회 및 출력할 수 있습니다.
						</p>
					</div>
				</article>
				<article class="media">
					<figure class="media-left">
						<i class="fas fa-columns"></i>icon
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
		</div>
	</div>
</div>



