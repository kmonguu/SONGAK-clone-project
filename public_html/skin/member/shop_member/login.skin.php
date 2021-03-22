<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$tmp_mb_id = $tmp_mb_password = "";
if (isset($is_demo))
{
    $f = @file("$g4[path]/DEMO");
    if (is_array($f))
    {
        $tmp_mb_id = $f[0];
        $tmp_mb_password = $f[1];
    }
}

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

// 아이디 자동저장 
$ck_id_save = get_cookie("ck_id_save"); 

if ($ck_id_save) { 
$ch_id_save_chk = "checked"; 
} 

?>


<style type="text/css">
#LogConbox { position:relative; width:100%; background:#fff; box-sizing:border-box; border:6px solid #efefef; padding:70px 0px; text-align:center; }

#LogConbox .idinput { width:100%; height:50px; border-top:1px solid #d5d5d5; border-bottom:1px solid #d5d5d5; }
#LogConbox .idinput > input { width:100%; height:50px; box-sizing:border-box; border:0px; background:url("/<?=$member_skin_path?>/img/login_icon.jpg") no-repeat 18px center, #fff; padding:0 20px 0 50px; color:#808080; font-size:14px; font-weight:300; outline:none; }

#LogConbox .pwinput { width:100%; height:50px; border-bottom:1px solid #d5d5d5; }
#LogConbox .pwinput > input { width:100%; height:50px; box-sizing:border-box; border:0px; background:url("/<?=$member_skin_path?>/img/pw_icon.jpg") no-repeat 20px center, #fff; padding:0 20px 0 50px; color:#808080; font-size:14px; font-weight:300; outline:none; }

#LogConbox .login_submit { width:100%; height:47px; color:#fff; border:0px; background:#4a4a4a; font-size:17px; display:inline-block; cursor:pointer; outline:none; margin-top:20px; font-weight:300; }

