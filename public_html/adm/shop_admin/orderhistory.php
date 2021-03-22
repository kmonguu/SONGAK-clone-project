<?
include_once("./_common.php");


//배송회사명
function dlCompany($dl_id){
	$result = sql_fetch("SELECT dl_company FROM yc4_delivery WHERE dl_id = '$dl_id'");
	return $result[dl_company];
}

//이전 로그 가져옴
function getHistory($od_id){
	$result = sql_fetch("SELECT od_history FROM yc4_order WHERE od_id = '$od_id'");
	return addSlashes($result[od_history]);
}


//주문정보 가져오기
function getOrder($od_id){
	$result = sql_fetch(" SELECT * FROM yc4_order WHERE od_id = '$od_id' ");
	return $result;
}
//카트정보 가져오기
function getCart($ct_id){
	$result = sql_fetch(" SELECT * FROM yc4_cart WHERE ct_id = '$ct_id' ");
	return $result;
}

//로그 기록
function setHistory($od_id, $history){

	global $member;
	$prefix = "[".date("Y-m-d H:i:s")."][".$member[mb_id]."][".$_SERVER[REMOTE_ADDR]."] ";
	$suffix = "\n";

	$history = $prefix . $history . $suffix . getHistory($od_id);
	sql_query("UPDATE yc4_order SET od_history='$history' WHERE od_id='$od_id'");

}

//주문조회 로그
function setViewLog($od_id){
	$log = "주문내역을 조회하였습니다.";
	//setHistory($od_id, $log);
}

//주문생성 로그
function setCreateLog($od_id){
	$log = "주문이 생성되었습니다.";
	setHistory($od_id, $log);
}


//주문상품 상태 로그
function setStateLog($ct_id, $od_id, $it_id, $state){
	$ct = getCart($ct_id);
	$itNm = sql_fetch("SELECT it_name FROM yc4_item WHERE it_id='$it_id'");
	$log = "상품상태 정보가 변경되었습니다.";
	$log .= setToString("[{$itNm[it_name]}] 상품상태 : ", $ct[ct_status], $state);
	setHistory($od_id, $log);
}


//결제/배송내역 변경 로그
function setSettleLog($od_id, $data){
	$od = getOrder($od_id);
	$log = "주문결제 정보가 변경되었습니다.";
	
	if($data[od_deposit_name] != $od[od_deposit_name])
		$log .= setToString("입금자명 : ", $od[od_deposit_name], $data[od_deposit_name]);
	if($data[od_bank_account] != $od[od_bank_account])
		$log .= setToString("계좌번호 : ", $od[od_bank_account], $data[od_bank_account]);
	if(($od[od_bank_time] != '0000-00-00 00:00:00' || $data[od_bank_time] != '') && $data[od_bank_time] != $od[od_bank_time])
		$log .= setToString("입금확인일시 : ", $od[od_bank_time], $data[od_bank_time]);
	if(($od[od_card_time] != '0000-00-00 00:00:00' || $data[od_card_time] != '') && $data[od_card_time] != $od[od_card_time])
		$log .= setToString("카드승인일시 : ", $od[od_card_time], $data[od_card_time]);
	
	if(($od[od_receipt_bank] != 0 || $data[od_receipt_bank] != '') && $data[od_receipt_bank] != $od[od_receipt_bank])
		$log .= setToString("무통장입금액 : ", $od[od_receipt_bank], $data[od_receipt_bank]);
	if(($od[od_receipt_card] != 0 || $data[od_receipt_card] != '') && $data[od_receipt_card] != $od[od_receipt_card])
		$log .= setToString("신용카드결제액 : ", $od[od_receipt_card], $data[od_receipt_card]);
	
	if($data[od_receipt_point] != $od[od_receipt_point])
		$log .= setToString("포인트 결제액 : ", $od[od_receipt_point], $data[od_receipt_point]);
	if(($od[od_cancel_card] != 0 || $data[od_cancel_card] != '') && $data[od_cancel_card] != $od[od_cancel_card])
		$log .= setToString("카드승인취소 : ", $od[od_cancel_card], $data[od_cancel_card]);
	if($data[od_dc_amount] != $od[od_dc_amount])
		$log .= setToString("DC : ", $od[od_dc_amount], $data[od_dc_amount]);
	if($data[od_refund_amount] != $od[od_refund_amount])
		$log .= setToString("환불액 : ", $od[od_refund_amount], $data[od_refund_amount]);
	
	if(($od[dl_id] != 0 || $data[dl_id] != '') && $data[dl_id] != $od[dl_id])
		$log .= setToString("배송회사 : ", dlCompany($od[dl_id]), dlCompany($data[dl_id]));

	if($data[od_invoice] != $od[od_invoice])
		$log .= setToString("운송장번호 : ", $od[od_invoice], $data[od_invoice]);
	if($data[od_invoice_time] != "" && $data[od_invoice_time] != $od[od_invoice_time])
		$log .= setToString("배송일시 : ", $od[od_invoice_time], $data[od_invoice_time]);
	
	if(($od[od_send_cost] != 0 || $data[od_send_cost] != '') && $data[od_send_cost] != $od[od_send_cost])
		$log .= setToString("주문자 배송비 : ", $od[od_send_cost], $data[od_send_cost]);
	
	
	//멀티 배송지 업데이트
	if($od["od_delivery_cnt"] > 1) {
		$mdObj = new Yc4MultiDelivery();
		$cnt = 0;
		for($idx = 0 ; $idx < count($data["md_no"]) ;$idx++){
			$cnt++;
			$md = $mdObj->get($data["md_no"][$idx]);

			if(($md["md_dl_id"] != 0 || $data["md_dl_id"][$idx] != '') && $data["md_dl_id"][$idx] != $md["md_dl_id"])
				$log .= setToString("[배송지{$cnt}]배송회사 : ", dlCompany($md["md_dl_id"]), dlCompany($data["md_dl_id"][$idx]));
			
			if($data["md_invoice"][$idx] != $md[md_invoice])
				$log .= setToString("[배송지{$cnt}]운송장번호 : ", $md[md_invoice], $data["md_invoice"][$idx]);

			if($data["md_invoice_time"][$idx] != "" && $data["md_invoice_time"][$idx] != $md["md_invoice_time"])
				$log .= setToString("[배송지{$cnt}]배송일시 : ", $md[md_invoice_time], $data["md_invoice_time"][$idx]);
			
		}
	}


	setHistory($od_id, $log);
}

