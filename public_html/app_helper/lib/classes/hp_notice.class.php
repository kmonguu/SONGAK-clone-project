<?
class HpNotice {
    
    protected $dao = null;

	function __construct(){
        global $helper_dao;
		$this->dao = $helper_dao;
	}
	



	function get_notice_list($page, $rows, $is_moreview=true){

		$url = "http://it9.co.kr/api/helper/get_notice.php";
		$params["page"] = $page;
		$params["rows"] = $rows;
		$params["is_moreview"] = $is_moreview ? "" : "N";
		$result = $this->send_post_api($url, $params, false);

		return $result;
	}

	function get_notice_view($wr_id){

		$url = "http://it9.co.kr/api/helper/get_notice.php";
		$params["page"] = 1;
		$params["rows"] = 1;
		$params["is_moreview"] = "";
		$params["wr_id"] = $wr_id;
		
		$result = $this->send_post_api($url, $params, false);

		return $result;
	}

	

	
	
	function send_post_api($url, $params, $is_test = false){
	
		$ch = curl_init();
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
	
		$result = json_decode($result, true);
	
		return $result;
	
	}
	
}


