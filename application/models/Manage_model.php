<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	public function getNoDTS($COD, $DVS, $NOS)
	{
		$sql = "SELECT DTS FROM sales WHERE COD = '{$COD}' AND DVS = '{$DVS}' AND NOS = '{$NOS}';";
		return $this->db->query($sql)->result_array()[0]['DTS'];
	}

	public function getNewNOS($COD, $DVS, $DTS)
	{
		// $sql = "SELECT RIGHT(NOS, 5) AS NOSNO FROM sales WHERE COD = '{$COD}' AND DVS = '{$DVS}' AND DTS = '{$DTS}';";
		// $result_arr = $this->db->query($sql)->result_array();
		// if ($result_arr) return ((int) $result_arr[0]['NOSNO'] + 1);
		// else return 1;
		$sql = "EXEC sp_sales_get_nos '{$COD}', '{$DVS}', '{$DTS}' ;";
		$result_arr = $this->db->query($sql)->result_array();
		return $result_arr[0]['pMAXNO'];
	}
	
	public function getDetailSeq($COD, $DVS, $NOS)
	{
		$sql = "SELECT IFNULL(MAX(SEQS) + 1, 1) AS NSEQS FROM salesd WHERE COD = '{$COD}' AND DVS = '{$DVS}' AND NOS = '{$NOS}';";
		$result_arr = $this->db->query($sql)->result_array();
		return $result_arr[0]['NSEQS'];
	}

	public function getMasterData($DVS, $COD, $YM, $D)
	{
		// $where = "";
		// if ($D) $where .= "AND RIGHT(sales.DTS, 2) = '{$D}'";
		// $sql = "
		// 	SELECT
		// 		sales.*
		// 		, RIGHT(sales.DTS, 2) AS DAT
		// 		, cods.NAM AS CDS_NAM
		// 	FROM
		// 		sales sales
		// 	LEFT OUTER JOIN
		// 		cmpy_cods cods
		// 	ON
		// 		sales.COD = cods.COD
		// 		AND sales.CDS = cods.CDS
		// 	WHERE
		// 		sales.DVS = '{$DVS}'
		// 		AND sales.COD = '{$COD}'
		// 		AND LEFT(sales.DTS, 6) = '{$YM}'
		// 		{$where}
		// 	ORDER BY
		// 		sales.DTS, sales.NOS+0 ASC
		// 	;
		// ";
		$sql = "EXEC sp_sales_select '{$COD}', '{$DVS}', '{$YM}{$D}' ;";
		return $this->db->query($sql)->result_array();
	}

	public function getDetailData($COD, $DVS, $NOS)
	{
		// $sql = "
		// 	SELECT
		// 		d.*
		// 		, p.NAM AS PCOD_NAM
		// 	FROM
		// 		salesd d
		// 	LEFT OUTER JOIN
		// 		prod p
		// 	ON
		// 		d.COD = p.COD
		// 		AND d.PCOD = p.PCOD
		// 	WHERE
		// 		d.DVS = '{$DVS}'
		// 		AND d.COD = '{$COD}'
		// 		AND d.NOS = '{$NOS}'
		// 	ORDER BY
		// 		d.SEQS+0 ASC;
		// ";
		$sql = "EXEC sp_salesd_select '{$COD}', '{$DVS}', '{$NOS}' ;";
		return $this->db->query($sql)->result_array();
	}

	// 미사용
	public function insertRowData($CRUD, $COD, $DVS, $DTS, $NOS, $TYP, $GBN, $CDS)
	{
		// $sql = "
		// 	INSERT INTO
		// 		sales (COD, DVS, DTS, TYP, GBN, CDS, NOS)
		// 	VALUES
		// 		('{$COD}', '{$DVS}', '{$DTS}', '{$TYP}', '{$GBN}', '{$CDS}', '{$NOS}');
		// ";
		$sql = "EXEC sp_sales_update 'C', '{$COD}', '{$DVS}', '{$DTS}', '{$NOS}', '{$TYP}', '{$GBN}', '{$CDS}', 0, 0;";
		return $this->db->query($sql);
	}

	public function updateRowData($CRUD, $COD, $DVS, $DTS, $NOS, $TYP, $GBN, $CDS, $NET, $VAT)
	{
		// $sql = "
		// 	UPDATE sales
		// 	SET
		// 		DTS = '{$DTS}'
		// 		, TYP = '{$TYP}'
		// 		, GBN = '{$GBN}'
		// 		, CDS = '{$CDS}'
		// 		, NET = '{$NET}'
		// 		, VAT = '{$VAT}'
		// 		, GRS = '{$GRS}'
		// 		, TRS = '{$TRS}'
		// 		, EBL = '{$EBL}'
		// 		, ENO = '{$ENO}'
		// 	WHERE
		// 		COD = '{$COD}'
		// 		AND NOS = '{$NOS}'
		// 		AND DVS = '{$DVS}'
		// 		AND DTS = '{$no_dts}';
		// ";
		$sql = "EXEC sp_sales_update '{$CRUD}', '{$COD}', '{$DVS}', '{$DTS}', '{$NOS}', '{$TYP}', '{$GBN}', '{$CDS}', '{$NET}', '{$VAT}';";

		// try {
		// 	if (!$this->db->query($sql)) {
		// 		throw new Exception($this->db->error(), 1);
		// 	}
		// } catch(Exception $e) {
		// 	var_dump($e);
		// }
		
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function deleteRowData($COD, $DVS, $NOS)
	{
		$sql = "EXEC sp_sales_delete '{$COD}', '{$DVS}', '{$NOS}';";
		return $this->db->query($sql);
	}

	public function transfer_tran_RowData($COD, $NOS)
	{
		$sql = "EXEC sp_sales_transfer_tran_gunbyul '{$COD}', '{$NOS}';";
		return $this->db->query($sql);
	}


	public function transfer_cancel_RowData($COD, $TNO)
	{
		$sql = "EXEC sp_sales_transfer_cancel_gunbyul '{$COD}', '{$TNO}';";
		return $this->db->query($sql);
	}


	// 미사용
	public function saveRowDataDetail($COD, $DVS, $NOS, $PCOD, $QTYS)
	{
		$CRUD = 'C';
		$sql = "EXEC sp_salesd_update '{$CRUD}', '{$COD}', '{$DVS}', '', '{$NOS}', '', '', '{$PCOD}', '{$QTYS}', '', '' ;";
		// return $this->db->query($sql);
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function updateRowDataDetail($CRUD, $COD, $DVS, $NOS, $SEQS, $DSEQ, $PCOD, $QTYS, $PRIC, $REMK)
	{
		$sql = "EXEC sp_salesd_update '{$CRUD}', '{$COD}', '{$DVS}', '', '{$NOS}', '{$SEQS}', '{$DSEQ}', '{$PCOD}', '{$QTYS}', '{$PRIC}', '{$REMK}';";
		// return $this->db->query($sql);
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	// 거래처 선택 modal 관련
	public function getCmpyCods($COD, $SCH, $CDS)
	{
		// $sql = "SELECT * FROM cmpy_cods WHERE COD = '{$COD}' ORDER BY CDS+0 ASC;";
		$sql = "EXEC sp_cmpy_cods_select '{$COD}', '{$SCH}', '{$CDS}' ;";
		return $this->db->query($sql)->result_array();
	}

	public function getNextCmpyCds($COD)
	{
		$sql = "SELECT IFNULL(MAX(CDS+0) + 1, 1) AS CDS FROM cmpy_cods WHERE COD = '{$COD}';";
		return $this->db->query($sql)->result_array()[0]['CDS'];
	}

	public function saveCmpyCds($CRUD, $COD, $CDS, $NAM, $SNO, $JNO, $OWN, $ZIP, $ADR1, $ADR2, $TYP, $KND, $MGR1, $EML1, $MGR2, $EML2)
	{
		$sql = "EXEC sp_cmpy_cods_update '{$CRUD}', '{$COD}', '{$CDS}', '{$NAM}', '{$SNO}', '{$JNO}', '{$OWN}', '{$ZIP}', '{$ADR1}', '{$ADR2}', '{$TYP}', '{$KND}', '{$MGR1}', '{$EML1}', '{$MGR2}', '{$EML2}', '', '' ;";
		return $this->db->query($sql);
	}

	// 거래처 유무 조회 쿼리, sp 2개 실행 안되서 일단 쿼리로 실행해봄
	public function isCmpyCods($COD, $CDS)
	{
		$sql = "SELECT COUNT(*) AS cnt FROM cmpy_cods WHERE COD = '{$COD}' AND CDS = '{$CDS}';";
		return $this->db->query($sql)->result_array()[0]['cnt'];
	}

	// 품목군 선택 modal 관련
	public function getPg($COD, $SCH)
	{
		$sql = "EXEC sp_pg_select '{$COD}', '{$SCH}' ;";
		return $this->db->query($sql)->result_array();
	}

	// 품목 선택 modal 관련
	public function getProd($COD, $SCH, $PCOD)
	{
		$sql = "EXEC sp_prod_select '{$COD}', '{$SCH}', '{$PCOD}' ;";
		return $this->db->query($sql)->result_array();
	}

	public function getNextPcod($COD)
	{
		$sql = "EXEC sp_prod_pcod '{$COD}';";
		return $this->db->query($sql)->result_array()[0]['PCOD'];
	}

	public function saveProd($CRUD, $COD, $PCOD, $DVS, $NAM, $STD, $UNT, $TAXCD, $STDCOST, $STDSALE, $RMK)
	{
		$sql = "EXEC sp_prod_update '{$CRUD}', '{$COD}', '{$PCOD}', '{$DVS}', '{$NAM}', '{$STD}', '{$UNT}', '{$TAXCD}', '{$STDCOST}', '{$STDSALE}', '{$RMK}' ;";
		//echo $sql;
		//exit;
		
		return $this->db->query($sql);
	}

	// 품목 유무 조회 쿼리, sp 2개 실행 안되서 일단 쿼리로 실행해봄
	public function isPcod($COD, $PCOD)
	{
		$sql = "SELECT COUNT(*) AS cnt FROM prod WHERE COD = '{$COD}' AND pcod = '{$PCOD}';";
		return $this->db->query($sql)->result_array()[0]['cnt'];
	}
}

?>