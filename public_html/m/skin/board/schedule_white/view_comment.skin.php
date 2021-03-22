<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 이모티콘
if($cwin==1) {
function emoticon_html($str, $board_skin_path)
{

	for($i=1; $i<=120; $i++) {
		if($i < 10) {
			$emo_id = "emoticon_00$i";
		} else if($i < 100) {
			$emo_id = "emoticon_0$i";
		} else {
			$emo_id = "emoticon_$i";
		}
		$img_src = "<img src='$board_skin_path/emoticons/$i.gif' width=18 height=18 border=0 title=$emo_id>";
		$str = eregi_replace($emo_id, $img_src, $str);
	}

	return $str;
}
}
?>
<? if ($cwin==1) { ?>
<link rel="stylesheet" href="<?=$board_skin_path?>/style.css" type="text/css">
<? } ?>

<!-- 코멘트 리스트 -->
<? for ($i=0; $i<count($list); $i++) {
	$comment_id = $list[$i][wr_id];

	// 회원레벨아이콘
	$mb = get_member($list[$i][mb_id]);
	$level=level_name($mb[mb_level]);
	if (!$level) { $level = "<img src=$g4[path]/img/level/01.gif align=absmiddle>"; }
?>
<a name="c_<?=$comment_id?>"></a>

<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr height=25>
	<td>
	<? for ($k=0; $k<strlen($list[$i][wr_comment_reply]); $k++) { ?>
		&nbsp;&nbsp;
	<? } ?>
	</td>
	<td>
		<? if ($list[$i][wr_comment_reply]) { echo "<img src='$board_skin_path/img/icon_reply.gif'>"; } ?>
		<?=$level?> <?=$list[$i][name]?>
		<? if ($is_ip_view) { echo "&nbsp;({$list[$i][ip]})"; } ?>
	</td>
	<td align=right>
         <? if ($list[$i][is_reply]) { echo "<a href=\"javascript:comment_box('{$comment_id}', 'c');\"><img src='$board_skin_path/img/btn_comment_reply.gif' border=0 align=absmiddle></a> "; } ?>
         <? if ($list[$i][is_edit]) { echo "<a href=\"javascript:comment_box('{$comment_id}', 'cu');\"><img src='$board_skin_path/img/btn_comment_edit.gif' border=0 align=absmiddle></a> "; } ?>
         <? if ($list[$i][is_del])  { echo "<a href=\"javascript:comment_delete('{$list[$i][del_link]}');\"><img src='$board_skin_path/img/btn_comment_delete.gif' border=0 align=absmiddle></a> "; } ?>&nbsp;
		<?=$list[$i][datetime]?>
	</td>
</tr>


<tr>
	<td></td>
	<td colspan="2" align="left" class="c_tc">
		<!-- 코멘트 출력 -->
		<? $list[$i][content] = emoticon_html($list[$i][content], $board_skin_path); ?>
		<span class="vc_content"><?=$list[$i][content]?></span>
		<? if ($list[$i][trackback]) { echo "<p>".$list[$i][trackback]."</p>"; } ?>

		<textarea id='save_comment_<?=$comment_id?>' style='display:none;'><?=get_text($list[$i][wr_content], 0)?></textarea>
		<span id='edit_<?=$comment_id?>' style='display:none;'></span><!-- 수정 -->
		<span id='reply_<?=$comment_id?>' style='display:none;'></span><!-- 답변 -->
	</td>
</tr>
<tr><td></td><td colspan=2 class=c_tl></td></tr>
</table>
<br>
<? } ?>

