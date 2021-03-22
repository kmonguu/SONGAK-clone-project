<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

//퀵로그인 여부
$qlgn = false;
if($config["cf_use_naver_id_login"]){ $qlgn = true; }
if($config["cf_use_kakao_id_login"]){ $qlgn = true; }
if($config["cf_use_facebook_id_login"]){ $qlgn = true; }
?>


<style>
.submit_btn { width:173px; height:47px; color:#fff; border:0px; background:#373737; font-size:16px; display:inline-block; cursor:pointer; }
.snslogin { width:100%; text-align:center; margin-top:30px; margin-bottom:40px;}
.snslogin > div { margin-bottom:10px; }
.snslogin a { text-decoration:none; }

input#logbt { width:300px; height:57px; border:none; outline:none; color:#fff; background:#4a4a4a; font-size:20px; }
</style>

<div class="ShopCover" >
	<form name="fregister" method="post" onsubmit="return fregister_submit(this);" autocomplete="off">

		<div style="display:inline-block; width:100%; line-height:40px;" >
			<span style="font-size:22px;font-weight:bold;color:#444444">서비스 이용약관 안내</span>
		</div>
		<div style="display:inline-block; width:100%;">
			<textarea style="width:100%; height:157px; background:#fff; border:1px solid #a9a9a9; box-sizing:border-box;" rows=15 readOnly><?=get_text($config[cf_stipulation])?></textarea>
			<div style="margin-top:10px; text-align:center;">
				<input type="checkbox" name="agree" id="agree11" class="design" value="1"/>
				<label for="agree11" ><span></span>서비스 이용약관 안내를 읽었으며 내용에 동의합니다.</label>
			</div>
		</div>
		<div style="display:inline-block; width:100%; line-height:40px; margin-top:40px;" >
			<span style="font-size:22px;font-weight:bold;color:#444444">개인정보 수집·이용동의</span>
		</div>
		<div style="display:inline-block; width:100%;">
			<textarea style="width:100%; height:157px; background:#fff; border:1px solid #a9a9a9; box-sizing:border-box;" rows=15 readOnly><?=get_text($config[cf_privacy])?></textarea></td>
			<div style="margin:10px auto; text-align:center;">
				<input type="checkbox" name="agree2" id="agree21" class="design" value="1"/>
				<label for="agree21" ><span></span>개인정보 수집·이용동의를 읽었으며 내용에 동의합니다.</label>
			</div>
		</div>

		<div style="width:600px; margin:0 auto; text-align:center; padding:40px 0 0px;" >
			<input type="submit" id="logbt" value="확인" border=0> 
		</div>

		
		<?if($qlgn){?>
			<div class="snslogin login_social" style="margin-bottom:0px;" >
				<?if($config["cf_use_naver_id_login"]){?>
					<div>
						<a href="#login_social" onclick="naver_login()" class="login_naver" >
							<img src="<?=$member_skin_mpath?>/img/login_naver.jpg" />
						</a>
					</div>
				<?}?>
				<?if($config["cf_use_kakao_id_login"]){?>
					<div>
						<a href="#login_social" onclick="loginWithKakao()" class="login_kakao" >
							<img src="<?=$member_skin_mpath?>/img/login_kakao.jpg" />
						</a>
					</div>
				<?}?>
				<?if($config["cf_use_facebook_id_login"]){?>
					<div>
						<a href="#login_social" onclick="facebook_login()" class="login_facebook" >
							<img src="<?=$member_skin_mpath?>/img/login_facebook.jpg" />
						</a>
					</div>
				<?}?>
			</div>
		<?}?>



	</form>



</div>


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

    f.action = "./register_form.php";
    f.submit();
}

if (typeof(document.fregister.mb_name) != "undefined")
    document.fregister.mb_name.focus();
</script>

<?include("{$member_skin_mpath}/login.snslogin.inc.php");?>

