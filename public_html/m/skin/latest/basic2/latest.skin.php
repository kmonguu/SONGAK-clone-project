<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<style>
#latistboxallgoodsuperbox {padding-top:12px; padding-left:22px;}
#latistboxallgoodsuperbox a:visited,#latistboxallgoodsuperbox a:link,#latistboxallgoodsuperbox a:active { color:#777777; text-decoration:none; }
#latistboxallgoodsuperbox a:hover { color:#777777; text-decoration:none; }
.dot {padding-left:6px; width:4px;height:17px;float:left; }
.lasubject{width:351px; height:17px; float:left; color:#eeeeee;}
.datetime{width:103px;height:17px;float:right; color:#dbdbdb}
#latistboxallgoodsuperbox .latistboxallgood { line-height:20px; width:536px; height:23px; font-family:'Noto Sans KR'; font-size:20px; font-weight:300; padding-bottom:20px; }
#latistboxallgoodsuperbox .latistboxallgood:last-child {border:0px; }
.latistboxallgood img{vertical-align:top;}
</style>
<div id="latistboxallgoodsuperbox">
<?
$listco=count($list)-1;
?>
<? for ($i=0; $i<count($list); $i++) { ?>

<div class="latistboxallgood">

	<div class="lasubject">
		ㆍ<a href="<?=$list[$i]['href']?>" style="cursor:pointer; color:#fff;"><?=$list[$i]['subject']?></a>
	</div>
	<div class="datetime">
	<?
		$dddtime=date("Y-m-d",strtotime($list[$i][wr_datetime]));
		echo ($dddtime);
	?>
	</div>

</div>
<? } ?>

<? if (count($list) == 0) { ?>게시물이 없습니다.<? } ?>
</div>