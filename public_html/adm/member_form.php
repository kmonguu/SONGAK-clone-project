<?
$sub_menu = "200100";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

$token = get_token();

if ($w == "") 
{
    $required_mb_id = "required minlength=3 alphanumericunderline itemname='회원아이디'";
    $required_mb_password = "required itemname='패스워드'";

    $mb[mb_mailling] = 1;
    $mb[mb_open] = 1;
    $mb[mb_level] = $config[cf_register_level];
    $html_title = "등록";
}
else if ($w == "u") 
{
    $mb = get_member($mb_id);
    if (!$mb[mb_id])
        alert("존재하지 않는 회원자료입니다."); 

    if ($is_admin != 'super' && $mb[mb_level] >= $member[mb_level])
        alert("자신보다 권한이 높거나 같은 회원은 수정할 수 없습니다.");

    $required_mb_id = "readonly style='background-color:#dddddd;'";
    $required_mb_password = "";
    $html_title = "수정";
} 
else 
    alert("제대로 된 값이 넘어오지 않았습니다.");

if ($mb[mb_mailling]) $mailling_checked = "checked"; // 메일 수신
if ($mb[mb_sms])      $sms_checked = "checked"; // SMS 수신
if ($mb[mb_open])     $open_checked = "checked"; // 정보 공개

$g4[title] = "회원정보 " . $html_title;
include_once("./admin.head.php");
?>

<table width=1000 cellpadding=0 cellspacing=0 class="list02" style="margin:10px 0 0 0;">
<form name=fmember method=post action="./member_form_update.php" onsubmit="return fmember_submit(this);" enctype="multipart/form-data" autocomplete="off">
<input type=hidden name=w     value='<?=$w?>'>
<input type=hidden name=sfl   value='<?=$sfl?>'>
<input type=hidden name=stx   value='<?=$stx?>'>
<input type=hidden name=sst   value='<?=$sst?>'>
<input type=hidden name=sod   value='<?=$sod?>'>
<input type=hidden name=page  value='<?=$page?>'>
<input type=hidden name=token value='<?=$token?>'>
<colgroup width=15% class='col1 pad1 bold right'>
<colgroup width=35% class='col2 pad2'>
<colgroup width=15% class='col1 pad1 bold right'>
<colgroup width=35% class='col2 pad2'>
<tr class='bgcol1 bold col1 ht center'>
    <td colspan=4 class=title align=left><img src='<?=$g4[admin_path]?>/img/icon_title.gif'> <?=$g4[title]?></td>
</tr>
<tr class='ht'>
    <td class="head">아이디</td>
    <td>
        <input type=text class=ed name='mb_id' size=20 maxlength=20 minlength=2 <?=$required_mb_id?> itemname='아이디' value='<? echo $mb[mb_id] ?>'>
        <!--<?if ($w=="u"){?><a href='./boardgroupmember_form.php?mb_id=<?=$mb[mb_id]?>'>접근가능그룹보기</a><?}?>-->
    </td>
    <td class="head">패스워드</td>
    <td><input type=password class=ed name='mb_password' size=20 maxlength=20 <?=$required_mb_password?> itemname='암호'></td>
</tr>
<tr class='ht'>
    <td class="head">이름(실명)</td>
    <td><input type=text class=ed name='mb_name' maxlength=20 minlength=2 required itemname='이름(실명)' value='<? echo $mb[mb_name] ?>'></td>
    <td class="head">별명</td>
    <td><input type=text class=ed name='mb_nick' maxlength=20 minlength=2 required itemname='별명' value='<? echo $mb[mb_nick] ?>'></td>
</tr>
<!-- 여분 필드 1로 업체 관리 정보 셋팅 -->

<!-- -->
<tr class='ht'>
    <td class="head">회원 권한</td>
    <td><?=get_member_level_select("mb_level", 1, $member[mb_level], $mb[mb_level])?></td>
	<td class="head">E-mail</td>
    <td><input type=text class=ed name='mb_email' size=40 maxlength=100 value='<? echo $mb[mb_email] ?>' required ></td>
</tr>
<tr class='ht'>
    <td class="head">전화번호</td>
    <td><input type=text class=ed name='mb_tel' maxlength=20 itemname='전화번호' value='<? echo $mb[mb_tel] ?>'></td>
    <td class="head">핸드폰번호</td>
    <td><input type=text class=ed name='mb_hp' maxlength=20 itemname='핸드폰번호' value='<? echo $mb[mb_hp] ?>'></td>
