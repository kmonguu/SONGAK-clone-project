
var is_main = false;

var application_name = "홈페이지도우미";
var confirmBtn = '확인, 취소';
var exitTimeout = null;

var init_phone_functions = new Array();

function init_phone_event(){
	
	try{
		document.addEventListener("backbutton", onBackButton, false); //백버튼 (Android 전용)
		document.addEventListener("pause", onPause, false);
		
	}catch(ex){
		error(ex);
	}
	
	is_device_ready = true;
	
	if(is_page_loaded) {
		closeProgress(default_loading_delay);
	}
	
	init_phone_functions.forEach(function(v, i) {
		if(typeof(v) == "function"){
			v();
		}
	});
	

	//IOS전용
	initKeyboardSetting();
	Keyboard.onshowing = function () {
		//Keyboard show
		if(typeof(onKeyboardShow) == "function") {
			onKeyboardShow();
		}
	}
	Keyboard.onhide = function () {
		//keyboard hide
		if(typeof(onKeyboardHide) == "function") {
			onKeyboardHide();
		}
	}

} 


function initKeyboardSetting(){
		if(is_device_ready) {
			Keyboard.shrinkView(false);
			Keyboard.hideFormAccessoryBar(false);
			Keyboard.disableScrollingInShrinkView(false);
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
	
	if(typeof(is_menu_open) != "undefined") {
			if(is_menu_open){
				menuclose();
				return;
			}
	}


	
	
	if($("#chatpanel #room_no").val() != "" && $("#chatpanel #room_no").val() !== undefined){
		eval("close_chat()");
		return;
	}
	
	
	if(is_main){
	
		try{
			exit_app();
		}catch(ex){
			error(ex);
		}
		
	} else {
		//backlink();
		if(typeof(override_backbutton_event) == "function") {
			override_backbutton_event();
		} else {
			history.go(-1);
		}
		
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
	navigator.notification.confirm(msg, null, title, '확인');
}



function toast(msg, time, position) {
	
	if(time === undefined) time = 2000;
	if(position === undefined) position = "bottom";
	

	window.plugins.toast.showWithOptions(
    {
      message: msg,
      duration: time, // ms 
      position: position,
      addPixelsY: -40,
      styling: {
          opacity: 0.55, // 0.0 (transparent) to 1.0 (opaque). Default 0.8
          backgroundColor: '#333333', // make sure you use #RRGGBB. Default #333333
          textColor: '#FFFFFF', // ditto. Default #FFFFFF (white).
          cornerRadius: 16, // minimum is 0 (square). iOS default 20, Android default 100
          horizontalPadding: 30, // iOS default 16, Android default 50
          verticalPadding: 30 // iOS default 12, Android default 30
        } 
    }
    , function(a) {}
    , function(b) {}
  );
}



var exit_flag = false;
function exit_app(){
	try{
		
				
		if(!exit_flag) {
			
			toast("뒤로(종료) 버튼을 한번 더 누르시면 종료됩니다.", 2000);
			exit_flag = true;
			clearTimeout(exitTimeout);
			exitTimeout = setTimeout(function(){exit_flag = false;}, 2000);
			
		} else {
			
			//종료
			if (navigator.app && navigator.app.exitApp) {
				navigator.app.exitApp();
			} else if (navigator.device && navigator.device.exitApp) {
				navigator.device.exitApp();
			}
		}
		
		
	}catch(ex){
		error(ex);
	}
}

function onBackKeyDownMsg(button){

	try{
		if(button==1){
			
			//$.post("/m/del_session.php", null, function(){ //세션삭제하고 종료
				
				if (navigator.app && navigator.app.exitApp) {
					navigator.app.exitApp();
				} else if (navigator.device && navigator.device.exitApp) {
					navigator.device.exitApp();
				}
				
			//});
			
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





//플래시라이트 온
function flashlight_on(){
	
	cordova.exec(function(result){}, function(err){}, "CallNative", "camefa_flash_on", [null]);
}

//세로보기
function set_portrait(){

	cordova.exec(function(result){}, function(err){}, "CallNative", "set_portrait", [null]);	
}
//가로보기
function set_landscape(){
	cordova.exec(function(result){}, function(err){}, "CallNative", "set_landscape", [null]);	
}


//설정창 열기
function showSettingView(){
	
	cordova.exec(function(result){}, function(err){}, "CallNative", "settingView", [null]);
}


//뱃지아이콘 변경
function setIconBadge(cnt){
	
	cordova.exec(function(result){}, function(err){}, "CallNative", "set_icon_badge", [cnt]);
}

//뱃지아이콘 차감
function setIconBadgeMinus(){
	
	cordova.exec(function(result){}, function(err){}, "CallNative", "set_icon_badge_minus", [null]);
}

//뱃지아이콘 증감
function setIconBadgePlus(){
	
	cordova.exec(function(result){}, function(err){}, "CallNative", "set_icon_badge_plus", [null]);
}




//카메라 콜백
var cameraCallback = {
		imageClass:"",
		filePath:"",
		success:function(imageData){
			
			 $(" ."+cameraCallback.imageClass).attr("src", "data:image/jpeg;base64," + imageData);
			 if(cameraCallback.filePath != "") {
				 save_image(imageData, cameraCallback.filePath, cameraCallback.fileName, cameraCallback.callback);				 
			 }
		},
		error:function(message){
			if(message != 'Camera cancelled.' && message != 'Selection cancelled.') {
				alert_app(message);
			}
		},
		callback:null,
		init:function(){
			cameraCallback.imageClass = "";
			cameraCallback.callback = null;
			cameraCallback.filePath = "";
			cameraCallback.fileName = "";
		}
}

//카메라사진찍기
function get_camera_picture(sType, imageClass, filePath, fileName, callback){
	
	cameraCallback.init();
	
	var sourceType = 0;
	if(sType == "album")
		sourceType = Camera.PictureSourceType.SAVEDPHOTOALBUM;
	else
		sourceType = Camera.PictureSourceType.CAMERA;
	
	//퀄리티
	quality = 50;
	
	cameraCallback.imageClass = imageClass;
	cameraCallback.filePath = filePath;
	cameraCallback.fileName = fileName;
	cameraCallback.callback = callback;
	
	navigator.camera.getPicture(cameraCallback.success, cameraCallback.error, {
		quality:quality,
		destinationType:Camera.DestinationType.DATA_URL,
		sourceType:sourceType
	});
	
}


//인앱브라우져
var in_app_browser_loading = false;
var in_app_browser_ref = null;
function in_app_browser(url, option, exitCallback){
	
	if(option === undefined || option == null || option == "" ) 
		option = "zoom=yes,location=yes";
	
	
	if(flatform.iphone){
		if(option != "") option += ",";
		option += "toolbar=yes, enableViewportScale=yes, closebuttoncaption=Close";
	}
	
	
	if(!in_app_browser_loading) {
		
		
		in_app_browser_loading = true;
		in_app_browser_ref  = cordova.InAppBrowser.open(url, "_blank", option);
		

		in_app_browser_ref.addEventListener("exit", function(){ if(typeof(exitCallback) == "function") exitCallback(); });
		in_app_browser_ref.addEventListener("loadstart", function(event){
			
			if (event.url.match("story.kakao.com")){
				
				in_app_browser_ref.close();
				location.href = event.url;
			
			} else if(event.url.match("inappbrowser/close")){
				
				in_app_browser_ref.close();
				
			} else if(event.url.match("inappbrowser/coord")){
				
				in_app_browser_ref.close();
				
				var data = event.url.split("/");
				var lat = data[data.length-1];
				var latField = data[data.length-2];
				var lng = data[data.length-3];
				var lngField = data[data.length-4];
				
				$("#"+latField).val(lat);
				$("#"+lngField).val(lng);
				
			} else if(event.url.match("inappbrowser/postcode")){
				
				in_app_browser_ref.close();
				
				var data = event.url.split("/");
				var addr2Field = data[data.length-1];
				var addr1 = decodeURIComponent(data[data.length-2]);
				var addr1Field = data[data.length-3];
				var zip = data[data.length-4];
				var zipField = data[data.length-5];
				var formName = data[data.length-6];
				
				var f = document[formName];
				f[zipField].value = zip;
				f[addr1Field].value = addr1;
				if(addr2Field) f[addr2Field].focus();
				
				
			} 
			
		});
		in_app_browser_ref.addEventListener("loadstop", function(event){
			
			
			if(event.url.match(/^intent:\/\//)){
				//in_app_browser_ref.close();
				//window.open(event.url);
				location.href=event.url;
				in_app_browser_ref.executeScript({
					code:"history.go(-1)"
				}, null);
				
			}
			
		});

	}
	
	setTimeout(function(){
		in_app_browser_loading = false;
	}, 1000);
	
}




//파일 다운로드
function onFileDownloadError(e) {
    alert_app("Error : Downloading Failed");
};

function onFileSystemSuccess(fileSystem) {

	showProgress("파일을 다운로드 중입니다...");

    var entry = "";
    if (device.platform.toLowerCase() == "android") {
        entry = fileSystem;
    } else {
        entry = fileSystem.root;
    }
    entry.getDirectory("Download", {
        create: true,
        exclusive: false
    }, onGetDirectorySuccess, onGetDirectoryFail);
};

function onGetDirectorySuccess(dir) {
	
    cdr = dir;
    dir.getFile(download_file_name, {
        create: true,
        exclusive: false
    }, gotFileEntry, onFileDownloadError);
};

function onGetDirectoryFail(e){
	alert(e);
}

function gotFileEntry(fileEntry) {
	var fileTransfer = new FileTransfer();

    // URL in which the pdf is available
    var documentUrl = download_file_link;
	var uri = encodeURI(documentUrl);
	
    fileTransfer.download(uri, cdr.nativeURL + download_file_name,
        function(entry) {
			
			closeProgress();
            confirm_app("다운로드가 완료되었습니다. 파일을 열어보시겠습니까?", function(){
				file_opener(cdr.nativeURL + download_file_name, download_file_mime_type);
			});
			
        },
        function(error) {
            navigator.notification.alert("Download Fail : " + error.code);
			closeProgress();
        },
        false
    );
};


function file_opener(filePath, mimetype){
	
	var fileMIMEType = mimetype;

	cordova.plugins.fileOpener2.open(
		filePath, 
		fileMIMEType, 
		{
			error : function(e) { 
				if(e.status == 9) {
					alert_app("열어볼 수 없는 형식의 파일입니다, 해당 파일의 뷰어 어플리케이션을 설치해주세요.");
				} else {
					alert_app('Error status: ' + e.status + '\n파일을 열 수 없습니다.');
				}
			},
			success : function(){} 
		} 
	);
}

var download_file_link = "";
var download_file_name = "";
var download_file_mime_type = "";
function cdv_file_download(url, filename, mime_type){

	download_file_mime_type = mime_type;
	download_file_name = filename;
	download_file_link = url;
	
	if (device.platform.toLowerCase() == "android") {
		window.resolveLocalFileSystemURL(cordova.file.externalRootDirectory, onFileSystemSuccess, onFileDownloadError);		
	} else {
		// for iOS
		window.requestFileSystem(LocalFileSystem.PERSISTENT, 0, onFileSystemSuccess, onFileDownloadError);
	}

}



