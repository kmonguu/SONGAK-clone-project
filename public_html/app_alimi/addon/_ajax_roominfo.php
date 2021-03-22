<? 
include "./_common.php";
$mb_id = $member[mb_id];
$chat_id = $mb_id ? $mb_id : $_SESSION["user_chat_id"];
$room_no = $mb_id ? $mb_id : session_id();

echo $chat_id."|".$room_no;