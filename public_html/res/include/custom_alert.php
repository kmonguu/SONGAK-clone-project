
<!-- #################################################################################################################### Custom Alert -->


<style>
.custom_alert a {text-decoration:none;}

/* PC */
@media screen and (min-width:640px) {
	.custom_alert.radius .Lpcon2 { padding:0px !important; }
	.custom_alert ul {  }
	.custom_alert ul > li  { height:40px; box-sizing:border-box; border:1px solid #a7a7a7; border-radius:3px; margin:5px 0 0px 0px; cursor:pointer; text-align:center; }
	.custom_alert ul > li > a  > span { font-size:16px; color:#474747; font-weight:300; line-height:38px; padding:0 15px; }
	.custom_alert ul > li.on  { background:#e32128; border-color:#e32128; }
    .custom_alert ul > li.on > a > span { color:#ffffff; }
    .custom_alert .alert_msg {text-align:center; width:95%; padding:20px 2.5% 35px 2.5%; font-size:15px; color:#222;}
}
/* Mobile */
@media screen and (max-width:640px) {
	.custom_alert.radius .Lpcon2 { padding:0px !important; }
	.custom_alert ul {  }
	.custom_alert ul > li  { height:48px; box-sizing:border-box; border:1px solid #a7a7a7; border-radius:3px; margin:5px 0 0px 0px; cursor:pointer; text-align:center; }
	.custom_alert ul > li > a > span { font-size:25px; color:#474747; font-weight:300; line-height:42px; padding:0px 15px; }
	.custom_alert ul > li.on { background:#e32128; border-color:#e32128; }
    .custom_alert ul > li.on > a > span { color:#ffffff; }
    .custom_alert .alert_msg {text-align:center; width:95%; padding:30px 2.5% 45px 2.5%; font-size:19px; color:#222;}
}

.custom_alert_first_focus:focus {outline:none;}
.custom_alert_wrapper {position:fixed; width:100%; height:100%; overflow-x:hidden; overflow-y:auto; top:0px; left:0px; display:none;z-index:9999;}
.custom_alert {width: 910px; position: absolute; top: 10%; left: 50%; z-index: 9999; background-color:white; border-radius:3px; box-shadow:#4a4a4a 2px 2px 2px;}
</style>



<script>
var custom_alert_before_focus = null;
var custom_alert_close_callback = null;
function custom_alert(width, msg, callback){
	custom_alert_before_focus = $( ":focus" );
    custom_alert_close_callback = callback === undefined ? null : callback;
	custom_alert_duration = 500;
	custom_alert_close_duration = 200;
	custom_alert_in_animation = "transition.bounceIn";
	custom_alert_out_animation = "transition.expandOut";

    msg = msg.split("\n").join("<br/>");
    $(".btn_custom_alert").show();
    $(".btn_custom_confirm").hide();
    open_custom_alert(width, msg);
}
function custom_confirm(width, msg, onOk, onCancel){
	custom_alert_before_focus = $( ":focus" );
	custom_alert_duration = 200;
	custom_alert_close_duration = 10;
	custom_alert_in_animation = "transition.expandIn";
	custom_alert_out_animation = "transition.expandOut";

    msg = msg.split("\n").join("<br/>");
    $(".btn_custom_alert").hide();
    $(".btn_custom_confirm").show();
	open_custom_alert(width, msg, onOk, onCancel);
	
}
</script>

<!-- Custom Alert Layer 팝업 -->
<div class="custom_alert_overlay" style="width:100%; height:100%; position:fixed; top:0px; left:0px; z-index:9998; display:none; background-color:black; opacity:0.5" onclick="">
	&nbsp;
</div>
<div class="custom_alert_wrapper" style="" >

	<div class="custom_alert" style="">

		<div class="" id="custom_alert_content" style="width: 890px; padding: 10px;">  

			<a class="custom_alert_first_focus" href="javascript:void(0);">
				<div class="alert_msg">
					<!-- 내용이 출력되는 부분 -->
				</div>
			</a>
			
			<ul class="btn_custom_confirm">
				<li class="on" onclick="custom_alert_ok()">
					<a href="javascript:void(0);">
						<span><i class='fa fa-check'></i> OK</span>
					</a>
				</li>
				<li onclick="custom_alert_cancel()">
					<a href="javascript:void(0);">
						<span>취소</span>
					</a>
				</li>
            </ul>
            
            <ul class="btn_custom_alert">
				<li class="on" onclick="custom_alert_ok()">
					<a href="javascript:void(0);">
						<span>확인</span>
					</a>
				</li>
			</ul>

		</div>
	</div>
</div>

<script>					
$(".custom_alert").on("click", function(e){
	  e.stopPropagation();
});

var custom_alert_duration = 500;
var custom_alert_close_duration = 200;
var custom_alert_in_animation = "transition.bounceIn";
var custom_alert_out_animation = "transition.expandOut";
var custom_alert_ok_function = null;
var custom_alert_cancel_function = null;
function open_custom_alert(width, msg, onOk, onCancel){

	$('.custom_alert_wrapper').hide();
	$(".custom_alert").hide();
	$(".custom_alert_overlay").show();
	$(".custom_alert").css({width:width, "margin-left":((width/2)*-1)});
	$("#custom_alert_content").css({width:width-20});
	//$("body, html").css({"overflow":"hidden"});
	$("#custom_alert_content").find(".alert_msg").html(msg);
	$('.custom_alert_wrapper').show();
	open_layer('custom_alert', custom_alert_in_animation, custom_alert_duration, function(){ 	$(".custom_alert_first_focus").focus().select(); });
	set_custom_alert_center_screen();
	set_class_event($("#custom_alert_content"));
	custom_alert_ok_function = onOk;
	custom_alert_cancel_function = onCancel;



}

function custom_alert_ok(){
	close_custom_alert(true);

}
function custom_alert_cancel(){
	close_custom_alert(false);
	
}

function close_custom_alert(isok){
	var isok = isok === undefined ? false : isok;
	$(".custom_alert").velocity(custom_alert_out_animation, custom_alert_close_duration, function(){
		$(".custom_alert_overlay").hide();
		$('.custom_alert_wrapper').hide();
		if(custom_alert_before_focus != null) {custom_alert_before_focus.focus();}
		if(isok && typeof(custom_alert_ok_function) == "function") custom_alert_ok_function();
        if(!isok && typeof(custom_alert_cancel_function) == "function") custom_alert_cancel_function();
        if(typeof(custom_alert_close_callback) == "function") custom_alert_close_callback();
		custom_alert_ok_function = null;
		custom_alert_cancel_function = null;
		custom_alert_close_callback = null;
	});

}
//레이어 Modal 팝업 센터로
function set_custom_alert_center_screen(){
	var h = $(".custom_alert").height();
	var wh = window.innerHeight;
	var ntop = (wh - h) / 2;
	if(ntop < 0) {
		ntop = 0;
		$(".layer_model_wrapper").scrollTop(0);
	}
	$(".custom_alert").css("top", ntop+"px");
}
$(window).resize(function(){
	if($(".custom_alert").is(":visible")) {
		set_custom_alert_center_screen();
	}
});
</script>

<!-- 
#### Custom Alert #################################################################################################################### -->


