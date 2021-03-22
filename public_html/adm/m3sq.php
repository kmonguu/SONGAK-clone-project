<?
// 외부 유입 검색어 분석기
// SearchQuery by mahler83 Ver 1.10 UTF-8
// A plugin for GNU board 4.31.02
// Released at 2009-04-17
// Please give feedbacks to http://bomool.net/
$g4_path = "..";
include_once("./_common.php");
$sub_menu = "200500";
$g4[title]="m3 검색어 분석기";
include_once("./admin.head.php");
//include_once("$g4[path]/adm/admin.head.php");
?>


<?
// 날짜 설정
if(!$datefrom) $datefrom = date("Y-m-d", strtotime("6 days ago"));
if(!$dateto) $dateto = $g4[time_ymd];


?>



<div id="div_m3sq">

외부 유입 검색어 분석기<br />
<br />

<li><a href="<?=$PHP_SELF?>?dateto=<?=$dateto?>&datefrom=<?=$datefrom?>">All</a></li>
<li><a href="<?=$PHP_SELF?>?page=google&dateto=<?=$dateto?>&datefrom=<?=$datefrom?>">Google</a></li>
<li><a href="<?=$PHP_SELF?>?page=nate&dateto=<?=$dateto?>&datefrom=<?=$datefrom?>">Nate</a></li>
<li><a href="<?=$PHP_SELF?>?page=yahoo&dateto=<?=$dateto?>&datefrom=<?=$datefrom?>">Yahoo</a></li>
<li><a href="<?=$PHP_SELF?>?page=daum&dateto=<?=$dateto?>&datefrom=<?=$datefrom?>">Daum</a></li>
<li><a href="<?=$PHP_SELF?>?page=naver&dateto=<?=$dateto?>&datefrom=<?=$datefrom?>">Naver</a></li><br />
<br />

<form method="get" action="<?=$_SERVER[PHP_SELF]?>">
	<input type="hidden" name="page" value="<?=$page?>" />
	시작 : <input type="text" name="datefrom" value="<?=$datefrom?>" size="10" />
	끝 : <input type="text" name="dateto" value="<?=$dateto?>" size="10" />
	<input type="submit" value="go" /><br />
</form><br />
<form action="javascript:;" onsubmit="findsq(getElementById('sq').value)" />
	결과내 검색 : <input type="text" id="sq" name="sq" value="<?=$sq?>" />
	<input type="submit" value="search" />
	<input type="button" value="reset" onclick="resetsq()" />
	<span id="search_cnt"></span><br />
</form>
<br />



<script>
jQuery(document).ready(function(){
	$( "#tabs" ).tabs({selected:'<?=$tabIdx?>'});
	$( "#tabs" ).fadeIn();
});
 </script>

<div id="tabs" style='display:none;border:0'>
  <ul>
	<li><a href="m3sq2.php?md=a&datefrom=<?=$datefrom?>&dateto=<?=$dateto?>&page=<?=$_REQUEST[page]?>&tabIdx=0">전체</a></li>
	<li><a href="m3sq2.php?md=p&datefrom=<?=$datefrom?>&dateto=<?=$dateto?>&page=<?=$_REQUEST[page]?>&tabIdx=1">PC</a></li>	
	<li><a href="m3sq2.php?md=m&datefrom=<?=$datefrom?>&dateto=<?=$dateto?>&page=<?=$_REQUEST[page]?>&tabIdx=2">Mobile</a></li>	
  </ul>

</div>




<?
include_once("$g4[path]/adm/admin.tail.php");
?>