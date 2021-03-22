<?
include_once("_common.php");

$fcmID = get_session("fcm_id");

$field = $_REQUEST[field];
$value = $_REQUEST[value];

$result = sql_query(" UPDATE helper_analytics_config SET $field='$value' WHERE fcm_id='$fcmID' ", FALSE);

echo "{\"result\":\"".($result ? "true" : "false")."\"}";