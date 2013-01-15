<?php
	require ("includes/secure.php");
	require ("../includes/config.php");
	require ("../includes/class/faq.class.php");
	
	$faq = new Faq();
		
	if (isset ($_POST["faq_code"]) && (int) $_POST["faq_code"] > 0 && isset ($_POST["faq_order"]) && count ($_POST) == 2){
		$faq_code = (int) $_POST["faq_code"];
		$faq_order = (int) $_POST["faq_order"];
		
		if ($faq->updateOrder($faq_code, $faq_order)) {
			echo 1;
		} else {
			echo 0;
		}
	} elseif ((isset ($_POST["faq_code"]) && (int) $_POST["faq_code"] > 0) && (isset($_POST["faq_status"]) && (int) $_POST["faq_status"] > 0) && count($_POST) == 2) {
		$faq_code = (int) $_POST["faq_code"];
		$faq_status = (int) $_POST["faq_status"];
		
		if ($faq->changeStatus($faq_code, $faq_status)) {
			echo 1;
		} else {
			echo 0;
		}
	} else {
		echo -1;
	}
?>