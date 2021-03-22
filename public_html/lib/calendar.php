<?if (!defined('_GNUBOARD_')) exit;?>

<script style='text/javascript'>

var dc__data = "";
var da__datas = new Array();

//Datepicker 생성
function dc_datepikcer(data){

	dual_calendar(data);
}
//달력 로드
function dual_calendar(data){
	
	var uid = "dc__"+(Math.floor(Math.random() * 999999) + 1); // 켈린더 고유 ID 생성
	data.uid = uid;	
	dc__data = data;
	da__datas[uid] = dc__data;
	da__datas[uid]["isfirst"] = true;

	if(data.period_limit == null || data.period_limit === undefined)
		data.period_limit = 10;

    if(data.is_single === undefined) data.is_single = false;

	$("#" + data.id).addClass("dc__calendar");
	
	var sday = $("#"+ dc__data.sdate_id).val();
	if(sday != "" && sday !== undefined)
		sday = sday.split(data.date_sep).join("");

	var eday = $("#"+ dc__data.edate_id).val();
	if(eday != "" && eday !== undefined)
		eday = eday.split(data.date_sep).join("");

	var year ="";
	var month = "";

	//선택불가 요일
	if(data.none_week == null || data.none_week === undefined) {
		data.none_week = new Array();
	}
	
	//숙박선택모드
	if(data.use_accom_mode == null || data.use_accom_mode === undefined) {
		data.use_accom_mode = false;
	}

	if(data.none_week_allow_period == null || data.none_week_allow_period === undefined){
		data.none_week_allow_period = false;
	}

	//숙박모드(use_accom_mode)가 true일경우 강제 dual가 됨
	if(data.use_accom_mode) {
		data.mode = "dual";
	}
	
	//선택불가 일자
	data.none_dates = new Array();

	//선택불가 요일 일자
	data.none_yoil = new Array();


	//최대 선택가능기간 계산을 가능한 날자만 체크해서 계산
	if(data.period_limit_check_able == null || data.period_limit_check_able === undefined) {
		data.period_limit_check_able = false;
	}
	


	// mindate 추가
	var mindate = dc__data.mindate;
	var min = "";
	if(mindate != "" && mindate !== undefined)  {
		min = mindate.split(data.date_sep).join("");
		if(sday < min) {
			$("#"+ dc__data.sdate_id).val("");
			$("#"+ dc__data.edate_id).val("");
			sday="";
		}
	}

	//maxdate
	var maxdate = dc__data.maxdate;
	var max="";
	if(maxdate != "" && maxdate !== undefined)  {
		max = maxdate.split(data.date_sep).join("");
		if(eday > max) {
			$("#"+ dc__data.sdate_id).val("");
			$("#"+ dc__data.edate_id).val("");
			eday="";
			sday="";
		}
	}


	if(sday != "" && sday !== undefined && sday.length == 8){
		year = sday.substring(0,4);
		month = sday.substring(4,6);
	} else {
		if(min != "" && min !== undefined && min.length == 8){
			year = min.substring(0,4);
			month = min.substring(4,6);
		}
	}

	



	dc__load_calendar(year, month, uid, true, min, max);
	
}

//기간이 선택되있는 상태로 달력 넘기기
function dc__select_period(data, isFirst){
	var uid = data.uid;

	if(data.mode == "dual"){
		var init_s_day = $("#"+ data.sdate_id).val();
		var init_e_day = $("#" + data.edate_id).val()
		if(init_s_day != "" && init_s_day !== undefined)
			init_s_day = init_s_day.split(data.date_sep).join("");
		if(init_e_day != "" && init_e_day !== undefined)
			init_e_day = init_e_day.split(data.date_sep).join("");
		if(init_s_day != "" && init_e_day == "") {
			$("."+uid).find('#'+uid+init_s_day).addClass("td-select-start");
		}
		if(init_s_day != "" && init_e_day != ""){
			if(isFirst == true) {
				$("#" + uid + init_s_day).click();
				setTimeout(function() { $("#" + uid + init_e_day).click(); }, 50);
			} else {
				dc__set_date_period_style(data, uid, init_s_day, init_e_day);
			}
		}
	} else {
		var init_s_day = $("#"+ data.sdate_id).val();
		if(init_s_day != "" && init_s_day !== undefined)
			init_s_day = init_s_day.split(data.date_sep).join("");
		if(init_s_day != ""){
				//$("#" + uid + init_s_day).click();
		}
	}
}

