<?php
include_once("./_common.php");

    /*
     * 공통결제결과 정보 
     */
    $LGD_RESPCODE = "";           			// 응답코드: 0000(성공) 그외 실패
    $LGD_RESPMSG = "";            			// 응답메세지
    $LGD_MID = "";                			// 상점아이디 
    $LGD_OID = "";                			// 주문번호
    $LGD_AMOUNT = "";             			// 거래금액
    $LGD_TID = "";                			// LG유플러스에서 부여한 거래번호
    $LGD_PAYTYPE = "";            			// 결제수단코드
    $LGD_PAYDATE = "";            			// 거래일시(승인일시/이체일시)
    $LGD_HASHDATA = "";           			// 해쉬값
    $LGD_FINANCECODE = "";        			// 결제기관코드(카드종류/은행코드/이통사코드)
    $LGD_FINANCENAME = "";        			// 결제기관이름(카드이름/은행이름/이통사이름)
    $LGD_ESCROWYN = "";           			// 에스크로 적용여부
    $LGD_TIMESTAMP = "";          			// 타임스탬프
    $LGD_FINANCEAUTHNUM = "";     			// 결제기관 승인번호(신용카드, 계좌이체, 상품권)
	
    /*
     * 신용카드 결제결과 정보
     */
    $LGD_CARDNUM = "";            			// 카드번호(신용카드)
    $LGD_CARDINSTALLMONTH = "";   			// 할부개월수(신용카드) 
    $LGD_CARDNOINTYN = "";        			// 무이자할부여부(신용카드) - '1'이면 무이자할부 '0'이면 일반할부
    $LGD_TRANSAMOUNT = "";        			// 환율적용금액(신용카드)
    $LGD_EXCHANGERATE = "";       			// 환율(신용카드)

    /*
     * 휴대폰
     */
    $LGD_PAYTELNUM = "";          			// 결제에 이용된전화번호

    /*
     * 계좌이체, 무통장
     */
    $LGD_ACCOUNTNUM = "";         			// 계좌번호(계좌이체, 무통장입금) 
    $LGD_CASTAMOUNT = "";         			// 입금총액(무통장입금)
    $LGD_CASCAMOUNT = "";         			// 현입금액(무통장입금)
    $LGD_CASFLAG = "";            			// 무통장입금 플래그(무통장입금) - 'R':계좌할당, 'I':입금, 'C':입금취소 
    $LGD_CASSEQNO = "";           			// 입금순서(무통장입금)
    $LGD_CASHRECEIPTNUM = "";     			// 현금영수증 승인번호
    $LGD_CASHRECEIPTSELFYN = "";  			// 현금영수증자진발급제유무 Y: 자진발급제 적용, 그외 : 미적용
    $LGD_CASHRECEIPTKIND = "";    			// 현금영수증 종류 0: 소득공제용 , 1: 지출증빙용

    /*
     * OK캐쉬백
     */
    $LGD_OCBSAVEPOINT = "";       			// OK캐쉬백 적립포인트
    $LGD_OCBTOTALPOINT = "";      			// OK캐쉬백 누적포인트
    $LGD_OCBUSABLEPOINT = "";     			// OK캐쉬백 사용가능 포인트

    /*
     * 구매정보
     */
    $LGD_BUYER = "";              			// 구매자
    $LGD_PRODUCTINFO = "";        			// 상품명
    $LGD_BUYERID = "";            			// 구매자 ID
    $LGD_BUYERADDRESS = "";       			// 구매자 주소
    $LGD_BUYERPHONE = "";         			// 구매자 전화번호
    $LGD_BUYEREMAIL = "";         			// 구매자 이메일
    $LGD_BUYERSSN = "";           			// 구매자 주민번호
    $LGD_PRODUCTCODE = "";        			// 상품코드
    $LGD_RECEIVER = "";           			// 수취인
    $LGD_RECEIVERPHONE = "";      			// 수취인 전화번호
    $LGD_DELIVERYINFO = "";       			// 배송지
    

    $LGD_RESPCODE            = $HTTP_POST_VARS["LGD_RESPCODE"];
    $LGD_RESPMSG             = $HTTP_POST_VARS["LGD_RESPMSG"];
    $LGD_MID                 = $HTTP_POST_VARS["LGD_MID"];
    $LGD_OID                 = $HTTP_POST_VARS["LGD_OID"];
    $LGD_AMOUNT              = $HTTP_POST_VARS["LGD_AMOUNT"];
    $LGD_TID                 = $HTTP_POST_VARS["LGD_TID"];
    $LGD_PAYTYPE             = $HTTP_POST_VARS["LGD_PAYTYPE"];
    $LGD_PAYDATE             = $HTTP_POST_VARS["LGD_PAYDATE"];
    $LGD_HASHDATA            = $HTTP_POST_VARS["LGD_HASHDATA"];
    $LGD_FINANCECODE         = $HTTP_POST_VARS["LGD_FINANCECODE"];
    $LGD_FINANCENAME         = $HTTP_POST_VARS["LGD_FINANCENAME"];
    $LGD_ESCROWYN            = $HTTP_POST_VARS["LGD_ESCROWYN"];
    $LGD_TRANSAMOUNT         = $HTTP_POST_VARS["LGD_TRANSAMOUNT"];
    $LGD_EXCHANGERATE        = $HTTP_POST_VARS["LGD_EXCHANGERATE"];
    $LGD_CARDNUM             = $HTTP_POST_VARS["LGD_CARDNUM"];
    $LGD_CARDINSTALLMONTH    = $HTTP_POST_VARS["LGD_CARDINSTALLMONTH"];
    $LGD_CARDNOINTYN         = $HTTP_POST_VARS["LGD_CARDNOINTYN"];
    $LGD_TIMESTAMP           = $HTTP_POST_VARS["LGD_TIMESTAMP"];
    $LGD_FINANCEAUTHNUM      = $HTTP_POST_VARS["LGD_FINANCEAUTHNUM"];
    $LGD_PAYTELNUM           = $HTTP_POST_VARS["LGD_PAYTELNUM"];
    $LGD_ACCOUNTNUM          = $HTTP_POST_VARS["LGD_ACCOUNTNUM"];
    $LGD_CASTAMOUNT          = $HTTP_POST_VARS["LGD_CASTAMOUNT"];
    $LGD_CASCAMOUNT          = $HTTP_POST_VARS["LGD_CASCAMOUNT"];
    $LGD_CASFLAG             = $HTTP_POST_VARS["LGD_CASFLAG"];
    $LGD_CASSEQNO            = $HTTP_POST_VARS["LGD_CASSEQNO"];
    $LGD_CASHRECEIPTNUM      = $HTTP_POST_VARS["LGD_CASHRECEIPTNUM"];
    $LGD_CASHRECEIPTSELFYN   = $HTTP_POST_VARS["LGD_CASHRECEIPTSELFYN"];
    $LGD_CASHRECEIPTKIND     = $HTTP_POST_VARS["LGD_CASHRECEIPTKIND"];
    $LGD_OCBSAVEPOINT        = $HTTP_POST_VARS["LGD_OCBSAVEPOINT"];
    $LGD_OCBTOTALPOINT       = $HTTP_POST_VARS["LGD_OCBTOTALPOINT"];
    $LGD_OCBUSABLEPOINT      = $HTTP_POST_VARS["LGD_OCBUSABLEPOINT"];

    $LGD_BUYER               = $HTTP_POST_VARS["LGD_BUYER"];
    $LGD_PRODUCTINFO         = $HTTP_POST_VARS["LGD_PRODUCTINFO"];
    $LGD_BUYERID             = $HTTP_POST_VARS["LGD_BUYERID"];
    $LGD_BUYERADDRESS        = $HTTP_POST_VARS["LGD_BUYERADDRESS"];
    $LGD_BUYERPHONE          = $HTTP_POST_VARS["LGD_BUYERPHONE"];
    $LGD_BUYEREMAIL          = $HTTP_POST_VARS["LGD_BUYEREMAIL"];
    $LGD_BUYERSSN            = $HTTP_POST_VARS["LGD_BUYERSSN"];
    $LGD_PRODUCTCODE         = $HTTP_POST_VARS["LGD_PRODUCTCODE"];
    $LGD_RECEIVER            = $HTTP_POST_VARS["LGD_RECEIVER"];
    $LGD_RECEIVERPHONE       = $HTTP_POST_VARS["LGD_RECEIVERPHONE"];
    $LGD_DELIVERYINFO        = $HTTP_POST_VARS["LGD_DELIVERYINFO"];
	
    $param_opt_1        = $HTTP_POST_VARS["param_opt_1"];
    $param_opt_2        = $HTTP_POST_VARS["param_opt_2"];
    $param_opt_3        = $HTTP_POST_VARS["param_opt_3"];
    $param_opt_4        = $HTTP_POST_VARS["param_opt_4"];

	$LGD_MERTKEY = $default['de_dacom_mertkey'];
    //$LGD_MERTKEY = "95160cce09854ef44d2edb2bfb05f9f3";  //LG유플러스에서 발급한 상점키로 변경해 주시기 바랍니다.
       
    $LGD_HASHDATA2 = md5($LGD_MID.$LGD_OID.$LGD_AMOUNT.$LGD_RESPCODE.$LGD_TIMESTAMP.$LGD_MERTKEY); 

    /*
     * 상점 처리결과 리턴메세지
     *
     * OK   : 상점 처리결과 성공
     * 그외 : 상점 처리결과 실패
     *
     * ※ 주의사항 : 성공시 'OK' 문자이외의 다른문자열이 포함되면 실패처리 되오니 주의하시기 바랍니다.
     */    
    $resultMSG = "결제결과 상점 DB처리(NOTE_URL) 결과값을 입력해 주시기 바랍니다.";


    $od_id =         $LGD_OID;                      // 주문서 번호
    $on_uid =        $param_opt_2;           // ss_temp_on_uid 값
    $cd_mall_id =    $LGD_MID;                      // 상점 아이디
    $cd_amount =     $LGD_AMOUNT;                   // 금액
    $cd_app_no =     $LGD_FINANCEAUTHNUM;               // 카드 승인 번호, 만약 승인이 나지 않으면 "XXXXXXXX"
    $cd_app_rt =     $LGD_RESPCODE;                 // 카드 승인 결과 코드, 카드 승인 실패(T002) 성공(0000)
    $cd_trade_ymd = substr($LGD_TIMESTAMP,0,4)."-".substr($LGD_TIMESTAMP,4,2)."-".substr($LGD_TIMESTAMP,6,2);
    $cd_trade_hms = substr($LGD_TIMESTAMP,8,2).":".substr($LGD_TIMESTAMP,10,2).":".substr($LGD_TIMESTAMP,12,2);
    $cd_opt01 =      $LGD_BUYER;                    // 구매자 이름
    $cd_opt02 =      $LGD_PRODUCTINFO;                 // 상품명
	$transaction = $LGD_TID;

    if ($LGD_HASHDATA2 == $LGD_HASHDATA) {      //해쉬값 검증이 성공하면
        if($LGD_RESPCODE == "0000"){            //결제가 성공이면

            // 저장된 가격과 결제된 가격이 같은지 검사
            $sql = " select od_temp_bank, od_temp_card from yc4_order
                      where od_id = '$od_id' ";
            $od = sql_fetch($sql);

			$save_amount = $od[od_temp_card];
			
            // 저장된 가격과 일치하지 않는다면
            if ($save_amount != $cd_amount) 
                die("FAIL");

			// 주문서의 카드입금 수정
			// 크래킹의 우려도 있으므로 on_uid 도 같이

			$sql = " update yc4_order ";
			$sql .= "set od_receipt_card = '$cd_amount',
							 od_card_time    = now() ";
			// 카드영수증 발급을 위해 이미 생성되어 있는 에스크로 필드에 트랙잰션 번호 추가
			// 그러나 실제 카드영수증 발급시 이값을 사용하지는 않음 (추후 사용될 경우에 대비해 저장)
			$sql .= " , od_escrow1       = '$transaction' ";
            $sql .= "  where od_id  = '$od_id' AND on_uid = '".$on_uid."' ";
            $isDBOK = sql_query($sql);


            $sql = "insert yc4_card_history
                 set od_id = '$od_id',
                     on_uid = '$on_uid',
                     cd_mall_id = '$cd_mall_id',
                     cd_amount = '$cd_amount',
                     cd_app_no = '$cd_app_no',
                     cd_app_rt = '$cd_app_rt',
                     cd_trade_ymd = '$cd_trade_ymd',
                     cd_trade_hms = '$cd_trade_hms',
                     cd_opt01 = '$cd_opt01',
                     cd_opt02 = '$cd_opt02',
                     cd_time = now(),
                     cd_ip = '$_SERVER[REMOTE_ADDR]' ";
            sql_query($sql);

            // 장바구니 '준비' 상태로 변경
			$sql = " update $g4[yc4_cart_table]
                        set ct_status = '준비'
                    where on_uid = '$on_uid' ";
            sql_query($sql, TRUE);


            // 포인트 결제를 했다면 실제 포인트 결제한 것으로 수정합니다. (settleresult.php까지 넘어가지 않은 경우에 대비해서 여기서 합니다)
			$sql = " select od_id, on_uid, od_receipt_point, od_temp_point from $g4[yc4_order_table] where on_uid = '$on_uid' ";
			$row = sql_fetch($sql);
			if ($row[od_receipt_point] == 0 && $row[od_temp_point] != 0)
			{
				sql_query(" update $g4[yc4_order_table] set od_receipt_point = od_temp_point where on_uid = '$on_uid' ");
				insert_point($member[mb_id], (-1) * $row[od_temp_point], "주문번호:$row[od_id] 결제", "@order", $member[mb_id], "$row[od_id],$row[on_uid]");
            }


            //최종결제요청 결과 성공 DB처리 실패시 Rollback 처리
          	//$isDBOK = true; //DB처리 실패시 false로 변경해 주세요.
          	if($isDBOK){
				echo '<body onload="document.f_payres.submit();">
							<form name="f_payres" method="post" action="'.$g4['shop_mpath'].'/settleresult.php">
								<input type="hidden" name="on_uid" value="'.$param_opt_2.'">
								<input type="hidden" name="state" value="mobile">
							</form>
						</body>
				';
            /*
             * 거래성공 결과 상점 처리(DB) 부분
             * 상점 결과 처리가 정상이면 "OK"
             */    
            //if( 결제성공 상점처리결과 성공 ) 
            $resultMSG = "OK";   
        }else {                                 //결제가 실패이면
            /*
             * 거래실패 결과 상점 처리(DB) 부분
             * 상점결과 처리가 정상이면 "OK"
             */  
           //if( 결제실패 상점처리결과 성공 ) 
           $resultMSG = "OK";    
        }
    } else {                                    //해쉬값 검증이 실패이면
        /*
         * hashdata검증 실패 로그를 처리하시기 바랍니다. 
         */  
		$resultMSG = "결제결과 상점 DB처리(NOTE_URL) 해쉬값 검증이 실패하였습니다.";         
    }

    echo $resultMSG;        
?>
