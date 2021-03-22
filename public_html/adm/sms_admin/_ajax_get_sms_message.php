<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");
auth_check($auth[$sub_menu], "r");

$obj = new Sms4Message();

$msg = $obj->get($no);

echo $msg["msg_sms_content"]."|".$msg["msg_send_number"]."|".$msg["no"];