<?
$sub_menu = "200800";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g4[title] = "연도별 접속자현황";
include_once("./admin.head.php");
include_once("./visit.sub.php");

$colspan = 4;
?>


<script>
jQuery(document).ready(function(){
	$( "#tabs" ).tabs({selected:'<?=$tabIdx?>'});
	$( "#tabs" ).fadeIn();
});
 </script>


<div id="tabs" style='display:none;border:0'>
  <ul>
	<li><a href="visit_year2.php?md=a&fr_date=<?=$fr_date?>&to_date=<?=$to_date?>&domain=<?=$domain?>&tabIdx=0">전체</a></li>
	<li><a href="visit_year2.php?md=p&fr_date=<?=$fr_date?>&to_date=<?=$to_date?>&domain=<?=$domain?>&tabIdx=1">PC</a></li>	
	<li><a href="visit_year2.php?md=m&fr_date=<?=$fr_date?>&to_date=<?=$to_date?>&domain=<?=$domain?>&tabIdx=2">Mobile</a></li>	
  </ul>

</div>



<?
include_once("./admin.tail.php");
?>
