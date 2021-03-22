<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>

<style type="text/css">
.item_area { display:inline-block; width:100%; }
.item_area .item_list { width:<?=$img_width?>px; height:372px; position:relative; text-align:left; border:1px solid #e4e4e4; float:left; margin-left:30px; margin-bottom:15px; }
.item_area .item_list:nth-child(4n+1) { margin-left:0; }
.item_list .item_thum { width:<?=$img_width?>px; height:<?=$img_height?>px; position:relative; }
.item_list .item_thum .item_black { width:<?=$img_width?>px; height:<?=$img_height?>px; position:absolute; left:0; top:0; display:none; background:rgba(0,0,0,0.6); } 
.item_list:hover .item_thum .item_black { display:inline-block; }

.item_content { position:relative; width:100%; height:118px; box-sizing:border-box; padding:12px 15px 0 15px; }
.item_subj { position:relative; height:30px; line-height:30px; font-size:17px; color:#000; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; font-weight:300; padding-bottom:10px; }
.item_subj > a { font-size:17px; color:#000; text-decoration:none; }
.item_amount1 { position:relative; height:17px; line-height:17px; font-size:13px; color:#8a8a8a; font-weight:300; }
.item_amount2 { position:relative; height:25px; line-height:25px; font-size:22px; color:#009b8a; font-weight:500; }

.item_list .it_btn_area { position:absolute; left:15px; top:112px; width:68px; cursor:pointer; display:none; }
.item_list:hover .it_btn_area { display:inline-block; }
.item_list .it_btn_area > img, .item_list .it_btn_area > a { float:left; }
.item_list .it_btn_area > a img { display:block; }

.it_option { position:absolute; left:0px; top:198px; border:1px solid #333333; background:#fff; width:<?=$img_width?>px; display:none; padding:15px 15px 5px 15px; box-sizing:border-box; z-index:10; }
p.option_title { color:#3b3b3b; font-size:14px; font-family:'Dotum'; font-weight:bold; padding-bottom:10px; }
.it_option table th { font-size:13px; text-align:left; }
.it_option table td { font-size:13px; text-align:left; }

.it_option_point { position:absolute; left:15px; top:-9px; width:16px; height:9px; background:url("/res/images/it_option.png") no-repeat left top; }

.item_mark_area { position:absolute; left:10px; top:-1px; width:140px; height:53px; }
.item_mark { float:left; width:64px; height:53px; line-height:45px; color:#ffffff; font-size:21px; box-sizing:border-box; padding:0px 0px 0 0; text-align:center; background-position:center top; background-repeat:no-repeat; background-image:url("/res/images/item_mark1.png"); font-weight:400; }
.item_mark2 { float:left; width:64px; height:53px; line-height:17px; color:#ffffff; font-size:15px; box-sizing:border-box; padding:5px 0px 0 0; text-align:center; background-position:center top; background-repeat:no-repeat; background-image:url("/res/images/item_mark2.png"); font-weight:400; margin-left:12px; }
</style>

<div class="item_area" >
	<? for ($i=0; $row=sql_fetch_array($result); $i++) { ?>			
		<div class="item_list">

				
				<a href="<?=$g4[shop_url]?>/item.php?it_id=<?=$row[it_id]?>" target="_self" style="display:inline-block;" >
					<div class='item_thum'>
						<?=get_image($row[it_id]."_s", $img_width, $img_height)?>
						<?//=get_it_image($row[it_id]."_s", $img_width, $img_height, $row[it_id])?>
						<div class="item_black"></div>
							
						<?if($row[it_stock_qty] < 1){?>
							<div class="item_mark_area">
								<div class="item_mark" style="font-size:15px; line-height:15px; padding-top:10px;">SOLD<br/>OUT</div>
							</div>
						<?}else if($row[it_basic_discount] > 0){?>
							<div class="item_mark_area">
								<div class="item_mark">
									<?=$row[it_basic_discount]?>%<!-- <br/>기본할인 -->
								</div>
								<?if($row[it_special_discount] > 0){?>
									<div class="item_mark2">
										<span style="font-size:18px;" ><?=$row[it_special_discount]?>%</span><br/>추가할인
									</div>
								<?}?>
							</div>
						<?}?>
					</div>
				</a>

				<div class="item_content" >
					<p class='item_subj'><a href="<?=$g4[shop_url]?>/item.php?it_id=<?=$row[it_id]?>" target="_self" style="display:inline-block;" ><?=$row[it_name]?></a></p>
					
					<?if (!$row[it_gallery]) { //갤러리 상품은 표시 안함?>
					<p class='item_amount1'>
						<?if( $row["it_cust_amount"] > get_amount($row)){?><strike style="color:#8a8a8a; font-weight:300;"><?=display_amount($row["it_cust_amount"])?></strike><?}?>
					</p>
					<p class='item_amount2'>
						<?=display_amount(get_amount($row), $row[it_tel_inq])?>
					</p>
					<?}?>
				</div>

				<div class="it_btn_area" style="top:145px;" >
					<img src="/shop/img/it_btn1.png" onmouseover="this.src='/shop/img/it_btn1a.png'" onmouseout="this.src='/shop/img/it_btn1.png'" onclick="window.open('<?=$g4[shop_url]?>/item.php?it_id=<?=$row[it_id]?>')" class="it_btn1" />

					<a class="it_btn3" href="javascript:void(0);" onclick="open_fixed_layer('<?=$g4[shop_path]?>/item_popup.php?it_id=<?=$row[it_id]?>', 660)">
						<img src="/shop/img/it_btn3.png" onmouseover="this.src='/shop/img/it_btn3a.png'" onmouseout="this.src='/shop/img/it_btn3.png'"/>
					</a>
					<img src="/shop/img/it_btn4.png" onmouseover="this.src='/shop/img/it_btn4a.png'" onmouseout="this.src='/shop/img/it_btn4.png'" onclick="item_wish($(this).closest('form'), '<?=$row[it_id]?>')" class="it_btn4" />
				</div>

		</div>

	<? } ?>
</div>

<script type="text/javascript">
$(function(){


	$(".item_list").mouseleave(function(){
		if( $(this).find(".it_option").is(":visible") ){
			$(this).find(".it_option").hide();
		}
	});
});


// 상품보관
function item_wish(fObj, it_id)
{
	/*
	var f = fObj[0];
	f.url.value = "<?=$g4[shop_path]?>/wishupdate.php?it_id="+it_id;
	f.action = "<?=$g4[shop_path]?>/wishupdate.php";
	f.submit();
	*/
	
	jQuery.ajax({
		url : "<?=$g4[shop_path]?>/_ajaxAddWish.php?it_id="+it_id+"&mb_id=<?=$member["mb_id"]?>",
		success: function(data){
			alert(data.message);
		}
	});

}
</script>
