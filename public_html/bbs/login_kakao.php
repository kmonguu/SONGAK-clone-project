<?
include_once("./_common.php");
header("content-type:text/html; charset=utf-8");


$access_token = $_REQUEST["access_token"];
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
		
		//echo $response;

		$result = json_decode($response, true);

		return $result;
}


$headers = array(
		"Authorization: Bearer {$access_token}"
);

$url = "https://kapi.kakao.com/v2/user/me";
$params = array();

//회원정보
$result = send_post_api($headers, $url, $params);


if(!$result["id"]){
	echo "<script>alert('카카오 아이디로 로그인 실패하였습니다.');window.close();</script>";
}


//카카오 아이디로(고유식별값) 가입된 회원이 있으면 로그인시킴
$n_member = sql_fetch(" SELECT * FROM {$g4[member_table]} WHERE mb_kakao_id='{$result["id"]}' AND mb_is_kakao=1 ");
if($n_member[mb_id]) {
	echo "
		<form name='q_loginform' method='post' action='/bbs/login_kakao_check.php'/>
			<input type='hidden' name='mb_id' value='{$n_member[mb_id]}'/>
			<input type='hidden' name='mb_password' value='{$result["id"]}'/>
			<input type='hidden' name='access_token' value='{$access_token}'/>
		</form>
		<script>
			document.q_loginform.submit();
		</script>
	";
	exit;
}



//카카오아이디 가입회원이 없으면 가입시킴
echo "
<form name='q_loginform' method='post' action='/bbs/register_kakao.php'/>
	<input type='hidden' name='token_type' value='{$token_type}'/>
	<input type='hidden' name='access_token' value='{$access_token}'/>
</form>
<script>
	document.q_loginform.submit();
</script>
";


