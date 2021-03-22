<?
include_once("./_common.php");


$ycObj = new Yc4();
$obj = new Yc4Coupon();


$g4[title] = "쿠폰목록";
include_once("$g4[admin_path]/admin.head.php");


if($page=="") $page = 1;
$rowCnt = 15;
$result = $obj->get_list($page, $sfl, $stx, $sst, $sod, $rowCnt, $search_query);
$list = $result["list"];



$qstr = "page=$page&sfl=$sfl&stx=$stx&sod=$sod&sst=$sst";
?>


<div class="navi">
<table width=100%>
<form name=fsearch method=get>
<tr>
    <td width=70% align=left style="padding:0 0 0 5px;">
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
					<select name=sfl class=cssfl id="sfl">
						<option value='cpn_no'>쿠폰번호</option>
						<option value='m.mb_name'>이름</option>
						<option value='a.mb_id'>아이디</option>
						<option value='cpn_name'>쿠폰이름</option>
					</select>
					
					<script type="text/javascript">
						$("#sfl > option[value='<?=$sfl?>']").attr("selected", "selected");
					</script>
				</td>
				<td style="padding:0 0 0 5px;"><input type=text name=stx class=ed required itemname='검색어' value='<? echo $stx ?>'></td>
				<td style="padding:0 0 0 5px;"><input type=image src='<?=$g4[admin_path]?>/img/btn_search.gif' align=absmiddle></td>
				
			</tr>
		</table>
	</td>
	<td width=50% align=right style="padding:0 5px 0 0;">
		
    </td>
</tr>
</form>
</table>
</div>

<?=subtitle("개인 쿠폰지급")?>
<form name=fcouponlist2 method=post onsubmit="return fcouponlist2_submit(this);" autocomplete="off">
	<input type=hidden name=sfl   value='<?=$sfl?>'>
	<input type=hidden name=stx   value='<?=$stx?>'>
	<input type=hidden name=sst   value='<?=$sst?>'>
	<input type=hidden name=sod   value='<?=$sod?>'>
	<input type=hidden name=page  value='<?=$page?>'>
	<input type=hidden name=token value='<?=$token?>'>
	<input type=hidden name=sch_site value='<?=$sch_site?>' />
	
	<table width=100% cellpadding=0 cellspacing=1 class="list" style="margin:0px 0 20px;" >
		<colgroup>
			<col width="300px" />
			<col width="" />
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
		</colgroup>
		<tr class='bgcol1 bold col1 ht center'>
			<td>회원아이디</td>
			<td>쿠폰이름</td>
			<td>쿠폰타입</td>
			<td>할인율(할인가격)</td>
			<td>기간시작</td>
			<td>기간끝</td>
			<td>관리자패스워드</td>
			<td>&nbsp;</td>
		</tr>

		<tr class='ht center'>
			<td>
				
				<select type=text class=ed id="mb_id" name='mb_ids[]' multiple style="height:100px; width:200px; float:left;">
				</select>
				<div style="float:left; padding:3px 10px;">
					<span class="Btn4 link3">
						<a href="javascript:void(0);" id="btn_mb_slt" onclick='find_member()'>회원선택</a>
					</span>
				</div>
		
			</td>
			<td><input type=text class=ed name=cpn_name required itemname='쿠폰이름' style='width:99%;'></td>
			<td>
				<select class="Tselcet01" name="cpn_type" style="width:100px;">
					<option value="W">원 할인</option>
					<option value="P">퍼센트</option>
				</select>
			</td>
			<td><input type=text class=ed name=cpn_amt required itemname='할인율' style='width:99%;' ></td>
			<td><input type=text class="ed calendar" name=cpn_start required itemname='기간시작' style='width:70%;' readonly></td>
			<td><input type=text class="ed calendar" name=cpn_end required itemname='기간끝' style='width:70%;' readonly></td>
			<td><input type=password class=ed name=admin_password required itemname='관리자 패스워드' style='width:99%;' ></td>
			<td><input type=submit class=btn1 value=' 확  인 '></td>
		</tr>
	</table>

</form>

<script type="text/javascript">
function fcouponlist2_submit(f)
{
	<?if($w == "") {?>
		if($("#mb_id > option").size() == 0){
			alert("회원을 선택해주세요");
			return false;
		}
	<?}?>
	$("#mb_id > option").prop("selected", "selected");

    f.action = "./list_update.php";
    return true;
}


function find_member() {

    $.colorbox({href:"./find_member<?=$w == "" ? "2" : ""?>.php", iframe:true, width:"600px", height:"700px", transition:"none", scrolling:true,closeButton:true,overlayClose:true, onClosed:function(){ 
        
    }});

}

function select_find_member(mb_id, mb_name){
    $("#mb_id").val(mb_id);
    $.colorbox.close();
}


