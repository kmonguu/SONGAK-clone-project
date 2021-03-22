function home(){location.href="/app_helper/index.php";} // 홈
function adm(){location.href="/adm";} //관리자
function login(){location.href="/app/bbs/login.php";} //로그인

function register(){location.href="/app/bbs/register.php";} //회원가입
function revision(){location.href="/app/bbs/member_confirm.php?url=register_form.php";} //회원정보수정
function m_travel(){window.open("http://www.jejutour.go.kr/app/contents/?mid=TU&type=cat");}//모바일 제주트레벌
function m_it9(){window.open("http://it9.co.kr/app/bbs/board.php?bo_table=portfolio");}//모바일 IT9포토폴리오
function m_smart9(){window.open("http://smart9.net/app/pages.php?p=3_1_1_1");}//스마트나인 포토폴리오


function logout(){
	confirm_app("로그아웃 하시겠습니까?", function(){

		location.href=g4_app_path + "/bbs/logout.php";
	});
} //로그아웃


function menum(link_go, anchor) {
	
	if(anchor === undefined) anchor = "";
	if(anchor != "") anchor = "#"+anchor;

	switch ( link_go ) {

		//접속자 분석기
		case 'menu01-1' : //
		location.href="/app_helper/pages.php?p=1_1_1_1"+anchor; break;
		case 'menu01-2' : //
		location.href="/app_helper/pages.php?p=1_2_1_1"+anchor; break;
		case 'menu01-3' : //
		location.href="/app_helper/pages.php?p=1_3_1_1"+anchor; break;
		case 'menu01-4' : //
		location.href="/app_helper/pages.php?p=1_4_1_1"+anchor; break;
				
		
		//실시간 알리미
		case 'menu02-1' ://
		location.href="/app_helper/pages.php?p=2_1_1_1"+anchor; break;


		//수정의뢰
		case 'menu03-1' ://
		location.href="/app_helper/pages.php?p=3_1_1_1"+anchor; break;


		//공지사항	//공지사항
		case 'menu04-1' ://
		location.href="/app_helper/pages.php?p=4_1_1_1"+anchor; break;
				
		//실시간 문의
		case 'menu05-1' ://
		location.href="/app_helper/pages.php?p=5_1_1_1"+anchor; break;

		//알람 설정
		case 'menu06-1' ://
		location.href="/app_helper/pages.php?p=6_1_1_1"+anchor; break;

		//시스템 설정
		case 'menu07-1' ://
		location.href="/app_helper/pages.php?p=7_1_1_1"+anchor; break;
				

		/*
		//도서안내
		case 'menu03-1' ://신간도서
		location.href="/app/bbs/board.php?bo_table=3_1_1_1"+anchor; break;
			case 'menu03-1-1' :// -점자도서
			location.href="/app/bbs/board.php?bo_table=3_1_1_1"+anchor; break;
			case 'menu03-1-2' :// -전자도서
			location.href="/app/bbs/board.php?bo_table=3_1_2_1"+anchor; break;
			case 'menu03-1-3' :// -소리도서
			location.href="/app/bbs/board.php?bo_table=3_1_3_1"+anchor; break;
			case 'menu03-1-4' :// -기타
			location.href="/app/bbs/board.php?bo_table=3_1_4_1"+anchor; break;
		case 'menu03-2' ://추천도서
		location.href="/app/bbs/board.php?bo_table=3_2_1_1"+anchor; break;
		case 'menu03-3' ://소장도서
		location.href="/app/bbs/board.php?bo_table=3_3_1_1"+anchor; break;
		case 'menu03-4' ://희망도서 신청
		location.href="/app/bbs/board.php?bo_table=3_4_1_1"+anchor; break;
		
		
		//전자도서관
		case 'menu04-1' ://점자도서
		location.href="/app/bbs/board.php?bo_table=4_1_1_1"+anchor; break;
		case 'menu04-2' ://전자도서
		location.href="/app/bbs/board.php?bo_table=4_2_1_1"+anchor; break;
		case 'menu04-3' ://소리도서
		location.href="/app/bbs/board.php?bo_table=4_3_1_1"+anchor; break;
		case 'menu04-4' ://정기간행물
		location.href="/app/bbs/board.php?bo_table=4_4_1_1"+anchor; break;
		case 'menu04-5' ://정보세상(장애인뉴스)
		location.href="/app/pages.php?p=4_5_1_1"+anchor; break;
		//location.href="/app/pages.php?p=4_5_1_1&ConnectId=jifb11"+anchor; break;
		case 'menu04-6' ://자유세상
		location.href="/app/bbs/board.php?bo_table=4_6_1_1"+anchor; break;
		
		
		//자원봉사/후원/기증
		case 'menu05-1' : //자원봉사 안내 및 신청
		location.href="/app/pages.php?p=5_1_1_1"+anchor; break;
			case 'menu05-1write' : //자원봉사 안내 및 신청게시판
			location.href="/app/bbs/write.php?bo_table=5_1_1_1"+anchor; break;
		case 'menu05-2' : //자원봉사 자료실
		location.href="/app/bbs/board.php?bo_table=5_2_1_1"+anchor; break;
		case 'menu05-3' : //후원 및 기증안내
		location.href="/app/pages.php?p=5_3_1_1"+anchor; break;

		
		//커뮤니티
		case 'menu06-1' : //공지사항
		location.href="/app/bbs/board.php?bo_table=6_1_1_1"+anchor; break;
		case 'menu06-2' : //자유게시판
		location.href="/app/bbs/board.php?bo_table=6_2_1_1"+anchor; break;
		case 'menu06-3' : //질문과 답변
		location.href="/app/bbs/board.php?bo_table=6_3_1_1"+anchor; break;
		case 'menu06-4' : //자료실
		location.href="/app/bbs/board.php?bo_table=6_4_1_1"+anchor; break;


		//점자배움터
		case 'menu07-1' : //점자역사
		location.href="/app/pages.php?p=7_1_1_1"+anchor; break;
		case 'menu07-2' : //점자알림표
		location.href="/app/pages.php?p=7_2_1_1"+anchor; break;
		case 'menu07-3' : //점자자료실
		location.href="/app/bbs/board.php?bo_table=7_3_1_1"+anchor; break;

		
		//
		case 'menu100-7' : //사이트맵
		location.href="/app/pages.php?p=100_7_1_1"+anchor; break;
		case 'menu100-8' : //개인정보처리방침
		location.href="/app/pages.php?p=100_8_1_1"+anchor; break;
		*/


		}
}





