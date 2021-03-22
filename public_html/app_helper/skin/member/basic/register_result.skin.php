<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<style>
/*#bg {position:relative; no-repeat; margin:100px auto 100px; width:590px; height:362px; }
#text {position:absolute; top:128px;left:32px; text-align:left;}
#homebt {position:absolute; top:125px;left:524px;}
.size1 {font-size:15px; font-family:sans-serif, Dotum, 돋움;}*/

.texttit1 {font-size:15px;color:#777777;text-align:center;font-family:sans-serif, Dotum, 돋움;letter-spacing:-1px;margin:80px 0 0 0;}
.texttit2 {font-size:26px;color:#444444;text-align:center;font-family:sans-serif, Dotum, 돋움;letter-spacing:-2px;margin:10px 0 30px 0;}
.bg {width:590px;height:240px;position:relative;margin:0 auto 100px;background:#f5f5f4}
.bg1 {width:568px;height:218px;border:1px solid #d9d9d9;background:#fff;position:relative;top:10px;left:10px}
.text {position:absolute;top:10px;left:14px;text-align:left;font-size:13px;font-family:sans-serif, Dotum, 돋움;line-height:28px;}
.size1 {font-size:16px;font-family:sans-serif, Dotum, 돋움;}
.size2 {font-size:15px;font-family:sans-serif, Dotum, 돋움;}
.homebt {position:absolute; top:16px;right:20px;}
</style>
<!-- <div id="bg">
<img src="<?=$member_skin_path?>/img/bg.jpg">
<div id="text">
	<span class="size1"><b><?=$mb[mb_name]?></b></span> 님의 회원가입을 진심으로 축하합니다.<br /><br />
	회원님의 아이디는 <span class="size1"><b><?=$mb[mb_id]?></b></span> 입니다.
</div>
<div id="homebt">
	<a href="<?=$g4[mpath]?>/"><img src="<?=$member_skin_path?>/img/homebt.jpg"border=0></a>
</div>
</div> -->

<div class="texttit1"><b>제주점자도서관에서 좋은시간되세요!</b></div>
<div class="texttit2">제주점자도서관 <span><b>회원가입</b></span>을 축하합니다.</div>

<div class="bg">
	<div class="bg1">
		<div class="text">
			<span class="size1"><b><?=$mb[mb_name]?></b></span> 님의 회원가입을 진심으로 축하합니다.<br />
			회원님의 아이디는 <span class="size1"><b><?=$mb[mb_id]?></b></span> 입니다.<br />
			회원님의 패스워드는 아무도 알 수 없는 암호화 코드로 저장되므로 안심하셔도 좋습니다.<br />
			아이디, 패스워드 분실시에는 회원가입시 입력하신 이메일 주소를 이용하여 찾을 수 있습니다.<br />
			회원탈퇴는 언제든지 가능하며 탈퇴 후 일정기간이 지난 후, <br />회원님의 소중한 정보는 모두 삭제됩니다.<br />
			<span class="size2"><b>제주점자도서관</b></span>을 찾아주셔서 감사합니다!
		</div>
		<div class="homebt">
			<a href="<?=$g4[mpath]?>/"><img src="<?=$member_skin_path?>/img/homebt.jpg"border=0></a>
		</div>
	</div>
</div>

