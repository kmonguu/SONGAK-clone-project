<?
class Member {
	public $dao = null;
	function Member() {
		global $dao;
		$this->dao = $dao;
	}
	function get($mb_id) {
		$resultArr = $this->dao->doSelect ( "Member.select", array (
				"mb_id" => $mb_id 
		) );
		$result = $resultArr [0];
		return $result;
	}
	
	// 회원목록 리스트
	function get_list($page, $sfl = "", $stx = "", $sst = "", $sod = "", $rows = "", $where_query = "", $order_query = "", $moreView=false) {
		if (! $rows)
			$rows = Props::get ( "rows" );
		
		$from_record = ($page - 1) * $rows;
		
		if($moreView){
			$from_record = 0;
			$rows = $page * $rows;
		}
		
		if (! $sst) {
			$sst = "mb_no";
			$sod = "desc";
		}
		
		// 리스트
		$params = array ();
		$params ['page'] = $page;
		$params ['from_record'] = $from_record;
		$params ['rows'] = $rows;
		$params ['sfl'] = $sfl;
		$params ['stx'] = $stx;
		$params ['sst'] = $sst;
		$params ['sod'] = $sod;
		$params ['where_query'] = $where_query;
		$params ['order_query'] = $order_query;
		$result ["list"] = $this->dao->doSelect ( 'Member.list', $params );
		
		// 전체 리스트 수
		$params ["is_count"] = "Y";
		$listCnt = $this->dao->doSelect ( "Member.list", $params );
		$result ["count"] = $listCnt [0] ["cnt"];
		
		return $result;
	}
	
	// 회원전체목록
	function get_list_all($where_query = "", $order_query = "") {
		$rows = 65535;
		
		$sst = "mb_name";
		$sod = "asc";
		
		$where_query .= " AND mb_leave_date = '' ";
		
		// 리스트
		$params = array ();
		$params ['page'] = 1;
		$params ['from_record'] = 0;
		$params ['rows'] = $rows;
		$params ['sst'] = $sst;
		$params ['sod'] = $sod;
		$params ['where_query'] = $where_query;
		$params ['order_query'] = $other_query;
		
		$result = $this->dao->doSelect ( 'Member.list', $params );
		
		return $result;
	}
	
	function get_field($field, $search){
		$params = array();
		$params["field"] = $field;
		$params["search"] = $search;
		$result = $this->dao->doSelect("Member.select_field", $params);
		
		return $result;
	}
	
	function update($params){
		
		$this->dao->doUpdate("Member.update", $params);
	}
	
	// 한개필드 업뎃용
	function update_field($id, $field, $value) {
		$params = array ();
		$params ["mb_id"] = $id;
		$params ["field"] = $field;
		$params ["value"] = $value;
		$this->dao->doUpdate ( "Member.update_field", $params );
	}
	
	// 아이디 중복체크
	function id_dup_chk($mb_id) {
		$result = $this->dao->doSelect ( "Member.id_dup_chk", array (
				"mb_id" => $mb_id 
		) );
		if ($result [0] [cnt] == 0) {
			return true; // 중복아님
		}
		return false; // 중복
	}
	
	// 회원 추가 (/adm/에서 추가하는 거랑 다를 수 있음)
	function insert($params) {
		$this->dao->doInsert ( "Member.insert", $params );
	}
	
	// 탈퇴하거나 없는 회원?
	function is_leave($mb_id) {
		$mb = $this->get ( $mb_id );
		
		if ($mb [mb_leave_date] != "") {
			return true; // 탈퇴한 회원
		}
		
		return false;
	}
}
?>