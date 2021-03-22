<?
if (!defined('_GNUBOARD_')) exit;

// 방문자수 출력
function visit($skin_dir="basic")
{
    global $config, $g4;

    // visit 배열변수에 
    // $visit[1] = 오늘
    // $visit[2] = 어제
    // $visit[3] = 최대
    // $visit[4] = 전체
    // 숫자가 들어감
    preg_match("/오늘:(.*),어제:(.*),최대:(.*),전체:(.*)/", $config['cf_visit'], $visit);
    settype($visit[0], "integer");
    settype($visit[1], "integer");
    settype($visit[2], "integer");
    settype($visit[3], "integer");

    ob_start();
    $visit_skin_path = "$g4[path]/skin/visit/$skin_dir";
    include_once ("$visit_skin_path/visit.skin.php");
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

// get_browser() 함수는 이미 있음
function get_brow($agent)
{
    $agent = strtolower($agent);

    //echo $agent; echo "<br/>";

    if (preg_match("/msie 5.0[0-9]*/i", $agent))         { $s = "MSIE 5.0"; }
    else if(preg_match("/msie 5.5[0-9]*/i", $agent))     { $s = "MSIE 5.5"; }
    else if(preg_match("/msie 6.0[0-9]*/i", $agent))     { $s = "MSIE 6.0"; }
    else if(preg_match("/msie 7.0[0-9]*/i", $agent))     { $s = "MSIE 7.0"; }
    else if(preg_match("/msie 8.0[0-9]*/i", $agent))     { $s = "MSIE 8.0"; }
    else if(preg_match("/msie 4.[0-9]*/i", $agent))      { $s = "MSIE 4.x"; }
    else if(preg_match("/firefox/i", $agent))            { $s = "FireFox"; }
    else if(preg_match("/chrome/i", $agent))             { $s = "Chrome"; }
    else if(preg_match("/x11/i", $agent))                { $s = "Netscape"; }
    else if(preg_match("/opera/i", $agent))              { $s = "Opera"; }
    else if(preg_match("/trident\/5.0/i", $agent))  { $s = "IE9"; }
    else if(preg_match("/trident\/6.0/i", $agent))  { $s = "IE10"; }
    else if(preg_match("/trident\/7.0/i", $agent))  { $s = "IE11"; }
    else if(preg_match("/gec/i", $agent))                { $s = "Gecko"; }
    else if(preg_match("/bot|slurp/i", $agent))          { $s = "Robot"; }
    else if(preg_match("/internet explorer/i", $agent))  { $s = "IE"; }
    else if(preg_match("/mozilla/i", $agent))            { $s = "Mozilla"; }
    else { $s = "기타"; }

    return $s;
}

function get_os($agent)
{
    $agent = strtolower($agent);

    //echo $agent; echo "<br/>";

    if (preg_match("/windows 98/i", $agent))                 { $s = "98"; }
    else if(preg_match("/windows 95/i", $agent))             { $s = "95"; }
    else if(preg_match("/windows nt 4\.[0-9]*/i", $agent))   { $s = "NT"; }
    else if(preg_match("/windows nt 5\.0/i", $agent))        { $s = "2000"; }
    else if(preg_match("/windows nt 5\.1/i", $agent))        { $s = "XP"; }
    else if(preg_match("/windows nt 5\.2/i", $agent))        { $s = "2003"; }
    else if(preg_match("/windows nt 6\.0/i", $agent))        { $s = "Vista"; }
    else if(preg_match("/windows nt 6\.1/i", $agent))        { $s = "Windows7"; }
    else if(preg_match("/windows 9x/i", $agent))             { $s = "ME"; }
    else if(preg_match("/windows ce/i", $agent))             { $s = "CE"; }
    else if(preg_match("/iPhone/i", $agent))                  { $s = "iPhone"; }
    else if(preg_match("/mac/i", $agent))                    { $s = "MAC"; }
    else if(preg_match("/android/i", $agent))                  { $s = "Android"; }
    else if(preg_match("/linux/i", $agent))                  { $s = "Linux"; }
    else if(preg_match("/sunos/i", $agent))                  { $s = "sunOS"; }
    else if(preg_match("/irix/i", $agent))                   { $s = "IRIX"; }
    else if(preg_match("/phone/i", $agent))                  { $s = "Phone"; }
    else if(preg_match("/bot|slurp/i", $agent))              { $s = "Robot"; }
    else if(preg_match("/internet explorer/i", $agent))      { $s = "IE"; }
    else if(preg_match("/mozilla/i", $agent))                { $s = "Mozilla"; }
    else { $s = "기타"; }

    return $s;
}
?>