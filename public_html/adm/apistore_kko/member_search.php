<?
$sub_menu = "200100";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$token = get_token();

$sql_common = " from $g4[member_table] ";

$sql_search = " where ( mb_leave_date = '' AND mb_sms = 1 AND mb_hp != '') ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "mb_point" :
            $sql_search .= " ($sfl >= '$stx') ";
            break;
        case "mb_level" :
            $sql_search .= " ($sfl = '$stx') ";
            break;
        case "mb_tel" :
        case "mb_hp" :
            $sql_search .= " ($sfl like '%$stx') ";
            break;
        default :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}
//if ($is_admin == 'group') $sql_search .= " and mb_level = '$member[mb_level]' ";
if ($is_admin != 'super') 
    $sql_search .= " and mb_level <= '$member[mb_level]' ";

if (!$sst) {
    $sst = "mb_datetime";
    $sod = "desc";
}

$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt
         $sql_common
         $sql_search
         $sql_order ";
$row = sql_fetch($sql);
$total_count = $row[cnt];

$rows = PHP_INT_MAX; //$config[cf_page_rows];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if (!$page) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함


$listall = "<a href='$_SERVER[PHP_SELF]' class=tt>처음</a>";

if($sch) {
$sql = " select *
          $sql_common
          $sql_search
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);
}
$colspan = 6;




include_once ("$g4[admin_path]/admin.popup.php");
?>


<div class="navi">
<table width=100%>
<form name=fsearch method=get>
<input type="hidden" name="sch" value="1"/>
<tr>
    <td width=50% align=left style="padding:0 0 0 5px;">
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
					<select name=sfl class=cssfl>
						<option value='mb_name'>이름</option>
						<option value='mb_id'>회원아이디</option>
						<!-- <option value='mb_nick'>별명</option>
						<option value='mb_level'>권한</option> -->
						<option value='mb_email'>E-MAIL</option>
						<option value='mb_tel'>전화번호</option>
						<option value='mb_hp'>핸드폰번호</option>
						<!-- <option value='mb_point'>포인트</option>
						<option value='mb_datetime'>가입일시</option>
						<option value='mb_ip'>IP</option>
						<option value='mb_recommend'>추천인</option>
						<option value='mb_1'>관리업체</option> -->
					</select>
				</td>
				<td style="padding:0 0 0 5px;"><input type=text name=stx class=ed  itemname='검색어' value='<? echo $stx ?>'></td>
				<td style="padding:0 0 0 5px;"><input type=image src='<?=$g4[admin_path]?>/img/btn_search.gif' align=absmiddle></td>
			</tr>
		</table>
	</td>
	 <td width=50% align=right style="padding:0 5px 0 0;">
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
				<?=$listall?>
				</td>
				<td></td>
			</tr>
		</table>
    </td>
</tr>
</form>
</table>
</div>
<form name=fmemberlist method=post>
<input type=hidden name=sst   value='<?=$sst?>'>
<input type=hidden name=sod   value='<?=$sod?>'>
<input type=hidden name=sfl   value='<?=$sfl?>'>
<input type=hidden name=stx   value='<?=$stx?>'>
<input type=hidden name=page  value='<?=$page?>'>
<input type=hidden name=token value='<?=$token?>'>

<table width=99.7% cellpadding=0 cellspacing=0 class="list" style="table-layout:fixed;">
<colgroup>
	<col width="40px" />
<colgroup>

<tr class='bgcol1 bold col1 ht center'>
    <td><input type=checkbox name=chkall value='1' onclick='check_all(this.form)'></td>
    <td><?=subject_sort_link('mb_id')?>회원아이디</a></td>
    <td><?=subject_sort_link('mb_name')?>이름</a></td>
    <td><?=subject_sort_link('mb_nick')?>별명</a></td>
	<td><?=subject_sort_link('mb_hp')?>번호</a></td>
	<td></td>
</tr>
<?
for ($i=0; $row=sql_fetch_array($result); $i++) {
 
  
    $mb_nick = $row[mb_nick];
    $mb_id = $row[mb_id];
    if ($row[mb_leave_date])
        $mb_id = "<font color=crimson>$mb_id</font>";
    else if ($row[mb_intercept_date])
        $mb_id = "<font color=orange>$mb_id</font>";

    $list = $i%2;
    echo "
    <input type=hidden name=mb_id[$i] value='$row[mb_id]'>
    <tr class='list$list col1 ht center'>
        <td>
			<input type=checkbox name=chk[] class='chks' value='1' data-id=\"{$row[mb_id]}\" data-name=\"{$row[mb_name]}\" data-hp=\"{$row[mb_hp]}\">
		</td>
        <td title='$row[mb_id]'><nobr style='display:block; overflow:hidden;'>&nbsp;$mb_id</nobr></td>
        <td><nobr style='display:block; overflow:hidden; ".($row[mb_black]=="1"?"color:#FF0000;":"")."'>$row[mb_name]</nobr></td>
        <td><nobr style='display:block; overflow:hidden;'><u>$mb_nick</u></nobr></td>
		<td><nobr style='display:block; overflow:hidden;'>$row[mb_hp]</nobr></td>
        <td>
			<input type='button' value='선택' onclick='top.select_member(\"{$row[mb_id]}\", \"{$row[mb_name]}\", \"{$row[mb_hp]}\")'/>
		</td>
    </tr>";
}

if ($i == 0) {
	if($sch)
	    echo "<tr><td colspan='$colspan' align=center height=100 class=contentbg>자료가 없습니다.</td></tr>";
	else
		echo "<tr><td colspan='$colspan' align=center height=100 class=contentbg>SMS를 전송하실 회원을 검색해주세요</td></tr>";
}


echo "</table>";

$pagelist = get_paging($config[cf_write_pages], $page, $total_page, "?$qstr&page=");
echo "<table width=100% cellpadding=3 cellspacing=1>";
echo "<tr><td width=50%>";
echo "<input type=button class='btn1' value='선택추가' onclick=\"add_all()\">&nbsp;";
echo "</td>";
echo "<td width=50% align=right>$pagelist</td></tr></table>\n";

if ($stx)
    echo "<script type='text/javascript'>document.fsearch.sfl.value = '$sfl';</script>\n";
?>
</form>

<script>
// POST 방식으로 삭제
function post_delete(action_url, val)
{
	var f = document.fpost;

	if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
        f.mb_id.value = val;
		f.action      = action_url;
		f.submit();
	}
}
</script>

<form name='fpost' method='post'>
<input type='hidden' name='sst'   value='<?=$sst?>'>
<input type='hidden' name='sod'   value='<?=$sod?>'>
<input type='hidden' name='sfl'   value='<?=$sfl?>'>
<input type='hidden' name='stx'   value='<?=$stx?>'>
<input type='hidden' name='page'  value='<?=$page?>'>
<input type='hidden' name='token' value='<?=$token?>'>
<input type='hidden' name='mb_id'>
</form>


<script>
var t = 1;
	function add_all(){
			
			$(".chks").each(function(){
				if($(this).is(":checked")){
					var id = $(this).data("id");
					var name = $(this).data("name");
					var hp = $(this).data("hp");
					top.select_member(id, name, hp);
				}
			});
	}
</script>


<?
include_once ("../admin.tail.php");
?>
