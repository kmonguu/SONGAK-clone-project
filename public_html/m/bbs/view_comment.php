<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 




/*
//=====================================================================================================================================
// ANTISPAM V3.1
// Last Update : 19.08.19
// author : Ko gi boong
// DESC : /bbs/view_comment.php 상단
//=====================================================================================================================================
*/
$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_RETURNTRANSFER => 1,
CURLOPT_URL => 'http://antispam.1937.co.kr/v3/_getkey.php',
CURLOPT_POST => 1,
CURLOPT_POSTFIELDS => array(
	"ip"=>$_SERVER["REMOTE_ADDR"],
	"ssid"=>session_id(),
	"w"=>"c",
	"as_version"=>"3.1"
)
));
$antispam_key = curl_exec($curl);
curl_close($curl);
echo "
<script>if(typeof(antispam_fkey) != 'undefined') { antispam_fkey='{$antispam_key}'; }</script>
";




@include_once("$board_skin_mpath/view_comment.head.skin.php");

// 자동등록방지
include_once ($g4[bbs_path]."/norobot.inc.php");

// 코멘트를 새창으로 여는 경우 세션값이 없으므로 생성한다.
if ($is_admin && !$token) 
{
    set_session("ss_delete_token", $token = uniqid(time()));
}

$list = array();

$is_comment_write = false;
if ($member[mb_level] >= $board[bo_comment_level]) 
    $is_comment_write = true;

// 코멘트 출력
//$sql = " select * from $write_table where wr_parent = '$wr_id' and wr_is_comment = 1 order by wr_comment desc, wr_comment_reply ";
$sql = " select * from $write_table where wr_parent = '$wr_id' and wr_is_comment = 1 order by wr_comment, wr_comment_reply ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) 
{
    $list[$i] = $row;

    //$list[$i][name] = get_sideview($row[mb_id], cut_str($row[wr_name], 20, ''), $row[wr_email], $row[wr_homepage]);

    $tmp_name = get_text(cut_str($row[wr_name], $config[cf_cut_name])); // 설정된 자리수 만큼만 이름 출력
    if ($board[bo_use_sideview])
        $list[$i][name] = get_sideview($row[mb_id], $tmp_name, $row[wr_email], $row[wr_homepage]);
    else
        $list[$i][name] = "<span class='".($row[mb_id]?'member':'guest')."'>$tmp_name</span>";


    
    // 공백없이 연속 입력한 문자 자르기 (way 보드 참고. way.co.kr)
    //$list[$i][content] = eregi_replace("[^ \n<>]{130}", "\\0\n", $row[wr_content]);

    $list[$i][content] = $list[$i][content1]= "비밀글 입니다.";
    if (!strstr($row[wr_option], "secret") ||
        $is_admin || 
        ($write[mb_id]==$member[mb_id] && $member[mb_id]) || 
        ($row[mb_id]==$member[mb_id] && $member[mb_id])) {
        $list[$i][content1] = $row[wr_content];
        $list[$i][content] = conv_content($row[wr_content], 0, 'wr_content');
        $list[$i][content] = search_font($stx, $list[$i][content]);
    }

    $list[$i][trackback] = url_auto_link($row[wr_trackback]);
    $list[$i][datetime] = substr($row[wr_datetime],2,14);

    // 관리자가 아니라면 중간 IP 주소를 감춘후 보여줍니다.
    $list[$i][ip] = $row[wr_ip];
    if (!$is_admin)
        $list[$i][ip] = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", "\\1.♡.\\3.\\4", $row[wr_ip]);

    $list[$i][is_reply] = false;
    $list[$i][is_edit] = false;
    $list[$i][is_del]  = false;
    if ($is_comment_write || $is_admin) 
    {
        if ($member[mb_id]) 
        {
            if ($row[mb_id] == $member[mb_id] || $is_admin) 
            {
                $list[$i][del_link]  = "./delete_comment.php?bo_table=$bo_table&comment_id=$row[wr_id]&token=$token&cwin=$cwin&page=$page".$qstr;
                $list[$i][is_edit]   = true;
                $list[$i][is_del]    = true;
            }
        } 
        else 
        {
            if (!$row[mb_id]) {
                $list[$i][del_link] = "./password.php?w=x&bo_table=$bo_table&comment_id=$row[wr_id]&cwin=$cwin&page=$page".$qstr;
                $list[$i][is_del]   = true;
            }
        }

        if (strlen($row[wr_comment_reply]) < 5)
            $list[$i][is_reply] = true;
    }

    // 05.05.22
    // 답변있는 코멘트는 수정, 삭제 불가
    if ($i > 0 && !$is_admin)
    {
        if ($row[wr_comment_reply]) 
        {
            $tmp_comment_reply = substr($row[wr_comment_reply], 0, strlen($row[wr_comment_reply]) - 1);
            if ($tmp_comment_reply == $list[$i-1][wr_comment_reply])
            {
                $list[$i-1][is_edit] = false;
                $list[$i-1][is_del] = false;
            }
        }
    }
}

//  코멘트수 제한 설정값
if ($is_admin)
{
    $comment_min = $comment_max = 0;
}
else
{
    $comment_min = (int)$board[bo_comment_min];
    $comment_max = (int)$board[bo_comment_max];
}

include_once("$board_skin_mpath/view_comment.skin.php");

// 필터
//echo "<script type='text/javascript'> var g4_cf_filter = '$config[cf_filter]'; </script>\n";
//echo "<script type='text/javascript' src='$g4[path]/js/filter.js'></script>\n";

if (!$member[mb_id]) // 비회원일 경우에만
    echo "<script type='text/javascript' src='$g4[path]/js/md5.js'></script>\n";

@include_once("$board_skin_mpath/view_comment.tail.skin.php");
?>

<script>
//ANTISPAM3 
var old_comment_box = comment_box;
comment_box = function(comment_id, work) {
    old_comment_box(comment_id, work);
    if(typeof(set_antispam_form_event) == "function") {
        make_antispam_form_key(document.fviewcomment);
        set_antispam_form_event(document.fviewcomment);
    }
}
</script>