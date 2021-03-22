<?
include_once("./_common.php");

// 장바구니가 비어있는가?
if (get_session("ss_direct"))
    $tmp_on_uid = get_session("ss_on_direct");
else
    $tmp_on_uid = get_session("ss_on_uid");

if (get_cart_count($tmp_on_uid) == 0)// 장바구니에 담기
    alert("장바구니가 비어 있습니다.\\n\\n이미 주문하셨거나 장바구니에 담긴 상품이 없는 경우입니다.", "./cart.php");

$error = "";
// 장바구니 상품 재고 검사
// 1.03.07 : and a.it_id = b.it_id : where 조건문에 이 부분 추가
$sql = " select 
                a.it_id,
                a.ct_qty,
                a.ct_id,
                a.it_option1,
                a.it_option2,
                a.it_option3,
                b.it_name
           from $g4[yc4_cart_table] a,
                $g4[yc4_item_table] b
          where a.on_uid = '$tmp_on_uid'
            and a.it_id = b.it_id ";


$optObj = new Yc4ItemOption();
$result = sql_query($sql);
$item_names = "";
for ($i=0; $row=sql_fetch_array($result); $i++)
{

	// 상품에 대한 현재고수량
	if($row["it_option1"] == "" && $row["it_option2"] == "" && $row["it_option3"] == "") {
		
		//옵션이 없을경우 상품자체의 수량 
		$it_stock_qty = (int)get_it_stock_qty($row[it_id], $row["ct_id"]);
		// 장바구니 수량이 재고수량보다 많다면 오류
		if ($row[ct_qty] > $it_stock_qty)
			$error .= "$row[it_name] 의 재고수량이 부족합니다. 재고수량 : $it_stock_qty 개\\n\\n";


	} else {
		
		//옵션 수량
		$opt_qty = $optObj->get_qty($row["it_id"], $row["ct_id"], $row["it_option1"], $row["it_option2"], $row["it_option3"]); //현재 재고
		$qty = $row["ct_qty"]; //빌리는 수
		$strOpt = "";
		if($qty > $opt_qty) {
			$strOpt = $row["it_option1"];
			if($row["it_option2"] != "") $strOpt .= " / ". $row["it_option2"];
			if($row["it_option3"] != "") $strOpt .= " / ". $row["it_option3"];
			$error .= "\\n{$row[it_name]} [ {$strOpt} ] 상품의 재고가 부족합니다.  재고수량 : $opt_qty 개\\n\\n";
		}
    }
    
    if($item_names != "") $item_names .= ",";
    $item_names .= $row["it_name"];
}


if ($error != "")
{
    $error .= "다른 고객님께서 {$od_name}님 보다 먼저 주문하신 경우입니다. 불편을 끼쳐 죄송합니다.";
    alert($error);
}

// , 를 없애고
$od_receipt_bank = (int)str_replace(",", "", $od_receipt_bank);
$od_receipt_card = (int)str_replace(",", "", $od_receipt_card);
if ($od_settle_case == "무통장")
{
    $od_temp_point = (int)str_replace(",", "", $od_temp_point);
    $od_receipt_point = (int)str_replace(",", "", $od_temp_point);
}
else
{
    $od_temp_point = (int)str_replace(",", "", $od_temp_point);
    $od_receipt_point = 0;
}
//if ($is_admin) { echo $od_receipt_card; exit; }

if ($od_temp_point)
{
    if ($member[mb_point] < $od_temp_point)
        alert("회원님의 포인트가 부족하여 포인트로 결제 할 수 없습니다.");
}



//쿠폰 가격 계산
$ycart = new Yc4();
$cpnObj = new Yc4Coupon();

if($coupon != ""){
	$cpns = explode("|", $coupon);
	$cpAmt = 0;
	foreach($cpns as $cp){
		
		$cptmp = explode("::", $cp);

		$cpid = $cptmp[0];
		$ctid = $cptmp[1];

		$cpAmt += $cpnObj->cal_cpn_amount($cpid, $ctid);
		

		//쿠폰 사용처리
		$cpnObj->use_coupon($cpid);
	}
}



//로그인된 경우 회원아이디로 장바구니테이블에 저장된 ON_UID를 유니크한 KEY로 변경
if($member["mb_id"]) { 

	$mb_on_uid = $tmp_on_uid;
	$tmp_on_uid = get_unique_id();

	$sql = "UPDATE {$g4["yc4_cart_table"]} SET on_uid='{$tmp_on_uid}' WHERE on_uid='{$mb_on_uid}' ";
	sql_query($sql);

}


// 새로운 주문번호를 얻는다.
$od_id = get_new_od_id();

// 주문서에 입력
$sql = " insert $g4[yc4_order_table]
            set od_id             = '$od_id',
                on_uid            = '$tmp_on_uid',
                mb_id             = '$member[mb_id]',
                od_pwd            = '$od_pwd',
                od_name           = '$od_name',
                od_email          = '$od_email',
                od_tel            = '$od_tel',
                od_hp             = '$od_hp',
                od_zip1           = '$od_zip1',
                od_zip2           = '$od_zip2',
                od_addr1          = '$od_addr1',
                od_addr2          = '$od_addr2',
                od_b_name         = '$od_b_name',
                od_b_tel          = '$od_b_tel',
                od_b_hp           = '$od_b_hp',
                od_b_zip1         = '$od_b_zip1',
                od_b_zip2         = '$od_b_zip2',
                od_b_addr1        = '$od_b_addr1',
                od_b_addr2        = '$od_b_addr2',
                od_deposit_name   = '$od_deposit_name',
                od_memo           = '$od_memo',
                od_send_cost      = '$od_send_cost',
                od_temp_bank      = '$od_receipt_bank',
                od_temp_card      = '$od_receipt_card',
                od_temp_point     = '$od_temp_point',
                od_receipt_bank   = '0',
                od_receipt_card   = '0',
                od_receipt_point  = '$od_receipt_point',
                od_coupon 			= '$cpAmt',
                od_bank_account   = '$od_bank_account',
                od_shop_memo      = '',
                od_hope_date      = '$od_hope_date',
                od_time           = '$g4[time_ymdhis]',
                od_ip             = '$REMOTE_ADDR',
                od_settle_case    = '$od_settle_case'
                , od_delivery_cnt = '$od_delivery_cnt'
                ";
