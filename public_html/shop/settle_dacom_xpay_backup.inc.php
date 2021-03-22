<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

    /*
     * [상점결제요청 페이지(ActiveX)]
     *     
     * 기본 파라미터만 예시되어 있으며, 별도로 필요하신 파라미터는 연동메뉴얼을 참고하시어 추가하시기 바랍니다. 
     * hashdata 암호화는 거래 위변조를 막기위한 방법입니다. 
     *
     */

    /*
     * 1. 기본결제정보 변경
     *
     * 결제기본정보를 변경하여 주시기 바랍니다. 
     */
	$LGD_MID                = $default[de_dacom_mid];                   //상점아이디(자동생성)               
    $platform               = preg_match("/^tsi\_/", $LGD_MID) ? "test" : "service";    //LG텔레콤 결제서비스 선택(test:테스트, service:서비스)    
    $LGD_OID                = $od[od_id];                               //주문번호(상점정의 유니크한 주문번호를 입력하세요)
    $LGD_AMOUNT             = $settle_amount;                           //결제금액("," 를 제외한 결제금액을 입력하세요)
    $LGD_MERTKEY            = $default[de_dacom_mertkey];               //상점MertKey(mertkey는 상점관리자 -> 계약정보 -> 상점정보관리에서 확인하실수 있습니다)
    $LGD_TIMESTAMP          = $g4[server_time];                         //타임스탬프
    $LGD_BUYER              = addslashes($od[od_name]);                 //구매자명
    $LGD_PRODUCTINFO        = $goods;                                   //상품명
    $LGD_BUYEREMAIL         = $od[od_email];                            //구매자 이메일
    $LGD_CUSTOM_SKIN        = "red";      							    //상점정의 결제창 스킨 (red, blue, cyan, green, yellow)

    /*
     * 2. 결제결과 DB처리 페이지 링크 변경
     *
     * LGD_NOTEURL : 상점결제결과 처리(DB) 페이지 URL을 넘겨주세요.
     * LGD_CASNOTEURL : 가상계좌(무통장) 결제 연동을 하시는 경우 아래 LGD_CASNOTEURL 을 설정하여 주시기 바랍니다.
     */	
    $LGD_NOTEURL            = "$g4[shop_url]/settle_dacom_xpay_noteurl.php"; //상점결제결과 처리(DB) 페이지(URL을 변경해 주세요)
    $LGD_CASNOTEURL			= "$g4[shop_url]/settle_dacom_xpay_cas_noteurl.php";

    /*
     * 3. hashdata 암호화 (수정하지 마세요)
     *
     * hashdata 암호화 적용( LGD_MID + LGD_OID + LGD_AMOUNT + LGD_TIMESTAMP + LGD_MERTKEY )
     * LGD_MID : 상점아이디
     * LGD_OID : 주문번호
     * LGD_AMOUNT : 금액 
     * LGD_TIMESTAMP : 타임스탬프
     * LGD_MERTKEY : 상점키(mertkey)
     *
     * hashdata 검증을 위한 
     * LG텔레콤에서 발급한 상점키(MertKey)를 반드시 입력해 주시기 바랍니다.
     */   
    $LGD_HASHDATA = md5($LGD_MID.$LGD_OID.$LGD_AMOUNT.$LGD_TIMESTAMP.$LGD_MERTKEY);
?>

<script language = 'javascript'>
<!--
/*
 * 결제요청 및 결과화면 처리 
 */

