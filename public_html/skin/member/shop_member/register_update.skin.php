<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

//----------------------------------------------------------
// SMS 문자전송 시작
//----------------------------------------------------------

$sms_contents = $default[de_sms_cont1];
$sms_contents = preg_replace("/{이름}/", $mb_name, $sms_contents);
$sms_contents = preg_replace("/{회원아이디}/", $mb_id, $sms_contents);
$sms_contents = preg_replace("/{회사명}/", $default[de_admin_company_name], $sms_contents);

// 핸드폰번호에서 숫자만 취한다
$receive_number = preg_replace("/[^0-9]/", "", $mb_hp);  // 수신자번호 (회원님의 핸드폰번호)
$send_number = preg_replace("/[^0-9]/", "", $default[de_sms_hp]); // 발신자번호

if ($w == "" && $default[de_sms_use1] && $receive_number) 
{ 
	Sms4Message::SEND_SMS($receive_number, $send_number, stripslashes($sms_contents), $mb_id, $mb_name);
}
//----------------------------------------------------------
// SMS 문자전송 끝
//----------------------------------------------------------


//알림톡 전송
APIStoreKKO::SEND_JOIN($mb_id, $mb_hp);

?>
