<?php

	$configPath = "C:/lgdacom"; //LG유플러스에서 제공한 환경파일("/conf/lgdacom.conf") 위치 지정. 
	
    /*
     * [LG유플러스 환경파일 UPDATE]
     *
     * 이 페이지는 LG유플러스 환경파일을 UPDATE 합니다.(수정하지 마세요.)
     */
    $CST_PLATFORM   = $HTTP_POST_VARS["CST_PLATFORM"];
    $CST_MID        = $HTTP_POST_VARS["CST_MID"];
    $LGD_MID        = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;


    if($CST_MID == "TEST" || $CST_MID == "test" || $CST_MID == "lgdacomxpay") {
        $LGD_MERTKEY = "95160cce09854ef44d2edb2bfb05f9f3";
    } else {
        $LGD_MERTKEY				=  $default[de_dacom_mertkey];
    }


    if( $CST_PLATFORM == null || $CST_PLATFORM == "" ) {
        echo "[TX_PING error] 파라미터 누락<br>";
        return;
    }
    if( $LGD_MID == null || $LGD_MID == "" ) {
        echo "[TX_PING error] 파라미터 누락<br>";
        return;
    }

    require_once("./XPayClient.php");
    $xpay = &new XPayClient($configPath, $CST_PLATFORM, $LGD_MERTKEY);
    $xpay->Init_TX($LGD_MID);

    echo "patch result = ".$xpay->Patch("lgdacom.conf");
?>
