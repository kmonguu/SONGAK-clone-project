<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<script>
var member_skin_path = "<?=$member_skin_path?>";
</script>
<script type="text/javascript" src="<?=$member_skin_path?>/ajax_register_form.jquery.js"></script>
<script type="text/javascript" src="<?=$g4[path]?>/js/md5.js"></script>
<script type="text/javascript" src="<?=$g4[path]?>/js/sideview.js"></script>


<style type="text/css">
.RegisterTable { border-top:2px solid #333; }
.RegisterTable > tbody > tr > th { height:36px; font-size:17px; color:#222; font-weight:500; text-align:left; padding:10px 0px 10px 25px; border-right:1px solid #c2c2c2; border-bottom:1px solid #c2c2c2; background:#fafafa; }
.RegisterTable > tbody > tr > th.th_required::before { content:"*"; display:inline; color:#ff0000; margin:0 3px 0 -12px; }
.RegisterTable > tbody > tr > td { font-size:17px; color:#222; font-weight:400; text-align:left; padding:10px; border-bottom:1px solid #c2c2c2; }

.RegisterTable > tbody > tr > td input.ed { width:230px; padding:3px 0 3px 10px; height:36px; font-size:17px; vertical-align:middle; }
.RegisterTable > tbody > tr > td input.ed.onlynumber { padding-left:0px; text-align:center; }

	.DesignSelect { min-width:100px; height:36px; border:1px solid #cfcfcf; font-size:17px; background:url("/img/select_arrow.png") no-repeat right 10px center; vertical-align:middle; }


.submit_btn { width:173px; height:55px; color:#fff; border:0px; background:#373737; font-size:20px; display:inline-block; }
.submit_btn2 { width:173px; height:55px; color:#353535; border:0px; background:#e5e5e5; font-size:20px; display:inline-block; margin-left:5px; }

.addr_table td { border-bottom:0px; padding-left:0px; }

#ui-datepicker-div { margin:3px 0 0 -100px; }
</style>


<div class="ShopCover" >

	<form id="fregisterform" name=fregisterform method=post onsubmit="return fregisterform_submit(this);" enctype="multipart/form-data" autocomplete="off" >
		<input type=hidden name=w                value="<?=$w?>">
		<input type=hidden name=url              value="<?=$urlencode?>">
		<input type=hidden name=mb_jumin         value="<?=$jumin?>">
		<input type=hidden name=mb_id_enabled    value="" id="mb_id_enabled">
		<input type=hidden name=mb_nick_enabled  value="" id="mb_nick_enabled">
		<input type=hidden name=mb_email_enabled value="" id="mb_email_enabled">
		<!-- <input type=hidden name=token value="<?=$token?>"> -->

		<? if ($member[mb_nick_date] > date("Y-m-d", $g4[server_time] - ($config[cf_nick_modify] * 86400))) { // 별명수정일이 지났다면 수정가능 ?>
			<input type=hidden name="mb_nick_default" value='<?=$member[mb_nick]?>'>
			<input type=hidden name="mb_nick" value="<?=$member[mb_nick]?>">
		<?}?>

		<? if ($member[mb_sex]) { ?>
			<input type=hidden name=mb_sex value='<?=$member[mb_sex]?>'>
		<? } ?>

		<input type=hidden name='old_email' value='<?=$member[mb_email]?>'>
		<input type=hidden name=mb_open value='' >

		<!-- ANTISPAM -->
		<input type=hidden name=bo_table value="register_form"/>



		<p style="color:#000; font-size:28px; padding:0px 0px 0px;">정보입력</p>
		<p style="color:#777; font-size:18px; font-weight:300; padding:0px 0px;">회원님의 개인정보를 안전하게 보호하고 있으며, 회원님의 명백한 동의 없이는 공개 또는 제3자에게 제공되지 않습니다.</p>


		<p style="color:#000; font-size:28px; padding:35px 0px 10px;">*필수 정보입력</p>
		<table width="100%" cellspacing="0" cellpadding="0" class="RegisterTable" >
			<caption>
				회원가입 필수 정보입력 - 
					이름, 
					<? if ($w=="") { ?>생년월일, <? } ?>
					아이디, 
					패스워드, 
					패스워드 확인, 
					<? if ($config[cf_use_hp]) { ?>핸드폰, <? } ?>
					이메일, 
					별명, 
					<? if ($g4["use_mb_sex"]) { ?>성별, <? } ?>
					<? if ($config["cf_use_homepage"]) { ?>홈페이지, <? } ?>
					<? if ($config["cf_use_tel"]) { ?>전화번호, <? } ?>
					<? if ($config["cf_use_addr"]) { ?>주소, <? } ?>
					보안코드로 구성
			</caption>
			<colgroup>
				<col width="25%" />
				<col width="" />
			</colgroup>

			<tbody>
				<tr>
					<th class="th_required" ><label for="mb_name" >이름</label></th>
					<td>
						<input type=text class="ed" name="mb_name" id="mb_name" itemname="이름" title="이름" value="<?=$member[mb_name]?>" data-required="required" <?=$member[mb_name] ? "readonly" : ""?> />
						<?/* if ($w=='') { echo "(공백없이 한글만 입력 가능)"; } */?>
					</td>
				</tr>

				<? 
				if ($w=="") { 
					$BirthType = "1";
				?>
					<tr>
						<th class="th_required" ><label for="<?=$BirthType == "1" ? "mb_birth" : "bir_year"?>" >생년월일</label></th>
						<td>
							<?
							if($BirthType == "1"){?>

								<input type=text name="mb_birth" id="mb_birth" class="ed calendar" data-required="required" itemname="생년월일" value="<?=$member["mb_birth"]?>" autocomplete="off" data-year-range="1900:<?=date("Y")?>" />

							<?}else if($BirthType == "2"){?>
							
								<input type="hidden" id="mb_birth" name="mb_birth" value="<?=$member["mb_birth"]?>" />

								<select id="bir_year" class="birth_select DesignSelect" alt="생일년도" title="생일년도" style="width:110px;" >
									<?for($y=date("Y", $g4['server_time']); $y>=1900; $y--){?>
										<option value="<?=$y?>"><?=$y?>년</option>
									<?}?>
								</select>
								
								<select id="bir_month" class="birth_select DesignSelect" alt="생일월" title="생일월" style="width:100px;" >
									<?for($m=1; $m<=12; $m++){?>
										<option value="<?=sprintf('%02d',$m);?>"><?=sprintf('%02d',$m);?>월</option>
									<?}?>
								</select>
								
								<select id="bir_day" class="birth_select DesignSelect" alt="생일일자" title="생일일자" style="width:100px;" >
									<?for($d=1; $d<=31; $d++){?>
										<option value="<?=sprintf('%02d',$d);?>"><?=sprintf('%02d',$d);?>일</option>
									<?}?>
								</select>

								<script>
								$(".birth_select").change(function(){
									$("#mb_birth").val( $("#bir_year").val() + "-" + $("#bir_month").val() + "-" + $("#bir_day").val() );
								});
								</script>

							<?}?>
						</td>
					</tr>
				<? } ?>

				<tr>
					<th class="th_required" ><label for="reg_mb_id" >아이디</label></th>
					<td>
						<input type=text name="mb_id" id='reg_mb_id' class="ed" maxlength=20 data-required="required" value="<?=$member[mb_id]?>" <? if ($w=='u') { echo "readonly style='background-color:#dddddd;'"; } ?> <? if ($w=='') { echo "onblur='reg_mb_id_check();'"; } ?> itemname="아이디" title="아이디" >
						<p><span id='msg_mb_id'> * 영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요.</span></p>
					</td>
				</tr>

				<tr style="<?=($member["mb_is_naver"] || $member["mb_is_kakao"] || $member["mb_is_facebook"])? "display:none" : "";?>" >
					<th class="th_required" ><label for="mb_password" >패스워드</label></th>
					<td>
						<input type="password" name="mb_password" id="mb_password" class="ed" maxlength=20 <?=($w=="") ? "data-required=\"required\"" : "";?> itemname="패스워드" title="패스워드" />
						<p>* 영문+숫자가 조합된 문자를 입력해 주세요. 최소 8자이상</p>
					</td>
				</tr>

				<tr style="<?=($member["mb_is_naver"] || $member["mb_is_kakao"] || $member["mb_is_facebook"])? "display:none" : "";?>" >
					<th class="th_required" ><label for="mb_password_re" >패스워드 확인</label></th>
					<td>
						<input type="password" name="mb_password_re" id="mb_password_re" class="ed" maxlength=20 <?=($w=="") ? "data-required=\"required\"" : "";?> itemname="패스워드 확인" title="패스워드 확인" >
						<p>* 비밀번호를 한번 더 입력해 주세요.</p>
					</td>
				</tr>


				<?
				//핸드폰 입력 사용하려면 환경설정에서 "핸드폰 입력" 체크 하세요
				if ($config[cf_use_hp]) { ?>
					<? 
						$mb_hp = str_replace("-", "",$member[mb_hp]);
						$mb_hp1 = substr($mb_hp, 0, 3);
						$mb_hp2 = substr($mb_hp, 3, 4);
						$mb_hp3 = substr($mb_hp, 7, 4);	
					?>

					<tr>
						<th <?if($config["cf_req_hp"]){?>class="th_required"<?}?> ><label for="hp1" >핸드폰</label></th>
						<td>
							<!--휴대폰 입력부 -->
							<select id="hp1" class="hp_input DesignSelect" <?=$config[cf_req_hp] ? 'data-required="required"' : '';?> style="width:100px;" itemname="핸드폰 앞자리" title="핸드폰 앞자리" >
								<option value="" selected="">선택</option>
								<option value="010">010</option>
								<option value="011">011</option>
								<option value="016">016</option>
								<option value="017">017</option>
								<option value="018">018</option>
								<option value="019">019</option>
							</select>
							-
							<input type="tel" pattern="\d*" id="hp2" class="ed onlynumber hp_input" maxlength=4 style="width:100px;" <?=$config[cf_req_hp] ? 'data-required="required"' : '';?> value="<?=$mb_hp2?>" itemname="핸드폰 중간 4자리" title="휴대폰 중간 번호 네자리" > -
							<input type="tel" pattern="\d*" id="hp3" class="ed onlynumber hp_input" maxlength=4 style="width:100px;" <?=$config[cf_req_hp] ? 'data-required="required"' : '';?> value="<?=$mb_hp3?>" itemname="핸드폰 마지막 4자리" title="휴대폰 마지막 번호 네자리" >

							<input type="hidden" name='mb_hp' id="mb_hp" class="ed" maxlength=20 <?=$config[cf_req_hp] ? 'data-required="required"' : '';?> itemname='핸드폰번호' value='<?=$member[mb_hp]?>' >
							
							
							<script>
								$(".hp_input").blur(function(){
									$("#mb_hp").val( $("#hp1").val() + "-" + $("#hp2").val() + "-" + $("#hp3").val() );
								});

								$("#hp1 > option[value='<?=$mb_hp1?>']").prop("selected", true);

								$(function(){
									$("#hp1").change(function(){
										$("#hp2").focus();
									});
									$("#hp2").bind("keyup",function(){
										if($(this).val().length >= 4){
											$(this).val( $(this).val().substring(0,4) );
											$("#hp3").focus();
										}
									});
									$("#hp3").bind("keyup",function(){
										if($(this).val().length >= 4){
											$(this).val( $(this).val().substring(0,4) );
										}
									});
								});
							</script>
							<!--휴대폰 입력부 끝 -->
						</td>
					</tr>

				<?}?>

				<tr>
					<th class="th_required" ><label for="email1" >이메일</label></th>
					<td>
						<!--이메일 입력부 -->
						<input type="hidden" name="mb_email" id="reg_mb_email" class="ed" maxlength=100 value="<?=$member[mb_email]?>" onblur="reg_mb_email_check()" >
					
						<?$email = explode("@", $member[mb_email]);?>
						<input type="text" name="email1" id="email1" class="ed" style="width:200px; margin-bottom:5px;" value="<?=$email[0]?>" data-required="required" itemname="이메일" title="이메일 아이디" > 
						@ 
						<input type="text" name="email2" id="email2" class="ed" style="width:230px;" value="<?=$email[1]?>" data-required="required" itemname="이메일" title="이메일 도메인(직접입력)" >

						<select id="email_selector" class="DesignSelect" style="width:160px; vertical-align:top;" title="이메일 도메인(선택)" >
							<option value="">선택</option>
							<option value="naver.com">naver.com</option>
							<option value="daum.net">daum.net</option>
							<option value="hanmail.net">hanmail.net</option>
							<option value="yahoo.co.kr">yahoo.co.kr</option>
							<option value="nate.com">nate.com</option>
							<option value="paran.com">paran.com</option>
							<option value="hotmail.com">hotmail.com</option>
							<option value="direct">직접입력</option>
						</select>
						<p><span id='msg_mb_email'><?=$w == "" ? "* 회원가입 완료 후, 정보수정 페이지에서 변경이 가능합니다." : ""?></span></p>

						<script type="text/javascript">
						$(function(){
							// 아래 값이 0이면 주소입력칸이 계속 나오고 1이면 주소입력칸 안나옴.
							<?if($w == "u"){?>
								var email2_hide = 0;
								$("#email_selector").val("direct");
							<?} else {?>
								var email2_hide = 1;
							<?}?>


							if(email2_hide == 1)
								$("#email2").hide();


							$("#email_selector").change(function(){
								if($(this).val() == 'direct'){
									$("#email2").val("").show().focus();
								}else{

									if(email2_hide == 1)
										$("#email2").val($(this).val()).hide();
									else
										$("#email2").val($(this).val());

								}
							});


							$("#email2, #email1").bind("blur",function(){
								var em = $("#email1").val().split("@");
								var email1 = em[0];
								$("#email1").val(email1);
								if(em.length > 1) {
										$("#email_selector").val(em[1]);
										if($("#email_selector").val() == null || $("#email_selector").val() === undefined || $("#email_selector").val() == ""){
											$("#email_selector").val("direct").change();
										} else {
											$("#email_selector").change();
										}
										$("#email2").val(em[1]);
										
								}
								$("#reg_mb_email").val( email1 + "@" + $("#email2").val() ).trigger('blur');
							});

							$("#email_selector").bind("blur",function(){
								$("#email2").trigger("blur");
							});
						});
						</script>

						<!--이메일 입력부 끝 -->
						<? if ($config[cf_use_email_certify]) { ?>
							<? if ($w=='') { echo "<p>e-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다.</p>"; } ?>
							<? if ($w=='u') { echo "<p>e-mail 주소를 변경하시면 다시 인증하셔야 합니다.</p>"; } ?>
						<? } ?>
					</td>
				</tr>

				<tr>
					<th class="th_required" ><label for="reg_mb_nick" >별명</label></th>
					<td>
						<input type=hidden name="mb_nick_default" value="<?=$member[mb_nick]?>" >
						<input type="text" name="mb_nick" id="reg_mb_nick" class="ed" maxlength=20 value="<?=$member[mb_nick]?>" data-required="required" onblur="reg_mb_nick_check();" itemname="별명" title="별명" >
						
						<p id='msg_mb_nick'></p>
						한글, 영문, 숫자만 입력 가능 (한글2자, 영문4자 이상)
						<br>별명을 바꾸시면 앞으로 <?=(int)$config[cf_nick_modify]?>일 이내에는 변경 할 수 없습니다.
					</td>
				</tr>


				<? //성별사용시 /config.php => "use_mb_sex" true로 변경  ?>
				<?if($g4["use_mb_sex"]){?>
					<tr>
						<th class="th_required" >성별</th>
						<td>
							<label><input type="radio" name="mb_sex" id="mb_sex_m" value="M" itemname="성별" checked > 남자</label>
							<label><input type="radio" name="mb_sex" id="mb_sex_f" value="F" itemname="성별" > 여자</label>
							<script type="text/javascript">//document.getElementById('mb_sex').value='<?=$member[mb_sex]?>';</script>
						</td>
					</tr>
				 <?} ?>


				<? 
				//홈페이지 사용 하려면 관리자 환경설정에서 "홈페이지 입력" 체크 하세요
				if ($config[cf_use_homepage]) { ?>
					<tr>
						<th <?if($config["cf_req_homepage"]){?>class="th_required"<?}?> ><label for="mb_homepage" >홈페이지</label></th>
						<td>
							<input type="text" name="mb_homepage" id="mb_homepage" class="ed" value="<?=$member[mb_homepage]?>" <?=$config[cf_req_homepage] ? 'data-required="required"' : '';?> itemname="홈페이지" title="홈페이지" >
						</td>
					</tr>
				<? } ?>

				<?
				//전화번호 사용 하려면 관리자 환경설정에서 "전화번호 입력" 체크 하세요
				if ($config[cf_use_tel]) { ?>
					<tr>
						<th <?if($config["cf_req_tel"]){?>class="th_required"<?}?> ><label for="mb_tel" >전화번호</label></th>
						<td>
							<input type="tel" pattern="\d*" name="mb_tel" id="mb_tel" class="ed phonenum" value="<?=$member[mb_tel]?>" <?=$config[cf_req_tel] ? 'data-required="required"' : '';?> itemname="전화번호" title="전화번호" >
						</td>
					</tr>
				<? } ?>


				<?
				//주소 표시 시 관리자 환경설정에서 "주소 입력" 체크 할 것
				if ($config[cf_use_addr]) {  ?>
					<tr>
						<th <?if($config["cf_req_addr"]){?>class="th_required"<?}?> >주소</th>
						<td>
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="addr_table" >
								<tr>
									<td>
										<input type="text" name="mb_zip1" id="mb_zip1" class="ed" value="<?=$member[mb_zip1]?>" style="width:80px; text-align:center; padding-left:0px;" maxlength=5 readonly <?=$config[cf_req_addr] ? 'data-required="required"' : '';?> itemname="우편번호" title="우편번호" >
										&nbsp;
										<a href="#addrOpen" onclick="openDaumPostcode('fregisterform', 'mb_zip1', 'mb_addr1', 'mb_addr2');" >
											<span class='btn1' style="padding:5px 10px 6px; vertical-align:top;" >우편번호검색</span>
										</a>
									</td>
								</tr>
								<tr>
									<td style="padding:5px 0;" >
										<input type="text" name="mb_addr1" id="mb_addr1" class="ed" style="width:100%;" value="<?=$member["mb_addr1"]?>" readonly <?=$config[cf_req_addr] ? 'data-required="required"' : '';?> itemname='주소' title="주소" >
									</td>
								</tr>
								<tr>
									<td>
										<input type="text" name="mb_addr2" id="mb_addr2" class="ed" style="width:100%;" value="<?=$member["mb_addr2"]?>" itemname='상세주소' title="상세주소" >
									</td>
								</tr>
							</table>
						</td>
					</tr>
				<? } ?>


				<tr>
					<th class="th_required" ><label for="wr_key" >보안코드</label></th>
					<td>
						<img id='kcaptcha_image' style="vertical-align:middle;" alt="" />
						<input type="text" name="wr_key" id="wr_key" class="ed" style="margin-left:5px;" data-required="required" itemname="자동등록방지" title="자동등록방지" >
						<p>* 위의 보안코드 문자를 입력해 주세요.</p>
					</td>
				</tr>

			</tbody>

		</table>



		<p style="color:#000000; font-size:28px; padding:35px 0px 10px;">선택 정보입력(알림설정)</p>

		<table width="100%" cellspacing="0" cellpadding="0" class="RegisterTable" >
			<caption>
				회원가입 선택 정보입력 - 
					<? if ($config[cf_use_signature]) { ?>서명, <? } ?>
					<? if ($member[mb_level] >= $config[cf_icon_level]) { ?>회원아이콘, <? } ?>
					메일링 서비스, 
					SMS 수신여부로 구성
			</caption>
			<colgroup>
				<col width="25%" />
				<col width="" />
			</colgroup>

			<tbody>
				<? 
				//서명 사용 하려면 관리자 환경설정에서 "서명 입력" 체크 하세요
				if ($config[cf_use_signature]) { ?>
					<tr>
						<th <?if($config["cf_req_signature"]){?>class="th_required"<?}?> ><label for="mb_signature" >서명</label></th>
						<td>
							<textarea name="mb_signature" id="mb_signature" class="tx" rows=3 style="width:95%;" <?=$config[cf_req_signature] ? 'data-required="required"' : '';?> itemname="서명" title="서명" ><?=$member["mb_signature"]?></textarea>
						</td>
					</tr>
				<? } ?>

				<?
				//자기소개 사용 하려면 관리자 환경설정에서 "자기소개 입력" 체크 하세요
				?>
				<tr id="reg_profile" <? if (!$config["cf_use_profile"]) { ?>style="display:none;"<?}?> >
					<th <?if($config["cf_req_profile"]){?>class="th_required"<?}?> ><label for="mb_profile" >자기소개</label></th>
					<td>
						<textarea name="mb_profile" id="mb_profile" class="tx" rows=3 style="width:95%;" <?=$config[cf_req_profile] ? 'data-required="required"' : '';?> itemname="자기소개" title="자기소개" ><?=$member["mb_profile"]?></textarea>
					</td>
				</tr>
			

				<? if ($member[mb_level] >= $config[cf_icon_level]) { ?>
					<tr>
						<th <?if($config["cf_req_signature"]){?>class="th_required"<?}?> ><label for="mb_icon">회원아이콘</label></th>
						<td>
							<div>
								<INPUT type="file" name="mb_icon" id="mb_icon" class="file_input" >
								<p>
									용량:<?=sprintf("%2.1f", $config[cf_member_icon_size]/1024/1024)?>메가바이트 이하 gif또는 jpg 이미지만 등록됩니다.
									<br/>
									크기: 가로:<?=$config[cf_member_icon_width]?>px, 세로:<?=$config[cf_member_icon_width]?>px 이하 이미지만 등록됩니다.
								</p>
							</div>

							<? if ($w == "u" && file_exists($mb_icon)) { ?>
								<br>
								<img src='<?=$mb_icon?>' style="max-width:200px; height:auto; margin:10px;" alt="회원 아이콘" >
								<input type=checkbox name='del_mb_icon' id="del_mb_icon" value='1' ><label for="del_mb_icon" >삭제</label>
							<? } ?>
						</td>
					</tr>
				<? } ?>

				<tr>
					<th>메일링<br>서비스</th>
					<td>
						<input type="checkbox" name="mb_mailling" id="mb_mailling" value="1" <?=($w=='' || $member[mb_mailling]) ? 'checked' : '';?> />
						<label for="mb_mailling" >소식 및 정보를 이메일로 받겠습니다.</label>
					</td>
				</tr>

				<tr>
					<th>SMS<br>수신여부</th>
					<td>
						<input type="checkbox" name="mb_sms" id="mb_sms" value="1" <?=($w=='' || $member[mb_sms]) ? 'checked' : '';?> />
						<label for="mb_sms" >소식 및 정보를 sms로 받겠습니다.</label>
					</td>
				</tr>


				<? if ($w == "" && $config[cf_use_recommend]) { ?>
					<tr>
						<th>추천인아이디</th>
						<td>
							<input type="text" name="mb_recommend" id="mb_recommend" class="ed" value="" itemname="추천인아이디" title="추천인아이디" />
						</td>
					</tr>
				<? } ?>
			</tbody>
		</table>

		<?if($w=="u"){?>
			<div style="display:inline-block; width:100%; box-sizing:border-box; padding:20px 20px 0;">
				<span class="btn1-o" style="float:left;" onclick="member_leave()" >회원탈퇴</span>
			</div>
		<?}?>

		<div style="padding-top:30px; text-align:center;">
			<input type="submit" value="확인" class="submit_btn" accesskey='s' />
			<input type="button" value="취소" class="submit_btn2" onclick="check_cancel()" />
		</div>


	</form>

</div>

<script type="text/javascript">
function member_leave(){
    if (confirm("정말 회원에서 탈퇴 하시겠습니까?"))
            location.href = "/m/bbs/member_confirm.php?url=member_leave.php";
}

function check_cancel(){
	if( confirm("취소하시겠습니까? 입력한 정보는 저장되지 않습니다.") ){
		home();
	}
}
</script>

<script type="text/javascript" src="<?="$g4[path]/js/jquery.kcaptcha.js"?>"></script>
<script type="text/javascript">

$(function() {
    // 폼의 첫번째 입력박스에 포커스 주기
    $("#fregisterform :input[type=text]:visible:enabled:first").focus();
});

// submit 최종 폼체크
function fregisterform_submit(f)
{

	
	var req_valid = true;
	$("[data-required='required']").each(function(){
		if($(this).val() == "") {
			alert($(this).attr("itemname")+"은(는) 반드시 입력해야합니다.");
			req_valid = false;
			$(this).focus();
			return false;
		}
	});
	if(!req_valid) return false;


    // 회원아이디 검사
    if (f.w.value == "") {

        reg_mb_id_check();

        if (document.getElementById('mb_id_enabled').value!='000') {
            alert('회원아이디를 입력하지 않았거나 입력에 오류가 있습니다.');
            document.getElementById('reg_mb_id').select();
            return false;
        }
    }

    if (f.w.value == '') {
        if (f.mb_password.value.length < 8) {
            alert('패스워드를 8글자 이상 입력하십시오.');
            f.mb_password.focus();
            return false;
        }
    }

    if (f.mb_password.value != f.mb_password_re.value) {
        alert('패스워드가 같지 않습니다.');
        f.mb_password_re.focus();
        return false;
    }

    if (f.mb_password.value.length > 0) {
        if (f.mb_password_re.value.length < 8) {
            alert('패스워드를 8글자 이상 입력하십시오.');
            f.mb_password_re.focus();
            return false;
        }
    }

	
	 var pw = f.mb_password.value;
	 var num = pw.search(/[0-9]/g);
	 var eng = pw.search(/[a-z]/ig);
	 //var spe = pw.search(/[`~!@@#$%^&*|₩₩₩'₩";:₩/?]/gi);

	if (f.w.value == '' || pw.length > 0) {
	 if(pw.length < 8 || pw.length > 20){

		alert("패스워드를 8자리 ~ 20자리 이내로 입력해주세요.");
		f.mb_password.focus();
		return false;

	 }

	 if(pw.search(/₩s/) != -1){

		  alert("패스워드는 공백없이 입력해주세요.");
		f.mb_password.focus();
		  return false;

	 }
	 
	 //if(num < 0 || eng < 0 || spe < 0 ){
	 if(num < 0 || eng < 0 ){

		//alert("패스워드는 영문,숫자, 특수문자를 혼합하여 입력해주세요.");
		alert("패스워드는 영문,숫자를 혼합하여 입력해주세요.");
		f.mb_password.focus();
		return false;

	 }
	}

    /*
    if (f.mb_password_q.value.length < 1) {
        alert('패스워드 분실시 질문을 선택하거나 입력하십시오.');
        f.mb_password_q.focus();
        return false;
    }

    if (f.mb_password_a.value.length < 1) {
        alert('패스워드 분실시 답변을 입력하십시오.');
        f.mb_password_a.focus();
        return false;
    }
    */

    // 이름 검사
    if (f.w.value=='') {
        if (f.mb_name.value.length < 1) {
            alert('이름을 입력하십시오.');
            f.mb_name.focus();
            return false;
        }

        var pattern = /([^가-힣\x20])/i;
        if (pattern.test(f.mb_name.value)) {
            alert('이름은 한글로 입력하십시오.');
            f.mb_name.focus();
            return false;
        }
    }

    // 별명 검사
	/*
    if ((f.w.value == "") ||
        (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {

        reg_mb_nick_check();

        if (document.getElementById('mb_nick_enabled').value!='000') {
            alert('별명을 입력하지 않았거나 입력에 오류가 있습니다.');
            document.getElementById('reg_mb_nick').select();
            return false;
        }
    }
	*/

    // E-mail 검사
    if ((f.w.value == "") ||
        (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {

        reg_mb_email_check();

        if (document.getElementById('mb_email_enabled').value!='000') {
            alert('E-mail을 입력하지 않았거나 입력에 오류가 있습니다.');
            document.getElementById('reg_mb_email').select();
            return false;
        }

        // 사용할 수 없는 E-mail 도메인
        var domain = prohibit_email_check(f.mb_email.value);
        if (domain) {
            alert("'"+domain+"'은(는) 사용하실 수 없는 메일입니다.");
            document.getElementById('reg_mb_email').focus();
            return false;
        }
    }

    if (typeof(f.mb_birth) != 'undefined') {
        if (f.mb_birth.value.length < 1) {
            alert('생일을 입력하여 주십시오.');
            //f.mb_birth.focus();
            return false;
        }

        var todays = <?=date("Ymd", $g4['server_time']);?>;
        // 오늘날짜에서 생일을 빼고 거기서 140000 을 뺀다.
        // 결과가 0 이상의 양수이면 만 14세가 지난것임
		var birthday = f.mb_birth.value.replace(/-/gi, "");
        var n = todays - parseInt(birthday) - 140000;
        if (n < 0) {

			if(f.mb_profile.value.length < 1){
				alert("만 14세가 지나지 않은 어린이는 정보통신망 이용촉진 및 정보보호 등에 관한 법률\n\n제 31조 1항의 규정에 의하여 법정대리인의 동의를 얻어야 하므로\n\n법정대리인의 이름과 연락처를 '자기소개'란에 별도로 입력하시기 바랍니다.");

				$("#reg_profile").show();
				return false;
			}
        }
    }

    if (typeof(f.mb_sex) != 'undefined') {
        if (f.mb_sex.value == '') {
            alert('성별을 선택하여 주십시오.');
            f.mb_sex.focus();
            return false;
        }
    }

    if (typeof f.mb_icon != 'undefined') {
        if (f.mb_icon.value) {
            if (!f.mb_icon.value.toLowerCase().match(/.(gif|jpg|jpeg)$/i)) {
                alert('회원아이콘이 jpg 또는 gif 파일이 아닙니다.');
                f.mb_icon.focus();
                return false;
            }
        }
    }

    if (typeof(f.mb_recommend) != 'undefined') {
        if (f.mb_id.value == f.mb_recommend.value) {
            alert('본인을 추천할 수 없습니다.');
            f.mb_recommend.focus();
            return false;
        }
    }

    if (!check_kcaptcha(f.wr_key)) {
        return false;
    }

    <?
   
	if ($g4[https_url])
        echo "f.action = '$g4[https_url]/$g4[bbs]/register_form_update.php';";
    else
        echo "f.action = './register_form_update.php';";
	
    ?>

    // 보안인증관련 코드로 반드시 포함되어야 합니다.
    set_cookie("<?=md5($token)?>", "<?=base64_encode($token)?>", 1, "<?=$g4['cookie_domain']?>");

    return true;
}

// 금지 메일 도메인 검사
function prohibit_email_check(email)
{
    email = email.toLowerCase();

    var prohibit_email = "<?=trim(strtolower(preg_replace("/(\r\n|\r|\n)/", ",", $config[cf_prohibit_email])));?>";
    var s = prohibit_email.split(",");
    var tmp = email.split("@");
    var domain = tmp[tmp.length - 1]; // 메일 도메인만 얻는다

    for (i=0; i<s.length; i++) {
        if (s[i] == domain)
            return domain;
    }
    return "";
}


</script>
