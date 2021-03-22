<?include_once "_common.php"; ?>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>


<style type="text/css">
body {margin-left:0px;margin-top:0px;margin-right:0px;margin-bottom:0px; font-family:'Nanum Gothic',굴림,Tahoma; font-size:12px; color:#888888;}

.moamoa {position:fixed; width:100%; height:100%; left:0; top:0; background-color:#000000;filter:alpha(opacity=70);opacity:.7; z-index:999;}
.moamoa1 {width:1000px;height:600px;margin:0 auto;background:url("/moamoa/img/bg.jpg") no-repeat center top;position:relative;z-index:9999}
.clobtn {width:69px;height:22px;position:absolute;top:21px;left:910px;}
.tit {width:297px;height:29px;position:absolute;top:51px;left:352px;}
.title {width:284px;height:70px;position:absolute;top:479px;left:359px;}

.t {position:absolute;top:100px;left:148px}
table.t2 {width:705px;background:#fff;padding:0 0 0 0;overflow:hidden}
table.t2 th {padding:0;font-size:13px;background:#f1f1f1;font-weight:bold;color:#3d3d3d;line-height:30px;}
table.t2 td {border-bottom:1px solid #c7cccf;padding:0;line-height:28px;vertical-align:middle;color:#5e5e5e;font-size:11px;}
table.t2 td img {vertical-align:middle;}

.board_page { clear:both; text-align:center; margin:15px 0 50px 0;font-size:14px;line-height:18px; }
.board_page a:link { color:#777; }
.board_page span {color:#111;padding:0 5px;vertical-align:middle;text-align:center;}

a:link, a:visited, a:active { text-decoration:none; color:#5e5e5e; }
a:hover { text-decoration:none; }
</style>



<div class="moamoa">
<?
$blog_list = array("joinsmsn"=>"Joins","naver"=>"네이버","egloos"=>"이글루스","cyworld"=>"싸이월드","dreamwiz"=>"드림위즈","textcube"=>"텍스트큐브","mediamob"=>"미디어몹","paran"=>"파란","yahoo"=>"야후","tistory"=>"티스토리","daum"=>"다음");




$sql = "SELECT count(*) cnt FROM blog_data";
$row = sql_fetch($sql);
$total_count = $row[cnt];



$rows = 10;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if (!$page) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함


$result = sql_query("SELECT * FROM blog_data ORDER BY disp_order asc, reg_date desc   limit $from_record, $rows ");

?>
</div>
	<div class="moamoa1">
		<div style="position:relative;">
			<div class="clobtn" style="cursor:pointer;" onclick="parent.moamoa_close()"><img src="/moamoa/img/clobtn.png"/></div>
			<div class="tit"><img src="/moamoa/img/tit.png"/></div>
			<div class="t">
				<table cellspacing="0" cellpadding="0" class="t2">
					<colgroup>
						<col width="60" />
						<col width="100" />
						<col width="" />
					</colgroup>
					<thead>
						<tr>
							<th scope="col">번&nbsp;호</th>
							<th scope="col">매&nbsp;체</th>
							<th scope="col">제&nbsp;목</th>
						</tr>
					</thead>
					<tbody>

					 <?for($idx = 0 ; $row = sql_fetch_array($result); $idx++){

						 $link = $row["link"];
						 $title = $row["title"];
						 $description = $row["description"];
						 $bloggerlink = $row["bloggerlink"];
						 $bloggername = $row["bloggername"];
						 $blog_name = "네이버";
						 $blog_key = "naver";
						 foreach($blog_list as $blog=>$name){
							if(strpos($bloggerlink, $blog) !== false){
								$blog_name = $name;
								$blog_key = $blog;								
							}
						 } 
					?>
						<tr>
							<td align="center"><?=$idx + (($page-1) * $rows) + 1?></td>
							<td align="center"><a href="javascript:void(0)" onclick="window.open('<?=$link?>','moamoablog','menubar=no, toolbar=no, directories=no, location=no,status=no, scrollbars=yes, top=0, left=0, width='+screen.width+', height='+screen.height )"  ><img src="/moamoa/img/<?=$blog_key?>.png" border=0/></a></td>
							<td class="mma_title" style="font-weight:bold"><a href="javascript:void(0)" onclick="window.open('<?=$link?>','moamoablog','menubar=no, toolbar=no, directories=no, location=no,status=no, scrollbars=yes, top=0, left=0, width='+screen.width+', height='+screen.height )"  ><?=$title?></a></td>
						</tr>

					<?}?>
						
	
					</tbody>
				</table>
				<div class="board_page">
					
					<?
					 $write_pages = get_paging(5, $page, $total_page, "?$qstr&page=");
					 $write_pages = str_replace("&nbsp;", "", $write_pages);
					 $write_pages = str_replace("처음", "<img src='/moamoa/img/page_begin.gif' border='0' align='absmiddle' title='처음'>", $write_pages);
					 $write_pages = str_replace("이전", "<img src='/moamoa/img/page_prev.gif' align='absmiddle' title='이전'>", $write_pages);
					 $write_pages = str_replace("다음", "<img src='/moamoa/img/page_next.gif' border='0' align='absmiddle' title='다음'>", $write_pages);
					 $write_pages = str_replace("맨끝", "<img src='/moamoa/img/page_end.gif' border='0' align='absmiddle' title='맨끝'>", $write_pages);
					 //$write_pages = preg_replace("/<span>([0-9]*)<\/span>/", "$1", $write_pages);
					 $write_pages = preg_replace("/<span>([0-9]*)<\/span>/", "<span style=\"color:#000; background:#fff; padding:3px; \">$1</span>", $write_pages);
					 $write_pages = preg_replace("/<b>([0-9]*)<\/b>/", "<span style=\"color:#fff; background:#000; padding:3px; \">$1</span>", $write_pages);

					 echo $write_pages;
					?>
					
				</div>
			</div>
			<div class="title"><img src="/moamoa/img/title.png"/></div>
		</div>
	</div>

</body>
</html>
