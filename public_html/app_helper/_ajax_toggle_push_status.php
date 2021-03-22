<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

if(!$member["mb_id"]) {
	echo "0";exit;
}

$result = sql_fetch("SELECT * FROM helper_push_id WHERE mb_id='{$member["mb_id"]}' ");

$v = $result["is_on"] ? 0 : 1;


sql_query("
		UPDATE helper_push_id SET is_on='{$v}' WHERE mb_id='{$member["mb_id"]}'
");

echo $v;