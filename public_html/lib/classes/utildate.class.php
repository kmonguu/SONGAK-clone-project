<?
class Utildate {
	function Utildate() {
	}
	
	// 날짜 더하기
	function dateAdd($orgDate, $mth, $sep = "") {
		$cd = strtotime ( $orgDate );
		$format = "Y{$sep}m{$sep}d";
		$retDAY = date ( $format, mktime ( 0, 0, 0, date ( 'm', $cd ), date ( 'd', $cd ) + $mth, date ( 'Y', $cd ) ) );
		return $retDAY;
	}
	function datediff($date1, $date2) {
		$_date1 = explode ( "-", $date1 );
		$_date2 = explode ( "-", $date2 );
		$tm1 = mktime ( 0, 0, 0, $_date1 [1], $_date1 [2], $_date1 [0] );
		$tm2 = mktime ( 0, 0, 0, $_date2 [1], $_date2 [2], $_date2 [0] );
		return ($tm1 - $tm2) / 86400;
	}

	//요일
	static function yoil($date, $type=0) {

		$yoilArr = array(
			0=>array("일", "월", "화", "수", "목", "금", "토")
			, 1=>array("일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일")
			, 2=>array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat")
		);
		
		return $yoilArr[$type][date("w", strtotime($date))];
	}	
}
?>