<?
if (!defined('_GNUBOARD_')) exit;

class UtilTranslate {
	
	var $file_server_path = "";
	var $server_path = "";
	var $xmlPath = "";
	
	var $strObj = null;
	var $strObj_tmp = null;	//2인 작업 시
	
	var $msgObj = null;

	function UtilTranslate(){

		$this->file_server_path = realpath(__FILE__);
		$this->server_path = str_replace(basename(__FILE__), "", $this->file_server_path);
		$this->xmlPath = $this->server_path;
		
		$this->setXmlObj();
	}
	
	function t($str, $lang="kor"){
		global $language;
		
		$l = $language;
		if($lang != "kor"){ $l = $lang; }

		return $this->getStr($str, $l);
	}

	function msg($str, $lang="kor"){

		global $language;
		
		$l = $language;
		if($lang != "kor"){ $l = $lang; }

		return $this->getMsg($str, $l);
	}
	

	//XML object 생성
	function setXmlObj(){

		//일반 단문 XML로드
		$filepath = $this->xmlPath."translate.xml";


		$xml = null;
		if(file_exists($filepath)){
			$xml=simplexml_load_file($filepath);
		} else {
			echo " Translate XML 파일 [".$filepath."] 을 찾을 수 없습니다. ";	
		}
		$this->strObj = $xml;
		
		
		//일반 단문 XML로드 (2인 작업 시 임시 파일 로드 (없으면 무시))
		$filepath = $this->xmlPath."translate_tmp.xml";
		$xml = null;
		if(file_exists($filepath)){
			$xml=simplexml_load_file($filepath);
			$this->strObj_tmp = $xml;
		} else {
			//Don't care
			$this->strObj_tmp = null;
		}
		


		//메시지 XML 로드
		$filepath = $this->xmlPath."translate_msg.xml";
		$xml = null;
		if(file_exists($filepath)){
			$xml=simplexml_load_file($filepath);
		} else {
			echo " Translate Message XML 파일 [".$filepath."] 을 찾을 수 없습니다. ";	
		}
		$this->msgObj = $xml;

		return true;
	}

	
	function getStr($str, $l){
		
		$x = $this->strObj;
		
		$tstr = $x->xpath("//t[@value='".$str."']");
		
		$result = $tstr[0][$l];
		
		if($result == ""){
			if($this->strObj_tmp != null){
				$result = $this->getStr_tmp($str, $l);
			} else {
				$result = $str;
			}
		}

		$result = str_replace("{br}","<br/>", $result);

		return $result;
	}
	
	//2인 작업용 tmp XML파일에서 검색
	function getStr_tmp($str, $l){
		
		$x = $this->strObj_tmp;
	
		$tstr = $x->xpath("//t[@value='".$str."']");
		
		$result = $tstr[0][$l];
		if($result == ""){
			$result = $str;
		}

		return $result;
	}

	function getMsg($str, $l){
		
		$x = $this->msgObj;

		$tstr = $x->xpath("//m[@msg='".$str."']");
		
		$result = $tstr[0][$l];
		if($result == ""){
			$result = $str;
		}
		
		$result = str_replace("{br}","<br/>", $result);

		return $result;
	}
}




$translateObj = new UtilTranslate();


//기본 문구를 번역합니다.
function t($str, $p1="", $p2="", $p3="", $p4="", $p5="", $p6=""){

	global $translateObj;
	//if($str == "문서자료") echo $translateObj;
	//if(!isset($translateObj)) $translateObj = new UtilTranslate();
	
	
	$result = "";
	if($p1 != ""){
		$param = array($p1, $p2, $p3, $p4, $p5, $p6);
		$result = t_reg($str, $param);
	} else {
		$result = $translateObj->t($str);
	}

	return $result;
}

//메시지를 번역합니다.
function msg($str, $p1="", $p2="", $p3="", $p4="", $p5="", $p6=""){
	global $translateObj;
	
	$result = "";
	if($p1 != ""){
		$param = array($p1, $p2, $p3, $p4, $p5, $p6);
		$result = msg_reg($str, $param);
	} else {
		$result = $translateObj->msg($str);
	}

	return $result;
}

//한국어가 아닐 경우 "_{lang[eng|chn|jpn]}" 을 반환합니다.
function t_pfx(){
	global $language;
	
	$r = "";
	if($language != "kor")
		$r = "_".$language;
	
	return $r;
}

//이미지이름 끝에 _{lang}을 붙인 경로를 반환합니다. 
function t_img($src){
	
	$src = str_replace("../", "|bbb|", $src);

	$filename = strtolower($src); 

	$elements = explode('.',$filename); 
	$elemcnt = count($elements)-1; 

	if(count($elements)==1) $ext = ''; 
	else $ext = $elements[$elemcnt]; 
	
	unset($elements[$elemcnt]); 
	$fname = implode($elements,'');
	

	$fname_t = $fname.t_pfx().".".$ext; 
	$fname_t.="\" onerror=\"this.src='".$fname.".".$ext."'"; 

	$fname_t = str_replace("|bbb|", "../", $fname_t);

	return $fname_t;
}


//배열변수에서 키값에 _{lang}을 붙인 결과를 반환합니다.
function tobj($obj, $key){
	global $language;
	
	$lstr = "";
	if($language != "kor")
		$lstr = "_".$language;

	$result = ($obj[$key.$lstr] == "" ? $obj[$key] : $obj[$key.$lstr]);

	return $result;
}

//각 언어별로 반환 - (한국어, 영어, 중국어, 일본어 )
function td($kor, $eng="", $chn="", $jpn=""){
	global $language;

	$result = "";
	switch($language){
		case "kor" :
			$result = $kor;
			break;
		case "eng" :
			$result = $eng;
			break;
		case "chn" :
			$result = $chn;
			break;
		case "jpn" :
			$result = $jpn;
	}

	return $result;
}


//문자열 중간에 param을 두고 변환
function t_reg($str, $params){

	global $translateObj;

	$result = $translateObj->t($str);
	
	

	for($idx = 1 ; $idx <= count($params) ; $idx++){
		$result = str_replace("{".$idx."}", $params[$idx-1], $result);
	}

	return $result;
}

//메시지 내에 param을 두고 변환
function msg_reg($str, $params){

	global $translateObj;

	$result = $translateObj->msg($str);
	

	for($idx = 1 ; $idx <= count($params) ; $idx++){
		$result = str_replace("{".$idx."}", $params[$idx-1], $result);
	}

	return $result;
}

?>