//function doPay_ActiveX(){
function OpenWindow(){
    ret = xpay_check(document.getElementById('LGD_PAYINFO'), '<?= $platform ?>');
 
	if (ret=="00"){     //ActiveX 로딩 성공  
        var LGD_RESPCODE        = dpop.getData('LGD_RESPCODE');       	  //결과코드
        var LGD_RESPMSG         = dpop.getData('LGD_RESPMSG');        	  //결과메세지 
                      
        if( "0000" == LGD_RESPCODE ) { //결제성공
	        var LGD_TID             = dpop.getData('LGD_TID');            //LG텔레콤 거래번호
	        var LGD_OID             = dpop.getData('LGD_OID');            //주문번호 
	        var LGD_PAYTYPE         = dpop.getData('LGD_PAYTYPE');        //결제수단
	        var LGD_PAYDATE         = dpop.getData('LGD_PAYDATE');        //결제일자
	        var LGD_FINANCECODE     = dpop.getData('LGD_FINANCECODE');    //결제기관코드
	        var LGD_FINANCENAME     = dpop.getData('LGD_FINANCENAME');    //결제기관이름        
	        var LGD_FINANCEAUTHNUM  = dpop.getData('LGD_FINANCEAUTHNUM'); //결제사승인번호
	        var LGD_ACCOUNTNUM      = dpop.getData('LGD_ACCOUNTNUM');     //입금할 계좌 (가상계좌)
	        var LGD_BUYER           = dpop.getData('LGD_BUYER');          //구매자명
	        var LGD_PRODUCTINFO     = dpop.getData('LGD_PRODUCTINFO');    //상품명
	        var LGD_AMOUNT          = dpop.getData('LGD_AMOUNT');         //결제금액
            var LGD_NOTEURL_RESULT  = dpop.getData('LGD_NOTEURL_RESULT'); //상점DB처리(LGD_NOTEURL)결과 ('OK':정상,그외:실패)

	        //메뉴얼의 결제결과 파라미터내용을 참고하시어 필요하신 파라미터를 추가하여 사용하시기 바랍니다. 
	                     
            var msg = "결제결과 : " + LGD_RESPMSG + "\n";            
            msg += "LG텔레콤거래TID : " + LGD_TID +"\n";
                                    
            if( LGD_NOTEURL_RESULT != "null" ) msg += LGD_NOTEURL_RESULT +"\n";
            //alert(msg);
 
            document.getElementById('LGD_RESPCODE').value = LGD_RESPCODE;
            document.getElementById('LGD_RESPMSG').value = LGD_RESPMSG;
            document.getElementById('LGD_TID').value = LGD_TID;
            document.getElementById('LGD_OID').value = LGD_OID;
            document.getElementById('LGD_PAYTYPE').value = LGD_PAYTYPE;
            document.getElementById('LGD_PAYDATE').value = LGD_PAYDATE;
            document.getElementById('LGD_FINANCECODE').value = LGD_FINANCECODE;
            document.getElementById('LGD_FINANCENAME').value = LGD_FINANCENAME;
            document.getElementById('LGD_FINANCEAUTHNUM').value = LGD_FINANCEAUTHNUM;
            document.getElementById('LGD_ACCOUNTNUM').value = LGD_ACCOUNTNUM;
            document.getElementById('LGD_BUYER').value = LGD_BUYER;
            document.getElementById('LGD_PRODUCTINFO').value = LGD_PRODUCTINFO;
            document.getElementById('LGD_AMOUNT').value = LGD_AMOUNT;
              
            document.getElementById('LGD_PAYINFO').submit();
     
        } else { //결제실패
            alert("결제가 실패하였습니다. " + LGD_RESPMSG);
        }
    } else {
            alert("LG텔레콤 전자결제를 위한 ActiveX 설치 실패");
    }     
}
       
//-->
</script>

<form method="post" id="LGD_PAYINFO" action ="settleresult.php">

<!-- 사용자 변수 -->
<input type="hidden" name="on_uid"              value="<?=$_SESSION[ss_temp_on_uid]?>"/>

<?
$LGD_PAYTYPE = "";
switch ($settle_case)
{
    case '계좌이체' :
        $LGD_PAYTYPE = "SC0030";
        break;
    case '가상계좌' :
        $LGD_PAYTYPE = "SC0040";
        break;
    case '휴대폰' :
        $LGD_PAYTYPE = "SC0060";
        break;
    default : // 신용카드
        $LGD_PAYTYPE = "SC0010";
        break;
}
?>
<input type="hidden" name="LGD_PAYTYPE"          value="<?= $LGD_PAYTYPE ?>"/>
<input type="hidden" name="LGD_CUSTOM_USABLEPAY" value="<?= $LGD_PAYTYPE ?>"/>
<input type="hidden" name="LGD_CASHRECEIPTYN"    value="N"/>

