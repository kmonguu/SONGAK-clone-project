<?
include_once("_common.php");

$depth = $_POST["depth"];
$it_id = $_POST["it_id"];
$type1 = $_POST["type1"];
$type2 = $_POST["type2"];
$type3 = $_POST["type3"];

$optObj = new Yc4ItemOption();
$optlst = $optObj->opt_list($depth, $it_id);

foreach($optlst as $opt){

	$is_last = false; //마지막 Depth 옵션인가?
	
	if($depth == 1) {
		$d2list = $optObj->get_options_d2($it_id, $opt["type"]); //해당 옵션의 하위 목록
		$optInfo = $optObj->get_option($it_id, $opt["type"]);
		if(count($d2list) == 0)  {
			$qty = $optObj->get_qty($it_id, "", $opt["type"], "", "", true);
			$is_last = true;
		}
	}
	if($depth == 2){
		$d3list = $optObj->get_options_d3($it_id, $type1, $opt["type"]); //해당 옵션의 하위 목록
		$optInfo = $optObj->get_option($it_id, $type1,$opt["type"]);
		if(count($d3list) == 0) {
			$qty = $optObj->get_qty($it_id, "", $type1, $opt["type"], "", true);
			$is_last = true;
		}
	}
	else if($depth == 3){
		$optInfo = $optObj->get_option($it_id, $type1, $type2, $opt["type"]);
		$qty = $optObj->get_qty($it_id, "", $type1, $type2, $opt["type"], true);
		$is_last = true;
	}
	

	$is_disable = false;
	if($is_last && !$optInfo["io_use"]) continue;
	if($is_last && $qty <= 0) $is_disable = true;
	
?>
	<option value="<?=$opt["type"]?>" class="<?=$is_last ? "lastopt" : ""?>" data-opt-no="<?=$optInfo["no"]?>" <?=$is_disable ? "disabled" : ""?> >
		<?=$opt["type"]?>&nbsp;&nbsp;&nbsp;
		<?if($is_last){ ?>
			<?if($optInfo["io_amt"] != 0) {?>
			+<?=number_format($optInfo["io_amt"])?>원
			<?}?>
			<?if($qty > 0) {?>
				(재고 <?=$qty?>개)
			<?} else {?>
				(재고없음)
			<?}?>
		<?}?>
	</option>
<?}?>
