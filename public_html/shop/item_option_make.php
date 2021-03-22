<?
include_once("_common.php");



$it_id = $_POST["it_id"];
$type1 = $_POST["type1"];
$type2 = $_POST["type2"];
$type3 = $_POST["type3"];
$ct_id = $_POST["ct_id"]; //장바구니 옵션/수량 변경시 넘어옴



$yc4Obj = new Yc4();

$ct = array("ct_qty"=>"1");
if($ct_id) {
	$ct = $yc4Obj->get_cart($ct_id);
	$it_id = $ct["it_id"];
	$type1 = $ct["it_option1"];
	$type2 = $ct["it_option2"];
	$type3 = $ct["it_option3"];
	if($ct["ct_id"] == "") exit;
}


$it = $yc4Obj->get_item($it_id);

$obj = new Yc4ItemOption();
$it_option = $obj->get_option($it_id, $type1, $type2, $type3);
$qty = $obj->get_qty($it_id, "", $type1, $type2, $type3, true);

$is_opt = true;
if($type1 == "" && $type2 == "" && $type3 == ""){ //옵션이 없는 상품
	$qty = get_it_stock_qty($it_id, "", true);
	$is_opt = false;
}


?>


<div class="option_item option_item_<?=$it_option["no"]?>"  data-qty="<?=$qty?>" style="display:inline-block; width:100%;" >

	<input type="hidden" name="it_option1[]" value="<?=$type1?>"  />
	<input type="hidden" name="it_option2[]" value="<?=$type2?>"  />
	<input type="hidden" name="it_option3[]" value="<?=$type3?>"  />
	<input type="hidden" name="io_amt[]" class="io_amt" value="<?=$it_option["io_amt"]?>"  />
	<input type="hidden" name="io_point[]" class="io_point" value="<?=$member["mb_id"] ? $it_option["io_point"] : 0?>"  />

	

	<?if($is_opt) {
		//############################################
		//선택된 선택옵션 표시	
	?>

	
		<?
			$opt_name = "";
			$opt_name .= $it["it_option1_subject"].":".$type1;
			if($type2)
				$opt_name .= " / ".$it["it_option2_subject"].":".$type2;
			if($type3)
				$opt_name .= " / ".$it["it_option3_subject"].":".$type3;
		?>


		<div class="opt_name" style="position:relative;" data-name="<?=$opt_name?>">
			<i class="fas fa-gift"></i>
			<?=$opt_name?>

			<!-- 옵션 삭제 버튼-->
			<div style="position:absolute; top:0px; right:0px; font-size:15px; color:#CC0000; font-weight:bold; margin-right:10px; cursor:pointer;" onclick="delete_option_item(this);">	
				<i class="far fa-trash-alt" ></i>
			</div>
		</div>


	<?} else {
		//############################################
		//선택옵션이 없는 상품
		?>
		

		
		<?if($qty > 0) {//선택옵션이 없는 상품의 경우 일반옵션은 수량 전에 표시?>
			<?
				// 선택옵션 출력
				$add_options = "";
				for ($i=1; $i<=6; $i++)
				{
					// 옵션에 문자가 존재한다면
					$str = get_item_options(trim($it["it_opt{$i}_subject"]), trim($it["it_opt{$i}"]), $i);
					if(trim($it["it_opt{$i}"]) == $str) continue; //선택옵션만 표시
					if ($str)
					{
						$add_options .= "<div>";
						$add_options .=  "<span class='tit'>".$it["it_opt{$i}_subject"]."</span>";
						$add_options .=  "<span class='cont'>$str</span>";
						$add_options .= "</div>";
					}
				}
				if($add_options) {
			?>

				<div class="div_add_options_nosltopt">
					<?=$add_options?>
				</div>

			<?}?>
		<?}?>
	


		
		<div class="opt_name vright_con_title" data-name="<?=$it["it_name"]?>">
			<!--
			<i class="fas fa-cube"></i> <?=$it["it_name"]?> (재고수량 : <?=$qty?>개)
			-->
			수량
		</div>

	<?}?>
	


    <?if($qty > 0) {
		// 수량선택 버튼
		?>


        <img src="/shop/img/minus_btn.jpg" onclick="qty_add(this, -1)" style="cursor:pointer; float:left;" />
        <input type=text name='ct_qty[]' value='<?=$ct["ct_qty"]?>' maxlength=4 class="ed ct_qty" autocomplete='off' style='text-align:center; width:40px; height:34px; border:1px solid #cecece; float:left; padding:0;' onkeyup='qty_keyup(this)'>
        <img src="/shop/img/plus_btn.jpg" onclick="qty_add(this, +1)" style="cursor:pointer; float:left;" />
        
        <?if($is_opt) {?>
            <div class="opt_amount" >
                +<?=number_format($it_option["io_amt"])?>원
            </div>

			<div class="opt_amount" style="width:auto; margin-left:5px;" >
				(적립금:<?=number_format($it_option["io_point"])?>)
			</div>
        <?}?>


    <?} else {?>
        
        <input type="hidden"  name='ct_qty[]' class="ct_qty"  value='1'>
        <div class="opt_amount" style="width:100%; font-weight:bold; color:#CC0000;">
            재고없음
        </div>

	<?}?>
	



	<?if($is_opt) {//선택옵션이 존재하면, 일반옵션은 추가된 선택옵션 하단으로 표시?>
		<?if($qty > 0) {?>
			<?
				// 선택옵션 출력
				$add_options = "";
				for ($i=1; $i<=6; $i++)
				{
					// 옵션에 문자가 존재한다면
					$str = get_item_options(trim($it["it_opt{$i}_subject"]), trim($it["it_opt{$i}"]), $i);
					if(trim($it["it_opt{$i}"]) == $str) continue; //선택옵션만 표시
					if ($str)
					{
						$add_options .=  "<div class='tit'><i class='far fa-arrow-alt-circle-right'></i> ".$it["it_opt{$i}_subject"]."</div>";
						$add_options .=  "<div class='cont'>$str</div>";
					}
				}
				if($add_options) {
			?>

				<div class="div_add_options">
					<?=$add_options?>
				</div>

			<?}?>
		<?}?>
	<?}?>




	
	<?
	//장바구니 수정일 경우 일반옵션 선택되어있게
	if($ct_id) {
	?>
		<script>
			<?for ($i=1; $i<=6; $i++)	{?>
				$(".it_opt<?=$i?> > option[value='<?=$ct["it_opt{$i}"]?>']").attr("selected", "selected");
			<?}?>
		</script>
	<?}?>
	
</div>
