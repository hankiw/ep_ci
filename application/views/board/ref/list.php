<section class="section">
	<div class="container">
		<h1 class="title">자료실</h1>
		<!-- <h2 class="subtitle">1:1문의</h2> -->
		<?php if ($this->login->CDIV == 'M'): ?>
			<div class="field is-grouped is-grouped-right">
				<div class="control">
					<a href="/board/write?BNM=<?=$BNM?>"><button type="button" class="button is-info">글쓰기</button></a>
				</div>
			</div>
		<?php endif ?>
		<table class="table is-fullwidth is-striped">
			<colgroup>
				<col width="4%">
				<col width="12%">
				<col width="*">
				<col width="12%">
			</colgroup>
			<thead>
				<tr>
					<th>No</th>
					<th>구분</th>
					<th>제목</th>
					<th>등록일</th>
				</tr>
			</thead>
			<tbody>
				<?php if (count($list) > 0): ?>
					<?php foreach ($list as $idx => $row): ?>
						<tr>
							<td><?=$row['no']?></td>
							<td><?=$row['BVAR1']?></td>
							<td>
								<a href="<?=$row['href']?>">
									<?=$row['TITLE']?>
									<?php if ($row['new']) : ?><span class="tag is-primary is-normal">N</span><?php endif ?>
								</a>
							</td>
							<td><?=$row['RDTF']?></td>
						</tr>
					<?php endforeach ?>
				<?php else: ?>
					<tr>
						<td colspan="3">내용이 없습니다.</td>
					</tr>
				<?php endif ?>
			</tbody>
		</table>
		<nav class="pagination is-centered" role="navigation" aria-label="pagination">
			<?php if (isset($prev_href)): ?>
				<a href="<?=$prev_href?>" class="pagination-previous">이전</a>
			<?php endif ?>
			<?php if (isset($next_href)): ?>
				<a href="<?=$next_href?>" class="pagination-next">다음</a>
			<?php endif ?>
			<ul class="pagination-list">
				<?php for ($i = $pager_start;$i <= $pager_end;$i++): ?>
					<li><a href="<?=$list_href?>&page=<?=$i?>" class="pagination-link <?=($page == $i) ? 'is-current' : ''?> "><?=$i?></a></li>
				<?php endfor ?>
			</ul>
		</nav>
	</div>
</section>