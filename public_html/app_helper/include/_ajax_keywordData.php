<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

$mb_id = $member[mb_id];
if($mb_id == "") { exit; };


if(!$_POST["rowcnt"])
	$rowCnt = 15;
else 
	$rowCnt = $_POST["rowcnt"];

$page = $_POST["page"];


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


$where1 = "(vi_referer LIKE 'http://www.google.%' OR vi_referer LIKE '%search.yahoo.com%' OR vi_referer LIKE '%search.nate.com%' OR vi_referer LIKE '%search.daum.net%' OR vi_referer LIKE '%search.naver.com%') AND INSTR(vi_referer,'&') > 0 ";
$allCntRst = sql_fetch(" select count(*) as cnt from `$g4[visit_table]` where $where1 AND vi_date>='$datefrom' AND vi_date<='$dateto' ");
$result["count"] = $allCntRst[cnt];




$start = ($page - 1) * $rowCnt;
$keyList = sql_query("select * from `$g4[visit_table]` where $where1 AND vi_date>='$datefrom' AND vi_date<='$dateto' order by vi_id desc  limit $start, $rowCnt ");
$list = array();
for($i = 0 ; $row = sql_fetch_array($keyList) ; $i++) { 
	$list[] = $row;
}
function utf8_urldecode($str) {
	$str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
	return html_entity_decode($str,null,'UTF-8');;
}



?>

<?
$continueCnt = 0;
for ($i=0; $i < count($list); $i++) { 
	$row = $list[$i];
	
	$info = ""; 
	if($i == count($list)-1) {
		$info = " data-listcnt={$result["count"]} ";
		$info .= " data-savepage=\"{$save_page}\" "; //저장페이지 
		$info .= " data-savesc=\"{$save_sc}\" ";//저장 스크롤 위치
	}
	
	// 사이트에 따라 검색쿼리 변수가 다름
	if(strstr($row[vi_referer], "search.daum.net")) { $var = "q="; $engine = "daum"; }
	if(strstr($row[vi_referer], "search.naver.com")) { $var = "query="; $engine = "naver"; }
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
	if(!strlen($querystr)) {
		continue;
	}

?>
		
	<li  <?=$info?> class="nboxli">
		<div class="nboxlidiv1">
			<span><?=cut_str($querystr,40)?></span><span class="listpoint"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
		</div>
		<div class="nboxlibar"></div>
		<div class="nboxlidiv2">
			<span class="<?=$engine?>"><img src="/app_helper/images/<?=$engine?>.png" style="width:100%"/></span><span class="nboxlidiv2text"><?=$row[vi_date]?></span>
		</div>
	</li>
		

<? }?>

<? if($result["count"]==0){?>



	<li  data-listcnt=0 class="nboxli">
		<div class="nboxlidiv1">
			<span>데이터가 없습니다.</span><span class="listpoint"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
		</div>
	</li>


<? }?>