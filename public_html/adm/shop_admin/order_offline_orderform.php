<?
include_once("./_common.php");


$smb_id = get_session("ss_od_offline_id");
if($smb_id == "") {
	echo "
		<script>
			alert('오프라인 주문을 입력할 회원이 선택되어있지 않습니다. 회원ID를(또는 비회원) 선택해주세요');
			top.$.colorbox.close();
		</script>
	";
}
$mbObj = new Member();
if($smb_id == "|guest|") {
	$member = array("mb_level"=>1);
	$is_member = false;
} else {
	$member = $mbObj->get($smb_id);
}




$pageNum = 13;
$subNum = 3;
set_session("ss_direct", $sw_direct);
// 장바구니가 비어있는가?
if ($sw_direct) {
    $tmp_on_uid = get_session("ss_on_direct");
}
else {
    $tmp_on_uid = get_session("ss_on_uid");
}

if (get_cart_count($tmp_on_uid) == 0) {
    echo '
        <script>
        alert("장바구니가 비어있습니다.");
        top.$.colorbox.close();
        </script>
    ';
    exit;
}


// 포인트 결제 대기 필드 추가
//sql_query(" ALTER TABLE `$g4[yc4_order_table]` ADD `od_temp_point` INT NOT NULL AFTER `od_temp_card` ", false);

$pageNum='100';
$subNum='11';

$g4[title] = "주문서 작성";

set_session("ss_orderform", "");
include_once("{$g4["path"]}/head.sub.php");
?>

<p class="shoptitle">

<?
$s_page = 'orderform.php';
$s_on_uid = $tmp_on_uid;
include_once("./order_offline_cart.php");
?>



<style>
.multi_delivery {display:none;}
</style>



<form name=forderform method=post action="./order_offline_orderreceipt.php" onsubmit="return forderform_check(this);" autocomplete=off>
<input type=hidden name=od_amount    value='<?=$tot_sell_amount?>'>
<input type=hidden name=od_send_cost value='<?=$send_cost?>'>
<input type=hidden name=od_tel value='000-0000-0000'>
<input type="hidden" name="coupon" id="slt_cpn" value=""/>
<input type="hidden" name="coupon_amt" id="slt_cpn_amt" value=""/>

<!-- 주문하시는 분 -->
<table width=100% align=center cellpadding=0 cellspacing=10 border=0>
<colgroup width=140>
<colgroup width=''>
<tr>
    <td bgcolor=#FAFAFA class="od_group" style='padding-left:10px;' colspan="2">

        <div class="od_group_title">
            <i class="fas fa-shopping-bag"></i> 주문 하시는 분
        </div>

        <table cellpadding=3>
        <colgroup width=100>
        <colgroup width=''>
        <tr>
            <td>이름</td>
            <td><input type=text id=od_name name=od_name value='<?=$member[mb_name]?>' maxlength=20 class=ed></td>
        </tr>

        <? if (!$is_member) { // 비회원이면 ?>
        <tr>
            <td>비밀번호</td>
            <td><input type=password name=od_pwd class=ed maxlength=20>
                영,숫자 3~20자 (주문서 조회시 필요)</td>
        </tr>
        <? } ?>

        <tr style="display:none;">
            <td>전화번호</td>
            <td><input type="text" name=od_tel value='<?=$member[mb_tel]?>' maxlength=20 class=ed></td>
        </tr>
        <tr>
            <td>핸드폰</td>
            <td><input type=text class="phonenum" name=od_hp value='<?=$member[mb_hp]?>' maxlength=20 class=ed></td>
        </tr>
        <tr>
            <td rowspan=2>주 소</td>
            <td>
            	<div style="float:left;">
	                <input type=text name=od_zip1 size=6 maxlength=5 value='<?=$member[mb_zip1]?>' class=ed readonly>
            	</div>
                <div style="float:left; margin:0 0 0 5px; padding:3px 0 0 0;">
	                <a href="javascript:;" onclick="openDaumPostcode('forderform', 'od_zip1', 'od_addr1', 'od_addr2');">
                        <span class="btn1-o">우편번호확인</span>
                    </a>
	             </div>
            </td>
        </tr>
        <tr>
            <td>
                <input type=text name=od_addr1 size=35 maxlength=50 value='<?=$member[mb_addr1]?>' class=ed readonly>
                <input type=text name=od_addr2 size=20 maxlength=50 value='<?=$member[mb_addr2]?>' class=ed> (상세주소)
            </td>
        </tr>
        <tr>
            <td>E-mail</td>
            <td><input type=text name=od_email size=35 maxlength=100 value='<?=$member[mb_email]?>' class=ed></td>
        </tr>

        <? if ($default[de_hope_date_use]) { // 배송희망일 사용 ?>
        <tr>
            <td>희망배송일</td>
            <td><select name=od_hope_date>
                <option value=''>선택하십시오.
                <?
                for ($i=0; $i<7; $i++) {
                    $sdate = date("Y-m-d", time()+86400*($default[de_hope_date_after]+$i));
                    echo "<option value='$sdate'>$sdate (".get_yoil($sdate).")\n";
                }
                ?>
                </select></td>
        </tr>
        <? } ?>
        </table>
    </td>
