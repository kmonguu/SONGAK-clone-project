<?
include_once("./_common.php");


$g4[title] = "메시지설정";
include_once ("$g4[admin_path]/admin.head.php");




$obj = new APIStoreKKOMessage(); 

if($w != ""){
		$row = $obj->get($no);
}

//echo conv_content($obj->make_resv_message($row["msg_content"], 54), "2");
?>



<div class="Totalot2">	

	<form name="fwrite" id="fwrite" action="./message_form_update.php" method="post" onsubmit="return fsubmit();">
	<input type="hidden" name="p" value="<?=$p?>"/>
	<input type="hidden" name="action" value="update"/>
	<input type="hidden" name="w" value="<?=$w?>" />
	<input type="hidden" name="no" value="<?=$no?>" />
	
	<div class="Topbar02">			
		<div class="Toprightb">

			<span class="Btn1 link3"><a href="./message_list.php?p=<?=$p?>&<?=$qstr?>">목록보기</a></span>&nbsp;&nbsp;
			
			<span class="Btn3 link3"><a href="javascript:void(0)" onclick="$('#fwrite').submit()">저장하기</a></span>
			
		</div>
	</div>
	
	<div class="Wright01">
		

		<?
			$confObj = new APIStoreKKOConfig();
			$conf = $confObj->get();
			$apiObj = new APIStoreKKO($conf["api_id"], $conf["api_key"]);
			$templates = $apiObj->list_template();
		?>
		<table class="t4" summary="">
			<colgroup>
				<col width="20%" />
				<col  />
			</colgroup>			
			<tbody>
				<tr class="">
					<td class="td01">▶ 템플릿 불러오기</td>
					<td>
						<select class="Tselcet01" id="template">
							<option value="">선택해주세요</option>
							<?for($idx = 0 ; $idx < count($templates); $idx++){ $tmp = $templates[$idx]?>
								<option value='<?=$tmp["template_code"]?>'><?=$tmp["template_name"]?> (<?=$tmp["template_code"]?>)</option>
							<?}?>
						</select>

						<span class="Btn3 link3"><a href="javascript:void(0)" onclick="load_template()">불러오기</a></span>
						<br/>
						<span style='display:inline-block;font-weight:normal; padding:7px 0 0 0; color:#DD0000;line-height:1.6;'>
						* 불러온 템플릿 내용의 <strong>변수명(#{변수명})</strong>과 홈페이지에서 사용하는 변수명이 다를 수 있습니다<br/>
						* 하단 <strong>[::사용가능한 변수목록]</strong>표를 참고하여, 홈페이지에서 사용하는 변수명으로 변경해주시기 바랍니다.<br/>
						* 템플릿에 등록된 변수명과 하단의 "내용"에 입력된 변수명이 달라도 전송에 지장이 없습니다.<br/>
						&nbsp;&nbsp;예) 템플릿에 #{이름}으로 된 변수명을 하단의 "내용"에서는 #{고객이름}으로 변경해도 무관 
						</span>
					</td>
				</tr>
			</tbody>
		</table>
		<br/>
	


		<table class="t4" summary="">
			<colgroup>
				<col width="13%" />
				<col  />
			</colgroup>			
			<tbody>
				<tr>
					<td colspan="2" class="tb01">
						<span style="color:#cc0000;">
							**&nbsp;<a href="https://www.apistore.co.kr" style='color:#cc0000;' target="_blank">[API스토어]</a> ▶ 마이홈 ▶ 알림톡관리 ▶ 템플릿관리에 등록된 템플릿과 아래 입력된 내용이 일치해야 정상적으로 전송 가능합니다.
						</span>
					</td>
				</tr>
				<tr class="">
					<td class="td01">▶ 순번</td>
					<td>
						<?=$row["no"]?>
					</td>
				
				</tr>
				<tr class="">
					<td class="td01">▶ 제목</td>
					<td>
						<input type="text" class="Tinput01" name="msg_name" id="template_name" required value="<?=$row[msg_name]?>" style="width:200px;"/>
					</td>
				</tr>


				<tr class="">
					<td class="td01">▶ 자동전송 </td>
					<td>
						<select class="Tselcet01" name="msg_send_type" style="min-width:120px;">
							<option value="">사용안함</option>
							<?if(USE_SHOP) { //config.php?>
								<?foreach(APIStoreKKOMessage::$SEND_TYPE_SHOP as $key=>$value){?>
									<option value="<?=$key?>" <?=$row["msg_send_type"]==$key ? "selected" : ""?> ><?=$value?></option>
								<?}?>
							<?} else {?>
								<?foreach(APIStoreKKOMessage::$SEND_TYPE as $key=>$value){?>
									<option value="<?=$key?>" <?=$row["msg_send_type"]==$key ? "selected" : ""?> ><?=$value?></option>
								<?}?>
							<?}?>
						</select>
						
					</td>
				</tr>



				<tr class="">
					<td class="td01">▶ 템플릿코드</td>
					<td>
						<input type="text" class="Tinput01" name="msg_kko_template" id="template_code" required value="<?=$row[msg_kko_template]?>" style="width:200px;"/>
					</td>
				</tr>
				<tr class="">
					<td class="td01">▶ 내용</td>
					<td>
						<textarea name="msg_content" id="template_msg" style="width:99%;height:300px; background-color:#def6ff; line-height:1.5; font-size:14px;"><?=$row["msg_content"]?></textarea>
					</td>
				</tr>
				
				
				<?for($idx = 1 ; $idx <= 5; $idx++){?>
				
				<tr class="">
					<td colspan="2" style="font-size:3px; height:4px;padding:0px;">&nbsp;</td>
				</tr>
				<tr class="">
					<td class="td01">▶ 버튼타입<?=$idx?> </td>
					<td>
						<select class="btnTypes Tselcet01" name="msg_kko_btntype_<?=$idx?>" id="btn_type_<?=$idx?>" onchange="change_btn_type(this.value, this, '<?=$idx?>')">
							<option value="">사용안함</option>
							<option value="웹링크" <?=$row["msg_kko_btntype_{$idx}"]=="웹링크" ? "selected" : ""?> >웹링크</option>
							<option value="앱링크" <?=$row["msg_kko_btntype_{$idx}"]=="앱링크" ? "selected" : ""?> >앱링크</option>
							<option value="봇키워드" <?=$row["msg_kko_btntype_{$idx}"]=="봇키워드" ? "selected" : ""?> >봇키워드</option>
							<option value="메시지전달" <?=$row["msg_kko_btntype_{$idx}"]=="메시지전달" ? "selected" : ""?> >메시지전달</option>
							<option value="배송조회" <?=$row["msg_kko_btntype_{$idx}"]=="배송조회" ? "selected" : ""?> >배송조회</option>
						</select>
						
					</td>
				</tr>

				<tr class="btns btns<?=$idx?>" style="<?=$row["msg_kko_btntype_{$idx}"] ? "display:;" : "display:none;"?>" >
					<td class="td01">▶ 버튼이름<?=$idx?> </td>
					<td>
						<input type="text" class="Tinput01" name="msg_kko_btnname_<?=$idx?>"  id="btn_name_<?=$idx?>" value="<?=$row["msg_kko_btnname_{$idx}"]?>" style="width:200px;"/>
					</td>
				</tr>


				<tr class="btns btns<?=$idx?>" style="<?=$row["msg_kko_btntype_{$idx}"] ? "display:;" : "display:none;"?>">
					<td class="td01">▶ 버튼링크<?=$idx?> </td>
					<td style="line-height:2;">
						<span style="display:inline-block;width:60px;">Mobile : </span><input type="text" class="Tinput01" name="msg_kko_btnurl_m_<?=$idx?>" id="btn_url1_<?=$idx?>"  value="<?=$row["msg_kko_btnurl_m_{$idx}"]?>" style="width:400px;"/><br/>
						<span style="display:inline-block;width:60px;">PC : </span><input type="text" class="Tinput01" name="msg_kko_btnurl_p_<?=$idx?>" id="btn_url2_<?=$idx?>" value="<?=$row["msg_kko_btnurl_p_{$idx}"]?>" style="width:400px;"/>
					</td>
				</tr>
				<?}?>




				
			</tbody>
		</table>
	</div>
	</form>	
	
	
	
	
	
	<div class="Topbar02" style="float:left;margin-top:16px;">	
		<div style="position:absolute;top:4px;left:0;font-weight:bold;font-size:16px;">:: 사용가능한 변수목록 </div>
	</div>
	
	<div class="Wright01">
		<table class="t3" summary="">
		<colgroup>
			<col width="120px"/>
			<col width="320px"/>
			<col />
		</colgroup>
		<thead>
		  <tr>
			<th scope="col" class="th-left">발신번호</th>
			<th scope="col">사용가능조건</th>
			<th scope="col">내용</th>
		  </tr>
		</thead>
		<tbody id="datalist_senderinfo">
				
				<tr>
						<td>#{고객이름}</td>
                        <td style='text-align:left; margin-left:5px;'>전체적용</td>
						<td style='text-align:left; margin-left:5px;'>회원가입시 가입한 회원의 이름, 주문자 이름</td>
				</tr>

				<tr>
						<td>#{날짜}</td>
                        <td style='text-align:left; margin-left:5px;'>전체적용</td>
						<td style='text-align:left; margin-left:5px;'>알림톡이 전송되는 현재 일시 (YYYY-mm-dd HH:ii:ss)</td>
				</tr>
				
				<?if(USE_SHOP) { //config.php?>
				<tr>
						<td>#{주문일시}</td>
                        <td style='text-align:left; margin-left:5px;'>[주문접수시], [입금확인시], [상품배송시]</td>
						<td style='text-align:left; margin-left:5px;'>주문이 등록된 일시 (YYYY-mm-dd HH:ii:ss)</td>
				</tr>
				
				<tr>
						<td>
							#{주문번호}
						</td>
                        <td style='text-align:left; margin-left:5px;'>[주문접수시], [입금확인시], [상품배송시]</td>
						<td style='text-align:left; margin-left:5px;'>주문 번호</td>
				</tr>
				<tr>
						<td>#{금액}</td>
                        <td style='text-align:left; margin-left:5px;'>[주문접수시], [입금확인시], [상품배송시]</td>
						<td style='text-align:left; margin-left:5px;'>주문 금액</td>
				</tr>

				<tr>
						<td>#{상품명}</td>
                       <td style='text-align:left; margin-left:5px;'>[주문접수시], [입금확인시], [상품배송시]</td>
						<td style='text-align:left; margin-left:5px;'>주문한 상품명 (여러개일 경우 '1상품명 외 n건' 으로 표시)</td>
				</tr>
				<tr>
						<td>#{입금일시}</td>
                       <td style='text-align:left; margin-left:5px;'>[주문접수시], [입금확인시], [상품배송시]</td>
						<td style='text-align:left; margin-left:5px;'>입금 확인된 일시(주문상세에서 입력한 일시)</td>
				</tr>
                <tr>
						<td>#{배송일시}</td>
                        <td style='text-align:left; margin-left:5px;'>[상품배송시]</td>
						<td style='text-align:left; margin-left:5px;'>배송 시작 일시(주문상세에 입력한 일시)</td>
				</tr>
				
				<tr>
						<td>#{택배사}</td>
                        <td style='text-align:left; margin-left:5px;'>[상품배송시]</td>
						<td style='text-align:left; margin-left:5px;'>배송 회사 명</td>
				</tr>
				
				<tr>
						<td>#{운송장번호}</td>
                        <td style='text-align:left; margin-left:5px;'>[상품배송시]</td>
						<td style='text-align:left; margin-left:5px;'>운송장 번호</td>
				</tr>
				<?}?>


				
		</tbody>
		</table>
	</div>
	
	
