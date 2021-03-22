<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

if(!$member["mb_id"]) {
	echo "0";exit;
}

$result = sql_fetch("SELECT * FROM helper_push_id WHERE mb_id='{$member["mb_id"]}' ");

echo $result["is_on"];