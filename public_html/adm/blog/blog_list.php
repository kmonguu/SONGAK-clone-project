<?
$sub_menu = "400500";
include_once("./_common.php");


auth_check($auth[$sub_menu], "r");

$g4[title] = "블로그관리";
include_once ("$g4[admin_path]/admin.head.php");

if(!$tabIdx)$tabIdx = 0;

$save_stx = urlencode($save_stx);
$stx = urlencode($stx);


//키워드목록
$result = sql_query("SELECT * FROM blog_keyword ORDER BY reg_date asc");
$list = array();
for($idx = 0 ; $row = sql_fetch_array($result); $idx++){
	array_push($list, $row);
}




?>

<script>
jQuery(document).ready(function(){
	$( "#tabs" ).tabs({selected:'<?=$tabIdx?>'});
	$( "#tabs" ).fadeIn();
});

function delete_keyword(no){
	if(!confirm("정말로 삭제하시겠습니까?")) return;
	
	document.fkeyword.w.value = "d";
	document.fkeyword.no.value = no;
	document.fkeyword.submit();
}
</script>


<table width=100% cellpadding=0 cellspacing=0 class="list">
<col width="220px;">
<col width="320px;">
<col>
<tr class='bgcol1 bold col1 ht center'>
	<td>키워드추가</td>
	<td>키워드목록</td>
	<td></td>
</tr>
<tr>
	<td>
		<form name="fkeyword" method="post" action="./blog_keyword_add.php" >
			<input type="hidden" id="w" name="w" value="" />
			<input type="hidden" id="no" name="no" value="" />
			<input type="text" name="keyword" value="" />
			<input type="submit" value="추가" />
		</form>
	</td>
	<td>
		<div style="width:100%; height:100px; overflow:auto; ">
		<ul>
			<?foreach($list as $rows){?>
				<li style='text-align:left;'><?=$rows[keyword]?>&nbsp;<a href="javascript:void(0)" onclick="delete_keyword('<?=$rows[no]?>')">[삭제]</a></li>
			<?}?>
		</ul>
		</div>
	</td>
	<td></td>
</tr>
</table>

<br/>

<div id="tabs" style='display:none;border:0'>
  <ul>
		<li><a href="./blog_list2_tab.php">현재 표시중</a></li>
		<?
		$cnt = 0;
		foreach($list as $rows){$cnt++; ?>
			<li><a href="./blog_list_tab.php?query=<?=urlencode($rows[keyword])?>&tabIdx=<?=$cnt?>&start_<?=$cnt?>=<?=$_REQUEST["start_".$cnt]?>" ><?=$rows[keyword]?></a></li>	
		<?}?>
  </ul>  
</div>


