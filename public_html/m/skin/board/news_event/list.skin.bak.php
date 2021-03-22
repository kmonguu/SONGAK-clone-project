<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once("$g4[path]/lib/thumb.lib.php");
if (!$board[bo_1]) {
    $board[bo_1] = "350";
    $sql = " update $g4[board_table] set bo_1 = '$board[bo_1]', bo_1_subj = '썸네일 가로' where bo_table = '$bo_table' ";
    sql_query($sql);
}

if (!$board[bo_2]) {
    $board[bo_2] = "210";
    $sql = " update $g4[board_table] set bo_2 = '$board[bo_2]', bo_2_subj = '썸네일 세로' where bo_table = '$bo_table' ";
    sql_query($sql);
}

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

//if ($is_category) $colspan++;
if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// 제목이 두줄로 표시되는 경우 이 코드를 사용해 보세요.
// <nobr style='display:block; overflow:hidden; width:000px;'>제목</nobr>



if(!$sdate){
	$sdate = date('Y-m');
	$yy = (int)date('Y');
	$mm = (int)date('m');
} else {
	$yymm = explode("-", $sdate);
	$yy = (int)$yymm[0];
	$mm = (int)$yymm[1];
}
$mmStr = str_pad($mm, 2, 0, STR_PAD_LEFT);


$beforeP = date('Y-m',mktime(0,0,0,$mm-3,15,$yy)); //이전버튼 클릭시
$nextP = date('Y-m',mktime(0,0,0,$mm+3,15,$yy)); //다음버튼 클릭시 

$firstPTmp = sql_fetch("SELECT substr(MIN(DECODE(ca_name, 'News', wr_datetime, wr_2)), 1, 7) as min_date FROM g4_write_{$bo_table}");
$firstP = $firstPTmp[min_date];
$lastPTmp = sql_fetch("SELECT substr(MAX(DECODE(ca_name, 'News', wr_datetime, wr_3)), 1, 7) as max_date FROM g4_write_{$bo_table}");
$lastP = $lastPTmp[max_date];


//YYYY-MM
$month[0] = $sdate;
$month[1] = date('Y-m',mktime(0,0,0,$mm+1,15,$yy));
$month[2] = date('Y-m',mktime(0,0,0,$mm+2,15,$yy));

//YYYY.MM
$monthStr1 = $yy.".".$mmStr;
$monthStr2 = date('Y.m',mktime(0,0,0,$mm+1,15,$yy));
$monthStr3 =  date('Y.m',mktime(0,0,0,$mm+2,15,$yy));

//YYYY. MM
$monthStr1_t = $yy.". ".$mmStr;
$monthStr2_t = date('Y. m',mktime(0,0,0,$mm+1,15,$yy));
$monthStr3_t =  date('Y. m',mktime(0,0,0,$mm+2,15,$yy));


$qstr2 = $qstr; 
$qstr  .= "&sdate=$sdate";



function get_query($yymm){

	global $bo_table, $stx, $sfl;
	
		
	$sql_search = "";
	if($yymm==""){
		$sql_search = " AND $sfl like '%$stx%' ";
	} else {
		$sql_search = "	AND
					(ca_name = 'News' AND substr(wr_datetime, 1, 7) = '{$yymm}') OR
					(ca_name = 'Event' AND ('{$yymm}' BETWEEN substr(wr_2, 1, 7) AND substr(wr_3, 1, 7)))
		";
	}
	
	$sql = "
		SELECT 
			*
		FROM
			g4_write_$bo_table
		WHERE
			wr_is_comment != 1
			$sql_search
		ORDER BY
			DECODE(ca_name, 'News', wr_datetime, wr_2) asc
	";

	
	return $sql;
}


function get_list_month($month){
	
	global $g4, $board, $bo_table, $qstr;

		$sql = get_query($month);

		$result = sql_query($sql);
		
		$list_mm = array();
		for($i = 0 ; $row = sql_fetch_array($result) ; $i++){
			$row[file] = get_file($bo_table, $row[wr_id]);
			$row['href'] = "$g4[bbs_path]/board.php?bo_table=$board[bo_table]&wr_id=$row[wr_id]&" . $qstr;
			array_push($list_mm, $row);
		}	

		return $list_mm;
}