</tr>
</table>




<?if($default["de_use_multi_delivery"]) { ?>
    <?if($total_qty >= 2){ //총 수량이 2개 이상일 때 활성화?>

        <!-- 받으시는 분 -->
        <table width=100% align=center cellpadding=0 cellspacing=10 border=0>
        <colgroup width=140>
        <colgroup width=''>
        <tr>
            
            <td bgcolor=#FAFAFA class="od_group"  style='padding-left:10px' colspan="2">
                <div class="od_group_title">
                    <i class="fas fa-boxes"></i> 여러곳으로 상품 보내기
                </div>
                <table cellpadding=3>
                    <colgroup width=100>
                    <colgroup width=''>
                    
                    <tr>
                        <td>배송지 개수</td>
                        <td>

                            
                                <select name="od_delivery_cnt" id="od_delivery_cnt" onchange="change_delivery_cnt();">
                                    <?for($didx = 1 ; $didx <= 10; $didx++){?>
                                        <option value="<?=$didx?>"><?=$didx?>군데</option>
                                    <?}?>
                                </select>

                                
                        </td>
                    </tr>
                </table>
            </td>

        </tr>
        </table>

    <?} else {?>

        <input type="hidden" name="od_delivery_cnt" value="1"/>
    <?}?>
<?}?>






<!-- 받으시는 분 -->
<table width=100% align=center cellpadding=0 cellspacing=10 border=0 class="single_delivery">
<colgroup width=140>
<colgroup width=''>
<tr>
    
    <td bgcolor=#FAFAFA class="od_group"  style='padding-left:10px' colspan="2">

        <div class="od_group_title">
            <i class="fas fa-truck"></i> 받으시는 분

                   
            <input type=checkbox id=same name=same onclick="javascript:gumae2baesong(document.forderform);">
            <label for='same'><b>주문하시는 분과 받으시는 분의 정보가 동일한 경우 체크하세요.</b></label>
           
        </div>

        <table cellpadding=3>
        <colgroup width=100>
        <colgroup width=''>
        
        <tr>
            <td>이름</td>
            <td><input type=text name=od_b_name class=ed maxlength=20></td>
        </tr>
        <tr style="display:none;">
            <td >전화번호</td>
            <td><input type=text name=od_b_tel class=ed
                maxlength=20></td>
        </tr>
        <tr>
            <td>핸드폰</td>
            <td><input type=text class="phonenum" name=od_b_hp class=ed maxlength=20></td>
        </tr>
        <tr>
            <td rowspan=2>주 소</td>
            <td>
            	<div style="float:left;">
	                <input type=text name=od_b_zip1 size=6 maxlength=5 class=ed readonly>
            	</div>
                <div style="float:left; margin:0 0 0 5px; padding:3px 0 0 0;">
	                <a href="javascript:;" onclick="openDaumPostcode('forderform', 'od_b_zip1', 'od_b_addr1', 'od_b_addr2');">
                        <span class="btn1-o">
                            우편번호확인 
                        </span>
	                </a>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <input type=text name=od_b_addr1 size=35 maxlength=50 class=ed readonly>
                <input type=text name=od_b_addr2 size=20 maxlength=50 class=ed> (상세주소)
            </td>
        </tr>
        <tr>
            <td>전하실말씀</td>
            <td><textarea name=od_memo rows=4 cols=60 class=ed></textarea></td>
        </tr>

        </table>


    </td>
