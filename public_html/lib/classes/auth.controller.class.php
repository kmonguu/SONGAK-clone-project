<?
class Auth_Controller  {

	
	//권한별 접근가능 페이지
	private $allow_pages = array(
	);
	

	
	function __construct() {

		global $member;
		
		
		if($member["mb_level"] < 10){
			
			$menus = Auth::$menus;
				
			$auth = $member["mb_1"];
					
			$auths = explode("|", $auth);
			
			$this->allow_pages[$member["mb_level"]]["__"] = array("ALL");


			foreach($auths as $au){
				
				$a = explode("_", $au);
				
				$p = $a[0];
				$s = $a[1];
				$this->allow_pages[$member["mb_level"]]["{$p}_1_0"] = array("ALL"); //대메뉴 오픈
				
				
				if($menus[$p]["sub"][$s]["sub"]) {
					
					foreach($menus[$p]["sub"][$s]["sub"] as $key=>$value){
							$this->allow_pages[$member["mb_level"]]["{$p}_{$s}_{$key}"] = array("ALL"); //3depth 메뉴 오픈
					}
					
				} else {
					
					$this->allow_pages[$member["mb_level"]]["{$p}_{$s}_1"] = array("ALL"); //서브메뉴 오픈
				}
				
				
				
				/*
				$this->allow_pages[$member["mb_level"]]["{$au}_1_0"] = array("ALL"); //대메뉴 오픈
				
				foreach($menus[$au]["sub"] as $key=>$value){
					
					if($value["sub"]) {
						
						foreach($value["sub"] as $sk => $sv) {
							$this->allow_pages[$member["mb_level"]]["{$au}_{$key}_{$sk}"] = array("ALL"); //3depth 메뉴 오픈
						}
						
					} else {
						
						$this->allow_pages[$member["mb_level"]]["{$au}_{$key}_1"] = array("ALL"); //서브메뉴 오픈
					
					}
					
				}
				*/
				
			}
			
		}
		
	}
	
	
	//게시판 권한이 있는가
	function is_board_auth(){
		global $member;
		if($this->allow_pages[$member["mb_level"]]["BOARD"] == "Y") return true;
		return false;
	}
	
	
	
	//사용자가 메뉴에 접근할 권한이 있는지 확인합니다..
	function check_menu($p) {
		
		global $member;
		
		if($member["mb_level"] == 10) return true;
		
		if(count($this->allow_pages[$member['mb_level']]) == 0) return false;
		
		foreach($this->allow_pages[$member['mb_level']] as $allowpage=>$auth){
			
			if(startsWith($p, $allowpage)) { return true; }
				
		}
		

		return false;
	}
	
	
	//접속하려는 페이지에 권한이 있는지 체크합니다.
	function check_page_auth($checkpage=""){
		
		global $member, $pageNum, $subNum, $ssNum, $tabNum, $p;
		
		if($member["mb_level"] == 10) return true;
		
		//echo $checkpage; exit;
		
		if($checkpage) {
			$p = $checkpage;
			if($p){
				$ppage=explode("_",$p);
				$pageNum=$ppage[0];
				$subNum=$ppage[1];
				$ssNum=$ppage[2];
				$tabNum=$ppage[3];
			}		
		}
		else if($pageNum == "" && $p != "" ){
			if($p){
				$ppage=explode("_",$p);
				$pageNum=$ppage[0];
				$subNum=$ppage[1];
				$ssNum=$ppage[2];
				$tabNum=$ppage[3];
			}
		}
		
		
		
		$tot = $pageNum."_".$subNum."_".$ssNum;
		
		if(array_key_exists($tot, $this->allow_pages[$member["mb_level"]])){
			
			return true;
			
		} else {
			
			echo "<div style='color:gray;font-size:35px;width:100%;padding-top:100px;text-align:center;font-weight:bold;'>해당 작업을 진행할<span style='color:#ef6149;font-size:40px;'>권한</span>이 없습니다<div>";
			echo "<div style='color:gray;font-size:17px;width:100%;line-height:1.6;padding-top:22px;text-align:center;'>관리자에게 문의해주십시오.<br/>[Error CODE : AUTH000]</div>";
			//echo("해당 페이지에 접근권한이 없습니다.");
			exit;
		}
		
	}
	
	//수정 권한 체크
	function check_CRUD_auth($CRUD, $page=""){
		
		global $member, $pageNum, $subNum, $ssNum, $tabNum, $p;
		
		if($member["mb_level"] == 10) return true;
		
		if($page != ""){
			$ppage=explode("_",$page);
			$pageNum=$ppage[0];
			$subNum=$ppage[1];
			$ssNum=$ppage[2];
			$tabNum=$ppage[3];
		}
		else if($pageNum == "" && $p != ""){
			$ppage=explode("_",$p);
			$pageNum=$ppage[0];
			$subNum=$ppage[1];
			$ssNum=$ppage[2];
			$tabNum=$ppage[3];
		}
		$tot = $pageNum."_".$subNum."_".$ssNum;
		
		$auth = $this->allow_pages[$member["mb_level"]][$tot][0];
		if($auth == "ALL") { return true; }
		
		$crudArr = explode("|", $CRUD);
		
		$result = false;
		foreach($crudArr as $a){
			if(in_array($a, $this->allow_pages[$member["mb_level"]][$tot])) {
				$result = true;
				break;
			}
		}
		return $result;
	}
 
}