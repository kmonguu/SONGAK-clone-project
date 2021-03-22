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

	if($page_area>1) $prev_area="<span class='pgPrevNext'><a href=".$_blog_url."?page=".($page_start_no-1)."&$href&target=$target&arrange=$arrange&ca_no=$ca_no&mid=$mid  style='font-size:24px;'><<</a></span>";
		else $prev_area="";
	if($page_area<$total_page_area) $next_area="<span class='pgPrevNext'><a href=".$_blog_url."?page=".($page_end_no+1)."&$href&target=$target&arrange=$arrange&ca_no=$ca_no&mid=$mid  style='font-size:24px;'>>></a></span>";
		else $next_area="";


	for($i=$page_start_no;$i<=$page_end_no;$i++){
		if($i==$page) $page_list.="<span class='pgNow'  style='font-size:24px;'>".$i."</span>";
			else $page_list.="<span class='pgNum' ><a href=$filename?".$href."&page=$i style='font-size:24px;'>".$i."</a></span>";
	}$page_list="<div class=\"pagelist\">".$prev_area.$page_list.$next_area."</div>";	

	return array($start_no,$page_list);
}

// 게시물 정보($write_row)를 출력하기 위하여 $list로 가공된 정보를 복사 및 가공
function get_mlist($write_row, $board, $skin_path, $subject_len=40)
{
    global $g4, $config;
    global $qstr, $page;

    //$t = get_microtime();

    // 배열전체를 복사
    $list = $write_row;
    unset($write_row);

    $list['is_notice'] = preg_match("/[^0-9]{0,1}{$list['wr_id']}[\r]{0,1}/",$board['bo_notice']);

    if ($subject_len)
        $list['subject'] = conv_subject($list['wr_subject'], $subject_len, "...");
    else
        $list['subject'] = conv_subject($list['wr_subject'], $board['bo_subject_len'], "...");

    // 목록에서 내용 미리보기 사용한 게시판만 내용을 변환함 (속도 향상) : kkal3(커피)님께서 알려주셨습니다.
    if ($board['bo_use_list_content'])
	{
		$html = 0;
		if (strstr($list['wr_option'], "html1"))
			$html = 1;
		else if (strstr($list['wr_option'], "html2"))
			$html = 2;

        $list['content'] = conv_content($list['wr_content'], $html);
	}

    $list['comment_cnt'] = "";
    if ($list['wr_comment'])
        $list['comment_cnt'] = "($list[wr_comment])";

    // 당일인 경우 시간으로 표시함
    $list['datetime'] = substr($list['wr_datetime'],0,10);
    $list['datetime2'] = $list['wr_datetime'];
    if ($list['datetime'] == $g4['time_ymd'])
        $list['datetime2'] = substr($list['datetime2'],11,5);
    else
        $list['datetime2'] = substr($list['datetime2'],5,5);
    // 4.1
    $list['last'] = substr($list['wr_last'],0,10);
    $list['last2'] = $list['wr_last'];
    if ($list['last'] == $g4['time_ymd'])
        $list['last2'] = substr($list['last2'],11,5);
    else
        $list['last2'] = substr($list['last2'],5,5);

    $list['wr_homepage'] = get_text(addslashes($list['wr_homepage']));

    $tmp_name = get_text(cut_str($list['wr_name'], $config['cf_cut_name'])); // 설정된 자리수 만큼만 이름 출력
    if ($board['bo_use_sideview'])
        $list['name'] = get_sideview($list['mb_id'], $tmp_name, $list['wr_email'], $list['wr_homepage']);
    else
        $list['name'] = "<span class='".($list['mb_id']?'member':'guest')."'>$tmp_name</span>";

    $reply = $list['wr_reply'];

    $list['reply'] = "";
    if (strlen($reply) > 0)
    {
        for ($k=0; $k<strlen($reply); $k++)
            $list['reply'] .= ' &nbsp;&nbsp; ';
    }

    $list['icon_reply'] = "";
    if ($list['reply'])
        $list['icon_reply'] = "<img src='$skin_path/img/icon_reply.gif' align='absmiddle'>";

    $list['icon_link'] = "";
    if ($list['wr_link1'] || $list['wr_link2'])
        $list['icon_link'] = "<img src='$skin_path/img/icon_link.gif' align='absmiddle'>";

    // 분류명 링크
    $list['ca_name_href'] = $g4[mpath]."/bbs/board.php?bo_table=$board[bo_table]&sca=".urlencode($list['ca_name']);

    $list['href'] = $g4[mpath]."/bbs/board.php?bo_table=$board[bo_table]&wr_id=$list[wr_id]" . $qstr;
    if ($board['bo_use_comment'])
        $list['comment_href'] = "javascript:win_comment('".$g4[mpath]."/bbs/board.php?bo_table=$board[bo_table]&wr_id=$list[wr_id]&cwin=1');";
    else
        $list['comment_href'] = $list['href'];

    $list['icon_new'] = "";
    if ($list['wr_datetime'] >= date("Y-m-d H:i:s", $g4['server_time'] - ($board['bo_new'] * 3600)))
        $list['icon_new'] = "<img src='$skin_path/img/icon_new.gif' align='absmiddle'>";

    $list['icon_hot'] = "";
    if ($list['wr_hit'] >= $board['bo_hot'])
        $list['icon_hot'] = "<img src='$skin_path/img/icon_hot.gif' align='absmiddle'>";

    $list['icon_secret'] = "";
    if (strstr($list['wr_option'], "secret"))
        $list['icon_secret'] = "<img src='$skin_path/img/icon_secret.gif' align='absmiddle'>";

    // 링크
    for ($i=1; $i<=$g4['link_count']; $i++)
    {
        $list['link'][$i] = set_http(get_text($list["wr_link{$i}"]));
        $list['link_href'][$i] = $g4[mpath]."/bbs/link.php?bo_table=$board[bo_table]&wr_id=$list[wr_id]&no=$i" . $qstr;
        $list['link_hit'][$i] = (int)$list["wr_link{$i}_hit"];
    }

    // 가변 파일
    $list['file'] = get_file($board['bo_table'], $list['wr_id']);

    if ($list['file']['count'])
        $list['icon_file'] = "<img src='$skin_path/img/icon_file.gif' align='absmiddle'>";

    return $list;
}