<!-- 코멘트 리스트 -->
<? if ($is_comment_write) { ?>
<table width="98%" cellspacing="0" cellpadding="0" align="center">
<tr>
    <td height=30 align=right>
		<a href="javascript:comment_box('', 'c');"><img src='<?=$board_skin_path?>/img/btn_comment.gif' border=0 align=absmiddle></a>
		<? if($cwin==1) { ?>
		<a href="javascript:window.close();"><img src="<?=$board_skin_path?>/img/btn_close.gif" width="48" height="20" border="0" align=absmiddle></a>
		<? } ?>
	</td>
</tr>
<tr>
    <td>
        <!-- 코멘트 입력테이블시작 -->
        <span id=comment_write style='display:none;'>
        <form name="fviewcomment" method="post" action="./write_comment_update.php" onsubmit="return fviewcomment_submit(this);" autocomplete="off">
        <input type=hidden name=w           id=w value='c'>
        <input type=hidden name=bo_table    value='<?=$bo_table?>'>
        <input type=hidden name=wr_id       value='<?=$wr_id?>'>
        <input type=hidden name=comment_id  id='comment_id' value=''>
        <input type=hidden name=sfl         value='<?=$sfl?>' >
        <input type=hidden name=stx         value='<?=$stx?>'>
        <input type=hidden name=spt         value='<?=$spt?>'>
        <input type=hidden name=page        value='<?=$page?>'>
        <input type=hidden name=cwin        value='<?=$cwin?>'>
        <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td height='30' width="100%">
<? if ($is_guest) { ?>
	이름 <INPUT type=text maxLength=20 size=15 name="wr_name" itemname="이름" required class="bbs_ft">
	비번 <INPUT type=password maxLength=20 size=15 name="wr_password" itemname="패스워드" required class="bbs_ft">
	<? if ($is_norobot) { ?>
		<?=$norobot_str?> <INPUT title="왼쪽의 글자중 빨간글자만 순서대로 입력하세요." type="input" name="wr_key" itemname="자동등록방지" required class="bbs_ft">
	<? } ?>
<? } ?>
			</td>
        </tr>

		<tr>
            <td>
                <textarea id='wr_content' name='wr_content' class="bbs_fa" style="width:100%;" rows="5" itemname="내용" required ></textarea>
            </td>
			<td width="70">
				<INPUT type="image" src="<?=$board_skin_path?>/img/btn_comment_ok.gif" border=0 accesskey='s'>
			</td>
        </tr>
		<tr>
			<td><? include "$board_skin_path/write_input.php"; ?></td>
			<td>
				<SPAN class="bbs_point" onclick="textarea_decrease('wr_content', 10);"><img src="<?=$board_skin_path?>/img/write_up.gif"></SPAN>
				<SPAN  class="bbs_point" onclick="textarea_original('wr_content', 5);"><img src="<?=$board_skin_path?>/img/write_start.gif"></SPAN>
				<SPAN  class="bbs_point" onclick="textarea_increase('wr_content', 10);"><img src="<?=$board_skin_path?>/img/write_down.gif"></SPAN>
			</td>
		</tr>
        </table>
        </form>
        </span>
        <!-- 코멘트 입력 테이블 끝 -->
    </td>
</tr>
</table>

<script language='JavaScript'>
var save_before = '';
var save_html = document.getElementById('comment_write').innerHTML;
function fviewcomment_submit(f)
{
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자

    var s;
    if (s = word_filter_check(document.getElementById('wr_content').value))
    {
        alert("내용에 금지단어('"+s+"')가 포함되어있습니다");
        document.getElementById('wr_content').focus();
        return false;
    }

    if (typeof(f.wr_name) != 'undefined')
    {
        f.wr_name.value = f.wr_name.value.replace(pattern, "");
        if (f.wr_name.value == '')
        {
            alert('이름이 입력되지 않았습니다.');
            f.wr_name.focus();
            return false;
        }
    }

    if (typeof(f.wr_password) != 'undefined')
    {
        f.wr_password.value = f.wr_password.value.replace(pattern, "");
        if (f.wr_password.value == '')
        {
            alert('패스워드가 입력되지 않았습니다.');
            f.wr_password.focus();
            return false;
        }
    }

    if (typeof(f.wr_key) != 'undefined')
    {
        if (hex_md5(f.wr_key.value) != md5_norobot_key)
        {
            alert('자동등록방지용 빨간글자가 순서대로 입력되지 않았습니다.');
            f.wr_key.focus();
            return false;
        }
    }

    return true;
}

function comment_box(comment_id, work)
{
    var el_id;
    // 코멘트 아이디가 넘어오면 답변, 수정
    if (comment_id)
    {
		comment_box('', 'c');
        if (work == 'c')
            el_id = 'reply_' + comment_id;
        else
            el_id = 'edit_' + comment_id;
    }
    else
        el_id = 'comment_write';

    if (save_before != el_id)
    {
        if (save_before)
        {
            document.getElementById(save_before).style.display = 'none';
            document.getElementById(save_before).innerHTML = '';
        }

        document.getElementById(el_id).style.display = '';
        document.getElementById(el_id).innerHTML = save_html;
        // 코멘트 수정
        if (work == 'cu')
        {
            document.getElementById('wr_content').value = document.getElementById('save_comment_' + comment_id).value;
        }

        document.getElementById('comment_id').value = comment_id;
        document.getElementById('w').value = work;

        save_before = el_id;
    }
}

function comment_delete(url)
{
    if (confirm("이 코멘트를 삭제하시겠습니까?")) location.href = url;
}
</script>
<? } ?>