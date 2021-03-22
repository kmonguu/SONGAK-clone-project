<?
include_once("./_common.php");

$g4[title] = "글쓰기";


$is_html = false;
if ($member[mb_level] >= $board[bo_html_level])
    $is_html = true;

$is_secret = $board[bo_use_secret];

if ($board[bo_use_dhtml_editor] && $member[mb_level] >= $board[bo_html_level])
    $is_dhtml_editor = true;
else
    $is_dhtml_editor = false;



if ($is_dhtml_editor) {
	include_once("$g4[path]/lib/cheditor4.lib.php");
	echo "<script src='$g4[cheditor4_path]/cheditor.js'></script>";
	echo cheditor1('wr_content', '100%', '500px');
}



if($w == "u") {
	$sql = "select * from g4_write_".$bo_table." where wr_id = '$wr_id' ";
	$result = sql_fetch($sql);

	$name = $result[wr_name];
	$password = $result[wr_password];
	$subject = $result[wr_subject];
	$content = $result[wr_content];

	$file = get_file($bo_table, $wr_id);

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

<style>
	input {font-size:21px;height:40px;};
</style>
<form name="fwrite" method="post" onsubmit="return fwrite_submit(this);" enctype="multipart/form-data" style="margin-top:55px" data-ajax="false">
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
<div style="height:20px;"></div>
	<ul>
		<?if(!$is_member){?>
		<li>
		이름
		</li>
		<li>
		<input class="" size="15" name="wr_name" itemname="이름" required="required" placeholder="이름" value="<?=$name?>" onFocus="this.placeholder=''">
		</li>
		<li>
		패스워드
		</li>
		<li>
		<input type="password" class="" size="15" name="wr_password" itemname="패스워드" required="required" placeholder="패스워드" value="<?=$password?>" onFocus="this.placeholder=''">
		</li>
		<?}?>
		<li style='font-weight:bold'>
		제목
		</li>
		<li>
		<input class="" size="15" name="wr_subject" itemname="제목" required="required" placeholder="제목" value="<?=$subject?>" onFocus="this.placeholder=''">
		</li>
		


		<li style='font-weight:bold; font-size:1.5em;margin-bottom:15px;'>
			투숙정보
		</li>

		<li style='font-weight:bold'>
		CHECK-IN
		</li>
		<li>
		<input class="calendar" size="15" name="wr_2" itemname="CHECK-IN" required="required" placeholder="CHECK-IN" value="<?=$write[wr_2]?>" onFocus="this.placeholder=''">
		</li>

		<li style='font-weight:bold'>
		CHECK-OUT
		</li>
		<li>
		<input class="calendar" size="15" name="wr_3" itemname="CHECK-OUT" required="required" placeholder="CHECK-OUT" value="<?=$write[wr_3]?>" onFocus="this.placeholder=''">
		</li>

		<li style='font-weight:bold'>
		ROOM-TYPE
		</li>
		<li>
			<input type="text" name="wr_4" value="<?=$write[wr_4]?>"  />
		</li>

		<li style='font-weight:bold'>
		ROOMS
		</li>
		<li>
			<input type="text" name="wr_5" value="<?=$write[wr_5]?>"  />
		</li>

		<li style='font-weight:bold'>
		인원수
		</li>
		<li>
			성인:<input class="" size="4" name="wr_6" itemname="성인" required="required" placeholder="성인" value="<?=$write[wr_6]?>" onFocus="this.placeholder=''" style="width:50px"> 
			어린이:<input class="" size="4" name="wr_7" itemname="성인" required="required" placeholder="성인" value="<?=$write[wr_7]?>" onFocus="this.placeholder=''" style="width:50px">
		</li>
		

		
		<li style='font-weight:bold; font-size:1.5em;margin-bottom:15px;margin-top:15px;'>
			예약자정보
		</li>

		<li style='font-weight:bold'>
		NAME
		</li>
		<li>
			<input type="text" name="wr_name" value="<?=$write[wr_name]?>"  />
		</li>

		<li style='font-weight:bold'>
		PHONE
		</li>
		<li>
			<input class="" size="15" name="wr_1" itemname="핸드폰" required="required" placeholder="핸드폰" value="<?=$write[wr_1]?>" onFocus="this.placeholder=''">
		</li>
		

		<li style='font-weight:bold'>
		EMAIL
		</li>
		<li>
			<input type="text" name="wr_email" value="<?=$write[wr_email]?>" />
		</li>


		<li style='font-weight:bold; font-size:1.5em;margin-bottom:15px;margin-top:15px;'>
			투숙자정보
		</li>

		<li style='font-weight:bold'>
		NAME
		</li>
		<li>
			<input type="text" name="wr_8" value="<?=$write[wr_8]?>"  />
		</li>

		<li style='font-weight:bold'>
		PHONE
		</li>
		<li>
			<input class="" size="15" name="wr_9" itemname="핸드폰" required="required" placeholder="핸드폰" value="<?=$write[wr_9]?>" onFocus="this.placeholder=''">
		</li>
		
		<li style='font-weight:bold'>
		EMAIL
		</li>
		<li>
			<input type="text" name="wr_10" value="<?=$write[wr_10]?>" />
		</li>

		<li style='font-weight:bold'>
		EMAIL 수신
		</li>
		<li>
			<select id="select_box" class=input_txt1 name='wr_11' class='ed' required itemname='E-mail 수신' style="font-size:14px;">
				<option value='Y' <? if($write[wr_11] == "Y") echo "selected"; ?> >예</option>
				<option value='N' <? if($write[wr_11] == "N") echo "selected"; ?>>아니오</option>
			</select>
		</li>




		<li style='font-weight:bold; font-size:1.5em;margin-bottom:15px;margin-top:15px;'>
			추가요청
		</li>

		<li style='font-weight:bold'>
		추가요청사항
		</li>
		<li>
			<? if ($is_dhtml_editor) { ?>
		        <?=cheditor2('wr_content', $content);?>
	    	<? } else { ?>
				<textarea id="wr_content" class="" name="wr_content" rows="5" itemname="내용" required="required"  placeholder="내용" onFocus="this.placeholder=''"><?=$content?></textarea>
			<? }?>
		</li>
		<li>
		<!--
		<input type='file' class='ed' name='bf_file[]' title='파일 용량 <?=$upload_max_filesize?> 이하만 업로드 가능'>
		-->
		<!-- <table id="variableFiles" cellpadding=0 cellspacing=0 style="float:left;"></table>파일업로드 -->
		<script type="text/javascript">

		$(function(){

			jQuery.datepicker.regional['ko'] = {
				closeText: '닫기',
				prevText: '이전달',
				nextText: '다음달',
				currentText: '오늘',
				monthNames: ['1월(JAN)','2월(FEB)','3월(MAR)','4월(APR)','5월(MAY)','6월(JUN)',
				'7월(JUL)','8월(AUG)','9월(SEP)','10월(OCT)','11월(NOV)','12월(DEC)'],
				monthNamesShort: ['1월','2월','3월','4월','5월','6월',
				'7월','8월','9월','10월','11월','12월'],
				dayNames: ['일','월','화','수','목','금','토'],
				dayNamesShort: ['일','월','화','수','목','금','토'],
				dayNamesMin: ['일','월','화','수','목','금','토'],
				weekHeader: 'Wk',
				dateFormat: 'yy-mm-dd',
				firstDay: 0,
				isRTL: false,
				showMonthAfterYear: true,
				yearSuffix: ''};
			jQuery.datepicker.setDefaults(jQuery.datepicker.regional['ko']);

			jQuery(".calendar").datepicker({
					//showOn: "both",
					//buttonImage: "/img/calendar.gif",
					//buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					//showButtonPanel: false,
			});

			jQuery("img.ui-datepicker-trigger").attr("style","vertical-align:top; cursor:pointer;");
		});


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

            objCell.innerHTML = "<input type='file' class='ed' name='bf_file[]' title='파일 용량 <?=$upload_max_filesize?> 이하만 업로드 가능'><br>";
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
		<li style="width:100%;text-align:center"></li>
	</ul>

	<div style='width:200px;margin:0 auto' >
		<input type="submit" value=" 확 인 ">
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
<script type="text/javascript"> window.onload=function() { drawFont(); } </script>


<?
//include_once($g4[mpath]."/tail.php");
?>
