<?
@extract($_GET);
@extract($_POST);




function SkipOffset($no) {
  for ($i = 1; $i <= $no; $i++) { echo " <TD style='visibility:hidden'><p></p></TD> \n"; }
}

if($min){
	$thisyear  = date('Y', strtotime($min));  // 2000
	$thismonth = date('n', strtotime($min));  // 1, 2, 3, ..., 12
	$thisday   = date('j', strtotime($min));  // 1, 2, 3, ..., 31
}else{
	//---- 오늘 날짜
	$thisyear  = date('Y');  // 2000
	$thismonth = date('n');  // 1, 2, 3, ..., 12
	$thisday   = date('j');  // 1, 2, 3, ..., 31
}


if($max) {
	$maxyear  = date('Y', strtotime($max));  // 2000
	$maxmonth = date('n', strtotime($max));  // 1, 2, 3, ..., 12
	$maxday   = date('j', strtotime($max));  // 1, 2, 3, ..., 31
}

//캘린더 고유 ID
$uid = $_REQUEST[uid];

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


$year2 = date(Y, mktime(0, 0, 0, $month+1, 1, $year));
$month2 = date(n, mktime(0, 0, 0, $month+1, 1, $year));
$maxdate2 = date(t, mktime(0, 0, 0, $month+1, 1, $year));   // the final date of $month

$prevmonth2 = $month2-1 ;
$nextmonth2 = $month2+1 ;
$prevyear2 = $year2;
$nextyear2 = $year2;
if ($month2 == 1) {
  $prevmonth2 = 12;
  $prevyear2 = $year2 - 1;
} elseif ($month2 == 12) {
  $nextmonth2 = 1;
  $nextyear2 = $year2 + 1;
}

$ti_link2 = "";
?>

<!-- 달력시작 -->
<input type="hidden" id="dc__year" value="<?=$year?>" />
<input type="hidden" id="dc__month" value="<?=$month?>" />

<input type="hidden" id="dc__year_<?=$uid?>" value="<?=$year?>" />
<input type="hidden" id="dc__month_<?=$uid?>" value="<?=$month?>" />


