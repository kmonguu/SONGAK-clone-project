
var is_main = false;

var application_name = "홈페이지 알리미";
var confirmBtn = 'OK, CANCEL';

function init_phone_event(){
	try{

		document.addEventListener("pause", onPause, false);

	}catch(ex){
		error(ex);
	}
	
	is_device_ready = true;
	
	if(is_page_loaded) {
		closeProgress(default_loading_delay);
	}
	
	//IOS전용
	initKeyboardSetting();
	Keyboard.onshowing = function () {
		$(".ui-footer").hide()
	}
	Keyboard.onhide = function () {
		$(".ui-footer").show();
	}
} 


function initKeyboardSetting(){
		if(is_device_ready) {
			Keyboard.shrinkView(true);
			Keyboard.hideFormAccessoryBar(true);
			Keyboard.disableScrollingInShrinkView(true);
		}
}

function onPause(){
	/*
	if (navigator.app && navigator.app.exitApp) {
		navigator.app.exitApp();
	} else if (navigator.device && navigator.device.exitApp) {
		navigator.device.exitApp();
	}
	*/
}

function onBackButton(){
	
	if($(".ui-page-active #chatpanel #room_no").val() != "" && $(".ui-page-active #chatpanel #room_no").val() !== undefined){
		eval("close_chat()");
	}
	else if($(".ui-page-active .ui-panel-open").size() > 0) {
	
		$(".ui-panel").panel("close");
		
	}
	else if(is_main){
	
		try{
			exit_app();
		}catch(ex){
			error(ex);
		}
		
	} else {
		backlink();
		//history.go(-1);
	}
}


function confirm_app(msg, callback){
	try {
	navigator.notification.confirm(msg, function(btn){
		if(btn == "1") {
			callback();
		}
	}, application_name, confirmBtn);
	} catch(ex){
		alert(ex);
	}
}



function alert_app(msg, title){
	if(title === undefined || title == null || title == ""){
		title = application_name;
	}
	navigator.notification.confirm(msg, null, title, 'OK');
}



function exit_app(){
	try{
			navigator.notification.confirm('종료하시겠습니까?', onBackKeyDownMsg, application_name, 'OK, CANCEL');
		}catch(ex){
			error(ex);
		}
}

function onBackKeyDownMsg(button){

	try{
		if(button==1){
			
			$.post(g4_app_path+"/del_session.php", null, function(){ //세션삭제하고 종료
				
				if (navigator.app && navigator.app.exitApp) {
					navigator.app.exitApp();
				} else if (navigator.device && navigator.device.exitApp) {
					navigator.device.exitApp();
				}
				
			});
			
		}
	}catch(ex){
		error(ex);
	}
}


function exit(){
	onBackKeyDownMsg(2);
}

function error(msg){
		alert(msg);
}


//카메라 콜백
var cameraCallback = {
		imageClass:"",
		success:function(imageData){
				
			 	$(".ui-page-active").find(" ."+cameraCallback.imageClass).attr("src", "data:image/jpeg;base64," + imageData);
				
				 var type = cameraCallback.type;
				 var no = cameraCallback.no;
				
				showProgress("파일을 업로드중입니다.");
				$(".ui-page-active #profile_image").val(imageData);
				$(".ui-page-active #f_profileImgSave").submit();
				 
		},
		error:function(message){
			alert_app(message);
		}
}

//카메라사진찍기
function get_camera_picture(sType, imageClass, quality){
	

	var sourceType = 0;
	if(sType == "album")
		sourceType = Camera.PictureSourceType.SAVEDPHOTOALBUM;
	else
		sourceType = Camera.PictureSourceType.CAMERA;
	
	if(quality === undefined)
		quality = 50;
	
	cameraCallback.imageClass = imageClass;

	
	navigator.camera.getPicture(cameraCallback.success, cameraCallback.error, {
		quality:quality,
		destinationType:Camera.DestinationType.DATA_URL,
		sourceType:sourceType
	});
	
}