<?
$monthtime = strtotime($year.($month<10?"0".$month:$month).($day<10?"0".$day:$day));


	$thisyear  = date('Y');  // 2000
	$thismonth = date('n');  // 1, 2, 3, ..., 12
	$thisday   = date('j');  // 1, 2, 3, ..., 31

$pyear	= date('Y',mktime(0,0,0,date("m",$monthtime)-1,15,date("Y",$monthtime)));
$pmonth = date('n',mktime(0,0,0,date("m",$monthtime)-1,15,date("Y",$monthtime)));
$pday   = date('j',strtotime("-1 Month", $monthtime));
$nyear	= date('Y',mktime(0,0,0,date("m",$monthtime)+1,15,date("Y",$monthtime)));
$nmonth = date('n',mktime(0,0,0,date("m",$monthtime)+1,15,date("Y",$monthtime)));
$nday   = date('j',strtotime("+1 Month", $monthtime));
$daynum = date('t',$monthtime);

$result = sql_query("SELECT * FROM $write_table WHERE substr(wr_link1,1,6) = '".$year.($month<10?"0".$month:$month)."' ");

$scheduleData = array();
for($i=0;$row=sql_fetch_array($result);$i++){
	$scheduleData[$row['wr_link1']][count($scheduleData[$row['wr_link1']])] = $row;
}

?>
<style type="text/css">
#scheduleTable td {text-align:center; font-size:25px;}
#scheduleUl {list-style:none; margin:10px 0; padding:5px 0; border-top:5px solid #000000;}
#scheduleUl > li {clear:both;border-top:1px solid #EAEAEA;}
#scheduleUl li > ul > li {float:left;}
#scheduleUl li > ul > li.first {width:80px; padding:0 10px;font-size:27px}
#scheduleUl li > ul > li.second {padding:5px; width:480px; min-height:12px; line-height:35px;font-size:25px}


.sche_p { padding-left:17px; font-size:17px; }
.sche_p0 { background:url("<?=$board_skin_path?>/img/dia_review.gif") no-repeat 0px center; }
.sche_p1 { background:url("<?=$board_skin_path?>/img/dia_memorial.gif") no-repeat 0px center; }
.sche_p2 { background:url("<?=$board_skin_path?>/img/dia_schedual.gif") no-repeat 0px center; }
.sche_p3 { background:url("<?=$board_skin_path?>/img/dia_diary.gif") no-repeat 0px center; }


</style>
<table id="scheduleTable" style="width:600px;">
<colgroup>
<col width="240">
<col width="158">
<col width="240">
</colgroup>
<tr>
	<td style="text-align:right; cursor:pointer;" onclick="document.location.href='?bo_table=<?=$bo_table?>&year=<?=$pyear?>&month=<?=$pmonth?>&day=<?=$pday?>'">
		<?=date("F", mktime(0,0,0,date("m",$monthtime)-1,15,date("Y",$monthtime)));?>
		<?=date("n", mktime(0,0,0,date("m",$monthtime)-1,15,date("Y",$monthtime)));?>월&nbsp;
		<img src="<?=$board_skin_mpath?>/img/icon_prev.png" style="height:28px;vertical-align:bottom;">
	</td>
	<td><?=$year?>년&nbsp;<?=$month?>월</td>
	<td style="text-align:left; cursor:pointer;" onclick="document.location.href='?bo_table=<?=$bo_table?>&year=<?=$nyear?>&month=<?=$nmonth?>&day=<?=$nday?>'">
		<img src="<?=$board_skin_mpath?>/img/icon_next.png" style="height:28px;vertical-align:bottom;">&nbsp;
		<?=date("n", mktime(0,0,0,date("m",$monthtime)+1,15,date("Y",$monthtime)));?>월
		<?=date("F", mktime(0,0,0,date("m",$monthtime)+1,15,date("Y",$monthtime)));?>
	</td>
</tr>
</table>

<ul id="scheduleUl">
<?for($i=0;$i<$daynum;$i++){
	$rowday = $year.($month<10?"0".$month:$month).(($i+1)<10?"0".($i+1):($i+1));
	$rowweek = date("w", strtotime($rowday));
	$rowweekeng = date("D", strtotime($rowday));
	$bgcolor = "";
	if($rowweek==6) $bgcolor = "#E6FFFF";
	if($rowweek==0) $bgcolor = "#FFEAEA";
?>
	<li style="background-color:<?=$bgcolor?>;">
		<ul>
			<li class="first">
				<a href="./write.php?bo_table=<?=$bo_table?>&write[wr_link1]=<?=$rowday?>">
					<span style="color:#000000; font-weight:bold;"><?=$i+1?>일</span>(<?=$rowweekeng?>)
				</a>
			</li>

			<li class="second">
				<?
				for($j=0;$j<count($scheduleData[$rowday]);$j++){
					//if($j>0) echo "<br>";

					
						switch ($scheduleData[$rowday][$j][wr_3]) {
							case 1 :
								echo "<p class='sche_p sche_p1'>";
								break;
							case 2 :
								echo "<p class='sche_p sche_p2'>";
								break;
							case 3 :
								echo "<p class='sche_p sche_p3'>";
								break;
							default :
								echo "<p class='sche_p sche_p0'>";
						}


				?>
						<a href='./board.php?bo_table=<?=$bo_table?>&wr_id=<?=$scheduleData[$rowday][$j]['wr_id']?>'>
							<?=$scheduleData[$rowday][$j]['wr_subject']?>
						</a>
					</p>
				<?}?>
			</li>
		</ul>
		<ul style="clear:both;"></ul>
	</li>
<?}?>
</ul>