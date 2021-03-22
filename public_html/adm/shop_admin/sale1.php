<?
$sub_menu = "500110";
include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$titleTmp = $g4[title];
$g4[title] = "매출현황";
include_once ("$g4[admin_path]/admin.head.php");

$schtype = "";
if(strlen($fr_date) == 10) {
    $sch_fr_date = $fr_date;
    $sch_to_date = $to_date;
    $schtype="date";
}
else if(strlen($fr_date) == 7) {
    $sch_fr_date = $fr_date."-01";
    $sch_to_date = date("Y-m-t", strtotime($to_date."-15"));
    $schtype = "month";
}
else if(strlen($fr_date) == 4) {
    $sch_fr_date = $fr_date."-01-01";
    $sch_to_date = $to_date."-12-31";
    $schtype = "year";
}
else if($date != "") {
    $schtype = "today";
}
?>


<style>
.headon {background-color:#2d2d2d !important; color:#ffffff !important;}
</style>

<?=subtitle($g4[title])?>

<table cellpadding=0 cellspacing=0 border=0 class="list02">
<colgroup width=150></colgroup>
<colgroup width='' bgcolor=#ffffff></colgroup>

<tr height=40>
    <form name=frm_sale_today action='./sale1today.php'>
    <td class="head <?=$schtype=="today" ? "headon" : ""?>">당일 매출현황</td>
    <td align=right>
        <input type="date" name=date size=8 maxlength=8 value='<? echo $date ? $date : date("Y-m-d", $g4['server_time']) ?>' class=ed>
        일 하루
        <input type=submit class=btn1 value='  확  인  '>
    </td>
    </form>
</tr>

<tr height=40>
    <form name=frm_sale_date action='./sale1date.php'>
    <td class="head <?=$schtype=="date" ? "headon" : ""?>">일별 매출현황</td>
    <td align=right>
        <input type="date" name=fr_date size=8 maxlength=8 value='<? echo $sch_fr_date ? $sch_fr_date : date("Y-m-01", $g4['server_time']) ?>' class=ed>
        일 부터
        <input type="date" name=to_date size=8 maxlength=8 value='<? echo $sch_to_date ? $sch_to_date : date("Y-m-d", $g4['server_time']) ?>' class=ed>
        일 까지
        <input type=submit class=btn1 value='  확  인  '>
    </td>
    </form>
</tr>

<tr height=40>
    <form name=frm_sale_month action='./sale1month.php'>
    <td class="head <?=$schtype=="month" ? "headon" : ""?>">월별 매출현황</td>
    <td align=right>
        <input type="month" name=fr_date size=6 maxlength=6 value='<? echo $sch_fr_date ? date("Y-m", strtotime($sch_fr_date)) : date("Y-01", $g4['server_time']) ?>' class=ed>
        월 부터
        <input type="month" name=to_date size=6 maxlength=6 value='<? echo $sch_to_date ? date("Y-m", strtotime($sch_to_date)) : date("Y-m", $g4['server_time']) ?>' class=ed>
        월 까지
        <input type=submit class=btn1 value='  확  인  '>
    </td>
    </form>
</tr>

<tr height=40>
    <form name=frm_sale_year action='./sale1year.php'>
    <td class="head <?=$schtype=="year" ? "headon" : ""?>">연별 매출현황</td>
    <td align=right>
        <input type=text name=fr_date size=4 maxlength=4 value='<? echo $sch_fr_date ? date("Y", strtotime($sch_fr_date)) : date("Y", $g4['server_time'])-1 ?>' class=ed>
        년 부터
        <input type=text name=to_date size=4 maxlength=4 value='<? echo $sch_to_date ? date("Y", strtotime($sch_to_date)) : date("Y", $g4['server_time']) ?>' class=ed>
        년 까지
        <input type=submit class=btn1 value='  확  인  '>
    </td>
    </form>
</tr>

</table>

<br/>
<?
$g4[title] = $titleTmp;
?>