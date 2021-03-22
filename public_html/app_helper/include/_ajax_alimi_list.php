<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

$mb_id = $member[mb_id];
if($mb_id == "") { exit; };




$save_page = get_session("alimi_save_page");
$save_sc = get_session("alimi_save_sc");

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



$bdObj = new HpBoard();
$result = $bdObj->get_list($pg, "","","","", $rowCnt, "", "", $is_moreview);
$list = $result["list"];


set_session("alimi_save_page", "");
set_session("alimi_save_sc", "");
?>

<?for ($i=0; $i < count($list); $i++) { 
	$row = $list[$i];
	
	$info = ""; 
	if($i == count($list)-1) {
		$info = " data-listcnt={$result["count"]} ";
		$info .= " data-savepage=\"{$save_page}\" "; //저장페이지 
		$info .= " data-savesc=\"{$save_sc}\" ";//저장 스크롤 위치
	}

	$isReadCss = "background:#ffffff;";
	if($row["is_read"]) {
		$isReadCss = "background:#deff78;";
	}


	$isDel = "";
	$delTxt = "";
	$isBoard = false;
	$clickevent = "";

	if($row["bo_table"] == "shop_order"){
		//주문알림
		$od = sql_fetch(" SELECT count(*) cnt FROM yc4_order where od_id='{$row["wr_id"]}' ");
		if($od["cnt"] == 0){
			$isDel = true;
			$delTxt = "[삭제됨]";
		}
		$clickevent = "go_view('{$row["wr_id"]}', '{$row["bo_table"]}', ".($isDel ? "true" : "false").")";
	} else {
		$isBoard = true;
		$wrNum = sql_fetch(" SELECT wr_num FROM g4_write_{$row[bo_table]} where wr_id='$row[wr_id]' ");
		$repCnt = sql_fetch(" SELECT count(*) cnt FROM g4_write_{$row[bo_table]} where wr_num='$wrNum[wr_num]' AND wr_is_comment != 1");
		$replyCnt = sql_fetch(" SELECT count(*) cnt FROM g4_write_{$row[bo_table]} where wr_num='$wrNum[wr_num]' AND wr_is_comment = 1");
		if($repCnt[cnt] == 0) {
			$isDel = true;
			$delTxt = "[삭제됨]";
		}
		$clickevent = "go_view('{$row["wr_id"]}', '{$row["bo_table"]}', ".($isDel ? "true" : "false").")";
	}


	$titleWith = "99%";
	if($replyCnt[cnt] > 0) $titleWith = "90%";
?>
		
<li <?=$info?> class="nboxli2" onclick="<?=$clickevent?>" >
	<span class="Simg">
		<?if($isBoard){?>
			<img src="<?=$g4["mpath"]?>/images/<?=$row["is_read"] || $isDel ? "yes" : "no"?>_m.png" style="width:100%"/>
		<?}else{?>
			<div style="width:100%; text-align:center; color:<?=$isDel ? "gray" : "#ff5f2d"?>">
				<i class="fa fa-shopping-bag" aria-hidden="true" style="font-size:65px;"></i>
			</div>
		<?}?>
	</span>	
	<span class="Tit" style="white-space:nowrap;">
		
		<span class="ellipsis" style='display:inline-block; max-width:<?=$titleWith?>; float:left;'>
			<?if($isDel){?><strike style='color:#717171;'><?}?>
			<?=$row["msg_title"]?>
			<?if($isDel){?></strike><?}?>
		</span>
		
		<?if($replyCnt[cnt] > 0){?>
			<span style="color:#ff5f2e;font-size:20px; float:left; display:inline-block; padding-top:1%;">&nbsp;(<?=$replyCnt["cnt"]?>)</span>
		<?}?>

	</span>

	<span class="Con ellipsis"><?=$delTxt?><?=cut_str(strip_tags($row["msg_content"]), 160)?></span>
	<span class="Date"><?=date("Y-m-d H:i:s", strtotime($row["msg_date"]))?></span>
	<?if($repCnt[cnt] > 1){?>
		<span class="Re"><img src="<?=$g4["mpath"]?>/images/re_ico.jpg" style="width:100%"/></span>
	<?}?>
	<span class="Point"><img src="<?=$g4["mpath"]?>/images/listpoint.png" style="width:100%"/></span>
</li>
<div style="float:left;width:100%;"><img src="<?=$g4["mpath"]?>/images/tr_bar.jpg" style="width:100%"/></div>

<? }?>

<? if($result["count"]==0){?>
	<div data-listcnt=0 style="position:relative;float:left;width:94.166%;border:1px solid #d3d3d3;padding:20px 0;margin-top:20px;margin-left:2.777%;background:#ffffff;border-radius:8px;">
		<div style="float:left;margin-left:5.752%;width:71.386%;">
			게시글이 없습니다.
		</div>
	</div>
<? }?>