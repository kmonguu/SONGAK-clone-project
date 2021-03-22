<?
include_once("./_common.php");
auth_check($auth[$sub_menu], "r");


$g4[title] = "메시지관리";
include_once("{$g4["admin_path"]}/admin.head.php");



if($page=="") $page = 1;
$rowCnt = 30;




$obj = new Sms4Message();
$result = $obj->get_list($page, $sfl, $stx, $sst, $sod, $rowCnt, $search_query);
$list = $result["list"];
$total_page  = ceil($result["count"] / $rowCnt);  // 전체 페이지 계산
$qstr .= Common::make_search_qstr();
?>

<div class="Totalot2" style="width:1400px;">	


	<div class="Topbar"  style="width:1400px;">
		<div class="Toprightb"><span class="Btn3 link3"><a href="./message_form.php?p=<?=$p?>">추가등록</a></span></div>
	</div>
	
	<table class="t3" summary="" style="table-layout:fixed;">
		<colgroup>
			<col width="150px" />
			<col width="200px" />
			<col />
			<col width="200px" />
		</colgroup>
		<thead>
		  <tr>
			<th scope="col" class="th-left"><?=subject_sort_link('msg_send_number')?>발신번호</a></th>
			<th scope="col"><?=subject_sort_link('msg_name')?>제목</a></th>
			<th scope="col"><?=subject_sort_link('msg_content')?>내용(일부)</a></th>
			<th scope="col"></th>
		  </tr>
		</thead>
		<tbody>
		
            <?for ($i=0; $i < count($list); $i++) { $row = $list[$i]; 

			?>
				<tr class="colorhover">
					<td><?=$row["msg_send_number"]?></td>
					<td style="text-align:left; margin-left:5px;"  class="ellipsis"><?=$row["msg_name"]?></td>
					<td style="text-align:left; margin-left:5px;" class="ellipsis">
                            <?=$row["msg_content"]?>
                    </td>
					<td class="link3">
						<span class="Btn4"><a href="./message_form.php?w=u&no=<?=$row[no]?>&<?=$qstr?>">상세보기</a></span>
						&nbsp;&nbsp;
						<span class="Btn2 link3"><a href="javascript:void(0)" onclick="delete_row('<?=$row["no"]?>')">삭제하기</a></span>
					</td>	
				</tr>
			<?}?>
			
			<? if(count($list) == 0) {?>
				<tr class="colorhover">
					<td colspan="4">등록된 메시지가 없습니다.</td>
				</tr>
			<? }?>
		
		</tbody>
	</table>
</div>


<form name="fdelete" id="fdelete" method="post" action="./message_form_update.php">
	<input type="hidden" name="w" value="d" />
	<input type="hidden" name="no" value="" />
</form>

<script>
function delete_row(no){
	if(!confirm("삭제하시겠습니까?")) return;
	document.fdelete.no.value = no;
	document.fdelete.submit();
}
</script>


