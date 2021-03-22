<?
include_once("_common.php");

$it_id = $_POST["it_id"];
$yc4Obj = new Yc4();
$it = $yc4Obj->get_item($it_id);


$type1 = $_POST["type1"];
$type2 = $_POST["type2"];
$type3 = $_POST["type3"];

$obj = new Yc4ItemOption();
$it_option = $obj->get_option($it_id, $type1, $type2, $type3);
$qty = $obj->get_qty($it_id, "", $type1, $type2, $type3);

$is_opt = true;
if($type1 == "" && $type2 == "" && $type3 == ""){ //옵션이 없는 상품
	$is_opt = false;
	$qty = get_it_stock_qty($it_id);
}
?>


<div class="option_item option_item_<?=$it_option["no"]?>"  data-qty="<?=$qty?>" style="display:inline-block; width:100%;" >

	<input type="hidden" name="it_option1[]" value="<?=$type1?>"  />
	<input type="hidden" name="it_option2[]" value="<?=$type2?>"  />
	<input type="hidden" name="it_option3[]" value="<?=$type3?>"  />
	<input type="hidden" name="io_amt[]" class="io_amt" value="<?=$it_option["io_amt"]?>"  />

	<?if($is_opt) {?>
		<div class="opt_name" style="position:relative;">

			<?=$it["it_option1_subject"]?>:<?=$type1?> 
			<?if($type2 != ""){?>
			/ <?=$it["it_option2_subject"]?>:<?=$type2?> 
			<?}?>
			<?if($type3 != ""){?>
			/ <?=$it["it_option3_subject"]?>:<?=$type3?>
			<?}?>

			<div style="position:absolute; top:0px; right:0px; font-size:15px; color:#CC0000; font-weight:bold; margin-right:10px; cursor:pointer;" onclick="delete_option_item(this);">	
				<i class="far fa-trash-alt" ></i>
			</div>
		</div>
	<?} else {?>
		<div class="opt_name" >
			<?=$it["it_name"]?> (재고수량 : <?=$qty?>개)
		</div>
	<?}?>
	
	<?if($qty > 0) {?>
	<img src="/res/images/minus_btn.jpg" onclick="qty_add(this, -1)" style="cursor:pointer; float:left;" />
	<input type=text name='ct_qty[]' value='1' maxlength=4 class="ed ct_qty" autocomplete='off' style='text-align:center; width:40px; height:45px; border:1px solid #cecece; float:left; padding:0;' onkeyup='qty_keyup(this)'>
	<img src="/res/images/plus_btn.jpg" onclick="qty_add(this, +1)" style="cursor:pointer; float:left;" />

	<div class="opt_amount" >
		+<?=number_format($it_option["io_amt"])?>원
	</div>
	<?} else {?>
	<input type="hidden"  name='ct_qty[]' class="ct_qty"  value='1'>
	<div class="opt_amount" style="width:160px; font-weight:bold; color:#CC0000;">
		재고없음
	</div>
	<?}?>
	
	
</div>
