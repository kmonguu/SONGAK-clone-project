<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<style>
#latistboxallgoodsuperbox2 {padding-top:12px; padding-left:22px;}
#latistboxallgoodsuperbox2 a:visited,#latistboxallgoodsuperbox2 a:link,#latistboxallgoodsuperbox2 a:active { color:#777777; text-decoration:none; }
#latistboxallgoodsuperbox2 a:hover { color:#777777; text-decoration:none; }
.dot {padding-left:6px; width:4px;height:17px;float:left; }
.lasubject2{width:351px; height:17px; float:left; color:#565656;}
.datetime2{width:103px;height:17px;float:right; color:#9c9c9c}
.latistboxallgood2 { line-height:46px; width:536px; height:23px; font-family:'Noto Sans KR'; font-size:20px; font-weight:300; padding-bottom:20px;}
.latistboxallgood2:last-child{border:0px;}
.latistboxallgood2 img{vertical-align:top;}
</style>
<div id="latistboxallgoodsuperbox2">
<?
$listco=count($list)-1;
?>
<? for ($i=0; $i<count($list); $i++) { ?>

<div class="latistboxallgood2">

	<div class="lasubject2">
		<a href="<?=$list[$i]['href']?>" style="cursor:pointer; color:#262626;">ㆍ<?=$list[$i]['subject']?></a>
	</div>
	<div class="datetime2">
	<?
		$dddtime=date("Y-m-d",strtotime($list[$i][wr_datetime]));
		echo ($dddtime);
	?>
	</div>

</div>
<? } ?>

<? if (count($list) == 0) { ?>게시물이 없습니다.<? } ?>
</div>