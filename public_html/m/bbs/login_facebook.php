<?
include_once("./_common.php");
header("content-type:text/html; charset=utf-8");

$access_token = $_REQUEST["access_token"];
$user_id = $_REQUEST["user_id"];
set_session("nlogin_access_token", $access_token);

if( !$access_token ) {
    alert("잘못된 접근입니다!");
} 


function send_post_api($headers, $url, $params, $is_test = false){

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,  $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER,  $headers);
		curl_setopt($ch, CURLOPT_POST,    true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
		$response = curl_exec($ch);
		curl_close($ch);
		$result = json_decode($response, true);

		return $result;
}


$headers = array(
		"Authorization: Bearer {$access_token}"
);
$url = "https://graph.facebook.com/v3.2/me";
$params = array();

$result = send_post_api($headers, $url, $params);
if(!$result["success"]){
	echo "<script>alert('페이스북 아이디로 로그인 실패하였습니다.');window.close();</script>";
}



//페이스북 아이디로(고유식별값) 가입된 회원이 있으면 로그인시킴
$n_member = sql_fetch(" SELECT * FROM {$g4[member_table]} WHERE mb_facebook_id='{$user_id}' AND mb_is_facebook=1 ");
if($n_member[mb_id]) {
	echo "
		<form name='q_loginform' method='post' action='/m/bbs/login_facebook_check.php'/>
			<input type='hidden' name='mb_id' value='{$n_member[mb_id]}'/>
			<input type='hidden' name='mb_password' value='{$n_member[mb_id]}'/>
			<input type='hidden' name='access_token' value='{$access_token}'/>
		</form>
		<script>
			document.q_loginform.submit();
		</script>
	";
	exit;
}



//페이스북 가입회원이 없으면 가입시킴
echo "
<form name='q_loginform' method='post' action='/m/bbs/register_facebook.php'/>
	<input type='hidden' name='access_token' value='{$access_token}'/>
</form>
<script>
	document.q_loginform.submit();
</script>
";


