<div id="modal-PG" class="modal">
	<div class="modal-background"></div>
	<div class="modal-card">
		<header class="modal-card-head">
			<p class="modal-card-title">품목군 코드 도움</p>
			<button class="delete" aria-label="close" onclick="closeModal('modal-PG');"></button>
		</header>
		<section class="modal-card-body">
			<div id="pg_grid" class="mb-1" style="width:100%;height:300px;"></div>
		</section>
		<section class="modal-card-body">
			<div class="field is-grouped">
				<div class="control">
					<input class="input is-small" type="text" placeholder="품목군" id="pg_search">
				</div>
				<div class="control">
					<a class="button is-info is-small" onclick="pgSearch(document.getElementById('pg_search').value);">검색</a>
				</div>

				

			</div>
		</section>
		<footer class="modal-card-foot">
			<div class="buttons are-small is-centered">
				<button class="button is-success" id="pg_select_btn" onclick="pgSelect();">선택</button>
				<button class="button" onclick="closeModal('modal-PG');">취소</button>
			</div>
		</footer>
	</div>
</div>


<script>
	// openModal('modal-PG-reg');
	
	var selectedPGCD;
	var selectedPGNM;
	var dataPg;
	document.addEventListener('DOMContentLoaded', function() {
		providerPg = new RealGrid.LocalDataProvider();
		gridViewPg = new RealGrid.GridView('pg_grid');
		gridViewPg.setDataSource(providerPg);

		gridViewPg.displayOptions.rowHeight = 30;
		gridViewPg.displayOptions.selectionMode = "none";
		gridViewPg.displayOptions.selectionStyle = "singleRow";


		// 단순조회물, 풋터는 표시하지 않는다.
		gridViewPg.setFooters({
		  	visible: false
		});

		gridViewPg.header.height = 36;
		//gridViewPg.footer.height = 30;

		providerPg.setFields([
			{fieldName: 'PGCD', dataType: 'text'}
			, {fieldName: 'PGNM', dataType: 'text'}
		]);

		gridViewPg.onKeyDown = function (grid, event) {
		    
		    if (event.keyCode == 13) {
		    	pgSelect();
		    	return false;
		    }

		};


		gridViewPg.setColumns([
			{
				name: 'PGCD'
				, fieldName: 'PGCD'
				, width: 150
				, editable: false
				, header: {text: '품목군코드'}
			}
			, {
				name: 'PGNM'
				, fieldName: 'PGNM'
				, width: 200
				, editable: false
				, header: {text: '품목군'}
			}
			
		]);

		gridViewPg.onCurrentRowChanged = function(grid, oldRow, newRow) {
			console.log('check', oldRow, newRow);
			console.log(grid);
			
			// 품목 선택 정보
			selectedPGCD = providerPg.getValue(newRow, 'PGCD');
			selectedPGNM = providerPg.getValue(newRow, 'PGNM');
		}
	});

	// 품목 데이터 가져오기
	function setPgData() {
		gridViewPg.showLoading();

		//$COD = $this->session->userdata('UCOD');

		$.ajax({
			url: '/manage/getPg/',
			type: 'post',
			dataType: 'json',
			data: {
				COD: "1"
				, SCH: ""
			},
		})
		.done(function(jsonData) {
			providerPg.fillJsonData(jsonData, {fillMode : 'set'});
			dataPg = jsonData;
			gridViewPg.commit(true);
			gridViewPg.closeLoading();
			gridViewPg.setFocus();
		})
		.always(function() {
			console.log('gridPgData complete');
		});

		// 검색 입력 reset
		document.getElementById('pg_search').value = '';
		
		//document.getElementById("pg_grid").focus();
		//gridViewPg.setfocus();

	}

	function pgSelect() {

		

		providerProd.setValue(modalTargetIndex, 'PGCD', selectedPGCD);
		providerProd.setValue(modalTargetIndex, 'PGNM', selectedPGNM);
		
		//console.log(modalTargetIndex, modalTargetGrid);


		
		//alert(modalTargetIndex);

		//커밋을 한 다음에 parent.saveData를 태워야 합니다.
		
		//alert("before commit");

		gridViewProd.commit(true);

		//alert("before save data");

		//saveData(modalTargetIndex);



		//모달은 마지막에 닫아야 합니다.
		closeModal('modal-PG');



		gridViewProd.onEditRowChanged(modalTargetGrid, modalTargetIndex, 0, 0, 0, 0);

		//gridViewProg.setCurrent(modalTargetIndex, providerProd.getFieldIndex("PGCD"));
		//gridViewProd.setfocus();
		//document.getElementById("prod_grid").focus();





		//alert("before modal close");




	}

	function pgSearch(val) {
		setPgData();
	}
</script>