<?
include_once("./_common.php");


$g4[title] = "메시지 전송기록";
include_once ("$g4[admin_path]/admin.head.php");


$obj = new APIStoreKKOResult();

if(!$sch_date){
	$sch_date = date("Y-m-d");
}

$nextDate = date("Y-m-d", strtotime("{$sch_date} +1 Days"));
$prevDate = date("Y-m-d", strtotime("{$sch_date} -1 Days"));


//기존 데이터들 REPORT결과 업데이트
$need_report_list = $obj->get_all_list("", "", "", "", " AND (api_status='200' AND (kko_status='' AND (msg_status='' OR msg_status='X'))) AND reg_date BETWEEN '{$sch_date} 00:00:00' AND '{$sch_date} 24:00:00' ");
if(count($need_report_list) > 0){
	$smsConfObj = new APIStoreKKOConfig();
	$scf = $smsConfObj->get($ss_com_id);
	$smsObj = new APIStoreKKO($scf["api_id"], $scf["api_key"]);

	foreach($need_report_list as $nr){
		$report = $smsObj->get_report($nr["cmid"]);
		//if($report->status == "3"){
			$obj->update_api_report($nr["cmid"], $report->RSLT, $report->msg_rslt);
		//}
	}
}

$stat = $obj->status($sch_date, $sch_date);
$data = $stat[0];


if($page=="") $page = 1;
$rowCnt = 15;
$result = $obj->get_list($page,"","","reg_date", "desc", $rowCnt, " AND substring(reg_date, 1, 10) = '{$sch_date}' ");
$list = $result["list"];



$qstr .= "&sch_date=$sch_date";
?>




<div class="Totalot2">	

	<form name="schform" id="schform" method="get">
		<input type="hidden" name="p" value="<?=$p?>" />
		<input type="hidden" name="action" value="<?=$action?>" />
		<div class="Topbar">

			<span style="position:relative;cursor:pointer;" onclick="$('#sch_date').val('<?=$prevDate?>');$('#schform').submit();"><span style="position:absolute;top:-3px;left:0;"><img src="/res/images/left01_btn.jpg" /></span></span>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<input type="text" class="Tinput01 calendar" name="sch_date" id="sch_date"" value="<?=$sch_date?>" style="width:70px;" onchange="$('#schform').submit()" />
			<span style="position:relative;cursor:pointer" onclick="$('#sch_date').val('<?=$nextDate?>');$('#schform').submit();"><span style="position:absolute;top:-3px;left:0;"><img src="/res/images/right01_btn.jpg" /></span></span>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<span class="Btn2 link3"><a href="javascript:void(0)" onclick="$('#schform').submit()">검색</a></span>
			
			
			<div class="Toprightb">
				<span class="Btn4 link3"><a href="./history.php?p=<?=$p?>&sch_year=<?=date("Y", strtotime($sch_date))?>&sch_month=<?=date("m", strtotime($sch_date))?>">목록보기</a></span>
			</div>
			
		</div>
		
		
	</form>
	
	
	
	<table class="t3" summary="">
		<colgroup>
			<col />
			<col />
			<col />
			<col />
			<col />
			<col />
			<col />
		</colgroup>
		<thead>
		  <tr>
		  	<th scope="col" colspan="3">성공</th>
		  	<th scope="col" colspan="4">실패</th>
		  </tr>
		  <tr>
			<th scope="col">알림톡 성공</th>
			<th scope="col">Failback 성공</th>
			<th scope="col">합계</th>
			<th scope="col">알림톡 실패</th>
			<th scope="col">Failback 실패</th>
			<th scope="col">기타실패</th>
			<th scope="col">합계</th>
		  </tr>
		</thead>
		<tbody>
		
			
				<tr class="colorhover">
					<td class="td-left"><?=number_format($data["kko"])?></td>
					<td ><?=number_format($data["msg"])?></td>
					<td ><?=number_format($data["kko"]+$data["msg"])?></td>
					
					<td ><?=number_format($data["kko_fail"])?></td>
					<td ><?=number_format($data["msg_fail"])?></td>
					<td ><?=number_format($data["fail"])?></td>
					<td ><?=number_format($data["kko_fail"] + $data["msg_fail"] + $data["fail"])?></td>
				</tr>
			
		
		</tbody>
	</table>

	<br/>
	<br/>

	<table class="t3" summary="">
		<colgroup>
			<col width="60px"/>
			<col width="60px"/>
			<col width="110px"/>
			<col />
			<col width="160px"/>
			<col width="160px"/>
			<col width="160px"/>
		</colgroup>
		<thead>
		  <tr>
			<th scope="col">#</th>
			<th scope="col">시간</th>
			<th scope="col">수신번호</th>
			<th scope="col">내용</th>
			<th scope="col">API전송</th>
			<th scope="col">알림톡</th>
			<th scope="col">Failback</th>
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
						<?=date("H:i", strtotime($row["reg_date"]))?>
					</td>
					<td >
						<?=$row["dest_number"]?>
					</td>
					<td style="text-align:left; padding-left:10px;">
						<?=conv_content($row["msg_content"], "2")?>
					</td>
					
					<td style="text-align:left; padding-left:10px;">
						<? if($row["api_status"] != ""){?>
							<?
								if($row["api_status"] == "200") {
									$stat_css = "color:#0000BB";
								} else {
									$stat_css = "color:#BB0000; font-weight:bold;";
								}
							?>
							<span style="<?=$stat_css?>">
								<?=$row["api_status"]?> : <?=APIStoreKKOResult::$KKO_STATUS[$row["api_status"]]?>
							</span>
						<?}?>
					</td>
			
					<td style="text-align:left; padding-left:10px;">
						<? if($row["kko_status"] != ""){?>
							<?
								if($row["kko_status"] == "0") {
									$stat_css = "color:#0000BB";
								} else {
									$stat_css = "color:#BB0000; font-weight:bold;";
								}
							?>
							<span style="<?=$stat_css?>">
								<?=$row["kko_status"]?> : <?=APIStoreKKOResult::$KKO_STATUS[$row["kko_status"]]?>
							</span>
						<?}?>
					</td>
					<td style="text-align:left; padding-left:10px;">
						<? if($row["msg_status"] != ""){?>
							<?
								if($row["msg_status"] == "0") {
									$stat_css = "color:#0000BB";
								} else {
									$stat_css = "color:#BB0000; font-weight:bold;";
								}
							?>
							<span style="<?=$stat_css?>">
								<?=$row["msg_status"]?> : <?=APIStoreKKOResult::$MSG_STATUS[$row["msg_status"]]?>
							</span>
						<? }?>
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




