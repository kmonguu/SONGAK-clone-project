<?
$sub_menu = "300100";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

$token = get_token();

$g4[title] = "게시판 복사";
include_once("$g4[path]/head.sub.php");
?>

<link rel="stylesheet" href="./admin.style.css" type="text/css">
<style>
.list04 { width:100%; border-top:2px solid #232323; }
.list04 tr th { color:#2f2f2f; font-weight:400; text-align:center; border-bottom:1px solid #ddd; vertical-align:middle; background:#fafafa; }
.list04 tr td { font-weight:400; text-align:left; vertical-align:middle; border-bottom:1px solid #ddd; padding:10px; color:#464646; }

.nBtn { padding:0px 15px; line-height:35px; font-size:14px; font-weight:400; display:inline-block; text-decoration:none; border:0px; }
.nBtn1 { background:#484848; color:#ffffff; }
.nBtn2 { background:#727272; color:#ffffff; }

</style>

<form name="fboardcopy" method='post' onsubmit="return fboardcopy_check(this);" autocomplete="off">
<input type="hidden" name="bo_table" value="<?=$bo_table?>">
<input type="hidden" name="token"    value="<?=$token?>">
<table width=100% cellpadding=0 cellspacing=0 class="list04" >
<colgroup width=25% class='col1 pad1 bold right'>
<colgroup width='' class='col2 pad2'>
<tr>
    <th colspan=2 class=title align=center style="font-size:17px; font-weight:bold; height:30px;" ><img src='<?=$g4[admin_path]?>/img/icon_title.gif'> <?=$g4[title]?></th>
</tr>
<tr class='ht'>
	<th>원본 테이블</th>
	<td><?=$bo_table?></td>
</tr>
<tr class='ht'>
	<th>복사할 TABLE</th>
	<td>
		<input type=text class=ed name="target_table" style="width:110px;" maxlength="20" required alphanumericunderline itemname="TABLE">
		영문자, 숫자, _ 만 가능 (공백없이)
	</td>
</tr>
<tr class='ht'>
	<th>게시판 제목</th>
	<td><input type=text class=ed name='target_subject' style="width:230px;" maxlength=120 required itemname='게시판 제목' value='[복사본] <?=$board[bo_subject]?>'></td>
</tr>
<tr class='ht'>
	<th>복사 유형</th>
	<td>
        <input type="radio" name="copy_case" id="schema_only" value="schema_only" checked><label for="schema_only">구조만</label>
        <input type="radio" name="copy_case" id="schema_data_both" value="schema_data_both"><label for="schema_data_both">구조와 데이터</label>
    </td>
</tr>
<tr height=40>
	<td colspan=2 align=center style="text-align:center; border-bottom:0px;" >
        <input type="submit" value="  복  사  " class="nBtn nBtn1" >&nbsp;
        <input type="button" value="창닫기" onclick="window.close();" class="nBtn nBtn2" >
    </td>
</tr>
</table>

</form>

<script type='text/javascript'>
function fboardcopy_check(f)
{
    f.action = "./board_copy_update.php";
    return true;
}
</script>

<?
include_once("$g4[path]/tail.sub.php");
?>
