<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

/*
    $s_page 는 cart.php 일때 수량의 수정, 물품의 삭제를 위한 변수이다.
               orderinquiryview.php 일때 배송상태등을 나타내는 변수이다.

    $s_on_uid 는 유일한 키인데 orderupdate.php 에서 ck_on_uid 를 죽이면서
    ck_tmp_on_uid 에 복사본을 넣어준다. ck_tmp_on_uid 는 orderconfirm.php 에서만 사용한다.
*/

if ($s_page == 'cart.php' || $s_page == 'orderinquiryview.php')
    $colspan = 5;
else
    $colspan = 4;
?>
<style type="text/css">
.cartsub_top td { font-size:18px; }
.cartsubtext { font-size:14px; }
</style>

<form name=frmcartlist method=post style="padding:0px;" autocomplete="off" >
<table width=98% cellpadding=0 cellspacing=0 align=center class="cartsub_top" style="border-top:2px solid #2d2d2d;">
<colgroup width=70>
<colgroup width=''>
<colgroup width=80>
<colgroup width=115>
<? if ($s_page == 'cart.php' || $s_page == 'orderinquiryview.php') echo '<colgroup width=60>'; ?>
<tr><td colspan='<?=$colspan?>' height=2 class=c1></td></tr>
<tr align=center height=43 class=c2 bgcolor="#efefef">
    <td colspan=2>상품명</td>
    <td>수량</td>
    <td>판매가<?if($config["cf_use_point"]){?><br/>(적립금)<?}?></td>
<?
if ($s_page == 'cart.php')
    echo '<td>삭제</td>';
else if ($s_page == 'orderinquiryview.php')
    echo '<td>상태</td>';
?>
</tr>
<tr><td colspan='<?=$colspan?>' height=1 class=c1></td></tr>
<?
$is_send_free = false; //배송비 무료상품이 끼어있는지 체크
$is_send_free2_cnt = 0; //단독주문시 배송비 무료상품

$tot_point = 0;
$tot_sell_amount = 0;
$tot_cancel_amount = 0;

$goods = $goods_it_id = "";
$goods_count = -1;

$total_qty = 0; //총 상품 수량 //멀티 배송지 용

// $s_on_uid 로 현재 장바구니 자료 쿼리
$sql = " select a.ct_id,
                a.it_opt1,
                a.it_opt2,
                a.it_opt3,
                a.it_opt4,
                a.it_opt5,
                a.it_opt6,
                a.ct_amount,
                a.ct_point,
                a.ct_qty,
                a.ct_status,
                b.it_id,
                b.it_name,
                b.ca_id,
                b.ca_id2,
                b.ca_id3,
                a.it_option1,
                a.it_option2,
                a.it_option3,
                a.it_option_amount,
                b.it_free_send
           from $g4[yc4_cart_table] a,
                $g4[yc4_item_table] b
          where a.on_uid = '$s_on_uid'
            and a.it_id  = b.it_id
          order by a.ct_id ";
$result = sql_query($sql);

