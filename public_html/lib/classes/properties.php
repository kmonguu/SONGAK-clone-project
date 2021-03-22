<?


$props ["market_level"] = $g4[market_level]; // 입점업체 레벨



// #########################################################################################
                            // 게시판 관련
$props ["rows"] = 20; // 페이지당 ROW 표시 수
$props ["write_pages"] = 5; // 페이지리시트에 한번에 표시될 페이지 수


class Props {
	static function get($key) {
		global $props;
		return $props [$key];
	}
}

?>