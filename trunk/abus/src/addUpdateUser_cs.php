<?php
	if (!(isset($_GET["key"]) && $_GET["key"] == date ("YmddmY"))) {
		//require ("includes/secure.php");
	}
	require ("../includes/config.php");
	require ("../includes/class/user.class.php");
	require ("../includes/class/RijndaelHex.php");
			
	$user = new User();
	$rijndaelHex = new RijndaelHex();
	
	$use_code = "";
	$use_name = "";
	$use_lastname = "";
	$use_email = "";
	$use_login = "";
	
	$titlePage = $messages["general_title_users_add"];
	if (isset ($_POST['save']) && $_POST['save'] == 1) {
		$data->use_code = (int) fieldSecure($_POST['use_code']);		
		$data->use_name = fieldSecure($_POST['use_name']);
		$data->use_lastname = fieldSecure($_POST['use_lastname']);
		$data->use_email = fieldSecure($_POST['use_email']);
		$data->use_login = fieldSecure($_POST['use_login']);
		$data->use_password = $rijndaelHex->linencrypthex( $data->use_login.fieldSecure($_POST['use_password'], false).$data->use_login );
		if ($data->use_code == 0) {					/*agregar usuario*/
			if ($user->addUser($data)) {
				$_SESSION["message_value"] = replaceMessage($messages["user_message_addedUser"], array($data->use_login));
				$_SESSION["message_show"] = 3;
			} else {
				$_SESSION["message_value"] = $messages["user_message_errorAdding"];
				$_SESSION["message_show"] = 1;
			}
		} elseif ($data->use_code > 0) {			/*actualizar usuario*/
			if ($user->updateUser($data)) {
				$_SESSION["message_value"] = replaceMessage($messages["user_message_updatedUser"], array($data->use_login));
				$_SESSION["message_show"] = 3;
			} else {
				$_SESSION["message_value"] = $messages["user_message_errorUpdating"];
				$_SESSION["message_show"] = 1;
			}
		}
		echo ("<script> window.location.href='listUser.php'</script>");
	} elseif (isset($_GET["use_code"]) && (int) $_GET["use_code"] > 0) {
		$titlePage = $messages["general_title_users_update"];
		$use_code = (int) $_GET["use_code"];
		$data = $user->getUser($use_code);
		
		$use_name = $data->use_name;
		$use_lastname = $data->use_lastname;
		$use_email = $data->use_email;
		$use_login = $data->use_login;		
	}
?>