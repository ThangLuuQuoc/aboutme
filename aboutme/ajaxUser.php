<?php
	require ("includes/secure.php");
	require ("../includes/config.php");
	require ("../includes/class/user.class.php");
	
	$user = new User(); 
		
	if ( isset ($_POST['use_login']) && $_POST['use_login'] != ''){		
		$use_login = trim ($_POST['use_login']);
		
		if ($user->userExist($use_login)) {
			echo replaceMessage($messages["validationUser_userInvalid"], array ($use_login));
		} else {
			echo 1;
		}
	} elseif ((isset ($_POST['use_code']) && (int) $_POST['use_code'] > 0) && (int) $_POST["use_status"] > 0){
		$use_code = (int) $_POST['use_code'];
		$use_status = (int) $_POST['use_status'];
		
		if ($user->changeStatusUser($use_code, $use_status)) {
			echo 1;
		} else {
			echo 0;
		}
	} else {
		echo -1;
	}
?>