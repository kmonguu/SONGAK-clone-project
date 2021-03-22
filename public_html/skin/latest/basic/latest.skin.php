<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>

<style>

.notice {position:relative; width:270px; height:290px; background:#fff; border:1px solid #e4ded4; transition:.3s all ease-out; float:left; margin-left:20px; box-sizing:border-box; color:#777777 !important;  font-size:17px !important; font-weight:300 !important;}
.notice > div { overflow:hidden; text-overflow:ellipsis; white-space:normal; word-wrap:break-word; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; word-break:break-all; }
.notice:hover { border:1px solid #4e7169; box-shadow:5px 10px 10px 0px rgba(0,0,0,0.3); }

.point_dat { width:9px; height:9px; margin:30px 0 0 30px; border-radius:2px; transition:.3s all ease-out; background:#e5e5e5; }
.notice:hover .point_dat { background:#384d48; }

.notice_title { line-height:29px; height:58px; padding:0 30px; margin-top:23px; text-align:left; font-size:21px; font-weight:400; color:#000; }

.notice_content {  padding:0 30px; margin-top:19px; text-align:left; }

.notice_date { position:absolute; width:100%; height:50px; bottom:0; left:0; border-top:1px solid #e4ded4; }
.notice_date > p { padding-left:30px; line-height:50px; }



</style>

<? for ($i=0; $i<3; $i++) { 
	$m1_delay1 = 0.3 + $i/10*3;
	$m1_delay2 = 0.36 + $i/10*3;
	$cnt = 0;
?>

	<div class="notice wow fadeInUp" data-wow-delay="<?=$m1_delay1?>s" onclick="location.href='<?=$list[$i][href]?>'">
		<div class="point_dat wow fadeInUp" data-wow-delay="<?=$m1_delay2?>s"></div>

		<div class="notice_title wow fadeInUp" data-wow-delay="<?=$m1_delay2+0.06*(++$cnt)?>s">
			<?=cut_str($list[$i][wr_subject],58, '...');?>
		</div>

		<div class="notice_content wow fadeInUp" data-wow-delay="<?=$m1_delay2+0.06*(++$cnt)?>s">
			<?=strip_tags(cut_str($list[$i][wr_content], 300, '...'));?>
		</div>

		<div class="notice_date wow fadeInUp" data-wow-delay="<?=$m1_delay2+0.06*(++$cnt)?>s">
			<p><?=date("Y.m.d",strtotime($list[$i][wr_datetime]));?></p>
		</div>
		<? if (count($list) == 0) { ?><font color=#6A6A6A>게시물이 없습니다.<? } ?>
	</div>
<? } ?>