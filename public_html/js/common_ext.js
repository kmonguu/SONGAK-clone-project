function check_all(f)
{
    var chk = document.getElementsByName("chk[]");

    for (i=0; i<chk.length; i++)
        chk[i].checked = f.chkall.checked;
}

function btn_check(f, act)
{
    if (act == "update") // 선택수정
    { 
        f.action.value = list_update_php;
        str = "수정";
    } 
    else if (act == "delete") // 선택삭제
    { 
        f.action.value = list_delete_php;
        str = "삭제";
    } 
    else
        return;

    var chk = document.getElementsByName("chk[]");
    var bchk = false;

    for (i=0; i<chk.length; i++)
    {
        if (chk[i].checked)
            bchk = true;
    }

    if (!bchk) 
    {
        alert(str + "할 자료를 하나 이상 선택하세요.");
        return;
    }

    if (act == "delete")
    {
        if (!confirm("선택한 자료를 정말 삭제 하시겠습니까?"))
            return;
    }

    f.submit();
}


$.datepicker.regional['ko'] = {
		closeText: '닫기',
		prevText: '이전달',
		nextText: '다음달',
		currentText: '오늘',
		monthNames: ['1월(JAN)','2월(FEB)','3월(MAR)','4월(APR)','5월(MAY)','6월(JUN)',
		'7월(JUL)','8월(AUG)','9월(SEP)','10월(OCT)','11월(NOV)','12월(DEC)'],
		monthNamesShort: ['1월','2월','3월','4월','5월','6월',
		'7월','8월','9월','10월','11월','12월'],
		dayNames: ['일','월','화','수','목','금','토'],
		dayNamesShort: ['일','월','화','수','목','금','토'],
		dayNamesMin: ['일','월','화','수','목','금','토'],
		weekHeader: 'Wk',
		dateFormat: 'yy-mm-dd',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: true,
		yearSuffix: ''};

$.datepicker.setDefaults($.datepicker.regional['ko']);


var saved_layer_z_index=0;
var a_rbtn_clicked = false;


if ( typeof String.prototype.startsWith != 'function' ) {
  String.prototype.startsWith = function( str ) {
    return this.substring( 0, str.length ) === str;
  }
};
	
	


function loading(){
	$("body").addClass("loading");
}
function close_loading(){
	$("body").removeClass("loading");
}


//IE인지
function detectIE() {
    var ua = window.navigator.userAgent;
    var ie = ua.search(/(MSIE|Trident|Edge)/);
    return ie > -1;
}

var is_IE = false;

$(function(){

	//클래스에 이벤트 맥이기
	set_class_event();
	
	set_combo_widget();
	
	is_IE = detectIE();
	
});


