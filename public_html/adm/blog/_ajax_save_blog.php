<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");



/**
 * 블로그 실제주소 파악용
 * get_redirect_url()
 * Gets the address that the provided URL redirects to,
 * or FALSE if there's no redirect. 
 *
 * @param string $url
 * @return string
 */
function get_redirect_url($url){
    $redirect_url = null; 

    $url_parts = @parse_url($url);
    if (!$url_parts) return false;
    if (!isset($url_parts['host'])) return false; //can't process relative URLs
    if (!isset($url_parts['path'])) $url_parts['path'] = '/';

    $sock = fsockopen($url_parts['host'], (isset($url_parts['port']) ? (int)$url_parts['port'] : 80), $errno, $errstr, 30);
    if (!$sock) return false;

    $request = "HEAD " . $url_parts['path'] . (isset($url_parts['query']) ? '?'.$url_parts['query'] : '') . " HTTP/1.1\r\n"; 
    $request .= 'Host: ' . $url_parts['host'] . "\r\n"; 
    $request .= "User-Agent: Mozilla/5.0 (Linux; U; Android 4.0.3; ko-kr; LG-L160L Build/IML74K) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30\r\n";
    $request .= "Connection: Close\r\n\r\n"; 
    fwrite($sock, $request);
    $response = '';
    while(!feof($sock)) $response .= fread($sock, 8192);
    fclose($sock);

    if (preg_match('/^Location: (.+?)$/m', $response, $matches)){
        if ( substr($matches[1], 0, 1) == "/" )
            return $url_parts['scheme'] . "://" . $url_parts['host'] . trim($matches[1]);
        else
            return trim($matches[1]);

    } else {
        return false;
    }

}




$title = str_replace("'", "''", urldecode($title));
$link = urldecode($link);
$linkV = get_redirect_url($link);
if($linkV){
	$link = $linkV;
}
$description = str_replace("'", "''", urldecode($description));
$bloggername = str_replace("'", "''", urldecode($bloggername));
$bloggerlink = urldecode($bloggerlink);



if($w == ""){
	$sql = "
		INSERT INTO blog_data SET
			title = '$title',
			link = '$link',
			description = '$description',
			bloggername = '$bloggername',
			bloggerlink = '$bloggerlink',
			reg_date = now();
	";

	sql_query($sql);
}
else if($w == "d"){
	

	$sql = "
		DELETE FROM blog_data WHERE
			title = '$title' AND
			description = '$description' AND 
			bloggername = '$bloggername' AND 
			bloggerlink = '$bloggerlink'
	";
	sql_query($sql);

}

echo "OK";