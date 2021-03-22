<?
class Auth {
	private $dao = null;
	private $mbObj = null;
	private $AUTH_TEST = false;
	
	
	
	
	public static $menus = array(
				
			"1" => array(
					"name"=>"홈페이지관리",
					"pageNum" => "1",
					"sub"=> array(
						1=>array("name"=>"환경설정"),
						2=>array(
								"name"=>"회원관리",
								"sub"=>array(
									1=>array("name"=>"회원관리"),
									2=>array("name"=>"포인트관리"),
									3=>array("name"=>"접속자현황"),
									4=>array("name"=>"접속자분석기"),
									5=>array("name"=>"회원메일발송"),
								),
						),
						3=>array(
								"name"=>"게시판관리",
								"sub"=>array(
										1=>array("name"=>"게시판관리"),
										2=>array("name"=>"게시판그룹관리")
								),
						),
						4=>array(
								"name"=>"예약상품관리",
								"sub"=>array(
										1=>array("name"=>"퍼시픽랜드"),
										2=>array("name"=>"샹그릴라요트"),
										3=>array("name"=>"레스토랑")
								),
						),
						5=>array("name"=>"패키지 상품관리"	),
					)		
			),
			
			"2" => array(
				"name"=>"예약설정관리",
				"pageNum"=>"2",
				"sub"=>array(
					1=>array(
							"name"=>"상품관리",
							"sub"=>array(
								1=>array("name"=>"요트", "pagename"=>"요트 관리"),		
								2=>array("name"=>"보트", "pagename"=>"보트 관리"),		
								3=>array("name"=>"씨푸드", "pagename"=>"씨푸드 관리"),		
								4=>array("name"=>"베이커리", "pagename"=>"베이커리 관리"),		
								5=>array("name"=>"공연", "pagename"=>"공연 관리"),		
							)
					),
					2=>array("name"=>"투어관리"),
					3=>array("name"=>"코스관리"),
					4=>array("name"=>"할인내역 관리"),
					5=>array("name"=>"예약 담당자관리")
				)
			),
			
			
			"3" => array(
				"name"=>"거래처관리",
				"pageNum"=>"3",
				
				"sub"=>array(
					1=>array("name"=>"거래처관리"),
					2=>array("name"=>"거래처구분"),
					3=>array("name"=>"거래처 담당자관리"),
				)
			),
			
			
			"4" => array(
					"name"=>"예약목록",
					//"ul_attr"=>"style='width:100px;'",
					//"submenu_style"=>"left:-48px;",
					"pageNum"=>"4",
					"sub"=>array(
							1=>array(
									"name"=>"예약목록",
									"sub"=>array(
											1=>array("name"=>"전체 예약목록"),
											2=>array("name"=>"일일 예약목록"),
											//2=>array("name"=>"월별 예약목록"),
									)
							),
							2=>array("name"=>"외상내역관리"),
							3=>array("name"=>"매출현황표"),
							4=>array("name"=>"예약변경기록"),
					)
			),
			
			
			"5" => array(
				"name"=>"문자/알림톡",
				"pageNum"=>"5",
				"sub"=>array(
					1=>array("name"=>"회원 문자발송"),
					2=>array(
							"name"=>"예약자에게 발송",
							"sub"=>array(
									1=>array("name"=>"SMS", "pagename"=>"예약자 문자메시지 발송"),
									2=>array("name"=>"알림톡", "pagename"=>"예약자 알림톡발송"),
							)	
					),
					3=>array(
							"name"=>"SMS관리",
							"sub"=>array(
									1=>array("name"=>"발송내역", "pagename"=>"SMS 발송내역"),
									2=>array("name"=>"환경설정", "pagename"=>"SMS 환경설정"),
									3=>array("name"=>"메시지 편집", "pagename"=>"SMS 메시지편집"),
							)
					),
					4=>array(
							"name"=>"알림톡관리",
							"sub"=>array(
									1=>array("name"=>"발송내역", "pagename"=>"알림톡 발송내역"),
									2=>array("name"=>"환경설정", "pagename"=>"알림톡 환경설정"),
									3=>array("name"=>"메시지편집", "pagename"=>"알림톡 메시지편집"),
							)
							
					)
				)
			),
			
			
			"6" => array(
				"name"=>"모아모아 블로그",
				"pageNum"=>"6",
				"sub"=>array(
					1=>array("name"=>"퍼시픽랜드"),
					2=>array("name"=>"요트투어 샹그릴라"),
					3=>array("name"=>"씨푸드샹그릴라"),
				)
			),
			
		
	); 
	

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
	
	
	
	//예약 총요금을 확인할 수 있는 권한인지 체크
	static function CHECK_LVL_IS_RSV_TOTAL_AMT(){
		global $member;
	
		if(Auth::is_admin()) return true;
	
		if($member["mb_2"] == 1) return true;
	
		return false;
	}
	
	
	//예약 비고를 확인할 수 있는 권한인지 체크
	static function CHECK_LVL_IS_RSV_MEMO(){
		global $member;
	
		if(Auth::is_admin()) return true;
	
		if($member["mb_3"] == 1) return true;
	
		return false;
	}
	
	
	

	
}