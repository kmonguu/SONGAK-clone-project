<?php
include_once("./_common.php");

function write_success($noti){
	global $g4;
    //결제에 관한 log남기게 됩니다. log path수정 및 db처리루틴이 추가하여 주십시요.
    write_log("$g4[path]/shop/lgdacom/log/escrow_dacom_success.log", $noti);
    return true;
}

function write_failure($noti){
	global $g4;
    //결제에 관한 log남기게 됩니다. log path수정 및 db처리루틴이 추가하여 주십시요.
    write_log("$g4[path]/shop/lgdacom/log/escrow_dacom_failure.log", $noti);
    return true;
}

function write_hasherr($noti) {
	global $g4;
    //결제에 관한 log남기게 됩니다. log path수정 및 db처리루틴이 추가하여 주십시요.
    write_log("$g4[path]/shop/lgdacom/log/escrow_dacom_hasherr.log", $noti);
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

	/*
	 * 사용자변수
	*/
	$on_uid = $_POST["on_uid"];
    


    /*
     * [최종결제요청 페이지(STEP2-2)]
	 *
	 * 매뉴얼 "5.1. XPay 결제 요청 페이지 개발"의 "단계 5. 최종 결제 요청 및 요청 결과 처리" 참조
     *
     * LG유플러스으로 부터 내려받은 LGD_PAYKEY(인증Key)를 가지고 최종 결제요청.(파라미터 전달시 POST를 사용하세요)
     */
	
	/* ※ 중요
	* 환경설정 파일의 경우 반드시 외부에서 접근이 가능한 경로에 두시면 안됩니다.
	* 해당 환경파일이 외부에 노출이 되는 경우 해킹의 위험이 존재하므로 반드시 외부에서 접근이 불가능한 경로에 두시기 바랍니다. 
	* 예) [Window 계열] C:\inetpub\wwwroot\lgdacom ==> 절대불가(웹 디렉토리)
	*/
	
	$configPath  =  dirname($_SERVER['DOCUMENT_ROOT'])."/public_html/shop/lgdacom";    //LG유플러스에서 제공한 환경파일("/conf/lgdacom.conf") 위치 지정.     

    /*
     *************************************************
     * 1.최종결제 요청 - BEGIN
     *  (단, 최종 금액체크를 원하시는 경우 금액체크 부분 주석을 제거 하시면 됩니다.)
     *************************************************
     */
    $CST_PLATFORM               = $_POST["CST_PLATFORM"];
    $CST_MID                    = $_POST["CST_MID"];
    $LGD_MID                    = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;
    $LGD_PAYKEY                 = $_POST["LGD_PAYKEY"];

    if($CST_MID == "TEST" || $CST_MID == "test" || $CST_MID == "lgdacomxpay") {
        $LGD_MERTKEY = "95160cce09854ef44d2edb2bfb05f9f3";
    } else {
        $LGD_MERTKEY				=  $default[de_dacom_mertkey];
    }


    require_once("./lgdacom/XPayClient.php");

	// (1) XpayClient의 사용을 위한 xpay 객체 생성
	// (2) Init: XPayClient 초기화(환경설정 파일 로드) 
	// configPath: 설정파일
	// CST_PLATFORM: - test, service 값에 따라 lgdacom.conf의 test_url(test) 또는 url(srvice) 사용
	//				- test, service 값에 따라 테스트용 또는 서비스용 아이디 생성
    $xpay = &new XPayClient($configPath, $CST_PLATFORM, $LGD_MERTKEY);
	
	// (3) Init_TX: 메모리에 mall.conf, lgdacom.conf 할당 및 트랜잭션의 고유한 키 TXID 생성
	$xpay->Init_TX($LGD_MID);    
    $xpay->Set("LGD_TXNAME", "PaymentByKey");
    $xpay->Set("LGD_PAYKEY", $LGD_PAYKEY);
    
    //금액을 체크하시기 원하는 경우 아래 주석을 풀어서 이용하십시요.
	//$DB_AMOUNT = "DB나 세션에서 가져온 금액"; //반드시 위변조가 불가능한 곳(DB나 세션)에서 금액을 가져오십시요.
	//$xpay->Set("LGD_AMOUNTCHECKYN", "Y");
	//$xpay->Set("LGD_AMOUNT", $DB_AMOUNT);
	    
    /*
     *************************************************
     * 1.최종결제 요청(수정하지 마세요) - END
     *************************************************
     */

    /*
     * 2. 최종결제 요청 결과처리
     *
     * 최종 결제요청 결과 리턴 파라미터는 연동메뉴얼을 참고하시기 바랍니다.
     */
	// (4) TX: lgdacom.conf에 설정된 URL로 소켓 통신하여 최종 인증요청, 결과값으로 true, false 리턴
    if ($xpay->TX()) {

		/*
        //1)결제결과 화면처리(성공,실패 결과 처리를 하시기 바랍니다.)
        echo "결제요청이 완료되었습니다.  <br>";
        echo "TX 통신 응답코드 = " . $xpay->Response_Code() . "<br>";		//통신 응답코드("0000" 일 때 통신 성공)
        echo "TX 통신 응답메시지 = " . iconv("euc-kr", "utf-8", $xpay->Response_Msg()) . "<p>";
        echo "거래번호 : " . $xpay->Response("LGD_TID",0) . "<br>";
        echo "상점아이디 : " . $xpay->Response("LGD_MID",0) . "<br>";
        echo "상점주문번호 : " . $xpay->Response("LGD_OID",0) . "<br>";
        echo "결제금액 : " . $xpay->Response("LGD_AMOUNT",0) . "<br>";
        echo "결과코드 : " . $xpay->Response("LGD_RESPCODE",0) . "<br>";	//LGD_RESPCODE 가 반드시 "0000" 일때만 결제 성공, 그 외는 모두 실패
        echo "결과메세지 : " . $xpay->Response("LGD_RESPMSG",0) . "<p>";
        $keys = $xpay->Response_Names();
        foreach($keys as $name) {
            echo $name . " = " . $xpay->Response($name, 0) . "<br>";
        }
		exit;
		*/


		$LGD_TID = $xpay->Response("LGD_TID",0);
		$LGD_OID = $xpay->Response("LGD_OID",0);
		$LGD_MID = $xpay->Response("LGD_MID",0);
		$LGD_FINANCENAME = $xpay->Response("LGD_FINANCENAME",0);
        $LGD_ACCOUNTNUM = $xpay->Response("LGD_ACCOUNTNUM",0);
        $LGD_CASSEQNO = $xpay->Response("LGD_CASSEQNO",0);
		$LGD_AMOUNT = $xpay->Response("LGD_AMOUNT",0);
		$LGD_PAYTYPE = $xpay->Response("LGD_PAYTYPE",0);
		$LGD_PAYDATE = $xpay->Response("LGD_PAYDATE",0);
		$LGD_BUYER = $xpay->Response("LGD_BUYER",0);
		$LGD_PRODUCTINFO = $xpay->Response("LGD_PRODUCTINFO",0);
		$LGD_FINANCEAUTHNUM = $xpay->Response("LGD_FINANCEAUTHNUM",0);
		$LGD_RESPCODE = $xpay->Response("LGD_RESPCODE",0);
          


		// (5) DB에 요청 결과 처리
		if( "0000" == $xpay->Response_Code() ) {
			
			$resp = write_success($_POST);
			
          	$isDBOK = true; 

			$sql = " update $g4[yc4_order_table] ";
            switch ($LGD_PAYTYPE)
            {
                case 'SC0040' : // 가상계좌
                    $sql .= "set od_bank_account = '$LGD_FINANCENAME $LGD_ACCOUNTNUM',
                                 od_receipt_bank = '0',
                                 od_bank_time    = '',
                                 od_escrow1 = '$LGD_CASSEQNO' ";
                    break;
                case 'SC0030' : // 실시간계좌이체
                    $sql .= "set od_bank_account = '$LGD_FINANCENAME $LGD_ACCOUNTNUM',
                                 od_receipt_bank = '$LGD_AMOUNT',
                                 od_bank_time    = '$g4[time_ymdhis]' ";
                    break;
                default : // SC0010 : 카드 결제
                    $sql .= "set od_receipt_card = '$LGD_AMOUNT',
                                 od_card_time    = '$g4[time_ymdhis]' ";
                    // 카드영수증 발급을 위해 이미 생성되어 있는 에스크로 필드에 트랙잰션 번호 추가
                    // 그러나 실제 카드영수증 발급시 이값을 사용하지는 않음 (추후 사용될 경우에 대비해 저장)
                    $sql .= " , od_escrow1       = '$LGD_TID' ";
                    break;
            }
            $sql .= "  where od_id  = '$LGD_OID' ";
            $result = sql_query($sql);



			 if ($result) {
                
               

                    $sql = "insert $g4[yc4_card_history_table]
                        set od_id = '$LGD_OID',
                            on_uid = '$on_uid',
                            cd_mall_id = '$LGD_MID',
                            cd_amount = '$LGD_AMOUNT',
                            cd_app_no = '$LGD_FINANCEAUTHNUM',
                            cd_app_rt = '$LGD_RESPCODE',
                            cd_trade_ymd = '$LGD_PAYDATE',
                            cd_trade_hms = '".substr($LGD_PAYDATE, -6)."',
                            cd_opt01 = '$LGD_BUYER',
                            cd_opt02 = '$LGD_PRODUCTINFO',
                            cd_time = '$g4[time_ymdhis]',
                            cd_ip = '$_SERVER[REMOTE_ADDR]' ";
                    $result = sql_query($sql);


                    if($LGD_PAYTYPE != "SC0040") {
                        // 장바구니 '준비' 상태로 변경
                        $sql = " update $g4[yc4_cart_table]
                                    set ct_status = '준비'
                                where on_uid = '$on_uid' ";
                        sql_query($sql, TRUE);
                    }


                     // 포인트 결제를 했다면 실제 포인트 결제한 것으로 수정합니다. (settleresult.php까지 넘어가지 않은 경우에 대비해서 여기서 합니다)
                     $sql = " select od_id, on_uid, od_receipt_point, od_temp_point from $g4[yc4_order_table] where on_uid = '$on_uid' ";
                     $row = sql_fetch($sql);
                     if ($row[od_receipt_point] == 0 && $row[od_temp_point] != 0)
                     {
                         sql_query(" update $g4[yc4_order_table] set od_receipt_point = od_temp_point where on_uid = '$on_uid' ");

                         echo "{$member["mb_id"]} // {$row["od_temp_point"]} // {$row["od_id"]} // {$row["on_uid"]} ";
                         insert_point($member[mb_id], (-1) * $row[od_temp_point], "주문번호:$row[od_id] 결제", "@order", $member[mb_id], "$row[od_id],$row[on_uid]");
                     }

 
                    goto_url("./settleresult.php?on_uid={$on_uid}");    



            } else {

				$isDBOK = false;

			}



          	if( !$isDBOK ) {
           		echo "<p>";
           		$xpay->Rollback("상점 DB처리 실패로 인하여 Rollback 처리 [TID:" . $xpay->Response("LGD_TID",0) . ",MID:" . $xpay->Response("LGD_MID",0) . ",OID:" . $xpay->Response("LGD_OID",0) . "]");            		            		
                echo "TX Rollback Response_code = " . $xpay->Response_Code() . "<br>";
                echo "TX Rollback Response_msg = " . $xpay->Response_Msg() . "<p>";
                if( "0000" == $xpay->Response_Code() ) {
                  	alert("자동취소가 정상적으로 완료 되었습니다.");
                }else{
          			alert("자동취소가 정상적으로 처리되지 않았습니다.");
                }
          	}  
			
        }else{
          	//통신상의 문제 발생(최종결제요청 결과 실패 DB처리)
         	//echo "최종결제요청 결과 실패 DB처리하시기 바랍니다.<br>";            	            
			$resp = write_failure($_POST);
			$str = "결제요청이 실패하였습니다.";
			$str .= "\\r\\nCODE : " . $xpay->Response_Code();
			$str .= "\\r\\nMSG : " . $xpay->Response_Msg();
			alert($str);
        }
    } else {
        //2)API 요청실패 화면처리
        $str = "결제요청이 실패하였습니다.";
        $str .= "\\r\\ncode = " . $xpay->Response_Code();
        $str .= "\\r\\nmsg = " . $xpay->Response_Msg();

		alert($str);
    }
?>
