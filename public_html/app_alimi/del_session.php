<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

session_unset(); // 모든 세션변수를 언레지스터 시켜줌
session_destroy(); // 세션해제함