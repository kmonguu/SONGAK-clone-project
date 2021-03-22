<?
class HpPush {
    
    protected $dao = null;

	function __construct(){
        global $helper_dao;
		$this->dao = $helper_dao;
	}
	


    
	function send_itnine_pushids($fcmID, $flatform="ANDROID"){
        
        global $sitekey;
        
        $ch = curl_init();
        
        $url = "http://it9.co.kr/api/helper/pushid.php";

        $params["pushid"] = $fcmID;
        $params["sitekey"] = $sitekey;
        $params["domain"] = $_SERVER["HTTP_HOST"];
		$params["flatform"] = $flatform;
				
        curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_URL,"{$url}");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		
		return $result;
	
    }


    function send_itnine_sites(){

        global $sitekey;

        $ch = curl_init();
        
        $url = "http://it9.co.kr/api/helper/sitekey.php";

        $params["sitekey"] = $sitekey;//md5($_SERVER["DOCUMENT_ROOT"].$_SERVER["REMOTE_ADDR"]);
        $params["domain"] = $_SERVER["HTTP_HOST"];
				
        curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_URL,"{$url}");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
        
		return $result;
    }
	
    
    
    function send_logout($fcmID){
        
        global $sitekey;
        
        $ch = curl_init();
        
        $url = "http://it9.co.kr/api/helper/logout.php";

        $params["pushid"] = $fcmID;
        $params["sitekey"] = $sitekey;
        $params["domain"] = $_SERVER["HTTP_HOST"];
				
        curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_URL,"{$url}");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		
		return $result;
	
    }
	
}


