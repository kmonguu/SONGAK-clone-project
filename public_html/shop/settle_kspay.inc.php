<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

//if ($settle_case == '계좌이체') alert("계좌이체 결제는 지원하지 않습니다. 다른 결제수단을 사용하여 주십시오.");
?>

<script language="javascript">
<!--
function getLocalUrl(mypage)
{
    var myloc = location.href;
    return myloc.substring(0, myloc.lastIndexOf('/')) + '/' + mypage;
}

/*에스크로 약관에 대해 동의여부를 선택하도록 합니다. */
function openKEscrowAgree()
{
    var height_ = 700;
    var width_ = 650;
    var left_ = screen.width;
    var top_ = screen.height;

    left_ = left_/2 - (width_/2);
    top_ = top_/2 - (height_/2);

    /* 약관 동의 창을 호출 - KEscrowRcv.html(파일 확장자는 변경가능, 파일 명은 변경 불가능)*/
    var escrow_url = "https://kspay.ksnet.to/store/KSPayWebV1.3/vaccount/kscrow_agree.jsp?sndEscrowReply=" + getLocalUrl("settle_kspay_KEscrowRcv.html");

    /*kspay통합창을 띄워줍니다.*/
    src = window.open(escrow_url,'AuthFrmUp',
            'height='+height_+',width='+width_+',status=yes,scrollbars=no,resizable=no,left='+left_+',top='+top_+'');
	}

/*goOpen() - 함수설명 : 결재에 필요한 기본거래정보들을 세팅하고 kspay통합창을 띄웁니다.*/
function goOpen()
{
    // 가상계좌만 해당
    if (document.authFrmFrame.sndPaymethod.value == '01000') {
        // 아직 에스크로에 동의하지 않았다면
        if (document.authFrmFrame.sndEscrow.value != '1') {
            // 10만원 이상의 현금 거래에 대해서만
            if (parseInt(document.KSPayWeb.sndAmount.value) >= 100000) {
                // '확인' 클릭시 에스크로 약관을 보여줌
                if (confirm("10만원이상을 결제하실 경우에 에스크로를 사용하실 수 있습니다.\n\n'확인'을 클릭하여 에스크로 약관에 동의하신 후 다시 '결제하기' 버튼을 클릭하여 주십시오.\n\n'취소'를 클릭하시면 에스크로에 동의하지 않고 결제합니다.")) {
                    openKEscrowAgree();
                    return false;
                }
            }
        }
    }

    /*kspay통합창에 전달해줄 인자값들을 세팅합니다.*/
    document.authFrmFrame.sndOrdernumber.value     = document.KSPayWeb.sndOrdernumber.value;
    document.authFrmFrame.sndGoodname.value        = document.KSPayWeb.sndGoodname.value;
    document.authFrmFrame.sndInstallmenttype.value = document.KSPayWeb.sndInstallmenttype.value;
    document.authFrmFrame.sndAmount.value          = document.KSPayWeb.sndAmount.value;
    document.authFrmFrame.sndOrdername.value       = document.KSPayWeb.sndOrdername.value;
    document.authFrmFrame.sndAllregid.value        = document.KSPayWeb.sndAllregid.value;
    document.authFrmFrame.sndEmail.value           = document.KSPayWeb.sndEmail.value;
    document.authFrmFrame.sndMobile.value          = document.KSPayWeb.sndMobile.value;
    document.authFrmFrame.sndInteresttype.value    = document.KSPayWeb.sndInteresttype.value;
    document.authFrmFrame.sndCurrencytype.value    = document.KSPayWeb.sndCurrencytype.value;
    document.authFrmFrame.sndWptype.value          = document.KSPayWeb.sndWptype.value;
    document.authFrmFrame.sndAdulttype.value       = document.KSPayWeb.sndAdulttype.value;

    var height_ = 420;
    var width_ = 400;
    var left_ = screen.width;
    var top_ = screen.height;

    left_ = left_/2 - (width_/2);
    top_ = top_/2 - (height_/2);

    /*kspay통합창을 띄워줍니다.*/
    src = window.open('about:blank','AuthFrmUp',
            'height='+height_+',width='+width_+',status=yes,scrollbars=no,resizable=no,left='+left_+',top='+top_+'');
    document.authFrmFrame.target = 'AuthFrmUp';
    document.authFrmFrame.action ='https://kspay.ksnet.to/store/KSPayWebV1.3/KSPayWeb.jsp';
    document.authFrmFrame.submit();
}

