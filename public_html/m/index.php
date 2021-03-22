<?
/*
 * author	: 이양석
 * date		: 2012-02-28
 * desc	    : 모바일사이트
 */
include_once("./_common.php");
include_once("{$g4["path"]}/lib/thumb.lib.php");
define("__INDEX",TRUE);
include_once("./head.php");

?>

<section>

	<?include_once("{$g4["path"]}/m/include/mainvisual.php");?>
	<?include_once("{$g4["path"]}/m/include/m1.php");?>
	<?include_once("{$g4["path"]}/m/include/m2.php");?>
	<?include_once("{$g4["path"]}/m/include/m3.php");?>

</section>




<?//#########################################################################
	// 로그인팝업
	// /bbs/login_popup.php
?>


<style>
.product_box { width:250px; height:90px; box-sizing:border-box; padding:22px 0 0 10px; background:#fff; position:relative; }
.pro_info { width:180px; height:100%; text-align:left; }

.Mainlist { width:100%; height:1011px; text-align:center; background:url('/m/images/main_product_bg.jpg') no-repeat center top; box-sizing:border-box; padding-top:171px; }
.Mainlist ul { display:inline-block; width:540px; }
.Mainlist ul li {position:relative; float:left; width:250px; height:36 5px; margin:0px 0 30px 40px;}
.Mainlist ul li:nth-child(2n+1) { margin-left:0; }
.Mainlist ul li span.Thum { display:inline-block; }
.Mainlist ul li span.Tit { font-size:16px; color:#000; display:block; }
.Mainlist ul li span.Price { font-size:16px; color:#111; display:block; }
.Mainlist ul li span.Line {position:absolute;top:326px;left:0;background:#d9d9d9;width:289px;height:1px;}
.Mainlist ul li span.Btn {position:absolute;top:25px;right:10px;}

.Mainlist2 {float:left;}
.Mainlist2 ul {float:left;margin-bottom:40px;}
.Mainlist2 ul li {position:relative;float:left;width:289px;height:375px;margin:0px 0 0 21px;}
.Mainlist2 ul li div span.Thum {position:absolute;top:0;left:0;}
.Mainlist2 ul li div span.Tit {position:absolute;color:#717171;top:254px;left:0px;font-size:22px;}
.Mainlist2 ul li div span.Price {position:absolute;color:#e70a0a;top:344px;right:127px;font-size:22px;font-weight:bold;}
.Mainlist2 ul li div span.Line {position:absolute;top:326px;left:0;background:#d9d9d9;width:289px;height:1px;}
.Mainlist2 ul li div span.Btn {position:absolute;top:346px;right:0;}
</style>

<!--
<div class="Mainlist">

	<?
		$result2 = sql_query("SELECT * FROM {$g4["yc4_item_table"]} WHERE it_use=1 ");
		display_m_itemlist($result2, "maintype10.inc.php");
	?>

</div>



<div class="Mainlist2">
	
	

</div>





<div style="margin:20px auto; height:350px; padding-left:20px;"> 
 Dual Calendar TEST 
<input type='hidden' name="sdate" id="sdate" value="<?=$sdate?>" />
<input type='hidden' name="edate" id="edate" value="<?=$edate?>" />
<input type="hidden" name="night" id="night" value="" />
<div id="cal_hide_date"></div>
</div>
<script>
//시작 날자
dual_calendar({
	id:"cal_hide_date",
	sdate_id:"sdate",
	edate_id:"edate",
	mode:"dual",
	is_single:false,
	date_sep:"-",
	dup_date:true,
	period_limit:5,
	sdate_change: function(val){
	
	},
	edate_change: function(val){

	},
	night_change:function(){
		
	},
	limit_over: function(val){
		custom_alert(400, "최대 선택 가능 일수는 "+(val)+"일 입니다");
	}
});

</script>

-->



<!--
<div class="main_story">
	<img src="/m/images/gal_left.jpg" class="gal_left" alt="">
	<div class="story_con">
		<?//=latestm("gallery", "1_1_1_1", 30, 75, "");?>
	</div>
	<img src="/m/images/gal_right.jpg" class="gal_right" alt="">
	<div class="story_more" onclick="menum('menu04-1')">
		<span>Read More</span>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		$(".gal_left").click(function(){
			if( !$(".story_con").is(":animated") ){
				$(".story_con").animate({scrollLeft:"-=560"}, 400);
			}
		});
		$(".gal_right").click(function(){
			if( !$(".story_con").is(":animated") ){
				$(".story_con").animate({scrollLeft:"+=560"}, 400);
			}
		});
		var cnt1_3 = $("#la_area4_1_1_1 > .la_con").size();
		var new_width1_3 = parseInt(cnt1_3*550) - 10;
		$("#la_area4_1_1_1").css("width", new_width1_3+"px");

	});
</script>
-->


<?
include_once("./tail.php");
?>
