<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<style>
.member {font-weight:normal;color:#939393;}
.guest  {font-weight:normal;color:#939393;}
#writeContents,
#writeContents p, 
#writeContents div {display:block;line-height:1.5em;}
#writeContents img { max-width:580px !important; height:auto !important; }
span.nBtn1 { background:#484848; color:#ffffff; padding:10px 7px; font-size:16px; text-decoration:none; display:inline-block; }
span.nBtn2 { background:#727272; color:#ffffff; padding:10px 7px; font-size:16px; text-decoration:none; display:inline-block; }
span.nBtn3 { background:#dddddd; color:#555555; padding:10px 7px; font-size:16px; text-decoration:none; display:inline-block; }
</style>
<div style="height:12px; line-height:1px; font-size:1px;display:none">&nbsp;</div>

<!-- 게시글 보기 시작 -->
<table width="<?=$width?>" align="center" cellpadding="0" cellspacing="0"><tr><td>




<div style="line-height:32px; border-top:0px solid #7d7d7d; border-bottom:2px solid #d6d6d6; padding-bottom:5px; ">
    <table border=0 cellpadding=0 cellspacing=0 width=100%>
    <tr>
        <td>
			<div style="color:#343434; font-size:23px; line-height:38px;font-weight:bold; word-break:break-all;">
				<? if ($is_category) { echo ($category_name ? "[$view[ca_name]] " : ""); } ?>
				<?=cut_hangul_last(get_text($view[wr_subject]))?>
			</div>  
        </td>
        <td align="right" style="padding:6px 6px 0 0;">
           <!-- <? if ($scrap_href) { echo "<a href=\"javascript:;\" onclick=\"win_scrap('$scrap_href');\"><img src='$board_skin_path/img/btn_scrap.gif' border='0' align='absmiddle'></a> "; } ?>
            <? if ($trackback_url) { ?><a href="javascript:trackback_send_server('<?=$trackback_url?>');" style="letter-spacing:0;" title='주소 복사'><img src="<?=$board_skin_path?>/img/btn_trackback.gif" border='0' align="absmiddle"></a><?}?>-->
        </td>
    </tr>
    </table>
</div>

<?
// 분류사용, 상품사용하는 상품의 정보를 얻음
$sql = " select a.*,
                b.ca_name,
                b.ca_use
           from $g4[yc4_item_table] a,
                $g4[yc4_category_table] b
          where a.it_id = '$view[wr_6]'
            and a.ca_id = b.ca_id ";
$it = sql_fetch($sql);
$middle_image = $it[it_id]."_m";

$is_has = false;
if($it[it_name]) $is_has = true;

/*
$star = intval($view[wr_4])<10?'0'.$view[wr_4]:$view[wr_4];
$star_img = "<img src='".$board_skin_path."/img/star".$star.".gif' alt='$view[wr_4]' border=0 />";
$avg_value = sql_fetch("SELECT AVG(wr_4) as avg from g4_write_".$bo_table." where wr_6 = '".$view[wr_6]."' ");
$score = $view[wr_4]." 점 (평균 ".$avg_value[avg]." 점) ";
*/
?>
<table border=0 cellpadding=0 cellspacing=0 width=100% style="margin-top:10px;" >
<tr>
    <td>
		<table cellpadding="0" cellspacing="0" border="0" style="width:100%;" >
			<tr>
				<?if($it[it_id]){?>
				<td style="padding:3px 0 0 0">
					<a href="/m/shop/item.php?it_id=<?=$view[wr_6]?>#qnalist">
						<?=get_it_image2($it[it_id], '_s','140','140');?>
					</a>
				</td>
				<?}?>
				<td style="padding:0 0 0px 0px;width:100%;">
					<style>
						.request { color:#ffffff; width:100%;height:140px; margin:0 auto; margin-top:0px; border-top:1px solid #dddddd; border-right:0; border-left:0;line-height:15px; }
						.request th,
						.request td { padding:8px 10px; border-bottom:1px solid #dddddd;line-height:15px;font-size:16px;  }
						.request th { text-align:left; color:#676767;font-weight:bold; font-size:16px; background:#f3f3f3;line-height:15px;  }
						.request td { color:#444444; }
					</style>
					<table class="request" cellspacing="0" style="width:100%;" >
						<colgroup>
							<col style="width:70px">
							<col>
						</colgroup>
						<tbody>
							<?if($it[it_id]){?>
							<tr>
								<th>상품명</th>
								<td><?=$it[it_name]?></td>
							</tr>
							<?}?>
							<tr>
								<th>작성자</th>
								<td><?=$view[name]?><? if ($is_ip_view) { echo "&nbsp;($ip)"; } ?></td>
							</tr>
							<tr>
								<th>작성일</th>
								<td><?=date("Y-m-d H:i", strtotime($view[wr_datetime]))?></td>
							</tr>
							
						</tbody>
					</table>
				</td>
			</tr>
		</table>
	    <!-- <div style="float:left;">
        &nbsp;글쓴이 :
        <?=$view[name]?><? if ($is_ip_view) { echo "&nbsp;($ip)"; } ?>
        </div>
        <div style="float:right;">
		<span style="color:#444444;">작성일 : <?=date("Y-m-d H:i", strtotime($view[wr_datetime]))?></span>&nbsp;&nbsp;
        조회 : <?=number_format($view[wr_hit])?>
        <? if ($is_good) { ?>&nbsp;<img src="<?=$board_skin_path?>/img/icon_good.gif" border='0' align=absmiddle> 추천 : <?=number_format($view[wr_good])?><? } ?>
        <? if ($is_nogood) { ?>&nbsp;<img src="<?=$board_skin_path?>/img/icon_nogood.gif" border='0' align=absmiddle> 비추천 : <?=number_format($view[wr_nogood])?><? } ?>
        &nbsp;
        </div> -->
    </td>
</tr>
<!--<?
$bo=substr($bo_table,0,9);
?>
<?if($bo=='menu05_01'){?>
<?if($is_admin){?>
<tr>
<td>
		<font color="#444444">&nbsp;연락처 :
		<?=$view[wr_1]?></font><font color="red">&nbsp;&nbsp;&nbsp;( · 연락처는 관리자만 보입니다. ) </font>
</td>
</tr>
<?}?>
<?}?>-->
<?
// 가변 파일
$cnt = 0;
for ($i=0; $i<count($view[file]); $i++) {
    if ($view[file][$i][source] && !$view[file][$i][view]) {
        $cnt++;
        echo "<tr><td height=30 background=\"$board_skin_path/img/view_dot.gif\">";
        echo "&nbsp;&nbsp;<img src='{$board_skin_path}/img/icon_file.gif' align=absmiddle border='0'>";
        echo "<a href=\"javascript:file_download('{$view[file][$i][href]}', '{$view[file][$i][source]}');\" title='{$view[file][$i][content]}'>";
        echo "&nbsp;<span style=\"color:#888;\">{$view[file][$i][source]} ({$view[file][$i][size]})</span>";
        echo "&nbsp;<span style=\"color:#ff6600; font-size:11px;\">[{$view[file][$i][download]}]</span>";
        echo "&nbsp;<span style=\"color:#d3d3d3; font-size:11px;\">DATE : {$view[file][$i][datetime]}</span>";
        echo "</a></td></tr>";
    }
}

// 링크
$cnt = 0;
for ($i=1; $i<=$g4[link_count]; $i++) {
    if ($view[link][$i]) {
        $cnt++;
        $link = cut_str($view[link][$i], 70);
        echo "<tr><td height=30 background=\"$board_skin_path/img/view_dot.gif\">";
        echo "&nbsp;&nbsp;<img src='{$board_skin_path}/img/icon_link.gif' align=absmiddle border='0'>";
        echo "<a href='{$view[link_href][$i]}' target=_blank>";
        echo "&nbsp;<span style=\"color:#888;\">{$link}</span>";
        echo "&nbsp;<span style=\"color:#ff6600; font-size:11px;\">[{$view[link_hit][$i]}]</span>";
        echo "</a></td></tr>";
    }
}
?>
<tr>
    <td height="150" style="word-break:break-all; padding:10px;">
        <?
        // 파일 출력
        for ($i=0; $i<=count($view[file]); $i++) {
            if ($view[file][$i][view])
                echo $view[file][$i][view] . "<p>";
        }
        ?>

        <!-- 내용 출력 -->
        <span id="writeContents"><?=$view[content];?></span>

        <?//echo $view[rich_content]; // {이미지:0} 과 같은 코드를 사용할 경우?>
        <!-- 테러 태그 방지용 --></xml></xmp><a href=""></a><a href=''></a>

        <? if ($nogood_href) {?>
        <div style="width:72px; height:55px; background:url(<?=$board_skin_path?>/img/good_bg.gif) no-repeat; text-align:center; float:right;">
        <div style="color:#888; margin:7px 0 5px 0;">비추천 : <?=number_format($view[wr_nogood])?></div>
        <div><a href="<?=$nogood_href?>" target="hiddenframe"><img src="<?=$board_skin_path?>/img/icon_nogood.gif" border='0' align="absmiddle"></a></div>
        </div>
        <? } ?>

        <? if ($good_href) {?>
        <div style="width:72px; height:55px; background:url(<?=$board_skin_path?>/img/good_bg.gif) no-repeat; text-align:center; float:right;">
        <div style="color:#888; margin:7px 0 5px 0;"><span style='color:crimson;'>추천 : <?=number_format($view[wr_good])?></span></div>
        <div><a href="<?=$good_href?>" target="hiddenframe"><img src="<?=$board_skin_path?>/img/icon_good.gif" border='0' align="absmiddle"></a></div>
        </div>
        <? } ?>

</td>
</tr>
<? if ($is_signature) { echo "<tr><td align='center' style='border-bottom:1px solid #E7E7E7; padding:5px 0;'>$signature</td></tr>"; } // 서명 출력 ?>
</table>
<br>

<?
// 코멘트 입출력
//include_once("./view_comment.php");
?>

<div style="height:1px; line-height:1px; font-size:1px; background-color:#d6d6d6; clear:both;">&nbsp;</div>


<div style="clear:both; height:30px;display:none">
    <div style="float:left; margin-top:6px;">


    </div>

    <!-- 링크 버튼
    <div style="float:right;">
    <?
    ob_start();
    ?>
	<?if($is_has){?>
	<? echo "<a href=\"/m/shop/item.php?it_id={$view[wr_6]}#qnalist\"><span class='nBtn1'>&lt;&lt;&nbsp;상품으로</span></a> "; ?>
	<?}?>
	<? if ($search_href) { echo "<a href=\"$search_href\"><span class='nBtn1'>검색목록</span></a> "; } ?>
	<? echo "<a href=\"$list_href\"><span class='nBtn1'>목록보기</span></a> "; ?>
    <?// if ($copy_href) { echo "<a href=\"$copy_href\"><span class='nBtn3'>복사하기</span></a> "; } ?>
    <?// if ($move_href) { echo "<a href=\"$move_href\"><span class='nBtn3'>이동하기</span></a> "; } ?>
	<? if ($delete_href) { echo "<a href=\"$delete_href\"><span class='nBtn3'>삭제하기</span></a> "; } ?>
    <? if ($reply_href) { echo "<a href=\"$reply_href\"><span class='nBtn3'>답변하기</span></a> "; } ?>
	<? if ($update_href) { echo "<a href=\"$update_href\"><span class='nBtn2'>수정하기</span></a> "; } ?>
    <? if ($write_href) { echo "<a href=\"$write_href\"><span class='nBtn2'>글쓰기</span></a> "; } ?>
    <?
    $link_buttons = ob_get_contents();
    ob_end_flush();
    ?>
    </div> -->
</div>


<div style="clear:both; height:43px;">
    <!-- <div style="float:left; margin-top:10px;">
    <? if ($prev_href) { echo "<a href=\"$prev_href\" title=\"$prev_wr_subject\"><span class='nBtn'>이전글</span></a>"; } ?>
    <? if ($next_href) { echo "<a href=\"$next_href\" title=\"$next_wr_subject\"><span class='nBtn'>다음글</span></a>"; } ?>
    </div> -->

    <!-- 링크 버튼 -->
    <div style="text-align:center;margin-top:20px">
    <?=$link_buttons?>
    </div>
</div>

<!-- <div style="height:2px; line-height:1px; font-size:1px; background-color:#dedede; clear:both;">&nbsp;</div> -->

</td></tr></table><br>

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