/*goResult() - 함수설명 : 결재완료후 결과값을 지정된 결과페이지(result.php)로 전송합니다.*/
function goResult()
{
	document.KSPayWeb.target = "";
	document.KSPayWeb.submit();
}

/*paramSet() - 함수설명 : 결재완료후 (KSPayRcv.php로부터)결과값을 받아 지정된 결과페이지(result.php)로 전송될 form에 세팅합니다.*/
function paramSet(authyn,trno,trdt,trtm,authno,ordno,msg1,msg2,amt,temp_v,isscd,aqucd,remark,result)
{
	document.KSPayWeb.reAuthyn.value 	= authyn;
	document.KSPayWeb.reTrno.value 		= trno  ;
	document.KSPayWeb.reTrddt.value 	= trdt  ;
	document.KSPayWeb.reTrdtm.value 	= trtm  ;
	document.KSPayWeb.reAuthno.value 	= authno;
	document.KSPayWeb.reOrdno.value 	= ordno ;
	document.KSPayWeb.reMsg1.value 		= msg1  ;
	document.KSPayWeb.reMsg2.value 		= msg2  ;
	document.KSPayWeb.reAmt.value 		= amt   ;
	document.KSPayWeb.reTemp_v.value 	= temp_v;
	document.KSPayWeb.reIsscd.value 	= isscd ;
	document.KSPayWeb.reAqucd.value 	= aqucd ;
	document.KSPayWeb.reRemark.value 	= remark;
	document.KSPayWeb.reResult.value 	= result;
}

function OpenWindow()
{
	goOpen();
}
-->
</script>

<!----------------------------------------------- KSPayWeb Form에 대한 설명 ----------------------------------------------->
<!--결제완료후 결과값을 받아처리할 결과페이지의 주소-->
<!--KSPAY의 팝업결제창에서 결재가 이루어짐과 동시에 KSPayRcv.php가 구동되면서 아래의 value값이 채워지고 action경로로 값을 전달합니다-->
<!--action의 경로는 상대경로 절대경로 둘다 사용가능합니다-->
<!-- <form name=KSPayWeb action = "./result.php" method=post> -->
<form name=KSPayWeb action = "<?=$g4[shop_url]?>/settle_kspay_result.php" method=post>

<!-- 결과값 수신 파라메터 -->
<!-- 이곳의 value값을 채우지마십시오. KSPayRcv.php가 실행되면서 채워주는 값입니다-->
<input type=hidden name=reAuthyn value="">
<input type=hidden name=reTrno   value="">
<input type=hidden name=reTrddt  value="">
<input type=hidden name=reTrdtm  value="">
<input type=hidden name=reAuthno value="">
<input type=hidden name=reOrdno  value="">
<input type=hidden name=reMsg1   value="">
<input type=hidden name=reMsg2   value="">
<input type=hidden name=reAmt    value="">
<input type=hidden name=reTemp_v value="">
<input type=hidden name=reIsscd  value="">
<input type=hidden name=reAqucd  value="">
<input type=hidden name=reRemark value="">
<input type=hidden name=reResult value="">

<!--업체에서 추가하고자하는 임의의 인자값들을 추가합니다.-->
<!--이 파라메터들은 지정된결과 페이지(result.php)로 전송됩니다.-->
<input type=hidden name=a        value="<?=$_SESSION[ss_temp_on_uid]?>">
<input type=hidden name=b        value="b1">
<input type=hidden name=c        value="c1">
<input type=hidden name=d        value="d1">
<!----------------------------------------------- 고객에게 보여지지 않는 항목 ----------------------------------------------->
<!--이부분은 고객에게 보여지지 않아야 하는 항복입니다.-->
<!--
화폐단위
원화 : 410 또는 WON
미화 : 840 또는 USD
주의 : 미화승인은 영업부 담당자와 문의하여 처리하셔야 합니다.
		미화로 결제시 1000원이 1달러 입니다.
		예를들어 55달러이면 55000 으로 결제하셔야 합니다.
