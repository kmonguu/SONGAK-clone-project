<?
$sub_menu = "400800";
include_once("./_common.php");
auth_check($auth[$sub_menu], "r");



include_once ("$g4[path]/lib/cheditor4.lib.php");

auth_check($auth[$sub_menu], "w");





if ($w == "")
{
	$sql = " SELECT  (ifnull( max(cast( pop_no  AS unsigned )) , 0 )  +1) AS max_seq FROM g4_popup ";
        $row = sql_fetch($sql);

	$ca[pop_no] = $row[max_seq];

	//echo $row[max_seq]."<br>";

    $ca[ca_skin] = "list.skin.10.php";
}
else if ($w == "u")
{
    $sql = " select * from g4_popup where pop_no = '$no' ";
    $ca = sql_fetch($sql);
    if (!$ca[pop_no])
        alert("자료가 없습니다.");

    $html_title = $ca[pop_nm] . " 수정";
    $ca[pop_nm] = get_text($ca[pop_nm]);
}

$qstr = "page=$page&sort1=$sort1&sort2=$sort2";

$g4[title] = $html_title;
include_once ("$g4[admin_path]/admin.head.php");

?>

<?=subtitle("팝업정보 입력")?>


<form name=oneform method=post action="./pop_formUpdate.php" enctype="multipart/form-data" onsubmit='return foneform_submit(this);' style="margin:0px;">

<table cellpadding=0 cellspacing=0 width=1000px class="list02">
<input type=hidden name=w        value="<?=$w?>">
<input type=hidden name=page     value="<?=$page?>">
<input type=hidden name=sort1    value="<?=$sort1?>">
<input type=hidden name=sort2    value="<?=$sort2?>">
<colgroup width=15%>
<colgroup width=35% bgcolor=#FFFFFF>
<colgroup width=15%>
<colgroup width=35% bgcolor=#FFFFFF>

<tr class=ht>
    <td class="head">번호</td>
    <td colspan=3><input type=hidden name=pop_no value='<? echo $ca[pop_no] ?>' size=38 required itemname="번호" class=ed><? echo $ca[pop_no] ?></td>
</tr>
<tr class=ht>
    <td class="head">타이틀</td>
    <td colspan="3">
		<input type=text name=pop_nm id=pop_nm value='<? echo $ca[pop_nm] ?>' style="width:98%" required itemname="타이틀" class=ed>
    </td>
</tr>
<tr class=ht>
    <td class="head">기간</td>
    <td colspan="3">
		<input type=text name=pop_sdate id=pop_sdate value='<? echo $ca[pop_sdate] ?>' style="width:70px;" required itemname="타이틀" class="ed calendar">&nbsp;~&nbsp;
		<input type=text name=pop_edate id=pop_edate value='<? echo $ca[pop_edate] ?>' style="width:70px;" required itemname="타이틀" class="ed calendar">
    </td>
</tr>
<tr class=ht>
	<td class="head">팝업사용</td>
     <td colspan="3">
		<select name='pop_type' style='width:125px;'>
			<option value='Y' <?=($ca[pop_type] == "Y" ? "selected" : "")?>>새창</option>
			<option value='F' <?=($ca[pop_type] == "F" ? "selected" : "")?>>레이어(Absolute)</option>
			<option value='A' <?=($ca[pop_type] == "A" ? "selected" : "")?>>레이어(Fixed)</option>
			<option value='N' <?=($ca[pop_type] == "N" ? "selected" : "")?>>사용안함</option>
		</select>
	</td>
</tr>
<tr class=ht>
    <td class="head">넓이/높이</td>
	<td colspan="3">
		width : <input type=text name=pop_width value='<? echo $ca[pop_width] ?>' size=4 itemname="넓이" class=ed>px /
		height : <input type=text name=pop_height value='<? echo $ca[pop_height] ?>' size=4 itemname="높이" class=ed>px 
	</td>

</tr>

<tr class=ht>
	<td class="head">위쪽위치/왼쪽위치</td>
	<td colspan="3">
		top : <input type=text name="pop_top" value='<? echo $ca[pop_top] ?>' size=4 itemname="넓이" class=ed>px /
		left : <input type=text name="pop_left" value='<? echo $ca[pop_left] ?>' size=4 itemname="높이" class=ed>px /
		<input type=checkbox name="pop_iscenter" value="Y" <?=$ca[pop_iscenter]=="Y" ? "checked" : ""?>> 가운데표시 (설정값 무시)
	</td>