</tr>
</table>




<div class="multi_delivery" id="div_multi_delivery">
	
</div>






<?if($is_member && ( $config[cf_use_point] || $default[de_use_coupon])) {?>

    <!-- 적립금 / 쿠폰 -->
    <table width=100% align=center cellpadding=0 cellspacing=10 border=0>
    <colgroup width=140>
    <colgroup width=''>
    <tr>
        
        <td bgcolor=#FAFAFA class="od_group"  style='padding-left:10px' colspan="2">

            <div class="od_group_title">
                <i class="fas fa-coins"></i> 적립금 / 쿠폰
            </div>

            <table cellpadding=3>
                <colgroup width=100>
                <colgroup width=''>
                <?
                if ($is_member && $default[de_use_coupon])
                {
                ?>
                <tr>
                    <td>
                        쿠폰 사용
                    </td>
                    <td colspan="">
                        <div>
                                <span>쿠폰할인금액 : 
                                </span> <span id="cpn_amt" style='font-weight:bold;color:#000;'>0 원</span> &nbsp;
                                <a href="/shop/coupon_select.php?on_uid=<?=$s_on_uid?>" class="fancybox fancybox.iframe"><span class="btn1-o">쿠폰함</span></a> 
                        </div>
                    </td>
                </tr>
                <?}?>
                
                <?
                // 회원이면서 포인트사용이면
                if ($is_member && $config[cf_use_point])
                {
                ?>
                <tr>        
                    <td>
                        적립금 사용
                    </td>
                    <td colspan="2" style='line-height:1.5;'>
                    <?
                            // 포인트 결제 사용 포인트보다 회원의 포인트가 크다면
                            if ($member[mb_point] >= $default[de_point_settle]){
                                $od_temp_point_style = "style='width:70px;'";
                            } else {
                                $od_temp_point_style = "style='width:70px; background:#ddd;' readonly ";
                            }

                            $temp_point = $tot_amount * ($default[de_point_per] / 100); // 포인트 결제 % 적용
                            $max_point = $temp_point;
                            //$temp_point = (int)((int)($temp_point / 100) * 100); // 100점 단위
                            $member_point = $member[mb_point];//(int)((int)($member[mb_point] / 100) * 100); // 100점 단위
                            if ($temp_point > $member_point)
                                $temp_point = $member_point;

                            
                            $has_point = $member_point;


                            echo " <input type=text id=od_temp_point name=od_temp_point value='0' ".$od_temp_point_style." >원";
                            echo " (총 사용가능 적립금 : ".display_point($temp_point).")";
                            echo "<br/><span style='margin-left:0px;' >- 적립금은 최소 ".number_format($default[de_point_settle])." 이상일 때 결제가 가능합니다.</span>";
                            echo "<br/><span style='margin-left:0px;' >- 최대 사용금액은 주문금액의 {$default[de_point_per]}% 내에서 결제가 가능합니다.</span>";
                    ?>
                    </td>
                </td>
                <?}?>
        
        
            </table>
        </td>
    </tr>
    </table>

<?}?>
        