$optObj = new Yc4ItemOption();
for ($i=0; $row=mysql_fetch_array($result); $i++)
{
    //무료배송상품이면
	if($row["it_free_send"] == "1"){
		$is_send_free = true;
    } else if($row["it_free_send"] == "2") {
        $is_send_free2_cnt++;
    }
    
    if (!$goods)
    {
        //$goods = addslashes($row[it_name]);
        //$goods = get_text($row[it_name]);
        $goods = preg_replace("/\'|\"|\||\,|\&|\;/", "", $row[it_name]);
        $goods_it_id = $row[it_id];
    }
    $goods_count++;

    if ($i==0) { // 계속쇼핑
		if($row[ca_id2]){
			$continue_ca_id = $row[ca_id2];
		} else {
			$continue_ca_id = $row[ca_id];
		}
    }

    if ($s_page == "cart.php" || $s_page == "orderinquiryview.php") { // 링크를 붙이고
        $a1 = "<a href='./item.php?it_id=$row[it_id]'>";
        $a2 = "</a>";
        $image = mget_it_image($row[it_id]."_s", 50, 50, $row[it_id]);
    } else { // 붙이지 않고
        $a1 = "";
        $a2 = "";
        $image = mget_it_image($row[it_id]."_s", 50, 50);
    }

    $it_name = $a1 . stripslashes($row[it_name]) . $a2 . "<br>";
    $it_add_options = print_item_options($row[it_id], $row[it_opt1], $row[it_opt2], $row[it_opt3], $row[it_opt4], $row[it_opt5], $row[it_opt6]);

    $it_option_str = "";
    $it_option_str = $optObj->print_option_cart($row["it_id"], $row["it_option1"], $row["it_option2"], $row["it_option3"], $row["it_option_amount"]);

    $point       = $row[ct_point] * $row[ct_qty];
    $sell_amount = $row[ct_amount] * $row[ct_qty];

    $total_qty += $row["ct_qty"];
    
    if ($i > 0)
        echo "<tr><td colspan='$colspan' height=1 bgcolor=#E7E9E9></td></tr>";

    echo "<tr>";
    echo "<td align=left style='padding:5px;'>$image</td><td style='padding:10px;'>";
    echo "<input type=hidden name='ct_id[$i]'    value='$row[ct_id]'>";
    echo "<input type=hidden name='it_id[$i]'    value='$row[it_id]'>";
    echo "<input type=hidden name='ap_id[$i]'    value='$row[ap_id]'>";
    echo "<input type=hidden name='bi_id[$i]'    value='$row[bi_id]'>";
    echo "<input type=hidden name='it_name[$i]'  value='".get_text($row[it_name])."'>";
    echo "<span style='font-size:18px; display:inline-block; padding-top:0px;'>{$it_name}</span>";	
    if($it_option_str != "") {
		echo "<div style='padding:4px 0px 0px 0px; color:#7d7d7d; font-size:16px;'>".$it_option_str."</div>";
    }
    if($it_add_options)
        echo $it_add_options;

    if($s_page == "cart.php") { //장바구니 옵션/수량 변경 버튼
        echo "<span class='btn1-o' style='display:block; width:100px; text-align:center; font-size:16px; padding:3px 9px; margin-top:8px;' onclick='open_fixed_layer(\"{$g4["shop_mpath"]}/item_popup.php?it_id={$row[it_id]}&ct_id={$row[ct_id]}\", 580, {\"isMobile\":\"Y\"})'>옵션/수량변경</span>";
    }
    echo "</td>";

    // 수량, 입력(수량)
    if ($s_page == "cart.php")
        echo "<td align=center><input type=number id='ct_qty_{$i}' name='ct_qty[{$i}]' value='$row[ct_qty]'  style='width:60px;text-align:center; padding:0;' maxlength=6 class=ed autocomplete='off'></td>";
    else
        echo "<td align=center>$row[ct_qty]</td>";
        
    echo "<td align=center style='text-align:center;'>" . number_format($sell_amount);
	if($config["cf_use_point"]){
	    echo "<br/>(".number_format($point).")";
	}
    echo "</td>";
    /*
    echo "<td align=center>" . number_format($row[ct_amount]) . "</td>";
    echo "<td align=center>" . number_format($sell_amount) . "</td>";
    echo "<td align=center>" . number_format($point) . "&nbsp;</td>";
    */

    if ($s_page == "cart.php")
        echo "<td align=center><a href='./cartupdate.php?w=d&ct_id=$row[ct_id]'><img src='$g4[shop_img_path]/btn_del.gif' border='0' align=absmiddle alt='삭제'></a></td>";
    else if ($s_page == "orderinquiryview.php")
    {
        switch($row[ct_status])
        {
            case '주문' : $icon = "<span class=\"cartsub_icon cartsub_icon1\" title=\"주문대기\" ><i class=\"far fa-comment-dots\"></i></span>"; break;
            case '준비' : $icon = "<span class=\"cartsub_icon cartsub_icon2\" title=\"준비중\" ><i class=\"far fa-gift\"></i></span>"; break;
            case '배송' : $icon = "<span class=\"cartsub_icon cartsub_icon3\" title=\"배송중\" ><i class=\"far fa-truck\"></i></span>"; break;
            case '완료' : $icon = "<span class=\"cartsub_icon cartsub_icon4\" title=\"배송완료\" ><i class=\"far fa-check-circle\"></i></span>"; break;
            default     : $icon = $row[ct_status]; break;
        }
        echo "<td align=center>$icon</td>";
    }

    echo "</tr>";
    echo "<tr><td colspan='$colspan' class=dotline></td></tr>";

    //$tot_point       += $point;
    //$tot_sell_amount += $sell_amount;

    if ($row[ct_status] == '취소' || $row[ct_status] == '반품' || $row[ct_status] == '품절') {
        $tot_cancel_amount += $sell_amount;
    }
    else {
        $tot_point       += $point;
        $tot_sell_amount += $sell_amount;
    }
}

