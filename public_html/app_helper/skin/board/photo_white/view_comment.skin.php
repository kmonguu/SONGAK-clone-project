<?
if($view[wr_comment]) {
?>





<!-- <h4>댓글 (<?=$view[wr_comment]?>)</h4> -->
<div id="m_cmt_list">
	<ul>
	<?
	$is_comment_write = false;
	if ($member[mb_level] >= $board[bo_comment_level])
		$is_comment_write = true;

	//$cmts_num=6;//댓글 출력수
	$page_num=1;//페이지수

	$a_total=sql_fetch("select count(*) as cnt from ".$g4[write_prefix].$bo_table." where wr_parent = '$wr_id' and wr_is_comment=1");

	list($startno,$paging)=mpagelist($a_total[cnt],$cmts_num,$page_num,$g4[mpath]."/list.php","bo_table=$bo_table&wr_id=$wr_id");

	//$result=sql_query("select * from ".$g4[write_prefix].$bo_table." where wr_parent = '$wr_id' and wr_is_comment=1 order by wr_num, wr_reply limit $startno, $cmts_num");
	$result=sql_query("select * from ".$g4[write_prefix].$bo_table." where wr_parent = '$wr_id' and wr_is_comment=1 order by wr_num, wr_reply");

	$list = array();

	for($i=0;$list=sql_fetch_array($result);$i++){

		$tmp_name = get_text(cut_str($list[wr_name], $config[cf_cut_name])); // 설정된 자리수 만큼만 이름 출력
		if ($board[bo_use_sideview])
			$list[name] = get_sideview($list[mb_id], $tmp_name, $list[wr_email], $list[wr_homepage]);
		else
			$list[name] = "<span class='".($list[mb_id]?'member':'guest')."'>$tmp_name</span>";



		// 공백없이 연속 입력한 문자 자르기 (way 보드 참고. way.co.kr)
		//$list[content] = eregi_replace("[^ \n<>]{130}", "\\0\n", $row[wr_content]);

		$list[content] = $list[content1]= "비밀글 입니다.";
		if (!strstr($list[wr_option], "secret") ||
			$is_admin ||
			($write[mb_id]==$member[mb_id] && $member[mb_id]) ||
			($list[mb_id]==$member[mb_id] && $member[mb_id])) {
			$list[content1] = $list[wr_content];
			$list[content] = conv_content($list[wr_content], 0, 'wr_content');
			$list[content] = search_font($stx, $list[content]);
		}

		$list[trackback] = url_auto_link($list[wr_trackback]);
		$list[datetime] = substr($list[wr_datetime],2,14);

		// 관리자가 아니라면 중간 IP 주소를 감춘후 보여줍니다.
		$list[ip] = $list[wr_ip];
		if (!$is_admin)
			$list[ip] = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", "\\1.♡.\\3.\\4", $list[wr_ip]);

		$icon_secret = "";
		if (strstr($list['wr_option'], "secret"))
			$icon_secret = "<img src='$g4[mpath]/images/icon/icon_secret.gif' align='absmiddle'>";


	?>
		<li>
			<div class="cmt_hd">
			<strong><?=$list[wr_name]?></strong> at <?=$list[wr_datetime]?>
			</div>
			<div class="line"></div>
			<div class="cmt_centent">
				<?
				if (strstr($list[wr_option], "secret")) echo "<span style='color:#ff6600;'>*</span> ";
                $str = $list[content];
                if (strstr($list[wr_option], "secret"))
                    $str = "<span class='small' style='color:#ff6600;'>$str</span>";

                $str = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $str);
                // FLASH XSS 공격에 의해 주석 처리 - 110406
                //$str = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(swf)\".*\<\/a\>\]/i", "<script>doc_write(flash_movie('$1://$2.$3'));</script>", $str);
                $str = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<img src='$1://$2.$3' id='target_resize_image[]' onclick='image_window(this);' border='0'>", $str);
                echo $str;
				?>
			</div>

		</li>

		<?}?>
	</ul>
	<div class="blank"></div>
	<div class="paging"><?=$paging?></div>
</div>
<?}?>

<form name="fviewcomment" method="post" onsubmit="return fviewcomment_submit(this);" autocomplete="off" style="margin:0px;">
<input type=hidden name=w           id=w value='c'>
<input type=hidden name=bo_table    value='<?=$bo_table?>'>
<input type=hidden name=wr_id       value='<?=$wr_id?>'>
<input type=hidden name=comment_id  id='comment_id' value=''>
<input type=hidden name=sca         value='<?=$sca?>' >
<input type=hidden name=sfl         value='<?=$sfl?>' >
<input type=hidden name=stx         value='<?=$stx?>'>
<input type=hidden name=spt         value='<?=$spt?>'>
<input type=hidden name=page        value='<?=$page?>'>
<input type=hidden name=cwin        value='<?=$cwin?>'>
<div id="m_cmt_write">
	<ul>
	<?if(false && $member[mb_id]){?>
	<li>
		<textarea id="wr_content" name="wr_content" rows="4" itemname="내용" required="required"
		 placeholder="내용" onFocus="this.placeholder=''" class="input_txt2" style="font-size:21px;"></textarea>
	</li>
	<li><span class="button xLarge strong"><input type="submit" value="댓글쓰기"></span></li>
	<?}?>
	<?=$link_buttons?>
	</ul>
</div>
</form>


<script type="text/javascript">
function fviewcomment_submit(f) {

	if (!f.wr_content.value) {
        alert("내용을 입력하십시오.");
        f.wr_content.focus();
        return false;
    }

    f.action='./write_comment_update.php';

    return true;
}
</script>
