<?
include_once("./_common.php");
header("Content-Type: text/html; charset=$g4[charset]");

//업체정보 추출
$sql =    "	SELECT *
			  FROM $g4[yc4_item_table] 
 			 WHERE ca_id = '$ca_id' 
                  or ca_id2 = '$ca_id' 
                  or ca_id3 = '$ca_id'
			";
$itemResult = sql_query($sql);
$returnStr = "";

$j=0;

while($row = sql_fetch_array($itemResult)) {
	if($j > 0) $returnStr .= "&&";
	$returnStr .= "$row[it_id]||$row[it_name]";
	$j++;
}
if($j == 0 ){
	$returnStr = "N";
}

echo $returnStr;
?>