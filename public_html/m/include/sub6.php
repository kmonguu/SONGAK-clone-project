<style>
	.subMenu { position:relative; bottom:0; left:0; right:0; margin:0 auto; width:100%; height:80px; background:#222222; }
	.subMenu > ul { display:inline-block; width:100%; }
	.subMenu > ul > li { position:absolute; bottom:0; width:50%; float:left; line-height:80px; }
	.subMenu > ul > li > img { position:absolute; top:0; display:none; }
	.subMenu > ul > li > a { position:relative; display:inline-block; width:320px; text-align:center; color:#fff; font-size:22px; font-weight:500; }
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
	
	.tour_place { position:relative; width:1030px;  height:117px; padding-top:254px; margin-bottom:50px; text-align:center; }
	.tour_place > ul { display:inline-block; }
	.tour_place > ul > li { position:relative; float:left; text-align:center; width:117px; height:117px; margin-left:30px; background:#fff; border-radius:100%; cursor:pointer; }
	.tour_place > ul > li.on { background:#222222; color:#fff;}
	
	.tour_place > ul > li > div { padding-top:25px; }
	.tour_place > ul > li > div > span { font-size:22px; font-weight:500; line-height:30px; }
	.tour_place > ul > li > div > span:first-child { font-size:17px; line-height:17px; }
	.tour_place > ul > li:nth-last-child(-n+3) > div > span { line-height:25px; }
</style>

<div class="subMenu">
	<ul>
		<?foreach($menu["tot"][$pageNum] as $sn=>$snStr) {?>
			<li  <?=$tot == $pageNum."_".$sn ? "class='on'" : ""?>>
				<a href="#menum" onclick="menum('menu<?=sprintf("%02d", $pageNum)?>-<?=$sn?>')" ><?=$snStr?>
					<img src="/res/images/subvisual/sub6/sub6_arrow.png"/>
				</a>
				<img src="/res/images/subvisual/sub6/sub6_<?=$subNum?>_tab.png"/>
			</li>
		<?}?>
	</ul>
</div>

<div style="background:url('/m/images/subvisual/sub6/sub6_<?=$subNum?>_content.jpg') no-repeat center top; width:100%; ">
	<div style="width:100%; display:inline-block; overflow-x:auto; overflow-y:hidden;">
		<div class="tour_place">
			<ul>
				<?foreach($menu["tott"][$pageNum][$subNum] as $ssn=>$ssnStr){
					$ssnStr = str_replace(" ", "<br/>", $ssnStr);
				?>
					<li  onclick="menum('menu<?=sprintf("%02d", $pageNum)?>-<?=$subNum?>-<?=$ssn?>')" class="<?=$tott == $pageNum."_".$subNum."_".$ssn ? "on" : ""?> wow fadeInUp" data-wow-delay="<?=0.2*$ssn?>s">
						
						<div>
							<span>#<?=$ssn?></span><br/><span><?=$ssnStr?></span>
						</div>
					</li>
				<?}?>
			</ul>
		</div>
	</div>
	<img style="margin:0 auto 80px; display:block;" src="/m/images/subvisual/sub6/sub6_<?=$subNum?>/<?=$ssNum?>_1.jpg">
</div>