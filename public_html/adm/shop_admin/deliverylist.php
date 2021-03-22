<?
$sub_menu = "400500";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g4[title] = "배송일괄처리";
include_once ("$g4[admin_path]/admin.head.php");

//sql_query(" update $g4[yc4_cart_table] set ct_status = '완료' where ct_status = '배송' ");

// 배송회사리스트 ---------------------------------------------
$delivery_options = "";
$sql = " select * from $g4[yc4_delivery_table] order by dl_order ";
$result = sql_query($sql);
for($i=0; $row=sql_fetch_array($result); $i++) {
    $delivery_options .= "<option value='$row[dl_id]'>$row[dl_company]";
}
// 배송회사리스트 end ---------------------------------------------

$where = " where ";
$sql_search = "";
if ($search != "") {
	if ($sel_field != "") {
    	$sql_search .= " $where $sel_field like '%$search%' ";
        $where = " and ";
    }
}

if ($sel_ca_id != "") {
    $sql_search .= " $where ca_id like '$sel_ca_id%' ";
}

if ($sel_field == "")  $sel_field = "od_id";

$sql_common = " from $g4[yc4_order_table] a
                left join $g4[yc4_cart_table] b on (a.on_uid=b.on_uid)
                $sql_search ";

// 테이블의 전체 레코드수만 얻음
if ($chk_misu) {
    $sql  = " select od_id, a.*, "._MISU_QUERY_." $sql_common group by od_id having  misu <= 0 ";
    $result = sql_query($sql);
    $total_count = mysql_num_rows($result);
}
else {
    $row = sql_fetch("select count(od_id) as cnt from {$g4['yc4_order_table']} $sql_search ");
    $total_count = $row[cnt];
}

$rows = $config[cf_page_rows];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

if (!$sort1) {
    $sort1 = "od_id";
}

if (!$sort2) {
    $sort2 = "desc";
}

if ($sort2 == "desc") {
    $unsort2 == "asc";
} else {
    $unsort2 == "desc";
}

$qstr1 = "sel_ca_id=$sel_ca_id&sel_field=$sel_field&search=$search&chk_misu=$chk_misu";
$qstr  = "$qstr1&sort1=$sort1&sort2=$sort2&page=$page";
?>

<form name=flist autocomplete='off' style="margin:0px;">
<input type=hidden name=doc  value="<?=$doc?>">
<!--input type=hidden name=page value="<?=$page?>"-->

<div class="navi">
<table width=100%>
<tr>
    <td width=50% align=left style="padding:0 0 0 5px;">
		<form name=fsearch method=get>
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
						<label><input type="checkbox" name="chk_misu" value="1" <?=$chk_misu?"checked='checked'":"";?> /> 미수금없음</label>
						&nbsp;&nbsp;
						<select name=sel_field>
							<option value='od_id'>주문번호
							<option value='od_name'>주문자
							<option value='od_invoice'>운송장번호
						</select>
						<? if ($sel_field) echo "<script> document.flist.sel_field.value = '$sel_field';</script>"; ?>
					</td>
					<td style="padding:0 0 0 5px;"> <input type=text name=search value='<? echo $search ?>'></td>
					<td style="padding:0 0 0 5px;"><input type=image src='<?=$g4[admin_path]?>/img/btn_search.gif' align=absmiddle></td>
				</tr>
			</table>
		</form>
	</td>
	 <td width=50% align=right style="padding:0 5px 0 0;">
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>

				

					<td style="padding-right:10px;">
						<form name="uploadexcel_form" method="post" action="./delivery_excel_up.php" enctype="multipart/form-data" onsubmit="return file_check();">
							<select name=dl_id style="height:25px;">
								<?=$delivery_options?>
							</select>
							<input type="file" name="excel_file" id="excel_file" style="border:1px solid gray; padding:3px; background-color:white;"/> : <input type="submit" class="btn1" value="엑셀업로드">
						</form>
						<div style="font-size:11px; padding-top:5px;">
							** 주문개별관리에서 [엑셀저장]버튼을 통해 출력 된 엑셀파일만 사용해주세요
						</div>
					</td>


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

<script type="text/javascript">
function file_check(){

	if(jQuery("#excel_file").val()==""){
		alert("파일을 선택해주세요.");
		return false;
	}
	return true;
}
</script>




