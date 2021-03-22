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

#LogConbox .idinput { width:100%; height:50px; border-top:1px solid #d5d5d5; border-bottom:1px solid #d5d5d5; }
#LogConbox .idinput > input { width:100%; height:50px; box-sizing:border-box; border:0px; background:url("/<?=$member_skin_path?>/img/login_icon.jpg") no-repeat 18px center, #fff; padding:0 20px 0 50px; color:#808080; font-size:14px; font-weight:300; outline:none; }

#LogConbox .pwinput { width:100%; height:50px; border-bottom:1px solid #d5d5d5; }
#LogConbox .pwinput > input { width:100%; height:50px; box-sizing:border-box; border:0px; background:url("/<?=$member_skin_path?>/img/pw_icon.jpg") no-repeat 20px center, #fff; padding:0 20px 0 50px; color:#808080; font-size:14px; font-weight:300; outline:none; }

#LogConbox .login_submit { width:100%; height:47px; color:#fff; border:0px; background:#4a4a4a; font-size:17px; display:inline-block; cursor:pointer; outline:none; margin-top:20px; font-weight:300; }
</style>
<div class="ShopCover">
	<div style="display:inline-block; width:100%; padding:0 0 20px;">
		<div id="LogConbox">

			<form name=fmemberconfirm id="fmemberconfirm" method=post onsubmit="return fmemberconfirm_submit(this);">
				<input type=hidden name=w     value='u'>

				<div style="display:inline-block; text-align:left;" >
					<div style="float:left;">
						<?
						if($url == "member_leave.php"){
							$font_size = "60";
						}else{
							$font_size = "80";
						}
						?>
						<p style="font-weight:bold; color:#e5e5e5; font-size:<?=$font_size?>px; line-height:1.1em;" >
							<?if($url == "member_leave.php"){?>
								WITHDRAWAL
							<?}else{?>
								MODIFY
							<?}?>
						</p>
						<p style="font-weight:400; color:#373737; font-size:20px; line-height:1.1em; padding:10px 0 10px 5px;" >
							<?if($url == "member_leave.php"){?>
								회원 탈퇴
							<?}else{?>
								회원 정보수정
							<?}?>
						</p>

						<p style="font-size:14px; color:#959494; font-weight:300; line-height:22px; padding-left:5px;" >
							회원님의 소중한 정보를 보호하기 위해<br/>
							비밀번호를 입력해주시기 바랍니다.
						</p>
					</div>

					<div style="float:left; width:400px; margin-left:60px;">
						<div class="idinput">
							<input type=text class="ed" maxLength="20" name="mb_id" id="mb_id" value="<?=$member[mb_id]?>" readonly >
						</div>

						<div class="pwinput">
							<input type="password" class="ed" maxLength="20" name="mb_password" id="mb_password" id="login_mb_password" itemname="패스워드" requiredonkeypress="check_capslock(event, 'login_mb_password');" placeholder="비밀번호를 입력해주세요" >
						</div>

						<input type="submit" class="login_submit" value="확인" >
					</div>
				</div>

			</form>
		</div>

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

