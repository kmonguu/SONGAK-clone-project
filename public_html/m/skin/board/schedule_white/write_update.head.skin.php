<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$arr = array("황금성");

function check($target){
	global $arr;
	foreach($arr as $val){
		if(strpos("w".$target,$val) != false){
			return $val;
		}
	}

	return false;
}

if( check($wr_subject) ||  check($wr_name) ||  check($wr_content) ){
	//echo "<meta charset='utf-8'>";
	//die(check($wr_content));
	goto_url("/bbs/board.php?bo_table=$bo_table");
}
