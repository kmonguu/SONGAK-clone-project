<?
include_once("./_common.php");

include_once("./settle_banktown_callback.php");

// 뱅크타운에서 받은 value
$P_STATUS;	// 거래상태: 0021(성공), 0031(실패), 0032(실패:중복거래), 0000(진행)
$P_TR_NO;   // 거래번호
$P_AUTH_DT; // 승인시간 
$P_AUTH_NO; // 승인번호
$P_TYPE;    // 거래종류 (CARD, BANK)
$P_MID;    	// 회원사아이디
$P_OID;   	// 주문번호
$P_FN_CD1;  // 금융사코드(은행코드, 카드코드)
$P_FN_CD2;  // 금융사코드2(은행코드, 카드코드)
$P_FN_NM;   // 금융사명(은행명, 카드사명)
$P_UNAME;   // 주문자명
$P_AMT;     // 거래금액
$P_NOTI;    // 주문정보
$P_RMESG1;  // 메시지1
$P_RMESG2;  // 메시지2

$P_HASH = get_param(P_HASH);
$P_STATUS = get_param(P_STATUS);
$P_TR_NO = get_param(P_TR_NO);
$P_AUTH_DT = get_param(P_AUTH_DT);
$P_AUTH_NO = get_param(P_AUTH_NO);
$P_TYPE = get_param(P_TYPE);
$P_MID = get_param(P_MID);
$P_OID = get_param(P_OID);
$P_FN_CD1 = get_param(P_FN_CD1);
$P_FN_CD2 = get_param(P_FN_CD2);
$P_FN_NM = get_param(P_FN_NM);
$P_UNAME = get_param(P_UNAME);
$P_AMT = get_param(P_AMT);
$P_NOTI = get_param(P_NOTI);
$P_RMESG1 = get_param(P_RMESG1);
$P_RMESG2 = get_param(P_RMESG2);

/* mid가 bt_test인 경우에 사용합니다
   해당 회원사 id당 하나의 auth_key가 발급됩니다
   발급받으신 auth_key를 설정하셔야 합니다 */
//$PG_AUTH_KEY = "1dffe7648bbd6defe69bd50112f0badc";    
$PG_AUTH_KEY = $default[de_banktown_auth_key];    


/* P_NOTI의 값을  <input type="hidden" name="P_NOTI" value="name1=value1,name2=value2">처럼 넘긴 경우에 
   P_NOTI내의 name1, name2값을 추출하는 경우 다음처럼 하시면 됩니다 */
$noti_param = split(",", $P_NOTI);
for($i = 0; $i < sizeof($noti_param); $i++) {
    $name_value = split("=", $noti_param[$i]);
    if($name_value[0] == "name1") {
            $name1 = $name_value[1];
    }
    else if($name_value[0] == "name2") {
            $name2 = $name_value[1];
    }
}


/* hash 값 체크는 banktown pg 서버에서 전송한 결과 데이타 값들과
   회원사 결과 페이지에서 수신한 데이타 값들의 동일 여부를 체크를 위한것입니다.
   지불 결과 페이지에서는 결과코드(P_STATUS)의 값에 따라 지불 결과를 고객에게 단순히 화면만 처리하시고
   지불 성공/실패 유무의 최종 판단 및 DB 처리는 노티(noti) 에서 처리하시기를 권장합니다 */
if (md5($P_STATUS.$P_TR_NO.$P_AUTH_DT.$P_TYPE.$P_MID.$P_OID.$P_AMT.$PG_AUTH_KEY) == $P_HASH) {
    // 신용카드 승인이 정상이면 P_STATUS =  "0021"
    if($P_STATUS == "0021"){
        //echo "0021 : success <br>";

        $on_uid = $name2;

        /*
        $ymd = sprintf("%s-%s-%s", substr($P_AUTH_DT,0,4), substr($P_AUTH_DT,4,2), substr($P_AUTH_DT,6,2));
        $hms = sprintf("%s:%s:%s", substr($P_AUTH_DT,8,2), substr($P_AUTH_DT,10,2), substr($P_AUTH_DT,12,2));
        // 신용카드내역에 생성
        $sql = "insert $cfg[table_card_history]
                   set od_id = '$P_OID',
                       on_uid = '$on_uid',
                       cd_mall_id = '$P_MID',
                       cd_amount = '$P_AMT',
                       cd_app_no = '$P_AUTH_NO',
                       cd_app_rt = '$P_STATUS',
                       cd_trade_ymd = '$ymd',
                       cd_trade_hms = '$hms',
                       cd_opt01 = '$name1',
                       cd_time = '$now',
                       cd_ip = '$REMOTE_ADDR' ";
        sql_query($sql);

        // 주문서의 카드입금 수정
        // 크래킹의 우려도 있으므로 on_uid 도 같이
        $sql = " update $cfg[table_order]
                    set od_receipt_card = '$P_AMT',
                        od_card_time = '$now'
                  where od_id = '$P_OID'
                    and on_uid = '$on_uid' ";
        sql_query($sql);
        */

    }else if($P_STATUS == "0031"){
        alert("신용카드 승인이 실패하였습니다.", $g4[path]);
        //echo "0031 : fail <br>";
    }else if($P_STATUS == "0032" ){
        alert("신용카드 중복 승인이 발생하였습니다.", $g4[path]);
        //echo "0032 : duplicate <br>";
    }else if($P_STATUS == "0000"){
        //echo "0000 : processing <br>";
    }else{
        //echo "undefined error <br>";
    }
}
else {
    if ($P_STATUS == "0033"){
        //echo "0033 : cancel <br>";
    }else if($P_STATUS == "0035"){
        //echo "0035 : recp info error <br>";        
    }else{
        //echo "hash error <br>";
    }
}

//gotourl("./?doc=$cart_dir/ordercardresult.php&on_uid=$on_uid");
goto_url("./settleresult.php?on_uid=$on_uid");
?>

<!--

<br><br>
P_HASH:<?= $P_HASH ?><br>
MD5_HASH:<?= $md5_hash = md5($P_STATUS.$P_TR_NO.$P_AUTH_DT.$P_TYPE.$P_MID.$P_OID.$P_AMT.$PG_AUTH_KEY); ?><br><br>
        
P_STATUS:<?= $P_STATUS ?><br>
P_TR_NO:<?= $P_TR_NO ?><br>
P_AUTH_DT:<?= $P_AUTH_DT ?><br>
P_AUTH_NO:<?= $P_AUTH_NO ?><br>
P_TYPE:<?= $P_TYPE ?><br>
P_MID:<?= $P_MID ?><br>
P_OID:<?= $P_OID ?><br>
P_FN_CD1:<?= $P_FN_CD1 ?><br>
P_FN_CD2:<?= $P_FN_CD2 ?><br>
P_FN_NM:<?= $P_FN_NM ?><br>
P_UNAME:<?= $P_UNAME ?><br>
P_AMT:<?= $P_AMT ?><br>
P_NOTI:<?= $P_NOTI ?><br>
&nbsp&nbsp&nbsp P_NOTI name1 : <?= $name1 ?><br>
&nbsp&nbsp&nbsp P_NOTI name2 : <?= $name2 ?><br>
P_RMESG1:<?= $P_RMESG1 ?><br>
P_RMESG2:<?= $P_RMESG2 ?><br>


</body>
</html>
-->