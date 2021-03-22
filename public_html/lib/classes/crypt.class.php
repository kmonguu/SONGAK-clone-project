<?
// 암호화 복호화 관련 클래스
class Crypt {
	private $iv = 'c2ee9328473acb39'; // Same as in JAVA
	private $key = '139alvcm29x391bc'; // Same as in JAVA
	function __construct() {
	}
	function encrypt($str) {
		
		// $key = $this->hex2bin($key);
		$str = $this->padString ( $str );
		$iv = $this->iv;
		
		$td = mcrypt_module_open ( 'rijndael-128', '', 'cbc', $iv );
		
		mcrypt_generic_init ( $td, $this->key, $iv );
		$encrypted = mcrypt_generic ( $td, $str );
		
		mcrypt_generic_deinit ( $td );
		mcrypt_module_close ( $td );
		
		return bin2hex ( $encrypted );
	}
	function decrypt($code) {
		// $key = $this->hex2bin($key);
		$code = $this->hex2bin ( $code );
		$iv = $this->iv;
		
		$td = mcrypt_module_open ( 'rijndael-128', '', 'cbc', $iv );
		
		mcrypt_generic_init ( $td, $this->key, $iv );
		$decrypted = mdecrypt_generic ( $td, $code );
		
		mcrypt_generic_deinit ( $td );
		mcrypt_module_close ( $td );
		
		return utf8_encode ( trim ( $decrypted ) );
	}
	protected function hex2bin($hexdata) {
		$bindata = '';
		
		for($i = 0; $i < strlen ( $hexdata ); $i += 2) {
			$bindata .= chr ( hexdec ( substr ( $hexdata, $i, 2 ) ) );
		}
		
		return $bindata;
	}
	function padString($str) {
		$paddingStr = ' ';
		$size = 16;
		$x = strlen ( $str ) % $size;
		$plen = $size - $x;
		for($idx = 0; $idx < $plen; $idx ++) {
			$str .= $paddingStr;
		}
		
		return $str;
	}
}
?>