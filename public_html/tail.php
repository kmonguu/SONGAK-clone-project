<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<?if(!defined("__INDEX")){?>
	<?if($bo_table){?>
	</div>
	<?}?>
	</section>
</section>
</div>
<?}?>

<? 
if(file_exists("{$g4[path]}/res/include/sub{$tott}full.php")) {
	include_once("$g4[path]/res/include/sub{$tott}full.php");
}else if(file_exists("{$g4[path]}/res/include/sub{$tot}full.php")) {
	include_once("$g4[path]/res/include/sub{$tot}full.php");
}else if(file_exists("{$g4[path]}/res/include/sub{$pageNum}full.php")) {
	include_once("$g4[path]/res/include/sub{$pageNum}full.php");
}?>

<div class="wrap-footer">
	<footer class="layout">
			<!--하단 영역-->
	<div class="footer_1">
			<div>
				<img src="/res/images/footer/f_logo.png" alt="하단 로고" />
			</div>

			<div class="f_address">
			제주특별자치도 서귀포시<br>
			대정읍 형제해안로 322-1<br>
			(상모리 133-8)
			</div>

			<div>
				<ul id="f_Menu" >
					<?foreach($menu["pageNum"] as $pn=>$pnStr) {
						if($pn == 100) continue;
						?>
						
						<li <?=$pageNum == $pn ? "class='on'" : ""?> >
							<a href="#menulink" onclick="menulink('menu<?=sprintf("%02d", $pn)?>-1')" ><?=$pnStr?>
							</a>
						</li>

					<?}?>
				</ul>
			</div>

			<div class="fixed">
				<img class="top" src="/res/images/sub/top.png" onclick="gotoTop()"/>
				<img class="onair" src="/res/images/sub/onair.png" onmouseover="this.src='/res/images/sub/onair_over.png'" onmouseout="this.src='/res/images/sub/onair.png'" /> 
			</div>

			<div>
			
				<ul id="f_info">
					<li>사업자등록번호 : 251-11-01374</li>
					<li>대표자 : 이연희</li>
					<li>T : 064-792-3112</li>
					<li>M : 010-7124-3111</li>
					<li><a href="javascript:info2()">개인정보처리방침</a></li>
					<li><a href="javascript:adm()">관리자 페이지</a></li>
				</ul>
			</div>
		</div>
	</footer>
	<div class="footer_2">

		<div class="footer_2_1">
			<div class="footer_2_1_1">&copy 2019 <span><?=$g4['title']?></span>. All Rights Reserved</div>
			<div class="footer_2_1_2"><span>Design By</span>&nbsp&nbsp <a href="javascript:it9()"><img src="/res/images/footer/f_it9.png" alt="it9로고" /></div>
		</div>
		
	</div>
</div>

<script>
	function gotoTop(){
		$("html, body").animate({scrollTop:0}, 300);
	}

	var scrollact=false;

	$(function(){
		check_scroll();
		$(window).scroll(function () {
			check_scroll();
		});
	});


	function check_scroll(){

		var scrollTop = $(document).scrollTop();
		//console.log(scrollTop);
        var scrollHeight = $("body").prop("scrollHeight");
		var footerHeight = 37;
        //var footerHeight = $(".wrap-footer").height();

       
        if(scrollHeight - footerHeight < scrollTop + $(window).height()) {
            $(".fixed").css({"position":"absolute", "bottom":(footerHeight+50)+"px"});
        }else{
            $(".fixed").css({"position":"fixed", "bottom":"50px"});
        }
		

		if (scrollTop > 100  && scrollact == false) {
			$(".top").show();
			$(".top").stop().animate({"left" : "0px", "opacity" : "1"});
			
			$(".onair").stop().animate({ "top":"0px" },"easeOutBack");
			
			scrollact = true;
		} 
		
		if (scrollTop < 100) {
			
			$(".top").stop().animate({"left" : "45px", "opacity" : "0"},function(){
				$(".top").hide();
			});
			$(".onair").stop().animate({ "top":"76px" },"easeOutBack");
			scrollact = false;
		}
		
	}
	
</script>

<?
include_once("$g4[path]/tail.sub.php");
?>