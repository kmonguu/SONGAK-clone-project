<?
include_once("./_common.php");
$pageNum = 100;
$subNum = 5;
if (!$is_member)
    goto_url("$g4[path]/bbs/login.php?url=".urlencode("$g4[shop_path]/mypage.php"));

$g4[title] = "마이페이지";
include_once("./_head.php");

//$str = $g4[title];
//include("./navigation2.inc.php");
?>



<div class="ShopCover" >


<table cellpadding=0 cellspacing=0 align=center width=98%>
	<tr>
		<td>&nbsp;</td>
		<td align=right >
			<div style="margin-right:1px;">
				<? if ($is_admin == 'super') {?>
				<a href='<?=$g4[admin_path]?>/' class=''><span class="btn1-o">ADMIN</span></a> 
				<?} ?>

				<a href='<?=$g4[bbs_path]?>/member_confirm.php?url=register_form.php' class=''><span class="btn1">회원정보변경</span></a> 
				<a  href="javascript:member_leave();" class=''><span class="btn1">회원탈퇴</span></a> 

			</div>
		</td>
	</tr>
</table>

<script language="JavaScript">
function member_leave()
{
    if (confirm("정말 회원에서 탈퇴 하시겠습니까?"))
            location.href = "<?=$g4[bbs_path]?>/member_confirm.php?url=member_leave.php";
}
</script>


<br/>

<table class="mypage_tb" width="98%" align=center style="border-collapse:collapse;">
	<colgroup>
		<col width="17%" />
		<col width="35%"/>
		<col width="17%" />
		<col />
	</colgroup>
	<tbody>
		<tr bgcolor="#efefef" >
			<td colspan="4" style='height:34px; padding-left:10px; font-size:10pt; border-top:1px solid #222222;border-bottom:1px solid #999999;'>
				<B><?=$member[mb_name]?></B> 님의 마이페이지입니다.
			</td>
		</tr>
		
		<tr>
			<?if($config["cf_use_point"]){?>
				<td class="mp_it_tit">보유 적립금</td>
				<td class="mp_it_cont">
					<a href="javascript:win_point();"><?=number_format($member[mb_point])?>점</a>
				</td>
				<td class="mp_it_tit2">회원권한</td>
				<td class="mp_it_cont"><?=$member[mb_level]?></td>
			<?}else{?>
				<td class="mp_it_tit">회원권한</td>
				<td class="mp_it_cont" colspan="3" ><?=$member[mb_level]?></td>
			<?}?>
		</tr>
		
		<tr>
			<td class="mp_it_tit">주소</td>
			<td class="mp_it_cont"><?=sprintf("(%s) %s %s", $member[mb_zip1], $member[mb_addr1], $member[mb_addr2]);?></td>
			<td class="mp_it_tit2">최종접속일시</td>
			<td class="mp_it_cont"><?=$member[mb_today_login]?></td>
		</tr>
		
		<tr>
			<td class="mp_it_tit">연락처</td>
			<td class="mp_it_cont"><?=$member[mb_hp]?></td>
			<td class="mp_it_tit2">회원가입일시</td>
			<td class="mp_it_cont"><?=$member[mb_datetime]?></td>
		</tr>
		
		<tr>
			<td class="mp_it_tit">E-mail</td>
			<td class="mp_it_cont" colspan="3"><?=$member[mb_email]?></td>
		</tr>
		
		
	</tbody>
	
</table>

<br/>
<br/>



<table width=98% cellpadding=0 cellspacing=0 align=center>
<tr>
    <td height=35 style="font-size:17px;font-weight:bold;padding-left:13px;">최근 구매내역</td>
    <td align=right><a href='./orderinquiry.php' class=""><span class="btn1-o">more</span></a></td>
</tr>
</table>
<br>

<?
// 최근 주문내역
define("_ORDERINQUIRY_", true);

$limit = " limit 0, 5 ";
include "$g4[shop_path]/orderinquiry.sub.php";
?>


</div>



<!--
<table width=98% cellpadding=0 cellspacing=0 align=center>
<tr>
    <td height=35 colspan=2><img src='<?=$g4[shop_img_path]?>/my_title02.gif'></td>
    <td align=right><a href='./wishlist.php'><img src='<?=$g4[shop_img_path]?>/icon_more.gif' border=0></a></td>
</tr>
<tr><td height=2 colspan=3 class=c1></td></tr>
<tr align=center height=25 class=c2>
    <td colspan=2>상품명</td>
    <td>보관일시</td>
</tr>
<tr><td height=1 colspan=3 class=c1></td></tr>
<?
$sql = " select *
           from $g4[yc4_wish_table] a,
                $g4[yc4_item_table] b
          where a.mb_id = '$member[mb_id]'
            and a.it_id  = b.it_id
          order by a.wi_id desc
          limit 0, 3 ";
$result = sql_query($sql);
for ($i=0; $row = sql_fetch_array($result); $i++)
{
    if ($i>0)
        echo "<tr><td colspan=3 height=1 background='$g4[shop_img_path]/dot_line.gif'></td></tr>";

    $image = get_it_image($row[it_id]."_s", 50, 50, $row[it_id]);

    echo "<tr align=center height=60>";
    echo "<td width=100>$image</td>";
    echo "<td align=left><a href='./item.php?it_id=$row[it_id]'>".stripslashes($row[it_name])."</a></td>";
    echo "<td>$row[wi_time]</td>";
    echo "</tr>";
}

if ($i == 0)
    echo "<tr><td colspan=3 height=100 align=center><span class=point>보관 내역이 없습니다.</span></td></tr>";
?>
<tr><td height=1 colspan=3 bgcolor=#94D7E7></td></tr>
</table>

-->
<?
include_once("./_tail.php");
?>