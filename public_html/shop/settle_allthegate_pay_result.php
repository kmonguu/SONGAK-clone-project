<?php
include_once("./_common.php");
//include_once("$g4[path]/lib/etc.lib.php");
//write_log("$g4[path]/data/log/allthegate_pay_result.log", $_POST);

//print_r2($_POST); exit;

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
$abank['88'] = '신한은행'; 
$abank['93'] = '새마을금고';

/**********************************************************************************************
*
* 파일명 : AGS_pay_result.php
* 작성일자 : 2005/03
*
* 소켓결제결과를 처리합니다.
*
* Copyright 2004-2005 AEGISHYOSUNG.Co.,Ltd. All rights reserved.
*
**********************************************************************************************/

$AuthTy 		= trim( $_POST["AuthTy"] );			//결제형태
$SubTy 		= trim( $_POST["SubTy"] );			//서브결제형태
$rStoreId 		= trim( $_POST["rStoreId"] );			//업체ID
$rBusiCd 		= trim( $_POST["rBusiCd"] );			//전문코드
$rOrdNo 		= trim( $_POST["rOrdNo"] );			//주문번호
$rProdNm 		= trim( $_POST["rProdNm"] );			//상품명
$rApprNo 		= trim( $_POST["rApprNo"] );			//승인번호
$rAmt 		= trim( $_POST["rAmt"] );			//거래금액
$rSuccYn 		= trim( $_POST["rSuccYn"] );			//성공여부
$rResMsg 		= trim( $_POST["rResMsg"] );			//실패사유
$rApprTm 		= trim( $_POST["rApprTm"] );			//승인시각
$rCardCd 		= trim( $_POST["rCardCd"] );			//카드사코드
$rCardNm 		= trim( $_POST["rCardNm"] );			//카드사명
$rMembNo 		= trim( $_POST["rMembNo"] );			//가맹점번호
$rAquiCd 		= trim( $_POST["rAquiCd"] );			//매입사코드
$rAquiNm 		= trim( $_POST["rAquiNm"] );			//매입사명
$rBillNo 		= trim( $_POST["rBillNo"] );			//전표번호
$rDealNo 		= trim( $_POST["rDealNo"] );			//거래고유번호
$ICHE_OUTBANKNAME = trim( $_POST["ICHE_OUTBANKNAME"] );	//이체계좌은행명
$ICHE_OUTACCTNO 	= trim( $_POST["ICHE_OUTACCTNO"] );		//이체계좌번호
$ICHE_OUTBANKMASTER = trim( $_POST["ICHE_OUTBANKMASTER"] );	//이체계좌소유주
$ICHE_AMOUNT 	= trim( $_POST["ICHE_AMOUNT"] );		//이체금액
$rHP_TID 		= trim( $_POST["rHP_TID"] );			//핸드폰결제TID
$rHP_DATE 		= trim( $_POST["rHP_DATE"] );			//핸드폰결제날짜
$rHP_HANDPHONE 	= trim( $_POST["rHP_HANDPHONE"] );		//핸드폰결제핸드폰번호
$rHP_COMPANY 	= trim( $_POST["rHP_COMPANY"] );		//핸드폰결제통신사명(SKT,KTF,LGT)
$rVirNo 		= trim( $_POST["rVirNo"] );			//가상계좌번호 가상계좌추가
$VIRTUAL_CENTERCD = trim( $_POST["VIRTUAL_CENTERCD"] );	//가상계좌번호 가상계좌추가
$mTId 		= trim( $_POST["mTId"] );

$od_id = $rOrdNo;

//print_r2($_POST); exit;

