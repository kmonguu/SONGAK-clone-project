<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

/*
if ($settle_case == '계좌이체')
{
    alert("이니시스 에스크로의 경우 계좌이체가 서비스가 아직 가능하지 않습니다.\\n\\n가상계좌 결제를 사용하여 주십시오.");
}
*/
?>

<script language=javascript src="http://plugin.inicis.com/pay40.js"></script>
<script language=javascript>

var openwin;

// 플러그인 설치(확인)
StartSmartUpdate();

function pay(frm)
{
	// MakePayMessage()를 호출함으로써 플러그인이 화면에 나타나며, Hidden Field
	// 에 값들이 채워지게 됩니다. 일반적인 경우, 플러그인은 통신을 하는 것이
	// 아니라, Hidden Field의 값들을 채우고 종료한다는 사실에 유의하십시오.

	if(document.ini.clickcontrol.value == "enable")
	{
		
		if(document.ini.goodname.value == "")  // 필수항목 체크 (상품명, 상품가격, 구매자명, 구매자 이메일주소, 구매자 전화번호)
		{
			alert("상품명이 빠졌습니다. 필수항목입니다.");
			return false;
		}
		else if(document.ini.price.value == "")
		{
			alert("상품가격이 빠졌습니다. 필수항목입니다.");
			return false;
		}
		else if(document.ini.buyername.value == "")
		{
			alert("구매자명이 빠졌습니다. 필수항목입니다.");
			return false;
		}
		else if(document.ini.buyeremail.value == "")
		{
			alert("구매자 이메일주소가 빠졌습니다. 필수항목입니다.");
			return false;
		}
		else if(document.ini.buyertel.value == "")
		{
			alert("구매자 전화번호가 빠졌습니다. 필수항목입니다.");
			return false;
		}
		else if(document.INIpay == null || document.INIpay.object == null)  // 플러그인 설치유무 체크
		{
			alert("플러그인 설치 후 다시 시도 하십시오.");
			return false;
		}
		else
		{
			/******
			 * 플러그인이 참조하는 각종 지불옵션을 이곳에서 수행할 수 있습니다.
			 * (자바스크립트를 이용한 동적 옵션처리)
			 */
			
			// 50000원 미만은 할부불가
			if(parseInt(frm.price.value) < 50000)
				frm.quotabase.value = "일시불";
				
			/****
			<작성예> 100000원 미만은 무이자할부가 불가능하도록 설정
			if(parseInt(frm.price.value) < 100000)
				frm.nointerest.value = "no";
			****/
			 
			if (MakePayMessage(frm))
			{
				disable_click();
				openwin = window.open("<?=$g4[shop_url]?>/settle_inicis_childwin.php","childwin","width=300,height=160");
				
								
				return true;
			}
			else
			{
				alert("지불에 실패하였습니다.");
				return false;
			}
		}
	}
	else
	{
		return false;
	}
}


function enable_click()
{
	document.ini.clickcontrol.value = "enable"
}

function disable_click()
{
	document.ini.clickcontrol.value = "disable"
}

function focus_control()
{
	if(document.ini.clickcontrol.value == "disable")
		openwin.focus();
}
</script>	

<!-- pay()가 "true"를 반환하면 post된다 -->
<form name=ini method=post action="<?=$g4[shop_url]?>/settle_inicis_result.php" onSubmit="return pay(this)">
<!-- 결제수단 -->
<?
switch ($settle_case)
{
    case '계좌이체' :
        $settle_method = "onlydbank";
        break;
    case '가상계좌' :
        $settle_method = "onlyvbank";
        break;
    default : // 신용카드
        $settle_method = "onlycard";
        break;
}
?>
<input type=hidden name=gopaymethod value="<?=$settle_method?>">
<!-- 상품명 -->
<!-- <input type=hidden name=goodname value="<?=$goods?>"> -->
<input type=hidden name=goodname value="<?=str_replace("'", "", stripslashes($goods))?>">
<!-- 가격 -->
<input type=hidden name=price value="<?=$settle_amount?>">
<!-- 성명 -->
<input type=hidden name=buyername value="<?=$od[od_name]?>">
<!-- 전자우편 -->
<input type=hidden name=buyeremail value="<?=$od[od_email]?>">
<!-- 이동전화 -->
<input type=hidden name=buyertel value="<?=$od[od_hp]?>">
<!-- 
수취인 정보는 필수 필드는 아니지만 카드사에 정책에 따라 필수필드로 바뀔 수 있습니다.
컨텐츠 업체는 수취인 관련 필드 해당없음
-->
<!-- 수취인성명 : 최대 30 byte 길이-->
<input type=hidden name=recvname value="">
<!-- 수취인 전화번호 : 최대 30 byte 길이-->
<input type=hidden name=recvtel value="">
<!-- 수취인 주소 : 최대 100 byte 길이-->
<input type=hidden name=recvaddr value="">
<!-- 수취인 우편번호 : 최대 6byte 길이-->
<input type=hidden name=recvpostnum value="">
<!-- 
상점아이디.
테스트를 마친 후, 발급받은 아이디로 바꾸어 주십시오.
-->
<input type=hidden name=mid value="<?=$default[de_inicis_mid]?>">
<!--
화폐단위
WON 또는 CENT
주의 : 미화승인은 별도 계약이 필요합니다.
-->
<input type=hidden name=currency value="WON">
<!--
무이자 할부
무이자로 할부를 제공 : yes
무이자할부는 별도 계약이 필요합니다.
카드사별,할부개월수별 무이자할부 적용은 아래의 카드할부기간을 참조 하십시오.
무이자할부 옵션 적용은 반드시 매뉴얼을 참조하여 주십시오.
-->
<input type=hidden name=nointerest value="no">
<!--
카드할부기간
각 카드사별로 지원하는 개월수가 다르므로 유의하시기 바랍니다.

