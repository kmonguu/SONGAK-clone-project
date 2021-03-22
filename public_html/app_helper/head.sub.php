<?
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$nocache = date("YmdHis");


$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
$script_path = "js";
if( (stripos($ua,'iphone') !== false) || (stripos($ua,'ipod') !== false) || (stripos($ua,'ipad') !== false)  )
{
	$isIOS = true;
	$script_path = "js/ios";
}
else
	$isIOS = false;


$isAndroid = false;
if( (stripos($ua,'android') !== false)  )  {
	$isAndroid = true;
}


//로그인안했으면 로그인화면으로
 if (!$member["mb_id"] && !preg_match("/login.php$/", $_SERVER['PHP_SELF'])) { 
	goto_url($g4["mpath"]."/bbs/login.php");
 }





if (!$g4['title'])
    $g4['title'] = $config['cf_title'];
include_once("$g4[mpath]/lib/mobile.lib.php");

// 쪽지를 받았나?
if ($member['mb_memo_call']) {
    $mb = get_member($member[mb_memo_call], "mb_nick");
    sql_query(" update {$g4[member_table]} set mb_memo_call = '' where mb_id = '$member[mb_id]' ");

    alert($mb[mb_nick]."님으로부터 쪽지가 전달되었습니다.", $_SERVER[REQUEST_URI]);
}


// 현재 접속자
//$lo_location = get_text($g4[title]);
//$lo_location = $g4[title];
// 게시판 제목에 ' 포함되면 오류 발생
$lo_location = addslashes($g4['title']);
if (!$lo_location)
    $lo_location = $_SERVER['REQUEST_URI'];
//$lo_url = $g4[url] . $_SERVER['REQUEST_URI'];
$lo_url = $_SERVER['REQUEST_URI'];
if (strstr($lo_url, "/$g4[admin]/") || $is_admin == "super") $lo_url = "";

