<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

//고객평가테이블
$qna_board = $g4["yc4_qna_bo_table"]; // shop.config.php

$bdObj = new Board($qna_board);
$bd = $bdObj->get_board();
if($bd["bo_table"]) { //게시판이 없으면 무시
?>


<!-- 고객평가 시작 -->
<?
//게시글 읽어오기!!!! 각업체에 해당하는 평가글!!!
$sql = "
	SELECT 
		a.*
		, (select wr_datetime FROM g4_write_{$qna_board} WHERE wr_num=a.wr_num AND wr_reply = '' AND wr_is_comment=0 ) wr_p_datetime 
		, (select mb_id FROM g4_write_{$qna_board} WHERE wr_num=a.wr_num AND wr_reply = '' AND wr_is_comment=0 ) p_mb_id 
	FROM 
		g4_write_{$qna_board} a 
	WHERE
		wr_6 = '".$it[it_id]."' 
		AND 
			wr_is_comment <> '1' 
	order by 
		wr_num asc, wr_reply asc 
	limit 15
";
$bbs_result = sql_query($sql);
$bbs_info = sql_fetch("select * from g4_board where bo_table = '{$qna_board}' ");
//평점..
$avg_value = sql_fetch("SELECT AVG(wr_4) as avg from g4_write_{$qna_board} where wr_6 = '".$it_id."' ");
if(!$avg_value[avg]){
	$avg_value[avg] = "10";
}else{
	$avg_value[avg] = ceil($avg_value[avg]);
}

$avg_str = intval($avg_value[avg])<10?'0'.$avg_value[avg]:$avg_value[avg];
$board_skin_path = "/skin/board/".$bbs_info[bo_skin];
$bbs_list = array();
while($bbs_item = sql_fetch_array($bbs_result)){
	$bbs_list[] = get_list($bbs_item, $bbs_info, $bbs_info[bo_skin], $bbs_info[bo_subject_len]);
}
?>


<style>
.Cons p,
.Cons div {display:block;line-height:1.5em;}
.Cons {display:block; min-height:100px;}
a.afterlist_btn { display:inline-block; padding:3px 8px; color:#fff; font-size:13px; text-decoration:none; background:#4b4b4b; }
</style>
<div style="height:10px;">
</div>
<!-- <div class="Sstit"><img src="/res/images/s_subtit09.gif" /></div> -->
<div class="RoomBox02" id="qnalist">
	<div class="RoomBox02In" style="border:1px solid #fff;">
		<div style="float:left;width:100%;padding:0 0 10px 0;">
			<div style="float:left;width:22%;"></div>
			<div style="float:right;">
				<a href="/bbs/write.php?bo_table=<?=$qna_board?>&item_id=<?=$it_id?>" class="afterlist_btn" ><span>질문하기</span></a>&nbsp;&nbsp;
				<a href="/bbs/board.php?bo_table=<?=$qna_board?>&cate_id=<?=$it[ca_id]?>&sop=and&sca=" class="afterlist_btn" ><span>+ 더보기</span></a>
			</div>
		</div>
		<?
		for($b=0; $b<count($bbs_list); $b++){

		
			$isReply = "<span style='font-weight:bold;'> &nbsp;&nbsp;Q. </span>";
			if($bbs_list[$b][wr_reply]){
				$isReply = "<span style='font-weight:bold;'> &nbsp;&nbsp;A. <img src='$board_skin_path/img/icon_reply.gif' align='absmiddle'></span>";
			}

			$html = 0;
			if (strstr($bbs_list[$b][wr_option], "html1"))
				$html = 1;
			else if (strstr($bbs_list[$b][wr_option], "html2"))
				$html = 2;
			$bbs_list[$b][content] = conv_content($bbs_list[$b]["wr_content"], $html);


			//비밀글 여부
			$is_secret = false;
			$secret_icon = strstr($bbs_list[$b]['wr_option'], "secret") ? '<i class="fa fa-lock"></i> ' : '';
			if (!$is_admin && strstr($bbs_list[$b]['wr_option'], "secret")) {
				$is_secret = true;
			}

			//비밀글인데 내가 작성한 글이거나 내가 작성한글의 답글
			if($is_secret && $member["mb_id"] && ($member["mb_id"] == $bbs_list[$b]["mb_id"] || $member["mb_id"] == $bbs_list[$b]["p_mb_id"] )) {
				$is_secret = false;
			}
			
			if($is_secret) {
				$goScript = "go_qna_view('{$bbs_list[$b]["wr_id"]}')";
			} else {
				$goScript = "show_qna_content('{$b}')";
			}
			
			?>



				<!-- 제목 -->
				<div style="float:left;width:100%;border-top:1px solid #d6d6d6;padding:10px 0 0 0;background:#f6f6f6;">
					<div style="float:left;width:22%;;color:#000">
						&nbsp;&nbsp;<span style="display:inline-block;width:100px;"><?=$bbs_list[$b][name]?></span>
						&nbsp;&nbsp;<span style="font-size:11px;;color:#000"><?=$bbs_list[$b][datetime]?></span>
					</div>
					<div style="float:left;width:20%;color:#4a4a4a; text-overflow:ellipsis; overflow:hidden; white-space:nowrap;">
						<a href='javascript:void(0)' onclick="<?=$goScript?>" style="color:#000">
							<?=$isReply?>&nbsp;&nbsp;<strong><?=$bbs_list[$b][subject]?></strong>
						</a>
					</div>
					<div style="float:left;width:58%;padding:0 0 10px 0; text-overflow:ellipsis; overflow:hidden; white-space:nowrap;">
						<a href='javascript:void(0)' onclick="<?=$goScript?>" style="color:#000">
							<?if($is_secret) {?>
								<span style="color:#9a9a9a">
									<i class="fa fa-lock"></i> 비밀글입니다.
								</span>
							<?} else {?>
								<?=$secret_icon?> <?=cut_str(strip_tags($bbs_list[$b][wr_content]),240,"…")?>
							<?}?>
						</a>
					</div>
				</div>
				


				<!-- 내용 -->
				<div class="qna_list qna_list_<?=$b?>" style="display:none;float:left;width:98%;border-top:1px solid #d6d6d6;padding:1%;background:#fff;">
					<?if($is_secret) {?>
						<span style="color:#9a9a9a">
							<i class="fa fa-lock"></i> 비밀글입니다.
						</span>
					<?} else {?>
						<span class="Cons"><?=$bbs_list[$b][content]?></span>
						<div style="width:100%;text-align:right;">
							<?if($is_admin && !$bbs_list[$b][wr_reply]){?>
								<a href="/bbs/write.php?w=r&bo_table=<?=$qna_board?>&wr_id=<?=$bbs_list[$b][wr_id]?>" style="color:#000"><span class='btn1-o'>답변하기</span></a>
							<?}?>
							<a href="/bbs/board.php?bo_table=<?=$qna_board?>&wr_id=<?=$bbs_list[$b][wr_id]?>" style="color:#000"><span class='btn1'>상세/수정/삭제</span></a>
						</div>
					<?}?>
				</div>


		<?
		}	if($b == 0) echo "<div>이 상품에 대한 Q&A가 아직 없습니다.</div>"
		?>		
	</div>
</div>

<script>
	function show_qna_content(b){
            $('.qna_list_'+b).siblings(".qna_list").hide();
            if($('.qna_list_'+b).is(":visible")) {
                $('.qna_list_'+b).slideUp('fast');
            } else {
                $('.qna_list_'+b).slideDown('fast');
            }
	}
	function go_qna_view(wr_id){
		window.open("<?=$g4["bbs_path"]?>/board.php?bo_table=<?=$qna_board?>&wr_id="+wr_id);
	}
</script>


<?}?>