function set_class_event(obj){
	
	var o = null;
	if(obj !== undefined)
		o = obj;
	else 
		o = $(document);
		
	//공용 캘린더
	o.find(".calendar").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: false,
		onSelect:function(dateText, inst){
			if(typeof(onCalendarSelect) == "function"){
				onCalendarSelect(this, dateText, inst);
			}
			if(typeof($(this).attr("onCalendarSelect")) == "string"){
				eval($(this).attr("onCalendarSelect"));
			}
		},
		onClose:function(dateText){
			focus_move_next(this, 10);
			if(typeof(onCalendarClose) == "function"){
				onCalendarClose(this, $(this).val(), null);
			}
			if(typeof($(this).attr("onCalendarClose")) == "string"){
				eval($(this).attr("onCalendarClose"));
			}
		}
	});

	o.find(".calendar").each(function(){
		var yearRange = $(this).data("year-range");
		if(yearRange !== undefined && yearRange != null && yearRange != "" ){
			$(this).datepicker("option", "yearRange", yearRange);
		}
		var sep = $(this).data("sep");
		if(sep !== undefined && sep != null && sep != "" ){
			$(this).datepicker("option", "dateFormat", "yy"+sep+"mm"+sep+"dd");
		}

	});
	o.find(".calendar").keyup(function(event){

		var sep = $(this).data("sep");
		if(sep === undefined || sep == "" || sep == null) {sep = "-";}

		var regEx = new RegExp("[^0-9|\\"+sep+"]", "g");
		var regEx2 = new RegExp("[\\"+sep+"]{2}", "g");

		var str = this.value;
		str = str.replace(regEx, '');
		str = str.replace(regEx2, sep);
		this.value = str;

		auto_date_format(event, this, sep);
		auto_next_focus(event, this, 10);
		$(this).data("textlength", this.value.length);

	});
	o.find(".calendar").keypress(function(event){		
		var sep = $(this).data("sep");
		if(sep === undefined || sep == "" || sep == null) {sep = "-";}
		auto_date_format(event, this, sep);
	});
	o.find(".calendar").blur(function(event) { 

		var sep = $(this).data("sep");
		if(sep === undefined || sep == "" || sep == null) {sep = "-";}

		var regEx = new RegExp("[^0-9|\\"+sep+"]", "g");
		var regEx2 = new RegExp("[\\"+sep+"]{2}", "g");
		var str = this.value;
		str = str.replace(regEx, '');
		str = str.replace(regEx2, sep);
		this.value = str;

		if(!validateDate(str, "yy"+sep+"mm"+sep+"dd")) {
			//info_message("입력하신 날자가 잘못되었습니다. '"+this.value+"'");
			this.value = "";
			$(this).focus();
		} else {
			var tmp = str.split(sep);
			if(tmp.length == 3) {
				if(tmp[1].length == 1) {tmp[1] = "0" + tmp[1];}
				if(tmp[2].length == 1) {tmp[2] = "0" + tmp[2];}
				this.value = tmp[0] + sep + tmp[1] + sep +tmp[2];
			}
		}

	});
	o.find(".calendar").attr("autocomplete", "off");
	//공용 캘린더 끝
	



	//날짜형식 입력받기
	o.find(".dateformat").keyup(function(event){

		var sep = $(this).data("sep");
		if(sep === undefined || sep == "" || sep == null) {sep = "-";}

		var regEx = new RegExp("[^0-9|\\"+sep+"]", "g");
		var regEx2 = new RegExp("[\\"+sep+"]{2}", "g");
		var str = this.value;
		str = str.replace(regEx, '');
		str = str.replace(regEx2, sep);
		this.value = str;

		auto_date_format(event, this, sep);
		auto_next_focus(event, this, 10);
		$(this).data("textlength", this.value.length);

	});
	o.find(".dateformat").blur(function(event) { 

		var sep = $(this).data("sep");
		if(sep === undefined || sep == "" || sep == null) {sep = "-";}

		var regEx = new RegExp("[^0-9|\\"+sep+"]", "g");
		var regEx2 = new RegExp("[\\"+sep+"]{2}", "g");
		var str = this.value;
		str = str.replace(regEx, '');
		str = str.replace(regEx2, sep);
		this.value = str;

		if(!validateDate(str, "yy"+sep+"mm"+sep+"dd")) {
			//info_message("입력하신 날자가 잘못되었습니다. '"+this.value+"'");
			this.value = "";
			$(this).focus();
		} else {
			var tmp = str.split(sep);
			if(tmp.length == 3) {
				if(tmp[1].length == 1) {tmp[1] = "0" + tmp[1];}
				if(tmp[2].length == 1) {tmp[2] = "0" + tmp[2];}
				this.value = tmp[0] + sep + tmp[1] + sep +tmp[2];
			}
		}
	});
	o.find(".dateformat").keypress(function(event){
		var sep = $(this).data("sep");
		if(sep === undefined || sep == "" || sep == null) {sep = "-";}
		auto_date_format(event, this, sep);
	});
	o.find(".dateformat").attr("autocomplete", "off");
	//날짜형식 입력받기 끝



	

	//시간형식 입력받기
	o.find(".timeformat").keyup(function(event){
		var str = this.value;
		str = str.replace(/[^0-9|:]/g, '');
		this.value = str;
		auto_time_format(event, this);
		auto_next_focus(event, this, 5);
		$(this).data("textlength", this.value.length);
	});
	
	o.find(".timeformat").keypress(function(event){
		auto_time_format(event, this);
	});

	o.find(".timeformat").blur(function(event){
		var str = this.value;
		str = str.replace(/[^0-9|:]/g, '');
		this.value = str;
		if(str.split(":").length != 2) {
			this.value = "";
			$(this).focus();
		}
	});
	
	o.find(".calendar, .timeformat").focus(function(){
		$(this).select();
	});
	//시간형식 입력받기 끝




	
	//드래그가능한 DIV
	o.find( ".draggable").each(function(){
		var _self = $(this);
		saved_layer_z_index = $(this).css("z-index");
		$(this).draggable({
			
			handle: ".drag_handle",
			containment:".wrap-content",
			start:function(){
				open_layer_zindex++;
				_self.css({"opacity":"0.7", "z-index":open_layer_zindex});
			},
			stop:function(){
				
				//_self.css({"opacity":"1", "z-index":saved_layer_z_index});
				_self.css({"opacity":"1"});
			}
		});		
	});
	o.find(".draggable").css({"box-shadow":"6px 6px 5px rgba(136, 136, 136, 0.5)"});
	

	
	//탭
	if(typeof(slt_tab_no) != "undefined"){
		
		o.find( ".tabs" ).tabs({
			active:slt_tab_no,
			activate: function(event, ui){
				if(o.find(".selected_tab_idx").size() > 0) o.find(".selected_tab_idx").val($(this).find("> ul> li").index(ui.newTab));
				if(typeof(onTabActivate) == "function") {
					onTabActivate(event, ui);
				}
				if(typeof(onTabChange) == "function") {
					onTabChange($(this).find("> ul> li").index(ui.newTab));
				}
			}
		});
	}
	
	

	//버튼
	o.find(".Btn1, .Btn2, .Btn3, .Btn4").css("cursor", "pointer");
	o.find(".Btn1, .Btn2, .Btn3, .Btn4").find("a").click(function(){
		a_rbtn_clicked = true;
	})
	o.find(".Btn1, .Btn2, .Btn3, .Btn4").click(function(){ 
		
			var anchor = $(this).find("a");
			var oce = anchor.attr("onclick");
			
			if(oce != "" && !a_rbtn_clicked) {
				
					eval(oce);//onclick 이벤트 실행
				
			}
			
			var loc = anchor.attr("href");
			var tag = anchor.attr("target");
			
			if(typeof(loc) != "undefined") {
				
				if(!loc.startsWith("javascript:void(0)") && !loc.startsWith("#")){
					if(tag == "_blank")
						window.open(loc);
					else if(tag == "_parent"){
						parent.location.href = loc;
					}
					else if(tag == "_top"){
						top.location.href = loc;
					}
					else
						location.href = loc;
				}
	
				a_rbtn_clicked = false;
				
				return false;
				
			} else {
				return true;
			} 
	});

	//숫자만 입력가능
	o.find(".onlynumber").keypress(function(){ onlyNumber(); });
	o.find(".onlynumber").keyup(function(){ 
		var str = this.value;
		str = str.replace(/[^0-9|\-]/g, '');
		this.value = str;
	});
	o.find(".onlynumber").blur(function(){ 
		var str = this.value;
		str = str.replace(/[^0-9|\-]/g, '');
		this.value = str;
		//onlyNumber2(this); 
	});
	

	//통화형식 자동변환
	o.find(".currency").keyup(function(){ setNumberFormat(this); });
	o.find(".currency").keypress(function(){ onlyNumber(); });
	//o.find(".onlynumber, .currency").css({"text-align":"right", "padding-right":"3px"});
	o.find(".onlynumber, .currency").focus(function(){
		$(this).select();
	});
	
	
	//전화번호 자동 하이픈
	o.find(".phonenum").keyup(function(){
		$(this).val(autoHypenPhone($(this).val()));
	});
	o.find(".phonenum").blur(function(){
		$(this).val(autoHypenPhone($(this).val()));
	});
	
	
	//엔터키 서브밋
	o.find(".enter_submit").keydown(function(event){
		if(event.keyCode == 13) {
			var f = $(this).closest("form");
			f.submit();
		}
	});
	
	//폼 서브밋 시에 currency 형식 컴마 제거
	o.find("form").on("submit", function(){
		replace_currency();
	});
	
	
	//정렬가능 li 설정
	o.find(".sortable" ).sortable({
		placeholder: "ui-state-highlight",
	    sort: function(ev, ui) {
	    	
	    	if(is_IE) {	    	
			    //익스는 이거 실행하도록...
		    	if(o.find(".sortable").hasClass("first_move")){	    		
		    		ui.helper.css({'top' : ui.position.top + $(window).scrollTop() + 'px'});
		    	}
	    	}
	    	
	    },
	    change: function(ev, ui){
	    	
	    	//익스일경우
	    	if(is_IE) { o.find(".sortable").addClass("first_move"); 	}
	    	
	    }
	});
	o.find(".sortable").disableSelection();


	//투명 셀렉트 박스
	o.find(".transparent_sltbox").each(function(){
		
		var _self = this;
		var linkID = $(this).data("link");
		
		$(_self).prop("tabindex", "-1");
		$("#"+linkID).prop("readonly",true);
		$("#"+linkID).focus(function(){});
		$("#"+linkID).keydown(function(event){ if(event.keyCode == 13) { $(_self).click().focus(); } });
		
		$("#"+linkID).val($(this).find("> option:selected").text().trim());
		$(this)[0].transparent_sltbox_refresh = function() {
			var linkID = $(this).data("link");
			$("#"+linkID).val($(this).find("> option:selected").text().trim());
		}
	});
	
	o.find(".transparent_sltbox").change(function(){
		var linkID = $(this).data("link");
		$("#"+linkID).val($(this).find("> option:selected").text().trim());
	});
	
	
	
	//투명 체크박스
	o.find(".transparent_chkbox").each(function(){
		
		var _self = this;
		var linkID = $(this).data("link");

		$(_self).prop("tabindex", "-1");
		$("#"+linkID).after("<a href='javascript:void(0);'  class='transparent_chkbox_focus_area'>&nbsp;</a>");
		$("#"+linkID).next("a").click(function(){
			$(_self).click();
		});


		var imgW = $("#"+linkID).width();
		var imgT = $("#"+linkID).css("top");
		$("#"+linkID).next("a").css({width:imgW+"px", height:imgW+"px", top:imgT});

		
		var onimg = $(this).data("onimg");
		var offimg = $(this).data("offimg");
		if(onimg == "" || onimg === undefined) { onimg = "/res/images/check_on.jpg"; }
		if(offimg == "" || offimg === undefined) { offimg = "/res/images/check.jpg"; }
		
		if($(this).is(":checked")){
			$("#"+linkID).attr("src", onimg);
		} else {
			$("#"+linkID).attr("src", offimg);
		}
		
		$(this)[0].transparent_chkbox_refresh = function() {
			var linkID = $(this).data("link");
			var onimg = $(this).data("onimg");
			var offimg = $(this).data("offimg");
			if(onimg == "" || onimg === undefined) { onimg = "/res/images/check_on.jpg"; }
			if(offimg == "" || offimg === undefined) { offimg = "/res/images/check.jpg"; }
			
			if($(this).is(":checked")){
				$("#"+linkID).attr("src", onimg);
			}else{
				$("#"+linkID).attr("src", offimg);
			}
		}
		
		//크롬 뒤로가기 시
		var _chkbox = $(this)[0];
		(function(obj){
			setTimeout(function(){
				obj.transparent_chkbox_refresh();				
			}, 300);
		})(_chkbox);
			

		
	});
	
	//투명 체크박스
	o.find(".transparent_chkbox").change(function(){
		
		var linkID = $(this).data("link");

		var onimg = $(this).data("onimg");
		var offimg = $(this).data("offimg");
		if(onimg == "" || onimg === undefined) { onimg = "/res/images/check_on.jpg"; }
		if(offimg == "" || offimg === undefined) { offimg = "/res/images/check.jpg"; }

		if($(this).is(":checked")){
			$("#"+linkID).attr("src", onimg);
		}else{
			$("#"+linkID).attr("src", offimg);
		}
	});
	
	
	//투명 라디오
	o.find(".transparent_radio").each(function(){
		
		var _self = this;
		var linkID = $(this).data("link");

		var onimg = $(this).data("onimg");
		var offimg = $(this).data("offimg");
		if(onimg == "" || onimg === undefined) { onimg = "/res/images/radio_on.jpg"; }
		if(offimg == "" || offimg === undefined) { offimg = "/res/images/radio.jpg"; }
		
		
		if($(this).is(":checked")){
			$("#"+linkID).attr("src", onimg);
		} else {
			$("#"+linkID).attr("src", offimg);
		}


		$(_self).prop("tabindex", "-1");
		$("#"+linkID).after("<a href='javascript:void(0);'  class='transparent_radio_focus_area'>&nbsp;</a>");
		$("#"+linkID).next("a").click(function(){
			$(_self).click();
		});

		var imgW = $("#"+linkID).width();
		var imgT = $("#"+linkID).css("top");
		$("#"+linkID).next("a").css({width:imgW+"px", height:imgW+"px", top:imgT});


		
		$(this)[0].transparent_radio_refresh = function() {
			
			$(".transparent_radio[name='"+$(this).attr("name")+"']").each(function(){
				var linkID = $(this).data("link");
				var onimg = $(this).data("onimg");
				var offimg = $(this).data("offimg");
				if(onimg == "" || onimg === undefined) { onimg = "/res/images/radio_on.jpg"; }
				if(offimg == "" || offimg === undefined) { offimg = "/res/images/radio.jpg"; }
				if($(this).is(":checked")){
					$("#"+linkID).attr("src", onimg);
				}else{
					$("#"+linkID).attr("src", offimg);
				}
			});
		}

		//크롬 뒤로가기 시
		var _radio = $(this)[0];
		(function(obj){
			setTimeout(function(){
				obj.transparent_radio_refresh();				
			}, 300);
		})(_radio);
		
	});
	
	//투명 라디오
	o.find(".transparent_radio").change(function(){
				
		$(".transparent_radio[name='"+$(this).attr("name")+"']").each(function(){
			var linkID = $(this).data("link");
			var onimg = $(this).data("onimg");
			var offimg = $(this).data("offimg");
			if(onimg == "" || onimg === undefined) { onimg = "/res/images/radio_on.jpg"; }
			if(offimg == "" || offimg === undefined) { offimg = "/res/images/radio.jpg"; }
			if($(this).is(":checked")){
				$("#"+linkID).attr("src", onimg);
			}else{
				$("#"+linkID).attr("src", offimg);
			}
		});

	});
	
	
	//투명 달력
	o.find(".transparent_date").each(function(){
		
		var _self = this;
		var linkID = $(this).data("link");
		$("#"+linkID).focus(function(){
			$(_self).focus();
		});
		
		
		$("#"+linkID).val($(this).val());
		$(this)[0].transparent_date_refresh = function() {
			var linkID = $(this).data("link");
			$("#"+linkID).val($(this).val());
		}
	});
	
	o.find(".transparent_date").change(function(){
		var linkID = $(this).data("link");
		$("#"+linkID).val($(this).val());
	});
	
}



