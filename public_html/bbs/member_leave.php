<?
include_once("./_common.php");

if (!$member[mb_id]) 
    alert("회원만 접근하실 수 있습니다.");

if ($is_admin == "super") 
    alert("최고 관리자는 탈퇴할 수 없습니다"); 


if(!$member["mb_is_naver"] && !$member["mb_is_kakao"] && !$member["mb_is_facebook"]) {
    if (!($_POST[mb_password] && $member[mb_password] == sql_password($_POST[mb_password])))
        alert("패스워드가 틀립니다.");
}


if($member["mb_is_naver"] || $member["mb_is_kakao"] || $member["mb_is_facebook"]){  //API  ID로 회원가입일경우 완전 삭제
	
	$mb_id = $member[mb_id];
	// 회원 자료 삭제
	sql_query(" delete from $g4[member_table] where mb_id = '$mb_id' ");

	// 포인트 테이블에서 삭제
	sql_query(" delete from $g4[point_table] where mb_id = '$mb_id' ");
	
	// 그룹접근가능 삭제
	sql_query(" delete from $g4[group_member_table] where mb_id = '$mb_id' ");
	
	// 쪽지 삭제
	sql_query(" delete from $g4[memo_table] where me_recv_mb_id = '$mb_id' or me_send_mb_id = '$mb_id' ");
	
	// 스크랩 삭제
	sql_query(" delete from $g4[scrap_table] where mb_id = '$mb_id' ");
	
	// 관리권한 삭제
	sql_query(" delete from $g4[auth_table] where mb_id = '$mb_id' ");

	// 그룹관리자인 경우 그룹관리자를 공백으로 
	sql_query(" update $g4[group_table] set gr_admin = '' where gr_admin = '$mb_id' ");

	// 게시판관리자인 경우 게시판관리자를 공백으로
	sql_query(" update $g4[board_table] set bo_admin = '' where bo_admin = '$mb_id' ");

	// 아이콘 삭제
	@unlink("$g4[path]/data/member/".substr($mb_id,0,2)."/$mb_id.gif");

} else {

	// 회원탈퇴일을 저장, 회원레벨 1로 변경
	$date = date("Ymd");
	$sql = " update $g4[member_table] set mb_level=1, mb_leave_date = '$date' where mb_id = '$member[mb_id]' ";
	sql_query($sql);

}

// 3.09 수정 (로그아웃)
session_unregister("ss_mb_id");

if (!$url) 
    $url = $g4[path]; 

alert("{$member[mb_nick]}님께서는 " . date("Y년 m월 d일") . "에 회원에서 탈퇴 하셨습니다.", $url);
?>
