<?
include_once("./_common.php");

set_session("alimi_save_page", $_GET["save_page"]);
set_session("alimi_save_sc", $_GET["save_sc"]);

?>

<style>
	#divContent p, 
	#divContent div, 
	#divContent span {
		font-size:23px !important;
		line-height:1.5;
	}
	#divContent img {
		max-width:100%;
		height:initial !important;
	}
</style>



<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;"><?=$board[bo_subject]?> 글보기</div>
<div class="nbox">
	<div style="float:left;width:16.42%;margin-left:3.402%;margin-top:20px;"><a href="javascript:menum('menu02-1')"><img src="/app_helper/images/back_btn.jpg" style="width:100%"/></a></div>
	<div style="float:left;width:85.2%;margin-left:7.396%;margin-top:25px;color:#222222;font-size:26px;"><?=$view[wr_subject]?></div>
	<div style="position:relative;float:left;width:87.053%;border-bottom:2px solid #97979a;color:#676767;font-size:22px;margin-left:5.473%;margin-top:15px;line-height:50px;padding-left:2%;"><?=$view[wr_datetime]?>
		<div style="position:absolute;top:0;right:2%;">글쓴이 : <?=$view[wr_name]?></div>
	</div>


	<!-- ##############################################################################  -->
	<!-- 파일 / 링크  -->
	<?
	// 가변 파일
	$cnt = 0;
	for ($i=0; $i<count($view[file]); $i++) {
		if ($view[file][$i][source] && !$view[file][$i][view]) {

			$link=str_replace("./", "http://".$_SERVER["HTTP_HOST"]."/app_helper/bbs/",$view[file][$i][href]);
		
			$cnt++;
			echo "
				<div style='position:relative;float:left;width:87.053%;border-bottom:2px solid #e0e0e1;color:#6a6a6a;font-size:15px;margin-left:5.473%;padding-bottom:16px;margin-top:15px;padding-left:2%;'>
					<a href=\"javascript:cdv_file_download('{$link}', '{$view[file][$i][source]}', '{$view[file][$i][mime_type]}');\" title='{$view[file][$i][content]}'>
						{$view[file][$i][source]} ({$view[file][$i][size]})
						<span style='color:#ff6f2b;'>[{$view[file][$i][download]}]</span> DATE : {$view[file][$i][datetime]}
					</a>
				</div>
			";
		}
	}
	// 링크
	$cnt = 0;
	for ($i=1; $i<=$g4[link_count]; $i++) {
		if ($view[link][$i]) {
			$cnt++;
			$link = cut_str($view[link][$i], 70);
			echo "
				<div style='position:relative;float:left;width:87.053%;border-bottom:2px solid #e0e0e1;color:#6a6a6a;font-size:15px;margin-left:5.473%;padding-bottom:16px;margin-top:15px;padding-left:2%;'>
					<a href=\"{$view[link_href][$i]}\" target='_blank'>
						<img src='{$g4[mpath]}/images/icon/icon_link.gif' align=absmiddle border='0'>
						{$link}
						<span style='color:#ff6f2b;'>[{$view[link_hit][$i]}]</span>
					</a>
				</div>
			";
		}
	}
	?>

	<!-- ##############################################################################  -->
	<!-- 본문 내용 -->
	<div id="divContent" style="float:left;width:85.2%;margin-left:7.396%;margin-top:25px;color:#222222;font-size:23px;padding-bottom:26px;border-bottom:2px solid #e0e0e1;">		
		<?
		// 파일 출력
		for ($i=0; $i<=count($view[file]); $i++) {
			if ($view[file][$i][view])
				echo "<div class='board_img_file'>".$view[file][$i][view] . "</div><p>";
		}
		?>

		<?
		$html = 0;
		if (strstr($view[wr_option], "html1"))
			$html = 1;
		else if (strstr($view[wr_option], "html2"))
			$html = 2;
		$view[content] = conv_content($view[wr_content], $html);
		?>
		<?=$view['content']?>
	</div>




	<!-- ##############################################################################  -->
	<!-- 원글 / 답글 -->
	<?$repSqlCnt = sql_fetch(" SELECT count(*) cnt FROM g4_write_{$bo_table} where wr_num='$view[wr_num]' AND wr_is_comment != 1 order by wr_reply ");
	 if($repSqlCnt[cnt] > 1){
	 ?>

		<?
			$repSql = " SELECT * FROM g4_write_{$bo_table} where wr_num='$view[wr_num]' AND wr_is_comment != 1 order by wr_reply ";
			$reps = sql_query($repSql);
			for($ridx = 0; $rep = sql_fetch_array($reps) ; $ridx++){
		?>
			<a href='javascript:void(0)' onclick='location.href=g4_app_path+"/pages.php?p=2_2_1_1&bo_table=<?=$bo_table?>&wr_id=<?=$rep["wr_id"]?><?=$qstr?>";'>
				<?if($rep[wr_reply] == ""){?>
						<div class="ellipsis" style="float:left;width:85.2%;margin-left:7.396%;margin-top:25px;color:#6e6e6e;font-size:21px;padding-bottom:15px;border-bottom:2px solid #e0e0e1;">· <?=$rep["wr_subject"]?></div>
				<?} else {?>
					<div style="float:left;width:80.2%;margin-left:11.396%;margin-top:15px;">
						<div style="float:left;width:10%;margin-top:4px;"><img src="/app_helper/images/re_i.jpg" style="width:100%"/></div>
						<div class="ellipsis" style="float:left;width:87.2%;margin-left:2%;color:<?=($view[wr_id] == $rep[wr_id] ? "#1D1D1D;" : "#6e6e6e;")?>;font-size:21px;"><?=$rep["wr_subject"]?></div>
					</div>
				<?}?>
			</a>
		<?}?>
	<?}?>



	<!-- ##############################################################################  -->
	<!-- 댓글 -->
	<?include "{$g4["mpath"]}/include/_view_comment.php";?>




	<!-- ##############################################################################  -->
	<!-- 버튼 -->
	<div style="float:left;width:100%;margin-top:30px;margin-bottom:20px;">
		<div style="float:left;width:28.994%;margin-left:5.473%;"><a href="<?=$update_href?>"><img src="/app_helper/images/v_btn01.jpg" style="width:100%"/></a></div>
		<div style="float:left;width:28.994%;margin-left:1.035%;"><a href="<?=$delete_href?>"><img src="/app_helper/images/v_btn02.jpg" style="width:100%"/></a></div>
		<div style="float:left;width:28.994%;margin-left:1.035%;"><a href="<?=$reply_href?>"><img src="/app_helper/images/v_btn03.jpg" style="width:100%"/></a></div>
	</div>
</div>


<script type="text/javascript">
function file_download(link, file) {
    <? if ($board[bo_download_point] < 0) { ?>if (confirm("'"+file+"' 파일을 다운로드 하시면 포인트가 차감(<?=number_format($board[bo_download_point])?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?"))<?}?>
    document.location.href=link;
}
window.onload=function() {
	resizeBoardImage(screen.width-20);
}
$(function(){
	$(".view_contents img, .board_img_file img").each(function(){
		$("<div style='font-size:0.8em; padding:5px;'>*이미지를 클릭하시면 확대됩니다.</div>").insertAfter($(this));
		$(this).click(function(){
			in_app_browser($(this).attr("src"));
		});
		
	});
});
</script>