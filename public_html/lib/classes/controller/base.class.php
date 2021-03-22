<?
class Base {

	protected $dao = null;
	
	public $member_id = "";
	public $ip = ""; 
	
	private $is_auth_checkd = false;
	private $authObj = null;
	
	private $logObj = null;
	private $codeObj = null;

	protected $is_admin = "N";
	protected $post_show_days = "";

	protected $log_mode = "";
	
	function __construct() {
		
		global $dao, $member, $authObj, $config;
		
		$this->dao = $dao;
		$this->member_id = $member["mb_id"];
		$this->ip = $_SERVER["REMOTE_ADDR"];
		$this->authObj = $authObj;
		
		if($member["mb_level"] == 10 && strpos($_SERVER['PHP_SELF'], "/adm/") === 0) {
			$this->is_admin = "Y";
		}
		
		$this->post_show_days = $config["cf_post_show_days"];
	}
	
	
	function crud_auth_check($crud){
		
		global $member, $g4;
		if($member["mb_level"] == 10) return true;
		

		if(!$this->authObj INSTANCEOF Auth_Controller) {
			$this->authObj = new Auth_Controller();
		}
		
		$this->authObj->check_page_auth_CRUD($crud);
		
		return true;
		
		/*
		$result = true;
		$result = $this->authObj->check_CRUD_auth($crud);
		
		if(!$result) {
			goto_url("{$g4[path]}/noauth.php", true);
		}
		
		return $result;
		*/
	}	
	
	
	
	//전체리스트
	function get_all_list($sfl = "", $stx = "", $sst = "", $sod = "", $where_query = "", $order_query = ""){
		$listResult = $this->get_list(1, $sfl, $stx, $sst, $sod, PHP_INT_MAX, $where_query, $order_query);
		$list = $listResult["list"];
		return $list;
	}
	
	
	
	function auth_check($key){
		/*
		if(!$this->is_auth_checkd) { //한 인스턴스에서 한번만 검사
			
			if(count($key) == 3){
				$thisRow = $this->get($key[0], $key[1], $key[2]);
			} else if(count($key) == 2){
				$thisRow = $this->get($key[0], $key[1]);
			} else {
				$thisRow = $this->get($key);
			}
		}
		*/
	}
	
	
	
	
	/**********************************************************************************************************************
	 * 로그관련
	 */
	
