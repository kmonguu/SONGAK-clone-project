<style>
	.sub6_div1 { width:100%; height:1000px; }
	.sub6_div1 > div > img { position:absolute; top:26%; left:272px; }

	.subMenu { position:relative; bottom:100px; left:0; right:0; margin:0 auto; width:100%; height:100px; background:#222222; }
	.subMenu > ul { display:inline-block; width:100%; }
	.subMenu > ul > li { position:absolute; bottom:0; width:50%; float:left; line-height:100px; }
	.subMenu > ul > li > img { position:absolute; top:0; display:none; }
	.subMenu > ul > li > a { position:relative; display:inline-block; width:600px; text-align:center; color:#fff; font-size:22px; font-weight:500; }
	.subMenu > ul > li > a > img { position:absolute; left:50%; transform:translateX(-50%); bottom:15px; display:none; }

	.subMenu > ul > li:first-child { left:0; }
	.subMenu > ul > li:first-child > img { right:-13px; }
	.subMenu > ul > li:first-child > a { float:right; }
	.subMenu > ul > li:first-child.on { padding-top:15px; background:#1b98db; }
	.subMenu > ul > li:first-child.on > img,
	.subMenu > ul > li:first-child.on > a > img { display:block; }

	.subMenu > ul > li:last-child { right:0; }
	.subMenu > ul > li:last-child > img { left:-13px; }
	.subMenu > ul > li:last-child > a { float:left; }
	.subMenu > ul > li:last-child.on { padding-top:15px; background:#f6494f;}
	.subMenu > ul > li:last-child.on > img,
	.subMenu > ul > li:last-child.on > a > img { display:block; }

	.tour_place { position:relative; width:100%;  height:117px; margin-bottom:58px; text-align:center; }
	.tour_place > ul { display:inline-block; }
	.tour_place > ul > li { position:relative; float:left; text-align:center; width:117px; height:117px; margin-left:30px; background:#fff; border-radius:100%; cursor:pointer; }
	.tour_place > ul > li.on { background:#222222; color:#fff;}
	
	.tour_place > ul > li > div { padding-top:20px; }
	.tour_place > ul > li > div > span { font-size:22px; font-weight:500; line-height:25px; }
	.tour_place > ul > li > div > span:first-child { font-size:17px; line-height:15px; }
	.tour_place > ul > li:nth-last-child(-n+3) > div > span { line-height:20px; }


</style>
<div class="fit">
	<div class="sub6_div1 parallax-window" data-parallax="scroll" data-image-src="/res/images/subvisual/sub6/<?=$subNum?>.jpg">
		<div style ="width:1200px; height:100%; margin:0 auto; position:relative;">
			<img src="/res/images/subvisual/sub6/sub6_<?=$subNum?>_title.png" />
		</div>
		<div class="subMenu">
			<ul>
				<?foreach($menu["tot"][$pageNum] as $sn=>$snStr) {?>
					<li  <?=$tot == $pageNum."_".$sn ? "class='on'" : ""?>>
						<a href="#menulink" onclick="menulink('menu<?=sprintf("%02d", $pageNum)?>-<?=$sn?>')" ><?=$snStr?>
							<img src="/res/images/subvisual/sub6/sub6_arrow.png"/>
						</a>
						<img src="/res/images/subvisual/sub6/sub6_<?=$subNum?>_tab.png"/>
					</li>
				<?}?>
			</ul>
		</div>
	</div>
</div>

<div style="background:url('/res/images/subvisual/sub6/sub6_<?=$subNum?>_content.jpg') no-repeat center top; height:1200px; width:100%;">
	<div style="position:relative; padding-top:186px; width:1200px; margin:0 auto; ">
		<div class="tour_place">
			<ul>
				<?foreach($menu["tott"][$pageNum][$subNum] as $ssn=>$ssnStr){
					$ssnStr = str_replace(" ", "<br/>", $ssnStr);
				?>
					<li  onclick="menulink('menu<?=sprintf("%02d", $pageNum)?>-<?=$subNum?>-<?=$ssn?>')" class="<?=$tott == $pageNum."_".$subNum."_".$ssn ? "on" : ""?> wow fadeInUp" data-wow-delay="<?=0.2*$ssn?>s">
						
						<div>
							<span>#<?=$ssn?></span><br/><span><?=$ssnStr?></span>
						</div>
					</li>
				<?}?>
			</ul>
		</div>
		<? include_once("$g4[path]/res/include/sub6_tab.php"); ?>
	</div>
</div>