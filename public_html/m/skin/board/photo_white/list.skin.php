<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once("$g4[path]/lib/thumb.lib.php");

$board[bo_1] = "290";
$board[bo_2] = "200";
   

//목록수 12개로 고정
/*
$board[bo_page_rows] = "12";
$sql = " update $g4[board_table] set bo_page_rows = '$board[bo_page_rows]' where bo_table = '$bo_table' ";
sql_query($sql);
*/
$mod = 2;
$td_width = (int)(100 / $mod);

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

$is_checkbox = false; 
if ($is_category) $colspan++;
if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// 제목이 두줄로 표시되는 경우 이 코드를 사용해 보세요.
// <nobr style='display:block; overflow:hidden; width:000px;'>제목</nobr>
?>

<style>
.member {font-weight:normal;color:#444444;}
.guest  {font-weight:normal;color:#444444;}

.board_button { clear:both; padding:10px 0 0 0;}

a.nBtn { background:#4b4b4b; color:#ffffff; padding:5px 15px; line-height:23px; border:1px solid #1b1b1b; font-size:17px; text-decoration:none; display:inline-block; }
#categorywrap { display:inline-block; display:inline-block; border-left:1px solid #dfdfdf; float:left; }
#categorywrap > li { width:188px; height:48px; box-sizing:border-box; float:left; margin:0px; display:inline-block; border:1px solid #dfdfdf; text-align:center; border-left:0px; border-bottom:0px; }
#categorywrap > li > a { display:block; width:100%; height:100%; line-height:48px; text-decoration:none; color:#000000; font-size:16px; font-weight:300; }
#categorywrap > li:hover, 
#categorywrap > li.on { border-top:5px solid #ffba00; }
#categorywrap > li:hover > a, 
#categorywrap > li.on > a { color:#ffba00; line-height:40px; }

#GalleryUl { display:inline-block; width:100%; margin:0px 0 0; }
#GalleryUl > li { float:left; width:49%; margin:0 0 20px 2%; position:relative; text-align:center }
#GalleryUl > li:nth-child(2n+1) { margin-left:0%; }
#GalleryUl > li > a { display:inline-block; text-decoration:none; width:100%; }
.GU_thumb { width:288px; height:288px; object-fit:cover; display:block; float:left; }
.mg_img { position:absolute; top:20px; left:20px; }
/*
.GU_subj {
    width:100%; height:46px; line-height:23px; font-size:16px; color:#222;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:normal;
    word-wrap:break-word;
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
}
*/
</style>

<!--게시판 서치부분-->
<style>
/* 검색부분 */
.board_search { display:inline-block; width:100%; margin:0 0 30px 0; }
.search_box { float:left; display:inline; border:1px solid #d8d8d8; margin-left:5px;}
.board_search label { font-size:16px; color:#777; }
.board_search #stx {  }
.board_search #search_input > #stx { border:0; width:170px; height:34px; margin:0; padding:0 0 0 10px; letter-spacing:0px; color:#777; font-size:14px; }
.search_option_box { 
	width:100px; height:36px; border:1px solid #d8d8d8; position:relative; float:left; font-size:14px; 
	background:url("/img/search_arrow.jpg") no-repeat 80px 16px; color:#777;
	   -moz-appearance:none; /* Firefox */
    -webkit-appearance:none; /* Safari and Chrome */
    appearance:none;
}
	
select.search_option_box::-ms-expand {
   display: none;            /* 화살표 없애기 for IE10, 11*/
}
#search_option_list { display:none; position:absolute; left:-1px; top:33px; margin:0;border:1px solid #dfdfdf; width:100px; list-style:none; font-size:0; line-height:1; padding:5px 0 5px 0;background:#fff }
#search_option_list label { background:#ffffff; display:block; padding:4px 5px 4px 10px; cursor:pointer;  }
#search_option_list label:hover { background:#fafafa; }
.board_search #search_input { float:left; }
.board_search #search_submit { float:right; height:34px; }
.board_search #search_submit input { padding:10px; cursor:pointer; background:#fff; }
.board_search:after,
.board_search .search_box:after { clear:both; content:""; display:block; }
.board_search,
.board_search .search_box { height:1%; }
.board_list >/**/ .board_search,
.board_search >/**/ .search_box { height:25px; }
</style>
<!--게시판 서치부분-->




<!-- 게시판 목록 시작 -->
<!-- <table width="<?=$width?>" align="center" cellpadding="0" cellspacing="0"><tr><td> -->

    <!-- 분류 셀렉트 박스, 게시물 몇건, 관리자화면 링크 -->
	<? if ($is_category) { ?>
    <div class="board_top">
        <div style="float:left;">
            <form name="fcategory" method="get" style="margin:0px;display:none;">
           
				<select name=sca onchange="location='<?=$category_location?>'+<?=strtolower($g4[charset])=='utf-8' ? "encodeURIComponent(this.value)" : "this.value"?>;">
				<option value=''>전체</option>
				<?=$category_option?>
				</select>
				
            </form>
			
			<?$arr = explode("|", $board[bo_category_list]);?>
			<ul id="categorywrap">
				<!-- <li><a href="<?=$category_location?>">전체</a></li> -->
				<?for($i=0;$i<count($arr);$i++){?>
					<li <?=$arr[$i] == $sca ? "class='on'" : ""?> >
						<a href="<?=$category_location?><?=urlencode($arr[$i])?>"><?=$arr[$i]?></a>
					</li>
				<?}?>
			</ul>
		
        </div>
	</div>
	<? } ?>
	<!-- 
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
	 -->
	
	<div class="board_search" >
		<form method="get" >
			<input type="hidden" name="bo_table" value="<?=$bo_table?>" />
			<input type="hidden" name="sop" value="and" />
			<input type="hidden" name="sca" value="<?=$sca?>" />
			<input type='hidden' name='now_id' value='<?=$now_id?>'>
			
			<div style="float:right;" >
				<select name="sfl" id="sfl" class="search_option_box">
					<option value="wr_subject||wr_content" <?=$sfl == "wr_subject||wr_content" ? "selected" : ""?> >제목+내용</option>
					<option value="wr_subject" <?=$sfl == "wr_subject" ? "selected" : ""?> >제목</option>
					<option value="wr_content" <?=$sfl == "wr_content" ? "selected" : ""?> >내용</option>
					<option value="wr_name,1" <?=$sfl == "wr_name,1" ? "selected" : ""?> >글쓴이</option>
				</select>

				<div class="search_box">
					<div id="search_input">
					<input id="stx" name="stx" itemname="검색어" value="<?=stripslashes($stx)?>" placeholder="검색어를 입력해주세요." />
					</div>
					<div id="search_submit">
						<input src="/img/btn_search.jpg" alt="검색" type="image">
					</div>
				</div>

				<? if ($write_href && false) { ?>
					<div style="float:right;margin:0px 0 0 5px;">
						<a href="<?=$write_href?>" class="nBtn">글쓰기</a>
					</div>
				<? } ?>
			</div>
		</form>
	</div>



    <form name="fboardlist" id="fboardlist" method="post" >
		<input type='hidden' name='bo_table' value='<?=$bo_table?>'>
		<input type='hidden' name='sfl'  value='<?=$sfl?>'>
		<input type='hidden' name='stx'  value='<?=$stx?>'>
		<input type='hidden' name='spt'  value='<?=$spt?>'>
		<input type='hidden' name='page' value='<?=$page?>'>
		<input type='hidden' name='sw'   value=''>

		<ul id="GalleryUl" >
			<?
			for ($i=0; $i<count($list); $i++) {

				// 첨부파일 이미지가 있으면 썸을 생성, 아니면 pass
				if ($list[$i][file][0][file]) {

					// 이미지 체크
					$image = urlencode($list[$i][file][0][file]);
					$ori="$g4[path]/data/file/$bo_table/" . $image;
					$ext = strtolower(substr(strrchr($ori,"."), 1)); //확장자

					// 이미지가 있다면.
					if ($ext=="gif"||$ext=="jpg"||$ext=="jpeg"||$ext=="png"||$ext=="bmp"||$ext=="tif"||$ext=="tiff") {

						// 섬네일 경로 만들기 + 섬네일 생성
						$list_img_path = $list[$i][file][0][path]."/".$list[$i][file][0][file];
						$list_thumb = thumbnail($list_img_path ,$board[bo_1], $board[bo_2],0,2,100);

					}

				} else {	////  첨부파일 이미지가 없으면

					$content = $list[$i][wr_content];
					preg_match("/(<img[^>]+>)/i", $content, $matches);// 내용에서 <img.*> 태그의 전체 코드를 얻음
					$img = $matches[1]; // <img.*> 태그에서 src 의 코드만 얻음
					preg_match("/src\=[\"\']?([^\"\'\s\>]+)/i", $img, $matches);
					$list_thumb = $matches[1];
					
					if(!$list_thumb) {
						$list_thumb = "/res/images/noimg.jpg";
					}

				}

				// 섬네일 완료

			?>
				
				<li class="wow fadeInUp" data-wow-delay="0.3s">
					<a href="<?=$list[$i]["href"]?>" >
						<img src="/res/images/mainvisual/mg_img.png" class="mg_img" />
						<img src="<?=$list_thumb?>" class="GU_thumb" alt="<?=$list[$i]["wr_subject"]?>" />
					</a>

					<? if ($is_checkbox) { ?>
						<input type=checkbox name=chk_wr_id[] value="<?=$list[$i][wr_id]?>" style="margin:20px 0; padding:0 5px;">
					<? } ?>
				</li>

			<?
			}	//for end

			if (count($list) == 0) {?>

				<li>
					<img src="/res/images/noimg.jpg" class="GU_thumb" alt="게시물이 없습니다" />
					<div class="GU_con">
						<div class="GU_subj" >게시물이 없습니다.</div>
					</div>
				</li>
			<? } ?>
		</ul>
	</form>


   <div class="board_button">
        <div style="float:left;">
			<? if ($list_href) { ?>
				<a href="<?=$list_href?>" class="nBtn" >목록보기</a>
			<? } ?>
			<? if ($is_checkbox) { ?>
				<a href="javascript:select_delete();" class="nBtn" >선택삭제</a>
				<a href="javascript:select_copy('copy');" class="nBtn" >선택복사</a>
				<a href="javascript:select_copy('move');" class="nBtn" >선택이동</a>
			<? } ?>
        </div>
        <div style="float:right;">
			<? if ($write_href) { ?><a href="<?=$write_href?>" class="nBtn" >글쓰기</a><? } ?>
		</div>
    </div>


	<!-- 페이지 -->
	<div class="Boardpage linkpage" >
		<table cellspacing="3" cellpadding="0" class="t6" style='margin:0 auto;' >
			<colgroup>
				<col />
				<col />
				<col />
				<col />
				<col />
				<col />
				<col />
				<col />
				<col />
			</colgroup>
			<tbody>
				<tr>
					<?=$write_pages?>
				</tr>
			</tbody>
		</table>
	</div>
	
<!-- </td></tr></table> -->

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
