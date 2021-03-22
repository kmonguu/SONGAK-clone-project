<style>

.m2 { background:url('/res/images/mainvisual/m2_1.jpg') no-repeat center top; width:100%; height:790px;  }

.m2_1 { width:100%; height:90px; padding-top:128px; }
.m2_1 > p { color:#fff; font-weight:300; }
.m2_1_1 { font-size:25px; bottom:50px; }
.m2_1_2 { font-size:40px; bottom:0; }

.m2_2 { display:inline-block; margin-top:60px; }
.m2_2 > img { float:left; margin-left:63px; }
.m2_2 > img:first-child { margin-left:0; }
.m2_2 > img:nth-child(2) { margin-left:58px; }
.m2_2 > img:nth-child(3) { margin-left:56px; }

.m2_3 { position:relative; display:block; width:230px; height:60px; margin:0 auto; bottom:-57px; font-weight:500; font-size:16px; border:2px solid #fff; cursor:pointer; color:#fff; line-height:60px; text-align:center; }
.m2_3:hover { background:#fff; transition:.3s all ease-out; color:#4d5e5a; }


</style>

<div class="m2">
	<div style="width:1200px; margin:0 auto; position:relative; text-align:center;">
		<div class="m2_1">
			<p class="m2_1_1 wow fadeInUp" data-wow-delay="0.3s">제 2의 심장이라고도 말하는 우리의 발!</p>
			<p class="m2_1_2 wow fadeInUp" data-wow-delay="0.3s">이런 증상으로 고생하는 분들게 추천드립니다.</p>
		</div>

		<div class="m2_2">
			<?for($i=1; $i<=6; $i++) {
				$m2_delay = 0.4 + $i/10*2;
			?>
				<img class="wow fadeInUp" data-wow-delay="<?=$m2_delay?>s" src="/res/images/mainvisual/m2_<?=$i?>.png" alt="족욕의 효능"/>
		<?}?>
		</div>
	</div>
	
	<a class="m2_3 wow fadeInUp" data-wow-delay="0.3s" href="#menulink" onclick="menulink('menu02-1')">ReadMore</a>

</div>