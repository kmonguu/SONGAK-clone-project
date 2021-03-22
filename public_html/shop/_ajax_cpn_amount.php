<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

$obj = new Yc4Coupon();

echo $obj->cal_cpn_amount($cpn_id, $ct_id);
