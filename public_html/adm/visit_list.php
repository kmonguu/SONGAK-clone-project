<?
$sub_menu = "200800";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g4[title] = "접속자현황";
include_once("./admin.head.php");
include_once("./visit.sub.php");


$tabIdx = 0;
if($tab == "1") $tabIdx = 1;
else if($tab == "2") $tabIdx = 2;

$colspan = 5;
?>


<script>
jQuery(document).ready(function(){
	$( "#tabs" ).tabs({selected:'<?=$tabIdx?>'});
	$( "#tabs" ).fadeIn();
});
 </script>



<div id="tabs" style='display:none;border:0'>
  <ul>
	<li><a href="visit_list2.php?md=a&page=<?=$page?>&fr_date=<?=$fr_date?>&to_date=<?=$to_date?>&domain=<?=$domain?>&tabIdx=0">전체</a></li>
	<li><a href="visit_list2.php?md=p&page=<?=$page?>&fr_date=<?=$fr_date?>&to_date=<?=$to_date?>&domain=<?=$domain?>&tabIdx=1">PC</a></li>	
	<li><a href="visit_list2.php?md=m&page=<?=$page?>&fr_date=<?=$fr_date?>&to_date=<?=$to_date?>&domain=<?=$domain?>&tabIdx=2">Mobile</a></li>	
  </ul>

</div>





<?
include_once("./admin.tail.php");
?>
