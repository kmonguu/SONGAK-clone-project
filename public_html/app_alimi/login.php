<?
include_once("./_common.php");
 
$g4['title'] = "홈페이지관리";

include_once("{$in_app_path}/head.sub.php");
include_once("./head.php");


if($chat_server){
$_SESSION["chat_server"] = $chat_server;
}

?>

<script type="text/javascript">
	is_main = true;

	$(function(){
		if(window.localStorage != null){
			if(window.localStorage.getItem("u_mb_id") != null && window.localStorage.getItem("u_mb_id") != "" ){
				document.lgnFrm.mb_id.value = window.localStorage.getItem("u_mb_id");
				document.lgnFrm.mb_password.value = window.localStorage.getItem("u_mb_password");
				<?if($gcm_id == ""){?>
					document.lgnFrm.gcm_id.value = window.localStorage.getItem("gcmId");
				<?}?>
			}
		}
	});
</script>



  <div data-role="content">
  
	<input type='hidden' class='pageName' value='1_1' />
	
	<form name="lgnFrm" action="<?=$in_app_path?>/login/login_app.php" target="_blank">
	<input type='hidden' class='pageName' value='0_1' />
	<div style="width:80%;margin:0 auto;">
	<input type="text" name="mb_id" placeholder="아이디"/>
	<div style="margin:15px 0 0 0;"><input type="password" name="mb_password" placeholder="비밀번호"/></div>
	<div style="margin:15px 0 0 0;"><input type="submit" value="로그인"/></div>
	<input type="hidden" name='gcm_id' id="gcm_id" value='<?=$gcm_id?>'>
	</div>
	
	</form>


	
  </div>




<?
include_once("./tail.php");
include_once("{$in_app_path}/tail.sub.php");
?>
 