<?
include_once("./_common.php");
include_once("$g4[path]/lib/visit.lib.php");

$colspan = 4;
?>


<table width=100% cellpadding=0 cellspacing=1 border=0 class="list02">
<colgroup width=100>
<colgroup width=100>
<colgroup width=100>
<colgroup width=''>

<tr class='bgcol1 bold col1 ht center'>
    <td>년-월-일</td>
    <td>방문자수</td>
    <td>비율(%)</td>
    <td>그래프</td>
</tr>

<?

$mQuery = "vs_count";
if($md == "p"){
	$mQuery = "vs_pc";
} else if ($md == "m") {
	$mQuery = "vs_mobile";
}


$max = 0;
$sum_count = 0;
$sql = " select vs_date, $mQuery as cnt 
           from $g4[visit_sum_table]
          where vs_date between '$fr_date' and '$to_date'
          order by vs_date desc ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $arr[$row[vs_date]] = $row[cnt];

    if ($row[cnt] > $max) $max = $row[cnt];

    $sum_count += $row[cnt];
}

$i = 0;
$k = 0;
$save_count = -1;
$tot_count = 0;
if (count($arr)) {
    foreach ($arr as $key=>$value) {
        $count = $value;

        $rate = ($count / $sum_count * 100);
        $s_rate = number_format($rate, 1);

        $bar = (int)($count / $max * 100);
        $graph = "<img src='{$g4[admin_path]}/img/graph.gif' width='$bar%' height='18'>";

        $list = ($k++%2);
        echo "
        <tr class='list$list ht center'>
            <td><a href='./visit_list.php?fr_date=$key&to_date=$key' class=tt>$key</a></td>
            <td>".number_format($value)."</td>
            <td>$s_rate</td>
            <td align=left>$graph</td>
        </tr>";
    }

    echo "

    <tr class='bgcol2 bold col1 ht center'>
        <td>합계</td>
        <td>".number_format($sum_count)."</td>
        <td colspan=2>&nbsp;</td>
    </tr>";
} else {
    echo "<tr><td colspan='$colspan' height=100 align=center>자료가 없습니다.</td></tr>";
}
?>

</table>