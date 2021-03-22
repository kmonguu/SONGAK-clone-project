<?
include_once("./_common.php");

$sql = " select *
           from $g4[yc4_category_table]
          where ca_id = '$ca_id'
            and ca_use = '1'  ";
$ca = sql_fetch($sql);
if (!$ca[ca_id])
    alert("등록된 분류가 없습니다.");

$g4[title] = $ca[ca_name] . " 상품리스트";

if ($ca[ca_include_head])
    @include_once($ca[ca_include_head]);
else
    include_once("./_head.php");


//상품에서 목록보기로 이동할 ca_id 저장
set_session("ss_ca_id", $ca_id);

// 스킨을 지정했다면 지정한 스킨을 사용함 (스킨의 다양화)
//if ($skin) $ca[ca_skin] = $skin;

//$nav_ca_id = $ca_id;
//include "$g4[shop_path]/navigation1.inc.php";

//$himg = "$g4[path]/data/category/{$ca_id}_h";
//if (file_exists($himg)) {
//    echo "<img src='$himg' border=0><br>";
//}

// 상단 HTML
echo stripslashes($ca[ca_head_html]);
?>



<? 
if ($is_admin) {
    echo "<p align=center class='shop_btns'><a href='$g4[shop_admin_path]/categoryform.php?w=u&ca_id=$ca_id'><span class='cartBtn'>&nbsp;&nbsp;관리자 화면에서 수정하기&nbsp;&nbsp;</span></a></p>";
}
//include "$g4[shop_path]/listcategory2.inc.php";
?>

<table width=100% cellpadding=0 cellspacing=0>
    <tr>
        <td>

<?
// 상품 출력순서가 있다면
if ($sort != "") {
    if(!sql_xss_check($sort)) {
		$order_by = $sort . " , ";
	}
}

// 상품 (하위 분류의 상품을 모두 포함한다.)
$sql_list1 = " select * ";
$sql_list2 = " order by $order_by it_order, it_id desc ";

// 하위분류 포함
// 판매가능한 상품만
$sql_common = " from $g4[yc4_item_table]
               where (ca_id like '{$ca_id}%'
                   or ca_id2 like '{$ca_id}%'
                   or ca_id3 like '{$ca_id}%')
                 and it_use = '1' ";

$error = "<img src='$g4[shop_img_path]/no_item.gif' border=0>";

// 리스트 유형별로 출력
$list_file = "$g4[shop_path]/$ca[ca_skin]";
if (file_exists($list_file)) {

    //display_type(2, "maintype10.inc.php", 4, 2, 100, 100, $ca[ca_id]);

    $list_mod   = $ca[ca_list_mod];
    $list_row   = $ca[ca_list_row];
    $img_width  = $ca[ca_img_width];
    $img_height = $ca[ca_img_height];

    include "$g4[shop_path]/list.sub.php";
    include "$g4[shop_path]/list.sort.php";

    $sql = $sql_list1 . $sql_common . $sql_list2 . " limit $from_record, $items ";
    $result = sql_query($sql);

    include $list_file;

}
else
{

    $i = 0;
    $error = "<p>$ca[ca_skin] 파일을 찾을 수 없습니다.<p>관리자에게 알려주시면 감사하겠습니다.";

}

if ($i==0)
{
    echo "<br>";
    echo "<div align=center>$error</div>";
}
?>

        </td>
    </tr>
</table>


<?
$qstr1 .= "ca_id=$ca_id&skin=$skin&ev_id=$ev_id&sort=$sort";
$shop_pages = get_paging3($config[cf_write_pages], $page, $total_page, "$_SERVER[PHP_SELF]?$qstr1&page=");
?>
<!-- 페이지 -->
<div class="shop_page">
	<? if ($prev_part_href && false) { echo "<a href='$prev_part_href'><img src='$board_skin_path/img/page_search_prev.gif' border='0' align=absmiddle title='이전검색'></a>"; } ?>
	<?
	// 기본으로 넘어오는 페이지를 아래와 같이 변환하여 이미지로도 출력할 수 있습니다.
	//echo $shop_pages;
	$shop_pages = str_replace("처음", "<div class='page_bg1' ><img src='/img/page_first.png' /></div>", $shop_pages);
	$shop_pages = str_replace("이전", "<div class='page_bg2' ><img src='/img/page_prev.png' /></div>", $shop_pages);
	$shop_pages = str_replace("다음", "<div class='page_bg2' ><img src='/img/page_next.png' /></div>", $shop_pages);
	$shop_pages = str_replace("맨끝", "<div class='page_bg1' ><img src='/img/page_last.png' /></div>", $shop_pages);
	//$shop_pages = preg_replace("/<span>([0-9]*)<\/span>/", "$1", $shop_pages);
	$shop_pages = preg_replace("/<b>([0-9]*)<\/b>/", "<span>$1</span>", $shop_pages);
	?>
	<b><?=$shop_pages?></b>
	<? if ($next_part_href && false) { echo "<a href='$next_part_href'><img src='$board_skin_path/img/page_search_next.gif' border='0' align=absmiddle title='다음검색'></a>"; } ?>
</div>


<?
// 하단 HTML
echo stripslashes($ca[ca_tail_html]);

$timg = "$g4[path]/data/category/{$ca_id}_t";
if (file_exists($timg))
    echo "<br><img src='$timg' border=0>";

if ($ca[ca_include_tail])
    @include_once($ca[ca_include_tail]);
else
    include_once("./_tail.php");

echo "\n<!-- $ca[ca_skin] -->\n";
?>
