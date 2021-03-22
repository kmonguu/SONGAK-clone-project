<?php
require_once("config.php");

//----------------------------------------------------------------------------
//
//
$filename = null;
$savefile = null;
$filesize = 0;

if (isset($_POST["filehtml5"])) {
	
	$filename = $_POST["randomname"];
	$savefile = SAVE_DIR . '/' . $filename;
	$fh = fopen($savefile, "w");
	fwrite($fh, base64_decode($_POST["filehtml5"]));
	fclose($fh);



	$orientation = $_POST["orientation"];
	if($orientation == 6) {
		// 시계방향으로 90도 돌려줘야 정상인데 270도 돌려야 정상적으로 출력됨
		$degree = 270;
	}
	else if($orientation == 8) {
		// 반시계방향으로 90도 돌려줘야 정상
		$degree = 90;
	}
	else if($orientation == 3) {
		$degree = 180;
	}

	if($degree) {
		if($orientation > 0) {
			$source = imagecreatefromjpeg($savefile);
			$source = imagerotate ($source , $degree, 0);
			imagejpeg($source, $savefile);
			imagedestroy($source);
		}
	}
  

}
else {
	$tempfile = $_FILES['file']['tmp_name'];
	$filename = $_FILES['file']['name'];

	$type = strtolower(substr($filename, strrpos($filename, ".")));
	$found = false;
	switch ($type) {
	case ".jpg":
	case ".jpeg":
	case ".gif":
	case ".png":
		$found = true;
	}

	if ($found != true) {
		exit;
	}

	$filename = $_POST["randomname"];
	$savefile = SAVE_DIR . '/' . $filename;

	move_uploaded_file($tempfile, $savefile);
	$imgsize = getimagesize($savefile);

	if (!$imgsize) {
		$filesize = 0;
		$filename = '-ERR';
		unlink($savefile);
	}
}


$filesize = filesize($savefile);

$rdata = sprintf('{"fileUrl": "%s/%s", "filePath": "%s", "fileName": "%s", "fileSize": "%d" }',
	SAVE_URL,
	$filename,
	$savefile,
	$filename,
	$filesize );

echo $rdata;
?>