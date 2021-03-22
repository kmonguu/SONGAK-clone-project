<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

//if ($is_category) $colspan++;
if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// 제목이 두줄로 표시되는 경우 이 코드를 사용해 보세요.
// <nobr style='display:block; overflow:hidden; width:000px;'>제목</nobr>

//목록수 15개로 고정
$board[bo_page_rows] = "15";
$sql = " update $g4[board_table] set bo_page_rows = '$board[bo_page_rows]' where bo_table = '$bo_table' ";
sql_query($sql);


?>
  <div style="float:left;">
            <form name="fcategory" method="get" style="margin:0px;display:none;">
            <? if ($is_category) { ?>
            <select name=sca onchange="location='<?=$category_location?>'+<?=strtolower($g4[charset])=='utf-8' ? "encodeURIComponent(this.value)" : "this.value"?>;">
            <option value=''>전체</option>
            <?=$category_option?>
            </select>
            <? } ?>
            </form>
			<? if ($is_category) { ?>
			<?$arr = explode("|", $board[bo_category_list]);?>
			<div id="categorywrap">
			<a href="<?=$category_location?>">전체</a>&nbsp;&nbsp;<?for($i=0;$i<count($arr);$i++){?><a href="<?=$category_location?><?=urlencode($arr[$i])?>"><?=$arr[$i]?></a>&nbsp;&nbsp;<?}?>
			</div>
			<? } ?>
        </div>
<style>
span.list_cmt_cnt_new {font-size:22px; color: #EE5A00;}
span.list_cmt_cnt {font-size:22px; color: #EE5A00;}
</style>
<div id="m_list">
	<div style="height:28px;"></div>
	<ul>
	<?
	$subject_len=40;//자를 제목 수

	list($startno,$paging)= mpagelist($total_count, $board[bo_page_rows], 5, $g4[mpath]."/bbs/board.php","bo_table=$bo_table");

	 for ($i=0; $i<count($list); $i++) {

		$list_selected="";

		$list[$i]['subject'] = conv_subject($list[$i]['wr_subject'], $subject_len, "…");

		if ($list[$i][is_notice]){
			$list[$i]['subject'] = "[공지]".$list[$i]['subject'];
		}
		
		$list[$i]['subject'] = $list[$i][reply].$list[$i][icon_reply].$list[$i]['subject'];

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
			$icon_secret = "<img src='$g4[mpath]/images/icon/icon_secret.gif' >";

		$icon_new = "";
		if ($list[$i]['wr_datetime'] >= date("Y-m-d H:i:s", $g4['server_time'] - ($board['bo_new'] * 3600)))
			$icon_new = "<img src='$g4[mpath]/images/icon/icon_new.gif' >";


	?>
		
		<li <?=$list_selected?> onclick="location.href='<?=$g4[mpath]?>/bbs/board.php?bo_table=<?=$bo_table?>&wr_id=<?=$list[$i][wr_id]?>&page=<?=$page?>'"  >
			<div class="list_left" style='width:70%; overflow:hidden; float:left; text-overflow:ellipsis; white-space:nowrap; font-size:24px;'>
				<?=$list[$i][subject]?> <?=$icon_secret?> <?=$icon_new?> <?=$wr_comment?>
			</div>
			<nobr><a class="list_right" style="font-size:24px; width:27%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?=$list[$i][wr_name]?></a></nobr>
		</li>
		<?}?>
		<? if($i==0){ 	?>
		<li style='text-align:center;'>게시물이 존재하지 않습니다.</li>
		<? } ?>
	
	</ul>
	
	<div class="paging"><?=$paging?></div>

	 <div style="width:100%;text-align:right;">
        <? if ($write_href) { ?>
			<span class="button medium add"><a href="<?=$write_href?>" style='font-size:24px;'>글쓰기</a></span>
	<? } ?>
        </div>
</div>