$cartNum = $i;
if($cartNum > 0 && $cartNum == $is_send_free2_cnt){ //단독 주문시 배송비 무료상품 수 = 장바구니 상품 수 => 배송비 무료
    $is_send_free = true;
}


if ($goods_count)
    $goods .= " 외 {$goods_count}건";

if ($i == 0) {
    echo "<tr>";
    echo "<td colspan='$colspan' align=center height=100><span class=textpoint>장바구니가 비어 있습니다.</span></td>";
    echo "</tr>";
} else {
    // 배송비가 넘어왔다면
    if ($_POST[od_send_cost]) {
        $send_cost = (int)$_POST[od_send_cost];
    } else {
        // 배송비 계산
        if ($default[de_send_cost_case] == "없음" || $is_send_free) //무료배송상품이 포함된경우 배송비 없음
            $send_cost = 0;
        else {
            // 배송비 상한 : 여러단계의 배송비 적용 가능
            $send_cost_limit = explode(";", $default[de_send_cost_limit]);
            $send_cost_list  = explode(";", $default[de_send_cost_list]);
            $send_cost = 0;
            for ($k=0; $k<count($send_cost_limit); $k++) {
                // 총판매금액이 배송비 상한가 보다 작다면
                if ($tot_sell_amount < $send_cost_limit[$k]) {
                    $send_cost = $send_cost_list[$k];
                    break;
                }
            }
        }

        // 이미 주문된 내역을 보여주는것이므로 배송비를 주문서에서 얻는다.
        $sql = "select od_send_cost from $g4[yc4_order_table] where od_id = '$od_id' ";
        $row = sql_fetch($sql);
        if ($row[od_send_cost] > 0)
            $send_cost = $row[od_send_cost];
    }


    //다중배송이면 배송비 곱
	if($_REQUEST["od_delivery_cnt"] > 1){
		$send_cost = $send_cost * intval($_REQUEST["od_delivery_cnt"]);
    }
    
    
    // 배송비가 0 보다 크다면 (있다면)
    if ($send_cost > 0)
    {
        echo "<tr><td colspan='$colspan' height=1 bgcolor=#EFEFEF></td></tr>";
        echo "<tr>";
        echo "<td height=28 colspan='".($colspan)."' align=right style='padding-right:5px;'>배송비 : ";
        echo "<b class='sendcost' data-singlesendcost='{$send_cost}' >" . number_format($send_cost) . "</span></b></td>";
        echo "  </tr>   ";
    }

    // 총계 = 주문상품금액합계 + 배송비
    $tot_amount = $tot_sell_amount + $send_cost;

    echo "<tr><td colspan='$colspan' height=1 class='c1'></td></tr>";
    echo "<tr align=center height=40 bgcolor=#EFEFEF>";
    echo "<td colspan='".($colspan)."' align=right style='padding-right:5px;'><b>총계 : </b>";
    echo "  <span class=amount><b class='disp_tot_amount' data-sellamount='{$tot_sell_amount}'>" . number_format($tot_amount);
	if($config["cf_use_point"]){
	    echo "  (" . number_format($tot_point) . ")";
	}
    echo "  </b></span></td>";
    echo "</tr>";
    echo "<input type=hidden name=w value=''>";
    echo "<input type=hidden name=records value='$i'>";
}
?>
<tr><td colspan='<?=$colspan?>' height=2 class="c1"></td></tr>
<tr>
    <td colspan='<?=$colspan?>' align=center>
    <?
    if ($s_page == "cart.php") {
        if ($i == 0) {
            echo "<br><a href='$g4[mpath]'><span class='btn1-o big'> <i class='fas fa-shopping-basket'></i> 쇼핑계속하기</span></a>";
        } else {
            echo "
            <br><input type=hidden name=url value='./orderform.php'>
            <a href=\"javascript:form_check('buy')\"><span class='btn1 big'> <i class='fas fa-check'></i> 주문하기</span></a>
            <a href=\"javascript:form_check('allupdate')\"><span class='btn1-o big'> <i class='fas fa-cubes'></i> 수량변경</span></a>
            <a href=\"javascript:form_check('alldelete')\"><span class='btn1-o big'> <i class='far fa-trash-alt'></i> 삭제하기</span></a>
            <a href='./list.php?ca_id=$continue_ca_id'><span class='btn1-o big'> <i class='fas fa-shopping-basket'></i> 쇼핑계속하기</span></a>";
        }
    }
    ?>
    </td>
