<?php
include_once("./_common.php");

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


$on_uid       = $_POST["a"];             // ss_temp_on_uid 값

if ($_POST[reAuthyn] == "O")
{
    /*
    $od_id        = $_POST["reOrdno"];       // 주문서 번호
    $on_uid       = $_POST["a"];             // ss_temp_on_uid 값
    $cd_mall_id   = $default['de_kspay_id']; // 상점 아이디
    $cd_trade_ymd = preg_replace("/(\d{4})(\d{2})(\d{2})/", "\\1-\\2-\\3", $_POST["reTrddt"]);  // 해당 거래 발생의 년,월,일
    $cd_trade_hms = preg_replace("/(\d{2})(\d{2})(\d{2})/", "\\1-\\2-\\3", $_POST["reTrdtm"]);  // 해당 거래 발생의 시,분,초
    $cd_opt01     = $_POST["sndOrdername"];     // 이름
    $cd_amount    = $_POST["sndAmount"]; // 금액

    $sql = " select od_settle_case from $g4[yc4_order_table] where od_id = '$od_id' and on_uid = '$on_uid' ";
    $row = sql_fetch($sql);
    if ($row[od_settle_case] == '신용카드')
    {
        $cd_app_no    = $_POST["reAuthno"];  // 승인 번호
        $cd_app_rt    = $_POST["reIsscd"];

        $sql = " update $g4[yc4_order_table]
                    set od_receipt_card = '$cd_amount',
                        od_card_time = '$g4[time_ymdhis]'
                  where od_id = '$od_id'
                    and on_uid = '$on_uid' ";
        sql_query($sql);
    }
    else if ($row[od_settle_case] == '가상계좌')
    {
        $idx = trim((string)$_POST['reIsscd']);
        $bank = $abank[$idx];
        $sql = " update $g4[yc4_order_table]
                    set od_bank_account = '$bank $_POST[reIsscd]'
                  where od_id = '$od_id'
                    and on_uid = '$on_uid' ";
        sql_query($sql);
    }
    else if ($row[od_settle_case] == '계좌이체')
    {
        $cd_app_no = $_POST['reTrno'];
        $cd_app_rt = $_POST['reMsg2'];

        $idx = trim((string)$_POST['reIsscd']);
        $bank = $abank[$idx];
        $sql = " update $g4[yc4_order_table]
                    set od_bank_account = '$bank $_POST[reIsscd]',
                        od_receipt_bank = '$cd_amount',
                        od_bank_time    = '$g4[time_ymdhis]'
                  where od_id = '$od_id'
                    and on_uid = '$on_uid' ";
        sql_query($sql);

        //print_r2($_POST); exit;
    }
    else
    {
        alert("\$od_settle_case 정보가 없습니다.", $g4[path]);
    }

    $sql = "insert $g4[yc4_card_history_table]
               set od_id = '$od_id',
                   on_uid = '$on_uid',
                   cd_mall_id = '$cd_mall_id',
                   cd_amount = '$cd_amount',
                   cd_app_no = '$cd_app_no',
                   cd_app_rt = '$cd_app_rt',
                   cd_trade_ymd = '$cd_trade_ymd',
                   cd_trade_hms = '$cd_trade_hms',
                   cd_opt01 = '$cd_opt01',
                   cd_time = '$g4[time_ymdhis]',
                   cd_ip = '$_SERVER[REMOTE_ADDR]' ";
    sql_query($sql);
    */

	goto_url("./settleresult.php?on_uid=$on_uid");
}
?>
<? if ($_POST[reAuthyn] == "X") { ?>
<script language='javascript'>
var str = '';
str += '※ 오류가 발생하였습니다. \n';
str += ' \n';
str += '-----------------------------Result Data---------------------------------- \n';
str += '승인구분    : <?=($_POST[reAuthyn]=="O"?"승인":"거절")?> \n';
str += '거래번호    : <?=$_POST[reTrno]?> \n';
str += '거래일자    : <?=$_POST[reTrddt]?> \n';
str += '거래시간    : <?=$_POST[reTrdtm]?> \n';
str += '승인번호    : <?=$_POST[reAuthno]?> \n'; // 카드사에서 넘기는 값
str += '주문번호    : <?=$_POST[reOrdno]?> \n';
str += '메세지 1    : <?=$_POST[reMsg1]?> \n'; // 카드사에서 넘기는 값
str += '메세지 2    : <?=$_POST[reMsg2]?> \n';
str += 'a           : <?=$_POST[a]?> \n';
str += 'b           : <?=$_POST[b]?> \n';
str += 'c           : <?=$_POST[c]?> \n';
str += 'd           : <?=$_POST[d]?> \n';
str += '--------------------------------------------------------------------------';
alert(str);

document.location.href = "../";
</script>
<? } ?>