// 자바스크립트에서 go(-1) 함수를 쓰면 폼값이 사라질때 해당 폼의 상단에 사용하면
// 캐쉬의 내용을 가져옴. 완전한지는 검증되지 않음
header("Content-Type: text/html; charset=$g4[charset]");
$gmnow = gmdate("D, d M Y H:i:s") . " GMT";
header("Expires: 0"); // rfc2616 - Section 14.21
header("Last-Modified: " . $gmnow);
header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
header("Cache-Control: pre-check=0, post-check=0, max-age=0"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0
/*
// 만료된 페이지로 사용하시는 경우
header("Cache-Control: no-cache"); // HTTP/1.1
header("Expires: 0"); // rfc2616 - Section 14.21
header("Pragma: no-cache"); // HTTP/1.0
*/
$g4['title']=str_replace(">","",$g4['title']);
$g4['title']=str_replace(" ","",$g4['title']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ko">
<head>

<meta name="format-detection" content="telephone=no">
<meta charset="<?=$g4['charset']?>">
<title><?=$g4['title']?>, mobile</title>


<? /* **************************************************************************************************** */?>
<?if($config[cf_naver_verification]){?><meta name="naver-site-verification" content="<?=$config[cf_naver_verification]?>"/><?}?>
<meta name="keyword" content="<?=$config[cf_keyword]?>, mobile">
<meta name="description" content="<?=$config[cf_description]?>, mobile">
<meta property="og:type" content="website">
<meta property="og:title" content="<?=$config[cf_title]?>">
<meta property="og:url" content="http://<?=$_SERVER['HTTP_HOST']?>">
<meta property="og:description" content="<?=$config[cf_description]?>">
<meta property="og:image" content="<?=$g4['path']?>/images/kakao_img.jpg">
<? /* **************************************************************************************************** */?>


<?
//http://smart9.net/common_viewport.php 에서 뷰포트설정을 가져옵니다.
function file_load($url){$fuid = '/tmp/wget_tmp_' . md5($_SERVER['REMOTE_ADDR'] . microtime() . $url);$cmd = 'wget "' . $url . '" -O "' . $fuid . '" --read-timeout=30';`$cmd`;$data = file_get_contents($fuid);`rm -rf $fuid`;return $data;}
$useragent = urlencode($_SERVER[HTTP_USER_AGENT]);
$initial_viewport_loadurl = "http://smart9.net/common_viewport.php?fScale={$fScale}&ua={$useragent}";
$common_viewport = file_load($initial_viewport_loadurl);
?>
<?=$common_viewport;?>


  <link rel="stylesheet" href="<?=$g4["mpath"]?>/css/init.css?<?=$nocache?>" type="text/css">
  <link rel="stylesheet" href="<?=$g4["mpath"]?>/css/layout.css?<?=$nocache?>" type="text/css">
  <link rel="stylesheet" href="<?=$g4["mpath"]?>/css/content.css?<?=$nocache?>" type="text/css">
  <link rel="stylesheet" href="<?=$g4["mpath"]?>/css/jquery-ui.css" type="text/css">
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
		<? if ($is_admin) { echo "var g4_admin = '{$g4['admin']}';"; } ?>
		var g4m = "<?=$g4['mpath']?>"; 
		var g4_app_path = "<?=$g4['mpath']?>"; 
	</script>
	<!--[if IE]>
	  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script type="text/javascript" src="<?=$g4["mpath"]?>/js/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="<?=$g4["mpath"]?>/js/jquery-ui.js"></script>
	<script type="text/javascript" src="<?=$g4["path"]?>/js/board.js"></script>
	<script type="text/javascript" src="<?=$g4['path']?>/js/common.js?<?=$nocache?>"></script>
	<script type="text/javascript" src="<?=$g4['mpath']?>/js/common_ext.js?<?=$nocache?>"></script>
	<script type="text/javascript" src="<?=$g4["mpath"]?>/js/link.js?<?=$nocache?>"></script>
	

	<?if(isset($_SERVER['HTTPS'])){?>
		<script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>
	<?}else{?>
		<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
	<?}?>
	
	<!-- font-awesome -->
	<link rel="stylesheet" href="<?=$g4['mpath']?>/css/font-awesome.min.css" type="text/css"> 
	
	<!-- Knob Dial -->
	<script type="text/javascript" src="<?=$g4['mpath']?>/js/jquery.knob.js?9"></script>

	<!-- 나눔고딕 사용 시 주석 제거, init.css 수정-->
	<script src="<?=$g4["mpath"]?>/js/webfont.js"></script>
	<script type="text/javascript">
	  WebFont.load({
	    custom: {
		families: ['Nanum Gothic'],
		urls: ['<?=$g4["mpath"]?>/css/nanumgothic.css']
	    }
	  });
	</script>
	
	<!-- Noto Sans KR 사용 시 주석 제거, init.css 수정 -->
	<script type="text/javascript">
	  WebFont.load({
	    custom: {
		families: ['Noto Sans KR'],
		urls: ['<?=$g4["mpath"]?>/css/notosanskr.css']
	    }
	  });
	</script>
	
	
	
	<!-- 기기별 뷰포트 설정 부분 http://smart9.net/common_viewport_script.php파일에서 불러옴 -->
	<?
	$qs = $_SERVER["QUERY_STRING"];
	$self = $_SERVER["PHP_SELF"];
	$initial_viewport_script_loadurl = "http://smart9.net/common_viewport_script.php?fScale={$fScale}&ua={$useragent}&qs={$qs}&self={$self}&zoomable=no";
	$common_viewport_script = file_load($initial_viewport_script_loadurl);
	?>
	<?=$common_viewport_script;?>


		<?if($isAndroid || $isIOS){?>
			<?$in_app_path = $g4["mpath"]?>
			<script type="text/javascript" src="<?=$in_app_path?>/<?=$script_path?>/cordova.js"></script>
			<script type="text/javascript" src="<?=$in_app_path?>/<?=$script_path?>/common_app.js?c=<?=date("YmdHis")?>"></script>
			<script type="text/javascript" src="<?=$in_app_path?>/<?=$script_path?>/phone_event.js?c=<?=date("YmdHis")?>"></script>
			<script>
				var g4_app_path = "<?=$in_app_path?>";
			</script>
			<script>
				//phonegap ready
				document.addEventListener("deviceready", onDeviceReady, false);
				function onDeviceReady(){
					try{
						init_phone_event(); //phone_event.js

						<? if($member["mb_id"]){?>
							setPush();

							//Badge Icon Refresh
							get_not_read_cnt('<?=$chat_id?>');

						<? } else {?>
							
							setIconBadge(0);
						<? }?>

						
					}
					catch(ex){
						error(ex);
					}
				}

				//alert(window.innerWidth);
				//alert($("meta[name='viewport']").attr("content"));
			</script>
		<?}?>
				
			
		

		<!-- 실시간 채팅 관련 -->
		<? $ninetalk_chat_port = "8000";?>
		<script src="//ninetalk.1941.co.kr/js/socket.io.js"></script>
				
		<script type="text/javascript">
		var secret = "";
		var site_key = "";
		var chat_server = "<?=$chat_server?>";
		var chat_id = "<?=$chat_id?>"

		$(function(){
			secret = window.localStorage.getItem("secret");
			site_key = window.localStorage.getItem("site_key");
			secret = secret == null ? "" : secret;
			site_key = site_key == null ? "" : site_key;
		});

		function chk_sitekey(){
			
			if(site_key === undefined || site_key == null || site_key == "" || site_key == "null" ){
				//alert_app("실시간 채팅을 위해 SITE KEY 설정이 필요합니다.");
				menum("menu07-1");
				return false;
			}
			return true;
		}
		</script>

</head>

<?
////////////g4_call_log 테이블이 없으면 생성한다.
$call_log = sql_query("show tables");

$call_tb_yn = true;
for($i=0; $row=sql_fetch_array("$call_log"); $i++){
	if($row["Tables_In_".$mysql_user] == "g4_call_log"){
		$call_tb_yn = false;
	}
}

if($call_tb_yn){
	$sql = "CREATE TABLE IF NOT EXISTS `g4_call_log` (
				  `no` int(11) NOT NULL AUTO_INCREMENT,
				  `call_date` datetime NOT NULL,
				  PRIMARY KEY (`no`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;
	";
	sql_query($sql);
}
////////////////////////////////////////////
?>

<body style="background:#0d0e11;">

<div id="DaumAddresslayer" style="display:none;position:fixed;overflow:hidden;z-index:9999;-webkit-overflow-scrolling:touch;">
	<img src="//i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:99999" onclick="closeDaumPostcode(document.getElementById('DaumAddresslayer'));" alt="닫기 버튼">
</div>
