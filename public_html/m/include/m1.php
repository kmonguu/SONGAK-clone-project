<style>
.main_Num { position:absolute; width:590px; height:120px; background:#fff; left:0; z-index:3; padding-left:40px; box-sizing:border-box; margin-top:-33px; box-shadow:0px 0px 15px 0 rgba(0,0,0,0.3); }
.main_Num > div > span { color:#455d58; display:inline-block; padding-right:10px; }
.main_Num > div:last-child { position:absolute; width:144px; height:40px; border:2px solid #455d58; border-radius:80px; text-align:center; color:#455d58; font-size:20px; right:0; margin-right:-33px; background:#fff; line-height:40px; top:40%; }

.notice { position:relative; height:390px; width:294px; text-align:center; top:200px; padding:80px 0 0 30px; box-sizing:border-box; }
.notice > p { color:#fff; font-size:18px; }
.notice > div { position:absolute; color:#fff; font-size:20px; border:2px solid #fff; width:200px; height:60px; line-height:60px; margin-left:34px; }
</style>

<div style="position:relative; width:100%; height:688px; background:url('/m/images/mainvisual/main_bg.jpg') no-repeat center top; ">
	<div class="main_Num">
		<div style="margin-top:25px; position:absolute; font-size:18px; ">
			대표번호&nbsp;&nbsp;&nbsp;<span style="font-size:20px; font-weight:600; ">064.792.3112 / 010.7124.3111</span><br/>
			영업시간&nbsp;&nbsp;&nbsp;<span style="font-size:20px; ">09:00 A.M ~ 05:00 P.M</span>
		</div>
		<div onclick="menum('menu01-1')">Read More</div>
	</div>
	<div class="notice">
		<p style="font-size:50px; font-family:'Lora';">Notice</p>
		<p>송악산 7족욕에서 알려드립니다.</p>
		<p style="opacity:.5; font-weight:100; padding:28px 85px; ">XXX</p>
		
		<div onclick="menum('menu05-1')">Read More</div>

	</div>
	<div>
		<?=latestm ("basic", "5_1_1_1", 12, 38); ?>
	</div>
</div>