<form name=fdeliverylistupate method=post action="./deliverylistupdate.php" autocomplete='off' style="margin:0px;">
<input type=hidden name=sel_ca_id  value="<? echo $sel_ca_id ?>">
<input type=hidden name=sel_field  value="<? echo $sel_field ?>">
<input type=hidden name=search     value="<? echo $search ?>">
<input type=hidden name=page       value="<? echo $page ?>">
<input type=hidden name=sort1      value="<? echo $sort1 ?>">
<input type=hidden name=sort2      value="<? echo $sort2 ?>">
<table cellpadding=0 cellspacing=0 width=100% border=0 class="list">

<tr align=center class='bgcol1 bold col1 ht center'>
    <td><a href='<? echo title_sort("od_id",1) . "&$qstr1"; ?>'>주문번호</a></td>
    <td><a href='<? echo title_sort("od_name") . "&$qstr1"; ?>'>주문자</a></td>
    <td><a href='<? echo title_sort("orderamount",1) . "&$qstr1"; ?>'>주문액</a></td>
    <td><a href='<? echo title_sort("receiptamount",1) . "&$qstr1"; ?>'>입금액</a></td>
    <td><a href='<? echo title_sort("misu",1) . "&$qstr1"; ?>'>미수금</a></td>
    <td><a href='<? echo title_sort("od_hope_date",1) . "&$qstr1"; ?>'>희망배송일</a></td>
    <td>배송일시</td>
    <td>배송회사</td>
    <td>운송장번호</td>
	<td></td>
</tr>

<?
$sql  = " select od_id, a.*, "._MISU_QUERY_."
          $sql_common
          group by od_id ";
if ($chk_misu)
    $sql .= " having  misu <= 0 ";
$sql .= "  order by $sort1 $sort2/* 김선용 심각한 트래픽으로 미사용, a.od_invoice asc*/
          limit $from_record, $config[cf_page_rows] ";
$result = sql_query($sql);


