<?
include_once("./_common.php");



$obj = new APIStoreKKOMessage();
$qstr .= "";

if($w == ""){
	
	$no = $obj->insert($_REQUEST);
	$w = "u";
	
} else if($w=="u"){

	$obj->update($_REQUEST);


} else if($w=="d"){
	
	$obj->delete($_REQUEST["no"]);
	
	goto_url("./message_list.php?p={$p}&{$qstr}");
	exit;
}

goto_url("./message_form.php?w=u&no={$no}&{$qstr}");



