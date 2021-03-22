<?
$sub_menu = "400500";
include_once("./_common.php");
include_once("$g4[path]/lib/mailer.lib.php");
include_once("$g4[path]/lib/icode.sms.lib.php");

check_demo();

auth_check($auth[$sub_menu], "w");

define("_ORDERMAIL_", true);

$admin = get_admin('super');


//#############################################################################################
//#############################################################################################
//멀티배송지 관련
$mdObj = new Yc4MultiDelivery();
$comp_odids = array();
for ($m=0; $m<count($_POST["md_no"]); $m++)  {
	
	$_POST["md_dl_id"][$m] = $_POST["md_dl_id"][$m] ? $_POST["md_dl_id"][$m] : 0;

	// 배송회사와 운송장번호가 있는것만 수정
    if ($_POST["md_dl_id"][$m] && trim($_POST[md_invoice][$m])) 
    {

		$params = array();
		$params["no"] = $_POST["md_no"][$m];
		$params["md_invoice"] = $_POST["md_invoice"][$m];
		$params["md_invoice_time"] = $_POST["md_invoice_time"][$m];
		$params["md_dl_id"] = $_POST["md_dl_id"][$m];
		$mdObj->dl_update($params);

		// 이전에 입력한 배송회사, 운송장번호가 틀리다면
		if ($_POST[save_md_invoice][$m] != trim($_POST[md_invoice][$m]) || $_POST[save_md_dl_id][$m] != $_POST[md_dl_id][$m]) 
		{
			$md = $mdObj->get($_POST["md_no"][$m]);
			if($mdObj->is_all_invoice($md["od_id"])) { //모든 주문에 운송장번호가 들어가 있다면
				$comp_odids[$md["od_id"]] = $_POST["md_on_uid"][$m];
			} 


			//-----------------------------------------
			// 일괄배송처리시 알림톡 일괄전송
			if($_POST['send_kko']){
				$od_id = $md["od_id"];
				$sql = " select od_id, od_name, od_invoice, od_hp, dl_id from $g4[yc4_order_table] where od_id = '$od_id' ";
				$od = sql_fetch($sql);
				APIStoreKKO::SEND_ORDER("delivery", $od_id, $od["od_hp"], $md["no"]);
			}


			 //-----------------------------------------
			// 일괄배송처리시 SMS 문자 일괄전송
			if ($default[de_sms_use4] && $_POST['send_sms']) 
			{
				$od_id = $md["od_id"];
				$sql = " select od_id, od_name, od_invoice, od_hp, dl_id, mb_id from $g4[yc4_order_table] where od_id = '$od_id' ";
				$od = sql_fetch($sql);

				$sql = " select dl_company from $g4[yc4_delivery_table] where dl_id = '$md[md_dl_id]' ";
				$dl = sql_fetch($sql);

				$sms_contents = $default[de_sms_cont4];
				$sms_contents = preg_replace("/{이름}/", $md[md_name], $sms_contents);
				$sms_contents = preg_replace("/{택배회사}/", $dl[dl_company], $sms_contents);
				$sms_contents = preg_replace("/{운송장번호}/", $md[md_invoice], $sms_contents);
				$sms_contents = preg_replace("/{주문번호}/", $md[od_id], $sms_contents);
				$sms_contents = preg_replace("/{회사명}/", $default[de_admin_company_name], $sms_contents);

				$receive_number = preg_replace("/[^0-9]/", "", $od[od_hp]);	// 수신자번호 (받는사람 핸드폰번호 ... 여기서는 주문자님의 핸드폰번호임)
				$send_number = preg_replace("/[^0-9]/", "", $default[de_sms_hp]); // 발신자번호
				
				Sms4Message::SEND_SMS($receive_number, $send_number, stripslashes($sms_contents), $od["mb_id"], $od["od_name"]);
			}
			//---------------------------------------


		}	

	}
	
}

//전부 운송장번호가 들어간 주문목록
foreach($comp_odids as $key=>$value){

	$od_id = $key;

	// 장바구니 상태가 '주문', '준비' 일 경우 '배송' 으로 상태를 변경
	$on_uid = $value;
	$sql = " update $g4[yc4_cart_table]
				set ct_status = '배송'
			  where ct_status in ('주문', '준비')
				and on_uid = '$on_uid' ";
	sql_query($sql);


	// 재고 반영
	$sql2 = " select it_id, ct_id, ct_stock_use, ct_qty from $g4[yc4_cart_table] 
			   where on_uid = '$on_uid' 
				 and ct_stock_use = '0' ";
	$result2 = sql_query($sql2);
	for ($k=0; $row2=mysql_fetch_array($result2); $k++) 
	{
		$sql3 =" update $g4[yc4_item_table] set it_stock_qty = it_stock_qty - '$row2[ct_qty]' where it_id = '$row2[it_id]' ";
		sql_query($sql3);
		$sql4 = " update $g4[yc4_cart_table]
					set ct_stock_use  = '1',
						ct_history    = CONCAT(ct_history,'\n배송일괄|$now|$REMOTE_ADDR')
				  where on_uid = '$on_uid'
					and ct_id  = '$row2[ct_id]' ";
		sql_query($sql4);
	}
	
}
//멀티배송지 관련 끝
//#############################################################################################
//#############################################################################################




