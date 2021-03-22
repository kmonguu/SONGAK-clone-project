<?
class APIStoreKKOMessage {
	
	protected $dao = null;

	public $member_id = "";
	public $ip = ""; 
	
	public $com_id = "";

	private $boObj = null;
	private $resvObj = null;


	public static $SEND_TYPE_SHOP = array(
		"delivery" => "상품배송시"
		,"deposit" => "입금확인시"
		,"order" => "주문접수시"
		,"join" => "회원가입시"
	);
	public static $SEND_TYPE = array(
		"join" => "회원가입시"
	);

	function __construct($com_id = "") {
		
		global $dao, $member;
		
		$this->dao = $dao;

		$this->member_id = $member["mb_id"];
		$this->ip = $_SERVER["REMOTE_ADDR"];

		if($com_id != ""){
			$this->com_id = $com_id;
		}

	}

	function get_list($page, $sfl = "", $stx = "", $sst = "", $sod = "", $rows = "", $where_query = "", $order_query = "") {
		
		global $g4;
	
		
		if (! $rows)
			$rows = Props::get ( "rows" );
		
		$from_record = ($page - 1) * $rows;
		if (! $sst) {
			$sst = "no";
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
		
		$result ["list"] = $this->dao->doSelect ( 'APIStoreKKOMessage.list', $params );
		
		// 전체 리스트 수
		$params ["is_count"] = "Y";
		$listCnt = $this->dao->doSelect ( "APIStoreKKOMessage.list", $params );
		$result ["count"] = $listCnt [0] ["cnt"];
		
		return $result;
	}
	
	//전체리스트
	function get_all_list($sfl = "", $stx = "", $sst = "", $sod = "", $where_query = "", $order_query = ""){
		$listResult = $this->get_list(1, $sfl, $stx, $sst, $sod, PHP_INT_MAX, $where_query, $order_query);
		$list = $listResult["list"];
		return $list;
	}
	
	
	
	
	function get($no) {
		
		$params = array();
		$params["no"] = $no;
		$result = $this->dao->doSelect ( "APIStoreKKOMessage.get", $params );
		
		return $result [0];
	}
	
	
	
	//예약관련 메시지 생성
	function make_resv_message($msg, $od_id, $md_no=""){
		
		global $g4;
	
		$yc4 = new Yc4();
		$mdObj = new Yc4MultiDelivery();

		//주문정보
		$od = $yc4->get_order($od_id);

		//택배사
		$dl = sql_fetch(" SELECT * FROM yc4_delivery WHERE dl_id = '{$od["dl_id"]}' ");

		//배송일시
		$od_invoice_time = $od["od_invoice_time"] == "" || $od["od_invoice_time"] == "0000-00-00 00:00:00" ? date("Y-m-d H:i:s") : $od["od_invoice_time"];
		

		//장바구니정보
		$cart = $yc4->list_cart($od["on_uid"]);
		$item_name = "";
		$it = $yc4->get_item($cart[0]["it_id"]);
		if(count($cart) == 1){
			$item_name = $it["it_name"];
		} else {
			$item_name = $it["it_name"]."외 ".(count($cart)-1)."건";
		}
		
		$od_deposit_time = ($od["od_bank_time"] && $od["od_bank_time"] != "0000-00-00 00:00:00") ? $od["od_bank_time"] : $od["od_card_time"];
		

		//포인트|쿠폰금액은 temp_{bank|card}에서 빠져있음 => 전송되는 금액은 결제할 금액이므로 쿠폰/포인트 결제액은 빼서 보냄
		$amt = $od["od_temp_bank"] + $od["od_temp_card"] + $od["od_send_cost"];


		if($md_no == "") {

			//단일배송지
			$msg = str_replace("#{고객이름}", $od["od_name"], $msg);
			$msg = str_replace("#{고객 이름}", $od["od_name"], $msg);

			$msg = str_replace("#{주문일시}", $od["od_time"], $msg);
			$msg = str_replace("#{주문 일시}", $od["od_time"], $msg);

			$msg = str_replace("#{주문번호}", $od["od_id"], $msg);
			$msg = str_replace("#{주문 번호}", $od["od_id"], $msg);

			$msg = str_replace("#{입금일시}", $od_deposit_time, $msg);
			$msg = str_replace("#{입금 일시}", $od_deposit_time, $msg);

			$msg = str_replace("#{배송일시}", $od_invoice_time, $msg);
			$msg = str_replace("#{배송 일시}", $od_invoice_time, $msg);

			$msg = str_replace("#{택배사}", $dl["dl_company"], $msg);
			$msg = str_replace("#{택배회사}", $dl["dl_company"], $msg);

			$msg = str_replace("#{운송장번호}", $od["od_invoice"], $msg);
			$msg = str_replace("#{운송장 번호}", $od["od_invoice"], $msg);

			$msg = str_replace("#{금액}", number_format($amt)."원", $msg);
			$msg = str_replace("#{상품명}", $item_name, $msg);
			$msg = str_replace("#{날짜}", date("Y-m-d H:i:s"), $msg);
			$msg = str_replace("#{날자}", date("Y-m-d H:i:s"), $msg);
		}
		else  {

			//다중배송지 처리
			$md = $mdObj->get($md_no);
			$sql = " select dl_company from $g4[yc4_delivery_table] where dl_id = '$md[md_dl_id]' ";
			$dl = sql_fetch($sql);

			//배송일시
			$od_invoice_time = $md["md_invoice_time"] == "" || $od["md_invoice_time"] == "0000-00-00 00:00:00" ? date("Y-m-d H:i:s") : $od["md_invoice_time"];

			$msg = str_replace("#{고객이름}", $md["md_name"], $msg);
			$msg = str_replace("#{고객 이름}", $md["md_name"], $msg);

			$msg = str_replace("#{주문일시}", $od["od_time"], $msg);
			$msg = str_replace("#{주문 일시}", $od["od_time"], $msg);

			$msg = str_replace("#{주문번호}", $od["od_id"], $msg);
			$msg = str_replace("#{주문 번호}", $od["od_id"], $msg);

			$msg = str_replace("#{입금일시}", $od_deposit_time, $msg);
			$msg = str_replace("#{입금 일시}", $od_deposit_time, $msg);

			$msg = str_replace("#{배송일시}", $od_invoice_time, $msg);
			$msg = str_replace("#{배송 일시}", $od_invoice_time, $msg);

			$msg = str_replace("#{택배사}", $dl["dl_company"], $msg);
			$msg = str_replace("#{택배회사}", $dl["dl_company"], $msg);

			$msg = str_replace("#{운송장번호}", $md["md_invoice"], $msg);
			$msg = str_replace("#{운송장 번호}", $md["md_invoice"], $msg);

			$msg = str_replace("#{금액}", number_format($amt)."원", $msg);
			$msg = str_replace("#{상품명}", $item_name, $msg);
			$msg = str_replace("#{날짜}", date("Y-m-d H:i:s"), $msg);
			$msg = str_replace("#{날자}", date("Y-m-d H:i:s"), $msg);

		}	

		$msg = str_replace("&", "＆", $msg);
	
		return $msg;
	}
	





	//회원관련 메시지 생성
	function make_member_message($msg, $mb_id){
		
		$mbObj = new Member();
		$m = $mbObj->get($mb_id);
		$msg = str_replace("#{고객이름}", $m["mb_name"], $msg);
		$msg = str_replace("#{고객 이름}", $m["mb_name"], $msg);
		$msg = str_replace("#{날짜}", date("Y-m-d H:i:s"), $msg);
		$msg = str_replace("#{날자}", date("Y-m-d H:i:s"), $msg);
		$msg = str_replace("&", "＆", $msg);
		return $msg;
	}



	
	function insert($params) {

		if($params["com_id"] == "") { $params["com_id"] = $this->com_id; } 
		
		$params["member_id"] = $this->member_id;
		$params["ip"] = $this->ip;
		
		$this->dao->doInsert ( "APIStoreKKOMessage.insert", $params );
		$no = mysql_insert_id();

		return $no;
	}
	
	
	function update($params) {
		

		if($params["com_id"] == "") { $params["com_id"] = $this->com_id; } 
	
		$params["member_id"] = $this->member_id;
		$params["ip"] = $this->ip;
		
		$this->dao->doUpdate("APIStoreKKOMessage.update", $params);
	}
	
		

	function delete($no) {
	
		$params = array ();
		$params ["no"] = $no;
		$this->dao->doDelete ( "APIStoreKKOMessage.delete", $params );
	}
	
	

	function get_btns($row){
		
		$btnTypes = "";
		$btnTxts = "";
		$btnURLs1 = "";
		$btnURLs2 = "";
	
		for($idx = 1 ; $idx <= 5 ; $idx++){
			
			if($row["msg_kko_btntype_{$idx}"] != "") {

				if($idx > 1) $btnTypes .= ",";
				$btnTypes.= $row["msg_kko_btntype_{$idx}"];
				
				if($idx > 1)  $btnTxts .= ",";
				$btnTxts .= $row["msg_kko_btnname_{$idx}"];

				if($idx > 1)  $btnURLs1 .= ",";
				if($row["msg_kko_btnurl_m_{$idx}"]){
					$btnURLs1 .= $row["msg_kko_btnurl_m_{$idx}"];
				} else {
					$btnURLs1 .= "";
				}

				if($idx > 1)  $btnURLs2 .= ",";
				if($row["msg_kko_btnurl_p_{$idx}"]){
					$btnURLs2 .= $row["msg_kko_btnurl_p_{$idx}"];
				} else {
					$btnURLs2 .= "";
				}
				

			}
		}
		

		$result["types"] = $btnTypes;
		$result["txts"] = $btnTxts;
		$result["urls1"] = $btnURLs1;
		$result["urls2"] = $btnURLs2;

		return $result;
	}


}


