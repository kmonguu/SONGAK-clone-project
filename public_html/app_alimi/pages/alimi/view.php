<?
include "./_common.php";
include_once("./_head.php");
include "./pages/bbs/view.php";

//if(!$view[wr_id]) goto_url($g4[mpath]."/list.php?bo_table=$bo_table");


// 수정, 삭제 링크
$update_href = $delete_href = "";

if ($is_admin) {
    //$update_href = "javascript:go_link_page('p=1_3_1_1&w=u&bo_table=$bo_table&wr_id=$wr_id&page=$page" . $qstr."')";
    $update_href = "./pages.php?p=1_3_1_1&w=u&bo_table=$bo_table&wr_id=$wr_id&page=$page" . $qstr;
    $reply_href = "./pages.php?p=1_3_1_1&w=r&bo_table=$bo_table&wr_id=$wr_id" . $qstr;
    $delete_href = "javascript:del('$g4[app_path]/pages/alimi/delete.php?bo_table=$bo_table&wr_id=$wr_id&page=$page".urldecode($qstr)."&mobile=true');";
    
    if ($is_admin)
    {
        set_session("ss_delete_token", $token = uniqid(time()));
        $delete_href = "javascript:del('$g4[app_path]/pages/alimi/delete.php?bo_table=$bo_table&wr_id=$wr_id&token=$token&page=$page".urldecode($qstr)."&mobile=true');";
    }
}


?>
<style>
#m_view img { width:300px;}
</style>


<div style='width:100%;text-align:center;font-size:13pt;border-bottom:1px solid #ddd;font-weight:bold;padding:0 0 5px 0'><?=$board[bo_subject]?></div>

<div id="m_view" style='border-bottom:0px'>
	<h3>제목 : <?=$view[wr_subject]?></h3>
	<div class="line"></div>
	<p><?=$view[wr_datetime]?> , 조회 : <?=$view[wr_hit]?></p>
	<p>글쓴이 <strong><?=$view[wr_name]?></strong></p>
	
	<?if($view[wr_1]){?>
	<ul style='line-height:2;margin-left:-10px'>
		<li><strong>연락처</strong> <span style="float:right;width:70%"><a href="tel:<?=$view[wr_1]?>"><?=$view[wr_1]?></a></span></li>
	</ul>
	<?}?>

	<?
	// 가변 파일
	$cnt = 0;
	for ($i=0; $i<count($view[file]); $i++) {
		if ($view[file][$i][source] && !$view[file][$i][view]) {

			$link=str_replace("./",$g4[bbs_path]."/",$view[file][$i][href]);

			$cnt++;
			echo "<p>";
			echo "<a href=\"javascript:file_download('{$link}', '{$view[file][$i][source]}');\" title='{$view[file][$i][content]}'>";
			echo "<span style=\"color:#888;\">{$view[file][$i][source]} ({$view[file][$i][size]})</span>";
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
	for ($i=0; $i<=count($view[file]); $i++) {
		if ($view[file][$i][view])
			echo "<div class='board_img_file'>".$view[file][$i][view] . "</div><p>";
	}

	?>
	
	<div class="view_contents"><?=$view['content']?></div>
	<div class="blank"></div>

	<?//if($is_admin){?>
	<?//include "./pages/alimi/m.cmt.php";?>
	<?//}?>
	
	 <?$repSqlCnt = sql_fetch(" SELECT count(*) cnt FROM g4_write_{$bo_table} where wr_num='$view[wr_num]' AND wr_is_comment != 1 order by wr_reply ");
	 if($repSqlCnt[cnt] > 1){
	 ?>
	<div id="m_view" style='font-size:12pt;border:0px'>
			<?
				$repSql = " SELECT * FROM g4_write_{$bo_table} where wr_num='$view[wr_num]' AND wr_is_comment != 1 order by wr_reply ";
				$reps = sql_query($repSql);
			
				for($ridx = 0; $rep = sql_fetch_array($reps) ; $ridx++)
				{
					echo "<a data-ajax='false' data-transition='none' href='javascript:go_link_page(\"p=1_2_1_1&bo_table=$bo_table&wr_id=$rep[wr_id]\")'>";
					echo "<div style='padding:7px 0 7px 0;".($view[wr_id] == $rep[wr_id] ? "color:#333;" : "color:gray")."' >";
					if($rep[wr_reply] != "")
						echo " <img src='/skin/board/basic_white/img/icon_reply.gif' style='width:26px;height:15px' align='absmiddle'/> ";
					else
						echo " 원본글 : ";
					echo "$rep[wr_subject] <br/>";		
					echo "</div>";
					echo "</a>";
				}
		 ?>
	</div>
	<?}?>


	<?if($is_admin){?>
	<div id="m_cmt_write" style='border:0px;padding:5px 0 0 0;'>
		<ul>
		<li style='padding:0 0 0 0;'><div style='width:80%;margin:0 auto' ><a href="<?=$update_href?>" data-ajax=false data-transition="none" style=''><input type="button" value="수정하기" /></a></div></li>
		<li style='padding:0 0 0 0'><div style='width:80%;margin:0 auto' ><a href="<?=$delete_href?>"  data-transition="none"><input type="button" value="삭제하기" /></a></div></li>
		<?if($is_admin){ ?>
		<li style='padding:0 0 0 0'><div style='width:80%;margin:0 auto' ><a href="<?=$reply_href?>" data-ajax="false" data-transition="none"><input type="button" value="답글쓰기" /></a></div></li>
		<?}?>
		</ul>
	</div>

	<?}?>

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
<?
//include $g4[mpath]."/m.list.php";
//include $g4[mpath]."/tail.php";
include_once("./_tail.php");
?>