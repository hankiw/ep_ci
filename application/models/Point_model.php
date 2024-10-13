<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Point_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	public function test()
	{
		return true;
	}

	public function setPayPoint($COD, $UID, $PAYAMT)
	{
		$sql = "exec sp_cmpy_pnts_get '{$COD}', '{$UID}', '{$PAYAMT}';";
		return $this->db->query($sql);
	}

	public function usePoint($COD, $DSCR, $PNTS, $REFNO)
	{
		$sql = "exec sp_cmpy_pnts_use '{$COD}', '{$DSCR}', '{$PNTS}', '{$REFNO}';";
		return $this->db->query($sql);
	}
	
	public function getPointGetData($COD, $SDTS, $EDTS)
	{
		$sql = "exec sp_pnts_get_select '{$COD}', '{$SDTS}', '{$EDTS}';";
		return $this->db->query($sql)->result_array();
	}

	public function getPointUseData($COD, $SDTS, $EDTS)
	{
		$sql = "exec sp_pnts_use_select '{$COD}', '{$SDTS}', '{$EDTS}';";
		return $this->db->query($sql)->result_array();
	}
}

?>