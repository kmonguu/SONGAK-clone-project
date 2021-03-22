<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

//if ($settle_case == '가상계좌') alert("가상계좌 결제는 지원하지 않습니다. 다른 결제수단을 사용하여 주십시오."); 
/*
[가상계좌]
결과 저장 페이지 (dbpath) 결과 전송
최초 가상계좌 발급과, 입금 여부 통보는 동일한 dbpath로 전송됩니다.
(가상계좌 발급은 redirpath로 동일하게 전송하지만, 입금통보는 dbpath로만 전송합니다.)
dbpath = shop/settle_tgcorp_dbinsert.php
*/
?>

<? /* ?>
<!--
페이지 설명:
	가맹점이 직접 구성하는 페이지를 예제로 작성함 것임. 
	구매자가 장바구니를 확인한 후, PG서버에게 카드결제를 요청하는 페이지.

단추설명:
	[지불요청] : 클릭시, 새 창 띄우고 PG서버의 DLP(Direct Link Page)를 call함 <참고1>.

변수설명:

입력사항 설명: 
	'거래번호','거래일자'는 테스트를 위해 수동으로 입력하도록 되어 있지만, 
	실제로 운용하기 위해서는 자동으로 입력되도록 코딩해야 함.

파라메터 설명(메뉴얼 참조):
	MxID       : 가맹점ID. TGCORP와 PG서비스 계약시 할당받는 가맹점구분용 ID
	MxIssueNO  : 카드 거래번호. 카드결제 요청시 가맹점에서 발생시키는 일련번호.
	             이 소스상에서는 테스트를 위해 수동으로 입력하도록 되어 있지만, 
	             실제로 운용하기 위해서는 자동으로 입력되도록 코딩해야 함.
	             반드시 중복되지 않는 serial한 값이 설정되도록 해야 합니다.
	MxIssueDate: 카드 거래일시. 카드결제 요청시 가맹점에서 발생시키는 거래일시.
	             예로, 2001년10월1일 오후 2시40분13초에 [지불요청]을 클릭할 시
	             20011001144013 으로 setting 되도록 코딩한다.
	             이 소스상에서는 테스트를 위해 수동으로 입력하도록 되어 있지만, 
	             실제로 운용하기 위해서는 자동으로 입력되도록 코딩해야 함.
	Amount     : 카드결제를 요구하는 거래금액(=결제금액).
	             카드결제를 희망하는 금액이 15,000원일 경우 15000 으로 setting함.
	URL        : mall 운용서버의 URL. ("http://"는 빼고)
	DBPATH     : mall 운용서버에서 dbpath.jsp 페이지의 논리적 path. (맨앞에 "/" 붙여서)
	REDIRPATH  : mall 운용서버에서 redirpath.jsp 페이지의 논리적 path. (맨앞에 "/" 붙여서)
	ex) 만약 http://www.abc.com/pg/card/dbinsert.jsp <= dbpath페이지
	         http://www.abc.com/pg/card/showresult.jsp <= redirpath페이지인 경우
			 <input type="hidden" name="URL" value="www.abc.com">
			 <input type="hidden" name="DBPATH" value="/pg/card/dbinsert.jsp">
			 <input type="hidden" name="REDIRPATH" value="/pg/card/showresult.jsp">
			 이와 같이 hidden값을 설정 하시면 됩니다.

	VERSION    : service version.(VERSION=1 로 고정)
    MSTR       : 가맹점에서 지정하는 특정 값을 위한 보조 파라메타.
	             예로,
	             index.* 페이지에서 이 값에 '구매자의 주민번호'값을 저장하여 보내면
	             PG서버에서는 그대로 되돌려 보내준다.
	             PG서버에서는 이 값에 대해 어떤 처리도 하지 않는다.
	CcMode     : 거래모드.
	             00 - 테스트 거래시. (실제 거래는 발생하지 않으며, parameter 만 check 하게 됩니다.)
	             11 - 실제거래시. (실제 거래 발생)
	Smode      : 결제서비스 종류 모드
				3001 : 일반 신용카드 결제
				3005 : 가맹점에 DB가 없을때(DBPATH쪽으로 data를 넘기지 않습니다)
				

-->
<? */ ?>
<HTML>
<HEAD>
<TITLE>지불 요청 화면</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=<?=$g4['charset']?>"/>
<LINK rel="stylesheet" href="css/backoffice.css"/>

