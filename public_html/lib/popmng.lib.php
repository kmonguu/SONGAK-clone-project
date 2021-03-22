<?
if (!defined('_GNUBOARD_')) exit;
?>

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

function popup_setCookie( name, value, expiredays ){
	var todayDate = new Date();
	todayDate.setDate( todayDate.getDate() + expiredays );
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";";
}



function open_pop_center(url, w, h, no)
{
		// Fixes dual-screen position                       Most browsers      Firefox
		var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
		var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

		var left = ((screen.width / 2) - (w / 2)) + dualScreenLeft;
		var top = ((screen.height / 2) - (h / 2)) + dualScreenTop - 150;
		var newWindow = window.open(url, "adminpopup"+no, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

		// Puts focus on the newWindow
		if (window.focus) {
			newWindow.focus();
		}
}


function open_popup(url, w, h, top, left, no)
{
		// Fixes dual-screen position                       Most browsers      Firefox
		var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
		var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

		left = left + dualScreenLeft;
		top = top + dualScreenTop;
		var newWindow = window.open(url, "adminpopup"+no, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

		// Puts focus on the newWindow
		if (window.focus) {
			newWindow.focus();
		}
}



function openLayerPopup(id, w, h, x, y, is_center)
{
	var p = $("#layer_popup"+id);
	var divName = p.attr("id");
	var noticeCookie = getCookiePop(divName);  // 쿠키네임 지정
	
	p.css({top:y+"px", left:x+"px"});
	

	if(is_center == "Y"){
		var left = (w / 2);
		var top = ($(window).height() / 2) - (h / 2);
		p.css({top:top+"px", left:"50%", "margin-left":"-"+left+"px"});
	}

	if (noticeCookie != "no"){
		p.show();
	}
	
}

</script>
<?
$rY = sql_query("SELECT * FROM g4_popup WHERE is_mobile=0 AND pop_type = 'Y' AND '".date("Y-m-d")."' BETWEEN pop_sdate AND pop_edate "); //새창 리스트
$rL = sql_fetch("SELECT count(*) cnt FROM g4_popup WHERE is_mobile=0 AND pop_type = 'L' "); //목록형태 리스트

//새창 팝업 띄우기
for($i = 0 ; $row = sql_fetch_array($rY) ; $i++){
?>
	<script type="text/javascript">
		if('<?=$row[pop_iscenter]?>' != 'Y'){
			if ( getCookiePop("popup_<?=$row[pop_no]?>") != "no1" ){
				open_popup('popup.php?pop_no=<?=$row[pop_no]?>', <?=$row[pop_width]?>, <?=$row[pop_height]?>, <?=$row[pop_top]?>, <?=$row[pop_left]?>, '<?=$row[pop_no]?>');
			}
		}else{
			if ( getCookiePop("popup_<?=$row[pop_no]?>") != "no1" ){
				open_pop_center('popup.php?pop_no=<?=$row[pop_no]?>', <?=$row[pop_width]?>, <?=$row[pop_height]?>, '<?=$row[pop_no]?>');
			}
		}
	</script>

<?}
if($rL[cnt] != 0){?>
	<script type="text/javascript">
		var height = <?=$rL[cnt]?> * 40 + 47;
		if ( getCookiePop("popup_list") != "no1" ){
			noticeWindow  =  window.open('popup_list.php','popup_list','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=406,height='+height+',left=10,top=10');
			noticeWindow.opener = self;
		}
	</script>
<?}?>






<?
//레이어 팝업 띄우기
$rR = sql_query("SELECT * FROM g4_popup WHERE is_mobile=0 AND (pop_type = 'F' OR pop_type = 'A') AND '".date("Y-m-d")."' BETWEEN pop_sdate AND pop_edate "); //레이어팝업 리스트
for($i = 0 ; $row = sql_fetch_array($rR) ; $i++){

$popInfo = $row;
$imgSizeW = 0;
$imgSizeH = 0;
$isScroll = "";
$posType = "absolute";
if($popInfo["pop_type"] == "F") $posType = "fixed";

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
	$imgSizeH = $popInfo[pop_height];-60;
	$isScroll = "style='overflow:hidden'";
}

?>
	
		<div id="layer_popup<?=$row[pop_no]?>" style="position:<?=$posType?>; z-index:998; width:<?=$row[pop_width]?>px; height:<?=$row[pop_height]?>px; display:none;  overflow:hidden; line-height:0px;">
				
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

			<div style="background:#000000; color:#ffffff; position:absolute; left:0px; bottom:0px; width:100%; ;text-align:left;padding:3px 5px 5px 10px;margin:0;font-size:14px;height:28px;line-height:28px;">
				<input type="checkbox" id="popup_chk<?=$row[pop_no]?>" style="vertical-align:-2px;"
				onclick="if(this.checked) popup_setCookie($(this).parent().parent().attr('id'), 'no' , 1); else popup_setCookie($(this).parent().parent().attr('id'), 'no' , -1000);" />
				<label for="popup_chk<?=$row[pop_no]?>">오늘 하루 열지않기</label>
				<a style="position:absolute; right:25px; top:-2px; color:#ffffff; font-size:11px; display:block; padding:5px 0;font-size:14px;" href="#"
				onclick="$(this).parent().parent().hide(); return false;">닫기</a>
			</div>

		</div>




	<script>
		openLayerPopup(<?=$row["pop_no"]?>, '<?=$row["pop_width"]?>', '<?=$row["pop_height"]?>', '<?=$row["pop_left"]?>', '<?=$row["pop_top"]?>', '<?=$row["pop_iscenter"]?>');
	</script>

<?}
