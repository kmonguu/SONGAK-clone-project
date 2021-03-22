<form name="order_info" id="order_info" method="post" action="./plugin/kcp/settle.php">
<input type="hidden" name="od_id" value="<?=$od_id?>">
<input type="hidden" name="goods" value="<?=str_replace(" ","",$goods)?>">
<input type="hidden" name="settle_amount" value="<?=$settle_amount?>">
<input type="hidden" name="od_name" value="<?=addslashes($od['od_name'])?>">
<input type="hidden" name="od_email" value="<?=$od[od_email]?>">
<input type="hidden" name="od_tel" value="<?=$od[od_tel]?>">
<input type="hidden" name="od_hp" value="<?=$od[od_hp]?>">


<?
switch ($settle_case)
{
    case '계좌이체' :
        $settle_method = "acnt";
        break;
    case '가상계좌' :
        $settle_method = "vcnt";
        break;
    default : // 신용카드
        $settle_method = "card";
        break;
}
?>
<input type="hidden" name="ActionResult" value="<?=$settle_method?>" />




<style>
.cartBtn {background:#2d7dab; color:#ffffff; padding:8px 12px;line-height:23px; border:1px solid #346a89; font-size:22px; font-weight:bold;}
.cartBtn:hover {background:#2d7dab; color:#ffffff; padding:8px 12px;line-height:23px; border:1px solid #346a89; font-size:22px; font-weight:bold;}
</style>
<p align=center class="shop_btns" style="margin-bottom:10px; margin-top:21px;">
   	 <a href='javascript:void(0);' onclick="document.order_info.submit();"><span class='cartBtn'>&nbsp;&nbsp;&nbsp;&nbsp;결제요청&nbsp;&nbsp;&nbsp;&nbsp;</span></a>
</p>
<br/>
<!--
<div style="text-align:center; margin:20px 0;">
	<input type="submit" value="결제요청" style="width:100px; height:30px;">
<div>
-->
</form>