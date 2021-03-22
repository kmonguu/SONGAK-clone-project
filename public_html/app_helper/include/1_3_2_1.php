<?
include_once("./_common.php");
?>

<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;"><?=$date?> 접속자 현황</div>
<div class="nbox" style="padding-bottom:0;">
	<div class="tab2">
		<ul>
			<li onclick="menum('menu01-1')">일별</li>
			<li style="color:#a6a6a6;font-size:20px;">&nbsp;&nbsp;|&nbsp;&nbsp;</li>
			<li onclick="menum('menu01-2')">월별</li>
			<li style="color:#a6a6a6;font-size:20px;">&nbsp;&nbsp;|&nbsp;&nbsp;</li>
			<li  class="on"  onclick="menum('menu01-3')">연별</li>
			<li style="color:#a6a6a6;font-size:20px;">&nbsp;&nbsp;|&nbsp;&nbsp;</li>
			<li onclick="menum('menu01-4')">트래픽</li>
		</ul>
	</div>


	<div class="tab">
		<ul>
			<li class="on" onclick="location.href=g4_app_path+'/pages.php?p=1_3_2_1&date=<?=$date?>';">키워드</li>
			<li  onclick="location.href=g4_app_path+'/pages.php?p=1_3_3_1&date=<?=$date?>';">포털</li>
			<li  onclick="location.href=g4_app_path+'/pages.php?p=1_3_4_1&date=<?=$date?>';">OS</li>
			<li  onclick="location.href=g4_app_path+'/pages.php?p=1_3_5_1&date=<?=$date?>';">브라우저</li>
		</ul>
	</div>


	<div class="nbox1">
		<div class='loadingtxt' style="text-align:center; font-size:20px; padding:40px;">
			데이터를 불러오는 중 입니다...
		</div>
		<ul id="datalist">
			<!-- ajax load -->
		</ul>
	</div>



	<div  id="morebtn"  style="float:left;width:100%;height:70px;background:#f5f5f5;border-top:1px solid #dbdbdb; display:none;">
		<div style="float:left;width:20.118%;margin-left:42%;"><img src="<?=$g4["mpath"]?>/images/more_bt.jpg?2" style="width:100%"/></div>
	</div>


</div>




<script>
	var page = 0;
	function load_list(){

		page++;

		var sch_params = <?=json_encode($_REQUEST)?>;

		sch_params["date"] = "<?=$date?>";
		sch_params["rowcnt"] = 100;
		sch_params["page"] = page;

		$.post("<?=$g4["mpath"]?>/include/_ajax_keywordData.php", sch_params, function(data){

			$(".loadingtxt").remove();

			$("#datalist").append(data);
			
			var cnt = $("#datalist > li").size();
			var listcnt = $("#datalist > li:last").data("listcnt");

			if(cnt >= listcnt){
				$("#morebtn").hide();
			} else {
				$("#morebtn").show();
			}
		
		});
		
	}
	$(function(){ 
		load_list();
		$("#morebtn").mousedown(function(){ load_list(); });
	});


</script>