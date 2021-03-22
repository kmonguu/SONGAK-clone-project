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


	$f = @file("$g4[path]/bbs/calendar/$year.txt");
	if ($f) {
		while ($line = each($f)) {
			$tmp = explode("|", $line[value]);
	        $nal[$tmp[0]] = $tmp;
	    }
	}


	//------ 날짜의 범위 체크
	if (($year > 9999) or ($year < 0)){
		alert("연도는 0~9999년만 가능합니다.");
	}

	if (($month > 12) or ($month < 0)){
		alert("달은 1~12만 가능합니다.");
	}
?>
<link rel="stylesheet" href="<?=$board_skin_path?>/style.css" type="text/css">
<table width="100%" border="0" cellspacing="0" cellpadding="1">
<tr>
<td>
<table width="<?=$width?>" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td>

<?
	switch ($mode) {
	case "d" :
		include "$board_skin_path/list.day.php";
		break;
	case "w" :
		include "$board_skin_path/list.week.php";
		break;
	case "m2" :
		include "$board_skin_path/list.month2.php";
	    break;
	case "m" :
		include "$board_skin_path/list.month.php";
	    break;
	case "l" :
		include "$board_skin_path/list.day.php";
	    break;
	default :
		include "$board_skin_path/list.month3.php";
	}
?>
</td>
</tr>
</table>
	</td>
</tr>
</table>