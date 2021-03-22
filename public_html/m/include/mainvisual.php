<style>

.swiper-mainvisual {margin:0 auto; width:100%; height:1020px; position:relative; left:0; top:0; right:0; z-index:1; overflow:hidden; }
.swiper-mainvisual .swiper-slide > img { position:absolute; top:40%; left:5%; }

.swiper-pagination {  width:100px !important; height:50px; position:absolute; left:540px !important; bottom:72px !important; background:rgba(0,0,0,.6); border-radius:25px 0 0 25px; box-sizing:border-box; padding-left:25px; line-height:50px; color:rgba(255,255,255,.8);font-size:22px; font-weight:500; }
.swiper-pagination .swiper-pagination-bullet { display:none; outline:none;}
.swiper-pagination .swiper-pagination-bullet-active { display:block; background:rgba(0,0,0,0); border-radius:0px !important; opacity:1; color:rgba(255,255,255,0.8); }

.more { position:absolute; z-index:3; border:2px solid #fff; padding:20px 68px; top:65%; left:33%; margin:0 auto; color:#fff; font-size:16px; font-weight:bold; }

</style>
	<div class="swiper-mainvisual-container swiper-mainvisual" >


		 <div class="swiper-wrapper">
			<?for($i=1; $i<=8; $i++){?>
				<div style="background:url('/m/images/mainvisual/<?=$i?>.jpg');width:100%;background-position:center center;" class="swiper-slide" >
					<img src="/m/images/mainvisual/catch/<?=$i?>.png" alt="캐치"/>
				</div>
			<?}?>
		</div>

		<div class="more" onclick="menum('menu01-1')" >Read More</div>
		
		
		<div class="swiper-pagination"></div>
	</div>

<script>

	window.onload = function(){
	var swiper_mainvisual = null;

	$(function(){

		swiper_mainvisual = new Swiper('.swiper-mainvisual', {
						spaceBetween: 0,
						centeredSlides: true,
						autoplay: {
							delay: 4000,
						},
						disableOnInteraction: false,
						effect:'fade',
						speed: 1000,
						loop:true,
						loopAdditionalSlides:1,
						loopedSlides:1,
						slidesPerView:'auto',
						observer:true,
						simulateTouch: false,
						on:{
						transitionEnd:function(){
							this.autoplay.stop();
							this.autoplay.start();
							}
						},
						touchRatio:0,
						pagination: {
							el: '.swiper-pagination',
							type: 'bullets',
							bulletElement: 'span',
							clickable: 'false',
							renderBullet: function (index, className) {
								return '<span class="' + className + '">' + (index + 1) + '&nbsp;/&nbsp;8</span>';
							 },
						 },
						
						
						
					});


		

	});
	}

</script>

