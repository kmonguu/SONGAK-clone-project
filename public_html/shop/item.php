<?
include_once("./_common.php");

if(USE_MOBILE) { //config.php
	if($default["de_npay_use"]){ //네이버페이 사용 시
		//모바일로 상품정보 확인시, 모바일 상품정보로 이동
		$arr_browser = array ("iPhone","iPod","IEMobile","Mobile","lgtelecom","PPC","iphone","ipod","android","blackberry","windows ce","nokia","webos","opera mini","sonyericsson","opera mobi","iemobile");
		for($indexi = 0 ; $indexi < count($arr_browser) ; $indexi++) {
			if(stripos($_SERVER['HTTP_USER_AGENT'],$arr_browser[$indexi]) == true){
				if($_SERVER["QUERY_STRING"]!=''){$param ="?".$_SERVER["QUERY_STRING"];}else{$param = '';}
				header("Location: http://{$_SERVER["HTTP_HOST"]}/m{$_SERVER["PHP_SELF"]}{$param}");
				exit;
			}
		}
	}
}


// 불법접속을 할 수 없도록 세션에 아무값이나 저장하여 hidden 으로 넘겨서 다음 페이지에서 비교함
$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

$rand = rand(4, 6);
$norobot_key = substr($token, 0, $rand);
set_session('ss_norobot_key', $norobot_key);

// 조회수 증가
if ($_COOKIE[ck_it_id] != $it_id) {
    sql_query(" update $g4[yc4_item_table] set it_hit = it_hit + 1 where it_id = '$it_id' "); // 1증가
    setcookie("ck_it_id", $it_id, time() + 3600, $config[cf_cookie_dir], $config[cf_cookie_domain]); // 1시간동안 저장
}

// 분류사용, 상품사용하는 상품의 정보를 얻음
$sql = " select a.*,
                b.ca_name,
                b.ca_use
           from $g4[yc4_item_table] a,
                $g4[yc4_category_table] b
          where a.it_id = '$it_id'
            and a.ca_id = b.ca_id ";
$it = sql_fetch($sql);
if (!$it[it_id])
    alert("자료가 없습니다.");
if (!($it[ca_use] && $it[it_use])) {
    if (!$is_admin)
        alert("판매가능한 상품이 아닙니다.");
}

// 분류 테이블에서 분류 상단, 하단 코드를 얻음
$sql = " select ca_include_head, ca_include_tail
           from $g4[yc4_category_table]
          where ca_id = '$it[ca_id]' ";
$ca = sql_fetch($sql);
$g4[title] = "상품 상세보기 : $it[ca_name] - $it[it_name] ";

// 분류 상단 코드가 있으면 출력하고 없으면 기본 상단 코드 출력
if ($ca[ca_include_head])
    @include_once($ca[ca_include_head]);
else
    include_once("./_head.php");

// 상단 HTML
echo stripslashes($ca[ca_head_html]);
?>

