<?
include "./_common.php";

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


$chat_id = get_session("chat_id");
$chat_server = $_SESSION["chat_server"];

$self = $_SERVER["PHP_SELF"];
$return_url = $_SERVER[HTTP_HOST].urlencode($_SERVER[REQUEST_URI]);
$useragent = urlencode($_SERVER[HTTP_USER_AGENT]);
$protocol = isset($_SERVER['HTTPS']) ? "https://" : "http://";
$ninetalk_addon_loadurl = "http://{$chat_server}/app_alimi/chat/admin_chat_list.php?v=1&protocol={$protocol}&chat_id={$chat_id}&chat_server={$chat_server}";

$ninetalk_addon = ninetalk_script_load($ninetalk_addon_loadurl);
?>
<?=$ninetalk_addon;?>
    