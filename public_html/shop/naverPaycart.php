<?
include_once("./_common.php");

include_once("./naverPay_cfg.php");


$on_uid = $_SESSION['naverPay']['on_uid'];
$is_mobile = $_SESSION['naverPay']['is_mobile'] ? "Y" : "";

unset($_SESSION['naverPay']);

$ct_result = sql_query("SELECT * FROM yc4_cart WHERE on_uid = '".$on_uid."' ");
$ctAmt = sql_fetch("SELECT sum(ct_amount*ct_qty) as amt FROM yc4_cart WHERE on_uid = '".$on_uid."' ");

if(mysql_num_rows($ct_result)<=0) alert("잘못된 접근입니다.","/");

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

$tot_sell_amount = $ctAmt[amt];
// 배송비 계산
if ($default[de_send_cost_case] == "없음")
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
	$backUrl = "https://".$_SERVER[HTTP_HOST]."/shop/cart.php";
} else {
	$backUrl = "http://".$_SERVER[HTTP_HOST]."/shop/cart.php";
}
$queryString = 'SHOP_ID='.urlencode($shopId);
$queryString .= '&CERTI_KEY='.urlencode($certiKey);
// $queryString .= '&SHIPPING_TYPE='.$shippingType;
// $queryString .= '&SHIPPING_PRICE='.$shippingPrice;
$queryString .= '&RESERVE1=&RESERVE2=&RESERVE3=&RESERVE4=&RESERVE5=';
$queryString .= '&BACK_URL='.$backUrl;
$queryString .= '&SA_CLICK_ID='.$_COOKIE["NVADID"]; //CTS
// CPA 스크립트 가이드 설치 업체는 해당 값 전달
$queryString .= '&CPA_INFLOW_CODE='.urlencode($_COOKIE["CPAValidator"]);
$queryString .= '&NAVER_INFLOW_CODE='.urlencode($_COOKIE["NA_CO"]);
$totalMoney = 0;
$optObj = new Yc4ItemOption();

$it_free_send2_cnt = 0; //단독주문시 배송비 무료 상품 수
$cartNum = 0;

//DB와 장바구니에서 상품 정보를 얻어 온다.
while($ct=sql_fetch_array($ct_result)) {

	$cartNum++;	
	
	$opt_name = "";
	$opt_name = $optObj->print_option_cart($ct["it_id"], $ct["it_option1"], $ct["it_option2"], $ct["it_option3"], 0, "/");

	for($i=1;$i<=6;$i++){
		if($ct['it_opt'.$i]){
			$str = explode(";",$ct['it_opt'.$i]);
			if($opt_name) $opt_name .= "/".$str[0];
			else $opt_name .= $str[0];
		}
	}

	$it = sql_fetch("SELECT * FROM yc4_item WHERE it_id = '".$ct['it_id']."' ");
	$basic_amount = get_amount($it);
	$id = $it['it_id'];
	$name = $it['it_name'];
	$uprice = $basic_amount;
	$count = $ct[ct_qty];
	$tprice = $ct[ct_amount] * $count;
	$option = $opt_name;
	$item = new ItemStack($id, $name, $tprice, $uprice, $option, $count);
	$totalMoney += $tprice;
	$queryString .= '&'.$item->makeQueryString();

	if($it["it_free_send"] == "1"){ //배송비 무료인 상품이 끼어있으면
		$shippingType = 'FREE';
		$shippingPrice = 0;
	} else if($it["it_free_send"] == "2"){ //단독 주문시 무료
		$it_free_send2_cnt++;
	}
}
if($cartNum > 0 && $cartNum == $it_free_send2_cnt) { //단독 주문시 무료인 상품으로만 장바구니가 구성되어 있으면
	$shippingType = 'FREE';
	$shippingPrice = 0;
}

$queryString .= '&SHIPPING_TYPE='.$shippingType;
$queryString .= '&SHIPPING_PRICE='.$shippingPrice;

$totalPrice = (int)$totalMoney + (int)$shippingPrice;
$queryString .= '&TOTAL_PRICE='.$totalPrice;
//echo($queryString."<br>\n");
if($npay_istest) {

		$req_addr = 'ssl://test-pay.naver.com';
}
else  {

		$req_addr = 'ssl://pay.naver.com';

}

$req_url = 'POST /customer/api/order.nhn HTTP/1.1'; // utf-8
// $req_url = 'POST /customer/api/CP949/order.nhn HTTP/1.1'; // euc-kr
if($npay_istest) {

		$req_host = 'test-pay.naver.com';
}
else { 

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
if($npay_istest) {
	if($is_mobile)
		$orderUrl = "https://test-m.pay.naver.com/mobile/customer/order.nhn";
	else
		$orderUrl = "https://test-pay.naver.com/customer/order.nhn";
}
else  {
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