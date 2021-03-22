<?
include_once("./_common.php");

if ($member[mb_id]) 
{
    echo "<script type='text/javascript'>";
    echo "alert('이미 로그인중입니다.');";
    echo "window.close();";
    echo "opener.document.location.reload();";
    echo "</script>";
    exit;
}

$g4[title] = "회원아이디/패스워드 찾기";
include_once("$g4[mpath]/head.sub.php");

$member_skin_mpath = "$g4[mpath]/skin/member/$config[cf_member_skin]";
include_once("$member_skin_mpath/password_lost.skin.php");

include_once("$g4[mpath]/tail.sub.php");
?>