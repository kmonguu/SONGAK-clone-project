<?
include "./_common.php";
?>

<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;">실시간문의 설정</div>
<div class="nbox">
	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:20px;padding-bottom:7px;">SITE KEY</div>
	<div style="float:left;width:100%;">		
		<div style="position:relative;float:left;width:66.5%;margin-top:20px;margin-left:3.994%;">
            <input type="text"  class="input02"  name="site_key" id="site_key" itemname="이름" required="required" placeholder="SITE KEY" value="" onFocus="this.placeholder=''">
        </div>
		<div style="float:left;margin-top:28px;width:18.786%;margin-left:7%;"><a href="javascript:void(0);"  onclick="setSiteKey()"><img src="/app_helper/images/btn01.jpg" style="width:100%"/></a></div>
	</div>
	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:40px;padding-bottom:7px;">대화명</div>
	<div style="float:left;width:100%;">		
		<div style="position:relative;float:left;width:66.5%;margin-top:20px;margin-left:3.994%;">
            <input type="text" class="input02" name="chat_name" id="chat_name" itemname="대화명" required="required" placeholder="대화명" value="<?=$ci[chat_name]?>" onFocus="this.placeholder=''">
        </div>
		<div style="float:left;margin-top:28px;width:18.786%;margin-left:7%;"><a href="javascript:void(0)" onclick="set_chatName()"><img src="/app_helper/images/btn01.jpg" style="width:100%"/></a></div>
	</div>



	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:40px;padding-bottom:7px;">프로필 사진</div>
	<div style="float:left;width:100%;">		
		<div style="float:left;margin-top:28px;width:25.887%;margin-left:36.355%;">
            <img class='profile_picture' src="http://<?=$_SESSION["chat_server"]?>/data/profile/thumb/200x200_100/<?=$chat_id?>?<?=date("YmdHis")?>" style="width:100%;border-radius:50%;" onerror="javascript:this.src='<?=$g4["mpath"]?>/images/pic_img.jpg'"/>
        </div>
		<div style="float:left;width:100%;">
			<div style="float:left;margin-top:28px;width:22.633%;margin-left:26.627%;"><a href="javascript:void(0);" onclick="get_profile_camera_picture('album', 'profile_picture')"><img src="/app_helper/images/btn02.jpg" style="width:100%"/></a></div>
			<div style="float:left;margin-top:28px;width:22.633%;margin-left:1.479%;"><a href="javascript:void(0);" onclick="get_profile_camera_picture('camera', 'profile_picture')"><img src="/app_helper/images/btn03.jpg" style="width:100%"/></a></div>
		</div>
	</div>

	<form id="f_profileImgSave" method="post" action="//<?=$_SESSION["chat_server"]?>/app_alimi/fileupload/UploadProfileImg2.php" target='profileImg_hidden_frame'>
		<input type="hidden" name="image" id="profile_image" />
		<input type="hidden" name="type" value="profile" />
		<input type="hidden" name="no" value="<?=$chat_id?>" />
	</form>
	<iframe name="profileImg_hidden_frame" style="display:none;" onload="closeProgress();"></iframe>



	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:40px;padding-bottom:7px;">첫 메세지 설정</div>
	<div style="float:left;border:1px solid #c3c3c3;border-radius:8px;color:#3f3f3f;padding:2.5%;font-size:26px;width:87.011%;margin-left:3.994%;margin-top:20px;">
		<div style="position:relative;float:left;width:6.36%;">
			
			<input type="checkbox" class="transparent_chkbox" id="use_first_msg" name="use_first_msg" data-link="disp_use_first_msg" data-onimg="<?=$g4["mpath"]?>/images/check_on.jpg" data-offimg="<?=$g4["mpath"]?>/images/check.jpg" value="Y"  onclick="set_use_firstmsg()">
            <img src="<?=$g4["mpath"]?>/images/check.jpg" id="disp_use_first_msg" style="width:100%"/>
            
        </div>
		<div style="float:left;margin-left:3%;line-height:30px;">첫 메세지 표시</div>
	</div>
	<div style="position:relative;float:left;width:87.511%;margin-top:20px;margin-left:3.994%;">
		<textarea class="textarea01" rows="4" id="first_msg" name="first_msg" ></textarea>
	</div>
	<div style="float:left;margin-top:15px;width:92.311%;margin-left:3.994%;"><a href="javascript:void(0);" onclick="set_firstmsg()" ><img src="/app_helper/images/btn04.jpg" style="width:100%"/></a></div>


	
	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:40px;padding-bottom:7px;">부재중 설정</div>
	<div style="float:left;border:1px solid #c3c3c3;border-radius:8px;color:#3f3f3f;padding:2.5%;font-size:26px;width:87.011%;margin-left:3.994%;margin-top:20px;">
		<div style="position:relative;float:left;width:6.36%;">
		
			<input type="checkbox" class="transparent_chkbox" id="is_absent" name="is_absent" data-link="disp_is_absent" data-onimg="<?=$g4["mpath"]?>/images/check_on.jpg" data-offimg="<?=$g4["mpath"]?>/images/check.jpg" value="Y"  onclick="set_absent()">
            <img src="<?=$g4["mpath"]?>/images/check.jpg" id="disp_is_absent" style="width:100%"/>
			
		</div>
		<div style="float:left;margin-left:3%;line-height:30px;">부재중 표시</div>
	</div>



	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:40px;padding-bottom:7px;">부재중 자동설정 요일</div>
	<div style="float:left;border:1px solid #c3c3c3;border-radius:8px;color:#3f3f3f;padding:2.5%;font-size:22px;width:87.011%;margin-left:3.994%;margin-top:20px;">
		<div style="float:left;width:100%;">

			<div style="position:relative;float:left;width:6.36%;">
				<input type="checkbox" class="absent_yoil transparent_chkbox" id="absent_yoil0" name="absent_yoil0" data-link="disp_absent_yoil0" data-onimg="<?=$g4["mpath"]?>/images/check_on.jpg" data-offimg="<?=$g4["mpath"]?>/images/check.jpg" value="Y">
            	<img src="<?=$g4["mpath"]?>/images/check.jpg" id="disp_absent_yoil0" style="width:100%"/>
			</div>
			<div style="float:left;margin-left:2%;line-height:30px;">일요일</div>

			<div style="position:relative;float:left;width:6.36%;margin-left:5%;">
				<input type="checkbox" class="absent_yoil transparent_chkbox" id="absent_yoil1" name="absent_yoil1" data-link="disp_absent_yoil1" data-onimg="<?=$g4["mpath"]?>/images/check_on.jpg" data-offimg="<?=$g4["mpath"]?>/images/check.jpg" value="Y">
            	<img src="<?=$g4["mpath"]?>/images/check.jpg" id="disp_absent_yoil1" style="width:100%"/>
			</div>
			<div style="float:left;margin-left:2%;line-height:30px;">월요일</div>

			<div style="position:relative;float:left;width:6.36%;margin-left:5%;">
				<input type="checkbox" class="absent_yoil transparent_chkbox" id="absent_yoil2" name="absent_yoil2" data-link="disp_absent_yoil2" data-onimg="<?=$g4["mpath"]?>/images/check_on.jpg" data-offimg="<?=$g4["mpath"]?>/images/check.jpg" value="Y">
            	<img src="<?=$g4["mpath"]?>/images/check.jpg" id="disp_absent_yoil2" style="width:100%"/>
			</div>
			<div style="float:left;margin-left:2%;line-height:30px;">화요일</div>

			<div style="position:relative;float:left;width:6.36%;margin-left:5%;">
				<input type="checkbox" class="absent_yoil transparent_chkbox" id="absent_yoil3" name="absent_yoil3" data-link="disp_absent_yoil3" data-onimg="<?=$g4["mpath"]?>/images/check_on.jpg" data-offimg="<?=$g4["mpath"]?>/images/check.jpg" value="Y">
            	<img src="<?=$g4["mpath"]?>/images/check.jpg" id="disp_absent_yoil3" style="width:100%"/>
			</div>
			<div style="float:left;margin-left:2%;line-height:30px;">수요일</div>			
		</div>
		<div style="float:left;width:100%;margin-top:15px;">
			<div style="position:relative;float:left;width:6.36%;">
				<input type="checkbox" class="absent_yoil transparent_chkbox" id="absent_yoil4" name="absent_yoil4" data-link="disp_absent_yoil4" data-onimg="<?=$g4["mpath"]?>/images/check_on.jpg" data-offimg="<?=$g4["mpath"]?>/images/check.jpg" value="Y">
            	<img src="<?=$g4["mpath"]?>/images/check.jpg" id="disp_absent_yoil4" style="width:100%"/>
			</div>
			<div style="float:left;margin-left:2%;line-height:30px;">목요일</div>

			<div style="position:relative;float:left;width:6.36%;margin-left:5%;">
				<input type="checkbox" class="absent_yoil transparent_chkbox" id="absent_yoil5" name="absent_yoil5" data-link="disp_absent_yoil5" data-onimg="<?=$g4["mpath"]?>/images/check_on.jpg" data-offimg="<?=$g4["mpath"]?>/images/check.jpg" value="Y">
            	<img src="<?=$g4["mpath"]?>/images/check.jpg" id="disp_absent_yoil5" style="width:100%"/>
			</div>
			<div style="float:left;margin-left:2%;line-height:30px;">금요일</div>

			<div style="position:relative;float:left;width:6.36%;margin-left:5%;">
				<input type="checkbox" class="absent_yoil transparent_chkbox" id="absent_yoil6" name="absent_yoil6" data-link="disp_absent_yoil6" data-onimg="<?=$g4["mpath"]?>/images/check_on.jpg" data-offimg="<?=$g4["mpath"]?>/images/check.jpg" value="Y">
            	<img src="<?=$g4["mpath"]?>/images/check.jpg" id="disp_absent_yoil6" style="width:100%"/>
			</div>
			<div style="float:left;margin-left:2%;line-height:30px;">토요일</div>
		</div>
	</div>
	<div style="float:left;margin-top:15px;width:92.311%;margin-left:3.994%;">
		<a href="javascript:void(0);" onclick="set_absent_yoil()"><img src="/app_helper/images/btn05.jpg" style="width:100%"/></a>
	</div>



	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:40px;padding-bottom:7px;">부재중 자동설정 시간 추가</div>
	<div style="position:relative;float:left;margin-left:4.027%;width:42.711%;margin-top:15px;">
		<select id="shour" name="shour" data-link="disp_shour" class="transparent_sltbox">	
			<?for($i = 0 ; $i <= 23 ; $i++){ $ii = sprintf("%02d", $i);?>
				<option value="<?=$ii?>"><?=$ii?>시</option>
			<?}?>
		</select>
		<input type="text" placeholder="00시" id="disp_shour" class="input02" style="text-align:center;">
		<div style="position:absolute;top:22px;right:0.4%;width:5%;"><img src="/app_helper/images/arrow02.jpg" width="100%" /></div>
	</div>

	<div style="position:relative;float:left;margin-left:4.027%;width:42.711%;margin-top:15px;">
		<select id="smin" name="smin" data-link="disp_smin" class="transparent_sltbox">	
			<?for($i = 0 ; $i <= 60 ; $i += 10){ $ii = sprintf("%02d", $i);?>
				<option value="<?=$ii?>"><?=$ii?>분</option>
			<?}?>
		</select>
		<input type="text" placeholder="00분" id="disp_smin" class="input02" style="text-align:center;">
		<div style="position:absolute;top:22px;right:0.4%;width:5%;"><img src="/app_helper/images/arrow02.jpg" width="100%" /></div>
	</div>


	<div style="position:relative;float:left;margin-left:4.027%;width:42.711%;margin-top:15px;">
		<select id="ehour" name="ehour" data-link="disp_ehour" class="transparent_sltbox">	
			<?for($i = 0 ; $i <= 23 ; $i++){ $ii = sprintf("%02d", $i);?>
				<option value="<?=$ii?>"><?=$ii?>시</option>
			<?}?>
		</select>
		<input type="text" placeholder="00시" id="disp_ehour" class="input02" style="text-align:center;">
		<div style="position:absolute;top:22px;right:0.4%;width:5%;"><img src="/app_helper/images/arrow02.jpg" width="100%" /></div>
	</div>

	<div style="position:relative;float:left;margin-left:4.027%;width:42.711%;margin-top:15px;">
		<select id="emin" name="emin" data-link="disp_emin" class="transparent_sltbox">	
			<?for($i = 0 ; $i <= 60 ; $i += 10){ $ii = sprintf("%02d", $i);?>
				<option value="<?=$ii?>"><?=$ii?>분</option>
			<?}?>
		</select>
		<input type="text" placeholder="00분" id="disp_emin" class="input02" style="text-align:center;">
		<div style="position:absolute;top:22px;right:0.4%;width:5%;"><img src="/app_helper/images/arrow02.jpg" width="100%" /></div>
	</div>

	<div style="float:left;margin-top:15px;width:92.311%;margin-left:3.994%;"><a href="javascript:void(0);" onclick="absent_time_add()"><img src="/app_helper/images/btn06.jpg" style="width:100%"/></a></div>



	
	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:40px;padding-bottom:7px;">등록된 부재중 자동설정 시간 목록</div>
	<div style="position:relative;float:left;margin-left:4.027%;width:87.511%;margin-top:15px;">
		<select id="absent_time" name="absent_time" style="width:100%" data-link="disp_absent_time" class="transparent_sltbox">
		</select>
		<input type="text" placeholder="등록된 시간이 없습니다" id="disp_absent_time" class="input02" style="text-align:center;">
		<div style="position:absolute;top:27px;right:0.4%;width:3%;"><img src="/app_helper/images/arrow02.jpg" width="100%" /></div>
	</div>
	<div style="float:left;margin-top:15px;width:92.311%;margin-left:3.994%;"><a href="javascript:void(0);" onclick="absent_time_delete()"><img src="/app_helper/images/btn07.jpg" style="width:100%"/></a></div>	

	
	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:40px;padding-bottom:7px;">부재중 표시 메세지</div>
	<div style="position:relative;float:left;width:87.511%;margin-top:20px;margin-left:3.994%;">
		<textarea class="textarea01" rows="4" id="absent_msg" name="absent_msg" placeholder="부재중시 표시 될 메세지를 작성해주세요."></textarea>
	</div>
	<div style="float:left;margin-top:15px;width:92.311%;margin-left:3.994%;"><a href="javascript:void(0);" onclick="set_absent_msg()"><img src="/app_helper/images/btn08.jpg" style="width:100%"/></a></div>
