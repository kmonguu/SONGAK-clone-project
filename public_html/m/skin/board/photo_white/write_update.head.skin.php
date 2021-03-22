<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
$wr_content=str_replace("자신의 도메인",'..',$wr_content); 
// 업로드 파일경로 절대경로 -> 상대경로로 변경
// 홈페이지 주소가 http://aaa.com 이면 그것을 자신의 도메인 부분에 적어 줍니다.
// 상대경로일때 썸네일이 동작합니다.
?>