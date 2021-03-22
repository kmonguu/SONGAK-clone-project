<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// LG텔레콤 결제창 호출시 넘겨주는 파라메터에 대한 암호화 적용
$hashdata = md5($default[de_dacom_mid].$od[od_id].$settle_amount.$default[de_dacom_mertkey]);
?>

<form name="mainForm" method="POST" action="">
<!-- 결제를 위한 필수 hidden정보 -->
<input type="hidden" name="hashdata" value="<?=$hashdata?>">
<input type="hidden" name="mid" value="<?=$default[de_dacom_mid]?>">
<input type="hidden" name="oid" value="<?=$od[od_id]?>">
<input type="hidden" name="amount" value="<?=$settle_amount?>">
<input type="hidden" name="ret_url" value="<?="$g4[shop_url]/settleresult.php?on_uid=$_SESSION[ss_temp_on_uid]"?>">
<input type="hidden" name="note_url" value="<?="$g4[shop_url]/settle_dacom_noteurl.php?on_uid=$_SESSION[ss_temp_on_uid]"?>">
<input type="hidden" name="buyer" value="<?=addslashes($od[od_name])?>">
<input type="hidden" name="buyerid" value="<?=$od[mb_id]?>">
<input type="hidden" name="buyeraddress" value="<?=addslashes($od[od_addr1])?> <?=addslashes($od[od_addr2])?>">
<input type="hidden" name="buyerphone" value="<?=$od[od_tel]?>">
<input type="hidden" name="buyeremail" value="<?=$od[od_email]?>">
<input type="hidden" name="productinfo" value="<?=$goods?>">
<input type="hidden" name="pid" value="">
<input type="hidden" name="buyerssn" value="">

<input type="hidden" name="receiver" value="<?=addslashes($od[od_b_name])?>">
<input type="hidden" name="receiverphone" value="<?=$od[od_b_tel]?>">

<input type="hidden" name="deliveryinfo" value="<?=addslashes($od[od_b_addr1])?> <?=addslashes($od[od_b_addr2])?>">

<!-- 에스크로 시작 -->
<?
$sqlx = " select a.it_id,
                a.ct_amount,
                a.ct_qty,
                b.it_name
           from $g4[yc4_cart_table] a, 
                $g4[yc4_item_table] b
          where a.on_uid = '$s_on_uid'
            and a.it_id  = b.it_id
          order by a.ct_id ";
$resultx = sql_query($sqlx);
for ($i=1; $rowx=sql_fetch_array($resultx); $i++) {
    echo "<input type='hidden' name='escrow_good_id' value='$i'>\n";
    echo "<input type='hidden' name='escrow_good_name' value=\"".get_text(htmlspecialchars2($rowx[it_name]))."\">\n";
    echo "<input type='hidden' name='escrow_good_code' value='$rowx[it_id]'>\n";
    echo "<input type='hidden' name='escrow_unit_price' value='$rowx[ct_amount]'>\n";
    echo "<input type='hidden' name='escrow_quantity' value='$rowx[ct_qty]'>\n";
}
echo "<input type='hidden' name='escrow_zipcode' value='$od[od_b_zip1]$od[od_b_zip2]'>\n";
echo "<input type='hidden' name='escrow_address1' value='".addslashes($od[od_b_addr1])."'>\n";
echo "<input type='hidden' name='escrow_address2' value='".addslashes($od[od_b_addr2])."'>\n";
echo "<input type='hidden' name='escrow_buyermobile' value='$od[od_b_tel2]'>\n";
?>
<input type="hidden" name="escrowflag" value="Y">
<!-- 에스크로 끝 -->
<input type="hidden" name="taxUseYN" value="Y"> <!-- 현금영수증 표시 : N, 미표시 : Y -->
</form>

<script language="javascript">
<!--
function OpenWindow()
{
    var jumin = '';
    var settle_case = '<?=$settle_case?>';

    if (settle_case == '계좌이체')
        jumin = prompt("주민등록번호 13자리를 '-' 없이 입력하십시오.\n계좌이체 결제시 주민등록번호를 요구하며 따로 저장하지는 않습니다.", "");
    
    if ((settle_case == '계좌이체' && !(jumin == null || jumin == "")) || settle_case != '계좌이체') { 
        document.mainForm.pid.value = jumin;
        document.mainForm.buyerssn.value = jumin;

        window.open("", "Window", "width=510, height=700, scrollbars=0");

        // Test ID로 테스트시 테스트용 URL로 테스트 하셔야 합니다.
        <? 
        if (preg_match("/^tsi_/", $default[de_dacom_mid]))
        {
            if ($settle_case == '신용카드')
                $action = 'http://pg.dacom.net:7080/card/cardAuthAppInfo.jsp';
            else if ($settle_case == '계좌이체')
                $action = "http://pg.dacom.net:7080/transfer/transferSelectBank.jsp";
            else if ($settle_case == '가상계좌')
                $action = "http://pg.dacom.net:7080/cas/casRequestSA.jsp";
        }
        else
        {
            if ($settle_case == '신용카드')
                $action = 'http://pg.dacom.net/card/cardAuthAppInfo.jsp';
            else if ($settle_case == '계좌이체')
                $action = "http://pg.dacom.net/transfer/transferSelectBank.jsp";
            else if ($settle_case == '가상계좌')
                $action = "http://pg.dacom.net/cas/casRequestSA.jsp";
        }
        ?>

        document.mainForm.action  = "<?=$action?>";
        document.mainForm.target = "Window";
        document.mainForm.submit();
    }
}
-->
</script>

<script type="text/javascript">
// LG텔레콤 권고 : 소스보기 방지 스크립트
document.onkeydown=KeyEventHandle;
document.onkeyup=KeyEventHandle;
document.oncontextmenu = MouseEventHandle;

function KeyEventHandle() {
    if((event.ctrlKey == true && (event.keyCode == 78 || event.keyCode == 82)) || (event.keyCode >= 112 && event.keyCode <= 123)) {
        event.keyCode = 0;
        event.cancelBubble = true;
        event.returnValue = false;
    }
}
function MouseEventHandle() {
    return false;
}
</script>