<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가


include_once $board_skin_path."/lib/util.php";
include_once("$g4[path]/lib/thumb.lib.php");


//모바일 섬네일 크기
$board[bo_1] = "512";
$board[bo_2] = "307";


// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

//if ($is_category) $colspan++;
if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// 제목이 두줄로 표시되는 경우 이 코드를 사용해 보세요.
// <nobr style='display:block; overflow:hidden; width:000px;'>제목</nobr>




$qstr2 = $qstr; 
$qstr  .= "&sdate=$sdate";



function print_list($list){
		
		global $bo_table, $board, $g4, $board_skin_path;
	
		
		$count1 = count($list)-1 ;
		for ($i=0; $i<count($list); $i++) {
		// 첨부파일 이미지가 있으면 썸을 생성, 아니면 pass~!
		if ($list[$i][ca_name] == "News"){
			$thumImg = "<img src='/res/images/news_img.jpg'  style='width:{$board[bo_1]}px;height:{$board[bo_2]}px;margin-left:3px; margin-bottom:3px; border:{$imgbordersize}px solid {$imgcolor}; ' id='img{$i}'  alt='News &amp; Event 이미지' />";
		}
		else if ($list[$i][file][0][file])
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
				$thumImg = "<img src='$list_thumb'  style='width:{$board[bo_1]}px;height:{$board[bo_2]}px;margin-left:3px; margin-bottom:3px; border:{$imgbordersize}px solid {$imgcolor}; ' id='img{$i}'  alt='News &amp; Event 이미지' />";
			}
		}
		else
		{                
				////  첨부파일 이미지가 없으면
				$img_tags = explode("src=",$list[$i][wr_content]);
				$img_tag = explode(" ",$img_tags[1]);
				$img_url = explode(">",$img_tag[0]);
				$real_img_url = $img_url[0];
				$clear_img_url =  str_replace('"','',$real_img_url);
				$thumImg =  "<img src='{$board_skin_path}/img/noimg.jpg'  style='width:{$board[bo_1]}px;height:{$board[bo_2]}px; margin-left:3px;  margin-bottom:3px; border:{$imgbordersize}px solid {$imgcolor}; ' id='img{$i}' alt='News &amp; Event 이미지' />";

		}
		// 섬네일 완료
		
		$date = date("Y-m-d H:i", strtotime($list[$i][wr_datetime]));
		if ($list[$i][ca_name] == "Event") {
			$date = $list[$i][wr_2]."~".$list[$i][wr_3];
		} 


		echo "
			<li>
				<span class='Thum'><a href='{$list[$i][href]}'>$thumImg</a></span>
				<span class='Tit'><a href='{$list[$i][href]}'>".cut_str($list[$i][wr_subject],90)."</a></span>
				<span class='Stit'><a href='{$list[$i][href]}'>".cut_str($list[$i][wr_1],180)."</a></span>
				<span class='Date'><span class='Pricein'>Date.</span> &nbsp;&nbsp;$date</span>
				
			</li>
		";

	 } 
}

?>

<style>
.board_button { clear:both; padding:10px 0 0 0;}

