<?
class Yc4 {
	
	public static $IT_TYPE = array(
		"1" => "Hit"
		, "2" => "추천"
		, "3" => "New"
		, "4" => "Best"
		, "5" => "Sale"
	);


	private $dao = null;
	
	function Yc4() {
		global $dao;
		$this->dao = $dao;
	}
	
	
	
	
	//##############################################################################
	// 주문 관련
	
	function get_order($od_id){
		$result = $this->dao->doSelect("Yc4.get_order", array("od_id"=>$od_id));
		return $result[0];
	}
	function get_order_byOnUid($on_uid){
		$result = $this->dao->doSelect("Yc4.get_order_byOnUid", array("on_uid"=>$on_uid));
		return $result[0];
	}
	//주문의 상품 수
	function get_od_it_cnt($on_uid){
		
		$result = $this->dao->doSelect("Yc4.get_od_it_cnt", array("on_uid"=>$on_uid));
		return $result[0]["cnt"];
	}
	
	//주문추가
	function insert_order($params){
		
		if(!$params["on_uid"]) { 
			$new_on_uid = get_unique_id();
			$params["on_uid"] = $new_on_uid;
		}
		
		$new_od_id = get_new_od_id();
		$params["od_id"] = $new_od_id;
		
		$params["od_ip"] = $_SERVER["REMOTE_ADDR"];
		
		$result = $this->dao->doInsert("Yc4.insert_order", $params);
		
		return $params;
	}
	
	//주문삭제
	function delete_order($on_uid){
		
		$this->dao->doDelete("Yc4.delete_order", array("on_uid"=>$on_uid));
	}
	
	
	//주문 필드 업데이트
	function update_order_field($od_id, $field, $value){
	
		$params = array();
		$params["field"] = $field;
		$params["value"] = $value;
		$params["od_id"] = $od_id;
	
		$this->dao->doUpdate("Yc4.update_order_field", $params);
	}
	
	//주문 필드 업데이트
	function update_order_field_by_uid($on_uid, $field, $value){
	
		$params = array();
		$params["field"] = $field;
		$params["value"] = $value;
		$params["on_uid"] = $on_uid;
	
		$this->dao->doUpdate("Yc4.update_order_field_by_uid", $params);
	}
		
	// 주문 관련 끝
	//##############################################################################
	
	

	
	//##############################################################################
	// 상품 관련

	//상품정보 가져오기
	function get_item($it_id){
		
		$result = $this->dao->doSelect("Yc4.get_item", array("it_id"=>$it_id));
		return $result[0];
	}
	
	//상품 필드 업데이트
	function update_item_field($it_id, $field, $value){
		
		$params = array();
		$params["field"] = $field;
		$params["value"] = $value;
		$params["it_id"] = $it_id;
		
		$this->dao->doUpdate("Yc4.update_item_field", $params);
	}
	
	
	
	//상품옵션 리스트
	function get_it_options($it_id){
		
		$result = $this->dao->doSelect("Yc4.get_it_options", array("it_id"=>$it_id));
		return $result;
	}
	
	//상품옵션 정보
	function get_it_option_info($op_id){
		$result = $this->dao->doSelect("Yc4.get_it_option_info", array("op_id"=>$op_id));
		return $result[0];
	}
	
	//상품옵션 추가
	function insert_it_options($params){
		
		$this->dao->doInsert("Yc4.insert_it_options", $params);
	
		return mysql_insert_id();
	}
	
	//상품옵션 업데이트
	function update_it_options($params){
		
		$this->dao->doUpdate("Yc4.update_it_options", $params);
	}
	
	//상품옵션 제거
	function delete_it_options($op_id){

		$this->dao->doDelete("Yc4.delete_it_options", array("op_id"=>$op_id));
		
		//옵션 하위 리스트 제거
		$this->delete_it_option_list_all($op_id);
	}
	
	//상품항목정보
	function get_it_option_list_info($opl_no){
		$result = $this->dao->doSelect("Yc4.get_it_option_list_info", array("opl_no"=>$opl_no));
		return $result[0];
	}
			
	//상품 옵션 항목 리스트 
	function get_it_option_list($op_id){
		
		$result = $this->dao->doSelect("Yc4.get_it_option_list", array("op_id"=>$op_id));
		return $result;
	}

