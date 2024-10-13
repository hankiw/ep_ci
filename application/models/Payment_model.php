<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	public function test()
	{
		return true;
	}

	public function getPaymentData($COD, $DVS, $PDT)
	{
		$sql = "EXEC sp_pays_select '{$COD}', '{$DVS}', '{$PDT}' ;";
		return $this->db->query($sql)->result_array();
	}

	public function updatePaymentData($CRUD, $COD, $CDS, $PDT, $DVS, $PNO, $PAMT, $PCDS, $PRMK)
	{
		$sql = "EXEC sp_pays_update '{$CRUD}', '{$COD}', '{$CDS}', '{$PDT}', '{$DVS}', '{$PNO}', '{$PAMT}', '{$PCDS}', '{$PRMK}' ;";
		return $this->db->query($sql);
	}

	public function getAccountData($COD, $CDS, $PNO)
	{
		$sql = "EXEC sp_paysd_select '{$COD}', '{$CDS}', '{$PNO}', '', '', '' ;";
		return $this->db->query($sql)->result_array();
	}

	public function updateAccountData($COD, $CDS, $PNO, $DVS, $ENO, $PAMT, $OAMT, $PRMK)
	{
		$sql = "EXEC sp_paysd_update '{$COD}', '{$CDS}', '{$PNO}', '{$DVS}', '{$ENO}', '{$PAMT}', '{$OAMT}', '{$PRMK}' ;";
		return $this->db->query($sql);
	}


	// 입금구분 select
	public function getPcds($COD, $SCH, $CDS)
	{
		$sql = "EXEC sp_cmpy_cods2_select '{$COD}', '{$SCH}', '{$CDS}' ;";
		return $this->db->query($sql)->result_array();
	}

	public function getNextPcdsCds($COD)
	{
		$sql = "SELECT IFNULL(MAX(CDS+0) + 1, 1) AS CDS FROM cmpy_cods2 WHERE COD = '{$COD}';";
		return $this->db->query($sql)->result_array()[0]['CDS'];
	}

	public function saveCmpyCds2($CRUD, $COD, $CDS, $NAM, $SNO, $JNO, $OWN, $ZIP, $ADR1, $ADR2, $TYP, $KND, $MGR1, $EML1, $MGR2, $EML2)
	{
		$sql = "EXEC sp_cmpy_cods2_update '{$CRUD}', '{$COD}', '{$CDS}', '{$NAM}', '{$SNO}', '{$JNO}', '{$OWN}', '{$ZIP}', '{$ADR1}', '{$ADR2}', '{$TYP}', '{$KND}', '{$MGR1}', '{$EML1}', '{$MGR2}', '{$EML2}', '', '' ;";
		return $this->db->query($sql);
	}

	// 입금구분 유무 조회 쿼리, sp 2개 실행 안되서 일단 쿼리로 실행해봄
	public function isCmpyCods2($COD, $CDS)
	{
		$sql = "SELECT COUNT(*) AS cnt FROM cmpy_cods2 WHERE COD = '{$COD}' AND CDS = '{$CDS}';";
		return $this->db->query($sql)->result_array()[0]['cnt'];
	}
}

?>