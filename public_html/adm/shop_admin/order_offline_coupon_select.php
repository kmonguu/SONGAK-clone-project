<?
include_once("./_common.php");


$smb_id = get_session("ss_od_offline_id");
if($smb_id == "") {
	echo "
		<script>
			alert('오프라인 주문을 입력할 회원이 선택되어있지 않습니다. 회원ID를(또는 비회원) 선택해주세요');
			top.$.colorbox.close();
		</script>
	";
}
$mbObj = new Member();
if($smb_id == "|guest|") {
	$member = array("mb_level"=>1);
	$is_member = false;
} else {
	$member = $mbObj->get($smb_id);
}





$g4[title] = "나의 쿠폰 조회";

$ycart = new Yc4();
$obj = new Yc4Coupon();

if($page=="") $page = 1;
$rowCnt = 65535;
$result = $obj->get_list($page, $sfl, $stx, $sst, $sod, $rowCnt, "  AND use_date = '' AND m.mb_id='{$member[mb_id]}'  ", "", "Y");
$list = $result["list"];

$qstr = "page=$page&sfl=$sfl&stx=$stx&sod=$sod&sst=$sst";

include_once("{$g4[path]}/head.sub.php");
?>

<style>
.loginbtn span.loginbtn1 {float:left;width:104px;height:30px;background:#1f1f1f;color:#b9b9b9;text-align:center;font-size:14px;line-height:29px;text-decoration:none;cursor:pointer;}
.loginbtn a:hover span {color:#ffffff;background:#000000;}
.loginbtn a:active span {color:#ffffff;background:#000000;}
.loginbtn {float:right;margin:15px 0 15px 0;padding:0 0 0 0;}


.Surveytit03 {float:left;color:#1f1f1f;font-size:14px;font-weight:bold;padding:0 0 0 32px;background:url("/res/images/total_ico04.jpg") no-repeat 6px 4px;line-height:21px;margin:10px 0 0 0;width:100%;}
table.b7 {width:100%;border:0;background:#fff;padding:0 0 0 0;}
table.b7 th {padding: 0;font-size:13px;background:#f4f4f4;font-weight:bold;color:#1f1f1f;height:38px;border-top:1px solid #455560;border-bottom:1px solid #455560;}
table.b7 td {border-bottom:1px solid #c7cccf;padding:0;height:40px;text-align:center;vertical-align:middle;color:#5e5e5e;background:#fff;}
table.b7 th.th-right {width:75px;}
table.b7 td.td-topone {border-bottom:1px solid #a2aaaf;height:1px;}
table.b7 td.td-top {}
table.b7 td.td-bottom {border-bottom:1px solid #1f1f1f;}
table.b7 td.td-bottom2 {border-bottom:1px solid #a2aaaf;height:40px;background:#f4f4f4;}
table.b7 td.Boardtit {text-align:left;padding:0 0 0 10px;}
table.b7 thead th, table.t1 tfoot th { text-align: center; vertical-align: middle;}

</style>


<p style="height:60px;line-height:60px;font-size:18px;font-weight:bold;color:#0c0c0c; width:100%; box-sizing:border-box; padding:0 20px; border-top:3px solid #222; border-bottom:2px dashed #eee; ">쿠폰 사용하기</p>


<div class="Surveytit03" style='width:90%;'>장바구니 목록</div>

<div class="Boradnlist Listlink" style="width:96%;float:left;margin-top:10px; padding:10px 2%;">
	<?
		$cart_list = $ycart->list_cart($on_uid);
	?>
	
	<table cellspacing="0" cellpadding="0" class="b7" summary="주문내역 입니다." style='width:100%;'>
		<colgroup>
			<col />
			<col width="120px"/>
			<col width="150px"/>
			<col width="90px"/>
			<col width="90px" />
		</colgroup>
		<thead>
		  <tr>
			<th scope="col">상품명</th>
			<th scope="col">가격</th>
			<th scope="col">쿠폰선택</th>
			<th scope="col">합계</th>
			<th scope="col">할인액</th>
		  </tr>
		</thead>
		<tbody>
			<tr>
				<td class="td-topone" colspan="5"></td>
			</tr>
			<? for($idx = 0 ; $idx < count($cart_list) ; $idx++){ $row = $cart_list[$idx]; 
				$cls = "";
				if(($idx+1) == count($cart_list)) $cls = "td-bottom";
				$it = $ycart->get_item($row[it_id]); 
				
				$cpnListTmp = $obj->get_list(1, "", "", "", "", 65545, "  AND use_date = '' AND m.mb_id='{$member[mb_id]}' ", "", "Y");
				$cpnList = $cpnListTmp["list"];
			?>
			<tr>
				<td class="<?=$cls?>" style='text-align:left;padding-left:10px;'><?=$it[it_name]?></td>
				<td class="<?=$cls?>"><?=number_format($row[ct_amount] * $row["ct_qty"])?> 원</td>
				<td class="<?=$cls?>">
						<select name='coupon' class="coupons" style='height:32px; width:140px;' onchange="change_coupon(this.value, '<?=$it[it_id]?>', '<?=$row[ct_id]?>')">
							<option value="">선택해주세요</option>
							<? foreach ($cpnList as $cpn) {?>
								<option value="<?=$cpn[cpn_id]?>::<?=$row[ct_id]?>">[<?=$cpn[cpn_no]?>]<?=$cpn[cpn_name]?></option>
							<? }?>
						</select>
				</td>
				<td class="<?=$cls?>">
					<input type="hidden" id='it_amount_<?=$row[ct_id]?>' value='<?=$row[ct_amount]* $row["ct_qty"]?>'>
					<span style="color:blue;" id="disp_amount_<?=$row[ct_id]?>"></span>
				</td>
				<td class="<?=$cls?>">
					<input type="hidden" class="discount_values" id='discount_<?=$row[ct_id]?>' value=''>
					<span style="color:blue;" id="disp_discount_<?=$row[ct_id]?>"></span>
				</td>
			</tr>
			<? }?>
			
			<tr >
				<td colspan="5" style='text-align:right;padding-right:15px;'>
						
						<div class="loginbtn">
							<a href="javascript:void(0)" onclick='coupon_set()'><span class="loginbtn1">쿠폰적용</span></a>
						</div> 
				
				</td>
			</tr>
		</tbody>
	</table>
	
</div>





<div class="Surveytit03" style='width:90%; margin-top:25px;'>보유 쿠폰 내역</div>

<div class="Boradnlist Listlink" style="float:left;margin-top:10px; padding:10px 10px 10px 10px;">
	

	<table cellspacing="0" cellpadding="0" class="b7" summary="주문내역 입니다." style='width:100%; table-layout:fixed;'>
		<colgroup>
			<col width="90px" />
			<col width="" />
			<col width="120px" />
			<col width="180px" />
			<col width="120px" />
			<col width="40px" />
		</colgroup>
		<thead>
		  <tr>
			<th scope="col">쿠폰번호</th>
			<th scope="col">쿠폰명</th>
			<th scope="col">할인율(액)</th>
			<th scope="col">사용기간</th>
			<th scope="col">사용여부</th>
			<th scope="col"></th>
		  </tr>
		</thead>
		<tbody>
			<tr>
				<td class="td-topone" colspan="6"></td>
			</tr>

			
			<?for ($i=0; $i < count($list); $i++) { $row = $list[$i];

				if($row[useable] != "Y") continue; 
				$cls = "";
				if(($i+1) == count($list)) $cls = "td-bottom";
			
			?>
			<tr>
				<td class="<?=$cls?>">
					<?=$row[cpn_no]?>
				</td>
				<td class="<?=$cls?>">
					<?=$row["cpn_name"]?>
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
							<span style='color:red;'>기간만료</span>
						<? }?>
					<? }?>
				</td>
	
				<td class="<?=$cls?>">

				</td>
				
			</tr>
		<?}?>
		
		<? if(count($list) == 0) {?>
			<tr class='list0 col1 ht center'>
				<td colspan="6">
					<?=msg("쿠폰이 없습니다.")?>
				</td>
			</tr>
		<? }?>
		
		
		</tbody>
	</table>
</div>



<script type="text/javascript">

	function coupon_set(){

			var validFlag = true;
			var cpnStr = "";
			var cpnIDStr = "";
			var sltObj = null;
			$(".coupons").each(function(){

				var cpnNo = $(this).find("option:selected").html();
				var cpnID = $(this).find("option:selected").val();

				if(cpnID != "" && cpnStr != "" && cpnStr.indexOf(cpnNo) != -1) {
					validFlag = false;
					sltObj = this;
					return;
				}

				if(cpnID != "") {
				
					if(cpnStr != "") { 
							cpnStr += "|"; //구분자
							cpnIDStr += "|";
					}
					cpnStr += cpnNo;
					cpnIDStr += cpnID;
				
				}
			
			});


			
			if(!validFlag) {
					alert("하나의 쿠폰은 한번만 사용될 수 있습니다.");
					$(sltObj).focus();
					return;
			}
			
			var tot_cpnamt = 0;
			$(".discount_values").each(function(){
					if($(this).val() != "")
						tot_cpnamt += parseInt($(this).val());
			});	
		
			parent.coupon_set(cpnIDStr, tot_cpnamt);
	}

	function change_coupon(cpn_id, it_id, ct_id){
		
		if(cpn_id == ""){
			 $("#disp_amount_"+ct_id).html("");
         	 $("#disp_discount_"+ct_id).html("");
         	$("#discount_"+ct_id).val(0);
		} else {
			$.post("<?=$g4["shop_path"]?>/_ajax_cpn_amount.php", "it_id="+it_id + "&cpn_id="+cpn_id + "&ct_id="+ct_id, function(data){
	
				 var ctamt = parseInt($("#it_amount_"+ct_id).val());
				 var tamt = ctamt - parseInt(data);
				 $("#disp_amount_"+ct_id).html(number_format(tamt+"") + " 원");
	         	 $("#disp_discount_"+ct_id).html(number_format(data+"") + " 원");

	         	 $("#discount_"+ct_id).val(data);
	        });
		}
        
	}
</script>



<?
include_once("{$g4[path]}/tail.sub.php");
?>