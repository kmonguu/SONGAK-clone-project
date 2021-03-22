<?
include_once("./_common.php");

$chatServer = $_SESSION["chat_server"];

//gcmid 해제
$ss_gcmId = $_REQUEST['gcmid'];
sql_query(" delete from it9_gcmid where gcm_id='$ss_gcmId' AND mb_id='$member[mb_id]' ");

//FCM해제
$ss_fcmId = get_session("fcm_id");
$ss_device_serial = get_session("device_serial");
if($ss_fcmId) sql_query(" delete from push_fcmid where fcm_id='$ss_fcmId' AND mb_id='$member[mb_id]' ");
if($ss_device_serial) sql_query(" delete from push_fcmid where device_serial='$ss_device_serial' AND mb_id='$member[mb_id]' ");




// 이호경님 제안 코드
session_unset(); // 모든 세션변수를 언레지스터 시켜줌 
session_destroy(); // 세션해제함 

// 자동로그인 해제 --------------------------------
set_cookie("ck_mb_id", "", 0);
set_cookie("ck_auto", "", 0);

// 자동로그인 해제 end --------------------------------

//setcookie("adCheck", $admin_check, $g4[server_time] + 4*60*60*1000, '/', $g4[cookie_domain]);
setcookie("adCheck", "", time() - 3600, '/', $g4[cookie_domain]);
unset($_COOKIE["adCheck"]);

if ($url) {
    $link = $url;
} else if ($bo_table) {
    $link = "$g4[bbs_path]/board.php?bo_table=$bo_table";
} else {
    $link = $g4[path];
}

?>

<script type='text/javascript'>

if(window.localStorage != null){
	window.localStorage.removeItem("u_mb_id")
	window.localStorage.removeItem("u_mb_password");
	//window.localStorage.removeItem("gcmId");
}
location.href = "<?=$in_app_path?>/login.php?chat_server=<?=$chatServer?>&gcm_id=<?=$ss_gcmId?>";

</script>
