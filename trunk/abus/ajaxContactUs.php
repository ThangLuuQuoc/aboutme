<?php
	require ("includes/secure.php");
	require ("../includes/config.php");
	require ("../includes/class/contactus.class.php");
	
	$contactUs = new ContactUs();
		
	if (isset ($_POST["contact_code"]) && (int) $_POST["contact_code"] > 0 && count ($_POST) == 2) {
		$response = 0;
		$data->contact_code = (int) $_POST["contact_code"];
		$data->use_code = (int) $_SESSION["use_code"];
		$data->contact_status = 2;//respuesto
		
		$flagSecure = false;

		$dataContactUs = $contactUs->getContactUs($data->contact_code);

		if (!empty ($_POST["contact_answer"]) && !empty($dataContactUs)) {
			$data->contact_answer = fieldSecure ($_POST["contact_answer"]);
			$data->contact_status = 2;//respuesto

			// se envía en correo
			/* email */
			$spaces = '   ';
			$htmlEnter = '<br />';

			$bodyEmail = $spaces . $htmlEnter .'Respuesta a su pregunta / inquietud:' .$htmlEnter . $htmlEnter;
			$bodyEmail .= $spaces . '<b>Nombre: </b>' . $dataContactUs->contact_name . $htmlEnter;
			$bodyEmail .= $spaces . '<b>Correo electronico: </b>' . $dataContactUs->contact_email . $htmlEnter;
			$bodyEmail .= $spaces . '<b>Telefono: </b>' . $dataContactUs->contact_phone . $htmlEnter;
			$bodyEmail .= $spaces . '<b>Pais / Estado / Ciudad: </b>' . $dataContactUs->contact_city . $htmlEnter;
			$bodyEmail .= $spaces . '<b>Preguntas / inquietudes: </b>' . $dataContactUs->contact_text . $htmlEnter;
			$bodyEmail .= $spaces . '<b>Respuesta: </b>' . $data->contact_answer . $htmlEnter;

			$dataEmail->emailMU_body = $bodyEmail;
			$dataEmail->emailMU_address[0] = $dataContactUs->contact_email;
			$dataEmail->emailMU_subject = 'Respuesta a su Pregunta / Inquietud ' . $_SERVER["SERVER_NAME"];

			$dataEmail->emailMU_signature = false;
			$dataEmail->email_from = EMAIL_FROM;
			$dataEmail->emailMU_fromName = SITE_NAME;
			
			if (sendEmailAbus($dataEmail)) {
				$flagSecure = true;				
			}
			/* email */
		} elseif (!empty ($_POST["contact_status"]) && ((int) $_POST["contact_status"] > 0)) {
			$data->contact_answer = "";
			$data->contact_status = (int) $_POST["contact_status"];
			$flagSecure = true;
		}
		
		if ($flagSecure && $contactUs->isValid($data->contact_code)) {			
			if ($contactUs->updateContactUs($data)) {
				$response = 1;
			}
		}			
		
		echo $response;
	} else {
		echo -1;
	}
?>