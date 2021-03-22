<?
include_once("./_common.php");
include_once("$g4[admin_path]/admin.popup.php");


$obj = new Member();
$search_query = "";
if($sfl != ""){
	$search_query = " AND {$sfl} LIKE '%{$stx}%' ";
	$list = $obj->get_list_all($search_query);
}

?>


<style>
	.list tbody tr:hover { background-color: #f5f5f5; }
    .list td {font-size:13px; font-family:'맑은 고딕'}
</style>



<h2 style="font-family:'맑은 고딕'; margin:0 0 10px 0;">회원검색</h2>



<div class="navi"  style="min-width:90%;">
	<table width=100% >
			<tr>
				<td width=60% align=left style="padding:0 0 0 5px;">
					<form name=fsearch id="fsearch" method=get>
					
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td>
										
										<select name=sfl  id="sfl" class="Tselcet01" data-width="100px">
											<option value='mb_name'>회원명</option>
											<option value='mb_id'>회원ID</option>
											<option value='mb_hp'>회원연락처</option>
										</select>
											
										<script type="text/javascript">
											$("#sfl > option[value='<?=$sfl?>']").attr("selected", "selected");
										</script>
								</td>
								<td style="padding:0 0 0 5px;"><input type=text name=stx id="stx" class="Tinput01" itemname='검색어' value='<? echo $stx ?>'></td>
								<td style="padding:0 0 0 5px;">
									<input type=image src='<?=$g4[admin_path]?>/img/btn_search.gif' align=absmiddle>
								</td>
								
							</tr>
						</table>
						
						
						
					</form>
				</td>
				 <td width=40% style="padding:0 5px 0 0;">
							
			    </td>
			</tr>
	
	</table>
</div>


<table width=100% cellpadding=0 cellspacing=0 class="list" style="table-layout: fixed;">
	<colgroup>
		<col width="110" />
		<col width="" />
		<col width="110" />
	</colgroup>
	<thead>
	 <tr class='bgcol1 bold col1 ht center'>
		<td scope="col" class="th-left">회원ID</td>
		<td scope="col">회원명</td>
		<td scope="col">선택</td>
	  </tr>
	</thead>
	<tbody>
	

    <? if($sfl == ""){?>
        <tr class='list0 col1 ht center'>
            <td colspan="3">
                검색어를 입력해주세요.
            </td>
        </tr>
    <?}?>
	
    <?
    for ($i=0; $i < count($list); $i++) { 
            $row = $list[$i]; 
    ?>


			<tr class='list0 col1 ht center'>


				<td>
					<?=$row["mb_id"]?>
				</td>

                <td>
					<?=$row["mb_name"]?>
				</td>


				<td>
                   <a href="javascript:void(0);" onclick='parent.select_find_member("<?=$row["mb_id"]?>","<?=$row["mb_name"]?>")'><span class="bbtn1">선택</span></a>
				</td>
				
			</tr>


		<?}?>
		
		
	</tbody>
</table>



<script>
$(function(){
    $("#stx").focus();

});
</script>


</body>
</html>

