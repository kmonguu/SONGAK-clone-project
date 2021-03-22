<?
include_once("./_common.php");

$g4[title] = "메시지설정";
include_once ("$g4[admin_path]/admin.head.php");

$obj = new APIStoreKKOMessage();

$list = $obj->get_all_list($sfl, $stx, $sst, $sod,$search_query);


$qstr .= "";
?>

<div class="Totalot2" style="width:1400px;">	


	<div class="Topbar"  style="width:1400px;">
		<div class="Toprightb"><span class="Btn3 link3"><a href="./message_form.php">추가등록</a></span></div>
	</div>
	
	<table class="t3" summary="" style="table-layout:fixed;">
		<colgroup>
			<col width="50px" />
			<col width="150px" />
			<col width="90px" />
			<col width="180px" />
			<col width="150px" />
			<col width="200px" />
			<col />
			<col width="190px" />
		</colgroup>
		<thead>
		  <tr>
			<th scope="col" class="th-left">번호</th>
			<th scope="col"><?=subject_sort_link('msg_name')?>제목</a></th>
			<th scope="col"><?=subject_sort_link('msg_send_type')?>자동전송</a></th>
			<th scope="col"><?=subject_sort_link('msg_kko_template')?>템플릿코드</a></th>
			<th scope="col"><?=subject_sort_link('msg_kko_btntxt')?>버튼이름1</a></th>
			<th scope="col"><?=subject_sort_link('msg_kko_url')?>버튼링크1</a></th>
			<th scope="col"><?=subject_sort_link('msg_content')?>내용</a></th>
			<th scope="col"></th>
		  </tr>
		</thead>
		<tbody>
		
			<?for ($i=0; $i < count($list); $i++) { $row = $list[$i]; 
			?>
				<tr class="colorhover">
					<td class="td-left"><?=$row[no]?></td>
					<td ><?=$row["msg_name"]?></td>
					<td >
						<?if(USE_SHOP) { //config.php?>
							<?=APIStoreKKOMessage::$SEND_TYPE_SHOP[$row["msg_send_type"]]?>
						<?} else {?>
							<?=APIStoreKKOMessage::$SEND_TYPE[$row["msg_send_type"]]?>
						<?}?>
					</td>
					<td style="text-align:center; margin-left:5px;" class="ellipsis"><?=$row["msg_kko_template"]?></td>
					<td style="text-align:left; margin-left:5px;"><?=$row["msg_kko_btnname_1"]?></td>
					<td style="text-align:left; margin-left:5px;"><?=$row["msg_kko_btnurl_m_1"]?></td>
					<td style="text-align:left; margin-left:5px;" class="ellipsis">
                            <?=$row["msg_content"]?>
                    </td>
					<td class="link3">
						<span class="Btn1"><a href="./message_form.php?w=u&no=<?=$row[no]?>&<?=$qstr?>">상세보기</a></span>
						&nbsp;&nbsp;
						<span class="Btn2 link3"><a href="javascript:void(0)" onclick="delete_row('<?=$row["no"]?>')">삭제하기</a></span>
					</td>	
				</tr>
			<?}?>
			
			<? if(count($list) == 0) {?>
				<tr class="colorhover">
					<td colspan="8">등록된 메시지가 없습니다.</td>
				</tr>
			<? }?>
		
		</tbody>
	</table>
</div>


<form name="fdelete" id="fdelete" method="post" action="./message_form_update.php">
	<input type="hidden" name="p" value="<?=$p?>" />
	<input type="hidden" name="action" value="update" />
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


