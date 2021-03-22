<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if( ! preg_match("/[가-힣]/",$wr_content) ){
	alert("한글이 없는 경우 등록이 불가합니다.");
	exit;
}

