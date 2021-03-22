<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>

<style>
.submit_btn { width:173px; height:47px; color:#fff; border:0px; background:#373737; font-size:16px; display:inline-block; cursor:pointer; }
.snslogin { width:100%; text-align:center; margin-top:30px;}
.snslogin > div { display:inline-block; }
</style>

<div class="ShopCover" style="font-size:16px;" >
	<form name="fregister" method="post" onsubmit="return fregister_submit(this);" autocomplete="off">
		
		<div style="margin-bottom:10px;">
			<span style="font-size:22px;font-weight:bold;color:#444444">서비스 이용약관 안내</span>
		</div>
		<textarea style="width: 96%; border:1px solid #d9d9d9; background:#f7f7f7; padding:20px; outline:none; font-size:15px; height:240px;" readOnly><?=get_text($config[cf_stipulation])?></textarea>

		<div style="margin:10px 0; text-align:center;">
			<input type=checkbox value=1 name=agree id=agree11 >&nbsp;
			<label for=agree11>서비스 이용약관 안내를 읽었으며 내용에 동의합니다.</label>
		</div>

		<div style="margin:20px 0 10px 0;">
			<span style="font-size:22px;font-weight:bold;color:#444444">개인정보 수집·이용동의</span>
		</div>

		<textarea style="width: 96%; border:1px solid #d9d9d9; background:#f7f7f7; padding:20px; outline:none; font-size:15px; height:240px;" readOnly><?=get_text($config[cf_privacy])?></textarea>

		<div style="margin:10px 0; text-align:center;">
			<input type=checkbox value=1 name=agree2 id=agree21 >&nbsp;
			<label for=agree21>개인정보 수집·이용동의를 읽었으며 내용에 동의합니다.</label>
		</div>
		
		<div style="text-align:center; margin-top:30px;">
			<input type=submit value="확인" class="submit_btn" >
		</div>

	</form>

	<div class="snslogin login_social">
		<?$qlgn = false;?>
		<?if($config["cf_use_naver_id_login"]){ $qlgn=true; ?>
			&nbsp;
			<a href="#login_social" onclick="naver_login()" class="login_naver" >
				<img src="<?=$member_skin_path?>/img/login_naver.jpg" />
			</a>
			&nbsp;
		<?}?>
		<?if($config["cf_use_kakao_id_login"]){ $qlgn=true;?>
			&nbsp;
			<a href="#login_social" onclick="loginWithKakao()" class="login_kakao" >
				<img src="<?=$member_skin_path?>/img/login_kakao.jpg" />
			</a>
			&nbsp;
		<?}?>
		<?if($config["cf_use_facebook_id_login"]){ $qlgn=true;?>
			&nbsp;
			<a href="#login_social" onclick="facebook_login()" class="login_facebook" >
				<img src="<?=$member_skin_path?>/img/login_facebook.jpg" />
			</a>
			&nbsp;
		<?}?>
	</div>

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

    f.action = "./register_form.php";
    f.submit();
}

if (typeof(document.fregister.mb_name) != "undefined")
    document.fregister.mb_name.focus();
</script>



<?include("{$member_skin_path}/login.snslogin.inc.php");?>
