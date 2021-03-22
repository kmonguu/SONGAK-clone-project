<?
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

$begin_time = get_microtime();

if (!$g4['title'])
    $g4['title'] = $config['cf_title'];

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
?>
<!-- <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"> -->
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?=$g4['charset']?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title><?=$g4['title']?></title>
<link rel="stylesheet" href="<?=$g4['path']?>/res/css/init.css" type="text/css">
<link rel="stylesheet" href="<?=$g4['path']?>/style.css" type="text/css">
<link rel="stylesheet" href="<?=$g4['path']?>/res/css/jquery-ui.css" type="text/css">
<link rel="stylesheet" href="<?=$g4['path']?>/res/css/content_admin.css" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
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
<? if ($is_admin) { echo "var g4_admin = '{$g4['admin']}';"; } ?>
</script>
<script type="text/javascript" src="<?=$g4['path']?>/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="<?=$g4['path']?>/js/jquery-ui.js?2"></script>
<?if(isset($_SERVER['HTTPS'])){?>
<script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>
<?}else{?>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<?}?>
<script type="text/javascript" src="<?=$g4['path']?>/js/common.js"></script>
<link rel="stylesheet" href="<?=$g4['path']?>/res/css/content_admin.css" type="text/css">
<script type="text/javascript" src="<?=$g4['path']?>/js/common_ext.js"></script>


<script type="text/javascript" src="<?=$g4['path']?>/js/velocity.js"></script>
<script type="text/javascript" src="<?=$g4['path']?>/js/velocity.ui.js"></script>

<!-- colorbox -->
<link rel="stylesheet" href="<?=$g4['path']?>/js/colorbox/colorbox.css" type="text/css">
<script type="text/javascript" src="<?=$g4['path']?>/js/colorbox/jquery.colorbox.js"></script>

<!-- tootipsy -->
<script type="text/javascript" src="<?=$g4['path']?>/js/tooltipsy.min.js"></script>



<script type="text/javascript">	
	<? $ninetalk_key = sql_fetch("SELECT site_key FROM ninetalk_site_key limit 0,1", false) ?>
	var ninetalk_site_key = "<?=$ninetalk_key["site_key"]?>";
</script>
<?if(isset($_SERVER['HTTPS'])){?>
	<script type="text/javascript" src="//ninetalk.1941.co.kr:13443/js/ninetalk_adm_ssl.js"></script>
<?}else{?>
	<script type="text/javascript" src="//ninetalk.1941.co.kr/js/ninetalk_adm.js"></script>
<?}?>



<script>
    function showLoading(){
        $("body").addClass("loading");
    }
    function closeLoading(){
        $("body").removeClass("loading");
    }
</script>
<style>
    .divLoading{display:none;}
    .loading .divLoading {display:block;}
</style>
<link rel="stylesheet" href="<?=$g4["path"]?>/res/css/loading.css" type="text/css">
<div class="divLoading" id="divLoading" style="position:fixed; top:40%; left:50%; margin-left:-100px; width:200px; height:200px; z-index:99999;">
    <div class="lds-css ng-scope"><div style="width:100%;height:100%" class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>
</div>
<div class="divLoading" id="divLoadingOverlay" style="position:fixed; top:0px; left:0px; height:100%; width:100%; z-index:99998; background:gray; opacity:0.3">
    &nbsp;
</div>




<body topmargin="0" leftmargin="0" <?=isset($g4['body_script']) ? $g4['body_script'] : "";?>>

<div id="DaumAddresslayer" style="display:none;position:fixed;overflow:hidden;z-index:9999;-webkit-overflow-scrolling:touch;">
<img src="//i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:99999" onclick="closeDaumPostcode(document.getElementById('DaumAddresslayer'));" alt="닫기 버튼">
</div>

<a name="g4_head"></a>