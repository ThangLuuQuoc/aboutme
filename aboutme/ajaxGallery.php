<?php
	require ("includes/secure.php");
	require ("../includes/config.php");
	require ("../includes/class/gallery.class.php");
	
	$gallery = new Gallery();
		
	if (isset ($_POST["gall_code"]) && (int) $_POST["gall_code"] > 0 && isset ($_POST["gall_order"]) && count ($_POST) == 2){
		$gall_code = (int) $_POST["gall_code"];
		$gall_order = (int) $_POST["gall_order"];
		
		if ($gallery->updateOrder($gall_code, $gall_order)) {
			echo 1;
		} else {
			echo 0;
		}
	} elseif ((isset ($_POST["gall_code"]) && (int) $_POST["gall_code"] > 0) && (isset($_POST["gall_status"]) && (int) $_POST["gall_status"] > 0) && count($_POST) == 2) {
		$gall_code = (int) $_POST["gall_code"];
		$gall_status = (int) $_POST["gall_status"];
		
		if ($gallery->changeStatus($gall_code, $gall_status)) {
			echo 1;
		} else {
			echo 0;
		}
	} else {
		echo -1;
	}
?>