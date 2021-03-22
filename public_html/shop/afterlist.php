<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

//상품후기 테이블 게시판경로
$after_board = $g4["yc4_after_bo_table"]; //shop.config.php

$bdObj = new Board($after_board);
$bd = $bdObj->get_board();
if($bd["bo_table"]) { //게시판이 없으면 무시
?>





<!-- 고객평가 시작 -->
<?
$bbs_result = sql_query("SELECT a.*, (select wr_datetime FROM g4_write_{$after_board} WHERE wr_num=a.wr_num AND wr_reply != '' AND wr_is_comment=0 ) wr_p_datetime FROM g4_write_{$after_board} as a WHERE wr_6 = '".$it[it_id]."' and wr_is_comment <> '1' order by wr_p_datetime desc limit 10");
$bbs_info = sql_fetch("select * from g4_board where bo_table = '{$after_board}' ");
//평점..
$avg_value = sql_fetch("SELECT AVG(wr_4) as avg from g4_write_{$after_board} where wr_6 = '".$it_id."' AND wr_reply='' ");
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

<div style="height:10px;">
</div>

<style>
span.member {color:#000}
.Cons p,
.Cons div {display:block;line-height:1.5em;}

a.afterlist_btn { display:inline-block; padding:3px 8px; color:#fff; font-size:13px; text-decoration:none; background:#4b4b4b; }
</style>

<!-- <div class="Sstit"><img src="/res/images/s_subtit08.gif" /></div> -->
<div class="RoomBox02" id="afterlist">
	<div class="RoomBox02In" style="border:1px solid #fff;">

		<div style="float:left;width:100%;padding:0 0 10px 0;">
			
			<!-- <div style="float:left;width:22%;"><img src="<?=$board_skin_path?>/img/star<?=$avg_str?>.gif" />&nbsp;&nbsp;<strong>평점 : <span style="color:red;"><?=$avg_value[avg]?></span>점</strong></div> -->
			
			<div style="float:right;">
				<a href="/bbs/write.php?bo_table=<?=$after_board?>&item_id=<?=$it_id?>" class="afterlist_btn" ><span>평가하기</span></a>&nbsp;&nbsp;
				<a href="/bbs/board.php?bo_table=<?=$after_board?>&cate_id=<?=$it[ca_id]?>&sop=and&sca=" class="afterlist_btn" ><span>+ 더보기</span></a>
			</div>
		</div>

		<?
		for($b=0; $b<count($bbs_list); $b++){
		
			if($bbs_list[$b][wr_reply]){
				$isReply = "&nbsp;<span><img src='$board_skin_path/img/icon_reply.gif' align='absmiddle'></span>";
				$star = intval($bbs_list[$b][wr_4])<10?'0'.$bbs_list[$b][wr_4]:$bbs_list[$b][wr_4]; 				
				$star_img = "<img src='$board_skin_path/img/star".$star.".gif' alt='$bbs_list[$b][wr_4]' border=0  style='visibility:hidden'/>";
			} else {
				$star = intval($bbs_list[$b][wr_4])<10?'0'.$bbs_list[$b][wr_4]:$bbs_list[$b][wr_4]; 				
				$star_img = "<img src='$board_skin_path/img/star".$star.".gif' alt='$bbs_list[$b][wr_4]' border=0 />";
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
				$goScript = "go_after_view('{$bbs_list[$b]["wr_id"]}')";
			} else {
				$goScript = "show_after_content('{$b}')";
			}

		?>

				<!-- 제목 -->
				<div style="float:left;width:100%;border-top:1px solid #d6d6d6;padding:10px 0 0 0;background:#f6f6f6;">
					<div style="float:left;width:23%;color:#000"><?=$star_img?><?=$isReply?>&nbsp;&nbsp;<?=$bbs_list[$b][name]?>&nbsp;&nbsp;<span style="font-size:11px;color:#000"><?=$bbs_list[$b][datetime]?></span></div>

					<div style="float:left;width:20%;color:#4a4a4a; text-overflow:ellipsis; overflow:hidden; white-space:nowrap;">
						<a href='javascript:void(0)' onclick="<?=$goScript?>" style="color:#000"><strong><?=$bbs_list[$b][subject]?></strong></a>
					</div>
					<div style="float:left;width:57%;padding:0 0 10px 0; text-overflow:ellipsis; overflow:hidden; white-space:nowrap;">
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
				<div class="after_list after_list_<?=$b?>" style="display:none;float:left;width:98%;border-top:1px solid #d6d6d6;padding:1%;background:#fff;">
					
					<?if($is_secret) {?>
						<span style="color:#9a9a9a">
							<i class="fa fa-lock"></i> 비밀글입니다.
						</span>
					<?} else {?>
						<span class="Cons"><?=$bbs_list[$b][content]?></span>
						<div style="width:100%;text-align:right;">
							<a href="/bbs/board.php?bo_table=<?=$after_board?>&wr_id=<?=$bbs_list[$b][wr_id]?>" style="color:#000"><span class='btn1'>상세/수정/삭제</span></a>
						</div>
					<?}?>

				</div>


		<?
		}	if($b == 0) echo "<div>이 상품에 대한 사용후기가 아직 없습니다.<br/>사용후기를 작성해 주시면 다른 분들께 많은 도움이 됩니다.</div>"
		?>		
	</div>

	<script>
		function show_after_content(b){

			$('.after_list_'+b).siblings(".after_list").hide();
            if($('.after_list_'+b).is(":visible")) {
                $('.after_list_'+b).slideUp('fast');
            } else {
                $('.after_list_'+b).slideDown('fast');
			}
			
		}
		function go_after_view(wr_id){
			window.open("<?=$g4["bbs_path"]?>/board.php?bo_table=<?=$after_board?>&wr_id="+wr_id);
		}
	</script>
</div>
<br/>
<br/>



<?}?>