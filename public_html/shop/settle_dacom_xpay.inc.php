<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
	

	/*
     * [결제 인증요청 페이지(STEP2-1)]
     *
     * 샘플페이지에서는 기본 파라미터만 예시되어 있으며, 별도로 필요하신 파라미터는 연동메뉴얼을 참고하시어 추가 하시기 바랍니다.     
     */

    /*
     * 1. 기본결제 인증요청 정보 변경
     * 
     * 기본정보를 변경하여 주시기 바랍니다.(파라미터 전달시 POST를 사용하세요)
     */
    $CST_MID                    = $default[de_dacom_mid];		 //상점아이디(LG유플러스으로 부터 발급받으신 상점아이디를 입력하세요)

	if($CST_MID == "TEST" || $CST_MID == "test") {

        $CST_PLATFORM               ="test";                     //LG유플러스 결제 서비스 선택(test:테스트, service:서비스)
		$CST_MID = "lgdacomxpay";
        $LGD_MERTKEY = "95160cce09854ef44d2edb2bfb05f9f3";
        
	} else {

        $CST_PLATFORM               ="service";                     //LG유플러스 결제 서비스 선택(test:테스트, service:서비스)
	    $CST_MID                    = $default[de_dacom_mid];		 //상점아이디(LG유플러스으로 부터 발급받으신 상점아이디를 입력하세요)
        $LGD_MERTKEY				=  $default[de_dacom_mertkey];
        
    }

                                                                                 //테스트 아이디는 't'를 반드시 제외하고 입력하세요.
    $LGD_MID                    = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;   //상점아이디(자동생성)
    $LGD_OID                    =  $od[od_id]; //주문번호(상점정의 유니크한 주문번호를 입력하세요)
    $LGD_AMOUNT                 = $settle_amount; //결제금액("," 를 제외한 결제금액을 입력하세요)
    $LGD_BUYER                  = addslashes($od[od_name]); //구매자명
    $LGD_PRODUCTINFO            = $goods; //상품명
    $LGD_BUYEREMAIL             =  $od[od_email]; //구매자 이메일
    $LGD_OSTYPE_CHECK           = "P";                                           //값 P: XPay 실행(PC 결제 모듈): PC용과 모바일용 모듈은 파라미터 및 프로세스가 다르므로 PC용은 PC 웹브라우저에서 실행 필요. 
																				 //"P", "M" 외의 문자(Null, "" 포함)는 모바일 또는 PC 여부를 체크하지 않음
    //$LGD_ACTIVEXYN			= "N";											 //계좌이체 결제시 사용, ActiveX 사용 여부로 "N" 이외의 값: ActiveX 환경에서 계좌이체 결제 진행(IE)
																				 
    $LGD_CUSTOM_SKIN            = "red";                                         //상점정의 결제창 스킨



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
    $LGD_CUSTOM_USABLEPAY       = $LGD_PAYTYPE;//디폴트 결제수단 (해당 필드를 보내지 않으면 결제수단 선택 UI 가 노출됩니다.)



    $LGD_WINDOW_VER		        = "2.5";										 //결제창 버젼정보
    $LGD_WINDOW_TYPE            = "iframe";				 //결제창 호출방식 (수정불가)
    $LGD_CUSTOM_SWITCHINGTYPE   = "IFRAME";        //신용카드 카드사 인증 페이지 연동 방식 (수정불가)  
    $LGD_CUSTOM_PROCESSTYPE     = "TWOTR";                                       //수정불가
	
	$protocol = "https";
	if(!isset($_SERVER['HTTPS'])){
		$protocol = "http";
	}

	
	$portnum = "";
	if($_SERVER[SERVER_PORT] != "443" && $_SERVER[SERVER_PORT] != "80") {
		$portnum = ":{$_SERVER[SERVER_PORT]}";
	}
    /* 가상계좌(무통장) 결제 연동을 하시는 경우 아래 LGD_CASNOTEURL 을 설정하여 주시기 바랍니다. */    
    $LGD_CASNOTEURL				= "{$protocol}://{$_SERVER[HTTP_HOST]}{$portnum}/shop/settle_dacom_xpay_cas_noteurl.php";    

    /* LGD_RETURNURL 을 설정하여 주시기 바랍니다. 반드시 현재 페이지와 동일한 프로트콜 및  호스트이어야 합니다. 아래 부분을 반드시 수정하십시요. */    
    $LGD_RETURNURL				= "{$protocol}://{$_SERVER[HTTP_HOST]}{$portnum}/shop/settle_dacom_xpay_returnurl.php";  
    $configPath                 =  dirname($_SERVER['DOCUMENT_ROOT'])."/public_html/shop/lgdacom";    //LG유플러스에서 제공한 환경파일("/conf/lgdacom.conf") 위치 지정.     

	
    /*
     *************************************************
     * 2. MD5 해쉬암호화 (수정하지 마세요) - BEGIN
     * 
     * MD5 해쉬암호화는 거래 위변조를 막기위한 방법입니다. 
     *************************************************
     */
    require_once("./lgdacom/XPayClient.php");
    $xpay = new XPayClient($configPath, $CST_PLATFORM, $LGD_MERTKEY);
   	$xpay->Init_TX($LGD_MID);
	$LGD_TIMESTAMP = $xpay->GetTimeStamp(); 
    $LGD_HASHDATA = $xpay->GetHashData($LGD_MID,$LGD_OID,$LGD_AMOUNT,$LGD_TIMESTAMP);
    
    /*
     *************************************************
     * 2. MD5 해쉬암호화 (수정하지 마세요) - END
     *************************************************
     */

    $payReqMap['CST_PLATFORM']           = $CST_PLATFORM;				// 테스트, 서비스 구분
    $payReqMap['LGD_WINDOW_TYPE']        = $LGD_WINDOW_TYPE;			// 수정불가
    $payReqMap['CST_MID']                = $CST_MID;					// 상점아이디
    $payReqMap['LGD_MID']                = $LGD_MID;					// 상점아이디
    $payReqMap['LGD_OID']                = $LGD_OID;					// 주문번호
    $payReqMap['LGD_BUYER']              = $LGD_BUYER;					// 구매자
    $payReqMap['LGD_PRODUCTINFO']        = $LGD_PRODUCTINFO;			// 상품정보
    $payReqMap['LGD_AMOUNT']             = $LGD_AMOUNT;					// 결제금액
    $payReqMap['LGD_BUYEREMAIL']         = $LGD_BUYEREMAIL;				// 구매자 이메일
    $payReqMap['LGD_CUSTOM_SKIN']        = $LGD_CUSTOM_SKIN;			// 결제창 SKIN
    $payReqMap['LGD_CUSTOM_PROCESSTYPE'] = $LGD_CUSTOM_PROCESSTYPE;		// 트랜잭션 처리방식
    $payReqMap['LGD_TIMESTAMP']          = $LGD_TIMESTAMP;				// 타임스탬프
    $payReqMap['LGD_HASHDATA']           = $LGD_HASHDATA;				// MD5 해쉬암호값
    $payReqMap['LGD_RETURNURL']   		 = $LGD_RETURNURL;				// 응답수신페이지
    $payReqMap['LGD_VERSION']         	 = "PHP_Non-ActiveX_Standard";	// 버전정보 (삭제하지 마세요)
    $payReqMap['LGD_PAYTYPE']  	            =   $LGD_CUSTOM_USABLEPAY;	// 디폴트 결제수단
    $payReqMap['LGD_CUSTOM_USABLEPAY']  	= $LGD_CUSTOM_USABLEPAY;	// 디폴트 결제수단
	$payReqMap['LGD_CUSTOM_SWITCHINGTYPE']  = $LGD_CUSTOM_SWITCHINGTYPE;// 신용카드 카드사 인증 페이지 연동 방식
	$payReqMap['LGD_OSTYPE_CHECK']          = $LGD_OSTYPE_CHECK;        // 값 P: XPay 실행(PC용 결제 모듈), PC, 모바일 에서 선택적으로 결제가능 
	//$payReqMap['LGD_ACTIVEXYN']			= $LGD_ACTIVEXYN;			// 계좌이체 결제시 사용,ActiveX 사용 여부
    $payReqMap['LGD_WINDOW_VER'] 			= $LGD_WINDOW_VER;
	$payReqMap['LGD_DOMAIN_URL'] 			= "xpayvvip";

    
    // 가상계좌(무통장) 결제연동을 하시는 경우  할당/입금 결과를 통보받기 위해 반드시 LGD_CASNOTEURL 정보를 LG 유플러스에 전송해야 합니다 .
    $payReqMap['LGD_CASNOTEURL'] = $LGD_CASNOTEURL;               // 가상계좌 NOTEURL

    //Return URL에서 인증 결과 수신 시 셋팅될 파라미터 입니다.*/
    $payReqMap['LGD_RESPCODE']           = "";
    $payReqMap['LGD_RESPMSG']            = "";
    $payReqMap['LGD_PAYKEY']             = "";

    $_SESSION['PAYREQ_MAP'] = $payReqMap;
