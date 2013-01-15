<?php
	require ("includes/secure.php");
	require ("../includes/config.php");
	require ("../includes/class/charge.class.php");
	
	$charge = new Charge();
	
	if (isset ($_POST["chg_code"]) && (int) $_POST["chg_code"] > 0 && isset ($_POST["chg_order"]) && count ($_POST) == 2){
		$chg_code = (int) $_POST["chg_code"];
		$chg_order = (int) $_POST["chg_order"];
		
		if ($charge->updateOrder($chg_code, $chg_order)) {
			echo 1;
		} else {
			echo 0;
		}
	} elseif ((isset ($_POST["chg_code"]) && (int) $_POST["chg_code"] > 0) && (isset($_POST["chg_status"]) && (int) $_POST["chg_status"] > 0) && 
			count($_POST) == 2) {
		$chg_code = (int) $_POST["chg_code"];
		$chg_status = (int) $_POST["chg_status"];
		
		$flagSecure = false;
		if ($chg_status == 3) {//validar que el cargo no tenga personal asociado
			if ($charge->validateRemove($chg_code) == 0) {
				$flagSecure = true;	
			}
		} else {
			$flagSecure = true;	
		}
		
		if ($flagSecure && $charge->changeStatus($chg_code, $chg_status)) {
			echo 1;
		} else {
			echo 0;
		}
	} else {
		echo -1;
	}
?>