<?
include_once("./_common.php");
auth_check($auth[$sub_menu], "r");


$g4[title] = "메시지 발송 내역";
include_once("{$g4["admin_path"]}/admin.head.php");



$obj = new Sms4Stat();

if(!$sch_date){
	$sch_date = date("Y-m-d");
}

$nextDate = date("Y-m-d", strtotime("{$sch_date} +1 Days"));
$prevDate = date("Y-m-d", strtotime("{$sch_date} -1 Days"));


$stat = $obj->stat_date($sch_date);
$data = $stat[0];


if($page=="") $page = 1;
$rowCnt = 15;
$result = $obj->get_list($page, $sfl, $stx,"", "", $rowCnt, " AND wr_datetime BETWEEN '{$sch_date} 00:00:00' AND '{$sch_date} 23:59:59' ");
$list = $result["list"];



$qstr .= "&sch_date=$sch_date";
?>




<div class="Totalot2">	

	<form name="schform" id="schform" method="get">
		<input type="hidden" name="p" value="<?=$p?>" />
		<input type="hidden" name="action" value="<?=$action?>" />
		<div class="Topbar">

            <span class="Bar01">날자</span>
			<span style="position:relative;cursor:pointer;" onclick="$('#sch_date').val('<?=$prevDate?>');$('#schform').submit();"><span style="position:absolute;top:-3px;left:0;"><img src="/res/images/left01_btn.jpg" /></span></span>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<input type="text" class="Tinput01 calendar" name="sch_date" id="sch_date"" value="<?=$sch_date?>" style="width:70px;" onchange="$('#schform').submit()" />
			<span style="position:relative;cursor:pointer" onclick="$('#sch_date').val('<?=$nextDate?>');$('#schform').submit();"><span style="position:absolute;top:-3px;left:0;"><img src="/res/images/right01_btn.jpg" /></span></span>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<span class="Btn2 link3"><a href="javascript:void(0)" onclick="$('#schform').submit()">검색</a></span>
			
			
			<div class="Toprightb">
				<span class="Btn4 link3"><a href="./result.php?sch_year=<?=date("Y", strtotime($sch_date))?>&sch_month=<?=date("m", strtotime($sch_date))?>">목록보기</a></span>
			</div>
			
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
	




    <table class="t3" summary="">
		<colgroup>
			<col width="150px" />
			<col width="150px" />
			<col width="150px" />
			<col width="150px" />
			<col />
		</colgroup>
		<thead>
		  <tr>
			<th scope="col"></th>
			<th scope="col">성공</th>
			<th scope="col">실패</th>
			<th scope="col">합계</th>
			<th scope="col"></th>
		  </tr>
		</thead>
		<tbody>
				<tr class="colorhover">
					<td ><?=$sch_date?></td>
					<td class="blue"><?=number_format($data["succ"])?></td>
					<td class="red"><?=number_format($data["fail"])?></td>
					<td><?=number_format($data["tot"])?></td>
					<td ></td>
				</tr>
		</tbody>
	</table>
	
	
	<br/>
	<br/>

	<table class="t3" summary="">
		<colgroup>
			<col width="60px"/>
			<col width="80px"/>
			<col width="120px"/>
			<col width="120px"/>
			<col />
			<col width="260px"/>
		</colgroup>
		<thead>
		  <tr>
			<th scope="col">#</th>
			<th scope="col">시간</th>
			<th scope="col">회원</th>
			<th scope="col">수신번호</th>
			<th scope="col">내용</th>
			<th scope="col">결과</th>
		  </tr>
		</thead>
		<tbody>
		
			<?$idx = 0; 
			foreach($list as $row){ $idx++;?>
				<tr class="colorhover">
					<td class="td-left">
						<?=$idx?>
					</td>
					<td >
						<?=date("H:i", strtotime($row["wr_datetime"]))?>
					</td>
                    <td >
						<?=$row["hs_name"]?><br/>(<?=$row["mb_id"] ? $row["mb_id"] : "비회원"?>)
					</td>
					<td >
						<?=$row["hs_hp"]?>
					</td>
					<td style="text-align:left; padding-left:10px;">
						<?=conv_content($row["wr_message"], "2")?>
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




