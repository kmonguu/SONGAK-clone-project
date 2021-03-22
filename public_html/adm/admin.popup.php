<?
if (!defined("_GNUBOARD_")) exit;

$begin_time = get_microtime();

include_once("$g4[path]/head.sub.admin.php");
?>

<script type="text/javascript">
if (!g4_is_ie) document.captureEvents(Event.MOUSEMOVE)
document.onmousemove = getMouseXY;
var tempX = 0;
var tempY = 0;
var prevdiv = null;
var timerID = null;

function getMouseXY(e)
{
    if (g4_is_ie) { // grab the x-y pos.s if browser is IE
        tempX = event.clientX + document.body.scrollLeft;
        tempY = event.clientY + document.body.scrollTop;
    } else {  // grab the x-y pos.s if browser is NS
        tempX = e.pageX;
        tempY = e.pageY;
    }

    if (tempX < 0) {tempX = 0;}
    if (tempY < 0) {tempY = 0;}

    return true;
}

function imageview(id, w, h)
{

    menu(id);

    var el_id = document.getElementById(id);

    //submenu = eval(name+".style");
    submenu = el_id.style;
    submenu.left = tempX - ( w + 11 );
    submenu.top  = tempY - ( h / 2 );

    selectBoxVisible();

    if (el_id.style.display != 'none')
        selectBoxHidden(id);
}

function help(id, left, top)
{
    menu(id);

    var el_id = document.getElementById(id);

    //submenu = eval(name+".style");
    submenu = el_id.style;
    submenu.left = tempX - 50 + left;
    submenu.top  = tempY + 15 + top;

    selectBoxVisible();

    if (el_id.style.display != 'none')
        selectBoxHidden(id);
}

// TEXTAREA 사이즈 변경
function textarea_size(fld, size)
{
	var rows = parseInt(fld.rows);

	rows += parseInt(size);
	if (rows > 0) {
		fld.rows = rows;
	}
}
</script>


<!--[if IE]>
	<meta http-equiv="imagetoolbar" content="no">
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
<script type="text/javascript">
var save_layer = null;
function layer_view(link_id, menu_id, opt, x, y)
{
    var link = document.getElementById(link_id);
    var menu = document.getElementById(menu_id);

    //for (i in link) { document.write(i + '<br/>'); } return;

    if (save_layer != null)
    {
        save_layer.style.display = "none";
        selectBoxVisible();
    }

    if (link_id == '')
        return;

    if (opt == 'hide')
    {
        menu.style.display = 'none';
        selectBoxVisible();
    }
    else
    {
        x = parseInt(x);
        y = parseInt(y);
        menu.style.left = get_left_pos(link) + x;
        menu.style.top  = get_top_pos(link) + link.offsetHeight + y;
        menu.style.display = 'block';
    }

    save_layer = menu;
}
</script>