function dc__set_date_period_style(data, uid, sdateValue, edateValue){
	var pre_date = new Date(sdateValue.substr(0,4), parseInt(sdateValue.substr(4,2))-1, parseInt(sdateValue.substr(6,4))); 
	var next_date = new Date(edateValue.substr(0,4), parseInt(edateValue.substr(4,2))-1, parseInt(edateValue.substr(6,4))); 
	var beDay = (next_date.getTime() - pre_date.getTime())/1000/60/60/24;

	
    var sdate = pre_date.getFullYear()+""+dc__addZero(parseInt(pre_date.getMonth()+1))+""+dc__addZero(pre_date.getDate());
    $("."+uid).find('#'+uid+sdate).addClass("td-select-start");

	for(var t=1; t<=beDay;t++){
		var tmp_date = new Date(pre_date.getFullYear(), pre_date.getMonth(), pre_date.getDate()+t);
		var date_str = tmp_date.getFullYear()+""+dc__addZero(parseInt(tmp_date.getMonth()+1))+""+dc__addZero(tmp_date.getDate());
		$("."+uid).find('#'+uid+date_str).addClass("td-select on");
	}

    var edate = next_date.getFullYear()+""+dc__addZero(parseInt(next_date.getMonth()+1))+""+dc__addZero(next_date.getDate());
    $("."+uid).find('#'+uid+edate).addClass("td-select-end");

}


function dc__load_calendar(year, month, uid, isFirst, min, max){

	var data = da__datas[uid];
	
	var sday = $("#"+ data.sdate_id).val();
	sday = sday.split(data.date_sep).join("");
	
	var cpt = "true";
	if(data.caption == false)
		cpt = "false";
	var islimit = "true";
	if(data.limit == false){
		islimit= "false";
	}

    var calendar_sub_url = "calendar.sub.php";
    if(data.is_single) calendar_sub_url = "calendar.sub2.php";


	$(" #" + data.id).load("/lib/"+calendar_sub_url+"?uid="+uid+"&year="+year+"&month="+month+"&sday="+sday+"&caption="+cpt+"&islimit="+islimit+"&min="+min+"&max="+max, null, function(){

		//로드 이벤트
		if(typeof(data.onLoad) == "function"){
			if(year == ""){
				var d = new Date();
				year = d.getFullYear();
				month = d.getMonth()+1;
			}
			data.onLoad(year, month, uid);
		}

		//요일 불가 선택
		if(typeof(data.none_week) != "undefined" && data.none_week.length > 0) {
			data.none_yoil = [];
			var lastDay = ( new Date( year, month-1, 0) ).getDate();
			for(var dd = 1 ; dd <= lastDay ; dd++){
				var tmp_date = new Date(year, month-1, dd);		
				var date_str = tmp_date.getFullYear()+""+dc__addZero(parseInt(tmp_date.getMonth()+1))+""+dc__addZero(tmp_date.getDate());
				if(data.none_week.indexOf(tmp_date.getDay()) !== -1) {
					data.none_yoil.push(date_str);
				}
			}
			if(!data.is_single)  {
				var lastDay = ( new Date( year, month, 0) ).getDate();
				for(var dd = 1 ; dd <= lastDay ; dd++){
					var tmp_date = new Date(year, month, dd);		
					var date_str = tmp_date.getFullYear()+""+dc__addZero(parseInt(tmp_date.getMonth()+1))+""+dc__addZero(tmp_date.getDate());
					if(data.none_week.indexOf(tmp_date.getDay()) !== -1) {
						data.none_yoil.push(date_str);
					}
				}
			}
			dc__select_disable(data.none_yoil, uid, false, true, true);
		}
		
		data["isfirst"] = false;

		dc__select_period(data, isFirst);

	});


}

