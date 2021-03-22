<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if ($is_dhtml_editor) {
    include_once("$g4[path]/lib/cheditor4.lib.php");
    echo "<script src='$g4[cheditor4_path]/cheditor.js'></script>";
    echo cheditor1('wr_content', '100%', '300px');
}


$option = "";
$option_hidden = "";
if ($is_notice || $is_html || $is_secret || $is_mail) {
	$option = "";
	if ($is_notice) {
		$option .= "<input type=checkbox name=notice id='notice' value='1' $notice_checked><label for='notice' >공지</label>&nbsp;";
	}

	if ($is_html) {
		if ($is_dhtml_editor) {
			$option_hidden .= "<input type=hidden value='html1' name='html'>";
		} else {
			$option_hidden .= "<input type=hidden value='$html_value' name='html' >";
		}
	}

	if ($is_secret) {
		if ($is_admin || $is_secret==1) {
			$option .= "<input type=checkbox value='secret' name='secret' id='secret' $secret_checked><label for='secret' >비밀글</label>&nbsp;";
		} else {
			$option_hidden .= "<input type=hidden value='secret' name='secret' id='secret' >";
		}
	}

	if ($is_mail) {
		$option .= "<input type=checkbox value='mail' name='mail' id='mail' $recv_email_checked><label for='mail' >답변메일받기</label>&nbsp;";
	}
}
?>