function get_search_result(){
	
	global $g4, $board, $bo_table, $qstr;

	$sql = get_query("");

	$result = sql_query($sql);
	
	$list_mm = array();
	for($i = 0 ; $row = sql_fetch_array($result) ; $i++){
		$row[file] = get_file($bo_table, $row[wr_id]);
		$row['href'] = "$g4[bbs_path]/board.php?bo_table=$board[bo_table]&wr_id=$row[wr_id]&" . $qstr;
		array_push($list_mm, $row);
	}	

	return $list_mm;
}


function print_list($list){
		
		global $bo_table, $board, $g4, $board_skin_path;
	
		
		$count1 = count($list)-1 ;
		for ($i=0; $i<count($list); $i++) {
		// 첨부파일 이미지가 있으면 썸을 생성, 아니면 pass~!
		if ($list[$i][ca_name] == "News"){
			$thumImg = "<img src='/res/images/news_img.jpg'  style='width:{$board[bo_1]}px;height:{$board[bo_2]}px;margin-left:3px; margin-bottom:3px; border:{$imgbordersize}px solid {$imgcolor}; ' id='img{$i}'  alt='News &amp; Event 이미지' />";
		}
		else if ($list[$i][file][0][file])
		{
			// 이미지 체크
			$image = urlencode($list[$i][file][0][file]);
			$ori="$g4[path]/data/file/$bo_table/" . $image;
			$ext = strtolower(substr(strrchr($ori,"."), 1)); //확장자
				// 이미지가 있다면.
				if ($ext=="gif"||$ext=="jpg"||$ext=="jpeg"||$ext=="png"||$ext=="bmp"||$ext=="tif"||$ext=="tiff") {
				// 섬네일 경로 만들기 + 섬네일 생성
				$list_img_path = $list[$i][file][0][path]."/".$list[$i][file][0][file];
				$list_thumb = thumbnail($list_img_path ,$board[bo_1], $board[bo_2],0,2,100);
				$thumImg = "<img src='$list_thumb'  style='width:{$board[bo_1]}px;height:{$board[bo_2]}px;margin-left:3px; margin-bottom:3px; border:{$imgbordersize}px solid {$imgcolor}; ' id='img{$i}'  alt='News &amp; Event 이미지' />";
			}
		}
		else
		{                
				////  첨부파일 이미지가 없으면
				$img_tags = explode("src=",$list[$i][wr_content]);
				$img_tag = explode(" ",$img_tags[1]);
				$img_url = explode(">",$img_tag[0]);
				$real_img_url = $img_url[0];
				$clear_img_url =  str_replace('"','',$real_img_url);
				$thumImg =  "<img src='{$board_skin_path}/img/noimg.gif'  style='width:{$board[bo_1]}px;height:{$board[bo_2]}px; margin-left:3px;  margin-bottom:3px; border:{$imgbordersize}px solid {$imgcolor}; ' id='img{$i}' alt='News &amp; Event 이미지' />";

		}
		// 섬네일 완료
		
		$date = date("Y-m-d H:i", strtotime($list[$i][wr_datetime]));
		if ($list[$i][ca_name] == "Event") {
			$date = $list[$i][wr_2]."~".$list[$i][wr_3];
		} 


		echo "
			<li>
				<span class='Thum'><a href='{$list[$i][href]}'>$thumImg</a></span>
				<span class='Tit'><a href='{$list[$i][href]}'>".cut_str($list[$i][wr_subject],60)."</a></span>
				<span class='Stit'><a href='{$list[$i][href]}'>".cut_str($list[$i][wr_1],180)."</a></span>
				<span class='Date'>
					<span class='Pricein'>Date.</span> &nbsp;&nbsp;$date
				</span>
			</li>
		";

	 } 
}

?>



<div class="titleline3"></div>