<!-- 결제 정보 -->
<table width=100% align=center cellpadding=0 cellspacing=10 border=0>
<colgroup width=140>
<colgroup width=''>
<tr>
    
    <td bgcolor=#FAFAFA class="od_group"  style='padding-left:10px' colspan="2">
        <div class="od_group_title">
            <i class="fas fa-wallet"></i> 결제수단
        </div>

        <table cellpadding=3>
        <tr>
            <td height=50>
                <?
                $multi_settle == 0;
                $checked = "";

                // 무통장입금 사용
                if ($default[de_bank_use]) {
                    $multi_settle++;
                    echo "
                        <label class='btn_settlecase'>
                            <input type='radio' id=od_settle_bank name='od_settle_case' value='무통장' $checked style='visibility:hidden;'>
                            <i class='fas fa-money-bill-wave' style=''></i>
                            <label for='od_settle_bank'>무통장입금</label>
                        </label>&nbsp;";
                    $checked = "";
                }

                // 가상계좌 사용
                if ($default[de_vbank_use]) {
                    $multi_settle++;
                    echo "<label class='btn_settlecase'><input type='radio' id=od_settle_vbank name=od_settle_case value='가상계좌' $checked style='visibility:hidden;'><i class='fas fa-laptop-code' style=''></i> <label for='od_settle_vbank'>가상계좌</label></label>&nbsp;";
                    $checked = "";
                }

                // 계좌이체 사용
                if ($default[de_iche_use]) {
                    $multi_settle++;
                    echo "<label class='btn_settlecase'><input type='radio' id=od_settle_iche name=od_settle_case value='계좌이체' $checked style='visibility:hidden;'><i class='fas fa-laptop' style=''></i> <label for='od_settle_iche'>계좌이체</label></label>&nbsp;";
                    $checked = "";
                }

                // 신용카드 사용
                if ($default[de_card_use]) {
                    $multi_settle++;
                    echo "<label class='btn_settlecase'><input type='radio' id=od_settle_card name=od_settle_case value='신용카드' $checked style='visibility:hidden;'><i class='fas fa-credit-card' style=''></i> <label for='od_settle_card'>신용카드</label></label>&nbsp;";
                    $checked = "";
                }


                if ($multi_settle == 0)
                    echo "<br><span class=point>결제할 방법이 없습니다.<br>운영자에게 알려주시면 감사하겠습니다.</span>";

                if (!$default[de_card_point])
                    echo "<br><br>· '무통장입금' 이외의 결제 수단으로 결제하시는 경우 포인트를 적립해드리지 않습니다.";
                ?>

				<br/>
                <br/>

				
            </td>
        </tr>
        </table>
    </td>
</tr>
</table>

<p align=center class="shop_btns" style="margin-top:30px; margin-bottom:10px;">
   
    <a href="javascript:top.$.colorbox.close();"><span class='btnBack'>&nbsp;&nbsp;취 소&nbsp;&nbsp;</span></a>
    <a href="javascript:void(0)" onclick="$('form[name=forderform]').submit()"><span class='btnOK'>&nbsp;&nbsp;&nbsp;&nbsp;다 음 <i class="fas fa-check"></i>&nbsp;&nbsp;&nbsp;&nbsp;</span></a>

</p>
    
</form>

<!-- <? if ($default[de_card_use] || $default[de_iche_use]) { echo "결제대행사 : $default[de_card_pg]"; } ?> -->

<script language='javascript'>



function coupon_set(cpnIDStr, tot_cpnamt){
		
		$("#slt_cpn").val(cpnIDStr);
		$("#slt_cpn_amt").val(tot_cpnamt);
		$("#cpn_amt").html(number_format(tot_cpnamt+"") + " 원");

		$.fancybox.close();
}
       
$(document).ready(function() {
	$(".fancybox").fancybox({
		openEffect  : 'elastic',
		closeEffect : 'elastic',
		nextEffect  : 'none',
		prevEffect  : 'none',
		width		: '670px',
		height		: '500px',
		autoScale	: 'false',
		autoDimensions : 'false',
		padding     : 0,
		margin	    : 0,
		fitToView	: false,
		autoSize	: false,
		scrolling	: 'no',
		closeBtn	: false
	});
});


//여러곳으로 배송
function change_delivery_cnt(){
	var cnt = parseInt($("#od_delivery_cnt").val());
	if(cnt > 1){
		$(".multi_delivery").show();
		$(".single_delivery").hide();
	} else {
		$(".multi_delivery").hide();
		$(".single_delivery").show();
	}
	
    set_disp_sendcost();
	if(cnt <= 1) return;

	
	var ccnt = $(".multi_delivery_tables").size();

	//추가할 숫자
	var offset = cnt - ccnt;
	if(offset > 0) {
		//추가
		for(var idx = 1 ; idx <= offset ; idx++){
			add_delivery(ccnt+idx);
		}
	} else {

		//제거
		for(var idx = ccnt ; idx > ccnt-(offset*-1) ; idx--){
			$(".mdt_"+idx).remove();
		}
		
	}


}

function add_delivery(cnt) {
	
	var params = {
		sw_direct:"<?=$sw_direct?>",
		cnt:cnt
	}

	if($(".multi_delivery_"+cnt).size() > 0) $(".multi_delivery_"+cnt).remove();
	$("#div_multi_delivery").append("<div class='multi_delivery_container multi_delivery_"+cnt+"'></div>");
	$(".multi_delivery_"+cnt).load(g4_path+"/shop/orderform_multi_delivery.php", params, function(){
		set_class_event($(".multi_delivery_"+cnt));
	});

}

