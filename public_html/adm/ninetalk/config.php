<?
$sub_menu = "100990";
$is_config = true;
include_once "./_common.php";
		
$g4[title] = "실시간문의 설정";
include_once("../admin.head.php");



if(isset($_SERVER['HTTPS'])){
	$ninetalk->chat_server = $ninetalk->chat_server.":13443";
}

?>



<?if(!$ninetalk->get_site_key() || !$ninetalk->get_secret()){?>
	<div style="padding:15px 0; font-size:12px; color:#CC0000; font-weight:bold; line-height:1.6;">
		<i class="fas fa-exclamation-triangle"></i> Site-key를 입력해주세요.<br/>
		<i class="fas fa-exclamation-triangle"></i> Secret을 입력해주세요.
	</div>
<?}?>

<form name='fconfigform' method='post' action="./config_update.php">

<table width=1000px cellpadding=0 cellspacing=0 border=0  class="list02">
<colgroup width=20% class='col1 pad1 bold right'>
<colgroup width=30% class='col2 pad2'>
<colgroup width=20% class='col1 pad1 bold right'>
<colgroup width=30% class='col2 pad2'>
<tr>
    <td colspan=4 class=title align=left height="35"><img src='<?=$g4[admin_path]?>/img/icon_title.gif'> 실시간문의 설정</td>
</tr>
<tr class='ht'>
    <td class="head">Site-Key</td>
    <td>
        <input type=text class=ed name='site_key' size='30' required itemname='Site-Key' value='<?=$ninetalk->get_site_key()?>' >
    </td>
    <td class="head">Secret</td>
    <td>
    	<input type=text class=ed name='secret' size='40' required itemname='Site-Key' value='<?=$ninetalk->get_secret()?>' >
    </td>
</tr>


<tr>
    <td colspan=4 class=title align=left height="35"><img src='<?=$g4[admin_path]?>/img/icon_title.gif'> 관리자 설정</td>
</tr>

<tr class='ht'>
    <td class="head">관리자 선택</td>
    <td colspan="3">
        <select name="chat_name" id="chat_name">
        
        </select>
    </td>
</tr>



</table>
<p align=center style="width:1000px;margin:10px 0 0 0;">
    <input type=submit class=btn1 accesskey='s' value='  확  인  '>
</p>    
</form>


<br/>
<br/>
<br/>

<table width=1000px cellpadding=0 cellspacing=0 border=0  class="list02">
<colgroup width=20% class='col1 pad1 bold right'>
<colgroup width=30% class='col2 pad2'>
<colgroup width=20% class='col1 pad1 bold right'>
<colgroup width=30% class='col2 pad2'>
<tr>
    <td colspan=4 class=title align=left height="35"><img src='<?=$g4[admin_path]?>/img/icon_title.gif'>첫 메시지</td>
</tr>
<tr class='ht'>
    <td class="head">첫 메시지 사용</td>
    <td colspan="3">
        <div style="float:left">
		<input type=checkbox class=ed name='use_first_msg' id="use_first_msg" size='30'  value='Y' align="bottom" onclick="set_use_firstmsg()"/>
	</div>
	<div style='float:left;cursor:pointer;padding:5px 0 0 0;' onclick='$("#use_first_msg").click()' >
		첫 메시지 사용
	</div>
    </td>
</tr>

<tr class='ht'>
    <td class="head">첫 메시지</td>
    <td colspan="3">
		<textarea id="first_msg" name="first_msg" style="width:99%;height:80px"></textarea>
		<input type="button" value="첫 메시지 저장" onclick="set_firstmsg()"/>
    </td>
</tr>

</table>

<br/>
<br/>
<br/>


<table width=1000px cellpadding=0 cellspacing=0 border=0  class="list02">
<colgroup width=20% class='col1 pad1 bold right'>
<colgroup width=30% class='col2 pad2'>
<colgroup width=20% class='col1 pad1 bold right'>
<colgroup width=30% class='col2 pad2'>
<tr>
    <td colspan=4 class=title align=left height="35"><img src='<?=$g4[admin_path]?>/img/icon_title.gif'> 부재중 설정</td>
</tr>
<tr class='ht'>
    <td class="head">부재중 수동 설정</td>
    <td colspan="3">
        <div style="float:left">
		<input type=checkbox class=ed name='is_absent' id="is_absent" size='30'  value='Y' align="bottom" onclick="set_absent()"/>
	</div>
	<div style='float:left;cursor:pointer;padding:5px 0 0 0;' onclick='$("#is_absent").click()' >
		부재중 표시
	</div>
    </td>
</tr>

