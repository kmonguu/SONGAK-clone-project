<?
include_once("./_common.php");



$send_list = array();

//전송목록 생성
if($_POST["sendtype"] == "all"){ //전체

	$mbObj = new Member();
	$mblist_result = $mbObj->get_list(1, "", "" ,"", "", PHP_INT_MAX, " AND mb_sms=1 AND mb_hp != '' ");
	$mblist = $mblist_result["list"];

} else {

	//선택회원
	$mblist_result = explode("|", $_POST["hp_list"]);
	$mblist = array();
	foreach($mblist_result as $mb){
		$m = explode("//", $mb);
		if($m[2] == "") continue; 
		$row = array(
			"mb_id" => $m[0],
			"mb_name" => $m[1],
			"mb_hp" => $m[2]
		);

		array_push($mblist, $row);
	}

}


$sms4 = sql_fetch("select * from $g4[sms4_config_table] ");
$o_msg = $_POST["msg_content"];
$snum = $sms4["cf_phone"];
$snum = str_replace("-", "", $snum);
$snum = str_replace(" ", "", $snum);



for($idx = 0 ;  $idx < count($mblist) ; $idx++) {

    $row = $mblist[$idx];
    $rnum = $row["mb_hp"];
    Sms4Message::SEND_MSG($rnum, $snum, $msg_content, $row["mb_id"], $row["mb_name"]);
}
    

















alert("전송이 완료되었습니다.", "./send_sms.php");
			