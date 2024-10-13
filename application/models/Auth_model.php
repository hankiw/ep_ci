<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {
	private $COD;
	private $MID;
	private $MPW;
	
	function __construct() {
		parent::__construct();
	}

	public function checkLogin($COD, $UID, $UPW)
	{
		// $sql = "CALL sp_user_login('{$COD}', '{$UID}', '{$UPW}');";
		$sql = "EXEC sp_user_login '{$COD}', '{$UID}', '{$UPW}';";
		
		return $this->db->query($sql)->result_array();
	}

	public function getLoginInfo($UCOD, $UID)
	{
		$sql = "
			SELECT U.COD, U.UID, U.UNM, U.USECD, C.CDIV, C.NAM AS CNAM, C.BALPNT, R.UTEL, R.EML
			FROM cmpy_user U, cmpy C
			LEFT OUTER JOIN
				svcrqst R
			ON
				C.COD = R.COD
			WHERE
				U.COD =  C.COD
				AND U.COD = '{$UCOD}' AND U.UID = '{$UID}';
		";
		$result = $this->db->query($sql)->result_object();
		if ($result) return $result[0];
		else return false;
	}
}

?>