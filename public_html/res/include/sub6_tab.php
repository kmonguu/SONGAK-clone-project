<? 
	$imgNumber = glob("$g4[path]/res/images/subvisual/sub6/sub6_2/$ssNum/*.jpg");
?>
<style>
	.swiper-sub6 { width:100%; height:600px; position:relative; margin: 0 auto; z-index:3; box-shadow:5px 10px 10px 0 rgba(0,0,0,.3); }
</style>

<div>
	<? if($subNum==2 && ($ssNum==1 || $ssNum==7)) {?>
		<div class="swiper-container swiper-sub6" >
			 <div class="swiper-wrapper">
				<?for($i=1; $i<=count($imgNumber); $i++){?>
					<div style="background:url('/res/images/subvisual/sub6/sub6_2/<?=$ssNum?>/<?=$i?>.jpg');width:100%; background-position:center center;" class="swiper-slide" ></div>
				<?}?>
			</div>
		</div>
	<?}else{?>
		<img src="/res/images/subvisual/sub6/sub6_<?=$subNum?>/<?=$ssNum?>_1.jpg">
	<?}?>
</div>

<script>

	var swiper_gallery = null;
	$(function(){
		swiper_gallery = new Swiper('.swiper-sub6', {
			spaceBetween: 0,
			centeredSlides: true,
			autoplay: {
				delay: 3000,
			},
			disableOnInteraction: false,
			effect:'fade',
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