<?
include "./_common.php";
include "$g4[path]/lib/etc.lib.php";
	
	setlocale(LC_CTYPE, 'ko_KR.euc-kr');

	// 현금영수증 필드생성    
	$sql = " ALTER TABLE `$g4[yc4_order_table]` ADD `od_cash_no` VARCHAR( 255 ) NOT NULL ,
												ADD `od_cash_receipt_no` VARCHAR( 255 ) NOT NULL ,
												ADD `od_cash_app_time` VARCHAR( 255 ) NOT NULL ,
												ADD `od_cash_reg_stat` VARCHAR( 255 ) NOT NULL ,
												ADD `od_cash_reg_desc` VARCHAR( 255 ) NOT NULL ,
												ADD `od_cash_tr_code` VARCHAR( 255 ) NOT NULL ,
												ADD `od_cash_id_info` VARCHAR( 255 ) NOT NULL ";
	sql_query($sql, false);

	// 현금영수증 사용, 미사용 구분
	$sql = " ALTER TABLE `$g4[yc4_order_table]` ADD `od_cash` TINYINT NOT NULL ";
	sql_query($sql, false);


    /* ============================================================================== */
    /* =   PAGE : 등록/변경 처리 PAGE                                               = */
    /* = -------------------------------------------------------------------------- = */
    /* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
    /* =   접속 주소 : http://testpay.kcp.co.kr/pgsample/FAQ/search_error.jsp       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2010.02.   KCP Inc.   All Rights Reserved.                = */
    /* ============================================================================== */