-->
<input type=hidden name=sndCurrencytype size=30 maxlength=3 value="WON">
<input type=hidden name=sndOrdernumber size=30 maxlength=30 value="<?=$od[od_id]?>">
<!--주민등록번호는 계좌이체를 사용하시는 업체만 값을 넘겨주시면 됩니다. 사용하지 않는 업체는 value값을 ""로 넘겨주세요. "-"는 빼고 입력-->
<input type=hidden name=sndAllregid size=30 maxlength=30 value="">
<!--상점에서 적용할 할부개월수를 세팅합니다. 여기서 세팅하신 값은 KSPAY결재팝업창에서 고객이 스크롤선택하게 됩니다 -->
<!--아래의 예의경우 고객은 0~12개월의 할부거래를 선택할수있게 됩니다. -->
<input type=hidden name=sndInstallmenttype size=30 maxlength=30 value="0:2:3:4:5:6:7:8:9:10:11:12">
<!--무이자 구분값은 중요합니다. 무이자선택하게 되면 상점쪽에서 이자를 내셔야합니다.-->
<!--무이자 할부를 적용하지 않는 업체는 value='NONE" 로 넘겨주셔야 합니다. -->
<!--예 : 3,4,5,6개월 무이자 적용할 때는 value="3:4:5:6" -->
<!--예 : 모두 무이자 적용할 때는 value="ALL" -->
<!--예 : 무이자 미적용할 때는 value="NONE" -->
<input type=hidden name=sndInteresttype size=30 maxlength=30 value="NONE">
<!--월드패스카드를 사용하시는 상점만 신경쓰시면 됩니다. 사용하지 않는 상점은 아무값이나 넘겨주시면 됩니다. 지우시면 안됩니다.-->
<input type=hidden    name=sndWptype value="1">
<!--
<input type="radio" name="sndWptype" value="1" checked>선불카드
<input type="radio" name="sndWptype" value="2">후불카드
<input type="radio" name="sndWptype" value="0">모든카드
-->
<input type=hidden name="sndAdulttype" value="0">
<!--
<input type="radio" name="sndAdulttype" value="1" checked>성인확인필요
<input type="radio" name="sndAdulttype" value="0">성인확인불필요
-->

<!----------------------------------------------- 고객에게 보여주는 항목 ----------------------------------------------->
<!--상품명은 30Byte(한글 15자)입니다. 특수문자 ' " - ` 는 사용하실수 없습니다. 따옴표,쌍따옴표,빼기,백쿼테이션 -->
<input type=hidden name=sndGoodname size=30 maxlength=30 value="<?=cut_str($goods,15,'')?>">
<input type=hidden name=sndAmount size=30 maxlength=9 value="<?=$settle_amount?>">
<input type=hidden name=sndOrdername size=30 maxlength=20 value="<?=$od[od_name]?>">
<!--KSPAY에서 결제정보를 메일로 보내줍니다.(신용카드거래에만 해당)-->
<input type=hidden name=sndEmail size=30 maxlength=50 value="<?=$od[od_email]?>">
<!--카드사에 SMS 서비스를 등록하신 고객에 한해서 SMS 문자메세지를 전송해 드립니다.(추후서비스예정 2004년11월10일 현재) -->
<!--전화번호 value 값에 -가 들어가면 안됩니다.-->
<input type=hidden name=sndMobile size=30 maxlength=20 value="<?=preg_replace("/[^0-9]/", "", $od[od_hp]);?>">
</form>

<!--dummy.php는 보안경고를 방지하기 위한 것입니다. 수정하지 마세요. -->
<IFRAME id=AuthFrame name=AuthFrame style="display:none" src="dummy.php"></IFRAME>
<div style="display:none">
<!----------------------------------------------- authFrmFrame Form에 대한 설명 ----------------------------------------------->
<!-- 상점에서 KSNET 결제팝업창으로 전송하는 파라메터입니다.-->
<form name=authFrmFrame target=AuthFrame method=post>
<!-- 상점아이디입니다. 초기 테스트아이디 2999199999. 테스트 종료 후 KSPAY에서 발급받은 실제 상점아이디로 바꿔주십시오.-->
<!-- 테스트아이디로 테스트하실 때 실제카드로 결제하셔도 고객에게 청구되지 않습니다. -->
<input type=hidden name=sndStoreid         value="<?=$default[de_kspay_id]?>">
<!--
backUrl은 페이지링크방식모듈에서 기존의 결과페이지로의 결과인자값전달외에, 지정된 URL로 결과전문을 전송해드리는 추가기능입니다.
backUrl은 사용하지 않으셔도 무방한 옵션기능입니다.
지정된 backUrl을 찾을수 없거나 올바른 응답값이 없을시 "상점BU오류"라는 거절메시지로 거절처리되고 원거래가 승인된경우 그거래는 자동취소됩니다.
backUrl기능은 신용카드거래에 한합니다.
-->
<input type=hidden name=sndBackUrl         value="">

