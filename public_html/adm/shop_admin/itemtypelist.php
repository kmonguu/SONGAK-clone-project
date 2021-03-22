<?
$sub_menu = "400610";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g4[title] = "상품유형관리";
include_once ("$g4[admin_path]/admin.head.php");

/*
$sql_search = " where 1 ";
if ($search != "") {
	if ($sel_field != "") {
    	$sql_search .= " and $sel_field like '%$search%' ";
    }
}

if ($sel_ca_id != "") {
    $sql_search .= " and (ca_id like '$sel_ca_id%' or ca_id2 like '$sel_ca_id%' or ca_id3 like '$sel_ca_id%') ";
}

if ($sel_field == "")  $sel_field = "it_name";
*/

$where = " where ";
$sql_search = "";
if ($stx != "") {
    if ($sfl != "") {
        $sql_search .= " $where $sfl like '%$stx%' ";
        $where = " and ";
    }
    if ($save_stx != $stx)
        $page = 1;
}

if ($sca != "") {
    $sql_search .= " $where (ca_id like '$sca%' or ca_id2 like '$sca%' or ca_id3 like '$sca%') ";
}

if ($sfl == "")  $sfl = "it_name";

if (!$sst)  {
    $sst  = "it_id";
    $sod = "desc";
}
$sql_order = "order by $sst $sod";

$sql_common = "  from $g4[yc4_item_table] ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row[cnt];

$rows = $config[cf_page_rows];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select it_id, 
                 it_name,
                 it_type1,
                 it_type2,
                 it_type3,
                 it_type4,
                 it_type5
          $sql_common
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);

//$qstr1 = "sel_ca_id=$sel_ca_id&sel_field=$sel_field&search=$search";
//$qstr  = "$qstr1&sort1=$sort1&sort2=$sort2&page=$page";
$qstr  = "$qstr&sca=$sca&page=$page&save_stx=$stx";
?>

<form name=flist style="margin:0px;">

<div class="navi">
<table width=100%>
<input type=hidden name=doc   value="<? echo $doc ?>">
<input type=hidden name=sort1 value="<? echo $sort1 ?>">
<input type=hidden name=sort2 value="<? echo $sort2 ?>">
<input type=hidden name=page  value="<? echo $page ?>">
<tr>
    <td width=50% align=left style="padding:0 0 0 5px;">
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
					<select name="sca">
						<option value=''>전체분류
						<?
						$sql1 = " select ca_id, ca_name from $g4[yc4_category_table] order by ca_id ";
						$result1 = sql_query($sql1);
						for ($i=0; $row1=sql_fetch_array($result1); $i++) {
							$len = strlen($row1[ca_id]) / 2 - 1;
							$nbsp = "";
							for ($i=0; $i<$len; $i++) $nbsp .= "&nbsp;&nbsp;&nbsp;";
							echo "<option value='$row1[ca_id]'>$nbsp$row1[ca_name]\n";
						}
						?>
					</select>
					<script> document.flist.sca.value = '<?=$sca?>';</script>

					<select name=sfl>
						<option value='it_name'>상품명
						<option value='it_id'>상품코드
					</select>
					<? if ($sfl) echo "<script> document.flist.sfl.value = '$sfl';</script>"; ?>
				</td>
				<td style="padding:0 0 0 5px;"><input type=text name=stx value='<? echo $stx ?>'></td>
				<td style="padding:0 0 0 5px;"><input type=image src='<?=$g4[admin_path]?>/img/btn_search.gif' align=absmiddle></td>
			</tr>
		</table>
	</td>
	 <td width=50% align=right style="padding:0 5px 0 0;">
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
				건수 : <? echo $total_count ?>&nbsp;<a href='<?=$_SERVER[PHP_SELF]?>'>처음</a></a>
			    </td>
			</tr>
		</table>
    </td>
</tr>
</table>
</div>

</form>


<form name=fitemtypelist method=post action="./itemtypelistupdate.php" style="margin:0px;">
<input type=hidden name=sca  value="<?=$sca?>">
<input type=hidden name=sst  value="<?=$sst?>">
<input type=hidden name=sod  value="<?=$sod?>">
<input type=hidden name=sfl  value="<?=$sfl?>">
<input type=hidden name=stx  value="<?=$stx?>">
<input type=hidden name=page value="<?=$page?>">
<table cellpadding=0 cellspacing=0 width=100% class="list">


<tr align=center class='bgcol1 bold col1 ht center'>
    <td><?=subject_sort_link("it_id", $qstr, 1)?>상품코드</a></td>
    <td colspan=2><?=subject_sort_link("it_name")?>상품명</a></td>
    <td><?=subject_sort_link("it_type1", $qstr, 1)?><?=Yc4::$IT_TYPE["1"]?></a></td>
    <td><?=subject_sort_link("it_type2", $qstr, 1)?><?=Yc4::$IT_TYPE["2"]?></a></td>
    <td><?=subject_sort_link("it_type3", $qstr, 1)?><?=Yc4::$IT_TYPE["3"]?></a></td>
    <td><?=subject_sort_link("it_type4", $qstr, 1)?><?=Yc4::$IT_TYPE["4"]?></a></td>
    <td><?=subject_sort_link("it_type5", $qstr, 1)?><?=Yc4::$IT_TYPE["5"]?></a></td>
    <td>수정</td>
</tr>

<? 
for ($i=0; $row=sql_fetch_array($result); $i++) 
{
    $href = "{$g4[shop_path]}/item.php?it_id=$row[it_id]";

    $s_mod = icon("수정", "./itemform.php?w=u&it_id=$row[it_id]&ca_id=$row[ca_id]&$qstr");

    $list = $i%2;
    echo "
    <input type='hidden' name='it_id[$i]' value='$row[it_id]'>
    <tr class='list$list center'>
        <td>$row[it_id]</td> 
        <td style='padding-top:5px; padding-bottom:5px;'><a href='$href'>".get_it_image("{$row[it_id]}_s", 50, 50)."</a></td>
        <td align=left><a href='$href'>".cut_str(stripslashes($row[it_name]), 60, "&#133")."</a></td> 
        <td><input type=checkbox name='it_type1[$i]' value='1' ".($row[it_type1] ? 'checked' : '')."></td>
        <td><input type=checkbox name='it_type2[$i]' value='1' ".($row[it_type2] ? 'checked' : '')."></td>
        <td><input type=checkbox name='it_type3[$i]' value='1' ".($row[it_type3] ? 'checked' : '')."></td>
        <td><input type=checkbox name='it_type4[$i]' value='1' ".($row[it_type4] ? 'checked' : '')."></td>
        <td><input type=checkbox name='it_type5[$i]' value='1' ".($row[it_type5] ? 'checked' : '')."></td>
        <td>$s_mod</td>
    </tr>";
}

if (!$i)
    echo "<tr><td colspan=9 align=center height=100 bgcolor=#ffffff><span class=point>자료가 한건도 없습니다.</span></td></tr>";
?>

</table>

<table width=100%>
<tr>
    <td colspan=50%><input type=submit class=btn1 value='일괄수정' accesskey='s'></td>
    <td width=50% align=right><?=get_paging($config[cf_write_pages], $page, $total_page, "$_SERVER[PHP_SELF]?$qstr&page=");?></td>
</tr>
</form>
</table><br>

* 상품의 유형을 일괄 처리합니다.

<?
include_once ("$g4[admin_path]/admin.tail.php");
?>
