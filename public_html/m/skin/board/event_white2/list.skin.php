<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once("$g4[path]/lib/thumb.lib.php");
$imgcolor="#b4b4b4";
$imgbordercolor="#b4b4b4";
$imgbordersize="0";


if (!$board[bo_1]) {
    $board[bo_1] = "255";
    $sql = " update $g4[board_table] set bo_1 = '$board[bo_1]', bo_1_subj = '썸네일 가로' where bo_table = '$bo_table' ";
    sql_query($sql);
}

if (!$board[bo_2]) {
    $board[bo_2] = "170";
    $sql = " update $g4[board_table] set bo_2 = '$board[bo_2]', bo_2_subj = '썸네일 세로' where bo_table = '$bo_table' ";
    sql_query($sql);
}

//목록수 4개로 고정
$board[bo_page_rows] = "4";
$sql = " update $g4[board_table] set bo_page_rows = '$board[bo_page_rows]' where bo_table = '$bo_table' ";
sql_query($sql);

//이미지 1개로 고정
$board[bo_gallery_cols] = "1";
$sql = " update $g4[board_table] set bo_gallery_cols = '$board[bo_gallery_cols]' where bo_table = '$bo_table' ";
sql_query($sql);

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

//if ($is_category) $colspan++;
if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// 제목이 두줄로 표시되는 경우 이 코드를 사용해 보세요.
// <nobr style='display:block; overflow:hidden; width:000px;'>제목</nobr>
?>