?>


<!-- test일 경우 -->
<?if($CST_PLATFORM == "test") {?>
<script language="javascript" src="https://pretest.uplus.co.kr:9443/xpay/js/xpay_crossplatform.js" type="text/javascript"></script>
<?} else {?>
<script language="javascript" src="https://xpayvvip.uplus.co.kr/xpay/js/xpay_crossplatform.js" type="text/javascript"></script>
<?}?>
<script type="text/javascript">

/*
* 수정불가.
*/
	var LGD_window_type = '<?= $LGD_WINDOW_TYPE ?>';
	
/*
* 수정불가
*/
function OpenWindow(){
	lgdwin = openXpay(document.getElementById('LGD_PAYINFO'), '<?= $CST_PLATFORM ?>', LGD_window_type, null, "", "");
}
/*
* FORM 명만  수정 가능
*/
function getFormObject() {
        return document.getElementById("LGD_PAYINFO");
}

/*
 * 인증결과 처리
 */
function payment_return() {
	var fDoc;
	
		fDoc = lgdwin.contentWindow || lgdwin.contentDocument;
	
		
	if (fDoc.document.getElementById('LGD_RESPCODE').value == "0000") {
		
			document.getElementById("LGD_PAYKEY").value = fDoc.document.getElementById('LGD_PAYKEY').value;
			document.getElementById("LGD_PAYINFO").target = "_self";
			document.getElementById("LGD_PAYINFO").action = "settle_dacom_xpay_payres.php";
			document.getElementById("LGD_PAYINFO").submit();
	} else {
		alert("LGD_RESPCODE (결과코드) : " + fDoc.document.getElementById('LGD_RESPCODE').value + "\n" + "LGD_RESPMSG (결과메시지): " + fDoc.document.getElementById('LGD_RESPMSG').value);
		closeIframe();
	}
}
</script>



<form method="post" id="LGD_PAYINFO" action ="settle_dacom_xpay_payres.php">

<!-- 사용자 변수 -->
<input type="hidden" name="on_uid"              value="<?=$_SESSION[ss_temp_on_uid]?>"/>

<?
  foreach ($payReqMap as $key => $value) {
    echo "<input type='hidden' name='$key' id='$key' value='$value'>";
  }
  //var_dump($_SESSION);
?>
<input type="hidden" name="LGD_CASHRECEIPTYN"    value="N"/>
<input type="hidden" name="LGD_ENCODING"    value="UTF-8"/>
<input type="hidden" name="LGD_ENCODING_RETURNURL"    value="UTF-8"/>
<input type="hidden" name="LGD_INSTALLRANGE"    value="0:2:3:4:5:6:7:8:9:10:11:12"/>


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



</form>