</tr>

<tr class=ht>
	<td class="head">팝업이미지</td>
	<td colspan=3>
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<?$img1 = "$g4[path]/data/popupmng/popup_{$ca[pop_no]}_1";?>
				<td style="border:0px;padding:0;"><input type="file" name="img1" class=ed width="50px;"></td>
				<td style="border:0px;padding:0;">
					<?if (file_exists($img1)) {?>
					<img src='<?=$g4[admin_path]?>/img/btn_search.gif' align=absmiddle onclick="viewImg('<?=$img1?>');">
					<input type=checkbox name=img1_del value='1'>삭제
					<?}?>
				</td>
			</tr>
		</table>
	</td>
</tr>



<tr class=ht>
	<td class="head">이미지 크기1</td>
	<td colspan="3">
		<input type=radio name=pop_img_size value="1" <?=$ca[pop_img_size]=="1" || $ca[pop_img_size] == "" || $ca[pop_img_size] == 0 ? "checked" : ""?>> 원본크기 &nbsp;
		<input type=radio name=pop_img_size value="2" <?=$ca[pop_img_size]=="2" ? "checked" : ""?>> 설정값 &nbsp;
		<input type=radio name=pop_img_size value="3" <?=$ca[pop_img_size]=="3" ? "checked" : ""?>> 팝업창 크기에 맞춤 &nbsp;
	</td>
</tr>

<tr class=ht>
	<td class="head">이미지 크기2</td>
	<td colspan="3">
		width : <input type=text name=pop_img_width value='<? echo $ca[pop_img_width] ?>' size=4 itemname="넓이" class=ed>px /
		height : <input type=text name=pop_img_height value='<? echo $ca[pop_img_height] ?>' size=4 itemname="높이" class=ed>px 
	</td>
</tr>

<tr class=ht>
	<td class="head">링크</td>
	<td colspan="3">
		<input type=text name=pop_link value='<? echo $ca[pop_link] ?>' style="width:70%" itemname="링크" class=ed>
		<select name='pop_link_type' style='width:100px'>
			<option value='1' <?=$ca[pop_link_type] == "1" ? "selected" : ""?>>일반</option>
			<option value='2' <?=$ca[pop_link_type] == "2" ? "selected" : ""?>>새창</option>
		</select>
	</td>
</tr>



<tr class=ht>
	<td class="head">이미지 맵</td>
	<td colspan="3">
		<input type=text name=pop_map value='<? echo $ca[pop_map] ?>' size=10 itemname="이미지 맵" class=ed>
		<span style="color:gray">◁(이미지 맵이름을 아무 단어나 영문으로 입력해주시면, 하단의 맵 속성으로 이미지맵이 적용됩니다.)</span>
	</td>
</tr>



<tr class=ht>
	<td class="head">맵속성</td>
	<td colspan="3">
		<textarea name="pop_map_opt" style='width:100%;height:150px'><?=$ca[pop_map_opt] ? $ca[pop_map_opt] : "<area shape='rect' coords='좌표값' href='링크주소' target='_blank' onClick='window.close();'/>" ?></textarea>
	</td>
</tr>



</table>

</div>
<p>


<?if(!$isPopup) {?>
<p align=center style="width:1000px;margin:10px 0 0 0;">
    <input type=submit class=btn1 accesskey='s' value='  확  인  '>&nbsp;
    <input type=button class=btn1 accesskey='l' value='  목  록  ' onclick="document.location.href='./pop_list.php?<?=$qstr?>';">
<?}?>
</form>

<div id="viewimg">
</div>

<script language='javascript'>


function viewImg(img) {
	$("#viewimg").html("<center><img src='"+img+"' width='300px;' height='300px;'></center>");

	var hStr = "380";
	if(navigator.appName.indexOf("Microsoft") > -1) {
		hStr = "380 px";
	} else {
		hStr = "380";
	}
	$("#viewimg").dialog({
		width : 350,
		height : hStr,
		position : {my: "center", at: "center", of: window},
		resizable: false,
		overflow: false,
		open:function() {
		}
	});

}


function foneform_submit(f) {

    f.action = "./pop_formUpdate.php";
    return true;
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

<iframe name='hiddenFrame' width=0 height=0></iframe>

<?
if(!$isPopup) {
	include_once ("$g4[admin_path]/admin.tail.php");
}
?>