<?
include_once("./_common.php");
include_once("$g4[path]/lib/visit.lib.php");
?>


<table width=100% cellpadding=0 cellspacing=1 border=0 class="list02">
<colgroup width=100>
<colgroup width=200>
<colgroup width=100>
<colgroup width=100>
<colgroup width=''>
<tr class='bgcol1 bold col1 ht center'>
    <td>순위</td>
    <td>접속 도메인</td>
    <td>방문자수</td>
    <td>비율(%)</td>
    <td>그래프</td>
</tr> 
<?

$mQuery = "";
if($md == "p"){
	$mQuery = " is_mobile != 'Y'  AND ";
} else if ($md == "m") {
	$mQuery = " is_mobile = 'Y' AND ";
}




$max = 0;
$sum_count = 0;
$sql = " select * from $g4[visit_table]
          where $mQuery vi_date between '$fr_date' and '$to_date' ";
$result = sql_query($sql);
while ($row=sql_fetch_array($result)) {
    $str = $row[vi_referer];
    preg_match("/^http[s]*:\/\/([\.\-\_0-9a-zA-Z]*)\//", $str, $match);
    $s = $match[1];
    $s = preg_replace("/^(www\.|search\.|dirsearch\.|dir\.search\.|dir\.|kr\.search\.|myhome\.)(.*)/", "\\2", $s);
    $arr[$s]++;

    if ($arr[$s] > $max) $max = $arr[$s];

    $sum_count++;
}

$i = 0;
$k = 0;
$save_count = -1;
$tot_count = 0;
if (count($arr)) {
    arsort($arr);
    foreach ($arr as $key=>$value) {
        $count = $arr[$key];
        if ($save_count != $count) {
            $i++;
            $no = $i;
            $save_count = $count;
        } else {
            $no = "";
        }

        if (!$key) {
            $link = "";
            $key = "직접"; 
        } else {
            $link = "<a href='./visit_list.php?$qstr&domain=$key' title='상세보기'>";
        }

        $rate = ($count / $sum_count * 100);
        $s_rate = number_format($rate, 1);

        $bar = (int)($count / $max * 100);
        $graph = "<img src='{$g4[admin_path]}/img/graph.gif' width='$bar%' height='18'>";

        $list = ($k++%2);
        echo "
        <tr class='list$list ht center'>
            <td>$no</td>
            <td align=left>$link$key</a></td>
            <td>$count</td>
            <td>$s_rate</td>
            <td align=left>$graph</td>
        </tr>";
    }

    echo "
   
    <tr class='bgcol2 bold col1 ht center'>
        <td colspan=2>합계</td>
        <td>$sum_count</td>
        <td colspan=2>&nbsp;</td>
    </tr>";
} else {
    echo "<tr><td colspan='$colspan' height=100 align=center>자료가 없습니다.</td></tr>";
}
?>

</table>