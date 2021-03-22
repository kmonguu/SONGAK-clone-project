<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$cols  = 1; //  이미지 가로갯수 //  이미지 세로 갯수는 메인에서 지정(총 이미지 수)
$image_h  = 1; // 이미지 상하 간격
$col_width = (int)(99 / $cols);

$img_width = 405; //썸네일 가로길이
$img_height = 405; //썸네일 세로길이
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

<style>

	.swiper_m3 { position:relative; width:750px; height:405px; padding-top:50px; float:right; }
	.swiper_m3 .swiper-slide { position:relative; margin:0 auto; width:405px; height:100%; }

	.swiper_m3 .swiper-slide .slide_img { transition:.2s; }	
	.swiper_m3 .swiper-slide > img { position:absolute; top:20px; left:20px; }
	

</style>
<div class="swiper-container swiper_m3">
	<div class="swiper-wrapper">

	<? for ($i=0; $i<count($list); $i++) {

		// 첨부파일 이미지가 있으면 썸을 생성, 아니면 pass~!
		if ($list[$i][file][0][file]) {

			// 이미지 체크
			$image = urlencode($list[$i][file][0][file]);
			$ori="$g4[path]/data/file/$bo_table/" . $image;
			$ext = strtolower(substr(strrchr($ori,"."), 1)); //확장자

			// 이미지가 있다면.
			if ($ext=="gif"||$ext=="jpg"||$ext=="jpeg"||$ext=="png"||$ext=="bmp"||$ext=="tif"||$ext=="tiff") {

				// 섬네일 경로 만들기 + 섬네일 생성
				$list_img_path = $list[$i][file][0][path]."/".$list[$i][file][0][file];
				$list_thumb = thumbnail($list_img_path ,$img_width, $img_height,0,2,100);

			}                                                         

		} else {                ////  첨부파일 이미지가 없으면

			$list_thumb = "/res/images/noimg.jpg";

		}
		
		$img = "<img src='{$list_thumb}' class='slide_img'; style='width:{$img_width}px; height:{$img_height}px;' />";
		$a_img="<a href='{$list[$i][href]}'>$img</a>";
	?>



		<div class="swiper-slide">
				<?=$a_img?>
				<img src="/res/images/mainvisual/mg_img.png" alt="이미지 아이콘" />
		</div>

		<? } ?>

	</div>
</div>


<script>

	var swiper_gallery = null;
	$(function(){
		swiper_gallery = new Swiper('.swiper_m3', {
						spaceBetween: 80,
						centeredSlides: true,
						autoplay: {
							delay: 4000,
						},
						disableOnInteraction: false,
						effect:'slide',
						speed: 1000,
						loop:true,
						slidesPerView:'auto',
						observer:true,
						simulateTouch: false,
						on:{
							transitionStart:function(){ },
							transitionEnd:function(){
								this.autoplay.stop();
								this.autoplay.start();
							}
						},
						navigation: {
							nextEl: '.gallery_right',
							prevEl: '.gallery_left',
						},

			});
		});
</script>