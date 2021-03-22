<?
include_once("./_common.php");
include_once("$g4[admin_path]/admin.popup.php");


$mbObj = new Member();
if($stx){
	$listR = $mbObj->get_list(1, $sfl, $stx, $sst, $sod, PHP_INT_MAX, $search_query);
}
$list = $listR["list"];
$total_count = $listR["count"];
?>


<style>
	.list tbody tr:hover { background-color: #f5f5f5; }
    .list td {font-size:13px; }
</style>

<style>
.schtit {display:inline-block; padding:3px 10px; width:90px; background: #efefef; text-align:right; color:#2d2d2d; border:0px solid black; font-weight:bold; }
.schtit.on {display:inline-block; padding:3px 10px; width:90px; background: #0083b5; text-align:right; color:white; font-weight:bold; ; border:1px solid #0083b5; box-shadow:#a0a0a0 3px 3px 3px; cursor:pointer;}
.statistics td { text-align:left; padding-left:5px; padding-right:5px;}
</style>

<h2 style="margin:0 0 10px 0;">회원검색</h2>



<div class="navi"  style="min-width:90%;">
	<table width=100% >
			<tr>
				<td width=100% align=left style="padding:0 0 0 5px;">
					<form name=fsearch id="fsearch" method=get onsubmit="top.showLoading();">
					
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
								<td style="padding:0 0 0 5px;"><input type=text name=stx id="stx" class="Tinput01" itemname='검색어' value='<? echo $stx ?>' style="width:100px;"></td>
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

<div style="padding:5px; font-size:12px; width:98%; text-align:right;">
	총 검색된 회원 수 <?=number_format(count($list))?>명
</div>


<table width=100% cellpadding=0 cellspacing=0 class="list" style="table-layout: fixed;">
	<colgroup>
		<col width="150" />
		<col width="120" />
		<col width="150" />
		<col width="" />
	</colgroup>
	<thead>
	 <tr class='bgcol1 bold col1 ht center'>
		<td scope="col" class="th-left">회원ID</td>
		<td scope="col">회원명</td>
		<td scope="col">연락처</td>
		<td scope="col">전체선택<input type='checkbox' id="check_all" onchange="check_all(this)"/></td>
	  </tr>
	</thead>
	<tbody>
	

    <? if($sfl == ""){?>
        <tr class='list0 col1 ht center'>
            <td colspan="4">
                검색조건을 입력해주세요.
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
					<?=$row["mb_hp"]?>
				</td>
				<td>
                    <input type="checkbox" class="ids" value="<?=$row["mb_id"]?>" data-mbname="<?=$row["mb_name"]?>"/>
				</td>
				
				
				
			</tr>


		<?}?>
		
		
	</tbody>
</table>

<div style="position:fixed; bottom:0px; height:40px; width:99%; text-align:center; background-color:white; ">
	<span class="Btn4 link3" style="font-size:22px;"><a href="javascript:void(0);" style="" onclick='slt_complete()'>선택완료</a></span>
</div>

<div style="bottom:0px; height:60px; width:99%; text-align:center;">
	&nbsp;
</div>



<script>
$(function(){
    $("#stx").focus();
	top.closeLoading();
});

function slt_complete(){

	parent.clear_member_list();

	$(".ids:checked").each(function(){

		parent.select_member($(this).val(), $(this).data("mbname"));
	});

	parent.set_slt_mb_cnt();
	parent.$.colorbox.close();
}

function check_all(obj){
	if($(obj).is(":checked")){
		$(".ids").prop("checked","checked");
	} else {
		$(".ids").removeProp("checked","checked");

	}
}
</script>


</body>
</html>

