<?
include_once("./_common.php");


$isInApp = get_session("in_app"); //앱 세션 기억


//FCM해제
$ss_fcmId = get_session("fcm_id");
$ss_device_serial = get_session("device_serial");
if($ss_fcmId) sql_query(" delete from helper_push_id where fcm_id='$ss_fcmId' AND mb_id='$member[mb_id]' ");
if($ss_device_serial) sql_query(" delete from helper_push_id where device_serial='$ss_device_serial' AND mb_id='$member[mb_id]' ");

if(!$ss_fcmId) {
    $pushInfo = sql_fetch(" select * from helper_push_id WHERE device_serial='$ss_device_serial' AND mb_id='$member[mb_id]' ");
    $ss_fcmId = $pushInfo["fcm_id"];
}

//IT9 중앙 DB에서 삭제
$hpPushObj = new HpPush();
$hpPushObj->send_logout($ss_fcmId);



// 이호경님 제안 코드
session_unset(); // 모든 세션변수를 언레지스터 시켜줌
session_destroy(); // 세션해제함

// 자동로그인 해제 --------------------------------
set_cookie("ck_mb_id", "", 0);
set_cookie("ck_auto", "", 0);
// 자동로그인 해제 end --------------------------------

if ($url) {
    $link = $url;
} else if ($bo_table) {
    $link = $g4[mpath]."/bbs/board.php?bo_table=$bo_table";
} else {
    $link = $g4[mpath];
}


set_session("in_app", $isInApp);
?>

<script type='text/javascript'>
if(window.localStorage != null){
	window.localStorage.removeItem("u_mb_id")
	window.localStorage.removeItem("u_mb_password");
}
</script>


<?
goto_url($g4[mpath]."/bbs/login.php");
?>
