<?
$sub_menu = "300100";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "w");

check_token();



function isField($table, $searchField) {
$sql = "SHOW COLUMNS FROM $table LIKE '".$searchField."'";
$result = mysql_query($sql);
if (mysql_num_rows($result)) return true;
else return false;
} // function 


$has_push_field = false;
if(isField($g4[board_table], "bo_use_pushmsg")){
	$has_push_field = true;
}

for ($i=0; $i<count($chk); $i++) 
{
    // 실제 번호를 넘김
    $k = $chk[$i];

    if ($is_admin != "super")
    {
        $sql = " select count(*) as cnt from $g4[board_table] a, $g4[group_table] b
                  where a.gr_id = '{$_POST['gr_id'][$k]}' 
                    and a.gr_id = b.gr_id 
                    and b.gr_admin = '$member[mb_id]' ";
        $row = sql_fetch($sql);
        if (!$row[cnt])
            alert("최고관리자가 아닌 경우 다른 관리자의 게시판($board_table[$k])은 수정이 불가합니다.");
    }
	



	$use_push ="";
	if($has_push_field) {
		$use_push = " bo_use_pushmsg       = '{$_POST['bo_use_pushmsg'][$k]}', ";
	}


    $sql = " update $g4[board_table]
                set gr_id               = '{$_POST['gr_id'][$k]}',
                    bo_subject          = '{$_POST['bo_subject'][$k]}',
                    bo_skin             = '{$_POST['bo_skin'][$k]}',
                    bo_read_point       = '{$_POST['bo_read_point'][$k]}',
                    bo_write_point      = '{$_POST['bo_write_point'][$k]}',
                    bo_comment_point    = '{$_POST['bo_comment_point'][$k]}',
                    bo_download_point   = '{$_POST['bo_download_point'][$k]}',
                    bo_use_search       = '{$_POST['bo_use_search'][$k]}',
					{$use_push}
                    bo_order_search     = '{$_POST['bo_order_search'][$k]}'
              where bo_table            = '{$_POST['board_table'][$k]}' ";
    sql_query($sql);
}

goto_url("./board_list.php?$qstr");
?>
