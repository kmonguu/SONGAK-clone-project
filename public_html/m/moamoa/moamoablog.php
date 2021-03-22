<?include_once "_common.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ko">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<script type="text/javascript" src="<?=$g4['path']?>/m/js/jquery-1.6.2.min.js"></script>

<meta name="keyword" content="<?=$g4['title']?>, mobile" />
<meta name="description" content="<?=$g4['title']?>, mobile" />
<?
//http://smart9.net/common_viewport.php 에서 뷰포트설정을 가져옵니다.
function file_load($url){$fuid = '/tmp/wget_tmp_' . md5($_SERVER['REMOTE_ADDR'] . microtime() . $url);$cmd = 'wget "' . $url . '" -O "' . $fuid . '" --read-timeout=30';`$cmd`;$data = file_get_contents($fuid);`rm -rf $fuid`;return $data;}
$useragent = urlencode($_SERVER[HTTP_USER_AGENT]);
$initial_viewport_loadurl = "http://smart9.net/common_viewport.php?fScale={$fScale}&ua={$useragent}";
$common_viewport = file_load($initial_viewport_loadurl);
?>
<?=$common_viewport;?>

<!-- 기기별 뷰포트 설정 부분 http://smart9.net/common_viewport_script.php파일에서 불러옴 -->
<?
$qs = $_SERVER["QUERY_STRING"];
$self = $_SERVER["PHP_SELF"];
$initial_viewport_script_loadurl = "http://smart9.net/common_viewport_script.php?fScale={$fScale}&ua={$useragent}&qs={$qs}&self={$self}&zoomable=no";
$common_viewport_script = file_load($initial_viewport_script_loadurl);
?>
<?=$common_viewport_script;?>



</head>
<body>

<script type="text/javascript">
	function closeMoamoa(){
		location.href = "<?=$protocol?><?=$return_url?>";
	}
</script>


<style type="text/css">
body {width:640px; height:auto; margin:0 auto; position:relative;font-family:'Nanum Gothic',굴림,Tahoma; font-size:12px; color:#888888;}

.moamoa {width:640px;height:auto; left:0; top:0; background-color:#fff;z-index:999;}
.moamoa1 {width:640px;background:#fff;position:relative;z-index:9999}
.clobtn {width:30px;height:29px;position:absolute;top:10px;left:590px;z-index:9999}
.title {width:640px;height:131px;clear:both}

table.t2 {width:640px;background:#fff;padding:20px 0 0 0;overflow:hidden}
table.t2 th {height:50px;padding:0;font-size:20px;background:#f1f1f1;font-weight:bold;color:#3d3d3d;line-height:30px;}
table.t2 td {height:50px;border-bottom:1px solid #c7cccf;padding:0;line-height:28px;vertical-align:middle;color:#5e5e5e;font-size:20px;}
table.t2 td img {vertical-align:middle;}

.board_page { clear:both; text-align:center; margin:30px 0 50px 0;font-size:22px;line-height:18px; }
.board_page a:link { color:#777; }
.board_page span {color:#111;padding:0 5px;vertical-align:middle;text-align:center;margin-left:5px}

a:link, a:visited, a:active { text-decoration:none; color:#5e5e5e; }
a:hover { text-decoration:none; }
</style>



<div class="moamoa">

<?

$qstr = $qstr."&protocol={$protocol}&return_url={$return_url}";

$blog_list = array("joinsmsn"=>"Joins","naver"=>"네이버","egloos"=>"이글루스","cyworld"=>"싸이월드","dreamwiz"=>"드림위즈","textcube"=>"텍스트큐브","mediamob"=>"미디어몹","paran"=>"파란","yahoo"=>"야후","tistory"=>"티스토리","daum"=>"다음");




$sql = "SELECT count(*) cnt FROM blog_data";
$row = sql_fetch($sql);
$total_count = $row[cnt];



$rows = 15;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if (!$page) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함


$result = sql_query("SELECT * FROM blog_data ORDER BY disp_order asc, reg_date asc   limit $from_record, $rows ");

?>


</div>
	<div class="moamoa1">
		<div style="position:relative;">
			<div class="tit"><img src="/m/moamoa/img/title.jpg"/></div>
			<div class="clobtn" onclick="closeMoamoa()"><img src="/m/moamoa/img/clobtn.png"/></div>
			<table cellspacing="0" cellpadding="0" class="t2">
				<colgroup>
					<col width="55" />
					<col width="120" />
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
						<td align="center"><a href="javascript:void(0)" onclick="window.open('<?=$link?>','moamoablog','menubar=no, toolbar=no, directories=no, location=no,status=no, top=0, left=0, width='+screen.width+', height='+screen.height )"  ><img src="/m/moamoa/img/<?=$blog_key?>.jpg" border=0/></a></td>
						<td style="font-weight:bold">
							<div style='text-overflow:ellipsis; overflow:hidden; width:95%;white-space: nowrap'>
								<a href="javascript:void(0)" onclick="window.open('<?=$link?>','moamoablog','menubar=no, toolbar=no, directories=no, location=no,status=no, top=0, left=0, width='+screen.width+', height='+screen.height )"  ><?=$title?></a>
							</div>
						</td>
					</tr>

					<?}?>

				</tbody>
			</table>
			<div class="board_page">
				
				<?
				 $write_pages = get_paging(5, $page, $total_page, "?$qstr&page=");
				 $write_pages = str_replace("&nbsp;", "", $write_pages);
				 $write_pages = str_replace("처음", "<img src='/m/moamoa/img/page_begin.jpg' border='0' align='absmiddle' title='처음'>", $write_pages);
				 $write_pages = str_replace("이전", "<img src='/m/moamoa/img/page_prev.jpg' align='absmiddle' title='이전'>", $write_pages);
				 $write_pages = str_replace("다음", "<img src='/m/moamoa/img/page_next.jpg' border='0' align='absmiddle' title='다음'>", $write_pages);
				 $write_pages = str_replace("맨끝", "<img src='/m/moamoa/img/page_end.jpg' border='0' align='absmiddle' title='맨끝'>", $write_pages);
				 //$write_pages = preg_replace("/<span>([0-9]*)<\/span>/", "$1", $write_pages);
				 $write_pages = preg_replace("/<span>([0-9]*)<\/span>/", "<span style=\"color:#000; background:#fff;font-size:22px; padding:3px; \">$1</span>", $write_pages);
				 $write_pages = preg_replace("/<b>([0-9]*)<\/b>/", "<span style=\"color:#fff; background:#000;font-size:22px; padding:10px; \">$1</span>", $write_pages);

				 echo $write_pages;
				?>
				
			</div>
		</div>
	</div>

</body>
</html>
