<?php
	if(is_dir($g4[shop_mpath]."/plugin/dacom_xpay/log")){
		chmod($g4[shop_mpath]."/plugin/dacom_xpay/log",0777);
	}else{
		mkdir($g4[shop_mpath]."/plugin/dacom_xpay/log",0777, true);
		chmod($g4[shop_mpath]."/plugin/dacom_xpay/log",0777);
	}
?>
<form method="post" id="LGD_PAYINFO" action="<?=$g4[shop_mpath]?>/plugin/dacom_xpay/payreq_crossplatform.php">
<input type="hidden" name="LGD_BUYER" value="<?=addslashes($od['od_name'])?>"/>
<input type="hidden" name="LGD_PRODUCTINFO" value="<?=str_replace(" ","",$goods)?>"/>
<input type="hidden" name="LGD_AMOUNT" value="<?=$settle_amount?>"/>
<input type="hidden" name="LGD_BUYEREMAIL" value="<?=$od[od_email]?>"/>
<input type="hidden" name="LGD_BUYERPHONE" value="<?=$od[od_hp]?>"/>
<input type="hidden" name="LGD_OID" value="<?=$od_id?>"/>
<input type="hidden" name="LGD_CUSTOM_FIRSTPAY" value="SC0010"/>
<div style="text-align:center; margin:20px 0;">
	<input type="submit" value="결제요청" style="width:100px; height:30px;">
<div>
</form>