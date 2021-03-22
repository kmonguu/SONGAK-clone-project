
<style>
.item_area2 { display:inline-block; width:100%; padding-bottom:20px; }
.item_area2 .item_list { width:<?=$img_width?>px !important; height:420px; position:relative; text-align:left; margin-left:24px; border:1px solid #d9d9d9; float:left; }
.item_area2 .item_list:first-child { margin-left:0; }
.item_area2 .item_list .item_thum { width:<?=$img_width?>px; height:<?=$img_height?>px; position:relative; }

.item_area2 .item_content { position:relative; width:100%; height:94px; box-sizing:border-box; padding:12px 15px 0 15px; text-align:center; }
.item_area2 .item_subj { position:relative; height:30px; line-height:30px; text-align:left; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; padding-bottom:10px; }
.item_area2 .item_subj > a { font-size:16px; color:#222; text-decoration:none; font-weight:400; }
.item_area2 .item_amount1 { position:relative; height:17px; line-height:17px; font-size:16px; color:#555; font-weight:400; }
.item_area2 .item_amount2 { position:relative; height:25px; line-height:25px; font-size:16px; color:#ff6565; font-weight:400; }

.item_area2 .con_btn { width:100%; height:41px; box-sizing:border-box; border-top:1px solid #d9d9d9; float:left; }
.item_area2 .con_btn div { width:50%; height:41px; float:left; cursor:pointer; }
.item_area2 .con_btn div:nth-child(1) { background:url('/res/images/wish.png') no-repeat center center, #fff; }
.item_area2 .con_btn div:nth-child(2) { background:url('/res/images/cart.png') no-repeat center center, #fff; box-sizing:border-box; border-left:1px solid #d9d9d9; }
.item_area2 .con_btn div:nth-child(1):hover { background:url('/res/images/wish.png') no-repeat center center, #f8f8f8; }
.item_area2 .con_btn div:nth-child(2):hover { background:url('/res/images/cart.png') no-repeat center center, #f8f8f8; }
</style>

<div class="item_area2" >
	<div class="">
		<? for ($i=0; $row=sql_fetch_array($result); $i++) { ?>			
			<div class="item_list">

					<a href="<?=$g4[shop_url]?>/item.php?it_id=<?=$row[it_id]?>" target="_self" style="display:inline-block;" >
						<div class='item_thum'>
							<div style="position:relative;" >
								<div style=" display:inline-block; position:absolute; right:0; top:10px; border-radius:4px;">
								

								<!-- ITEM YPTE ICON -->
								<?for($idx = 1 ; $idx <= 5; $idx++) {?>
									<?if($row["it_type{$idx}"]) {?>
										<div class="icon_item_type<?=$idx?>"><?=Yc4::$IT_TYPE[$idx]?></div>
									<?}?>
								<?}?>
				
								</div>
							</div>
							<?=get_image($row[it_id]."_s", $img_width, $img_height)?>
							<?//=get_it_image($row[it_id]."_s", $img_width, $img_height, $row[it_id])?>
						</div>
					</a>

					<div class="item_content" >

						<p class='item_subj'><a href="<?=$g4[shop_url]?>/item.php?it_id=<?=$row[it_id]?>" target="_self" style="display:inline-block;" ><?=$row[it_name]?></a></p>
						<?if ($row[it_cust_amount] && !$row[it_gallery]){?><?//갤러리 상품은 표시 안함?>
							<span class='item_amount1'>
									<?if( $row["it_cust_amount"] > get_amount($row)){?><strike style="color:#ff6565; font-weight:300;">
									<span style="color:#555; font-weight:400;"><?=display_amount($row["it_cust_amount"])?></span></strike><?}?>
							</span>
						<?}?>

						&nbsp;&nbsp;&nbsp;
						
						<span class='item_amount2'>
							<?if (!$row[it_gallery]){?><?//갤러리 상품은 표시 안함?>
								<?=display_amount(get_amount($row), $row[it_tel_inq])?>
							<?} else {?>
								<?=$row["it_tel_inq"] ? "전화문의" : ""?>
							<?}?>

						</span>

					</div>


					<? if (!$row[it_tel_inq] && !$row[it_gallery]) { ?><?//갤러리/전화문의 상품은 표시 안함?>
						<div class="con_btn">
								<div onclick="item_wish($(this).closest('form'), '<?=$row[it_id]?>')"></div>	
								<div onclick="open_fixed_layer('<?=$g4[shop_path]?>/item_popup.php?it_id=<?=$row[it_id]?>', 660)"></div>	
						</div>
					<?}?>
					
			</div>

		<? } ?>
	</div>

</div>





<script>
// 상품보관
function item_wish(fObj, it_id)
{
	jQuery.ajax({
		url : "<?=$g4[shop_path]?>/_ajaxAddWish.php?it_id="+it_id+"&mb_id=<?=$member["mb_id"]?>",
		success: function(data){
			alert(data.message);
		}
	});

}
</script>