<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>


	<div data-role="footer" data-position="fixed" data-theme="b" data-tap-toggle="false"  data-hide-during-focus="false" >
		<h1 style="font-size:10px;font-weight:normal;color:#b8b8b8;">COPYRIGHT2015 IT9 ALLRIGHTSRESERVE</h1>
	</div>

	

</div>


<!-- 상세 스케줄 표시 Dialog -->
<div data-role="page" id="dialog">

  <div data-role="header">
    <h1 id="digHeader">스케줄정보</h1>
  </div>

  <div data-role="content" id='digContent'>
	
  </div>


</div> 



<?
include_once("$g4[path]{$g4[app_path]}/tail.sub.php");
?>