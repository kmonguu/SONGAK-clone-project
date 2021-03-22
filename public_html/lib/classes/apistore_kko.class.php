<?
class APIStoreKKO {
	
	private $id = "";
	private $key = "";
	private $com_id = "";
	
	private $api_base_url = "http://api.apistore.co.kr/kko/1";
	private $api_base_url2 = "http://api.apistore.co.kr/kko/2";
	
	private $resultObj = null;
	
	function __construct($id, $key, $com_id="") {
		
		global $ss_com_id;
		
		$this->id = $id;
		$this->key = $key;
		$this->com_id = $com_id != "" ? $com_id : $ss_com_id;
			
		$this->resultObj = new APIStoreKKOResult();
	}
	
	
	//CHECK ID/KEY
	function check_id(){
	
		$apiurl = "{$this->api_base_url}/sendnumber/list/{$this->id}?sendernumber={$number}";
	
		$result = $this->send_get_api($apiurl);
		
		if(gettype($result->result_code) != "NULL"){
			return "OK";				
		} else {
			return $result->description;
		}	
	}
	
	
	
	//발신자번호 등록
	function regist_sender_number($number, $comment="", $pincode=""){
		
		$apiurl = "{$this->api_base_url2}/sendnumber/save/{$this->id}";
		
		$params = array();
		$params["sendnumber"] = str_replace("-", "", $number);
		$params["comment"] = $comment;
		
		
		if(substr($number, 0, strlen("010")) === "010") {
			$params["pintype"] = "SMS";
		} else {
			$params["pintype"] = "VMS";			
		}
		
		
		if($pincode != "") {
			$params["pincode"] = $pincode;
		}
		
		$result = $this->send_post_api($apiurl, $params);
		
		if(gettype($result->result_code) != "NULL"){
			
			if($result->result_code == "200"){
				return "OK";
			}
			else {
				
				$msg = "";
				/*
				switch($result->result_code){
					case "500" :
						$msg = " : 중복등록 ";
						break;
					default :
						$msg = "";
				}
				*/
				
				
				return $result->result_code.$msg;
			}
			
		}
		
		return $result->description;			
	}
	
	
	//발신자번호 목록
	function list_sender_number($number=""){
	
		$apiurl = "{$this->api_base_url}/sendnumber/list/{$this->id}?sendernumber={$number}";
	
		$result = $this->send_get_api($apiurl);
		
		if($result->result_code == "200"){
			
			return $result->numberList;
			
		}
		
		return null;
	}



	//템플릿 목록
	function list_template($status="", $code=""){
		
		$sch = "";		
		if($status != ""){
			if($sch == "") $sch .= "?"; else $sch .= "&";
			$sch .= "status={$status}";
		}
		if($code != ""){
			if($sch == "") $sch .= "?"; else $sch .= "&";
			$sch .= "template_code={$code}";
		}

		$apiurl = "{$this->api_base_url}/template/list/{$this->id}{$sch}";
		$result = $this->send_get_api($apiurl);
		
		$r = array();

		for($idx = 0 ; $idx < count($result->templateList); $idx++){
			
			$template = $result->templateList[$idx];

			$row = array();
			$row["template_code"] = $template->template_code;
			$row["template_name"] = $template->template_name;
			$row["template_msg"] = $template->template_msg;
			$row["status"] = $template->status;

			$row["btnList"] = array();
			for($bidx = 0 ; $bidx < count($template->btnList); $bidx++){
				
				$tbtn = $template->btnList[$bidx];
				
				$btn = array();

				$btn["btn_type"] = $tbtn->template_btn_type;
				$btn["btn_name"] = $tbtn->template_btn_name;
				$btn["btn_url1"] = $tbtn->template_btn_url;
				$btn["btn_url2"] = $tbtn->template_btn_url2;

				$row["btnList"][] = $btn;
			}

			$r[] = $row;
		}
		//return;

		return $r;
	}

	
	
	
	public static $SEND_RESULT_CODE = array(
		"100" => "User Error"
		, "200" => "OK"
		, "300" => "Parameter Error"
		, "400" => "Etc Error"
		, "500" => "발신자번호 사전 등록제에 의한 미등록 차단"
		, "600" => "충전요금 부족"
		, "700" => "템플릿코드 사전 승인제에 의한 미승인 차단"
 	);
	




