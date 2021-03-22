<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

$mb_id = $member[mb_id];
if($mb_id == "") { exit; };



$save_page = get_session("notice_save_page");
$save_sc = get_session("notice_save_sc");

if(!$_POST["rowcnt"])
	$rowCnt = 15;
else 
	$rowCnt = $_POST["rowcnt"];


if($save_page == "") { 
	$pg = $_POST["page"];
	$is_moreview = false;
} else {
	$pg = $save_page;
	$is_moreview = true;
}

$noticeObj = new HpNotice();
$result = $noticeObj->get_notice_list($pg, $rowCnt, $is_moreview);
$list = $result["list"];

set_session("notice_save_page", "");
set_session("notice_save_sc", "");
?>

<?for ($i=0; $i < count($list); $i++) { 
	$row = $list[$i];
	
	$info = ""; 
	if($i == count($list)-1) {
		$info = " data-listcnt={$result["count"]} ";
		$info .= " data-savepage=\"{$save_page}\" "; //저장페이지 
		$info .= " data-savesc=\"{$save_sc}\" ";//저장 스크롤 위치
	}
?>
		
<li <?=$info?> class="nboxli" onclick="go_view('<?=$row["wr_id"]?>')" >
	<div class="nboxlidiv1">
		<span class="ellipsis" style="width:95%; display:inline-block;"><?=$row["wr_subject"]?></span><span class="listpoint"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
	</div>
	<div class="nboxlibar"></div>
	<div class="nboxlidiv2" style="overflow:hidden;">
		<span><?=cut_str(strip_tags($row["wr_content"]), 160)?></span><span style="font-size:20px;color:#999999;float:right"><?=date("Y-m-d", strtotime($row["wr_datetime"]))?></span>
	</div>
</li>	

<? }?>

<? if($result["count"]==0){?>
	<li data-listcnt=0  class="nboxli" >
		<div class="nboxlidiv1">
			<span>게시글이 없습니다.</span>
		</div>
	</li>	
<? }?>