</div>





<script>

$(function(){

    $("#site_key").val(window.localStorage.getItem("site_key"));
    get_chatName();
	get_absent_data();
	
});


function get_absent_data(){
	var sk = site_key;
	var sc = secret;
	
	//부재중, 첫메시지정보 불러오기
	$.ajax({
		url:"http://"+chat_server+"/api/chat/get_absent_config.php",
		dataType:"jsonp",
		jsonp:"callback",
		data:{
			site_key:sk,
			secret:sc
		},
		success:function(result){
		
			if(result["use_first_msg"] == "Y"){
				$("#use_first_msg").prop("checked", true).change();
			}
			$("#first_msg").val(result["first_msg"]);

			
			if(result["is_absent"] == "Y"){
				$("#is_absent").prop('checked',true).change();
			}
			$("#absent_msg").val(result["absent_msg"]);


			$(".absent_yoil").each(function(){				
					$(this).prop("checked",false).change();
			});
			
            var ayoils = result["absent_yoil"];
			if(ayoils != "" && ayoils !== undefined){
				var ayoil = ayoils.split("|");
				if(ayoil.length > 0){

					for(var yidx = 0 ; yidx < ayoil.length; yidx++){
							if(ayoil[yidx] == "Y"){
								$("#absent_yoil"+yidx).prop("checked", true).change();
							}
					} 
				}
			}

		
            var atime = result["absent_time"];
            if(atime != "" && atime !== undefined){
                for(var i = 0 ; i < atime.length ; i ++){
                    var row = atime[i];
                    $("#absent_time").append("<option value='"+row["stime"]+"|"+row["etime"]+"'>"+row["stime"]+" ~ "+row["etime"]+"</option>");
				}
				$("#absent_time").change();
            }
		}, 
		error:function(x, o, e){
			alert(x+":"+o+":"+e);
		}
	});
}


