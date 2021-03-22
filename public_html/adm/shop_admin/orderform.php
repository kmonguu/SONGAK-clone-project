<?
$sub_menu = "400400";
include_once("./_common.php");

$sql = " ALTER TABLE `$g4[yc4_order_table]` ADD `od_cash` TINYINT NOT NULL ";
sql_query($sql, false);

// 메세지
$html_title = "주문 내역 수정";
$alt_msg1   = "주문번호 오류입니다.";
$mb_guest   = "비회원";
$hours = 6; // 설정 시간이 지난 주문서 없는 장바구니 자료 삭제

$cart_title1 = "쇼핑";
$cart_title2 = "완료";
$cart_title3 = "주문번호";
$cart_title4 = "배송완료";

auth_check($auth[$sub_menu], "w");

$g4[title] = $html_title;
include_once("$g4[admin_path]/admin.head.php");

//------------------------------------------------------------------------------
// 설정 시간이 지난 주문서 없는 장바구니 자료 삭제
//------------------------------------------------------------------------------
if (!isset($cart_not_delete)) {
    if (!$hours) $hours = 6;
    $beforehours = date("Y-m-d H:i:s", ( $g4[server_time] - (60 * 60 * $hours) ) );
    $sql = " delete from $g4[yc4_cart_table] where ct_status = '$cart_title1' and ct_time <= '$beforehours' and length(on_uid)=32 ";
    sql_query($sql);
}
//------------------------------------------------------------------------------


//------------------------------------------------------------------------------
// 주문완료 포인트
//      설정일이 지난 포인트 부여되지 않은 배송완료된 장바구니 자료에 포인트 부여
//      설정일이 0 이면 주문서 완료 설정 시점에서 포인트를 바로 부여합니다.
//------------------------------------------------------------------------------
if (!isset($order_not_point)) {
    $beforedays = date("Y-m-d H:i:s", ( time() - (60 * 60 * 24 * (int)$default[de_point_days]) ) );
    $sql = " select * from $g4[yc4_cart_table] 
               where ct_status = '$cart_title2' 
                 and ct_point_use = '0' 
                 and ct_time <= '$beforedays' ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++) 
    {
        // 회원 ID 를 얻는다.
        $tmp_row = sql_fetch("select od_id, mb_id from $g4[yc4_order_table] where on_uid = '$row[on_uid]' ");

        // 회원이면서 포인트가 0보다 크다면
        if ($tmp_row[mb_id] && $row[ct_point] > 0)
        {
            $po_point = $row[ct_point] * $row[ct_qty];
            $po_content = "$cart_title3 $tmp_row[od_id] ($row[ct_id]) $cart_title4";
            insert_point($tmp_row[mb_id], $po_point, $po_content, "@delivery", $tmp_row[mb_id], "$tmp_row[od_id],$row[on_uid],$row[ct_id]");
        }

        sql_query("update $g4[yc4_cart_table] set ct_point_use = '1' where ct_id = '$row[ct_id]' ");
    }
}
//------------------------------------------------------------------------------


//------------------------------------------------------------------------------
// 주문서 정보
//------------------------------------------------------------------------------
$sql = " select * from $g4[yc4_order_table] where od_id = '$od_id' ";
$od = sql_fetch($sql);
if (!$od[od_id]) {
    alert($alt_msg1);
}

if ($od[mb_id] == "") {
    $od[mb_id] = $mb_guest;
}
//------------------------------------------------------------------------------


//------------------------------------------------------------------------------
// 배송중인 상태로 n일 지난 주문건 자동 완료 처리 (배송시작일자 이후, 배송시작일 없으면 장바구니 등록일자 기준) shop.config.php
//------------------------------------------------------------------------------
if(!$g4["cf_auto_delivery_complete_day"]) $g4["cf_auto_delivery_complete_day"]=7;
$beforedays = date("Y-m-d H:i:s", ( time() - (60 * 60 * 24 * $g4["cf_auto_delivery_complete_day"]) ) );
if($od["od_invoice_time"]) {
	if(date("Y-m-d H:i:s", strtotime($od["od_invoice_time"])) <= $beforedays) {
		$sql = "UPDATE $g4[yc4_cart_table] SET ct_status ='완료' WHERE on_uid='{$od["on_uid"]}' AND ct_status = '배송' ";
		sql_query($sql);
	}
} else {
	$sql = "UPDATE $g4[yc4_cart_table] SET ct_status ='완료' WHERE on_uid='{$od["on_uid"]}' ct_status = '배송' and ct_status_time <= '$beforedays' ";
	sql_query($sql);
}
//------------------------------------------------------------------------------


//알림톡 셋팅 정보
$obj = new APIStoreKKOConfig();
$kkoConf = $obj->get($ss_com_id);



$qstr = "sort1=$sort1&sort2=$sort2&sel_field=$sel_field&search=$search&page=$page";

// PG사를 KCP 사용하면서 테스트 상점아이디라면
if ($default[de_card_pg] == 'kcp' && $default[de_kcp_mid] == 'T0007')
    $g4[yc4_cardpg][kcp] = "http://admin.dev.kcp.co.kr"; // 로그인 아이디/비번 : escrow/escrow
else if ($default[de_card_pg] == 'dacom' && $default[de_dacom_mid] == 'tlinkret')
    $g4[yc4_cardpg][dacom] = "http://pgweb.dacom.net:7085/index.jsp"; // 로그인 아이디/비번 : tlinkret/tlinkret


$sql = " select a.ct_id,
                a.it_id,
                a.ct_qty,
                a.ct_amount,
                a.ct_point,
                a.ct_status,
                a.ct_time,
                a.ct_point_use,
                a.ct_stock_use,
                a.it_opt1,
                a.it_opt2,
                a.it_opt3,
                a.it_opt4,
                a.it_opt5,
                a.it_opt6,
                a.it_option1,
				a.it_option2,
                a.it_option3,
                a.it_option_amount,
                b.it_name
           from $g4[yc4_cart_table] a, $g4[yc4_item_table] b
          where a.on_uid = '$od[on_uid]'
            and a.it_id  = b.it_id
          order by a.ct_id ";
