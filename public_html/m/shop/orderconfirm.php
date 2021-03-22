<?
include_once("./_common.php");




// 장바구니가 비어있는가?
$tmp_on_uid = get_session('ss_temp_on_uid');


$sql = " select * from $g4[yc4_order_table] where on_uid = '$tmp_on_uid' ";
$od = sql_fetch($sql);


if (get_cart_count($tmp_on_uid) == 0)// 장바구니에 담기
    alert("장바구니가 비어 있습니다.\\n\\n이미 주문하셨거나 장바구니에 담긴 상품이 없는 경우입니다.", "./cart.php");

set_session("ss_on_uid_inquiry", $tmp_on_uid);


$pageNum='100';
$subNum='13';

$g4[title] = "주문 및 결제완료";

include_once("./_head.php");

// 상품명만들기
$sql = " select a.it_id, b.it_name 
           from $g4[yc4_cart_table] a, $g4[yc4_item_table] b
          where a.it_id = b.it_id 
            and a.on_uid = '$tmp_on_uid' 
          order by ct_id
          limit 1 ";
$row = sql_fetch($sql);
?>

<div class="ShopCover" >

<?
$s_page = '';
$s_on_uid = $tmp_on_uid;
$od_id = $od[od_id];
include_once("./cartsub.inc.php");
?>

<br>
<table width=100% align=center cellpadding=0 cellspacing=10 border=0>
<tr>
    <td bgcolor=#FAFAFA class="" style='padding-left:10px; '>
        <div class="" style="font-size:16px; background-color:white;" >
            <i class="fas fa-check"></i> 주문번호 : <FONT COLOR="red"><?=$od[od_id]?></FONT></B> </b>
        </div>    
    </td>
</tr>
</table>


<!-- 주문하시는 분 -->
<table width=100% align=center cellpadding=0 cellspacing=10 border=0>
<colgroup width=140>
<colgroup width=''>
<tr>
    <td bgcolor=#FAFAFA class="od_group" style='padding-left:10px;' colspan="2">

    <div class="od_group_title">
        <i class="fas fa-shopping-bag"></i> 주문 하시는 분
    </div>

    <table cellpadding=3 class="od_group_table">
        <colgroup width=120>
        <colgroup width=''>
        <tr height=25>
            <td>이름</td>
            <td><? echo $od[od_name] ?></td>
        </tr>
        <tr height=25 style="display:none">
            <td>전화번호</td>
            <td><? echo $od[od_tel] ?></td>
        </tr>
        <tr height=25>
            <td>핸드폰</td>
            <td><? echo $od[od_hp] ?></td>
        </tr>
        <tr height=25>
            <td>주소</td>
            <td><? echo sprintf("(%s) %s %s", $od[od_zip1], $od[od_addr1], $od[od_addr2]); ?></td>
        </tr>
        <tr height=25>
            <td>E-mail</td>
            <td><? echo $od[od_email] ?></td>
        </tr>

        <? if ($default[de_hope_date_use]) { // 희망배송일 사용한다면 ?>
        <tr height=25>
            <td>희망배송일</td>
            <td><?=$od[od_hope_date]?> (<?=get_yoil($od[od_hope_date])?>)</td>
        </tr>
        <? } ?>
        </table>
    </td>
</tr>
</table>



