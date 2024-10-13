<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	public function test()
	{
		return true;
	}

	// 사용자 리스트
	public function getUserData($COD, $SCH)
	{
		$sql = "exec sp_cmpy_user_select '{$COD}', '{$SCH}' ;";
		return $this->db->query($sql)->result_array();
	}
	
	public function updateUserData($CRUD, $COD, $SEQ, $UID, $UPW, $UNM, $STDT, $EDDT)
	{
		$sql = "exec sp_cmpy_user_update '{$CRUD}', '{$COD}', '{$SEQ}', '{$UID}', '{$UPW}', '{$UNM}', '{$STDT}', '{$EDDT}' ;";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	
	// 거래처 리스트
	public function getCodsData($COD, $SCH)
	{
		$sql = "exec sp_cmpy_cods_select '{$COD}', '{$SCH}','' ;";
		return $this->db->query($sql)->result_array();
	}
	
	public function updateCodsData($CRUD, $COD, $CDS , $NAM , $SNO , $JNO , $OWN , $ZIP , $ADR1, $ADR2, $TYP , $KND , $MGR1, $EML1, $MGR2, $EML2, $SDT , $EDT )
	{
		$sql = "exec sp_cmpy_cods_update '{$CRUD}','{$COD}','{$CDS}','{$NAM}','{$SNO}','{$JNO}','{$OWN}','{$ZIP}','{$ADR1}','{$ADR2}','{$TYP}','{$KND}','{$MGR1}','{$EML1}','{$MGR2}','{$EML2}','{$SDT}','{$EDT}' ;";
		$result = $this->db->query($sql);
		return $result->result_array();
	}




	// 품목군 리스트
	public function getPg($COD, $SCH)
	{
		$sql = "exec sp_pg_select '{$COD}', '{$SCH}' ;";
		return $this->db->query($sql)->result_array();
	}

	// 품목군 리스트
	public function getPgData($COD, $SCH)
	{
		$sql = "exec sp_pg_select '{$COD}', '{$SCH}' ;";
		return $this->db->query($sql)->result_array();
	}

	public function updatePgData($CRUD, $COD, $PGCD_SAVED, $PGCD, $PGNM, $SDT, $EDT  )
	{
		$sql = "exec sp_pg_update '{$CRUD}','{$COD}','{$PGCD_SAVED}','{$PGCD}','{$PGNM}','{$SDT}','{$EDT}' ;";
		$result = $this->db->query($sql);
		return $result->result_array();
	}


	// 서비스신청 리스트
	public function getSvcrqstData($SCH, $RQST_STAT)
	{
		$sql = "exec sp_svcrqst_select '{$SCH}', '{$RQST_STAT}' ;";
		return $this->db->query($sql)->result_array();
	}

	public function updateSvCrqstData($SEQ, $RQST_STAT, $RQST_REMK  )
	{
		$sql = "exec sp_svcrqst_update '{$SEQ}','{$RQST_STAT}','{$RQST_REMK}' ;";
		return $this->db->query($sql);
	}


	// 품목 리스트
	public function getProdData($COD, $SCH)
	{
		$sql = "exec sp_prod_select '{$COD}', '{$SCH}','' ;";
		return $this->db->query($sql)->result_array();
	}

	public function updateProdData($CRUD, $COD, $PCOD_SAVED, $PCOD, $DVS, $PGCD, $NAM, $STD, $UNT, $TAXCD, $STDCOST, $STDSALE, $RMK  )
	{
		$sql = "exec sp_prod_update_2nd '{$CRUD}','{$COD}','{$PCOD_SAVED}','{$PCOD}','{$DVS}','{$PGCD}','{$NAM}','{$STD}','{$UNT}','{$TAXCD}','{$STDCOST}','{$STDSALE}','{$RMK}' ;";
		$result = $this->db->query($sql);
		return $result->result_array();
		
	}




	// 현재고 현황
	public function getStockData($COD, $SCH)
	{
		$sql = "exec sp_stk_select '{$COD}', '{$SCH}', '' ;";
		return $this->db->query($sql)->result_array();
	}


}

?>