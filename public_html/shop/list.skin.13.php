<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>

<style>
.item_cover_ul { display:inline-block; width:100%; padding-top:50px; } 
 /* 이미지 넓이280 */
.item_cover_ul > li { width:<?=$img_width?>px !important; height:413px; margin:0 0 20px 24px; position:relative; text-align:left; border:1px solid #d9d9d9; float:left; }  
.item_cover_ul > li:nth-child(4n+1) { margin-left:0px; }
.item_cover_ul > li > div > a { text-decoration:none; font-size:17px; color:#222; font-weight:400; overflow:hidden; text-overflow:ellipsis; white-space:normal; word-wrap:break-word; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; }

.list_subject { text-align:center; width:100%; height:54px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }



.con_btn { width:100%; height:41px; box-sizing:border-box; border-top:1px solid #d9d9d9; float:left; }
.con_btn div { width:50%; height:38px; float:left; cursor:pointer; }
.con_btn div:nth-child(1) { background:url('/res/images/wish.png') no-repeat center center, #fff; }
.con_btn div:nth-child(2) { background:url('/res/images/cart.png') no-repeat center center, #fff; box-sizing:border-box; border-left:1px solid #d9d9d9; }
.con_btn div:nth-child(1):hover { background:url('/res/images/wish.png') no-repeat center center, #f8f8f8; }
.con_btn div:nth-child(2):hover { background:url('/res/images/cart.png') no-repeat center center, #f8f8f8; }
</style>

<ul class="item_cover_ul">
	<? for ($i=0; $row=sql_fetch_array($result); $i++) { 
		$href = "<a href='$g4[shop_path]/item.php?it_id=$row[it_id]' class=item style='color:#222;'>";
	?>

		<li>
			<div style="position:relative;" >
				<?=$href?><?=get_it_image($row[it_id]."_s", $img_width, $img_height)?></a>
				<div style=" display:inline-block; position:absolute; right:5px; top:10px; border-radius:4px;">

					<!-- ITEM TYPE ICON -->
					<?for($idx = 1 ; $idx <= 5; $idx++) {?><?if($row["it_type{$idx}"]) {?><div class="icon_item_type<?=$idx?>"><?=Yc4::$IT_TYPE[$idx]?></div><?}?><?}?>
				
				</div>
			</div>

			<div class="list_subject" style=""><?=$href?><?=stripslashes($row[it_name])?></a></div>



			<div style="text-align:center; font-size:16px; color:#222; padding:7px 0 8px;">

				<?if (!$row[it_gallery]) { //갤러리 상품은 표시 안함?>

					<?if($row[it_cust_amount]){?>
						<strike style="color:#ff6565"><span style='color:#555;'><?=number_format($row[it_cust_amount])."원"?></span></strike>
					<?}?>
					<span style='color:#ff6565;  margin-left:15px;'>
						<?=display_amount(get_amount($row), $row[it_tel_inq])?>
					</span>

				<?} else {?>
					<?=$row[it_tel_inq] ? "전화문의" : ""?>
				<?}?>

			</div>

			<? if (!$row[it_tel_inq] &&  !$row[it_gallery]) { //전화문의/갤러리 상품은 표시 안함?>
			
				<div style="width:100%; height:41px; position:relative;">
				
						<div class="con_btn">
							<div onclick="item_wish($(this).closest('form'), '<?=$row[it_id]?>')"></div>	
							<div onclick="open_fixed_layer('<?=$g4[shop_path]?>/item_popup.php?it_id=<?=$row[it_id]?>', 660)"></div>	
						</div>
		
				</div>
				
			<?}?>


		</li>

	<?}?>
</ul>
<script type="text/javascript">
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