.board_page { clear:both; text-align:center; margin:3px 0 0 0;}
.board_page a { color:#777;border:1px solid #dddddd;padding:5px 8px 5px 7px;font-size:16px }

a.nBtn { background:#4b4b4b; color:#ffffff; padding:5px 15px; line-height:23px; border:1px solid #1b1b1b; font-size:16px; text-decoration:none; display:inline-block; }

</style>


<!--게시판 서치부분-->
<style>
/* 검색부분 */
.board_search {float:right; margin:0 0 30px 0; }
.search_box { float:left; display:inline; border:1px solid #e5e5e5; margin-left:5px }
.board_search label { font-size:16px; color:#919191; }
.board_search #stx {  }
.board_search #search_input >/**/ #stx { border:0; width:170px; height:34px; margin:0; padding:0 0 0 10px; letter-spacing:0px; color:#919191; font-size:16px; }
.search_option_box { width:100px; height:36px; border:1px solid #e5e5e5; position:relative; float:left; font-size:16px; background:url("<?=$board_skin_mpath?>/img/search_arrow.jpg") no-repeat 80px 16px; font-size:16px; color:#919191; padding:0 5px;
    -moz-appearance:none; /* Firefox */
    -webkit-appearance:none; /* Safari and Chrome */
    appearance:none; }
	
select.search_option_box::-ms-expand {
   display: none;            /* 화살표 없애기 for IE10, 11*/
}
#search_option_list { display:none; position:absolute; left:-1px; top:33px; margin:0;border:1px solid #dfdfdf; width:100px; /*background:transparent url("<?=$board_skin_mpath?>/img/search_arrow.gif") no-repeat 72px -40px;*/ list-style:none; font-size:0; line-height:1; padding:5px 0 5px 0;background:#fff }
#search_option_list label { background:#ffffff; display:block; padding:4px 5px 4px 10px; cursor:pointer;  }
#search_option_list label:hover { background:#fafafa; }
.board_search #search_input { float:left; }
.board_search #search_submit { float:right; height:34px; }
.board_search #search_submit input { padding:10px; cursor:pointer; }
.board_search:after,
.board_search .search_box:after { clear:both; content:""; display:block; }
.board_search,
.board_search .search_box { height:1%; }
.board_list >/**/ .board_search,
.board_search >/**/ .search_box { height:25px; }
</style>
<!--게시판 서치부분-->

<link rel="stylesheet" href="<?=$board_skin_mpath?>/skin.css" type="text/css"/>

<div class="Boardbox">

	
	<div class="board_search">
		<form method="get">
			<input type="hidden" name="bo_table" value="<?=$bo_table?>" />
			<input type="hidden" name="sop" value="and" />
			<input type="hidden" name="sca" value="<?=$sca?>" />
			<input type='hidden' name='now_id' value='<?=$now_id?>'>

			<select name="sfl" id="sfl" class="search_option_box">
				<option value="wr_subject||wr_content">제목+내용</option>
				<option value="wr_subject">제목</option>
				<option value="wr_content">내용</option>
				<option value="wr_name">글쓴이</option>
			</select>

			<div class="search_box">
				<div id="search_input">
				<input id="stx" name="stx" itemname="검색어" value="<?=stripslashes($stx)?>" placeholder="검색어를 입력해주세요." />
				</div>
				<div id="search_submit">
					<input src="<?=$board_skin_mpath?>/img/btn_search.jpg" alt="검색" type="image">
				</div>
			</div>

			<div style="float:right;margin:0px 0 0 5px;">
				<? if ($write_href && $is_comu_member) { ?>
					<a href="<?=$write_href?>" class="nBtn">글쓰기</a>
				<? } ?>
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

<div class="Conslide3" style="border-bottom:0; cursor:default; width:100%;height:1px;padding:0;background:transparent;"></div>

	<div class="Eventlist mm1">
		<ul>
			<?print_list($list);?>
		</ul>
	</div>
	<div class="Boardbtn" style="margin:30px 0 0 0;">
		<div class="Boardleftbtn">
			<div class="totalbtn">&nbsp;</div>
		</div>
		<div class="Boardpage linkpage">
			<table cellspacing="3" cellpadding="0" class="t6" summary="페이지 입니다.">
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
						<?=get_paging2($config[cf_write_pages], $page, $total_page, "$_SERVER[PHP_SELF]?bo_table=$bo_table&$qstr&page=");?>
					</tr>
				</tbody>
			</table>
		</div>
<!-- 
		<div class="Boardrightbtn">
			 <? if ($write_href) { ?><div class="totalbtn"><a href="<?=$write_href?>&sca=<?=$sca?>"><span class="totalbtn1">글쓰기</span></a></div><?}?>
		</div> 
-->


		<div class="board_button">

			<div style="float:left;">
				<? if ($list_href) { ?>
					<a href="<?=$list_href?>" class="nBtn" >목록보기</a>
				<? } ?>
				<? if ($is_checkbox && false) { ?>
					<a href="javascript:select_delete();" class="nBtn" >선택삭제</a>
					<a href="javascript:select_copy('copy');" class="nBtn" >선택복사</a>
					<a href="javascript:select_copy('move');" class="nBtn" >선택이동</a>
				<? } ?>
			</div>

			<div style="float:right;">
			  <? if ($write_href) { ?><a href="<?=$write_href?>" class="nBtn" >글쓰기</a><? } ?>
			</div>

			
		</div>

	</div>
</div>





<script type="text/javascript">


function list_fold(idx){
	
	if($(".mm"+idx).hasClass("fold")){
		$(".img_mm"+idx).attr("src", $(".img_mm"+idx).attr("src").split("_off").join("_on"));
		$(".mm"+idx).slideDown().removeClass("fold");
	} else {
		$(".img_mm"+idx).attr("src", $(".img_mm"+idx).attr("src").split("_on").join("_off"));
		$(".mm"+idx).slideUp().addClass("fold");
	}

}

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
