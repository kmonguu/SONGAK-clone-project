<?
include_once("./_common.php");



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


<form name="fwrite" id="fwrite" method="post" onsubmit="return fwrite_submit(this);" enctype="multipart/form-data" style="margin:0px;" data-ajax="false">
<input type=hidden name=null>
<input type=hidden name=w        value="<?=$w?>">
<input type=hidden name=p        value="2_2_1_1">
<input type=hidden name=bo_table value="<?=$bo_table?>">
<input type=hidden name=bo_table value="<?=$bo_table?>">
<input type=hidden name=wr_id    value="<?=$wr_id?>">
<input type=hidden name=sca      value="<?=$sca?>">
<input type=hidden name=sfl      value="<?=$sfl?>">
<input type=hidden name=stx      value="<?=$stx?>">
<input type=hidden name=spt      value="<?=$spt?>">
<input type=hidden name=sst      value="<?=$sst?>">
<input type=hidden name=sod      value="<?=$sod?>">
<input type=hidden name=page     value="<?=$page?>">

<input type=hidden name=save_sc     value="<?=$save_sc?>">
<input type=hidden name=save_page     value="<?=$save_page?>">
<input type=hidden name="ca_name" value="<?=$write["ca_name"]?>"/>
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

if ($option) {
	echo '
		<div style="display:none;">
			'.$option.'
		</div>
	';
}




if($board[bo_skin] == "reservation_white" || $board[bo_skin] =="reservation_black"  || $board[bo_skin] =="inquiry_white2"  || $board[bo_skin] =="inquiry_white" || $board[bo_skin] =="inquiry_black"  || $board[bo_skin] =="inquiry_black2" )
		include_once($g4["mpath"]."/include/2_3_1_1_write_r1.php"); //게시판 뷰 (예약게시판)
	else if($board[bo_skin] == "reserve_white" || $board[bo_skin] =="reserve_black" )
		include_once($g4["mpath"]."/include/2_3_1_1_write_r2.php"); //게시판 뷰 (호텔용예약게시판)
	else if($board[bo_skin] == "reserve_phone" )
		include_once($g4["mpath"]."/include/2_3_1_1_write_r3.php");		//게시판 뷰 (연락처 및 상태)
	else
        include_once($g4["mpath"]."/include/2_3_1_1_write.php"); //게시판 뷰 (호텔용예약게시판)
        

