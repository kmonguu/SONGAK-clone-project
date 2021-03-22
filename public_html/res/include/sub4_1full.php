<style>
.sub4_div1 { width:100%; height:1000px; }
.sub4_div1 > div > img { position:absolute; top:40%; left:320px; }

.swiper-sub4 { width:1230px; height:835px; margin:0 auto; padding-top:120px; }
.swiper-sub4 .swiper-slide { width:1200px; height:650px; position:relative; box-shadow:5px 10px 10px 0 rgba(0,0,0,.3); }
</style>
<div class="fit">
	<div class="sub4_div1 parallax-window" data-parallax="scroll" data-image-src="/res/images/subvisual/sub4/s4.jpg">
		<div style ="width:1200px; height:100%; margin:0 auto; position:relative;">
			<img src="/res/images/subvisual/sub4/sub4_title.png" />
		</div>
	</div>
</div>

<div style="background:url('/res/images/subvisual/sub4/sub4_content.jpg') no-repeat center top; height:1812px; "></div>

<div style=" background:url('/res/images/subvisual/sub4/sub4_content2.jpg') no-repeat center top; position:relative; width:100%; height:1035px;">
	<div class="swiper-container swiper-sub4" >
		<div style="width:1200px; height:70px; margin:0 auto; position:relative; top:-27px;">
			<img class="l" src="/res/images/subvisual/sub4/s4_leftoff.jpg" onmouseover="this.src='/res/images/subvisual/sub4/s4_left.jpg'" onmouseout="this.src='/res/images/subvisual/sub4/s4_leftoff.jpg'" style="outline:none;">
			<img class="r" src="/res/images/subvisual/sub4/s4_rightoff.jpg" onmouseover="this.src='/res/images/subvisual/sub4/s4_right.jpg'" onmouseout="this.src='/res/images/subvisual/sub4/s4_rightoff.jpg'" style="outline:none; float:right;">
		</div>

		 <div class="swiper-wrapper">
			<?for($i=1; $i<=4; $i++){?>
				<div style="background:url('/res/images/subvisual/sub4/<?=$i?>.jpg');background-position:center center;" class="swiper-slide" ></div>
			<?}?>
		</div>

	</div>

<script>

	var swiper_gallery = null;
	$(function(){
		swiper_gallery = new Swiper('.swiper-sub4', {
			spaceBetween: 30,
			centeredSlides: true,
			autoplay: {
				delay: 3000,
			},
			disableOnInteraction: false,
			effect:'slide',
			speed: 700,
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
			navigation: {
				nextEl: '.r',
				prevEl: '.l',
			},

		});
	});
</script>