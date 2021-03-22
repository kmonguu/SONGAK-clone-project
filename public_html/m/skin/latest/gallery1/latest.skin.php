<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$cols  = 1; //  이미지 가로갯수 //  이미지 세로 갯수는 메인에서 지정(총 이미지 수)
$image_h  = 1; // 이미지 상하 간격
$col_width = (int)(99 / $cols);

$img_width = 83; //썸네일 가로길이
$img_height = 61; //썸네일 세로길이
$img_quality = 90; //퀼리티 100이하로 설정 일부 php버전에서는 10이하의 수로 처리 될 수 있삼

if (!function_exists("imagecopyresampled")) alert("GD 2.0.1 이상 버전이 설치되어 있어야 사용할 수 있는 갤러리 게시판 입니다.");

$data_path = $g4[path]."/data/file/$bo_table";
$thumb_path = $data_path.'/thumb_img_list'; //썸네일 이미지 생성 디렉토리

@mkdir($thumb_path, 0707);
@chmod($thumb_path, 0707);

/*
//공지사항 맨위로 올림
 if (count($list) >1 ) {
foreach( $list as $key => $value) $tmp_notice[$key] = $value['is_notice'] *100000 + $value['wr_id'];
 array_multisort($tmp_notice, SORT_DESC, $list);
}
*/
?>
<div style="padding-top:9px;padding-left:8px;">
<table style="margin-top:0px; padding:0px; border-spacing:0px;border-collapse:0px;">
<tr>
<? for ($i=0; $i<count($list); $i++) { ?>
<?
$wr_content = "<a href='{$list[$i]['href']}' style='color:#7a7a7a;'>".cut_str(strip_tags($list[$i]['wr_content']), 20, '...')."</a>";
 //   if ($i>0 && $i%$cols==0) { echo "<td colspan='$cols' height='$image_h'></td><tr>"; }
    $img = "<img src='$g4_path/img/noimg.jpg' border=1 width='$img_width' height='$img_height' title='이미지 없음' align=left style='border:1 #222222 solid;'>";
    $thumb = $thumb_path.'/'.$list[$i][wr_id];


	// 섬네일과 새로 올린파일 날짜를 비교하여 셈네일을 갱신하기위해서 지운다.
	if ( file_exists($thumb) && (filemtime($thumb) < filemtime($list[$i][file][0][path] .'/'. $list[$i][file][0][file])) ) {
		@unlink($thumb);
	}

    // 썸네일 이미지가 존재하지 않는다면
    if (!file_exists($thumb)) {
        $file = $list[$i][file][0][path] .'/'. $list[$i][file][0][file];
        // 업로드된 파일이 이미지라면
		//echo $i;
        if (preg_match("/\.(jp[e]?g|gif|png)$/i", $file) && file_exists($file)) {
            $size = getimagesize($file);
            if ($size[2] == 1)
                $src = imagecreatefromgif($file);
            else if ($size[2] == 2)
                $src = imagecreatefromjpeg($file);
            else if ($size[2] == 3)
                $src = imagecreatefrompng($file);
            else
                break;

            $rate = $img_width / $size[0];
            $height = (int)($size[1] * $rate);
			$width = (int)($size[0] * $rate);

            // 계산된 썸네일 이미지의 높이가 설정된 이미지의 높이보다 작다면
            $dst = imagecreatetruecolor($img_width, $img_height);

            if ($height < $img_height) {                // 계산된 이미지 높이로 복사본 이미지 생성
				imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $img_height, $size[0], $size[1]);
				@imagepng($dst, $thumb_path.'/'.$list[$i][wr_id], $img_quality);
            } else {   // 설정된 이미지 높이로 복사본 이미지 생성
				imagecopyresampled($dst, $src, 0, 0, 0, 0, $img_width, $height, $size[0], $size[1]);
				@imagepng($dst, $thumb_path.'/'.$list[$i][wr_id], $img_quality);

			}
			//echo $i;
            chmod($thumb_path.'/'.$list[$i][wr_id], 0606);
        }
    }

    //if (file_exists($thumb))
    //     $img = "<img src='$thumb' border=0 style='width:".$img_width."px; height:".$img_height."px;'>";
		if (!file_exists($thumb)){
		 $img = "<img src='$latest_skin_path/noimg.jpg' border=0 style='width:".$img_width."px; height:".$img_height."px;'>";
		}else{
	     $img = "<img src='{$list[$i][file][0][path]}/{$list[$i][file][0][file]}' border=0 style='width:".$img_width."px; height:".$img_height."px;'>";
		}
?>
<?
        $datetime = substr($list[$i][wr_datetime],0,10);
        $datetime2 = $list[$i][wr_datetime];

        if ($list[$i]['wr_datetime'] >= date("Y-m-d H:i:s", $g4['server_time'] - ($row['bo_new'] * 3600))) $comment_new = "new";

        if ($datetime == $g4[time_ymd])
            $datetime2 = substr($datetime2,11,5);
        else
            $datetime2 = substr($datetime2,5,5);

    $list[$i][datetime] = $datetime;
    $list[$i][datetime2] = $datetime2;

    $a[$i] = array(
      "wr_date"=>$datetime2,
);
?>

<?
 $rw_subject = cut_str(stripslashes($list[$i][subject]),$subject_size,'..');
 $a_link="<a href='{$list[$i][href]}'>$rw_subject</a>";
   $a_img="<a href='{$list[$i][href]}'>$img</a>";
 $a_comment="<a href=\"{$list[$i][comment_href]}\"><span class='commentFont'>{$list[$i]['comment_cnt']}</span></a>";
 $rw_content = cut_str(stripslashes($list[$i][wr_content]),$content_size,' ..more');
 $rw_content = strip_tags($rw_content);
?>

<td valign="top">
<script>
$(document).ready(function (){
	$("#border<?=$i?>").hover(function(){
	$(this).css("border","1px solid #0098dc"); },
	function(){$(this).css("border","1px solid #5a5a5a");
	});
});
</script>
	<div style="width:<?=$img_width+2?>px; <?if($i<count($list)-1){?>padding-right:11px;<?}?>">
		<div style="margin:0 auto; float:left; text-align:center;" >
		<div id="border<?=$i?>" style="border:1px solid #5a5a5a;margin-bottom:5px;">
		<?=$a_img?>
		</div>

			<!--<div style="height:14px; margin-top:2px;">
	       <?
            /*if ($list[$i]['is_notice'])
               echo "<font style='font:12px dotum;'><font color=#252525>{$list[$i]['subject']}</font></font>";
               else
               echo "<font style='font:12px dotum;'><font color=#252525>{$list[$i]['subject']}</font></font>";
               echo "</a>";*/
		   ?>
			</div>-->

			<!--<div style="height:13px; margin-top:1px;">
			<font style='font:12px dotum; text-align:center;'><font 	color=#252525><?=date("Y.m.d",strtotime($list[$i][wr_datetime]));?></font>
			</div>-->

		</div>

		<div style="font-family:돋움; text-align:center; margin:0 auto;">
		<?
		/*$latestsubject=substr($list[$i]['subject'],0,12);
		echo $latestsubject;*/
		?>
		</div>
		<div style="clear:both;"></div>
	</div>
</td>

<?
	}
?>

</tr>
</table>
</div>
