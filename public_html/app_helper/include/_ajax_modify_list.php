<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

$mb_id = $member[mb_id];
if($mb_id == "") { exit; };



$save_page = get_session("modify_save_page");
$save_sc = get_session("modify_save_sc");

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

$modifyObj = new HpModifyReq();
$result = $modifyObj->get_modify_req_list($pg, $rowCnt, $is_moreview);
$list = $result["list"];

set_session("modify_save_page", "");
set_session("modify_save_sc", "");
?>

<?for ($i=0; $i < count($list); $i++) { 
	$row = $list[$i];
	
	$info = ""; 
	if($i == count($list)-1) {
		$info = " data-listcnt={$result["count"]} ";
		$info .= " data-savepage=\"{$save_page}\" "; //저장페이지 
		$info .= " data-savesc=\"{$save_sc}\" ";//저장 스크롤 위치
    }
    

    $titleWith = "99%";
	if($row["wr_comment"] > 0) $titleWith = "90%";
?>
		

        <li <?=$info?> class="nboxli2" onclick="go_view('<?=$row["wr_id"]?>')">
			<span class="Simg"><img src="<?=$g4["mpath"]?>/images/order<?=$row["wr_7"] ? $row["wr_7"] : "1"?>.png" style="width:100%"/></span>	
			<span class="Tit" style="white-space:nowrap;">
                <span class="ellipsis" style='display:inline-block; max-width:<?=$titleWith?>; float:left;'>
                    <?=$row["wr_subject"]?>
                </span>
                <?if($row["wr_comment"] > 0){?>
                    <span style="color:#ff5f2e;font-size:20px;float:left;display:inline-block; padding-top:1%;">(<?=$row["wr_comment"]?>)</span>
                <?}?>
            </span>
			<span class="Con ellipsis"><?=cut_str(strip_tags($row["wr_content"]), 160)?></span>
			<span class="Date"><?=date("Y-m-d H:i:s", strtotime($row["wr_datetime"]))?></span>
			<span class="Point"><img src="<?=$g4["mpath"]?>/images/listpoint.png" style="width:100%"/></span>
		</li>

<? }?>

<? if($result["count"]==0){?>
	<li data-listcnt=0  class="nboxli2" >
            <span class="Simg"><img src="<?=$g4["mpath"]?>/images/yes_m.png" style="width:100%"/></span>	
			<span class="Tit ellipsis">등록하신 수정의뢰가 없습니다.</span>
            <span class="Con ellipsis">수정의뢰 게시글을 등록해주세요!</span>
	</li>	
<? }?>