function replace_currency(){
	$(".currency").each(function(){
		var v = $(this).val();
		$(this).val(v.split(",").join(""));
	});
}


//#########################################################################################################################
//날자 형식
Date.prototype.format = function(f) {
    if (!this.valueOf()) return " ";
 
    var weekName = ["일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일"];
    var d = this;
     
    return f.replace(/(yyyy|yy|MM|dd|E|hh|mm|ss|a\/p)/gi, function($1) {
        switch ($1) {
            case "yyyy": return d.getFullYear();
            case "yy": return (d.getFullYear() % 1000).zf(2);
            case "MM": return (d.getMonth() + 1).zf(2);
            case "dd": return d.getDate().zf(2);
            case "E": return weekName[d.getDay()];
            case "HH": return d.getHours().zf(2);
            case "hh": return ((h = d.getHours() % 12) ? h : 12).zf(2);
            case "mm": return d.getMinutes().zf(2);
            case "ss": return d.getSeconds().zf(2);
            case "a/p": return d.getHours() < 12 ? "오전" : "오후";
            default: return $1;
        }
    });
};
String.prototype.string = function(len){var s = '', i = 0; while (i++ < len) { s += this; } return s;};
String.prototype.zf = function(len){return "0".string(len - this.length) + this;};
Number.prototype.zf = function(len){return this.toString().zf(len);};
//#########################################################################################################################



