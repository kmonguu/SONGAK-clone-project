<?
include_once("./_common.php");

$pageNum='100';
$subNum='1';

$g4[title] = "로그인";
include_once("./_head.php");

// 이미 로그인 중이라면
if ($member[mb_id])
{
    if ($url)
        goto_url($url);
    else
        goto_url($g4[mpath]);
}

if ($url)
    $urlencode = urlencode($url);
else
    $urlencode = urlencode($_SERVER[REQUEST_URI]);

$member_skin_mpath = "$g4[mpath]/skin/member/$config[cf_member_skin]";

include_once("$member_skin_mpath/login.skin.php");

include_once("./_tail.php");
?>
