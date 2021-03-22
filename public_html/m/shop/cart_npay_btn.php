
<?
	$shopPath = $g4["shop_path"];
?>
<?include_once("{$shopPath}/naverPay_cfg.php");?>
<?if( (!$npay_istest || ($member["mb_id"]=="npay" || $member["mb_id"]=="itmaster")) && $cartNum>0){?>
<div style="text-align:center; padding:10px 0 40px 0;">
	<?if($npay_istest){?>
		<script type="text/javascript" src="//test-pay.naver.com/customer/js/mobile/naverPayButton_viewport.js" charset="UTF-8"></script>
	<?} else {?>
		<script type="text/javascript" src="//pay.naver.com/customer/js/mobile/naverPayButton_viewport.js" charset="UTF-8"></script>
	<?}?>
	<script type="text/javascript" >
	function buy_nc(url)
	{
		jQuery.ajax({
			type:'post',
			url:"<?=$shopPath?>/_ajax.naverPay.php",
			data:{on_uid:"<?=$s_on_uid?>", is_mobile:"Y"},
			contentType:"application/x-www-form-urlencoded;charset=utf-8",
			global:false,
			success:function(data){
				//네이버 페이로 주문 정보를 등록하는 가맹점 페이지로 이동.
				//해당 페이지에서 주문 정보 등록 후 네이버 페이 주문서 페이지로 이동.
				location.href=url;
			},
			error:function(e,o,x){
				alert(x.status+"|"+x.responseText+"|"+e);
			}
		});
	}

	naver.NaverPayButton.apply({
		BUTTON_KEY: "<?=$npay_btnkey?>", // 네이버 페이에서 제공받은 버튼 인증 키 입력
		TYPE: "MA", // 버튼 모음 종류 설정
		COLOR: 1, // 버튼 모음의 색 설정
		COUNT: 1, // 버튼 개수 설정. 구매하기 버튼만 있으면(장바구니 페이지) 1, 찜하기 버튼도 있으면(상품 상세 페이지) 2를 입력.
		ENABLE: "Y", // 품절 등의 이유로 버튼 모음을 비활성화할 때에는 "N" 입력
		BUY_BUTTON_HANDLER: buy_nc,
		BUY_BUTTON_LINK_URL:"<?=$shopPath?>/naverPaycart.php",
		"":""
	});
	</script>
	</div>
<?}?>