<?
include_once("./_common.php");
header("Content-Type: text/html; charset={$g4['charset']}");

$popInfo = sql_fetch("SELECT * FROM g4_popup WHERE pop_no='$pop_no'");

$imgSizeW = 0;
$imgSizeH = 0;
$isScroll = "";

if($popInfo[pop_img_size] == 1){ //원본크기
	$imgSizeW = $popInfo[pop_img_width_o];
	$imgSizeH = $popInfo[pop_img_height_o];
}
else if($popInfo[pop_img_size] == 2) {//설정값
	$imgSizeW = $popInfo[pop_img_width];
	$imgSizeH = $popInfo[pop_img_height];
}
else {	 //팝업창 크기 맞춤
	$imgSizeW = $popInfo[pop_width];
	$imgSizeH = $popInfo[pop_height]-25;
	$isScroll = "style='overflow:hidden'";
}



?>
<html <?=$isScroll?>>
<head <?=$isScroll?>>
<title><?=$popInfo[pop_nm]?></title>
<style type="text/css">
body {margin:0; padding:0; color:#666; font:12px "맑은 고딕",sans-serif; }
img {vertical-align:top; margin:0; padding:0;border:0;}
#footer {clear:both; width:100%; height:25px; background:#E7E7E7; text-align:right; font-size:11px;}
#footer img {cursor:hand; margin-right:4px;margin-top:3px;}
a:link { color:#0e6fb5;text-decoration:none;}
a:visited { color:#0e6fb5;text-decoration:none;}
a:hover { color:black;text-decoration:none;}
a:active { color:black;text-decoration:none;}

</style>
<script language="JavaScript">
<!--
function setCookie( name, value, expiredays ) {
 var todayDate = new Date();
 todayDate.setDate( todayDate.getDate() + expiredays );
 document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}
function closeWin() {
 setCookie("popup_<?=$popInfo[pop_no]?>", "no1" , 1);
 self.close();
}
//-->
</script>
<script language="JavaScript">
<!--
function changeFrameUrl( url )  {
	if(window.opener.closed) {
		eval("window.open('" + getDomainUrl("/bbs/board.php?bo_table=kim") + "', 'tody_1', '');");
	} else {
		opener.location.href = url ;
	}
	self.close();
}
//-->
</script>

</head>
<body <?=$isScroll?>>


<?
	$imgMap = "";
	$linkStyle = "";
	$linkLocation = "";

	if($popInfo[pop_map] != ""){
		$imgMap = "usemap='#$popInfo[pop_map]'";
	} else {
	
	
		if($popInfo[pop_link]){
			$linkStyle="cursor:pointer;";
			if($popInfo[pop_link_type] == 1){
				$linkLocation = "location.href='$popInfo[pop_link]'";
			}else{
				$linkLocation = "window.open('$popInfo[pop_link]')";
			}
		}
	}
?>
<img src="/data/popupmng/popup_<?=$popInfo[pop_no]?>_1" width="<?=$imgSizeW?>" height="<?=$imgSizeH?>" <?=$imgMap?> style="<?=$linkStyle?>" onclick="<?=$linkLocation?>">
<?if($popInfo[pop_map] != ""){?>
	<map name="<?=$popInfo[pop_map]?>">
		<?=$popInfo[pop_map_opt]?>
	</map>
<?}?>
<div id="footer">
	<form name="form1" style="margin:0;">
		<!-- <a href="javascript:closeWin()">[ 오늘 다시 보지 않기 ]&nbsp;&nbsp;</a> -->
		<!--input type="checkbox" name="interest" value="checkbox" onClick="closeWin();"/-->
		오늘 다시 보지 않기<input type="checkbox" name="interest" value="checkbox" onClick="closeWin();" /><img src="/res/images/pop_close.jpg" alt="닫기" onClick="self.close()">
	</form>
</div>
</body>
</html>