<div class="Boardbox">

		
	<form name='fsch' method="get">
		<input type="hidden" name="bo_table" value="<?=$bo_table?>" />
		<input type="hidden" name="sop" value="and" />
		<input type="hidden" name="sca" value="<?=$sca?>" />

		<div class="Boardtop">

			<select name="sfl" id="sfl">
				<option value='wr_subject||wr_content' <?=$sfl=="wr_subject||wr_content" ? "selected" : ""?> >전체</option>
				<option value='wr_subject' <?=$sfl=="wr_subject" ? "selected" : ""?> >제목</option>
				<option value='wr_content' <?=$sfl=="wr_content" ? "selected" : ""?> >내용</option>
			</select>

			<div style="float:left;padding:0 7px 0 10px;"><input type="text" name="stx" value="<?=$stx?>" class="input03" placeholder="검색어입력" title="검색어를 입력해주세요" /></div>
			<div class="totalbtn"><a href="javascript:document.fsch.submit()"><span class="totalbtn1" title="새창에서 열림">검색</span></a></div>
		</div>
	
	</form>

<?if($stx){?>
	
	<?
	// n Month =======================================================================================================
	$list_mm = get_search_result();
	?>

	<a href="javascript:list_fold(1)" title="<?=$monthStr1_t?>">
	<div class="Conslide3">Search Result<span class="point"><img class="img_mm1" src="/res/images/slidepoint_on.jpg" alt="BED ROOM 정보" /></span><span class="point2"><span class="point3"><?=count($list_mm)?></span> 개의 게시물이 있습니다.</span></div></a>
	<div class="Eventlist mm1">
		<ul>
			<?print_list($list_mm);?>
		</ul>
	</div>
	
<?}else{?>

	<?
	// n Month =======================================================================================================
	$list_mm = get_list_month($month[0]);
	?>

	<a href="javascript:list_fold(1)" title="<?=$monthStr1_t?>">
		<div class="Conslide3"><?=$monthStr1_t ?><span class="point"><img class="img_mm1" src="/res/images/slidepoint_on.jpg" alt="BED ROOM 정보" /></span><span class="point2"><span class="point3"><?=count($list_mm)?></span> 개의 게시물이 있습니다.</span></div>
	</a>
	<div class="Eventlist mm1">
		<ul>
			<?print_list($list_mm);?>
		</ul>
	</div>


	<?
	// n+1 Month =======================================================================================================
	$list_mm = get_list_month($month[1]);
	?>

	<a href="javascript:list_fold(2)" title="<?=$monthStr2_t?>"><div class="Conslide4"><?=$monthStr2_t ?><span class="point"><img class="img_mm2" src="/res/images/slidepoint_on.jpg" alt="BED ROOM 정보" /></span><span class="point2"><span class="point3"><?=count($list_mm)?></span> 개의 게시물이 있습니다.</span></div></a>
	<div class="Eventlist mm2">
		<ul>
			<?print_list($list_mm);?>
		</ul>
	</div>

	<?
	// n+2 Month =======================================================================================================
	$list_mm = get_list_month($month[2]);
	?>

	<a href="javascript:list_fold(3)" title="<?=$monthStr3_t?>"><div class="Conslide4"><?=$monthStr3_t ?><span class="point"><img class="img_mm3" src="/res/images/slidepoint_on.jpg" alt="BED ROOM 정보" /></span><span class="point2"><span class="point3"><?=count($list_mm)?></span> 개의 게시물이 있습니다.</span></div></a>
	<div class="Eventlist mm3">
		<ul>
			<?print_list($list_mm);?>
		</ul>
	</div>


	<div class="Boardbtn" style="margin:30px 0 0 0;">
		<div class="Boardleftbtn">
			<div class="totalbtn">&nbsp;</div>
		</div>
		<div class="Boardpage linkpage">
			<table cellspacing="3" cellpadding="0" class="t6" summary="페이지 입니다.">
				<colgroup>
					<col />
					<col />
					<col />
					<col />
					<col />
					<col />
					<col />
					<col />
					<col />
				</colgroup>
				<tbody>
					<tr>
						<td class="td-remo"><a href="/bbs/board.php?bo_table=<?=$bo_table?>&<?=$qstr2?>&sdate=<?=$firstP?>">&lt;&lt;</a></td>
						<td class="td-remo"><a href="/bbs/board.php?bo_table=<?=$bo_table?>&<?=$qstr2?>&sdate=<?=$beforeP?>">&lt;</a></td>
						<td class="td-con"><strong><?=$monthStr1?>&nbsp;~&nbsp;<?=$monthStr3?></strong></td>
						<td class="td-remo2"><a href="/bbs/board.php?bo_table=<?=$bo_table?>&<?=$qstr2?>&sdate=<?=$nextP?>">&gt;</a></td>
						<td class="td-remo2"><a href="/bbs/board.php?bo_table=<?=$bo_table?>&<?=$qstr2?>&sdate=<?=$lastP?>">&gt;&gt;</a></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="Boardrightbtn">
			 <? if ($write_href) { ?><div class="totalbtn"><a href="<?=$write_href?>&sca=<?=$sca?>"><span class="totalbtn1">글쓰기</span></a></div><?}?>
		</div>
	</div>

<?}?>
</div>





