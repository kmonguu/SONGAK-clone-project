<?
class Auth {
	private $dao = null;
	private $mbObj = null;
	private $AUTH_TEST = false;
	function Auth() {
	}
	
	// 로그인체크
	static function login_check($level = "") {
		
		
		
		global $member;
		
		if($level == "M"){  //입점업체 레벨
			$level = Props::get("market_level");
		}
		if($level == "A"){
			$level = 10;
		}
		
		
		
		if($level == "") {
			if ($member [mb_level] <= 1) {
				echo "로그인하세요!";
				exit ();
			}
		} else {
			
			
			if ($member [mb_level] < $level) {
				echo "권한이 없습니다.";
				exit ();
			}
			
		}
			
			
	}
	
	
	static function is_admin(){
		
		global $member;
		if($member[mb_level] == 10){
			return true;
		}
		return false;
	}
	
	

	
}