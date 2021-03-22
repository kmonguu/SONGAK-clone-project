<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");


sql_fetch("delete FROM it9_gcmid where gcm_id='$gcmId' ");
?>