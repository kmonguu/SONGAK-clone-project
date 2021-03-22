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
<!--
    /* ============================================================================== */
    /* =   PAGE : 등록 요청 PAGE                                                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2007   KCP Inc.   All Rights Reserverd.                   = */
    /* ============================================================================== */
//-->

<script language="javascript">

	// 주문번호 생성 예제
	function init_orderid()
	{
	    var today = new Date();
	    var year  = today.getFullYear();
	    var month = today.getMonth()+ 1;
	    var date  = today.getDate();
	    var time  = today.getTime();

	    if(parseInt(month) < 10)
	    {
	        month = "0" + month;
	    }

	    var vOrderID = year + "" + month + "" + date + "" + time;

	    document.forms[0].ordr_idxx.value = vOrderID;
	}

    // 현금영수증 MAIN FUNC
    function  jsf__pay_cash( form )
    {
        jsf__show_progress(true);

        if ( jsf__chk_cash( form ) == false )
        {
            jsf__show_progress(false);
            return;
        }

        form.ordr_idxx.value = "<?=$od[od_id]?>";
        form.amt_tot.value = "<?=$amt_tot?>";
        form.amt_sup.value = "<?=$amt_sup?>";
        form.amt_svc.value = "<?=$amt_svc?>";
        form.amt_tax.value = "<?=$amt_tax?>";

        form.submit();
    }

    // 진행 바
    function  jsf__show_progress( show )
    {
        if ( show == true )
        {
            window.show_pay_btn.style.display  = "none";
            window.show_progress.style.display = "inline";
        }
        else
        {
            window.show_pay_btn.style.display  = "inline";
            window.show_progress.style.display = "none";
        }
    }

	// 포맷 체크
    function  jsf__chk_cash( form )
    {
        if ( form.trad_time.value.length != 14 )
        {
            alert("원 거래 시각을 정확히 입력해 주시기 바랍니다.");
            form.trad_time.select();
            form.trad_time.focus();
            return false;
        }

		if ( form.corp_type.value == "1" )
        {
            if ( form.corp_tax_no.value.length != 10 )
            {
                alert("발행 사업자번호를 정확히 입력해 주시기 바랍니다.");
                form.corp_tax_no.select();
                form.corp_tax_no.focus();
                return false;
            }
        }

        if (  form.tr_code[0].checked )
        {
            if ( form.id_info.value.length != 10 &&
            	 form.id_info.value.length != 11 &&
            	 form.id_info.value.length != 13 )
            {
                alert("주민번호 또는 휴대폰번호를 정확히 입력해 주시기 바랍니다.");
                form.id_info.select();
                form.id_info.focus();
                return false;
            }
        }
        else if (  form.tr_code[1].checked )
        {
            if ( form.id_info.value.length != 10 )
            {
                alert("사업자번호를 정확히 입력해 주시기 바랍니다.");
                form.id_info.select();
                form.id_info.focus();
                return false;
            }
        }
        return true;
    }

    function  jsf__chk_tr_code( form )
    {
        var span_tr_code_0 = document.getElementById( "span_tr_code_0" );
        var span_tr_code_1 = document.getElementById( "span_tr_code_1" );

        if ( form.tr_code[0].checked )
        {
            span_tr_code_0.style.display = "block";
            span_tr_code_1.style.display = "none";
        }
        else if (form.tr_code[1].checked )
        {
            span_tr_code_0.style.display = "none";
            span_tr_code_1.style.display = "block";
        }
    }

</script>
<style>
    .tb_taxinner {border-collapse:collapse;}
    td {height:20px;}
    table table tr td:nth-child(1) {font-weight:bold;}
