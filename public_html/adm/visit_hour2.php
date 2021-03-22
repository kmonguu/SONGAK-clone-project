<?
include_once("./_common.php");
include_once("$g4[path]/lib/visit.lib.php");
?>

<table width=100% cellpadding=0 cellspacing=1 border=0 class="list02">
<colgroup width=100>
<colgroup width=100>
<colgroup width=100>
<colgroup width=''>
<tr class='bgcol1 bold col1 ht center'>
    <td>시간</td>
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
$sql = " select SUBSTRING(vi_time,1,2) as vi_hour, count(vi_id) as cnt 
           from $g4[visit_table]
          where $mQuery  vi_date between '$fr_date' and '$to_date'
          group by vi_hour
          order by vi_hour ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $arr[$row[vi_hour]] = $row[cnt];

    if ($row[cnt] > $max) $max = $row[cnt];

    $sum_count += $row[cnt];
}

$k = 0;
if ($i) {
    for ($i=0; $i<24; $i++) {
        $hour = sprintf("%02d", $i);
        $count = (int)$arr[$hour];

        $rate = ($count / $sum_count * 100);
        $s_rate = number_format($rate, 1);

        $bar = (int)($count / $max * 100);
        $graph = "<img src='{$g4[admin_path]}/img/graph.gif' width='$bar%' height='18'>";

        $list = ($k++%2);
        echo "
        <tr class='list$list ht center'>
            <td>$hour</td>
            <td>".number_format($count)."</td>
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
</table><br><br>