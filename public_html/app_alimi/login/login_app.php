<?
include_once("./_common.php");

$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if( (stripos($ua,'iphone') !== false) || (stripos($ua,'ipod') !== false) || (stripos($ua,'ipad') !== false)  )
	$isIOS = true;
else
	$isIOS = false;


$nocacheTime = date('ymd').time("His"); //개발시 현재시간으로, 개발완료시 고정값으로 변경하는게 좋을듯

$mb_id       = $_REQUEST[mb_id];
$mb_password = $_REQUEST[mb_password];
$gcm_id = $_REQUEST[gcm_id];

if (!trim($mb_id) || !trim($mb_password))
    alert("회원아이디나 패스워드가 공백이면 안됩니다.", "{$in_app_path}/login.php");



$mb = get_member($mb_id);

	
// 가입된 회원이 아니다. 패스워드가 틀리다. 라는 메세지를 따로 보여주지 않는 이유는 
// 회원아이디를 입력해 보고 맞으면 또 패스워드를 입력해보는 경우를 방지하기 위해서입니다.
// 불법사용자의 경우 회원아이디가 틀린지, 패스워드가 틀린지를 알기까지는 많은 시간이 소요되기 때문입니다.
if (!$mb[mb_id] || (sql_password($mb_password) != $mb[mb_password])) {
    echo "<script type='text/javascript'>window.localStorage.removeItem('u_mb_id');window.localStorage.removeItem('u_mb_password');</script>'";
    alert("가입된 회원이 아니거나 패스워드가 틀립니다.\\n\\n패스워드는 대소문자를 구분합니다.", "{$in_app_path}/login.php?gcm_id={$gcm_id}");
}

// 차단된 아이디인가?
if ($mb[mb_intercept_date] && $mb[mb_intercept_date] <= date("Ymd", $g4[server_time])) {
    echo "<script type='text/javascript'>window.localStorage.removeItem('u_mb_id');window.localStorage.removeItem('u_mb_password');</script>'";
    $date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1년 \\2월 \\3일", $mb[mb_intercept_date]); 
    alert("회원님의 아이디는 접근이 금지되어 있습니다.\\n\\n처리일 : $date", "{$in_app_path}/login.php?gcm_id={$gcm_id}");
}

// 탈퇴한 아이디인가?
if ($mb[mb_leave_date] && $mb[mb_leave_date] <= date("Ymd", $g4[server_time])) {
    echo "<script type='text/javascript'>window.localStorage.removeItem('u_mb_id');window.localStorage.removeItem('u_mb_password');</script>'";
    $date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1년 \\2월 \\3일", $mb[mb_leave_date]); 
    alert("탈퇴한 아이디이므로 접근하실 수 없습니다.\\n\\n탈퇴일 : $date", "{$in_app_path}/login.php?gcm_id={$gcm_id}");
}

if ($config[cf_use_email_certify] && !preg_match("/[1-9]/", $mb[mb_email_certify])){
    echo "<script type='text/javascript'>window.localStorage.removeItem('u_mb_id');window.localStorage.removeItem('u_mb_password');</script>'";
    alert("메일인증을 받으셔야 로그인 하실 수 있습니다.\\n\\n회원님의 메일주소는 $mb[mb_email] 입니다.", "{$in_app_path}/login.php?gcm_id={$gcm_id}");
}

if ($mb[mb_level] < 5) {
    echo "<script type='text/javascript'>window.localStorage.removeItem('u_mb_id');window.localStorage.removeItem('u_mb_password');</script>'";
    alert("회원레벨 5 이상만 로그인하실 수 있습니다.", "{$in_app_path}/login.php?gcm_id={$gcm_id}");
}



// 회원아이디 세션 생성
set_session('ss_mb_id', $mb[mb_id]);



// 채팅고유아이디 생성 ( 도매인 + 아이디 )
set_session('chat_id', md5($_SERVER[HTTP_HOST].$mb[mb_id]));




// 자동로그인 ---------------------------
// 쿠키 한달간 저장
$key = md5($_SERVER[SERVER_ADDR] . "APP" . $_SERVER[HTTP_USER_AGENT] . $mb[mb_password]);
set_cookie('ck_mb_id', $mb[mb_id], 86400 * 9999);
set_cookie('ck_auto', $key, 86400 * 9999);
// 자동로그인 end ---------------------------


if ($url) 
{
    $link = urldecode($url);
    // 2003-06-14 추가 (다른 변수들을 넘겨주기 위함)
    if (preg_match("/\?/", $link))
        $split= "&"; 
    else
        $split= "?"; 

    // $_POST 배열변수에서 아래의 이름을 가지지 않은 것만 넘김
    foreach($_POST as $key=>$value) 
    {
        if ($key != "mb_id" && $key != "mb_password" && $key != "x" && $key != "y" && $key != "url") 
        {
            $link .= "$split$key=$value";
            $split = "&";
        }
    }
} 
else
    $link = $g4[path];



//gcmid 비교 값 수정
if($gcm_id != "" && $gcm_id != "undefined"){
	$gcmCnt = sql_fetch(" SELECT COUNT(*) as cnt FROM it9_gcmid WHERE mb_id='$mb[mb_id]' AND gcm_id='$gcm_id' ");
	if($gcmCnt[cnt] == 0)	
		sql_query(" insert into it9_gcmid set mb_id='$mb[mb_id]', gcm_id='$gcm_id', reg_dt=now() ");
}

//goto_url("$g4[path]/user/main.php");
?>


<?
if(!$isIOS){
	$script_path = "js";
} else {
	$script_path = "js_ios";
}
?>
<script type="text/javascript" src="<?=$in_app_path?>/<?=$script_path?>/common.js?nochache=<?=$nocacheTime?>"></script>



<script type='text/javascript'>
if(window.localStorage != null){
	if(window.localStorage.getItem("u_mb_id") != ""){
		window.localStorage.setItem("u_mb_id", "<?=$mb_id?>");
		window.localStorage.setItem("u_mb_password", "<?=$mb_password?>");
	}

	window.localStorage.setItem("gcmId", "<?=$gcm_id?>");
}
//push메시지 타입
var bo_table = "<?=$_REQUEST[bo_table]?>";
//push메시지 이동 게시글 아이디
var wr_id = "<?=$_REQUEST[wr_id]?>";

if(bo_table != ""){
	
	if(bo_table != "chatting")
		goto_first_page(bo_table, wr_id);
	else
		location.href = "<?=$in_app_path?>/pages.php?p=2_1_1_1&first=Y&room_no="+wr_id;
						
} else {
	location.href = "<?=$in_app_path?>/pages.php?p=1_1_1_1&first=Y";

}

</script>
