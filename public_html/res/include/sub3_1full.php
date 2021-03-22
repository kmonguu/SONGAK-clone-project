<style>
.sub3_div1 { width:100%; height:1000px; }
.sub3_div1 > div > img { position:absolute; top:50%; left:485px; }

.swiper-sub3 { background:url('/res/images/subvisual/sub3/sub3_content.jpg') no-repeat center top; position:relative; width:100%; min-width:1200px; max-width:1919px; height:700px; margin:0 auto; padding-top:376px; }
.swiper-sub3 .swiper-slide { width:900px; height:480px; position:relative;  }
.swiper-sub3 .swiper-slide .black_cover { width:100%; height:100%; background:rgba(0,0,0,.5); }
.swiper-sub3 .swiper-slide-active { box-shadow:5px 10px 10px 0 rgba(0,0,0,.3); }
.swiper-sub3 .swiper-slide-active .black_cover { display:none; } 

.swiper-pagination { position:relative; width:440px !important; height:2px; background:#d5d7d2; margin:0 auto; bottom:160px !important;}
.swiper-pagination .swiper-pagination-bullet { float:left; width:55px; border-radius:0; height:2px; margin:0px !important; transition:.2s all ease-out; }
.swiper-pagination .swiper-pagination-bullet-active { background:#000; }


.s_arrow { position:absolute; width:251px; height:45px; z-index:3; top:318px; right:360px; }
.s_arrow:before { position:absolute; content:""; display:block; left:125px; top:16px; width:1px; height:22px; background:#d9d9d9;  }
 
.s_arrow > div { position:absolute; width:98px; height:100%; top:17px; cursor:pointer; outline:none; }
.s_arrow > div > img { position:absolute; transition:.2s linear; }

.s_right { right:0; }
.s_right > img { left:0; }
.s_right:hover > img { left:10px; }

.s_left { left:0; }
.s_left > img { right:0; }
.s_left:hover > img { right:10px; }

.s_circle { position:absolute; width:40px; height:40px; border-radius:100%; border:2px solid #fff; bottom:17px; opacity:0; transition:.2s all ease-out;}
.s_right:hover .s_circle { opacity:1; }
.s_left:hover .s_circle { opacity:1; }

</style>
<div class="fit">
	<div class="sub3_div1 parallax-window" data-parallax="scroll" data-image-src="/res/images/subvisual/sub3/s3.jpg">
		<div style ="width:1200px; height:100%; margin:0 auto; position:relative;">
			<img src="/res/images/subvisual/sub3/sub3_title.png" />
		</div>
	</div>
</div>

<div class="swiper-container swiper-sub3" >

	<div class="s_arrow">
		<div class="s_right wow fadeInRight" data-wow-delay="0.3s">
			<img src="/res/images/subvisual/sub3/s_right.png" alt="메인비주얼 다음버튼">
			<div class="s_circle" style="right:0px;"></div>
		</div>

		<div class="s_left wow fadeInLeft" data-wow-delay="0.3s">
			<img src="/res/images/subvisual/sub3/s_left.png" alt="메인비주얼 이전버튼">
			<div class="s_circle" style="left:0px;"></div>
		</div>
	</div>

	 <div class="swiper-wrapper">
		<?for($i=1; $i<=8; $i++){?>
			<div style="background:url('/res/images/subvisual/sub3/<?=$i?>.jpg');background-position:center center;" class="swiper-slide" >
				<div class="black_cover"></div>
			</div>
		<?}?>
	</div>
	<div class="swiper-pagination"></div>

</div>

<script>

	var swiper_gallery = null;
	$(function(){
		swiper_gallery = new Swiper('.swiper-sub3', {
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
			simulateTouch: false,
			on:{
				transitionStart:function(){ },
				transitionEnd:function(){
					this.autoplay.stop();
					this.autoplay.start();
				}
			},
			navigation: {
				nextEl: '.s_right',
				prevEl: '.s_left',
			},
			pagination: {
			el: '.swiper-pagination',
			type: 'bullets',
			},

		});
	});
</script>