<?
class Yc4Coupon {
	
	private $dao = null;
	private $ycObj = null;
	
	function Yc4Coupon() {
		global $dao;
		$this->dao = $dao;
		$this->ycObj = new Yc4();
	}
	
	
	function get($cpn_id){
		
		$result = $this->dao->doSelect("Yc4Coupon.get", array("cpn_id"=>$cpn_id));
		return $result[0];
	}
	
	function get_byNo($cpn_no){
		$result = $this->dao->doSelect("Yc4Coupon.get_byNo", array("cpn_no"=>$cpn_no));
		return $result[0];
	}
	

	
	// 리스트
	function get_list($page, $sfl = "", $stx = "", $sst = "", $sod = "", $rows = "", $where_query = "", $order_query = "", $useable="", $moreView=false) {
		if (! $rows)
			$rows = Props::get ( "rows" );
	
		$from_record = ($page - 1) * $rows;
	
		if($moreView){
			$from_record = 0;
			$rows = $page * $rows;
		}
	
		if (! $sst) {
			$sst = "cpn_id";
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
		
		if($useable != "")
			$params["useable"] = "Y";
			
		

		$result ["list"] = $this->dao->doSelect ( 'Yc4Coupon.list', $params );


	
		// 전체 리스트 수
		$params ["is_count"] = "Y";
		$listCnt = $this->dao->doSelect ( "Yc4Coupon.list", $params );
		$result ["count"] = $listCnt [0] ["cnt"];
	
		return $result;
	}
	
	//쿠폰번호 랜덤 생성
	function create_cpn_no(){
	 	$no = rand(10000, 99999);
	 	$str = "";
	 	for($idx = 0 ; $idx < 3; $idx++){
	 		$str .= chr(rand(65, 90));	
	 	}
	 	
	 	return $str.$no;
	}
	
	

	
	//쿠폰 생성
	function create_coupon($mb_id, $cpn_name, $cpn_start, $cpn_end, $cpn_type, $cpn_amt){
		
		if($this->is_dup($mb_id, $cpn_name)){
			return "DUP";
		}
		
		$params = array();
		$params["cpn_no"] = $this->create_cpn_no();
		$params["mb_id"] = $mb_id;
		$params["cpn_name"] = $cpn_name;
		$params["cpn_type"] = $cpn_type;
		$params["cpn_amt"] = $cpn_amt;
		$params["cpn_start"] = $cpn_start;
		$params["cpn_end"] = $cpn_end;
		
		
		$this->insert($params);
		
		
		return "OK";
	}
	
	
	
	function insert($params){
		$this->dao->doInsert("Yc4Coupon.insert", $params);
	}

	
	function insert_all($params) {
		
		
		$params["member_id"] = $this->member_id;
		$params["ip"] = $this->ip;
		
		if($params["mb_id"] == "") $params["mb_id"] = $this->member_id;
		
		$this->dao->doInsert ( "Yc4Coupon.insert_all", $params );
		$no = mysql_insert_id();
		
		return $no;
	}
	
	function update($params){
		$this->dao->doUpdate("Yc4Coupon.update", $params);
	}
	
	function delete($cpn_id){
		$this->dao->doDelete("Yc4Coupon.delete", array("cpn_id"=>$cpn_id));
	}
	
	function delete_byNo($params){
		$this->dao->doDelete("Yc4Coupon.delete_byNo", array("cpn_no"=>$cpn_no));
	}
	
	
	
	//쿠폰 할인가 계산
	function cal_cpn_amount($cpn_id, $ct_id){
		
		
		$ct = $this->ycObj->get_cart($ct_id);
		$cpn = $this->get($cpn_id);
		
		if($cpn[cpn_type] == "P") {
			if($cpn[cpn_amt] == 0){
				$cpnAmt = 0;
			} else {
				$cpnAmt = $ct[ct_amount] * $ct[ct_qty]; //$this->ycObj->get_sale_amount($it_id);
				$cpnAmt =  $cpnAmt * ( $cpn[cpn_amt] / 100);
				$cpnAmt = $this->ycObj->cal_round($cpnAmt,10);
			}
		} else {
			$cpnAmt = $cpn[cpn_amt];
		}
		
		
		return $cpnAmt;
		
	}
	
	
	//쿠폰 사용처리
	function use_coupon($cpn, $is_cpnNo = false){
			
			$params = array();
			if($is_cpnNo)
				$params["cpn_no"] = $cpn;
			else
				$params["cpn_id"] = $cpn;
			
			$this->dao->doUpdate("Yc4Coupon.use_coupon", $params);
		
	}
	


	//이미받은쿠폰인지 조회
	function is_dup($mb_id, $cpn_name){
			
			$params = array();
			$params["mb_id"] = $mb_id;
			$params["cpn_name"] = $cpn_name;
			$result = $this->dao->doSelect("Yc4Coupon.check_dup", $params);
			
			if($result[0]["cnt"] > 0){
				return true;
			} 
			return false;
	}
		

}





