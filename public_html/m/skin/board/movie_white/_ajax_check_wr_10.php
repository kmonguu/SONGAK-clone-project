<?
include_once("./_common.php");

$result = sql_fetch(" SELECT count(*) cnt FROM g4_write_{$bo_table} WHERE wr_10='1' ");

echo $result[cnt];