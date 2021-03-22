<?
class Sms4Message extends Base {
    
	function __construct(){
        parent::__construct();
	}
	

	function get_list($page, $sfl = "", $stx = "", $sst = "", $sod = "", $rows = "", $where_query = "", $order_query = "") {
		
		global $g4;
		
		if (! $rows)
			$rows = Props::get ( "rows" );
		
		$from_record = ($page - 1) * $rows;
		if (! $sst) {
			$sst = "msg_when";
			$sod = "asc";
			$order_query = ", a.no asc";
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
		
		
		$result ["list"] = $this->dao->doSelect ( 'Sms4Message.list', $params );
		
		// 전체 리스트 수
		$params ["is_count"] = "Y";
		$listCnt = $this->dao->doSelect ( "Sms4Message.list", $params );
		$result ["count"] = $listCnt [0] ["cnt"];
		
		return $result;
	}
	
	
	
	function get($no) {
		
		$params = array();
		$params["no"] = $no;
		$result = $this->dao->doSelect ( "Sms4Message.get", $params );
		
		return $result [0];
	}
	
	
	
	function insert($params) {
		
		$params["member_id"] = $this->member_id;
        $params["ip"] = $this->ip;
        
		$this->dao->doInsert ( "Sms4Message.insert", $params );
		$no = mysql_insert_id();

		return $no;
	}
	
	
	function update($params) {
		
		$params["member_id"] = $this->member_id;
        $params["ip"] = $this->ip;
        
		$this->dao->doUpdate("Sms4Message.update", $params);
	}
    

	function update_field($no, $field, $value) {
		
		$params = array ();
		$params ["no"] = $no;
		$params ["field"] = $field;
		$params ["value"] = $value;
		
		$params["member_id"] = $this->member_id;
		$params["ip"] = $this->ip;
		
		$this->dao->doUpdate ( "Sms4Message.update_field", $params );
	}
	
	
	function delete($no) {
		
		$params = array ();
		$params ["no"] = $no;
		$this->dao->doDelete ( "Sms4Message.delete", $params );
		
		
    }
    
    //업체의 메시지
    function get_com_msg($com_no, $msg_when="1") {

        $params = array();
        $params["com_no"] = $com_no;
        $params["msg_when"] = $msg_when;
        $result = $this->dao->doSelect("Sms4Message.get_com_msg", $params);

        return $result;

    }
    
   

	static function SEND_MSG($rcv, $send, $msg, $mb_id="", $mb_name="") {

		if($mb_id != "") {
			$mbObj = new Member();
			$mb = $mbObj->get($mb_id);
			if($mb_name == "") {
				$mb_name = $mb["mb_name"];
			}
		}

		$msg = str_replace("{이름}", $mb_name, $msg);
		$msg = str_replace("{아이디}", $mb["mb_id"], $msg);
		$msg = str_replace("{이메일}", $mb["mb_email"], $msg);

		return Sms4Message::SEND_SMS($rcv, $send, $msg, $mb_id, $mb_name);

	}

	//수신번호, 회신번호(발신자번호), 메시지, 회원ID, 발신자명
	static function SEND_SMS($rcv, $send, $msg, $mb_id="", $mb_name=""){
		
		global $g4;


		if($mb_id != "") {
			$mbObj = new Member();
			$mb = $mbObj->get($mb_id);
			$mb_name = $mb["mb_name"];
		}

		//수신번호
		$rcv = get_hp($rcv, 0);

		//회신번호
		$wr_reply = $send;
		$reply = str_replace('-', '', trim($wr_reply));
		
		if($rcv == "") return "수신번호를 확인해주세요.";
		if($reply == "") return "";
	
		//전송메시지
		$wr_message = $msg;

		$list = array();
		array_push($list, array('bk_hp' => $rcv, 'bk_name' => $mb_name, 'mb_id' => $mb_id));


		$send_result = "";
		$sms4 = sql_fetch("select * from $g4[sms4_config_table] ");

		$SMS = new SMS4;
		$SMS->SMS_con($sms4[cf_ip], $sms4[cf_id], $sms4[cf_pw], $sms4[cf_port]);



		$result = $SMS->Add($list, $reply, '', '', $wr_message, $booking, 1);

		if ($result) 
		{
			$result = $SMS->Send();

			if ($result) //SMS 서버에 접속했습니다.
			{
				$row = sql_fetch("select max(wr_no) as wr_no from $g4[sms4_write_table]");
				if ($row)
					$wr_no = $row[wr_no] + 1;
				else
					$wr_no = 1;
				

				$wr_message_db = str_replace("'", "''", $wr_message);
				sql_query("insert into $g4[sms4_write_table] set wr_no='$wr_no', wr_renum=0, wr_reply='$wr_reply', wr_message='$wr_message_db', wr_booking='$wr_booking', wr_total='$wr_total', wr_datetime='$g4[time_ymdhis]'");

				$wr_success = 0;
				$wr_failure = 0;
				$count      = 0;


			
				foreach ($SMS->Result as $result) 
				{
					list($phone, $code) = explode(":", $result);

					if (substr($code,0,5) == "Error")
					{
						$hs_code = substr($code,6,2);

						switch ($hs_code) {
							case '02':	 // "02:형식오류"
								$hs_memo = "형식이 잘못되어 전송이 실패하였습니다.";
								$send_result .= $hs_memo;
								break;
							case '23':	 // "23:인증실패,데이터오류,전송날짜오류"
								$hs_memo = "데이터를 다시 확인해 주시기바랍니다.";
								$send_result .= $hs_memo;
								break;
							case '97':	 // "97:잔여코인부족"
								$hs_memo = "충전 잔액이 부족합니다.";
								$send_result .= $hs_memo;
								break;
							case '98':	 // "98:사용기간만료"
								$hs_memo = "사용기간이 만료되었습니다.";
								$send_result .= $hs_memo;
								break;
							case '99':	 // "99:인증실패"
								$hs_memo = "인증 받지 못하였습니다. 계정을 다시 확인해 주세요.";
								$send_result .= $hs_memo;
								break;
							default:	 // "미 확인 오류"
								$hs_memo = "[{$hs_code}]알 수 없는 오류로 전송이 실패하었습니다.";
								$send_result .= $hs_memo;
								break;
						}
						$wr_failure++;
						$hs_flag = 0;
					} 
					else
					{
						$hs_code = $code;
						$hs_memo = get_hp($phone, 1)."로 전송했습니다.";
						$wr_success++;
						$hs_flag = 1;
						$send_result .= $hs_memo;
					}

					$row = array_shift($list);
					$row[bk_hp] = get_hp($row[bk_hp], 1);

					$log = array_shift($SMS->Log);
					sql_query("insert into $g4[sms4_history_table] set wr_no='$wr_no', wr_renum=0, bg_no='$row[bg_no]', mb_id='$row[mb_id]', bk_no='$row[bk_no]', hs_name='$row[bk_name]', hs_hp='$row[bk_hp]', hs_datetime='$g4[time_ymdhis]', hs_flag='$hs_flag', hs_code='$hs_code', hs_memo='$hs_memo', hs_log='$log'");
				}
				$SMS->Init(); // 보관하고 있던 결과값을 지웁니다.

				sql_query("update $g4[sms4_write_table] set wr_success='$wr_success', wr_failure='$wr_failure' where wr_no='$wr_no' and wr_renum=0");
			}
			else {
				return "에러: SMS 서버와 통신이 불안정합니다.";
			}
		}
		else {
			return "에러: SMS 데이터 입력도중 에러가 발생하였습니다.";
		}

		if($send_result == "") $send_result = "OK";
		return $send_result;

	}
	



	
}


