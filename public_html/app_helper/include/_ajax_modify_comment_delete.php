<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");


$obj = new HpModifyReq();
$result = $obj->delete_modify_comment($_POST["wr_id"], $_POST["pwr_id"]);


echo $result;