<?
include_once("./_common2.php");


$password = $_REQUEST["password"];
if($password != $sitekey) { exit; }


$time = $_REQUEST[push_time];

$ncnt = sql_fetch(" SELECT vs_count as cnt FROM  $g4[visit_sum_table] WHERE  vs_date = '".date('Y-m-d')."' ");
$push_msg = date("Y-m-d")." 현재까지 접속자 수는 " .number_format($ncnt[cnt]) . "명 입니다";
$push_title = "접속자분석기";


//현재시각에 보내기로 설정된 목록
$result = sql_query(" SELECT * FROM helper_analytics_config WHERE (push1_time='$time' OR push2_time='$time') AND push_use='1' ");
$fcm_reg_ids = array();
for($i = 0 ; $row = sql_fetch_array($result); $i++){
	$is_login = sql_fetch(" SELECT count(*) cnt FROM helper_push_id WHERE fcm_id='{$row["fcm_id"]}' ");
	if($is_login["cnt"] != 0){
		$fcm_reg_ids[] = $row["fcm_id"];
	}
}



include_once("{$g4["path"]}/app_helper/lib/fcm.class.php");
$fcmObj = new HpFcm();
$fcmObj->send_FcmID($push_title, $push_msg, $fcm_reg_ids, "analytics", "1", "analytics");