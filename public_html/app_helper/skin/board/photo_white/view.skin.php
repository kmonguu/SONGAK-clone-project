<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if(!$view[wr_id]) goto_url($g4[mpath]."/bbs/board.php?bo_table=$bo_table");
?>




<style type="text/css">
#m_view img { max-width:600px;}
#m_view div, #m_view p, #m_view span {font-size:24px;}
.view_contents div, .view_contents p, .view_contents span {font-size:24px !important; line-height:1.5 !important; }
</style>

<div id="m_view">
<div style="height:28px; clear:both;"></div>
	<h3 style='font-size:24px'><? if ($is_category) { echo ($category_name ? "[$view[ca_name]] " : ""); } ?>
            <?=cut_hangul_last(get_text($view[wr_subject]))?>
	<div class="line"></div>
	<p><?=$view[wr_datetime]?> , 조회 : <?=$view[wr_hit]?></p>
	<p>글쓴이 <strong><?=$view[wr_name]?></strong></p>
	<?
	// 가변 파일
	$cnt = 0;
	for ($i=0; $i<count($view[file]); $i++) {
		if ($view[file][$i][source] && !$view[file][$i][view]) {

			$link=str_replace("./",$g4[bbs_path]."/",$view[file][$i][href]);

			$cnt++;
			echo "<p>";
			echo "&nbsp;&nbsp;<img src='{$g4[mpath]}/images/icon/icon_file.gif' align=absmiddle border='0'>";
			echo "<a href=\"javascript:file_download('{$link}', '{$view[file][$i][source]}');\" title='{$view[file][$i][content]}'>";
			echo "&nbsp;<span style=\"color:#888;\">{$view[file][$i][source]} ({$view[file][$i][size]})</span>";
			echo "&nbsp;<span style=\"color:#ff6600; font-size:11px;\">[{$view[file][$i][download]}]</span>";
			echo "&nbsp;<span style=\"color:#d3d3d3; font-size:11px;\">DATE : {$view[file][$i][datetime]}</span>";
			echo "</a></p>";
		}
	}

	// 링크
	$cnt = 0;
	for ($i=1; $i<=$g4[link_count]; $i++) {
		if ($view[link][$i]) {
			$cnt++;
			$link = cut_str($view[link][$i], 70);
			echo "<p>";
			echo "&nbsp;&nbsp;<img src='{$g4[mpath]}/images/icon/icon_link.gif' align=absmiddle border='0'>";
			echo "<a href='{$view[link_href][$i]}' target='_blank'>";
			echo "&nbsp;<span style=\"color:#888;\">{$link}</span>";
			echo "&nbsp;<span style=\"color:#ff6600; font-size:11px;\">[{$view[link_hit][$i]}]</span>";
			echo "</a></p>";
		}
	}

	// 파일 출력
	/*
	for ($i=0; $i<=count($view[file]); $i++) {
		if ($view[file][$i][view])
			echo $view[file][$i][view] . "<p>";
	}
	*/
	?>
	<div class="view_contents"><?=$view['content']?></div>
	<div class="blank"></div>
	

	<!-- 링크 버튼
	<div style="float:right;">
	<?
	ob_start();
	?>
	<? if ($update_href) { echo "<li><span style='margin-left:11px; font-weight:bold;'><a href=\"$update_href\">수정하기</a></span></li>"; }?>
	<? if ($reply_href) { echo "<li><span style='margin-left:11px; font-weight:bold;'><a href=\"$reply_href\">답변하기</a></span></li>"; }?>
	<? if ($delete_href) { echo "<li><span style='margin-left:11px; font-weight:bold;'><a href=\"$delete_href\">삭제하기</a></span></li>"; }?>
	<? echo "<li><a href=\"$list_href\"><span style='margin-left:11px; font-weight:bold;'>목록보기</span></a></li> "; ?>
	<?
	$link_buttons = ob_get_contents();
	ob_end_flush();
	?>
	</div> -->

	<?
	// 코멘트 입출력
	include_once("./view_comment.php");
	?>

</div>
<script type="text/javascript">
function file_download(link, file) {
    <? if ($board[bo_download_point] < 0) { ?>if (confirm("'"+file+"' 파일을 다운로드 하시면 포인트가 차감(<?=number_format($board[bo_download_point])?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?"))<?}?>
    document.location.href=link;
}
window.onload=function() {
	//resizeBoardImage(screen.width-20);
}
</script>


   <div style="padding-bottom:98px;"></div>