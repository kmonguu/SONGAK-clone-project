var is_device_ready = false;
var is_page_loaded = false;
var default_loading_delay = 500;

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



var gcm_payload = null;

//GCM
function onNotificationGCM (e){
	switch (e.event) {
		case 'registered': // 안드로이드 디바이스의 registerID를 획득하는 event 중 registerd 일 경우 호출된다.
			console.log('registerID:' + e.regid);
			
			if(typeof(go_login) == "function") {
				if(!e.coldstart) {
					go_login(e.regid); 
				} else {
					//푸시를 선택하여 실행된 경우 바로 로그인하지 않고 기다림
				}
			}
			break;
			
			
		case 'message': // 안드로이드 디바이스에 푸시 메세지가 오면 호출된다.
			

			if (e.foreground) { // 푸시 메세지가 왔을 때 앱이 실행되고 있을 경우
				
				
				
				e.payload.message = e.payload.message.split("<br/>").join("\n");
				gcm_payload = e.payload;
				
				if(typeof(e.payload.room_no) == "string"){ //채팅 푸시
				
					//현재 해당 채팅창이 열려있는지 확인
					var gcm_room_no = gcm_payload.room_no;
					var open_room_no = $(".ui-page-active #chatpanel #room_no").val();
					
					//다른 방이 열려있거나 열려있지 않으면 Move 문의
					if(open_room_no != gcm_room_no) {
						navigator.notification.confirm(e.payload.message+"\n\n채팅창으로 이동하시겠습니까?", gcm_sended_chat, e.payload.title, 'OK, Cancel');
					}
					
					
				} else { //게시판 푸시
								
					navigator.notification.confirm(e.payload.message+"\n\n채팅창으로 이동하시겠습니까?", gcm_sended, e.payload.title, 'OK, Cancel');
				}
				
				
				
				
			} else { //백그라운드로 OR 실행되지 않을 경우
				
				
				if (e.coldstart) { //푸시를 선택하여 앱이 열렸을 경우
					
					if(typeof(e.payload.room_no) == "string"){ //채팅 푸시	
					
						go_login(e.regid, "chatting", e.payload.room_no); //로그인한 후 열릴 채팅창
						
					} else {
						
						go_login(e.regid, e.payload.bo_table, e.payload.wr_id); //로그인하며 Move할페이지
					}
					
					
					
				} else { //앱이 백그라운드로 사용되고 있을 경우
					
					
					
					e.payload.message = e.payload.message.split("<br/>").join("\n");
					gcm_payload = e.payload;
					
				
					if(typeof(e.payload.room_no) == "string"){ //채팅 푸시
						
						navigator.notification.confirm(e.payload.message+"\n\n채팅창으로 이동하시겠습니까?", gcm_sended_chat, e.payload.title, 'OK, Cancel');
					} else {
						
						navigator.notification.confirm(e.payload.message+"\n\n채팅창으로 이동하시겠습니까?", gcm_sended, e.payload.title, 'OK, Cancel');
					}
									
				}
			}	
			
			
		break;
			case 'error': // 푸시 메세지 처리에 에러가 발생하면 호출한다.
			console.log('error:' + e.msg);
		break;
			case 'default':
			console.log('알수 없는 이벤트');
		break;
	}
}

 function tokenHandler(result){
              console.log('deviceToken:' + result);
}
function errorHandler(err){
	console.log('error:' + err);
}
	function successHandler(result){
	console.log('result:'+result);
}


//게시판 GCM메시지를 실행중에 받은 경우
function gcm_sended(button){
	try{
		if(button==1){ 
			
			//채팅창 열려있으면 종료시킴
			 if(typeof(close_chat) == "function"){
				eval("close_chat()");
			 }
			 
			//menulink("menu04-2");
			goto_first_page(gcm_payload.bo_table, gcm_payload.wr_id, true);
		}
	}catch(ex){
		error(ex);
	}
}


//실시간 채팅 GCM메시지를 실행중에 받은 경우
function gcm_sended_chat(button){
	
	try{

		if(button == 1){
			 
			 //현재 채팅창 종료시킴
			 if(typeof(close_chat) == "function"){
				eval("close_chat()");
			 }
			
			 //채팅창 열기
			 setTimeout(function(){ open_chatting(gcm_payload.room_no); }, 500);
		}
		
		
		 if(typeof(roomlist_refresh) == "function"){
			 roomlist_refresh();
		 }
		
	} catch(ex){
		error(ex);
	}
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

//P서비스 시작
function p_service_start(){
	gcmid = window.localStorage.getItem('gcmId');
	cordova.exec(function(result){}, function(err){}, "CallNative", "p_service_start", [gcmid]);
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




//채팅창 열기
function open_chatting(roomno){
	
	showProgress("Loading...");
	$(".ui-page-active #chatpanel").load(g4_app_path + "/pages/talk/chatting.php", {room_no:roomno}, function(data){
		$(this).panel("open"); 
		closeProgress(1000);
	});
}


//인앱브라우져
var in_app_browser_loading = false;
function in_app_browser(url, option, exitCallback){
	
	if(option === undefined || option == null || option == "" ) 
		option = "zoom=yes,location=no";
	
	if(!in_app_browser_loading) {
		
		in_app_browser_loading = true;
		var ref  = cordova.InAppBrowser.open(url, "_blank", option);
		
		with(ref){
			addEventListener("exit", function(){ if(typeof(exitCallback) == "function") exitCallback(); });
		}
	}
	
	setTimeout(function(){
		in_app_browser_loading = false;
	}, 1000);
	
}




$(window).load(function(){
	
	is_page_loaded = true;
	
	if(is_device_ready) {

		closeProgress(default_loading_delay);
		//goto_first_page();
	}
});



function test(){
	navigator.notification.confirm("내용내용 내용내용 내용내용 내용내용\n\n\n\n채팅창으로 이동하시겠습니까?", function(button){}, "테스트님의 실시간 문의입니다.", 'OK, Cancel');
}





