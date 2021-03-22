<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<div style="width:610px; height:551px; margin:50px auto; position:relative;">
	<form name="fregister" id="fregister" method="post" onsubmit="return fregister_submit(this);" autocomplete="off">
		<input type='hidden' name='token_type' value='<?=$token_type?>'/>
		<input type='hidden' name='access_token' value='<?=$access_token?>'/>

		<p style="color:#000000; font-size:25px; font-weight:bold; position:absolute; top:-22px; left:11px;">카카오 아이디로 회원 가입</p>

		<div style="width:582px; position:absolute; top:30px; left:11px;">
			<!-- <img src="<?=$member_skin_mpath?>/img/register_tit1.png" /> --><span style="font-size:22px;font-weight:bold;color:#444444">회원가입약관</span>
			<textarea style="width: 100%; height:157px; font-size:16px; border:7px solid #efefef;" rows=15 readOnly><?=get_text($config[cf_stipulation])?></textarea>
			<div style="margin-top:10px; font-size:17px; ">
				<input type=radio value=1 name=agree id=agree11 >&nbsp;<label for=agree11>회원가입약관을 읽었으며 내용에 동의합니다.</label>
			</div>
		</div>

		<div style="width:582px; position:absolute; top:290px; left:11px;">
			<!-- <img src="<?=$member_skin_mpath?>/img/register_tit2.png" /> --><span style="font-size:22px;font-weight:bold;color:#444444">개인정보처리방침</span>
			<textarea style="width: 100%; height:157px; font-size:16px; border:7px solid #efefef;" rows=15 readOnly><?=get_text($config[cf_privacy])?></textarea></td>
			<div style="margin-top:10px; font-size:17px; ">
				<input type=radio value=1 name=agree2 id=agree21 >&nbsp;<label for=agree21>개인정보처리방침을 읽었으며 내용에 동의합니다.</label>
			</div>
		</div>

		<div style="width:610px; margin:0 auto; text-align:center; padding-top:550px;">
			<span class="btn1 big" onclick="fregister_submit(document.fregister)">&nbsp;&nbsp;&nbsp;회원가입&nbsp;&nbsp;&nbsp;</span>
		</div>

	</form>
</div>
<div style="height:50px; "></div>


<script language="javascript">
function fregister_submit(f)
{
    var agree1 = document.getElementsByName("agree");
    if (!agree1[0].checked) {
        alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
        agree1[0].focus();
        return false;
    }

    var agree2 = document.getElementsByName("agree2");
    if (!agree2[0].checked) {
        alert("개인정보처리방침의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
        agree2[0].focus();
        return false;
    }

    f.action = "./register_kakao_form.php";
    f.submit();
}

if (typeof(document.fregister.mb_name) != "undefined")
    document.fregister.mb_name.focus();
</script>