value의 마지막 부분에 카드사코드와 할부기간을 입력하면 해당 카드사의 해당
할부개월만 무이자할부로 처리됩니다 (매뉴얼 참조).
-->
<input type=hidden name=quotabase value="선택:일시불:3개월:4개월:5개월:6개월:7개월:8개월:9개월:10개월:11개월:12개월">
<!-- 기타설정 -->
<!--
SKIN : 플러그인 스킨 칼라 변경 기능 - 6가지 칼라(ORIGINAL, GREEN, ORANGE, BLUE, KAKKI, GRAY)
HPP : 컨텐츠 또는 실물 지불 여부에 따라 HPP(1)과 HPP(2)중 선택 적용(HPP(1):컨텐츠, HPP(2):실물).
NEMO : 컨텐츠 또는 실물 지불 여부에 따라 NEMO(1)과 NEMO(2)중 선택 적용(NEMO(1):컨텐츠, NEMO(2):실물).
-->
<input type=hidden name=acceptmethod value="SKIN(ORIGINAL):HPP(1):NEMO(1)">
<!--
주민번호 : 실시간 계좌이체 관련 필수필드로 반드시 로그인한 회원의 주민번호를 
회원DB에서 추출하여 페이지에 추가해야 합니다.
고객이 직접 주민번호를 지불요청 페이지에 입력하는 경우 계좌도용 등의 사고 발생시 추적이 불가능하오니
반드시 회원DB에서 추출하여 페이지에 세팅하시기 바랍니다.
주민번호를 지불요청 페이지에 입력할 수 있도록 페이지를 수정하는 경우 도용사고 발생시 이니시스 책임이 없습니다
-->
<input type=hidden name=INIregno value="">
<!--
상점 주문번호 : 무통장입금 예약(가상계좌 이체),전화결재(1588 Bill) 관련 필수필드로 반드시 상점의 주문번호를 페이지에 추가해야 합니다.
지불수단 중에 실시간 계좌이체 이용 시에는 주문 번호가 지불결과를 조회하는 기준 필드가 됩니다.
상점 주문번호는 최대 40 BYTE 길이입니다.
-->
<input type=hidden name=oid value="<?=$od[od_id]?>">
<!--
플러그인 좌측 상단 상점 로고 이미지 사용
플러그인 좌측 상단에 상점 로고 이미지를 사용하실 수 있으며,
주석을 풀고 이미지가 있는 URL을 입력하시면 플러그인 상단 부분에 상점 이미지를 삽입할수 있습니다.
-->
<!--input type=hidden name=ini_logoimage_url  value="[사용할 로고이미지주소]"-->

<!--
좌측 지불메뉴 위치에 이미지 추가 
좌측 지불메뉴 위치에 미미지를 추가하시 위해서는 담당 영업대표에게 사용여부 계약을 하신 후
주석을 풀고 이미지가 있는 URL을 입력하시면 플러그인 좌측 지불메뉴 부분에 이미지를 삽입할수 있습니다.
-->
<!--input type=hidden name=ini_menuarea_url value="http://[사용할 이미지주소]"-->

<!--
플러그인에 의해서 값이 채워지거나, 플러그인이 참조하는 필드들
삭제/수정 불가
-->
<input type=hidden name=quotainterest value="">
<input type=hidden name=paymethod value="">
<input type=hidden name=cardcode value="">
<input type=hidden name=cardquota value="">
<input type=hidden name=rbankcode value="">
<input type=hidden name=reqsign value="DONE">
<input type=hidden name=encrypted value="">
<input type=hidden name=sessionkey value="">
<input type=hidden name=uid value="">
<input type=hidden name=sid value="">
<input type=hidden name=version value=4000>
<input type=hidden name=clickcontrol value="">

<!-- 머천트 리저브드 -->
<input type=hidden name=on_uid value="<?=$_SESSION[ss_temp_on_uid]?>">
<input type=hidden name=od_id value="<?=$od[od_id]?>">
</form>

<script language="JavaScript">
<!--
    enable_click();
    focus_control();

    function OpenWindow()
    {
        //var jumin = prompt("주민등록번호 13자리를 '-' 없이 입력하십시오.\n실시간 계좌이체의 경우 주민등록번호를 요구하며 저장하지는 않습니다.", "");

        //if (!(jumin == null || jumin == "")) {
        //    document.ini.INIregno.value = jumin;
            if (pay(document.ini)) {
                document.ini.submit();
            }
        //}
    }
//-->
</script>