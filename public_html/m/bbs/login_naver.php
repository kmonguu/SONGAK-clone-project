<?
include_once("./_common.php");
header("content-type:text/html; charset=utf-8");

$state = $_REQUEST["state"];
$stored_state = get_session("nlogin_token");

if( $state != $stored_state ) {
    alert("잘못된 접근입니다!");
} 


function script_load_curl($url, $headers=""){ 
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL,  $url); 
	if($headers) curl_setopt($ch, CURLOPT_HTTPHEADER,  $headers);
	curl_setopt($ch, CURLOPT_POST,  false); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	$response = curl_exec($ch); 
	curl_close($ch); 

	return $response; 
} 

//토큰얻기
$url = "https://nid.naver.com/oauth2.0/token?client_id={$g4[nlogin_client_id]}&client_secret={$g4[nlogin_secret]}&grant_type=authorization_code&state={$state}&code={$code}";
$result = script_load_curl($url);
$r = json_decode($result);
if($r->error){
	if($r->error == "invalid_request") {
		alert($r->error." 취소되었습니다.");
	} else {
		alert($r->error);
	}
	exit;
}


//유저정보 얻기
$access_token = $r->access_token;
$refresh_token = $r->refresh_token;
$token_type = $r->token_type;
$headers = array(
	 "Authorization:{$token_type} {$access_token}"
);




$userXML = script_load_curl("https://apis.naver.com/nidlogin/nid/getUserProfile.xml", $headers);
$userinfo = simplexml_load_string($userXML); 
$user = $userinfo->response;


set_session("nlogin_token_type", $token_type);
set_session("nlogin_access_token", $access_token);




//네이버아이디로(고유식별값) 가입된 회원이 있으면 로그인시킴
$n_member = sql_fetch(" SELECT * FROM {$g4[member_table]} WHERE mb_naver_id='{$user->id}' AND mb_is_naver=1 ");
if($n_member[mb_id]) {
	echo "
		<form name='naver_loginform' method='post' action='/m/bbs/login_naver_check.php'/>
			<input type='hidden' name='mb_id' value='{$n_member[mb_id]}'/>
			<input type='hidden' name='mb_password' value='{$user->id}'/>
			<input type='hidden' name='access_token' value='{$access_token}'/>
		</form>
		<script>
			document.naver_loginform.submit();
		</script>
	";
	exit;
}



//네이버 아이디 가입회원이 없으면 가입시킴
echo "
<form name='naver_loginform' method='post' action='/m/bbs/register_naver.php'/>
	<input type='hidden' name='token_type' value='{$token_type}'/>
	<input type='hidden' name='access_token' value='{$access_token}'/>
</form>
<script>
	document.naver_loginform.submit();
</script>
";
