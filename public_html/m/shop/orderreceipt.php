<?
include_once("./_common.php");

function proc_quot($str)
{
    return preg_replace('/\"/', "&quot;", stripslashes($str));
}

session_check();

// 장바구니가 비어있는가?
if (get_session("ss_direct"))
    $tmp_on_uid = get_session("ss_on_direct");
else
    $tmp_on_uid = get_session("ss_on_uid");

if (get_cart_count($tmp_on_uid) == 0) 
    alert("장바구니가 비어 있습니다.", "./cart.php");

// 희망배송일 사용한다면
if ($default[de_hope_date_use])
{
    ereg("([0-9]{4})-([0-9]{2})-([0-9]{2})", $od_hope_date, $hope_date);
    if ($od_hope_date == "") ; // 통과
    else if (checkdate($hope_date[2], $hope_date[3], $hope_date[1]) == false)
        alert("희망배송일을 올바르게 입력해 주십시오.");
    else if ($od_hope_date < date("Y-m-d", time()+86400*$default[de_hope_date_after]))
        alert("희망배송일은 오늘부터 {$default[de_hope_date_after]}일 후 부터 입력해 주십시오.");
}

// 회원 로그인 중이라면 회원비밀번호를 주문서에 넣어줌
if ($is_member)
    $od_pwd = $mb[mb_pwd];
else
    $od_pwd = sql_password($od_pwd);

$pageNum='100';
$subNum='12';

$g4[title] = "주문확인 및 결제";


//뒤로가기용 데이터 저장
set_session("ss_orderform", json_encode($_POST));


include_once("./_head.php");
?>

<div class="ShopCover" >


<?
$s_page = '';
$s_on_uid = $tmp_on_uid;
include_once("./cartsub.inc.php");
?>