$result = sql_query($sql);

?>

<p>
<table width=100% cellpadding=0 cellspacing=0>
	<tr>
        <td><?=subtitle("주문상품")?></td>
        <td align=right>
        <? if ($default[de_hope_date_use]) { ?>
            희망배송일은
            <b><?=$od[od_hope_date]?> (<?=get_yoil($od[od_hope_date])?>)</b> 입니다.
        <? } ?>
        </td>
    </tr>
</table>


<form name=frmorderform method=post action='' style="margin:0px;">
<input type=hidden name=ct_status value=''>
<input type=hidden name=on_uid    value='<? echo $od[on_uid] ?>'>
<input type=hidden name=od_id     value='<? echo $od_id ?>'>
<input type=hidden name=mb_id     value='<? echo $od[mb_id] ?>'>
<input type=hidden name=od_email  value='<? echo $od[od_email] ?>'>
<input type=hidden name=sort1 value="<? echo $sort1 ?>">
<input type=hidden name=sort2 value="<? echo $sort2 ?>">
<input type=hidden name=sel_field  value="<? echo $sel_field ?>">
<input type=hidden name=search     value="<? echo $search ?>">
<input type=hidden name=page       value="<? echo $page ?>">
<table width=100% cellpadding=0 cellspacing=0 border=0 class="list02">


<tr align=center class=ht>
    <td width="50"><input type=checkbox onclick='select_all();'>전체</td>
    <td>상품명</td>
    <td>상태</td>
    <td>수량</td>
    <td>판매가</td>
    <td>소계</td>
    <td>포인트</td>
    <td>포인트반영</td>
    <td>재고반영</td>
</tr>

<?
$image_rate = 2.5;
$optObj = new Yc4ItemOption();
for ($i=0; $row=sql_fetch_array($result); $i++) 
{
    $it_name = "<a href='./itemform.php?w=u&it_id=$row[it_id]'>".stripslashes($row[it_name])."</a>";
	if($row["it_option1"]) {
		$it_name .= "<br/>".$optObj->print_option_cart($row["it_id"], $row["it_option1"], $row["it_option2"], $row["it_option3"], $row["it_option_amount"])."<br/>";
	}
    $it_name .= print_item_options($row[it_id], $row[it_opt1], $row[it_opt2], $row[it_opt3], $row[it_opt4], $row[it_opt5], $row[it_opt6]);

    $ct_amount[소계] = $row[ct_amount] * $row[ct_qty];
    $ct_point[소계] = $row[ct_point] * $row[ct_qty];
    if ($row[ct_status]=='주문' || $row[ct_status]=='준비' || $row[ct_status]=='배송' || $row[ct_status]=='완료')
        $t_ct_amount[정상] += $row[ct_amount] * $row[ct_qty];
    else if ($row[ct_status]=='취소' || $row[ct_status]=='반품' || $row[ct_status]=='품절')
        $t_ct_amount[취소] += $row[ct_amount] * $row[ct_qty];
    
    $image = get_it_image("$row[it_id]_s", (int)($default[de_simg_width] / $image_rate), (int)($default[de_simg_height] / $image_rate), $row[it_id]);

    $list = $i%2;
    echo "
    <tr class='list$list'>
        <td align=center title='$row[ct_id]'><input type=hidden name=ct_id[$i] value='$row[ct_id]'><input type=checkbox id='ct_chk_{$i}' name='ct_chk[{$i}]' value='1'></td>
        <td style='padding-top:5px; padding-bottom:5px;'><table width='100%'><tr><td width=40 align=center>$image</td><td>$it_name</td></tr></table></td>
        <td align=center>$row[ct_status]</td>
        <td align=center>$row[ct_qty]</td>
        <td align=right>".number_format($row[ct_amount])."</td>
        <td align=right>".number_format($ct_amount[소계])."</td>
        <td align=right>".number_format($ct_point[소계])."</td>
        <td align=center>".get_yn($row[ct_point_use])."</td>
        <td align=center>".get_yn($row[ct_stock_use])."</td>";
    echo "</tr><tr><td colspan=9 height=1 bgcolor=F5F5F5></td></tr>";

    $t_ct_amount[합계] += $ct_amount[소계];
    $t_ct_point[합계] += $ct_point[소계];
}
?>

<tr bgcolor=#ffffff class=ht>
    <td colspan=3>&nbsp;&nbsp;&nbsp;
        <a href="javascript:form_submit('주문')">주문</a> |
        <a href="javascript:form_submit('준비')">상품준비중</a> |
        <a href="javascript:form_submit('배송')">배송중</a> |
        <a href="javascript:form_submit('완료')">완료</a> |
        <a href="javascript:form_submit('취소')">취소</a> |
        <a href="javascript:form_submit('반품')">반품</a> |
        <a href="javascript:form_submit('품절')">품절</a>
        <?=help("한 주문에 여러가지의 상품주문이 있을 수 있습니다.\n\n상품을 체크하여 해당되는 상태로 설정할 수 있습니다.");?>
    </td>
    <td colspan=3>주문일시 : <?=substr($od[od_time],0,16)?> (<?=get_yoil($od[od_time]);?>)</td>
    <td colspan=3 align=right>                  
        <input type=hidden name="chk_cnt" value="<? echo $i ?>">
        <b>주문합계 : <? echo number_format($t_ct_amount[합계]); ?>원</B></td>
	    <? //echo number_format($t_ct_point[합계]); ?>
</tr>
</form>
</table>
<br>
<br>

<?if($od["od_is_offline"]) {?>
	<?=subtitle("주문결제 <span style='color:#CC0000; font-weight:bold;'>(오프라인)</span>")?>
<?} else {?>
	<?=subtitle("주문결제")?>
<?}?>


