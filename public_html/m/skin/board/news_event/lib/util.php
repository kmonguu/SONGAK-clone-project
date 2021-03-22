<?
/*
// 현재페이지, 총페이지수, 한페이지에 보여줄 행, URL
function get_paging2($write_pages, $cur_page, $total_page, $url, $add="")
{
	
    $str = "";
    if ($cur_page > 1) {
        $str .= "<td class='td-remo'><a href='" . $url . "1{$add}'>&lt;&lt;</a></td>";
    } else {
	$str .= "<td class='td-remo' style='color:#d9d9d9'>&lt;&lt;</td>";
    }

    $start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
    $end_page = $start_page + $write_pages - 1;

    if ($end_page >= $total_page) $end_page = $total_page;

    if ($start_page > 1) $str .= " <td class='td-remo'><a href='" . $url . ($start_page-1) . "{$add}'>&lt;</a></td>";
    else $str .= " <td class='td-remo' style='color:#d9d9d9'>&lt;</td>";

    if ($total_page > 1) {
        for ($k=$start_page;$k<=$end_page;$k++) {
            if ($cur_page != $k)
                $str .= " <td><a href='$url$k{$add}'>$k</a></td>";
            else
                $str .= " <td class='td-on'>$k</td>";
        }
    }

    if ($total_page > $end_page) $str .= " <td class='td-remo2'><a href='" . $url . ($end_page+1) . "{$add}'>&gt;</a></td>";
    else  $str .= " <td class='td-remo2'  style='color:#d9d9d9'>&gt;</td>";

    if ($cur_page < $total_page) {
        $str .= " <td class='td-remo2'><a href='$url$total_page{$add}'>&gt;&gt;</a></td>";
    } else {
	 $str .= " <td class='td-remo2' style='color:#d9d9d9'>&gt;&gt;</td>";
    }
    $str .= "";
	

						


    return $str;
}

*/
?>