var open_layer_zindex = 900;
function open_layer(cls, transition, interval, callback){
	open_layer_zindex++;
	$("."+cls).css("z-index", open_layer_zindex);
	
	if(transition !== undefined) {
		$("."+cls).velocity(transition, interval, callback);
	} else {
		$("."+cls).fadeIn("fast", callback);
	}
}
function close_layer(obj){
	
	if(typeof(obj) == "string"){
		$("."+obj).fadeOut("fast");
	} else {		
		$(obj).closest(".draggable").fadeOut("fast");
	}

	$(".layer_modal_overlay").hide();
}
function loding_layer(content_id){
	$("#"+content_id).prepend("<div style='position:absolute;width:100%;height:25px;font-size:15px;text-align:center;top:0px; left:0px;z-index:99;padding-top:5px;background-color:#1d1d1d;color:white;opacity:0.6;'>잠시만 기다려주세요...</div>");
}


function stopPropagation(e){
	
	var event = e || window.event; 
	
	//IE9 & Other Browsers
    if (event.stopPropagation) {
    	event.stopPropagation();
    }
    //IE8 and Lower
    else {
    	event.cancelBubble = true;
    }
}



//숫자만 입력받는다. "-"도 받는다.
function onlyNumber2(loc) {
if(/[^0123456789-]/g.test(loc.value)) {
alert("숫자가 아닙니다.\n\n0-9의 정수만 허용합니다.");
loc.value = "";
loc.focus();
}
}