</tr>
</table>
</form>



<? if ($s_page == "cart.php") { ?>
    <script language='javascript'>
    <? if ($i != 0) { ?>
        function form_check(act) {
            var f = document.frmcartlist;
            var cnt = f.records.value;

            if (act == "buy")
            {
                f.w.value = act;

                <?
                if (get_session('ss_mb_id')) // 회원인 겨우
                {
                    echo "f.action = './orderform.php';";
                    echo "f.submit();";
                }
                else
                    echo "document.location.href = '".$g4[mpath]."/bbs/login.php?url=".urlencode("$g4[shop_mpath]/orderform.php")."';";
                ?>
            }
            else if (act == "alldelete")
            {
				var con_delete = confirm("전 상품을 삭제하시겠습니까?");
				if(con_delete){
					 f.w.value = act;
					 f.action = "<?="./cartupdate.php"?>";
					 f.submit();
				}else{
					return;
				}
               
            }
            else if (act == "allupdate")
            {
                for (i=0; i<cnt; i++)
                {
                    //if (f.elements("ct_qty[" + i + "]").value == "")
                    if (document.getElementById('ct_qty_'+i).value == '')
                    {
                        alert("수량을 입력해 주십시오.");
                        //f.elements("ct_qty[" + i + "]").focus();
                        document.getElementById('ct_qty_'+i).focus();
                        return;
                    }
                    //else if (isNaN(f.elements("ct_qty[" + i + "]").value))
                    else if (isNaN(document.getElementById('ct_qty_'+i).value))
                    {
                        alert("수량을 숫자로 입력해 주십시오.");
                        //f.elements("ct_qty[" + i + "]").focus();
                        document.getElementById('ct_qty_'+i).focus();
                        return;
                    }
                    //else if (f.elements("ct_qty[" + i + "]").value < 1)
                    else if (document.getElementById('ct_qty_'+i).value < 1)
                    {
                        alert("수량은 1 이상 입력해 주십시오.");
                        //f.elements("ct_qty[" + i + "]").focus();
                        document.getElementById('ct_qty_'+i).focus();
                        return;
                    }
                }
                f.w.value = act;
                f.action = "./cartupdate.php";
                f.submit();
            }

            return true;
        }
    <? } ?>
    </script>
<? } ?>

<? if ($s_page == "cart.php") { ?>


    
<?if($default["de_npay_use"]){ //네이버페이?>
    <style>
        .npaybtn{
            position:relative; 
            float:left; 
            width:100%; 
            text-align:center;
            padding-top:20px;
        }
    </style>
    <div class="npaybtn">
        <?include_once("{$g4["shop_mpath"]}/cart_npay_btn.php")?>
    </div>
<?}?>


<br><br>
<table align=center cellpadding=0 cellspacing=0 class="cartsub">
    <tr><td style="height:2px; background:url('<?=$g4[shop_img_path]?>/cartsub_line.gif') repeat-x center top;"></td></tr>
    <tr><td style='line-height:180%;'>
		   <div class="cartsubtext">
			<FONT COLOR="#e87575"> · 상품 주문하기</FONT> : 주문서를 작성하시려면 '주문하기' 버튼을 누르세요.<BR>
			<FONT COLOR="#ffae00"> · 상품 수량변경</FONT> : 주문수량을 변경하시려면 원하시는 수량을 입력하신 후 '수량변경' 버튼을 누르세요.<BR>
			<FONT COLOR="#5a8f30"> · 상품 삭제하기</FONT> : 모든 주문내용을 삭제하시려면 '삭제하기' 버튼을 누르세요.<BR>
			<FONT COLOR="#0777be"> · 쇼핑 계속하기</FONT> : 쇼핑하시던 페이지로 돌아가시려면 '쇼핑 계속하기' 버튼을 누르세요.
		   </div>
        </td></tr>
   <tr><td style="height:2px; background:url('<?=$g4[shop_img_path]?>/cartsub_line.gif') repeat-x center top;"></td></tr>
</table>
<? } ?>
