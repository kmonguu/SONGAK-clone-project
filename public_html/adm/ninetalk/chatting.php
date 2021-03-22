<?
include_once("./_common.php");
if($member[mb_level] != 10) alert("관리자만 접근할 수 있습니다.");


$chat_id = "";
if(!$ninetalk->get_chat_id()){
	$chat_id = md5("PC".$ninetalk->get_site_key().$member[mb_id]);
	$chat_name = $member[mb_name];
} else {
	$chat_id = $ninetalk->get_chat_id();
	$chat_name = $ninetalk->get_chat_name();
}




function ninetalk_script_load($url){$fuid = '/tmp/wget_tmp_' . md5($_SERVER['REMOTE_ADDR'] . microtime() . $url);$cmd = 'wget "' . $url . '" -O "' . $fuid . '" --read-timeout=30';`$cmd`;$data = file_get_contents($fuid);`rm -rf $fuid`;return $data;}
function ninetalk_script_load_curl($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,   $url);
	curl_setopt($ch, CURLOPT_POST,  false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$response = curl_exec($ch);
	curl_close($ch);

	return $response;
}

//설정===
$sitekey = $ninetalk->get_site_key();
$in_app_path = $g4_path.$g4['app_path'];

$user_chat_id = $chat_id;
$user_chat_name = $chat_name;

$room_no = $_REQUEST["room_no"];

//====

$self = $_SERVER["PHP_SELF"];
$useragent = urlencode($_SERVER[HTTP_USER_AGENT]);
$protocol = isset($_SERVER['HTTPS']) ? "https://" : "http://";
$ninetalk_addon_loadurl = "http://ninetalk.1941.co.kr/app_alimi/chat_adm/user_chatting_admin.php?sitekey={$sitekey}&self={$self}&protocol={$protocol}&in_app_path={$in_app_path}&user_chat_id={$user_chat_id}&user_chat_name={$user_chat_name}&session_id={$room_no}&ua={$useragent}&return_url={$return_url}";

$ninetalk_addon = ninetalk_script_load($ninetalk_addon_loadurl);
?>
<?=$ninetalk_addon;?>
