<?
include_once("./_common.php");
define("__INDEX",TRUE);
include_once("./head.php");
?>


<!-- <div style="position:relative;float:left;width:95%; padding:5% 0 0 5%;">
	
	<div style="font-size:1.7em; font-weight:bold;">
		INDEX 
	</div>

	<hr/>
	<a href="<?=$g4["mpath"]?>/pages.php?p=1_1_1_1">1_1</a>
	<br/>
	<br/>
	<a href="<?=$g4["mpath"]?>/pages.php?p=2_1_1_1">1_2</a> -->

<style>
.box1 {width:93.88%;height:352px;background:#fff;border-radius:15px;box-shadow:2px 2px 5px rgba(0,0,0,0.4);position:absolute;top:-97px;left:3.05%}
.box1icon {width:19.44%;position:absolute;top:106px;right:6.66%;z-index:10}
.box1more {width:10.27%;position:absolute;top:270px;right:6.66%;z-index:10}
.boxbar {width:12.22%;height:2px;background:#ff620f;position:absolute;top:66px;left:6.66%}
.box1tit {width:48.05%;font-size:34px;color:#373737;position:absolute;top:97px;left:6.66%;line-height:45px;}
.box1tit1 {font-size:20px;color:#777777;position:absolute;top:215px;left:6.66%;line-height:45px;}
.box1tit2 {font-size:20px;color:#777777;position:absolute;top:270px;left:6.66%;line-height:45px;}

.tit {font-size:32px;color:#242424;margin:46px 0 0 5.55%;}
.box2 {width:93.88%;height:503px;background:#fff;border-radius:15px;box-shadow:2px 2px 5px rgba(0,0,0,0.4);margin:32px 0 0 3.05%}
.box2 ul {list-style:none;margin:0;padding:0}
.box2 ul li {float:left;margin:0;padding:0}
.box2 ul li.box2img1 {width:38.19%;height:218px;float:left;margin:54px 0 0 5.13%}
.box2 ul li.box2img2 {width:38.33%;height:218px;float:left;margin:54px 0 0 13.13%}
.box2bar {width:100%;height:1px;border-top:1px dashed #bfbfbf}
.box2 ul li.box2img3 {width:16.66%;height:96px;float:left;margin:50px 0 0 11.97%}
.box2 ul li.box2img4 {width:16.66%;height:96px;float:left;margin:50px 0 0 13.38%}
.box2 ul li.box2img5 {width:16.66%;height:96px;float:left;margin:50px 0 0 13.38%}

.morebtn {width:11.80%;height:22px;position:absolute;top:8px;right:5.97%}

.box3 {width:93.88%;height:271px;background:#fff;border-radius:15px;box-shadow:2px 2px 5px rgba(0,0,0,0.4);margin:32px 0 0 3.05%;position:relative}
.box3icon {width:19.44%;position:absolute;top:67px;right:4.30%;z-index:10}
.box3icon1 {width:12.77%;position:absolute;top:96px;left:6.66%;z-index:10}
.box3tit {width:50.55%;font-size:30px;color:#2e2e2e;position:absolute;top:73px;left:23.47%;line-height:40px;}
.box3tit1 {font-size:20px;color:#777777;position:absolute;top:178px;left:23.47%;}

.box4 {width:93.88%;height:271px;background:#fff;border-radius:15px;box-shadow:2px 2px 5px rgba(0,0,0,0.4);margin:32px 0 0 3.05%;position:relative;box-sizing:border-box;border-left:15px solid #ff5e06}
.box4icon {width:20.83%;position:absolute;top:69px;right:6.38%;z-index:10}
.box4tit {width:58.30%;font-size:30px;color:#2e2e2e;position:absolute;top:73px;left:6.66%;line-height:40px;}
.box4tit1 {font-size:20px;color:#777777;position:absolute;top:178px;left:6.66%;}

</style>


<?
$bdObj = new HpBoard();
$bdResult = $bdObj->get_list(1, "","","","", 1);
$bd = $bdResult["list"][0];
$bdinfo = $bdObj->get_board($bd["bo_table"]);
$nCnt = $bdObj->get_new_cnt();
?>
<div style="float:left;width:100%;position:relative;background:#0d0d0d;padding:0;margin:0;">
	<div style="float:left;width:100%;">
		<div style="position:relative;float:left;width:100%;"><img src="<?=$g4["mpath"]?>/images/main_top01.jpg" style="width:100%"/>
			<div style="width:60.05%;font-size:36px;color:#ffffff;position:absolute;top:12%;left:5.833%;line-height:42px;">새로운 게시글 알림</div><div style="position:absolute;top:12.5%;left:52%;padding:1%  2%;border-radius:8px;background:#ff5f2e;text-align:center;line-height:29px;color:#ffffff;font-size:26px;font-weight:bold;font-family:'Noto Sans KR';"><?=number_format($nCnt)?></div>

			<?if($bd["msg_no"]){?>

				<div style="width:60.05%;font-size:30px;color:#ffffff;position:absolute;top:40%;left:9.583%;line-height:42px; max-height:82px; overflow:hidden;"  onclick="goAlimiView('<?=$bd["wr_id"]?>', '<?=$bd["bo_table"]?>')">
					<?if($bdinfo["bo_subject"]){?>
						<span style="display:inline-block;width:100%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
							<?=$bdinfo["bo_subject"]?> 게시판에
						</span>
						<br/>게시글이 등록되었습니다.
					<?} else if($bd["bo_table"] == "shop_order") {?>
						새로운 주문이 등록되었습니다.
					<?}?>
				</div>
				<div style="width:60.05%;font-size:25px;color:#777777;position:absolute;top:58%;left:9.583%;line-height:32px; max-height:65px;overflow:hidden;" onclick="goAlimiView('<?=$bd["wr_id"]?>, '<?=$bd["bo_table"]?>')">
					<?=$bd["msg_content"]?>
				</div>
				<div style="width:60.05%;font-size:20px;color:#4d4d4d;position:absolute;top:74%;left:9.583%;line-height:25px;">
					<?=$bd["msg_date"]?>
				</div>
				<div style="position:absolute;top:73%;right:9.722%;width:12.361%;"><a href="javascript:menum('menu02-1');"><img src="<?=$g4["mpath"]?>/images/top_more.jpg" style="width:100%"/></a></div>
			</div>

		<?} else {?>

			<div style="width:60.05%;font-size:30px;color:#ffffff;position:absolute;top:40%;left:9.583%;line-height:42px; max-height:82px; overflow:hidden;">
					홈페이지에<br/>
					등록된 게시글이 없습니다.
			</div>

		<?}?>

	</div>




	<div style="float:left;width:100%;">
		<div style="position:relative;float:left;width:100%;"><img src="<?=$g4["mpath"]?>/images/main_top02.jpg" style="width:100%"/>
			<div style="width:60.05%;font-size:36px;color:#ffffff;position:absolute;top:6%;left:5.833%;line-height:42px;">접속자 분석기</div>
			<div style="width:60.05%;font-size:27px;color:#ffffff;position:absolute;top:20%;left:43.333%;line-height:32px;" class="dial_title_1">TODAY</div>
			<div style="width:60.05%;font-size:22px;color:#ffffff;position:absolute;top:40%;left:20.555%;line-height:32px;" class="dial_max_1">0</div>
			<div style="width:60.05%;font-size:22px;color:#ffffff;position:absolute;top:40%;left:76.944%;line-height:32px;">0</div>


			<div class="divDial" style="position:absolute;top:27%;left:31%;width:38.33%; height:38.33%;">
				<input  type="text" class="dial1" value=0 data-stopper="false" data-skin="tron" data-width="100%" style="background-color:transparent; border:0px; color:#191d20;">
			</div>
		

			<div style="width:60.05%;font-size:20px;color:#cacaca;position:absolute;top:86%;left:12.333%;line-height:32px;" class="dial_title_2"></div>
			<div style="position:absolute;top:67.7%;left:10.944%;width:20.777%; height:20.777%;">
				<input  type="text" class="dial2" value=0 data-stopper="false" data-skin="tron" data-width="100%" style="background-color:transparent; border:0px; color:#191d20;">
			</div>


			<div style="width:60.05%;font-size:20px;color:#cacaca;position:absolute;top:86%;left:41.838%;line-height:32px;" class="dial_title_3"></div>
			<div style="position:absolute;top:67.7%;left:39.8%;width:20.777%; height:20.777%;">
				<input  type="text" class="dial3" value=0 data-stopper="false" data-skin="tron" data-width="100%" style="background-color:transparent; border:0px; color:#191d20;">
			</div>
			
			
			<div style="width:60.05%;font-size:20px;color:#cacaca;position:absolute;top:86%;left:71.005%;line-height:32px;" class="dial_title_4"></div>
			<div style="position:absolute;top:67.7%;left:68.8%;width:20.777%; height:20.777%;">
				<input  type="text" class="dial4" value=0 data-stopper="false" data-skin="tron" data-width="100%" style="background-color:transparent; border:0px; color:#191d20;">
			</div>
			
		</div>
	</div>

	<script>
		$(function() {
			
			$(".divDial").click(function(){
				location.href = g4_app_path + '/pages.php?p=1_1_1_1';
			});

			$.post("<?=$g4["mpath"]?>/include/_ajax_getDayData.php", null, function(data){
				
				for(i = 0; i < 4; i++){
					var title = "";
					if( i == 0) {
						title = "TODAY";
						$(".dial_max_1").html(data["max"]);
					}
					else
						title = data["title"][i];
					
					
					var color = "#fdd905";
					if(i ==0) color = "#d54220";
					$(".dial"+(i+1)).knob({readOnly:true, max:data["max"], min:0, stopper:false, fgColor:color , bgColor:"transparent", thickness:".2", displayPrevious:false, font:'Noto Sans KR'});
					$(".dial"+(i+1)).anim_dial(data["data"][i]);
					$(".dial_title_"+(i+1)).html(title);

					$(".dial"+(i+1)).click(function(){
						location.href = g4_app_path + '/pages.php?p=1_1_1_1';
					});
				}

			}, "json");

		});
	</script>




	<?
	//내 수정의뢰 가져오기
	$mrObj = new HpModifyReq();
	$mr_list = $mrObj->get_modify_req_list(1, 1);
	$mr = $mr_list["list"][0];
	?>	

 	<div style="float:left;width:100%;">
		<div style="position:relative;float:left;width:100%;"><img src="<?=$g4["mpath"]?>/images/main_top03.jpg" style="width:100%"/>
			<div style="width:60.05%;font-size:36px;color:#ffffff;position:absolute;top:14%;left:5.833%;line-height:42px;">나의 수정의뢰</div>
			<div style="position:absolute;top:20%;right:5.972%;width:11.805%;"><a href="javascript:menum('menu03-1')"><img src="<?=$g4["mpath"]?>/images/top_more.jpg" style="width:100%"/></a></div>

			<?if($mr["wr_id"]){?>
			
				<div style="position:absolute;top:55%;left:9.722%;width:12.777%;">
					<a href="#"><img src="<?=$g4["mpath"]?>/images/order<?=$mr["wr_7"] ? $mr["wr_7"] : "1"?>.png" style="width:100%"/></a>
				</div>
				<div style="width:40.05%;font-size:30px;color:#ffffff;position:absolute;top:50%;left:26.527%;line-height:42px; max-height:80px; overflow:hidden;" onclick="goModifyView('<?=$mr["wr_id"]?>')">
					<?=$mr["wr_subject"]?>
				</div>
				<div style="width:50.05%;font-size:20px;color:#4d4d4d;position:absolute;top:77%;left:26.527%;line-height:25px;">
					<?=$mr["wr_datetime"]?>
				</div>

			<?} else {?>

				<div style="width:40.05%;font-size:30px;color:#ffffff;position:absolute;top:50%;left:9.722%;line-height:42px;">
					수정의뢰 게시글이<br/>없습니다.
				</div>
				<div style="width:50.05%;font-size:20px;color:#4d4d4d;position:absolute;top:77%;left:9.722%;line-height:25px;">
					수정의뢰 게시글을 등록해주세요!
				</div>

			<?}?>

		</div>
	</div>




	<?
	//최신 공지사항 가져오기
	$noticeObj = new HpNotice();
	$notice_list = $noticeObj->get_notice_list(1, 1);
	$notice = $notice_list["list"][0];
	?>	

	<div style="float:left;width:100%;">
		<div style="position:relative;float:left;width:100%;">
			<img src="<?=$g4["mpath"]?>/images/main_top04.jpg?2" style="width:100%"/>
			<div style="width:60.05%;font-size:36px;color:#ffffff;position:absolute;top:12%;left:5.833%;line-height:42px;">알려드립니다</div>
			<div style="position:absolute;top:17%;right:5.972%;width:11.805%;">
				<a href="javascript:menum('menu04-1')"><img src="<?=$g4["mpath"]?>/images/top_more.jpg" style="width:100%"/></a>
			</div>
			<?if($notice["wr_id"]){?>
			<div style="width:50.05%;font-size:30px;color:#ffffff;position:absolute;top:45%;left:9.583%;line-height:42px; max-height:80px; overflow:hidden;" onclick="goNoticeView('<?=$notice["wr_id"]?>')">
				<?=$notice["wr_subject"]?>
			</div>
			<div style="width:50.05%;font-size:20px;color:#4d4d4d;position:absolute;top:72%;left:9.583%;line-height:25px;">
				<?=$notice["wr_datetime"]?>
			</div>
			<?} else {?>
				<div style="width:40.05%;font-size:30px;color:#ffffff;position:absolute;top:50%;left:9.722%;line-height:42px;">
					게시글이 없습니다.
				</div>
			<?}?>
		</div>
	</div>
</div>

	


<script>
function goAlimiView(wr_id, bo_table){
	location.href=g4_app_path+'/pages.php?p=2_2_1_1&wr_id='+wr_id+'&bo_table='+bo_table;
}
function goNoticeView(wr_id){
	location.href=g4_app_path+'/pages.php?p=4_2_1_1&wr_id='+wr_id;
}
function goModifyView(wr_id){
	location.href=g4_app_path+'/pages.php?p=3_2_1_1&wr_id='+wr_id;
}


try{
	init_phone_functions.push(function(){
		get_not_read_cnt('<?=$chat_id?>');
	});
}
catch(ex){
	//Don't care
}


is_main = true;
</script>

<?
include_once("./tail.php");
?>