//=======================================================
//금액 텍스트박스 관련
function setNumberFormat(obj){

	if((event.keyCode == 9 || event.keyCode == 65 || event.keyCode == 35 || event.keyCode == 36 || event.keyCode == 16 || event.keyCode == 17)) { return; }
	

	var bVal = $(obj).val();
	var strVal = $(obj).val().split(",").join("");
	if(strVal != "") {
			if(isNaN(strVal)){
				$(obj).val(0);
			} else {
				
				var cur_pos = doGetCaretPosition(obj);
				var v1 = bVal.substr(1, cur_pos);
				
				$(obj).val(Number(strVal).toLocaleString().split(".")[0]);
				
				var v2 = $(obj).val().substr(1, cur_pos);
				
				var w1 = v1.split(",").length;
				var w2 = v2.split(",").length;
				
				var x1 = w2-w1;
				var ncur_pos = cur_pos + x1;
				
				setCaretPosition(obj, ncur_pos);
			}
	}
}
function onlyNumber() {
	if((event.keyCode > 31) && (event.keyCode < 45) || (event.keyCode > 57)) {
	event.preventDefault ? event.preventDefault() : (event.returnValue = false);
	}
}
function doGetCaretPosition (ctrl) {
  var CaretPos = 0;
  // IE Support
  if (document.selection) {
      ctrl.focus ();
      var Sel = document.selection.createRange ();
      Sel.moveStart ('character', -ctrl.value.length);
      CaretPos = Sel.text.length;
  }
  // Firefox support
  else if (ctrl.selectionStart || ctrl.selectionStart == '0')
      CaretPos = ctrl.selectionStart;
  return (CaretPos);
}
function setCaretPosition(ctrl, pos)
{
  if(ctrl.setSelectionRange)
  {
      ctrl.focus();
      ctrl.setSelectionRange(pos,pos);
  }
  else if (ctrl.createTextRange) {
      var range = ctrl.createTextRange();
      range.collapse(true);
      range.moveEnd('character', pos);
      range.moveStart('character', pos);
      range.select();
  }
}
//금액 텍스트박스 관련 끝
//=======================================================


//날자입력시 자동 짝대기
function auto_date_format( e, oThis, sep ){
    
	if(sep === undefined || sep == "" || sep == null) sep = "-";

    var num_arr = [ 
        97, 98, 99, 100, 101, 102, 103, 104, 105, 96,
        48, 49, 50, 51, 52, 53, 54, 55, 56, 57
    ]
    
    var key_code = ( e.which ) ? e.which : e.keyCode;

    //if( num_arr.indexOf( Number( key_code ) ) != -1 ){
	var blen= 0;
	blen = parseInt($(oThis).data("textlength"));
	if(isNaN(blen)) blen = 0;
	if(oThis.value.length > blen) { //글자수가 늘었을때만 동작(삭제시 동작안함)
        var len = oThis.value.length;
        if( len == 4 ) oThis.value += sep;
        if( len == 7 ) oThis.value += sep;
		if( len == 5 && oThis.value.substring(4) != sep) { oThis.value = oThis.value.substring(0,4) + sep + oThis.value.substring(4); }
		if( len == 8 && oThis.value.substring(7) != sep) { oThis.value = oThis.value.substring(0,7) + sep + oThis.value.substring(7); }
	}
    //}

    if(len > 10){
    	oThis.value = oThis.value.substr(0,10);
    }
    
    if(key_code == 45 ) {
 	   e.preventDefault ? e.preventDefault() : (e.returnValue = false);
 	}
}

