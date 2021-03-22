<?php
include_once("./_common.php");

//print_r2($_POST); exit;

/* INIsecurepay.php
 *
 * 이니페이 플러그인을 통해 요청된 지불을 처리한다.
 * 지불 요청을 처리한다.
 * 코드에 대한 자세한 설명은 매뉴얼을 참조하십시오.
 * <주의> 구매자의 세션을 반드시 체크하도록하여 부정거래를 방지하여 주십시요.
 * 실시간 계좌이체 지불인 경우 이체결과 수신 WEB프로그램(INIpayresult.php)를 이용하여
 * 지불결과(이체결과) 데이타를 수신받도록 하십시요
 *  
 * http://www.inicis.com
 * Copyright (C) 2002 Inicis, Co. All rights reserved.
 */

	/**************************
	 * 1. 라이브러리 인클루드 *
	 **************************/
	require("./settle_inicis_INIpay41Lib.php");

    /***************************************
	 * 2. INIpay41 클래스의 인스턴스 생성 *
	 ***************************************/
	$inipay = new INIpay41;

    

	/*********************
	 * 3. 지불 정보 설정 *
	 *********************/
    // 이니페이 홈디렉터리를 만든다.
	//$inipay->m_inipayHome = str_replace("{$doc}", "", __FILE__) . "INIpay41"; // 이니페이 홈디렉터리
	$inipay->m_inipayHome = "$g4[shop_path]/INIpay41_escrow"; // 이니페이 홈디렉터리
	$inipay->m_type = "securepay"; // 고정
	$inipay->m_pgId = "IniTechPG_"; // 고정
	$inipay->m_subPgIp = "203.238.3.10"; // 고정
	$inipay->m_keyPw = $default[de_inicis_passwd]; // 키패스워드(상점아이디에 따라 변경)
	$inipay->m_debug = "true"; // 로그모드("true"로 설정하면 상세로그가 생성됨.)
	$inipay->m_mid = $mid; // 상점아이디
	$inipay->m_uid = $uid; // INIpay User ID
	$inipay->m_uip = getenv("REMOTE_ADDR"); // 고정
	$inipay->m_goodName = $goodname;
	$inipay->m_currency = $currency;
	$inipay->m_price = $price;
	$inipay->m_buyerName = $buyername;
	$inipay->m_buyerTel = $buyertel;
	$inipay->m_buyerEmail = $buyeremail;
	$inipay->m_recvName = $recvname;
	$inipay->m_recvTel = $recvtel;
	$inipay->m_recvAddr = $recvaddr;
	$inipay->m_recvPostNum = $recvpostnum;
	$inipay->m_recvMsg = $recvmsg;
	$inipay->m_payMethod = $paymethod;
	$inipay->m_encrypted = $encrypted;
	$inipay->m_sessionKey = $sessionkey;
	$inipay->m_url = $g4[url];
	$inipay->m_merchantReserved1 = $on_uid; // 예비1
	$inipay->m_merchantReserved2 = "merchantreserved2"; // 예비2
	$inipay->m_merchantReserved3 = "merchantreserved3"; // 예비3
	$inipay->m_cardcode = $cardcode; // 카드코드 리턴
	
	/****************
	 * 4. 지불 요청 *
	 ****************/
	$inipay->startAction();
	
	
	/*******************************************************************
	 * 5. 지불 결과                                                    *
	 *                                                                 *
	 * 거래번호 : $inipay->m_tid                                       *
	 * 결과코드 : $inipay->m_resultCode ("00"이면 지불 성공)           *
	 * 결과내용 : $inipay->m_resultMsg (지불결과에 대한 설명)          *
	 * 지불방법 : $inipay->m_payMethod (매뉴얼 참조)                   *
	 * OK Cashbag 복합결재시 신용카드 지불금액 : $inipay->m_price1     *
	 * OK Cashbag 복합결재시 포인트 지불금액 : $inipay->m_price2       *
	 * 신용카드 승인번호 : $inipay->m_authCode                         *
	 * 할부기간 : $inipay->m_cardQuota                                 *
	 * 무이자할부 여부 : $inipay->m_quotaInterest ("1"이면 무이자할부) *
	 * 신용카드사 코드 : $inipay->m_cardCode (매뉴얼 참조)             *
	 * 카드발급사 코드 : $inipay->m_cardIssuerCode (매뉴얼 참조)       *
	 * 본인인증 수행여부 : $inipay->m_authCertain ("00"이면 수행)      *
	 * 이니시스 승인날짜 : $inipay->m_pgAuthDate (YYYYMMDD)            *
	 * 이니시스 승인시각 : $inipay->m_pgAuthTime (HHMMSS)              *
	 * OK Cashbag 적립 승인번호 : $inipay->m_ocbSaveAuthCode           *
	 * OK Cashbag 사용 승인번호 : $inipay->m_ocbUseAuthCode            *
	 * OK Cashbag 승인일시 : $inipay->m_ocbAuthDate (YYYYMMDDHHMMSS)   *
	 * 각종 이벤트 적용 여부 : $inipay->m_eventFlag                    *
	 * 가상계좌 채번에 사용된 주민번호 : $inipay->m_perno              *
	 * 상품 주문번호 : $inipay->m_oid                                  *
	 * 가상계좌 번호 : $inipay->m_vacct                                *
	 * 입금할 은행 코드 : $inipay->m_vcdbank                           *
	 * 입금예정일 : $inipay->m_dtinput (YYYYMMDD)                      *
	 * 송금자 명 : $inipay->m_nminput                                  *
	 * 예금주 명 : $inipay->m_nmvacct                                  *
	 * 휴대폰 번호 : $inipay->m_nohpp                                  *
     * 전화번호 : $inipay->m_noars (ARS 결제후 리턴되는 전화번호)      *
     *******************************************************************/

