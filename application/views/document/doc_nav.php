<div class="box" id="doc_nav">
	<input class="input is-link" type="text" placeholder="Search" onkeyup="setDocNav(this.value);">
	<aside class="menu mt-3">
		<ul class="menu-list depth1 ">
			<li>
				<a class="<?= ($this->current_page == 'index') ? 'is-active' : '' ?>" href="/document/index">사용방법 안내</a>
				<ul class="depth2">
					<li><a class="<?= ($pg == 'doc01') ? 'is-active' : '' ?>" href="/document/index?pg=doc01" data-key="접속하기">접속하기</a></li>
					<li><a class="<?= ($pg == 'doc02') ? 'is-active' : '' ?>" href="/document/index?pg=doc02" data-key="기준관리">기준관리</a></li>
					<li><a class="<?= ($pg == 'doc03') ? 'is-active' : '' ?>" href="/document/index?pg=doc03" data-key="예산등록">예산등록</a></li>
					<li><a class="<?= ($pg == 'doc04') ? 'is-active' : '' ?>" href="/document/index?pg=doc04" data-key="결의서">결의서</a></li>
					<li><a class="<?= ($pg == 'doc05') ? 'is-active' : '' ?>" href="/document/index?pg=doc05" data-key="마감">마감</a></li>
					<li><a class="<?= ($pg == 'doc06') ? 'is-active' : '' ?>" href="/document/index?pg=doc06" data-key="현황">현황</a></li>
					<li><a class="<?= ($pg == 'doc07') ? 'is-active' : '' ?>" href="/document/index?pg=doc07" data-key="자금수지계산서">자금수지계산서</a></li>
					<li><a class="<?= ($pg == 'doc08') ? 'is-active' : '' ?>" href="/document/index?pg=doc08" data-key="자금수지보고서">자금수지보고서</a></li>
					<li><a class="<?= ($pg == 'doc09') ? 'is-active' : '' ?>" href="/document/index?pg=doc09" data-key="게시판">게시판</a></li>
				</ul>
			</li>

		</ul>
	</aside>
</div>
<script>
	function setDocNav(key) {
		let navDepth1 = document.querySelectorAll('#doc_nav .depth1>li');
		let navDepth2;
		let thisItem;
		let isDepth1Show;

		for (d1 of navDepth1) {
			navDepth2 = d1.querySelectorAll('.depth2>li');
			isDepth1Show = 0;
			for (d2 of navDepth2) {
				thisItem = d2.querySelector('a');
				thisItem.innerHTML = thisItem.dataset.key;
				if (key == '') {
					thisItem.style.display = 'block';
					isDepth1Show++;
				} else if (thisItem.innerHTML.indexOf(key) >= 0) {
					thisItem.style.display = 'block';
					thisItem.innerHTML = thisItem.innerHTML.replaceAll(key, '<span class="has-background-success has-text-white">' + key + '</span>');
					isDepth1Show++;
				} else {
					thisItem.style.display = 'none';
				}
			}
			if (isDepth1Show > 0) d1.style.display = 'block';
			else d1.style.display = 'none';
		}
	}
</script>