<?include_once("./naverPay_cfg.php");?>
<?if( (!$npay_istest || ($member["mb_id"]==$default["de_npay_testid"] || $member["mb_id"]=="itmaster")) &&  get_it_stock_qty($it_id, "", true)>0){?>

   
        <?if($npay_istest){?>
            <script type="text/javascript" src="//test-pay.naver.com/customer/js/naverPayButton.js" charset="UTF-8"></script>
        <?} else {?>
            <script type="text/javascript" src="//pay.naver.com/customer/js/naverPayButton.js" charset="UTF-8"></script>
        <?}?>

    
        <script type="text/javascript" >

        function buy_nc(url) {

            var f = document.fitem;
            var tmp = f.action;
            if(!validate()) return;
            f.target = "_blank";
            f.action = url;
            f.submit();
            f.target = "";
            f.action = tmp;
            
        }
        function wishlist_nc(url)
        {
            jQuery.ajax({
                type:'post',
                url:"./_ajax.naverPaywishlist.php",
                data:{it_id:"<?=$it_id?>",image_url:"<?=$image_url?>",thumb_url:"<?=$thumb_url?>"},
                contentType:"application/x-www-form-urlencoded;charset=utf-8",
                global:false,
                success:function(data){
                    // 네이버 페이로 찜 정보를 등록하는 가맹점 페이지 팝업 창 생성.
                    // 해당 페이지에서 찜 정보 등록 후 네이버 페이 찜 페이지로 이동.
                    window.open(url,"","scrollbars=yes,width=400,height=267");
                },
                error:function(e,o,x){
                    alert(x.status+"|"+x.responseText+"|"+e);
                }
            });
        }

        naver.NaverPayButton.apply({
            BUTTON_KEY: "<?=$npay_btnkey?>", // 네이버 페이에서 제공받은 버튼 인증 키 입력
            TYPE: "A", // 버튼 모음 종류 설정
            COLOR: 1, // 버튼 모음의 색 설정
            COUNT: 2, // 버튼 개수 설정. 구매하기 버튼만 있으면(장바구니 페이지) 1, 찜하기 버튼도 있으면(상품 상세 페이지) 2를 입력.
            ENABLE: "Y", // 품절 등의 이유로 버튼 모음을 비활성화할 때에는 "N" 입력
            BUY_BUTTON_HANDLER: buy_nc,
            BUY_BUTTON_LINK_URL:"./naverPay.php",
            WISHLIST_BUTTON_HANDLER:wishlist_nc, // 찜하기 버튼 이벤트 Handler 함수 등록
            WISHLIST_BUTTON_LINK_URL:"./naverPaywishlist.php", // 찜하기 팝업 링크 주소
            "":""
        });
        </script>

<?}?>