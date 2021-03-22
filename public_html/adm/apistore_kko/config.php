<?
include_once("./_common.php");

$g4[title] = "알림톡 환경설정";
include_once ("$g4[admin_path]/admin.head.php");



$obj = new APIStoreKKOConfig();

$row = $obj->get($ss_com_id);

$smsObj = new APIStoreKKO($row["api_id"], $row["api_key"]);


//발신자번호 리스트
$numberlist = $smsObj->list_sender_number();
if(count($numberlist) == 0) $numberlist = array();

?>



<div class="Totalot2">	

	<form name="fwrite" id="fwrite" action="./config_update.php" method="post" onsubmit="return fsubmit();">
	<input type="hidden" name="p" value="<?=$p?>"/>
	<input type="hidden" name="action" value="update"/>
	<input type="hidden" name="w" value="<?=$w?>" />
	
	
	<div class="Wright01">
		<table class="t4" summary="">
			<colgroup>
				<col width="17%" />
				<col width="35%" />
				<col width="" />
			</colgroup>			
			<tbody>
				<tr class="">
					<td class="td01" >▶ 발신자번호</td>
					<td>
						<? $sender_number = APIStoreKKO::mphon($row["sender_number"]); ?>
						<input type="text" class="Tinput02" name="sender_number" value="<?=$sender_number?>" style="width:120px;" />
						<?
						$isReg = false;
						foreach($numberlist as $list) {
							if($list->sendnumber == str_replace("-", "", $row["sender_number"])) { $isReg = true; break; }
						}
						?>
						<? if(!$isReg) {?>
						<span style='color:#CC0000;'>등록되지 않은 발신자번호입니다.</span>
						<? }?>
					</td>
					<td>
						사전등록한 발신번호가 아니면 발송이 되지 않습니다.
					</td>
				</tr>
				
				<tr class="">
					<td class="td01" >▶ Failback 사용</td>
					<td>
						<select class="Tselcet01" name="use_failback">
							<option value="">사용안함</option>
							<option value="Y" <?=$row["use_failback"] == "Y" ? "selected" : ""?> >사용</option>
						</select>
					</td>
					<td>
						카카오알림톡 전송 실패시 SMS전송 사용여부 <br/>(90byte초과시 자동으로 LMS로 전송)
					</td>
				</tr>
				
				<tr class="">
					<td class="td01" >▶ Failback 제목</td>
					<td>
						<input type="text" class="Tinput02" name="sender_name" value="<?=$row["sender_name"]?>" />
					</td>
					<td>
						Failback 메시지가 LMS일 경우에만 사용됩니다
					</td>
				</tr>
				
				<tr class="">
					<td class="td01" >▶ API STORE ID</td>
					<td>
						<input type="text" class="Tinput02" name="api_id" value="<?=$row["api_id"]?>" />
					</td>
					<td>
					</td>
				</tr>
				
				<td class="td01" >▶ API STORE KEY</td>
					<td colspan="2">
						<input type="text" class="Tinput02" name="api_key" value="<?=$row["api_key"]?>" />
					</td>
				</tr>
				
				<?
				$checkID = $smsObj->check_id(); 
				if($checkID != "OK"){?>
				<td class="td01" >▶ ERROR</td>
					<td colspan="2" style='color:#CC0000;'>
						<?=$checkID?>
					</td>
				</tr>
				<? }?>
				
				
				
			</tbody>
		</table>
	</div>
	

	<div class="Topbar02" style="margin-top:10px;">		
		<div class="Toprightb">
			<span class="Btn3 link3"><a href="javascript:void(0)" onclick="$('#fwrite').submit()">저장하기</a></span>
		</div>
	</div>

	
	</form>	
	
	
	
	<div class="Topbar02" style="float:left;margin-top:16px; height:49px;">	
		<div style="position:absolute;top:4px;left:0;font-weight:bold;font-size:16px;">:: APISTORE KKO에 발신자번호 등록</div>
		<div style="position:absolute;top:28px;left:14px;font-weight:bold;font-size:12px; font-weight:normal; ">등록된 발신번호는 삭제/변경 할 수 없습니다. </div>
	</div>
	
	<div class="Wright01">
		<table class="t4" summary="">
			<colgroup>
				<col width="20%" />
				<col width="35%" />
				<col width="20%" />
				<col width="10%" />
				<col width="15%" />
			</colgroup>			
			<tbody>
				<tr class="">
					<td class="td01" >▶ 발신자번호 등록하기</td>
					<td>
						<input type="text" class="Tinput02" id="add_sender_number" value="" style="width:120px;" placeholder="발신자번호" />&nbsp;&nbsp;
						<input type="text" class="Tinput02" id="add_sender_comment" value="" style="width:150px;" placeholder="COMMENT" />
					</td>
					<td>
						<span class="Btn3 link3"><a href="javascript:void(0)" onclick="add_sender_number(false)">발신자번호 등록 요청</a></span>
					</td>
					
					<td>
						<input type="text" class="Tinput02" id="add_pincode" value="" style="width:100px;" placeholder="PINCODE" />
					</td>
					<td>
						<span class="Btn3 link3"><a href="javascript:void(0)" onclick="add_sender_number(true)">인증번호입력</a></span>
					</td>
					
				</tr>
			</tbody>
		</table>
	</div>
	
	<br/>
	
	<div class="Topbar02" style="float:left;margin-top:16px;">	
		<div style="position:absolute;top:4px;left:0;font-weight:bold;font-size:16px;">:: APISTORE KKO에 등록된 발신번호 </div>
	</div>
	
	<div class="Wright01">
		<table class="t3" summary="">
		<colgroup>
			<col width="250px"/>
			<col />
			<col width="300px"/>
		</colgroup>
		<thead>
		  <tr>
			<th scope="col" class="th-left">발신번호</th>
			<th scope="col">COMMENT</th>
			<th scope="col">인증</th>
		  </tr>
		</thead>
		<tbody id="datalist_senderinfo">
			<?
				if($numberlist != null && count($numberlist) > 0) { 
					$numIdx = 0;
					foreach($numberlist as $list){
						$numIdx++;
						$phonenum = APIStoreKKO::mphon($list->sendnumber);
						
						
						echo "
							<tr>
								<td>{$phonenum}</td>
		                        <td style='text-align:left; padding-left:10px;'>{$list->comment}</td>
		                        <td id='tdPin_{$numIdx}'>";

									if($list->use_yn == "Y") {
										echo "인증이 완료된 번호입니다";
									} else {
										echo "
											<input type='text' id='pincode_{$numIdx}' value='' class='Tinput02' style='width:100px;' placeholder='PINCODE' />
											<span class='Btn3 link3'><a href='javascript:void(0)' onclick='send_pinnumber(\"{$phonenum}\", \"{$list->comment}\", {$numIdx})' >인증번호입력</a></span>
										";
									}
		                echo
		                	 	  	"</td>
							</tr>
						";
					}
				} else {
					
					echo "
					<tr id='senderinfo_none'>
						<td colspan='3'>등록된 발신자번호가 없습니다.</td>
					</tr>
					";
				}
			?>
		</tbody>
		</table>
	</div>
	
