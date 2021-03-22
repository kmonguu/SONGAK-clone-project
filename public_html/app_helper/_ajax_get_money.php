<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

if($member["mb_id"] == "") exit;
$moneyObj = new Money();
$money = $moneyObj->get_money( $member["is_car"] ? $member["p_mb_id"] : $member["mb_id"] );

echo $money;