<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");


$sql = "
	UPDATE blog_data SET
		disp_order = '$disp_order'
	WHERE
		no	 = '$no'
";
sql_query($sql);

echo "OK";