

function logout(){
	
	var gcmid = window.localStorage.getItem('gcmId');
	
	confirm_app("로그아웃 하시겠습니까?", function(){
		location.href=g4_app_path + "/login/logout_app.php?gcmid=" + gcmid;
	});
}


function link_history(param, transition)
{
		this.param = param;
		this.transition = transition;
}
var hist = 0;
function backlink(){
	
	
	if(hist <= 1) {
			//showProgress("잠시만 기다려주세요");
			hist=1;
			//location.href=g4_app_path + "/pages.php?p=1_1_1_1";
			go_link_page("p=1_1_1_1");
			return;
	}
	
	
	hist = hist - 1;
	var param = history_list[hist].param;
	var transition = history_list[hist].transition;

	go_link_page(param,transition, true);
}
var history_list = new Array();



function menulink(link_go) {

	
	switch ( link_go ) {

		//게시판알리미
		case 'menu01-1' : //게시판알리미
			go_link_page("p=1_1_1_1");
			break;

		//실시간채팅
		case 'menu02-1' : //실시간채팅
			go_link_page("p=2_1_1_1");
			break;

		//스케줄관리
		case 'menu03-1' : //프로필설정
			go_link_page("p=3_1_1_1");
			break;
			
	}
}


function go_link_page(param, transition, is_back){
	
	var isReverse = false;
	
	if(transition == null || transition === "undefined"){
		transition = "none";
	}
	if(is_back == "clear"){
		history_list = new Array();
		hist = 0;
	}
	if(is_back == null || is_back === "undefined"){
		
		//HISTORY
		hist++;
		history_list[hist] = new link_history(param, transition, true);
		
		if(typeof(history_list[hist-1]) !== "undefined"){
			history_list[hist-1].transition = transition;
		}
		
	} else{
		isReverse = true;
	}
	

	$.mobile.changePage("./pages.php?d=" + new Date().getTime(),
	{
			transition:transition,
			reloadPage:true,
			reverse:isReverse,
			type:"get",
			data:param
	});


}

