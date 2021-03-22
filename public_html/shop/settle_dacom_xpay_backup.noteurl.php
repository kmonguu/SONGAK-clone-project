<?php
include_once("./_common.php");

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

    /*
     * 사용자변수
     */
    $on_uid = $_POST["on_uid"];


    /*
     * 공통결제결과 정보 
     */
    $LGD_RESPCODE = "";           			// 응답코드: 0000(성공) 그외 실패
    $LGD_RESPMSG = "";            			// 응답메세지
    $LGD_MID = "";                			// 상점아이디 
    $LGD_OID = "";                			// 주문번호
    $LGD_AMOUNT = "";             			// 거래금액
    $LGD_TID = "";                			// LG텔레콤이 부여한 거래번호
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
    

    $LGD_RESPCODE            = $_POST["LGD_RESPCODE"];
    $LGD_RESPMSG             = $_POST["LGD_RESPMSG"];
    $LGD_MID                 = $_POST["LGD_MID"];
    $LGD_OID                 = $_POST["LGD_OID"];
    $LGD_AMOUNT              = $_POST["LGD_AMOUNT"];
    $LGD_TID                 = $_POST["LGD_TID"];
    $LGD_PAYTYPE             = $_POST["LGD_PAYTYPE"];
    $LGD_PAYDATE             = $_POST["LGD_PAYDATE"];
    $LGD_HASHDATA            = $_POST["LGD_HASHDATA"];
    $LGD_FINANCECODE         = $_POST["LGD_FINANCECODE"];
    $LGD_FINANCENAME         = $_POST["LGD_FINANCENAME"];
    $LGD_ESCROWYN            = $_POST["LGD_ESCROWYN"];
    $LGD_TRANSAMOUNT         = $_POST["LGD_TRANSAMOUNT"];
    $LGD_EXCHANGERATE        = $_POST["LGD_EXCHANGERATE"];
    $LGD_CARDNUM             = $_POST["LGD_CARDNUM"];
    $LGD_CARDINSTALLMONTH    = $_POST["LGD_CARDINSTALLMONTH"];
    $LGD_CARDNOINTYN         = $_POST["LGD_CARDNOINTYN"];
    $LGD_TIMESTAMP           = $_POST["LGD_TIMESTAMP"];
    $LGD_FINANCEAUTHNUM      = $_POST["LGD_FINANCEAUTHNUM"];
    $LGD_PAYTELNUM           = $_POST["LGD_PAYTELNUM"];
    $LGD_ACCOUNTNUM          = $_POST["LGD_ACCOUNTNUM"];
    $LGD_CASTAMOUNT          = $_POST["LGD_CASTAMOUNT"];
    $LGD_CASCAMOUNT          = $_POST["LGD_CASCAMOUNT"];
    $LGD_CASFLAG             = $_POST["LGD_CASFLAG"];
    $LGD_CASSEQNO            = $_POST["LGD_CASSEQNO"];
    $LGD_CASHRECEIPTNUM      = $_POST["LGD_CASHRECEIPTNUM"];
    $LGD_CASHRECEIPTSELFYN   = $_POST["LGD_CASHRECEIPTSELFYN"];
    $LGD_CASHRECEIPTKIND     = $_POST["LGD_CASHRECEIPTKIND"];
    $LGD_OCBSAVEPOINT        = $_POST["LGD_OCBSAVEPOINT"];
    $LGD_OCBTOTALPOINT       = $_POST["LGD_OCBTOTALPOINT"];
    $LGD_OCBUSABLEPOINT      = $_POST["LGD_OCBUSABLEPOINT"];

    $LGD_BUYER               = $_POST["LGD_BUYER"];
    $LGD_PRODUCTINFO         = $_POST["LGD_PRODUCTINFO"];
    $LGD_BUYERID             = $_POST["LGD_BUYERID"];
    $LGD_BUYERADDRESS        = $_POST["LGD_BUYERADDRESS"];
    $LGD_BUYERPHONE          = $_POST["LGD_BUYERPHONE"];
    $LGD_BUYEREMAIL          = $_POST["LGD_BUYEREMAIL"];
    $LGD_BUYERSSN            = $_POST["LGD_BUYERSSN"];
    $LGD_PRODUCTCODE         = $_POST["LGD_PRODUCTCODE"];
    $LGD_RECEIVER            = $_POST["LGD_RECEIVER"];
    $LGD_RECEIVERPHONE       = $_POST["LGD_RECEIVERPHONE"];
    $LGD_DELIVERYINFO        = $_POST["LGD_DELIVERYINFO"];

    $LGD_MERTKEY = $default[de_dacom_mertkey];  //LG 텔레콤에서 발급한 상점키로 변경해 주시기 바랍니다.
       
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
	  
    if ($LGD_HASHDATA2 == $LGD_HASHDATA) {      //해쉬값 검증이 성공하면
        if($LGD_RESPCODE == "0000"){            //결제가 성공이면
            
            $resp = write_success($_POST);

            /*
             * 거래성공 결과 상점 처리(DB) 부분
             * 상점 결과 처리가 정상이면 "OK"
             */    
            //if( 결제성공 상점처리결과 성공 ) resultMSG = "OK";   

            /*
            // 저장된 가격과 결제된 가격이 같은지 검사
            $sql = " select od_temp_bank, od_temp_card from $g4[yc4_order_table] where od_id = '$LGD_OID' ";
            $od = sql_fetch($sql);
            if ($LGD_PAYTYPE == 'SC0010') {
                $save_amount = $od[od_temp_card];
            } else {
                $save_amount = $od[od_temp_bank];
            }
            // 저장된 가격과 일치하지 않는다면
            if ($save_amount != $LGD_AMOUNT) 
                die("FAIL");
            */

            // 주문서의 카드입금 수정
            // 크래킹의 우려도 있으므로 on_uid 도 같이

            $sql = " update $g4[yc4_order_table] ";
            switch ($LGD_PAYTYPE)
            {
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

            }

            if ($result) 
                $resultMSG = "OK";
            else
                $resultMSG = "DB Error";
            
        }else {                                 //결제가 실패이면
            /*
             * 거래실패 결과 상점 처리(DB) 부분
             * 상점결과 처리가 정상이면 "OK"
             */  
           //if( 결제실패 상점처리결과 성공 ) resultMSG = "OK";    
			 $resp = write_failure($_POST);
        }
    } else {                                    //해쉬값 검증이 실패이면
        /*
         * hashdata검증 실패 로그를 처리하시기 바랍니다. 
         */  
		$resp = write_hasherr($_POST);
		$resultMSG = "결제결과 상점 DB처리(NOTE_URL) 해쉬값 검증이 실패하였습니다.";         
    }

    echo $resultMSG;        
?>