<div class="Calendarbox <?=$uid?> ">
	<div class="Calendartop">
		<ul>	
			<li>
				
				<?if($islimit == "false" || !($year == $thisyear &&  $month == $thismonth)){?>
					<a href='javascript:dc__load_calendar("<?=$prevyear?>", "<?=$prevmonth?>", "<?=$uid?>", false, "<?=$min?>", "<?=$max?>")'>
						<img src="/res/images/cal_left.jpg" alt="이전달" />
					</a>
				<?}?>
			</li>
			<li class="leftt"><?=$year?>.<span><?=str_pad($month, 2, 0, STR_PAD_LEFT)?></span></li>
			<li class="rightt">	<?=$year2?>.<span><?=str_pad($month2, 2, 0, STR_PAD_LEFT)?></span></li>
			<li class="right">
				<a href='javascript:dc__load_calendar("<?=$nextyear?>","<?=$nextmonth?>", "<?=$uid?>", false, "<?=$min?>", "<?=$max?>")'>
					<img src="/res/images/cal_right.jpg" alt="다음달" />
				</a>
			</li>
		</ul>
	</div>
	<div class="Calendercon">
		<div class="Calenderconl">

			<table class="c1" summary="캘린더입니다">
				<colgroup>
					<col />
					<col />
					<col />
					<col />
					<col />
					<col />
					<col />
				</colgroup>
				<thead>
				  <tr>
					<th scope="col" class="th-left">SUN</th>
					<th scope="col">MON</th>
					<th scope="col">TUE</th>
					<th scope="col">WED</th>
					<th scope="col">THU</th>
					<th scope="col">FRI</th>
					<th scope="col">SAT</th>
				  </tr>
				</thead>
				<tbody>
					<?
						$date = 1;
						while ($date <= $maxdate) {
						  $offset = date('w', mktime(0, 0, 0, $month, $date, $year));  // 0: sunday, 1: monday, ..., 6: saturday
						  if ($date == '1') {
						    SkipOffset($offset);
						  }

						  if ( $date == $thisday  &&  $year == $thisyear &&  $month == $thismonth) {
						    $cstyle = 'today';
						  } else {
						    $cstyle = 'dc__valid';
						  }
						  

						  switch ($offset) {            // 요일에 따라 날짜의 색깔 결정
						    case 0: $dstyle = 'dc__sunday';
							    break;
						    case 6: $dstyle = 'dc__saturday';
							    break;
						    default: $dstyle = 'dc__weekday';
						  }

							$tmp = sprintf("%02d",$month)."-".sprintf("%02d",$date);
							if ($nal[$tmp])	{ if (trim($nal[$tmp][2]) == "*") {	$dstyle = "sunday";	} }//공휴일

						  $date_array = array(sprintf('%04d', $year), sprintf('%02d', $month), sprintf('%02d', $date));
						  $date_stext = implode("", $date_array);


						  
						  $date_link = "{$date}";
						  if($islimit != "false"){
							  if((mktime(0, 0, 0, $month, $date, $year)-mktime(0, 0, 0, $thismonth, $thisday, $thisyear))/86400 < 0){
								$cstyle = 'td-off';
							  }
							  else if($max && (mktime(0, 0, 0, $maxmonth, $maxday, $maxyear)-mktime(0, 0, 0, $month, $date, $year))/86400 < 0){
								$cstyle = 'td-off';
							  }

						  }

						if($sday == date("Ymd", mktime(0, 0, 0, $month, $date, $year)))
							$cstyle = 'td-select on';

						$onclick = "";
						if($cstyle != 'td-off' && $cstyle != 'td-none'){
							$onclick = "onclick='dc__inputDate(\"$date_stext\", \"$uid\")'";
							$onhref = "href='javascript:;'";
							if($offset == 0 || $offset == 6) {
								$cstyle .= " td-weekend";
							}
						}

						  echo "<TD id='{$uid}{$date_stext}' class='$cstyle' style='cursor:pointer' $onclick >";
						  if($cstyle != "td-off") echo "<a $onhref' class='$cstyle'>";
						  echo $date_link;
						  if($cstyle != "td-off") echo "</a>";
						  echo "</TD>\n"; 


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
				</tbody>
			</table>
		</div>
		<div class="Calenderconr">
		<table class="c1" summary="캘린더입니다">
				<colgroup>
					<col />
					<col />
					<col />
					<col />
					<col />
					<col />
					<col />
				</colgroup>
				<thead>
				  <tr>
					<th scope="col" class="th-left">SUN</th>
					<th scope="col">MON</th>
					<th scope="col">TUE</th>
					<th scope="col">WED</th>
					<th scope="col">THU</th>
					<th scope="col">FRI</th>
					<th scope="col">SAT</th>
				  </tr>
				</thead>
				<tbody>
					<?
						$date = 1;
						while ($date <= $maxdate2) {
 					      $offset = date('w', mktime(0, 0, 0, $month2, $date, $year2));  // 0: sunday, 1: monday, ..., 6: saturday
						  if ($date == '1') {
						    SkipOffset($offset);
						  }

						  if ( $date == $thisday  &&  $year == $thisyear &&  $month+1 == $thismonth) {
						    $cstyle = 'today';
						  } else {
						    $cstyle = 'dc__valid';
						  }

						  switch ($offset) {            // 요일에 따라 날짜의 색깔 결정
						    case 0: $dstyle = 'dc__sunday';
							    break;
						    case 6: $dstyle = 'dc__saturday';
							    break;
						    default: $dstyle = 'dc__weekday';
						  }

						 $tmp = sprintf("%02d",$month2)."-".sprintf("%02d",$date);
						  if ($nal[$tmp])	{ if (trim($nal[$tmp][2]) == "*") {	$dstyle = "sunday";	} }//공휴일

						  $date_array = array(sprintf('%04d', $year2), sprintf('%02d', $month2), sprintf('%02d', $date));
						  $date_stext = implode("", $date_array);


						  $date_link = "{$date}";

						  if($islimit != "false"){
			
								if((mktime(0, 0, 0, $month2, $date, $year2)-mktime(0, 0, 0, $thismonth, $thisday, $thisyear))/86400 < 0){
									$cstyle = 'td-off';
								}
								else if($max && (mktime(0, 0, 0, $maxmonth, $maxday, $maxyear)-mktime(0, 0, 0, $month2, $date, $year2))/86400 < 0){
									$cstyle = 'td-off';
								}
						   }

						  if($sday == date("Ymd", mktime(0, 0, 0, $month2, $date, $year2)))
							$cstyle = 'td-select on';


							
							$onclick = "";
							if($cstyle != 'td-off' && $cstyle != 'td-none'){
								$onclick = "onclick='dc__inputDate(\"$date_stext\", \"$uid\")'";
								$onhref = "href='javascript:;'";
								if($offset == 0 || $offset == 6) {
									$cstyle .= " td-weekend";
								}
							}


						  echo "<TD id='{$uid}{$date_stext}' class='$cstyle' style='cursor:pointer' $onclick >";
						  if($cstyle != "td-off") echo "<a $onhref' class='$cstyle'>";
						  echo $date_link;
						  if($cstyle != "td-off") echo "</a>";
						  echo "</TD>\n"; 



						  $date++;
						  $offset++;

						  if ($offset == 7) {
						    echo "</TR> \n";
						    if ($date <= $maxdate2) {
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
				</tbody>
			</table>
		</div>
	</div>
	<?if($caption != "false"){?>
	<div class="Cdetail">
		<ul>
			<li class="none"></li>
			<li id='noss_<?=$uid?>' class="none2"></li>
			<li class="select"></li>
			<li id='sssddd_<?=$uid?>'></li>
		</ul>
	</div>
	<?}?>
</div>
<!-- 달력끝 -->
<script type='text/javascript'>
	$("#sssddd_<?=$uid?>").html("선택한 일정");
	$("#noss_<?=$uid?>").html("선택불가");
</script>