<style type="text/css">
.WriteBoardTable {  }
.WriteBoardTable > tbody {  }
.WriteBoardTable > tbody > tr {  }
.WriteBoardTable > tbody > tr > th { height:45px; font-size:17px; text-align:center; color:#6e6e6e; border-right:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6; background:#fafafa; font-weight:400; }
.WriteBoardTable > tbody > tr > td { font-size:17px; text-align:left; color:#6e6e6e; border-bottom:1px solid #e6e6e6; padding:10px; }
.field { border:1px solid #ccc; }

#variableFiles td { padding:2px 0; }
.file_btn { background:none; border:0; font-size:16px; margin:0 5px; padding:5px; outline:none; color:#777; }
.file_input { width:250px; height:30px; border:1px solid #ddd; background:#fff; box-shadow:none; }
.file_input_content { vertical-align:top; width:100%; box-sizing:border-box; margin:5px 0 10px; padding:0 5px; border:1px solid #D8D8D8; height:35px; }

a.nBtn1,
.nBtn1 { background:#484848; color:#ffffff; padding:7px 15px; line-height:23px; font-size:17px; font-weight:400; display:inline-block; text-decoration:none; border:0px; }
a.nBtn2,
.nBtn2 { background:#727272; color:#ffffff; padding:7px 15px; line-height:23px; font-size:17px; font-weight:400; display:inline-block; text-decoration:none; border:0px; }

</style>

<script type="text/javascript">
// 글자수 제한
var char_min = parseInt(<?=$write_min?>); // 최소
var char_max = parseInt(<?=$write_max?>); // 최대
</script>

<form name="fwrite" id="fwrite" method="post" onsubmit="return fwrite_submit(this);" enctype="multipart/form-data" style="margin:0px;">
<input type=hidden name=null>
<input type=hidden name=w        value="<?=$w?>" >
<input type=hidden name=bo_table value="<?=$bo_table?>" >
<input type=hidden name=wr_id    value="<?=$wr_id?>" >
<input type=hidden name=sca      value="<?=$sca?>" >
<input type=hidden name=sfl      value="<?=$sfl?>" >
<input type=hidden name=stx      value="<?=$stx?>" >
<input type=hidden name=spt      value="<?=$spt?>" >
<input type=hidden name=sst      value="<?=$sst?>" >
<input type=hidden name=sod      value="<?=$sod?>" >
<input type=hidden name=page     value="<?=$page?>" >
<?
echo $option_hidden;
?>




<div style="height:50px; line-height:50px; background:#f8f8f8; padding:0 10px; width:100%; box-sizing:border-box; font-size:21px; border-top:1px solid #dddddd; border-bottom:1px solid #dddddd; color:#222;">
<?=$title_msg?>
</div>


<table width="100%" border="0" cellspacing="0" cellpadding="0" class="WriteBoardTable" >
	<caption><?=$board["bo_subject"]?> <?=$title_msg?> - <?=$option ? "옵션, " : ""?><?=$is_name ? "이름, " : ""?><?=$is_password ? "패스워드, " : ""?><?=$is_category ? "분류, " : ""?>제목, 본문<?=$is_file && $board[bo_upload_count] > 0 ? ", 파일첨부로" : "으로"?> 구성</caption>

	<colgroup>
		<col width="110px" />
		<col width="" />
	</colgroup>

	<tbody>
		<?if ($option) {?>
		<tr>
			<th scope="row" >옵 션</th>
			<td>
				<?=$option?>
			</td>
		</tr>
		<? } ?>
		

		<? if ($board["bo_sort_field"] == "wr_10 asc, wr_num, wr_reply" && $is_admin) {?>
		<tr>
			<th scope="row" ><label for="wr_subject">노출순서</label></th>
			<td>
				<input class='ed' style="width:80px;" name=wr_10 id="wr_10" itemname="노출순서" data-required="required" value="<?=$write["wr_10"] ? $write["wr_10"] : "1"?>" >&nbsp;&nbsp;<span style="color:#888;" >(※숫자가 작을수록 상위노출 됩니다.)</span>
			</td>
		</tr>
		<? } ?>


		<? if ($is_name) { ?>
		<tr>
			<th scope="row" ><label for="wr_name">이 름</label></th>
			<td>
				<input class='ed' maxlength=20 name=wr_name id="wr_name" itemname="이름" data-required="required" style="width:50%;" value="<?=$name?>" >
			</td>
		</tr>
		<? } ?>

		
		<? if ($is_password) { ?>

			<? if($board["bo_use_secret"] > 0 || (isset($bo_use_password_input) && in_array($bo_table, $bo_use_password_input))){ ?>
				<tr class="tr_password" style="display:none;" >
					<th scope="row" ><label for="wr_password">패스워드</label></th>
					<td>
						<input type="password" class='ed' maxlength=20 name=wr_password id="wr_password" itemname="패스워드" <?=$password_required?> style="width:50%;" value="<?=md5(date("YmdHis"))?>" >
					</td>
					
					<script>
						function check_password_show() {
							<?if($board["bo_use_secret"] == "2" || $board["bo_use_secret"] == "0"){?>
									$("#wr_password").val("");
									$(".tr_password").show();
							<?} else {?>
								if($("input[name='secret']").is(":checked")) { 
									$("#wr_password").val("");
									$(".tr_password").show();
								} else {
									$(".tr_password").hide();
									$("#wr_password").val("<?=md5(date("YmdHis"))?>");
								}
							<?}?>
						}
						check_password_show();
						$("input[name='secret']").change(check_password_show);
					</script>
				</tr>
			<? }  else { ?>
				<tr style="display:none;">
					<th></th>
					<td><input type=hidden name="wr_password" value="<?=md5(date("YmdHis"))?>" /></td>
				</tr>
			<? } ?>    
			
		<?}?>



		<? if ($is_category) { ?>
		<tr>
			<th scope="row" ><label for="ca_name">분 류</label></th>
			<td>
				<select name=ca_name id="ca_name" data-required="required" itemname="분류">
					<option value="">선택하세요<?=$category_option?>
				</select>
			</td>
		</tr>
		<? } ?>

		<tr>
			<th scope="row" ><label for="wr_subject">제 목</label></th>
			<td>
				<input class='ed' style="width:99%;" name=wr_subject id="wr_subject" itemname="제목" data-required="required" value="<?=$write["wr_subject"]?>" >
			</td>
		</tr>

		<tr>
			<th scope="row" colspan="2" style="border-right:0px;" ><label for="wr_content">본 문</label></th>
		</tr>
		<tr>
			<td colspan="2" >
				<? if ($is_dhtml_editor) { ?>
					<?=cheditor2('wr_content', $content);?>
				<? } else { ?>
					<textarea id="wr_content" name="wr_content" class=tx style='width:99%; word-break:break-all;' rows=10 itemname="본문" data-required="required"  
					<? if ($write_min || $write_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?}?>><?=$content?></textarea>
					<? if ($write_min || $write_max) { ?><script type="text/javascript"> check_byte('wr_content', 'char_count'); </script><?}?>
				<? } ?>
			</td>
		</tr>

		<? if ($is_file && $board[bo_upload_count] > 0) { ?>
		<tr>
			<th scope="row" ><label for="wr_content">파일첨부</label></th>
			<td>
				<div style="margin:0px 0 10px 0px;" >
					<button type="button" onclick="add_file();" class="file_btn" alt="첨부파일 갯수 +1" >
						<i class="fas fa-plus"></i>
					</button>
					<button type="button" onclick="del_file();" class="file_btn" alt="첨부파일 갯수 -1" >
						<i class="fas fa-minus"></i>
					</button>
				</div>

				<table id="variableFiles" cellpadding=0 cellspacing=0 style="float:left;"></table><?// print_r2($file); ?>

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

					objCell.innerHTML = "<input type='file' class='file_input' name='bf_file[]' title='파일 용량 <?=$upload_max_filesize?> 이하만 업로드 가능'>";
					if (delete_code)
						objCell.innerHTML += delete_code;
					else
					{
						<? if ($is_file_content) { ?>
						objCell.innerHTML += "<input type='text' class='file_input file_input_content' name='bf_content[]' title='업로드 이미지 파일에 해당 되는 내용을 입력하세요.' placeholder='업로드 이미지 파일에 해당 되는 내용을 입력하세요.' >";
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

				$(function(){
					//$("#variableFiles").prepend("<caption>첨부파일 업로드. +, - 버튼으로 첨부파일 수량 설정</caption>");
				});
				</script>
			</td>
		</tr>
		<? } ?>

		<? if ($is_trackback) { ?>
		<tr>
			<th scope="row" ><label for="wr_trackback">트랙백주소</label></th>
			<td>
				<input class='ed' size=50 name=wr_trackback id="wr_trackback" itemname="트랙백" value="<?=$trackback?>">
				<? if ($w=="u") { ?><input type=checkbox name="re_trackback" value="1">핑 보냄<? } ?>
			</td>
		</tr>
		<? } ?>

		<? if ($is_guest) { /*?>
		<tr>
			<th scope="row" ><img id='kcaptcha_image' alt="자동등록방지 이미지" /></th>
			<td>
				<input class='ed' type=input size=10 name="wr_key" id="wr_key" itemname="자동등록방지" data-required="required" >&nbsp;&nbsp;
				<label for="wr_key">왼쪽의 글자를 입력하세요.</label>
			</td>
		</tr>
		<?*/ } ?>
	</tbody>
</table>

<? if ($is_file && $board[bo_upload_count] > 0 && false) { ?>
	<p style="color:#CC0000; font:15px dotum; margin-top:5px;">첨부파일 이미지 사이즈는 가로 최대 1200px로 맞춰주세요.</p>
<?}?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td width="100%" align="center" valign="top" style="padding-top:25px;">
				<button type="button" onclick="$('#fwrite').submit()" class="nBtn1" >확 인</button>
				<a href="./board.php?bo_table=<?=$bo_table?>" class="nBtn2">목록보기</a>
			</td>
		</tr>
	</tbody>
</table>

</form>


<script type="text/javascript" src="<?="$g4[path]/js/jquery.kcaptcha.js"?>"></script>
<script type="text/javascript">
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

with (document.fwrite) {
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
	
	/*
    if (document.getElementById('tx_wr_content')) {
        if (!ed_wr_content.outputBodyText()) {
			alert('본문을 입력하십시오.');
            ed_wr_content.returnFalse();
            return false;
        }
    }
	*/

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
<script type="text/javascript"> window.onload=function() { /*drawFont();*/ } </script>
