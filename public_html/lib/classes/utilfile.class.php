<?
class Utilfile {
	private $dao = null;
	function Utilfile() {
		global $dao;
		
		$this->dao = $dao;
	}
	
	// 해당 폴더와 내용 전부 삭제
	function removeDir($dir) {
		if (! is_dir ( $dir ))
			return;
		$dirs = dir ( $dir );
		while ( false !== ($entry = $dirs->read ()) ) {
			if (($entry != '.') && ($entry != '..')) {
				if (is_dir ( $dir . '/' . $entry )) {
					Utilfile::removeDir ( $dir . '/' . $entry );
				} else {
					@unlink ( $dir . '/' . $entry );
				}
			}
		}
		$dirs->close ();
		@rmdir ( $dir );
	}
	
	// 이미지
	static function get_images($path, $od = "asc") {
		global $g4;
		
		$filePath = $path;
		
		$fileArray = array ();
		if (file_exists ( $filePath )) {
			$tmp = dir ( $filePath );
			while ( $entry = $tmp->read () ) {
				if ($entry == "thumb" || $entry == "_thumb")
					continue;
				if ($entry == "." || $entry == "..")
					continue;
				array_push ( $fileArray, $entry );
			}
			if ($od == "desc")
				rsort ( $fileArray );
			else
				sort ( $fileArray );
		}
		
		return $fileArray;
	}
	

	//파일 복수 업로드시 index기준으로 배열을 다시 만들어줌
	static  function reArrayFiles(&$file_post) {
	    $file_ary = array();
	    $file_count = count($file_post['name']);
	    $file_keys = array_keys($file_post);
	    for ($i=0; $i<$file_count; $i++) {
	        foreach ($file_keys as $key) {
	            $file_ary[$i][$key] = $file_post[$key][$i];
	        }
	    }
	    return $file_ary;
	}

	// 파일을 업로드 함
	static function upload_file($srcfile, $destfile, $dir) {
		if ($destfile == "")
			return false;
			// 업로드 한후 , 퍼미션을 변경함
		@move_uploaded_file ( $srcfile, "$dir/$destfile" );
		@chmod ( "$dir/$destfile", 0606 );
		return true;
	}
	static function img_thum($i_path, $w = 130, $h = 130, $pw = 0, $ph = 0) {
		$r = "";
		if (file_exists ( $i_path )) {
			
			$limit_w = $w; // 최대 가로 크기
			$limit_h = $h; // 최대 세로 크기
			               
			// 이미지 사이즈 비율조절 시작.
			$size = GetImageSize ( $i_path );
			$width = $size [0]; // 입력받은 파일의 가로크기
			$height = $size [1]; // 입력받은 파일의 세로크기
			                     // 긴쪽을 기준 사이즈로 한다.
			if ($width > $height) {
				$percentage = $width / $limit_w;
			} elseif ($height > $width) {
				$percentage = $height / $limit_h;
			} else {
				$percentage = $width / $limit_w;
			}
			// 크기에서 긴쪽을 나누어서 비율을 정한다.
			$height_new = $height / $percentage;
			$width_new = $width / $percentage;
			
			if ($height_new < 22) {
				$height_new = 22;
			}
			$size = getimagesize ( $i_path );
			
		
			if ($pw == 0)
				$pw = $size [0];
			if ($ph == 0)
				$ph = $size [1];
			
		

			$num = rand ( 0, 65535 );
			$r .= "<div style='position:relative;border:1px solid #efefef;width:{$width_new}px' >";
			$r .= "<img src='$i_path?" . date ( "YmdHis" ) . "' width='$width_new' height='$height_new'>";
			$r .= "<img src='/adm/img/icon_viewer.gif' border=0 align=absmiddle onclick=\"window.open('$i_path?" . date ( "YmdHis" ) . "', '', 'menubar=no, toolbar=no, directories=no, location=no,status=no, top=20, left=20, width=$pw, height=$ph' )\" style='position:absolute;right:0px;bottom:0px;cursor:pointer'>";
			$r .= "<div id='limg$num' style='left:0; top:0; z-index:+1; display:none; position:absolute;' ><img src='$i_path?" . date ( "YmdHis" ) . "' border=1 ></div>";
			$r .= "</div>";
		}
		return $r;
	}
	function get_mainimage_link($img_no) {
		$result = $this->dao->doSelect ( "Utilfile.get_mainimage_link", array (
				"image_no" => $img_no 
		) );
		return $result [0];
	}
	function insert_mainimage_link($params) {
		$this->dao->doInsert ( "Utilfile.insert_mainimage_link", $params );
	}
	function update_mainimage_link($params) {
		$this->dao->doUpdate ( "Utilfile.update_mainimage_link", $params );
	}
	function get_image_content($img_no, $tablename) {
		$result = $this->dao->doSelect ( "Utilfile.get_image_content", array (
				"image_no" => $img_no,
				"tablename" => $tablename 
		) );
		return $result [0];
	}
	function insert_image_content($params) {
		$this->dao->doInsert ( "Utilfile.insert_image_content", $params );
	}
	function update_image_content($params) {
		$this->dao->doUpdate ( "Utilfile.update_image_content", $params );
	}
	function delete_image_content($params){
		$this->dao->doDelete("Utilfile.delete_image_content", $params);
	}
}

?>