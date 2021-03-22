<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>

<script language="javascript">
function on_load()
{
	curr_date	= new Date();
	year        = curr_date.getYear();
	month       = curr_date.getMonth();
	day         = curr_date.getDay();
	hours       = curr_date.getHours();
	mins        = curr_date.getMinutes();
	secs        = curr_date.getSeconds();

	/* 회원사에서 사용하는 주문번호를 이용하는 경우에는 다음을 주석처리 하세요
	   주석처리하신 경우에는 form tag중 P_OID에 값을 넘겨주셔야 합니다 */
	document.btpg_form.P_OID.value = year.toString() + month.toString() + day.toString() + hours.toString() + mins.toString() + secs.toString();
}

function on_click_card_pay()
{
	myform = document.btpg_form;
	window.name = "BTPG_CLIENT";
	BTPG_WALLET = window.open("", "BTPG_WALLET", "width=450,height=500");
    BTPG_WALLET.focus;
	myform.target = "BTPG_WALLET";
	myform.action = "http://pg.banktown.com/mywallet/card/";
	myform.submit();
}

function on_click_bank_pay()
{
	myform = document.btpg_form;
	window.name = "BTPG_CLIENT";
	BTPG_WALLET = window.open("", "BTPG_WALLET", "width=450,height=500");
        BTPG_WALLET.focus();
	myform.target = "BTPG_WALLET";
	myform.action = "http://pg.banktown.com/mywallet/bank/"; 
	myform.submit();
}

function on_click_ktcard_pay()
{              
    myform = document.btpg_form;              
    window.name = "BTPG_CLIENT";
    BTPG_WALLET = window.open("", "BTPG_WALLET", "width=450,height=500");               
    BTPG_WALLET.focus;               
    myform.target = "BTPG_WALLET";
    myform.action = "http://pg.banktown.com/mywallet/ktcard/";               
    myform.btn_card_pay.disabled = true;               
    myform.btn_bank_pay.disabled = true;               
    myform.submit();
}


function on_click_mobile()
{
    myform = document.btpg_form;
    window.name = "BTPG_CLIENT";
    BTPG_WALLET = window.open("", "BTPG_WALLET", "width=450,height=500");
    BTPG_WALLET.focus();
    myform.target = "BTPG_WALLET";
    myform.action = "http://pg.banktown.com/mywallet/cellular/"; 
    myform.btn_card_pay.disabled = true;               
    myform.btn_bank_pay.disabled = true;               
    myform.submit();
}

function OpenWindow()
{
    var settle_case = '<?=$settle_case?>';

    if (settle_case == '계좌이체') {
        on_click_bank_pay();
        /*
        var jumin = prompt("주민등록번호 13자리를 '-' 없이 입력하십시오.\n실시간 계좌이체의 경우 주민등록번호를 요구하며 저장하지는 않습니다.", "");
        
        if (!(jumin == null || jumin == "")) { 
            document.mainForm.pid.value = jumin;

            window.open("", "Window", "width=510, height=700, scrollbars=0");

            // Test ID로 테스트시 테스트용 URL로 테스트 하셔야 합니다.
            <? if ($default[de_dacom_test]) { ?>
                document.mainForm.action  = "http://pg.dacom.net:7080/transfer/transferSelectBank.jsp";
            <? } else { ?>
                document.mainForm.action  = "http://pg.dacom.net/transfer/transferSelectBank.jsp";
            <? } ?>

            document.mainForm.target = "Window";
            document.mainForm.submit();
        }
        */
    } else if (settle_case == '신용카드') {
        on_click_card_pay();
    } else {
        alert('지원하지 않는 결제방식입니다.');
    }
}
</script>

<form name="btpg_form" method="post">
<input type="hidden" name="P_MID" value="<?=$default[de_banktown_mid]?>">
<input type="hidden" name="P_NOTEURL" value="<?=$g4[shop_url]?>/settle_banktown_rnoti.php"> <!-- "http://www.***.com/rnoti.php" -->
<input type="hidden" name="P_NEXT_URL" value="<?=$g4[shop_url]?>/settle_banktown_result.php"> <!-- "http://www.***.com/pay_result.php" -->
<input type="hidden" name="P_CANC_URL" value=""> <!-- "http://www.***.com/pay_result.php" -->
<input type="hidden" name="P_IPOS_VER" value="3.0">
<input type="hidden" name="P_IPOS_IP" value="<?=$_SERVER[SERVER_ADDR]?>">
<input type="hidden" name="P_ACTION" value="0">
<input type="hidden" name="P_WALLET_TYPE" value="POPUP">
<input type="hidden" name="P_EMAIL" value="<?=$od[od_email]?>">
<input type="hidden" name="P_MOBILE" value="<?=$od[od_hp]?>">
<input type="hidden" name="P_GOODS" value="<?=$goods?>">
<input type="hidden" name="P_OID" value="<?=$od[od_id]?>"> <!-- P_OID를 회원사에서 직접넘겨주는 경우에 함수 on_load()에서 주문번호 넣는 부분을 주석처리하시기 바랍니다 -->
<input type="hidden" name="P_AMT" value="<?=$settle_amount?>">
<input type="hidden" name="P_NOTI" value="<?="name1=$od[od_name],name2=$_SESSION[ss_temp_on_uid]"?>">
<input type="hidden" name="P_MNAME" value="">
<input type="hidden" name="P_UNAME" value="<?=$od[od_name]?>">
<input type="hidden" name="P_TARGET">

<input type="hidden" name="P_RECP_NAME" value="<?=$od[od_b_name]?>">
<input type="hidden" name="P_RECP_ADDR" value="<?=$od[od_b_addr1].' '.$od[od_b_addr2]?>">
<input type="hidden" name="P_RECP_PHONE" value="<?=$od[od_b_tel]?>">
<input type="hidden" name="P_RECP_MOBILE" value="<?=$od[od_b_hp]?>">
<input type="hidden" name="P_RECP_MAIL" value="">
</form>