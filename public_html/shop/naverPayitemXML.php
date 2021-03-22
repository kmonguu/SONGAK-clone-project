<?
include_once("./_common.php");

$query = $_SERVER['QUERY_STRING'];
$vars = array();
foreach(explode('&', $query) as $pair) {
	list($key, $value) = explode('=', $pair);
	$key = urldecode($key);
	$value = urldecode($value);
	$vars[$key][] = $value;
}
$itemIds = $vars['ITEM_ID'];
if (count($itemIds) < 1) {
	exit('ITEM_ID 는 필수입니다.');
}

$where = "";
for($i=0;$i<count($itemIds);$i++){
	if($where) $where .= ",'".$itemIds[$i]."'";
	else $where .= " it_id IN('".$itemIds[$i]."'";
}
if($where){
	$where .= ")";

	$it_result = sql_query("SELECT * FROM yc4_item WHERE ".$where);
}

header('Content-Type: application/xml;charset=utf-8');

echo ('<?xml version="1.0" encoding="utf-8"?>');
?>
<response>
<?
while($it=sql_fetch_array($it_result)){
	$id = $it['it_id'];
	$name = trim(strip_tags($it['it_name']));
	$description = strip_tags($it['it_basic']);
	$price = $it['it_amount'];
	$quantity = 1;

	$image_url = "";
	$domain = explode(":", $_SERVER[HTTP_HOST]);
	if(is_file("$g4[path]/data/item/{$it['it_id']}_l1")) $image_url = "http://".$domain[0]."/data/item/{$it['it_id']}_l1";
	if(is_file("$g4[path]/data/item/{$it['it_id']}_m")) $thumb_url = "http://".$domain[0]."/data/item/{$it['it_id']}_m";
	if(is_file("$g4[path]/data/item/{$it['it_id']}_s")) $thumb_url = "http://".$domain[0]."/data/item/{$it['it_id']}_s";
	if(!$thumb_url) $thumb_url = $image_url;

	$ca_name1 = sql_fetch("SELECT * FROM yc4_category WHERE ca_id = '".$it['ca_id']."' ");
	$ca_name2 = sql_fetch("SELECT * FROM yc4_category WHERE ca_id = '".$it['ca_id2']."' ");
	$ca_name3 = sql_fetch("SELECT * FROM yc4_category WHERE ca_id = '".$it['ca_id3']."' ");
	?>
	<item id="<?=$id?>">
	<?/*?>
		<mall_pid><?=$id?></mall_pid>
	<?*/?>
	<name><![CDATA[<?=$name?>]]></name>
	
	<?if(isset($_SERVER['HTTPS'])){?>
	<url>https://<?=$_SERVER["HTTP_HOST"]?>/shop/item.php?it_id=<?=$it['it_id']?></url>
	<?} else {?>
	<url>http://<?=$_SERVER["HTTP_HOST"]?>/shop/item.php?it_id=<?=$it['it_id']?></url>
	<?}?>

	<description><![CDATA[<?=$description?>]]></description>
	<image><?=$image_url?></image>
	<thumb><?=$thumb_url?></thumb>
	<price><?=$price?></price>
	<quantity><?=$quantity?></quantity>
	<category>
	<first id="MJ01"><?=$ca_name1['ca_name']?></first>
	<second id="ML01"><?=$ca_name2['ca_name']?></second>
	<third id="MN01"><?=$ca_name3['ca_name']?></third>
	</category>
	<options>
	<?for ($i=1; $i<=6; $i++){
		$arr = explode("\n", $it["it_opt{$i}"]);
		if ($it["it_opt{$i}_subject"]&&count($arr)>0){
	?>
		<option name="<?=$it["it_opt".$i."_subject"]?>">
		<?for($j=0;$j<count($arr);$j++){
			$str = explode(";", $arr[$j]);
		?>
			<select> <![CDATA[ <?=$str[0]?> ]]> </select>
		<?}?>
		</option>
	<?}}?>
	</options>
	</item>
<?
}
echo('</response>');
?>