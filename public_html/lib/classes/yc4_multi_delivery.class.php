<?
class Yc4MultiDelivery {
    
    private $dao = null;
	private $member_id = "";
	private $ip = "";
	
	function __construct()
	{
		global $dao, $member;
		$this->dao = $dao;   

		$this->member_id = $member["mb_id"];
		$this->ip = $_SERVER["REMOTE_ADDR"];
	}
	

	function get_list($od_id, $page, $sfl = "", $stx = "", $sst = "", $sod = "", $rows = "", $where_query = "", $order_query = "") {
		
		global $g4;
		

		if (! $rows)
			$rows = Props::get ( "rows" );
		
		$from_record = ($page - 1) * $rows;
		if (! $sst) {
			$sst = "no";
			$sod = "";
			$order_query = "no asc";
		}

		// 리스트
		$params = array ();
		$params ["od_id"] = $od_id;
		$params ['page'] = $page;
		$params ['from_record'] = $from_record;
		$params ['rows'] = $rows;
		$params ['sfl'] = $sfl;
		$params ['stx'] = $stx;
		$params ['sst'] = $sst;
		$params ['sod'] = $sod;
		$params ['where_query'] = $where_query;
		$params ['order_query'] = $order_query;
		
		$result ["list"] = $this->dao->doSelect ( 'Yc4MultiDelivery.list', $params );
		
		// 전체 리스트 수
		$params ["is_count"] = "Y";
		$listCnt = $this->dao->doSelect ( "Yc4MultiDelivery.list", $params );
		$result ["count"] = $listCnt [0] ["cnt"];
		
		return $result;
	}
	
	
	
	function get($no) {

		$params = array();
		$params["no"] = $no;
		$result = $this->dao->doSelect ( "Yc4MultiDelivery.get", $params );
		
		return $result [0];
	}
	
	
	
	function insert($params) {
		

		$params["member_id"] = $this->member_id;
		$params["ip"] = $this->ip;
		
		$this->dao->doInsert ( "Yc4MultiDelivery.insert", $params );
		$no = mysql_insert_id();

		return $no;
	}
	
	
	function dl_update($params) {

		
		$params["member_id"] = $this->member_id;
		$params["ip"] = $this->ip;
		
		
		$this->dao->doUpdate("Yc4MultiDelivery.dl_update", $params);
	}


	function receiver_update($params){
		
		$params["member_id"] = $this->member_id;
		$params["ip"] = $this->ip;
		
		
		$this->dao->doUpdate("Yc4MultiDelivery.receiver_update", $params);
	}
	
		
	function update_field($no, $field, $value) {
		
		
		$params = array ();
		$params ["no"] = $no;
		$params ["field"] = $field;
		$params ["value"] = $value;
		
		$params["member_id"] = $this->member_id;
		$params["ip"] = $this->ip;
		
		$this->dao->doUpdate ( "Yc4MultiDelivery.update_field", $params );
	}
	
	
	function delete($no) {

		
		$params = array ();
		$params ["no"] = $no;
		$this->dao->doDelete ( "Yc4MultiDelivery.delete", $params );
		
		
	}
	

	//전부 운송장 번호가 들어가있는가?
	function is_all_invoice($od_id){
		
		$params = array();
		$params["od_id"] = $od_id;
		$result = $this->dao->doSelect("Yc4MultiDelivery.is_all_invoice", $params );

		if($result[0]["cnt"] == 0) {
			return true;
		}
		return false;
	}
	


	static function get_list_qty($qty) {

		$result = array();

		$qty_list = explode("||", $qty);
		foreach($qty_list as $qtys){
			$qty = explode("|",$qtys);
			
			$row = array();
			$row["name"] = urldecode($qty[0]);
			$row["qty"] = $qty[1];
			
			$result[] = $row;
		}

		return $result;

	}

	static function get_qty_string($qty){
		
		$result = "";

		$qty_list = explode("||", $qty);
		foreach($qty_list as $qtys){
			$qty = explode("|",$qtys);
			if($result != "") $result .= "<br/>";
			$result .= urldecode($qty[0])." - ".$qty[1];
		}
		
		return $result;
	}
}


