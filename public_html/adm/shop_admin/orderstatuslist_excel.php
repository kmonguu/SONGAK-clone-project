<?php
include_once("./_common.php");

if($member[mb_level]<10) alert("권한이 없습니다.");
//if(count($excel_chkbox) == 0) alert("선택된 데이터가 없습니다.");

/*$IN_SQL = "";
for($i=0;$i<count($excel_chkbox);$i++){
	if($IN_SQL=="") $IN_SQL .= $excel_chkbox[$i];
	else $IN_SQL .= ",".$excel_chkbox[$i];
}*/


if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once $g4["path"].'/lib/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Document")
							 ->setSubject("Office 2007 XLSX Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("result file");

// 기본셋팅
$objPHPExcel->getDefaultStyle()->getFont()->setName('굴림체')
                                          ->setSize(12);
// data row ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*$sql = "SELECT a.*, b.it_name, b.ct_qty, b.ct_status FROM yc4_order a INNER JOIN (SELECT on_uid, it_name, ct_qty, ct_status FROM yc4_cart a INNER JOIN yc4_item b ON a.it_id = b.it_id) b ON a.on_uid = b.on_uid
			WHERE a.od_id IN(".$IN_SQL.")
";*/

if(isset($_REQUEST["sel_field"])) $sel_field = $_REQUEST["sel_field"]; else $sel_field = "";
if(isset($_REQUEST["search"])) $search = $_REQUEST["search"]; else $search = "";
if(isset($_REQUEST["sort1"])) $sort1 = $_REQUEST["sort1"]; else $sort1 = "";
if(isset($_REQUEST["sort2"])) $sort2 = $_REQUEST["sort2"]; else $sort2 = "";


$where = " where ";
$sql_search = "";
if ($search != "") {
    if ($sel_field == "c.ca_id") {
    	$sql_search .= " $where $sel_field like '$search%' ";
        $where = " and ";
    } else if ($sel_field != "") {
    	$sql_search .= " $where $sel_field like '%$search%' ";
        $where = " and ";
    }

    if ($save_search != $search)
        $page = 1;
}

if ($sel_field == "")  $sel_field = "od_id";
if ($sort1 == "") $sort1 = "od_id";
if ($sort2 == "") $sort2 = "desc";

$sql_common = " from $g4[yc4_order_table] a
                left join $g4[yc4_cart_table] b on (a.on_uid = b.on_uid)
                left join $g4[yc4_item_table] c on (b.it_id = c.it_id)
                $sql_search ";


//$excel_sql = str_replace("\\","",$excel_sql);
$excel_sql = "select a.*,
				 b.ct_id,
				 b.it_id as it_id,
                 b.it_opt1,
                 b.it_opt2,
                 b.it_opt3,
                 b.it_opt4,
                 b.it_opt5,
                 b.it_opt6,
                 b.it_option1,
                 b.it_option2,
                 b.it_option3,
                 b.it_option_amount,
                 b.ct_status,
                 b.ct_qty,
                 b.ct_amount,
                 b.ct_point,
                 (b.ct_qty * b.ct_amount) as ct_sub_amount,
                 (b.ct_qty * b.ct_point)  as ct_sub_point,
                 c.it_id,
                 c.it_name,
                 c.it_opt1_subject,
                 c.it_opt2_subject,
                 c.it_opt3_subject,
                 c.it_opt4_subject,
                 c.it_opt5_subject,
                 c.it_opt6_subject
				 ".$sql_common."
";
$result = sql_query($excel_sql);


$LCMN = "N";
// 기본필드
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', '고객주문처명')
			->setCellValue('B1', '주문번호')
			->setCellValue('C1', '노출상품명(옵션명)')
			->setCellValue('D1', '구매수(수량)')
			->setCellValue('E1', '주문자')
			->setCellValue('F1', '주문자 이동통신')
			->setCellValue('G1', '주문자 전화번호')
			->setCellValue('H1', '수취인이름')
			->setCellValue('I1',  '수취인 전화번호')
			->setCellValue('J1', '수취인 전화번호')
			->setCellValue('K1', '우편번호')
			->setCellValue('L1', '주소')
			->setCellValue('M1', '배송메시지')
			->setCellValue('N1', '운송장번호');

$optObj = new Yc4ItemOption();
$i = 1;
$save_odid = array(); //다중배송지는 주문번호 1번만 읽어오면 됨
for($idx=2;$row=sql_fetch_array($result);$idx++){
	
	if($row["od_delivery_cnt"] <= 1) {

		$i++;
        $it_name = $row["it_name"];
        if($row["it_option1"]) {
            $it_name .= " / ".$optObj->print_option_cart($row["it_id"], $row["it_option1"], $row["it_option2"], $row["it_option3"], $row["it_option_amount"])." / ";
        }
		$it_name .= print_item_options_excel($row["it_id"], $row["it_opt1"], $row["it_opt2"], $row["it_opt3"], $row["it_opt4"], $row["it_opt5"], $row["it_opt6"]);
		

		$od_hp = preg_replace("/(0(?:2|[0-9]{2}))([0-9]+)([0-9]{4}$)/", "\\1-\\2-\\3", $row["od_hp"]);
		$od_tel = preg_replace("/(0(?:2|[0-9]{2}))([0-9]+)([0-9]{4}$)/", "\\1-\\2-\\3", $row["od_tel"]);
		$od_b_hp = preg_replace("/(0(?:2|[0-9]{2}))([0-9]+)([0-9]{4}$)/", "\\1-\\2-\\3", $row["od_b_hp"]);
		$od_b_tel = preg_replace("/(0(?:2|[0-9]{2}))([0-9]+)([0-9]{4}$)/", "\\1-\\2-\\3", $row["od_b_tel"]);

		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$i, '홈페이지')
					->setCellValue('B'.$i, $row["od_id"])
					->setCellValue('C'.$i, $it_name)
					->setCellValue('D'.$i, $row["ct_qty"])
					->setCellValue('E'.$i, $row["od_name"])
					->setCellValue('F'.$i, $od_hp)
					->setCellValue('G'.$i, $od_tel)
					->setCellValue('H'.$i, $row["od_b_name"])
					->setCellValue('I'.$i, $od_b_hp)
					->setCellValue('J'.$i, $od_b_tel)
					->setCellValue('K'.$i, $row["od_b_zip1"])
					->setCellValue('L'.$i, $row["od_b_addr1"]." ".$row["od_b_addr2"])
					->setCellValue('M'.$i, $row["od_memo"])
					->setCellValue('N'.$i, $row["od_invoice"])
					->setCellValue('O'.$i, $row["ct_id"]);

		$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(21);

	} else {
		
		if(in_array($row["od_id"], $save_odid)) {
			continue;
		}
		$save_odid[] = $row["od_id"];
		
		$mdObj = new Yc4MultiDelivery();
		$mdResult = $mdObj->get_list($row["od_id"], 1, "", "", "", "", PHP_INT_MAX, "", "");
		$mdlist = $mdResult["list"];
		$cnt = 0;
		for($idx = 0 ; $idx < count($mdlist); $idx++){
			$md = $mdlist[$idx];
			$cnt++;
			
			$qty_list = $md["md_qty"];
			$qtys = explode("||", $qty_list);
			foreach($qtys as $qtystr) {
				
                $qs = explode("|", $qtystr);
                $qsname = urldecode($qs[0]);
                $qsname = str_replace("<br/>", " / ", $qsname);
                $qsname = str_replace("<br>", " / ", $qsname);
                $qsname = str_replace("</li>", " / </li>", $qsname);
                $qsname = str_replace("</span>", " =</span> ", $qsname);
				$it_name = "[배송지{$cnt}] - ".strip_tags($qsname);
				$qty = $qs[1];

				$i++;
				$od_hp = preg_replace("/(0(?:2|[0-9]{2}))([0-9]+)([0-9]{4}$)/", "\\1-\\2-\\3", $row["od_hp"]);
				$od_tel = preg_replace("/(0(?:2|[0-9]{2}))([0-9]+)([0-9]{4}$)/", "\\1-\\2-\\3", $row["od_tel"]);
				$od_b_hp = preg_replace("/(0(?:2|[0-9]{2}))([0-9]+)([0-9]{4}$)/", "\\1-\\2-\\3", $md["md_hp"]);
				$od_b_tel = preg_replace("/(0(?:2|[0-9]{2}))([0-9]+)([0-9]{4}$)/", "\\1-\\2-\\3", $row["md_tel"]);

				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$i, '홈페이지')
							->setCellValue('B'.$i, $row["od_id"])
							->setCellValue('C'.$i, $it_name)
							->setCellValue('D'.$i, $qty)
							->setCellValue('E'.$i, $row["od_name"])
							->setCellValue('F'.$i, $od_hp)
							->setCellValue('G'.$i, $od_tel)
							->setCellValue('H'.$i, $row["od_b_name"])
							->setCellValue('I'.$i, $od_b_hp)
							->setCellValue('J'.$i, $od_b_tel)
							->setCellValue('K'.$i, $md["md_zip1"])
							->setCellValue('L'.$i, $md["md_addr1"]." ".$md["md_addr2"])
							->setCellValue('M'.$i, $md["md_memo"])
							->setCellValue('N'.$i, $md["md_invoice"])
							->setCellValue('O'.$i, $row["ct_id"])
							->setCellValue('P'.$i, $md["no"]);

				$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(21);
			}



		}


	}


}
$i++;









