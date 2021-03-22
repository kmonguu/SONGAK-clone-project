<?
class HpModifyReq {
    
    protected $dao = null;

	function __construct(){
        global $helper_dao;
		$this->dao = $helper_dao;
	}
	



	function get_modify_req_list($page, $rows, $is_moreview=true){

		global $sitekey;

		$url = "http://it9.co.kr/api/helper/get_modify_req.php";
		$params["page"] = $page;
		$params["rows"] = $rows;
		$params["sitekey"] = $sitekey;
		$params["is_moreview"] = $is_moreview ? "" : "N";

		$result = $this->send_post_api($url, $params, false);

		return $result;
	}


	
	function get_modify_view($wr_id){

		global $sitekey;

		$url = "http://it9.co.kr/api/helper/get_modify_req.php";
		$params["page"] = 1;
		$params["rows"] = 1;
		$params["is_moreview"] = "";
		$params["sitekey"] = $sitekey;
		$params["wr_id"] = $wr_id;
		
		$result = $this->send_post_api($url, $params, false);

		return $result;
	}



	function get_modify_comment($wr_id){

		global $sitekey;

		$url = "http://it9.co.kr/api/helper/get_modify_req_cmtlist.php";
		$params["sitekey"] = $sitekey;
		$params["wr_id"] = $wr_id;
		
		$result = $this->send_post_api($url, $params, false);

		return $result;

	}




	function insert_modify_comment($wr_id, $wr_name, $wr_content) {


		global $sitekey;

		$url = "http://it9.co.kr/api/helper/insert_modify_req_cmt.php";

		$params["sitekey"] = $sitekey;
		$params["wr_name"] = $wr_name;
		$params["wr_content"] = $wr_content;
		$params["wr_id"] = $wr_id;
		
		$result = $this->send_post_api2($url, $params, false);

		return $result;


	}



	
	function delete_modify_comment($wr_id, $pwr_id) {


		global $sitekey;

		$url = "http://it9.co.kr/api/helper/delete_modify_req_cmt.php";

		$params["sitekey"] = $sitekey;
		$params["wr_id"] = $wr_id;
		$params["pwr_id"] = $pwr_id;
		
		$result = $this->send_post_api2($url, $params, false);

		return $result;


	}




	
	
	function delete_modify_req($wr_id) {


		global $sitekey;

		$url = "http://it9.co.kr/api/helper/delete_modify_req.php";

		$params["sitekey"] = $sitekey;
		$params["wr_id"] = $wr_id;
			
		$result = $this->send_post_api2($url, $params, false);

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

	function send_post_api2($url, $params, $is_test = false){
	
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
	
		return $result;
	
	}
	
}


