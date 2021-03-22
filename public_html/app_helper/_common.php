<?
$g4_path = ".."; // common.php 의 상대 경로
include_once("$g4_path/common.php");

if(!$no_common_read) { //_common2.php 불러온 페이지에서는 실행 안함

    $g4["mpath"]=$g4['path']."/app_helper";
    
    // 스킨경로
    $board_skin_path = '';
    if (isset($board['bo_skin']))
    $board_skin_path = "{$g4['path']}/app/skin/board/{$board['bo_skin']}"; // 게시판 스킨 경로    
   
    include_once($g4["mpath"]."/lib/class.php");
}
?>