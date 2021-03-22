<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>
<ul>
			<?for ($i=0; $row=sql_fetch_array($result); $i++){?>
			<li>
				<span class="Thum">
					<div style="position:absolute; right:5px ; top:10px;">
						<!-- ITEM TYPE ICON -->
						<?for($idx = 1 ; $idx <= 5; $idx++) {?><?if($row["it_type{$idx}"]) {?><div class="icon_item_type<?=$idx?>"><?=Yc4::$IT_TYPE[$idx]?></div><?}?><?}?>
					</div>
					<a href="/m/shop/item.php?it_id=<?=$row[it_id]?>">
						<?=mget_it_image($row[it_id]."_l1", 250 , 275, $row[it_id])?>
					</a>
				</span>
				
					<div class="product_box">
						<div class="pro_info">
							<span class="Tit"><a href="/m/shop/item.php?it_id=<?=$row[it_id]?>"><?=$row[it_name]?></a></span>
							
							
								<span class="Price">
									<?if ($row[it_cust_amount] && !$row[it_gallery]){?><?//갤러리 상품은 표시 안함?>
									<span class='item_amount1'>
											<strike style="color:#ff6565; font-weight:300;"><span style="color:#555; font-weight:400;"><?=display_amount($row["it_cust_amount"])?></span></strike>
									</span>
									<?}?>
									<?if (!$row[it_gallery]){?><?//갤러리 상품은 표시 안함?>
										<?=display_amount(get_amount($row), $row[it_tel_inq])?>
									<?} else {?>
										<?=$row["it_tel_inq"] ? "전화문의" : ""?>
									<?}?>
								</span>
						</div>
						<? if (!$row[it_tel_inq] && !$row[it_gallery]) { ?><?//갤러리/전화문의 상품은 표시 안함?>
							<span class="Btn"  onclick="open_fixed_layer('<?=$g4[shop_path]?>/item_popup.php?it_id=<?=$row[it_id]?>', 620, {'isMobile':'Y'})"><img src="/m/images/main_Thum_cart.png" onclick="$(this).closest('form').submit()"/></span><!-- <a href="/m/shop/item.php?it_id=<?//=$row[it_id]?>"></a> -->
						<?}?>
					</div>

			</li>
			<? }?>
</ul>


