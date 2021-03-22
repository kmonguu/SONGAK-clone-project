<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>
<style type="text/css">
#item_list_div { width:540px; margin:0 auto; }
#item_list_div ul { list-style:none; padding:0; margin:0; margin-top:20px; }
#item_list_div ul li { float:left; width:250px; height:365px; margin:0 0 30px 40px;  }
#item_list_div ul li:nth-child(2n+1) { margin-left:0; }
#item_list_div ul li a, strike, span {font-size:16px; color:#000; }
#item_list_div ul > li > div > img {margin-left:5px;margin-top:8px;}

.text_cover { width:100%; height:90px; box-sizing:border-box; padding:22px 0 0 10px; position:relative; }
.Thing_box { width:180px; height:100%; text-align:left; }
.Thing_cart { position:absolute; right:10px; top:25px; }
</style>
<div id="item_list_div">
	<ul>
		<?
		for ($i=0; $row=sql_fetch_array($result); $i++){
			
			$href="<a href='$g4[shop_mpath]/item.php?it_id=$row[it_id]'>";
			?>
			
			<li class="thing_list">
				<form name="cartform" action="<?=$g4[mpath]?>/shop/cartupdate.php" method="post">
					<input type="hidden" name="it_id" value="<?=$row["it_id"]?>"/>
					<input type="hidden" name="ct_qty" value="1"/>
					<input type="hidden" name="it_amount" value="<?=get_amount($row)?>"/>
					<input type="hidden" name="it_point" value="<?=$row["it_point"]?>"/>
					<input type="hidden" name="ct_qty" value="1"/>
				<div style="position:relative; width:<?=$img_width?>px;">
						<?=mget_it_image($row[it_id]."_s", $img_width , $img_height, $row[it_id])?>
						<div style="position:absolute; right:5px ; top:10px;">
							<!-- ITEM TYPE ICON -->
							<?for($idx = 1 ; $idx <= 5; $idx++) {?><?if($row["it_type{$idx}"]) {?><div class="icon_item_type<?=$idx?>"><?=Yc4::$IT_TYPE[$idx]?></div><?}?><?}?>
						</div>
				</div>
				<div class="text_cover">
					<div class="Thing_box">
						<div><?=$href?><?=stripslashes($row[it_name])?></a></div>
						<?if ($row[it_cust_amount] && !$row[it_gallery]){?><?//갤러리 상품은 표시 안함?>
							<div><strike><?=display_amount($row[it_cust_amount])?></strike></div>
						<?}?>
					
						<div>
							<span class=amount>
								<?if(!$row[it_gallery]){?><?//갤러리 상품은 표시 안함?>
									<?=display_amount(get_amount($row), $row[it_tel_inq])?>
								<?} else {?>
									<?=$row["it_tel_inq"] ? "전화문의" : ""?>
								<?}?>
							</span>
						</div>
						</div>
						<? if (!$row[it_tel_inq] && !$row[it_gallery]) { ?><?//갤러리/전화문의 상품은 표시 안함?>
						<span class="Thing_cart"><img src="/m/images/main_Thum_cart.png" onclick="open_fixed_layer('<?=$g4[shop_path]?>/item_popup.php?it_id=<?=$row[it_id]?>', 620, {'isMobile':'Y'})"/></span>
						<?}?>
				</div>
				</form>
			</li>
			
		<?}?>
	</ul>
	<div style="clear:both;"></div>
</div>