function setSiteKey(){

    showProgress();

	var sk = $("#site_key").val();
	
	$.ajax({
		url:"http://"+chat_server+"/api/chat/get_site_key.php",
		dataType:"jsonp",
		jsonp:"callback",
		data:{
			site_key:sk
		},
		success:function(result){
			try {
				if(result["secret"]){
					
					closeProgress();
					window.localStorage.setItem("site_key", sk);
					window.localStorage.setItem("secret", result.secret);
					toast("저장되었습니다.");

					site_key = sk;
					secret = result.secret;
					get_chatName();
					get_absent_data();
				
				} else {
					closeProgress();
					alert_app("SITE KEY가 올바르지 않습니다.");
					$("#chat_name").val("");
					window.localStorage.removeItem("site_key", site_key);
					window.localStorage.removeItem("secret", result.secret);
					site_key = "";
					secret = "";
				}
			} catch(e){
					alert(e);
            }
            
            closeProgress();
		},
		error:function(x, o, e){
				alert(x + ":" + o + ":" + e);
		}
	});
	
}


function set_chatName(){

	var sk = site_key;
	var sc = secret;
	if(sk == "" || sc == ""){ alert_app("SITE KEY를 입력해주세요"); return; }

	var chat_name = $("#chat_name").val();

	if(chat_name == ""){
		alert_app("대화명을 입력해주세요"); 
		$("#chat_name").focus();
		return;
	}
	
	$.ajax({
			url:"http://"+chat_server+"/api/chat/set_chat_name.php",
			dataType:"jsonp",
			jsonp:"callback",
			data:{
				site_key:sk,
				secret:sc,
				chat_id:"<?=$chat_id?>",
				chat_name:chat_name
			},
			success:function(result){
				
				if(result["result"] == "true"){
	
					toast("저장되었습니다.");
				} else {
					
					alert_app(result["message"]);
				}
			},
			error:function(x,o,e){
				alert(x+":"+o+":"+e);
			}
	});
}	

