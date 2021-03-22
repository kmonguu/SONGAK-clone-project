<?
include_once("./_common.php");

set_session("alimi_save_page", $_GET["save_page"]);
set_session("alimi_save_sc", $_GET["save_sc"]);


$tot_point = 0;
$tot_sell_amount = 0;
$tot_cancel_amount = 0;
$goods = $goods_it_id = "";
$goods_count = -1;

$od = sql_fetch("SELECT * FROM $g4[yc4_order_table] WHERE od_id='{$_GET["wr_id"]}'");
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
				a.it_option_amount
           from $g4[yc4_cart_table] a,
                $g4[yc4_item_table] b
          where a.on_uid = '{$od["on_uid"]}'
            and a.it_id  = b.it_id
          order by a.ct_id ";
$result = sql_query($sql);

$optObj = null;
if(class_exists("Yc4ItemOption"))
    $optObj = new Yc4ItemOption();

$cart = array();
for ($i=0; $row=mysql_fetch_array($result); $i++)
{
    $sell_amount = $row[ct_amount] * $row[ct_qty];
    if ($row[ct_status] == '취소' || $row[ct_status] == '반품' || $row[ct_status] == '품절') {
        $tot_cancel_amount += $sell_amount;
    }
    else {
        $tot_sell_amount += $sell_amount;
    }

    $it_name = stripslashes($row[it_name]);
    $it_add_options = print_item_options($row[it_id], $row[it_opt1], $row[it_opt2], $row[it_opt3], $row[it_opt4], $row[it_opt5], $row[it_opt6]);
    $it_option_str = "";
    if($optObj != null) {
        $it_option_str = $optObj->print_option_cart($row["it_id"], $row["it_option1"], $row["it_option2"], $row["it_option3"], $row["it_option_amount"]);
    }
    $row["it_name"] = $it_name;
    $row["it_add_options"] = $it_add_options;
    $row["it_option_str"] = $it_option_str;
    $cart[] = $row;
    
}

$tot_amount = $tot_sell_amount + $od["od_send_cost"];
?>

<style>
	#divContent p, 
	#divContent div, 
	#divContent span {
		font-size:23px;
		line-height:1.5;
	}
	#divContent img {
		max-width:100%;
		height:initial !important;
	}
    .items {width:95%; border:1px solid gray; border-radius:7px; padding:6px 2.5%; margin-bottom:10px; box-shadow:  1px 1px 1px;}
    .items hr{border:0px; border-bottom:1px dashed gray;}
    ul.detailinfo li {display:inline-block; width:95%;}
</style>



