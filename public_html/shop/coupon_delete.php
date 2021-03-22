<?
include_once("./_common.php");

$obj = new Yc4Coupon();


$qstr = "page=$page&sfl=$sfl&stx=$stx&sod=$sod&sst=$sst";


$obj->delete($cpn_id);


goto_url("/shop/coupon.php?$qstr");