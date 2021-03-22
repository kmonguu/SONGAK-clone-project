<?
include_once("./_common.php");

ob_start(); 
setcookie("7777", "antispamreg"); 
ob_end_clean(); 
$_SESSION["as77"] = "antispamreg";



$ssn_nlogin_token = get_session("nlogin_access_token");
if($ssn_nlogin_token == "" || $access_token != $ssn_nlogin_token){
	alert("잘못된 접근입니다.");
}

$pageNum='100';
$subNum='3';

// 로그인중인 경우 회원가입 할 수 없습니다.
if ($member[mb_id]) 
    goto_url($g4[path]);

// 세션을 지웁니다.
set_session("ss_mb_reg", "");

$member_skin_path = "$g4[mpath]/skin/member/$config[cf_member_skin]";

$g4[title] = "회원가입약관";
include_once("./_head.php");
include_once("$member_skin_path/register_kakao.skin.php");
include_once("./_tail.php");
?>
