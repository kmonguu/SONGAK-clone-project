<?
include_once("./_common.php");

// 현금영수증 사용, 미사용 구분
$sql = " ALTER TABLE `$g4[yc4_order_table]` ADD `od_cash` TINYINT NOT NULL ";
sql_query($sql, false);

// 현금영수증 승인번호
$sql = " ALTER TABLE `$g4[yc4_order_table]` ADD `od_cash_receiptnumber` VARCHAR( 255 ) NOT NULL ";
sql_query($sql, false);

/********************************************************************************************************

 * 현금영수증 발급/취소 PHP 연동설명 및 예제


 1, 현금영수증 발급/취소 요청 파라미터 
 ============ ====================================================================
  파라미터명        설명
 ============ ====================================================================
 mid            LG텔레콤에서 발급한 상점아이디
 oid            주문번호    
 paytype        결제수단 : SC0030(계좌이체), SC0040(무통장입금), SC0100(단독)
 usertype       용도 : 1(소득공제용), 2(지출증빙용)
 ssn            현금영수증 발급 정보 , 주민등록번호 또는 사업자번호 또는 전화번호등
 amount         발급(취소)금액
 bussinessno    현금영수증 발급 사업자번호 
 method         종류 : auth(발급), cancel(취소)
 ret_url        defaul(고정) : NONE
 hashdata       해쉬데이타(무결성검증필드)  :   md5($mid.$oid.$mertkey)
 ============ ====================================================================

 2. 결과 파라미터 
 ============ ====================================================================
 파라미터명         설명
 ============ ====================================================================
 mid                LG텔레콤에서 발급한 상점아이디
 oid                주문번호    
 paytype            결제수단 - SC0030(계좌이체), SC0040(무통장입금), SC0100(단독)
 receiptnumber      현금영수증 승인번호
 respcode           결과코드 ("0000" : 성공,  그외 : 실패)
 respmsg            결과메시지 
 ============ ====================================================================
 ==> 요청 결과 형식
   형 식 )  name|value^name|value^name|value^name|value
   예) mid|tdacomts1^oid|20080306-1^paytype|SC0030^receiptnumber|null^respcode|0000^respmsg|성공


 주의) 1. 현금영수증 발급 (단독만 가능)
          결제수단은 단독 발급만 가능 합니다. (SC0100)

       2. 현금영수증 취소
          필수: 주문번호(oid), 금액(amount), 상점아이디(mid), paytype, hashdata, ret_url, method

******************************************************************************************************/

// 결제 요청 URL
// 서비스용 : http://pg.dacom.net/common/cashreceipt.jsp
// 테스트용 : http://pg.dacom.net:7080/common/cashreceipt.jsp

if (preg_match("/^tsi_/", $default[de_dacom_mid])) {
    // 테스트용
    $service_url = "http://pg.dacom.net:7080/common/cashreceipt.jsp"; 
} else {
    // 서비스용
    $service_url = "http://pg.dacom.net/common/cashreceipt.jsp"; 
}

$mid            = $_POST[mid];      //LG텔레콤에서 발급한 상점아이디
$oid            = $_POST[od_id];    //주문번호 (취소시 원거래 주문번호) 
$paytype        = "SC0100";         //결제수단 - SC0030(계좌이체), SC0040(무통장입금), SC0100(단독)
$usertype       = $_POST[usertype]; //용도 - 1(소득공제용), 2(지출증빙용)
$ssn            = $_POST[ssn];      //현금영수증 발급 정보 , 주민등록번호 또는 사업자번호 또는 전화번호등
$amount         = $_POST[amount];   //발급금액(발급/재발급시)
$bussinessno    = str_replace("-", "", $default[de_admin_company_saupja_no]); //현금영수증 발급 사업자번호 
$method         = "auth";           //종류 - auth(발급), cancel(취소)
$ret_url        = "NONE";           // defaul : NONE

$mertkey        = $default[de_dacom_mertkey];   //LG텔레콤에서 발급  
                                                //상점관리자 > 계약정보 > 상점정보 관리 에서 mertkey  확인
$hashdata       = md5($mid.$oid.$mertkey);      // 인증키


// LG텔레콤의 배송결과등록페이지를 호출하여 배송정보등록함
$str_url = $service_url."?mid=".$mid."&oid=".$oid."&paytype=".$paytype."&usertype=".$usertype."&ssn=".$ssn."&amount=".$amount."&bussinessno=".$bussinessno."&method=".$method."&ret_url=".$ret_url."&hashdata=".$hashdata; 

