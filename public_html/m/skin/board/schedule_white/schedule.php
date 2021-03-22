<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$cellh  = 21;
$cellw  = 21;

$f = @file("$g4[path]/bbs/calendar/$year.txt");
if ($f) {
	while ($line = each($f)) {
		$tmp = explode("|", $line[value]);
        $nal[$tmp[0]] = $tmp;
    }
}
?>

<style type="text/css">
td.title    {text-align: center; height: 25px; font-weight:bold;}
td.invalid  {
	text-align: center; height:<?=$cellh?>; width:<?=$cellh?>;
	background-image: url(<?=$g4[path]?>/img/calendar/mini1.gif);
}

td.valid    {
	text-align: center; height:<?=$cellh?>; width:<?=$cellh?>;
	background-image: url(<?=$g4[path]?>/img/calendar/mini2.gif);
}

td.today    {
	text-align: center; height:<?=$cellh?>; width:<?=$cellh?>;
	background-image: url(<?=$g4[path]?>/img/calendar/mini3.gif);
}

p.title     {font-size: 1em; font-weight:bold}
p.sunday    {text-align: center; font-size: 8pt; color: #ff00ff;}
p.saturday  {text-align: center; font-size: 8pt; color: #3366cc;}
p.weekday   {text-align: center; font-size: 8pt;}

a:link.writeday, a:visited.writeday  {text-align: center; font-size: 8pt; color: #fd7100;}
</style>

<?
function SkipOffset($no)
{
  for ($i = 1; $i <= $no; $i++) {
    echo " <TD class=invalid><p></p></TD> \n";
  }
}

//---- 오늘 날짜
$thisyear  = date('Y');  // 2000
$thismonth = date('n');  // 1, 2, 3, ..., 12
$thisday   = date('j');  // 1, 2, 3, ..., 31

//------ $year, $month 값이 없으면 현재 날짜
if (!$year) { $year = $thisyear; }
if (!$month) { $month = $thismonth; }

//------ 날짜의 범위 체크
if (($year > 9999) or ($year < 0)){
	alert("연도는 0~9999년만 가능합니다.");
}

if (($month > 12) or ($month < 0)){
	alert("달은 1~12만 가능합니다.");
}

$maxdate = date(t, mktime(0, 0, 0, $month, 1, $year));   // the final date of $month

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

$ti_link = "";

if($bo_table) {
	$s_month = sprintf("%02d",$month);
	$sql = "select count(wr_id) as blog_count, substring(wr_1, 7, 2) as blog_day
		    from g4_write_$bo_table
			where left(wr_1, 6) >= '$year$s_month' and left(wr_1, 6) <= '$year$s_month'
			group by left(wr_1, 8) ";
	$result = sql_query($sql);

	$write_blog = array_fill(1,$maxdate,-1);

	for ($i = 0; $row = mysql_fetch_array($result); $i++) {
		$row[blog_day] = sprintf("%d",$row[blog_day]);
		$write_blog[$row[blog_day]] = $row[blog_count];
	}
	mysql_free_result($result);

	$ti_link = "board.php";
}
?>

<TABLE width="<?=$cellw*7?>" cellspacing="0" cellpadding="0" border="0">
<TR>
	<TD width=100% colspan=7 class=title>
		<a href="<?=$ti_link?>?bo_table=<?=$bo_table?>&mode=m&year=<?=$prevyear?>&month=<?=$prevmonth?>">
		<img src='<?=$g4[path]?>/img/calendar/first.gif' border=0 align=absmiddle width=17 height=13>
		</a>
	    <?=$year?> 년 <?=$month?> 월
		<a href="<?=$ti_link?>?bo_table=<?=$bo_table?>&mode=m&year=<?=$nextyear?>&month=<?=$nextmonth?>">
		<img src='<?=$g4[path]?>/img/calendar/end.gif' border=0 align=absmiddle width=17 height=13>
		</a>
	</TD>
</TR>

<TR>
	<td class=sunday><p class=sunday>일</p></td>
	<td class=weekday><p class=weekday>월</p></td>
	<td class=weekday><p class=weekday>화</p></td>
	<td class=weekday><p class=weekday>수</p></td>
	<td class=weekday><p class=weekday>목</p></td>
	<td class=weekday><p class=weekday>금</p></td>
	<td class=saturday><p class=saturday>토</p></td>
</TR>

<TR>
<?
$date = 1;
while ($date <= $maxdate) {
  if ($date == '1') {
    $offset = date('w', mktime(0, 0, 0, $month, $date, $year));  // 0: sunday, 1: monday, ..., 6: saturday
    SkipOffset($offset);
  }

  if ( $date == $thisday  &&  $year == $thisyear &&  $month == $thismonth) {
    $cstyle = 'today';
  } else {
    $cstyle = 'valid';
  }

  switch ($offset) {            // 요일에 따라 날짜의 색깔 결정
    case 0: $dstyle = 'sunday';
            break;
    case 6: $dstyle = 'saturday';
            break;
    default: $dstyle = 'weekday';
  }

	$tmp = sprintf("%02d",$month)."-".sprintf("%02d",$date);
	if ($nal[$tmp])	{ if (trim($nal[$tmp][2]) == "*") {	$dstyle = "sunday";	} }//공휴일

  $date_array = array(sprintf('%04d', $year), sprintf('%02d', $month), sprintf('%02d', $date));
  $date_stext = implode("", $date_array);

  if($bo_table && $write_blog[$date] > 0) {
  	$date_link = "<p><a href='board.php?bo_table=$bo_table&mode=d&year=$year&month=$month&day=$date' class=writeday>{$date}</p>";
  } else {
	$date_link = "<p class=$dstyle>{$date}</p>";
  }

  echo " <TD class=$cstyle>{$date_link}</TD> \n";

  $date++;
  $offset++;

  if ($offset == 7) {
    echo "</TR> \n";
    if ($date <= $maxdate) {
      echo "<TR> \n";
    }
    $offset = 0;
  }

} // end of while

if ($offset != 0) {
  SkipOffset((7-$offset));
  echo "</TR> \n";
}
?>
</TABLE>
