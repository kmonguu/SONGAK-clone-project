<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");


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



$mb_id = $member[mb_id];
if($mb_id == "") { exit; }

$where1 = "(vi_referer LIKE 'http://www.google.%' OR vi_referer LIKE '%search.yahoo.com%' OR vi_referer LIKE '%search.nate.com%' OR vi_referer LIKE '%search.daum.net%' OR vi_referer LIKE '%search.naver.com%')";
$keyList = sql_query("select * from `$g4[visit_table]` where $where1 AND vi_date>='$datefrom' AND vi_date<='$dateto' order by vi_id desc");


function utf8_urldecode($str) {
	$str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
	return html_entity_decode($str,null,'UTF-8');;
}

$cnt = 0;
$resultArray = array();
for($idx = 0 ; $row = sql_fetch_array($keyList ) ; $idx++){
	// 사이트에 따라 검색쿼리 변수가 다름
	if(strstr($row[vi_referer], "search.daum.net")) { $var = "q="; $engine = "DAUM"; }
	if(strstr($row[vi_referer], "search.naver.com")) { $var = "query="; $engine = "NAVER"; }
	if(strstr($row[vi_referer], "http://www.google.")) { $var = "q="; $engine = "GOOGLE"; }
	if(strstr($row[vi_referer], "search.yahoo.com")) { $var = "p="; $engine = "YAHOO"; }
	if(strstr($row[vi_referer], "search.nate.com")) { $var = "q="; $engine = "NATE"; }
	// vi_referer 중 검색쿼리부터 "&"까지 잘라내기 (나중에 정규식으로 치환할지 생각하기)
	$querystr = substr(strstr($row[vi_referer], $var), strlen($var));
	if(strpos($querystr, "&")) $querystr = substr($querystr, 0, strpos($querystr, "&"));
	// %ab 이런 식으로 된 걸 바꿔주기
	$querystr = urldecode($querystr);
	// 네이버는 unicode로 된 경우도 있어서
	if($engine=="naver") $querystr = utf8_urldecode($querystr);
	// 캐릭터셋이 EUC-KR인 경우는 UTF-8로 고치기 (EUC-KR 유저는 UTF-8과 EUC-KR를 서로 바꿔주면 될 듯)
	$charset = mb_detect_encoding($querystr, "ASCII, UTF-8, EUC-KR");
	if($charset=="EUC-KR") $querystr = iconv("EUC-KR", "UTF-8", $querystr);
	// 자잘한 처리들
	$querystr = trim($querystr);
	$querystr = str_replace("+", " ", $querystr);
	$querystr = htmlspecialchars($querystr);
	// 가끔 빈 것들도 있다 -_-
	if(!strlen($querystr)) continue;
	$cnt++;
	$cnt2[$engine]++;
}


$percent = array();
$elist= array();
if(count($cnt2) != 0){
	arsort($cnt2);

	foreach($cnt2 as $engine => $count) {
		$percent[$engine] = floor($count/$cnt*100);
		array_push($elist, $engine);
	}

}


echo '{"max":100, "title":["'.$elist[0].'", "'.$elist[1].'", "'.$elist[2].'", "'.$elist[3].'", "'.$elist[4].'"], "data":['.
	($percent[$elist[0]] ? $percent[$elist[0]] : 0).','.
	($percent[$elist[1]] ? $percent[$elist[1]] : 0).','.
	($percent[$elist[2]] ? $percent[$elist[2]] : 0).','.
	($percent[$elist[3]] ? $percent[$elist[3]] : 0).','.
	($percent[$elist[4]] ? $percent[$elist[4]] : 0).']}';
?>