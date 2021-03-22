<?
$sub_menu = "400800";
include_once("./_common.php");

check_demo();

if ($w == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");


if($pop_nm == "" && $w != "d")
	alert("필수 입력값이 입력되지 않았습니다,\\n정상적인 접근이 아닌 것 같습니다.");

include_once("$g4[path]/lib/resizing.lib.php");
$image = new SimpleImage();

@mkdir("$g4[path]/data/popupmng", 0707);
@chmod("$g4[path]/data/popupmng", 0707);



if ($w == "") {
	$sql = " SELECT  (ifnull( max(pop_no) , 0 )  +1) AS max_No FROM g4_popup ";
	$row = sql_fetch($sql);

	$pop_no = $row[max_No];
}

//파일 올리기
$img1Nm = "";
$oimg1Nm = "";
if ($_FILES[img1][name]) {
	upload_afile($_FILES[img1][tmp_name], "popup_".$pop_no."_1", "$g4[path]/data/popupmng");
	//saveOneSmallImg($image, $no, "1", "golf");

	$img1Nm = "popup_".$pop_no."_1";
	$oimg1Nm = $_FILES[img1][name];

	$imgSize = getimagesize("$g4[path]/data/popupmng/popup_{$pop_no}_1");
}


// 파일을 업로드 함
function upload_afile($srcfile, $destfile, $dir)
{
	if ($destfile == "") return false;
    // 업로드 한후 , 퍼미션을 변경함
	@move_uploaded_file($srcfile, "$dir/$destfile");
	@chmod("$dir/$destfile", 0606);
	return true;
}

if($pop_width==0) $pop_width = $imgSize[0];
if($pop_height==0) $pop_height = $imgSize[1]+25;
if($pop_img_width==0) $pop_img_width = $imgSize[0];
if($pop_img_height==0) $pop_img_height = $imgSize[1];


$qstr = "page=$page&sort1=$sort1&sort2=$sort2";

if ($w == "")
{
	$iv = sql_fetch(" select * from g4_popup where pop_no = '$pop_no' ");
	if ($iv[pop_no])
		alert("등록된 자료가 있습니다.");

    $sql = " insert g4_popup
                set
					pop_no = '".$pop_no."',
					pop_nm = '$pop_nm',
					pop_type = '$pop_type',
					pop_image = '$img1Nm',
					pop_width = '$pop_width',
					pop_height = '$pop_height',
					pop_top = '$pop_top',
					pop_left = '$pop_left',
					pop_opt = '$pop_opt',
					pop_iscenter = '$pop_iscenter',
					pop_link = '$pop_link',
					pop_map = '$pop_map',
					pop_map_opt = '$pop_map_opt',
					pop_link_type = '$pop_link_type',
					pop_img_width_o = '{$imgSize[0]}',
					pop_img_height_o = '{$imgSize[1]}',
					pop_img_size = '$pop_img_size',
					pop_img_width = '$pop_img_width',
					pop_img_height = '$pop_img_height',
					pop_sdate = '$pop_sdate',
					pop_edate = '$pop_edate',
					is_mobile = 1,

					reg_dt = now()

					";
    sql_query($sql);

	
	goto_url("./pop_list_mobile.php?$qstr");

} else if ($w == "u") {
	$iv = sql_fetch(" select * from g4_popup where pop_no = '$pop_no' ");
	if (!$iv[pop_no])
		alert("등록된 자료가 없습니다.");

	if (!$_FILES[img1][name]) {
		if ($img1_del)  @unlink("$g4[path]/data/popupmng/popup_{$no}_1");
	}

    $sql = "update g4_popup
               set
					pop_nm = '$pop_nm',
					pop_type = '$pop_type',
					
					pop_width = '$pop_width',
					pop_height = '$pop_height',
					pop_top = '$pop_top',
					pop_left = '$pop_left',
					pop_opt = '$pop_opt',
					pop_iscenter = '$pop_iscenter',
					pop_link = '$pop_link',
					pop_map = '$pop_map',
					pop_map_opt = '$pop_map_opt',
					pop_link_type = '$pop_link_type',				
					pop_img_size = '$pop_img_size',
					pop_img_width = '$pop_img_width',
					pop_img_height = '$pop_img_height',
					pop_sdate = '$pop_sdate',
					pop_edate = '$pop_edate',
					is_mobile = 1,
	";

	if($img1Nm) { 
		$sql .= "
			pop_image = '$img1Nm',
			pop_img_width_o = '{$imgSize[0]}',
			pop_img_height_o = '{$imgSize[1]}',
		";
	}

	$sql .= "
					mod_dt = now()
             where pop_no = '$pop_no' ";
    sql_query($sql);

    goto_url("./pop_form_mobile.php?w=$w&no=$pop_no&$qstr");

} else if ($w == "d") {
	@unlink("$g4[path]/data/popupmng/popup_$no"."_1");

	$iv = sql_fetch(" select * from g4_popup where pop_no = '$no' ");
	if (!$iv[pop_no])
		alert("등록된 자료가 없습니다.");

    $sql = "delete from g4_popup where pop_no = '$no' ";
    sql_query($sql);

    goto_url("./pop_list_mobile.php?$qstr");
}
else
{
    alert();
}




?>

