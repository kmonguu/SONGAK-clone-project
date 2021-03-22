<?
include_once("./_common.php");
include_once("$g4[path]/lib/xmlparser.lib.php");

auth_check($auth[$sub_menu], "r");

function file_wget_contents($url, $timeout=30, $option='')
{
 if($option) $option = ' ' . $option;
 $fuid = '/tmp/wget_tmp_' . md5($_SERVER['REMOTE_ADDR'] . microtime() . $url);
 $cmd = 'wget "' . $url . '" -O "' . $fuid . '" --read-timeout=' . $timeout . $option;
 `$cmd`;
 $data = file_get_contents($fuid);
 `rm -rf $fuid`;
 return $data;
}

$start = $_REQUEST["start_".$tabIdx];

if(!$start) $start = 1;

?>

<!-- 블로그 시작 -->
<?
	$query = rawurlencode ($_REQUEST["query"]);
	$url = "http://antispam.1937.co.kr/naver_search.php?query={$query}&start={$start}&rows=100";
	$xmlS = file_wget_contents($url);
	
	$xml = simplexml_load_string($xmlS);

	$total = $xml->xpath('/rss/channel/total'); 
	$total_cnt = $total[0];
	$items = $xml->xpath('/rss/channel/item');

	$blog_list = array("joinsmsn"=>"Joins","naver"=>"네이버","egloos"=>"이글루스","cyworld"=>"싸이월드","dreamwiz"=>"드림위즈","textcube"=>"텍스트큐브","mediamob"=>"미디어몹","paran"=>"파란","yahoo"=>"야후","tistory"=>"티스토리","daum"=>"다음");

	$end = $start + 99;
	if( ($end) >= $total_cnt ) $end = $total_cnt;
?>

<div style="width:100%; height:30px; overflow-y:scroll;overflow-x:hidden; border:1px solid #aaaaaa; border-bottom:0px; ">
	<table width=100% cellpadding=0 cellspacing=0 class="list">
		<col width="120px;">
		<col width="520px;">
		<col width="120px;">
		<col>
		<tr class='bgcol1 bold col1 ht center'>
			<td>포털</td>
			<td>블로그제목</td>
			<td>적용하기</td>
			<td style='text-align:left; padding-left:15px;'> (총 <?=$total_cnt?>개의 검색결과 중 <?=$start?> ~ <?=$end?>)</td>
		</tr>
	</table>
</div>

<div style="width:100%; height:500px; overflow:auto; border:1px solid #aaaaaa; border-top:0px;">

	<table width=100% cellpadding=0 cellspacing=0 class="list">
	<col width="120px;">
	<col width="520px;">
	<col width="120px;">
	<col>

	<?if($total_cnt > 0){
		
		$cnt = 0;
		foreach($items as $item){
			 $cnt ++;
			 $link = $item->link;
			 $title = $item->title;
			 $description = $item->description;
			 $bloggerlink = $item->bloggerlink;
			 $bloggername = $item->bloggername;
			 $blog_name = "네이버";
			 $blog_key = "naver";
			 foreach($blog_list as $blog=>$name){
				if(strpos($bloggerlink, $blog) !== false){
					$blog_name = $name;
					$blog_key = $blog;	
				}
			 }

			 if($blog_key != "naver" && $blog_key != "daum"){
				continue;
			 }

			 //추가되어 있는 블로그인지 검색
			 $sch_title = str_replace("'", "''", $title);
			 $sch_bloggername = str_replace("'", "''", $bloggername);
			 $chkResult = sql_fetch(" SELECT count(*) cnt FROM blog_data WHERE title='{$sch_title}' AND bloggername='{$sch_bloggername}' ");
			 $chk = $chkResult[cnt];
			 $use_checked = "";
			 if($chk > 0){
				$use_checked = "checked";
			 }

		?>
			<tr>
				<td width='80' style='padding:3px 0 0 0;'><?=$blog_name?>블로그</td>				
				<td style="text-align:left;"><a href="<?=$link?>" target='_blank'><?=$title?></a></td>
				<td><input type="checkbox" name="bg_use" <?=$use_checked?> onclick="save_blog(this, '<?=urlencode($title)?>', '<?=urlencode($link)?>', '<?=urlencode($description)?>', '<?=urlencode($bloggerlink)?>' ,'<?=urlencode($bloggername)?>')" /></td>	
				<td></td>
			</tr>


		<?}?>
	<?}?>


	</table>
</div>

<div style="width:100%; text-align:center; padding:20px;">

	<?
		$prev_start = $start - 100; 
		$next_start = $start + 100;
	?>

	<?if($start > 1){?>
		<input type="button" value="이전 100개 보기" style="width:200px; height:30px;" onclick="location.href='./blog_list.php?tabIdx=<?=$tabIdx?>&start_<?=$tabIdx?>=<?=$prev_start?>'; "/>
	<?}?>

	<?if($total_cnt > ($cnt + $start)-1){ ?>
		<input type="button" value="다음 100개 보기" style="width:200px; height:30px;" onclick="location.href='./blog_list.php?tabIdx=<?=$tabIdx?>&start_<?=$tabIdx?>=<?=$next_start?>'; "/>
	<?}?>

</div>


<br/>
<br/>
<br/>

<script type="text/javascript">
function save_blog(chk_obj, title, link, desc, bloggerlink, bloggername){
	
	var w = "";
	if($(chk_obj).is(":checked")) { w = ""; } else { w = "d"; }


	$.post("./_ajax_save_blog.php", {w:w, title:title, link:link, description:desc, bloggerlink:bloggerlink, bloggername:bloggername}, function(data){
		if(data != "OK"){
			alert(data);
		}
	});
}
</script>

