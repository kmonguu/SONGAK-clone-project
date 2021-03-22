<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<style>
.latistboxallgoodsuperbox { padding:0px 0px 0px 0px; }
.latistboxallgoodsuperbox a:visited,.latistboxallgoodsuperbox a:link,.latistboxallgoodsuperbox a:active { color:#797979; text-decoration:none; }
.latistboxallgoodsuperbox a:hover { color:#797979; text-decoration:none; }

.dot { width:4px; height:100%; float:left; margin:0 4px 0 2px; background:url("/res/images/la_dot.jpg") no-repeat center center; }
.lasubject{ width:230px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; float:left; }
.datetime{ float:right; }
.latistboxallgood { width:100%; height:23px; line-height:23px; font-family:돋움; font-size:10pt; color:#797979; }
.latistboxallgood img{ vertical-align:top; }
</style>

<?
$listco=count($list)-1;
?>
<div class="latistboxallgoodsuperbox">
	<? for ($i=0; $i<count($list); $i++) { ?>
		<div class="latistboxallgood">

			<div class="dot"></div>

			<div class="lasubject">
				<a href="<?=$list[$i]['href']?>" ><?=$list[$i]['subject']?></a>
			</div>
			<div class="datetime">
			<?
				$dddtime=date("Y-m-d",strtotime($list[$i][wr_datetime]));
				echo ($dddtime);
			?>
			</div>

		</div>
	<? } ?>

	<? if (count($list) == 0) { ?>
		<div class="latistboxallgood">
			<div class="dot"></div>
			<div class="lasubject">
				게시물이 없습니다.
			</div>
		</div>
	<? } ?>
</div>