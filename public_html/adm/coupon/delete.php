<?
$sub_menu = "200300";
include_once("./_common.php");



$sql = " delete from yc4_coupon where cpn_id = '{$_REQUEST['cpn_id']}' ";
sql_query($sql);



$qstr .= "&sch_site=$sch_site";
goto_url("./list.php?$qstr");
?>