function dc__inputDate(date, uid){
	
	
	var dataObj = da__datas[uid];
	var dateStr = dc__set_date_format(date, dataObj.date_sep); 

	if(dataObj.mode == "single") {
	
		//불가 일자 선택시 걍 리턴
		if($('#'+uid+date).hasClass("td-none")){
			if(typeof(dataObj.none_alert) == "function"){
				dataObj.none_alert();
			}
			return;
		}
		
		$("#"+ dataObj.sdate_id).val(dateStr);		
		
		$("."+uid).find("td.td-select").removeClass("td-select on");
		$("."+uid).find('#'+uid+date).addClass("td-select on");
		
		if(!dataObj["isfirst"]) {
			if(typeof(dataObj.single_callback) == "function"){
				dataObj.single_callback(dateStr);
			}
		}

		return;
	}
	


	var sdate = document.getElementById(dataObj.sdate_id);
	var edate = document.getElementById(dataObj.edate_id);

	//전부 초기화
	if(date == "clear"){
		sdate.value = "";
		edate.value = "";
		$("."+uid).find("td.td-select").removeClass("td-select-start");
		$("."+uid).find("td.td-select").removeClass("td-select-end");
		$("."+uid).find("td.td-select").removeClass("td-select on");
		$("."+uid).find("td.td-accom-inout").removeClass("td-accom-inout");
		dc__valueChange("s", sdate.value, uid); 
		dc__valueChange("e", edate.value, uid);
		return;
	}

	
	if(sdate.value == "" || (sdate.value && edate.value)){
		
		//불가 일자 선택시 걍 리턴
		if($('#'+uid+date).hasClass("td-none")){
			
			if(typeof(dataObj.none_alert) == "function"){
				dataObj.none_alert();
			}

			return;
		}

		sdate.value = dateStr;
		edate.value = "";	
		dc__valueChange("s", sdate.value, uid); 
		dc__valueChange("e", edate.value, uid);
        $("."+uid).find("td.td-select").removeClass("td-select-start");
        $("."+uid).find("td.td-select").removeClass("td-select-end");
		$("."+uid).find("td.td-select").removeClass("td-select on");
		$("."+uid).find("td.td-accom-inout").removeClass("td-accom-inout");

		if(dataObj.use_accom_mode && sdate.value != "") {
			//선택한 시작일과 가장 가까운 불가일자를 가능으로 변경(숙박업체 특성)(use_accom_mode:true시 작동)
			if(dataObj.none_dates !== undefined) {
				var nds = Object.keys(dataObj.none_dates);
				nds = nds.concat(dataObj.none_yoil);
				nds.sort();
				
				for(var nidx = 0 ; nidx < nds.length; nidx++){
					if(date < nds[nidx]){
						if(!$("#"+uid+nds[nidx]).hasClass("td-none-yoil")) {
							//선택된 날자의 바로 다음 불가능일자 = 숙박에서는 입실/퇴실 간격으로 예약가능
							$("#"+uid+nds[nidx]).addClass("td-accom-inout"); 
						} else {
							if($("#"+uid+nds[nidx]).hasClass("td-none-yoil-none")) {
								break;
							}
							else if(dataObj.none_week_allow_period) {
								continue;
							}
						}
						break;
					}
				}
			}
		}
		

	}else{
		edate.value = dateStr;
		dc__valueChange("e", edate.value, uid);
	}
	

	var sdateValue = sdate.value.split(dataObj.date_sep).join("");
	var edateValue = edate.value.split(dataObj.date_sep).join("");

	
	if(sdate.value && edate.value){
		

		var pre_date = new Date(parseInt(sdateValue.substr(0,4),10), parseInt(sdateValue.substr(4,2),10)-1, parseInt(sdateValue.substr(6,4),10)); 
		var next_date = new Date(parseInt(edateValue.substr(0,4),10), parseInt(edateValue.substr(4,2),10)-1, parseInt(edateValue.substr(6,4),10)); 
		var beDay = (next_date.getTime() - pre_date.getTime())/1000/60/60/24;
		
		var ff = (beDay <= 0);
		if(dataObj.dup_date){ ff = (beDay < 0);}
		if(ff){
			sdate.value = "";
			edate.value = "";
            $("."+uid).find("td.td-select").removeClass("td-select-start");
            $("."+uid).find("td.td-select").removeClass("td-select-end");
			$("."+uid).find("td.td-select").removeClass("td-select on");
			$("."+uid).find("td.td-accom-inout").removeClass("td-accom-inout");
			dc__valueChange("s", sdate.value, uid); 
			dc__valueChange("e", edate.value, uid);
			return false;	
		}



		//선택기간 일자 한계 체크
		var limit_over = false;
		if(dataObj.period_limit_check_able) {
			var useDay = 0;
			//실제사용가능일 기준으로 기간일자 초과계산
			for(var t=1; t<=beDay;t++){
				var tmp_date = new Date(pre_date.getFullYear(), pre_date.getMonth(), pre_date.getDate()+t);
				var date_str = tmp_date.getFullYear()+""+dc__addZero(parseInt(tmp_date.getMonth()+1))+""+dc__addZero(tmp_date.getDate());
				if($.inArray(date_str, dataObj.none_yoil) < 0 && dataObj.none_dates[date_str] != "1") {
					useDay++;
				}
			}
			if(useDay > dataObj.period_limit){
				limit_over = true;
			}
		} else if(beDay > dataObj.period_limit){
			limit_over = true;
		}



		if(limit_over) {
			if(typeof(dataObj.limit_over) == "function"){
				dataObj.limit_over(dataObj.period_limit);
			}
			//선택 날짜가 기준일 초과이면 (edate만) 초기화 
			//sdate.value = "";
			edate.value = "";
			//$("."+uid).find("td.td-select").removeClass("td-select on");
			//dc__valueChange("s", sdate.value, uid); 
			dc__valueChange("e", edate.value, uid);
			return false;
			
		} 


		
		//중간에 불가능 기간이 끼어있는지 체크
		for(var t=1; t<=beDay;t++){
			
			var tmp_date = new Date(pre_date.getFullYear(), pre_date.getMonth(), pre_date.getDate()+t);
			var date_str = tmp_date.getFullYear()+""+dc__addZero(parseInt(tmp_date.getMonth()+1))+""+dc__addZero(tmp_date.getDate());
			
		
			if(dataObj.none_dates[date_str] == "1" || $.inArray(date_str, dataObj.none_yoil) >= 0) { //|| $("#"+uid+date_str).hasClass("td-none-yoil") ) {
				
				
				if(t == beDay && dataObj.use_accom_mode) {	//숙박의 경우 마지막 날이 예약불가능한 날인 경우는 선택가능하도록
					if($.inArray(date_str, dataObj.none_yoil) < 0) { //마지막일자가 선택불가능 요일이면 선택 불가
						//마지막날자가 예약불가일 때 선택가능
						continue;
					}
				}

				if(t != beDay && dataObj.none_week_allow_period) { //중간에 불가능 요일이 포함된 기간을 선택 할 수 있다면
					if($.inArray(date_str, dataObj.none_yoil) >= 0) { 
						//불가능한요일이 예약불가일자면 선택불가
						if(dataObj.none_dates[date_str] != "1") {
							continue;
						}
					}
				}

				if(typeof(dataObj.none_alert) == "function"){
					dataObj.none_alert();
				} else {
					//alert("선택 불가능한 일자가 포함됩니다.");
				}
				//선택 날자 도중에 불가능 한 날자가 있으면 (edate만) 초기화
				//sdate.value = "";
				edate.value = "";
				//$("."+uid).find("td.td-select").removeClass("td-select on");
				//dc__valueChange("s", sdate.value, uid); 
				dc__valueChange("e", edate.value, uid);
				return false;

			}

		}

		for(var t=1; t<=beDay;t++){
			var tmp_date = new Date(pre_date.getFullYear(), pre_date.getMonth(), pre_date.getDate()+t);
			var date_str = tmp_date.getFullYear()+""+dc__addZero(parseInt(tmp_date.getMonth()+1))+""+dc__addZero(tmp_date.getDate());
			$("."+uid).find('#'+uid+date_str).addClass("td-select on");
            if(t == beDay) $("."+uid).find('#'+uid+date_str).addClass("td-select-end");
		}

		$("#"+ dataObj.night_id).val(beDay);
		dc__valueChange("n", beDay, uid);

        if(beDay == 0) {
            var tmp_date = new Date(pre_date.getFullYear(), pre_date.getMonth(), pre_date.getDate());
			var date_str = tmp_date.getFullYear()+""+dc__addZero(parseInt(tmp_date.getMonth()+1))+""+dc__addZero(tmp_date.getDate());
            $("."+uid).find('#'+uid+date_str).addClass("td-select-end");
		}
		

		$("."+uid).find("td.td-accom-inout").removeClass("td-accom-inout");

	}else if(sdate.value){
		
		if(!$('#'+uid+sdateValue).hasClass("td-none"))
			$('#'+uid+sdateValue).addClass("td-select on td-select-start");

	}

}