	//상품 옵션 항목 등록
	function insert_it_option_list($params){
		
		$this->dao->doInsert("Yc4.insert_it_option_list", $params);
		return mysql_insert_id();
	}
	
	
	//상품 옵션 항목 업뎃
	function update_it_option_list($params) {
		
		$this->dao->doUpdate("Yc4.update_it_option_list", $params);
	}
	
	//상품 옵션 항목 삭제
	function delete_it_option_list($opl_no){
		
		$this->dao->doDelete("Yc4.delete_it_option_list", array("opl_no"=>$opl_no));
	}
	
	//상품 옵션 항목 전부 삭제
	function delete_it_option_list_all($op_id){
		
		$this->dao->doDelete("Yc4.delete_it_option_list_all", array("op_id"=>$op_id));
	}
	
	//상품 삭제에 따른 옵션 항목 전부 삭제
	function delete_it_option_list_item($it_no){
		
		$this->dao->doDelete("Yc4.delete_it_option_list_item", array("it_no"=>$it_no));
	}

	//반올림처리
	function cal_round($v, $p = 100){
		$r = round($v * (1/$p)) * $p; //100단위 반올림
		return $r;
	}
	
	//입금가격 + 카드수수료 + 수수료 + 포인트 가격
	function cal_sale_amount($amt){
		
		global $default;
		
		$comm = $amt * ($default[de_commision]/100);
		$comm_card = $amt * ($default[de_commision_card]/100);
		$comm_point = $amt * ($default[de_commision_point]/100);
		
		$r = $amt + $comm + $comm_card + $comm_point;
		
		$r = $this->cal_round($r, 100);
		return $r;
	}
	
	//가격에 따른 포인트 계산
	function cal_sale_point($amt){
		
		global $default;
		
		$comm_point = $amt * ($default[de_commision_point]/100);
		$r = $this->cal_round($comm_point, 10);
		
		return $r;
	}
	
	
	//가격변동체크
	function check_item_price_change($it_id, $params){
		
		 $oit = $this->get_item($it_id);
		 $cit = $params;
		 
		 
	}

	
	//상품 판매가
	function get_sale_amount($it_id){
		
		$it = $this->get_item($it_id);
		return $this->cal_sale_amount($it[it_amount]);
	}
	
	// 상품 관련 끝
	//##############################################################################
	
	
	
	
	
	
	
	//##############################################################################
	// 카테고리관련
	
	//네비문자 출력
	function get_navi($ca_id){
		
		$ca_id1 = substr($ca_id, 0,2);
		if(strlen($ca_id) >= 4) $ca_id2 = substr($ca_id, 0,4); else $ca_id2 = "";
		if(strlen($ca_id) == 6) $ca_id3 = substr($ca_id, 0,6); else $ca_id3 = "";
		
		if($ca_id1) $ca1_info = $this->get_category($ca_id1);
		if($ca_id2) $ca2_info = $this->get_category($ca_id2);
		if($ca_id3) $ca3_info = $this->get_category($ca_id3);
		
		if($ca_id2) {
			$result = "홈 > {$ca1_info[ca_name]}";
			
			if($ca_id3){
				$result .= " > {$ca2_info[ca_name]} > <span style='color:#161616;'>{$ca3_info[ca_name]}</span>";
				
			} else {
				$result .= " > <span style='color:#161616;'>{$ca2_info[ca_name]}</span>";
			}
		}
		else {
			$result = "홈 > <span style='color:#161616;'>{$ca1_info[ca_name]}</span>";
		}
		
		
		return $result;//"홈 > 정성들인 농산물 전문점 > <span style='color:#161616;'>한라산 표고버섯/고사리</span>";
	}
	
	function get_category($ca_id){
		
		$result = $this->dao->doSelect("Yc4.get_category", array("ca_id"=>$ca_id));
		return $result[0];
	}
	
	//카테고리 Depth1 리스트
	function get_category_d1(){
		
		$result = $this->dao->doSelect("Yc4.get_category_d1", null);
		return $result;
	}
	
	//카테고리 Depth2 리스트
	function get_category_d2($ca_id){
	
		$result = $this->dao->doSelect("Yc4.get_category_d2", array("ca_id"=>$ca_id));
		return $result;
	}
	
