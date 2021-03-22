<?
class Board {
	private $dao = null;
	
	// 테이블 명 (생성자에서 셋팅 필요)
	private $write_table = null;
	function Board($write_table) {
		global $dao;
		$this->dao = $dao;
		$this->write_table = $write_table;
	}
	function get_list($page, $sfl = "", $stx = "", $sst = "", $sod = "", $rows = "", $where_query = "", $order_query = "") {
		global $g4, $qstr;
		if (! $rows)
			$rows = Props::get ( "rows" );
		
		$from_record = ($page - 1) * $rows;
		if (! $sst) {
			$sst = "wr_id";
			$sod = "desc";
		}

		$sfls = explode("||", $sfl);

		if(count($sfls) > 1) {
			$sfl = " concat(";
			$idx = 0;
			foreach($sfls as $f){
					$idx ++;
					if($idx != 1) $sfl .= ", ";
					$sfl .= $f;
			}
			$sfl .= ") ";
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
		$params ["bo_table"] = $this->write_table;
		$params ['where_query'] = $where_query;
		$params ['order_query'] = $order_query;
		
		$result ["list"] = $this->dao->doSelect ( 'Board.list', $params );
		
		foreach($result["list"] as $key=>$value){
			$result["list"][$key]["file"] = get_file($this->write_table, $value["wr_id"]); //가변파일정보
			$result["list"][$key]['href'] = "$g4[bbs_path]/board.php?bo_table={$this->write_table}&wr_id={$value['wr_id']}" . $qstr;
		}
		
		// 전체 리스트 수
		$params ["is_count"] = "Y";
		$listCnt = $this->dao->doSelect ( "Board.list", $params );
		$result ["count"] = $listCnt [0] ["cnt"];
		
		return $result;
	}
	function get_board() {
		$params = array ();
		$params ["bo_table"] = $this->write_table;
		
		$result = $this->dao->doSelect ( "Board.get_board", $params );
		
		return $result [0];
	}
	
	// 게시물 추가
	function insert($params) {
		global $member;
		
		$params ["wr_num"] = get_next_num ( "g4_write_" . $this->write_table ); // 그누보드함수
		$params ["mb_id"] = $member [mb_id];
		$params ["wr_password"] = $member [mb_password] ? $member [mb_password] : $params [wr_password];
		if($member[mb_id])
				$params ["wr_name"] = $board [bo_use_name] ? $member [mb_name] : $member [mb_nick];
		$params ["wr_ip"] = $_SERVER [REMOTE_ADDR];
		$params ["bo_table"] = $this->write_table;
		
		$this->dao->doInsert ( "Board.insert", $params );
		
		$wr_id = mysql_insert_id ();
		
		// parent 수정, board 테이블 추가, 글 수 수정
		$this->insert_other_table ( $wr_id );
		
		return $wr_id;
	}
	function get_forSubject($subject) {
		$params = array ();
		$params ["wr_subject"] = $subject;
		$params ["bo_table"] = $this->write_table;
		
		$result = $this->dao->doSelect ( "Board.get_forSubject", $params );
		return $result;
	}
	function get($wr_id) {
		global $g4;

		$params = array ();
		$params ["wr_id"] = $wr_id;
		$params ["bo_table"] = $this->write_table;
		
		$result = $this->dao->doSelect ( "Board.get", $params );
		
		$result[0]["file"] = get_file($this->write_table, $wr_id); //가변파일정보
		$result[0]['href'] = "$g4[bbs_path]/board.php?bo_table={$this->write_table}&wr_id={$wr_id}" . $qstr;

		return $result [0];
	}
	function get_forAnother($field, $value) {
		$params = array ();
		$params ["field"] = $field;
		$params ["value"] = $value;
		$params ["bo_table"] = $this->write_table;
		
		$result = $this->dao->doSelect ( "Board.get_fromAnother", $params );
		
		return $result [0];
	}
	
	// 게시판 추가될때 연관 자료들 업뎃
	function insert_other_table($wr_id) {
		$this->update_parent ( $wr_id );
		$this->update_new ( $wr_id );
		$this->update_cnt ();
	}
	function update_field($wr_id, $field, $value) {
		$params = array ();
		$params ["wr_id"] = $wr_id;
		$params ["field"] = $field;
		$params ["value"] = $value;
		$params ["bo_table"] = $this->write_table;
		
		$this->dao->doUpdate ( "Board.update_field", $params );
	}
	function update_parent($wr_id) {
		$params = array ();
		$params ["wr_id"] = $wr_id;
		$params ["wr_num"] = get_next_num ( "g4_write_" . $this->write_table ); // 그누보드함수
		$params ["write_table"] = $this->write_table;
		$this->dao->doUpdate ( "Board.update_parent", $params );
	}
	function update_new($wr_id) {
		global $member;
		$params = array ();
		$params ["wr_id"] = $wr_id;
		$params ["mb_id"] = $member [mb_id];
		$params ["bo_table"] = $this->write_table;
		$this->dao->doUpdate ( "Board.update_new", $params );
	}
	function update_cnt() {
		$params = array ();
		$params ["bo_table"] = $this->write_table;
		$this->dao->doUpdate ( "Board.update_cnt", $params );
	}
	function delete_cnt() {
		$params = array ();
		$params ["bo_table"] = $this->write_table;
		$this->dao->doUpdate ( "Board.delete_cnt", $params );
	}
	function delete($wr_id) {
		$params = array ();
		$params ["bo_table"] = $this->write_table;
		$params ["wr_id"] = $wr_id;
		$this->dao->doDelete ( "Board.delete", $params );
		$this->dao->doDelete ( "Board.delete_new", $params );
		$this->delete_cnt ();
		
		$board = $this->get_board ();
		// 공지사항 삭제
		$notice_array = explode ( "\n", trim ( $board [bo_notice] ) );
		$bo_notice = "";
		for($k = 0; $k < count ( $notice_array ); $k ++) {
			if (( int ) $write [wr_id] != ( int ) $notice_array [$k]) {
				$bo_notice .= $notice_array [$k] . "\n";
			}
		}
		$bo_notice = trim ( $bo_notice );
		$params ["bo_notice"] = $bo_notice;
		$this->dao->doUpdate ( "Board.update_notice", $params );
	}
	
	// #####################################################################################################
	// 댓글 부분
	
	// 댓글 리스트를 가져옵니다.
	function get_list_comment($wr_id) {
		$params = array ();
		$params ["wr_id"] = $wr_id;
		$params ["board"] = $this->write_table;
		
		$result = $this->dao->doSelect ( "BoardComment.list", $params );
		
		return $result;
	}
	
	// 댓글을 가져옵니다.
	function get_comment($wr_id) {
		$params = array ();
		$params ["wr_id"] = $wr_id;
		$params ["board"] = $this->write_table;
		
		$result = $this->dao->doSelect ( "BoardComment.select", $params );
		return $result [0];
	}
	
	// 댓글 추가
	function insert_comment($wr_id, $params) {
		$params ["board"] = $this->write_table;
		$params ["wr_id"] = $wr_id;
		$this->dao->doInsert ( "BoardComment.insert", $params );
		
		// 댓글 수 맞춤
		$this->update_comment_cnt ( $wr_id );
	}
	
	// 댓글 업데이트
	function update_comment($wr_id, $content) {
		$params = array ();
		$params ["wr_id"] = $wr_id;
		$params ["board"] = $this->write_table;
		$params ["wr_content"] = $content;
		
		$this->dao->doUpdate ( "BoardComment.update", $params );
	}
	
	// 댓글 개수
	function get_comment_cnt($wr_id) {
		$params = array ();
		$params ["wr_id"] = $wr_id;
		$params ["board"] = $this->write_table;
		$result = $this->dao->doSelect ( "BoardComment.get_cnt", $params );
		return $result [0] [cnt];
	}
	
	// 현재 코멘트 숫자로 업뎃
	function update_comment_cnt($wr_id) {
		
		// 현재 코멘트트 수
		$cmtCnt = $this->get_comment_cnt ( $wr_id );
		
		$params = array ();
		$params ["wr_id"] = $wr_id;
		$params ["cnt"] = $cmtCnt;
		$params ["board"] = $this->write_table;
		
		$this->dao->doUpdate ( "BoardComment.update_cnt", $params );
	}
	
	// 댓글 삭제
	function delete_comment($wr_id, $pwr_id) {
		$params = array ();
		$params ["wr_id"] = $wr_id;
		$params ["board"] = $this->write_table;
		
		$this->dao->doDelete ( "BoardComment.delete", $params );
		
		// 댓글 수 맞춤
		$this->update_comment_cnt ( $pwr_id );
	}
	
	// #####################################################################################################
}


