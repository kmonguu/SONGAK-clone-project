<?
include_once("./_common.php");
?>



<style>
.nbox {float:left;width:93.88%;background:#fff;border-radius:15px;box-shadow:2px 2px 5px rgba(0,0,0,0.4);padding:9px 0 40px 0;margin:20px 0 20px 3.05%;overflow:hidden;}
.nbox > ul {list-style:none;margin:0;padding:0}
.nbox > ul > li {float:left;margin:0;padding:0}
.nbox > ul > li:nth-child(even){background:#f7f5f8}
.nboxli {width:100%;height:175px;}
.nboxli2 {position:relative;float:left;width:100%;height:175px;}
.nboxli2 span.Simg {position:absolute;top:26%;left:7.396%;width:13.609%;}
.nboxli2 span.Re {position:absolute;top:63%;left:63%;width:12.721%;}
.nboxli2 span.Tit {position:absolute;top:16%;left:25%;color:#2e2e2e;font-size:26px;width:65%;}
.nboxli2 span.Con {position:absolute;top:38%;left:25%;color:#717171;font-size:24px;width:65%;}
.nboxli2 span.Date {position:absolute;top:60%;left:25%;color:#717171;font-size:22px;width:65%;}
.nboxli2 span.Point {position:absolute;top:47%;right:7.248%;}
.nboxlidiv1 {width:88.6%;height:91px;margin:0 auto;color:#222222;font-size:29px;line-height:101px;position:relative}
.listpoint {width:1.1%;height:9px;float:right;margin-top:47px;}
.nboxlibar {width:88.6%;height:1px;border-top:2px dotted #d9d9d9;margin:0 auto}

.nboxlidiv2 {width:88.6%;height:82px;margin:0 auto;color:#676767;font-size:23px;line-height:82px;position:relative}

.nlist {width:88.6%;height:175px;margin:0 auto;}
.nlist1 {width:88.6%;height:175px;margin:0 auto;background:#f7f5f8}

.nbox1 {float:left;width:100%;}
.nbox1 > ul {list-style:none;margin:0;padding:0}
.nbox1 > ul > li {float:left;margin:0;padding:0;height:175px;}
.nbox1 > ul > li:nth-child(even){background:#f7f5f8}
.nboxlidiv2text {font-size:20px;color:#999999;float:right}

.tab {float:left;width:90.13%;margin-left:6%;}
.tab > ul {list-style:none;margin:5px 0 25px 0;padding:0}
.tab > ul > li {float:left;margin:0 0 20px 1.38%;padding:0 6.18%;height:51px;border:1px solid #d7d7d7;background:#f8f8f8;color:#282828;font-size:24px;line-height:53px}
.tab > ul > li:first-child {margin:0}
.tab > ul > li.on {background:#ff4f00;color:#fff;border:1px solid #de4500;}

.tab2 {float:left;width:90.13%;}
.tab2 > ul {list-style:none;margin:25px 0 0 24%;padding:0}
.tab2 > ul > li {float:left;margin:0 0 20px 1.38%;padding:0;height:51px;color:#7a7a7a;font-size:28px;line-height:53px}
.tab2 > ul > li:first-child {margin:0}
.tab2 > ul > li.on {color:#ff4f00;border-top:1px solid #ff4f00;}

.naver {width:16.97%;height:26px;display:inline-block;margin-top:30px}
.daum {width:8.63%;height:20px;display:inline-block;margin-top:33px}
.google {width:13.63%;height:20px;display:inline-block;margin-top:33px}


.input01 {border:1px solid #e03229;border-radius:8px;color:#e03229;padding:2.5%;font-size:26px;width:100%;}
.input02 {border:1px solid #bdbdbd;border-radius:8px;color:#484848;padding:2.5%;font-size:26px;width:100%;}
.input03 {border:1px solid #bdbdbd;border-radius:8px;color:#484848;padding:4.4% 95.5% 4.4% 0;text-align:right;font-size:26px;width:100%;}
.input04 {border:1px solid #bdbdbd;border-radius:8px;color:#484848;padding:5%;font-size:26px;width:100%;}
.input05 {border:1px solid #bdbdbd;border-radius:8px;color:#484848;padding:2.5%;font-size:26px;width:100%;background:#f7f7f7;}

.textarea01 {border:1px solid #bdbdbd;border-radius:8px;color:#484848;padding:2.5%;font-size:26px;width:100%;}
</style>

<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;">수정의뢰 글쓰기</div>
<div class="nbox" style="padding-top:0;">
	<div style="float:left;width:100%;height:100px;background:#f2f2f2;">
		<div style="float:left;margin:20px 0 0 0;"><img src="/app_helper/images/mo_text.jpg" style="width:100%"/></div>
	</div>
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:28px;width:20%;">업체명</div>
		<div style="position:relative;float:left;width:67.5%;margin-top:20px;"><input type="text" class="input02" ></div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;width:20%;margin-top:8px;">패스워드</div>
		<div style="position:relative;float:left;width:67.5%;"><input type="text" class="input02" ></div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;width:20%;margin-top:1px;">비밀글</div>
		<div style="position:relative;float:left;width:6.36%;"><img src="/app_helper/images/check_on.jpg" style="width:100%"/></div>
		<div style="position:relative;float:left;width:50.36%;color:#ff4f00;font-size:26px;">&nbsp;&nbsp;비밀글로 작성하기</div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;width:20%;margin-top:8px;">연락처</div>
		<div style="position:relative;float:left;width:19%;"><input type="text" class="input02" style="height:45px;"></div>
		<div style="float:left;font-size:26px;width:6%;color:#000000;">&nbsp;&nbsp;&nbsp;-</div>
		<div style="position:relative;float:left;width:19.5%;"><input type="text" class="input02" style="height:45px;"></div>
		<div style="float:left;font-size:26px;width:6%;color:#000000;">&nbsp;&nbsp;&nbsp;-</div>
		<div style="position:relative;float:left;width:19.5%;"><input type="text" class="input02" style="height:45px;"></div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:8px;width:20%;">제목</div>
		<div style="position:relative;float:left;width:67.5%;"><input type="text" class="input02" ></div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:28px;width:20%;">수정내용</div>
		<div style="position:relative;float:left;width:67.5%;"><textarea class="textarea01" rows="4"></textarea></div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:8px;width:20%;">파일첨부1</div>
		<div style="position:relative;float:left;width:67.5%;"><input type="file" class="input02" ></div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:8px;width:20%;">파일첨부2</div>
		<div style="position:relative;float:left;width:67.5%;"><input type="file" class="input02" ></div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:28px;width:20%;"></div>
		<div style="position:relative;float:left;width:67.5%;color:#212121;font-size:22px;">회사규정상 <span style="color:#ff4f00;">한달 3번의 수정건이 무상</span>으로 지원이 됩니다.<br/><strong>페이지 추가나 소요시간이 길어질 때에는<br/>유료수정</strong>이 되며 담당자가 따로 연락을 드립니다.<br/><br/>※ <strong>유료수정건 작업시에는 입금이 확인되어야 수정작업이 진행되오니 이 점 참고해주시기 바랍니다.</strong></div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;margin-top:10px;">
		<div style="float:left;width:20.786%;margin-left:27%;"><a href="#"><img src="/app_helper/images/write_btn.jpg" style="width:100%"/></a></div>
		<div style="float:left;width:23.449%;margin-left:3%;"><a href="#"><img src="/app_helper/images/list_btn.jpg" style="width:100%"/></a></div>
	</div>
</div>

<!-- 채팅창 리스트
<div style="float:left;width:100%;background:#d8d8d8;padding:20px 0;">		
	<div style="position:relative;float:left;width:87.5%;margin-left:3.994%;"><input type="text" placeholder="참여자 이름, 대화 내용 검색" class="input02" ></div>
</div>
<div class="nbox" style="padding-bottom:0;margin-top:25px;">
	<ul>
		<li class="nboxli2">
			<span class="Simg"><img src="/app_helper/images/yes_m.png" style="width:100%"/></span>	
			<span class="Tit"><strong>손님999</strong></span>
			<span class="Con">안녕하세요. 문의드릴 사항이 있습니다.</span>
			<span class="Date">2017-11-02 16:11:49</span>
			<span class="Point"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
		</li>
		<div style="float:left;width:100%;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
		<li class="nboxli2">
			<span class="Simg"><img src="/app_helper/images/no_m.png" style="width:100%"/></span>	
			<span class="Tit"><strong>손님999</strong></span>
			<span class="Con">안녕하세요. 문의드릴 사항이 있습니다.</span>
			<span class="Date">2017-11-02 16:11:49</span>
			<span class="Point"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
		</li>
		<div style="float:left;width:100%;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
		<li class="nboxli2">
			<span class="Simg"><img src="/app_helper/images/yes_m.png" style="width:100%"/></span>	
			<span class="Tit"><strong>손님999</strong></span>
			<span class="Con">안녕하세요. 문의드릴 사항이 있습니다.</span>
			<span class="Date">2017-11-02 16:11:49</span>
			<span class="Point"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
		</li>
	</ul>	
	<div style="float:left;width:100%;height:70px;background:#f5f5f5;border-top:1px solid #dbdbdb;">
		<div style="float:left;width:20.118%;margin-left:42%;"><img src="/app_helper/images/more_bt.jpg?2" style="width:100%"/></div>
	</div>
</div>
-->

<!-- 접속자 알람 설정
<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;">접속자 알람 설정</div>
<div class="nbox">
	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:20px;padding-bottom:7px;">접속자 분석기 알림 전송받기</div>
	<div style="float:left;border:1px solid #c3c3c3;border-radius:8px;color:#3f3f3f;padding:2.5%;font-size:26px;width:87.011%;margin-left:3.994%;margin-top:20px;">
		<div style="position:relative;float:left;width:16.124%;"><img src="/app_helper/images/s_on.jpg" style="width:100%"/></div>
	</div>	
	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:40px;padding-bottom:7px;">전송시간1</div>
	<div style="position:relative;float:left;margin-left:4.027%;width:42.711%;margin-top:15px;"><input type="text" placeholder="12시" class="input02" style="text-align:center;">
		<div style="position:absolute;top:22px;right:0.4%;width:5%;"><img src="/app_helper/images/arrow02.jpg" width="100%" /></div>
	</div>
	<div style="position:relative;float:left;margin-left:4.027%;width:42.711%;margin-top:15px;"><input type="text" placeholder="30분" class="input02" style="text-align:center;">
		<div style="position:absolute;top:22px;right:0.4%;width:5%;"><img src="/app_helper/images/arrow02.jpg" width="100%" /></div>
	</div>
	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:40px;padding-bottom:7px;">전송시간2</div>
	<div style="position:relative;float:left;margin-left:4.027%;width:42.711%;margin-top:15px;"><input type="text" placeholder="18시" class="input02" style="text-align:center;">
		<div style="position:absolute;top:22px;right:0.4%;width:5%;"><img src="/app_helper/images/arrow02.jpg" width="100%" /></div>
	</div>
	<div style="position:relative;float:left;margin-left:4.027%;width:42.711%;margin-top:15px;"><input type="text" placeholder="30분" class="input02" style="text-align:center;">
		<div style="position:absolute;top:22px;right:0.4%;width:5%;"><img src="/app_helper/images/arrow02.jpg" width="100%" /></div>
	</div>	
</div>
-->

<!-- 시스템 설정
<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;">시스템 설정</div>
<div class="nbox">
	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:20px;padding-bottom:7px;">SITE KEY</div>
	<div style="float:left;width:100%;">		
		<div style="position:relative;float:left;width:66.5%;margin-top:20px;margin-left:3.994%;"><input type="text" placeholder="SITE KEY" class="input02" ></div>
		<div style="float:left;margin-top:28px;width:18.786%;margin-left:7%;"><a href="#"><img src="/app_helper/images/btn01.jpg" style="width:100%"/></a></div>
	</div>
	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:40px;padding-bottom:7px;">대화명</div>
	<div style="float:left;width:100%;">		
		<div style="position:relative;float:left;width:66.5%;margin-top:20px;margin-left:3.994%;"><input type="text" placeholder="대화명" class="input02" ></div>
		<div style="float:left;margin-top:28px;width:18.786%;margin-left:7%;"><a href="#"><img src="/app_helper/images/btn01.jpg" style="width:100%"/></a></div>
	</div>
	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:40px;padding-bottom:7px;">프로필 사진</div>
	<div style="float:left;width:100%;">		
		<div style="float:left;margin-top:28px;width:25.887%;margin-left:36.355%;"><img src="/app_helper/images/pic_img.jpg" style="width:100%"/></div>
		<div style="float:left;width:100%;">
			<div style="float:left;margin-top:28px;width:22.633%;margin-left:26.627%;"><a href="#"><img src="/app_helper/images/btn02.jpg" style="width:100%"/></a></div>
			<div style="float:left;margin-top:28px;width:22.633%;margin-left:1.479%;"><a href="#"><img src="/app_helper/images/btn03.jpg" style="width:100%"/></a></div>
		</div>
	</div>
	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:40px;padding-bottom:7px;">첫 메세지 설정</div>
	<div style="float:left;border:1px solid #c3c3c3;border-radius:8px;color:#3f3f3f;padding:2.5%;font-size:26px;width:87.011%;margin-left:3.994%;margin-top:20px;">
		<div style="position:relative;float:left;width:6.36%;"><img src="/app_helper/images/check.jpg" style="width:100%"/></div>
		<div style="float:left;margin-left:3%;line-height:30px;">첫 메세지 표시</div>
	</div>
	<div style="position:relative;float:left;width:87.511%;margin-top:20px;margin-left:3.994%;"><input type="text" placeholder="처음 표시 될 메세지를 작성해주세요." class="input02" ></div>
	<div style="float:left;margin-top:15px;width:92.311%;margin-left:3.994%;"><a href="#"><img src="/app_helper/images/btn04.jpg" style="width:100%"/></a></div>
	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:40px;padding-bottom:7px;">부재중 설정</div>
	<div style="float:left;border:1px solid #c3c3c3;border-radius:8px;color:#3f3f3f;padding:2.5%;font-size:26px;width:87.011%;margin-left:3.994%;margin-top:20px;">
		<div style="position:relative;float:left;width:6.36%;"><img src="/app_helper/images/check.jpg" style="width:100%"/></div>
		<div style="float:left;margin-left:3%;line-height:30px;">부재중 표시</div>
	</div>
	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:40px;padding-bottom:7px;">부재중 자동설정 요일</div>
	<div style="float:left;border:1px solid #c3c3c3;border-radius:8px;color:#3f3f3f;padding:2.5%;font-size:22px;width:87.011%;margin-left:3.994%;margin-top:20px;">
		<div style="float:left;width:100%;">
			<div style="position:relative;float:left;width:6.36%;"><img src="/app_helper/images/check.jpg" style="width:100%"/></div>
			<div style="float:left;margin-left:2%;line-height:30px;">일요일</div>
			<div style="position:relative;float:left;width:6.36%;margin-left:5%;"><img src="/app_helper/images/check.jpg" style="width:100%"/></div>
			<div style="float:left;margin-left:2%;line-height:30px;">월요일</div>
			<div style="position:relative;float:left;width:6.36%;margin-left:5%;"><img src="/app_helper/images/check.jpg" style="width:100%"/></div>
			<div style="float:left;margin-left:2%;line-height:30px;">화요일</div>
			<div style="position:relative;float:left;width:6.36%;margin-left:5%;"><img src="/app_helper/images/check.jpg" style="width:100%"/></div>
			<div style="float:left;margin-left:2%;line-height:30px;">수요일</div>			
		</div>
		<div style="float:left;width:100%;margin-top:15px;">
			<div style="position:relative;float:left;width:6.36%;"><img src="/app_helper/images/check.jpg" style="width:100%"/></div>
			<div style="float:left;margin-left:2%;line-height:30px;">목요일</div>
			<div style="position:relative;float:left;width:6.36%;margin-left:5%;"><img src="/app_helper/images/check.jpg" style="width:100%"/></div>
			<div style="float:left;margin-left:2%;line-height:30px;">금요일</div>
			<div style="position:relative;float:left;width:6.36%;margin-left:5%;"><img src="/app_helper/images/check.jpg" style="width:100%"/></div>
			<div style="float:left;margin-left:2%;line-height:30px;">토요일</div>
		</div>
	</div>
	<div style="float:left;margin-top:15px;width:92.311%;margin-left:3.994%;"><a href="#"><img src="/app_helper/images/btn05.jpg" style="width:100%"/></a></div>
	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:40px;padding-bottom:7px;">부재중 자동설정 시간 추가</div>
	<div style="position:relative;float:left;margin-left:4.027%;width:42.711%;margin-top:15px;"><input type="text" placeholder="00시" class="input02" style="text-align:center;">
		<div style="position:absolute;top:22px;right:0.4%;width:5%;"><img src="/app_helper/images/arrow02.jpg" width="100%" /></div>
	</div>
	<div style="position:relative;float:left;margin-left:4.027%;width:42.711%;margin-top:15px;"><input type="text" placeholder="00분" class="input02" style="text-align:center;">
		<div style="position:absolute;top:22px;right:0.4%;width:5%;"><img src="/app_helper/images/arrow02.jpg" width="100%" /></div>
	</div>
	<div style="position:relative;float:left;margin-left:4.027%;width:42.711%;margin-top:15px;"><input type="text" placeholder="00시" class="input02" style="text-align:center;">
		<div style="position:absolute;top:22px;right:0.4%;width:5%;"><img src="/app_helper/images/arrow02.jpg" width="100%" /></div>
	</div>
	<div style="position:relative;float:left;margin-left:4.027%;width:42.711%;margin-top:15px;"><input type="text" placeholder="00분" class="input02" style="text-align:center;">
		<div style="position:absolute;top:22px;right:0.4%;width:5%;"><img src="/app_helper/images/arrow02.jpg" width="100%" /></div>
	</div>
	<div style="float:left;margin-top:15px;width:92.311%;margin-left:3.994%;"><a href="#"><img src="/app_helper/images/btn06.jpg" style="width:100%"/></a></div>
	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:40px;padding-bottom:7px;">등록된 부재중 자동설정 시간 목록</div>
	<div style="position:relative;float:left;margin-left:4.027%;width:87.511%;margin-top:15px;"><input type="text" placeholder="00시 : 00분" class="input02" style="text-align:center;">
		<div style="position:absolute;top:27px;right:0.4%;width:3%;"><img src="/app_helper/images/arrow02.jpg" width="100%" /></div>
	</div>
	<div style="float:left;margin-top:15px;width:92.311%;margin-left:3.994%;"><a href="#"><img src="/app_helper/images/btn07.jpg" style="width:100%"/></a></div>	
	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:40px;padding-bottom:7px;">부재중 표시 메세지</div>
	<div style="position:relative;float:left;width:87.511%;margin-top:20px;margin-left:3.994%;"><input type="text" placeholder="부재중시 표시 될 메세지를 작성해주세요." class="input02" ></div>
	<div style="float:left;margin-top:15px;width:92.311%;margin-left:3.994%;"><a href="#"><img src="/app_helper/images/btn08.jpg" style="width:100%"/></a></div>
</div>
-->


<!-- 글보기
<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;">수정의뢰 글보기</div>
<div class="nbox">
	<div style="float:left;width:16.42%;margin-left:3.402%;margin-top:20px;"><a href="#"><img src="/app_helper/images/back_btn.jpg" style="width:100%"/></a></div>
	<div style="float:left;width:85.2%;margin-left:7.396%;margin-top:25px;color:#222222;font-size:26px;">제목 공간입니다.제목 공간입니다.제목 공간입니다.제목 공간입니다.제목 공간입니다.</div>
	<div style="position:relative;float:left;width:87.053%;border-bottom:2px solid #97979a;color:#676767;font-size:22px;margin-left:5.473%;margin-top:15px;line-height:50px;padding-left:2%;">2018.11.20 10:55
		<div style="position:absolute;top:0;right:2%;">글쓴이 : 아이티나인</div>
	</div>
	<div style="position:relative;float:left;width:87.053%;border-bottom:2px solid #e0e0e1;color:#6a6a6a;font-size:15px;margin-left:5.473%;padding-bottom:16px;margin-top:15px;padding-left:2%;">첨부 되는 파일의 이름 표시.jpg (21.0K) <span style="color:#ff6f2b;">[2]</span> DATE : 2018-02-06 14:22:27</div>
	<div style="float:left;width:85.2%;margin-left:7.396%;margin-top:25px;color:#222222;font-size:23px;padding-bottom:26px;border-bottom:2px solid #e0e0e1;">상세보기 페이지입니다.상세보기 페이지입니다.상세보기 페이지입니다.상세보기 페이지입니다.상세보기 페이지입니다.상세보기 페이지입니다.상세보기 페이지입니다.상세보기 페이지입니다.상세보기 페이지입니다.상세보기 페이지입니다.상세보기 페이지입니다.상세보기 페이지입니다.상세보기 페이지입니다.상세보기 페이지입니다.상세보기 페이지입니다.상세보기 페이지입니다.상세보기 페이지입니다.상세보기 페이지입니다.</div>
	<div style="float:left;width:85.2%;margin-left:7.396%;margin-top:25px;color:#6e6e6e;font-size:21px;padding-bottom:15px;border-bottom:2px solid #e0e0e1;">· 원본글 노출 되는 부분 원본글 내용이 노출됩니다.</div>
	<div style="float:left;width:80.2%;margin-left:11.396%;margin-top:15px;">
		<div style="float:left;width:10%;margin-top:4px;"><img src="/app_helper/images/re_i.jpg" style="width:100%"/></div>
		<div style="float:left;width:87.2%;margin-left:2%;color:#6e6e6e;font-size:21px;">리플글이 표시되는 부분입니다 내용이 노출됩니</div>
	</div>
	<div style="float:left;width:80.2%;margin-left:11.396%;margin-top:15px;">
		<div style="float:left;width:10%;margin-top:4px;"><img src="/app_helper/images/re_i.jpg" style="width:100%"/></div>
		<div style="float:left;width:87.2%;margin-left:2%;color:#6e6e6e;font-size:21px;">리플글이 표시되는 부분입니다 내용이 노출됩니</div>
	</div>
	<div style="float:left;margin-left:5.473%;background:#f5f5f5;padding:15px 3%;color:#222222;font-size:21px;margin-top:35px;width:83%;">
		<div style="float:left;color:#676767;">박유리 사원 <span style="font-size:19px;">2018-02-06 14:22</span>&nbsp;&nbsp;<strong style="font-size:19px;">삭제</strong></div>
		<div style="float:left;margin-top:7px;">댓글표시 공간입니다.댓글표시 공간입니다.댓글표시 공간입니다.댓글표시 공간입니다.</div>
	</div>
	<div style="float:left;width:100%;margin-left:5.473%;margin-top:30px;">		
		<div style="position:relative;float:left;width:62.5%;"><textarea class="textarea01" rows="3"></textarea></div>
		<div style="float:left;margin-left:6%;width:20.414%;"><a href="#"><img src="/app_helper/images/re_bt.jpg" style="width:100%"/></a></div>
	</div>
	<div style="float:left;width:100%;margin-top:30px;margin-bottom:20px;">
		<div style="float:left;width:28.994%;margin-left:5.473%;"><a href="#"><img src="/app_helper/images/v_btn01.jpg" style="width:100%"/></a></div>
		<div style="float:left;width:28.994%;margin-left:1.035%;"><a href="#"><img src="/app_helper/images/v_btn02.jpg" style="width:100%"/></a></div>
		<div style="float:left;width:28.994%;margin-left:1.035%;"><a href="#"><img src="/app_helper/images/v_btn03.jpg" style="width:100%"/></a></div>
	</div>
</div>
-->

<!-- 시스템 설정
<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;">시스템 설정</div>
<div class="nbox">
	<div style="float:left;width:92.011%;border-bottom:2px solid #97979a;color:#1d1d1d;font-size:26px;margin-left:3.994%;margin-top:10px;">SITE KEY</div>
</div>
-->

<!-- 실시간알리미 수정의뢰 리스트
<div style="position:relative;float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;width:100%;">실시간 알리미
	<div style="position:absolute;top:-10px;right:9%;width:20.786%;"><a href="#"><img src="/app_helper/images/write_btn2.jpg" style="width:100%"/></a></div>
</div>
<div class="nbox" style="padding-bottom:0;">
	<ul>
		<li class="nboxli2">
			<span class="Simg"><img src="/app_helper/images/yes_m.png" style="width:100%"/></span>	
			<span class="Tit">수정의뢰 게시글이 등록되었습니<span style="color:#ff5f2e;font-size:20px;">&nbsp;(1)</span></span>
			<span class="Con">홈페이지 약도 수정부탁드립니다.</span>
			<span class="Date">2017-11-02 16:11:49</span>
			<span class="Re"><img src="/app_helper/images/re_ico.jpg" style="width:100%"/></span>
			<span class="Point"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
		</li>
		<div style="float:left;width:100%;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
		<li class="nboxli2">
			<span class="Simg"><img src="/app_helper/images/no_m.png" style="width:100%"/></span>	
			<span class="Tit">수정의뢰 게시글이 등록되었습니다.</span>
			<span class="Con">홈페이지 약도 수정부탁드립니다.</span>
			<span class="Date">2017-11-02 16:11:49</span>
			<span class="Point"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
		</li>
		<div style="float:left;width:100%;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
		<li class="nboxli2">
			<span class="Simg"><img src="/app_helper/images/yes_m.png" style="width:100%"/></span>	
			<span class="Tit">수정의뢰 게시글이 등록되었습니다.</span>
			<span class="Con">홈페이지 약도 수정부탁드립니다.</span>
			<span class="Date">2017-11-02 16:11:49</span>
			<span class="Point"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
		</li>
	</ul>	
	<div style="float:left;width:100%;height:70px;background:#f5f5f5;border-top:1px solid #dbdbdb;">
		<div style="float:left;width:20.118%;margin-left:42%;"><img src="/app_helper/images/more_bt.jpg?2" style="width:100%"/></div>
	</div>
</div>
-->

<!-- 알리미 답변하기
<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;">게시판 답변하기</div>
<div class="nbox" style="padding-top:0;">
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:28px;width:20%;">제목</div>
		<div style="position:relative;float:left;width:67.5%;margin-top:20px;"><input type="text" class="input02" ></div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:28px;width:20%;">답변내용</div>
		<div style="position:relative;float:left;width:67.5%;"><textarea class="textarea01" rows="4"></textarea></div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;margin-top:10px;">
		<div style="float:left;width:20.786%;margin-left:27%;"><a href="#"><img src="/app_helper/images/write_btn.jpg" style="width:100%"/></a></div>
		<div style="float:left;width:23.449%;margin-left:3%;"><a href="#"><img src="/app_helper/images/list_btn.jpg" style="width:100%"/></a></div>
	</div>
</div>
-->

<!-- 수정의뢰 글쓰기
<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;">수정의뢰 글쓰기</div>
<div class="nbox" style="padding-top:0;">
	<div style="float:left;width:100%;height:100px;background:#f2f2f2;">
		<div style="float:left;margin:20px 0 0 0;"><img src="/app_helper/images/mo_text.jpg" style="width:100%"/></div>
	</div>
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:28px;width:20%;">업체명</div>
		<div style="position:relative;float:left;width:67.5%;margin-top:20px;"><input type="text" class="input02" ></div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;width:20%;margin-top:8px;">패스워드</div>
		<div style="position:relative;float:left;width:67.5%;"><input type="text" class="input02" ></div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;width:20%;margin-top:1px;">비밀글</div>
		<div style="position:relative;float:left;width:6.36%;"><img src="/app_helper/images/check_on.jpg" style="width:100%"/></div>
		<div style="position:relative;float:left;width:50.36%;color:#ff4f00;font-size:26px;">&nbsp;&nbsp;비밀글로 작성하기</div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;width:20%;margin-top:8px;">연락처</div>
		<div style="position:relative;float:left;width:19%;"><input type="text" class="input02" style="height:45px;"></div>
		<div style="float:left;font-size:26px;width:6%;color:#000000;">&nbsp;&nbsp;&nbsp;-</div>
		<div style="position:relative;float:left;width:19.5%;"><input type="text" class="input02" style="height:45px;"></div>
		<div style="float:left;font-size:26px;width:6%;color:#000000;">&nbsp;&nbsp;&nbsp;-</div>
		<div style="position:relative;float:left;width:19.5%;"><input type="text" class="input02" style="height:45px;"></div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:8px;width:20%;">제목</div>
		<div style="position:relative;float:left;width:67.5%;"><input type="text" class="input02" ></div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:28px;width:20%;">수정내용</div>
		<div style="position:relative;float:left;width:67.5%;"><textarea class="textarea01" rows="4"></textarea></div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:8px;width:20%;">파일첨부1</div>
		<div style="position:relative;float:left;width:67.5%;"><input type="file" class="input02" ></div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:8px;width:20%;">파일첨부2</div>
		<div style="position:relative;float:left;width:67.5%;"><input type="file" class="input02" ></div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;">
		<div style="float:left;margin-left:4.585%;font-size:26px;color:#222222;margin-top:28px;width:20%;"></div>
		<div style="position:relative;float:left;width:67.5%;color:#212121;font-size:22px;">회사규정상 <span style="color:#ff4f00;">한달 3번의 수정건이 무상</span>으로 지원이 됩니다.<br/><strong>페이지 추가나 소요시간이 길어질 때에는<br/>유료수정</strong>이 되며 담당자가 따로 연락을 드립니다.<br/><br/>※ <strong>유료수정건 작업시에는 입금이 확인되어야 수정작업이 진행되오니 이 점 참고해주시기 바랍니다.</strong></div>
	</div>
	<div style="float:left;width:100%;margin-top:20px;margin-bottom:20px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;margin-top:10px;">
		<div style="float:left;width:20.786%;margin-left:27%;"><a href="#"><img src="/app_helper/images/write_btn.jpg" style="width:100%"/></a></div>
		<div style="float:left;width:23.449%;margin-left:3%;"><a href="#"><img src="/app_helper/images/list_btn.jpg" style="width:100%"/></a></div>
	</div>
</div>
-->

<!-- 공지사항 리스트
<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;">공지사항</div>
<div class="nbox">
	<ul>
		<li class="nboxli">
			<div class="nboxlidiv1">
				<span>공지사항 새 글이 등록되었습니다.</span><span class="listpoint"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
			</div>
			<div class="nboxlibar"></div>
			<div class="nboxlidiv2">
				<span>내용이 간단하게 노출되어지는 공간입니다.</span><span style="font-size:20px;color:#999999;float:right">2017-11-06</span>
			</div>
		</li>
		<li class="nboxli">
			<div class="nboxlidiv1">
				<span>공지사항 새 글이 등록되었습니다.</span><span class="listpoint"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
			</div>
			<div class="nboxlibar"></div>
			<div class="nboxlidiv2">
				<span>내용이 간단하게 노출되어지는 공간입니다.</span><span style="font-size:20px;color:#999999;float:right">2017-11-06</span>
			</div>
		</li>
		<li class="nboxli">
			<div class="nboxlidiv1">
				<span>공지사항 새 글이 등록되었습니다.</span><span class="listpoint"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
			</div>
			<div class="nboxlibar"></div>
			<div class="nboxlidiv2">
				<span>내용이 간단하게 노출되어지는 공간입니다.</span><span style="font-size:20px;color:#999999;float:right">2017-11-06</span>
			</div>
		</li>
		<li class="nboxli">
			<div class="nboxlidiv1">
				<span>공지사항 새 글이 등록되었습니다.</span><span class="listpoint"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
			</div>
			<div class="nboxlibar"></div>
			<div class="nboxlidiv2">
				<span>내용이 간단하게 노출되어지는 공간입니다.</span><span style="font-size:20px;color:#999999;float:right">2017-11-06</span>
			</div>
		</li>
		<li class="nboxli">
			<div class="nboxlidiv1">
				<span>공지사항 새 글이 등록되었습니다.</span><span class="listpoint"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
			</div>
			<div class="nboxlibar"></div>
			<div class="nboxlidiv2">
				<span>내용이 간단하게 노출되어지는 공간입니다.</span><span style="font-size:20px;color:#999999;float:right">2017-11-06</span>
			</div>
		</li>
		<li class="nboxli">
			<div class="nboxlidiv1">
				<span>공지사항 새 글이 등록되었습니다.</span><span class="listpoint"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
			</div>
			<div class="nboxlibar"></div>
			<div class="nboxlidiv2">
				<span>내용이 간단하게 노출되어지는 공간입니다.</span><span style="font-size:20px;color:#999999;float:right">2017-11-06</span>
			</div>
		</li>
	</ul>
</div>
-->

<!-- 접속자 분석기 일별 월별 등 견본
<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;">접속자 현황</div>
<div class="nbox">
	<div class="tab2">
		<ul>
			<li class="on">일별</li>
			<li style="color:#a6a6a6;font-size:20px;">&nbsp;&nbsp;|&nbsp;&nbsp;</li>
			<li>월별</li>
			<li style="color:#a6a6a6;font-size:20px;">&nbsp;&nbsp;|&nbsp;&nbsp;</li>
			<li>연별</li>
			<li style="color:#a6a6a6;font-size:20px;">&nbsp;&nbsp;|&nbsp;&nbsp;</li>
			<li>트래픽</li>
		</ul>
	</div>
	<div class="tab">
		<ul>
			<li class="on">키워드</li>
			<li>포털</li>
			<li>OS</li>
			<li>브라우저</li>
		</ul>
	</div>
	<div style="float:left;position:relative;width:100%;">
		<div style="position:absolute;top:5%;left:23.5%;width:50%;text-align:center;font-weight:bold;font-size:28px;">TODAY</div>
		<div style="position:absolute;top:55%;left:10%;width:20%;text-align:center;font-weight:bold;font-size:22px;">100</div>
		<div style="position:absolute;top:55%;left:68%;width:20%;text-align:center;font-weight:bold;font-size:22px;">0</div>
		<div style="float:left;width:38.165%;margin-left:30%;margin-top:70px;"><img src="/app_helper/images/mc01.jpg" style="width:100%"/></div>
	</div>
	<div style="float:left;width:100%;margin-top:40px;margin-bottom:40px;"><img src="/app_helper/images/tr_bar.jpg" style="width:100%"/></div>
	<div style="float:left;position:relative;width:100%;">
		<div style="float:left;width:18.934%;margin-left:11%;margin-bottom:50px;"><img src="/app_helper/images/mc02.jpg" style="width:100%"/></div>
		<div style="position:absolute;top:75%;left:7.4%;width:26%;text-align:center;font-weight:bold;font-size:20px;">2018-01-01</div>
		<div style="float:left;width:18.934%;margin-left:11%;margin-bottom:50px;"><img src="/app_helper/images/mc02.jpg" style="width:100%"/></div>
		<div style="position:absolute;top:75%;left:37.4%;width:26%;text-align:center;font-weight:bold;font-size:20px;">2018-01-01</div>
		<div style="float:left;width:18.934%;margin-left:11%;margin-bottom:50px;"><img src="/app_helper/images/mc02.jpg" style="width:100%"/></div>
		<div style="position:absolute;top:75%;left:67.4%;width:26%;text-align:center;font-weight:bold;font-size:20px;">2018-01-01</div>
	</div>
</div>
-->

<!-- 접속자 분석기 트래픽
<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;">접속자 현황</div>
<div class="nbox">
	<div class="tab2">
		<ul>
			<li class="on">일별</li>
			<li style="color:#a6a6a6;font-size:20px;">&nbsp;&nbsp;|&nbsp;&nbsp;</li>
			<li>월별</li>
			<li style="color:#a6a6a6;font-size:20px;">&nbsp;&nbsp;|&nbsp;&nbsp;</li>
			<li>연별</li>
			<li style="color:#a6a6a6;font-size:20px;">&nbsp;&nbsp;|&nbsp;&nbsp;</li>
			<li>트래픽</li>
		</ul>
	</div>
	<div class="tab">
		<ul>
			<li class="on">키워드</li>
			<li>포털</li>
			<li>OS</li>
			<li>브라우저</li>
		</ul>
	</div>
	<div style="float:left;width:34.763%;margin-left:32.692%;margin-top:30px;"><img src="/app_helper/images/i01.jpg" style="width:100%"/></div>
	<div style="float:left;width:100%;"><img src="/app_helper/images/tr_img.jpg" style="width:100%"/></div>
</div>
-->

<!-- 접속자 분석기 키워드
<div style="float:left;color:#ffffff;font-size:26px;margin-left:5%;margin-top:30px;">접속자 현황</div>
<div class="nbox" style="padding-bottom:0;">
	<div class="tab2">
		<ul>
			<li class="on">일별</li>
			<li style="color:#a6a6a6;font-size:20px;">&nbsp;&nbsp;|&nbsp;&nbsp;</li>
			<li>월별</li>
			<li style="color:#a6a6a6;font-size:20px;">&nbsp;&nbsp;|&nbsp;&nbsp;</li>
			<li>연별</li>
			<li style="color:#a6a6a6;font-size:20px;">&nbsp;&nbsp;|&nbsp;&nbsp;</li>
			<li>트래픽</li>
		</ul>
	</div>
	<div class="tab">
		<ul>
			<li class="on">키워드</li>
			<li>포털</li>
			<li>OS</li>
			<li>브라우저</li>
		</ul>
	</div>
	<div class="nbox1">
		<ul>
			<li class="nboxli">
				<div class="nboxlidiv1">
					<span>사업자 등록번호 변경</span><span class="listpoint"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
				</div>
				<div class="nboxlibar"></div>
				<div class="nboxlidiv2">
					<span class="naver"><img src="/app_helper/images/naver.png" style="width:100%"/></span><span class="nboxlidiv2text">2017-11-06</span>
				</div>
			</li>
			<li class="nboxli">
				<div class="nboxlidiv1">
					<span>사업자 등록번호 변경</span><span class="listpoint"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
				</div>
				<div class="nboxlibar"></div>
				<div class="nboxlidiv2">
					<span class="daum"><img src="/app_helper/images/daum.png" style="width:100%"/></span><span class="nboxlidiv2text">2017-11-06</span>
				</div>
			</li>
			<li class="nboxli">
				<div class="nboxlidiv1">
					<span>사업자 등록번호 변경</span><span class="listpoint"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
				</div>
				<div class="nboxlibar"></div>
				<div class="nboxlidiv2">
					<span class="google"><img src="/app_helper/images/google.png?2" style="width:100%"/></span><span class="nboxlidiv2text">2017-11-06</span>
				</div>
			</li>
			<li class="nboxli">
				<div class="nboxlidiv1">
					<span>사업자 등록번호 변경</span><span class="listpoint"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
				</div>
				<div class="nboxlibar"></div>
				<div class="nboxlidiv2">
					<span class="naver"><img src="/app_helper/images/naver.png" style="width:100%"/></span><span class="nboxlidiv2text">2017-11-06</span>
				</div>
			</li>
			<li class="nboxli">
				<div class="nboxlidiv1">
					<span>사업자 등록번호 변경</span><span class="listpoint"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
				</div>
				<div class="nboxlibar"></div>
				<div class="nboxlidiv2">
					<span class="naver"><img src="/app_helper/images/naver.png" style="width:100%"/></span><span class="nboxlidiv2text">2017-11-06</span>
				</div>
			</li>
			<li class="nboxli">
				<div class="nboxlidiv1">
					<span>사업자 등록번호 변경</span><span class="listpoint"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
				</div>
				<div class="nboxlibar"></div>
				<div class="nboxlidiv2">
					<span class="naver"><img src="/app_helper/images/naver.png" style="width:100%"/></span><span class="nboxlidiv2text">2017-11-06</span>
				</div>
			</li>
		</ul>		
	</div>
	<div style="float:left;width:100%;height:70px;background:#f5f5f5;border-top:1px solid #dbdbdb;">
		<div style="float:left;width:20.118%;margin-left:42%;"><img src="/app_helper/images/more_bt.jpg?2" style="width:100%"/></div>
	</div>
</div>

-->

<!--
<div style="width:100%;position:relative;margin:0 auto;">
	<div class="nbox">
		<ul>
			<li class="nboxli">
				<div class="nboxlidiv1">
					<span>공지사항 새 글이 등록되었습니다.</span><span class="listpoint"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
				</div>
				<div class="nboxlibar"></div>
				<div class="nboxlidiv2">
					<span>내용이 간단하게 노출되어지는 공간입니다.</span><span style="font-size:20px;color:#999999;float:right">2017-11-06</span>
				</div>
			</li>
			<li class="nboxli">
				<div class="nboxlidiv1">
					<span>공지사항 새 글이 등록되었습니다.</span><span class="listpoint"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
				</div>
				<div class="nboxlibar"></div>
				<div class="nboxlidiv2">
					<span>내용이 간단하게 노출되어지는 공간입니다.</span><span style="font-size:20px;color:#999999;float:right">2017-11-06</span>
				</div>
			</li>
			<li class="nboxli">
				<div class="nboxlidiv1">
					<span>공지사항 새 글이 등록되었습니다.</span><span class="listpoint"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
				</div>
				<div class="nboxlibar"></div>
				<div class="nboxlidiv2">
					<span>내용이 간단하게 노출되어지는 공간입니다.</span><span style="font-size:20px;color:#999999;float:right">2017-11-06</span>
				</div>
			</li>
			<li class="nboxli">
				<div class="nboxlidiv1">
					<span>공지사항 새 글이 등록되었습니다.</span><span class="listpoint"><img src="/app_helper/images/listpoint.png" style="width:100%"/></span>
				</div>
				<div class="nboxlibar"></div>
				<div class="nboxlidiv2">
					<span>내용이 간단하게 노출되어지는 공간입니다.</span><span style="font-size:20px;color:#999999;float:right">2017-11-06</span>
				</div>
			</li>
		</ul>
	</div>
</div>
-->