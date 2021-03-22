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

<style>
.member {font-weight:normal;color:#444444;}
.guest  {font-weight:normal;color:#444444;}
.board_list a:link, .board_list a:visited, .board_list a:active{text-decoration:none;color:#444444;}
.board_top { clear:both; }

.board_list { clear:both; width:100%; table-layout:fixed; margin:20px 0 0 0; }
.board_list th { font-weight:bold; font-size:12px;border-top:1px solid #dddddd;border-bottom:1px solid #dddddd; background:#f8f8f8; }
.board_list th { white-space:nowrap; height:50px; overflow:hidden; text-align:center; color:#6e6e6e; font-size:14px; }


.board_list tr.bg0 { background-color:#fafafa; }
.board_list tr.bg1 { background-color:#ffffff; }

.board_list tr.bg:hover { background-color:#f8f8f8; }

.board_list td { height:50px; border-bottom:1px solid #dddddd; color:#6e6e6e; font-size:14px; }
.board_list td.num { color:#444444; text-align:center; padding:7px 0; border-left:0; }
.board_list td.bocheckbox { text-align:center; padding:7px 0; }
.board_list td.subject { overflow:hidden; padding:7px 0 7px 15px; }
.board_list td.name { text-align:center; padding:7px 0; }

.board_list td.datetime { text-align:center; padding:7px 0; }
.board_list td.hit { text-align:center; padding:7px 0; }
.board_list td.good { color:#BABABA; text-align:center; padding:7px 0; }
.board_list td.nogood { color:#BABABA; text-align:center; padding:7px 0; }

.board_list .notice { font-weight:normal; }
.board_list .current { font:bold 11px tahoma; color:#E15916; }
.board_list .comment { font-family:Tahoma; font-size:10px; color:#EE5A00; }


.board_button { clear:both; margin:30px 0 0 0; display:inline-block; width:100%; }

a.nBtn { background:#4b4b4b; color:#ffffff; padding:5px 15px; line-height:23px; border:1px solid #1b1b1b; font-size:14px; text-decoration:none; display:inline-block; }
</style>

<!--게시판 서치부분-->
<style>
.board_search { float:right; }
.search_select { 
	width:125px; height:40px; border:1px solid #d8d8d8; position:relative; float:left; font-size:15px; padding-left:15px; background:#f9f9f9; outline:none; box-sizing:border-box; color:#5d5d5d; font-weight:400; 
	-webkit-appearance:none; -moz-appearance:none; appearance:none; 
	background:url('/img/select_arrow.png') no-repeat right 15px top 18px;
}
select.search_select::-ms-expand { display:none; }

.search_box { float:left; display:inline; border:1px solid #d8d8d8; border-left:0px; }
.board_search #search_input > #stx { border:0; width:165px; height:38px; margin:0; padding:0 0 0 10px; letter-spacing:0px; color:#5d5d5d; font-size:15px; font-weight:400; }
.board_search #search_input { float:left; }
.board_search #search_submit { float:right; height:34px; }
.board_search #search_submit input { padding:0px; }
</style>
<!--게시판 서치부분-->



<!-- 게시판 목록 시작 -->
<table width="<?=$width?>" align="center" cellpadding="0" cellspacing="0"><tr><td>

	<div style="display:inline-block; width:100%;" >
		<div class="board_search">
			<form method="get">
				<input type="hidden" name="bo_table" value="<?=$bo_table?>" />
				<input type="hidden" name="sop" value="and" />
				<input type="hidden" name="sca" value="<?=$sca?>" />
				<input type='hidden' name='sst'  value='<?=$sst?>' />
				<input type='hidden' name='sod'  value='<?=$sod?>' />
				
				<label class="hidden" for="sfl">검색조건</label>
				<select name="sfl" id="sfl" class="search_select" >
					<option value="wr_subject||wr_content" <?=$sfl == "wr_subject||wr_content" ? "selected" : ""?> >제목+내용</option>
					<option value="wr_subject" <?=$sfl == "wr_subject" ? "selected" : ""?> >제목</option>
					<option value="wr_content" <?=$sfl == "wr_content" ? "selected" : ""?> >내용</option>
					<option value="wr_name,1" <?=$sfl == "wr_name,1" ? "selected" : ""?> >글쓴이</option>
				</select>

				<div class="search_box">
					<div id="search_input">
						<input id="stx" name="stx" itemname="검색어" value="<?=stripslashes($stx)?>" placeholder="검색어를 입력해주세요." title="검색어를 입력해주세요." />
					</div>
					<div id="search_submit">
						<input type="image" src="/img/btn_search.jpg" alt="검색" >
					</div>
				</div>
				
				<?if(false){?>
					<div style="float:right; margin:0px 0 0 5px;">
						<? if ($write_href) { ?><a href="<?=$write_href?>" class="nBtn">글쓰기</a><? } ?>
					</div>
				<?}?>
			</form>
		</div>
	</div>

	<? if ($is_category) { ?>
		<?$arr = explode("|", $board[bo_category_list]);?>
		<ul id="categorywrap">
			<li <?=$sca == "" ? "class='on'" : ""?> ><a href="<?=$category_location?>" >전체</a></li>
			<?for($i=0;$i<count($arr);$i++){?>
				<li <?=$sca == $arr[$i]  ? "class='on'" : ""?> ><a href="<?=$category_location?><?=urlencode($arr[$i])?>" >
						<?=$arr[$i]?>
				</a></li>
			<?}?>
		</ul>
	<? } ?>

    <form name="fboardlist" method="post">
    <input type='hidden' name='bo_table' value='<?=$bo_table?>'>
    <input type='hidden' name='sfl'  value='<?=$sfl?>'>
    <input type='hidden' name='stx'  value='<?=$stx?>'>
    <input type='hidden' name='spt'  value='<?=$spt?>'>
    <input type='hidden' name='page' value='<?=$page?>'>
    <input type='hidden' name='sw'   value=''>

	<table cellspacing="0" cellpadding="0" class="board_list" >
		<colgroup>
			<col width="50" />
			<? if ($is_checkbox) { ?><col width="40" /><? } ?>
			<col />
			<col width="120" />
			<col width="80" />
			<col width="50" />
			<? if ($is_good) { ?><col width="40" /><? } ?>
			<? if ($is_nogood) { ?><col width="40" /><? } ?>
		</colgroup>

		<thead>
			<tr>
				<th>번호</th>
				<? if ($is_checkbox) { ?>
					<th>
						<input type="checkbox" onclick="if (this.checked) all_checked(true); else all_checked(false);" >
					</th>
				<?}?>
				<th>제목</th>
				<th>작성자</th>
				<th><!--<?=subject_sort_link('wr_datetime', $qstr2, 1)?>-->작성일<!--</a>--></th>
				<th><!--<?=subject_sort_link('wr_hit', $qstr2, 1)?>-->조회<!--</a>--></th>
				<? if ($is_good) { ?><th><?=subject_sort_link('wr_good', $qstr2, 1)?>추천</a></th><?}?>
				<? if ($is_nogood) { ?><th><?=subject_sort_link('wr_nogood', $qstr2, 1)?>비추천</a></th><?}?>
			</tr>
		</thead>
		
		<tbody>
			<?
			$count1 = count($list)-1 ;
			for ($i=0; $i<count($list); $i++) {
			   // $bg = $i%2 ? 0 : 1;
			?>
		
			<tr class="bg">
				<td class="num">
					<?
					if ($list[$i][is_notice]) // 공지사항
						echo "<b><img src='$board_skin_path/img/noticeicon.png'/></b>";
					else if ($wr_id == $list[$i][wr_id]) // 현재위치
						echo "<span class='current'>{$list[$i][num]}</span>";
					else
						echo $list[$i][num];
					?>
				</td>
				<? if ($is_checkbox) { ?>
					<td class="bocheckbox">
						<input type=checkbox name=chk_wr_id[] value="<?=$list[$i][wr_id]?>">
					</td>
				<? } ?>
				<td class="subject">
					<?
					//echo $nobr_begin;
					echo "<div style=\"width:100%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;\" >";

					echo $list[$i][reply];
					echo $list[$i][icon_reply];
					if ($is_category && $list[$i][ca_name]) {
						echo "<span class=small><font color=gray>[<a href='{$list[$i][ca_name_href]}'>{$list[$i][ca_name]}</a>]</font></span> ";
					}

					if ($list[$i][is_notice])
						echo "<a href='{$list[$i][href]}'><span class='notice'>{$list[$i][subject]}</span></a>";
					else
						echo "<a href='{$list[$i][href]}'>{$list[$i][subject]}</a>";

					if ($list[$i][comment_cnt])
						echo " <a href=\"{$list[$i][comment_href]}\"><span class='comment'>{$list[$i][comment_cnt]}</span></a>";

					// if ($list[$i]['link']['count']) { echo "[{$list[$i]['link']['count']}]"; }
					// if ($list[$i]['file']['count']) { echo "<{$list[$i]['file']['count']}>"; }

					echo " " . $list[$i][icon_file];
					echo " " . $list[$i][icon_new];
					echo " " . $list[$i][icon_link];
					echo " " . $list[$i][icon_hot];
					echo " " . $list[$i][icon_secret];
					
					echo "</div>";
					//echo $nobr_end;
					?>
				</td>
				<td class="name"><?=$list[$i][name]?></td>
				<td class="datetime"><?=date("y-m-d",strtotime($list[$i][datetime]))?></td>
				<td class="hit"><?=$list[$i][wr_hit]?></td>
				<? if ($is_good) { ?><td class="good"><?=$list[$i][wr_good]?></td><? } ?>
				<? if ($is_nogood) { ?><td class="nogood"><?=$list[$i][wr_nogood]?></td><? } ?>
			</tr>

			<? } // end for ?>

			<? if (count($list) == 0) {
				$bo=substr($bo_table,0,8);
				if($bo=='menu04_1'){
				echo "<tr><td colspan='$colspan' height=100 align=center>이곳은 기술지원을 하는 게시판입니다.</td></tr>";
				}else{
				echo "<tr><td colspan='$colspan' height=100 align=center>게시물이 없습니다.</td></tr>";
				}
			} ?>
		</tbody>

    </table>

    </form>


	<div class="board_button">
		<div style="float:left;">
			<? if ($list_href) { ?>
				<a href="<?=$list_href?>" class="nBtn" >목록보기</a>
			<? } ?>
			<? if ($is_checkbox) { ?>
				<a href="#select_delete" onclick="select_delete();" class="nBtn" >선택삭제</a>
				<a href="#select_copy" onclick="select_copy('copy');" class="nBtn" >선택복사</a>
				<a href="#select_move" onclick="select_copy('move');" class="nBtn" >선택이동</a>
			<? } ?>
		</div>
		<div style="float:right;">
			<? if ($write_href) { ?><a href="<?=$write_href?>" class="nBtn" >글쓰기</a><? } ?>
		</div>
	</div>

	<!-- 페이지 -->
	<div class="Boardpage linkpage" >
	<table cellspacing="3" cellpadding="0" class="t6" style='margin:0 auto;' >
		<colgroup>
			<col />
			<col />
			<col />
			<col />
			<col />
			<col />
			<col />
			<col />
			<col />
		</colgroup>
		<tbody>
			<tr>
				<?=$write_pages?>
			</tr>
		</tbody>
	</table>
	</div>
	

</td></tr></table>


<script type="text/javascript">
if ('<?=$sca?>') document.fcategory.sca.value = '<?=$sca?>';
</script>

<? if ($is_checkbox) { ?>
<script type="text/javascript">
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function check_confirm(str) {
    var f = document.fboardlist;
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(str + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }
    return true;
}

// 선택한 게시물 삭제
function select_delete() {
    var f = document.fboardlist;

    str = "삭제";
    if (!check_confirm(str))
        return;

    if (!confirm("선택한 게시물을 정말 "+str+" 하시겠습니까?\n\n한번 "+str+"한 자료는 복구할 수 없습니다"))
        return;

    f.action = "./delete_all.php";
    f.submit();
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    if (!check_confirm(str))
        return;

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<? } ?>
<!-- 게시판 목록 끝 -->