	//KKO전송
	function send($snum, $rnum, $msg, $fail_msg, $temp_code, $btns="", $sname="", $usefailback="", $mb_id="", $is_test = false ){
		
		$apiurl = "{$this->api_base_url}/msg/{$this->id}";
		
		
		$snum = str_replace("-", "", $snum);
		$snum = str_replace(" ", "", $snum);
		$rnum = str_replace("-", "", $rnum);
		$rnum = str_replace(" ", "", $rnum);

		
		$params = array();
		$params["PHONE"] = $rnum;
		$params["CALLBACK"] = $snum;
		$params["MSG"] = $msg;
		$params["TEMPLATE_CODE"] = $temp_code;

		/*
		if($linkurl != "") $params["URL"] = $linkurl;
		if($btntxt != "") $params["URL_BUTTON_TXT"] = $btntxt;
		*/
		$params["BTN_TYPES"] = $btns["types"];
		$params["BTN_TXTS"] = $btns["txts"];
		$params["BTN_URLS1"] = $btns["urls1"];
		$params["BTN_URLS2"] = $btns["urls2"];


		if($usefailback == "Y"){ //failback
			$params["FAILED_TYPE"] = "LMS";
			$params["FAILED_SUBJECT"] = $sname;
			$params["FAILED_MSG"] = $msg;
		} else {
			$params["FAILED_TYPE"] = "N";
		}
		


		
		$result = $this->send_post_api($apiurl, $params, $is_test);
		
		
		if($is_test){ exit; }

		return $this->send_result($snum, $rnum, $msg, $result, $mb_id);
	}




	function send_result($snum, $rnum, $msg, $result, $mb_id, $msglist=array()){

			$returnValue = "";
	
			if(gettype($result->result_code) != "NULL"){
					
				if($result->result_code == "200"){
					$returnValue = "OK";
				}
				else {
					$err_msg = " : ".APIStoreKKO::$SEND_RESULT_CODE[$result->result_code];
					$returnValue = $result->result_code.$err_msg;
				}
				
				
				//전송기록 저장
				$this->save_report($snum, $rnum, $msg, $result, $mb_id, $msglist);
					
			} else {
				
				$returnValue = $result->description;
			}
			
			return $returnValue;
	}

	
	
	
	
	function get_report($cmid){
		
		//전송결과코드
		$apiurl = "{$this->api_base_url}/report/{$this->id}?cmid={$cmid}";
		$report = $this->send_get_api($apiurl);
		
		return $report;
		
	}
	
	
	
	//전송 REPORT 저장
	function save_report($snum, $rnum, $msg, $result, $mb_id="", $msglist=array()){
		
	
		$status = "";
		$status = $result->result_code;
		
		if($result->result_code == "200") {
			$is_fail = "0";
		} else {
			$is_fail = "1";
		}


		$confObj = new APIStoreKKOConfig();
		$conf = $confObj->get();
		$msg_status = "";
		if(!$conf["use_failback"]){$msg_status = "X";}



		$cmid_array = explode(",", $result->cmid);
		$rnum_array = explode(",", $rnum);
		$mbid_array = explode(",", $mb_id);
		
		if(count($cmid_array) == 0) {

			$params = array();
			$params["com_id"] = $this->com_id;
			$params["send_number"] = $snum;
			$params["dest_number"] = $rnum;
			$params["msg_content"] = $msg;
			$params["is_fail"] = $is_fail;
			$params["api_status"] = $status;
			$params["kko_status"] = "";
			$params["msg_status"] = $msg_status;
			$params["cmid"] = $result->cmid;
			$params["mb_id"] = $mb_id;
			//$params["umid"] = $report->umid;
			
			$this->resultObj->insert($params);

		} else {

			$idx = 0;
			foreach($cmid_array as $cmid){
				
				if(count($msglist) > 0){
					$msg = $msglist[$idx];
				}
				$rn = $rnum_array[$idx];
				$mbid = $mbid_array[$idx];

				$params = array();
				$params["com_id"] = $this->com_id;
				$params["send_number"] = $snum;
				$params["dest_number"] = $rn;
				$params["msg_content"] = $msg;
				$params["is_fail"] = $is_fail;
				$params["api_status"] = $status;
				$params["kko_status"] = "";
				$params["msg_status"] = $msg_status;
				$params["cmid"] = $cmid;
				$params["mb_id"] = $mbid;
				
				$this->resultObj->insert($params);
				
				$idx++;
			}

		}
		
	}
	
	
	
