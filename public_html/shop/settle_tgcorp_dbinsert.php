<?
include_once("./_common.php");
include_once("$g4[path]/lib/etc.lib.php");

//write_log("$g4[path]/data/log/tgcorp.log", $_POST);

$returnMsg = "";

 /*
    $Amount 
    $ReplyCode 
    $ReplyMessage
    $MxIssueNO
    $MxIssueDate
    $MSTR
    $MxHASH
*/ // 이와같은 형태로 넘어오는 값들을 받아서 사용하시면 되겠습니다.

//주문하신 상품의 가격과 return받은 Amount값이 같은지 확인해야 합니다.

/* 1. return받은 MxHASH값과 거래 data를 이용해 만든 HASH값을 비교한다.
HASH값 설정 관련
아래의 예제와 같이 
MxID, MxOTP, MxIssueNO, MxIssueDate, Amount 5개의 값을 이용하여
HASH key를 만들어 거래시 넘겨주시면
dbpath에서 HASH key를 넘겨 받아 
원거래의 정보가 바뀌지 않았는지 확인 할 수 있습니다.

아래의 mxid, mxotp, mxissueno, mxissuedate, amount는 
가맹점이 가지고 있는 data를 가져 와야 합니다.
*/

/*
$mxid        = "testcorp";
$mxotp       = "wr7yZ2OayGjj3eDo2XbA1jipf6S45ubp";
$mxissueno   = "1001";
$mxissuedate = "20040319143500";
$amount      = "2000";
*/

$sql = " select od_time, od_name from $g4[yc4_order_table] where od_id = '$MxIssueNO' and on_uid = '$MSTR' ";
$row = sql_fetch($sql);

$mxid        = $default[de_tgcorp_mxid];
$mxotp       = $default[de_tgcorp_mxotp];
$mxissueno   = $MxIssueNO;
//$mxissuedate = date("YmdHis",strtotime($row[od_time]));
$mxissuedate = $MxIssueDate;
$amount      = $Amount;
$currency    = "KRW";

$output = md5($mxid.$mxotp.$mxissueno.$mxissuedate.$amount.$currency);

if($MxHASH==$output) //보낸 거래 정보와 넘겨 받은 거래가 일치하는 경우
{     
    //1번, 혹은 2번의 구성을 삽입;
    if($ReplyCode=="00003000" || $ReplyCode=="00004000") //승인성공이면
    { 
        // 이 부분에 승인성공 결과를 data base에 저장하는 부분을 coding한다.
        $cd_trade_ymd = date("Y-m-d",strtotime($row[od_time]));
        $cd_trade_hms = date("H:i:s",strtotime($row[od_time]));
        //$cd_app_no = substr($ReplyMessage,-8);
        $cd_app_no = $ReplyMessage;

        $sql = "insert $g4[yc4_card_history_table]
                   set od_id = '$MxIssueNO',
                       on_uid = '$MSTR',
                       cd_mall_id = '$default[de_banktown_mid]',
                       cd_amount = '$amount',
                       cd_app_no = '$cd_app_no',
                       cd_app_rt = '$ReplyCode',
                       cd_trade_ymd = '$cd_trade_ymd',
                       cd_trade_hms = '$cd_trade_hms',
                       cd_opt01 = '$row[od_name]',
                       cd_time = '$g4[time_ymdhis]',
                       cd_ip = '$REMOTE_ADDR' ";
        $result = sql_query($sql, false);

        	// 장바구니 '준비' 상태로 변경
	$sql = " update $g4[yc4_cart_table]
        set ct_status = '준비'
    where on_uid = '$MSTR' ";
    sql_query($sql, TRUE);

        if($result) 
        {
            // 크래킹의 우려도 있으므로 on_uid 도 같이
            if ($Smode == '3001') {
                $sql = " update $g4[yc4_order_table]
                            set od_receipt_card = '$amount',
                                od_card_time = '$g4[time_ymdhis]'
                          where od_id = '$MxIssueNO'
                            and on_uid = '$MSTR' ";
                sql_query($sql, false);
            } else if ($Smode == '2501') { 
                $sql = " update $g4[yc4_order_table]
                            set od_receipt_bank = '$amount',
                                od_bank_time = '$g4[time_ymdhis]'
                          where od_id = '$MxIssueNO'
                            and on_uid = '$MSTR' ";
                sql_query($sql, false);
            } else if ($Smode == '2601' && $ReplyCode=="00004000") { // 가상계좌 발급 (입금전)
                $sql = " update $g4[yc4_order_table]
                            set od_bank_account = '$ReplyMessage',
                                od_receipt_bank = '0',
                                od_bank_time = ''
                          where od_id = '$MxIssueNO'
                            and on_uid = '$MSTR' ";
                sql_query($sql, false);
            } else if ($Smode == '2601' && $ReplyCode=="00003000") { // 가상계좌 입금 (입금후)
                $sql = " update $g4[yc4_order_table]
                            set od_receipt_bank = '$amount',
                                od_bank_time = '$g4[time_ymdhis]'
                          where od_id = '$MxIssueNO'
                            and on_uid = '$MSTR' ";
                sql_query($sql, false);
            }
            $returnMsg = "ACK=200OKOK";
        }
        else //디비저장실패는 승인실패, 즉 ReplyCode가 00003000이 아닌경우와 다릅니다.
        { 
            $returnMsg = "ACK=400FAIL";
        }
    }
} 
else //보낸 거래 정보와 넘겨 받은 거래 정보가 다르다 => 3자의 의한 조작 가능성 내포
{      
    $returnMsg = "ACK=400FAIL";
}

echo $returnMsg; 
?>