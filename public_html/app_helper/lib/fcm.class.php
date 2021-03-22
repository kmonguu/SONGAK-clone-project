<?
class HpFcm {
	
	/**
	FCM google 계정 :: kgb6615@gmail.com 
	FCM Project 명 :: ITNINE-Helper
	*/
	
	//Firebase kgb6615@gmail.com 서버 키
	private $apiKey = "AAAAzGIs8AM:APA91bHCvELPGaRybBhzcWsq9IEXzXo45I4vMC036c-jXBaArwYsnGI_nWu0aXhMOg-t33i6i4JTO12YsizGstMDuQm5jzC4PIfWZh7NCpjAzNBi7LwvZqWcf6vD2TGh1DIaYB7ELDCo"; 
	private $dao = null;
	
	private $isNoPush = false; //테스트용으로 푸시안보내고 개발작업시 사용
	private $isNoLog = false; //테스트용으로 푸시는 보내지만 DB에 저장하지 않을 시 
	
	private $sound = "default";
	private $sound_for_ios = "default";

	function Fcm($isNoPush=false, $isNoLog=false) {
		global $dao;
		$this->dao = $dao;
		$this->isNoPush = $isNoPush;
		$this->isNoLog = $isNoLog;
	}
	
	
	function send($title, $msg, $mbIDlist=array(), $board="", $no="", $type1="", $type2="", $flatform=""){
		

		if($flatform == "" || $flatform == "ANDROID") {
			//ANDROID 폰에 전송
			$this->send_flatform("ANDROID", $title, $msg, $mbIDlist, $board, $no, $type1, $type2);
		}

		if($flatform == "" || $flatform == "IOS") {
			//IOS폰에 전송
			if(count($mbIDlist) == 0) { 

				//모든사용자일때는 전체전송
				$this->send_flatform("IOS", $title, $msg, $mbIDlist, $board, $no, $type1, $type2);

				//모든 iOS 사용자 badge_count 증가
				$this->increase_ios_badge_counter();

			} else {
				//Badge카운트 계산을 위해서 한명씩 따로전송
				foreach($mbIDlist as $mbid){
					$this->send_ios($title, $msg, $mbid, $board, $no, $type1, $type2);
				}
			}
		}


        if($this->isNoLog) {
            return; //로그 안남김
        }
    
        if($type1 == "board") {

            //bo_table <=> wr_id 쌍이 이미 등록되어있으면 기록 저장 안함
            // (app_alimi) 어플과 중복 저장을 피하기 위함
            

			$is_read_query = "";
			$isLog = true;
			if($board == "shop_order") {
				$is_read_query = ", is_read=1";
			} else {
				$isLogTmp = sql_fetch(" SELECT * FROM it9_gcm_msg WHERE bo_table='{$board}' AND wr_id='{$no}' ");
				if($isLog["msg_no"]) $isLog = false;
			}

            if($isLog){
                //푸시 전송 기록
                sql_query("
                INSERT 
                    it9_gcm_msg
                SET
                    mb_id = '',
                    msg_title = '$title',
                    msg_content = '$msg',
                    msg_type = '',
                    msg_date = now(),
                    bo_table = '$board',
                    wr_id = '$no'
					$is_read_query
                ");
            }
            
       }

	}
	


	function send_flatform($flatform, $title, $msg, $mbIDlist=array(), $board="", $no="", $type1="", $type2=""){
	
		global $member;
		
		if($this->isNoPush) { return; }
		

		$title = str_replace("\\\"", "\"", $title);
		$msg = str_replace("\\\"", "\"", $msg);


		$headers = array(
				"Content-Type:application/json",
				"Authorization:key={$this->apiKey}"
		);
	
		//전송할 모든 GCMID 갯수
		$cntTmp = sql_fetch(" SELECT count(*) cnt FROM  helper_push_id WHERE is_on='1' AND device_flatform='{$flatform}' ");
		$cnt = $cntTmp["cnt"];
		
		
		//분할전송 갯수
		$div_limit = 100;
		if($flatform == "IOS") $div_limit = 1000;
	
		//나눠서 보낼 수
		$divCnt = ceil($cnt / $div_limit);
	
	
		for($idx = 0 ; $idx < $divCnt ; $idx++){
	
			$start = $idx * $div_limit;
			$from = $div_limit;
				
			//회원의 모든 GCMID
			$send_id_list = array();
			$fcmidListRst = sql_query(" SELECT * FROM  helper_push_id WHERE is_on='1' AND device_flatform='{$flatform}' ORDER BY reg_dt ASC LIMIT $start, $from ");
			
			
			for($i = 0 ; $row = sql_fetch_array($fcmidListRst); $i++){
				
				if(count($mbIDlist) == 0) {
					
					array_push($send_id_list, $row[fcm_id]);
					
				} else {
					
					if(in_array($row["mb_id"], $mbIDlist)){ //보낼 목록에 있는 회원만 추가
						
						if($row["fcm_id"] != "") {
							array_push($send_id_list, $row[fcm_id]);
						}
						
					}
						
				}
					
			}
			
		

			if(count($send_id_list) > 0){
	
				$arr   = array();
				$arr['data'] = array();
				$arr["priority"] = "high";


				if($flatform == "IOS") { //ANDROID의 경우는 DATA Notification으로 전송 / IOS는 Notification 으로 전송
					$arr["notification"] = array();
					$arr['notification']['body'] = str_replace("<br/>", "\n", $msg);
					$arr['notification']['title'] = str_replace("<br/>", "\n", $title);
					$arr['notification']['click_action'] = "FCM_PLUGIN_ACTIVITY";
					$arr['notification']['sound'] = $this->sound_for_ios;
					$arr['notification']['icon'] = "noti_icon";
				}
				

				$arr['data']['sound'] = $this->sound;
				$arr['data']['click_action'] = "FCM_PLUGIN_ACTIVITY";
				$arr['data']['body'] = str_replace("<br/>", "\n", $msg);
				$arr['data']['title'] = str_replace("<br/>", "\n", $title);
				if($board!="") {
					$arr['data']['board'] = $board;
					$arr['data']['no'] = $no;
					$arr['data']['type1'] = $type1;
					$arr['data']['type2'] = $type2;
				}
	
				$arr['registration_ids'] = $send_id_list;
	
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,    'https://fcm.googleapis.com/fcm/send');
				curl_setopt($ch, CURLOPT_HTTPHEADER,  $headers);
				curl_setopt($ch, CURLOPT_POST,    true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arr));
				$response = curl_exec($ch);
				curl_close($ch);

				//echo $response;
				//exit;
				usleep(100);
				
				
	
			}
	
		}
	
	}



	//IOS BadgeCount계산을 위해서 한명씩 따로보내는 함수
	function send_ios($title, $msg, $id, $board="", $no="", $type1="", $type2="", $idType="mb_id"){
	
		global $member;
		
		if($this->isNoPush) { return; }
		
		$headers = array(
				"Content-Type:application/json",
				"Authorization:key={$this->apiKey}"
		);
	
			
		//회원의 FCMID
		$send_id_list = array();
		if($idType == "mb_id") 
			$fcmidListRst = sql_query(" SELECT * FROM helper_push_id WHERE mb_id='{$id}' AND is_on='1' AND device_flatform='IOS' ");	
		else if($idType == "fcm_id")
			$fcmidListRst = sql_query(" SELECT * FROM helper_push_id WHERE fcm_id='{$id}' AND is_on='1' AND device_flatform='IOS' ");	

		
	
		for($i = 0 ; $row = sql_fetch_array($fcmidListRst); $i++){
			

			$arr   = array();
			$arr['data'] = array();
			$arr["priority"] = "high";

			$arr["notification"] = array();
			$arr['notification']['body'] = str_replace("<br/>", "\n", $msg);
			$arr['notification']['title'] = str_replace("<br/>", "\n", $title);
			$arr['notification']['click_action'] = "FCM_PLUGIN_ACTIVITY";
			$arr['notification']['sound'] = $this->sound_for_ios;
			$arr['notification']['icon'] = "noti_icon";


			//Badge 증가시켜서 보내기
			$badge_cnt = intval($row["apns_badge_cnt"])+1;
			$arr['notification']['badge'] = $badge_cnt;
			sql_query(" UPDATE helper_push_id SET apns_badge_cnt = '{$badge_cnt}' WHERE fcm_id='{$row["fcm_id"]}' ");

			$arr['data']['sound'] = $this->sound_for_ios;
			$arr['data']['click_action'] = "FCM_PLUGIN_ACTIVITY";
			$arr['data']['body'] = str_replace("<br/>", "\n", $msg);
			$arr['data']['title'] = str_replace("<br/>", "\n", $title);
			if($board!="") {
				$arr['data']['board'] = $board;
				$arr['data']['no'] = $no;
				$arr['data']['type1'] = $type1;
				$arr['data']['type2'] = $type2;
			}

			$arr['registration_ids'] = array($row["fcm_id"]);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,    'https://fcm.googleapis.com/fcm/send');
			curl_setopt($ch, CURLOPT_HTTPHEADER,  $headers);
			curl_setopt($ch, CURLOPT_POST,    true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arr));
			$response = curl_exec($ch);
			curl_close($ch);
				
			if($this->isNoLog){
				echo $response."<br/>";
			}
		}
			
	
	}



	//모든 ios 푸시 ON사용자의 badge카운트를 1씩 증가시킴 (전체전송)
	function increase_ios_badge_counter(){
		
		sql_query(" UPDATE helper_push_id SET apns_badge_cnt = apns_badge_cnt+1 WHERE device_flatform='IOS' AND is_on=1 ");
	}



	
	


	function send_FcmID($title, $msg, $fcm_ids=array(), $board="", $no="", $type1="", $type2="", $flatform=""){
		

		if($flatform == "" || $flatform == "ANDROID") {
			//ANDROID 폰에 전송
			$this->send_FcmID_flatform("ANDROID", $title, $msg, $fcm_ids, $board, $no, $type1, $type2);
		}

		if($flatform == "" || $flatform == "IOS") {
			//IOS폰에 전송
			if(count($fcm_ids) == 0) { 

			} else {
				//Badge카운트 계산을 위해서 한명씩 따로전송
				foreach($fcm_ids as $fcmid){
					$this->send_ios($title, $msg, $fcmid, $board, $no, $type1, $type2, "fcm_id");
				}
			}
		}


	}



	function send_FcmID_flatform($flatform, $title, $msg, $fcm_ids=array(), $board="", $no="", $type1="", $type2=""){
	
		global $member;
		
		if($this->isNoPush) { return; }
		
		$title = str_replace("\\\"", "\"", $title);
		$msg = str_replace("\\\"", "\"", $msg);


		$headers = array(
				"Content-Type:application/json",
				"Authorization:key={$this->apiKey}"
		);
	
		//전송할 모든 GCMID 갯수
		$cntTmp = sql_fetch(" SELECT count(*) cnt FROM  helper_push_id WHERE is_on='1' AND device_flatform='{$flatform}' ");
		$cnt = $cntTmp["cnt"];
		
		
		//분할전송 갯수
		$div_limit = 100;
		if($flatform == "IOS") $div_limit = 1000;
	
		//나눠서 보낼 수
		$divCnt = ceil($cnt / $div_limit);
	
	
		for($idx = 0 ; $idx < $divCnt ; $idx++){
	
			$start = $idx * $div_limit;
			$from = $div_limit;
				
			//회원의 모든 GCMID
			$send_id_list = array();
			$fcmidListRst = sql_query(" SELECT * FROM  helper_push_id WHERE is_on='1' AND device_flatform='{$flatform}' ORDER BY reg_dt ASC LIMIT $start, $from ");
			
			
			for($i = 0 ; $row = sql_fetch_array($fcmidListRst); $i++){		
				if(in_array($row["fcm_id"], $fcm_ids)){ //보낼 목록에 있는 회원만 추가

						array_push($send_id_list, $row[fcm_id]);
					
				}
			}
			

			if(count($send_id_list) > 0){
	
				$arr   = array();
				$arr['data'] = array();
				$arr["priority"] = "high";


				if($flatform == "IOS") { //ANDROID의 경우는 DATA Notification으로 전송 / IOS는 Notification 으로 전송
					$arr["notification"] = array();
					$arr['notification']['body'] = str_replace("<br/>", "\n", $msg);
					$arr['notification']['title'] = str_replace("<br/>", "\n", $title);
					$arr['notification']['click_action'] = "FCM_PLUGIN_ACTIVITY";
					$arr['notification']['sound'] = $this->sound_for_ios;
					$arr['notification']['icon'] = "noti_icon";
				}
				

				$arr['data']['sound'] = $this->sound;
				$arr['data']['click_action'] = "FCM_PLUGIN_ACTIVITY";
				$arr['data']['body'] = str_replace("<br/>", "\n", $msg);
				$arr['data']['title'] = str_replace("<br/>", "\n", $title);
				if($board!="") {
					$arr['data']['board'] = $board;
					$arr['data']['no'] = $no;
					$arr['data']['type1'] = $type1;
					$arr['data']['type2'] = $type2;
				}
	
				$arr['registration_ids'] = $send_id_list;
	
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,    'https://fcm.googleapis.com/fcm/send');
				curl_setopt($ch, CURLOPT_HTTPHEADER,  $headers);
				curl_setopt($ch, CURLOPT_POST,    true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arr));
				$response = curl_exec($ch);
				curl_close($ch);

				//echo $response;
				//exit;
				usleep(100);
				
				
			}
	
		}

	}
	

}












