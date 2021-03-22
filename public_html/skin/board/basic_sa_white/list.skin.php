<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 7;

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

.board_list { clear:both; width:100%; table-layout:fixed; margin:0px 0 0 0; }
.board_list th { font-weight:bold; font-size:12px;border-top:1px solid #dddddd;border-bottom:1px solid #dddddd;background:#f8f8f8 }
.board_list th { white-space:nowrap; height:50px; overflow:hidden; text-align:center;color:#6e6e6e;font-size:14px; }


.board_list tr.bg0 { background-color:#fafafa; }
.board_list tr.bg1 { background-color:#ffffff; }

.board_list tr.bg:hover { background-color:#f8f8f8; }

.board_list td {height:50px;border-bottom:1px solid #dddddd;color:#6e6e6e;font-size:14px}
/*.board_list td { border-bottom:1px solid #e0e0e0; }*/
.board_list td.num { color:#444444; text-align:center;padding:7px 0;border-left:0;}
.board_list td.checkbox { text-align:center;padding:7px 0 }
.board_list td.subject { overflow:hidden;padding:7px 0 7px 15px }
.board_list td.name { text-align:center;padding:7px 0 }

.board_list td.datetime {text-align:center;padding:7px 0; }
.board_list td.hit {text-align:center;padding:7px 0 }
.board_list td.good {color:#BABABA; text-align:center;padding:7px 0 }
.board_list td.nogood {color:#BABABA; text-align:center;padding:7px 0 }

.board_list .notice { font-weight:normal; }
.board_list .current { font:bold 11px tahoma; color:#E15916; }
.board_list .comment { font-family:Tahoma; font-size:10px; color:#EE5A00; }

.board_button { clear:both; padding:10px 0 0 0;}

.board_page { clear:both; text-align:center; margin:3px 0 0 0;}
.board_page a { color:#777;border:1px solid #dddddd;padding:5px 8px 5px 7px;font-size:14px }

a.nBtn { background:#4b4b4b; color:#ffffff; padding:5px 15px; line-height:23px; border:1px solid #1b1b1b; font-size:13px; text-decoration:none; display:inline-block; }

/*.board_search { text-align:center; margin:10px 0 0 0; padding:3px 0 3px 0; height:35px; }
.board_search .stx { height:16px;  border:1px solid #9A9A9A; border-right:1px solid #D8D8D8; border-bottom:1px solid #D8D8D8; background:transparent; }
select{font-size:13px;}*/
</style>

<!--게시판 서치부분-->
<style>
/* 검색부분 */
.board_search {float:right; margin:0 0 30px 0; }
.search_box { float:left; display:inline; border:1px solid #e5e5e5; margin-left:5px }
.board_search label { font-size:14px; color:#919191; }
.board_search #stx {  }
.board_search #search_input >/**/ #stx { border:0; width:170px; height:34px; margin:0; padding:0 0 0 10px; letter-spacing:0px; color:#919191; font-size:14px; }
.search_option_box { width:100px; height:34px; border:1px solid #e5e5e5; position:relative; float:left; background:url("<?=$board_skin_path?>/img/search_arrow.jpg") no-repeat 80px 16px; font-size:14px; }
#search_option_selector { display:block; width:100px; line-height:33px; padding:0 0 0 10px; box-sizing:border-box; cursor:pointer;  }
#search_option_list { display:none; position:absolute; left:-1px; top:33px; margin:0;border:1px solid #dfdfdf; width:100px; /*background:transparent url("<?=$board_skin_path?>/img/search_arrow.gif") no-repeat 72px -40px;*/ list-style:none; font-size:0; line-height:1; padding:5px 0 5px 0;background:#fff }
#search_option_list label { background:#ffffff; display:block; padding:4px 5px 4px 10px; cursor:pointer;  }
#search_option_list label:hover { background:#fafafa; }
.board_search #search_input { float:left; }
.board_search #search_submit { float:right; height:34px; }
.board_search #search_submit input { padding:10px; cursor:pointer; }
.board_search:after,
.board_search .search_box:after { clear:both; content:""; display:block; }
.board_search,
.board_search .search_box { height:1%; }
.board_list >/**/ .board_search,
.board_search >/**/ .search_box { height:25px; }
</style>
<!--게시판 서치부분-->



<!-- 게시판 목록 시작 -->
<table width="<?=$width?>" align="center" cellpadding="0" cellspacing="0"><tr><td>

    <!-- 분류 셀렉트 박스, 게시물 몇건, 관리자화면 링크 -->
    <!-- div style="float:left;">
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
        <div style="float:right; margin-bottom:10px;">
			<div style="float:left; line-heigth:25px;">
				<span style="line-height:25px;">
				<?if($is_admin){?><img src="<?=$board_skin_path?>/img/icon_total.gif" style="margin-top:5px;" align="absmiddle" border='0'>
				</span>
				<span style="color:#888888; font-weight:bold; line-height:25px;  margin-right:7px;">Total <?=number_format($total_count)?></span><?}?>
			</div>
			<div style="float:left;">
				<? if ($rss_href) { ?><a href='<?=$rss_href?>'><img src='<?=$board_skin_path?>/img/btn_rss.gif' border='0' align="absmiddle"></a><?}?>
				<? if ($admin_href) { ?><a href="<?=$admin_href?>"><img src="<?=$board_skin_path?>/img/btn_admin.gif" border='0' title="관리자" align="absmiddle"></a><?}?>
			</div>
		</div>
    </div -->
    <!-- 제목 -->
	
	<div class="board_search">
	<form method="get">
		<input type="hidden" name="bo_table" value="<?=$bo_table?>" />
		<input type="hidden" name="sop" value="and" />
		<input type="hidden" name="sca" value="<?=$sca?>" />
		<input type="hidden" name="sfl" id="sfl" value="<?=$sfl ? $sfl : "wr_subject||wr_content"?>" />

		<div class="search_option_box">
			<div class="search_option">
				<label id="search_option_selector">제목+내용</label>
			</div>
			<ul id="search_option_list">
				<li><label for="stx" class="wr_subject||wr_content">제목+내용</label></li>
				<li><label for="stx" class="wr_subject">제목</label></li>
				<li><label for="stx" class="wr_content">내용</label></li>
				<li><label for="stx" class="wr_name,1">글쓴이</label></li>
			</ul>
		</div>

		<div class="search_box">
			<div id="search_input">
			<input id="stx" name="stx" itemname="검색어" value="<?=stripslashes($stx)?>" placeholder="검색어를 입력해주세요." />
			</div>
			<div id="search_submit">
				<input src="<?=$board_skin_path?>/img/btn_search.jpg" alt="검색" type="image">
			</div>
		</div>

		<div style="float:right;margin:0px 0 0 5px;">
		 <? if ($write_href) { ?><a href="<?=$write_href?>" class="nBtn">글쓰기</a><? } ?>
        </div>

		
	</form>
	</div>

	<script type="text/javascript">
	$("#search_option_selector").bind("click",function(){
		$("#search_option_list").show();
		return false;
	});
	$("#search_option_list").find("label").bind("click",function(){
		$("#search_option_selector").text($(this).text());
		$("#search_option_list").hide();
		$("#sfl").val(	$(this).attr("class"));
	});
	/*$("#search_submit input").mousedown(function(){
		$(this).attr('src','<?=$board_skin_path?>/img/btn_search_down.gif');
	});
	$("#search_submit input").hover(function(){
		$(this).attr('src','<?=$board_skin_path?>/img/btn_search_over.gif');
	},function(){
		$(this).attr('src','<?=$board_skin_path?>/img/btn_search.gif');
	});*/
	$("html").bind("click",function(){
        $("#search_option_list").hide();
    }); 
	</script>

    <form name="fboardlist" method="post">
    <input type='hidden' name='bo_table' value='<?=$bo_table?>'>
    <input type='hidden' name='sfl'  value='<?=$sfl?>'>
    <input type='hidden' name='stx'  value='<?=$stx?>'>
    <input type='hidden' name='spt'  value='<?=$spt?>'>
    <input type='hidden' name='page' value='<?=$page?>'>
    <input type='hidden' name='sw'   value=''>

    <table cellspacing="0" cellpadding="0" class="board_list">
    <col width="60" />
    <? if ($is_checkbox) { ?><col width="40" /><? } ?>
	<col width="80" />
    <col />
    <col width="130" />
    <col width="100" />
	<col width="100" />
	<col width="50" />
    <? if ($is_good) { ?><col width="40" /><? } ?>
    <? if ($is_nogood) { ?><col width="40" /><? } ?>
    <tr>
        <th>번호</th>
        <? if ($is_checkbox) { ?><th><input onclick="if (this.checked) all_checked(true); else all_checked(false);" type="checkbox"></th><?}?>
		<th><font color='#616161'>제품</font></th>
        <th>제목</th>
        <th>글쓴이</th>
        <th><!--<?=subject_sort_link('wr_datetime', $qstr2, 1)?>-->작성일<!--</a>--></th>
		<th><font color='#616161'>평가</font></th>
		<th><!--<?=subject_sort_link('wr_hit', $qstr2, 1)?>-->조회<!--</a>--></th>
		<? if ($is_good) { ?><th><?=subject_sort_link('wr_good', $qstr2, 1)?>추천</a></th><?}?>
        <? if ($is_nogood) { ?><th><?=subject_sort_link('wr_nogood', $qstr2, 1)?>비추천</a></th><?}?>
    </tr>

    <?
	$count1 = count($list)-1 ;
    for ($i=0; $i<count($list); $i++) {

       // 분류사용, 상품사용하는 상품의 정보를 얻음
		$sql = " select a.*,
						b.ca_name,
						b.ca_use
				   from $g4[yc4_item_table] a,
						$g4[yc4_category_table] b
				  where a.it_id = '".$list[$i][wr_6]."'
					and a.ca_id = b.ca_id ";
		$it = sql_fetch($sql);
		$href = "$g4[shop_path]/item.php?it_id=$it[it_id]";
		$star = intval($list[$i][wr_4])<10?'0'.$list[$i][wr_4]:$list[$i][wr_4];
		$star_img = "<img src='".$board_skin_path."/img/star".$star.".gif' alt='$list[$i][wr_4]' border=0 />";
    ?>

    <tr class="bg<?=$bg?>">
        <td class="num">
            <?
            if ($list[$i][is_notice]) // 공지사항
                echo "<b><font color='#b11a45'>공지</font></b>";
            else if ($wr_id == $list[$i][wr_id]) // 현재위치
                echo "<span class='current'>{$list[$i][num]}</span>";
            else
                echo $list[$i][num];
            ?>
        </td>
        <? if ($is_checkbox) { ?><td class="checkbox"><input type=checkbox name=chk_wr_id[] value="<?=$list[$i][wr_id]?>"></td><? } ?>
		<td class="img" style="padding:5px;" ><a href="<?=$href?>#afterlist"><?=get_it_image($it[it_id]."_m", '70', '70')?></a></td>
        <td class="subject">
			<?
			echo $nobr_begin;
            echo $list[$i][reply];
            echo $list[$i][icon_reply];
            if ($is_category && $list[$i][ca_name]) {
                echo "<span class=small><font color=gray>[<a href='{$list[$i][ca_name_href]}'>{$list[$i][ca_name]}</a>]</font></span> ";
            }

            if ($list[$i][is_notice])
                echo "<a href='{$list[$i][href]}'><span class='notice'>{$list[$i][subject]}</span></a>";
            else
                echo "<a href='{$list[$i][href]}'>[".cut_str($it[it_name],30)."] {$list[$i][subject]}</a>";

            if ($list[$i][comment_cnt])
                echo " <a href=\"{$list[$i][comment_href]}\"><span class='comment'>{$list[$i][comment_cnt]}</span></a>";


            echo " " . $list[$i][icon_new];
            echo " " . $list[$i][icon_file];
            echo " " . $list[$i][icon_link];
            echo " " . $list[$i][icon_hot];
            echo " " . $list[$i][icon_secret];
            echo $nobr_end;
            ?>
        </td>
        <td class="name"><?if(file_exists("$g4[path]/data/member/".substr($list[$i][mb_id],0,2)."/{$list[$i][mb_id]}.gif")) echo "<img src='$g4[path]/data/member/".substr($list[$i][mb_id],0,2)."/{$list[$i][mb_id]}.gif'>";?><?=$list[$i][name]?></td>
        <td class="datetime"><?=date("y-m-d",strtotime($list[$i][datetime]))?></td>
		
		<td class="star" align='center'><?=$star_img?></td>
		
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

    </table>
    </form>

    <div class="board_button">
        <div style="float:left;">
			<? if ($list_href) { ?>
				<a href="<?=$list_href?>" class="nBtn" >목록보기</a>
			<? } ?>
			<? if ($is_checkbox) { ?>
				<a href="javascript:select_delete();" class="nBtn" >선택삭제</a>
				<a href="javascript:select_copy('copy');" class="nBtn" >선택복사</a>
				<a href="javascript:select_copy('move');" class="nBtn" >선택이동</a>
			<? } ?>
        </div>
        <div style="float:right;">
		  <? if ($write_href && false) { ?><a href="<?=$write_href?>" class="nBtn" >글쓰기</a><? } ?>
		</div>

        
    </div>

    <!-- 페이지 -->
    <div class="board_page">
        <? if ($prev_part_href) { echo "<a href='$prev_part_href'><img src='$board_skin_path/img/page_search_prev.gif' border='0' align=absmiddle title='이전검색'></a>"; } ?>
        <?
        // 기본으로 넘어오는 페이지를 아래와 같이 변환하여 이미지로도 출력할 수 있습니다.
        //echo $write_pages;
        $write_pages = str_replace("처음", "<<", $write_pages);
        $write_pages = str_replace("이전", "<", $write_pages);
        $write_pages = str_replace("다음", ">", $write_pages);
        $write_pages = str_replace("맨끝", ">>", $write_pages);
        //$write_pages = preg_replace("/<span>([0-9]*)<\/span>/", "$1", $write_pages);
        $write_pages = preg_replace("/<b>([0-9]*)<\/b>/", "<b><span style=\"color:#ffffff; background:#727272; padding:5px 8px 5px 7px; font-size:14px; text-align:center;border:1px solid #727272 \">$1</span></b>", $write_pages);
        ?>
        <b><?=$write_pages?></b>
        <? if ($next_part_href) { echo "<a href='$next_part_href'><img src='$board_skin_path/img/page_search_next.gif' border='0' align=absmiddle title='다음검색'></a>"; } ?>
    </div>

    <!-- 검색 -->
    <?/*<div class="board_search">
        <form name="fsearch" method="get">
        <input type="hidden" name="bo_table" value="<?=$bo_table?>">
        <input type="hidden" name="sca"      value="<?=$sca?>">
        <span style="border:2px solid #bcbcbc; background:#ffffff; padding:3px;"><select name="sfl" style="border:0; background:transparent;">
            <option value="wr_subject">제목</option>
            <option value="wr_content">내용</option>
            <?/*<option value="wr_subject||wr_content">제목+내용</option>
            <option value="mb_id,1">회원아이디</option>
            <?/*<option value="mb_id,0">회원아이디(코)</option>
            <option value="wr_name,1">글쓴이</option>
            <?/*<option value="wr_name,0">글쓴이(코)</option>
        </select>
        <input name="stx" class="stx" maxlength="15" itemname="검색어" required value='<?=stripslashes($stx)?>' style="border:0;"></span>
        <input type="image" src="<?=$board_skin_path?>/img/btn_search.gif" border='0' align="absmiddle">
        <input type="hidden" name="sop" value="and">
		<!--<input type="radio" name="sop" value="and">and
        <input type="radio" name="sop" value="or">or-->
        </form>
    </div>*/?>
	

</td></tr></table>

<script type="text/javascript">
if ('<?=$sca?>') document.fcategory.sca.value = '<?=$sca?>';
/*if ('<?=$stx?>') {
    document.fsearch.sfl.value = '<?=$sfl?>';

    if ('<?=$sop?>' == 'and')
        document.fsearch.sop[0].checked = true;

    if ('<?=$sop?>' == 'or')
        document.fsearch.sop[1].checked = true;
} else {
    document.fsearch.sop[0].checked = true;
}*/
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
