<?
include_once("./_common.php");


$g4[title] = "SMS환경설정";
include_once ("$g4[admin_path]/admin.head.php");

$obj = new Sms4Message();
$msglist = $obj->get_all_list("","","msg_name","asc", "");
?>

<link rel="stylesheet" href="<?=$g4['path']?>/adm/apistore_sms/style.css" type="text/css">

<div class="Totalot2">	



	<form name="fwrite" id="fwrite" action="./send_sms_update.php" method="post" onsubmit="return fsubmit();" enctype="multipart/form-data" >

	<input type="hidden" name="w" value="<?=$w?>" />
	<input type="hidden" name="hp_list" id="hp_list" value="" />
		
	<div class="Wright01">
		<table class="t4" summary="" style="table-layout:fixed; width:1458px;">
			<colgroup>
				<col width="10%" />
				<col width="20%" />
				<col width="" />
			</colgroup>			
			<tbody>
				<tr class="">
					<td class="td01" >▶ 문자전송</td>
					<td style="vertical-align:top; padding-top:20px;">
						
						 <div style="">
							메시지입력 : 
							<select class="Tselcet01" onchange="get_content(this.value);" style="width:99%;">
								<option value="">메시지 템플릿 선택</option>
								<? foreach($msglist as $msg){?>
									<option value="<?=$msg["no"]?>"><?=$msg["msg_name"]?></option>
								<? }?>
							</select>

				            <textarea name='msg_content' id='msg_content' class=ed style="font-family:Nanum Gothic; color:#000; line-height:15px; margin:5px 0 0 0px; overflow: hidden; width:99%; height:188px; font-size: 9pt; border:1px solid gray; background-color:#def6ff;" cols="16" onkeyup="byte_check('msg_content', 'sms_bytes');" accesskey="m" itemname='메세지'></textarea>
				        </div>

				        <div style="width:120px; text-align:center; margin:5px auto;">
				            <span id=sms_bytes>0</span> / 90 byte
				        </div>

						<div style='font-weight:normal; padding:10px 3px 3px 3px;'>
							* 90바이트(한글 45자, 영문/숫자 90자)가 초과되면 LMS로 전송됩니다.
						</div>

									
									<div class="Topbar02" style="float:left;margin-top:16px; width:100%;">	
										<div style="position:absolute;top:4px;left:0;font-weight:bold;font-size:16px;">:: 사용가능한 변수목록 </div>
									</div>
									<div class="">
										<table class="t3" summary="">
											<colgroup>
												<col width="120px"/>
												<col />
											</colgroup>
				
											<tbody id="datalist_senderinfo">
												
													<tr>
															<td>{이름}</td>
															<td style='text-align:left; margin-left:5px;'>회원이름</td>
													</tr>

													<tr>
															<td>{아이디}</td>
															<td style='text-align:left; margin-left:5px;'>회원아이디</td>
													</tr>

													
											</tbody>
										</table>
									</div>

					</td>
					<td>
						
						<table class="t4" summary="">
								<colgroup>
									<col width="20%" />
									<col/>
								</colgroup>			
								<tbody>
									<tr class="">
										<td class="td01" >전체전송</td>
										<td>
											<div style='float:left;'>
												<input type="radio" name="sendtype" id="sendtype_all" value="all" checked onchange='change_sendtype()' />
											</div>
											<div style='float:left; padding-top:2px;'>
												<label for="sendtype_all" style='font-weight:normal; cursor:pointer; '>
													모든 회원에게 전송 &nbsp;※ SMS 수신허용한 회원만 전송됩니다.
												</label>
											</div>
										</td>
									</tr>

									<tr class="">
										<td class="td01" >회원선택</td>
										<td>
											<div style='float:left;'>
												<input type="radio" name="sendtype" id="sendtype_slt" value="slt" onchange='change_sendtype()'/>
											</div>
											<div style='float:left; padding-top:2px;'>
												<label for="sendtype_slt" style='font-weight:normal; cursor:pointer; '>
													선택 회원 전송 / 번호입력 전송
												</label>
											</div>
										</td>
									</tr>


								</tbody>
						</table>





						<div class="Wright01" style="position:relative;">

							<div id="slt_member_overlay" style="position:absolute; width:100%; height:482px; top:0px; left:0px; background-color:black; z-index:99; opacity:0.3; cursor:pointer;" onclick="$('#sendtype_slt').click()">
								&nbsp;
							</div>

							<table class="t3" summary="">
							<colgroup>
								<col width="250px"/>
								<col />
							</colgroup>
							<thead>
							  <tr>
								<th scope="col" class="th-left">전송목록</th>
								<th scope="col">회원검색</th>
							  </tr>
							</thead>
							<tbody id="datalist_senderinfo">
								<td>
									<select name="slt_members" id="slt_members" size=21 style="width:100%; height:418px;">
									</select>
									<div style='float:right;'>
										<span class="Btn2 link3"><a href="javascript:void(0)" onclick="slt_delete_member()">선택삭제</a></span>
										<span class="Btn1 link3"><a href="javascript:void(0)" onclick="all_delete_member()">전부삭제</a></span>
									</div>
								</td>
								<td>
									<iframe src="./member_search.php" style="border:1px solid gray; width:100%; height:400px; "></iframe>

									<div style='float:left; padding-top:2px;'>
										<label for="sendtype_all" style='font-weight:normal; cursor:pointer; '>
											※ SMS 수신허용한 회원과, 핸드폰번호가 입력된 회원만 검색됩니다,
										</label>
									</div>

								</td>
							</tbody>
							</table>
						</div>



					</td>
				</tr>
				<tr class="">
					<td class="td01" ></td>
					<td>
						
					</td>
					<td>
						<span class="Btn3 link3" onclick="send()"><a href="javascript:void(0)" >전 송 하 기</a></span>
					</td>
				</tr>
				
				
				
			</tbody>
		</table>
	</div>
	
	

	
	
	</form>	
	
	