function auto_time_format(e, oThis){
	
	var num_arr = [ 
       97, 98, 99, 100, 101, 102, 103, 104, 105, 96,
       48, 49, 50, 51, 52, 53, 54, 55, 56, 57
   ]
   
   var key_code = ( e.which ) ? e.which : e.keyCode;
   
   //if( num_arr.indexOf( Number( key_code ) ) != -1 ){
	var blen= 0;
	blen = parseInt($(oThis).data("textlength"));
	if(isNaN(blen)) blen = 0;
	if(oThis.value.length > blen) { //글자수가 늘었을때만 동작(삭제시 동작안함)	
       var len = oThis.value.length;
       if( len == 2 ) oThis.value += ":";
	   if( len == 3 && oThis.value.substring(2) != "-") { oThis.value = oThis.value.substring(0,2) + ":" + oThis.value.substring(2); }
	}
   //}    
  
   if(len > 5){
   		oThis.value = oThis.value.substr(0,5);
   }
   if(key_code == 58 ) {
	   e.preventDefault ? e.preventDefault() : (e.returnValue = false);
	}
   
   
}

function auto_next_focus(e, oThis, nextLength){
	
	var num_arr = [ 
	               97, 98, 99, 100, 101, 102, 103, 104, 105, 96,
	               48, 49, 50, 51, 52, 53, 54, 55, 56, 57
    ];
	
	var key_code = ( e.which ) ? e.which : e.keyCode;
	
	if( num_arr.indexOf( Number( key_code ) ) != -1 ){
		
		if(key_code != 8){
			focus_move_next(oThis, nextLength);
		}
		
	}

}


function focus_move_next(oThis, nextLength){
	
	var len = oThis.value.length;
	if(len == nextLength) {
	   	if(typeof($(oThis).data("next")) == "string"){
	   		var nextInputName = $(oThis).data("next");
	   		$("input[name='"+nextInputName+"']").first().focus();
	   		
	   		$(oThis).datepicker("hide");
	   	}
	}
}


function ifrResize(obj){
	
	var saveScrollTop = $(document).scrollTop();
	

	$(obj).height(0);
	var the_height=obj.contentWindow.document.body.scrollHeight;  
	$(obj).height(the_height);

	
	$(document).scrollTop(saveScrollTop);
}


function open_popup(url, width, height, name, scrollbars){
	if(name === undefined) name = "_blank";
	var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
	var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
	
	var w = width;
	var h = height;
	var left = ((screen.width / 2) - (w / 2)) + dualScreenLeft;
	var top = ((screen.height / 2) - (h / 2)) + dualScreenTop - 50;

	if(scrollbars === undefined) scrollbars = "yes";
	
	return window.open(url,name,'menubar=no, toolbar=no, directories=no, location=no,status=no,scrollbars='+scrollbars+', top='+top+', left='+left+', width='+w+', height='+h+'');
}

function open_popup_right(url, width, height, name){
	if(name === undefined) name = "_blank";
	var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
	var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
	
	var w = width;
	var h = height;
	var left = ((screen.width) - (w)) + dualScreenLeft - 100;
	var top = ((screen.height / 2) - (h / 2)) + dualScreenTop;


	return window.open(url,name,'menubar=no, toolbar=no, directories=no, location=no,status=no, scrollbars=yes, top='+top+', left='+left+', width='+w+', height='+h+'');
}


function flashWindow()
{
    try {
        if (window.external.msIsSiteMode()) {
            window.setTimeout("window.external.msSiteModeActivate()", 2000);
        }
    }
    catch (ex) {
        // Fail silently.
    }
}


function get_yoil(day) {
	
	var week = new Array("일", "월", "화", "수", "목", "금", "토");
	
	var today = new Date(day.split("-").join("/")).getDay();
	var result = week[today];
	
	return result;
}


function get_num(data){
	
	var result = data + "";
	
	result = parseInt(result.split(",").join(""));
	
	if(isNaN(result)) result = 0;
	
	return result;
}


//class의 입력 합계
function sum_class(class_name){
	var result = 0;
	$("."+class_name).each(function(){
		var vl = $(this).val();
		if(vl == "") vl = $(this).html();
		var v = get_num(vl);
		result+=v;
	});
	return result;
}



//전화번호 자동 하이픈
function autoHypenPhone(str){

	str = str.replace(/[^0-9]/g, '');
	
	first2 = str.substring(0, 2);
	
	var tmp = '';


	if(first2 == "02"){

		if(str.length < 3){
			return str;
		}else if(str.length < 6){
			tmp += str.substr(0, 2);
			tmp += '-';
			tmp += str.substr(2);
			return tmp;
		}else if(str.length < 10){
			tmp += str.substr(0, 2);
			tmp += '-';
			tmp += str.substr(2, 3);
			tmp += '-';
			tmp += str.substr(5);
			return tmp;
		}else if(str.length < 11){
			tmp += str.substr(0, 2);
			tmp += '-';
			tmp += str.substr(2, 4);
			tmp += '-';
			tmp += str.substr(6);
			return tmp;
		}else{				
			tmp += str.substr(0, 2);
			tmp += '-';
			tmp += str.substr(2, 4);
			tmp += '-';
			tmp += str.substr(6);
			return tmp;
		}


	} else {

		if( str.length < 4){
			return str;
		}else if(str.length < 7){
			tmp += str.substr(0, 3);
			tmp += '-';
			tmp += str.substr(3);
			return tmp;
		}else if(str.length < 11){
			tmp += str.substr(0, 3);
			tmp += '-';
			tmp += str.substr(3, 3);
			tmp += '-';
			tmp += str.substr(6);
			return tmp;
		}else if(str.length < 12){
			tmp += str.substr(0, 3);
			tmp += '-';
			tmp += str.substr(3, 4);
			tmp += '-';
			tmp += str.substr(7);
			return tmp;
		}else{				
			tmp += str.substr(0, 4);
			tmp += '-';
			tmp += str.substr(4, 4);
			tmp += '-';
			tmp += str.substr(8);
			return tmp;
		}

	}


	return str;
}



