<?
$sub_menu = "400300";
include_once("./_common.php");

$mbObj = new Member();
$s_on_uid = get_session('ss_on_uid');

auth_check($auth[$sub_menu], "r");

$g4[title] = "상품관리";
include_once ("$g4[admin_path]/admin.head.php");


if(isset($od_offline_id)) {
	set_session("ss_od_offline_id", $od_offline_id);
}
if($od_offline_id == "") {
	$od_offline_id = get_session("ss_od_offline_id");
}



if($od_offline_id) {

	$tmpMember = $member;
	if($od_offline_id == "|guest|") {
		$member = array("mb_level"=>1);
	} else {
		$member = $mbObj->get($od_offline_id);
	}

	//회원에 맞는 가격으로 변동
	set_cart_member_amount($s_on_uid);

	$member = $tmpMember;

}


// 분류
$ca_list  = "";
$sql = " select * from $g4[yc4_category_table] ";
if ($is_admin != 'super')
    $sql .= " where ca_mb_id = '$member[mb_id]' ";
$sql .= " order by ca_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++)
{
    $len = strlen($row[ca_id]) / 2 - 1;
    $nbsp = "";
    for ($i=0; $i<$len; $i++) {
        $nbsp .= "&nbsp;&nbsp;&nbsp;";
    }
    $ca_list .= "<option value='$row[ca_id]'>$nbsp$row[ca_name]";
}
$ca_list .= "</select>";

$where = " and ";
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
    $sql_search .= " $where (a.ca_id like '$sca%' or a.ca_id2 like '$sca%' or a.ca_id3 like '$sca%') ";
}

if ($sfl == "")  $sfl = "it_name";

/*
$sql_common = " from $g4[yc4_item_table] a ,
                     $g4[yc4_category_table] b
               where (a.ca_id = b.ca_id";
*/
$sql_common = " from $g4[yc4_item_table] a left join $g4[yc4_category_table] b on a.ca_id=b.ca_id where (1)";
if ($is_admin != 'super')
    $sql_common .= " and b.ca_mb_id = '$member[mb_id]'";
//$sql_common .= ") ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row[cnt];

$rows = 15;//$config[cf_page_rows];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

if (!$sst) {
    $sst  = "it_id";
    $sod = "desc";
}
$sql_order = "order by $sst $sod";

$sql  = " select *
           $sql_common
           $sql_order
           limit $from_record, $rows ";
$result = sql_query($sql);

//$qstr  = "$qstr&sca=$sca&page=$page";
$qstr  = "$qstr&sca=$sca&page=$page&save_stx=$stx";
?>



<form name=fsearch id="fsearch" method=get>

<div class="navi" style="padding:10px; font-weight:bold; font-family:'맑은 고딕'">
		<?
			$mblistTmp = $mbObj->get_list(1, "","","mb_name","asc", PHP_INT_MAX);
			$mblist = $mblistTmp["list"];
		?>
		주문자 선택 : 
		<select name="od_offline_id" id="od_offline_id" style="font-size:14px; padding:5px 0 6px 0;" onchange="change_mb_id();">
			<option value="">선택해주세요</option>
			<option value="|guest|">비회원</option>
			<?foreach($mblist as $mb) {?>
				<option value="<?=$mb["mb_id"]?>"><?=$mb["mb_name"]?>(<?=$mb["mb_id"]?>)</option>
			<?}?>
		</select>

		<script>
			$("#od_offline_id > option[value='<?=$od_offline_id?>']").attr("selected", "selected");
		</script>

		<span class="btn1" onclick="find_member()">회원검색</span>
</div>