//주소정보 변경 로그
function setAddrLog($od_id, $data){
	$od = getOrder($od_id);
	$log = "주문고객 정보가 변경되었습니다.";
	
	if($data[od_name] != $od[od_name])
		$log .= setToString("주문자 이름: ", $od[od_name], $data[od_name]);
	if($data[od_tel] != $od[od_tel])
		$log .= setToString("주문자 전화번호: ", $od[od_tel], $data[od_tel]);
	if($data[od_hp] != $od[od_hp])
		$log .= setToString("주문자 핸드폰: ", $od[od_hp], $data[od_hp]);
	if($data[od_zip1] != $od[od_zip1])
		$log .= setToString("주문자 우편번호1: ", $od[od_zip1], $data[od_zip1]);
	if($data[od_zip2] != $od[od_zip2])
		$log .= setToString("주문자 우편번호2: ", $od[od_zip2], $data[od_zip2]);
	if($data[od_addr1] != $od[od_addr1])
		$log .= setToString("주문자 주소1: ", $od[od_addr1], $data[od_addr1]);
	if($data[od_addr2] != $od[od_addr2])
		$log .= setToString("주문자 주소2: ", $od[od_addr2], $data[od_addr2]);
	if($data[od_email] != $od[od_email])
		$log .= setToString("주문자 이메일: ", $od[od_email], $data[od_email]);


	if($data[od_b_name] != $od[od_b_name])
		$log .= setToString("수령인 이름: ", $od[od_b_name], $data[od_b_name]);
	if($data[od_b_tel] != $od[od_b_tel])
		$log .= setToString("수령인 전화번호: ", $od[od_b_tel], $data[od_b_tel]);
	if($data[od_b_hp] != $od[od_b_hp])
		$log .= setToString("수령인 핸드폰: ", $od[od_b_hp], $data[od_b_hp]);
	if($data[od_b_zip1] != $od[od_b_zip1])
		$log .= setToString("수령인 우편번호1: ", $od[od_b_zip1], $data[od_b_zip1]);
	if($data[od_b_zip2] != $od[od_b_zip2])
		$log .= setToString("수령인 우편번호2: ", $od[od_b_zip2], $data[od_b_zip2]);
	if($data[od_b_addr1] != $od[od_b_addr1])
		$log .= setToString("수령인 주소1: ", $od[od_b_addr1], $data[od_b_addr1]);
	if($data[od_b_addr2] != $od[od_b_addr2])
		$log .= setToString("수령인 주소2: ", $od[od_b_addr2], $data[od_b_addr2]);
	
	
	//멀티 배송지 업데이트

	if($od["od_delivery_cnt"] > 1) {
		$mdObj = new Yc4MultiDelivery();
		$cnt = 0;
		for($idx = 0 ; $idx < count($data["md_no"]) ;$idx++){
			$cnt++;
			$md = $mdObj->get($data["md_no"][$idx]);


			if($data[md_name][$idx] != $md[md_name])
				$log .= setToString("[배송지{$cnt}] 수령인 이름: ", $md[md_name], $data[md_name][$idx]);
			if($data[md_tel][$idx] != $md[md_tel])
				$log .= setToString("[배송지{$cnt}] 수령인 전화번호: ", $md[md_tel], $data[md_tel][$idx]);
			if($data[md_hp][$idx] != $md[md_hp])
				$log .= setToString("[배송지{$cnt}] 수령인 핸드폰: ", $md[md_hp], $data[md_hp][$idx]);
			if($data[md_zip1][$idx] != $md[md_zip1])
				$log .= setToString("[배송지{$cnt}] 수령인 우편번호1: ", $md[md_zip1], $data[md_zip1][$idx]);
			if($data[md_zip2][$idx] != $md[md_zip2])
				$log .= setToString("[배송지{$cnt}] 수령인 우편번호2: ", $md[md_zip2], $data[md_zip2][$idx]);
			if($data[md_addr1][$idx] != $md[md_addr1])
				$log .= setToString("[배송지{$cnt}] 수령인 주소1: ", $md[md_addr1], $data[md_addr1][$idx]);
			if($data[md_addr2][$idx] != $md[md_addr2])
				$log .= setToString("[배송지{$cnt}] 수령인 주소2: ", $md[md_addr2], $data[md_addr2][$idx]);			
		}
	}



	setHistory($od_id, $log);
}

//변경스트링
function setToString($name, $old, $new){
	if($old == "")
		$old = "'' ''";
	if($new == "")
		$new = "'' ''";
	$name = addslashes($name);
	return " [".$name.$old."=>".$new."] ";
}


?>