</tr>

<tr class='ht'>
    
	<td class="head">생년월일</td>
    <td colspan="1">
		<input type=text class="ed" id="mb_birth" name='mb_birth' value='<? echo $mb[mb_birth] ?>'>
	</td>

    <? //성별사용시 /config.php => "use_mb_sex" true로 변경  ?>
	<?if($g4["use_mb_sex"]){?>	
        <td class="head">성별</td>
        <td colspan="1">
            <select name="mb_sex" >
                <option value="M">남</option>
                <option value="F" <?=$mb["mb_sex"] == "F" ? "selected" : ""?>>여</option>
            </select>
        </td>
    <?} else {?>
        <td class="head"></td>
        <td colspan="1">
        </td>
    <?}?>


</tr>

<tr class='ht'>
    <td class="head">주소</td>
    <td colspan="3">
        <input type=text class=ed name='mb_zip1' size=5 maxlength=5 readonly itemname='우편번호' value='<? echo $mb[mb_zip1] ?>'> 
        <a href="javascript:;" onclick="openDaumPostcode('fmember', 'mb_zip1', 'mb_addr1', 'mb_addr2');"><img src='<?=$g4[bbs_img_path]?>/btn_zip.gif' border=0 style="vertical-align: top;
margin-bottom: 7px;"></a>
        <br><input type=text class=ed name='mb_addr1' size=40 readonly value='<? echo $mb[mb_addr1] ?>'>&nbsp;<input type=text class=ed name='mb_addr2' size=25 itemname='상세주소' value='<? echo $mb[mb_addr2] ?>'> 상세주소 입력
	</td>
</tr>
<tr class='ht'>
    <td class="head">메일 수신</td>
    <td><input type=checkbox name=mb_mailling value='1' <?=$mailling_checked?>> 정보 메일을 받음</td>
    <td class="head">SMS 수신</td>
    <td><input type=checkbox name=mb_sms value='1' <?=$sms_checked?>> 문자메세지를 받음</td>
</tr>
<tr class='ht'>
    <td class="head">서명</td>
    <td><textarea class=ed name=mb_signature rows=5 style='width:99%; word-break:break-all;'><? echo $mb[mb_signature] ?></textarea></td>
    <td class="head">자기 소개</td>
    <td><textarea class=ed name=mb_profile rows=5 style='width:99%; word-break:break-all;'><? echo $mb[mb_profile] ?></textarea></td>
</tr>
<tr class='ht'>
    <td class="head">메모</td>
    <td colspan=3><textarea class=ed name=mb_memo rows=5 style='width:99%; word-break:break-all;'><? echo $mb[mb_memo] ?></textarea></td>
</tr>

<!-- 
<tr class='ht'>
    <?if($mb[mb_id] == "webmaster"){?>	
		<td class="head">은행계좌</td>
		<td><textarea name=mb_3 rows=3 class=ed style='width:99%;'><?=$mb[mb_3]?></textarea></td>
	<?}else{?>
		<td class="head">여행사노출</td>
		<td>
			<input name='mb_2' type=checkbox value='on' <?if($mb[mb_2] == "on" /*|| $w != "u"*/){ echo "checked";}?>  />
			<?/*&nbsp;&nbsp;&nbsp;&nbsp;<span id="fee" style="display:<?=$mb[mb_2]!="on"?'none':'inline'?>;">수수료 : <input type=text size=10 id='mb_3' name=mb_3 value='<?=$mb[mb_3]?>' class=ed />원</span>*/?>
		</td>
	<?}?>
	<td class="head">여분필드</td>
	<td>&nbsp;</td>
</tr>
 -->

<? if ($w == "u") { ?>
<tr class='ht'>
    <td class="head">회원가입일</td>
    <td><?=$mb[mb_datetime]?></td>
    <td class="head">최근접속일</td>
    <td><?=$mb[mb_today_login]?></td>
</tr>
<tr class='ht'>
    <td class="head">IP</td>
    <td><?=$mb[mb_ip]?></td>

    <? if ($config[cf_use_email_certify]) { ?>
    <td class="head">인증일시</td>
    <td><?=$mb[mb_email_certify]?>
        <? if ($mb[mb_email_certify] == "0000-00-00 00:00:00") { echo "<input type=checkbox name=passive_certify>수동인증"; } ?></td>
    <? } else { ?>
    <td class="head">여분필드</td>
    <td></td>
    <? } ?>

</tr>
<? } ?>

