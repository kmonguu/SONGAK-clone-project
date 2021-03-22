<?
include "./_common.php";
$chat_id = get_session("chat_id");

$obj = new ChatInfo();

//$ci = $obj->get($chat_id);

/*
if(!$ci[chat_id]) {
	
	$params = array();
	$params["chat_id"] = $chat_id;
	$params["chat_name"] = "관리자";
	$obj->insert($params);
	
	$ci = $obj->get($chat_id);
}
*/


?>


<style>
	.m_write ul li {margin:0px 0 15px 0;}
	.li_title {background-color:#1d1d1d; font-size:1.3em; font-weight:bold; color:white;}
	
	.my-breakpoint2.ui-grid-a .ui-block-a { width: 65%; padding:0 0 0 0.5%;  }
	.my-breakpoint2.ui-grid-a .ui-block-b { width: 35%; padding:0 0 0 0; margin-top:-3px;}
	
	.my-breakpoint3.ui-grid-a .ui-block-a { width: 40%; padding:0 0 0 0.5%;  }
	.my-breakpoint3.ui-grid-a .ui-block-b { width: 60%; padding:0 0 0 0; margin-top:5%;}
</style>


<div class="m_write">
	<ul>
		<li class="li_title">
		SITE KEY
		</li>
		<li>

			<div class="ui-grid-a my-breakpoint2" style="width:100%;">
				<div class="ui-block-a">
					<input type="text" name="site_key" id="site_key" itemname="이름" required="required" placeholder="SITE KEY" value="" onFocus="this.placeholder=''">
				</div>
				<div class="ui-block-b">
					<a href="" data-role='button' style='' onclick="setSiteKey()">저장</a>
				</div>
			</div>

		</li>
		<li class="li_title">
		대화명
		</li>
		<li>
		
			<div class="ui-grid-a my-breakpoint2" style="width:100%;">
				<div class="ui-block-a">
					<input type="text" name="chat_name" id="chat_name" itemname="대화명" required="required" placeholder="대화명" value="<?=$ci[chat_name]?>" onFocus="this.placeholder=''">
				</div>
				<div class="ui-block-b">
					<a href="" data-role='button' style='' onclick="set_chatName()">저장</a>
				</div>
			</div>
			
			
		</li>
		<li class="li_title">
		프로필사진
		</li>
		<li>
			
			
			<div class="ui-grid-a my-breakpoint3" style="width:100%;">
				<div class="ui-block-a">
					<img class='profile_picture' src="http://<?=$_SESSION["chat_server"]?>/data/profile/thumb/200x200_100/<?=$chat_id?>?<?=date("YmdHis")?>" style="width:80px;height:80px;border-radius:5px;" onerror="javascript:this.src='http://ninetalk.1941.co.kr/res/images/user1.png'"/>
				</div>
				<div class="ui-block-b">
					<!-- <button onclick="upload_image('profile', '<?=$chat_id?>', 'UploadProfileImg.php', '', img_upload_success)">사진변경</button> -->
					<button onclick="get_camera_picture('album', 'profile_picture')">사진변경</button>
					<button onclick="get_camera_picture('camera', 'profile_picture')">사진촬영</button>
				</div>
			</div>
			
			
			<form id="f_profileImgSave" method="post" action="//<?=$_SESSION["chat_server"]?>/app_alimi/fileupload/UploadProfileImg2.php" target='profileImg_hidden_frame'>
				<input type="hidden" name="image" id="profile_image" />
				<input type="hidden" name="type" value="profile" />
				<input type="hidden" name="no" value="<?=$chat_id?>" />
			</form>
			<iframe name="profileImg_hidden_frame" style="display:none;" onload="closeProgress();"></iframe>

		</li>
	</ul>
</div>		
	
	
<div class="m_write">
<ul>
	<li class="li_title">
	첫메시지 설정
	</li>
	<li>
		<div data-role="fieldcontain">
		 	<fieldset data-role="controlgroup">
				<legend></legend>
				<input type="checkbox" name="use_first_msg" id="use_first_msg" class="custom" value="Y" onclick="set_use_firstmsg()"/>
				<label for="use_first_msg">첫메시지 표시</label>
		    </fieldset>
		</div>
		
	</li>
	
	<li class="li_title">
		첫 메시지
	</li>
	<li>
		<textarea id="first_msg" name="first_msg" style="width:99%;height:200px"></textarea>
		<input type="button" value="첫 메시지 저장" onclick="set_firstmsg()"/>
	</li>
		
</ul>
</div>
	
	
<style>
	.my-breakpoint3.ui-grid-c .ui-block-0 { width: 2%; padding:0 0 0 0.5%;  }
	.my-breakpoint3.ui-grid-c .ui-block-a { width: 49%; padding:0 0 0 0.5%;  }
	.my-breakpoint3.ui-grid-c .ui-block-b { width: 49%; padding:0 0 0 0.5%;  }

	.my-breakpoint4.ui-grid-d .ui-block-a { width: 35%; padding:0 0 0 0.5%;  }
	.my-breakpoint4.ui-grid-d .ui-block-b { width: 35%; padding:0 0 0 0.5%;  }
	.my-breakpoint4.ui-grid-d .ui-block-c { width: 30%; padding:0 0 0 0;}

</style>
	
<div class="m_write">
	<ul>
		<li class="li_title">
		부재중 설정
		</li>
		<li>
			<div data-role="fieldcontain">
			 	<fieldset data-role="controlgroup">
					<legend></legend>
					<input type="checkbox" name="is_absent" id="is_absent" class="custom" value="Y" onclick="set_absent()"/>
					<label for="is_absent">부재중 표시</label>
			    </fieldset>
			</div>
			
		</li>
		
		<li class="li_title">
			부재중 자동설정 요일
		</li>
		
		<li>
		
			<div data-role="fieldcontain">
			 	<fieldset data-role="controlgroup">
					<legend></legend>
					<input type="checkbox" class="absent_yoil" name="absent_yoil" id="absent_yoil0" class="custom" value="Y" />
					<label for="absent_yoil0">일요일</label>
					<input type="checkbox" class="absent_yoil" name="absent_yoil" id="absent_yoil1" class="custom" value="Y" />
					<label for="absent_yoil1">월요일</label>
					<input type="checkbox" class="absent_yoil" name="absent_yoil" id="absent_yoil2" class="custom" value="Y" />
					<label for="absent_yoil2">화요일</label>
					<input type="checkbox" class="absent_yoil" name="absent_yoil" id="absent_yoil3" class="custom" value="Y" />
					<label for="absent_yoil3">수요일</label>
					<input type="checkbox" class="absent_yoil" name="absent_yoil" id="absent_yoil4" class="custom" value="Y" />
					<label for="absent_yoil4">목요일</label>
					<input type="checkbox" class="absent_yoil" name="absent_yoil" id="absent_yoil5" class="custom" value="Y" />
					<label for="absent_yoil5">금요일</label>
					<input type="checkbox" class="absent_yoil" name="absent_yoil" id="absent_yoil6" class="custom" value="Y" />
					<label for="absent_yoil6">토요일</label>
			    </fieldset>
			</div>
			
			<input type="button" value="부재중 요일설정 저장" onclick="set_absent_yoil()"/>
			
		</li>
		
		<li class="li_title">
			부재중 자동설정 시간 추가
		</li>
		<li>
			<div class="ui-grid-c my-breakpoint3" style="width:100%;">
				<div class="ui-block-0">
				</div>
				<div class="ui-block-a">
					<select id="shour" name="shour" >	
						<?for($i = 0 ; $i <= 23 ; $i++){ $ii = sprintf("%02d", $i);?>
							<option value="<?=$ii?>"><?=$ii?>시</option>
						<?}?>
					</select>
				</div>
				<div class="ui-block-b">
					<select id="smin" name="smin" >	
						<?for($i = 0 ; $i <= 60 ; $i += 10){ $ii = sprintf("%02d", $i);?>
							<option value="<?=$ii?>"><?=$ii?>분</option>
						<?}?>
					</select>
				</div>
			</div>
		</li>
		
		<li>
			<div class="ui-grid-c my-breakpoint3" style="width:100%;">
				<div class="ui-block-0">
					~
				</div>
				<div class="ui-block-a">
					<select id="ehour" name="ehour" >	
						<?for($i = 0 ; $i <= 23 ; $i++){ $ii = sprintf("%02d", $i);?>
							<option value="<?=$ii?>"><?=$ii?>시</option>
						<?}?>
					</select>
				</div>
				<div class="ui-block-b">
					<select id="emin" name="emin" >	
						<?for($i = 0 ; $i <= 60 ; $i += 10){ $ii = sprintf("%02d", $i);?>
							<option value="<?=$ii?>"><?=$ii?>분</option>
						<?}?>
					</select>
				</div>
			</div>
		</li>
		
		<li>
			<div style="width:100%;">
				<input type="button" value="추가" onclick="absent_time_add()"> 
			</div>
		</li>
		
		<li class="li_title">
			등록된 부재중 자동설정 시간 목록
		</li>
		<li>	
			<div style="width:100%;padding:9px 0 0 0;">
				<select id="absent_time" name="absent_time" style="width:100%" >
				</select>
				<input type="button" value="선택삭제" onclick="absent_time_delete()">
			</div>
		</li>
		
		<li class="li_title">
		부재중 표시 메시지
		</li>
		<li>
		<textarea id="absent_msg" name="absent_msg" style="width:99%;height:200px"></textarea>
		<input type="button" value="부재중 메시지 저장" onclick="set_absent_msg()"/>
		</li>
		
	</ul>
</div>		


<script type="text/javascript">

$(function(){

	
	get_absent_data();
	
});

function pageshow(){
	
	if($(".ui-page-active .pageName").val() == "3_1"){
		$(".ui-page-active #site_key").val(window.localStorage.getItem("site_key"));
		get_chatName();
	}
}


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
				$(".ui-page-active  #use_first_msg").prop("checked", true).checkboxradio('refresh');
			}
			$(".ui-page-active  #first_msg").val(result["first_msg"]);

			
			if(result["is_absent"] == "Y"){
				$(".ui-page-active #is_absent").prop('checked',true).checkboxradio('refresh');
			}
			$(".ui-page-active #absent_msg").val(result["absent_msg"]);


			$(".ui-page-active .absent_yoil").each(function(){				
					$(this).prop("checked",false);
			});
			
			var ayoils = result["absent_yoil"];
			if(ayoils != ""){
				var ayoil = ayoils.split("|");
				if(ayoil.length > 0){

					for(var yidx = 0 ; yidx < ayoil.length; yidx++){
							if(ayoil[yidx] == "Y"){
								$(".ui-page-active #absent_yoil"+yidx).prop("checked", true);
							}
					} 
				}
			}

			$(".ui-page-active .absent_yoil").checkboxradio('refresh');

			
			var atime = result["absent_time"];
			for(var i = 0 ; i < atime.length ; i ++){
				var row = atime[i];
				$(".ui-page-active #absent_time").append("<option value='"+row["stime"]+"|"+row["etime"]+"'>"+row["stime"]+" ~ "+row["etime"]+"</option>");
				$(".ui-page-active #absent_time").selectmenu('refresh');
			}
		}, 
		error:function(x, o, e){
			alert(x+":"+o+":"+e);
		}
	});
}


