<?
include_once("./_common.php");

$pageNum = 100;
$subNum = 18;

if (!$is_member)
    goto_url("$g4[bbs_path]/login.php?url=".urlencode("$g4[shop_path]/wishlist.php"));

$g4[title] = "보관함";
include_once("./_head.php");
?>


<style>
.wishlist_title {background-color:#efefef;}
.wishlist_title td {font-size:13px; font-weight:bold; padding:10px 5px;}
</style>

<form name=fwishlist method=post action="" style="padding:0px;">
<input type=hidden name=w         value="multi">
<input type=hidden name=sw_direct value=''>
<input type=hidden name=prog      value='wish'>

<table width=100% align=center cellpadding=0 cellspacing=0>
<colgroup>
    <col width="120"/>
    <col width=""/>
    <col width="150"/>
    <col width="120"/>
    <col width="120"/>
</colgroup>
<tr><td colspan=6 height=2 class=c1></td></tr>
<tr align=center class="c2 wishlist_title" >
    <td colspan=2>상품명</td>
    <td>보관일시</td>
    <td>장바구니</td>
    <td>삭제</td>
</tr>
<tr><td colspan=6 height=1 class=c1></td></tr>
<?
$sql = " select * 
           from $g4[yc4_wish_table] a, 
                $g4[yc4_item_table] b
          where a.mb_id = '$member[mb_id]'
            and a.it_id  = b.it_id
          order by a.wi_id desc ";
$result = sql_query($sql);
for ($i=0; $row = mysql_fetch_array($result); $i++) {

    $out_cd = "";
    for($k=1; $k<=6; $k++){
        $opt = trim($row["it_opt{$k}"]);
        if(preg_match("/\n/", $opt)||preg_match("/;/" , $opt)) {
            $out_cd = "no";
            break;
        }
    }

    $it_amount = get_amount($row);

    if ($row[it_tel_inq]) $out_cd = "tel_inq";

    if ($i > 0)
        echo "<tr><td colspan=20 height=1 background='$g4[shop_img_path]/dot_line.gif'></td></tr>\n";

    $image = get_it_image($row[it_id]."_s", 50, 50, $row[it_id]);

    $s_del = "<a href='./wishupdate.php?w=d&wi_id=$row[wi_id]'><img src='$g4[shop_img_path]/btn_del.gif' border='0' align=absmiddle alt='삭제'></a>";

    echo "<tr>\n";
    echo "<td align=center style='padding-top:5px; padding-bottom:5px;'>$image</td>\n";
    echo "<td><a href='./item.php?it_id=$row[it_id]'>".stripslashes($row[it_name])."</a></td>\n";
    echo "<td align=center>$row[wi_time]</td>\n";
    echo "<td align=center>";
    echo " <a href=\"javascript:open_fixed_layer('{$g4["shop_path"]}/item_popup.php?it_id={$row[it_id]}', 600)\"><span class='btn1'> <i class='fas fa-cart-plus'></i> 장바구니 담기</span></a>";
    echo "</td>\n";
    echo "<td align=center>$s_del</td>\n";
    echo "</tr>\n";
}

if ($i == 0)
    echo "<tr><td colspan=20 align=center height=100><span class=point>보관함이 비었습니다.</span></td></tr>\n";
?>
</tr>
<tr><td colspan=6 height=1 class=c1></td></tr>
</table><br>
</form>



<?
include_once("./_tail.php");
?>