<?
include_once("./_common.php");

if (!$member[mb_id]) 
    alert("로그인 한 회원만 접근하실 수 있습니다.");

/*
if ($url)
    $urlencode = urlencode($url);
else
    $urlencode = urlencode($_SERVER[REQUEST_URI]);
*/
$pageNum='100';
$subNum='2';

$g4[title] = "회원 패스워드 확인";
include_once("./_head.php");

if(!$member["mb_is_naver"] && !$member["mb_is_kakao"] && !$member["mb_is_facebook"]) {
	$member_skin_mpath = "$g4[mpath]/skin/member/$config[cf_member_skin]";
	include_once("$member_skin_mpath/member_confirm.skin.php");
} else {

	if (preg_match("/member_leave.php/", $url)) {
		goto_url("$g4[mpath]/bbs/member_leave.php");
	} else {
		goto_url("$g4[mpath]/bbs/register_form.php?w=u");
    }
    
}

include_once("./_tail.php");
?>
