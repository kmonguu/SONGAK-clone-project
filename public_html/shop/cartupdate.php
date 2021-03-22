<?
include_once("./_common.php");

if ($sw_direct) {
    $tmp_on_uid = get_session("ss_on_direct");
}
else {
    $tmp_on_uid = get_session("ss_on_uid");
}

//장바구니추가 시
function err($msg, $url=""){
    global $sw_direct, $w;
    if($sw_direct || $w == "allupdate"){
        alert($msg, $url);
    } else {
        $msg = str_replace("\\n", "<br/>", $msg);
        echo "<div id='ifrErr'>".$msg."</div>";
        exit;
    }
}


// 브라우저에서 쿠키를 허용하지 않은 경우라고 볼 수 있음.
if (!$tmp_on_uid)
{
    err("더 이상 작업을 진행할 수 없습니다.\\n\\n브라우저의 쿠키 허용을 사용하지 않음으로 설정한것 같습니다.\\n\\n브라우저의 인터넷 옵션에서 쿠키 허용을 사용으로 설정해 주십시오.\\n\\n그래도 진행이 되지 않는다면 쇼핑몰 운영자에게 문의 바랍니다.");
}


// 레벨(권한)이 상품구입 권한보다 작다면 상품을 구입할 수 없음.
if ($member[mb_level] < $default[de_level_sell])
{
    err("상품을 구입할 수 있는 권한이 없습니다.");
}


