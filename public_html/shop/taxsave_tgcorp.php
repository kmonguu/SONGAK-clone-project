<?
include_once("./_common.php");

$od = sql_fetch(" select * from $g4[yc4_order_table] where od_id = '$od_id' and on_uid = '$on_uid' ");
if (!$od) 
    die("주문서가 존재하지 않습니다.");

$goods = get_goods($od[on_uid]);
$goods_name = $goods[full_name];
if ($goods[count] > 1)
    $goods_name .= ' 외 '.$goods[count].'건';

$trad_time = date("YmdHis");

$amt_tot = (int)$od[od_receipt_bank];
$amt_sup = (int)round(($amt_tot * 10) / 11);
$amt_svc = 0;
$amt_tax = (int)($amt_tot - $amt_sup);


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

<FORM name="mInfo"  method="post"  target=POPWIN onsubmit="return OpenWindow()" action="" target="TG_PAY">
<input type="hidden" name="MxID" value="<?=$default[de_tgcorp_mxid]?>"><!-- 가맹점 ID-->
<input type="hidden" name="MxIssueNO" value="<?=$od_id?>"> <!-- 거래 번호(가맹점 생성) -->
<input type="hidden" name="MxIssueDate" value="<?=date("YmdHis",strtotime($od[od_time]))?>"><!-- 거래 일자 -->
<input type="hidden" name="Amount" value="<?=$amt_tot?>"><!--거래 금액 -->	
<input type="hidden" name="Currency" value="KRW"><!--화폐 구분(KRW/USD)-->
<input type="hidden" name="CcMode" value="10"><!--거래를 위한 모드(00:Demo 11: Real)-->
<input type="hidden" name="Smode" value="0001"><!--서비스 구분 모드-->

<input type="hidden" name="CcProdDesc" value="<?=urlencode($goods_name)?>"> <!-- 상품명 -->
<input type="hidden" name="CcNameOnCard" value="<?=addslashes($od[od_name])?>"> <!-- 구매자 성명 -->
<input type="hidden" name="MSTR" value="<?=$od[on_uid]?>"> <!-- 가맹점 return 값, DBPATH로 전달-->
<input type="hidden" name="MSTR2" value=""> <!-- 가맹점 return 값, REDIRPATH로 전달-->


<input type="hidden" name="URL" value="<?=$_SERVER[SERVER_NAME]?>"><!--가맹점 URL. 반드시 가맹점 상황에 맞게 값 입력 -->
<input type="hidden" name="DBPATH" value="<?=dirname($_SERVER["PHP_SELF"])."/taxsave_tgcorp_dbinsert.php"?>"><!--DB 저장을 위한 Server Side Script Path-->
<input type="hidden" name="REDIRPATH" value="<?=$redirpath?>"><!--PG에서 결과를 CP로 Redirection할 Path-->

<input type="hidden" name="email" value="<?=$od[od_email]?>"><!-- 결제 결과를 전달받을 email주소-->

</FORM>

<script type="text/javascript">
OpenWindow();
</script>

</BODY>
</HTML>