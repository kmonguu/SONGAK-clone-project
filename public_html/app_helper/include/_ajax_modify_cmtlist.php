<?
include_once("_common.php");
?>
<?
    $mObj = new HpModifyReq();
    $cmtlist = $mObj->get_modify_comment($wr_id);
?>
<?foreach($cmtlist as $cmt) {?>
<div style="float:left;margin-left:5.473%;background:#f5f5f5;padding:15px 3%;color:#222222;font-size:21px;margin-top:35px;width:83%;">
    <div style="float:left;color:#676767;"><?=$cmt["wr_name"]?> <span style="font-size:19px;"><?=$cmt["wr_datetime"]?></span>&nbsp;
        <?if($cmt["wr_10"] == $sitekey) {?>
            <strong style="font-size:19px;" onclick="delete_cmt('<?=$cmt["wr_id"]?>', '<?=$cmt["wr_parent"]?>')">삭제</strong>
        <?}?>
    </div>

    <div style="float:left;margin-top:7px; clear:both;">
        <?=conv_content($cmt["wr_content"], 2);?>
    </div>
</div>
<?}?>