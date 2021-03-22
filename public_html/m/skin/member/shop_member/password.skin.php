<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once($g4[mpath]."/head.sub.php");
?>

<style type="text/css">
#PasswordConbox { position:relative; width:100%; background:#fff; box-sizing:border-box; border:6px solid #efefef; padding:70px 0px; text-align:center; }

#PasswordConbox .pwinput { width:100%; height:60px; border-top:1px solid #d5d5d5; border-bottom:1px solid #d5d5d5; }
#PasswordConbox .pwinput > input { width:100%; height:60px; box-sizing:border-box; border:0px; background:url("/img/pw_icon_m.jpg") no-repeat 20px center, #fff; padding:0 20px 0 60px; color:#808080; font-size:19px; font-weight:300; outline:none; }

#PasswordConbox .pw_submit { width:100%; height:57px; color:#fff; border:0px; background:#4a4a4a; font-size:20px; display:inline-block; outline:none; margin-top:20px; font-weight:300; }

a.history_back { width:160px; height:35px; line-height:35px; border:1px solid #ddd; background:#f1f1f1; text-align:center; color:#222; display:inline-block; margin-top:35px; text-decoration:none; }
</style>


<div style="width:600px; margin:0 auto;" >
	<div id="PasswordConbox">

		<form name="fboardpassword" id="fboardpassword" method=post action="javascript:fboardpassword_submit(document.fboardpassword);" >
			<input type=hidden name=w           value="<?=$w?>">
			<input type=hidden name=bo_table    value="<?=$bo_table?>">
			<input type=hidden name=wr_id       value="<?=$wr_id?>">
			<input type=hidden name=comment_id  value="<?=$comment_id?>">
			<input type=hidden name=sfl         value="<?=$sfl?>">
			<input type=hidden name=stx         value="<?=$stx?>">
			<input type=hidden name=page        value="<?=$page?>">

			<div style="display:inline-block; text-align:center; width:100%;" >
				<div>
					<p style="font-weight:bold; color:#f0f0f0; font-size:80px; line-height:1.1em;" >PASSWORD</p>
					<p style="font-weight:400; color:#373737; font-size:30px; line-height:1.1em; padding:10px 0 10px 5px;" >비밀번호</p>

					<p style="font-size:22px; color:#959494; font-weight:300; line-height:1.1em; padding-top:20px;" >
						이 게시물의 패스워드를 입력하십시요.
					</p>
				</div>
			</div>

			<div style="display:inline-block; text-align:center; width:100%;" >
				<div style="width:478px; margin:46px 0 0 56px;">
					<div class="pwinput">
						<INPUT type="password" class="ed" maxLength=20 name="wr_password" id="wr_password" itemname="패스워드" placeholder="비밀번호를 입력해주세요" >
					</div>

					<input type="submit" class="pw_submit" value="확 인" >
				</div>
			</div>
			<a href="javascript:history.back();" class="history_back" >뒤로가기</a>
		</form>
	</div>


</div>

<script language='JavaScript'>
document.fboardpassword.wr_password.focus();

function fboardpassword_submit(f)
{
	
			
	if($("#wr_password").val() == ""){
		alert("비밀번호를 입력해주세요.");
		return false;
	};

    f.action = "<?=$action?>";
    f.submit();
}
</script>

