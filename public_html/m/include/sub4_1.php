<style>
.swiper-msub4 { background:url('/m/images/subvisual/sub4/1-2.jpg') no-repeat center top; position:relative; width:100%; min-width:586px; max-width:640px; height:540px; text-align:center; padding-top:173px; }
.swiper-msub4 .swiper-slide { position:relative; width:586px; height:480px; box-shadow:5px 5px 10px 0px rgba(0,0,0,.4);}

.s4_arrow { position:absolute; width:586px; height:70px; z-index:3; top:86px; right:0; left:0; margin:0 auto;  }
.s4_arrow img { position:absolute; }
</style>

<div style="background:url('/m/images/subvisual/sub4/1-1.jpg') no-repeat center top; width:100%; height:2566px;"></div>
<div class="swiper-container swiper-msub4" >
	<div class="swiper-wrapper">
		<?for($i=1; $i<=4; $i++){?>
			<div style="background:url('/m/images/subvisual/sub4/<?=$i?>.jpg');background-position:center center;" class="swiper-slide" >
			</div>
		<?}?>
	</div>

	<div class="s4_arrow">
		<img class="m4_right" src="/res/images/subvisual/sub4/s4_rightoff.jpg" alt="메인비주얼 다음버튼" style="right:0; outline:none;">
		<img class="m4_left" src="/res/images/subvisual/sub4/s4_leftoff.jpg" alt="메인비주얼 이전버튼" style="left:0; outline:none;">
	</div>
</div>



<script>

	var swiper_gallery = null;
	$(function(){
		swiper_gallery = new Swiper('.swiper-msub4', {
			spaceBetween: 70,
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
			simulateTouch: true,
			on:{
				transitionStart:function(){ },
				transitionEnd:function(){
					this.autoplay.stop();
					this.autoplay.start();
				}
			},
			navigation: {
				nextEl: '.m4_right',
				prevEl: '.m4_left',
			},
			pagination: {
			el: '.swiper-pagination',
			type: 'bullets',
			},

		});
	});
</script>