//배송비 표시
function set_disp_sendcost(){
	
	var cnt = parseInt($("#od_delivery_cnt").val());
	var sendcost = $(".sendcost").data("singlesendcost");
	if(isNaN(sendcost)) {
		sendcost = 0;
		return;
	}
	
	var sc = sendcost * cnt;
	$(".sendcost").html(number_format(sendcost+"")+ " X "+cnt);

	var sellamount = parseInt($(".disp_tot_amount").data("sellamount"));
	var newTotal = sellamount + (sendcost * cnt);

	$(".disp_tot_amount").html(number_format(newTotal+""));
	
}   


//다중 배송지 입력 체크
function validate_multi_delivery(){

	//입력검사
	if(!mdcheck("md_b_name", "배송받는 분 이름을 입력해주세요.")) return false;
	if(!mdcheck("md_b_hp", "배송받는 분 핸드폰 번호를 입력해주세요.")) return false;
	if(!mdcheck("md_b_zip", "배송받는 분 주소를 입력해주세요.")) return false;
	if(!mdcheck("md_b_addr1", "배송받는 분 주소를 입력해주세요.")) return false;
	if(!mdcheck("md_b_addr2", "배송받는 분 주소를 입력해주세요.")) return false;
	
	//배송수량 체크
	var flag = true;
	$(".tot_qty").each(function(){

		var it_id = $(this).data("key");
		var tqty = parseInt($(this).val());
		var sqty = 0;
		$(".qty_"+it_id).each(function(){
			sqty += parseInt($(this).val());
		});

		if(tqty != sqty) {
			alert("배송지별 배송 수량이 전체 수량과 다릅니다.\n전체 주문수량과 각 배송지별 배송수량의 합을 동일하게 설정해주세요.");
			flag = false;
			return false;
		}
		

	});
	if(!flag) return false;

	return true;

}

function mdcheck(value, msg){
	var flag = true;
	$("."+value).each(function(){
		if($(this).val() == "") {
			alert(msg);
			$(this).focus();
			flag = false;
			return false;
		}
	});
	return flag;
}


