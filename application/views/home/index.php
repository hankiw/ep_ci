<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<style>
	#main_slide .hero {
		background-size:cover;
		background-repeat:no-repeat;
		background-position:center center;
	}

	#main_slide .hero-body {
		text-shadow: 1px 1px 1px black;
	}
	#main_slide .hero-body .title {
		font-size:6rem;
	}

	#main_slide .hero-body .title {
		font-size:1.8em;
	}
</style>

<style>
  .fixed-banner {
    position: fixed;
    top: 50%;
    right: 0;
    transform: translateY(-50%);
    width: 150px;
    height: 300px;
    background-image: url('/include/bannerbackimg.webp'); /* 배경 이미지 URL */
    background-size: cover; /* 이미지가 배너 크기에 맞게 조절 */
    background-position: center; /* 이미지가 중앙에 위치하도록 조절 */
    color: white;
    text-align: center;
    border: 1px solid #9E9E9E; /* 조금 더 진한 푸른색 테두리 */
    border-radius: 15px;
    box-shadow: 0px 4px 5px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  .banner-img {
    width: 100%;
    height: auto;
    transition: transform 0.3s ease;
  }
  .banner-img:hover {
    transform: scale(1.1);
  }
</style>

<div class="fixed-banner">
  <a href="https://example.com/link1">
    
    <a href="/board/lists?BNM=inq"><button type="button" class="button is-default">1:1문의</button></a>

  </a>
  <a href="https://example.com/link2">
    
    <a href="/board/lists?BNM=inq"><button type="button" class="button is-default">체험하기</button></a>
  </a>
  <a href="https://example.com/link3">
    
    <a href="/board/lists?BNM=inq"><button type="button" class="button is-default">매뉴얼</button></a>
  </a>
</div>


<section>
	<div>
		<h1 class="title mb-4 is-size-5-desktop is-size-6-tablet is-size-6-mobile"> </h1>
	</div>
	<div class="container" id="main_slide">
		<div class="hero is-large is-success" style="background-image:url('/include/1.webp'); height: 500px;">
			<div class="hero-body">
				<p class="title" style="font-size:3.5em;font-weight:bold;">
					업무 효율을 높이는 이펀치 ERP
				</p>
				<p class="subtitle" style="font-size:2rem;font-weight:bold;">
					주문, 출고, 세금계산서 발행까지 모든 업무를 한 곳에서 처리하세요. 이펀치와 함께라면 업무 처리가 편안해집니다.
				</p>
			</div>
		</div>
		<div class="hero is-large is-success" style="background-image:url('/include/2.webp'); height: 500px;">
			<div class="hero-body">
				<p class="title" style="font-size:3.5em;font-weight:bold;">
					간편한 전자세금계산서 발행
				</p>
				<p class="subtitle" style="font-size:2rem;font-weight:bold;">
					전자세금계산서 발행이 간편해집니다. 편리한 인터페이스와 신속한 발행으로 세금계산서 관리를 효율적으로 수행하세요.
				</p>
			</div>
		</div>
		<div class="hero is-large is-success" style="background-image:url('/include/3.webp'); height: 500px;">
			<div class="hero-body">
				<p class="title" style="font-size:3.5em;font-weight:bold;">
					실시간 재고현황 및 매출 분석
				</p>
				<p class="subtitle" style="font-size:2rem;font-weight:bold;">
					실시간으로 재고현황을 파악하고 매출 분석을 진행하세요. 직관적인 챠트를 통해 비즈니스를 관리하세요.
				</p>
			</div>
		</div>
	</div>
</section>
<script>
	$('#main_slide').slick({
		arrows: false
		, autoplay: true
		, autoplaySpeed: 3000
	});
</script>
<section class="section">
	<div class="container">
		<div class="level">
			<div class="level-left">
				<h1 class="title is-size-4">공지사항</h1>
			</div>
			<div class="level-left">
				<a href="/board/lists?BNM=notice"><button type="button" class="button is-default">더보기</button></a>
			</div>
		</div>
		<table class="table is-fullwidth is-striped">
			<colgroup>
				<col width="10%">
				<col width="65%">
				<col width="*">
			</colgroup>
			<thead>
				<tr>
					<th>No</th>
					<th>제목</th>
					<th>등록일</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($notice as $idx => $row): ?>
					<tr>
						<td><?=$row['no']?></td>
						<td><a href="<?=$row['href']?>"><?=$row['TITLE']?></a></td>
						<td><?=$row['RDTF']?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</section>