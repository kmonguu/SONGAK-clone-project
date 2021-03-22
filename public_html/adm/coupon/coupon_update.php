<?
$sub_menu = "200300";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

check_token();

$obj = new Yc4Coupon();

if ($member[mb_password] != sql_password($_POST['admin_password'])) {
    alert("패스워드가 다릅니다.");
}

$mb_id      = $_POST['mb_id'];
$cpn_name   = $_POST['cpn_name'];
$cpn_type	= $_POST['cpn_type'];
$cpn_amt	= $_POST['cpn_amt'];
$cpnt_start	= $_POST['cpnt_start'];
$cpn_end	= $_POST['cpn_end'];

$mb = get_member($mb_id);

if (!$mb[mb_id])
    alert("존재하는 회원아이디가 아닙니다.", "./list.php?$qstr"); 


$result = $obj->create_coupon($mb_id, $cpn_name, $cpnt_start, $cpn_end, $cpn_type, $cpn_amt);


if($result == "OK"){
	$qstr .= "&sch_site=$sch_site";
	goto_url("./list.php?$qstr");
} else {
	if($result == "DUP"){
		alert("이미 같은쿠폰이 존재합니다.");

		$qstr .= "&sch_site=$sch_site";
		goto_url("./list.php?$qstr");
	}
}
?>
