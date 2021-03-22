<?php
/*
include "../dbconfig.php";
include "../configexpand.php";
$connect = @mysql_connect($cfg[mysql_host], $cfg[mysql_user], $cfg[mysql_pass]);
$select_db = @mysql_select_db($cfg[mysql_db], $connect);
$result = mysql_query(" select de_banktown_auth_key from $cfg[table_yc_default] ");
$banktown_auth_key = @mysql_result($result, 0);
*/

include_once("./_common.php");
$banktown_auth_key = $default['de_banktown_auth_key'];

//이 페이지는 수정하지 마십시요. 수정시 html태그나 자바스크립트가 들어가는 경우 동작을 보장할 수 없습니다

//관련 db처리는 callback.php에서 참조하는 함수 noti_success(),noti_failure(),noti_progress(),noti_hash_err()에서 관련 루틴을 추가하시면 됩니다
//위의 각 함수에는 현재 결제에 관한 log남기게 됩니다. 회원사서버에서 남기실 절대경로로 맞게 수정하여 주세요

//hash데이타값이 맞는 지 확인 하는 루틴은 뱅크타운에서 받은 데이타가 맞는지 확인하는 것이므로 꼭 사용하셔야 합니다
//정상적인 결제 건임에도 불구하고 노티 페이지의 오류나 네트웍 문제 등으로 인한 hash 값의 오류가 발생할 수도 있습니다.
//그러므로 hash 오류건에 대해서는 오류 발생시 원인을 파악하여 즉시 수정 및 대처해 주셔야 합니다.
//그리고 정상적으로 data를 처리한 경우에도 뱅크타운에서 응답을 받지 못한 경우는 결제결과가 중복해서 나갈 수 있으므로 관련한 처리도 고려되어야 합니다.

// 회원사 callback function page
include("./settle_banktown_callback.php");

// 뱅크타운 noti server에서 받은 value
$P_STATUS;	// 거래상태 : 0021(성공), 0031(실패), 0000(진행)
$P_TR_NO;    	// 거래번호
$P_AUTH_DT;     // 승인시간
$P_TYPE;        // 거래종류 (CARD, BANK)
$P_MID;    	// 회원사아이디
$P_OID;   	// 주문번호
$P_FN_CD1;   	// 금융사코드1 (은행코드, 카드코드)
$P_FN_CD2;   	// 금융사코드2 (은행코드, 카드코드)
$P_FN_NM;   	// 금융사명 (은행명, 카드사명)
$P_UNAME;       // 주문자명
$P_AMT;      	// 거래금액
$P_NOTI;        // 주문정보
$P_RMESG1;      // 메시지1
$P_RMESG2;      // 메시지2
$P_AUTH_NO;     // 승인번호

$resp = false;

$P_HASH = get_param(P_HASH);
$P_STATUS = get_param(P_STATUS);
$P_TR_NO = get_param(P_TR_NO);
$P_AUTH_DT = get_param(P_AUTH_DT);
$P_TYPE = get_param(P_TYPE);
$P_MID = get_param(P_MID);
$P_OID = get_param(P_OID);
$P_FN_CD1 = get_param(P_FN_CD1);
$P_FN_CD2 = get_param(P_FN_CD2);
$P_FN_NM = get_param(P_FN_NM);
$P_UNAME = get_param(P_UNAME);
$P_AMT = get_param(P_AMT);
$P_NOTI = get_param(P_NOTI);
$P_RMESG1 = get_param(P_RMESG1);
$P_RMESG2 = get_param(P_RMESG2);
$P_AUTH_NO = get_param(P_AUTH_NO);

/* mid가 bt_test인 경우에 사용합니다
   해당 회원사 id당 하나의 auth_key가 발급됩니다
   발급받으신 라이센스 키(auth_key)를 설정하셔야 합니다 */
