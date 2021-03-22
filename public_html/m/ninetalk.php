<?
include_once("./_common.php");

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
$sitekey = $_REQUEST["site_key"];
$in_app_path = "..".$g4['app_path'];
$return_url = urlencode($_REQUEST["return_url"]);
//====

$self = $_SERVER["PHP_SELF"];
$useragent = urlencode($_SERVER[HTTP_USER_AGENT]);
$protocol = isset($_SERVER['HTTPS']) ? "https://" : "http://";
$ninetalk_addon_loadurl = "http://ninetalk.1941.co.kr/app_alimi/chat/user_chatting_mobile.php?sitekey={$sitekey}&self={$self}&protocol={$protocol}&in_app_path={$in_app_path}&mb_id={$member[mb_id]}&user_chat_name={$_SESSION["user_chat_name"]}&user_chat_id={$_SESSION["user_chat_id"]}&mb_name={$member[mb_name]}&session_id=".session_id()."&ua={$useragent}&return_url={$return_url}";

$ninetalk_addon = ninetalk_script_load($ninetalk_addon_loadurl);
?>
<?=$ninetalk_addon;?>