function dc__select_disable(dates, uid, is_init, is_yoil, is_onload){

	if(is_init === undefined) is_init = false;
	if(is_yoil === undefined) is_yoil = false;
	if(is_onload === undefined) is_onload = false;

	if(is_init){
		$("."+uid+" .td-none").not(".td-none-yoil").removeClass("td-none");
		$("."+uid+" .td-accom-inout").removeClass("td-accom-inout");
		$("."+uid+" .td-none-yoil-none").removeClass("td-none-yoil-none");
		da__datas[uid].none_dates = new Array();
	}

	var data = da__datas[uid];
	var sday = $("#"+ data.sdate_id).val();
	var eday = $("#"+ data.edate_id).val();
	sday = sday.split(data.date_sep).join("");
	eday = eday.split(data.date_sep).join("");

	//$("."+uid+" .td-none").removeClass("td-none");
	for(var i = 0 ; i < dates.length ; i++){
		if(dates[i] !== undefined && dates[i] != ""){

				var nodate = dates[i].split("-").join("");
				if(!$("#"+ uid + nodate).hasClass("td-off")){
					$("#"+ uid + nodate).addClass("td-none");
					if(is_yoil){
							$("#"+ uid + nodate).addClass("td-none-yoil");
					}
					if(!is_onload){
						if($("#"+uid+nodate).hasClass("td-none-yoil")) {
							$("#"+ uid + nodate).addClass("td-none-yoil-none");
						}
					}
				}

				var disable_period = false;
				if(nodate == sday) {
					//시작일이 불가일이면 초기화
					disable_period = true;
				}

				if(eday != "" && (nodate >= sday && nodate <= eday && nodate != eday)){
					//시작일과 종료일 사이가 불가일이면 (종료일 제외) 
					if(!data.none_week_allow_period || $.inArray(nodate, data.none_yoil) < 0)  {//요일 포함 기간설정시 해당요일이 불가능 요일이면 제외
						disable_period = true;
					}
				}

				if(disable_period) {
					$("#"+ data.sdate_id).val("");
					$("#"+ data.edate_id).val("");
					$("."+uid+ " .td-select").removeClass("td-select").removeClass("on");
				}
				
				if(!is_yoil)
					da__datas[uid].none_dates[nodate] = 1;
		}
	}

	$("."+uid+" .td-select-start").not(".on").removeClass("td-select-start");
	$("."+uid+" .td-select-end").not(".on").removeClass("td-select-end");


	if(da__datas[uid].use_accom_mode && $("#"+ data.sdate_id).val() != "" && $("#"+ data.edate_id).val() == "") {
			//선택한 시작일과 가장 가까운 불가일자를 가능으로 변경(숙박업체 특성)(use_accom_mode:true시 작동)
			var date = $("#"+ data.sdate_id).val();
			date = date.split(da__datas[uid].date_sep).join("");
			if(da__datas[uid].none_dates !== undefined) {
				var nds = Object.keys(da__datas[uid].none_dates);
				nds = nds.concat(da__datas[uid].none_yoil);
				nds.sort();
				for(var nidx = 0 ; nidx < nds.length; nidx++){
					if(date < nds[nidx]){
						if(!$("#"+uid+nds[nidx]).hasClass("td-none-yoil")) {
							//선택된 날자의 바로 다음 불가능일자 = 숙박에서는 입실/퇴실 간격으로 예약가능
							$("#"+uid+nds[nidx]).addClass("td-accom-inout"); 
						} else {
							if($("#"+uid+nds[nidx]).hasClass("td-none-yoil-none")) {
								break;
							}
							else if(data.none_week_allow_period) {
								continue;
							}
						}
						break;
					}
				}
			}
	}


}




function dc__set_date_format(date, sep){
	
	if(date=="") return "";

	if(sep === undefined || sep == "") sep = "";
	
	var year = date.substr(0,4);
	var month = date.substr(4,2);
	var day = date.substr(6,4);

	return year + sep + month + sep + day;
	
}

function dc__valueChange(type, value, uid){

	var dataObj = da__datas[uid];

	if(type == "s"){
		if(typeof(dataObj.sdate_change) == "function"){
			dataObj.sdate_change(value);
		}
	} else if(type == "e") {
		if(typeof(dataObj.edate_change) == "function"){
			dataObj.edate_change(value);
		}
	} else {
		if(typeof(dataObj.night_change) == "function"){
			dataObj.night_change(value);
		}
	}

}

function dc__addZero(num){
	if(parseInt(num) < 10){
		return "0"+num;
	}else
		return num;
}
</script>

