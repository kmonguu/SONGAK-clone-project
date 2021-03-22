
<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;">게시판 답변하기</div>
<div class="nbox" style="padding-top:0;">
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:28px;width:20%;">제목</div>
		<div style="position:relative;float:left;width:67.5%;margin-top:20px;">
			<input type="text" class="input02"  name="wr_subject" itemname="제목" required="required" placeholder="제목" value="<?=$subject?>" onFocus="this.placeholder=''" >
		</div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:28px;width:20%;">답변내용</div>
		<div style="position:relative;float:left;width:70.5%;">

			<? if ($is_dhtml_editor) { ?>
		        <?=cheditor2('wr_content', $content);?>
	    	<? } else { ?>
				<textarea id="wr_content" class="textarea01" name="wr_content" rows="8" itemname="내용" required="required"  placeholder="내용" onFocus="this.placeholder=''" style='width:95%;font-size:21px;'><?=$content?></textarea>
			<? }?>

		</div>
	</div>
	
	
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>

	<div style="float:left;width:100%;margin-top:10px;">
		<div style="float:left;width:20.786%;margin-left:27%;"><a href="javascript:void(0);" onclick='$("#fwrite").submit()'><img src="/app_helper/images/write_btn.jpg" style="width:100%"/></a></div>
		<div style="float:left;width:23.449%;margin-left:3%;"><a href="javascript:void(0);" onclick="menum('menu02-1')"><img src="/app_helper/images/list_btn.jpg" style="width:100%"/></a></div>
	</div>
</div>



<table id="variableFiles" cellpadding=0 cellspacing=0 style="float:left; display:none;"></table>
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
	
    f.action='<?=$g4["mpath"]?>/bbs/write_update.php';

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