<!-- 사용자가 접속한 URL을 받아와서 sndReply의 값에 세팅합니다.-->
<?
$server_protocal_tmp = explode("/", $_SERVER["SERVER_PROTOCOL"]);
$server_protocal = $server_protocal_tmp[0];
$http_host = $_SERVER["HTTP_HOST"];

$path_info_tmp = explode("/", $_SERVER["SCRIPT_NAME"]);
$path_info = "";
for($i = 0; $i < count($path_info_tmp)-1; $i++) {
	$path_info .= $path_info_tmp[$i]."/";
}
//$ret = $server_protocal."://".$http_host.$path_info."KSPayRcv.php";
//$ret = $server_protocal."://".$http_host.$path_info."$cart_dir/ordercardkspayrev.php";
$ret = "$g4[shop_url]/settle_kspay_rcv.php";
?>

<!-- sndReply는 KSPayRcv.php의 절대경로를 넣어줍니다.
<!-- KSPayRcv.php 역할 : KSPAY 결제팝업창에서 결제승인후에 값들을 본창의 KSPayWeb Form에 넘겨줍니다-->
<!-- sndReply가 오류날 경우에 본창으로 결과페이지가 넘어가지 않습니다. -->
<input type=hidden name=sndReply           value="<?echo($ret)?>">

<!--KSPAY 결제팝업창에서 사용가능한 결제수단을 세팅합니다. -->
<!--각결재수단은 각각의 계약이 이루어져 오픈되있어야 사용가능합니다.-->
<!--신용카드/가상계좌/계좌이체/월드패스카드/포인트-->
<!--예 : 신용카드만 선택 value="10000' -->
<!--예 : 신용카드,가상계좌,월드패스카드 선택 value="11010' -->
<?
switch ($settle_case)
{
    case '계좌이체' :
        $sndPaymethod = "00100";
        break;
    case '가상계좌' :
        $sndPaymethod = "01000";
        break;
    default : // 신용카드
        $sndPaymethod = "10000";
        break;
}
?>
<input type=hidden name=sndPaymethod       value="<?=$sndPaymethod?>"> <!-- 순서 : 신용카드, 가상계좌, 계좌이체, 월드패스카드, OK Cashbag -->
<input type=hidden name=sndOrdernumber	   value="">
<input type=hidden name=sndGoodname        value="">
<input type=hidden name=madeCompany	       value="">
<input type=hidden name=madeCountry	       value="">
<input type=hidden name=sndInstallmenttype value="">
<input type=hidden name=sndAmount          value="">
<input type=hidden name=sndOrdername       value="">
<input type=hidden name=sndAllregid        value="">
<input type=hidden name=sndEmail           value="">
<input type=hidden name=sndMobile          value="">
<input type=hidden name=sndInteresttype    value="">
<input type=hidden name=sndCurrencytype    value="">
<input type=hidden name=sndCashbag         value="0">          <!--OK CashBag-- 0: 미사용, 1: 사용 -->
<input type=hidden name=sndWptype          value="">
<input type=hidden name=sndAdulttype       value="">
<input type=hidden name=sndStoreName       value="<?=$default['de_admin_company_name']?>">    <!--회사명을 한글로 넣어주세요(최대20byte)-->
<input type=hidden name=sndStoreNameEng    value="kspay_store">   <!--회사명을 영어로 넣어주세요(최대20byte)-->
<input type=hidden name=sndStoreDomain     value="<?=$cfg[d_url]?>">   <!-- 회사 도메인을 http://를 포함해서 넣어주세요-->
<input type=hidden name=sndEscrow          value="">
<input type=hidden name=sndCertimethod	   value="IM">     <!-- I  : ISP결제, M : MPI결제, N : 해외카드 -->
</form>
</div>