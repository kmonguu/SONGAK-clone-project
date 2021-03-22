<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once($g4[mpath]."/head.sub.php");
include_once($g4['path']."/lib/calendar.php");
set_session("ss_is_pc_view", "");

if($p){
$ppage=explode("_",$p);
	$pageNum=$ppage[0];
	$subNum=$ppage[1];
	$ssNum=$ppage[2];
	$tabNum=$ppage[3];
}

if($bo_table){
	$ppage=explode("_",$bo_table);
	$pageNum=$ppage[0];
	$subNum=$ppage[1];
	$ssNum=$ppage[2];
	$tabNum=$ppage[3];
}

$ca_temp = 0;
if(isset($it)){
	$ca_temp = 1;
	$ca_id = $it[ca_id2];
	if(!$it[ca_id2]) $ca_id = $it[ca_id];

}

if($ca_id){

	for($i=0; $i<strlen($ca_id); $i++) { 
		$str_cut[$i] = substr($ca_id,$i,1); 
	}
	if($str_cut[0] == "a") $str_cut[0] = 11;
	if($str_cut[0] == "b") $str_cut[0] = 12;
	if($str_cut[0] == "c") $str_cut[0] = 13;
	if($str_cut[0] == "d") $str_cut[0] = 14;
	if($str_cut[0] == "e") $str_cut[0] = 15;

	$pageNum = $str_cut[0]+1;
	$subNum = (strlen($ca_id) <= 2) ? 1 : $str_cut[2];
	$ssNum = (strlen($ca_id) <= 4) ? 1 : $str_cut[4];
	$tabNum = (strlen($ca_id) <= 6) ? 1 : $str_cut[6];

}


if($ca_temp == 1){
	unset($ca_id);
}

$tot=$pageNum."_".$subNum;
$tott=$pageNum."_".$subNum."_".$ssNum;

$cartcnt = get_cart_count(get_session("ss_on_uid"));

// 모바일 변수설정
$board_skin_mpath = $g4[mpath]."/skin/board/".$board[bo_skin];


//모바일 실시간채팅
$ninetalk_key = sql_fetch("SELECT site_key FROM ninetalk_site_key limit 0,1", false);
$talk_link = "location.href='".$g4["mpath"]."/ninetalk.php?site_key=".$ninetalk_key[site_key]."&return_url=".$_SERVER[HTTP_HOST].urlencode($_SERVER[REQUEST_URI])."'";



$menu = array();

$menu["pageNum"][1] = "인사말";

$menu["pageNum"][2] = "족욕의 효능";

$menu["pageNum"][3] = "카페";

$menu["pageNum"][4] = "이용·예약안내";

$menu["pageNum"][5] = "커뮤니티";
	$menu["tot"][5][1] = "공지사항";
	$menu["tot"][5][2] = "갤러리";

$menu["pageNum"][6] = "주변관광지";
		$menu["tot"][6][1] = "주변관광지";
			$menu["tott"][6][1][1] = "송악산";
			$menu["tott"][6][1][2] = "산방산";
			$menu["tott"][6][1][3] = "가파도";
			$menu["tott"][6][1][4] = "마라도";
			$menu["tott"][6][1][5] = "마라도 선착장";
			$menu["tott"][6][1][6] = "형제 해안로";
			$menu["tott"][6][1][7] = "올레 10코스";

		$menu["tot"][6][2] = "맛집";
			$menu["tott"][6][2][1] = "홍성방";
			$menu["tott"][6][2][2] = "거멍국수";
			$menu["tott"][6][2][3] = "산방산 횟집";
			$menu["tott"][6][2][4] = "제주 기장횟집";
			$menu["tott"][6][2][5] = "복태네 갈치탕";
			$menu["tott"][6][2][6] = "선채향";
			$menu["tott"][6][2][7] = "소라소라 감성술집";



?>


<?if(defined("__INDEX")){
//팝업관리
if(file_exists("$g4[path]/lib/popmng.mobile.lib.php")){ //모바일 팝업관리자 지원되는 셋팅버전인지 확인
	include_once("$g4[path]/lib/popmng.mobile.lib.php");
}
}?>


<script>
new WOW().init();
function gotoTop(){
	jQuery('html, body').animate( {scrollTop:0} ,300);
}
</script>

<!-- 전화걸기 스크립트 -->
<script type="text/javascript">

var callFlag = true;
function callNumber(num){   
   if(callFlag){
	   $.post("<?=$g4[mpath]?>/_ajax_call_log.php", null, function(){
		callFlag = false;
		location.href="tel:"+num;
	   });
   }
   setTimeout(function(){callFlag=true;}, 1000 * 3);
}
</script>

<div id="MenuArea" onclick="menuclose()">
</div>


<style type="text/css">
#MenuArea {position:fixed; width:100%; height:100%; left:0; top:0; background-color:#000000;filter:alpha(opacity=50);opacity:.7; z-index:9999; display:none;}
#MenuZone {position:absolute; width:550px;background:#fff; z-index:99999; display:none; left:-480px; background:#445c57;}

#Menu { position:relative; top:120px; }
#Menu > li { padding:50px 0 10px 60px; }
#Menu > li.on { border-bottom:1px solid rgba(255,255,255,.2); }

#Menu > li > a { color:#fff; font-size:30px; }
#Menu > li.on > a { padding-bottom:10px; border-bottom:2px solid #fff; }

</style>

<script type="text/javascript">
	function menu(){
		jQuery("#MenuZone").height(jQuery("#wrap").height());
		jQuery("#MenuArea").show();
		jQuery("#MenuZone").show();
		jQuery("#MenuZone").animate({left:"0"});
	}
	function menuclose(){
		jQuery("#MenuArea").hide();
		jQuery("#MenuZone").animate({left:"-450px"}, function(){jQuery("#MenuZone").hide();});
	}
