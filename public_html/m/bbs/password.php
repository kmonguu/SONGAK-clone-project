<?
include_once("./_common.php");

if ($w == "u")
    $action = "./write.php";
else if ($w == "d")
    $action = "./delete.php";
else if ($w == "x")
    $action = "./delete_comment.php";
else if ($w == "s")
{
    // 패스워드 창에서 로그인 하는 경우 관리자 또는 자신의 글이면 바로 글보기로 감
    if ($is_admin || ($member[mb_id] == $write[mb_id] && $write[mb_id]))
        goto_url("./board.php?bo_table=$bo_table&wr_id=$wr_id");
    else
        $action = "./password_check.php";
}
else
    alert("w 값이 제대로 넘어오지 않았습니다.");

$g4[title] = "패스워드 입력";
include_once("$g4[mpath]/head.sub.php");

if ($board[bo_include_head]) { @include ($board[bo_include_head]); }
if ($board[bo_content_head]) { 
	echo "<div class='board_content_head'>";
	echo stripslashes($board[bo_content_head]); 
	echo "</div>";
} 


$member_skin_mpath = "$g4[mpath]/skin/member/$config[cf_member_skin]";

include_once("$member_skin_mpath/password.skin.php");

if ($board[bo_content_tail]) { echo stripslashes($board[bo_content_tail]); } 
if ($board[bo_include_tail]) { @include ($board[bo_include_tail]); }

include_once("$g4[mpath]/tail.sub.php");
?>