</div>	






<script>


function change_btn_type(v, obj, idx){


	if(v == ""){
		$(".btns"+idx).hide();	
	} else {
		$(".btns"+idx).show();	
	}

}

function fsubmit(f){

	
	return true;
}


function load_template(){
	var code = $("#template").val();
	if(code == "") {
		alert("불러올 템플릿을 선택해주세요");
		return;
	}

	if(!confirm("아래 내용을 불러온 템플릿 내용으로 변경하시겠습니까?")) return;

	$.post("./_ajax_load_template.php", {code:code}, function(data){

		$("#template_code").val(data["template_code"]);
		$("#template_name").val(data["template_name"]);
		$("#template_msg").val(data["template_msg"]);
		
		$(".btns").hide();
		$(".btns input[type='text']").val("");
		$(".btnTypes").val("");

		for(var idx = 0 ; idx < data["btnList"].length; idx++){
			var btn = data["btnList"][idx];
			$("#btn_type_"+(idx+1)).find(" > option[value='"+btn["btn_type"]+"']").prop("selected", "selected");
			$("#btn_name_"+(idx+1)).val(btn["btn_name"]);
			$("#btn_url1_"+(idx+1)).val(btn["btn_url1"]);
			$("#btn_url2_"+(idx+1)).val(btn["btn_url2"]);
			$("#btn_type_"+(idx+1)).change();
		}


	},"json");
}


</script>