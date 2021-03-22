<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>



<style type="text/css">
.regiter_table { border-top:2px solid #7f7f7f; text-align:left; }
.regiter_table td { padding:5px 20px; border-bottom:1px solid #c2c2c2; font-size:14px; color:#8e8e8e; font-weight:300; height:32px; }
.regiter_table td.m_title { background:#f9fafa; color:#504f4f; font-weight:400; }
.regiter_table td input.ed { border:1px solid #e0e0e0; outline:none; padding:0px 5px; width:234px; height:29px; }
.orange_star { color:#ff7200; }

.submit_btn { width:173px; height:47px; color:#fff; border:0px; background:#373737; font-size:16px; display:inline-block; cursor:pointer; }
.submit_btn2 { width:173px; height:47px; color:#353535; border:0px; background:#e5e5e5; font-size:16px; display:inline-block; margin-left:10px; cursor:pointer; }

.addr_table td { border-bottom:0px; padding-left:0px; }
</style>

<script>
var member_skin_path = "<?=$member_skin_path?>";
</script>
<script type="text/javascript" src="<?=$member_skin_path?>/ajax_register_form.jquery.js"></script>
<script type="text/javascript" src="<?=$g4[path]?>/js/md5.js"></script>
<script type="text/javascript" src="<?=$g4[path]?>/js/sideview.js"></script>

<form id="fregisterform" name=fregisterform method=post onsubmit="return fregisterform_submit(this);" enctype="multipart/form-data" autocomplete="off">
<input type=hidden name=w                value="<?=$w?>">
<input type=hidden name=url              value="<?=$urlencode?>">
<input type=hidden name=mb_jumin         value="<?=$jumin?>">
<input type=hidden name=mb_id_enabled    value="" id="mb_id_enabled">
<input type=hidden name=mb_nick_enabled  value="" id="mb_nick_enabled">
<input type=hidden name=mb_email_enabled value="" id="mb_email_enabled">
<!-- <input type=hidden name=token value="<?=$token?>"> -->

<input type="hidden" name="mb_is_naver" value="1" />
<input type="hidden" name="access_token" value="<?=$access_token?>" />
<input type="hidden" name="mb_naver_id" value="<?=$w=="" ? $user->id : $member["mb_naver_id"]?>" />

<!-- ANTISPAM -->
<input type=hidden name=bo_table value="register_form"/>


<p style="color:#000000; font-size:20px; padding:65px 0 10px;">정보입력</p>
<p style="color:#848484; font-size:16px; font-weigth:300; padding:0px;">회원님의 개인정보를 안전하게 보호하고 있으며, 회원님의 명백한 동의 없이는 공개 또는 제3자에게 제공되지 않습니다.</p>


<p style="color:#000000; font-size:20px; padding:35px 0 10px;">*필수 정보입력</p>
<table width="100%" cellspacing="0" cellpadding="0" class="regiter_table" >
	<colgroup>
		<col width="150px" />
		<col width="" />
	</colgroup>

    

	<tr bgcolor="#FFFFFF" style="display:none;">
		<td class=m_title><span class="orange_star">* </span>아이디</td>
		<td class=m_padding>
			<input type=text class=ed maxlength=20 type=text size=20 required id='reg_mb_id' name="mb_id" readonly value="<?=$user->id?>@naver" />
			<span style="margin-left:15px;" ><span id='msg_mb_id'> * 영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요.</span></span>
		</td>
	</tr>
	<tr bgcolor="#FFFFFF"  style="display:none;">
		<td class=m_title><span class="orange_star">* </span>패스워드</td>
		<td class=m_padding>
			<INPUT class=ed type=password name="mb_password" size=20 maxlength=20 <?=($w=="")?"required":"";?> itemname="패스워드" value="<?=md5($user->id)?>">
			<span style="margin-left:15px;" >* 영문+숫자가 조합된 문자를 입력해 주세요. * 회원정보 변경 시 사용할 패스워드입니다.</span>
		</td>
	</tr>



	<tr bgcolor="#FFFFFF">
		<td class=m_title><span class="orange_star">* </span>이름</td>
		<td class=m_padding>
			<input type=text class=ed name=mb_name required itemname="이름" value="<?=$user->name?>" <?=$member[mb_name]?"readonly":""?>>
			<?/* if ($w=='') { echo "(공백없이 한글만 입력 가능)"; } */?>
		</td>
	</tr>


	<? if ($w=="") { 

            if($user->birthday){
                $member["mb_birth"] = date("Y")."-".$user->birthday;    

				$birth_year = date("Y", strtotime(date("Y")."-".$user->birthday));
				$birth_month = date("m", strtotime(date("Y")."-".$user->birthday));
				$birth_day = date("d", strtotime(date("Y")."-".$user->birthday));            
            }
        ?>
		<tr bgcolor="#FFFFFF">
			<td class=m_title><span class="orange_star">* </span>생년월일</td>
			<td class=m_padding>
				<?$BirthType = "2";
				if($BirthType == "1"){?>

					<input type=text class="ed calendar" name=mb_birth required itemname="생년월일" value="<?=$member["mb_birth"]?>" autocomplete="off" data-year-range="1900:<?=date("Y")?>" />

				<?}else if($BirthType == "2"){?>
				
					<input type="hidden" id=mb_birth name='mb_birth' value='<?=$member[mb_birth]?>' >

					<select id="bir_year" class="birth_select" style="border:1px solid #bcbcbc; height:31px;  padding:0 px 0 3px; box-sizing:border-box; width:83px;">
						<?for($y=date("Y", $g4['server_time']); $y>=1900; $y--){?>
							<option value="<?=$y?>"><?=$y?>년</option>
						<?}?>
					</select>
					
					<select id="bir_month" class="birth_select" style="border:1px solid #bcbcbc; height:31px; padding:0 px 0 3px; box-sizing:border-box; width:77px;">
						<?for($m=1; $m<=12; $m++){?>
							<option value="<?=sprintf('%02d',$m);?>"><?=sprintf('%02d',$m);?>월</option>
						<?}?>
					</select>
					
					<select id="bir_day" class="birth_select" style="border:1px solid #bcbcbc; height:31px;  padding:0 px 0 3px; box-sizing:border-box; width:77px;">
						<?for($d=1; $d<=31; $d++){?>
							<option value="<?=sprintf('%02d',$d);?>"><?=sprintf('%02d',$d);?>일</option>
						<?}?>
					</select>

					<script>
						$("#bir_month > option[value='<?=$birth_month?>']").prop("selected", true);
						$("#bir_day > option[value='<?=$birth_day?>']").prop("selected", true);
						$(".birth_select").change(function(){
							$("#mb_birth").val( $("#bir_year").val() + "-" + $("#bir_month").val() + "-" + $("#bir_day").val() );
						});
					</script>

				<?}?>
			</td>
		</tr>
	<? } ?>

	
    <? if ($config[cf_use_hp]) { //연락처(휴대전화번호) 사용 시 관리자 환경설정에서 핸드폰 입력에 체크할 것 ?>
	<? 
		$mb_hp = str_replace("-", "",$member[mb_hp]);
		$mb_hp1 = substr($mb_hp, 0, 3);
		$mb_hp2 = substr($mb_hp, 3, 4);
		$mb_hp3 = substr($mb_hp, 7, 4);	
	?>
	<TR bgcolor="#FFFFFF">
		<TD class=m_title>
			<?if($config[cf_req_hp]){?><span class="orange_star">* </span><?}?>
			핸드폰
		</TD>
		<TD class=m_padding>
			<!--휴대폰 입력부 -->
			<select id="hp1" class="hp_input" <?=$config[cf_req_hp]?'required':'';?> style="border:1px solid #bcbcbc; height:31px;  padding:0 px 0 3px; box-sizing:border-box; width:78px;" >
				<option value="" selected="">선택</option>
				<option value="010">010</option>
				<option value="011">011</option>
				<option value="016">016</option>
				<option value="017">017</option>
				<option value="018">018</option>
				<option value="019">019</option>
			</select>
			-
			<input type="text" class="ed hp_input" maxlength=4 id="hp2" style="width:61px;" <?=$config[cf_req_hp]?'required':'';?> value="<?=$mb_hp2?>"> -
			<input type="text" class="ed hp_input" maxlength=4 id="hp3" style="width:61px;" <?=$config[cf_req_hp]?'required':'';?> value="<?=$mb_hp3?>">

			<input class=ed type="hidden" id="mb_hp" name='mb_hp' size=21 maxlength=20 itemname='핸드폰번호' value='<?=$member[mb_hp]?>'>
			
			
			<script>
				$(".hp_input").change(function(){
					$("#mb_hp").val( $("#hp1").val() + "-" + $("#hp2").val() + "-" + $("#hp3").val() );
				});

				$("#hp1 > option[value='<?=$mb_hp1?>']").attr("selected", "selected");
			</script>

			<!--휴대폰 입력부 끝 -->
		</TD>
	</TR>
    <?}?>
	
	<?
	if($w == "") $member["mb_email"] = $user->email;
	?>
	<input type=hidden name='old_email' value='<?=$member[mb_email]?>'>
	<TR bgcolor="#FFFFFF">
		<TD class=m_title><span class="orange_star">* </span>이메일</TD>
		<TD class='m_padding lh'>

		<!--이메일 입력부 -->
			<input class=ed type="hidden" id='reg_mb_email' name='mb_email' size=38 maxlength=100 value='<?=$member[mb_email]?>' onblur="reg_mb_email_check()">
	
		<?$email = explode("@", $member[mb_email]);?>
		<input class=ed name="email1" id="email1" value="<?=$email[0]?>" required itemname="이메일"> @ <input class=ed maxlength=26 size=26 name="email2" id="email2" required itemname="이메일" value="<?=$email[1]?>">

		<select id="email_selector" style="border:1px solid #bcbcbc; height:29px;  padding:0 px 0 3px; box-sizing:border-box; width:120px;">
			<option value="">선택</option>
			<option value="naver.com" >naver.com</option>
			<option value="daum.net">daum.net</option>
			<option value="hanmail.net">hanmail.net</option>
			<option value="yahoo.co.kr">yahoo.co.kr</option>
			<option value="nate.com">nate.com</option>
			<option value="paran.com">paran.com</option>
			<option value="hotmail.com">hotmail.com</option>
			<option value="direct" selected>직접입력</option>
		</select>
		<span style="margin-left:15px;" ><span id='msg_mb_email'><?=$w == "" ? "* 회원가입 완료 후, 정보수정 페이지에서 변경이 가능합니다." : ""?></span></span>

		<script type="text/javascript">
		jQuery(window).ready(function(){
        // 아래 값이 0이면 주소입력칸이 계속 나오고 1이면 주소입력칸 안나옴.
        <?if($w == "u" || $email[1] != ""){?>
            var email2_hide = 0;
            $("#email_selector").val("direct");
        <?} else {?>
            var email2_hide = 1;
        <?}?>


        if(email2_hide == 1)
            jQuery("#email2").hide();

        jQuery("#email_selector").change(function(){
            if(jQuery(this).val() == 'direct'){
                jQuery("#email2").val("").show().focus();
            }else{

                if(email2_hide == 1)
                    jQuery("#email2").val(jQuery(this).val()).hide();
                else
                    jQuery("#email2").val(jQuery(this).val());

            }
        });
        jQuery("#email2, #email1").bind("blur",function(){
            var em = jQuery("#email1").val().split("@");
            var email1 = em[0];
            $("#email1").val(email1);
            if(em.length > 1) {
                    $("#email_selector").val(em[1]);
                    if($("#email_selector").val() == null || $("#email_selector").val() === undefined || $("#email_selector").val() == ""){
                        $("#email_selector").val("direct").change();
                    } else {
                        $("#email_selector").change();
                    }
                    jQuery("#email2").val(em[1]);
                    
            }
            jQuery("#reg_mb_email").val( email1 + "@" + jQuery("#email2").val() ).trigger('blur');
        });
        jQuery("#email_selector").bind("blur",function(){
            jQuery("#email2").trigger("blur");
        });
        });
		</script>

		<!--이메일 입력부 끝 -->
			<? if ($config[cf_use_email_certify]) { ?>
				<? if ($w=='') { echo "<br>e-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다."; } ?>
				<? if ($w=='u') { echo "<br>e-mail 주소를 변경하시면 다시 인증하셔야 합니다."; } ?>
			<? } ?>
		</TD>
	</TR>

	
	<? if ($member[mb_nick_date] <= date("Y-m-d", $g4[server_time] - ($config[cf_nick_modify] * 86400))) { // 별명수정일이 지났다면 수정가능 ?>

	<input type=hidden name=mb_nick_default value='<?=$member[mb_nick]?>'>
	<TR bgcolor="#FFFFFF">
		<TD class=m_title><span class="orange_star">* </span>별명</TD>
		<TD class='m_padding lh'>
			<input class=ed type=text required id='reg_mb_nick' name='mb_nick' maxlength=20 value='<?=$user->nickname?>'
				onblur="reg_mb_nick_check();">
			<span id='msg_mb_nick'></span>
			<br>공백없이 한글,영문,숫자만 입력 가능 (한글2자, 영문4자 이상)
			<br>별명을 바꾸시면 앞으로 <?=(int)$config[cf_nick_modify]?>일 이내에는 변경 할 수 없습니다.
		</TD>
	</TR>

	<? } else { ?>
		<input type=hidden name="mb_nick_default" value='<?=$member[mb_nick]?>'>
		<input type=hidden name="mb_nick" value="<?=$member[mb_nick]?>">
	<? } ?>

	
	<? //성별사용시 /config.php => "use_mb_sex" true로 변경  ?>
	<?if($g4["use_mb_sex"]){?>	
		<? if ($member[mb_sex]) { ?>
			<input type=hidden name=mb_sex value='<?=$member[mb_sex]?>'>
		<? } else { ?>
			<TR bgcolor="#FFFFFF">
				<TD class=m_title><span class="orange_star">* </span>성별</TD>
				<TD class=m_padding>
					<label><input type="radio" id=mb_sex_m name=mb_sex required value='M' itemname='성별' checked> 남자</label>
					<label><input type="radio" id=mb_sex_f name=mb_sex required value='F' itemname='성별'> 여자</label>
					<script type="text/javascript">//document.getElementById('mb_sex').value='<?=$member[mb_sex]?>';</script>
					</td>
			</TR>
		<? } ?>
	<?}?>

	<? if ($config[cf_use_homepage]) { ?>
	<TR bgcolor="#FFFFFF">
		<TD class=m_title>
			<?if($config[cf_req_homepage]){?><span class="orange_star">* </span><?}?>
			홈페이지
		</TD>
		<TD class=m_padding><input class=ed type=text name='mb_homepage' size=38 maxlength=255 <?=$config[cf_req_homepage]?'required':'';?> itemname='홈페이지' value='<?=$member[mb_homepage]?>'></TD>
	</TR>
	<? } ?>

	<? if ($config[cf_use_tel]) { ?>
	<TR bgcolor="#FFFFFF">
		<TD class=m_title>
			<?if($config[cf_req_tel]){?><span class="orange_star">* </span><?}?>
			전화번호
		</TD>
		<TD class=m_padding><input class=ed type=text name='mb_tel' size=21 maxlength=20 <?=$config[cf_req_tel]?'required':'';?> itemname='전화번호' value='<?=$member[mb_tel]?>'></TD>
	</TR>
	<? } ?>
    

    <? if ($config[cf_use_addr]) { //주소 표시 시 관리자 환경설정에서 "주소 입력" 체크 할 것 ?>
	<TR bgcolor="#FFFFFF">
		<TD class=m_title>
			<?if($config[cf_req_addr]){?><span class="orange_star">* </span><?}?>
			주소
		</TD>
		<TD valign="middle" class=m_padding>
			<table width="99%" border="0" cellspacing="0" cellpadding="0" class="addr_table" >
			<tr>
				<td height="25">
					<input class=ed type=text name='mb_zip1' style="width:50px;" maxlength=5 readonly <?=$config[cf_req_addr]?'required':'';?> itemname='우편번호' value='<?=$member[mb_zip1]?>'>
					&nbsp;

                    <a href="javascript:;" onclick="openDaumPostcode('fregisterform', 'mb_zip1', 'mb_addr1', 'mb_addr2');">
                        <span class="btn1" style='font-size:13px;'>우편번호검색</span>
					</a>
				</td>
			</tr>
			<tr>
				<td height="25" colspan="2"  >
					<input class=ed type=text name='mb_addr1' style="width:70%;" readonly <?=$config[cf_req_addr]?'required':'';?> itemname='주소' value='<?=$member[mb_addr1]?>'>
				</td>
			</tr>
			<tr>
				<td height="25" colspan="2">
					<input class=ed type=text name='mb_addr2' style="width:70%;"  itemname='상세주소' value='<?=$member[mb_addr2]?>'>
				</td>
			</tr>
			</table>
		</TD>
	</TR>
    <?}?>





</table>

<p style="color:#000000; font-size:20px; padding:35px 0 10px;">선택 정보입력(알림설정)</p>

<table width="100%" cellspacing="0" cellpadding="0" class="regiter_table" >
	<colgroup>
		<col width="150px" />
		<col width="" />
	</colgroup>


	<? if ($config[cf_use_signature]) { ?>
	<TR bgcolor="#FFFFFF">
		<TD class=m_title>
			<?if($config[cf_req_signature]){?><span class="orange_star">* </span><?}?>
			서명
		</TD>
		<TD class=m_padding><textarea name=mb_signature class=tx rows=3 style='width:95%;' <?=$config[cf_req_signature]?'required':'';?> itemname='서명'><?=$member[mb_signature]?></textarea></TD>
	</TR>
	<? } ?>

	<TR id="reg_profile" bgcolor="#FFFFFF" <? if (!$config[cf_use_profile]) { ?>style="display:none;"<?}?> >
		<TD class=m_title>
			<?if($config[cf_req_profile]){?><span class="orange_star">* </span><?}?>
			자기소개
		</TD>
		<TD class=m_padding><textarea name=mb_profile class=tx rows=3 style='width:95%;' <?=$config[cf_req_profile]?'required':'';?> itemname='자기 소개'><?=$member[mb_profile]?></textarea></TD>
	</TR>

	<? if ($member[mb_level] >= $config[cf_icon_level] && false) { ?>
	<TR bgcolor="#FFFFFF">
		<TD class=m_title>회원아이콘</TD>
		<TD class=m_padding>
			<INPUT class=ed type=file name='mb_icon' size=30 >
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="addr_table" >
				<tr>
					<td class=m_padding3>
						<!--
						* 이미지 크기는 가로(<?=$config[cf_member_icon_width]?>픽셀)x세로(<?=$config[cf_member_icon_height]?>픽셀) 이하로 해주세요.
						<br>&nbsp;&nbsp;(gif만 가능 / 용량:<?=number_format($config[cf_member_icon_size])?>바이트 이하만 등록됩니다.)
						-->

						용량:<?=sprintf("%2.1f", $config[cf_member_icon_size]/1024/1024)?>메가바이트 이하 gif또는 jpg 이미지만 등록됩니다.
						/ 크기: 가로:<?=$config[cf_member_icon_width]?>px, 세로:<?=$config[cf_member_icon_width]?>px 이하 이미지만 등록됩니다.

						<? if ($w == "u" && file_exists($mb_icon)) { ?>
							<br>
							<img src='<?=$mb_icon?>' align=absmiddle style="max-width:300px; height:auto;" >
							<input type=checkbox name='del_mb_icon' value='1'>삭제
						<? } ?>
					</td>
				</tr>
			</table>
		</TD>
	</TR>
	<? } ?>

	<TR bgcolor="#FFFFFF">
		<TD class=m_title>메일링서비스</TD>
		<TD class=m_padding style="color:#504f4f;" ><input type=checkbox name=mb_mailling value='1' <?=($w=='' || $member[mb_mailling])?'checked':'';?>>소식 및 정보를 이메일로 받겠습니다.</TD>
	</TR>
	<TR bgcolor="#FFFFFF">
		<TD class=m_title>SMS 수신여부</TD>
		<TD class=m_padding style="color:#504f4f;" ><input type=checkbox name=mb_sms value='1' <?=($w=='' || $member[mb_sms])?'checked':'';?>>소식 및 정보를 sms로 받겠습니다.</TD>
	</TR>
<!-- 
	<? if ($member[mb_open_date] <= date("Y-m-d", $g4[server_time] - ($config[cf_open_modify] * 86400))) { // 정보공개 수정일이 지났다면 수정가능 ?>
		<input type=hidden name=mb_open_default value='<?=$member[mb_open]?>'>
		<TR bgcolor="#FFFFFF">
			<TD class=m_title>정보공개</TD>
			<TD class=m_padding><input type=checkbox name=mb_open value='1' <?=($w=='' || $member[mb_open])?'checked':'';?>>다른분들이 나의 정보를 볼 수 있도록 합니다.
			<?if((int)$config[cf_open_modify] != 0){?>
				<br>&nbsp;&nbsp;&nbsp;&nbsp; 정보공개를 바꾸시면 앞으로 <?=(int)$config[cf_open_modify]?>일 이내에는 변경이 안됩니다.</td>
			<?}?>
		</TR>
	<? } else { ?>
		<input type=hidden name="mb_open" value="<?=$member[mb_open]?>">
		<TR bgcolor="#FFFFFF">
			<TD class=m_title>정보공개</TD>
			<TD class=m_padding>
				정보공개는 수정후 <?=(int)$config[cf_open_modify]?>일 이내, <?=date("Y년 m월 j일", strtotime("$member[mb_open_date] 00:00:00") + ($config[cf_open_modify] * 86400))?> 까지는 변경이 안됩니다.<br>
				이렇게 하는 이유는 잦은 정보공개 수정으로 인하여 쪽지를 보낸 후 받지 않는 경우를 막기 위해서 입니다.
			</td>
		</tr>
	<? } ?>
 -->

	<input type=hidden name=mb_open value='' >

	<? if ($w == "" && $config[cf_use_recommend]) { ?>
	<TR bgcolor="#FFFFFF">
		<TD class=m_title>추천인아이디</TD>
		<TD class=m_padding><input type=text name=mb_recommend class=ed></TD>
	</TR>
	<? } ?>

</table>

<div style="padding-top:30px; text-align:center;">
	<?if($w=="u"){?>
		<img src="<?=$member_skin_path?>/img/member_leave.png" style="cursor:pointer;float:left;" onclick="member_leave()" />
	<?}?>	

	<input type="button" value="확인" class="submit_btn" onclick="$('#fregisterform').submit()"/>
	<input type="button" value="취소" class="submit_btn2" onclick="check_cancel()" />
</div>


</form>


<div style="height:80px;"></div>



<script type="text/javascript">
function check_cancel(){
	if( confirm("취소하시겠습니까? 입력한 정보는 저장되지 않습니다.") ){
		home();
	}
}

$(function() {
    reg_mb_nick_check();
    // 폼의 첫번째 입력박스에 포커스 주기
    $("#fregisterform :input[type=text]:visible:enabled:first").focus();
});

// submit 최종 폼체크
function fregisterform_submit(f)
{

    /*
    if (f.mb_password_q.value.length < 1) {
        alert('패스워드 분실시 질문을 선택하거나 입력하십시오.');
        f.mb_password_q.focus();
        return false;
    }

    if (f.mb_password_a.value.length < 1) {
        alert('패스워드 분실시 답변을 입력하십시오.');
        f.mb_password_a.focus();
        return false;
    }
    */

    // 이름 검사
    if (f.w.value=='') {
        if (f.mb_name.value.length < 1) {
            alert('이름을 입력하십시오.');
            f.mb_name.focus();
            return false;
        }

        var pattern = /([^가-힣\x20])/i;
        if (pattern.test(f.mb_name.value)) {
            alert('이름은 한글로 입력하십시오.');
            f.mb_name.focus();
            return false;
        }
    }

    // 별명 검사
    if ((f.w.value == "") ||
        (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {

        reg_mb_nick_check();

        if (document.getElementById('mb_nick_enabled').value!='000') {
            alert('별명을 입력하지 않았거나 입력에 오류가 있습니다.');
            document.getElementById('reg_mb_nick').select();
            return false;
        }
    }

    // E-mail 검사
    if ((f.w.value == "") ||
        (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {

        reg_mb_email_check();

        if (document.getElementById('mb_email_enabled').value!='000') {
            alert('E-mail을 입력하지 않았거나 입력에 오류가 있습니다.');
            document.getElementById('reg_mb_email').select();
            return false;
        }


        // 사용할 수 없는 E-mail 도메인
        var domain = prohibit_email_check(f.mb_email.value);
        if (domain) {
            alert("'"+domain+"'은(는) 사용하실 수 없는 메일입니다.");
            document.getElementById('reg_mb_email').focus();
            return false;
        }
    }

    if (typeof(f.mb_birth) != 'undefined') {
        if (f.mb_birth.value.length < 1) {
            alert('생일을 입력하여 주십시오.');
            //f.mb_birth.focus();
            return false;
        }

        var todays = <?=date("Ymd", $g4['server_time']);?>;
        // 오늘날짜에서 생일을 빼고 거기서 140000 을 뺀다.
        // 결과가 0 이상의 양수이면 만 14세가 지난것임
		var birthday = f.mb_birth.value.replace(/-/gi, "");
        var n = todays - parseInt(birthday) - 140000;
        if (n < 0) {

			if(f.mb_profile.value.length < 1){
				alert("만 14세가 지나지 않은 어린이는 정보통신망 이용촉진 및 정보보호 등에 관한 법률\n\n제 31조 1항의 규정에 의하여 법정대리인의 동의를 얻어야 하므로\n\n법정대리인의 이름과 연락처를 '자기소개'란에 별도로 입력하시기 바랍니다.");

				$("#reg_profile").show();
				return false;
			}
        }
    }

    if (typeof(f.mb_sex) != 'undefined') {
        if (f.mb_sex.value == '') {
            alert('성별을 선택하여 주십시오.');
            f.mb_sex.focus();
            return false;
        }
    }

    if (typeof f.mb_icon != 'undefined') {
        if (f.mb_icon.value) {
            if (!f.mb_icon.value.toLowerCase().match(/.(gif|jpg|jpeg)$/i)) {
                alert('회원아이콘이 jpg 또는 gif 파일이 아닙니다.');
                f.mb_icon.focus();
                return false;
            }
        }
    }

    if (typeof(f.mb_recommend) != 'undefined') {
        if (f.mb_id.value == f.mb_recommend.value) {
            alert('본인을 추천할 수 없습니다.');
            f.mb_recommend.focus();
            return false;
        }
    }


    <?
    if ($g4[https_url])
        echo "f.action = '$g4[https_url]/$g4[bbs]/register_form_update.php';";
    else
        echo "f.action = './register_form_update.php';";
    ?>

    // 보안인증관련 코드로 반드시 포함되어야 합니다.
    set_cookie("<?=md5($token)?>", "<?=base64_encode($token)?>", 1, "<?=$g4['cookie_domain']?>");

    return true;
}

// 금지 메일 도메인 검사
function prohibit_email_check(email)
{
    email = email.toLowerCase();

    var prohibit_email = "<?=trim(strtolower(preg_replace("/(\r\n|\r|\n)/", ",", $config[cf_prohibit_email])));?>";
    var s = prohibit_email.split(",");
    var tmp = email.split("@");
    var domain = tmp[tmp.length - 1]; // 메일 도메인만 얻는다

    for (i=0; i<s.length; i++) {
        if (s[i] == domain)
            return domain;
    }
    return "";
}
</script>
