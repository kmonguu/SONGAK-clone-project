/* 모바일에 필요없는 아이콘 제거 */
$(function(){
	$(".cheditor-tb-wrapper div[name=Print]").hide();				//프린트
	$(".cheditor-tb-wrapper div[name=NewDocument]").hide();			//새문서
	$(".cheditor-tb-wrapper div[name=Undo]").hide();				//되돌리기
	$(".cheditor-tb-wrapper div[name=Redo]").hide();				//다시실행
	$(".cheditor-tb-wrapper div[name=Copy]").hide();				//복사하기
	$(".cheditor-tb-wrapper div[name=Cut]").hide();					//오려두기
	$(".cheditor-tb-wrapper div[name=SelectAll]").hide();			//전체선택
	$(".cheditor-tb-wrapper div[name=Paste]").hide();				//텍스트붙이기
	$(".cheditor-tb-wrapper div[name=PasteFromWord]").hide();		//MS워드 붙이기
	$(".cheditor-tb-wrapper div[name=Symbol]").hide();				//특수문자
	$(".cheditor-tb-wrapper div[name=Flash]").hide();				//플래쉬 동영상
	$(".cheditor-tb-wrapper div[name=Map]").hide();					//지도
	$(".cheditor-tb-wrapper div[name=Link]").hide();				//하이퍼링크
	$(".cheditor-tb-wrapper div[name=UnLink]").hide();				//하이퍼링크없애기

	$(".cheditor-tb-wrapper div[name=JustifyCenter]").hide();		//가운데정렬
	$(".cheditor-tb-wrapper div[name=JustifyRight]").hide();		//오른정렬
	$(".cheditor-tb-wrapper div[name=JustifyLeft]").hide();			//왼쪽정렬
	$(".cheditor-tb-wrapper div[name=JustifyFull]").hide();			//양쪽정렬

	$(".cheditor-tb-wrapper div[name=OrderedList]").hide();			//문단번호
	$(".cheditor-tb-wrapper div[name=OrderedListCombo]").hide();	//문단번호확장
	$(".cheditor-tb-wrapper div[name=UnOrderedList]").hide();		//글머리표
	$(".cheditor-tb-wrapper div[name=UnOrderedListCombo]").hide();	//글머리표확장

	$(".cheditor-tb-wrapper div[name=Outdent]").hide();				//왼쪽여백줄이기
	$(".cheditor-tb-wrapper div[name=Indent]").hide();				//왼쪽여백늘이기

	$(".cheditor-tb-wrapper div[name=RemoveFormat]").hide();		//서식지우기
	$(".cheditor-tb-wrapper div[name=ClearTag]").hide();			//모든html태그제거

	$(".cheditor-tb-wrapper div[name=TextBlock]").hide();			//글상자
	$(".cheditor-tb-wrapper div[name=HR]").hide();					//가로줄

	$(".cheditor-tb-wrapper div[name=Table]").hide();				//표만들기
	$(".cheditor-tb-wrapper div[name=ModifyTable]").hide();			//표수정

	//$(".cheditor-tb-button-spacer").hide();
	
});
	

/* 아이콘 변경 스크립트 */
$(function(){
	$(".cheditor-tb-wrapper").css({
		height:"81px",
	});	
	
	$(".cheditor-tb-wrapper div[name=BackColor], .cheditor-tb-wrapper div[name=ForeColor]").css({
		width:"45px",
		height:"38px",
	});

	$(".cheditor-tb-wrapper div[name=Bold], .cheditor-tb-wrapper div[name=Italic], .cheditor-tb-wrapper div[name=Underline], .cheditor-tb-wrapper div[name=Strikethrough]").css({
		width:"36px",
		height:"38px",
	});

	$(".cheditor-tb-wrapper div[name=FormatBlock]").css({
		width:"83px",
		height:"35px",
		margin:"0 0 0 12px",
	});
	$(".cheditor-tb-wrapper div[name=FontName]").css({
		width:"110px",
		height:"35px",
	});

	$(".cheditor-tb-wrapper div[name=FontSize]").css({
		width:"62px",
		height:"35px",
	});
	$(".cheditor-tb-wrapper div[name=LineHeight]").css({
		width:"83px",
		height:"35px",
	});
	$(".cheditor-tb-wrapper div[name=SmileyIcon]").css({
		width:"35px",
		height:"35px",
	});
	$(".cheditor-tb-wrapper div[name=Image]").css({
		width:"75px",
		height:"35px",
	});
});