<input type="hidden" name="LGD_MID"             value="<?= $LGD_MID ?>"/>                        				<!-- 상점아이디 -->
<input type="hidden" name="LGD_OID"             id = 'LGD_OID'              value="<?= $LGD_OID ?>"/>           <!-- 주문번호 -->
<input type="hidden" name="LGD_BUYER"           id = 'LGD_BUYER'            value="<?= $LGD_BUYER ?>"/>         <!-- 구매자 -->
<input type="hidden" name="LGD_PRODUCTINFO"     id = 'LGD_PRODUCTINFO'      value="<?= $LGD_PRODUCTINFO ?>"/>   <!-- 상품정보 -->
<input type="hidden" name="LGD_AMOUNT"          id = 'LGD_AMOUNT'           value="<?= $LGD_AMOUNT ?>"/>        <!-- 결제금액 -->
<input type="hidden" name="LGD_BUYEREMAIL"      value="<?= $LGD_BUYEREMAIL ?>"/>                 				<!-- 구매자 이메일 -->
<input type="hidden" name="LGD_CUSTOM_SKIN"     value="<?= $LGD_CUSTOM_SKIN ?>"/>                									<!-- 결제창 SKIN -->
<input type="hidden" name="LGD_TIMESTAMP"       value="<?= $LGD_TIMESTAMP ?>"/>                  				<!-- 타임스탬프 -->
<input type="hidden" name="LGD_HASHDATA"        value="<?= $LGD_HASHDATA ?>"/>                   				<!-- MD5 해쉬암호값 -->
<input type="hidden" name="LGD_NOTEURL"			value="<?= $LGD_NOTEURL ?>"/>                    				<!-- 결제결과 수신페이지 URL --> 
<input type="hidden" name="LGD_VERSION"         value="PHP_XPay_lite_1.0"/>			        					<!-- 버전정보 (삭제하지 마세요) -->

<input type="hidden" name="LGD_TID"			    id = 'LGD_TID'              value=""/>
<input type="hidden" name="LGD_PAYTYPE"	        id = 'LGD_PAYTYPE'		    value=""/>
<input type="hidden" name="LGD_PAYDATE"	        id = 'LGD_PAYDATE'		    value=""/>
<input type="hidden" name="LGD_FINANCECODE"	    id = 'LGD_FINANCECODE'		value=""/>
<input type="hidden" name="LGD_FINANCENAME"	    id = 'LGD_FINANCENAME'		value=""/>
<input type="hidden" name="LGD_FINANCEAUTHNUM"	id = 'LGD_FINANCEAUTHNUM'	value=""/> 
<input type="hidden" name="LGD_ACCOUNTNUM"	    id = 'LGD_ACCOUNTNUM'		value=""/>                   
<input type="hidden" name="LGD_RESPCODE"        id = 'LGD_RESPCODE'         value=""/>
<input type="hidden" name="LGD_RESPMSG"         id = 'LGD_RESPMSG'          value=""/>

<input type="hidden" name="LGD_CASNOTEURL"		value="<?= $LGD_CASNOTEURL ?>"/>                                <!-- 가상계좌 NOTEURL -->

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
    echo "<input type='hidden' name='LGD_ESCROW_GOODID' value='$i'>\n";
    echo "<input type='hidden' name='LGD_ESCROW_GOODNAME' value=\"".get_text(htmlspecialchars2($rowx[it_name]))."\">\n";
    echo "<input type='hidden' name='LGD_ESCROW_GOODCODE' value='$rowx[it_id]'>\n";
    echo "<input type='hidden' name='LGD_ESCROW_UNITPRICE' value='$rowx[ct_amount]'>\n";
    echo "<input type='hidden' name='LGD_ESCROW_QUANTITY' value='$rowx[ct_qty]'>\n";
}
echo "<input type='hidden' name='LGD_ESCROW_ZIPCODE' value='$od[od_b_zip1]$od[od_b_zip2]'>\n";
echo "<input type='hidden' name='LGD_ESCROW_ADDRESS1' value='".addslashes($od[od_b_addr1])."'>\n";
echo "<input type='hidden' name='LGD_ESCROW_ADDRESS2' value='".addslashes($od[od_b_addr2])."'>\n";
echo "<input type='hidden' name='LGD_ESCROW_BUYERPHONE' value='$od[od_b_hp]'>\n";
?>
<input type="hidden" name="LGD_ESCROW_USEYN" value="Y">
<!-- 에스크로 끝 -->
<input type="hidden" name="LGD_CASHRECEIPTYN" value="N"> <!-- 현금영수증 표시 : N, 미표시 : Y -->

</form>



<? if (strtolower($g4[charset]) == 'euc-kr') { ?>
<script language="javascript" src="<?= isset($_SERVER['HTTPS']) ?"https":"http" ?>://xpay.lgdacom.net<?=($platform == "test")?(!isset($_SERVER['HTTPS'])?":7080":":7443"):""?>/xpay/js/xpay.js" type="text/javascript"></script>
<? } else { ?>
<script language="javascript" src="<?= isset($_SERVER['HTTPS']) ?"https":"http" ?>://xpay.lgdacom.net<?=($platform == "test")?(!isset($_SERVER['HTTPS'])?":7080":":7443"):""?>/xpay/js/xpay_utf-8.js" type="text/javascript"></script>
<? } ?>

