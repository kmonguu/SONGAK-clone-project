<?
$g4_path = ".."; // common.php 의 상대 경로
$no_common_read = true;
include_once("./_common.php");

include_once("{$g4['path']}/common.php");
$g4["mpath"]=$g4['path']."/app_helper";

//해당 사이트 식별값으로 쓰일 sitekey
$sitekey = md5($_SERVER["DOCUMENT_ROOT"].$_SERVER["SERVER_ADDR"]);
?>