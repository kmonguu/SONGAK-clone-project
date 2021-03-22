<?
include_once("./_common.php");

include_once("./head.php");
?>
<section class="sub">

<?if($tot==''){?>

<?}else if($tot=='100_6')//이용약관 
	include_once("$g4[mpath]/include/utilization.php");

else if($tot=='100_7')//개인정보처리방침
	include_once("$g4[mpath]/include/privacy.php");

else if($tot=='100_16')//이메일주소무단수집거부
	include_once("$g4[mpath]/include/email_privacy.php");
else{

    if(file_exists("{$g4[path]}/m/include/sub{$tott}.php"))
       include_once("$g4[path]/m/include/sub{$tott}.php");
    
    else if(file_exists("{$g4[path]}/m/images/sub{$tott}.jpg"))
		echo "<img src='/m/images/sub{$tott}.jpg' alt='".$menu["tott"][$pageNum][$subNum][$ssNum]." 컨텐츠'/>";

    else if(file_exists("{$g4[path]}/m/include/sub{$tot}.php"))
		include_once("$g4[path]/m/include/sub{$tot}.php");

	else if(file_exists("{$g4[path]}/m/images/sub{$tot}.jpg"))
		echo "<img src='/m/images/sub{$tot}.jpg' alt='".$menu["tot"][$pageNum][$subNum]." 컨텐츠'/>";

    else if(file_exists("{$g4[path]}/m/include/sub{$pageNum}.php"))
		include_once("$g4[path]/m/include/sub{$pageNum}.php");

    else if(file_exists("{$g4[path]}/m/images/sub{$pageNum}.jpg"))
		echo "<img src='/m/images/sub{$pageNum}.jpg' alt='".$menu["pageNum"][$pageNum]." 컨텐츠'/>";

    else {?>
		<img src="/m/images/sub_ready.jpg" style="display:block; margin:0 auto;"/>
    <?}

}?>

</section>
<?
include_once("./tail.php");
?>
