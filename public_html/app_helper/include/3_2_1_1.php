<?
include_once("./_common.php");

set_session("modify_save_page", $_GET["save_page"]);
set_session("modify_save_sc", $_GET["save_sc"]);


$mObj = new HpModifyReq();
$view = $mObj->get_modify_view($_GET["wr_id"]);
?>

<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;">수정의뢰 글보기</div>
<div class="nbox">
	<div style="float:left;width:16.42%;margin-left:3.402%;margin-top:20px;"><a href="javascript:menum('menu03-1')"><img src="/app_helper/images/back_btn.jpg" style="width:100%"/></a></div>
	<div style="float:left;width:85.2%;margin-left:7.396%;margin-top:25px;color:#222222;font-size:26px;"><?=$view["wr_subject"]?></div>
	<div style="position:relative;float:left;width:87.053%;border-bottom:2px solid #97979a;color:#676767;font-size:22px;margin-left:5.473%;margin-top:15px;line-height:50px;padding-left:2%;"><?=$view[wr_datetime]?>
		<div style="position:absolute;top:0;right:2%;">글쓴이 : <?=$view["wr_name"]?></div>
	</div>

   <?
	// 가변 파일
	$cnt = 0;
	for ($i=0; $i<count($view[file]); $i++) {
		if ($view[file][$i][source]) {

			$link=str_replace("./download.php", "http://it9.co.kr/api/helper/download_modify_req_file.php", $view[file][$i][href]);
            $link .= "&sitekey={$sitekey}";

			$cnt++;
			echo "
				<div style='position:relative;float:left;width:87.053%;border-bottom:2px solid #e0e0e1;color:#6a6a6a;font-size:15px;margin-left:5.473%;padding-bottom:16px;margin-top:15px;padding-left:2%;'>
					<a href=\"javascript:cdv_file_download('{$link}', '{$view[file][$i][source]}', '{$view[file][$i][mime_type]}');\" title='{$view[file][$i][content]}'>
                        {$view[file][$i][source]} ({$view[file][$i][size]})
						<span style='color:#ff6f2b;'>[{$view[file][$i][download]}]</span> DATE : {$view[file][$i][datetime]}
					</a>
				</div>
			";
		}
    }   
    ?>
    

	<!--
    <ul>
        <li class="nboxli2">
			<span class="Simg"><img src="<?=$g4["mpath"]?>/images/order<?=$view["wr_7"] ? $view["wr_7"] : "1"?>.png" style="width:100%"/></span>	
        </li>
    </ul>
    -->
        
	<div style="float:left;width:85.2%;margin-left:7.396%;margin-top:25px;color:#222222;font-size:23px;padding-bottom:26px;border-bottom:2px solid #e0e0e1;">
        <?
		$html = 0;
		if (strstr($view[wr_option], "html1"))
			$html = 1;
		else if (strstr($view[wr_option], "html2"))
			$html = 2;
		$view[content] = conv_content($view[wr_content], $html);
		?>
		<?=$view['content']?>
    </div>


    
    <div id="cmtList">
    </div>
  

	<div style="float:left;width:100%;margin-left:5.473%;margin-top:30px;">		
		<div style="position:relative;float:left;width:62.5%;"><textarea class="textarea01" rows="3" id="cmt_content"></textarea></div>
		<div style="float:left;margin-left:6%;width:20.414%;"><a href="javascript:void(0);" onclick="insert_comment();"><img src="/app_helper/images/re_bt.jpg" style="width:100%"/></a></div>
	</div>



	<div style="float:left;width:100%;margin-top:30px;margin-bottom:20px;text-align:center;">
		<div style="width:28.994%; display:inline-block;"><a href="javascript:void(0);" onclick="go_delete()"><img src="/app_helper/images/v_btn02.jpg" style="width:100%"/></a></div>
        <!--
		<div style="float:left;width:28.994%;margin-left:20.173%;"><a href="javascript:void(0);" onclick="go_modify()"><img src="/app_helper/images/v_btn01.jpg" style="width:100%"/></a></div>
		<div style="float:left;width:28.994%;margin-left:1.035%;"><a href="#"><img src="/app_helper/images/v_btn03.jpg" style="width:100%"/></a></div>
        -->
	</div>
</div>


<script>

    function go_modify(){
        location.href="<?=$g4["mpath"]?>/pages.php?p=3_3_1_1&w=u&wr_id=<?=$wr_id?>";
    }

    function go_delete(){

        confirm_app("삭제하시겠습니까?", function(){

            $.post("<?=$g4["mpath"]?>/include/_ajax_modify_delete.php", {
                wr_id:"<?=$wr_id?>"
            }, function(data){

                if(data != "OK") {
                    alert(data);
                } else {
                    menum('menu03-1');
                    load_cmtlist();
                }

            });

        });
    
    }

    $(function(){
        load_cmtlist();
    });

    function load_cmtlist(){
        $("#cmtList").load("<?=$g4["mpath"]?>/include/_ajax_modify_cmtlist.php", {wr_id:"<?=$wr_id?>"}, function(data){});
    }

    function insert_comment(){

        showProgress();

        $.post("<?=$g4["mpath"]?>/include/_ajax_modify_comment_insert.php", {
            wr_id:"<?=$wr_id?>"
            , wr_name:"<?=$view["wr_name"]?>"
            , wr_content:$("#cmt_content").val()
        }, function(data){
            
            closeProgress();

            if(data != "OK") {
                alert(data);
            } else {
                $("#cmt_content").val("");
                load_cmtlist();
                //alert_app("댓글이 입력되었습니다.");
            }

        });
    }

    function delete_cmt(wr_id, pwr_id){

        showProgress();

        confirm_app("댓글을 삭제하시겠습니까?", function(){
            
            $.post("<?=$g4["mpath"]?>/include/_ajax_modify_comment_delete.php", {
                wr_id:wr_id
                , pwr_id:pwr_id
            }, function(data){
                if(data != "OK") {
                    alert(data);
                } else {
                    load_cmtlist();
                }
                closeProgress();
            });

        });
        
    }
</script>