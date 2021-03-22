<?include_once("./_common.php");?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?=$g4['charset']?>">
<title>판매자님께 주문서 메일 드리기</title>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" cellspacing="0" cellpadding="0" border=0>
<tr><td width="25" height="25" colspan=3>&nbsp;</td></tr>
<tr>
    <td width="25" valign="top"><img src="<?=$g4['shop_url']?>/mail/img/mail_left.gif" width="25" height="281"></td>
    <td class="line" align=center>
        <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td height="59" background="<?=$g4['shop_url']?>/mail/img/mail_bg2.gif" style='padding-left:20px'>
                <strong><font color="#02253A">본 메일은 <?=$g4[time_ymdhis]?> (<?=get_yoil($g4[time_ymdhis])?>)을 기준으로 작성되었습니다.</font></strong>
            </td>
        </tr>
        </table>
        <p>

        <!-- 주문내역  -->
        <table width="95%" cellpadding="0" cellspacing="0">  
        <col width=200>                    
        <col width=110>
        <col width=150>
        <col width=1>
        <col width=''>
        <tr>
            <td rowspan=6 align=center><a href='<?="$g4[shop_url]/item.php?it_id={$list[it_id]}"?>' target=_blank><?=$list[it_simg]?></a></td>
            <td height=22 style="text-align:left;"> □  주문제품명</td>
            <td colspan=3 style="text-align:left;">: <B><?=$list[it_name]?></B></td>
        </tr>
        <tr><td colspan=4 bgcolor=#DDDDDD height=1></td></tr>
        <tr>
            <td height=22 style="text-align:left;"> □  주문번호</td>
            <td style="text-align:left;">: <font color=#CC3300><B><?=$od_id?></B></font></td>
            <td rowspan=4 bgcolor=#DDDDDD></td>
            <td style="text-align:left;">&nbsp; □  선택옵션 </td>
        </tr>
        <tr><td colspan=2 bgcolor=#DDDDDD height=1></td></tr>
        <tr>
            <td height=22 style="text-align:left;"> □  수량</td>
            <td style="text-align:left;">: <b><?=number_format($list[ct_qty])?></b>개</td>
            <td style="padding-left:10px; padding-top:0px; text-align:left;"><?=$list[it_opt]?></td>
        </tr>
        <tr><td colspan=4 bgcolor=#DDDDDD height=1></td></tr>
        </table><p>
        <!-- 주문내역 END -->

        <!-- 주문자 정보 -->
        <table width="95%" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td height=30 style="text-align:left;"><B>주문하신 분 정보</B></td>
        </tr>
        <tr>
            <td>
                <table width="100%" cellpadding="4" cellspacing="0">
                <col width=110>                    
                <col width=''>
                <tr><td colspan=2 height=2 bgcolor=#DFDED9></td></tr>
                <tr bgcolor="#F8F7F2">
                    <td style="text-align:left;" height=22>□ 이 름</td>
                    <td style="text-align:left;">: <?=$od_name?></td>
                </tr>
                <tr bgcolor="#F8F7F2">
                    <td style="text-align:left;" height=22>□ 전화번호</td>
                    <td style="text-align:left;">: <?=$od_tel?></td>
                </tr>
                <tr bgcolor="#F8F7F2">
                    <td style="text-align:left;" height=22>□ 핸드폰</td>
                    <td style="text-align:left;">: <?=$od_hp?></td>
                </tr>
                <tr bgcolor="#F8F7F2">
                    <td style="text-align:left;" height=22>□ 주 소</td>
                    <td style="text-align:left;">: <?=sprintf("(%s-%s) %s %s", $od_zip1, $od_zip2, $od_addr1, $od_addr2)?></td>
                </tr>

                <? if ($od_hope_date) { ?>
                <tr bgcolor="#F8F7F2">
                    <td style="text-align:left;" height=22>□ 희망배송일</td>
                    <td style="text-align:left;">: <?=$od_hope_date?> (<?=get_yoil($od_hope_date)?>)</td>
                </tr>
                <? } ?>
                <tr><td colspan=2 height=2 bgcolor=#DFDED9></td></tr>
                </table>
            </td>
        </tr>
        </table>   
        <!-- 주문자 정보 END-->
        
  
        <p>
        <!-- 배송지 정보 -->
		<?
			$mdObj = new Yc4MultiDelivery();
			$mdResult = $mdObj->get_list($od_id, 1, "", "", "", "", PHP_INT_MAX, "", "");
			$mdlist = $mdResult["list"];
			if(count($mdlist) == 0){
		?>

			<table width="95%" align="center" cellpadding="0" cellspacing="0">
			<tr><td height=30 style="text-align:left;"><B>배송지 정보</B></td></tr>
			<tr>
				<td>
					<table width="100%" cellpadding="4" cellspacing="0">
					<col width=110>                    
					<col width=''>
					<tr><td colspan=2 height=2 bgcolor=#DFDED9></td></tr>
					<tr bgcolor="#F8F7F2">
						<td style="text-align:left;" height=22>□ 이 름</td>
						<td style="text-align:left;">: <?=$od_b_name?></td>
					</tr>
					<tr bgcolor="#F8F7F2">
						<td style="text-align:left;" height=22>□ 전화번호</td>
						<td style="text-align:left;">: <?=$od_b_tel?></td>
					</tr>
					<tr bgcolor="#F8F7F2">
						<td style="text-align:left;" height=22>□ 핸드폰</td>
						<td style="text-align:left;">: <?=$od_b_hp?></td>
					</tr>
					<tr bgcolor="#F8F7F2">
						<td style="text-align:left;" height=22>□ 주 소</td>
						<td style="text-align:left;">: <?=sprintf("(%s%s) %s %s", $od_b_zip1, $od_b_zip2, $od_b_addr1, $od_b_addr2)?></td>
					</tr>
					<tr bgcolor="#F8F7F2">
						<td style="text-align:left;" height=22> □ 전하실 말씀</td>
						<td style="text-align:left;">: <?=$od_memo?></td>
					</tr>
					<tr><td colspan=2 height=2 bgcolor=#DFDED9></td></tr>
					</table>
				</td>
			</tr>
			<tr><td height=30 style="color:#A26217; text-align:right;">상세한 내용은 운영자 화면에서 확인하실 수 있습니다. [<a href='<?="$g4[shop_admin_url]/orderform.php?od_id=$od_id"?>'>바로가기</a>]</td></tr>
			</table> 

		<?} else {

			$cnt = 0;
			for($idx = 0 ; $idx < count($mdlist); $idx++){
				$md = $mdlist[$idx];
				$cnt++;			
			?>
				
			<table width="95%" align="center" cellpadding="0" cellspacing="0">
			<tr><td height=30 style="text-align:left;"><B>[배송지 <?=$cnt?>] 받으시는 분</B></td></tr>
			<tr>
				<td>
					<table width="100%" cellpadding="4" cellspacing="0">
					<col width=110>                    
					<col width=''>
					<tr><td colspan=2 height=2 bgcolor=#DFDED9></td></tr>
					<tr bgcolor="#F8F7F2">
						<td style="text-align:left;" height=22>□ 이 름</td>
						<td style="text-align:left;">: <?=$md["md_name"]?></td>
					</tr>
					<tr bgcolor="#F8F7F2">
						<td style="text-align:left;" height=22>□ 전화번호</td>
						<td style="text-align:left;">: <?=$md["md_tel"]?></td>
					</tr>
					<tr bgcolor="#F8F7F2">
						<td style="text-align:left;" height=22>□ 핸드폰</td>
						<td style="text-align:left;">: <?=$md["md_hp"]?></td>
					</tr>
					<tr bgcolor="#F8F7F2">
						<td style="text-align:left;" height=22>□ 주 소</td>
						<td style="text-align:left;">: <?=sprintf("(%s) %s %s", $md["md_zip1"], $md["md_addr1"], $md["md_addr2"])?></td>
					</tr>
					<tr bgcolor="#F8F7F2">
						<td style="text-align:left;" height=22> □ 전하실 말씀</td>
						<td style="text-align:left;">: <?=$md["md_memo"]?></td>
					</tr>

					<tr bgcolor="#F8F7F2">
						<td style="text-align:left;" height=22> □ 배송수량</td>
						<td style="text-align:left;"><?=str_replace("\r\n", " | ", $md["md_qty"])?></td>
					</tr>

					<tr><td colspan=2 height=2 bgcolor=#DFDED9></td></tr>
					</table>
				</td>
			</tr>
			</table> 



			<?}?>
			<table width="95%" align="center" cellpadding="0" cellspacing="0">
				<tr><td height=30 style="color:#A26217; text-align:right;">상세한 내용은 운영자 화면에서 확인하실 수 있습니다. [<a href='<?="$g4[shop_admin_url]/orderform.php?od_id=$od_id"?>'>바로가기</a>]</td></tr>
			</table>
		<?}?>
		
        <!-- 배송지정보 END-->
       
        <table width=95%>
        <tr><td height=30 align=right></td></tr>
        </table>
    </td>
    <td width="25" valign="top"><img src="<?=$g4['shop_url']?>/mail/img/mail_right.gif" width="25" height="281"></td>
</tr>
</table>

</body>
</html>
