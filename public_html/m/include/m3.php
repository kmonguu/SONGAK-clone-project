<style>
.m3 { position:relative; height:520px; width:100%; background:#faf7f2; }
.m3 > div:first-child {position:absolute;width:600px;height:123px; margin:0 auto; left:0; right:0; top:0; margin-top:-123px; background:#faf7f2; border-radius:15px 15px 0 0; box-sizing:border-box; padding-left:40px; padding-top:14px; }
.m3 > div > span { color:#455d58; font-weight:500; z-index:3; font-size:20px;}
.m3 > div > span:nth-child(2) { border-bottom:2px solid #455d58; padding-bottom:5px; margin-left:40px; }
.m3 > div > img { padding:0 10px; outline:none;}
</style>

<div class="m3">
	<div>
		<span style="font-size:50px; font-family:'Lora';">Gallery</span><span onclick="menum('menu05-2')">READ MORE</span><br/>
		<span style="font-weight:400; padding:3px 35px 0 0; line-height:60px; ">좋은 사람과 좋은 추억 건강한 추억을 남기세요.</span>
		<img src="/m/images/mainvisual/mobile_left.png" class="gallery_left"/>
		<img src="/m/images/mainvisual/mobile_right.png" class="gallery_right" />
	</div>
	<div>
		<?=latestm ("gallery", "5_2_1_1", 12, 38); ?>
	</div>
</div>