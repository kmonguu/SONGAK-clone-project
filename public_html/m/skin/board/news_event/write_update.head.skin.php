<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$arr = array("경마","게임","예상","스포츠","경정","레이스","경륜","로얄","백경","토토","검빛","경주거리","뉴바다","더비","럭키정글","리벨로","리빙티비","마주협회","명승부경주","무료사이트","무승패","블루오션","생방송","속보","신마뉴스","신천지","야마토3","요실금도","운영본부","체리마스터","출주기수","텍사스홀덤","파라다이스","프로토","한국마사회","황금성");

function check($target){
	global $arr;
	foreach($arr as $val){
		if(strpos("w".$target,$val) != false){
			return $val;
		}
	}

	return "";
}

$val = check($wr_subject);
if( $val != "" ) {
	//echo "<meta charset='utf-8'>";
	//die(check($wr_content));
	//goto_url("/bbs/board.php?bo_table=$bo_table");
	alert('입력하신내용에 금지어 '.$val.'가 있습니다. ');
}
$val = check($wr_name);
if( $val != "" ) {
	//echo "<meta charset='utf-8'>";
	//die(check($wr_content));
	//goto_url("/bbs/board.php?bo_table=$bo_table");
	alert('입력하신내용에 금지어 '.$val.'가 있습니다. ');
}

$val = check($wr_content);
if( $val != "" ) {
	//echo "<meta charset='utf-8'>";
	//die(check($wr_content));
	//goto_url("/bbs/board.php?bo_table=$bo_table");
	alert('입력하신내용에 금지어 '.$val.'가 있습니다. ');
}

