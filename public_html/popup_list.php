<?
include_once("./_common.php");
header("Content-Type: text/html; charset={$g4['charset']}");
?>

<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title><?=$popInfo[pop_nm]?></title>
<style type="text/css">
body {margin:0; padding:0; color:#666; font:12px "맑은 고딕",sans-serif; }
img {vertical-align:top; margin:0; padding:0;border:0;}
#footer {clear:both; width:100%; height:25px; background:#E7E7E7; text-align:right; font-size:11px; }
#footer img {cursor:hand; margin-right:4px;margin-top:1px;}
a:link { color:white;text-decoration:none;}
a:visited { color:white;text-decoration:none;}
a:hover { color:#0e6fb5;text-decoration:none;}
a:active { color:#0e6fb5;text-decoration:none;}
*{margin:0;padding:0}
ul { width: 95%; padding:0 0 0 10px}
ul li { list-style:none; font-size:12pt; text-align:center; padding:5px 0 5px 0; margin:5px 0 5px 0; border:0px solid #0e6fb5; background-color:#69a8d4; font-weight:bold}
</style>
<script language="JavaScript">
<!--
function setCookie( name, value, expiredays ) {
 var todayDate = new Date();
 todayDate.setDate( todayDate.getDate() + expiredays );
 document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}
function closeWin() {
 setCookie("popup_list", "no1" , 1);
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

<script type="text/javascript">
function getCookiePop( name ){
	var nameOfCookie = name + "=";
	var x = 0;
	while ( x <= document.cookie.length ){
		var y = (x+nameOfCookie.length);
		if ( document.cookie.substring( x, y ) == nameOfCookie ) {
		if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
			endOfCookie = document.cookie.length;
			return unescape( document.cookie.substring( y, endOfCookie ) );
		}
		x = document.cookie.indexOf( " ", x ) + 1;
		if ( x == 0 )
			break;
	}
	return "";
}

function open_pop_center(url, w, h)
{
		// Fixes dual-screen position                       Most browsers      Firefox
		var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
		var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

		var left = ((screen.width / 2) - (w / 2)) + dualScreenLeft;
		var top = ((screen.height / 2) - (h / 2)) + dualScreenTop - 150;
		var newWindow = window.open(url, "_blank", 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

		// Puts focus on the newWindow
		if (window.focus) {
			newWindow.focus();
		}
}

</script>


<body>

<div style="width:100%;overflow-y:auto;overflow-x:hidden;">
<div style="width: 95%; margin:5px 0 0 10px;border-bottom:1px solid gray;font-size:12pt">
	Popup List
</div>
<ul>

<?
$rL = sql_query("SELECT * FROM g4_popup WHERE pop_type = 'L' "); //목록형태 리스트

//새창 팝업 띄우기
for($i = 0 ; $row = sql_fetch_array($rL) ; $i++){
?>
	<li>	
		<a href="javascript:open<?=$row[pop_no]?>()"><?=$row[pop_nm]?></a>
		<script type="text/javascript">
		function open<?=$row[pop_no]?>(){
			if('<?=$row[pop_iscenter]?>' != 'Y'){
				if ( getCookiePop("popup_<?=$row[pop_no]?>") != "no1" ){
					noticeWindow  =  window.open('popup.php?pop_no=<?=$row[pop_no]?>','popup_<?=$row[pop_no]?>','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=<?=$row[pop_width]?>,height=<?=$row[pop_height]?>,left=<?=$row[pop_left]?>,top=<?=$row[pop_top]?>');
					noticeWindow.opener = self;
				}
			}else{
				if ( getCookiePop("popup_<?=$row[pop_no]?>") != "no1" ){
					open_pop_center('popup.php?pop_no=<?=$row[pop_no]?>', <?=$row[pop_width]?>, <?=$row[pop_height]?>);
				}
			}
		}
		</script>
	</li>
<?}?>
</ul>

</div>

<div id="footer">
	<form name="form1" style="margin:0;">
		오늘 다시 보지 않기<input type="checkbox" name="interest" value="checkbox" onClick="closeWin();"/>
	</form>
</div>
</body>
</html>

