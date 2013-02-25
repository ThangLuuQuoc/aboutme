<?php
	require ("includes/secure.php");
	require ("../includes/config.php");
	require ("../includes/class/application.class.php");
	
	$application = new Application();
		
	$titlePage = $messages["general_title_abus_configuration"];
	
	if (isset ($_POST['save']) && $_POST['save'] == 1) {		
		$data->chg_code = (int) fieldSecure($_POST['chg_code']);
		$data->chg_name = fieldSecure($_POST['chg_name']);
		$data->chg_name_e = fieldSecure($_POST['chg_name_e']);
		$data->chg_status = fieldSecure($_POST['chg_status']);
		$data->chg_order = ($charge->getMaxOrder() + 1);
		
		if ($data->chg_code == 0) {					/*agregar*/
			if ($charge->insertCharge($data)) {
				$_SESSION["message_value"] = replaceMessage($messages["charge_message_added"], array($data->chg_name));
				$_SESSION["message_show"] = 3;
			} else {
				$_SESSION["message_value"] = $messages["charge_message_errorAdding"];
				$_SESSION["message_show"] = 1;
			}
		} elseif ($data->chg_code > 0) {			/*actualizar*/
			if ($charge->updateCharge($data)) {
				$_SESSION["message_value"] = replaceMessage($messages["charge_message_updated"], array($data->chg_name));
				$_SESSION["message_show"] = 3;
			} else {
				$_SESSION["message_value"] = $messages["charge_message_errorUpdating"];
				$_SESSION["message_show"] = 1;
			}
		}
		echo ("<script> window.location.href='listCharges.php'</script>");
	} elseif (isset($_GET["chg_code"]) && (int) $_GET["chg_code"] > 0) {
		$titlePage = $messages["general_title_personal_charge_update"];
		$chg_code = (int) $_GET["chg_code"];
		$data = $charge->getCharge($chg_code);
		
		$chg_code = $data->chg_code;
		$chg_name = $data->chg_name;
		$chg_name_e = $data->chg_name_e;
		$chg_status = $data->chg_status;
	}
?>