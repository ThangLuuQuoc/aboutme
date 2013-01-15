<?php
	require ("includes/secure.php");
	require ("../includes/config.php");
	require ("../includes/class/slider.class.php");
	$slider = new Slider();
		
	if( isset ($_POST["slid_code"]) && (int) $_POST["slid_code"] > 0 && isset ($_POST["slid_order"]) && count ($_POST) == 2){
		$slid_code = (int) $_POST["slid_code"];
		$slid_order = (int) $_POST["slid_order"];
		
		if ($slider->updateOrderItemSlider($slid_code, $slid_order)) {
			echo 1;
		} else {
			echo 0;
		}
	} elseif ((isset ($_POST["slid_code"]) && (int) $_POST["slid_code"] > 0) && (isset($_POST["slid_status"]) && (int) $_POST["slid_status"] > 0) && count($_POST) == 2) {
		$slid_code = (int) $_POST["slid_code"];
		$slid_status = (int) $_POST["slid_status"];
		
		if ($slider->changeStatusItemSlider($slid_code, $slid_status)) {
			echo 1;
		} else {
			echo 0;
		}
	} else {
		echo -1;
	}
?>