<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

	//---- 오늘 날짜
	$thisyear  = date('Y');  // 2000
	$thismonth = date('n');  // 1, 2, 3, ..., 12
	$thisday   = date('j');  // 1, 2, 3, ..., 31

	//------ $year, $month 값이 없으면 현재 날짜
	if (!$year)  { $year = $thisyear; }
	if (!$month) { $month = $thismonth; }
	if (!$day)   { $day = $thisday; }

	//------ 날짜의 범위 체크
	if (($year > 9999) or ($year < 0)){
		alert("연도는 0~9999년만 가능합니다.");
	}

	if (($month > 12) or ($month < 0)){
		alert("달은 1~12만 가능합니다.");
	}
?>
<link rel="stylesheet" href="<?=$board_skin_mpath?>/style.css" type="text/css">
<div style="height:40px;"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td>
		<?include_once($board_skin_mpath."/list.month.skin.php");?>
	</td>
</tr>
</table>