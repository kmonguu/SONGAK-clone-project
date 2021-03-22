<?
include_once("./_common.php");

header("Content-Type: text/html; charset=utf-8");

$uploadfile = "{$g4["path"]}/data/".time().".xls";

@unlink($uploadfile);
copy($_FILES[excel_file][tmp_name],"$uploadfile");
chmod($uploadfile, 0777);
unlink($_FILES[excel_file][tmp_name]);

error_reporting(E_ALL ^ E_NOTICE);
require_once $g4["path"].'/lib/excel_reader2.php';
$data = new Spreadsheet_Excel_Reader("$uploadfile");
$data->setOutputEncoding('EUC-KR');


$dl_id = $_POST["dl_id"];
if(!$dl_id) $dl_id = "1";



$excel_fields = "";
$sRow = 2;
$cnt = 0;
$fcnt = 0;

$tmp_od_id = "XXX";
$tmp_md_no = "XXX";
$invoiceArr = array();
$mdInvoiceArr = array();

for($row=$sRow; $row<=$data->rowcount(0); $row++) {

	$md_no = "";
	$ct_id = "";
	$invoice = "";
	$od_id = "";
	
	for($col = 1 ; $col <= $data->colcount(0);$col++){
		
		//운송장번호 필드가 비어있으면 그 행에 데이터가 없는것으로 간주합니다. 
		if($data->val($row, 14) == "") break;
		//주문번호 필드가 비어있으면 그 행에 데이터가 없는것으로 간주합니다.
		if($data->val($row, 2) == "") break;

		$excel_fields = $data->val($row, $col);

		if($col == 14) $invoice = $excel_fields;
		else if($col == 2) $od_id = $excel_fields;
		else if($col == 15) $ct_id = $excel_fields;
		else if($col == 16) $md_no = $excel_fields;

	}


	if($md_no == "")  { //일반 배송지 
		
		$mdObj = new Yc4MultiDelivery();
		if($tmp_od_id == $od_id) { //이전 row와 주문번호가 같을 때
			if(!in_array($invoice, $invoiceArr[$od_id]))
				$invoiceArr[$od_id][] = $invoice;
		} else {
			$invoiceArr[$od_id][] = $invoice;
			$tmp_od_id = $od_id;
		}

		$invoiceStr = implode("/", $invoiceArr[$od_id]);

		if($invoice != "" && $od_id != "") {
			//배송일시, 배송회사ID, 운송장번호 업데이트
			$sql = "
				UPDATE
					yc4_order 
				SET 
					dl_id='{$dl_id}',
					od_invoice_time = '".date("Y-m-d H:i:s")."',
					od_invoice = '{$invoiceStr}'
				WHERE
					od_id = '{$od_id}'
			";
			sql_query($sql);
		
			$sql = "
				UPDATE 
					yc4_cart 
				SET
					ct_status = '배송'
				WHERE 
					ct_id = '{$ct_id}' AND ct_status IN('준비', '주문')
			";
			sql_query($sql);

			$cnt++;
		} 


	} else { //다중 배송지

		
		if($tmp_md_no == $md_no) { //이전 md_no와 번호가 같을 때
			if(!in_array($invoice, $mdInvoiceArr[$md_no]))
				$mdInvoiceArr[$md_no][] = $invoice;
		} else {
			$mdInvoiceArr[$md_no][] = $invoice;
			$tmp_md_no = $md_no;
		}

		$invoiceStr = implode("/", $mdInvoiceArr[$md_no]);
		if($invoice != "" && $md_no != "") {

			$params = array();
			$params["no"] = $md_no;
			$params["md_invoice"] = $invoiceStr;
			$params["md_invoice_time"] = date("Y-m-d H:i:s");
			$params["md_dl_id"] = $dl_id;
		
			$mdObj->dl_update($params);


			if($mdObj->is_all_invoice($od_id)) { //모든 주문에 운송장번호가 들어가 있다면

				$od = sql_fetch(" SELECT * FROM yc4_order WHERE od_id='{$od_id}' ");
				$sql = "
					UPDATE 
						yc4_cart 
					SET
						ct_status = '배송'
					WHERE 
						on_uid='{$od[on_uid]}' AND ct_status IN('준비', '주문')
				";
				sql_query($sql);

			} 

		}


		$cnt++;




	}

}

@unlink($uploadfile);

alert("엑셀 업로드작업이 완료되었습니다.", "./deliverylist.php");
?>

