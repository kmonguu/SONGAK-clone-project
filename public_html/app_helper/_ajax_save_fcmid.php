<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");


if($_REQUEST["device_serial"] == "") exit; //Device Serial이 없는 ID는 푸시 사용할 수 없음


//기기 플랫폼
$flatform = $_REQUEST["device_flatform"];
if($flatform == "")
{
	if(strlen($_REQUEST["device_serial"]) > 30)  {
		$flatform = "IOS";
	}
	else {
		$flatform = "ANDROID";
	}
}



if($member["mb_id"] == "") exit;

set_session("fcmid_get_hour", date("YmdH")); //실행시간세션 갱신
set_session("fcm_id", $_REQUEST["fcm_id"]); //FCM_ID저장
set_session("device_serial", $_REQUEST["device_serial"]); //기기 UUID

$row = sql_fetch("SELECT * FROM helper_push_id WHERE device_serial='{$_REQUEST[device_serial]}' ");

if(!$row["fcm_id"]){
	sql_query("INSERT INTO helper_push_id SET mb_id='{$member["mb_id"]}', fcm_id='{$_REQUEST[fcm_id]}', device_serial='{$_REQUEST[device_serial]}', device_flatform='{$flatform}', reg_dt=now() ", true);
}
else {
	sql_query("UPDATE helper_push_id SET mb_id='{$member["mb_id"]}', fcm_id='{$_REQUEST[fcm_id]}', apns_badge_cnt=0 WHERE device_serial='{$_REQUEST[device_serial]}' ", true);
}


//IT9 테이블에 등록/타 사이트 중복제거 절차
$pushObj = new HpPush();
$pushObj->send_itnine_pushids($_REQUEST["fcm_id"], $flatform);
