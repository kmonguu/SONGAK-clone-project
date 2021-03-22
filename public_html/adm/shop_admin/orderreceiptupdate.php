<?
$sub_menu = "400400";
include_once("./_common.php");
include_once("$g4[path]/lib/mailer.lib.php");
include_once("$g4[path]/lib/icode.sms.lib.php");

auth_check($auth[$sub_menu], "w");

if ($od_bank_time) 
{
    if (check_datetime($od_bank_time) == false)
        alert("무통장 입금일시 오류입니다.");
}

if ($od_card_time) 
{
    if (check_datetime($od_card_time) == false)
        alert("신용카드 입금일시 오류입니다.");
}

//로그
include_once("./orderhistory.php");
setSettleLog($od_id, $_REQUEST);

$sql = " update $g4[yc4_order_table]
            set od_deposit_name  = '$od_deposit_name',
                od_bank_account  = '$od_bank_account',
                od_bank_time     = '$od_bank_time',
                od_card_time     = '$od_card_time',
                od_receipt_bank  = '$od_receipt_bank',
                od_receipt_card  = '$od_receipt_card',
				od_receipt_point = '$od_receipt_point',
				od_coupon = '$od_coupon',
                od_cancel_card   = '$od_cancel_card',
                od_dc_amount     = '$od_dc_amount',
                od_refund_amount = '$od_refund_amount',
                dl_id            = '$dl_id',
                od_invoice       = '$od_invoice',
                od_invoice_time  = '$od_invoice_time' ";
if (isset($od_send_cost))
    $sql .= " , od_send_cost = '$od_send_cost' ";
$sql .= " where od_id = '$od_id' ";
sql_query($sql);

// 미수금이 없을때 상품준비중으로 수정 cart table ///////////////////////
$od_info = sql_fetch("SELECT * FROM $g4[yc4_order_table] WHERE od_id = '$od_id' ");
$ct_result = sql_query("SELECT * FROM $g4[yc4_cart_table] WHERE on_uid = '$od_info[on_uid]' ");
$c = 0;
$ct_id = array();
for($i=0;$ct_info = sql_fetch_array($ct_result);$i++){
    if ($ct_info[ct_status]=='주문') {
		$t_ct_amount[정상] += $ct_info[ct_amount] * $ct_info[ct_qty];
		$ct_id[$c] = $ct_info[ct_id];
		$c++;
	}
}
// 주문금액 = 상품구입금액 + 배송비
$amount[정상] = $t_ct_amount[정상] + $od_info[od_send_cost];

// 입금액 = 무통장 + 신용카드 + 포인트
$amount[입금] = $od_info[od_receipt_bank] + $od_info[od_receipt_card] + $od_info[od_receipt_point] + $od_info["od_coupon"];

// 미수금 = (주문금액 - DC + 환불액) - (입금액 - 신용카드승인취소)
$amount[미수] = ($amount[정상] - $od_info[od_dc_amount] + $od_info[od_refund_amount]) - ($amount[입금] - $od_info[od_cancel_card]);

if($amount[미수] <= 0){
	for($j=0;$j < count($ct_id);$j++){
		$sql = "UPDATE $g4[yc4_cart_table] SET
					ct_status = '준비'
					WHERE ct_id = '$ct_id[$j]'
		";
		sql_query($sql);
	}
}
////////////////////////////////////////////////////////////////////////////////
// 운송장번호에 값이 있을면 배송으로 수정 cart table ///////////////////////
if($od_invoice){
	$ct_result2 = sql_query("SELECT * FROM $g4[yc4_cart_table] WHERE on_uid = '$od_info[on_uid]' ");

	for($i=0;$ct_info2 = sql_fetch_array($ct_result2);$i++){
		if ($ct_info2[ct_status]=='준비') {
			$sql = "UPDATE $g4[yc4_cart_table] SET
						ct_status = '배송'
						, ct_stock_use  = '1'
						WHERE ct_id = '$ct_info2[ct_id]'
			";
			sql_query($sql);
			$sql =" update $g4[yc4_item_table] set it_stock_qty = it_stock_qty - '$ct_info2[ct_qty]' where it_id = '$ct_info2[it_id]' ";
			sql_query($sql);
		}
	}
}
////////////////////////////////////////////////////////////////////////////////




//멀티 배송지 업데이트
$mdObj = new Yc4MultiDelivery();
for($idx = 0 ; $idx < count($_POST["md_no"]) ;$idx++){
	$params = array();
	$params["no"] = $_POST["md_no"][$idx];
	$params["md_dl_id"] = $_POST["md_dl_id"][$idx];
	$params["md_invoice"] = $_POST["md_invoice"][$idx];
	$params["md_invoice_time"] = $_POST["md_invoice_time"][$idx];

	$mdObj->dl_update($params);
}





// 메일발송
define("_ORDERMAIL_", true);
include "./ordermail.inc.php";


// SMS 문자전송
define("_ORDERSMS_", true);
include "./ordersms.inc.php";


//알림톡 입금확인 전송
if ($od_kko_ipgum_check) {
	//알림톡 전송
	APIStoreKKO::SEND_ORDER("deposit", $od_id, $od_hp);
}


//알림톡 배송정보 전송
if ($od_kko_baesong_check) {

	$md_cnt = 0;
	for($idx = 0 ; $idx < count($_POST["md_no"]) ;$idx++){
		$md_cnt++;
		$md_no = $_POST["md_no"][$idx];
		
		//다중배송지 알림톡 전송
		APIStoreKKO::SEND_ORDER("delivery", $od_id, $od_hp, $md_no);
	}

	if($md_cnt == 0) {
		//알림톡 전송
		APIStoreKKO::SEND_ORDER("delivery", $od_id, $od_hp);
	}
}



$qstr = "sort1=$sort1&sort2=$sort2&sel_field=$sel_field&search=$search&page=$page";

goto_url("./orderform.php?od_id=$od_id&$qstr");
?>
