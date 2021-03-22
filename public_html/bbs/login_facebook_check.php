<?
include_once("./_common.php");

$mb_id       = $_POST[mb_id];
$mb_password = $_POST[mb_password];


$ssn_nlogin_token = get_session("nlogin_access_token");
if($ssn_nlogin_token == "" || $access_token != $ssn_nlogin_token){
	alert("잘못된 접근입니다.");
}
$mb = get_member($mb_id);

set_session("nlogin_access_token", "");

// 차단된 아이디인가?
if ($mb[mb_intercept_date] && $mb[mb_intercept_date] <= date("Ymd", $g4[server_time])) {
    $date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1년 \\2월 \\3일", $mb[mb_intercept_date]); 
    alert("회원님의 아이디는 접근이 금지되어 있습니다.\\n\\n처리일 : $date");
}

// 탈퇴한 아이디인가?
if ($mb[mb_leave_date] && $mb[mb_leave_date] <= date("Ymd", $g4[server_time])) {
    $date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1년 \\2월 \\3일", $mb[mb_leave_date]); 
    alert("탈퇴한 아이디이므로 접근하실 수 없습니다.\\n\\n탈퇴일 : $date");
}

if ($config[cf_use_email_certify] && !preg_match("/[1-9]/", $mb[mb_email_certify]))
    alert("메일인증을 받으셔야 로그인 하실 수 있습니다.\\n\\n회원님의 메일주소는 $mb[mb_email] 입니다.");

$member_skin_path = "$g4[path]/skin/member/$config[cf_member_skin]";
@include_once("$member_skin_path/login_check.skin.php");

// 회원아이디 세션 생성
set_session('ss_mb_id', $mb[mb_id]);
// FLASH XSS 공격에 대응하기 위하여 회원의 고유키를 생성해 놓는다. 관리자에서 검사함 - 110106
set_session('ss_mb_key', md5($mb[mb_datetime] . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']));

// 3.26
// 아이디 쿠키에 한달간 저장
if ($auto_login) {
    // 3.27
    // 자동로그인 ---------------------------
    // 쿠키 한달간 저장
    $key = md5($_SERVER[SERVER_ADDR] . $_SERVER[REMOTE_ADDR] . $_SERVER[HTTP_USER_AGENT] . $mb[mb_password]);
    set_cookie('ck_mb_id', $mb[mb_id], 86400 * 31);
    set_cookie('ck_auto', $key, 86400 * 31);
    // 자동로그인 end ---------------------------
} else {
    set_cookie('ck_mb_id', '', 0);
    set_cookie('ck_auto', '', 0);
}


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



//CART 테이블 회원가격으로 조정 (영카트일 경우)
if (function_exists('set_cart_member_amount')) { 
	$member = $mb;
	//장바구니
	if($on_uid_key) set_cart_member_amount($on_uid_key);
	//바로구매
	if($on_direct_key) set_cart_member_amount($on_direct_key);
}

goto_url("/index.php");
?>