<style>
.cartBtn {background:#4b4b4b;color:#ffffff;padding:5px 8px;line-height:23px;border:1px solid #1b1b1b;font-size:11px;}
.cartBtn:hover {background:#ffffff;color:#000000;padding:5px 8px;line-height:23px;border:1px solid #1b1b1b;font-size:11px;}
.shop_btns a:hover {text-decoration:none;}
.vleft_img {width:560px; margin:0px 0 0 0px; float:left; display:inline-block;  }
.vimg { display:block; width:560px; height:560px; position:relative; border:1px solid #e1e1e1; }
.thum_img { margin-top:9px; padding:0; height:65px; width:auto; text-align:center }
.thum_img img { width:60px; height:60px; border:1px solid #c0c0c0; margin:0 4px; display:inline-block }
.vright { float:left; width:570px; margin:0px 0px 0 50px; display:inline-table; font-family:"Noto Sans KR"; text-align:left; font-weight:300; position:relative; }
#zoom_area { position:absolute; left:-37px; top:-2px; width:400px; height:400px; background:rgba(0,0,0,0.2); display:none; overflow:hidden; border:3px solid gray;}

/***/
select:focus {
   /*  background:red;  */
}

.vright > div { display:table-cell; vertical-align:top; }
.vright h3 { padding:0; font-size:38px; color:#000000; line-height:44px; display:block; }
.it_basic { font-size:16px; color:#b8b8b8; font-weight:400; line-height:25px; margin-bottom:25px; }
.vright_con { width:100%; color:#4b4b4b; border-top:1px solid #cccccc; border-bottom:1px solid #cccccc; padding:40px 0; }
.vright_con th { padding:5px 0 5px 10px; text-align:left; font-size:16px; color:#414141; }
.vright_con_title { font-weight:bold; text-align:left; font-size:16px; color:#414141; width:78.5%; }
.vright_con td { padding:5px 0 5px 0px; vertical-align:top;font-size:14px;  }

.cnt_amount { display:inline-block; width:100%; margin:30px 0 30px; }

.v_btn { padding:0px 0 0 0; list-style:none; width:100%; display:inline-block; }
.v_btn li { float:left; }
.v_btn li img { display:block; }
.v_btn li a { text-decoration:none; }

.vbanner { float:right; position:relative; display:inline-block; }
.vbanner .v_left { position:absolute; right:24px; top:0px; cursor:pointer; }
.vbanner .v_right { position:absolute; right:0px; top:0px; cursor:pointer; }

.pro_btn { width:183px; height:43px; text-align:center; line-height:40px; font-size:16px; }

.btn_buy { border:1px solid #4a4a4a; color:#fff; background:#4a4a4a; }
.btn_buy:hover { background:#ff9c00; border:1px solid #ff9c00; }
.ather_btn { border:1px solid #b0b0b0; color:#555; }
.ather_btn:hover { border:1px solid #333; }

.product_icon { width:100%; height:20px; text-align:right; }

.wrap-footer { margin-bottom:85px; }
</style>

<? 
if ($is_admin) {
    echo "<p align=center class='shop_btns'><a href='$g4[shop_admin_path]/itemform.php?w=u&it_id=$it_id'><span class='cartBtn'>&nbsp;&nbsp;관리자 화면에서 수정하기&nbsp;&nbsp;</span></a></p>";
}
?>

<script>
$(function(){
	$(".item_name").html("<?=$it[it_name]?>");
});
</script>




<div style="width:1200px; margin:0 auto;">

<script language="JavaScript" src="<?=$g4[path]?>/js/shop.js"></script>
<script language="JavaScript" src="<?=$g4[path]?>/js/md5.js"></script>

<form name=fitem method=post  action="./cartupdate.php" style="position:relative; width:100%; display:inline-block; margin-top:40px;">
<input type=hidden name=it_id value='<?=$it[it_id]?>'>
<input type=hidden name=it_name value='<?=$it[it_name]?>'>
<input type=hidden name=sw_direct>
<input type=hidden name=url>



    <!-- 상품중간이미지 -->
	<?
	$middle_image = $it[it_id]."_m";
	$image_url = "";
	$domain = explode(":", $_SERVER[HTTP_HOST]);
	if(is_file("$g4[path]/data/item/{$it_id}_l1")) $image_url = "http://".$domain[0]."/data/item/{$it_id}_l1";
	if(is_file("$g4[path]/data/item/{$it_id}_m")) $thumb_url = "http://".$domain[0]."/data/item/{$it_id}_m";
	if(is_file("$g4[path]/data/item/{$it_id}_s")) $thumb_url = "http://".$domain[0]."/data/item/{$it_id}_s";
	if(!$thumb_url) $thumb_url = $image_url;
	?>
	
	<div class="vleft_img"> 
		
		<div class="vimg">
			 <div id="vimgbox" style="display:none;width:200px;height:200px; border:3px solid gray; position:absolute;z-index:99; background:rgba(255,255,255,0.4)">
				&nbsp;
			</div> 
			<!-- 상품 이미지 사이즈는 560*560 -->
			<?=get_it_image($middle_image,'560','560')?>
		</div>

		<!-- 상품이미지 썸네일 -->
		<div class="thum_img">
			<?
			for ($i=1; $i<=5; $i++)
			{
				if (file_exists("$g4[path]/data/item/{$it_id}_l{$i}"))
				{
					echo get_large_image("{$it_id}_l{$i}", $it[it_id], false);
					if ($i==1 && file_exists("$g4[path]/data/item/{$it_id}_m"))
						echo "<img id='middle{$i}' src='$g4[path]/data/item/{$it_id}_m' border=0 width=60 height=60 style='border:1px solid #E4E4E4;' ";
					else
						echo "<img id='middle{$i}' src='$g4[path]/data/item/{$it_id}_l{$i}' border=0 width=60 height=60 style='border:1px solid #E4E4E4;' ";
					echo " onmouseover=\"document.getElementById('$middle_image').src=document.getElementById('middle{$i}').src;\">";
					echo "</a> &nbsp;";
				}
			}
			?>
		</div>

	</div>
	<!--		
		<script type="text/javascript">
			var zoomlv = 2.5;
			$(function(){
				$( ".vimg" ).mouseenter(function(event) {
					
					var posT = ((event.pageY-$(this).offset().top) * zoomlv) * -1;
					var posL = ((event.pageX-Math.floor($(this).offset().left)) * zoomlv) * -1;

					var iw = $(this).width() * zoomlv;
					var ih = $(this).height() * zoomlv;

					var now_src = $(this).find("img").attr("src");
					$("#zoom_area").show().html("<img src='"+now_src+"'style='width:"+iw+"px; height:"+ih+"px; position:absolute; left:"+posL+"px; top:"+posT+"px;'/>");
					$("#vimgbox").show();
					
					var zbw = $(this).width() / zoomlv;
					var zbh = $(this).height() / zoomlv;
					$("#vimgbox").css({width:zbw+"px", height:zbh+"px"});
					//console.log(now_src);
				});

				$( ".vimg" ).mouseleave(function() {
					$("#zoom_area").hide();
					$("#vimgbox").hide();
				});

				$( ".vimg" ).mousemove(function( event ) {
					
					var msg = "Handler for .mousemove() called at ";
					msg += (event.pageX-Math.floor($(this).offset().left)) + ", " + (event.pageY-$(this).offset().top);
					$( "#log" ).html( "<div>" + msg + "</div>" );
					
			
					var posT = (event.pageY-$(this).offset().top);
					var posL = (event.pageX-Math.floor($(this).offset().left));
					
					var offsetL = ($("#vimgbox").width() / zoomlv);
					var offsetT = ($("#vimgbox").height() / zoomlv)

					var top = posT - offsetT;
					var left = posL - offsetL;
					
					if(top < 0) {
						top = 0;
					}

					if(left < 0) {
						left = 0;
					}

					var imgW = $(this).width();
					var imgH = $(this).height();

					if(left + $("#vimgbox").width() > imgW){
						//left = imgW - $("#vimgbox").width()-6;
						left = imgW - $("#vimgbox").width()-6;
					}

					if(top + $("#vimgbox").height() > imgH){
						//top = imgH - $("#vimgbox").height()-6;
						top = imgH - $("#vimgbox").height()-6;
					}

					$("#vimgbox").css({"top":top, "left":left});

					
					var imgMoveT = (top * zoomlv) * -1;
					var imgMoveL = (left  * zoomlv) * -1;

					$("#zoom_area").find("img").css({"left":imgMoveL+"px", "top":imgMoveT+"px"});

				});
			});
		</script>
	-->
	<!-- 상품중간이미지 END -->
	<div class="product_icon">

			<!-- ITEM TYPE ICON -->
			<?for($idx = 1 ; $idx <= 5; $idx++) {?><?if($it["it_type{$idx}"]) {?><div class="icon_item_type<?=$idx?>"><?=Yc4::$IT_TYPE[$idx]?></div><?}?><?}?>
			
	</div>
    <div class="vright" >
			
		<div id="zoom_area"></div>
			
		<div >

			<h3><?=$it[it_name]?></h3>

			<p class="it_basic"><?=$it[it_basic]?></p>

			<table border="0" cellspacing="0" cellpadding="0" class="vright_con">
				<colgroup>
					<col width="90px" />
					<col width="" />
				</colgroup>



				<?/******* 갤러리/전화문의 상품은 표시 안하는 부분 **********/?>
				<? if (!$it[it_tel_inq] && !$it[it_gallery]) { ?>
					<tr>
						<th>상품가격</th>
						<td>
							<font style="color:#e30413; font-size:16px; font-weight:400;"><?=display_amount(get_amount($it), $it[it_tel_inq])?></font>
						</td>
					</tr>
					
					<? if ($config[cf_use_point]) { // 포인트 사용한다면 ?>
						<tr>
							<th>적립금</th>
							<td>
								<input type=text name=disp_point style='width:35px; text-align:left; border:none; border-width:0px; color:#e30413;' readonly>
								<input type=hidden name=it_point value='0'>
							</td>
						</tr>
					<? } ?>
				<?}?>
				<?/******* 갤러리/전화문의 상품은 표시 안하는 부분 끝 **********/?>



				<? if ($it[it_maker]) { ?>
					<tr>
						<th>제조사</th>
						<td><?=$it[it_maker]?></td>
					</tr>
				<? } ?>

				<? if ($it[it_origin]) { ?>
					<tr>
						<th>원산지</th>
						<td><font style="font-size:16px; color:#555; font-weight:400;"><?=$it[it_origin]?></font></td>
					</tr>

				<? } ?>



				<?
				// 옵션 텍스트 출력 
				// ** 추가옵션필드 중 단순 택스트 항목(선택이 없는)만 출력하는 부분
				$add_options = "";
				for ($i=1; $i<=6; $i++)
				{
					// 옵션에 문자가 존재한다면
					$str = get_item_options(trim($it["it_opt{$i}_subject"]), trim($it["it_opt{$i}"]), $i);
					if(trim($it["it_opt{$i}"]) != $str) continue; //선택추가옵션은 제외
					if ($str)
					{
						$add_options .=  "<tr>";
						$add_options .=  "<th scope='row' class='subject_add_option'>".$it["it_opt{$i}_subject"]."</th>";
						$add_options .=  "<td class='option_td'>$str</td>";
						$add_options .=  "</tr>";
					}
				}
				if($add_options != "") {
					echo "
					<tr>
						<td colspan='2'>
							<hr style='border:0px; border-bottom:1px solid #efefef;'/>
						</td>
					</tr>
					";
				}
				echo $add_options;
				?>

				



				<?/******* 갤러리/전화문의 상품은 표시 안하는 부분 **********/?>
				<? if (!$it[it_tel_inq] && !$it[it_gallery]) { ?>


				<?
				//선택옵션이 존재한다면
				if($it["it_option1_subject"] != ""){?>
					<tr>
						<td colspan='2'>
							<hr style='border:0px; border-bottom:1px solid #efefef;'/>
						</td>
					</tr>
					<tr>
						<th>선택옵션</th>
						<td>
						</td>
					</tr>
		
					<tr>
						<th class='subject_add_option'><?=$it["it_option1_subject"]?></th>
						<td>
							<select name="io_type1" id="io_type1" class="slt_add_option" onchange="change_io_type1()">
								<option value="">선택</option>
							</select>
						</td>
					</tr>

					<?if($it["it_option2_subject"] != ""){?>
						<tr>
							<th class='subject_add_option'><?=$it["it_option2_subject"]?></th>
							<td>
								<select name="io_type2" id="io_type2" class="slt_add_option" onchange="change_io_type2()" disabled>
									<option value="">선택</option>
								</select>
							</td>
						</tr>


						<?if($it["it_option3_subject"] != ""){?>
							<tr>
								<th class='subject_add_option'><?=$it["it_option3_subject"]?></th>
								<td>
									<select name="io_type3" id="io_type3" class="slt_add_option" onchange="change_io_type3()" disabled>
										<option value="">선택</option>
									</select>
								</td>
							</tr>
						<?}?>
					<?}?>

				<?} else {?>

					<script>
						$(function(){
							make_options(); //옵션 없는 상품 생성
						});
					</script>

				<?}?>
			
				
				<tr>
					<td colspan='2'>
						<hr style='border:0px; border-bottom:1px solid #efefef;'/>
					</td>
				</tr>
				

				<? 
				// 선택 옵션이 표시되는 부분 
				// 선택 옵션이 없는 경우, 수량이 표시되는 부분 
				// item_option_make.php
				?>
				<tr>
					<td colspan="2" class="optlist" style="padding-left:10px;">

							<div class="option_none_select" style="display:inline-block; width:100%;" >
								<div class="opt_name" >
								- 옵션을 선택해주세요.
								</div>							
							</div>

					</td>
				</tr>



				<?}?>
				<?/******* 갤러리/전화문의 상품은 표시 안하는 부분 끝**********/?>
				
			</table>
			





			<? if (!$it[it_tel_inq] && !$it[it_gallery]) { //갤러리 / 전화문의 체크 ?>

				<div class="cnt_amount">
					<div style='color:#515151; font-weight:400; font-size:16px; float:right;'>
						총 금액 :
						<span style='color:#e30413; font-weight:700; font-size:25px; ' id=disp_sell_amount></span>
					</div>
					<input type=hidden name=it_amount value='0'>
				</div>

			<?}else{?>

				<div class="cnt_amount">
					<div style='color:#515151; font-weight:400; font-size:16px; float:right;'>
						<span style='color:#e30413; font-weight:700; font-size:25px;'><?=$it[it_tel_inq] ? "전화문의" : ""?></span>
					</div>
					<input type=hidden name=it_amount value='0'>
				</div>

			<?}?>





			<ul class="v_btn">

				<?/******* 갤러리/전화문의 상품은 표시 안하는 부분 **********/?>
				<? if (!$it[it_tel_inq] && !$it[it_gallery]) { ?>
				<li style="margin:0 0 0 0px">
					<a href="javascript:void(0)" onclick="fitemcheck(document.fitem, 'direct_buy');" id="buy_btn" >
						<div class="btn_buy pro_btn">
							<i class="far fa-credit-card"></i>	구매하기
						</div>
					</a>
				</li>
				<li style="margin:0 0 0 7px">
					<a href="javascript:void(0)" onclick="fitemcheck(document.fitem, 'cart_update');" id="cart_btn" >
						<div class="ather_btn pro_btn">
							<i class="fas fa-shopping-cart"></i> 장바구니
						</div>
					</a>
				</li>
				<?}?>
				<?/******* 갤러리/전화문의 상품은 표시 안하는 부분 끝**********/?>


				<?
				$list_ca_id = get_session("ss_ca_id"); //마지막으로 확인한 목록의 ca_id
				if(!$list_ca_id) {
					if($it[ca_id3])	$list_ca_id = $it[ca_id3];
					else if($it[ca_id2]) $list_ca_id = $it[ca_id2];
					else if($it[ca_id])	$list_ca_id = $it[ca_id];
				}
				?>
				<li style="margin:0 0 0 7px">
					<div class="ather_btn pro_btn list_btn" style="cursor:pointer;" onclick="location.href='./list.php?ca_id=<?=$list_ca_id?>';">
						<i class="fas fa-list"></i>	목록보기
					</div>
				</li>

			</ul>



		</div>
	</div>




	
	<?/******* 네이버페이 **********/?>
	<? if (!$it[it_tel_inq] && !$it[it_gallery]) { ?>
		<?if($default["de_npay_use"]){?>
			<style>
				.npaybtn{
					position:relative; 
					float:right; 
					padding:20px 10px 10px 50px; 
					width:570px; 
					text-align:right;
				}
			</style>
			<div class="npaybtn">
				<?include_once("{$g4["shop_path"]}/item_npay_btn.php")?>
			</div>
		<?}?>
	<?}?>
	<?/******* 네이버페이 끝 **********/?>


</form>



<!-- 상품정보 -->
<style>
.item_ex_tab { display:inline-block; width:100%; margin:30px 0; position:relative; }
.item_ex_tab > li { display:inline-block; width:25%; height:55px; line-height:53px; text-align:center; box-sizing:border-box; border:1px solid #bfbfbf; border-left:0px; float:left; }
.item_ex_tab > li:first-child { border-left:1px solid #bfbfbf; }
.item_ex_tab > li.on { border:1px solid #bfbfbf; border-bottom:3px solid #363636; border-left:0; }
.item_ex_tab > li.on:first-child { border-left:1px solid #bfbfbf; }
.item_ex_tab > li > a { display:inline-block; width:100%; height:100%; text-decoration:none; color:#222; font-size:15px; font-weight:300; }
.item_ex_tab > li > a > span { color:#222; }

.div_explan { position:relative; width:100%; margin:0 auto 50px; box-sizing:border-box; }
.div_explan ul { list-style-type:disc; list-style-position:inside; list-style:initial; margin:initial; padding: 0 0 0 40px;  }
.div_explan li { margin:initial; display:list-item; }
.div_explan img { width:950px !important; display:block; margin:0 auto; }
a.it_btn { position:absolute; width:200px; height:50px; line-height:50px; text-align:center; text-decoration:none; font-size:18px; }

table.return_table { border-top:1px solid #e7e7e7;  }
.return_table th { text-align:left; font-size:14px; color:#515151; font-weight:300; padding:13px 0 13px 15px; background:#f7f7f7; vertical-align:top; border:1px solid #e7e7e7; border-top:0px; }
.return_table td { text-align:left; font-size:14px; color:#515151; font-weight:300; padding:13px 0 13px 15px; border:1px solid #e7e7e7; border-top:0px; border-left:0px; }
.return_table td p { font-size:14px; color:#515151; font-weight:300; }
.return_table td span.red { color:#df4141; }
</style>

<ul class="item_ex_tab">
	<li class="on"><a href="javascript:go_block('explan')">상품상세정보</a></li>
	<li><a href="javascript:go_block('sand')">배송안내</a></li>
	<li><a href="javascript:go_block('change_content')">교환/반품안내</a></li>
	<li><a href="javascript:go_block('after')">생생후기</a></li>
	<div style="position:absolute; left:0; top:-150px;" class="explan"></div>
</ul>

<? if(trim(str_replace("&nbsp;", "", strip_tags($it[it_explan], "<img>"))) != ""){ ?>
	<div class='div_explan' style="" >
		
		<?if( $it["it_btn_link"] && $it["it_btn_name"] ){?>
			<a href="<?=$it["it_btn_link"]?>" target="<?=$it["it_btn_target"]?>" class="it_btn" style="left:<?=$it["it_btn_left"]?>px; top:<?=$it["it_btn_top"]?>px; color:#<?=$it["it_btn_color"]?>; background-color:#<?=$it["it_btn_bg"]?>;" ><?=$it["it_btn_name"]?></a>
		<?}?>

		<?=conv_content($it[it_explan], 1);?>
	</div>
<? } ?>


<style>
.RoomBox02 { width:100%; margin:0px auto 50px; border:1px solid #e7e7e7; padding:20px 0 20px 0; display:inline-block; }
.RoomBox02In {color:#5f5f5f;padding:0 20px 0 20px;}
</style>



<ul class="item_ex_tab ">
	<li><a href="javascript:go_block('explan')">상품상세정보</a></li>
	<li class="on" ><a href="javascript:go_block('sand')">배송안내</a></li>
	<li><a href="javascript:go_block('change_content')">교환/반품안내</a></li>
	<li><a href="javascript:go_block('after')">생생후기</a></li>
	<div style="position:absolute; left:0; top:-150px;" class="sand"></div>
</ul>

<? if (trim(str_replace("&nbsp;", "", strip_tags($default[de_baesong_content], "<img>"))) != "") { ?>
	<div class='div_explan' >
		<?=conv_content($default[de_baesong_content], 1);?>
	</div>
<?}?>


<ul class="item_ex_tab ">
	<li><a href="javascript:go_block('explan')">상품상세정보</a></li>
	<li><a href="javascript:go_block('sand')">배송안내</a></li>
	<li class="on" ><a href="javascript:go_block('change_content')">교환/반품안내</a></li>
	<li><a href="javascript:go_block('after')">생생후기</a></li>
	<div style="position:absolute; left:0; top:-150px;" class="change_content"></div>
</ul>

<? if (trim(str_replace("&nbsp;", "", strip_tags($default[de_change_content], "<img>"))) != "") { ?>
	<div class='div_explan' >
		<!-- <p style="font-size:18px; color:#1c1c1c; font-weight:500; padding:0 0 15px 10px;" >배송/교환/반품</p>-->
		<?=conv_content($default[de_change_content], 1);?> 
	</div>
<?}?>

<? if (trim(str_replace("&nbsp;", "", strip_tags($default[de_change_content], "<img>"))) != "" && false) { ?>
	<div style="width:100%; height:30px; font-size:18px; color:#010101; font-weight:bold; border-bottom:1px solid #7f7f7f; margin:0 auto 20px;">
		<span style="margin-left:20px;">교환/반품안내</span>
	</div>
	
	<div class='div_explan' style="margin:0 auto 30px;" >
		<?=conv_content($default[de_change_content], 1);?>
	</div>
<?}?>

<ul class="item_ex_tab ">
	<li><a href="javascript:go_block('explan')">상품상세정보</a></li>
	<li><a href="javascript:go_block('sand')">배송안내</a></li>
	<li><a href="javascript:go_block('change_content')">교환/반품안내</a></li>
	<li class="on" ><a href="javascript:go_block('after')">생생후기</a></li>
	<div style="position:absolute; left:0; top:-150px;" class="after"></div>
</ul>

<?
	// 사용후기
	include_once("./afterlist.php");
?>

<?
	// 사용후기
	include_once("./qnalist.php");
?>

<!-- 
<img src="/res/images/aa.jpg" style="display:block; margin:0 auto 80px;" />
 -->
<!-- 상품정보 end -->
<div style="height:50px;">
</div>


<!-- 배송정보
<? //if ($default[de_baesong_content]) { // 배송정보 내용이 있다면 ?>

<div id='item_baesong' style='display:block;'>
<table width=100% cellpadding=0 cellspacing=0>
<tr><td rowspan=2 width=31 valign=top bgcolor=#D6E1A7><img src='<?//=$g4[shop_img_path]?>/item_t04.gif'></td><td height=2 bgcolor=#D6E1A7></td></tr>
<tr><td style='padding:15px' height=130><?//=conv_content($default[de_baesong_content], 1);?></td></tr>
<tr><td colspan=2 height=1></td></tr>
</table>
</div>

<? //} ?>
배송정보 end -->

<!-- 교환/반품
<? //if ($default[de_change_content]) { // 교환/반품 내용이 있다면 ?>

<div id='item_change' style='display:block;'>
<table width=100% cellpadding=0 cellspacing=0>
<tr><td rowspan=2 width=31 valign=top bgcolor=#F6DBAB><img src='<?//=$g4[shop_img_path]?>/item_t05.gif'></td><td height=2 bgcolor=#F6DBAB></td></tr>
<tr><td style='padding:15px' height=130><?//=conv_content($default[de_change_content], 1);?></td></tr>
<tr><td colspan=2 height=1></td></tr>
</table>
</div>

<? //} ?>
교환/반품 end -->



</td></tr></table>




<script type="text/javascript">

function qty_keyup(obj){
	var qtyObj = $(obj).closest(".option_item").find(".ct_qty");
	var qty = parseInt(qtyObj.val());
	var max = parseInt($(obj).closest(".option_item").data("qty"));
	if(qty > max){
		alert("재고 수량이 부족합니다.");
		qtyObj.val(max);
	}
	amount_change();
}

function qty_add(obj, num)
{
    var f = document.fitem;
	var qtyObj = $(obj).closest(".option_item").find(".ct_qty");
    var qty = parseInt(qtyObj.val());
	var max = parseInt($(obj).closest(".option_item").data("qty"));
    if (num < 0 && qty <= 1)
    {
        alert("수량은 1 이상만 가능합니다.");
        qty = 1;
    }
    else if (num > 0 && qty >= 9999)
    {
        alert("수량은 9999 이하만 가능합니다.");
        qty = 9999;
    }
    else
    {
        qty = qty + num;
    }
	
	if(num > 0 && qty > max){
		alert("재고 수량이 부족합니다.");
        qty = max;
	}

    qtyObj.val(qty);

    amount_change();
}

function get_amount(data)
{
    var str = data.split(";");
    var num = parseInt(str[1]);
    if (isNaN(num)) {
        return 0;
    } else {
        return num;
    }
}

function get_amount_point(data)
{
    var str = data.split(";");
    var num = parseInt(str[2]);
    if (isNaN(num)) {
        return 0;
    } else {
        return num;
    }
}

function amount_change()
{
    var basic_amount = parseInt('<?=get_amount($it)?>');
    var basic_point  = parseFloat('<?=$it[it_point]?>');
    var cust_amount  = parseFloat('<?=$it[it_cust_amount]?>');

    var f = document.fitem;
    var opt1 = 0;
    var opt2 = 0;
    var opt3 = 0;
    var opt4 = 0;
    var opt5 = 0;
    var opt6 = 0;

	var opt21 = 0;
    var opt22 = 0;
    var opt23 = 0;
    var opt24 = 0;
    var opt25 = 0;
    var opt26 = 0;
    var ct_qty = 0;

	$(".ct_qty").each(function(){
		var q = parseInt($(this).val());
		ct_qty += q;
	});
	if(ct_qty == 0) ct_qty=1;

	//상품옵션 가격
	var optAmt = 0;
	$(".ct_qty").each(function(){
		var q = parseInt($(this).val());
		if($(this).closest(".option_item").find(".io_amt").val() != "") {
			var oa = parseInt($(this).closest(".option_item").find(".io_amt").val());
			optAmt += (oa * q);
		}
	});

	$(".option_item").each(function(){
		var q = parseInt($(this).find(".ct_qty").val());
		$(this).find(".it_opt1").each(function(){ opt1 += get_amount($(this).val()) * q; opt21 += get_amount_point($(this).val()) * q; });
		$(this).find(".it_opt2").each(function(){ opt2 += get_amount($(this).val()) * q; opt22 += get_amount_point($(this).val()) * q; });
		$(this).find(".it_opt3").each(function(){ opt3 += get_amount($(this).val()) * q; opt23 += get_amount_point($(this).val()) * q; });
		$(this).find(".it_opt4").each(function(){ opt4 += get_amount($(this).val()) * q; opt24 += get_amount_point($(this).val()) * q; });
		$(this).find(".it_opt5").each(function(){ opt5 += get_amount($(this).val()) * q; opt25 += get_amount_point($(this).val()) * q; });
		$(this).find(".it_opt6").each(function(){ opt6 += get_amount($(this).val()) * q; opt26 += get_amount_point($(this).val()) * q; });
	});
	


    var amount = basic_amount;
	var point  = parseInt(basic_point);
	
	var opt = opt1 + opt2 + opt3 + opt4 + opt5 + opt6;
	var opp = opt21 + opt22 + opt23 + opt24 + opt25 + opt26;



    if (typeof(f.it_amount) != 'undefined')
        f.it_amount.value = amount + optAmt  + opt;

    if (typeof(jQuery("#disp_sell_amount")) != 'undefined'){
		var amount1 = String(amount * ct_qty + optAmt + opt) ;
		jQuery("#disp_sell_amount").html(number_format(amount1)+"원");
		jQuery("#disp_sell_amount_fixed").html(number_format(amount1)+"원");
	}

    if (typeof(f.disp_cust_amount) != 'undefined')
        f.disp_cust_amount.value = number_format(String(cust_amount * ct_qty + optAmt + opt));

    if (typeof(f.it_point) != 'undefined') {
        f.it_point.value = point;
        f.disp_point.value = number_format(String( point * ct_qty +opp ));
    }
}

<? if (!$it[it_gallery]) { echo "amount_change();"; } // 처음시작시 한번 실행 ?>


function validate(){
	var f = document.fitem;
	// 판매가격이 0 보다 작다면
    if (f.it_amount.value < 0)
    {
        alert("전화로 문의해 주시면 감사하겠습니다.");
        return false;
	}

	var is_qty = true;
	$(".ct_qty").each(function(){
		if(parseInt($(this).val()) <= 0){
			is_qty = false;
		}
	});
	if(!is_qty){
		//alert("수량이 0개인 상품이 있습니다. 수량을 조절해주세요.");
		custom_alert(400, "수량이 0개인 상품이 있습니다. 수량을 조절해주세요.");
		return false;
	}
	if($(".option_item").size() == 0) {
		//alert("상품의 선택옵션을 선택해 주십시오.");
		custom_alert(400, "상품의 선택옵션을 선택해 주십시오.");
		return false;
	}


	var optcheckstr = "";
	$(".option_item").each(function(){
		
		for (i=1; i<=6; i++) {
			var slt = $(this).find(".it_opt"+i);
			if(slt.size() > 0) {
				if(slt.val() == '선택해주세요'){
					if(optcheckstr != "") optcheckstr += "\n";
					optcheckstr += "[ " + $(this).find(".opt_name").data("name") + " ] " + $(this).find(".it_opt"+i+"_subject").val() + "을(를) 선택하여 주십시오.";
					slt.focus();
				}
			}
		}

	});

	if(optcheckstr != "") {
		//alert(optcheckstr);
		custom_alert(500, optcheckstr);
		return false;
	}
	
	return true;
}

// 바로구매 또는 장바구니 담기
var clickbtn = false;
function fitemcheck(f, act)
{
	clickbtn = true;
    
	if(!validate()) return;


    if (act == "direct_buy") {
		f.target = "";
        f.sw_direct.value = 1;
    } else {
		f.target = "ifrCartUpdate";
        f.sw_direct.value = 0;
	}
	
    amount_change();

	loading();
	
	f.submit();
}


function cartupdated(){
	if(!clickbtn) return;
	close_loading();
	var err = $("iframe[name='ifrCartUpdate']").contents().find("#ifrErr").html();
	if(err === undefined || err == ""){

		custom_confirm(400, "<strong style='font-size:20px;'>상품이 장바구니에 담겼습니다.</strong><br/><br/>장바구니로 이동하시겠습니까?", function(){
			location.href='<?=$g4["shop_path"]?>/cart.php';
		}, function(){});

		/*
		$(".cartMessage").html("상품이 장바구니에 담겼습니다.");
		$(".divCartUpdate").show();
		*/
		//if(!confirm("장바구니에 상품이 추가되었습니다. 장바구니로 이동하시겠습니까?")) return;
		//location.href = "<?=$g4["shop_path"]?>/cart.php";
	} else {
		
		custom_alert(400, err);
		/*
		$(".cartMessage").html(err);
		$(".divCartUpdate").show();
		*/

		// err = err.split("\\n").join("\n");
		// if(!confirm(err + "\n장바구니로 이동하시겠습니까?")) return;
		//location.href = "<?=$g4["shop_path"]?>/cart.php";
	}
}


// 상품보관
function item_wish(f, it_id)
{
	f.url.value = "<?=$g4[shop_path]?>/wishupdate.php?it_id="+it_id;
	f.action = "<?=$g4[shop_path]?>/wishupdate.php";
	f.submit();
}


function go_block(target){
	var target_state = $("."+target).offset().top;
	$("html, body").stop().animate({scrollTop:target_state}, 300, "linear");
}

/*
function go_block(no){
	
	var target_state = $("."+target).offset().top;
	$("html, body").stop().animate({scrollTop:target_state}, 300, "linear");
	

	$(".tab_info").hide();
	$(".tab_info"+no).show();

	$(".item_ex_tab > li").removeClass("on");
	$(".item_ex_tab > li:nth-child("+no+")").addClass("on");
}
*/
</script>



</div> <!-- 1110px -->





<!-- ########################################################################################### -->
<!-- 옵션관련 스크립트 -->
<script>
		load_option_list(1);

		function change_io_type1(){ //옵션 1 변경
			var slt = $("#io_type1 > option:selected");
			if(slt.hasClass("lastopt")) {
				make_options();
			} else {
				load_option_list(2);
			}
		}

		function change_io_type2() { //옵션 2 변경
			var slt = $("#io_type2 > option:selected");
			if(slt.hasClass("lastopt")) {
				make_options();
			} else {
				load_option_list(3);
			}
		}

		function change_io_type3() { //옵션 3 변경
			var slt = $("#io_type2 > option:selected");
			make_options();
		}

		//옵션 불러오기
		function load_option_list(depth){				

			for(var idx = depth ; idx <= 3; idx++){ //하위옵션 선택으로 변경
				$("#io_type"+idx).prop("disabled","disabled");	
				$("#io_type"+idx).html("<option value=''>선택</option>");
				if(depth == idx){ //차 하위 제외 전부 disable
					$("#io_type"+idx).removeProp("disabled","disabled");	
				}
			}
			if($("#io_type"+(depth-1)).val() == "") {
				$("#io_type"+depth).prop("disabled","disabled");	
				return;
			}

			var type1 = "";
			var type2 = "";
			var type3 = "";
			var it_id = "<?=$it_id?>";
			var od_sdate = "<?=$_GET["od_sdate"]?>";
			var od_edate = "<?=$_GET["od_edate"]?>";

			type1 = $("#io_type1").val();
			if($("#io_type2").size() > 0) type2 = $("#io_type2").val();
			if($("#io_type3").size() > 0) type3 = $("#io_type3").val();

			$.post("./item_optionlist.php", {it_id:it_id, od_sdate:od_sdate, od_edate:od_edate, depth:depth, type1:type1, type2:type2, type3:type3}, function(data){
					$("#io_type"+depth).append(data);
			});
			
		}

		//마지막 옵션 변경
		function make_options(){

			$(".option_none_select").hide();
			

			var type1 = "";
			var type2 = "";
			var type3 = "";
			var it_id = "<?=$it_id?>";
			var od_sdate = "<?=$_GET["od_sdate"]?>";
			var od_edate = "<?=$_GET["od_edate"]?>";
			type1 = $("#io_type1").val();
			if($("#io_type2").size() > 0) type2 = $("#io_type2").val();
			if($("#io_type3").size() > 0) type3 = $("#io_type3").val();



			if($("#io_type1").size() == 0) { //옵션이 없는 상품
				loading();
				$.post("./item_option_make.php", {it_id:it_id, od_sdate:od_sdate, od_edate:od_edate}, function(data){
					$(".optlist").append(data);
					close_loading();
				});
				return;
			}

			var optno = $(".lastopt:selected").data("opt-no");
			if(optno == "" || optno === undefined) return;

			if($(".option_item_"+optno).size() > 0) {
				var strOpt = type1;
				if(type2 != "") strOpt += " / " + type2;
				if(type3 != "") strOpt += " / " + type3;
				alert(strOpt + " 상품 옵션이 이미 추가되어있습니다");
				return;
			}
		
			loading();
			$.post("./item_option_make.php", {it_id:it_id, od_sdate:od_sdate, od_edate:od_edate, type1:type1, type2:type2, type3:type3}, function(data){
					$(".optlist").append(data);
					amount_change();
					close_loading();
			});
		}
		
		//옵션항목 삭제
		function delete_option_item(obj){

			custom_confirm(350, "선택하신 옵션항목을 삭제하시겠습니까?", function(){
				$(obj).closest(".option_item").remove();
				amount_change();
			}, function(){});
			
			/*
			if(!confirm("선택하신 옵션항목을 삭제하시겠습니까?")) return;
			$(obj).closest(".option_item").remove();
			amount_change();
			*/
			
		}
</script>
<!-- 옵션관련 스크립트 -->
<!-- ########################################################################################### -->






<!--장바구니용 hidden Iframe -->
<iframe name="ifrCartUpdate" style="display:none; width:0px; height:0px;" src="" onload="cartupdated(this)"></iframe>

<!--장바구니 Alert -->
<div class="divCartUpdate" style="display:none; position:fixed; top:30%; left:50%; width:400px; min-height:120px; margin-left:-200px; border:1px solid black; background:white; ">
	<div style="width:385px; padding:10px 0 15px 15px; border-bottom:1px solid #afafaf; font-size:20px; font-weight:bold; ">
		<i class="fas fa-cart-arrow-down"></i> 장바구니 담기
		<i class="fas fa-times" style="float:right; padding:7px 15px 0px 0px;cursor:pointer;" onclick="$('.divCartUpdate').hide();" ></i>
	</div>
	<div class="cartMessage" style="width:370px; font-size:18px; padding:25px 15px 5px 15px; text-align:center; max-height:300px; overflow-x:hidden; overflow-y:auto;">
		<!--상품이 장바구니에 담겼습니다.-->
	</div>
	<div class="cartMoveMessage" style="width:370px; font-size:16px; padding:5px 15px 15px 15px; text-align:center; color:#8f8f8f;">
		장바구니로 이동하시겠습니까?
	</div>
	<div class="cartBtns" style="width:400px; font-size:14px; padding:15px 0px 25px 0px; text-align:center;">
		<span class="btn1 big" onclick="location.href='<?=$g4["shop_path"]?>/cart.php';">&nbsp;&nbsp;예&nbsp;&nbsp;</span>
		<span class="btn1-o big" onclick="$('.divCartUpdate').hide();">아니오</span>
	</div>
</div>
<!--장바구니 Alert -->








<?
// 하단 HTML
if(trim(str_replace("&nbsp;", "", strip_tags($it[it_tail_html], "<img>"))) != ""){
    echo stripslashes($it[it_tail_html]);
}

$timg = "$g4[path]/data/item/{$it_id}_t";
if (file_exists($timg))
    echo "<img src='$timg' border=0><br>";


// 오늘 본 상품 저장 시작
// tv 는 today view 약자
$saved = false;
$tv_idx = (int)get_session("ss_tv_idx");
$sv_idx = 0;
if ($tv_idx > 0) {
    for ($i=1; $i<=$tv_idx; $i++) {
        if (get_session("ss_tv[$i]") == $it_id) {
			$sv_idx = $i;
            $saved = true;
            break;
        }
    }
	if($sv_idx > 0) {
		for ($i=($sv_idx+1); $i<=$tv_idx; $i++) {
			$sit_id = get_session("ss_tv[{$i}]");
			set_session("ss_tv[".($i-1)."]", $sit_id);
		}
	}
}

if (!$saved) {
    $tv_idx++;
}
set_session("ss_tv_idx", $tv_idx);
set_session("ss_tv[$tv_idx]", $it_id);
// 오늘 본 상품 저장 끝


if ($ca[ca_include_tail])
    @include_once($ca[ca_include_tail]);
else
    include_once("./_tail.php");
?>