<?if($od["od_delivery_cnt"] <= 1){?>

	<!-- 받으시는 분 -->
	<table width=100% align=center cellpadding=0 cellspacing=10 border=0>
	<colgroup width=140>
	<colgroup width=''>
	<tr>
		<td bgcolor=#FAFAFA class="od_group" style='padding-left:10px;' colspan="2">

		<div class="od_group_title">
			<i class="fas fa-truck"></i> 받으시는 분
		</div>

		<table cellpadding=3 class="od_group_table">
			<colgroup width=120>
			<colgroup width=''>
			<tr height=25>
				<td>이름</td>
				<td><? echo $od[od_b_name]; ?></td>
			</tr>
			<tr height=25 style="display:none">
				<td>전화번호</td>
				<td><? echo $od[od_b_tel] ?></td>
			</tr>
			<tr height=25>
				<td>핸드폰</td>
				<td><? echo $od[od_b_hp] ?>&nbsp;</td>
			</tr>
			<tr height=25>
				<td>주소</td>
				<td><? echo sprintf("(%s) %s %s", $od[od_b_zip1], $od[od_b_addr1], $od[od_b_addr2]); ?></td>
			</tr>
			<tr height=25>
				<td>전하실말씀</td>
				<td><? echo nl2br(htmlspecialchars2($od[od_memo])); ?>&nbsp;</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>

<?} else {?>
	

	<!-- 받으시는 분 (여러군데 배송)-->
	<table width=100% align=center cellpadding=0 cellspacing=10 border=0>
	<colgroup width=120>
	<colgroup width=''>
	<tr>
		<td bgcolor=#FAFAFA class="od_group"  style='padding-left:10px' colspan="2">
			<div class="od_group_title">
				<i class="fas fa-boxes"></i> 여러곳으로 상품 배송
			</div>
			<table cellpadding=3 class="od_group_table">
			<colgroup width=120>
			<colgroup width=''>
			<tr height=25>
				<td>배송지 개수</td>
				<td colspan=3><? echo $od["od_delivery_cnt"] ?>군데</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>




	<?
	$mdObj = new Yc4MultiDelivery();
	$mdResult = $mdObj->get_list($od["od_id"], 1, "", "", "", "", PHP_INT_MAX, "", "");
	$mdlist = $mdResult["list"];
	$cnt = 0;
	for($idx = 0 ; $idx < count($mdlist); $idx++){
		$md = $mdlist[$idx];
		$cnt++;
	?>

		<!-- 받으시는 분 (다중 배송) -->
		<table width=100% align=center cellpadding=0 cellspacing=10 border=0 class="multi_delivery_tables mdt_<?=$cnt?>">
		<colgroup width=140>
		<colgroup width=''>
		<tr>
			
			<td bgcolor=#FAFAFA class="od_group"  style='padding-left:10px' colspan="2">
				<div class="od_group_title">
                    <span class="label_black" style="background:white;"> <i class="fas fa-truck"></i> 배송지 <?=$cnt?></span> 받으시는 분
				</div>

				<table cellpadding=3 class="od_group_table">
				<colgroup width=120>
				<colgroup width=''>
					<tr height=25>
						<td>이름</td>
						<td colspan=3><? echo $md["md_name"]; ?></td>
					</tr>
					<tr height=25 style="display:none;">
						<td>전화번호</td>
						<td colspan=3><? echo $md["md_tel"]?></td>
					</tr>
					<tr height=25>
						<td>핸드폰</td>
						<td colspan=3><? echo $md["md_hp"]; ?></td>
					</tr>
					<tr height=25>
						<td>주소</td>
						<td colspan=3>(<? echo $md["md_zip1"];?>) <? echo $md["md_addr1"]; ?> <? echo $md["md_addr2"]; ?></td>
					</tr>
					<tr height=25>
						<td>전하실말씀</td>
						<td colspan=3><? echo $md["md_memo"]; ?></td>
					</tr>
				</table>


				<div class="od_group_title">
                     <span class="label_gray" style="background:white;"> <i class="fas fa-truck"></i> 배송지 <?=$cnt?></span> 배송수량
				</div>
				

                <table cellpadding=3>
                    <colgroup>
					    <col width=''>
					    <col width='100px'>
                    </colgroup>

                        <? $multi_delivery_list = Yc4MultiDelivery::get_list_qty($md["md_qty"]) ?>
                        <?foreach($multi_delivery_list as $mrow) {?>
						<tr>
							<td style="padding:8px 2px"> 
								<?=$mrow["name"]?>
							</td>
                            <td style="text-align:center; font-size:22px;">
                                <?=$mrow["qty"] ?>개
                            </td>
						</tr>
                        <?}?>



				</table>

			</td>
		</tr>
		</table>


	<?}?>


<?}?>


<!-- 결제 정보 -->
<table width=100% align=center cellpadding=0 cellspacing=10 border=0>
<colgroup width=140>
<colgroup width=''>
<tr>
    <td bgcolor=#FAFAFA class="od_group"  style='padding-left:10px' colspan="2">
        <div class="od_group_title">
            <i class="fas fa-coins"></i> 결제정보
        </div>
        <table cellpadding=3 class="od_group_table">
        <colgroup width=120>
        <colgroup width=''>

        <? if ($od[od_receipt_point] > 0) { ?>
        <tr height=25>
            <td>적립금결제</td>
            <td><? echo display_point($od[od_receipt_point]) ?></td>
        </tr>
        <? } ?>

        <? if ($od[od_coupon] > 0) { ?>
        <tr height=25>
            <td>쿠폰결제</td>
            <td><? echo number_format($od[od_coupon]) ?> 원</td>
        </tr>
        <? } ?>

        <? if ($od['od_temp_bank'] > 0) { ?>
            <tr height=25>
                <td><?=$od[od_settle_case]?></td>
                <td><? echo display_amount($od[od_temp_bank]) ?>  (결제하실 금액)</td>
            </tr>
            <? if ($od[od_settle_case] == '무통장') { ?>
                <tr height=25>
                    <td>계좌번호</td>
                    <td><? echo $od[od_bank_account]; ?></td>
                </tr>
            <? } ?>
        <tr height=25>
            <td>입금자 이름</td>
            <td><? echo $od[od_deposit_name]; ?></td>
        </tr>
        <? } ?>

        <? if ($od[od_temp_card] > 0) { ?>
        <tr height=25>
            <td>신용카드</td>
            <td><? echo display_amount($od[od_temp_card]) ?> (결제하실 금액)</td>
        </tr>
        <? } ?>

        </table>
    </td>
</tr>
</table>

