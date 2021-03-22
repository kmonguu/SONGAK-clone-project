<?
$sub_menu = "400800";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g4[title] = "팝업관리";
include_once ("$g4[admin_path]/admin.head.php");




$sql_search = " WHERE is_mobile = 0 ";
$where = " AND ";

if ($stx != "") {
    if ($sfl != "") {
        $sql_search .= " $where $sfl like '%$stx%' ";
        $where = " and ";
    }
    if ($save_stx != $stx)
        $page = 1;
}


$sql_common = " from
				g4_popup a
			";

//$sql_common = " from one_item_golf a ";
$sql_common .= $sql_search;



// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row[cnt];

$rows = $config[cf_page_rows]+5;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

if (!$sst)
{
    $sst  = "cast( pop_no  AS unsigned ) ";
    $sod = "desc";
}
$sql_order = "order by $sst $sod";

// 출력할 레코드를 얻음
$sql  = " select a.*
           $sql_common
           $sql_order
           limit $from_record, $rows ";
$result = sql_query($sql);

//$qstr = "page=$page&sort1=$sort1&sort2=$sort2";
$qstr  = "$qstr&sca=$sca&page=$page&save_stx=$stx";


?>




<div class="navi">
<table width=100% cellpadding=4 cellspacing=0>
<form name=flist>
<input type=hidden name=page value="<?=$page?>">
<tr>
     <td width="300px" align=left style="padding:0 0 0 10px;">
		 <table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
					<select name=sfl>
						<option value='pop_nm'>팝업명</option>
					</select>
					<? if ($sfl) echo "<script> document.flist.sfl.value = '$sfl';</script>"; ?>
				</td>
				<td style="padding:0 0 0 5px;">
					<input type=hidden name=save_stx value='<?=$stx?>'>
					<input type=text name=stx value='<?=$stx?>' class="ed">
					<input type=image src='<?=$g4[admin_path]?>/img/btn_search.gif' align=absmiddle>
				</td>
			</tr>
		</table>
	</td>
    <td></td>
    <td width="600px" align=right style="padding:0 10px 0 0;">
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td style="padding:0 10px 0 10px;"><a href='<?=$_SERVER[PHP_SELF]?>'>처음</a></td>
				<td align=right>건수 : <? echo $total_count ?>&nbsp;</td>
			</tr>
		</table>
	</td>
</tr>
</form>
</table>
</div>

<form name=fcategorylist method='post' action='./pop_listUpdate.php' autocomplete='off' style="margin:0px;">

<table cellpadding=0 cellspacing=0 width="100%" class="list">
<input type=hidden name=page  value='<? echo $page ?>'>
<input type=hidden name=sort1 value='<? echo $sort1 ?>'>
<input type=hidden name=sort2 value='<? echo $sort2 ?>'>
<tr align=center class='bgcol1 bold col1 ht center'>
	<td width='50' ><?=subject_sort_link('pop_no');?>번호</a></td>
	<td width='' ><?=subject_sort_link('pop_nm');?>타이틀</a></td>
	<td width='' ><?=subject_sort_link('pop_type');?>팝업사용</a></td>
	<td width='' ><?=subject_sort_link('pop_sdate');?>시작날짜</a></td>
	<td width='' ><?=subject_sort_link('pop_edate');?>종료날짜</a></td>
	<td width='' ><?=subject_sort_link('pop_top');?>위쪽위치</a></td>
	<td width='' ><?=subject_sort_link('pop_left');?>왼쪽위치</a></td>
	<td width='' ><?=subject_sort_link('pop_iscenter');?>중앙표시</a></td>
	<td width='' ><?=subject_sort_link('pop_link');?>링크</a></td>
	<td width='' >이미지</td>
	<td width='' ><?=subject_sort_link('reg_dt');?>등록일자</a><br><?=subject_sort_link('mod_dt');?>수정일자</a></td>
	<td width=''><a href='./pop_form.php'><img src='<?=$g4[admin_path]?>/img/icon_insert.gif' border=0 title='골프등록'></a></td>
</tr>

