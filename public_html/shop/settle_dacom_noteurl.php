<?php
include_once("./_common.php");

$de_dacom_mertkey = $default['de_dacom_mertkey'];

//이 페이지는 수정하지 마십시요. 수정시 html태그나 자바스크립트가 들어가는 경우 동작을 보장할 수 없습니다.
//관련 db처리는 write.php에서 참조하는 함수 write_success(),write_failure(),write_hasherr()에서 관련 루틴을 추가하시면 됩니다.
//위의 각 함수에는 현재 결제에 관한 log남기게 됩니다. 상점서버에서 남기실 절대경로로 맞게 수정하여 주세요

//hash데이타값이 맞는 지 확인 하는 루틴은 LG텔레콤에서 받은 데이타가 맞는지 확인하는 것이므로 꼭 사용하셔야 합니다
//정상적인 결제 건임에도 불구하고 노티 페이지의 오류나 네트웍 문제 등으로 인한 hash 값의 오류가 발생할 수도 있습니다.
//그러므로 hash 오류건에 대해서는 오류 발생시 원인을 파악하여 즉시 수정 및 대처해 주셔야 합니다.

//정상적으로 처리한 경우에도 LG텔레콤에서 응답을 받지 못한 경우는 결제결과가 중복해서 나갈 수 있으므로 관련한 처리도 고려되어야 합니다.
//이 페이지는 상점연동성공 여부에 따라 'OK' 또는 'FAIL' 이라는 문자를 표시하도록 되었습니다.
//PHP에서는 되도록이면 error_reporting() 함수를 이용하여 개발 후에는 단순한 경고메세지는 출력이 되지 않도록 해주십시요.

// 상점연동 function page
//	return value
//  true  : 결과연동이 성공
//  false : 결과연동이 실패

function write_success($noti){
	global $g4;
    //결제에 관한 log남기게 됩니다. log path수정 및 db처리루틴이 추가하여 주십시요.
    write_log("$g4[path]/data/log/escrow_dacom_success.log", $noti);
    return true;
}

function write_failure($noti){
	global $g4;
    //결제에 관한 log남기게 됩니다. log path수정 및 db처리루틴이 추가하여 주십시요.
    write_log("$g4[path]/data/log/escrow_dacom_failure.log", $noti);
    return true;
}

function write_hasherr($noti) {
	global $g4;
    //결제에 관한 log남기게 됩니다. log path수정 및 db처리루틴이 추가하여 주십시요.
    write_log("$g4[path]/data/log/escrow_dacom_hasherr.log", $noti);
    return true;
}

function write_log($file, $noti) {
    $fp = fopen($file, "a+");
    ob_start();
    print_r($noti);
    $msg = ob_get_contents();
    ob_end_clean();
    fwrite($fp, $msg);
    fclose($fp);
}


