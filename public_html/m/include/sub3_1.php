<style>
.swiper-msub3 { background:url('/m/images/subvisual/sub3/1-1.jpg') no-repeat center top; position:relative; width:100%; min-width:586px; max-width:640px; height:601px; text-align:center; padding-top:440px; }
.swiper-msub3 .swiper-slide { position:relative; width:586px; height:480px; box-shadow:5px 5px 10px 0px rgba(0,0,0,.4);}

.s_arrow { position:absolute; width:175px; height:45px; z-index:3; top:135px; right:50px;}
.s_arrow:before { position:absolute; content:""; display:block; left:88px; top:-4px; width:1px; height:22px; background:#d9d9d9;  }
.s_arrow img { position:absolute; }

.swiper-pagination { position:relative; width:410px !important; height:3px; background:#d5d7d2; margin:0 auto; bottom:70px !important;}
.swiper-pagination .swiper-pagination-bullet {  float:left; width:51.25px; border-radius:0; height:3px; margin:0px !important; transition:.2s all ease-out; }
.swiper-pagination .swiper-pagination-bullet-active { background:#3f5651; }

</style>
<div class="swiper-container swiper-msub3" >
	<div class="swiper-wrapper">
		<?for($i=1; $i<=8; $i++){?>
			<div style="background:url('/m/images/subvisual/sub3/cafe/<?=$i?>.jpg');background-position:center center;" class="swiper-slide" >
			</div>
		<?}?>
	</div>
	<div class="swiper-pagination"></div>

	<div class="s_arrow">
		<img class="m_right" src="/res/images/subvisual/sub3/s_right.png" alt="메인비주얼 다음버튼" style="right:0; outline:none;">
		<img class="m_left" src="/res/images/subvisual/sub3/s_left.png" alt="메인비주얼 이전버튼" style="left:0; outline:none;">
	</div>
</div>



<script>

	var swiper_gallery = null;
	$(function(){
		swiper_gallery = new Swiper('.swiper-msub3', {
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
				nextEl: '.m_right',
				prevEl: '.m_left',
			},
			pagination: {
			el: '.swiper-pagination',
			type: 'bullets',
			},

		});
	});
</script>