<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if ($is_dhtml_editor) {
    include_once("$g4[path]/lib/cheditor4.lib.php");
    echo "<script src='$g4[cheditor4_path]/cheditor.js'></script>";
    echo cheditor1('wr_content', '100%', '250px');
}
?>

<div style="height:14px; line-height:1px; font-size:1px;display:none">&nbsp;</div>

<style type="text/css">
.write_head { height:40px; font-size:14px; text-align:center; color:#6e6e6e; border-right:1px solid #e6e6e6; background:#fafafa; }
.field { border:1px solid #ccc; }

.file_input { width:250px; height:23px; border:1px solid #ddd; background:#fff; box-shadow:none; }

a.nBtn1 { background:#484848; color:#ffffff; padding:7px 15px; line-height:23px; font-size:13px; font-weight:400; display:inline-block; text-decoration:none; }
a.nBtn2 { background:#727272; color:#ffffff; padding:7px 15px; line-height:23px; font-size:13px; font-weight:400; display:inline-block; text-decoration:none; }

</style>

<script type="text/javascript">
// 글자수 제한
var char_min = parseInt(<?=$write_min?>); // 최소
var char_max = parseInt(<?=$write_max?>); // 최대
</script>

<form name="fwrite" id="fwrite" method="post" onsubmit="return fwrite_submit(this);" enctype="multipart/form-data" style="margin:0px;">
<input type=hidden name=null>
<input type=hidden name=w        value="<?=$w?>">
<input type=hidden name=bo_table value="<?=$bo_table?>">
<input type=hidden name=wr_id    value="<?=$wr_id?>">
<input type=hidden name=sca      value="<?=$sca?>">
<input type=hidden name=sfl      value="<?=$sfl?>">
<input type=hidden name=stx      value="<?=$stx?>">
<input type=hidden name=spt      value="<?=$spt?>">
<input type=hidden name=sst      value="<?=$sst?>">
<input type=hidden name=sod      value="<?=$sod?>">
<input type=hidden name=page     value="<?=$page?>">
<div>
<?//=cheditor2('wr_content', $content);?>
</div>
<table width="<?=$width?>" align=center cellpadding=0 cellspacing=0><tr><td>


<div style="height:50px; line-height:50px; background:#f8f8f8; padding:0 10px; width:100%; box-sizing:border-box; font-size:16px; border-top:1px solid #dddddd; border-bottom:1px solid #dddddd; color:#6e6e6e;">
고객상품평 <?=$title_msg?>
</div>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
<colgroup width=90>
<colgroup width=''>
<?
$option = "";
$option_hidden = "";
if ($is_notice || $is_html || $is_secret || $is_mail) {
    $option = "";
    if ($is_notice) {
        $option .= "<input type=checkbox name=notice value='1' $notice_checked>공지&nbsp;";
    }

    if ($is_html) {
        if ($is_dhtml_editor) {
            $option_hidden .= "<input type=hidden value='html1' name='html'>";
        } else {
            $option .= "<input onclick='html_auto_br(this);' type=checkbox value='$html_value' name='html' $html_checked><span class=w_title>html</span>&nbsp;";
        }
    }

    if ($is_secret) {
        if ($is_admin || $is_secret==1) {
            $option .= "<input type=checkbox value='secret' name='secret' $secret_checked><span class=w_title>비밀글</span>&nbsp;";
        } else {
            $option_hidden .= "<input type=hidden value='secret' name='secret'>";
        }
    }

    if ($is_mail) {
       // $option .= "<input type=checkbox value='mail' name='mail' $recv_email_checked>답변메일받기&nbsp;";
    }
}

echo $option_hidden;
if ($option) {
?>
<tr>
    <td class=write_head>옵 션</td>
    <td style="padding:10px;"><?=$option?></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>
<!-- 상품 선택 시작-->
<?

$it_result = sql_query("SELECT it_id, it_name FROM $g4[yc4_item_table] WHERE it_use = '1' order by it_id asc");
$item_list = "<select name='wr_6' onchange='selectItem(this)'>";

$it_idx = 0;
if($item_id)$write[wr_6] = $item_id;
while($item = sql_fetch_array($it_result)){
	$selected = "";
	if($it_idx == 0) $item_list .= "<option value=''>--선택하세요--</option>";
	if($write[wr_6] == $item[it_id]) {
		$selected = "selected";
		$write["wr_7"] = $item["it_name"];
	}
	$item_list .= "<option value='".$item[it_id]."' ".$selected.">".$item[it_name]."</option>";
	$it_idx++;
}
$item_list .= "</select>";
?>
<tr>
    <td class=write_head>상 품</td>
    <td style="padding:10px;"><span id='item_list'><?=$item_list?></span><input type='hidden' id='wr_7' name='wr_7' required value='<?=$write[wr_7]?>'/></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<!-- 상품 선택 끝-->
<? if ($is_name || ($is_admin && $w != "r")) { ?>
<tr>
    <td class=write_head>이 름</td>
    <td style="padding:10px;"><input class='ed' maxlength=20 size=15 name=wr_name itemname="이름" required value="<?=$name?>"></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if (($is_admin && $w != "r")) { ?>
<tr>
    <td class=write_head>작성일자</td>
    <td style="padding:10px;"><input class='ed calendar' maxlength=20 size=25 name=wr_datetime itemname="이름" required value="<?=date("Y-m-d H:i:s")?>"></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>


<? if ($is_password) { ?>
<tr>
    <td class=write_head>패스워드</td>
    <td style="padding:10px;"><input class='ed' type=password maxlength=20 size=15 name=wr_password itemname="패스워드" <?=$password_required?>></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<!--<? if ($is_email) { ?>
<tr>
    <td class=write_head>이메일</td>
    <td><input class='ed' maxlength=100 size=50 name=wr_email email itemname="이메일" value="<?=$email?>"></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($is_homepage) { ?>
<tr>
    <td class=write_head>홈페이지</td>
    <td><input class='ed' size=50 name=wr_homepage itemname="홈페이지" value="<?=$homepage?>"></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>-->

<? if ($is_category) { ?>
<tr>
    <td class=write_head>분 류</td>
    <td style="padding:10px;"><select name=ca_name required itemname="분류"><option value="">선택하세요<?=$category_option?></select></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>
<?
$bo=substr($bo_table,0,9);
?>
<?if($bo=='menu05_01'){?>
<?if(!$is_admin){?>
<?/*<tr>
    <td class=write_head>연락처</td>
    <td><input type="hidden" class='ed' style="width:120px;" name=wr_1 id="wr_1" itemname="연락처" required value="<?=$write[wr_1]?>">




<!--휴대폰 입력부 -->
			<input type="text" class='ed' maxlength=3 id="hp1" style="width:40px;" required > -
			<input type="text" class='ed' maxlength=4 id="hp2" style="width:50px;" required> -
			<input type="text" class='ed' maxlength=4 id="hp3" style="width:50px;" required>
			<script type="text/javascript">
				jQuery("#hp1,#hp2,#hp3").bind("blur",function(){
					jQuery("#wr_1").val( jQuery("#hp1").val() + "-"+ jQuery("#hp2").val() + "-"+ jQuery("#hp3").val());
				});
				jQuery("#hp1").bind("keyup",function(){
					if($(this).val().length >= 3) $("#hp2").focus();
				});
				jQuery("#hp2").bind("keyup",function(){
					if($(this).val().length >= 4) $("#hp3").focus();
				});
			</script>
<!--휴대폰 입력부 끝 -->
</td></tr>*/?>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<?}}?>


<tr>
	<td class=write_head>별 점</td>
	<td >
		<?
	$write[wr_4] = $write[wr_4]?$write[wr_4]:10;
			for($s=10;$s>-1;$s--){ 
				$check = ""; 
				if($write[wr_4] == $s ) $check = "checked"; 
				$star = $s<10?'0'.$s:$s; 
				$br=""; if($s==4) $br = "<br/>"; 
				echo $br."<input type='radio' name='wr_4' class=ed value='".$s."' ".$check." /><img src='".$board_skin_path."/img/star".$star.".gif' alt='$s' border=0 />";}?></td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>



<tr>
    <td class=write_head>제 목</td>
    <td style="padding:10px;"><input class='ed' style="width:99%;" name=wr_subject id="wr_subject" itemname="제목" required value="<?=$subject?>"></td></tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>

<tr>
	<td class=write_head>본문</td>
    <td style="padding:10px;">
        <? if ($is_dhtml_editor) { ?>
            <?=cheditor2('wr_content', $content);?>
        <? } else { ?>
        <table width=100% cellpadding=0 cellspacing=0>
        <tr>
            <td width=50% align=left valign=bottom>
                <span style="cursor: pointer;" onclick="textarea_decrease('wr_content', 10);"><img src="<?=$board_skin_path?>/img/up.gif"></span>
                <span style="cursor: pointer;" onclick="textarea_original('wr_content', 10);"><img src="<?=$board_skin_path?>/img/start.gif"></span>
                <span style="cursor: pointer;" onclick="textarea_increase('wr_content', 10);"><img src="<?=$board_skin_path?>/img/down.gif"></span></td>
            <td width=50% align=right><? if ($write_min || $write_max) { ?><span id=char_count></span>글자<?}?></td>
        </tr>
        </table>
        <textarea id="wr_content" name="wr_content" class=tx style='width:99%; word-break:break-all;' rows=10 itemname="본문" required
        <? if ($write_min || $write_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?}?>><?=$content?></textarea>
        <? if ($write_min || $write_max) { ?><script type="text/javascript"> check_byte('wr_content', 'char_count'); </script><?}?>
        <? } ?>
    </td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#dddddd></td></tr>

<!--<? if ($is_link) { ?>
<? for ($i=1; $i<=$g4[link_count]; $i++) { ?>
<tr>
    <td class=write_head>링크 #<?=$i?></td>
    <td><input type='text' class='ed' size=50 name='wr_link<?=$i?>' itemname='링크 #<?=$i?>' value='<?=$write["wr_link{$i}"]?>'></td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>
<? } ?>-->

<? if (false && $is_file) { ?>
<tr>
    <td class=write_head>파일첨부</td>
    <td style="padding:10px;"><table id="variableFiles" cellpadding=0 cellspacing=0 style="float:left;"></table><?// print_r2($file); ?>
		<div style="float:left; margin: 2px 0 0 10px">
		<span onclick="add_file();" style="cursor:pointer;"><img src="<?=$board_skin_path?>/img/btn_file_add.gif"></span>
        <span onclick="del_file();" style="cursor:pointer;"><img src="<?=$board_skin_path?>/img/btn_file_minus.gif"></span>
		</div>
		  <script type="text/javascript">
        var flen = 0;
        function add_file(delete_code)
        {
            var upload_count = <?=(int)$board[bo_upload_count]?>;
            if (upload_count && flen >= upload_count)
            {
                alert("이 게시판은 "+upload_count+"개 까지만 파일 업로드가 가능합니다.");
                return;
            }

            var objTbl;
            var objRow;
            var objCell;
            if (document.getElementById)
                objTbl = document.getElementById("variableFiles");
            else
                objTbl = document.all["variableFiles"];

            objRow = objTbl.insertRow(objTbl.rows.length);
            objCell = objRow.insertCell(0);

            objCell.innerHTML = "<input type='file' class='ed' name='bf_file[]' title='파일 용량 <?=$upload_max_filesize?> 이하만 업로드 가능'>";
            if (delete_code)
                objCell.innerHTML += delete_code;
            else
            {
                <? if ($is_file_content) { ?>
                objCell.innerHTML += "<br><input type='text' class='ed' size=50 name='bf_content[]' title='업로드 이미지 파일에 해당 되는 내용을 입력하세요.'>";
                <? } ?>
                ;
            }

            flen++;
        }

        <?=$file_script; //수정시에 필요한 스크립트?>

        function del_file()
        {
            // file_length 이하로는 필드가 삭제되지 않아야 합니다.
            var file_length = <?=(int)$file_length?>;
            var objTbl = document.getElementById("variableFiles");
            if (objTbl.rows.length - 1 > file_length)
            {
                objTbl.deleteRow(objTbl.rows.length - 1);
                flen--;
            }
        }
        </script>
		</td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($is_trackback) { ?>
<tr>
    <td class=write_head>트랙백주소</td>
    <td><input class='ed' size=50 name=wr_trackback itemname="트랙백" value="<?=$trackback?>">
        <? if ($w=="u") { ?><input type=checkbox name="re_trackback" value="1">핑 보냄<? } ?></td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<? } ?>

<? if ($is_guest) { /*?>
<tr>
    <td class=write_head><img id='kcaptcha_image' /></td>
    <td><input class='ed' type=input size=10 name=wr_key itemname="자동등록방지" required>&nbsp;&nbsp;왼쪽의 글자를 입력하세요.</td>
</tr>
<tr><td colspan=2 height=1 bgcolor=#e7e7e7></td></tr>
<?*/ } ?>

</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td width="100%" align="center" valign="top" style="padding-top:25px;">
		<a href="javascript:void(0)" onclick="$('#fwrite').submit()" class="nBtn1">확 인</a>&nbsp;
        <a href="/shop/item.php?it_id=<?=$item_id ?  $item_id : $write["wr_6"]?>#afterlist" class="nBtn2">상품으로</a>
	</td>
</tr>
</table>

</td></tr></table>
</form>

<div>

</div>
<script type="text/javascript" src="<?="$g4[path]/js/jquery.kcaptcha.js"?>"></script>
<script type="text/javascript">


function selectCategory(ca_id){
	$.ajax({
		type:'post',
		url:"<?=$board_skin_path?>/ajax_getItems.php?ca_id="+ca_id,
		contentType:"application/x-www-form-urlencoded;charset=utf-8",
		global:false,
		success:function(data) {				
			if(data == "N"){
				alert("해당 카테고리에는 상품이 존재하지 않습니다\n다른 카테고리를 선택하세요."); 
				$('#item_list').html("카테고리를 선택하세요.");
				return;
			}else{
				$('#item_list').html("");

				var option = "<select name='wr_6' onchange='selectItem(this)'>";
				var tArray = decodeURIComponent(data).split("&&");
				
				for(var i = 0 ; i < tArray.length ; i++) {
					var row = tArray[i].split("||");
					option += "<option value='"+row[0]+"'>"+row[1]+"</option>";
				}

				option += "</select>";
				$('#item_list').append(option);
			}
		}
	});
}

function selectItem(item){
	if(item.value){		
		$('#wr_7').val(item.options[item.selectedIndex].text);
	}
}
<?
// 관리자라면 분류 선택에 '공지' 옵션을 추가함
if ($is_admin)
{
    echo "
    if (typeof(document.fwrite.ca_name) != 'undefined')
    {
        document.fwrite.ca_name.options.length += 1;
        document.fwrite.ca_name.options[document.fwrite.ca_name.options.length-1].value = '공지';
        document.fwrite.ca_name.options[document.fwrite.ca_name.options.length-1].text = '공지';
    }";
}
?>

with (document.fwrite)
{
    if (typeof(wr_name) != "undefined")
        wr_name.focus();
    else if (typeof(wr_subject) != "undefined")
        wr_subject.focus();
    else if (typeof(wr_content) != "undefined")
        wr_content.focus();

    if (typeof(ca_name) != "undefined")
        if (w.value == "u")
            ca_name.value = "<?=$write[ca_name]?>";
}


function html_auto_br(obj)
{
    if (obj.checked) {
        result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
        if (result)
            obj.value = "html2";
        else
            obj.value = "html1";
    }
    else
        obj.value = "";
}

function fwrite_submit(f)
{
    /*
    var s = "";
    if (s = word_filter_check(f.wr_subject.value)) {
        alert("제목에 금지단어('"+s+"')가 포함되어있습니다");
        return false;
    }

    if (s = word_filter_check(f.wr_content.value)) {
        alert("내용에 금지단어('"+s+"')가 포함되어있습니다");
        return false;
    }
    */

    if (document.getElementById('char_count')) {
        if (char_min > 0 || char_max > 0) {
            var cnt = parseInt(document.getElementById('char_count').innerHTML);
            if (char_min > 0 && char_min > cnt) {
                alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                return false;
            }
            else if (char_max > 0 && char_max < cnt) {
                alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                return false;
            }
        }
    }

    if (document.getElementById('tx_wr_content')) {
        if (!ed_wr_content.outputBodyText()) {
         //   alert('본문을 입력하십시오.');
            ed_wr_content.returnFalse();
            return false;
        }
    }

    <?
    if ($is_dhtml_editor) echo cheditor3('wr_content');
    ?>

    var subject = "";
    var content = "";
    $.ajax({
        url: "<?=$board_skin_path?>/ajax.filter.php",
        type: "POST",
        data: {
            "subject": f.wr_subject.value,
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

    if (subject) {
        alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
        f.wr_subject.focus();
        return false;
    }

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        if (typeof(ed_wr_content) != "undefined")
            ed_wr_content.returnFalse();
        else
            f.wr_content.focus();
        return false;
    }

    if (!check_kcaptcha(f.wr_key)) {
        return false;
    }

    <?
    if ($g4[https_url])
        echo "f.action = '$g4[https_url]/$g4[bbs]/write_update.php';";
    else
        echo "f.action = './write_update.php';";
    ?>

    if(typeof(loading) == "function") loading();
    return true;
}
</script>

<script type="text/javascript" src="<?="$g4[path]/js/board.js"?>"></script>
<script type="text/javascript"> window.onload=function() { drawFont(); } </script>
