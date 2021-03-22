<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once("$g4[path]/lib/thumb.lib.php");
$imgcolor="#a4a4a4";
$imgbordercolor="#a4a4a4";
$imgbordersize="1";

if (!$board[bo_1]) {
    $board[bo_1] = "300";
    $sql = " update $g4[board_table] set bo_1 = '$board[bo_1]', bo_1_subj = '썸네일 가로' where bo_table = '$bo_table' ";
    sql_query($sql);
}

if (!$board[bo_2]) {
    $board[bo_2] = "250";
    $sql = " update $g4[board_table] set bo_2 = '$board[bo_2]', bo_2_subj = '썸네일 세로' where bo_table = '$bo_table' ";
    sql_query($sql);
}

//목록수 16개로 고정
$board[bo_page_rows] = "16";
$sql = " update $g4[board_table] set bo_page_rows = '$board[bo_page_rows]' where bo_table = '$bo_table' ";
sql_query($sql);

$mod = $board[bo_gallery_cols];
$td_width = (int)(100 / $mod);

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

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
.board_top { clear:both; }


.board_button { clear:both; margin:30px 0 0 0; display:inline-block; width:100%; }

a.nBtn { background:#4b4b4b; color:#ffffff; padding:5px 15px; line-height:23px; border:1px solid #1b1b1b; font-size:14px; text-decoration:none; display:inline-block; }

#GalleryUl { display:inline-block; width:100%; margin:20px 0 0; }
#GalleryUl > li { float:left; width:375px; height:374px; margin:0 0 20px 1.6%; position:relative; }
#GalleryUl > li:nth-child(3n+1) { margin-left:0%; }
#GalleryUl > li > a { display:inline-block; height:100%; text-decoration:none; width:100%; }
.GU_thumb { width:100%; height:100%; object-fit:cover; display:block; float:left; }
.img_icon { position:absolute; top:20px; left:20px; }

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
.GU_date_name { display:inline-block; width:100%; line-height:20px; }
.GU_date { float:left; font-size:14px; color:#777; }
.GU_name { float:right; font-size:14px; color:#777; }
</style>


<!--게시판 서치부분-->
<style>
.board_search { float:right; }
.search_select { 
	width:125px; height:40px; border:1px solid #d8d8d8; position:relative; float:left; font-size:15px; padding-left:15px; background:#f9f9f9; outline:none; box-sizing:border-box; color:#5d5d5d; font-weight:400; 
	-webkit-appearance:none; -moz-appearance:none; appearance:none; 
	background:url('/img/select_arrow.png') no-repeat right 15px top 18px;
}
select.search_select::-ms-expand { display:none; }

.search_box { float:left; display:inline; border:1px solid #d8d8d8; border-left:0px; }
.board_search #search_input > #stx { border:0; width:165px; height:38px; margin:0; padding:0 0 0 10px; letter-spacing:0px; color:#5d5d5d; font-size:15px; font-weight:400; }
.board_search #search_input { float:left; }
.board_search #search_submit { float:right; height:34px; }
.board_search #search_submit input { padding:0px; }
</style>
<!--게시판 서치부분-->



<!-- 게시판 목록 시작 -->
<table width="<?=$width?>" align="center" cellpadding="0" cellspacing="0"><tr><td>
	
	<div style="display:inline-block; width:100%;" >
		<div class="board_search">
			<form method="get">
				<input type="hidden" name="bo_table" value="<?=$bo_table?>" />
				<input type="hidden" name="sop" value="and" />
				<input type="hidden" name="sca" value="<?=$sca?>" />
				<input type='hidden' name='sst'  value='<?=$sst?>' />
				<input type='hidden' name='sod'  value='<?=$sod?>' />
				
				<label class="hidden" for="sfl">검색조건</label>
				<select name="sfl" id="sfl" class="search_select" >
					<option value="wr_subject||wr_content" <?=$sfl == "wr_subject||wr_content" ? "selected" : ""?> >제목+내용</option>
					<option value="wr_subject" <?=$sfl == "wr_subject" ? "selected" : ""?> >제목</option>
					<option value="wr_content" <?=$sfl == "wr_content" ? "selected" : ""?> >내용</option>
					<option value="wr_name,1" <?=$sfl == "wr_name,1" ? "selected" : ""?> >글쓴이</option>
				</select>

				<div class="search_box">
					<div id="search_input">
						<input id="stx" name="stx" itemname="검색어" value="<?=stripslashes($stx)?>" placeholder="검색어를 입력해주세요." title="검색어를 입력해주세요." />
					</div>
					<div id="search_submit">
						<input type="image" src="/img/btn_search.jpg" alt="검색" >
					</div>
				</div>
				
				<?if(false){?>
					<div style="float:right; margin:0px 0 0 5px;">
						<? if ($write_href) { ?><a href="<?=$write_href?>" class="nBtn">글쓰기</a><? } ?>
					</div>
				<?}?>
			</form>
		</div>
	</div>

	<? if ($is_category) { ?>
		<?$arr = explode("|", $board[bo_category_list]);?>
		<ul id="categorywrap">
			<li <?=$sca == "" ? "class='on'" : ""?> ><a href="<?=$category_location?>" >전체</a></li>
			<?for($i=0;$i<count($arr);$i++){?>
				<li <?=$sca == $arr[$i]  ? "class='on'" : ""?> ><a href="<?=$category_location?><?=urlencode($arr[$i])?>" >
						<?=$arr[$i]?>
				</a></li>
			<?}?>
		</ul>
	<? } ?>


    <form name="fboardlist" method="post">
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
					$list_thumb = thumbnail($list_img_path ,$board[bo_1], '',0,2,100);

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
					<img src="/res/images/mainvisual/mg_img.png" class="img_icon"/>
					<img src="<?=$list_thumb?>" class="GU_thumb" alt="<?=$list[$i]["wr_subject"]?>" />
				</a>

				<? if ($is_checkbox) { ?>
					<input type=checkbox name=chk_wr_id[] value="<?=$list[$i][wr_id]?>" style="position:absolute; left:10px; top:10px;" >
				<? } ?>
			</li>

		<?
		}	//for end

		if (count($list) == 0) {?>
			<li>
				<img src="/res/images/noimg.jpg" class="GU_thumb" alt="게시물이 없습니다." />
				<div class="GU_con">
					<div class="GU_subj" >게시물이 없습니다.</div>
				</div>
			</li>
		<? } ?>
    </ul>
    </form>


	
	<? if ($write_href || $list_href || $is_checkbox) { ?>
		<div class="board_button">
			<div style="float:left;">
				<? if ($list_href) { ?>
					<a href="<?=$list_href?>" class="nBtn" >목록보기</a>
				<? } ?>
				<? if ($is_checkbox) { ?>
					<a href="#select_delete" onclick="select_delete();" class="nBtn" >선택삭제</a>
					<a href="#select_copy" onclick="select_copy('copy');" class="nBtn" >선택복사</a>
					<a href="#select_move" onclick="select_copy('move');" class="nBtn" >선택이동</a>
					
					&nbsp;&nbsp;&nbsp;
					<label>
						모두체크
						<input onclick="if (this.checked) all_checked(true); else all_checked(false);" type="checkbox">
					</label>
				<? } ?>
			</div>
			<div style="float:right;">
				<? if ($write_href) { ?><a href="<?=$write_href?>" class="nBtn" >글쓰기</a><? } ?>
			</div>
		</div>
	<?}?>

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

</td></tr></table>

<script type="text/javascript">
if ('<?=$sca?>') document.fcategory.sca.value = '<?=$sca?>';
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
