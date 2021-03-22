<?
include_once("./_common.php");
auth_check($auth[$sub_menu], "r");

if($w == ""){

	if($keyword == "") alert("추가할 키워드를 입력해주세요!");

	$sql = "
		INSERT INTO blog_keyword
		SET
			keyword = '$keyword' 
			, reg_date = now()
	";
	
	sql_query($sql);
}
else if($w == "d"){
	
	$sql = "
		DELETE FROM blog_keyword WHERE no = '$no' 
	";

	sql_query($sql);
}
goto_url("./blog_list.php");
?>


