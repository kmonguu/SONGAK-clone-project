<?
include_once("_common2.php");
header("content-type:text/html; charset=utf-8");


//#############################################################
//FCM해제
//다른 사이트로의 로그인이 확인된 경우 호출됩니다. 
//호출위치 http://it9.co.kr/api/helper/pushid.php

$ss_fcmId = $_REQUEST["fcm_id"];
if($ss_fcmId) sql_query(" delete from helper_push_id where fcm_id='$ss_fcmId' ");


