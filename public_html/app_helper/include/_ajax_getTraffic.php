<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

//페이지 불러오기
function fetch_url($theurl) {
	$url_parsed = parse_url($theurl);
	$host = $url_parsed["host"];
	$port = $url_parsed["port"];
	if($port==0) $port = 80;
	$the_path = $url_parsed["path"];
	if(empty($the_path)) $the_path = "/";
	if(empty($host)) return false;
	if($url_parsed["query"] != "") $the_path .= "?".$url_parsed["query"];
	$out = "GET ".$the_path." HTTP/1.0\r\nHost: ".$host."\r\n\r\nUser-Agent: Mozilla/4.0 \r\n";
	$fp = fsockopen($host, $port, $errno, $errstr, 30);

	if($fp) {
		socket_set_timeout($fp, 30);
		fwrite($fp, $out);
		$body = false;
		while(!feof($fp)) {
		$buffer = fgets($fp, 128);
		if($body) 
			$content .= $buffer;
		if($buffer=="\r\n") $body = true;
		}
		fclose($fp);
	} else {
		return false;
	}
	return $content;
}

$domain = $_SERVER[HTTP_HOST];
if($domain == "it9.co.kr") $domain = "vetago.com";
if($domain == "china.smart9.net") $domain = "seniorclub.1937.co.kr";


$traffic = fetch_url("http://it9.co.kr/api/traffic.php?domain={$domain}");
if($traffic == ""){
	echo "-1";
	exit;
}
echo $traffic;