<script language="javascript">
function OpenWindow() 
{
	payform = document.mInfo;
	TG_PAY = window.open("","TG_PAY", "resizable=yes, width=390, height=360");
	TG_PAY.focus();
	payform.target="TG_PAY";
	payform.action="https://npg.tgcorp.com/dlp/start.jsp";
    payform.submit();
}
</SCRIPT>
</HEAD>

<BODY>

<FORM name=mInfo  method=post  target=POPWIN onsubmit="return OpenWindow()" action=''>
<input type=hidden name="MxID" value="<?=$default[de_tgcorp_mxid]?>"><!-- 가맹점 ID-->
<input type=hidden name="Amount" value="<?=$settle_amount?>"><!--거래 금액 -->	
<input type="hidden" name="Currency" value="KRW"><!--화폐 구분(KRW/USD)-->
<input type="hidden" name="CcMode" value="11"><!--거래를 위한 모드(00:Demo 11: Real)-->
<? 
$smode = '3001';
if ($settle_case == '계좌이체') {
    //$smode = '2201';
    $smode = '2501'; // 금결원
} else if ($settle_case == '가상계좌') {
    $smode = '2601';
}
?>
<input type="hidden" name="Smode" value="<?=$smode?>"><!--서비스 구분 모드-->

<input type=hidden name="MxIssueNO" value="<?=$od[od_id]?>"><!-- 주문번호-->
<input type=hidden name="MxIssueDate" value="<?=date("YmdHis",strtotime($od[od_time]))?>"><!-- 주문일시-->

<input type=hidden name="URL" value="<?=$_SERVER[SERVER_NAME]?>"><!--가맹점 URL. 반드시 가맹점 상황에 맞게 값 입력 -->
<input type=hidden name="DBPATH" value="<?=dirname($HTTP_SERVER_VARS["PHP_SELF"])?>/settle_tgcorp_dbinsert.php"><!--DB 저장을 위한 Server Side Script Path-->
<input type=hidden name="REDIRPATH" value="<?=dirname($HTTP_SERVER_VARS["PHP_SELF"])?>/settle_tgcorp_result.php"><!--PG에서 결과를 CP로 Redirection할 Path-->

<input type=hidden name="MSTR" value="<?=$_SESSION[ss_temp_on_uid]?>"><!--CP를 위한 String (Undefine) 값-->
<input type=hidden name="CcNameOnCard" value="<?=$od[od_name]?>"><!-- 카드사용자 이름 (영문16자, 한글8자, Null 사용가능)-->
<input type=hidden name="CcProdDesc" value="<?=urlencode($goods)?>"><!-- 상품명 (Null 사용가능)-->
<input type=hidden name="email" value="<?=$od[od_email]?>"><!-- 결제 결과를 전달받을 email주소-->

<!-- 계좌이체(금결원) parameter 설정 시작 -->
<input type="hidden" name="CcProdName" value="<?=substr($goods,0,10);?>"> <!-- 간략한 상품 정보(한글 5자까지) -->
<input type="hidden" name="Name" value="<?=substr($od[od_name],0,10);?>"> <!-- 송금인 성명(한글 5자까지) --> 
<!-- 계좌이체(금결원) parameter 설정 끝 --> 

<!-- 가상계좌 parameter 설정 시작 -->
<input type="hidden" name="CcUserMPhone" value="<?=preg_replace("/([^0-9])/", "", $od[od_hp]);?>"> <!-- 사용자 휴대폰 번호('-' 생략) -->
<input type="hidden" name="Email" value="<?=$od[od_email]?>"> <!-- 구매자 입금안내 메일 주소 -->   
<!-- 가상계좌 parameter 설정 끝 -->

</FORM>

</BODY>
</HTML>