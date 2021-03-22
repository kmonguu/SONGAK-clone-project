<?
include_once("./_common.php");


$g4[title] = "나의 쿠폰 조회";

$obj = new Yc4Coupon();

if($page=="") $page = 1;
$rowCnt = 15;
$result = $obj->get_list($page, $sfl, $stx, $sst, $sod, $rowCnt, " AND m.mb_id='{$member[mb_id]}' ");
$list = $result["list"];

$qstr = "page=$page&sfl=$sfl&stx=$stx&sod=$sod&sst=$sst";

include_once("{$g4[path]}/head.sub.php");
?>

<style>
</style>

<div class="Boradnlist Listlink" style="width:100%;display:inline-block;margin-top:10px;">
	<table cellspacing="0" cellpadding="0" class="b7" summary="주문내역 입니다.">
		<colgroup>
			<col />
			<col />
			<col />
			<col />
			<col width="" />
		</colgroup>
		<thead>
		  <tr>
			<th scope="col">쿠폰번호</th>
			<th scope="col">쿠폰이름</th>
			<th scope="col">할인율(액)</th>
			<th scope="col">사용기간</th>
			<th scope="col">사용여부</th>
			<th scope="col"></th>
		  </tr>
		</thead>
		<tbody>
			<tr>
				<td class="td-topone" colspan="8"></td>
			</tr>

			
			<?for ($i=0; $i < count($list); $i++) { $row = $list[$i];
		 		
				$cls = "";
				if(($idx+1) == count($list)) $cls = "td-bottom";
				
				$s_del = "";
				//if($row[use_date] == "") {
					$s_del = "<a href=\"javascript:del('./coupon_delete.php?cpn_id=$row[cpn_id]&$qstr', '$row[cpn_id]');\"><img src='../shop/img/btn_del.gif' border='0' align='absmiddle' alt='삭제'></a>";
				//}
				
			?>
			<tr>
				<td class="<?=$cls?>">
					<?=$row[cpn_no]?>
				</td>
				<td class="<?=$cls?>">
					<?=$row[cpn_name]?>
				</td>
				<td class="<?=$cls?>">
					<?=$row[cpn_amt]?> <?=($row[cpn_type]=="P" ? "%" : "원")?>
				</td>
				<td class="<?=$cls?>">
					<?=$row[cpn_start]?> ~ <?=$row[cpn_end]?>
				</td>

				<td class="<?=$cls?>">
					<?if($row[use_date] != "") { ?>
						<span style='color:green;'>사용됨</span><br/>
						<?=$row[use_date]?>
					<? } else {?>
						<?if($row[useable] == "Y"){?>
							<span style='color:blue;'>사용가능</span>
						<? } else {?>
							<span style='color:red;'>사용불가</span>
						<? }?>
					<? }?>
				</td>
	
				<td class="<?=$cls?>">
					<?=$s_del?> 
				</td>
				
			</tr>
		<?}?>
		
		<? if(count($list) == 0) {?>
			<tr class='list0 col1 ht center'>
				<td colspan="10">
					<?=msg("쿠폰이 없습니다.")?>
				</td>
			</tr>
		<? }?>
		
		
		</tbody>
	</table>
</div>


<?
	//페이지 생성
	$total_page  = ceil($result["count"] / $rowCnt);  // 전체 페이지 계산
	$pagelist = get_paging2(Props::get("write_pages"), $page, $total_page, "?mb_id=$mb_id&$qstr&page=");
?>
<div class="Boardpage linkpage">
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





<?
include_once("{$g4[path]}/tail.sub.php");
?>