<?
/*
if ($od[od_temp_card]) 
{
    include "./ordercard{$default[de_card_pg]}.inc.php";
    echo "<p align=center><input type='image' src='$g4[shop_img_path]/btn_card.gif' border=0 onclick='OpenWindow();'></p>";
    echo "<p align=left>&nbsp; &middot; 결제가 제대로 되지 않은 경우 <a href='./orderinquiryview.php?od_id=$od[od_id]&on_uid=$od[on_uid]'><u>주문상세조회 페이지</u></a>에서 다시 결제하실 수 있습니다.</p>";
} 
else if ($od[od_temp_bank] && $od[od_bank_account] == "실시간 계좌이체")  
{
    include "./orderiche{$default[de_card_pg]}.inc.php";
    echo "<p align=center><input type='image' src='$g4[shop_img_path]/btn_iche.gif' border=0 onclick='OpenWindow();'></p>";
    echo "<p align=left>&nbsp; &middot; 결제가 제대로 되지 않은 경우 [<a href='./orderinquiryview.php?od_id=$od[od_id]&on_uid=$od[on_uid]'><u>주문상세조회 페이지</u></a>] 에서 다시 결제하실 수 있습니다.</p>";
} 
else 
{
    //echo "<a href='$g4[path]'><img src='$g4[shop_img_path]/btn_confirm3.gif' border=0 align=absmiddle></a>";
    //echo "주문이 완료 되었습니다. 입금 확인 후 배송하도록 하겠습니다. 감사합니다.";
    echo "<p align=center><a href='{$g4[path]}'><img src='{$g4[shop_img_path]}/btn_order_end.gif' border=0></a>";
}
*/
?>
<? 
// 파일이 존재한다면 ...
if (file_exists("./settle_{$default[de_card_pg]}.inc.php")) 
{
    $settle_case = $od['od_settle_case'];
    if ($settle_case == '')
    {
        echo "*** 결제방법 없음 오류 ***";
    }
    else if ($settle_case == '무통장')
    {
        echo "<p align=center class='cart_btns' style='line-height:1.5;'>";
        
        echo "<br/><br/><span style='font-weight:bold;font-size:16pt;'>주문이 완료되었습니다.</span><br/>입금을 확인한 후 배송하도록 하겠습니다, 주문해주셔서 감사합니다!";
        echo "<br/><br/><a href='./orderinquiryview.php?od_id=$od[od_id]&on_uid=$od[on_uid]'><span class='btnOK'>&nbsp;&nbsp;주문상세내역 <i class='fas fa-external-link-alt'></i>&nbsp;&nbsp;</span></a></p>";
    }
    else 
    {
        if ($settle_case == '신용카드')
            $settle_amount = $od['od_temp_card'];
        else
            $settle_amount = $od['od_temp_bank'];

        include "./settle_{$default[de_card_pg]}.inc.php";
	 if($default[de_card_pg] != 'kcp')
	        echo "<p align=center><input type='image' src='$g4[shop_img_path]/btn_settle.gif' border=0 onclick='OpenWindow();'>";
        echo "<p align=left>&nbsp; &middot; 결제가 제대로 되지 않은 경우 [<a href='./orderinquiryview.php?od_id=$od[od_id]&on_uid=$od[on_uid]'><u>주문상세조회 페이지</u></a>] 에서 다시 결제하실 수 있습니다.</p>";
    }
}
else
{
    if ($od[od_temp_card]) {
        include "./ordercard{$default[de_card_pg]}.inc.php";
        echo "<p align=center><input type='image' src='$g4[shop_img_path]/btn_card.gif' border=0 onclick='OpenWindow();'></p>";
        echo "<p align=left>&nbsp; &middot; 결제가 제대로 되지 않은 경우 <a href='./orderinquiryview.php?od_id=$od[od_id]&on_uid=$od[on_uid]'><u>주문상세조회 페이지</u></a>에서 다시 결제하실 수 있습니다.</p>";
    } else if ($od[od_temp_bank] && $od[od_bank_account] == "계좌이체")  {
        include "./orderiche{$default[de_card_pg]}.inc.php";
        echo "<p align=center><input type='image' src='$g4[shop_img_path]/btn_iche.gif' border=0 onclick='OpenWindow();'></p>";
        echo "<p align=left>&nbsp; &middot; 결제가 제대로 되지 않은 경우 [<a href='./orderinquiryview.php?od_id=$od[od_id]&on_uid=$od[on_uid]'><u>주문상세조회 페이지</u></a>] 에서 다시 결제하실 수 있습니다.</p>";
    } else {
    	
        echo "<p align=center><a href='{$g4[path]}'><img src='{$g4[shop_img_path]}/btn_order_end.gif' border=0></a>";
    }
}
?>




<?
/** 네이버 프리미엄 로그 분석 전환페이지 설정 = 주문완료 */
if($config["cf_use_naver_log"] && $config["cf_use_naver_log_buy"]){?>
    <script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
    <script type="text/javascript"> 
        var _nasa={};
        _nasa["cnv"] = wcs.cnv("1","<?=$od[od_temp_bank] + $od[od_temp_card]?>");
    </script> 
<?}?>


</div>


<?
include_once("./_tail.php");
?>