// 최신글 추출
function latestm($skin_dir="", $bo_table, $rows=10, $subject_len=40, $options="")
{
    global $g4;

    if ($skin_dir)
        $latest_skin_path = "$g4[mpath]/skin/latest/$skin_dir";
    else
        $latest_skin_path = "$g4[mpath]/skin/latest/basic";

    $list = array();

    $sql = " select * from $g4[board_table] where bo_table = '$bo_table'  ";
    $board = sql_fetch($sql);

    $tmp_write_table = $g4['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
    //$sql = " select * from $tmp_write_table where wr_is_comment = 0 order by wr_id desc limit 0, $rows ";
    // 위의 코드 보다 속도가 빠름
    //$sql = " select * from $tmp_write_table where wr_is_comment = 0 order by wr_num limit 0, $rows ";
	$sql = " select * from $tmp_write_table where wr_is_comment = 0 and wr_reply = ''order by wr_num limit 0, $rows ";
    //explain($sql);
    $result = sql_query($sql);
    for ($i=0; $row = sql_fetch_array($result); $i++) 
        $list[$i] = get_mlist($row, $board, $latest_skin_path, $subject_len);
    
    ob_start();
    include "$latest_skin_path/latest.skin.php";
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

//이미지 불러오기
function dirImageList($dir, $p, $num){
	global $g4;
	$path = $g4['path']."/data/".$dir."/".$p;
	if(!is_dir($path)) return "해당 디렉터리가 없습니다.";
	$opendir = opendir($path);
	$file = array();
	$i = 0;
	while(false !== ($readfile = readdir($opendir))){
		$filename = explode("_", $readfile);
		if($filename[0]==$num){
			$file[$i] = $readfile;
			$i++;
		}
	}

	sort($file);
	$imghtml = "";
	for($i=0;$i<count($file);$i++){
		if(getimagesize($path."/".$file[$i])) $imghtml .= '<img src="'.$path."/".$file[$i].'" width="100%">';
	}
	return $imghtml;
}


function mget_it_image($img, $width=0, $height=0, $id=""){
    global $g4;

    $str = get_image($img, $width, $height);
    if ($id) {
        $str = "<a href='$g4[shop_mpath]/item.php?it_id=$id'>$str</a>";
    }
    return $str;
}

function mit_name_icon($it, $it_name="", $url=1){
    global $g4;

    $str = "";
    if ($it_name) 
        $str = $it_name;
    else
        $str = stripslashes($it[it_name]);

    if ($url){
        $str = "<a href='$g4[shop_mpath]/item.php?it_id=$it[it_id]'>$str</a>";
		$str .= "<div class='mit_name_div' ></div>";
	}

    for($idx = 1 ; $idx <= 5; $idx++) {
        if($it["it_type{$idx}"]) {
            $str .= "<div class='icon_item_type{$idx}'>".Yc4::$IT_TYPE[$idx]."</div>";
        }
    }

    // 품절
    $stock = get_it_stock_qty($it[it_id]);
    if ($stock <= 0)
        $str .= " <img src='$g4[shop_img_path]/icon_pumjul.gif' border='0' align='absmiddle' /> ";

    return $str;
}



// 출력유형, 스킨파일, 1라인이미지수, 총라인수, 이미지폭, 이미지높이
// 1.02.01 $ca_id 추가
function mdisplay_type($type, $skin_file, $list_mod, $list_row, $img_width, $img_height, $ca_id="")
{
	global $member, $g4;

    // 상품의 갯수
    $items = $list_mod * $list_row;

    // 1.02.00 
    // it_order 추가
    $sql = " select *
               from $g4[yc4_item_table]
              where it_use = '1'
                and it_type{$type} = '1' ";
    if ($ca_id) $sql .= " and ca_id like '$ca_id%' ";
    $sql .= " order by it_order, it_id desc 
              limit $items ";
    $result = sql_query($sql);
    if (!mysql_num_rows($result)) {
        return false;
    }

    $file = "$g4[shop_mpath]/$skin_file";
    if (!file_exists($file)) {
        echo "<span class=point>{$file} 파일을 찾을 수 없습니다.</span>";
    } else {
        $td_width = (int)(100 / $list_mod);
        include $file;
    }
}



// 분류별 출력 
// 스킨파일번호, 1라인이미지수, 총라인수, 이미지폭, 이미지높이 , 분류번호
function mdisplay_category($no, $list_mod, $list_row, $img_width, $img_height, $ca_id="")
{
	global $member, $g4;

    // 상품의 갯수
    $items = $list_mod * $list_row;

    $sql = " select * from $g4[yc4_item_table] where it_use = '1'";
    if ($ca_id) 
        $sql .= " and ca_id LIKE '{$ca_id}%' ";
    $sql .= " order by it_order, it_id desc limit $items ";
    $result = sql_query($sql);
    if (!mysql_num_rows($result)) {
        return false;
    }

    $file = "$g4[shop_mpath]/maintype{$no}.inc.php";
    if (!file_exists($file)) {
        echo "<span class=point>{$file} 파일을 찾을 수 없습니다.</span>";
    } else {
        $td_width = (int)(100 / $list_mod);
        include $file;
    }
}


?>
