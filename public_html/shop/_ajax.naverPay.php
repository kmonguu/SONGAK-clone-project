<?
include_once("./_common.php");

if($on_uid) $_SESSION['naverPay']['on_uid'] = $on_uid;
else{
	$_SESSION['naverPay']['it_id'] = $it_id;
	$_SESSION['naverPay']['ct_qty'] = $ct_qty;
	$_SESSION['naverPay']['it_opt1'] = $it_opt1;
	$_SESSION['naverPay']['it_opt2'] = $it_opt2;
	$_SESSION['naverPay']['it_opt3'] = $it_opt3;
	$_SESSION['naverPay']['it_opt4'] = $it_opt4;
	$_SESSION['naverPay']['it_opt5'] = $it_opt5;
	$_SESSION['naverPay']['it_opt6'] = $it_opt6;
}

$_SESSION['naverPay']['is_mobile'] = $is_mobile;

//print_r($_SESSION['naverPay']);
exit;
?>
