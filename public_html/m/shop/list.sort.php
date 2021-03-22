<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

$link_basic = $_SERVER[PHP_SELF]."?ca_id=".$ca_id."&skin=".$skin."&ev_id=".$ev_id."&sort=";

$sort_name = array();
$sort_name["it_type3 desc"] = "신상품";
$sort_name["it_amount asc"] = "낮은가격";
$sort_name["it_amount desc"] = "높은가격";
$sort_name["it_type4 desc"] = "인기상품";
$sort_name["it_hit desc"] = "조회";
?>

<style>
.SortArea { width:100%; height:35px; line-height:35px; display:inline-block; box-sizing:border-box; }
.totalprice { color:#333; font-size:17px; font-weight:400; display:inline-block; float:left; }

#it_sort { float:right; width:138px; height:35px; position:relative; }
#it_sort > span { width:100%; height:100%; line-height:33px; display:inline-block; border:1px solid #dcdcdc; box-sizing:border-box; background:url("/m/images/sort_arrow.jpg") no-repeat right 17px top 14px, #fff; padding-left:19px; font-size:16px; color:#000; font-weight:400; }
#it_sort.on > span { background:url("/m/images/sort_arrow_on.jpg") no-repeat right 17px top 14px, #fff; }

#it_sort > ul { position:absolute; left:0px; top:35px; background:#fff; border:1px solid #dcdcdc; border-top:0px; width:100%; box-sizing:border-box; display:none; padding:10px 0; z-index:50; }
#it_sort.on > ul { display:inline-block; }
#it_sort > ul > li { float:left; width:100%; }
#it_sort > ul > li > a { display:inline-block; width:100%; box-sizing:border-box; padding:0 0 0 19px; text-decoration:none; line-height:35px; font-size:16px; color:#666; font-weight:400; }
#it_sort > ul > li > a.on { color:#222; }
</style>


<div class="SortArea">
	<span class="totalprice" >
		총 <span style="color:#ff4242;" ><?=number_format($total_count)?>개</span>의 상품이 있습니다.
	</span>

	<div id="it_sort" >
		<span><?=$sort ? $sort_name[$sort] : "신상품"?></span>
		<ul>
			<li><a <?=!$sort || $sort == "it_type3 desc" ? "class='on'" : ""?> href="<?=$link_basic?>&sort=it_type3 desc">신상품</a></li>
			<li><a <?=$sort == "it_amount asc" ? "class='on'" : ""?> href="<?=$link_basic?>&sort=it_amount asc">낮은가격</a></li>
			<li><a <?=$sort == "it_amount desc" ? "class='on'" : ""?> href="<?=$link_basic?>&sort=it_amount desc">높은가격</a></li>
			<li><a <?=$sort == "it_type4 desc" ? "class='on'" : ""?> href="<?=$link_basic?>&sort=it_type4 desc">인기상품</a></li>
			<li><a <?=$sort == "it_hit desc" ? "class='on'" : ""?> href="<?=$link_basic?>&sort=it_hit desc">조회</a></li>
		</ul>
	</div>
</div>


<script>
$(function(){
	$("#it_sort > span").click(function(){
		
		$("#it_sort").toggleClass("on");

	});
});
</script>

<? /* ?>
<!--


<table width=98% cellpadding=0 cellspacing=0 align=center>
<tr>
    <td width=50% style="font-size:17px;">총 <span class=point><b><? echo number_format($total_count) ?></b></span>개의 상품이 있습니다.</td>
    <td width=50% align=right style='padding-top:3px; padding-bottom:3px;'>
        <select id=it_sort name=sort style="height: 24px;font-size: 17px;" onchange="if (this.value=='') return; document.location = '<? echo "$_SERVER[PHP_SELF]?ca_id=$ca_id&skin=$skin&ev_id=$ev_id&sort=" ?>'+this.value;" class=small>
            <option value=''>출력 순서
            <option value=''>---------
            <option value='it_amount asc'>낮은가격순
            <option value='it_amount desc'>높은가격순
            <option value='it_name asc'>상품명순
            <option value='it_type1 desc'>히트상품
            <option value='it_type2 desc'>추천상품
            <option value='it_type3 desc'>최신상품
            <option value='it_type4 desc'>인기상품
            <option value='it_type5 desc'>할인상품
        </select>
    </td>
</tr>
<tr><td colspan="2" background='<? echo "$g4[shop_img_path]/line_h.gif" ?>' height=1></td></tr>
</table>

<script language='JavaScript'>
document.getElementById('it_sort').value="<?=$sort?>";
</script>


-->

<? */ ?>