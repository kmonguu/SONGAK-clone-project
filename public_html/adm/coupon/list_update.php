<?
$sub_menu = "200300";
include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

check_token();

$obj = new Yc4Coupon();

if ($member[mb_password] != sql_password($_POST['admin_password'])) {
    alert("패스워드가 다릅니다.");
}

//$mb_id      = $_POST['mb_id'];
$cpn_name   = $_POST['cpn_name'];
$cpn_type	= $_POST['cpn_type'];
$cpn_amt	= $_POST['cpn_amt'];
$cpn_start	= $_POST['cpn_start'];
$cpn_end	= $_POST['cpn_end'];


$dupMsg = "";
for($idx = 0 ; $idx < count($_POST["mb_ids"]) ; $idx++){
	
    $result = $obj->create_coupon($_POST["mb_ids"][$idx], $cpn_name, $cpn_start, $cpn_end, $cpn_type, $cpn_amt);

    if($result == "DUP") {
        if($dupMsg != "")  { 
            $dupMsg .= "\\n";
        } else {
            $dupMsg .= "같은 이름의 쿠폰이 이미 발급되어있어, 발급이 실패하였습니다.\\n";
        }
        $dupMsg .= "ID : {$_POST["mb_ids"][$idx]} ";
    }
    
}


if($dupMsg != "") {
    alert($dupMsg, "./list.php?$qstr");
}

goto_url("./list.php?$qstr");