if (($_POST[rSuccYn] == 'y' || $_POST[rSuccYn] == '') && $_POST[on_uid]) 
{
    switch ($AuthTy)
    {
        // 신용카드
        case 'card' :

            /*
            --------------------------------------------
            shop/settle_allthegate_pay_ing.php 에서 처리
            07.08.09
            --------------------------------------------
            $cd_trade_ymd = substr($rApprTm,0,8);
            $cd_trade_hms = substr($rApprTm,8,6);

            $sql = "insert $g4[yc4_card_history_table]
                       set od_id = '$od_id',
                           on_uid = '$on_uid',
                           cd_mall_id = '$rStoreId',
                           cd_amount = '$rAmt',
                           cd_app_no = '$rApprNo',
                           cd_app_rt = '$rResMsg',
                           cd_trade_ymd = '$cd_trade_ymd',
                           cd_trade_hms = '$cd_trade_hms',
                           cd_quota = '',
                           cd_opt01 = '',
                           cd_time = '$g4[time_ymdhis]',
                           cd_ip = '$_SERVER[REMOTE_ADDR]' ";
            sql_query($sql);

            $sql = " update $g4[yc4_order_table]
                        set od_receipt_card = '$rAmt',
                            od_card_time    = '$g4[time_ymdhis]'
                      where od_id = '$od_id'
                        and on_uid = '$on_uid' ";
            sql_query($sql);
            */
            
            break;

        // 계좌이체
        case 'iche' :
        case 'eiche' :

            /*
            --------------------------------------------
            shop/settle_allthegate_pay_ing.php 에서 처리
            07.08.09
            --------------------------------------------
            $cd_trade_ymd = date("Ymd", $g4['server_time']);
            $cd_trade_hms = date("His", $g4['server_time']);

            $sql = "insert $g4[yc4_card_history_table]
                       set od_id = '$od_id',
                           on_uid = '$on_uid',
                           cd_mall_id = '$rStoreId',
                           cd_amount = '$rAmt',
                           cd_app_no = '$rOrdNo',
                           cd_app_rt = '$AuthTy',
                           cd_trade_ymd = '$cd_trade_ymd',
                           cd_trade_hms = '$cd_trade_hms',
                           cd_quota = '',
                           cd_opt01 = '$ICHE_OUTBANKMASTER',
                           cd_time = '$g4[time_ymdhis]',
                           cd_ip = '$_SERVER[REMOTE_ADDR]' ";
            sql_query($sql);

            $sql = " update $g4[yc4_order_table]
                        set od_bank_account = '$ICHE_OUTBANKNAME',
                            od_receipt_bank = '$rAmt',
                            od_bank_time    = '$g4[time_ymdhis]'
                      where od_id = '$od_id'
                        and on_uid = '$on_uid' ";
            sql_query($sql);
            */
            
            break;

        // 가상계좌
        case 'virtual' :
        case 'evirtual' :

            /*
            --------------------------------------------
            shop/settle_allthegate_pay_ing.php 에서 처리
            07.08.09
            --------------------------------------------
            $cd_trade_ymd = substr($mTid,0,8);
            $cd_trade_hms = substr($mTid,8,6);

            $sql = "insert $g4[yc4_card_history_table]
                       set od_id = '$od_id',
                           on_uid = '$on_uid',
                           cd_mall_id = '$rStoreId',
                           cd_amount = '$rAmt',
                           cd_app_no = '$rVirNo',
                           cd_app_rt = '$rResMsg',
                           cd_trade_ymd = '$cd_trade_ymd',
                           cd_trade_hms = '$cd_trade_hms',
                           cd_quota = '',
                           cd_opt01 = '',
                           cd_time = '$g4[time_ymdhis]',
                           cd_ip = '$_SERVER[REMOTE_ADDR]' ";
            sql_query($sql);

            $bank = $abnk[VIRTUAL_CENTERCD];

            $sql = " update $g4[yc4_order_table]
                        set od_bank_account = '$bank $rVirNo',
                            od_receipt_bank = '0',
                            od_bank_time    = ''
                      where od_id = '$od_id'
                        and on_uid = '$on_uid' ";
            sql_query($sql);
            */
            
            break;
    }

    goto_url("./settleresult.php?on_uid=$on_uid");
} 
else 
{
    alert("정상 승인되지 않았습니다.\\n\\n오류메세지 : $_POST[rResMsg]", $g4[path]);
}
?>
