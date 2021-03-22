<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<style type="text/css">
.latistboxallgoodsuperbox { }

.latistboxallgood1 a:visited, .latistboxallgood1 a:link, .latistboxallgood1 a:active { color:#000000; text-decoration:none; }
.latistboxallgood1 a:hover { color:#000000; text-decoration:none; }
.latistboxallgood1 { width:588px; height:62px; line-height:62px; font-size:20px; }
.dot1 { float:left; width:30px; height:62px; display:inline-block; margin-right:5px; background:url("/app/images/new_icon.jpg") no-repeat center center; }
.dot1 img { margin-top:1px; vertical-align:middle; display:table-cell; }
.lasubject1 { width:380px; height:62px; float:left; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.datetime1 { height:62px; float:right; color:#000000; }

</style>
<div class="latistboxallgoodsuperbox">
	<?
	$listco=count($list)-1;
	?>
	<? for ($i=0; $i<count($list); $i++) { ?>
		
		<div class="latistboxallgood1">
			<div class="dot1">
				<!-- <img src="/app/images/new_icon.jpg" alt="최근게시글 New 아이콘" /> -->
			</div>
			<div class="lasubject1">
				<a href="<?=$list[$i]['href']?>" ><?=$list[$i]['subject']?></a>
			</div>
			<div class="datetime1">
			<?
				$dddtime=date("Y-m-d",strtotime($list[$i][wr_datetime]));
				echo ($dddtime);
			?>
			</div>
		</div>

	<? } ?>

	<? if (count($list) == 0) { ?>
		<div class="latistboxallgood1" style="padding-bottom:0px; border-bottom:0px; margin-bottom:0px;">
			<div class="lasubject">
				게시물이 없습니다.
			</div>
		</div>
	<? } ?>
</div>