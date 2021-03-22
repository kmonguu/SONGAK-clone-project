<?
include_once("./_common.php");

$g4[title] = "글쓰기";
include_once($g4[mpath]."/head.php");


if ($is_dhtml_editor) {
    include_once("$g4[path]/lib/cheditor4.lib.php");
    echo "<script src='$g4[cheditor4_path]/cheditor.js'></script>";
    echo cheditor1('wr_content', '100%', '300px');
}


?>
  <!-- <div style="padding-top:100px;"></div> -->
<style type="text/css">
ul li {font-size:24px;}
</style>

<form name="fwrite" method="post" onsubmit="return fwrite_submit(this);" enctype="multipart/form-data" style="margin:0px;">
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
<div style="height:0px; clear:both; "></div>
	<ul>
		<?if ($option) {?>
		<li>옵 션</li>
	    <li>
	    	<?=$option?>
	    </li>
		<? } ?>
		
		<?if(!$is_member){?>
		<li>
		이름
		</li>
		<li>
		<input class="input_txt1" size="15" name="wr_name" itemname="이름" required="required" placeholder="이름" value="<?=$name?>" onFocus="this.placeholder=''" style="font-size:21px;height:40px;">
		</li>
		<li>
		패스워드
		</li>
		<li>
		<input type="password" class="input_txt1" size="15" name="wr_password" itemname="패스워드" <?if($w==""){?>required="required"<?}?> placeholder="패스워드" value="<?=$password?>" onFocus="this.placeholder=''" style="font-size:21px;height:40px;">
		</li>
		<?}?>
		<li>
		제목
		</li>
		<li>
		<input class="input_txt1" size="15" name="wr_subject" itemname="제목" required="required" placeholder="제목" value="<?=$subject?>" onFocus="this.placeholder=''" style="font-size:21px;height:40px;">
		</li>
		<li>
		내용
		</li>
		<li>
			<? if ($is_dhtml_editor) { ?>
		        <?=cheditor2('wr_content', $content);?>
		    <? } else { ?>
				<textarea id="wr_content2" class="input_txt2" name="wr_content" rows="15" itemname="내용" required="required"  placeholder="내용" onFocus="this.placeholder=''" style="font-size:21px;"><?=$content?></textarea>
			<?}?>

		</li>
		<li>
				
				<? if ($is_file) { ?>
					<div style="float:left; margin: 2px 0 0 10px">
						<table id="variableFiles" cellpadding=0 cellspacing=0 style="float:left;"></table>
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

						    objCell.innerHTML = "<input type='file' class='ed' name='bf_file[]' title='파일 용량 <?=$upload_max_filesize?> 이하만 업로드 가능' style='font-size:24px; height:35px;'>";
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
				<? } ?>
		</li>
		<li style="margin-top:50px; text-align:center;"><span class="button xLarge strong"><input type="submit" value=" 확 인 "></span></li>
	</ul>
</div>
</form>

<script type="text/javascript">

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

    f.action='./write_update.php';

    return true;
}


$(function(){
	$(".cheditor-editarea").contents().find("body").css("font-size", "21px");
	$(".cheditor-tb-wrapper").hide();
	$(".cheditor-viewmode").hide();
});

</script>

<script type="text/javascript" src="<?="$g4[path]/js/board.js"?>"></script>
<script type="text/javascript"> window.onload=function() { drawFont(); } </script>


