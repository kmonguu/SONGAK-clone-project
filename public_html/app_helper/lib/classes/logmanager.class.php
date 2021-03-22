<?
class LogManager {
	private $dao = null;
	function LogManager() {
		global $dao;
		$this->dao = $dao;
	}
	function get_list($div1, $div2, $pno, $limit = "", $where = "") {
		$params = array ();
		$params ["div1"] = $div1;
		$params ["div2"] = $div2;
		$params ["pno"] = $pno;
		$params ["limit"] = $limit;
		$params ["where_query"] = $where;
		$result = $this->dao->doSelect ( "Log.list", $params );
		
		return $result;
	}
	function insert($params) {
		global $member;
		$params ["log_ip"] = $_SERVER [REMOTE_ADDR];
		$params ["log_id"] = $member [mb_id];
		$this->dao->doInsert ( "Log.insert", $params );
	}
}
?>
