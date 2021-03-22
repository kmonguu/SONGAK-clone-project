<?
class HpBoard {
    
    protected $dao = null;

	function __construct(){

		global $helper_dao;
		$this->dao = $helper_dao;
		$this->delete_check(); 
	}
	

	//msg테이블의 연결 게시물이 삭제된 경우 is_read를 1(읽음) 처리해서 안읽은 숫자 맞춤
	function delete_check(){

		$listR = $this->get_list(1, "", "", "", "", PHP_INT_MAX, " AND is_read = 0 ");
		$list = $listR["list"];

		foreach($list as $m) {
			if($m["bo_table"] == "shop_order") break;
			$b = $this->get_board_article($m["bo_table"], $m["wr_id"]);
			if(!$b["wr_id"]){ //없으면 삭제된것, 읽음처리해버림
				$this->update_field($m["msg_no"], "is_read", "1");
			}
		}
		
	}

	function get_list($page, $sfl = "", $stx = "", $sst = "", $sod = "", $rows = "", $where_query = "", $order_query = "", $is_moreview=false) {
		
		global $g4;
		
		if (! $rows)
			$rows = 15;
		
		if(!$is_moreview) {
			$from_record = ($page - 1) * $rows;
		} else {
			$from_record = "0";
			$rows = $page * $rows;
		}
		
		if (! $sst) {
			$sst = "msg_no";
			$sod = "desc";
			$order_query = "";
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
		
		$params["is_admin"] = $this->is_admin;
		$result ["list"] = $this->dao->doSelect ( 'HpBoard.list', $params );
		
		// 전체 리스트 수
		$params ["is_count"] = "Y";
		$listCnt = $this->dao->doSelect ( "HpBoard.list", $params );
		$result ["count"] = $listCnt [0] ["cnt"];
		
		return $result;
	}
	
	    
	function get_board_article($bo_table, $wr_id){
		
		$params = array();
		$params["bo_table"] = $bo_table;
		$params["wr_id"] = $wr_id;
		$result = $this->dao->doSelect("HpBoard.get_board_article", $params);

		return $result[0];
	}

	function get($msg_no) {
		
		$params = array();
		$params["msg_no"] = $msg_no;
		$result = $this->dao->doSelect ( "HpBoard.get", $params );
		
		return $result [0];
	}
    
    
    function get_board($bo_table){
        $result = $this->dao->doSelect("HpBoard.get_board", array("bo_table"=>$bo_table));
        return $result[0];
    }

    //읽지 않은 새 게시글 숫자
    function get_new_cnt() {
        $params = array();
        $result = $this->dao->doSelect("HpBoard.get_new_cnt", $params);

        return $result[0]["cnt"];
    }
	
	
	function insert($params) {
	
		$this->dao->doInsert ( "HpBoard.insert", $params );
		$no = mysql_insert_id();
		
		return $no;
	}
	
	
	function update($params) {
		
		$this->dao->doUpdate("HpBoard.update", $params);
	}
	

	function update_is_read($wr_id, $bo_table) {

		$params = array();
		$params["wr_id"] = $wr_id;
		$params["bo_table"] = $bo_table;
		
		$this->dao->doUpdate("HpBoard.update_is_read", $params);

	}

	function update_field($msg_no, $field, $value) {
		
		$params = array ();
		$params ["msg_no"] = $msg_no;
		$params ["field"] = $field;
		$params ["value"] = $value;
		
		$this->dao->doUpdate ( "HpBoard.update_field", $params );
	}
	
	
	function delete($msg_no) {
		
		$params = array ();
		$params ["msg_no"] = $msg_no;
		$this->dao->doDelete ( "HpBoard.delete", $params );
		
	}
	
	

	
}


