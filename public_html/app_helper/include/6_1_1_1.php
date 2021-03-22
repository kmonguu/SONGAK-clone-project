<?
include "./_common.php";

$ss_fcmID = get_session("fcm_id");
if($ss_fcmID){
    $conf = sql_fetch(" SELECT * FROM helper_analytics_config WHERE fcm_id='$ss_fcmID' ");
    if(!$conf["push1_time"]) {
        sql_query(" INSERT INTO helper_analytics_config SET fcm_id='{$ss_fcmID}', push_use='0', push1_time='12:30', push2_time='18:30' ");
        $conf = sql_fetch(" SELECT * FROM helper_analytics_config WHERE fcm_id='$ss_fcmID' ");
    }
    $time1 = explode(":", $conf[push1_time]);
    $time2 = explode(":", $conf[push2_time]);
}

?>



<script type="text/javascript">
	var failMsg = "설정변경에 실패하였습니다. 다시한번 변경해 주세요";

	function saveValue(field, value){

        showProgress();

		$.ajax({
			url:"<?=$g4["mpath"]?>/include/_ajax_analytics_setting.php?d=" + new Date().getTime(),
			type:"post",
			dataType:"json",
			data:{
				field:field,
				value:value
			},
			success:function(result){
				var r = result["result"];
				if(r != "true"){
					alert(failMsg);
                }
                toast("설정이 저장되었습니다.");
                closeProgress();
			},
			error:function(x,o,e){
                //alert(failMsg+"!");
                toast(failMst, 2000);
                closeProgress();
			}
		});
	}
	function mod_push_use(val){
        var value = "0";
        if(val) {
            value = "1";
        }
		saveValue("push_use", value);
	}

	function mod_push1_time(){
		var val = $("#push_time1_1").val() + ":" + $("#push_time1_2").val();
		saveValue("push1_time", val);
	}

	function mod_push2_time(){
		var val = $("#push_time2_1").val() + ":" + $("#push_time2_2").val();
		saveValue("push2_time", val);
	}
</script>




<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;">접속자 알람 설정</div>
<div class="nbox">
	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:20px;padding-bottom:7px;">접속자 분석기 알림 전송받기</div>
	<div style="float:left;border:1px solid #c3c3c3;border-radius:8px;color:#3f3f3f;padding:2.5%;font-size:26px;width:87.011%;margin-left:3.994%;margin-top:20px;">
		<div style="position:relative;float:left;width:16.124%;">
            <input type="checkbox" class="transparent_chkbox" id="push_use" name="push_use" <?=$conf["push_use"] ? "checked" : ""?> data-link="disp_push_use" data-onimg="<?=$g4["mpath"]?>/images/s_on.jpg" data-offimg="<?=$g4["mpath"]?>/images/s_off.jpg" value="1"  onchange="mod_push_use($(this).is(':checked'))">
            <img src="<?=$g4["mpath"]?>/images/s_off.jpg" id="disp_push_use" style="width:100%"/>
        </div>
	</div>	

	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:40px;padding-bottom:7px;">전송시간1</div>
        <div style="position:relative;float:left;margin-left:4.027%;width:42.711%;margin-top:15px;">
            <select name="push_time1_1" id="push_time1_1" onchange="mod_push1_time()" data-link="disp_push_time_1_1" class="transparent_sltbox" >
                <?for($i = 1 ; $i <= 24 ; $i++) {
                    $ii = str_pad($i, 2, '0', STR_PAD_LEFT);
                ?>	
                    <option value="<?=$ii?>" <?=$time1[0] == $ii ? "selected" : "" ?>><?=$i?>시</option>
                <?}?>
            </select>
            <input type="text" id="disp_push_time_1_1" placeholder="00시" class="input02" style="text-align:center;">
            <div style="position:absolute;top:22px;right:0.4%;width:5%;"><img src="/app_helper/images/arrow02.jpg" width="100%" />
        </div>
	</div>


	<div style="position:relative;float:left;margin-left:4.027%;width:42.711%;margin-top:15px;">
        <select name="push_time1_2" id="push_time1_2" onchange="mod_push1_time()" data-link="disp_push_time_1_2"  class="transparent_sltbox" >
            <option value="00" <?=$time1[1] == "00" ? "selected" : "" ?>>00 분</option>
            <option value="30" <?=$time1[1] == "30" ? "selected" : "" ?>>30 분</option>
        </select>
        <input type="text" id="disp_push_time_1_2" placeholder="00분" class="input02" style="text-align:center;">
		<div style="position:absolute;top:22px;right:0.4%;width:5%;"><img src="/app_helper/images/arrow02.jpg" width="100%" /></div>
	</div>




    <div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:40px;padding-bottom:7px;">전송시간2</div>
        <div style="position:relative;float:left;margin-left:4.027%;width:42.711%;margin-top:15px;">
            <select name="push_time2_1" id="push_time2_1" onchange="mod_push2_time()" data-link="disp_push_time_2_1" class="transparent_sltbox" >
                <?for($i = 1 ; $i <= 24 ; $i++) {
                    $ii = str_pad($i, 2, '0', STR_PAD_LEFT);
                ?>	
                    <option value="<?=$ii?>" <?=$time2[0] == $ii ? "selected" : "" ?>><?=$i?>시</option>
                <?}?>
            </select>
            <input type="text" id="disp_push_time_2_1" placeholder="00시" class="input02" style="text-align:center;">
            <div style="position:absolute;top:22px;right:0.4%;width:5%;"><img src="/app_helper/images/arrow02.jpg" width="100%" />
        </div>
	</div>


	<div style="position:relative;float:left;margin-left:4.027%;width:42.711%;margin-top:15px;">
        <select name="push_time2_2" id="push_time2_2" onchange="mod_push2_time()" data-link="disp_push_time_2_2"  class="transparent_sltbox" >
            <option value="00" <?=$time2[1] == "00" ? "selected" : "" ?>>00 분</option>
            <option value="30" <?=$time2[1] == "30" ? "selected" : "" ?>>30 분</option>
        </select>
        <input type="text" id="disp_push_time_2_2" placeholder="00분" class="input02" style="text-align:center;">
		<div style="position:absolute;top:22px;right:0.4%;width:5%;"><img src="/app_helper/images/arrow02.jpg" width="100%" /></div>
	</div>


</div>