<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;">주문내역</div>
<div class="nbox">
	<div style="float:left;width:16.42%;margin-left:3.402%;margin-top:20px;"><a href="javascript:menum('menu02-1')"><img src="/app_helper/images/back_btn.jpg" style="width:100%"/></a></div>
	<div style="float:left;width:85.2%;margin-left:7.396%;margin-top:25px;color:#222222;font-size:26px;"><?=$view[wr_subject]?></div>
	
	<!-- ##############################################################################  -->
	<!-- 본문 내용 -->
	<div id="divContent" style="float:left;width:85.2%;margin-left:7.396%;margin-top:25px;color:#222222;font-size:23px;padding-bottom:26px;border-bottom:2px solid #e0e0e1;">		


        <ul class="detailinfo" style='line-height:2;margin:10px 10px 30px 10px;'>
            
            <li style='font-size:1.3em; margin-left:-15px;'>
                <strong>주문 상품</strong> 
            </li>
            <?foreach($cart as $c){?>
                <li>
                    <div class="items">
                        <strong><?=$c["it_name"]?></strong>
                        <span>(수량:<?=$c["ct_qty"]?>)</span>
                        <?if($c["it_option_str"]){?>
                            <br/><span style='color:gray; font-size:20px;'><?=$c["it_option_str"]?></span>
                        <?}?>
                        <br/>
                        <?=$c["it_add_options"]?>
                    </div>
                </li>
            <?}?>

            <hr style="border:0px ; border-top:2px dashed gray;margin-top:20px;"/>                  
            <li style='font-size:1.3em; margin-left:-15px; '>
                <strong>주문하시는 분</strong> 
            </li>
            <li><strong>주문번호</strong> <span style="float:right;width:70%;line-height:2;"><?=$od[od_id]?></span></li>
            <li><strong>주문일시</strong> <span style="float:right;width:70%;line-height:2;"><?=$od[od_time]?></span></li>
            <li><strong>이름</strong> <span style="float:right;width:70%;line-height:2;"><?=$od[od_name]?></span></li>
            <li><strong>핸드폰</strong> <span style="float:right;width:70%;line-height:2;"><a href="tel:<?=$od[od_hp]?>"><?=$od[od_hp]?></a></span></li>
            <li ><strong>주소</strong> <span style="float:right;width:70%;line-height:2;"><?=$od[od_zip1]?> <?=$od[od_addr1]?> <?=$od[od_zip2]?></span></li>
            <li><strong>이메일</strong> <span style="float:right;width:70%;line-height:2;"><?=$od[od_email]?></span></li>
    
            <hr style="border:0px ; border-top:2px dashed gray;margin-top:20px;"/>                  
            <li style='font-size:1.3em; margin-left:-15px; '>
                <strong>받으시는 분</strong> 
            </li>
            <li><strong>이름</strong> <span style="float:right;width:70%;line-height:2;"><?=$od[od_b_name]?></span></li>
            <li><strong>핸드폰</strong> <span style="float:right;width:70%;line-height:2;"><a href="tel:<?=$od[od_hp]?>"><?=$od[od_hp]?></a></span></li>
            <li><strong>주소</strong> <span style="float:right;width:70%;line-height:2;"><?=$od[od_b_zip1]?> <?=$od[od_b_addr1]?> <?=$od[od_b_addr2]?></span></li>
            <li><strong>전하는말</strong> <span style="float:right;width:70%;line-height:2;"><?=conv_content($od[od_memo],"2")?></span></li>
            
            <hr style="border:0px ; border-top:2px dashed gray;margin-top:20px;"/>                  
            <li style='font-size:1.3em; margin-left:-15px; '>
                <strong>결제정보</strong> 
            </li>
            <li><strong>결제방식</strong> <span style="float:right;width:70%;line-height:2;"><?=$od[od_settle_case]?></span></li>
            <?if($od["od_settle_case"] == "무통장"){?>
                <li><strong>계좌번호</strong> <span style="float:right;width:70%;line-height:2;"><?=$od[od_bank_account]?></span></li>
                <li><strong>입금자명</strong> <span style="float:right;width:70%;line-height:2;"><?=$od[od_deposit_name]?></span></li>
            <?}?>
            
            

                
        </ul>

        <hr style="border:0px ; border-top:2px dashed gray;"/>
        <div style='width:95%; text-align:right; line-height:1.5;'>
        <?
        $receipt_amount = $od[od_receipt_bank] + $od[od_receipt_card]  + $od[od_receipt_point]  + $od[od_coupon]  - $od[od_cancel_card] - $od[od_refund_amount];
        $misu_amount = $tot_amount - $tot_cancel_amount - $receipt_amount - $od[od_dc_amount];
        ?>
        <b>결제 합계</b> <? echo $wanbul ?> : <b><? echo display_amount($receipt_amount) ?></b></span>&nbsp;&nbsp;
        <?
        if ($od[od_dc_amount] > 0) {
            echo "<br>DC : ". display_amount($od[od_dc_amount]) . "&nbsp;&nbsp;";
        }
        if ($misu_amount > 0) {
            echo "<br><font color=crimson><b>아직 결제하지 않으신 금액 : <span style='font-size:20px;'>".display_amount($misu_amount)."</span></b></font>&nbsp;&nbsp;";
        }
        ?>
        </div>


               
	</div>


</div>


<script type="text/javascript">

</script>