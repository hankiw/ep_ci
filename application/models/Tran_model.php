<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tran_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	public function test()
	{
		return true;
	}

	public function getTranData($COD, $DTS)
	{
		$sql = "exec sp_tran_select '{$COD}', '{$DTS}' ;";
		return $this->db->query($sql)->result_array();
	}

	public function updateTranData($CRUD, $COD, $DVS, $DTS, $TNO, $TYP, $GBN, $CDS, $NET, $VAT)
	{
		$sql = "exec sp_tran_update '{$CRUD}', '{$COD}', '{$DVS}', '{$DTS}', '{$TNO}', '{$TYP}', '{$GBN}', '{$CDS}', '{$NET}', '{$VAT}' ;";
		$result = $this->db->query($sql);
		return $result->result_array();
	}

	public function getEtaxData($COD, $TNO)
	{
		$sql = "exec sp_tran_etax_select '{$COD}', '{$TNO}' ;";
		return $this->db->query($sql)->result_array();
	}
	
}

?>