</div>


<script>



function get_content(no){
	$.post("./_ajax_get_sms_message.php", {no:no}, function(data){
		var d = data.split("|");
		$("#msg_content").val(d[0]);
        $("#sender_number").val(d[1]);
		$("#msg_no").val(d[2]);
		byte_check('msg_content', 'sms_bytes');
	});	
}



function select_member(id, name, number){
	var v = id + "//" + name + "//" + number;
	if($("#slt_members").find(" > option[value='"+v+"']").size() == 0) {
		$("#slt_members").append("<option value='"+v+"'>"+name+"("+number+")</option>");
	}
}

function slt_delete_member(){
	var v = $("#slt_members").val();
	var obj = $("#slt_members").find(" > option[value='"+v+"']");
	if(obj.size() > 0){
		obj.remove();
	}
}

function all_delete_member(){
	$("#slt_members").html("");
}

function change_sendtype(){
	var st = $(':radio[name="sendtype"]:checked').val();
	if(st == "all")
		$("#slt_member_overlay").show();
	else
		$("#slt_member_overlay").hide();
}


$(function(){
	byte_check('msg_content', 'sms_bytes');
});


function byte_check(msg_content, sms_bytes)
{
    var conts = document.getElementById(msg_content);
    var bytes = document.getElementById(sms_bytes);

    var i = 0;
    var cnt = 0;
    var exceed = 0;
    var ch = '';

    for (i=0; i<conts.value.length; i++) 
    {
        ch = conts.value.charAt(i);
        if (escape(ch).length > 4) {
            cnt += 2;
        } else {
            cnt += 1;
        }
    }

    bytes.innerHTML = cnt;

    if (cnt >= 90) 
    {
        
    }
}



function send(){

	var hp_list = document.getElementById('slt_members');
	var list = '';

	for (i=0; i<hp_list.length; i++)
        list += hp_list.options[i].value + '|';

	$("#hp_list").val(list);

	$("#fwrite").submit();
}


function fsubmit(){
	
	if($("#msg_content").val() == ""){
		$("#msg_content").focus();
		alert("메시지를 입력해주세요!");
		return false;
	}

	var st = $(':radio[name="sendtype"]:checked').val();
	if(st != "all"){
		if($("#hp_list").val() == ""){
			alert("문자메시지를 전송할 회원을 한명이상 선택해주세요!");
			return false;
		}
	}


	if(st == "all") {

		if(!confirm("모든 회원에게 문자메시지를 발송하시겠습니까?\n\n*SMS전송을 동의한 회원에게만 발송됩니다")) return false;
	}
	if(st == "slt"){
		var hp_list = document.getElementById('slt_members');
		if(!confirm("선택된 회원에게 문자메시지를 발송하시겠습니까?\n(선택된 회원 총 "+(number_format(hp_list.length+""))+"명)")) return false;
	}



	return true;
}




var a_rbtn_clicked = false;
$(function(){
	o = $(document);
	o.find(".Btn1, .Btn2, .Btn3, .Btn4").css("cursor", "pointer");
	o.find(".Btn1, .Btn2, .Btn3, .Btn4").find("a").click(function(){
		a_rbtn_clicked = true;
	})
	o.find(".Btn1, .Btn2, .Btn3, .Btn4").click(function(){ 
		
			var anchor = $(this).find("a");
			var oce = anchor.attr("onclick");
			
			if(oce != "" && !a_rbtn_clicked) {
				
					eval(oce);//onclick 이벤트 실행
				
			}
			
			var loc = anchor.attr("href");
			var tag = anchor.attr("target");
			
			if(!loc.startsWith("javascript:void(0)") && !loc.startsWith("#")){
				if(tag == "_blank")
					window.open(loc);
				else if(tag == "_parent"){
					parent.location.href = loc;
				}
				else if(tag == "_top"){
					top.location.href = loc;
				}
				else
					location.href = loc;
			}

			a_rbtn_clicked = false;
			
			return false;
	});
});
</script>