<?
// 주문금액 = 상품구입금액 + 배송비
$amount[정상] = $t_ct_amount[정상] + $od[od_send_cost];

// 입금액 = 무통장 + 신용카드 + 포인트
$amount[입금] = $od[od_receipt_bank] + $od[od_receipt_card] + $od[od_receipt_point] + $od[od_coupon];

// 미수금 = (주문금액 - DC + 환불액) - (입금액 - 신용카드승인취소)
$amount[미수] = ($amount[정상] - $od[od_dc_amount] + $od[od_refund_amount]) - ($amount[입금] - $od[od_cancel_card]);

// 결제방법
$s_receipt_way = $od[od_settle_case];

if ($od[od_receipt_point] > 0)
    $s_receipt_way .= "+포인트";
if ($od[od_coupon] > 0)
	$s_receipt_way .= "+쿠폰";    
?>


<table width=100% cellpadding=0 cellspacing=0 border=0 class="list02" style="margin:0 0 20px 0;">
<!-- on_uid : <? echo $od[on_uid] ?> -->

<tr align=center class=ht>
	<td>주문번호</td>
	<td>결제방법</td>
	<td>주문총액</td>
    <td>포인트결제액</td>
    <td>쿠폰결제액</td>
	<td>결제액(포인트,쿠폰포함)</td>
	<td>DC</td>
	<td>환불액</td>
	<td>주문취소</td>
</tr>
<tr align=center class=ht>
    <td><? echo $od[od_id] ?></td>
	<td><? echo $s_receipt_way ?></td>
	<td><? echo display_amount($amount[정상]) ?></td>
    <td><? echo display_point($od[od_receipt_point]); ?></td>
    <td><? echo number_format($od[od_coupon]); ?>원</td>
	<td><? echo number_format($amount[입금]); ?>원</td>
    <td><? echo display_amount($od[od_dc_amount]); ?></td>
    <td><? echo display_amount($od[od_refund_amount]); ?></td>
	<td><? echo number_format($t_ct_amount[취소]) ?>원</td>
</tr>

<tr><td colspan=9 align=right class=ht style="text-align:right;"><b><font color=#FF6600><b>미수금 : <? echo display_amount($amount[미수]) ?></b></font></b></td></tr>
</table>


