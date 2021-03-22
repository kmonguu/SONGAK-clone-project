<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once("$g4[path]/lib/thumb.lib.php");

$imgcolor="#dfdfdf";
$imgbordercolor="#dfdfdf";
$imgbordersize="2";
?>
<style>
body, td, p, input, button, textarea, select, .c1 {font-family:돋움; font-size:15px;}
.member {font-weight:normal;color:#444444;}
.guest  {font-weight:normal;color:#444444;}
#writeContents {line-height:1.5em;}
.line_wrap {width:100%;height:160px; border:2px solid #dfdfdf;}
.line_wrap table {border-spacing:0; border-collapse:collapse; border-style:none;}
.line_wrap table tr {height:26px;}
.line_wrap table td { color:#636363;}
table.thum {margin-left: 34px; margin-top: 17px;}
th.tt {width:180px; text-align:left;}
.title1 {display:block;font-weight:bold;font-size:20px;color:#856f56;padding-bottom:10px}
.title2 {text-align:left;font-weight:bold;font-size:15px;color:#888;width:55px;height:20px;}

</style>
<div style="height:40px"></div>
<!-- 게시글 보기 시작 -->
<table width="<?=$width?>" align="center" cellpadding="0" cellspacing="0"><tr><td>


<div style="clear:both; height:30px;display:none">
    <div style="float:left; margin-top:6px;">

    
    </div>

    <!-- 링크 버튼
    <div style="float:right;">
    <?
    ob_start();
    ?>
    <? if ($copy_href) { echo "<a href=\"$copy_href\"><img src='$board_skin_path/img/btn_copy.gif' border='0' align='absmiddle'></a> "; } ?>
    <? if ($move_href) { echo "<a href=\"$move_href\"><img src='$board_skin_path/img/btn_move.gif' border='0' align='absmiddle'></a> "; } ?>

    <? if ($search_href) { echo "<a href=\"$search_href\"><img src='$board_skin_path/img/btn_list_search.gif' border='0' align='absmiddle'></a> "; } ?>
    <? echo "<a href=\"$list_href\"><img src='$board_skin_path/img/btn_list.gif' border='0' align='absmiddle'></a> "; ?>
    <? if ($update_href) { echo "<a href=\"$update_href\"><img src='$board_skin_path/img/btn_modify.gif' border='0' align='absmiddle'></a> "; } ?>
    <? if ($delete_href) { echo "<a href=\"$delete_href\"><img src='$board_skin_path/img/btn_delete.gif' border='0' align='absmiddle'></a> "; } ?>
    <? if ($reply_href) { echo "<a href=\"$reply_href\"><img src='$board_skin_path/img/btn_reply.gif' border='0' align='absmiddle'></a> "; } ?>
    <? if ($write_href) { echo "<a href=\"$write_href\"><img src='$board_skin_path/img/btn_write.gif' border='0' align='absmiddle'></a> "; } ?>
    <?
    $link_buttons = ob_get_contents();
    ob_end_flush();
    ?>
    </div> -->
</div>

<div style="clear:both;border-bottom:2px solid #bbbbbb;">
    <table border=0 cellpadding=0 cellspacing=0 width=100%>
    <tr>
        <td style="padding:8px 0 5px 10px;">
            <div style="color:#505050; font-size:18px; font-weight:bold; word-break:break-all;">
            <? if ($is_category) { echo ($category_name ? "[$view[ca_name]] " : ""); } ?>
            <?=cut_hangul_last(get_text($view[wr_subject]))?>
            </div>
        </td>
        <td align="right" style="padding:6px 6px 0 0;" width=120>
           <!-- <? if ($scrap_href) { echo "<a href=\"javascript:;\" onclick=\"win_scrap('$scrap_href');\"><img src='$board_skin_path/img/btn_scrap.gif' border='0' align='absmiddle'></a> "; } ?>
            <? if ($trackback_url) { ?><a href="javascript:trackback_send_server('<?=$trackback_url?>');" style="letter-spacing:0;" title='주소 복사'><img src="<?=$board_skin_path?>/img/btn_trackback.gif" border='0' align="absmiddle"></a><?}?>-->
        </td>
    </tr>
    </table>
</div>


<table border=0 cellpadding=0 cellspacing=0 width=<?=$width?>>
<tr>
    <td style="color:#444;padding-top:10px">
        <div>
		<span style="color:#444444;">작성일 : <?=date("Y-m-d H:i", strtotime($view[wr_datetime]))?></span>&nbsp;&nbsp;
        조회 : <?=number_format($view[wr_hit])?>
        <? if ($is_good) { ?>&nbsp;<img src="<?=$board_skin_path?>/img/icon_good.gif" border='0' align=absmiddle> 추천 : <?=number_format($view[wr_good])?><? } ?>
        <? if ($is_nogood) { ?>&nbsp;<img src="<?=$board_skin_path?>/img/icon_nogood.gif" border='0' align=absmiddle> 비추천 : <?=number_format($view[wr_nogood])?><? } ?>
        &nbsp;
        </div>
        <div>
        글쓴이 :
        <?=$view[name]?><? if ($is_ip_view) { echo "&nbsp;($ip)"; } ?>
        </div>
		<div style="height:20px;"></div>
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
		
			<div class="line_wrap">
			<table class="thum">
				<tr>
					<th class="tt">
						<?
						// 첨부파일 이미지가 있으면 썸을 가져옴, 아니면 pass~!
							if ($view[file][0][file])
							{

						// 이미지 체크
							$image = urlencode($view[file][0][file]);
								$ori="$g4[path]/data/file/$bo_table/" . $image;
								$ext = strtolower(substr(strrchr($ori,"."), 1)); //확장자

							// 이미지가 있다면.
							if ($ext=="gif"||$ext=="jpg"||$ext=="jpeg"||$ext=="png"||$ext=="bmp"||$ext=="tif"||$ext=="tiff") {

						// 섬네일 경로 만들기 + 섬네일 생성
								$view_img_path = $view[file][0][path]."/".$view[file][0][file];
								//$list_thumb = thumbnail($list_img_path ,$board[bo_1], $board[bo_2],0,2,100);
								//$view_thumb = $view[file][0][path]."/thumb/".$board[bo_1]."x".$board[bo_2]."_100/".$view[file][0][file];
								$view_thumb = thumbnail($view_img_path ,$board[bo_1], $board[bo_2],0,2,100);

								echo "<div  >";
								// echo $view_thumb;
								//echo $list[$i][file][0][path];
								echo "<img src='$view_thumb'  style='width:158px;height:117px; overflow:hidden;margin-left:0px; margin-bottom:3px; border:{$imgbordersize}px solid {$imgcolor}; ' id='img{$i}'  />";
								echo "</div>";
							}



							}
							else
							{                ////  첨부파일 이미지가 없으면




						  $img_tags = explode("src=",$view[$i][wr_content]);
						  $img_tag = explode(" ",$img_tags[1]);
						  $img_url = explode(">",$img_tag[0]);
						  $real_img_url = $img_url[0];

						  $clear_img_url =  str_replace('"','',$real_img_url);

						// $pppimg_url = preg_match_all('#img src=\"(.*)\"#Usi',$list[$i][wr_content],$result);
						// 본문내에 첫번째 이미지링크에서 주소 추출 ()

							//$list_thumb = thumbnail($clear_img_url,$board[bo_1], $board[bo_2],0,2,100);


								echo "<div >";
						//	    echo $clear_img_url;
								echo "<img src='{$board_skin_path}/img/noimg.gif'  style='width:158px;height:117px; overflow:hidden;margin-left:0px;  margin-bottom:3px; border:{$imgbordersize}px solid {$imgcolor}; ' id='img{$i}'  />";
								echo "</div>";



							}

						// 섬네일 완료5
						?>
					</th>
					<td>
						<div class="title1"><?=cut_str($view[subject],80,"..")?></div>
						<table>
							<tr>
								<th class="title2">ㆍ기간</th>
								<td style="font-size:16px;"><strong>
								<?=date("Y년 m월 d일", strtotime("{$view[wr_3]} 00:00:00"))?>  ~ <?=date("Y년 m월 d일", strtotime("{$view[wr_4]} 00:00:00"))?>&nbsp;&nbsp;&nbsp;&nbsp;
									<?
									//////////////////////////////////////////////////////

									// 현재시간
									$current_time = time();
									$current_time = date("Y-m-d", $current_time);

									// event time
									$notice_stime  = $view[wr_3];
									$notice_etime  = $view[wr_4];
									
									$last_time = $notice_time - $current_time ;

									//남은 날이 -  이면, 이벤트 기간이 끝나면..
									if($current_time <= $notice_etime && $current_time >= $notice_stime){
									 echo "<img src='$board_skin_path/img/icon_Inprogress.jpg' border='0' align='absmiddle' title='진행중'>";
									}
									else if($current_time > $notice_stime){
									 echo "<img src='$board_skin_path/img/icon_Outprogress.jpg' border='0' align='absmiddle' title='마감'>";
									}

									//////////////////////////////////////////////////////
									?></strong>
								</td>
							</tr>
							<tr>
								<th class="title2">ㆍ주최</th>
								<td style="font-size:16px;"><?=$view[wr_2]?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<br />
		<br />
		<br />
		
        <?
        // 파일 출력
        //for ($i=0; $i<=count($view[file]); $i++) {
        //    if ($view[file][$i][view])
        //        echo $view[file][$i][view] . "<p>";
        //}
        ?>

        <!-- 내용 출력 -->
        <div id="writeContents"><font style="font-size:20px"><?=$view[content];?></font></div>

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

<div style="height:1px; line-height:1px; font-size:1px; background-color:#ddd; clear:both;">&nbsp;</div>

<div style="clear:both; height:43px;">
    <div style="float:left; margin-top:10px;">
    <? if ($prev_href) { echo "<a href=\"$prev_href\" title=\"$prev_wr_subject\"><img src='$board_skin_path/img/btn_prev.gif' border='0' align='absmiddle'></a>&nbsp;"; } ?>
    <? if ($next_href) { echo "<a href=\"$next_href\" title=\"$next_wr_subject\"><img src='$board_skin_path/img/btn_next.gif' border='0' align='absmiddle'></a>&nbsp;"; } ?>
    </div>

    <!-- 링크 버튼 -->
    <div style="float:right; margin-top:10px;">
    <?=$link_buttons?>
    </div>
</div>

<div style="height:2px; line-height:1px; font-size:1px; background-color:#dedede; clear:both;">&nbsp;</div>

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
