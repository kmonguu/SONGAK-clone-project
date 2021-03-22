<script type="text/javascript" src="<?=$g4['path']?>/js/wrest.js"></script>

<iframe width="0" height="0" title="내부 연동 프레임" id="hiddenframe" name="hiddenframe" style="display:none;"></iframe>

<? if ($is_admin == "super") { ?><!-- run time : <?=get_microtime()-$begin_time;?>sec --><? } ?>



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


<?if($config["cf_kakao_key"]){?>
	<!-- 카카오 API -->
	<script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
	<script>
	// 사용할 앱의 Javascript 키를 설정해 주세요.
	Kakao.init('<?=$config["cf_kakao_key"]?>');
	</script>
<?}?>


<?include_once("{$g4["path"]}/res/include/fixed_layer_popup.php");?>
<?include_once("{$g4["path"]}/res/include/custom_alert.php");?>

</body>



</html>
<?
$tmp_sql = " select count(*) as cnt from $g4[login_table] where lo_ip = '$_SERVER[REMOTE_ADDR]' ";
$tmp_row = sql_fetch($tmp_sql);
//sql_query(" lock table $g4[login_table] write ", false);
if ($tmp_row['cnt'])
{
	$tmp_sql = " update $g4[login_table] set mb_id = '$member[mb_id]', lo_datetime = '$g4[time_ymdhis]', lo_location = '$lo_location', lo_url = '$lo_url' where lo_ip = '$_SERVER[REMOTE_ADDR]' ";
	sql_query($tmp_sql, FALSE);
}
else
{
	$tmp_sql = " insert into $g4[login_table] ( lo_ip, mb_id, lo_datetime, lo_location, lo_url ) values ( '$_SERVER[REMOTE_ADDR]', '$member[mb_id]', '$g4[time_ymdhis]', '$lo_location',  '$lo_url' ) ";
	sql_query($tmp_sql, FALSE);

	// 시간이 지난 접속은 삭제한다
	sql_query(" delete from $g4[login_table] where lo_datetime < '".date("Y-m-d H:i:s", $g4[server_time] - (60 * $config[cf_login_minutes]))."' ");

	// 부담(overhead)이 있다면 테이블 최적화
	//$row = sql_fetch(" SHOW TABLE STATUS FROM `$mysql_db` LIKE '$g4[login_table]' ");
	//if ($row['Data_free'] > 0) sql_query(" OPTIMIZE TABLE $g4[login_table] ");
}
//sql_query(" unlock tables ", false);
?>