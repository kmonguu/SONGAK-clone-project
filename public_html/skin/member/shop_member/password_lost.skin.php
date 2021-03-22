<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>

<style>
    div.tit {font-size:22px; padding:15px 15px 0px 15px; font-weight:bold; font-size:15px;} 
    #fpasswordlost input[type="text"] {padding:10px; }
</style>
<div class="tit">
    <i class="fas fa-search"></i> <?=$g4[title]?>
</div>

<form name="fpasswordlost" id="fpasswordlost" method="post" onsubmit="return fpasswordlost_submit(this);" autocomplete="off">
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr> 
    <td height="30"></td>
</tr>
<tr> 
    <td height="170" align="center" valign="middle" bgcolor="#FFFFFF">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
            <td width="" height="14" >
                <input type="text" name="mb_email" class="ed" required email itemname="이메일주소" style="width:94%;" placeholder="회원가입시 등록하신 이메일 주소를 입력해주세요."/>
                <br />* 회원가입시 등록하신 이메일주소 입력
            </td>
        </tr>

        <tr> 
            <td width="" height="24" >
            </td>
        </tr>


        <tr> 
            <td>
                <div style="float:left; margin:0 15px 0 0;">
                    <img id='kcaptcha_image' />
                </div>
                <input type=text name='wr_key' class="ed" style="width:120px;" required itemname='자동등록방지'>
                <br />왼쪽의 숫자를 입력하세요.
            </td>
        </tr>
        </table>
    </td>
</tr>
<tr> 
    <td height="10"></td>
</tr>
<tr> 
    <td height="40" align="center" valign="bottom">
        
        <a href="javascript:void(0)" onclick="$('#fpasswordlost').submit()"><span class="btnOK"><i class='fa fa-check'></i> 다음</span></a>
        <a href="javascript:window.close();"><span class="btnBack">창닫기</span></a>

    </td>
</tr>
</table>
</form>



<script type="text/javascript" src="<?="$g4[path]/js/jquery.kcaptcha.js"?>"></script>
<script type="text/javascript">
function fpasswordlost_submit(f)
{
    if (!check_kcaptcha(f.wr_key)) {
        return false;
    }

    <?
    if ($g4[https_url])
        echo "f.action = '$g4[https_url]/$g4[bbs]/password_lost2.php';";
    else
        echo "f.action = './password_lost2.php';";
    ?>

    return true;
}

self.focus();
document.fpasswordlost.mb_email.focus();

$(function() {
    var sw = screen.width;
    var sh = screen.height;
    var cw = document.body.clientWidth;
    var ch = document.body.clientHeight;
    var top  = sh / 2 - ch / 2 - 100;
    var left = sw / 2 - cw / 2;
    moveTo(left, top);
});
</script>
