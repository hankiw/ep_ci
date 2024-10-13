<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Etax_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	public function getCmpyInfo($COD, $CDS)
	{
		$sql = "EXEC sp_cmpy_cods_select '{$COD}', '', '{$CDS}' ;";
		$data = $this->db->query($sql)->result_array()[0];
		return $data;
	}

	public function makeEtaxSingle($COD, $TNO, $DTS_YY, $DTS_MM, $DTS_DD, $TYP, $CDS, $NET, $VAT, $MDFYCD, $EDIV, $EEML, $EDTS, $ATNO)
	{
		$sql = "EXEC sp_tran_etax_update '{$COD}', '{$TNO}', '{$DTS_YY}', '{$DTS_MM}', '{$DTS_DD}', '{$TYP}', '{$CDS}', '{$NET}', '{$VAT}', '{$MDFYCD}', '{$EDIV}', '{$EEML}', '{$EDTS}', '{$ATNO}' ;";
		$result = $this->db->query($sql);
		return $result;
	}

	public function makeEtaxMulti($COD, $NOS)
	{
		$sql = "EXEC sp_sales_transfer_tran '{$COD}', '{$NOS}' ;";
		$result = $this->db->query($sql);
		return $result;
	}

	public function cancelEtaxMulti($COD, $TNO)
	{
		$sql = "EXEC sp_sales_transfer_cancel '{$COD}', '{$TNO}' ;";
		$result = $this->db->query($sql);
		return $result;
	}

	// 합산계산서발행 페이지
	public function getCompanyData($COD, $DVS, $SDT, $EDT)
	{
		$sql = "EXEC sp_sales_cmpy_cods_select '{$COD}', '{$DVS}', '{$SDT}', '{$EDT}' ;";
		return $this->db->query($sql)->result_array();
	}

	public function getSalesData($COD, $DVS, $SDT, $EDT, $CDS)
	{
		$sql = "EXEC sp_sales_cmpy_cods_etax_select '{$COD}', '{$DVS}', '{$SDT}', '{$EDT}', '{$CDS}' ;";
		return $this->db->query($sql)->result_array();
	}

	public function getInvoiveData($COD, $DVS, $SDT, $EDT, $CDS)
	{
		$sql = "EXEC sp_sales_cmpy_cods_etax_select2 '{$COD}', '{$DVS}', '{$SDT}', '{$EDT}', '{$CDS}' ;";
		return $this->db->query($sql)->result_array();
	}

	// 미사용
	// public function getEtaxBef($COD, $DVS, $NOS)
	// {
	// 	$sql = "EXEC sp_etax_bef_select  '{$COD}', '{$DVS}', '{$NOS}';";
	// 	$data = $this->db->query($sql)->result_array()[0];
	// 	return $data;
	// }

	// public function makeEtaxSingle($COD, $DVS, $ENO, $CDS, $NOS, $EDTS, $EITM, $ERMK, $EMGR, $EEML)
	// {
	// 	$sql = "EXEC sp_etax_update '{$COD}', '{$DVS}', '{$ENO}', '{$CDS}', '{$NOS}', '{$EDTS}', '{$EITM}', '{$ERMK}', '{$EMGR}', '{$EEML}' ;";
	// 	$result = $this->db->query($sql);
	// 	return $result;
	// }
}

?>