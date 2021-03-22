<?
class ChatInfo {
	private $dao = null;
	
	function ChatInfo() {
		global $dao;
		$this->dao = $dao;
	}
	
	
	
	function get($chat_id){
		
		$result = $this->dao->doSelect("ChatInfo.get", array("chat_id"=>$chat_id));
		return $result[0];
	}
	
	
	
	function update($params){
		
		$this->dao->doUpdate("ChatInfo.update", $params);
	}
	
	
	function insert($params){
		
		$params["site_key"] = rand(100000,999999);
		$this->dao->doInsert("ChatInfo.insert", $params);
	}
	
	function delete($chat_id){
	
		$this->dao->doDelete("ChatInfo.delete", array("chat_id"=>$chat_id));
	}
}


