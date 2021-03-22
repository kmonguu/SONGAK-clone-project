<?
class Utilstr {
	function Utilstr() {
	}
	
	//숫자를 한글로 변환
	static function getConvertNumberToKorean($_number)
	{
		// 0부터 9까지의 한글 배열
		$number_arr = array('','일','이','삼','사','오','육','칠','팔','구');
		// 천자리 이하 자리 수의 한글 배열
		$unit_arr1 = array('','십','백','천');
		// 만자리 이상 자리 수의 한글 배열
		$unit_arr2 = array('','만','억','조','경','해');
		// 결과 배열 초기화
		$result = array();
		// 인자값을 역순으로 배열한 후, 4자리 기준으로 나눔
		$reverse_arr = str_split(strrev($_number), 4);
		foreach($reverse_arr as $reverse_idx=>$reverse_number){
		// 1자리씩 나눔
		$convert_arr = str_split($reverse_number);
		$convert_idx = 0;
		foreach($convert_arr as $split_idx=>$split_number){
		// 해당 숫자가 0일 경우 처리되지 않음
		if(!empty($number_arr[$split_number])){ 
		// 0부터 9까지 한글 배열과 천자리 이하 자리 수의 한글 배열을 조합하여 글자 생성
		$result[$result_idx] = $number_arr[$split_number].$unit_arr1[$split_idx];
		// 반복문의 첫번째에서는 만자리 이상 자리 수의 한글 배열을 앞 전 배열에 연결하여 조합
		if(empty($convert_idx)) $result[$result_idx] .= $unit_arr2[$reverse_idx]; 
		++$convert_idx;
		}
		++$result_idx;
		}
		}
		// 배열 역순으로 재정렬 후 합침
		$result = implode('', array_reverse($result));
		// 결과 리턴
		return $result;
	}
}
?>