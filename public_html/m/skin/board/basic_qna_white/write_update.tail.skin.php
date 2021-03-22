<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if($is_admin && $w == "") {
$sql = " UPDATE g4_write_{$bo_table} SET wr_name='{$_REQUEST['wr_name']}', wr_datetime='{$_REQUEST['wr_datetime']}' WHERE wr_id='{$wr_id}' ";
sql_fetch($sql);
}