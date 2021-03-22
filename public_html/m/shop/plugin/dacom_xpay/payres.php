<?php
include_once("./_common.php");
header("Content-Type: text/html; charset=utf-8");
    /*
     * [최종결제요청 페이지(STEP2-2)]
     *
     * LG유플러스으로 부터 내려받은 LGD_PAYKEY(인증Key)를 가지고 최종 결제요청.(파라미터 전달시 POST를 사용하세요)
     */
	
	/* ※ 중요
	* 환경설정 파일의 경우 반드시 외부에서 접근이 가능한 경로에 두시면 안됩니다.
	* 해당 환경파일이 외부에 노출이 되는 경우 해킹의 위험이 존재하므로 반드시 외부에서 접근이 불가능한 경로에 두시기 바랍니다. 
	* 예) [Window 계열] C:\inetpub\wwwroot\lgdacom ==> 절대불가(웹 디렉토리)
	*/
	
	$configPath = "./lgdacom"; //LG유플러스에서 제공한 환경파일("/conf/lgdacom.conf,/conf/mall.conf") 위치 지정. 

    /*
     *************************************************
     * 1.최종결제 요청 - BEGIN
     *  (단, 최종 금액체크를 원하시는 경우 금액체크 부분 주석을 제거 하시면 됩니다.)
     *************************************************
     */
    $CST_PLATFORM               = $HTTP_POST_VARS["CST_PLATFORM"];
    $CST_MID                    = $HTTP_POST_VARS["CST_MID"];
    $LGD_MID                    = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;
    $LGD_PAYKEY                 = $HTTP_POST_VARS["LGD_PAYKEY"];


    if($CST_MID == "TEST" || $CST_MID == "test" || $CST_MID == "lgdacomxpay") {
        $LGD_MERTKEY = "95160cce09854ef44d2edb2bfb05f9f3";
    } else {
        $LGD_MERTKEY				=  $default[de_dacom_mertkey];
    }




    require_once("./lgdacom/XPayClient.php");
    $xpay = &new XPayClient($configPath, $CST_PLATFORM, $LGD_MERTKEY);
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
    if ($xpay->TX()) {
        //1)결제결과 화면처리(성공,실패 결과 처리를 하시기 바랍니다.)


		$od_id =         $xpay->Response("LGD_OID",0);                      // 주문서 번호
		$on_uid =        $HTTP_POST_VARS["on_uid"];           // ss_temp_on_uid 값
		$cd_mall_id =    $xpay->Response("LGD_MID",0);                      // 상점 아이디
		$cd_amount =     $xpay->Response("LGD_AMOUNT",0);                   // 금액
		$cd_app_no =     $xpay->Response("LGD_FINANCEAUTHNUM",0);               // 카드 승인 번호, 만약 승인이 나지 않으면 "XXXXXXXX"
		$cd_app_rt =     $xpay->Response("LGD_RESPCODE",0);                 // 카드 승인 결과 코드, 카드 승인 실패(T002) 성공(0000)
		$LGD_TIMESTAMP = $xpay->Response("LGD_TIMESTAMP",0);
		$cd_trade_ymd = substr($LGD_TIMESTAMP,0,4)."-".substr($LGD_TIMESTAMP,4,2)."-".substr($LGD_TIMESTAMP,6,2);
		$cd_trade_hms = substr($LGD_TIMESTAMP,8,2).":".substr($LGD_TIMESTAMP,10,2).":".substr($LGD_TIMESTAMP,12,2);
		$cd_opt01 =      $xpay->Response("LGD_BUYER",0);                    // 구매자 이름
		$cd_opt02 =      $xpay->Response("LGD_PRODUCTINFO",0);                 // 수취인 이름
		$transaction = $xpay->Response("LGD_TID",0);

		/*	
        echo "TX Response_code = " . $xpay->Response_Code() . "<br>";
        echo "TX Response_msg = " . $xpay->Response_Msg() . "<p>";
            
        echo "거래번호 : " . $xpay->Response("LGD_TID",0) . "<br>";
        echo "결과코드 : " . $xpay->Response("LGD_RESPCODE",0) . "<br>";
        echo "결과메세지 : " . $xpay->Response("LGD_RESPMSG",0) . "<p>";
            
        $keys = $xpay->Response_Names();
        foreach($keys as $name) {
            echo $name . " = " . $xpay->Response($name, 0) . "<br>";
        }
		*/
/*
	echo "--------------------------------------------<br>";
    echo $HTTP_POST_VARS["param_opt_1"]."<br>";
    echo $HTTP_POST_VARS["param_opt_2"]."<br>";
    echo $HTTP_POST_VARS["param_opt_3"]."<br>";
    echo $HTTP_POST_VARS["param_opt_4"]."<br>";
*/
        if( "0000" == $xpay->Response_Code() ) {
         	//최종결제요청 결과 성공 DB처리

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


            // // 장바구니 '준비' 상태로 변경
			// $sql = " update $g4[yc4_cart_table]
            //             set ct_status = '준비'
            //         where on_uid = '$on_uid' ";
            // sql_query($sql, TRUE);
            $sql = " update $g4[yc4_order_table] SET od_status='결제완료' WHERE on_uid='{$on_uid}' ";
            sql_query($sql, TRUE);


            // 포인트 결제를 했다면 실제 포인트 결제한 것으로 수정합니다. (settleresult.php까지 넘어가지 않은 경우에 대비해서 여기서 합니다)
			$sql = " select od_id, on_uid, od_receipt_point, od_temp_point, od_sch_no_e from $g4[yc4_order_table] where on_uid = '$on_uid' ";
			$row = sql_fetch($sql);
			if ($row[od_receipt_point] == 0 && $row[od_temp_point] != 0)
			{
				sql_query(" update $g4[yc4_order_table] set od_receipt_point = od_temp_point where on_uid = '$on_uid' ");
				insert_point($member[mb_id], (-1) * $row[od_temp_point], "주문번호:$row[od_id] 결제", "@order", $member[mb_id], "$row[od_id],$row[on_uid]");
            }


            //입금게시판에 추가
            $yc4Obj = new Yc4();
            $yc4Obj->insert_deposit_board('결제완료', $row);

            //결제완료 문자 전송
            if($row["od_sch_no_e"] != "0")
                Resv::SEND_SMS($row["od_id"], 5);
            else
                Resv::SEND_SMS($row["od_id"], 6);


            //최종결제요청 결과 성공 DB처리 실패시 Rollback 처리
          	//$isDBOK = true; //DB처리 실패시 false로 변경해 주세요.
          	if($isDBOK){
				echo '<body onload="document.f_payres.submit();">
							<form name="f_payres" method="post" action="'.$g4['shop_mpath'].'/settleresult.php">
								<input type="hidden" name="on_uid" value="'.$on_uid.'">
								<input type="hidden" name="state" value="mobile">
							</form>
						</body>
				';
			}else{
           		echo "<p>";
           		$xpay->Rollback("상점 DB처리 실패로 인하여 Rollback 처리 [TID:" . $xpay->Response("LGD_TID",0) . ",MID:" . $xpay->Response("LGD_MID",0) . ",OID:" . $xpay->Response("LGD_OID",0) . "]");            		            		
            		
                echo "TX Rollback Response_code = " . $xpay->Response_Code() . "<br>";
                echo "TX Rollback Response_msg = " . $xpay->Response_Msg() . "<p>";
            		
                if( "0000" == $xpay->Response_Code() ) {
                  	echo "자동취소가 정상적으로 완료 되었습니다.<br>";
                }else{
          			echo "자동취소가 정상적으로 처리되지 않았습니다.<br>";
                }
          	}            	
        }else{
          	//최종결제요청 결과 실패 DB처리
         	echo "최종결제요청 결과 실패 DB처리하시기 바랍니다.<br>";            	            
        }
    }else {
        //2)API 요청실패 화면처리
        echo "결제요청이 실패하였습니다.  <br>";
        echo "TX Response_code = " . $xpay->Response_Code() . "<br>";
        echo "TX Response_msg = " . $xpay->Response_Msg() . "<p>";
            
        //최종결제요청 결과 실패 DB처리
        echo "최종결제요청 결과 실패 DB처리하시기 바랍니다.<br>";            	                        
    }
?>
