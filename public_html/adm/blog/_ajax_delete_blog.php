<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");


$sql = "
	DELETE FROM blog_data WHERE
		no	 = '$no'
";
sql_query($sql);

echo "OK";