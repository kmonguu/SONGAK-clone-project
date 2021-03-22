<style>
.swiper-mainvisual { width:100%; min-width:1200px; max-width:1919px; height:1000px; position:relative; margin:0 auto; z-index:1; }
.swiper-mainvisual .swiper-slide { width:100%; min-width:1200px; max-width:1919px; height:1000px; position:relative; margin:0 auto; }
.swiper-mainvisual .swiper-slide > img { position:absolute; top:40%; left:25%; }

.more { position:absolute; z-index:3; border:2px solid #fff; padding:22px 72px; top:65%; left:43%; margin:0 auto; color:#fff; font-size:16px; font-weight:bold; transition:.3s all ease-out; }
.more:hover { background:#fff; color:#455d58; }

.miribogi { position:absolute; width:575px; height:70px; right:46px; bottom:125px; z-index:3; }
.miribogi > div { position:relative; width:110px; height:70px; float:left; margin-left:5px; }
.miribogi > div > img { display:block; width:100%; height:100%; cursor:pointer; box-shadow:3px 4px 5px 0 rgba(0,0,0,0.3); }
.miribogi > div > p { text-align:center; color:#fff; opacity:0.5; font-size:17px; width:100%; margin-top:26px; transition:.2s all ease-out; }

.miribogi_bar { position:absolute; width:575px; height:2px; right:46px; bottom:103px; background:rgba(255, 255, 255, 0.5); z-index:3; }
.miribogi_bar > div { width:0%; height:2px; background:#fff; }

.main_bottom { position:absolute; width:762px; height:120px; background:#fff; left:0; bottom:0; z-index:3; padding-left:80px; box-shadow:0px 0px 15px 0 rgba(0,0,0,0.3); }
.main_bottom span { color:#455d58; display:inline-block; padding-right:10px; } 

.more2 { position:absolute; width:180px; height:40px; border:2px solid #455d58; border-radius:80px; text-align:center; color:#455d58; font-size:16px; right:40px; top:33px; line-height:40px; }
.more2:hover { background:#455d58; color:#fff; transition:.2s all ease-out; }

</style>
<div class="fit">
	<div class="swiper-container swiper-mainvisual wow fadeIn" data-wow-delay="0s" >

		 <div class="swiper-wrapper">
			<?for($i=1; $i<=5; $i++){?>
				<div style="background:url('/res/images/mainvisual/<?=$i?>.jpg');width:100%;background-position:center center;" class="swiper-slide" >
					<img src="/res/images/mainvisual/<?=$i?>.png" alt="캐치1" class="cache"/>
				</div>
			<?}?>
		</div>

		<div class="more" onclick="menulink('menu01-1')" >Read More</div>
		
		<div class="miribogi wow fadeInRight" data-wow-delay="0.5s">
				<?for($i=1; $i<=5; $i++){?>
					<div>
						<img src="/res/images/mainvisual/<?=$i?>.jpg" alt="메인 이미지 미리보기" />
						<p>0<?=$i?></p>
					</div>
				<?}?>

		</div>

		<div class="miribogi_bar wow fadeInRight" data-wow-delay="0.5s">
			<div></div>
		</div>

		<div class="main_bottom wow fadeInLeft" data-wow-delay="1s">
			<div style="margin-top:35px;">
				<span style="font-size:17px; ">대표번호</span> <span style="font-size:18px; font-weight:800; ">064.792.3112 / 010.7124.3111</span><br>
				<span style="font-size:17px; ">영업시간</span> <span style="font-size:15px; ">09:00 A.M ~ 05:00 P.M</span>
				<div class="more2" onclick="menulink('menu01-1')">Read More</div>
			</div>
		</div>

		
	</div>

</div>

<script>
	function mainmove() {
		$(".miribogi_bar > div").stop().animate({"width":"+=110px"},5000,"linear");
	}

	var swiper_mainvisual = null;
	var slideindex=0;
	$(function(){
		mainmove();

		swiper_mainvisual = new Swiper('.swiper-mainvisual', {
						spaceBetween: 0,
						centeredSlides: true,
						autoplay: {
							delay: 5000,
						},
						disableOnInteraction: false,
						effect:'fade',
						speed: 2500,
						loop:true,
						slidesPerView:'auto',
						observer:true,
						simulateTouch: false,
						on:{
							transitionStart:function(){
								var index = this.realIndex;
								var cindex = this.realIndex+1;
								$(".miribogi > div > p").css("opacity","0.5");
								$(".miribogi > div").eq(index).find("p").css("opacity","1");
							
								
								if(slideindex != 0){
									$(".miribogi_bar > div").stop().animate({"width" : (115*index)+"px"},2000,function(){
										mainmove();
									});
								}
								
								slideindex++;
								
							},
							transitionEnd:function(){
								this.autoplay.stop();
								this.autoplay.start();
							},
							

						},
						navigation: {
							nextEl: '.navigation_next',
							prevEl: '.navigation_prev',
						}
					});
	});
	$(".miribogi > div > img").click(function(){
		var miriIndex = $(this).parent().index();
		swiper_mainvisual.slideTo(miriIndex+1, 2000, false);
	});

</script>