<?
$style = "style='text-align:right;'";
$listCnt = 0;
for ($i=0; $row=sql_fetch_array($result); $i++)
{
	$listCnt++;

    $s_add = icon("추가", "./pop_form.php?no=$row[pop_no]&$qstr");
    $s_upd = icon("수정", "./pop_form.php?w=u&no=$row[pop_no]&$qstr");
    //$s_vie = icon("보기", "$g4[shop_path]/list.php?no=$row[no]");

    if ($is_admin == 'super')
	$s_del = icon("삭제", "javascript:del('./pop_formUpdate.php?w=d&no=$row[pop_no]&$qstr');");

    $list = $i%2;
    echo "
    <input type=hidden name='pop_no[$i]' value='$row[pop_no]'>
    <tr class='list$list center ht'>
        <td align='center'>$row[pop_no]</td>
		<td align='center'><input type=text name='pop_nm[$i]' id='pop_nm[$i]' value='".($row[pop_nm])."' title='$row[pop_nm]' required class=ed style='width:100%'></td>
		<td align='center'>
			<select name='pop_type[$i]' style='width:115px;'>
				<option value='Y' ".($row[pop_type] == "Y" ? "selected" : "").">새창</option>
				<option value='A' ".($row[pop_type] == "A" ? "selected" : "").">레이어(Absolute)</option>
				<option value='F' ".($row[pop_type] == "F" ? "selected" : "").">레이어(Fixed)</option>
				<option value='N' ".($row[pop_type] == "N" ? "selected" : "").">사용안함</option>
			</select>
		</td>
		<td align='center'>
			<input type=text name='pop_sdate[$i]' id='pop_sdate[$i]' value='".($row[pop_sdate])."' title='$row[pop_sdate]'  class='ed calendar' size=10>
		</td>
		<td align='center'>
			<input type=text name='pop_edate[$i]' id='pop_edate[$i]' value='".($row[pop_edate])."' title='$row[pop_edate]'  class='ed calendar' size=10>
		</td>
		<td align='center'>
			<input type=text name='pop_top[$i]' id='pop_top[$i]' value='".($row[pop_top])."' title='$row[pop_top]'  class=ed size=5 $style>px	
		</td>
		<td align='center'>
			<input type=text name='pop_left[$i]' id='pop_left[$i]' value='".($row[pop_left])."' title='$row[pop_left]'  class=ed size=5 $style>px
		</td>
		<td align='center'>
			<input type=checkbox name='pop_iscenter[$i]' id='pop_iscenter[$i]' value='Y' ".($row[pop_iscenter] == 'Y' ? "checked" : "").">
		</td>
		<td align=center>
			<input type=text name='pop_link[$i]' id='pop_link[$i]' value='".($row[pop_link])."' title='$row[pop_link]'  class=ed style='width:60%'>
			<select name='pop_link_type[$i]' style='width:35%;'>
				<option value='1' ".($row[pop_link_type] == "1" ? "selected" : "").">일반</option>
				<option value='2' ".($row[pop_link_type] == "2" ? "selected" : "").">새창</option>
			</select>
		</td>
		<td align='center'>
			<a href='./download_file.php?filepath=../data/popupmng/".$row[pop_image]."'>Down</a>
		</td>
		<td align='center'>$row[reg_dt]<br>$row[mod_dt]</td>
		";




    echo "
        <td>$s_upd $s_del $s_vie</td>
    </tr>";
}

if ($i == 0) {
    echo "<tr><td colspan=20 height=100 bgcolor='#ffffff' align=center><span class=point>자료가 한건도 없습니다.</span></td></tr>\n";
}
?>

</table>


<table width=100%>
<tr>
    <td width=50%><input type=submit class=btn1 value='일괄수정'></td>
    <td width=50% align=right><?=get_paging($config[cf_write_pages], $page, $total_page, "$_SERVER[PHP_SELF]?$qstr&page=");?></td>
</tr>
</form>
</table>

<script type="text/javascript">

function excelUpload(){
	fNewWin("oneItemGolfExcelUploadForm.php", "excelUp", 400, 185);
}

function fNewWin(url, name, width, height)  {
 cw=screen.availWidth; // 화면 너비
 ch=screen.availHeight; // 화면 높이

 sw=width;// 띄울 창의 너비
 sh=height;// 띄울 창의 높이

 ml=(cw-sw)/2;// 가운데 띄우기위한 창의 x위치
 mt=(ch-sh)/2;// 가운데 띄우기위한 창의 y위치

  NewWindow=window.open(url, name,'width='+sw+',height='+sh+',top='+mt+',left='+ml+',toobar=no,scrollbars=yes,menubar=no,status=no ,directories=no,');
}


jQuery(function($){
	$.datepicker.regional['ko'] = {
		closeText: '닫기',
		prevText: '이전달',
		nextText: '다음달',
		currentText: '오늘',
		monthNames: ['1월(JAN)','2월(FEB)','3월(MAR)','4월(APR)','5월(MAY)','6월(JUN)',
		'7월(JUL)','8월(AUG)','9월(SEP)','10월(OCT)','11월(NOV)','12월(DEC)'],
		monthNamesShort: ['1월','2월','3월','4월','5월','6월',
		'7월','8월','9월','10월','11월','12월'],
		dayNames: ['일','월','화','수','목','금','토'],
		dayNamesShort: ['일','월','화','수','목','금','토'],
		dayNamesMin: ['일','월','화','수','목','금','토'],
		weekHeader: 'Wk',
		dateFormat: 'yy-mm-dd',
		isRTL: false,
		firstDay: 0,
		showMonthAfterYear: true,
		yearSuffix: ''};

	$.datepicker.setDefaults($.datepicker.regional['ko']);

    $('.calendar').datepicker({
        showOn: 'button',
		buttonImage: '<?=$g4[path]?>/img/calendar.gif',
		buttonImageOnly: true,
        buttonText: "달력",
        changeMonth: true,
		changeYear: true,
        showButtonPanel: true,
        yearRange: 'c-99:c+99'
    });
});

</script>
<style type="text/css">
.ui-datepicker-trigger {vertical-align:middle;}
</style>

<?
include_once ("$g4[admin_path]/admin.tail.php");
?>