for ($i=0; $row=mysql_fetch_array($result); $i++) 
{
    $invoice_time = $g4[time_ymdhis];
    if (!is_null_time($row[od_invoice_time])) 
        $invoice_time = $row[od_invoice_time];

    $sql1 = " select * from $g4[member_table] where mb_id = '$row[mb_id]' ";
    $row1 = sql_fetch($sql1);
    $name = get_sideview($row[mb_id], $row[mb_name], $row[mb_email], $row[mb_homepage]);

    if ($default[de_hope_date_use])
        $hope_date = substr($row[od_hope_date],2,8)." (".get_yoil($row[od_hope_date]).")";
    else
        $hope_date = "<span title='사용안함'>-</span>";
	
    $list = $i%2;

	if($row["od_delivery_cnt"] <= 1){ 
		echo "
		<input type='hidden' name='od_id[$i]' value='$row[od_id]'>
		<input type='hidden' name='on_uid[$i]' value='$row[on_uid]'>
		<tr class='list$list center ht'>
			<td><a href='./orderform.php?od_id=$row[od_id]'>$row[od_id]</a></td>
			<td>$row[od_name]</td>
			<td align=right>".display_amount($row[orderamount])."&nbsp;</td>
			<td align=right>".display_amount($row[receiptamount])."&nbsp;</td>
			<td align=right>".display_amount($row[misu])."&nbsp;</td>
			<td>$hope_date</td>
			<td><input type='text' name='od_invoice_time[$i]' class=ed size=20 maxlength=19 value='$invoice_time'></td>
			<td>
				<select name=dl_id[$i]>
				<option value=''>--------
				$delivery_options
				</select>
			</td>
			<!-- 값이 바뀌었는지 비교하기 위하여 저장 -->
			<input type='hidden' name='save_dl_id[$i]' value='$row[dl_id]'>
			<input type='hidden' name='save_od_invoice[$i]' value='$row[od_invoice]'>
			<td><input type='text' name='od_invoice[$i]' class=ed size=10 value='$row[od_invoice]'></td>
			<td>$row[it_hit]</td>
		</tr>";

		if ($row[dl_id]) {
			//echo "<script> document.fdeliverylistupate.elements('dl_id[$i]').value = '$row[dl_id]'; </script>";
			// FF 3.0 에서 위의 코드는 에러를 발생함 (080626 수정)
			echo "<script> document.fdeliverylistupate.elements['dl_id[$i]'].value = '$row[dl_id]'; </script>";
		}

	} else {

		$mdObj = new Yc4MultiDelivery();
		$mdResult = $mdObj->get_list($row["od_id"], 1, "", "", "", "", PHP_INT_MAX, "", "");
		$mdlist = $mdResult["list"];
		$cnt = 0;
		for($idx = 0 ; $idx < count($mdlist); $idx++){
			$md = $mdlist[$idx];
			$cnt++;
			
			$invoice_time = $g4[time_ymdhis];
			if (!is_null_time($md[md_invoice_time])) 
				$invoice_time = $md[md_invoice_time];
			
			echo "
			<input type='hidden' name='md_no[]' value='{$md["no"]}'>
			<input type='hidden' name='md_on_uid[]' value='$row[on_uid]'>
			<tr class='list$list center ht'>
				<td><a href='./orderform.php?od_id=$row[od_id]'>$row[od_id]</a></td>
				<td>$row[od_name]</td>
				<td align=right>".display_amount($row[orderamount])."&nbsp;</td>
				<td align=right>".display_amount($row[receiptamount])."&nbsp;</td>
				<td align=right>".display_amount($row[misu])."&nbsp;</td>
				<td>$hope_date</td>
				<td>
					[배송지{$cnt}] - 
					<input type='text' name='md_invoice_time[]' class=ed size=20 maxlength=19 value='{$invoice_time}'>
				</td>
				<td>
					<select name=md_dl_id[] id='md_dl_id_{$md["no"]}'>
					<option value=''>--------
					$delivery_options
					</select>
				</td>
				<!-- 값이 바뀌었는지 비교하기 위하여 저장 -->
				<input type='hidden' name='save_md_dl_id[]' value='{$md["md_dl_id"]}'>
				<input type='hidden' name='save_md_invoice[]' value='{$md["md_invoice"]}'>
				<td><input type='text' name='md_invoice[]' class=ed size=10 value='$md[md_invoice]'></td>
				<td>$row[it_hit]</td>
			</tr>";

			if ($md["md_dl_id"]) {
				//echo "<script> document.fdeliverylistupate.elements('dl_id[$i]').value = '$row[dl_id]'; </script>";
				// FF 3.0 에서 위의 코드는 에러를 발생함 (080626 수정)
				echo "<script> document.getElementById('md_dl_id_{$md["no"]}').value = '$md[md_dl_id]'; </script>";
			}



		}

	}
}
if ($i == 0)
    echo "<tr><td colspan=20 align=center height=100 bgcolor=#FFFFFF><span class=point>자료가 한건도 없습니다.</span></td></tr>";
?>

</table>


<?
//알림톡 셋팅 정보
$obj = new APIStoreKKOConfig();
$kkoConf = $obj->get($ss_com_id);
?>
<table width=100%>
<tr bgcolor=#ffffff>
    <td width=50%>
        <table>
        <tr>
			<!--
            <td><input type=checkbox name='od_send_mail' value='1' checked> 메일발송&nbsp;</td>
			-->
			<td><input type=checkbox name='send_sms' value='1'> SMS&nbsp;</td>
			<?if($kkoConf["api_id"]) {?>
				<td><input type=checkbox name='send_kko' value='1'> 알림톡&nbsp;</td>
			<?}?>
            <td><input type=submit class=btn1 accesskey='s' value='일괄수정'></td>
        </tr>
        </table>
    </td>
    <td width=50% align=right><?=get_paging($config[cf_write_pages], $page, $total_page, "$_SERVER[PHP_SELF]?$qstr&page=");?></td>
</tr>
</table>
</form>

<br>
* 주문액은 취소, 반품, 품절, DC가 포함된 금액이 아닙니다.<br>
* 입금액은 환불, 승인취소가 포함된 금액이 아닙니다.<br>
* 배송일시, 배송회사는 입력의 편의성을 위하여 기본값으로 설정되어 있습니다. 운송장번호만 없는것이 미배송 주문자료입니다.

<?
include_once ("$g4[admin_path]/admin.tail.php");
?>
