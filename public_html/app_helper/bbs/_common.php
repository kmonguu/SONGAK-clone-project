<?
$g4_path = "../.."; // common.php 의 상대 경로
include_once("$g4_path/common.php");

$g4["mpath"]=$g4['path']."/app_helper";

$board_skin_mpath = "";
if (isset($board['bo_skin']))
    $board_skin_mpath = "{$g4['mpath']}/skin/board/{$board['bo_skin']}"; // 게시판 스킨 경로

include_once($g4["mpath"]."/lib/class.php");
?>