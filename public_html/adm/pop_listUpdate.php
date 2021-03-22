<?
$sub_menu = "400800";
include_once("./_common.php");
auth_check($auth[$sub_menu], "w");

// 판매가격 일괄수정
for ($i=0; $i<count($_POST[pop_no]); $i++)
{
    $sql = "update g4_popup
			set 
					pop_nm          = '{$_POST[pop_nm][$i]}',
					pop_type          = '{$_POST[pop_type][$i]}',
					pop_top          = '{$_POST[pop_top][$i]}',
					pop_left       = '{$_POST[pop_left][$i]}',
					pop_iscenter    = '{$_POST[pop_iscenter][$i]}',
					pop_link          = '{$_POST[pop_link][$i]}',
					pop_link_type         = '{$_POST[pop_link_type][$i]}',
					pop_sdate          = '{$_POST[pop_sdate][$i]}',
					pop_edate         = '{$_POST[pop_edate][$i]}'
             where pop_no   = '{$_POST[pop_no][$i]}' ";
    sql_query($sql);

}

goto_url("./pop_list.php?sca=$sca&sst=$sst&sod=$sod&sfl=$sfl&stx=$stx&page=$page");
?>
