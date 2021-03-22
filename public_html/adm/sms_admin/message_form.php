<?
include_once("./_common.php");
auth_check($auth[$sub_menu], "r", false, false, false, false, false, true);


$g4[title] = "메시지관리";
include_once("{$g4["admin_path"]}/admin.head.php");

$obj = new Sms4Message(); 


if($w != ""){
    
        $row = $obj->get($no);

} else {

        $row["msg_content"] = $msglist[0]["msg_content"];
}


// SMS 설정값 배열변수
$sms4 = sql_fetch("select * from $g4[sms4_config_table] ");

//echo conv_content($obj->make_resv_message($row["msg_content"], 54), "2");
?>



<div class="Totalot2">	

	<form name="fwrite" id="fwrite" action="./message_form_update.php" method="post" onsubmit="return fsubmit();">
	<input type="hidden" name="w" value="<?=$w?>" />
	<input type="hidden" name="no" value="<?=$no?>" />
	
	<div class="Topbar02">			
		<div class="Toprightb">
			<span class="Btn3 link3"><a href="./message.php?p=<?=$p?>&<?=$qstr?>">목록보기</a></span>&nbsp;&nbsp;
			<span class="Btn4 link3"><a href="javascript:void(0)" onclick="$('#fwrite').submit()">저장하기</a></span>
		</div>
	</div>
	
	<div class="Wright01">
		<table class="t4" summary="">
			<colgroup>
				<col width="13%" />
				<col  />
			</colgroup>			
			<tbody>
				
				<tr class="">
					<td class="td01">▶ 발신번호</td>
					<td>
						<input type="text" class="Tinput01" name="msg_send_number" required value="<?=$w=="" ? $sms4["cf_phone"]: $row[msg_send_number]?>" style="width:200px;"/>

                        <span style="color:#cc0000;">
							&nbsp;사전등록된 발신번호만 사용 가능합니다.
						</span>
                        
					</td>
				</tr>
		
			

				<tr class="msg_type SMS">
					<td class="td01">▶ 제목</td>
					<td>
						<input type="text" class="Tinput01" name="msg_sms_name" value="<?=$row[msg_sms_name]?>" style="width:600px;"/>

                        <span style="color:#909090;">
							&nbsp;(구분용도 - 메시지로 전송되지 않습니다.)
						</span>
                        
					</td>
				</tr>


				<tr class="msg_type SMS">
					<td class="td01">▶ 전송 내용</td>
					<td>
						<textarea name="msg_sms_content" id="msg_sms_content"  style="width:99%;height:300px; background-color:#fff; line-height:1.5; font-size:14px;"   onkeyup="byte_check('msg_sms_content', 'sms_bytes');"><?=$row["msg_sms_content"]?></textarea>
						<div style="width:;text-align:center; margin:5px 0 5px 0;">
				            <span id=sms_bytes>0</span> / 2000 byte
							<br/>
							<span style='font-weight:normal;'>* 변수가 실제 값으로 변환될 경우 바이트수가 초과될 수 있습니다.</span>
				        </div>
					</td>
				</tr>


				<tr class="msg_type ATK">
					<td class="td01">▶ 내용</td>
					<td>
						<textarea name="msg_content" id="msg_content" readonly style="width:99%;height:300px; background-color:#efefef; line-height:1.5; font-size:14px;"><?=$row["msg_content"]?></textarea>
					</td>
				</tr>
		
		
				
			</tbody>
		</table>
	</div>
	</form>	
	
	
	
	
	
	<div class="Topbar02" style="float:left;margin-top:16px;">	
		<div style="position:absolute;top:4px;left:0;font-weight:bold;font-size:16px;">:: 변수설명 </div>
	</div>
	
	<div class="Wright01">
		<table class="t3" summary="">
		<colgroup>
			<col width="120px"/>
			<col />
		</colgroup>
		<thead>
		  <tr>
			<th scope="col" class="th-left">발신번호</th>
			<th scope="col">내용</th>
		  </tr>
		</thead>
		<tbody id="datalist_senderinfo">
				
				<tr>
						<td>{이름}</td>
                        <td style='text-align:left; margin-left:5px;'>회원이름</td>
				</tr>
				
				<tr>
						<td>{아이디}</td>
                        <td style='text-align:left; margin-left:5px;'>회원 아이디</td>
				</tr>
				

		</tbody>
		</table>
	</div>
	
	
</div>	






<script>

$(function(){
	
		change_type('<?=$row["msg_type"] ? $row["msg_type"] : "SMS"?>');
		byte_check('msg_sms_content', 'sms_bytes');
	
});

function change_type(v) {

	$(".msg_type").hide();
	$("."+v).show();

}

function get_content(no){

    // $.post("<?=$g4["apath"]?>/pages/com/_ajax_get_kko_message.php", {
    //     p:"<?=$p?>"
    //     , action:"<?=$action?>"
    //     , no:no
    // }, function(data){
    //     var d = data.split("|");
    //     $("#msg_content").val(d[0]);
    //     byte_check('msg_content', 'sms_bytes');
    // });	

}


function check_all(obj){

    var check = true;
    if($(obj).data("toggle") == "1") {
        check = true;
        $(obj).data("toggle", "");
    } else {
        check = false;
        $(obj).data("toggle", "1");
    }

    $(".cb_com_no").each(function(){
        if(!check) {
            $(this).prop("checked", "checked");
        } else {
            $(this).removeProp("checked");
        }
    });


}


function change_msg_when(){
    var type = $("#msg_when").val();
    $(".msg_when").hide();
    $(".msg_when_"+type).show();
    
}




function fsubmit(f){

	if(totbyte > 2000) {
		alert("전송 내용이 2000바이트를 초과합니다.");
		return false;
	}
	
	return true;
}



function check_com_id(v){
	dupCheck = false;
	$.post("/cai/basic/_ajax_user_checkid.php", {user_id:v, com_id:$("#com_id").val()}, function(data){

		if(data != "DUP") {
			$(".span_idchk").hide();
			$(".idchk_ok").show();
			dupCheck = true;
		} else {
			$(".span_idchk").hide();
			$(".idchk_fail").show();
			dupCheck = false;
		}
	});
}		



var totbyte = 0;
function byte_check(msg_content, sms_bytes) {
   
    var conts = document.getElementById(msg_content);
    var bytes = document.getElementById(sms_bytes);


   var totalByte = 0;
   var message = conts.value;

   for(var i =0; i < message.length; i++) {
		   var currentByte = message.charCodeAt(i);
		   if(currentByte > 128) totalByte += 3;
		   else totalByte++;
   }

   bytes.innerHTML = totalByte;
   totbyte = totalByte;
   
}

</script>