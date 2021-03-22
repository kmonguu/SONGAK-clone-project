<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$call = sql_fetch("SELECT COUNT(*) cnt FROM g4_call_log");
?>

<?if($bo_table){?>
	</div>
<?}?>

<style>

</style>




<div id="right_q">
	<img src="/m/images/bot_quick/ask.png" class="rq_chat"/>
	<img src="/m/images/bot_quick/top.png" class="rq_gotop" onclick="gotoTop()" />
</div>	

<div style="position:fixed; height:70px; width:640px; background:#324541; color:#fff; font-size:26px; font-weight:500; text-align:center; right:0; left:0; bottom:0; margin:0 auto; z-index:999; line-height:70px; ">
	<img src="/m/images/bottom/phone_call.png" style="margin-right:15px;"/>
	064 792 3112 / 010 4125 6464
</div>



<script type="text/javascript">

    $(function(){
		 check_chat();

        $(window).scroll(function () {
            check_chat();
        });
        $(window).resize(function(){
            check_chat();
        });
    });

    function check_chat(){
        var scrollTop = $(document).scrollTop();

        var scrollHeight = $("body").prop("scrollHeight");
        var footerHeight = $("footer.copy").height();

        if(scrollHeight - footerHeight < scrollTop + $(window).height()) {
            $("#right_q").css({"position":"absolute", "bottom":(footerHeight-200)+"px"});
        }else{
            $("#right_q").css({"position":"fixed", "bottom":"70px"});
        }
		if (scrollTop > 200  && scrollact == false) {
			$(".rq_gotop").show();
			$(".rq_gotop").stop().animate({"left" : "0px", "opacity" : "1"});
			
			$(".rq_chat").stop().animate({ "top":"0px" },"easeOutBack");
			
			scrollact = true;
		} 
		
		if (scrollTop < 200) {
			
			$(".rq_gotop").stop().animate({"left" : "45px", "opacity" : "0"},function(){
				$(".rq_gotop").hide();
			});
			$(".rq_chat").stop().animate({ "top":"76px" },"easeOutBack");
			scrollact = false;
		}
    }

</script>

<footer class="copy">
	<ul id="bottom_menu" >
		<?foreach($menu["pageNum"] as $pn=>$pnStr) {?>
			
			<li>
				<a href="#menum" onclick="menum('menu<?=sprintf("%02d", $pn)?>-1')" ><?=$pnStr?></a>
				
			</li>

		<?}?>
	</ul>
	<img src="/m/images/top/ci.png" onclick="home()"/>
	<p>제주특별자치도 서귀포시 대정읍 형제해안로 322-1 (상모리 133-8)<br/>사업자등록번호 : 251-11-01374&nbsp;&nbsp;대표자 김연희<br/>
	T : 064-792-3112&nbsp;&nbsp; M : 010-7124-3111</p>

	<div style="padding-bottom:32px; "><span onclick="info2()">개인정보처리방침</span>&nbsp&nbsp<span onclick="login()">관리자 페이지</span></div>

	<?preg_match("/오늘:(.*),어제:(.*),최대:(.*),전체:(.*)/", $config['cf_visit'], $visit);settype($visit[0], "integer");settype($visit[1], "integer");settype($visit[2], "integer");settype($visit[3], "integer");?>
	<div style="position:relative;width:640px;height:40px;font-size:18px;background:#4f6561;color:#fff;text-align:center;border-top:1px solid #90b8b1;">
		<div style="margin:6px 0 0;display:inline-block;">
			<span style="color:#90b8b1; font-size:20px;">Today</span>
			<span style="font-weight:bold;margin-left:8px;"><?=$visit[1]?></span>
		</div>
		<div style="margin:6px 0 0 30px;display:inline-block;">
			<span style="color:#90b8b1; font-size:20px;">Total</span>
			<span style="font-weight:bold;margin-left:8px;"><?=$visit[4]?></span>
		</div>
	</div>
	<div style="background:#324541; height:60px; color:rgba(255,255,255,.4); font-size:20px; font-weight:300; line-height:60px; border-bottom:1px solid rgba(255,255,255,.3); padding-bottom:65px; box-sizing:border-box;">&copy<?=$g4[title]?>.All Rights Reserved.&nbsp&nbsp&nbsp<img onclick="m_it9()" src="/m/images/bottom/it9.png"/></div>
	

</footer>



</div><!-- #menu_cover_area -->

</div><!-- #wrap -->



<?if($config["cf_kakao_key"]){?>
<script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
<script>
// 사용할 앱의 Javascript 키를 설정해 주세요.
Kakao.init('<?=$config["cf_kakao_key"]?>');
</script>
<?}?>


<!--
<script>
// 카카오톡 링크 버튼을 생성합니다. 처음 한번만 호출하면 됩니다.
Kakao.Link.createTalkLinkButton({
  container: '#kakao-link-btn',
  label: '안녕하세요. <?=$config[cf_title]?>입니다.',
  image: {
    src: 'http://<?=$_SERVER[SERVER_NAME]?>/m/images/kakao_img.jpg',
    width: '300',
    height: '150'
  },
  webButton: {
	text: '<?=$config[cf_title]?>',
	url: 'http://antispam.1937.co.kr/kakaolink.php?link_url=http://<?=$_SERVER[SERVER_NAME]?>/m/' // 앱 설정의 웹 플랫폼에 등록한 도메인의 URL이어야 합니다.
  }
});
</script> -->

<?
include_once($g4[mpath]."/tail.sub.php");
?>