<? if ($config[cf_use_recommend]) { // 추천인 사용 ?>
<tr class='ht'>
    <td>추천인</td>
    <td colspan=3><?=($mb[mb_recommend] ? get_text($mb[mb_recommend]) : "없음"); // 081022 : CSRF 보안 결함으로 인한 코드 수정 ?></td>
</tr>
<? } ?>

<tr class='ht'>
    <td class="head">탈퇴일자</td>
    <td><input type=text class=ed name=mb_leave_date size=9 maxlength=8 value='<? echo $mb[mb_leave_date] ?>'></td>
    <td class="head">접근차단일자</td>
    <td><input type=text class=ed name=mb_intercept_date size=9 maxlength=8 value='<? echo $mb[mb_intercept_date] ?>'> <input type=checkbox value='<? echo date("Ymd"); ?>' onclick='if (this.form.mb_intercept_date.value==this.form.mb_intercept_date.defaultValue) { this.form.mb_intercept_date.value=this.value; } else { this.form.mb_intercept_date.value=this.form.mb_intercept_date.defaultValue; } '>오늘</td>
</tr>
<!--
<tr class='ht'>
	<td>여분 필드 2</td>
    <td colspan="3"><input type=text class=ed style='width:37%;' name='mb_2' maxlength=255 value='<?=$mb["mb_2"]?>'></td>
</tr>

<? for ($i=3; $i<=10; $i=$i+2) { $k=$i+1; ?>
<tr class='ht'>
    <td>여분 필드 <?=$i?></td>
    <td><input type=text class=ed style='width:99%;' name='mb_<?=$i?>' maxlength=255 value='<?=$mb["mb_$i"]?>'></td>
    <td>여분 필드 <?=$k?></td>
    <td><input type=text class=ed style='width:99%;' name='mb_<?=$k?>' maxlength=255 value='<?=$mb["mb_$k"]?>'></td>
</tr>
<? } ?>

<tr class='ht'>
    <td colspan=4 align=left>
        <?=subtitle("XSS / CSRF 방지")?>
    </td>
</tr>-->
<tr class='ht'>
    <td class="head">
        관리자 패스워드
    </td>
    <td colspan=3>
        <input class='ed' type='password' name='admin_password' itemname="관리자 패스워드" required>
        <?=help("관리자 권한을 빼앗길 것에 대비하여 로그인한 관리자의 패스워드를 한번 더 묻는것 입니다.", 20, -100);?>
    </td>
</tr>
</table>
<div style="width:1000px;">
<p align=center style="padding:10px 0 0 0;">
    <input type=submit class=btn1 accesskey='s' value='  확    인  '>&nbsp;
    <input type=button class=btn1 value='  목  록  ' onclick="document.location.href='./member_list.php?<?=$qstr?>';">&nbsp;

    <? if ($w != '' && $member[mb_level] == 10) { ?>
    <input type=button class=btn1 value='  삭  제  ' onclick="del('./member_delete.php?<?=$qstr?>&w=d&mb_id=<?=$mb[mb_id]?>&url=<?=$_SERVER[PHP_SELF]?>');">&nbsp;
    <? } ?>
</form>
</div>

<script type='text/javascript'>
if (document.fmember.w.value == "")
    document.fmember.mb_id.focus();
else if (document.fmember.w.value == "u")
    document.fmember.mb_password.focus();

if (typeof(document.fmember.mb_level) != "undefined")
    document.fmember.mb_level.value   = "<?=$mb[mb_level]?>";

function fmember_submit(f)
{
    if (!f.mb_icon.value.match(/\.(gif|jp[e]g|png)$/i) && f.mb_icon.value) {
        alert('아이콘이 이미지 파일이 아닙니다. (bmp 제외)');
        return false;
    }

    f.action = './member_form_update.php';
    return true;
}

function ftouryn(check){
	var display = "none";
	if(check) display = "inline";
	$('#fee').css("display",display);
}




$.datepicker.regional['ko'] = {
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
$.datepicker.setDefaults($.datepicker.regional['ko']);


$(function(){
	jQuery("#mb_birth").datepicker({
			showOn: "both",
			buttonImage: "/img/calendar.gif",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			showButtonPanel: false,
			dateFormat: 'yy-mm-dd',
			yearRange:"<?=date("Y")-100?>:<?=date("Y")?>"
	});

});



</script>

<?
include_once("./admin.tail.php");
?>