</script>

<div id="wrap">

	<div id="MenuZone">
		<div style="background:url('/m/images/menu/menu_bg.jpg') no-repeat center top; height:1020px;">
			<img src="/m/images/menu/menu_close.png" style="position:absolute; right:55px; top:42px;" onclick="menuclose()" alt="메뉴닫기">

			<ul id="Menu" >
				<?foreach($menu["pageNum"] as $pn=>$pnStr) {?>
					
					<li <?=$pageNum == $pn? "class='on'" : ""?>>
						<a href="#menum" onclick="menum('menu<?=sprintf("%02d", $pn)?>-1')" ><?=$pnStr?></a>
						
					</li>

				<?}?>
			</ul>
		</div>
	</div>
	
	<header>
		<img src="/m/images/top/menu_open.jpg" class="menu" onclick="menu()" alt="메뉴오픈">
		<img src="/m/images/top/ci.png" class="ci" onclick="home()" alt="로고">		
	</header>

	

	<div id="menu_cover_area">
		<?if(!defined("__INDEX")){?>

			<?
			$subcount;
			if($pageNum == "1"){
				$subcount = 2;
			}else if($pageNum == "2"){
				$subcount = 4;
			}else if($pageNum == "3"){
				$subcount = 1;
			}else if($pageNum == "4"){
				$subcount = 1;
			}else if($pageNum == "5"){
				$subcount = 2;
			}else if($pageNum == "100"){
				$subcount = 0;
			}
			?>
			<script type="text/javascript">
			$(function(){

				var a = new Array();					var b = new Array();
				a["a1_1"] = "인사말";						b["b1"] = "二代약초건강원";
				a["a1_2"] = "오시는 길";

				a["a2_1"] = "칡즙";							b["b2"] = "상품소개";
				a["a2_2"] = "배+도라지즙";
				a["a2_3"] = "양파즙";
				a["a2_4"] = "자색양파즙";

				a["a3_0"] = "전체상품";
				a["a3_1"] = "칡즙";							b["b3"] = "구매하기";
				a["a3_2"] = "배+도라지즙";
				a["a3_3"] = "양파즙";
				a["a3_4"] = "자색양파즙";

				a["a4_1"] = "산행이야기";					b["b4"] = "산행이야기";

				a["a5_1"] = "공지사항";						b["b5"] = "고객센터";
				a["a5_2"] = "문의하기";

				a["a100_1"] = "로그인";						b["b100"] = "二代약초건강원";
				a["a100_2"] = "정보수정";
				a["a100_3"] = "회원가입";
				a["a100_5"] = "장바구니";
				a["a100_6"] = "My Page";
				a["a100_7"] = "개인정보처리방침";
				a["a100_8"] = "이용약관";
				a["a100_9"] = "주문배송조회";
				a["a100_10"] = "주문상세내역";
				a["a100_11"] = "주문하기";
				a["a100_12"] = "주문 확인 및 결제";
				a["a100_13"] = "주문완료";
				a["a100_14"] = "주문내역";
				a["a100_15"] = "상품검색";
				a["a100_16"] = "이메일무단수집거부";
				a["a100_17"] = "결제완료";
				a["a100_18"] = "관심상품";

				var tit_a = a["a<?=$tot?>"];
				var tit_b = b["b<?=$pageNum?>"];

				$(".ru1, .bt1").html(tit_b); //대메뉴
				$(".st1, .st4, .ru2, .st2").html(tit_a); //소메뉴

				for (var t=1; t<="<?=$subcount?>";t++ ){
					var tablist = a["a<?=$pageNum?>_"+t];
					$("#tab_li_"+t+" span").html(tablist);
				}
				
				

			});
			</script>

			<section class="content">
				<?
					$pageCheck = ($pageNum==5 || $pageNum==100) ? true : false;		

					if(file_exists("{$g4['path']}/m/images/subvisual/s{$p}.jpg"))				$Svisual = "s{$p}";
					else if(file_exists("{$g4['path']}/m/images/subvisual/s{$bo_table}.jpg"))	$Svisual = "s{$bo_table}";
					else if(file_exists("{$g4['path']}/m/images/subvisual/s{$tott}.jpg"))		$Svisual = "s{$tott}";
					else if(file_exists("{$g4['path']}/m/images/subvisual/s{$tot}.jpg"))		$Svisual = "s{$tot}";
					else if(file_exists("{$g4['path']}/m/images/subvisual/s{$pageNum}.jpg"))	$Svisual = "s{$pageNum}";
					else																		$Svisual = "s0";
				?>
					<div class="subvisual parallax-window" data-parallax="scroll" data-image-src="/m/images/subvisual/<?=$Svisual?>.jpg" style="height:<?=$pageCheck ? '500' : '1020'?>px">
						
						<img src="/m/images/subvisual/title/<?=$pageNum.'_'.$subNum?>.png"
						<?=$pageNum==2 ? "style='left:-163px; top:20%;'" : ""?>/>

						<? if($pageNum==5) {?>
							<div style="position:absolute; right:0; left:0; bottom:0; margin:0 auto; width:600px; height:70px; background:#fff; border-radius:5px 5px 0 0; ">
								<ul id="subMenu">
									<?foreach($menu["tot"][$pageNum] as $sn=>$snStr) {?>
										<li  <?=$tot == $pageNum."_".$sn ? "class='on'" : ""?>><a href="#menum" onclick="menum('menu<?=sprintf("%02d", $pageNum)?>-<?=$sn?>')" ><?=$snStr?></a></li>
									<?}?>
								</ul>
							</div>
						<?}?>
					</div>
				

				


			</section>
					<?if($bo_table){?>
				<div class="boardarea">
			<?}?>
		<?}?>

