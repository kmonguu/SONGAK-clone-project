<? 
include "./_common.php";

$_SESSION["user_chat_id"] = $_REQUEST["chat_id"];
$_SESSION["user_chat_name"] = $_REQUEST["chat_name"];

$_SESSION["ss_push_key"] = md5($_REQUEST["chat_id"]."push_key");
?>