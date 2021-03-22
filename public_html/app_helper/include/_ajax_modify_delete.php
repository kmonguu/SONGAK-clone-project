<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

if(!$_POST["wr_id"]) {
    echo "값이 넘어오지 않았습니다. 다시 시도해주세요!";
    exit;
}

$obj = new HpModifyReq();
$result = $obj->delete_modify_req($_POST["wr_id"]);


echo $result;