function forderform_check(f)
{
    errmsg = "";
    errfld = "";
    var deffld = "";

    check_field(f.od_name, "주문하시는 분 이름을 입력하십시오.");
    if (typeof(f.od_pwd) != 'undefined')
    {
        clear_field(f.od_pwd);
        if( (f.od_pwd.value.length<3) || (f.od_pwd.value.search(/([^A-Za-z0-9]+)/)!=-1) )
            error_field(f.od_pwd, "회원이 아니신 경우 주문서 조회시 필요한 비밀번호를 3자리 이상 입력해 주십시오.");
    }
    check_field(f.od_hp, "주문하시는 분 전화번호를 입력하십시오.");
    check_field(f.od_addr1, "우편번호 찾기를 이용하여 주문하시는 분 주소를 입력하십시오.");
    //check_field(f.od_addr2, " 주문하시는 분의 상세주소를 입력하십시오.");
    check_field(f.od_zip1, "");
    //check_field(f.od_zip2, "");

    clear_field(f.od_email);
    if(f.od_email.value=='' || f.od_email.value.search(/(\S+)@(\S+)\.(\S+)/) == -1)
        error_field(f.od_email, "E-mail을 바르게 입력해 주십시오.");

    if (typeof(f.od_hope_date) != "undefined")
    {
        clear_field(f.od_hope_date);
        if (!f.od_hope_date.value)
            error_field(f.od_hope_date, "희망배송일을 선택하여 주십시오.");
    }



	var cnt = parseInt($("#od_delivery_cnt").val());
	if(cnt > 1){	

		if(!validate_multi_delivery()){return false;}

	} else {

		check_field(f.od_b_name, "받으시는 분 이름을 입력하십시오.");
		check_field(f.od_b_hp, "받으시는 분 전화번호를 입력하십시오.");
		check_field(f.od_b_addr1, "우편번호 찾기를 이용하여 받으시는 분 주소를 입력하십시오.");
		//check_field(f.od_b_addr2, "받으시는 분의 상세주소를 입력하십시오.");
		check_field(f.od_b_zip1, "");
	    //check_field(f.od_b_zip2, "");

	}

    // 배송비를 받지 않거나 더 받는 경우 아래식에 + 또는 - 로 대입
    f.od_send_cost.value = parseInt(f.od_send_cost.value);
	

    if (errmsg)
    {
        alert(errmsg);
        errfld.focus();
        return false;
    }

    var settle_case = document.getElementsByName("od_settle_case");
    var settle_check = false;
    for (i=0; i<settle_case.length; i++)
    {
        if (settle_case[i].checked)
        {
            settle_check = true;
            break;
        }
    }
    if (!settle_check)
    {
        alert("결제방식을 선택하십시오.");
        return false;
    }


	var od_amount = parseInt($("#od_amount").val());
	var od_send_cost = parseInt($("#od_send_cost").val());
	if( $("#slt_cpn_amt").val() ){
		var slt_cpn_amt = parseInt($("#slt_cpn_amt").val());
	} else{
		var slt_cpn_amt = 0;
	}
	if( $("#od_temp_point").val() ){
		var od_temp_point = parseInt($("#od_temp_point").val());
	} else{
		var od_temp_point = 0;
	}
	var de_point_settle = parseInt("<?=$default[de_point_settle]?>");
	
	//console.log("od_amount = "+od_amount+", od_send_cost = "+od_send_cost+", slt_cpn_amt = "+slt_cpn_amt+", od_temp_point = "+od_temp_point);
	//console.log(od_amount - (od_send_cost+slt_cpn_amt+od_temp_point));

	if(od_amount - (od_send_cost+slt_cpn_amt+od_temp_point) <= 0){
		alert("결제 총액은 0보다 작을 수 없습니다.");
		return false;

	} else if (od_temp_point > 0 && od_temp_point < de_point_settle){
		//console.log("od_temp_point = "+od_temp_point+", de_point_settle = "+de_point_settle);
		
		alert("적립금은 최소 "+de_point_settle+" 이상일 때 결제가 가능합니다.");
		return false;
	}

    return true;
}

// 구매자 정보와 동일합니다.
function gumae2baesong(f)
{
    f.od_b_name.value = f.od_name.value;
    //f.od_b_tel.value  = f.od_tel.value;
    f.od_b_hp.value   = f.od_hp.value;
    f.od_b_zip1.value = f.od_zip1.value;
    //f.od_b_zip2.value = f.od_zip2.value;
    f.od_b_addr1.value = f.od_addr1.value;
    f.od_b_addr2.value = f.od_addr2.value;
}

// 구매자 정보와 동일합니다.
function gumae2baesong2(obj, f)
{
	var p = $(obj).closest("table");
	p.find(".md_b_name").val(f.od_name.value);
	p.find(".md_b_hp").val(f.od_hp.value);
	p.find(".md_b_zip1").val(f.od_zip1.value);
	p.find(".md_b_addr1").val(f.od_addr1.value);
	p.find(".md_b_addr2").val(f.od_addr2.value);

    
}



$(function(){

    $(".btn_settlecase input[type='radio']").change(function(){
        $(".btn_settlecase input[type='radio']").closest(".btn_settlecase").removeClass("on");
        $(".btn_settlecase input[type='radio']:checked").closest(".btn_settlecase").addClass("on");

        //무통장입금이면 계좌번호/예금주 입력창 표시
        var sc = $(":radio[name='od_settle_case']:checked").val();
        if(sc == "무통장") { $(".bank_case").show(); } else {$(".bank_case").hide(); }
    });


	$("#od_temp_point").keypress(function(){
		var max_point = parseInt("<?=$max_point?>");
		var has_point = parseInt("<?=$has_point?>");
		var var_point = parseInt($("#od_temp_point").val());
		
		onlyNumber();

		if(var_point > has_point){
			alert("보유하신 적립금보다 높게 적립금을 입력할 수 없습니다.");
			$("#od_temp_point").val(has_point);
			return false;
		}else if(var_point > max_point){
			alert("총 금액보다 높게 적립금을 입력할 수 없습니다.");
			$("#od_temp_point").val(max_point);
			return false;
		}
	});
	
	$("#od_temp_point").blur(function(){
		var max_point = parseInt("<?=$max_point?>");
		var has_point = parseInt("<?=$has_point?>");
		var var_point = parseInt($("#od_temp_point").val());
		
		onlyNumber2(this);

		if(var_point > has_point){
			alert("보유하신 적립금보다 높게 적립금을 입력할 수 없습니다.");
			$("#od_temp_point").val(has_point);
			return false;
		}else if(var_point > max_point){
			alert("총 금액보다 높게 적립금을 입력할 수 없습니다.");
			$("#od_temp_point").val(max_point);
			return false;
		}
	});
});


