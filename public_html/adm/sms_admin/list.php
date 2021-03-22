<?
include_once("./_common.php");
auth_check($auth[$sub_menu], "r");


$g4[title] = "메시지 발송 내역";
include_once("{$g4["admin_path"]}/admin.head.php");



$obj = new Sms4Stat();


if($sch_sdate && $sch_edate) {
	$search_query = " AND wr_datetime BETWEEN '{$sch_sdate} 00:00:00' AND '{$sch_edate} 23:59:59' ";
}
if($sch_sdate && !$sch_edate) {
	$search_query = " AND wr_datetime >= '{$sch_sdate} 00:00:00' ";
}
if(!$sch_sdate && $sch_edate) {
	$search_query = " AND wr_datetime <= '{$sch_edate} 23:59:59' ";
}


if($page=="") $page = 1;
$rowCnt = 30;
$result = $obj->get_list($page, $sfl, $stx,"", "", $rowCnt, $search_query);
$list = $result["list"];



$qstr .= "&sch_date=$sch_date";
?>




<div class="Totalot2">	

	<form name="schform" id="schform" method="get">
		<input type="hidden" name="p" value="<?=$p?>" />
		<input type="hidden" name="action" value="<?=$action?>" />
		<div class="Topbar">

			<span class="Bar01">기간검색</span>
			<input type="text" class="Tinput01 calendar" name="sch_sdate" id="sch_sdate"" value="<?=$sch_sdate?>" style="width:70px;" onchange="$('#schform').submit()" />
			~
			<input type="text" class="Tinput01 calendar" name="sch_edate" id="sch_edate"" value="<?=$sch_edate?>" style="width:70px;" onchange="$('#schform').submit()" />
			
			<span class="Btn2 link3"><a href="javascript:void(0)" onclick="$('#schform').submit()">검색</a></span>
			&nbsp;&nbsp;&nbsp;


            <span class="Bar01">검색어입력</span>
            <select name=sfl  id="sfl" class="Tselcet01" data-width="100px">
                <option value='a.mb_id'>회원ID</option>
                <option value='hs_name'>회원이름</option>
                <option value='hs_hp'>연락처</option>
                <option value='wr_message'>내용</option>
            </select>

            <script type="text/javascript">
                $("#sfl > option[value='<?=$sfl?>']").attr("selected", "selected");
            </script>
            <input type=text name=stx class="Tinput01" itemname='검색어' value='<? echo $stx ?>'>
            <span class="Btn2 link3"><a href="javascript:void(0)" onclick="$('#schform').submit()">검색</a></span>

		</div>
		
		
	</form>
	

	<table class="t3" summary="" style="table-layout:fixed;">
		<colgroup>
			<col width="60px"/>
			<col width="120px"/>
			<col width="120px"/>
			<col width="120px"/>
			<col />
			<col width="260px"/>
		</colgroup>
		<thead>
		  <tr>
			<th scope="col">#</th>
			<th scope="col">전송일시</th>
			<th scope="col">회원</th>
			<th scope="col">수신번호</th>
			<th scope="col">내용<br/>(클릭시 상세내용 표시)</th>
			<th scope="col">결과</th>
		  </tr>
		</thead>
		<tbody>
		
			<?$idx = 0; 
			foreach($list as $row){ 
					$idx++;

					$num = $result["count"] - ($page - 1) * $rowCnt - ($idx-1);

			?>
				<tr class="colorhover">
					<td class="td-left">
						<?=$num?>
					</td>
					<td >
						<?=date("Y-m-d H:i", strtotime($row["wr_datetime"]))?>
					</td>
                    <td >
						<?=$row["hs_name"]?><br/>(<?=$row["mb_id"] ? $row["mb_id"] : "비회원"?>)
					</td>
					<td >
						<?=$row["hs_hp"]?>
					</td>
					<td style="text-align:left; padding-left:10px; position:relative; cursor:pointer;" onclick="$(this).find('.dispmsg').show();" onmouseleave="$('.dispmsg').hide();">
						<div style="width:100%; text-overflow:ellipsis; overflow:hidden; white-space:nowrap;" >
							<?=$row["wr_message"]?>
						</div>
						
						<div class="dispmsg" style="display:none; position:absolute; top:0px; left:0px; width:500px; height:200px; overflow:auto; padding:5px; background:#fff; border:1px solid gray; z-index:999;">
							<?=conv_content($row["wr_message"], "2")?>
						</div>
					</td>
					
					<td style="text-align:left; padding-left:10px;">
						<?
							if($row["wr_success"] == "1") {
								$stat_css = "color:#0000BB";
							} else {
								$stat_css = "color:#BB0000; font-weight:bold;";
							}
						?>
						<span style="<?=$stat_css?>">
							<?=$row["hs_memo"]?>
						</span>
					</td>
				</tr>
			<? }?>
		
		</tbody>
	</table>
	
	<?
		//페이지 생성
		$total_page  = ceil($result["count"] / $rowCnt);  // 전체 페이지 계산
		$pagelist = get_paging2(Props::get("write_pages"), $page, $total_page, "?p={$p}&action={$action}&$qstr&page=");
	?>
	<div class="Boardpage linkpage" style="">
	<table cellspacing="3" cellpadding="0" class="t6" summary="페이지 입니다." style='margin:0 auto;'>
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
				<?=$pagelist?>
			</tr>
		</tbody>
	</table>
	</div>
	
</div>




