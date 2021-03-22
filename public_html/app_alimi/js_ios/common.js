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
	
}
function onFS(fs) {
    alert(fs.root.fullPath); 
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






//FCM Setting
function setPush(){


	FCMPlugin.getToken(
	  function(token){
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
		
		var bo_table = data.bo_table;
		var wr_id = data.wr_id;
		var room_no = data.room_no;


		if(data.wasTapped) { 
			
			if(typeof(room_no) == "string") { //채팅푸시
				//채팅창 열기
				open_chatting(room_no);
			}
			else if(!notification_pagemove(bo_table, wr_id, room_no)){ 
				alert_app(message, title); //이동할 페이지가 없으면
			}

		} else {
			

			if(typeof(room_no) == "string") { //채팅푸시
				
				//현재 해당 채팅창이 열려있는지 확인
				var open_room_no = $(".ui-page-active #chatpanel #room_no").val();
				
				//다른 방이 열려있거나 열려있지 않으면 이동 문의
				if(open_room_no != room_no) {
					navigator.notification.confirm(message, function(btn){
						if(btn == 1){
							//현재 채팅창 종료시킴
							if(typeof(close_chat) == "function"){
								eval("close_chat()");
							 }
							 //채팅창 열기
							 setTimeout(function(){ open_chatting(room_no); }, 500);
						}
						if(typeof(roomlist_refresh) == "function"){
							roomlist_refresh();
						}
					}, title, 'OK, CANCEL');
				}


			} else if(typeof(bo_table) == "string" && bo_table != "") {  //게시판 푸시

					navigator.notification.confirm(message, function(btn) { 
						if(btn==1){
							notification_pagemove(bo_table, wr_id);
						}
					}, title, 'OK, CANCEL');


			} else {
				
				alert_app(message, title);
			}

		}


	  },
	  function(msg){
		  //alert("SCCESS"+msg);
	  },
	  function(err){
		  //alert("ERROR"+err);
	  }
	);


}


//푸시메시지를 통한 페이지 이동
function notification_pagemove(bo_table, wr_id){
	
	showProgress("잠시만 기다려주세요...");
	
	//채팅창 열려있으면 종료시킴
	 if(typeof(close_chat) == "function"){
		eval("close_chat()");
	 }

	try {
		var qs = "";
		qs = "p=1_2_1_1&bo_table="+bo_table+"&wr_id="+wr_id+"&first=Y";
		go_link_page(qs);	
		closeProgress(1000);
	
	} catch(ex){
		
		alert_app(ex);
		closeProgress();
		
	}

	return true;
	
}