	//카테고리 Depth3 리스트
	function get_category_d3($ca_id){
	
		$result = $this->dao->doSelect("Yc4.get_category_d3", array("ca_id"=>$ca_id));
		return $result;
	}
	
	//카테고리 d1 <option> 들
	function get_category_d1_option(){
		
		$d1list = $this->get_category_d1();
		$result = "";
		foreach($d1list as $row){
			$result .= "<option value='{$row[ca_id]}'>{$row[ca_name]}</option>\r\n";	
		}
		return $result;

	}
	
	//관련카테고리 검색 쿼리 생성
	static function make_category_query($rel_cat){
			
			$cats = explode(",", $rel_cat);
		
			$result = "(";
			$idx = 0;	
			foreach($cats as $cat){
					$idx++;
					if($idx > 1) $result .=" OR ";
					$result .= " ca_id like '{$cat}%'  ";
			}
			$result .=")";
			
			return $result;
			
	}
	
	// 카테고리관련 끝
	//##############################################################################
	
	
	
	
	
	
	
	
	
	//##############################################################################
	// 배송관련
	
	function get_dl_list(){
		
		$result = $this->dao->doSelect("Yc4.get_dl_list", null);
		return $result;
	}
	
	
	//배송회사 옵션 리스트
	function get_dl_option($slt){

		$dl = $this->get_dl_list();
		$result = "<option value=''>선택해주세요</option>";
		foreach($dl as $row){
			
			$selected = $row[dl_id] == $slt ? "selected" : "";
			
			$result .= "<option value='{$row[dl_id]}' {$selected} >{$row[dl_company]}</option>\r\n";	
		}
		return $result;
	} 
	
	// 배송관련 끝
	//##############################################################################
	
	
	
	
	
	//##############################################################################
	// 장바구니 관련
	
	//장바구니 목록
	function list_cart($on_uid){
		$result = $this->dao->doSelect("Yc4.list_cart", array("on_uid"=>$on_uid));
		return $result;
	}

	//장바구니 상품 하나 가져오기
	function get_cart($ct_id) {
		$result = $this->dao->doSelect("Yc4.get_cart", array("ct_id"=>$ct_id));
		return $result[0];
	}

	//장바구니 필드수정
	function update_cart_field($ct_id, $field, $value){
		
		$this->dao->doUpdate("Yc4.update_cart_field", array(
				"field" => $field,
				"value" => $value, 
				"ct_id" => $ct_id
		));
	}
	
	//장바구니 추가
	function insert_cart($params){
		
		if(!$params["on_uid"]) {
			$new_on_uid = get_unique_id();
			$params["on_uid"] = $new_on_uid;
		}
		
		$params["ct_ip"] = $_SERVER["REMOTE_ADDR"];
			
		$this->dao->doInsert("Yc4.insert_cart", $params);
		
		return $params;
	}
	
	//장바구니삭제
	function delete_cart($on_uid){
	
		$this->dao->doDelete("Yc4.delete_cart", array("on_uid"=>$on_uid));
	}
	
	// 장바구니관련 끝
	//##############################################################################
	
	
	
	
	

	
	
	
	//##############################################################################
	// 포인트 관련
	
	//포인트 소멸 7일전 알람
	function point_expriation_alert($mb_id, $cday){
		
		$exp_point = $this->get_exp_point_alert($mb_id, $cday);
		$use_point = $this->get_use_point_alert($mb_id, $cday);
		
		$epoint = $exp_point - $use_point;
		
		if($epoint < 0) {
			//소멸될 포인트 없음
			$r = 0;
		} else {
				
			$r = $epoint;
		}
	
		return $r;
			
	}
	
	//포인트 소멸 당일조회용
	function point_expriation_today_alert($mb_id){
	
		$exp_point = $this->get_exp_point_today_alert($mb_id);
		$use_point = $this->get_use_point_today_alert($mb_id);
		
		$epoint = $exp_point - $use_point;
		
		if($epoint < 0) {
			//소멸될 포인트 없음
			$r = 0;
		} else {
	
			$r = $epoint;
		}
	
		return $r;
			
	}
	
	
	//포인트 소멸
	function point_expiration($mb_id){
		
		$exp_point = $this->get_exp_point($mb_id);
		$use_point = $this->get_use_point($mb_id);
		
		
		$epoint = $exp_point - $use_point;
		
		/*
		echo $exp_point;
		echo "<br/>";
		echo $use_point;
		echo "<br/>";
		echo $epoint;
		echo "<br/>";
		exit;
		*/
		
		
		if($epoint < 0) {
			//소멸될 포인트 없음
			$r = 0;
		} else {
			
			// 포인트 소멸
			insert_point($mb_id, ($epoint * -1), "포인트 소멸", "@expiration", $mb_id, $g4['time_ymd']);
			
			$r = $epoint;
		}
		
		$this->set_exp_point($mb_id); //소멸처리된 포인트 DB기록
		
		
		
		return $r;
		
	}
	
