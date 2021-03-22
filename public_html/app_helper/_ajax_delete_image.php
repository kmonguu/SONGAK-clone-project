<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

if($member[mb_level] < 10){
	exit;
}


$file_path = $g4[path]."/data/".$_REQUEST["filePath"];
$file_name = $_REQUEST["fileName"];


unlink($file_path."/".$file_name);


echo "OK";