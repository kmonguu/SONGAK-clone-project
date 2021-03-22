<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<style>
.bg { position:relative; width:100%; background:#f7f7f7; color:#2f2f2f; text-align:center; padding:120px 0; }
.submit_btn { width:173px; height:47px; line-height:47px; color:#fff; border:0px; background:#373737; font-size:16px; display:inline-block; cursor:pointer; text-align:center; }
</style>

<div class="ShopCover" >

	<div class="bg">
		<p style="color:#7d7d7d; font-size:30px;">
			<span style="color:#000; font-weight:500;  "><?=$config['cf_title']?></span> 홈페이지의<br/>
			회원가입이 성공적으로 완료되었습니다.
		</p>
		
		<p style="color:#2f2f2f; font-size:14px; padding-top:10px;">
			회원탈퇴는 언제든지 가능하며 탈퇴 후 일정기간이 지나면 회원님의<br/>
			소중한 정보는 모두 삭제됩니다.
		</p>
	</div>

	<div style="margin-top:30px; text-align:center;">
		<span class="submit_btn" onclick="home()" >홈으로</span>
	</div>


	<?
	/** 네이버 프리미엄 로그 분석 전환페이지 설정 = 회원가입 */
	if($config["cf_use_naver_log"] && $config["cf_use_naver_log_reg"]){?>
		<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
		<script type="text/javascript"> 
			var _nasa={};
			_nasa["cnv"] = wcs.cnv("2","1");
		</script> 
	<?}?>

</div>


