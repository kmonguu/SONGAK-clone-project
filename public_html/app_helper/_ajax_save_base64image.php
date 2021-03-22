<?
include_once("_common.php");
header("content-type:text/html; charset=utf-8");

if($member[mb_level] < 2){
	exit;
}

function base64_to_jpeg($base64_string, $output_file) {
	$ifp = fopen($output_file, "wb");
	fwrite($ifp, base64_decode($base64_string));
	fclose($ifp);
	return $output_file;
}


$file_path = $g4[path]."/data/file/".$_REQUEST["filePath"];
$file_name = $_REQUEST["fileName"];

@mkdir ( $file_path, 0707, true );

if($file_name == ".jpg"){
	$file_name = date("YmdHis").".jpg";
}

base64_to_jpeg($_REQUEST["imageData"], $file_path."/".$file_name);



// 파일 사이즈를 줄여서 처리하기 1
include_once("$g4[path]/lib/resizing.lib.php");

	
$image = new SimpleImage();
$image->load($file_path."/".$file_name);

if($image->getWidth() > Props::get("upload_image_max_width")){
	$image->resizeToWidth(Props::get("upload_image_max_width"));
	$image->save($file_path."/".$file_name);
}


echo "OK";