<p>
<form name=frmorderreceiptform method=post action="./orderreceiptupdate.php" autocomplete=off style="margin:0px;">
<input type=hidden name=od_id     value="<?=$od_id?>">
<input type=hidden name=sort1     value="<?=$sort1?>">
<input type=hidden name=sort2     value="<?=$sort2?>">
<input type=hidden name=sel_field value="<?=$sel_field?>">
<input type=hidden name=search    value="<?=$search?>">
<input type=hidden name=page      value="<?=$page?>">
<input type=hidden name=od_name   value="<?=$od[od_name]?>">
<input type=hidden name=od_hp     value="<?=$od[od_hp]?>">
<table cellpadding=0 cellspacing=0 width=1000px  >
<tr>
    <td width=49% valign=top>

        <?=subtitle("결제상세정보")?>
       <table width=100% cellpadding=0 cellspacing=0 border=0 class="list04" style="width:480px;">
        <colgroup width=110>
        <colgroup width='' bgcolor=#ffffff>

        <? if ($od[od_settle_case] != '신용카드') { ?>
            <? 
            if ($od[od_settle_case] == '무통장' || $od[od_settle_case] == '가상계좌') 
            { 
                echo "<tr class=ht>";
                echo "<td class='head'>계좌번호</td>";
                echo "<td>".$od[od_bank_account]."</td>";
                echo "</tr>";
            }
            ?>
            <tr class=ht>
                <td class='head'><?=$od[od_settle_case]?> 입금액</td>
                <td>
                <?
                    if ($od[od_receipt_bank] > 0) {
                        echo "" . display_amount($od[od_receipt_bank]);
                    } else {
                        echo "0원";
                    }
                    ?>
                </td>
            </tr>
            <tr class=ht>
                <td class='head'>입금자</td>
                <td><? echo $od[od_deposit_name] ?></td>
            </tr>
            <tr class=ht>
                <td class='head'>입금확인일시</td>
                <td>
                <?
                    if ($od[od_bank_time] == "0000-00-00 00:00:00") {
                        echo "입금 확인일시를 체크해 주세요.";
                    } else {
                        echo " " . substr($od[od_bank_time], 0, 16);
                    }
                  ?>
                </td>
            </tr>
         <? } ?>


        <? if ($od[od_settle_case] == '신용카드') { ?>
        <tr class=ht>
            <td bgcolor=#F8FFED class='head'>신용카드 입금액</td>
            <td>
            <?
                if ($od[od_card_time] == "0000-00-00 00:00:00")
                    echo "0원";
                else
                    echo display_amount($od[od_receipt_card]);
            ?>
            </td>
        </tr>
		<tr class=ht>
			<td bgcolor=#F8FFED class='head'>카드 승인일시</td>
			<td>
            <?
                if ($od[od_card_time] == "0000-00-00 00:00:00")
                    echo "신용카드 결제 일시 정보가 없습니다.";
                else
                {
                    echo "" . substr($od[od_card_time], 0, 20);
                }
            ?>
			</td>
		</tr>
        <tr class=ht>
            <td bgcolor=#F8FFED class='head'>카드 승인취소</td>
            <td><? echo display_amount($od[od_cancel_card]); ?></td>
        </tr>
        <? } ?>

        <tr class=ht>
            <td class='head'>포인트</td>
            <td><? echo display_point($od[od_receipt_point]); ?></td>
        </tr>


        <tr class=ht>
            <td class='head'>쿠폰</td>
            <td><? echo number_format($od[od_coupon]); ?> 원</td>
        </tr>


        <tr class=ht>
            <td class='head'>DC</td>
            <td><? echo display_amount($od[od_dc_amount]); ?></td>
        </tr>
        <tr class=ht>
            <td class='head'>환불액</td>
            <td><? echo display_amount($od[od_refund_amount]); ?></td>
        </tr>

       
        <?
        if ($amount[미수] == 0) {
            if ($od[od_receipt_bank]) {
                if ($default[de_card_pg] == 'kcp') {
                    echo "<tr class=ht><td class='head'>현금영수증</td><td>";
                    if ($od["od_cash"]) 
                        echo "<a href=\"javascript:;\" onclick=\"window.open('https://admin.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp?cash_no=$od[od_cash_no]', 'taxsave_receipt', 'width=360,height=647,scrollbars=0,menus=0');\">현금영수증 확인하기</a>";
                    else
                        echo "<a href=\"javascript:;\" onclick=\"window.open('$g4[shop_path]/taxsave_kcp.php?od_id=$od_id&on_uid=$od[on_uid]', 'taxsave', 'width=550,height=400,scrollbars=1,menus=0');\">현금영수증을 발급하시려면 클릭하십시오.</a>";
                    echo "</td></tr>";
                }
                else if ($default[de_card_pg] == 'tgcorp') {
                    echo "<tr class=ht><td class='head'>현금영수증</td><td>";
                    if ($od["od_cash"]) {
                        echo "<script>function tgcorpBill(mxid, mxissueno, smode, billtype) { var url = \"https://npg.tgcorp.com/dlp/tgcorpbill.jsp?MxID=\"+mxid+\"&MxIssueNO=\"+mxissueno+\"&Smode=\"+smode+\"&BillType=\"+billtype; var win = window.open(url, \"tgcorp\", \"width=400,height=640,menubar=no,resizable=yes\"); if(win.focus) win.focus(); }</script>";
                        echo "<a href=\"javascript:;\" onclick=\"tgcorpBill('{$default[de_tgcorp_mxid]}', '{$od[od_cash_tgcorp_mxissueno]}', '0001', '00');\">현금영수증 확인하기</a>";
                    } 
                    else {
                        // "&a=a" 는 뒤의 ? 를 무력화하기 위해 넣었습니다
                        echo "<a href=\"javascript:;\" onclick=\"window.open('$g4[shop_path]/taxsave_tgcorp.php?od_id=$od_id&on_uid=$od[on_uid]&redirpath=".urlencode($_SERVER[REQUEST_URI]."&a=a")."', 'TG_PAY', 'width=390,height=360,scrollbars=0,menus=0');\">현금영수증을 발급하시려면 클릭하십시오.</a>";
                    }
                    echo "</td></tr>";
                }
                else if ($default[de_card_pg] == 'allthegate') {
                    echo "<tr class=ht><td class='head'>현금영수증</td><td>";
                    if ($od["od_cash"]) {
                        echo "<a href=\"javascript:;\" onclick=\"window.open('$g4[shop_path]/taxsave_allthegate_receipt.php?od_id=$od_id&on_uid=$od[on_uid]', 'allthegate_receipt', 'width=440,height=550,scrollbars=0,menus=0');\">현금영수증 확인하기</a>";
                    } 
                    else {
                        echo "<a href=\"javascript:;\" onclick=\"window.open('$g4[shop_path]/taxsave_allthegate.php?od_id=$od_id&on_uid=$od[on_uid]', 'allthegate', 'width=440,height=550,scrollbars=0,menus=0');\">현금영수증을 발급하시려면 클릭하십시오.</a>";
                    }
                    echo "</td></tr>";
                }
                else if ($default[de_card_pg] == 'inicis') {
                    echo "<tr class=ht><td class='head'>현금영수증</td><td>";
                    if ($od["od_cash"]) {
                        echo "<script>function showreceipt(tid) { var showreceiptUrl = 'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/Cash_mCmReceipt.jsp?noTid=' + tid + '&clpaymethod=22'; window.open(showreceiptUrl,'showreceipt','width=380,height=540, scrollbars=no,resizable=no'); } </script>";
                        echo "<a href=\"javascript:;\" onclick=\"showreceipt('$od[od_cash_inicis_tid]');\">현금영수증 확인하기</a>";
                    } 
                    else {
                        echo "<a href=\"javascript:;\" onclick=\"window.open('$g4[shop_path]/taxsave_inicis.php?od_id=$od_id&on_uid=$od[on_uid]', 'inicis', 'width=632,height=655,scrollbars=0,menus=0');\">현금영수증을 발급하시려면 클릭하십시오.</a>";
                    }
                    echo "</td></tr>";
                }
                else if ($default[de_card_pg] == 'dacom' || $default[de_card_pg] == 'dacom_xpay') {
                    echo "<tr class=ht><td class='head'>현금영수증</td><td>";
                    if ($od["od_cash"]) {
                        if (preg_match("/^tsi_/", $default[de_dacom_mid])) {
                            echo "<script>function showreceipt(tid) { var showreceiptUrl = 'http://pg.dacom.net:7080/transfer/cashreceipt.jsp?orderid=$od[od_id]&mid=$default[de_dacom_mid]&servicetype=SC0100'; window.open(showreceiptUrl,'showreceipt','menubar=0,toolbar=0,scrollbars=no,width=380,height=600,resize=1,left=252,top=116'); } </script>";
                        } else {
                            echo "<script>function showreceipt(tid) { var showreceiptUrl = 'http://pg.dacom.net/transfer/cashreceipt.jsp?orderid=$od[od_id]&mid=$default[de_dacom_mid]&servicetype=SC0100'; window.open(showreceiptUrl,'showreceipt','menubar=0,toolbar=0,scrollbars=no,width=380,height=600,resize=1,left=252,top=116'); } </script>";
                        }
                        echo "<a href=\"javascript:;\" onclick=\"showreceipt('$od[od_cash_receiptnumber]');\">현금영수증 확인하기</a>"; // od_cash_receiptnumber 는 실제 사용하지 않으므로 의미 없음
                    } 
                    else {
                        echo "<a href=\"javascript:;\" onclick=\"window.open('$g4[shop_path]/taxsave_dacom.php?od_id=$od_id&on_uid=$od[on_uid]', 'dacom', 'width=632,height=655,scrollbars=0,menus=0');\">현금영수증을 발급하시려면 클릭하십시오.</a>";
                    }
                    echo "</td></tr>";
                }
            }
        }
        ?>
        </table>
    </td>
    <td width=1%> </td>
    <td width=47% valign=top align=center>

        <?=subtitle("결제상세정보 수정")?>
       <table width=100% cellpadding=0 cellspacing=0 border=0 class="list04" style="width:500px;">
        <colgroup width=110>
        <colgroup width='' bgcolor=#ffffff>
        <? if ($od[od_settle_case] != '신용카드') { ?>
            <?
            // 주문서
            $sql = " select * from $g4[yc4_order_table] where od_id = '$od_id' ";
            $result = sql_query($sql);
            $od = sql_fetch_array($result);

            if ($od['od_settle_case'] == '무통장')
            {
                // 은행계좌를 배열로 만든후
                $str = explode("\n", $default[de_bank_account]);
                $bank_account = "\n<select name=od_bank_account>\n";
                $bank_account .= "<option value=''>------------ 선택하십시오 ------------\n";
                for ($i=0; $i<count($str); $i++) {
                    $str[$i] = str_replace("\r", "", $str[$i]);
                    $bank_account .= "<option value='$str[$i]'>$str[$i] \n";
                }
                $bank_account .= "</select> ";
            }
            else if ($od['od_settle_case'] == '가상계좌')
                $bank_account = $od[od_bank_account] . "<input type='hidden' name='od_bank_account' value='$od[od_bank_account]'>";
            else if ($od['od_settle_case'] == '계좌이체')
                $bank_account = $od['od_settle_case'];
            ?>

            <?
            if ($od[od_settle_case] == '무통장' || $od[od_settle_case] == '가상계좌')
            {
                echo "<tr class=ht>";
                echo "<td class='head'>계좌번호</td>";
                echo "<td>$bank_account</td>";
                echo "</tr>";
            }

            if ($od[od_settle_case] == '무통장')
                echo "<script> document.frmorderreceiptform.od_bank_account.value = '".str_replace("\r", "", $od[od_bank_account])."'; </script>";
            ?>
            <tr class=ht>
                <td class='head'><?=$od[od_settle_case]?> 입금액</td>
                <td>
                    <input type=text class=ed name=od_receipt_bank size=10 
                        value='<? echo $od[od_receipt_bank] ?>'>원
                    <?
                    if ($od['od_settle_case'] == '계좌이체' || $od['od_settle_case'] == '가상계좌')
                    {
                        $pg_url = $g4['yc4_cardpg'][$default['de_card_pg']];
                        echo "&nbsp;<a href='$pg_url' target=_new>결제대행사</a>";
                    }
                    ?>
                </td>
            </tr>
            <tr class=ht>
                <td class='head'>입금자명</td>
                <td>
                    <input type=text class=ed name=od_deposit_name 
                        value='<? echo $od[od_deposit_name] ?>'>
                    <? if ($default[de_sms_use3]) { ?>
                        <input type=checkbox name=od_sms_ipgum_check> SMS 문자전송
                    <? } ?>
                    <?if($kkoConf["api_id"]) {?>
                        <input type=checkbox name=od_kko_ipgum_check> 알림톡전송
                    <?}?>
                </td>
            </tr>
            <tr class=ht>
                <td class='head'>입금 확인일시</td>
                <td>
                    <input type=text class=ed name=od_bank_time maxlength=19 value='<? echo is_null_time($od[od_bank_time]) ? "" : $od[od_bank_time]; ?>'>
                    <input type=checkbox name=od_bank_chk
                        value="<? echo date("Y-m-d H:i:s", $g4['server_time']); ?>"
                        onclick="if (this.checked == true) this.form.od_bank_time.value=this.form.od_bank_chk.value; else this.form.od_bank_time.value = this.form.od_bank_time.defaultValue;">현재 시간
                </td>
            </tr>
        <? } ?>
        
        <? if ($od[od_settle_case] == '신용카드') { ?>
        <tr class=ht>
            <td bgcolor=#F8FFED class='head'>신용카드 결제액</td>
            <td>
                <input type=text class=ed name=od_receipt_card size=10 
                    value='<? echo $od[od_receipt_card] ?>'>원
                &nbsp;
                <? 
                $card_url = $g4[yc4_cardpg][$default[de_card_pg]];
                ?>
                <a href='<? echo $card_url ?>' target=_new>결제대행사</a>
            </td>
        </tr>
        <tr class=ht>
            <td bgcolor=#F8FFED class='head'>카드 승인일시</td>
            <td>
                <input type=text class=ed name=od_card_time size=19 maxlength=19 value='<? echo is_null_time($od[od_card_time]) ? "" : $od[od_card_time]; ?>'>
                <input type=checkbox name=od_card_chk
                    value="<? echo date("Y-m-d H:i:s", $g4['server_time']); ?>"
                    onclick="if (this.checked == true) this.form.od_card_time.value=this.form.od_card_chk.value; else this.form.od_card_time.value = this.form.od_card_time.defaultValue;">현재 시간
            </td>
        </tr>
        <tr class=ht>
            <td bgcolor=#F8FFED class='head'>카드 승인취소</td>
            <td>
                <input type=text class=ed name=od_cancel_card size=10 value='<? echo $od[od_cancel_card] ?>'>원
            </td>
        </tr>
        <? } ?>

        <tr class=ht>
            <td class='head'>포인트 결제액</td>
            <td>
                <input type=text class=ed name=od_receipt_point size=10 value='<? echo $od[od_receipt_point] ?>'>점
            </td>
        </tr>

        <tr class=ht>
	            <td class='head'>쿠폰 결제액</td>
	            <td>
	                <input type=text class=ed name=od_coupon size=10 value='<? echo $od[od_coupon] ?>'>원
	            </td>
            </tr>
            

        <tr class=ht>
            <td class='head'>DC</td>
            <td>
                <input type=text class=ed name=od_dc_amount size=10 value='<? echo $od[od_dc_amount] ?>'>원
            </td>
        </tr>
        <tr class=ht>
            <td class='head'>환불액</td>
            <td>
                <input type=text class=ed name=od_refund_amount size=10 value='<? echo $od[od_refund_amount] ?>'>원
                <?=help("카드승인취소를 입력한 경우에는 중복하여 입력하면 미수금이 틀려집니다.", 0, -100);?>
            </td>
        </tr>
        

        <tr class=ht>
            <td class='head'>주문자 배송비</td>
            <!-- <td><? echo number_format($od[od_send_cost]) ?>원</td> -->
            <td><input type=text name='od_send_cost' value='<?=$od[od_send_cost]?>' class=ed size=10 style='text-align:right;'>원
                <?=help("주문취소시 배송비는 취소되지 않으므로 이 배송비를 0으로 설정하여 미수금을 맞추십시오.");?></td>
        </tr>


        <?if($od["od_delivery_cnt"] <= 1) {?>

			<tr class=ht>
				<td class='head'>배송회사</td>
				<td>
					<select name=dl_id>
						<option value=''>배송시 선택하세요.
					<?
					$sql = "select * from $g4[yc4_delivery_table] order by dl_order desc, dl_id desc ";
					$result = sql_query($sql);
					for ($i=0; $row=sql_fetch_array($result); $i++)
						echo "<option value='$row[dl_id]'>$row[dl_company]\n";
					mysql_free_result($result);
					?>
					</select>

				   <?
					if ($od[dl_id] > 0) {
						echo "<script language='javascript'> document.frmorderreceiptform.dl_id.value = '$od[dl_id]' </script>";
					}
					?>

				</td>
			</tr>
			<tr class=ht>
				<td class='head'>운송장번호</td>
				<td><input type=text class=ed name=od_invoice 
					value='<? echo $od[od_invoice] ?>'>
					<? if ($default[de_sms_use4]) { ?>
						<input type=checkbox name=od_sms_baesong_check> SMS 문자전송
                    <? } ?>
                    <?if($kkoConf["api_id"]) {?>
                        <input type=checkbox name=od_kko_baesong_check> 알림톡전송
                    <?}?>
				</td>
			</tr>
			<tr class=ht>
				<td class='head'>배송일시</td>
				<td>
					<input type=text class=ed name=od_invoice_time maxlength=19 value='<? echo is_null_time($od[od_invoice_time]) ? "" : $od[od_invoice_time]; ?>'>
					<input type=checkbox name=od_invoice_chk
						value="<? echo date("Y-m-d H:i:s", $g4['server_time']); ?>"
						onclick="if (this.checked == true) this.form.od_invoice_time.value=this.form.od_invoice_chk.value; else this.form.od_invoice_time.value = this.form.od_invoice_time.defaultValue;">현재 시간
				</td>
			</tr>




		<?} else {?>
			
			<? if ($default[de_sms_use4]) {?>
			<tr>
				<td class="head">문자전송</td>
				<td>
                    <label class="checkbox-inline">
					    <input type=checkbox name=od_sms_baesong_check> 운송장번호 SMS 문자전송
                    </label>
				</td>
			</tr>
			<? } ?>

            <?if($kkoConf["api_id"]) {?>
			<tr>
				<td class="head">알림톡</td>
				<td>
                    <label class="checkbox-inline">
                        <input type=checkbox name=od_kko_baesong_check> 운송장번호 알림톡전송
                    </label>
				</td>
            </tr>
            <?}?>



			<?
				$mdObj = new Yc4MultiDelivery();
				$mdResult = $mdObj->get_list($od["od_id"], 1, "", "", "", "", PHP_INT_MAX, "", "");
				$mdlist = $mdResult["list"];
				$cnt = 0;
				for($idx = 0 ; $idx < count($mdlist); $idx++){
					$md = $mdlist[$idx];
					$cnt++;
			?>
				 <tr class=ht>
					<td colspan=2 bgcolor=#ffffff align=left class='bgcol1 bold col1 ht center'><B>배송지 <?=$cnt?></B></td>
				</tr>
				<tr>
					<td class='head'>배송수량</td>
					<td colspan="1">

                            <table cellpadding=3 style="border-collapse:collapse; width:100%; border:0px;">
                                <colgroup width=''>
                                <colgroup width=''>

                                    <? $multi_delivery_list = Yc4MultiDelivery::get_list_qty($md["md_qty"]) ?>
                                    <?foreach($multi_delivery_list as $mrow) {?>
                                    <tr>
                                        <td style="padding:8px; border:0px;"> 
                                            <?=$mrow["name"]?>
                                        </td>
                                        <td style="padding:8px; border:0px;">
                                        &nbsp;&nbsp;<?=$mrow["qty"] ?>개
                                        </td>
                                    </tr>
                                    <?}?>

                            </table>
                            
					</td>
				</tr>
				<tr class=ht>
					<td class='head'>배송회사</td>
					<td>
						<input type="hidden" name="md_no[]" value='<?=$md["no"]?>' />
						<select name="md_dl_id[]" id="dl_id_<?=$md["no"]?>">
							<option value=''>배송시 선택하세요.
						<?
						$sql = "select * from $g4[yc4_delivery_table] order by dl_order desc, dl_id desc ";
						$result = sql_query($sql);
						for ($i=0; $row=sql_fetch_array($result); $i++)
							echo "<option value='$row[dl_id]'>$row[dl_company]\n";
							mysql_free_result($result);
						?>
						</select>
						<?
						if ($md[md_dl_id] > 0) {
							echo "<script language='javascript'>$(\"#dl_id_{$md["no"]} > option[value='{$md[md_dl_id]}']\").attr('selected', 'selected');</script>";
						}
						?>


					</td>
				</tr>
				<tr class=ht>
					<td class='head'>운송장번호</td>
					<td>
						<input type=text class=ed name="md_invoice[]" value='<? echo $md[md_invoice] ?>'>
					</td>
				</tr>
				<tr class=ht>
					<td class='head'>배송일시</td>
					<td>
						<input type=text class=ed id="md_invoice_time_<?=$md["no"]?>" name="md_invoice_time[]" maxlength=19 value='<? echo is_null_time($md[md_invoice_time]) ? "" : $md[md_invoice_time]; ?>'>
						<input type=checkbox name=md_invoice_chk
							onclick="if (this.checked == true) getElementById('md_invoice_time_<?=$md["no"]?>').value='<? echo date("Y-m-d H:i:s", $g4['server_time']); ?>'; else getElementById('md_invoice_time_<?=$md["no"]?>').value='<?=$md["md_invoice_time"]?>';">현재 시간
					</td>
				</tr>




			
			<?}?>
		<?}?>


        </table>

        <br>
		<div style="float:right;">
        <input type=submit class=btn1 value='결제/배송내역 수정'>&nbsp;
        <input type=button class=btn1 value='  목  록  ' onclick="document.location.href='./orderlist.php?<?=$qstr?>';">
		</div>
    </td>
