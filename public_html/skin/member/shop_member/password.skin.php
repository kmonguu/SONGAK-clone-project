<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<style>
#pass_wrap { width:100%; max-width:1919px; min-width:1200px; height:293px; margin:0px auto; position:relative; box-sizing:border-box; border:6px solid #efefef; }
	.pass_word { width:50%; height:281px; float:left; box-sizing:border-box; padding:60px 0 0 107px; }
		.pass_title { font-size:80px; color:#e5e5e5; line-height:1.1em; font-weight:bold; display:block; }
		.pass_info { font-weight:400; color:#373737; font-size:20px; line-height:1.1em; padding:10px 0 10px 5px; display:block; }
		.pass_in { font-size:14px; color:#959494; font-weight:300; line-height:22px; padding-left:5px; display:block; }

#passwordinput {  }
	.pass_area { width:50%; height:281px; float:left; box-sizing:border-box; padding:94px 116px 81px 0; }
		.pass_enter { width:400px; height:52px; float:right; border:1px solid #c2c2c2; border-left:0; border-right:0; background:url("/<?=$member_skin_path?>/img/pw_icon.jpg") no-repeat 20px center, #fff; box-sizing:border-box; padding-left:50px; }
		#passwordinput INPUT { width:100%; height:100%; padding:0; margin:0; border:0; outline:none; font-size:16px; }
		.ent_btn { width:400px; height:47px; background:#4a4a4a; float:right; margin-top:19px; text-align:center; line-height:47px; color:#fff; font-size:17px; cursor:pointer; }
#bt {  }
</style>
<div id="pass_wrap">
<form name="fboardpassword"  id="fboardpassword" method=post action="javascript:fboardpassword_submit(document.fboardpassword);">
<input type=hidden name=w           value="<?=$w?>">
<input type=hidden name=bo_table    value="<?=$bo_table?>">
<input type=hidden name=wr_id       value="<?=$wr_id?>">
<input type=hidden name=comment_id  value="<?=$comment_id?>">
<input type=hidden name=sfl         value="<?=$sfl?>">
<input type=hidden name=stx         value="<?=$stx?>">
<input type=hidden name=page        value="<?=$page?>">



<div id="passwordinput">
	<div class="pass_word">
		<span class="pass_title">PASSWORD</span>
		<span class="pass_info">비밀번호 입력</span>
		<span class="pass_in">회원님의 소중한 정보를 보호하기 위해 비밀번호를 입력해주시기 바랍니다.</span>
	</div>
	<div class="pass_area">
		<div class="pass_enter">
			<INPUT type=password maxLength=20 size=17 name="wr_password" itemname="패스워드" required placeholder="비밀번호를 입력해주세요">
		</div>
		<div class="ent_btn" onclick="$('#fboardpassword').submit();">
			확인
		</div>
	</div>
	
</div>

<div id="bt">
<!-- <INPUT name="image" type=image src="<?=$member_skin_path?>/img/btn_confirm.jpg" > -->
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
