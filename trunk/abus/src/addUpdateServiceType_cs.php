<?php
	require ("includes/secure.php");
	require ("../includes/config.php");
	require ("../includes/class/serviceType.class.php");
	
	$serviceType = new ServiceType();
	
	$sertype_code = "";
	$sertype_name = "";
	$sertype_name_e = "";
	$sertype_status = "";
	
	$titlePage = $messages["general_title_services_type_add"];
	
	if (isset ($_POST['save']) && $_POST['save'] == 1) {		
		$data->sertype_code = (int) fieldSecure($_POST['sertype_code']);
		$data->sertype_name = fieldSecure($_POST['sertype_name']);
		$data->sertype_name_e = fieldSecure($_POST['sertype_name_e']);
		$data->sertype_status = fieldSecure($_POST['sertype_status']);
		$data->sertype_order = ($serviceType->getMaxOrder() + 1);
		
		if ($data->sertype_code == 0) {					/*agregar*/
			if ($serviceType->insertServiceType($data)) {
				$_SESSION["messageValue"] = replaceMessage($messages["service_type_message_added"], array($data->sertype_name));
				$_SESSION["messageShow "] = 3;
			} else {
				$_SESSION["messageValue"] = $messages["service_type_message_errorAdding"];
				$_SESSION["messageShow "] = 1;
			}
		} elseif ($data->sertype_code > 0) {			/*actualizar*/
			if ($serviceType->updateServiceType($data)) {
				$_SESSION["messageValue"] = replaceMessage($messages["service_type_message_updated"], array($data->sertype_name));
				$_SESSION["messageShow "] = 3;
			} else {
				$_SESSION["messageValue"] = $messages["service_type_message_errorUpdating"];
				$_SESSION["messageShow "] = 1;
			}
		}
		echo ("<script> window.location.href='listServicesType.php'</script>");
	} elseif (isset($_GET["sertype_code"]) && (int) $_GET["sertype_code"] > 0) {
		$titlePage = $messages["general_title_services_type_update"];
		$sertype_code = (int) $_GET["sertype_code"];
		$data = $serviceType->getServiceType($sertype_code);
		
		$sertype_code = $data->sertype_code;
		$sertype_name = $data->sertype_name;
		$sertype_name_e = $data->sertype_name_e;
		$sertype_status = $data->sertype_status;
	}
?>