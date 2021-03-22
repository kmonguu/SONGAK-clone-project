<?php
class APIStoreKKOResult {

	public static $KKO_STATUS = array(
			"100" => "User Error"
			, "200" => "OK"
			, "300" => "Parameter Error"
			, "400" => "Etc Error"
			, "500" => "발신자번호 사전 등록제에 의한 미등록 차단"
			, "600" => "충전요금 부족"
			, "700" => "템플릿코드 사전 승인제에 의한 미승인 차단"
			,"0"=> "성공"
			,"1"=> "발신 프로필 키가 유효하지않음"
			,"2"=> "서버와 연결되어있지않은 사용자"
			,"5"=> "메시지 발송 후 수신여부 불투명"
			,"6"=> "메시지 전송결과를 찾을 수 없음"
			,"8"=> "메시지를 전송할 수 없는 상태"
			,"9"=> "최근 카카오톡을 미사용자"
			,"a"=> "건수 부족"
			,"b"=> "전송 권한 없음"
			,"c"=> "중복된 키 접수 차단"
			,"d"=> "중복된 수신번호 접수 차단"
			,"e"=> "서버 내부 에러"
			,"f"=> "메시지 포맷 에러"
			,"k"=> "메시지가존재하지않음"
			,"o"=> "TIME OUT 처리(Agent 내부)"
			,"p"=> "메시지본문 중복 차단(Agent내부)"
			,"t"=> "메시지가비어있음"
			,"A"=> "카카오톡을 미사용자"
			,"B"=> "알림톡 차단을 선택한 사용자"
			,"C"=> "메시지 일련번호 중복"
			,"D"=> "5 초 이내 메시지 중복 발송"
			,"E"=> "미지원 클라이언트 버전"
			,"F"=> "기타 오류"
			,"H"=> "카카오 시스템 오류"
			,"I"=> "전화번호 오류"
			,"J"=> "050 안심번호 발송불가"
			,"L"=> "메시지 길이 제한 오류"
			,"M"=> "템플릿을 찾을 수 없음"
			,"S"=> "발신번호 검증 오류"
			,"U"=> "메시지가 템플릿과 일치하지않음"
			,"V"=> "메시지가 템플릿과 비교 실패"
	);
	
	public static $MSG_STATUS = array(
			"0"=> "성공"
			,"00"=> "-"
			,"1"=> "전송시간 초과"
			,"2"=> "잘못된 전화번호/비가입자"
			,"5"=> "통신사 결과 미수신"
			,"8"=> "단말기 BUSY"
			,"9"=> "음영지역"
			,"a"=> "건수 부족"
			,"b"=> "전송 권한 없음"
			,"c"=> "중복된 키 접수 차단"
			,"d"=> "중복된 수신번호 접수 차단"
			,"e"=> "서버 내부 에러"
			,"o"=> "TIME OUT 처리(Agent 내부)"
			,"p"=> "메시지본문 중복 차단(Agent내부)"
			,"q"=> "메시지 중복키 체크(Agent 내부)"
			,"t"=> "잘못된 동보 전송 수신번호 리스트 카운트(Agent 내부)"
			,"A"=> "단말기 메시지 저장개수 초과"
			,"B"=> "단말기 일시 서비스 정지"
			,"C"=> "기타 단말기 문제"
			,"D"=> "착신 거절"
			,"E"=> "전원 꺼짐"
			,"F"=> " 기타"
			,"G"=> "내부 포맷 에러"
			,"H"=> "통신사 포맷 에러"
			,"I"=> "SMS/MMS 서비스 불가 단말기"
			,"J"=> "착신 측 호 불가 상태"
			,"K"=> "통신사에서 메시지 삭제 처리"
			,"L"=> "통신사 메시지 처리 불가 상태"
			,"M"=> "무선망단 전송 실패"
			,"S"=> "스팸"
			,"V"=> "컨텐츠 사이즈 초과"
			,"U"=> "잘못된 컨텐츠"
			,"X"=> "Failback 사용 안함"
	);
	


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

		$result ["list"] = $this->dao->doSelect ( 'APIStoreKKOResult.list', $params );

		// 전체 리스트 수
		$params ["is_count"] = "Y";
		$listCnt = $this->dao->doSelect ( "APIStoreKKOResult.list", $params );
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
		$result = $this->dao->doSelect ( "APIStoreKKOResult.get", $params );

		return $result [0];
	}
	
	
	function status($sdate, $edate, $com_id=""){
		
		
		if($com_id == "") $com_id = $this->com_id;
	
	
		$params = array();
		$params["com_id"] = $com_id;
		$params["sdate"] = $sdate;
		$params["edate"] = $edate;
		
		$result = $this->dao->doSelect("APIStoreKKOResult.status", $params);
		
		return $result;
	}

	
	function status_month($year, $month){
		
		$sdate = date("Y-m-01", strtotime($year.$month."15"));
		$edate = date("Y-m-t", strtotime($year.$month."15"));
		
		return $this->status($sdate, $month);
	}


	function insert($params) {
		
		if($params["com_id"] == "") { $params["com_id"] = $this->com_id; } 
		$params["member_id"] = $this->member_id;
		$params["ip"] = $this->ip;

		$this->dao->doInsert ( "APIStoreKKOResult.insert", $params );
		$no = mysql_insert_id();

		return $no;
	}
	
	
	function update_api_report($cmid, $kko_status, $msg_status){
		
		$params = array();
		if($kko_status == "rslt is null") return;

		$params["cmid"] = $cmid;
		$params["kko_status"] = $kko_status;


		$confObj = new APIStoreKKOConfig();
		$conf = $confObj->get();
		if($conf["use_failback"]){
			$params["msg_status"] = $msg_status;
		} else {
			$params["msg_status"] = "X";
		}
		
		
		$this->dao->doUpdate("APIStoreKKOResult.update_api_report", $params);
	}

	

}


