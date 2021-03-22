<?
include_once("./_common2.php");


$password = $_REQUEST["password"];
if($password != $sitekey) { exit; }



function call($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,   $url);
	curl_setopt($ch, CURLOPT_POST,  false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}



$domain = $_REQUEST[domain];
if($domain == "it9.co.kr") $domain = "vetago.com";
$traffic = call("http://it9.co.kr/api/traffic.php?domain={$domain}");


if($traffic == "" || $traffic == -1 || $traffic < 95) { 
	exit;
}

$push_msg = "트래픽 용량이 95%를 초과하였습니다.";
$push_title = "트래픽 초과";


//PUSH 설정된 목록
$result = sql_query(" SELECT * FROM helper_analytics_config WHERE  push_use='1' ");
$fcm_reg_ids = array();
for($i = 0 ; $row = sql_fetch_array($result); $i++){	
	$is_login = sql_fetch(" SELECT count(*) cnt FROM helper_push_id WHERE fcm_id='{$row["fcm_id"]}' ");
	if($is_login["cnt"] != 0){
		$fcm_reg_ids[] = $row["fcm_id"];
	}
}


include_once("{$g4["path"]}/app_helper/lib/fcm.class.php");
$fcmObj = new HpFcm();
$fcmObj->send_FcmID($push_title, $push_msg, $fcm_reg_ids, "traffic", "1", "analytics");