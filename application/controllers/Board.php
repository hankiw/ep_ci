<?php
// custom core
require_once APPPATH.'core/Controller_custom.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class Board extends Controller {
	function __construct() {
		parent::__construct();
		defined('INC_JS_URL') OR define('INC_JS_URL', '/include/js/');

		$this->BNM = $this->input->get('BNM');

		$this->load->model('Board_model');
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->mode = $this->input->get('m') ? $this->input->get('m') : 'l';
	}

	public function lists()
	{
		$BNM = $this->input->get('BNM');
		$data['page_title'] = $BNM;
		$data['page_name'] = $BNM;

		$COD = (isset($this->login->COD)) ? $this->login->COD : '';
		
		$this->load->view('templates/header', $data);
		if ($this->login->CDIV != 'M' && in_array($BNM, array('inq'))) {
			$this->boardListCmpy($BNM, $COD);
		} else {
			$this->boardList($BNM);
		}
		$this->load->view('templates/footer', $data);
	}

	public function write()
	{
		$BNM = $this->input->get('BNM');
		$data['page_title'] = $BNM;
		$data['page_name'] = $BNM;

		$this->load->view('templates/header', $data);
		$this->boardWrite($BNM);
		$this->load->view('templates/footer', $data);
	}

	public function view()
	{
		$BNM = $this->input->get('BNM');
		$data['page_title'] = $BNM;
		$data['page_name'] = $BNM;

		$this->load->view('templates/header', $data);
		$this->boardView($BNM);
		$this->load->view('templates/footer', $data);
	}

	public function boardList($BNM)
	{
		$page = (isset($_GET['page']) && (int) $_GET['page']) ? (int) $_GET['page'] : 1;
		$limit = 10;
		$sidx = (($page - 1) * $limit);
		$list_cnt = $this->Board_model->getListCnt($BNM);
		$list_page = $list_cnt > 0 ? ceil($list_cnt / $limit) : 1;
		$pager_start = (floor($page / 10) * 10) + 1;
		$pager_end = ($pager_start + 9) < $list_page ? ($pager_start + 9) : $list_page;

		$data['page'] = $page;
		$data['pager_start'] = $pager_start;
		$data['pager_end'] = $pager_end;
		if ($list_page > $page) $data['next_href'] = '/board/lists?BNM='.$BNM.'&page='.($page + 1);
		if ($page > 1) $data['prev_href'] = '/board/lists?BNM='.$BNM.'&page='.($page - 1);
		$data['list_href'] = "/board/lists?BNM={$BNM}";
		$data['BNM'] = $BNM;

		$list = $this->Board_model->getList($BNM, $sidx, $limit);
		$current_dt = new Datetime();
		foreach ($list as $idx => $row) {
			$row['href'] = "/board/view?BNM={$BNM}&BSEQ={$row['BSEQ']}";
			$row['no'] = $list_cnt - ($idx + $sidx);

			$row_dt = new Datetime($row['RDTF']);
			$row_dt_diff = $row_dt->diff($current_dt);
			$row['new'] = ($row_dt_diff->days <= 5) ? true : false;
			$list[$idx] = $row;
		}

		$data['list'] = $list;
		$this->load->view("board/{$BNM}/list", $data);
	}

	public function boardListCmpy($BNM, $COD)
	{
		$page = (isset($_GET['page']) && (int) $_GET['page']) ? (int) $_GET['page'] : 1;
		$limit = 10;
		$sidx = (($page - 1) * $limit);
		$list_cnt = $this->Board_model->getListCmpyCnt($BNM, $COD);
		$list_page = $list_cnt > 0 ? ceil($list_cnt / $limit) : 1;
		$pager_start = (floor($page / 10) * 10) + 1;
		$pager_end = ($pager_start + 9) < $list_page ? ($pager_start + 9) : $list_page;

		$data['page'] = $page;
		$data['pager_start'] = $pager_start;
		$data['pager_end'] = $pager_end;
		if ($list_page > $page) $data['next_href'] = '/board/lists?BNM='.$BNM.'&page='.($page + 1);
		if ($page > 1) $data['prev_href'] = '/board/lists?BNM='.$BNM.'&page='.($page - 1);
		$data['list_href'] = "/board/lists?BNM={$BNM}";
		$data['BNM'] = $BNM;

		$list = $this->Board_model->getListCmpy($BNM, $COD, $sidx, $limit);
		$current_dt = new Datetime();
		foreach ($list as $idx => $row) {
			$row['href'] = "/board/view?BNM={$BNM}&BSEQ={$row['BSEQ']}";
			$row['no'] = $list_cnt - ($idx + $sidx);

			$row_dt = new Datetime($row['RDTF']);
			$row_dt_diff = $row_dt->diff($current_dt);
			$row['new'] = ($row_dt_diff->days <= 5) ? true : false;
			$list[$idx] = $row;
		}

		$data['list'] = $list;
		$this->load->view("board/{$BNM}/list", $data);
	}

	public function boardWrite($BNM)
	{
		$data = array();
		$data['BNM'] = $BNM;
		$data['list_href'] = "/board/lists?BNM={$BNM}";
		$this->load->view("board/{$BNM}/write", $data);
	}

	public function boardView($BNM)
	{
		$BSEQ = $this->input->get('BSEQ');
		$data = array();
		$data['list_href'] = "/board/lists?BNM={$BNM}";
		$data['view'] = $this->Board_model->getView($BSEQ);
		
		$bfile = $this->Board_model->getBoardFile($BSEQ);
		foreach ($bfile as $idx => $bf) {
			$tmp = explode('/', $bf['BFILE']);
			$bf['filename'] = $tmp[count($tmp) - 1];
			$bf['href'] = substr($bf['BFILE'], 1);
			$bfile[$idx] = $bf;
		}

		$data['bfile'] = $bfile;
		$this->load->view("board/{$BNM}/view", $data);
	}

	public function writeProc()
	{
		$response = new StdClass();
		$this->form_validation->set_rules('BNM', '게시판', 'required');
		$this->form_validation->set_rules('UID', '아이디', 'required');
		$this->form_validation->set_rules('TITLE', '제목', 'required');
		$this->form_validation->set_rules('CONT', '내용', 'required');

		if (!$this->form_validation->run()) {
			$response->result = false;
			$response->msg = validation_errors();
		} else {
			$BNM = $this->input->post('BNM');
			$UID = $this->input->post('UID');
			$TITLE = $this->input->post('TITLE');
			$CONT = $this->input->post('CONT');
			$BVAR1 = $this->input->post('BVAR1') ? $this->input->post('BVAR1') : '';
			$BVAR2 = $this->input->post('BVAR2') ? $this->input->post('BVAR2') : '';
			$BCOD = $this->input->post('BCOD') ? $this->input->post('BCOD') : '';

			$response->result = $this->Board_model->insert($BNM, $UID, $TITLE, $CONT, $BVAR1, $BVAR2, $BCOD);
			if (!$response->result) {
				$response->msg = 'board insert error';
			} else {
				if ($_FILES['BFILE']) {
					$bfile = $_FILES['BFILE'];
					for ($i = 0;$i < count($bfile['name']);$i++) {
						$BSEQ = $this->db->insert_id();
						$filename = $bfile['name'][$i];
						$filepath = './include/upload/'.$BNM.'/BSEQ'.$BSEQ.'/';

						if ($filename) {
							if (!is_dir($filepath)) mkdir($filepath, 0777, true);
							
							if (move_uploaded_file($bfile['tmp_name'][$i], $filepath.$filename)) {
								$this->Board_model->insertBoardFile($BSEQ, $BNM, $i, $filepath.$filename);
								// if ($this->Board_model->isBoardFile($BNM, $i)) {
								// 	$this->Board_model->updateBoardFile($BNM, $i, $filepath.$filename);
								// } else {
								// 	$this->Board_model->insertBoardFile($BNM, $i, $filepath.$filename);
								// }
							}
						}
					}
				}
			}
		}
		
		echo json_encode($response, JSON_UNESCAPED_UNICODE);
		exit;
	}

	public function replyProc()
	{
		$response = new StdClass();
		$this->form_validation->set_rules('BSEQ', '게시글', 'required');
		$this->form_validation->set_rules('UID', '아이디', 'required');
		$this->form_validation->set_rules('RECONT', '답변', 'required');

		if (!$this->form_validation->run()) {
			$response->result = false;
			$response->msg = validation_errors();
		} else {
			$BSEQ = $this->input->post('BSEQ');
			$UID = $this->input->post('UID');
			$RECONT = $this->input->post('RECONT');

			$response->result = $this->Board_model->reply($BSEQ, $UID, $RECONT);
			if (!$response->result) {
				$response->msg = 'board insert error';
			}
		}
		
		echo json_encode($response, JSON_UNESCAPED_UNICODE);
		exit;
	}

	public function modifyNoticeProc()
	{
		$response = new StdClass();
		$this->form_validation->set_rules('BSEQ', '게시글', 'required');
		$this->form_validation->set_rules('UID', '아이디', 'required');
		$this->form_validation->set_rules('CONT', '내용', 'required');

		if (!$this->form_validation->run()) {
			$response->result = false;
			$response->msg = validation_errors();
		} else {
			$BSEQ = $this->input->post('BSEQ');
			$UID = $this->input->post('UID');
			$CONT = $this->input->post('CONT');

			$response->result = $this->Board_model->modifyNotice($BSEQ, $UID, $CONT);
			if (!$response->result) {
				$response->msg = 'board insert error';
			}
		}
		
		echo json_encode($response, JSON_UNESCAPED_UNICODE);
		exit;
	}
	
}
