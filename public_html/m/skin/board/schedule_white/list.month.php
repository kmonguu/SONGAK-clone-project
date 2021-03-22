<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

//가로 세로 폭 지정
if (eregi('%', $width)) { $col_width = "14%"; }
else { $col_width = round($width/7); }

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
<!--년, 월 form 스크립트 -->
<script language="JavaScript">
<!--
function namosw_goto_byselect(sel, targetstr)
{
  var index = sel.selectedIndex;
  if (sel.options[index].value != '') {
     if (targetstr == 'blank') {
       window.open(sel.options[index].value, 'win1');
     } else {
       var frameobj;
       if (targetstr == '') targetstr = 'self';
       if ((frameobj = eval(targetstr)) != null)
         frameobj.location = sel.options[index].value;
     }
  }
}

// 레이어 뷰 스크립트
var iDelay = 80 // Delay to hide in milliseconds
var iNSWidth=250 // Default width for netscape
var sDisplayTimer = null, oLastItem

function getRealPosition(i,which) {
	iPos = 0
	while (i!=null) {
	 	iPos += i["offset" + which]
		i = i.offsetParent
	}
	return iPos
}
function showLayers(sDest,itop,ileft,iWidth) {
	if (document.all!=null) {
		var i = window.event.srcElement
		stopTimer()
		dest = document.all[sDest]
		if ((oLastItem!=null) && (oLastItem!=dest))
			hideItem()
		if (dest) {
			// Netscape Hack
			if (i.offsetWidth==0)
				if (iWidth)
					i.offsetWidth=iWidth
				else
					i.offsetWidth=iNSWidth;
			if (ileft)
				dest.style.pixelLeft = ileft
			else
			dest.style.pixelLeft = getRealPosition(i,"Left") - 5 // 불러오는 메뉴 좌표
//			dest.style.pixelLeft = getRealPosition(i,"Left") + i.offsetWidth *0.1 // 불러오는 메뉴 좌표
			if (itop)
				dest.style.pixelTop = itop
			else
			   	dest.style.pixelTop = getRealPosition(i,"Top") + 15 // 불러오는 메뉴 좌표
			dest.style.visibility = "visible"
		}
		oLastItem = dest
	}
}

function stopTimer() {
	clearTimeout(sDisplayTimer)
}

function startTimer(el) {
	if (!el.contains(event.toElement)) {
		stopTimer()
		sDisplayTimer = setTimeout("hideItem()",iDelay)
	}
}

function hideItem() {
	if (oLastItem)
		oLastItem.style.visibility="hidden"
}

function checkOver() {
	if ((oLastItem) && (oLastItem.contains(event.srcElement))) {
		stopTimer()
	}
}

function checkOut() {
	if (oLastItem==event.srcElement)
		startTimer(event.srcElement)
}

document.onmouseover = checkOver
document.onmouseout = checkOut
//-->
</SCRIPT>
<style type="text/css">
/* 카테고리 스타일*/
#box_day{width:45px; padding-left: 7px; padding-top: 4px; font-size:12pt; font-family:돋움; font-weight:bold; float:left;}
#box_list{width:100%;}
#box_list2{width:100%; padding:5px 0px 5px 7px;}

#box00{width:60px;float:left;}
#box01{width:80px;float:left;}
#box02{width:80px;float:right;}
#box03{width:100px;float:left;}
#box04{width:100px;float:left;}
#box05{width:60px;float:left;}

