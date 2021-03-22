<?
include_once("_common.php");
include_once("$g4[path]/lib/visit.lib.php");

header("content-type:text/html; charset=utf-8");

$mb_id = $member[mb_id];
if($mb_id == "") { exit; };



if(strlen($date) == 4){
	$datefrom = $date."-01-01";
	$dateto = $date."-12-31";
}
else if(strlen($date) == 7){
	$datefrom = $date."-01";
	$dateto = $date."-".date("t", $datefrom);
}
else{
	$datefrom = $date;
	$dateto = $date;
}



$sql = " select * from $g4[visit_table]
          where vi_date between '$datefrom' and '$dateto' ";
$result = sql_query($sql);

while ($row=sql_fetch_array($result)) {
    $s = get_os($row[vi_agent]);
    $arr[$s]++;
    if ($arr[$s] > $max) $max = $arr[$s];
    $sum_count++;
}

//$sum_count = $max;
//$sum_count = ceil($sum_count * 0.01) * 100; // 최대값을 10의 자리에서 올림


$title = array();
if (count($arr)) {
	arsort($arr);
} else {
	$sum_count = 0;
	$arr["No Data"] = 0;
}

 foreach ($arr as $key=>$value) {

        $count = $arr[$key];

        if (!$key) {
            $key = " "; 
        }

	if($count == "")
		$arr[$key] = "0";
	
	array_push($title, $key);
}


echo '{"max":'.$sum_count.', "title":["'.$title[0].'", "'.$title[1].'", "'.$title[2].'", "'.$title[3].'", "'.$title[4].'"], "data":['.
	($arr[$title[0]] ? $arr[$title[0]] : 0).','.
	($arr[$title[1]] ? $arr[$title[1]] : 0).','.
	($arr[$title[2]] ? $arr[$title[2]] : 0).','.
	($arr[$title[3]] ? $arr[$title[3]] : 0).','.
	($arr[$title[4]] ? $arr[$title[4]] : 0).']}';

?>