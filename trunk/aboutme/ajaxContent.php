<?php
	require ("includes/secure.php");
	require ("../includes/config.php");
	require ("../includes/class/content.class.php");
	$content = new Content();
		
	if( isset ($_POST["cont_code"]) && (int) $_POST["cont_code"] > 0 && isset ($_POST["cont_order"]) && count ($_POST) == 2){
		$cont_code = (int) $_POST["cont_code"];
		$cont_order = (int) $_POST["cont_order"];
		
		if ($content->updateOrder($cont_code, $cont_order)) {
			echo 1;
		} else {
			echo 0;
		}
	} elseif ((isset ($_POST["cont_code"]) && (int) $_POST["cont_code"] > 0) && (isset($_POST["cont_status"]) && (int) $_POST["cont_status"] > 0) && count($_POST) == 2) {
		$cont_code = (int) $_POST["cont_code"];
		$cont_status = (int) $_POST["cont_status"];
		
		if ($content->changeStatus($cont_code, $cont_status)) {
			echo 1;
		} else {
			echo 0;
		}
	} else {
		echo -1;
	}
?>