<?
include_once("./_common.php");

if (!($ReplyCode == "00003000" || $ReplyCode == "00004000")) 
{
    alert("요청하신 결제가 실패 하였습니다.", $g4[path]);
    exit;
}

$sql = " select on_uid from $g4[yc4_order_table] where od_id = '$MxIssueNO' ";
$row = sql_fetch($sql);
$on_uid = $row[on_uid];

//gotourl("./?doc=$cart_dir/ordercardresult.php&on_uid=$on_uid");
goto_url("./settleresult.php?on_uid=$on_uid");
?>
