<?
$sub_menu = "400620";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g4[title] = "상품재고관리";
include_once ("$g4[admin_path]/admin.head.php");

$sql_search = " where 1 ";
if ($search != "") {
	if ($sel_field != "") {
    	$sql_search .= " and $sel_field like '%$search%' ";
    }
}

if ($sel_ca_id != "") {
    $sql_search .= " and ca_id like '$sel_ca_id%' ";
}

if ($sel_field == "")  $sel_field = "it_name";
if ($sort1 == "") $sort1 = "it_id";
if ($sort2 == "") $sort2 = "desc";

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
                 it_use, 
                 it_stock_qty
           $sql_common
          order by $sort1 $sort2
          limit $from_record, $rows ";
$result = sql_query($sql);

$qstr1 = "sel_ca_id=$sel_ca_id&sel_field=$sel_field&search=$search";
$qstr  = "$qstr1&sort1=$sort1&sort2=$sort2&page=$page";
?>

<form name=flist style="margin:0px;">


<div class="navi">
<input type=hidden name=doc   value="<? echo $doc ?>">
<input type=hidden name=sort1 value="<? echo $sort1 ?>">
<input type=hidden name=sort2 value="<? echo $sort2 ?>">
<input type=hidden name=page  value="<? echo $page ?>">
<table width=100%>
<form name=fsearch method=get>
<tr>
    <td width=50% align=left style="padding:0 0 0 5px;">
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
					 <select name="sel_ca_id">
						<option value=''>전체분류
						<?
						$sql1 = " select ca_id, ca_name from $g4[yc4_category_table] order by ca_id ";
						$result1 = sql_query($sql1);
						for ($i=0; $row1=mysql_fetch_array($result1); $i++) {
							$len = strlen($row1[ca_id]) / 2 - 1;
							$nbsp = "";
							for ($i=0; $i<$len; $i++) $nbsp .= "&nbsp;&nbsp;&nbsp;";
							echo "<option value='$row1[ca_id]'>$nbsp$row1[ca_name]\n";
						}
						?>
					</select>
					<script> document.flist.sel_ca_id.value = '<?=$sel_ca_id?>';</script>

					<select name=sel_field>
						<option value='it_name'>상품명
						<option value='it_id'>상품코드
					</select>
					<? if ($sel_field) echo "<script> document.flist.sel_field.value = '$sel_field';</script>"; ?>
				</td>
				<td style="padding:0 0 0 5px;"><input type=text name=search value='<? echo $search ?>'></td>
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
</form>
</table>
</div>
</form>




<form name=fitemstocklist method=post action="./itemstocklistupdate.php" style="margin:0px;">
<input type=hidden name=sort1      value="<? echo $sort1 ?>">
<input type=hidden name=sort2      value="<? echo $sort2 ?>">
<input type=hidden name=sel_ca_id  value="<? echo $sel_ca_id ?>">
<input type=hidden name=sel_field  value="<? echo $sel_field ?>">
<input type=hidden name=search     value="<? echo $search ?>">
<input type=hidden name=page       value="<? echo $page ?>">
<table cellpadding=0 cellspacing=0 width=100% class="list">

<tr align=center class='bgcol1 bold col1 ht center'>
    <td><a href='<? echo title_sort("it_id") . "&$qstr1"; ?>'>상품코드</a></td>
    <td colspan=2><a href='<? echo title_sort("it_name") . "&$qstr1"; ?>'>상품명</a></td>
    <td><a href='<? echo title_sort("it_stock_qty") . "&$qstr1"; ?>'>창고재고</a></td>
    <td>주문대기</td>
    <td>가재고</td>
    <td>재고수정</td>
    <td><a href='<? echo title_sort("it_use") . "&$qstr1"; ?>'>판매</a></td>
    <td>수정</td>
</tr>

<?
for ($i=0; $row=mysql_fetch_array($result); $i++) 
{
    $href = "{$g4[shop_path]}/item.php?it_id=$row[it_id]";

    $sql1 = " select SUM(ct_qty) as sum_qty
                from $g4[yc4_cart_table]
               where it_id = '$row[it_id]'
                 and ct_stock_use = '0'
                 and ct_status in ('주문', '준비') ";
    $row1 = sql_fetch($sql1);
    $wait_qty = $row1['sum_qty'];

    // 가재고 (미래재고)
    $temporary_qty = $row['it_stock_qty'] - $wait_qty;

    $s_mod = icon("수정", "./itemform.php?w=u&it_id=$row[it_id]&ca_id=$row[ca_id]&$qstr");

    $list = $i%2;
    echo "
    <input type='hidden' name='it_id[$i]' value='$row[it_id]'>
    <tr class='list$list center'>
        <td>$row[it_id]</td> 
        <td style='padding-top:5px; padding-bottom:5px;'><a href='$href'>".get_it_image("{$row[it_id]}_s", 50, 50)."</a></td>
        <td align=left><a href='$href'>".cut_str(stripslashes($row[it_name]), 60, "&#133")."</a></td> 
        <td align=right>".number_format($row[it_stock_qty])."</td>
        <td align=right>".number_format($wait_qty)."</td>
        <td align=right>".number_format($temporary_qty)."</td>
        <td align=right><input type='text' name='it_stock_qty[$i]' value='$row[it_stock_qty]' class=ed size=10 style='text-align:right;' autocomplete='off'></td>
        <td><input type=checkbox name='it_use[$i]' value='1' ".($row[it_use] ? "checked" : "")."></td>
        <td>$s_mod</td>
    </tr><tr>";
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

* 상품의 재고와 판매를 일괄 처리합니다.<br>
* 가재고는 창고재고 - 주문대기 수량입니다.<br>
* 재고수정의 수량은 창고재고를 수정하는것입니다.

<?
include_once ("$g4[admin_path]/admin.tail.php");
?>
