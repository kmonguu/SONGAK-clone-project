<?
include("base.class.php");
include("common.class.php");

$tmp_cr_clses = dir("$g4[path]/lib/classes/controller/class");
while ($cr_cls = $tmp_cr_clses->read()) {
	if (preg_match("/(\.class.php)$/i", $cr_cls))
		include("$g4[path]/lib/classes/controller/class/$cr_cls");
}
?>