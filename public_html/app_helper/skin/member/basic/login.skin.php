<?
include_once("./_common.php");

$g4[title] = "로그인";
include_once($g4[mpath]."/head.php");

// 이미 로그인 중이라면
if ($member[mb_id])
{
    if ($url)
        goto_url($url);
    else
        goto_url($g4[mpath]);
}

if ($url)
    $urlencode = urlencode($url);
else
    $urlencode = urlencode($_SERVER[REQUEST_URI]);

if ($g4['https_url']) {
    $outlogin_url = $_GET['url'];
    if ($outlogin_url) {
        if (preg_match("/^\.\.\//", $outlogin_url)) {
            $outlogin_url = urlencode($g4[url]."/".preg_replace("/^\.\.\//", "", $outlogin_url));
        }
        else {
            $purl = parse_url($g4[url]);
            if ($purl[path]) {
                $path = urlencode($purl[path]);
                $urlencode = preg_replace("/".$path."/", "", $urlencode);
            }
            $outlogin_url = $g4[url].$urlencode;
        }
    }
    else {
        $outlogin_url = $g4[url];
    }
}
else {
    $outlogin_url = $urlencode;
}
?>

<style>
.reg1 {float:left;width:100%;margin:0;background:#242424;position:relative}
.logintit {width:53.472%;margin:45px auto 0}
.tit {width:53.472%;margin:74px 0 0 5.55%}
.loginimg {width:50%;margin:66px 0 0 25%}
.reg11 {width:87.77%;margin:70px 0 0 6.11%;position:relative}
.reg12	{width:87.77%;margin:10px 0 0 6.11%;position:relative}
.reg1input {position:absolute;top:13px;left:11.216%;width:85%;}
.logbtn1 {position:absolute;top:50px;right:9.162%;width:19.027%;}
.logbtn2 {width:87.77%;float:left;position:relative;margin:33px 0 104px 6.11%}
</style>


<form name="fhead" id="fhead" method="post" onsubmit="return fhead_submit(this);" autocomplete="off" style="margin:0px;">
<input type="hidden" name="url" value="<?=$outlogin_url?>">


<!-- 로그인 -->
<div class="reg1" style="height:auto;">
	<div class="logintit"><img src="/app_helper/images/login/logintit.jpg?3" width="100%"/></div>
	<div class="tit"><img src="/app_helper/images/login/tit.jpg?5" width="100%"/></div>
	<div class="loginimg"><img src="/app_helper/images/login/loginimg.jpg?3" width="100%"/></div>
	<div class="reg11">
		<img src="/app_helper/images/login/idbg.jpg" width="100%"/>
		<div class="reg1input"><input type="text" class="InputID" placeholder="아이디(ID)" name="mb_id"  required="required" tabindex="1"/></div>
	</div>
	<div class="reg12">
		<img src="/app_helper/images/login/pwbg.jpg" width="100%"/>
		<div class="reg1input"><input type="password"  name="mb_password" id="outlogin_mb_password"  class="InputID" placeholder="비밀번호(PASSWORD)" /></div>
	</div>
	<div class="logbtn2"><img src="/app_helper/images/login/loginbtn.jpg" width="100%" onclick="$('#fhead').submit()"/></div>
</div>
<!-- 로그인 -->


</form>

<script type="text/javascript">
function fhead_submit(f)
{
    if (!f.mb_id.value) {
        f.mb_id.focus();
        return false;
    }

    if (!f.mb_password.value) {
        f.mb_password.focus();
        return false;
    }

    f.action = './login_check.php';

    return true;
}
is_main = true;
</script>
<!-- 로그인 전 외부로그인 끝 -->

<?
include_once($g4[mpath]."/tail.php");
?>
