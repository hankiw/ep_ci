<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	public function getListCnt($bo)
	{
		$sql = "SELECT COUNT(*) AS CNT FROM board WHERE BNM = '{$bo}';";
		$data = $this->db->query($sql)->result_array()[0];
		return (int) $data['CNT'];
	}

	public function getListCmpyCnt($bo, $cod)
	{
		$sql = "SELECT COUNT(*) AS CNT FROM board WHERE BNM = '{$bo}' AND BCOD = '{$cod}';";
		$data = $this->db->query($sql)->result_array()[0];
		return (int) $data['CNT'];
	}

	public function getList($bo, $sidx, $limit)
	{
		// mssql
		$sql = "
			SELECT *, CONVERT(CHAR(10), RDT, 23) AS RDTF, CONVERT(CHAR(10), UDT, 23) AS UDTF FROM board
			WHERE BNM = '{$bo}'
			ORDER BY BSEQ DESC
			OFFSET {$sidx} ROWS
			FETCH NEXT {$limit} ROWS ONLY
		";

		$data = $this->db->query($sql)->result_array();
		return $data;
	}

	public function getListCmpy($bo, $cod, $sidx, $limit)
	{
		// mssql
		$sql = "
			SELECT *, CONVERT(CHAR(10), RDT, 23) AS RDTF, CONVERT(CHAR(10), UDT, 23) AS UDTF FROM board
			WHERE BNM = '{$bo}' AND BCOD = '{$cod}'
			ORDER BY BSEQ DESC
			OFFSET {$sidx} ROWS
			FETCH NEXT {$limit} ROWS ONLY
		";
		$data = $this->db->query($sql)->result_array();
		return $data;
	}

	public function getLatest($bo, $limit)
	{
		$sql = "
			SELECT TOP {$limit} *, CONVERT(CHAR(8), RDT, 112) AS RDTF FROM board
			WHERE BNM = '{$bo}'
			ORDER BY BSEQ DESC;
		";

		$data = $this->db->query($sql)->result_array();
		return $data;
	}

	public function insert($BNM, $UID, $TITLE, $CONT, $BVAR1, $BVAR2, $BCOD)
	{
		$sql = "
			INSERT INTO board
				(BNM, UID, TITLE, CONT, RDT, UDT, BVAR1, BVAR2, BCOD)
			VALUES
				('{$BNM}', '{$UID}', '{$TITLE}', '{$CONT}', GETDATE(), GETDATE(), '{$BVAR1}', '{$BVAR2}', '{$BCOD}');
		";
		return $this->db->query($sql);
	}

	public function isBoardFile($BNM, $BFNO) {
		$sql = "SELECT count(BFSEQ) AS cnt FROM board_file WHERE BNM = '{$BNM}' AND BFNO = '{$BFNO}';";
		$tmp = $this->db->query($sql)->result_array()[0];
		return (int) $tmp['cnt'];
	}

	public function insertBoardFile($BSEQ, $BNM, $BFNO, $BFILE)
	{
		$sql = "
			INSERT INTO board_file
				(BSEQ, BNM, BFNO, BFILE, RDT)
			VALUES
				({$BSEQ}, '{$BNM}', '{$BFNO}', '{$BFILE}', GETDATE());
		";
		return $this->db->query($sql);
	}

	public function updateBoardFile($BNM, $BFNO, $BFILE)
	{
		$sql = "
			UPDATE board_file
			SET
				BFILE = '{$BFILE}'
				, RDT = GETDATE()
			WHERE
				BNM = '{$BNM}'
				AND BFNO = '{$BFNO}';
		";
		return $this->db->query($sql);
	}

	public function reply($BSEQ, $UID, $RECONT)
	{
		$sql = "
			UPDATE board
			SET
				RECONT = '{$RECONT}'
				, UDT = GETDATE()
			WHERE
				BSEQ = {$BSEQ};
		";
		return $this->db->query($sql);
	}

	public function modifyNotice($BSEQ, $UID, $CONT)
	{
		$sql = "
			UPDATE board
			SET
				CONT = '{$CONT}'
				, UDT = GETDATE()
			WHERE
				BSEQ = {$BSEQ};
		";
		return $this->db->query($sql);
	}

	public function getView($BSEQ)
	{
		$sql = "SELECT *, CONVERT(CHAR(10), RDT, 23) AS RDTF, CONVERT(CHAR(10), UDT, 23) AS UDTF FROM board WHERE BSEQ = {$BSEQ};";
		return $this->db->query($sql)->result_array()[0];
	}

	public function getBoardFile($BSEQ)
	{
		$sql = "SELECT * FROM board_file WHERE BSEQ = {$BSEQ} ORDER BY BFNO ASC;";
		return $this->db->query($sql)->result_array();
	}
}

?>