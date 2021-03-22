<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

$mb_id = $member[mb_id];
if($mb_id == "") { exit; }


$pushList = sql_query(" SELECT * FROM it9_gcm_msg ORDER BY msg_date desc limit $start, $rowCnt");

$resultArray = array();
for($idx = 0 ; $row = sql_fetch_array($pushList ) ; $idx++){

	
	
	$wrNum = sql_fetch(" SELECT wr_num FROM g4_write_{$row[bo_table]} where wr_id='$row[wr_id]' ");
	$repCnt = sql_fetch(" SELECT count(*) cnt FROM g4_write_{$row[bo_table]} where wr_num='$wrNum[wr_num]' AND wr_is_comment != 1");
	$replyCnt = sql_fetch(" SELECT count(*) cnt FROM g4_write_{$row[bo_table]} where wr_num='$wrNum[wr_num]' AND wr_is_comment = 1");
	$row[repCnt] = $repCnt[cnt];
	$row[replyCnt] = $replyCnt[cnt];


	array_push($resultArray, $row);
}
echo json_encode($resultArray);
?>