a.day1:link, a.day1:visited, a.day1:active { font-size:14px; text-decoration:none; color:#9e9e9e; }
a.day1:hover { font-size:16px;color:#9e9e9e; text-decoration:underline; font-weight:bold; }

a.day2:link, a.day2:visited, a.day2:active { font-size:14px; text-decoration:none; color:#9e9e9e; }
a.day2:hover { font-size:16px;color:#9e9e9e; text-decoration:underline; font-weight:bold; }

a.day3:link, a.day3:visited, a.day3:active { font-size:14px; text-decoration:none; color:#9e9e9e; }
a.day3:hover { font-size:16px;color:#9e9e9e; text-decoration:underline; font-weight:bold; }

.day4 {font-size:20px;color:#1641b2;}
.day5 {font-family:돋움;font-size:14px;color:#6c91c3;}
</style>

<table width="100%" height="39" border="0" cellpadding="0" cellspacing="0" background="<?=$board_skin_path?>/img/bar_bg.gif"">
<tr>
	<td width="10">&nbsp;</td>
	<td valign="bottom">
	<a href='board.php?bo_table=<?=$bo_table?>&mode=m2'><img src="<?=$board_skin_path?>/img/btn_s2_01.gif"></a><a href='board.php?bo_table=<?=$bo_table?>&mode=m'><img src="<?=$board_skin_path?>/img/btn_s_02.gif"></a></td>
	<td align="right">

<div align="right">
</span><span class="day4"><?=$year?></span><span class="day5">년</span>
<a href="<?="$_SERVER[PHP_SELF]?bo_table=$bo_table&"?><?if ($month == 1) { $year_pre=$year-1; $month_pre=$month; } else {$year_pre=$year-1; $month_pre=$month;} echo ("year=$year_pre&month=$month_pre");?>" target="_self" onfocus="this.blur()"><img src="<?=$board_skin_path?>/img/y_prev.gif" border="0" title="<?=$year_pre?>년" align="abbottom" /></a> <a href="<?="$_SERVER[PHP_SELF]?bo_table=$bo_table&"?><?if ($month == 12) { $year_pre=$year+1; $month_pre=$month; } else {$year_pre=$year+1; $month_pre=$month;} echo ("&year=$year_pre&month=$month_pre");?>" target="_self" onfocus="this.blur()"><img src="<?=$board_skin_path?>/img/y_next.gif" border="0" title="<?=$year_pre?>년" align="abbottom" /></a> <span class="day4">
<?=$month?>
</span><span class="day5">월</span> <a href="<?="$_SERVER[PHP_SELF]?bo_table=$bo_table&"?><?if ($month == 1) { $year_pre=$year-1; $month_pre=12; } else {$year_pre=$year; $month_pre=$month-1;} echo ("year=$year_pre&month=$month_pre");?>" target="_self" onfocus="this.blur()"><img src="<?=$board_skin_path?>/img/m_prev.gif" border="0" title="<?=$month_pre?>월" align="abbottom" /></a> <a href="<?="$_SERVER[PHP_SELF]?bo_table=$bo_table&"?><? if ($month == 12) { $year_pre=$year+1; $month_pre=1; } else {$year_pre=$year; $month_pre=$month+1;} echo ("&year=$year_pre&month=$month_pre");?>" target="_self" onfocus="this.blur()"><img src="<?=$board_skin_path?>/img/m_next.gif" border="0" title="<?=$month_pre?>월" align="abbottom" /></a></div>	</td>
</tr>
</table>

<table width="100%" border="0" background="<?=$board_skin_path?>/img/bar_bg2.gif">
  <tr>
    <td>
<div id='box00' align="center"><font color=#000000>날짜</font></div>
<div id='box01' align="center"><font color=#000000>행사명</font></div>
<div id='box02'><font color=#000000>작성자</font></div>
<div id='box03'><font color=#000000>주관</font></div>
<div id='box03' align="center"><font color=#000000>장소</font></div>
<div id='box05'><font color=#000000>시간</font></div></td>
  </tr>
</table>


<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tbline3">
<?
$cel_mon = sprintf("%02d",$month);
$query = "SELECT * FROM $write_table WHERE left(wr_link1,6) = '$year$cel_mon' ORDER BY wr_id ASC";
$result = sql_query($query);

// 내용을 보여주는 부분
$j++; // layer ID
while ($row = mysql_fetch_array($result)) {
	for ($i = 1 ; $i <= $maxdate;  $i++) {

	if( substr($row[wr_link1],6,2) == $i ) {


	$html_day[$i].= "<div id='box_list2'>
	<div id='box01'><a ".$functionlayer."=\"showLayers('popup_schd".$j."')\" onmouseout=\"startTimer(this)\"  href='$g4[bbs_path]/board.php?bo_table=$bo_table&year=$year&month=$month&wr_id=$row[wr_id]' class=schedule><font color=#e04f00>".$row[wr_subject]. "</font></a></div>
	<div id='box02'><font color=#8b8b8b>$row[wr_name]</font></div>
	<div id='box03'><font color=#8b8b8b>$row[wr_5]</font></div>
	<div id='box03'><<font color=#8b8b8b>$row[wr_7]</font></div>
	<div id='box04'><font color=#8b8b8b>$row[wr_6]</font></div></div>
	<div style='height:1px; line-height:1px; font-size:1px; background-color:#f7f7f7; clear:both;'>&nbsp;</div>"."\n";
	}
}
}
?>
<DIV ID=popup_schd<?=$j?> onmouseout="startTimer(event.srcElement)" style="BORDER-RIGHT: #DCD0AE 1px solid; BORDER-TOP: #DCD0AE 1px solid; BORDER-LEFT: #DCD0AE 1px solid; BORDER-BOTTOM: #DCD0AE 1px solid;  BACKGROUND-COLOR: #FFECA8; FILTER: alpha(opacity=90); padding: 5 5 5 5; POSITION:absolute; width:400px; top:-200px; visibility: hidden; Z-INDEX:1;">
<?
$html = 0;
if (strstr($row[wr_option], "html1"))
    $html = 1;
else if (strstr($row[wr_option], "html2"))
    $html = 2;
$viewlist = cut_str(conv_content($row[wr_content], $html),1000,"…");
echo "<b>작성자 : ".$row[wr_name]."</b><br>";
echo "<br>";
echo $viewlist;
?>
</DIV>
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

	if ($count%7 == 1) {$daytext = "<font color=#f10707>$daytext</font>"; $bgcolor = "#FEFAFF";} // 일요일
	if ($count%7 == 0) {$daytext = "<font color=#3b86e7>$daytext</font>"; $bgcolor = "#F0F8FF";} // 토요일
	if ($thisyear==$year && $thismonth==$month && $thisday==$count_day) {$daytext = "<font color=#888888>$daytext</font>"; $bgcolor = "#ecff98";} //오늘날짜

		$tmp = sprintf("%02d",$month)."-".sprintf("%02d",$count_day);
		if ($nal[$tmp])	{
			$title = trim($nal[$tmp][1]);
			$title1 = cut_str($title,8);
			if (trim($nal[$tmp][2]) == "*") {
				$daytext = "<span class='day1'>$daytext</span></br><span style='font:normal 11px tahoma; color:#804180;'>$title1</span>";
				$bgcolor = "#FEFAFF";
			} //공휴일
			else {
				$daytext = "$daytext</br><span style='font:normal 11px tahoma; color:#804180;'>$title1</span>";
			}
		}

		// 여기까지 숫자와 들어갈 내용에 대한 변수들의 세팅이 끝나고

		// 이제 여기 부터 직접 셀이 그려지면서 그 안에 내용이 들어 간다.
		echo ("<tr><td class=tbline3 bgcolor=$bgcolor valign=top onmouseover=this.style.backgroundColor='#F8FFDA' onmouseout=this.style.backgroundColor=''>\n");

		 //글쓰기 권한여부
		if ($write_href) {
			$f_date = $year.sprintf("%02d",$month).sprintf("%02d",$count_day);
			echo "<div id='box_day' align='center'><a href='$write_href&write[wr_link1]=$f_date'>$daytext</a></div>\n";
		}
		else {
			echo "<div id='box_day' align='center'>$daytext</div>\n";
		}

		echo "<div id='box_list'>$html_day[$count_day]</div>\n";
		echo ("</td></tr>\n");  // 한칸을 마무리

	$count_day++; // 날짜를 카운팅
	}

	// 날짜가 없을경우
	else { echo ("\n"); }

	if (($count%7) == 0) echo ("</tr>\n");
}
?>

</table>