<style>
body, td, p, input, button, textarea, select, .c1 {font-family:돋움;}
.member {font-weight:normal;color:#444444;}
.guest  {font-weight:normal;color:#444444;}
a:link, a:visited, a:active{text-decoration:none;color:#444444;}
.board_top { clear:both; display:inline-block; width:100%; }

.board_list { clear:both; width:100%; margin:20px 0 0 0; color:#636363;}
.board_list ul { width:260px;height:325px;float:left; margin:0 8px 20px 9px; padding:15px; border:1px solid #e5d9ca; list-style: none;}
.board_list ul li { margin:0; padding:0;}
.board_list .title a {display:block;margin-top:15px;font-weight:bold;font-size:18px;color:#856f56}
.board_list .title2 {text-align:left;font-weight:bold;font-size:14px;color:#888;width:55px;height:20px;}

.board_number {width:6%; text-align:right;}
.board_number_wrap {padding-top:62px;}
.board_thumbnail_wrap {padding-top:13px;}
.board_content_wrap {padding-top:0px;}
.board_content_wrap a:link, .board_content_wrap a:visited, .board_content_wrap a:active { text-decoration:none; color:#ff2100; }
.board_content_wrap a:hover { text-decoration:underline; }
.board_content_wrap table {border-spacing:0; border-collapse:collapse; border-style:none;}
.board_content_wrap table td { color:#636363;}


.board_content {}

.no_post {padding-top:66px; text-align:center;}

.board_button { clear:both; margin:10px 0 0 0; padding-top:10px; border-top: 1px solid #EDEDED; }

.board_page { clear:both; text-align:center; margin:3px 0 0 0; }
.board_page a:link { color:#777; }

/*.board_search { text-align:center; margin:10px 0 0 0; padding:3px 0 3px 0; height:35px; }
.board_search .stx { height:16px;  border:1px solid #9A9A9A; border-right:1px solid #D8D8D8; border-bottom:1px solid #D8D8D8; background:transparent; }
select{font-size:13px;}*/


</style>

<!-- 게시판 목록 시작 -->
<table width="<?=$width?>" align="center" cellpadding="0" cellspacing="0" ><tr><td>

    <!-- 분류 셀렉트 박스, 게시물 몇건, 관리자화면 링크 -->
    <!-- div class="board_top">
        <div style="float:left;">
            <form name="fcategory" method="get" style="margin:0px;display:none;">
            <? if ($is_category) { ?>
            <select name=sca onchange="location='<?=$category_location?>'+<?=strtolower($g4[charset])=='utf-8' ? "encodeURIComponent(this.value)" : "this.value"?>;">
            <option value=''>전체</option>
            <?=$category_option?>
            </select>
            <? } ?>
            </form>
			<? if ($is_category) { ?>
			<?$arr = explode("|", $board[bo_category_list]);?>
			<div id="categorywrap">
			<a href="<?=$category_location?>">전체</a>&nbsp;&nbsp;<?for($i=0;$i<count($arr);$i++){?><a href="<?=$category_location?><?=urlencode($arr[$i])?>"><?=$arr[$i]?></a>&nbsp;&nbsp;<?}?>
			</div>
			<? } ?>
        </div>
         <div style="float:right; margin-bottom:10px;">
			<div style="float:left; line-heigth:25px;">
				<span style="line-height:25px;">
				<?if($is_admin){?><img src="<?=$board_skin_path?>/img/icon_total.gif" style="margin-top:5px;" align="absmiddle" border='0'>
				</span>
				<span style="color:#888888; font-weight:bold; line-height:25px;  margin-right:7px;">Total <?=number_format($total_count)?></span><?}?>
			</div>
			<div style="float:left;">
				<? if ($rss_href) { ?><a href='<?=$rss_href?>'><img src='<?=$board_skin_path?>/img/btn_rss.gif' border='0' align="absmiddle"></a><?}?>
				<? if ($admin_href) { ?><a href="<?=$admin_href?>"><img src="<?=$board_skin_path?>/img/btn_admin.gif" border='0' title="관리자" align="absmiddle"></a><?}?>
			</div>
		</div>
    </div -->


    <form name="fboardlist" method="post">
    <input type='hidden' name='bo_table' value='<?=$bo_table?>'>
    <input type='hidden' name='sfl'  value='<?=$sfl?>'>
    <input type='hidden' name='stx'  value='<?=$stx?>'>
    <input type='hidden' name='spt'  value='<?=$spt?>'>
    <input type='hidden' name='page' value='<?=$page?>'>
    <input type='hidden' name='sw'   value=''>








<div class="board_list">
<?
for ($i=0; $i<count($list); $i++) {
?>
	<ul>
		<li class="title"><a href="<?=$list[$i][href]?>"><?=cut_str($list[$i][subject],43,"..")?></a></li>
		<li class="board_thumbnail">
			<div class="board_thumbnail_wrap">
				<?
				// 첨부파일 이미지가 있으면 썸을 생성, 아니면 pass~!
					if ($list[$i][file][0][file])
					{


				// 이미지 체크
					$image = urlencode($list[$i][file][0][file]);
						$ori="$g4[path]/data/file/$bo_table/" . $image;
						$ext = strtolower(substr(strrchr($ori,"."), 1)); //확장자

					// 이미지가 있다면.
					if ($ext=="gif"||$ext=="jpg"||$ext=="jpeg"||$ext=="png"||$ext=="bmp"||$ext=="tif"||$ext=="tiff") {

				// 섬네일 경로 만들기 + 섬네일 생성
						$list_img_path = $list[$i][file][0][path]."/".$list[$i][file][0][file];
						$list_thumb = thumbnail($list_img_path ,$board[bo_1], $board[bo_2],0,2,100);


						echo "<div  ><a onfocus='this.blur()' href=";
						echo $list[$i][href];
						echo " onfocus='this.blur()'>";
				//		 echo $list_img_path;
						//echo $list[$i][file][0][path];
						echo "<img src='$list_thumb'  style='width:255px; height: {$board[bo_2] }px; overflow:hidden;margin-left:3px; margin-bottom:3px; border:{$imgbordersize}px solid {$imgcolor}; ' id='img{$i}'  />";
						echo "</a></div>";
					}



					}
					else
					{                ////  첨부파일 이미지가 없으면




				  $img_tags = explode("src=",$list[$i][wr_content]);
				  $img_tag = explode(" ",$img_tags[1]);
				  $img_url = explode(">",$img_tag[0]);
				  $real_img_url = $img_url[0];

				  $clear_img_url =  str_replace('"','',$real_img_url);

				// $pppimg_url = preg_match_all('#img src=\"(.*)\"#Usi',$list[$i][wr_content],$result);
				// 본문내에 첫번째 이미지링크에서 주소 추출 ()

					//$list_thumb = thumbnail($clear_img_url,$board[bo_1], $board[bo_2],0,2,100);


						echo "<div ><a href=";
						echo $list[$i][href];
						echo " onfocus='this.blur()'>";
				//	    echo $clear_img_url;
						echo "<img src='{$board_skin_path}/img/noimg.gif'  style='width:255px; height: {$board[bo_2] }px; margin-left:3px;  margin-bottom:3px; border:{$imgbordersize}px solid {$imgcolor}; ' id='img{$i}'  />";
						echo "</a></div>";



					}

				// 섬네일 완료
				?>
			</div>
		</li>
		<li class="board_content">
			<div class="board_content_wrap">

				<table>
					<tr>
						<td colspan="2" height="40" style="line-height:16px;font-size:15px"><?=cut_str($list[$i][wr_6],120,"..")?></td>
					</tr>
					<tr>
						<th class="title2">ㆍ기간</th>
						<td style="font-size:16px;">
						<strong><?=date("Y. m. d", strtotime("{$list[$i][wr_3]} 00:00:00"))?>  ~ <?=date("Y. m. d", strtotime("{$list[$i][wr_4]} 00:00:00"))?></strong>&nbsp;
							<?
							//////////////////////////////////////////////////////

							// 현재시간
							$current_time = time();
							$current_time = date("Y-m-d", $current_time);

							// event time
							$notice_time  = $list[$i][wr_4];

							$last_time = $notice_time - $current_time ;

							//남은 날이 -  이면, 이벤트 기간이 끝나면..
							//if($last_time < 0){
							 //echo "<img src='$board_skin_path/img/icon_Outprogress.jpg' border='0' align='absmiddle' title='마감'>";
							//}
							//else{
							 //echo "<img src='$board_skin_path/img/icon_Inprogress.jpg' border='0' align='absmiddle' title='진행중'>";
							//}

							//////////////////////////////////////////////////////
							?>
						</td>
					</tr>
					<tr>
						<th class="title2">ㆍ주최</th>
						<td style="font-size:16px;"><?=$list[$i][wr_2]?></td>
					</tr>
				</table>

			</div>

		</li>
		<li class="board_number_wrap">
			<? if ($is_checkbox) { ?><span class="checkbox"><input type=checkbox name=chk_wr_id[] value="<?=$list[$i][wr_id]?>"> </span><? } ?><!-- ?=$list[$i][num]? -->
		</li>
	</ul>
<?} // end for?>
<? if (count($list) == 0) {?>
<ul>

		<div class="no_post">게시물이 없습니다.</div>

</ul>
<?}?>
</div>





    </form>

    <div class="board_button">
        <div style="float:left;">
        <? if ($list_href) { ?>
        <a href="<?=$list_href?>"><img src="<?=$board_skin_path?>/img/btn_list.gif" align="absmiddle" border='0'></a>
        <? } ?>
        <? if ($is_checkbox) { ?>
        <a href="javascript:select_delete();"><img src="<?=$board_skin_path?>/img/btn_select_delete.gif" align="absmiddle" border='0'></a>
        <a href="javascript:select_copy('copy');"><img src="<?=$board_skin_path?>/img/btn_select_copy.gif" align="absmiddle" border='0'></a>
        <!--<a href="javascript:select_copy('move');"><img src="<?=$board_skin_path?>/img/btn_select_move.gif" align="absmiddle" border='0'></a>-->
		&nbsp;&nbsp;&nbsp;모두체크&nbsp;<input onclick="if (this.checked) all_checked(true); else all_checked(false);" type="checkbox">
        <? } ?>
        </div>

        <div style="float:right;">
        <? if ($write_href) { ?><a href="<?=$write_href?>"><img src="<?=$board_skin_path?>/img/btn_write.gif" border='0'></a><? } ?>
        </div>
    </div>

    <!-- 페이지 -->
    <div class="board_page">
        <? if ($prev_part_href) { echo "<a href='$prev_part_href'><img src='$board_skin_path/img/page_search_prev.gif' border='0' align=absmiddle title='이전검색'></a>"; } ?>
        <?
        // 기본으로 넘어오는 페이지를 아래와 같이 변환하여 이미지로도 출력할 수 있습니다.
        //echo $write_pages;
        $write_pages = str_replace("처음", "<img src='$board_skin_path/img/page_begin.gif' border='0' align='absmiddle' title='처음'>", $write_pages);
        $write_pages = str_replace("이전", "<img src='$board_skin_path/img/page_prev.gif' border='0' align='absmiddle' title='이전'>", $write_pages);
        $write_pages = str_replace("다음", "<img src='$board_skin_path/img/page_next.gif' border='0' align='absmiddle' title='다음'>", $write_pages);
        $write_pages = str_replace("맨끝", "<img src='$board_skin_path/img/page_end.gif' border='0' align='absmiddle' title='맨끝'>", $write_pages);
        //$write_pages = preg_replace("/<span>([0-9]*)<\/span>/", "$1", $write_pages);
        $write_pages = preg_replace("/<b>([0-9]*)<\/b>/", "<b><span style=\"color:#ffffff; background:#000000; padding:5px 8px 5px 7px; font-size:12px; text-align:center; \">$1</span></b>", $write_pages);
        ?>
        <b><?=$write_pages?></b>
        <? if ($next_part_href) { echo "<a href='$next_part_href'><img src='$board_skin_path/img/page_search_next.gif' border='0' align=absmiddle title='다음검색'></a>"; } ?>
    </div>

    <!-- 검색 -->
    <?/*<div class="board_search">
        <form name="fsearch" method="get">
        <input type="hidden" name="bo_table" value="<?=$bo_table?>">
        <input type="hidden" name="sca"      value="<?=$sca?>">
        <span style="border:2px solid #bcbcbc; background:#ffffff; padding:3px;"><select name="sfl" style="border:0; background:transparent;">
            <option value="wr_subject">제목</option>
            <option value="wr_content">내용</option>
            <?/*<option value="wr_subject||wr_content">제목+내용</option>
            <option value="mb_id,1">회원아이디</option>
            <?/*<option value="mb_id,0">회원아이디(코)</option>
            <option value="wr_name,1">글쓴이</option>
            <?/*<option value="wr_name,0">글쓴이(코)</option>
        </select>
        <input name="stx" class="stx" maxlength="15" itemname="검색어" required value='<?=stripslashes($stx)?>' style="border:0;"></span>
        <input type="image" src="<?=$board_skin_path?>/img/btn_search.gif" border='0' align="absmiddle">
        <input type="hidden" name="sop" value="and">
		<!--<input type="radio" name="sop" value="and">and
        <input type="radio" name="sop" value="or">or-->
        </form>
    </div>*/?>
	<!--게시판 서치부분-->
	<style>
/* 검색부분 */
.board_search { margin:10px auto 0; width:318px;}
.search_box { float:left; display:inline; font-size:0; padding:3px 0px 3px 3px; width:254px; border:4px solid #d3d3d3;}
.board_search label { font-size:16px; }
.board_search #stx { border:0; width:135px; margin:0; padding:0; padding-top:1px; font-size:18px;}
.board_search #search_input >/**/ #stx { margin-top:1px; padding-top:1px; padding-bottom:2px; letter-spacing:-1px; }
.search_option {margin-top:2px;}
.search_option_box { position:relative; float:left; background:url("<?=$board_skin_mpath?>/img/search_arrow.gif") no-repeat right -4px; }
#search_option_selector { display:block; width:100px; line-height:21px;margin:0 5px 0 6px; cursor:pointer;  }
#search_option_list { display:none; position:absolute; left:0; top:0; margin:0; padding:0; border:1px solid #dfdfdf; width:100px; background:transparent url("<?=$board_skin_mpath?>/img/search_arrow.gif") no-repeat 72px -40px; list-style:none; font-size:0; line-height:1; padding-top:18px; }
#search_option_list label { background:#ffffff; display:block; padding:4px 5px; cursor:pointer; }
#search_option_list label:hover { background:#fafafa; }
.board_search #search_input { float:left; }
.board_search #search_submit { float:right; }
.board_search:after,
.board_search .search_box:after { clear:both; content:""; display:block; }
.board_search,
.board_search .search_box { height:1%; }
.board_list >/**/ .board_search,
.board_search >/**/ .search_box { height:auto; }
	</style>
	<div class="board_search">
	<form method="get">
		<input type="hidden" name="bo_table" value="<?=$bo_table?>" />
		<input type="hidden" name="sop" value="and" />
		<input type="hidden" name="sca" value="<?=$sca?>" />
		<input type="hidden" name="sfl" id="sfl" value="<?=$sfl ? $sfl : "wr_subject||wr_content"?>" />

		<div class="search_box">
			<div class="search_option_box">
				<div class="search_option">
					<label id="search_option_selector">제목&amp;내용</label>
				</div>
				<ul id="search_option_list">
					<li><label for="stx" class="wr_subject||wr_content">제목&amp;내용</label></li>
					<li><label for="stx" class="wr_subject">제목</label></li>
					<li><label for="stx" class="wr_content">내용</label></li>
					<li><label for="stx" class="wr_name,1">글쓴이</label></li>
				</ul>
			</div>

			<div id="search_input">
			<input id="stx" name="stx" itemname="검색어" value="<?=stripslashes($stx)?>" />
			</div>
		</div>

		<div id="search_submit">
			<input src="<?=$board_skin_path?>/img/btn_search.gif" alt="검색" type="image">
		</div>
	</form>
	</div>
	<script type="text/javascript">
	$("#search_option_selector").bind("click",function(){
		$("#search_option_list").show();
		return false;
	});
	$("#search_option_list").find("label").bind("click",function(){
		$("#search_option_selector").text($(this).text());
		$("#search_option_list").hide();
		$("#sfl").val(	$(this).attr("class"));
	});
	/*$("#search_submit input").mousedown(function(){
		$(this).attr('src','<?=$board_skin_path?>/img/btn_search_down.gif');
	});
	$("#search_submit input").hover(function(){
		$(this).attr('src','<?=$board_skin_path?>/img/btn_search_over.gif');
	},function(){
		$(this).attr('src','<?=$board_skin_path?>/img/btn_search.gif');
	});*/
	</script>
	<!--게시판 서치부분-->

</td></tr></table>

<script type="text/javascript">
if ('<?=$sca?>') document.fcategory.sca.value = '<?=$sca?>';
/*if ('<?=$stx?>') {
    document.fsearch.sfl.value = '<?=$sfl?>';

    if ('<?=$sop?>' == 'and')
        document.fsearch.sop[0].checked = true;

    if ('<?=$sop?>' == 'or')
        document.fsearch.sop[1].checked = true;
} else {
    document.fsearch.sop[0].checked = true;
}*/
</script>

<? if ($is_checkbox) { ?>
<script type="text/javascript">
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function check_confirm(str) {
    var f = document.fboardlist;
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(str + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }
    return true;
}

// 선택한 게시물 삭제
function select_delete() {
    var f = document.fboardlist;

    str = "삭제";
    if (!check_confirm(str))
        return;

    if (!confirm("선택한 게시물을 정말 "+str+" 하시겠습니까?\n\n한번 "+str+"한 자료는 복구할 수 없습니다"))
        return;

    f.action = "./delete_all.php";
    f.submit();
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    if (!check_confirm(str))
        return;

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<? } ?>
<!-- 게시판 목록 끝 -->