<tr class='ht'>

    <td class="head">부재중 자동 설정 요일</td>
    <td colspan="3">
    	<input type="checkbox" class="absent_yoil" id="absent_yoil0" value="1" /><span style="cursor:pointer" onclick="$(this).prev().click()">일</span>
    	<input type="checkbox" class="absent_yoil" id="absent_yoil1" value="2" /><span style="cursor:pointer" onclick="$(this).prev().click()">월</span>
    	<input type="checkbox" class="absent_yoil" id="absent_yoil2" value="3" /><span style="cursor:pointer" onclick="$(this).prev().click()">화</span>
    	<input type="checkbox" class="absent_yoil" id="absent_yoil3" value="4" /><span style="cursor:pointer" onclick="$(this).prev().click()">수</span>
    	<input type="checkbox" class="absent_yoil" id="absent_yoil4" value="5" /><span style="cursor:pointer" onclick="$(this).prev().click()">목</span>
    	<input type="checkbox" class="absent_yoil" id="absent_yoil5" value="6" /><span style="cursor:pointer" onclick="$(this).prev().click()">금</span>
    	<input type="checkbox" class="absent_yoil" id="absent_yoil6" value="7" /><span style="cursor:pointer" onclick="$(this).prev().click()">토</span>
    	&nbsp;&nbsp;<input type="button" value="부재중 요일 저장" onclick="set_absent_yoil()">
 	</td>   
</td>
    
<tr class='ht'>

    <td class="head">부재중 자동 설정 시간</td>
    <td colspan="3">
		<div style="float:left;width:90%;">
		<select id="shour" name="shour" >	
			<?for($i = 0 ; $i <= 23 ; $i++){ $ii = sprintf("%02d", $i);?>
				<option value="<?=$ii?>"><?=$ii?>시</option>
			<?}?>
		</select>
		<select id="smin" name="smin" >	
			<?for($i = 0 ; $i <= 60 ; $i += 10){ $ii = sprintf("%02d", $i);?>
				<option value="<?=$ii?>"><?=$ii?>분</option>
			<?}?>
		</select>
		~
		<select id="ehour" name="ehour" >	
			<?for($i = 0 ; $i <= 23 ; $i++){ $ii = sprintf("%02d", $i);?>
				<option value="<?=$ii?>"><?=$ii?>시</option>
			<?}?>
		</select>
		<select id="emin" name="emin" >	
			<?for($i = 0 ; $i <= 60 ; $i += 10){ $ii = sprintf("%02d", $i);?>
				<option value="<?=$ii?>"><?=$ii?>분</option>
			<?}?>
		</select>
		<input type="button" value="추가" onclick="absent_time_add()"> 
		</div>
		<div style="float:left; padding:9px 0 0 0;">
			<select id="absent_time" name="absent_time" style="width:200px; height:50px;" multiple >
			</select>
			<br/>
			<input type="button" value="선택삭제" onclick="absent_time_delete()">
		</div>
		
    </td>
</tr>


<tr class='ht'>
    <td class="head">부재중 표시 메시지</td>
    <td colspan="3">
		<textarea id="absent_msg" name="absent_msg" style="width:99%;height:80px"></textarea>
		<input type="button" value="부재중 메시지 저장" onclick="set_absent_msg()"/>
    </td>
</tr>





</table>



<br/>
<br/>
<br/>

<script type="text/javascript">
$(function(){

	$.ajax({
		
		url:"//<?=$ninetalk->chat_server?>/api/chat/get_admin_list.php",
		dataType:"jsonp",
		jsonp:"callback",
		data:{
			site_key:"<?=$ninetalk->get_site_key()?>",
		},
		success:function(result){

			$("#chat_name").html("<option value=''>PC버전관리자</option>");

			if(result != null && result !== undefined && result.length != 0){
				$("#chat_name").html("<option value=''>PC버전관리자</option>");
				for(var i = 0 ; i < result.length ; i++){
						var data = result[i];
						$("#chat_name").append("<option value='"+data["chat_id"]+"|"+data["chat_name"]+"'>"+data["chat_name"]+" / " +data["reg_date"] + " ("+data["chat_id"]+")</option>");
				}

				$("#chat_name > option[value='<?=$ninetalk->get_chat_id()?>|<?=$ninetalk->get_chat_name()?>']").attr("selected", "selected");
			} else {

				$("#chat_name").append("<option value=''>어플리케이션에 로그인된 사용자가 없습니다.</option>");
			}
		
		},
		error:function(x,o,e){
			alert(x+":"+o+":"+e);
			
		}
	});



	//부재중, 기본메시지 정보 불러오기
	$.ajax({
		
		url:"//<?=$ninetalk->chat_server?>/api/chat/get_absent_config.php",
		dataType:"jsonp",
		jsonp:"callback",
		data:{
			site_key:"<?=$ninetalk->get_site_key()?>",
		},
		success:function(result){

			if(result["use_first_msg"] == "Y"){
				$("#use_first_msg").attr("checked", "checked");
			}
			$("#first_msg").val(result["first_msg"]);

			
			if(result["is_absent"] == "Y"){
				$("#is_absent").attr("checked", "checked");
			}
			$("#absent_msg").val(result["absent_msg"]);


			var ayoils = result["absent_yoil"];
			if(ayoils != ""){
				var ayoil = ayoils.split("|");
				if(ayoil.length > 0){

					for(var yidx = 0 ; yidx < ayoil.length; yidx++){
							if(ayoil[yidx] == "Y"){
								$("#absent_yoil"+yidx).attr("checked",true);
							}
					} 
				}
			}
			
			var atime = result["absent_time"];
			for(var i = 0 ; i < atime.length ; i ++){
				var row = atime[i];
				$("#absent_time").append("<option value='"+row["stime"]+"|"+row["etime"]+"'>"+row["stime"]+" ~ "+row["etime"]+"</option>");

			}


			
		}, 
		error:function(x, o, e){
			alert(x+":"+o+":"+e);
		}
	});



});


