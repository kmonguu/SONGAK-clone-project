<?
include_once("./_common.php");

if(USE_MOBILE) { //config.php
	if($default["de_npay_use"]){ //네이버페이 사용 시
		//모바일로 장바구니 확인시, 모바일 장바구니로 이동
		$arr_browser = array ("iPhone","iPod","IEMobile","Mobile","lgtelecom","PPC","iphone","ipod","android","blackberry","windows ce","nokia","webos","opera mini","sonyericsson","opera mobi","iemobile");
		for($indexi = 0 ; $indexi < count($arr_browser) ; $indexi++) {
			if(stripos($_SERVER['HTTP_USER_AGENT'],$arr_browser[$indexi]) == true){
				if($_SERVER["QUERY_STRING"]!=''){$param ="?".$_SERVER["QUERY_STRING"];}else{$param = '';}
				header("Location: http://{$_SERVER["HTTP_HOST"]}/m{$_SERVER["PHP_SELF"]}{$param}");
				exit;
			}
		}
	}
}





$pageNum='100';
$subNum='4';

$g4[title] = "장바구니";
include_once("./_head.php");
?>


<div class="ShopCover" >

<?
$s_page = 'cart.php';
$s_on_uid = get_session('ss_on_uid');
include "$g4[shop_path]/cartsub.inc.php";
?>

<br><br>


<?if($_REQUEST["ctu"] == md5(date("YmdHi"))) {?>
	<?
	/** 네이버 프리미엄 로그 분석 전환페이지 설정 = 장바구니 */
	if($config["cf_use_naver_log"] && $config["cf_use_naver_log_cart"]){?>
		<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
		<script type="text/javascript"> 
			var _nasa={};
			_nasa["cnv"] = wcs.cnv("3","1");
		</script> 
	<?}?>
<?}?>



</div>


<?
include_once("./_tail.php");
?>