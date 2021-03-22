<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

$mb_id = $member[mb_id];
if($mb_id == "") { exit; };



$day = array();
$day[0] = date("Y");
$day[1] = date('Y',strtotime("-1 year"));
$day[2] = date('Y',strtotime("-2 year"));
$day[3] = date('Y',strtotime("-3 year"));
$day[4] = date('Y',strtotime("-4 year"));

$mm[0] = date("Y년");
$mm[1] = date('Y년',strtotime("-1 year"));
$mm[2] = date('Y년',strtotime("-2 year"));
$mm[3] = date('Y년',strtotime("-3 year"));
$mm[4] = date('Y년',strtotime("-4 year"));


$max = 0;
$sum_count = 0;
$sql = " 
SELECT 
	substring(vs_date, 1, 4) as vs_date,
	sum(vs_count) as cnt 
FROM 
	$g4[visit_sum_table]
WHERE 
	substring(vs_date, 1, 4) between '$day[3]' and '$day[0]'
	GROUP BY
	substring(vs_date, 1, 4)
ORDER BY VS_DATE DESC ";

$result = sql_query($sql);


for ($i=0; $row=sql_fetch_array($result); $i++) {
	
	$arr[$row[vs_date]] = $row[cnt];
	if ($row[cnt] > $max) 
		$max = $row[cnt];
	$sum_count += $row[cnt];
}

$sum_count = $max;
$sum_count = ceil($sum_count * 0.001) * 1000; // 최대값을 1000의 자리에서 올림




echo '{"max":'.$sum_count.', "yymm":["'.$day[0].'", "'.$day[1].'", "'.$day[2].'", "'.$day[3].'", "'.$day[4].'"], "title":["'.$mm[0].'", "'.$mm[1].'", "'.$mm[2].'", "'.$mm[3].'", "'.$mm[4].'"], "data":['.
	($arr[$day[0]] ? $arr[$day[0]] : 0).','.
	($arr[$day[1]] ? $arr[$day[1]] : 0).','.
	($arr[$day[2]] ? $arr[$day[2]] : 0).','.
	($arr[$day[3]] ? $arr[$day[3]] : 0).','.
	($arr[$day[4]] ? $arr[$day[4]] : 0).']}';
?>