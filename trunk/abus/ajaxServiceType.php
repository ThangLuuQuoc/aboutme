<?php
	require ("includes/secure.php");
	require ("../includes/config.php");
	require ("../includes/class/serviceType.class.php");
	
	$serviceType = new ServiceType();
	
	if (isset ($_POST["sertype_code"]) && (int) $_POST["sertype_code"] > 0 && isset ($_POST["sertype_order"]) && count ($_POST) == 2){
		$sertype_code = (int) $_POST["sertype_code"];
		$sertype_order = (int) $_POST["sertype_order"];
		
		if ($serviceType->updateOrder($sertype_code, $sertype_order)) {
			echo 1;
		} else {
			echo 0;
		}
	} elseif ((isset ($_POST["sertype_code"]) && (int) $_POST["sertype_code"] > 0) && (isset($_POST["sertype_status"]) && (int) $_POST["sertype_status"] > 0) && 
			count($_POST) == 2) {
		$sertype_code = (int) $_POST["sertype_code"];
		$sertype_status = (int) $_POST["sertype_status"];
		
		$flagSecure = false;
		if ($sertype_status == 3) {//validar que el tipo de servicio no tenga ningun servicio activo o inactivo.
			if ($serviceType->validateRemove($sertype_code) == 0) {
				$flagSecure = true;	
			}
		} else {
			$flagSecure = true;	
		}
		
		if ($flagSecure && $serviceType->changeStatus($sertype_code, $sertype_status)) {
			echo 1;
		} else {
			echo 0;
		}
	} else {
		echo -1;
	}
?>