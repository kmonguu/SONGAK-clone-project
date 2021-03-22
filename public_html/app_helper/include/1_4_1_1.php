<?
include_once("./_common.php");
?>

<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;">접속자 현황</div>
<div class="nbox">
	<div class="tab2">
		<ul>
			<li onclick="menum('menu01-1')">일별</li>
			<li style="color:#a6a6a6;font-size:20px;">&nbsp;&nbsp;|&nbsp;&nbsp;</li>
			<li onclick="menum('menu01-2')">월별</li>
			<li style="color:#a6a6a6;font-size:20px;">&nbsp;&nbsp;|&nbsp;&nbsp;</li>
			<li onclick="menum('menu01-3')">연별</li>
			<li style="color:#a6a6a6;font-size:20px;">&nbsp;&nbsp;|&nbsp;&nbsp;</li>
			<li class="on" onclick="menum('menu01-4')">트래픽</li>
		</ul>
	</div>




	<div style="position:relative;float:left;width:34.763%;margin-left:32.692%;margin-top:30px;">
		<img src="/app_helper/images/i01.jpg" style="width:100%;visibility:hidden;"/>

		<div style="position:absolute;top:-9%;left:-9%;width:118%; height:118%;">
			<input  type="text" class="dial" value=0 data-stopper="false" data-skin="tron" data-width="100%" style="background-color:transparent; border:0px; color:white;">
		</div>

	</div>


	<script>
		$(function() {

			$.post("<?=$g4["mpath"]?>/include/_ajax_getTraffic.php", null, function(data){
			
					var color = "#ff9a2e";
					$(".dial").knob({readOnly:true, max:data["max"], min:0, stopper:false, fgColor:color , bgColor:"transparent", thickness:".2", displayPrevious:false, font:'Noto Sans KR'});
					$(".dial").anim_dial(parseInt(data));

			});

		});
	</script>



	
	<div style="float:left;width:100%;"><img src="/app_helper/images/tr_img.jpg" style="width:100%"/></div>

</div>