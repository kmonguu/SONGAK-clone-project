<?
//페이징
function mpagelist($total_article,$num,$div_page_num,$filename,$href){

	global $page;

	if(!$page) $page=1;
	if(!$page_area) $page_area=@ceil($page/$div_page_num);
	$total_page=@ceil($total_article/$num);
	$start_no=($page-1)*$num;
	$total_page_area=@ceil($total_page/$div_page_num);
	$page_start_no=($page_area-1)*$div_page_num+1;
	$page_end_no=$page_start_no+$div_page_num-1;
	if($total_page==1 || $total_page_area==1){
		$page_start="";
		$page_end="";
	}else{
		if($page==1){
			$page_start="";
			if(!$board[no]) $page_end="";
				else {
					if($total_page[0]) $page_end="<span class='pgPrevNext'><a href=$filename?page=$total_page&$href>Last</a></span>";
						else $page_end="";
				}
		}
		elseif($page==$total_page){
			$page_end="";
			$page_start="<span class='pgPrevNext'><a href=$filename?page=1&$href>First</a></span>";
		}else{
			$page_start="<span class='pgPrevNext'><a href=$filename?page=1&$href>First</a></span>";
			$page_end="<span class='pgPrevNext'><a href=$filename?page=$total_page&$href>Last</a></span>";
			}
	}

	if($total_page_div==$page_div) $page_end="";
	if($page_end_no>$total_page) $page_end_no=$total_page;

	if($page_area>1) $prev_area="<span class='pgPrevNext'><a href=".$_blog_url."?page=".($page_start_no-1)."&$href&target=$target&arrange=$arrange&ca_no=$ca_no&mid=$mid><<</a></span>";
		else $prev_area="";
	if($page_area<$total_page_area) $next_area="<span class='pgPrevNext'><a href=".$_blog_url."?page=".($page_end_no+1)."&$href&target=$target&arrange=$arrange&ca_no=$ca_no&mid=$mid>>></a></span>";
		else $next_area="";


	for($i=$page_start_no;$i<=$page_end_no;$i++){
		if($i==$page) $page_list.="<span class='pgNow'>".$i."</span>";
			else $page_list.="<span class='pgNum'><a href=$filename?".$href."&page=$i>".$i."</a></span>";
	}$page_list="<div class=\"pagelist\">".$prev_area.$page_list.$next_area."</div>";	

	return array($start_no,$page_list);
}

?>