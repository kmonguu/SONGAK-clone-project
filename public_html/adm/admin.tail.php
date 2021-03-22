<?
if (!defined("_GNUBOARD_")) exit;
?>

</td>
</tr>
<tr><td colspan=3 height=22 bgcolor=#F2F2F2 align=right><a href='#gnuboard4_admin_head'><img src='<?=$g4['admin_path']?>/img/top.gif' border=0></a>&nbsp;</td></tr>
</table><br><br>
<!-- <p>실행시간 : <?=get_microtime() - $begin_time;?> -->

<script type='text/javascript' src='<?=$g4['admin_path']?>/admin.js'></script>
<script>
    $(".tooltip").tooltipsy({
		'alignTo':'cursor',
		'offset':[10,10],
        css: {
            'padding': '10px',
            'max-width': '300px',
            'color': '#FFFFFF',
            'background-color': '#000000',
            'border': '1px solid #000000',
            'box-shadow': 'gray 3px 3px 3px',
            'text-shadow': 'none',
            'border-radius': '5px',
            'opacity':'0.75'
        }
    });

</script>

<? 
include_once("$g4[path]/tail.sub.php");
?>