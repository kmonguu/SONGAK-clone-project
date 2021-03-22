<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

if($member["mb_id"] == "") exit;
if($_REQUEST["fcm_id"] == "") exit;

set_session("fcmid_get_hour", date("YmdH")); //실행시간세션 갱신
set_session("fcm_id", $_REQUEST["fcm_id"]); //GCM_ID저장
set_session("device_serial", $_REQUEST["device_serial"]); //기기 UUID

$row = sql_fetch("SELECT * FROM push_fcmid WHERE mb_id='{$member["mb_id"]}' AND device_serial='{$_REQUEST[device_serial]}' ");

if(!$row["fcm_id"]){
	sql_query("INSERT INTO push_fcmid SET mb_id='{$member["mb_id"]}', fcm_id='{$_REQUEST[fcm_id]}', device_serial='{$_REQUEST[device_serial]}', reg_dt=now() ", true);
}
else {
	sql_query("UPDATE push_fcmid SET fcm_id='{$_REQUEST[fcm_id]}' WHERE mb_id='{$member["mb_id"]}' AND device_serial='{$_REQUEST[device_serial]}' ", true);
}
