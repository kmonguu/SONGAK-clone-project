<?
include_once("./_common.php");
$it_id = $_POST["it_id"];
$optObj = new Yc4ItemOption();
$opts = $optObj->get_all_list($it_id);

if(!$_POST["opt1"]) { //불러오기
?>
	<?foreach($opts as $o){?>
	<tr class="optionlist">
		<td style="height:45px;">
			<input type="hidden" name="io_type1[]" value="<?=$o["io_type1"]?>" />
			<input type="hidden" name="io_type2[]" value="<?=$o["io_type2"]?>" />
			<input type="hidden" name="io_type3[]" value="<?=$o["io_type3"]?>" />

			<span class="bbtn1-o small"><?=$o["io_type1"]?></span>
			<?if($o["io_type2"]){ echo " > <span class='bbtn1-o small'>".$o["io_type2"]."</span>"; }?> 
			<?if($o["io_type3"]){ echo " > <span class='bbtn1-o small'>".$o["io_type3"]."</span>"; }?> 
		</td>
		<td>
			<input class="" type="text" name="io_amt[]" value="<?=$o["io_amt"]?>" style="width:98%;"/>
		</td>
		<td>
			<input class="" type="text" name="io_point[]" value="<?=$o["io_point"]?>" style="width:98%;"/>
		</td>
		<td>
			<input class="" type="text" name="io_qty[]" value="<?=$o["io_qty"]?>" style="width:98%;"/>
		</td>
		<td>
			<select name="io_use[]">
				<option value="0">사용안함</option>
				<option value="1" <?=$o["io_use"] ? "selected" : ""?> >사용</option>
			</select>
		</td>
		
	</tr>
	<?}?>

	<?if(count($opts) == 0){?>
	<tr>
		<td colspan="5" style="text-align:center; padding:50px;">
			선택옵션이 없습니다 옵션목록을 생성해주세요
		</td>
	</tr>
	<?}?>


<?} else { //생성하기 
	
	//#### 옵션 Array 생성
	$row = array();
	
	$opt1 = $_POST["opt1"];
	$opt2 = $_POST["opt2"];
	$opt3 = $_POST["opt3"];
	$os1 = explode(",", $opt1);
	$os2 = explode(",", $opt2);
	$os3 = explode(",", $opt3);
	
	for($d1 = 0 ; $d1 < count($os1); $d1++){

		$type1 = trim($os1[$d1]);
		$type1 = str_replace("\\\"", "", $type1);
		
		$row[$type1] = array();
		
		if(count($os2) > 0){

			//2Depth			
			for($d2 = 0 ; $d2 < count($os2); $d2++){

				$type2 = trim($os2[$d2]);
				$type2 = str_replace("\\\"", "", $type2);

				$row[$type1][$type2] = array();
				
				if(count($os3) > 0){ 

					//3Depth			
					for($d3 = 0 ; $d3 < count($os3); $d3++){
						$type3 = trim($os3[$d3]);
						$type3 = str_replace("\\\"", "", $type3);

						$row[$type1][$type2][$type3] = array();
						
					}
					
				} 

			}

		} 
	}




	//#### 옵션 ROW 생성
	$options = array();
	foreach($row as $type1 => $t2s){
		if(count($t2s) > 0){
			foreach($t2s as $type2 => $t3s){
				if(count($t3s) > 0){
					foreach($t3s as $type3 => $values){
						$options[] = array("io_type1"=>$type1, "io_type2"=>$type2, "io_type3"=>$type3);
					}
				} else {
					$options[] = array("io_type1"=>$type1, "io_type2"=>$type2);
				}
			}
		} else {
			$options[] = array("io_type1"=>$type1);
		}
	}
	?>



	<?
	//#### 옵션 TABLE TR 생성
	foreach($options as $o){
		
		//DB에 등록정보 있으면 가져옴
		$orow = $optObj->get_option($it_id, $o["io_type1"], $o["io_type2"], $o["io_type3"]);
	?>

	
	<tr class="optionlist">
		<td style="height:45px;">
			<input type="hidden" name="io_type1[]" value="<?=$o["io_type1"]?>" />
			<input type="hidden" name="io_type2[]" value="<?=$o["io_type2"]?>" />
			<input type="hidden" name="io_type3[]" value="<?=$o["io_type3"]?>" />

			<span class="bbtn1-o small"><?=$o["io_type1"]?></span>
			<?if($o["io_type2"]){ echo " > <span class='bbtn1-o small'>".$o["io_type2"]."</span>"; }?> 
			<?if($o["io_type3"]){ echo " > <span class='bbtn1-o small'>".$o["io_type3"]."</span>"; }?> 
		</td>
		<td>
			<input class="" type="text" name="io_amt[]" value="<?=$orow["io_amt"] ? $orow["io_amt"] : "0"?>" style="width:98%;"/>
		</td>
		<td>
			<input class="" type="text" name="io_point[]" value="<?=$orow["io_point"] ? $orow["io_point"] : "0"?>" style="width:98%;"/>
		</td>
		<td>
			<input class="" type="text" name="io_qty[]" value="<?=$orow["io_qty"] ? $orow["io_qty"] : $_POST["it_stock_qty"]?>" style="width:98%;"/>
		</td>
		<td>
			<select name="io_use[]">
				<option value="0">사용안함</option>
				<option value="1" <?=$orow["no"] == "" || $orow["io_use"] ? "selected" : ""?> >사용</option>
			</select>
		</td>
		
	</tr>


	<?}?>







<?}?>