<?
/*
//=====================================================================================================================================
// ANTISPAM V3.1
// Last Update : 19.08.19
// author : Ko gi boong
// DESC : /bbs/regieter_form.php,  /bbs/register_{loginAPI}_form.php 하단 include('~~~/register_form.skin.php') 코드 위
//=====================================================================================================================================
*/
if($w == "") {
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://antispam.1937.co.kr/v3/_getkey.php',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => array(
        "ip"=>$_SERVER["REMOTE_ADDR"],
        "ssid"=>session_id(),
        "w"=>$w,
        "as_version"=>"3.1"
    )
    ));
    $antispam_key = curl_exec($curl);
    curl_close($curl);
    echo "
    <script>if(typeof(antispam_fkey) != 'undefined') { antispam_fkey='{$antispam_key}';}</script>
    ";
}