<?
include_once("./_common.php");

$sql = " select it_name from $g4[yc4_item_table] where it_id='$it_id' ";
$row = sql_fetch_array(sql_query($sql));

$imagefile = "$g4[path]/data/item/$img";
$size = getimagesize($imagefile);

$g4[title] = "$row[it_name] ($it_id)";
include_once("$g4[path]/head.sub.php");
?>
<br>
<div align=center>
    <a href='#' onclick='window.close();'><img id='largeimage' src='<?=$imagefile?>' width='<?=$size[0]?>' height='<?=$size[1]?>' alt='<?=$row[it_name]?>' border=0 style='border:1 solid #E4E4E4;'></a>
</div>
<p>
<table width=100% cellpadding=0 cellspacing=0>
<tr>
    <td width=30% align=center><a href='#' onclick='window.close();'><span class="btn1-o">창닫기</span></a></td>
    <td width=70% align=right>
        <?
        for ($i=1; $i<=5; $i++)
        {
            if (file_exists("$g4[path]/data/item/{$it_id}_l{$i}"))
                echo "<img id='large{$i}' src='$g4[path]/data/item/{$it_id}_l{$i}' border=0 width=50 height=50 style='border:1 solid #E4E4E4;'
                    onmouseover=\"document.getElementById('largeimage').src=document.getElementById('large{$i}').src;\"> &nbsp;";
        }
        ?>
        &nbsp;</td>
</tr>
</table>
<?
include_once("$g4[path]/tail.sub.php");
?>