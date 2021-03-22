<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
if (!defined("_SMS_")) exit; // 개별 페이지 접근 불가

// 데모라면
if (file_exists("./DEMO")) return;

if (!function_exists("xonda_sms_send")) {
    function xonda_sms_send($url, $data)
    {
        global $_SERVER;
        $url_info	= parse_url($url);
        $referer	= $_SERVER["HTTP_HOST"];

        $req =	"POST " . $url_info["path"] . " HTTP/1.1\n";
        $req .= "Host: " . $url_info["host"] . "\n";
        $req .= "Referer: $referer\n"; 
        $req .= "Content-type: application/x-www-form-urlencoded\n"; 
        $req .= "Content-length: ". strlen($data) . "\n"; 
        $req .= "Connection: close\n"; 
        $req .= "\n"; 
        $req .= $data . "\n"; 

        $res = "";

        $fp = fsockopen($url_info["host"],  80); 

        if($fp)
        {
            fputs($fp, $req); 

            while(!feof($fp)) 
                $res .= fgets($fp, 128); 
        
            fclose($fp);
        }

        xonda_sms_savelog($res);
    }

    function xonda_sms_savelog($res)
    {
        global $g4, $_SERVER;

        preg_match_all("/name=\"(.*)\".+value=\"(.*)\"/", $res, $match);

        for($i = 0; $i < count($match[1]); $i++)
            $log[$match[1][$i]] = $match[2][$i];

        $fp = fopen("$g4[path]/data/log/sms.log", "a+");

        if($fp)
        {
            $msg  = "$g4[time_ymdhis]|$_SERVER[REMOTE_ADDR]";
            $msg .= "|return_value=" . $log["return_value"];
            $msg .= "|success_value=" . $log["success_value"];
            $msg .= "|fail_value=" . $log["fail_value"];
            $msg .= "|error_code=" . $log["error_code"];
            $msg .= "|error_msg=" . $log["error_msg"];
            $msg .= "|unique_num=" . $log["unique_num"];
            $msg .= "|process_type=" . $log["process_type"];
            $msg .= "|usrdata1=" . $log["usrdata1"];
            $msg .= "|usrdata2=" . $log["usrdata2"];
            $msg .= "|usrdata3=" . $log["usrdata3"] . "\n";

            fwrite($fp, $msg);
            fclose($fp);
        }
    }
}

// 회사명
$sms_contents = preg_replace("/{회사명}/", $default[de_admin_company_name], $sms_contents);

$biz_id      = $default[de_xonda_id];
$smskey      = $default[de_xonda_smskey];
$return_url  = "http://"; // 의미없는 변수 (값이 없으면 안됨)
$reserved_flag = false;

// 전송요청 URL
//$xonda_sms_url = "http://biz.xonda.net/biz/sms/process_F.asp";
$xonda_sms_url = "http://biz.xonda.net/biz/biz_newV2/SMSASP_WEBV4_s.asp";

$xonda_sms_data = "biz_id=" . $biz_id;					    // 쏜다넷에 등록된 고객 아이디
$xonda_sms_data .= "&smskey=" . $smskey;                    // 보안키
$xonda_sms_data	.= "&send_number=" . $send_number;			// 발송자 핸드폰 번호
$xonda_sms_data	.= "&receive_number=" . $receive_number;	// 수신자 핸드폰 번호
$xonda_sms_data .= "&sms_contents=" . urlencode($sms_contents);		// 전송할 메세지
$xonda_sms_data .= "&return_url=" . $return_url;			// sms 전송 후 돌아올 URL - 80번 포트 직접 호출 방식을 
															// 사용하고 있어 임의의 값을 할당 하시면 됩니다.
$xonda_sms_data .= "&reserved_flag=" . $reserved_flag;		// 예약여부 true or false
$xonda_sms_data .= "&reserved_year=" . $reserved_year;		// 예약년도
$xonda_sms_data .= "&reserved_month=" . $reserved_month;	// 예약월
$xonda_sms_data .= "&reserved_day=" . $reserved_day;		// 예약일
$xonda_sms_data .= "&reserved_hour=" . $reserved_hour;		// 예약시간
$xonda_sms_data .= "&reserved_minute=" . $reserved_minute;	// 예약분
$xonda_sms_data .= "&usrdata1=" . $usrdata1;				// 사용자 임의의 값
$xonda_sms_data .= "&usrdata2=" . $usrdata2;				// 사용자 임의의 값
$xonda_sms_data .= "&usrdata2=" . $usrdata3;				// 사용자 임의의 값

xonda_sms_send($xonda_sms_url, $xonda_sms_data);
?>