<?
include_once("./_common.php");
auth_check($auth[$sub_menu], "r");

$g4[title] = "메시지 발송 내역";
include_once("{$g4["admin_path"]}/admin.head.php");


$obj = new Sms4Stat();


if(!$sch_year){
	$sch_year = date("Y");
	$sch_month = date("m");
}

$sch_sdate = date("Y-m-01", strtotime("{$sch_year}{$sch_month}01"));
$sch_edate = date("Y-m-t", strtotime($sch_sdate));

$tmpSdate = date("Y-m-15", strtotime($sch_sdate));

$nextDate = date("Y-m-01", strtotime("{$tmpSdate} +30 Days"));
$nextYear = date("Y", strtotime($nextDate));
$nextMonth = date("m", strtotime($nextDate));

$prevDate = date("Y-m-01", strtotime("{$tmpSdate} -30 Days"));
$prevYear = date("Y", strtotime("{$prevDate}"));
$prevMonth = date("m", strtotime("{$prevDate}"));



$qstr .= "&sch_year=$sch_year&sch_month=$sch_month";


$list = array();
?>




<div class="Totalot2">	

	<form name="schform" id="schform" method="get" >
		<input type="hidden" name="p" value="<?=$p?>" />
		<div class="Topbar">
		
			<span style="position:relative;cursor:pointer;" onclick="$('#sch_year').val('<?=$prevYear?>');$('#sch_month').val('<?=$prevMonth?>');$('#schform').submit();"><span style="position:absolute;top:-3px;left:0;"><img src="/res/images/left01_btn.jpg" /></span></span>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
			<select class="Tselcet01" name="sch_year" id="sch_year" onchange="$('#schform').submit();">
				<?for($yy = date("Y") + 1 ; $yy >= 2008 ; $yy--) {?>
					<option value="<?=$yy?>" <?=$yy == $sch_year ? "selected" : ""?> ><?=$yy?></option>
				<? }?>
			</select>년
			&nbsp;
			<select class="Tselcet01" name="sch_month" id="sch_month" onchange="$('#schform').submit();">
				<? for($mm=1 ; $mm <= 12; $mm++){ $mstr = sprintf("%02d", $mm);?>
					<option value="<?=$mstr?>" <?=$mstr == $sch_month ? "selected" : ""?> ><?=$mstr?></option>
				<? }?>
			</select>월
			&nbsp;
			
			<span style="position:relative;cursor:pointer" onclick="$('#sch_year').val('<?=$nextYear?>');$('#sch_month').val('<?=$nextMonth?>');$('#schform').submit();"><span style="position:absolute;top:-3px;left:0;"><img src="/res/images/right01_btn.jpg" /></span></span>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
		</div>
		
		
	</form>
	
	
	
	
<?
//---- 오늘 날짜
$thisyear  = date('Y');  // 2000
$thismonth = date('n');  // 1, 2, 3, ..., 12
$thisday   = date('j');  // 1, 2, 3, ..., 31

$year  = date('Y', strtotime($sch_sdate));  // 2000
$month = date('n', strtotime($sch_sdate));  // 1, 2, 3, ..., 12
$day   = date('j', strtotime($sch_sdate));  // 1, 2, 3, ..., 31

if ($month == 1) {
	$year_pre=$year-1; $month_pre=12;
} else {
	$year_pre=$year; $month_pre=$month-1;
}

$maxdate = date(t, mktime(0, 0, 0, $month, 1, $year));   // the final date of $month
$offset  = date(w, mktime(0, 0, 0, $month, 1, $year));

$col_height= 80 ;
?>

