<?php
	//header('Content-Type: text/html; charset=UTF-8');	
	
	if (!empty ($_SESSION['message_value']) && !empty ($_SESSION['message_show'])) {
		$messageValue = $_SESSION['message_value'];
		$messageShow = $_SESSION['message_show'];
	} else {
		$messageValue = "";
		$messageShow = "";
	}
	
		
	$_SESSION['message_value'] = "";
	$_SESSION['message_show'] = "";
	$_SESSION["lang_admin"] = "es";//idioma del admnin.	
	
	$messages = getLanguage($_SESSION["lang_admin"], ADMIN);
	
	if (is_null ($messages)) {
		Application :: showApplicationError(); // no se pudo cargar un lenguaje para el admon
	}

	if (!isset ($_SESSION["lang"])) {
		$_SESSION["lang"] = 'es';
	}
	$lang = $_SESSION["lang"];
	$messages_p = getLanguage($_SESSION["lang"], PUBLIC_);
	
	/**
	*	Función responsable de hacer hacerle un check de seguridad a una cadena, el proceso consiste en trim, strip_tags, myreal_scape_string
	*	@parameters field: campo a analizar
	*				aplyTrim: para hacerle trim a la cadena por parametro.
	*				aplyMyRealScapeString: para remover palabras reservadas de mysql q puedan ser un ataque
	*				aplyStripTags: para los ataques cross site.
	*	@return cadena con la seguridad aplicada.
	*/
	function fieldSecure($field, $aplyTrim=true, $aplyMyRealScapeString=true, $aplyStripTags=true) {
		if (is_array($field)) {
			foreach ($field as $var=>$val) {
				$output[$var] = fieldSecure($val, $aplyTrim, $aplyMyRealScapeString, $aplyStripTags);
			}
		} else {
			$field = str_replace ("'", "", $field);	 
			$field = str_replace ('"', '', $field);
			
			if ($aplyTrim) {
				$field = trim ($field);
			}
			
			if ($aplyMyRealScapeString) {
				$field = mysql_real_escape_string ($field);
			}
			
			if ($aplyStripTags) {
				$field = cleanInput($field);
				$field = strip_tags ($field);
				if (get_magic_quotes_gpc()) {
					$field = stripslashes($field);
				}
			}			
		}
		
		return $field;
	}

	function cleanInput($input) {
		$search = array(
			'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
			'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
			'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
			'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
		);

		$output = preg_replace($search, '', $input);
		return $output;
	}
	

	/**
	*	Función responsable de obtener el lenguaje que se usará en la app para los visitantes.
	*	@parameter lang: lenguaje a mostrar en la app.
	*	@return array, array con el idioma cargado para mostrar en la app.
	*/
	function getLanguage($lang = 'es', $loadBy) {
		$fileLanguage = 'abus_language.es.php';
		$abusLanguage = NULL;

		if ($lang == "es") {
			$fileLanguage = 'abus_language.es.php';
		} elseif ($lang == "en") {
			$fileLanguage = 'abus_language.en.php';
		}
		
		$abusLanguage = PATH_LANGUAGE_FILE . $loadBy . '/' . $fileLanguage;
		include($abusLanguage);

		return $abusLanguage;
	}

	
	/**
	*	Función reponsable de reemplazar en un mensaje los valores dinamicos 
	*	del mismo. Ej: con los parámetros: 
	*							$message="hola {0} hoy es {1}", 
	*							$args=array("mundo", "lunes") 
	*			   retorna: 
	*							"hola mundo hoy es lunes"
	*	@parameters message: mensaje a ser modificado.
	*				args: array de valores para reemplazar en el mensaje.
	*	@return String, mensaje con los valores reemplazados.
	*/
	function replaceMessage($message, $args=array()) {
		$amountItems = count ($args);
		for ($i=0; $i < $amountItems; $i++) {
			$message = str_replace("{".$i."}", $args[$i], $message);
		}		
		return $message;
	}
	
	
	/**
	*	Función responsable de convertir una fecha a otro formato.
	*  	tipe = 1: yyyy-mm-dd => dd/mm/yyyy. desde el modelo a la vista
	*  	tipe = 2: dd/mm/yyyy => yyyy-mm-dd. desde la vista al modelo.
	*  	tipe = 3: yyyy-mm-dd => mm/dd/yyyy. desde el modelo a la vista, formato inglés.
	*  	tipe = 4: mm/dd/yyyy => yyyy-mm-dd. desde la vista al modelo, formato inglés.
	*/	
	function changeFormatDate($date, $type, $isDatatime = false, $getTime = true) {
		$hour = "";
		
		if (empty($date)) {
			return "";	
		}
		
		if ($isDatatime) {			
			$hour = substr($date, 10,19);
			$date = substr($date, 0,10);
		} else {
			$getTime = false;	
		}
		
		$date = trim ($date);
		
		switch($type) {
			case 1: $aux = explode('-', $date);
				$dateFormat = $aux[2]."/".$aux[1]."/".$aux[0];
			break;
			case 2:	$aux = explode('/', $date);
				$dateFormat = $aux[2]."-".$aux[1]."-".$aux[0];
			break;
			case 3: $aux = explode('-', $date);
				$dateFormat = $aux[1]."/".$aux[2]."/".$aux[0];
			break;
			case 4:	$aux = explode('/', $date);
				$dateFormat = $aux[2]."-".$aux[0]."-".$aux[1];
			break;
		}
		
		if ($getTime) {
			return $dateFormat.' '.$hour;
		} else {
			return $dateFormat;	
		}
	}
	
	/**
	*	Trunca un texto largo para cuando se necesita solo una parte
	* 	@param $string Texto que va a ser truncado
	* 	@param $length Este determina para cuantos car�cteres truncar.
	* 	@param $etc Este es el texto para adicionar si el truncamiento ocurre. La longitud NO se incluye para la logitud del truncamiento
	* 	@param $break_words Este determina cuando truncar o no o al final de una palabra(false), o un car�cter 	exacto(true).
	* 	@param $middle Este determina cuando ocurre el truncamiento al final de la cadena(false), o en el centro de la 	
	*				cadena(true). Nota cuando este es true, entonces la palabra limite es ignorada.
	* 	@return String
	*/
	function truncate($string, $length = 80, $etc = '...',$break_words = false, $middle = false) {
	    if ($length == 0) {
	        return '';
		}
		
	    if (strlen ($string) > $length) {
	        $length -= strlen ($etc);
	        if (!$break_words && !$middle) {
	            $string = preg_replace ('/\s+?(\S+)?$/', '', substr ($string, 0, $length+1));
	        }
			
	        if(!$middle) {
	            return substr ($string, 0, $length).$etc;
	        } else {
	            return substr ($string, 0, $length/2) . $etc . substr($string, -$length/2);
	        }
	    } else {
	        return $string;
	    }
	}
		
	/**
	*	Funcion encargada de enviar los emails en la aplicación.
	*	@autor: JSL
	*	@date: 09 DIC 2011
	*/
	function sendApplicationEmail($data){
		include_once("phpmailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->IsHTML(true);
		
		$mail->Body = sendEmailSite($data->email_body);
		
		foreach($data->email_address as $address)
			$mail->AddAddress($address);
		
		for($i=0; $i < count($data->email_attachment); $i++) {
			$mail->AddAttachment($data->email_attachment[$i], $data->email_attachment_name[$i]);
		}
		
		if(isset($data->email_from) && $data->email_from != "")
			$mail->From = $data->email_from;		
		
		if(isset($data->email_fromName) && $data->email_fromName != "")
			$mail->FromName = $data->email_fromName;
		
		if(isset($data->email_sender) && $data->email_sender != "")
			$mail->sender = $data->email_sender;
		
		if(isset($data->email_subject) && $data->email_subject != "")		
			$mail->Subject = $data->email_subject;
		else
			$mail->Subject = "";
		
		return $mail->send();
	}
	
	/**
	*	Firma de la aplicacion
	*/
	function sendEmailSite($body){
		return '<div>'.$body.'</div><div>Signature site...</div>';
	}
	
	/**
	 * Función responsable de dar el formato necesario a un texto para que pueda ser utilizado en una URL semántica.
	 * @parameters $string: representa la cadena a la cuál se le dará formato.
	 * @return String, cadena con el formato necesario para la URL.
	 */
	function formatToUrl($string) {
		if ( @preg_match ('/.+/u', $string) ) {
			$string = utf8_decode ($string);
		}
	   
		$string = htmlentities ($string);
		$string = preg_replace ('/&([a-zA-Z])(uml|acute|grave|circ|tilde);/','$1',$string);
		$string = html_entity_decode ($string);
		$string = strtolower ($string);
		$string = str_replace ("Ã§","c",$string);
		$string = preg_replace ('@[ =()/\'\"\:\+\!\â€œ\â€�\â€˜\â€™\Â¡\Â¿\?\Âº\,\;\$\&\#\%\Â´\Â·\.\@\Â«\Â»]+@','_',trim($string));
		$string = preg_replace ('@[\W]+@','_',$string);
		$string = preg_replace ('@[-]*[^A-Za-z0-9._,]@','_',$string);
		$string = preg_replace ('@^[-]@','',$string);
		$string = preg_replace ('@([-])$@','',$string);
		
		$string = strtolower($string);
		
		return $string;
	}


	/**
	*	Funcion responsble de enviar un email.
	*/
	function sendEmailAbus($data){
		include_once("phpmailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->IsHTML(true);
		
		//if( isset($dataEmail->emailMU_signature) && $dataEmail->emailMU_signature == false)
			$mail->Body = $data->emailMU_body;
		//else
		//	$mail->Body = sendEmailSite($data->emailMU_body);
		
		foreach($data->emailMU_address as $address)
			$mail->AddAddress($address);
		
		if(isset($data->emailMU_from) && $data->emailMU_from != "")
			$mail->From = $data->emailMU_address;
		else
			$mail->From = EMAIL_FROM;
		
		if(isset($data->emailMU_fromName) && $data->emailMU_fromName != "")
			$mail->FromName = $data->emailMU_fromName;
		
		if(isset($data->emailMU_sender) && $data->emailMU_sender != "")
			$mail->sender = $data->emailMU_sender;
		else
			$mail->sender = "livethechanges@abus.co";
		
		if(isset($data->emailMU_subject) && $data->emailMU_subject != "")		
			$mail->Subject = $data->emailMU_subject;
		else
			$mail->Subject = "";
		
		return $mail->send();
	}
	
	/**
	*	Función responsable de obtener la url actual cuando se es llamada
	*	esta función
	*/
	function curPageURL() {
		$pageURL = 'http';
		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
			$pageURL .= "s";
		}
		
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}

	
