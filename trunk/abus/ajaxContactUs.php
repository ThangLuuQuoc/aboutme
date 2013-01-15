<?php
	require ("includes/secure.php");
	require ("../includes/config.php");
	require ("../includes/class/contactus.class.php");
	
	$contactUs = new ContactUs();
		
	if (isset ($_POST["contact_code"]) && (int) $_POST["contact_code"] > 0 && count ($_POST) == 2) {
		$response = 0;
		$data->contact_code = (int) $_POST["contact_code"];
		$data->use_code = (int) $_SESSION["use_code"];
		$data->contact_status = 2;//respuesto
		
		$flagSecure = false;
		if (!empty ($_POST["contact_answer"])) {
			$data->contact_answer = fieldSecure ($_POST["contact_answer"]);
			$data->contact_status = 2;//respuesto
			$flagSecure = true;
		} elseif (!empty ($_POST["contact_status"]) && ((int) $_POST["contact_status"] > 0)) {
			$data->contact_answer = "";
			$data->contact_status = (int) $_POST["contact_status"];
			$flagSecure = true;
		}
		
		if ($flagSecure && $contactUs->isValid($data->contact_code)) {			
			if ($contactUs->updateContactUs($data)) {
				$response = 1;
			}
		}			
		
		echo $response;
	} else {
		echo -1;
	}
?>