	<script type="text/javascript" src="<?=$g4['path']?>/js/wrest.js"></script>


	
	<?if($config["cf_use_naver_log"] || $default["de_npay_use"]){
		$naver_common_key = $config["cf_naver_common_key"];
		$wcs_domain = str_replace("www.", "", $_SERVER["HTTP_HOST"]);
		?>
		<!-- 네이버 페이 공통 유입 스크립트 -->
		<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script> 
		<script type="text/javascript"> 
		if(!wcs_add) var wcs_add = {};
		wcs_add["wa"] = "<?=$naver_common_key?>";
		wcs.checkoutWhitelist = ["<?=$wcs_domain?>","www.<?=$wcs_domain?>"];
		wcs.inflow("<?=$wcs_domain?>");
		if (!_nasa) var _nasa={};
		wcs_do(_nasa);
		</script>
	<?}?>


	<?include_once("{$g4["path"]}/res/include/fixed_layer_popup.php");?>
	<?include_once("{$g4["path"]}/res/include/custom_alert.php");?>

</body>
</html>
