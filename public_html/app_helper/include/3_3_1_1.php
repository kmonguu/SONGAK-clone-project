<?
    $obj = new HpModifyReq();

    if($w == "u") {
        
        $write = $obj->get_modify_view($_GET["wr_id"]);

        if (strstr($write["wr_option"], "secret")) {
            $secret_checked = "checked";
        }

    } else {

        $write["wr_name"] = $config["cf_title"];

    }
?>

<form id="mform" name="mform" method="post" enctype="multipart/form-data">
    
    <input type="hidden" name="return_url" value="<?=$_SERVER[HTTP_HOST]?><?=$_SERVER[PHP_SELF]?>?p=3_2_1_1&wr_id="/>
    <input type="hidden" name="wr_id" value="<?=$write["wr_id"]?>"/>
    <input type="hidden" name="wr_7" value="<?=$write["wr_7"] ? $write["wr_7"] : "1"?>"/>
    <input type="hidden" name="sitekey" value="<?=$sitekey?>" />
    <input type="hidden" name="w" value="<?=$w?>" />
    
    <div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;">수정의뢰 글쓰기</div>
    <div class="nbox" style="padding-top:0;">
        <div style="float:left;width:100%;height:100px;background:#f2f2f2;">
            <div style="float:left;margin:20px 0 0 0;"><img src="/app_helper/images/mo_text.jpg" style="width:100%"/></div>
        </div>
        <div style="float:left;width:100%;">
            <div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:28px;width:20%;">업체명</div>
            <div style="position:relative;float:left;width:67.5%;margin-top:20px;">
                <input type="text" class="input02" name="wr_name" id="wr_name" value="<?=$write["wr_name"]?>" required >
            </div>
        </div>
        <div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
        <div style="float:left;width:100%;">
            <div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;width:20%;margin-top:8px;">패스워드</div>
            <div style="position:relative;float:left;width:67.5%;">
                <input type="password" class="input02" <?=$w == "" ? "required" : ""?> id="wr_password" name="wr_password" value="" autocomplete="new-password" />
            </div>
        </div>

        <div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
        <div style="float:left;width:100%;">
            <div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;width:20%;margin-top:1px;">비밀글</div>
            <div style="position:relative;float:left;width:6.36%;">
                <input type="checkbox" class="transparent_chkbox" id="secret" name="secret" <?=$secret_checked ? "checked" : ""?> data-link="disp_secret" data-onimg="<?=$g4["mpath"]?>/images/check_on.jpg" data-offimg="<?=$g4["mpath"]?>/images/check.jpg" value="secret" onchange="$(this).is(':checked') ? $('#div_secret').css('color','#ff4f00') : $('#div_secret').css('color', '#777777');">
                <img src="<?=$g4["mpath"]?>/images/check.jpg" id="disp_secret" style="width:100%"/>
            </div>
            <div style="position:relative;float:left;width:50.36%;color:<?=$secret_checked ? "#ff4f00" : "#777777"?>;font-size:26px;" id="div_secret">&nbsp;&nbsp;<label for="secret">비밀글로 작성하기</label></div>
        </div>

        <div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>


        <div style="float:left;width:100%;">
            <div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;width:20%;margin-top:8px;">연락처</div>
            <div style="position:relative;float:left;width:67.5%;">
                <input type="tel" class="input02 phonenum" name="wr_4" id="wr_4" value="<?=$write["wr_4"]?>" required >
            </div>
        </div>


        <div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
        <div style="float:left;width:100%;">
            <div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:8px;width:20%;">제목</div>
            <div style="position:relative;float:left;width:67.5%;">
                <input type="text" class="input02" name="wr_subject" id="wr_subject" value="<?=$write["wr_subject"]?>">
            </div>
        </div>
        <div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
        <div style="float:left;width:100%;">
            <div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:28px;width:20%;">수정내용</div>
            <div style="position:relative;float:left;width:67.5%;">
                <textarea class="textarea01" rows="10" id="wr_content" name="wr_content"><?=$write["wr_content"]?></textarea>
            </div>
        </div>

        <?/* 수정하기를 막을거라서 이부분 수정은 작업하지 않음, 추후 작업시 참고 */?>
        <div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
        <div style="float:left;width:100%;">
            <div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:8px;width:20%;">파일첨부1</div>
            <div style="position:relative;float:left;width:67.5%;"><input type="file" name="bf_file[]" class="input02" ></div>
        </div>
        <div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
        <div style="float:left;width:100%;">
            <div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:8px;width:20%;">파일첨부2</div>
            <div style="position:relative;float:left;width:67.5%;"><input type="file" name="bf_file[]" class="input02" ></div>
        </div>

        
        <div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
        <div style="float:left;width:100%;">
            <div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:28px;width:20%;"></div>
            <div style="position:relative;float:left;width:67.5%;color:#212121;font-size:22px;">회사규정상 <span style="color:#ff4f00;">한달 3번의 수정건이 무상</span>으로 지원이 됩니다.<br/><strong>페이지 추가나 소요시간이 길어질 때에는<br/>유료수정</strong>이 되며 담당자가 따로 연락을 드립니다.<br/><br/>※ <strong>유료수정건 작업시에는 입금이 확인되어야 수정작업이 진행되오니 이 점 참고해주시기 바랍니다.</strong></div>
        </div>
        <div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
        <div style="float:left;width:100%;margin-top:10px;">
            <div style="float:left;width:20.786%;margin-left:27%;"><a href="javascript:void(0);" onclick="go_submit()"><img src="/app_helper/images/write_btn3.jpg" style="width:100%"/></a></div>
            <div style="float:left;width:23.449%;margin-left:3%;"><a href="javascript:menum('menu03-1');" ><img src="/app_helper/images/list_btn.jpg" style="width:100%"/></a></div>
        </div>
    </div>

</form>


<script>

    try {
        var wr_name = window.localStorage.getItem("modify_req_wr_name");
        if(wr_name) {
            $("#wr_name").val(wr_name);
        }
    } catch(ex) {
        //Don't care
    }
    

    function go_submit(){
		
		if($("#wr_name").val() == ""){
			toast("업체명을 입력해주세요", 2000, "center");
			$("#wr_name").focus();
			return;
		}
		<?if($w==""){?>
			if($("#wr_password").val() == ""){
				toast("패스워드를 입력해주세요", 2000, "center");
				$("#wr_password").focus();
				return;
			}
		<?}?>
		if($("#wr_4").val() == ""){
			toast("연락처를 입력해주세요", 2000, "center");
			$("#wr_4").focus();
			return;
		}
		if($("#wr_subject").val() == ""){
			toast("제목을 입력해주세요", 2000, "center");
			$("#wr_subject").focus();
			return;
		}
		if($("#wr_content").val() == ""){
			toast("수정내용을 입력해주세요", 2000, "center");
			$("#wr_content").focus();
			return;
		}

    
        <?if($w == ""){?>
            if(!confirm("등록하시겠습니까?")) {return;}
        <?} else {?>
            if(!confirm("수정하시겠습니까?")) {return;}
        <?}?>
                    
        document.mform.action = 'http://it9.co.kr/api/helper/insert_modify_req.php';
        

        //업체명 저장
        window.localStorage.setItem("modify_req_wr_name", $("#wr_name").val());
        
        showProgress();
        $("#mform").submit();
        
    }
</script>