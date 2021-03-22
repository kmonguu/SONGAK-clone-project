<?
include_once("./_common.php");

set_session("notice_save_page", $_GET["save_page"]);
set_session("notice_save_sc", $_GET["save_sc"]);


$nObj = new HpNotice();
$view = $nObj->get_notice_view($_GET["wr_id"]);
?>


<style>
	#divContent p, 
	#divContent div, 
	#divContent span {
		font-size:23px !important;
	}
	#divContent img {
		max-width:100%;
		height:initial !important;
	}
</style>



<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;">공지사항 글보기</div>
<div class="nbox">
	<div style="float:left;width:16.42%;margin-left:3.402%;margin-top:20px;"><a href="javascript:menum('menu04-1')"><img src="/app_helper/images/back_btn.jpg" style="width:100%"/></a></div>
	<div style="float:left;width:85.2%;margin-left:7.396%;margin-top:25px;color:#222222;font-size:26px;"><?=$view["wr_subject"]?></div>
	<div style="position:relative;float:left;width:87.053%;border-bottom:2px solid #97979a;color:#676767;font-size:22px;margin-left:5.473%;margin-top:15px;line-height:50px;padding-left:2%;">
		<?=$view[wr_datetime]?>
	</div>
	<div id="divContent" style="float:left;width:85.2%;margin-left:7.396%;margin-top:25px;color:#222222;font-size:23px;padding-bottom:26px;border-bottom:2px solid #e0e0e1;">
		<?
		$html = 0;
		if (strstr($view[wr_option], "html1"))
			$html = 1;
		else if (strstr($view[wr_option], "html2"))
			$html = 2;
		$view[content] = conv_content($view[wr_content], $html);
		?>
		<?=$view['content']?>
	</div>
</div>








<script>
	$(document).find("img").error(function(){
		var newSrc = "http://it9.co.kr" + $(this).attr("src");
		$(this).attr("src", newSrc);
	});
</script>