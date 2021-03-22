<?
if (!defined('_GNUBOARD_')) exit;
?>

<script type="text/javascript">
function popup_setCookie( name, value, expiredays ){
	var todayDate = new Date();
	todayDate.setDate( todayDate.getDate() + expiredays );
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";";
}

function getCookie(name){
	var Found = false;
	var start, end;
	var i = 0;

	while(i<= document.cookie.length) {
		start = i;
		end = start +name.length;

		if(document.cookie.substring(start, end)== name) {
			Found = true;
			break;
		}
		i++;
	}

	if(Found == true) {
		start = end + 1;
		end = document.cookie.indexOf(";",start);
		if(end < start)
			end = document.cookie.length;
		return document.cookie.substring(start, end);
	}
	return "";
}
// 이부분 까지는 수정할 필요 없습니다.


function openPopup(id, w, h, x, y, is_center)
{
	var p = $("#m_popup"+id);
	var divName = p.attr("id");
	var noticeCookie = getCookie(divName);  // 쿠키네임 지정
	
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
$rY = sql_query("SELECT * FROM g4_popup WHERE is_mobile=1 AND pop_type = 'Y' AND '".date("Y-m-d")."' BETWEEN pop_sdate AND pop_edate "); //새창 리스트

//새창 팝업 띄우기
for($i = 0 ; $row = sql_fetch_array($rY) ; $i++){
	
$popInfo = $row;
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
	$imgSizeH = $popInfo[pop_height];-60;
	$isScroll = "style='overflow:hidden'";
}


?>
	

		<div id="m_popup<?=$row[pop_no]?>" style="position:absolute; z-index:998; display:none;  overflow:hidden;">
				
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

			<p style="background:#000000; color:#ffffff; position:relative;text-align:left;padding:7px 5px 5px 10px;margin:0;font-size:24px;height:48px;line-height:48px;">
				<input type="checkbox" id="popup_chk<?=$row[pop_no]?>" style="vertical-align:-2px;width:26px;height:26px;"
				onclick="if(this.checked) popup_setCookie($(this).parent().parent().attr('id'), 'no' , 1); else popup_setCookie($(this).parent().parent().attr('id'), 'no' , -1000);" />
				<label for="popup_chk<?=$row[pop_no]?>">오늘 하루 열지않기</label>
				<a style="position:absolute; right:25px; top:0; color:#ffffff; font-size:11px; display:block; padding:5px 0;font-size:24px;" href="#"
				onclick="$(this).parent().parent().hide(); return false;">닫기</a>
			</p>

		</div>




	<script>
		openPopup(<?=$row["pop_no"]?>, '<?=$row["pop_width"]?>', '<?=$row["pop_height"]?>', '<?=$row["pop_left"]?>', '<?=$row["pop_top"]?>', '<?=$row["pop_iscenter"]?>');
	</script>

<?}