<style>
a:link, a:visited, a:active { text-decoration:none; color:#004280; }
a:hover { text-decoration:underline; color:#006cd1; }

article, aside, figure, footer, header, hgroup,
menu, nav, section { display: block; }

h1,h2,h3,h4,h5,p { line-height:1; margin:0; padding:0; }
html { overflow-y:scroll; }
body { margin:0; padding:0; }
img { border:0; }





body, td, p, input, button, textarea, select, .c1 { font-family:Tahoma,굴림; font-size:12px; color:#222222; }

form { margin:0px; }


a:link, a:visited, a:active { text-decoration:none; color:#466C8A; }
a:hover { text-decoration:underline; }

a.menu:link, a.menu:visited, a.menu:active { text-decoration:none; color:#454545; }
a.menu:hover { text-decoration:none; }

.member {font-weight:bold;color:#888888;}
.guest  {font-weight:normal;color:#888888;}

.lh { line-height: 150%; }
.jt { text-align:justify; }

.li { font-weight:bold; font-size:18px; vertical-align:-4px; color:#66AEAD; }

.ul { list-style-type:square; color:#66AEAD; }

.ct { font-family: Verdana, 굴림; color:#222222; }

.ed { border:1px solid #CCCCCC; }
.tx { border:1px solid #CCCCCC; }

.small { font-size:8pt; font-family:돋움; }
.cloudy, a.cloudy {color:#888888;} /* 흐림 */

input.ed { height:20px; border:1px solid #9A9A9A; border-right:1px solid #D8D8D8; border-bottom:1px solid #D8D8D8; padding:3px 2px 0 2px;}
input.ed_password { height:20px; border:1px solid #9A9A9A; border-right:1px solid #D8D8D8; border-bottom:1px solid #D8D8D8; padding:3px 2px 0 2px; font:10px Tahoma; }
textarea.tx { border:1px solid #9A9A9A; border-right:1px solid #D8D8D8; border-bottom:1px solid #D8D8D8; padding:2px; }


.title { font-size:9pt; font-family:굴림; font-weight:bold; color:#616161; }

.btn1 { background-color:#f2f9ff;padding:4px; }

.col1 { color:#616161; }
.col2 { color:#868686; }

.pad1 { padding:5px 10px 5px 10px; }
.pad2 { padding:5px 0px 5px 0px; }

.bgcol1 { background-color:#f0f8ff; padding:5px;border-top:2px solid #0e87f9;}
.bgcol2 { background-color:#F5F5F5; padding:5px; }

.line1 { background-color:#CCCCCC; height:2px;padding:0;margin:0;  }
.line2 { background-color:#CCCCCC; height:1px;padding:0;margin:0; }

.list0 { background-color:#FFFFFF; }
.list1 { background-color:#F8F8F8; }

.bold { font-weight:bold; }
.center { text-align:center; }
.right { text-align:right; }

.w99 { width:99%; }
.ht { height:30px; }

.bg_menu1 { height:22px;
            padding-left:15px;
            padding-right:15px; }
.bg_line1 { height:1px; background-color:#EFCA95; }

.bg_menu2 { height:22px;
            padding-left:25px; }
.bg_line2 { background-image:url('<?=$g4['admin_path']?>/img/dot.gif'); height:3px; }
.dot {color:#D6D0C8;border-style:dotted;}

#csshelp1 { border:0px; background:#FFFFFF; padding:6px; }
#csshelp2 { border:2px solid #BDBEC6; padding:0px; }
#csshelp3 { background:#F9F9F9; padding:6px; width:200px; color:#222222; line-height:120%; text-align:left; }


h1 { font:bold 14px dotum; letter-spacing:-1px; }
h1.title { font:bold 14px dotum; letter-spacing:-1px;color:#fff; }
header {position:relative; background:url('/adm/img/member_bg.jpg') repeat-x left top; width:100%; }
header h1 { margin:0 20px 15px 20px; font-size:0; line-height:1; padding-top:15px; }
header ul.gnb { height:1%; list-style:none; margin:0; margin-left:20px; padding:0; border-left:1px solid #555555; }
header >/**/ ul.gnb { height:auto; }
header ul.gnb:after { content:""; clear:both; display:block; }
header ul.gnb li { display:block; float:left; }
header ul.gnb li a:link,
header ul.gnb li a:visited { display:block;  width:100px; padding:10px; color:#d5d5d5; background:#404149; border:1px solid #555555; border-left:0; text-align:center; }
header ul.gnb li a:hover,
header ul.gnb li a:active { background:#505159; color:#ffffff; text-decoration:none; }
header ul.gnb li a.active { background:#ffffff !important; color:#cb0000 !important; text-decoration:none; border-bottom-color:#ffffff !important; font-weight:bold; }
footer { margin:0 auto; border-top:1px solid #dfdfdf; margin-top:20px; margin-bottom:20px; text-align:center; padding-top:20px;}
div.side { position:absolute; right:10px; top:10px; color:#dddddd; font:11px dotum; letter-spacing:-1px; }
div.side a { color:#ffffff !important; }
div.side02 { position:absolute; right:55px; top:33px; color:#dddddd; font:11px dotum; letter-spacing:-1px; }
div.side03 { position:absolute; right:11px; top:49px; color:#ffffff; font:11px dotum; font-size:12px; }
footer p { font:11px verdana; letter-spacing:-1px; color:#666666; }
footer span { border-right:1px solid #aaaaaa; display:inline-block; height:7px; width:1px; }
.panel { padding:10px; margin:10px; }
div.navi { border:1px solid #dfdfdf; padding:5px 0 5px 0; margin:10px 0; }
div.navi02 {float:left; border:1px solid #dfdfdf; padding:5px 0 5px 0; margin:10px 0; }
div.navi03 {float:left; border:1px solid #dfdfdf; padding:5px 0 5px 0; margin:10px 0; }
div.nav { background:url('/adm/img/nav_bg.gif') repeat-x left bottom;  height:1%; }
div.navi >/**/ div.nav { height:auto; }
div.navi02 >/**/ div.nav { height:auto; }
div.nav ul { float:left; list-style:none; margin:0; padding:0; border-left:1px solid #aaaaaa; padding-right:5px; }
div.nav >/**/ ul { height:auto; }
div.nav:after { content:""; clear:both; display:block; }
div.nav li { float:left; display:block; border:1px solid #aaaaaa; border-left:0; }
div.nav li a { display:block; width:110px; text-align:center; padding:7px; background:#efefef; }
div.nav li.active { border-bottom-color:#ffffff;  }
div.nav li.active a { background:#ffffff; }
div.navi form { display:inline; }
div.navi label,

div.navi div { clear:both; padding-top:10px;}
table.list { border-collapse:collapse; width:100%;border-top:2px solid #0e87f9; }
table.list th { font:11px dotum; letter-spacing:-1px; padding:10px 0; border-bottom:2px solid #333333; }
table.list td { border:1px solid #dfdfdf; text-align:center; padding:5px; }
table.list td.right {text-align:right;padding:0 20px 0 0;}
table.list02 { border-collapse:collapse; width:1000px;border-top:2px solid #0e87f9; }
table.list02 th { font:11px dotum; letter-spacing:-1px; padding:10px 0; border-bottom:2px solid #333333; }
table.list02 td { border:1px solid #dfdfdf; text-align:left; padding:5px 5px 5px 10px; }
table.list02 td.head {padding:0 0 0 20px;font-weight:bold;background:#f3f3f3;color:#656565;}
table.list03 { border-collapse:collapse; width:1000px; text-align:center;border-top:2px solid #0e87f9;}
table.list03 th { font:11px dotum; letter-spacing:-1px; padding:10px 0; border-bottom:2px solid #333333; }
table.list03 td { border:1px solid #dfdfdf; text-align:left; padding:5px;text-align:center; }
table.list03 td.left { border:1px solid #dfdfdf; text-align:left; padding:5px;text-align:left; }
table.list03 td.right { border:1px solid #dfdfdf; text-align:left; padding:5px 15px 5px 5px;text-align:right; }
table.list03 td.head {padding:0 0 0 20px;font-weight:bold;background:#f3f3f3;color:#656565;}
table.list04 { border-collapse:collapse; width:495px; text-align:center;border-top:2px solid #0e87f9;}
table.list04 th { font:11px dotum; letter-spacing:-1px; padding:10px 0; border-bottom:2px solid #333333; }
table.list04 td { border:1px solid #dfdfdf; text-align:left; padding:5px; }
table.list04 td.left { border:1px solid #dfdfdf; text-align:left; padding:5px;text-align:left; }
table.list04 td.head {padding:0 0 0 8px;font-weight:bold;background:#f3f3f3;color:#656565;text-align:left;}
table.list05 { border-collapse:collapse; width:592px; text-align:center;border-top:2px solid #0e87f9;}
table.list05 th { font:11px dotum; letter-spacing:-1px; padding:10px 0; border-bottom:2px solid #333333; }
table.list05 td { border:1px solid #dfdfdf; text-align:left; padding:5px;text-align:center; }
table.list05 td.left { border:1px solid #dfdfdf; text-align:left; padding:5px;text-align:left; }
table.list05 td.right { border:1px solid #dfdfdf; text-align:left; padding:5px 15px 5px 5px;text-align:right; }
table.list05 td.head {padding:0 0 0 20px;font-weight:bold;background:#f3f3f3;color:#656565;}
table.list06 { border-collapse:collapse; width:755px;border-top:2px solid #0e87f9; }
table.list06 th { font:11px dotum; letter-spacing:-1px; padding:10px 0; border-bottom:2px solid #333333; }
table.list06 td { border:1px solid #dfdfdf; text-align:left; padding:5px 5px 5px 10px; }
table.list06 td.head {padding:0 0 0 20px;font-weight:bold;background:#f3f3f3;color:#656565;}
table.list07 { border-collapse:collapse; width:755px; text-align:center;border-top:2px solid #0e87f9;}
table.list07 th { font:11px dotum; letter-spacing:-1px; padding:10px 0; border-bottom:2px solid #333333; }
table.list07 td { border:1px solid #dfdfdf; text-align:left; padding:5px;text-align:center; }
table.list07 td.left { border:1px solid #dfdfdf; text-align:left; padding:5px;text-align:left; }
table.list07 td.right { border:1px solid #dfdfdf; text-align:left; padding:5px 15px 5px 5px;text-align:right; }
table.list07 td.head {padding:0 0 0 20px;font-weight:bold;background:#f3f3f3;color:#656565;}

.latest { position:absolute; top:30px; right:10px; background:#444444; border:1px solid #555555; padding-bottom:8px; }

.blue {color:#1275e0;}
.blue1 {color:#1275e0;font-weight:bold;}
.red {color:#ee020d;}
.red1 {color:#ee020d;font-weight:bold;}
.orange {color:#fb7c00;}
.orange1 {color:#fb7c00;font-weight:bold;}

.RoomCal2 {float:left;width:961px;margin:24px 0 0 0;}
.RoomCalTop2 {float:left;width:958px;}
.RoomCaltopBtn2 {float:left;width:275px;}
.RoomCaltopBtn2 ul {float:left;padding:0 0 0 5px;}
.RoomCaltopBtn2 ul li {float:left;}
.RoomCaltopBtn2 ul li.tw {margin:0;padding:0 0 0 5px;}
.RoomCaltopBtn2 ul li.two {margin:2px 0 0 0;padding:0 0 0 11px;}
.RoomCaltopBtn2 ul li.th {margin:2px 0 0 0;padding:0 0 0 2px;}
.RoomCaltopBtn2 ul li.fo {margin:2px 0 0 0;padding:0 0 0 2px;}
.RoomCaltopBtn2 ul li.fo1 {margin:1px 0 0 0;padding:0 0 0 6px;}
.RoomCaltopBtn2 ul li.last {padding:0 0 0 11px;}
.RoomCaltopBtn2 ul li.last02 {margin:0;padding:0 0 0 11px;}

.total04 {float:right;width:924px;margin:45px 0 0 0;position:relative;}
.total04 dl {float:left; }
.total04 dt,
.total04 dd { float:left; padding:3px 0 3px 0; margin:0; }
.total04 dd.po { width:29px;border:0px;background:none; }
.total04 dt { padding:0 13px 0 0;margin:12px 0 0 0;}
.total04 dd { border:1px solid #c8c8c8; background-color:#f6f6f6; color:#dc0000;font:bold 15px 'arial black'; width:102px; text-align:right; }
.total04 dd.btn {float:left;border:0px; margin:0 0 0 0;padding:0 0 0 10px;width:96px;}
.total04 dd.btn02 {float:left;border:0px; margin:0 0 0 0;padding:0 0 0 10px;width:82px;}
.total04 dd.btn03 {float:left;border:0px; margin:0 0 0 0;padding:0 0 0 6px;width:82px;}
.total04 dd.btn04 {float:left;border:0px; margin:0 0 0 0;padding:0 0 0 6px;width:79px;}

.total04 dd span { font:bold 12px dotum; }
.total04 dd span.price { color:#dc0000; font:bold 15px 'arial black'; }

.total05 {float:right;width:814px;margin:45px 0 0 0;position:relative;}
.total05 dl {float:left; }
.total05 dt,
.total05 dd { float:left; padding:3px 0 3px 0; margin:0; }
.total05 dd.po { width:29px;border:0px;background:none; }
.total05 dt { padding:0 13px 0 0;margin:12px 0 0 0;}
.total05 dd { border:1px solid #c8c8c8; background-color:#f6f6f6; color:#dc0000;font:bold 15px 'arial black'; width:102px; text-align:right; }
.total05 dd.btn {float:left;border:0px; margin:0 0 0 0;padding:0 0 0 10px;width:96px;}
.total05 dd.btn02 {float:left;border:0px; margin:0 0 0 0;padding:0 0 0 10px;width:79px;}
.total05 dd.btn03 {float:left;border:0px; margin:0 0 0 0;padding:0 0 0 6px;width:46px;}

.total05 dd span { font:bold 12px dotum; }
.total05 dd span.price { color:#dc0000; font:bold 15px 'arial black'; }
/*.total03 dd span#totalAmt_ter { color:#dc0000; font:bold 15px 'arial black'; }
.total03 dd span#totalAmt_tot { color:#dc0000; font:bold 15px 'arial black'; }*/
.Pos01 {position:absolute;top:-22px;*top:-32px;_top:-32px;left:52px;}
.Pos02 {position:absolute;top:-22px;*top:-32px;_top:-32px;left:160px;*left:156;_left:156px;}
.Pos03 {position:absolute;top:-22px;*top:-32px;_top:-32px;left:292px;*left:287;_left:287px;}
.Pos04 {position:absolute;top:-22px;*top:-32px;_top:-32px;left:450px;*left:445;_left:445px;}
.Pos05 {position:absolute;top:-22px;*top:-32px;_top:-32px;left:584px;*left:577;_left:577px;}
.Pos06 {position:absolute;top:9px;*top:-4px;_top:-4px;left:111px;*left:109;_left:109px;}
.Pos07 {position:absolute;top:9px;*top:-4px;_top:-4px;left:244px;*left:240;_left:240px;}
.Pos08 {position:absolute;top:9px;*top:-4px;_top:-4px;left:377px;*left:371;_left:371px;}
.Pos09 {position:absolute;top:9px;*top:-4px;_top:-4px;left:510px;*left:502;_left:502px;}
.Pos10 {position:absolute;top:11px;*top:1px;_top:1px;left:633px;}

.Pos11 {position:absolute;top:52px;*top:34px;_top:34px;left:52px;}
.Pos12 {position:absolute;top:52px;*top:34px;_top:34px;left:160px;*left:156;_left:156px;}
.Pos13 {position:absolute;top:52px;*top:34px;_top:34px;left:292px;*left:287;_left:287px;}
.Pos14 {position:absolute;top:52px;*top:34px;_top:34px;left:450px;*left:445;_left:445px;}
.Pos15 {position:absolute;top:52px;*top:34px;_top:34px;left:584px;*left:577;_left:577px;}
.Pos16 {position:absolute;top:81px;*top:62px;_top:62px;left:111px;*left:109;_left:109px;}
.Pos17 {position:absolute;top:81px;*top:62px;_top:62px;left:244px;*left:240;_left:240px;}
.Pos18 {position:absolute;top:81px;*top:62px;_top:62px;left:377px;*left:371;_left:371px;}
.Pos19 {position:absolute;top:81px;*top:62px;_top:62px;left:510px;*left:502;_left:502px;}
.Pos20 {position:absolute;top:11px;*top:1px;_top:1px;left:633px;}


</style>

<body leftmargin=0 topmargin=0>