</style>
</head>
<!-- <body onload="init_orderid();"> -->
<body>
<form name="cash_form" action="./kcp/pp_cli_cash_hub.php" method="post">
<input type="hidden" name="corp_type" value="0"> <!-- 사업자 구분 - 0:직접판매 , 1:입점몰판매 -->
<input type="hidden" name="ordr_idxx">
<input type="hidden" name="good_name" value="<?=addslashes($goods_name)?>">
<input type="hidden" name="buyr_name" value="<?=$od[od_name]?>">
<input type="hidden" name="buyr_mail" value="<?=$od[od_email]?>">
<input type="hidden" name="buyr_tel1" value="<?=$od[od_tel]?>">
<input type="hidden" name="trad_time" value="<?=$trad_time?>">

<input type="hidden" name="amt_tot">
<input type="hidden" name="amt_sup">
<input type="hidden" name="amt_svc">
<input type="hidden" name="amt_tax">
<table border="0" cellpadding="0" cellspacing="1" width="500" align="center">

    <tr>
        <td colspan="2">
            <table width="95%" align="center">

                <tr style="background:#efefef;">
                    <td align="center" style="padding:10px;"><B>주문 정보</B></td>
                </tr>

            </table>
            <table width="95%" align="center" class="tb_taxinner">
                <tr>
                    <td>주문 번호</td>
                    <td><?=$od[od_id]?></td>
                </tr>
                <tr>
                    <td>상품 정보</td>
                    <td><?=$goods_name?></td>
                </tr>
                <tr>
                    <td>주문자 이름</td>
                    <td><?=$od[od_name]?></td>
                </tr>
                <tr>
                    <td>주문자 E-Mail</td>
                    <td><?=$od[od_email]?></td>
                </tr>
                <tr>
                    <td>주문자 전화번호</td>
                    <td><?=$od[od_tel]?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
               

                <tr style="background:#efefef;">
                    <td align="center" style="padding:10px;" colspan="2"><B>현금영수증 발급 정보</B></td>
                </tr>

                <tr>
                    <td>원 거래 시각</td>
                    <td><?=$trad_time?></td>
                </tr>

                <tr>
                	<td>발행 용도</td>
                	<td>
                    	<input type="radio" name="tr_code" value="0" onClick="jsf__chk_tr_code( this.form )" checked>소득공제용&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    	<input type="radio" name="tr_code" value="1" onClick="jsf__chk_tr_code( this.form )">지출증빙용
                    </td>
                </tr>
                <tr>
                    <td width="40%">
                        <span id="span_tr_code_0" style="display:block;">휴대폰번호</span>
                        <span id="span_tr_code_1" style="display:none;">사업자번호</span>
                    </td>
                    <td width="60%">
                        <input type="tel" name="id_info" size="16" maxlength="13"> ("-" 생략)
                    </td>
                </tr>
                <tr>
                    <td>거래금액 총합</td>
                    <td><?=number_format($amt_tot)?>원</td>
                </tr>
                <tr>
                    <td>공급가액</td>
                    <td><?=number_format($amt_sup)?>원<!-- ((거래금액 총합 * 10) / 11) --></td>
                </tr>
                <tr>
                    <td>봉사료</td>
                    <td><?=number_format($amt_svc)?>원</td>
                </tr>
                <tr>
                    <td>부가가치세</td>
                    <td><?=number_format($amt_tax)?>원<!-- 거래금액 총합 - 공급가액 - 봉사료 --></td>
                </tr>
                <tr>
                    <td colspan="2" align="center" style="padding-top:5px;">
                    
                        <span id="show_pay_btn">
                            <span class="btn1"  onclick="jsf__pay_cash( document.cash_form )">등록 요청</span>
                        </span>
                        <span id="show_progress" style="display:none">
                            <b>등록 진행중입니다. 잠시만 기다려주십시오</b>
                        </span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td colspan="2" align="center" height="25"><br/>ⓒ Copyright 2007. KCP Inc.  All Rights Reserved.</td>
    </tr>
</table>
<!-- 요청종류 승인(pay)/변경(mod) 요청시 사용 -->
<input type="hidden" name="req_tx" value="pay">
</form>

<?
include_once("$g4[path]/tail.sub.php");
?>
