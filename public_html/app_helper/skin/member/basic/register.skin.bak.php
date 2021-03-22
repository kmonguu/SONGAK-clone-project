<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<div style="width:590px; height:551px; margin:0 auto; margin-top:50px; background:url('<?=$member_skin_mpath?>/img/rbg.jpg') no-repeat center top; position:relative;">
	<form name="fregister" method="post" onsubmit="return fregister_submit(this);" autocomplete="off">

		<div style="width:562px; position:absolute; top:39px; left:11px;">
			<textarea style="width: 100%; height:157px;" rows=15 readOnly><?=get_text($config[cf_stipulation])?></textarea>
			<div style="margin-top:10px; ">
				<input type=radio value=1 name=agree id=agree11 >&nbsp;<label for=agree11>회원가입약관을 읽었으며 내용에 동의합니다.</label>
			</div>
		</div>

		<div style="width:562px; position:absolute; top:319px; left:11px;">
			<textarea style="width: 100%; height:157px;" rows=15 readOnly><?=get_text($config[cf_privacy])?></textarea></td>
			<div style="margin-top:10px;">
				<input type=radio value=1 name=agree2 id=agree21 >&nbsp;<label for=agree21>개인정보취급방침을 읽었으며 내용에 동의합니다.</label>
			</div>
		</div>

		<div style="width:590px; margin:0 auto; text-align:center; padding-top:550px;">
			<input type=image src="<?=$member_skin_mpath?>/img/join_ok_btn.jpg" border=0>
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
        alert("개인정보취급방침의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
        agree2[0].focus();
        return false;
    }

    f.action = "./register_form.php";
    f.submit();
}

if (typeof(document.fregister.mb_name) != "undefined")
    document.fregister.mb_name.focus();
</script>

