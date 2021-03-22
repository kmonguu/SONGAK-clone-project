<div style="width:100%;">
	<form name="f_mobile_charge" method="post" action="<?=$g4[mpath]?>/lgumobile/payreq_crossplatform.php">
	<input type="hidden" name="CST_MID" value="<?=$default[de_dacom_mid]?>">
	<input type="hidden" name="LGD_OID" value="<?=$od[od_id]?>">
	<input type="hidden" name="LGD_BUYEREMAIL" value="<?=$od[od_email]?>">
	<input type="hidden" name="LGD_PRODUCTINFO" value="<?=$goods[name]?>">
	<input type="hidden" name="LGD_AMOUNT" value="<?=$od[od_temp_card]?>">
	<input type="hidden" name="LGD_BUYER" value="<?=$od[od_name]?>">
	<input type="hidden" name="LGD_BUYERPHONE" value="<?=$od[od_hp]?>">
	<input type="hidden" name="LGD_CUSTOM_FIRSTPAY" value="SC0010">
	<!-- 추가 파라미터 -->
	<input type="hidden" name="param_opt_1" value="<?=$od['od_temp_point']?>">
	<input type="hidden" name="param_opt_2" value="<?=$od['on_uid']?>">
	<input type="hidden" name="param_opt_3" value="<?=$member['mb_id']?>">
	<input type="hidden" name="param_opt_4" value="<?=$od['od_b_name']?>">
	</form>
</div>