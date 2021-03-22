<?
include_once("./_common.php");
?>

<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;"><?=$date?> 접속자 현황</div>
<div class="nbox">
	<div class="tab2">
		<ul>
			<li onclick="menum('menu01-1')">일별</li>
			<li style="color:#a6a6a6;font-size:20px;">&nbsp;&nbsp;|&nbsp;&nbsp;</li>
			<li onclick="menum('menu01-2')">월별</li>
			<li style="color:#a6a6a6;font-size:20px;">&nbsp;&nbsp;|&nbsp;&nbsp;</li>
			<li class="on" onclick="menum('menu01-3')">연별</li>
			<li style="color:#a6a6a6;font-size:20px;">&nbsp;&nbsp;|&nbsp;&nbsp;</li>
			<li onclick="menum('menu01-4')">트래픽</li>
		</ul>
	</div>


	<div class="tab">
		<ul>
			<li  onclick="location.href=g4_app_path+'/pages.php?p=1_3_2_1&date=<?=$date?>';">키워드</li>
			<li  onclick="location.href=g4_app_path+'/pages.php?p=1_3_3_1&date=<?=$date?>';">포털</li>
			<li  onclick="location.href=g4_app_path+'/pages.php?p=1_3_4_1&date=<?=$date?>';">OS</li>
			<li  class="on" onclick="location.href=g4_app_path+'/pages.php?p=1_3_5_1&date=<?=$date?>';">브라우저</li>
		</ul>
	</div>

	<div style="float:left;position:relative;width:100%;">

		<div class='loadingtxt' style="text-align:center; font-size:20px; padding-top:20px;">
			데이터를 불러오는 중 입니다...
		</div>
		<div style="position:absolute;top:5%;left:23.5%;width:50%;text-align:center;font-weight:bold;font-size:28px;" class="dial_title_1"></div>
		<div style="position:absolute;top:55%;left:10%;width:20%;text-align:center;font-weight:bold;font-size:22px;"  class="dial_max_1"></div>
		<div style="position:absolute;top:55%;left:68%;width:20%;text-align:center;font-weight:bold;font-size:22px;" class="dial_min_1"></div>

		
		<div style="float:left;width:38.165%;margin-left:30%;margin-top:70px;">
			<img src="/app_helper/images/mc01.jpg" style="width:100%; visibility:hidden;"/>
			<div class="divDial" style="position:absolute;top:15%;left:27%;width:89%; height:89%;">
				<input  type="text" class="dial1" value=0 data-stopper="false" data-skin="tron" data-width="100%" style="background-color:transparent; border:0px; color:white;">
			</div>
		</div>
	</div>

	
	<div style="float:left;width:100%;margin-top:40px;margin-bottom:40px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>

	<div style="float:left;position:relative;width:100%;">
		
		<div style="position:relative;float:left;width:18.934%;margin-left:11%;margin-bottom:50px;">
			<img src="/app_helper/images/mc02.jpg" style="width:100%;visibility:hidden;"/>
			<div style="position:absolute;top:-9%;left:-9%;width:118%; height:118%;">
				<input  type="text" class="dial2" value=0 data-stopper="false" data-skin="tron" data-width="100%" style="background-color:transparent; border:0px; color:white;">
			</div>
		</div>
		<div style="position:absolute;top:75%;left:7.4%;width:26%;text-align:center;font-weight:bold;font-size:20px;" class="dial_title_2"></div>


		<div style="position:relative;float:left;width:18.934%;margin-left:11%;margin-bottom:50px;">
			<img src="/app_helper/images/mc02.jpg" style="width:100%;visibility:hidden;"/>
			<div style="position:absolute;top:-9%;left:-9%;width:118%; height:118%;">
				<input  type="text" class="dial3" value=0 data-stopper="false" data-skin="tron" data-width="100%" style="background-color:transparent; border:0px; color:white;">
			</div>
		</div>
		<div style="position:absolute;top:75%;left:37.4%;width:26%;text-align:center;font-weight:bold;font-size:20px;" class="dial_title_3"></div>



		<div style="position:relative;float:left;width:18.934%;margin-left:11%;margin-bottom:50px;">
			<img src="/app_helper/images/mc02.jpg" style="width:100%;visibility:hidden;"/>
			<div style="position:absolute;top:-9%;left:-9%;width:118%; height:118%;">
				<input  type="text" class="dial4" value=0 data-stopper="false" data-skin="tron" data-width="100%" style="background-color:transparent; border:0px; color:white;">
			</div>
		</div>
		<div style="position:absolute;top:75%;left:67.4%;width:26%;text-align:center;font-weight:bold;font-size:20px;" class="dial_title_4"></div>
	</div>


	
	<script>
		$(function() {

			$.post("<?=$g4["mpath"]?>/include/_ajax_getBrowserData.php", {date:"<?=$date?>"}, function(data){
				
				$(".loadingtxt").remove();

				for(i = 0; i < 4; i++){
					var title = "";
					if( i == 0) {
						$(".dial_max_1").html(data["max"]);
						$(".dial_min_1").html(0);
					}
					
					title = data["title"][i];
					$(".dial"+(i+1)).data("date", data["title"][i]);
					
					var color = "#ff9a2e";
					if(i ==0) color = "#d54220";
					$(".dial"+(i+1)).knob({readOnly:true, max:data["max"], min:0, stopper:false, fgColor:color , bgColor:"transparent", thickness:".2", displayPrevious:false, font:'Noto Sans KR'});
					$(".dial"+(i+1)).anim_dial(data["data"][i]);
					$(".dial_title_"+(i+1)).html(title);
				}

			}, "json");

		});
	</script>








</div>