for ($m=0; $m<count($_POST[od_id]); $m++) 
{
    // 배송회사와 운송장번호가 있는것만 수정
    if ($_POST[dl_id][$m] && trim($_POST[od_invoice][$m])) 
    {
        $sql = "update $g4[yc4_order_table] 
                   set od_invoice_time = '{$_POST[od_invoice_time][$m]}',
                       dl_id           = '{$_POST[dl_id][$m]}',
                       od_invoice      = '{$_POST[od_invoice][$m]}'
                 where od_id           = '{$_POST[od_id][$m]}' ";
        sql_query($sql);

        // 이전에 입력한 배송회사, 운송장번호가 틀리다면 메일 발송
        if ($_POST[save_od_invoice][$m] != trim($_POST[od_invoice][$m]) || $_POST[save_dl_id][$m] != $_POST[dl_id][$m]) 
        {
            $od_id = $_POST[od_id][$m];

            // 장바구니 상태가 '주문', '준비' 일 경우 '배송' 으로 상태를 변경
            $on_uid = $_POST[on_uid][$m];
            $sql = " update $g4[yc4_cart_table]
                        set ct_status = '배송'
                      where ct_status in ('주문', '준비')
                        and on_uid = '$on_uid' ";
            sql_query($sql);

            include "./ordermail.inc.php";

            // 재고 반영
            $sql2 = " select it_id, ct_id, ct_stock_use, ct_qty from $g4[yc4_cart_table] 
                       where on_uid = '$on_uid' 
                         and ct_stock_use = '0' ";
            $result2 = sql_query($sql2);
            for ($k=0; $row2=mysql_fetch_array($result2); $k++) 
            {
                $sql3 =" update $g4[yc4_item_table] set it_stock_qty = it_stock_qty - '$row2[ct_qty]' where it_id = '$row2[it_id]' ";
                sql_query($sql3);

                $sql4 = " update $g4[yc4_cart_table]
                            set ct_stock_use  = '1',
                                ct_history    = CONCAT(ct_history,'\n배송일괄|$now|$REMOTE_ADDR')
                          where on_uid = '$on_uid'
                            and ct_id  = '$row2[ct_id]' ";
                sql_query($sql4);
            }


			//-----------------------------------------
			// 일괄배송처리시 알림톡 일괄전송
			if($_POST['send_kko']){
				$sql = " select od_id, od_name, od_invoice, od_hp, dl_id from $g4[yc4_order_table] where od_id = '$od_id' ";
				$od = sql_fetch($sql);
				APIStoreKKO::SEND_ORDER("delivery", $od_id, $od["od_hp"]);
			}

            //-----------------------------------------
            // 일괄배송처리시 SMS 문자 일괄전송
            if ($default[de_sms_use4] && $_POST['send_sms']) 
            {
                $sql = " select od_id, od_name, od_invoice, od_hp, dl_id, mb_id from $g4[yc4_order_table] where od_id = '$od_id' ";
                $od = sql_fetch($sql);

                $sql = " select dl_company from $g4[yc4_delivery_table] where dl_id = '$od[dl_id]' ";
                $dl = sql_fetch($sql);

                $sms_contents = $default[de_sms_cont4];
                $sms_contents = preg_replace("/{이름}/", $od[od_name], $sms_contents);
                $sms_contents = preg_replace("/{택배회사}/", $dl[dl_company], $sms_contents);
                $sms_contents = preg_replace("/{운송장번호}/", $od[od_invoice], $sms_contents);
                $sms_contents = preg_replace("/{주문번호}/", $od[od_id], $sms_contents);
				$sms_contents = preg_replace("/{회사명}/", $default[de_admin_company_name], $sms_contents);

                $receive_number = preg_replace("/[^0-9]/", "", $od[od_hp]);	// 수신자번호 (받는사람 핸드폰번호 ... 여기서는 주문자님의 핸드폰번호임)
                $send_number = preg_replace("/[^0-9]/", "", $default[de_sms_hp]); // 발신자번호

				Sms4Message::SEND_SMS($receive_number, $send_number, stripslashes($sms_contents), $od["mb_id"], $od["od_name"]);
            }
            //---------------------------------------
        }
    } 
    else 
    {
        $sql = "update $g4[yc4_order_table] 
                   set od_invoice_time = '',
                       dl_id           = '',
                       od_invoice      = ''
                 where od_id           = '{$_POST[od_id][$m]}' ";
        sql_query($sql);
    }
}


goto_url("./deliverylist.php?sort1=$sort1&sort2=$sort2&sel_ca_id=$sel_ca_id&sel_field=$sel_field&search=$search&page=$page");
?>
