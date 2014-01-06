<?php
	if (isset ($_POST["save"]) && (int) $_POST["save"] == 2) {
		$aux = "../";
	} else {
		$aux = "";
	}
	
	require ($aux."includes/config.php");
	require ($aux."includes/class/contactus.class.php");
	$contactus = new ContactUs();
	$menu_code = 7;
	
	if ( isset ($_POST["save"]) && (int) $_POST["save"] > 0) {
		$save = (int) $_POST["save"];
		$data->contact_name = fieldSecure($_POST["contact_name"]);
		$data->contact_email = fieldSecure($_POST["contact_email"]);
		$data->contact_phone = fieldSecure($_POST["contact_phone"]);
		
		if (isset ($_POST["contact_city"])) {
			$data->contact_city = fieldSecure($_POST["contact_city"]);
		} else {
			$data->contact_city = "";
		}
		
		$data->contact_text = fieldSecure($_POST["contact_text"]);
		
		/* email */
		$spaces = '   ';
		$htmlEnter = '<br />';

		$bodyEmail = $spaces . $htmlEnter .'Nueva pregunta / inquietud:' .$htmlEnter . $htmlEnter;
		$bodyEmail .= $spaces . '<b>Nombre: </b>' . $data->contact_name . $htmlEnter;
		$bodyEmail .= $spaces . '<b>Correo electronico: </b>' . $data->contact_email . $htmlEnter;
		$bodyEmail .= $spaces . '<b>Telefono: </b>' . $data->contact_phone . $htmlEnter;
		$bodyEmail .= $spaces . '<b>Pais / Estado / Ciudad: </b>' . $data->contact_city . $htmlEnter;
		$bodyEmail .= $spaces . '<b>Preguntas / inquietudes: </b>' . str_replace("\r\n", "\n", $data->contact_text) . $htmlEnter;

		$dataEmail->emailMU_body = $bodyEmail;
		$dataEmail->emailMU_address[0] = EMAIL_TO;
		$dataEmail->emailMU_subject = 'Pregunta / Inquietud ' . $_SERVER["SERVER_NAME"];

		$dataEmail->emailMU_signature = false;
		$dataEmail->email_from = EMAIL_FROM;
		$dataEmail->emailMU_fromName = SITE_NAME;
		sendEmailAbus($dataEmail);
		/* email */
		if ($contactus->insertContactUs($data)) {
			if ($save == 1) {
				$_SESSION["message_value"] = $messages_p["general_info_send"];
				$_SESSION["message_show"] = 3;
				echo ("<script> window.location.href = '/".$_SESSION["lang"]."' </script>");
			} else {
				echo 1;	
			}
		} else {
			if ($save == 1) {
				$_SESSION["message_value"] = $messages_p["general_error_send"];
				$_SESSION["message_show"] = 1;
				echo ("<script> window.location.href = '/".$_SESSION["lang"]."' </script>");
			} else {
				echo 0;	
			}
		}		
	}
?>