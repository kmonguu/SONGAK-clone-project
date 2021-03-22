<?

//로그인화면이 아니면 로그인 체크해서 로그인으로 보냄
if ($member["mb_level"] < 7 && !preg_match("/app.php$/", $_SERVER['PHP_SELF']) && !preg_match("/login.php$/", $_SERVER['PHP_SELF']) && !preg_match("/login_check.php$/", $_SERVER['PHP_SELF']) && !preg_match("/logout.php$/", $_SERVER['PHP_SELF'])) { 
	alert("권한이 없거나, 로그인 되어있지 않습니다.",$g4["mpath"]."/bbs/logout.php");
 }


//chat_server 셋팅
if($_REQUEST["chat_server"]) {
	set_session("chat_server", $_REQUEST["chat_server"]);
}
if(get_session("chat_server")== "") {
	if($_REQUEST["chat_server"] == ""){
		$_SESSION["chat_server"] = "ninetalk.1941.co.kr";
	}
}
$chat_server = get_session("chat_server");


//채팅아이디
$chat_id = md5($_SERVER[HTTP_HOST].$member[mb_id]);
if(get_session("chat_id") == "") {
	set_session("chat_id", $chat_id);
}

//해당 사이트 식별값으로 쓰일 sitekey
$sitekey = md5($_SERVER["DOCUMENT_ROOT"].$_SERVER["SERVER_ADDR"]);


require("{$g4[mpath]}/lib/fpbatis.php");
$fpBatisApp = new FPBatis_forHelper("{$g4[mpath]}/lib/sqlmap/sqlMap.xml");
$helper_dao = $fpBatisApp;

if($_REQUEST[sqldebug]) $fpBatisApp->setDebug(true);

include_once("{$g4[mpath]}/lib/classes/classes.php");
?>