function get_param($name){
    global $_POST, $_GET;
    if (!isset($_POST[$name]) || $_POST[$name] == "") {
        if (!isset($_GET[$name]) || $_GET[$name] == "") {
            return false;
        } else {
             return $_GET[$name];
        }
    }
    return $_POST[$name];
}


	// LG텔레콤에서 받은 value
	$respcode="";       // 응답코드: 0000(성공) 그외 실패
	$respmsg="";        // 응답메세지
	$hashdata="";       // 해쉬값
	$transaction="";    // LG텔레콤이 부여한 거래번호
	$mid="";            // 상점아이디
	$oid="";            // 주문번호
	$amount="";         // 거래금액
	$currency="";       // 통화코드('410':원화, '840':달러)
	$paytype="";        // 결제수단코드
	$msgtype="";        // 거래종류에 따른 LG텔레콤이 정의한 코드
	$paydate="";        // 거래일시(승인일시/이체일시)
	$buyer="";          // 구매자명
	$productinfo="";    // 상품정보
	$buyerssn="";       // 구매자주민등록번호
	$buyerid="";        // 구매자ID
	$buyeraddress="";   // 구매자주소
	$buyerphone="";     // 구매자전화번호
	$buyeremail="";     // 구매자이메일주소
	$receiver="";       // 수취인명
	$receiverphone="";  // 수취인전화번호
	$deliveryinfo="";   // 배송정보
	$producttype="";    // 상품유형
	$productcode="";    // 상품코드
	$financecode="";    // 결제기관코드(카드종류/은행코드)
	$financename="";    // 결제기관이름(카드이름/은행이름)

	$authnumber="";     // 승인번호(신용카드)
	$cardnumber="";     // 카드번호(신용카드)
	$cardexp="";        // 유효기간(신용카드)
	$cardperiod="";     // 할부개월수(신용카드)
	$nointerestflag=""; //무이자할부여부(신용카드) - '1'이면 무이자할부 '0'이면 일반할부
	$transamount="";    // 환율적용금액(신용카드)
	$exchangerate="";   // 환율(신용카드)

	$pid="";            // 예금주/휴대폰소지자 주민등록번호(계좌이체/휴대폰)
	$accountowner="";   // 계좌소유주이름(계좌이체)
	$accountnumber="";  // 계좌번호(계좌이체, 무통장입금)

	$telno="";          // 휴대폰번호(휴대폰)

    $payer="";           // 입금인(무통장입금)
    $cflag="";           // 무통장입금 플래그(무통장입금) - 'R':계좌할당, 'I':입금, 'C':입금취소
    $tamount="";         // 입금총액(무통장입금)
    $camount="";         // 현입금액(무통장입금)
    $bankdate="";        // 입금또는취소일시(무통장입금)

    $ocbsavecardnumber="";  //OCB적립카드번호
    $ocbsaveauthnumber="";  //OCB적립승인번호
    $ocbsavepoint="";       //OCB적립포인트
    $ocbsaveusablepoint=""; //OCB적립가용포인트
    $ocbsavetotalepoint=""; //OCB적립총포인트
    $ocbsaverespcode="";    //OCB적립응답코드
    $ocbsaverespmsg="";     //OCB적립응답메세지

    $ocbappcardnumber="";   //OCB사용카드번호
    $ocbappauthnumber="";   //OCB사용승인번호
    $ocbapppoint="";        //OCB사용후 자동적립포인트
    $ocbappusablepoint="";  //OCB사용가용포인트
    $ocbapptotalepoint="";  //OCB사용총포인트
    $ocbapprespcode="";     //OCB사용응답코드
    $ocbapprespmsg="";      //OCB사용응답메세지
    $ocbappamount="";       //OCB사용금액

	$resp = false;          //결과연동 성공여부

	$respcode = get_param("respcode");
	$respmsg = get_param("respmsg");
	$hashdata = get_param("hashdata");
	$transaction = get_param("transaction");
	$mid = get_param("mid");
	$oid = get_param("oid");
	$amount = get_param("amount");
	$currency = get_param("currency");
	$paytype = get_param("paytype");
	$msgtype = get_param("msgtype");
	$paydate = get_param("paydate");
	$buyer = get_param("buyer");
	$productinfo = get_param("productinfo");
	$buyerssn = get_param("buyerssn");
	$buyerid = get_param("buyerid");
	$buyeraddress = get_param("buyeraddress");
	$buyerphone = get_param("buyerphone");
	$buyeremail = get_param("buyeremail");
	$receiver = get_param("receiver");
	$receiverphone = get_param("receiverphone");
	$deliveryinfo = get_param("deliverinfo");
	$producttype = get_param("producttype");
	$productcode = get_param("productcode");
	$financecode = get_param("financecode");
	$financename = get_param("financename");
	$authnumber = get_param("authnumber");
	$cardnumber = get_param("cardnumber");
	$cardexp = get_param("cardexp");
	$cardperiod = get_param("cardperiod");
	$nointerestflag = get_param("nointerestflag");
	$transamount = get_param("transamount");
	$exchangerate = get_param("exchangerate");
	$pid = get_param("pid");
	$accountnumber = get_param("accountnumber");
	$accountowner = get_param("accountowner");
	$telno = get_param("telno");
	$payer = get_param("payer");
	$cflag = get_param("cflag");
	$tamount = get_param("tamount");
	$camount = get_param("camount");
	$bankdate = get_param("bankdate");
    $ocbsavecardnumber= get_param("ocbsavecardnumber");
    $ocbsaveauthnumber= get_param("ocbsaveauthnumber");
    $ocbsavepoint= get_param("ocbsavepoint");
    $ocbsaveusablepoint= get_param("ocbsaveusablepoint");
    $ocbsavetotalepoint= get_param("ocbsavetotalepoint");
    $ocbsaverespcode= get_param("ocbsaverespcode");
    $ocbsaverespmsg= get_param("ocbsaverespmsg");
    $ocbappcardnumber= get_param("ocbappcardnumber");
    $ocbappauthnumber= get_param("ocbappauthnumber");
    $ocbapppoint= get_param("ocbapppoint");
    $ocbappusablepoint= get_param("ocbappusablepoint");
    $ocbapptotalepoint= get_param("ocbapptotalepoint");
    $ocbapprespcode= get_param("ocbapprespcode");
    $ocbapprespmsg= get_param("ocbapprespmsg");
    $ocbappamount= get_param("ocbappamount");

    //$mertkey = "116063976f7a62cd9770548377f40901"; //LG텔레콤에서 발급한 상점키로 변경해 주시기 바랍니다.
    $mertkey = $de_dacom_mertkey; //LG텔레콤에서 발급한 상점키로 변경해 주시기 바랍니다.

    $hashdata2 = md5($transaction.$mid.$oid.$paydate.$mertkey);

    $value = array( "msgtype"           => $msgtype,
                    "transaction"       => $transaction,
                    "mid"               => $mid,
                    "oid"               => $oid,
                    "amount"     	    => $amount,
                    "currency" 		    => $currency,
                    "paytype"  		    => $paytype,
                    "paydate"  	  	    => $paydate,
                    "buyer"   		    => $buyer,
                    "productinfo"       => $productinfo,
                    "respcode" 		    => $respcode,
                    "respmsg"  		    => $respmsg,
                    "buyerssn"     	    => $buyerssn,
                    "buyerid"     	    => $buyerid,
                    "buyeraddress"      => $buyeraddress,
                    "buyerphone"        => $buyerphone,
                    "buyeremail"        => $buyeremail,
                    "receiver"     	    => $receiver,
                    "receiverphone"     => $receiverphone,
                    "deliveryinfo"      => $deliveryinfo,
                    "producttype"  	    => $producttype,
                    "productcode"  	    => $productcode,
                    "financecode"  	    => $financecode,
                    "financename"  	    => $financename,
                    "authnumber"   	    => $authnumber,
                    "cardnumber"   	    => $cardnumber,
                    "cardexp"     	    => $cardexp,
                    "cardperiod"   	    => $cardperiod,
                    "nointerestflag"    => $nointerestflag,
                    "transamount"  	    => $transamount,
                    "exchangerate" 	    => $exchangerate,
                    "pid"     		    => $pid,
                    "accountnumber"	    => $accountnumber,
                    "accountowner" 	    => $accountowner,
                    "telno" 		    => $telno,
                    "payer" 		    => $payer,
                    "cflag" 		    => $cflag,
                    "tamount" 		    => $tamount,
                    "camount" 		    => $camount,
                    "ocbsavecardnumber"     =>$ocbsavecardnumber,
                    "ocbsaveauthnumber"     =>$ocbsaveauthnumber,
                    "ocbsavepoint"          =>$ocbsavepoint,
                    "ocbsaveusablepoint"    =>$ocbsaveusablepoint,
                    "ocbsavetotalepoint"    =>$ocbsavetotalepoint,
                    "ocbsaverespcode"       =>$ocbsaverespcode,
                    "ocbsaverespmsg"        =>$ocbsaverespmsg,
                    "ocbappcardnumber"      =>$ocbappcardnumber,
                    "ocbappauthnumber"      =>$ocbappauthnumber,
                    "ocbapppoint"           =>$ocbapppoint,
                    "ocbappusablepoint"     =>$ocbappusablepoint,
                    "ocbapptotalepoint"     =>$ocbapptotalepoint,
                    "ocbapprespcode"        =>$ocbapprespcode,
                    "ocbapprespmsg"         =>$ocbapprespmsg,
                    "ocbappamount"          =>$ocbappamount,
                    "bankdate" 		        => $bankdate,
                    "hashdata"    	        => $hashdata,
                    "hashdata2"  	        => $hashdata2);

    // 받은 변수를 영카드 변수로 변경 저장 2005-07-27 by prosper
    $od_id =         $oid;                      // 주문서 번호
    $on_uid =        $_GET['on_uid'];           // ss_temp_on_uid 값
    $cd_mall_id =    $mid;                      // 상점 아이디
    $cd_amount =     $amount;                   // 금액
    $cd_app_no =     $authnumber;               // 카드 승인 번호, 만약 승인이 나지 않으면 "XXXXXXXX"
    $cd_app_rt =     $respcode;                 // 카드 승인 결과 코드, 카드 승인 실패(T002) 성공(0000)
    $cd_trade_ymd = substr($paydate,0,4)."-".substr($paydate,4,2)."-".substr($paydate,6,2);  // 해당 거래 발생의 년,월,일 YYYY-MM-DD
    $cd_trade_hms = date("H:i:s", time());      // 해당 거래 발생의 시,분,초 HH:MM:SS
    $cd_opt01 =      $buyer;                    // 구매자 이름
    $cd_opt02 =      $receiver;                 // 수취인 이름

    //write_log("$g4[path]/data/log/escrow_dacom.log", $value);

	if ($hashdata2 == $hashdata) //해쉬값 검증이 성공하면
    {
		if($respcode == "0000") //결제가 성공이면
        {
			$resp = write_success($value);

            $msg = '';
            if ($msgtype == 'CAS') // 가상계좌 (입금전)
                $msg = '입금전';
            else if ($msgtype == 'CBR') // 가상계좌 (입금후 완료)
                $msg = '입금완료';

            // 저장된 가격과 결제된 가격이 같은지 검사
            $sql = " select od_temp_bank, od_temp_card from $g4[yc4_order_table]
                      where od_id = '$od_id' ";
            $od = sql_fetch($sql);
            if ($msgtype == 'GMC') {
                $save_amount = $od[od_temp_card];
            } else {
                $save_amount = $od[od_temp_bank];
            }
            // 저장된 가격과 일치하지 않는다면
            if ($save_amount != $cd_amount) 
                die("FAIL");

            // 주문서의 카드입금 수정
            // 크래킹의 우려도 있으므로 on_uid 도 같이

            $sql = " update $g4[yc4_order_table] ";
            switch ($msgtype)
            {
                case 'BMC' : // 실시간계좌이체
                    $sql .= "set od_bank_account = '$financename $accountnumber',
                                 od_receipt_bank = '$cd_amount',
                                 od_bank_time    = '$g4[time_ymdhis]' ";
                    break;
                case 'CAS' : // 가상계좌 (입금전)
                    $sql .= "set od_bank_account = '$financename $accountnumber',
                                 od_receipt_bank = '0',
                                 od_bank_time    = '' ";
                    break;
                case 'CBR' : // 가상계좌 (입금후)
                    $sql .= "set od_receipt_bank = '$cd_amount',
                                 od_bank_time    = '$g4[time_ymdhis]' ";
                    break;
                default : // GMC:카드 결제
                    $sql .= "set od_receipt_card = '$cd_amount',
                                 od_card_time    = '$g4[time_ymdhis]' ";
                    // 카드영수증 발급을 위해 이미 생성되어 있는 에스크로 필드에 트랙잰션 번호 추가
                    // 그러나 실제 카드영수증 발급시 이값을 사용하지는 않음 (추후 사용될 경우에 대비해 저장)
                    $sql .= " , od_escrow1       = '$transaction' ";
                    break;

            }
            $sql .= "  where od_id  = '$od_id' ";
            sql_query($sql);


            $sql = "insert $g4[yc4_card_history_table]
                 set od_id = '$od_id',
                     on_uid = '$on_uid',
                     cd_mall_id = '$cd_mall_id',
                     cd_amount = '$cd_amount',
                     cd_app_no = '$cd_app_no{$msg}',
                     cd_app_rt = '$cd_app_rt',
                     cd_trade_ymd = '$cd_trade_ymd',
                     cd_trade_hms = '$cd_trade_hms',
                     cd_opt01 = '$cd_opt01',
                     cd_opt02 = '$cd_opt02',
                     cd_time = '$g4[time_ymdhis]',
                     cd_ip = '$_SERVER[REMOTE_ADDR]' ";
            sql_query($sql);
		}else {                             //결제가 실패이면
			$resp = write_failure($value);
		}
	} else {                                //해쉬값 검증이 실패이면
		write_hasherr($value);
	}

   	if($resp){                              //결과연동이 성공이면
   		echo "OK";
   	}else{                                  //결과연동이 실패이면
   		echo "FAIL";
   	}
?>