<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	public function getSummaryMain($COD)
	{
		$sql = "exec sp_dashboard_select_01 '{$COD}' ;";
		return $this->db->query($sql)->result_array()[0];
	}

	public function getChartData($p1, $p2, $p3)
	{
		$sql = "exec sp_dashboard_select_02 '{$p1}', '{$p2}', '{$p3}', '' ;";
		return $this->db->query($sql)->result_array();
	}

	public function registCmpy($NAM, $SNO, $EML, $UNM, $UTEL, $UID, $UPW, $UPW_CONF)
	{
		$sql = "EXEC sp_svcrqst_request '{$NAM}', '{$SNO}', '{$EML}', '{$UNM}', '{$UTEL}', '{$UID}', '{$UPW}', '{$UPW_CONF}';";
		$result = $this->db->query($sql)->result_id;
		return $result;
	}
}

?>