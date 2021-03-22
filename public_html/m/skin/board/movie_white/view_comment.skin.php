<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<style>
.Comentot { position:relative; background:#fcfcfc; border:1px solid #e9e9e9; width:600px; margin:30px 0 40px 0px; padding:30px 20px 50px; display:inline-block; box-sizing:border-box; }
.Comentot ul {float:left;margin-bottom:35px;width:100%;}
.Comentot ul li {position:relative;float:left;padding:36px 0 0 5px;margin-top:35px; width:100%; box-sizing:border-box;}
.Comentot ul li span.Ico {position:absolute;top:0;left:25px;}
.Comentot ul li span.Name {position:absolute;top:10px;left:5px;color:#494949;font-size:17px;font-weight:bold;}
.Comentot ul li span.Date {position:absolute;top:12px;right:5px;color:#848484;}
.Comentot ul li span.Con {float:left;font-size:16px;color:#494949;line-height:20px;border-top:1px solid #dcdcdc;padding:10px 0 0 0;width:100%;}

.Comentot ul li.reply {position:relative;float:left;padding:36px 0 0 34px;margin-top:25px;}
.Comentot ul li.reply span.Ico {position:absolute;top:0;left:80px;}
.Comentot ul li.reply span.Name {position:absolute;top:10px;left:34px;/*color:#fd551b;*/font-size:17px;font-weight:bold;}
.Comentot ul li.reply span.Date {position:absolute;top:12px;right:5px;color:#848484;}
.Comentot ul li.reply span.Con {float:left;font-size:16px;color:#494949;line-height:20px;border-top:1px solid #dcdcdc;padding:10px 0 0 0;width:100%; }

.pic_profile > img { width:54px; height:54px; }

#btn_comment { width:123px; height:72px; font-size:16px; color:#ffffff; font-weight:500; background:#d83c3c; border-radius:5px; border:0px; float:right; margin:27px 10px 0 0; outline:none; }
</style>


<script type="text/javascript">
// 글자수 제한
var char_min = parseInt(<?=$comment_min?>); // 최소
var char_max = parseInt(<?=$comment_max?>); // 최대
</script>

<div class="Comentot">

	<? if ($is_comment_write) { ?>
	<div id=comment_write style="display:none;">
		
		<form name="fviewcomment" id="fviewcomment" method="post" action="./write_comment_update.php" onsubmit="return fviewcomment_submit(this);" autocomplete="off" style="margin:0px;">
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
		<input type=hidden name=is_good     value=''>
		<?if($vc=="1"){?>
			<input type=hidden name=vc     value='1'/>
		<? }?>

			<div class="txa_comment" style="float:left; margin-left:0px;">
				<textarea  id="wr_content" name="wr_content"  style="width:385px; height:210px; border:1px solid #d8d8d8; color:#a1a1a1; padding:10px;" onfocus="txtfocus(this)" placeholder="댓글을 남겨주세요!" style='width:99%; word-break:break-all;' class=tx></textarea>
			</div>
			

			<input type="submit" class="btn_comment" id="btn_comment" value="등록하기" />
		
			<? if ($is_guest) { ?>
				
				<?
					$ss_cmt_name = get_session("ssname");
					$ss_cmt_password = get_session("sspwd");
					
					if($ss_cmt_name) {
				?>
					<input type="hidden" name="wr_name" value="<?=$ss_cmt_name?>"/>
					<input type="hidden" name="wr_password" value="<?=$ss_cmt_password?>"/>
				<? } else {?>
					<div style="margin-top:10px;padding-left:0px; display:inline-block; ">
						닉네임 : <input type="text" name="wr_name" placeholder="닉네임" style="border:1px solid #d8d8d8;color:#a1a1a1; height:30px;padding-left:10px;width:110px;" />
					</div>
					<div style="margin-top:10px;padding-left:14px; display:inline-block;  ">
						패스워드 : <input type="password" name="wr_password" placeholder="패스워드" style="border:1px solid #d8d8d8;color:#a1a1a1; height:30px;padding-left:10px;width:110px;" />
					</div>
				<? }?>
			<? }?>
		</form>
		
	</div>
	<? }?>
	
	
	<ul>
	
		<? for ($i=0; $i<count($list); $i++) { $comment_id = $list[$i][wr_id]; ?>
		<? 
			$cmt_depth = strlen($list[$i][wr_comment_reply]);
			$li_class = ""; 
			if($cmt_depth >= 1){ $li_class= "reply";}
			if($vc=="1"){
				$list[$i][del_link] = $list[$i][del_link]."&vc=1";
            }
            
            $reStyle = "";
            $reLeft = 36 * ($cmt_depth);
            $reStyle = "padding-left:{$reLeft}px";
            $reStyle2 = "left:{$reLeft}px";

		?>
		<li class="<?=$li_class?>" style="<?=$reStyle?>">
			<a name="c_<?=$comment_id?>"></a>
			
			
			<span class="Name"  style="<?=$reStyle2?>"><?=$list[$i][wr_name]?></span>
			<span class="Date">
				<?=$list[$i][datetime]?>
				<? if ($is_ip_view) { echo "&nbsp;<span style=\"color:#444444; font-size:11px;\">{$list[$i][ip]}</span>"; } ?>
				
                <?// if ($is_admin && $cmt_depth ==0 && $list[$i][is_reply]) { echo "<a href=\"javascript:comment_box('{$comment_id}', 'c');\">답변</a> "; } ?>
				
                <?if ($list[$i][is_reply]) { echo "<a href=\"javascript:comment_box('{$comment_id}', 'c');\">답변</a> "; } ?>
                
                <? if ($list[$i][is_edit]) { echo "<a href=\"javascript:comment_box('{$comment_id}', 'cu');\">수정</a> "; } ?>
                <? if ($list[$i][is_del])  { echo "<a href=\"javascript:comment_delete('{$list[$i][del_link]}');\">삭제</a> "; } ?>
			</span>
			<span class="Con">
				<?
                if (strstr($list[$i][wr_option], "secret")) echo "<span style='color:#ff6600;'>*</span> ";
                $str = $list[$i][content];
                if (strstr($list[$i][wr_option], "secret"))
                    $str = "<span class='small' style='color:#ff6600;'>$str</span>";

                $str = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $str);
                // FLASH XSS 공격에 의해 주석 처리 - 110406
                //$str = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(swf)\".*\<\/a\>\]/i", "<script>doc_write(flash_movie('$1://$2.$3'));</script>", $str);
                $str = preg_replace("/\[\<a\s*href\=\"(http|https|ftp)\:\/\/([^[:space:]]+)\.(gif|png|jpg|jpeg|bmp)\"\s*[^\>]*\>[^\s]*\<\/a\>\]/i", "<img src='$1://$2.$3' id='target_resize_image[]' onclick='image_window(this);' border='0'>", $str);
                echo $str;
                ?>
                

                
                <input type=hidden id='secret_comment_<?=$comment_id?>' value="<?=strstr($list[$i][wr_option],"secret")?>">
                <textarea id='save_comment_<?=$comment_id?>' style='display:none;'><?=get_text($list[$i][content1], 0)?></textarea>
                
			</span>
			
			<div id='edit_<?=$comment_id?>' style='display:none;'>
			</div>
			<div id='reply_<?=$comment_id?>' style='display:none;'>
			</div>
		</li>
		
		
		<? }?>
		
	
	</ul>
</div>







<? if ($is_comment_write) { ?>



<script type="text/javascript" src="<?="$g4[path]/js/jquery.kcaptcha.js"?>"></script>
<script type="text/javascript">

        function txtfocus(obj){
        	if($(obj).val() == $(obj).attr("placeholder")){
            	$(obj).val("");
        	}
        }
        
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

var is_first = true;
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

			$("#fviewcomment").find(".pic_profile").hide();
			$("#fviewcomment").find(".txa_comment").css("padding-left", "0px");                        
			$("#fviewcomment").find(".btn_comment").css("top", "103px");                        
            /*
            if (document.getElementById('secret_comment_'+comment_id).value)
                document.getElementById('wr_secret').checked = true;
            else
                document.getElementById('wr_secret').checked = false;
            */
        }
        if(!is_first && work == 'c'){
        	$("#fviewcomment").find(".pic_profile").hide();
			$("#fviewcomment").find(".txa_comment").css("padding-left", "0px");                        
			$("#fviewcomment").find(".btn_comment").css("top", "103px");       
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

    is_first = false;
}

function comment_delete(url)
{
    if (confirm("이 코멘트를 삭제하시겠습니까?")) location.href = url;
}

comment_box('', 'c'); // 코멘트 입력폼이 보이도록 처리하기위해서 추가 (root님)
</script>
<? } ?>

<? if($cwin==1) { ?></td><tr></table><p align=center><a href="javascript:window.close();"><img src="<?=$board_skin_mpath?>/img/btn_close.gif" border="0"></a><br><br><?}?>
