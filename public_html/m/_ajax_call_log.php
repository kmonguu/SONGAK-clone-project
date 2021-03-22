<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");


sql_query("INSERT INTO g4_call_log SET call_date = now()");
?>
