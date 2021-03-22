var is_device_ready = false;
var is_page_loaded = false;
var default_loading_delay = 100;

var AgentType = navigator.userAgent;
var flatform = {
	  iphone:       AgentType.match(/(iPhone|iPod)/),
	  ipad:         AgentType.match(/iPad/),
	  android:      AgentType.match(/Android/),
	  galaxyS:      AgentType.match(/SHW-M110S/),
	  galaxyNote:   AgentType.match(/SHV-E160S/),
	  galaxyNexus:  AgentType.match(/SHW-M420S/),
	  galaxyTab89:  AgentType.match(/SHV-E140S/),
	  galaxyTab101: AgentType.match(/SHW-M380S/)
	};



//삭제 검사 확인
function del_app(href) 
{
	confirm_app("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?", function(){
		
		if (g4_charset.toUpperCase() == 'EUC-KR') 
            document.location.href = href;
        else
            document.location.href = encodeURI(href);
		
	});
}


function loading(){
	showProgress("잠시만 기다려주세요..");
}

//안드로이드 뺑뺑이 표시
function showProgress(msg){
	cordova.exec(function(result){}, function(err){}, "CallNative", "showProgress", [msg]);
}

//안드로이드 뺑뺑이 닫기
function closeProgress(delay){
	
	if(delay === undefined || delay == ""){		
		cordova.exec(function(result){}, function(err){}, "CallNative", "closeProgress", []);

	} else {
		
		setTimeout(function(){closeProgress("");}, delay);
	}
}


//안드로이드 뺑뺑이 표시2
function showSystemProgress(msg){
	cordova.exec(function(result){}, function(err){}, "CallNative", "showSystemProgress", [msg]);
}

//안드로이드 뺑뺑이 닫기2
function closeSystemProgress(delay){
	
	if(delay === undefined || delay == ""){		
		cordova.exec(function(result){}, function(err){}, "CallNative", "closeSystemProgress", []);

	} else {
		
		setTimeout(function(){closeSystemProgress("");}, delay);
	}
}



//noti로 앱 실행시킨 경우 자동이동
function goto_first_page(bo_table, wr_id, nofirst){
	
	if(nofirst === undefined) nofirst = false;
	
	var qs = "";
	
	if(bo_table != "ninetalk"){
		qs = "p=1_2_1_1&bo_table="+bo_table+"&wr_id="+wr_id+"&first=Y";
	}
		
	if(nofirst)
		go_link_page(qs);	
	else 
		location.href = "/app_alimi/pages.php?" + qs;
	
	/*
		var noti_type = window.localStorage.getItem("noti_type");
		if(noti_type != ""){
			window.localStorage.setItem("noti_type", "");
			if(noti_type == "push"){
					setTimeout(function(){menulink("menu04-2");}, 300);
			}
		}
	*/

}



//삭제 검사 확인
function del(href)
{
    if(confirm("삭제하시겠습니까?")) {
    	
    	loading();
    	
        if (g4_charset.toUpperCase() == 'EUC-KR')
            document.location.href = href;
        else
            document.location.href = encodeURI(href);
    }
}


function showSettingView(){
	
	cordova.exec(function(result){}, function(err){}, "CallNative", "settingView", [null]);
}



var upload_callback = null;
function upload_image(type, no, uploadUri, filetype, callback){
	upload_callback = callback;
	//uploadUri = "http://"+chat_domain+"/user/pages/common/" + uploadUri; //domain - /lib/classes/properties.php
	cordova.exec(function(result){}, function(err){alert(err);}, "ImageUploader", "select_gallery", [type, no, filetype, uploadUri]);
}
function image_upload_complete(str){
	 if(typeof(upload_callback) == "function") upload_callback(str);
	 upload_callback = null;
}




function save_image(imageData, filePath, fileName, callback, isLoading){
	
	 if(isLoading === undefined)
		 isLoading = true;
	 
	 if(isLoading) showProgress("파일을 저장중입니다. ");
	 $.post(g4_app_path + "/_ajax_save_base64image.php", {imageData:imageData, filePath:filePath, fileName:fileName}, function(data){
		 
		 if(isLoading) { closeProgress(500); }
		 
		 if(data == "OK"){
			 
			 if(callback !== undefined && typeof(callback) == "function"){				 
				 callback("data:image/jpeg;base64,"+imageData);
			 }
			 
		 } else {
			 
			 alert_app(data);
		 }
		 
	 });
}


function delete_image(filePath, fileName, confirm, callback){
	
	 confirm_app("이미지를 삭제하시겠습니까?", function(){
	
		 showProgress("파일을 삭제중입니다. ");
		 $.post(g4_app_path + "/_ajax_delete_image.php", {filePath:filePath, fileName:fileName}, function(data){
			 
			 closeProgress(500);
			 if(data == "OK"){
				 if(callback !== undefined && typeof(callback) == "function"){				 
					 callback();
				 }
			 } else {
				 alert_app(data);
			 }
			 
		 });
		 
	 });
}



