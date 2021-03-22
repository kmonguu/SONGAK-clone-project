<?
include_once("./_common.php");

ob_start();

/*
요약 상품페이지

Field	Status	Notes
<<<begin>>>	필수	상품의 시작을 알리는 필드
<<<mapid>>>		    판매하는 상품의 유니크한 상품ID
<<<pname>>>		    실제 서비스에 반영될 상품명(Title)
<<<price>>>		    해당 상품의 판매가격
<<<ftend>>>	필수	상품의 마지막을 알리는 필드
*/

$lt = "<<<";
$gt = ">>>";

$sql =" select it_id, it_name, it_amount from $g4[yc4_item_table] where it_use = '1' order by ca_id";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++)
{

    echo <<< HEREDOC
{$lt}begin{$gt}
{$lt}mapid{$gt}$row[it_id]
{$lt}pname{$gt}$row[it_name]
{$lt}price{$gt}$row[it_amount]
{$lt}ftend{$gt}

HEREDOC;
}

$content = ob_get_contents();
ob_end_clean();

// 091223 : 네이버에서는 아직 utf-8 을 지원하지 않고 있음
if (strtolower($g4[charset]) == 'utf-8') {
    $content = iconv('utf-8', 'euc-kr', $content);
}

echo $content;
?>