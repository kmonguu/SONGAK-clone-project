<?
if (!defined('_GNUBOARD_')) exit;
include_once("$g4[path]/lib/sms.lib.php");


class SMS {

	var $SMS4 = null;
	function SMS(){
		$this->SMS4 = new SMS4();
	}

	function SMS_con($sms_server,$sms_id,$sms_pw,$port) {
		$this->SMS4->SMS_con($sms_server,$sms_id,$sms_pw,$port);
	}

	function Init() {
	}

	function Add($dest, $callBack, $Caller, $msg, $rsvTime="") {
	
		$destArr = array();
		$destArr[] = array(
			"bk_hp" => $dest
			, "bk_name" => ""
		);
		
		return $this->SMS4->Add($destArr, $callBack, $Caller, '', $msg, "", 1);
	}


	function AddURL($dest, $callBack, $URL, $msg, $rsvTime="") {

		$destArr = array();
		$destArr[] = array(
			"bk_hp" => $dest
			, "bk_name" => ""
		);
		return $this->SMS4->Add($destArr, $callBack, '', $URL, $strData, "", 1);
	}


	function Send () {
		return $this->SMS4->Send();
	}

}
?>