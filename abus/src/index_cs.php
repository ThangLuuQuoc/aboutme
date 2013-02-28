<?php
	require ("../includes/config.php");
	require ("../includes/class/user.class.php");
	
	$user = new User();
	$loginUsername = "";
	
	if (! isset ($_SESSION['intentosLog'])) {
		$_SESSION['intentosLog'] = 0;	
	}
		
	if ( !empty ($_POST['login']) && !empty ($_POST['password']) ) {
		require ("../includes/class/RijndaelHex.php");
		$rijndaelHex = new RijndaelHex();
		$loginUsername = $_SESSION['loginUsername'] = fieldSecure ($_POST['login']);
		$password =	$rijndaelHex->linencrypthex( $loginUsername.fieldSecure($_POST['password'], false).$loginUsername );		
		
		if (!isset ($_SESSION['intentosLog'])) {
			$_SESSION['intentosLog'] = 1;
		}
		if ($_SESSION['intentosLog'] >= 7) {
			if ($user->userExist($loginUsername)) {
				if ($user->userChangeStatus( $user->use_code, 3)) {
					$_SESSION['intentosLog'] = 1;
					$_SESSION["message_value"] .= replaceMessage($messages["user_message_action_bloqued"], array($user->use_login));
					$_SESSION["message_show"] = 3;
				}
			}
			else{
				$_SESSION["message_value"] .= $messages["general_incorrect_data"].'<br />';
				$_SESSION["message_show"] = 2;
			}
		} elseif ($_SESSION['intentosLog'] >= 4 && ($_POST['code'] != $_SESSION['codigoVal']) ){
			$_SESSION["message_value"] .= $messages["general_code_security_incorrect"].'<br />';
			$_SESSION["message_show"] = 2;
		} elseif ($user->validateAccount($loginUsername,$password) ) {
			if ($user->use_status == 1){
				unset ( $_SESSION['loginUsername'] );
				$_SESSION['intentosLog'] = 1;
				$_SESSION['statusSession'] = true;
				
				$_SESSION['use_code'] = $user->use_code;
				$_SESSION['use_name'] = $user->use_name;
				$_SESSION['use_lastname'] = $user->use_lastname;
				$_SESSION['use_email'] = $user->use_email;
				$_SESSION['use_login'] = $user->use_login;
				$_SESSION['use_status'] = $user->use_status;
				$_SESSION['use_date_create'] = $user->use_date_create;
				
				$_SESSION['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR']; 
				$_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
				
				echo ("<script> window.location.href = 'home.php'</script>");
			} elseif ($user->use_status == 2){
				$_SESSION["message_value"] .= replaceMessage($messages["user_message_inactive"], array ($user->use_login)).'<br />';
				$_SESSION["message_show"] = 3;
			} elseif ( $user->use_status == 'Blocked' ){
				$_SESSION["message_value"] .= replaceMessage($messages["user_message_bloqued"], array ($user->use_login)).'<br />';
				$_SESSION["message_show"] = 3;
			} else {
				$_SESSION["message_value"] .= $messages["general_incorrect_data"].'<br />';
				$_SESSION["message_show"] = 2;	
			}			
		} else {
			$_SESSION['intentosLog']++;
			$_SESSION["message_value"] .= $messages["general_incorrect_data"].'<br />';
			$_SESSION["message_show"] = 2;
		}		
	}
?>