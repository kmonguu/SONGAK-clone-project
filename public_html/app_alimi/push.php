<?
include_once("./_common.php");
 

function sendPush($push_title, $push_msg, $push_mbid="", $bo_table="", $wr_id = "", $push_type = 1){
	
	$headers = array(
	 'Content-Type:application/json',
	 'Authorization:key=AIzaSyBBGMdBLowfQvNCMRn1iidpn9WFAuTLOOE'
	);

	//$push_msg = "내용입니다.";
	//$push_title = "제목입니다.";
	$where = "";
	if($push_mbid != ""){
		$where = " WHERE mb_id='$push_mbid'";
	}
	

	$gcm_mg_cnt_rst = sql_fetch(" SELECT count(*) cnt FROM it9_gcmid $where ");
	$gcm_mg_cnt = $gcm_mg_cnt_rst[cnt];


	if($gcm_mg_cnt > 0){
		
		$arr   = array();
		$arr['data'] = array();
		$arr['data']['message'] = $push_msg;
		$arr['data']['title'] = $push_title;
		
		$arr['data']['bo_table'] = $bo_table;
		$arr['data']['wr_id'] = $wr_id;
		
		$arr['registration_ids'] = array();
		
		$gcmidListRst = sql_query(" SELECT * FROM it9_gcmid $where ");
		for($i = 0 ; $row = sql_fetch_array($gcmidListRst); $i++){
			$arr['registration_ids'][$i] = $row[gcm_id];
		}
		

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,    'https://android.googleapis.com/gcm/send');
		curl_setopt($ch, CURLOPT_HTTPHEADER,  $headers);
		curl_setopt($ch, CURLOPT_POST,    true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arr));
		$response = curl_exec($ch);
		//echo $response;
		curl_close($ch);

		
		$push_title = str_replace("'", "''", $push_title);
		$push_msg = str_replace("'", "''", $push_msg);

		//푸시 전송 기록
		sql_query("
			INSERT 
				it9_gcm_msg
			SET
				mb_id = '$push_mbid',
				msg_title = '$push_title',
				msg_content = '$push_msg',
				msg_type = '$push_type',
				msg_date = now(),
				bo_table = '$bo_table',
				wr_id = '$wr_id'
		");
	}









	//###############################################################################################################################
	//IOS용 FCM 메시지 전송
	//###############################################################################################################################

	//FCM (kgb6615@gmail.com 계정 Alimi프로젝트 서버키)
	$apiKey = "AAAAbv89g0w:APA91bF-7yOltpoKQ3AirT4H-zN8NxxBnlYY-xjE_38QkIELWX6DjZ0JGKiFlpmQa2RV_Ab4dXy0PfH7EW3MhwiXpXzbO-QG1sXfqNTQUrdsW1BsklcwEHwFW8uEciaDqv5bukzo6BB5"; 
	
	$headers = array(
		"Content-Type:application/json",
		"Authorization:key={$apiKey}"
	);

	//전송할 모든 FCMID 갯수
	$cntTmp = sql_fetch(" SELECT count(*) cnt FROM push_fcmid WHERE is_on='1' ");
	$cnt = $cntTmp["cnt"];

	
	//분할전송 갯수
	$div_limit = 500;

	//나눠서 보낼 수
	$divCnt = ceil($cnt / $div_limit);


	for($idx = 0 ; $idx < $divCnt ; $idx++){
	
		
			$start = $idx * $div_limit;
			$from = $div_limit;
				
			//회원의 모든 GCMID
			$send_id_list = array();
			$fcmidListRst = sql_query(" SELECT * FROM push_fcmid WHERE is_on='1' ORDER BY reg_dt ASC LIMIT $start, $from ");
			
			
			for($i = 0 ; $row = sql_fetch_array($fcmidListRst); $i++){
				array_push($send_id_list, $row[fcm_id]);
			}
			

			if(count($send_id_list) > 0){
				

				$arr   = array();
				$arr['data'] = array();
				$arr["notification"] = array();
				
				$arr["priority"] = "high";
				$arr['notification']['body'] = str_replace("<br/>", "\n", $push_msg);
				$arr['notification']['title'] = str_replace("<br/>", "\n", $push_title);
				$arr['notification']['click_action'] = "FCM_PLUGIN_ACTIVITY";
				$arr['notification']['content_available'] = true;
				$arr['notification']['sound'] = "default";
				$arr['notification']['icon'] = "noti_icon";
	
				$arr['data']['body'] = $push_msg;
				$arr['data']['title'] = $push_title;
				if($bo_table!="") {
					$arr['data']['bo_table'] = $bo_table;
					$arr['data']['wr_id'] = $wr_id;
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
	
			}



	}
	//###############################################################################################################################
	//IOS용 FCM 메시지 전송 끝
	//###############################################################################################################################



}
?>