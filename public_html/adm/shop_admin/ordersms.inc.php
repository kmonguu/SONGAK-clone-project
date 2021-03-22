<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
if (!defined("_ORDERSMS_")) exit;

$receive_number = preg_replace("/[^0-9]/", "", $od_hp);	// 수신자번호 (받는사람 핸드폰번호 ... 여기서는 주문자님의 핸드폰번호임)
$send_number = preg_replace("/[^0-9]/", "", $default[de_sms_hp]); // 발신자번호

if ($od_sms_ipgum_check)
{
	if ($od_bank_account && $od_receipt_bank && $od_deposit_name)
	{
		$sms_contents = $default[de_sms_cont3];
		$sms_contents = preg_replace("/{이름}/", $od_name, $sms_contents);
		$sms_contents = preg_replace("/{입금액}/", number_format($od_receipt_bank), $sms_contents);
		$sms_contents = preg_replace("/{주문번호}/", $od_id, $sms_contents);
		$sms_contents = preg_replace("/{회사명}/", $default[de_admin_company_name], $sms_contents);
	
		Sms4Message::SEND_SMS($receive_number, $send_number, stripslashes($sms_contents), $od_info["mb_id"], $od_info["od_name"]);

	}
}

if ($od_sms_baesong_check)
{

	if($od_info["od_delivery_cnt"] <= 1) {

		if ($dl_id && $od_invoice)
		{
			$sms_contents = $default[de_sms_cont4];
			$sms_contents = preg_replace("/{이름}/", $od_name, $sms_contents);
			$sql = " select dl_company from $g4[yc4_delivery_table] where dl_id = '$dl_id' ";
			$row = sql_fetch($sql);
			$sms_contents = preg_replace("/{택배회사}/", $row[dl_company], $sms_contents);
			$sms_contents = preg_replace("/{운송장번호}/", $od_invoice, $sms_contents);
			$sms_contents = preg_replace("/{주문번호}/", $od_id, $sms_contents);
			$sms_contents = preg_replace("/{회사명}/", $default[de_admin_company_name], $sms_contents);

			Sms4Message::SEND_SMS($receive_number, $send_number, stripslashes($sms_contents), $od_info["mb_id"], $od_info["od_name"]);
		}

	} else {
		

		$mdObj = new Yc4MultiDelivery();
		$mdResult = $mdObj->get_list($od_id, 1, "", "", "", "", PHP_INT_MAX, "", "");
		$mdlist = $mdResult["list"];
		$cnt = 0;
		for($idx = 0 ; $idx < count($mdlist); $idx++){

			$md = $mdlist[$idx];
			$cnt++;
			
			if($md["md_dl_id"] && $md["md_invoice"]) {
				$sms_contents = $default[de_sms_cont4];
				$sms_contents = preg_replace("/{이름}/", $md["md_name"], $sms_contents);
				$sql = " select dl_company from $g4[yc4_delivery_table] where dl_id = '{$md["md_dl_id"]}' ";
				$row = sql_fetch($sql);
				$sms_contents = preg_replace("/{택배회사}/", $row[dl_company], $sms_contents);
				$sms_contents = preg_replace("/{운송장번호}/", $md["md_invoice"], $sms_contents);
				$sms_contents = preg_replace("/{주문번호}/", $od_id, $sms_contents);
				$sms_contents = preg_replace("/{회사명}/", $default[de_admin_company_name], $sms_contents);
			}
			
			Sms4Message::SEND_SMS($receive_number, $send_number, stripslashes($sms_contents), $od_info["mb_id"], $od_info["od_name"]);

		}



	}
}
?>
