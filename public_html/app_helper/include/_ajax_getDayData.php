<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

$mb_id = $member[mb_id];
if($mb_id == "") { exit; };


$day = array();
$day[0] = date("Y-m-d");
$day[1] = date('Y-m-d',strtotime("-1 day"));
$day[2] = date('Y-m-d',strtotime("-2 day"));
$day[3] = date('Y-m-d',strtotime("-3 day"));
//$day[4] = date('Y-m-d',strtotime("-4 day"));

$max = 0;
$sum_count = 0;
$sql = " 
	SELECT 
		vs_date, 
		vs_count as cnt 
	FROM 
		$g4[visit_sum_table]
	WHERE 
		vs_date between '$day[3]' and '$day[0]'
	ORDER BY VS_DATE DESC ";

$result = sql_query($sql);


for ($i=0; $row=sql_fetch_array($result); $i++) {
	
	//$row[cnt] = $row[cnt] * rand(100,200);

    $arr[$row[vs_date]] = $row[cnt];
	if ($row[cnt] > $max) 
		$max = $row[cnt];
	$sum_count += $row[cnt];
}

$sum_count = $max;
$sum_count = ceil($sum_count * 0.01) * 100; // 최대값을 10의 자리에서 올림




echo '{"max":'.$sum_count.', "title":["'.$day[0].'", "'.$day[1].'", "'.$day[2].'", "'.$day[3].'", "'.$day[4].'"], "data":['.
	($arr[$day[0]] ? $arr[$day[0]] : 0).','.
	($arr[$day[1]] ? $arr[$day[1]] : 0).','.
	($arr[$day[2]] ? $arr[$day[2]] : 0).','.
	($arr[$day[3]] ? $arr[$day[3]] : 0).','.
	($arr[$day[4]] ? $arr[$day[4]] : 0).']}';
?>