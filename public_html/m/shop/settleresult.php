<?
include_once("./_common.php");

$pageNum = 100;
$subNum = 17;


$html_title = "결제 결과";
include_once("./_head.php");

if (get_session('ss_temp_on_uid') != $on_uid)
    alert("정상적인 방법으로 확인하실 수 있습니다.", $g4[mpath]);


$sql = " select * from $g4[yc4_card_history_table] where on_uid = '$on_uid' ";
$cd = sql_fetch($sql);
if ($cd[cd_id] == "")
    alert("값이 제대로 전달되지 않았습니다.");


// 포인트 결제를 했다면 실제 포인트 결제한 것으로 수정합니다.
$sql = " select od_id, on_uid, od_receipt_point, od_temp_point from $g4[yc4_order_table] where on_uid = '$on_uid' ";
$row = sql_fetch($sql);
if ($row[od_receipt_point] == 0 && $row[od_temp_point] != 0)
{
    sql_query(" update $g4[yc4_order_table] set od_receipt_point = od_temp_point where on_uid = '$on_uid' ");
    insert_point($member[mb_id], (-1) * $row[od_temp_point], "주문번호:$row[od_id] 결제", "@order", $member[mb_id], "$row[od_id],$row[on_uid]");
}

$sql = " select * from $g4[yc4_order_table] where on_uid = '$on_uid' ";
$od = sql_fetch($sql);
    
// 이곳에서 정상 결제되었다는 메일도 같이 발송합니다.
@extract($od);
$tmp_on_uid = $on_uid;

if ($od[od_settle_case] == '가상계좌')
    $od_receipt_bank = $od_temp_bank;

include_once($g4[path]."/shop/ordermail1.inc.php");
include_once($g4[path]."/shop/ordermail2.inc.php");

if ($od[od_settle_case] == '가상계좌')
{
    $msg_settle_amount = '결제하실 금액';
    $settle_amount = $od[od_temp_bank];
    $msg_trade_time = '처리일시';
}
else
{
    $msg_settle_amount = '결제금액';
    $settle_amount = $cd[cd_amount];
    $msg_trade_time = '결제일시';

    //알림톡 입금확인 전송
	APIStoreKKO::SEND_ORDER("deposit", $od["od_id"], $od["od_hp"]);
}
?>


<style>
.settle_result_table tr td {font-size:18px; font-family:Nanum Gothic 굴림; }
.settle_result_table tr td table tr td{font-size:18px; padding:5px; font-family:Nanum Gothic 굴림;} 

.cartBtn {background:#2d7dab; color:#ffffff; padding:8px 12px;line-height:23px; border:1px solid #346a89; font-size:22px; font-weight:bold;}
.cartBtn:hover {background:#2d7dab; color:#ffffff; padding:8px 12px;line-height:23px; border:1px solid #346a89; font-size:22px; font-weight:bold;}
.shop_btns a:hover {text-decoration:none;}
</style>



<div style="width:95%; font-size:25px; font-family:Nanum Gothic 굴림; margin:20px auto -20px auto;">
▶ 주문 및 결제완료
</div>


<table class="settle_result_table" width="95%" align=center cellpadding=0 cellspacing=0>
<tr><td align=center height=50><!-- 결제를 정상적으로 처리하였습니다. --></td></tr>
<tr><td height=2 bgcolor=gray ></td></tr>
<tr><td bgcolor=#efefef height=48 align=center><?=$od['od_settle_case']?> 결제 내역</td></tr>
<tr>
    <td style='padding-left:10px'>
        <table cellpadding=5>
        <tr><td> · 주문번호</td><td>: <?=$cd[od_id]?></td></tr>
        <? if ($od[od_settle_case] == '신용카드') { ?><tr><td width=100> · 승인번호</td><td><font color="#7f3ca2">: <b><?=$cd[cd_app_no]?></b></font></td></tr><? } ?>
        <tr><td> · <?=$msg_settle_amount?></td><td>: <span class=amount><?=display_amount($settle_amount)?></span></td></tr>
        <? if ($od[od_settle_case] == '가상계좌') { ?><tr><td width=100> · 계좌번호</td><td><font color="#7f3ca2">: <b><?=$od[od_bank_account]?></b></font></td></tr><? } ?>
        <tr><td> · <?=$msg_trade_time?></td><td>: <?=$cd[cd_trade_ymd]?> <?=$cd[cd_trade_hms]?></td></tr>
        </table>
    </td></tr>
<tr><td height=2 bgcolor=gray></td></tr>
</table><br><br>


<p align=center class="shop_btns" style="margin-bottom:10px; margin-top:21px;">
   	 <a href='<?="$g4[shop_mpath]/orderinquiryview.php?od_id=$od[od_id]&on_uid=$od[on_uid]";?>'><span class='cartBtn'>&nbsp;&nbsp;&nbsp;&nbsp;확인&nbsp;&nbsp;&nbsp;&nbsp;</span></a>
</p>

<br/>
<br/>

<?
include_once("./_tail.php");
?>