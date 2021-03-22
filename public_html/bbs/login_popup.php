<?include_once("./_common.php");

    if($member["mb_id"]){
        echo "
            <script>
                custom_confirm('350', '이미 로그인 되어있습니다.<br/><b>로그아웃 하시겠습니까?</b>', function(){location.href='/bbs/logout.php';});
                close_modal_layer();
            </script>
        ";
        exit;
    }
?>
<style type="text/css">
#login_tab { position:absolute; left:48px; top:110px; display:inline-block; }
#login_tab > li { float:left; display:inline-block; height:19px; line-height:19px; padding-left:24px; margin-right:0px; font-size:17px; color:#555; font-weight:300; cursor:pointer; }
#login_tab > li.on {}
html { overflow:hidden; }

.login_area { display:none; width:100%; text-align:center; }
.fanlo_title { display:inline-block; width:100%; height:40px; line-height:40px; text-align:center; font-weight:400; color:#111; font-size:30px; padding:15px 0 70px; }

input.fanlo_input { width:355px; height:40px; border:1px solid #d1d1d1; padding:0 12px; color:#999; font-size:15px; font-weight:300; border-radius:4px; background:#fff; margin:0 auto; box-sizing:border-box; outline:none; }
input.fanlo_submit { width:355px; height:40px; border:1px solid #5ab21d; color:#fff; font-size:18px; font-weight:300; border-radius:4px; background:#5ab21d; margin:0 auto; box-sizing:border-box; cursor:pointer; }
.fanlo_regi { width:355px; height:40px; line-height:40px; color:#fff; font-size:18px; font-weight:300; border-radius:4px; background:#4a4a4a; margin:0 auto; box-sizing:border-box; cursor:pointer; }
.fanlo_find { width:355px; height:40px; line-height:38px; border:1px solid #d1d1d1; color:#222; font-size:18px; font-weight:300; border-radius:4px; background:#fff; margin:0 auto; box-sizing:border-box; cursor:pointer; margin-top:10px; }

.login_social { text-align:center; padding:15px 0px 5px 0px;} 

</style>


<div style="display:inline-block; width:100%; padding:5px; box-sizing:border-box;">
	
    <?if(USE_SHOP) {?>
	<ul id="login_tab" >
		<li class="on" data-no="1" >
            <label class="transparent_radio_wrapper">
                    <input type="radio" class="transparent_radio" id="login_tab_1" name="login_tab" value="1" checked  data-link="disp_login_tab_1" data-onimg="/res/images/radio_on.jpg" data-offimg="/res/images/radio.jpg"/>
                    <span style="font-size:15px;">
                            <img src="/res/images/radio.jpg" id="disp_login_tab_1" style="width:15px; top:2px;"/>
                            회원
                    </span>
            </label>
        </li>
		<li data-no="2" >
             <label class="transparent_radio_wrapper">
                    <input type="radio" class="transparent_radio" id="login_tab_2" name="login_tab" value="2"  data-link="disp_login_tab_2" data-onimg="/res/images/radio_on.jpg" data-offimg="/res/images/radio.jpg"/>
                    <span style="font-size:15px;">
                            <img src="/res/images/radio.jpg" id="disp_login_tab_2" style="width:15px; top:2px;"/>
                            비회원(주문조회)
                    </span>
            </label>
        </li>
    </ul>
    <?}?>

    
    


	<div class="login_area login_area1" style="display:block;" >
		<div id="ConfirmLogin">
			<div class="fanlo_title">로그인</div>
			<form name="Confirm_login" method="post" onsubmit="return f_fanlo_submit(this);" autocomplete="off">
				<input type="hidden" name="url" value='/index.php'>
				
				<div><input type=text maxLength="20" name="mb_id" class="fanlo_input" placeholder="아이디" required ></div>
				<div style="margin:9px 0;" >
					<input type="password" maxLength="20" name="mb_password" class="fanlo_input" placeholder="패스워드" required >
				</div>
				
				<input type="submit" class="fanlo_submit" value="로그인" >
            </form>
            

            
            <?
                $member_skin_path = "{$g4["path"]}/skin/member/shop_member/";
            ?>
            <div class="login_social">
				<?$qlgn = false;?>
				<?if($config["cf_use_naver_id_login"]){ $qlgn=true; ?>
                    <img src="<?=$member_skin_path?>/img/login_naver.jpg" class="login_naver" onclick="naver_login()" />
				<?}?>
				<?if($config["cf_use_kakao_id_login"]){ $qlgn=true;?>
                    <img src="<?=$member_skin_path?>/img/login_kakao.jpg" class="login_kakao" onclick="loginWithKakao()" />
				<?}?>
				<?if($config["cf_use_facebook_id_login"]){ $qlgn=true;?>
                    <img src="<?=$member_skin_path?>/img/login_facebook.jpg" class="login_facebook" onclick="facebook_login()" />
				<?}?>
            </div>



			
			<div style="width:100%; height:0px; border-top:1px dashed #999; margin:30px 0;"></div>

			<div class="fanlo_regi" onclick="window.top.location.href='<?=$g4["path"]?>/bbs/register.php'" >회원가입</div>
			<div class="fanlo_find" onclick="win_password_lost();" >ID / PW 찾기</div>
		</div>
	</div>


	<div class="login_area login_area2" >
		<div id="ConfirmNonId">
			<div class="fanlo_title">비회원 주문조회</div>
			<form name=forderinquiry method=post action="/shop/orderinquiry.php" target="_top" autocomplete="off" style="padding:0px;">
				
				<!-- 자동입력 방지 -->
				<div style="display:none;" id="dummy">
					<input type="text" name="user_id" />
					<input type="password" name="password" />
				</div>

				<div><input type=text maxLength="20" name="od_id" class="fanlo_input" placeholder="주문번호를 입력해주세요" required ></div>
				<div style="margin:9px 0;" >
					<input type="password" maxLength="20" name="od_pwd" class="fanlo_input" placeholder="패스워드를 입력해주세요" required >
				</div>
				
				<input type="submit" class="fanlo_submit" style="background:#4a4a4a; border:1px solid #4a4a4a;" value="주문조회" >

			</form>

			<p style="padding-top:15px; color:#999; font-size:15px; font-weight:300; text-align:left; padding-left:43px;" >
				주문하신 회원님의 성함과 패스워드를 입력해주세요.
			</p>
		</div>
	</div>

</div>

<iframe name="ifrLogin" onload="if(typeof(checklogin) == 'function') checklogin()" style="display:none;"></iframe>


<script type='text/javascript'>


function checklogin(){
	var err = $("iframe[name='ifrLogin']").contents().find("#ifrErr").html();
	if(err === undefined) return;
    if(err == "OK") {
        location.reload();
    } else {
        err = err.split("\\n").join("<br/>");
        custom_alert(350, err);
	}
	close_loading();
}


function f_fanlo_submit(f) {
	<?
	if ($g4[https_url])
		echo "f.action = '$g4[https_url]/$g4[bbs]/login_popup_check.php';";
	else
		echo "f.action = '$g4[bbs_path]/login_popup_check.php';";
    ?>
	f.target = "ifrLogin";
	loading();
	return true;
}

$(function(){
    $("input[type=radio][name='login_tab']").change(function(){
        var no = $(this).val();
        $(".login_area").hide();
		$(".login_area"+no).show();
		$("#login_tab > li").removeClass("on");
	});
	
	setTimeout(function(){ $("input[name='mb_id']").focus(); }, 600);

});
</script>


<?include("{$member_skin_path}/login.snslogin.inc.php");?>


