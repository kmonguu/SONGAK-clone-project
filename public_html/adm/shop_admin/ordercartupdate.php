<?
$sub_menu = "400400";
include_once("./_common.php");
include_once("./orderhistory.php");

auth_check($auth[$sub_menu], "w");


$optObj = new Yc4ItemOption();

$ostatus = array();

$cnt = count($_POST[ct_id]);
for ($i=0; $i<$cnt; $i++) 
{
    if ($_POST[ct_chk][$i]) 
    {
        $ct_id = $_POST[ct_id][$i];

        $sql = " select * from $g4[yc4_cart_table]
                  where on_uid = '$on_uid'
                    and ct_id  = '$ct_id' ";
        $ct = sql_fetch($sql);
        
        //변경 전 상태
        $ostatus[$ct["ct_id"]] = $ct["ct_status"];

        // 재고를 이미 사용했다면 (재고에서 이미 뺐다면)
        $stock_use = $ct[ct_stock_use];
        if ($ct[ct_stock_use]) 
        {
            if ($ct_status == '주문' || $ct_status == '취소' || $ct_status == '반품' || $ct_status == '품절') 
            {
                $stock_use = 0;
                // 재고에 다시 더한다.
                $sql =" update $g4[yc4_item_table] set it_stock_qty = it_stock_qty + '$ct[ct_qty]' where it_id = '$ct[it_id]' ";
                sql_query($sql);

                //옵션 재고 반영
                $optObj->set_qty($ct["ct_id"], true);
            }
        } 
        else 
        {
            // 재고 오류로 인한 수정
            // if ($ct_status == '주문' || $ct_status == '준비' || $ct_status == '배송' || $ct_status == '완료') {
            if ($ct_status == '배송' || $ct_status == '완료') 
            {
                $stock_use = 1;
                // 재고에서 뺀다.
                $sql =" update $g4[yc4_item_table] set it_stock_qty = it_stock_qty - '$ct[ct_qty]' where it_id = '$ct[it_id]' ";
                sql_query($sql);

                //옵션 재고 반영
                $optObj->set_qty($ct["ct_id"], false);
            } 
            /* 주문 수정에서 "품절" 선택시 해당 상품 자동 품절 처리하기
            else if ($ct_status == '품절') {
                $stock_use = 1;
                // 재고에서 뺀다.
                $sql =" update $g4[yc4_item_table] set it_stock_qty = 0 where it_id = '$ct[it_id]' ";
                sql_query($sql);
            } */
        }

        $point_use = $ct[ct_point_use];
        // 회원이면서 포인트가 0보다 크면
        // 이미 포인트를 부여했다면 뺀다.
        if ($mb_id && $ct[ct_point] && $ct[ct_point_use]) 
        {
            $point_use = 0;
            //insert_point($mb_id, (-1) * ($ct[ct_point] * $ct[ct_qty]), "주문번호 $od_id ($ct_id) 취소");
            delete_point($mb_id, "@delivery", $mb_id, "$od_id,$on_uid,$ct_id");
        }
        
        //로그
        setStateLog($ct_id, $_POST[od_id], $ct[it_id], $ct_status);

        //배송상태로 변경시 배송일시 자동 셋팅
		if($ct_status == "배송") {
			$od = sql_fetch(" SELECT * FROM $g4[yc4_order_table] WHERE on_uid = '$on_uid' ");
			if($od["od_invoice_time"] == "" || $od["od_invoice_time"] == "0000-00-00 00:00:00") {
				sql_query(" UPDATE $g4[yc4_order_table] SET od_invoice_time='".date("Y-m-d H:i:s")."' WHERE on_uid = '$on_uid' ");
			}
		}
        
        // 히스토리에 남김
        // 히스토리에 남길때는 작업|시간|IP|그리고 나머지 자료
        $ct_history="\n$ct_status|$now|$REMOTE_ADDR";

        $sql = " update $g4[yc4_cart_table]
                    set ct_point_use  = '$point_use',
                        ct_stock_use  = '$stock_use',
                        ct_status     = '$ct_status',
                        ct_history    = CONCAT(ct_history,'$ct_history')
                  where on_uid = '$on_uid'
                    and ct_id  = '$ct_id' ";
        sql_query($sql);
    }
}







//##########################################################################
//무통장일 경우, 상품 상태변경에 따르 입금액 자동 조정
$yc4Obj = new Yc4();
$od = $yc4Obj->get_order_byOnUid($on_uid);
if($od["od_settle_case"] == "무통장") { //무통장일 경우, 준비,배송,완료상태로 변경 시 자동 입금액 반영 
    //준비, 배송 상태의 상품 가격
    $inAmt = 0;
    $ctlist = $yc4Obj->list_cart($on_uid);
    $ccnt = 0;
    foreach($ctlist as $ct) {
        if($ostatus[$ct["ct_id"]] != "주문") {
            continue;
        }
        if($ct["ct_status"] == "준비" || $ct["ct_status"] == "배송" || $ct["ct_status"] == "완료") {
            $ccnt++;
            $inAmt += $ct["ct_amount"] * $ct["ct_qty"];
        }
    }

    if($ccnt > 0) {
        //무통장입금액 0수정시  (상품 부분 수정시 처음에만 계산)
        if($od["od_receipt_bank"] == 0 || $od["od_receipt_bank"] == "") {
            $inAmt += intval(str_replace(",", "", $od["od_send_cost"])); //배송비 더함
            $inAmt -= intval(str_replace(",", "", $od["od_receipt_point"])); //포인트 빼기
            $inAmt -= intval(str_replace(",", "", $od["od_coupon"])); //쿠폰빼기
        }

        if($inAmt > 0) {
            $inAmt += intval(str_replace(",", "", $od["od_receipt_bank"]));
            $yc4Obj->update_order_field_by_uid($on_uid, "od_receipt_bank", $inAmt);
        }
    }
}
//##########################################################################







$qstr = "sort1=$sort1&sort2=$sort2&sel_field=$sel_field&search=$search&page=$page";
$url = "./orderform.php?od_id=$od_id&$qstr";






// 1.06.06
$od = sql_fetch(" select od_receipt_point from $g4[yc4_order_table] where od_id = '$od_id' ");
if ($od[od_receipt_point])
    alert("포인트로 결제한 주문은,\\n\\n주문상태 변경으로 인해 포인트의 가감이 발생하는 경우\\n\\n회원관리 > 포인트관리에서 수작업으로 포인트를 맞추어 주셔야 합니다.\\n\\n만약, 미수금이 발생하는 경우에는 DC에 금액을 음수로 입력하시면 해결됩니다.", $url);
else
    goto_url($url);
?>
