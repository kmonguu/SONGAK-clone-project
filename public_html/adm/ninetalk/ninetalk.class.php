<? 

class Ninetalk {
	
	private $site_key = "";
	private $secret = "";
	private $chat_id = "";
	private $chat_name = "";
	
	public $chat_server = "ninetalk.1941.co.kr";
	
	function __construct($is_config=false){

		$sql = " SELECT * FROM ninetalk_site_key LIMIT 0, 1";
		$result = sql_fetch($sql);
		
		$this->site_key = $result["site_key"];
		$this->secret = $result["secret"];
		$this->chat_id = $result["chat_id"];
		$this->chat_name = $result["chat_name"];
		
		if(!$is_config) {
			if($this->site_key == "" || $this->secret == ""){
				goto_url("/adm/ninetalk/config.php");
				//alert("실시간문의 SITEKEY 또는 Secret 설정이 필요합니다.", "/adm/ninetalk/config.php");
			}
		}
	}
	
	
	function get_site_key(){
		return $this->site_key;
	}
	
	function get_secret(){
		return $this->secret;
	}
	
	function get_chat_id(){
		return $this->chat_id;
	}
	
	function get_chat_name(){
		return $this->chat_name;
	}
	

	
	function update($key, $secret, $chat_name){
		
		$r = sql_fetch("SELECT COUNT(*) cnt FROM ninetalk_site_key");
		
		$chatinfo = explode("|", $chat_name);
		
		if($r["cnt"] == 0){
			$sql = "INSERT ninetalk_site_key SET site_key='{$key}', secret='{$secret}', chat_id='{$chatinfo[0]}', chat_name='{$chatinfo[1]}' ";
			sql_query($sql);
		} else {
			$sql = "UPDATE ninetalk_site_key SET site_key='{$key}', secret='{$secret}', chat_id='{$chatinfo[0]}', chat_name='{$chatinfo[1]}' ";
			sql_query($sql);
		}
	}
	
}

