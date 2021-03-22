<?
include_once("./_common.php");

// 불법접속을 할 수 없도록 세션에 아무값이나 저장하여 hidden 으로 넘겨서 다음 페이지에서 비교함
$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

if (!$is_member) {
    if (get_session("ss_on_uid_inquiry") != $_GET['on_uid'])
        alert("직접 링크로는 주문서 조회가 불가합니다.\\n\\n주문조회 화면을 통하여 조회하시기 바랍니다.");
}

$sql = "select * from $g4[yc4_order_table] where od_id = '$od_id' and on_uid = '$on_uid' ";
$od = sql_fetch($sql);
if (!$od[od_id]) {
    echo "$od_id $on_uid $MxIssueNO";
    alert("조회하실 주문서가 없습니다.", $g4[path]);
}

// 결제방법
$settle_case = $od[od_settle_case];

set_session('ss_temp_on_uid', $on_uid);

$pageNum='100';
$subNum='14';


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


$g4[title] = "주문상세내역 : 주문번호 - $od_id";
include_once("./_head.php");
?>

<style>
.cartsub_icon_area { text-align:right; padding:5px 20px; font-size:16px; }
.cartsub_icon { font-size:18px; }
.cartsub_icon_area .cartsub_icon { margin-left:20px; }
.cartsub_icon1 { color:#ea9500; }
.cartsub_icon2 { color:#ff00de; }
.cartsub_icon3 { color:#049700; }
.cartsub_icon4 { color:#0024ff; }
</style>


<div class="ShopCover" >

<?
$s_on_uid = $od[on_uid];
$s_page = "orderinquiryview.php";
include "./cartsub.inc.php";
?>

<div class="cartsub_icon_area" >
	<span class="cartsub_icon cartsub_icon1" ><i class="far fa-comment-dots"></i></span> 주문대기
	<span class="cartsub_icon cartsub_icon2" ><i class="fas fa-gift"></i></span> 준비중
	<span class="cartsub_icon cartsub_icon3" ><i class="fas fa-truck"></i></span> 배송중
	<span class="cartsub_icon cartsub_icon4" ><i class="far fa-check-circle"></i></span> 배송완료
</div>

<br>
<table width=100% align=center cellpadding=0 cellspacing=10 border=0>
<tr>
    <td bgcolor=#FAFAFA class="" style='padding-left:10px;' >
        <div class="" style="font-size:16px; background-color:white;" >
            <i class="fas fa-check"></i> 주문번호 : <FONT COLOR="red"><?=$od[od_id]?></FONT></B> </b>
        </div>    
    </td>
</tr>
</table>



<table width=98% cellpadding=0 cellspacing=7 align=center >
<tr>
    <td bgcolor=#FFF class="od_group" style='padding-left:10px;' colspan="2">
        <div class="od_group_title">
            <i class="fas fa-shopping-bag"></i> 주문 하시는 분
        </div>
    
        <table cellpadding=4 class="od_group_table">
        <colgroup width=130>
        <colgroup width=''>
        <tr><td>· 주문일시</td><td>: <b><? echo $od[od_time] ?></b></td></tr>
        <tr><td>· 이 름</td><td>: <? echo $od[od_name] ?></td></tr>
        <tr style="display:none"><td>· 전화번호</td><td>: <? echo $od[od_tel] ?></td></tr>
        <tr><td>· 핸드폰</td><td>: <? echo $od[od_hp] ?></td></tr>
        <tr><td>· 주 소</td><td>: <?=sprintf("(%s)&nbsp;%s %s", $od[od_zip1], $od[od_addr1], $od[od_addr2])?></td></tr>
        <tr><td>· E-mail</td><td>: <? echo $od[od_email] ?></td></tr>
        </table>
    </td>
    
</tr>

<tr>
    <td colspan="2">
            &nbsp;
    </td>
</tr>


<?if($od["od_delivery_cnt"] <= 1){?>

	<tr>
		<td bgcolor=#FFF class="od_group" style='padding-left:10px;' colspan="2">

			<div class="od_group_title">
				<i class="fas fa-truck"></i> 받으시는 분
			</div>

			<table cellpadding=4 cellspacing=0 class="od_group_table">
			<colgroup width=130>
			<colgroup width=''>
			<tr><td>· 이 름</td><td>: <? echo $od[od_b_name] ?></td></tr>
			<tr style="display:none"><td>· 전화번호</td><td>: <? echo $od[od_b_tel] ?></td></tr>
			<tr><td>· 핸드폰</td><td>: <? echo $od[od_b_hp] ?></td></tr>
			<tr><td>· 주 소</td><td>: <?=sprintf("(%s)&nbsp;%s %s", $od[od_b_zip1], $od[od_b_addr1], $od[od_b_addr2])?></td></tr>
			<? 
			// 희망배송일을 사용한다면
			if ($default[de_hope_date_use]) 
			{
				echo "<tr>";
				echo "<td>· 희망배송일</td>";
				echo "<td>: ".substr($od[od_hope_date],0,10)." (".get_yoil($od[od_hope_date]).")</td>";
				echo "</tr>";
			} 
			
			if ($od[od_memo]) {
				echo "<tr>";
				echo "<td>· 전하실 말씀</td>";
				echo "<td>".conv_content($od[od_memo], 0)."</td>";
				echo "</tr>";        
			}
			?>
			</table></td></tr>

	<tr>
		<td colspan="2">
				&nbsp;
		</td>
	</tr>

	<?
	// 배송회사 정보
	$dl = sql_fetch(" select * from $g4[yc4_delivery_table] where dl_id = '$od[dl_id]' ");

	if ($od[od_invoice] || !$od[misu]) 
	{ 
		echo "
			<td bgcolor=#FFF class='od_group' style='padding-left:10px;' colspan='2'>
			<div class='od_group_title'>
				<i class='fas fa-truck-loading'></i> 배송정보
			</div>
		";
		if (is_array($dl)) 
		{ 
			// get 으로 날리는 경우 운송장번호를 넘김
			if (strpos($dl[dl_url], "=")) $invoice = $od[od_invoice];
			echo "<table cellpadding=4 cellspacing=0 class='od_group_table'>";
			echo "<colgroup width=130><colgroup width=''>";
			echo "<tr><td>· 배송회사</td><td>: $dl[dl_company] &nbsp;&nbsp;<a href='$dl[dl_url]{$invoice}' target=_new><span class='btn1-o'>배송조회하기</span></a></td></tr>";
			echo "<tr><td>· 운송장번호</td><td>: $od[od_invoice]</td></tr>";
			echo "<tr><td>· 배송일시</td><td>: $od[od_invoice_time]</td></tr>";
			echo "<tr><td>· 고객센터 전화</td><td>: $dl[dl_tel]</td></tr>";
			echo "</table>";
		} 
		else 
		{ 
			echo "<table cellpadding=4 cellspacing=0 class='od_group_table'><tr><td><span class=leading>&nbsp;&nbsp;아직 배송하지 않았거나 배송정보를 입력하지 못하였습니다.</span></td></tr></table>";
		} 
		echo "</td></tr>";
	}
	?>
	<tr>
		<td colspan="2">
				&nbsp;
		</td>
	</tr>
<?} else {?>
	

	<tr>
		<td class="od_group" style='padding-left:10px; background-color:#ffffff;' colspan="2">

			<div class="od_group_title">
				<i class="fas fa-boxes"></i> 여러곳으로 상품 배송
			</div>

			<table cellpadding=4 cellspacing=0 class="od_group_table">
			<colgroup width=150>
			<colgroup width=''>
			<tr><td>· 배송지 개수</td><td>: <? echo $od[od_delivery_cnt] ?>군데</td></tr>
			<?
			// 희망배송일을 사용한다면
			if ($default[de_hope_date_use]) 
			{
				echo "<tr>";
				echo "<td>· 희망배송일</td>";
				echo "<td>: ".substr($od[od_hope_date],0,10)." (".get_yoil($od[od_hope_date]).")</td>";
				echo "</tr>";
			} 
			?>
			</table>

		</td>
	</tr>
	<tr>
		<td colspan="2">
				&nbsp;
		</td>
	</tr>


	<?
	$mdObj = new Yc4MultiDelivery();
	$mdResult = $mdObj->get_list($od["od_id"], 1, "", "", "", "", PHP_INT_MAX, "", "");
	$mdlist = $mdResult["list"];
	$cnt = 0;
	for($idx = 0 ; $idx < count($mdlist); $idx++){
		$md = $mdlist[$idx];
		$cnt++;
	?>

		
		<tr>
			<td class="od_group" style='padding-left:10px; background-color:#ffffff;' colspan="2">

				<div class="od_group_title">
                    <span class="label_black" style="background:white;"> <i class="fas fa-truck"></i> 배송지 <?=$cnt?></span> 받으시는 분
				</div>

				<table cellpadding=4 cellspacing=0 class="od_group_table">
				<colgroup width=130>
				<colgroup width=''>
					<tr><td>· 이름</td><td>: <? echo $md["md_name"] ?></td></tr>
					<tr style="display:none;"><td>· 전화번호</td><td>: <? echo $md["md_tel"] ?></td></tr>
					<tr><td>· 핸드폰</td><td>: <? echo $md["md_hp"] ?></td></tr>
					<tr><td>· 주소</td><td>: (<? echo $md["md_zip1"] ?>) <?=$md["md_addr1"]?> <?=$md["md_addr2"]?></td></tr>
					<tr><td>· 전하실말씀</td><td>: <? echo conv_content($md[md_memo], 0) ?></td></tr>
				</table>

				<div class="od_group_title">
                    <span class="label_gray" style="background:white;"> <i class="fas fa-truck"></i> 배송지 <?=$cnt?></span> 배송수량
				</div>

				<table cellpadding=4 cellspacing=0 class="od_group_table">
				<colgroup width=130>
				<colgroup width=''>
					<tr><td colspan="2">
                            <table cellpadding=3 style="border-collapse:collapse; width:100%; border:0px;">
                                <colgroup>
                                    <col width=''>
                                    <col width='100px'>
                                </colgroup>

                                    <? $multi_delivery_list = Yc4MultiDelivery::get_list_qty($md["md_qty"]) ?>
                                    <?foreach($multi_delivery_list as $mrow) {?>
                                    <tr>
                                        <td style="padding:8px; border:0px;"> 
                                            <?=$mrow["name"]?>
                                        </td>
                                        <td style="text-align:center; font-size:22px;">
                                        &nbsp;&nbsp;<?=$mrow["qty"] ?>개
                                        </td>
                                    </tr>
                                    <?}?>

                            </table>
					</td></tr>
				</table>

				<?if ($md[md_invoice] || !$od[misu]) {?>

					<div class="od_group_title">
                        <span class="label_gray" style="background:white;"> <i class="fas fa-truck-loading"></i> 배송지 <?=$cnt?></span> 배송정보
					</div>

					
					<?
					// 배송회사 정보
					$dl = sql_fetch(" select * from $g4[yc4_delivery_table] where dl_id = '{$md[md_dl_id]}' ");
					if (is_array($dl))
					{ 	
						// get 으로 날리는 경우 운송장번호를 넘김
						if (strpos($dl[dl_url], "=")) $invoice = $md[md_invoice];
						echo "<table cellpadding=4 cellspacing=0 class='od_group_table'>";
						echo "<colgroup width=160><colgroup width=''>";
						echo "<tr><td>· 배송회사</td><td>: $dl[dl_company] &nbsp;&nbsp;<a href='$dl[dl_url]{$invoice}' target=_new><span class='btn1-o'>배송조회하기</span></a></td></tr>";
						echo "<tr><td>· 운송장번호</td><td>: $md[md_invoice]</td></tr>";
						echo "<tr><td>· 배송일시</td><td>: $md[md_invoice_time]</td></tr>";
						echo "<tr><td>· 고객센터 전화</td><td>: $dl[dl_tel]</td></tr>";
						echo "</table>";
					} else {
						echo "<table cellpadding=4 cellspacing=0 class='od_group_table'><tr><td><span class=leading>&nbsp;&nbsp;아직 배송하지 않았거나 배송정보를 입력하지 못하였습니다.</span></td></tr></table>";
					}
					?>

				<?}?>


			</td>
		</tr>
		<tr>
			<td colspan="2">
					&nbsp;
			</td>
		</tr>



	<?}?>




<?}?>



<?
$receipt_amount = $od[od_receipt_bank] 
                + $od[od_receipt_card] 
                + $od[od_receipt_point] 
                + $od[od_coupon] 
                - $od[od_cancel_card]
                - $od[od_refund_amount];

$misu = true;

if ($tot_amount - $tot_cancel_amount == $receipt_amount) {
    $wanbul = " (완불)"; 
    $misu = false; // 미수금 없음
}

$misu_amount = $tot_amount - $tot_cancel_amount - $receipt_amount - $od[od_dc_amount];

echo "<tr>";
echo " 
    <td bgcolor=#FFF class='od_group' style='padding-left:10px;' colspan='2'>
    <div class='od_group_title'>
        <i class='fas fa-coins'></i> 결제정보
    </div>
";

if ($od[od_settle_case] == '신용카드')
{
    if ($od[od_receipt_card] > 0) 
    {
        $sql = " select * from $g4[yc4_card_history_table] where od_id = '$od[od_id]' order by cd_id desc ";
        $result = sql_query($sql);
        $cd = mysql_fetch_array($result);
    }

    echo "<table cellpadding=4 cellspacing=0 width=100% class='od_group_table'>";
    echo "<colgroup width=130><colgroup width=''>";
    echo "<tr><td>· 결제방식</td><td>: 신용카드 결제</td></tr>";

    if ($od[od_receipt_card]) 
    {
        echo "<tr><td>· 결제금액</td><td class=amount>: " . display_amount($cd[cd_amount]) . "</td></tr>";
        echo "<tr><td>· 승인일시</td><td>: $cd[cd_trade_ymd] $cd[cd_trade_hms]</td>";
        echo "<tr><td>· 승인번호</td><td>: $cd[cd_app_no]</td></tr>";
        if ($default[de_card_pg] == 'kcp') {
            // KCP 신용카드 영수증 출력 코드
            echo "<tr><td>· 영수증</td><td>: <a href='javascript:;' onclick=\"window.open('https://admin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=card_bill&tno=$od[od_escrow1]&order_no=$od[od_id]&trade_mony=$cd[cd_amount]', 'winreceipt', 'width=620,height=670')\"><span class='btn1-o'>영수증 출력</span></a></td></tr>"; 
        }
        else if ($default[de_card_pg] == 'dacom' || $default[de_card_pg] == 'dacom_xpay') {
            // LG텔레콤 신용카드 영수증 출력 코드
            echo "<script language=\"JavaScript\" src=\"http://pg.dacom.net/mert/pg/eCredit.js\"></script>";
            echo "<tr><td>· 영수증</td><td>: <a href=\"javascript:showReceipt('$default[de_dacom_mid]','$od[od_id]','service')\">카드영수증보기</a></td>";
        }
        else if ($default[de_card_pg] == 'inicis') {
            // 이니시스 신용카드 영수증 출력 코드
            echo "<tr><td>· 영수증</td><td>: <a href='javascript:;' onclick=\"javascript:window.open('https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid=$od[od_escrow1]&noMethod=1', 'inicisReceipt', 'width=410,height=710')\">카드영수증보기</a></td>";
        }
        else if ($default[de_card_pg] == 'allthegate') {
            // 올더게이트 신용카드 영수증 출력 코드
            $send_dt = date("Ymd", strtotime($od[od_time]));
            echo "<tr><td>· 영수증</td><td>: <a href='javascript:;' onclick=\"javascript:window.open('http://www.allthegate.com/customer/receiptLast3.jsp?sRetailer_id=$default[de_allthegate_mid]&approve=$od[od_escrow1]&send_no=$od[od_id]&send_dt={$send_dt}', 'window', 'toolbar=no,location=no,directories=no,status=,menubar=no,scrollbars=no,resizable=no,width=420,height=700,top=0,left=150')\">카드영수증보기</a></td>";
        }

    }
    else if ($default[de_card_use] && $tot_cancel_amount == 0)
    {
        $settle_amount = $od['od_temp_card'];
        echo "<tr><td>· 결제정보</td><td>: 아직 승인되지 않았거나 승인을 확인하지 못하였습니다.</td>";
        echo "<tr><td colspan=2>";
        if ((int)$member[mb_point] >= $od[od_temp_point]) {
            include "./settle_{$default[de_card_pg]}.inc.php";
            if($default[de_card_pg] != "kcp"){
                echo "<input type='image' src='$g4[shop_img_path]/btn_settle.gif' border=0 onclick='OpenWindow();'>";
            }
        } else {
            echo "<font color=red>· 보유적립금이 모자라서 결제할 수 없습니다. 주문후 다시 결제하시기 바랍니다.</font>";
        }
        echo "</td></tr>";
    }
    echo "</table><br>";
}
else
{
    echo "<table cellpadding=4 cellspacing=0 class='od_group_table'>";
    echo "<colgroup width=130><colgroup width=''>";
    echo "<tr><td>· 결제방식</td><td>: {$od['od_settle_case']}</td></tr>";
    
    if ($od[od_receipt_bank]) 
    {
        echo "<tr><td>· 입금액</td><td>: " . display_amount($od[od_receipt_bank]) . "</td></tr>";
        echo "<tr><td>· 입금확인일시</td><td>: $od[od_bank_time]</td></tr>";
    }
    else
    {
        echo "<tr><td>· 입금액</td><td>: 아직 입금되지 않았거나 입금정보가 없습니다.</td></tr>";
    }

    if ($od[od_settle_case] != '계좌이체')
        echo "<tr><td>· 계좌번호</td><td>: $od[od_bank_account]</td></tr>";

    echo "<tr><td>· 입금자명</td><td>: $od[od_deposit_name]</td></tr>";

    if ($od[od_receipt_bank] == 0 && $tot_cancel_amount == 0)
    {
        if ($od['od_settle_case'] == '계좌이체' && $default[de_iche_use])
        {
            $settle_amount = $od['od_temp_bank'];
            echo "<tr><td colspan=2>";
            if ((int)$member[mb_point] >= $od[od_temp_point]) {
                include "./settle_{$default[de_card_pg]}.inc.php";
                if($default[de_card_pg] != "kcp"){
                    echo "<input type='image' src='$g4[shop_img_path]/btn_settle.gif' border=0 onclick='OpenWindow();'>";
                }
            } else {
                echo "<font color=red>· 보유포적립금이 모자라서 결제할 수 없습니다. 주문후 다시 결제하시기 바랍니다.</font>";
            }
            echo "</td></tr>";
        }

        if ($od['od_settle_case'] == '가상계좌' && $od['od_bank_account'] == '가상계좌' && $default[de_vbank_use])
        {
            $settle_amount = $od['od_temp_bank'];
            echo "<tr><td colspan=2>";
            if ((int)$member[mb_point] >= $od[od_temp_point]) {
                include "./settle_{$default[de_card_pg]}.inc.php";
                if($default[de_card_pg] != "kcp"){
                    echo "<input type='image' src='$g4[shop_img_path]/btn_settle.gif' border=0 onclick='OpenWindow();'>";
                }
            } else {
                echo "<font color=red>· 보유적립금이 모자라서 결제할 수 없습니다. 주문후 다시 결제하시기 바랍니다.</font>";
            }
            echo "</td></tr>";
        }
    }

    echo "</table><br>";
}

if ($od[od_receipt_point] > 0) 
{ 
    echo "<table cellpadding=4 cellspacing=0 width=100% class='od_group_table'>";
    echo "<colgroup width=130><colgroup width=''>";
    echo "<tr><td>· 적립금결제</td><td>: " . display_point($od[od_receipt_point]) . "</td></tr>";
    echo "</table>";
//} else if ($od[od_temp_point] > 0) {
} else if ($od[od_temp_point] > 0 && $member[mb_point] >= $od[od_temp_point]) {
    echo "<table cellpadding=4 cellspacing=0 width=100% class='od_group_table'>";
    echo "<colgroup width=130><colgroup width=''>";
    echo "<tr><td>· 적립금결제</td><td>: " . display_point($od[od_temp_point]) . "</td></tr>";
    echo "</table>";
}


if ($od[od_coupon] > 0)
{
	echo "<table cellpadding=4 cellspacing=0 width=100% class='od_group_table'>";
	echo "<colgroup width=130><colgroup width=''>";
	echo "<tr><td>· 쿠폰결제</td><td>: " . number_format($od[od_coupon]) . "원</td></tr>";
	echo "</table>";
}



if ($od[od_cancel_card] > 0) 
{
    echo "<table cellpadding=4 cellspacing=0 width=100% class='od_group_table'>";
    echo "<colgroup width=130><colgroup width=''>";
    echo "<tr><td><b>· 승인취소 금액</td><td>: " . display_amount($od[od_cancel_card]) . "</td></tr>";
    echo "</table>";
}

if ($od[od_refund_amount] > 0) 
{
    echo "<table cellpadding=4 cellspacing=0 width=100% class='od_group_table'>";
    echo "<colgroup width=130><colgroup width=''>";
    echo "<tr><td>· 환불 금액</td><td>: " . display_amount($od[od_refund_amount]) . "</td></tr>";
    echo "</table>";
}

// 취소한 내역이 없다면
if ($tot_cancel_amount == 0) {
    if (($od[od_temp_bank] > 0 && $od[od_receipt_bank] == 0) ||
        ($od[od_temp_card] > 0 && $od[od_receipt_card] == 0)) {
        echo "<form method='post' action='./orderinquirycancel.php' style='margin:0;'>";
        echo "<input type=hidden name=od_id  value='$od[od_id]'>";
        echo "<input type=hidden name=on_uid value='$od[on_uid]'>";
        echo "<input type=hidden name=token  value='$token'>";
        echo "<table cellpadding=4 cellspacing=0 width=100%>";
        echo "<colgroup width=150><colgroup width=''>";
        echo "<tr><td><a href='javascript:;' onclick=\"document.getElementById('_ordercancel').style.display='block';\"><span class='btn1-o'>위의 주문을 취소합니다.</span></a></td></tr>";
        echo "<tr id='_ordercancel' style='display:none;'><td>· 취소사유 : <input type=text name='cancel_memo' style='width:50%;' maxlength=100 required itemname='취소사유'></textarea> <input type=submit value='확인'></td></tr>";
        echo "</table></form>";
    } else if ($od[od_invoice] == "") {
        echo "<br><table cellpadding=4 cellspacing=0 width=100%>";
        echo "<colgroup width=130><colgroup width=''>";
        echo "<tr><td style='color:blue;'>· 이 주문은 직접 취소가 불가하므로 상점에 전화 연락 후 취소해 주십시오.</td></tr>";
        echo "</table>";
    }
} else {
    $misu_amount = $misu_amount - $send_cost;

    echo "<br><table cellpadding=4 cellspacing=0 width=100% class='od_group_table'>";
    echo "<colgroup width=130><colgroup width=''>";
    echo "<tr><td style='color:red;'>· 주문 취소, 반품, 품절된 내역이 있습니다.</td></tr>";
    echo "</table>";
}


if ($default[de_taxsave_use]) { // 현금영수증 발급을 사용하는 경우에만

    if ($misu_amount == 0 && $od[od_receipt_bank]) { // 미수금이 없고 현금일 경우에만 현금영수증을 발급 할 수 있습니다.
        if ($default[de_card_pg] == 'kcp') {
            echo "<br />";
            echo "<table cellpadding=4 cellspacing=0 width=100% class='od_group_table'>";
            echo "<colgroup width=130><colgroup width=''>";
            echo "<tr><td>· 현금영수증</td><td>: ";
            if ($od["od_cash"]) 
                echo "<a href=\"javascript:;\" onclick=\"window.open('https://admin.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp?cash_no=$od[od_cash_no]', 'taxsave_receipt', 'width=360,height=647,scrollbars=0,menus=0');\">현금영수증 확인하기</a>";
            else
                echo "<a href=\"javascript:;\" onclick=\"window.open('{$g4["shop_path"]}/taxsave_kcp.php?od_id=$od_id&on_uid=$od[on_uid]', 'taxsave', 'width=550,height=400,scrollbars=1,menus=0');\">현금영수증을 발급하시려면 클릭하십시오.</a>";
            echo "</td></tr>";
            echo "</table>";
        }
        else if ($default[de_card_pg] == 'tgcorp') {
            echo "<br />";
            echo "<table cellpadding=4 cellspacing=0 width=100% class='od_group_table'>";
            echo "<colgroup width=130><colgroup width=''>";
            echo "<tr><td>· 현금영수증</td><td>: ";
            if ($od["od_cash"]) {
                echo "<script>function tgcorpBill(mxid, mxissueno, smode, billtype) { var url = \"https://npg.tgcorp.com/dlp/tgcorpbill.jsp?MxID=\"+mxid+\"&MxIssueNO=\"+mxissueno+\"&Smode=\"+smode+\"&BillType=\"+billtype; var win = window.open(url, \"tgcorp\", \"width=400,height=640,menubar=no,resizable=yes\"); if(win.focus) win.focus(); }</script>";
                echo "<a href=\"javascript:;\" onclick=\"tgcorpBill('{$default[de_tgcorp_mxid]}', '{$od[od_cash_tgcorp_mxissueno]}', '0001', '00');\">현금영수증 확인하기</a>";
            } 
            else {
                // "&a=a" 는 뒤의 ? 를 무력화하기 위해 넣었습니다
                echo "<a href=\"javascript:;\" onclick=\"window.open('$g4[shop_path]/taxsave_tgcorp.php?od_id=$od_id&on_uid=$od[on_uid]&redirpath=".urlencode($_SERVER[REQUEST_URI]."&a=a")."', 'TG_PAY', 'width=390,height=360,scrollbars=0,menus=0');\">현금영수증을 발급하시려면 클릭하십시오.</a>";
            }
            echo "</td></tr>";
            echo "</table>";
        }
        else if ($default[de_card_pg] == 'allthegate') {
            echo "<br />";
            echo "<table cellpadding=4 cellspacing=0 width=100% class='od_group_table'>";
            echo "<colgroup width=130><colgroup width=''>";
            echo "<tr><td>· 현금영수증</td><td>: ";
            if ($od["od_cash"]) {
                echo "<a href=\"javascript:;\" onclick=\"window.open('$g4[shop_path]/taxsave_allthegate_receipt.php?od_id=$od_id&on_uid=$od[on_uid]', 'allthegate_receipt', 'width=440,height=550,scrollbars=0,menus=0');\">현금영수증 확인하기</a>";
            } 
            else {
                echo "<a href=\"javascript:;\" onclick=\"window.open('$g4[shop_path]/taxsave_allthegate.php?od_id=$od_id&on_uid=$od[on_uid]', 'allthegate', 'width=440,height=550,scrollbars=0,menus=0');\">현금영수증을 발급하시려면 클릭하십시오.</a>";
            }
            echo "</td></tr>";
            echo "</table>";
        }
        else if ($default[de_card_pg] == 'inicis') {
            echo "<br />";
            echo "<table cellpadding=4 cellspacing=0 width=100% class='od_group_table'>";
            echo "<colgroup width=130><colgroup width=''>";
            echo "<tr><td>· 현금영수증</td><td>: ";
            if ($od["od_cash"]) {
                echo "<script>function showreceipt(tid) { var showreceiptUrl = 'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/Cash_mCmReceipt.jsp?noTid=' + tid + '&clpaymethod=22'; window.open(showreceiptUrl,'showreceipt','width=380,height=540, scrollbars=no,resizable=no'); } </script>";
                echo "<a href=\"javascript:;\" onclick=\"showreceipt('$od[od_cash_inicis_tid]');\">현금영수증 확인하기</a>";
            } 
            else {
                echo "<a href=\"javascript:;\" onclick=\"window.open('$g4[shop_path]/taxsave_inicis.php?od_id=$od_id&on_uid=$od[on_uid]', 'inicis', 'width=632,height=655,scrollbars=0,menus=0');\">현금영수증을 발급하시려면 클릭하십시오.</a>";
            }
            echo "</td></tr>";
            echo "</table>";
        }
        else if ($default[de_card_pg] == 'dacom' || $default[de_card_pg] == 'dacom_xpay') {
            echo "<br />";
            echo "<table cellpadding=4 cellspacing=0 width=100% class='od_group_table'>";
            echo "<colgroup width=130><colgroup width=''>";
            echo "<tr><td>· 현금영수증</td><td>: ";
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
            echo "</table>";
        }
    }
}
?>
<tr>
    <td colspan="2">
            &nbsp;
    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#AFAFAF></td></tr>
<tr>
    <td colspan=2 align=right bgcolor='#FFF' height=70 style='font-size:20px; padding:15px; '>
        <b>결제 합계</b> <? echo $wanbul ?> : <b><? echo display_amount($receipt_amount) ?></b></span>&nbsp;&nbsp;
        <?
        if ($od[od_dc_amount] > 0) {
            echo "<br>DC : ". display_amount($od[od_dc_amount]) . "&nbsp;&nbsp;";
        }

        if ($misu_amount > 0) {
            echo "<br><font color=crimson><b>아직 결제하지 않으신 금액 : <span style='font-size:25px;'>".display_amount($misu_amount)."</span></b></font>&nbsp;&nbsp;";
        }
        ?></td></tr>    
<tr><td colspan=1 height=1 bgcolor=#AFAFAF></td></tr>
</table>

</div>

<?
include_once("./_tail.php");
?>