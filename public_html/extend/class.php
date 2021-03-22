<?
require("{$g4[path]}/lib/fpbatis.php");
$fpBatis = new FPBatis("{$g4[path]}/lib/sqlmap/sqlMap.xml");
$dao = $fpBatis;

if($_REQUEST[sqldebug]) $fpBatis->setDebug(true);

include_once("{$g4[path]}/lib/classes/classes.php");
?>