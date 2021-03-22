<?
include_once("$g4[path]/lib/thumb.lib.php"); 

if($stx == ""){

	alert("검색어를 입력해주세요!");

} else {

	$boardlist = sql_query(" SELECT * FROM g4_board WHERE bo_use_search = '1' ORDER BY bo_table ASC ");

	$bdAllList = array();
	$allCnt = 0;
	for($idx = 0 ; $row = sql_fetch_array($boardlist); $idx++){

		$bdObj = new Board($row["bo_table"]);
		$bdResult = $bdObj->get_list(1, $ssf, $stx, "", "", PHP_INT_MAX);
		$allCnt += $bdResult["count"];	
		$bdAllList[$row["bo_table"]] = $bdResult["list"];

	}

?>


<style type="text/css">
.sch_title { padding-left:10px; margin:30px 0 10px; }
.sch_title a { font-size:19px; color:#444; text-decoration:none; }

.sch_table { width:100%; border-top:2px solid #006bc5; color:#313131; }
.sch_table th { font-size:17px; height:40px; font-weight:400; text-align:center; border-left:1px solid #cccccc; border-bottom:1px solid #cccccc; }
.sch_table td { font-size:17px; padding:10px 0;  font-weight:400; text-align:center; border-left:1px solid #cccccc; border-bottom:1px solid #cccccc; }
.sch_table td:nth-child(1) { text-align:left; padding-left:20px; }
.sch_table th:last-child,
.sch_table td:last-child { border-right:1px solid #cccccc; }

.sch_table td a { color:#313131; text-decoration:none; }
</style>

<div style="width:600px; min-height:340px; display:inline-block; padding-bottom:50px; margin-left:20px;">
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
		
		<?if($sbptot == "4_5" || $sbptot == "4_6" || $sbp1 == "5" || $sbp1 == "6" || $sbp1 == "7"){	//일반게시판?>
<!-- 
			<p class="sch_title"><a href="./bbs/board.php?bo_table=<?=$board["bo_table"]?>"><?=$board["bo_subject"]?></a></p>
			<table width="100%" cellpadding="0" cellspacing="0" class="sch_table" style="border-top:2px solid #222; color:#313131;" />
				<tbody>
					<colgroup>
						<col width="" />
						<col width="120px" />
						<col width="100px" />
						<col width="55px" />
					</colgroup>
					<tr>
						<th>제목</th>
						<th>글쓴이</th>
						<th>작성일</th>
						<th>조회</th>
					</tr>

					<? foreach($list as $row) { ?>

						<tr>
							<td><a href="<?=$row["href"]?>"><?=strcut_utf8(strip_tags($row["wr_subject"]), 65)?></a></td>
							<td><?=$row["wr_name"]?></td>
							<td><?=date("Y.m.d",strtotime($row["wr_datetime"]))?></td>
							<td><?=$row["wr_hit"]?></td>
						</tr>
					
					<? } ?>

				</tbody>
			</table>
 -->
		<?}else if($sbptot == "4_2" || $sbptot == "4_3"){	//도서게시판?>
			
			<p class="sch_title"><a href="./bbs/board.php?bo_table=<?=$board["bo_table"]?>"><?=$board["bo_subject"]?></a></p>
			<table width="100%" cellpadding="0" cellspacing="0" class="sch_table" />
				<tbody>
					<colgroup>
						<col width="" />
						<col width="170px" />
						<!-- <col width="150px" /> -->
						<col width="100px" />
					</colgroup>
					<tr>
						<th>도서명</th>
						<th>저자</th>
						<!-- <th>출판사</th> -->
						<th>발행일</th>
					</tr>

					<? foreach($list as $row) { ?>
						<?
						$mhref = str_replace("/bbs/", "/m/bbs/", $row["href"]);
						?>
						<tr>
							<td><a href="<?=$mhref?>"><?=$row["wr_subject"]?></a></td>
							<td><?=$row["wr_2"]?></td>
							<!-- <td><?=$row["wr_3"]?></td> -->
							<td><?=$row["wr_4"]?></td>
						</tr>
					
					<? } ?>

				</tbody>
			</table>
		<?}?>

		<?
	}
}
?>

<?if($allCnt==0){?>
	<?
	if($ssf == "wr_subject")	$nssf = "도서명";
	else if($ssf == "wr_2")		$nssf = "저자";
	else if($ssf == "wr_10")	$nssf = "낭독자";
	else $nssf = "";
	?>
	<p style="height:50px; line-height:50px; text-align:center; margin-top:100px; font-size:25px;">
	입력하신 검색어 "<strong><?=$stx?></strong>"에 대한 <strong><?=$nssf?></strong>검색결과가 없습니다.
	</p>
<?}?>

</div>


<? } ?>