	//회원의 소멸될 포인트 조회
	function get_exp_point($mb_id){
		
		global $default;
		
		$params = array();
		$params["mb_id"] = $mb_id;
		$params["point_limit"] = $default["de_point_limit"];
		$params["point_limit_type"] = $default["de_point_limit_type"];
		
		$result = $this->dao->doSelect("Yc4.get_exp_point", $params);
		
		return $result[0]["exp_point"];
		
	}
	
	
	//소멸일 후에 사용된 포인트 총 합
	function get_use_point($mb_id){
		
		global $default;
		
		$params = array();
		$params["mb_id"] = $mb_id;
		$params["point_limit"] = $default["de_point_limit"];
		$params["point_limit_type"] = $default["de_point_limit_type"];
		
		//$this->dao->setDebug(true);
		$result = $this->dao->doSelect("Yc4.get_use_point", $params);
		//$this->dao->setDebug(false);
		
		return $result[0]["use_point"];
	}
	
	//소멸된 포인트 기록
	function set_exp_point($mb_id){
		
		global $default;
		
		$params = array();
		$params["mb_id"] = $mb_id;
		$params["point_limit"] = $default["de_point_limit"];
		$params["point_limit_type"] = $default["de_point_limit_type"];
		
		$result = $this->dao->doUpdate("Yc4.set_exp_point", $params);
	}
	
	
	
	//회원의 소멸될 포인트 조회(7일전조회)
	function get_exp_point_alert($mb_id, $cday){
	
		global $default;
	
		$params = array();
		$params["mb_id"] = $mb_id;
		$params["cday"] = $cday;
		$params["point_limit"] = $default["de_point_limit"];
		$params["point_limit_type"] = $default["de_point_limit_type"];
	
		$result = $this->dao->doSelect("Yc4.get_exp_point_alert", $params);
	
		return $result[0]["exp_point"];
	
	}
	
	
	//소멸일 후에 사용된 포인트 총 합(7일전조회)
	function get_use_point_alert($mb_id, $cday){
	
		global $default;
	
		$params = array();
		$params["mb_id"] = $mb_id;
		$params["cday"] = $cday;
		$params["point_limit"] = $default["de_point_limit"];
		$params["point_limit_type"] = $default["de_point_limit_type"];
	
		//$this->dao->setDebug(true);
		$result = $this->dao->doSelect("Yc4.get_use_point_alert", $params);
		//$this->dao->setDebug(false);
	
		return $result[0]["use_point"];
	}
	
	
	
	
	//회원의 소멸될 포인트 조회(당일조회용)
	function get_exp_point_today_alert($mb_id){
	
		global $default;
	
		$params = array();
		$params["mb_id"] = $mb_id;
		$params["point_limit"] = $default["de_point_limit"];
		$params["point_limit_type"] = $default["de_point_limit_type"];
	
		$result = $this->dao->doSelect("Yc4.get_exp_point_today_alert", $params);
	
		return $result[0]["exp_point"];
	
	}
	
	//소멸일 후에 사용된 포인트 총 합(당일)
	function get_use_point_today_alert($mb_id){
	
		global $default;
	
		$params = array();
		$params["mb_id"] = $mb_id;
		$params["point_limit"] = $default["de_point_limit"];
		$params["point_limit_type"] = $default["de_point_limit_type"];
	
		//$this->dao->setDebug(true);
		$result = $this->dao->doSelect("Yc4.get_use_point_today_alert", $params);
		//$this->dao->setDebug(false);
	
		return $result[0]["use_point"];
	}
	
	
	
	
	
	// 포인트 관련 끝
	//##############################################################################
	
	
	
	
	
	
	
	
}