	function send_get_api($url){
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"x-waple-authorization:{$this->key}"
		));
		
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_URL,"{$url}");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		

		$result = json_decode($result);
		
		return $result;
	
	}
	
	
	
	function send_post_api($url, $params, $is_test = false){
	
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"x-waple-authorization:{$this->key}"
		));
		
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_URL,"{$url}");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		
		if($is_test) {
			echo "<br/>========================== send_post_api($url, $params, $is_test) =======================================<br/>";
			echo $result;
			echo "<br/>===============================================================================================<br/>";
			exit;
		}
	
		$result = json_decode($result);
	
		return $result;
	
	}
	
	static function mphon($num){
		return preg_replace("/(^02.{0}|^01.{1}|[0-9]{3})([0-9]+)([0-9]{4})/", "$1-$2-$3", $num);
	}
	

	static function send_sms($msg_no, $rnum, $od_id="", $mb_id="", $send_number="", $md_no=""){
			
		global $member;


		$msgObj = new APIStoreKKOMessage();
		$confObj = new APIStoreKKOConfig();


		$conf = $confObj->get();
		$msgInfo = $msgObj->get($msg_no);
			

		$apiObj = new APIStoreKKO($conf["api_id"], $conf["api_key"]);

		$resultMessage = "";

		if($apiObj->check_id() != "OK"){
			
			$resultMessage = "API 연결오류";
			
		} else {

			$msg = $msgInfo["msg_content"];
			$template = $msgInfo["msg_kko_template"];

			$snum = $send_number != "" ? $send_number : $conf["sender_number"];
			$rnum = $rnum;

			$sname = $conf["sender_name"];
			
			if(trim($msg) == ""){
					$resultMessage = "빈 메시지를 전송할 수 없습니다.";
					
			} else if($rnum == ""){
				
					$resultMessage = "전화번호가 입력되지 않았습니다.";
					
			//} else if(substr($rnum, 0, 3) != "010"){
					
					//$resultMessage = "수신자번호가 010으로 시작하지 않습니다.";
			}
			else 
			{
					
					if($od_id != "") {
						$msg = $msgObj->make_resv_message($msg, $od_id, $md_no);
					}

					if($mb_id != ""){
						$msg = $msgObj->make_member_message($msg, $mb_id);
					}
					
					$fail_msg = $msg;
					

					$btns = $msgObj->get_btns($msgInfo);

					$resultMessage = $apiObj->send($snum, $rnum, $msg, $fail_msg, $template, $btns, $sname, $conf["use_failback"], $member["mb_id"]);
					if($resultMessage == "OK") $resultMessage = "성공";
			}
			
		}


		$r = array();
		$r["message"] = $resultMessage;
		$r["echo"] = $_POST["echo"];



		//REPORT결과 업데이트
		$sch_sdate = date("Y-m-d");
		$sch_edate = date("Y-m-d");
		$resultObj = new APIStoreKKOResult();
		$need_report_list = $resultObj->get_all_list("", "", "", "", " AND (api_status='200' AND (kko_status='' AND (msg_status='' OR msg_status='X')))  AND reg_date BETWEEN '{$sch_sdate} 00:00:00' AND '{$sch_edate} 24:00:00' ");
		if(count($need_report_list) > 0){
			foreach($need_report_list as $nr){
				$report = $apiObj->get_report($nr["cmid"]);
				if($report->status == 3 || $report->status == 4){
					$resultObj->update_api_report($nr["cmid"], $report->RSLT, $report->msg_rslt);
				}
			}
		}
	

		return json_encode($r);


	}



	//회원 가입시 전송
	static function SEND_JOIN($mb_id, $mb_hp){
		
		$msgObj = new APIStoreKKOMessage();
		$confObj = new APIStoreKKOConfig();
		$conf = $confObj->get();	
		$listR = $msgObj->get_list(1, "msg_send_type", "join", "", "", PHP_INT_MAX, "", "");
		$list = $listR["list"];


		//회원가입시 회원에게 전송
		foreach($list as $row) {
			APIStoreKKO::send_sms($row["no"], $mb_hp, "", $mb_id);
		}
	}


	//주문관련 전송
	static function SEND_ORDER($type, $od_id, $od_hp, $md_no=""){
		
		$msgObj = new APIStoreKKOMessage();
		$confObj = new APIStoreKKOConfig();
		$conf = $confObj->get();	
		$listR = $msgObj->get_list(1, "msg_send_type", $type, "", "", PHP_INT_MAX, "", "");
		$list = $listR["list"];
	

		//주문접수 시 회원에게 전송
		foreach($list as $row) {
			APIStoreKKO::send_sms($row["no"], $od_hp, $od_id, "", "", $md_no);
		}
	}

	
	
}