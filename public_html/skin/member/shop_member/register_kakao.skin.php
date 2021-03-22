<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>

<style>
.submit_btn { width:173px; height:47px; color:#fff; border:0px; background:#373737; font-size:16px; display:inline-block; cursor:pointer; }
</style>

<div style="width:100%; margin:70px auto 0px; padding-bottom:80px; font-size:15px;">
	<form name="fregister" method="post" onsubmit="return fregister_submit(this);" autocomplete="off">
		<input type='hidden' name='token_type' value='<?=$token_type?>'/>
		<input type='hidden' name='access_token' value='<?=$access_token?>'/>
		
        <p style="color:#000000; font-size:25px; font-weight:bold; padding:65px 0 60px 0;">카카오 아이디로 회원 가입</p>

		<div style="margin-bottom:10px;">
			<span style="font-size:22px;font-weight:bold;color:#444444">서비스 이용약관 안내</span>
		</div>
		<textarea style="width:100%; border:1px solid #d9d9d9; background:#f7f7f7; padding:20px; outline:none; font-size:15px; height:200px; box-sizing:border-box;" readOnly ><?=get_text($config[cf_stipulation])?></textarea>

		<div style="margin:10px 0; text-align:center;">
			<input type=checkbox value=1 name=agree id=agree11 >&nbsp;
			<label for=agree11 style="color:#000;">서비스 이용약관 안내를 읽었으며 내용에 동의합니다.</label>
		</div>

		<div style="margin:20px 0 10px 0;">
			<span style="font-size:22px;font-weight:bold;color:#444444">개인정보 수집·이용동의</span>
		</div>

		<textarea style="width:100%; border:1px solid #d9d9d9; background:#f7f7f7; padding:20px; outline:none; font-size:15px; height:200px; box-sizing:border-box;" readOnly><?=get_text($config[cf_privacy])?></textarea>

		<div style="margin:10px 0; text-align:center;">
			<input type=checkbox value=1 name=agree2 id=agree21 >&nbsp;
			<label for=agree21 style="color:#000;">개인정보 수집·이용동의를 읽었으며 내용에 동의합니다.</label>
		</div>
		
		<div style="text-align:center; margin-top:30px;">
			<input type=submit value="확인" class="submit_btn" >
		</div>

	</form>
</div>
 

<script language="javascript">
function fregister_submit(f)
{
    var agree1 = document.getElementsByName("agree");
    if (!agree1[0].checked) {
        alert("서비스 이용약관 안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
        agree1[0].focus();
        return false;
    }

    var agree2 = document.getElementsByName("agree2");
    if (!agree2[0].checked) {
        alert("개인정보 수집·이용동의의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
        agree2[0].focus();
        return false;
    }

    f.action = "./register_kakao_form.php";
    f.submit();
}

if (typeof(document.fregister.mb_name) != "undefined")
    document.fregister.mb_name.focus();
</script>