/*
 * ----------------------------------------------------------------------------
 * 특정 날짜에 대해 지정한 값만큼 가감(+-)한 날짜를 반환
 *
 *
 *
 * 입력 파라미터 ----- pInterval : "yyyy" 는 연도 가감, "m" 은 월 가감, "d" 는 일 가감 pAddVal : 가감
 * 하고자 하는 값 (정수형) pYyyymmdd : 가감의 기준이 되는 날짜 pDelimiter : pYyyymmdd 값에 사용된 구분자를
 * 설정 (없으면 "" 입력)
 *
 *
 *
 * 반환값 ----
 *
 * yyyymmdd 또는 함수 입력시 지정된 구분자를 가지는 yyyy?mm?dd 값
 *
 *
 * 사용예 ---
 *
 * 2008-01-01 에 3 일 더하기 ==> addDate("d", 3, "2008-08-01", "-");
 *
 * 20080301 에 8 개월 더하기 ==> addDate("m", 8, "20080301", "");
 * ---------------------------------------------------------------------------
 */
function addDate(pInterval, pAddVal, pYyyymmdd, pDelimiter) {
	var yyyy;
	var mm;
	var dd;
	var cDate;
	var oDate;
	var cYear, cMonth, cDay;

	if (pDelimiter != "") {
		pYyyymmdd = pYyyymmdd.replace(eval("/\\" + pDelimiter + "/g"), "");
	}

	yyyy = pYyyymmdd.substr(0, 4);
	mm = pYyyymmdd.substr(4, 2);
	dd = pYyyymmdd.substr(6, 2);

	if (pInterval == "yyyy") {
		yyyy = (yyyy * 1) + (pAddVal * 1);
	} else if (pInterval == "m") {
		mm = (mm * 1) + (pAddVal * 1);
	} else if (pInterval == "d") {
		dd = (dd * 1) + (pAddVal * 1);
	}

	cDate = new Date(yyyy, mm - 1, dd) // 12월, 31일을 초과하는 입력값에 대해 자동으로 계산된 날짜가
	// 만들어짐.
	cYear = cDate.getFullYear();
	cMonth = cDate.getMonth() + 1;
	cDay = cDate.getDate();

	cMonth = cMonth < 10 ? "0" + cMonth : cMonth;
	cDay = cDay < 10 ? "0" + cDay : cDay;

	if (pDelimiter != "") {
		return cYear + pDelimiter + cMonth + pDelimiter + cDay;
	} else {
		return ""+cYear + cMonth + cDay;
	}
}