<?if($od_offline_id) {?>

	<div class="navi">
	<table width=100%>
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
							for ($i=0; $row1=sql_fetch_array($result1); $i++)
							{
								$len = strlen($row1[ca_id]) / 2 - 1;
								$nbsp = "";
								for ($i=0; $i<$len; $i++) $nbsp .= "&nbsp;&nbsp;&nbsp;";
								echo "<option value='$row1[ca_id]'>$nbsp$row1[ca_name]\n";
							}
							?>
						</select>
						<script> document.fsearch.sca.value = '<?=$sca?>';</script>

						<select name=sfl>
							<option value='it_name'>상품명
							<option value='it_id'>상품코드
							<option value='it_maker'>제조사
							<option value='it_origin'>원산지
							<option value='it_sell_email'>판매자 e-mail
						</select>
						<?// if ($sel_field) echo "<script> document.flist.sel_field.value = '$sel_field';</script>"; ?>
						<? if ($sfl) echo "<script> document.fsearch.sfl.value = '$sfl';</script>"; ?>
					</td>
					<td style="padding:0 0 0 5px;"><input type=hidden name=save_stx value='<?=$stx?>'><input type=text name=stx value='<?=$stx?>'></td>
					<td style="padding:0 0 0 5px;"><input type=image src='<?=$g4[admin_path]?>/img/btn_search.gif' align=absmiddle></td>
				</tr>
			</table>
		</td>
		 <td width=50% align=right style="padding:0 5px 0 0;">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
					건수 : <? echo $total_count ?>&nbsp;<a href='<?=$_SERVER[PHP_SELF]?>'>처음</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
	</div>

	</form>


	<div style="min-width:1600px; overflow:auto;"> 

		<table cellpadding=0 cellspacing=0 width=50% border=0 class="list" style="width:50%; float:left;">
		<tr align=center class='bgcol1 bold col1 ht center'>
			<td><?=subject_sort_link("it_id", "sca=$sca")?>상품코드</a></td>
			<td colspan=2><?=subject_sort_link("it_name", "sca=$sca")?>상품명</a></td>
			<td><?=subject_sort_link("it_amount", "sca=$sca")?>비회원가격</a><br><?=subject_sort_link("it_cust_amount", "sca=$sca")?>시중가격</a></td>
			<td><?=subject_sort_link("it_amount2", "sca=$sca")?>회원가격</a><br><?=subject_sort_link("it_point", "sca=$sca")?>포인트</a></td>
			<td><?=subject_sort_link("it_amount3", "sca=$sca")?>특별가격</a><br><?=subject_sort_link("it_stock_qty", "sca=$sca")?>재고</a></td>
			<td></td>
		</tr>

		<?
		for ($i=0; $row=mysql_fetch_array($result); $i++)
		{
			$gallery = $row[it_gallery] ? "Y" : "";
			$list = $i%2;
			echo "
			<input type='hidden' name='it_id[$i]' value='$row[it_id]'>
			<tr class='list$list'>
				<td rowspan='2'>$row[it_id]</td>
				<td rowspan='2' style='padding-top:5px; padding-bottom:5px;'><a href='$href'>".get_it_image("{$row[it_id]}_s", 50, 50)."</a></td>
				<td rowspan='2' align=left>".htmlspecialchars2(cut_str($row[it_name],250, ""))."</td>
				<td width=70 align=center><input type='text' name='it_amount[$i]' value='".number_format($row[it_amount])."' class=ed size=7 style='text-align:right; background-color:#DDE6FE; border:0px; ' readonly></td>
				<td width=70 align=center><input type='text' name='it_amount2[$i]' value='$row[it_amount2]' class=ed size=7 style='text-align:right; background-color:#DDFEDE; border:0px' readonly></td>
				<td width=70 align=center><input type='text' name='it_amount3[$i]' value='$row[it_amount3]' class=ed size=7 style='text-align:right; background-color:#FEDDDD; border:0px;' readonly></td>
				<td rowspan='2'>
					<span class='bbtn1' onclick='show_itemform(\"{$row[it_id]}\")'>추가</span>
				</td>
			</tr>
			<tr class='list$list'>
				<td width=70 align=center><input type='text' name='it_cust_amount[$i]' value='$row[it_cust_amount]' class=ed size=7 style='text-align:right;border:0px' readonly></td>
				<td width=70 align=center><input type='text' name='it_point[$i]' value='$row[it_point]' class=ed size=7 style='text-align:right; border:0px; readonly;'></td>
				<td width=70 align=center><input type='text' name='it_stock_qty[$i]' value='$row[it_stock_qty]' class=ed size=7 style='text-align:right; border:0px;'  readonly></td>
			</tr>";
		}
		if ($i == 0)
			echo "<tr><td colspan=20 align=center height=100 bgcolor=#FFFFFF><span class=point>자료가 한건도 없습니다.</span></td></tr>";
		?>
		</table>


		<div style="float:left; width:48%; margin-left:15px;">
			<?
			$s_page = 'cart.php';
			include_once("./order_offline_cart.php");
			?>
		</div>


		
		<table width=50% style="clear:both;width:50%; float:left;">
		<tr>
		<td width=50%></td>
		<td width=50% align=right><?=get_paging($config[cf_write_pages], $page, $total_page, "$_SERVER[PHP_SELF]?$qstr&page=");?></td>
		</tr>
		</table>



	</div>

	<script>
	function _trim(str)
	{
		var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
		return str.replace(pattern, "");
	}
	</script>

<?}?>


<script>
function change_mb_id(){
	
	$("#fsearch").submit();
}

function show_itemform(it_id) {

	   $.colorbox({href:"./order_offline_item.php?it_id="+it_id, iframe:true, width:"620px", height:"620px", transition:"none", scrolling:true,closeButton:true,overlayClose:true, onClosed:function(){ 
        
    }});

}

function find_member() {

    $.colorbox({href:"../find_member.php", iframe:true, width:"600px", height:"700px", transition:"none", scrolling:true,closeButton:true,overlayClose:true, onClosed:function(){ 
        
    }});

}

function select_find_member(id, name){
	$("#od_offline_id > option[value='"+id+"']").prop("selected", "selected").change();
}
</script>


<?
include_once ("$g4[admin_path]/admin.tail.php");
?>
