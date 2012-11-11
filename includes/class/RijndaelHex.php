<?php

/**
 * class RijndaelHex
 * Clase encriptadora Rijndael.
 */
class RijndaelHex {
	var $mykey = "umaster";
	var $myconst = "@l@7@f@j@";

   /**
   * Constructor de clase.
   *
   * @param char clave Clave que ser empleada como llave. Por defecto se emplea la palabra "clave".
   * @return RijndaelHex
   * @access public
   */
  public function __construct($clave=false) {
    if(!$clave) {
      $this->mykey="master";
    } else {
      $this->mykey=$clave;
    }
    while(strlen($this->mykey)<24) {
      $this->mykey.=chr(0);
    }
  }

  /**
   * Encripta un texto segun la llave.
   *
   * @param char text Texto que sera encriptado.
   * @return char
   * @access public
   */
	public function linencrypt($text) {
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB); //get vector size on ECB mode
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND); //Creating the vector
		$cryptedpass = mcrypt_encrypt (MCRYPT_RIJNDAEL_128, $this->mykey, $text, MCRYPT_MODE_ECB, $iv); //Encrypting using MCRYPT_RIJNDAEL_128 algorithm
	return $cryptedpass;
	}

  /**
   * Encripta un texto según la llave. El resultado se entrega en forma hexadecimal (0a1fe7...).
   *
   * @param char text Texto que sera encriptado.
   * @return char
   * @access public
   */
	public function linencrypthex($text) {
		$cryptedpass = $this->linencrypt($text);
    $text_hex="";
    for($i=0;$i<strlen($cryptedpass);$i++) {
      $char=dechex(ord($cryptedpass[$i]));
      if(strlen($char)==1)
        $text_hex.="0";
      $text_hex.=$char;
    }
    return $text_hex;
	}

  /**
   * Desencripta un texto según la llave.
   *
   * @param char text Texto que sera desencriptado.
   * @return char
   * @access public
   */
	public function lindecrypt($enpass) {
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decryptedpass = mcrypt_decrypt (MCRYPT_RIJNDAEL_128, $this->mykey, $enpass, MCRYPT_MODE_ECB, $iv); //Decrypting...
	return rtrim($decryptedpass);
	}

  /**
   * Desencripta un texto según la llave. El texto debe ser una cadena con los datos en forma hexadecimal (0a1fe7...).
   *
   * @param char text Texto que sera desencriptado.  Debe estar en formato hexadecimal (0a1fe7...).
   * @return char
   * @access public
   */
	public function lindecrypthex($enpass) 
	{
		$rec_str="";
		
		if(strlen($enpass)%2==1)
			$enpass .= 'z';
			
	    for($i=0;$i<strlen($enpass);$i+=2)
	    {
	      $rec_str.=chr(hexdec($enpass[$i].$enpass[$i+1]));
	    }
    	return $this->lindecrypt($rec_str);
	}
	
  /**
   * Encripta un texto 2 veces, convinandolo en el segundo nivel con una constante y otra cadena. 
   * El resultado se entrega en forma hexadecimal (0a1fe7...).
   *
   * @param char text Texto que sera encriptado en el primer y segundo nivel.
   * @param char text2 Texto que sera encriptado en el segundo nivel.
   * @return char
   * @access public
   */
	public function linencrypthexComplex($text, $text2) 
	{
		$encryp = $this->linencrypthex($text);

		$encryp = $this->linencrypthex($encryp.$this->myconst.$text2);
		
		return $encryp;
	}

  /**
   * Desencripta un texto que ha sido encriptado 2 veces.
   * El resultado se entrega en forma hexadecimal (0a1fe7...).
   *
   * @param char text Texto que sera desencriptado.
   * @return char
   * @access public
   */
	public function lindecrypthexComplex($text) 
	{
		$decrypt = $this->lindecrypthex($text);
		$pieces = explode($this->myconst, $decrypt);

		$decrypt = $this->lindecrypthex($pieces[0]);
		
		return $decrypt;
	}

}
?>