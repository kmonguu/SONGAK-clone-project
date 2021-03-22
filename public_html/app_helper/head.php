<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once($g4[mpath]."/head.sub.php");


if($bo_table){
	$ppage=explode("_",$bo_table);
	$pageNum=$ppage[0];
	$subNum=$ppage[1];
	$ssNum=$ppage[2];
	$tabNum=$ppage[3];
}
if($p){
$ppage=explode("_",$p);
$pageNum=$ppage[0];
$subNum=$ppage[1];
$ssNum=$ppage[2];
$tabNum=$ppage[3];
}


$tot=$pageNum."_".$subNum;
$tott=$pageNum."_".$subNum."_".$ssNum;
$totp=$pageNum."_".$subNum."_".$ssNum."_".$tabNum;
?>

<?if(defined("__INDEX")){?>
<script>
history.pushState(null, null, location.href);
window.onpopstate = function(event) {
	history.go(1);
};
</script>
<? }?>


<?if(!preg_match("/login.php$/", $_SERVER['PHP_SELF'])) { //로그인화면에서는 Header 안나오게  ?>


<!-- <div style="padding:5% 0 5% 5%;">

	<button onclick="location.reload();">새로고침<?=$tot?></button>
	&nbsp;
	<button onclick="location.href='<?=$g4["mpath"]?>/index.php';">메인화면</button>
	&nbsp;
	<button onclick="location.href='./bbs/logout.php' ">로그아웃</button>
	
</div> -->
<style>
.headtop {float:left;width:100%;}

#Menu {position:absolute;width:73.47%;min-height:2170px;height:auto;background:#191c1f;z-index:200;top:0px;right:-73.47%;display:none}
#Menu #sidemenu .smenu {display:none;}
#Menu #sidemenu .smenu.on {display:block;}

.ci {width:38.333%;position:absolute;top:12.4%;left:30.833%;z-index:10}
.leftbtn {width:5.138%;position:absolute;top:20.5%;left:3.611%;z-index:10}
.rightbtn {width:5.138%;position:absolute;top:20.5%;right:3.611%;z-index:10}
.mmenu {width:93.88%;position:absolute;top:63.4%;left:2.77%;min-width:620px;}
.mmenu ul {list-style:none;margin:3.8% 0 0 0;padding:0;line-height:10px;}
.mmenu ul li {float:left;margin:0 0 0 5.3%;padding:0;white-space:nowrap;}
.mmenu ul li span {height:45px;font-size:27px;color:#7c7d7e;font-family:'Noto Sans KR';display:inline-block}
.mmenu ul li.on span {color:#ffffff;border-bottom:2px solid #ff5f2e}
.mmenu ul li:first-child {margin:0}

.title {width:88.33%;font-size:32px;color:#fff;position:absolute;top:277px;left:5.55%;font-family:'Noto Sans KR'}
.title1 {float:left;margin:0;padding:0}
.title1cou {float:left;width:7.63%;height:25px;border-radius:8px;background:#fff;text-align:center;line-height:29px;color:#ff5605;font-size:20px;font-weight:bold;font-family:'Noto Sans KR';margin:5px 0 0 2.5%;}
</style>

<script type="text/javascript">
function smenuView(me){

	var isOpen = jQuery(me).parent().children(".smenu").is(":visible");

	if(isOpen){
		jQuery(me).parent().children(".smenu").slideUp();
		$(me).removeClass("on");
	
	}else{
		jQuery(me).parent().children(".smenu").slideDown();
		$(me).addClass("on");
		
	}
}
</script>

<script type="text/javascript">
	function menu(){
		if(jQuery("#Menu").height()<jQuery("#wrap").height()) jQuery("#Menu").height(jQuery("#wrap").height());
		jQuery("#Menu").show();
		jQuery("#menu_overlay").show();
		jQuery("#Menu").animate({"right":"0px"}, 400, function(){
		});
		
	}
	function menuclose(){
		jQuery("#MenuArea").hide();
		jQuery("#menu_overlay").hide();
		jQuery("#Menu").animate({"right":"-73.47%"}, 400, function(){
			jQuery("#Menu").hide();
		});
	}
</script>


<!--
<div onclick="location.href='<?=$g4["mpath"]?>/pages.php?p=999_1_1_1';" style="z-index:999;position:absolute; left:30%; top:10px; border:3px solid black; background:#efefef; width:135px; height:30px; padding:10px; font-size:20px; opacity:0.6; color:black;">
	테스트페이지로
</div>
<div onclick="location.reload();" style="z-index:999;position:absolute; left:55%; top:10px; border:3px solid black; background:#efefef; width:135px; height:30px; padding:10px; font-size:20px; opacity:0.6; color:black;">
	새로고침
</div>
-->


<!--챗팅 패널 --> 
<div id="chatpanel" style="z-index:9999;width:100%;height:100%;position:fixed;display:none;">
	<!-- 챗팅! -->
</div>

<div id="menu_overlay" onclick="menuclose()" style="position:fixed; top:0px; left:0px; width:100%; height:100%; background:#000000; opacity:0.7; z-index:199;display:none">
&nbsp;
</div>

<div id="Menu" style="position:fixed;">
	<div style="position:absolute;width:6.05%;right:5.97%;top:42px;z-index:999"><img src="/app_helper/images/rightmenu/close.jpg?2" onclick="menuclose()" width="100%" /></div>

	<div style="position:relative;">
		<div style="position:absolute;width:100%;left:0%;top:0%;"><img src="/app_helper/images/rightmenu/ci.jpg?2" width="100%" /></div>

		<div id="sidemenu" style="width:100%;">
			<div style="position:relative;float:left;width:100%;margin:0;" onclick="menum('menu06-1')"><img src="/app_helper/images/rightmenu/menu5.jpg?2" width="100%" />
				<div style="position:absolute;left:17.025%;top:28%;color:#bec0c8;font-size:28px;">접속자 알람 설정</div>
			</div>
			<?if(!$isIOS){?>
			<div style="position:relative;float:left;width:100%;margin:0;" onclick="showSettingView();"><img src="/app_helper/images/rightmenu/menu1.jpg?2" width="100%" />
				<div style="position:absolute;left:17.025%;top:21%;color:#bec0c8;font-size:28px;">도메인 설정</div>
			</div>
			<?}?>
			<div style="position:relative;float:left;width:100%;margin:0;" onclick="menum('menu07-1')"><img src="/app_helper/images/rightmenu/menu2.jpg?2" width="100%" />
				<div style="position:absolute;left:17.025%;top:21%;color:#bec0c8;font-size:28px;">실시간문의 설정</div>
			</div>
			<div style="position:relative;float:left;width:100%;margin:0;" onclick="logout();"><img src="/app_helper/images/rightmenu/menu3.jpg?2" width="100%" />
				<div style="position:absolute;left:17.025%;top:21%;color:#bec0c8;font-size:28px;">로그아웃</div>
			</div>
			<?if(!$isIOS){?>
			<div style="position:relative;float:left;width:100%;margin:0;" onclick="exit_app();"><img src="/app_helper/images/rightmenu/menu4.jpg?2" width="100%" />
				<div style="position:absolute;left:17.025%;top:21%;color:#bec0c8;font-size:28px;">종료</div>
			</div>
			<?}?>
		</div>
	</div>
</div>


<div id="wrap">

	<div class="headtop">
		

		<div style="float:left;position:relative;width:100%;"><img src="/app_helper/images/top/headbg.jpg?2" width="100%"/>

			<div class="leftbtn" onclick="menum('menu05-1');"><img src="/app_helper/images/top/leftbtn.png?2" width="100%"/></div>

			<div class="ci"><a href="javascript:home();"><img src="/app_helper/images/top/ci.png?3" width="100%"/></a></div>
			
			<div class="rightbtn" onclick="menu()"><img src="/app_helper/images/top/rightbtn.png?2" width="100%" /></div>

			<div class="mmenu">
				<ul>
					<li <?=$pageNum=="1" ? "class='on'" : ""?> ><a href="<?=$g4["mpath"]?>/pages.php?p=1_1_1_1"><span>접속자 분석기</span></a><li>
					<li <?=$pageNum=="2" ? "class='on'" : ""?> ><a href="<?=$g4["mpath"]?>/pages.php?p=2_1_1_1"><span>실시간 알리미</span></a><li>
					<li <?=$pageNum=="3" ? "class='on'" : ""?> ><a href="<?=$g4["mpath"]?>/pages.php?p=3_1_1_1"><span>수정의뢰</span></a><li>
					<li <?=$pageNum=="4" ? "class='on'" : ""?> ><a href="<?=$g4["mpath"]?>/pages.php?p=4_1_1_1"><span>공지사항</span></a><li>
				</ul>
			</div>
		</div>
	</div>
	<!--
	<div class="title">
		<?if(defined("__INDEX")){?>
		<div class="title1">새로운 게시글 알림</div><div class="title1cou">23</div>
		<?}else if($totp=='1_1_1_1'){?>
		<div class="title1">
			2017-11-15
		</div>
		<?}else if($totp=='2_1_1_1'){?>
		<div class="title1">
			실시간 알리미
		</div>
		<?}else if($totp=='3_1_1_1'){?>
		<div class="title1">
			수정의뢰
		</div>
		<?}else if($totp=='4_1_1_1'){?>
		<div class="title1">
			공지사항
		</div>
		<?}else{?>
		
		<?}?>
	</div>
	-->





<?}?>