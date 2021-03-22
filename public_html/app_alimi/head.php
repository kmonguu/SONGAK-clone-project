<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가


$subNaviHeight = array("",389,389,389,484,389,389);

if($bo_table){ //게시판일때
$bp=explode("_",$bo_table);
$pageNum=$bp[0];
$subNum=$bp[1];
$ssNum=$bp[2];
$tabNum=$bp[3];
}

if($p){
$ppage=explode("_",$p);
$pageNum=$ppage[0];
$subNum=$ppage[1];
$ssNum=$ppage[2];
$tabNum=$ppage[3];
}

$tot=$pageNum."_".$subNum;


include_once("{$in_app_path}/head.sub.php");
?>




<div data-role="page" id="roomnetpage" data-fullscreen="false">

		
	<div data-role="panel" id="menupanel" data-position="right" data-position-fixed="true"  data-display="overlay" style="background-color:white;">
	 
	  		<ul data-role="listview"  data-inset="false" data-divider-theme="d">
	  			<li data-role="list-divider">메뉴</li>
	  			<?if($member[mb_id]){ ?>
			    <li><a href="javascript:menulink('menu03-1')" style="font-size:0.8em;" >실시간채팅 설정</a></li>
			    <?}?>

				<?if(!$isIOS) {?>
			    <li><a href="javascript:showSettingView()" style="font-size:0.8em;" >도메인변경</a></li>
				<?}?>
			
			    <?if($member[mb_id]){ ?>
			    <li><a href="javascript:logout()" style="font-size:0.8em;" >로그아웃</a></li>
			    <?}?>

				<?if(!$isIOS) {?>
			    <li data-role="list-divider"></li>
			    <li><a href="javascript:exit_app()" style="font-size:0.8em;" >종료</a></li>
				<?}?>

			</ul>
			
	  </div><!-- /panel -->
	  
	  
	  
	  <div data-role="panel" id="chatpanel" class="chatpanel" data-swipe-close="false" data-dismissible="false" data-position="right" data-position-fixed="true" data-display="overlay" style="background-color:#e4e4e4;width:100%">
	 
	  </div><!-- /panel -->
	  
	  

	  <div data-role="header" data-position="fixed"  data-theme="b"  data-tap-toggle="false"  data-hide-during-focus="false" >
		
		<div style='padding:0.4em;height:32px;'>
			<div style='float:left'>
				<a href="http://<?=$_SERVER[HTTP_HOST]?><?=$_SERVER[PHP_SELF]?>?<?=$_SERVER[QUERY_STRING]?>" data-ajax="false" style="color:white;">
					<img src="<?=$in_app_path?>/images/icon.png?7" align="absmiddle" style="width:32px;height:32px;" />
				</a>
			</div>
			<div style='float:left;margin-left:7px;padding-top:9px;'>
				<a href="http://<?=$_SERVER[HTTP_HOST]?><?=$_SERVER[PHP_SELF]?>?<?=$_SERVER[QUERY_STRING]?>" data-ajax="false" style="color:white;" id="app_title">
					홈페이지 알리미 2.0
				</a>
			</div>
		</div>
		
		<div data-role="controlgroup" data-type="horizontal" data-mini="true"  class="ui-btn-right"> 
			<a href="#menupanel"  data-role="button" data-iconpos="notext" data-icon="bars" data-theme="b">Menu</a>
		</div>

		<?if($member[mb_id]){ ?>
		
		<div data-role="navbar" data-iconpos="top" style="overflow:hidden">
			<ul>
				<li><a href="javascript:menulink('menu01-1')" class="mmn m1_1" data-ajax="true"  data-transition="none" data-theme="b" style='color:white' >게시판알림</a></li>
				<li><a href="javascript:menulink('menu02-1')" class="mmn m2_1" data-ajax="true"  data-transition="none" data-theme="b" style='color:white'>실시간채팅</a></li>
			</ul>
		</div>

		<?}?>
		
	  </div>
	 	 