function clear_member_list(){
	$("#mb_id").html("");
}
function select_member(mb_id, mb_name){

	$("#mb_id").append("<option value='"+mb_id+"'>"+mb_name+"(" + mb_id+ ")</option>");
}
function set_slt_mb_cnt(){
	$("#btn_mb_slt").html("회원선택(" + $("#mb_id>option").size() + ")");
}


$( function() {

	var ulObj = $("#sortable");
	ulObj.sortable({
    	placeholder: "ui-state-highlight",
    	stop:function(event, ui){
           // $(".ui-state-default").index(ui.item);
        }
    });
	ulObj.disableSelection();

	var ulObj = $("#sortable");
	ulObj.sortable({
    	placeholder: "ui-state-highlight",
    	stop:function(event, ui){
           // $(".ui-state-default").index(ui.item);
        }
    });
	ulObj.disableSelection();


	$.datepicker.regional['ko'] = {
		closeText: '닫기',
		prevText: '이전달',
		nextText: '다음달',
		currentText: '오늘',
		monthNames: ['1월(JAN)','2월(FEB)','3월(MAR)','4월(APR)','5월(MAY)','6월(JUN)',
		'7월(JUL)','8월(AUG)','9월(SEP)','10월(OCT)','11월(NOV)','12월(DEC)'],
		monthNamesShort: ['1월','2월','3월','4월','5월','6월',
		'7월','8월','9월','10월','11월','12월'],
		dayNames: ['일','월','화','수','목','금','토'],
		dayNamesShort: ['일','월','화','수','목','금','토'],
		dayNamesMin: ['일','월','화','수','목','금','토'],
		weekHeader: 'Wk',
		dateFormat: 'yy-mm-dd',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: true,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['ko']);

	jQuery(".calendar").datepicker({
		showOn: "both",
		buttonImage: "/img/calendar.gif",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		showButtonPanel: false
	});

	jQuery(".calendar").datepicker({
		showOn: "both",
		buttonImage: "/img/calendar.gif",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		showButtonPanel: false
	});

});

</script>

<?=subtitle("쿠폰 현황")?>
<table width=100% cellpadding=0 cellspacing=0 class="list">
	<colgroup>
		<col width="90" />
		<col width="120"/>
		<col width="180"/>
		<col width="300"/>
		<col width="100"/>
		<col width="250"/>
		<col width="220"/>
		<col width="140"/>
		<col />
	</colgroup>
	<thead>
	 <tr class='bgcol1 bold col1 ht center'>
		<td scope="col" class="th-left"><?=subject_sort_link('cpn_id')?>번호</a></td>
		<td scope="col"><?=subject_sort_link('cpn_no')?>쿠폰번호</a></td>
		<td scope="col"><?=subject_sort_link('mb_name')?>고객</a></td>
		<td scope="col"><?=subject_sort_link('cpn_name')?>쿠폰이름</a></td>
		<td scope="col"><?=subject_sort_link('cpn_amt')?>할인액(률)</a></td>
		<td scope="col"><?=subject_sort_link('cpn_start')?>사용기간</a></td>
		<td scope="col"><?=subject_sort_link('use_date')?>사용여부</a></td>
		<td scope="col"></td>
		<td scope="col"></td>
	  </tr>
	</thead>
	<tbody>
		<?for ($i=0; $i < count($list); $i++) { $row = $list[$i];
		 
			if($row[use_date] != "") {
				$s_del = "&nbsp;";
			}else{
				$s_del = "<a href=\"javascript:del('./delete.php?cpn_id=$row[cpn_id]&$qstr', '$row[cpn_id]');\"><img src='/adm/img/icon_delete.gif' border=0 title='삭제'></a>";
			}
			
		?>
			<tr class='list0 col1 ht center'>
				<td><?=$row[cpn_id]?></td>
				<td>
					<?=$row[cpn_no]?>
				</td>
				<td>
					<?=$row[mb_name]?>
					[<?=$row[mb_id]?>]
				</td>
				<td>
					<?=$row[cpn_name]?>
				</td>
				<td>
					<?=$row[cpn_amt]?> <?=($row[cpn_type]=="P" ? "%" : "원")?>
				</td>
				<td>
					<?=$row[cpn_start]?> ~ <?=$row[cpn_end]?>
				</td>

				<td>
					<?if($row[use_date] != "") { ?>
						<span style='color:green;'>사용됨</span><br/>
						<?=$row[use_date]?>
					<? } else {?>
						<?if($row[useable] == "Y"){?>
							<span style='color:blue;'>사용가능</span>
						<? } else {?>
							<span style='color:red;'>기간만료</span>
						<? }?>
					<? }?>
				</td>
				
				<td>
					<?=$s_del?>
				</td>
				
				<td>

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
include_once ("$g4[admin_path]/admin.tail.php");
?>

