<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$qstr .= "&sdate=$sdate";
?>

<style>
#writeContents,
#writeContents p, 
#writeContents div {display:block;line-height:1.5em;}
#writeContents img { max-width:580px !important; height:auto !important; }
a.nBtn1 { background:#484848; color:#ffffff; padding:10px 15px; font-size:16px; text-decoration:none; display:inline-block; }
a.nBtn2 { background:#727272; color:#ffffff; padding:10px 15px; font-size:16px; text-decoration:none; display:inline-block; }
a.nBtn3 { background:#dddddd; color:#555555; padding:10px 15px; font-size:16px; text-decoration:none; display:inline-block; }

</style>

<link rel="stylesheet" href="<?=$board_skin_mpath?>/skin.css" type="text/css"/>



    <!-- 링크 버튼
    <div style="float:right;">
    <?
    ob_start();
    ?>
	<? if ($search_href) { echo "<a href=\"$search_href\" class='nBtn1' >검색목록</a> "; } ?>
	<? echo "<a href=\"$list_href\" class='nBtn1' >목록보기</a> "; ?>
    <? if ($copy_href && false) { echo "<a href=\"$copy_href\" class='nBtn3' >복사하기</a> "; } ?>
    <? if ($move_href && false) { echo "<a href=\"$move_href\" class='nBtn3' >이동하기</a> "; } ?>
	<? if ($delete_href) { echo "<a href=\"$delete_href\" class='nBtn3' >삭제하기</a> "; } ?>
    <? if ($reply_href) { echo "<a href=\"$reply_href\" class='nBtn3' >답변하기</a> "; } ?>
	<? if ($update_href) { echo "<a href=\"$update_href\" class='nBtn2' >수정하기</a> "; } ?>
    <? if ($write_href) { echo "<a href=\"$write_href\" class='nBtn2' >글쓰기</a> "; } ?>
    <?
    $link_buttons = ob_get_contents();
    ob_end_flush();
    ?>
    </div> -->


<div class="Packagedbox">

	<?/*
		// 파일 출력
		for ($i=0; $i<=count($view[file]); $i++) {
		    if ($view[file][$i][view]){?>
			<div class="Packagettop">
				<img src="<? echo $view[file][$i][path]."/".$view[file][$i][file]?>" alt="News & Event Image" style='width:100%;height:350px;'/>
			</div>		    
		    <?}
		}
	*/?>


	<div class="Packagedcon">
		<span class="Tit"><?=cut_hangul_last(get_text($view[wr_subject]))?></span>
		<!--<span class="Stit"><?=$view[wr_1]?></span>-->
		<?if($view[ca_name] == "News"){ ?>
			<span class="Date2"><span class="Pricein">Date.</span> &nbsp;&nbsp;<?=date("Y-m-d H:i", strtotime($view[wr_datetime])) ?></span>			
		<?}else{?>
			<span class="Date2"><span class="Pricein">Date.</span> &nbsp;&nbsp;<?=$view[wr_2]?> ~ <?=$view[wr_3]?></span>			
			<!--<span class="Date2" style='padding-top:0px;margin-top:0px;line-height:1px'><span class="Pricein">Price.</span> &nbsp;&nbsp;\ <?=number_format($view[wr_4])?> ~ \ <?=number_format($view[wr_5])?></span>	-->		
		<?}?>
			

	</div>
	<div class="Packagedetail" id="writeContents">
		<?if($board[bo_use_dhtml_editor] == 1){?>
			<?=str_replace("\n", "", $write[wr_content])?>
		<?}else{?>
			<?=str_replace("\n", "<br/>", $write[wr_content])?>
		<?}?>
	</div>
<!-- 
	<div class="Boardbtn">
		<div class="Boardrightbtn">
			<div class="totalbtn" style="padding:0 5px 0 0;"><a href="<?=$list_href."&".$qstr?>"><span class="totalbtn1">목록보기</span></a></div>
			<? if ($update_href) { echo '<div class="totalbtn" style="padding:0 5px 0 0;"><a href="'.$update_href.'"><span class="totalbtn1">수정하기</span></a></div>'; } ?>
			<? if (false && $delete_href) { echo '<div class="totalbtn" style="padding:0 5px 0 0;"><a href="'.$delete_href.'"><span class="totalbtn1">삭제하기</span></a></div>'; } ?>
			<? if (false && $write_href) { echo '<div class="totalbtn" style="padding:0 5px 0 0;"><a href="'.$write_href.'"><span class="totalbtn1">글쓰기</span></a></div>'; } ?>
		</div>
	</div>
 -->


	<table border=0 cellpadding=0 cellspacing=0 width=100%>
		<tr>
			<td style="width:60px;height:50px;border-top:1px solid #d6d6d6;text-align:center">
				<img src="<?=$board_skin_mpath?>/img/up.jpg" border='0' align="absmiddle" <?=$prev[wr_id] ? "onclick='location.href=\"/m/bbs/board.php?bo_table=".$bo_table."&wr_id=".$prev[wr_id]."\"' style='cursor:pointer;' " : ""?> >
			</td>
			<td style="width:80px;height:50px;border-top:1px solid #d6d6d6;color:#676767;font-size:16px;">이전 글</td>
			<td style="height:50px;border-top:1px solid #d6d6d6;color:#676767;font-size:16px;">
				<?=$prev[wr_id] ? "<a href='/m/bbs/board.php?bo_table=".$bo_table."&wr_id=".$prev[wr_id]."' style='color:#676767;'>".$prev[wr_subject]."</a>" : "<font style='color:#a09f9f'>이전 글이 없습니다.</font>"?>
			</td>
		<tr>
		<tr>
			<td style="width:60px;height:50px;border-top:1px solid #d6d6d6;text-align:center">
				<img src="<?=$board_skin_mpath?>/img/down.jpg" border='0' align="absmiddle" <?=$next[wr_id] ? "onclick='location.href=\"/m/bbs/board.php?bo_table=".$bo_table."&wr_id=".$next[wr_id]."\"' style='cursor:pointer;' " : ""?> />
			</td>
			<td style="width:80px;height:50px;border-top:1px solid #d6d6d6;color:#676767;font-size:16px;">다음 글</td>
			<td style="height:50px;border-top:1px solid #d6d6d6;font-size:16px;">
				<?=$next[wr_id] ? "<a href='/m/bbs/board.php?bo_table=".$bo_table."&wr_id=".$next[wr_id]."' style='color:#676767;'>".$next[wr_subject]."</a>" : "<font style='color:#a09f9f'>다음 글이 없습니다.</font>"?>
			</td>
		<tr>
	</table>
 
    <!-- 링크 버튼 -->
    <div style="text-align:center;margin-top:20px">
    <?=$link_buttons?>
    </div>

	<?/*?>
	<div class="Packageother">OTHER PACKAGE</div>


	<?
		
		//기간 지난 게시물은 숨김
		if($member[mb_level] < 10){
			//$where_query = " AND (ca_name = 'News' OR wr_3 >= '".date("Y-m-d")."') ";
		}

		$op_result = sql_query("
			SELECT
				*
			FROM 
			(
				SELECT 
					* 
				FROM 
					g4_write_$bo_table 
				WHERE 
					wr_is_comment != 1 AND
					wr_id != $view[wr_id]
					$where_query
				ORDER BY
					wr_num asc
			) as a
			limit 0, 100
		");
	?>


	<div class="Potherlist">	 
		<div class="Potherleft"><a href="javascript:opPrev()"><img src="/res/images/package_left.jpg" alt="이전 패키지" /></a></div>
		

		<div class="other_pack_list" style='float: left;width: 760px; height: 193px; overflow: hidden; margin: 0 0 0 30px;position:relative;'>
			
			<ul id='op_slide' style='width:100%;padding:0 0 0 0;position:absolute'>
				<?
				$cnt = 0;
				for($idx = 0 ; $op = sql_fetch_array($op_result) ; $idx++){ ?>
				<?
					$cnt++;
					$link_src = "/bbs/board.php?bo_table=$bo_table&wr_id={$op[wr_id]}";
				?>
				<?
					if($op[ca_name] == "News"){
						$img = "<img src='/res/images/news_img.jpg'  style='width:200px;height:120px'/>";
					} else {
						// 파일 출력
						$img = "";
						$view[file] = get_file($bo_table, $op[wr_id]);
						for ($i=0; $i<=count($view[file]); $i++) {
						    if ($view[file][$i][view]){
								    $img ="<img src='{$view[file][$i][path]}/{$view[file][$i][file]}' alt='Other News & Event Image' style='width:200px;height:120px'/>";
								    break;
						    } else {
								    $img ="<img src='{$board_skin_path}/img/noimg.gif' alt='Other News & Event Image' style='width:200px;height:120px'/>";
						    }
						}
					}

				?>

				<li onclick='location.href="<?=$link_src?>"' style='cursor:pointer'>
					<span class="Thum"><?=$img?></span>
					<span class="Tit"><?=cut_str($op[wr_subject], 37)?></span>
					<span class="Stit"><?=cut_str($op[wr_1], 44)?></span>
				</li>
				<?}?>
			</ul>

		</div>


		

		<div class="Potherright"><a href="javascript:opNext()"><img src="/res/images/package_right.jpg" alt="다음 패키지" /></a></div>
	</div>
	<?*/?>
</div>





<script type="text/javascript">

$("#op_slide").width(217 * <?=$cnt?>);
var ops_idx = 1;
var ops_movep = 720;

function opPrev(){
	if(ops_idx == 1) return;
	ops_idx--;

	var m = ops_movep * (ops_idx -1) * -1;
	$("#op_slide").animate({"left":m}, 700);
	
}

function opNext(){
	if(ops_idx == <?=ceil($cnt/3)?>) return;
	var m = ops_movep * ops_idx * -1;
	$("#op_slide").animate({"left":m}, 700);
	ops_idx++;
}


$(".chimg_photo").css({"width":"100%", "height":"auto"});
</script>



<script type="text/javascript">
function file_download(link, file) {
    <? if ($board[bo_download_point] < 0) { ?>if (confirm("'"+file+"' 파일을 다운로드 하시면 포인트가 차감(<?=number_format($board[bo_download_point])?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?"))<?}?>
    document.location.href=link;
}
</script>

<script type="text/javascript" src="<?="$g4[path]/js/board.js"?>"></script>
<script type="text/javascript">
window.onload=function() {
    resizeBoardImage(<?=(int)$board[bo_image_width]?>);
    drawFont();
}
</script>
<!-- 게시글 보기 끝 -->
