<?
$sub_menu = "400400";
include_once("./_common.php");

//로그
include_once("./orderhistory.php");
setAddrLog($od_id, $_REQUEST);

$sql = " update $g4[yc4_order_table]
            set od_shop_memo = '$od_shop_memo',
                od_name = '$od_name',
                od_tel = '$od_tel',
                od_hp = '$od_hp',
                od_zip1 = '$od_zip1',
                od_zip2 = '$od_zip2',
                od_addr1 = '$od_addr1',
                od_addr2 = '$od_addr2',
                od_email = '$od_email',
                od_b_name = '$od_b_name',
                od_b_tel = '$od_b_tel',
                od_b_hp = '$od_b_hp',
                od_b_zip1 = '$od_b_zip1',
                od_b_zip2 = '$od_b_zip2',
                od_b_addr1 = '$od_b_addr1',
                od_b_addr2 = '$od_b_addr2' ";
if ($default[de_hope_date_use])
    $sql .= " , od_hope_date = '$od_hope_date' ";
$sql .= " where od_id = '$od_id' ";
sql_query($sql);




//멀티 배송지 업데이트
$mdObj = new Yc4MultiDelivery();
for($idx = 0 ; $idx < count($_POST["md_no"]) ;$idx++){

	$params = array();
	$params["no"] = $_POST["md_no"][$idx];
	$params["md_name"] = $_POST["md_name"][$idx];
	$params["md_tel"] = $_POST["md_tel"][$idx];
	$params["md_hp"] = $_POST["md_hp"][$idx];
	$params["md_zip1"] = $_POST["md_zip1"][$idx];
	$params["md_addr1"] = $_POST["md_addr1"][$idx];
	$params["md_addr2"] = $_POST["md_addr2"][$idx];

	$mdObj->receiver_update($params);
}



$qstr = "sort1=$sort1&sort2=$sort2&sel_field=$sel_field&search=$search&page=$page";

goto_url("./orderform.php?od_id=$od_id&$qstr");
?>
