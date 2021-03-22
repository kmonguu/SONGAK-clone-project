<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

//type은 msg or string
if($type == ""){
	$type = "string";
}


if($type == "string") {
	$result = t($str);
}
else if($type == "msg"){
	$result = msg($str);
}
	

echo $result;
?>