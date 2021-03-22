<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once("$g4[path]/shop.config.php");
include_once("$g4[path]/lib/shop.lib.php");

//==============================================================================
// 쇼핑몰 필수 실행코드 모음 시작
//==============================================================================
// 쇼핑몰 설정값 배열변수
$default = sql_fetch(" select * from $g4[yc4_default_table] ");

if(!USE_NAVERPAY) { //config.php?
    $default["de_npay_use"] = 0;
}

$i = 0;
do {
    // 프로그램 전반에 걸쳐 사용하는 유일한 키 (장바구니 키)
    $on_uid_key = get_session("ss_on_uid");
    if (!$on_uid_key) {
        set_session("ss_on_uid", $on_uid_key = get_unique_id());
    }


    //회원으로 로그인된 경우 장바구니키를 아이디로 넣음 ({m}/shop/orderupdate.php에서 주문등록 시 유니크 키로 변경)
	if($member["mb_id"]){

		if($on_uid_key != $member["mb_id"]) {//첫 로그인시에만 실행
			$tmp_on_uid_key = $on_uid_key;
			$on_uid_key = $member["mb_id"];
			set_session("ss_on_uid", $on_uid_key);
			
			//비회원 장바구니 키로 들어가있는 장바구니상품을 회원ID 장바구니로 변경
			$sql = "UPDATE {$g4["yc4_cart_table"]} SET on_uid='{$on_uid_key}' WHERE on_uid='{$tmp_on_uid_key}' ";
			sql_query($sql);
		}

	}


    // 프로그램 전반에 걸쳐 사용하는 유일한 키 (바로구매 키)
    $on_direct_key = get_session("ss_on_direct");
    if (!$on_direct_key) {
        set_session("ss_on_direct", $on_direct_key = get_unique_id());
    }

    // 장바구니와 바로구매 키가 같다면 삭제하고 다시 돈다.
    // 10 회를 초과 했다면 에러메세지를 출력한다.
    if ($on_uid_key == $on_direct_key) {
        set_session("ss_on_uid", "");
        set_session("ss_on_direct", "");

        if ($i++ > 10) {
            die("ss_on_uid session key error");
        }
    }
    else {
        break;
    }
} while (1); 
//==============================================================================
// 쇼핑몰 필수 실행코드 모음 끝
//==============================================================================
?>