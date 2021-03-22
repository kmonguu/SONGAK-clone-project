<?
if($_REQUEST[p]){
	$ppage=explode("_",$_REQUEST[p]);
	$pageNum=$ppage[0];
	$subNum=$ppage[1];
	$ssNum=$ppage[2];
	$tabNum=$ppage[3];
}

if($pageNum != "1")  { 
	$useChatDB = "Y"; //게시판 알림 메뉴는 호스트DB사용, 나머지메뉴는 챗팅서버 DB사용 
} else {
	$useChatDB = "";
}



include_once("./_common.php");
 
$g4['title'] = "IT9 인트라넷";

include_once("./_head.php");
include_once("./lib/mobile.lib.php");

?>


	
<div data-role="content" class="divContent" stype="padding:0;margin:0;">

<?
 
if($bo_table)
	$bd = sql_fetch("SELECT * FROM g4_board WHERE bo_table='$bo_table'"); //게시판 스킨명

if($tot == "0_1"){
	echo "<input type='hidden' class='pageName' value='0_1' />";
	include_once("./pages/index.php");
}
if($tot == "1_1"){  
	echo "<input type='hidden' class='pageName' value='1_1' />";
	include_once("./pages/alimi/list.php"); 
} 
else if($tot == "1_2"){
	echo "<input type='hidden' class='pageName' value='1_2' />";
	
	if($ssNum == "1"){  
	
		if($bd[bo_skin] == "reservation_white" || $bd[bo_skin] =="reservation_black"  || $bd[bo_skin] =="inquiry_white2"  || $bd[bo_skin] =="inquiry_white" || $bd[bo_skin] =="inquiry_black"  || $bd[bo_skin] =="inquiry_black2" )
			include_once("./pages/alimi/viewR.php"); //게시판 뷰 (예약게시판)
		else if($bd[bo_skin] == "reserve_white" || $bd[bo_skin] =="reserve_black" )
			include_once("./pages/alimi/viewR2.php");		//게시판 뷰 (호텔용예약게시판)
		else
			include_once("./pages/alimi/view.php");	//게시판 뷰 (일반게시판)
	}
	
} 
else if($tot == "1_3"){
	echo "<input type='hidden' class='pageName' value='1_3' />";

	if($ssNum == "1"){

		if($bd[bo_skin] == "reservation_white" || $bd[bo_skin] =="reservation_black"  || $bd[bo_skin] =="inquiry_white2"  || $bd[bo_skin] =="inquiry_white" || $bd[bo_skin] =="inquiry_black"  || $bd[bo_skin] =="inquiry_black2" )
			include_once("./pages/alimi/writeR.php"); //게시판 뷰 (예약게시판)
		else if($bd[bo_skin] == "reserve_white" || $bd[bo_skin] =="reserve_black" )
			include_once("./pages/alimi/writeR2.php");		//게시판 뷰 (호텔용예약게시판)
		else
			include_once("./pages/alimi/write.php");	//게시판 뷰 (일반게시판)
	}

}

else if($tot == "2_1"){  
	echo "<input type='hidden' class='pageName' value='2_1' />";
	include_once("./pages/talk/list.php"); 
} 


else if($tot == "3_1"){
	echo "<input type='hidden' class='pageName' value='3_1' />";
	include_once("./pages/profile/view.php");
}


?>
	
  
  
<br/>
<br/>
<br/>

</div>

<?
include_once("./_tail.php");
?>
