<?
class APIStoreKKOConfig {
	
	protected $dao = null;

	public $member_id = "";
	public $ip = ""; 
	
	public $com_id = "";

	function __construct($com_id = "") {
		
		global $dao, $member;
		
		$this->dao = $dao;

		$this->member_id = $member["mb_id"];
		$this->ip = $_SERVER["REMOTE_ADDR"];

		if($com_id != ""){
			$this->com_id = $com_id;
		}

	}
	
	//전체리스트
	function get_all_list($sfl = "", $stx = "", $sst = "", $sod = "", $where_query = "", $order_query = ""){
		$listResult = $this->get_list(1, $sfl, $stx, $sst, $sod, PHP_INT_MAX, $where_query, $order_query);
		$list = $listResult["list"];
		return $list;
	}
	
	

	function get_list($page, $sfl = "", $stx = "", $sst = "", $sod = "", $rows = "", $where_query = "", $order_query = "") {
		
		global $g4;
		
		if (! $rows)
			$rows = Props::get ( "rows" );
		
		$from_record = ($page - 1) * $rows;
		if (! $sst) {
			$sst = "bc_no";
			$sod = "desc";
		}
		
		// 리스트
		$params = array ();
		$params ['com_id'] = $this->com_id;
		$params ['page'] = $page;
		$params ['from_record'] = $from_record;
		$params ['rows'] = $rows;
		$params ['sfl'] = $sfl;
		$params ['stx'] = $stx;
		$params ['sst'] = $sst;
		$params ['sod'] = $sod;
		$params ['where_query'] = $where_query;
		$params ['order_query'] = $order_query;
		
		$result ["list"] = $this->dao->doSelect ( 'APIStoreKKOConfig.list', $params );
		
		// 전체 리스트 수
		$params ["is_count"] = "Y";
		$listCnt = $this->dao->doSelect ( "APIStoreKKOConfig.list", $params );
		$result ["count"] = $listCnt [0] ["cnt"];
		
		return $result;
	}
	
	
	
	function get($com_id="") {
		
		if($com_id == "") { $com_id = $this->com_id; }
		
		$params = array();
		$params["com_id"] = $com_id;
		$result = $this->dao->doSelect ( "APIStoreKKOConfig.get", $params );
		
		return $result [0];
	}
	
	
	
	function insert($params) {
		

		if($params["com_id"] == "") { $params["com_id"] = $this->com_id; } 

		
		$params["member_id"] = $this->member_id;
		$params["ip"] = $this->ip;
		
		$this->dao->doInsert ( "APIStoreKKOConfig.insert", $params );
		$no = mysql_insert_id();

		return $no;
	}
	
	
	function update($params) {

		if($params["com_id"] == "") { $params["com_id"] = $this->com_id; } 
		
		$params["member_id"] = $this->member_id;
		$params["ip"] = $this->ip;
		
		$this->dao->doUpdate("APIStoreKKOConfig.update", $params);
	}
	
		
	
	
	
	function delete($com_id = "") {
		
		if($com_id == "") { $com_id = $this->com_id; }

		$this->com_id_check($com_id);
		
		$params = array ();
		$params ["com_id"] = $com_id;
		$this->dao->doDelete ( "APIStoreKKOConfig.delete", $params );
	}
	
	
}