</div>	



<script>

var is_req = false;
			
//발신자번호 등록
function add_sender_number(is_pincode){

	if(!is_req && is_pincode) {
		alert("먼저 발신자번호 등록요청을 진행해주세요!");
		return;
	}
	
	
	
	var add_number = $("#add_sender_number").val();
	var add_comment = $("#add_sender_comment").val();
	var pincode = "";
	if(is_pincode){
		pincode = $("#add_pincode").val();
		if(pincode == ""){
			alert("인증번호를 입력해주세요");
			$("#add_pincode").focus();
			return;
		}
	}

	if(add_number == ""){
		alert("발신자번호를 입력해주세요");
		$("#add_sender_number").focus();
		return;
	}


	if(!is_pincode){
		if(!confirm("번호 : " + add_number + "\n\n메모 : " + add_comment + "\n\n등록된 발신번호는 삭제/변경하실 수 없습니다.\n발신자 번호를 등록요청을 진행하시겠습니까? ")) return;
	}

	
	$.post("./_ajax_add_kko_sender_number.php", {
		p:"<?=$p?>"
		, action:""
		, number:add_number
		, comment:add_comment
		, pincode:pincode
	}, function(data){
		
		if(data != "OK"){
			error_code(data);
		} else {
			if(is_pincode) {
				alert("발신자번호 등록이 완료되었습니다.");
				$(".senderinfo_none").remove();
				$("#datalist_senderinfo").append("<tr><td>"+add_number+"</td><td style='text-align:left; margin-left:5px;'>"+add_comment+"</td><td>인증이 완료된 번호입니다.</td></tr>");
			} else {
				is_req = true;
				alert("인증번호가 요청되었습니다. SMS로 전송된 인증번호를 우측에 입력하시고 인증 버튼을 클릭해주세요!");
			}
			//$(".senderinfo_none").remove();
			//$("#datalist_senderinfo").append("<tr><td>"+add_number+"</td><td style='text-align:left; margin-left:5px;'>"+add_comment+"</td></tr>");
			
		}
		
	});
}




//발신자번호 등록
function send_pinnumber(num, comment, pincodeNo){
	
	
	
	var add_number = num;
	var add_comment = comment;
	var pincode = $("#pincode_"+pincodeNo).val();
	if(pincode == ""){
		alert("인증번호를 입력해주세요");
		$("#pincode_"+pincodeNo).focus();
		return;
	}

	
	$.post("./_ajax_add_kko_sender_number.php", {
		p:"<?=$p?>"
		, action:""
		, number:add_number
		, comment:add_comment
		, pincode:pincode
	}, function(data){
		
		if(data != "OK"){
			error_code(data);
		} else {
			if(is_pincode) {
				is_req = false;
				alert("발신자번호 등록이 완료되었습니다.");
				$("#tdPin_"+pincodeNo).html("인증이 완료된 번호입니다.");
			} else {
				alert("인증번호가 요청되었습니다. 3분 이내로 SMS로 전송된 인증번호를 우측에 입력하시고 인증 버튼을 클릭해주세요!");
			}
			//$(".senderinfo_none").remove();
			//$("#datalist_senderinfo").append("<tr><td>"+add_number+"</td><td style='text-align:left; margin-left:5px;'>"+add_comment+"</td></tr>");
			
		}
		
	});
}



function error_code(code){

	
	switch(code){
		case "300" : alert("파라메터 에러, 관리자에게 문의해주세요"); break;
		case "400" : alert("인증업데이트 중 에러, 잠시 후 다시 시도해주세요"); break;
		case "500" : alert("이미 등록된 번호입니다."); break;
		case "600" : alert("인증번호가 일치하지 않습니다. 다시 확인하시고 입력해주세요"); break;
		case "700" : alert("인증번호 인증 시간이 만료되었습니다, 발신자번호 등록요청을 다시 진행해주세요 "); break;
		default : alert(code); break;
	}
	
}



			
function fsubmit(){
	
	
	return true;
}
</script>