<?
$is_config = true;
include_once "./_common.php";
		
$ninetalk->update($site_key, $secret, $chat_name);

goto_url("./config.php");
