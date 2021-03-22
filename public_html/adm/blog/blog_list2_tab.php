<?
include_once("./_common.php");

$blog_list = array("joinsmsn"=>"Joins","naver"=>"네이버","egloos"=>"이글루스","cyworld"=>"싸이월드","dreamwiz"=>"드림위즈","textcube"=>"텍스트큐브","mediamob"=>"미디어몹","paran"=>"파란","yahoo"=>"야후","tistory"=>"티스토리","daum"=>"다음");

$result = sql_query("SELECT * FROM blog_data ORDER BY disp_order asc, reg_date desc");
?>


<table width=100% cellpadding=0 cellspacing=0 class="list">
<col width="120px;">
<col width="520px;">
<col width="120px;">
<col width="120px;">
<col>

<tr class='bgcol1 bold col1 ht center'>
	<td>포털</td>
	<td>블로그제목</td>
	<td>표시순서<br/>(낮을수록 상위)</td>
	<td>삭제</td>
	<td></td>
</tr>

         <?for($idx = 0 ; $row = sql_fetch_array($result); $idx++){

		 $link = $row["link"];
		 $title = $row["title"];
		 $description = $row["description"];
		 $bloggerlink = $row["bloggerlink"];
		 $bloggername = $row["bloggername"];
		 $blog_name = "네이버";
		 $blog_key = "naver";
		 foreach($blog_list as $blog=>$name){
			if(strpos($bloggerlink, $blog) !== false){
				$blog_name = $name;
				$blog_key = $blog;								
			}
		 }
	 ?>
		<tr>
			<td width='80' style='padding:3px 0 0 0;'><?=$blog_name?>블로그</td>				
			<td style="text-align:left;"><a href="<?=$link?>" target='_blank'><?=$title?></a></td>
			<td><input type="text" value="<?=$row[disp_order]?>" style="width:60px;text-align:right;" onchange="save_order(this, '<?=$row[no]?>')"/></td>	
			<td><input type="button" value="삭제" onclick="delete_row(this, '<?=$row[no]?>')" /></td>
			<td></td>
		</tr>
	<?}?>

	<?if($idx == 0){?>
		<tr>
			<td colspan="5" style='height:40px;'>표시중인 블로그 데이터가 없습니다.</td>
		</tr>
	<?}?>

</table>


<script type="text/javascript">
function delete_row(obj, no){
	
	$.post("./_ajax_delete_blog.php", {no:no}, function(data){
		if(data != "OK"){
			alert(data);
		} else {
			$(obj).closest("tr").remove();
		}
	});

}

function save_order(obj, no){
	
	
	$(obj).css({border:"2px solid blue"});

	$.post("./_ajax_save_order.php", {no:no, disp_order:$(obj).val()}, function(data){

		if(data != "OK") {
			alert(data) 
		}else{
			
		}

		setTimeout(function(){ $(obj).css({border:"1px solid #aaaaaa"});}, 1000);


	});
}
</script>
