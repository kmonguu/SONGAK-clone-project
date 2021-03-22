<?
include_once("./_common.php");

include_once("./head.php");
?>


<style>
    .ellipsis {white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    /* 투명 셀렉트박스 */
    .transparent_sltbox {width:107%;height:100%; position:absolute; top:0px; left:0px; opacity:0;}
    .transparent_chkbox {width:107%;height:100%; position:absolute; top:0px; left:0px; opacity:0; margin:0 0 0 15%;}
    .transparent_radio {width:107%;height:100%; position:absolute; top:0px; left:0px; opacity:0; margin:0 0 0 15%;}
    .transparent_date {width:107%;height:100%; position:absolute; top:0px; left:0px; opacity:0;}
</style>

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


<section class="sub">


<? include_once("{$g4["mpath"]}/include/{$totp}.php")?>
<? if(file_exists("{$g4["mpath"]}/include/{$totp}.php")) { $tot = "XXX";} ?>


</section>


<?
include_once("./tail.php");
?>