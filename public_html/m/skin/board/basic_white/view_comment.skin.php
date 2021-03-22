<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<style>
#comment_title { width:100%; display:inline-block; text-align:left; height:40px; line-height:40px; margin-top:50px; }
#comment_title > p { line-height:40px; color:#272727; font-size:19px; font-weight:300; padding-left:22px; background:url("/img/comment_icon.png") no-repeat left center; }

.comment_table { padding:25px 0; }
.comment_table caption { position:absolute; left:-9999px; }

.comment_write_top { position:relative; width:100%; display:inline-block; line-height:31px; margin-bottom:15px; }
.comment_write_top > span { color:#272727; font-size:19px; font-weight:300; }
#answer1 { display:inline-block; float:right; background:#e9e9e9; color:#4c4c4c; font-size:16px; padding:0 22px; cursor:pointer; }
#answer2 { display:inline-block; float:right; background:#e9e9e9; color:#4c4c4c; font-size:16px; padding:0 22px; margin:0 5px; cursor:pointer; }
#fviewcomment_submit_btn { display:inline-block; float:right; background:#ff9c00; color:#fff; font-size:18px; padding:0 22px; line-height:35px; border:0; cursor:pointer; font-weight:300; }

.comment_photo { width:68px; height:68px; background-position:center center; background-repeat:no-repeat; border-radius:50%; position:relative; background-size:cover; background-image:url('/img/comment_company.png'); }

.comment_con { width:100%; display:inline-block; border:1px solid #ddd; border-radius:5px; background-color:#fff; position:relative; }
.comment_con_head { display:inline-block; width:100%; padding:0 20px; box-sizing:border-box; line-height:31px; color:#777; font-size:16px; font-weight:300; border-bottom:1px solid #ddd; }

.comment_content { width:100%; min-height:130px; color:#272727; font-size:16px; font-weight:300; border:0px; padding:10px 20px; box-sizing:border-box; background:none !important; margin:0; resize:none; }

a.comment_link { display:inline-block; padding-left:20px; line-height:20px; color:#777; font-size:16px; font-weight:300; text-decoration:none; }
a.comment_link1 { background:url("/img/co_icon1.png") no-repeat left center; }
a.comment_link2 { background:url("/img/co_icon2.png") no-repeat left center; }
a.comment_link3 { background:url("/img/co_icon3.png") no-repeat left 2px center; }
</style>

<script type="text/javascript">
// 글자수 제한
var char_min = parseInt(<?=$comment_min?>); // 최소
var char_max = parseInt(<?=$comment_max?>); // 최대
</script>


<div id="comment_title">
	<p>댓글 <font color="#ff7f00"><?=count($list)?></font></p>
</div>

<!-- 코멘트 리스트 -->
<div id="commentContents" style="font-size:0px;" >
	<?
	for ($i=0; $i<count($list); $i++) {
		$comment_id = $list[$i][wr_id];
		

		//이름 *표시
		$a = $list[$i]['wr_name'];
		$name_len = mb_strlen($a, 'utf-8');
		if($name_len > 4){
			$b = mb_substr($a, 0, 3, 'utf-8');
			for($idx = 0 ; $idx < $name_len-3; $idx++){
				$b .= "*";
			}
			//$b .= mb_substr($a, -1, 1, 'utf-8');
		} else if($name_len > 2){
			$b = mb_substr($a, 0, 1, 'utf-8');
			for($idx = 0 ; $idx < $name_len-1; $idx++){
				$b .= "*";
			}
			//$b .= mb_substr($a, -1, 1, 'utf-8');
		} else {
			$b = "*".mb_substr($a, -1, 1, 'utf-8');
		}
		$b = $a;
		//echo $b;
		//이름 *표시 끝
		

		//대댓글
		$cmt_depth = strlen($list[$i][wr_comment_reply]);
		$reply_css = ""; 
		if($cmt_depth >= 1){ $reply_css = "margin-left:".($cmt_depth*30)."px;";}
	?>

	<div name="c_<?=$comment_id?>" id="c_<?=$comment_id?>" style="display:inline-block; width:100%; border-bottom:1px solid #ddd;" >
		<table border=0 cellpadding=0 cellspacing=0 width=100% >
			<colgroup>
				<col width="" />
				<col width="100%" />
			<colgroup>
			<tr>
				<td>
					<?if($cmt_depth >= 1){?>
						<img src="/img/reply.png" style="width:30px; height:auto; <?=$reply_css?>" />
					<?}?>
				</td>
				<td>
					<table border=0 cellpadding=0 cellspacing=0 width=100% class="comment_table" >
						<caption><?=$list[$i][wr_name]?>님의 댓글 - 작성자, 작성일시, 내용으로 구성</caption>
						<colgroup>
							<col width="140px" />
							<col width="" />
							<col width="70px" />
						</colgroup>
						<tbody>
							<tr>
								<td valign="top" align="center" >
									<p style="font-size:19px; color:#222; font-weight:400;" ><span class="hidden" >작성자 : </span><?=$b?></p>
									
									<p style="font-size:16px; color:#222; font-weight:300; padding:5px 0 0;">
										<span class="hidden" >작성일시 : </span>
										<?=date("Y-m-d",strtotime($list[$i][wr_datetime]))?>
										<?//=$list[$i][datetime]?>
									</p>
									
									<? if ($is_ip_view && false) {?>
										<p style="font-size:16px; color:#666; font-weight:300; padding:5px 0 0;">IP : <?=$list[$i][ip]?></p>
									<? } ?>
								</td>
								<td valign=top align="left" style="padding:0 20px 0 80px;" >


									<!-- 코멘트 출력 -->
									<p class="hidden" >내용 : </p>
									<div style='font-size:18px; color:#222; font-weight:300; line-height:24px; '>
										<?
										if (strstr($list[$i][wr_option], "secret")) echo "<span style='color:#ff6600;'>*</span> ";
										$str = $list[$i][content];
										if (strstr($list[$i][wr_option], "secret"))
											$str = "<span style='color:#ff6600;'>$str</span>";

										$str = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $str);
										// FLASH XSS 공격에 의해 주석 처리 - 110406
										//$str = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(swf)\".*\<\/a\>\]/i", "<script>doc_write(flash_movie('$1://$2.$3'));</script>", $str);
										$str = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<img src='$1://$2.$3' id='target_resize_image[]' onclick='image_window(this);' border='0'>", $str);
										echo $str;
										?>
									</div>
									<? if ($list[$i][trackback]) { echo "<p>".$list[$i][trackback]."</p>"; } ?>
									<span id='edit_<?=$comment_id?>' style='display:none;'></span><!-- 수정 -->
									<span id='reply_<?=$comment_id?>' style='display:none;'></span><!-- 답변 -->
									
									<input type=hidden id='secret_comment_<?=$comment_id?>' value="<?=strstr($list[$i][wr_option],"secret")?>">
									<textarea id='save_comment_<?=$comment_id?>' style='display:none;'><?=get_text($list[$i][content1], 0)?></textarea>
								</td>
								
								<td valign="bottom" align="center" >
									<? if ($list[$i][is_reply]) { echo "<div style='padding:4px 0;' ><a href=\"#comment_box\" onclick=\"comment_box('{$comment_id}', 'c');\" class='comment_link comment_link1' >답변</a></div> "; } ?>
									<? if ($list[$i][is_edit]) { echo "<div style='padding:4px 0;' ><a href=\"#comment_box\" onclick=\"comment_box('{$comment_id}', 'cu');\" class='comment_link comment_link2' >수정</a></div> "; } ?>
									<? if ($list[$i][is_del])  { echo "<div style='padding:4px 0;' ><a href=\"#comment_box\" onclick=\"comment_delete('{$list[$i][del_link]}');\" class='comment_link comment_link3' >삭제</a></div> "; } ?>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<? } ?>

	<?if($i == 0){?>
		<!-- <div style="display:inline-block; width:100%; padding:30px 20px; font-size:17px; color:#222; font-weight:300;" >
			등록된 리뷰가 없습니다.<br/>
			리뷰를 작성해주세요!
		</div> -->
	<?}?>
</div>
<!-- 코멘트 리스트 -->

<?if ($is_comment_write) { ?>
<!-- 코멘트 입력 -->
<div id=comment_write style="display:none; width:100%; box-sizing:border-box; padding:0px 40px 30px; background:#fbfbfb;"  >
<form name="fviewcomment" method="post" action="./write_comment_update.php" onsubmit="return fviewcomment_submit(this);" autocomplete="off" style="margin:0px;">
<input type=hidden name=w           id=w value='c' >
<input type=hidden name=bo_table    value='<?=$bo_table?>' >
<input type=hidden name=wr_id       value='<?=$wr_id?>' >
<input type=hidden name=comment_id  id='comment_id' value='' >
<input type=hidden name=sca         value='<?=$sca?>' >
<input type=hidden name=sfl         value='<?=$sfl?>' >
<input type=hidden name=stx         value='<?=$stx?>' >
<input type=hidden name=spt         value='<?=$spt?>' >
<input type=hidden name=page        value='<?=$page?>' >
<input type=hidden name=cwin        value='<?=$cwin?>' >
<input type=hidden name=is_good     value=''>

<!-- 
<div class="comment_write_top" >
	<span>댓글쓰기</span>
</div>
 -->
<table width=100% cellpadding=0 cellspacing=0 style="padding-top:30px;" >
	<caption>댓글작성 - <? if ($is_guest) { ?>이름, 패스워드, <? } ?>비밀글체크, 내용으로 구성</caption>
	<colgroup>
		<col width="" />
	</colgroup>
<? if ($is_guest) { ?>
	<tr>
		<td style="padding:10px 0;">
			이름 <INPUT type=text maxLength=20  name="wr_name" itemname="이름" data-required="required" class='ed' style="width:150px;" >
			&nbsp;&nbsp;&nbsp;&nbsp;
			패스워드 <INPUT type=password maxLength=20 name="wr_password" itemname="패스워드" data-required="required" class='ed' style="width:150px;" >
		</td>
	</tr>
<? } ?>
<tr>
    <td>
		<div class="comment_con" >
			<div class="comment_con_head">
				<input type=checkbox id="wr_secret" name="wr_secret" value="secret"><label for="wr_secret">비밀글쓰기</label>
			</div>

			<textarea id="wr_content" name="wr_content" class="comment_content" itemname="내용" data-required="required" <? if ($comment_min || $comment_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?}?> style='word-break:break-all;' title="내용" ></textarea>
			<? if ($comment_min || $comment_max) { ?>
				<span id=char_count></span>글자
				<script type="text/javascript"> check_byte('wr_content', 'char_count'); </script>
			<?}?>
			
			<?if($member["mb_id"]){?>
			<script type="text/javascript">
				$(function(){
				
					//$(".comment_content").attr("placeholder", "현재 <?=$member['mb_nick']?>으로 로그인되어 있습니다.\n본인의 이름이 아니라면 본인의 아이디로 재로그인해주세요.");

				});
			</script>
			<?}?>

		</div>
    </td>
</tr>
</table>

<div style="width:100%; display:inline-block; margin-top:10px;" >
	<input type="submit" id="fviewcomment_submit_btn" border=0 accesskey='s' value="댓글쓰기" >
</div>
</form>
</div>
<? } ?>

<script type="text/javascript" src="<?="$g4[path]/js/jquery.kcaptcha.js"?>"></script>
<script type="text/javascript">
var save_before = '';
var save_html = document.getElementById('comment_write').innerHTML;

function good_and_write()
{
    var f = document.fviewcomment;
    if (fviewcomment_submit(f)) {
        f.is_good.value = 1;
        f.submit();
    } else {
        f.is_good.value = 0;
    }
}

function fviewcomment_submit(f)
{
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자

    f.is_good.value = 0;

    /*
    var s;
    if (s = word_filter_check(document.getElementById('wr_content').value))
    {
        alert("내용에 금지단어('"+s+"')가 포함되어있습니다");
        document.getElementById('wr_content').focus();
        return false;
    }
    */
	

	
	var req_valid = true;
	$("[data-required='required']").each(function(){
		if($(this).val() == "") {
			alert($(this).attr("itemname")+"은(는) 반드시 입력해야합니다.");
			req_valid = false;
			$(this).focus();
			return false;
		}
	});
	if(!req_valid) return false;


    var subject = "";
    var content = "";
    $.ajax({
        url: "<?=$board_skin_path?>/ajax.filter.php",
        type: "POST",
        data: {
            "subject": "",
            "content": f.wr_content.value
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
            subject = data.subject;
            content = data.content;
        }
    });

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        f.wr_content.focus();
        return false;
    }

    // 양쪽 공백 없애기
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
    document.getElementById('wr_content').value = document.getElementById('wr_content').value.replace(pattern, "");
    if (char_min > 0 || char_max > 0)
    {
        check_byte('wr_content', 'char_count');
        var cnt = parseInt(document.getElementById('char_count').innerHTML);
        if (char_min > 0 && char_min > cnt)
        {
            alert("코멘트는 "+char_min+"글자 이상 쓰셔야 합니다.");
            return false;
        } else if (char_max > 0 && char_max < cnt)
        {
            alert("코멘트는 "+char_max+"글자 이하로 쓰셔야 합니다.");
            return false;
        }
    }
    else if (!document.getElementById('wr_content').value)
    {
        alert("코멘트를 입력하여 주십시오.");
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

    if (!check_kcaptcha(f.wr_key)) {
        return false;
    }

    return true;
}

/*
jQuery.fn.extend({
    kcaptcha_load: function() {
        $.ajax({
            type: 'POST',
            url: g4_path+'/'+g4_bbs+'/kcaptcha_session.php',
            cache: false,
            async: false,
            success: function(text) {
                $('#kcaptcha_image')
                    .attr('src', g4_path+'/'+g4_bbs+'/kcaptcha_image.php?t=' + (new Date).getTime())
                    .css('cursor', '')
                    .attr('title', '');
                md5_norobot_key = text;
            }
        });
    }
});
*/

function comment_box(comment_id, work)
{
    var el_id;
    // 코멘트 아이디가 넘어오면 답변, 수정
    if (comment_id)
    {
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
            if (typeof char_count != 'undefined')
                check_byte('wr_content', 'char_count');
            if (document.getElementById('secret_comment_'+comment_id).value)
                document.getElementById('wr_secret').checked = true;
            else
                document.getElementById('wr_secret').checked = false;
        }

        document.getElementById('comment_id').value = comment_id;
        document.getElementById('w').value = work;

        save_before = el_id;
    }

    if (typeof(wrestInitialized) != 'undefined')
        wrestInitialized();

    //jQuery(this).kcaptcha_load();
    if (comment_id && work == 'c')
        $.kcaptcha_run();
}

function comment_delete(url)
{
    if (confirm("이 코멘트를 삭제하시겠습니까?")) location.href = url;
}

comment_box('', 'c'); // 코멘트 입력폼이 보이도록 처리하기위해서 추가 (root님)
</script>

