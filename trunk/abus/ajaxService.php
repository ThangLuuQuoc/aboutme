<?php
	require ("includes/secure.php");
	require ("../includes/config.php");
	require ("../includes/class/service.class.php");
	
	$service = new Service();
	
	if (isset ($_POST["serv_code"]) && (int) $_POST["serv_code"] > 0 && isset ($_POST["serv_order"]) && count ($_POST) == 2){
		$serv_code = (int) $_POST["serv_code"];
		$serv_order = (int) $_POST["serv_order"];
		
		if ($service->updateOrder($serv_code, $serv_order)) {
			echo 1;
		} else {
			echo 0;
		}
	} elseif ((isset ($_POST["serv_code"]) && (int) $_POST["serv_code"] > 0) && (isset($_POST["serv_status"]) && (int) $_POST["serv_status"] > 0) && 
			count($_POST) == 2) {
		$serv_code = (int) $_POST["serv_code"];
		$serv_status = (int) $_POST["serv_status"];
		
		if ($service->changeStatus($serv_code, $serv_status)) {
			echo 1;
		} else {
			echo 0;
		}
	} elseif ((isset ($_POST["serv_code"]) && (int) $_POST["serv_code"] > 0) && (isset($_POST["serv_highlight"]) && ((int) $_POST["serv_highlight"] == 0 || (int) $_POST["serv_highlight"] == 1)) && count($_POST) == 2) {
		$serv_code = (int) $_POST["serv_code"];
		$serv_highlight = (int) $_POST["serv_highlight"];
		
		if ($service->highlightService($serv_code, $serv_highlight)) {
			echo 1;
		} else {
			echo 0;
		}
	} else {
		echo -1;
	}
?>