function get_chatName(){

	//if(!chk_sitekey()) return;
	var sk = site_key;
	var sc = secret;
	if(sk == "" || sc == "") return;
	
	$.ajax({
			url:"http://"+chat_server+"/api/chat/get_chat_info.php",
			dataType:"jsonp",
			jsonp:"callback",
			data:{
				site_key:sk,
				secret:sc,
				chat_id:"<?=$chat_id?>"
			},
			success:function(result){
				
				if(result["result"] == "true"){

					$("#chat_name").val(result["chat_name"]);
				} else {
					//alert("fail");
				}
			},
			error:function(x,o,e){
				alert(x+":"+o+":"+e);
			}
	});
}


function img_upload_success(){
	go_link_page("p=3_1_1_1");
}






function absent_time_add(){

	var sk = site_key;
	var sc = secret;
	
	var stime = $("#shour").val() + ":"+ $("#smin").val();
	var etime = $("#ehour").val() + ":" + $("#emin").val();
	
	if(stime == etime){
		alert_app("시작시간과 끝시간에 동일한 시간을 지정할 수 없습니다.");
		return;
	}
	if($("#absent_time > option[value='"+stime+"|"+etime+"']").size() > 0){
		alert_app("해당 시간이 이미 등록되어 있습니다.");
		return;
	}

	//부재중시간 저장
	$.ajax({

		url:"http://"+chat_server+"/api/chat/set_absent_time.php",
		dataType:"jsonp",
		jsonp:"callback",
		data:{
			site_key:sk,
			secret:sc,
			stime:stime,
			etime:etime,
			type:"i"
		},
		success:function(result){
			
			if(result["message"] == "OK"){
				toast("설정이 저장되었습니다.");

				$("#absent_time").append("<option value='"+stime+"|"+etime+"'>"+stime+" ~ "+etime+"</option>");
				$("#absent_time > option").last().attr("selected", "selected");
				$("#absent_time").change();

			} else {
				alert_app(result["message"]);
			}
		}, 
		error:function(x, o, e){
			alert_app(x+":"+o+":"+e);
		}
	});

}