//제목부분 스타일
$objPHPExcel->getActiveSheet()->getStyle('A1:'.$LCMN.($i-1))->getFont()->setSize(10);
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
$objPHPExcel->getActiveSheet()->getStyle('A1:'.$LCMN.'1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:'.$LCMN.'1')->applyFromArray(
	array(
		'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'AFAFAF')
        ),
		'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
        )
	)
);
//제목부분 스타일(운송장번호 입력부분)
$objPHPExcel->getActiveSheet()->getStyle('N1')->applyFromArray(
	array(
		'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'EFEFEF')
        ),
		'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
        )
	)
);

// 글자 모양
//$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
//$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
//$objPHPExcel->getActiveSheet()->getStyle('A4:K4')->getFont()->setBold(true);
// cell 높이 너비
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(22);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(65);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(11);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(9);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(64);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(0);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(0);
// 정렬
//$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A2:'.$LCMN.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A2:'.$LCMN.($i-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('C2:C'.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('L2:L'.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('M2:M'.($i-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// cell 병합
//$objPHPExcel->getActiveSheet()->mergeCells('A1:K1');
//$objPHPExcel->getActiveSheet()->mergeCells('A2:K2');


// 테두리
$styleBorder = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => 'FF808080'),
		),
	),
);
$objPHPExcel->getActiveSheet()->getStyle('A1:'.$LCMN.($i-1))->applyFromArray($styleBorder);

// sheet 제목
$objPHPExcel->getActiveSheet()->setTitle('리스트출력');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="ListExcel('.date("Y-m-d").').xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>