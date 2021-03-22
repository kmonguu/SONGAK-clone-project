<?php
// 회원사 로직에 맞게 수정요함
// input parameter 
// $P_STATUS;      // 거래상태 : 0021(성공), 0031(실패), 0000(진행)
// $P_TR_NO;       // 거래번호
// $P_AUTH_DT;     // 승인시간 
// $P_AUTH_NO      // 승인번호
// $P_TYPE;        // 거래종류 (CARD, BANK)
// $P_MID;         // 회원사아이디
// $P_OID;         // 주문번호
// $P_FN_CD1;      // 금융사코드 (은행코드, 카드코드)
// $P_FN_CD2;      // 금융사코드 (은행코드, 카드코드)
// $P_FN_NM;       // 금융사명 (은행명, 카드사명)
// $P_UNAME;       // 주문자명
// $P_AMT;         // 거래금액
// $P_NOTI;        // 주문정보
// $P_RMSG1;       // 메시지1
// $P_RMSG2;       // 메시지2

//	return value
//  true  : 성공
//  false : 실패

function noti_success($noti)
{
	global $g4;
	//결제에 관한 log남기게 됩니다. log path수정 및 db처리루틴이 추가하여 주십시요.	
	noti_write("$g4[path]/data/log/noti_success.log", $noti);
	return true;
}

function noti_failure($noti)
{
	global $g4;
	//결제에 관한 log남기게 됩니다. log path수정 및 db처리루틴이 추가하여 주십시요.	
	noti_write("$g4[path]/data/log/noti_failure.log", $noti);
	return true;
}

function noti_progress($noti)
{
	global $g4;
	//결제에 관한 log남기게 됩니다. log path수정 및 db처리루틴이 추가하여 주십시요.	
	noti_write("$g4[path]/data/log/noti_progress.log", $noti);
	return true;
}

function noti_hash_err($noti)
{
	//결제에 관한 log남기게 됩니다. log path수정 및 db처리루틴이 추가하여 주십시요.	
	noti_write("$g4[path]/data/log/noti_hash_err.log", $noti);
	return true;
}

function noti_write($file, $noti) 
{
		$fp = fopen($file, "a+");
		ob_start();
		print_r($noti);
		$msg = ob_get_contents();
		ob_end_clean();
		fwrite($fp, $msg);
		fclose($fp);
}

function get_param($name)
{
	global $_POST, $_GET;
	if (!isset($_POST[$name]) || $_POST[$name] == "") 
	{
		if (!isset($_GET[$name]) || $_GET[$name] == "") 
			return false;
		else
		 return $_GET[$name];
	}
	return $_POST[$name];
}
?>