<?
include_once("./_common.php");

@include_once("$board_skin_path/download.head.skin.php");

if ($member[mb_level] < $board[bo_download_level]) {
    $alert_msg = "다운로드 권한이 없습니다.";
    if ($member[mb_id])
        alert($alert_msg);
    else
        alert($alert_msg . "\\n\\n회원이시라면 로그인 후 이용해 보십시오.", "./login.php?wr_id=$wr_id&$qstr&url=".urlencode("$g4[bbs_path]/board.php?bo_table=$bo_table&wr_id=$wr_id"));
}

$filepath = addslashes($filepath);
if (!is_file($filepath) || !file_exists($filepath))
    alert("파일이 존재하지 않습니다.");
$original = "down_".time().".jpg";

if(preg_match("/msie/i", $_SERVER[HTTP_USER_AGENT]) && preg_match("/5\.5/", $_SERVER[HTTP_USER_AGENT])) {
	$ext = explode(".", $filepath);
	$original .= ".".$ext[count($ext)-1];
    header("content-type: doesn/matter");
    header("content-length: ".filesize("$filepath"));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-transfer-encoding: binary");
}else if(preg_match("/rv/i", $_SERVER[HTTP_USER_AGENT]) || preg_match("/msie/i", $_SERVER[HTTP_USER_AGENT])){
	$ext = explode(".", $filepath);
	$original .= ".".$ext[count($ext)-1];
    header("content-type: File Transfer");
    header("content-length: ".filesize("$filepath"));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-description: php generated data");
} else {
    header("content-type: File Transfer");
    header("content-length: ".filesize("$filepath"));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-description: php generated data");
}
header("pragma: no-cache");
header("expires: 0");
flush();

$fp = fopen("$filepath", "rb");

// 4.00 대체
// 서버부하를 줄이려면 print 나 echo 또는 while 문을 이용한 방법보다는 이방법이...
//if (!fpassthru($fp)) {
//    fclose($fp);
//}

$download_rate = 10;

while(!feof($fp)) {
    //echo fread($fp, 100*1024);
    /*
    echo fread($fp, 100*1024);
    flush();
    */

    print fread($fp, round($download_rate * 1024));
    flush();
    usleep(1000);
}
fclose ($fp);
flush();
?>