if ($w == "d") // 삭제이면
{
    $sql = " delete from $g4[yc4_cart_table]
              where ct_id = '$ct_id'
                and on_uid = '$tmp_on_uid' ";
    sql_query($sql);
}
else if ($w == "alldelete") // 모두 삭제이면
{
    $sql = " delete from $g4[yc4_cart_table]
              where on_uid = '$tmp_on_uid' ";
    sql_query($sql);
}
else if ($w == "allupdate") // 수량 변경이면 : 모두 수정이면
{

    $obj = new Yc4();
    $optObj = new Yc4ItemOption();
   
    
    $fldcnt = count($_POST[ct_id]);


    // 수량 변경, 재고등을 검사
    $error = "";
    for ($i=0; $i<$fldcnt; $i++)
    {
        $ct_id = $_POST["ct_id"][$i];
        $ct = $obj->get_cart($ct_id);
    
        if($ct["it_option1"] == "" && $ct["it_option2"] == "" && $ct["it_option3"] == ""){
             // 재고 구함
            $stock_qty = get_it_stock_qty($ct["it_id"], $ct["ct_id"]);

            // 변경된 수량이 재고수량보다 크면 오류
            if ($_POST[ct_qty][$i] > $stock_qty)
                $error .= "{$ct[it_name]} 의 재고수량이 부족합니다. 현재 재고수량 : $stock_qty 개\\n\\n";

        } else {
            
            $stock_qty = $optObj->get_qty($ct["it_id"], $ct["ct_id"], $ct["it_option1"], $ct["it_option2"], $ct["it_option3"]);
             // 변경된 수량이 재고수량보다 크면 오류
             if ($_POST[ct_qty][$i] > $stock_qty)
                $error .= "{$ct[it_name]} 의 재고수량이 부족합니다. 현재 재고수량 : $stock_qty 개\\n\\n";
        }
    }

    // 오류가 있다면 오류메세지 출력
    if ($error != "") { err($error); }

	for ($i=0; $i<$fldcnt; $i++)
    {
        $sql = " update $g4[yc4_cart_table]
                    set ct_qty = '{$_POST[ct_qty][$i]}'
                  where ct_id  = '{$_POST[ct_id][$i]}'
                    and on_uid = '$tmp_on_uid' ";
        sql_query($sql);
    }
}
else if ($w == "multi") // 온라인견적(등)에서 여러개의 상품이 한꺼번에 들어옴.
{
    // 보관함에서 금액이 제대로 반영되지 않던 오류를 수정
    $fldcnt = count($_POST[it_name]);

    // 재고등을 검사
    $error = "";
	for ($i=0; $i<$fldcnt; $i++)
    {
        if ($_POST[it_id][$i] == "" || $_POST[ct_qty][$i] <= 0) { continue; }

        // 비회원가격과 회원가격이 다르다면
        if (!$is_member && $default[de_different_msg])
        {
            $sql = " select it_amount, it_amount2 from $g4[yc4_item_table] where it_id = '{$_POST[it_id][$i]}' ";
            $row = sql_fetch($sql);
            if ($row[it_amount2] && $row[it_amount] != $row[it_amount2]) {
                $error .= "\"{$_POST[it_name][$i]}\" 의 비회원가격과 회원가격이 다릅니다. 로그인 후 구입하여 주십시오.\\n\\n";
            }
        }

        //--------------------------------------------------------
        //  변조 검사
        //--------------------------------------------------------
        $sql = " select * from $g4[yc4_item_table] where it_id = '{$_POST[it_id][$i]}' ";
        $it = sql_fetch($sql);

         $amount = get_amount($it);
        // 상품가격이 다름
        if ((int)$amount !== ((int)$_POST[it_amount][$i] - ((int)$_POST[addamt])))
            die("Error..");

        $point = $it[it_point];
        // 포인트가 다름
        if ((int)$point !== ((int)$_POST[it_point][$i] - (int)$_POST[addpoint]) && $config[cf_use_point])
            die("Error...");
        //--------------------------------------------------------

        // 이미 장바구니에 있는 같은 상품의 수량합계를 구한다.
        $sql = " select SUM(ct_qty) as cnt from $g4[yc4_cart_table] where it_id = '{$_POST[it_id][$i]}' and on_uid = '$tmp_on_uid' ";
        $row = sql_fetch($sql);
        $sum_qty = $row[cnt];

        // 재고 구함
        $it_stock_qty = get_it_stock_qty($_POST[it_id][$i]);
        if ($_POST[ct_qty][$i] + $sum_qty > $it_stock_qty) {
            $error .= "{$_POST[it_name][$i]} 의 재고수량이 부족합니다. 현재 재고수량 : $it_stock_qty\\n\\n";
        }
    }

    // 오류가 있다면 오류메세지 출력
    if ($error != "") { err($error); }

	for ($i=0; $i<$fldcnt; $i++)
    {
        if ($_POST[it_id][$i] == "" || $_POST[ct_qty][$i] <= 0) continue;

        // 포인트 사용하지 않는다면
        if (!$config[cf_use_point]) $_POST[it_point][$i] = 0;

        // 장바구니에 Insert
        $sql = " insert $g4[yc4_cart_table]
                    set on_uid       = '$tmp_on_uid',
                        it_id        = '{$_POST[it_id][$i]}',
                        ct_status    = '쇼핑',
                        ct_amount    = '{$_POST[it_amount][$i]}',
                        ct_point     = '{$_POST[it_point][$i]}',
                        ct_point_use = '0',
                        ct_stock_use = '0',
                        ct_qty       = '{$_POST[ct_qty][$i]}',
                        ct_time      = '$g4[time_ymdhis]',
                        ct_ip        = '$REMOTE_ADDR' ";
        sql_query($sql);
    }
}
else // 장바구니에 담기
{

    if (!$_POST[it_id])
        err("장바구니에 담을 상품을 선택하여 주십시오.");

    if ($_POST[ct_qty] < 1)
        err("수량은 1 이상 입력해 주십시오.");

    // 비회원가격과 회원가격이 다르다면
    if (!$is_member && $default[de_different_msg])
    {
        $sql = " select it_amount, it_amount2 from $g4[yc4_item_table] where it_id = '$_POST[it_id]' ";
        $row = sql_fetch($sql);
        if ($row[it_amount2] && $row[it_amount] != $row[it_amount2]) {
            echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=$g4[charset]\">";
            echo "<script>err('비회원가격과 회원가격이 다릅니다. 로그인 후 구입하여 주십시오.');</script>";
        }
    }

   

	// 바로구매에 있던 장바구니 자료를 지운다.
    $result = sql_query(" delete from $g4[yc4_cart_table] where on_uid = '$tmp_on_uid' and ct_direct = 1 ", false);
    if (!$result) {
        // 삭제중 에러가 발생했다면 필드가 없다는 것이므로 바로구매 필드를 생성한다.
        sql_query(" ALTER TABLE `$g4[yc4_cart_table]` ADD `ct_direct` TINYINT NOT NULL ");
    }


    //장바구니에서 옵션 수정일 경우, 지우고 들어갑니다!
    if($_POST["ct_id"]){ 
        $sql = " delete from $g4[yc4_cart_table]
                where ct_id = '{$_POST["ct_id"]}'
                and on_uid = '$tmp_on_uid' ";
        sql_query($sql);
    }
    
    $sql = " select * from $g4[yc4_item_table] where it_id = '$_POST[it_id]' ";
    $it = sql_fetch($sql);


    $errmsg = "";
    $optObj = new Yc4ItemOption();
    for($idx = 0 ; $idx < count($_POST["it_option1"]); $idx++){ //추가된 상품옵션만큼 Loop

        //--------------------------------------------------------
        //  추가옵션 변조 검사
        //--------------------------------------------------------
        //추가 옵션
        $opt_amount = 0;
        $opt_point = 0;
        for ($i=1; $i<=6; $i++) {
            $dst_opt = trim($_POST["it_opt".$i][$idx]);
            if ($dst_opt) {
                $org_opt = $it["it_opt".$i];
                $exp_opt = explode("\n", trim($org_opt));
                $exists = false;
                for ($k=0; $k<count($exp_opt); $k++) {
                    $opt = trim($exp_opt[$k]);
                    if ($dst_opt == $opt) {
                        $exists = true;
                        $exp_option = explode(";", $opt);
                        $opt_amount += (int)$exp_option[1];
                        $opt_point += (int)$exp_option[2];
                        break;
                    }
                }
                if ($exists == false) {
                    // 옵션이 다름
                    die("Error.");
                }
            }
        }

        $point = $it[it_point] + $opt_point;
        //--------------------------------------------------------



        //선택 옵션
        $type1 = $_POST["it_option1"][$idx];
        $type2 = $_POST["it_option2"][$idx];
        $type3 = $_POST["it_option3"][$idx];
        $io_amt = $_POST["io_amt"][$idx];
        $io_point = $_POST["io_point"][$idx];
        $qty = $_POST["ct_qty"][$idx];
        

        $amount = get_amount($it);

        $io_amt = 0; //상품 선택옵션 가격

        if($type1 != "" || $type2 != "" || $type3 != "") {
            $optInfo = $optObj->get_option($_POST["it_id"], $type1, $type2, $type3, $sw_direct ? true : false);
            $io_amt = $optInfo["io_amt"];
            $io_point = ($member["mb_id"] ? $optInfo["io_point"] : 0);
        
            //옵션 수량
            $opt_qty = $optObj->get_qty($_POST["it_id"],"", $type1, $type2, $type3, $sw_direct ? true : false);
            $strOpt = "";
            if($qty > $opt_qty) {
                $strOpt = $type1;
                if($type2 != "") $strOpt .= " / ". $type2;
                if($type3 != "") $strOpt .= " / ". $type3;
                $errmsg .= "{$strOpt} 상품의 재고가 부족하여 장바구니에 담지 못하였습니다.\\n";
                continue;
            }
        } else {
            
            // 상품에 대한 현재고수량
            $it_stock_qty = (int)get_it_stock_qty($_POST[it_id], "", $sw_direct ? true : false);
            if($qty > $it_stock_qty) {
                $errmsg .= "{$it[it_name]} 상품의 재고가 부족하여 장바구니에 담지 못하였습니다.\\n\\n현재 재고수량 : " . number_format($it_stock_qty) . " 개";
                continue;
            }

        }
        

        
        $amount =	($amount+$opt_amount+$io_amt);
		$point = ($point+$opt_point+$io_point);

        
        // 포인트 사용하지 않는다면
        if (!$config[cf_use_point]) { $point = 0; }


        $ctid_query= "";
        if($_POST["ct_id"] && $idx == 0) {
            $ctid_query = "ct_id = '{$_POST["ct_id"]}', ";
        }

        // 장바구니에 Insert
        $sql = " insert $g4[yc4_cart_table]
                    set 
                        on_uid       = '$tmp_on_uid',
                        it_id        = '$_POST[it_id]',
                        {$ctid_query}
                        it_opt1      = '{$_POST[it_opt1][$idx]}',
                        it_opt2      = '{$_POST[it_opt2][$idx]}',
                        it_opt3      = '{$_POST[it_opt3][$idx]}',
                        it_opt4      = '{$_POST[it_opt4][$idx]}',
                        it_opt5      = '{$_POST[it_opt5][$idx]}',
                        it_opt6      = '{$_POST[it_opt6][$idx]}',
                        it_option1 = '$type1',
                        it_option2 = '$type2',
                        it_option3 = '$type3',
                        it_option_amount = '$io_amt',
                        ct_status    = '쇼핑',
                        ct_amount    = '$amount',
                        ct_point     = '$point',
                        ct_point_use = '0',
                        ct_stock_use = '0',
                        ct_qty       = '$qty',
                        ct_time      = '$g4[time_ymdhis]',
                        ct_ip        = '$REMOTE_ADDR',
                        ct_direct    = '$sw_direct' ";
        sql_query($sql);

    }

    if($errmsg != "") err($errmsg);

}

// 바로 구매일 경우
if ($sw_direct)
{
    if ($member[mb_id])
    {
    	goto_url("./orderform.php?sw_direct=$sw_direct");
    }
    else
    {
    	goto_url("$g4[bbs_path]/login.php?url=".urlencode("$g4[shop_path]/orderform.php?sw_direct=$sw_direct"));
    }
}
else
{
    goto_url("./cart.php?ctu=".md5(date("YmdHi")));
}