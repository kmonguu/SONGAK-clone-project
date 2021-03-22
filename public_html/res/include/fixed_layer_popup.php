<?
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if( (stripos($ua,'iphone') !== false) || (stripos($ua,'ipod') !== false) || (stripos($ua,'ipad') !== false)  )
{$isIOS = true;} else {$isIOS = false;}
?>

<!-- #################################################################################################################### -->
<script>
var open_fixed_layer_before_focus = null;
function open_fixed_layer(url, width, paramsJson, callback){
	open_fixed_layer_before_focus = $( ":focus" );
    if(callback === undefined) callback = function(){};
    if(paramsJson === undefined) paramsJson = {};
	open_layer_modal(width, "", "");
    load_layer_modal(url, paramsJson, callback);
}
</script>

<style>
#ui-datepicker-div {z-index:9999 !important;} /* 팝업내 jquery calendar */
.layer_model_wrapper {position:fixed; width:100%; height:100%; overflow-x:hidden; overflow-y:auto; top:0px; left:0px; display:none;z-index:999; border-radius:5px; -webkit-overflow-scrolling: touch;}
.layer_modal {width: 910px; position: absolute; top: 10%; left: 50%; z-index: 999; background-color:white; border-radius:0px; box-shadow:#5a5a5a 3px 3px 3px; margin-top:20px; margin-bottom:20px;}
.layer_modal_closebtn {position:absolute; right:25px; top:10px; color:#1d1d1d; font-size:40px; cursor:pointer; z-index:99}
.layer_modal_overlay {width:100%; height:100%; position:fixed; top:0px; left:0px; z-index:899; display:none; background-color:black; opacity:0.5;}
</style>

<!-- 레이어 modal 팝업 -->
<div class="layer_modal_overlay" style="" onclick="">
	&nbsp;
</div>
<div class="layer_model_wrapper" style=""  onclick="">

    <div class="layer_modal" style="">

		<!-- 닫기 버튼 -->
		<a href="javascript:void(0);" class="layer_modal_closebtn" style="color:#2d2d2d;" onclick="close_modal_layer(false);" onkeypress="this.onclick;" title="찯 닫기">
            <i class="fa fa-times"></i>
        </a>

		<!-- 내용 -->
		<div class="" id="layer_modal_content" style="padding: 10px;">  
		</div>

	</div>
</div>

<script>					
$(".layer_modal").on("click", function(e){
	  e.stopPropagation();
});
var layer_modal_is_mouse_over = false;
$(".layer_modal").mouseover(function(){ layer_modal_is_mouse_over = true; });
$(".layer_modal").mouseleave(function(){ layer_modal_is_mouse_over = false; });

function open_layer_modal(width, title, content){
	if(typeof(onModelLayerClose) == "function"){
		delete onModelLayerClose;
		onModelLayerClose = undefined;
	}
	$('.layer_model_wrapper').hide();
	$(".layer_modal").hide();

	$(".layer_modal_overlay").show();
	$(".layer_modal").css({width:width, "margin-left":((width/2)*-1)});
	//$(".layer_modal .drag_handle").css({width:width-43});
	$("#layer_modal_content").css({width:width-20});
	//$("#layer_modal_title").html(title);
	$("#layer_modal_content").html("").html(content);
	set_class_event($("#layer_modal_content"));

	var scrollbar_width = (window.innerWidth - document.documentElement.clientWidth) / 2;

	<?if($isIOS){?>
		$("body, html").css({"overflow":"hidden", "padding-right":scrollbar_width+"px", "position":"relative", "height":"100%"});
	<?} else {?>
		$("body, html").css({"overflow":"hidden", "padding-right":scrollbar_width+"px"});
	<?}?>
}

function load_layer_modal(url, params, callback){
	params["pageNum"] = "<?=$pageNum?>";
	params["subNum"] =  "<?=$subNum?>";
	params["ssNum"] = "<?=$ssNum?>";
	params["tabNum"] = "<?=$tabNum?>";
	loading();
	$("#layer_modal_content").html("").load(url, params, function(){
	
		//set_modal_layer_center_screen();
		$('.layer_model_wrapper').show();
		//open_layer('layer_modal', "transition.slideDownIn", 500);
		open_layer('layer_modal', "transition.slideDownIn", 300, function(){$(".layer_modal_closebtn").focus();});
		set_modal_layer_center_screen();
		set_class_event($("#layer_modal_content"));
		if(callback !== undefined) callback();
		close_loading();
	});
}

function close_modal_layer(overcheck){
	
	if($(".divLoading").is(":visible")) return;
	
	if(overcheck === undefined) overcheck = true;
	if(overcheck){
		if(layer_modal_is_mouse_over) return;
	}

	if(typeof(onModelLayerClose) == "function"){
		if(!onModelLayerClose()) return;
	}
	
	$("body").off("copy");

	//$(".layer_modal").velocity("transition.slideUpOut", 200, function(){
	$(".layer_modal").velocity("transition.slideUpOut", 200, function(){
		$(".layer_modal_overlay").hide();
		$('.layer_model_wrapper').hide();
		<?if($isIOS){?>
			$("body, html").css({"overflow":"inherit", "padding-right":"0px", "position":"inherit", "height":"auto"});
		<?} else {?>
			$("body, html").css({"overflow":"inherit", "padding-right":"0px"});
		<?}?>

		if(open_fixed_layer_before_focus != null) {
			open_fixed_layer_before_focus.focus();
		}
		if(typeof(onModalLayerClosed) == "function") {
			onModalLayerClosed();
		}
	});

}

//레이어 Modal 팝업 센터로
function set_modal_layer_center_screen(){
	
	var h = $(".layer_modal").height();
	var wh = window.innerHeight;

	var ntop = (wh - h) / 2 - 20;
	if(ntop < 0) {
		ntop = 0;
		$(".layer_model_wrapper").scrollTop(0);
	}

	$(".layer_modal").css("top", ntop+"px");
}

$(window).resize(function(){
	if($(".layer_modal").is(":visible")) {
		set_modal_layer_center_screen();
	}
});

$(document).keyup(function(ev){
	//if(ev.keyCode == 27) close_modal_layer();
});
</script>
<!-- 레이어 modal 팝업 -->
<!-- #################################################################################################################### -->


