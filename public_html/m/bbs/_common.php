<?
$g4_path = "../.."; // common.php 의 상대 경로
include_once("$g4_path/common.php");


if(!USE_MOBILE) { //config.php
    exit;
}


$g4["mpath"]=$g4['path']."/m"; 
$g4["shop_mpath"]=$g4['mpath']."/shop"; 
$g4["mbbs_path"]=$g4['path']."/m/bbs"; 

// 스킨경로
$board_skin_path = '';
if (isset($board['bo_skin']))
    $board_skin_path = "{$g4['path']}/m/skin/board/{$board['bo_skin']}"; // 게시판 스킨 경로

    
?>