</tr>
</table>
</form>

<?=subtitle("상점메모")?>
<form name=frmorderform2 method=post action="./orderformupdate.php" style="margin:0px;">
<table width=100% cellpadding=0 cellspacing=0 border=0 class="list02" style="margin:0 0 20px 0;">
<input type=hidden name=od_id     value="<?=$od_id?>">
<input type=hidden name=sort1     value="<?=$sort1?>">
<input type=hidden name=sort2     value="<?=$sort2?>">
<input type=hidden name=sel_field value="<?=$sel_field?>">
<input type=hidden name=search    value="<?=$search?>">
<input type=hidden name=page      value="<?=$page?>">
<tr>
	<td width=85%>
        <textarea name="od_shop_memo" rows=8 style='width:99%;' class=ed><? echo stripslashes($od[od_shop_memo]) ?></textarea>
	</td>
    <td width=15%>
        <input type=submit class=btn1 value='메모 수정'>
        <?=help("이 주문에 대해 일어난 내용을 메모하는곳입니다.\n\n위에서 메일발송한 내역도 이곳에 저장합니다.", -150);?>
    </td>
</tr>
</table>

<p><?=subtitle("주소정보")?>
<table cellpadding=0 cellspacing=0 width=1000px  >
<tr>
    <td width=49% valign=top bgcolor=#ffffff>
         <table width=100% cellpadding=0 cellspacing=0 border=0 class="list04" style="width:480px;">
        <colgroup width=80>
        <colgroup width='' bgcolor=#ffffff>
        <tr class=ht>
            <td colspan=4 bgcolor=#ffffff align=left class='bgcol1 bold col1 ht center'><B>주문하신 분</B></td>
        </tr>
        <tr class=ht>
            <td class="head">이름</td>
            <td><input type=text class=ed name=od_name value='<?=$od[od_name]?>' required itemname='주문하신 분 이름'></td>
	</tr>
	<tr class=ht>
            <td class="head">핸드폰</td>
            <td><input type=text class=ed name=od_hp value='<?=$od[od_hp]?>'></td>
        </tr>
        <tr class=ht>
            <td class="head">주소</td>
            <td>
                <input type=text class=ed name=od_zip1 size=5 readonly required itemname='우편번호' value='<?=$od[od_zip1]?>'>
                &nbsp;<a href="javascript:;" onclick="openDaumPostcode('frmorderform2', 'od_zip1', 'od_addr1', 'od_addr2');"><img src="<?=$g4[shop_admin_path]?>/img/btn_zip_find.gif" border=0 align=absmiddle></a><br>
                <input type=text class=ed name=od_addr1 size=50 readonly required itemname='주소' value='<?=$od[od_addr1]?>'><br>
                <input type=text class=ed name=od_addr2 size=50  itemname='상세주소' value='<?=$od[od_addr2]?>'></td>
        </tr>
		<tr class=ht>
            <td class="head">E-mail</td>
            <td><input type=text class=ed name=od_email size=30 email required itemname='주문하신 분 E-mail' value='<?=$od[od_email]?>'></td>
        </tr>
		<tr class=ht>
            <td class="head">IP Address</td>
            <td><?=$od[od_ip]?></td>
        </tr>
        </table>
    </td>
    <td width=2%></td>
    <td width=49% valign=top align=center>

        <?if($od["od_delivery_cnt"] <= 1) {?>

            <table width=100% cellpadding=0 cellspacing=0 border=0 class="list04" style="width:500px;">
                <colgroup width=80>
                <colgroup width='' bgcolor=#ffffff>
                <tr class=ht>
                    <td colspan=4 bgcolor=#ffffff align=left class='bgcol1 bold col1 ht center'><B>받으시는 분</B></td>
                </tr>
                <tr class=ht>
                    <td class="head">이름</td>
                    <td><input type=text class=ed name=od_b_name value='<?=$od[od_b_name]?>' required itemname='받으시는 분 이름'></td>
                </tr>
                <tr class=ht>
                    <td class="head">핸드폰</td>
                    <td><input type=text class=ed name=od_b_hp value='<?=$od[od_b_hp]?>'></td>
                </tr>
                <tr class=ht>
                    <td class="head">주소</td>
                    <td>
                        <input type=text class=ed name=od_b_zip1 size=5 readonly required itemname='우편번호 앞자리' value='<?=$od[od_b_zip1]?>'>
                        &nbsp;<a href="javascript:;" onclick="openDaumPostcode('frmorderform2', 'od_b_zip1', 'od_b_addr1', 'od_b_addr2');"><img src="<?=$g4[shop_admin_path]?>/img/btn_zip_find.gif" border=0 align=absmiddle></a><br>
                        <input type=text class=ed name=od_b_addr1 size=50 readonly required itemname='주소' value='<?=$od[od_b_addr1]?>'><br>
                        <input type=text class=ed name=od_b_addr2 size=50  itemname='상세주소' value='<?=$od[od_b_addr2]?>'></td>
                </tr>

                <? if ($default[de_hope_date_use]) { ?>
                <tr class=ht>
                    <td class="head">희망배송일</td>
                    <td>
                        <input type=text class=ed name=od_hope_date value='<?=$od[od_hope_date]?>' maxlength=10 minlength=10 required itemname='희망배송일'>
                        (<?=get_yoil($od[od_hope_date])?>)</td>
                </tr>
                <? } ?>
                
                <tr class=ht>
                    <td class="head">전하는 말</td>
                    <td colspan=3><?=nl2br($od[od_memo])?></td>
                </tr>
            </table>

            <?} else {?>

            <table width=100% cellpadding=0 cellspacing=0 border=0 class="list04" style="width:500px;">
                <colgroup width=80>
                <colgroup width='' bgcolor=#ffffff>
                <tr class=ht>
                    <td colspan=4 bgcolor=#ffffff align=left class='bgcol1 bold col1 ht center'><B>받으시는 분 (<?=$od["od_delivery_cnt"]?>군데 배송)</B></td>
                </tr>

                <? if ($default[de_hope_date_use]) { ?>
                <tr class=ht>
                    <td class="head">희망배송일</td>
                    <td>
                        <input type=text class=ed name=od_hope_date value='<?=$od[od_hope_date]?>' maxlength=10 minlength=10 required itemname='희망배송일'>
                        (<?=get_yoil($od[od_hope_date])?>)</td>
                </tr>
                <? } ?>
                

                <?
                $cnt = 0;
                for($idx = 0 ; $idx < count($mdlist); $idx++){
                    $md = $mdlist[$idx];
                    $cnt++;
                ?>
                    <tr class=ht>
                        <td colspan=4 bgcolor=#ffffff align=left class='bgcol1 bold col1 ht center'><B>[배송지<?=$cnt?>] 받으시는 분</B></td>
                    </tr>

                    <tr class=ht>
                        <td class="head">이름</td>
                        <td>
                            <input type="hidden" name="md_no[]" value="<?=$md["no"]?>" />
                            <input type=text class=ed name="md_name[]" value='<?=$md["md_name"]?>' required itemname='받으시는 분 이름'>
                        </td>
                    </tr>
                    <tr class=ht>
                        <td class="head">핸드폰</td>
                        <td><input type=text class=ed name="md_hp[]" value='<?=$md["md_hp"]?>'></td>
                    </tr>
                    <tr class=ht>
                        <td class="head">주소</td>
                        <td>
                            <table style="width:100%; border:0px; " border=0>
                            <tr>
                            <td style="border:0px; padding:0px;">
                            <input type=text class="md_zip1 ed" name="md_zip1[]" size=5 readonly required itemname='우편번호 앞자리' value='<?=$md["md_zip1"]?>'>
                            &nbsp;<a href="javascript:;" onclick="openDaumPostcode2(this, 'md_zip1', 'md_addr1', 'md_addr2');"><img src="<?=$g4[shop_admin_path]?>/img/btn_zip_find.gif" border=0 align=absmiddle></a><br>
                            <input type=text class="md_addr1 ed" name="md_addr1[]" size=50 readonly required itemname='주소' value='<?=$md["md_addr1"]?>'><br>
                            <input type=text class="md_addr2 ed" name="md_addr2[]" size=50  itemname='상세주소' value='<?=$md["md_addr2"]?>'></td>
                            </td>
                            </tr>
                            </table>
                    </tr>
                    <tr class=ht>
                        <td class="head">전하는 말</td>
                        <td colspan=3><?=nl2br($md[md_memo])?></td>
                    </tr>
                <?}?>
            </table>


        <?}?>

		 
		
    </td>