//숫자만 입력받는다. "-"도 받지않는다.
function onlyNumber2(loc) {
    if(/[^0123456789-]/g.test(loc.value)) {
        alert("숫자가 아닙니다.\n\n0-9의 정수만 허용합니다.");
        loc.value = "";
        loc.focus();
    }

    /*
    if( $(loc).val().length >= 1 ){
        $(loc).val( number_format($(loc).val()) );
        console.log( number_format($(loc).val()) );
    }
    */
    

}
function onlyNumber() {
    if((event.keyCode > 31) && (event.keyCode < 45) || (event.keyCode > 57)) {
        event.preventDefault ? event.preventDefault() : (event.returnValue = false);
    }

}




//####################################################################################
//orderreceipt.php에서 뒤로가기시 데이터 셋팅
$(function(){

$.post("/shop/_ajax_get_ss_orderform.php", null, function(data){

    if(typeof(data) == "object") {
        set_orderform(data);    
    }

}, "json");

});

function set_orderform(data) {

$("input[name='od_name']").val(data["od_name"]);
$("input[name='od_hp']").val(data["od_hp"]);
$("input[name='od_zip']").val(data["od_zip"]);
$("input[name='od_addr1']").val(data["od_addr1"]);
$("input[name='od_addr2']").val(data["od_addr2"]);
$("input[name='od_email']").val(data["od_email"]);
$("select[name='od_hope_date'] > option[value='"+data["od_hope_date"]+"']").prop("selected", "selected");
$("input[name='od_temp_point']").val(data["od_temp_point"]);

if(data["coupon_amt"]) 
    coupon_set(data["coupon"], data["coupon_amt"]);

$("input:radio[name='od_settle_case']:input[value='"+data["od_settle_case"]+"']").closest(".btn_settlecase").click();

var dvCnt = parseInt(data["od_delivery_cnt"]);
$("#od_delivery_cnt > option[value='"+dvCnt+"']").prop("selected", "selected").change();

if(isNaN(dvCnt) || dvCnt == 1) {
    $("input[name='od_b_name']").val(data["od_b_name"]);
    $("input[name='od_b_hp']").val(data["od_b_hp"]);
    $("input[name='od_b_zip1']").val(data["od_b_zip1"]);
    $("input[name='od_b_addr1']").val(data["od_b_addr1"]);
    $("input[name='od_b_addr2']").val(data["od_b_addr2"]);
    $("textarea[name='od_memo']").val(data["od_memo"]);
} else {


    for(var i = 1 ; i <= dvCnt ; i++) {
        
        (function(idx){
            setTimeout(function() {
                $("input[name='md_b_name["+idx+"]']").val(data["md_b_name"][idx]);
                $("input[name='md_b_hp["+idx+"]']").val(data["md_b_hp"][idx]);
                $("input[name='md_b_zip1["+idx+"]']").val(data["md_b_zip1"][idx]);
                $("input[name='md_b_addr1["+idx+"]']").val(data["md_b_addr1"][idx]);
                $("input[name='md_b_addr2["+idx+"]']").val(data["md_b_addr2"][idx]);
                $("input[name='md_memo["+idx+"]']").val(data["md_memo"][idx]);

                var j = 0;                    
                $("select[name='md_qty["+idx+"][]']").each(function(){
                    var v = data["md_qty"][idx][j];
                    $(this).find('> option[value='+v+']').prop("selected", "selected");
                    j++;
                });

            }, 400);
        })(i);
        

    }
}

}
//orderreceipt.php에서 뒤로가기시 데이터 셋팅
//####################################################################################



</script>

<?
include_once("{$g4["path"]}/tail.sub.php");
?>