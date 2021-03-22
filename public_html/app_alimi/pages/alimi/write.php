<?
include "./_common.php";

$g4[title] = "글쓰기";




$is_html = false;
if ($member[mb_level] >= $board[bo_html_level])
    $is_html = true;

$is_secret = $board[bo_use_secret];

if (!$isIOS && $board[bo_use_dhtml_editor] && $member[mb_level] >= $board[bo_html_level])
    $is_dhtml_editor = true;
else
    $is_dhtml_editor = false;



if ($is_dhtml_editor) {
	include_once("$g4[path]/lib/cheditor4.lib.php");
	echo "<script src='$g4[cheditor4_path]/cheditor.js?2'></script>";
	echo cheditor1('wr_content', '100%', '500px');
}



//if(!$is_member) alert("글쓰기는 회원 전용입니다.");
$is_secret = false;
if($w == "u") {
	$sql = "select * from g4_write_".$bo_table." where wr_id = '$wr_id' ";
	$result = sql_fetch($sql);

	$name = $result[wr_name];
	$password = $result[wr_password];
	$subject = $result[wr_subject];
	$content = $result[wr_content];

	$file = get_file($bo_table, $wr_id);

	if ($is_admin == "super") // 최고관리자 통과
    ;
	else if ($is_admin == "group") { // 그룹관리자
		$mb = get_member($write[mb_id]);
		if ($member[mb_id] != $group[gr_admin]) // 자신이 관리하는 그룹인가?
			alert("자신이 관리하는 그룹의 게시판이 아니므로 삭제할 수 없습니다.");
		else if ($member[mb_level] < $mb[mb_level]) // 자신의 레벨이 크거나 같다면 통과
			alert("자신의 권한보다 높은 권한의 회원이 작성한 글은 삭제할 수 없습니다.");
	} else if ($is_admin == "board") { // 게시판관리자이면
		$mb = get_member($write[mb_id]);
		if ($member[mb_id] != $board[bo_admin]) // 자신이 관리하는 게시판인가?
			alert("자신이 관리하는 게시판이 아니므로 삭제할 수 없습니다.");
		else if ($member[mb_level] < $mb[mb_level]) // 자신의 레벨이 크거나 같다면 통과
			alert("자신의 권한보다 높은 권한의 회원이 작성한 글은 삭제할 수 없습니다.");
	} else if ($member[mb_id]) {
		if ($member[mb_id] != $write[mb_id])
			alert("자신의 글이 아니므로 삭제할 수 없습니다.");
	} else {
		if ($write[mb_id])
			alert("로그인 후 삭제하세요.", "./login.php?url=".urlencode("./board.php?bo_table=$bo_table&wr_id=$wr_id"));
		else if (sql_password($wr_password) != $write[wr_password])
			alert("패스워드가 틀리므로 삭제할 수 없습니다."); 
	}
	

	if (strstr($write[wr_option], "html1")) {
		$html_checked = "checked";
		$html_value = "html1";
	} else if (strstr($write[wr_option], "html2")) {
		$html_checked = "checked";
		$html_value = "html2";
	} else
		$html_value = "";
	
	if (strstr($write[wr_option], "secret"))
		$secret_checked = "checked";
	
} else if($w == "r") {
	
	$sql = "select * from g4_write_".$bo_table." where wr_id = '$wr_id' ";
	$result = sql_fetch($sql);

	if (strstr($write[wr_option], "secret")) {
		$is_secret = true;
		$secret_checked = "checked";
	}

	$subject = "[답글]".$result[wr_subject];

	if ($is_dhtml_editor) { 
		$content = "[원글]<br/>".$result[wr_content]."<br/><hr/>[답변]<br/>";
	} else {
		$content = "";
	}

}





?>


<form name="fwrite" method="post" onsubmit="return fwrite_submit(this);" enctype="multipart/form-data" style="margin:0px;" data-ajax="false">
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
        $option .= "<input type=checkbox value='mail' name='mail' $recv_email_checked>답변메일받기&nbsp;";
    }
}
echo $option_hidden;
?>


