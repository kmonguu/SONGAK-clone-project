<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

$ss_orderform = get_session("ss_orderform");
echo $ss_orderform;
exit;
