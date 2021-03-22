<?
include_once("./_common.php");

$g4[title] = "현금영수증 발행";
include_once("$g4[path]/head.sub.php");

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
?>

<html>
<head>
<title>올더게이트-현금영수증</title>
<style type="text/css">
<!--
body { font-family:"돋움"; font-size:9pt; color:#000000; font-weight:normal; letter-spacing:0pt; line-height:180%; }
td { font-family:"돋움"; font-size:9pt; color:#000000; font-weight:normal; letter-spacing:0pt; line-height:180%; }
.clsright { padding-right:10px; text-align:right; }
.clsleft { padding-left:10px; text-align:left; }
-->
</style>
<script language=javascript>
//승인 취소시 승인번호 입력칸여부
function check_cash(){

  if (document.cash_pay.Pay_kind.value == "cash-appr" || document.cash_pay.Pay_kind.value == "cash-appr-temp"){
		    document.cash_pay.Org_adm_no.disabled = true;
			document.cash_pay.Org_adm_no.style.background = "silver";
		
}  else if (document.cash_pay.Pay_kind.value == "cash-cncl" || document.cash_pay.Pay_kind.value == "cash-cncl-temp"){
		    document.cash_pay.Org_adm_no.disabled = false;
			document.cash_pay.Org_adm_no.style.background = "white";
		}
}
</script>

<script language=javascript>
<!--
function send_form(){	

	form_name = document.cash_pay;  
	
	// 주민(핸드폰)번호 체크 - 주민(핸드폰)번호 13(10,11)자리입력시 체크함

	if (document.getElementById("Gubun_cd_01").checked){
	  	alert("소득공제용 현금영수증을 선택했습니다.");
    	if( !(form_name.Confirm_no.value.length == 10 || form_name.Confirm_no.value.length == 11 || form_name.Confirm_no.value.length == 13)) {
			alert("주민등록번호 13자리 또는 핸드폰 번호 10,11자리를 입력하세요.");
			return false;
	    }
	    if(form_name.Confirm_no.value.length == 13) {
		  	var obj = form_name.Confirm_no.value;
          	var sum=0;
                	
           	for(i=0;i<8;i++) { sum+=obj.substring(i,i+1)*(i+2); }
                	
           	for(i=8;i<12;i++) { sum+=obj.substring(i,i+1)*(i-6); }
                	
	       	sum=11-(sum%11);
               	
		   	if (sum>=10) { sum-=10; }
              	
           	if (obj.substring(12,13) != sum || (obj.substring(6,7) !=1 && obj.substring(6,7) != 2))	{
           	    alert("주민등록번호에 오류가 있습니다. 다시 확인하십시오.");
           	    return false;
		   	}
        }	       
    }

	 // 사업자 번호 체크 - 사업자번호10자리 입력시  체크함
		
	 if (document.getElementById("Gubun_cd_02").checked){
		  alert("지출증빙용 현금영수증을 선택했습니다.");	
		if(form_name.Confirm_no.value.length != 10)
		{
			alert("사업자번호 10자리를 입력하세요.");
			return false;
		} 
		else if(form_name.Confirm_no.value.length == 10) {
		   
	        var  obj = form_name.Confirm_no.value;
    			var sum = 0; 

    			var getlist =new Array(10); 

    			var chkvalue =new Array("1","3","7","1","3","7","1","3","5"); 

    			for(var i=0; i<10; i++) { getlist[i] = obj.substring(i, i+1); } 

    			for(var i=0; i<9; i++) { sum += getlist[i]*chkvalue[i]; } 

    			sum = sum + parseInt((getlist[8]*5)/10);  

    			sidliy = sum % 10; 

    			sidchk = 0; 

    			if(sidliy != 0) { sidchk = 10 - sidliy; } 

    			else { sidchk = 0; } 

    			if(sidchk != getlist[9]){
    				alert("사업자등록번호에 오류가 있습니다. 다시 확인하십시오.");    
    				return;
    			}
    			     	
	        } 
		 }
       //입력확인스크립트
	    if (form_name.Pay_kind.value == ""){
			alert("결제종류를 입력해 주세요.");
			return false;
		}	

		if (form_name.Retailer_id.value == ""){
			alert("서비스아이디를 입력해 주세요.");
			return false;
		}		
	
		if (form_name.Cust_no.value == ""){
			alert("회원아이디를 입력해 주세요.");
			return false;
		}	
		
		if (form_name.Order_no.value == ""){
			alert("주문번호를 입력해 주세요.");
			return false;
		}	
		
		if (form_name.Amtcash.value == ""){
			alert("거래금액을 입력해 주세요.");
			return false;
		}	

		if (form_name.Amttex.value == ""){
		    alert("부가가치세를 입력해 주세요.");
	     	return false;
		}

		if (form_name.Amtadd.value == ""){
		    alert("봉사료를 입력해 주세요.");
		    return false;
		}	

		if (form_name.Confirm_no.value ==""){
		    alert("신분확인번호 를 입력해 주세요");
            form_name.Confirm_no.focus();
			return false;
		}
					 
	// 결제금액이 5000 원 이상이어야 함
	// 현금결제금액 합산은 아래의 자바스크립트를 통해 반드시 확인 하도록 하시기 바라며, 
	// 아래의 자바스크립트를 사용하지 않아 발생된 문제는 상점에 책임이 있습니다.
	   var sum_deal = eval(form_name.deal_won.value) + eval(form_name.Amttex.value) + eval(form_name.Amtadd.value);
       if(form_name.Amtcash.value != sum_deal)
       {
	 	   alert("결제금액이 맞지 않습니다.");
		   return false;
	   }
//	   else if(sum_deal < 5000)
//	   {
//		   alert("총결제금액이 5천원 이상이어야 현금영수증 발행이 가능합니다.");
//		   return false;
//	   }
	 //중복요청 방지를 위해서 confirm 을 실행해야함
		if(form_name.Pay_kind.value == "cash-appr" || form_name.Pay_kind.value == "cash-cncl") {
		   if(confirm("현금영수증을 발행하시겠습니까?"))
		   { 
			   form_name.submit();
			   return true;	
			
		   } else {
			return false;
		   }
		} else if(form_name.Pay_kind.value == "cash-appr-temp" || form_name.Pay_kind.value == "cash-cncl-temp") {
		   if(confirm("현금영수증 발행내역을 임시저장하시겠습니까?"))
		   { 
			   form_name.submit();
			   return true;	
			
		   } else {
			return false;
		   }
		}
	}
	   
-->
</script>

<body topmargin=0 leftmargin=0 rightmargin=0 bottommargin=0>
<form name=cash_pay method=post action="taxsave_allthegate_ing.php">
<table border=0 width=100% height=100% cellpadding=0 cellspacing=0>
	<tr>
		<td align=center>
		<table width=100% border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td><hr></td>
			</tr>
			<tr>
				<td class=clsleft><b>현금영수증 발급</b></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td class=clsleft>☞ 표시는 필수 입력사항입니다. </td>
			</tr>
			<tr>
				<td><hr></td>
			</tr>
			<tr>
				<td>
                <input type="hidden" name="Pay_kind" value="cash-appr"> <!-- 현금영수증 승인 -->
                <input type="hidden" name="Retailer_id" value="<?=$default[de_allthegate_mid]?>"> <!-- 올더게이트 상점아이디 -->
                <input type="hidden" naMe="Cust_no" value="<?=$member[mb_id]?>"> <!-- 회원아이디 -->
                <input type="hidden" naMe="Order_no" value="<?=$od[od_id]?>"> <!-- 주문번호 -->
                <input type="hidden" naMe="Filler" value="<?=$od[on_uid]?>"> <!-- on_uid -->
                <input type="hidden" naMe="Amtcash" value="<?=$amt_tot?>"> <!-- 현금으로결제한총금액 -->
                <input type="hidden" naMe="deal_won" value="<?=$amt_sup?>"> <!-- 공급가액 -->
                <input type="hidden" naMe="Amttex" value="<?=$amt_tax?>"> <!-- 부가가치세 -->
                <input type="hidden" naMe="Amtadd" value="<?=$amt_svc?>"> <!-- 봉사료 -->
                <input type="hidden" name="prod_nm" value="<?=addslashes($goods_name)?>">

				<table width=100% border=0 cellpadding=0 cellspacing=0>
					<tr>
						<td width=150 class=clsleft> ☞&nbsp;&nbsp;결제금액</td>
						<td><?=number_format($amt_tot);?>원</td>
					</tr>

					<tr>
						<td class=clsleft> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;공급가액</td>
						<td><?=number_format($amt_sup);?>원</td>
					</tr>
					<tr>
						<td class=clsleft> ☞&nbsp;&nbsp;부가가치세</td>
						<td><?=number_format($amt_tax);?>원</td>
					</tr>
					<tr>
						<td class=clsleft> ☞&nbsp;&nbsp;봉사료</td>
						<td><?=number_format($amt_svc);?>원</td>
					</tr>
					<tr>
						<td class=clsleft> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;상품명</td>
						<td><?=$goods_name?></td>
					</tr>
					<!-- <tr>
						<td class=clsleft> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;상품수량</td>
						<td><input type=text style=width:100px name=prod_set value="2"></td>
					</tr> -->
					<tr>
						<td class=clsleft> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;이메일주소</td>
						<td>
							<input type=text style=width:200px name=Email value="<?=$od[od_email]?>">
							<!-- 메일주소 기입시 현금영수증 발행 확인 메일 발송 -->
						</td>
					</tr>
					<tr>
                     	<td class=clsleft>☞&nbsp;&nbsp;신분확인번호</td>
						<td><input type=text style=width:100px name=Confirm_no value=""><br />[주민(핸드폰)번호 & 사업자번호]</td>
					</tr>
					<!-- <tr>
						<td class=clsleft> ☞&nbsp;&nbsp;원거래승인번호</td>
						<td><input type=text style=width:100px class="form" name=Org_adm_no value="">취소시입력해야함</td>
						<td></td>
					</tr> -->
					<!-----------------단말기 번호는 7005037001 셋팅함 (수정불가)----------------------->
					<input type=hidden name=Cat_id value="7005037001">
					<!-----------------결제방식 무통장입금으로 셋팅함 무통장입금-1 , 계좌이체-2 -------------------------->
					<input type=hidden name=Pay_type value="1">
    				<tr>
						<td class=clsleft> ☞&nbsp;&nbsp;사용구분</td>
						<td class=clsleft>
                            <input type=radio name=Gubun_cd id="Gubun_cd_01" value="01" checked> 소득공제용
                            &nbsp;&nbsp;
                            <input type=radio name=Gubun_cd id="Gubun_cd_02" value="02"> 지출증빙용
                        </td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td><hr></td>
			</tr>
			<tr>
				<td align=center>
				<input type="button" value="요청" onclick="javascript:send_form()">
			    </td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>
		</td>
	</tr>
</table>

</form>
</body>
</html>