.id_save_area { display:inline-block; width:100%; height:27px; line-height:27px; font-size:14px; color:#808080; font-family:"Dotum"; margin-top:5px; }
	#id_save { margin:-3px 5px 0 0; vertical-align:middle; }
	#secure_connection { display:inline-block; margin-left:17px; padding-right:52px; background:url("<?=$member_skin_path?>/img/on.jpg") no-repeat right top; }


.login_bot_span { position:relative; display:inline-block; padding-left:13px; background:url(../<?=$member_skin_path?>/img/login_dot.jpg) no-repeat left center; font-size:14px; color:#2f2f2f; font-weight:400; }
a.login_bot_btn { position:relative; width:155px; height:31px; line-height:31px; border:1px solid #cecece; text-decoration:none; font-size:13px; color:#676767; margin-left:14px; display:inline-block; }

.login_social { display:inline-block; width:100%; text-align:center; clear:both; margin-top:30px; }
.login_social > a { display:inline-block; }
.login_social > a > img { display:block; }
</style>

<div class="ShopCover">

	<div id="LogConbox">
		<form name="flogin" method="post" onsubmit="return flogin_submit(this);" autocomplete="off">
		<input type="hidden" name="url" value='<?=$login_url?>'>

			<div style="display:inline-block; text-align:left;" >
				<div style="float:left;">
					<p style="font-weight:bold; color:#e5e5e5; font-size:80px; line-height:1.1em;" >LOGIN</p>
					<p style="font-weight:400; color:#373737; font-size:20px; line-height:1.1em; padding:10px 0 10px 5px;" >회원 로그인</p>

					<p style="font-size:14px; color:#959494; font-weight:300; line-height:22px; padding-left:5px;" >
						회원님 아이디와 비밀번호를 입력해주세요.
					</p>
				</div>

				<div style="float:left; width:400px; margin-left:60px;">
					<div class="idinput">
						<input type=text class="ed" maxLength="20" name="mb_id" id="mb_id" minlength="2" value='<?=$ck_id_save?>' placeholder="아이디를 입력해주세요" >
					</div>

					<div class="pwinput">
						<input type="password" class="ed" maxLength="20" name="mb_password" id="mb_password" id="login_mb_password" itemname="패스워드" requiredonkeypress="check_capslock(event, 'login_mb_password');" value="<?=$tmp_mb_password?>" placeholder="비밀번호를 입력해주세요" >
					</div>

					<input type="submit" class="login_submit" value="로그인" >

					<div class="id_save_area">
						<label class="transparent_chkbox_wrapper">
							<input type="checkbox" class="transparent_chkbox" id="id_save_1" name="id_save" value="1" data-link="disp_id_save_1" <?=$ch_id_save_chk?> />
							<span>
								<img id="disp_id_save_1"/>
								아이디 저장
							</span>
						</label>
					</div>
				</div>
			</div>
			

			<?if($config["cf_use_naver_id_login"] || $config["cf_use_kakao_id_login"] || $config["cf_use_facebook_id_login"]){?>
				<div class="login_social">
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
			<?}?>


		</form>
	</div>


				
	<div style="width:100%; height:33px; line-height:33px; margin:30px auto 0; position:relative; text-align:center;">
		<span class="login_bot_span">아직 회원이 아니신가요?</span>
		<a href="./register.php" class="login_bot_btn" >회원가입 하기</a>
		
		<span class="login_bot_span" style="margin-left:30px;">아이디와 비밀번호를 잊으셨나요?</span>
		<a href="javascript:win_password_lost();" class="login_bot_btn" >아이디/비밀번호 찾기</a>
	</div>
	




<?include("{$member_skin_path}/login.snslogin.inc.php");?>




<script type='text/javascript'>
$(function(){
	if( $("#mb_id").val() == "" ){
		document.flogin.mb_id.focus();
	} else {
		document.flogin.mb_password.focus();
	}
});


function flogin_submit(f)
{

	if($("#mb_id").val() == ""){
		alert("아이디를 입력해주세요.");
		return false;
	};
		
	if($("#mb_password").val() == ""){
		alert("비밀번호를 입력해주세요.");
		return false;
	};

	<?
	if ($g4[https_url])
		echo "f.action = '$g4[https_url]/$g4[bbs]/login_check.php';";
	else
		echo "f.action = '$g4[bbs_path]/login_check.php';";
	?>

	return true;
}
</script>




<? // 쇼핑몰 사용시 여기부터 ?>
<? if ($default[de_level_sell] == 1) { // 상품구입 권한 ?>

    <!-- 주문하기, 신청하기 -->
    <? if (preg_match("/orderform.php/", $url)) { ?>


		<style type="text/css">
		#guestbox { position:relative; width:100%; background:#fff; box-sizing:border-box; border:6px solid #efefef; padding:70px 0px; text-align:center; }
		.guest_textarea { overflow:auto; width:480px; height:118px; border:1px solid #efefef; background:#fff; padding:5px; z-index:10; color:#8d8d8d; font-size:13px; font-weight:300; }
		.guest_textarea p, .guest_textarea span { color:#8d8d8d; font-size:13px; font-weight:300; }
		.guest_agree { color:#8d8d8d; font-size:14px; font-weight:300; padding:10px 0 20px; }
		.guestbtn { width:100%; height:47px; color:#fff; border:0px; background:#4a4a4a; font-size:17px; display:inline-block; cursor:pointer; outline:none; margin-top:20px; font-weight:300; }
		</style>

		<div style="display:inline-block; width:100%; padding:60px 0 0px;">
			<div id="guestbox">
				
				<div style="display:inline-block; text-align:left;" >
					<div style="float:left;">
						<p style="font-weight:bold; color:#e5e5e5; font-size:50px; line-height:1.1em; text-align:right;" >NON-MEMBER<br/>ORDER</p>
						<p style="font-weight:400; color:#373737; font-size:20px; line-height:1.1em; padding:10px 0 10px 5px; text-align:right;" >비회원 주문하기</p>
					</div>

					<div style="float:left; width:500px; margin-left:60px;">

						<div class="guest_textarea"><?=$default["de_guest_privacy"]?></div>

						<div class="guest_agree">
							<input type='checkbox' id='agree' value='1'>&nbsp;<label for="agree">개인정보수집에 대한 내용을 읽었으며 이에 동의합니다.</label>
						</div>

						<input type="button" class="guestbtn" onclick="guest_submit(document.flogin);" value="비회원으로 주문" />
					</div>
				</div>

			</div>
		</div>

		<script language="javascript">
		function guest_submit(f)
		{
			if (document.getElementById('agree')) {
				if (!document.getElementById('agree').checked) {
					alert("개인정보수집에 대한 내용을 읽고 이에 동의하셔야 합니다.");
					return;
				}
			}

			//f.url.value = "<?=$g4[shop_path]?>/orderform.php";
			//f.action = "<?=$g4[shop_path]?>/orderform.php";
			f.url.value = "<?=$url?>";
			f.action = "<?=$url?>";
			f.submit();
		}
		</script>


    <? } else if (preg_match("/orderinquiry.php$/", $url)) { ?>


		<style type="text/css">
		#order_check { position:relative; width:100%; background:#fff; box-sizing:border-box; border:6px solid #efefef; padding:70px 0px; text-align:center; }

		#order_check .id_num { width:100%; height:50px; border-top:1px solid #d5d5d5; border-bottom:1px solid #d5d5d5; }
		#order_check .id_num > input { width:100%; height:50px; box-sizing:border-box; border:0px; background:url("/<?=$member_skin_path?>/img/login_mail.jpg") no-repeat 18px center, #fff !important; padding:0 20px 0 50px; color:#808080; font-size:14px; font-weight:300; outline:none; }
		#order_check .passwordinput { width:100%; height:50px; border-bottom:1px solid #d5d5d5; }
		#order_check .passwordinput > input { width:100%; height:50px; box-sizing:border-box; border:0px; background:url("/<?=$member_skin_path?>/img/pw_icon.jpg") no-repeat 20px center, #fff !important; padding:0 20px 0 50px; color:#808080; font-size:14px; font-weight:300; outline:none; }
		#order_check .loginbttonarea { width:100%; height:47px; color:#fff; border:0px; background:#4a4a4a; font-size:17px; display:inline-block; cursor:pointer; outline:none; margin-top:20px; font-weight:300; }

		p.p_dot { line-height:2em; font-size:13px; }
		</style>

		<div style="display:inline-block; width:100%; padding:60px 0 0px;">
			<div id="order_check">

				<form name=forderinquiry method=post action="<?=urldecode($url)?>" autocomplete="off" style="padding:0px;">


					<div style="display:inline-block; text-align:left;" >
						<div style="float:left;">
							<p style="font-weight:bold; color:#e5e5e5; font-size:50px; line-height:1.1em;" >NON-MEMBER<br/>ORDER-CHECK</p>
							<p style="font-weight:400; color:#373737; font-size:20px; line-height:1.1em; padding:10px 0 10px 5px;" >비회원 주문조회</p>

							<p style="font-size:14px; color:#959494; font-weight:300; line-height:22px; padding-left:5px;" >
								회원님의 주문번화와 비밀번호를 입력해주세요.
							</p>
						</div>

						<div style="float:left; width:400px; margin-left:60px;">

							<div class="id_num">
								<!-- 주문번호 -->
								<INPUT type=text class="ed" name="od_id" id="od_id" placeholder="주문번호를 입력해주세요" required >
							</div>

							<div class="passwordinput">
								<!-- 비밀번호 -->
								<INPUT type="password" class="ed" name="od_pwd" id="od_pwd" itemname="패스워드" placeholder="비밀번호를 입력해주세요" required >
							</div>

							<input type="submit" class="loginbttonarea" value="주문조회" >

							<p class="p_dot" style="padding-top:10px;" >ㆍ메일로 발송한 주문서에 있는 주문번호를 입력하세요!</p>
							<p class="p_dot" >ㆍ주문서 작성 시 입력한 패스워드를 입력하세요!</p>
						</div>
					</div>


				</form>
			</div>

		</div>


    <? } ?>

<? } ?>
<? // 쇼핑몰 사용시 여기까지 반드시 복사해 넣으세요 ?>


</div>