</tr>
</table>

<p align=center style="width:1000px;margin:10px 0 0 0;">
    <input type=submit class=btn1 value='주소정보 수정'>&nbsp;
    <input type=button class=btn1 value='  목  록  ' accesskey='l' onclick="document.location.href='./orderlist.php?<?=$qstr?>';">&nbsp;
    <input type=button class=btn1 value='주문서 삭제' onclick="del('<?="./orderdelete.php?od_id=$od[od_id]&on_uid=$od[on_uid]&mb_id=$od[mb_id]&$qstr"?>');">
</form>



<br/>
<br/>
<br/>
<br/>
<?=subtitle("주문상태변경내역")?>
<table width="1050px" cellpadding=0 cellspacing=0 border=0>
<tr>
	<td width=100%>
	        <textarea name="od_history" rows=18 style='width:99%;' class=ed readonly wrap="off"><? echo $od[od_history]; ?></textarea>
	</td>
</tr>
</table>


<script language='javascript'>
var select_all_sw = false;
var visible_sw = false;

// 전체선택, 전체해제
function select_all()
{
    var f = document.frmorderform;

    for (i=0; i<f.chk_cnt.value; i++)
    {
        if (select_all_sw == false)
            document.getElementById('ct_chk_'+i).checked = true;
        else
            document.getElementById('ct_chk_'+i).checked = false;
    }

    if (select_all_sw == false)
        select_all_sw = true;
    else
        select_all_sw = false;
}

function form_submit(status)
{
    var f = document.frmorderform;
    var check = false;

    for (i=0; i<f.chk_cnt.value; i++) {
        if (document.getElementById('ct_chk_'+i).checked == true) check = true;
    }
    
    if (check == false) {
        alert("처리할 자료를 하나 이상 선택해 주십시오.");
        return;
    }

    if (confirm("\'" + status + "\'을(를) 선택하셨습니다.\n\n이대로 처리 하시겠습니까?") == true) {
        f.ct_status.value = status;
        f.action = "./ordercartupdate.php";
        f.submit();
    }

    return;
}
</script>

<?
include_once("$g4[admin_path]/admin.tail.php");
?>