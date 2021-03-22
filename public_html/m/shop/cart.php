<?
include_once("./_common.php");

$pageNum='100';
$subNum='4';

$g4[title] = "장바구니";
include_once("./_head.php");
?>


<div class="ShopCover">

<?
$s_page = 'cart.php';
$s_on_uid = get_session('ss_on_uid');
include "$g4[shop_mpath]/cartsub.inc.php";
?>





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