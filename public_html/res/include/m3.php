<style>

.m3 { width:100%; height:724px; position:relative; margin:0 auto; }

.m3_1 { position:relative; max-width:1280px; height:135px; background:#faf7f2; border-radius:15px 15px 0 0; margin:-135px auto 0; }
.m3_1_1 { padding:42px 0 0 42px; }
.m3_1_2 { position:absolute; color:#455d58; border-bottom:1px solid #455d58; padding-bottom:10px; left:226px; bottom:42px; font-size:16px; }
.m3_1_3 { color:#455d58; padding:15px 0 5px 42px; font-size:17px; }

.mg_arrow { position:absolute; width:251px; height:45px; z-index:3; bottom:0; right:10px; }
.mg_arrow:before { position:absolute; content:""; display:block; left:125px; top:16px; width:1px; height:22px; background:#d9d9d9;  }
 
.mg_arrow > div { position:absolute; width:98px; height:100%; top:17px; cursor:pointer; outline:none; }
.mg_arrow > div > img { position:absolute; transition:.2s linear; }

.mg_right { right:0; }
.mg_right > img { left:0; }
.mg_right:hover > img { left:10px; }

.mg_left { left:0; }
.mg_left > img { right:0; }
.mg_left:hover > img { right:10px; }

.mg_circle { position:absolute; width:40px; height:40px; border-radius:100%; border:2px solid #455d58; bottom:17px; opacity:0; transition:.2s all ease-out;}
.mg_right:hover .mg_circle { opacity:1; }
.mg_left:hover .mg_circle { opacity:1; }

.m3_2 { width:100%; min-width:1200px; max-width:1919px; background:#faf7f2; display:inline-block; }

</style>


<div class="m3 wow fadeIn" data-wow-delay="0.1s">
	<div class="m3_1">
	
		<img src="/res/images/mainvisual/gallery.png" alt="갤러리" class="m3_1_1"/>

		<a href="#menulink" onclick="menulink('menu05-2')"class="m3_1_2">READ MORE</a>
		<p class="m3_1_3">좋은 사람과 좋은 추억 건강한 추억을 남기세요.</p>


		<div class="mg_arrow">
			<div class="mg_right wow fadeInRight" data-wow-delay="0.3s">
				<img src="/res/images/mainvisual/m2_right.png" alt="메인비주얼 다음버튼">
				<div class="mg_circle" style="right:0px;"></div>
			</div>

			<div class="mg_left wow fadeInLeft" data-wow-delay="0.3s">
				<img src="/res/images/mainvisual/m2_left.png" alt="메인비주얼 이전버튼">
				<div class="mg_circle" style="left:0px;"></div>
			</div>
		</div>
	
	</div>

	<div class="m3_2">
		<?=latest("gallery", "5_2_1_1",  12, 35);?>
	</div>
</div>