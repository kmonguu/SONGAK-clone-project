<?
include_once("./_common.php");

$ct_id = $_REQUEST["ct_id"]; //장바구니에서 옵션 변경 시 넘어옴
if($isMobile == "Y") {
	$g4["shop_path"] = "/m/shop";
}

if($ct_id) {
	$yc4Obj = new Yc4();
	$ct = $yc4Obj->get_cart($ct_id);
	if($ct["ct_id"] == "") {
		alert("장바구니에서 삭제된 상품입니다.", "{$g4["shop_path"]}/cart.php");
	}
}

// 분류사용, 상품사용하는 상품의 정보를 얻음
$sql = " select a.*,
                b.ca_name,
                b.ca_use
           from $g4[yc4_item_table] a,
                $g4[yc4_category_table] b
          where a.it_id = '$it_id'
            and a.ca_id = b.ca_id ";
$it = sql_fetch($sql);
if (!$it[it_id])
    alert("자료가 없습니다.");
if (!($it[ca_use] && $it[it_use])) {
    if (!$is_admin)
        alert("판매가능한 상품이 아닙니다.");
}

// 분류 테이블에서 분류 상단, 하단 코드를 얻음
$sql = " select ca_include_head, ca_include_tail
           from $g4[yc4_category_table]
          where ca_id = '$it[ca_id]' ";
$ca = sql_fetch($sql);
?>

<style>
.product_icon { width:100%; text-align:left; margin-bottom:21px; }

