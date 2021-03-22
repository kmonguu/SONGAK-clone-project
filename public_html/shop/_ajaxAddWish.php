<?
include_once("./_common.php");
header("Content-Type: application/json; charset=$g4[charset]");
//wr_id bo_table val

if (!$mb_id){
	die("{\"message\":\"회원 전용 서비스 입니다.\"}");

} else if($mb_id && $it_id){

	$sql_common = " set mb_id = '$member[mb_id]',
                        it_id = '$it_id',
                        wi_time = '$g4[time_ymdhis]',
                        wi_ip = '$REMOTE_ADDR' ";

    $sql = " select wi_id from $g4[yc4_wish_table] 
              where mb_id = '$member[mb_id]' and it_id = '$it_id' ";
    $row = sql_fetch($sql);

    if ($row[wi_id]) { // 이미 있다면 삭제함

        $sql = " delete from $g4[yc4_wish_table] where wi_id = '$row[wi_id]' ";
        sql_query($sql);
		
		die("{\"message\":\"관심상품에서 삭제되었습니다.\",\"state\":\"off\"}");

    } else {

		$sql = " insert $g4[yc4_wish_table]
					set mb_id = '$member[mb_id]',
						it_id = '$it_id',
						wi_time = '$g4[time_ymdhis]',
						wi_ip = '$REMOTE_ADDR' ";
		sql_query($sql);
		
		die("{\"message\":\"관심상품에 추가되었습니다.\",\"state\":\"on\"}");
	}

} else {
	die("{\"message\":\"오류입니다.\"}");
}
?>