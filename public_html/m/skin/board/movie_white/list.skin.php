<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once("$g4[path]/lib/thumb.lib.php");


//모바일용 사이즈
$board[bo_2] = "272";
$board[bo_3] = "246"

?>

<style type='text/css'>
#mContentWrap { margin:10px 0 20px 0; overflow:hidden;}
span.mImgWrap { width:300px; height:302px; margin-left:0px; float:left;}
/*span.img0,
span.img2 { margin-left:20px;}*/
span.mImgWrap div { width:300px; float:left; text-align:center;}
span.mImgWrap div.mImg { margin-top:10px;}
span.mImgWrap div.mSubject { margin-top:5px; font-weight:bold; color:#222; font-size:24px;}
span.list_cmt_cnt_new {font-size:22px; color: #EE5A00;}
span.list_cmt_cnt {font-size:22px; color: #EE5A00;}
</style>

<!--게시판 서치부분-->
<style>
/* 검색부분 */
.board_search {float:right; margin:0 0 30px 0; }
.search_box { float:left; display:inline; border:1px solid #e5e5e5; margin-left:5px }
.board_search label { font-size:16px; color:#919191; }
.board_search #stx {  }
.board_search #search_input >/**/ #stx { border:0; width:170px; height:34px; margin:0; padding:0 0 0 10px; letter-spacing:0px; color:#919191; font-size:16px; }
.search_option_box { width:100px; height:36px; border:1px solid #e5e5e5; position:relative; float:left; font-size:16px; background:url("<?=$board_skin_path?>/img/search_arrow.jpg") no-repeat 80px 16px; font-size:16px; color:#919191; padding:0 5px;
    -moz-appearance:none; /* Firefox */
    -webkit-appearance:none; /* Safari and Chrome */
    appearance:none; }
	
select.search_option_box::-ms-expand {
   display: none;            /* 화살표 없애기 for IE10, 11*/
}
#search_option_list { display:none; position:absolute; left:-1px; top:33px; margin:0;border:1px solid #dfdfdf; width:100px; /*background:transparent url("<?=$board_skin_path?>/img/search_arrow.gif") no-repeat 72px -40px;*/ list-style:none; font-size:0; line-height:1; padding:5px 0 5px 0;background:#fff }
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

  <!--  <div style="padding-top:100px;"></div> -->

  
	
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
				<input src="<?=$board_skin_path?>/img/btn_search.jpg" alt="검색" type="image">
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


<div id="m_list">
<div style="height:30px;"></div>
<div id='mContentWrap' style="float:left;max-width:640px;">

	<?
	$subject_len=18;//자를 제목 수

	list($startno,$paging)= mpagelist($total_count, $board[bo_page_rows], 5, $g4[mpath]."/bbs/board.php","bo_table=$bo_table");


	for ($i=0; $i<count($list); $i++) {
		$file = sql_fetch("SELECT * from ".$g4['board_file_table']." where bo_table = '$bo_table' AND wr_id = '{$list[$i][wr_id]}' limit 1");
		

		// 이미지 체크
		if($file){
			$image = urlencode($file[bf_file]);
			$ori="$g4[path]/data/file/$bo_table/" . $image;
			$ext = strtolower(substr(strrchr($ori,"."), 1)); //확장자
			
			// 이미지가 있다면.
			if ($ext=="gif"||$ext=="jpg"||$ext=="jpeg"||$ext=="png"||$ext=="bmp"||$ext=="tif"||$ext=="tiff") {

				// 섬네일 경로 만들기 + 섬네일 생성
				$list_img_path = "$g4[path]/data/file/$bo_table/".$file[bf_file];
				$list_thumb = thumbnail($list_img_path ,$board[bo_2], $board[bo_3],0,2,100);
			}
		}else{
			
				$list_thumb = "https://img.youtube.com/vi/{$list[$i][wr_1]}/0.jpg";


		}
		$list_selected="";
		
		$list[$i]['subject'] = conv_subject($list[$i]['wr_subject'], $subject_len, "…");

		if($wr_id==$list[$i][wr_id]) $list_selected="class='list_selected'";

		$wr_comment="";

		if($list[$i][wr_comment]){

			$cmt=sql_fetch("select wr_datetime from ".$g4[write_prefix].$bo_table." where wr_is_comment=1 and wr_parent='$list[$i][wr_id]' order by wr_datetime desc");

			if ($cmt['wr_datetime'] >= date("Y-m-d H:i:s", $g4['server_time'] - 86400))
				$wr_comment="<span class='list_cmt_cnt_new'>({$list[$i][wr_comment]})</span>";
			else $wr_comment="<span class='list_cmt_cnt'>({$list[$i][wr_comment]})</span>";
		}

		$icon_secret = "";
		if (strstr($list[$i]['wr_option'], "secret"))
			$icon_secret = "<img src='$g4[mpath]/images/icon/icon_secret.gif' align='absmiddle'>";

		$icon_new = "";
		if ($list[$i]['wr_datetime'] >= date("Y-m-d H:i:s", $g4['server_time'] - ($board['bo_new'] * 3600)))
			$icon_new = "<img src='$g4[mpath]/images/icon/icon_new.gif' align='absmiddle'>";

	echo "<span class='mImgWrap img$i'>
			<div class='mImg'>
				<a href='$g4[mpath]/bbs/board.php?bo_table=$bo_table&wr_id={$list[$i][wr_id]}&page=$page'>
					<img src='$list_thumb'  style='width:{$board[bo_2]}px;height:{$board[bo_3]}px;margin-left:3px; margin-bottom:3px; padding:2px; border:1px solid {$imgcolor}; ' id='img{$i}'  />
				</a>
			</div>
			<div class='mSubject'>
				{$list[$i][subject]}
			</div>
		  </span>";
	}?>
	<? if($i==0){ 	?>
	<div style='width:620px; height:40px; line-height:40px; border-top:1px solid #ddd; border-bottom:1px solid #ddd; text-align:center;'>게시물이 존재하지 않습니다.</div>
	<? } ?>
</div>

<div class="paging" style="clear:both;"><?=$paging?></div>

 <div style="width:100%;text-align:right;clear:both;">
<? if ($write_href) { ?>
		<span class="button medium add"><a href="<?=$write_href?>" style='font-size:24px;'>글쓰기</a></span>
<? } ?>
</div>


</div>
