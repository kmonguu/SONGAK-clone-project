<?
include_once("./_common.php");

set_session("alimi_save_page", $_GET["save_page"]);
set_session("alimi_save_sc", $_GET["save_sc"]);


if($bo_table == "shop_order") { //영카트 주문

    include_once($g4["mpath"]."/include/2_2_1_1_view_shop.php"); //영카트 주문

} else {

    include $g4["mpath"]."/bbs/view.php";

    if(!$view["wr_id"]){
        alert("삭제된 게시글입니다.");
    }

    //읽음표시
    $hpBdObj = new HpBoard();
    $hpBdObj->update_is_read($wr_id, $bo_table);


    // 수정, 삭제 링크
    $update_href = $delete_href = "";

    $qstr .= "&save_sc=$save_sc&save_page=$save_page";

    if ($is_admin) {
        //$update_href = "javascript:go_link_page('p=1_3_1_1&w=u&bo_table=$bo_table&wr_id=$wr_id&page=$page" . $qstr."')";
        $update_href = "./pages.php?p=2_3_1_1&w=u&bo_table=$bo_table&wr_id=$wr_id&page=$page" . $qstr;
        $reply_href = "./pages.php?p=2_3_1_1&w=r&bo_table=$bo_table&wr_id=$wr_id" . $qstr;
        $delete_href = "javascript:del('$g4[mpath]/bbs/delete.php?p=2_1_1_1&bo_table=$bo_table&wr_id=$wr_id&page=$page".urldecode($qstr)."&mobile=true');";
        
        if ($is_admin)
        {
            set_session("ss_delete_token", $token = uniqid(time()));
            $delete_href = "javascript:del('$g4[mpath]/bbs/delete.php?p=2_1_1_1&bo_table=$bo_table&wr_id=$wr_id&token=$token&page=$page".urldecode($qstr)."&mobile=true');";
        }
    }


    if($bo_table)
        $bd = sql_fetch("SELECT * FROM g4_board WHERE bo_table='$bo_table'"); //게시판 스킨명
        
    if($bd[bo_skin] == "reservation_white" || $bd[bo_skin] =="reservation_black"  || $bd[bo_skin] =="inquiry_white2"  || $bd[bo_skin] =="inquiry_white" || $bd[bo_skin] =="inquiry_black"  || $bd[bo_skin] =="inquiry_black2" )
            include_once($g4["mpath"]."/include/2_2_1_1_view_r1.php"); //게시판 뷰 (예약게시판)
        else if($bd[bo_skin] == "reserve_white" || $bd[bo_skin] =="reserve_black" )
            include_once($g4["mpath"]."/include/2_2_1_1_view_r2.php"); //게시판 뷰 (호텔용예약게시판)
        else if($bd[bo_skin] == "reserve_phone" )
            include_once($g4["mpath"]."/include/2_2_1_1_view_r3.php"); //게시판 뷰 (연락처 및 상태)
        else
            include_once($g4["mpath"]."/include/2_2_1_1_view.php"); //게시판 뷰 (호텔용예약게시판)

}