//$PG_AUTH_KEY = "1dffe7648bbd6defe69bd50112f0badc";
$PG_AUTH_KEY = $banktown_auth_key;

$md5_hash = md5($P_STATUS.$P_TR_NO.$P_AUTH_DT.$P_TYPE.$P_MID.$P_OID.$P_AMT.$PG_AUTH_KEY);

$value = array("P_STATUS"  => $P_STATUS,
			   "P_TR_NO"   => $P_TR_NO,
			   "P_AUTH_DT" => $P_AUTH_DT,
			   "P_TYPE"    => $P_TYPE,
			   "P_MID"     => $P_MID,
			   "P_OID"     => $P_OID,
			   "P_FN_CD1"  => $P_FN_CD1,
			   "P_FN_CD2"  => $P_FN_CD2,
			   "P_FN_NM"   => $P_FN_NM,
			   "P_UNAME"   => $P_UNAME,
			   "P_AMT"     => $P_AMT,
			   "P_NOTI"    => $P_NOTI,
			   "P_RMESG1"  => $P_RMESG1,
			   "P_RMESG2"  => $P_RMESG2,
			   "P_AUTH_NO" => $P_AUTH_NO,
			   "P_HASH"    => $P_HASH,
			   "HashData"  => $md5_hash );

	if ($md5_hash == $P_HASH) {
			if($P_STATUS == "0021"){
				$resp = noti_success($value);

				$noti_param = split(",", $P_NOTI);
				for($i = 0; $i < sizeof($noti_param); $i++) {
					$name_value = split("=", $noti_param[$i]);
					if($name_value[0] == "name1") {
							$name1 = $name_value[1];
					}
					else if($name_value[0] == "name2") {
							$name2 = $name_value[1];
					}
				}

				$on_uid = $name2;

				$ymd = sprintf("%s-%s-%s", substr($P_AUTH_DT,0,4), substr($P_AUTH_DT,4,2), substr($P_AUTH_DT,6,2));
				$hms = sprintf("%s:%s:%s", substr($P_AUTH_DT,8,2), substr($P_AUTH_DT,10,2), substr($P_AUTH_DT,12,2));
				// 신용카드내역에 생성
				$sql = "insert $g4[yc4_card_history_table]
						   set od_id = '$P_OID',
							   on_uid = '$on_uid',
							   cd_mall_id = '$P_MID',
							   cd_amount = '$P_AMT',
							   cd_app_no = '$P_AUTH_NO',
							   cd_app_rt = '$P_STATUS',
							   cd_trade_ymd = '$ymd',
							   cd_trade_hms = '$hms',
							   cd_opt01 = '$name1',
							   cd_time = '$g4[time_ymdhis]',
							   cd_ip = '$_SERVER[REMOTE_ADDR]' ";
				sql_query($sql, false);

                if ($P_TYPE == 'CARD') {
                    // 주문서의 카드입금 수정
                    // 크래킹의 우려도 있으므로 on_uid 도 같이
                    $sql = " update $g4[yc4_order_table]
                                set od_receipt_card = '$P_AMT',
                                    od_card_time = '$g4[time_ymdhis]'
                              where od_id = '$P_OID'
                                and on_uid = '$on_uid' ";
                } else {
                    $sql = " update $g4[yc4_order_table]
                                set od_bank_account = '$P_FN_NM',
                                    od_receipt_bank = '$P_AMT',
                                    od_bank_time = '$g4[time_ymdhis]'
                              where od_id = '$P_OID'
                                and on_uid = '$on_uid' ";
                }
				sql_query($sql, false);

			}else if($P_STATUS == "0031" || $P_STATUS == "0032"){
				$resp = noti_failure($value);
			}else if($P_STATUS == "0000"){
				$resp = noti_progress($value);
			}else{
				$resp = false;
			}
	}
	else {
			noti_hash_err($value);
	}

if($resp){
	echo "OK";
}else{
	echo "FAIL";
}
?>