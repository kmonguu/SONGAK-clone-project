<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

//가로 세로 폭 지정
if (eregi('%', $width)) { $col_width = "14%"; }
else { $col_width = round($width/7); }
$col_height= 80 ;

$prevmonth = $month - 1;
$nextmonth = $month + 1;
$prevyear = $year;
$nextyear = $year;
if ($month == 1) {
  $prevmonth = 12;
  $prevyear = $year - 1;
} elseif ($month == 12) {
  $nextmonth = 1;
  $nextyear = $year + 1;
}

$maxdate = date(t, mktime(0, 0, 0, $month, 1, $year));   // the final date of $month
$offset  = date(w, mktime(0, 0, 0, $month, 1, $year));
?>
<style type="text/css">
/* 카테고리 스타일*/
#box_day{width:3%; padding-left: 7px; padding-top: 4px; font-size:12px; font-family:돋움; font-weight:bold; float:left;}
#box_list{width:97%;}
#box_list2{width:97%; padding:5px 7px 5px 7px;}



a.day1:link, a.day1:visited, a.day1:active { font-size:14px; text-decoration:none; color:#9e9e9e; }
a.day1:hover { font-size:16px;color:#9e9e9e; text-decoration:underline; font-weight:bold; }

a.day2:link, a.day2:visited, a.day2:active { font-size:14px; text-decoration:none; color:#9e9e9e; }
a.day2:hover { font-size:16px;color:#9e9e9e; text-decoration:underline; font-weight:bold; }

a.day3:link, a.day3:visited, a.day3:active { font-size:14px; text-decoration:none; color:#9e9e9e; }
a.day3:hover { font-size:16px;color:#9e9e9e; text-decoration:underline; font-weight:bold; }

.day4 {font-size:20px;color:#333333;}
.day5 {font-family:돋움;font-size:14px;color:#6c91c3;}

.month_eng { color:#797979; }
.month_pre { color:#2c2c2c; font-weight:bold; }
</style>
<table width="100%" height="39" border="0" cellpadding="0" cellspacing="0" >
<tr>
<td align="center">
<div align="center">
<?
if ($month == 1) { 
	$year_pre=$year-1; $month_pre=12; 
} else {
	$year_pre=$year; $month_pre=$month-1;
}
switch($month_pre){

	case "1" : $month_eng="January"; break; 
	case "2" : $month_eng="February"; break;
	case "3" : $month_eng="March"; break;
	case "4" : $month_eng="April"; break;
	case "5" : $month_eng="May"; break;
	case "6" : $month_eng="June"; break;
	case "7" : $month_eng="July"; break;
	case "8" : $month_eng="August"; break;
	case "9" : $month_eng="September"; break;
	case "10" : $month_eng="October"; break;
	case "11" : $month_eng="November"; break;
	case "12" : $month_eng="December"; break;

}
?>
<?="<span class='month_eng'>".$month_eng."</span> <span class='month_pre'>".$month_pre."</span> "?>
<a href="<?="$_SERVER[PHP_SELF]?bo_table=$bo_table&"?><?echo ("year=$year_pre&month=$month_pre");?>" target="_self" onfocus="this.blur()"><img src="<?=$board_skin_path?>/img/m_prev.gif" border="0" title="<?=$month_pre?>월" align="abbottom" /></a>

</span><span class="day4"><?=$year?> -</span>
 <span class="day4">
<?=$month?>
</span>
<a href="<?="$_SERVER[PHP_SELF]?bo_table=$bo_table&"?><? if ($month == 12) { $year_pre=$year+1; $month_pre=1; } else {$year_pre=$year; $month_pre=$month+1;} echo ("&year=$year_pre&month=$month_pre");?>" target="_self" onfocus="this.blur()"><img src="<?=$board_skin_path?>/img/m_next.gif" border="0" title="<?=$month_pre?>월" align="abbottom" /></a>
<?
switch($month_pre){

	case "1" : $month_eng="January"; break; 
	case "2" : $month_eng="February"; break;
	case "3" : $month_eng="March"; break;
	case "4" : $month_eng="April"; break;
	case "5" : $month_eng="May"; break;
	case "6" : $month_eng="June"; break;
	case "7" : $month_eng="July"; break;
	case "8" : $month_eng="August"; break;
	case "9" : $month_eng="September"; break;
	case "10" : $month_eng="October"; break;
	case "11" : $month_eng="November"; break;
	case "12" : $month_eng="December"; break;

}
echo "<span class='month_pre'>".$month_pre."</span> <span class='month_eng'>".$month_eng."</span>" ;
?>
</div>	
</td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tbline1">
<tr>
	<td class="tbline2 bbs_head bbs_fhead" align="center" width="<?=$col_width?>">SUN</td>
	<td class="tbline2 bbs_head bbs_fhead" align="center" width="<?=$col_width?>">MON</td>
	<td class="tbline2 bbs_head bbs_fhead" align="center" width="<?=$col_width?>">TUE</td>
	<td class="tbline2 bbs_head bbs_fhead" align="center" width="<?=$col_width?>">WED</td>
	<td class="tbline2 bbs_head bbs_fhead" align="center" width="<?=$col_width?>">THU</td>
	<td class="tbline2 bbs_head bbs_fhead" align="center" width="<?=$col_width?>">FRI</td>
	<td class="tbline2 bbs_head bbs_fhead" align="center" width="<?=$col_width?>">SAT</td>
</tr>

<?
$cel_mon = sprintf("%02d",$month);
$query = "SELECT * FROM $write_table WHERE left(wr_link1,6) = '$year$cel_mon' ORDER BY wr_id ASC";
$result = sql_query($query);

// 내용을 보여주는 부분
while ($row = mysql_fetch_array($result)) {
	for ($i = 1 ; $i <= $maxdate;  $i++) {

		if( substr($row[wr_link1],6,2) == $i ) {
			switch ($row[wr_3]) {
			case 1 :
				$html_day[$i].= "<br><img src='$board_skin_path/img/dia_diary.gif' border=0 align=absmiddle>";
				break;
			case 2 :
				$html_day[$i].= "<br><img src='$board_skin_path/img/dia_memorial.gif' border=0 align=absmiddle>";
				break;
			case 3 :
				$html_day[$i].= "<br><img src='$board_skin_path/img/dia_schedual.gif' border=0 align=absmiddle>";
			    break;
			default :
				$html_day[$i].= "<br><img src='$board_skin_path/img/dia_review.gif' border=0 align=absmiddle>";
			}

			$html_day[$i].= "<a href='./board.php?bo_table=$bo_table&wr_id=$row[wr_id]'>".$row[wr_subject]."</a>"."\n";
		}
	}
}
?>

<?
// 달력의 틀을 보여주는 부분
$temp = 7 - (($maxdate + $offset)%7);
if ($temp == 7) $temp = 0;

$count_day  = 1;
$count_last = $maxdate + $offset + $temp;

for ($count = 1; $count <= $count_last; $count++) {

	if (($count%7) == 1) echo ("<tr>\n"); // 주당 7개씩 한쎌씩을 쌓는다.

	// 날짜가 있을경우
	if ($offset < $count  &&  $count <= $maxdate + $offset)	{
		$daytext = "$count_day";   // $count_day 는 숫자

		$bgcolor = "#FFFFFF"; //일반날짜

		if ($thisyear==$year && $thismonth==$month && $thisday==$count_day) $bgcolor = "#FFFFFF"; //오늘날짜

		if ($count%7 == 1) {$daytext = "<font color=#ce1313>$daytext</font>"; $bgcolor = "#FFFFFF";} // 일요일
		if ($count%7 == 0) {$daytext = "<font color=#1e43cd>$daytext</font>"; $bgcolor = "#FFFFFF";} // 토요일

		$tmp = sprintf("%02d",$month)."-".sprintf("%02d",$count_day);
		if ($nal[$tmp])	{
			$title = trim($nal[$tmp][1]);
			$title1 = cut_str($title,8);
			if (trim($nal[$tmp][2]) == "*") {
				$daytext = "<font color=#FF0000>$daytext</font> <font color=#804180><a title=$title>$title1</a></font>";
				$bgcolor = "#FEFAFF";
			} //공휴일
			else {
				$daytext = "$daytext <font color=#804180><a title=$title>$title1</a></font>";
			}
		}

		// 여기까지 숫자와 들어갈 내용에 대한 변수들의 세팅이 끝나고

		// 이제 여기 부터 직접 셀이 그려지면서 그 안에 내용이 들어 간다.
		echo ("<td height=$col_height class='tbline2 padding2' bgcolor=$bgcolor valign=top>\n");

		 //글쓰기 권한여부
		if ($write_href) {
			$f_date = $year.sprintf("%02d",$month).sprintf("%02d",$count_day);
			echo " <a href='$write_href&write[wr_link1]=$f_date'>$daytext</a>\n";
		}
		else {
			echo "$daytext\n";
		}

		echo $html_day[$count_day];
		echo ("</td>\n");  // 한칸을 마무리

	$count_day++; // 날짜를 카운팅
	}

	// 날짜가 없을경우
	else { echo ("<td height=$col_height class=tbline2 bgcolor=#FFFFFF valign=top>&nbsp;</td>\n"); }

	if (($count%7) == 0) echo ("</tr>\n");
}
?>

</table>