<?
include_once("./_common.php");
header("content-type:text/html; charset=utf-8");

include_once("./naverPay_cfg.php");
$is_mobile = $_REQUEST["is_mobile"] ? "Y" : "";


$it = sql_fetch("SELECT * FROM yc4_item WHERE it_id = '".$it_id."' ");
if(!$it) alert("잘못된 접근입니다.","/");

// 레벨(권한)이 상품구입 권한보다 작다면 상품을 구입할 수 없음.
if ($member[mb_level] < $default[de_level_sell])
{alert("상품을 구입할 수 있는 권한이 없습니다.");}


function get_opt_name($data){
    $str = explode(";",$data);
    $name = $str[0];
	return $name;
}

function get_opt_amount($data){
    $str = explode(";",$data);
    $num = $str[1];
    if ($num>0) {
        return $num;
    } else {
        return 0;
    }
}

function get_opt_point($data){
    $str = explode(";",$data);
    $num = $str[2];
    if ($num>0) {
        return $num;
    } else {
        return 0;
    }
}



//item data를 생성한다.
class ItemStack {
	var $id;
	var $name;
	var $tprice;
	var $uprice;
	var $option;
	var $count;
	//option이 여러 종류라면, 선택된 옵션을 슬래시(/)로 구분해서 표시하는 것을 권장한다.
	function ItemStack($_id, $_name, $_tprice, $_uprice, $_option, $_count) {
		$this->id = $_id;
		$this->name = $_name;
		$this->tprice = $_tprice;
		$this->uprice = $_uprice;
		$this->option = $_option;
		$this->count = $_count;
	}
	function makeQueryString() {
		$ret .= 'ITEM_ID=' . urlencode($this->id);
//		$ret .= '&EC_MALL_PID='.urlencode($this->id);
		$ret .= '&ITEM_NAME=' . urlencode(trim(strip_tags($this->name)));
		$ret .= '&ITEM_COUNT=' . $this->count;
		$ret .= '&ITEM_OPTION=' . urlencode($this->option);
		$ret .= '&ITEM_TPRICE=' . $this->tprice;
		$ret .= '&ITEM_UPRICE=' . $this->uprice;
		return $ret;
	}
};



$items = Array();


$tot_sell_amount = 0;
$errmsg = "";
$optObj = new Yc4ItemOption();
for($idx = 0 ; $idx < count($_POST["it_option1"]); $idx++){ //추가된 상품옵션만큼 Loop

	//--------------------------------------------------------
	//  추가옵션 변조 검사
	//--------------------------------------------------------
	//추가 옵션
	$opt_amount = 0;
	$opt_point = 0;
	$opt_name = "";

	for ($i=1; $i<=6; $i++) {
		$dst_opt = trim($_POST["it_opt".$i][$idx]);
		if ($dst_opt) {
			$org_opt = $it["it_opt".$i];
			$exp_opt = explode("\n", trim($org_opt));
			$exists = false;
			for ($k=0; $k<count($exp_opt); $k++) {
				$opt = trim($exp_opt[$k]);
				if ($dst_opt == $opt) {
					$exists = true;
					$exp_option = explode(";", $opt);
					if($opt_name != "") $opt_name.="/";
					$opt_name .= $exp_option[0];
					$opt_amount += (int)$exp_option[1];
					$opt_point += (int)$exp_option[2];
					break;
				}
			}
			if ($exists == false) {
				// 옵션이 다름
				die("Error.");
			}
		}
	}
	$point = $it[it_point] + $opt_point;
	//--------------------------------------------------------

	//선택 옵션
	$type1 = $_POST["it_option1"][$idx];
	$type2 = $_POST["it_option2"][$idx];
	$type3 = $_POST["it_option3"][$idx];
	$io_amt = $_POST["io_amt"][$idx];
	$qty = $_POST["ct_qty"][$idx];
	

	$amount = get_amount($it);
	$base_amount = $amount;
	$io_amt = 0; //상품 선택옵션 가격
	$io_name= "";

	if($type1 != "" || $type2 != "" || $type3 != "") {

		$strOpt = $type1;
		if($type2 != "") $strOpt .= "/". $type2;
		if($type3 != "") $strOpt .= "/". $type3;

		$optInfo = $optObj->get_option($_POST["it_id"], $type1, $type2, $type3, true);
		$io_amt = $optInfo["io_amt"];

		$io_name = $optObj->print_option_cart($_POST["it_id"], $type1, $type2, $type3, 0, "/");
	
		//옵션 수량
		$opt_qty = $optObj->get_qty($_POST["it_id"],"", $type1, $type2, $type3, true);
		$strOpt = "";
		if($qty > $opt_qty) {
			$errmsg .= "{$strOpt} 상품의 재고가 부족합니다.\\n";
			alert($errmsg);
		}
	} else {
		
		// 상품에 대한 현재고수량
		$it_stock_qty = (int)get_it_stock_qty($_POST[it_id], "", true);
		if($qty > $it_stock_qty) {
			$errmsg .= "{$it[it_name]} 상품의 재고가 부족합니다.\\n\\n현재 재고수량 : " . number_format($it_stock_qty) . " 개";
			alert($errmsg);
		}

	}
	
	$amount =($amount+$opt_amount+$io_amt);

	$tot_sell_amount += $amount * $qty;

	$option = $io_name.($opt_name ? ($io_name ? "/" : "").$opt_name : "");
	$uprice = $base_amount;
	$tprice = $amount * $qty;
	$count=$qty;
	$item = new ItemStack($it["it_id"], $it["it_name"], $tprice, $uprice, $option, $count);
	$items[] = $item;

}


// 배송비 계산
if ($default[de_send_cost_case] == "없음"  || $it["it_free_send"] == "1" || $it["it_free_send"] == "2")
	$send_cost = 0;