.it_basic { font-size:20px; color:#666; font-weight:300; line-height:27px; margin-bottom:5px; }
.it_name { font-size:35px; color:#111; font-weight:400; line-height:42px; padding-bottom:40px; }

.poptitle { width:100%; height:60px; top:0; left:0; background:url('/res/images/index/cart_top.png') no-repeat left top; border-top-right-radius:10px; }
.layer_modal { border-radius:10px; }

.vright { width:100%;  margin:0px 0 0 30px; display:inline-table; font-family:"Noto Sans KR"; text-align:left; font-weight:300; position:relative; }

/***/
select:focus {
   /*  background:red;  */
}

.ItemTable {  }
.ItemTable > tbody > tr > th { padding:10px 0 10px 0px; font-size:20px; color:#222; font-weight:400; text-align:left; vertical-align:top; line-height:30px; }
.ItemTable > tbody > tr > td { padding:10px 10px 10px 10px; font-size:20px; color:#000; font-weight:300; text-align:left; vertical-align:top; line-height:30px; }
.ItemTable.ItemTable2 > tbody > tr > td {  }


.cnt_amount2 { font-size:20px; color:#555; font-weight:500; display:inline-block; width:100%; line-height:60px; background:#f8f8f8; border-top:1px solid #d9d9d9; border-bottom:1px solid #d9d9d9; text-align:right; padding:0 20px; box-sizing:border-box; margin-top:20px; }
.cnt_amount2 > span { font-size:26px; color:#f85858; }


.ItemBtnArea { display:inline-block; width:100%; font-size:0; line-height:0; margin:30px 0 50px 0; }
.ItemBtn { width:195px; height:55px; border:1px solid #333; background:#fff; font-size:20px; color:#333; font-weight:400; margin:0 0 0 7px; float:right; }
.ItemBtn.ItemBtn100 { width:100%; }
.ItemBtn.ItemBuy { width:100%; height:55px; border:0px; background:#ff4242; font-size:20px; color:#fff; font-weight:400; margin:0 0 10px 0px; }
.ItemBtn > img { display:inline-block; vertical-align:middle; margin:-3px 0 0 0; }


.vbanner { float:right; position:relative; display:inline-block; }
.vbanner .v_left { position:absolute; right:24px; top:0px; cursor:pointer; }
.vbanner .v_right { position:absolute; right:0px; top:0px; cursor:pointer; }

.pro_btn { width:175px; height:50px; text-align:center; line-height:48px; font-size:18px; font-weight:400;}

.buy_btn { width:220px; border:1px solid #eb3737; color:#fff; background:#eb3737; }
.buy_btn:hover { background:#ff4242; border:1px solid #ff4242; }
.ather_btn { border:1px solid #333333; color:#333333; }
.ather_btn:hover { border:1px solid #333; }

.list_btn:hover { color:#fff; background:#333333; border:1px solid #333333; }
.cart_btn:hover { color:#fff; background:#333333; border:1px solid #333333; }
.product_icon { width:100%; height:20px; text-align:left; }
.shop_btns { margin-top:10px; }
.cartBtn {background:#4b4b4b;color:#ffffff;padding:5px 8px;line-height:23px;border:1px solid #1b1b1b;font-size:11px;}
.cartBtn:hover {background:#ffffff;color:#000000;padding:5px 8px;line-height:23px;border:1px solid #1b1b1b;font-size:11px;}
.shop_btns a:hover {text-decoration:none;}








	/* 상세 탭 */
	.item_ex_tab { width:100%; height:50px; border-bottom:1px solid #cecece; text-align:center;  margin:30px 0; box-sizing:border-box;}
	.item_ex_tab > ul { display:inline-block; position:relative; }
	.item_ex_tab > ul > li { display:inline-block; width:225px; height:50px;  line-height:48px; text-align:center; box-sizing:border-box; background:#fbfbfb; border:1px solid #cecece; border-left:0px; float:left; }
	.item_ex_tab > ul > li:first-child { border-left:1px solid #cecece; }
	.item_ex_tab > ul > li.on { border:1px solid #cecece; border-bottom:1px solid #fff; border-left:0; border-top:2px solid #ff4242; background:#fff;}
	.item_ex_tab > ul > li.on:first-child { border-left:1px solid #cecece; }
	.item_ex_tab > ul > li > a { display:inline-block; width:100%; height:100%; text-decoration:none; color:#727171; font-size:17px; }


	.div_explan { position:relative; width:100%; margin:0 auto 50px; box-sizing:border-box; }
	.div_explan ul { list-style-type:disc; list-style-position:inside; list-style:initial; margin:initial; padding: 0 0 0 40px;  }
	.div_explan li { margin:initial; display:list-item; }
	.div_explan img { width:950px !important; display:block; margin:0 auto; }

	a.it_btn { position:absolute; width:200px; height:50px; line-height:50px; text-align:center; text-decoration:none; font-size:18px; }
	/* 상세 탭 끝 */

.layer_modal_closebtn { color:#fff; top:20px; }
.vright_con_title { width:75px !important; }
</style>





<!-- ########################################################################################### -->
<!-- 옵션관련 스크립트 -->
<script>
		load_option_list(1);

		function change_io_type1(){ //옵션 1 변경
			var slt = $("#io_type1 > option:selected");
			if(slt.hasClass("lastopt")) {
				make_options();
			} else {
				load_option_list(2);
			}
		}

		function change_io_type2() { //옵션 2 변경
			var slt = $("#io_type2 > option:selected");
			if(slt.hasClass("lastopt")) {
				make_options();
			} else {
				load_option_list(3);
			}
		}

		function change_io_type3() { //옵션 3 변경
			var slt = $("#io_type2 > option:selected");
			make_options();
		}

		//옵션 불러오기
		function load_option_list(depth){				

			for(var idx = depth ; idx <= 3; idx++){ //하위옵션 선택으로 변경
				$("#io_type"+idx).prop("disabled","disabled");	
				$("#io_type"+idx).html("<option value=''>선택</option>");
				if(depth == idx){ //차 하위 제외 전부 disable
					$("#io_type"+idx).removeProp("disabled","disabled");	
				}
			}
			if($("#io_type"+(depth-1)).val() == "") {
				$("#io_type"+depth).prop("disabled","disabled");	
				return;
			}

			var type1 = "";
			var type2 = "";
			var type3 = "";
			var it_id = "<?=$it_id?>";
			var od_sdate = "<?=$_GET["od_sdate"]?>";
			var od_edate = "<?=$_GET["od_edate"]?>";

			type1 = $("#io_type1").val();
			if($("#io_type2").size() > 0) type2 = $("#io_type2").val();
			if($("#io_type3").size() > 0) type3 = $("#io_type3").val();

			$.post("<?=$g4[shop_mpath]?>/item_optionlist.php", {it_id:it_id, od_sdate:od_sdate, od_edate:od_edate, depth:depth, type1:type1, type2:type2, type3:type3}, function(data){
                    $("#io_type"+depth).append(data);
                    if(typeof(set_modal_layer_center_screen) == "function") set_modal_layer_center_screen();
			});
			
		}

		//마지막 옵션 변경
		function make_options(ct_id){
			
			$(".option_none_select").hide();
		
			var type1 = "";
			var type2 = "";
			var type3 = "";
			var it_id = "<?=$it_id?>";
			var od_sdate = "<?=$_GET["od_sdate"]?>";
			var od_edate = "<?=$_GET["od_edate"]?>";
			var ct_id = ct_id !== undefined ? ct_id : "";
			type1 = $("#io_type1").val();
			if($("#io_type2").size() > 0) type2 = $("#io_type2").val();
			if($("#io_type3").size() > 0) type3 = $("#io_type3").val();


			if($("#io_type1").size() == 0) { //옵션이 없는 상품
				loading();
				$.post("<?=$g4[shop_mpath]?>/item_option_make.php", {it_id:it_id, od_sdate:od_sdate, od_edate:od_edate, ct_id:ct_id}, function(data){
                    $(".optlist").append(data);
					amount_change();
                    if(typeof(set_modal_layer_center_screen) == "function") set_modal_layer_center_screen();
					close_loading();
				});
				return;
			}

		
			var optno = $(".lastopt:selected").data("opt-no");
			if(ct_id == "" && (optno == "" || optno === undefined)) return;

			if($(".option_item_"+optno).size() > 0) {
				var strOpt = type1;
				if(type2 != "") strOpt += " / " + type2;
				if(type3 != "") strOpt += " / " + type3;
				alert(strOpt + " 상품 옵션이 이미 추가되어있습니다");
				return;
			}

			loading();
			$.post("<?=$g4[shop_path]?>/item_option_make.php", {it_id:it_id, od_sdate:od_sdate, od_edate:od_edate, type1:type1, type2:type2, type3:type3,ct_id:ct_id}, function(data){
					$(".optlist").append(data);
                    amount_change();
                    if(typeof(set_modal_layer_center_screen) == "function") set_modal_layer_center_screen();
					close_loading();
			});
		}
		
		//옵션항목 삭제
		function delete_option_item(obj){

			custom_confirm(380, "선택하신 옵션항목을 삭제하시겠습니까?", function(){
				$(obj).closest(".option_item").remove();
				amount_change();
				if(typeof(set_modal_layer_center_screen) == "function") set_modal_layer_center_screen();
			}, function(){});

			/*
			if(!confirm("선택하신 옵션항목을 삭제하시겠습니까?")) return;
			$(obj).closest(".option_item").remove();
            amount_change();
            if(typeof(set_modal_layer_center_screen) == "function") set_modal_layer_center_screen();
			*/
		}
</script>
<!-- 옵션관련 스크립트 -->
<!-- ########################################################################################### -->



<div class="poptitle"></div>

<div style="width:100%; padding:0 20px; box-sizing:border-box;" >

<form name=fitem id="fitem" method=post  action="<?=$g4["shop_path"]?>/cartupdate.php" style="position:relative; width:100%; display:inline-block; margin-top:40px;">
<input type=hidden name=ct_id value='<?=$ct_id?>'>
<input type=hidden name=it_id value='<?=$it[it_id]?>'>
<input type=hidden name=it_name value='<?=$it[it_name]?>'>
<input type=hidden name=sw_direct>
<input type=hidden name=url>



	<div class="product_icon">
		<!-- ITEM TYPE ICON -->
		<?for($idx = 1 ; $idx <= 5; $idx++) {?>
			<?if($it["it_type{$idx}"]) {?>
				<div class="icon_item_type<?=$idx?>" >
					<?=Yc4::$IT_TYPE[$idx]?>
				</div>
			<?}?>
		<?}?>
	</div>

	<p class="it_basic"><?=$it[it_basic]?></p>
	<p class="it_name"><?=$it[it_name]?></p>

	
	<table width="100%" cellspacing="0" cellpadding="0" class="ItemTable" >
		<colgroup>
			<col width="20%" />
			<col width="" />
		</colgroup>
		<tbody>



			<?/******* 갤러리/전화문의 상품은 표시 안하는 부분 **********/?>
				<tr>
					<th>상품가격</th>
					<td>
						<?=display_amount(get_amount($it), $it[it_tel_inq])?>
					</td>
				</tr>
				
				<? if ($config[cf_use_point]) { // 적립금 사용한다면 ?>
					<tr>
						<th>적립금</th>
						<td>
							<span id="disp_point_span" >0</span>
							<input type=hidden name=disp_point readonly >
							<input type=hidden name=it_point value='0'>
						</td>
					</tr>
				<? } ?>
			<?/******* 갤러리/전화문의 상품은 표시 안하는 부분 끝 **********/?>

			<? if ($it[it_maker]) { ?>
				<tr>
					<th>제조사</th>
					<td><?=$it[it_maker]?></td>
				</tr>
			<? } ?>

			<? if ($it[it_origin]) { ?>
				<tr>
					<th>원산지</th>
					<td><?=$it[it_origin]?></td>
				</tr>
			<? } ?>


			<?
			// 옵션 텍스트 출력 
			// ** 추가옵션필드 중 단순 택스트 항목(선택이 없는)만 출력하는 부분
			$add_options = "";
			for ($i=1; $i<=6; $i++)
			{
				// 옵션에 문자가 존재한다면
				$str = get_item_options(trim($it["it_opt{$i}_subject"]), trim($it["it_opt{$i}"]), $i);
				if(trim($it["it_opt{$i}"]) != $str) continue; //선택추가옵션은 제외
				if ($str)
				{
					$add_options .=  "<tr>";
					$add_options .=  "<th scope='row' class='subject_add_option' style='vertical-align:middle;' >".$it["it_opt{$i}_subject"]."</th>";
					$add_options .=  "<td class='option_td'>$str</td>";
					$add_options .=  "</tr>";
				}
			}
			/*
			if($add_options != "") {
				echo "
				<tr>
					<td colspan='2'>
						<hr style='border:0px; border-bottom:1px solid #efefef;'/>
					</td>
				</tr>
				";
			}
			*/
			echo $add_options;
			?>


			<?/******* 갤러리/전화문의 상품은 표시 안하는 부분 **********/?>


				<?
				//선택옵션이 존재한다면
				if($it["it_option1_subject"] != ""){?>
					<!-- <tr>
						<th colspan="2" >선택옵션</th>
					</tr> -->
		
					<tr>
						<th class='subject_add_option' style='vertical-align:middle;' ><?=$it["it_option1_subject"]?></th>
						<td>
							<select name="io_type1" id="io_type1" class="slt_add_option" onchange="change_io_type1()">
								<option value="">선택</option>
							</select>
						</td>
					</tr>

					<?if($it["it_option2_subject"] != ""){?>
						<tr>
							<th class='subject_add_option' style='vertical-align:middle;' ><?=$it["it_option2_subject"]?></th>
							<td>
								<select name="io_type2" id="io_type2" class="slt_add_option" onchange="change_io_type2()" disabled>
									<option value="">선택</option>
								</select>
							</td>
						</tr>


						<?if($it["it_option3_subject"] != ""){?>
							<tr>
								<th class='subject_add_option' style='vertical-align:middle;' ><?=$it["it_option3_subject"]?></th>
								<td>
									<select name="io_type3" id="io_type3" class="slt_add_option" onchange="change_io_type3()" disabled>
										<option value="">선택</option>
									</select>
								</td>
							</tr>
						<?}?>
					<?}?>

				<?}?>


			<?/******* 갤러리/전화문의 상품은 표시 안하는 부분 끝**********/?>
		</tbody>
	</table>
	
	
		<style>
		.ItemTable > tbody > tr.option_item > td { padding:0px 0px 0px 0px; }
		</style>
		<table width="100%" cellspacing="0" cellpadding="0" class="ItemTable ItemTable2" >
			<colgroup>
				<col width="20%" />
				<col width="" />
			</colgroup>
			<tbody class="optlist" >
				<tr>
					<td colspan="2" style="padding-top:0px; padding-bottom:0px;" >
						<div class="option_none_select" style="display:inline-block; width:100%; padding:20px 0;" >
							<div class="opt_name" style="width:auto;" >
							- 옵션을 선택해주세요.
							</div>							
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	


		<?
		//선택옵션이 존재한다면
		if($it["it_option1_subject"] == ""){?>

			<script>
				$(function(){
					make_options(); //옵션 없는 상품 생성
				});
			</script>

		<?}?>

			


		<div class="cnt_amount2" >
			결제금액

			<span id=disp_sell_amount></span>
			<input type=hidden name=it_amount value='0'>
		</div>



</form>



<?/******* 갤러리/전화문의 상품은 표시 안하는 부분 **********/?>
<? if (!$it[it_tel_inq] && !$it[it_gallery]) { ?>

	<div class="ItemBtnArea" >
		<?if($ct_id) { //장바구니에서 상품 수정?>

			<button type="button" class="ItemBtn" onclick="fitemcheck(document.fitem, 'cart_update2');" style="width:250px;" >
				옵션/수랑변경
			</button>

		<?} else {?>

			<button type="button" class="ItemBtn" onclick="fitemcheck(document.fitem, 'cart_update');" >
				<img src="/m/images/item_cart.png" style="margin-top:-6px;" />  장바구니
			</button>

		<?}?>
	</div>

<?}?>
<?/******* 갤러리/전화문의 상품은 표시 안하는 부분 끝**********/?>



<script type="text/javascript">

function qty_keyup(obj){
	var qtyObj = $(obj).closest(".option_item").find(".ct_qty");
	var qty = parseInt(qtyObj.val());
	var max = parseInt($(obj).closest(".option_item").data("qty"));
	if(qty > max){
		alert("재고 수량이 부족합니다.");
		qtyObj.val(max);
	}
	amount_change();
}

function qty_add(obj, num)
{
    var f = document.fitem;
	var qtyObj = $(obj).closest(".option_item").find(".ct_qty");
    var qty = parseInt(qtyObj.val());
	var max = parseInt($(obj).closest(".option_item").data("qty"));
    if (num < 0 && qty <= 1)
    {
        alert("수량은 1 이상만 가능합니다.");
        qty = 1;
    }
    else if (num > 0 && qty >= 9999)
    {
        alert("수량은 9999 이하만 가능합니다.");
        qty = 9999;
    }
    else
    {
        qty = qty + num;
    }
	
	if(num > 0 && qty > max){
		alert("재고 수량이 부족합니다.");
        qty = max;
	}

    qtyObj.val(qty);

    amount_change();
}

function get_amount(data)
{
    var str = data.split(";");
    var num = parseInt(str[1]);
    if (isNaN(num)) {
        return 0;
    } else {
        return num;
    }
}

function get_amount_point(data)
{
    var str = data.split(";");
    var num = parseInt(str[2]);
    if (isNaN(num)) {
        return 0;
    } else {
        return num;
    }
}

function amount_change()
{
    var basic_amount = parseInt('<?=get_amount($it)?>');
    var basic_point  = parseFloat('<?=$it[it_point]?>');
    var cust_amount  = parseFloat('<?=$it[it_cust_amount]?>');

    var f = document.fitem;
    var opt1 = 0;
    var opt2 = 0;
    var opt3 = 0;
    var opt4 = 0;
    var opt5 = 0;
    var opt6 = 0;

	var opt21 = 0;
    var opt22 = 0;
    var opt23 = 0;
    var opt24 = 0;
    var opt25 = 0;
    var opt26 = 0;
    var ct_qty = 0;

	$(".ct_qty").each(function(){
		var q = parseInt($(this).val());
		ct_qty += q;
	});
	if(ct_qty == 0) ct_qty=1;

	//상품옵션 가격
	var optAmt = 0;
	$(".ct_qty").each(function(){
		var q = parseInt($(this).val());
		if($(this).closest(".option_item").find(".io_amt").val() != "") {
			var oa = parseInt($(this).closest(".option_item").find(".io_amt").val());
			optAmt += (oa * q);
		}
	});

	$(".option_item").each(function(){
		var q = parseInt($(this).find(".ct_qty").val());
		$(this).find(".it_opt1").each(function(){ opt1 += get_amount($(this).val()) * q; opt21 += get_amount_point($(this).val()) * q; });
		$(this).find(".it_opt2").each(function(){ opt2 += get_amount($(this).val()) * q; opt22 += get_amount_point($(this).val()) * q; });
		$(this).find(".it_opt3").each(function(){ opt3 += get_amount($(this).val()) * q; opt23 += get_amount_point($(this).val()) * q; });
		$(this).find(".it_opt4").each(function(){ opt4 += get_amount($(this).val()) * q; opt24 += get_amount_point($(this).val()) * q; });
		$(this).find(".it_opt5").each(function(){ opt5 += get_amount($(this).val()) * q; opt25 += get_amount_point($(this).val()) * q; });
		$(this).find(".it_opt6").each(function(){ opt6 += get_amount($(this).val()) * q; opt26 += get_amount_point($(this).val()) * q; });
	});
	
    var amount = basic_amount;
	var point  = parseInt(basic_point);

	var opt = opt1 + opt2 + opt3 + opt4 + opt5 + opt6;
	var opp = opt21 + opt22 + opt23 + opt24 + opt25 + opt26;

    if (typeof(f.it_amount) != 'undefined')
        f.it_amount.value = amount + optAmt  + opt;

    if (typeof(jQuery("#disp_sell_amount")) != 'undefined'){
		var amount1 = String(amount * ct_qty + optAmt + opt) ;
		jQuery("#disp_sell_amount").html(number_format(amount1)+"원");
		jQuery("#disp_sell_amount_fixed").html(number_format(amount1)+"원");
	}

    if (typeof(f.disp_cust_amount) != 'undefined')
        f.disp_cust_amount.value = number_format(String(cust_amount * ct_qty + optAmt + opt));

    if (typeof(f.it_point) != 'undefined') {
        f.it_point.value = point;
        f.disp_point.value = number_format(String( point * ct_qty +opp ));
    }
}

<? if (!$it[it_gallery]) { echo "amount_change();"; } // 처음시작시 한번 실행 ?>

function validate(){
	var f = document.fitem;
	// 판매가격이 0 보다 작다면
    if (f.it_amount.value < 0)
    {
        alert("전화로 문의해 주시면 감사하겠습니다.");
        return false;
	}

	var is_qty = true;
	$(".ct_qty").each(function(){
		if(parseInt($(this).val()) <= 0){
			is_qty = false;
		}
	});
	if(!is_qty){
		//alert("수량이 0개인 상품이 있습니다. 수량을 조절해주세요.");
		custom_alert(400, "수량이 0개인 상품이 있습니다. 수량을 조절해주세요.");
		return false;
	}
	if($(".option_item").size() == 0) {
		//alert("상품의 선택옵션을 선택해 주십시오.");
		custom_alert(400, "상품의 선택옵션을 선택해 주십시오.");
		return false;
	}


	var optcheckstr = "";
	$(".option_item").each(function(){
		
		for (i=1; i<=6; i++) {
			var slt = $(this).find(".it_opt"+i);
			if(slt.size() > 0) {
				if(slt.val() == '선택해주세요'){
					if(optcheckstr != "") optcheckstr += "\n";
					optcheckstr += "[ " + $(this).find(".opt_name").data("name") + " ] " + $(this).find(".it_opt"+i+"_subject").val() + "을(를) 선택하여 주십시오.";
					slt.focus();
				}
			}
		}

	});

	if(optcheckstr != "") {
		//alert(optcheckstr);
		custom_alert(500, optcheckstr);
		return false;
	}
	
	return true;
}

// 바로구매 또는 장바구니 담기
var clickbtn = false;
function fitemcheck(f, act)
{
	clickbtn = true;
    
	if(!validate()) return;


    if (act == "direct_buy") {
		f.target = "";
        f.sw_direct.value = 1;
    } else if (act == "cart_update2") {
		f.target = "";
        f.sw_direct.value = 0;
    } else {
		f.target = "ifrCartUpdate";
        f.sw_direct.value = 0;
	}
	
    amount_change();

	loading();
	
    f.submit();

    /*
    var params = $("#fitem").serialize();
	$.post("<?=$g4["shop_path"]?>/cartupdate.php", params, function(data){
		top.location.reload();
    });
    */

}

function cartupdated(){
	if(!clickbtn) return;
	close_loading();
	var err = $("iframe[name='ifrCartUpdate']").contents().find("#ifrErr").html();
	if(err === undefined || err == ""){

		custom_confirm(400, "<strong style='font-size:20px;'>상품이 장바구니에 담겼습니다.</strong><br/><br/>장바구니로 이동하시겠습니까?", function(){
			location.href='<?=$g4["shop_mpath"]?>/cart.php';
		}, function(){});
		/*
		$(".cartMessage").html("상품이 장바구니에 담겼습니다.");
		$(".divCartUpdate").show();
		*/
		//if(!confirm("장바구니에 상품이 추가되었습니다. 장바구니로 이동하시겠습니까?")) return;
		//location.href = "<?=$g4["shop_path"]?>/cart.php";
	} else {
		custom_alert(400, err);
		/*
		$(".cartMessage").html(err);
		$(".divCartUpdate").show();
		*/
		// err = err.split("\\n").join("\n");
		// if(!confirm(err + "\n장바구니로 이동하시겠습니까?")) return;
		//location.href = "<?=$g4["shop_path"]?>/cart.php";
	}
}

// 상품보관
function item_popup_wish(f, it_id)
{
	f.url.value = "<?=$g4[shop_path]?>/wishupdate.php?it_id="+it_id;
	f.action = "<?=$g4[shop_path]?>/wishupdate.php";
	f.submit();
}

function go_block(target){
	var target_state = $("."+target).offset().top;
	$("html, body").stop().animate({scrollTop:target_state}, 300, "linear");
}

/*
function go_block(no){
	
	var target_state = $("."+target).offset().top;
	$("html, body").stop().animate({scrollTop:target_state}, 300, "linear");
	

	$(".tab_info").hide();
	$(".tab_info"+no).show();

	$(".item_ex_tab > li").removeClass("on");
	$(".item_ex_tab > li:nth-child("+no+")").addClass("on");
}
*/


$(function(){
	$("iframe[name='ifrCartUpdate']").load(function(){
		cartupdated(this);
	});
});

</script>



</div> <!-- 1110px -->



<!--장바구니용 hidden Iframe -->
<iframe name="ifrCartUpdate" style="display:none; width:0px; height:0px;" src="" onload=""></iframe>

<!--장바구니 Alert -->
<div class="divCartUpdate" style="display:none; position:fixed; top:30%; left:50%; width:400px; min-height:120px; margin-left:-200px; border:1px solid black; background:white; ">
	<div style="width:385px; padding:10px 0 15px 15px; border-bottom:1px solid #afafaf; font-size:20px; font-weight:bold; ">
		<i class="fas fa-cart-arrow-down"></i> 장바구니 담기
		<i class="fas fa-times" style="float:right; padding:7px 15px 0px 0px;cursor:pointer;" onclick="$('.divCartUpdate').hide();" ></i>
	</div>
	<div class="cartMessage" style="width:370px; font-size:18px; padding:25px 15px 5px 15px; text-align:center; max-height:300px; overflow-x:hidden; overflow-y:auto;">
		<!--상품이 장바구니에 담겼습니다.-->
	</div>
	<div class="cartMoveMessage" style="width:370px; font-size:16px; padding:5px 15px 15px 15px; text-align:center; color:#8f8f8f;">
		장바구니로 이동하시겠습니까?
	</div>
	<div class="cartBtns" style="width:400px; font-size:14px; padding:15px 0px 25px 0px; text-align:center;">
		<span class="btn1 big" onclick="location.href='<?=$g4["shop_mpath"]?>/cart.php';">&nbsp;&nbsp;예&nbsp;&nbsp;</span>
		<span class="btn1-o big" onclick="$('.divCartUpdate').hide();">아니오</span>
	</div>
</div>
<!--장바구니 Alert -->