function absent_time_add(){
	
	var stime = $("#shour").val() + ":"+ $("#smin").val();
	var etime = $("#ehour").val() + ":" + $("#emin").val();
	
	if(stime == etime){
		alert("시작시간과 끝시간에 동일한 시간을 지정할 수 없습니다.");
		return;
	}
	if($("#absent_time > option[value='"+stime+"|"+etime+"']").size() > 0){
		alert("해당 시간이 이미 등록되어 있습니다.");
		return;
	}

	//부재중시간 저장
	$.ajax({

		url:"//<?=$ninetalk->chat_server?>/api/chat/set_absent_time.php",
		dataType:"jsonp",
		jsonp:"callback",
		data:{
			site_key:"<?=$ninetalk->get_site_key()?>",
			stime:stime,
			etime:etime,
			type:"i"
		},
		success:function(result){
			
			if(result["message"] == "OK"){
				alert("설정이 저장되었습니다.");
				$("#absent_time").append("<option value='"+stime+"|"+etime+"'>"+stime+" ~ "+etime+"</option>");

			} else {
				alert(result["message"]);
			}
		}, 
		error:function(x, o, e){
			alert(x+":"+o+":"+e);
		}
	});

}

function absent_time_delete(){
	

	var d = $("#absent_time").val();
	if(d == null || d.length == 0) {
		return;
	}

	var data = d[0].split("|");
	var stime = data[0];
	var etime = data[1];
	
	//부재중시간 삭제
	$.ajax({

		url:"//<?=$ninetalk->chat_server?>/api/chat/set_absent_time.php",
		dataType:"jsonp",
		jsonp:"callback",
		data:{
			site_key:"<?=$ninetalk->get_site_key()?>",
			stime:stime,
			etime:etime,
			type:"d"
		},
		success:function(result){
			
			if(result["message"] == "OK"){
				alert("설정이 저장되었습니다.");
				$("#absent_time > option[value='"+stime+"|"+etime+"']").remove();

			} else {
				alert(result["message"]);
			}
		}, 
		error:function(x, o, e){
			alert(x+":"+o+":"+e);
		}
	});
}


function set_use_firstmsg(){
	var usefirst = $("#use_first_msg").is(":checked");
	var value =  usefirst ? "Y" : "N";
	var field = "use_first_msg";
	save_absent_config(field, value);
}


function set_firstmsg(){

	var value = $("#first_msg").val();
	var field = "first_msg";

	save_absent_config(field, value);
	
}

function set_absent(){

	var isab = $("#is_absent").is(":checked");
	var value =  isab ? "Y" : "N";
	var field = "is_absent";
	
	save_absent_config(field, value);
}


function set_absent_yoil(){

	var value = "";
	$(".absent_yoil").each(function(){
			if(value != "") value += "|";
			value += $(this).is(":checked") ? "Y" : "N";
	});
	
	var field = "absent_yoil";

	save_absent_config(field, value);
}

function set_absent_msg(){
	
	var value = $("#absent_msg").val();
	var field = "absent_msg";

	save_absent_config(field, value);
}


function save_absent_config(field, value){


	//부재중정보 저장
	$.ajax({
		
		url:"//<?=$ninetalk->chat_server?>/api/chat/set_absent_config.php",
		dataType:"jsonp",
		jsonp:"callback",
		data:{
			site_key:"<?=$ninetalk->get_site_key()?>",
			field:field,
			value:value
		},
		success:function(result){
			
			if(result["message"] == "OK"){
				alert("설정이 저장되었습니다.");
			} else {
				alert(result["message"]);
			}
		}, 
		error:function(x, o, e){
			alert(x+":"+o+":"+e);
		}
	});


}
</script>




<?
include_once ("../admin.tail.php");
?>