function absent_time_delete(){
	

	var sk = site_key;
	var sc = secret;


	
	var d = $("#absent_time").val();
	
	var data = d.split("|");
	var stime = data[0];
	var etime = data[1];
	
	//부재중시간 삭제
	$.ajax({

		url:"http://"+chat_server+"/api/chat/set_absent_time.php",
		dataType:"jsonp",
		jsonp:"callback",
		data:{
			site_key:sk,
			secret:sc,
			stime:stime,
			etime:etime,
			type:"d"
		},
		success:function(result){
			
			if(result["message"] == "OK"){
				toast("설정이 저장되었습니다.", 2000);
				$("#absent_time > option[value='"+stime+"|"+etime+"']").remove();
				$("#absent_time").change();

			} else {
				alert_app(result["message"]);
			}
		}, 
		error:function(x, o, e){
			alert_app(x+":"+o+":"+e);
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

	var sk = site_key;
	var sc = secret;
	
	//부재중정보 저장
	$.ajax({
		
		url:"http://"+chat_server+"/api/chat/set_absent_config.php",
		dataType:"jsonp",
		jsonp:"callback",
		data:{
			site_key:sk,
			secret:sc,
			field:field,
			value:value
		},
		success:function(result){
			
			if(result["message"] == "OK"){
				toast("설정이 저장되었습니다.");
			} else {
				alert_app(result["message"]);
			}
		}, 
		error:function(x, o, e){
			alert(x+":"+o+":"+e);
		}
	});


}






//카메라 콜백
var procileCameraCallback = {
		imageClass:"",
		success:function(imageData){
				
				 $(" ."+procileCameraCallback.imageClass).attr("src", "data:image/jpeg;base64," + imageData);
				 var imgWidth = $(" ."+procileCameraCallback.imageClass).width();
				 $(" ."+procileCameraCallback.imageClass).css("height", imgWidth+"px");
				
				 var type = procileCameraCallback.type;
				 var no = procileCameraCallback.no;
				
				showProgress("파일을 업로드중입니다.");
				$("#profile_image").val(imageData);
				$("#f_profileImgSave").submit();
				 
		},
		error:function(message){
			alert_app(message);
		}
}

//카메라사진찍기
function get_profile_camera_picture(sType, imageClass, quality){
	

	var sourceType = 0;
	if(sType == "album")
		sourceType = Camera.PictureSourceType.SAVEDPHOTOALBUM;
	else
		sourceType = Camera.PictureSourceType.CAMERA;
	
	if(quality === undefined)
		quality = 50;
	
	procileCameraCallback.imageClass = imageClass;

	
	navigator.camera.getPicture(procileCameraCallback.success, procileCameraCallback.error, {
		quality:quality,
		destinationType:Camera.DestinationType.DATA_URL,
		sourceType:sourceType
	});
	
}



</script>


