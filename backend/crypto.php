<?php
	function Crypto($CryptoString, $CryptoKey, $action){
		
		$secret_key = $CryptoKey;
		$secret_iv = 'Xart1san*';
		$string=$CryptoString;
		
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$key = hash( 'sha256', $secret_key );
		$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
	 
		if( $action == 'encrypt' ) {
			$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, OPENSSL_RAW_DATA, $iv ) );
		}
		else if( $action == 'decrypt' ){
			
			$output = openssl_decrypt( base64_decode($string), $encrypt_method, $key, OPENSSL_RAW_DATA, $iv );
			
		}
	 
		return $output;

	}
	
?>