function set_combo_widget(){

	$.widget( "custom.combobox", {
	    _create: function() {
	      this.wrapper = $( "<span>" )
	        .addClass( "custom-combobox" )
	        .insertAfter( this.element );

	      this.element.hide();
	      this._createAutocomplete();
	      this._createShowAllButton();
	    },

	    _createAutocomplete: function() {
	      var selected = this.element.children( ":selected" ),
	        value = selected.val() ? selected.text() : "";

	      this.input = $( "<input>" )
	        .appendTo( this.wrapper )
	        .val( value )
	        .attr( "title", "" )
	        .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
	        .css({
	        	width:$(this.element).data("width") != "" ? $(this.element).data("width") : "100px"
	        })
	        .autocomplete({
	          delay: 0,
	          minLength: 0,
	          source: $.proxy( this, "_source" ),
	          focus:function(event, ui){
	        	  event.preventDefault();
	          }
	        })
	        .tooltip({
	          classes: {
	            "ui-tooltip": "ui-state-highlight"
	          }
	        });

	      this._on( this.input, {
	        autocompleteselect: function( event, ui ) {
	          ui.item.option.selected = true;
	          this._trigger( "select", event, {
	            item: ui.item.option
	          });
	          $(this.element).change();
	        },

	        autocompletechange: "_removeIfInvalid"
	      });
	    },

	    _createShowAllButton: function() {
	      var input = this.input,
	        wasOpen = false;

	      $( "<a>" )
	        .attr( "tabIndex", -1 )
	        .attr( "title", "Show All Items" )
	        .tooltip()
	        .appendTo( this.wrapper )
	        .button({
	          icons: {
	            primary: "ui-icon-triangle-1-s"
	          },
	          text: false
	        })
	        .removeClass( "ui-corner-all" )
	        .addClass( "custom-combobox-toggle ui-corner-right" )
	        .on( "mousedown", function() {
	          wasOpen = input.autocomplete( "widget" ).is( ":visible" );
	        })
	        .on( "click", function() {
	          input.trigger( "focus" );

	          // Close if already visible
	          if ( wasOpen ) {
	            return;
	          }

	          // Pass empty string as value to search for, displaying all results
	          input.autocomplete( "search", "" );
	        });
	    },

	    _source: function( request, response ) {
	      var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
	      response( this.element.children( "option" ).map(function() {
	        var text = $( this ).text();
	        if ( this.value && ( !request.term || matcher.test(text) ) )
	          return {
	            label: text,
	            value: text,
	            option: this
	          };
	      }) );
	    },

	    _removeIfInvalid: function( event, ui ) {

	      // Selected an item, nothing to do
	      if ( ui.item ) {
	        return;
	      }

	      // Search for a match (case-insensitive)
	      var value = this.input.val(),
	        valueLowerCase = value.toLowerCase(),
	        valid = false;
	      this.element.children( "option" ).each(function() {
	        if ( $( this ).text().toLowerCase() === valueLowerCase ) {
	          this.selected = valid = true;
	          return false;
	        }
	      });

	      // Found a match, nothing to do
	      if ( valid ) {
	        return;
	      }

	      // Remove invalid value
	      this.input
	        .val( "" )
	        .attr("title", value + " " + $(this.element).data("notxt") )
	        .tooltip( "open" );
	      this.element.val( "" );
	      $(this.element).change();
	      this._delay(function() {
	        this.input.tooltip( "close" ).attr( "title", "" );
	      }, 2500 );
	      this.input.autocomplete( "instance" ).term = "";
	    },

	    _destroy: function() {
	      this.wrapper.remove();
	      this.element.show();
	    }
	  });
	
	
		$( ".editable_sltbox" ).combobox();
		$(".custom-combobox .ui-autocomplete-input").click(function(){
			$(this).select();
		});
	  
}


function option_add_or_change(selectID, value, addOptionStr){
	
	$("#"+selectID).find(" .added_option_value").remove();
	
	if($("#"+selectID).find(" option[value='"+value+"']").size() > 0){
		$("#"+selectID).val(value);
	} else {
		$("#"+selectID).append("<option class='added_option_value' value='"+value+"'>"+addOptionStr+"</option>");
		$("#"+selectID).val(value);
	}
	
}


function select_hidden_sltbox(id, value, btncls, obj){

	$("#"+id+ " > option[value='"+value+"']").prop("selected", "selected");

	$(obj).closest("."+btncls).siblings("."+btncls).removeClass("on").addClass("off");
	$(obj).closest("."+btncls).removeClass("off").addClass("on");
}





var info_message_timeout_object = null;
function info_message(msg, iconType, bgcolor, fontcolor, position_x, period){
	
	if(iconType === undefined) iconType = "warn";
	if(bgcolor === undefined) bgcolor = "#d60000";
	if(fontcolor === undefined) fontcolor = "#FFFFFF";
	if(position_x === undefined) position_x = "left";
	if(period === undefined) period = 5000;


	var icon = "";
	switch(iconType) {
		case "warn" :
			icon = "fa fa-exclamation-triangle"; 
			break;
		case "info" : 
			icon = "fa fa-info-circle";
			break;
		case "x" :
		case "times" :
		case "close" :
			icon = "fa fa-times-circle";
			break;
		default :
			icon = iconType;
	}


	var px = "";
	switch(position_x) {
		case "left" :
			px = "left:20px;";
			break;
		case "right" :
			px = "right:20px;";
			break;
	}


	info_message_close();
	
	var rndValue = Math.floor(Math.random() * 1000000) + 1;
	
	$("body").append("" +
			"<div class='info_message_box' id='infomsg_"+rndValue+"' " +
					"style='" +
					"display:none; " +
					"position:fixed; " +
					px +
					"bottom:20px; " +
					"z-index:999; " +
					"width:auth; " +
					"height:25px; " +
					"cursor:pointer; " +
					"padding:12px 20px 7px 20px; " +
					"font-size:15px; " +
					"min-width:300px; " +
					"font-weight:bold; " +
					"border:1px solid "+bgcolor+"; border-radius:5px; " +
					"background-color:"+bgcolor+"; " +
					"color:"+fontcolor+"; " +
					"box-shadow:#cfcfcf 3px 3px 3px;' " +
					"onclick='info_message_close()' >" 
				+ '<i class="'+icon+' aria-hidden="true"></i> ' + msg + 
			"</div>"
	);
	
	$("#infomsg_"+rndValue).velocity("transition.bounceUpIn", 700);


	if(info_message_timeout_object != null) clearTimeout(info_message_timeout_object);
	info_message_timeout_object = setTimeout(function(){info_message_close();}, period)
}

function info_message_close(){
	$(".info_message_box").velocity("transition.slideDownBigOut",500);
}



//날짜형식에 이상이 없는지 확인
function validateDate(dateField, format) {
	if(format === undefined || format == "") {
		format = "yy-mm-dd";
	}
	try{
		$.datepicker.parseDate(format, dateField, null);
	}
	catch(error){
		return false;
	}
	return true;
}