<?
$nocacheTime = date('ymd').time("His"); //개발시 현재시간으로, 개발완료시 고정값으로 변경하는게 좋을듯

$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if( (stripos($ua,'iphone') !== false) || (stripos($ua,'ipod') !== false) || (stripos($ua,'ipad') !== false)  )
	$isIOS = true;
else
	$isIOS = false;

?>
<!DOCTYPE html> 
<html style='overflow-x:hidden'>
<head>
<meta name="viewport" content="width=device-width, user-scalable=no" />
<meta http-equiv="content-type" content="text/html; charset=<?=$g4['charset']?>">
<meta name="format-detection" content="telephone=no" />
<title><?=$g4['title']?></title>


<link rel="stylesheet" href="<?=$in_app_path?>/js/jquery-ui.css" type="text/css"/>
<link rel="stylesheet" href="<?=$in_app_path?>/js/jquery.mobile-1.3.2.css?1" type="text/css">
<link rel="stylesheet" href="<?=$in_app_path?>/css/init.css?nochache=<?=$nocacheTime?>" type="text/css">
<link rel="stylesheet" href="<?=$in_app_path?>/css/layout.css?nochache=<?=$nocacheTime?>" type="text/css">
<link rel="stylesheet" href="<?=$in_app_path?>/css/content.css?nochache=<?=$nocacheTime?>" type="text/css">


<style type="text/css">
html {
    -webkit-touch-callout:none;
    -webkit-user-select:none;
    -webkit-tap-highlight-color:rgba(0, 0, 0, 0);
}
</style>

</head>
<script type="text/javascript">
// 자바스크립트에서 사용하는 전역변수 선언
var g4_path      = "<?=$g4['path']?>";
var g4_bbs       = "<?=$g4['bbs']?>";
var g4_bbs_img   = "<?=$g4['bbs_img']?>";
var g4_url       = "<?=$g4['url']?>";
var g4_is_member = "<?=$is_member?>";
var g4_is_admin  = "<?=$is_admin?>";
var g4_bo_table  = "<?=isset($bo_table)?$bo_table:'';?>";
var g4_sca       = "<?=isset($sca)?$sca:'';?>";
var g4_charset   = "<?=$g4['charset']?>";
var g4_cookie_domain = "<?=$g4['cookie_domain']?>";
var g4_is_gecko  = navigator.userAgent.toLowerCase().indexOf("gecko") != -1;
var g4_is_ie     = navigator.userAgent.toLowerCase().indexOf("msie") != -1;
var g4_app_path = "<?=$in_app_path?>";
<? if ($is_admin) { echo "var g4_admin = '{$g4['admin']}';"; } ?>
</script>


<?
if(!$isIOS){
	$script_path = "js";
} else {
	$script_path = "js_ios";
}
?>


<script type="text/javascript" src="<?=$in_app_path?>/<?=$script_path?>/jquery.js"></script>
<script type="text/javascript" src="<?=$in_app_path?>/<?=$script_path?>/jquery-ui.js"></script> 
<script type="text/javascript" src="<?=$in_app_path?>/<?=$script_path?>/jquery.mobile-1.3.0.js?1"></script>
<script type="text/javascript" src="<?=$in_app_path?>/<?=$script_path?>/cordova.js?nochache=<?=$nocacheTime?>"></script>
<script type="text/javascript" src="<?=$in_app_path?>/<?=$script_path?>/common.js?nochache=<?=$nocacheTime?>"></script>
<script type="text/javascript" src="<?=$in_app_path?>/<?=$script_path?>/phone_event.js?nochache=<?=$nocacheTime?>"></script>
<script type="text/javascript" src="<?=$in_app_path?>/<?=$script_path?>/link.js?nochache=<?=$nocacheTime?>"></script>


<? $ninetalk_chat_port = "8000";?>
<script src="//ninetalk.1941.co.kr/js/socket.io.js"></script>


<script type="text/javascript" src="<?=$g4["path"]?>/js/board.js"></script>



<script type="text/javascript">

	
	var secret = "";
	var site_key = "";
	var chat_server = "<?=$_SESSION["chat_server"]?>";

	//phonegap ready
	document.addEventListener("deviceready", onDeviceReady, false);

	function onDeviceReady(){
		try{
			init_phone_event(); //phone_event.js


			<?if($isIOS && $member["mb_id"]){?>
				setPush();
			<?}?>


			<?if($first == "Y" && $room_no != ""){?>	
				try {
					open_chatting("<?=$room_no?>");
				} catch(ex){
					alert(ex);
				}
			<? }?>	
		
		}
		catch(ex){
			error(ex);
		}
	}
	

	$( document ).delegate("#roomnetpage", "pageinit", function() {
		
		//$('[data-role=header],[data-role=footer]').fixedtoolbar({ tapToggle:false }); 
		if(typeof(pageinit) == "function") { 
			pageinit(); 
		}
	});

	$( document ).delegate("#roomnetpage", "pageshow", function() {

		var pageName = $(".ui-page-active").find(".pageName").val();
		if(pageName != "" && pageName !== undefined){
			var pn = pageName.split("_")[0];
			var sn = pageName.split("_")[1];
		}

		if(pageName == "1_1" || pageName == "2_1" )
			is_main = true;
		else
			is_main = false;

		$(".mmn").removeClass("ui-btn-active");
		$(".smn").removeClass("ui-btn-active");
		$(".m"+pn+"_1").addClass("ui-btn-active");
		$(".s"+pn+"_"+sn).addClass("ui-btn-active");

		secret = window.localStorage.getItem("secret");
		site_key = window.localStorage.getItem("site_key");
		secret = secret == null ? "" : secret;
		site_key = site_key == null ? "" : site_key;


		if(typeof(pageshow) == "function") { 
			pageshow(); 
		}
		
		if(typeof(initKeyboardSetting) == "function") { //IOS 전용
			initKeyboardSetting();
		}
		
		
	});

	function chk_sitekey(){
	
		if(site_key === undefined || site_key == null || site_key == "" || site_key == "null" ){
			//alert_app("실시간 채팅을 위해 SITE KEY 설정이 필요합니다.");
			menulink("menu03-1");
			return false;
		}
		return true;
	}


</script>

<body topmargin="0" leftmargin="0" <?=isset($g4['body_script']) ? $g4['body_script'] : "";?>>
<input type='hidden' class='isMain' value='false'>





