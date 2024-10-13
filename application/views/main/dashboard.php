<style>
	section.dashboard .box {
		background:-webkit-linear-gradient(top, rgb(59, 64, 70) 0%, rgb(46, 49, 56) 100%)
	}
	section.dashboard .box.c1 {
		color:#2be9cf;
	}
	section.dashboard .box.c2 {
		color:#d4b8ff;
	}
	section.dashboard .box.c3 {
		color:rgb(255, 192, 50);
	}
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<section class="section dashboard">
	<div class="container">
		<div class="columns summary_main">
			<div class="column is-one-fifth">
				<div class="box has-text-centered has-text-weight-bold c1">
					<div class="is-size-4">판매이익</div>
					<div class="mt-5 is-size-3" id="AMT1">-</div>
				</div>
			</div>
			<div class="column is-one-fifth">
				<div class="box has-text-centered has-text-weight-bold c1">
					<div class="is-size-4">현재매출</div>
					<div class="mt-5 is-size-3" id="AMT2">-</div>
				</div>
			</div>
			<div class="column is-one-fifth">
				<div class="box has-text-centered has-text-weight-bold c2">
					<div class="is-size-4">미수금액</div>
					<div class="mt-5 is-size-3" id="AMT3">-</div>
				</div>
			</div>
			<div class="column is-one-fifth">
				<div class="box has-text-centered has-text-weight-bold c2">
					<div class="is-size-4">미지급액</div>
					<div class="mt-5 is-size-3" id="AMT4">-</div>
				</div>
			</div>
			<div class="column is-one-fifth">
				<div class="box has-text-centered has-text-weight-bold c3">
					<div class="is-size-4">전일재고</div>
					<div class="mt-5 is-size-3" id="AMT5">-</div>
				</div>
			</div>
		</div>
		<div class="columns summary_chart">
			<div class="column is-half">
				<div class="box c1">
					<div class="is-size-4 has-text-centered has-text-weight-bold">판매이익</div>
					<canvas id="chart1"></canvas>
				</div>
			</div>
			<div class="column is-half">
				<div class="box c1">
					<div class="is-size-4 has-text-centered has-text-weight-bold">현재매출</div>
					<canvas id="chart2"></canvas>
				</div>
			</div>
		</div>
		<div class="columns summary_chart">
			<div class="column is-half">
				<div class="box c2">
					<div class="is-size-4 has-text-centered has-text-weight-bold">미수금액</div>
					<canvas id="chart3"></canvas>
				</div>
			</div>
			<div class="column is-half">
				<div class="box c2">
					<div class="is-size-4 has-text-centered has-text-weight-bold">미지급액</div>
					<canvas id="chart4"></canvas>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	drawChart('chart1', 'rgb(255, 192, 50)');
	drawChart('chart2', 'rgb(255, 192, 50)');
	drawChart('chart3', 'rgb(255, 192, 50)');
	drawChart('chart4', 'rgb(255, 192, 50)');
	summaryMain();

	Chart.defaults.font.size = 17;
	Chart.defaults.font.weight = 'bold';
	Chart.defaults.color = 'rgb(255, 192, 50)';
	Chart.defaults.elements.point.radius = 8;
	Chart.defaults.elements.point.hoverRadius = 16; //마우스 오버시 사이즈
	Chart.defaults.elements.point.hoverBorderWidth = 4;
	Chart.defaults.elements.point.hitRadius = 16; //근처에 가면 바로 반응


	Chart.defaults.elements.line.borderWidth = 4;

	function summaryMain() {
		$.ajax({
			url: '/main/summaryMain',
			type: 'post',
			dataType: 'json',
			data: {},
		})
		.done(function(data) {
			console.log(data);
			document.getElementById('AMT1').innerHTML = data.AMT1;
			document.getElementById('AMT2').innerHTML = data.AMT2;
			document.getElementById('AMT3').innerHTML = data.AMT3;
			document.getElementById('AMT4').innerHTML = data.AMT4;
			document.getElementById('AMT5').innerHTML = data.AMT5;
		});
	}

	function drawChart(cht, colr) {
		$.ajax({
			url: '/main/drawChart',
			type: 'post',
			dataType: 'json',
			data: {chart: cht},
		})
		.done(function(res) {
			console.log(res);
			let cLabel = [];
			let cData = [];
			for (row of res) {
				cLabel.push(row.DT);
				cData.push(row.AMT);
			}
			let chtObj = document.getElementById(cht);
			let chtData = {
				labels: cLabel,
				datasets: [{
					label: '',
					data: cData,
					fill: false,
					borderColor: colr, //'rgb(75, 192, 192)',
					tension: 0.1
				}]
			}
			new Chart(chtObj, {
				type: 'line'
				, data: chtData
				, options: {
					plugins: {
						legend: {display: false},
					


					}
					, scales: {
						y: {
							display: false
						}
					}
				}
			});
			console.log("success");
		}).always(function() {
			console.log("complete");
		});
	}
</script>