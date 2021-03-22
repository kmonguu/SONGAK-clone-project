<?
$sub_menu = "500110";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g4[title] = "$fr_date ~ $to_date 매출현황";
include_once ("$g4[admin_path]/admin.head.php");
?>

<?include_once("./sale1.php")?>
<br/>

<?
function print_line($save)
{
    global $admin_dir;
    static $count = 0;

    if ($count++ > 0)
        echo "<tr><td colspan=10 height=1 bgcolor=#EEEEEE style='font-size:1px; padding:1px;'></td></tr>\n";

    echo "
    <tr class=ht>
        <td align=center><a href='./sale1month.php?fr_date=$save[od_date]01&to_date=$save[od_date]12'>$save[od_date]</a></td>
        <td align=center>".number_format($save[ordercount])."</td>
        <td align=right >".number_format($save[orderamount])."</td>
        <td align=right >".number_format($save[ordercancel] + $save[dc])."</td>
        <td align=right >".number_format($save[receiptbank])."</td>
        <td align=right >".number_format($save[receiptcard])."</td>
        <td align=right >".number_format($save[receiptpoint])."</td>
		<td align=right >".number_format($save[od_coupon])."</td>
        <td align=right >".number_format($save[receiptcancel])."</td>
        <td align=right >".number_format($save[misu])."</td>
    </tr>\n";
}
?>

<?=subtitle($g4[title])?>

<table cellpadding=0 cellspacing=0 width=100% class="list">
<tr class='bgcol1 bold col1 ht center'>
    <td align=center>주문년도</td>
    <td align=center>주문수</td>
    <td align=right>주문합계</td>
    <td align=right>취소+DC</td>
    <td align=right>무통장입금</td>
    <td align=right>카드입금</td>
    <td align=right>포인트입금</td>
	<td align=right>쿠폰사용</td>
    <td align=right>입금취소</td>
    <td align=right>미수금</td>
</tr>
<?
unset($save);
unset($tot);
$sql = " select on_uid,
                SUBSTRING(od_time,1,4) as od_date,
                od_send_cost,
                od_receipt_bank,
                od_receipt_card,
                od_receipt_point,
				od_coupon,
                od_dc_amount,
                (od_receipt_bank + od_receipt_card + od_receipt_point + od_coupon) as receiptamount,
                (od_refund_amount + od_cancel_card) as receiptcancel
           from $g4[yc4_order_table]
          where SUBSTRING(od_time,1,4) between '$fr_date' and '$to_date' 
          order by od_time desc ";
$result = sql_query($sql);
for ($i=0; $row=mysql_fetch_array($result); $i++)
{
    if ($i == 0)
        $save[od_date] = $row[od_date];

    if ($save[od_date] != $row[od_date]) {
        print_line($save);
        unset($save);
        $save[od_date] = $row[od_date];
    }

    // 장바구니 상태별 금액
    $sql1 = " select (SUM(ct_amount * ct_qty)) as orderamount, /* 주문합계 */
                     (SUM(IF(ct_status = '취소' OR ct_status = '반품' OR ct_status = '품절', ct_amount * ct_qty, 0))) as ordercancel /* 주문취소 */
                from $g4[yc4_cart_table]
               where on_uid = '$row[on_uid]' ";
    $row1 = sql_fetch($sql1);

    $row1[orderamount] += $row[od_send_cost];
    $misu = $row1[orderamount] - $row1[ordercancel] - $row[od_dc_amount] - $row[receiptamount] + $row[receiptcancel];

    $save[ordercount]++;
    $save[orderamount]   += $row1[orderamount];
    $save[ordercancel]   += $row1[ordercancel];
    $save[dc]            += $row[od_dc_amount];
    $save[receiptbank]   += $row[od_receipt_bank];
    $save[receiptcard]   += $row[od_receipt_card];
    $save[receiptpoint]  += $row[od_receipt_point];
	$save[od_coupon]	 += $row[od_coupon];
    $save[receiptcancel] += $row[receiptcancel];
    $save[misu]          += $misu;

    $tot[ordercount]++;
    $tot[orderamount]   += $row1[orderamount];
    $tot[ordercancel]   += $row1[ordercancel];
    $tot[dc]            += $row[od_dc_amount];
    $tot[receiptbank]   += $row[od_receipt_bank];
    $tot[receiptcard]   += $row[od_receipt_card];
    $tot[receiptpoint]  += $row[od_receipt_point];
	$tot[od_coupon]		+= $row[od_coupon];
    $tot[receiptamount] += $row[receiptamount];
    $tot[receiptcancel] += $row[receiptcancel];
    $tot[misu]          += $misu;
}

if ($i == 0) {
    echo "<tr><td colspan=10 align=center height=100 bgcolor=#FFFFFF><span class=point>자료가 한건도 없습니다.</span></td></tr>";
} else {
    print_line($save);
}
?>
<tr class='bgcol1 bold col1 ht center'>
    <td align=center>합 계</td>
    <td align=center><?=number_format($tot[ordercount])?></td>
    <td align=right ><?=number_format($tot[orderamount])?></td>
    <td align=right ><?=number_format($tot[ordercancel] + $tot[dc])?></td>
    <td align=right ><?=number_format($tot[receiptbank])?></td>
    <td align=right ><?=number_format($tot[receiptcard])?></td>
    <td align=right ><?=number_format($tot[receiptpoint])?></td>
	<td align=right><?=number_format($tot[od_coupon])?></td>
    <td align=right ><?=number_format($tot[receiptcancel])?></td>
    <td align=right ><?=number_format($tot[misu])?></td>
</tr>
</table>

<?
include_once ("$g4[admin_path]/admin.tail.php");
?>