$abank = array();
$abank['01'] = '한국은행';
$abank['02'] = '한국산업은행';
$abank['03'] = '기업은행'; 
$abank['04'] = '국민은행'; 
$abank['05'] = '외환은행'; 
$abank['07'] = '수협중앙회'; 
$abank['11'] = '농협중앙회'; 
$abank['12'] = '단위농협'; 
$abank['16'] = '축협중앙회'; 
$abank['20'] = '우리은행'; 
$abank['21'] = '조흥은행'; 
$abank['22'] = '상업은행'; 
$abank['23'] = '제일은행'; 
$abank['24'] = '한일은행'; 
$abank['25'] = '서울은행'; 
$abank['26'] = '신한은행'; 
$abank['27'] = '한미은행'; 
$abank['31'] = '대구은행'; 
$abank['32'] = '부산은행'; 
$abank['34'] = '광주은행'; 
$abank['35'] = '제주은행'; 
$abank['37'] = '전북은행'; 
$abank['38'] = '강원은행'; 
$abank['39'] = '경남은행'; 
$abank['41'] = '비씨카드'; 
$abank['53'] = '씨티은행'; 
$abank['54'] = '홍콩상하이은행'; 
$abank['71'] = '우체국'; 
$abank['81'] = '하나은행'; 
$abank['83'] = '평화은행';
$abank['93'] = '새마을금고';

    if ($inipay->m_resultCode != "00") {
        alert("지불 실패 {$inipay->m_resultCode} : {$inipay->m_resultMsg}");
    }

    $ymd = sprintf("%s-%s-%s", substr($inipay->m_pgAuthDate,0,4), substr($inipay->m_pgAuthDate,4,2), substr($inipay->m_pgAuthDate,6,2));
    $hms = sprintf("%s:%s:%s", substr($inipay->m_pgAuthTime,0,2), substr($inipay->m_pgAuthTime,2,2), substr($inipay->m_pgAuthTime,4,2));

    // 신용카드내역에 생성
    $sql = "insert $g4[yc4_card_history_table]
               set od_id = '$od_id',
                   on_uid = '$on_uid',
                   cd_mall_id = '{$inipay->m_mid}',
                   cd_amount = '{$inipay->m_price}',
                   cd_app_no = '{$inipay->m_authCode}',
                   cd_app_rt = '{$inipay->m_resultCode}',
                   cd_trade_ymd = CURDATE(),
                   cd_trade_hms = CURTIME(),
                   cd_opt01 = '{$inipay->m_buyerName}',
                   cd_time = '$g4[time_ymdhis]',
                   cd_ip = '$_SERVER[REMOTE_ADDR]' ";
	sql_query($sql);
	
	// 장바구니 '준비' 상태로 변경
	$sql = " update $g4[yc4_cart_table]
		set ct_status = '준비'
	where on_uid = '$on_uid' ";
	sql_query($sql, TRUE);


    // 주문서의 카드입금 수정
    // 크래킹의 우려도 있으므로 on_uid 도 같이
    $sql = " update $g4[yc4_order_table] ";
    if ($gopaymethod == 'onlycard')
    {
        $sql .= " set od_receipt_card = '{$inipay->m_price}',
                      od_card_time = '$g4[time_ymdhis]' ";
    }
    else if ($gopaymethod == 'onlydbank')
    {
        $sql .= " set od_receipt_bank = '{$inipay->m_price}',
                      od_bank_time = '$g4[time_ymdhis]' ";
    }
    else if ($gopaymethod == 'onlyvbank')
    {
        $sql .= " set od_bank_account = '{$abank[$inipay->m_vcdbank]} {$inipay->m_vacct}' ";
    }
    
    if ($inipay->m_tid)
        $sql .= " , od_escrow1 = '{$inipay->m_tid}' ";

    $sql .= " where od_id = '$od_id' and on_uid = '$on_uid' ";
    sql_query($sql);

	/*******************************************************************
	 * 7. 강제취소                                                     *
	 *                                                                 *
	 * 지불 결과를 DB 등에 저장하거나 기타 작업을 수행하다가 실패하는  *
	 * 경우, 아래의 코드를 참조하여 이미 지불된 거래를 취소하는 코드를 *
	 * 작성합니다.                                                     *
	 *******************************************************************/
	/*
	var $cancelFlag = "false";

	// $cancelFlag를 "ture"로 변경하는 condition 판단은 개별적으로
	// 수행하여 주십시오.

	if($cancelFlag == "true")
	{
		$inipay->m_type = "cancel"; // 고정
		$inipay->m_msg = "DB FAIL"; // 취소사유
		$inipay->startAction();
		if($inipay->m_resultCode == "00")
		{
			$inipay->m_resultCode = "01";
			$inipay->m_resultMsg = "DB FAIL";
		}
	}
	*/
?>
<script>
	var openwin=window.open("<?=$g4[shop_url]?>/ordercard_es_inicischildwin.php","childwin","width=300,height=160");
	openwin.close();
	
	function show_receipt(tid)
	{
		if("<?php echo ($inipay->m_resultCode); ?>" == "00")
		{
			var receiptUrl = "https://iniweb.inicis.com/mall/cr/cm/mCmReceipt_head.jsp?noTid=" + "<?php echo($inipay->m_tid); ?>" + "&noMethod=1";
			window.open(receiptUrl,"receipt","width=428,height=741");
		}
		else
		{
			alert("해당하는 지불 거래가 없습니다");
		}
	}
</script>
<?
//gotourl("./?doc=$cart_dir/ordericheresult.php&on_uid=$on_uid");
goto_url("./settleresult.php?on_uid=$on_uid");
?>