<table class="t3" summary="">
	<thead>
		  <tr>
			<th class="tbline2 bbs_head bbs_fhead" align="center" width="14%">SUN</th>
			<th class="tbline2 bbs_head bbs_fhead" align="center" width="14%">MON</th>
			<th class="tbline2 bbs_head bbs_fhead" align="center" width="14%">TUE</th>
			<th class="tbline2 bbs_head bbs_fhead" align="center" width="14%">WED</th>
			<th class="tbline2 bbs_head bbs_fhead" align="center" width="14%">THU</th>
			<th class="tbline2 bbs_head bbs_fhead" align="center" width="15%">FRI</th>
			<th class="tbline2 bbs_head bbs_fhead" align="center" width="15%">SAT</th>
		</tr>
	</thead>



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

		if ($thisyear==$year && $thismonth==$month && $thisday==$count_day) $bgcolor = "#dff5ff"; //오늘날짜
		
		$td=$daytext; 
		if ($count%7 == 1) {$daytext = "<font color=#ce1313>$daytext</font>"; $bgcolor = "#FFFFFF";} // 일요일
		if ($count%7 == 0) {$daytext = "<font color=#1e43cd>$daytext</font>"; $bgcolor = "#FFFFFF";} // 토요일
		

		$tm = str_pad($month, 2, "0", STR_PAD_LEFT);
		$td = str_pad($td, 2, "0", STR_PAD_LEFT);
    
        $onclick = "";
        
        $dv = $obj->stat_date("{$year}-{$tm}-{$td}");
		if($dv[0]["tot"] > 0) {
			$onclick = " onclick=\"location.href='./form.php?sch_date={$year}-{$tm}-{$td}';\" ";
		}
		
		//$daytext = "<a href='./pages.php?p={$p}&action=form&sch_date={$year}-{$tm}-{$td}'>".$daytext."</a>";


		$daytext = "$daytext <font color=#804180><a title=$title>$title1</a></font>";
			

		echo ("<td height=$col_height $onclick style='cursor:pointer; height:{$col_height}px; font-weight:bold;font-size:14px; vertical-align:top; text-align:left;'>\n");

		
		echo $daytext;
		
		if($dv[0]["tot"] > 0) {
			$st = $dv[0];
			echo "
				<div style='border:0px solid gray; font-weight:normal; font-size:12px; color:gray; padding:8px 20px 8px; 20px; line-height:1.8;'>
						성공 : <span style='display:inline-block; width:70px; text-align:right;'>{$st["succ"]}</span><br/>
						실패 : <span style='display:inline-block; width:70px; text-align:right;'>{$st["fail"]}</span>
				</div>
            ";
            
            $st["date"] = "{$year}-{$tm}-{$td}";
            $list[] = $st;
		}
		
		echo ("</td>\n");  // 한칸을 마무리

	$count_day++; // 날짜를 카운팅
	}

	// 날짜가 없을경우
	else { echo ("<td height=$col_height class=tbline2 bgcolor=#FFFFFF valign=top>&nbsp;</td>\n"); }

	if (($count%7) == 0) echo ("</tr>\n");
}
?>

</table>



<br/>


	<table class="t3" summary="">
		<colgroup>
			<col width="350px" />
			<col width="150px" />
			<col width="150px" />
			<col width="150px" />
			<col />
		</colgroup>
		<thead>
		  <tr>
			<th scope="col" class="th-left">날짜</th>
			<th scope="col">성공</th>
			<th scope="col">실패</th>
			<th scope="col">합계</th>
			<th scope="col"></th>
		  </tr>
		</thead>
		<tbody>
		
			<?for ($i=0; $i < count($list); $i++) { $row = $list[$i];

				
				$tot_succ += $row["succ"];
				$tot_fail += $row["fail"];
				$tot_cnt += $row["tot"];
			?>
				<tr class="colorhover">
					<td class="td-left"><?=$row["date"]?></td>
					<td ><?=number_format($row["succ"])?></td>
					<td ><?=number_format($row["fail"])?></td>
					<td ><?=number_format($row["tot"])?></td>
					
					<td class="link3">
						<span class="Btn3 link3"><a href="./form.php?sch_date=<?=$row["date"]?>&<?=$qstr?>">상세보기</a></span>
					</td>	
				</tr>
			<?}?>
			
			<? if(count($list) == 0) {?>
				<tr class="colorhover">
					<td colspan="5">SMS전송기록이 없습니다.</td>
				</tr>
			<? } else {?>
				
				<tr class="colorhover" style="background-color:#ededed; height:40px;" >
					<th scope="col"  class="th-left">합계</th>
					<th scope="col" class="blue"><?=number_format($tot_succ)?></th>
					<th scope="col" class="red"><?=number_format($tot_fail)?></th>
					<th scope="col"><?=number_format($tot_cnt)?></th>
					<th scope="col"></th>
				</tr>
				
			<? }?>

           


		
		</tbody>
	</table>

    
    <?
    $statTmp = $obj->stat_date();
    $stat = $statTmp[0];
    ?>
	<table class="t3" summary="" style="margin-top:20px;">
		<colgroup>
			<col width="350px" />
			<col width="150px" />
			<col width="150px" />
			<col width="150px" />
			<col />
		</colgroup>

        <tbody>

            <tr class="colorhover" style="background-color:#ededed; height:40px;" >
                <th scope="col"  class="th-left">현재까지 총 합</th>
                <th scope="col" class="blue"><?=number_format($stat["succ"])?></th>
                <th scope="col" class="red"><?=number_format($stat["fail"])?></th>
                <th scope="col"><?=number_format($stat["tot"])?></th>
                <th scope="col"></th>
            </tr>
				
		<tbody>
    </table>


</div>


<form name="fdelete" id="fdelete" method="post" action="<?=$g4[path]?>/pages.php">
	<input type="hidden" name="p" value="<?=$p?>" />
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="w" value="d" />
	<input type="hidden" name="no" value="" />
</form>

<script>
function delete_row(cli_id){
	if(!confirm("삭제하시겠습니까?")) return;
	document.fdelete.no.value = cli_id;
	document.fdelete.submit();
}
</script>


