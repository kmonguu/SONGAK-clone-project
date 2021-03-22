<?
class Sms4Stat extends Base {
    
    
	function __construct(){
		parent::__construct();
	}


	function get_list($page, $sfl = "", $stx = "", $sst = "", $sod = "", $rows = "", $where_query = "", $order_query = "", $is_moreview=false) {
		
		global $g4;
		
		if (! $rows)
			$rows = Props::get ( "rows" );
		
		if(!$is_moreview) {
			$from_record = ($page - 1) * $rows;
		} else {
			$from_record = "0";
			$rows = $page * $rows;
		}
		
		if (! $sst) {
			$sst = "wr_datetime";
			$sod = "desc";
			$order_query = "";
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
		$params ['where_query'] = $where_query;
		$params ['order_query'] = $order_query;



		$result ["list"] = $this->dao->doSelect ( 'Sms4Stat.list', $params );
		// $this->dao->setDebug(false);
		
		// 전체 리스트 수
		$params ["is_count"] = "Y";
		$listCnt = $this->dao->doSelect ( "Sms4Stat.list", $params );
		$result ["count"] = $listCnt [0] ["cnt"];
	
		
		return $result;
	}
    
    
    function stat_date($sch_sdate="", $sch_edate="") {

        if($sch_sdate != "" && $sch_edate == "") $sch_edate = $sch_sdate;
        $params = array();
        $params["sch_sdate"] = $sch_sdate;
		$params["sch_edate"] = $sch_edate;
        $result = $this->dao->doSelect("Sms4Stat.stat_date", $params);
        return $result;

    }
    
}


