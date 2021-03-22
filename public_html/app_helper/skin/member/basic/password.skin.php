<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가


include_once($g4[mpath]."/head.php");
?>

<style>

#pass_wrap {width:590px;height:184px;margin:150px auto 100px; position:relative; border:5px solid #dbdbdb}
#passwordinput {float:left; margin-left:10px; height:30px; }
#passwordinput INPUT {border:1px solid #c2c2c2; width:130px; height:20px; vertical-align:middle; }
#bt {float:left; margin-left:10px; padding-top:1px;}
</style>

<div id="pass_wrap">

	<form name="fboardpassword" method=post action="javascript:fboardpassword_submit(document.fboardpassword);">
		<input type=hidden name=w           value="<?=$w?>">
		<input type=hidden name=bo_table    value="<?=$bo_table?>">
		<input type=hidden name=wr_id       value="<?=$wr_id?>">
		<input type=hidden name=comment_id  value="<?=$comment_id?>">
		<input type=hidden name=sfl         value="<?=$sfl?>">
		<input type=hidden name=stx         value="<?=$stx?>">
		<input type=hidden name=page        value="<?=$page?>">

		<div style="width:588px;height:183px;border:1px solid #737373">
			<div style="position:absolute;top:51px;left:25px;font-size:40px;color:#262626">PASSWORD</div>
			<div style="position:absolute;top:110px;left:25px;font-size:25px;color:#262626">비밀번호</div>

			
			<div style="position:absolute; left:265px; top:68px; height:30px;">
				<div style="font-size:20px;color:#262626;float:left; line-height:1.2em;">비밀번호</div>
				
				<div id="passwordinput">
					<INPUT type=password maxLength=20 name="wr_password" itemname="패스워드" required>
				</div>

				<div id="bt">
					<INPUT name="image" type=image src="<?=$member_skin_path?>/img/btn_confirm.jpg" >
				</div>
			</div>

			<div style="position:absolute;top:115px;left:265px;font-size:18px;color:#262626">이 게시물의 패스워드를 입력하십시요!</div>
		</div>

	</form>

</div>

<script language='JavaScript'>
document.fboardpassword.wr_password.focus();

function fboardpassword_submit(f)
{
    f.action = "<?=$action?>";
    f.submit();
}
</script>