<style>
.checkpop_css1 {display:none; position:fixed; top:0px; left:0px; height:100%; width:100%; background-color:black;opacity:0.5; z-index:999; }
.checkpop_css2 { display:none; line-height:40px; position:fixed; left:50%; margin-left:-300px; top:50%; transform:translateY(-50%); text-align:left; padding-left:20px; padding-top:30px; font-size:22px; color:#000; width:580px;background-color:white;border-radius:5px;z-index:9999; box-shadow:#444444 3px 3px 3px; padding-bottom:120px; }
.checkpop_css3 { position:absolute; bottom:0px; left:0px; height:60px; text-align:center; font-size:27px; padding-top:20px; width:100%; background-color:#ea4417; color:white; cursor:pointer; border-bottom-right-radius: 5px;border-bottom-left-radius: 5px}
</style>

<!-- 첫 팝업 -->
<div class="checkpop checkpop_css1" >
    &nbsp;
</div>
<div class="checkpop checkpop_css2" >

    <div onclick="$('.checkpop').hide();" style="position:absolute; top:8px; right:15px; font-size:34px;">
        <i class="fas fa-times"></i>
    </div>
    
    <span class="popup_content">
    </span>
    <br/>
    <div onclick="$('.checkpop').hide(); go_next();" class="checkpop_css3" >
        <i class="fas fa-check"></i> 주문하기
    </div>
</div>



  <form name=frmorderreceipt method=post action='./orderupdate.php' onsubmit="return frmorderreceipt_check(this)" autocomplete="off">
        <input type=hidden name=de_card_point value="<? echo $default[de_card_point] ?>">
        <input type=hidden name=od_settle_case value="<? echo $od_settle_case ?>">
        <input type=hidden name=od_amount    value="<? echo $tot_sell_amount ?>">
        <input type=hidden name=od_send_cost value="<? echo $send_cost ?>">
        <input type=hidden name=od_name      value="<? echo proc_quot($od_name) ?>">
        <input type=hidden name=od_pwd       value="<? echo $od_pwd ?>">
        <input type=hidden name=od_tel       value="<? echo $od_tel ?>">
        <input type=hidden name=od_hp        value="<? echo $od_hp ?>">
        <input type=hidden name=od_zip1      value="<? echo $od_zip1 ?>">
        <input type=hidden name=od_zip2      value="<? echo $od_zip2 ?>">
        <input type=hidden name=od_addr1     value="<? echo $od_addr1 ?>">
        <input type=hidden name=od_addr2     value="<? echo $od_addr2 ?>">
        <input type=hidden name=od_email     value="<? echo $od_email ?>">
        <input type=hidden name=od_b_name    value="<? echo proc_quot($od_b_name) ?>">
        <input type=hidden name=od_b_tel     value="<? echo $od_b_tel ?>">
        <input type=hidden name=od_b_hp      value="<? echo $od_b_hp ?>">
        <input type=hidden name=od_b_zip1    value="<? echo $od_b_zip1 ?>">
        <input type=hidden name=od_b_zip2    value="<? echo $od_b_zip2 ?>">
        <input type=hidden name=od_b_addr1   value="<? echo $od_b_addr1 ?>">
        <input type=hidden name=od_b_addr2   value="<? echo $od_b_addr2 ?>">
        <input type=hidden name=od_hope_date value="<? echo $od_hope_date ?>">
        <input type=hidden name=od_memo      value="<? echo htmlspecialchars2(stripslashes($od_memo)) ?>">
        <input type=hidden name=coupon      value="<? echo $coupon ?>">
		<input type="hidden" name="od_delivery_cnt" value="<?=$od_delivery_cnt?>" />




<br>
<table width=100% align=center cellpadding=0 cellspacing=10 border=0>
<tr>
    <td bgcolor=#FAFAFA class="od_group" style='padding-left:10px;'>
        <div class="od_group_title">
            <i class="fas fa-check-double"></i> 입력하신 내용이 맞는지 다시 한번 확인하여 주십시오.</b>
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
            <td><? echo proc_quot($od_name) ?></td>
        </tr>
        <tr height=25 style="display:none">
            <td>전화번호</td>
            <td><? echo $od_tel ?></td>
        </tr>
        <tr height=25>
            <td>핸드폰</td>
            <td><? echo $od_hp ?></td>
        </tr>
        <tr height=25>
            <td>주소</td>
            <td><? echo sprintf("(%s) %s %s", $od_zip1,$od_addr1, $od_addr2); ?></td>
        </tr>
        <tr height=25>
            <td>E-mail</td>
            <td><? echo $od_email ?></td>
        </tr>
        <?
        // 희망배송일 사용한다면
        if ($default[de_hope_date_use]) {
            echo "
            <tr height=25>
                <td>희망배송일</td>
                <td>$od_hope_date (".get_yoil($od_hope_date).")</td>
            </tr> ";
        }
        ?>
        </table>
    </td>
</tr>
</table>


<?if($_REQUEST["od_delivery_cnt"] <= 1){?>

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
				<td colspan=3><? echo proc_quot($od_b_name); ?></td>
			</tr>
			<tr height=25 style="display:none">
				<td>전화번호</td>
				<td><? echo $od_b_tel ?></td>
			</tr>
			<tr height=25>
				<td>핸드폰</td>
				<td><? echo $od_b_hp ?></td>
			</tr>
			<tr height=25>
				<td>주소</td>
				<td><? echo sprintf("(%s) %s %s", $od_b_zip1, $od_b_addr1, $od_b_addr2); ?></td>
			</tr>
			<tr height=25>
				<td>전하실말씀</td>
				<td style="word-break:break-all;"><? echo htmlspecialchars2(stripslashes($od_memo)) ?></td>
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
				<td colspan=3><? echo proc_quot($od_delivery_cnt); ?>군데</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
	

	<?
	for($idx = 0 ; $idx < count($_POST["md_no"]) ; $idx++){ 
		$cnt = $idx+1; 
		$md_b_name = $_POST["md_b_name"][$cnt];
		$md_b_tel = $_POST["md_b_tel"][$cnt];
		$md_b_hp = $_POST["md_b_hp"][$cnt];
		$md_b_zip1 = $_POST["md_b_zip1"][$cnt];
		$md_b_addr1 = $_POST["md_b_addr1"][$cnt];
		$md_b_addr2 = $_POST["md_b_addr2"][$cnt];
		$md_memo= $_POST["md_memo"][$cnt];
	?>
		
		<input type="hidden" class="md_no" name="md_no[]" value="<?=$cnt?>"/>
		<input type="hidden" name="md_b_name[<?=$cnt?>]" value="<?=$md_b_name?>" />
		<input type="hidden" name="md_b_tel[<?=$cnt?>]" value="<?=$md_b_tel?>" />
		<input type="hidden" name="md_b_hp[<?=$cnt?>]" value="<?=$md_b_hp?>" />
		<input type="hidden" name="md_b_zip1[<?=$cnt?>]" value="<?=$md_b_zip1?>" />
		<input type="hidden" name="md_b_addr1[<?=$cnt?>]" value="<?=$md_b_addr1?>" />
		<input type="hidden" name="md_b_addr2[<?=$cnt?>]" value="<?=$md_b_addr2?>" />
		<input type="hidden" name="md_memo[<?=$cnt?>]" value="<?=$md_memo?>" />

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
						<td colspan=3><? echo proc_quot($md_b_name); ?></td>
					</tr>
					<tr height=25 style="display:none;">
						<td>전화번호</td>
						<td colspan=3><? echo proc_quot($md_b_tel); ?></td>
					</tr>
					<tr height=25>
						<td>핸드폰</td>
						<td colspan=3><? echo proc_quot($md_b_hp); ?></td>
					</tr>
					<tr height=25>
						<td>주소</td>
						<td colspan=3>(<? echo proc_quot($md_b_zip1); ?>) <? echo proc_quot($md_b_addr1); ?> <? echo proc_quot($md_b_addr2); ?></td>
					</tr>
					<tr height=25>
						<td>전하실말씀</td>
						<td colspan=3><? echo proc_quot($md_memo); ?></td>
					</tr>
				</table>


				<div class="od_group_title">
                    <span class="label_gray" style="background:white;"> <i class="fas fa-truck"></i> 배송지 <?=$cnt?></span> 배송수량
				</div>
				

				<table cellpadding=3>
					<colgroup>
                        <col width=""/>
                        <col width="100px"/>
					</colgroup>

					<?for($cidx = 0 ; $cidx < count($_POST["md_qty"][$cnt]); $cidx++){?>
						<tr>
							<td style="padding:8px 2px;"> 
								
								<input type="hidden" name="md_ct_id[<?=$cnt?>][]" value="<?=$_POST["md_ct_id"][$cnt][$cidx]?>" />
								<input type="hidden" name="md_qty_itname[<?=$cnt?>][]" value="<?=$_POST["md_qty_itname"][$cnt][$cidx]?>" />
								<input type="hidden" name="md_qty[<?=$cnt?>][]" value="<?=$_POST["md_qty"][$cnt][$cidx]?>" />


								<span style="display:inline-block; min-width:200px; font-size:20px;">
                                    <?=urldecode($_POST["md_qty_itname"][$cnt][$cidx])?>
								</span>
							</td>
                            <td>

								<span style="font-size:20px;">
									<?=$_POST["md_qty"][$cnt][$cidx]?>개
								</span>
				
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
        <colgroup width="">
        <input type=hidden name=od_settle_amount value='<?=$tot_amount?>'>
        <tr>
            <td>결제금액</td>
            <td><?=display_amount($tot_amount)?></td>
        </tr>
        <?
        $receipt_amount = $tot_amount - $od_temp_point  - $coupon_amt;

        if ($od_temp_point != "") 
        {
            $temp_point = number_format($od_temp_point);
            echo "<input type=hidden name=od_temp_point value='$od_temp_point'>";
            echo "<tr><td>적립금결제</td><td>".display_point($od_temp_point)."</td></tr>";
        }

        if ($coupon_amt != "" && $coupon_amt != 0) {
	        echo "<input type=hidden name=od_coupon value='$coupon_amt'>";
	        echo "<tr><td>쿠폰결제</td><td>".number_format($coupon_amt)."원</td></tr>";
        }

        if ($od_settle_case == "무통장") 
        {
            // 은행계좌를 배열로 만든후
            $str = explode("\n", $default[de_bank_account]);
            if (count($str) <= 1)
            {
                $bank_account = "<input type=hidden name='od_bank_account' value='$str[0]'>$str[0]\n";
            }
            else 
            {
                $bank_account = "\n<select name=od_bank_account>\n";
                $bank_account .= "<option value=''>--------------- 선택하십시오 ---------------\n";
                for ($i=0; $i<count($str); $i++)
                {
                    $str[$i] = str_replace("\r", "", $str[$i]);
                    $bank_account .= "<option value='$str[$i]'>$str[$i] \n";
                }
                $bank_account .= "</select> ";
            }

            echo "<input type=hidden name=od_receipt_bank value='$receipt_amount'>";
            echo "<tr><td>무통장입금액</td><td>".display_amount($receipt_amount)." (결제하실 금액)</td></tr>";
            echo "<tr><td>계좌번호</td><td>$bank_account</td></tr>";
            echo "<tr><td>입금자 이름</td><td><input type=text name=od_deposit_name class=ed size=10 maxlength=20 value=\"".proc_quot($od_name)."\"><br/>(주문하시는분과 입금자가 다를 경우)</td></tr>";
            $receipt_amount = 0;
        }

        if ($od_settle_case == "가상계좌") 
        {
            $border_style = "";
            if ($od_receipt_bank == "") $border_style = " border-style:none;";
            echo "<input type=hidden name=od_bank_account value='가상계좌'>";
            echo "<input type=hidden name=od_deposit_name value='$od_name'>";
            echo "<input type=hidden name=od_receipt_bank value='$receipt_amount'>";
            echo "<tr><td>가상계좌</td><td>".display_amount($receipt_amount)." (결제하실 금액)</td></tr>";
            $receipt_amount = 0;
        }

        if ($od_settle_case == "계좌이체") 
        {
            $border_style = "";
            if ($od_receipt_bank == "") $border_style = " border-style:none;";
            echo "<input type=hidden name=od_bank_account value='계좌이체'>";
            echo "<input type=hidden name=od_deposit_name value='$od_name'>";
            echo "<input type=hidden name=od_receipt_bank value='$receipt_amount'>";
            echo "<tr><td>계좌이체</td><td>".display_amount($receipt_amount)." (결제하실 금액)</td></tr>";
            $receipt_amount = 0;
        }

        if ($od_settle_case == "신용카드") 
        {
            $border_style = "";
            if ($od_receipt_bank == "") $border_style = " border-style:none;";
            echo "<input type=hidden name=od_receipt_card value='$receipt_amount'>";
            echo "<tr><td>신용카드</td><td>".display_amount($receipt_amount)." (결제하실 금액)</td></tr>";
            $receipt_amount = 0;
        }
        ?>
        </table>
    </td>
</tr>
</table>

<p align=center class="shop_btns" style="margin-top:30px;">   
    <span id='id_submit'>
    
        <a href="javascript:history.go(-1);"><span class='btnBack'>&nbsp;&nbsp;뒤 로&nbsp;&nbsp;</span></a>
    <a href="javascript:frmorderreceipt_check(document.frmorderreceipt);"><span class='btnOK'>&nbsp;&nbsp;&nbsp;&nbsp;다 음 <i class="fas fa-check"></i>&nbsp;&nbsp;&nbsp;&nbsp;</a>
    
    </span>
    <span id='id_saving' style='display:none;'><img src='<?=$g4[shop_img_path]?>/saving.gif' border=0></span>
</p>


</form>
</div>

<script language='javascript'>

function go_next() {
    document.getElementById('id_submit').style.display = 'none';
    document.getElementById('id_saving').style.display = '';
    document.frmorderreceipt.submit();
}

function frmorderreceipt_check(f) 
{
    errmsg = "";
    errfld = "";

    settle_amount = parseFloat(f.od_amount.value) + parseFloat(f.od_send_cost.value);
    od_receipt_bank = 0;
    od_receipt_card = 0;
    od_temp_point = 0;
    od_coupon = 0;

    if (typeof(f.od_temp_point) != 'undefined')
    {
        od_temp_point = parseFloat(no_comma(f.od_temp_point.value));
        if (od_temp_point > 0)
        {
            /*
            // 적립금 최소 결제점수
            if (od_temp_point < <?=(int)($default[de_point_settle] * $default[de_point_per] / 100)?>)
            {
                //alert("적립금 결제액은 <?=display_point($default[de_point_settle])?> 이상 가능합니다.");
                alert("적립금 결제액은 <?=display_point($default[de_point_settle] * $default[de_point_per] / 100)?> 이상 가능합니다.");
                return;
            // 가지고 있는 적립금 보다 많이 입력했다면
            } 
            else 
            */
            if (od_temp_point > <? echo (int)$od_temp_point ?>) 
            {
                alert("적립금 결제액은 <? echo display_point($od_temp_point) ?> 까지 가능합니다.");
                return;
            }
        }
    }

    if (typeof(f.od_receipt_card) != 'undefined')
    {
        od_receipt_card = parseFloat(no_comma(f.od_receipt_card.value));
        if (od_receipt_card < <?=(int)($default[de_card_max_amount])?>)
        {
            alert("신용카드 결제액은 <?=display_amount($default[de_card_max_amount])?> 이상 가능합니다.");
            return;
        }
    }

    if (typeof(f.od_receipt_bank) != 'undefined')
    {
        od_receipt_bank = parseFloat(no_comma(f.od_receipt_bank.value));
        if (f.od_bank_account.value == "" && od_receipt_bank > 0)
        {
            alert("무통장으로 입금하실 은행 계좌번호를 선택해 주십시오.");
            f.od_bank_account.focus();
            return;
        }

        if (f.od_deposit_name.value.length < 2)
        {
            alert("입금자분 이름을 입력해 주십시오.");
            f.od_deposit_name.focus();
            return;
        }
    }

    if(typeof(f.od_coupon) != 'undefined'){

        od_coupon = parseFloat(no_comma(f.od_coupon.value));

    }

    sum = od_receipt_bank + od_receipt_card + od_temp_point + od_coupon;
    if (settle_amount != sum)
    {
        alert("입력하신 입금액 합계와 결제금액이 같지 않습니다.");
        return;
    }

    // 음수일 경우 오류
    if (od_temp_point < 0 || od_receipt_card < 0 || od_receipt_bank < 0)
    {
        alert("금액은 음수가 될 수 없습니다.");
        return;
    }

      str_card = "";
    str = "<i class='fas fa-cart-arrow-down'></i> 총 결제하실 금액 <strong style='font-size:22px; color:red;'>" + number_format(f.od_settle_amount.value) + "원</strong> 중에서\n";
    if (typeof(f.od_temp_point) != 'undefined')
        str += "적립금 : <strong>" + number_format(f.od_temp_point.value) + "점</strong>\n";
    if(typeof(f.od_coupon) != 'undefined')
    	str += "쿠폰 : <strong>" + number_format(f.od_coupon.value) + "원</strong>\n";
    if (typeof(f.od_receipt_card) != 'undefined')
    {
        str += "신용카드 : <strong>" + number_format(f.od_receipt_card.value) + "원</strong>\n";
        if (parseFloat(f.od_receipt_card.value) > 0)
        {
            // 카드, 계좌이체 결제시 적립금부여 여부
            if (!f.de_card_point.value)
                str_card += "\n---------------------------------------\\n\\n카드, 계좌이체 결제시 적립금 부여하지 않습니다.";
         }
    }
    if (typeof(f.od_receipt_bank) != 'undefined')
        str += "<?=$od_settle_case?> : <strong style='color:red;' >" + number_format(f.od_receipt_bank.value) + "원</strong>\n";
    str += "으로 주문 하셨습니다.\n"+
           "금액이 올바른지 확인해 주십시오."+str_card;
    
    
    $(".checkpop .popup_content").html(str.split("\n").join("<br/>"));
    $(".checkpop").show();
    return;

    sw_submit = confirm(str);
    if (sw_submit == false)
        return;
}

function compute_amount(f, fld)
{
    x = no_comma(fld.value);
    if (isNaN(x))
    {
        alert("숫자가 아닙니다.");
        fld.value = fld.defaultValue;
        fld.focus();
        return;
    }
    else if (x == "")
        x = 0;
    x = parseFloat(x);
    
    // 100점 미만 버림
    if (fld.name == "od_temp_point") {
        x = parseInt(x / 100) * 100;
    }

    fld.value = number_format(String(x));

    settle_amount = parseFloat(f.od_amount.value) + parseFloat(f.od_send_cost.value);

    od_receipt_bank = 0;
    od_receipt_card = 0;
    od_temp_point = 0;

    if (typeof(f.od_receipt_bank) != 'undefined')
        od_receipt_bank = parseFloat(no_comma(f.od_receipt_bank.value));

    if (typeof(f.od_receipt_card) != 'undefined')
        od_receipt_card = parseFloat(no_comma(f.od_receipt_card.value));

    if (typeof(f.od_temp_point) != 'undefined')
        od_temp_point   = parseFloat(no_comma(f.od_temp_point.value));

    sum = od_receipt_bank + od_receipt_card + od_temp_point;

    // 입력합계금액이 결제금액과 같지 않다면
    if (sum != settle_amount)
    {
        if (fld.name == 'od_temp_point')
        {
            if (typeof(f.od_receipt_bank) != 'undefined')
            {
                od_receipt_bank = settle_amount - (od_temp_point + od_receipt_card);
                f.od_receipt_bank.value = number_format(String(od_receipt_bank));
            }
            else if (typeof(f.od_receipt_card) != 'undefined')
            {
                od_receipt_card = settle_amount - (od_temp_point + od_receipt_bank);
                f.od_receipt_card.value = number_format(String(od_receipt_card));
            }
            else
            {
                f.od_temp_point.value = number_format(String(od_temp_point));
            }
        } 
        else if (fld.name == 'od_receipt_card')
        {
            if (typeof(f.od_receipt_bank) != 'undefined')
            {
                od_receipt_bank = settle_amount - (od_temp_point + od_receipt_card);
                f.od_receipt_bank.value = number_format(String(od_receipt_bank));
            }
            else
            {
                f.od_receipt_card.value = number_format(String(od_receipt_card));
            }
        }
        else if (fld.name == 'od_receipt_bank')
        {
            if (typeof(f.od_temp_point) == 'undefined')
            {
                if (typeof(f.od_receipt_card) == 'undefined') {
                    ;
                } else {
                    od_receipt_card = settle_amount - od_receipt_bank;
                    f.od_receipt_card.value = number_format(String(od_receipt_card));
                }
            }
        }
        return;
    }
}
</script>

<?
include_once("./_tail.php");
?>