<div id="m_write">
	<ul>
		<?if(!$is_member){?>
		<li>
		이름
		</li>
		<li>
		<input class="input_txt1"  name="wr_name" itemname="이름" required="required" placeholder="이름" value="<?=$name?>" onFocus="this.placeholder=''">
		</li>
		<li>
		패스워드
		</li>
		<li>
		<input type="password" class="input_txt1" size="15" name="wr_password" itemname="패스워드" required="required" placeholder="패스워드" value="<?=$password?>" onFocus="this.placeholder=''">
		</li>
		<?}?>
		<li>
		제목
		</li>
		<li>
		<input class="" size="15" name="wr_subject" itemname="제목" required="required" placeholder="제목" value="<?=$subject?>" onFocus="this.placeholder=''">
		</li>
		<li>
		내용 <span id="testx"></span>
		</li>
		<li>
			<? if ($is_dhtml_editor) { ?>
		        <?=cheditor2('wr_content', $content);?>
	    	<? } else { ?>
				<textarea id="wr_content" class="wr_content" name="wr_content" rows="15" itemname="내용" required="required"  placeholder="내용" onFocus="this.placeholder=''" style='height:150px;font-size:21px;'><?=$content?></textarea>
			<? }?>
		</li>
		<li>
		<!--
		<input type='file' class='ed' name='bf_file[]' title='파일 용량 <?=$upload_max_filesize?> 이하만 업로드 가능'>
		-->
		<table id="variableFiles" cellpadding=0 cellspacing=0 style="float:left;"></table>
		<script type="text/javascript">
<?
//echo "count : ".$file[count];
for ($i=0; $i<$file[count]; $i++)
{
	$row = sql_fetch(" select bf_file, bf_content from $g4[board_file_table] where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$i' ");
	if ($row[bf_file])
	{
		$file_script .= "add_file(\"<input type='checkbox' name='bf_file_del[$i]' value='1'>".cut_str($file[$i][source], 15)."({$file[$i][size]}) 파일 삭제";
		if ($is_file_content)
			//$file_script .= "<br><input type='text' class=ed size=50 name='bf_content[$i]' value='{$row[bf_content]}' title='업로드 이미지 파일에 해당 되는 내용을 입력하세요.'>";
			// 첨부파일설명에서 ' 또는 " 입력되면 오류나는 부분 수정
			$file_script .= "<br><input type='text' class='' size=50 name='bf_content[$i]' value='".addslashes(get_text($row[bf_content]))."' title='업로드 이미지 파일에 해당 되는 내용을 입력하세요.'>";
		$file_script .= "\");\n";
	}
	else
		$file_script .= "add_file('');\n";
}
$file_length = $file[count] - 1;
if ($file_length < 0)
{
    $file_script .= "add_file('');\n";
    $file_length = 0;
}
?>

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

            objCell.innerHTML = "<input type='file' class='' name='bf_file[]' title='파일 용량 <?=$upload_max_filesize?> 이하만 업로드 가능'><br>";
            if (delete_code)
                objCell.innerHTML += delete_code;
            else
            {
                <? if ($is_file_content) { ?>
                objCell.innerHTML += "<br><input type='text' class='' size=50 name='bf_content[]' title='업로드 이미지 파일에 해당 되는 내용을 입력하세요.'>";
                <? } ?>
                ;
            }

            flen++;
        }


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
		</li>
		<li><span class="button xLarge strong"></span></li>

	</ul>
	<div style='width:200px;margin:0 auto' >
		<input type="submit" value=" 확 인 ">
		<a href="./pages.php?p=1_2_1_1&wr_id=<?=$wr_id?>&bo_table=<?=$bo_table?>" data-role="button">취소</a>
	</div>
</div>
</form>

<script type="text/javascript">
<?=$file_script; //수정시에 필요한 스크립트?>

function fwrite_submit(f) {


	<?
		if ($is_dhtml_editor) echo cheditor3('wr_content');
	?>
		    
   if (!f.wr_subject.value) {
        f.wr_subject.focus();
        return false;
    }

	if (!f.wr_content.value) {
        f.wr_content.focus();
        return false;
    }

	loading();
	
    f.action='./pages/bbs/write_update.php';

    return true;
}

$(function(){
	$("textarea, input").attr("spellcheck", "false").attr("autocorrect", "off").attr("autocapitalize","off").attr("autocomplete","off");
	$(".cheditor-editarea").contents().find("body").attr("spellcheck", "false").attr("autocorrect", "off").attr("autocapitalize","off").attr("autocomplete","off");
	$(".cheditor-editarea").contents().find("body").css({"font-size":"21px", "word-break":"break-all"});
	$(".cheditor-tb-wrapper").hide();
	$(".cheditor-viewmode").hide();
});



function setKeyboard(){

	if(is_device_ready) {
		if(typeof(Keyboard) != "undefined") {	
			Keyboard.hideFormAccessoryBar(false);
			Keyboard.disableScrollingInShrinkView(false);
		}
	} else {
		setTimeout("setKeyboard()",500);
	}
	
}
setKeyboard();

</script>

<script type="text/javascript" src="<?="$g4[path]/js/board.js"?>"></script>
<script type="text/javascript"> window.onload=function() { /*drawFont();*/ } </script>

