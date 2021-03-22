<?
include_once("./_common.php");

$page = $_REQUEST[page];

// 주사 지랄 방지
$datefrom = substr($datefrom, 0, 10);
$dateto = substr($dateto, 0, 10);
$page = substr($page, 0, 10);


?>

<style type="text/css">
#m3tbl { border:solid 1px #CCC; border-collapse:collapse;}
#m3tbl th { border:solid 1px #CCC; text-align:center;}
#m3tbl td { border:solid 1px #CCC; text-align:center; padding:2px 8px;}
#div_m3sq li { display:inline; padding:0 10px; border:solid 1px #CCC; }
</style>



<?

$mQuery = "";
if($md == "p"){
	$mQuery = " is_mobile != 'Y'  AND ";
} else if ($md == "m") {
	$mQuery = " is_mobile = 'Y' AND ";
}



// vi_referer에서 사이트 찾고, vi_date로 범위 정하기, 정렬은 vi_id 역순 (속도 개선 필요)
if($page=="daum") {
	$where1 = "vi_referer LIKE '%search.daum.net%'";
}
elseif($page=="nate") {
	$where1 = "vi_referer LIKE '%search.nate.com%'";
}
elseif($page=="yahoo") {
	$where1 = "vi_referer LIKE '%search.yahoo.com%'";
}
elseif($page=="naver") {
	$where1 = "vi_referer LIKE '%search.naver.com%'";
}
elseif($page=="google") {
	$where1 = "vi_referer LIKE 'http://www.google.%'";
}
else { // 5개 사이트 모두 포함
	$where1 = "(vi_referer LIKE 'http://www.google.%' OR vi_referer LIKE '%search.yahoo.com%' OR vi_referer LIKE '%search.nate.com%' OR vi_referer LIKE '%search.daum.net%' OR vi_referer LIKE '%search.naver.com%')";
}
$query = sql_query("select * from `$g4[visit_table]` where $mQuery $where1 AND vi_date>='$datefrom' AND vi_date<='$dateto' order by vi_id desc");
?>
<table id="m3tbl">
<tr>
	<th width="90">날짜</td>
	<th>사이트</td>
	<th>검색어</td>
</tr>
<?
$cnt = 0;
$cnt2 = array();
while($row = sql_fetch_array($query)) {
	// 사이트에 따라 검색쿼리 변수가 다름
	if(strstr($row[vi_referer], "search.daum.net")) { $var = "q="; $engine = "daum"; }
	if(strstr($row[vi_referer], "search.naver.com")) { $row[vi_referer] = str_replace("oquery","xxxx", $row[vi_referer]); $var = "query="; $engine = "naver"; }
	if(strstr($row[vi_referer], "http://www.google.")) { $var = "q="; $engine = "google"; }
	if(strstr($row[vi_referer], "search.yahoo.com")) { $var = "p="; $engine = "yahoo"; }
	if(strstr($row[vi_referer], "search.nate.com")) { $var = "q="; $engine = "nate"; }
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
	// 에코
	echo "<tr><td>$row[vi_date]</td>";
	echo "<td><a href=\"$PHP_SELF?page=$engine\"><img src=\"$g4[path]/img/$engine.jpg\" ></a></td>";
	echo "<td style=\"text-align:left;\" id=\"m3sqtd[$cnt]\"><a href=\"$row[vi_referer]\" target=\"_blank\">$querystr</a></td></tr>\n";
	// 카운트용 변수
	$cnt++;
	$cnt2[$engine]++;
}
ksort($cnt2);

function utf8_urldecode($str) {
	$str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
	return html_entity_decode($str,null,'UTF-8');;
}

?>
</table><br />
Total : <?=$days=(strtotime($dateto)-strtotime($datefrom))/(24*60*60)+1?> days, <?=$cnt?> results (<?=sprintf("%.1f",$cnt/$days)?>/day)<br />
<? if(!$page) { // 모든 사이트의 경우 비율 분석
	foreach($cnt2 as $engine => $count) {
		echo "$engine : $count (".sprintf("%.1f",$count/$cnt*100)."%)<br />";
	}
}?>

</div>

<script type="text/javascript">
function findsq(sq) {
	if(sq=="") return;
	var i = 0;
	var search_cnt = 0; // 결과내 검색 개수
	while(a = document.getElementById("m3sqtd["+i+"]")) {
		if(a.innerText.toLowerCase().match(sq.toLowerCase())) { // 찾는 값이 있으면 보이기
			a.parentNode.style.display="";
			search_cnt++;
		} else { // 찾는 값이 없으면 숨기기
			a.parentNode.style.display="none";
		}
		i++;
	}
	document.getElementById("search_cnt").innerText = "결과내 검색 : " + search_cnt + "건";
}
function resetsq() {
	var i = 0;
	while(a = document.getElementById("m3sqtd["+i+"]")) {
		a.parentNode.style.display=""; // 모든 행의 display 속성 reset
		i++;
	}
	document.getElementById("search_cnt").innerText = "";
	document.getElementById("sq").value = "";
}
</script>