$(window).load(function(){
	
	is_page_loaded = true;
	
	if(is_device_ready) {

		closeProgress(default_loading_delay);
		//goto_first_page();
	}


});




function setPush(){


	FCMPlugin.getToken(
	  function(token){
		  
		if(token == "") return;
		
		$.post(g4_app_path+"/_ajax_save_fcmid.php", {fcm_id:token, device_serial:device.uuid}, function(data){
			//check_push_onoff();
		});

	  },
	  function(err){
		//console.log('error retrieving token: ' + err);
	  }
	)


	FCMPlugin.onNotification(


	  function(data){

		var message = data.body;
		var title = data.title;
		
		var board = data.board;
		var no = data.no;
		var type1 = data.type1;
		var type2 = data.type2;

	
		if(data.wasTapped) {
			
			if(!notification_pagemove(board, no, type1, type2)){ //이동할 페이지가 없으면
				closeProgress();
				alert_app(message, title);
			}

		} else {
			
			
			//푸시메시지 받는 화면에서 처리
			if(typeof(receive_push_event) == "function"){
				if(!receive_push_event(title, message, board, no, type1, type2)){ //리턴 결과에따라 하단 내용 처리 안함
					return;
				} 
			};
	
	
			if(typeof(board) != "undefined" && no != ""){ //게시판 바로보기


					//현재 해당 채팅창이 열려있는지 확인
					var room_no = no;
					var open_room_no = $("#chatpanel #room_no").val();
					
					//채팅방이 열려있으면
					if(open_room_no !== undefined && open_room_no != null && open_room_no != "" && open_room_no == room_no) {
						return;
					}
					
					navigator.notification.confirm(message, function(btn) { 
						
						if(btn==1){
							notification_pagemove(board, no, type1, type2);
						} else {
							closeProgress();
						}
						
					}, title, '자세히보기, 닫기');
				

			} else {
					closeProgress();
					alert_app(message, title);
			}

		}


	  },
	  function(msg){
	  },
	  function(err){
	  }
	);



}

//푸시메시지를 통한 페이지 이동
function notification_pagemove(board, no, type1, type2){
	
	showProgress("잠시만 기다려주세요...");	
	try {
		
		if(board == "" || board == null || board == "null" || board === undefined ) {
			closeProgress();
			return false;
		}
		else if(type1 == "board") { //게시판 푸시
			
					location.href=g4_app_path+"/pages.php?p=2_2_1_1&bo_table="+board+"&wr_id="+no;

		} else if(type1 == "global_notice") { //전체공지
			
			location.href=g4_app_path+"/pages.php?p=4_2_1_1&wr_id="+no;
		
		} else if(type1 == "modify_req") { //수정의뢰게시판

			location.href=g4_app_path+"/pages.php?p=3_2_1_1&wr_id="+no;
		
		} else if(type1 == "analytics") {
			
			if(board == "analytics") {
				location.href=g4_app_path+"/pages.php?p=1_1_1_1";
			} else if (board == "traffic") {
				location.href=g4_app_path+"/pages.php?p=1_4_1_1";
			}

		} else if(type1 == "chatting") {

			open_chatting(no);
			return true;

		}  else  {
		
			
		}
	
	} catch(ex){
		
		closeProgress();
		alert_app(ex);
		
	}

	return true;
	
}



//채팅창 열기
function open_chatting(roomno){
	
	showSystemProgress("잠시만 기다려주세요...");
	$("#chatpanel").load(g4_app_path + "/include/5_2_1_1.php", {room_no:roomno}, function(data){
		var _self = this;
		setTimeout(function(){
			$(_self).fadeIn(400);
			$(".chatarea").scrollTop($(".chatarea")[0].scrollHeight);
			closeSystemProgress();
		},500);
	});

}



//읽지않은 실시간 알리미 & 실시간 챗팅 갯수 세기
function get_not_read_cnt(chat_id){
	var sk = site_key;
	var sc = secret;

	//현재 ChatID가 읽지않은 챗팅 갯수(최근10일(ninetalk.1941.co.kr에 sqlmap에 정의됨))
	$.ajax({
		url:"//"+chat_server+"/api/chat/get_not_read_cnt.php",
		dataType:"jsonp",
		jsonp:"callback",
		data:{
			site_key:sk,
			secret:sc,
			chat_id:chat_id
		},
		success:function(result){
			
			var chatCnt = parseInt(result["not_read_cnt"]);
			if(isNaN(chatCnt)) chatCnt = 0;
			
			//현재까지 읽지 않은 Alimi 갯수
			$.post(g4_app_path + "/_ajax_get_not_read_alimi.php", null, function(data){
				var alimiCnt = parseInt(data);
				if(isNaN(data)) alimiCnt = 0;

				var badgeCnt = chatCnt + alimiCnt;

				setIconBadge(badgeCnt); //안읽은 숫자만큼 Badge ICON 설정
			});

		},
		error:function(x,o,e){
			//alert(x+":"+o+":"+e);

		}
	});

}
	
