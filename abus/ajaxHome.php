<?php
	require ("includes/secure.php");
	require ("../includes/config.php");
	require_once ("../includes/class/application.class.php");
	
	$application = new Application(); 
	
	if ( ! empty ($_POST['field']) && ! empty ($_POST['code']) && ! empty ($_POST['table'])) {
		$field = fieldSecure($_POST["field"]);
		$field_value = fieldSecure($_POST["field_value"]);
		$code = (int) fieldSecure($_POST["code"]);
		$table = fieldSecure($_POST["table"]);
		
		if ($table == 'menu') {
			if ($application->updateFieldMenu($field, $field_value, $code)) {
				echo '1';
			} else {
				echo '0';
			}
		} elseif ($table == 'general_app') {
			if ($application->updateInformationApp($field, $field_value, $code)) {
				if (($field == "app_background" || $field == "app_background_e") && (strlen($field_value) > 0)) {
					
					$copyImage = false;
					if (! empty ($field_value) && file_exists ("../file_upload/images_bank/".$field_value)) {
						$copyImage = copy ("../file_upload/images_bank/".$field_value, '../file_upload/background/'.$field_value);
					}
					
					if ($copyImage) {
						unlink ("../file_upload/images_bank/".$field_value);
						
						if (file_exists ("../file_upload/images_bank/thumb-".$field_value)) {
							$copyImage = copy ("../file_upload/images_bank/thumb-".$field_value, '../file_upload/background/thumb-'.$field_value);
							unlink ("../file_upload/images_bank/thumb-".$field_value);
						}
						
						if (!empty ($_POST[$field."_prev"])) {
							$unlink = false;
							$dataApp = $application->getInformationApp();
							
							if ($field == "app_background" && ($dataApp->app_background_e != $_POST[$field."_prev"])) {
								$unlink = true;
							} elseif ($field == "app_background_e" && ($dataApp->app_background != $_POST[$field."_prev"])) {
								$unlink = true;
							}
							
							if ($unlink) {
								if (file_exists ("../file_upload/background/".$_POST[$field."_prev"])) {
									unlink ("../file_upload/background/".$_POST[$field."_prev"]);
								}
								
								if (file_exists ("../file_upload/background/thumb-".$_POST[$field."_prev"])) {
									unlink ("../file_upload/background/thumb-".$_POST[$field."_prev"]);
								}
							}
						}
					}
					
					if ($copyImage || ($field == "app_background" && (isset ($_POST["flagSave"]) && $_POST["flagSave"])) || 
													($field == "app_background_e" && (isset ($_POST["flagSave_e"]) && $_POST["flagSave_e"]))) {
						echo '1';
					} else {
						echo '-1';
					}
					
				} elseif(! ($field == "app_background" || $field == "app_background_e")) {
					echo '1';
				}
			} else {
				echo '-3';
			}
		} else {
			echo '-4';
		}
	} else {
		echo '-5';
	}
?>