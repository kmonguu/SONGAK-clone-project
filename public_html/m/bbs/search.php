<?
include_once("./_common.php");

//if (!$stx) alert("검색어가 없습니다.");
$pageNum = "100";
$subNum = "20";

$g4[title] = "검색 : " . $stx;
include_once("./_head.php");
include_once("$g4[path]/lib/thumb.lib.php"); 
?>


<style type="text/css">
.sch_title { height:49px; line-height:49px; color:#000000; font-size:13px; font-weight:400; margin:0px 0 30px; border-bottom:1px solid #c2c2c2; }
.sch_title a { font-size:20px; color:#000000; text-decoration:none; }

.sch_basic { width:100%; display:inline-block; height:75px; margin-bottom:22px; }
.sch_basic p { font-size:14px; font-weight:300; line-height:22px;  overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.sch_basic p.sch_subj a { color:#048bd6; }
.sch_basic p.sch_another { font-size:12px; color:#939393; }
.sch_basic p.sch_content { color:#505050; }
</style>


<div style="width:100%; display:inline-block; min-height:400px; padding-top:40px; padding-bottom:100px;">


<?
$tmpPath = $g4["bbs_path"];
$g4["bbs_path"] = $g4["mbbs_path"];

if($stx){
	
	$boardlist = sql_query(" SELECT * FROM g4_board WHERE bo_use_search = '1' ORDER BY bo_table ASC ");

	$bdAllList = array();
	for($idx = 0 ; $row = sql_fetch_array($boardlist); $idx++){

		$bdObj = new Board($row["bo_table"]);
		$bdResult = $bdObj->get_list(1, $sfl, $stx, "", "", PHP_INT_MAX, " AND wr_reply = '' ");
		$allCnt += $bdResult["count"];	
		$bdAllList[$row["bo_table"]] = $bdResult["list"];

	}
	
	$bo_max_cnt = 10;

?>


<?
foreach($bdAllList as $key=>$list){
	if(count($list)>0){
		$bdObj2 = new Board($key);
		$board = $bdObj2->get_board();

		/*$allCnt //총 검색된 게시글 수*/

		if($board["bo_table"]){ //게시판일때
			$sbp=explode("_",$board["bo_table"]);
			$sbp1=$sbp[0];
			$sbp2=$sbp[1];
			$sbp3=$sbp[2];
			$sbp4=$sbp[3];

			$sbptot = $sbp1."_".$sbp2;
		}
?>
		

			<p class="sch_title">
				<a href="<?=$g4["mbbs_path"]?>/board.php?bo_table=<?=$board["bo_table"]?>"><?=$board["bo_subject"]?></a>
				&nbsp;&nbsp;총 <font style="color:#008bd6;"><?=count($list)?></font>건
			</p>


			<? 
			$rcnt = 0;
			foreach($list as $row) {
				$rcnt++;

				if($rcnt > $bo_max_cnt){
					
					echo "<a href=\"{$g4["bbs_path"]}/board.php?bo_table={$board['bo_table']}&stx={$stx}\" ><span class='btn1-o' style='margin-bottom:30px;'>{$board["bo_subject"]} 게시글 더보기 <i class=\"fas fa-external-link-alt\"></i></span></a>";

					break;
				}
			?>
				
				<div class="sch_basic">
					<?if ($row[file][0][file]){

						// 이미지 체크
						$image = urlencode($row[file][0][file]);
							$ori="$g4[path]/data/file/$bo_table/" . $image;
							$ext = strtolower(substr(strrchr($ori,"."), 1)); //확장자

						// 이미지가 있다면.
						if ($ext=="gif"||$ext=="jpg"||$ext=="jpeg"||$ext=="png"||$ext=="bmp"||$ext=="tif"||$ext=="tiff") {

						// 섬네일 경로 만들기 + 섬네일 생성
							$list_img_path = $row[file][0][path]."/".$row[file][0][file];
							$list_thumb = thumbnail($list_img_path ,100, 65,0,2,100);


							echo "<div style='float:left; width:110px; margin-right:10px;' ><a onfocus='this.blur()' href=";
							echo $row[href];
							echo " onfocus='this.blur()'>";
							// echo $list_img_path;
							//echo $row[file][0][path];
							echo "<img src='$list_thumb'  style='width:100px; height:65px; padding:2px; border:1px solid #aaa;' />";
							echo "</a></div>";
						}
					?>
						
						<div style="float:left; width:60%;">
							<p class="sch_subj"><a href="<?=$row["href"]?>"><?=strip_tags($row["wr_subject"])?></a><?=$row[icon_secret]?></p>
							<p class="sch_another">
								<?=$row["wr_name"]?>
								<span style="display:inline-block; margin:0 5px; font-size:9px;">│</span>
								조회 <?=number_format($row["wr_hit"])?>회
								<span style="display:inline-block; margin:0 5px; font-size:9px;">│</span>
								<?=date("Y.m.d H:i",strtotime($row["wr_datetime"]))?>
							</p>
							<p class="sch_content">
								<?if (strstr($row[wr_option], "secret")){?>
									비밀글입니다.
								<?}else{?>
									<?=strip_tags($row["wr_content"])?>
								<?}?>
							</p>
						</div>

					<? } else { ?>

						<p class="sch_subj"><a href="<?=$row["href"]?>"><?=strip_tags($row["wr_subject"])?></a><?=$row[icon_secret]?></p>
						<p class="sch_another">
							<?=$row["wr_name"]?>
							<span style="display:inline-block; margin:0 5px; font-size:9px;">│</span>
							조회 <?=number_format($row["wr_hit"])?>회
							<span style="display:inline-block; margin:0 5px; font-size:9px;">│</span>
							<?=date("Y.m.d H:i",strtotime($row["wr_datetime"]))?>
						</p>
						<p class="sch_content">
							<?if (strstr($row[wr_option], "secret")){?>
								비밀글입니다.
							<?}else{?>
								<?=strip_tags($row["wr_content"])?>
							<?}?>
						</p>

					<?}?>
				</div>
			
			<? } ?>

		<?
	}
}
?>

<?if($allCnt==0){?>
	<p style="height:50px; line-height:50px; text-align:center; margin-top:100px; font-size:25px;">
	입력하신 검색어 "<strong><?=$stx?></strong>"에 대한 검색결과가 없습니다.
	</p>
<?}?>


<? } ?>


</div>


<?
$g4["bbs_path"] = $tmpPath;

include_once("./_tail.php");
?>