function setSiteKey(){

	var sk = $(".ui-page-active #site_key").val();
	
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
					
					window.localStorage.setItem("site_key", sk);
					window.localStorage.setItem("secret", result.secret);
					alert_app("저장되었습니다.");

					site_key = sk;
					secret = result.secret;
					get_chatName();
					get_absent_data();
				
				} else {
					alert_app("SITE KEY가 올바르지 않습니다.");
					$(".ui-page-active #chat_name").val("");
					window.localStorage.removeItem("site_key", site_key);
					window.localStorage.removeItem("secret", result.secret);
					site_key = "";
					secret = "";
				}
			} catch(e){
					alert(e);
			}
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

	var chat_name = $(".ui-page-active #chat_name").val();

	if(chat_name == ""){
		alert_app("대화명을 입력해주세요"); 
		$(".ui-page-active #chat_name").focus();
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
	
					alert_app("저장되었습니다.");
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

					$(".ui-page-active #chat_name").val(result["chat_name"]);
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
	
	var stime = $(".ui-page-active #shour").val() + ":"+ $(".ui-page-active #smin").val();
	var etime = $(".ui-page-active #ehour").val() + ":" + $(".ui-page-active #emin").val();
	
	if(stime == etime){
		alert_app("시작시간과 끝시간에 동일한 시간을 지정할 수 없습니다.");
		return;
	}
	if($(".ui-page-active #absent_time > option[value='"+stime+"|"+etime+"']").size() > 0){
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
				alert_app("설정이 저장되었습니다.");

				$(".ui-page-active #absent_time").append("<option value='"+stime+"|"+etime+"'>"+stime+" ~ "+etime+"</option>");
				$(".ui-page-active #absent_time > option").last().attr("selected", "selected");
				$(".ui-page-active #absent_time").selectmenu('refresh');

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


	
	var d = $(".ui-page-active #absent_time").val();
	
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
				alert_app("설정이 저장되었습니다.");
				$(".ui-page-active #absent_time > option[value='"+stime+"|"+etime+"']").remove();
				$(".ui-page-active #absent_time").selectmenu('refresh');

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
	var usefirst = $(".ui-page-active #use_first_msg").is(":checked");
	var value =  usefirst ? "Y" : "N";
	var field = "use_first_msg";
	save_absent_config(field, value);
}


function set_firstmsg(){

	var value = $(".ui-page-active #first_msg").val();
	var field = "first_msg";

	save_absent_config(field, value);
	
}


function set_absent(){

	var isab = $(".ui-page-active #is_absent").is(":checked");
	var value =  isab ? "Y" : "N";
	var field = "is_absent";
	
	save_absent_config(field, value);
}

function set_absent_yoil(){

	var value = "";
	$(".ui-page-active .absent_yoil").each(function(){
			if(value != "") value += "|";
			value += $(this).is(":checked") ? "Y" : "N";
	});
	
	var field = "absent_yoil";

	save_absent_config(field, value);
}

function set_absent_msg(){
	
	var value = $(".ui-page-active #absent_msg").val();
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
				alert_app("설정이 저장되었습니다.");
			} else {
				alert_app(result["message"]);
			}
		}, 
		error:function(x, o, e){
			alert(x+":"+o+":"+e);
		}
	});


}


</script>