?>
<?
    /* ============================================================================== */
    /* = 라이브러리 및 사이트 정보 include                                          = */
    /* = -------------------------------------------------------------------------- = */
    require "./pp_cli_cash_hub_lib.php";
    include "./site_conf_inc.php";
    /* ============================================================================== */

    /* ============================================================================== */
    /* =   01. 요청 정보 설정                                                       = */
    /* = -------------------------------------------------------------------------- = */
    $req_tx     = $_POST[ "req_tx"     ];                             // 요청 종류
    $trad_time  = $_POST[ "trad_time"  ];                             // 원거래 시각
    /* = -------------------------------------------------------------------------- = */
    $ordr_idxx  = $_POST[ "ordr_idxx"  ];                             // 주문 번호
    $buyr_name  = iconv("UTF-8", "EUC-KR", $_POST[ "buyr_name" ]); // 주문자 이름
    $buyr_tel1  = $_POST[ "buyr_tel1"  ];                             // 주문자 전화번호
    $buyr_mail  = $_POST[ "buyr_mail"  ];                             // 주문자 E-Mail
    $good_name  = iconv("UTF-8", "EUC-KR", $_POST[ "good_name" ]);   // 상품 정보
    $comment    = iconv("UTF-8", "EUC-KR", $_POST[ "comment" ]);                        // 비고
    /* = -------------------------------------------------------------------------- = */
    $corp_type     = $_POST[ "corp_type"      ];                      // 사업장 구분
    $corp_tax_type = $_POST[ "corp_tax_type"  ];                      // 과세/면세 구분
    $corp_tax_no   = $_POST[ "corp_tax_no"    ];                      // 발행 사업자 번호
    $corp_nm       = iconv("UTF-8", "EUC-KR", $_POST[ "corp_nm" ]);  // 상호
    $corp_owner_nm = iconv("UTF-8", "EUC-KR", $_POST[ "corp_owner_nm"  ]);                      // 대표자명
    $corp_addr     = iconv("UTF-8", "EUC-KR", $_POST[ "corp_addr"  ]);   // 사업장 주소
    $corp_telno    = iconv("UTF-8", "EUC-KR", $_POST[ "corp_telno"  ]);   // 사업장 대표 연락처
    /* = -------------------------------------------------------------------------- = */
    $tr_code    = $_POST[ "tr_code"    ];                             // 발행용도
    $id_info    = $_POST[ "id_info"    ];                             // 신분확인 ID
    $amt_tot    = $_POST[ "amt_tot"    ];                             // 거래금액 총 합
    $amt_sup    = $_POST[ "amt_sup"    ];                             // 공급가액
    $amt_svc    = $_POST[ "amt_svc"    ];                             // 봉사료
    $amt_tax    = $_POST[ "amt_tax"    ];                             // 부가가치세
    /* = -------------------------------------------------------------------------- = */
    $mod_type   = $_POST[ "mod_type"   ];                             // 변경 타입
    $mod_value  = $_POST[ "mod_value"  ];                             // 변경 요청 거래번호
    $mod_gubn   = $_POST[ "mod_gubn"   ];                             // 변경 요청 거래번호 구분
    $mod_mny    = $_POST[ "mod_mny"    ];                             // 변경 요청 금액
    $rem_mny    = $_POST[ "rem_mny"    ];                             // 변경처리 이전 금액
    /* = -------------------------------------------------------------------------- = */
    $cust_ip    = getenv( "REMOTE_ADDR" );                            // 요청 IP
    /* ============================================================================== */


	/* ============================================================================== */
    /* =   02. 인스턴스 생성 및 초기화                                              = */
    /* = -------------------------------------------------------------------------- = */
    $c_PayPlus  = new C_PAYPLUS_CLI;
    $c_PayPlus->mf_clear();
    /* ============================================================================== */


	/* ============================================================================== */
    /* =   03. 처리 요청 정보 설정, 실행                                            = */
    /* = -------------------------------------------------------------------------- = */

    /* = -------------------------------------------------------------------------- = */
    /* =   03-1. 승인 요청                                                          = */
    /* = -------------------------------------------------------------------------- = */
        // 업체 환경 정보
        if ( $req_tx == "pay" )
        {
            $tx_cd = "07010000"; // 현금영수증 등록 요청

            // 현금영수증 정보
            $rcpt_data_set .= $c_PayPlus->mf_set_data_us( "user_type",      $g_conf_user_type );
            $rcpt_data_set .= $c_PayPlus->mf_set_data_us( "trad_time",      $trad_time        );
            $rcpt_data_set .= $c_PayPlus->mf_set_data_us( "tr_code",        $tr_code          );
            $rcpt_data_set .= $c_PayPlus->mf_set_data_us( "id_info",        $id_info          );
            $rcpt_data_set .= $c_PayPlus->mf_set_data_us( "amt_tot",        $amt_tot          );
            $rcpt_data_set .= $c_PayPlus->mf_set_data_us( "amt_sup",        $amt_sup          );
            $rcpt_data_set .= $c_PayPlus->mf_set_data_us( "amt_svc",        $amt_svc          );
            $rcpt_data_set .= $c_PayPlus->mf_set_data_us( "amt_tax",        $amt_tax          );
            $rcpt_data_set .= $c_PayPlus->mf_set_data_us( "pay_type",       "PAXX"            ); // 선 결제 서비스 구분(PABK - 계좌이체, PAVC - 가상계좌, PAXX - 기타)
            //$rcpt_data_set .= $c_PayPlus->mf_set_data_us( "pay_trade_no",   $pay_trade_no ); // 결제 거래번호(PABK, PAVC일 경우 필수)
            //$rcpt_data_set .= $c_PayPlus->mf_set_data_us( "pay_tx_id",      $pay_tx_id    ); // 가상계좌 입금통보 TX_ID(PAVC일 경우 필수)

            // 주문 정보
            $c_PayPlus->mf_set_ordr_data( "ordr_idxx",  $ordr_idxx );
            $c_PayPlus->mf_set_ordr_data( "good_name",  $good_name );
            $c_PayPlus->mf_set_ordr_data( "buyr_name",  $buyr_name );
            $c_PayPlus->mf_set_ordr_data( "buyr_tel1",  $buyr_tel1 );
            $c_PayPlus->mf_set_ordr_data( "buyr_mail",  $buyr_mail );
            $c_PayPlus->mf_set_ordr_data( "comment",    $comment   );

            // 가맹점 정보
            $corp_data_set .= $c_PayPlus->mf_set_data_us( "corp_type",       $corp_type     );

			if ( $corp_type == "1" ) // 입점몰인 경우 판매상점 DATA 전문 생성
            {
			    $corp_data_set .= $c_PayPlus->mf_set_data_us( "corp_tax_type",   $corp_tax_type );
                $corp_data_set .= $c_PayPlus->mf_set_data_us( "corp_tax_no",     $corp_tax_no   );
                $corp_data_set .= $c_PayPlus->mf_set_data_us( "corp_sell_tax_no",$corp_tax_no   );
                $corp_data_set .= $c_PayPlus->mf_set_data_us( "corp_nm",         $corp_nm       );
                $corp_data_set .= $c_PayPlus->mf_set_data_us( "corp_owner_nm",   $corp_owner_nm );
                $corp_data_set .= $c_PayPlus->mf_set_data_us( "corp_addr",       $corp_addr     );
                $corp_data_set .= $c_PayPlus->mf_set_data_us( "corp_telno",      $corp_telno    );
            }

            $c_PayPlus->mf_set_ordr_data( "rcpt_data", $rcpt_data_set );
            $c_PayPlus->mf_set_ordr_data( "corp_data", $corp_data_set );
        }

    /* = -------------------------------------------------------------------------- = */
    /* =   03-2. 취소 요청                                                          = */
    /* = -------------------------------------------------------------------------- = */
        else if ( $req_tx == "mod" )
        {
            if ( $mod_type == "STSQ" )
            {
                $tx_cd = "07030000"; // 조회 요청
            }
            else
            {
                $tx_cd = "07020000"; // 취소 요청
            }

            $c_PayPlus->mf_set_modx_data( "mod_type",   $mod_type   );      // 원거래 변경 요청 종류
            $c_PayPlus->mf_set_modx_data( "mod_value",  $mod_value  );
            $c_PayPlus->mf_set_modx_data( "mod_gubn",   $mod_gubn   );
            $c_PayPlus->mf_set_modx_data( "trad_time",  $trad_time  );

            if ( $mod_type == "STPC" ) // 부분취소
            {
                $c_PayPlus->mf_set_modx_data( "mod_mny",  $mod_mny  );
                $c_PayPlus->mf_set_modx_data( "rem_mny",  $rem_mny  );
            }
        }
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   03-3. 실행                                                               = */
    /* ------------------------------------------------------------------------------ */
        if ( strlen($tx_cd) > 0 )
        {
            $c_PayPlus->mf_do_tx( "",                $g_conf_home_dir, $g_conf_site_id,
                                  "",                $tx_cd,           "",
                                  $g_conf_pa_url,    $g_conf_pa_port,  "payplus_cli_slib",
                                  $ordr_idxx,        $cust_ip,         $g_conf_log_level,
                                  "",                $g_conf_tx_mode,  $g_conf_log_path );
        }
        else
        {
            $c_PayPlus->m_res_cd  = "9562";
            $c_PayPlus->m_res_msg = "연동 오류";
        }
        $res_cd  = $c_PayPlus->m_res_cd;                      // 결과 코드
        $res_msg = $c_PayPlus->m_res_msg;                     // 결과 메시지
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   04. 승인 결과 처리                                                       = */
    /* = -------------------------------------------------------------------------- = */
        if ( $req_tx == "pay" )
        {
            if ( $res_cd == "0000" )
            {
                $cash_no    = $c_PayPlus->mf_get_res_data( "cash_no"    );       // 현금영수증 거래번호
                $receipt_no = $c_PayPlus->mf_get_res_data( "receipt_no" );       // 현금영수증 승인번호
                $app_time   = $c_PayPlus->mf_get_res_data( "app_time"   );       // 승인시간(YYYYMMDDhhmmss)
                $reg_stat   = $c_PayPlus->mf_get_res_data( "reg_stat"   );       // 등록 상태 코드
                $reg_desc   = $c_PayPlus->mf_get_res_data( "reg_desc"   );       // 등록 상태 설명

    /* = -------------------------------------------------------------------------- = */
    /* =   04-1. 승인 결과를 업체 자체적으로 DB 처리 작업하시는 부분입니다.         = */
    /* = -------------------------------------------------------------------------- = */
    /* =         승인 결과를 DB 작업 하는 과정에서 정상적으로 승인된 건에 대해      = */
    /* =         DB 작업을 실패하여 DB update 가 완료되지 않은 경우, 자동으로       = */
    /* =         승인 취소 요청을 하는 프로세스가 구성되어 있습니다.                = */
    /* =         DB 작업이 실패 한 경우, bSucc 라는 변수(String)의 값을 "false"     = */
    /* =         로 세팅해 주시기 바랍니다. (DB 작업 성공의 경우에는 "false" 이외의 = */
    /* =         값을 세팅하시면 됩니다.)                                           = */
    /* = -------------------------------------------------------------------------- = */
                $bSucc = "";             // DB 작업 실패일 경우 "false" 로 세팅


				 $sql = " update $g4[yc4_order_table]
                            set od_cash_no = '$cash_no',
                                od_cash_receipt_no = '$receipt_no',
                                od_cash_app_time = '$app_time',
                                od_cash_reg_stat = '$reg_stat',
                                od_cash_reg_desc = '$reg_desc',
                                od_cash_tr_code = '$tr_code',
                                od_cash_id_info = '$id_info',
                                od_cash = '1'
                          where od_id = '$ordr_idxx' ";
                $result = sql_query($sql);


    /* = -------------------------------------------------------------------------- = */
    /* =   04-2. DB 작업 실패일 경우 자동 승인 취소                                 = */
    /* = -------------------------------------------------------------------------- = */
                if ( $bSucc == "false" )
                {
                    $c_PayPlus->mf_clear();

                    $tx_cd = "07020000"; // 취소 요청

                    $c_PayPlus->mf_set_modx_data( "mod_type",  "STSC"     );                    // 원거래 변경 요청 종류
                    $c_PayPlus->mf_set_modx_data( "mod_value", $cash_no   );
                    $c_PayPlus->mf_set_modx_data( "mod_gubn",  "MG01"     );
                    $c_PayPlus->mf_set_modx_data( "trad_time", $trad_time );

                    $c_PayPlus->mf_do_tx( "",                $g_conf_home_dir, $g_conf_site_id,
                                          "",                $tx_cd,           "",
                                          $g_conf_pa_url,    $g_conf_pa_port,  "payplus_cli_slib",
                                          $ordr_idxx,        $cust_ip,         $g_conf_log_level,
                                          "",                $g_conf_tx_mode );

                    $res_cd  = $c_PayPlus->m_res_cd;
                    $res_msg = $c_PayPlus->m_res_msg;
                }

            }    // End of [res_cd = "0000"]

    /* = -------------------------------------------------------------------------- = */
    /* =   04-3. 등록 실패를 업체 자체적으로 DB 처리 작업하시는 부분입니다.         = */
    /* = -------------------------------------------------------------------------- = */
            else
            {
            }
        }
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   05. 변경 결과 처리                                                       = */
    /* = -------------------------------------------------------------------------- = */
        else if ( $req_tx == "mod" )
        {
            if ( $res_cd == "0000" )
            {
                $cash_no    = $c_PayPlus->mf_get_res_data( "cash_no"    );       // 현금영수증 거래번호
                $receipt_no = $c_PayPlus->mf_get_res_data( "receipt_no" );       // 현금영수증 승인번호
                $app_time   = $c_PayPlus->mf_get_res_data( "app_time"   );       // 승인시간(YYYYMMDDhhmmss)
                $reg_stat   = $c_PayPlus->mf_get_res_data( "reg_stat"   );       // 등록 상태 코드
                $reg_desc   = $c_PayPlus->mf_get_res_data( "reg_desc"   );       // 등록 상태 설명
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-1. 변경 실패를 업체 자체적으로 DB 처리 작업하시는 부분입니다.         = */
    /* = -------------------------------------------------------------------------- = */
            else
            {
            }
        }
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   06. 인스턴스 CleanUp                                                     = */
    /* = -------------------------------------------------------------------------- = */
    $c_PayPlus->mf_clear();
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   07. 폼 구성 및 결과페이지 호출                                           = */
    /* ============================================================================== */


    $res_msg = iconv("cp949", "utf8", $res_msg);    
    $reg_desc = iconv("cp949", "utf8", $reg_desc);
    $good_name = iconv("cp949", "utf8", $good_name);
    $buyr_name = iconv("cp949", "utf8", $buyr_name);
?>

    <html>
    <head>
    <script language = 'javascript'>
        function goResult()
        {
            document.pay_info.submit();
        }
    </script>
    </head>
    <body onload="goResult();">
    <form name="pay_info" method="post" action="./result_cash.php">
        <input type="hidden" name="req_tx"            value="<?=$req_tx?>">            <!-- 요청 구분 -->
        <input type="hidden" name="bSucc"             value="<?=$bSucc?>">             <!-- 쇼핑몰 DB 처리 성공 여부 -->

        <input type="hidden" name="res_cd"            value="<?=$res_cd?>">            <!-- 결과 코드 -->
        <input type="hidden" name="res_msg"           value="<?=$res_msg?>">           <!-- 결과 메세지 -->
        <input type="hidden" name="ordr_idxx"         value="<?=$ordr_idxx?>">         <!-- 주문번호 -->
        <input type="hidden" name="good_name"         value="<?=$good_name?>">         <!-- 상품명 -->
        <input type="hidden" name="buyr_name"         value="<?=$buyr_name?>">         <!-- 주문자명 -->
        <input type="hidden" name="buyr_tel1"         value="<?=$buyr_tel1?>">         <!-- 주문자 전화번호 -->
        <input type="hidden" name="buyr_mail"         value="<?=$buyr_mail?>">         <!-- 주문자 E-mail -->
        <input type="hidden" name="comment"           value="<?=$comment?>">           <!-- 비고 -->

        <input type="hidden" name="corp_type"         value="<?=$corp_type?>">         <!-- 사업장 구분 -->
        <input type="hidden" name="corp_tax_type"     value="<?=$corp_tax_type?>">     <!-- 과세/면세 구분 -->
        <input type="hidden" name="corp_tax_no"       value="<?=$corp_tax_no?>">       <!-- 발행 사업자 번호 -->
        <input type="hidden" name="corp_nm"           value="<?=$corp_nm?>">           <!-- 상호 -->
        <input type="hidden" name="corp_owner_nm"     value="<?=$corp_owner_nm?>">     <!-- 대표자명 -->
        <input type="hidden" name="corp_addr"         value="<?=$corp_addr?>">         <!-- 사업장주소 -->
        <input type="hidden" name="corp_telno"        value="<?=$corp_telno?>">        <!-- 사업장 대표 연락처 -->

        <input type="hidden" name="tr_code"           value="<?=$tr_code?>">           <!-- 발행용도 -->
        <input type="hidden" name="id_info"           value="<?=$id_info?>">           <!-- 신분확인 ID -->
        <input type="hidden" name="amt_tot"           value="<?=$amt_tot?>">           <!-- 거래금액 총 합 -->
        <input type="hidden" name="amt_sub"           value="<?=$amt_sup?>">           <!-- 공급가액 -->
        <input type="hidden" name="amt_svc"           value="<?=$amt_svc?>">           <!-- 봉사료 -->
        <input type="hidden" name="amt_tax"           value="<?=$amt_tax?>">           <!-- 부가가치세 -->
        <input type="hidden" name="pay_type"          value="<?=$pay_type?>">          <!-- 결제 서비스 구분 -->
        <input type="hidden" name="pay_trade_no"      value="<?=$pay_trade_no?>">      <!-- 결제 거래번호 -->

        <input type="hidden" name="mod_type"          value="<?=$mod_type?>">          <!-- 변경 타입 -->
        <input type="hidden" name="mod_value"         value="<?=$mod_value?>">         <!-- 변경 요청 거래번호 -->
        <input type="hidden" name="mod_gubn"          value="<?=$mod_gubn?>">          <!-- 변경 요청 거래번호 구분 -->
        <input type="hidden" name="mod_mny"           value="<?=$mod_mny?>">           <!-- 변경 요청 금액 -->
        <input type="hidden" name="rem_mny"           value="<?=$rem_mny?>">           <!-- 변경처리 이전 금액 -->

        <input type="hidden" name="cash_no"           value="<?=$cash_no?>">           <!-- 현금영수증 거래번호 -->
        <input type="hidden" name="receipt_no"        value="<?=$receipt_no?>">        <!-- 현금영수증 승인번호 -->
        <input type="hidden" name="app_time"          value="<?=$app_time?>">          <!-- 승인시간(YYYYMMDDhhmmss) -->
        <input type="hidden" name="reg_stat"          value="<?=$reg_stat?>">          <!-- 등록 상태 코드 -->
        <input type="hidden" name="reg_desc"          value="<?=$reg_desc?>">          <!-- 등록 상태 설명 -->

	</form>
    </body>
    </html>