<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>
<style>
.swiper_gallery { position:absolute; width:319px; height:390px; right:0; bottom:105px; }
.swiper_gallery .swiper-slide { position:relative; width:279px; height:100%; margin:0 auto; overflow:hidden; }

.basic {position:relative; width:270px; height:390px; background:#fff; border:1px solid #e4ded4; float:left; box-sizing:border-box; color:#777777 !important;  font-size:17px !important; font-weight:300 !important;}

.basic > div { width:100%; box-sizing:border-box; text-align:left; }
.basic > div:nth-child(1) { width:9px; height:9px; background:#e5e5e5; margin:30px 0 0 30px; border-radius:2px;}
.basic > div:nth-child(2) { line-height:29px; height:58px; padding:0 30px; margin-top:23px; font-size:21px; font-weight:400; color:#000;}
.basic > div:nth-child(3) { padding:0 30px; margin-top:19px; }
.basic > div:nth-child(4) { position:absolute; height:50px; bottom:0; left:0; border-top:1px solid #e4ded4; }
.basic > div:nth-child(4) > p { padding-left:30px; line-height:50px; } }
</style>

<div class="swiper-container swiper_gallery">
	<div class="swiper-wrapper">
	<? for ($i=0; $i<count($list); $i++) { ?> 
			<div class="swiper-slide">
				
				<div class="basic" onclick="location.href='<?=$list[$i][href]?>'">
					<div class="point_dat"></div>

					<div class="notice_title">
						<?=cut_str($list[$i][wr_subject],58, '...');?>
					</div>

					<div class="notice_content">
						<?=strip_tags(cut_str($list[$i][wr_content], 300, '...'));?>
					</div>

					<div class="notice_date">
						<p><?=date("Y.m.d",strtotime($list[$i][wr_datetime]));?></p>
					</div>
					<? if (count($list) == 0) { ?><font color=#6A6A6A>게시물이 없습니다.<? } ?>
				</div>
				
			</div>
		<? } ?>
	</div>
</div>

<script>

	var swiper_gallery = null;
	$(function(){
		swiper_gallery = new Swiper('.swiper_gallery', {
				spaceBetween: 18,
				centeredSlides: true,
				autoplay: {
					delay: 4000,
				},
				disableOnInteraction: false,
				effect:'slide',
				speed: 1000,
				loop:true,
				slidesPerView:'auto',
				observer:true,
				simulateTouch: false,
				on:{
					transitionStart:function(){ },
					transitionEnd:function(){
						this.autoplay.stop();
						this.autoplay.start();
					}
				},
		});
});
</script>