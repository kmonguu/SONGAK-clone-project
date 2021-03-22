<?
include_once("./_common.php");

include_once("./naverPay_cfg.php");

$it_id = $_SESSION['naverPay']['it_id'];
$image_url = $_SESSION['naverPay']['image_url'];
$thumb_url = $_SESSION['naverPay']['thumb_url'];
$is_mobile = $_SESSION['naverPay']['is_mobile'] ? "Y" : "";

unset($_SESSION['naverPay']);

$it = sql_fetch("SELECT * FROM yc4_item WHERE it_id = '".$it_id."' ");

if(!$it) alert("잘못된 접근입니다.","/");

//item data를 생성한다.
class ItemStack {
	var $id;
	var $name;
	var $uprice;
	var $image;
	var $thumb;
	var $url;
	function ItemStack($_id, $_name, $_uprice, $_image, $_thumb, $_url) {
		$this->id = $_id;
		$this->name = $_name;
		$this->uprice = $_uprice;
		$this->image = $_image;
		$this->thumb = $_thumb;
		$this->url = $_url;
	}
	function makeQueryString() {
		$ret .= 'ITEM_ID=' . urlencode($this->id);
		//$ret .= '&EC_MALL_PID='.urlencode($this->id);
		$ret .= '&ITEM_NAME=' .  urlencode(trim(strip_tags($this->name)));
		$ret .= '&ITEM_UPRICE=' . $this->uprice;
		$ret .= '&ITEM_IMAGE=' . urlencode($this->image);
		$ret .= '&ITEM_THUMB=' . urlencode($this->thumb);
		$ret .= '&ITEM_URL=' . urlencode($this->url);
		return $ret;
	}
};

$shopId = $npay_shopId;
$certiKey = $npay_certiKey;

$queryString = 'SHOP_ID='.urlencode($shopId);
$queryString .= '&CERTI_KEY='.urlencode($certiKey);
$queryString .= '&RESERVE1=&RESERVE2=&RESERVE3=&RESERVE4=&RESERVE5=';
//DB 에서 상품 정보를 얻어온다.
//while(...) {
$uid = $it_id;
$name = $it['it_name'];
$uprice = get_amount($it);
$image = $image_url;
$thumb = $thumb_url;

if(isset($_SERVER['HTTPS'])){
	$url = "https://".$_SERVER[HTTP_HOST]."/shop/item.php?it_id=".$it_id;
} else {
	$url = "http://".$_SERVER[HTTP_HOST]."/shop/item.php?it_id=".$it_id;
}


$item = new ItemStack($uid, $name, $uprice, $image, $thumb, $url);
$queryString .= '&'.$item->makeQueryString();
//}
//echo($queryString."<br>\n");
if($npay_istest) 

		$req_addr = 'ssl://test-pay.naver.com';
else {

		$req_addr = 'ssl://pay.naver.com';
}

$req_url = 'POST /customer/api/wishlist.nhn HTTP/1.1'; // utf-8
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
fwrite($nc_sock, "Content-type: application/x-www-form-urlencoded; charset=utf-8\r\n"); // utf-8
//fwrite($nc_sock, "Content-type: application/x-www-form-urlencoded; charset=CP949\r\n"); // euc-kr
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
// 한개일경우
$itemId = $bodys;
// 여러개일경우
//$itemIds = trim($bodys);
//$itemIdList = split(",",$itemIds);
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
//리턴받은 itemId로 주문서 page를 호출한다.
//echo ($itemId."<br>\n");
if($npay_istest){
	if($is_mobile){
		$wishlistPopupUrl = "https://test-m.pay.naver.com/mobile/customer/wishList.nhn";
	} else {
		$wishlistPopupUrl = "https://test-pay.naver.com/customer/wishlistPopup.nhn";
	}
} else {
	if($is_mobile){
		$wishlistPopupUrl = "https://m.pay.naver.com/mobile/customer/wishList.nhn";	
	} else {
		$wishlistPopupUrl = "https://pay.naver.com/customer/wishlistPopup.nhn";
	}
}
?>
<html>
<body>
<form name="frm" method="get" action="<?=$wishlistPopupUrl?>">
<input type="hidden" name="SHOP_ID" value="<?=$shopId?>">
<!-- 한 개일 경우 -->
<input type="hidden" name="ITEM_ID" value="<?=$itemId?>">
<!-- 여러 개일 경우
<? for($i=0; $i < count($itemIdList); $i++) { ?>
<input type="hidden" name="ITEM_ID" value="<?=$itemIdList[$i]?>">
<? } ?>
-->
</form>
</body>
<script>
<? if ($resultCode == 200) { ?>
document.frm.target = "_top";
document.frm.submit();
<? } ?>
</script>