/*

    * windows
    curl 방식
    php 4.3 버전 이상에서 지원
    php.ini 파일 안에 extension=php_curl.dll 를 사용할수 있도록 풀어주어야 한다.

    * LINUX
    1. http://curl.haxx.se/download.html 에서 curl 을 다운 받는다.
    2. curl 설치
    shell>tar -xvzf curl-7.10.3.tar.gz 
    shell>cd curl-7.10.3
    shell>./configure 
    shell>make 
    shell>make instal
    ※curl 라이브러리는 /usr/local/lib 나머지 헤더는/usr/local/include/curl 로 들어간다 
    3. PHP설치
    shell>./configure \
    아래 항목 추가
    --with-curl \
    shell>make
    shell>make install
*/

if (function_exists("curl_init")) {
    $ch = curl_init(); 

    curl_setopt ($ch, CURLOPT_URL, $str_url); 
    curl_setopt ($ch, CURLOPT_COOKIEJAR, COOKIE_FILE_PATH);
    curl_setopt ($ch, CURLOPT_COOKIEFILE, COOKIE_FILE_PATH);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 

    $res = curl_exec ($ch);

    $exp1 = explode("^", trim($res));
    for ($i=0; $i<count($exp1); $i++) {
        $exp2 = explode("|", $exp1[$i]);
        // 변수 생성
        ${$exp2[0]} = $exp2[1];
        /*
        mid                LG텔레콤에서 발급한 상점아이디
        oid                주문번호    
        paytype            결제수단 - SC0030(계좌이체), SC0040(무통장입금), SC0100(단독)
        receiptnumber      현금영수증 승인번호
        respcode           결과코드 ("0000" : 성공,  그외 : 실패)
        respmsg            결과메시지 
        */
    }


    if(curl_errno($ch)){
        // 연결실패시 DB 처리 로직 추가
    }else{
        //if(trim($fp)=="OK"){
        if($respcode == "0000"){
            // 정상처리되었을때 DB 처리
            $sql = " update $g4[yc4_order_table] 
                        set od_cash = '1',
                            od_cash_receiptnumber = '$receiptnumber'
                      where od_id = '$oid' ";
            sql_query($sql);

            echo "<script>opener.location.reload();</script>";
            alert_close("현금영수증을 발급하였습니다.\\n\\n현금영수증 승인번호 : $receiptnumber");
        }else{
            // 비정상처리 되었을때 DB 처리
            alert("$respcode : $respmsg");
        }
    }
    curl_close($ch);
}
else {

    /*
    *   fopen 방식
    *   php 4.3 버전 이전에서 사용가능
    */

    $fp = fopen($str_url,"r");
    $res ="";
    if(!$fp)
    {
        // 연결실패시 DB 처리 로직 추가
        alert("현금영수증 발급에 실패하였습니다.");
    }
    else
    {
        // 해당 페이지 return값 읽기
        while(!feof($fp))
        {
                $res .= fgets($fp,3000);
        }

        //echo($res);

        $exp1 = explode("^", trim($res));
        for ($i=0; $i<count($exp1); $i++) {
            $exp2 = explode("|", $exp1[$i]);
            // 변수 생성
            ${$exp2[0]} = $exp2[1];
            /*
            mid                LG텔레콤에서 발급한 상점아이디
            oid                주문번호    
            paytype            결제수단 - SC0030(계좌이체), SC0040(무통장입금), SC0100(단독)
            receiptnumber      현금영수증 승인번호
            respcode           결과코드 ("0000" : 성공,  그외 : 실패)
            respmsg            결과메시지 
            */
        }

        // 정상처리되었을때 DB 처리
        $sql = " update $g4[yc4_order_table] 
                    set od_cash = '1',
                        od_cash_receiptnumber = '$receiptnumber'
                  where od_id = '$oid' ";
        sql_query($sql);

        echo "<script>opener.location.reload();</script>";
        alert_close("현금영수증을 발급하였습니다.\\n\\n현금영수증 승인번호 : $receiptnumber");
    }
}

/*<!--***************************************************
  #요청 결과 응답 형식
   형 식 )  name|value^name|value^name|value^name|value
   예) mid|tdacomts1^oid|20080306-1^paytype|SC0030^receiptnumber|null^respcode|0000^respmsg|성공
*****************************************************-->*/