<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

if($p){
	$ppage=explode("_",$p);
	$pageNum=$ppage[0];
	$subNum=$ppage[1];
	$ssNum=$ppage[2];
	$tabNum=$ppage[3];
}
$authObj = new Auth_Controller();
$authObj->check_page_auth();



$smsConf = new APIStoreKKOConfig();
$conf = $smsConf->get($ss_com_id);

$obj = new APIStoreKKO($conf["api_id"], $conf["api_key"]);


$result = $obj->regist_sender_number(str_replace("-", "", $_POST["number"]), $_POST["comment"], $_POST["pincode"]);

if($result != "OK"){
	echo "{$result}";
} else {
	echo "OK";
}
