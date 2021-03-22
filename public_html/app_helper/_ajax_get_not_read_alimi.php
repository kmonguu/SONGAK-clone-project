<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");


$bdObj = new HpBoard();
$nCnt = $bdObj->get_new_cnt();

echo $nCnt;