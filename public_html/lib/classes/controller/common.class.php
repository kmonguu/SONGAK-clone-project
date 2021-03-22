<?
class Common {
	
	function __construct() {

	}
	
	static function zero_is_this_str($value, $str="-", $number_format=true){
		if($value === 0 || !$value) {
			return $str;
		} else {
			return number_format($value);
		}
	}
	
	//$_REQUEST 파라미터들 Index기준으로 배열 재생성
	static  function reArrayRequest($count_keyname) {
		
		$request = $_REQUEST;
		$param_ary = array();
		$param_count = count($request[$count_keyname]);
		$param_keys = array_keys($request);
		for ($i=0; $i<$param_count; $i++) {
			foreach ($param_keys as $key) {
				$param_ary[$i][$key] = $request[$key][$i];
			}
		}
		return $param_ary;
	}
	

	//$_FILES 파라미터들 Index기준으로 배열 재생성
	static  function reArrayFileRequest($filename) {

		$count_keyname = "name";
		$request = $_FILES[$filename];
		$param_ary = array();
		$param_count = count($request[$count_keyname]);
		$param_keys = array_keys($request);
		for ($i=0; $i<$param_count; $i++) {
			foreach ($param_keys as $key) {
				$param_ary[$i][$key] = $request[$key][$i];
			}
		}
		return $param_ary;
	}
	
	static function get_search_parameter_in_sesstion($param, $ssname){
		
		if(isset($param)){ //카테고리 검색값 세션저장
			set_session($ssname, $param);
			$result = $param;
		} else {
			$result = get_session($ssname);
		}
		
		return $result;
	}
	
	
	
	static function make_search_qstr($prefix = "sch_"){
		
		$result = "";
		foreach($_REQUEST as $key => $value) {
			if(strpos($key, $prefix) === 0) {
				$value = urlencode($value);
				$result .= "&{$key}={$value}";
			}
		}
		return $result;
	}
	
	static function make_search_hidden($prefix = "sch_"){
		
		$result = "";
		$result .= "<input type='hidden' name='stx' value='{$_REQUEST["stx"]}' />\r\n";
		$result .= "<input type='hidden' name='sfl' value='{$_REQUEST["sfl"]}' />\r\n";		
		$result .= "<input type='hidden' name='sod' value='{$_REQUEST["sod"]}' />\r\n";
		$result .= "<input type='hidden' name='sst' value='{$_REQUEST["sst"]}' />\r\n";
		$result .= "<input type='hidden' name='page' value='{$_REQUEST["page"]}' />\r\n";
		
		foreach($_REQUEST as $key => $value) {
			if(strpos($key, $prefix) === 0) {
				
				$result .= "<input type='hidden' name='{$key}' value='{$value}' />\r\n";
			}
		}
		return $result;
	}
	
	
	static function dkr_log($obj, $div2, $no, $field, $b, $a){
		
		global $hotel_no; // /extend/hotel_select.php
		
		$log["ho_no"] = $hotel_no;
		$log["div"] = get_class($obj);
		$log["div2"] = $div2;
		$log["pno"] = $no;
		$log["field"] = $field;
		$log["before"] = addslashes($b);
		$log["after"] = $a;
		
		new DkrLog($log);
		
	}



}