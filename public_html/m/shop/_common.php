<?
$g4_path = "../.."; // common.php 의 상대 경로
include_once("$g4_path/common.php");

if(!USE_MOBILE) { //config.php
    exit;
}

$g4["mbbs_path"]=$g4['path']."/m/bbs"; 
$g4["mpath"]=$g4['path']."/m"; 
$g4["shop_mpath"]=$g4['mpath']."/shop"; 

?>