else {
	// 배송비 상한 : 여러단계의 배송비 적용 가능
	$send_cost_limit = explode(";", $default[de_send_cost_limit]);
	$send_cost_list  = explode(";", $default[de_send_cost_list]);
	$send_cost = 0;
	for ($k=0; $k<count($send_cost_limit); $k++) {
		// 총판매금액이 배송비 상한가 보다 작다면
		if ($tot_sell_amount < $send_cost_limit[$k]) {
			$send_cost = $send_cost_list[$k];
			break;
		}
	}
}
// 배송비 계산 끝



$shopId = $npay_shopId;
$certiKey = $npay_certiKey;

$shippingType = 'PAYED';
if ($shippingType == 'PAYED'&&$send_cost>0) {
	$shippingPrice = $send_cost;
} else {
	$shippingType = 'FREE';
	$shippingPrice = 0;
}

if(isset($_SERVER['HTTPS'])){
	$backUrl = "https://".$_SERVER[HTTP_HOST]."/shop/item.php?it_id=".$it_id;
} else {
	$backUrl = "http://".$_SERVER[HTTP_HOST]."/shop/item.php?it_id=".$it_id;
}
$queryString = 'SHOP_ID='.urlencode($shopId);
$queryString .= '&CERTI_KEY='.urlencode($certiKey);
$queryString .= '&SHIPPING_TYPE='.$shippingType;
$queryString .= '&SHIPPING_PRICE='.$shippingPrice;
$queryString .= '&RESERVE1=&RESERVE2=&RESERVE3=&RESERVE4=&RESERVE5=';
$queryString .= '&BACK_URL='.$backUrl;
$queryString .= '&SA_CLICK_ID='.$_COOKIE["NVADID"]; //CTS

// CPA 스크립트 가이드 설치 업체는 해당 값 전달
$queryString .= '&CPA_INFLOW_CODE='.urlencode($_COOKIE["CPAValidator"]);
$queryString .= '&NAVER_INFLOW_CODE='.urlencode($_COOKIE["NA_CO"]);
$totalMoney = 0;



//DB와 장바구니에서 상품 정보를 얻어 온다.
//while(...) {
foreach($items as $item){
	$totalMoney += $item->tprice;
	$queryString .= '&'.$item->makeQueryString();	
}
/*
$id = $it_id;
$name = $it['it_name'];
$uprice = $amount;
$count = $ct_qty;
$tprice = $uprice * $count;
$option = $opt_name;
$item = new ItemStack($id, $name, $tprice, $uprice, $option, $count);
$totalMoney += $tprice;
$queryString .= '&'.$item->makeQueryString();
//}
*/

$totalPrice = (int)$totalMoney + (int)$shippingPrice;
$queryString .= '&TOTAL_PRICE='.$totalPrice;

//echo($queryString."<br>\n");

if($npay_istest){
	
		$req_addr = 'ssl://test-pay.naver.com';
} else {
	
		$req_addr = 'ssl://pay.naver.com';
}
$req_url = 'POST /customer/api/order.nhn HTTP/1.1'; // utf-8
// $req_url = 'POST /customer/api/CP949/order.nhn HTTP/1.1'; // euc-kr

if($npay_istest) {

		$req_host = 'test-pay.naver.com';
} else {

		$req_host = 'pay.naver.com';
}
$req_port = 443;
$nc_sock = @fsockopen($req_addr, $req_port, $errno, $errstr);
if ($nc_sock) {
fwrite($nc_sock, $req_url."\r\n" );
fwrite($nc_sock, "Host: ".$req_host.":".$req_port."\r\n" );
fwrite($nc_sock, "Content-type: application/x-www-form-urlencoded; charset=utf-8\r\n");
//fwrite($nc_sock, "Content-type: application/x-www-form-urlencoded; charset=CP949\r\n");
fwrite($nc_sock, "Content-length: ".strlen($queryString)."\r\n");
fwrite($nc_sock, "Accept: */*\r\n");
fwrite($nc_sock, "\r\n");
fwrite($nc_sock, $queryString."\r\n");
fwrite($nc_sock, "\r\n");
// get header
while(!feof($nc_sock)){
$header=fgets($nc_sock,4096);
if($header=="\r\n"){
break;
} else {
$headers .= $header;
}
}
// get body
while(!feof($nc_sock)){
$bodys.=fgets($nc_sock,4096);
}

fclose($nc_sock);
$resultCode = substr($headers,9,3);
if ($resultCode == 200) {
// success
$orderId = $bodys;
} else {
// fail
echo $bodys;
}
}
else {
echo "$errstr ($errno)<br>\n";
exit(-1);
//에러처리
}
//리턴받은 order_id로 주문서 page를 호출한다.
//echo ($orderId."<br>\n");
if($npay_istest)  {
	if($is_mobile)
		$orderUrl = "https://test-m.pay.naver.com/mobile/customer/order.nhn";
	else
		$orderUrl = "https://test-pay.naver.com/customer/order.nhn";
}
else {
	if($is_mobile)
		$orderUrl = "https://m.pay.naver.com/mobile/customer/order.nhn";
	else
		$orderUrl = "https://pay.naver.com/customer/order.nhn";
}
?>
<html>
<body>

<form name="frm" method="get" action="<?=$orderUrl?>">
<input type="hidden" name="ORDER_ID" value="<?=$orderId?>">
<input type="hidden" name="SHOP_ID" value="<?=$shopId?>">
<input type="hidden" name="TOTAL_PRICE" value="<?=$totalPrice?>">
</form>
</body>
<script>
<? if ($resultCode == 200) { ?>
document.frm.target = "_top";
document.frm.submit();
<? } ?>
</script>
</html>