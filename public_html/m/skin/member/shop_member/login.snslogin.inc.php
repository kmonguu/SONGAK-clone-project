
<?if($config["cf_use_naver_id_login"]){
//###########################################################################################
//네이버 아이디로 로그인
function generate_state() {
    $mt = microtime();
    $rand = mt_rand();
    return md5($mt . $rand);
}
// 상태 토큰으로 사용할 랜덤 문자열을 생성
$state = generate_state();
// 세션 또는 별도의 저장 공간에 상태 토큰을 저장
set_session("nlogin_token", $state);
?>
<script>
	function naver_login(){
		isOnbeforeunload_show_loading = false;
		location.href = "https://nid.naver.com/oauth2.0/authorize?client_id=<?=$g4['nlogin_client_id']?>&response_type=code&redirect_uri=<?=(isset($_SERVER['HTTPS']) ? 'https:' : 'http:')?>//<?=$g4['nlogin_callback_domain']?>/m/bbs/login_naver.php&state=<?=$state?>";
	}
</script>

<?
//네이버 아이디로 로그인
//##########################################################################################3
}
?>






<?if($config["cf_use_kakao_id_login"]){
//##########################################################################################3
//카카오 아이디로 로그인 (카카오 API를 다른곳에서 사용중이면 js/key는 Tail에서 공통으로 불러와야 함)
?>
<script type='text/javascript'>
  //<![CDATA[
   // 사용할 앱의 JavaScript 키를 설정해 주세요.
   function loginWithKakao() {
      // 로그인 창을 띄웁니다.
      Kakao.Auth.login({
        success: function(authObj) {
          //alert(JSON.stringify(authObj));
		  go_kakao_login(authObj.access_token, authObj.refresh_token, authObj.scope);
        },
        fail: function(err) {
          alert(JSON.stringify(err));
        }
      });
    }
	function go_kakao_login(t, rt, s){
		document.kakaologin.access_token.value = t;
		document.kakaologin.refresh_token.value = rt;
		document.kakaologin.scope = s;
		document.kakaologin.submit();
	}
  //]]>
</script>
<form name="kakaologin" action="<?=$g4["mpath"]?>/bbs/login_kakao.php" method="post">
	<input type="hidden" name="access_token" />
	<input type="hidden" name="refresh_token" />
	<input type="hidden" name="scope" />
</form>
<?
//카카오 아이디로 로그인
//############################################################################################
}
?>




<?if($config["cf_use_facebook_id_login"]){
//##########################################################################################3
//페이스북 로그인
?>
<script>
function facebook_login(){
	FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
	});
}

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '<?=$g4["facebook_app_id"]?>',
      cookie     : true,
      xfbml      : true,
      version    : '<?=$g4["facebook_app_ver"]?>'
    });
    FB.AppEvents.logPageView();   
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
	
	// This is called with the results from from FB.getLoginStatus().
	function statusChangeCallback(response) {

		if (response.status === 'connected') {
		
			document.facebooklogin.access_token.value = response.authResponse.accessToken;
			document.facebooklogin.user_id.value = response.authResponse.userID;
			document.facebooklogin.submit();

		} else {

			FB.login(
				function(response) {
					if (response.authResponse) {
						document.facebooklogin.access_token.value = response.authResponse.accessToken;
						document.facebooklogin.user_id.value = response.authResponse.userID;
						document.facebooklogin.submit();
					} else {
						alert('User cancelled login or did not fully authorize.');
					}	
				}
				,
				{scope: 'public_profile,email'}
			);
		}
	}

</script>
<form name="facebooklogin" action="<?=$g4["mpath"]?>/bbs/login_facebook.php" method="post">
	<input type="hidden" name="access_token" />
	<input type="hidden" name="user_id" />
</form>
<?
//페이스북 로그인
//##########################################################################################
}
?>