<?
class Yc4ItemOption {


	private $dao = null;
	
	function Yc4ItemOption() {
		global $dao;
		$this->dao = $dao;
	}

	//전체리스트
	function get_all_list($it_id, $sfl = "", $stx = "", $sst = "", $sod = "", $where_query = "", $order_query = ""){
		$listResult = $this->get_list($it_id, 1, $sfl, $stx, $sst, $sod, PHP_INT_MAX, $where_query, $order_query);
		$list = $listResult["list"];
		return $list;
	}


	function get_list($it_id, $page, $sfl = "", $stx = "", $sst = "", $sod = "", $rows = "", $where_query = "", $order_query = "") {

		global $g4;

		if (! $rows)
			$rows = Props::get ( "rows" );
		
		$from_record = ($page - 1) * $rows;
		if (! $sst) {
			$sst = "no";
			$sod = "asc";
		}

		// 리스트
		$params = array ();
		$params ['it_id'] = $it_id;
		$params ['page'] = $page;
		$params ['from_record'] = $from_record;
		$params ['rows'] = $rows;
		$params ['sfl'] = $sfl;
		$params ['stx'] = $stx;
		$params ['sst'] = $sst;
		$params ['sod'] = $sod;
		$params ["bo_table"] = $this->write_table;
		$params ['where_query'] = $where_query;
		$params ['order_query'] = $order_query;
		
		$result ["list"] = $this->dao->doSelect ( 'Yc4ItemOption.list', $params );
		
		// 전체 리스트 수
		$params ["is_count"] = "Y";
		$listCnt = $this->dao->doSelect ( "Yc4ItemOption.list", $params );
		$result ["count"] = $listCnt [0] ["cnt"];
		
		return $result;
	}


	
	function get($no){

		$params = array();
		$params["no"] = $no;
		$result = $this->dao->doSelect("Yc4ItemOption.get", $params);
		return $result[0];
	}


	function insert($params){

		$this->dao->doInsert("Yc4ItemOption.insert", $params);
	}
	
	function update($params){
		
		$this->dao->doUpdate("Yc4ItemOption.update", $params);
	}
	
	function update_no($params){

		$this->dao->doUpdate("Yc4ItemOption.update", $params);
	}

	function delete($no){
		$params = array();
		$params["no"] = $no;
		$this->dao->doDelete("Yc4ItemOption.delete", $params);
	}

	function delete_item($it_id){
		$params = array();
		$params["it_id"] = $it_id;
		$this->dao->doDelete("Yc4ItemOption.delete_item", $params);
	}

	
	//옵션 수량
	function get_qty($it_id, $ct_id, $type1="", $type2="", $type3="", $is_direct=false){
		
		$result = 0;

		$qty = 0;
		if($type1 == "" && $type2 == "" && $type3 == ""){

			$qty = get_it_stock_qty($it_id, $ct_id);

		} else {	

			//총 수량
			$opt = $this->get_option($it_id, $type1, $type2, $type3);
			$qty = $opt["io_qty"];

		}


		//장바구니수량
		$cart_qty = 0;
		if(!$is_direct)
			$cart_qty = $this->get_mycart_qty($it_id, $ct_id, $type1, $type2, $type3);
	
		//주문대기 수량
		$used_qty = $this->get_stock_qty($it_id, $type1, $type2, $type3);
		
		$result = $qty - $cart_qty - $used_qty;
		

		if($result < 0) $result = 0;
		
		return $result;
	}


	//장바구니 옵션 수량
	function get_mycart_qty($it_id, $ct_id, $type1, $type2, $type3){

		$tmp_on_uid = get_session("ss_on_uid");
		$params = array();
		$params["it_id"] = $it_id;
		$params["it_option1"] = $type1;
		$params["it_option2"] = $type2;
		$params["it_option3"] = $type3;
		$params["ct_id"] = $ct_id;
		$params["on_uid"] = $tmp_on_uid;

		$result = $this->dao->doSelect("Yc4ItemOption.get_mycart_qty", $params);

		return intval($result[0]["cnt"]);
	}

	//주문대기중 옵션 수량(재고에서 빼지 않은 수량)
	function get_stock_qty($it_id, $type1, $type2, $type3) {
		$params = array();
		$params["it_id"] = $it_id;
		$params["it_option1"] = $type1;
		$params["it_option2"] = $type2;
		$params["it_option3"] = $type3;
		$result = $this->dao->doSelect("Yc4ItemOption.get_stock_qty", $params);
		return intval($result[0]["cnt"]);

	}

	//옵션정보
	function get_option($it_id, $type1="", $type2="", $type3=""){
		$params = array();
		$params["it_id"] = $it_id;
		$params["io_type1"] = $type1;
		$params["io_type2"] = $type2;
		$params["io_type3"] = $type3;

		$result = $this->dao->doSelect("Yc4ItemOption.get_option", $params);

		return $result[0];
	}
	
	//Depth2 옵션 리스트
	function get_options_d2($it_id, $type1){
		$params = array();
		$params["it_id"] = $it_id;
		$params["io_type1"] = $type1;
		$result = $this->dao->doSelect("Yc4ItemOption.get_options_d2", $params);
		return $result;
	}
	
	//Depth3 옵션 리시트
	function get_options_d3($it_id, $type1, $type2){
		$params = array();
		$params["it_id"] = $it_id;
		$params["io_type1"] = $type1;
		$params["io_type2"] = $type2;
		$result = $this->dao->doSelect("Yc4ItemOption.get_options_d3", $params);
		return $result;
	}

	function opt_list($optno, $it_id, $type2=""){
		$params["it_id"] = $it_id;
		$params["io_type2"] = $type2;
		$result = $this->dao->doSelect("Yc4ItemOption.opt{$optno}_list", $params);
		return $result;
	}


	//장바구니 옵션명 출력
	function print_option_cart($it_id, $type1, $type2, $type3, $amt, $sep=" / "){

		$obj = new Yc4();
		$it = $obj->get_item($it_id);
		
		$result = "";
		if($type1 != "") {
			$result .= $it["it_option1_subject"]." : ".$type1;
			if($type2 != "") $result .= $sep.$it["it_option2_subject"]." : ".$type2;
			if($type3 != "") $result .= $sep.$it["it_option3_subject"]." : ".$type3;

			if($amt != 0) {
				$amt = number_format($amt);
				$result.=(" (+{$amt}원)");
			}
		}
		
		
		return $result;
	}


	//재고반영 (재고반영 DB 업뎃은 안함)
	function set_qty($ct_id, $is_cancel){
		
		$obj = new Yc4();
		$ct = $obj->get_cart($ct_id);

		$params = array();
		$params["it_id"] = $ct["it_id"];
		$params["io_type1"] = $ct["it_option1"];
		$params["io_type2"] = $ct["it_option2"];
		$params["io_type3"] = $ct["it_option3"];
		$params["qty"] = $ct["ct_qty"] * ($is_cancel ? +1 : -1);

		$this->dao->doUpdate("Yc4ItemOption.set_qty", $params);
	}


}


