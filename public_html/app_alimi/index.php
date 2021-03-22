<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

$_SESSION["chat_server"] = $_REQUEST["chat_server"];
if($_REQUEST["chat_server"] == ""){
	$_SESSION["chat_server"] = "ninetalk.1941.co.kr";
}

function getVer($url){$fuid = '/tmp/wget_tmp_'. md5($_SERVER['REMOTE_ADDR'] . microtime() . $url. $ip);$cmd = 'wget "' . $url . '" -O "' . $fuid . '" --read-timeout=30';`$cmd`;$data = file_get_contents($fuid);`rm -rf $fuid`;return $data;}
$ver = getVer("http://it9.co.kr/board_alimi.apk.versioncode.php");




$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if( (stripos($ua,'iphone') !== false) || (stripos($ua,'ipod') !== false) || (stripos($ua,'ipad') !== false)  )
{
	$isIOS = true;
	$code = "0";
	$version = "0";
	$gcmid = "";
}
else
	$isIOS = false;




?>
<!DOCTYPE HTML>
<html>
	<head>
	
		<title>IT9 INTRANET APPLICATION</title>
		
		<!-- 분석기 푸시 서버에다가 해당 사이트 사용정보를 등록시킵니다. -->
		<script src="http://analytics.1939.co.kr/setting_board_alimi.php?domain=<?=$_SERVER["HTTP_HOST"]?>&path=<?=$g4['app_path']?>&it9direct=Y"></script>
	
		<!-- IT9 인트라넷 DB에 알리미 사용여부를 등록합니다. -->
		<script src="http://it9.co.kr/api/set_alimi.php?domain=<?=$_SERVER["HTTP_HOST"]?>"></script>
		

		<?
		if(!$isIOS){
			$script_path = "js";
		} else {
			$script_path = "js_ios";
		}
		?>

		<script type="text/javascript" src="<?=$in_app_path?>/<?=$script_path?>/cordova.js?c=<?=date("YmdHis")?>"></script>
		<script type="text/javascript" src="<?=$in_app_path?>/<?=$script_path?>/jquery.js?c=<?=date("YmdHis")?>"></script>
		<script type="text/javascript" src="<?=$in_app_path?>/<?=$script_path?>/jquery-ui.js?c=<?=date("YmdHis")?>"></script>
		<script type="text/javascript" src="<?=$in_app_path?>/<?=$script_path?>/iscroll-lite.js?c=<?=date("YmdHis")?>"></script>
		<script type="text/javascript" src="<?=$in_app_path?>/<?=$script_path?>/common.js?c=<?=date("YmdHis")?>"></script>

		<script type="text/javascript">

			//백버튼으로 index페이지 접근 제한
			//window.history.replaceState( {} , '1_1', '<?=$in_app_path?>/pages.php?p=1_1_1_1' );
			document.addEventListener("deviceready", onDeviceReady, false);

			function onDeviceReady(){
					

					if(flatform.android){
						var current_code = <?=$code?>;
						var newest_code = <?=$ver?>;
						if(current_code < newest_code){
							//navigator.notification.confirm('어플리케이션이 업데이트되었습니다.\n원활한 사용을 위해서 업데이트를 진행해주시기 바랍니다.\n\nhttp://it9.co.kr/board.apk 파일을 다운로드 하시겠습니까?', goNewVer, '업데이트', '취소, 다운로드');
							if(!confirm("어플리케이션이 업데이트되었습니다.\n원활한 사용을 위해서 업데이트를 진행해주시기 바랍니다.\n\nhttp://it9.co.kr/board.apk 파일을 다운로드 하실 수 있습니다.\n\n현재버전으로 계속 실행하시겠습니까?")){
								if (navigator.app && navigator.app.exitApp) {
									navigator.app.exitApp();
								} else if (navigator.device && navigator.device.exitApp) {
									navigator.device.exitApp();
								}
							}
						}
					}
					
					//푸시 등록
					if(device.platform.toUpperCase() == 'ANDROID'){
						//GCM등록
						window.plugins.pushNotification.register(successHandler,errorHandler, {
						"senderID" : "173260773951", // Google GCM 서비스에서 생성한 Project Number를 입력한다.
						"ecb" : "onNotificationGCM" // 디바이스로 푸시가 오면 onNotificationGCM 함수를 실행할 수 있도록 ecb(event callback)에 등록한다.
						});
					} else {
					
						go_login("");
					}

			}
		

			//GCM이 등록되면 호출됨 //common.js
			function go_login(gcmid, bo_table, wr_id){
			
				closeProgress();
				
				try{
										
					if(bo_table === undefined) bo_table ="";
					if(wr_id === undefined) wr_id ="";
					
					if(window.localStorage != null){

						if(gcmid !== undefined && gcmid != "") { 
							window.localStorage.setItem('gcmId', gcmid);
						} else {
							gcmid = window.localStorage.getItem('gcmId');
						}

						if(gcmid == null || gcmid == "null") gcmid = "";

						var cid = window.localStorage.getItem('u_mb_id');
						var cpwd = window.localStorage.getItem('u_mb_password');


						showProgress("잠시만 기다려주세요");
						
						if(cid != "" && cid != null){
							location.href="./login/login_app.php?mb_id="+cid+"&mb_password="+cpwd+"&gcm_id="+gcmid + "&bo_table="+bo_table + "&wr_id="+wr_id;
						} else {
							//어플 삭제했다가 다시 실행시켰을 시
							$.post("<?=$in_app_path?>/del_logout.php", "gcmId="+gcmid, null);

							location.href="./login.php?gcm_id="+gcmid + "&bo_table="+bo_table + "&wr_id="+wr_id;
						}
					} else {
						location.href="login.php?gcm_id="+gcmid + "&bo_table="+bo_table + "&wr_id="+wr_id
					}

				}catch(e){
					console.log(e);
				}


			}

		</script>
	</head>
	<body id="firstbody" topmargin="0;" leftmargin="0;" style="background:white;">
		<div style="margin:0 auto;text-align:center;margin-top:25%;"><img src="./images/intro.png?3" style="width:100%"></div>
	</body>
	

	
</html>