<script type="text/javascript">


function list_fold(idx){
	
	if($(".mm"+idx).hasClass("fold")){
		$(".img_mm"+idx).attr("src", $(".img_mm"+idx).attr("src").split("_off").join("_on"));
		$(".mm"+idx).slideDown().removeClass("fold");
	} else {
		$(".img_mm"+idx).attr("src", $(".img_mm"+idx).attr("src").split("_on").join("_off"));
		$(".mm"+idx).slideUp().addClass("fold");
	}

}

var isCalOver = false;
$(function(){
	$("#sfl").it9_select({width:40});
	
	$("#sch_sdate").click(function(){
		$("#cal_sdate").show();
		$("#cal_edate").hide();

		//시작 날자
		dual_calendar({
			id:"cal_sdate",
			sdate_id:"sch_sdate",
			mode:"single",
			date_sep:"-",
			caption:false,
			limit:false,
			single_callback: function(date){
				if($("#sch_edate").val() != "" && $("#sch_edate").val() < date){
					$("#sch_edate").val("")
					$("#cal_sdate").fadeOut('fast');
				} else {
					$("#cal_sdate").fadeOut('fast');
				}
			}
		});
	});

	$("#sch_edate").click(function(){
		$("#cal_edate").show();
		$("#cal_sdate").hide();
		//끝 날자
		dual_calendar({
			id:"cal_edate",
			sdate_id:"sch_edate",
			mode:"single",
			date_sep:"-",
			caption:false,
			limit:false,
			single_callback: function(date){
				if($("#sch_sdate").val() > date){
					alert("시작 검색일 보다 이전일을 검색하실 수 없습니다.");	
					$("#sch_edate").val($("#sch_sdate").val());
				} else {
					$("#cal_edate").fadeOut('fast');
				}
			}
		});
	});

	$("#cal_edate, #cal_sdate").mouseover(function(){isCalOver=true}).mouseleave(function(){isCalOver=false;});
	$(document).mouseup(function(){
		if(!isCalOver)
			$(".calendar").hide();
	});


});


</script>




<script type="text/javascript">
if ('<?=$sca?>') document.fcategory.sca.value = '<?=$sca?>';
/*if ('<?=$stx?>') {
    document.fsearch.sfl.value = '<?=$sfl?>';

    if ('<?=$sop?>' == 'and')
        document.fsearch.sop[0].checked = true;

    if ('<?=$sop?>' == 'or')
        document.fsearch.sop[1].checked = true;
} else {
    document.fsearch.sop[0].checked = true;
}*/
</script>

<? if ($is_checkbox) { ?>
<script type="text/javascript">
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function check_confirm(str) {
    var f = document.fboardlist;
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(str + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }
    return true;
}

// 선택한 게시물 삭제
function select_delete() {
    var f = document.fboardlist;

    str = "삭제";
    if (!check_confirm(str))
        return;

    if (!confirm("선택한 게시물을 정말 "+str+" 하시겠습니까?\n\n한번 "+str+"한 자료는 복구할 수 없습니다"))
        return;

    f.action = "./delete_all.php";
    f.submit();
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    if (!check_confirm(str))
        return;

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<? } ?>
<!-- 게시판 목록 끝 -->
