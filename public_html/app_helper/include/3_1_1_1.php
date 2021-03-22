<div style="position:relative;float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;width:100%;">수정의뢰
	<div style="position:absolute;top:-10px;right:9%;width:20.786%;"><a href="javascript:void(0);" onclick="go_write();"><img src="/app_helper/images/write_btn2.jpg" style="width:100%"/></a></div>
</div>
<div class="nbox"  style="padding-bottom:0; min-height:175px;">
	<ul id="datalist">
		
	</ul>

	<div  id="morebtn"  style="float:left;width:100%;height:70px;background:#f5f5f5;border-top:1px solid #dbdbdb; display:none; ">
		<div style="float:left;width:20.118%;margin-left:42%;"><img src="<?=$g4["mpath"]?>/images/more_bt.jpg?2" style="width:100%"/></div>
	</div>
</div>






<script>
    function go_write(){
        location.href = "<?=$g4["mpath"]?>/pages.php?p=3_3_1_1&w=";
    }

	var page = 0;
	function load_list(){

		page++;

		var sch_params = <?=json_encode($_REQUEST)?>;

		sch_params["rowcnt"] = 15;
		sch_params["page"] = page;
	
		$.post("<?=$g4["mpath"]?>/include/_ajax_modify_list.php", sch_params, function(data){
			
			$("#datalist").append(data);
			
			var cnt = $("#datalist > li").size();
			var listcnt = $("#datalist > li:last").data("listcnt");
			var savepage = $("#datalist > li:last").data("savepage");
			var savesc = $("#datalist > li:last").data("savesc");
			if(savepage !== undefined && savepage != null && savepage != "") page = parseInt(savepage);
			if(savesc !== undefined && savesc != null && savesc != "") $(window).scrollTop(savesc);

			if(cnt >= listcnt){
				$("#morebtn").hide();
			} else {
				$("#morebtn").show();
			}

			closeProgress();
		
		});
		
	}

	if(typeof(window.onpageshow) != "undefined") {
		window.onpageshow =  function(event) {
			$("#datalist").html("");
			load_list();
		}
	} else {
		$(function(){ load_list(); });
	}
	$(function(){
		$("#morebtn").click(function(){ showProgress(); load_list(); });
	});



	function go_view(no){
		var save_sc = $(window).scrollTop();
		location.href=g4_app_path+"/pages.php?p=3_2_1_1&save_sc="+save_sc+"&save_page="+page+"&wr_id="+no+"<?=$qstr?>";
	}

</script>
