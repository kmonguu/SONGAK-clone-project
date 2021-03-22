<?
include_once("./_common.php");

$mb_id = $member[mb_id];
if($mb_id == "") { alert("로그인이 필요한 페이지 입니다.","$g4[app_path]/login.php"); exit; };


$allCntRst = sql_fetch(" SELECT count(*) as cnt FROM it9_gcm_msg ");
$allCnt = $allCntRst[cnt];


$rowCnt = 20;	//한번 더보기 시에 표시할 갯수
$start = 0;


$pushList = sql_query(" SELECT * FROM it9_gcm_msg ORDER BY msg_date desc limit $start, $rowCnt");
?>


<ul data-role="listview" id="listview" style='margin-top:-6px;'>
	
    
	<?for($i = 0 ; $row = sql_fetch_array($pushList) ; $i++) { ?>

	<?
		$wrNum = sql_fetch(" SELECT wr_num FROM g4_write_{$row[bo_table]} where wr_id='$row[wr_id]' ");
		$repCnt = sql_fetch(" SELECT count(*) cnt FROM g4_write_{$row[bo_table]} where wr_num='$wrNum[wr_num]' AND wr_is_comment != 1");
		$replyCnt = sql_fetch(" SELECT count(*) cnt FROM g4_write_{$row[bo_table]} where wr_num='$wrNum[wr_num]' AND wr_is_comment = 1");
	?>

	<li >
		<a data-ajax='true' data-transition='none' href="javascript:go_link_page('p=1_2_1_1&wr_id=<?=$row[wr_id]?>&bo_table=<?=$row[bo_table]?>');">
		<?if($repCnt[cnt] == 0 || $repCnt[cnt] > 1 || $replyCnt[cnt] > 0){ //삭제, 답글, 댓글이 달린 게시물은 회색으로 표시?>
			<img src="./images/ico_it9_c.png?1" width="45px" height="45px" style='padding:20px 0 0 25px'>
		<?}else if($repCnt[cnt] == 1){ //답글이 없음?>
			<img src="./images/ico_it9.png?1" width="45px" height="45px" style='padding:20px 0 0 25px'>
		<?}?>
		<h2>
			<?=$row[msg_title]?>
		</h2>
		<div style='color:gray'><?=cut_str($row[msg_content],50)?></div>
		<div style='color:gray;font-size:9pt;text-align:right;padding-top:5px'>- <?=$row[msg_date]?></div>
		</a>
	</li>
	<?}?>
	
	<?if($allCnt > $rowCnt){?>
       <li id="btnMoreView">
		<a href="javascript:moreView()">
		        <div style='color:gray;text-align:center'>이전 내역 보기</div>
		</a>
      </li>
      <?}?>
	

     
    </ul>


<script type="text/javascript">
	$(function(){

	});

	var start = <?=$start?>;
	var rowCnt = <?=$rowCnt?>;
	var allCnt = <?=$allCnt?>;
	
	//이전 내역 보기
	function moreView(){

		loading();
		
		start = start + rowCnt;

		$.ajax({
			url:"<?=$g4[app_path]?>/pages/alimi/_ajax_pushList_more.php?d=" + new Date().getTime(),
			type:"post",
			dataType:"json",
			data:{
				start:start,
				rowCnt:rowCnt
			},
			success:function(result){
					
					var addStr = "";
					
					for(var i = 0 ; i < result.length ; i++) {
						if(i > rowCnt) break; 	
						var data = result[i];

				
						addStr += '<li class="ui-li-has-thumb ui-first-child ui-last-child">';
						addStr += '	<a data-ajax="true" data-transition="none" href="javascript:go_link_page(\'p=1_2_1_1&wr_id='+data['wr_id']+'&bo_table='+data['bo_table']+'\');" class="ui-btn ui-btn-icon-right ui-icon-carat-r">';
						if(data["repCnt"] == 0 || data["repCnt"] > 1 || data["replyCnt"] > 0) 
							addStr += '				<img src="./images/ico_it9_c.png?1" width="45px" height="45px" style="padding:20px 0 0 25px">';
						else if(data["repCnt"] == 1)
							addStr += '				<img src="./images/ico_it9.png?1" width="45px" height="45px" style="padding:20px 0 0 25px">';
							
						addStr += '		<h2>'+data["msg_title"]+'</h2>';
						addStr += '	<div style="color:gray;white-space:normal;">'+data["msg_content"]+'</div>';
						addStr += '	<div style="color:gray;font-size:9pt;text-align:right;padding-top:5px">- '+data["msg_date"]+'</div>';
						addStr += '	</a>';
						addStr += '</li>';



						

					}
					
					
					var divi = "";
					divi += "<li class='ui-li ui-li-static ui-btn-up-c'>"; 
					divi +=		"<div style='color:gray'>&nbsp;</div>";
					divi += "</li>";

					//$("#listview").append(divi);
					$(".ui-page-active #listview").append(addStr);


					if(result.length < rowCnt || start+rowCnt == allCnt){
						$(".ui-page-active #btnMoreView").remove();
					}else{
						$(".ui-page-active #btnMoreView").appendTo($(".ui-page-active #listview"));
					}
					
					closeProgress();

			},
			error:function(x,o,e){
				alert(x + ":" + o + ":" + e);
				closeProgress();
			}

		});

	}

</script>