<?
include_once("./_common.php");
include_once("$g4[admin_path]/admin.popup.php");


if($sfl == "car_nums") {
    $obj = new Cars();
    $list = $obj->find_carnum($_GET["stx"]);
} else {
    $obj = new Member();
    $search_query = "";
    if($sfl != ""){
        $search_query = " AND {$sfl} LIKE '%{$stx}%' ";
        $list = $obj->get_list_all($search_query);
    }
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
										
										<select name=sfl  id="sfl" class="editable_sltbox" data-width="100px">
											<option value='mb_name'>회원명</option>
											<option value='mb_id'>회원ID</option>
											<option value='mb_hp'>회원연락처</option>
											<option value='car_nums'>차량번호</option>
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
		<col width="110" />
		<col width="" />
		<col width="110" />
	</colgroup>
	<thead>
	 <tr class='bgcol1 bold col1 ht center'>
		<td scope="col" class="th-left">회원ID</td>
		<td scope="col">회원명</td>
		<td scope="col" class="th-left">차량번호</td>
		<td scope="col">선택</td>
		<td scope="col">-</td>
	  </tr>
	</thead>
	<tbody>
	

    <? if($sfl == ""){?>
        <tr class='list0 col1 ht center'>
            <td colspan="5">
                검색어를 입력해주세요.
            </td>
        </tr>
    <?}?>
	
    <?
    $carObj = new Cars();
    for ($i=0; $i < count($list); $i++) { 

            $row = $list[$i]; 
            $carStr = "";
            if($sfl != "car_nums"){
                $carlist = $carObj->get_all_list("","","","", " AND a.mb_id = '{$row[mb_id]}' ");    
                foreach($carlist as $car){
                    if($carStr != "") $carStr .= ", ";
                    $carStr .= $car["car_num"];
                }
            } else {
                $carStr = $row["car_num"];
            }
    ?>


			<tr class='list0 col1 ht center'>


				<td>
					<?=$row["mb_id"]?>
				</td>

                <td>
					<?=$row["mb_name"]?>
				</td>

				<td>
					<?=$carStr?>
				</td>
				
				<td>
                    <span class="Btn4 link3"><a href="javascript:void(0);" onclick='parent.select_find_member("<?=$row["mb_id"]?>","<?=$row["mb_name"]?>")'>선택</a></span>
				</td>
				<td>
					&nbsp;
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