	//추가기록에대한 로그문자열 생성
	function set_inlog_str($field, $fname, $i){
		$result = "";
		$i = $i[$field];
		$result .= "[{$fname} ▶ ".str_replace("\r\n", " ", $i)."] ";
		return $result;
	}
	
	
	//변경기록에대한 로그문자열 생성
	function set_uplog_str($field, $fname, $bi, $mi){
		$result = "";
		$b = $bi[$field];
		$m = str_replace("\'", "'", $mi[$field]);
		
		if($b != $m){
			
			if($this->log_mode == "UD") {
				$result .= "[{$fname} : ".str_replace("\r\n", " ", $b)."] ";
			} else {
				$result .= "[{$fname} : ".str_replace("\r\n"," ",$b)." ▶ ".str_replace("\r\n", " ", $m)."] ";
			}
		}
		return $result;
	}
	
	
	function get_uplog_dbno($field, $fname, $bi, $mi, $type="") {
		
		$obj = null;
		$bname = "";
		$mname = "";
		$result = "";
		
		$b = $bi[$field];
		$m = $mi[$field];
				
		if($type == "it"){
			$obj = new PcfItem();
			$bb = $obj->get($b);
			$mm = $obj->get($m);
			$bname = $bb["it_name"];
			$mname = $mm["it_name"];
		}
		else if($type == "itt"){
			$obj = new PcfItemType();
			$bb = $obj->get($b);
			$mm = $obj->get($m);
			$bname = $bb["itt_name"];
			$mname = $mm["itt_name"];
		}
		else if($type == "cos"){
			$obj = new PcfItemCourse("", "");
			$bb = $obj->get($b);
			$mm = $obj->get($m);
			$bname = $bb["cos_name"];
			$mname = $mm["cos_name"];
		}
		else if($type == "cli") {
			$obj = new PcfClient();
			$bb = $obj->get($b);
			$mm = $obj->get($m);
			$bname = $bb["cli_name"];
			$mname = $mm["cli_name"];
		}
		else if($type == "cem") {
			$obj = new PcfClientEmp();
			$bb = $obj->get($b);
			$mm = $obj->get($m);
			$bname = $bb["cem_name"];
			$mname = $mm["cem_name"];
		}
		else if($type == "sale"){
			$obj = new PcfSale();
			$bb = $obj->get($b);
			$mm = $obj->get($m);
			if($b == "0") $bname = "없음"; else $bname = $bb["sl_name"];
			if($m == "0") $mname = "없음"; else $mname = $mm["sl_name"];
			
		}
		
		
		if($bname == "") $bname = "≪NO : {$b}≫";
		if($mname == "") $mname = "≪NO : {$m}≫";

		
		if($b != $m) {
			
			if($this->log_mode == "UD") {
				$result .= "[{$fname} : ".str_replace("\r\n", " ", $bname)."] ";
			} else {
				$result .= "[{$fname} : ".str_replace("\r\n"," ",$bname)." ▶ ".str_replace("\r\n", " ", $mname)."] ";
			}
			
		}
		return $result;
		
	}
	
	
	//변경기록에대한 로그문자열 생성
	function set_uplog_str_checkbox($field, $fname, $bi, $mi, $checkvalue=1, $uncheckvalue=0){
		$result = "";
		
		$b = $bi[$field];
		$m = $mi[$field] ? $mi[$field] : $uncheckvalue;
		
		//echo "{$b} : {$m}";exit;
		
		if($b != $m) {
			if($this->log_mode == "UD") {
				$result .= "[{$fname} : ".($m == $checkvalue ? "Unchecked" : "Checked")."] ";
			} else {
				$result .= "[{$fname} : ".($m == $checkvalue ? "Unchecked" : "Checked")." ▶ ".($m == $checkvalue ? "Checked" : "Unchecked")."] ";
			}
		}
		return $result;
	}
	
	//변경기록에대한 로그문자열 생성
	function set_uplog_str_code($field, $fname, $bi, $mi){
		
		if($this->codeObj == null) $this->codeObj = new Code();
		
		$result = "";
	
		$b = $bi[$field];
		$m = $mi[$field];
	
		if($b != $m) { 
			$b = $this->codeObj->get_value($b);
			$m = $this->codeObj->get_value($m);
			if($this->log_mode == "UD") {
				$result .= "[{$fname} : ".$b."] ";
			} else {
				$result .= "[{$fname} : ".$b." ▶ ".$m."] ";
			}
		}
		return $result;
	}
	
	//변경기록에대한 로그문자열 생성
	function set_uplog_str_codelist($field, $fname, $bi, $mi){
	
		if($this->codeObj == null) $this->codeObj = new Code();
	
		$result = "";
		
		$b = $bi[$field];
		$m = $mi[$field];
		
		if($b != $m) {
			$b = Code::get_codes_value($b);
			$m = Code::get_codes_value($m);
			
			if($this->log_mode == "UD") {
				$result .= "[{$fname} : ".$b."] ";
			} else {
				$result .= "[{$fname} : ".$b." ▶ ".$m."] ";
			}
		}
		return $result;
	}
	
	
	//변경로그
	function set_log($div1, $div2, $pno, $logStr, $com_id=""){
	
		global $member;
		
		if($this->logObj == null) {
			$this->logObj = new PcfLog();
		}
		
		$this->logObj->member_id = $this->member_id;
		$this->logObj->ip = $this->ip;
		
			
		$logStr = str_replace("\'","''",$logStr);
		$logStr = str_replace("'","''",$logStr);
		
		//로그기록
		$log = array();
		$log["log_div1"] = $div1;
		$log["log_div2"] = $div2;
		$log["log_date"] = date("Y-m-d H:i:s");
		$log["pno"] = $pno;
		$log["log_content"] = $logStr;
		$log["admin_level"] = $member["mb_level"] ? $member["mb_level"] : "0";
		$this->logObj->insert($log);
		
	
	}
	 /*
	* 로그관련 끝
	**********************************************************************************************************************/
	
}