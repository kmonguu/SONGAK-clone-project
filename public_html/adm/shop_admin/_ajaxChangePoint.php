<?
include_once("./_common.php");
header("Content-Type: application/json; charset=$g4[charset]");
//wr_id bo_table val

if ($cf_all_point == ""){
	die("{\"message\":\"입력하신 포인트가 없습니다.\"}");

} else if($cf_all_point == 0 || $cf_all_point){
	

	$query = " SELECT * FROM yc4_item WHERE (1) ";

	$result = sql_query($query);

	for($i = 0; $row=sql_fetch_array($result) ; $i++ ){

		$give_point = 0;
		if($row[it_amount2] && $row[it_amount2] > 0){
			$give_point = $row[it_amount2] * ($cf_all_point/100);
		}else{
			$give_point = $row[it_amount] * ($cf_all_point/100);
		}
		$sql = " update yc4_item set it_point = '$give_point' where it_id = '{$row[it_id]}' ";
		sql_fetch($sql);
	} 

	$sql = " update g4_config set cf_all_point = '$cf_all_point' ";
	sql_fetch($sql);

	die("{\"message\":\"저장되었습니다.\"}");
} else {
	die("{\"message\":\"오류입니다.\"}");
}
?>