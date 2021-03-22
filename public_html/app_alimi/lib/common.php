<?
require("{$g4[path]}{$g4[app_path]}/lib/fpbatis.php");
$fpBatis = new FPBatis_forAlimi("{$g4[path]}{$g4[app_path]}/lib/sqlmap/sqlMap.xml");
$dao = $fpBatis;

if($_REQUEST[sqldebug]) $fpBatis->setDebug(true);

include_once("{$g4[path]}{$g4[app_path]}/lib/class/classes.php");


//채팅아이디
set_session('chat_id', md5($_SERVER[HTTP_HOST].$member[mb_id]));
?>