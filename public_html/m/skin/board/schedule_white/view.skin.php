<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$year = substr($view[wr_link1],0,4);
$month = sprintf("%d",substr($view[wr_link1],4,2));
$day = sprintf("%d",substr($view[wr_link1],6,2));
?>
<div style="height:40px;"></div>
<link rel="stylesheet" href="<?=$board_skin_path?>/style.css" type="text/css">
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr>
    <td>

<table width="<?=$width?>" align="center" cellpadding="0" cellspacing="0" style="border:1px solid #dddddd;" >
  <tr><td>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td class="bbs_pl" style="font-size:35px;height:55px">
		<b><?=$view[subject]?></b>	
	</td>
</tr>
<tr>
    <td class="bbs_pl bbs_fhead">
	<div align="left"> <font style="font:normal 20px 돋움; color:#6289BB;">
        <?=substr($view[wr_datetime],2,14)?>
&nbsp;&nbsp;
        <?=$view[name]?>
        </font>
           
    </div>
	</td>
</tr>
<tr><td colspan="3" class="bbs_line1"></td></tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
	<td style="font-size:25px">
		<font color="#CF4900"> - 현재일</font> : <?=$year?>년 <?=$month?>월 <?=$day?>일
	</td>
</tr>
<tr>
	<td style="font-size:25px">
	<font color="#CF4900">- 등록일</font> : <?=date("Y년 n월 j일", strtotime($view[wr_datetime]))?>
	</td>
</tr>
	<td style="font-size:25px">
	<font color="#CF4900">- 행사명</font> : <?=$view[wr_subject]?>
	</td>
</tr>
<tr>
	<td style="font-size:25px">
		<font color="#CF4900"> - 시&nbsp;&nbsp;&nbsp;간</font> : <?=$view[wr_6]?>
	</td>
</tr>
<tr>
	<td style="font-size:25px">
		<font color="#CF4900"> - 장&nbsp;&nbsp;&nbsp;소</font> : <?=$view[wr_7]?>
	</td>
</tr>
<tr>
	<td style="font-size:25px">
		<font color="#CF4900">- 연락처</font> : <?=$view[wr_8]?>
	</td>
</tr>

</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top: 1px solid #dddddd;">
<tr>
	<td valign="top" style='word-break:break-all; padding:5px;'>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="c_tc" style="font-size:23px">

	<?
		// 파일 출력
		for ($i=0; $i<=count($view[file]); $i++) {
			if ($view[file][$i][view]) echo $view[file][$i][view] . "<p>" . $view[file][$i][content] . "<p>";
		}

		echo "<span class='bbs_content'>$view[content]</span>";
	?>
	</td></tr></table>	<!-- 테러 태그 방지용 --></xml></xmp><a href=""></a><a href=''></a>
</td></tr></table>
</td></tr></table>
</td></tr></table>
<div style="text-align:right;margin:20px 20px 20px 0;">
<? if ($update_href) { echo "<a href=\"$update_href\"><span style='border:1px solid #666;padding:8px;background:#f8f8f8;color:#111;font-size:13px;'>수정하기</span></a> "; } ?>
&nbsp;&nbsp;<? if ($delete_href) { echo "<a href=\"".$delete_href."\"><span style='border:1px solid #666;padding:8px;background:#f8f8f8;color:#111;font-size:13px;'>삭   제</span></a> "; } ?>
</div>

<div align="center" style="margin:50px 0 50px 0;">
<span><a href="<?=$list_href?>&year=<?=$year?>&month=<?=$month?>">
<span style="border:1px solid #666;padding:10px 20px 10px 20px;background:#000;color:#fff;font-size:23px">달력보기</span>
<!-- <img id="btn_list" src="<?=$board_skin_path?>/img/btn_list.gif" border=0> --></a></span>
</div>

<script language="JavaScript">
// HTML 로 넘어온 <img ... > 태그의 폭이 테이블폭보다 크다면 테이블폭을 적용한다.
function resize_image()
{
    var target = document.getElementsByName('target_resize_image[]');
    var image_width = parseInt('<?=$board[bo_image_width]?>');
    var image_height = 0;

    for(i=0; i<target.length; i++) {
        // 원래 사이즈를 저장해 놓는다
        target[i].tmp_width  = target[i].width;
        target[i].tmp_height = target[i].height;
        // 이미지 폭이 테이블 폭보다 크다면 테이블폭에 맞춘다
        if(target[i].width > image_width) {
            image_height = parseFloat(target[i].width / target[i].height)
            target[i].width = image_width;
            target[i].height = parseInt(image_width / image_height);
        }
    }
}

window.onload = resize_image;
</script>
