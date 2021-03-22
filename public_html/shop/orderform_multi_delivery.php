<?
include_once("./_common.php");

$sw_direct = $_POST["sw_direct"];


// 장바구니가 비어있는가?
if ($sw_direct) {
    $tmp_on_uid = get_session("ss_on_direct");
}
else {
    $tmp_on_uid = get_session("ss_on_uid");
}
$s_on_uid = $tmp_on_uid;


$yc4Obj = new Yc4();
$optObj = new Yc4ItemOption();
$ctlist = $yc4Obj->list_cart($s_on_uid); //장바구니 목록

$cnt = $_POST["cnt"];
?>
<!-- 받으시는 분 (다중 배송) -->
<table width=100% align=center cellpadding=0 cellspacing=10 border=0 class="multi_delivery_tables mdt_<?=$cnt?>">
<colgroup width=140>
<colgroup width=''>
<tr>
    
    <td bgcolor=#FAFAFA class="od_group"  style='padding-left:10px' colspan="2">
		<input type="hidden" class="md_no" name="md_no[]" value="<?=$cnt?>"/>
        <div class="od_group_title">
            <span class="label_black" style="background:white;"> <i class="fas fa-truck"></i>  배송지 <?=$cnt?></span> 받으시는 분
            <label style="font-size:12px;cursor:pointer;" class="checkbox-inline">
                &nbsp;
				<input type=checkbox onclick="javascript:gumae2baesong2(this, document.forderform);" style="margin-top:2px;">
				<b>주문하시는 분과 받으시는 분의 정보가 동일한 경우 체크하세요.</b>
			</label>
        </div>

        <table cellpadding=3>
        <colgroup width=100>
        <colgroup width=''>
        
        <tr>
            <td>이름</td>
            <td><input type=text class="md_b_name ed" name="md_b_name[<?=$cnt?>]" maxlength=20></td>
        </tr>
        <tr style="display:none;">
            <td >전화번호</td>
            <td><input type=text class="md_b_tel ed" name="md_b_tel[<?=$cnt?>]" maxlength=20></td>
        </tr>
        <tr>
            <td>핸드폰</td>
            <td><input type=text class="phonenum md_b_hp" name="md_b_hp[<?=$cnt?>]" class=ed maxlength=20></td>
        </tr>
        <tr>
            <td rowspan=2>주 소</td>
            <td>
            	<div style="float:left;">
	                <input type=text class="md_b_zip1 ed" name="md_b_zip1[<?=$cnt?>]" size=6 maxlength=5 readonly>
            	</div>
                <div style="float:left; margin:0 0 0 5px; padding:3px 0 0 0;">
	                <a href="javascript:;" onclick="openDaumPostcode2(this, 'md_b_zip1', 'md_b_addr1', 'md_b_addr2');">
                        <span class="btn1-o">
                            우편번호확인 
                        </span>
	                </a>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <input type=text class="md_b_addr1 ed" name="md_b_addr1[<?=$cnt?>]" size=35 maxlength=50 readonly>
                <input type=text class="md_b_addr2 ed" name="md_b_addr2[<?=$cnt?>]" size=20 maxlength=50 > (상세주소)
            </td>
        </tr>
        <tr>
            <td>전하실말씀</td>
            <td><input type="text" name="md_memo[<?=$cnt?>]" rows=1 style="width:60%; min-width:500px;" class=ed/></td>
        </tr>

        </table>


		<div class="od_group_title">
			<span class="label_gray" style="background:white;"> <i class="fas fa-truck"></i> 배송지 <?=$cnt?></span> 배송수량선택
        </div>

		<table cellpadding=3>
        <colgroup width='50%'>
        <colgroup width=''>
        <?foreach($ctlist as $ct){
                $it_add_options = print_item_options($ct[it_id], $ct[it_opt1], $ct[it_opt2], $ct[it_opt3], $ct[it_opt4], $ct[it_opt5], $ct[it_opt6]);
                $it_option_str = $optObj->print_option_cart($ct["it_id"], $ct["it_option1"], $ct["it_option2"], $ct["it_option3"], $ct["it_option_amount"]);
			?>
        <tr>
            <td style='padding:8px 2px;'> 
				
				<?if($cnt == 1) {?>
					<input type="hidden" class="tot_qty" data-key="<?=$ct["it_id"]?>_<?=$ct["ct_id"]?>" value="<?=$ct["ct_qty"]?>"/>
				<?}?>
				<input type="hidden" name="md_ct_id[<?=$cnt?>][]" value="<?=$ct["ct_id"]?>"/>
				<input type="hidden" name="md_qty_itname[<?=$cnt?>][]" value="<?=urlencode("<b>".$ct["it_name"]."</b><br/>".$it_option_str." ".$it_add_options)?>"/>
                
              
                    <span style="display:inline-block; min-width:200px;">
                        <span style="font-weight:bold;"><?=$ct["it_name"]?></span><br/><span style='font-color:#9d9d9d;padding-top:3px;'><?=$it_option_str?></span> <?=$it_add_options?>
                    </span>

			</td>
            <td>

                     <select name="md_qty[<?=$cnt?>][]" class="qty_<?=$ct["it_id"]?>_<?=$ct["ct_id"]?>">
                        <?for($qidx = 0 ; $qidx <= $ct["ct_qty"]; $qidx++){?>
                            <option value="<?=$qidx?>"><?=$qidx?>개</option>
                        <?}?>
                    </select>
                    / <?=$ct["ct_qty"]?>개            

            </td>
        </tr>
		<?}?>
		</table>


    </td>
</tr>
</table>