sql_query($sql);

// 장바구니 쇼핑에서 주문으로
// 신용카드로 주문하면서 신용카드 포인트 사용하지 않는다면 포인트 부여하지 않음
$sql_card_point = "";
if ($od_receipt_card > 0 &&  $default[de_card_point] == false) {
    $sql_card_point = " , ct_point = '0' ";
}
$sql = "update $g4[yc4_cart_table]
           set ct_status = '주문'
               $sql_card_point
         where on_uid = '$tmp_on_uid' ";
sql_query($sql);

// 회원이면서 포인트를 사용했다면 포인트 테이블에 사용을 추가
if ($member[mb_id] && $od_receipt_point) {
    insert_point($member[mb_id], (-1) * $od_receipt_point, "주문번호 $od_id 결제");
}

$od_memo = nl2br(htmlspecialchars2(stripslashes($od_memo))) . "&nbsp;";




//다중 배송지 처리
if($_REQUEST["od_delivery_cnt"] > 1){
	
	$mdObj = new Yc4MultiDelivery();

	$cnt = 0;
	for($idx = 0 ; $idx < count($_POST["md_no"]) ; $idx++){ 
	
		$cnt = $idx+1; 
		$md_b_name = $_POST["md_b_name"][$cnt];
		$md_b_tel = $_POST["md_b_tel"][$cnt];
		$md_b_hp = $_POST["md_b_hp"][$cnt];
		$md_b_zip1 = $_POST["md_b_zip1"][$cnt];
		$md_b_addr1 = $_POST["md_b_addr1"][$cnt];
		$md_b_addr2 = $_POST["md_b_addr2"][$cnt];
		$md_memo= $_POST["md_memo"][$cnt];

		
		$params = array();
		$params["od_id"] = $od_id;
		$params["md_name"] = $md_b_name;
		$params["md_tel"] = $md_b_tel;
		$params["md_hp"] = $md_b_hp;
		$params["md_zip1"] = $md_b_zip1;
		$params["md_addr1"] = $md_b_addr1;
		$params["md_addr2"] = $md_b_addr2;
		$params["md_memo"] = $md_memo;
		
		$qtyStr = "";
		for($cidx = 0 ; $cidx < count($_POST["md_qty"][$cnt]); $cidx++){

			//수량 입력	
			if($qtyStr != "") $qtyStr .= "||";
			$qtyStr.=trim($_POST["md_qty_itname"][$cnt][$cidx])."|".$_POST["md_qty"][$cnt][$cidx]."";
		
		}
		$params["md_qty"] = $qtyStr;
		
		$mdObj->insert($params);

	}

}







include_once($g4[shop_path]."/ordermail1.inc.php");

if ($od_settle_case == "무통장") {

    include_once($g4[shop_path]."/ordermail2.inc.php");
    
    //알림톡 전송
	APIStoreKKO::SEND_ORDER("order", $od_id, $od_hp);
}

// SMS BEGIN --------------------------------------------------------
// 쇼핑몰 운영자가 수신자가 됨
$receive_number = preg_replace("/[^0-9]/", "", ($default[de_sms_hp2] ? $default[de_sms_hp2] : $default[de_sms_hp])); // 수신자번호
$send_number = preg_replace("/[^0-9]/", "", $default[de_sms_hp]); // 발신자번호

$sms_contents = $default[de_sms_cont2];
$sms_contents = preg_replace("/{이름}/", $od_name, $sms_contents);
$sms_contents = preg_replace("/{보낸분}/", $od_name, $sms_contents);
$sms_contents = preg_replace("/{받는분}/", $od_b_name, $sms_contents);
$sms_contents = preg_replace("/{주문번호}/", $od_id, $sms_contents);
$sms_contents = preg_replace("/{주문금액}/", number_format($ttotal_amount), $sms_contents);
$sms_contents = preg_replace("/{회원아이디}/", $member[mb_id], $sms_contents);
$sms_contents = preg_replace("/{회사명}/", $default[de_admin_company_name], $sms_contents);

if ($default[de_sms_use2] && $receive_number)
{
    Sms4Message::SEND_SMS($receive_number, $send_number, stripslashes($sms_contents), $member[mb_id], $od_name);
}
// SMS END   --------------------------------------------------------




//푸시메시지전송 (app_helper)
if(is_file("{$g4["path"]}/app_helper/app.php")) {

    @include_once("{$g4["path"]}/app_helper/lib/fcm.class.php");
    $title = "주문이 등록되었습니다";
    $msg = "{$od_name}({$od_hp}) / 주문상품:{$item_names}";
    $fcmObj = new HpFcm();
    $fcmObj->send($title, $msg, array(), "shop_order", $od_id, "board");
    
}




// order_confirm 에서 사용하기 위해 tmp에 넣고
set_session('ss_temp_on_uid', $tmp_on_uid);

// ss_on_uid 기존자료 세션에서 제거
if (get_session("ss_direct"))
    set_session("ss_on_direct", "");
else
    set_session("ss_on_uid", "");

goto_url("./orderconfirm.php");
?>
