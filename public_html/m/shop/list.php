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
?>


<style>
.cartBtn {background:#4b4b4b;color:#ffffff;padding:5px 8px;line-height:30px;border:1px solid #1b1b1b;font-size:16px;}
.cartBtn:hover {background:#ffffff;color:#000000;padding:5px 8px;line-height:30px;border:1px solid #1b1b1b;font-size:16px;}
.shop_btns a:hover {text-decoration:none;}

.shop_page { clear:both; text-align:center; margin:20px 0 30px 0; display:inline-block; width:100%; font-size:0px; }
.shop_page a { display:inline-block; vertical-align:middle; text-decoration:none; margin:0 3px; }
.shop_page a.page_text { color:#999898; font-size:16px; margin:0 10px; }
.shop_page a.now_on_page { color:#e30413; }
.shop_page .page_bg1 { background:#919191; border:1px solid #ddd; }
.shop_page .page_bg2 { background:#e30413; border:1px solid #ddd; }
.shop_page .page_bg1 img { display:block; }
.shop_page .page_bg2 img { display:block; }
</style>


<?
// 상단 HTML
if(trim(str_replace("&nbsp;", "", strip_tags($ca[ca_head_html], "<img>"))) != ""){
    echo stripslashes($ca[ca_head_html]); 
}

 
if ($is_admin) {
    echo "<p align=center class='shop_btns' style='margin:-20px 0 20px;'><a href='$g4[shop_admin_path]/categoryform.php?w=u&ca_id=$ca_id'><span class='cartBtn'>&nbsp;&nbsp;관리자 화면에서 수정하기&nbsp;&nbsp;</span></a></p>";
}
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
$list_file = "$g4[shop_mpath]/$ca[ca_skin]";
if (file_exists($list_file)) {

    //display_type(2, "maintype10.inc.php", 4, 2, 100, 100, $ca[ca_id]);

    $list_mod   = $ca[ca_list_mod];
    $list_row   = $ca[ca_list_row];
    $img_width  = $ca[ca_img_width];
    $img_height = $ca[ca_img_height];

    include "$g4[shop_mpath]/list.sub.php";
    include "$g4[shop_mpath]/list.sort.php";

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
$shop_pages = get_paging2($config[cf_write_pages], $page, $total_page, "$_SERVER[PHP_SELF]?$qstr1&page=");
?>

<!-- 페이지 -->
<div class="Boardpage linkpage" style="margin:0;" >
	<table cellspacing="3" cellpadding="0" class="t6" style='margin:0 auto;' >
		<colgroup>
			<col />
			<col />
			<col />
			<col />
			<col />
			<col />
			<col />
			<col />
			<col />
		</colgroup>
		<tbody>
			<tr>
				<?=$shop_pages?>
			</tr>
		</tbody>
	</table>
</div>


<?
// 하단 HTML
if(trim(str_replace("&nbsp;", "", strip_tags($ca[ca_tail_html], "<img>"))) != ""){
    echo stripslashes($ca[ca_tail_html]); 
}


$timg = "$g4[path]/data/category/{$ca_id}_t";
if (file_exists($timg))
    echo "<br><img src='$timg' border=0>";

if ($ca[ca_include_tail])
    @include_once($ca[ca_include_tail]);
else
    include_once("./_tail.php");

echo "\n<!-- $ca[ca_skin] -->\n";
?>
