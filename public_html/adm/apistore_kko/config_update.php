<?
include_once("./_common.php");


$obj = new APIStoreKKOConfig();


$config = $obj->get();
if($config["no"]){
	$obj->update($_REQUEST);
} else {
	$obj->insert($_REQUEST);
}


goto_url("./config.php?p={$p}&{$qstr}");
?>
