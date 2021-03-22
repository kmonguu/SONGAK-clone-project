<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");


$obj = new HpModifyReq();
$result = $obj->insert_modify_comment($_POST["wr_id"], $_POST["wr_name"], $_POST["wr_content"]);


echo $result;