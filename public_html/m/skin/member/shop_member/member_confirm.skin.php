<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if ($g4['https_url']) {
    $login_url = $_GET['url'];
    if ($login_url) {
        if (preg_match("/^\.\.\//", $url)) {
            $login_url = urlencode($g4[url]."/".preg_replace("/^\.\.\//", "", $login_url));
        }
        else {
            $purl = parse_url($g4[url]);
            if ($purl[path]) {
                $path = urlencode($purl[path]);
                $urlencode = preg_replace("/".$path."/", "", $urlencode);
            }
            $login_url = $g4[url].$urlencode;
        }
    }
    else {
        $login_url = $g4[url];
    }
}
else {
    $login_url = $urlencode;
}
?>

<style type="text/css">
#LogConbox { position:relative; width:100%; background:#fff; box-sizing:border-box; border:6px solid #efefef; padding:70px 0px; text-align:center; }

#LogConbox .idinput { width:100%; height:60px; border-top:1px solid #d5d5d5; border-bottom:1px solid #d5d5d5; }
#LogConbox .idinput > input { width:100%; height:60px; box-sizing:border-box; border:0px; background:url("/img/login_icon_m.jpg") no-repeat 18px center, #fff; padding:0 20px 0 60px; color:#808080; font-size:19px; font-weight:300; outline:none; }

#LogConbox .pwinput { width:100%; height:60px; border-bottom:1px solid #d5d5d5; }
#LogConbox .pwinput > input { width:100%; height:60px; box-sizing:border-box; border:0px; background:url("/img/pw_icon_m.jpg") no-repeat 20px center, #fff; padding:0 20px 0 60px; color:#808080; font-size:19px; font-weight:300; outline:none; }

#LogConbox .login_submit { width:100%; height:57px; color:#fff; border:0px; background:#4a4a4a; font-size:20px; display:inline-block; outline:none; margin-top:20px; font-weight:300; }

</style>
<div class="ShopCover">
	<div style="width:100%; margin:0 auto;" >
		<div id="LogConbox">

			<form name=fmemberconfirm id="fmemberconfirm" method=post onsubmit="return fmemberconfirm_submit(this);">
			<input type=hidden name=w value='u'>

				<div style="display:inline-block; text-align:center; width:100%;" >
					<div>
						<p style="font-weight:bold; color:#f0f0f0; font-size:<?=$url == "member_leave.php" ? "80px" : "120px"?>; line-height:1.1em;" >
							<?if($url == "member_leave.php"){?>
								WITHDRAWAL
							<?}else{?>
								MODIFY
							<?}?>
						</p>
						<p style="font-weight:400; color:#373737; font-size:30px; line-height:1.1em; padding:10px 0 10px 5px;" >
							<?if($url == "member_leave.php"){?>
								회원 탈퇴
							<?}else{?>
								회원 정보수정
							<?}?>
						</p>

						<p style="font-size:20px; color:#777; font-weight:300; line-height:1.5em; padding-top:10px;" >
							<?if($url == "member_leave.php"){?>
								본인확인을 위해 비밀번호를 입력해주시기 바랍니다.
							<?}else{?>
								회원님의 소중한 정보를 보호하기 위해<br/>
								비밀번호를 입력해주시기 바랍니다.
							<?}?>
						</p>

					</div>
				</div>

				<div style="display:inline-block; text-align:center; width:100%;" >
					<div style="width:478px; margin:46px 0 0 56px;">
						<div class="idinput">
							<input type=text class="ed" maxLength="20" name="mb_id" id="mb_id" placeholder="아이디를 입력해주세요" value="<?=$member[mb_id]?>" readonly title="아이디">
						</div>

						<div class="pwinput">
							<input type="password" class="ed" maxLength="20" name="mb_password" id="mb_password" id="login_mb_password" itemname="패스워드" requiredonkeypress="check_capslock(event, 'login_mb_password');" placeholder="비밀번호를 입력해주세요" title="패스워드">
						</div>

						<input type="submit" class="login_submit" value="확 인" >
					</div>
				</div>

			</form>
		</div>


	</div>


	<script language='Javascript'>
	document.onload = document.fmemberconfirm.mb_password.focus();

	function fmemberconfirm_submit(f)
	{
		//document.getElementById("btn_submit").disabled = true;

		f.action = "<?=$url?>";
		return true;
		//f.submit();
	}
	</script>
</div>
