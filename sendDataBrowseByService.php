<?php
	require ("includes/config.php");
	$result = '0';

	// se obtiene la info y se envía un email
	if ((isset($_POST['brow_serv_order_nro']) && !empty($_POST['brow_serv_order_nro']))
			&& (isset($_POST['brow_serv_email']) && !empty($_POST['brow_serv_email']))) {
		$brow_serv_order_nro = $_POST['brow_serv_order_nro'];
		$brow_serv_email = $_POST['brow_serv_email'];
		$brow_serv_comment = $_POST['brow_serv_comment'];

		$spaces = '   ';
		$htmlEnter = '<br />';

		$bodyEmail = $spaces . $htmlEnter .'<b>Consulta orden de servicio</b>' .$htmlEnter . $htmlEnter;
		$bodyEmail .= $spaces . '<b>Orden Nro: </b>' . $brow_serv_order_nro . $htmlEnter;
		$bodyEmail .= $spaces . '<b>Correo electronico: </b>' . $brow_serv_email . $htmlEnter;
		$bodyEmail .= $spaces . '<b>Comentario: </b>' . $brow_serv_comment . $htmlEnter;

		$dataEmail->emailMU_body = $bodyEmail;
		$dataEmail->emailMU_address[0] = EMAIL_TO;
		$dataEmail->emailMU_subject = 'Consulta orden de servicio ' . URL;

		$dataEmail->emailMU_signature = false;
		$dataEmail->email_from = EMAIL_FROM;
		$dataEmail->emailMU_fromName = SITE_NAME;
		if (sendEmailAbus($dataEmail)) {
			$result = '1';
		}
	}

	echo $result;