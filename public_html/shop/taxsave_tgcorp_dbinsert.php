<?
include_once("./_common.php");
include_once("$g4[path]/lib/etc.lib.php");

/*
[ReplyCode] => 00003000
[MxIssueDate] => 20080704135518
[MSTR] => 
[MSTR2] => 
[Smode] => 0001
[Amount] => 1000
[MxIssueNO] => 0807040002
[TxNO] => 106708
[MxHASH] => 7063035a3dca1c8eea4a0bdc8c838d2f
[ReplyMessage] => 0000
*/

$od_id = $_POST['MxIssueNO'];
$on_uid = $_POST['MSTR'];

// 티지코프용 현금영수증 필드생성    
$sql = " ALTER TABLE `$g4[yc4_order_table]` ADD `od_cash_tgcorp_mxissueno` VARCHAR( 255 ) NOT NULL ";
sql_query($sql, false);

// 현금영수증 사용, 미사용 구분
$sql = " ALTER TABLE `$g4[yc4_order_table]` ADD `od_cash` TINYINT NOT NULL ";
sql_query($sql, false);

$sql = " update $g4[yc4_order_table] set od_cash_tgcorp_mxissueno = '$od_id', od_cash = '1' where od_id = '$od_id' and on_uid = '$on_uid' ";
$result = sql_query($sql);

if ($result) 
    $returnMsg = "ACK=200OKOK";
else
    $returnMsg = "ACK=400FAIL";

echo $returnMsg;
?>
