<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

$in_app_path = "{$g4[mpath]}";
set_session("in_app", "Y");
set_session("fcmid_get_hour", ""); //새로실행하면 FCMID 다시 받게



$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
$script_path = "js";
if( (stripos($ua,'iphone') !== false) || (stripos($ua,'ipod') !== false) || (stripos($ua,'ipad') !== false)  )
{
	$isIOS = true;
	$script_path = "js/ios";
} else 
	$isIOS = false;



//IT9 테이블에 등록/중복제거 절차
$pushObj = new HpPush();
$pushObj->send_itnine_sites();

?>
<!DOCTYPE HTML>
<html>
	<head>
	
		
		<meta name="viewport" content="viewport-fit=cover">

		<title>홈페이지도우미</title>
		<script>
			var c_ip = "<?=$_SERVER[REMOTE_ADDR]?>";
		</script>
		<script type="text/javascript" src="<?=$in_app_path?>/js/jquery-1.6.2.min.js"></script>


		
		<script type="text/javascript" src="<?=$in_app_path?>/<?=$script_path?>/cordova.js?c=<?=date("YmdHis")?>"></script>
		<script type="text/javascript" src="<?=$in_app_path?>/<?=$script_path?>/common_app.js?c=<?=date("YmdHis")?>"></script>
		<script type="text/javascript" src="<?=$in_app_path?>/<?=$script_path?>/phone_event.js?c=<?=date("YmdHis")?>"></script>

		<script type="text/javascript">

		function onLoad() {
			document.addEventListener("deviceready", onDeviceReady, false);
		}

			
		function onDeviceReady(){

				showProgress("잠시만 기다려주세요.");
				var cid = window.localStorage.getItem('u_mb_id');
				var cpwd = window.localStorage.getItem('u_mb_password');

				if(cid != "" && cid != null){
					$("#mb_id").val(cid);
					$("#mb_password").val(cpwd);
					$("#loginform").submit();
				}
				else {
					location.href = "./bbs/login.php";
				}
		}


		</script>

	</head>
	
	<body id="firstbody" topmargin="0;" leftmargin="0;" onload="onLoad()">

		<form id="loginform" name="loginform" style="display:none;" method="post" action="<?=$in_app_path?>/bbs/login_check.php">
			<input type="hidden" id="mb_id" name="mb_id" value=""/>
			<input type="hidden" id="mb_password" name="mb_password" value=""/>
		</form>

	</body>
		
</html>