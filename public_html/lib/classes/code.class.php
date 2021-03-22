<?
class Code {
	private $dao = null;
	function Code() {
		global $dao;
		$this->dao = $dao;
	}
	
	// 모든 D1 리스트
	function get_list_d1() {
		$result = $this->dao->doSelect ( "Code.list_d1", array () );
		return $result;
	}
	
	// 선택된 D1에 대한 D2리스트
	function get_list_d2($code) {
		$result = $this->dao->doSelect ( "Code.list_d2", array (
				"code" => $code 
		) );
		return $result;
	}
	
	// 코드정보 (코드번호로 가져옴)
	function get($no) {
		$result = $this->dao->doSelect ( "Code.select_no", array (
				"no" => $no 
		) );
		return $result;
	}
	
	// 코드정보 (CODE와 SEQ조합으로 가져옴 ex. {CODE}-{SEQ})
	function get_codeSeq($codeSeq) {
		$c = explode ( "-", $codeSeq );
		if (count ( $c ) == 2) {
			$result = $this->dao->doSelect ( "Code.select_codeSeq", array (
					"code" => $c [0],
					"seq" => $c [1] 
			) );
			return $result [0];
		} else {
			$result ["value"] = "";
			return $result;
		}
	}
	
	// 코드의 VALUE값을 가져옴
	function get_value($codeSeq) {
		$c = explode ( "-", $codeSeq );
		if (count ( $c ) == 2) {
			$result = $this->dao->doSelect ( "Code.select_value", array (
					"code" => $c [0],
					"seq" => $c [1] 
			) );
			if (count ( $result ) != 0)
				return $result [0] ['value'];
		}
		return "";
	}
	
	// 추가될 seq
	function last_seq($code) {
		$result = $this->dao->doSelect ( "Code.last_seq", array (
				"code" => $code 
		) );
		return $result [0] ["seq"];
	}
	// 추가될 order
	function last_order($code) {
		$result = $this->dao->doSelect ( "Code.last_order", array (
				"code" => $code 
		) );
		return $result [0] ["order"];
	}
	
	// D1코드 추가
	function insert_d1($params) {
		$this->dao->doInsert ( "Code.insert_d1", $params );
	}
	
	// D2코드 추가
	function insert_d2($params) {
		$this->dao->doInsert ( "Code.insert_d2", $params );
	}
	
	// 코드 업데이트
	function update($params) {
		$this->dao->doUpdate ( "Code.update", $params );
	}
	
	// D1코드 삭제
	function delete_d1($code) {
		$this->dao->doDelete ( "Code.delete_d1", array (
				"code" => $code 
		) );
	}
	
	// D2코드 삭제
	function delete_d2($no) {
		$this->dao->doDelete ( "Code.delete_d2", array (
				"no" => $no 
		) );
	}
	
	// 코드 옵션 리스트 출력
	function get_options($code, $slt = "") {
		$list = $this->get_list_d2 ( $code );
		
		$options = "";
		foreach ( $list as $row ) {
			$selected = "";
			if ($slt == $row [code_seq]) {
				$selected = "selected";
			}
			$options .= "<option value='{$row[code_seq]}' {$selected} >{$row[value]}</option>";
		}
		
		return $options;
	}
	
	// 코드 옵션 리스트 출력
	function get_options_with_code($code, $slt = "") {
		$list = $this->get_list_d2 ( $code );
		
		$options = "";
		foreach ( $list as $row ) {
			$selected = "";
			$code1 = "";
			if ($row [code1] != "")
				$code1 = " ({$row[code1]})";
			if ($slt == $row [code_seq]) {
				$selected = "selected";
			}
			$options .= "<option value='{$row[code_seq]}' {$selected} >{$row[value]}{$code1}</option>";
		}
		
		return $options;
	}
}
?>