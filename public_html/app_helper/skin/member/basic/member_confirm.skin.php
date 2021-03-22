<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<style>
#pwrap { width:590px;height:184px; margin:74px auto; position:relative; background:url('<?=$member_skin_mpath?>/img/passwrapbg2.jpg') no-repeat center top;}
#passwrap form{padding:0; margin:0;}
#idd{position:absolute; top:55px;left:322px;}
#inputpass{position:absolute; top:85px;left:322px;}
#btnconfirm{position:absolute; top:55px;left:479px;}
input.ed{height:16px;}
</style>

<div id="pwrap">
<form name=fmemberconfirm method=post onsubmit="return fmemberconfirm_submit(this);">
<input type=hidden name=w     value='u'>



	<div id="idd">
		<INPUT type=text name=mb_id maxLength=20 class=ed style="width:140px;background:transparent;border:1px solid #dedede;" readonly value="<?=$member[mb_id]?>" >
	</div>
	<div id="inputpass">
		<INPUT type=password maxLength=20 name=mb_password class=ed style="width:140px;background:transparent;border:1px solid 
#dedede;" itemname="패스워드" required>
	</div>
	<div id="btnconfirm">
		<INPUT name="image" type=image src="<?=$member_skin_mpath?>/img/btn_confirm.gif" id="btn_submit">
	</div>

<!--<INPUT type=password maxLength=20 size=15 name=mb_password itemname="패스워드" required>

<INPUT name="image" type=image src="<?=$member_skin_path?>/img/ok_button.gif" width="65" height="52" border=0 id="btn_submit">-->


</form>
</div>

<script language='Javascript'>
document.onload = document.fmemberconfirm.mb_password.focus();

function fmemberconfirm_submit(f)
{
    document.getElementById("btn_submit").disabled = true;

    f.action = "<?=$url?>";
    return true;
}
</script>
